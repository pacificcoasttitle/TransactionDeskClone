<?php

(defined('BASEPATH')) OR exit('No direct script access allowed');

class TitlePoint extends MX_Controller {

	function __construct() {
        parent::__construct();
        $this->load->model('order/apiLogs');
		$this->load->model('order/titlePointData');
		$this->load->library('order/order');
		// $this->order->is_user();
	}

	function createService()
	{
		$userdata = $this->session->userdata('user');
		
		$methodId = isset($_POST['methodId']) && !empty($_POST['methodId']) ? $_POST['methodId'] : '';

		$random_number = isset($_POST['random_number']) && !empty($_POST['random_number']) ? $_POST['random_number'] : '';

		if (empty($random_number)) 
		{	
			$response = array('status'=>'error','message'=> 'Empty random number');
			echo json_encode($response); exit;
		}
		/* Insert into table */
		if(!$this->session->userdata('tp_api_id_'.$random_number)) 
		{
			if($random_number)
			{
				$tpData = 	array(
							'session_id' => 'tp_api_id_'.$random_number,
						);
				$tpId = $this->titlePointData->insert($tpData);

				$this->session->set_userdata('tp_api_id_'.$random_number,1);
			}
		}
		/* Insert into table */

		$requestParams = array(
            'userID' => env('TP_USERNAME'),
            'password' => env('TP_PASSWORD'),
            'orderNo' =>  '',
            'customerRef'=>  567467456743213,
            'company'=>  '',
            'department'=>  '',
            'titleOfficer'=>  '',
            'orderComment'=>  '',
            'starterRemarks'=>  '',
        );

        if($methodId == 3)
		{
			$apn = isset($_POST['apn']) && !empty($_POST['apn']) ? $_POST['apn'] : '';
			$apn = str_replace('0000', '0-000', $apn);
			$state = isset($_POST['state']) && !empty($_POST['state']) ? $_POST['state'] : '';
			$county = isset($_POST['county']) && !empty($_POST['county']) ? $_POST['county'] : '';
			$requestParams['serviceType'] = env('TAX_SEARCH_SERVICE_TYPE');
			$requestParams['parameters'] = 'Tax.APN='.$apn.';General.AutoSearchTaxes=true;General.AutoSearchProperty=false';
			$requestParams['state'] = $state;
			$requestParams['county'] = $county;
			$requestUrl= env('TP_TAX_INSTRUMENT_CREATE_SERVICE_ENDPOINT');
			$request_type= 'create_service_3';
		}
		else if($methodId == 4)
		{
			$fipsCode = isset($_POST['fipCode']) && !empty($_POST['fipCode']) ? $_POST['fipCode'] : '';
			$address = isset($_POST['address']) && !empty($_POST['address']) ? $_POST['address'] : '';
			$city = isset($_POST['city']) && !empty($_POST['city']) ? $_POST['city'] : '';
			$unit_no = isset($_POST['unit_no']) && !empty($_POST['unit_no']) ? $_POST['unit_no'] : '';
			$apn = isset($_POST['apn']) && !empty($_POST['apn']) ? $_POST['apn'] : '';
			$bedRooms = isset($_POST['bedRooms']) ? $_POST['bedRooms'] : '';
			$baths = isset($_POST['baths']) ? $_POST['baths'] : '';
			$lotSize = isset($_POST['lotSize']) && !empty($_POST['lotSize']) ? $_POST['lotSize'] : '';
			$zoning = isset($_POST['zoning']) && !empty($_POST['zoning']) ? $_POST['zoning'] : '';
			$buildingArea = isset($_POST['buildingArea']) && !empty($_POST['buildingArea']) ? $_POST['buildingArea'] : '';
			if($unit_no)
			{
				$unitinfo =  'UnitNumber '.$unit_no.', '; 
			}
			$requestParams['serviceType'] = env('SERVICE_TYPE');
			$requestParams['parameters'] = 'Address1='.$address.';City='.$city.';Pin='.$apn.';LvLookup=Address;LvLookupValue='.$address.', '.$unitinfo.$city.';LvReportFormat=LV;IncludeTaxAssessor=true';
			$requestParams['fipsCode'] = $fipsCode;
			$requestUrl= env('TP_CREATE_SERVICE_ENDPOINT');
			$request_type= 'create_service_4';
		}
		$request = $requestUrl.http_build_query($requestParams);

		$logid = $this->apiLogs->syncLogs($userdata['id'], 'titlepoint', $request_type, $request, $requestParams, array(), $random_number, 0);

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

		$this->apiLogs->syncLogs($userdata['id'], 'titlepoint', $request_type, $request, $requestParams, $result, $random_number, $logid);

		if(isset($result) && empty($result))
		{
			$tpData = 	array(
				'cs4_message' => 'Failed',
			);

			if ($this->session->has_userdata('tp_api_id_'.$random_number)) 
			{
				$session_id = 'tp_api_id_'.$random_number;
				$condition = array(
					'session_id' => $session_id
				);				
				$this->titlePointData->update($tpData,$condition);
			}
			else
			{
				$tpData['session_id'] = 'tp_api_id_'.$random_number;
				

				$tpId = $this->titlePointData->insert($tpData);

				$this->session->set_userdata('tp_api_id_'.$random_number, 1);

			}
		}
		else
		{
			$responseStatus = isset($result['ReturnStatus']) && !empty($result['ReturnStatus']) ? $result['ReturnStatus'] : '';
		
			if($methodId == 4)
			{
				if($responseStatus == 'Success')
				{
					$requestId = isset($result['RequestID']) && !empty($result['RequestID']) ? $result['RequestID'] : '';
					$tpData = 	array(
									'cs4_request_id' => $requestId,
									'property_bedroom' => $bedRooms,
									'property_bathroom' => $baths,
									'property_lotsize' => $lotSize,
									'property_zoning' => $zoning,
									'property_squarefeet' => $buildingArea
								);

					if ($this->session->has_userdata('tp_api_id_'.$random_number)) 
					{
						$session_id = 'tp_api_id_'.$random_number;
						$condition = array(
							'session_id' => $session_id
						);				
						$this->titlePointData->update($tpData,$condition);
					}
					else
					{
						$tpData['session_id'] = 'tp_api_id_'.$random_number;
						

						$tpId = $this->titlePointData->insert($tpData);

						$this->session->set_userdata('tp_api_id_'.$random_number, 1);

					}
				}
				else
				{
					$error = isset($result['ReturnErrors']['ReturnError']['ErrorDescription']) && !empty($result['ReturnErrors']['ReturnError']['ErrorDescription']) ? $result['ReturnErrors']['ReturnError']['ErrorDescription'] : '';
					$this->addLogs($methodId,$responseStatus,'',$error,$random_number);
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

					if ($this->session->has_userdata('tp_api_id_'.$random_number)) 
					{
						$session_id = 'tp_api_id_'.$random_number;
						$condition = array(
							'session_id' => $session_id
						);				
						$this->titlePointData->update($tpData,$condition);
					}
					else
					{
						$tpData['session_id'] = 'tp_api_id_'.$random_number;
						

						$tpId = $this->titlePointData->insert($tpData);

						$this->session->set_userdata('tp_api_id_'.$random_number, 1);

					}
				}
				else
				{
					$error = isset($result['ReturnErrors']['ReturnError']['ErrorDescription']) && !empty($result['ReturnErrors']['ReturnError']['ErrorDescription']) ? $result['ReturnErrors']['ReturnError']['ErrorDescription'] : '';
					$this->addLogs($methodId,$responseStatus,'',$error,$random_number);
				}
			}
			
			echo trim($file);
		}
		 
	}


