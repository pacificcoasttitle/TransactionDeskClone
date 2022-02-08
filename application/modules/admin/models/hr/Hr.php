<?php
class Hr extends CI_Model 
{
	public function get_hr_admin_user($email, $password)
    {
        $this->db->select('*');
        $this->db->where('email_id', $email);
        $this->db->where('password', md5($password));
        $this->db->where('is_hr_admin', 1);
        $this->db->where('status', 1);
        $query = $this->db->get('admin');
        if ($query->num_rows() > 0)  {
            return $query->row_array();
        } else {
            return false;
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

    public function getAdminUsers($params)
    {
        $this->db->where('status', 1);
        $this->db->where('is_hr_admin', 1);
        $this->db->where('is_super_hr_admin', 1);
        $this->db->from('admin');
        $total_records =  $this->db->count_all_results();
        $limit = isset($params['length']) && !empty($params['length']) ? $params['length'] : '';
        $offset = isset($params['start']) && !empty($params['start']) ? $params['start'] : '';
        $adminUsersList =array();
        
        if (isset($params['searchvalue']) && !empty($params['searchvalue'])) {
            $keyword = $params['searchvalue'];

            if (isset($keyword) && !empty($keyword)) {
                $this->db->group_start()
                    ->like("user_name", $keyword)
                    ->or_like('email_id',$keyword)
                    ->group_end();
            }
            $this->db->where('status', 1);
            $this->db->where('is_hr_admin', 1);
            $this->db->where('is_super_hr_admin', 1);
            $this->db->from('admin');
            $filter_total_records =  $this->db->count_all_results();

            if (isset($keyword) && !empty($keyword)) {
                $this->db->group_start()
                    ->like("user_name", $keyword)
                    ->or_like('email_id',$keyword)
                    ->group_end();
            }

            $this->db->where('status', 1);
            $this->db->where('is_hr_admin', 1);
            $this->db->where('is_super_hr_admin', 1);

            if((isset($limit) && !empty($limit)) || (isset($offset) && !empty($offset))) {
                $this->db->limit($limit, $offset);
            }  
            $this->db->order_by('id', 'desc');
            $query = $this->db->get('admin');

            if ($query->num_rows() > 0) {
                $adminUsersList = $query->result_array();
            }
        } else {            
            $this->db->where('status', 1);
            $this->db->where('is_hr_admin', 1);
            $this->db->where('is_super_hr_admin', 1);
            $this->db->from('admin');
            $filter_total_records =  $this->db->count_all_results();

            $this->db->where('status', 1);
            $this->db->where('is_hr_admin', 1);
            $this->db->where('is_super_hr_admin', 1);
            
            if ((isset($limit) && !empty($limit)) || (isset($offset) && !empty($offset))) {
                $this->db->limit($limit, $offset);
            }
            $this->db->order_by('id', 'desc');
            $query = $this->db->get('admin');
            
            if ($query->num_rows() > 0) {
                $adminUsersList = $query->result_array();
            } 
        }
        return array(
            'recordsTotal' => $total_records,
            'recordsFiltered' => $filter_total_records,
            'data' => $adminUsersList
        );
    }

    public function getAdminUserInfo($id) 
    {
        $this->db->select('*');
        $this->db->where('id', $id);
        $this->db->where('status', 1);
        $query = $this->db->get('admin');
        if ($query->num_rows() > 0)  {
            return $query->row_array();
        } else {
            return array();
        }
    }

    public function getUsers($params)
    {
        $this->db->from('pct_hr_users')
                 ->join('pct_hr_position', 'pct_hr_position.id = pct_hr_users.position_id')
                 ->join('pct_hr_user_types', 'pct_hr_user_types.id = pct_hr_users.user_type_id')
                 ->join('pct_hr_departments', 'pct_hr_departments.id = pct_hr_users.department_id');
        $this->db->where('pct_hr_users.status', 1);
        $total_records =  $this->db->count_all_results();
		$limit = isset($params['length']) && !empty($params['length']) ? $params['length'] : '';
        $offset = isset($params['start']) && !empty($params['start']) ? $params['start'] : '';
        $users = array();

    	if (isset($params['searchvalue']) && !empty($params['searchvalue'])) {
    		$keyword = $params['searchvalue'];

    		if (isset($keyword) && !empty($keyword)) {
                $this->db->group_start()
                        ->like('pct_hr_users.first_name', $keyword)
                        ->or_like('pct_hr_users.last_name', $keyword)
                        ->or_like('pct_hr_users.email', $keyword)
                        ->or_like('pct_hr_users.hire_date', $keyword)
                        ->or_like('pct_hr_position.name', $keyword)
                        ->or_like('pct_hr_user_types.name', $keyword)
                        ->or_like('pct_hr_departments.name', $keyword)
                        ->group_end();
            }
            
            $this->db->from('pct_hr_users')
                 ->join('pct_hr_position', 'pct_hr_position.id = pct_hr_users.position_id')
                 ->join('pct_hr_user_types', 'pct_hr_user_types.id = pct_hr_users.user_type_id')
                 ->join('pct_hr_departments', 'pct_hr_departments.id = pct_hr_users.department_id');
            $this->db->where('pct_hr_users.status', 1);
			$filter_total_records =  $this->db->count_all_results();

			if (isset($keyword) && !empty($keyword)) {
                $this->db->group_start()
                        ->like('pct_hr_users.first_name', $keyword)
                        ->or_like('pct_hr_users.last_name', $keyword)
                        ->or_like('pct_hr_users.email', $keyword)
                        ->or_like('pct_hr_users.hire_date', $keyword)
                        ->or_like('pct_hr_position.name', $keyword)
                        ->or_like('pct_hr_user_types.name', $keyword)
                        ->or_like('pct_hr_departments.name', $keyword)
                        ->group_end();
            }

            $this->db->select('pct_hr_users.*, pct_hr_position.name as position, pct_hr_user_types.name, pct_hr_departments.name as department_name');
            $this->db->from('pct_hr_users')
                    ->join('pct_hr_position', 'pct_hr_position.id = pct_hr_users.position_id')
                    ->join('pct_hr_user_types', 'pct_hr_user_types.id = pct_hr_users.user_type_id')
                    ->join('pct_hr_departments', 'pct_hr_departments.id = pct_hr_users.department_id');
            $this->db->where('pct_hr_users.status', 1);
            $this->db->order_by('pct_hr_users.id', 'desc');

            if ((isset($limit) && !empty($limit)) || (isset($offset) && !empty($offset))) {
                $this->db->limit($limit, $offset);
            }	

			$query = $this->db->get();
			if ($query->num_rows() > 0) {
	            $users = $query->result_array();
	        }
    	} else {    		
    		$this->db->from('pct_hr_users')
                 ->join('pct_hr_position', 'pct_hr_position.id = pct_hr_users.position_id')
                 ->join('pct_hr_user_types', 'pct_hr_user_types.id = pct_hr_users.user_type_id')
                 ->join('pct_hr_departments', 'pct_hr_departments.id = pct_hr_users.department_id');
            $this->db->where('pct_hr_users.status', 1);
            $filter_total_records =  $this->db->count_all_results();

            $this->db->select('pct_hr_users.*, pct_hr_position.name as position,  pct_hr_user_types.name, pct_hr_departments.name as department_name');
            $this->db->from('pct_hr_users')
                    ->join('pct_hr_position', 'pct_hr_position.id = pct_hr_users.position_id')
                    ->join('pct_hr_user_types', 'pct_hr_user_types.id = pct_hr_users.user_type_id')
                    ->join('pct_hr_departments', 'pct_hr_departments.id = pct_hr_users.department_id');
            $this->db->where('pct_hr_users.status', 1);
            $this->db->order_by('pct_hr_users.id', 'desc');

			if ((isset($limit) && !empty($limit)) || (isset($offset) && !empty($offset))) {
                $this->db->limit($limit, $offset);
            }

			$query = $this->db->get();
			if ($query->num_rows() > 0) {
	            $users = $query->result_array();
	        } 
    	}

    	return array(
            'recordsTotal' => $total_records,
            'recordsFiltered' => $filter_total_records,
            'data' => $users
        );
    }

    public function getHrPositions() 
    {
        $this->db->select('*');
        $this->db->where('status', 1);
        $query = $this->db->get('pct_hr_position');
        return $query->result_array();
    }

    public function getHrDepartments() 
    {
        $this->db->select('*');
        $this->db->where('status', 1);
        $query = $this->db->get('pct_hr_departments');
        return $query->result_array();
    }

    public function getHrUserTypes() 
    {
        $this->db->select('*');
        $this->db->where('status', 1);
        $query = $this->db->get('pct_hr_user_types');
        return $query->result_array();
    }

    public function getUserInfo($id) 
    {
        $this->db->select('*');
        $this->db->where('id', $id);
        $this->db->where('status', 1);
        $query = $this->db->get('pct_hr_users');
        if ($query->num_rows() > 0)  {
            return $query->row_array();
        } else {
            return array();
        }
    }

    public function getBranchManagers() 
    {
        $this->db->select('*');
        $this->db->where('user_type_id', 2);
        $this->db->where('status', 1);
        $query = $this->db->get('pct_hr_users');
        if ($query->num_rows() > 0)  {
            return $query->result_array();
        } else {
            return array();
        }
    }

    public function getUserTypes($params)
    {
        $this->db->from('pct_hr_user_types');
        $this->db->where('pct_hr_user_types.status', 1);
        $total_records =  $this->db->count_all_results();
		$limit = isset($params['length']) && !empty($params['length']) ? $params['length'] : '';
        $offset = isset($params['start']) && !empty($params['start']) ? $params['start'] : '';
        $userTypes = array();

    	if (isset($params['searchvalue']) && !empty($params['searchvalue'])) {
    		$keyword = $params['searchvalue'];

    		if (isset($keyword) && !empty($keyword)) {
                $this->db->group_start()
                        ->like('pct_hr_user_types.name', $keyword)
                        ->group_end();
            }
            
            $this->db->from('pct_hr_user_types');
            $this->db->where('pct_hr_user_types.status', 1);
			$filter_total_records =  $this->db->count_all_results();

			if (isset($keyword) && !empty($keyword)) {
                $this->db->group_start()
                        ->like('pct_hr_user_types.name', $keyword)
                        ->group_end();
            }

            $this->db->select('pct_hr_user_types.*');
            $this->db->from('pct_hr_user_types');
            $this->db->where('pct_hr_user_types.status', 1);
            $this->db->order_by('pct_hr_user_types.id', 'asc');

            if ((isset($limit) && !empty($limit)) || (isset($offset) && !empty($offset))) {
                $this->db->limit($limit, $offset);
            }	

			$query = $this->db->get();
			if ($query->num_rows() > 0) {
	            $userTypes = $query->result_array();
	        }
    	} else {    		
    		$this->db->from('pct_hr_user_types');
            $this->db->where('pct_hr_user_types.status', 1);
            $filter_total_records =  $this->db->count_all_results();

            $this->db->select('pct_hr_user_types.*');
            $this->db->from('pct_hr_user_types');
            $this->db->where('pct_hr_user_types.status', 1);
            $this->db->order_by('pct_hr_user_types.id', 'asc');

			if ((isset($limit) && !empty($limit)) || (isset($offset) && !empty($offset))) {
                $this->db->limit($limit, $offset);
            }

			$query = $this->db->get();
			if ($query->num_rows() > 0) {
	            $userTypes = $query->result_array();
	        } 
    	}

    	return array(
            'recordsTotal' => $total_records,
            'recordsFiltered' => $filter_total_records,
            'data' => $userTypes
        );
    }

    public function getDepartments($params)
    {
        $this->db->from('pct_hr_departments');
        $this->db->where('pct_hr_departments.status', 1);
        $total_records =  $this->db->count_all_results();
		$limit = isset($params['length']) && !empty($params['length']) ? $params['length'] : '';
        $offset = isset($params['start']) && !empty($params['start']) ? $params['start'] : '';
        $departments = array();

    	if (isset($params['searchvalue']) && !empty($params['searchvalue'])) {
    		$keyword = $params['searchvalue'];

    		if (isset($keyword) && !empty($keyword)) {
                $this->db->group_start()
                        ->like('pct_hr_departments.name', $keyword)
                        ->group_end();
            }
            
            $this->db->from('pct_hr_departments');
            $this->db->where('pct_hr_departments.status', 1);
			$filter_total_records =  $this->db->count_all_results();

			if (isset($keyword) && !empty($keyword)) {
                $this->db->group_start()
                        ->like('pct_hr_departments.name', $keyword)
                        ->group_end();
            }

            $this->db->select('pct_hr_departments.*');
            $this->db->from('pct_hr_departments');
            $this->db->where('pct_hr_departments.status', 1);
            $this->db->order_by('pct_hr_departments.id', 'asc');

            if ((isset($limit) && !empty($limit)) || (isset($offset) && !empty($offset))) {
                $this->db->limit($limit, $offset);
            }	

			$query = $this->db->get();
			if ($query->num_rows() > 0) {
	            $departments = $query->result_array();
	        }
    	} else {    		
    		$this->db->from('pct_hr_departments');
            $this->db->where('pct_hr_departments.status', 1);
            $filter_total_records =  $this->db->count_all_results();

            $this->db->select('pct_hr_departments.*');
            $this->db->from('pct_hr_departments');
            $this->db->where('pct_hr_departments.status', 1);
            $this->db->order_by('pct_hr_departments.id', 'asc');

			if ((isset($limit) && !empty($limit)) || (isset($offset) && !empty($offset))) {
                $this->db->limit($limit, $offset);
            }

			$query = $this->db->get();
			if ($query->num_rows() > 0) {
	            $departments = $query->result_array();
	        } 
    	}

    	return array(
            'recordsTotal' => $total_records,
            'recordsFiltered' => $filter_total_records,
            'data' => $departments
        );
    }

    public function getUserTypeInfo($id) 
    {
        $this->db->select('*');
        $this->db->where('id', $id);
        $this->db->where('status', 1);
        $query = $this->db->get('pct_hr_user_types');
        if ($query->num_rows() > 0)  {
            return $query->row_array();
        } else {
            return array();
        }
    }

    public function getDepartmentInfo($id) 
    {
        $this->db->select('*');
        $this->db->where('id', $id);
        $this->db->where('status', 1);
        $query = $this->db->get('pct_hr_departments');
        if ($query->num_rows() > 0)  {
            return $query->row_array();
        } else {
            return array();
        }
    }

    public function getPositions($params)
    {
        $this->db->from('pct_hr_position');
        $this->db->where('pct_hr_position.status', 1);
        $total_records =  $this->db->count_all_results();
		$limit = isset($params['length']) && !empty($params['length']) ? $params['length'] : '';
        $offset = isset($params['start']) && !empty($params['start']) ? $params['start'] : '';
        $positions = array();

    	if (isset($params['searchvalue']) && !empty($params['searchvalue'])) {
    		$keyword = $params['searchvalue'];

    		if (isset($keyword) && !empty($keyword)) {
                $this->db->group_start()
                        ->like('pct_hr_position.name', $keyword)
                        ->group_end();
            }
            
            $this->db->from('pct_hr_position');
            $this->db->where('pct_hr_position.status', 1);
			$filter_total_records =  $this->db->count_all_results();

			if (isset($keyword) && !empty($keyword)) {
                $this->db->group_start()
                        ->like('pct_hr_position.name', $keyword)
                        ->group_end();
            }

            $this->db->select('pct_hr_position.*');
            $this->db->from('pct_hr_position');
            $this->db->where('pct_hr_position.status', 1);
            $this->db->order_by('pct_hr_position.id', 'asc');

            if ((isset($limit) && !empty($limit)) || (isset($offset) && !empty($offset))) {
                $this->db->limit($limit, $offset);
            }	

			$query = $this->db->get();
			if ($query->num_rows() > 0) {
	            $positions = $query->result_array();
	        }
    	} else {    		
    		$this->db->from('pct_hr_position');
            $this->db->where('pct_hr_position.status', 1);
            $filter_total_records =  $this->db->count_all_results();

            $this->db->select('pct_hr_position.*');
            $this->db->from('pct_hr_position');
            $this->db->where('pct_hr_position.status', 1);
            $this->db->order_by('pct_hr_position.id', 'asc');

			if ((isset($limit) && !empty($limit)) || (isset($offset) && !empty($offset))) {
                $this->db->limit($limit, $offset);
            }

			$query = $this->db->get();
			if ($query->num_rows() > 0) {
	            $positions = $query->result_array();
	        } 
    	}

    	return array(
            'recordsTotal' => $total_records,
            'recordsFiltered' => $filter_total_records,
            'data' => $positions
        );
    }

    public function getPositionInfo($id) 
    {
        $this->db->select('*');
        $this->db->where('id', $id);
        $this->db->where('status', 1);
        $query = $this->db->get('pct_hr_position');
        if ($query->num_rows() > 0)  {
            return $query->row_array();
        } else {
            return array();
        }
    }

    public function getTimeCards($params)
    { 
        $this->db->from('pct_hr_time_cards')
                 ->join('pct_hr_users', 'pct_hr_users.id = pct_hr_time_cards.user_id')
                 ->join('pct_hr_users as branch_manager', 'branch_manager.id = pct_hr_time_cards.approved_by_user_id', 'left')
                 ->join('admin', 'admin.id = pct_hr_time_cards.approved_by_admin_user_id', 'left');

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
                        ->group_end();
            }

            $this->db->select('pct_hr_time_cards.*, pct_hr_users.first_name,  pct_hr_users.last_name, admin.user_name, branch_manager.first_name as branch_manager_first_name, branch_manager.last_name as branch_manager_last_name');
            $this->db->from('pct_hr_time_cards')
                ->join('pct_hr_users', 'pct_hr_users.id = pct_hr_time_cards.user_id')
                ->join('pct_hr_users as branch_manager', 'branch_manager.id = pct_hr_time_cards.approved_by_user_id', 'left')
                ->join('admin', 'admin.id = pct_hr_time_cards.approved_by_admin_user_id', 'left');


            
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


            
            $filter_total_records =  $this->db->count_all_results();

            $this->db->select('pct_hr_time_cards.*, pct_hr_users.first_name,  pct_hr_users.last_name, admin.user_name, branch_manager.first_name as branch_manager_first_name, branch_manager.last_name as branch_manager_last_name');
            $this->db->from('pct_hr_time_cards')
                ->join('pct_hr_users', 'pct_hr_users.id = pct_hr_time_cards.user_id')
                ->join('pct_hr_users as branch_manager', 'branch_manager.id = pct_hr_time_cards.approved_by_user_id', 'left')
                ->join('admin', 'admin.id = pct_hr_time_cards.approved_by_admin_user_id', 'left');


            
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
        $this->db->from('pct_hr_vacation_requests')
            ->join('pct_hr_users', 'pct_hr_users.id = pct_hr_vacation_requests.user_id')
            ->join('pct_hr_users as branch_manager', 'branch_manager.id = pct_hr_vacation_requests.approved_by_user_id', 'left')
            ->join('admin', 'admin.id = pct_hr_vacation_requests.approved_by_admin_user_id', 'left');

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

            $filter_total_records =  $this->db->count_all_results();

            $this->db->select('pct_hr_vacation_requests.*, pct_hr_users.first_name,  pct_hr_users.last_name, admin.user_name, branch_manager.first_name as branch_manager_first_name, branch_manager.last_name as branch_manager_last_name');
            $this->db->from('pct_hr_vacation_requests')
                ->join('pct_hr_users', 'pct_hr_users.id = pct_hr_vacation_requests.user_id')
                ->join('pct_hr_users as branch_manager', 'branch_manager.id = pct_hr_vacation_requests.approved_by_user_id', 'left')
                ->join('admin', 'admin.id = pct_hr_vacation_requests.approved_by_admin_user_id', 'left');

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
        $this->db->from('pct_hr_incident_reports')
            ->join('pct_hr_users', 'pct_hr_users.id = pct_hr_incident_reports.user_id')
            ->join('pct_hr_users as branch_manager', 'branch_manager.id = pct_hr_incident_reports.approved_by_user_id', 'left')
            ->join('admin', 'admin.id = pct_hr_incident_reports.approved_by_admin_user_id', 'left');

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

            $filter_total_records =  $this->db->count_all_results();

            $this->db->select('pct_hr_incident_reports.*, pct_hr_users.first_name,  pct_hr_users.last_name, admin.user_name, branch_manager.first_name as branch_manager_first_name, branch_manager.last_name as branch_manager_last_name');
            $this->db->from('pct_hr_incident_reports')
                ->join('pct_hr_users', 'pct_hr_users.id = pct_hr_incident_reports.user_id')
                ->join('pct_hr_users as branch_manager', 'branch_manager.id = pct_hr_incident_reports.approved_by_user_id', 'left')
                ->join('admin', 'admin.id = pct_hr_incident_reports.approved_by_admin_user_id', 'left');

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

    public function getMemos($params)
    {
        $this->db->from('pct_hr_memos')
                 ->join('admin', 'admin.id = pct_hr_memos.created_by');
        $this->db->where('pct_hr_memos.status', 1);
        $total_records =  $this->db->count_all_results();
		$limit = isset($params['length']) && !empty($params['length']) ? $params['length'] : '';
        $offset = isset($params['start']) && !empty($params['start']) ? $params['start'] : '';
        $memos = array();

    	if (isset($params['searchvalue']) && !empty($params['searchvalue'])) {
    		$keyword = $params['searchvalue'];

    		if (isset($keyword) && !empty($keyword)) {
                $this->db->group_start()
                        ->like('pct_hr_memos.subject', $keyword)
                        ->or_like('pct_hr_memos.date', date("Y-m-d", strtotime($keyword)))
                        ->or_like('pct_hr_memos.description', $keyword)
                        ->or_like('admin.user_name', $keyword)
                        ->group_end();
            }
            
            $this->db->from('pct_hr_memos')
                ->join('admin', 'admin.id = pct_hr_memos.created_by');
            $this->db->where('pct_hr_memos.status', 1);
			$filter_total_records =  $this->db->count_all_results();

			if (isset($keyword) && !empty($keyword)) {
                $this->db->group_start()
                        ->like('pct_hr_memos.subject', $keyword)
                        ->or_like('pct_hr_memos.date', date("Y-m-d", strtotime($keyword)))
                        ->or_like('pct_hr_memos.description', $keyword)
                        ->or_like('admin.user_name', $keyword)
                        ->group_end();
            }

            $this->db->select('pct_hr_memos.*, admin.user_name');
            $this->db->from('pct_hr_memos')
                    ->join('admin', 'admin.id = pct_hr_memos.created_by');
            $this->db->where('pct_hr_memos.status', 1);
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
                    ->join('admin', 'admin.id = pct_hr_memos.created_by');
            $this->db->where('pct_hr_memos.status', 1);
            $filter_total_records =  $this->db->count_all_results();

            $this->db->select('pct_hr_memos.*, admin.user_name');
            $this->db->from('pct_hr_memos')
                    ->join('admin', 'admin.id = pct_hr_memos.created_by');
            $this->db->where('pct_hr_memos.status', 1);
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

    public function getMemoInfo($id) 
    {
        $this->db->select('*');
        $this->db->where('id', $id);
        $this->db->where('status', 1);
        $query = $this->db->get('pct_hr_memos');
        if ($query->num_rows() > 0)  {
            return $query->row_array();
        } else {
            return array();
        }
    }
}
