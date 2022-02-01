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
        $this->db->where('is_super_hr_admin', 0);
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
            $this->db->where('is_super_hr_admin', 0);
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
            $this->db->where('is_super_hr_admin', 0);

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
            $this->db->where('is_super_hr_admin', 0);
            $this->db->from('admin');
            $filter_total_records =  $this->db->count_all_results();

            $this->db->where('status', 1);
            $this->db->where('is_hr_admin', 1);
            $this->db->where('is_super_hr_admin', 0);
            
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
                 ->join('pct_hr_user_types', 'pct_hr_user_types.id = pct_hr_users.user_type_id');
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
                        ->group_end();
            }
            
            $this->db->from('pct_hr_users')
                 ->join('pct_hr_position', 'pct_hr_position.id = pct_hr_users.position_id')
                 ->join('pct_hr_user_types', 'pct_hr_user_types.id = pct_hr_users.user_type_id');
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
                        ->group_end();
            }

            $this->db->select('pct_hr_users.*, pct_hr_position.name as position, pct_hr_user_types.name');
            $this->db->from('pct_hr_users')
                    ->join('pct_hr_position', 'pct_hr_position.id = pct_hr_users.position_id')
                    ->join('pct_hr_user_types', 'pct_hr_user_types.id = pct_hr_users.user_type_id');
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
                 ->join('pct_hr_user_types', 'pct_hr_user_types.id = pct_hr_users.user_type_id');
            $this->db->where('pct_hr_users.status', 1);
            $filter_total_records =  $this->db->count_all_results();

            $this->db->select('pct_hr_users.*, pct_hr_position.name as position,  pct_hr_user_types.name');
            $this->db->from('pct_hr_users')
                    ->join('pct_hr_position', 'pct_hr_position.id = pct_hr_users.position_id')
                    ->join('pct_hr_user_types', 'pct_hr_user_types.id = pct_hr_users.user_type_id');
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
        $query = $this->db->get('pct_hr_position');
        return $query->result_array();
    }

    public function getHrUserTypes() 
    {
        $this->db->select('*');
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
}
