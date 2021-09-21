<?php

(defined('BASEPATH')) OR exit('No direct script access allowed');

class TitleOfficers extends MX_Controller {

	function __construct() 
    {
        parent::__construct();
		$this->load->helper(
            array('file', 'url','form')
        );
        $this->load->library('session');
		$this->load->library('form_validation');
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
		/*$workedDays = $this->order->countWorkedDaysOfMonth();
		$workingDaysRemaining = $this->order->countWokingsDaysLeftOfMonth();
		$openRefiResult = $this->order->getOpenOrdersCountForRefiProducts(date('m'), 0);

		$data['refi_open_count'] = !empty($openRefiResult['refi_count']) ? $openRefiResult['refi_count'] : 0;
		$openSaleResult = $this->order->getOpenOrdersCountForSaleProducts(date('m'), 0);
		$data['sale_open_count'] = !empty($openSaleResult['sale_count']) ? $openSaleResult['sale_count'] : 0;
		$data['total_open_count'] = $data['sale_open_count'] + $data['refi_open_count'];

		if ($data['total_open_count'] > 0) {
			$numOfOpenOrderPerWorkedDays = $data['total_open_count']/$workedDays;
			$data['projected_open_count'] = (round($numOfOpenOrderPerWorkedDays*$workingDaysRemaining))+ $data['total_open_count'];
		} else {
			$numOfOpenOrderPerWorkedDays = 0;
			$data['projected_open_count'] = 0;
		}
		
		$closeRefiResult = $this->order->getClosedOrdersCountForRefiProducts(date('m'), 0);
		$data['refi_close_count'] = !empty($closeRefiResult['refi_count']) ? $closeRefiResult['refi_count'] : 0;
		$closeSaleResult = $this->order->getClosedOrdersCountForSaleProducts(date('m'), 0);
		$data['sale_close_count'] =  !empty($closeSaleResult['sale_count']) ? $closeSaleResult['sale_count'] : 0;
		$data['total_close_count'] = $data['refi_close_count'] + $data['sale_close_count'];

		if ($data['total_close_count'] > 0) {
			$numOfCloseOrderPerWorkedDays = $data['total_close_count']/$workedDays;
			$data['projected_close_count'] = (round($numOfCloseOrderPerWorkedDays*$workingDaysRemaining))+ $data['total_close_count'];
		} else {
			$numOfCloseOrderPerWorkedDays = 0;
			$data['projected_close_count'] = 0;
		}

		$openOrderRefiTotalPremium =  !empty($openRefiResult['total_premium_for_refi_open_orders']) ? $openRefiResult['total_premium_for_refi_open_orders'] : 0;
		$closeOrderRefiTotalPremium =  !empty($closeRefiResult['total_premium_for_refi_close_orders']) ? $closeRefiResult['total_premium_for_refi_close_orders'] : 0;
		$data['refi_total_premium'] = $openOrderRefiTotalPremium + $closeOrderRefiTotalPremium;
		$openOrderSaleTotalPremium =  !empty($openSaleResult['total_premium_for_sale_open_orders']) ? $openSaleResult['total_premium_for_sale_open_orders'] : 0;
		$closeOrderSaleTotalPremium =  !empty($closeSaleResult['total_premium_for_sale_close_orders']) ? $closeSaleResult['total_premium_for_sale_close_orders'] : 0;
		$data['sale_total_premium'] = $openOrderSaleTotalPremium + $closeOrderSaleTotalPremium;
		$data['total_premium'] = $data['sale_total_premium'] + $data['refi_total_premium'];
		if ($data['total_premium'] > 0) {
			$premiumWorkedDays = $data['total_premium']/$workedDays;
			$data['projected_revenue'] = (round($premiumWorkedDays*$workingDaysRemaining))+ $data['total_close_count'];
		} else {
			$premiumWorkedDays = 0;
			$data['projected_revenue'] = 0;
		}
		$totalCount = $data['sale_close_count'] + $data['refi_close_count'] + $data['sale_open_count'] + $data['refi_open_count'];
		if($totalCount > 0) { 
			$data['refi_close_order_percetage'] = round(($data['refi_close_count']*100)/$totalCount);
			$data['sale_close_order_percetage'] = round(($data['sale_close_count']*100)/$totalCount);
			$data['close_order_percetage'] = $data['refi_close_order_percetage'] + $data['sale_close_order_percetage'];
		} else {
			$data['refi_close_order_percetage'] = 0;
			$data['sale_close_order_percetage'] = 0;
			$data['close_order_percetage'] = 0;
		}*/
		$this->load->view('layout/head_dashboard',$data);
		$this->load->view('order/title_officer/dashboard');
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

	function titleOfficerProductionHistory()
	{
		$userdata = $this->session->userdata('user');
		$data['title'] = 'Sales Production History | Pacific Coast Title Company';
		$titleOfficerHistory = array();
		for ($iM = 1; $iM <= (int)date('m'); $iM++) {
			$month = date("m", strtotime("$iM/12/10"));
			$dateObj   = DateTime::createFromFormat('!m', $iM);
			$monthName = $dateObj->format('F'); 
			$titleOfficerHistory[$iM-1]['month'] = $monthName;

			$openRefiResult = $this->order->getOpenOrdersCountForRefiProducts($month, 0);
			$refi_open_count = !empty($openRefiResult['refi_count']) ? $openRefiResult['refi_count'] : 0;
			$openSaleResult = $this->order->getOpenOrdersCountForSaleProducts($month, 0);
			$sale_open_count = !empty($openSaleResult['sale_count']) ? $openSaleResult['sale_count'] : 0;
			$titleOfficerHistory[$iM-1]['total_open_count'] = $sale_open_count + $refi_open_count;

			$closeRefiResult = $this->order->getClosedOrdersCountForRefiProducts($month, 0);
			$refi_close_count = !empty($closeRefiResult['refi_count']) ? $closeRefiResult['refi_count'] : 0;
			$closeSaleResult = $this->order->getClosedOrdersCountForSaleProducts($month, 0);
			$sale_close_count =  !empty($closeSaleResult['sale_count']) ? $closeSaleResult['sale_count'] : 0;
			$titleOfficerHistory[$iM-1]['total_close_count'] = $refi_close_count + $sale_close_count;

			$openOrderRefiTotalPremium =  !empty($openRefiResult['total_premium_for_refi_open_orders']) ? $openRefiResult['total_premium_for_refi_open_orders'] : 0;
			$closeOrderRefiTotalPremium =  !empty($closeRefiResult['total_premium_for_refi_close_orders']) ? $closeRefiResult['total_premium_for_refi_close_orders'] : 0;
			$refi_total_premium = $openOrderRefiTotalPremium + $closeOrderRefiTotalPremium;
			$openOrderSaleTotalPremium =  !empty($openSaleResult['total_premium_for_sale_open_orders']) ? $openSaleResult['total_premium_for_sale_open_orders'] : 0;
			$closeOrderSaleTotalPremium =  !empty($closeSaleResult['total_premium_for_sale_close_orders']) ? $closeSaleResult['total_premium_for_sale_close_orders'] : 0;
			$sale_total_premium = $openOrderSaleTotalPremium + $closeOrderSaleTotalPremium;
			$titleOfficerHistory[$iM-1]['total_premium'] = $sale_total_premium + $refi_total_premium;

			$totalCount = $sale_close_count + $refi_close_count + $sale_open_count + $refi_open_count;
			if($totalCount > 0) { 
				$refi_close_order_percetage = round(($refi_close_count*100)/$totalCount);
				$sale_close_order_percetage = round(($sale_close_count*100)/$totalCount);
				$titleOfficerHistory[$iM-1]['close_order_percetage'] = $refi_close_order_percetage + $sale_close_order_percetage;
			} else {
				$refi_close_order_percetage = 0;
				$sale_close_order_percetage = 0;
				$titleOfficerHistory[$iM-1]['close_order_percetage'] = 0;
			}
		}
		$data['titleOfficerHistory'] = $titleOfficerHistory;
		$this->load->view('layout/head_dashboard',$data);
		$this->load->view('order/title_officer/production_history');
	}

	function notes()
    {
        $data['title'] = 'Notes | Pacific Coast Title Company';
        $this->load->view('layout/head_dashboard',$data);
        $this->load->view('order/title_officer/notes');
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
        $this->load->view('layout/head_dashboard',$data);
        $this->load->view('order/title_officer/get_notes');
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

    function uploadFileDocument() {
		
		$data['title'] = 'Smart Dashboard | Upload FIle';
		$this->load->view('layout/head_dashboard',$data);
		$this->load->view('order/title_officer/attach_files');
	}
	function getFileDocument() {
		$this->load->model('order/fileDocument_model');
		$userdata = $this->session->userdata('user');
		// $where = array('added_by'=>$userdata['id']);
		$files_data = $this->fileDocument_model->get_all();

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