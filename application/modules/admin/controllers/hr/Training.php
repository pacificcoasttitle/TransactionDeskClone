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
		
		if ($this->input->post()) {
			
            $this->load->library('hr/common');
            $this->form_validation->set_rules('traning_name', 'Name', 'required');
            $this->form_validation->set_rules('traning_department', 'Department', 'required');
            $this->form_validation->set_rules('traning_position', 'Position', 'required');
        
            if ($this->form_validation->run() == true) {
                $trainingData = array(
                    'name' =>  $this->input->post('traning_name'),
                    'description' =>  $this->input->post('traning_description'),
                    'department_id' =>  $this->input->post('traning_department'),
                    'position_id' =>  $this->input->post('traning_position'),
                    'status' =>  $this->input->post('check_status') ? 1 : 0,
                );
                $training_id = $this->training_model->insert($trainingData);
				if($training_id) {
					$this->load->model('hr/training_material_model');
					if($this->input->post('material_url') && count($this->input->post('material_url'))) {
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
				}
                $successMsg = 'Training detail added successfully.';
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
		

		$this->admintemplate->addJS( base_url('assets/backend/hr/js/custom.js?v=training_'.$this->custom_js_version) );
        $this->admintemplate->show("hr", "add_training", $data);
	}

	public function  editTraining($id)
    {
		$data = array();
		$record = $this->training_model->with('materials')->get($id);
		if($record) {
			$data['title'] = 'HR-Center Training';
			$data['page_title'] = 'Edit Training';
			$data['record'] = $record;
			if ($this->input->post()) {
				$this->form_validation->set_rules('traning_name', 'Name', 'required');
				$this->form_validation->set_rules('traning_department', 'Department', 'required');
				$this->form_validation->set_rules('traning_position', 'Position', 'required');
			
				if ($this->form_validation->run() == true) {
					$trainingData = array(
						'name' =>  $this->input->post('traning_name'),
						'description' =>  $this->input->post('traning_description'),
						'department_id' =>  $this->input->post('traning_department'),
						'position_id' =>  $this->input->post('traning_position'),
						'status' =>  $this->input->post('check_status') ? 1 : 0,
					);
					$this->training_model->update($id,$trainingData);
					$this->load->model('hr/training_material_model');
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
				$this->training_material_model->delete_by('training_id',$id);
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

}
