<?php

$curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => 'https://authtr.fnf.com/api/FnfAuthIdentityProvider/GetToken',
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => '',
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => 'POST',
  CURLOPT_POSTFIELDS =>'{"clientId":"a7884552-0fb5-4638-a35c-e3a19ac4d242","secretKey":"e3b962f8-9eec-4ac0-a39f-d3600a4bb292"}',
  CURLOPT_HTTPHEADER => array(
    'Content-Type: application/json',
    'Cookie: ApplicationGatewayAffinity=fad5af1966bfb1a40ad389b2926bd556569b7a1e9a8686cc312d530d855e278a; ApplicationGatewayAffinityCORS=fad5af1966bfb1a40ad389b2926bd556569b7a1e9a8686cc312d530d855e278a'
  ),
));

$response = curl_exec($curl);

curl_close($curl);
echo $response;