	function getRequestSummaries()
	{
		$userdata = $this->session->userdata('user');
		$requestId = isset($_POST['requestId']) && !empty($_POST['requestId']) ? $_POST['requestId'] : '';
		$methodId = isset($_POST['methodId']) && !empty($_POST['methodId']) ? $_POST['methodId'] : '';
		$apn = isset($_POST['apn']) && !empty($_POST['apn']) ? $_POST['apn'] : '';
		$random_number = isset($_POST['random_number']) && !empty($_POST['random_number']) ? $_POST['random_number'] : '';
		$random_number = isset($_POST['random_number']) && !empty($_POST['random_number']) ? $_POST['random_number'] : '';

		if (empty($random_number)) 
		{	
			$response = array('status'=>'error','message'=> 'Empty random number');
			echo json_encode($response); exit;
		}
		$requestParams = array(
		                    'userID' => env('TP_USERNAME'),
		                    'password' => env('TP_PASSWORD'),
		                    'company'=>  '',
		                    'department'=>  '',
		                    'titleOfficer'=>  '',
		                    'requestId'=>  $requestId,
		                    'maxWaitSeconds'=>  20
		                );

		$request = env('TP_REQUEST_SUMMARY_ENDPOINT').http_build_query($requestParams);

		$logid = $this->apiLogs->syncLogs($userdata['id'], 'titlepoint', 'get_request_summary_'.$methodId, $request, $requestParams, array(), $random_number, 0);

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

		$this->apiLogs->syncLogs($userdata['id'], 'titlepoint', 'get_request_summary_'.$methodId, $request, $requestParams, $result, $random_number, $logid);

		if(isset($result) && empty($result))
		{
			$tpData = 	array(
				'cs4_message' => 'Failed',
			);

			if ($this->session->has_userdata('tp_api_id_'.$random_number)) 
			{
				$session_id = 'tp_api_id_'.$random_number;
				$condition = array(
					'session_id' => $session_id
				);				
				$this->titlePointData->update($tpData,$condition);
			}
			else
			{
				$tpData['session_id'] = 'tp_api_id_'.$random_number;
				

				$tpId = $this->titlePointData->insert($tpData);

				$this->session->set_userdata('tp_api_id_'.$random_number, 1);

			}
		}
		else
		{
			$responseStatus = isset($result['ReturnStatus']) && !empty($result['ReturnStatus']) ? $result['ReturnStatus'] : '';
			$session_data = array();


			if($methodId == 4)
			{
				if($responseStatus == 'Success')
				{
					$status = isset($result['RequestSummaries']['RequestSummary']['Status']) && !empty($result['RequestSummaries']['RequestSummary']['Status']) ? $result['RequestSummaries']['RequestSummary']['Status'] : '';
					
					if($status == 'Complete')
					{
						$resultId = isset($result['RequestSummaries']['RequestSummary']['Order']['Services']['Service']['ThumbNails']['ResultThumbNail'][0]['ID']) && !empty($result['RequestSummaries']['RequestSummary']['Order']['Services']['Service']['ThumbNails']['ResultThumbNail'][0]['ID']) ? $result['RequestSummaries']['RequestSummary']['Order']['Services']['Service']['ThumbNails']['ResultThumbNail'][0]['ID'] : ''; 
						$serviceId = isset($result['RequestSummaries']['RequestSummary']['Order']['Services']['Service']['ID']) && !empty($result['RequestSummaries']['RequestSummary']['Order']['Services']['Service']['ID']) ? $result['RequestSummaries']['RequestSummary']['Order']['Services']['Service']['ID'] : '';
						
						$tpData = 	array(
							'cs4_result_id' => $resultId,
							'cs4_service_id' => $serviceId,
						);
					}
					else
					{
						$tpData = 	array(
							'cs4_message' => $status,
						);
					}

					if ($this->session->has_userdata('tp_api_id_'.$random_number)) 
					{
						$session_id = 'tp_api_id_'.$random_number;
						$condition = array(
							'session_id' => $session_id
						);				
						$this->titlePointData->update($tpData,$condition);
					}
					else
					{
						$tpData['session_id'] = 'tp_api_id_'.$random_number;
						

						$tpId = $this->titlePointData->insert($tpData);

						$this->session->set_userdata('tp_api_id_'.$random_number, 1);

					}
				}
				else
				{
					$error = isset($result['ReturnErrors']['ReturnError']['ErrorDescription']) && !empty($result['ReturnErrors']['ReturnError']['ErrorDescription']) ? $result['ReturnErrors']['ReturnError']['ErrorDescription'] : '';
					$this->addLogs($methodId,$responseStatus,'',$error,$random_number);
				}
			}
			if($methodId == 3)
			{
				if($responseStatus == 'Success')
				{
					$status = isset($result['RequestSummaries']['RequestSummary']['Status']) && !empty($result['RequestSummaries']['RequestSummary']['Status']) ? $result['RequestSummaries']['RequestSummary']['Status'] : '';

					if($status == 'Complete')
					{
						$resultId = isset($result['RequestSummaries']['RequestSummary']['Order']['Services']['Service']['ThumbNails']['ResultThumbNail']['ID']) && !empty($result['RequestSummaries']['RequestSummary']['Order']['Services']['Service']['ThumbNails']['ResultThumbNail']['ID']) ? $result['RequestSummaries']['RequestSummary']['Order']['Services']['Service']['ThumbNails']['ResultThumbNail']['ID'] : '';
						$serviceId = isset($result['RequestSummaries']['RequestSummary']['Order']['Services']['Service']['ID']) && !empty($result['RequestSummaries']['RequestSummary']['Order']['Services']['Service']['ID']) ? $result['RequestSummaries']['RequestSummary']['Order']['Services']['Service']['ID'] : '';
						$tpData = 	array(
							'cs3_result_id' => $resultId,
							'cs3_service_id' => $serviceId,
						);
					}
					else
					{
						$tpData = 	array(
							'cs3_message' => $status,
						);
					}
					
					
					if ($this->session->has_userdata('tp_api_id_'.$random_number)) 
					{
						$session_id = 'tp_api_id_'.$random_number;
						$condition = array(
							'session_id' => $session_id
						);				
						$this->titlePointData->update($tpData,$condition);
					}
					else
					{
						$tpData['session_id'] = 'tp_api_id_'.$random_number;
						

						$tpId = $this->titlePointData->insert($tpData);

						$this->session->set_userdata('tp_api_id_'.$random_number, 1);

					}
				}
				else
				{
					$error = isset($result['ReturnErrors']['ReturnError']['ErrorDescription']) && !empty($result['ReturnErrors']['ReturnError']['ErrorDescription']) ? $result['ReturnErrors']['ReturnError']['ErrorDescription'] : '';
					$this->addLogs($methodId,$responseStatus,'',$error,$random_number);
				}
			}
			
			echo trim($file);
		}
		
	}

