<?php

(defined('BASEPATH')) OR exit('No direct script access allowed');

class TitlePoint extends MX_Controller {

	function createService()
	{
		// $this->session->unset_userdata('customer_number');
		$methodId = isset($_POST['methodId']) && !empty($_POST['methodId']) ? $_POST['methodId'] : '';

		$requestParams = array(
            'userID' => TP_USERNAME,
            'password' => TP_PASSWORD,
            'orderNo' =>  '',
            'customerRef'=>  '',
            'company'=>  '',
            'department'=>  '',
            'titleOfficer'=>  '',
            'orderComment'=>  '',
            'starterRemarks'=>  '',
        );

        if($methodId == 3)
		{
			$apn = isset($_POST['apn']) && !empty($_POST['apn']) ? $_POST['apn'] : '';
			$state = isset($_POST['state']) && !empty($_POST['state']) ? $_POST['state'] : '';
			$county = isset($_POST['county']) && !empty($_POST['county']) ? $_POST['county'] : '';
			$requestParams['serviceType'] = TAX_SEARCH_SERVICE_TYPE;
			$requestParams['parameters'] = 'Tax.APN='.$apn.';General.AutoSearchTaxes=true;General.AutoSearchProperty=false';
			$requestParams['state'] = $state;
			$requestParams['county'] = $county;
			$requestUrl= TP_TAX_INSTRUMENT_CREATE_SERVICE_ENDPOINT;
		}
		else if($methodId == 4)
		{
			$fipsCode = isset($_POST['fipCode']) && !empty($_POST['fipCode']) ? $_POST['fipCode'] : '';
			$address = isset($_POST['address']) && !empty($_POST['address']) ? $_POST['address'] : '';
			$city = isset($_POST['city']) && !empty($_POST['city']) ? $_POST['city'] : '';

			$requestParams['serviceType'] = SERVICE_TYPE;
			$requestParams['parameters'] = 'Address1='.$address.';City='.$city.';LvLookup=Address;LvLookupValue='.$address.', '.$city.';LvReportFormat=LV;IncludeTaxAssessor=true';
			$requestParams['fipsCode'] = $fipsCode;
			$requestUrl= TP_CREATE_SERVICE_ENDPOINT;
		}
		$request = $requestUrl.http_build_query($requestParams);

		$opts = array(
			"ssl"=>array(
		        "verify_peer"=>false,
		        "verify_peer_name"=>false,
		    ),
		);
		$context = stream_context_create($opts);
		$file = file_get_contents($request,false,$context);

		$xmlData = simplexml_load_string($file);
		$response = json_encode($xmlData);
		$result = json_decode($response,TRUE);
		$responseStatus = isset($result['ReturnStatus']) && !empty($result['ReturnStatus']) ? $result['ReturnStatus'] : '';
		if($methodId == 4)
		{
			if($responseStatus == 'Success')
			{
				$requestId = isset($result['RequestID']) && !empty($result['RequestID']) ? $result['RequestID'] : '';
				$this->session->set_userdata('L_V_RequestId', $requestId);
				$this->session->set_userdata('L_V_CreateService', 1);
			}
			else
			{
				$this->session->set_userdata('L_V_CreateService', 0);
			}
			
		}
		if($methodId == 3)
		{
			if($responseStatus == 'Success')
			{
				$requestId = isset($result['RequestID']) && !empty($result['RequestID']) ? $result['RequestID'] : '';
				$this->session->set_userdata('Tax_RequestId', $requestId);
				$this->session->set_userdata('Tax_CreateService', 1);
			}
			else
			{
				$this->session->set_userdata('Tax_CreateService', 0);
			}
			
		}
		echo trim($file); 
	}


