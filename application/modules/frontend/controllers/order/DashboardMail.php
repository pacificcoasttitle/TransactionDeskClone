<?php

(defined('BASEPATH')) OR exit('No direct script access allowed');

class Dashboard extends MX_Controller {

	function __construct() {
        parent::__construct();
		$this->load->helper(
            array('file', 'url','form')
        );
        $this->load->library('session');
		$this->load->library('form_validation');
		$this->load->library('order/order');
        $this->load->model('order/apiLogs');
		$this->load->model('order/home_model');
    }

    public function generateCplFromMail()
    {
        $fileId = $this->uri->segment(2);    
        $data['title'] = 'Smart Dashboard | Pacific Coast Title Company';
        $data['mail_dashboard'] = 1;
        
		$this->load->view('layout/head_dashboard',$data);
		$this->load->view('order/mail_cpl');
    }
    
}