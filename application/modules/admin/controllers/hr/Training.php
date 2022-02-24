<?php

(defined('BASEPATH')) OR exit('No direct script access allowed');

class Training extends MX_Controller 
{
	private $custom_js_version = '01';
	function __construct() 
    {
        parent::__construct();
		$this->load->helper(
            array('file', 'url','form')
        );
        $this->load->library('session');
		$this->load->library('form_validation');
		$this->load->library('hr/adminTemplate');
        $this->load->library('hr/common');
		$this->load->model('hr/hr');
		$this->load->model('hr/training_model');
        $this->common->is_hr_admin();
	}
	
	function index()
	{
		$data['title'] = 'HR-Center Training';
        $data['page_title'] = 'Employee Training';
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
        $this->admintemplate->addJS( base_url('assets/backend/hr/js/custom.js?v=training_'.$this->custom_js_version) );
        $this->admintemplate->show("hr", "training", $data);
	}
	
	function getTraining()
    {
        $data = array();
		
		$training_list = $this->training_model->with('department')->with('position')->with('materials')->get_all();
		$i = 1;
		foreach($training_list as $record){
			$tmp_array = array();
			$status = '<span class="badge badge-info">In-active</span>';
			if($record->status == 1) {
				$status = '<span class="badge badge-success">Active</span>';
			}
			$material_url = '<span class="badge badge-danger">No Materials</span>';//count($record->materials)
			if(count($record->materials)) {
				$material_url = '<span class="badge badge-success">'.count($record->materials).' Materials</span>';
			}
			$tmp_array[] = $i;
			$tmp_array[] = $record->name;
			$tmp_array[] = strlen($record->description) > 50 ? substr($record->description,0,50)."..." : $record->description;
			$tmp_array[] = $material_url;
			$tmp_array[] = $record->department->name;
			$tmp_array[] = $record->position->name;
			$tmp_array[] = $status;
			// $tmp_array[] = $record->created_at;
			$editUrl = base_url().'hr/admin/edit-training/'.$record->id;
			$deleteUrl = base_url().'hr/admin/delete-training/';
			$tmp_array[] = '<div style="display:inline-flex;">
				<a href="'.$editUrl.'" class="btn btn-info btn-icon-split btn-sm">
					<span class="icon text-white-50">
						<i class="fas fa-pencil-alt"></i>
					</span>
					<span class="text">Edit</span>
				</a>
				<a style="margin-left: 5px;" data-id="'.$record->id.'" data-href="'.$deleteUrl.'" data-toggle="modal" data-target="#pct__delete_modal" class="btn btn-danger btn-icon-split btn-sm pct__btn_delete">
					<span class="icon text-white-50">
						<i class="fas fa-trash"></i>
					</span>
					<span class="text">Delete</span>
				</a>
			</div>';
			$data[]=$tmp_array;
			$i++;
		}
		
		$json_data['recordsTotal'] = intval(count($data));
		$json_data['recordsFiltered'] = intval(count($data));
		$json_data['data'] = $data;
		echo json_encode($json_data);
    }

