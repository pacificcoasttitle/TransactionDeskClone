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

        $this->load->model('hr/users_model');
        $userInfo = $this->users_model->get($userdata['id']);
        $branchUserInfo = $this->users_model->get_by(array('user_type_id' => 4, 'branch_id' => $userInfo->branch_id));
        $notificationData = array(
            'sent_user_id' => $branchUserInfo->id,
            'message' => $message,
            'type' => 'approved'
        );
        $this->hr->insert($notificationData, 'pct_hr_notifications');
        $this->common->sendNotification($message, 'approved', $branchUserInfo->id, 1);

        $superadminInfo = $this->users_model->get_by('user_type_id', 1);
        $notificationData['sent_user_id'] = $superadminInfo->id;
        $this->hr->insert($notificationData, 'pct_hr_notifications');
        $this->common->sendNotification($message, 'approved', $superadminInfo->id, 1);
    
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
			$is_break = $this->input->post('is_break');
			$this->load->model('hr/pct_hr_employee_time_tracking_model');
			$result = $this->pct_hr_employee_time_tracking_model->track_time($userdata['id'],$clock_event,$is_break);
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
	function viewTimeSheet($pay_period_start) {
		$userdata = $this->session->userdata('hr_user');
		// $current_date = $this->common->convertTimezone(date('Y-03-d H:i:s'),'Y-m-d H:i:s','America/Los_Angeles');
		$first_date = date('Y-m-d', $pay_period_start);
		$last_date = date('Y-m-d',strtotime("+13 day",$pay_period_start));


		$data = array();
		$data['user'] = $userdata;
		$data['first_date'] = $first_date;
		$data['last_date'] = $last_date;
		
		$this->load->model('hr/pct_hr_employee_time_tracking_model');
		$tracking_data = $this->pct_hr_employee_time_tracking_model->get_time_sheet($first_date,$last_date,$userdata['id']);
		$time_sheet_array_tmp = $time_sheet_array = array();
		foreach($tracking_data as $tracking_record) {
			
			$record_date =  date('Y-m-d',strtotime($tracking_record->time_in));
			if(!isset($time_sheet_array_tmp[$record_date])) {
				$time_sheet_array_tmp[$record_date] = array();
			}
				$time_sheet_array_tmp[$record_date][] =array(
					'time_in' => strtotime($tracking_record->time_in),
					'time_out' => strtotime($tracking_record->time_out),
					'is_break' => $tracking_record->is_break,
				);
		}
		$process_date = strtotime($first_date);
		while($process_date <= strtotime($last_date))
		{
			$record_date =  date('Y-m-d',$process_date);

			if(!isset($time_sheet_array_tmp[$record_date])) {
				$random_time = $random_lunch_start = $random_lunch_end = $random_end_time= "-";
				$random_reg_hours = 0;
				if(date('l', strtotime($record_date)) == 'Saturday' || date('l', strtotime($record_date)) == 'Sunday' ) {
					$random_time = $random_lunch_start = $random_lunch_end = $random_end_time= "-";
					$random_reg_hours = 0;
					
				}
				else {
					// $random_start = strtotime($record_date.' '.'09:00:00');
					// $random_end = strtotime($record_date.' '.'11:00:00');
					// $random_time = rand($random_start,$random_end);
	
					// $random_start = strtotime($record_date.' '.'13:00:00');
					// $random_end = strtotime($record_date.' '.'14:00:00');
					// $random_lunch_start = rand($random_start,$random_end);
	
					// $random_time_add = rand(2100,4000);
					// $random_lunch_end =  $random_lunch_start + $random_time_add;
	
					// $random_start = strtotime($record_date.' '.'18:00:00');
					// $random_end = strtotime($record_date.' '.'19:30:00');
					// $random_end_time = rand($random_start,$random_end);
					// $random_reg_hours = ($random_lunch_start - $random_time) + ($random_end_time - $random_lunch_end);



					// $insert_tracking_tmp = [
					// 	'employee_id'=>$userdata['id'],
					// 	'time_in'=>date("Y-m-d H:i:s",$random_time),
					// 	'time_out'=>date("Y-m-d H:i:s",$random_lunch_start),
					// 	'is_break'=>1
					// ];
					// $this->pct_hr_employee_time_tracking_model->insert($insert_tracking_tmp);
					// $insert_tracking_tmp = [
					// 	'employee_id'=>$userdata['id'],
					// 	'time_in'=>date("Y-m-d H:i:s",$random_lunch_end),
					// 	'time_out'=>date("Y-m-d H:i:s",$random_end_time),
					// 	'is_break'=>0
					// ];
					// $this->pct_hr_employee_time_tracking_model->insert($insert_tracking_tmp);
				}

				$time_sheet_array[$record_date] = [
					'start_time' => $random_time,
					'lunch_start' => $random_lunch_start,
					'lunch_end' => $random_lunch_end,
					'end_time' => $random_end_time,
					'reg_hours'=>$random_reg_hours,
					'ot_hours'=>'0',
					'double_ot_hours'=>'0',
					'lunch_hours'=>'0',
					'unpaid_hours'=>'0',
				];
			}
			else {
				$total_hours = 0;
				$lunch_hours = 0;
				$unpaid_hours = 0;

				if(count($time_sheet_array_tmp[$record_date]) == 1) {
					
					$time_sheet_array[$record_date]['start_time'] = $time_sheet_array_tmp[$record_date][0]['time_in'];
					$time_sheet_array[$record_date]['end_time'] = $time_sheet_array_tmp[$record_date][0]['time_out'];
					$total_hours = $time_sheet_array_tmp[$record_date][0]['time_out'] - $time_sheet_array_tmp[$record_date][0]['time_in'];

				}
				else {

					$was_break = 0;
					$total_hours = $lunch_hours = $unpaid_hours = $last_tracked_time = $hours_counted = 0;
					
					foreach($time_sheet_array_tmp[$record_date] as $key=>$track_time) {
						$hours_counted = 0;
						if($key==0) {
							$time_sheet_array[$record_date]['start_time'] = $track_time['time_in'];
							if($track_time['is_break'] == 1  && $key<count($time_sheet_array_tmp) && empty($time_sheet_array[$record_date]['lunch_start'])) {
								
								$time_sheet_array[$record_date]['lunch_start'] = $track_time['time_out'];
								$was_break = 1;
							}
						}
						elseif($was_break) {
							$time_sheet_array[$record_date]['lunch_end'] = $track_time['time_in'];
							$was_break = 0;
							$lunch_hours += $track_time['time_in'] - $last_tracked_time;
							$hours_counted = 1;
						}
						elseif($track_time['is_break'] == 1  && $key<count($time_sheet_array_tmp) && empty($time_sheet_array[$record_date]['lunch_start'])) {
							$time_sheet_array[$record_date]['lunch_start'] = $track_time['time_out'];
							$was_break = 1;
							
						}
						if(($key+1) == count($time_sheet_array_tmp[$record_date])) {
							$time_sheet_array[$record_date]['end_time'] = $track_time['time_out'];
							// $working_hours += $track_time['time_out'] - $track_time['time_in'];

						}
						if($hours_counted == 0 && $key>0) {
							$unpaid_hours += $track_time['time_in'] - $last_tracked_time;
						}
						$last_tracked_time = $track_time['time_out'];
						$total_hours += $track_time['time_out'] - $track_time['time_in'];

					}

				}
				if(empty($time_sheet_array[$record_date]['lunch_start'])) {
					$time_sheet_array[$record_date]['lunch_start'] = '-';
					$time_sheet_array[$record_date]['lunch_end'] = '-';
				}
				$time_sheet_array[$record_date]['ot_hours'] = '0';
				$time_sheet_array[$record_date]['double_ot_hours'] = '0';
				$time_sheet_array[$record_date]['reg_hours'] = $total_hours;
				$time_sheet_array[$record_date]['lunch_hours'] = $lunch_hours;
				$time_sheet_array[$record_date]['unpaid_hours'] = $unpaid_hours;
				
			}
			$process_date = strtotime("+1 day", $process_date);
		}
		$data['time_sheet_array'] = $time_sheet_array;
		$this->load->view('hr/time_sheet',$data);
	}
}
