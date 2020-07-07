<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class Titlepoint
{
    public static $CI;
    
	public function __construct($params = array())
	{
		$this->CI =& get_instance();                        
		$this->CI->load->database();
        $this->CI->load->library('session');
		self::$CI = $this->CI;
    }

    public function generateImg($serviceId,$fileNumber)
    {
        $serviceId = isset($serviceId) && !empty($serviceId) ? $serviceId : '';
        $opts = array(
            "ssl"=>array(
                "verify_peer"=>false,
                "verify_peer_name"=>false,
            ),
        );
        $context = stream_context_create($opts);
        if($serviceId)
        {   
            $requestParams = array(
                'username' => env('TP_USERNAME'),
                'password' => env('TP_PASSWORD'),
                'serviceId1' =>  $serviceId,
                'serviceId2'=>  '',
                'source'=>  '',
                'clientKey1'=>  '',
                'clientKey2'=>  '',
                'sortOrder'=>  '',
                'fileType'=>  'pdf',
            );
            $requestUrl= env('TP_IMAGE_ENDPOINT');
        }

        $request = $requestUrl.http_build_query($requestParams);

        
        $file = file_get_contents($request,false,$context);
        $xmlData = simplexml_load_string($file);
        $response = json_encode($xmlData);
        $result = json_decode($response,TRUE);
        $requestId = isset($result['RequestID']) && !empty($result['RequestID']) ? $result['RequestID'] : '';

        if(isset($requestId) && !empty($requestId))
        {
            $requestParams = array(
                            'username' => env('TP_USERNAME'),
                            'password' => env('TP_PASSWORD'),                    
                            'requestId'=>  $requestId
                        );
            $request = env('TP_IMAGE_REQUEST_STATUS').http_build_query($requestParams);
            
            $file = file_get_contents($request,false,$context);
            $xmlData = simplexml_load_string($file);
            $response = json_encode($xmlData);
            $result = json_decode($response,TRUE);
            
            $status = isset($result['ReturnStatus']) && !empty($result['ReturnStatus']) ? $result['ReturnStatus'] : '';
            if($status == 'Success')
            {
                $requestParams = array(
                                'username' => env('TP_USERNAME'),
                                'password' => env('TP_PASSWORD'),                    
                                'requestId'=>  $requestId
                            );

                $request = env('TP_GENERATE_IMAGE').http_build_query($requestParams);
                $file = file_get_contents($request,false,$context);

                $xmlData = simplexml_load_string($file);
                $response = json_encode($xmlData);
                $result = json_decode($response,TRUE);
                $responseStatus = isset($result['ReturnStatus']) && !empty($result['ReturnStatus']) ? $result['ReturnStatus'] : '';
                if($responseStatus == 'Success')
                {
                    $base64_data = isset($result['Data']) && !empty($result['Data']) ? $result['Data'] : '';
                    $bin = base64_decode($base64_data, true);      
                    
                    if (!is_dir('uploads/legal-vesting')) {
                        mkdir('./uploads/legal-vesting', 0777, TRUE);
                    }
                    $pdfFilePath = './uploads/legal-vesting/'.$fileNumber.'.pdf';
                    file_put_contents($pdfFilePath, $bin);                    
                }
            }
        }
        
        return $pdfFilePath;
    }
    
    public function generateGrantDeed($instrumentNumber,$recordedDate,$fips,$fileNumber)
    {
        if(isset($instrumentNumber) && !empty($instrumentNumber))
        {
            $count = substr_count($instrumentNumber, '-');

            if(isset($count) && !empty($count))
            {
                $detailDocInfo = explode('-', $instrumentNumber);
                
                $year = isset($detailDocInfo['0']) && !empty($detailDocInfo['0']) ? $detailDocInfo['0'] : '';
                $docId = isset($detailDocInfo['1']) && !empty($detailDocInfo['1']) ? $detailDocInfo['1'] : '';   
            }
            else
            {
                if(isset($recordedDate) && !empty($recordedDate))
                {
                    $time = strtotime($recordedDate);
                    $year = date('Y',$time);
                }
                $docId = str_replace($year, '', $instrumentNumber);
            }
            $docId = (string)((int)($docId));
        }

        $requestParams = array(
            'parameters'=>'FIPS='.$fips.',TYPE=REC,SUBTYPE=ALL,YEAR='.$year.',INST='.$docId.'',
            'username' => env('TP_USERNAME'),
            'password' => env('TP_PASSWORD'),            
            'company'=>  '',
            'department'=>  '',
            'titleOfficer'=>  '',
            'pages'=>  '',
            'propertyOnly'=>  'FALSE',
            'maxPageCount'=>  0,
            'maxSizeInKB'=>  0,             
            'additionalInfo'=>  '',            
            'customerRef'=>  '',
            'fileType'=>  'PDF',
        );

        $request = env('GRANT_DEED_ENDPOINT').http_build_query($requestParams);

        $opts = array(
            "ssl"=>array(
                "verify_peer"=>false,
                "verify_peer_name"=>false,
            ),
        );
        $context = stream_context_create($opts);
        $file = file_get_contents($request,false,$context);
        $xmlData = simplexml_load_string($file);
        $response = json_encode($xmlData);
        $result = json_decode($response,TRUE);
        
        $responseStatus = isset($result['Documents']['DocumentResponse']['DocStatus']['Msg']) && !empty($result['Documents']['DocumentResponse']['DocStatus']['Msg']) ? $result['Documents']['DocumentResponse']['DocStatus']['Msg'] : '';
        if($responseStatus == 'OK')
        {
            $base64_data = isset($result['Documents']['DocumentResponse']['Document']['Body']['Body']) && !empty($result['Documents']['DocumentResponse']['Document']['Body']['Body']) ? $result['Documents']['DocumentResponse']['Document']['Body']['Body'] : '';

            $bin = base64_decode($base64_data, true);       
            
            if (!is_dir('uploads/grant-deed')) {
                mkdir('./uploads/grant-deed', 0777, TRUE);
            }
            $pdfFilePath = './uploads/grant-deed/'.$fileNumber.'.pdf';
            file_put_contents($pdfFilePath, $bin);
        }
        return $pdfFilePath;
    }

    public function generateTaxDoc($serviceId,$fileNumber)
    {
        $serviceId = isset($serviceId) && !empty($serviceId) ? $serviceId : '';
        $opts = array(
            "ssl"=>array(
                "verify_peer"=>false,
                "verify_peer_name"=>false,
            ),
        );
        $context = stream_context_create($opts);
        if($serviceId)
        {   
            $requestParams = array(
                'username' => env('TP_USERNAME'),
                'password' => env('TP_PASSWORD'),
                'serviceId1' =>  $serviceId,
                'serviceId2'=>  '',
                'source'=>  '',
                'clientKey1'=>  '',
                'clientKey2'=>  '',
                'sortOrder'=>  '',
                'fileType'=>  'pdf',
            );
            $requestUrl= env('TP_IMAGE_ENDPOINT');
        }

        $request = $requestUrl.http_build_query($requestParams);

        
        $file = file_get_contents($request,false,$context);
        $xmlData = simplexml_load_string($file);
        $response = json_encode($xmlData);
        $result = json_decode($response,TRUE);
        $requestId = isset($result['RequestID']) && !empty($result['RequestID']) ? $result['RequestID'] : '';

        if(isset($requestId) && !empty($requestId))
        {
            $requestParams = array(
                            'username' => env('TP_USERNAME'),
                            'password' => env('TP_PASSWORD'),                    
                            'requestId'=>  $requestId
                        );
            $request = env('TP_IMAGE_REQUEST_STATUS').http_build_query($requestParams);
            
            $file = file_get_contents($request,false,$context);
            $xmlData = simplexml_load_string($file);
            $response = json_encode($xmlData);
            $result = json_decode($response,TRUE);
            
            $status = isset($result['ReturnStatus']) && !empty($result['ReturnStatus']) ? $result['ReturnStatus'] : '';
            if($status == 'Success')
            {
                $requestParams = array(
                                'username' => env('TP_USERNAME'),
                                'password' => env('TP_PASSWORD'),                    
                                'requestId'=>  $requestId
                            );

                $request = env('TP_GENERATE_IMAGE').http_build_query($requestParams);
                $file = file_get_contents($request,false,$context);

                $xmlData = simplexml_load_string($file);
                $response = json_encode($xmlData);
                $result = json_decode($response,TRUE);
                $responseStatus = isset($result['ReturnStatus']) && !empty($result['ReturnStatus']) ? $result['ReturnStatus'] : '';
                if($responseStatus == 'Success')
                {
                    $base64_data = isset($result['Data']) && !empty($result['Data']) ? $result['Data'] : '';
                    $bin = base64_decode($base64_data, true);      
                    
                    if (!is_dir('uploads/tax')) {
                        mkdir('./uploads/tax', 0777, TRUE);
                    }
                    $pdfFilePath = './uploads/tax/'.$fileNumber.'.pdf';
                    file_put_contents($pdfFilePath, $bin);                    
                }
            }
        }
        
        return $pdfFilePath;
    }
}
