<?php

(defined('BASEPATH')) OR exit('No direct script access allowed');

class Common extends MX_Controller 
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
        $this->load->model('hr/hr'); 
	}
	
	function approveDenyRequest()
	{
		$userdata = $this->session->userdata('hr_user');
		$request_type = $this->input->post('request_type');
        $request_id = $this->input->post('request_id');
        $status = $this->input->post('status');
        $condition = array(
            'id' => $request_id
        );
        if ($request_type == 'time_card') {
            $data = array(
                'status' => $status == '1' ? 'approved' : 'denied',
                'action_taken_user_id' => $userdata['id']
            );
			$this->hr->update($data, $condition, 'pct_hr_time_cards'); 
            redirect(base_url().'hr/time-cards');
        } else if ($request_type == 'incident_report') {
            $data = array(
                'status' => $status == '1' ? 'approved' : 'denied',
                'action_taken_user_id' => $userdata['id']
            );
			$this->hr->update($data, $condition, 'pct_hr_incident_reports'); 
            redirect(base_url().'hr/incident-reports');
        } else if ($request_type == 'vacation_request') {
            $data = array(
                'status' => $status == '1' ? 'approved' : 'denied',
                'action_taken_user_id' => $userdata['id']
            );
			$this->hr->update($data, $condition, 'pct_hr_vacation_requests'); 
            redirect(base_url().'hr/vacation-requests');
        }
	}	
}