	function getRequestSummaries()
	{
		$requestId = isset($_POST['requestId']) && !empty($_POST['requestId']) ? $_POST['requestId'] : '';
		$methodId = isset($_POST['methodId']) && !empty($_POST['methodId']) ? $_POST['methodId'] : '';
		$apn = isset($_POST['apn']) && !empty($_POST['apn']) ? $_POST['apn'] : '';

		$requestParams = array(
		                    'userID' => TP_USERNAME,
		                    'password' => TP_PASSWORD,
		                    'company'=>  '',
		                    'department'=>  '',
		                    'titleOfficer'=>  '',
		                    'requestId'=>  $requestId,
		                    'maxWaitSeconds'=>  20
		                );

		$request = TP_REQUEST_SUMMARY_ENDPOINT.http_build_query($requestParams);

		$opts = array(
			"ssl"=>array(
		        "verify_peer"=>false,
		        "verify_peer_name"=>false,
		    ),
		);
		$context = stream_context_create($opts);
		$file = file_get_contents($request,false,$context);
		$xmlData = simplexml_load_string($file);
		$response = json_encode($xmlData);
		$result = json_decode($response,TRUE);
		
		$responseStatus = isset($result['ReturnStatus']) && !empty($result['ReturnStatus']) ? $result['ReturnStatus'] : '';
		$session_data = array();


		if($methodId == 4)
		{
			if($responseStatus == 'Success')
			{
				
				$resultId = isset($result['RequestSummaries']['RequestSummary']['Order']['Services']['Service']['ThumbNails']['ResultThumbNail'][0]['ID']) && !empty($result['RequestSummaries']['RequestSummary']['Order']['Services']['Service']['ThumbNails']['ResultThumbNail'][0]['ID']) ? $result['RequestSummaries']['RequestSummary']['Order']['Services']['Service']['ThumbNails']['ResultThumbNail'][0]['ID'] : ''; 
				$serviceId = isset($result['RequestSummaries']['RequestSummary']['Order']['Services']['Service']['ID']) && !empty($result['RequestSummaries']['RequestSummary']['Order']['Services']['Service']['ID']) ? $result['RequestSummaries']['RequestSummary']['Order']['Services']['Service']['ID'] : '';
			
				if ($this->session->has_userdata($apn)) 
				{
					$session_info = $this->session->userdata($apn);
					$session_info['L_V_serviceId'] = $serviceId;
					$this->session->set_userdata($apn, $session_info);
				}
				else
				{
					$session_data = array(
			            "L_V_serviceId" => $serviceId
			        );
					$this->session->set_userdata($apn, $session_data);
				}
				$this->session->set_userdata('L_V_GetRequestSummary', 1);
				$this->session->set_userdata('L_V_ResultId', $resultId);
			}
			else
			{
				$this->session->set_userdata('L_V_GetRequestSummary', 0);
			}
		}
		if($methodId == 3)
		{
			if($responseStatus == 'Success')
			{
				$resultId = isset($result['RequestSummaries']['RequestSummary']['Order']['Services']['Service']['ThumbNails']['ResultThumbNail']['ID']) && !empty($result['RequestSummaries']['RequestSummary']['Order']['Services']['Service']['ThumbNails']['ResultThumbNail']['ID']) ? $result['RequestSummaries']['RequestSummary']['Order']['Services']['Service']['ThumbNails']['ResultThumbNail']['ID'] : '';
				$this->session->set_userdata('Tax_ResultId', $resultId);
				$this->session->set_userdata('Tax_GetRequestSummary', 1);
			}
			else
			{
				$this->session->set_userdata('Tax_GetRequestSummary', 0);
			}
		}
		/*else if($responseStatus == 'Success' && $methodId == 3)
		{
			$serviceId = isset($result['RequestSummaries']['RequestSummary']['Order']['Services']['Service']['ID']) && !empty($result['RequestSummaries']['RequestSummary']['Order']['Services']['Service']['ID']) ? $result['RequestSummaries']['RequestSummary']['Order']['Services']['Service']['ID'] : '';

			if ($this->session->has_userdata($apn)) 
			{
				$session_info = $this->session->userdata($apn);
				$session_info['deedserviceId'] = $serviceId;
				$this->session->set_userdata($apn, $session_info);
			}
			else
			{
				$session_data = array(
		            "deedserviceId" => $serviceId
		        );
				$this->session->set_userdata($apn, $session_data);
			}
		}*/
		echo trim($file); 
	}

