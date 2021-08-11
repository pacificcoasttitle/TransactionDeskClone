<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends MX_Controller {

	public function __construct()
    {
        parent::__construct();
        $this->load->helper(
            array('file', 'url','form')
        );
        $this->load->library('form_validation');
        $this->load->model('hr/hr'); 
    }

    public function login()
	{
        $data = array();
        $userdata = $this->session->userdata('hr_admin');
        if (!empty($userdata['id']) && $userdata['is_hr_admin'] == 1) {
            redirect(base_url().'hr/admin/dashboard');
        } else {
            $data['msg'] = $this->session->userdata('msg');
            $this->session->unset_userdata('msg');
            $this->load->view('hr/login', $data);
        }		
	}

    public function do_login()
    {
    	if($this->input->post()) {
    		$email_address = $this->input->post('email_address');
        	$password      = $this->input->post('password');
            $admin = $this->hr->get_hr_admin_user($email_address, $password);
        	if ($admin) {
        		$session_data = array(
                    "id" => isset($admin['id']) && !empty($admin['id']) ? $admin['id'] : '',
                    "name" => isset($admin['user_name']) && !empty($admin['user_name']) ? $admin['user_name'] : '',
                    "email_address" => isset($admin['email_id']) && !empty($admin['email_id']) ? $admin['email_id'] : '',
                    "is_super_hr_admin" => $admin['is_super_hr_admin'],
                    "is_hr_admin" => 1
                );
                $this->session->set_userdata('hr_admin', $session_data);
                if ($this->input->is_ajax_request())  {
                    $result = array('status'=>'success');
                    echo json_encode($result); exit;
                } else {
                    redirect(base_url().'hr/admin/dashboard');
                }
        	} else  {
                if ($this->input->is_ajax_request())  {
                    $result = array('status'=>'error','msg'=>'Incorrect email or password');
                    echo json_encode($result); exit;
                } else {
                    $this->session->set_userdata('msg', 'Incorrect email or password');
                    redirect(base_url().'hr/admin');
                }
            }
    	}
    }
}