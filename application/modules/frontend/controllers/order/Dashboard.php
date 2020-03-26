<?php

(defined('BASEPATH')) OR exit('No direct script access allowed');

class Dashboard extends MX_Controller {

	function __construct() {
        parent::__construct();
        $this->load->helper(array('file', 'url'));
        $this->load->library('session');
		$this->load->library('form_validation');
    }

    function selectFiles()
    {
    	/*echo "<pre>"; print_r("here"); exit;
    	$this->is_user();*/
		$data['title'] = 'Smart Dashboard | Pacific Coast Title Company';
		$this->load->view('layout/head_dashboard',$data);
		$this->load->view('order/select-files');
    }

    function getFiles()
    {
    	$this->is_user();
		$data['title'] = 'Smart Dashboard | Pacific Coast Title Company';
		$this->load->view('layout/head_dashboard',$data);
		$this->load->view('order/dashboard');
    }

    function recordings()
    {
    	// $this->is_user();
		$data['title'] = 'Smart Dashboard | Pacific Coast Title Company';
		$this->load->view('layout/head_dashboard',$data);
		$this->load->view('order/recordings');
	}
	
	function get_recordings()
    {
		$ch = curl_init(GET_RECORDING_URL.'&date=2020-03-26');                                    
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");                        
		curl_setopt($ch, CURLOPT_POSTFIELDS, array());                   
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_HTTPHEADER, array(                                
			"cache-control: no-cache",
            "Content-Type: application/json"                             
		));
		$error_msg = curl_error($ch);
		$result = curl_exec($ch);
		if(isset($result) && !empty($result))
		{
			$response = json_decode($result,true);
		} else {
			
		}
		$nestedData[] = 1;
			$nestedData[] = 'hitesh';
			$nestedData[] = 'gghhg';
		$data[] = $nestedData;  
		$json_data['recordsTotal'] = 1;
		//$json_data['recordsTotal'] = intval( $agent_lists['recordsTotal'] );
        $json_data['data'] = $data;
        echo json_encode($json_data);
    }
}