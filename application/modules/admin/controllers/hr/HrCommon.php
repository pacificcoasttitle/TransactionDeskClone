<?php

(defined('BASEPATH')) OR exit('No direct script access allowed');

class HrCommon extends MX_Controller 
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
        $this->load->library('hr/common');
	}
	
	function approveDenyRequest()
	{
		$request_type = $this->input->post('request_type');
        $request_id = $this->input->post('request_id');
        $status = $this->input->post('status');
        $this->common->approveDenyRequest($request_type, $request_id, $status);
        if ($request_type == 'time_card') {
            redirect(base_url().'hr/admin/time-cards');
        } else if ($request_type == 'incident_report') {
            redirect(base_url().'hr/admin/incident-reports');
        } else if ($request_type == 'vacation_request') {
            redirect(base_url().'hr/admin/vacation-requests');
        }
	}
    
    public function markAsRead()
    {
        $condition = array(
            'is_admin' => 1
        );
        $data = array(
            'is_admin_read' => 1
        );
        $this->hr->update($data, $condition, 'pct_hr_notifications');
        $response = array(
            'success' => 'true',
            'message'  => 'Notifcation marked as read.',
        );
        echo json_encode($response);
    }
}