	function addTraining()
    {
		$data['title'] = 'HR-Center Training';
        $data['page_title'] = 'Add Training';
		$config['upload_path'] = './uploads/hr/training/';  
        $config['max_size'] = 18000;
		$config['allowed_types'] = 'pdf';
        $this->load->library('upload', $config);
        if (!is_dir('/uploads/hr/training')) {
			mkdir('./uploads/hr/training', 0777, TRUE);
		}
        $filesName = array();
		$data['material_files_error'] = array();
		$data['users'] = $this->common->getAllUsers();
		
		if ($this->input->post()) {
            $this->load->library('hr/common');
            $this->form_validation->set_rules('traning_name', 'Name', 'required');
			$this->form_validation->set_rules('user_selection', 'User Selection', 'required', array('required'=> 'Please Check User Selection Option'));

			if ($this->input->post('user_selection') == 'based_on_position_and_department') {
				$this->form_validation->set_rules('traning_department', 'Department', 'required');
            	$this->form_validation->set_rules('traning_position', 'Position', 'required');
			} else if ($this->input->post('user_selection') == 'based_on_user_listing') {
				$this->form_validation->set_rules('users[]', 'Users', 'required', array('required'=> 'Please Select atleast one user'));
			}	
            
            if ($this->form_validation->run() == true) {
				if (!empty(($_FILES['material_file']))) {
					$fileName = '';
					foreach ($_FILES['material_file']['name'] as $key => $image) {
						$_FILES['material_file[]']['name']= $_FILES['material_file']['name'][$key];
						$_FILES['material_file[]']['type']= $_FILES['material_file']['type'][$key];
						$_FILES['material_file[]']['tmp_name']= $_FILES['material_file']['tmp_name'][$key];
						$_FILES['material_file[]']['error']= $_FILES['material_file']['error'][$key];
						$_FILES['material_file[]']['size']= $_FILES['material_file']['size'][$key];
						$this->upload->initialize($config);
			
						if ($this->upload->do_upload('material_file[]')) {
							$data = $this->upload->data();
							$fileName = date('YmdHis')."_".$data['file_name'];
							$filesName[] = date('YmdHis')."_".$data['file_name'];
							rename(FCPATH."/uploads/hr/training/".$data['file_name'], FCPATH."/uploads/hr/training/".$fileName);
							$this->common->uploadDocumentOnAwsS3($fileName, 'hr/training');
						} else {
							$data['material_files_error'][] = $this->upload->display_errors();
						}
					}
				}
				
				if (empty($data['material_files_error'])) {
					$trainingData = array(
						'name' =>  $this->input->post('traning_name'),
						'description' =>  $this->input->post('traning_description'),
						'department_id' =>  $this->input->post('traning_department') ? $this->input->post('traning_department') : 0,
						'position_id' =>  $this->input->post('traning_position') ? $this->input->post('traning_position') : 0,
						'user_selection' =>  $this->input->post('user_selection'),
						'status' =>  $this->input->post('check_status') ? 1 : 0,
					);
					$training_id = $this->training_model->insert($trainingData);
					if($training_id) {
						$this->load->model('hr/training_material_model');
						$this->load->model('hr/training_status_model');
						if ($this->input->post('material_url') && count($this->input->post('material_url'))) {
							$material_insert = array();
							foreach($this->input->post('material_url') as $material_url) {
								$material_insert[] = array(
									'path' => $material_url,
									'type' => 'url',
									'training_id' => $training_id
								);
							}
							if(count($material_insert)) {
								$this->training_material_model->insert_many($material_insert);
							}
						}

						if (!empty($filesName)) {
							$material_insert = array();
							foreach($filesName as $fileName) {
								$material_insert[] = array(
									'path' => $fileName,
									'type' => 'file',
									'training_id' => $training_id
								);
							}
							if(count($material_insert)) {
								$this->training_material_model->insert_many($material_insert);
							}
						}

						if ($this->input->post('user_selection') == 'based_on_position_and_department') {
							$this->load->model('hr/users_model');
							$usersList = $this->users_model->get_many_by("(position_id = {$this->input->post('traning_position')} and department_id ={$this->input->post('traning_department')})");
							$training_status = array();

							foreach($usersList as $user) {
								$training_status[] = array(
									'user_id' => $user->id,
									'training_id' => $training_id,
									'is_complete' => 0
								);

								$message = $this->input->post('traning_name').' training has assigned to you.';
								$notificationData = array(
									'sent_user_id' => $user->id,
									'message' => $message,
									'is_admin' => 0,
									'type' =>  'assigned'
								);
								$this->hr->insert($notificationData, 'pct_hr_notifications');
								$this->common->sendNotification($message, 'assigned', $user->id, 0);
							}
							if(count($training_status)) {
								$this->training_status_model->insert_many($training_status);
							}
						} else if ($this->input->post('user_selection') == 'based_on_user_listing') {
							$training_status = array();
							$usersList = $this->input->post('users');
							foreach($usersList as $user) {
								$training_status[] = array(
									'user_id' => $user,
									'training_id' => $training_id,
									'is_complete' => 0
								);

								$message = $this->input->post('traning_name').' training has assigned to you.';
								$notificationData = array(
									'sent_user_id' => $user,
									'message' => $message,
									'is_admin' => 0,
									'type' =>  'assigned'
								);
								$this->hr->insert($notificationData, 'pct_hr_notifications');
								$this->common->sendNotification($message, 'assigned', $user, 0);
							}

							if(count($training_status)) {
								$this->training_status_model->insert_many($training_status);
							}
						}	
					}
					$successMsg = 'Training detail added successfully.';
					$this->session->set_userdata('success', $successMsg);
					redirect(base_url().'hr/admin/training');
				}
            } else {
                $data['traning_name_error_msg'] = form_error('traning_name');
                $data['traning_department_error_msg'] = form_error('traning_department');
                $data['traning_position_error_msg'] = form_error('traning_position');
            }                                       
        }
		$this->load->model('hr/users_department');
		$this->load->model('hr/users_position');

		$data['departments'] = $this->users_department->get_many_by('status',1);
		$data['positions'] = $this->users_position->get_many_by('status',1);

		$this->admintemplate->addCSS( base_url('assets/css/bootstrap-select.css') );
        $this->admintemplate->addJS( base_url('assets/js/bootstrap-select.min.js') );
		$this->admintemplate->addJS( base_url('assets/backend/hr/js/custom.js?v=training_'.$this->custom_js_version) );
        $this->admintemplate->show("hr", "add_training", $data);
	}

