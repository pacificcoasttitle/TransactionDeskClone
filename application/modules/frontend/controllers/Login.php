<?php

(defined('BASEPATH')) OR exit('No direct script access allowed');

class Login extends MX_Controller {

    function __construct() 
    {
        parent::__construct();
        $this->load->helper(array('file', 'url'));
        $this->load->library('form_validation');
        $this->load->model('home_model'); 
    }

    function index() 
    {
        if ($this->session->userdata('id')) {
            redirect(base_url().'/dashboard');
        } else {
            $data = array();
            $this->load->view('login', $data);
        }	
    }

    function login() 
    {
        if ($this->input->post()) {
            $this->form_validation->set_rules('OpenEmail', 'Email', 'trim|required|valid_email|xss_clean');
            if ($this->form_validation->run($this) == FALSE) {
                $data['error'] =  form_error('OpenEmail');
                $this->load->view('login', $data);
            } else {
                $email = $this->input->post('OpenEmail');
                $user = $this->home_model->get_user($email);
                if ($user) {
                    $session_data = array(
                        "id" => isset($user['id']) && !empty($user['id']) ? $user['id'] : '',
                        "name" => isset($user['user_name']) && !empty($user['user_name']) ? $user['user_name'] : '',
                        "email_address" => isset($user['email_id']) && !empty($user['email_id']) ? $user['email_id'] : ''
                    );
                    $this->session->set_userdata($session_data);
                    redirect(base_url().'/dashboard');
                } else {
                    $data['error'] =  form_error('OpenEmail');
                    $this->load->view('login', $data);
                }
            }
    	}
    }
}