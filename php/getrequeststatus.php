<?php
include dirname(__FILE__).'/../config/config.php';

$requestId = isset($_GET['requestId']) && !empty($_GET['requestId']) ? $_GET['requestId'] : '';

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