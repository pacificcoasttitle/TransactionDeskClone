<?php

(defined('BASEPATH')) OR exit('No direct script access allowed');

class User extends MX_Controller 
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
		$data['title'] = 'HR-Center Employee Prolife';
        $this->template->show("hr/employee", "profile", $data);
	}

    public function updateUserInfo()
    {
        $userdata = $this->session->userdata('hr_user');
        $errors = array();
        $success = array();
       
        $userInfo = array(
            'user_id' => $userdata['id'],
            'incident_date' => date("Y-m-d", strtotime($this->input->post('incident_date'))),
            'employee_number' => $this->input->post('employee_number'),
            'incident_reason' => $this->input->post('incident_reason'),
            'incident_detail' => $this->input->post('incident_detail'),
            'actions' => implode(",", $this->input->post('actions')),
            'num_of_incidents' => implode(",", $this->input->post('num_of_incidents'))
        );
        $id = $this->hr->insert($userInfo, 'pct_hr_incident_reports');
            
        if(!empty($id)) {
            $success[] = "Incident Report saved successfully.";
        } else {
            $errors[] = "Something went wrong. Please try again.";
        }
        
        $data = array(
            "errors" =>  $errors,
            "success" => $success
        );
        $this->session->set_userdata($data);
        redirect(base_url().'hr/incident-reports');
    }
}