	function getResultById()
	{
		$resultId = isset($_POST['resultId']) && !empty($_POST['resultId']) ? $_POST['resultId'] : '';
		$methodId = isset($_POST['methodId']) && !empty($_POST['methodId']) ? $_POST['methodId'] : '';
		$apn = isset($_POST['apn']) && !empty($_POST['apn']) ? $_POST['apn'] : '';

		$requestParams = array(
		                    'userID' => TP_USERNAME,
		                    'password' => TP_PASSWORD,
		                    'company'=>  '',
		                    'department'=>  '',
		                    'titleOfficer'=>  '',
		                    'resultID'=>  $resultId
		                );

		$resultUrl = TP_GET_RESULT_BY_ID;

		if($methodId == 3)
		{
		    $requestParams['requestingTPXML'] = 'true';
		    $resultUrl = TP_GET_RESULT_BY_ID_3;
		}

		$request = $resultUrl.http_build_query($requestParams);

		$opts = array(
			"ssl"=>array(
		        "verify_peer"=>false,
		        "verify_peer_name"=>false,
		    ),
		);
		$context = stream_context_create($opts);
		$file = file_get_contents($request,false,$context);

		$xmlData = simplexml_load_string($file);
		$response = json_encode($xmlData);
		$result = json_decode($response,TRUE);
		
		$responseStatus = isset($result['ReturnStatus']) && !empty($result['ReturnStatus']) ? $result['ReturnStatus'] : '';
		$session_data = array();
		/*echo "<pre>"; print_r($result); exit;*/
		if($methodId == 4)
		{
			if($responseStatus == 'Success')
			{
				$briefLegal = isset($result['Result']['BriefLegal']) && !empty($result['Result']['BriefLegal']) ? $result['Result']['BriefLegal'] : '';
				
	            $vesting = isset($result['Result']['Vesting']) && !empty($result['Result']['Vesting']) ? $result['Result']['Vesting'] : '';
	            /*$apn = isset($result['Result']['Apn']) && !empty($result['Result']['Apn']) ? $result['Result']['Apn'] : '';*/
	            $instrumentNumber = isset($result['Result']['LvDeeds']['LegalAndVesting2DeedInfo'][0]['InstrumentNumber']) && !empty($result['Result']['LvDeeds']['LegalAndVesting2DeedInfo'][0]['InstrumentNumber']) ? $result['Result']['LvDeeds']['LegalAndVesting2DeedInfo'][0]['InstrumentNumber'] : '';
	            $recordedDate = isset($result['Result']['LvDeeds']['LegalAndVesting2DeedInfo'][0]['RecordedDate']) && !empty($result['Result']['LvDeeds']['LegalAndVesting2DeedInfo'][0]['RecordedDate']) ? $result['Result']['LvDeeds']['LegalAndVesting2DeedInfo'][0]['RecordedDate'] : '';

	            
		       	if ($this->session->has_userdata($apn)) 
				{
					$session_info = $this->session->userdata($apn);
					$session_info['briefLegal'] = $briefLegal;
					$session_info['vesting'] = $vesting;
					$session_info['recordedDate'] = $recordedDate;
					$session_info['instrumentNumber'] = $instrumentNumber;
					$this->session->set_userdata($apn, $session_info);
				}
				else
				{
					$session_data = array(
			            "briefLegal" => $briefLegal,
			            "vesting" => $vesting,
			            "instrumentNumber" => $instrumentNumber,
			            "recordedDate" => $recordedDate,
			        );
					$this->session->set_userdata($apn, $session_data);
				}
				$this->session->set_userdata('L_V_GetResultById', 1);
			}
			else
			{
				$this->session->set_userdata('L_V_GetResultById', 0);
			}
		}
		if($methodId == 3)
		{
			if($responseStatus == 'Success')
			{
				$firstInstallment = $secondInstallment = '';
				if(isset($result['Result']['TaxReport']['Installments']['Item'][0]) && !empty($result['Result']['TaxReport']['Installments']['Item'][0]))
				{
					$firstInstallment = $result['Result']['TaxReport']['Installments']['Item'][0];
					
				}

				if(isset($result['Result']['TaxReport']['Installments']['Item'][1]) && !empty($result['Result']['TaxReport']['Installments']['Item'][1]))
				{
					$secondInstallment = $result['Result']['TaxReport']['Installments']['Item'][1];			
				}

				if ($this->session->has_userdata($apn)) 
				{
					$session_info = $this->session->userdata($apn);
					$session_info['firstInstallment'] = $firstInstallment;
					$session_info['secondInstallment'] = $secondInstallment;
					$this->session->set_userdata($apn, $session_info);
				}
				else
				{
					$session_data = array('firstInstallment'=>$firstInstallment, 'secondInstallment'=>$secondInstallment);
					$this->session->set_userdata($apn, $session_data);
				}
				$this->session->set_userdata('Tax_GetResultById', 1);
			}
			else
			{
				$this->session->set_userdata('Tax_GetResultById', 0);
			}
		}
		echo trim($file);
	}

