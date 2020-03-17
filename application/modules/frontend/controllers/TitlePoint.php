<?php

(defined('BASEPATH')) OR exit('No direct script access allowed');

class TitlePoint extends MY_Controller {

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
			$requestUrl= TP_TAX_CREATE_SERVICE_ENDPOINT;
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

		echo trim($file); 
	}


	function getRequestSummaries()
	{
		$requestId = isset($_POST['requestId']) && !empty($_POST['requestId']) ? $_POST['requestId'] : '';

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
		echo trim($file); 
	}

	function getResultById()
	{
		$resultId = isset($_POST['resultId']) && !empty($_POST['resultId']) ? $_POST['resultId'] : '';
		$methodId = isset($_POST['methodId']) && !empty($_POST['methodId']) ? $_POST['methodId'] : '';

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
}