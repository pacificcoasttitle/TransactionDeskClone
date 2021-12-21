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

    public function is_admin()
    {
        $userdata = $this->CI->session->userdata('admin');
        if (!empty($userdata['id']) && $userdata['is_admin'] == 1) {
            return true;
        } else {
            redirect(base_url().'order/admin');
        }
    }

    public function is_title_officer_user()
    {
        $userdata = $this->CI->session->userdata('user');
        if (!empty($userdata['id'])) {
            if ($userdata['is_sales_rep'] ==  1) {
                redirect(base_url().'sales-dashboard/'.$userdata['id']);
            } else if ($userdata['is_special_lender'] ==  1) {
                redirect(base_url().'special-lender-dashboard');
            } else if ($userdata['is_payoff_user'] ==  1) {
                redirect(base_url().'pay-off-dashboard');
            } else if ($userdata['is_title_officer'] ==  0) {
                redirect(base_url().'dashboard');
            }
        } else {
            redirect(base_url().'order/login');
        }
    }

    public function is_sales_user()
    {
        $userdata = $this->CI->session->userdata('user');
        if (!empty($userdata['id'])) {
            if ($userdata['is_title_officer'] ==  1) {
                redirect(base_url().'title-officer-dashboard');
            } else if ($userdata['is_special_lender'] ==  1) {
                redirect(base_url().'special-lender-dashboard');
            } else if ($userdata['is_payoff_user'] ==  1) {
                redirect(base_url().'pay-off-dashboard');
            } else if ($userdata['is_sales_rep'] ==  0) {
                redirect(base_url().'dashboard');
            }
        } else {
            redirect(base_url().'order/login');
        }
    }

    public function is_special_lender_user()
    {
        $userdata = $this->CI->session->userdata('user');
        if (!empty($userdata['id'])) {
            if ($userdata['is_title_officer'] ==  1) {
                redirect(base_url().'title-officer-dashboard');
            } else if ($userdata['is_sales_rep'] ==  1) {
                redirect(base_url().'sales-dashboard/'.$userdata['id']);
            } else if ($userdata['is_payoff_user'] ==  1) {
                redirect(base_url().'pay-off-dashboard');
            } else if ($userdata['is_special_lender'] ==  0) {
                redirect(base_url().'dashboard');
            }
        } else {
            redirect(base_url().'order/login');
        }
    }

    public function is_pay_off_user()
    {
        $userdata = $this->CI->session->userdata('user');
        if (!empty($userdata['id'])) {
            if ($userdata['is_title_officer'] ==  1) {
                redirect(base_url().'title-officer-dashboard');
            } else if ($userdata['is_sales_rep'] ==  1) {
                redirect(base_url().'sales-dashboard/'.$userdata['id']);
            } else if ($userdata['is_special_lender'] ==  1) {
                redirect(base_url().'special-lender-dashboard');
            } else if ($userdata['is_payoff_user'] ==  0) {
                redirect(base_url().'dashboard');
            } 
        } else {
            redirect(base_url().'order/login');
        }
    }
}
