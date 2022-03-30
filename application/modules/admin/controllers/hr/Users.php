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
        $this->load->library('hr/adminTemplate');
        $this->load->model('hr/hr'); 
        $this->load->library('hr/common');
        $this->load->model('hr/branches_model');
        $this->common->is_hr_admin();
    }

    public function index()
    {
        $data['title'] = 'HR-Center Users';
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
        $this->admintemplate->addCSS( base_url('assets/backend/hr/vendor/datatables/dataTables.bootstrap4.min.css'));
        $this->admintemplate->addJS( base_url('assets/backend/hr/vendor/datatables/jquery.dataTables.min.js'));
        $this->admintemplate->addJS( base_url('assets/backend/hr/vendor/datatables/dataTables.bootstrap4.min.js'));
        $this->admintemplate->addJS( base_url('assets/backend/hr/js/custom.js') );
        $this->admintemplate->show("hr", "users", $data);
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
            $users = $this->hr->getUsers($params);
            $json_data['draw'] = intval( $params['draw'] );
        } else {
            $params['searchvalue'] = isset($_POST['keyword']) && !empty($_POST['keyword']) ? $_POST['keyword'] : '';
            $users = $this->hr->getUsers($params);            
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
                $nestedData[] = $value['name'];
                $nestedData[] = $value['department_name'];
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
                                            </a>'.$task_list.'
                                        </div>';
                    }
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

    public function addUser()
    {
        $userdata = $this->session->userdata('hr_admin');
        $data['title'] = 'HR-Center Add User';
        $data['page_title'] = 'Users';
        $data['hrPositions'] = $this->hr->getHrPositions(); 
        $data['userTypes'] = $this->hr->getHrUserTypes(); 
        $data['departments'] = $this->hr->getHrDepartments(); 
        $data['branches'] = $this->branches_model->get_many_by('status', '1');
        $config['upload_path'] = './uploads/hr/user/';
        $config['allowed_types'] = 'gif|jpg|png';   
        $config['max_size'] = 12000;
        $this->load->library('upload', $config);
        if (!is_dir('/uploads/hr/user')) {
			mkdir('./uploads/hr/user', 0777, TRUE);
		}
        $profileImgError = 0;
        $document_name = '';

        if ($this->input->post()) {
            $this->load->library('hr/common');
            $this->form_validation->set_rules('first_name', 'First Name', 'required', array('required'=> 'Please Enter First Name'));
            $this->form_validation->set_rules('last_name', 'Last Name', 'required', array('required'=> 'Please Enter Last Name'));
            $this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email|is_unique[pct_hr_users.email]', array('required'=> 'Please Enter Email', 'valid_email' => 'Please enter valid Email', 'is_unique'=>'Email already Exist'));
            $this->form_validation->set_rules('position', 'Password', 'required', array('required'=> 'Please Select Position'));
            $this->form_validation->set_rules('hire_date', 'Hire Date', 'required', array('required'=> 'Please Enter Hire Date'));
            $this->form_validation->set_rules('user_type', 'User Type', 'required', array('required'=> 'Please Check User Type'));
            $this->form_validation->set_rules('department', 'Department', 'required', array('required'=> 'Please Select Department.'));
            $this->form_validation->set_rules('branch', 'Branch', 'required', array('required'=> 'Please Select Branch.'));
            
            if ($this->form_validation->run() == true) {        
                if (!empty($_FILES['profile_img']['name'])) {
                    if (! $this->upload->do_upload('profile_img')) {
                        $data['profile_img_error_msg'] = $this->upload->display_errors();
                        $profileImgError = 1;
                    } else { 
                        $data = $this->upload->data();
                        $document_name = date('YmdHis')."_".$data['file_name'];
                        rename(FCPATH."/uploads/hr/user/".$data['file_name'], FCPATH."/uploads/hr/user/".$document_name);
                        $this->common->uploadDocumentOnAwsS3($document_name, 'hr/user');
                    } 
                }

                if ($profileImgError == 0) {
                    $randomPassword = $this->common->randomPassword();
                    $usersData = array(
                        'first_name' =>  $this->input->post('first_name'),
                        'last_name' =>  $this->input->post('last_name'),
                        'email' => $this->input->post('email'),
                        'password' => password_hash($randomPassword, PASSWORD_DEFAULT),    
                        'position_id' => $this->input->post('position'),
                        'user_type_id' => $this->input->post('user_type'),
                        'hire_date' => date("Y-m-d", strtotime($this->input->post('hire_date'))),
                        'status' => 1,
                        'is_tmp_password' => 1,
                        'department_id' => $this->input->post('department'),
                        'branch_id' => $this->input->post('branch'),
                        'profile_img' => $document_name
                    );

                    $user_id = $this->hr->insert($usersData, 'pct_hr_users');

                    $this->load->model('hr/training_model');
                    $trainingsList = $this->training_model->get_many_by("(position_id = {$this->input->post('position')} and department_id ={$this->input->post('department')})");
                    $assign_trainings = array();

                    if (!empty($trainingsList)) {
                        $this->load->model('hr/training_status_model');
                        foreach($trainingsList as $training) {
                            $assign_trainings[] = array(
                                'user_id' => $user_id,
                                'training_id' => $training->id,
                                'is_complete' => 0
                            );
    
                            $message = $trainingsList->name.' training has assigned to you  by '.$userdata['name'];
                            $notificationData = array(
                                'sent_user_id' => $user_id,
                                'message' => $message,
                                'type' =>  'assigned'
                            );
                            $this->hr->insert($notificationData, 'pct_hr_notifications');
                            $this->common->sendNotification($message, 'assigned', $user_id, 0);
                        }
    
                        if(count($assign_trainings)) {
                            $this->training_status_model->insert_many($assign_trainings);
                        }
                    }
                    
                    $successMsg = 'User added successfully.';
                    $from_name = 'Pacific Coast Title Company';
                    $from_mail = getenv('FROM_EMAIL');
                    $message_body = "Hi ".$this->input->post('first_name')." ".$this->input->post('last_name').", <br><br>";
                    $message_body .= "You have been invited to the Pacific Coast Title HR center. Please login with tempoary password and change your password.<br><br>";
                    $message_body .= "Tempoary password: ".$randomPassword. "<br><br>";
                    $message_body .= "Please click on the link below to complete your registration.<br><br> ".getenv('APP_URL')."hr/login";
                    $subject = 'Invitation For Pacific Coast Title HR Center';
                    $to = $this->input->post('email');
                    $this->load->helper('sendemail');
                    send_email($from_mail, $from_name, $to, $subject, $message_body);
                    $this->session->set_userdata('success', $successMsg);
                    redirect(base_url().'hr/admin/users'); 
                }
            } else {
                $data['first_name_error_msg'] = form_error('first_name');
                $data['last_name_error_msg'] = form_error('last_name');
                $data['email_error_msg'] = form_error('email');
                $data['position_error_msg'] = form_error('position');
                $data['hire_date_error_msg'] = form_error('hire_date');
                $data['user_type_error_msg'] = form_error('user_type');
                $data['department_error_msg'] = form_error('department');
            }                                       
        }
        $this->admintemplate->addJS( base_url('assets/backend/hr/js/custom.js') );
        $this->admintemplate->show("hr", "add_user", $data);
    }

    public function editUser()
    {
        $id = $this->uri->segment(4);
        $data['title'] = 'HR-Center Edit User';
        $data['page_title'] = 'Users';
        $data['hrPositions'] = $this->hr->getHrPositions(); 
        $data['userTypes'] = $this->hr->getHrUserTypes(); 
        $data['departments'] = $this->hr->getHrDepartments(); 
        $data['branches'] = $this->branches_model->get_many_by('status', '1');
        $config['upload_path'] = './uploads/hr/user/';
        $config['allowed_types'] = 'gif|jpg|png';   
        $config['max_size'] = 12000;
        $this->load->library('upload', $config);
        if (!is_dir('/uploads/hr/user')) {
			mkdir('./uploads/hr/user', 0777, TRUE);
		}
        $profileImgError = 0;
        $document_name = '';
       
        if(isset($id) && !empty($id)) {
            if ($this->input->post()) {
                $this->load->library('hr/common');
                $this->form_validation->set_rules('first_name', 'First Name', 'required', array('required'=> 'Please Enter First Name'));
                $this->form_validation->set_rules('last_name', 'Last Name', 'required', array('required'=> 'Please Enter Last Name'));
                $this->form_validation->set_rules('position', 'Password', 'required', array('required'=> 'Please Select Position'));
                $this->form_validation->set_rules('hire_date', 'Hire Date', 'required', array('required'=> 'Please Enter Hire Date'));
                $this->form_validation->set_rules('user_type', 'User Type', 'required', array('required'=> 'Please Check User Type'));
                $this->form_validation->set_rules('department', 'Department', 'required', array('required'=> 'Please Select Department.'));
                $this->form_validation->set_rules('branch', 'Branch', 'required', array('required'=> 'Please Select Branch.'));
                
                if ($this->form_validation->run() == true) {
                    if (!empty($_FILES['profile_img']['name'])) {
                        if (! $this->upload->do_upload('profile_img')) {
                            $data['profile_img_error_msg'] = $this->upload->display_errors();
                            $profileImgError = 1;
                        } else { 
                            $data = $this->upload->data();
                            $document_name = date('YmdHis')."_".$data['file_name'];
                            rename(FCPATH."/uploads/hr/user/".$data['file_name'], FCPATH."/uploads/hr/user/".$document_name);
                            $this->common->uploadDocumentOnAwsS3($document_name, 'hr/user');
                        } 
                    }

                    if ($profileImgError == 0) {
                        $usersData = array(
                            'first_name' =>  $this->input->post('first_name'),
                            'last_name' =>  $this->input->post('last_name'), 
                            'position_id' => $this->input->post('position'),
                            'user_type_id' => $this->input->post('user_type'),
                            'hire_date' => date("Y-m-d", strtotime($this->input->post('hire_date'))),
                            'status' => 1,
                            'department_id' => $this->input->post('department'),
                            'branch_id' => $this->input->post('branch')
                        );
                        if (!empty($document_name)) {
                            $usersData['profile_img'] = $document_name;
                        }
                        $condition = array('id' => $id);
                        $this->hr->update($usersData, $condition, 'pct_hr_users');
                        $successMsg = 'User updated successfully.';
                        $this->session->set_userdata('success', $successMsg);
                        redirect(base_url().'hr/admin/users');
                    }
                } else {
                    $data['first_name_error_msg'] = form_error('first_name');
                    $data['last_name_error_msg'] = form_error('last_name');
                    $data['position_error_msg'] = form_error('position');
                    $data['hire_date_error_msg'] = form_error('hire_date');
                    $data['user_type_error_msg'] = form_error('user_type');
                    $data['department_error_msg'] = form_error('department');
                }                                       
            }
            $data['userInfo'] = $this->hr->getUserInfo($id);
        } else {
            redirect(base_url().'hr/admin/users');
        }
        $this->admintemplate->addJS( base_url('assets/backend/hr/js/custom.js') );
        $this->admintemplate->show("hr", "edit_user", $data);
    }

    public function deleteUser()
    {
        $id = isset($_POST['id']) && !empty($_POST['id']) ? $_POST['id'] : '';
        if ($id) {
            $userData = array('status' => 0);
            $condition = array('id' => $id);
            $update = $this->hr->update($userData, $condition, 'pct_hr_users');
            if ($update) {
                $successMsg = 'User deleted successfully.';
                $response = array('status'=>'success', 'message' => $successMsg);
            }
        } else {
            $msg = 'User ID is required.';
            $response = array('status' => 'error','message'=>$msg);
        }
        echo json_encode($response);
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
