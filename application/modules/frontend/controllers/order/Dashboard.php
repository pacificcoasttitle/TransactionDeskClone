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
		$this->order->is_user();
	}
	
	
	function index()
	{
		$userdata = $this->session->userdata('user');
		$name = isset($userdata['name']) && !empty($userdata['name']) ? $userdata['name'] : '';
		$data['name'] = $name;
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
		$url = GET_RECORDING_URL.'date='.$date.'&api_token='.RECORDING_API_TOKEN;
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
				$nestedData[] = '<a href="'.base_url().'upload-documents/'.$order['file_id'].'"><button class="btn btn-grad-2a" type="button">Attach Files</button></a>';
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
					
					$logid = $this->apiLogs->syncLogs($userdata['id'], 'resware', 'create_document', RESWARE_ORDER_API.$endPoint, $documentApiData, array(), $orderId, 0);
					$result = $this->resware->make_request('POST', $endPoint, $document_api_data);
					$this->apiLogs->syncLogs($userdata['id'], 'resware', 'create_document', RESWARE_ORDER_API.$endPoint, $documentApiData, $result, $orderId, $logid);
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
                $nestedData[] = '<a href="'.base_url().'get-fees/'.$order['file_id'].'"><button class="btn btn-grad-2a" type="button">Get Fees</button></a>';
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
        $AddressPropertyParts = explode(',', $FullProperty);       
        $PropertyZip = trim(end($AddressPropertyParts));

        $AddressPropertyInfo = array_slice($AddressPropertyParts,0, -1);
        $propertyState = trim(end($AddressPropertyInfo));

        $AddressPropertyCityInfo = array_slice($AddressPropertyInfo,0, -1);
        $propertyCity = trim(end($AddressPropertyCityInfo));       
        
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
        }

        $fees_data = json_encode($request);
        $this->load->library('order/resware');


        $endPoint = 'estimates/closingfees';
        $logid = $this->apiLogs->syncLogs($userdata['id'], 'resware', 'get_fees', RESWARE_ORDER_API.$endPoint, $fees_data, array(), $orderId, 0);
        $result = $this->resware->make_request('POST', $endPoint, $fees_data);

        
        if(isset($result) && !empty($result))
        {
            $response = json_decode($result,TRUE);
            $closing_fee_estimate_id = isset($response['ClosingFeeEstimate']['ClosingFeeEstimateID']) && !empty($response['ClosingFeeEstimate']['ClosingFeeEstimateID']) ? $response['ClosingFeeEstimate']['ClosingFeeEstimateID'] : '';

            $fees = array();

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
        $data['fees'] = $fees;
        $data['order_number'] = isset($orderDetails['file_number']) && !empty($orderDetails['file_number']) ? $orderDetails['file_number'] : '';
        $data['full_address'] = isset($orderDetails['full_address']) && !empty($orderDetails['full_address']) ? $orderDetails['full_address'] : '';
        $data['sales_amount'] = isset($orderDetails['sales_amount']) && !empty($orderDetails['sales_amount']) ? $orderDetails['sales_amount'] : '';
        $data['loan_amount'] = isset($orderDetails['loan_amount']) && !empty($orderDetails['loan_amount']) ? $orderDetails['loan_amount'] : '';

        if(isset($orderDetails['purchase_type']) && !empty($orderDetails['purchase_type']))
        {
            $productTypeID = $orderDetails['purchase_type'];
            if($productTypeID == '19' || $productTypeID == '33')
            {
                $productType = 'Residential: Loan: Refinance';
            }
            elseif ($productTypeID == '20' || $productTypeID == '32') 
            {
                $productType = 'Residential: Sales: Purchase';
            }
        }
        $data['productType'] = $productType;
        $data['closing_fee_estimate_id'] = $closing_fee_estimate_id;
        
        $this->apiLogs->syncLogs($userdata['id'], 'resware', 'get_fees', RESWARE_ORDER_API.$endPoint, $fees_data, $result, $orderId, $logid);

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

            $logid = $this->apiLogs->syncLogs($userdata['id'], 'resware', 'get_fee_estimate_pdf', RESWARE_ORDER_API.$endPoint, $closing_fee_id, array(), 0, 0);

            $result = $this->resware->make_request('GET', $endPoint, array());

            $this->apiLogs->syncLogs($userdata['id'], 'resware', 'get_fee_estimate_pdf', RESWARE_ORDER_API.$endPoint, $closing_fee_id, $result, 0, $logid);
            
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
                $nestedData[] = '<a href="'.base_url().'get-notes/'.$order['file_id'].'"><button class="btn btn-grad-2a" type="button">View / Add Notes</button></a>';
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
        $logid = $this->apiLogs->syncLogs($userdata['id'], 'resware', 'get_notes', RESWARE_ORDER_API.$endPoint, $notes_data, array(), $orderId, 0);        

        $result = $this->resware->make_request('GET', $endPoint, $notes_data);

        $this->apiLogs->syncLogs($userdata['id'], 'resware', 'get_notes', RESWARE_ORDER_API.$endPoint, $notes_data, $result, $orderId, $logid);
        
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
	        $logid = $this->apiLogs->syncLogs($userdata['id'], 'resware', 'create_note', RESWARE_ORDER_API.$endPoint, $notes_data, array(), $orderId, 0);        

	        $result = $this->resware->make_request('POST', $endPoint, $notes_data);

	        $this->apiLogs->syncLogs($userdata['id'], 'resware', 'create_note', RESWARE_ORDER_API.$endPoint, $notes_data, $result, $orderId, $logid);
	        
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
                $nestedData[] = '<a href="javascript:void(0);" onclick="generateProposedInsured('.$order['file_id'].');"><button class="btn btn-grad-2a" type="button">Generate</button></a>';
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
			$this->load->model('order/titleOfficer');
			$condition = array(
                'where' => array(
                    'name' => $orderDetails['title_officer']
                )
            );
			
			$titleOfficerDetails = $this->titleOfficer->getTitleOfficerDetails($condition);
			
			$data['title_officer'] = $orderDetails['title_officer'];
			$data['title_officer_email'] = isset($titleOfficerDetails[0]['email_address']) && !empty($titleOfficerDetails[0]['email_address']);
			$data['title_officer_phone'] = isset($titleOfficerDetails[0]['phone']) && !empty($titleOfficerDetails[0]['phone']);
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

		$is_borrower = 0;
		if($purchase_type == '19' || $purchase_type == '33')
		{
			$owners = array();
			$primary_owner = isset($orderDetails['primary_owner']) && !empty($orderDetails['primary_owner']) ? $orderDetails['primary_owner'] : '';
			$secondary_owner = isset($orderDetails['secondary_owner']) && !empty($orderDetails['secondary_owner']) ? $orderDetails['secondary_owner'] : '';
			if($primary_owner)
			{
				$owners[] = $primary_owner;
			}

			if($secondary_owner)
			{
				$owners[] = $secondary_owner;
			}
			$data['borrowers'] = implode(', ', $owners);
			$is_borrower = 1;			
		}
		
		if($purchase_type == '20' || $purchase_type == '32')
		{
			$borrowers =  isset($orderDetails['borrower']) && !empty($orderDetails['borrower']) ? $orderDetails['borrower'] : '';
			$data['borrowers'] = $borrowers;
			if($borrowers)
			{
				$is_borrower = 1;
			}
			
		}
		$emptyData['is_borrower'] = $is_borrower;

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

	        if (!is_dir('uploads/proposed-insured')) {
			    mkdir('./uploads/proposed-insured', 0777, TRUE);
			}

			$pdfFilePath = './uploads/proposed-insured/ProposedInsured_'.time().'.pdf';
	        $this->m_pdf->pdf->Output($pdfFilePath,'F');
	        $contents = file_get_contents($pdfFilePath);
			$binaryData   = base64_encode($contents);		
			unlink($pdfFilePath);

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
				
				if(!empty($order['westcor_file_id'])) {
					$westcorFileId = $order['westcor_file_id'];
					$westcorOrderId = $order['westcor_order_id'];
					$nestedData[] = "<a onclick='download_for_pdf($westcorFileId, $westcorOrderId);' href='javascript:void(0);'><button class='btn btn-grad-2a' style='background: #d35411;' type='button'>Download</button></a>";
				} else {
					$file_id = $order['file_id'];
					$lender_id_flag = !empty($order['escrow_lender_id']) ? 1 : 0;
					$nestedData[] = "<form onclick='return lender_pop_up($lender_id_flag, $file_id);' action='".base_url()."create-cpl/".$order['file_id']."' method='POST'><button class='btn btn-grad-2a generate' type='submit'>GENERATE CPL</button></form>";
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
		$userdata = $this->session->userdata('user');
		$fileId = $this->uri->segment(2);    
		$errors = array();
		$success = array();
		$orderDetails = $this->order->get_order_details($fileId);
		$res = array();

		$resToken = $this->order->get_token();
		if ($resToken === false) {
			$resToken = $this->westcor->createToken($orderDetails['order_id']);
		} 

		$propertyDetail = explode(",", $orderDetails['full_address']);
		$propery[] = array (
			'PropertyID' => 0,
			'tvid' =>  0,
			'CountyName' => $orderDetails['county'].' County',
			'ShortLegal' => $orderDetails['legal_description'] ? $orderDetails['legal_description'] : null,
			'StreetAddress' => trim($propertyDetail[0])." ".trim($propertyDetail[1]),
			'City' => trim($propertyDetail[2]),
			'State' => trim($propertyDetail[3]),
			'Zip' => trim($propertyDetail[4]),
			'PropertyType' => 'R'
		);

		$primary_owner = explode(" ", $orderDetails['primary_owner']);
		if ($orderDetails['purchase_type'] == '19' || $orderDetails['purchase_type'] == '33') {
			$buyers[] = array (
				'NameID' => 0,
				'Last' => $primary_owner[1],
				'First' => $primary_owner[0],
				'NameType' => 1,
				'JoiningPhrase' => 'single',
				'tvid' => 0,
				'Sequence' => 1,
				'City' => trim($propertyDetail[2]),
				'State' => trim($propertyDetail[3]),
				'Zip' => trim($propertyDetail[4]),
				'Address' => trim($propertyDetail[0])." ".trim($propertyDetail[1])
			);
			$purchase_price = $orderDetails['loan_amount'];
			$sellers = array();
		} else if ($orderDetails['purchase_type'] == '20' || $orderDetails['purchase_type'] == '32')  {
			$sellers[] = array (
				'NameID' =>  0,
				'Last' => $primary_owner[1],
				'First' => $primary_owner[0],
				'NameType' => 2,
				'JoiningPhrase' => 'single',
				'tvid' => 0,
				'Sequence' => 1,
				'City' => trim($propertyDetail[2]),
				'State' => trim($propertyDetail[3]),
				'Zip' => trim($propertyDetail[4]),
				'Address' => trim($propertyDetail[0])." ".trim($propertyDetail[1]),
			);
			$purchase_price = $orderDetails['sales_amount'];
			$buyers = array();
		}

		if (!empty($orderDetails['escrow_lender_id'])) {
			$lenders[] =  array (
				'Id' =>  0,
				'tvid' => 0,
				'name' => $orderDetails['first_name']." ".$orderDetails['last_name'],
				'city' => $orderDetails['city'],
				'state' => 'CA',
				'zip' => $orderDetails['zip_code'],
				'address' => $orderDetails['street_address'],
				'phone' => $orderDetails['telephone_no'],
				'email' => $orderDetails['email_address'],
				'countyFIPS' => null,
				'assignment' => null,
				'mortgageType' => null,
				'amount' => 0,
				'loan_number' => null,
				'vendorInternalID' => $orderDetails['escrow_lender_id']
			);
		} 
		
		$cplPostData = array (
			'tvid' =>  0,
			'agentnumber' => $resToken['agent_number'],
			'agent_file_number' => $orderDetails['file_number'],
			'email_requestor' => $userdata['email'],
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
			'partnerCode' => (int)WESTCORE_INTEGRATION_PARTNER,
			'cpl' => null,
			'priors' => null
		);
		$endPointCreateOrder = 'VendorApi/Order/Update/'.WESTCORE_INTEGRATION_PARTNER;
		$cplPostData = json_encode($cplPostData);

		$logid = $this->apiLogs->syncLogs($userdata['id'], 'westcor', 'create_cpl_order', WESTCORE_URL.$endPointCreateOrder, $cplPostData, array(), $orderDetails['order_id'], 0);
		$result = $this->westcor->make_request('POST', $endPointCreateOrder, $cplPostData, 0, $resToken['token']);
		$this->apiLogs->syncLogs($userdata['id'], 'westcor', 'create_cpl_order', WESTCORE_URL.$endPointCreateOrder, $cplPostData, $result, $orderDetails['order_id'], $logid);
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
				'westcor_lender_id' => !empty($res['lenders']) ? $res['lenders'][0]['Id']: 0,
			);
			$condition = array(
				'id' => $orderDetails['order_id']
			);
			$this->home_model->update($order_details, $condition, 'order_details');
			$this->home_model->update(array('westcor_property_id' => !empty($res['property']) ? $res['property'][0]['PropertyID'] : 0), array('id' => $orderDetails['property_id']), 'property_details');
			$orderDetails['westcor_order_id'] = $res['tvid'];
		} else {
			$errors[] = $result;
			$data = array(
				"errors" =>  $errors,
				"success" => $success
			);
			$this->session->set_userdata($data);
			redirect(base_url().'cpl-dashboard');
		}
		
		if(!empty($orderDetails['westcor_order_id'])) {

			$endPointGetOrdeData = 'VendorApi/Order/'.$orderDetails['westcor_order_id'].'/'.WESTCORE_INTEGRATION_PARTNER;
			$logid = $this->apiLogs->syncLogs($userdata['id'], 'westcor', 'get_order_data', WESTCORE_URL.$endPointGetOrdeData, array(), array(), $orderDetails['order_id'], 0);
			$resultForGetOrderData = $this->westcor->make_request('GET', $endPointGetOrdeData, array(), 0, $resToken['token']);
			$this->apiLogs->syncLogs($userdata['id'], 'westcor', 'get_order_data', WESTCORE_URL.$endPointGetOrdeData, array(), $resultForGetOrderData, $orderDetails['order_id'], $logid);	
			$res = json_decode($resultForGetOrderData, true);
						
			$cpl[] = array (
				'TVID' => $res['tvid'],
				'CPLID' => -1,
				'FileInformation' => null,
				'LetterName' => 'ALTA CPL Single Trans 2.0',
				'IssueDate' => date('Y-m-d H:i:s'),
				'CancelDate' => null,
				'CancelReason' => null,
				'CancelUser' => null,
				'CreatedBy'=> null,
				'PolicyProducingAgentNumber' => $resToken['agent_number'],
				'PolicyProducingAgentAddressID' => $resToken['agent_number'],
				'PolicyProducingAgentName' => $resToken['agency_name'],
				'PolicyProducingAgentAddress' => $resToken['address'],
				'PolicyProducingAgentCity' => $resToken['city'],
				'PolicyProducingAgentState' => $resToken['state'],
				'PolicyProducingAgentZip' => $resToken['zip'],
				'ClosingAgentNumber'=> null,
				'ClosingAgentAddressID'=> null,
				'ClosingAgentName'=> null,
				'ClosingAgentAddress'=> null,
				'ClosingAgentCity'=> null,
				'ClosingAgentState'=> null,
				'ClosingAgentZip'=> null,
				'IsAuthorizedforDualCPLs' => false,
				'IsDualCPL' => false,
				'LenderID' => !empty($res['lenders']) ? $res['lenders'][0]['Id'] : 0,
				'CustomFields'=> null,
				'DualCombinedInfo'=> [],
				'ProtectBorrower' => false,
				'ProtectBuyer' => false,
				'ProtectLender' => true,
				'ProtectSeller' => false,
				'ProtectSeller'=> false,
				'ProtectAnyone'=> false,
				'ProtectAnyoneValue'=> null,
				'FreeInfoText'=> 'Some additional information about the closing would go here.',
				'AdditionalAgencyLocationsJSON'=> null,
				'ShowAdditionalAgencyLocations'=> false
			) ;
			$res['cpl'] = $cpl;
			$res['actions']['update_cpls'] = true;
			$generateCplPostData = json_encode($res);
			$endPointCreateCPL = 'VendorApi/Order/Update/'.WESTCORE_INTEGRATION_PARTNER;
			$logid = $this->apiLogs->syncLogs($userdata['id'], 'westcor', 'generate_cpl', WESTCORE_URL.$endPointCreateCPL, $generateCplPostData, array(), $orderDetails['order_id'], 0);
			$resultCPL = $this->westcor->make_request('POST', $endPointCreateCPL, $generateCplPostData, 0, $resToken['token']);
			$this->apiLogs->syncLogs($userdata['id'], 'westcor', 'generate_cpl', WESTCORE_URL.$endPointCreateCPL, $generateCplPostData, $resultCPL, $orderDetails['order_id'], $logid);
			$resCPL = json_decode($resultCPL, true);

			if (is_array($resCPL)) {
				if ($resCPL['Message']) {
					$errors[] = $res['Message'];
					$data = array(
						"errors" =>  $errors,
						"success" => $success
					);
					$this->session->set_userdata($data);
					redirect(base_url().'cpl-dashboard');
				}
				$order_details = array(
					'westcor_cpl_id'	=> $resCPL['cpl'][0]['CPLID'],
					'westcor_file_id'   => $resCPL['cpl'][0]['FileInformation']['FileAsDataVaultFileID']
				 );
				 
				$condition = array(
					'id' => $orderDetails['order_id']
				);
	
				$this->home_model->update($order_details, $condition, 'order_details');
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
		$endPoint = 'VendorApi/Attachments/Download/'.WESTCORE_INTEGRATION_PARTNER;
		$logid = $this->apiLogs->syncLogs($userdata['id'], 'westcor', 'get_pdf_content_cpl', WESTCORE_URL.$endPoint, $data, array(), $westcor_order_id, 0);
		$result = $this->westcor->make_request('POST', $endPoint, $data, 0, $resToken['token']);
		$this->apiLogs->syncLogs($userdata['id'], 'westcor', 'get_pdf_content_cpl', WESTCORE_URL.$endPoint, $data, $result, $westcor_order_id, $logid);
		if (isset($result) && !empty($result)) {
			echo base64_encode($result);
		}	
	}

	public function addLenderOnOrder()
	{
		$this->load->model('order/home_model');
		$userdata = $this->session->userdata('user');
		$file_id = $this->input->post('file_id');
		$LenderId = $this->input->post('LenderId');
		$name = explode(" ",$this->input->post('LenderName'));	
		$orderDetails = $this->order->get_order_details($file_id);

		$lender_details = array(
			'first_name'	=> $name[0],
			'last_name'  => !empty($name[1]) ? $name[1] : '',
			'telephone_no'  => !empty($this->input->post('LenderEmailAddress')) ? $this->input->post('LenderEmailAddress') : "",
			'email_address' => !empty($this->input->post('LenderTelephone')) ? $this->input->post('LenderTelephone') : "",
			'company_name'  => !empty($this->input->post('LenderCompany')) ? $this->input->post('LenderCompany') : "",
			'street_address' => !empty($this->input->post('LenderAddress')) ? $this->input->post('LenderAddress') : "",
			'city'  => !empty($this->input->post('LenderCity')) ? $this->input->post('LenderCity') : "",
			'zip_code'  => !empty($this->input->post('LenderZipcode')) ? $this->input->post('LenderZipcode') : ""
		);
		$condition = array(
			'id' => $LenderId
		);
		$this->home_model->update($lender_details, $condition, 'customer_basic_details');
		$this->home_model->update(array('escrow_lender_id' => $LenderId), array('id' => $orderDetails['property_id']), 'property_details');
		redirect(base_url()."create-cpl/".$file_id);
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
			$LenderId = isset($_POST['LenderId']) && !empty($_POST['LenderId']) ? $_POST['LenderId'] : '';
			$fileId = isset($_POST['fileId']) && !empty($_POST['fileId']) ? $_POST['fileId'] : '';
			$s_report_date = isset($_POST['s_report_date']) && !empty($_POST['s_report_date']) ? $_POST['s_report_date'] : '';
			$p_report_date = isset($_POST['p_report_date']) && !empty($_POST['p_report_date']) ? $_POST['p_report_date'] : '';

			
			if((isset($TitleOfficer) && !empty($TitleOfficer)) || (isset($loan_number) && !empty($loan_number)) || (isset($borrower) && !empty($borrower)) || (isset($s_report_date) && !empty($s_report_date)) || (isset($p_report_date) && !empty($p_report_date)))
			{
				$transaction_id = isset($_POST['transaction_id']) && !empty($_POST['transaction_id']) ? $_POST['transaction_id'] : '';

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

				$property_id = isset($_POST['property_id']) && !empty($_POST['property_id']) ? $_POST['property_id'] : '';

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
				
				
				$nestedData[] = "<a href='".base_url()."review-file/".$order['file_id']."'><button class='btn btn-grad-2a' type='button'>REVIEW FILE</button></a>";
				
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
		$logid = $this->apiLogs->syncLogs($userdata['id'], 'resware', 'get_documents', RESWARE_ORDER_API.$endPoint, array(), array(), $orderDetails['order_id'], 0);
		$resultDocuments = $this->resware->make_request('GET', $endPoint);
		$this->apiLogs->syncLogs($userdata['id'], 'resware', 'get_documents', RESWARE_ORDER_API.$endPoint, array(), $resultDocuments, $orderDetails['order_id'], $logid);
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
							$logid = $this->apiLogs->syncLogs($userdata['id'], 'resware', 'get_document', RESWARE_ORDER_API.$endPoint, array(), array(), $orderDetails['order_id'], 0);
							$resultDocument = $this->resware->make_request('GET', $endPoint);
							$this->apiLogs->syncLogs($userdata['id'], 'resware', 'get_document', RESWARE_ORDER_API.$endPoint, array(), $resultDocument, $orderDetails['order_id'], $logid);
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
								$pages = array(4, 5, 6, 7);
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
											$linked_doc[$linkedDocCount]['api_document_id'] = 0;
											$linked_doc[$linkedDocCount]['is_sync'] = 1;
											$linked_doc[$linkedDocCount]['is_prelim_document'] = 0;
											$linked_doc[$linkedDocCount]['order_id'] = $orderDetails['order_id'];
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
							$logid = $this->apiLogs->syncLogs($userdata['id'], 'resware', 'get_document', RESWARE_ORDER_API.$endPoint, array(), array(), $orderDetails['order_id'], 0);
							$resultDocument = $this->resware->make_request('GET', $endPoint);
							$this->apiLogs->syncLogs($userdata['id'], 'resware', 'get_document', RESWARE_ORDER_API.$endPoint, array(), $resultDocument, $orderDetails['order_id'], $logid);
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
								$pages = array(4, 5, 6, 7);
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
												$linked_doc[$linkedDocCount]['api_document_id'] = 0;
												$linked_doc[$linkedDocCount]['is_sync'] = 1;
												$linked_doc[$linkedDocCount]['is_prelim_document'] = 0;
												$linked_doc[$linkedDocCount]['order_id'] = $orderDetails['order_id'];
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
        $file_number = 'EELM-798-NR';
        // $data['file_number'] = $file_number;

        $condition = array(
            'where' => array(
                'file_number' => $file_number,
            )
        );

        $prelim_details = $this->reviewPrelimData->get_rows($condition);
        $data['prelim_details'] = array();
        if(isset($prelim_details[0]) && !empty($prelim_details[0]))
        {
        	$data['prelim_details'] = $prelim_details[0];
        }
        $data['prelim_details']['address'] = $address;
        
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
		$document_name = $this->input->post('document_name');
		$is_sync = $this->input->post('is_sync');
		if ($is_sync == 0) {
			$endPoint = 'documents/'.$resware_document_id.'?format=json';
			$logid = $this->apiLogs->syncLogs($userdata['id'], 'resware', 'get_document', RESWARE_ORDER_API.$endPoint, array(), array(), $order_id, 0);
			$resultDocument = $this->resware->make_request('GET', $endPoint);
			$this->apiLogs->syncLogs($userdata['id'], 'resware', 'get_document', RESWARE_ORDER_API.$endPoint, array(), $resultDocument, $order_id, $logid);
			$resDocument = json_decode($resultDocument, true);
			if (isset($resDocument['Document']) && !empty($resDocument['Document'])) { 
				$documentContent = base64_decode($resDocument['Document']['DocumentBody'], true);
				if (!is_dir('uploads/documents')) {
				    mkdir('./uploads/documents', 0777, TRUE);
				}
				file_put_contents('./uploads/documents/'.$document_name, $documentContent);
				$this->document->update(array('is_sync' => 1), array('api_document_id' => $resware_document_id));
			}	
		} 
		$data['api_document_id'] = $resware_document_id;
		$data['order_id'] = $order_id;
		$data['document_name'] = $document_name;
		$data['url'] = base_url().'uploads/documents/'.$document_name;
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
        $file_path = FCPATH.'uploads/plat-map/'.$file_number.'.pdf';

        $file_url = '';

		if (file_exists($file_path)) 
		{
		    $file_url = base_url().'uploads/plat-map/'.$file_number.'.png';
		} 
		else
		{
			if(isset($orderDetails['full_address']) && !empty($orderDetails['full_address']))
	        {
	        	$full_address = $orderDetails['full_address'];
	        	$AddressPropertyParts = explode(',', $full_address);
	        	$PropertyAddress = trim(reset($AddressPropertyParts));
	        	$PropertyZip = trim(end($AddressPropertyParts));
	        	
		        $AddressPropertyInfo = array_slice($AddressPropertyParts,0, -1);
		        $propertyState = trim(end($AddressPropertyInfo));       
		        $AddressPropertyCityInfo = array_slice($AddressPropertyInfo,0, -1);
		        $locale = trim(end($AddressPropertyCityInfo));
		        
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
	        }
	        $data['address'] = $PropertyAddress;
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

}