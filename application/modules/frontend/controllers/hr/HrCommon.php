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
	
    public function markAsRead()
    {
        $userdata = $this->session->userdata('hr_user');
        $condition = array(
            'sent_user_id' => $userdata['id']
        );
        $data = array(
            'is_read' => 1
        );
        $this->hr->update($data, $condition, 'pct_hr_notifications');
        $response = array(
            'success' => 'true',
            'message'  => 'Notifcation marked as read.',
        );
        echo json_encode($response);
    }

    public function completeTraining($id)
    {
        $this->load->model('admin/hr/training_model');
        $errors = array();
        $success = array();
        $trainingDetails = $this->training_model->get($id);
        $userdata = $this->session->userdata('hr_user');
        $condition = array(
            'user_id' => $userdata['id'],
            'training_id' => $id
        );
        $data = array(
            'is_complete' => 1
        );
        $this->hr->update($data, $condition, 'pct_hr_user_training_status');
        $message = $trainingDetails->name.' training completed successfully by '.$userdata['name'];
        $notificationData = array(
            'sent_user_id' => 0,
            'message' => $message,
            'is_admin' => 1,
            'type' => 'approved'
        );
        $this->hr->insert($notificationData, 'pct_hr_notifications');
        $this->common->sendNotification($message, 'approved', 0, 1);
        
        $success[] = $trainingDetails->name.' training completed successfully';
        $data = array(
            "errors" =>  $errors,
            "success" => $success
        );
        $this->session->set_userdata($data);
        redirect(base_url().'hr/trainings');
    }

	function recordTime()
	{
		$userdata = $this->session->userdata('hr_user');
		$response = array('status'=>false);
		if(!empty($userdata['id'])) {
			$clock_event = $this->input->post('clock_event');
			$this->load->model('hr/pct_hr_employee_time_tracking_model');
			$result = $this->pct_hr_employee_time_tracking_model->track_time($userdata['id'],$clock_event);
			$response['status'] = $result;
		}
		echo json_encode($response);
	}

	function stopTimer() {
		$this->load->model('hr/pct_hr_employee_time_tracking_model');
		$where['time_out'] = NULL;
		$data = $this->pct_hr_employee_time_tracking_model->get_many_by($where);
		foreach($data as $record) {
			$start_time = $record->time_in;
			$start_date = date('Y-m-d',strtotime($start_time));
			$end_time = $start_date.' 21:00:00'; // PST 9 pm
			$current_time = $this->common->convertTimezone(date('Y-m-d H:i:s'),'Y-m-d H:i:s','America/Los_Angeles');
			if((strtotime($start_time) < strtotime($end_time)) && (strtotime($end_time) <= strtotime($current_time))) {
				$update_data = array();
				$update_data['time_out'] = $end_time;
				$update_data['is_auto'] = 1;
				$this->pct_hr_employee_time_tracking_model->update($record->id,$update_data);
			}
		}
	}
}
