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

        $this->CI->db->where('order_details.customer_id', $userdata['id']);
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
        $this->CI->db->select('order_details.file_number, order_details.file_id,property_details.full_address,order_details.id, order_details.westcor_order_id, order_details.westcor_file_id, order_details.westcor_cpl_id, property_details.escrow_lender_id')
            ->from('order_details')
            ->join('property_details', 'order_details.property_id = property_details.id');
        $this->CI->db->where('order_details.customer_id', $userdata['id']);
        $total_records =  $this->CI->db->count_all_results();
       
		$limit = isset($params['length']) && !empty($params['length']) ? $params['length'] : '';
        $offset = isset($params['start']) && !empty($params['start']) ? $params['start'] : '';
        $orders_lists = array();
       
        $this->CI->db->select('order_details.file_number, order_details.file_id,property_details.full_address,order_details.id, order_details.westcor_order_id, order_details.westcor_file_id, order_details.westcor_cpl_id')
            ->from('order_details')
            ->join('property_details', 'order_details.property_id = property_details.id');

        
        $this->CI->db->where('order_details.customer_id', $userdata['id']);
        $this->CI->db->order_by("order_details.id", "desc");

        if ((isset($limit) && !empty($limit)) || (isset($offset) && !empty($offset))) {
            $this->CI->db->limit($limit, $offset);
        }

        $query = $this->CI->db->get();

        if ($query->num_rows() > 0)  {
            $orders_lists = $query->result_array();
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
        $this->CI->db->select('order_details.file_number, 
            order_details.id as order_id,
            order_details.file_id, 
            order_details.westcor_order_id,
            order_details.westcor_cpl_id, 
            order_details.created_at as opened_date, 
            property_details.id as property_id, 
            property_details.full_address, 
            property_details.county, 
            property_details.westcor_property_id, 
            property_details.legal_description, 
            property_details.primary_owner,
            property_details.secondary_owner,
            property_details.escrow_lender_id,
            transaction_details.id as transaction_id,
            transaction_details.sales_amount,
            transaction_details.loan_amount,
            transaction_details.loan_number,
            transaction_details.transaction_type, 
            transaction_details.title_officer,
            transaction_details.purchase_type,
            transaction_details.supplemental_report_date,
            transaction_details.preliminary_report_date,
            transaction_details.borrower, customer_basic_details.*')
            ->from('order_details')
            ->join('property_details', 'order_details.property_id = property_details.id')
            ->join('transaction_details', 'order_details.transaction_id = transaction_details.id')
            ->join('customer_basic_details', 'property_details.escrow_lender_id = customer_basic_details.id', 'left');
        $this->CI->db->where('file_id', $fileId);
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
            $update = $this->db->update($table, $data, $condition);
            
            // Return the status
            return $update?true:false;
        }
        return false;
    }
       
}
