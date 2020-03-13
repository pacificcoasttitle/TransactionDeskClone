<?php
include dirname(__FILE__).'/../config/config.php';

$resultId = isset($_GET['resultId']) && !empty($_GET['resultId']) ? $_GET['resultId'] : '';
$methodId = isset($_GET['methodId']) && !empty($_GET['methodId']) ? $_GET['methodId'] : '';

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