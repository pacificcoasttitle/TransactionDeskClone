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

    public function get_orders()
    {
        $this->CI->db->select('order_details.file_number, order_details.file_id,property_details.full_address')
            ->from('order_details')
            ->join('property_details', 'order_details.property_id = property_details.id');
        $query = $this->CI->db->get();
        return $query->result();
    }
    
}
