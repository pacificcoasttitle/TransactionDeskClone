<?php
if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class SoftPro
{
    public static $CI;

    public function __construct($params = array())
    {
        $this->CI = &get_instance();
        $this->CI->load->database();
        $this->CI->load->library('email');
        $this->CI->load->library('session');
        self::$CI = $this->CI;
    }

    public function make_request($http_method, $endpoint, $postData = '', $data = array())
    {
        $url = getenv("SOFT_PRO_API") . $endpoint;
        $header = [
            'Content-Type: application/json', // Set JSON content type
        ];
        if (false) {
            $header = [
                'Content-Type: application/json', // Set JSON content type
                'X-API-KEY: YOUR_TOKEN_HERE', // Add Authorization header if needed
            ];
        }
        // Initialize cURL
        $ch = curl_init();
        // Set cURL options
        curl_setopt($ch, CURLOPT_URL, $url); // Set the URL
        curl_setopt($ch, CURLOPT_POST, true); // Enable POST request
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($postData)); // Add JSON data to the request
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); // Return the response as a string
        curl_setopt($ch, CURLOPT_HTTPHEADER, $header);

        // Execute the request
        $response = curl_exec($ch);

        // Check for errors
        if (curl_error($ch)) {
            return ['status' => 'error', 'message' => curl_error($ch)];
        } else {
            // Decode the response if it's JSON
            return ['status' => 'success', 'message' => curl_error($ch), 'data' => json_decode($response, true)];
        }

        // Close cURL
        curl_close($ch);
    }

    public function loginSoftPro($userId)
    {
        $secretKey = getenv('SOFT_PRO_TOKEN');
        $staticToken = time();
        $data = $userId . "|" . $staticToken;
        $token = hash_hmac('sha256', $data, $secretKey);

        $request = [
            "UserId" => $userId,
            "Token" => $token,
            "TokenStatus" => 1,
        ];

        $response = $this->make_request('POST', 'api/Authentication/CreateUserToken', $request);
        print_r($response);die;
    }

}
