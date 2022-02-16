<?php
class Hr extends CI_Model 
{
    public function get_hr_user($params = array()) 
    {
        $this->db->select('pct_hr_users.*,pct_hr_user_types.name as user_type');
        $this->db->from('pct_hr_users');
        $this->db->join('pct_hr_user_types','pct_hr_users.user_type_id = pct_hr_user_types.id','left');
        foreach($params as $key => $val){
            $this->db->where('pct_hr_users.'.$key, $val);
        }
        $query = $this->db->get();
        $result = $query->row_array();
        if(!empty($result)) { 
            return $result;
        } else {
            return array();
        }   
    }

    public function insert($data = array(), $table) 
    {
        if (!empty($data)) {
        	$data['created_at'] = date("Y-m-d H:i:s");
            $insert = $this->db->insert($table, $data);
            return $insert ? $this->db->insert_id() : false;
        }
        return false;
    }

    public function update($data, $condition = array(), $table) 
    {
        if (!empty($data)) {          
            $data['updated_at'] = date("Y-m-d H:i:s");
            $update = $this->db->update($table, $data, $condition);
            return $update ? true : false;
        }
        return false;
    }

    public function getTimeCards($params)
    { 
        $userdata = $this->session->userdata('hr_user');
        $usersIds = array();
        if(!empty($this->session->userdata('hr_user'))) {
            if ($userdata['user_type_id'] == 2) {
                $usersForBranchManager = $this->getUsersForBranchManager($userdata['id']);
                if(!empty($usersForBranchManager)) {
                    $usersIds = explode(",", $usersForBranchManager['ids']);
                    $usersIds[] = $userdata['id'];
                } else {
                    $usersIds[] = $userdata['id'];
                }
            } 
        }
        
        $this->db->from('pct_hr_time_cards')
                ->join('pct_hr_users', 'pct_hr_users.id = pct_hr_time_cards.user_id')
                ->join('pct_hr_users as branch_manager', 'branch_manager.id = pct_hr_time_cards.approved_by_user_id', 'left')
                ->join('admin', 'admin.id = pct_hr_time_cards.approved_by_admin_user_id', 'left');

        if(!empty($usersIds)) {
            $this->db->where_in('pct_hr_time_cards.user_id', $usersIds);
        } else {
            $this->db->where_in('pct_hr_time_cards.user_id', $userdata['id']);
        }

        $total_records =  $this->db->count_all_results();
		$limit = isset($params['length']) && !empty($params['length']) ? $params['length'] : '';
        $offset = isset($params['start']) && !empty($params['start']) ? $params['start'] : '';
        $timeCardsList = array();

    	if (isset($params['searchvalue']) && !empty($params['searchvalue'])) {
    		$keyword = $params['searchvalue'];

    		if (isset($keyword) && !empty($keyword)) {
                $this->db->group_start()
                        ->like('pct_hr_users.first_name', $keyword)
                        ->or_like('pct_hr_users.last_name', $keyword)
                        ->or_like('pct_hr_time_cards.exception_date', date("Y-m-d", strtotime($keyword)))
                        ->or_like('pct_hr_time_cards.reg_hours', $keyword)
                        ->or_like('pct_hr_time_cards.ot_hours', $keyword)
                        ->or_like('pct_hr_time_cards.double_ot', $keyword)
                        ->or_like('pct_hr_time_cards.total_hours', $keyword)
                        ->or_like('branch_manager.first_name', $keyword)
                        ->or_like('branch_manager.last_name', $keyword)
                        ->or_like('admin.user_name', $keyword)
                        ->group_end();
            }
            
            $this->db->from('pct_hr_time_cards')
                ->join('pct_hr_users', 'pct_hr_users.id = pct_hr_time_cards.user_id')
                ->join('pct_hr_users as branch_manager', 'branch_manager.id = pct_hr_time_cards.approved_by_user_id', 'left')
                ->join('admin', 'admin.id = pct_hr_time_cards.approved_by_admin_user_id', 'left');

            if(!empty($usersIds)) {
                $this->db->where_in('pct_hr_time_cards.user_id', $usersIds);
            } else {
                $this->db->where_in('pct_hr_time_cards.user_id', $userdata['id']);
            }
			$filter_total_records =  $this->db->count_all_results();

			if (isset($keyword) && !empty($keyword)) {
                $this->db->group_start()
                        ->like('pct_hr_users.first_name', $keyword)
                        ->or_like('pct_hr_users.last_name', $keyword)
                        ->or_like('pct_hr_time_cards.exception_date', date("Y-m-d", strtotime($keyword)))
                        ->or_like('pct_hr_time_cards.reg_hours', $keyword)
                        ->or_like('pct_hr_time_cards.ot_hours', $keyword)
                        ->or_like('pct_hr_time_cards.double_ot', $keyword)
                        ->or_like('pct_hr_time_cards.total_hours', $keyword)
                        ->or_like('branch_manager.first_name', $keyword)
                        ->or_like('branch_manager.last_name', $keyword)
                        ->or_like('admin.user_name', $keyword)
                        ->or_like('branch_manager.first_name', $keyword)
                        ->or_like('branch_manager.last_name', $keyword)
                        ->or_like('admin.user_name', $keyword)
                        ->group_end();
            }

            $this->db->select('pct_hr_time_cards.*, pct_hr_users.first_name,  pct_hr_users.last_name, admin.user_name, branch_manager.first_name as branch_manager_first_name, branch_manager.last_name as branch_manager_last_name');
            $this->db->from('pct_hr_time_cards')
                ->join('pct_hr_users', 'pct_hr_users.id = pct_hr_time_cards.user_id')
                ->join('pct_hr_users as branch_manager', 'branch_manager.id = pct_hr_time_cards.approved_by_user_id', 'left')
                ->join('admin', 'admin.id = pct_hr_time_cards.approved_by_admin_user_id', 'left');

            if(!empty($usersIds)) {
                $this->db->where_in('pct_hr_time_cards.user_id', $usersIds);
            } else {
                $this->db->where_in('pct_hr_time_cards.user_id', $userdata['id']);
            }
            $this->db->order_by('pct_hr_time_cards.id', 'desc');

            if ((isset($limit) && !empty($limit)) || (isset($offset) && !empty($offset))) {
                $this->db->limit($limit, $offset);
            }	

			$query = $this->db->get();
			if ($query->num_rows() > 0) {
	            $timeCardsList = $query->result_array();
	        }
    	} else {    		
    		$this->db->from('pct_hr_time_cards')
                ->join('pct_hr_users', 'pct_hr_users.id = pct_hr_time_cards.user_id')
                ->join('pct_hr_users as branch_manager', 'branch_manager.id = pct_hr_time_cards.approved_by_user_id', 'left')
                ->join('admin', 'admin.id = pct_hr_time_cards.approved_by_admin_user_id', 'left');

            if(!empty($usersIds)) {
                $this->db->where_in('pct_hr_time_cards.user_id', $usersIds);
            } else {
                $this->db->where_in('pct_hr_time_cards.user_id', $userdata['id']);
            }
            $filter_total_records =  $this->db->count_all_results();

            $this->db->select('pct_hr_time_cards.*, pct_hr_users.first_name,  pct_hr_users.last_name, admin.user_name, branch_manager.first_name as branch_manager_first_name, branch_manager.last_name as branch_manager_last_name');
            $this->db->from('pct_hr_time_cards')
                ->join('pct_hr_users', 'pct_hr_users.id = pct_hr_time_cards.user_id')
                ->join('pct_hr_users as branch_manager', 'branch_manager.id = pct_hr_time_cards.approved_by_user_id', 'left')
                ->join('admin', 'admin.id = pct_hr_time_cards.approved_by_admin_user_id', 'left');

            if(!empty($usersIds)) {
                $this->db->where_in('pct_hr_time_cards.user_id', $usersIds);
            } else {
                $this->db->where_in('pct_hr_time_cards.user_id', $userdata['id']);
            }
            $this->db->order_by('pct_hr_time_cards.id', 'desc');

			if ((isset($limit) && !empty($limit)) || (isset($offset) && !empty($offset))) {
                
                $this->db->limit($limit, $offset);
            }

			$query = $this->db->get();
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
        $userdata = $this->session->userdata('hr_user');
        $usersIds = array();
        if(!empty($this->session->userdata('hr_user'))) {
            if ($userdata['user_type_id'] == 2) {
                $usersForBranchManager = $this->getUsersForBranchManager($userdata['id']);
                if(!empty($usersForBranchManager)) {
                    $usersIds = explode(",", $usersForBranchManager['ids']);
                    $usersIds[] = $userdata['id'];
                } else {
                    $usersIds[] = $userdata['id'];
                }
            } 
        }

        $this->db->from('pct_hr_vacation_requests')
            ->join('pct_hr_users', 'pct_hr_users.id = pct_hr_vacation_requests.user_id')
            ->join('pct_hr_users as branch_manager', 'branch_manager.id = pct_hr_vacation_requests.approved_by_user_id', 'left')
            ->join('admin', 'admin.id = pct_hr_vacation_requests.approved_by_admin_user_id', 'left');

        if(!empty($usersIds)) {
            $this->db->where_in('pct_hr_vacation_requests.user_id', $usersIds);
        } else {
            $this->db->where_in('pct_hr_vacation_requests.user_id', $userdata['id']);
        }
    
        $total_records =  $this->db->count_all_results();
		$limit = isset($params['length']) && !empty($params['length']) ? $params['length'] : '';
        $offset = isset($params['start']) && !empty($params['start']) ? $params['start'] : '';
        $vacationRequestsList = array();

    	if (isset($params['searchvalue']) && !empty($params['searchvalue'])) {
    		$keyword = $params['searchvalue'];

    		if (isset($keyword) && !empty($keyword)) {
                $this->db->group_start()
                        ->like('pct_hr_users.first_name', $keyword)
                        ->or_like('pct_hr_users.last_name', $keyword)
                        ->or_like('pct_hr_vacation_requests.comment', $keyword)
                        ->or_like('pct_hr_vacation_requests.from_date', date("Y-m-d", strtotime($keyword)))
                        ->or_like('pct_hr_vacation_requests.to_date', date("Y-m-d", strtotime($keyword)))
                        ->or_like('pct_hr_vacation_requests.is_salary_deduction', strtolower($keyword) == 'yes' ? 1 : 0)
                        ->or_like('pct_hr_vacation_requests.is_time_charged_vacation', strtolower($keyword) == 'yes' ? 1 : 0)
                        ->or_like('branch_manager.first_name', $keyword)
                        ->or_like('branch_manager.last_name', $keyword)
                        ->or_like('admin.user_name', $keyword)
                        ->group_end();
            }
            
            $this->db->from('pct_hr_vacation_requests')
                ->join('pct_hr_users', 'pct_hr_users.id = pct_hr_vacation_requests.user_id')
                ->join('pct_hr_users as branch_manager', 'branch_manager.id = pct_hr_vacation_requests.approved_by_user_id', 'left')
                ->join('admin', 'admin.id = pct_hr_vacation_requests.approved_by_admin_user_id', 'left');

            if(!empty($usersIds)) {
                $this->db->where_in('pct_hr_vacation_requests.user_id', $usersIds);
            } else {
                $this->db->where_in('pct_hr_vacation_requests.user_id', $userdata['id']);
            }

			$filter_total_records =  $this->db->count_all_results();

			if (isset($keyword) && !empty($keyword)) {
                $this->db->group_start()
                        ->like('pct_hr_users.first_name', $keyword)
                        ->or_like('pct_hr_users.last_name', $keyword)
                        ->or_like('pct_hr_vacation_requests.comment', $keyword)
                        ->or_like('pct_hr_vacation_requests.from_date', date("Y-m-d", strtotime($keyword)))
                        ->or_like('pct_hr_vacation_requests.to_date', date("Y-m-d", strtotime($keyword)))
                        ->or_like('pct_hr_vacation_requests.is_salary_deduction', strtolower($keyword) == 'yes' ? 1 : 0)
                        ->or_like('pct_hr_vacation_requests.is_time_charged_vacation', strtolower($keyword) == 'yes' ? 1 : 0)
                        ->or_like('branch_manager.first_name', $keyword)
                        ->or_like('branch_manager.last_name', $keyword)
                        ->or_like('admin.user_name', $keyword)
                        ->group_end();
            }

            $this->db->select('pct_hr_vacation_requests.*, pct_hr_users.first_name,  pct_hr_users.last_name, admin.user_name, branch_manager.first_name as branch_manager_first_name, branch_manager.last_name as branch_manager_last_name');
            $this->db->from('pct_hr_vacation_requests')
                ->join('pct_hr_users', 'pct_hr_users.id = pct_hr_vacation_requests.user_id')
                ->join('pct_hr_users as branch_manager', 'branch_manager.id = pct_hr_vacation_requests.approved_by_user_id', 'left')
                ->join('admin', 'admin.id = pct_hr_vacation_requests.approved_by_admin_user_id', 'left');

            if (!empty($usersIds)) {
                $this->db->where_in('pct_hr_vacation_requests.user_id', $usersIds);
            } else {
                $this->db->where_in('pct_hr_vacation_requests.user_id', $userdata['id']);
            }

            $this->db->order_by('pct_hr_vacation_requests.id', 'desc');

            if ((isset($limit) && !empty($limit)) || (isset($offset) && !empty($offset))) {
                $this->db->limit($limit, $offset);
            }	

			$query = $this->db->get();
           
			if ($query->num_rows() > 0) {
	            $vacationRequestsList = $query->result_array();
	        }
    	} else {    		
    		$this->db->from('pct_hr_vacation_requests')
                ->join('pct_hr_users', 'pct_hr_users.id = pct_hr_vacation_requests.user_id')
                ->join('pct_hr_users as branch_manager', 'branch_manager.id = pct_hr_vacation_requests.approved_by_user_id', 'left')
                ->join('admin', 'admin.id = pct_hr_vacation_requests.approved_by_admin_user_id', 'left');

            if (!empty($usersIds)) {
                $this->db->where_in('pct_hr_vacation_requests.user_id', $usersIds);
            } else {
                $this->db->where_in('pct_hr_vacation_requests.user_id', $userdata['id']);
            }
            $filter_total_records =  $this->db->count_all_results();

            $this->db->select('pct_hr_vacation_requests.*, pct_hr_users.first_name,  pct_hr_users.last_name, admin.user_name, branch_manager.first_name as branch_manager_first_name, branch_manager.last_name as branch_manager_last_name');
            $this->db->from('pct_hr_vacation_requests')
                ->join('pct_hr_users', 'pct_hr_users.id = pct_hr_vacation_requests.user_id')
                ->join('pct_hr_users as branch_manager', 'branch_manager.id = pct_hr_vacation_requests.approved_by_user_id', 'left')
                ->join('admin', 'admin.id = pct_hr_vacation_requests.approved_by_admin_user_id', 'left');

            if (!empty($usersIds)) {
                $this->db->where_in('pct_hr_vacation_requests.user_id', $usersIds);
            } else {
                $this->db->where_in('pct_hr_vacation_requests.user_id', $userdata['id']);
            }
            $this->db->order_by('pct_hr_vacation_requests.id', 'desc');

			if ((isset($limit) && !empty($limit)) || (isset($offset) && !empty($offset))) {
                
                $this->db->limit($limit, $offset);
            }

			$query = $this->db->get();
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

    public function getIncidentReports($params)
    { 
        $userdata = $this->session->userdata('hr_user');
        $usersIds = array();
        if(!empty($this->session->userdata('hr_user'))) {
            if ($userdata['user_type_id'] == 2) {
                $usersForBranchManager = $this->getUsersForBranchManager($userdata['id']);
                if(!empty($usersForBranchManager)) {
                    $usersIds = explode(",", $usersForBranchManager['ids']);
                    $usersIds[] = $userdata['id'];
                } else {
                    $usersIds[] = $userdata['id'];
                }
            } 
        }

        $this->db->from('pct_hr_incident_reports')
            ->join('pct_hr_users', 'pct_hr_users.id = pct_hr_incident_reports.user_id')
            ->join('pct_hr_users as branch_manager', 'branch_manager.id = pct_hr_incident_reports.approved_by_user_id', 'left')
            ->join('admin', 'admin.id = pct_hr_incident_reports.approved_by_admin_user_id', 'left');

        if(!empty($usersIds)) {
            $this->db->where_in('pct_hr_incident_reports.user_id', $usersIds);
        } else {
            $this->db->where_in('pct_hr_incident_reports.user_id', $userdata['id']);
        }

        $total_records =  $this->db->count_all_results();
		$limit = isset($params['length']) && !empty($params['length']) ? $params['length'] : '';
        $offset = isset($params['start']) && !empty($params['start']) ? $params['start'] : '';
        $incidentReportsList = array();

    	if (isset($params['searchvalue']) && !empty($params['searchvalue'])) {
    		$keyword = $params['searchvalue'];

    		if (isset($keyword) && !empty($keyword)) {
                $this->db->group_start()
                        ->like('pct_hr_users.first_name', $keyword)
                        ->or_like('pct_hr_users.last_name', $keyword)
                        ->or_like('pct_hr_incident_reports.employee_number', $keyword)
                        ->or_like('pct_hr_incident_reports.incident_date', date("Y-m-d", strtotime($keyword)))
                        ->or_like('pct_hr_incident_reports.incident_reason', $keyword)
                        ->or_like('pct_hr_incident_reports.actions', $keyword)
                        ->or_like('pct_hr_incident_reports.num_of_incidents', $keyword)
                        ->or_like('branch_manager.first_name', $keyword)
                        ->or_like('branch_manager.last_name', $keyword)
                        ->or_like('admin.user_name', $keyword)
                        ->group_end();
            }
            
            $this->db->from('pct_hr_incident_reports')
                ->join('pct_hr_users', 'pct_hr_users.id = pct_hr_incident_reports.user_id')
                ->join('pct_hr_users as branch_manager', 'branch_manager.id = pct_hr_incident_reports.approved_by_user_id', 'left')
                ->join('admin', 'admin.id = pct_hr_incident_reports.approved_by_admin_user_id', 'left');

            if(!empty($usersIds)) {
                $this->db->where_in('pct_hr_incident_reports.user_id', $usersIds);
            } else {
                $this->db->where_in('pct_hr_incident_reports.user_id', $userdata['id']);
            }
			$filter_total_records =  $this->db->count_all_results();

			if (isset($keyword) && !empty($keyword)) {
                $this->db->group_start()
                    ->like('pct_hr_users.first_name', $keyword)
                    ->or_like('pct_hr_users.last_name', $keyword)
                    ->or_like('pct_hr_incident_reports.employee_number', $keyword)
                    ->or_like('pct_hr_incident_reports.incident_date', date("Y-m-d", strtotime($keyword)))
                    ->or_like('pct_hr_incident_reports.incident_reason', $keyword)
                    ->or_like('pct_hr_incident_reports.actions', $keyword)
                    ->or_like('pct_hr_incident_reports.num_of_incidents', $keyword)
                    ->or_like('branch_manager.first_name', $keyword)
                    ->or_like('branch_manager.last_name', $keyword)
                    ->or_like('admin.user_name', $keyword)
                    ->group_end();
            }

            $this->db->select('pct_hr_incident_reports.*, pct_hr_users.first_name,  pct_hr_users.last_name, admin.user_name, branch_manager.first_name as branch_manager_first_name, branch_manager.last_name as branch_manager_last_name');
            $this->db->from('pct_hr_incident_reports')
                ->join('pct_hr_users', 'pct_hr_users.id = pct_hr_incident_reports.user_id')
                ->join('pct_hr_users as branch_manager', 'branch_manager.id = pct_hr_incident_reports.approved_by_user_id', 'left')
                ->join('admin', 'admin.id = pct_hr_incident_reports.approved_by_admin_user_id', 'left');

            if(!empty($usersIds)) {
                $this->db->where_in('pct_hr_incident_reports.user_id', $usersIds);
            } else {
                $this->db->where_in('pct_hr_incident_reports.user_id', $userdata['id']);
            }
            $this->db->order_by('pct_hr_incident_reports.id', 'desc');

            if ((isset($limit) && !empty($limit)) || (isset($offset) && !empty($offset))) {
                $this->db->limit($limit, $offset);
            }	

			$query = $this->db->get();
           
			if ($query->num_rows() > 0) {
	            $incidentReportsList = $query->result_array();
	        }
    	} else {    		
    		$this->db->from('pct_hr_incident_reports')
                ->join('pct_hr_users', 'pct_hr_users.id = pct_hr_incident_reports.user_id')
                ->join('pct_hr_users as branch_manager', 'branch_manager.id = pct_hr_incident_reports.approved_by_user_id', 'left')
                ->join('admin', 'admin.id = pct_hr_incident_reports.approved_by_admin_user_id', 'left');

            if(!empty($usersIds)) {
                $this->db->where_in('pct_hr_incident_reports.user_id', $usersIds);
            } else {
                $this->db->where_in('pct_hr_incident_reports.user_id', $userdata['id']);
            }
            $filter_total_records =  $this->db->count_all_results();

            $this->db->select('pct_hr_incident_reports.*, pct_hr_users.first_name,  pct_hr_users.last_name, admin.user_name, branch_manager.first_name as branch_manager_first_name, branch_manager.last_name as branch_manager_last_name');
            $this->db->from('pct_hr_incident_reports')
                ->join('pct_hr_users', 'pct_hr_users.id = pct_hr_incident_reports.user_id')
                ->join('pct_hr_users as branch_manager', 'branch_manager.id = pct_hr_incident_reports.approved_by_user_id', 'left')
                ->join('admin', 'admin.id = pct_hr_incident_reports.approved_by_admin_user_id', 'left');

            if(!empty($usersIds)) {
                $this->db->where_in('pct_hr_incident_reports.user_id', $usersIds);
            } else {
                $this->db->where_in('pct_hr_incident_reports.user_id', $userdata['id']);
            }
            $this->db->order_by('pct_hr_incident_reports.id', 'desc');

			if ((isset($limit) && !empty($limit)) || (isset($offset) && !empty($offset))) {
                
                $this->db->limit($limit, $offset);
            }

			$query = $this->db->get();
			if ($query->num_rows() > 0) {
	            $incidentReportsList = $query->result_array();
	        } 
    	}
        
    	return array(
            'recordsTotal' => $total_records,
            'recordsFiltered' => $filter_total_records,
            'data' => $incidentReportsList
        );
    }

    public function getUsersForBranchManager($user_id) 
    {
        $userdata = $this->session->userdata('hr_user');
        $userInfo = $this->get_hr_user(array('id' => $userdata['id']));
        $this->db->select('Group_concat(id) as ids')
            ->from('pct_hr_users');
        $this->db->where('department_id', $userInfo['department_id']);
        $query = $this->db->get();
        if ($query->num_rows() > 0)  {
            return $query->row_array();
        } else {
            return array();
        }
    }

    public function getUserInfo($user_id)
    {
        $this->db->select('pct_hr_users.*, pct_hr_position.name as position,  pct_hr_user_types.name, pct_hr_departments.name as department_name');
        $this->db->from('pct_hr_users')
                 ->join('pct_hr_position', 'pct_hr_position.id = pct_hr_users.position_id')
                 ->join('pct_hr_user_types', 'pct_hr_user_types.id = pct_hr_users.user_type_id')
                 ->join('pct_hr_departments', 'pct_hr_departments.id = pct_hr_users.department_id');
        $this->db->where('pct_hr_users.status', 1);
        $this->db->where('pct_hr_users.id', $user_id);
        $query = $this->db->get();
        $userInfo = $query->row_array();
        return $userInfo;
    }

    public function getMemos($params)
    {
        $userdata = $this->session->userdata('hr_user');
        $this->db->from('pct_hr_memos')
                 ->join('admin', 'admin.id = pct_hr_memos.created_by')
                 ->join('pct_hr_assigned_memo_users', 'pct_hr_assigned_memo_users.memo_id = pct_hr_memos.id');
        $this->db->where('pct_hr_memos.status', 1);
        $this->db->where('pct_hr_assigned_memo_users.user_id', $userdata['id']);
        
        $total_records =  $this->db->count_all_results();
		$limit = isset($params['length']) && !empty($params['length']) ? $params['length'] : '';
        $offset = isset($params['start']) && !empty($params['start']) ? $params['start'] : '';
        $memos = array();

    	if (isset($params['searchvalue']) && !empty($params['searchvalue'])) {
    		$keyword = $params['searchvalue'];

    		if (isset($keyword) && !empty($keyword)) {
                $this->db->group_start()
                        ->like('pct_hr_memos.subject', $keyword)
                        ->or_like('pct_hr_memos.created_at', date("Y-m-d", strtotime($keyword)))
                        ->or_like('admin.user_name', $keyword)
                        ->group_end();
            }
            
            $this->db->from('pct_hr_memos')
                    ->join('admin', 'admin.id = pct_hr_memos.created_by')
                    ->join('pct_hr_assigned_memo_users', 'pct_hr_assigned_memo_users.memo_id = pct_hr_memos.id');
            $this->db->where('pct_hr_memos.status', 1);
            $this->db->where('pct_hr_assigned_memo_users.user_id', $userdata['id']);
			$filter_total_records =  $this->db->count_all_results();

			if (isset($keyword) && !empty($keyword)) {
                $this->db->group_start()
                        ->like('pct_hr_memos.subject', $keyword)
                        ->or_like('pct_hr_memos.created_at', date("Y-m-d", strtotime($keyword)))
                        ->or_like('admin.user_name', $keyword)
                        ->group_end();
            }

            $this->db->select('pct_hr_memos.*, admin.user_name');
            $this->db->from('pct_hr_memos')
                    ->join('admin', 'admin.id = pct_hr_memos.created_by')
                    ->join('pct_hr_assigned_memo_users', 'pct_hr_assigned_memo_users.memo_id = pct_hr_memos.id');
            $this->db->where('pct_hr_memos.status', 1);
            $this->db->where('pct_hr_assigned_memo_users.user_id', $userdata['id']);
            $this->db->order_by('pct_hr_memos.id', 'desc');

            if ((isset($limit) && !empty($limit)) || (isset($offset) && !empty($offset))) {
                $this->db->limit($limit, $offset);
            }	

			$query = $this->db->get();
			if ($query->num_rows() > 0) {
	            $memos = $query->result_array();
	        }
    	} else {    		
            $this->db->from('pct_hr_memos')
                ->join('admin', 'admin.id = pct_hr_memos.created_by')
                ->join('pct_hr_assigned_memo_users', 'pct_hr_assigned_memo_users.memo_id = pct_hr_memos.id');
            $this->db->where('pct_hr_memos.status', 1);
            $this->db->where('pct_hr_assigned_memo_users.user_id', $userdata['id']);
            $filter_total_records =  $this->db->count_all_results();

            $this->db->select('pct_hr_memos.*, admin.user_name');
            $this->db->from('pct_hr_memos')
                ->join('admin', 'admin.id = pct_hr_memos.created_by')
                ->join('pct_hr_assigned_memo_users', 'pct_hr_assigned_memo_users.memo_id = pct_hr_memos.id');
            $this->db->where('pct_hr_memos.status', 1);
            $this->db->where('pct_hr_assigned_memo_users.user_id', $userdata['id']);
            $this->db->order_by('pct_hr_memos.id', 'desc');

			if ((isset($limit) && !empty($limit)) || (isset($offset) && !empty($offset))) {
                $this->db->limit($limit, $offset);
            }

			$query = $this->db->get();
			if ($query->num_rows() > 0) {
	            $memos = $query->result_array();
	        } 
    	}

    	return array(
            'recordsTotal' => $total_records,
            'recordsFiltered' => $filter_total_records,
            'data' => $memos
        );
    }

    public function getNotifications($params)
    {
        $userdata = $this->session->userdata('hr_user');
        $this->db->from('pct_hr_notifications');
        $this->db->where('pct_hr_notifications.sent_user_id', $userdata['id']);
        $total_records =  $this->db->count_all_results();
		$limit = isset($params['length']) && !empty($params['length']) ? $params['length'] : '';
        $offset = isset($params['start']) && !empty($params['start']) ? $params['start'] : '';
        $notifications = array();

    	if (isset($params['searchvalue']) && !empty($params['searchvalue'])) {
    		$keyword = $params['searchvalue'];

    		if (isset($keyword) && !empty($keyword)) {
                $this->db->group_start()
                        ->like('pct_hr_notifications.message', $keyword)
                        ->group_end();
            }
            
            $this->db->from('pct_hr_notifications');
            $this->db->where('pct_hr_notifications.sent_user_id', $userdata['id']);
			$filter_total_records =  $this->db->count_all_results();

			if (isset($keyword) && !empty($keyword)) {
                $this->db->group_start()
                        ->like('pct_hr_notifications.message', $keyword)
                        ->group_end();
            }

            $this->db->select('pct_hr_notifications.*');
            $this->db->from('pct_hr_notifications');
            $this->db->where('pct_hr_notifications.sent_user_id', $userdata['id']);
            $this->db->order_by('pct_hr_notifications.id', 'desc');

            if ((isset($limit) && !empty($limit)) || (isset($offset) && !empty($offset))) {
                $this->db->limit($limit, $offset);
            }	

			$query = $this->db->get();
			if ($query->num_rows() > 0) {
	            $notifications = $query->result_array();
	        }
    	} else {    		
    		$this->db->from('pct_hr_notifications');
            $this->db->where('pct_hr_notifications.sent_user_id', $userdata['id']);
            $filter_total_records =  $this->db->count_all_results();

            $this->db->select('pct_hr_notifications.*');
            $this->db->from('pct_hr_notifications');
            $this->db->where('pct_hr_notifications.sent_user_id', $userdata['id']);
            $this->db->order_by('pct_hr_notifications.id', 'desc');

			if ((isset($limit) && !empty($limit)) || (isset($offset) && !empty($offset))) {
                $this->db->limit($limit, $offset);
            }

			$query = $this->db->get();
			if ($query->num_rows() > 0) {
	            $notifications = $query->result_array();
	        } 
    	}

    	return array(
            'recordsTotal' => $total_records,
            'recordsFiltered' => $filter_total_records,
            'data' => $notifications
        );
    }
}
