<?php
class Home_model extends CI_Model 
{

	function __construct() {
        // Set table name
        $this->table = 'customer_basic_details';
    }
	public function get_admin_user($email, $password)
    {
        $this->db->select('*');
        $this->db->where('email_id', $email);
        // $this->db->where('password', md5($password));
        $this->db->where('status', 1);
        $query = $this->db->get('admin');

        if ($query->num_rows() > 0) 
        {
			$admin_record = $query->row_array();
			//Check password
			$hashed_pasasword = $admin_record['password'];
			if (password_verify($password, $hashed_pasasword)) {
				return $query->row_array();
			} else {
				return false;
			}
        } 
        else 
        {
			return false;
        }
    }

    public function get_user($params = array()) 
    {
        $table = $this->table;
        $this->db->select('*');
        $this->db->from($table);
        foreach($params as $key => $val){
            $this->db->where($key, $val);
        }
        $query = $this->db->get();
        $result = $query->row_array();
        if(!empty($result)) { 
            return $result;
        } else {
            return array();
        }
        
    }

    public function get_customers($params)
    {
        $is_escrow = isset($params['is_escrow']) && !empty($params['is_escrow']) ? $params['is_escrow'] : 0;

        $this->db->where('is_escrow', $is_escrow);
    	$this->db->where('status', 1);
    	$this->db->from('customer_basic_details');
		$total_records =  $this->db->count_all_results();


		$limit = isset($params['length']) && !empty($params['length']) ? $params['length'] : '';
        $offset = isset($params['start']) && !empty($params['start']) ? $params['start'] : '';
    	
        
        $customer_lists =array();
    	if(isset($params['searchvalue']) && !empty($params['searchvalue']))
    	{
    		$keyword = $params['searchvalue'];

    		if(isset($keyword) && !empty($keyword))
			{
                $this->db->group_start()
                    ->like('first_name', $keyword)
                    ->or_like('last_name', $keyword)
                    ->or_like('email_address', $keyword)
                    ->group_end();
			}

            $this->db->where('status', 1);
			$this->db->where('is_escrow', $is_escrow);
	    	$this->db->from('customer_basic_details');
			$filter_total_records =  $this->db->count_all_results();


			if(isset($keyword) && !empty($keyword))
			{
                $this->db->group_start()
                    ->like('first_name', $keyword)
                    ->or_like('last_name', $keyword)
                    ->or_like('email_address', $keyword)
                    ->group_end();
			}

			$this->db->where('status', 1);
            $this->db->where('is_escrow', $is_escrow);

            if((isset($limit) && !empty($limit)) || (isset($offset) && !empty($offset)))
            {
                $this->db->limit($limit, $offset);
            }			
			$query = $this->db->get('customer_basic_details');

			if ($query->num_rows() > 0) 
	        {
	            $customer_lists = $query->result_array();
	        }
    	}
    	else
    	{    		

    		$this->db->where('status', 1);
            $this->db->where('is_escrow', $is_escrow);
	    	$this->db->from('customer_basic_details');

            $filter_total_records =  $this->db->count_all_results();

            $this->db->where('is_escrow', $is_escrow);
			$this->db->where('status', 1);
			if((isset($limit) && !empty($limit)) || (isset($offset) && !empty($offset)))
            {
                $this->db->limit($limit, $offset);
            }
			$query = $this->db->get('customer_basic_details');
			
			if ($query->num_rows() > 0) 
	        {
	            $customer_lists = $query->result_array();
	        } 
    	}

    	return array(
            'recordsTotal' => $total_records,
            'recordsFiltered' => $filter_total_records,
            'data' => $customer_lists
        );
    }

    public function get_rows($params = array(), $table = '')
    {
    	if (empty($table)) {
            $table = $this->table;
        }

        $this->db->select('*');
        $this->db->from($table);
        
        if(array_key_exists("where", $params)){
            foreach($params['where'] as $key => $val){
                $this->db->where($key, $val);
            }
        }
        
        if(array_key_exists("returnType",$params) && $params['returnType'] == 'count'){
            $result = $this->db->count_all_results();
        }else{
            if(array_key_exists("id", $params)){
                $this->db->where('id', $params['id']);
                $query = $this->db->get();
                $result = $query->row_array();
            }else{
                $this->db->order_by('id', 'asc');
                if(array_key_exists("start",$params) && array_key_exists("limit",$params)){
                    $this->db->limit($params['limit'],$params['start']);
                }elseif(!array_key_exists("start",$params) && array_key_exists("limit",$params)){
                    $this->db->limit($params['limit']);
                }
                
                $query = $this->db->get();
                $result = ($query->num_rows() > 0)?$query->result_array():FALSE;
            }
        }
        
        // Return fetched data
        return $result;
    }

