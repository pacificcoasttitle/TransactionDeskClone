<?php
class Order_model extends CI_Model 
{

	function __construct() {
        // Set table name
        $this->table = 'order_details';
    }
	

    public function get_orders($params)
    {
        $sales_rep = isset($params['sales_rep']) && !empty($params['sales_rep']) ? $params['sales_rep'] : '';
        if(isset($params['searchValue']) && !empty($params['searchValue']))
        {
            $keyword = $params['searchValue'];

            if(isset($keyword) && !empty($keyword))
            {
                // $this->db->where('property_details.full_address', $keyword);            
                $this->db->or_like('order_details.file_number', $keyword);
            }
            if(isset($sales_rep) && !empty($sales_rep))
            {
                $this->db->where('transaction_details.sales_representative', $sales_rep);
            }
            $this->db->select('order_details.file_number, order_details.file_id,property_details.full_address,order_details.id,transaction_details.sales_representative,transaction_details.purchase_type,pct_order_sales_rep.name as sales_rep_name,pct_order_product_types.product_type')
            ->from('order_details')
            ->join('property_details', 'order_details.property_id = property_details.id')
            ->join('transaction_details', 'order_details.transaction_id = transaction_details.id')
            ->join('pct_order_sales_rep', 'transaction_details.sales_representative = pct_order_sales_rep.id')
            ->join('pct_order_product_types', 'transaction_details.purchase_type = pct_order_product_types.id')
            ->where('is_imported=0');
            $total_records =  $this->db->count_all_results();
            
            if(isset($keyword) && !empty($keyword))
            {
               // $this->db->like('property_details.full_address', $keyword);            
                $this->db->or_like('order_details.file_number', $keyword);
            }
            if(isset($sales_rep) && !empty($sales_rep))
            {
                $this->db->where('transaction_details.sales_representative', $sales_rep);
            }
            $limit = isset($params['length']) && !empty($params['length']) ? $params['length'] : '';
            $offset = isset($params['start']) && !empty($params['start']) ? $params['start'] : '';
            $orders_lists = array();
           
            $this->db->select('order_details.file_number, order_details.file_id,property_details.full_address,order_details.id,transaction_details.sales_representative,transaction_details.purchase_type,pct_order_sales_rep.name as sales_rep_name,pct_order_product_types.product_type')
            ->from('order_details')
            ->join('property_details', 'order_details.property_id = property_details.id')
            ->join('transaction_details', 'order_details.transaction_id = transaction_details.id')
            ->join('pct_order_sales_rep', 'transaction_details.sales_representative = pct_order_sales_rep.id')
            ->join('pct_order_product_types', 'transaction_details.purchase_type = pct_order_product_types.id')
            ->where('is_imported=0');
            $this->db->order_by("order_details.id", "desc");

            if ((isset($limit) && !empty($limit)) || (isset($offset) && !empty($offset))) {
                $this->db->limit($limit, $offset);
            }

            $query = $this->db->get();

            if ($query->num_rows() > 0)  {
                $orders_lists = $query->result_array();
            }
        }
        else
        {
            if(isset($sales_rep) && !empty($sales_rep))
            {
                $this->db->where('transaction_details.sales_representative', $sales_rep);
            }
            $this->db->select('order_details.file_number, order_details.file_id,property_details.full_address,order_details.id,transaction_details.sales_representative,transaction_details.purchase_type,pct_order_sales_rep.name as sales_rep_name,pct_order_product_types.product_type')
            ->from('order_details')
            ->join('property_details', 'order_details.property_id = property_details.id')
            ->join('transaction_details', 'order_details.transaction_id = transaction_details.id')
            ->join('pct_order_sales_rep', 'transaction_details.sales_representative = pct_order_sales_rep.id')
            ->join('pct_order_product_types', 'transaction_details.purchase_type = pct_order_product_types.id')
            ->where('is_imported=0');
       
            $total_records =  $this->db->count_all_results();
           
            $limit = isset($params['length']) && !empty($params['length']) ? $params['length'] : '';
            $offset = isset($params['start']) && !empty($params['start']) ? $params['start'] : '';
            $orders_lists = array();
            if(isset($sales_rep) && !empty($sales_rep))
            {
                $this->db->where('transaction_details.sales_representative', $sales_rep);
            }
            $this->db->select('order_details.file_number, order_details.file_id,property_details.full_address,order_details.id,transaction_details.sales_representative,transaction_details.purchase_type,pct_order_sales_rep.name as sales_rep_name,pct_order_product_types.product_type')
            ->from('order_details')
            ->join('property_details', 'order_details.property_id = property_details.id')
            ->join('transaction_details', 'order_details.transaction_id = transaction_details.id')
            ->join('pct_order_sales_rep', 'transaction_details.sales_representative = pct_order_sales_rep.id')
            ->join('pct_order_product_types', 'transaction_details.purchase_type = pct_order_product_types.id')
            ->join('pct_order_product_types', 'transaction_details.purchase_type = pct_order_product_types.id')
            ->where('is_imported=0');

            $this->db->order_by("order_details.id", "desc");

            if ((isset($limit) && !empty($limit)) || (isset($offset) && !empty($offset))) {
                $this->db->limit($limit, $offset);
            }

            $query = $this->db->get();

            if ($query->num_rows() > 0)  {
                $orders_lists = $query->result_array();
            } 
        }
        
        return array(
            'recordsTotal' => $total_records,
            'recordsFiltered' => $total_records,
            'data' => $orders_lists
        );
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
}
