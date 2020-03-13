<?php
include dirname(__FILE__).'/../config/config.php';

$fipsCode = isset($_GET['fipCode']) && !empty($_GET['fipCode']) ? $_GET['fipCode'] : '';
$address = isset($_GET['address']) && !empty($_GET['address']) ? $_GET['address'] : '';
$city = isset($_GET['city']) && !empty($_GET['city']) ? $_GET['city'] : '';

$requestParams = array(
                    'userID' => TP_USERNAME,
                    'password' => TP_PASSWORD,
                    'serviceType'=> SERVICE_TYPE,
                    'parameters' => 'Address1='.$address.';City='.$city.';LvLookup=Address;LvLookupValue='.$address.', '.$city.';LvReportFormat=LV;IncludeTaxAssessor=true',
                    'fipsCode' =>  $fipsCode,
                    'orderNo' =>  '',
                    'customerRef'=>  '',
                    'company'=>  '',
                    'department'=>  '',
                    'titleOfficer'=>  '',
                    'orderComment'=>  '',
                    'starterRemarks'=>  '',
                );

$request = TP_CREATE_SERVICE_ENDPOINT.http_build_query($requestParams);

$opts = array(
	"ssl"=>array(
        "verify_peer"=>false,
        "verify_peer_name"=>false,
    ),
);
$context = stream_context_create($opts);
$file = file_get_contents($request,false,$context);

echo trim($file); 