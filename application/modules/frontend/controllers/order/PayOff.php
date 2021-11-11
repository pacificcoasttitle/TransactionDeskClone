<?php

(defined('BASEPATH')) OR exit('No direct script access allowed');

class PayOff extends MX_Controller 
{
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
		$this->load->model('order/home_model');
		$this->load->library('order/resware');
		$this->load->library('order/common');
		$this->common->is_pay_off_user();
	}
	
	function index()
	{
		$userdata = $this->session->userdata('user');
		$name = isset($userdata['name']) && !empty($userdata['name']) ? $userdata['name'] : '';
		$data['name'] = $name;
		$data['user_email'] = $userdata['email'];
		$data['title'] = 'Smart Dashboard | Pacific Coast Title Company';
        $this->load->view('layout/head_dashboard',$data);
        $this->load->view('order/pay_off/pay_off_dashboard');
	}

	function get_pay_off_orders()
    {
        $params = array();  
        $data = array();
        $params['is_pay_off'] = 1;
		
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
                $file_id = $order['file_id'];
                $nestedData[] = date("m/d/Y", strtotime($order['created_at']));
				$nestedData[] = $order['file_number'];
                $nestedData[] = $order['first_name']." ".$order['last_name'];
				$nestedData[] = ucfirst($order['resware_status']);
				$nestedData[] = "<a href='javascript:void(0);' onclick='downloadPayOffDocument($file_id);'><button class='btn btn-grad-2a button-color' type='button'>View Package</button></a><a href='javascript:void(0);' onclick='updatePayOffAction($file_id);'><button class='btn btn-grad-2a button-color' type='button'>Disburse funds</button></a>";
                $data[] = $nestedData; 
                $i++; 
			}
        } 
        $json_data['recordsTotal'] = intval( $order_lists['recordsTotal'] );
        $json_data['recordsFiltered'] = intval( $order_lists['recordsFiltered'] );
        $json_data['data'] = $data;
        echo json_encode($json_data);
    }

	public function downloadPayOffDocument()
    {
		$userdata = $this->session->userdata('user');
		$file_id = $this->input->post('file_id');
		$user_data = array();
		$user_data = array(
			'admin_api' => 1
		);
		$user_data['from_mail'] = 1;

		$endPoint = 'files/'. $file_id .'/documents';
		$logid = $this->apiLogs->syncLogs($userdata['id'], 'resware', 'get_documents', env('RESWARE_ORDER_API').$endPoint, array(), array(), $file_id, 0);
		$resultDocuments = $this->resware->make_request('GET', $endPoint, '', $user_data);
		$this->apiLogs->syncLogs($userdata['id'], 'resware', 'get_documents', env('RESWARE_ORDER_API').$endPoint, array(), $resultDocuments, $file_id, $logid);
		$resDocuments = json_decode($resultDocuments, true);

		foreach($resDocuments['Documents'] as $orderDocuments) {
			if($orderDocuments['DocumentType']['DocumentTypeID'] == 1035) {
				$api_document_id = $orderDocuments['DocumentID'];
				$this->load->model('order/document');
				$endPoint = 'documents/'.$api_document_id.'?format=json';
				$logid = $this->apiLogs->syncLogs($userdata['id'], 'resware', 'get_document', env('RESWARE_ORDER_API').$endPoint, array(), array(), 0, 0);
				$resultDocument = $this->resware->make_request('GET', $endPoint, '', $user_data);
				$this->apiLogs->syncLogs($userdata['id'], 'resware', 'get_document', env('RESWARE_ORDER_API').$endPoint, array(), $resultDocument, 0, $logid);
				$resDocument = json_decode($resultDocument, true);
				if (isset($resDocument['Document']) && !empty($resDocument['Document'])) { 
					$binaryData  = $resDocument['Document']['DocumentBody'];
				}	
			}
		}
		echo $binaryData;exit;
	}

	public function updatePayOffAction()
	{
		$fileId = $this->input->post('file_id');
		$endPoint = 'files/'. $fileId.'/actions';
        $user_data['admin_api'] = 1; 
        $logid = $this->apiLogs->syncLogs(0, 'resware', 'get_actions_for_order', env('RESWARE_ORDER_API').$endPoint, array(), array(), 0, 0);
        $res = $this->resware->make_request('GET', $endPoint, array(), $user_data);
        $this->apiLogs->syncLogs(0, 'resware', 'get_actions_for_order', env('RESWARE_ORDER_API').$endPoint, array(), $res, 0, $logid);
        $result = json_decode($res,TRUE);
	
        if (isset($result['Actions']) && !empty($result['Actions'])) {
            $array_keymap = $this->order->array_recursive_search_key_map(154, $result['Actions']);
            if(!empty($array_keymap)) {
                $actionData = array(
                    'StartTask' => array(
                        'CoordinatorTypeID'=> 8,
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

				if (!empty($result['FileActionID'])) {
					$resultPayOffaction = array('status'=>'success', 'msg'=> 'Payoff action updated successfully.');
				} else {
					$resultPayOffaction = array('status'=>'error', 'msg' => 'Something went wrong during update action prelim.');
				}
            } else {
                $actionData = array(
                    'ActionType' => array(
                        'ActionTypeID' => 154
                    ),
                    'Group' => array(
                        'ActionGroupID' => 3
                    ),    
                    'StartTask' => array(
                        'CoordinatorTypeID'=> 8,
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

				if (!empty($result['FileActionID'])) {
					$resultPayOffaction = array('status'=>'success', 'msg'=> 'Payoff action added successfully.');
				} else {
					$resultPayOffaction = array('status'=>'error', 'msg'=> 'Something went wrong during update action prelim.');
				}
            }
        }
		echo json_encode($resultPayOffaction);
	}
}