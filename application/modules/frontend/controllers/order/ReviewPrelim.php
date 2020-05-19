<?php

(defined('BASEPATH')) OR exit('No direct script access allowed');

class ReviewPrelim extends MX_Controller {

	public function __construct() {
        parent::__construct();
        $this->load->model('order/apiLogs');
        $this->load->model('order/reviewPrelimData');
        $this->load->library('order/order');
        // $this->load->library("phpmailer_library");
        $this->load->model('order/document');
        $this->load->library('order/resware');
        $this->load->model('order/home_model');
    }

    
    public function fetchData()
    {
    	ini_set('max_execution_time', 0); 
		ini_set('memory_limit','2048M');
		
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
	    		$liens = $email_data = array();

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
									
								$language = str_replace("_PARCELID1_", $parcelID , $language);
								
							}

							$email_data['tax'][] = $language;
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
								
								$liens[] = $language;
								$email_data['liens'][] = $language;
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


	        $condition = array(
	            'where' => array(
	                'file_number' => $file_number,
	            )
	        );

			$order_details = $this->order->get_rows($condition);

			$order_id = isset($order_details['id']) && !empty($order_details['id']) ? $order_details['id'] : '';
			$file_id = isset($order_details['file_id']) && !empty($order_details['file_id']) ? $order_details['file_id'] : '';
			$customer_id = isset($order_details['customer_id']) && !empty($order_details['customer_id']) ? $order_details['customer_id'] : '';

			$condition = array(
	            'id' => $customer_id,
	        );

	    	$userDetails = $this->home_model->get_customers($condition);

	    	$customer_email = isset($userDetails['email_address']) && !empty($userDetails['email_address']) ? $userDetails['email_address'] : '';
	    	$customer_name = '';

	    	if(isset($userDetails['first_name']) && !empty($userDetails['first_name']))
	    	{
	    		$customer_name = $userDetails['first_name'];
	    	}

	    	if(isset($userDetails['last_name']) && !empty($userDetails['last_name']))
	    	{
	    		$customer_name .= $userDetails['last_name'];
	    	}

	    	if(isset($email_data) && !empty($email_data))
	    	{
	    		foreach ($email_data as $key => $value) 
	    		{
	    			foreach ($value as $k => $v)
	    			{
	    				$dom = new DomDocument();
						$dom->loadHTML($v);
						foreach ($dom->getElementsByTagName('a') as $item) 
						{
						    $output = array (
						      'str' => $dom->saveHTML($item),
						      'href' => $item->getAttribute('href'),
						      'anchorText' => $item->nodeValue
						   	);

						   	if(isset($output) && !empty($output))
							{
								$linkHref = $output['href'];
								$doc_link = explode('=', $linkHref);
								$document_id = isset($doc_link[1]) && !empty($doc_link[1]) ? $doc_link[1] : '';

								$documentDetail = $this->order->get_document_detail($document_id);

								if(empty($documentDetail))
								{
									$document_name = date('YmdHis')."_".trim($output['anchorText']).'.pdf';
									$original_doc_name = trim($output['anchorText']).'.pdf';
									
									$doc_url = 'http://clients.pacificcoasttitle.com/DownloadDocument.aspx?'.$linkHref;		

									file_put_contents('./uploads/documents/'.$document_name, file_get_contents($doc_url));

									$fileSize = filesize('./uploads/documents/'.$document_name);
									$new_href = base_url().'uploads/documents/'.$document_name;
									$documentData = array(
										'document_name' => $document_name,
										'original_document_name' => $original_doc_name,
										'document_type_id' => 0,
										'api_document_id' => $document_id,
										'document_size' => $fileSize,
										'user_id' => $customer_id,
										'order_id' => $order_id,
										'description' => "",
										'created' => date('Y-m-d H:i:s'),
										'is_sync' => 1,
										'is_prelim_document' => 0,
										'is_linked_doc' => 1
									);
									$documentId = $this->document->insert($documentData);

									$item->setAttribute('href', $new_href);
									$item->setAttribute('download',$document_name);

									$email_data[$key][$k] = $dom->saveHTML();
									
								}
								else
								{
									$document_name = isset($documentDetail['document_name']) && !empty($documentDetail['document_name']) ? $documentDetail['document_name'] : '';

									$new_href = base_url().'uploads/documents/'.$document_name;
									$item->setAttribute('href', $new_href);
									$item->setAttribute('download',$document_name);

									$email_data[$key][$k] = $dom->saveHTML();
								}
							}
						}
						
	    			}
	    		}
	    	}

	    	$emailContent['tax'] = isset($email_data['tax']) && !empty($email_data['tax']) ? json_encode($email_data['tax']) : '';
	    	$emailContent['liens'] = isset($email_data['liens']) && !empty($email_data['liens']) ? json_encode($email_data['liens']) : '';

	    	$mail = $this->phpmailer_library->load();
	    	$mail->isSendmail();
			$mail->IsHTML(true);
			$mail->setFrom('cs@pct.com','Open Order Desk');
			$mail->CharSet = "UTF-8";
			
			// $mail->addAddress('hitesh.p@crestinfosystems.com', 'Open Order Desk');							
			$mail->addAddress($customer_email, $customer_name);							
			$mail->Subject = "The Prelim Hot Sheet";
			$prelim_message_body = $this->load->view('emails/prelim.php',$emailContent,TRUE);
			
			$mail->Body = $prelim_message_body;
			$mail->AltBody = "Use an HTML compatible email client";
			
			$result = array();
			if($mail->Send())
			{
				$result['mail_status'] = 'success';
			}
			else
			{
				$result['mail_status'] = 'error';		
			}
	    	/* Send email to customer */
	    	$result['message'] = "Data stored successfully.";
    	}
    	else
    	{
    		$result['message'] = "Empty response received.";
    	}
    	echo json_encode($result);
    }
    
    public function testMail()
    {
    	$mail = $this->load->library("email");

    	// $mail->isSendmail();
		// $mail->IsHTML(true);
		$mail->setFrom('cs@pct.com','Open Order Desk');
		$mail->CharSet = "UTF-8";
		
		$mail->addAddress('hitesh.p@crestinfosystems.com', 'Open Order Desk');							
		// $mail->addAddress($customer_email, $customer_name);							
		$mail->Subject = "Sendgrid Test";
		// $prelim_message_body = $this->load->view('emails/prelim.php',$emailContent,TRUE);
		
		$mail->Body = "Testing sendgrid";
		$mail->AltBody = "Use an HTML compatible email client";
		
		$mail->Send();
    }
}

