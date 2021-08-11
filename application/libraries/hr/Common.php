<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class Common 
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

    public function is_hr_admin()
    {
        $userdata = $this->CI->session->userdata('hr_admin');
        if (!empty($userdata['id']) && $userdata['is_hr_admin'] == 1) {
            return true;
        } else {
            redirect(base_url().'hr/admin');
        }
    }
}
