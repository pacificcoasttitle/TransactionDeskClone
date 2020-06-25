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
            ->join('pct_order_product_types', 'transaction_details.purchase_type = pct_order_product_types.product_type_id AND pct_order_product_types.status=1')
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
            $this->db->select('order_details.file_number, order_details.file_id,property_details.full_address,order_details.id,transaction_details.sales_representative,transaction_details.purchase_type,pct_order_sales_rep.name as sales_rep_name,pct_order_product_types.product_type')
            ->from('order_details')
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
            $this->db->select('order_details.file_number, order_details.file_id,property_details.full_address,order_details.id,transaction_details.sales_representative,transaction_details.purchase_type,pct_order_sales_rep.name as sales_rep_name,pct_order_product_types.product_type')
            ->from('order_details')
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
            order_details.westcor_order_id,
            order_details.westcor_cpl_id, 
            order_details.westcor_buyer_id,
            order_details.westcor_seller_id, 
            order_details.westcor_secondary_buyer_id,
            order_details.westcor_secondary_seller_id,
            order_details.westcor_lender_id,
            order_details.is_regenerate_cpl,
            order_details.created_at as opened_date, 
            order_details.fnf_agent_id,
            order_details.fnf_document_id,
            property_details.id as property_id, 
            property_details.address, 
            property_details.full_address, 
            property_details.apn, 
            property_details.property_type, 
            property_details.city as property_city, 
            property_details.state as property_state, 
            property_details.zip as property_zip, 
            property_details.county, 
            property_details.westcor_property_id, 
            property_details.legal_description, 
            property_details.primary_owner,
            property_details.secondary_owner,
            property_details.escrow_lender_id,
            property_details.buyer_agent_id,
            transaction_details.id as transaction_id,
            transaction_details.sales_representative,
            pct_order_sales_rep.name as sales_rep_name,
            transaction_details.title_officer,
            pct_order_title_officer.name as title_officer_name,
            transaction_details.sales_amount,
            transaction_details.loan_amount,
            transaction_details.loan_number,
            transaction_details.escrow_number,
            transaction_details.transaction_type, 
            transaction_details.title_officer,
            transaction_details.purchase_type,
            pct_order_product_types.product_type,
            transaction_details.supplemental_report_date,
            transaction_details.preliminary_report_date,
            transaction_details.borrower, 
            CONCAT_WS(",",transaction_details.additional_email,transaction_details.additional_email_1,transaction_details.additional_email_2) as additional_emails, 
            transaction_details.secondary_borrower,
            customer_basic_details.id as lender_id,
            customer_basic_details.street_address as lender_address,
            customer_basic_details.city as lender_city,
            customer_basic_details.state as lender_state,
            customer_basic_details.zip_code as lender_zipcode,
            customer_basic_details.company_name as lender_company_name,
            customer_basic_details.first_name as lender_first_name,
            customer_basic_details.last_name as lender_last_name,
            customer_basic_details.email_address as lender_email,
            customer_basic_details.telephone_no as lender_telephone_no,
            agents.name as agent_name,
            agents.address as agent_address,
            agents.city as agent_city,
            agents.zipcode as agent_zipcode,
            agents.telephone_no as agent_telephone_no,
            pct_order_fnf_agents.agent_number,
            pct_order_fnf_agents.underwriter_code,
            pct_order_fnf_agents.underwriter')
            ->from('order_details')
            ->join('property_details', 'order_details.property_id = property_details.id')
            ->join('transaction_details', 'order_details.transaction_id = transaction_details.id')
            ->join('customer_basic_details', 'property_details.escrow_lender_id = customer_basic_details.id', 'left')
            ->join('agents', 'property_details.buyer_agent_id = agents.id', 'left')
            ->join('pct_order_fnf_agents', 'order_details.fnf_agent_id = pct_order_fnf_agents.id', 'left')
            ->join('pct_order_sales_rep', 'transaction_details.sales_representative = pct_order_sales_rep.id')
            ->join('pct_order_title_officer', 'transaction_details.title_officer = pct_order_title_officer.id')
            ->join('pct_order_product_types', 'transaction_details.purchase_type = pct_order_product_types.product_type_id AND pct_order_product_types.status=1');
        $this->db->where('file_id', $fileId);
         
        
        $query = $this->db->get();
        
        return $query->row_array();
    }
}
