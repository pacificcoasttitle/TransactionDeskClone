<?php

(defined('BASEPATH')) OR exit('No direct script access allowed');

class Dashboard extends MX_Controller {

	function __construct() {
        parent::__construct();
        $this->load->helper(array('file', 'url'));
        $this->load->library('session');
		$this->load->library('form_validation');
    }

    function selectFiles()
    {
    	/*echo "<pre>"; print_r("here"); exit;
    	$this->is_user();*/
		$data['title'] = 'Smart Dashboard | Pacific Coast Title Company';
		$this->load->view('layout/head_dashboard',$data);
		$this->load->view('order/select-files');
    }

    function getFiles()
    {
    	$this->is_user();
		$data['title'] = 'Smart Dashboard | Pacific Coast Title Company';
		$this->load->view('layout/head_dashboard',$data);
		$this->load->view('order/dashboard');
    }

    function recordings()
    {
    	// $this->is_user();
		$data['title'] = 'Smart Dashboard | Pacific Coast Title Company';
		$this->load->view('layout/head_dashboard',$data);
		$this->load->view('order/recordings');
    }
}