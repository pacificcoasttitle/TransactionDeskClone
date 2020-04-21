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
    }

    function index() 
    {
        $userdata = $this->session->userdata('user');
        if (!empty($userdata['id']) && $userdata['is_admin'] == 0) {
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
                $response = array('status'=>'error', 'message'=> 'Enter a Valid email address.');
                echo json_encode($response); exit;
            } else {
                $email = $this->input->post('email_address');
                $user =  $this->home_model->get_user(array('email_address' => $email));
                if (!empty($user)) {
                    $session_data = array(
                        "id" => isset($user['id']) && !empty($user['id']) ? $user['id'] : '',
                        "name" => isset($user['first_name']) && !empty($user['first_name']) ? $user['first_name'] : '',
                        "email" => isset($user['email_address']) && !empty($user['email_address']) ? $user['email_address'] : '',
                        "is_admin" => 0
                    );
                    $this->session->set_userdata('user', $session_data);
                    $response = array('status'=>'success', 'message'=> '');
					echo json_encode($response); exit;
                } else {
                    $response = array('status'=>'error', 'message'=> 'Please enter the correct email address.');
					echo json_encode($response); exit;
                }
            }
    	}
    }
}