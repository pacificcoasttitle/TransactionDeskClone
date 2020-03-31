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
		self::$CI = $this->CI;
    }

    public function get_orders($params)
    {
        $this->CI->db->select('order_details.file_number, order_details.file_id,property_details.full_address')
            ->from('order_details')
            ->join('property_details', 'order_details.property_id = property_details.id');
        $total_records =  $this->CI->db->count_all_results();
       
		$limit = isset($params['length']) && !empty($params['length']) ? $params['length'] : '';
        $offset = isset($params['start']) && !empty($params['start']) ? $params['start'] : '';
        $orders_lists = array();
       
        $this->CI->db->select('order_details.file_number, order_details.file_id,property_details.full_address')
            ->from('order_details')
            ->join('property_details', 'order_details.property_id = property_details.id');

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
        $this->CI->db->select('order_details.file_number, order_details.file_id,property_details.full_address')
        ->from('order_details')
        ->join('property_details', 'order_details.property_id = property_details.id');
        $this->CI->db->where('file_id', $fileId);
        $query = $this->CI->db->get();
        return $query->row_array();
    }
}
