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

    public function randomPassword() 
    {
        $len = 8;
        $sets = array();
        $sets[] = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $sets[] = 'abcdefghijkmnopqrstuvwxyz';
        $sets[] = '0123456789';
        $password = '';
        
        foreach ($sets as $set) {
            $password .= $set[array_rand(str_split($set))];
        }
    
        while(strlen($password) < $len) {
            $randomSet = $sets[array_rand($sets)];
            $password .= $randomSet[array_rand(str_split($randomSet))]; 
        }
        return str_shuffle($password);
    }

    public function is_user()
    {
        $userdata = $this->CI->session->userdata('hr_user');
        if (empty($userdata)) {
            redirect(base_url().'hr/login');
        } 
    }

    public function is_manager_user()
    {
        $userdata = $this->CI->session->userdata('hr_user');
        if (!empty($userdata['id']) && $userdata['user_type_id'] == 2) {
            return true;
        } else {
            redirect(base_url().'hr/dashboard');
        }
    }

    public function is_employee_user()
    {
        $userdata = $this->CI->session->userdata('hr_user');
        if (!empty($userdata['id']) && $userdata['user_type_id'] == 1) {
            return true;
        } else {
            redirect(base_url().'hr/dashboard');
        }
    }

    
}
