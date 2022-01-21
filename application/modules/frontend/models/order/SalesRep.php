<?php
class SalesRep extends CI_Model 
{
	function __construct() {
        // Set table name
        $this->table = 'pct_order_sales_rep';
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

    public function getSummaryDetailsForSalesRep()
    {
        $userdata = $this->session->userdata('user');
        $this->db->select('order_details.file_id, 
            order_details.file_number, 
            order_details.customer_id, 
            order_details.id as order_id,
            order_details.resware_status, 
            property_details.full_address,
            customer_basic_details.email_address as sales_email,
            CONCAT_WS(" ", customer_basic_details.first_name, customer_basic_details.last_name) as sales_name,
            CONCAT_WS(" ", user_details.first_name, user_details.last_name) as name,
            user_details.email_address, 
            user_details.company_name, 
            transaction_details.sales_representative');
        $this->db->from('order_details');
        $this->db->where('YEAR(order_details.sent_to_accounting_date)', '2020'); 
        $this->db->where('transaction_details.sales_representative', $userdata['id']);
        $this->db->where('customer_basic_details.email_address != ""');
        $this->db->join('property_details', 'order_details.property_id = property_details.id','inner');
        $this->db->join('transaction_details', 'order_details.transaction_id = transaction_details.id','inner');
        $this->db->join('customer_basic_details', 'customer_basic_details.id = transaction_details.sales_representative','inner');
        $this->db->join('customer_basic_details as user_details', 'user_details.id = order_details.customer_id','inner');
        $this->db->order_by('transaction_details.sales_representative asc, order_details.customer_id asc'); 
        $query = $this->db->get();
        return $query->result_array(); 
    }
}