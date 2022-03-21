<?php
class Pct_hr_employee_time_tracking_model extends MY_Model 
{
    public $_table = 'pct_hr_employee_time_tracking';

	public $belongs_to = array('user' => array( 'model' => 'hr/users_model','primary_key' => 'employee_id' ));

	public function track_time($user_id,$clock_event)
	{
		$track_data = array();
		$track_data['employee_id'] = $user_id;
		if($clock_event == 'IN') {
			$track_data['time_in'] = date('Y-m-d H:i:s');
			$this->insert($track_data);
			return true;
		}
		else {
			$record = $this->order_by('id','desc')->get_by($track_data);
			if($record && empty($record->time_out)) {
				$update_data = array('time_out'=>date('Y-m-d H:i:s'));
				$this->update($record->id,$update_data);
				return true;
			}
		}
		return false;
		
	}

	public function get_clock_event($user_id)
	{
		$track_data = array();
		$track_data['employee_id'] = $user_id;
		$record = $this->order_by('id','desc')->get_by($track_data);
		if($record && empty($record->time_out)) {
			return 'OUT';
		}
		else {
			return 'IN';
		}
	}

	public function get_today_working($user_id)
	{
		//SELECT employee_id,DATE(time_in),SUM(TIMESTAMPDIFF(SECOND,time_in,time_out)) AS time_diff FROM pct_hr_employee_time_tracking GROUP BY employee_id,DATE(time_in);
		$this->db->select('SUM(TIMESTAMPDIFF(SECOND,time_in,time_out)) AS time_diff');
		$this->db->where('DATE(time_in)',date('Y-m-d'));
		$this->db->where('employee_id',$user_id);
		$query = $this->db->get($this->_table);
		$result = $query->row();
		if($result && !empty($result->time_diff)) {
			return $result->time_diff;
		}
		else {
			return 0;
		}
	}

	public function get_last_time($user_id)
	{
		$track_data = array();
		$track_data['employee_id'] = $user_id;
		// $track_data['DATE(time_in)'] = date('Y-m-d');
		$record = $this->order_by('id','desc')->get_by($track_data);
		
		if($record && empty($record->time_out)) {
			
			return (strtotime(date('Y-m-d H:i:s')) - strtotime($record->time_in));
		}
		else {
			return 0;
		}
	}
}
