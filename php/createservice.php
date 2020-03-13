<?php
session_start();

if(isset($_SESSION['customer_number']) && !empty($_SESSION['customer_number']))
{
	unset($_SESSION['customer_number']);
}

include dirname(__FILE__).'/../config/config.php';

$methodId = isset($_GET['methodId']) && !empty($_GET['methodId']) ? $_GET['methodId'] : '';
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
	$apn = isset($_GET['apn']) && !empty($_GET['apn']) ? $_GET['apn'] : '';
	$state = isset($_GET['state']) && !empty($_GET['state']) ? $_GET['state'] : '';
	$county = isset($_GET['county']) && !empty($_GET['county']) ? $_GET['county'] : '';
	$requestParams['serviceType'] = TAX_SEARCH_SERVICE_TYPE;
	$requestParams['parameters'] = 'Tax.APN='.$apn.';General.AutoSearchTaxes=true;General.AutoSearchProperty=false';
	$requestParams['state'] = $state;
	$requestParams['county'] = $county;
	$requestUrl= TP_TAX_CREATE_SERVICE_ENDPOINT;
}
else if($methodId == 4)
{
	$fipsCode = isset($_GET['fipCode']) && !empty($_GET['fipCode']) ? $_GET['fipCode'] : '';
	$address = isset($_GET['address']) && !empty($_GET['address']) ? $_GET['address'] : '';
	$city = isset($_GET['city']) && !empty($_GET['city']) ? $_GET['city'] : '';

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