	function imageCreateRequest()
	{
		$serviceId = isset($_POST['serviceId']) && !empty($_POST['serviceId']) ? $_POST['serviceId'] : '';

		if($serviceId)
		{	
			$requestParams = array(
		        'username' => TP_USERNAME,
		        'password' => TP_PASSWORD,
		        'serviceId1' =>  $serviceId,
		        'serviceId2'=>  '',
		        'source'=>  '',
		        'clientKey1'=>  '',
		        'clientKey2'=>  '',
		        'sortOrder'=>  '',
		        'fileType'=>  'pdf',
		    );
			$requestUrl= TP_IMAGE_ENDPOINT;
		}

		$request = $requestUrl.http_build_query($requestParams);

		$opts = array(
			"ssl"=>array(
		        "verify_peer"=>false,
		        "verify_peer_name"=>false,
		    ),
		);
		$context = stream_context_create($opts);
		$file = file_get_contents($request,false,$context);

		echo trim($file);
	}

	function getRequestStatus()
	{
		$requestId = isset($_POST['requestId']) && !empty($_POST['requestId']) ? $_POST['requestId'] : '';

		$requestParams = array(
		                    'username' => TP_USERNAME,
		                    'password' => TP_PASSWORD,                    
		                    'requestId'=>  $requestId
		                );

		$request = TP_IMAGE_REQUEST_STATUS.http_build_query($requestParams);

		$opts = array(
			"ssl"=>array(
		        "verify_peer"=>false,
		        "verify_peer_name"=>false,
		    ),
		);
		$context = stream_context_create($opts);
		$file = file_get_contents($request,false,$context);
		echo trim($file); 
	}

	function generateImage()
	{
		$requestId = isset($_POST['requestId']) && !empty($_POST['requestId']) ? $_POST['requestId'] : '';

		$requestParams = array(
		                    'username' => TP_USERNAME,
		                    'password' => TP_PASSWORD,                    
		                    'requestId'=>  $requestId
		                );

		$request = TP_GENERATE_IMAGE.http_build_query($requestParams);

		$opts = array(
			"ssl"=>array(
		        "verify_peer"=>false,
		        "verify_peer_name"=>false,
		    ),
		);
		$context = stream_context_create($opts);
		$file = file_get_contents($request,false,$context);

		echo trim($file);
	}

	function instrumentService()
	{
		$state = isset($_POST['state']) && !empty($_POST['state']) ? $_POST['state'] : '';
		$county = isset($_POST['county']) && !empty($_POST['county']) ? $_POST['county'] : '';
		$docId = isset($_POST['docId']) && !empty($_POST['docId']) ? $_POST['docId'] : '';
		$recDate = isset($_POST['recDate']) && !empty($_POST['recDate']) ? $_POST['recDate'] : '';

		$requestParams = array(
            'userID' => TP_USERNAME,
            'password' => TP_PASSWORD,
            'orderNo' =>  '',
            'customerRef'=>  '',
            'company'=>  '',
            'department'=>  '',
            'titleOfficer'=>  '',
            'orderComment'=>  '',
            'starterRemarks'=>  '',
            'serviceType'=>  INSTRUMENT_SEARCH_SERVICE_TYPE,
            'parameters'=>  'Document.SearchType=Instrument;Document.RecordDate='.$recDate.'; Document.InstrumentNumber='.$docId.'',
            'state'=>  $state,
            'county'=>  $county,
        );

        $request = TP_TAX_INSTRUMENT_CREATE_SERVICE_ENDPOINT.http_build_query($requestParams);

        $opts = array(
			"ssl"=>array(
		        "verify_peer"=>false,
		        "verify_peer_name"=>false,
		    ),
		);
		$context = stream_context_create($opts);
		$file = file_get_contents($request,false,$context);

		echo trim($file);
	}
}