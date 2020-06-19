<?php

(defined('BASEPATH')) OR exit('No direct script access allowed');

class TitlePoint extends MX_Controller {

	function __construct() {
        parent::__construct();
        // $this->load->model('order/apiLogs');
		$this->load->model('order/titlePointData');
	}

	function createService()
	{
		/*if($this->session->has_userdata('tp_api_id'))
		{
			$this->session->unset_userdata('tp_api_id');
		}*/
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
			$unit_no = isset($_POST['unit_no']) && !empty($_POST['unit_no']) ? $_POST['unit_no'] : '';
			$apn = isset($_POST['apn']) && !empty($_POST['apn']) ? $_POST['apn'] : '';
			if($unit_no)
			{
				$unitinfo =  'UnitNumber '.$unit_no.', '; 
			}
			$requestParams['serviceType'] = SERVICE_TYPE;
			$requestParams['parameters'] = 'Address1='.$address.';City='.$city.';Pin='.$apn.';LvLookup=Address;LvLookupValue='.$address.', '.$unitinfo.$city.';LvReportFormat=LV;IncludeTaxAssessor=true';
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
				$tpData = 	array(
								'cs4_request_id' => $requestId,
							);

				if ($this->session->has_userdata('tp_api_id')) 
				{
					$id = $this->session->userdata('tp_api_id');
					$condition = array(
						'id' => $id
					);					
					$this->titlePointData->update($tpData,$condition);
				}
				else
				{
					$tpId = $this->titlePointData->insert($tpData);

					if($tpId)
					{
						$this->session->set_userdata('tp_api_id', $tpId);
					}
				}
			}
			else
			{
				$error = isset($result['ReturnErrors']['ReturnError']['ErrorDescription']) && !empty($result['ReturnErrors']['ReturnError']['ErrorDescription']) ? $result['ReturnErrors']['ReturnError']['ErrorDescription'] : '';
				$this->addLogs($methodId,$responseStatus,'',$error);
			}
			
		}
		if($methodId == 3)
		{
			if($responseStatus == 'Success')
			{
				$requestId = isset($result['RequestID']) && !empty($result['RequestID']) ? $result['RequestID'] : '';

				$tpData = 	array(
								'cs3_request_id' => $requestId,
							);

				if ($this->session->has_userdata('tp_api_id')) 
				{
					$id = $this->session->userdata('tp_api_id');
					$condition = array(
						'id' => $id
					);					
					$this->titlePointData->update($tpData,$condition);
				}
				else
				{
					$tpId = $this->titlePointData->insert($tpData);

					if($tpId)
					{
						$this->session->set_userdata('tp_api_id', $tpId);
					}
				}
			}
			else
			{
				$error = isset($result['ReturnErrors']['ReturnError']['ErrorDescription']) && !empty($result['ReturnErrors']['ReturnError']['ErrorDescription']) ? $result['ReturnErrors']['ReturnError']['ErrorDescription'] : '';
				$this->addLogs($methodId,$responseStatus,'',$error);
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
				
				$tpData = 	array(
					'cs4_result_id' => $resultId,
					'cs4_service_id' => $serviceId,
				);
				if ($this->session->has_userdata('tp_api_id')) 
				{
					$id = $this->session->userdata('tp_api_id');
					$condition = array(
						'id' => $id
					);					
					$this->titlePointData->update($tpData,$condition);
				}
				else
				{
					$tpId = $this->titlePointData->insert($tpData);
					if($tpId)
					{
						$this->session->set_userdata('tp_api_id', $tpId);
					}
				}
			}
			else
			{
				$error = isset($result['ReturnErrors']['ReturnError']['ErrorDescription']) && !empty($result['ReturnErrors']['ReturnError']['ErrorDescription']) ? $result['ReturnErrors']['ReturnError']['ErrorDescription'] : '';
				$this->addLogs($methodId,$responseStatus,'',$error);
			}
		}
		if($methodId == 3)
		{
			if($responseStatus == 'Success')
			{
				$resultId = isset($result['RequestSummaries']['RequestSummary']['Order']['Services']['Service']['ThumbNails']['ResultThumbNail']['ID']) && !empty($result['RequestSummaries']['RequestSummary']['Order']['Services']['Service']['ThumbNails']['ResultThumbNail']['ID']) ? $result['RequestSummaries']['RequestSummary']['Order']['Services']['Service']['ThumbNails']['ResultThumbNail']['ID'] : '';
				
				$tpData = 	array(
					'cs3_result_id' => $resultId
				);
				if ($this->session->has_userdata('tp_api_id')) 
				{
					$id = $this->session->userdata('tp_api_id');
					$condition = array(
						'id' => $id
					);					
					$this->titlePointData->update($tpData,$condition);
				}
				else
				{
					$tpId = $this->titlePointData->insert($tpData);
					if($tpId)
					{
						$this->session->set_userdata('tp_api_id', $tpId);
					}
				}
			}
			else
			{
				$error = isset($result['ReturnErrors']['ReturnError']['ErrorDescription']) && !empty($result['ReturnErrors']['ReturnError']['ErrorDescription']) ? $result['ReturnErrors']['ReturnError']['ErrorDescription'] : '';
				$this->addLogs($methodId,$responseStatus,'',$error);
			}
		}
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
		
		if($methodId == 4)
		{
			if($responseStatus == 'Success')
			{
				$briefLegal = isset($result['Result']['BriefLegal']) && !empty($result['Result']['BriefLegal']) ? $result['Result']['BriefLegal'] : '';
				
	            $vesting = isset($result['Result']['Vesting']) && !empty($result['Result']['Vesting']) ? $result['Result']['Vesting'] : '';

	            $fips = isset($result['Result']['Fips']) && !empty($result['Result']['Fips']) ? $result['Result']['Fips'] : '';
	            
	            $instrumentNumber = isset($result['Result']['LvDeeds']['LegalAndVesting2DeedInfo'][0]['InstrumentNumber']) && !empty($result['Result']['LvDeeds']['LegalAndVesting2DeedInfo'][0]['InstrumentNumber']) ? $result['Result']['LvDeeds']['LegalAndVesting2DeedInfo'][0]['InstrumentNumber'] : '';
	            $recordedDate = isset($result['Result']['LvDeeds']['LegalAndVesting2DeedInfo'][0]['RecordedDate']) && !empty($result['Result']['LvDeeds']['LegalAndVesting2DeedInfo'][0]['RecordedDate']) ? $result['Result']['LvDeeds']['LegalAndVesting2DeedInfo'][0]['RecordedDate'] : '';
	            $status = isset($result['Result']['Status']) && !empty($result['Result']['Status']) ? $result['Result']['Status'] : '';

	            $tpData = 	array(
					'legal_description' => $briefLegal,
					'vesting_information' => $vesting,
					'cs4_instrument_no' => $instrumentNumber,
					'cs4_recorded_date' => $recordedDate,
					'fips' => $fips,
					'cs4_result_id_status' => $status,
				);

		       	if ($this->session->has_userdata('tp_api_id')) 
				{
					$id = $this->session->userdata('tp_api_id');
					$condition = array(
						'id' => $id
					);					
					$this->titlePointData->update($tpData,$condition);
					
				}
				else
				{
					$tpId = $this->titlePointData->insert($tpData);

					if($tpId)
					{
						$this->session->set_userdata('tp_api_id', $tpId);
					}
				}
				$this->addLogs($methodId,$responseStatus,$status,$error);
			}
			else
			{
				$error = isset($result['ReturnErrors']['ReturnError']['ErrorDescription']) && !empty($result['ReturnErrors']['ReturnError']['ErrorDescription']) ? $result['ReturnErrors']['ReturnError']['ErrorDescription'] : '';
				$this->addLogs($methodId,$responseStatus,'',$error);
			}
		}
		if($methodId == 3)
		{
			if($responseStatus == 'Success')
			{
				$firstInstallment = $secondInstallment = array();
				if(isset($result['Result']['TaxReport']['Installments']['Item'][0]) && !empty($result['Result']['TaxReport']['Installments']['Item'][0]))
				{
					$firstInstallment = $result['Result']['TaxReport']['Installments']['Item'][0];
					
				}

				if(isset($result['Result']['TaxReport']['Installments']['Item'][1]) && !empty($result['Result']['TaxReport']['Installments']['Item'][1]))
				{
					$secondInstallment = $result['Result']['TaxReport']['Installments']['Item'][1];			
				}
				$status = isset($result['Result']['Status']) && !empty($result['Result']['Status']) ? $result['Result']['Status'] : '';
				$tpData = 	array(
					'first_installment' => json_encode($firstInstallment),
					'second_installment' => json_encode($secondInstallment),
				);

				if ($this->session->has_userdata('tp_api_id')) 
				{
					$id = $this->session->userdata('tp_api_id');
					$condition = array(
						'id' => $id
					);					
					$this->titlePointData->update($tpData,$condition);
				}
				else
				{
					$tpId = $this->titlePointData->insert($tpData);

					if($tpId)
					{
						$this->session->set_userdata('tp_api_id', $tpId);
					}
				}
				$this->addLogs($methodId,$responseStatus,$status,$error);
			}
			else
			{
				$error = isset($result['ReturnErrors']['ReturnError']['ErrorDescription']) && !empty($result['ReturnErrors']['ReturnError']['ErrorDescription']) ? $result['ReturnErrors']['ReturnError']['ErrorDescription'] : '';
				$this->addLogs($methodId,$responseStatus,'',$error);
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
		$methodId = isset($_POST['methodId']) && !empty($_POST['methodId']) ? $_POST['methodId'] : '';
		$fileNumber = isset($_POST['fileNumber']) && !empty($_POST['fileNumber']) ? $_POST['fileNumber'] : '';

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

		$xmlData = simplexml_load_string($file);
		$response = json_encode($xmlData);
		$result = json_decode($response,TRUE);
		$responseStatus = isset($result['ReturnStatus']) && !empty($result['ReturnStatus']) ? $result['ReturnStatus'] : '';
		if($responseStatus == 'Success')
		{
			$base64_data = isset($result['Data']) && !empty($result['Data']) ? $result['Data'] : '';
			$bin = base64_decode($base64_data, true);
			
			if($methodId == 4)
			{
				if (!is_dir('uploads/legal-vesting')) {
				    mkdir('./uploads/legal-vesting', 0777, TRUE);
				}
				$pdfFilePath = './uploads/legal-vesting/'.$fileNumber.'.pdf';
				file_put_contents($pdfFilePath, $bin);
			}
			if($methodId == 3)
			{
				if (!is_dir('uploads/grant-deed')) {
				    mkdir('./uploads/grant-deed', 0777, TRUE);
				}
				$pdfFilePath = './uploads/grant-deed/'.$fileNumber.'.pdf';
				file_put_contents($pdfFilePath, $bin);
			}

		}
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

	function generateGrantDeed()
	{
		$fips = isset($_POST['fips']) && !empty($_POST['fips']) ? $_POST['fips'] : '';
		$year = isset($_POST['year']) && !empty($_POST['year']) ? $_POST['year'] : '';
		$docId = isset($_POST['docId']) && !empty($_POST['docId']) ? $_POST['docId'] : '';
		$fileNumber = isset($_POST['fileNumber']) && !empty($_POST['fileNumber']) ? $_POST['fileNumber'] : '';

		$requestParams = array(
			'parameters'=>'FIPS='.$fips.',TYPE=REC,SUBTYPE=ALL,YEAR='.$year.',INST='.$docId.'',
            'username' => TP_USERNAME,
            'password' => TP_PASSWORD,            
            'company'=>  '',
            'department'=>  '',
            'titleOfficer'=>  '',
            'pages'=>  '',
            'propertyOnly'=>  'FALSE',
            'maxPageCount'=>  0,
            'maxSizeInKB'=>  0,           	
            'additionalInfo'=>  '',            
            'customerRef'=>  '',
            'fileType'=>  'PDF',
        );

        $request = GRANT_DEED_ENDPOINT.http_build_query($requestParams);

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
		
		$responseStatus = isset($result['Documents']['DocumentResponse']['DocStatus']['Msg']) && !empty($result['Documents']['DocumentResponse']['DocStatus']['Msg']) ? $result['Documents']['DocumentResponse']['DocStatus']['Msg'] : '';
		if($responseStatus == 'OK')
		{
			$base64_data = isset($result['Documents']['DocumentResponse']['Document']['Body']['Body']) && !empty($result['Documents']['DocumentResponse']['Document']['Body']['Body']) ? $result['Documents']['DocumentResponse']['Document']['Body']['Body'] : '';

			$bin = base64_decode($base64_data, true);		
			
			if (!is_dir('uploads/grant-deed')) {
			    mkdir('./uploads/grant-deed', 0777, TRUE);
			}
			$pdfFilePath = './uploads/grant-deed/'.$fileNumber.'.pdf';
			file_put_contents($pdfFilePath, $bin);
		}
		
		echo trim($file);
	}

	public function addLogs($methodId,$returnStatus,$status='',$error)
    {
    	if($returnStatus == 'Failed')
		{
			if($methodId == 4)
			{
				$tpData = 	array(
								'cs4_message' => $error,
							);
			}
			elseif($methodId == 3)
			{
				$tpData = 	array(
								'cs3_message' => $error,
							);
			}
			
		}
		else
		{
			if($methodId == 4)
			{
				$tpData = 	array(
								'cs4_message' => $status,
							);
			}
			elseif($methodId == 3)
			{
				$tpData = 	array(
								'cs3_message' => $status,
							);
			}
		}

   		if ($this->session->has_userdata('tp_api_id')) 
		{
			$id = $this->session->userdata('tp_api_id');
			$condition = array(
				'id' => $id
			);					
			$this->titlePointData->update($tpData,$condition);
		}
		else
		{
			$tpId = $this->titlePointData->insert($tpData);

			if($tpId)
			{
				$this->session->set_userdata('tp_api_id', $tpId);
			}
		}
		
    }
}