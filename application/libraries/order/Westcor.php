<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class Westcor
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

   public function make_request($http_method, $endpoint, $body_params, $is_token_call = 0, $bearerToken = '')
   {
        $userdata = $this->CI->session->userdata('user');
        $ch = curl_init(WESTCORE_URL.$endpoint);                                    
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $http_method);                        
        curl_setopt($ch, CURLOPT_POSTFIELDS, $body_params);                   
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        if ($is_token_call == 0) {
            curl_setopt($ch, CURLOPT_HTTPHEADER, array(                                
                'Content-Type: application/json',
                'Authorization: Bearer '.$bearerToken,
                'Content-Length: ' . strlen($body_params))                                 
            ); 
        }
        $error_msg = curl_error($ch);
        $result = curl_exec($ch);
        return $result;
   }

   public function createToken() 
   {

   }
    
}