	function getResultById()
	{
		$userdata = $this->session->userdata('user');
		$resultId = isset($_POST['resultId']) && !empty($_POST['resultId']) ? $_POST['resultId'] : '';
		$methodId = isset($_POST['methodId']) && !empty($_POST['methodId']) ? $_POST['methodId'] : '';
		$apn = isset($_POST['apn']) && !empty($_POST['apn']) ? $_POST['apn'] : '';
		$random_number = isset($_POST['random_number']) && !empty($_POST['random_number']) ? $_POST['random_number'] : '';
		if (empty($random_number)) 
		{	
			$response = array('status'=>'error','message'=> 'Empty random number');
			echo json_encode($response); exit;
		}
		$requestParams = array(
		                    'userID' => env('TP_USERNAME'),
		                    'password' => env('TP_PASSWORD'),
		                    'company'=>  '',
		                    'department'=>  '',
		                    'titleOfficer'=>  '',
		                    'resultID'=>  $resultId
		                );

		$resultUrl = env('TP_GET_RESULT_BY_ID');

		if($methodId == 3)
		{
		    $requestParams['requestingTPXML'] = 'true';
		    $resultUrl = env('TP_GET_RESULT_BY_ID_3');
		}

		$request = $resultUrl.http_build_query($requestParams);

		$logid = $this->apiLogs->syncLogs($userdata['id'], 'titlepoint', 'get_result_by_id_'.$methodId, $request, $requestParams, array(), $random_number, 0);

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

		$this->apiLogs->syncLogs($userdata['id'], 'titlepoint', 'get_result_by_id_'.$methodId, $request, $requestParams, $result, $random_number, $logid);

		if(isset($result) && empty($result))
		{
			$tpData = 	array(
				'cs4_message' => 'Failed',
			);

			if ($this->session->has_userdata('tp_api_id_'.$random_number)) 
			{
				$session_id = 'tp_api_id_'.$random_number;
				$condition = array(
					'session_id' => $session_id
				);				
				$this->titlePointData->update($tpData,$condition);
			}
			else
			{
				$tpData['session_id'] = 'tp_api_id_'.$random_number;
				

				$tpId = $this->titlePointData->insert($tpData);

				$this->session->set_userdata('tp_api_id_'.$random_number, 1);

			}
		}
		else
		{
			$responseStatus = isset($result['ReturnStatus']) && !empty($result['ReturnStatus']) ? $result['ReturnStatus'] : '';
			$session_data = array();
			
			if($methodId == 4)
			{
				if($responseStatus == 'Success')
				{
					$briefLegal = isset($result['Result']['BriefLegal']) && !empty($result['Result']['BriefLegal']) ? $result['Result']['BriefLegal'] : '';
					
		            $vesting = isset($result['Result']['Vesting']) && !empty($result['Result']['Vesting']) ? $result['Result']['Vesting'] : '';

		            $fips = isset($result['Result']['Fips']) && !empty($result['Result']['Fips']) ? $result['Result']['Fips'] : '';
		            
		            $legal_vesting_info = isset($result['Result']['LvDeeds']['LegalAndVesting2DeedInfo']) && !empty($result['Result']['LvDeeds']['LegalAndVesting2DeedInfo']) ? $result['Result']['LvDeeds']['LegalAndVesting2DeedInfo'] : array();
		            
		            if (count($legal_vesting_info) == count($legal_vesting_info, COUNT_RECURSIVE))
		            {
		            	$docType = isset($result['Result']['LvDeeds']['LegalAndVesting2DeedInfo']['DocType']) && !empty($result['Result']['LvDeeds']['LegalAndVesting2DeedInfo']['DocType']) ? $result['Result']['LvDeeds']['LegalAndVesting2DeedInfo']['DocType'] : '';
		            	$docType = strtolower($docType);

		            	if($docType == 'grant deed' || $docType == 'intrafamily transfer & dissolution' || $docType == 'quit claim deed' || $docType == 'intra-family transfer or dissolution')
		            	{
		            		$instrumentNumber = isset($result['Result']['LvDeeds']['LegalAndVesting2DeedInfo']['InstrumentNumber']) && !empty($result['Result']['LvDeeds']['LegalAndVesting2DeedInfo']['InstrumentNumber']) ? $result['Result']['LvDeeds']['LegalAndVesting2DeedInfo']['InstrumentNumber'] : '';
		            		$recordedDate = isset($result['Result']['LvDeeds']['LegalAndVesting2DeedInfo']['RecordedDate']) && !empty($result['Result']['LvDeeds']['LegalAndVesting2DeedInfo']['RecordedDate']) ? $result['Result']['LvDeeds']['LegalAndVesting2DeedInfo']['RecordedDate'] : '';
		            	}
		            	
		            }
		            else
		            {
		            	foreach ($legal_vesting_info as $key => $value) 
		            	{
		            		$docType = isset($value['DocType']) && !empty($value['DocType']) ? $value['DocType'] : '';
		            		$docType = strtolower($docType);
		            		$instruNumber = isset($value['InstrumentNumber']) && !empty($value['InstrumentNumber']) ? $value['InstrumentNumber'] : '';
		            		if(!empty($instruNumber) && ($docType == 'grant deed' || $docType == 'intrafamily transfer & dissolution' || $docType == 'quit claim deed' || $docType == 'intra-family transfer or dissolution'))
		            		{
		            			$instrumentNumber = isset($value['InstrumentNumber']) && !empty($value['InstrumentNumber']) ? $value['InstrumentNumber'] : '';
		            			$recordedDate = isset($value['RecordedDate']) && !empty($value['RecordedDate']) ? $value['RecordedDate'] : '';
		            			break;
		            		}
		            	}	            	
		            }
		            $status = isset($result['Result']['Status']) && !empty($result['Result']['Status']) ? $result['Result']['Status'] : '';

		            $tpData = 	array(
						'legal_description' => $briefLegal,
						'vesting_information' => $vesting,
						'cs4_instrument_no' => $instrumentNumber,
						'cs4_recorded_date' => $recordedDate,
						'grant_deed_type' => $docType,
						'fips' => $fips,
						// 'cs4_result_id_status' => $status,
					);

			       	if ($this->session->has_userdata('tp_api_id_'.$random_number)) 
					{
						$session_id = 'tp_api_id_'.$random_number;
						$condition = array(
							'session_id' => $session_id
						);				
						$this->titlePointData->update($tpData,$condition);
					}
					else
					{
						$tpData['session_id'] = 'tp_api_id_'.$random_number;
						

						$tpId = $this->titlePointData->insert($tpData);

						$this->session->set_userdata('tp_api_id_'.$random_number, 1);

					}
					$this->addLogs($methodId,$responseStatus,$status,$error,$random_number);
				}
				else
				{
					$error = isset($result['ReturnErrors']['ReturnError']['ErrorDescription']) && !empty($result['ReturnErrors']['ReturnError']['ErrorDescription']) ? $result['ReturnErrors']['ReturnError']['ErrorDescription'] : '';
					$this->addLogs($methodId,$responseStatus,'',$error,$random_number);
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
					
					$status = isset($result['Result']['TaxReport']['Status']) && !empty($result['Result']['TaxReport']['Status']) ? $result['Result']['TaxReport']['Status'] : '';
					if($status == 'Success')
					{
						$message = 'Success';
					}
					else
					{
						$message = isset($result['Result']['TaxReport']['WarningMessage']) && !empty($result['Result']['TaxReport']['WarningMessage']) ? $result['Result']['TaxReport']['WarningMessage'] : '';
					}
					
					$tpData = 	array(
						'first_installment' => json_encode($firstInstallment),
						'second_installment' => json_encode($secondInstallment),
					);

					if ($this->session->has_userdata('tp_api_id_'.$random_number)) 
					{
						$session_id = 'tp_api_id_'.$random_number;
						$condition = array(
							'session_id' => $session_id
						);				
						$this->titlePointData->update($tpData,$condition);
					}
					else
					{
						$tpData['session_id'] = 'tp_api_id_'.$random_number;
						

						$tpId = $this->titlePointData->insert($tpData);

						$this->session->set_userdata('tp_api_id_'.$random_number, 1);

					}
					$this->addLogs($methodId,$responseStatus,$message,$error,$random_number);
				}
				else
				{
					$error = isset($result['ReturnErrors']['ReturnError']['ErrorDescription']) && !empty($result['ReturnErrors']['ReturnError']['ErrorDescription']) ? $result['ReturnErrors']['ReturnError']['ErrorDescription'] : '';
					$this->addLogs($methodId,$responseStatus,'',$error,$random_number);
				}
			}
			echo trim($file);
		}
		
	}

