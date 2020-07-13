<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class Titlepoint
{
    public $count = 0;
    public static $CI;
    
	public function __construct($params = array())
	{
		$this->CI =& get_instance();                        
		$this->CI->load->database();
        $this->CI->load->library('session');
        $this->CI->load->model('order/titlePointData');
        $this->CI->load->model('order/apiLogs');
		self::$CI = $this->CI;
    }

    public function generateImg($serviceId,$fileNumber,$orderId)
    {
        $userdata = $this->CI->session->userdata('user');
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

            $request = $requestUrl.http_build_query($requestParams);

            $logid = $this->CI->apiLogs->syncLogs($userdata['id'], 'titlepoint', 'create_lv_image_request', $request, $requestParams, array(), $orderId, 0);

            $file = file_get_contents($request,false,$context);
            $xmlData = simplexml_load_string($file);
            $response = json_encode($xmlData);
            $result = json_decode($response,TRUE);

            $this->CI->apiLogs->syncLogs($userdata['id'], 'titlepoint', 'create_lv_image_request', $request, $requestParams, $result, $orderId, $logid);

            $returnStatus = isset($result['ReturnStatus']) && !empty($result['ReturnStatus']) ? $result['ReturnStatus'] : '';
            $returnStatus = strtolower($returnStatus);
            if($returnStatus == 'success')
            {
                $requestId = isset($result['RequestID']) && !empty($result['RequestID']) ? $result['RequestID'] : '';

                if(isset($requestId) && !empty($requestId))
                {
                    $response = $this->getImageRequestStatus($requestId,$orderId);
                    
                    $imgResult = json_decode($response, TRUE);
                    
                    if(isset($imgResult) && !empty($imgResult))
                    {
                        $imgReturnStatus = isset($imgResult['ReturnStatus']) && !empty($imgResult['ReturnStatus']) ? $imgResult['ReturnStatus'] : '';
                        $status = isset($imgResult['Status']) && !empty($imgResult['Status']) ? $imgResult['Status'] : '';
                        $imgReturnStatus = strtolower($imgReturnStatus);
                        $status = strtolower($status);
                        if($imgReturnStatus == 'success' && $status == 'success')
                        {
                            $generateImgResponse = $this->generateImage($requestId,$orderId);

                            $generateImgResult = json_decode($generateImgResponse, TRUE);
                            $generateImgReturnStatus = isset($generateImgResult['ReturnStatus']) && !empty($generateImgResult['ReturnStatus']) ? $generateImgResult['ReturnStatus'] : '';
                            $generateImgStatus = isset($generateImgResult['Status']) && !empty($generateImgResult['Status']) ? $generateImgResult['Status'] : '';

                            $generateImgMsg = isset($generateImgResult['Message']) && !empty($generateImgResult['Message']) ? $generateImgResult['Message'] : '';
                            $generateImgReturnStatus = strtolower($generateImgReturnStatus);
                            $generateImgStatus = strtolower($generateImgStatus);
                            if($generateImgReturnStatus == 'success' && $generateImgStatus == 'success')
                            {
                                $base64_data = isset($generateImgResult['Data']) && !empty($generateImgResult['Data']) ? $generateImgResult['Data'] : '';
                                
                                if(isset($base64_data) && !empty($base64_data))
                                {
                                    $bin = base64_decode($base64_data, true);      
                                
                                    if (!is_dir('uploads/legal-vesting')) {
                                        mkdir('./uploads/legal-vesting', 0777, TRUE);
                                    }
                                    
                                    $pdfFilePath = './uploads/legal-vesting/'.$fileNumber.'.pdf';
                                    file_put_contents($pdfFilePath, $bin); 
                                }

                                $tpData = array(
                                    'lv_file_status' => $generateImgStatus,
                                    'lv_file_message' => $generateImgMsg
                                );
                            }
                            else if($generateImgReturnStatus == 'success' && $generateImgStatus != 'success')
                            {
                                
                                $tpData = array(
                                    'lv_file_status' => $generateImgStatus,
                                    'lv_file_message' => $generateImgMsg
                                );
                                /*$condition =array(
                                    'file_number' => $fileNumber
                                );
                                $this->CI->titlePointData->update($tpData,$condition);*/
                            }
                            else
                            {
                              $error = isset($generateImgResult['ReturnErrors']['ReturnError']['ErrorDescription']) && !empty($generateImgResult['ReturnErrors']['ReturnError']['ErrorDescription']) ? $generateImgResult['ReturnErrors']['ReturnError']['ErrorDescription'] : '';

                                $tpData = array(
                                    'lv_file_status' => $generateImgReturnStatus,
                                    'lv_file_message' => $error
                                );
                                /*$condition =array(
                                    'file_number' => $fileNumber
                                );
                                $this->CI->titlePointData->update($tpData,$condition);*/  
                            }
                            $condition =array(
                                    'file_number' => $fileNumber
                                );
                            $this->CI->titlePointData->update($tpData,$condition); 

                        }
                        else if($imgReturnStatus == 'success' && $status != 'success')
                        {
                            $message = isset($imgResult['Message']) && !empty($imgResult['Message']) ? $imgResult['Message'] : '';
                            $tpData = array(
                                'lv_file_status' => $status,
                                'lv_file_message' => $message
                            );
                            $condition =array(
                                'file_number' => $fileNumber
                            );
                            $this->CI->titlePointData->update($tpData,$condition);
                        }
                        else
                        {
                          $error = isset($imgResult['ReturnErrors']['ReturnError']['ErrorDescription']) && !empty($imgResult['ReturnErrors']['ReturnError']['ErrorDescription']) ? $imgResult['ReturnErrors']['ReturnError']['ErrorDescription'] : '';

                            $tpData = array(
                                'lv_file_status' => $imgReturnStatus,
                                'lv_file_message' => $error
                            );
                            $condition =array(
                                'file_number' => $fileNumber
                            );
                            $this->CI->titlePointData->update($tpData,$condition);  
                        }
                    }
                    
                }
            }
            else
            {
              $error = isset($result['ReturnErrors']['ReturnError']['ErrorDescription']) && !empty($result['ReturnErrors']['ReturnError']['ErrorDescription']) ? $result['ReturnErrors']['ReturnError']['ErrorDescription'] : '';

                $tpData = array(
                    'lv_file_status' => $returnStatus,
                    'lv_file_message' => $error
                );
                $condition =array(
                    'file_number' => $fileNumber
                );
                $this->CI->titlePointData->update($tpData,$condition);  
            }
        }
    }
    
    public function generateGrantDeed($instrumentNumber,$recordedDate,$fips,$fileNumber,$orderId)
    {
        $userdata = $this->CI->session->userdata('user');
        if(isset($instrumentNumber) && !empty($instrumentNumber))
        {
            if(isset($recordedDate) && !empty($recordedDate))
            {
                $time = strtotime($recordedDate);
                $year = date('Y',$time);
            }
            $count = substr_count($instrumentNumber, '-');

            if(isset($count) && !empty($count))
            {
                $detailDocInfo = explode('-', $instrumentNumber);

                $docId = isset($detailDocInfo['1']) && !empty($detailDocInfo['1']) ? $detailDocInfo['1'] : '';   
            }
            else
            {
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

        $logid = $this->CI->apiLogs->syncLogs($userdata['id'], 'titlepoint', 'generate_grant_deed', $request, $requestParams, array(), $orderId, 0);

        $file = file_get_contents($request,false,$context);
        $xmlData = simplexml_load_string($file);
        
        $response = json_encode($xmlData);
        $result = json_decode($response,TRUE);

        $this->CI->apiLogs->syncLogs($userdata['id'], 'titlepoint', 'generate_grant_deed', $request, $requestParams, $result, $orderId, $logid);

        $responseStatus = isset($result['Status']['Msg']) && !empty($result['Status']['Msg']) ? $result['Status']['Msg'] : '';
        
      
        $docStatus = isset($result['Documents']['DocumentResponse']['DocStatus']['Msg']) && !empty($result['Documents']['DocumentResponse']['DocStatus']['Msg']) ? $result['Documents']['DocumentResponse']['DocStatus']['Msg'] : '';
        $docStatus = strtolower($docStatus);
        if(isset($docStatus) && !empty($docStatus) && $docStatus == 'ok')
        {
            $base64_data = isset($result['Documents']['DocumentResponse']['Document']['Body']['Body']) && !empty($result['Documents']['DocumentResponse']['Document']['Body']['Body']) ? $result['Documents']['DocumentResponse']['Document']['Body']['Body'] : '';

            if(isset($base64_data) && !empty($base64_data))
            {
                $bin = base64_decode($base64_data, true);       
            
                if (!is_dir('uploads/grant-deed')) {
                    mkdir('./uploads/grant-deed', 0777, TRUE);
                }
                $pdfFilePath = './uploads/grant-deed/'.$fileNumber.'.pdf';
                file_put_contents($pdfFilePath, $bin);
            }
            $tpData = array(
                'grant_deed_status' => $docStatus,
                'grant_deed_message' => 'Success'
            );
        }
        else
        {
            $tpData = array(
                'grant_deed_status' => 'Failed',
                'grant_deed_message' => $docStatus
            ); 
        }
        
        $condition =array(
            'file_number' => $fileNumber
        );
        $this->CI->titlePointData->update($tpData,$condition);
    }

    public function generateTaxDoc($serviceId,$fileNumber,$orderId)
    {
        $userdata = $this->CI->session->userdata('user');
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

            $request = $requestUrl.http_build_query($requestParams);

            $logid = $this->CI->apiLogs->syncLogs($userdata['id'], 'titlepoint', 'create_tax_image_request', $request, $requestParams, array(), $orderId, 0);

            $file = file_get_contents($request,false,$context);
            $xmlData = simplexml_load_string($file);
            $response = json_encode($xmlData);
            $result = json_decode($response,TRUE);

            $this->CI->apiLogs->syncLogs($userdata['id'], 'titlepoint', 'create_tax_image_request', $request, $requestParams, $result, $orderId, $logid);

            $returnStatus = isset($result['ReturnStatus']) && !empty($result['ReturnStatus']) ? $result['ReturnStatus'] : '';
            $returnStatus = strtolower($returnStatus);
            
            if($returnStatus == 'success')
            {
                $requestId = isset($result['RequestID']) && !empty($result['RequestID']) ? $result['RequestID'] : '';
                
                if(isset($requestId) && !empty($requestId))
                {
                    $imgresponse = $this->getTaxImageRequestStatus($requestId,$orderId);
                    echo "<pre>"; print_r($imgresponse); exit;
                    $imgResult = json_decode($imgresponse, TRUE);
                    
                    $imgReturnStatus = isset($imgResult['ReturnStatus']) && !empty($imgResult['ReturnStatus']) ? $imgResult['ReturnStatus'] : '';
                    $status = isset($imgResult['Status']) && !empty($imgResult['Status']) ? $imgResult['Status'] : '';
                    $imgReturnStatus = strtolower($imgReturnStatus);
                    $status = strtolower($status);
                    if($imgReturnStatus == 'success' && $status == 'success')
                    {
                        $generateImgResponse = $this->generateTaxImage($requestId,$orderId);

                        $generateImgResult = json_decode($generateImgResponse, TRUE);
                        $generateImgReturnStatus = isset($generateImgResult['ReturnStatus']) && !empty($generateImgResult['ReturnStatus']) ? $generateImgResult['ReturnStatus'] : '';
                        $generateImgStatus = isset($generateImgResult['Status']) && !empty($generateImgResult['Status']) ? $generateImgResult['Status'] : '';

                        $generateImgMsg = isset($generateImgResult['Message']) && !empty($generateImgResult['Message']) ? $generateImgResult['Message'] : '';
                        $generateImgReturnStatus = strtolower($generateImgReturnStatus);
                        $generateImgStatus = strtolower($generateImgStatus);
                        if($generateImgReturnStatus == 'success' && $generateImgStatus == 'success')
                        {
                            $base64_data = isset($generateImgResult['Data']) && !empty($generateImgResult['Data']) ? $generateImgResult['Data'] : '';
                            
                            if(isset($base64_data) && !empty($base64_data))
                            {
                                $bin = base64_decode($base64_data, true);      
                            
                                if (!is_dir('uploads/tax')) {
                                    mkdir('./uploads/tax', 0777, TRUE);
                                }
                                
                                $pdfFilePath = './uploads/tax/'.$fileNumber.'.pdf';
                                file_put_contents($pdfFilePath, $bin); 
                            }

                            $tpData = array(
                                'tax_file_status' => $generateImgStatus,
                                'tax_file_message' => $generateImgMsg
                            );
                        }
                        else if($generateImgReturnStatus == 'success' && $generateImgStatus != 'success')
                        {
                            
                            $tpData = array(
                                'tax_file_status' => $generateImgStatus,
                                'tax_file_message' => $generateImgMsg
                            );
                        }
                        else
                        {
                          $error = isset($generateImgResult['ReturnErrors']['ReturnError']['ErrorDescription']) && !empty($generateImgResult['ReturnErrors']['ReturnError']['ErrorDescription']) ? $generateImgResult['ReturnErrors']['ReturnError']['ErrorDescription'] : '';

                            $tpData = array(
                                'tax_file_status' => $generateImgReturnStatus,
                                'tax_file_message' => $error
                            );  
                        }
                        $condition =array(
                                'file_number' => $fileNumber
                            );
                        $this->CI->titlePointData->update($tpData,$condition); 

                    }
                    else if($imgReturnStatus == 'success' && $status != 'success')
                    {
                        $message = isset($imgResult['Message']) && !empty($imgResult['Message']) ? $imgResult['Message'] : '';
                        $tpData = array(
                            'tax_file_status' => $status,
                            'tax_file_message' => $message
                        );
                        $condition =array(
                            'file_number' => $fileNumber
                        );
                        $this->CI->titlePointData->update($tpData,$condition);
                    }
                    else
                    {
                      $error = isset($imgResult['ReturnErrors']['ReturnError']['ErrorDescription']) && !empty($imgResult['ReturnErrors']['ReturnError']['ErrorDescription']) ? $imgResult['ReturnErrors']['ReturnError']['ErrorDescription'] : '';

                        $tpData = array(
                            'tax_file_status' => $imgReturnStatus,
                            'tax_file_message' => $error
                        );
                        $condition =array(
                            'file_number' => $fileNumber
                        );
                        $this->CI->titlePointData->update($tpData,$condition);  
                    }
                }
            }
            else
            {
              $error = isset($result['ReturnErrors']['ReturnError']['ErrorDescription']) && !empty($result['ReturnErrors']['ReturnError']['ErrorDescription']) ? $result['ReturnErrors']['ReturnError']['ErrorDescription'] : '';

                $tpData = array(
                    'tax_file_status' => $returnStatus,
                    'tax_file_message' => $error
                );
                $condition =array(
                    'file_number' => $fileNumber
                );
                $this->CI->titlePointData->update($tpData,$condition);  
            }
        }
    }

    /*public function generateTaxDoc($serviceId,$fileNumber)
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

            $request = $requestUrl.http_build_query($requestParams);

        
            $file = file_get_contents($request,false,$context);
            $xmlData = simplexml_load_string($file);
            $response = json_encode($xmlData);
            $result = json_decode($response,TRUE);
            $status = isset($result['ReturnStatus']) && !empty($result['ReturnStatus']) ? $result['ReturnStatus'] : '';
            if($status == 'Success' || $status == 'Processing')
            {
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
                    $reqStatus = isset($result['Status']) && !empty($result['Status']) ? $result['Status'] : '';
                    $reqMessage = isset($result['Message']) && !empty($result['Message']) ? $result['Message'] : '';
                    if($status == 'Success')
                    {
                        if($reqStatus == 'Success' || $reqStatus == 'Processing')
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
                            if($responseStatus == 'Success' || $reqStatus == 'Processing')
                            {
                                $reqStatus = isset($result['Status']) && !empty($result['Status']) ? $result['Status'] : '';
                                $reqMessage = isset($result['Message']) && !empty($result['Message']) ? $result['Message'] : '';
                                $base64_data = isset($result['Data']) && !empty($result['Data']) ? $result['Data'] : '';
                                $bin = base64_decode($base64_data, true);      
                                
                                if (!is_dir('uploads/tax')) {
                                    mkdir('./uploads/tax', 0777, TRUE);
                                }
                                $pdfFilePath = './uploads/tax/'.$fileNumber.'.pdf';
                                file_put_contents($pdfFilePath, $bin);                    
                            }
                        }
                        $tpData = array(
                            'tax_file_status' => $reqStatus,
                            'tax_file_message' => $reqMessage
                        );
                        $condition =array(
                            'file_number' => $fileNumber
                        );
                        $this->CI->titlePointData->update($tpData,$condition);
                        
                    }
                    else
                    {
                        $error = isset($result['ReturnErrors']['ReturnError']['ErrorDescription']) && !empty($result['ReturnErrors']['ReturnError']['ErrorDescription']) ? $result['ReturnErrors']['ReturnError']['ErrorDescription'] : '';

                        $tpData = array(
                            'tax_file_status' => $status,
                            'tax_file_message' => $error
                        );
                        $condition =array(
                            'file_number' => $fileNumber
                        );
                        $this->CI->titlePointData->update($tpData,$condition);
                    }
                }
            }
            else
            {
                $error = isset($result['ReturnErrors']['ReturnError']['ErrorDescription']) && !empty($result['ReturnErrors']['ReturnError']['ErrorDescription']) ? $result['ReturnErrors']['ReturnError']['ErrorDescription'] : '';

                $tpData = array(
                    'tax_file_status' => $status,
                    'tax_file_message' => $error
                );
                $condition =array(
                    'file_number' => $fileNumber
                );
                $this->CI->titlePointData->update($tpData,$condition);
            }
            
        }
    }*/
    

    public function getImageRequestStatus($requestId,$orderId)
    {
        $userdata = $this->CI->session->userdata('user');
        $requestParams = array(
                            'username' => env('TP_USERNAME'),
                            'password' => env('TP_PASSWORD'),                    
                            'requestId'=>  $requestId
                        );
        $request = env('TP_IMAGE_REQUEST_STATUS').http_build_query($requestParams);
        
        $logid = $this->CI->apiLogs->syncLogs($userdata['id'], 'titlepoint', 'lv_image_request_status', $request, $requestParams, array(), $orderId, 0);

        $file = file_get_contents($request,false,$context);
        $xmlData = simplexml_load_string($file);
        $response = json_encode($xmlData);

        $imgResult = json_decode($response, TRUE);

        $this->CI->apiLogs->syncLogs($userdata['id'], 'titlepoint', 'lv_image_request_status', $request, $requestParams, $imgResult, $orderId, $logid);

        $imgReturnStatus = isset($imgResult['ReturnStatus']) && !empty($imgResult['ReturnStatus']) ? $imgResult['ReturnStatus'] : '';
        $imgReturnStatus = strtolower($imgReturnStatus);
        if($imgReturnStatus == 'success')
        {
            $status = isset($imgResult['Status']) && !empty($imgResult['Status']) ? $imgResult['Status'] : '';
            $status = strtolower($status);
            if($status == 'success')
            {
                return $response;
            }
            else if($status == 'processing') 
            {           
                /*if($this->count < 3)
                {*/
                    // $this->count = $this->count + 1;
                    $this->getImageRequestStatus($requestId,$orderId);                    
                /*}
                else
                {
                    $this->count = 0;
                    return $response;
                } */  
                
            }
            else
            {
                return $response;
            }
        }
        else
        {
          return $response; 
        }
    }

    public function generateImage($requestId,$orderId)
    {
        $userdata = $this->CI->session->userdata('user');
        $requestParams = array(
                            'username' => env('TP_USERNAME'),
                            'password' => env('TP_PASSWORD'),                    
                            'requestId'=>  $requestId
                        );

        $request = env('TP_GENERATE_IMAGE').http_build_query($requestParams);

        $logid = $this->CI->apiLogs->syncLogs($userdata['id'], 'titlepoint', 'generate_lv_image', $request, $requestParams, array(), $orderId, 0);
        $file = file_get_contents($request,false,$context);

        $xmlData = simplexml_load_string($file);
        $response = json_encode($xmlData);
        $result = json_decode($response, TRUE);

        $this->CI->apiLogs->syncLogs($userdata['id'], 'titlepoint', 'generate_lv_image', $request, $requestParams, $result, $orderId, $logid);

        return $response;
    }

    public function getTaxImageRequestStatus($requestId,$orderId)
    {
        $userdata = $this->CI->session->userdata('user');
        $requestParams = array(
                            'username' => env('TP_USERNAME'),
                            'password' => env('TP_PASSWORD'),                    
                            'requestId'=>  $requestId
                        );
        $request = env('TP_IMAGE_REQUEST_STATUS').http_build_query($requestParams);

        $logid = $this->CI->apiLogs->syncLogs($userdata['id'], 'titlepoint', 'tax_image_request_status', $request, $requestParams, array(), $orderId, 0);

        $file = file_get_contents($request,false,$context);
        $xmlData = simplexml_load_string($file);
        $response = json_encode($xmlData);

        $imgResult = json_decode($response, TRUE);

        $this->CI->apiLogs->syncLogs($userdata['id'], 'titlepoint', 'tax_image_request_status', $request, $requestParams, $imgResult, $orderId, $logid);

        $imgReturnStatus = isset($imgResult['ReturnStatus']) && !empty($imgResult['ReturnStatus']) ? $imgResult['ReturnStatus'] : '';
        $imgReturnStatus = strtolower($imgReturnStatus);
        if($imgReturnStatus == 'success')
        {
            $status = isset($imgResult['Status']) && !empty($imgResult['Status']) ? $imgResult['Status'] : '';
            $status = strtolower($status);
            if($status == 'success')
            {
                echo "<pre>success: "; print_r($response);
                return $response;
            }
            else if($status == 'processing') 
            {     
            echo "<pre>processing: "; print_r($response);       
                /*if($this->count < 3)
                {*/
                    // $this->count = $this->count + 1;
                    return $this->getTaxImageRequestStatus($requestId,$orderId);                    
                /*}
                else
                {
                    $this->count = 0;
                    return $response;
                } */  
                
            }
            else
            {
                return $response;
            }
        }
        else
        {
          return $response; 
        }
    }

    public function generateTaxImage($requestId,$orderId)
    {
        $userdata = $this->CI->session->userdata('user');
        $requestParams = array(
                            'username' => env('TP_USERNAME'),
                            'password' => env('TP_PASSWORD'),                    
                            'requestId'=>  $requestId
                        );

        $request = env('TP_GENERATE_IMAGE').http_build_query($requestParams);
        $file = file_get_contents($request,false,$context);

        $logid = $this->CI->apiLogs->syncLogs($userdata['id'], 'titlepoint', 'generate_tax_image', $request, $requestParams, array(), $orderId, 0);

        $xmlData = simplexml_load_string($file);
        $response = json_encode($xmlData);
        $result = json_decode($response, TRUE);

        $this->CI->apiLogs->syncLogs($userdata['id'], 'titlepoint', 'generate_tax_image', $request, $requestParams, $result, $orderId, $logid);

        return $response;
    }
}
