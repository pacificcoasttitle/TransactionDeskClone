<?php

use Illuminate\Support\Arr;

defined('BASEPATH') OR exit('No direct script access allowed');

class Orders extends MX_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */

    private $orders_js_version = '01';
	public function __construct()
    {
        parent::__construct();
        $this->load->helper(
            array('file', 'url','form')
        );
        $this->load->library('hr/adminTemplate');
        $this->load->model('hr/hr'); 
        $this->load->library('hr/common');
        $this->load->model('hr/branches_model');
        $this->load->model('escrow/tasks_model');
        $this->common->is_hr_admin();
    }

    public function index()
    {
        $data['title'] = 'Escrow Orders';
        $data['page_title'] = 'Orders';
        $data['errors'] = '';
		$data['success'] = '';
		if ($this->session->userdata('errors')) {
			$data['errors'] = $this->session->userdata('errors');
			$this->session->unset_userdata('errors');
		}
		if ($this->session->userdata('success')) {
			$data['success'] = $this->session->userdata('success');
			$this->session->unset_userdata('success');
		}
        $this->admintemplate->addCSS( base_url('assets/backend/hr/vendor/datatables/dataTables.bootstrap4.min.css'));
        $this->admintemplate->addJS( base_url('assets/backend/hr/vendor/datatables/jquery.dataTables.min.js'));
        $this->admintemplate->addJS( base_url('assets/backend/hr/vendor/datatables/dataTables.bootstrap4.min.js'));
        $this->admintemplate->addJS( base_url('assets/backend/hr/js/orders.js?v=orders_'.$this->orders_js_version) );
        $this->admintemplate->show("hr", "orders", $data);
    }

    public function getOrders()
    {
        $params = array();
        if (isset($_POST['draw']) && !empty($_POST['draw'])) {
            $params['draw'] = isset($_POST['draw']) && !empty($_POST['draw']) ? $_POST['draw'] : 10;
            $params['length'] = isset($_POST['length']) && !empty($_POST['length']) ? $_POST['length'] : 10;
            $params['start'] = isset($_POST['start']) && !empty($_POST['start']) ? $_POST['start'] : 0;
            $params['orderColumn'] = isset($_POST['order'][0]['column']) && !empty($_POST['order'][0]['column']) ? $_POST['order'][0]['column'] : 0;
            $params['orderDir'] = isset($_POST['order'][0]['dir']) && !empty($_POST['order'][0]['dir']) ? $_POST['order'][0]['dir'] : 0;
            $params['searchvalue'] = isset($_POST['search']['value']) && !empty($_POST['search']['value']) ? $_POST['search']['value'] : '';
            $userTypes = $this->common->getOrders($params);
            $json_data['draw'] = intval( $params['draw'] );
        } else {
            $params['searchvalue'] = isset($_POST['keyword']) && !empty($_POST['keyword']) ? $_POST['keyword'] : '';
            $userTypes = $this->common->getOrders($params);            
        }

        $data = array(); 
        $count = $params['start'] + 1;
	    if (isset($userTypes['data']) && !empty($userTypes['data'])) {
	    	foreach ($userTypes['data'] as $key => $value)  {
	    		$nestedData=array();
                $nestedData[] = $count;
                $nestedData[] = $value['file_number'];
                $nestedData[] = $value['full_address'];
                $nestedData[] = $value['product_type'];
                $nestedData[] = $value['created_at'];
                $editUrl = base_url().'hr/admin/order-tasks/'.$value['id'];
                $nestedData[] = '<div style="display:inline-flex;">
                    <a href="'.$editUrl.'" class="btn btn-info btn-icon-split btn-sm">
                        <span class="icon text-white-50">
                            <i class="fas fa-clipboard-check"></i>
                        </span>
                        <span class="text">Task</span>
                    </a>
                    
                </div>';
	            $data[] = $nestedData;    
                $count++;          
	    	}
	    }
        $json_data['recordsTotal'] = intval( $userTypes['recordsTotal'] );
        $json_data['recordsFiltered'] = intval( $userTypes['recordsFiltered'] );
        $json_data['data'] = $data;
	    echo json_encode($json_data);
    }

    public function orderTasks($id)
	{
        $userdata = $this->session->userdata('hr_admin');
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
            
            /*if ($userdata['is_escrow_manager'] == 1) {
                if (!empty($orderInfo->escrow_officer_id)) {
                    $escrowInfoFromOrder = $this->common->getEscrowOfficerInfoBasedOnIdFromOrder($orderInfo->escrow_officer_id); 
                    $escrowInfo = $this->escrow_user_model->get_by('email', $escrowInfoFromOrder['email']);
                    $notificationData = array(
                        'sent_user_id' => $escrowInfo->id,
                        'message' => $message,
                        'type' =>  'completed'
                    );
                    $this->common->insert($notificationData, 'pct_hr_notifications');
                    $this->common->sendNotification($message, 'completed', $escrowInfo->id, 0);
                    $assistantUsersInfo = $this->escrow_user_model->get_many_by(array('branch_id' => $escrowInfo->branch_id, 'position_id' => 15));
                    foreach ($assistantUsersInfo as $assistantUser) {
                        $notificationData = array(
                            'sent_user_id' => $assistantUser->id,
                            'message' => $message,
                            'type' =>  'completed'
                        );
                        $this->common->insert($notificationData, 'pct_hr_notifications');
                        $this->common->sendNotification($message, 'completed', $assistantUser->id, 0);
                    }
                }
            } else if ($userdata['is_escrow_officer'] == 1) {
                $notificationData = array(
                    'sent_user_id' => 0,
                    'message' => $message,
                    'type' =>  'completed'
                );
                $this->common->insert($notificationData, 'pct_hr_notifications');
                $this->common->sendNotification($message, 'completed', 0, 1);

                $assistantUsersInfo = $this->escrow_user_model->get_many_by(array('branch_id' => $userdata['branch_id'], 'position_id' => 15));
                foreach ($assistantUsersInfo as $assistantUser) {
                    $notificationData = array(
                        'sent_user_id' => $assistantUser->id,
                        'message' => $message,
                        'type' =>  'completed'
                    );
                    $this->common->insert($notificationData, 'pct_hr_notifications');
                    $this->common->sendNotification($message, 'completed', $assistantUser->id, 0);
                }

            } else if ($userdata['is_escrow_assistant'] == 1) {
                $notificationData = array(
                    'sent_user_id' => 0,
                    'message' => $message,
                    'type' =>  'completed'
                );
                $this->common->insert($notificationData, 'pct_hr_notifications');
                $this->common->sendNotification($message, 'completed', 0, 1);

                $escrowInfoFromOrder = $this->common->getEscrowOfficerInfoBasedOnIdFromOrder($orderInfo->escrow_officer_id); 
                $escrowInfo = $this->escrow_user_model->get_by('email', $escrowInfoFromOrder['email']);
                $notificationData = array(
                    'sent_user_id' => $escrowInfo->id,
                    'message' => $message,
                    'type' =>  'completed'
                );
                $this->common->insert($notificationData, 'pct_hr_notifications');
                $this->common->sendNotification($message, 'completed', $escrowInfo->id, 0);
            }*/
            $successMsg = 'Order task List Updated';
            $this->session->set_userdata('success', $successMsg);
            redirect(base_url().'hr/admin/orders');
        }
        $data['tasks'] = $tasks;
        $data['completedTaskIds'] = $completedTaskIds;
		$this->admintemplate->addJS( base_url('assets/backend/escrow/js/tasks.js?v=order_tasks_'.$this->orders_js_version) );
        $this->admintemplate->show("hr", "order_tasks", $data);
	}
}
