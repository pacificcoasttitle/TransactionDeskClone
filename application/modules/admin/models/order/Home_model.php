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
        $this->db->where('password', md5($password));
        $this->db->where('status', 1);
        $query = $this->db->get('admin');

        if ($query->num_rows() > 0) 
        {
            return $query->row_array();
        } 
        else 
        {
            return false;
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
                $this->db->where("CONCAT_WS(' ',first_name,last_name) LIKE '%".$keyword."%'", NULL, FALSE);
                $this->db->or_like('email_address',$keyword);
				// $this->db->like('first_name', $keyword);
			}

            $this->db->where('status', 1);
			$this->db->where('is_escrow', $is_escrow);
	    	$this->db->from('customer_basic_details');
			$filter_total_records =  $this->db->count_all_results();


			if(isset($keyword) && !empty($keyword))
			{
                $this->db->where("CONCAT_WS(' ',first_name,last_name) LIKE '%".$keyword."%'", NULL, FALSE);
                $this->db->or_like('email_address',$keyword);
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

    public function get_rows($params = array())
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


    public function update($data, $condition = array()) 
    {
    	$table = $this->table;

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

    public function insert($data = array()) 
    {
    	$table = $this->table;
        if(!empty($data)){

        	$data['created_at'] = date("Y-m-d H:i:s");

            // Insert data
            $insert = $this->db->insert($table, $data);
            
            // Return the status
            return $insert?$this->db->insert_id():false;
        }
        return false;
    }

    public function get_user_with_duplicate_email()
    {
        $query = $this->db->query('SELECT * FROM customer_basic_details WHERE email_address IN (
        SELECT email_address FROM customer_basic_details
        GROUP BY email_address HAVING COUNT(*) > 1 
        ) ORDER BY email_address ASC');

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

            $this->db->from('order_details')
                ->join('pct_order_documents', 'order_details.id = pct_order_documents.order_id');
            $this->db->where('pct_order_documents.is_cpl_doc', 1);

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

            $this->db->from('order_details')
                ->join('pct_order_documents', 'order_details.id = pct_order_documents.order_id');
            $this->db->where('pct_order_documents.is_cpl_doc', 1);

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
            $this->db->where('is_new_user', 1);
	    	$this->db->from('customer_basic_details');
            $filter_total_records =  $this->db->count_all_results();

            $this->db->where('is_new_user', 1);
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

            $this->db->from('order_details')
                ->join('pct_order_documents', 'order_details.id = pct_order_documents.order_id');
            $this->db->where('pct_order_documents.is_grant_doc', 1);

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

            $this->db->from('order_details')
                ->join('pct_order_documents', 'order_details.id = pct_order_documents.order_id');
            $this->db->where('pct_order_documents.is_grant_doc', 1);

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

            $this->db->from('order_details')
                ->join('pct_order_documents', 'order_details.id = pct_order_documents.order_id');
            $this->db->where('pct_order_documents.is_lv_doc', 1);

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

            $this->db->from('order_details')
                ->join('pct_order_documents', 'order_details.id = pct_order_documents.order_id');
            $this->db->where('pct_order_documents.is_lv_doc', 1);

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
}
