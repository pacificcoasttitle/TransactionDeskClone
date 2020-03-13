<?php
include dirname(__FILE__).'/../config/config.php';

$serviceId = isset($_GET['serviceId']) && !empty($_GET['serviceId']) ? $_GET['serviceId'] : '';


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