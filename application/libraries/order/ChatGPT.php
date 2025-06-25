<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class ChatGPT
{
    public static $CI;
    
    public function __construct($params = array())
    {
        $this->CI =& get_instance();
        self::$CI = $this->CI;
    }

    public function make_request($prompt, $data = array())
    {
        $postData = [
            'model' => 'gpt-4o-mini',
            'messages' => [
                ['role' => 'user', 'content' => $prompt]
            ],
            "temperature" => 0.7
        ];
        $apiKey = env('CHAT_GPT_API_KEY');
        $chatGPTUrl = env('CHAT_GPT_URL');
        $ch = curl_init($chatGPTUrl);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Content-Type: application/json',
            'Authorization: Bearer ' . $apiKey
        ]);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($postData));

        $response = curl_exec($ch);
        curl_close($ch);

        return $response;
    
    }
    
}
