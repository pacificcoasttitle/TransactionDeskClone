<?php
if(!function_exists('call_homedocs_api')){
    function call_homedocs_api($data) {
        $api_base_url = 'http://dev.homedocs.io/';
        if(!empty(env('HOMEDOCS_URL'))) {
            $api_base_url = env('HOMEDOCS_URL');
        }
        $url = $api_base_url.'api/users';

        $ch = curl_init( $url );
        # Setup request to send json via POST.
        $payload = json_encode($data);
        // echo $payload;die;
        curl_setopt( $ch, CURLOPT_POSTFIELDS, $payload );
        curl_setopt( $ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json','Accept:application/json'));
        # Return response instead of printing.
        curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
        # Send request.
        $result = curl_exec($ch);
        if (curl_errno($ch)) { 
           return false; 
        } 

        // var_dump($result);die;
        curl_close($ch);
        
        return true;

    }
}
