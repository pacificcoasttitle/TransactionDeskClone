<?php

(defined('BASEPATH')) OR exit('No direct script access allowed');

class Common extends MX_Controller {

	function __construct() 
    {
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
		$this->load->library('order/common');
        if (empty($this->session->userdata('user'))) {
            redirect(base_url().'order');
        }
	}

    function prelimFiles()
    {
		$data['title'] = 'Smart Dashboard | Pacific Coast Title Company';
		$this->load->view('layout/head_dashboard',$data);
		$this->load->view('order/review_files');
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
		if ((isset($userdata['is_sales_rep']) && !empty($userdata['is_sales_rep'])) || (isset($userdata['is_title_officer']) && !empty($userdata['is_title_officer']))) {
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

		$data['error'] = array();
		$data['success'] = array();

		if ($this->session->userdata('errors')) {
			$data['error'] = $this->session->userdata('error');
			$this->session->unset_userdata('error');
		}

		if ($this->session->userdata('success')) {
			$data['success'] = $this->session->userdata('success');
			$this->session->unset_userdata('success');
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
				'resware_json' => $prelim_details['resware_json'],
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
				$this->order->uploadDocumentOnAwsS3($documentDetail['document_name'], 'documents');
				$this->document->update(array('is_sync' => 1), array('api_document_id' => $resware_document_id));
			}	
		} 
		
		$data['api_document_id'] = $resware_document_id;
		$data['order_id'] = $order_id;
		$data['document_name'] = $documentDetail['document_name'];
		if ($documentDetail['is_grant_doc'] == 1) {
			if (env('AWS_ENABLE_FLAG') == 1) {
				$data['url'] = env('AWS_PATH')."grant-deed/".$documentDetail['document_name'];
			} else {
				$data['url'] = base_url().'uploads/grant-deed/'.$documentDetail['document_name'];
			}
		} else if ($documentDetail['is_proposed_insured_doc'] == 1) {
			if (env('AWS_ENABLE_FLAG') == 1) {
				$data['url'] = env('AWS_PATH')."proposed-insured/".$documentDetail['document_name'];
			} else {
				$data['url'] = base_url().'uploads/proposed-insured/'.$documentDetail['document_name'];
			}
		} else {
			if (env('AWS_ENABLE_FLAG') == 1) {
				$data['url'] = env('AWS_PATH')."documents/".$documentDetail['document_name'];
			} else {
				$data['url'] = base_url().'uploads/documents/'.$documentDetail['document_name'];
			}
		}
        $results = $this->load->view('order/review_file_load_doc', $data, TRUE);
        echo json_encode($results, true);
	}

    function logout()
	{
		$this->session->sess_destroy();
		$this->session->unset_userdata('user');
		redirect(base_url().'order');
	}