    public function get_customer_number()
    {
    	$query = $this->db->query("SELECT random_num
                        FROM (
                          SELECT FLOOR(1000 + ( RAND( ) *8999 )) AS random_num 
                          UNION
                          SELECT FLOOR(1000 + ( RAND( ) *8999 )) AS random_num
                        ) AS customer_basic_details_plus_1
                        WHERE `random_num` NOT IN (SELECT customer_number FROM customer_basic_details)
                        LIMIT 1");

    	if ($query->num_rows() > 0)
    	{
    		return $query->row_array();
    	}
    	else 
        {
            return false;
        }
    }


    public function update($data, $condition = array(), $table = '') 
    {
        if (empty($table)) {
            $table = $this->table;
        }
    	
        if(!empty($data))
        {          
            
            $data['updated_at'] = date("Y-m-d H:i:s");

            // Update data
            $update = $this->db->update($table, $data, $condition);
            
            // Return the status
            return $update?true:false;
        }
        return false;
    }

    public function insert($data = array(), $table = '') 
    {
        if (empty($table)) {
            $table = $this->table;
        }
        if(!empty($data)){

        	$data['created_at'] = date("Y-m-d H:i:s");

            // Insert data
            $insert = $this->db->insert($table, $data);
            
            // Return the status
            return $insert?$this->db->insert_id():false;
        }
        return false;
    }

    public function get_user_with_duplicate_email($params)
    {
        $where = ' where email_address != ""';
        if (isset($params['keyword']) && !empty($params['keyword'])) 
        {
            $keyword = $params['keyword'];

            /*$where = ' WHERE first_name LIKE "%'.$keyword.'%"';
            $where .= ' OR last_name LIKE "%'.$keyword.'%"';*/
            $where .= ' AND email_address LIKE "%'.$keyword.'%"';
        }
        $query = $this->db->query('SELECT * FROM customer_basic_details WHERE email_address IN (
        SELECT email_address FROM customer_basic_details'.$where.'
        GROUP BY email_address HAVING COUNT(*) > 1 
        ) ORDER BY email_address ASC, is_password_updated DESC');

        $result = ($query->num_rows() > 0)?$query->result_array():FALSE;

        return $result;
    }

    public function get_cpl_document_list($params)
    {
        $this->db->from('order_details')
                 ->join('pct_order_documents', 'order_details.id = pct_order_documents.order_id');
        $this->db->where('pct_order_documents.is_cpl_doc', 1);
        $total_records =  $this->db->count_all_results();
    
		$limit = isset($params['length']) && !empty($params['length']) ? $params['length'] : '';
        $offset = isset($params['start']) && !empty($params['start']) ? $params['start'] : '';
        $cpl_document_lists = array();

    	if (isset($params['searchvalue']) && !empty($params['searchvalue'])) {
    		$keyword = $params['searchvalue'];

    		if (isset($keyword) && !empty($keyword)) {
                $this->db->group_start()
                        ->like('order_details.file_number', $keyword)
                        ->or_like('pct_order_documents.document_name', $keyword)
                        ->group_end();
               
            }

            $this->db->from('order_details')
                ->join('pct_order_documents', 'order_details.id = pct_order_documents.order_id');
            $this->db->where('pct_order_documents.is_cpl_doc', 1);
			$filter_total_records =  $this->db->count_all_results();

			if(isset($keyword) && !empty($keyword)) {
                $this->db->group_start()
                        ->like('order_details.file_number', $keyword)
                        ->or_like('pct_order_documents.document_name', $keyword)
                        ->group_end();
			}

            $this->db->select('order_details.file_number, pct_order_documents.document_name, pct_order_documents.api_document_id, pct_order_documents.created');
            $this->db->from('order_details')
                ->join('pct_order_documents', 'order_details.id = pct_order_documents.order_id');
            $this->db->where('pct_order_documents.is_cpl_doc', 1);
            $this->db->order_by('pct_order_documents.id', 'desc');

            if ((isset($limit) && !empty($limit)) || (isset($offset) && !empty($offset))) {
                $this->db->limit($limit, $offset);
            }	
			$query = $this->db->get();
			if ($query->num_rows() > 0) {
	            $cpl_document_lists = $query->result_array();
	        }
    	} else {    		

    		$this->db->from('order_details')
                ->join('pct_order_documents', 'order_details.id = pct_order_documents.order_id');
            $this->db->where('pct_order_documents.is_cpl_doc', 1);
            $filter_total_records =  $this->db->count_all_results();

            $this->db->select('order_details.file_number, pct_order_documents.document_name, pct_order_documents.api_document_id, pct_order_documents.created');
            $this->db->from('order_details')
                ->join('pct_order_documents', 'order_details.id = pct_order_documents.order_id');
            $this->db->where('pct_order_documents.is_cpl_doc', 1);
            $this->db->order_by('pct_order_documents.id', 'desc');

			if ((isset($limit) && !empty($limit)) || (isset($offset) && !empty($offset))) {
                $this->db->limit($limit, $offset);
            }

			$query = $this->db->get();
			if ($query->num_rows() > 0) {
	            $cpl_document_lists = $query->result_array();
	        } 
    	}

    	return array(
            'recordsTotal' => $total_records,
            'recordsFiltered' => $filter_total_records,
            'data' => $cpl_document_lists
        );
    }

    public function get_new_users_list($params)
    {
        $this->db->where('is_new_user', 1);
        $this->db->where('is_password_updated', 0);
    	$this->db->where('status', 1);
    	$this->db->from('customer_basic_details');
		$total_records =  $this->db->count_all_results();
		$limit = isset($params['length']) && !empty($params['length']) ? $params['length'] : '';
        $offset = isset($params['start']) && !empty($params['start']) ? $params['start'] : '';
        $customer_lists =array();
        
        if (isset($params['searchvalue']) && !empty($params['searchvalue'])) {
    		$keyword = $params['searchvalue'];

    		if (isset($keyword) && !empty($keyword)) {
                $this->db->group_start()
                    ->like("first_name", $keyword)
                    ->or_like('last_name',$keyword)
                    ->or_like('email_address',$keyword)
                    ->or_like('company_name', $keyword)
                    ->or_like('password', $keyword)
                    ->or_like('random_password', $keyword)
                    ->group_end();
			}

            $this->db->where('status', 1);
            $this->db->where('is_password_updated', 0);
			$this->db->where('is_new_user', 1);
	    	$this->db->from('customer_basic_details');
			$filter_total_records =  $this->db->count_all_results();

			if (isset($keyword) && !empty($keyword)) {
                $this->db->group_start()
                    ->like("first_name", $keyword)
                    ->or_like('last_name',$keyword)
                    ->or_like('email_address',$keyword)
                    ->or_like('company_name', $keyword)
                    ->or_like('password', $keyword)
                    ->or_like('random_password', $keyword)
                    ->group_end();
			}
            $this->db->where('status', 1);
            $this->db->where('is_password_updated', 0);
            $this->db->where('is_new_user', 1);

            if((isset($limit) && !empty($limit)) || (isset($offset) && !empty($offset))) {
                $this->db->limit($limit, $offset);
            }			
			$query = $this->db->get('customer_basic_details');
			if ($query->num_rows() > 0) {
	            $customer_lists = $query->result_array();
	        }
    	} else {    		
            $this->db->where('status', 1);
            $this->db->where('is_password_updated', 0);
            $this->db->where('is_new_user', 1);
	    	$this->db->from('customer_basic_details');
            $filter_total_records =  $this->db->count_all_results();

            $this->db->where('is_new_user', 1);
            $this->db->where('is_password_updated', 0);
            $this->db->where('status', 1);
            
			if ((isset($limit) && !empty($limit)) || (isset($offset) && !empty($offset))) {
                $this->db->limit($limit, $offset);
            }
			$query = $this->db->get('customer_basic_details');
			
			if ($query->num_rows() > 0) {
	            $customer_lists = $query->result_array();
	        } 
    	}
    	return array(
            'recordsTotal' => $total_records,
            'recordsFiltered' => $filter_total_records,
            'data' => $customer_lists
        );
    }

    public function get_company_list($params)
    {
        $table = 'pct_order_partner_company_info';
        $this->db->select('*');
        $this->db->from($table);
        $this->db->order_by('id', 'asc');
        $this->db->select("CONCAT(partner_name, ' - ', CONCAT_WS(',', address1, city, state, zip)) AS value");
        $this->db->like('partner_name', $params['partner_name']); 
        $query = $this->db->get();
        $result = $query->result_array();
        return !empty($result) ? $result : FALSE;
    }

    public function get_title_company_list($params)
    {
        $table = 'pct_order_partner_company_info';
        $this->db->select('*');
        $this->db->from($table);
        $this->db->order_by('id', 'asc');
        $this->db->select("CONCAT(partner_name, ' - ', CONCAT_WS(',', address1, city, state, zip)) AS value");
        $this->db->like('partner_name', $params['partner_name']); 
        $this->db->like('partner_name', 'title'); 
        $query = $this->db->get();
        $result = $query->result_array();
        return !empty($result) ? $result : FALSE;
    }

    public function get_grant_deed_document_list($params)
    {
        $this->db->from('order_details')
                 ->join('pct_order_documents', 'order_details.id = pct_order_documents.order_id');
        $this->db->where('pct_order_documents.is_grant_doc', 1);
        $total_records =  $this->db->count_all_results();
    
		$limit = isset($params['length']) && !empty($params['length']) ? $params['length'] : '';
        $offset = isset($params['start']) && !empty($params['start']) ? $params['start'] : '';
        $grant_document_lists = array();

    	if (isset($params['searchvalue']) && !empty($params['searchvalue'])) {
    		$keyword = $params['searchvalue'];

    		if (isset($keyword) && !empty($keyword)) {
                $this->db->group_start()
                        ->like('order_details.file_number', $keyword)
                        ->or_like('pct_order_documents.document_name', $keyword)
                        ->group_end();
            }

            $this->db->from('order_details')
                ->join('pct_order_documents', 'order_details.id = pct_order_documents.order_id');
            $this->db->where('pct_order_documents.is_grant_doc', 1);
			$filter_total_records =  $this->db->count_all_results();

			if(isset($keyword) && !empty($keyword)) {
                $this->db->group_start()
                        ->like('order_details.file_number', $keyword)
                        ->or_like('pct_order_documents.document_name', $keyword)
                        ->group_end();
			}

            $this->db->select('order_details.lp_file_number, order_details.file_number, pct_order_documents.document_name, pct_order_documents.api_document_id, pct_order_documents.created');
            $this->db->from('order_details')
                ->join('pct_order_documents', 'order_details.id = pct_order_documents.order_id');
            $this->db->where('pct_order_documents.is_grant_doc', 1);
            $this->db->order_by('pct_order_documents.id', 'desc');

            if ((isset($limit) && !empty($limit)) || (isset($offset) && !empty($offset))) {
                $this->db->limit($limit, $offset);
            }	
			$query = $this->db->get();
			if ($query->num_rows() > 0) {
	            $grant_document_lists = $query->result_array();
	        }
    	} else {    		

    		$this->db->from('order_details')
                ->join('pct_order_documents', 'order_details.id = pct_order_documents.order_id');
            $this->db->where('pct_order_documents.is_grant_doc', 1);
            $filter_total_records =  $this->db->count_all_results();

            $this->db->select('order_details.lp_file_number, order_details.file_number, pct_order_documents.document_name, pct_order_documents.api_document_id, pct_order_documents.created');
            $this->db->from('order_details')
                ->join('pct_order_documents', 'order_details.id = pct_order_documents.order_id');
            $this->db->where('pct_order_documents.is_grant_doc', 1);
            $this->db->order_by('pct_order_documents.id', 'desc');

			if ((isset($limit) && !empty($limit)) || (isset($offset) && !empty($offset))) {
                $this->db->limit($limit, $offset);
            }

			$query = $this->db->get();
			if ($query->num_rows() > 0) {
	            $grant_document_lists = $query->result_array();
	        } 
    	}

    	return array(
            'recordsTotal' => $total_records,
            'recordsFiltered' => $filter_total_records,
            'data' => $grant_document_lists
        );
    }

    public function get_lv_document_list($params)
    {
        $this->db->from('order_details')
                 ->join('pct_order_documents', 'order_details.id = pct_order_documents.order_id');
        $this->db->where('pct_order_documents.is_lv_doc', 1);
        $total_records =  $this->db->count_all_results();
    
		$limit = isset($params['length']) && !empty($params['length']) ? $params['length'] : '';
        $offset = isset($params['start']) && !empty($params['start']) ? $params['start'] : '';
        $lv_document_lists = array();

    	if (isset($params['searchvalue']) && !empty($params['searchvalue'])) {
    		$keyword = $params['searchvalue'];

    		if (isset($keyword) && !empty($keyword)) {
                $this->db->group_start()
                        ->like('order_details.file_number', $keyword)
                        ->or_like('pct_order_documents.document_name', $keyword)
                        ->group_end();
            }

            $this->db->from('order_details')
                ->join('pct_order_documents', 'order_details.id = pct_order_documents.order_id');
            $this->db->where('pct_order_documents.is_lv_doc', 1);
			$filter_total_records =  $this->db->count_all_results();

			if(isset($keyword) && !empty($keyword)) {
                $this->db->group_start()
                        ->like('order_details.file_number', $keyword)
                        ->or_like('pct_order_documents.document_name', $keyword)
                        ->group_end();
			}

            $this->db->select('order_details.lp_file_number, order_details.file_number, pct_order_documents.document_name, pct_order_documents.api_document_id, pct_order_documents.created');
            $this->db->from('order_details')
                ->join('pct_order_documents', 'order_details.id = pct_order_documents.order_id');
            $this->db->where('pct_order_documents.is_lv_doc', 1);
            $this->db->order_by('pct_order_documents.id', 'desc');

            if ((isset($limit) && !empty($limit)) || (isset($offset) && !empty($offset))) {
                $this->db->limit($limit, $offset);
            }	
			$query = $this->db->get();
			if ($query->num_rows() > 0) {
	            $lv_document_lists = $query->result_array();
	        }
    	} else {    		

    		$this->db->from('order_details')
                ->join('pct_order_documents', 'order_details.id = pct_order_documents.order_id');
            $this->db->where('pct_order_documents.is_lv_doc', 1);
            $filter_total_records =  $this->db->count_all_results();

            $this->db->select('order_details.lp_file_number, order_details.file_number, pct_order_documents.document_name, pct_order_documents.api_document_id, pct_order_documents.created');
            $this->db->from('order_details')
                ->join('pct_order_documents', 'order_details.id = pct_order_documents.order_id');
            $this->db->where('pct_order_documents.is_lv_doc', 1);
            $this->db->order_by('pct_order_documents.id', 'desc');

			if ((isset($limit) && !empty($limit)) || (isset($offset) && !empty($offset))) {
                $this->db->limit($limit, $offset);
            }

			$query = $this->db->get();
			if ($query->num_rows() > 0) {
	            $lv_document_lists = $query->result_array();
	        } 
    	}

    	return array(
            'recordsTotal' => $total_records,
            'recordsFiltered' => $filter_total_records,
            'data' => $lv_document_lists
        );
    }

    public function get_master_users_list($params)
    {
        $this->db->where('is_master', 1);
    	$this->db->where('status', 1);
    	$this->db->from('customer_basic_details');
		$total_records =  $this->db->count_all_results();
		$limit = isset($params['length']) && !empty($params['length']) ? $params['length'] : '';
        $offset = isset($params['start']) && !empty($params['start']) ? $params['start'] : '';
        $customer_lists =array();
        
        if (isset($params['searchvalue']) && !empty($params['searchvalue'])) {
    		$keyword = $params['searchvalue'];

    		if (isset($keyword) && !empty($keyword)) {
                $this->db->group_start()
                    ->like("first_name", $keyword)
                    ->or_like('last_name',$keyword)
                    ->or_like('email_address',$keyword)
                    ->or_like('street_address', $keyword)
                    ->or_like('city', $keyword)
                    ->or_like('state', $keyword)
                    ->or_like('zip_code', $keyword)
                    ->group_end();
			}

            $this->db->where('status', 1);
			$this->db->where('is_master', 1);
	    	$this->db->from('customer_basic_details');
			$filter_total_records =  $this->db->count_all_results();

			if (isset($keyword) && !empty($keyword)) {
                $this->db->group_start()
                    ->like("first_name", $keyword)
                    ->or_like('last_name',$keyword)
                    ->or_like('email_address',$keyword)
                    ->or_like('street_address', $keyword)
                    ->or_like('city', $keyword)
                    ->or_like('state', $keyword)
                    ->or_like('zip_code', $keyword)
                    ->group_end();
			}
			$this->db->where('status', 1);
            $this->db->where('is_master', 1);

            if((isset($limit) && !empty($limit)) || (isset($offset) && !empty($offset))) {
                $this->db->limit($limit, $offset);
            }			
			$query = $this->db->get('customer_basic_details');
			if ($query->num_rows() > 0) {
	            $customer_lists = $query->result_array();
	        }
    	} else {    		
    		$this->db->where('status', 1);
            $this->db->where('is_master', 1);
	    	$this->db->from('customer_basic_details');
            $filter_total_records =  $this->db->count_all_results();

            $this->db->where('is_master', 1);
            $this->db->where('status', 1);
            
			if ((isset($limit) && !empty($limit)) || (isset($offset) && !empty($offset))) {
                $this->db->limit($limit, $offset);
            }
			$query = $this->db->get('customer_basic_details');
			
			if ($query->num_rows() > 0) {
	            $customer_lists = $query->result_array();
	        } 
    	}
    	return array(
            'recordsTotal' => $total_records,
            'recordsFiltered' => $filter_total_records,
            'data' => $customer_lists
        );
    }

    public function get_tax_document_list($params)
    {
        $this->db->from('order_details')
                 ->join('pct_order_documents', 'order_details.id = pct_order_documents.order_id');
        $this->db->where('pct_order_documents.is_tax_doc', 1);
        $total_records =  $this->db->count_all_results();
    
		$limit = isset($params['length']) && !empty($params['length']) ? $params['length'] : '';
        $offset = isset($params['start']) && !empty($params['start']) ? $params['start'] : '';
        $tax_document_lists = array();

    	if (isset($params['searchvalue']) && !empty($params['searchvalue'])) {
    		$keyword = $params['searchvalue'];

    		if (isset($keyword) && !empty($keyword)) {
                $this->db->group_start()
                        ->like('order_details.file_number', $keyword)
                        ->or_like('pct_order_documents.document_name', $keyword)
                        ->group_end();
            }

            $this->db->from('order_details')
                ->join('pct_order_documents', 'order_details.id = pct_order_documents.order_id');
            $this->db->where('pct_order_documents.is_tax_doc', 1);
			$filter_total_records =  $this->db->count_all_results();

			if(isset($keyword) && !empty($keyword)) {
                $this->db->group_start()
                        ->like('order_details.file_number', $keyword)
                        ->or_like('pct_order_documents.document_name', $keyword)
                        ->group_end();
			}

            $this->db->select('order_details.lp_file_number, order_details.file_number, pct_order_documents.document_name, pct_order_documents.api_document_id, pct_order_documents.created');
            $this->db->from('order_details')
                ->join('pct_order_documents', 'order_details.id = pct_order_documents.order_id');
            $this->db->where('pct_order_documents.is_tax_doc', 1);
            $this->db->order_by('pct_order_documents.id', 'desc');

            if ((isset($limit) && !empty($limit)) || (isset($offset) && !empty($offset))) {
                $this->db->limit($limit, $offset);
            }	
			$query = $this->db->get();
			if ($query->num_rows() > 0) {
	            $tax_document_lists = $query->result_array();
	        }
    	} else {    		

    		$this->db->from('order_details')
                ->join('pct_order_documents', 'order_details.id = pct_order_documents.order_id');
            $this->db->where('pct_order_documents.is_tax_doc', 1);
            $filter_total_records =  $this->db->count_all_results();

            $this->db->select('order_details.lp_file_number, order_details.file_number, pct_order_documents.document_name, pct_order_documents.api_document_id, pct_order_documents.created');
            $this->db->from('order_details')
                ->join('pct_order_documents', 'order_details.id = pct_order_documents.order_id');
            $this->db->where('pct_order_documents.is_tax_doc', 1);
            $this->db->order_by('pct_order_documents.id', 'desc');

			if ((isset($limit) && !empty($limit)) || (isset($offset) && !empty($offset))) {
                $this->db->limit($limit, $offset);
            }

			$query = $this->db->get();
			if ($query->num_rows() > 0) {
	            $tax_document_lists = $query->result_array();
	        } 
    	}

    	return array(
            'recordsTotal' => $total_records,
            'recordsFiltered' => $filter_total_records,
            'data' => $tax_document_lists
        );
    }

    public function get_curative_document_list($params)
    {
        $this->db->from('order_details')
                 ->join('pct_order_documents', 'order_details.id = pct_order_documents.order_id');
        $this->db->where('pct_order_documents.is_curative_doc', 1);
        $total_records =  $this->db->count_all_results();
    
		$limit = isset($params['length']) && !empty($params['length']) ? $params['length'] : '';
        $offset = isset($params['start']) && !empty($params['start']) ? $params['start'] : '';
        $curative_document_lists = array();

    	if (isset($params['searchvalue']) && !empty($params['searchvalue'])) {
    		$keyword = $params['searchvalue'];

    		if (isset($keyword) && !empty($keyword)) {
                $this->db->group_start()
                        ->like('order_details.file_number', $keyword)
                        ->or_like('pct_order_documents.document_name', $keyword)
                        ->group_end();
            }

            $this->db->from('order_details')
                ->join('pct_order_documents', 'order_details.id = pct_order_documents.order_id');
            $this->db->where('pct_order_documents.is_curative_doc', 1);
			$filter_total_records =  $this->db->count_all_results();

			if(isset($keyword) && !empty($keyword)) {
                $this->db->group_start()
                        ->like('order_details.file_number', $keyword)
                        ->or_like('pct_order_documents.document_name', $keyword)
                        ->group_end();
			}

            $this->db->select('order_details.file_number, pct_order_documents.document_name, pct_order_documents.api_document_id, pct_order_documents.created');
            $this->db->from('order_details')
                ->join('pct_order_documents', 'order_details.id = pct_order_documents.order_id');
            $this->db->where('pct_order_documents.is_curative_doc', 1);
            $this->db->order_by('pct_order_documents.id', 'desc');

            if ((isset($limit) && !empty($limit)) || (isset($offset) && !empty($offset))) {
                $this->db->limit($limit, $offset);
            }	
			$query = $this->db->get();
			if ($query->num_rows() > 0) {
	            $curative_document_lists = $query->result_array();
	        }
    	} else {    		

    		$this->db->from('order_details')
                ->join('pct_order_documents', 'order_details.id = pct_order_documents.order_id');
            $this->db->where('pct_order_documents.is_curative_doc', 1);
            $filter_total_records =  $this->db->count_all_results();

            $this->db->select('order_details.file_number, pct_order_documents.document_name, pct_order_documents.api_document_id, pct_order_documents.created');
            $this->db->from('order_details')
                ->join('pct_order_documents', 'order_details.id = pct_order_documents.order_id');
            $this->db->where('pct_order_documents.is_curative_doc', 1);
            $this->db->order_by('pct_order_documents.id', 'desc');

			if ((isset($limit) && !empty($limit)) || (isset($offset) && !empty($offset))) {
                $this->db->limit($limit, $offset);
            }

			$query = $this->db->get();
			if ($query->num_rows() > 0) {
	            $curative_document_lists = $query->result_array();
	        } 
    	}

    	return array(
            'recordsTotal' => $total_records,
            'recordsFiltered' => $filter_total_records,
            'data' => $curative_document_lists
        );
    }

    public function get_companies_list($params)
    {
    	$this->db->from('pct_order_partner_company_info');
		$total_records =  $this->db->count_all_results();
		$limit = isset($params['length']) && !empty($params['length']) ? $params['length'] : '';
        $offset = isset($params['start']) && !empty($params['start']) ? $params['start'] : '';
        $company_lists =array();
        
        if (isset($params['searchvalue']) && !empty($params['searchvalue'])) {
    		$keyword = $params['searchvalue'];

    		if (isset($keyword) && !empty($keyword)) {
                $this->db->group_start()
                    ->like("partner_id", $keyword)
                    ->or_like('partner_name',$keyword)
                    ->or_like('address1',$keyword)
                    ->or_like('city', $keyword)
                    ->or_like('state', $keyword)
                    ->or_like('zip', $keyword)
                    ->group_end();
			}

	    	$this->db->from('pct_order_partner_company_info');
			$filter_total_records =  $this->db->count_all_results();

			if (isset($keyword) && !empty($keyword)) {
                $this->db->group_start()
                    ->like("partner_id", $keyword)
                    ->or_like('partner_name',$keyword)
                    ->or_like('address1',$keyword)
                    ->or_like('city', $keyword)
                    ->or_like('state', $keyword)
                    ->or_like('zip', $keyword)
                    ->group_end();
			}
			
            if((isset($limit) && !empty($limit)) || (isset($offset) && !empty($offset))) {
                $this->db->limit($limit, $offset);
            }			
			$query = $this->db->get('pct_order_partner_company_info');
			if ($query->num_rows() > 0) {
	            $customer_lists = $query->result_array();
	        }
    	} else {    		
	    	$this->db->from('pct_order_partner_company_info');
            $filter_total_records =  $this->db->count_all_results();
 
			if ((isset($limit) && !empty($limit)) || (isset($offset) && !empty($offset))) {
                $this->db->limit($limit, $offset);
            }
			$query = $this->db->get('pct_order_partner_company_info');
			
			if ($query->num_rows() > 0) {
	            $customer_lists = $query->result_array();
	        } 
    	}
    	return array(
            'recordsTotal' => $total_records,
            'recordsFiltered' => $filter_total_records,
            'data' => $customer_lists
        );
    }

    public function get_incorrect_customers($params)
    {
        $query = $this->db->query('SELECT * 
                                FROM
                                  customer_basic_details 
                                WHERE email_address IN 
                                  (SELECT 
                                    email_address 
                                  FROM
                                    customer_basic_details 
                                  WHERE random_password != "" 
                                    AND is_password_updated = 0 AND email_address != "") 
                                GROUP BY email_address 
                                HAVING COUNT(email_address) = 1');

        $total_records =  $query->num_rows();


        $limit = isset($params['length']) && !empty($params['length']) ? $params['length'] : '';
        $offset = isset($params['start']) && !empty($params['start']) ? $params['start'] : '';
        
        
        $customer_lists =array();
        if(isset($params['searchvalue']) && !empty($params['searchvalue']))
        {
            $keyword = $params['searchvalue'];

            if(isset($keyword) && !empty($keyword))
            {
                $where = ' AND first_name LIKE "%'.$keyword.'%"';
                $where .= ' OR last_name LIKE "%'.$keyword.'%"';
                $where .= ' OR email_address LIKE "%'.$keyword.'%"';
            }

            
            $query = $this->db->query('SELECT * 
                                FROM
                                  customer_basic_details 
                                WHERE email_address IN 
                                  (SELECT 
                                    email_address 
                                  FROM
                                    customer_basic_details 
                                  WHERE random_password != ""
                                    AND is_password_updated = 0 AND email_address != "")'.$where.' 
                                GROUP BY email_address 
                                HAVING COUNT(email_address) = 1');

            $filter_total_records =  $query->num_rows();


            if(isset($keyword) && !empty($keyword))
            {
                if(isset($keyword) && !empty($keyword))
                {
                    $where = ' AND first_name LIKE "%'.$keyword.'%"';
                    $where .= ' OR last_name LIKE "%'.$keyword.'%"';
                    $where .= ' OR email_address LIKE "%'.$keyword.'%"';
                }
            }

            if(isset($limit) && !empty($limit))
            {
                $limit = ' LIMIT ' .$limit;
            }
            if((isset($offset) && !empty($offset)))
            {
                $offset = ' OFFSET '.$offset;
            }
            
            $query = $this->db->query('SELECT * 
                                FROM
                                  customer_basic_details 
                                WHERE email_address IN 
                                  (SELECT 
                                    email_address 
                                  FROM
                                    customer_basic_details 
                                  WHERE random_password != ""
                                    AND is_password_updated = 0 AND email_address != "")'.$where.' 
                                GROUP BY email_address 
                                HAVING COUNT(email_address) = 1'.$limit.$offset);
            if ($query->num_rows() > 0) 
            {
                $customer_lists = $query->result_array();
            }
        }
        else
        {   

            $query = $this->db->query('SELECT * 
                                FROM
                                  customer_basic_details 
                                WHERE email_address IN 
                                  (SELECT 
                                    email_address 
                                  FROM
                                    customer_basic_details 
                                  WHERE random_password != ""
                                    AND is_password_updated = 0 AND email_address != "") 
                                GROUP BY email_address 
                                HAVING COUNT(email_address) = 1');

            $filter_total_records =  $query->num_rows();
            if(isset($limit) && !empty($limit))
            {
                $limit = ' LIMIT ' .$limit;
            }
            if((isset($offset) && !empty($offset)))
            {
                $offset = ' OFFSET '.$offset;
            }
            
            $query = $this->db->query('SELECT * 
                                FROM
                                  customer_basic_details 
                                WHERE email_address IN 
                                  (SELECT 
                                    email_address 
                                  FROM
                                    customer_basic_details 
                                  WHERE random_password != "" 
                                    AND is_password_updated = 0 AND email_address != "") 
                                GROUP BY email_address 
                                HAVING COUNT(email_address) = 1'.$limit.$offset);

            if ($query->num_rows() > 0) 
            {
                $customer_lists = $query->result_array();
            }
        }

        return array(
            'recordsTotal' => $total_records,
            'recordsFiltered' => $filter_total_records,
            'data' => $customer_lists
        );
    }
    
    public function getUsersForEmail($email, $id) 
    {
        $this->db->select('*');
        $this->db->from('customer_basic_details');
        $this->db->where('random_password != ""');
        $this->db->where('email_address', $email);
        $this->db->where("id !=", $id);
        $query = $this->db->get();
        $usersLists = $query->result_array();  
        return $usersLists;  
    }

    public function get_company_rows($params = array())
    {
    	$table = 'pct_order_partner_company_info';
        $this->db->select('*');
        $this->db->from($table);
        
        if (array_key_exists("where", $params)) {

            foreach ($params['where'] as $key => $val){
                $this->db->where($key, $val);
            }
        }
        
        if (array_key_exists("returnType",$params) && $params['returnType'] == 'count') {
            $result = $this->db->count_all_results();
        } else {

            if (array_key_exists("id", $params)) {
                $this->db->where('id', $params['id']);
                $query = $this->db->get();
                $result = $query->row_array();
            } else {
                $this->db->order_by('id', 'asc');

                if (array_key_exists("start",$params) && array_key_exists("limit",$params)) {
                    $this->db->limit($params['limit'],$params['start']);
                } elseif (!array_key_exists("start",$params) && array_key_exists("limit",$params)) {
                    $this->db->limit($params['limit']);
                }
                $query = $this->db->get();
                $result = ($query->num_rows() > 0)?$query->result_array():FALSE;
            }
        }
        return $result;
    }

    public function get_cpl_proposed_users_list($params)
    {
        $this->db->where('is_added_lender_by_cpl_proposed', 1);
    	$this->db->from('customer_basic_details');
		$total_records =  $this->db->count_all_results();
		$limit = isset($params['length']) && !empty($params['length']) ? $params['length'] : '';
        $offset = isset($params['start']) && !empty($params['start']) ? $params['start'] : '';
        $customer_lists =array();
        
        if (isset($params['searchvalue']) && !empty($params['searchvalue'])) {
    		$keyword = $params['searchvalue'];

    		if (isset($keyword) && !empty($keyword)) {
                $this->db->group_start()
                    ->like("first_name", $keyword)
                    ->or_like('last_name',$keyword)
                    ->or_like('email_address',$keyword)
                    ->or_like('street_address', $keyword)
                    ->or_like('city', $keyword)
                    ->or_like('state', $keyword)
                    ->or_like('zip_code', $keyword)
                    ->group_end();
			}

           
            $this->db->where('is_added_lender_by_cpl_proposed', 1);
	    	$this->db->from('customer_basic_details');
			$filter_total_records =  $this->db->count_all_results();

			if (isset($keyword) && !empty($keyword)) {
                $this->db->group_start()
                    ->like("first_name", $keyword)
                    ->or_like('last_name',$keyword)
                    ->or_like('email_address',$keyword)
                    ->or_like('street_address', $keyword)
                    ->or_like('city', $keyword)
                    ->or_like('state', $keyword)
                    ->or_like('zip_code', $keyword)
                    ->group_end();
			}
			
            $this->db->where('is_added_lender_by_cpl_proposed', 1);

            if((isset($limit) && !empty($limit)) || (isset($offset) && !empty($offset))) {
                $this->db->limit($limit, $offset);
            }			
			$query = $this->db->get('customer_basic_details');
			if ($query->num_rows() > 0) {
	            $customer_lists = $query->result_array();
	        }
    	} else {    		
            $this->db->where('is_added_lender_by_cpl_proposed', 1);
	    	$this->db->from('customer_basic_details');
            $filter_total_records =  $this->db->count_all_results();

            $this->db->where('is_added_lender_by_cpl_proposed', 1);
            
			if ((isset($limit) && !empty($limit)) || (isset($offset) && !empty($offset))) {
                $this->db->limit($limit, $offset);
            }
			$query = $this->db->get('customer_basic_details');
			
			if ($query->num_rows() > 0) {
	            $customer_lists = $query->result_array();
	        } 
    	}
    	return array(
            'recordsTotal' => $total_records,
            'recordsFiltered' => $filter_total_records,
            'data' => $customer_lists
        );
    }

    public function get_password_list($params)
    {
        $user_type = isset($params['user_type']) && !empty($params['user_type']) ? $params['user_type'] : '';

        if (isset($user_type) && !empty($user_type)) {
            if ($user_type == 'title_officer') {
                $this->db->where('is_title_officer', 1);
            } else if ($user_type == 'sales_rep') {
                $this->db->where('is_sales_rep', 1);
            } else if ($user_type == 'sales_rep_manager') {
                $this->db->where('is_sales_rep', 1);
                $this->db->where('is_sales_rep_manager', 1);
            } else if ($user_type == 'escrow') {
                $this->db->where('is_escrow', 1);
            } else  if ($user_type == 'lender') {
                $this->db->where('is_escrow', 0);
            } else  if ($user_type == 'special_lender') {
                $this->db->where('is_special_lender', 1);
            }
        }
        $this->db->where('is_password_updated', 1);
    	$this->db->where('status', 1);
    	$this->db->from('customer_basic_details');
		$total_records =  $this->db->count_all_results();
		$limit = isset($params['length']) && !empty($params['length']) ? $params['length'] : '';
        $offset = isset($params['start']) && !empty($params['start']) ? $params['start'] : '';
        $customer_lists =array();

    	if(isset($params['searchvalue']) && !empty($params['searchvalue'])) {
    		$keyword = $params['searchvalue'];

    		if (isset($keyword) && !empty($keyword)) {
                $this->db->group_start()
                    ->like("first_name", $keyword)
                    ->or_like('last_name',$keyword)
                    ->or_like('email_address',$keyword)
                    ->or_like('street_address', $keyword)
                    ->or_like('city', $keyword)
                    ->or_like('state', $keyword)
                    ->or_like('zip_code', $keyword)
                    ->group_end();
            }

            if (isset($user_type) && !empty($user_type)) {
                if ($user_type == 'title_officer') {
                    $this->db->where('is_title_officer', 1);
                } else if ($user_type == 'sales_rep') {
                    $this->db->where('is_sales_rep', 1);
                } else if ($user_type == 'sales_rep_manager') {
                    $this->db->where('is_sales_rep', 1);
                    $this->db->where('is_sales_rep_manager', 1);
                } else if ($user_type == 'escrow') {
                    $this->db->where('is_escrow', 1);
                } else  if ($user_type == 'lender') {
                    $this->db->where('is_escrow', 0);
                } else  if ($user_type == 'special_lender') {
                    $this->db->where('is_special_lender', 1);
                }
            }
            $this->db->where('status', 1);
			$this->db->where('is_password_updated', 1);
	    	$this->db->from('customer_basic_details');
			$filter_total_records =  $this->db->count_all_results();

			if (isset($keyword) && !empty($keyword)) {
                $this->db->group_start()
                    ->like("first_name", $keyword)
                    ->or_like('last_name',$keyword)
                    ->or_like('email_address',$keyword)
                    ->or_like('street_address', $keyword)
                    ->or_like('city', $keyword)
                    ->or_like('state', $keyword)
                    ->or_like('zip_code', $keyword)
                    ->group_end();
            }
            
            if (isset($user_type) && !empty($user_type)) {
                if ($user_type == 'title_officer') {
                    $this->db->where('is_title_officer', 1);
                } else if ($user_type == 'sales_rep') {
                    $this->db->where('is_sales_rep', 1);
                } else if ($user_type == 'sales_rep_manager') {
                    $this->db->where('is_sales_rep', 1);
                    $this->db->where('is_sales_rep_manager', 1);
                } else if ($user_type == 'escrow') {
                    $this->db->where('is_escrow', 1);
                } else  if ($user_type == 'lender') {
                    $this->db->where('is_escrow', 0);
                } else  if ($user_type == 'special_lender') {
                    $this->db->where('is_special_lender', 1);
                }
            }
			$this->db->where('status', 1);
            $this->db->where('is_password_updated', 1);

            if ((isset($limit) && !empty($limit)) || (isset($offset) && !empty($offset))) {
                $this->db->limit($limit, $offset);
            }	

			$query = $this->db->get('customer_basic_details');

			if ($query->num_rows() > 0)  {
	            $customer_lists = $query->result_array();
	        }
    	} else {  
            if (isset($user_type) && !empty($user_type)) {
                if ($user_type == 'title_officer') {
                    $this->db->where('is_title_officer', 1);
                } else if ($user_type == 'sales_rep') {
                    $this->db->where('is_sales_rep', 1);
                } else if ($user_type == 'sales_rep_manager') {
                    $this->db->where('is_sales_rep', 1);
                    $this->db->where('is_sales_rep_manager', 1);
                } else if ($user_type == 'escrow') {
                    $this->db->where('is_escrow', 1);
                } else  if ($user_type == 'lender') {
                    $this->db->where('is_escrow', 0);
                } else  if ($user_type == 'special_lender') {
                    $this->db->where('is_special_lender', 1);
                }
            }  		
    		$this->db->where('status', 1);
            $this->db->where('is_password_updated', 1);
	    	$this->db->from('customer_basic_details');
            $filter_total_records =  $this->db->count_all_results();

            if (isset($user_type) && !empty($user_type)) {
                if ($user_type == 'title_officer') {
                    $this->db->where('is_title_officer', 1);
                } else if ($user_type == 'sales_rep') {
                    $this->db->where('is_sales_rep', 1);
                } else if ($user_type == 'sales_rep_manager') {
                    $this->db->where('is_sales_rep', 1);
                    $this->db->where('is_sales_rep_manager', 1);
                } else if ($user_type == 'escrow') {
                    $this->db->where('is_escrow', 1);
                } else  if ($user_type == 'lender') {
                    $this->db->where('is_escrow', 0);
                } else  if ($user_type == 'special_lender') {
                    $this->db->where('is_special_lender', 1);
                }
            }
            $this->db->where('is_password_updated', 1);
            $this->db->where('status', 1);
            
			if((isset($limit) && !empty($limit)) || (isset($offset) && !empty($offset))) {
                $this->db->limit($limit, $offset);
            }
			$query = $this->db->get('customer_basic_details');
			
			if ($query->num_rows() > 0) 
	        {
	            $customer_lists = $query->result_array();
	        } 
    	}

    	return array(
            'recordsTotal' => $total_records,
            'recordsFiltered' => $filter_total_records,
            'data' => $customer_lists
        );
    }

    public function get_import_order_users($params)
    {

        $this->db->where('is_password_updated', 1);
        $this->db->where('status', 1);
        $this->db->from('customer_basic_details');
        $total_records =  $this->db->count_all_results();


        $limit = isset($params['length']) && !empty($params['length']) ? $params['length'] : '';
        $offset = isset($params['start']) && !empty($params['start']) ? $params['start'] : '';
        
        
        $customer_lists =array();
        if(isset($params['searchvalue']) && !empty($params['searchvalue']))
        {
            $keyword = $params['searchvalue'];

            if(isset($keyword) && !empty($keyword))
            {
                $this->db->where("CONCAT_WS(' ',first_name,last_name) LIKE '%".$keyword."%'", NULL, FALSE);
                $this->db->or_like('email_address',$keyword);
                // $this->db->like('first_name', $keyword);
            }

            $this->db->where('status', 1);
            $this->db->where('is_password_updated', 1);
            $this->db->from('customer_basic_details');
            $filter_total_records =  $this->db->count_all_results();


            if(isset($keyword) && !empty($keyword))
            {
                $this->db->where("CONCAT_WS(' ',first_name,last_name) LIKE '%".$keyword."%'", NULL, FALSE);
                $this->db->or_like('email_address',$keyword);
            }

            $this->db->where('status', 1);
            $this->db->where('is_password_updated', 1);

            if((isset($limit) && !empty($limit)) || (isset($offset) && !empty($offset)))
            {
                $this->db->limit($limit, $offset);
            }           
            $query = $this->db->get('customer_basic_details');

            if ($query->num_rows() > 0) 
            {
                $customer_lists = $query->result_array();
            }
        }
        else
        {           

            $this->db->where('status', 1);
            $this->db->where('is_password_updated', 1);
            $this->db->from('customer_basic_details');

            $filter_total_records =  $this->db->count_all_results();

            $this->db->where('is_password_updated', 1);
            $this->db->where('status', 1);
            if((isset($limit) && !empty($limit)) || (isset($offset) && !empty($offset)))
            {
                $this->db->limit($limit, $offset);
            }
            $query = $this->db->get('customer_basic_details');
            
            if ($query->num_rows() > 0) 
            {
                $customer_lists = $query->result_array();
            } 
        }

        return array(
            'recordsTotal' => $total_records,
            'recordsFiltered' => $filter_total_records,
            'data' => $customer_lists
        );
    }

    public function getCplErrorLogs($params)
    {
        $this->db->from('pct_order_cpl_api_logs');
        $total_records =  $this->db->count_all_results();
        $limit = isset($params['length']) && !empty($params['length']) ? $params['length'] : '';
        $offset = isset($params['start']) && !empty($params['start']) ? $params['start'] : '';
        $customer_lists =array();

        if(isset($params['searchvalue']) && !empty($params['searchvalue'])) {
            $keyword = $params['searchvalue'];
            $this->db->from('pct_order_cpl_api_logs');
            if(isset($keyword) && !empty($keyword)) {
                $this->db->group_start()
                    ->like('file_number', $keyword)
                    ->or_like('cpl_page', $keyword)
                    ->or_like('error', $keyword)
                    ->group_end();
            }
            $filter_total_records =  $this->db->count_all_results();

            if(isset($keyword) && !empty($keyword)) {
                $this->db->group_start()
                    ->like('file_number', $keyword)
                    ->or_like('cpl_page', $keyword)
                    ->or_like('error', $keyword)
                    ->group_end();
            }
            if((isset($limit) && !empty($limit)) || (isset($offset) && !empty($offset))) {
                $this->db->limit($limit, $offset);
            }
            
            $this->db->order_by('order_id', 'desc');
            $query = $this->db->get('pct_order_cpl_api_logs');

            if ($query->num_rows() > 0)  {
                $customer_lists = $query->result_array();
            }
        } else {           

            $this->db->from('pct_order_cpl_api_logs');
            $filter_total_records =  $this->db->count_all_results();

            if((isset($limit) && !empty($limit)) || (isset($offset) && !empty($offset))) {
                $this->db->limit($limit, $offset);
            }

            $this->db->order_by('order_id', 'desc');
            $query = $this->db->get('pct_order_cpl_api_logs');
            
            if ($query->num_rows() > 0) {
                $customer_lists = $query->result_array();
            } 
        }

        return array(
            'recordsTotal' => $total_records,
            'recordsFiltered' => $filter_total_records,
            'data' => $customer_lists
        );
    }

    public function getNotifications() 
    {
        $this->db->select('*');
        $this->db->from('pct_notifications');
        $this->db->order_by('name', 'asc');
        $query = $this->db->get();
        $notifications = $query->result_array();  
        return $notifications;  
    }

    public function get_notifications_list($params)
    {
        $this->db->from('pct_notifications');
        $total_records =  $this->db->count_all_results();
        $limit = isset($params['length']) && !empty($params['length']) ? $params['length'] : '';
        $offset = isset($params['start']) && !empty($params['start']) ? $params['start'] : '';
        $notification_lists =array();

        if(isset($params['searchvalue']) && !empty($params['searchvalue'])) {
            $keyword = $params['searchvalue'];
            $this->db->from('pct_notifications');

            if(isset($keyword) && !empty($keyword)) {
                $this->db->group_start()
                    ->like('name', $keyword)
                    ->group_end();
            }
            $filter_total_records =  $this->db->count_all_results();

            if(isset($keyword) && !empty($keyword)) {
                $this->db->group_start()
                    ->like('name', $keyword)
                    ->group_end();
            }

            if((isset($limit) && !empty($limit)) || (isset($offset) && !empty($offset))) {
                $this->db->limit($limit, $offset);
            }           
            $query = $this->db->get('pct_notifications');

            if ($query->num_rows() > 0)  {
                $notification_lists = $query->result_array();
            }
        } else {           
            $this->db->from('pct_notifications');
            $filter_total_records =  $this->db->count_all_results();

            if((isset($limit) && !empty($limit)) || (isset($offset) && !empty($offset))) {
                $this->db->limit($limit, $offset);
            }
            $query = $this->db->get('pct_notifications');
            
            if ($query->num_rows() > 0) {
                $notification_lists = $query->result_array();
            } 
        }

        return array(
            'recordsTotal' => $total_records,
            'recordsFiltered' => $filter_total_records,
            'data' => $notification_lists
        );
    }

    public function get_escrow_officers($params)
    {
        $this->db->where('status', 1);
        $this->db->from('pct_order_partner_company_info');
        $this->db->like('partner_type_id', '10010');
        $total_records =  $this->db->count_all_results();

        $limit = isset($params['length']) && !empty($params['length']) ? $params['length'] : '';
        $offset = isset($params['start']) && !empty($params['start']) ? $params['start'] : '';
        $escrow_officer_lists =array();
        
        if (isset($params['searchvalue']) && !empty($params['searchvalue'])) {
            $keyword = $params['searchvalue'];

            if (isset($keyword) && !empty($keyword)) {
                $this->db->group_start()
                    ->like("partner_name", $keyword)
                    ->or_like('email',$keyword)
                    ->group_end();
            }
            $this->db->like('partner_type_id', '10010');
            $this->db->where('status', 1);

            $this->db->from('pct_order_partner_company_info');
            $filter_total_records =  $this->db->count_all_results();

            if (isset($keyword) && !empty($keyword)) {
                $this->db->group_start()
                    ->like("partner_name", $keyword)
                    ->or_like('email',$keyword)
                    ->group_end();
            }
            $this->db->like('partner_type_id', '10010');
            $this->db->where('status', 1);


            if((isset($limit) && !empty($limit)) || (isset($offset) && !empty($offset))) {
                $this->db->limit($limit, $offset);
            }           
            $query = $this->db->get('pct_order_partner_company_info');
            if ($query->num_rows() > 0) {
                $escrow_officer_lists = $query->result_array();
            }
        } else {            
            $this->db->where('status', 1);
            $this->db->like('partner_type_id', '10010');
            $this->db->from('pct_order_partner_company_info');
            $filter_total_records =  $this->db->count_all_results();

            $this->db->like('partner_type_id', '10010');
            $this->db->where('status', 1);
            
            if ((isset($limit) && !empty($limit)) || (isset($offset) && !empty($offset))) {
                $this->db->limit($limit, $offset);
            }
            $query = $this->db->get('pct_order_partner_company_info');
            
            if ($query->num_rows() > 0) {
                $escrow_officer_lists = $query->result_array();
            } 
        }
        return array(
            'recordsTotal' => $total_records,
            'recordsFiltered' => $filter_total_records,
            'data' => $escrow_officer_lists
        );
    }

    public function get_escrow_officer($params = array())
    {
        $this->db->select('*');
        $this->db->from('pct_order_partner_company_info');
        
        if(array_key_exists("where", $params)){
            foreach($params['where'] as $key => $val){
                $this->db->where($key, $val);
            }
        }
        
        if(array_key_exists("returnType",$params) && $params['returnType'] == 'count'){
            $result = $this->db->count_all_results();
        }else{
            if(array_key_exists("id", $params)){
                $this->db->where('id', $params['id']);
                $query = $this->db->get();
                $result = $query->row_array();
            }else{
                $this->db->order_by('id', 'asc');
                if(array_key_exists("start",$params) && array_key_exists("limit",$params)){
                    $this->db->limit($params['limit'],$params['start']);
                }elseif(!array_key_exists("start",$params) && array_key_exists("limit",$params)){
                    $this->db->limit($params['limit']);
                }
                
                $query = $this->db->get();
                $result = ($query->num_rows() > 0)?$query->result_array():FALSE;
            }
        }
        
        // Return fetched data
        return $result;
    }

    public function get_mortgage_users($params)
    {
        $this->db->where('is_mortgage_user', 1);
    	$this->db->where('status', 1);
    	$this->db->from('customer_basic_details');
		$total_records =  $this->db->count_all_results();
		$limit = isset($params['length']) && !empty($params['length']) ? $params['length'] : '';
        $offset = isset($params['start']) && !empty($params['start']) ? $params['start'] : '';
    
        $customer_lists =array();
    	if(isset($params['searchvalue']) && !empty($params['searchvalue'])) {
    		$keyword = $params['searchvalue'];

    		if(isset($keyword) && !empty($keyword)) {
                $this->db->group_start();
                $this->db->where("CONCAT_WS(' ',first_name,last_name) LIKE '%".$keyword."%'", NULL, FALSE);
                $this->db->or_like('email_address',$keyword);
                $this->db->group_end();
			}

            $this->db->where('status', 1);
            $this->db->where('is_mortgage_user', 1);
	    	$this->db->from('customer_basic_details');
			$filter_total_records =  $this->db->count_all_results();
			if(isset($keyword) && !empty($keyword)) {
                $this->db->group_start();
                $this->db->where("CONCAT_WS(' ',first_name,last_name) LIKE '%".$keyword."%'", NULL, FALSE);
                $this->db->or_like('email_address', $keyword);
                $this->db->group_end();
			}

			$this->db->where('status', 1);
            $this->db->where('is_mortgage_user', 1);
            if ((isset($limit) && !empty($limit)) || (isset($offset) && !empty($offset))) {
                $this->db->limit($limit, $offset);
            }	

			$query = $this->db->get('customer_basic_details');
			if ($query->num_rows() > 0) {
	            $customer_lists = $query->result_array();
	        }
    	} else {    		
    		$this->db->where('status', 1);
            $this->db->where('is_mortgage_user', 1);
	    	$this->db->from('customer_basic_details');
            $filter_total_records =  $this->db->count_all_results();

            $this->db->where('is_mortgage_user', 1);
			$this->db->where('status', 1);
			if((isset($limit) && !empty($limit)) || (isset($offset) && !empty($offset))) {
                $this->db->limit($limit, $offset);
            }
			$query = $this->db->get('customer_basic_details');
			
			if ($query->num_rows() > 0) {
	            $customer_lists = $query->result_array();
	        } 
    	}
    	return array(
            'recordsTotal' => $total_records,
            'recordsFiltered' => $filter_total_records,
            'data' => $customer_lists
        );
    }

	public function get_pending_json_files() {
		
		$this->db->select('file_number');
		$this->db->from('pct_order_prelim_summary');
		
		$query = $this->db->get();
        $result = ($query->num_rows() > 0)?$query->result_array():array();
		$file_array = array();
		if(count($result)) {
			$file_array = array_column($result,'file_number');
		}
		
		$this->db->distinct()->select('count(order_details.file_number) as total_files');
		$this->db->from('pct_order_api_logs');
		$this->db->join('order_details','order_details.id = pct_order_api_logs.order_id');
		$this->db->where_not_in('order_details.file_number',$file_array);
		$query = $this->db->get();
		$result = ($query->num_rows() > 0)?$query->result_array():array();
		if(count($result)) {
			return $result[0]['total_files'];
		}
		else {
			return 0;
		}

	}

	public function get_failed_json_files() {
		
		$this->db->select('count(id) as total_files');
		$this->db->from('order_details');
		$this->db->where('prelim_flag','0');
		$query = $this->db->get();
		$result = $query->row_array();
        if(!empty($result)) { 
            return $result['total_files'];
        } else {
            return 0;
        }
	}

	public function get_records($table,$condition = null,$order = null) {
		$this->db->from($table);
		if($condition) {
			$this->db->where($condition);
		}
		if($order) {
			foreach($order as $order_key=>$order_val) {
				$this->db->order_by($order_key, $order_val);
			}
		}
		$query = $this->db->get();
		if ($query->num_rows() > 0)  {
			return $query->result_array();
		} else {
			return array();
		}
	}

    public function get_pre_listing_document_list($params)
    {
        $this->db->from('order_details')
                 ->join('pct_order_documents', 'order_details.id = pct_order_documents.order_id');
        $this->db->where('pct_order_documents.is_pre_listing_doc', 1);
        $total_records =  $this->db->count_all_results();
    
		$limit = isset($params['length']) && !empty($params['length']) ? $params['length'] : '';
        $offset = isset($params['start']) && !empty($params['start']) ? $params['start'] : '';
        $grant_document_lists = array();

    	if (isset($params['searchvalue']) && !empty($params['searchvalue'])) {
    		$keyword = $params['searchvalue'];

    		if (isset($keyword) && !empty($keyword)) {
                $this->db->group_start()
                        ->like('order_details.file_number', $keyword)
                        ->or_like('pct_order_documents.document_name', $keyword)
                        ->group_end();
            }

            $this->db->from('order_details')
                ->join('pct_order_documents', 'order_details.id = pct_order_documents.order_id');
            $this->db->where('pct_order_documents.is_pre_listing_doc', 1);
			$filter_total_records =  $this->db->count_all_results();

			if(isset($keyword) && !empty($keyword)) {
                $this->db->group_start()
                        ->like('order_details.file_number', $keyword)
                        ->or_like('pct_order_documents.document_name', $keyword)
                        ->group_end();
			}

            $this->db->select('order_details.lp_file_number, order_details.file_number, pct_order_documents.document_name, pct_order_documents.api_document_id, pct_order_documents.created');
            $this->db->from('order_details')
                ->join('pct_order_documents', 'order_details.id = pct_order_documents.order_id');
            $this->db->where('pct_order_documents.is_pre_listing_doc', 1);
            $this->db->order_by('pct_order_documents.id', 'desc');

            if ((isset($limit) && !empty($limit)) || (isset($offset) && !empty($offset))) {
                $this->db->limit($limit, $offset);
            }	
			$query = $this->db->get();
			if ($query->num_rows() > 0) {
	            $grant_document_lists = $query->result_array();
	        }
    	} else {    		

    		$this->db->from('order_details')
                ->join('pct_order_documents', 'order_details.id = pct_order_documents.order_id');
            $this->db->where('pct_order_documents.is_pre_listing_doc', 1);
            $filter_total_records =  $this->db->count_all_results();

            $this->db->select('order_details.lp_file_number, order_details.file_number, pct_order_documents.document_name, pct_order_documents.api_document_id, pct_order_documents.created');
            $this->db->from('order_details')
                ->join('pct_order_documents', 'order_details.id = pct_order_documents.order_id');
            $this->db->where('pct_order_documents.is_pre_listing_doc', 1);
            $this->db->order_by('pct_order_documents.id', 'desc');

			if ((isset($limit) && !empty($limit)) || (isset($offset) && !empty($offset))) {
                $this->db->limit($limit, $offset);
            }

			$query = $this->db->get();
			if ($query->num_rows() > 0) {
	            $grant_document_lists = $query->result_array();
	        } 
    	}

    	return array(
            'recordsTotal' => $total_records,
            'recordsFiltered' => $filter_total_records,
            'data' => $grant_document_lists
        );
    }

    public function get_lp_listing_document_list($params)
    {
        $this->db->from('order_details')
                 ->join('pct_order_documents', 'order_details.id = pct_order_documents.order_id');
        $this->db->where('pct_order_documents.is_pre_listing_report_doc', 1);
        $total_records =  $this->db->count_all_results();
    
		$limit = isset($params['length']) && !empty($params['length']) ? $params['length'] : '';
        $offset = isset($params['start']) && !empty($params['start']) ? $params['start'] : '';
        $grant_document_lists = array();

    	if (isset($params['searchvalue']) && !empty($params['searchvalue'])) {
    		$keyword = $params['searchvalue'];

    		if (isset($keyword) && !empty($keyword)) {
                $this->db->group_start()
                        ->like('order_details.file_number', $keyword)
                        ->or_like('pct_order_documents.document_name', $keyword)
                        ->group_end();
            }

            $this->db->from('order_details')
                ->join('pct_order_documents', 'order_details.id = pct_order_documents.order_id');
            $this->db->where('pct_order_documents.is_pre_listing_report_doc', 1);
			$filter_total_records =  $this->db->count_all_results();

			if(isset($keyword) && !empty($keyword)) {
                $this->db->group_start()
                        ->like('order_details.file_number', $keyword)
                        ->or_like('pct_order_documents.document_name', $keyword)
                        ->group_end();
			}

            $this->db->select('order_details.file_id, order_details.lp_report_status, order_details.lp_file_number, order_details.file_number, pct_order_documents.document_name, pct_order_documents.api_document_id, pct_order_documents.created');
            $this->db->from('order_details')
                ->join('pct_order_documents', 'order_details.id = pct_order_documents.order_id');
            $this->db->where('pct_order_documents.is_pre_listing_report_doc', 1);
            $this->db->order_by('pct_order_documents.id', 'desc');

            if ((isset($limit) && !empty($limit)) || (isset($offset) && !empty($offset))) {
                $this->db->limit($limit, $offset);
            }	
			$query = $this->db->get();
			if ($query->num_rows() > 0) {
	            $grant_document_lists = $query->result_array();
	        }
    	} else {    		

    		$this->db->from('order_details')
                ->join('pct_order_documents', 'order_details.id = pct_order_documents.order_id');
            $this->db->where('pct_order_documents.is_pre_listing_report_doc', 1);
            $filter_total_records =  $this->db->count_all_results();

            $this->db->select('order_details.file_id, order_details.lp_report_status, order_details.lp_file_number, order_details.file_number, pct_order_documents.document_name, pct_order_documents.api_document_id, pct_order_documents.created');
            $this->db->from('order_details')
                ->join('pct_order_documents', 'order_details.id = pct_order_documents.order_id');
            $this->db->where('pct_order_documents.is_pre_listing_report_doc', 1);
            $this->db->order_by('pct_order_documents.id', 'desc');

			if ((isset($limit) && !empty($limit)) || (isset($offset) && !empty($offset))) {
                $this->db->limit($limit, $offset);
            }

			$query = $this->db->get();
			if ($query->num_rows() > 0) {
	            $grant_document_lists = $query->result_array();
	        } 
    	}

    	return array(
            'recordsTotal' => $total_records,
            'recordsFiltered' => $filter_total_records,
            'data' => $grant_document_lists
        );
    }

    public function get_admin_user_logs($params)
    {
        $this->db->from('admin')
                 ->join('pct_admin_activity_logs', 'pct_admin_activity_logs.user_id = admin.id');
        $total_records =  $this->db->count_all_results();
    
		$limit = isset($params['length']) && !empty($params['length']) ? $params['length'] : '';
        $offset = isset($params['start']) && !empty($params['start']) ? $params['start'] : '';
        $admin_logs_list = array();

    	if (isset($params['searchvalue']) && !empty($params['searchvalue'])) {
    		$keyword = $params['searchvalue'];

    		if (isset($keyword) && !empty($keyword)) {
                $this->db->group_start()
                        ->like('admin.first_name', $keyword)
                        ->or_like('admin.last_name', $keyword)
                        ->or_like('pct_admin_activity_logs.message', $keyword)
                        ->group_end();
               
            }

            $this->db->from('admin')
                 ->join('pct_admin_activity_logs', 'pct_admin_activity_logs.user_id = admin.id');
			$filter_total_records =  $this->db->count_all_results();

			if(isset($keyword) && !empty($keyword)) {
                $this->db->group_start()
                        ->like('admin.first_name', $keyword)
                        ->or_like('admin.last_name', $keyword)
                        ->or_like('pct_admin_activity_logs.message', $keyword)
                        ->group_end();
			}

            $this->db->select('admin.first_name, admin.last_name, pct_admin_activity_logs.message, pct_admin_activity_logs.created_at');
            $this->db->from('admin')
                 ->join('pct_admin_activity_logs', 'pct_admin_activity_logs.user_id = admin.id');
            $this->db->order_by('pct_admin_activity_logs.id', 'desc');

            if ((isset($limit) && !empty($limit)) || (isset($offset) && !empty($offset))) {
                $this->db->limit($limit, $offset);
            }	
			$query = $this->db->get();
			if ($query->num_rows() > 0) {
	            $admin_logs_list = $query->result_array();
	        }
    	} else {    		
    		$this->db->from('admin')
                 ->join('pct_admin_activity_logs', 'pct_admin_activity_logs.user_id = admin.id');
            $filter_total_records =  $this->db->count_all_results();

            $this->db->select('admin.first_name, admin.last_name, pct_admin_activity_logs.message, pct_admin_activity_logs.created_at');
            $this->db->from('admin')
                 ->join('pct_admin_activity_logs', 'pct_admin_activity_logs.user_id = admin.id');
            $this->db->order_by('pct_admin_activity_logs.id', 'desc');

			if ((isset($limit) && !empty($limit)) || (isset($offset) && !empty($offset))) {
                $this->db->limit($limit, $offset);
            }

			$query = $this->db->get();
			if ($query->num_rows() > 0) {
	            $admin_logs_list = $query->result_array();
	        } 
    	}

    	return array(
            'recordsTotal' => $total_records,
            'recordsFiltered' => $filter_total_records,
            'data' => $admin_logs_list
        );
    }

    public function get_lp_document_list($params)
    {
        $orderColumnList = [
            0 => 'doc_type',
            1 => 'doc_type',
            2 => 'doc_type_description',
            3 => 'doc_sub_type',
            4 => 'sub_type_list',
        ];
    	$this->db->from('pct_lp_document_types');
		$total_records =  $this->db->count_all_results();
		$limit = isset($params['length']) && !empty($params['length']) ? $params['length'] : '';
        $offset = isset($params['start']) && !empty($params['start']) ? $params['start'] : '';
        $orderBy = $orderColumnList[$params['orderColumn']];
        $orderDir = $params['orderDir'];
        $lp_document_lists =array();
        
        if (isset($params['searchvalue']) && !empty($params['searchvalue'])) {
    		$keyword = $params['searchvalue'];

    		if (isset($keyword) && !empty($keyword)) {
                $this->db->group_start()
                    ->like("doc_type_description", $keyword)
                    // ->or_like('doc_sub_type_description',$keyword)
                    ->or_like('doc_type',$keyword)
                    ->or_like('sub_type_list', $keyword)
                    ->group_end();
			}
            $this->db->from('pct_lp_document_types');
            // $this->db->where('subtype_flag', 0);
            if((isset($params['is_display']))) {
                $this->db->where('is_display', $params['is_display']);
            }
			$filter_total_records =  $this->db->count_all_results();
			if (isset($keyword) && !empty($keyword)) {
                $this->db->group_start()
                    ->like("doc_type_description", $keyword)
                    // ->or_like('doc_sub_type_description',$keyword)
                    ->or_like('doc_type',$keyword)
                    ->or_like('sub_type_list', $keyword)
                    ->group_end();
			}
            // $this->db->where('subtype_flag', 0);
            if((isset($params['is_display']))) {
                $this->db->where('is_display', $params['is_display']);
            }

            if((isset($limit) && !empty($limit)) || (isset($offset) && !empty($offset))) {
                $this->db->limit($limit, $offset);
            }
            $this->db->order_by($orderBy, $orderDir);
			$query = $this->db->get('pct_lp_document_types');
			if ($query->num_rows() > 0) {
	            $lp_document_lists = $query->result_array();
	        }
    	} else {    		
	    	$this->db->from('pct_lp_document_types');
            // $this->db->where('subtype_flag', 0);
            if((isset($params['is_display']))) {
                $this->db->where('is_display', $params['is_display']);
            }
            $filter_total_records =  $this->db->count_all_results();
            // $this->db->where('subtype_flag', 0);
            if((isset($params['is_display']))) {
                $this->db->where('is_display', $params['is_display']);
            }
			if ((isset($limit) && !empty($limit)) || (isset($offset) && !empty($offset))) {
                $this->db->limit($limit, $offset);
            }
            $this->db->order_by($orderBy, $orderDir);
			$query = $this->db->get('pct_lp_document_types');
			if ($query->num_rows() > 0) {
	            $lp_document_lists = $query->result_array();
	        } 
    	}
    	return array(
            'recordsTotal' => $total_records,
            'recordsFiltered' => $filter_total_records,
            'data' => $lp_document_lists
        );
    }

    public function get_lp_alert_list($params)
    {
    	$this->db->from('pct_lp_alert');
		$total_records =  $this->db->count_all_results();
		$limit = isset($params['length']) && !empty($params['length']) ? $params['length'] : '';
        $offset = isset($params['start']) && !empty($params['start']) ? $params['start'] : '';
        // $orderDir = $params['orderDir'];
        $lp_alert =array();
        
        if (isset($params['searchvalue']) && !empty($params['searchvalue'])) {
    		$keyword = $params['searchvalue'];

    		if (isset($keyword) && !empty($keyword)) {
                $this->db->group_start()
                    ->like("days", $keyword)
                    ->or_like('color_code',$keyword)
                    ->group_end();
			}
            $this->db->from('pct_lp_alert');
            
			$filter_total_records =  $this->db->count_all_results();
			if (isset($keyword) && !empty($keyword)) {
                $this->db->group_start()
                    ->like("days", $keyword)
                    ->or_like('color_code',$keyword)
                    ->group_end();
			}

            if((isset($limit) && !empty($limit)) || (isset($offset) && !empty($offset))) {
                $this->db->limit($limit, $offset);
            }
            $this->db->order_by('days', 'asc');
			$query = $this->db->get('pct_lp_alert');
			if ($query->num_rows() > 0) {
	            $lp_alert = $query->result_array();
	        }
    	} else {    		
	    	$this->db->from('pct_lp_alert');
            $filter_total_records =  $this->db->count_all_results();
			if ((isset($limit) && !empty($limit)) || (isset($offset) && !empty($offset))) {
                $this->db->limit($limit, $offset);
            }
            $this->db->order_by('days', 'asc');
			$query = $this->db->get('pct_lp_alert');
			if ($query->num_rows() > 0) {
	            $lp_alert = $query->result_array();
	        } 
    	}
    	return array(
            'recordsTotal' => $total_records,
            'recordsFiltered' => $filter_total_records,
            'data' => $lp_alert
        );
    }

    public function getSubtypeLPDocumentList()
    {
        $this->db->select('id,doc_type');
        $this->db->from('pct_lp_document_types');
        $this->db->where('subtype_flag', 1);
        $query = $this->db->get();
        return $query->result_array();
    }
    public function insertLpDocType($data = array(), $table = '') 
    {
        if (empty($table)) {
            $table = 'pct_lp_document_types';
        }
        if(!empty($data)){

        	$data['created_at'] = date("Y-m-d H:i:s");

            // Insert data
            $insert = $this->db->insert($table, $data);
            
            // Return the status
            return $insert?$this->db->insert_id():false;
        }
        return false;
    }

    public function insertLpAlert($data = array(), $table = '') 
    {
        if (empty($table)) {
            $table = 'pct_lp_alert';
        }
        if(!empty($data)){
        	$data['created_at'] = date("Y-m-d H:i:s");

            // Insert data
            $insert = $this->db->insert($table, $data);
            
            // Return the status
            return $insert?$this->db->insert_id():false;
        }
        return false;
    }

    public function deleteLpDocType($condition = array(), $table = '') 
    {
        if (empty($table)) {
            $table = 'pct_lp_document_types';
        }
        if(!empty($condition)){
            // Delete data
            return $this->db->delete($table, $condition);
        }
        return false;
    }

    public function deleteLpAlert($condition = array(), $table = '') 
    {
        if (empty($table)) {
            $table = 'pct_lp_alert';
        }
        if(!empty($condition)){
            // Delete data
            return $this->db->delete($table, $condition);
        }
        return false;
    }

    public function getLpDocType($params = array())
    {
        $this->db->select('*');
        $this->db->from('pct_lp_document_types');
        
        if (array_key_exists("where", $params)){
            foreach($params['where'] as $key => $val){
                $this->db->where($key, $val);
            }
        }
        
        if (array_key_exists("id", $params)){
            $this->db->where('id', $params['id']);
            $query = $this->db->get();
            $result = $query->row_array();
        }
        // Return fetched data
        return $result;
    }

    public function getLpAlert($params = array())
    {
        $this->db->select('*');
        $this->db->from('pct_lp_alert');
        
        if (array_key_exists("where", $params)){
            foreach($params['where'] as $key => $val){
                $this->db->where($key, $val);
            }
        }
        
        if (array_key_exists("id", $params)){
            $this->db->where('id', $params['id']);
            $query = $this->db->get();
            $result = $query->row_array();
        }
        // Return fetched data
        return $result;
    }

    public function updateLpDocType($data, $condition = array(), $table = '') 
    {
        if (empty($table)) {
            $table = 'pct_lp_document_types';
        }

        if(!empty($condition)){
            // Update data
            $data['updated_at'] = date("Y-m-d H:i:s");

            // Update data
            $update = $this->db->update($table, $data, $condition);
            
            // Return the status
            return $update?true:false;
        }
        return false;
    }

    public function updateLpAlert($data, $condition = array(), $table = '') 
    {
        if (empty($table)) {
            $table = 'pct_lp_alert';
        }

        if(!empty($condition)){
            // Update data
            $data['updated_at'] = date("Y-m-d H:i:s");

            // Update data
            $update = $this->db->update($table, $data, $condition);
            
            // Return the status
            return $update?true:false;
        }
        return false;
    }
    
    public function getDocumetTypes()
    {
        $this->db->select('*')
            ->from('pct_lp_document_types');
            
        $this->db->where('is_display', 1);
        //$this->db->where('is_notice', 0);
        //$this->db->group_by('doc_type');
        $query = $this->db->get();
        if ($query->num_rows() > 0)  {
            return $query->result_array();
        } else {
            return array();
        }         
    }

    public function getNoticeDocumetTypes()
    {
        $this->db->select('*')
            ->from('pct_lp_document_types');
            
        $this->db->where('is_display', 1);
        // $this->db->where('is_notice', 1);
        $this->db->group_by('doc_type');
        $query = $this->db->get();
        if ($query->num_rows() > 0)  {
            return $query->result_array();
        } else {
            return array();
        }         
    }

    public function getSectionWiseLPDocumentList($section)
    {
        $this->db->select('doc_type');
        $this->db->from('pct_lp_document_types');
        $this->db->where('display_in_section', $section);
        $this->db->where('is_display', 1);
        $query = $this->db->get();
        return $query->result_array();
    }

    public function getSalesRepDetails($params)
    {
        $table = $this->table;

        $this->db->select('*');
        $this->db->from($table);
        
        if(array_key_exists("where", $params)){
            foreach($params['where'] as $key => $val){
                $this->db->where($key, $val);
            }
        }
        
        if(array_key_exists("returnType",$params) && $params['returnType'] == 'count'){
            $result = $this->db->count_all_results();
        }else{
            if(array_key_exists("id", $params)){
                $this->db->where('id', $params['id']);
                $query = $this->db->get();
                $result = $query->row_array();
            }
            else
            {
                $this->db->order_by('first_name', 'asc');
                if(array_key_exists("start",$params) && array_key_exists("limit",$params))
                {
                    $this->db->limit($params['limit'],$params['start']);
                }
                elseif(!array_key_exists("start",$params) && array_key_exists("limit",$params))
                {
                    $this->db->limit($params['limit']);
                }
                $query = $this->db->get();              
                $result = ($query->num_rows() > 0)?$query->result_array():FALSE;
            }
        }
        // Return fetched data
        return $result;
    }

    public function getTitleOfficerDetails($params)
    {
        $table = $this->table;

        $this->db->select('*,CONCAT(first_name, " ", last_name) as name');
        $this->db->from($table);
        $this->db->where('is_title_officer', 1);
        
        if(array_key_exists("where", $params)){
            foreach($params['where'] as $key => $val){
                $this->db->where($key, $val);
            }
        }
        
        if(array_key_exists("returnType",$params) && $params['returnType'] == 'count'){
            $result = $this->db->count_all_results();
        }else{
            if(array_key_exists("id", $params)){
                $this->db->where('id', $params['id']);
                $query = $this->db->get();
                $result = $query->row_array();
            }
            else
            {
                $this->db->order_by('id', 'asc');
                if(array_key_exists("start",$params) && array_key_exists("limit",$params))
                {
                    $this->db->limit($params['limit'],$params['start']);
                }
                elseif(!array_key_exists("start",$params) && array_key_exists("limit",$params))
                {
                    $this->db->limit($params['limit']);
                }
                $query = $this->db->get();              
                $result = ($query->num_rows() > 0)?$query->result_array():FALSE;
            }
        }
        // Return fetched data
        return $result;
    }
}