	function imageCreateRequest()
	{
		$userdata = $this->session->userdata('user');
		$serviceId = isset($_POST['serviceId']) && !empty($_POST['serviceId']) ? $_POST['serviceId'] : '';

		if($serviceId)
		{	
			$requestParams = array(
		        'username' => env('TP_USERNAME'),
		        'password' => env('TP_PASSWORD'),
		        'serviceId1' =>  $serviceId,
		        'serviceId2'=>  '',
		        'source'=>  '',
		        'clientKey1'=>  '',
		        'clientKey2'=>  '',
		        'sortOrder'=>  '',
		        'fileType'=>  'pdf',
		    );
			$requestUrl= env('TP_IMAGE_ENDPOINT');
		}

		$request = $requestUrl.http_build_query($requestParams);

		$logid = $this->apiLogs->syncLogs($userdata['id'], 'titlepoint', 'create_image_request', $request, $requestParams, array(), 0, 0);

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

        $this->apiLogs->syncLogs($userdata['id'], 'titlepoint', 'create_image_request', $request, $requestParams, $result, 0, $logid);
		echo trim($file);
	}

	function getRequestStatus()
	{
		$userdata = $this->session->userdata('user');
		$requestId = isset($_POST['requestId']) && !empty($_POST['requestId']) ? $_POST['requestId'] : '';

		$requestParams = array(
                            'username' => env('TP_USERNAME'),
                            'password' => env('TP_PASSWORD'),                    
                            'requestId'=>  $requestId
                        );
        $request = env('TP_IMAGE_REQUEST_STATUS').http_build_query($requestParams);

        $logid = $this->apiLogs->syncLogs($userdata['id'], 'titlepoint', 'image_request_status', $request, $requestParams, array(), 0, 0);

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

        $result = json_decode($response, TRUE);

        $this->apiLogs->syncLogs($userdata['id'], 'titlepoint', 'image_request_status', $request, $requestParams, $result, 0, $logid);
		echo trim($file); 
	}

