<?php

(defined('BASEPATH')) OR exit('No direct script access allowed');

class ReviewPrelim extends MX_Controller {

	function __construct() {
        parent::__construct();
        $this->load->model('order/apiLogs');
    }

    function fetchData()
    {
    	$json = file_get_contents('php://input');
    	if($json)
    	{
    		$logId = $this->apiLogs->syncLogs(0,'resware WCF', 'get_prelim','https://mypctrep.com/ReceiveSearchDataService.svc?wsdl', array('ReceiveSearchDataService'=>true), $json);

    		$this->apiLogs->syncLogs(0, 'resware WCF', 'get_prelim', 'https://mypctrep.com/ReceiveSearchDataService.svc?wsdl', array(), $json, 0, $logId);
    		//Name of our directory
			$dir_name = APPPATH.'logs/prelim';

			//Check if the directory with the name already exists
			if (!is_dir($dir_name)) 
			{
				mkdir($dir_name);
			}

			$file = APPPATH.'logs/prelim/response.log';
			if (file_exists($file)) 
			{
			  $fh = fopen($file, 'a');
			} 
			else 
			{
			  $fh = fopen($file, 'w');
			}

			fwrite($fh, $json."\n");
			fclose($fh);
    	}
		
    }
}