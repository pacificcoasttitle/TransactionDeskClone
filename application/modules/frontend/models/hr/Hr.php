<?php
class Hr extends CI_Model 
{
    public function get_hr_user($params = array()) 
    {
        $this->db->select('*');
        $this->db->from('pct_hr_users');
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
}