	public function  editTraining($id)
    {
		$data = array();
		$config['upload_path'] = './uploads/hr/training/';  
        $config['max_size'] = 18000;
		$config['allowed_types'] = '*';
        $this->load->library('upload', $config);
        if (!is_dir('/uploads/hr/training')) {
			mkdir('./uploads/hr/training', 0777, TRUE);
		}
        $filesName = array();
		$editFilesName = array();
		$data['material_files_error'] = array();
		$data['material_exist_files_error'] = array();
		$data['users'] = $this->common->getAllUsers();
		$data['trainingUsers'] = array();
		
		$record = $this->training_model->with('materials')->with('users')->get($id);
		if($record) {
			if ($record->user_selection == 'based_on_user_listing') {
				foreach ($record->users as $user) {
					$data['trainingUsers'][] = $user->user_id;
				}
			} 
			$data['title'] = 'HR-Center Training';
			$data['page_title'] = 'Edit Training';
			$data['record'] = $record;
			if ($this->input->post()) {
				$this->form_validation->set_rules('traning_name', 'Name', 'required');
				$this->form_validation->set_rules('user_selection', 'User Selection', 'required', array('required'=> 'Please Check User Selection Option'));

				if ($this->input->post('user_selection') == 'based_on_position_and_department') {
					$this->form_validation->set_rules('traning_department', 'Department', 'required');
					$this->form_validation->set_rules('traning_position', 'Position', 'required');
				} else if ($this->input->post('user_selection') == 'based_on_user_listing') {
					$this->form_validation->set_rules('users[]', 'Users', 'required', array('required'=> 'Please Select atleast one user'));
				}	

				if ($this->form_validation->run() == true) {
					if (!empty(($_FILES['material_file']))) {
						$fileName = '';
						foreach ($_FILES['material_file']['name'] as $key => $image) {
							$_FILES['material_file[]']['name']= $_FILES['material_file']['name'][$key];
							$_FILES['material_file[]']['type']= $_FILES['material_file']['type'][$key];
							$_FILES['material_file[]']['tmp_name']= $_FILES['material_file']['tmp_name'][$key];
							$_FILES['material_file[]']['error']= $_FILES['material_file']['error'][$key];
							$_FILES['material_file[]']['size']= $_FILES['material_file']['size'][$key];
							$this->upload->initialize($config);
				
							if ($this->upload->do_upload('material_file[]')) {
								$data = $this->upload->data();
								$fileName = date('YmdHis')."_".$data['file_name'];
								$filesName[] = date('YmdHis')."_".$data['file_name'];
								rename(FCPATH."/uploads/hr/training/".$data['file_name'], FCPATH."/uploads/hr/training/".$fileName);
								$this->common->uploadDocumentOnAwsS3($fileName, 'hr/training');
							} else {
								$data['material_files_error'][] = $this->upload->display_errors();
							}
						}
					}

					if (!empty(($_FILES['material_exist_file']))) {
						$fileName = '';
						foreach ($_FILES['material_exist_file']['name'] as $key => $image) {
							if (!empty($_FILES['material_exist_file']['name'][$key])) {
								$_FILES['material_exist_file[]']['name']= $_FILES['material_exist_file']['name'][$key];
								$_FILES['material_exist_file[]']['type']= $_FILES['material_exist_file']['type'][$key];
								$_FILES['material_exist_file[]']['tmp_name']= $_FILES['material_exist_file']['tmp_name'][$key];
								$_FILES['material_exist_file[]']['error']= $_FILES['material_exist_file']['error'][$key];
								$_FILES['material_exist_file[]']['size']= $_FILES['material_exist_file']['size'][$key];
								$this->upload->initialize($config);
					
								if ($this->upload->do_upload('material_exist_file[]')) {
									$data = $this->upload->data();
									$fileName = date('YmdHis')."_".$data['file_name'];
									$editFilesName[$key] = date('YmdHis')."_".$data['file_name'];
									rename(FCPATH."/uploads/hr/training/".$data['file_name'], FCPATH."/uploads/hr/training/".$fileName);
									$this->common->uploadDocumentOnAwsS3($fileName, 'hr/training');
								} else {
									$data['material_exist_files_error'][] = $this->upload->display_errors();
								}
							}
						}
					}

					$trainingData = array(
						'name' =>  $this->input->post('traning_name'),
						'description' =>  $this->input->post('traning_description'),
						'department_id' =>  $this->input->post('traning_department') ? $this->input->post('traning_department') : 0,
						'position_id' =>  $this->input->post('traning_position') ? $this->input->post('traning_position') : 0,
						'user_selection' =>  $this->input->post('user_selection'),
						'status' =>  $this->input->post('check_status') ? 1 : 0,
					);
					$this->training_model->update($id,$trainingData);
					$this->load->model('hr/training_material_model');
					$this->load->model('hr/training_status_model');

					if($this->input->post('material_exist_url') && count($this->input->post('material_exist_url'))) {
						foreach($this->input->post('material_exist_url') as $key=>$material_url) {
							$material_update = array(
								'path' => $material_url,
								'type' => 'url',
							);
							$this->training_material_model->update($key,$material_update);
						}
					}

					if($this->input->post('material_url') && count($this->input->post('material_url'))) {
						$material_insert = array();
						foreach($this->input->post('material_url') as $material_url) {
							$material_insert[] = array(
								'path' => $material_url,
								'type' => 'url',
								'training_id' => $id
							);
						}
						if(count($material_insert)) {
							$this->training_material_model->insert_many($material_insert);
						}
					}

					if (!empty($filesName)) {
						$material_insert = array();
						foreach($filesName as $fileName) {
							$material_insert[] = array(
								'path' => $fileName,
								'type' => 'file',
								'training_id' => $id
							);
						}
						if(count($material_insert)) {
							$this->training_material_model->insert_many($material_insert);
						}
					}

					if (!empty($editFilesName)) {
						foreach ($editFilesName as $key=>$editFileName) {
							$material_update = array(
								'path' => $editFileName,
								'type' => 'file',
							);
							$this->training_material_model->update($key, $material_update);
						}
					}

					if ($this->input->post('user_selection') == 'based_on_position_and_department') {
						$this->training_status_model->delete_by('training_id', $id);
						$this->load->model('hr/users_model');
						
						$usersList = $this->users_model->get_many_by("(position_id = {$this->input->post('traning_position')} and department_id ={$this->input->post('traning_department')})");
						echo "hhee";exit;
						$training_status = array();

						foreach($usersList as $user) {
							$training_status[] = array(
								'user_id' => $user->id,
								'training_id' => $id,
								'is_complete' => 0
							);
						}

						if(count($training_status)) {
							$this->training_status_model->insert_many($training_status);
						}
					} else if ($this->input->post('user_selection') == 'based_on_user_listing') {
						$this->training_status_model->delete_by('training_id', $id);
						$training_status = array();
						$usersList = $this->input->post('users');
						foreach($usersList as $user) {
							$training_status[] = array(
								'user_id' => $user,
								'training_id' => $id,
								'is_complete' => 0
							);
						}

						if(count($training_status)) {
							$this->training_status_model->insert_many($training_status);
						}
					}	

					$successMsg = 'Training detail updated successfully.';
					$this->session->set_userdata('success', $successMsg);
					redirect(base_url().'hr/admin/training');
				} else {
					$data['traning_name_error_msg'] = form_error('traning_name');
					$data['traning_department_error_msg'] = form_error('traning_department');
					$data['traning_position_error_msg'] = form_error('traning_position');
				}                                       
			}
			$this->load->model('hr/users_department');
			$this->load->model('hr/users_position');
			$data['departments'] = $this->users_department->get_many_by('status',1);
			$data['positions'] = $this->users_position->get_many_by('status',1);
			$data['success'] = '';
			if ($this->session->userdata('errors')) {
				$data['errors'] = $this->session->userdata('errors');
				$this->session->unset_userdata('errors');
			}
			if ($this->session->userdata('success')) {
				$data['success'] = $this->session->userdata('success');
				$this->session->unset_userdata('success');
			}
			$this->admintemplate->addCSS( base_url('assets/css/bootstrap-select.css') );
        	$this->admintemplate->addJS( base_url('assets/js/bootstrap-select.min.js') );
			$this->admintemplate->addJS( base_url('assets/backend/hr/js/custom.js?v=training_'.$this->custom_js_version) );
			$this->admintemplate->show("hr", "edit_training", $data);
		}
		else {
			$this->session->set_userdata('errors', 'Invalid Request');
			redirect(base_url().'hr/admin/training');
		}
	}


