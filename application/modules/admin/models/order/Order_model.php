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
        if(isset($sales_rep) && !empty($sales_rep))
        {
            $this->db->where('transaction_details.sales_representative', $sales_rep);
        }

        $created_by = isset($params['created_by']) && !empty($params['created_by']) ? $params['created_by'] : '';
        if(isset($created_by) && !empty($created_by))
        {
            $this->db->where('order_details.created_by', $created_by);
        }
        if(isset($params['searchValue']) && !empty($params['searchValue']))
        {
            $keyword = $params['searchValue'];

            if(isset($keyword) && !empty($keyword))
            {
                $this->db->where("(property_details.full_address LIKE '%".$keyword."%' OR order_details.file_number LIKE '%".$keyword."%')");
            }
            
            $this->db->select('order_details.file_number, order_details.file_id,property_details.full_address,order_details.id,transaction_details.sales_representative,transaction_details.purchase_type,pct_order_sales_rep.name as sales_rep_name,pct_order_product_types.product_type, customer_basic_details.first_name, customer_basic_details.last_name,order_details.created_at')
            ->from('order_details')
            ->join('customer_basic_details', 'customer_basic_details.id = order_details.created_by')
            ->join('property_details', 'order_details.property_id = property_details.id')
            ->join('transaction_details', 'order_details.transaction_id = transaction_details.id')
            ->join('pct_order_sales_rep', 'transaction_details.sales_representative = pct_order_sales_rep.id')
            ->join('pct_order_product_types', 'transaction_details.purchase_type = pct_order_product_types.product_type_id AND pct_order_product_types.status=1')
            ->where('is_imported=0');
            $total_records =  $this->db->count_all_results();
            if(isset($sales_rep) && !empty($sales_rep))
            {
                $this->db->where('transaction_details.sales_representative', $sales_rep);

            }

            $created_by = isset($params['created_by']) && !empty($params['created_by']) ? $params['created_by'] : '';
            if(isset($created_by) && !empty($created_by))
            {
                $this->db->where('order_details.created_by', $created_by);
            }
            if(isset($keyword) && !empty($keyword))
            {
                $this->db->where("(property_details.full_address LIKE '%".$keyword."%' OR order_details.file_number LIKE '%".$keyword."%')");
            }
            
            $limit = isset($params['length']) && !empty($params['length']) ? $params['length'] : '';
            $offset = isset($params['start']) && !empty($params['start']) ? $params['start'] : '';
            $orders_lists = array();
           
            $this->db->select('order_details.file_number, order_details.file_id,property_details.full_address,order_details.id,transaction_details.sales_representative,transaction_details.purchase_type,pct_order_sales_rep.name as sales_rep_name,pct_order_product_types.product_type, customer_basic_details.first_name, customer_basic_details.last_name,order_details.created_at')
            ->from('order_details')
            ->join('customer_basic_details', 'customer_basic_details.id = order_details.created_by')
            ->join('property_details', 'order_details.property_id = property_details.id')
            ->join('transaction_details', 'order_details.transaction_id = transaction_details.id')
            ->join('pct_order_sales_rep', 'transaction_details.sales_representative = pct_order_sales_rep.id')
            ->join('pct_order_product_types', 'transaction_details.purchase_type = pct_order_product_types.product_type_id AND pct_order_product_types.status=1')
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

            $created_by = isset($params['created_by']) && !empty($params['created_by']) ? $params['created_by'] : '';
            if(isset($created_by) && !empty($created_by))
            {
                $this->db->where('order_details.created_by', $created_by);
            }
            $this->db->select('order_details.file_number, order_details.file_id,property_details.full_address,order_details.id,transaction_details.sales_representative,transaction_details.purchase_type,pct_order_sales_rep.name as sales_rep_name,pct_order_product_types.product_type, customer_basic_details.first_name, customer_basic_details.last_name,order_details.created_at')
            ->from('order_details')
            ->join('customer_basic_details', 'customer_basic_details.id = order_details.created_by')
            ->join('property_details', 'order_details.property_id = property_details.id')
            ->join('transaction_details', 'order_details.transaction_id = transaction_details.id')
            ->join('pct_order_sales_rep', 'transaction_details.sales_representative = pct_order_sales_rep.id')
            ->join('pct_order_product_types', 'transaction_details.purchase_type = pct_order_product_types.product_type_id AND pct_order_product_types.status=1')
            ->where('is_imported=0');
       
            $total_records =  $this->db->count_all_results();
           
            $limit = isset($params['length']) && !empty($params['length']) ? $params['length'] : '';
            $offset = isset($params['start']) && !empty($params['start']) ? $params['start'] : '';
            $orders_lists = array();
            if(isset($sales_rep) && !empty($sales_rep))
            {
                $this->db->where('transaction_details.sales_representative', $sales_rep);
            }

            $created_by = isset($params['created_by']) && !empty($params['created_by']) ? $params['created_by'] : '';
            if(isset($created_by) && !empty($created_by))
            {
                $this->db->where('order_details.created_by', $created_by);
            }
            
            $this->db->select('order_details.file_number, order_details.file_id,property_details.full_address,order_details.id,transaction_details.sales_representative,transaction_details.purchase_type,pct_order_sales_rep.name as sales_rep_name,pct_order_product_types.product_type, customer_basic_details.first_name, customer_basic_details.last_name,order_details.created_at')
            ->from('order_details')
            ->join('customer_basic_details', 'customer_basic_details.id = order_details.created_by')
            ->join('property_details', 'order_details.property_id = property_details.id')
            ->join('transaction_details', 'order_details.transaction_id = transaction_details.id')
            ->join('pct_order_sales_rep', 'transaction_details.sales_representative = pct_order_sales_rep.id')
            ->join('pct_order_product_types', 'transaction_details.purchase_type = pct_order_product_types.product_type_id AND pct_order_product_types.status=1')
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

    public function get_order_details($fileId)
    {
        $this->db->select('order_details.file_number, 
            order_details.customer_id,
            order_details.id as order_id,
            order_details.file_id,
            order_details.created_at as opened_date, 
            property_details.id as property_id, 
            property_details.address, 
            property_details.full_address, 
            property_details.apn, 
            property_details.property_type, 
            property_details.city as property_city, 
            property_details.state as property_state, 
            property_details.zip as property_zip, 
            property_details.county,
            property_details.legal_description, 
            property_details.primary_owner,
            property_details.secondary_owner,
            transaction_details.id as transaction_id,
            transaction_details.sales_representative,
            pct_order_sales_rep.name as sales_rep_name,
            transaction_details.title_officer,
            pct_order_title_officer.name as title_officer_name,
            transaction_details.sales_amount,
            transaction_details.loan_amount,
            transaction_details.loan_number,
            transaction_details.escrow_number,
            transaction_details.notes,
            transaction_details.transaction_type, 
            transaction_details.title_officer,
            transaction_details.purchase_type,
            pct_order_product_types.product_type,
            transaction_details.supplemental_report_date,
            transaction_details.preliminary_report_date,
            transaction_details.borrower, 
            CONCAT_WS(",",transaction_details.additional_email,transaction_details.additional_email_1,transaction_details.additional_email_2) as additional_emails,
            transaction_details.additional_email,
            transaction_details.additional_email_1,
            transaction_details.additional_email_2,
            transaction_details.secondary_borrower,
            property_details.escrow_lender_id,
            customer_basic_details.company_name as escrow_lender_company_name,
            customer_basic_details.first_name as escrow_lender_first_name,
            customer_basic_details.last_name as escrow_lender_last_name,
            customer_basic_details.email_address as escrow_lender_email,
            customer_basic_details.telephone_no as escrow_lender_telephone_no,
            property_details.buyer_agent_id,
            agents.name as buyer_agent_name,
            agents.email_address as buyer_agent_email_address,
            agents.company as buyer_agent_company,
            agents.telephone_no as buyer_agent_telephone_no,
            property_details.listing_agent_id,
            a.name as listing_agent_name,
            a.email_address as listing_agent_email_address,
            a.company as listing_agent_company,
            a.telephone_no as listing_agent_telephone_no')
            ->from('order_details')
            ->join('property_details', 'order_details.property_id = property_details.id')
            ->join('transaction_details', 'order_details.transaction_id = transaction_details.id')
            ->join('customer_basic_details', 'property_details.escrow_lender_id = customer_basic_details.id', 'left')
            ->join('agents', 'property_details.buyer_agent_id = agents.id', 'left')
            ->join('agents a', 'property_details.listing_agent_id = a.id', 'left')
            ->join('pct_order_fnf_agents', 'order_details.fnf_agent_id = pct_order_fnf_agents.id', 'left')
            ->join('pct_order_sales_rep', 'transaction_details.sales_representative = pct_order_sales_rep.id')
            ->join('pct_order_title_officer', 'transaction_details.title_officer = pct_order_title_officer.id')
            ->join('pct_order_product_types', 'transaction_details.purchase_type = pct_order_product_types.product_type_id AND pct_order_product_types.status=1');
        $this->db->where('file_id', $fileId);
         
        
        $query = $this->db->get();
        
        return $query->row_array();
    }
}
