<?php

(defined('BASEPATH')) OR exit('No direct script access allowed');

class Dashboard extends MX_Controller 
{
	function __construct() 
    {
        parent::__construct();
		$this->load->helper(
            array('file', 'url','form')
        );
        $this->load->library('session');
		$this->load->library('form_validation');
		$this->load->library('hr/template');
        $this->load->library('hr/common');
        $this->common->is_user();
	}
	
	function index()
	{
		$userdata = $this->session->userdata('hr_user');
		if ($userdata['user_type_id'] == 2) {
			$data['title'] = 'HR-Center Branch Manager Dashboard';
			$this->template->show("hr/branch_manager", "dashboard", $data);
		} else {
			$data['title'] = 'HR-Center Employee Dashboard';
			$this->template->show("hr/employee", "dashboard", $data);
		}
	}

	function logout()
	{
		$this->session->sess_destroy();
		$this->session->unset_userdata('hr_user');
		redirect(base_url().'hr');
	}
}