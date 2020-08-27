<?php
class Fees_model extends CI_Model 
{
	function __construct() {
        // Set table name
        $this->table = 'pct_order_fees';
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

    public function getFees($params)
    {
        $this->db->where('status', 1);
        $this->db->from($this->table);
        $total_records =  $this->db->count_all_results();


        $limit = isset($params['length']) && !empty($params['length']) ? $params['length'] : '';
        $offset = isset($params['start']) && !empty($params['start']) ? $params['start'] : '';
        
        
        $fees_lists =array();
        if(isset($params['searchvalue']) && !empty($params['searchvalue']))
        {
            $keyword = $params['searchvalue'];

            if(isset($keyword) && !empty($keyword))
            {
                $this->db->like('name', $keyword);
            }
            $this->db->where('status', 1);
               
            $this->db->from($this->table);
            $filter_total_records =  $this->db->count_all_results();


            if(isset($keyword) && !empty($keyword))
            {
                $this->db->like('name', $keyword);
            }

            if((isset($limit) && !empty($limit)) || (isset($offset) && !empty($offset)))
            {
                $this->db->limit($limit, $offset);
            }
            $this->db->order_by('id', 'desc');
            
            $this->db->where('status', 1);
                    
            $query = $this->db->get($this->table);

            if ($query->num_rows() > 0) 
            {
                $fees_lists = $query->result_array();
            }
        }
        else
        {
            $this->db->where('status', 1);
            
            $this->db->from($this->table);

            $filter_total_records =  $this->db->count_all_results();

            
            $this->db->where('status', 1);
            
            if((isset($limit) && !empty($limit)) || (isset($offset) && !empty($offset)))
            {
                $this->db->limit($limit, $offset);
            }
            $this->db->order_by('id', 'desc');
            $query = $this->db->get($this->table);
            
            if ($query->num_rows() > 0) 
            {
                $fees_lists = $query->result_array();
            } 
        }

        return array(
            'recordsTotal' => $total_records,
            'recordsFiltered' => $filter_total_records,
            'data' => $fees_lists
        );
    }


    public function get_rows($params = array())
    {
        $table = $this->table;

        $this->db->select('pct_order_fees.*, pct_order_fees_types.name as fee_type');
        $this->db->from($table);
        
        if(array_key_exists("where", $params)){
            foreach($params['where'] as $key => $val){
                $this->db->where($key, $val);
            }
        }
        
        if(array_key_exists("returnType",$params) && $params['returnType'] == 'count')
        {
            $this->db->join('pct_order_fees_types','pct_order_fees.fee_type_id = pct_order_fees_types.id');
            $result = $this->db->count_all_results();
        }
        else
        {
            if(array_key_exists("id", $params)){
                $this->db->where('id', $params['id']);
                $this->db->join('pct_order_fees_types','pct_order_fees.fee_type_id = pct_order_fees_types.id');
                $query = $this->db->get();
                $result = $query->row_array();
            }else{
                $this->db->order_by('pct_order_fees.id', 'desc');
                if(array_key_exists("start",$params) && array_key_exists("limit",$params)){
                    $this->db->limit($params['limit'],$params['start']);
                }elseif(!array_key_exists("start",$params) && array_key_exists("limit",$params)){
                    $this->db->limit($params['limit']);
                }
                $this->db->join('pct_order_fees_types','pct_order_fees.fee_type_id = pct_order_fees_types.id');
                $query = $this->db->get();
                $result = ($query->num_rows() > 0)?$query->result_array():FALSE;
            }
        }
        
        // Return fetched data
        return $result;
    }
}