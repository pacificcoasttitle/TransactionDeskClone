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
		$this->load->library('order/resware');
		$this->order->is_user();
	}
	
	
	function index()
	{
		$userdata = $this->session->userdata('user');
		$name = isset($userdata['name']) && !empty($userdata['name']) ? $userdata['name'] : '';
		$is_master = isset($userdata['is_master']) && !empty($userdata['is_master']) ? $userdata['is_master'] : '';
		$is_sales_rep = isset($userdata['is_sales_rep']) && !empty($userdata['is_sales_rep']) ? $userdata['is_sales_rep'] : '';
		$data['name'] = $name;
		$data['is_master'] = $is_master;
		$data['user_email'] = $userdata['email'];
		$data['is_special_lender'] = $userdata['is_special_lender'] == 1 ? 1 : 0;
		$data['is_sales_rep'] = isset($userdata['is_sales_rep']) && !empty($userdata['is_sales_rep']) ? 1 : 0;
		$data['order_lists'] = $this->order->get_recent_orders();
		$data['title'] = 'Smart Dashboard | Pacific Coast Title Company';
		
		if($is_sales_rep)
        {
        	// $data['mail_dashboard'] = 1;
        	$this->load->view('layout/head_dashboard',$data);
        	$this->load->view('order/sales_dashboard');
        }
        else
        {
        	$this->load->view('layout/head_dashboard',$data);
			$this->load->view('order/dashboard');
        }
		
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
        }

        $salesAmount = isset($orderDetails['sales_amount']) && !empty($orderDetails['sales_amount']) ? $orderDetails['sales_amount'] : '';
        
        if(isset($salesAmount) && !empty($salesAmount))
        {
            $request['SalesPrice'] = $salesAmount;
            $condition = array(
	            'where' => array(
	                'transaction_type' => 'sale',
	                'pct_order_fees.status' => 1
	            )
	        );
        }
        else
        {
        	$condition = array(
	            'where' => array(
	                'transaction_type' => 'loan',
	                'pct_order_fees.status' => 1
	            )
	        );
        }

        $fees_data = json_encode($request);
        $this->load->library('order/resware');


        $endPoint = 'estimates/closingfees';
        $logid = $this->apiLogs->syncLogs($userdata['id'], 'resware', 'get_fees', env('RESWARE_ORDER_API').$endPoint, $fees_data, array(), $orderId, 0);
        $result = $this->resware->make_request('POST', $endPoint, $fees_data);
        $this->apiLogs->syncLogs($userdata['id'], 'resware', 'get_fees', env('RESWARE_ORDER_API').$endPoint, $fees_data, $result, $orderId, $logid);

        $product_type = isset($orderDetails['product_type']) && !empty($orderDetails['product_type']) ? $orderDetails['product_type'] : '';
        $data['productType'] = $product_type;

        $fees = array();
        if(isset($result) && !empty($result))
        {
            $response = json_decode($result,TRUE);
            $closing_fee_estimate_id = isset($response['ClosingFeeEstimate']['ClosingFeeEstimateID']) && !empty($response['ClosingFeeEstimate']['ClosingFeeEstimateID']) ? $response['ClosingFeeEstimate']['ClosingFeeEstimateID'] : '';

            if(isset($response['ClosingFeeEstimate']['Premiums']) && !empty(isset($response['ClosingFeeEstimate']['Premiums'])))
            {
                foreach ($response['ClosingFeeEstimate']['Premiums'] as $k => $v) 
                {
                	if($k == 'FullLendersPremium')
                    {
                        $k = 'Stand Alone Title Policy';
                    }
                    $fees['Title Fee'][] = array('amount' => $v, 'description' => $k);
                }
            }
        }
        $feesInfo = $this->fees_model->get_rows($condition);
        
        if(isset($feesInfo) && !empty(isset($feesInfo)))
        {
            foreach ($feesInfo as $k => $v) 
            {
                $fees[$v['fee_type']][] = array('amount' => $v['value'], 'description' => $v['name']);
            }
        }

        if(strpos($product_type, 'Loan:') !== false)
        {
            if(isset($fees['Title Fee']) && !empty($fees['Title Fee']))
            {
                foreach ($fees['Title Fee'] as $key => $value)
                {
                    if($value['description'] == 'Stand Alone Title Policy')
                    {
                        unset($fees['Title Fee'][$key]);
                    }
                }
            }
        }

        $data['fees'] = $fees;
        $data['order_number'] = isset($orderDetails['file_number']) && !empty($orderDetails['file_number']) ? $orderDetails['file_number'] : '';
        $data['full_address'] = isset($orderDetails['full_address']) && !empty($orderDetails['full_address']) ? $orderDetails['full_address'] : '';
        $data['sales_amount'] = isset($orderDetails['sales_amount']) && !empty($orderDetails['sales_amount']) ? $orderDetails['sales_amount'] : '';
        $data['loan_amount'] = isset($orderDetails['loan_amount']) && !empty($orderDetails['loan_amount']) ? $orderDetails['loan_amount'] : '';
        
        $data['closing_fee_estimate_id'] = $closing_fee_estimate_id;

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
					

                	$action = '<a href="./uploads/proposed-insured/'.$documentName.'" download><button class="btn btn-grad-2a" type="button" style="background: #d35411;">Download</button></a>';
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
    	$data['fileId'] = $fileId;

		$orderDetails = $this->order->get_order_details($fileId);

	    $orderId = isset($orderDetails['order_id']) && !empty($orderDetails['order_id']) ? $orderDetails['order_id'] : '';
	    $data['orderId'] = $orderId;
	    $transaction_id = isset($orderDetails['transaction_id']) && !empty($orderDetails['transaction_id']) ? $orderDetails['transaction_id'] : '';
	    $data['transaction_id'] = $transaction_id;
	    $vesting = isset($orderDetails['vesting']) && !empty($orderDetails['vesting']) ? $orderDetails['vesting'] : '';
	    $data['vesting'] = $vesting;
	    $property_id = isset($orderDetails['property_id']) && !empty($orderDetails['property_id']) ? $orderDetails['property_id'] : '';
	    $data['property_id'] = $property_id;
	    $customer_id = isset($orderDetails['customer_id']) && !empty($orderDetails['customer_id']) ? $orderDetails['customer_id'] : '';

	    $this->load->model('order/home_model');
		$customer_data =  $this->home_model->get_user(array('id' => $customer_id));

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
		$data['sales_amount'] = isset($orderDetails['sales_amount']) && !empty($orderDetails['sales_amount']) ? $orderDetails['sales_amount'] : '';
		$data['loan_amount'] = isset($orderDetails['loan_amount']) && !empty($orderDetails['loan_amount']) ? $orderDetails['loan_amount'] : '';
		$data['loan_number'] = isset($orderDetails['loan_number']) && !empty($orderDetails['loan_number']) ? $orderDetails['loan_number'] : '';
		$data['title_officer']= isset($orderDetails['title_officer']) && !empty($orderDetails['title_officer']) ? $orderDetails['title_officer'] : '';

		if ($orderDetails['sales_amount'] > 0) 
        {
            if (!empty($orderDetails['borrower'])) {
                $orderDetails['primary_owner_name'] = $orderDetails['borrower'];
            } else {
                $orderDetails['primary_owner_name'] = '';
            }
    
            if (!empty($orderDetails['secondary_borrower'])) {
                $orderDetails['secondary_owner_name'] = $orderDetails['secondary_borrower'];
            } else {
                $orderDetails['secondary_owner_name'] = '';
            }
        } 
        else 
        {
            if (!empty($orderDetails['primary_owner'])) {
                $orderDetails['primary_owner_name'] = $orderDetails['primary_owner'];
            } else {
                $orderDetails['primary_owner_name'] = '';
            }
    
            if (!empty($orderDetails['secondary_owner'])) {
                $orderDetails['secondary_owner_name'] =  $orderDetails['secondary_owner'];
            } else {
                $orderDetails['secondary_owner_name'] = '';
            }
        }

        if(!empty($orderDetails['borrowers_vesting'])) {
            $orderDetails['borrowers_vesting'] = $orderDetails['borrowers_vesting'];
        } else {
            if (!empty($orderDetails['primary_owner_name'])) {
                $orderDetails['borrowers_vesting'] = $orderDetails['primary_owner_name'];
            } 
    
            if (!empty($orderDetails['secondary_owner_name'])) {
                $orderDetails['borrowers_vesting'] .=  " ".$orderDetails['secondary_owner_name'];
            } 

            if (!empty($orderDetails['vesting'])) {
                $orderDetails['borrowers_vesting'] .=  " ".$orderDetails['vesting'];
            } 
        }
        $data['borrowers_vesting'] = $orderDetails['borrowers_vesting'];

        /* property address */
        if(!empty($orderDetails['cpl_proposed_property_address'])) 
        {
            $data['street_address'] = isset($orderDetails['cpl_proposed_property_address']) && !empty($orderDetails['cpl_proposed_property_address']) ? $orderDetails['cpl_proposed_property_address'] : '';
        } 
        else 
        {
            $data['street_address'] = isset($orderDetails['address']) && !empty($orderDetails['address']) ? $orderDetails['address'] : '';
        }

        if(!empty($orderDetails['cpl_proposed_property_city'])) 
        {
            $data['property_city'] = isset($orderDetails['cpl_proposed_property_city']) && !empty($orderDetails['cpl_proposed_property_city']) ? $orderDetails['cpl_proposed_property_city'] : '';
        } 
        else 
        {
            $data['property_city'] = isset($orderDetails['property_city']) && !empty($orderDetails['property_city']) ? $orderDetails['property_city'] : '';
        }

        if(!empty($orderDetails['cpl_proposed_property_state'])) 
        {
            $data['property_state'] = isset($orderDetails['cpl_proposed_property_state']) && !empty($orderDetails['cpl_proposed_property_state']) ? $orderDetails['cpl_proposed_property_state'] : '';
        } 
        else 
        {
            $data['property_state'] = isset($orderDetails['property_state']) && !empty($orderDetails['property_state']) ? $orderDetails['property_state'] : '';
        }


        if(!empty($orderDetails['cpl_proposed_property_zip'])) 
        {
            $data['property_zip'] = isset($orderDetails['cpl_proposed_property_zip']) && !empty($orderDetails['cpl_proposed_property_zip']) ? $orderDetails['cpl_proposed_property_zip'] : '';
        } 
        else 
        {
            $data['property_zip'] = isset($orderDetails['property_zip']) && !empty($orderDetails['property_zip']) ? $orderDetails['property_zip'] : '';
        }
        /* property address */

		if(!empty($orderDetails['supplemental_report_date']) && $orderDetails['supplemental_report_date'] != '0000-00-00')
        {
            $s_report_date = date("m/d/Y",strtotime($orderDetails['supplemental_report_date']));
        }

		$data['supplemental_report_date']= isset($s_report_date) && !empty($s_report_date) ? $s_report_date : '';

		if(!empty($orderDetails['preliminary_report_date']) && $orderDetails['preliminary_report_date'] != '0000-00-00')
        {
            $p_report_date = date("m/d/Y",strtotime($orderDetails['preliminary_report_date']));
        }
		$data['preliminary_report_date'] = isset($p_report_date) && !empty($p_report_date) ? $p_report_date : '';

		$data['is_escrow'] = $customer_data['is_escrow'];

		if ($customer_data['is_escrow'] == 1) {
			if (!empty($orderDetails['cpl_lender_id'])) {
				$lenderDetails =  $this->home_model->get_user(array('id' => $orderDetails['cpl_lender_id']));
				$data['lender_first_name'] =  $lenderDetails['first_name'] ? $lenderDetails['first_name'] : '';
				$data['lender_last_name'] = $lenderDetails['last_name'] ? $lenderDetails['last_name'] : '';
				$data['lender_email'] = $lenderDetails['email_address'] ? $lenderDetails['email_address'] : '';
				$data['lender_state'] = $lenderDetails['state'] ? $lenderDetails['state'] : '';
				$data['lender_company_name'] = $lenderDetails['company_name'] ? $lenderDetails['company_name'] : '';
				$data['lender_address'] = $lenderDetails['street_address'] ? $lenderDetails['street_address'] : '';
				$data['lender_city'] = $lenderDetails['city'] ? $lenderDetails['city'] : '';
				$data['lender_zipcode'] = $lenderDetails['zip_code'] ? $lenderDetails['zip_code'] : '';
				$data['lender_id'] = $lenderDetails['id'] ? $lenderDetails['id'] : '';
				// $data['escrow_lender_id'] = '';
			} else {
				// $data['escrow_lender_id'] = $orderDetails['escrow_lender_id'] ? $orderDetails['escrow_lender_id'] : '';		
				$data['lender_first_name'] = $orderDetails['lender_first_name'] ? $orderDetails['lender_first_name'] : '';
				$data['lender_last_name'] = $orderDetails['lender_last_name'] ? $orderDetails['lender_last_name'] : '';
				$data['lender_email'] = $orderDetails['lender_email'] ? $orderDetails['lender_email'] : '';
				$data['lender_state'] = $orderDetails['lender_state'] ? $orderDetails['lender_state'] : '';
				$data['lender_company_name'] = $orderDetails['lender_company_name'] ? $orderDetails['lender_company_name'] : '';
				$data['lender_address'] = $orderDetails['lender_address'] ? $orderDetails['lender_address'] : '';
				$data['lender_city'] = $orderDetails['lender_city'] ? $orderDetails['lender_city'] : '';
				$data['lender_zipcode'] = $orderDetails['lender_zipcode'] ? $orderDetails['lender_zipcode'] : '';
				$data['lender_assignment_clause'] = $orderDetails['lender_assignment_clause'] ? $orderDetails['lender_assignment_clause'] : '';
				$data['lender_id'] = $orderDetails['lender_id'] ? $orderDetails['lender_id'] : '';
			}
		} else {
			if (!empty($orderDetails['cpl_lender_id'])) {
				$lenderDetails =  $this->home_model->get_user(array('id' => $orderDetails['cpl_lender_id']));

				$data['cpl_lender_id'] = $orderDetails['cpl_lender_id'];
				$data['lender_first_name'] = $lenderDetails['first_name'] ? $lenderDetails['first_name'] : '';
				$data['lender_last_name'] = $lenderDetails['last_name'] ? $lenderDetails['last_name'] : '';
				$data['lender_email'] = $lenderDetails['email_address'] ? $lenderDetails['email_address'] : '';
				$data['lender_state'] = $lenderDetails['state'] ? $lenderDetails['state'] : '';
				$data['lender_company_name'] = $lenderDetails['company_name'] ? $lenderDetails['company_name'] : '';
				$data['lender_address'] = $lenderDetails['street_address'] ? $lenderDetails['street_address'] : '';
				$data['lender_city'] = $lenderDetails['city'] ? $lenderDetails['city'] : '';
				$data['lender_zipcode'] = $lenderDetails['zip_code'] ? $lenderDetails['zip_code'] : '';
				$data['lender_assignment_clause'] = $lenderDetails['assignment_clause'] ? $lenderDetails['assignment_clause'] : '';
				$data['lender_id'] = $lenderDetails['id'] ? $lenderDetails['id'] : '';
			} else {
				// $data['cpl_lender_id'] = $customer_data['id']; 
				$data['lender_first_name'] = $customer_data['first_name'] ? $customer_data['first_name'] : '';
				$data['lender_last_name'] = $customer_data['last_name'] ? $customer_data['last_name'] : '';
				$data['lender_email'] = $customer_data['email_address'] ? $customer_data['email_address'] : '';
				$data['lender_state'] = $customer_data['state'] ? $customer_data['state'] : '';
				$data['lender_company_name'] = $customer_data['company_name'] ? $customer_data['company_name'] : '';
				$data['lender_address'] = $customer_data['street_address'] ? $customer_data['street_address'] : '';
				$data['lender_city'] = $customer_data['city'] ? $customer_data['city'] : '';
				$data['lender_zipcode'] = $customer_data['zip_code'] ? $customer_data['zip_code'] : '';
				// $data['lender_assignment_clause'] = $customer_data['assignment_clause'] ? $customer_data['assignment_clause'] : '';
				$data['lender_id'] = $customer_data['id'] ? $customer_data['id'] : '';
			}
			$orderUser =  $this->home_model->get_user(array('id' => $orderDetails['customer_id']));
		}

		if(empty($data['lender_first_name']) && empty($data['lender_last_name'])) {
			$data['lender_name'] = '';
		} else if(empty($data['lender_first_name']) && !empty($data['lender_last_name'])) {
			$data['lender_name'] = $data['lender_last_name'];
		} else if(!empty($data['lender_first_name']) && empty($data['lender_last_name'])) {
			$data['lender_name'] = $data['lender_first_name'];
		} else if(!empty($data['lender_first_name']) && !empty($data['lender_last_name'])) {
			$data['lender_name'] = $data['lender_first_name']." ".$data['lender_last_name'];
		}
		
		$response = array('status'=>'success', 'orderDetails' => $data);
		echo json_encode($response); exit;
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
				$nestedData[] = !empty($order['document_created_date']) ? date("m/d/Y", strtotime($order['document_created_date'])) : '';
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
					$nestedData[] = "<div style='display:flex;'><form onclick='return lender_pop_up(0, $file_id);' action='".base_url()."create-cpl/".$order['file_id']."' method='POST'><button class='btn btn-grad-2a generate button-color' type='submit'>GENERATE</button></form>
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

		$resToken = $this->westcor->get_token($orderDetails['fnf_agent_id'], $orderDetails['order_id']);
		$orderUser =  $this->home_model->get_user(array('id' => $orderDetails['customer_id']));

		$propertyDetail = explode(",", $orderDetails['full_address']);
		$propery[] = array (
			'PropertyID' => 0,
			'tvid' =>  0,
			'CountyName' => $orderDetails['county'].' County',
			'ShortLegal' => $orderDetails['legal_description'] ? $orderDetails['legal_description'] : null,
			'StreetAddress' => $orderDetails['cpl_proposed_property_address'],
            'City' => $orderDetails['cpl_proposed_property_city'],
            'State' => $orderDetails['cpl_proposed_property_state'],
            'Zip' => $orderDetails['cpl_proposed_property_zip'],
			'PropertyType' => 'R'
		);

		$primary_owner = explode(" ", $orderDetails['primary_owner']);
		$secondary_owner = explode(" ", $orderDetails['secondary_owner']);
		if ($orderDetails['sales_amount'] > 0)  {
			$sellerBorrowerName = $orderDetails['borrowers_vesting']; 
			$sellers[] = array (
				'NameID' =>  $orderDetails['westcor_seller_id'] ? $orderDetails['westcor_seller_id'] : 0,
				'Last' => '-',
				'First' => $sellerBorrowerName,
				'NameType' => 2,
				'JoiningPhrase' => 'single',
				'tvid' => 0,
				'Sequence' => 1,
				'City' => null,
				'State' => null,
				'Zip' => null,
				'Address' => null,
			);

			$purchase_price = $orderDetails['sales_amount'];
			$buyers = array();

			if (!empty($orderDetails['borrower'])) {

				$buyerBorrowerName = $orderDetails['borrower'];

				if(!empty($orderDetails['secondary_borrower'])) { 
					$buyerBorrowerName .= " and ".$orderDetails['secondary_borrower'];
				}
	
				$buyers[] = array (
					'NameID' => $orderDetails['westcor_secondary_buyer_id'] ? $orderDetails['westcor_secondary_buyer_id'] : 0,
					'Last' => '-',
					'First' => $buyerBorrowerName,
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
		} else {
			$buyers = array();
			$buyerBorrowerName = $orderDetails['borrowers_vesting']; 
			$buyers[] = array (
				'NameID' => $orderDetails['westcor_buyer_id'] ? $orderDetails['westcor_buyer_id'] : 0,
				'Last' => '-',
				'First' => $buyerBorrowerName,
				'NameType' => 1,
				'JoiningPhrase' => 'single',
				'tvid' => 0,
				'Sequence' => 1,
				'City' => null,
				'State' => null,
				'Zip' => null,
				'Address' => null
			);
			$purchase_price = $orderDetails['loan_amount'];
			$sellers = array();
		}

		
		$lenderDetails = $this->home_model->get_user(array('id' => $orderDetails['cpl_lender_id']));
		$name = $lenderDetails['first_name']." ".$lenderDetails['last_name'];
		if (!empty($lenderDetails)) {
			$lenders[] =  array (
				'Id' =>  $orderDetails['westcor_lender_id'] ? $orderDetails['westcor_lender_id'] : 0,
				'tvid' => 0,
				'name' => $lenderDetails['company_name'],
				'city' => $lenderDetails['city'],
				'state' => $lenderDetails['state'],
				'zip' => $lenderDetails['zip_code'],
				'address' => $lenderDetails['street_address'],
				'phone' => $lenderDetails['telephone_no'],
				'email' => $lenderDetails['email_address'],
				'countyFIPS' => null,
				'assignment' => $lenderDetails['assignment_clause'] ? $lenderDetails['assignment_clause']."\n".$name : "\n".$name,
				'mortgageType' => null,
				'amount' => 0,
				'loan_number' => $orderDetails['loan_number'] ? $orderDetails['loan_number'] : '',
				'vendorInternalID' => $lenderDetails['id']
			);
		} 
		
		
		$cplPostData = array (
			'tvid' =>  0,
			'agentnumber' => $resToken['original_agent_number'],
			'agent_file_number' => $orderDetails['file_number'],
			'email_requestor' => isset($orderUser['email_address']) && !empty($orderUser['email_address']) ? $orderUser['email_address'] : 'cpl@pct.com',
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
					$cplErrorData = array(
						'order_id' => $orderDetails['order_id'],
						'file_number' => $orderDetails['file_number'],
						'cpl_page' => 'Dashboard',
						'error' => $res['Message']
					);
					$this->order->storeCplError($cplErrorData);
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
					
				}

				if(!empty($sellers)) {
					$sellers[0]['NameID'] = !empty($res['sellers']) ? $res['sellers'][0]['NameID'] : 0;
					
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
				$cplErrorData = array(
                    'order_id' => $orderDetails['order_id'],
                    'file_number' => $orderDetails['file_number'],
                    'cpl_page' => 'Dashboard',
                    'error' => $result
                );
                $this->order->storeCplError($cplErrorData);
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
			$resCPL['CPL']['ProtectLender'] = true;
			
			$res['cpl'][] = $resCPL['CPL'];
			$res['property'] = $propery;
			$res['lenders'] = $lenders;
			$res['buyers'] = $buyers;
			$res['sellers'] = $sellers;
			$res['actions']['update_property'] = true;
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
				if ($resultResCPL['messages']['error']) {
					foreach($resultResCPL['messages']['error'] as $error) {
						$errors[] = $error;
						$cplErrorData = array(
							'order_id' => $orderDetails['order_id'],
							'file_number' => $orderDetails['file_number'],
							'cpl_page' => 'Dashboard',
							'error' => $error
						);
						$this->order->storeCplError($cplErrorData);
					}
                   
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
		$loan_number = $this->input->post('loan_number');
		$first_name = $this->input->post('first_name');
		$last_name = $this->input->post('last_name');
		$vesting = $this->input->post('vesting');
		$new_existing_lender = $this->input->post('new_existing_lender');
		$borrowers_vesting = $this->input->post('borrowers_vesting');
		$name = explode(" ",$this->input->post('LenderName'));	
		$editFlag = $this->input->post('editFlag');
		$orderDetails = $this->order->get_order_details($file_id);
		$cplApi = $this->input->post('cpl_api');

		$lender_details = array(
			'first_name'	=> $name[0],
			'last_name'  => !empty($name[1]) ? $name[1] : '',
			'state'  => !empty($this->input->post('LenderState')) ? $this->input->post('LenderState') : "",
			'company_name'  => !empty($this->input->post('LenderCompany')) ? $this->input->post('LenderCompany') : "",
			'street_address' => !empty($this->input->post('LenderAddress')) ? $this->input->post('LenderAddress') : "",
			'city'  => !empty($this->input->post('LenderCity')) ? $this->input->post('LenderCity') : "",
			'zip_code'  => !empty($this->input->post('LenderZipcode')) ? $this->input->post('LenderZipcode') : "",
			'assignment_clause'  => !empty($this->input->post('assignment_clause')) ? $this->input->post('assignment_clause') : ""
		);

		$orderUser =  $this->home_model->get_user(array('id' => $orderDetails['customer_id']));
		if($new_existing_lender == 'add_lender') {
			$lender_details['partner_id'] = $this->input->post('partner_id');
			$lender_details['is_added_lender_by_cpl_proposed'] = 1;
			$lender_details['is_escrow'] = 0;
			$lender_details['status'] = 0;
			$LenderId = $this->home_model->insert($lender_details, 'customer_basic_details');		
		} else {
			$condition = array(
				'id' => $LenderId
			);
			$this->home_model->update($lender_details, $condition, 'customer_basic_details');
		}

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

		// if(!empty($lenderUserDetails['resware_user_id'])) {
		// 	if ($orderUser['is_escrow'] == 1) {
		// 		if(empty($orderDetails['escrow_lender_id'])) {
		// 			$partners[] = $secondaryPartners;
		// 		} else if (!empty($orderDetails['escrow_lender_id']) && $orderDetails['escrow_lender_id'] != $LenderId) {
		// 			$partners[] = $secondaryPartners;
		// 			$removeLenderUserDetails = $this->home_model->get_user(array('id' => $orderDetails['escrow_lender_id']));
		// 			$removeSecondaryEmp[] = array('UserID'=> $removeLenderUserDetails['resware_user_id']);
		// 			$removeSecondaryPartners = array(
		// 				'SecondaryEmployees'=> $removeSecondaryEmp,
		// 				'PartnerTypeID' => 3,
		// 				'PartnerID' => $removeLenderUserDetails['partner_id'],
		// 				'PartnerType' => array(
		// 					'PartnerTypeID' => 3
		// 				)
		// 			);
		// 			$removePartners[] = $removeSecondaryPartners;
		// 			$removePartnerData = json_encode(array('Partners' => $removePartners));
		// 			$removeLogid = $this->apiLogs->syncLogs($userdata['id'], 'resware', 'delete_partner', env('RESWARE_ORDER_API').$endPoint, $removePartnerData, array(), 0, 0);
		// 			$resultRemovePartner = $this->resware->make_request('DELETE', $endPoint, $removePartnerData, $partnerUserData);
		// 			$this->apiLogs->syncLogs($userdata['id'], 'resware', 'delete_partner', env('RESWARE_ORDER_API').$endPoint, $removePartnerData, $resultRemovePartner, 0, $removeLogid);
		// 		}
		// 	} else {
		// 		if(empty($orderDetails['cpl_lender_id'])) {
		// 			$partners[] = $secondaryPartners;
		// 		} else if (!empty($orderDetails['cpl_lender_id']) && $orderDetails['cpl_lender_id'] != $LenderId) {
		// 			$partners[] = $secondaryPartners;
		// 			$removeLenderUserDetails = $this->home_model->get_user(array('id' => $orderDetails['cpl_lender_id']));
		// 			$removeSecondaryEmp[] = array('UserID'=> $removeLenderUserDetails['resware_user_id']);
		// 			$removeSecondaryPartners = array(
		// 				'SecondaryEmployees'=> $removeSecondaryEmp,
		// 				'PartnerTypeID' => 3,
		// 				'PartnerID' => $removeLenderUserDetails['partner_id'],
		// 				'PartnerType' => array(
		// 					'PartnerTypeID' => 3
		// 				)
		// 			);
		// 			$removePartners[] = $removeSecondaryPartners;
		// 			$removePartnerData = json_encode(array('Partners' => $removePartners));
		// 			$removeLogid = $this->apiLogs->syncLogs($userdata['id'], 'resware', 'delete_partner', env('RESWARE_ORDER_API').$endPoint, $removePartnerData, array(), 0, 0);
		// 			$resultRemovePartner = $this->resware->make_request('DELETE', $endPoint, $removePartnerData, $partnerUserData);
		// 			$this->apiLogs->syncLogs($userdata['id'], 'resware', 'delete_partner', env('RESWARE_ORDER_API').$endPoint, $removePartnerData, $resultRemovePartner, 0, $removeLogid);
		// 		}
		// 	}
	
		// 	if(!empty($partners)) {
		// 		$partnerData = json_encode(array('Partners' => $partners));
		// 		$logid = $this->apiLogs->syncLogs($userdata['id'], 'resware', 'add_partner', env('RESWARE_ORDER_API').$endPoint, $partnerData, array(), 0, 0);
		// 		$resultPartner = $this->resware->make_request('POST', $endPoint, $partnerData, $partnerUserData);
		// 		$this->apiLogs->syncLogs($userdata['id'], 'resware', 'add_partner', env('RESWARE_ORDER_API').$endPoint, $partnerData, $resultPartner, 0, $logid);
		// 	}
		// }
		
		
		$propertyDetails = array(
			'cpl_lender_id' => $LenderId, 
			'borrowers_vesting' => trim($borrowers_vesting),
			'cpl_proposed_property_address' => $this->input->post('property_address'),
			'cpl_proposed_property_city' => $this->input->post('property_city'),
			'cpl_proposed_property_state' => $this->input->post('property_state'),
			'cpl_proposed_property_zip' => $this->input->post('property_zipcode'),
		);
		$this->home_model->update(array('loan_number' => $loan_number), array('id' => $orderDetails['transaction_id']), 'transaction_details');
		$this->home_model->update(array('fnf_agent_id' => $this->input->post('branch')), array('id' => $orderDetails['order_id']), 'order_details');
		$this->home_model->update($propertyDetails, array('id' => $orderDetails['property_id']), 'property_details');
		
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
		$userdata = $this->session->userdata('user');
		$orderId = $this->input->post('orderId');
		$this->load->library('order/resware');

		if($orderId)
		{
			$this->load->model('order/home_model');

			$TitleOfficer = $this->input->post('TitleOfficer');
			$loan_amount = $this->input->post('loan_amount');
			$loan_number = $this->input->post('loan_number');
			
			$name = explode(" ",$this->input->post('LenderName'));
			$new_existing_lender = $this->input->post('new_existing_lender');
			$LenderId = $this->input->post('LenderId');
			$orderId = $this->input->post('orderId');
			$transaction_id = $this->input->post('transaction_id');
			$property_id = $this->input->post('property_id');
			$property_address = $this->input->post('property_address');
            $property_city = $this->input->post('property_city');
            $property_state = $this->input->post('property_state');
            $property_zipcode = $this->input->post('property_zipcode');
            $borrowers_vesting = $this->input->post('borrowers_vesting');
			$fileId = $this->input->post('fileId');
			$s_report_date = $this->input->post('s_report_date');
			$p_report_date = $this->input->post('p_report_date');
			$s_report_date = date("Y-m-d",strtotime($s_report_date));
			$p_report_date = date("Y-m-d",strtotime($p_report_date));
			
			$orderDetails = $this->order->get_order_details($fileId);

			
			$lender_details = array(
				'first_name'	=> $name[0],
				'last_name'  => !empty($name[1]) ? $name[1] : '',
				'state'  => !empty($this->input->post('LenderState')) ? $this->input->post('LenderState') : "",
				'email_address' => !empty($this->input->post('LenderEmailAddress')) ? $this->input->post('LenderEmailAddress') : "",
				'company_name'  => !empty($this->input->post('LenderCompany')) ? $this->input->post('LenderCompany') : "",
				'street_address' => !empty($this->input->post('LenderAddress')) ? $this->input->post('LenderAddress') : "",
				'city'  => !empty($this->input->post('LenderCity')) ? $this->input->post('LenderCity') : "",
				'zip_code'  => !empty($this->input->post('LenderZipcode')) ? $this->input->post('LenderZipcode') : ""
			);

			if($new_existing_lender == 'add_lender') 
			{
				$lender_details['partner_id'] = $this->input->post('partner_id');
				$lender_details['state'] = empty($this->input->post('state')) ? $this->input->post('state') : 'CA';
				$lender_details['is_added_lender_by_cpl_proposed'] = 1;
				$lender_details['is_escrow'] = 0;
				$lender_details['status'] = 0;
				$LenderId = $this->home_model->insert($lender_details, 'customer_basic_details');		
			} 
			else {
				$condition = array(
					'id' => $LenderId
				);

				$this->home_model->update($lender_details, $condition, 'customer_basic_details');
			}			

			if(empty($lender_details['first_name']) && empty($lender_details['lender_last_name'])) {
				$lender_details['lender_name'] = '';
			} else if(empty($lender_details['first_name']) && !empty($lender_details['last_name'])) {
				$lender_details['lender_name'] = $lender_details['last_name'];
			} else if(!empty($lender_details['first_name']) && empty($lender_details['last_name'])) {
				$lender_details['lender_name'] = $lender_details['first_name'];
			} else if(!empty($lender_details['first_name']) && !empty($lender_details['last_name'])) {
				$lender_details['lender_name'] = $lender_details['first_name']." ".$lender_details['last_name'];
			}

			$lender_address = array();
            $street_address = $this->input->post('LenderAddress');
            if($street_address)
            {
                $lender_address[] = $street_address;
            }
            $city = $this->input->post('LenderCity');
            if($city)
            {
                $lender_address[] = $city;
            }

            $lendeUser =  $this->home_model->get_user(array('id' => $LenderId));

            $state = isset($lendeUser['state']) && !empty($lendeUser['state']) ? $lendeUser['state'] : '';

            if($state)
            {
                $lender_address[] = $state;
            }

            $zip_code = $this->input->post('LenderZipcode');
            if($zip_code)
            {
                $lender_address[] = $zip_code;
            }

            $pdfData['lender'] = array(
                'lender_name'=> $lender_details['lender_name'],
                'address'=> implode(', ', $lender_address),
                'company_name'=> $lender_details['company_name']
            );
			
			
			$orderUser =  $this->home_model->get_user(array('id' => $orderDetails['customer_id']));
			
			
			$propertyDetails = array('cpl_lender_id' => $LenderId,'cpl_proposed_property_address'=> trim($property_address),'cpl_proposed_property_city'=> trim($property_city), 'cpl_proposed_property_state' => trim($property_state),'cpl_proposed_property_zip'=> trim($property_zipcode),'borrowers_vesting' => trim($borrowers_vesting));
				
			$property_update_flag = $this->home_model->update($propertyDetails, array('id' => $orderDetails['property_id']), 'property_details');

			$transaction_update_flag = $this->home_model->update(array('loan_amount' => $loan_amount, 'loan_number' => $loan_number,'title_officer'=>$TitleOfficer,'preliminary_report_date'=>$p_report_date,'supplemental_report_date'=>$s_report_date), array('id' => $orderDetails['transaction_id']), 'transaction_details');
			

			if($property_update_flag || $transaction_update_flag)
			{
				$orderDetails = $this->order->get_order_details($fileId);
				$customer_id = isset($orderDetails['customer_id']) && !empty($orderDetails['customer_id']) ? $orderDetails['customer_id'] : '';

	    		$this->load->model('order/home_model');
				$customer_data =  $this->home_model->get_user(array('id' => $customer_id));
				$pdfData['company'] = isset($customer_data['company_name']) && !empty($customer_data['company_name']) ? $customer_data['company_name'] : '';
	
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
				$pdfData['address'] = implode(', ', $address);
				$pdfData['order_number'] = isset($orderDetails['file_number']) && !empty($orderDetails['file_number']) ? $orderDetails['file_number'] : '';
				$new_property_address = array();
                
                if(isset($property_address) && !empty($property_address))
                {
                    $new_property_address[] = $property_address;
                }
                
                if(isset($property_city) && !empty($property_city))
                {
                    $new_property_address[] = $property_city;
                }

                if(isset($property_state) && !empty($property_state))
                {
                    $new_property_address[] = $property_state;
                }

                if(isset($property_zipcode) && !empty($property_zipcode))
                {
                    $new_property_address[] = $property_zipcode;
                }

               // $pdfData['property_address'] = isset($orderDetails['full_address']) && !empty($orderDetails['full_address']) ? $orderDetails['full_address'] : '';
                $pdfData['property_address'] = implode(', ', $new_property_address);
				$pdfData['sales_amount'] = isset($orderDetails['sales_amount']) && !empty($orderDetails['sales_amount']) ? $orderDetails['sales_amount'] : '';
				$pdfData['loan_amount'] = isset($orderDetails['loan_amount']) && !empty($orderDetails['loan_amount']) ? $orderDetails['loan_amount'] : '';
				$pdfData['loan_number'] = isset($orderDetails['loan_number']) && !empty($orderDetails['loan_number']) ? $orderDetails['loan_number'] : '';
				
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
				
					$pdfData['title_officer'] = isset($titleOfficerDetails['name']) && !empty($titleOfficerDetails['name']) ? $titleOfficerDetails['name'] : '';;
					$pdfData['title_officer_email'] = isset($titleOfficerDetails['email_address']) && !empty($titleOfficerDetails['email_address']) ? $titleOfficerDetails['email_address'] : '';
					$pdfData['title_officer_phone'] = isset($titleOfficerDetails['phone']) && !empty($titleOfficerDetails['phone']) ? $titleOfficerDetails['phone'] : '';
				}

				/*if ($orderDetails['sales_amount'] > 0) 
				{
					if (!empty($orderDetails['borrower'])) {
						$pdfData['primary_owner'] = $orderDetails['borrower'];
						
					} else {
						$pdfData['primary_owner'] =  '';
					}
			
					if (!empty($orderDetails['secondary_borrower'])) 
					{
						$pdfData['secondary_owner'] = $orderDetails['secondary_borrower'];
					} else {
						$pdfData['secondary_owner'] = '';
					}	
				} 
				else 
				{
					if (!empty($orderDetails['primary_owner'])) {
						$pdfData['primary_owner'] = $orderDetails['primary_owner'];
						
					} else {
						$pdfData['primary_owner'] = '';
					}
					
					if (!empty($orderDetails['secondary_owner'])) 
					{
						$pdfData['secondary_owner'] = $orderDetails['secondary_owner'];
					} else {
						$pdfData['secondary_owner'] = '';
					}
				}*/
				$pdfData['vesting'] = isset($borrowers_vesting) && !empty($borrowers_vesting) ? $borrowers_vesting : '';
				$pdfData['supplemental_report_date']= isset($orderDetails['supplemental_report_date']) && !empty($orderDetails['supplemental_report_date']) ? date("m/d/Y h:i:s A", strtotime($orderDetails['supplemental_report_date'])) : '';

				$pdfData['preliminary_report_date'] = isset($orderDetails['preliminary_report_date']) && !empty($orderDetails['preliminary_report_date']) ? date("m/d/Y h:i:s A", strtotime($orderDetails['preliminary_report_date'])) : '';

				$pdfData['underwriter'] = '';
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
					if ($resPartners['Partners'][$key]['PartnerName'] == 'North American Title Insurance Company' || $resPartners['Partners'][$key]['PartnerName'] == 'Westcor Land Title Insurance Company' || $resPartners['Partners'][$key]['PartnerName'] == 'Commonwealth Land Title Insurance Company') {
						$pdfData['underwriter'] = $resPartners['Partners'][$key]['PartnerName'];
					} else {
						$pdfData['underwriter'] = 'Westcor Land Title Insurance Company';
					}
				}

				$html=$this->load->view('order/proposed_insured_pdf',$pdfData, true);
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

				$this->uploadProposedDocumentToResware($document_name, $orderDetails, $binaryData);
				/*$fileSize = filesize('./uploads/proposed-insured/'.$document_name);
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
				$documentId = $this->document->insert($documentData);*/

				$data = array('status'=>'success','data'=>$binaryData);
			}
			else
			{
				$data = array('status'=>'error');
			}
		}
		else
		{
			$data = array('status'=>'error');
		}
		echo json_encode($data); exit;
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
					
					$class = isset($order['is_updated']) && !empty($order['is_updated']) ? 'button-color-green' : 'button-color';
					$nestedData[] = "<a href='".base_url()."review-file/".$order['file_id']."'><button class='btn btn-grad-2a ".$class."' type='button'>REVIEW FILE</button></a>";
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
		$userdata = $this->session->userdata('user');
		$prelimDocument = array();
		$linked_doc = array();
		$this->load->library('order/resware');
		$this->load->model('order/document');
		$fileId = $this->uri->segment(2);
		$data['title'] = 'Smart Dashboard | Pacific Coast Title Company';  
		$orderDetails = $this->order->get_order_details($fileId);
		$prelimDocument = $this->order->get_prelim_document($orderDetails['order_id']);
		if (isset($userdata['is_sales_rep']) && !empty($userdata['is_sales_rep'])) {
			$linked_doc = $this->order->get_order_linked_documents($fileId, 1);
		} else {
			$linked_doc = $this->order->get_order_linked_documents($fileId);
		}
		$uploaded_docs = $this->order->get_order_uploaded_documents($fileId);

		if(isset($orderDetails['file_number']) && !empty($orderDetails['file_number']))
		{
			$condition = array('file_number' => $orderDetails['file_number']);
			$summaryData['is_updated'] = 0;
			$update = $this->reviewPrelimData->update($summaryData, $condition);
		}

		$data['linked_doc'] = $linked_doc;
		$data['uploaded_docs'] = $uploaded_docs;
		$data['prelimDocument'] = $prelimDocument;
		$data['orderDetails'] = $orderDetails;
		$data['is_sales_rep'] = isset($userdata['is_sales_rep']) && !empty($userdata['is_sales_rep']) ? 1 : 0;
		$this->load->view('layout/head_dashboard',$data);
		$this->load->view('order/view_review_file');
	}

	public function summary()
	{
		$fileId = $this->input->post('fileId');
		$orderDetails = $this->order->get_order_details($fileId);
		$policy_type = '';
		if (isset($orderDetails['product_type']) && !empty($orderDetails['product_type'])) {
			if (strpos($orderDetails['product_type'], 'Loan:') !== false) {
				$policy_type = 'ALTA 2012 Short Form Residential Loan Policy';
			} else {
				$policy_type = 'ALTA 2006 Extended Loan Policy CA';
			}
		}

		$file_number = isset($orderDetails['file_number']) && !empty($orderDetails['file_number']) ? $orderDetails['file_number'] : '';
		$address = isset($orderDetails['full_address']) && !empty($orderDetails['full_address']) ? $orderDetails['full_address'] : '';
		$property_type = isset($orderDetails['property_type']) && !empty($orderDetails['property_type']) ? $orderDetails['property_type'] : '';

		$condition = array(
			'where' => array(
				'file_number' => $file_number,
			)
		);

		$prelim_details = $this->reviewPrelimData->get_rows($condition);

		$data = json_decode($prelim_details['resware_json'], TRUE);

		if (isset($data) && !empty($data)) {
			$parcelID = isset($data['ParcelID']) && !empty($data['ParcelID']) ? $data['ParcelID'] : '';
			$vesting = isset($data['Vesting']) && !empty($data['Vesting']) ? $data['Vesting'] : '';
			$generated_date = isset($data['CommitmentEffectiveDate']) && !empty($data['CommitmentEffectiveDate']) ? date('Y-m-d H:i:s', strtotime($data['CommitmentEffectiveDate'])) : '';
			$summaryData = array(
				'file_number'=> $file_number,
				'vesting'=> $vesting,
				'generated_date'=> $generated_date,
				'lien'=> isset($prelim_details['lien']) && !empty($prelim_details['lien']) ? $prelim_details['lien'] : '',
				'tax'=> isset($prelim_details['tax']) && !empty($prelim_details['tax']) ? $prelim_details['tax'] : '',
				'easement'=> isset($prelim_details['easement']) && !empty($prelim_details['easement']) ? $prelim_details['easement'] : '',
				'requirements'=> isset($prelim_details['requirements']) && !empty($prelim_details['requirements']) ? $prelim_details['requirements'] : '',
				'restrictions'=> isset($prelim_details['restrictions']) && !empty($prelim_details['restrictions']) ? $prelim_details['restrictions'] : '',
				'resware_json' => $json,
				'parcel_id' => $parcelID,
				'policy_type' => $policy_type
			);
			$prelim_details = $summaryData;
		}

		$data['prelim_details'] = array();
		if (isset($prelim_details) && !empty($prelim_details)) {
			$data['prelim_details'] = $prelim_details;
		}
		$data['prelim_details']['address'] = $address;
		$data['prelim_details']['property_type'] = $property_type;
		$results = $this->load->view('order/review_file_summary', $data, TRUE);
		echo json_encode($results, true);
	}
	
	function multiexplode ($delimiters,$string) 
	{

	    $ready = str_replace($delimiters, $delimiters[0], $string);
	    $launch = explode($delimiters[0], $ready);
	    return  $launch;
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
		$documentDetail = $this->order->get_document_detail($resware_document_id, $order_id);
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
		if ($documentDetail['is_grant_doc'] == 1) {
			$data['url'] = base_url().'uploads/grant-deed/'.$documentDetail['document_name'];
		} else if ($documentDetail['is_proposed_insured_doc'] == 1) {
			$data['url'] = base_url().'uploads/proposed-insured/'.$documentDetail['document_name'];
		} else {
			$data['url'] = base_url().'uploads/documents/'.$documentDetail['document_name'];
		}
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
		$this->load->library('order/resware');
		/*$orderId = isset($_POST['orderId']) && !empty($_POST['orderId']) ? $_POST['orderId'] : '';
		
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
		}*/

		$userdata = $this->session->userdata('user');
		$orderId = $this->input->post('orderId');
		if($orderId)
		{
			$this->load->model('order/home_model');

			$TitleOfficer = $this->input->post('TitleOfficer');
			$loan_amount = $this->input->post('loan_amount');
			$loan_number = $this->input->post('loan_number');
			$primary_first_name = $this->input->post('primary_first_name');
			$primary_last_name = $this->input->post('primary_last_name');
			$primary_owner = $primary_first_name." ".$primary_last_name;
			$secondary_first_name = $this->input->post('secondary_first_name');
			$secondary_last_name = $this->input->post('secondary_last_name');
			$secondaryOwner = $secondary_first_name." ".$secondary_last_name;
			$name = explode(" ",$this->input->post('LenderName'));

			$LenderId = $this->input->post('LenderId');
			$orderId = $this->input->post('orderId');
			$transaction_id = $this->input->post('transaction_id');
			$property_id = $this->input->post('property_id');
			$fileId = $this->input->post('fileId');
			$s_report_date = $this->input->post('s_report_date');
			$p_report_date = $this->input->post('p_report_date');
			$s_report_date = date("Y-m-d",strtotime($s_report_date));
			$p_report_date = date("Y-m-d",strtotime($p_report_date));
			
			$orderDetails = $this->order->get_order_details($fileId);

			if(isset($LenderId) && !empty($LenderId))
			{
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
				$this->home_model->update($lender_details, $condition, 'customer_basic_details');
			}
			

			$orderUser =  $this->home_model->get_user(array('id' => $orderDetails['customer_id']));
			
			if ($orderDetails['sales_amount'] > 0) 
			{
				$propertyDetails = array('escrow_lender_id' => $LenderId);
				
				$property_update_flag = $this->home_model->update($propertyDetails, array('id' => $orderDetails['property_id']), 'property_details');

				$transaction_update_flag = $this->home_model->update(array('loan_amount' => $loan_amount, 'loan_number' => $loan_number, 'borrower' => $primary_owner, 'secondary_borrower' => $secondaryOwner,'title_officer'=>$TitleOfficer,'preliminary_report_date'=>$p_report_date,'supplemental_report_date'=>$s_report_date), array('id' => $orderDetails['transaction_id']), 'transaction_details');
			} 
			else 
			{
				
				$propertyDetails = array('escrow_lender_id' => $LenderId, 'primary_owner' => $primary_owner, 'secondary_owner' => $secondaryOwner);
				
				$property_update_flag = $this->home_model->update($propertyDetails, array('id' => $orderDetails['property_id']), 'property_details');

				$transaction_update_flag = $this->home_model->update(array('loan_amount' => $loan_amount, 'loan_number' => $loan_number,'title_officer'=>$TitleOfficer,'preliminary_report_date'=>$p_report_date,'supplemental_report_date'=>$s_report_date), array('id' => $orderDetails['transaction_id']), 'transaction_details');
			}

			if($property_update_flag || $transaction_update_flag)
			{
				$orderDetails = $this->order->get_order_details($fileId);
				$customer_id = isset($orderDetails['customer_id']) && !empty($orderDetails['customer_id']) ? $orderDetails['customer_id'] : '';

	    		$this->load->model('order/home_model');
				$customer_data =  $this->home_model->get_user(array('id' => $customer_id));
				$pdfData['company'] = isset($customer_data['company_name']) && !empty($customer_data['company_name']) ? $customer_data['company_name'] : '';
	
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
				$pdfData['address'] = implode(', ', $address);
				$pdfData['order_number'] = isset($orderDetails['file_number']) && !empty($orderDetails['file_number']) ? $orderDetails['file_number'] : '';
				$pdfData['property_address'] = isset($orderDetails['full_address']) && !empty($orderDetails['full_address']) ? $orderDetails['full_address'] : '';
				$pdfData['sales_amount'] = isset($orderDetails['sales_amount']) && !empty($orderDetails['sales_amount']) ? $orderDetails['sales_amount'] : '';
				$pdfData['loan_amount'] = isset($orderDetails['loan_amount']) && !empty($orderDetails['loan_amount']) ? $orderDetails['loan_amount'] : '';
				$pdfData['loan_number'] = isset($orderDetails['loan_number']) && !empty($orderDetails['loan_number']) ? $orderDetails['loan_number'] : '';
				
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
				
					$pdfData['title_officer'] = isset($titleOfficerDetails['name']) && !empty($titleOfficerDetails['name']) ? $titleOfficerDetails['name'] : '';;
					$pdfData['title_officer_email'] = isset($titleOfficerDetails['email_address']) && !empty($titleOfficerDetails['email_address']) ? $titleOfficerDetails['email_address'] : '';
					$pdfData['title_officer_phone'] = isset($titleOfficerDetails['phone']) && !empty($titleOfficerDetails['phone']) ? $titleOfficerDetails['phone'] : '';
				}

				if ($orderDetails['sales_amount'] > 0) 
				{
					if (!empty($orderDetails['borrower'])) {
						$pdfData['primary_owner'] = $orderDetails['borrower'];
						
					} else {
						$pdfData['primary_owner'] =  '';
					}
			
					if (!empty($orderDetails['secondary_borrower'])) 
					{
						$pdfData['secondary_owner'] = $orderDetails['secondary_borrower'];
					} else {
						$pdfData['secondary_owner'] = '';
					}	
				} 
				else 
				{
					if (!empty($orderDetails['primary_owner'])) {
						$pdfData['primary_owner'] = $orderDetails['primary_owner'];
						
					} else {
						$pdfData['primary_owner'] = '';
					}
					
					if (!empty($orderDetails['secondary_owner'])) 
					{
						$pdfData['secondary_owner'] = $orderDetails['secondary_owner'];
					} else {
						$pdfData['secondary_owner'] = '';
					}
				}

				$pdfData['supplemental_report_date']= isset($orderDetails['supplemental_report_date']) && !empty($orderDetails['supplemental_report_date']) ? date("m/d/Y h:i:s A", strtotime($orderDetails['supplemental_report_date'])) : '';

				$pdfData['preliminary_report_date'] = isset($orderDetails['preliminary_report_date']) && !empty($orderDetails['preliminary_report_date']) ? date("m/d/Y h:i:s A", strtotime($orderDetails['preliminary_report_date'])) : '';

				$pdfData['underwriter'] = '';
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
					if($resPartners['Partners'][$key]['PartnerName'] == 'Outside Title Order') {
						$pdfData['underwriter'] = 'Westcor Land Title Insurance Company';
					} else {
						$pdfData['underwriter'] = $resPartners['Partners'][$key]['PartnerName'];
					}
				}

				$html=$this->load->view('order/proposed_insured_pdf',$pdfData, true);
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

				$data = array('status'=>'success','data'=>$binaryData);
			}
			else
			{
				$data = array('status'=>'error');
			}
		}
		else
		{
			$data = array('status'=>'error');
		}
		echo json_encode($data); exit;
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
			if (!empty($orderDetails['cpl_lender_id'])) {
				$lenderDetails =  $this->home_model->get_user(array('id' => $orderDetails['cpl_lender_id']));
				$orderDetails['lender_first_name'] = $lenderDetails['first_name'] ? $lenderDetails['first_name'] : '';
				$orderDetails['lender_last_name'] = $lenderDetails['last_name'] ? $lenderDetails['last_name'] : '';
				$orderDetails['lender_email'] = $lenderDetails['email_address'] ? $lenderDetails['email_address'] : '';
				$orderDetails['lender_state'] = $lenderDetails['state'] ? $lenderDetails['state'] : '';
				$orderDetails['lender_company_name'] = $lenderDetails['company_name'] ? $lenderDetails['company_name'] : '';
				$orderDetails['lender_address'] = $lenderDetails['street_address'] ? $lenderDetails['street_address'] : '';
				$orderDetails['lender_city'] = $lenderDetails['city'] ? $lenderDetails['city'] : '';
				$orderDetails['lender_zipcode'] = $lenderDetails['zip_code'] ? $lenderDetails['zip_code'] : '';
				$orderDetails['lender_assignment_clause'] = $lenderDetails['assignment_clause'] ? $lenderDetails['assignment_clause'] : '';
				$orderDetails['lender_id'] = $lenderDetails['id'] ? $lenderDetails['id'] : '';
			} else {			
				$orderDetails['lender_first_name'] = $orderDetails['lender_first_name'] ? $orderDetails['lender_first_name'] : '';
				$orderDetails['lender_last_name'] = $orderDetails['lender_last_name'] ? $orderDetails['lender_last_name'] : '';
				$orderDetails['lender_email'] = $orderDetails['lender_email'] ? $orderDetails['lender_email'] : '';
				$orderDetails['lender_state'] = $orderDetails['lender_state'] ? $orderDetails['lender_state'] : '';
				$orderDetails['lender_company_name'] = $orderDetails['lender_company_name'] ? $orderDetails['lender_company_name'] : '';
				$orderDetails['lender_address'] = $orderDetails['lender_address'] ? $orderDetails['lender_address'] : '';
				$orderDetails['lender_city'] = $orderDetails['lender_city'] ? $orderDetails['lender_city'] : '';
				$orderDetails['lender_zipcode'] = $orderDetails['lender_zipcode'] ? $orderDetails['lender_zipcode'] : '';
				$orderDetails['lender_assignment_clause'] = $orderDetails['lender_assignment_clause'] ? $orderDetails['lender_assignment_clause'] : '';
				$orderDetails['lender_id'] = $orderDetails['lender_id'] ? $orderDetails['lender_id'] : '';
			}
		} else {
			if (!empty($orderDetails['cpl_lender_id'])) {
				$lenderDetails =  $this->home_model->get_user(array('id' => $orderDetails['cpl_lender_id']));
				$orderDetails['lender_first_name'] = $lenderDetails['first_name'] ? $lenderDetails['first_name'] : '';
				$orderDetails['lender_last_name'] = $lenderDetails['last_name'] ? $lenderDetails['last_name'] : '';
				$orderDetails['lender_email'] = $lenderDetails['email_address'] ? $lenderDetails['email_address'] : '';
				$orderDetails['lender_state'] = $lenderDetails['state'] ? $lenderDetails['state'] : '';
				$orderDetails['lender_company_name'] = $lenderDetails['company_name'] ? $lenderDetails['company_name'] : '';
				$orderDetails['lender_address'] = $lenderDetails['street_address'] ? $lenderDetails['street_address'] : '';
				$orderDetails['lender_city'] = $lenderDetails['city'] ? $lenderDetails['city'] : '';
				$orderDetails['lender_zipcode'] = $lenderDetails['zip_code'] ? $lenderDetails['zip_code'] : '';
				$orderDetails['lender_assignment_clause'] = $lenderDetails['assignment_clause'] ? $lenderDetails['assignment_clause'] : '';
				$orderDetails['lender_id'] = $lenderDetails['id'] ? $lenderDetails['id'] : '';
			} else {
				$orderDetails['lender_first_name'] = $orderUser['first_name'] ? $orderUser['first_name'] : '';
				$orderDetails['lender_last_name'] = $orderUser['last_name'] ? $orderUser['last_name'] : '';
				$orderDetails['lender_email'] = $orderUser['email_address'] ? $orderUser['email_address'] : '';
				$orderDetails['lender_state'] = $orderUser['state'] ? $orderUser['state'] : '';
				$orderDetails['lender_company_name'] = $orderUser['company_name'] ? $orderUser['company_name'] : '';
				$orderDetails['lender_address'] = $orderUser['street_address'] ? $orderUser['street_address'] : '';
				$orderDetails['lender_city'] = $orderUser['city'] ? $orderUser['city'] : '';
				$orderDetails['lender_zipcode'] = $orderUser['zip_code'] ? $orderUser['zip_code'] : '';
				$orderDetails['lender_assignment_clause'] = $orderUser['assignment_clause'] ? $orderUser['assignment_clause'] : '';
				$orderDetails['lender_id'] = $orderUser['id'] ? $orderUser['id'] : '';
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
				$orderDetails['primary_owner_name'] = $orderDetails['borrower'];
			} else {
				$orderDetails['primary_owner_name'] = '';
			}
	
			if (!empty($orderDetails['secondary_borrower'])) {
				$orderDetails['secondary_owner_name'] = $orderDetails['secondary_borrower'];
			} else {
				$orderDetails['secondary_owner_name'] = '';
			}
		} else {
			if (!empty($orderDetails['primary_owner'])) {
				$orderDetails['primary_owner_name'] = $orderDetails['primary_owner'];
			} else {
				$orderDetails['primary_owner_name'] = '';
			}
	
			if (!empty($orderDetails['secondary_owner'])) {
                $orderDetails['secondary_owner_name'] =  $orderDetails['secondary_owner'];
			} else {
				$orderDetails['secondary_owner_name'] = '';
			}
		}
		
		$endPoint = 'files/'. $fileId .'/partners';
		$logid = $this->apiLogs->syncLogs($userdata['id'], 'resware', 'get_partners', env('RESWARE_ORDER_API').$endPoint, array(), array(), $orderDetails['order_id'], 0);
		if ($userdata['is_master'] == 1) {
			if ($orderDetails['customer_id'] == 0) {
				$user_data['admin_api'] = 1; 
			} else {
				// $orderUser =  $this->home_model->get_user(array('id' => $orderDetails['customer_id']));
				// $user_data['email'] = $orderUser['email_address'];
				// $user_data['password'] = $orderUser['random_password'];
				$user_data['admin_api'] = 1; 
			}
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
				$agentsData = array(
					array(
						'id' => 303,
						'location_city' => 'Orange'
					),
					array(
						'id' => 1879,
						'location_city' => 'Oxnard',
					),
					array(
						'id' => 1880,
						'location_city' => 'Glendale',
					)
				);
				$orderDetails['agents_data'] = $agentsData;
			} elseif ($resPartners['Partners'][$key]['PartnerName'] == 'Westcor Land Title Insurance Company') {
				$orderDetails['cpl_api'] = 'westcor';
				$this->load->library('order/westcor');
				$agentsData = $this->westcor->getBranches($orderDetails['order_id']);
				$orderDetails['agents_data'] = $agentsData;
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
				$this->load->library('order/westcor');
				$agentsData = $this->westcor->getBranches($orderDetails['order_id']);
				$orderDetails['agents_data'] = $agentsData;
			}
		} 
		if(!empty($orderDetails['borrowers_vesting'])) {
			$orderDetails['borrowers_vesting'] = $orderDetails['borrowers_vesting'];
		} else {
			if (!empty($orderDetails['primary_owner_name'])) {
				$orderDetails['borrowers_vesting'] = $orderDetails['primary_owner_name'];
			} 
	
			if (!empty($orderDetails['secondary_owner_name'])) {
                $orderDetails['borrowers_vesting'] .=  " ".$orderDetails['secondary_owner_name'];
			} 

			if (!empty($orderDetails['vesting'])) {
                $orderDetails['borrowers_vesting'] .=  " ".$orderDetails['vesting'];
			} 
		}
		if(!empty($orderDetails['cpl_proposed_property_address'])) {
			$orderDetails['property_address'] = $orderDetails['cpl_proposed_property_address'];
			$orderDetails['property_city'] = $orderDetails['cpl_proposed_property_city'];
			$orderDetails['property_state'] = $orderDetails['cpl_proposed_property_state'];
			$orderDetails['property_zipcode'] = $orderDetails['cpl_proposed_property_zip'];
		} else {
			$orderDetails['property_address'] = $orderDetails['address'];
			$orderDetails['property_city'] = $orderDetails['property_city'];
			$orderDetails['property_state'] = $orderDetails['property_state'];
			$orderDetails['property_zipcode'] = $orderDetails['property_zip'];
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
		$responseArr = $this->natic->getDocumentContentForCpl($fileId, $orderDetails);
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
			$cplErrorData = array(
                'order_id' => $orderDetails['order_id'],
                'file_number' => $orderDetails['file_number'],
                'cpl_page' => 'Dashboard',
                'error' => $responseArr['error']
            );
            $this->order->storeCplError($cplErrorData);
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
				$cplErrorData = array(
                    'order_id' => $orderDetails['order_id'],
                    'file_number' => $orderDetails['file_number'],
                    'cpl_page' => 'Dashboard',
                    'error' => $editCplResponse['error']
                );
                $this->order->storeCplError($cplErrorData);
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
				$cplErrorData = array(
                    'order_id' => $orderDetails['order_id'],
                    'file_number' => $orderDetails['file_number'],
                    'cpl_page' => 'Dashboard',
                    'error' => $generateCplResponse['error']
                );
                $this->order->storeCplError($cplErrorData);
			}
			$data = array(
				"errors" =>  $errors,
				"success" => $success
			);
			$this->session->set_userdata($data);
			redirect(base_url().'cpl-dashboard');
		} else {
			$errors[] = $getCPLFormNameResponse['error'];
			$cplErrorData = array(
				'order_id' => $orderDetails['order_id'],
				'file_number' => $orderDetails['file_number'],
				'cpl_page' => 'Dashboard',
				'error' => $getCPLFormNameResponse['error']
			);
			$this->order->storeCplError($cplErrorData);
			$data = array(
				"errors" =>  $errors,
				"success" => $successrev
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

		/*$from_name = 'Pacific Coast Title Company';
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
		$mail_result = send_email($from_mail,$from_name, $to, $subject, $message,$file,$cc,$bcc);*/
	}

	
	function get_sales_orders()
    {
        $params = array();  $data = array();
        $status = $this->input->post('status');
        $params['status'] = isset($status) && !empty($status) ? $status : 'open';
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
                $nestedData[] = $order['file_number'];
               // $nestedData[] = date("m/d/Y", strtotime($order['created_at']));
                $nestedData[] = $order['full_address'];
                $nestedData[] = ucfirst($order['resware_status']);
               
                if ($order['prelim_summary_id'] != 0) {
					$action = "<a href='".base_url()."review-file/".$order['file_id']."'><button class='btn btn-grad-2a button-color' type='button'>REVIEW FILE</button></a>";
				} else {
					$action = "<a href='javascript:void(0);'><button class='btn btn-grad-2a' style='background: #d35411;' type='button'>Not Ready</button></a>";
				}
				$action .= "<a href='javascript:void(0);'><button class='btn btn-grad-2a button-color' type='button' onclick='getPartners(".$order['file_id'].");'>VIEW Partners</button></a>";
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

    function get_partners()
    {
    	$fileId = $this->input->post('fileId');

    	if($fileId)
    	{
    		$userdata = $this->session->userdata('user');

    		$orderDetails = $this->order->get_order_details($fileId);

    		$endPoint = 'files/'. $fileId .'/partners';

			$logid = $this->apiLogs->syncLogs($userdata['id'], 'resware', 'get_partners', env('RESWARE_ORDER_API').$endPoint, array(), array(), $orderDetails['order_id'], 0);

			if ($userdata['is_master'] == 1) {
				$orderUser =  $this->home_model->get_user(array('id' => $orderDetails['customer_id']));
				$user_data['email'] = $orderUser['email_address'];
				$user_data['password'] = $orderUser['random_password'];
			} else {
				$user_data = array();
			}

			$result = $this->resware->make_request('GET', $endPoint, '', $user_data);

			$this->apiLogs->syncLogs($userdata['id'], 'resware', 'get_partners', env('RESWARE_ORDER_API').$endPoint, array(), $result, $orderDetails['order_id'], $logid);
			$partners = json_decode($result, true);

			$partners = isset($partners['Partners']) && !empty($partners['Partners']) ? $partners['Partners'] : '';
			
			$res = array('status'=>'success','partners'=>$partners);
    	}
    	else
    	{
    		$res = array('status'=>'error','msg'=>"Please select file.");
    	}
    	
    	echo json_encode($res);
    }

    public function uploadProposedDocumentToResware($document_name, $orderDetails, $binaryData)
    {
    	$this->load->model('order/document');
		$this->load->library('order/resware');
		$this->load->model('order/apiLogs');

		$userdata = $this->session->userdata('user');

		$fileSize = filesize('./uploads/proposed-insured/'.$document_name);

		$documentData = array(
			'document_name' => $document_name,
			'original_document_name' => $document_name,
			'document_type_id' => 1037,
			'document_size' => $fileSize,
			'user_id' => $userdata['id'],
			'order_id' => $orderDetails['order_id'],
			'description' => 'Proposed Insured Document',
			'is_sync' => 1,
			'is_prelim_document' => 0,
			'is_proposed_insured_doc' => 1
		);

		$documentId = $this->document->insert($documentData);

		$endPoint = 'files/'.$orderDetails['file_id'].'/documents';

		$documentApiData = array(			
			'DocumentName' => $document_name,
			'DocumentType' => array(
				'DocumentTypeID' => 1037,
			),
			'Description' => 'Proposed Insured Document',
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
    }


    public function get_sales_rep_orders_count()
    {
    	$userdata = $this->session->userdata('user');

    	if(isset($userdata) && !empty($userdata))
    	{
    		$order_status = array('open','closed');
    		foreach ($order_status as $key => $value) 
            {
                $status = array();
                if($value == 'closed')
                {
                    $status['Statuses'][] = array('StatusID'=>9,'Name'=>'Closed');
                }
                else
                {
                    $status['Statuses'][] = array('StatusID'=>2,'Name'=>'Open');
                }                

                $logid = $this->apiLogs->syncLogs($userdata['id'], 'resware', 'get_sales_rep_orders', env('RESWARE_ORDER_API').'files/search', json_encode($status), array(), 0, 0);
        
                $res = $this->resware->make_request('POST', 'files/search', json_encode($status),  $userdata);
                
                $this->apiLogs->syncLogs($userdata['id'], 'resware', 'get_sales_rep_orders', env('RESWARE_ORDER_API').'files/search', json_encode($status), $res, 0, $logid);

                $result = json_decode($res,TRUE);            
                
                $resware_count[$value] = count($result['Files']);
                $order_lists = $this->order->get_orders(array('status'=>$value));
                $count[$value] = isset($order_lists['recordsTotal']) && !empty($order_lists['recordsTotal']) ? $order_lists['recordsTotal'] : 0;
            }
            $response = array('resware_open_count'=>$resware_count['open'], 'resware_closed_count'=>$resware_count['closed'], 'open_count'=>$count['open'], 'closed_count'=>$count['closed']);
            echo json_encode($response); exit;
    	}
    }
}