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
		$userdata = $this->session->userdata('hr_admin');
		$request_type = $this->input->post('request_type');
        $request_id = $this->input->post('request_id');
        $status = $this->input->post('status');
        $condition = array(
            'id' => $request_id
        );
        $type = $status == '1' ? 'approved' : 'denied';
        if ($request_type == 'time_card') {
            $data = array(
                'status' => $type,
                'approved_date' => date('Y-m-d'),
                'approved_by_user_id' => 0,
                'approved_by_admin_user_id' => $userdata['id']
            );
			$this->hr->update($data, $condition, 'pct_hr_time_cards'); 
            $timeCardInfo = $this->common->getTimeCardInfo($request_id);
            $exceptionDate = date("F d, Y", strtotime($timeCardInfo['exception_date']));
            $message = 'Timecard request of '.$exceptionDate.' '.$type.' by '.$userdata['name'].' for '.$timeCardInfo['first_name']." ".$timeCardInfo['last_name'];
            $notificationData = array(
                'sent_user_id' => $timeCardInfo['user_id'],
                'message' => $message,
                'is_admin' => 0,
                'type' =>  $type
            );
            $this->hr->insert($notificationData, 'pct_hr_notifications');
            $this->common->callPusher($message, $type, $timeCardInfo['user_id'], 0);
            redirect(base_url().'hr/admin/time-cards');
        } else if ($request_type == 'incident_report') {
            $data = array(
                'status' => $type,
                'approved_date' => date('Y-m-d'),
                'approved_by_user_id' => 0,
                'approved_by_admin_user_id' => $userdata['id']
            );
			$this->hr->update($data, $condition, 'pct_hr_incident_reports'); 
            $incidentReportInfo = $this->common->getIncidentReport($request_id);
            $incident_date = date("F d, Y", strtotime($incidentReportInfo['incident_date']));
            $message = 'Incident report request of '.$incident_date.' '.$type.' by '.$userdata['name'].' for '.$incidentReportInfo['first_name']." ".$incidentReportInfo['last_name'];
            $notificationData = array(
                'sent_user_id' => $incidentReportInfo['user_id'],
                'message' => $message,
                'is_admin' => 0,
                'type' =>  $type
            );
            $this->hr->insert($notificationData, 'pct_hr_notifications');
            $this->common->callPusher($message, $type, $incidentReportInfo['user_id'], 0);
            redirect(base_url().'hr/admin/incident-reports');
        } else if ($request_type == 'vacation_request') {
            $data = array(
                'status' => $type,
                'approved_date' => date('Y-m-d'),
                'approved_by_user_id' => 0,
                'approved_by_admin_user_id' => $userdata['id']
            );
			$this->hr->update($data, $condition, 'pct_hr_vacation_requests'); 
            $vacationRequestInfo = $this->common->getVacationRequest($request_id);
            $from_date = date("F d, Y", strtotime($vacationRequestInfo['from_date']));
            $to_date = date("F d, Y", strtotime($vacationRequestInfo['to_date']));
            $message = 'Vacation request from '.$from_date.' to '.$to_date.' '.$type.' by '.$userdata['name'].' for '.$vacationRequestInfo['first_name']." ".$vacationRequestInfo['last_name'];
            $notificationData = array(
                'sent_user_id' => $vacationRequestInfo['user_id'],
                'message' => $message,
                'is_admin' => 0,
                'type' =>  $type
            );
            $this->hr->insert($notificationData, 'pct_hr_notifications');
            $this->common->callPusher($message, $type, $vacationRequestInfo['user_id'], 0);
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