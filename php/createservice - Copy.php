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

echo "<pre>"; print_r($file); exit;
$ch = curl_init();
 
//Set the URL that you want to GET by using the CURLOPT_URL option.
curl_setopt($ch, CURLOPT_URL, $request);
 
//Set CURLOPT_RETURNTRANSFER so that the content is returned as a variable.
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
 
//Set CURLOPT_FOLLOWLOCATION to true to follow redirects.
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
 
//Execute the request.
$data = curl_exec($ch);
 
 $b = curl_error($ch);
//Close the cURL handle.
curl_close($ch);
 
//Print the data out onto the page.
echo "<pre>123: "; print_r($b); 
echo "<pre>456: "; print_r($data); exit;