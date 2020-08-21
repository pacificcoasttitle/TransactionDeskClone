<?php

(defined('BASEPATH')) OR exit('No direct script access allowed');

class Dashboard extends MX_Controller {

	function __construct() {
        parent::__construct();
		$this->load->helper(
            array('file', 'url','form')
        );
        $this->load->library('session');
		$this->load->library('form_validation');
		$this->load->model('order/orderRecording');
		$this->load->library('order/order');
        $this->load->model('order/apiLogs');
        $this->load->model('order/reviewPrelimData');
		$this->load->model('order/titleOfficer');
		$this->load->model('order/home_model');
		$this->load->model('order/fees_model');
		$this->order->is_user();
	}
	
	
	function index()
	{
		$userdata = $this->session->userdata('user');
		$name = isset($userdata['name']) && !empty($userdata['name']) ? $userdata['name'] : '';
		$is_master = isset($userdata['is_master']) && !empty($userdata['is_master']) ? $userdata['is_master'] : '';
		$data['name'] = $name;
		$data['is_master'] = $is_master;
		$data['is_special_lender'] = $userdata['is_special_lender'] == 1 ? 1 : 0;
		$data['order_lists'] = $this->order->get_recent_orders();
		$data['title'] = 'Smart Dashboard | Pacific Coast Title Company';
		$this->load->view('layout/head_dashboard',$data);
		$this->load->view('order/dashboard');
	}


    function prelimFiles()
    {
		$data['title'] = 'Smart Dashboard | Pacific Coast Title Company';
		$this->load->view('layout/head_dashboard',$data);
		$this->load->view('order/review_files');
    }

    function getFiles()
    {
		$data['title'] = 'Smart Dashboard | Pacific Coast Title Company';
		$this->load->view('layout/head_dashboard',$data);
		$this->load->view('order/dashboard');
    }

    function recordings()
    {
		$data['title'] = 'Smart Dashboard | Pacific Coast Title Company';
		$this->load->view('layout/head_dashboard',$data);
		$this->load->view('order/recordings');
	}
	
	function get_recordings()
    {
		$this->db->select('*');
        $this->db->from('pct_order_recordings_monthly_sync');	
		$this->db->where('month', date('Ym'));
		$this->db->order_by("day", "desc");
		$this->db->where('is_sync',  1);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
			$syncData = $query->result_array();
			if ($syncData[0]['day'] == date('d')) {
				$this->get_recordings_from_api(date("Y-m-d"));
			} else {
				$day = $syncData[0]['day'];
				$begin = new DateTime(date("Y-m-$day"));
				$end = new DateTime(date('Y-m-d', strtotime(date('Y-m-d') . ' +1 day')));
			
				$interval = DateInterval::createFromDateString('1 day');
				$period = new DatePeriod($begin, $interval, $end);
				$i = 0;
				foreach ($period as $dt) {
					$this->get_recordings_from_api($dt->format("Y-m-d"));
					if ($i != 0) {
						$this->db->insert('pct_order_recordings_monthly_sync', array('is_sync' => 1, 'month' => $dt->format("Ym"), 'day' => $dt->format("d"), 'created' => date('Y-m-d H:i:s')));
					}
					$i++;
				}
			}
		} else {
			$begin = new DateTime(date('Y-m-01'));
			$end = new DateTime(date('Y-m-d', strtotime(date('y-m-d') . ' +1 day')));
		
			$interval = DateInterval::createFromDateString('1 day');
			$period = new DatePeriod($begin, $interval, $end);

			foreach ($period as $dt) {
				$this->get_recordings_from_api($dt->format("Y-m-d"));
				$this->db->insert('pct_order_recordings_monthly_sync', array('is_sync' => 1, 'month' => $dt->format("Ym"), 'day' => $dt->format("d"), 'created' => date('Y-m-d H:i:s')));
			}
		}
	
		$params = array();  $data = array();
        if (isset($_POST['draw']) && !empty($_POST['draw'])) {
            $params['draw'] = isset($_POST['draw']) && !empty($_POST['draw']) ? $_POST['draw'] : 10;
            $params['length'] = isset($_POST['length']) && !empty($_POST['length']) ? $_POST['length'] : 2;
            $params['start'] = isset($_POST['start']) && !empty($_POST['start']) ? $_POST['start'] : 0;
            $params['orderColumn'] = isset($_POST['order'][0]['column']) && !empty($_POST['order'][0]['column']) ? $_POST['order'][0]['column'] : 0;
            $params['orderDir'] = isset($_POST['order'][0]['dir']) && !empty($_POST['order'][0]['dir']) ? $_POST['order'][0]['dir'] : 0;
            $params['searchvalue'] = isset($_POST['search']['value']) && !empty($_POST['search']['value']) ? $_POST['search']['value'] : '';
            $pageno = ($params['start'] / $params['length'])+1;
			$recording_lists = $this->orderRecording->get_recordings($params);
            $json_data['draw'] = intval( $params['draw'] );
        } else {
            $params['searchvalue'] = isset($_POST['keyword']) && !empty($_POST['keyword']) ? $_POST['keyword'] : '';
            $recording_lists = $this->orderRecording->get_recordings($params);
        }
        

        if (isset($recording_lists['data']) && !empty($recording_lists['data'])) {
            foreach ($recording_lists['data'] as $key => $value)  {
				$nestedData=array();
				
				$date = strtotime($value['recording_date']);
				$recording_date = date('m/d/Y H:i:s', $date);
				$nestedData[] = $recording_date;
                $nestedData[] = $value['instrument_number'];
                $nestedData[] = 'file_number';
                $data[] = $nestedData;      
            }
        }

