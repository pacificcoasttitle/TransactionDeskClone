<?php

(defined('BASEPATH')) OR exit('No direct script access allowed');

class TitleOfficers extends MX_Controller 
{
	private $title_officer_dashboard_js_version = '01';
	function __construct() 
    {
        parent::__construct();
		$this->load->helper(
            array('file', 'url','form')
        );
        $this->load->library('session');
		$this->load->library('form_validation');
		$this->load->library('order/template');
		$this->load->library('order/order');
        $this->load->model('order/apiLogs');
        $this->load->model('order/reviewPrelimData');
		$this->load->model('order/titleOfficer');
		$this->load->model('order/home_model');
		$this->load->library('order/resware');
		$this->load->library('order/common');
		$this->common->is_title_officer_user();
	}
	
	public function index()
	{
		$userdata = $this->session->userdata('user');
		$name = isset($userdata['name']) && !empty($userdata['name']) ? $userdata['name'] : '';
		$data['name'] = $name;
		$data['user_email'] = $userdata['email'];
		$data['title'] = 'Smart Dashboard | Pacific Coast Title Company';
		$con = array('id' => $userdata['id']);
		$user_info = $this->order->getSalesRep($con);
		$data['user_info'] = $user_info;
		$this->template->addJS( base_url('assets/frontend/js/order/title_officer_dashboard.js?v=title_officer_dashboard_'.$this->title_officer_dashboard_js_version) );
		$this->template->show("order/title_officer", "dashboard", $data);
	}

	function get_title_officer_orders()
    {
        $params = array();  $data = array();
        $status = $this->input->post('status');
		$month = $this->input->post('month') ? $this->input->post('month') :  '';
        $params['status'] = isset($status) && !empty($status) ? $status : 'open';
		$params['month'] = isset($month) && !empty($month) ? $month : date('m');
		
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
				$nestedData[] = date("m/d/Y", strtotime($order['created_at']));
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

	function notes()
    {
        $data['title'] = 'Notes | Pacific Coast Title Company';
		$this->template->addJS( base_url('assets/frontend/js/order/title_officer_dashboard.js?v=title_officer_dashboard_'.$this->title_officer_dashboard_js_version) );
		$this->template->show("order/title_officer", "notes", $data);
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
        $orderDetails = $this->order->get_order_details($fileId);
		$orderId = isset($orderDetails['order_id']) && !empty($orderDetails['order_id']) ? $orderDetails['order_id'] : '';
		$data['orderDetails'] = $orderDetails;
		$data['notes'] = $this->order->get_order_notes($orderId);
       
		$this->template->addJS( base_url('assets/frontend/js/order/title_officer_dashboard.js?v=title_officer_dashboard_'.$this->title_officer_dashboard_js_version) );
		$this->template->show("order/title_officer", "get_notes", $data);
    }

    public function create_note()
    {
    	$fileId = isset($_POST['fileId']) && !empty($_POST['fileId']) ? $_POST['fileId'] : '';
		$errors = array();
		$success = array();
    	if (isset($fileId) && !empty($fileId)) {
    		$userdata = $this->session->userdata('user');
    		$subject = isset($_POST['subject']) && !empty($_POST['subject']) ? $_POST['subject'] : '';
    		$body = isset($_POST['body']) && !empty($_POST['body']) ? $_POST['body'] : '';
    		$orderDetails = $this->order->get_order_details($fileId);
			$orderId = isset($orderDetails['order_id']) && !empty($orderDetails['order_id']) ? $orderDetails['order_id'] : '';
    		$this->load->library('order/resware');
	        $request = array();
	        $endPoint = 'files/'.$fileId.'/notes';
	        $request['Subject'] = $subject;
	        $request['Body'] = $body;
	        $request['FileID'] = $fileId;
	        $notes_data = json_encode($request);
			$user_data = array();

			if ($userdata['is_title_officer'] == 1 || $userdata['is_master'] == 1) {
				$user_data['admin_api'] = 1; 
			}
			
	        $logid = $this->apiLogs->syncLogs($userdata['id'], 'resware', 'create_note', env('RESWARE_ORDER_API').$endPoint, $notes_data, array(), $orderId, 0);        
	        $result = $this->resware->make_request('POST', $endPoint, $notes_data, $user_data);
	        $this->apiLogs->syncLogs($userdata['id'], 'resware', 'create_note', env('RESWARE_ORDER_API').$endPoint, $notes_data, $result, $orderId, $logid);
			
	        if (isset($result) && !empty($result)) {
	            $response = json_decode($result, TRUE);

	            if (isset($response['ResponseStatus']) && !empty($response['ResponseStatus'])) {
					$message = isset($response['ResponseStatus']['Message']) && !empty($response['ResponseStatus']['Message']) ? $response['ResponseStatus']['Message'] : '';
					$errors[] = $message;
				} else {
					$noteId = isset($response['Note']['NoteID']) && !empty($response['Note']['NoteID']) ? $response['Note']['NoteID'] : '';
					$this->load->model('order/note');
			        $notesData = array(
			            'resware_note_id' => $noteId,
						'subject' => $subject,
						'note' => $body,
			            'user_id' => $userdata['id'],
			            'order_id' => $orderId
			        );
			        $id = $this->note->insert($notesData);
			        if ($noteId && $id) {
						$success[] = 'Note created successfully.';
			        } else {
						$errors[] = 'Something went wrong. Please try again.';
			        }
				}
	    	}
			$data = array(
				"errors" =>  $errors,
				"success" => $success
			);
			$this->session->set_userdata($data);
			redirect(base_url().'get-notes/'.$fileId);
	    }
    }

    function uploadFileDocument() 
	{
		$data['title'] = 'Smart Dashboard | Upload FIle';
		$this->template->addJS( base_url('assets/frontend/js/order/title_officer_dashboard.js?v=title_officer_dashboard_'.$this->title_officer_dashboard_js_version) );
		$this->template->show("order/title_officer", "attach_files", $data);
	}

	function getFileDocument() 
	{
		$this->load->model('order/fileDocument_model');
		$userdata = $this->session->userdata('user');
		$files_data = $this->fileDocument_model->get_forms();

		$tableData = array();
		foreach ($files_data as $key=>$file_data) {
			$tmp_array = array();
			$tmp_array[] = ($key + 1);
			$tmp_array[] = $file_data->name;
			$tmp_array[] = $file_data->description;
			$tmp_array[] = date('m/d/Y',strtotime($file_data->created_at));
			$documentName = $file_data->file_path;
			if (env('AWS_ENABLE_FLAG') == 1) {
                        $documentUrl = env('AWS_PATH')."file_document/".$documentName;
						$action = "<a href='#' onclick='downloadDocumentFromAws(".'"'.$documentUrl.'"'.", ".'"'.$documentName.'"'.");'><button class='btn btn-grad-2a' type='button' style='background: #d35411;'>Download</button></a>";
                    } else {
                        $documentUrl = FCPATH.'uploads/file_document/'.$documentName;
						$action = '<a href="'.$documentUrl.'" download><button class="btn btn-grad-2a" type="button" style="background: #d35411;">Download</button></a>';
                    }
            $tmp_array[] = $action;
            $tableData[] = $tmp_array;
		}

		$json_data['recordsTotal'] = count($tableData);
        $json_data['recordsFiltered'] = count($tableData);
        $json_data['data'] = $tableData;
        echo json_encode($json_data);
	}

	public function downloadAwsDocument()
    {
        $url = $this->input->post('url');
        $binaryData   = base64_encode(file_get_contents($url)); 
		echo $binaryData;exit;
    }
}