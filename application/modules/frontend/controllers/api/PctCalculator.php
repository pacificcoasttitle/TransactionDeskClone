<?php

(defined('BASEPATH')) OR exit('No direct script access allowed');

class PctCalculator extends MX_Controller {
	private $return_response;

	function __construct() 
    {
		parent::__construct();
		$this->return_response = ['status'=>false,'message'=>'','data'=>array()];
		$this->load->library('order/resware');
		$headers = null;
    if (isset($_SERVER['Authorization'])) {
        $headers = trim($_SERVER["Authorization"]);
    }
    else if (isset($_SERVER['HTTP_AUTHORIZATION'])) { //Nginx or fast CGI
        $headers = trim($_SERVER["HTTP_AUTHORIZATION"]);
    } elseif (function_exists('apache_request_headers')) {
        $requestHeaders = apache_request_headers();
        // Server-side fix for bug in old Android versions (a nice side-effect of this fix means we don't care about capitalization for Authorization)
        $requestHeaders = array_combine(array_map('ucwords', array_keys($requestHeaders)), array_values($requestHeaders));
        //print_r($requestHeaders);
        if (isset($requestHeaders['Authorization'])) {
            $headers = trim($requestHeaders['Authorization']);
        }
    }
	if (!empty($headers)) {
        if (preg_match('/Bearer\s(\S+)/', $headers, $matches)) {
            $verify_token = $matches[1];
			$env_token = env('PCT_CALC_TOKEN');
			if( ! ($verify_token === $env_token)) {
				$this->return_response['message']='Invalid Token';
				echo json_encode($this->return_response);
				exit;
			}
        }
    }
	else {
			$this->return_response['message']='Please provide Token';
			echo json_encode($this->return_response);
			exit;
		}
	}
	
	function get_file_details($file_number) 
	{
		$data = json_encode(array('FileNumber' => $file_number));
		$userData = array(
			'admin_api' => 1
		);
		$result = $this->resware->make_request('POST', 'files/search', $data, $userData);
		if(json_decode($result) && count(json_decode($result)->Files)) {
			$result_data = $result_decoded = array();
			$result_decoded = json_decode($result);
			$result_data['LoanNumber']=$result_decoded->Files[0]->Loans[0]->LoanNumber;
			$result_data['SalesPrice']=$result_decoded->Files[0]->SalesPrice;
			$result_data['City']=$result_decoded->Files[0]->Properties[0]->City;
			$result_data['State']=$result_decoded->Files[0]->Properties[0]->State;
			$result_data['County']=$result_decoded->Files[0]->Properties[0]->County;
			$result_data['ProductType']=$result_decoded->Files[0]->TransactionProductType->ProductType;

			$this->return_response['status'] = true;
			$this->return_response['data'] = json_encode($result_data);
		}
		echo json_encode($this->return_response);
	}
}