    public function legal_vesting() 
	{
        $fileId = $this->input->post('fileId');
        $orderDetails = $this->order->get_order_details($fileId);
        
        $file_number = isset($orderDetails['file_number']) && !empty($orderDetails['file_number']) ? $orderDetails['file_number'] : '';
		if (env('AWS_ENABLE_FLAG') == 1) {
			$file_path = env('AWS_PATH')."legal-vesting/".$file_number.'.pdf';
		} else {
			$file_path = FCPATH.'uploads/legal-vesting/'.$file_number.'.pdf';
		}
        

        $file_url = '';

		if (file_exists($file_path)) 
		{
			if (env('AWS_ENABLE_FLAG') == 1) {
				$file_url = env('AWS_PATH')."legal-vesting/".$file_number.'.pdf';
			} else {
				$file_url = base_url().'uploads/legal-vesting/'.$file_number.'.pdf';
			}
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
		if (env('AWS_ENABLE_FLAG') == 1) {
			$file_path = env('AWS_PATH')."plat-map/".$file_number.'.pdf';
		} else {
			$file_path = FCPATH.'uploads/plat-map/'.$file_number.'.pdf';
		}
    
        $file_url = '';

		if (file_exists($file_path)) 
		{
			if (env('AWS_ENABLE_FLAG') == 1) {
				$file_url = env('AWS_PATH')."plat-map/".$file_number.'.pdf';
			} else {
				$file_url = base_url().'uploads/plat-map/'.$file_number.'.pdf';
			}
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
		if (env('AWS_ENABLE_FLAG') == 1) {
			$contents = file_get_contents(env('AWS_PATH')."documents/".$document_name);
		} else {
			$contents = file_get_contents(base_url().'uploads/documents/'.$document_name);
		}
		
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
			if (env('AWS_ENABLE_FLAG') == 1) { 
				$plat_map_url = env('AWS_PATH')."plat-map/".$file_number.'.png';
			} else {
				$plat_map_url = base_url().'uploads/plat-map/'.$file_number.'.png';
			}
			
			$this->order->uploadDocumentOnAwsS3($file_number.'.png', 'plat-map');
			$response = array('status'=>'success','plat_map_url'=>$plat_map_url);
		}
		else
		{
			$response = array('status'=>'error');
		}
		echo json_encode($response); exit;
	}

    function getSearchResults()
    {
    	$userdata = $this->session->userdata('user');
    	ini_set('max_execution_time', 300);
    	$request = $_GET['requrl'];
    	$api_key = env('BLACK_KNIGHT_KEY');        
		$request .= '&key=' . $api_key;
		$query_string = parse_url($request,PHP_URL_QUERY);
        parse_str($query_string, $requestParams);
        $getsortedresults = isset($_GET['getsortedresults'])?$_GET['getsortedresults']:'false';
        $opts = array(
        	'http'=>array(
        		'header' => "User-Agent:MyAgent/1.0\r\n"
        	),
        	"ssl"=>array(
		        "verify_peer"=>false,
		        "verify_peer_name"=>false,
		    )
        );
        $context = stream_context_create($opts);
        $this->load->model('order/apiLogs');
        $logid = $this->apiLogs->syncLogs($userdata['id'], 'black knight', 'address_search', $request, $requestParams, array(), 0, 0);
        $file = file_get_contents($request,false,$context);
        $xmlData = simplexml_load_string($file);
		$response = json_encode($xmlData);
		$result = json_decode($response,TRUE);
		$this->apiLogs->syncLogs($userdata['id'], 'black knight', 'address_search', $request, array(), $result, 0, $logid);
        echo trim($file);
    }

    public function updatePrelimAction()
	{
		$fileId = $this->uri->segment(2);
		$endPoint = 'files/'. $fileId.'/actions';
        $user_data['admin_api'] = 1; 
        $logid = $this->apiLogs->syncLogs(0, 'resware', 'get_actions_for_order', env('RESWARE_ORDER_API').$endPoint, array(), array(), 0, 0);
        $res = $this->resware->make_request('GET', $endPoint, array(), $user_data);
        $this->apiLogs->syncLogs(0, 'resware', 'get_actions_for_order', env('RESWARE_ORDER_API').$endPoint, array(), $res, 0, $logid);
        $result = json_decode($res,TRUE);
		$error = '';
		$success = '';

        if (isset($result['Actions']) && !empty($result['Actions'])) {
            $array_keymap = $this->order->array_recursive_search_key_map(126, $result['Actions']);
            if(!empty($array_keymap)) {
                $actionData = array(
                    'StartTask' => array(
                        'CoordinatorTypeID'=> 19,
                        'DueDate' => '/Date('.(strtotime(date('Y-m-d H:i:s'))*1000).'-0000)/'
                    )
                );
                $endPoint = 'files/'. $fileId.'/actions/'.$result['Actions'][$array_keymap[0]]['FileActionID'];
                $user_data['admin_api'] = 1; 
                $actionData = json_encode($actionData);
                $logid = $this->apiLogs->syncLogs(0, 'resware', 'update_actions_for_order', env('RESWARE_ORDER_API').$endPoint, $actionData, array(), $fileId, 0);
                $res = $this->resware->make_request('PUT', $endPoint,  $actionData, $user_data);
                $this->apiLogs->syncLogs(0, 'resware', 'update_actions_for_order', env('RESWARE_ORDER_API').$endPoint,  $actionData, $res, $fileId, $logid);
                $result = json_decode($res,TRUE);

				if(!empty($result['FileActionID'])) {
					$success = 'Prelim action updated successfully.';
				} else {
					$error = 'Something went wrong during update action prelim';
				}

            } else {
                $actionData = array(
                    'ActionType' => array(
                        'ActionTypeID' => 126
                    ),
                    'Group' => array(
                        'ActionGroupID' => 6
                    ),    
                    'StartTask' => array(
                        'CoordinatorTypeID'=> 19,
                        'DueDate' => '/Date('.(strtotime(date('Y-m-d H:i:s'))*1000).'-0000)/'
                    )
                );
                $endPoint = 'files/'. $fileId.'/actions/';
                $user_data['admin_api'] = 1; 
                $actionData = json_encode($actionData);
                $logid = $this->apiLogs->syncLogs(0, 'resware', 'add_actions_for_order', env('RESWARE_ORDER_API').$endPoint, $actionData, array(), $fileId, 0);
                $res = $this->resware->make_request('POST', $endPoint, $actionData, $user_data);
                $this->apiLogs->syncLogs(0, 'resware', 'add_actions_for_order', env('RESWARE_ORDER_API').$endPoint, $actionData, $res, $fileId, $logid);
                $result = json_decode($res,TRUE);

				if(!empty($result['FileActionID'])) {
					$success = 'Prelim action updated successfully.';
				} else {
					$error = 'Something went wrong during update action prelim';
				}
            }
        }
		$data = array(
			"error" =>  $error,
			"success" => $success
		);
		$this->session->set_userdata($data);
		redirect(base_url().'review-file/'.$fileId);
	}

    function get_partners()
    {
    	$fileId = $this->input->post('fileId');
    	if ($fileId) {
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
    	} else {
    		$res = array('status'=>'error','msg'=>"Please select file.");
    	}
    	echo json_encode($res);
    }

	function uploadDocOrders()
    {
		$data['title'] = 'Smart Dashboard | Pacific Coast Title Company';
		$this->load->view('layout/head_dashboard',$data);
		$this->load->view('order/common/upload_doc_orders');
	}

	function getOrdersUploadDoc()
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
		$this->load->view('order/common/upload_documents');
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

					$this->order->uploadDocumentOnAwsS3($document_name, 'documents');
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
					if ($userdata['is_title_officer'] == 1 || $userdata['is_master'] == 1) {
						$user_data['admin_api'] = 1; 
					}
					
					$logid = $this->apiLogs->syncLogs($userdata['id'], 'resware', 'create_document', env('RESWARE_ORDER_API').$endPoint, $documentApiData, array(), $orderId, 0);
					$result = $this->resware->make_request('POST', $endPoint, $document_api_data, $user_data);
					$this->apiLogs->syncLogs($userdata['id'], 'resware', 'create_document', env('RESWARE_ORDER_API').$endPoint, $documentApiData, $result, $orderId, $logid);
					$res = json_decode($result);
					if (!empty($res->Document->DocumentID)) {
						$this->document->update(array('api_document_id' => $res->Document->DocumentID), array('id' => $documentId));
						$success[$i] = "Document #".$i.": uploaded successfully";
					} else {
						$errors[$i] = "Document #".$i.": Something went wrong.Please try again";
					}
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
}