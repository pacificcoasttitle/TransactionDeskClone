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
        $this->load->library('escrow/common');
    }

    public function login()
	{
        $data = array();
        $userdata = $this->session->userdata('escrow_admin');
        if (!empty($userdata['id']) && $userdata['is_escrow_admin'] == 1) {
            redirect(base_url().'escrow/admin/dashboard');
        } else {
            $data['msg'] = $this->session->userdata('msg');
            $this->session->unset_userdata('msg');
            $this->load->view('escrow/login', $data);
        }		
	}

    public function do_login()
    {
    	if($this->input->post()) {
    		$email_address = $this->input->post('email_address');
        	$password      = $this->input->post('password');
            $admin =  $this->common->get_escrow_user(array('email' => $email_address, 'status' => 1));
            if (!empty($admin)) {
                if($admin['is_tmp_password'] == 1) {
                    if (password_verify($password, $admin['password'])) {
                        $randomString = $this->common->randomPassword();
                        $hash = md5($admin['id'] . $admin['email'] .$randomString);
                        $this->hr->update(array('hash' => $hash), array('id' => $admin['id']), 'pct_hr_users');
                        redirect(base_url().'escrow/change-password/'.$hash);
                    } else {
                        $this->session->set_userdata('msg', 'Incorrect email or password');
                        redirect(base_url().'escrow/admin');
                    }
                } else {
                    if (password_verify($password, $admin['password'])) {
                        $session_data = array(
                            "id" => isset($admin['id']) && !empty($admin['id']) ? $admin['id'] : '',
                            "name" => isset($admin['first_name']) && !empty($admin['first_name']) ? $admin['first_name']." ".$admin['last_name'] : '',
                            "email" => isset($admin['email']) && !empty($admin['email']) ? $admin['email'] : '',
                            "user_type_id" => isset($admin['user_type_id']) && !empty($admin['user_type_id']) ? $admin['user_type_id'] : '',
                            "branch_id" => isset($admin['branch_id']) && !empty($admin['branch_id']) ? $admin['branch_id'] : '',
                            "user_type" => isset($admin['user_type']) && !empty($admin['user_type']) ? $admin['user_type'] : '',
                            "is_escrow_manager" => $admin['position_id'] == 7 ? 1 : 0,
                            "is_escrow_officer" => ($admin['position_id'] == 9 || $admin['position_id'] == 22 || $admin['position_id'] == 23) ? 1 : 0,
                            "is_escrow_assistant" => $admin['position_id'] == 15 ? 1 : 0
                        );
                        $this->session->set_userdata('escrow_admin', $session_data);
                        if ($admin['position_id'] == 9 || $admin['position_id'] == 22 || $admin['position_id'] == 23 || $admin['position_id']) {
                            redirect(base_url().'escrow/admin/orders');
                        } else {
                            redirect(base_url().'escrow/admin/dashboard');
                        }
                    } else {
                        $this->session->set_userdata('msg', 'Incorrect email or password');
                        redirect(base_url().'escrow/admin');
                    }
                }
            } else {
                $this->session->set_userdata('msg', 'Incorrect email or password');
                redirect(base_url().'escrow/admin');
            }
    	}
    }
}