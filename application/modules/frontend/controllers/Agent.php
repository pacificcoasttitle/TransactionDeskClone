<?php

(defined('BASEPATH')) OR exit('No direct script access allowed');

class Agent extends MY_Controller {

	function __construct() {
        parent::__construct();
        $this->load->helper(array('file', 'url'));
        $this->load->library('session');
        $this->load->model('agent_model');
    }

    function getAgentDetails() {
    	$searchTerm = isset($_POST['term']) && !empty($_POST['term']) ? $_POST['term'] : '';

    	$condition = array(
            'name' => $searchTerm
        );

    	$agentDetails = $this->agent_model->get_agents($condition);
    	$agentInfo = array();
    	if(isset($agentDetails) && !empty($agentDetails))
    	{
    		foreach ($agentDetails as $key => $value) 
    		{
    			$data['id'] = isset($value['id']) && !empty($value['id']) ? $value['id'] : '';
            
	            $data['value'] = isset($value['value']) && !empty($value['value']) ? $value['value'] : '';

	            $data['name'] = isset($value['name']) && !empty($value['name']) ? $value['name'] : '';
	            /* $data['last_name'] = isset($value['last_name']) && !empty($value['last_name']) ? $value['last_name'] : '';*/
	            $data['email_address'] = isset($value['email_address']) && !empty($value['email_address']) ? $value['email_address'] : '';
	            $data['telephone_no'] = isset($value['telephone_no']) && !empty($value['telephone_no']) ? $value['telephone_no'] : '';
	            $data['company'] = isset($value['company']) && !empty($value['company']) ? $value['company'] : '';
	            // array_push($agentInfo, $data); 
	            $agentInfo[] =$data;
    		}
    	}
    	echo json_encode($agentInfo);
    }
}