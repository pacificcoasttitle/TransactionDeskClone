<?php

(defined('BASEPATH')) OR exit('No direct script access allowed');

class ReviewPrelim extends MX_Controller {

	function __construct() {
        parent::__construct();
        $this->load->model('order/apiLogs');
        $this->load->model('order/reviewPrelimData');
        $this->load->library('order/order');
        $this->load->library("phpmailer_library");
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

				$parcelID = isset($data['ParcelID']) && !empty($data['ParcelID']) ? $data['ParcelID'] : '';
	    		$vesting = isset($data['Vesting']) && !empty($data['Vesting']) ? $data['Vesting'] : '';
	    		$generated_date = isset($data['CommitmentEffectiveDate']) && !empty($data['CommitmentEffectiveDate']) ? date('Y-m-d H:i:s', strtotime($data['CommitmentEffectiveDate'])) : '';
	    		$liens = $tax = array();

	    		if(isset($data['Liens']) && !empty($data['Liens']))
				{
					foreach ($data['Liens'] as $key => $lien) 
					{
						$language = isset($lien['Language']) && !empty($lien['Language']) ? $lien['Language'] : '';
						$language = preg_replace('/(.*):/', '<b>$1:</b>', $language);
						$language = preg_replace('/[\x00-\x09\x0B\x0C\x0E-\x1F\x7F]/', '', $language);

						if(strpos($language, 'Tax Identification No') !== false)
						{
							if(strpos($language, '_PARCELID1_') !== false) 
							{									
									
								$language = str_replace("_PARCELID1_", " <strong><u>".$parcelID."</u></strong>" , $language);
							}

							$tax[] = $language;
						}
						else
						{
							$amount = isset($lien['Amount']) && !empty($lien['Amount']) ? $lien['Amount'] : '';
							$date = isset($lien['Date']) && !empty($lien['Date']) ? $lien['Date'] : '';
							$grantor = isset($lien['Grantor']) && !empty($lien['Grantor']) ? $lien['Grantor'] : '';
							$trustee = isset($lien['Trustee']) && !empty($lien['Trustee']) ? $lien['Trustee'] : '';
							$grantee = isset($lien['Grantee']) && !empty($lien['Grantee']) ? $lien['Grantee'] : '';
							$recordedDate = isset($lien['RecordedDate']) && !empty($lien['RecordedDate']) ? $lien['RecordedDate'] : '';
							$instrument = isset($lien['Instrument']) && !empty($lien['Instrument']) ? $lien['Instrument'] : '';
							if(!empty($language))
							{								
								if(strpos($language, '_AMOUNT_') !== false) {
									$language = str_replace("_AMOUNT_", " ".$amount , $language);
								}
								if(strpos($language, '_DATE_') !== false) {
									$language = str_replace("_DATE_", " ".$date , $language);
								}
								if(strpos($language, '_GRANTOR_') !== false) {
									$language = str_replace("_GRANTOR_", " ".$grantor , $language);
								}
								if(strpos($language, '_TRUSTEE_') !== false) {
									$language = str_replace("_TRUSTEE_", " ".$trustee , $language);
								}
								if(strpos($language, '_GRANTEE_') !== false) {
									$language = str_replace("_GRANTEE_", " ".$grantee , $language);
								}
								if(strpos($language, '_RECORDEDDATE_') !== false) {
									$language = str_replace("_RECORDEDDATE_", " ".$recordedDate , $language);
								}
								if(strpos($language, '_INSTRUMENTONLY_') !== false) {
									$language = str_replace("_INSTRUMENTONLY_", " ".$instrument , $language);
								}
								if(strpos($language, '_PARCELID1_') !== false) {
									$language = str_replace("_PARCELID1_", " ".$parcelID , $language);
								}
								$language = str_replace("\u000b", "", $language);
								$language = str_replace("\r", "", $language);
								$liens[] = $language;
							}
						}
							    				
					}
				}

				$easements = array();
				if(isset($data['Easements']) && !empty($data['Easements']))
				{
					foreach ($data['Easements'] as $key => $easement) 
					{
						$language = isset($easement['Language']) && !empty($easement['Language']) ? $easement['Language'] : '';
						$language = preg_replace('/(.*):/', '<b>$1:</b>', $language);
						$language = preg_replace('/[\x00-\x09\x0B\x0C\x0E-\x1F\x7F]/', '', $language);
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
						$language = preg_replace('/(.*):/', '<b>$1:</b>', $language);
						$language = preg_replace('/[\x00-\x09\x0B\x0C\x0E-\x1F\x7F]/', '', $language);
						$amount = isset($requirement['Amount']) && !empty($requirement['Amount']) ? $requirement['Amount'] : '';
						$date = isset($requirement['Date']) && !empty($requirement['Date']) ? $requirement['Date'] : '';
						$grantor = isset($requirement['Grantor']) && !empty($requirement['Grantor']) ? $requirement['Grantor'] : '';
						$trustee = isset($requirement['Trustee']) && !empty($requirement['Trustee']) ? $requirement['Trustee'] : '';
						$grantee = isset($requirement['Grantee']) && !empty($requirement['Grantee']) ? $requirement['Grantee'] : '';
						$recordedDate = isset($requirement['RecordedDate']) && !empty($requirement['RecordedDate']) ? $requirement['RecordedDate'] : '';
						$instrument = isset($requirement['Instrument']) && !empty($requirement['Instrument']) ? $requirement['Instrument'] : '';
						
						if(strpos($language, '_AMOUNT_') !== false) {
							$language = str_replace("_AMOUNT_", " ".$amount , $language);
						}
						if(strpos($language, '_DATE_') !== false) {
							$language = str_replace("_DATE_", " ".$date , $language);
						}
						if(strpos($language, '_GRANTOR_') !== false) {
							$language = str_replace("_GRANTOR_", " ".$grantor , $language);
						}
						if(strpos($language, '_TRUSTEE_') !== false) {
							$language = str_replace("_TRUSTEE_", " ".$trustee , $language);
						}
						if(strpos($language, '_GRANTEE_') !== false) {
							$language = str_replace("_GRANTEE_", " ".$grantee , $language);
						}
						if(strpos($language, '_RECORDEDDATE_') !== false) {
							$language = str_replace("_RECORDEDDATE_", " ".$recordedDate , $language);
						}
						if(strpos($language, '_INSTRUMENTONLY_') !== false) {
							$language = str_replace("_INSTRUMENTONLY_", " ".$instrument , $language);
						}
						if(strpos($language, '_PARCELID1_') !== false) {
							$language = str_replace("_PARCELID1_", " ".$parcelID , $language);
						}
						
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
						$language = preg_replace('/(.*):/', '<b>$1:</b>', $language);
						$language = preg_replace('/[\x00-\x09\x0B\x0C\x0E-\x1F\x7F]/', '', $language);
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
					'resware_json' => $json,
					'parcel_id' => $parcelID
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

	    	/* Send email to customer */
	    	$emailContent  = $summaryData;
	    	$emailContent['tax'] = json_encode($tax);
	    	
	    	$mail = $this->phpmailer_library->load();
	    	$mail->isSendmail();
			$mail->IsHTML(true);
			$mail->setFrom('cs@pct.com','Open Order Desk');
			$mail->CharSet = "UTF-8";
			/*$mail->Encoding = "base64";
			$mail->Timeout = 200;
			$mail->ContentType = "text/html";*/
			$mail->addAddress('hitesh.p@crestinfosystems.com', 'Open Order Desk');							
			$mail->Subject = "The Prelim Hot Sheet";
			$prelim_message_body = $this->load->view('emails/prelim.php',$emailContent,TRUE);

			$mail->Body = $prelim_message_body;
			$mail->AltBody = "Use an HTML compatible email client";
			
			if($mail->Send())
			{
				echo 'success'; exit;
			}
			else
			{
				echo 'error';
				echo "<pre>"; print_r($mail->ErrorInfo); exit;
				
			}
	    	/* Send email to customer */

	    	echo "Data stored successfully.";
    	}
    	else
    	{
    		echo "Empty response received.";
    	}
    }
    
}

