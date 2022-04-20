<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Users extends MX_Controller {

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

	public function __construct()
    {
        parent::__construct();
        $this->load->helper(
            array('file', 'url','form')
        );
        $this->load->library('form_validation');
        $this->load->library('escrow/template');
        $this->load->library('escrow/common');
        $this->common->is_escrow_admin();
    }

    public function index()
    {
        $data['title'] = 'Escrow Users';
        $data['page_title'] = 'Users';
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
        $this->template->addCSS( base_url('assets/backend/hr/vendor/datatables/dataTables.bootstrap4.min.css'));
        $this->template->addJS( base_url('assets/backend/hr/vendor/datatables/jquery.dataTables.min.js'));
        $this->template->addJS( base_url('assets/backend/hr/vendor/datatables/dataTables.bootstrap4.min.js'));
        $this->template->addJS( base_url('assets/backend/hr/js/custom.js') );
        $this->template->show("escrow", "users", $data);
    }

    public function getUsers()
    {
        $params = array();
        $userdata = $this->session->userdata('hr_admin');
        if (isset($_POST['draw']) && !empty($_POST['draw'])) {
            $params['draw'] = isset($_POST['draw']) && !empty($_POST['draw']) ? $_POST['draw'] : 10;
            $params['length'] = isset($_POST['length']) && !empty($_POST['length']) ? $_POST['length'] : 10;
            $params['start'] = isset($_POST['start']) && !empty($_POST['start']) ? $_POST['start'] : 0;
            $params['orderColumn'] = isset($_POST['order'][0]['column']) && !empty($_POST['order'][0]['column']) ? $_POST['order'][0]['column'] : 0;
            $params['orderDir'] = isset($_POST['order'][0]['dir']) && !empty($_POST['order'][0]['dir']) ? $_POST['order'][0]['dir'] : 0;
            $params['searchvalue'] = isset($_POST['search']['value']) && !empty($_POST['search']['value']) ? $_POST['search']['value'] : '';
            $users = $this->common->getUsers($params);
            $json_data['draw'] = intval( $params['draw'] );
        } else {
            $params['searchvalue'] = isset($_POST['keyword']) && !empty($_POST['keyword']) ? $_POST['keyword'] : '';
            $users = $this->common->getUsers($params);            
        }

        $data = array(); 
		


        $count = $params['start'] + 1;
	    if (isset($users['data']) && !empty($users['data'])) {
	    	foreach ($users['data'] as $key => $value)  {
	    		$nestedData=array();
                $nestedData[] = $count;
	            $nestedData[] = $value['first_name']." ".$value['last_name'];
                $nestedData[] = $value['email'];
                $nestedData[] = $value['position'];
                $nestedData[] = $value['branch_name'];
                $nestedData[] = $value['name'];
                //$nestedData[] = $value['employee_id'];
                $nestedData[] = date("m/d/Y", strtotime($value['hire_date'])); 

				

                if($userdata['user_type_id'] == 1 || $userdata['user_type_id'] == 2) {
                    if(isset($_POST['draw']) && !empty($_POST['draw'])) {
                        $editUrl = base_url().'hr/admin/edit-user/'.$value['id'];
                        $task_list = "";
                        if(trim(strtolower($value['name'])) == 'employee') {
                            $task_list_url = base_url().'hr/admin/users-tasks/'.$value['id'];
                            $task_list = '<a style="margin-left: 5px;" href="'.$task_list_url.'" class="btn btn-info btn-icon-split btn-sm">
                                            <span class="icon text-white-50">
                                                <i class="fas fa-clipboard-check"></i>
                                            </span>
                                            <span class="text">Task</span>
                                        </a>';
                        }
                        $nestedData[] = '<div style="display:inline-flex;">
                                            <a href="'.$editUrl.'" class="btn btn-info btn-icon-split btn-sm">
                                                <span class="icon text-white-50">
                                                    <i class="fas fa-pencil-alt"></i>
                                                </span>
                                                <span class="text">Edit</span>
                                            </a>
                                            <a style="margin-left: 5px;" href="#" onclick="deleteUser('.$value["id"].')" class="btn btn-danger btn-icon-split btn-sm">
                                                <span class="icon text-white-50">
                                                    <i class="fas fa-trash"></i>
                                                </span>
                                                <span class="text">Delete</span>
                                            </a>'.$task_list.$time_sheet_var.'
                                        </div>';
                    }
                }
				elseif($userdata['user_type_id'] == 4) {
					$nestedData[] = '<div style="display:inline-flex;">'.$time_sheet_var.'</div>';
				}
	            $data[] = $nestedData;    
                $count++;          
	    	}
	    }
        $json_data['recordsTotal'] = intval( $users['recordsTotal'] );
        $json_data['recordsFiltered'] = intval( $users['recordsFiltered'] );
        $json_data['data'] = $data;
	    echo json_encode($json_data);
    }

    

    

    

	public function getTask($id)
	{
		$this->load->model('hr/task_list_category');
		$this->load->model('hr/users_tasks_model');
		$this->load->model('hr/users_model');
		$user_record = $this->users_model->with('type')->get($id);
		if($user_record && trim(strtolower($user_record->type->name)) == 'employee'){

			$data['title'] = 'HR-Center New Rep Checklist';
			$data['page_title'] = 'New Rep Checklist';
			$tasks = $this->task_list_category->with('tasks')->get_many_by('status','1');
	
			$this->load->model('hr/task_position');
	
			$hr_task_positions = $this->task_position->get_many_by('position_id',$user_record->position_id);
			$data['hr_task_positions'] = array_column($hr_task_positions,'task_id');
			
			$users_tasks_all = $this->users_tasks_model->get_tasks($id);
			$users_tasks = array_column($users_tasks_all,"task_id");
			if ($this->input->post()) {
				$users_tasks_add = array();
				$task_done = $this->input->post('task_done');
				foreach($task_done as $task_id) {
					if(!(in_array($task_id,$users_tasks))){
						$users_task = array();
						$users_task['task_id'] = $task_id;
						$users_task['employee_id'] = $id;
						$users_tasks_add[] = $users_task;
					}
				}
				if(count($users_tasks_add)) {
					$this->users_tasks_model->insert_many($users_tasks_add);
				}
				//Delete records if task unchecked
				$delete_id_array = array();
				foreach($users_tasks_all as $users_task) {
					if(!(in_array($users_task['task_id'],$task_done))){
						$delete_id_array[] = $users_task['id'];
					}
				}
				if(count($delete_id_array)) {
					$this->users_tasks_model->delete_many($delete_id_array);
				}
				$successMsg = 'Task List Updated';
				$this->session->set_userdata('success', $successMsg);
				redirect(base_url().'hr/admin/users');
			}
	
			// $data = array();
			$data['tasks'] = $tasks;
			$data['users_tasks'] = $users_tasks;
			$this->admintemplate->addJS( base_url('assets/backend/hr/js/custom.js') );
			$this->admintemplate->show("hr", "users_tasks", $data);
		}
	}
}
