<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class AdminUsers extends MX_Controller {

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
        $this->load->library('hr/AdminTemplate');
        $this->load->model('hr/hr'); 
        $this->load->library('hr/common');
        $this->common->is_hr_admin();
    }

    public function index()
    {
        $data['title'] = 'HR-Center Admin Users';
        $data['page_title'] = 'Admin Users';
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
        $this->admintemplate->show("hr", "admin_users", $data);
    }

    public function getAdminUsers()
    {
        $params = array();
        if (isset($_POST['draw']) && !empty($_POST['draw'])) {
            $params['draw'] = isset($_POST['draw']) && !empty($_POST['draw']) ? $_POST['draw'] : 10;
            $params['length'] = isset($_POST['length']) && !empty($_POST['length']) ? $_POST['length'] : 10;
            $params['start'] = isset($_POST['start']) && !empty($_POST['start']) ? $_POST['start'] : 0;
            $params['orderColumn'] = isset($_POST['order'][0]['column']) && !empty($_POST['order'][0]['column']) ? $_POST['order'][0]['column'] : 0;
            $params['orderDir'] = isset($_POST['order'][0]['dir']) && !empty($_POST['order'][0]['dir']) ? $_POST['order'][0]['dir'] : 0;
            $params['searchvalue'] = isset($_POST['search']['value']) && !empty($_POST['search']['value']) ? $_POST['search']['value'] : '';
            $adminUsersList = $this->hr->getAdminUsers($params);
            $json_data['draw'] = intval( $params['draw'] );
        } else {
            $params['searchvalue'] = isset($_POST['keyword']) && !empty($_POST['keyword']) ? $_POST['keyword'] : '';
            $adminUsersList = $this->hr->getAdminUsers($params);            
        }

        $data = array(); 
        $count = $params['start'] + 1;
	    if (isset($adminUsersList['data']) && !empty($adminUsersList['data'])) {
	    	foreach ($adminUsersList['data'] as $key => $value)  {
	    		$nestedData=array();
                $nestedData[] = $count;
                $userName = explode(" ", $value['user_name']);
	            $nestedData[] = $userName[0];
                $nestedData[] = $userName[1];
                $nestedData[] = $value['email_id'];
                if(isset($_POST['draw']) && !empty($_POST['draw'])) {
                    $editUrl = base_url().'hr/admin/edit-admin-user/'.$value['id'];
                    
                    $nestedData[] = '<a href="'.$editUrl.'" class="btn btn-info btn-icon-split btn-sm">
                            <span class="icon text-white-50">
                                <i class="fas fa-pencil-alt"></i>
                            </span>
                            <span class="text">Edit</span>
                        </a>
                        <a href="#" onclick="deleteAdminUser('.$value["id"].')" class="btn btn-danger btn-icon-split btn-sm">
                            <span class="icon text-white-50">
                                <i class="fas fa-trash"></i>
                            </span>
                            <span class="text">Delete</span>
                        </a>';
                }
	            $data[] = $nestedData;    
                $count++;          
	    	}
	    }
        $json_data['recordsTotal'] = intval( $adminUsersList['recordsTotal'] );
        $json_data['recordsFiltered'] = intval( $adminUsersList['recordsFiltered'] );
        $json_data['data'] = $data;
	    echo json_encode($json_data);
    }

    public function addAdminUser()
    {
        $data['title'] = 'HR-Center Add Admin Users';
        $data['page_title'] = 'Admin Users';
        if ($this->input->post()) {
            $this->form_validation->set_rules('first_name', 'First Name', 'required', array('required'=> 'Please Enter First Name'));
            $this->form_validation->set_rules('last_name', 'Last Name', 'required', array('required'=> 'Please Enter Last Name'));
            $this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email|is_unique[admin.email_id]', array('required'=> 'Please Enter Email', 'valid_email' => 'Please enter valid Email', 'is_unique'=>'Email already Exist'));
            $this->form_validation->set_rules('password', 'Password', 'required', array('required'=> 'Please Enter Password'));
           
            if ($this->form_validation->run() == true) {
                $adminData = array(
                    'user_name' =>  $this->input->post('first_name')." ".$this->input->post('last_name'),
                    'password' => md5($this->input->post('password')),    
                    'email_id' => $this->input->post('email'),
                    'is_hr_admin' => 1,
                    'is_super_hr_admin' => 1,
                    'status' => 1,
                    'created_at' => date('Y-m-d H:i:s')
                );
                $this->hr->insert($adminData, 'admin');
                $successMsg = 'Admin user added successfully.';
                $this->session->set_userdata('success', $successMsg);
                redirect(base_url().'hr/admin/admin-users');
            } else {
                $data['first_name_error_msg'] = form_error('first_name');
                $data['last_name_error_msg'] = form_error('last_name');
                $data['email_error_msg'] = form_error('email');
                $data['password_error_msg'] = form_error('password');
            }                                       
        }
        $this->admintemplate->show("hr", "add_admin_user", $data);
    }

    public function editAdminUser()
    {
        $id = $this->uri->segment(4);
        $data['title'] = 'HR-Center Edit Admin Users';
        $data['page_title'] = 'Admin Users';

        if(isset($id) && !empty($id)) {
            if ($this->input->post()) {
                $this->form_validation->set_rules('first_name', 'First Name', 'required', array('required'=> 'Please Enter First Name'));
                $this->form_validation->set_rules('last_name', 'Last Name', 'required', array('required'=> 'Please Enter Last Name'));
                $this->form_validation->set_rules('password', 'Password', 'required', array('required'=> 'Please Enter Password'));
                if ($this->form_validation->run() == true) {
                    $adminData = array(
                        'user_name' =>  $this->input->post('first_name')." ".$this->input->post('last_name'),
                        'password' => md5($this->input->post('password'))
                    );
                    $condition = array('id' => $id);
                    $this->hr->update($adminData, $condition, 'admin');
                    $successMsg = 'Admin user updated successfully.';
                    $this->session->set_userdata('success', $successMsg);
                    redirect(base_url().'hr/admin/admin-users');
                } else {
                    $data['first_name_error_msg'] = form_error('first_name');
                    $data['last_name_error_msg'] = form_error('last_name');
                    $data['password_error_msg'] = form_error('password');
                }                                       
            }
            $data['adminUserInfo'] = $this->hr->getAdminUserInfo($id);
        } else {
            redirect(base_url().'hr/admin/admin-users');
        }
        $this->admintemplate->show("hr", "edit_admin_user", $data);
    }

    public function deleteAdminUser()
    {
        $id = isset($_POST['id']) && !empty($_POST['id']) ? $_POST['id'] : '';
        if ($id) {
            $adminData = array('status' => 0);
            $condition = array('id' => $id);
            $update = $this->hr->update($adminData, $condition, 'admin');
            if ($update) {
                $successMsg = 'Admin User deleted successfully.';
                $response = array('status'=>'success', 'message' => $successMsg);
            }
        } else {
            $msg = 'Admin User ID is required.';
            $response = array('status' => 'error','message'=>$msg);
        }
        echo json_encode($response);
    }
}
