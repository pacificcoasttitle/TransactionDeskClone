<?php

(defined('BASEPATH')) OR exit('No direct script access allowed');

class Login extends MX_Controller {

    function __construct() 
    {
        parent::__construct();
        $this->load->helper(
            array('file', 'url','form')
        );
        $this->load->library('form_validation');
        $this->load->model('hr/hr'); 
    }

    function index() 
    {
        $userdata = $this->session->userdata('hr_user');
        if (!empty($userdata['id'])) {
            redirect(base_url().'hr/dashboard');
        } else {
            redirect(base_url().'hr/login');
        }
    }

    function login() 
    {
        $userdata = $this->session->userdata('hr_user');
        if (!empty($userdata['id']) && $userdata['is_admin'] == 0) {
            redirect(base_url().'hr/dashboard');
        } 
        $data = array();

        if ($this->input->post()) {
            $this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email', array('required'=> 'Please enter Email', 'valid_email' => 'Enter a Valid email address'));
            $this->form_validation->set_rules('password', 'Password', 'required', array('required'=> 'Please enter password'));

            if ($this->form_validation->run($this) == FALSE) {
                $data['email_error_msg'] = form_error('email');
                $data['password_error_msg'] = form_error('password');
            } else {
                $email = $this->input->post('email');
                $password = $this->input->post('password');
                $user =  $this->hr->get_hr_user(array('email' => $email, 'status' => 1));
                if (!empty($user)) {
                    if($user['is_tmp_password'] == 1) {
                        if (password_verify($password, $user['password'])) {
                            $this->load->library('hr/common');
                            $randomString = $this->common->randomPassword();
                            $hash = md5($user['id'] . $user['email_address'] .$randomString);
                            $this->hr->update(array('hash' => $hash), array('id' => $user['id']), 'pct_hr_users');
                            redirect(base_url().'hr/change-password/'.$hash);
                        } else {
                            $data['password_error_msg'] = 'Please enter the correct login details.';
                        }
                    } else {
                        if (password_verify($password, $user['password'])) {
                            $session_data = array(
                                "id" => isset($user['id']) && !empty($user['id']) ? $user['id'] : '',
                                "name" => isset($user['first_name']) && !empty($user['first_name']) ? $user['first_name']." ".$user['last_name'] : '',
                                "email" => isset($user['email']) && !empty($user['email']) ? $user['email'] : '',
                                "user_type_id" => isset($user['user_type_id']) && !empty($user['user_type_id']) ? $user['user_type_id'] : '',
                            );
                            $this->session->set_userdata('hr_user', $session_data);
                            redirect(base_url().'hr/dashboard');
                        } else {
                            $data['password_error_msg'] = 'Please enter the correct login details.';
                        }
                    }
                } else {
                    $data['password_error_msg'] = 'Please enter the correct login details.';
                }
            }
    	} 
        $this->load->view('hr/login', $data);	
    }

    function change_password()
    {
        $hash = $this->uri->segment(3); 
        $user =  $this->hr->get_hr_user(array('hash' => $hash));
        if (!empty($user)) {
            if ($this->input->post()) {
                $this->form_validation->set_rules('password', 'Password', 'required', array('required'=> 'Enter your password'));
                $this->form_validation->set_rules('confirm_password', 'Confirm Password', 'required', array('required'=> 'Please enter confirm password'));

                if ($this->form_validation->run($this) == FALSE) {
                    $data['pwd_err_msg'] = form_error('password');
                    $data['confirm_pwd_err_msg'] = form_error('confirm_password');
                } else {
                    $password = $this->input->post('password');
                    $this->hr->update(array('password' => password_hash($password, PASSWORD_DEFAULT), 'is_tmp_password' => 0, 'hash' => ''), array('id' => $user['id']), 'pct_hr_users');
                    $session_data = array(
                        "id" => isset($user['id']) && !empty($user['id']) ? $user['id'] : '',
                        "name" => isset($user['first_name']) && !empty($user['first_name']) ? $user['first_name']." ".$user['last_name'] : '',
                        "email" => isset($user['email']) && !empty($user['email']) ? $user['email'] : '',
                        "user_type_id" => isset($user['user_type_id']) && !empty($user['user_type_id']) ? $user['user_type_id'] : '',
                    );
                    $this->session->set_userdata('hr_user', $session_data);
                    redirect(base_url().'hr/dashboard');
                }
            } else {
                $data['hash'] = $hash;
                $this->load->view('hr/change_password', $data);
            }
        } else {
            $data['change_password_error_msg'] = 'Invalid Link.';
            redirect(base_url().'hr/login');
        }
    }
}