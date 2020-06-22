<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class Order 
{
    public static $CI;
    
	public function __construct($params = array())
	{
		$this->CI =& get_instance();                        
		$this->CI->load->database();
        $this->CI->load->library('email');
        $this->CI->load->library('session');
		self::$CI = $this->CI;
    }

    public function get_recent_orders()
    {
        $userdata = $this->CI->session->userdata('user');
        $this->CI->db->select('order_details.file_number, order_details.file_id, property_details.full_address,order_details.id, order_details.westcor_order_id, order_details.westcor_file_id, order_details.westcor_cpl_id, order_details.created_at, property_details.primary_owner')
            ->from('order_details')
            ->join('property_details', 'order_details.property_id = property_details.id');

        if ($userdata['is_master'] == 0) {
            $this->CI->db->where('order_details.customer_id', $userdata['id']);
        }
        $this->CI->db->order_by("order_details.created_at", "desc");
        $this->CI->db->limit(10);
        $query = $this->CI->db->get();

        if ($query->num_rows() > 0)  {
            return $query->result_array();
        } else {
            return array();
        } 
    }

    public function get_orders($params)
    {
        $userdata = $this->CI->session->userdata('user');
        if(isset($params['searchvalue']) && !empty($params['searchvalue']))
        {
            $keyword = $params['searchvalue'];

            if(isset($keyword) && !empty($keyword))
            {
                $this->CI->db->like('property_details.full_address', $keyword);            
                $this->CI->db->or_like('order_details.file_number', $keyword);
            }
            $this->CI->db->select('order_details.prelim_summary_id, order_details.file_number, order_details.file_id,property_details.full_address,order_details.id, order_details.westcor_order_id, order_details.westcor_file_id, order_details.westcor_cpl_id, property_details.escrow_lender_id, order_details.is_regenerate_cpl, order_details.cpl_document_name, order_details.cpl_document_name')
            ->from('order_details')
            ->join('property_details', 'order_details.property_id = property_details.id');
            if ($userdata['is_master'] == 0) {
                $this->CI->db->where('order_details.customer_id', $userdata['id']);
            }
            $total_records =  $this->CI->db->count_all_results();
            
            if(isset($keyword) && !empty($keyword))
            {
                $this->CI->db->like('property_details.full_address', $keyword);            
                $this->CI->db->or_like('order_details.file_number', $keyword);
            }
            $limit = isset($params['length']) && !empty($params['length']) ? $params['length'] : '';
            $offset = isset($params['start']) && !empty($params['start']) ? $params['start'] : '';
            $orders_lists = array();
           
            $this->CI->db->select('order_details.prelim_summary_id, order_details.file_number, order_details.file_id,property_details.full_address,order_details.id, order_details.westcor_order_id, order_details.westcor_file_id, order_details.westcor_cpl_id, order_details.cpl_document_name, order_details.cpl_document_name')
                ->from('order_details')
                ->join('property_details', 'order_details.property_id = property_details.id');

            if ($userdata['is_master'] == 0) {
                $this->CI->db->where('order_details.customer_id', $userdata['id']);
            }
            $this->CI->db->order_by("order_details.id", "desc");

            if ((isset($limit) && !empty($limit)) || (isset($offset) && !empty($offset))) {
                $this->CI->db->limit($limit, $offset);
            }

            $query = $this->CI->db->get();

            if ($query->num_rows() > 0)  {
                $orders_lists = $query->result_array();
            }
        }
        else
        {
            $this->CI->db->select('order_details.prelim_summary_id, order_details.file_number, order_details.file_id,property_details.full_address,order_details.id, order_details.westcor_order_id, order_details.westcor_file_id, order_details.westcor_cpl_id, property_details.escrow_lender_id, order_details.is_regenerate_cpl, order_details.cpl_document_name, order_details.cpl_document_name')
            ->from('order_details')
            ->join('property_details', 'order_details.property_id = property_details.id');

            if ($userdata['is_master'] == 0) {
                $this->CI->db->where('order_details.customer_id', $userdata['id']);
            }
       
            $total_records =  $this->CI->db->count_all_results();
           
            $limit = isset($params['length']) && !empty($params['length']) ? $params['length'] : '';
            $offset = isset($params['start']) && !empty($params['start']) ? $params['start'] : '';
            $orders_lists = array();
           
            $this->CI->db->select('order_details.prelim_summary_id, order_details.file_number, order_details.file_id,property_details.full_address,order_details.id, order_details.westcor_order_id, order_details.westcor_file_id, order_details.westcor_cpl_id, order_details.cpl_document_name, order_details.cpl_document_name')
                ->from('order_details')
                ->join('property_details', 'order_details.property_id = property_details.id');

            
            if ($userdata['is_master'] == 0) {
                $this->CI->db->where('order_details.customer_id', $userdata['id']);
            }
            $this->CI->db->order_by("order_details.id", "desc");

            if ((isset($limit) && !empty($limit)) || (isset($offset) && !empty($offset))) {
                $this->CI->db->limit($limit, $offset);
            }

            $query = $this->CI->db->get();

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

    public function get_document_types() 
    {
        $this->CI->db->select('*');
        $this->CI->db->from('pct_order_documents_types');
        $query = $this->CI->db->get();
        return $rs = $query->result_array();
    }

    public function get_order_details($fileId)
    {
        $userdata = $this->CI->session->userdata('user');
        $this->CI->db->select('order_details.file_number, 
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
            transaction_details.title_officer,
            transaction_details.sales_amount,
            transaction_details.loan_amount,
            transaction_details.loan_number,
            transaction_details.transaction_type, 
            transaction_details.title_officer,
            transaction_details.purchase_type,
            transaction_details.supplemental_report_date,
            transaction_details.preliminary_report_date,
            transaction_details.borrower, 
            transaction_details.secondary_borrower,
            customer_basic_details.id as lender_id,
            customer_basic_details.street_address as lender_address,
            customer_basic_details.city as lender_city,
            ustomer_basic_details.state as lender_state,
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
            ->join('pct_order_fnf_agents', 'order_details.fnf_agent_id = pct_order_fnf_agents.id', 'left');
        $this->CI->db->where('file_id', $fileId);
         
        if ($userdata['is_master'] == 0) {
            $this->CI->db->where('order_details.customer_id', $userdata['id']);
        }
        $query = $this->CI->db->get();
        
        return $query->row_array();
    }

    public function is_user()
    {
        $userdata = $this->CI->session->userdata('user');
        if (!empty($userdata['id']) && $userdata['is_admin'] == 0) {
            
        } else {
            redirect(base_url().'order/login');
        }
    }
    
    public function get_token()
    {
        $this->CI->db->select('*');
        $this->CI->db->from('pct_order_westcore_token');
        $query = $this->CI->db->get();
        $result = $query->row_array();
        if(!empty($result)) {
            $date = new DateTime($result['create_token_time']);
            $date2 = new DateTime(date('Y-m-d H:i:s'));
            $diff = $date2->getTimestamp() - $date->getTimestamp();
            if($diff < $result['expires_in']) {
                return $result;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    public function get_order_documents($fileId)
    {
        $userdata = $this->CI->session->userdata('user');
        $this->CI->db->select('order_details.file_number, 
                order_details.file_id, 
                order_details.id as order_id, 
                pct_order_documents.document_name, 
                pct_order_documents.original_document_name, 
                pct_order_documents.is_sync, 
                pct_order_documents.is_prelim_document, 
                pct_order_documents.api_document_id, 
                pct_order_documents.is_linked_doc')
            ->from('order_details')
            ->join('pct_order_documents', 'order_details.id = pct_order_documents.order_id');
        $this->CI->db->where('order_details.file_id', $fileId);
        if ($userdata['is_master'] == 0) {
            $this->CI->db->where('order_details.customer_id', $userdata['id']);
        }
        $query = $this->CI->db->get();
        if ($query->num_rows() > 0)  {
            return $query->result_array();
        } else {
            return array();
        }         
    }

    public function update($data, $condition = array()) 
    { 
        $table = 'order_details';

        if(!empty($data))
        {   
            $data['updated_at'] = date("Y-m-d H:i:s");

            // Update data
            $update = $this->CI->db->update($table, $data, $condition);
            // Return the status
            return $update?true:false;
        }
        return false;
    }

    public function get_linked_documents($order_id)
    {
        $this->CI->db->select('*')
            ->from('pct_order_documents');
            
        $this->CI->db->where('order_id', $order_id);
        $this->CI->db->where('is_linked_doc', 1);
        $query = $this->CI->db->get();
        if ($query->num_rows() > 0)  {
            return $query->result_array();
        } else {
            return array();
        }         
    }

    public function get_document_detail($api_document_id)
    {
        $this->CI->db->select('*')
            ->from('pct_order_documents');
        
        $this->CI->db->where('api_document_id', $api_document_id);
        $query = $this->CI->db->get();
        if ($query->num_rows() > 0)  {
            return $query->row_array();
        } else {
            return array();
        }         
    }

    public function get_rows($params = array())
    {
        $table = 'order_details';

        $this->CI->db->select('*');
        $this->CI->db->from($table);
        
        if(array_key_exists("where", $params)){
            foreach($params['where'] as $key => $val){
                $this->CI->db->where($key, $val);
            }
        }
        
        if(array_key_exists("returnType",$params) && $params['returnType'] == 'count'){
            $result = $this->CI->db->count_all_results();
        }else{
            if(array_key_exists("id", $params)){
                $this->CI->db->where('id', $params['id']);
                $query = $this->CI->db->get();
                $result = $query->row_array();
            }else{
                $this->CI->db->order_by('id', 'asc');
                if(array_key_exists("start",$params) && array_key_exists("limit",$params)){
                    $this->CI->db->limit($params['limit'],$params['start']);
                }elseif(!array_key_exists("start",$params) && array_key_exists("limit",$params)){
                    $this->CI->db->limit($params['limit']);
                }
                
                $query = $this->CI->db->get();
                $result = ($query->num_rows() > 0)?$query->row_array():FALSE;
            }
        }
        
        // Return fetched data
        return $result;
    }
       
}
