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
        } else if ($request_type == 'time_sheet_status') {
            redirect(base_url().'hr/admin/time-sheets');
        }
		
	}
    
    public function markAsRead()
    {
        $userdata = $this->session->userdata('hr_admin');
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

	function randomizeTimeSheet() {
		$this->load->model('hr/branches_model');
		$this->load->model('hr/users_model');
		$this->load->model('frontend/hr/pct_hr_employee_time_tracking_model');
		$branch_names = [
			'10 PCT Glendale Escr',
			'12 PCT Glendale Titl'
		];
		// $branch_names = ['IT'];
		$dept_records = $this->branches_model->get_many_by('name',$branch_names);
		$dept_ids = array_column($dept_records,'id');
		$user_records = $this->users_model->get_many_by('branch_id',$dept_ids);
		$user_ids = array_column($user_records,'id');
		
		$start_date = strtotime('2022-04-01');
		$end_date = strtotime('2022-04-15');
		$current_date = $start_date;
		while($current_date <= $end_date) {
			$record_date = date('Y-m-d',$current_date );
			foreach($user_ids as $user_id) {
				
				//8:30am-:8:40am
				$random_start = strtotime($record_date.' '.'08:30:00');
				$random_end = strtotime($record_date.' '.'08:40:00');
				$random_time = rand($random_start,$random_end);
				$random_end = strtotime($record_date.' '.'17:30:00');
	
				
	
				
	
				$insert_tracking_tmp = [
					'employee_id'=>$user_id,
					'time_in'=>date("Y-m-d H:i:s",$random_time),
					'time_out'=>date("Y-m-d H:i:s",$random_end),
					'is_break'=>0
				];
				
				$this->pct_hr_employee_time_tracking_model->insert($insert_tracking_tmp);
			}

			$current_date = strtotime("+1 day",$current_date);


		}





		// $users = 		
	}
}