	function generateImage()
	{
		$userdata = $this->session->userdata('user');
		$requestId = isset($_POST['requestId']) && !empty($_POST['requestId']) ? $_POST['requestId'] : '';
		$methodId = isset($_POST['methodId']) && !empty($_POST['methodId']) ? $_POST['methodId'] : '';
		$fileNumber = isset($_POST['fileNumber']) && !empty($_POST['fileNumber']) ? $_POST['fileNumber'] : '';

		$requestParams = array(
		                    'username' => env('TP_USERNAME'),
		                    'password' => env('TP_PASSWORD'),                    
		                    'requestId'=>  $requestId
		                );

		$request = env('TP_GENERATE_IMAGE').http_build_query($requestParams);

		$logid = $this->apiLogs->syncLogs($userdata['id'], 'titlepoint', 'generate_image', $request, $requestParams, array(), 0, 0);

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

		$this->apiLogs->syncLogs($userdata['id'], 'titlepoint', 'generate_image', $request, $requestParams, $result, 0, $logid);

		$responseStatus = isset($result['ReturnStatus']) && !empty($result['ReturnStatus']) ? $result['ReturnStatus'] : '';
		if($responseStatus == 'Success')
		{
			$base64_data = isset($result['Data']) && !empty($result['Data']) ? $result['Data'] : '';
			$bin = base64_decode($base64_data, true);

			if ($this->session->has_userdata('tp_api_id')) 
			{
				$fileNumber = $this->session->userdata('tp_api_id');
			}
			if($methodId == 4)
			{
				if (!is_dir('uploads/legal-vesting')) {
				    mkdir('./uploads/legal-vesting', 0777, TRUE);
				}
				$pdfFilePath = './uploads/legal-vesting/'.$fileNumber.'.pdf';
				file_put_contents($pdfFilePath, $bin);
				$this->order->uploadDocumentOnAwsS3($fileNumber.'.pdf', 'legal-vesting');
			}
			if($methodId == 3)
			{
				if (!is_dir('uploads/tax')) {
				    mkdir('./uploads/tax', 0777, TRUE);
				}
				$pdfFilePath = './uploads/tax/'.$fileNumber.'.pdf';
				file_put_contents($pdfFilePath, $bin);
				$this->order->uploadDocumentOnAwsS3($fileNumber.'.pdf', 'tax');
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
            'userID' => env('TP_USERNAME'),
            'password' => env('TP_PASSWORD'),
            'orderNo' =>  '',
            'customerRef'=>  '',
            'company'=>  '',
            'department'=>  '',
            'titleOfficer'=>  '',
            'orderComment'=>  '',
            'starterRemarks'=>  '',
            'serviceType'=>  env('INSTRUMENT_SEARCH_SERVICE_TYPE'),
            'parameters'=>  'Document.SearchType=Instrument;Document.RecordDate='.$recDate.'; Document.InstrumentNumber='.$docId.'',
            'state'=>  $state,
            'county'=>  $county,
        );

        $request = env('TP_TAX_INSTRUMENT_CREATE_SERVICE_ENDPOINT').http_build_query($requestParams);

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
		$userdata = $this->session->userdata('user');
		$fips = isset($_POST['fips']) && !empty($_POST['fips']) ? $_POST['fips'] : '';
		$year = isset($_POST['year']) && !empty($_POST['year']) ? $_POST['year'] : '';
		$docId = isset($_POST['docId']) && !empty($_POST['docId']) ? $_POST['docId'] : '';
		$fileNumber = isset($_POST['fileNumber']) && !empty($_POST['fileNumber']) ? $_POST['fileNumber'] : '';

		$requestParams = array(
			'parameters'=>'FIPS='.$fips.',TYPE=REC,SUBTYPE=ALL,YEAR='.$year.',INST='.$docId.'',
            'username' => env('TP_USERNAME'),
            'password' => env('TP_PASSWORD'),            
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

        $request = env('GRANT_DEED_ENDPOINT').http_build_query($requestParams);

        $opts = array(
			"ssl"=>array(
		        "verify_peer"=>false,
		        "verify_peer_name"=>false,
		    ),
		);
		$context = stream_context_create($opts);
		$logid = $this->apiLogs->syncLogs($userdata['id'], 'titlepoint', 'generate_grant_deed', $request, $requestParams, array(), 0, 0);

		$file = file_get_contents($request,false,$context);
		$xmlData = simplexml_load_string($file);
		$response = json_encode($xmlData);
		$result = json_decode($response,TRUE);
		
		$this->apiLogs->syncLogs($userdata['id'], 'titlepoint', 'generate_grant_deed', $request, $requestParams, $result, 0, $logid);

		$responseStatus = isset($result['Status']['Msg']) && !empty($result['Status']['Msg']) ? $result['Status']['Msg'] : '';
		$docStatus = isset($result['Documents']['DocumentResponse']['DocStatus']['Msg']) && !empty($result['Documents']['DocumentResponse']['DocStatus']['Msg']) ? $result['Documents']['DocumentResponse']['DocStatus']['Msg'] : '';
		$docStatus = strtolower($docStatus);

        if(isset($docStatus) && !empty($docStatus) && $docStatus == 'ok')
		{
			$base64_data = isset($result['Documents']['DocumentResponse']['Document']['Body']['Body']) && !empty($result['Documents']['DocumentResponse']['Document']['Body']['Body']) ? $result['Documents']['DocumentResponse']['Document']['Body']['Body'] : '';

			if(isset($base64_data) && !empty($base64_data))
			{
				$bin = base64_decode($base64_data, true);		
			
				if (!is_dir('uploads/grant-deed')) {
				    mkdir('./uploads/grant-deed', 0777, TRUE);
				}
				$pdfFilePath = './uploads/grant-deed/'.$fileNumber.'.pdf';
				file_put_contents($pdfFilePath, $bin);
				$this->order->uploadDocumentOnAwsS3($fileNumber.'.pdf', 'grant-deed');
				$tpData = array(
	                'grant_deed_status' => $docStatus,
	                'grant_deed_message' => 'success'
	            );
			}
			else
			{
				$tpData = array(
                    'grant_deed_status' => 'failed',
                    'grant_deed_message' => 'failed'
                );
			}
			
		}
		else
		{
			$tpData = array(
                'grant_deed_status' => 'Failed',
                'grant_deed_message' => $docStatus
            );
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
		echo trim($file);
	}

	public function addLogs($methodId,$returnStatus,$status='',$error,$random_number)
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

   		if ($this->session->has_userdata('tp_api_id_'.$random_number)) 
		{
			$session_id = 'tp_api_id_'.$random_number;
			$condition = array(
				'session_id' => $session_id
			);				
			$this->titlePointData->update($tpData,$condition);
		}
		else
		{
			$tpData['session_id'] = 'tp_api_id_'.$random_number;
			

			$tpId = $this->titlePointData->insert($tpData);

			$this->session->set_userdata('tp_api_id_'.$random_number, 1);

		}
		
    }
}