	public function deleteTraining()
    {
		$id = $this->input->post('id');
		$action = $this->input->post('action');
		$record = $this->training_model->with('materials')->get($id);
        if ($record && $action == 'delete') {
			$materials = ($record->materials);
			if($materials) {
				$this->load->model('hr/training_material_model');
				$this->load->model('hr/training_status_model');
				$this->training_material_model->delete_by('training_id',$id);
				$this->training_status_model->delete_by('training_id',$id);
			}
			$this->training_model->delete($id);
			$this->session->set_userdata('success', 'Training source deleted');
			
        } else {
            $this->session->set_userdata('errors', 'Invalid Request');
        }
		redirect(base_url().'hr/admin/training');
    }

	public function deleteTrainingMaterial($training_id)
    {
		$id = $this->input->post('id');
		$action = $this->input->post('action');
		$this->load->model('hr/training_material_model');
		$record = $this->training_material_model->get($id);
        if ($record && $action == 'delete') {
			$this->training_material_model->delete($id);
			$this->session->set_userdata('success', 'Training material deleted');
        } else {
            $this->session->set_userdata('errors', 'Invalid Request');
        }
		redirect(base_url().'hr/admin/edit-training/'.$training_id);
    }

	public function trainingStatus()
    {
        $data['title'] = 'HR-Center Training';
        $data['page_title'] = "Training Status";
        $this->admintemplate->addCSS( base_url('assets/backend/hr/vendor/datatables/dataTables.bootstrap4.min.css'));
        $this->admintemplate->addJS( base_url('assets/backend/hr/vendor/datatables/jquery.dataTables.min.js'));
        $this->admintemplate->addJS( base_url('assets/backend/hr/vendor/datatables/dataTables.bootstrap4.min.js'));
        $this->admintemplate->addJS( base_url('assets/backend/hr/js/custom.js?v=training_'.$this->custom_js_version) );
        $this->admintemplate->show("hr", "training_status", $data);
    }

