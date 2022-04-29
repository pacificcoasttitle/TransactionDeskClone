<?php

(defined('BASEPATH')) OR exit('No direct script access allowed');

class Escrow extends MX_Controller 
{
    private $escrow_js_version = '01';
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
		$this->load->model('order/home_model');
		$this->load->library('order/resware');
		$this->load->library('order/common');
		$this->common->is_escrow_user();
	}
	
	function index()
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

		$userdata = $this->session->userdata('user');
		$name = isset($userdata['name']) && !empty($userdata['name']) ? $userdata['name'] : '';
		$data['name'] = $name;
		$data['user_email'] = $userdata['email'];
		$data['title'] = 'Smart Dashboard | Pacific Coast Title Company';
        $this->template->addJS( base_url('assets/frontend/js/order/escrow.js?v=escrow_'.$this->escrow_js_version));
		$this->template->show("order/escrow", "dashboard", $data);
	}

	function get_escrow_orders()
    {
        $params = array();  
        $data = array();
    
        if (isset($_POST['draw']) && !empty($_POST['draw'])) {
            $params['draw'] = isset($_POST['draw']) && !empty($_POST['draw']) ? $_POST['draw'] : 10;
            $params['length'] = isset($_POST['length']) && !empty($_POST['length']) ? $_POST['length'] : 2;
            $params['start'] = isset($_POST['start']) && !empty($_POST['start']) ? $_POST['start'] : 0;
            $params['orderColumn'] = isset($_POST['order'][0]['column']) && !empty($_POST['order'][0]['column']) ? $_POST['order'][0]['column'] : 0;
            $params['orderDir'] = isset($_POST['order'][0]['dir']) && !empty($_POST['order'][0]['dir']) ? $_POST['order'][0]['dir'] : 0;
            $params['searchvalue'] = isset($_POST['search']['value']) && !empty($_POST['search']['value']) ? $_POST['search']['value'] : '';
            $pageno = ($params['start'] / $params['length'])+1;
            $order_lists = $this->order->getEscrowOrders($params);
            $json_data['draw'] = intval( $params['draw'] );
        } else {
            $params['searchvalue'] = isset($_POST['keyword']) && !empty($_POST['keyword']) ? $_POST['keyword'] : '';
            $order_lists = $this->order->getEscrowOrders($params);
        }

        if (isset($order_lists['data']) && !empty($order_lists['data'])) {
            $i = $params['start'] + 1;
            foreach ($order_lists['data'] as $order)  {

                $nestedData = array();
                $nestedData[] = $i;
                $nestedData[] = $order['file_number'];
                $nestedData[] = $order['full_address'];
                $nestedData[] = $order['product_type'];
                $nestedData[] = date("m/d/Y", strtotime($order['created_at']));
                $editUrl = base_url().'order/escrow/order-tasks/'.$order['id'];
                $nestedData[] = "<a href='$editUrl'>
                                    <button class='btn btn-grad-2a button-color' type='button'>Tasks</button>
                                </a>";
                $data[] = $nestedData; 
                $i++; 
			}
        } 
        $json_data['recordsTotal'] = intval( $order_lists['recordsTotal'] );
        $json_data['recordsFiltered'] = intval( $order_lists['recordsFiltered'] );
        $json_data['data'] = $data;
        echo json_encode($json_data);
    }

    public function orderTasks($id)
	{
        $data['title'] = 'Escrow Order Tasks';
        $data['page_title'] = 'Order Tasks';
		$this->load->model('escrow/tasks_model');
        $this->load->model('escrow/order_model');
        $this->load->model('escrow/order_completed_tasks_model');
        $this->load->model('escrow/escrow_user_model');
        $orderInfo = $this->order_model->get($id);
        $prod_type = $orderInfo->prod_type;
		$tasks = json_decode(json_encode($this->tasks_model->get_many_by("(status = 1 and (prod_type = 'both' or prod_type = '$prod_type') )")), true);
        $completedTasksInfo = $this->order_completed_tasks_model->get_many_by("(order_id = $id)");
        if (!empty($completedTasksInfo)) {
            $completedTasks = json_decode(json_encode($completedTasksInfo), true);
            $completedTaskIds = array_column($completedTasks, 'task_id');	
        } else {
            $completedTasks = array();
            $completedTaskIds = array();
        }
        
        if ($this->input->post()) {
            $completed_task_name = array();
            $incompleted_task_name = array();
            $orders_tasks_add = array();
            $task_done = $this->input->post('task_done');
            $message = '';

            foreach($task_done as $task_id) {
                if (!(in_array($task_id, $completedTaskIds))) {
                    $order_tasks = array();
                    $order_tasks['task_id'] = $task_id;
                    $order_tasks['order_id'] = $id;
                    $order_tasks['completed_by'] = $userdata['id'];
                    $orders_tasks_add[] = $order_tasks;
                    $taskKey = array_search($task_id, array_column($tasks, 'id'));
                    $completed_task_name[] = $tasks[$taskKey]['name'];
                }
            }

            if (count($orders_tasks_add)) {
                $this->order_completed_tasks_model->insert_many($orders_tasks_add);
            }

            $delete_id_array = array();
            if (!empty($completedTasks)) {
                foreach ($completedTasks as $task) {
                    if (!(in_array($task['task_id'], $task_done))){
                        $delete_id_array[] = $task['id'];
                        $incompleteTaskKey = array_search($task['id'], array_column($tasks, 'id'));
                        $incompleted_task_name[] = $tasks[$incompleteTaskKey]['name'];
                    }
                }
            }
            
            if (count($delete_id_array)) {
                $this->order_completed_tasks_model->delete_many($delete_id_array);
            }

            if (!empty($completed_task_name)) {
                if (count($completed_task_name) > 1) {
                    $task_names = implode(', ', $completed_task_name);
                    $message .= $task_names.' tasks of order #'.$orderInfo->file_number.' have been marked as complete by '.$userdata['name'];
                } else {
                    $message .= $completed_task_name[0].' task of order #'.$orderInfo->file_number.' has been marked as complete by '.$userdata['name'];
                }
            }

            if (!empty($incompleted_task_name)) {
                if (count($incompleted_task_name) > 1) {
                    $incompleted_task_names = implode(', ', $incompleted_task_name);
                    $message .= '<br>'.$incompleted_task_names.' tasks of order #'.$orderInfo->file_number.' have been marked as incomplete by '.$userdata['name'];
                } else {
                    $message .= '<br>'.$incompleted_task_name[0].' task of order #'.$orderInfo->file_number.' has been marked as incomplete by '.$userdata['name'];
                }
            }
            
            if (!empty($orderInfo->escrow_officer_id)) {
                $escrowInfoFromOrder = $this->common->getEscrowOfficerInfoBasedOnIdFromOrder($orderInfo->escrow_officer_id); 
                $notificationData = array(
                    'sent_user_id' => $escrowInfoFromOrder['id'],
                    'message' => $message,
                    'type' =>  'completed'
                );
                $this->hr->insert($notificationData, 'pct_order_notifications');
                $this->common->sendNotification($message, 'completed', $escrowInfoFromOrder['id'], 0);
                
                $assistantUsersInfo = $this->escrow_user_model->get_many_by(array('branch_id' => $escrowInfo->branch_id, 'position_id' => 15));
                foreach ($assistantUsersInfo as $assistantUser) {
                    $notificationData = array(
                        'sent_user_id' => $assistantUser->id,
                        'message' => $message,
                        'type' =>  'completed'
                    );
                    $this->hr->insert($notificationData, 'pct_hr_notifications');
                    $this->common->sendNotification($message, 'completed', $assistantUser->id, 0);
                }
            }
            $successMsg = 'Order task List Updated';
            $this->session->set_userdata('success', $successMsg);
            redirect(base_url().'hr/admin/orders');
        }
        $data['tasks'] = $tasks;
        $data['completedTaskIds'] = $completedTaskIds;
		$this->template->addJS( base_url('assets/backend/escrow/js/tasks.js?v=order_tasks_'.$this->orders_js_version) );
        $this->template->show("hr", "order_tasks", $data);
	}
}