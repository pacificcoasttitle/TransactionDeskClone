<?php
class Sales_model extends CI_Model 
{

	function __construct() {
        $this->table = 'customer_basic_details';
    }
	
    public function get_sales_reps($params)
    {
        $this->db->where('status', 1);
        $this->db->where('is_sales_rep', 1);
    	$this->db->from('customer_basic_details');
		$total_records =  $this->db->count_all_results();
		$limit = isset($params['length']) && !empty($params['length']) ? $params['length'] : '';
        $offset = isset($params['start']) && !empty($params['start']) ? $params['start'] : '';
        $sales_rep_lists = array();
        
    	if (isset($params['searchvalue']) && !empty($params['searchvalue'])) {
    		$keyword = $params['searchvalue'];
            $this->db->where('status', 1);
            $this->db->where('is_sales_rep', 1);
    		if (isset($keyword) && !empty($keyword)) {
				$this->db->where("CONCAT_WS(' ',first_name,last_name) LIKE '%".$keyword."%'", NULL, FALSE);
                $this->db->or_like('email_address', $keyword);
                $this->db->or_like('telephone_no', $keyword);
            }            
	    	$this->db->from('customer_basic_details');

			$filter_total_records =  $this->db->count_all_results();

            $this->db->where('status', 1);
            $this->db->where('is_sales_rep', 1);
			if (isset($keyword) && !empty($keyword)) {
				$this->db->where("CONCAT_WS(' ',first_name,last_name) LIKE '%".$keyword."%'", NULL, FALSE);
                $this->db->or_like('email_address', $keyword);
                $this->db->or_like('telephone_no', $keyword);
			}
			if ((isset($limit) && !empty($limit)) || (isset($offset) && !empty($offset))) {
                $this->db->limit($limit, $offset);
            }
			$query = $this->db->get('customer_basic_details');
			echo "<pre>"; print_r($this->db->last_query()); exit;
			if ($query->num_rows() > 0) {
                $sales_rep_lists = $query->result_array();
	        }
    	} else {   
            $this->db->where('status', 1); 	
            $this->db->where('is_sales_rep', 1);	
	    	$this->db->from('customer_basic_details');
			$filter_total_records =  $this->db->count_all_results();

            $this->db->where('status', 1);
            $this->db->where('is_sales_rep', 1);
			if ((isset($limit) && !empty($limit)) || (isset($offset) && !empty($offset))) {
                $this->db->limit($limit, $offset);
            }
			$query = $this->db->get('customer_basic_details');

			if ($query->num_rows() > 0) {
	            $sales_rep_lists = $query->result_array();
	        } 
    	}

    	return array(
            'recordsTotal' => $total_records,
            'recordsFiltered' => $filter_total_records,
            'data' => $sales_rep_lists
        );
    }

    public function getSalesRep($params = array())
    {
    	$table = $this->table;
        $this->db->select('*');
        $this->db->from($table);

        if (array_key_exists("where", $params)) {
            foreach($params['where'] as $key => $val){
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
                $result = ($query->num_rows() > 0) ? $query->result_array() : FALSE;
            }
        }
        return $result;
    }

    public function update($data, $condition = array()) 
    {
    	$table = $this->table;
        if (!empty($data)) {          
            $data['updated_at'] = date("Y-m-d H:i:s");
            $update = $this->db->update($table, $data, $condition);
            return $update ? true : false;
        }
        return false;
    }

    public function insert($data = array()) 
    {
    	$table = $this->table;
        if (!empty($data)) {
        	$data['created_at'] = date("Y-m-d H:i:s");
            $insert = $this->db->insert($table, $data);
            return $insert ? $this->db->insert_id() : false;
        }
        return false;
    }
}
