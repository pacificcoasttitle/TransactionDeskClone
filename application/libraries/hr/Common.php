<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class Common 
{
    public static $CI;
    
	public function __construct($params = array())
	{
		$this->CI =& get_instance();                        
		$this->CI->load->database();
        $this->CI->load->library('email');
        $this->CI->load->library('session');
		self::$CI = $this->CI;
    }

    public function is_hr_admin()
    {
        $userdata = $this->CI->session->userdata('hr_admin');
        if (!empty($userdata['id']) && $userdata['is_hr_admin'] == 1) {
            return true;
        } else {
            redirect(base_url().'hr/admin');
        }
    }

    public function randomPassword() 
    {
        $len = 8;
        $sets = array();
        $sets[] = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $sets[] = 'abcdefghijkmnopqrstuvwxyz';
        $sets[] = '0123456789';
        $password = '';
        
        foreach ($sets as $set) {
            $password .= $set[array_rand(str_split($set))];
        }
    
        while(strlen($password) < $len) {
            $randomSet = $sets[array_rand($sets)];
            $password .= $randomSet[array_rand(str_split($randomSet))]; 
        }
        return str_shuffle($password);
    }

    public function is_user()
    {
        $userdata = $this->CI->session->userdata('hr_user');
        if (empty($userdata)) {
            redirect(base_url().'hr/login');
        } 
    }

    public function is_manager_user()
    {
        $userdata = $this->CI->session->userdata('hr_user');
        if (!empty($userdata['id']) && $userdata['user_type_id'] == 2) {
            return true;
        } else {
            redirect(base_url().'hr/dashboard');
        }
    }

    public function is_employee_user()
    {
        $userdata = $this->CI->session->userdata('hr_user');
        if (!empty($userdata['id']) && $userdata['user_type_id'] == 1) {
            return true;
        } else {
            redirect(base_url().'hr/dashboard');
        }
    }

    public function getTimeCards($params)
    { 
        $this->CI->db->from('pct_hr_time_cards')
                 ->join('pct_hr_users', 'pct_hr_users.id = pct_hr_time_cards.user_id');

        if(!empty($this->CI->session->userdata('hr_user'))) {
            $userdata = $this->CI->session->userdata('hr_user');
            $this->CI->db->where('pct_hr_time_cards.user_id', $userdata['id']);
        }

        $total_records =  $this->CI->db->count_all_results();
		$limit = isset($params['length']) && !empty($params['length']) ? $params['length'] : '';
        $offset = isset($params['start']) && !empty($params['start']) ? $params['start'] : '';
        $timeCardsList = array();

    	if (isset($params['searchvalue']) && !empty($params['searchvalue'])) {
    		$keyword = $params['searchvalue'];

    		if (isset($keyword) && !empty($keyword)) {
                $this->CI->db->group_start()
                        ->like('pct_hr_users.first_name', $keyword)
                        ->or_like('pct_hr_users.last_name', $keyword)
                        ->or_like('pct_hr_time_cards.exception_date', date("Y-m-d", strtotime($keyword)))
                        ->or_like('pct_hr_time_cards.reg_hours', $keyword)
                        ->or_like('pct_hr_time_cards.ot_hours', $keyword)
                        ->or_like('pct_hr_time_cards.double_ot', $keyword)
                        ->or_like('pct_hr_time_cards.total_hours', $keyword)
                        ->group_end();
            }
            
            $this->CI->db->from('pct_hr_time_cards')
                 ->join('pct_hr_users', 'pct_hr_users.id = pct_hr_time_cards.user_id');

            if(!empty($this->CI->session->userdata('hr_user'))) {
                $userdata = $this->CI->session->userdata('hr_user');
                $this->CI->db->where('pct_hr_time_cards.user_id', $userdata['id']);
            }
			$filter_total_records =  $this->CI->db->count_all_results();

			if (isset($keyword) && !empty($keyword)) {
                $this->CI->db->group_start()
                        ->like('pct_hr_users.first_name', $keyword)
                        ->or_like('pct_hr_users.last_name', $keyword)
                        ->or_like('pct_hr_time_cards.exception_date', date("Y-m-d", strtotime($keyword)))
                        ->or_like('pct_hr_time_cards.reg_hours', $keyword)
                        ->or_like('pct_hr_time_cards.ot_hours', $keyword)
                        ->or_like('pct_hr_time_cards.double_ot', $keyword)
                        ->or_like('pct_hr_time_cards.total_hours', $keyword)
                        ->group_end();
            }

            $this->CI->db->select('pct_hr_time_cards.*, pct_hr_users.first_name,  pct_hr_users.last_name');
            $this->CI->db->from('pct_hr_time_cards')
                ->join('pct_hr_users', 'pct_hr_users.id = pct_hr_time_cards.user_id');

            if(!empty($this->CI->session->userdata('hr_user'))) {
                $userdata = $this->CI->session->userdata('hr_user');
                $this->CI->db->where('pct_hr_time_cards.user_id', $userdata['id']);
            }
            $this->CI->db->order_by('pct_hr_time_cards.id', 'desc');

            if ((isset($limit) && !empty($limit)) || (isset($offset) && !empty($offset))) {
                $this->CI->db->limit($limit, $offset);
            }	

			$query = $this->CI->db->get();
			if ($query->num_rows() > 0) {
	            $timeCardsList = $query->result_array();
	        }
    	} else {    		
    		$this->CI->db->from('pct_hr_time_cards')
                 ->join('pct_hr_users', 'pct_hr_users.id = pct_hr_time_cards.user_id');

            if(!empty($this->CI->session->userdata('hr_user'))) {
                $userdata = $this->CI->session->userdata('hr_user');
                $this->CI->db->where('pct_hr_time_cards.user_id', $userdata['id']);
            }
            $filter_total_records =  $this->CI->db->count_all_results();

            $this->CI->db->select('pct_hr_time_cards.*, pct_hr_users.first_name,  pct_hr_users.last_name');
            $this->CI->db->from('pct_hr_time_cards')
                ->join('pct_hr_users', 'pct_hr_users.id = pct_hr_time_cards.user_id');

            if(!empty($this->CI->session->userdata('hr_user'))) {
                $userdata = $this->CI->session->userdata('hr_user');
                $this->CI->db->where('pct_hr_time_cards.user_id', $userdata['id']);
            }
            $this->CI->db->order_by('pct_hr_time_cards.id', 'desc');

			if ((isset($limit) && !empty($limit)) || (isset($offset) && !empty($offset))) {
                
                $this->CI->db->limit($limit, $offset);
            }

			$query = $this->CI->db->get();
			if ($query->num_rows() > 0) {
	            $timeCardsList = $query->result_array();
	        } 
    	}

    	return array(
            'recordsTotal' => $total_records,
            'recordsFiltered' => $filter_total_records,
            'data' => $timeCardsList
        );
    }

    public function getVacationRequests($params)
    { 
        $this->CI->db->from('pct_hr_vacation_requests')
                 ->join('pct_hr_users', 'pct_hr_users.id = pct_hr_vacation_requests.user_id');

        if(!empty($this->CI->session->userdata('hr_user'))) {
            $userdata = $this->CI->session->userdata('hr_user');
            $this->CI->db->where('pct_hr_vacation_requests.user_id', $userdata['id']);
        }

        $total_records =  $this->CI->db->count_all_results();
		$limit = isset($params['length']) && !empty($params['length']) ? $params['length'] : '';
        $offset = isset($params['start']) && !empty($params['start']) ? $params['start'] : '';
        $vacationRequestsList = array();

    	if (isset($params['searchvalue']) && !empty($params['searchvalue'])) {
    		$keyword = $params['searchvalue'];

    		if (isset($keyword) && !empty($keyword)) {
                $this->CI->db->group_start()
                        ->like('pct_hr_users.first_name', $keyword)
                        ->or_like('pct_hr_users.last_name', $keyword)
                        ->or_like('pct_hr_vacation_requests.comment', $keyword)
                        ->or_like('pct_hr_vacation_requests.from_date', date("Y-m-d", strtotime($keyword)))
                        ->or_like('pct_hr_vacation_requests.to_date', date("Y-m-d", strtotime($keyword)))
                        ->or_like('pct_hr_vacation_requests.is_salary_deduction', strtolower($keyword) == 'yes' ? 1 : 0)
                        ->or_like('pct_hr_vacation_requests.is_time_charged_vacation', strtolower($keyword) == 'yes' ? 1 : 0)
                        ->group_end();
            }
            
            $this->CI->db->from('pct_hr_vacation_requests')
                 ->join('pct_hr_users', 'pct_hr_users.id = pct_hr_vacation_requests.user_id');

            if(!empty($this->CI->session->userdata('hr_user'))) {
                $userdata = $this->CI->session->userdata('hr_user');
                $this->CI->db->where('pct_hr_vacation_requests.user_id', $userdata['id']);
            }
			$filter_total_records =  $this->CI->db->count_all_results();

			if (isset($keyword) && !empty($keyword)) {
                $this->CI->db->group_start()
                        ->like('pct_hr_users.first_name', $keyword)
                        ->or_like('pct_hr_users.last_name', $keyword)
                        ->or_like('pct_hr_vacation_requests.comment', $keyword)
                        ->or_like('pct_hr_vacation_requests.from_date', date("Y-m-d", strtotime($keyword)))
                        ->or_like('pct_hr_vacation_requests.to_date', date("Y-m-d", strtotime($keyword)))
                        ->or_like('pct_hr_vacation_requests.is_salary_deduction', strtolower($keyword) == 'yes' ? 1 : 0)
                        ->or_like('pct_hr_vacation_requests.is_time_charged_vacation', strtolower($keyword) == 'yes' ? 1 : 0)
                        ->group_end();
            }

            $this->CI->db->select('pct_hr_vacation_requests.*, pct_hr_users.first_name,  pct_hr_users.last_name');
            $this->CI->db->from('pct_hr_vacation_requests')
                ->join('pct_hr_users', 'pct_hr_users.id = pct_hr_vacation_requests.user_id');

            if(!empty($this->CI->session->userdata('hr_user'))) {
                $userdata = $this->CI->session->userdata('hr_user');
                $this->CI->db->where('pct_hr_vacation_requests.user_id', $userdata['id']);
            }
            $this->CI->db->order_by('pct_hr_vacation_requests.id', 'desc');

            if ((isset($limit) && !empty($limit)) || (isset($offset) && !empty($offset))) {
                $this->CI->db->limit($limit, $offset);
            }	

			$query = $this->CI->db->get();
           
			if ($query->num_rows() > 0) {
	            $vacationRequestsList = $query->result_array();
	        }
    	} else {    		
    		$this->CI->db->from('pct_hr_vacation_requests')
                 ->join('pct_hr_users', 'pct_hr_users.id = pct_hr_vacation_requests.user_id');

            if(!empty($this->CI->session->userdata('hr_user'))) {
                $userdata = $this->CI->session->userdata('hr_user');
                $this->CI->db->where('pct_hr_vacation_requests.user_id', $userdata['id']);
            }
            $filter_total_records =  $this->CI->db->count_all_results();

            $this->CI->db->select('pct_hr_vacation_requests.*, pct_hr_users.first_name,  pct_hr_users.last_name');
            $this->CI->db->from('pct_hr_vacation_requests')
                ->join('pct_hr_users', 'pct_hr_users.id = pct_hr_vacation_requests.user_id');

            if(!empty($this->CI->session->userdata('hr_user'))) {
                $userdata = $this->CI->session->userdata('hr_user');
                $this->CI->db->where('pct_hr_vacation_requests.user_id', $userdata['id']);
            }
            $this->CI->db->order_by('pct_hr_vacation_requests.id', 'desc');

			if ((isset($limit) && !empty($limit)) || (isset($offset) && !empty($offset))) {
                
                $this->CI->db->limit($limit, $offset);
            }

			$query = $this->CI->db->get();
			if ($query->num_rows() > 0) {
	            $vacationRequestsList = $query->result_array();
	        } 
    	}
        
    	return array(
            'recordsTotal' => $total_records,
            'recordsFiltered' => $filter_total_records,
            'data' => $vacationRequestsList
        );
    }
}
