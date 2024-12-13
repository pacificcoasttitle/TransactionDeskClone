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

    public function make_request($http_method, $endpoint, $postData = '', $userData = array())
    {
        $apiEndPoints = SOFTPRO_API_END;
        $url = getenv("SOFT_PRO_API") . $apiEndPoints[$endpoint];
        // print_r($url);die;
        $header = [
            'Content-Type: application/json', // Set JSON content type
            'Content-Length: ' . strlen($postData),
        ];
        if (false) {
            $header = [
                'Content-Type: application/json', // Set JSON content type
                'X-API-KEY: YOUR_TOKEN_HERE', // Add Authorization header if needed
                'Content-Length: ' . strlen($postData),
            ];
        }
        // Initialize cURL
        $ch = curl_init();
        // Set cURL options
        curl_setopt($ch, CURLOPT_URL, $url); // Set the URL
        curl_setopt($ch, CURLOPT_POST, true); // Enable POST request
        curl_setopt($ch, CURLOPT_POSTFIELDS, $postData); // Add JSON data to the request
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); // Return the response as a string
        curl_setopt($ch, CURLOPT_HTTPHEADER, $header);

        // Execute the request
        $response = curl_exec($ch);
        // print_r($response);die;
        // Check for errors
        if (curl_error($ch)) {
            return ['status' => 'error', 'message' => curl_error($ch)];
        } else {
            $res = json_decode($response, true);
            if ($res['Status'] == 200) {
                return ['status' => 'success', 'message' => $res['Message'], 'data' => $res];
            } else {
                return ['status' => 'error', 'message' => $res['Message'], 'data' => $res];
            }
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
