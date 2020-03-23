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
        $this->load->model('order/home_model'); 
        if ($this->session->userdata('id')) {
			if($this->session->userdata('is_admin') == 1) {
				redirect(base_url().'order/admin/dashboard');
			}
		} 
    }

    function index() 
    {
        if ($this->session->userdata('id') && $this->session->userdata('is_admin') == 0) {
            redirect(base_url().'order');
        } else {
            $data = array();
            $this->load->view('order/login', $data);	
        }
    }

    function do_login() 
    {
        if ($this->input->post()) {
            $this->form_validation->set_rules('email_address', 'Email', 'trim|required|valid_email');
            if ($this->form_validation->run($this) == FALSE) {
                $data['error'] =  'The Email field must contain a valid email address.';
                $this->load->view('login', $data);
            } else {
                $email = $this->input->post('email_address');
                $user =  $this->home_model->get_user(array('email_address' => $email));
                if (!empty($user)) {
                    $session_data = array(
                        "id" => isset($user['id']) && !empty($user['id']) ? $user['id'] : '',
                        "name" => isset($user['first_name']) && !empty($user['first_name']) ? $user['first_name'] : '',
                        "email" => isset($user['email_id']) && !empty($user['email_id']) ? $user['email_id'] : '',
                        "is_admin" => 0
                    );
                    $this->session->set_userdata($session_data);
                    redirect(base_url().'dashboard');
                } else {
                    $data['error'] =  'Please enter the correct email address';
                    $this->load->view('order/login', $data);
                }
            }
    	}
    }
}