	public function getTrainingStatus()
    {
        $params = array();
        if (isset($_POST['draw']) && !empty($_POST['draw'])) {
            $params['draw'] = isset($_POST['draw']) && !empty($_POST['draw']) ? $_POST['draw'] : 10;
            $params['length'] = isset($_POST['length']) && !empty($_POST['length']) ? $_POST['length'] : 10;
            $params['start'] = isset($_POST['start']) && !empty($_POST['start']) ? $_POST['start'] : 0;
            $params['orderColumn'] = isset($_POST['order'][0]['column']) && !empty($_POST['order'][0]['column']) ? $_POST['order'][0]['column'] : 0;
            $params['orderDir'] = isset($_POST['order'][0]['dir']) && !empty($_POST['order'][0]['dir']) ? $_POST['order'][0]['dir'] : 0;
            $params['searchvalue'] = isset($_POST['search']['value']) && !empty($_POST['search']['value']) ? $_POST['search']['value'] : '';
            $training_status = $this->hr->getTrainingStatus($params);
            $json_data['draw'] = intval( $params['draw'] );
        } else {
            $params['searchvalue'] = isset($_POST['keyword']) && !empty($_POST['keyword']) ? $_POST['keyword'] : '';
            $training_status = $this->hr->getTrainingStatus($params);            
        }

        $data = array(); 
        $count = $params['start'] + 1;
	    if (isset($training_status['data']) && !empty($training_status['data'])) {
	    	foreach ($training_status['data'] as $key => $value)  {
	    		$nestedData=array();
                $nestedData[] = $count;
	            $nestedData[] = $value['name'];
				$nestedData[] = $value['first_name']." ".$value['last_name']; 
                $nestedData[] = date("m/d/Y", strtotime($value['created_at'])); 
                $status = '<span class="badge badge-info">Pending</span>';
                if ($value['is_complete'] == 1) {
                    $status = '<span class="badge badge-success">Complted</span>';
                }
                $nestedData[] = $status;
	            $data[] = $nestedData;    
                $count++;          
	    	}
	    }
        $json_data['recordsTotal'] = intval( $training_status['recordsTotal'] );
        $json_data['recordsFiltered'] = intval( $training_status['recordsFiltered'] );
        $json_data['data'] = $data;
	    echo json_encode($json_data);
    }

}
