<?php

(defined('BASEPATH')) OR exit('No direct script access allowed');

class TaskList extends MX_Controller 
{
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
		$this->load->model('hr/task_list_category');
		$this->load->model('hr/task_list_model');
        $this->common->is_hr_admin();
	}
	
	function category()
	{
		$data['title'] = 'HR-Center Task Category';
        $data['page_title'] = 'Task Category';
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
        $this->admintemplate->show("hr", "task_category", $data);
	}
	
	public function  getCategory()
    {
        $params = array();  $data = array();
		
		$task_list_category = $this->task_list_category->get_all();
		$i = 1;
		foreach($task_list_category as $record){
			$tmp_array = array();
			$status = '<span class="badge badge-info">In-active</span>';
			if($record->status == 1) {
				$status = '<span class="badge badge-success">Active</span>';
			}
			$tmp_array[] = $i;
			$tmp_array[] = $record->name;
			$tmp_array[] = strlen($record->description) > 50 ? substr($record->description,0,50)."..." : $record->description;
			$tmp_array[] = $status;
			// $tmp_array[] = $record->created_at;
			$editUrl = base_url().'hr/admin/edit-task-category/'.$record->id;
			$deleteUrl = base_url().'hr/admin/delete-task-category/'.$record->id;
			$tmp_array[] = '<div style="display:inline-flex;">
				<a href="'.$editUrl.'" class="btn btn-info btn-icon-split btn-sm">
					<span class="icon text-white-50">
						<i class="fas fa-pencil-alt"></i>
					</span>
					<span class="text">Edit</span>
				</a>
				<a style="margin-left: 5px;" href="'.$deleteUrl.'" onclick="return confirm(\'Are you sure you want to delete this record?\');" class="btn btn-danger btn-icon-split btn-sm">
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

	public function  addCategory()
    {
		$data['title'] = 'HR-Center Task Category';
        $data['page_title'] = 'Add Category';
		if ($this->input->post()) {
            $this->load->library('hr/common');
            $this->form_validation->set_rules('category_name', 'Category Name', 'required');
        
            if ($this->form_validation->run() == true) {
                $categoryData = array(
                    'name' =>  $this->input->post('category_name'),
                    'description' =>  $this->input->post('category_description'),
                    'status' =>  $this->input->post('check_status') ? 1 : 0,
                );
                $this->task_list_category->insert($categoryData);
                $successMsg = 'Category added successfully.';
                $this->session->set_userdata('success', $successMsg);
                redirect(base_url().'hr/admin/task-category');
            } else {
                $data['category_name_error_msg'] = form_error('category_name');
            }                                       
        }
		$this->admintemplate->addJS( base_url('assets/backend/hr/js/custom.js') );
        $this->admintemplate->show("hr", "add_task_category", $data);
	}

	public function  editCategory($id)
    {
		$record = $this->task_list_category->get($id);
		if($record) {
			$data['title'] = 'HR-Center Task Category';
			$data['page_title'] = 'Edit Category';
			$data['record'] = $record;
			if ($this->input->post()) {
				$this->load->library('hr/common');
				$this->form_validation->set_rules('category_name', 'Category Name', 'required');
			
				if ($this->form_validation->run() == true) {
					$categoryData = array(
						'name' =>  $this->input->post('category_name'),
						'description' =>  $this->input->post('category_description'),
						'status' =>  $this->input->post('check_status') ? 1 : 0,
					);
					$this->task_list_category->update($id,$categoryData);
					$successMsg = 'Category updated successfully.';
					$this->session->set_userdata('success', $successMsg);
					redirect(base_url().'hr/admin/task-category');
				} else {
					$data['category_name_error_msg'] = form_error('category_name');
				}                                       
			}
			$this->admintemplate->addJS( base_url('assets/backend/hr/js/custom.js') );
			$this->admintemplate->show("hr", "edit_task_category", $data);
		}
		else {
			$this->session->set_userdata('errors', 'Invalid Request');
			redirect(base_url().'hr/admin/task-category');
		}
	}

	public function deleteCategory($id)
    {
		$record = $this->task_list_category->with('tasks')->get($id);
        if ($record) {
			$tasks = ($record->tasks);
			if($tasks) {
				$this->session->set_userdata('errors', 'You can not delete this category because there is task/tasks associate with this. You can In-active this instead.');
			}
			else {
				$this->task_list_category->delete($id);
				$this->session->set_userdata('success', 'Category deleted');
			}
        } else {
            $this->session->set_userdata('errors', 'Invalid Request');
        }
		redirect(base_url().'hr/admin/task-category');
    }

	/** Task List start */
	public function index()
	{
		$data['title'] = 'HR-Center Task List';
        $data['page_title'] = 'Task List';
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
        $this->admintemplate->show("hr", "task_list", $data);
	}
	
	public function  getTask()
    {
        $params = array();  $data = array();
		
		$task_list = $this->task_list_model->with('category')->get_all();
		// var_dump($task_list);die;
		$i = 1;
		foreach($task_list as $record){
			$tmp_array = array();
			$status = '<span class="badge badge-info">In-active</span>';
			if($record->status == 1) {
				$status = '<span class="badge badge-success">Active</span>';
			}
			$tmp_array[] = $i;
			$tmp_array[] = $record->name;
			$tmp_array[] = $record->category->name;
			$tmp_array[] = strlen($record->description) > 50 ? substr($record->description,0,50)."..." : $record->description;
			$tmp_array[] = $status;
			// $tmp_array[] = $record->created_at;
			$editUrl = base_url().'hr/admin/edit-task-list/'.$record->id;
			$deleteUrl = base_url().'hr/admin/delete-task-list/'.$record->id;
			$tmp_array[] = '<div style="display:inline-flex;">
				<a href="'.$editUrl.'" class="btn btn-info btn-icon-split btn-sm">
					<span class="icon text-white-50">
						<i class="fas fa-pencil-alt"></i>
					</span>
					<span class="text">Edit</span>
				</a>
				<a style="margin-left: 5px;" href="'.$deleteUrl.'" onclick="return confirm(\'Are you sure you want to delete this record?\');" class="btn btn-danger btn-icon-split btn-sm">
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

	public function  addTask()
    {
		$data['title'] = 'HR-Center Task Category';
        $data['page_title'] = 'Add Category';
		$task_list_category = $this->task_list_category->get_many_by('status', '1');
        $data['task_list_category'] = $task_list_category;

		if ($this->input->post()) {
            $this->load->library('hr/common');
            $this->form_validation->set_rules('task_name', 'Task Name', 'required');
            $this->form_validation->set_rules('task_category', 'Task Category', 'required');
        
            if ($this->form_validation->run() == true) {
                $taskData = array(
                    'category_id' =>  $this->input->post('task_category'),
                    'name' =>  $this->input->post('task_name'),
                    'description' =>  $this->input->post('task_description'),
                    'status' =>  $this->input->post('check_status') ? 1 : 0,
                );
                $this->task_list_model->insert($taskData);
                $successMsg = 'Task added successfully.';
                $this->session->set_userdata('success', $successMsg);
                redirect(base_url().'hr/admin/task-list');
            } else {
                $data['task_name_error_msg'] = form_error('task_name');
                $data['task_category_error_msg'] = form_error('task_category');
            }                                       
        }
		$this->admintemplate->addJS( base_url('assets/backend/hr/js/custom.js') );
        $this->admintemplate->show("hr", "add_task_list", $data);
	}

	public function  editTask($id)
    {
		$record = $this->task_list_model->get($id);
		// $task_list_category = $this->task_list_category->get_many_by(['status'=> '1']);
		$task_list_category = $this->task_list_category->get_many_by("(status='1' OR id={$record->category_id})");
        $data['task_list_category'] = $task_list_category;
		if($record) {
			$data['title'] = 'HR-Center Task Category';
			$data['page_title'] = 'Edit Category';
			$data['record'] = $record;
			if ($this->input->post()) {
				$this->load->library('hr/common');
				$this->form_validation->set_rules('task_name', 'Task Name', 'required');
				$this->form_validation->set_rules('task_category', 'Task Category', 'required');
			
				if ($this->form_validation->run() == true) {
					$taskData = array(
						'category_id' =>  $this->input->post('task_category'),
						'name' =>  $this->input->post('task_name'),
						'description' =>  $this->input->post('task_description'),
						'status' =>  $this->input->post('check_status') ? 1 : 0,
					);
					$this->task_list_model->update($id,$taskData);
					$successMsg = 'Task updated successfully.';
					$this->session->set_userdata('success', $successMsg);
					redirect(base_url().'hr/admin/task-list');
				} else {
					$data['task_name_error_msg'] = form_error('task_name');
					$data['task_category_error_msg'] = form_error('task_category');
				}                                       
			}
			$this->admintemplate->addJS( base_url('assets/backend/hr/js/custom.js') );
			$this->admintemplate->show("hr", "edit_task_list", $data);
		}
		else {
			$this->session->set_userdata('errors', 'Invalid Request');
			redirect(base_url().'hr/admin/task-list');
		}
	}

	public function deleteTask($id)
    {
		$record = $this->task_list_model->with('tasks')->get($id);
        if ($record) {
			
			$this->task_list_model->delete($id);
			$this->session->set_userdata('success', 'Task deleted');
			
        } else {
            $this->session->set_userdata('errors', 'Invalid Request');
        }
		redirect(base_url().'hr/admin/task-list');
    }

}
