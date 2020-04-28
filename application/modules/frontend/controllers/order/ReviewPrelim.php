<?php

(defined('BASEPATH')) OR exit('No direct script access allowed');

class ReviewPrelim extends MX_Controller {

	function __construct() {
        parent::__construct();
        $this->load->model('order/apiLogs');
        $this->load->model('order/reviewPrelimData');
        $this->load->library('order/order');
    }

    function fetchData()
    {
    	$json = file_get_contents('php://input');
    	if($json)
    	{
    		$logId = $this->apiLogs->syncLogs(0,'resware WCF', 'get_prelim','https://mypctrep.com/ReceiveSearchDataService.svc?wsdl', array('ReceiveSearchDataService'=>true), array());

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

			$data = json_decode($json,TRUE);

	    	if(isset($data) && !empty($data))
	    	{
	    		$file_number = isset($data['FileNumber']) && !empty($data['FileNumber']) ? $data['FileNumber'] : '';

	    		$vesting = isset($data['Vesting']) && !empty($data['Vesting']) ? $data['Vesting'] : '';
	    		$generated_date = isset($data['CommitmentEffectiveDate']) && !empty($data['CommitmentEffectiveDate']) ? date('Y-m-d H:i:s', strtotime($data['CommitmentEffectiveDate'])) : '';
	    		$liens = array();

	    		if(isset($data['Liens']) && !empty($data['Liens']))
	    		{
	    			foreach ($data['Liens'] as $key => $lien) 
	    			{
	    				$language = isset($lien['Language']) && !empty($lien['Language']) ? $lien['Language'] : '';

	    				if(!empty($language))
	    				{
	    					$liens[] = $language;
	    				}	    				
	    			}
	    		}

	    		$easements = array();
	    		if(isset($data['Easements']) && !empty($data['Easements']))
	    		{
	    			foreach ($data['Easements'] as $key => $easement) 
	    			{
	    				$language = isset($easement['Language']) && !empty($easement['Language']) ? $easement['Language'] : '';
	    				
	    				if(!empty($language))
	    				{
	    					$easements[] = $language;
	    				}
	    			}
	    		}

	    		$requirements = array();
	    		if(isset($data['Requirements']) && !empty($data['Requirements']))
	    		{
	    			foreach ($data['Requirements'] as $key => $requirement) 
	    			{
	    				$language = isset($requirement['Language']) && !empty($requirement['Language']) ? $requirement['Language'] : '';

	    				if(!empty($language))
	    				{
	    					$requirements[] = $language;
	    				}
	    			}
	    		}
	    		
	    		$restrictions = array();
	    		
	    		if(isset($data['Restrictions']) && !empty($data['Restrictions']))
	    		{
	    			foreach ($data['Restrictions'] as $key => $restriction) 
	    			{

	    				$language = isset($restriction['Language']) && !empty($restriction['Language']) ? $restriction['Language'] : '';
	    				
	    				if(!empty($language))
	    				{
	    					$restrictions[] = $language;
	    				}
	    			}
	    			
	    		}
	    		
	    		$summaryData = array(
	    			'file_number'=> $file_number,
	    			'vesting'=> $vesting,
	    			'generated_date'=> $generated_date,
	    			'lien'=> json_encode($liens),
	    			'easement'=> json_encode($easements),
	    			'requirements'=> json_encode($requirements),
	    			'restrictions'=> json_encode($restrictions),
	    		);
	    		$con = array(
	                'where' => array(
	                    'file_number' => $file_number,
	                ),
	                'returnType' => 'count'
	            );
	            $prevCount = $this->reviewPrelimData->get_rows($con);
	            
	            if($prevCount > 0)
	            {
		            $condition = array('file_number' => $file_number);
		            $update = $this->reviewPrelimData->update($summaryData, $condition);
	            }
	            else
	            {
	            	$id = $this->reviewPrelimData->insert($summaryData);

	            	$condition = array(
			                'file_number' => $file_number
			        );
		    		$data = array(
						'prelim_summary_id'	=> $id
					);

		        	$this->order->update($data,$condition);
	            }
	    	}
	    	echo "Data stored successfully.";
    	}
    	else
    	{
    		echo "Empty response received.";
    	}
    }
}

