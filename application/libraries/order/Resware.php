<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class Resware
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

   public function make_request($http_method, $endpoint, $body_params='')
   {
        $userdata = $this->CI->session->userdata('user');
        $login =  $userdata['email'];
        if ($userdata['email'] == 'ghernandez@pct.com') {
            $password= 'Alpha637#';
        } else {
            $password= 'Pacific2';
        }
        echo $login."---".$password;
        $ch = curl_init(RESWARE_ORDER_API.$endpoint);                                    
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $http_method);                        
        curl_setopt($ch, CURLOPT_POSTFIELDS, $body_params);                   
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
       // curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
       // curl_setopt($ch, CURLOPT_USERPWD, "$login:$password");
        curl_setopt($ch, CURLOPT_HTTPHEADER, array( 
            'Authorization: Basic Z2hlcm5hbmRlekBwY3QuY29tOkFscGhhNjM3Iw==',                              
            'Content-Type: application/json',
            'Content-Length: ' . strlen($body_params))                                 
        ); 
        $error_msg = curl_error($ch);
        $result = curl_exec($ch);
        echo "here345";
        echo $result;
        print_r($result);
        echo $error_msg;
        print_r($error_msg);
        echo "here123";
        exit;
        return $result;
   }
    
}