        $json_data['recordsTotal'] = intval( $recording_lists['recordsTotal'] );
        $json_data['recordsFiltered'] = intval( $recording_lists['recordsFiltered'] );
        $json_data['data'] = $data;
        echo json_encode($json_data);
		
	}
	
	public function get_recordings_from_api($date)
	{
		$userdata = $this->session->userdata('user');
		$this->load->model('order/apiLogs');
		$url = getenv('GET_RECORDING_URL').'date='.$date.'&api_token='.getenv('RECORDING_API_TOKEN');
		$logId = $this->apiLogs->syncLogs($userdata['id'], 'recording', 'get_recordings', $url, array(), array());
		$ch = curl_init($url);                                    
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");                        
		curl_setopt($ch, CURLOPT_POSTFIELDS, array());                   
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_HTTPHEADER, array(                                
			"cache-control: no-cache",
            "Content-Type: application/json"                             
		));
		$error_msg = curl_error($ch);
		$result = curl_exec($ch);
		$this->apiLogs->syncLogs($userdata['id'], 'recording', 'get_recordings', $url, array(), $result, 0, $logId);

		if (isset($result) && !empty($result)) {
			$response = json_decode($result,true);
			$records = array();
			if (isset($response) && !empty($response)) {
				foreach ($response as $key => $value) {
					if (isset($value['documents']) && !empty($value['documents'])) {
						foreach ($value['documents'] as $k => $v)  {
							$date = strtotime($v['recordingTime']);
							$recording_date = date('m/d/Y H:i:s', $date);
							$records = array(
								'instrument_number' => $v['instrumentNumber'], 
								'state' => $v['state'], 
								'county' => $v['county'],
								'recording_date' => $v['recordingTime'],
								'created' => date('Y-m-d H:i:s'),
								'updated' => date('Y-m-d H:i:s')
							);
							$this->db->replace('pct_order_recordings', $records);
						}
					}
				}
			}
		}  
	}
	
	function attach_files()
    {
		$data['title'] = 'Smart Dashboard | Pacific Coast Title Company';
		$this->load->view('layout/head_dashboard',$data);
		$this->load->view('order/attach_files');
	}

	function get_orders()
    {
		$params = array();  $data = array();
		if (isset($_POST['draw']) && !empty($_POST['draw'])) {
			$params['draw'] = isset($_POST['draw']) && !empty($_POST['draw']) ? $_POST['draw'] : 10;
			$params['length'] = isset($_POST['length']) && !empty($_POST['length']) ? $_POST['length'] : 2;
			$params['start'] = isset($_POST['start']) && !empty($_POST['start']) ? $_POST['start'] : 0;
			$params['orderColumn'] = isset($_POST['order'][0]['column']) && !empty($_POST['order'][0]['column']) ? $_POST['order'][0]['column'] : 0;
			$params['orderDir'] = isset($_POST['order'][0]['dir']) && !empty($_POST['order'][0]['dir']) ? $_POST['order'][0]['dir'] : 0;
			$params['searchvalue'] = isset($_POST['search']['value']) && !empty($_POST['search']['value']) ? $_POST['search']['value'] : '';
			$pageno = ($params['start'] / $params['length'])+1;
			$order_lists = $this->order->get_orders($params);
			$json_data['draw'] = intval( $params['draw'] );
		} else {
			$params['searchvalue'] = isset($_POST['keyword']) && !empty($_POST['keyword']) ? $_POST['keyword'] : '';
			$order_lists = $this->order->get_orders($params);
		}

		if (isset($order_lists['data']) && !empty($order_lists['data'])) {
			$i = $params['start'] + 1;
			foreach ($order_lists['data'] as $order)  {
				$nestedData = array();
				$nestedData[] = $i;
				$nestedData[] = $order['file_number'];
				$nestedData[] = $order['full_address'];
				$nestedData[] = '<a href="'.base_url().'upload-documents/'.$order['file_id'].'"><button class="btn btn-grad-2a button-color button-color" type="button">Attach Files</button></a>';
				$data[] = $nestedData; 
				$i++; 
			}
		}

		$json_data['recordsTotal'] = intval( $order_lists['recordsTotal'] );
		$json_data['recordsFiltered'] = intval( $order_lists['recordsFiltered'] );
		$json_data['data'] = $data;
		echo json_encode($json_data);
	}

	public function upload_documents()
	{
		$data['errors'] = array();
		$data['success'] = array();
		if ($this->session->userdata('errors')) {
			$data['errors'] = $this->session->userdata('errors');
			$this->session->unset_userdata('errors');
		}
		if ($this->session->userdata('success')) {
			$data['success'] = $this->session->userdata('success');
			$this->session->unset_userdata('success');
		}
		$data['title'] = 'Smart Dashboard | Pacific Coast Title Company';
		$fileId = $this->uri->segment(2);     
		$data['documentTypes'] = $this->order->get_document_types();
		$data['orderDetails'] = $this->order->get_order_details($fileId);

		$this->load->view('layout/head_dashboard',$data);
		$this->load->view('order/upload_documents');
	}

	public function files_upload() 
	{
		$this->load->model('order/document');
		$this->load->model('order/apiLogs');
		$this->load->library('order/resware');
		$errors = array();
		$success = array();
		$config['upload_path'] = './uploads/documents/';
		$config['allowed_types'] = 'doc|docx|gif|msg|pdf|tif|tiff|xls|xlsx|xml';   
		$config['max_size'] = 12000;
		$userdata = $this->session->userdata('user');
		$this->load->library('upload', $config);
		$fileId = $this->input->post('file_id');
		$orderId = $this->input->post('order_id');

		if (!is_dir('uploads/documents')) {
			mkdir('./uploads/documents', 0777, TRUE);
		}

		for ($i = 1; $i <=6 ; $i++) {
			if (!empty($_FILES['document_'.$i]['name'])) {
				if (! $this->upload->do_upload('document_'.$i)) {
					$errors[$i] = "Document #".$i.": ".$this->upload->display_errors();
				} else { 
					$data = $this->upload->data();
					$contents = file_get_contents($data['full_path']);
					$binaryData   = base64_encode($contents); 
					$document_name = date('YmdHis')."_".$data['file_name'];
					rename(FCPATH."/uploads/documents/".$data['file_name'], FCPATH."/uploads/documents/".$document_name);
					
					$documentData = array(
						'document_name' => $document_name,
						'original_document_name' => $data['file_name'],
						'document_type_id' => $this->input->post('document_type_'.$i),
						'document_size' => ($data['file_size'] * 1000),
						'user_id' => $userdata['id'],
						'order_id' => $orderId,
						'description' => $this->input->post('description_'.$i),
						'is_sync' => 1,
						'is_prelim_document' => 0
					);
					
					$documentId = $this->document->insert($documentData);
					
					$endPoint = 'files/'.$fileId.'/documents';
					
					$documentApiData = array(			
						'DocumentName' => $data['file_name'],
						'DocumentType' => array(
							'DocumentTypeID' => $this->input->post('document_type_'.$i),
						),
						'Description' => $this->input->post('description_'.$i),
						'InternalOnly' => false,
						'DocumentBody' => $binaryData
					);
					$document_api_data = json_encode($documentApiData, JSON_UNESCAPED_SLASHES);

					if ($userdata['is_master'] == 1) {
						$orderDetails = $this->order->get_order_details($fileId);
						$orderUser =  $this->home_model->get_user(array('id' => $orderDetails['customer_id']));
						$user_data['email'] = $orderUser['email_address'];
						$user_data['password'] = $orderUser['random_password'];
					} else {
						$user_data = array();
					}
					
					$logid = $this->apiLogs->syncLogs($userdata['id'], 'resware', 'create_document', env('RESWARE_ORDER_API').$endPoint, $documentApiData, array(), $orderId, 0);
					$result = $this->resware->make_request('POST', $endPoint, $document_api_data, $user_data);
					$this->apiLogs->syncLogs($userdata['id'], 'resware', 'create_document', env('RESWARE_ORDER_API').$endPoint, $documentApiData, $result, $orderId, $logid);
					$res = json_decode($result);
					$this->document->update(array('api_document_id' => $res->Document->DocumentID), array('id' => $documentId));
					$success[$i] = "Document #".$i.": uploaded successfully";
				} 
			}
		}
		$data['errors'] = $errors;
		$data['success'] = $success;
		$data = array(
			"errors" =>  $errors,
			"success" => $success
		);
		$this->session->set_userdata($data);
		redirect(base_url().'upload-documents/'.$fileId);
	}

    function fees()
    {
        $data['title'] = 'Smart Dashboard | Pacific Coast Title Company';
        $this->load->view('layout/head_dashboard',$data);
        $this->load->view('order/fees');
    }

    function get_transaction_orders()
    {
        $params = array();  $data = array();
        if (isset($_POST['draw']) && !empty($_POST['draw'])) {
            $params['draw'] = isset($_POST['draw']) && !empty($_POST['draw']) ? $_POST['draw'] : 10;
            $params['length'] = isset($_POST['length']) && !empty($_POST['length']) ? $_POST['length'] : 2;
            $params['start'] = isset($_POST['start']) && !empty($_POST['start']) ? $_POST['start'] : 0;
            $params['orderColumn'] = isset($_POST['order'][0]['column']) && !empty($_POST['order'][0]['column']) ? $_POST['order'][0]['column'] : 0;
            $params['orderDir'] = isset($_POST['order'][0]['dir']) && !empty($_POST['order'][0]['dir']) ? $_POST['order'][0]['dir'] : 0;
            $params['searchvalue'] = isset($_POST['search']['value']) && !empty($_POST['search']['value']) ? $_POST['search']['value'] : '';
            $pageno = ($params['start'] / $params['length'])+1;
            $order_lists = $this->order->get_orders($params);
            $json_data['draw'] = intval( $params['draw'] );
        } else {
            $params['searchvalue'] = isset($_POST['keyword']) && !empty($_POST['keyword']) ? $_POST['keyword'] : '';
            $order_lists = $this->order->get_orders($params);
        }

        if (isset($order_lists['data']) && !empty($order_lists['data'])) {
            $i = $params['start'] + 1;
            foreach ($order_lists['data'] as $order)  {
                $nestedData = array();
                $nestedData[] = $i;
                $nestedData[] = $order['file_number'];
                $nestedData[] = $order['full_address'];
                $nestedData[] = '<a href="'.base_url().'get-fees/'.$order['file_id'].'"><button class="btn btn-grad-2a button-color button-color" type="button">Get Fees</button></a>';
                $data[] = $nestedData; 
                $i++; 
            }
        }

        $json_data['recordsTotal'] = intval( $order_lists['recordsTotal'] );
        $json_data['recordsFiltered'] = intval( $order_lists['recordsFiltered'] );
        $json_data['data'] = $data;
        echo json_encode($json_data);
    }

    function get_fees()
    {
        $data['title'] = 'Smart Dashboard | Pacific Coast Title Company';
        $userdata = $this->session->userdata('user');
        $fileId = $this->uri->segment(2);
        $orderDetails = $this->order->get_order_details($fileId);
        $orderId = isset($orderDetails['order_id']) && !empty($orderDetails['order_id']) ? $orderDetails['order_id'] : '';
        /* start get fees details from resware */
        $request = array();

        $TransactionTypeID = isset($orderDetails['transaction_type']) && !empty($orderDetails['transaction_type']) ? $orderDetails['transaction_type'] : '';
        $ProductTypeID = isset($orderDetails['purchase_type']) && !empty($orderDetails['purchase_type']) ? $orderDetails['purchase_type'] : '';
        $request['TransactionProductType'] = array("TransactionTypeID" => $TransactionTypeID, 'ProductTypeID'=>$ProductTypeID);

        $propertyAddress = isset($orderDetails['address']) && !empty($orderDetails['address']) ? $orderDetails['address'] : '';

        $addressParts = explode(' ', $propertyAddress);

        $streetNumber = isset($addressParts[0]) && !empty($addressParts[0]) ? $addressParts[0] : '';

        $primaryStreetName = array_slice($addressParts, 1);
        $streetName = isset($primaryStreetName) && !empty($primaryStreetName) ? implode(" ", $primaryStreetName) : '';

        $FullProperty = isset($orderDetails['full_address']) && !empty($orderDetails['full_address']) ? $orderDetails['full_address'] : '';
               
        $PropertyZip = isset($orderDetails['property_zip']) && !empty($orderDetails['property_zip']) ? $orderDetails['property_zip'] : '';
        
        $propertyState = isset($orderDetails['property_state']) && !empty($orderDetails['property_state']) ? $orderDetails['property_state'] : '';

        $propertyCity = isset($orderDetails['property_city']) && !empty($orderDetails['property_city']) ? $orderDetails['property_city'] : '';      
        
        $county = isset($orderDetails['county']) && !empty($orderDetails['county']) ? $orderDetails['county'] : '';

        $request['Properties'][] = array('IsPrimary'=>'true', 'StreetNumber'=>$streetNumber, 'StreetName'=> $streetName, 'City'=> $propertyCity, 'State'=> $propertyState, 'County'=> $county, 'Zip'=>$propertyZip);

        $loanAmount = isset($orderDetails['loan_amount']) && !empty($orderDetails['loan_amount']) ? $orderDetails['loan_amount'] : '';
        if(isset($loanAmount) && !empty($loanAmount))
        {
            $request['Loans'][]['LoanAmount'] = $loanAmount;
            $condition = array(
	            'where' => array(
	                'transaction_type' => 'loan',
	                'status' => 1
	            )
	        );
        }

        $salesAmount = isset($orderDetails['sales_amount']) && !empty($orderDetails['sales_amount']) ? $orderDetails['sales_amount'] : '';

        if(isset($salesAmount) && !empty($salesAmount))
        {
            $request['SalesPrice'] = $salesAmount;
            $condition = array(
	            'where' => array(
	                'transaction_type' => 'sale',
	                'status' => 1
	            )
	        );
        }

        $fees_data = json_encode($request);
        $this->load->library('order/resware');


        $endPoint = 'estimates/closingfees';
        $logid = $this->apiLogs->syncLogs($userdata['id'], 'resware', 'get_fees', env('RESWARE_ORDER_API').$endPoint, $fees_data, array(), $orderId, 0);
        $result = $this->resware->make_request('POST', $endPoint, $fees_data);

        $fees = array();
        if(isset($result) && !empty($result))
        {
            $response = json_decode($result,TRUE);
            $closing_fee_estimate_id = isset($response['ClosingFeeEstimate']['ClosingFeeEstimateID']) && !empty($response['ClosingFeeEstimate']['ClosingFeeEstimateID']) ? $response['ClosingFeeEstimate']['ClosingFeeEstimateID'] : '';

            if(isset($response['ClosingFeeEstimate']['HUDFees']) && !empty(isset($response['ClosingFeeEstimate']['HUDFees'])))
            {
                
                foreach ($response['ClosingFeeEstimate']['HUDFees'] as $key => $value) 
                {
                    $fees['HUDFees'][$key] = array('amount' => $value['Amount'], 'description' => $value['Description']);
                }
            }

            if(isset($response['ClosingFeeEstimate']['GFE']) && !empty(isset($response['ClosingFeeEstimate']['GFE'])))
            {
                foreach ($response['ClosingFeeEstimate']['GFE'] as $k => $v) 
                {
                    $fees['GFE'][$k] = array('amount' => $v['Amount'], 'description' => $v['Description']);
                }
            }

            if(isset($response['ClosingFeeEstimate']['Premiums']) && !empty(isset($response['ClosingFeeEstimate']['Premiums'])))
            {
                foreach ($response['ClosingFeeEstimate']['Premiums'] as $k => $v) 
                {
                    $fees['Premiums'][] = array('amount' => $v, 'description' => $k);
                }
            }
        }
        $feesInfo = $this->fees_model->get_rows($condition);
        if(isset($feesInfo) && !empty(isset($feesInfo)))
        {
            foreach ($feesInfo as $k => $v) 
            {
                $fees['AdditionalFees'][] = array('amount' => $v['value'], 'description' => $v['name']);
            }
        }
        $data['fees'] = $fees;
        $data['order_number'] = isset($orderDetails['file_number']) && !empty($orderDetails['file_number']) ? $orderDetails['file_number'] : '';
        $data['full_address'] = isset($orderDetails['full_address']) && !empty($orderDetails['full_address']) ? $orderDetails['full_address'] : '';
        $data['sales_amount'] = isset($orderDetails['sales_amount']) && !empty($orderDetails['sales_amount']) ? $orderDetails['sales_amount'] : '';
        $data['loan_amount'] = isset($orderDetails['loan_amount']) && !empty($orderDetails['loan_amount']) ? $orderDetails['loan_amount'] : '';
        if(isset($orderDetails['sales_amount']) && !empty($orderDetails['sales_amount']))
        {
        	$productType = 'Residential: Sales: Purchase';
        }
        if(isset($orderDetails['loan_amount']) && !empty($orderDetails['loan_amount']))
        {
        	$productType = 'Residential: Loan: Refinance';
        }

        $data['productType'] = $productType;
        $data['closing_fee_estimate_id'] = $closing_fee_estimate_id;
        
        $this->apiLogs->syncLogs($userdata['id'], 'resware', 'get_fees', env('RESWARE_ORDER_API').$endPoint, $fees_data, $result, $orderId, $logid);

        $this->load->model('order/fee');
        $feesData = array(
            'closing_fee_estimate_id' => $closing_fee_estimate_id,
            'user_id' => $userdata['id'],
            'order_id' => $orderId
        );

        $feeId = $this->fee->insert($feesData);

        /* end get fees details from resware */

        $this->load->view('layout/head_dashboard',$data);
        $this->load->view('order/get_fees');
    }

    function get_fee_estimate_pdf()
    {
        $userdata = $this->session->userdata('user');
        $closing_fee_id = isset($_POST['closing_fee_id']) && !empty($_POST['closing_fee_id']) ? $_POST['closing_fee_id'] :'';

        if($closing_fee_id)
        {
            $this->load->library('order/resware');

            $endPoint = '/estimates/closingfees/'.$closing_fee_id.'/receipt/pdf';

            $logid = $this->apiLogs->syncLogs($userdata['id'], 'resware', 'get_fee_estimate_pdf', env('RESWARE_ORDER_API').$endPoint, $closing_fee_id, array(), 0, 0);

            $result = $this->resware->make_request('GET', $endPoint, array());

            $this->apiLogs->syncLogs($userdata['id'], 'resware', 'get_fee_estimate_pdf', env('RESWARE_ORDER_API').$endPoint, $closing_fee_id, $result, 0, $logid);
            
            if(isset($result) && !empty($result))
            {
                echo base64_encode($result);
            }
        }
    }

    function notes()
    {
        $data['title'] = 'Smart Dashboard | Pacific Coast Title Company';
        $this->load->view('layout/head_dashboard',$data);
        $this->load->view('order/notes');
    }

    function get_notes_orders()
    {
        $params = array();  $data = array();
        if (isset($_POST['draw']) && !empty($_POST['draw'])) {
            $params['draw'] = isset($_POST['draw']) && !empty($_POST['draw']) ? $_POST['draw'] : 10;
            $params['length'] = isset($_POST['length']) && !empty($_POST['length']) ? $_POST['length'] : 2;
            $params['start'] = isset($_POST['start']) && !empty($_POST['start']) ? $_POST['start'] : 0;
            $params['orderColumn'] = isset($_POST['order'][0]['column']) && !empty($_POST['order'][0]['column']) ? $_POST['order'][0]['column'] : 0;
            $params['orderDir'] = isset($_POST['order'][0]['dir']) && !empty($_POST['order'][0]['dir']) ? $_POST['order'][0]['dir'] : 0;
            $params['searchvalue'] = isset($_POST['search']['value']) && !empty($_POST['search']['value']) ? $_POST['search']['value'] : '';
            $pageno = ($params['start'] / $params['length'])+1;
            $order_lists = $this->order->get_orders($params);
            $json_data['draw'] = intval( $params['draw'] );
        } else {
            $params['searchvalue'] = isset($_POST['keyword']) && !empty($_POST['keyword']) ? $_POST['keyword'] : '';
            $order_lists = $this->order->get_orders($params);
        }

        if (isset($order_lists['data']) && !empty($order_lists['data'])) {
            $i = $params['start'] + 1;
            foreach ($order_lists['data'] as $order)  {
                $nestedData = array();
                $nestedData[] = $i;
                $nestedData[] = $order['file_number'];
                $nestedData[] = $order['full_address'];
                $nestedData[] = '<a href="'.base_url().'get-notes/'.$order['file_id'].'"><button class="btn btn-grad-2a button-color button-color" type="button">View / Add Notes</button></a>';
                $data[] = $nestedData; 
                $i++; 
            }
        }

        $json_data['recordsTotal'] = intval( $order_lists['recordsTotal'] );
        $json_data['recordsFiltered'] = intval( $order_lists['recordsFiltered'] );
        $json_data['data'] = $data;
        echo json_encode($json_data);
    }


    function get_notes()
    {        
        $data['title'] = 'Smart Dashboard | Pacific Coast Title Company';
        
        $fileId = $this->uri->segment(2);
        $orderDetails = $this->order->get_order_details($fileId);
		$orderId = isset($orderDetails['order_id']) && !empty($orderDetails['order_id']) ? $orderDetails['order_id'] : '';
        $data['fileId'] = $fileId;
        $userdata = $this->session->userdata('user');
        
        $this->load->library('order/resware');

        $request = array();
        $endPoint = '/files/'.$fileId.'/notes';

        $request['DownloadDocuments'] = false;
        $request['FileID'] = $fileId;

        $notes_data = json_encode($request);
        $logid = $this->apiLogs->syncLogs($userdata['id'], 'resware', 'get_notes', env('RESWARE_ORDER_API').$endPoint, $notes_data, array(), $orderId, 0);        

        $result = $this->resware->make_request('GET', $endPoint, $notes_data);

        $this->apiLogs->syncLogs($userdata['id'], 'resware', 'get_notes', env('RESWARE_ORDER_API').$endPoint, $notes_data, $result, $orderId, $logid);
        
        if(isset($result) && !empty($result))
        {
            $response = json_decode($result, TRUE);

            if(isset($response['notes']) && !empty($response['notes']))
            {
                $data['notes'] = $response['notes'];
            }
        }
        /* end get fees details from resware */

        $this->load->view('layout/head_dashboard',$data);
        $this->load->view('order/get_notes');
    }

    public function create_note()
    {
    	$fileId = isset($_POST['fileId']) && !empty($_POST['fileId']) ? $_POST['fileId'] : '';
    	if(isset($fileId) && !empty($fileId))
    	{
    		$userdata = $this->session->userdata('user');
    		$subject = isset($_POST['subject']) && !empty($_POST['subject']) ? $_POST['subject'] : '';
    		$body = isset($_POST['body']) && !empty($_POST['body']) ? $_POST['body'] : '';
    		$orderDetails = $this->order->get_order_details($fileId);
			$orderId = isset($orderDetails['order_id']) && !empty($orderDetails['order_id']) ? $orderDetails['order_id'] : '';
			
    		$this->load->library('order/resware');

	        $request = array();
	        $endPoint = '/files/'.$fileId.'/notes';

	        $request['Subject'] = $subject;
	        $request['Body'] = $body;
	        $request['FileID'] = $fileId;

	        $notes_data = json_encode($request);
	        $logid = $this->apiLogs->syncLogs($userdata['id'], 'resware', 'create_note', env('RESWARE_ORDER_API').$endPoint, $notes_data, array(), $orderId, 0);        

	        $result = $this->resware->make_request('POST', $endPoint, $notes_data);

	        $this->apiLogs->syncLogs($userdata['id'], 'resware', 'create_note', env('RESWARE_ORDER_API').$endPoint, $notes_data, $result, $orderId, $logid);
	        
	        if(isset($result) && !empty($result))
	        {
	            $response = json_decode($result, TRUE);
	            if(isset($response['ResponseStatus']) && !empty($response['ResponseStatus']))
				{
					$message = isset($response['ResponseStatus']['Message']) && !empty($response['ResponseStatus']['Message']) ? $response['ResponseStatus']['Message'] : '';
					$response = array('status'=>'error', 'message'=> $message);
					echo json_encode($response); exit;
				}
				else
				{
					$noteId = isset($response['Note']['NoteID']) && !empty($response['Note']['NoteID']) ? $response['Note']['NoteID'] : '';

					$this->load->model('order/note');
					
			        $notesData = array(
			            'note_id' => $noteId,
			            'user_id' => $userdata['id'],
			            'order_id' => $orderId
			        );

			        $id = $this->note->insert($notesData);

			        if($noteId && $id)
			        {
			        	$response = array('status'=>'success', 'message'=>'Note created successfully.');
						echo json_encode($response); exit;
			        }
			        else
			        {
			        	$response = array('status'=>'error', 'message'=> 'Something went wrong. Please try again.');
						echo json_encode($response); exit;
			        }
				}
	    	}
	    }
    }

    public function proposed_insured()
    {
    	$data['title'] = 'Smart Dashboard | Pacific Coast Title Company';
    	$condition = array(
            'where' => array(
                'status' => 1
            )
        );
		
		$data['titleOfficer'] = $this->titleOfficer->getTitleOfficerDetails($condition);

    	$data['title'] = 'Smart Dashboard | Pacific Coast Title Company';
        $this->load->view('layout/head_dashboard',$data);
        $this->load->view('order/proposed_insured');
    }

    function get_proposed_orders()
    {
        $params = array();  $data = array();
        if (isset($_POST['draw']) && !empty($_POST['draw'])) {
            $params['draw'] = isset($_POST['draw']) && !empty($_POST['draw']) ? $_POST['draw'] : 10;
            $params['length'] = isset($_POST['length']) && !empty($_POST['length']) ? $_POST['length'] : 2;
            $params['start'] = isset($_POST['start']) && !empty($_POST['start']) ? $_POST['start'] : 0;
            $params['orderColumn'] = isset($_POST['order'][0]['column']) && !empty($_POST['order'][0]['column']) ? $_POST['order'][0]['column'] : 0;
            $params['orderDir'] = isset($_POST['order'][0]['dir']) && !empty($_POST['order'][0]['dir']) ? $_POST['order'][0]['dir'] : 0;
            $params['searchvalue'] = isset($_POST['search']['value']) && !empty($_POST['search']['value']) ? $_POST['search']['value'] : '';
            $pageno = ($params['start'] / $params['length'])+1;
            $order_lists = $this->order->get_orders($params);
            $json_data['draw'] = intval( $params['draw'] );
        } else {
            $params['searchvalue'] = isset($_POST['keyword']) && !empty($_POST['keyword']) ? $_POST['keyword'] : '';
            $order_lists = $this->order->get_orders($params);
        }

        if (isset($order_lists['data']) && !empty($order_lists['data'])) {
            $i = $params['start'] + 1;
            foreach ($order_lists['data'] as $order)  {
                $nestedData = array();
                $nestedData[] = $i;
                $nestedData[] = $order['file_number'];
                $nestedData[] = $order['full_address'];
               
                if (!empty($order['proposed_insured_document_name'])) 
                {
                	$file_id = $order['file_id'];
					$documentName = $order['proposed_insured_document_name'];
					

                	$action = '<a href="./uploads/proposed-insured/'.$documentName.'" download><button class="btn btn-grad-2a button-color" type="button">Download</button></a>';
                }
                else
                {
                	$action = '<a href="javascript:void(0);" onclick="generateProposedInsured('.$order['file_id'].');"><button class="btn btn-grad-2a button-color" type="button">Generate</button></a>';
                }
                

                $action .= '<a href="javascript:void(0);" onclick="editInformation('.$order['file_id'].');"><button class="btn btn-grad-2a button-color" type="button">Edit</button></a>';

                $nestedData[] = $action;

                $data[] = $nestedData; 
                $i++; 
            }
        }

        $json_data['recordsTotal'] = intval( $order_lists['recordsTotal'] );
        $json_data['recordsFiltered'] = intval( $order_lists['recordsFiltered'] );
        $json_data['data'] = $data;
        echo json_encode($json_data);
    }

    public function generate_proposed_insured()
    {
    	$fileId = isset($_POST['fileId']) && !empty($_POST['fileId']) ? $_POST['fileId'] : '';

    	$orderDetails = $this->order->get_order_details($fileId);
        $orderId = isset($orderDetails['order_id']) && !empty($orderDetails['order_id']) ? $orderDetails['order_id'] : '';
        $transaction_id = isset($orderDetails['transaction_id']) && !empty($orderDetails['transaction_id']) ? $orderDetails['transaction_id'] : '';
        $property_id = isset($orderDetails['property_id']) && !empty($orderDetails['property_id']) ? $orderDetails['property_id'] : '';

        $purchase_type = isset($orderDetails['purchase_type']) && !empty($orderDetails['purchase_type']) ? $orderDetails['purchase_type'] : '';

        $userdata = $this->session->userdata('user');

        $this->load->model('order/home_model');
		$customer_data =  $this->home_model->get_user(array('id' => $userdata['id']));

		
		$emptyData = array();
		$emptyData['orderId'] = $orderId;
		$emptyData['transaction_id'] = $transaction_id;
		$emptyData['property_id'] = $property_id;
		$emptyData['fileId'] = $fileId;
		$is_title_officer = 0;
		
		if(isset($orderDetails['title_officer']) && !empty($orderDetails['title_officer']))
		{
			if(preg_match('/\\d/', $orderDetails['title_officer']) > 0)
			{
				$condition = array(
	                'id' => $orderDetails['title_officer'],
	                'status' => 1
	            );
	            $titleOfficerDetails = $this->titleOfficer->getTitleOfficerDetails($condition); 
			}
			else
			{
	            $condition = array(
		            'where' => array(
		                'name' => $orderDetails['title_officer'],
		                'status' => 1
		            )
		        );
		        $officerDetails = $this->titleOfficer->getTitleOfficerDetails($condition);
		        $titleOfficerDetails = isset($officerDetails[0]) && !empty($officerDetails[0]) ? $officerDetails[0] : array();
			}
		
			$data['title_officer'] = isset($titleOfficerDetails['name']) && !empty($titleOfficerDetails['name']) ? $titleOfficerDetails['name'] : '';;
			$data['title_officer_email'] = isset($titleOfficerDetails['email_address']) && !empty($titleOfficerDetails['email_address']) ? $titleOfficerDetails['email_address'] : '';
			$data['title_officer_phone'] = isset($titleOfficerDetails['phone']) && !empty($titleOfficerDetails['phone']) ? $titleOfficerDetails['phone'] : '';
			
			$is_title_officer = 1;
		}
		$emptyData['is_title_officer'] = $is_title_officer;
		
		$data['company'] = isset($customer_data['company_name']) && !empty($customer_data['company_name']) ? $customer_data['company_name'] : '';
		
		$address = array();
		$street_address = isset($customer_data['street_address']) && !empty($customer_data['street_address']) ? $customer_data['street_address'] : '';
		if($street_address)
		{
			$address[] = $street_address;
		}
		$city = isset($customer_data['city']) && !empty($customer_data['city']) ? $customer_data['city'] : '';
		if($city)
		{
			$address[] = $city;
		}

		$zip_code = isset($customer_data['zip_code']) && !empty($customer_data['zip_code']) ? $customer_data['zip_code'] : '';
		if($zip_code)
		{
			$address[] = $zip_code;
		}
		$data['address'] = implode(', ', $address);
		$data['order_number'] = isset($orderDetails['file_number']) && !empty($orderDetails['file_number']) ? $orderDetails['file_number'] : '';
		$data['property_address'] = isset($orderDetails['full_address']) && !empty($orderDetails['full_address']) ? $orderDetails['full_address'] : '';
		$data['loan_amount'] = isset($orderDetails['loan_amount']) && !empty($orderDetails['loan_amount']) ? $orderDetails['loan_amount'] : '';
		
		$is_loan_number = 0;
		if(isset($orderDetails['loan_number']) && !empty($orderDetails['loan_number']))
		{
			$is_loan_number = 1;
			$data['loan_number'] = $orderDetails['loan_number'];
		}
		$emptyData['is_loan_number'] = $is_loan_number;

		$is_borrower = 0; $is_secondary_borrower = 0;
		
		$sales_amount = isset($orderDetails['sales_amount']) && !empty($orderDetails['sales_amount']) ? $orderDetails['sales_amount'] : '';
		
		if(isset($sales_amount) && !empty($sales_amount))
		{
			$borrowers =  isset($orderDetails['borrower']) && !empty($orderDetails['borrower']) ? $orderDetails['borrower'] : '';
			$data['borrowers'] = $borrowers;
			if($borrowers)
			{
				$is_borrower = 1;
			}

			$secondary_borrower =  isset($orderDetails['secondary_borrower']) && !empty($orderDetails['secondary_borrower']) ? $orderDetails['secondary_borrower'] : '';
			$data['secondary_borrower'] = $secondary_borrower;
			if($secondary_borrower)
			{
				$is_secondary_borrower = 1;
			}
		}
		else if(isset($orderDetails['loan_amount']) && !empty($orderDetails['loan_amount']))
		{
			$primary_owner = isset($orderDetails['primary_owner']) && !empty($orderDetails['primary_owner']) ? $orderDetails['primary_owner'] : '';
			$secondary_owner = isset($orderDetails['secondary_owner']) && !empty($orderDetails['secondary_owner']) ? $orderDetails['secondary_owner'] : '';
			if($primary_owner)
			{
				$data['borrowers'] = $primary_owner;
				$is_borrower = 1;
			}

			if($secondary_owner)
			{
				$data['secondary_borrower'] = $secondary_owner;
				$is_secondary_borrower = 1;
			}
				
		}
		$emptyData['is_borrower'] = $is_borrower;
		$emptyData['is_secondary_borrower'] = $is_secondary_borrower;
		
		$is_supplemental_report_date = 0;
		if(isset($orderDetails['supplemental_report_date']) && !empty($orderDetails['supplemental_report_date']))
		{
			$data['supplemental_report_date'] =  $orderDetails['supplemental_report_date'];
			$is_supplemental_report_date = 1;
		}
		$emptyData['is_supplemental_report_date'] = $is_supplemental_report_date;

		$is_preliminary_report_date = 0;
		if(isset($orderDetails['preliminary_report_date']) && !empty($orderDetails['preliminary_report_date']))
		{
			$data['preliminary_report_date'] = $orderDetails['preliminary_report_date'];
			$is_preliminary_report_date = 1;
		}
		$emptyData['is_preliminary_report_date'] = $is_preliminary_report_date;

		$is_lender = 0;
		if(isset($orderDetails['escrow_lender_id']) && !empty($orderDetails['escrow_lender_id']))
		{
			$escrow_lender_id = $orderDetails['escrow_lender_id'];
			$is_lender = 1;
			$lender_data =  $this->home_model->get_user(array('id' => $escrow_lender_id));
			$data['lender'] = isset($lender_data['company_name']) && !empty($lender_data['company_name']) ? $lender_data['company_name'] : '';
		}
		$emptyData['is_lender'] = $is_lender;

		$logid = $this->apiLogs->syncLogs($userdata['id'], 'westcor', 'proposed_insured', '', $data, array(), $orderId, 0);
		
		if(empty($data['title_officer']) || empty($data['borrowers']) || empty($data['lender']) || empty($data['loan_number']) || empty($data['supplemental_report_date']) || empty($data['preliminary_report_date']))
		{
			$res = array('status'=>'dataRequired','data'=>$emptyData);
			echo json_encode($res); exit;
		}
		else
		{
			$html=$this->load->view('order/proposed_insured_pdf',$data, true);
	        $this->load->library('m_pdf');
	        $this->m_pdf->pdf->WriteHTML($html);
	        $this->load->model('order/document');
	        $proposedDocumentCount = $this->document->countProposedInsuredDocument($orderDetails['order_id']);
			$document_name = "proposed_".$proposedDocumentCount."_".$fileId.".pdf";

	        if (!is_dir('uploads/proposed-insured')) {
			    mkdir('./uploads/proposed-insured', 0777, TRUE);
			}

			$pdfFilePath = './uploads/proposed-insured/'.$document_name;
	        $this->m_pdf->pdf->Output($pdfFilePath,'F');
	        $contents = file_get_contents($pdfFilePath);
			$binaryData   = base64_encode($contents);		
			// unlink($pdfFilePath);
			$this->home_model->update(array('proposed_insured_document_name' => $document_name), array('file_id' => $fileId), 'order_details');

			$fileSize = filesize('./uploads/proposed-insured/'.$document_name);
			$documentData = array(
				'document_name' => $document_name,
				'original_document_name' => $document_name,
				'document_type_id' => 1031,
				'document_size' => $fileSize,
				'user_id' => $userdata['id'],
				'order_id' => $orderDetails['order_id'],
				'description' => 'Proposed Insured Document',
				'is_sync' => 0,
				'is_prelim_document' => 0,
				'is_proposed_insured_doc' => 1
			);
			$documentId = $this->document->insert($documentData);

			$res = array('status'=>'success','data'=>$binaryData);
			echo json_encode($res); exit;
		}
    }

	function cpl()
    {
		$data['errors'] = array();
		$data['success'] = array();
		if ($this->session->userdata('errors')) {
			$data['errors'] = $this->session->userdata('errors');
			$this->session->unset_userdata('errors');
		}
		if ($this->session->userdata('success')) {
			$data['success'] = $this->session->userdata('success');
			$this->session->unset_userdata('success');
		}
		$data['title'] = 'Smart Dashboard | Pacific Coast Title Company';
		$this->load->view('layout/head_dashboard',$data);
		$this->load->view('order/cpl');
	}

	public function get_orders_cpl()
	{
		$params = array();  $data = array();
		if (isset($_POST['draw']) && !empty($_POST['draw'])) {
			$params['draw'] = isset($_POST['draw']) && !empty($_POST['draw']) ? $_POST['draw'] : 10;
			$params['length'] = isset($_POST['length']) && !empty($_POST['length']) ? $_POST['length'] : 2;
			$params['start'] = isset($_POST['start']) && !empty($_POST['start']) ? $_POST['start'] : 0;
			$params['orderColumn'] = isset($_POST['order'][0]['column']) && !empty($_POST['order'][0]['column']) ? $_POST['order'][0]['column'] : 0;
			$params['orderDir'] = isset($_POST['order'][0]['dir']) && !empty($_POST['order'][0]['dir']) ? $_POST['order'][0]['dir'] : 0;
			$params['searchvalue'] = isset($_POST['search']['value']) && !empty($_POST['search']['value']) ? $_POST['search']['value'] : '';
			$pageno = ($params['start'] / $params['length'])+1;
			$order_lists = $this->order->get_orders($params);
			$json_data['draw'] = intval( $params['draw'] );
		} else {
			$params['searchvalue'] = isset($_POST['keyword']) && !empty($_POST['keyword']) ? $_POST['keyword'] : '';
			$order_lists = $this->order->get_orders($params);
		}
		
		if (isset($order_lists['data']) && !empty($order_lists['data'])) {
			$i = $params['start'] + 1;
			foreach ($order_lists['data'] as $order)  {
				$nestedData = array();
				$nestedData[] = $i;
				$nestedData[] = $order['file_number'];
				$nestedData[] = $order['full_address'];
				if (!empty($order['cpl_document_name'])) {
					$file_id = $order['file_id'];
					$documentName = $order['cpl_document_name'];
					$nestedData[] = "<div style='display:flex;'><a href='./uploads/documents/$documentName' download><button class='btn btn-grad-2a' style='background: #d35411;' type='button'>Download</button></a>
						<a onclick='return lender_pop_up(0, $file_id);' href='javascript:void(0);'><button class='btn btn-grad-2a generate button-color' type='button'>Edit</button></a></div>";
				} else if(!empty($order['westcor_file_id'])) {
					$file_id = $order['file_id'];
					$westcorFileId = $order['westcor_file_id'];
					$westcorOrderId = $order['westcor_order_id'];
					$nestedData[] = "<div style='display:flex;'><a onclick='download_for_pdf($westcorFileId, $westcorOrderId);' href='javascript:void(0);'><button class='btn btn-grad-2a' style='background: #d35411;' type='button'>Download</button></a>
							<a onclick='return lender_pop_up(0, $file_id);' href='javascript:void(0);'><button class='btn btn-grad-2a generate button-color' type='button'>Edit</button></a></div>";
				} else {
					$file_id = $order['file_id'];
					$lender_id_flag = !empty($order['escrow_lender_id']) ? 1 : 0;
					$nestedData[] = "<div style='display:flex;'><form onclick='return lender_pop_up($lender_id_flag, $file_id);' action='".base_url()."create-cpl/".$order['file_id']."' method='POST'><button class='btn btn-grad-2a generate button-color' type='submit'>GENERATE</button></form>
					<a onclick='return lender_pop_up(0, $file_id);' href='javascript:void(0);'><button class='btn btn-grad-2a generate button-color' type='button'>Edit</button></a></div>";
				}
				$data[] = $nestedData; 
				$i++; 
			}
		}

		$json_data['recordsTotal'] = intval( $order_lists['recordsTotal'] );
		$json_data['recordsFiltered'] = intval( $order_lists['recordsFiltered'] );
		$json_data['data'] = $data;
		echo json_encode($json_data);
	}

	public function create_cpl()
	{
		$this->load->model('order/apiLogs');
		$this->load->library('order/westcor');
		$this->load->model('order/home_model');
		$this->load->model('order/document');
		$userdata = $this->session->userdata('user');
		$fileId = $this->uri->segment(2);    
		$errors = array();
		$success = array();
		$orderDetails = $this->order->get_order_details($fileId);
		$res = array();

		$resToken = $this->order->get_token();
		$orderUser =  $this->home_model->get_user(array('id' => $orderDetails['customer_id']));

		if ($resToken === false) {
			$resToken = $this->westcor->createToken($orderDetails['order_id']);
		} 

		$propertyDetail = explode(",", $orderDetails['full_address']);
		$propery[] = array (
			'PropertyID' => 0,
			'tvid' =>  0,
			'CountyName' => $orderDetails['county'].' County',
			'ShortLegal' => $orderDetails['legal_description'] ? $orderDetails['legal_description'] : null,
			'StreetAddress' => $orderDetails['address'] ? $orderDetails['address'] : trim($propertyDetail[0])." ".trim($propertyDetail[1]),
			'City' => $orderDetails['property_city'] ? $orderDetails['property_city'] : trim($propertyDetail[2]),
			'State' => $orderDetails['property_state'] ? $orderDetails['property_state'] : trim($propertyDetail[3]),
			'Zip' => $orderDetails['property_zip'] ? $orderDetails['property_zip'] : trim($propertyDetail[4]),
			'PropertyType' => 'R'
		);

		$primary_owner = explode(" ", $orderDetails['primary_owner']);
		$secondary_owner = explode(" ", $orderDetails['secondary_owner']);
		if ($orderDetails['sales_amount'] > 0)  {
			$sellers[] = array (
				'NameID' =>  $orderDetails['westcor_seller_id'] ? $orderDetails['westcor_seller_id'] : 0,
				'Last' => $primary_owner[1],
				'First' => $primary_owner[0],
				'NameType' => 2,
				'JoiningPhrase' => 'single',
				'tvid' => 0,
				'Sequence' => 1,
				'City' => $orderDetails['property_city'] ? $orderDetails['property_city'] : trim($propertyDetail[2]),
				'State' => $orderDetails['property_state'] ? $orderDetails['property_state'] : trim($propertyDetail[3]),
				'Zip' => $orderDetails['property_zip'] ? $orderDetails['property_zip'] : trim($propertyDetail[4]),
				'Address' => $orderDetails['address'] ? $orderDetails['address'] : trim($propertyDetail[0])." ".trim($propertyDetail[1]),
			);
			if(!empty($secondary_owner)) {
				$sellers[] = array (
					'NameID' => $orderDetails['westcor_secondary_seller_id'] ? $orderDetails['westcor_secondary_seller_id'] : 0,
					'Last' => $secondary_owner[1],
					'First' => $secondary_owner[0],
					'NameType' => 1,
					'JoiningPhrase' => 'single',
					'tvid' => 0,
					'Sequence' => 2,
					'City' => $orderDetails['property_city'] ? $orderDetails['property_city'] : trim($propertyDetail[2]),
					'State' => $orderDetails['property_state'] ? $orderDetails['property_state'] : trim($propertyDetail[3]),
					'Zip' => $orderDetails['property_zip'] ? $orderDetails['property_zip'] : trim($propertyDetail[4]),
					'Address' => $orderDetails['address'] ? $orderDetails['address'] : trim($propertyDetail[0])." ".trim($propertyDetail[1])
				);	
			}
			$purchase_price = $orderDetails['sales_amount'];
			$buyers = array();

			if (!empty($orderDetails['borrower'])) {
				$primary_owner = explode(' ', $orderDetails['borrower']);
				$buyers[] = array (
					'NameID' => $orderDetails['westcor_secondary_buyer_id'] ? $orderDetails['westcor_secondary_buyer_id'] : 0,
					'Last' => $primary_owner[1],
					'First' => $primary_owner[0],
					'NameType' => 1,
					'JoiningPhrase' => 'single',
					'tvid' => 0,
					'Sequence' => 1,
					'City' => null,
					'State' => null,
					'Zip' => null,
					'Address' => null
				);	
			} 
			if (!empty($orderDetails['secondary_borrower'])) {
				$secondary_owner = explode(' ', $orderDetails['secondary_borrower']);
				$buyers[] = array (
					'NameID' => $orderDetails['westcor_secondary_buyer_id'] ? $orderDetails['westcor_secondary_buyer_id'] : 0,
					'Last' => $secondary_owner[1],
					'First' => $secondary_owner[0],
					'NameType' => 1,
					'JoiningPhrase' => 'single',
					'tvid' => 0,
					'Sequence' => 2,
					'City' => null,
					'State' => null,
					'Zip' => null,
					'Address' => null
				);	
			} 
		} else {
			$buyers[] = array (
				'NameID' => $orderDetails['westcor_buyer_id'] ? $orderDetails['westcor_buyer_id'] : 0,
				'Last' => $primary_owner[1],
				'First' => $primary_owner[0],
				'NameType' => 1,
				'JoiningPhrase' => 'single',
				'tvid' => 0,
				'Sequence' => 1,
				'City' => $orderDetails['property_city'] ? $orderDetails['property_city'] : trim($propertyDetail[2]),
				'State' => $orderDetails['property_state'] ? $orderDetails['property_state'] : trim($propertyDetail[3]),
				'Zip' => $orderDetails['property_zip'] ? $orderDetails['property_zip'] : trim($propertyDetail[4]),
				'Address' => $orderDetails['address'] ? $orderDetails['address'] : trim($propertyDetail[0])." ".trim($propertyDetail[1])
			);
			if(!empty($secondary_owner)) {
				$buyers[] = array (
					'NameID' => $orderDetails['westcor_secondary_buyer_id'] ? $orderDetails['westcor_secondary_buyer_id'] : 0,
					'Last' => $secondary_owner[1],
					'First' => $secondary_owner[0],
					'NameType' => 1,
					'JoiningPhrase' => 'single',
					'tvid' => 0,
					'Sequence' => 2,
					'City' => $orderDetails['property_city'] ? $orderDetails['property_city'] : trim($propertyDetail[2]),
					'State' => $orderDetails['property_state'] ? $orderDetails['property_state'] : trim($propertyDetail[3]),
					'Zip' => $orderDetails['property_zip'] ? $orderDetails['property_zip'] : trim($propertyDetail[4]),
					'Address' => $orderDetails['address'] ? $orderDetails['address'] : trim($propertyDetail[0])." ".trim($propertyDetail[1])
				);	
			}
			$purchase_price = $orderDetails['loan_amount'];
			$sellers = array();
		}

		if (!empty($orderDetails['escrow_lender_id'])) {
			$lenders[] =  array (
				'Id' =>  $orderDetails['westcor_lender_id'] ? $orderDetails['westcor_lender_id'] : 0,
				'tvid' => 0,
				'name' => $orderDetails['lender_first_name']." ".$orderDetails['lender_last_name'],
				'city' => $orderDetails['lender_city'],
				'state' => 'CA',
				'zip' => $orderDetails['lender_zipcode'],
				'address' => $orderDetails['lender_address'],
				'phone' => $orderDetails['lender_telephone_no'],
				'email' => $orderDetails['lender_email'],
				'countyFIPS' => null,
				'assignment' => null,
				'mortgageType' => null,
				'amount' => 0,
				'loan_number' => $orderDetails['property_zip'] ? $orderDetails['property_zip'] : trim($propertyDetail[4]),
				'vendorInternalID' => $orderDetails['escrow_lender_id']
			);
		} 
		
		$cplPostData = array (
			'tvid' =>  0,
			'agentnumber' => $resToken['agent_number'],
			'agent_file_number' => $orderDetails['file_number'],
			'email_requestor' => $orderUser['email_address'],
			'purchase_price' => $purchase_price,
			'property' =>  $propery,
			'buyers' => $buyers,
			'sellers' => $sellers,
			'lenders' => $lenders,
			'search' => null,
			'commitment' => null,
			'jacket' => null,
			'sdn' => null,
			'history' => null,
			'notes' => !empty($orderDetails['addtional_details']) ? $orderDetails['addtional_details'] : null,
			'messages' => array(
				'success' => [],
				'warning' => [],
				'error' => []
			),
			'actions' =>  array (
				'sdn' => false,
				'update_base' => true,
				'update_property' => true,
				'update_lender' => true,
				'update_buyers' => true,
				'update_sellers' => true,
				'update_attorneys' => false,
				'update_cpls' => false,
				'update_jacket' => false,
				'update_search' => false,
				'update_reinsurance' => false,
				'update_priors' => false,
			),
			'partnerCode' => (int)getenv('WESTCORE_INTEGRATION_PARTNER'),
			'cpl' => null,
			'priors' => null
		);

		if(empty($orderDetails['westcor_order_id'])) {
			$endPointCreateOrder = 'VendorApi/Order/Update/'.getenv('WESTCORE_INTEGRATION_PARTNER');
			$cplPostData = json_encode($cplPostData);
			$res = array();
			$logid = $this->apiLogs->syncLogs($userdata['id'], 'westcor', 'create_cpl_order', getenv('WESTCORE_URL').$endPointCreateOrder, $cplPostData, array(), $orderDetails['order_id'], 0);
			$result = $this->westcor->make_request('POST', $endPointCreateOrder, $cplPostData, 0, $resToken['token']);
			$this->apiLogs->syncLogs($userdata['id'], 'westcor', 'create_cpl_order', getenv('WESTCORE_URL').$endPointCreateOrder, $cplPostData, $result, $orderDetails['order_id'], $logid);
			$res = json_decode($result, true);
			if(is_array($res)) {
				if ($res['Message']) {
					$errors[] = $res['Message'];
					$data = array(
						"errors" =>  $errors,
						"success" => $success
					);
					$this->session->set_userdata($data);
					redirect(base_url().'cpl-dashboard');
				}
				$order_details = array(
					'westcor_order_id'	=> $res['tvid'],
					'westcor_buyer_id'  => !empty($res['buyers']) ? $res['buyers'][0]['NameID'] : 0,
					'westcor_seller_id'  => !empty($res['sellers']) ? $res['sellers'][0]['NameID'] : 0,
					'westcor_secondary_buyer_id'  => !empty($res['buyers']) ? $res['buyers'][1]['NameID'] : 0,
					'westcor_secondary_seller_id'  => !empty($res['sellers']) ? $res['sellers'][1]['NameID'] : 0,
					'westcor_lender_id' => !empty($res['lenders']) ? $res['lenders'][0]['Id']: 0,
				);
				$condition = array(
					'id' => $orderDetails['order_id']
				);
				if(!empty($buyers)) {
					$buyers[0]['NameID'] = !empty($res['buyers']) ? $res['buyers'][0]['NameID'] : 0;
					if(!empty($secondary_owner)) { 
						$buyers[1]['NameID'] = !empty($res['buyers']) ? $res['buyers'][1]['NameID'] : 0;
					}
				}

				if(!empty($sellers)) {
					$sellers[0]['NameID'] = !empty($res['sellers']) ? $res['sellers'][0]['NameID'] : 0;
					if(!empty($secondary_owner)) { 
						$sellers[1]['NameID'] = !empty($res['sellers']) ? $res['sellers'][1]['NameID'] : 0;
					}
				}

				$lenders[0]['Id'] = !empty($res['lenders']) ? $res['lenders'][0]['Id']: 0;
				
				$this->home_model->update($order_details, $condition, 'order_details');
				$this->home_model->update(array('westcor_property_id' => !empty($res['property']) ? $res['property'][0]['PropertyID'] : 0), array('id' => $orderDetails['property_id']), 'property_details');
				$orderDetails['westcor_order_id'] = $res['tvid'];
				$orderDetails['westcor_buyer_id']  = !empty($res['buyers']) ? $res['buyers'][0]['NameID'] : 0;
				$orderDetails['westcor_seller_id']  = !empty($res['sellers']) ? $res['sellers'][0]['NameID'] : 0;
				$orderDetails['westcor_secondary_buyer_id']  = !empty($res['buyers']) ? $res['buyers'][1]['NameID'] : 0;
				$orderDetails['westcor_secondary_seller_id']  = !empty($res['sellers']) ? $res['sellers'][1]['NameID'] : 0;
				$orderDetails['westcor_lender_id'] = !empty($res['lenders']) ? $res['lenders'][0]['Id']: 0;

			} else {
				$errors[] = $result;
				$data = array(
					"errors" =>  $errors,
					"success" => $success
				);
				$this->session->set_userdata($data);
				redirect(base_url().'cpl-dashboard');
			}
		}
		
		if(!empty($orderDetails['westcor_order_id'])) {
			$res = array();
			$endPointGetOrdeData = 'VendorApi/Order/'.$orderDetails['westcor_order_id'].'/'.getenv('WESTCORE_INTEGRATION_PARTNER');
			$logid = $this->apiLogs->syncLogs($userdata['id'], 'westcor', 'get_order_data', getenv('WESTCORE_URL').$endPointGetOrdeData, array(), array(), $orderDetails['order_id'], 0);
			$resultForGetOrderData = $this->westcor->make_request('GET', $endPointGetOrdeData, array(), 0, $resToken['token']);
			$this->apiLogs->syncLogs($userdata['id'], 'westcor', 'get_order_data', getenv('WESTCORE_URL').$endPointGetOrdeData, array(), $resultForGetOrderData, $orderDetails['order_id'], $logid);	
			$res = json_decode($resultForGetOrderData, true);
			$res['cpl'] = array();
			

			$resCPL = array();
			$endPointForCPL = 'VendorApi/ClosingLetters/PrepareAddCPL/'.$orderDetails['westcor_order_id'].'/'.getenv('WESTCORE_INTEGRATION_PARTNER');
			$logid = $this->apiLogs->syncLogs($userdata['id'], 'westcor', 'get_cpl_data', getenv('WESTCORE_URL').$endPointForCPL, array(), array(), $orderDetails['order_id'], 0);
			$cplData = $this->westcor->make_request('GET', $endPointForCPL, array(), 0, $resToken['token']);
			$this->apiLogs->syncLogs($userdata['id'], 'westcor', 'get_cpl_data', getenv('WESTCORE_URL').$endPointForCPL, array(), $cplData, $orderDetails['order_id'], $logid);	
			$resCPL = json_decode($cplData, true);
			
			$resCPL['CPL']['LetterName'] = $resCPL['CPL']['Forms'][1]['FormName'];
			$resCPL['CPL']['FileInformation'] = null;
			$resCPL['CPL']['CPLID'] = -1;
			$resCPL['CPL']['LenderID'] = $orderDetails['westcor_lender_id'];
			$resCPL['CPL']['PolicyProducingAgentAddressID'] = $resToken['agent_number'];
			$resCPL['CPL']['PolicyProducingAgentAddress'] = $resToken['address'];
			$resCPL['CPL']['PolicyProducingAgentCity'] = $resToken['city'];
			$resCPL['CPL']['PolicyProducingAgentState'] = $resToken['state'];
			$resCPL['CPL']['PolicyProducingAgentZip'] = $resToken['zip'];
			
						
			// $cpl[] = array (
			// 	'TVID' => $res['tvid'],
			// 	'CPLID' => -1,
			// 	'FileInformation' => null,
			// 	'LetterName' => 'ALTA CPL Single Trans 2018 2.0',
			// 	'IssueDate' => date('Y-m-d H:i:s'),
			// 	'CancelDate' => null,
			// 	'CancelReason' => null,
			// 	'CancelUser' => null,
			// 	'CreatedBy'=> null,
			// 	'PolicyProducingAgentNumber' => $resToken['agent_number'],
			// 	'PolicyProducingAgentAddressID' => $resToken['agent_number'],
			// 	'PolicyProducingAgentName' => $resToken['agency_name'],
			// 	'PolicyProducingAgentAddress' => $resToken['address'],
			// 	'PolicyProducingAgentCity' => $resToken['city'],
			// 	'PolicyProducingAgentState' => $resToken['state'],
			// 	'PolicyProducingAgentZip' => $resToken['zip'],
			// 	'ClosingAgentNumber'=> null,
			// 	'ClosingAgentAddressID'=> null,
			// 	'ClosingAgentName'=> null,
			// 	'ClosingAgentAddress'=> null,
			// 	'ClosingAgentCity'=> null,
			// 	'ClosingAgentState'=> null,
			// 	'ClosingAgentZip'=> null,
			// 	'IsAuthorizedforDualCPLs' => false,
			// 	'IsDualCPL' => false,
			// 	'LenderID' => !empty($res['lenders']) ? $res['lenders'][0]['Id'] : 0,
			// 	'CustomFields'=> null,
			// 	'DualCombinedInfo'=> [],
			// 	'ProtectBorrower' => false,
			// 	'ProtectBuyer' => false,
			// 	'ProtectLender' => true,
			// 	'ProtectSeller' => false,
			// 	'ProtectSeller'=> false,
			// 	'ProtectAnyone'=> false,
			// 	'ProtectAnyoneValue'=> null,
			// 	'FreeInfoText'=> 'Some additional information about the closing would go here.',
			// 	'AdditionalAgencyLocationsJSON'=> null,
			// 	'ShowAdditionalAgencyLocations'=> false
			// ) ;

			$res['cpl'][] = $resCPL['CPL'];
			$res['lenders'] = $lenders;
			$res['buyers'] = $buyers;
			$res['sellers'] = $sellers;
			$res['actions']['update_cpls'] = true;
			$res['actions']['update_buyers'] = true;
			$res['actions']['update_sellers'] = true;
			$res['actions']['update_lender'] = true;
			$res['purchase_price']= $purchase_price;
			
			$generateCplPostData = json_encode($res);
			$endPointCreateCPL = 'VendorApi/Order/Update/'.getenv('WESTCORE_INTEGRATION_PARTNER');
			$resultResCPL = array();
			$logid = $this->apiLogs->syncLogs($userdata['id'], 'westcor', 'generate_cpl', getenv('WESTCORE_URL').$endPointCreateCPL, $generateCplPostData, array(), $orderDetails['order_id'], 0);
			$resultCPL = $this->westcor->make_request('POST', $endPointCreateCPL, $generateCplPostData, 0, $resToken['token']);
			$this->apiLogs->syncLogs($userdata['id'], 'westcor', 'generate_cpl', getenv('WESTCORE_URL').$endPointCreateCPL, $generateCplPostData, $resultCPL, $orderDetails['order_id'], $logid);
			$resultResCPL = json_decode($resultCPL, true);

			if (is_array($resultResCPL)) {
				if ($resultResCPL['Message']) {
					$errors[] = $res['Message'];
					$data = array(
						"errors" =>  $errors,
						"success" => $success
					);
					$this->session->set_userdata($data);
					redirect(base_url().'cpl-dashboard');
				}

				$cplCount = count($resultResCPL['cpl']) - 1;

				$order_details = array(
					'westcor_cpl_id'	=> $resultResCPL['cpl'][$cplCount]['CPLID'],
					'westcor_file_id'   => $resultResCPL['cpl'][$cplCount]['FileInformation']['FileAsDataVaultFileID'],
					'westcor_buyer_id'  => !empty($resultResCPL['buyers']) ? $resultResCPL['buyers'][0]['NameID'] : 0,
					'westcor_seller_id'  => !empty($resultResCPL['sellers']) ? $resultResCPL['sellers'][0]['NameID'] : 0,
					'westcor_secondary_buyer_id'  => !empty($resultResCPL['buyers']) ? $resultResCPL['buyers'][1]['NameID'] : 0,
					'westcor_secondary_seller_id'  => !empty($resultResCPL['sellers']) ? $resultResCPL['sellers'][1]['NameID'] : 0
				);

				if(!empty($resultResCPL['cpl'][$cplCount]['FileInformation']['FileAsBase64'])) {
					$cplDocumentCount = $this->document->countCplDocument($orderDetails['order_id']);
					$document_name = "westcor_".$cplDocumentCount."_".$fileId.".pdf";
					if (!is_dir('uploads/documents')) {
						mkdir('./uploads/documents', 0777, TRUE);
					}
					file_put_contents('./uploads/documents/'.$document_name, base64_decode($resultResCPL['cpl'][$cplCount]['FileInformation']['FileAsBase64']));
					$this->home_model->update(array('cpl_document_name' => $document_name), array('file_id' => $fileId), 'order_details');
				}
				
				 
				$condition = array(
					'id' => $orderDetails['order_id']
				);
	
				$this->home_model->update($order_details, $condition, 'order_details');
				$this->uploadCPLDocumentToResware($document_name, $orderDetails, $resultResCPL['cpl'][$cplCount]['FileInformation']['FileAsBase64']);
				$success[] = "Generated CPL request successfully for file number - ".$orderDetails['file_number'];
			} else {
				$errors[] = $resultCPL;
			}
		
			$data = array(
				"errors" =>  $errors,
				"success" => $success
			);
			$this->session->set_userdata($data);
			redirect(base_url().'cpl-dashboard');
		}
	}

	public function donloadCplPdf()
	{
		$userdata = $this->session->userdata('user');
		$this->load->library('order/westcor');
		$this->load->model('order/apiLogs');
		$westcor_file_id = $this->input->post('westcor_file_id');
		$westcor_order_id = $this->input->post('westcor_order_id');
		$data = array(
			'fileIDs' => [$westcor_file_id], 
			'dvid' => $westcor_order_id , 
			'toZip' => false
		);
		$data = json_encode($data, true);
		$resToken = $this->order->get_token();
		if ($resToken === false) {
			$resToken = $this->westcor->createToken($westcor_order_id);
		} 
		$endPoint = 'VendorApi/Attachments/Download/'.getenv('WESTCORE_INTEGRATION_PARTNER');
		$logid = $this->apiLogs->syncLogs($userdata['id'], 'westcor', 'get_pdf_content_cpl', getenv('WESTCORE_URL').$endPoint, $data, array(), $westcor_order_id, 0);
		$result = $this->westcor->make_request('POST', $endPoint, $data, 0, $resToken['token']);
		$this->apiLogs->syncLogs($userdata['id'], 'westcor', 'get_pdf_content_cpl', getenv('WESTCORE_URL').$endPoint, $data, $result, $westcor_order_id, $logid);
		if (isset($result) && !empty($result)) {
			echo base64_encode($result);
		}	
	}

	public function addLenderOnOrder()
	{
		$this->load->model('order/home_model');
		$this->load->library('order/resware');
		$userdata = $this->session->userdata('user');
		$file_id = $this->input->post('file_id');
		$LenderId = $this->input->post('LenderId');
		$loan_amount = $this->input->post('loan_amount');
		$loan_number = $this->input->post('loan_number');
		$first_name = $this->input->post('first_name');
		$last_name = $this->input->post('last_name');
		$primary_first_name = $this->input->post('primary_first_name');
		$primary_last_name = $this->input->post('primary_last_name');
		$primary_owner = $primary_first_name." ".$primary_last_name;
		$secondaryOwner = $first_name." ".$last_name;
		$name = explode(" ",$this->input->post('LenderName'));	
		$editFlag = $this->input->post('editFlag');
		$orderDetails = $this->order->get_order_details($file_id);
		$cplApi = $this->input->post('cpl_api');

		$lender_details = array(
			'first_name'	=> $name[0],
			'last_name'  => !empty($name[1]) ? $name[1] : '',
			'telephone_no'  => !empty($this->input->post('LenderTelephone')) ? $this->input->post('LenderTelephone') : "",
			'email_address' => !empty($this->input->post('LenderEmailAddress')) ? $this->input->post('LenderEmailAddress') : "",
			'company_name'  => !empty($this->input->post('LenderCompany')) ? $this->input->post('LenderCompany') : "",
			'street_address' => !empty($this->input->post('LenderAddress')) ? $this->input->post('LenderAddress') : "",
			'city'  => !empty($this->input->post('LenderCity')) ? $this->input->post('LenderCity') : "",
			'zip_code'  => !empty($this->input->post('LenderZipcode')) ? $this->input->post('LenderZipcode') : ""
		);
		$condition = array(
			'id' => $LenderId
		);
		$orderUser =  $this->home_model->get_user(array('id' => $orderDetails['customer_id']));
		$this->home_model->update($lender_details, $condition, 'customer_basic_details');

		$partners = array();
		$lenderUserDetails = $this->home_model->get_user(array('id' => $LenderId));
		$secondaryEmp[] = array('UserID'=> $lenderUserDetails['resware_user_id']);
		$secondaryPartners = array(
			'SecondaryEmployees'=> $secondaryEmp,
			'PartnerTypeID' => 3,
			'PartnerID' => $lenderUserDetails['partner_id'],
			'PartnerType' => array(
				'PartnerTypeID' => 3
			)
		);
		$endPoint = 'files/'.$file_id.'/partners';
		$partnerUserData = array(
			'admin_api' => 1
		);

		if ($orderUser['is_escrow'] == 1) {
			if(empty($orderDetails['escrow_lender_id'])) {
				$partners[] = $secondaryPartners;
			} else if (!empty($orderDetails['escrow_lender_id']) && $orderDetails['escrow_lender_id'] != $LenderId) {
				$partners[] = $secondaryPartners;
				$removeLenderUserDetails = $this->home_model->get_user(array('id' => $orderDetails['escrow_lender_id']));
				$removeSecondaryEmp[] = array('UserID'=> $removeLenderUserDetails['resware_user_id']);
				$removeSecondaryPartners = array(
					'SecondaryEmployees'=> $removeSecondaryEmp,
					'PartnerTypeID' => 3,
					'PartnerID' => $removeLenderUserDetails['partner_id'],
					'PartnerType' => array(
						'PartnerTypeID' => 3
					)
				);
				$removePartners[] = $removeSecondaryPartners;
				$removePartnerData = json_encode(array('Partners' => $removePartners));
				$removeLogid = $this->apiLogs->syncLogs($userdata['id'], 'resware', 'delete_partner', env('RESWARE_ORDER_API').$endPoint, $removePartnerData, array(), 0, 0);
				$resultRemovePartner = $this->resware->make_request('DELETE', $endPoint, $removePartnerData, $partnerUserData);
				$this->apiLogs->syncLogs($userdata['id'], 'resware', 'delete_partner', env('RESWARE_ORDER_API').$endPoint, $removePartnerData, $resultRemovePartner, 0, $removeLogid);
			}
		} else {
			if(empty($orderDetails['cpl_lender_id'])) {
				$partners[] = $secondaryPartners;
			} else if (!empty($orderDetails['cpl_lender_id']) && $orderDetails['cpl_lender_id'] != $LenderId) {
				$partners[] = $secondaryPartners;
				$removeLenderUserDetails = $this->home_model->get_user(array('id' => $orderDetails['cpl_lender_id']));
				$removeSecondaryEmp[] = array('UserID'=> $removeLenderUserDetails['resware_user_id']);
				$removeSecondaryPartners = array(
					'SecondaryEmployees'=> $removeSecondaryEmp,
					'PartnerTypeID' => 3,
					'PartnerID' => $removeLenderUserDetails['partner_id'],
					'PartnerType' => array(
						'PartnerTypeID' => 3
					)
				);
				$removePartners[] = $removeSecondaryPartners;
				$removePartnerData = json_encode(array('Partners' => $removePartners));
				$removeLogid = $this->apiLogs->syncLogs($userdata['id'], 'resware', 'delete_partner', env('RESWARE_ORDER_API').$endPoint, $removePartnerData, array(), 0, 0);
				$resultRemovePartner = $this->resware->make_request('DELETE', $endPoint, $removePartnerData, $partnerUserData);
				$this->apiLogs->syncLogs($userdata['id'], 'resware', 'delete_partner', env('RESWARE_ORDER_API').$endPoint, $removePartnerData, $resultRemovePartner, 0, $removeLogid);
			}
		}

		if(!empty($partners)) {
			$partnerData = json_encode(array('Partners' => $partners));
			$logid = $this->apiLogs->syncLogs($userdata['id'], 'resware', 'add_partner', env('RESWARE_ORDER_API').$endPoint, $partnerData, array(), 0, 0);
			$resultPartner = $this->resware->make_request('POST', $endPoint, $partnerData, $partnerUserData);
			$this->apiLogs->syncLogs($userdata['id'], 'resware', 'add_partner', env('RESWARE_ORDER_API').$endPoint, $partnerData, $resultPartner, 0, $logid);
		}

		if ($orderDetails['sales_amount'] > 0) { 

			if ($orderUser['is_escrow'] == 1) {
				$propertyDetails = array('escrow_lender_id' => $LenderId);
			} else {
				$propertyDetails = array('cpl_lender_id' => $LenderId);
			}
			$this->home_model->update(array('loan_amount' => $loan_amount, 'loan_number' => $loan_number, 'borrower' => $primary_owner, 'secondary_borrower' => $secondaryOwner), array('id' => $orderDetails['transaction_id']), 'transaction_details');

			if ($cplApi == 'fnf') {
				$propertyDetails['buyer_agent_id'] = $this->input->post('agent_id');
				$this->home_model->update(array('fnf_agent_id' => $this->input->post('branch')), array('id' => $orderDetails['order_id']), 'order_details');
			}
			$this->home_model->update($propertyDetails, array('id' => $orderDetails['property_id']), 'property_details');
		} else {

			if ($orderUser['is_escrow'] == 1) {
				$propertyDetails = array('escrow_lender_id' => $LenderId, 'primary_owner' => $primary_owner, 'secondary_owner' => $secondaryOwner);
			} else {
				$propertyDetails = array('cpl_lender_id' => $LenderId, 'primary_owner' => $primary_owner, 'secondary_owner' => $secondaryOwner);
			}
			$this->home_model->update(array('loan_amount' => $loan_amount, 'loan_number' => $loan_number), array('id' => $orderDetails['transaction_id']), 'transaction_details');
			
			if ($cplApi == 'fnf') {
				$propertyDetails['buyer_agent_id'] = $this->input->post('agent_id');
				$this->home_model->update(array('fnf_agent_id' => $this->input->post('branch')), array('id' => $orderDetails['order_id']), 'order_details');
			}
			$this->home_model->update($propertyDetails, array('id' => $orderDetails['property_id']), 'property_details');
		}
	
		$this->home_model->update(array('is_regenerate_cpl' => $editFlag), array('id' => $orderDetails['order_id']), 'order_details');
		if ($cplApi == 'fnf') {
			redirect(base_url()."create-cpl-for-fnf/".$file_id);
		} else if ($cplApi == 'westcor') {
			redirect(base_url()."create-cpl/".$file_id);
		} else {
			redirect(base_url()."create-cpl-for-natic/".$file_id);
		}
	}

	public function add_order_details()
	{
		$orderId = isset($_POST['orderId']) && !empty($_POST['orderId']) ? $_POST['orderId'] : '';

		if($orderId)
		{
			$this->load->model('order/home_model');

			$TitleOfficer = isset($_POST['TitleOfficer']) && !empty($_POST['TitleOfficer']) ? $_POST['TitleOfficer'] : '';
			$loan_number = isset($_POST['loan_number']) && !empty($_POST['loan_number']) ? $_POST['loan_number'] : '';
			$borrower = isset($_POST['borrower']) && !empty($_POST['borrower']) ? $_POST['borrower'] : '';
			$secondary_borrower = isset($_POST['secondary_borrower']) && !empty($_POST['secondary_borrower']) ? $_POST['secondary_borrower'] : '';
			$LenderId = isset($_POST['LenderId']) && !empty($_POST['LenderId']) ? $_POST['LenderId'] : '';
			$fileId = isset($_POST['fileId']) && !empty($_POST['fileId']) ? $_POST['fileId'] : '';
			$s_report_date = isset($_POST['s_report_date']) && !empty($_POST['s_report_date']) ? $_POST['s_report_date'] : '';
			$p_report_date = isset($_POST['p_report_date']) && !empty($_POST['p_report_date']) ? $_POST['p_report_date'] : '';
			$transaction_id = isset($_POST['transaction_id']) && !empty($_POST['transaction_id']) ? $_POST['transaction_id'] : '';
			$property_id = isset($_POST['property_id']) && !empty($_POST['property_id']) ? $_POST['property_id'] : '';

			$orderDetails = $this->order->get_order_details($fileId);
			$sales_amount = isset($orderDetails['sales_amount']) && !empty($orderDetails['sales_amount']) ? $orderDetails['sales_amount'] : '';

			if(isset($sales_amount) && !empty($sales_amount))
			{
				$update_data = array();
				if($borrower)
				{
					$update_data['borrower'] = $borrower;
				}
				if($secondary_borrower)
				{
					$update_data['secondary_borrower'] = $secondary_borrower;
				}
				$condition = array(
					'id' => $transaction_id
				);
				$borrower_update_flag = $this->home_model->update($update_data, $condition, 'transaction_details');
			}
			else if(isset($orderDetails['loan_amount']) && !empty($orderDetails['loan_amount']))
			{
				$update_data = array();
				if($borrower)
				{
					$update_data['primary_owner'] = $borrower;
				}
				if($secondary_borrower)
				{
					$update_data['secondary_owner'] = $secondary_borrower;
				}

				$condition = array(
					'id' => $property_id
				);

				$owner_update_flag = $this->home_model->update($update_data, $condition, 'property_details');
			}


			if((isset($TitleOfficer) && !empty($TitleOfficer)) || (isset($loan_number) && !empty($loan_number)) || (isset($s_report_date) && !empty($s_report_date)) || (isset($p_report_date) && !empty($p_report_date)))
			{				

				$update_data = array();
				if($TitleOfficer)
				{
					$update_data['title_officer'] = $TitleOfficer;
				}
				if($loan_number)
				{
					$update_data['loan_number'] = $loan_number;
				}
				if($borrower)
				{
					$update_data['borrower'] = $borrower;
				}
				if($s_report_date)
				{
					$update_data['supplemental_report_date'] = date("Y-m-d",strtotime($s_report_date));
				}
				if($p_report_date)
				{
					$update_data['preliminary_report_date'] = date("Y-m-d",strtotime($p_report_date));
				}

				$condition = array(
					'id' => $transaction_id
				);
				$transaction_update_flag = $this->home_model->update($update_data, $condition, 'transaction_details');
			}
			
			if(isset($LenderId) && !empty($LenderId))
			{
				$update_data = array();			
				$update_data['escrow_lender_id'] = $LenderId;		

				$condition = array(
					'id' => $property_id
				);

				$property_update_flag = $this->home_model->update($update_data, $condition, 'property_details');
			}
			if($property_update_flag || $transaction_update_flag || $borrower_update_flag || $owner_update_flag)
			{
				$data = array('status'=>'success', 'fileId'=>$fileId);
			}
			else
			{
				$data = array('status'=>'error');
			}
			echo json_encode($data); exit;
		}
	}

	public function get_orders_prelim()
	{
		$params = array();  $data = array();

		if (isset($_POST['draw']) && !empty($_POST['draw'])) {
			$params['draw'] = isset($_POST['draw']) && !empty($_POST['draw']) ? $_POST['draw'] : 10;
			$params['length'] = isset($_POST['length']) && !empty($_POST['length']) ? $_POST['length'] : 2;
			$params['start'] = isset($_POST['start']) && !empty($_POST['start']) ? $_POST['start'] : 0;
			$params['orderColumn'] = isset($_POST['order'][0]['column']) && !empty($_POST['order'][0]['column']) ? $_POST['order'][0]['column'] : 0;
			$params['orderDir'] = isset($_POST['order'][0]['dir']) && !empty($_POST['order'][0]['dir']) ? $_POST['order'][0]['dir'] : 0;
			$params['searchvalue'] = isset($_POST['search']['value']) && !empty($_POST['search']['value']) ? $_POST['search']['value'] : '';
			$pageno = ($params['start'] / $params['length'])+1;
			$order_lists = $this->order->get_orders($params);
			$json_data['draw'] = intval( $params['draw'] );
		} else {
			$params['searchvalue'] = isset($_POST['keyword']) && !empty($_POST['keyword']) ? $_POST['keyword'] : '';
			$order_lists = $this->order->get_orders($params);
		}
		
		if (isset($order_lists['data']) && !empty($order_lists['data'])) {
			$i = $params['start'] + 1;
			foreach ($order_lists['data'] as $order)  {
				$nestedData = array();
				$nestedData[] = $i;
				$nestedData[] = $order['file_number'];
				$nestedData[] = $order['full_address'];
				
				if ($order['prelim_summary_id'] != 0) {
					$nestedData[] = "<a href='".base_url()."review-file/".$order['file_id']."'><button class='btn btn-grad-2a button-color' type='button'>REVIEW FILE</button></a>";
				} else {
					$nestedData[] = "<a href='javascript:void(0)'><button class='btn btn-grad-2a' style='background: #d35411;' type='button'>Not Ready</button></a>";
				}
				
				
				$data[] = $nestedData; 
				$i++; 
			}
		}

		$json_data['recordsTotal'] = intval( $order_lists['recordsTotal'] );
		$json_data['recordsFiltered'] = intval( $order_lists['recordsFiltered'] );
		$json_data['data'] = $data;
		echo json_encode($json_data);
	}

	public function review_file()
	{
		$prelimDocument = array();
		$linked_doc = array();
		$this->load->library('order/resware');
		$this->load->model('order/document');
		$fileId = $this->uri->segment(2);
		$data['title'] = 'Smart Dashboard | Pacific Coast Title Company';  
		$orderDetails = $this->order->get_order_details($fileId);
		$documents = $this->order->get_order_documents($fileId);
		$endPoint = 'files/'. $fileId .'/documents';
		$userdata = $this->session->userdata('user');
		$logid = $this->apiLogs->syncLogs($userdata['id'], 'resware', 'get_documents', env('RESWARE_ORDER_API').$endPoint, array(), array(), $orderDetails['order_id'], 0);
		if ($userdata['is_master'] == 1) {
			$orderUser =  $this->home_model->get_user(array('id' => $orderDetails['customer_id']));
			$user_data['email'] = $orderUser['email_address'];
			$user_data['password'] = $orderUser['random_password'];
		} else {
			$user_data = array();
		}
		$resultDocuments = $this->resware->make_request('GET', $endPoint, '', $user_data);
		$this->apiLogs->syncLogs($userdata['id'], 'resware', 'get_documents', env('RESWARE_ORDER_API').$endPoint, array(), $resultDocuments, $orderDetails['order_id'], $logid);
		$resDocuments = json_decode($resultDocuments, true);
		$documentCount  = count($documents);
		
		if (!empty($documents)) {
			$apiDocumentIds = array_column($documents, 'api_document_id');
			if (!empty($resDocuments['Documents'])) {
				foreach($resDocuments['Documents'] as $resDocument) {
					$ext = end(explode('.', $resDocument['DocumentName']));
					if (!in_array($resDocument['DocumentID'], $apiDocumentIds)) {
						$time = round((int)(str_replace("-0000)/", "", str_replace("/Date(", "", $resDocument['CreateDate'])))/1000);
						$created_date = date('Y-m-d H:i:s', $time);
						$document_name = date('YmdHis')."_".$resDocument['DocumentName'];
						if (($resDocument['DocumentType']['DocumentTypeID'] == 1032 || $resDocument['DocumentType']['DocumentTypeID'] == '1032' || strpos($resDocument['DocumentName'], 'Prelim') !== false) && (strtolower($ext) == 'doc' || strtolower($ext) == 'docx')) {
							$is_prelim_document = 1;
							$document_name = str_replace($ext, 'pdf', $document_name);
						} else {
							$is_prelim_document = 0;
							if(strtolower($ext) == 'doc' || strtolower($ext) == 'docx') {
								$document_name = str_replace($ext, 'pdf', $document_name);
							}
						}
						$documentData = array(
							'document_name' => $document_name,
							'original_document_name' => $resDocument['DocumentName'],
							'document_type_id' => $resDocument['DocumentType']['DocumentTypeID'],
							'api_document_id' => $resDocument['DocumentID'],
							'document_size' => $resDocument['Size'],
							'user_id' => $userdata['id'],
							'order_id' => $orderDetails['order_id'],
							'description' => $resDocument['DocumentName'],
							'created' => $created_date,
							'is_sync' => 0,
							'is_prelim_document' => $is_prelim_document
						);
						$documentId = $this->document->insert($documentData);

						if($is_prelim_document == 1) {
							$prelimDocument['original_document_name'] = $resDocument['DocumentName'];
							$prelimDocument['document_name'] = $document_name;
							$prelimDocument['api_document_id'] = $resDocument['DocumentID'];
							$prelimDocument['is_sync'] = 0;
							$prelimDocument['order_id'] = $orderDetails['order_id'];
							$prelimDocument['is_prelim_document'] =  $is_prelim_document;

							$endPoint = 'documents/'.$resDocument['DocumentID'].'?format=json';
							$logid = $this->apiLogs->syncLogs($userdata['id'], 'resware', 'get_document', env('RESWARE_ORDER_API').$endPoint, array(), array(), $orderDetails['order_id'], 0);
							$resultDocument = $this->resware->make_request('GET', $endPoint, '', $user_data);
							$this->apiLogs->syncLogs($userdata['id'], 'resware', 'get_document', env('RESWARE_ORDER_API').$endPoint, array(), $resultDocument, $orderDetails['order_id'], $logid);
							$resDocument = json_decode($resultDocument, true);

							if (isset($resDocument['Document']) && !empty($resDocument['Document'])) { 
								$documentContent = base64_decode($resDocument['Document']['DocumentBody'], true);
								if (!is_dir('uploads/documents')) {
									mkdir('./uploads/documents', 0777, TRUE);
								}
								file_put_contents('./uploads/documents/'.$document_name, $documentContent);
								$this->document->update(array('is_sync' => 1), array('api_document_id' => $resDocument['DocumentID']));

								$source_pdf = './uploads/documents/'.$document_name;
								\Gufy\PdfToHtml\Config::set('pdftohtml.bin', './bin/pdftohtml');
								\Gufy\PdfToHtml\Config::set('pdfinfo.bin', './bin/pdfinfo');
								$pdf = new \Gufy\PdfToHtml\Pdf($source_pdf);
								$pages = array(4, 5, 6, 7, 8, 9);
								$linkedDocCount = 0;
								foreach ($pages as $page) {
									$html = $pdf->html($page);
									$total_pages = $pdf->getPages();
									$htmlDom = new DOMDocument;
									@$htmlDom->loadHTML($html);
									$links = $htmlDom->getElementsByTagName('a');
									$extractedLinks = array();
									
									foreach($links as $link) {
										$linkText = $link->nodeValue;
										$linkHref = $link->getAttribute('href');
										if(strlen(trim($linkHref)) == 0){
											continue;
										}

										if($linkHref[0] == '#'){
											continue;
										}
									
										if(strpos($linkHref, 'clients.pacificcoasttitle.com') !== false){
											$linkText = str_replace(' ', '-', $linkText); 
											$linkText = preg_replace('/[^A-Za-z0-9\-]/', '', $linkText).'.pdf';
											$document_name = date('YmdHis')."_".$linkText;
											$documentId = explode('=', $linkHref);
											if (!in_array($documentId[1], $apiDocumentIds))  {
												file_put_contents('./uploads/documents/'.$document_name, file_get_contents($linkHref));
												$fileSize = filesize('./uploads/documents/'.$document_name);
												$documentData = array(
													'document_name' => $document_name,
													'original_document_name' => $linkText,
													'document_type_id' => 0,
													'api_document_id' => $documentId[1],
													'document_size' => $fileSize,
													'user_id' => $userdata['id'],
													'order_id' => $orderDetails['order_id'],
													'description' => "",
													'created' => date('Y-m-d H:i:s'),
													'is_sync' => 1,
													'is_prelim_document' => 0,
													'is_linked_doc' => 1
												);
												$documentId = $this->document->insert($documentData);
												$linked_doc[$linkedDocCount]['original_document_name'] = $linkText;
												$linked_doc[$linkedDocCount]['document_name'] = $document_name;
												$linked_doc[$linkedDocCount]['api_document_id'] = $documentId[1];
												$linked_doc[$linkedDocCount]['is_sync'] = 1;
												$linked_doc[$linkedDocCount]['is_prelim_document'] = 0;
												$linked_doc[$linkedDocCount]['order_id'] = $orderDetails['order_id'];
											} else {
												$key = array_search($documentId[1], array_column($documents, 'api_document_id'));
												$linked_doc[$linkedDocCount]['original_document_name'] = $documents[$key]['original_document_name'];
												$linked_doc[$linkedDocCount]['document_name'] = $documents[$key]['document_name'];
												$linked_doc[$linkedDocCount]['api_document_id'] = $documents[$key]['api_document_id'];
												$linked_doc[$linkedDocCount]['is_sync'] = $documents[$key]['is_sync'];
												$linked_doc[$linkedDocCount]['is_prelim_document'] = 0;
												$linked_doc[$linkedDocCount]['order_id'] = $orderDetails['order_id'];
											}
											$linkedDocCount++;
										} else{
											continue;
										}
									}
								}
							}	
						} else {
							$documents[$documentCount]['original_document_name'] = $resDocument['DocumentName'];
							$documents[$documentCount]['document_name'] = $document_name;
							$documents[$documentCount]['api_document_id'] = $resDocument['DocumentID'];
							$documents[$documentCount]['is_sync'] = 0;
							$documents[$documentCount]['is_prelim_document'] = $is_prelim_document;
							$documents[$documentCount]['order_id'] = $orderDetails['order_id'];
							$documentCount++;
						}
					} else if (($resDocument['DocumentType']['DocumentTypeID'] == 1032 || $resDocument['DocumentType']['DocumentTypeID'] == '1032' || strpos($resDocument['DocumentName'], 'Prelim') !== false) && (strtolower($ext) == 'doc' || strtolower($ext) == 'docx')) {
						$key = array_search(1, array_column($documents, 'is_prelim_document'));
						$prelimDocument['original_document_name'] = $documents[$key]['original_document_name'];
						$prelimDocument['document_name'] = $documents[$key]['document_name'];
						$prelimDocument['api_document_id'] = $documents[$key]['api_document_id'];
						$prelimDocument['is_sync'] = $documents[$key]['is_sync'];
						$prelimDocument['order_id'] = $orderDetails['order_id'];
						array_splice($documents, $key, 1);
						$keys = array_keys(array_column($documents, 'is_linked_doc'), 1);
						$linkedDocCount = 0;
						foreach($keys as $key) {
							$linked_doc[$linkedDocCount]['original_document_name'] = $documents[$key]['original_document_name'];
							$linked_doc[$linkedDocCount]['document_name'] = $documents[$key]['document_name'];
							$linked_doc[$linkedDocCount]['api_document_id'] = $documents[$key]['api_document_id'];
							$linked_doc[$linkedDocCount]['is_sync'] = $documents[$key]['is_sync'];
							$linked_doc[$linkedDocCount]['is_prelim_document'] = 0;
							$linked_doc[$linkedDocCount]['order_id'] = $orderDetails['order_id'];
							$linkedDocCount++;
						}
					}
				}	
			}
		} else {
			if (!empty($resDocuments['Documents'])) {
				foreach($resDocuments['Documents'] as $resDocument) {
					if (!in_array($resDocument['DocumentID'], $apiDocumentIds)) {
						$time = round((str_replace("-0000)/", "", str_replace("/Date(", "", $resDocument['CreateDate'])))/1000);
						$created_date = date('Y-m-d H:i:s', $time);
						$document_name = date('YmdHis')."_".$resDocument['DocumentName'];
						$ext = end(explode('.', $resDocument['DocumentName']));
						if (($resDocument['DocumentType']['DocumentTypeID'] == 1032 || $resDocument['DocumentType']['DocumentTypeID'] == '1032' || strpos($resDocument['DocumentName'], 'Prelim') !== false) && (strtolower($ext) == 'doc' || strtolower($ext) == 'docx')) {
							$is_prelim_document = 1;
							$document_name = str_replace($ext, 'pdf', $document_name);
						} else {
							$is_prelim_document = 0;
							if(strtolower($ext) == 'doc' || strtolower($ext) == 'docx') {
								$document_name = str_replace($ext, 'pdf', $document_name);
							}
						}
						$documentData = array(
							'document_name' => $document_name,
							'original_document_name' => $resDocument['DocumentName'],
							'document_type_id' => $resDocument['DocumentType']['DocumentTypeID'],
							'api_document_id' => $resDocument['DocumentID'],
							'document_size' => $resDocument['Size'],
							'user_id' => $userdata['id'],
							'order_id' => $orderDetails['order_id'],
							'description' => $resDocument['DocumentName'],
							'created' => $created_date,
							'is_sync' => 0,
							'is_prelim_document' => $is_prelim_document
						);   
						$documentId = $this->document->insert($documentData);
						if($is_prelim_document == 1) {
							$prelimDocument['original_document_name'] = $resDocument['DocumentName'];
							$prelimDocument['document_name'] = $document_name;
							$prelimDocument['api_document_id'] = $resDocument['DocumentID'];
							$prelimDocument['is_sync'] = 0;
							$prelimDocument['is_prelim_document'] =  $is_prelim_document;
							$prelimDocument['order_id'] = $orderDetails['order_id'];

							$endPoint = 'documents/'.$resDocument['DocumentID'].'?format=json';
							$logid = $this->apiLogs->syncLogs($userdata['id'], 'resware', 'get_document', env('RESWARE_ORDER_API').$endPoint, array(), array(), $orderDetails['order_id'], 0);
							$resultDocument = $this->resware->make_request('GET', $endPoint, '', $user_data);
							$this->apiLogs->syncLogs($userdata['id'], 'resware', 'get_document', env('RESWARE_ORDER_API').$endPoint, array(), $resultDocument, $orderDetails['order_id'], $logid);
							$resDocument = json_decode($resultDocument, true);

							if (isset($resDocument['Document']) && !empty($resDocument['Document'])) { 
								$documentContent = base64_decode($resDocument['Document']['DocumentBody'], true);
								if (!is_dir('uploads/documents')) {
									mkdir('./uploads/documents', 0777, TRUE);
								}
								file_put_contents('./uploads/documents/'.$document_name, $documentContent);
								$this->document->update(array('is_sync' => 1), array('api_document_id' => $resDocument['DocumentID']));

								$source_pdf = './uploads/documents/'.$document_name;
								chmod($source_pdf, 0755);
								\Gufy\PdfToHtml\Config::set('pdftohtml.bin', getenv('PDFTOHTML_PATH'));
								\Gufy\PdfToHtml\Config::set('pdfinfo.bin', getenv('PDFTOINFO_PATH'));
								$pdf = new \Gufy\PdfToHtml\Pdf($source_pdf);
								$pages = array(4, 5, 6, 7, 8, 9);
								$linkedDocCount = 0;
								foreach ($pages as $page) {
									$html = $pdf->html($page);
									$total_pages = $pdf->getPages();
									$htmlDom = new DOMDocument();
									@$htmlDom->loadHTML($html);
									if(!$htmlDom) {
										echo 'failed to load DOM';
										exit;
									} else {
										$links = $htmlDom->getElementsByTagName('a');
										$extractedLinks = array();

										foreach($links as $link) {
											$linkText = $link->nodeValue;
											$linkHref = $link->getAttribute('href');
											if(strlen(trim($linkHref)) == 0){
												continue;
											}

											if($linkHref[0] == '#'){
												continue;
											}
										
											if(strpos($linkHref, 'clients.pacificcoasttitle.com') !== false){
												$linkText = str_replace(' ', '-', $linkText); 
												$linkText = preg_replace('/[^A-Za-z0-9\-]/', '', $linkText).'.pdf';
												$document_name = date('YmdHis')."_".$linkText;
												$documentId = explode('=', $linkHref);
												if (!in_array($documentId[1], $apiDocumentIds))  {
													file_put_contents('./uploads/documents/'.$document_name, file_get_contents($linkHref));
													$fileSize = filesize('./uploads/documents/'.$document_name);
													$documentData = array(
														'document_name' => $document_name,
														'original_document_name' => $linkText,
														'document_type_id' => 0,
														'api_document_id' => $documentId[1],
														'document_size' => $fileSize,
														'user_id' => $userdata['id'],
														'order_id' => $orderDetails['order_id'],
														'description' => "",
														'created' => date('Y-m-d H:i:s'),
														'is_sync' => 1,
														'is_prelim_document' => 0,
														'is_linked_doc' => 1
													);
													$documentId = $this->document->insert($documentData);
													$linked_doc[$linkedDocCount]['original_document_name'] = $linkText;
													$linked_doc[$linkedDocCount]['document_name'] = $document_name;
													$linked_doc[$linkedDocCount]['api_document_id'] = $documentId[1];
													$linked_doc[$linkedDocCount]['is_sync'] = 1;
													$linked_doc[$linkedDocCount]['is_prelim_document'] = 0;
													$linked_doc[$linkedDocCount]['order_id'] = $orderDetails['order_id'];
												} else {
													$key = array_search($documentId[1], array_column($documents, 'api_document_id'));
													$linked_doc[$linkedDocCount]['original_document_name'] = $documents[$key]['original_document_name'];
													$linked_doc[$linkedDocCount]['document_name'] = $documents[$key]['document_name'];
													$linked_doc[$linkedDocCount]['api_document_id'] = $documents[$key]['api_document_id'];
													$linked_doc[$linkedDocCount]['is_sync'] = $documents[$key]['is_sync'];
													$linked_doc[$linkedDocCount]['is_prelim_document'] = 0;
													$linked_doc[$linkedDocCount]['order_id'] = $orderDetails['order_id'];
												}
												$linkedDocCount++;
											} else{
												continue;
											}
										}
									}
									
								}
							}
						} else {
							$documents[$documentCount]['original_document_name'] = $resDocument['DocumentName'];
							$documents[$documentCount]['document_name'] = $document_name;
							$documents[$documentCount]['api_document_id'] = $resDocument['DocumentID'];
							$documents[$documentCount]['is_sync'] = 0;
							$documents[$documentCount]['is_prelim_document'] = $is_prelim_document;
							$documents[$documentCount]['order_id'] = $orderDetails['order_id'];
							$documentCount++;
						}
					}
				}	
			}
		}
		$data['linked_doc'] = $linked_doc;
		$data['prelimDocument'] = $prelimDocument;
		$data['orderDetails'] = $orderDetails;
		$data['documents'] = $documents;
		$this->load->view('layout/head_dashboard',$data);
		$this->load->view('order/view_review_file');
	}

	public function summary() 
	{
        $fileId = $this->input->post('fileId');
        $orderDetails = $this->order->get_order_details($fileId);
        
        $file_number = isset($orderDetails['file_number']) && !empty($orderDetails['file_number']) ? $orderDetails['file_number'] : '';
        $address = isset($orderDetails['full_address']) && !empty($orderDetails['full_address']) ? $orderDetails['full_address'] : '';
        $property_type = isset($orderDetails['property_type']) && !empty($orderDetails['property_type']) ? $orderDetails['property_type'] : '';
        /*$file_number = 'EELM-798-NR';*/
        $data['file_number'] = $file_number;

        $condition = array(
            'where' => array(
                'file_number' => $file_number,
            )
        );

		$prelim_details = $this->reviewPrelimData->get_rows($condition);

		$data = json_decode($prelim_details['resware_json'], TRUE);
		
		if(isset($data) && !empty($data))
		{
			$file_number = isset($data['FileNumber']) && !empty($data['FileNumber']) ? $data['FileNumber'] : '';

			$parcelID = isset($data['ParcelID']) && !empty($data['ParcelID']) ? $data['ParcelID'] : '';
			$vesting = isset($data['Vesting']) && !empty($data['Vesting']) ? $data['Vesting'] : '';
			$generated_date = isset($data['CommitmentEffectiveDate']) && !empty($data['CommitmentEffectiveDate']) ? date('Y-m-d H:i:s', strtotime($data['CommitmentEffectiveDate'])) : '';
			$liens = $tax = array();
			$linkedDocuments = $this->order->get_linked_documents($orderDetails['order_id']);
			if(isset($data['Liens']) && !empty($data['Liens']))
			{
				foreach ($data['Liens'] as $key => $lien) 
				{
					$language = isset($lien['Language']) && !empty($lien['Language']) ? $lien['Language'] : '';
					$language = preg_replace('/(.*):/', '<b>$1:</b>', $language);
					$language = preg_replace('/[\x00-\x09\x0B\x0C\x0E-\x1F\x7F]/', '', $language);
					if(strpos($language, 'Tax Identification No') !== false)
					{
						if(strpos($language, '_PARCELID1_') !== false) {
								foreach($linkedDocuments as $linkedDocument) {
									$href = 'href="DocumentID='.$linkedDocument['api_document_id'].'"';
									$sync = $linkedDocument['is_sync'];
									$api_document_id = $linkedDocument['api_document_id'];
									$order_id = $linkedDocument['order_id'];
									$document_name = $linkedDocument['document_name'];
									if(strpos($language, $href) !== false) {
										$onclick = "href='javascript: void(0)' style='cusror: pointer !important;' onclick='load_doc($sync, $api_document_id, $order_id)'";
										$language = str_replace($href, $onclick, $language);
									}
								}
								
								$language = str_replace("_PARCELID1_", " <strong><u>".$parcelID."</u></strong>" , $language);
							}

							$tax[] = $language;
					}
					else
					{
						$amount = isset($lien['Amount']) && !empty($lien['Amount']) ? $lien['Amount'] : '';
						$date = isset($lien['Date']) && !empty($lien['Date']) ? $lien['Date'] : '';
						$grantor = isset($lien['Grantor']) && !empty($lien['Grantor']) ? $lien['Grantor'] : '';
						$trustee = isset($lien['Trustee']) && !empty($lien['Trustee']) ? $lien['Trustee'] : '';
						$grantee = isset($lien['Grantee']) && !empty($lien['Grantee']) ? $lien['Grantee'] : '';
						$recordedDate = isset($lien['RecordedDate']) && !empty($lien['RecordedDate']) ? $lien['RecordedDate'] : '';
						$instrument = isset($lien['Instrument']) && !empty($lien['Instrument']) ? $lien['Instrument'] : '';
						if(!empty($language))
						{
							if(strpos($language, '_AMOUNT_') !== false) {
								$language = str_replace("_AMOUNT_", " ".$amount , $language);
							}
							if(strpos($language, '_DATE_') !== false) {
								$language = str_replace("_DATE_", " ".$date , $language);
							}
							if(strpos($language, '_GRANTOR_') !== false) {
								$language = str_replace("_GRANTOR_", " ".$grantor , $language);
							}
							if(strpos($language, '_TRUSTEE_') !== false) {
								$language = str_replace("_TRUSTEE_", " ".$trustee , $language);
							}
							if(strpos($language, '_GRANTEE_') !== false) {
								$language = str_replace("_GRANTEE_", " ".$grantee , $language);
							}
							if(strpos($language, '_RECORDEDDATE_') !== false) {
								$language = str_replace("_RECORDEDDATE_", " ".$recordedDate , $language);
							}
							if(strpos($language, '_INSTRUMENTONLY_') !== false) {
								foreach($linkedDocuments as $linkedDocument) {
									$href = 'href="DocumentID='.$linkedDocument['api_document_id'].'"';
									$sync = $linkedDocument['is_sync'];
									$api_document_id = $linkedDocument['api_document_id'];
									$order_id = $linkedDocument['order_id'];
									$document_name = $linkedDocument['document_name'];
									if(strpos($language, $href) !== false) {
										$onclick = "href='javascript:void(0)' style='cusror:pointer !important;' onclick='load_doc($sync, $api_document_id, $order_id)'";
										$language = str_replace($href, $onclick, $language);
									}
								}
								$language = str_replace("_INSTRUMENTONLY_", " <strong><u>".$instrument."</u></strong>" , $language);
							}
							if(strpos($language, '_PARCELID1_') !== false) {
								foreach($linkedDocuments as $linkedDocument) {
									$href = 'href="DocumentID='.$linkedDocument['api_document_id'].'"';
									$sync = $linkedDocument['is_sync'];
									$api_document_id = $linkedDocument['api_document_id'];
									$order_id = $linkedDocument['order_id'];
									$document_name = $linkedDocument['document_name'];
									if(strpos($language, $href) !== false) {
										$onclick = "href='javascript:void(0)' style='cusror:pointer !important;' onclick='load_doc($sync, $api_document_id, $order_id)'";
										$language = str_replace($href, $onclick, $language);
									}
								}
								
								$language = str_replace("_PARCELID1_", " <strong><u>".$parcelID."</u></strong>" , $language);
							}
							/*$language = str_replace("\u000b", "", $language);
							$language = str_replace("\r", "", $language);*/
							$liens[] = $language;
						}
					}
					   				
				}
			}

			$easements = array();
			if(isset($data['Easements']) && !empty($data['Easements']))
			{
				foreach ($data['Easements'] as $key => $easement) 
				{
					$language = isset($easement['Language']) && !empty($easement['Language']) ? $easement['Language'] : '';
					$language = preg_replace('/(.*):/', '<b>$1:</b>', $language);
					$language = preg_replace('/[\x00-\x09\x0B\x0C\x0E-\x1F\x7F]/', '', $language);
					/*$language = str_replace("\u000b", "", $language);
					$language = str_replace("\r", "", $language);*/
					if(!empty($language))
					{
						$easements[] = $language;
					}
				}
			}

			$requirements = array();
			if(isset($data['Requirements']) && !empty($data['Requirements']))
			{
				foreach ($data['Requirements'] as $key => $requirement) 
				{
					$language = isset($requirement['Language']) && !empty($requirement['Language']) ? $requirement['Language'] : '';
					$language = preg_replace('/(.*):/', '<b>$1:</b>', $language);
					$language = preg_replace('/[\x00-\x09\x0B\x0C\x0E-\x1F\x7F]/', '', $language);
					$amount = isset($requirement['Amount']) && !empty($requirement['Amount']) ? $requirement['Amount'] : '';
					$date = isset($requirement['Date']) && !empty($requirement['Date']) ? $requirement['Date'] : '';
					$grantor = isset($requirement['Grantor']) && !empty($requirement['Grantor']) ? $requirement['Grantor'] : '';
					$trustee = isset($requirement['Trustee']) && !empty($requirement['Trustee']) ? $requirement['Trustee'] : '';
					$grantee = isset($requirement['Grantee']) && !empty($requirement['Grantee']) ? $requirement['Grantee'] : '';
					$recordedDate = isset($requirement['RecordedDate']) && !empty($requirement['RecordedDate']) ? $requirement['RecordedDate'] : '';
					$instrument = isset($requirement['Instrument']) && !empty($requirement['Instrument']) ? $requirement['Instrument'] : '';
					
					if(strpos($language, '_AMOUNT_') !== false) {
						$language = str_replace("_AMOUNT_", " ".$amount , $language);
					}
					if(strpos($language, '_DATE_') !== false) {
						$language = str_replace("_DATE_", " ".$date , $language);
					}
					if(strpos($language, '_GRANTOR_') !== false) {
						$language = str_replace("_GRANTOR_", " ".$grantor , $language);
					}
					if(strpos($language, '_TRUSTEE_') !== false) {
						$language = str_replace("_TRUSTEE_", " ".$trustee , $language);
					}
					if(strpos($language, '_GRANTEE_') !== false) {
						$language = str_replace("_GRANTEE_", " ".$grantee , $language);
					}
					if(strpos($language, '_RECORDEDDATE_') !== false) {
						$language = str_replace("_RECORDEDDATE_", " ".$recordedDate , $language);
					}
					if(strpos($language, '_INSTRUMENTONLY_') !== false) {
						foreach($linkedDocuments as $linkedDocument) {
							$href = 'href="DocumentID='.$linkedDocument['api_document_id'].'"';
							$sync = $linkedDocument['is_sync'];
							$api_document_id = $linkedDocument['api_document_id'];
							$order_id = $linkedDocument['order_id'];
							$document_name = $linkedDocument['document_name'];
							if(strpos($language, $href) !== false) {
								$onclick = "href='javascript:void(0)' style='cusror:pointer !important;' onclick='load_doc($sync, $api_document_id, $order_id)'";
								$language = str_replace($href, $onclick, $language);
							}
						}
						$language = str_replace("_INSTRUMENTONLY_", " <strong><u>".$instrument."</u></strong>" , $language);
					}
					if(strpos($language, '_PARCELID1_') !== false) {
						foreach($linkedDocuments as $linkedDocument) {
							$href = 'href="DocumentID='.$linkedDocument['api_document_id'].'"';
							$sync = $linkedDocument['is_sync'];
							$api_document_id = $linkedDocument['api_document_id'];
							$order_id = $linkedDocument['order_id'];
							$document_name = $linkedDocument['document_name'];
							if(strpos($language, $href) !== false) {
								$onclick = "href='javascript:void(0)' style='cusror:pointer !important;' onclick='load_doc($sync, $api_document_id, $order_id)'";
								$language = str_replace($href, $onclick, $language);
							}
						}
						$language = str_replace("_PARCELID1_", " <strong><u>".$parcelID."</u></strong>" , $language);
					}
					/*$language = str_replace("\u000b", "", $language);
					$language = str_replace("\r", "", $language);*/
					if(!empty($language))
					{
						$requirements[] = $language;
					}
				}
			}
			
			$restrictions = array();
			
			if(isset($data['Restrictions']) && !empty($data['Restrictions']))
			{
				foreach ($data['Restrictions'] as $key => $restriction) 
				{

					$language = isset($restriction['Language']) && !empty($restriction['Language']) ? $restriction['Language'] : '';
					$language = preg_replace('/(.*):/', '<b>$1:</b>', $language);
					$language = preg_replace('/[\x00-\x09\x0B\x0C\x0E-\x1F\x7F]/', '', $language);
					/*$language = str_replace("\u000b", "", $language);
					$language = str_replace("\r", "", $language);*/
					if(!empty($language))
					{
						$restrictions[] = $language;
					}
				}
				
			}
			
			$summaryData = array(
				'file_number'=> $file_number,
				'vesting'=> $vesting,
				'generated_date'=> $generated_date,
				'lien'=> json_encode($liens),
				'tax'=> json_encode($tax),
				'easement'=> json_encode($easements),
				'requirements'=> json_encode($requirements),
				'restrictions'=> json_encode($restrictions),
				'resware_json' => $json,
				'parcel_id' => $parcelID
			);
			$prelim_details = $summaryData;
		}
		
        $data['prelim_details'] = array();
        if(isset($prelim_details) && !empty($prelim_details))
        {
        	$data['prelim_details'] = $prelim_details;
        }
        $data['prelim_details']['address'] = $address;
        $data['prelim_details']['property_type'] = $property_type;
        
        $results = $this->load->view('order/review_file_summary', $data, TRUE);
        echo json_encode($results, true);
	}
	
	public function prelim() 
	{
        $fileId = $this->input->post('fileId');
        $data['orderDetails'] = $this->order->get_order_details($fileId);
        $results = $this->load->view('order/review_file_prelim', $data, TRUE);
        echo json_encode($results, true);
	}

	public function load_doc() 
	{
		$this->load->model('order/document');
		$this->load->library('order/resware');
		$this->load->model('order/apiLogs');
		$userdata = $this->session->userdata('user');
		$resware_document_id = $this->input->post('resware_document_id');
		$order_id = $this->input->post('order_id');
		$documentDetail = $this->order->get_document_detail($resware_document_id);
		$is_sync = $this->input->post('is_sync');
		if ($userdata['is_master'] == 1) {
			$orderDetails = $this->order->get_rows(array('id' => $order_id));
			$orderUser =  $this->home_model->get_user(array('id' => $orderDetails['customer_id']));
			$user_data['email'] = $orderUser['email_address'];
			$user_data['password'] = $orderUser['random_password'];
		} else {
			$user_data = array();
		}
		if ($is_sync == 0) {
			$endPoint = 'documents/'.$resware_document_id.'?format=json';
			$logid = $this->apiLogs->syncLogs($userdata['id'], 'resware', 'get_document', env('RESWARE_ORDER_API').$endPoint, array(), array(), $order_id, 0);
			$resultDocument = $this->resware->make_request('GET', $endPoint, '', $user_data);
			$this->apiLogs->syncLogs($userdata['id'], 'resware', 'get_document', env('RESWARE_ORDER_API').$endPoint, array(), $resultDocument, $order_id, $logid);
			$resDocument = json_decode($resultDocument, true);
			if (isset($resDocument['Document']) && !empty($resDocument['Document'])) { 
				$documentContent = base64_decode($resDocument['Document']['DocumentBody'], true);
				if (!is_dir('uploads/documents')) {
				    mkdir('./uploads/documents', 0777, TRUE);
				}
				file_put_contents('./uploads/documents/'.$documentDetail['document_name'], $documentContent);
				$this->document->update(array('is_sync' => 1), array('api_document_id' => $resware_document_id));
			}	
		} 
		
		$data['api_document_id'] = $resware_document_id;
		$data['order_id'] = $order_id;
		$data['document_name'] = $documentDetail['document_name'];
		$data['url'] = base_url().'uploads/documents/'.$documentDetail['document_name'];
        $results = $this->load->view('order/review_file_load_doc', $data, TRUE);
        echo json_encode($results, true);
	}

	public function legal_vesting() 
	{
        $fileId = $this->input->post('fileId');
        $orderDetails = $this->order->get_order_details($fileId);
        
        $file_number = isset($orderDetails['file_number']) && !empty($orderDetails['file_number']) ? $orderDetails['file_number'] : '';
        $file_path = FCPATH.'uploads/legal-vesting/'.$file_number.'.pdf';

        $file_url = '';

		if (file_exists($file_path)) 
		{
		    $file_url = base_url().'uploads/legal-vesting/'.$file_number.'.pdf';
		} 
		else 
		{
			$this->load->model('order/titlePointData');
		    $file_id = isset($orderDetails['file_id']) && !empty($orderDetails['file_id']) ? $orderDetails['file_id'] : '';

		    $condition = array(
	            'where' => array(
	                'file_id' => $file_id,
	            )
	        );
			$titlePointDetails = $this->titlePointData->gettitlePointDetails($condition);

			$serviceId = isset($titlePointDetails[0]['cs4_service_id']) && !empty($titlePointDetails[0]['cs4_service_id']) ? $titlePointDetails[0]['cs4_service_id'] : '';
		}
        
        $data['file_url'] = $file_url;
        $data['file_number'] = $file_number;
        $data['serviceId'] = $serviceId;
        
        $results = $this->load->view('order/review_file_legal_vesting', $data, TRUE);
        echo json_encode($results, true);
	}

	public function plat_map() 
	{
        $fileId = $this->input->post('fileId');
        $orderDetails = $this->order->get_order_details($fileId);

        $file_number = isset($orderDetails['file_number']) && !empty($orderDetails['file_number']) ? $orderDetails['file_number'] : '';
        $file_path = FCPATH.'uploads/plat-map/'.$file_number.'.png';

        $file_url = '';

		if (file_exists($file_path)) 
		{
		    $file_url = base_url().'uploads/plat-map/'.$file_number.'.png';
		} 
		else
		{
			$address = isset($orderDetails['address']) && !empty($orderDetails['address']) ? $orderDetails['address'] : '';

			$locale = isset($orderDetails['property_city']) && !empty($orderDetails['property_city']) ? $orderDetails['property_city'] : '';

			$propertyState = isset($orderDetails['property_state']) && !empty($orderDetails['property_state']) ? $orderDetails['property_state'] : '';

			$PropertyZip = isset($orderDetails['property_zip']) && !empty($orderDetails['property_zip']) ? $orderDetails['property_zip'] : '';
		        
            if (($locale)) 
            {
               	if(!empty($propertyState))
                {
                    $locale .= ', '.$propertyState;
                } 
                else 
                {
                    $locale .= ', CA';
                }
            }
			
	        $data['address'] = $address;
	        $data['locale'] = $locale;
	        $data['zip'] = $PropertyZip;
		}
		
        $data['file_url'] = $file_url;
        $data['file_number'] = $file_number;

        $results = $this->load->view('order/review_file_plat_map', $data, TRUE);
        echo json_encode($results, true);
	}

	public function download_document()
	{
		$resware_document_id = $this->input->post('resware_document_id');
		$order_id = $this->input->post('order_id');
		$document_name = $this->input->post('document_name');
		$contents = file_get_contents(base_url().'uploads/documents/'.$document_name);
		$binaryData   = base64_encode($contents); 
		echo $binaryData;
	}

	public function generate_plat_map()
	{
		$response = array();
		$imagedata = isset($_POST['imagedata']) && !empty($_POST['imagedata']) ? $_POST['imagedata'] : '';
		$file_number = isset($_POST['file_number']) && !empty($_POST['file_number']) ? $_POST['file_number'] : '';
		if($imagedata)
		{
			if (!is_dir('uploads/plat-map')) 
			{
				mkdir('./uploads/plat-map', 0777, TRUE);
			}
			$path = './uploads/plat-map/'.$file_number.'.png';

			file_put_contents($path, base64_decode($imagedata,true));
			$plat_map_url = base_url().'uploads/plat-map/'.$file_number.'.png';
			$response = array('status'=>'success','plat_map_url'=>$plat_map_url);
		}
		else
		{
			$response = array('status'=>'error');
		}
		
		echo json_encode($response); exit;
	}

	public function get_order_details()
	{
		$fileId = $this->input->post('fileId');
		$data = array();
		if($fileId)
		{
			$orderDetails = $this->order->get_order_details($fileId);
			
			$data['loan_amount'] = isset($orderDetails['loan_amount']) && !empty($orderDetails['loan_amount']) ? $orderDetails['loan_amount'] : '';
			
			$sales_amount = isset($orderDetails['sales_amount']) && !empty($orderDetails['sales_amount']) ? $orderDetails['sales_amount'] : '';

			if(isset($sales_amount) && !empty($sales_amount))
			{
				$data['borrower'] = isset($orderDetails['borrower']) && !empty($orderDetails['borrower']) ? $orderDetails['borrower'] : '';

				$data['secondary_borrower'] = isset($orderDetails['secondary_borrower']) && !empty($orderDetails['secondary_borrower']) ? $orderDetails['secondary_borrower'] : '';
			}
			else if(isset($orderDetails['loan_amount']) && !empty($orderDetails['loan_amount']))
			{
				$primary_owner = isset($orderDetails['primary_owner']) && !empty($orderDetails['primary_owner']) ? $orderDetails['primary_owner'] : '';
				$secondary_owner = isset($orderDetails['secondary_owner']) && !empty($orderDetails['secondary_owner']) ? $orderDetails['secondary_owner'] : '';
				
				$data['borrower'] = $primary_owner;
				$data['secondary_borrower'] = 	$secondary_owner;
			}

			$data['escrow_lender_id'] = isset($orderDetails['escrow_lender_id']) && !empty($orderDetails['escrow_lender_id']) ? $orderDetails['escrow_lender_id'] : '';
			$data['property_id'] = isset($orderDetails['property_id']) && !empty($orderDetails['property_id']) ? $orderDetails['property_id'] : '';
			$data['transaction_id'] = isset($orderDetails['transaction_id']) && !empty($orderDetails['transaction_id']) ? $orderDetails['transaction_id'] : '';
			$data['orderId'] = isset($orderDetails['order_id']) && !empty($orderDetails['order_id']) ? $orderDetails['order_id'] : '';

			$data['fileId'] = $fileId;
			$lender = '';

			if(isset($orderDetails['lender_company_name']) && !empty($orderDetails['lender_company_name']))
			{
				$lender = $orderDetails['lender_company_name'];
			}
			if(isset($orderDetails['lender_email']) && !empty($orderDetails['lender_email']))
			{
				$lender .= " - ".$orderDetails['lender_email'];
			}
			$data['lender']= $lender;
			$data['status'] = 'success';
		}
		else
		{
			$data['status'] = 'error';
		}
		
		echo json_encode($data); exit;
	}

	
	public function update_order_details()
	{
		$orderId = isset($_POST['orderId']) && !empty($_POST['orderId']) ? $_POST['orderId'] : '';
		
		if($orderId)
		{
			$this->load->model('order/home_model');
			
			$loan_amount = isset($_POST['loan_amount']) && !empty($_POST['loan_amount']) ? $_POST['loan_amount'] : '';
			$borrower = isset($_POST['borrower']) && !empty($_POST['borrower']) ? $_POST['borrower'] : '';
			$secondary_borrower = isset($_POST['secondary_borrower']) && !empty($_POST['secondary_borrower']) ? $_POST['secondary_borrower'] : '';
			$LenderId = isset($_POST['LenderId']) && !empty($_POST['LenderId']) ? $_POST['LenderId'] : '';
			$fileId = isset($_POST['fileId']) && !empty($_POST['fileId']) ? $_POST['fileId'] : '';
			$transaction_id = isset($_POST['transaction_id']) && !empty($_POST['transaction_id']) ? $_POST['transaction_id'] : '';
			$property_id = isset($_POST['property_id']) && !empty($_POST['property_id']) ? $_POST['property_id'] : '';

			$orderDetails = $this->order->get_order_details($fileId);
			$sales_amount = isset($orderDetails['sales_amount']) && !empty($orderDetails['sales_amount']) ? $orderDetails['sales_amount'] : '';

			if(isset($sales_amount) && !empty($sales_amount))
			{
				$update_data = array();
				if($borrower)
				{
					$update_data['borrower'] = $borrower;
				}
				if($secondary_borrower)
				{
					$update_data['secondary_borrower'] = $secondary_borrower;
				}
				$condition = array(
					'id' => $transaction_id
				);
				$borrower_update_flag = $this->home_model->update($update_data, $condition, 'transaction_details');
			}
			else if(isset($orderDetails['loan_amount']) && !empty($orderDetails['loan_amount']))
			{
				$update_data = array();
				if($borrower)
				{
					$update_data['primary_owner'] = $borrower;
				}
				if($secondary_borrower)
				{
					$update_data['secondary_owner'] = $secondary_borrower;
				}

				$condition = array(
					'id' => $property_id
				);

				$owner_update_flag = $this->home_model->update($update_data, $condition, 'property_details');
			}

			if(isset($loan_amount) && !empty($loan_amount))
			{
				$update_data = array();
				
				if($loan_amount)
				{
					$update_data['loan_amount'] = $loan_amount;
				}
				$condition = array(
					'id' => $transaction_id
				);
				$transaction_update_flag = $this->home_model->update($update_data, $condition, 'transaction_details');
			}
			
			if(isset($LenderId) && !empty($LenderId))
			{
				$update_data = array();	
				
				$update_data['escrow_lender_id'] = $LenderId;

				$condition = array(
					'id' => $property_id
				);

				$property_update_flag = $this->home_model->update($update_data, $condition, 'property_details');
			}
			if($property_update_flag || $transaction_update_flag)
			{
				$data = array('status'=>'success', 'fileId'=>$fileId);
			}
			else
			{
				$data = array('status'=>'error');
			}
			echo json_encode($data); exit;
		}
	}
	public function getOrderDetailsCpl()
	{
		$this->load->library('order/fnf');
		$this->load->model('order/home_model');
		$this->load->library('order/resware');
		$fileId = $this->input->post('fileId');
		$userdata = $this->session->userdata('user');
		$orderDetails = $this->order->get_order_details($fileId);
		$orderUser =  $this->home_model->get_user(array('id' => $orderDetails['customer_id']));
			
		if ($orderUser['is_escrow'] == 1) {
			if ($orderDetails['is_escrow'] == 1) {
				$orderDetails['lender_first_name'] =  '';
				$orderDetails['lender_last_name'] ='';
				$orderDetails['lender_email'] = '';
				$orderDetails['lender_telephone_no'] = '';
				$orderDetails['lender_company_name'] = '';
				$orderDetails['lender_address'] = '';
				$orderDetails['lender_city'] = '';
				$orderDetails['lender_zipcode'] = '';
				$orderDetails['lender_id'] = '';
			} else {			
				$orderDetails['lender_first_name'] = $orderDetails['lender_first_name'] ? $orderDetails['lender_first_name'] : '';
				$orderDetails['lender_last_name'] = $orderDetails['lender_last_name'] ? $orderDetails['lender_last_name'] : '';
				$orderDetails['lender_email'] = $orderDetails['lender_email'] ? $orderDetails['lender_email'] : '';
				$orderDetails['lender_telephone_no'] = $orderDetails['lender_telephone_no'] ? $orderDetails['lender_telephone_no'] : '';
				$orderDetails['lender_company_name'] = $orderDetails['lender_company_name'] ? $orderDetails['lender_company_name'] : '';
				$orderDetails['lender_address'] = $orderDetails['lender_address'] ? $orderDetails['lender_address'] : '';
				$orderDetails['lender_city'] = $orderDetails['lender_city'] ? $orderDetails['lender_city'] : '';
				$orderDetails['lender_zipcode'] = $orderDetails['lender_zipcode'] ? $orderDetails['lender_zipcode'] : '';
				$orderDetails['lender_id'] = $orderDetails['lender_id'] ? $orderDetails['lender_id'] : '';
			}
		} else {
			if (!empty($orderDetails['cpl_lender_id'])) {
				$lenderDetails =  $this->home_model->get_user(array('id' => $orderDetails['cpl_lender_id']));
				$orderDetails['lender_first_name'] = $lenderDetails['first_name'] ? $lenderDetails['first_name'] : '';
				$orderDetails['lender_last_name'] = $lenderDetails['last_name'] ? $lenderDetails['last_name'] : '';
				$orderDetails['lender_email'] = $lenderDetails['email_address'] ? $lenderDetails['email_address'] : '';
				$orderDetails['lender_telephone_no'] = $lenderDetails['telephone_no'] ? $lenderDetails['telephone_no'] : '';
				$orderDetails['lender_company_name'] = $lenderDetails['company_name'] ? $lenderDetails['company_name'] : '';
				$orderDetails['lender_address'] = $lenderDetails['street_address'] ? $lenderDetails['street_address'] : '';
				$orderDetails['lender_city'] = $lenderDetails['city'] ? $lenderDetails['city'] : '';
				$orderDetails['lender_zipcode'] = $lenderDetails['zip_code'] ? $lenderDetails['zip_code'] : '';
				$orderDetails['lender_id'] = $lenderDetails['id'] ? $lenderDetails['id'] : '';
			} else {
				$orderDetails['lender_first_name'] =  '';
				$orderDetails['lender_last_name'] ='';
				$orderDetails['lender_email'] = '';
				$orderDetails['lender_telephone_no'] = '';
				$orderDetails['lender_company_name'] = '';
				$orderDetails['lender_address'] = '';
				$orderDetails['lender_city'] = '';
				$orderDetails['lender_zipcode'] = '';
				$orderDetails['lender_id'] = '';
			}
			$orderUser =  $this->home_model->get_user(array('id' => $orderDetails['customer_id']));
		}

		if(empty($orderDetails['lender_first_name']) && empty($orderDetails['lender_last_name'])) {
			$orderDetails['lender_name'] = '';
		} else if(empty($orderDetails['lender_first_name']) && !empty($orderDetails['lender_last_name'])) {
			$orderDetails['lender_name'] = $orderDetails['lender_last_name'];
		} else if(!empty($orderDetails['lender_first_name']) && empty($orderDetails['lender_last_name'])) {
			$orderDetails['lender_name'] = $orderDetails['lender_first_name'];
		} else if(!empty($orderDetails['lender_first_name']) && !empty($orderDetails['lender_last_name'])) {
			$orderDetails['lender_name'] = $orderDetails['lender_first_name']." ".$orderDetails['lender_last_name'];
		}

		if ($orderDetails['sales_amount'] > 0) {
			if (!empty($orderDetails['borrower'])) {
				$primary_owner = explode(' ', $orderDetails['borrower']);
				$orderDetails['primary_owner_first_name'] = !empty($primary_owner[0]) ? $primary_owner[0] : '';
				$orderDetails['primary_owner_last_name'] = !empty($primary_owner[1]) ? $primary_owner[1] : '';
			} else {
				$orderDetails['primary_owner_first_name'] = '';
				$orderDetails['primary_owner_last_name'] = '';
			}
	
			if (!empty($orderDetails['secondary_borrower'])) {
				$secondary_owner = explode(' ', $orderDetails['secondary_borrower']);
				$orderDetails['secondary_owner_first_name'] = !empty($secondary_owner[0]) ? $secondary_owner[0] : '';
				$orderDetails['secondary_owner_last_name'] = !empty($secondary_owner[1]) ? $secondary_owner[1] : '';
			} else {
				$orderDetails['secondary_owner_first_name'] = '';
				$orderDetails['secondary_owner_last_name'] = '';
			}
		} else {
			if (!empty($orderDetails['primary_owner'])) {
				$primary_owner = explode(' ', $orderDetails['primary_owner']);
				$orderDetails['primary_owner_first_name'] = !empty($primary_owner[0]) ? $primary_owner[0] : '';
				$orderDetails['primary_owner_last_name'] = !empty($primary_owner[1]) ? $primary_owner[1] : '';
			} else {
				$orderDetails['primary_owner_first_name'] = '';
				$orderDetails['primary_owner_last_name'] = '';
			}
	
			if (!empty($orderDetails['secondary_owner'])) {
				$secondary_owner = explode(' ', $orderDetails['secondary_owner']);
				$orderDetails['secondary_owner_first_name'] = !empty($secondary_owner[0]) ? $secondary_owner[0] : '';
				$orderDetails['secondary_owner_last_name'] = !empty($secondary_owner[1]) ? $secondary_owner[1] : '';
			} else {
				$orderDetails['secondary_owner_first_name'] = '';
				$orderDetails['secondary_owner_last_name'] = '';
			}
		}
		
		$endPoint = 'files/'. $fileId .'/partners';
		$logid = $this->apiLogs->syncLogs($userdata['id'], 'resware', 'get_partners', env('RESWARE_ORDER_API').$endPoint, array(), array(), $orderDetails['order_id'], 0);
		if ($userdata['is_master'] == 1) {
			$orderUser =  $this->home_model->get_user(array('id' => $orderDetails['customer_id']));
			$user_data['email'] = $orderUser['email_address'];
			$user_data['password'] = $orderUser['random_password'];
		} else {
			$user_data = array();
		}
		
		$resultPartners = $this->resware->make_request('GET', $endPoint, '', $user_data);
		$this->apiLogs->syncLogs($userdata['id'], 'resware', 'get_partners', env('RESWARE_ORDER_API').$endPoint, array(), $resultPartners, $orderDetails['order_id'], $logid);
		$resPartners = json_decode($resultPartners, true);
		if(!empty($resPartners)) {
			$key = array_search(7, array_column($resPartners['Partners'], 'PartnerTypeID'));
 			if ($resPartners['Partners'][$key]['PartnerName'] == 'North American Title Insurance Company') {
				$orderDetails['cpl_api'] = 'natic';
			} elseif ($resPartners['Partners'][$key]['PartnerName'] == 'Westcor Land Title Insurance Company') {
				$orderDetails['cpl_api'] = 'westcor';
			} else if ($resPartners['Partners'][$key]['PartnerName'] == 'Commonwealth Land Title Insurance Company') {
				$orderDetails['cpl_api'] = 'fnf';
				$agentsData = $this->fnf->getAgents();
				if ($agentsData === false) {
					$orderDetails['email'] = $orderUser['email_address'];
					$agentsData = $this->fnf->getAgentsFromApi($orderDetails);
				}
				$orderDetails['agents_data'] = $agentsData;
			} else {
				$orderDetails['cpl_api'] = 'westcor';
			}
		}
		$orderDetails['loan_amount'] = $orderDetails['loan_amount'] ? $orderDetails['loan_amount'] : '';
		$orderDetails['loan_number'] = $orderDetails['loan_number'] ? $orderDetails['loan_number'] : '';
		$response = array('status'=>'success', 'orderDetails' => $orderDetails);
		echo json_encode($response); exit;
	}

	public function createCPlForNatic()
	{
		$this->load->library('order/natic');
		$this->load->model('order/home_model');
		$this->load->model('order/document');
		$errors = array();
		$success = array();
		$userdata = $this->session->userdata('user');
		$fileId = $this->uri->segment(2);    
		$orderDetails = $this->order->get_order_details($fileId);
		$responseArr = $this->natic->getDocumentContentForCpl($fileId);
		if ($responseArr['success']) {
			$cplCount = $this->document->countCplDocument($orderDetails['order_id']);
			$document_name = "natic_".$cplCount."_".$fileId.".pdf";
			if (!is_dir('uploads/documents')) {
				mkdir('./uploads/documents', 0777, TRUE);
			}
			file_put_contents('./uploads/documents/'.$document_name, base64_decode($responseArr['content']));
			$this->home_model->update(array('cpl_document_name' => $document_name), array('file_id' => $fileId), 'order_details');
			$success[] = "Generated CPL request successfully for file number - ".$orderDetails['file_number'];
			$this->uploadCPLDocumentToResware($document_name, $orderDetails, $responseArr['content']);
		} else {
			$errors[] = $responseArr['error'];
		}
		$data = array(
			"errors" =>  $errors,
			"success" => $success
		);
		$this->session->set_userdata($data);
		redirect(base_url().'cpl-dashboard');
	}

	public function createCPlForFnf()
	{
		$this->load->library('order/fnf');
		$this->load->model('order/home_model');
		$this->load->model('order/document');
		$errors = array();
		$success = array();
		$userdata = $this->session->userdata('user');
		$fileId = $this->uri->segment(2);    
		$orderDetails = $this->order->get_order_details($fileId);
		$vendorTokenData = $this->fnf->get_vendor_token();

        if ($vendorTokenData === false) {
            $vendorTokenData = $this->fnf->generateVendorToken($orderDetails);
		}

		$userTokenData = $this->fnf->get_user_token();

        if ($userTokenData === false) {
            $userTokenData = $this->fnf->generateUserToken($orderDetails);
		}

		if (!empty($orderDetails['fnf_document_id'])) {
			$editCplResponse = $this->fnf->editCpl($orderDetails, $vendorTokenData, $userTokenData);
			if ($editCplResponse['success']) {
				$cplCount = $this->document->countCplDocument($orderDetails['order_id']);
				$document_name = "fnf_".$cplCount."_".$fileId.".pdf";
				if (!is_dir('uploads/documents')) {
					mkdir('./uploads/documents', 0777, TRUE);
				}
				file_put_contents('./uploads/documents/'.$document_name, base64_decode($editCplResponse['response']['a:Content']));
				$this->home_model->update(array('cpl_document_name' => $document_name, 'fnf_document_id' => $generateCplResponse['response']['a:DocumentId']), array('file_id' => $fileId), 'order_details');
				$success[] = "CPL document edited successfully for file number - ".$orderDetails['file_number'];
				$this->uploadCPLDocumentToResware($document_name, $orderDetails, $generateCplResponse['response']['a:Content']);
			} else {
				$errors[] = $editCplResponse['error'];
			}
			$data = array(
				"errors" =>  $errors,
				"success" => $success
			);
			$this->session->set_userdata($data);
			redirect(base_url().'cpl-dashboard');
		}

		$getCPLFormNameResponse = $this->fnf->getCPLForm($orderDetails, $vendorTokenData, $userTokenData);
		if ($getCPLFormNameResponse['success'])  {
			$key = array_search('Lender', array_column($getCPLFormNameResponse['response'], 'a:RecipientType'));
			$orderDetails['formname'] = $getCPLFormNameResponse['response'][$key]['a:FormName'];
			$generateCplResponse = $this->fnf->generateCpl($orderDetails, $vendorTokenData, $userTokenData);
			
			if ($generateCplResponse['success']) {
				$cplCount = $this->document->countCplDocument($orderDetails['order_id']);
				$document_name = "fnf_".$cplCount."_".$fileId.".pdf";
				if (!is_dir('uploads/documents')) {
					mkdir('./uploads/documents', 0777, TRUE);
				}
				file_put_contents('./uploads/documents/'.$document_name, base64_decode($generateCplResponse['response']['a:Content']));
				$this->home_model->update(array('cpl_document_name' => $document_name, 'fnf_document_id' => $generateCplResponse['response']['a:DocumentId']), array('file_id' => $fileId), 'order_details');
				$success[] = "Generated CPL request successfully for file number - ".$orderDetails['file_number'];
				$this->uploadCPLDocumentToResware($document_name, $orderDetails, $generateCplResponse['response']['a:Content']);
			} else {
				$errors[] = $generateCplResponse['error'];
			}
			$data = array(
				"errors" =>  $errors,
				"success" => $success
			);
			$this->session->set_userdata($data);
			redirect(base_url().'cpl-dashboard');
		} else {
			$errors[] = $getCPLFormNameResponse['error'];
			$data = array(
				"errors" =>  $errors,
				"success" => $success
			);
			$this->session->set_userdata($data);
			redirect(base_url().'cpl-dashboard');
		}	
	}

	public function uploadCPLDocumentToResware($document_name, $orderDetails, $binaryData)
	{
		$this->load->model('order/document');
		$this->load->library('order/resware');
		$this->load->model('order/apiLogs');
		$userdata = $this->session->userdata('user');
		$fileSize = filesize('./uploads/documents/'.$document_name);
		$documentData = array(
			'document_name' => $document_name,
			'original_document_name' => $document_name,
			'document_type_id' => 1051,
			'document_size' => $fileSize,
			'user_id' => $userdata['id'],
			'order_id' => $orderDetails['order_id'],
			'description' => 'CPL Document',
			'is_sync' => 1,
			'is_prelim_document' => 0,
			'is_cpl_doc' => 1
		);
		$documentId = $this->document->insert($documentData);
		$endPoint = 'files/'.$orderDetails['file_id'].'/documents';
		$documentApiData = array(			
			'DocumentName' => $document_name,
			'DocumentType' => array(
				'DocumentTypeID' => 1051,
			),
			'Description' => 'CPL Document',
			'InternalOnly' => false,
			'DocumentBody' => $binaryData
		);
		$document_api_data = json_encode($documentApiData, JSON_UNESCAPED_SLASHES);

		if ($userdata['is_master'] == 1) {
			$orderUser =  $this->home_model->get_user(array('id' => $orderDetails['customer_id']));
			$user_data['email'] = $orderUser['email_address'];
			$user_data['password'] = $orderUser['random_password'];
		} else {
			$user_data = array();
		}
		
		$logid = $this->apiLogs->syncLogs($userdata['id'], 'resware', 'create_document', env('RESWARE_ORDER_API').$endPoint, $documentApiData, array(), $orderDetails['order_id'], 0);
		$result = $this->resware->make_request('POST', $endPoint, $document_api_data, $user_data);
		$this->apiLogs->syncLogs($userdata['id'], 'resware', 'create_document', env('RESWARE_ORDER_API').$endPoint, $documentApiData, $result, $orderDetails['order_id'], $logid);
		$res = json_decode($result);
		$this->document->update(array('api_document_id' => $res->Document->DocumentID), array('id' => $documentId));

		$from_name = 'Pacific Coast Title Company';
		$from_mail = env('FROM_EMAIL');
		$order_message_body = 'Please check attachment for CPL document.';
		$message = $order_message_body; 
		$subject = 'CPL Document';
		$to = $orderDetails['lender_email'];
		$cc = array();
		if (!empty($orderDetails['sales_representative'])) {
			$this->db->select('*')
            	->from('pct_order_sales_rep');
			$this->db->where('id', $orderDetails['sales_representative']);
			$query = $this->db->get();
			$salesResult = $query->row_array();
			if (!empty($salesResult)) {
				$cc = array($salesResult['email_address']);
			}
		}
		$bcc = array();
		$file = array(base_url().'uploads/documents/'.$document_name);
		$this->load->helper('sendemail');
		$mail_result = send_email($from_mail,$from_name, $to, $subject, $message,$file,$cc,$bcc);
	}
}