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

    public function make_request($http_method, $endpoint, $postData = '', $queryParams = '')
    {
        $apiEndPoints = SOFTPRO_API_END;
        $url = getenv("SOFT_PRO_API") . $apiEndPoints[$endpoint];
        if ($http_method == 'GET') {
            $url .= '?' . $queryParams;
        }
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
        // $ch = curl_init();
        // // Set cURL options
        // curl_setopt($ch, CURLOPT_URL, $url); // Set the URL
        // curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $http_method);

        // curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
        // // curl_setopt($ch, CURLOPT_POST, true); // Enable POST request
        // // curl_setopt($ch, CURLOPT_POSTFIELDS, $postData); // Add JSON data to the request
        // curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); // Return the response as a string
        // curl_setopt($ch, CURLOPT_HTTPHEADER, $header);

        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $http_method);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        if ($http_method == 'GET') {
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // Debug SSL
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
            curl_setopt($ch, CURLOPT_VERBOSE, true); // Enable verbose output for debugging
        } else {
            curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);
        }
        curl_setopt($ch, CURLOPT_TIMEOUT, 180); // Increase timeout

//         $ch = curl_init();

// // Prepare the URL with query parameters
//         $userType = "Order Contact - Person";
//         $url = "http://100.29.181.61:8081/api/lookup/GetLookuptable?userType=" . urlencode($userType);

// // Set cURL options
//         curl_setopt($ch, CURLOPT_URL, $url); // Set the URL to send the GET request
//         curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); // Return the response as a string
//         curl_setopt($ch, CURLOPT_HTTPHEADER, [
//             "Content-Type: application/json", // Set content type to JSON (although it's not strictly necessary for GET)
//         ]);

        // curl_setopt($ch, CURLOPT_TIMEOUT, 120); // Set the timeout to 60 seconds (you can adjust this as needed)

        // $response = curl_exec($ch);
        // // Check for errors
        // if (curl_errno($ch)) {
        //     echo "cURL Error: " . curl_error($ch);die;
        // } else {
        //     print_r($response);die;
        //     // Print the response
        //     echo $response;
        // }

        $response = curl_exec($ch);
        // print_r($response);die;
        // Execute the request
        // $response = curl_exec($ch);
        // Check for errors
        if (curl_error($ch)) {
            return ['status' => 'error', 'message' => curl_error($ch)];
        } else {
            // echo 'hhelo';
            $res = json_decode($response, true);
            if ($res['Status'] == 200) {
                $return = ['status' => 'success', 'message' => $res['Message'], 'data' => $res['data']];
                if (isset($res['OrderNumber']) && !empty($res['OrderNumber'])) {
                    $return['OrderNumber'] = $res['OrderNumber'];
                }
                return $return;
            } else {
                return ['status' => 'error', 'message' => $res['Message'], 'data' => $res];
            }
        }

        // Close cURL
        curl_close($ch);
    }

    /*public function make_request($http_method, $endpoint, $postData = '', $queryParams = '')
    {
    $apiEndPoints = SOFTPRO_API_END;
    $url = getenv("SOFT_PRO_API") . $apiEndPoints[$endpoint];
    if ($http_method == 'GET') {
    $url .= '?' . $queryParams;
    }

    $header = [
    'Content-Type: application/json', // Set JSON content type
    'Content-Length: ' . strlen($postData),
    ];

    // Initialize cURL
    $ch = curl_init();
    // Set cURL options
    curl_setopt($ch, CURLOPT_URL, $url); // Set the URL
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $http_method);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); // Return the response as a string
    curl_setopt($ch, CURLOPT_HTTPHEADER, $header);

    if ($http_method == 'POST' || $http_method == 'PUT') {
    curl_setopt($ch, CURLOPT_POSTFIELDS, $postData); // Set the POST fields
    }

    // Execute cURL request
    $response = curl_exec($ch);

    // Check for cURL errors
    if (curl_errno($ch)) {
    $error_msg = curl_error($ch);
    curl_close($ch);
    return 'cURL error: ' . $error_msg;
    }

    // Close cURL session
    curl_close($ch);

    return $response;
    }

    // ...existing code...
    }*/

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
