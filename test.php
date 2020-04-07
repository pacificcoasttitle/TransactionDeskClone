<?php

$handle = curl_init();
 
    $url = "https://www.ladygaga.com";
     
    
    curl_setopt($handle, CURLOPT_URL, $url);
    
    curl_setopt($handle, CURLOPT_RETURNTRANSFER, true);
     
    $output = curl_exec($handle);

    if(curl_exec($handle) === false)
    {
        echo 'Curl error: ' . curl_error($handle);
    }
    else
    {
        echo 'Operation completed without any errors';
    }
     
    curl_close($handle);
     
    echo $output;exit;

?>