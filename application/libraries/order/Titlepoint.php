<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class Titlepoint
{
    public $count = 0;
    public $taxcount = 0;
    public $geocount = 0;
    public static $CI;
    
	public function __construct($params = array())
	{
		$this->CI =& get_instance();                        
		$this->CI->load->database();
        $this->CI->load->library('session');
        $this->CI->load->model('order/titlePointData');
        $this->CI->load->model('order/titlePointDocumentRecords');
        $this->CI->load->model('order/apiLogs');
        $this->CI->load->library('order/order');
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
                $requestOrderId = isset($result['OrderID']) && !empty($result['OrderID']) ? $result['OrderID'] : '';

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
                                    $this->CI->order->uploadDocumentOnAwsS3($fileNumber.'.pdf', 'legal-vesting');
                                }

                                $tpData = array(
                                    'lv_file_status' => $generateImgStatus,
                                    'lv_file_message' => $generateImgMsg,
                                    'lv_order_id' => $requestOrderId
                                );
                            }
                            else if($generateImgReturnStatus == 'success' && $generateImgStatus != 'success')
                            {
                                
                                $tpData = array(
                                    'lv_file_status' => $generateImgStatus,
                                    'lv_file_message' => $generateImgMsg,
                                    'lv_order_id' => $requestOrderId
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
                                    'lv_file_message' => $error,
                                    'lv_order_id' => $requestOrderId
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
                                'lv_file_message' => $message,
                                'lv_order_id' => $requestOrderId
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
                                'lv_file_message' => $error,
                                'lv_order_id' => $requestOrderId
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
                $this->CI->order->uploadDocumentOnAwsS3($fileNumber.'.pdf', 'grant-deed');
                $tpData = array(
                    'grant_deed_status' => $docStatus,
                    'grant_deed_message' => 'success'
                );
            }
            else
            {
                $tpData = array(
                    'grant_deed_status' => 'failed',
                    'grant_deed_message' => 'failed'
                );
            }
            
        }
        else
        {
            $tpData = array(
                'grant_deed_status' => 'failed',
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
                $requestOrderId = isset($result['OrderID']) && !empty($result['OrderID']) ? $result['OrderID'] : '';
                if(isset($requestId) && !empty($requestId))
                {
                    $imgresponse = $this->getTaxImageRequestStatus($requestId,$orderId);
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
                                $this->CI->order->uploadDocumentOnAwsS3($fileNumber.'.pdf', 'tax');
                            }

                            $tpData = array(
                                'tax_file_status' => $generateImgStatus,
                                'tax_file_message' => $generateImgMsg,
                                'tax_order_id' => $requestOrderId
                            );
                        }
                        else if($generateImgReturnStatus == 'success' && $generateImgStatus != 'success')
                        {
                            
                            $tpData = array(
                                'tax_file_status' => $generateImgStatus,
                                'tax_file_message' => $generateImgMsg,
                                'tax_order_id' => $requestOrderId
                            );
                        }
                        else
                        {
                          $error = isset($generateImgResult['ReturnErrors']['ReturnError']['ErrorDescription']) && !empty($generateImgResult['ReturnErrors']['ReturnError']['ErrorDescription']) ? $generateImgResult['ReturnErrors']['ReturnError']['ErrorDescription'] : '';

                            $tpData = array(
                                'tax_file_status' => $generateImgReturnStatus,
                                'tax_file_message' => $error,
                                'tax_order_id' => $requestOrderId
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
                            'tax_file_message' => $message,
                            'tax_order_id' => $requestOrderId
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
                            'tax_file_message' => $error,
                            'tax_order_id' => $requestOrderId
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

    public function generateGeoDoc($postData)
    {
        $fileNumber = $postData['file_number'];
        $orderId = $postData['order_id'];
        $state = $postData['state'];
        $county = $postData['county'];
        $property = $postData['property'];
        // $primaryOwner = $postData['primary_owner'];
        // $secondaryOwner = $postData['secondary_owner'];

        $userdata = $this->CI->session->userdata('user');
        // $serviceId = isset($serviceId) && !empty($serviceId) ? $serviceId : '';
        $opts = array(
            "ssl"=>array(
                "verify_peer"=>false,
                "verify_peer_name"=>false,
            ),
        );
        $context = stream_context_create($opts);
        
        $requestParams = array(
            'userID' => env('TP_USERNAME'),
            'password' => env('TP_PASSWORD'),
            'serviceType' => TP_GEO_SERVICE_TYPE,
            // 'parameters' =>  'Address.FullAddress=1358 5th St;General.AutoSearchTaxes=False;General.AutoSearchProperty=True',
            'parameters' =>  'Address.FullAddress='. $property .';General.AutoSearchTaxes=False;General.AutoSearchProperty=True',
            'department'=> '',
            'orderNo'=>  '',
            'customerRef'=>  '',
            'company'=>  '',
            'titleOfficer'=>  '',
            'orderComment'=>  '',
            'starterRemarks'=>  '',
            // 'state'=>  'CA',
            'state'=>  $state,
            // 'county'=>  'Los Angeles',
            'county'=>  $county,
        );

        $requestUrl= env('TP_SERVICE_ENDPOINT') . TP_GEO_CREATE_SERVICE_URL;

        $request = $requestUrl.http_build_query($requestParams);

        $logid = $this->CI->apiLogs->syncLogs($userdata['id'], 'titlepoint', 'create_geo_request', $request, $requestParams, array(), $orderId, 0);

        $file = file_get_contents($request,false,$context);
        $xmlData = simplexml_load_string($file);
        $response = json_encode($xmlData);
        $result = json_decode($response,TRUE);
        
        $this->CI->apiLogs->syncLogs($userdata['id'], 'titlepoint', 'create_geo_request', $request, $requestParams, $result, $orderId, $logid);

        $returnStatus = isset($result['ReturnStatus']) && !empty($result['ReturnStatus']) ? $result['ReturnStatus'] : '';
        $returnStatus = strtolower($returnStatus);
        
        
        
        if($returnStatus == 'success')
        {
            $requestId = isset($result['RequestID']) && !empty($result['RequestID']) ? $result['RequestID'] : '';
            $requestOrderId = isset($result['OrderID']) && !empty($result['OrderID']) ? $result['OrderID'] : '';
            
            if(isset($requestId) && !empty($requestId))
            {
                $imgresponse = $this->getGeoImageRequestStatus($requestId,$orderId);
                $imgResult = json_decode($imgresponse, TRUE);
                $imgReturnStatus = isset($imgResult['ReturnStatus']) && !empty($imgResult['ReturnStatus']) ? $imgResult['ReturnStatus'] : '';
                $status = isset($imgResult['RequestSummaries']['RequestSummary']) && !empty($imgResult['RequestSummaries']['RequestSummary']) ? $imgResult['RequestSummaries']['RequestSummary']['Status'] : '';
                $imgReturnStatus = strtolower($imgReturnStatus);
                $status = strtolower($status);
                // print_r($status);
                // print_r($imgReturnStatus == 'success');
                if($imgReturnStatus == 'success' && $status == 'complete')
                {
                    $requestSummary = $imgResult['RequestSummaries']['RequestSummary']['Order']['Services']['Service'];
                    $thumbnail = $requestSummary['ThumbNails']['ResultThumbNail'];
                    $serviceId = $requestSummary['ID'];
                    $resultId = $thumbnail['ID'];
                    // echo "Hello if";
                    $generateImgResponse = $this->generateGeoDocument($resultId,$orderId, $fileNumber);

                    $generateImgResult = json_decode($generateImgResponse, TRUE);
                    // echo "<pre>Hello";
                    // print_r($generateImgResult['ReturnStatus']);die;
                    $generateImgReturnStatus = isset($generateImgResult['ReturnStatus']) && !empty($generateImgResult['ReturnStatus']) ? $generateImgResult['ReturnStatus'] : '';
                    // $generateImgStatus = isset($generateImgResult['Status']) && !empty($generateImgResult['Status']) ? $generateImgResult['Status'] : '';

                    $generateImgMsg = isset($generateImgResult['Message']) && !empty($generateImgResult['Message']) ? $generateImgResult['Message'] : '';
                    $generateImgReturnStatus = strtolower($generateImgReturnStatus);
                    // $generateImgStatus = strtolower($generateImgStatus);
                    if($generateImgReturnStatus == 'success')
                    {
                        /** Generate image and uploadin AWS */
                        return $this->generateGeoImg($serviceId,$fileNumber,$orderId, $requestOrderId);
                    } else {
                        $error = isset($imgResult['Message']) && !empty($imgResult['Message']) ? $imgResult['Message'] : '';
                        $tpData = array(
                            'geo_file_status' => $generateImgReturnStatus,
                            'geo_file_message' => $error,
                            'geo_order_id' => $resultId
                        );
                        $condition =array(
                            'file_number' => $fileNumber
                        );
                        $this->CI->titlePointData->update($tpData,$condition);
                    }
                }
                else if($imgReturnStatus == 'success' && $status != 'success')
                {
                    $message = isset($imgResult['Message']) && !empty($imgResult['Message']) ? $imgResult['Message'] : '';
                    $tpData = array(
                        'geo_file_status' => $status,
                        'geo_file_message' => $message,
                        'geo_order_id' => $requestOrderId
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
                        'geo_file_status' => $imgReturnStatus,
                        'geo_file_message' => $error,
                        'geo_order_id' => $requestOrderId
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
                'geo_file_status' => $returnStatus,
                'geo_file_message' => $error
            );
            $condition =array(
                'file_number' => $fileNumber
            );
            $this->CI->titlePointData->update($tpData,$condition);  
        }
        
    }

    public function generateGeoImg($serviceId, $fileNumber, $orderId, $requestOrderId)
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

            $logid = $this->CI->apiLogs->syncLogs($userdata['id'], 'titlepoint', 'create_geo_image_request', $request, $requestParams, array(), $orderId, 0);

            $file = file_get_contents($request,false,$context);
            $xmlData = simplexml_load_string($file);
            $response = json_encode($xmlData);
            $result = json_decode($response,TRUE);
            
            $this->CI->apiLogs->syncLogs($userdata['id'], 'titlepoint', 'create_geo_image_request', $request, $requestParams, $result, $orderId, $logid);
            
            $returnStatus = isset($result['ReturnStatus']) && !empty($result['ReturnStatus']) ? $result['ReturnStatus'] : '';
            $returnStatus = strtolower($returnStatus);
            if($returnStatus == 'success')
            {
                $requestId = isset($result['RequestID']) && !empty($result['RequestID']) ? $result['RequestID'] : '';
                // $requestOrderId = isset($result['OrderID']) && !empty($result['OrderID']) ? $result['OrderID'] : '';
                if(isset($requestId) && !empty($requestId))
                {
                    $response = $this->getImageRequestStatus($requestId,$orderId, 'Geo');
                    
                    $imgResult = json_decode($response, TRUE);
                    
                    if(isset($imgResult) && !empty($imgResult))
                    {
                        $imgReturnStatus = isset($imgResult['ReturnStatus']) && !empty($imgResult['ReturnStatus']) ? $imgResult['ReturnStatus'] : '';
                        $status = isset($imgResult['Status']) && !empty($imgResult['Status']) ? $imgResult['Status'] : '';
                        $imgReturnStatus = strtolower($imgReturnStatus);
                        $status = strtolower($status);
                        if($imgReturnStatus == 'success' && $status == 'success')
                        {
                            $generateImgResponse = $this->generateImage($requestId,$orderId, 'Geo');

                            $generateImgResult = json_decode($generateImgResponse, TRUE);
                            // echo "<pre>";
                            // print_r($generateImgResult);die;
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
                                
                                    if (!is_dir('uploads/pre-listing-doc')) {
                                        mkdir('./uploads/pre-listing-doc', 0777, TRUE);
                                    }
                                    $pdfFilePath = './uploads/pre-listing-doc/'.$fileNumber.'.pdf';
                                    file_put_contents($pdfFilePath, $bin); 
                                    $this->CI->order->uploadDocumentOnAwsS3($fileNumber.'.pdf', 'pre-listing-doc');
                                }

                                $tpData = array(
                                    'geo_file_status' => $generateImgStatus,
                                    'geo_file_message' => $generateImgMsg,
                                    'geo_order_id' => $requestId
                                );
                                // $condition =array(
                                //     'file_number' => $fileNumber
                                // );
                                // $updated = $this->CI->titlePointData->update($tpData,$condition);  
                                // echo "Hello checlk" . $updated; print_r($condition); die;
                            }
                            else if($generateImgReturnStatus == 'success' && $generateImgStatus != 'success')
                            {
                                
                                $tpData = array(
                                    'geo_file_status' => $generateImgStatus,
                                    'geo_file_message' => $generateImgMsg,
                                    'geo_order_id' => $requestId
                                );
                                // $condition =array(
                                //     'file_number' => $fileNumber
                                // );
                                // $this->CI->titlePointData->update($tpData,$condition);
                            }
                            else
                            {
                              $error = isset($generateImgResult['ReturnErrors']['ReturnError']['ErrorDescription']) && !empty($generateImgResult['ReturnErrors']['ReturnError']['ErrorDescription']) ? $generateImgResult['ReturnErrors']['ReturnError']['ErrorDescription'] : '';

                                $tpData = array(
                                    'geo_file_status' => $generateImgReturnStatus,
                                    'geo_file_message' => $error,
                                    'geo_order_id' => $requestId
                                );
                                // $condition =array(
                                //     'file_number' => $fileNumber
                                // );
                                // $this->CI->titlePointData->update($tpData,$condition);
                            }
                            $condition =array(
                                    'file_number' => $fileNumber
                                );
                            return $this->CI->titlePointData->update($tpData,$condition); 

                        }
                        else if($imgReturnStatus == 'success' && $status != 'success')
                        {
                            $message = isset($imgResult['Message']) && !empty($imgResult['Message']) ? $imgResult['Message'] : '';
                            $tpData = array(
                                'geo_file_status' => $status,
                                'geo_file_message' => $message,
                                'geo_order_id' => $requestId
                            );
                            $condition =array(
                                'file_number' => $fileNumber
                            );
                            return $this->CI->titlePointData->update($tpData,$condition);
                        }
                        else
                        {
                          $error = isset($imgResult['ReturnErrors']['ReturnError']['ErrorDescription']) && !empty($imgResult['ReturnErrors']['ReturnError']['ErrorDescription']) ? $imgResult['ReturnErrors']['ReturnError']['ErrorDescription'] : '';

                            $tpData = array(
                                'geo_file_status' => $imgReturnStatus,
                                'geo_file_message' => $error,
                                'geo_order_id' => $requestId
                            );
                            $condition =array(
                                'file_number' => $fileNumber
                            );
                            return $this->CI->titlePointData->update($tpData,$condition);  
                        }
                    }
                    
                }
            }
            else
            {
              $error = isset($result['ReturnErrors']['ReturnError']['ErrorDescription']) && !empty($result['ReturnErrors']['ReturnError']['ErrorDescription']) ? $result['ReturnErrors']['ReturnError']['ErrorDescription'] : '';

                $tpData = array(
                    'geo_file_status' => $returnStatus,
                    'geo_file_message' => $error,
                    'geo_order_id' => $serviceId
                );
                $condition =array(
                    'file_number' => $fileNumber
                );
                return $this->CI->titlePointData->update($tpData,$condition);  
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
    

    public function getImageRequestStatus($requestId,$orderId,$requestFrom='')
    {
        $userdata = $this->CI->session->userdata('user');
        $requestParams = array(
                            'username' => env('TP_USERNAME'),
                            'password' => env('TP_PASSWORD'),                    
                            'requestId'=>  $requestId
                        );
        $request = env('TP_IMAGE_REQUEST_STATUS').http_build_query($requestParams);
        $requestName = ($requestFrom == 'Geo') ? 'geo_image_request_status' : 'lv_image_request_status';
        
        $logid = $this->CI->apiLogs->syncLogs($userdata['id'], 'titlepoint', $requestName, $request, $requestParams, array(), $orderId, 0);

        $file = file_get_contents($request,false,$context);
        $xmlData = simplexml_load_string($file);
        $response = json_encode($xmlData);

        $imgResult = json_decode($response, TRUE);
        $this->CI->apiLogs->syncLogs($userdata['id'], 'titlepoint', $requestName, $request, $requestParams, $imgResult, $orderId, $logid);

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
                if($this->count < 3)
                {
                    sleep(1);
                    $this->count = $this->count + 1;
                    return $this->getImageRequestStatus($requestId,$orderId,$requestFrom);                    
                }
                else
                {
                    $this->count = 0;
                    return $response;
                }   
                
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

    public function generateImage($requestId,$orderId, $requestFrom='')
    {
        $userdata = $this->CI->session->userdata('user');
        $requestParams = array(
                            'username' => env('TP_USERNAME'),
                            'password' => env('TP_PASSWORD'),                    
                            'requestId'=>  $requestId
                        );

        $request = env('TP_GENERATE_IMAGE').http_build_query($requestParams);
        $requestName = ($requestFrom == 'Geo') ? 'generate_geo_image' : 'generate_lv_image';
        $logid = $this->CI->apiLogs->syncLogs($userdata['id'], 'titlepoint', $requestName, $request, $requestParams, array(), $orderId, 0);
        $file = file_get_contents($request,false,$context);

        $xmlData = simplexml_load_string($file);
        $response = json_encode($xmlData);
        $result = json_decode($response, TRUE);

        $this->CI->apiLogs->syncLogs($userdata['id'], 'titlepoint', $requestName, $request, $requestParams, $result, $orderId, $logid);

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
                return $response;
            }
            else if($status == 'processing') 
            {
                if($this->taxcount < 3)
                {
                    sleep(1);
                    $this->taxcount = $this->taxcount + 1;
                    return $this->getTaxImageRequestStatus($requestId,$orderId);                    
                }
                else
                {
                    $this->taxcount = 0;
                    return $response;
                }   
                
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

    public function generateGeoDocument($resultId,$orderId, $fileNumber)
    {
        $userdata = $this->CI->session->userdata('user');
        /*
        $primarySplitName = explode(' ', $primaryOwner);
        $secondarySplitName = explode(' ', $secondaryOwner);
        $primaryFirstName = $primaryMiddleName = $primaryLastName = $secondaryFirstName = $secondaryMiddleName = $secondaryLastName = $secondaryNameToSearch = $primaryNameToSearch = '';
        if (!empty($primarySplitName)) {
            $primaryFirstName = $primarySplitName[0];
            $primaryMiddleName = (isset($primarySplitName[1]) && isset($primarySplitName[2])) ? $primarySplitName[1] : '';
            $primaryLastName = isset($primarySplitName[2]) ? $primarySplitName[2] : (isset($primarySplitName[1]) ? $primarySplitName[1] : '');
			$primaryNameToSearch = $primaryLastName . ', ' . $primaryFirstName . ' ' . $primaryMiddleName;
        }

        if (!empty($secondarySplitName)) {
            $secondaryFirstName = $secondarySplitName[0];
            $secondaryMiddleName = (isset($secondarySplitName[1]) && isset($secondarySplitName[2])) ? $secondarySplitName[1] : '';
            $secondaryLastName = isset($secondarySplitName[2]) ? $secondarySplitName[2] : (isset($secondarySplitName[1]) ? $secondarySplitName[1] : '');
			$secondaryNameToSearch = $secondaryLastName . ', ' . $secondaryFirstName . ' ' . $secondaryMiddleName;
        }
        */
        
        $requestParams = array(
                            'userID' => env('TP_USERNAME'),
                            'password' => env('TP_PASSWORD'), 
                            'company'=>'',
                            'department' => '',
                            'titleOfficer' => '',
                            'requestingTPXML' => "true",
                            'resultID'=>  $resultId
                        );

                        
        // echo "<pre>";
        $requestUrl= env('TP_SERVICE_ENDPOINT') . TP_GEO_GET_RESULT_URL;
        $request = $requestUrl.http_build_query($requestParams);
        // print_r($request);
        $file = file_get_contents($request,false,$context);

        $logid = $this->CI->apiLogs->syncLogs($userdata['id'], 'titlepoint', 'generate_geo_document', $request, $requestParams, array(), $orderId, 0);

        $xmlData = simplexml_load_string($file);
        $response = json_encode($xmlData);
        $result = json_decode($response, TRUE);
        $condition = array(
            'where' => array(
                'file_number' => $fileNumber,
                )
            );
        $titlePointDetails = $this->CI->titlePointData->gettitlePointDetails($condition);
        $titlePointId = $titlePointDetails[0]['id'];
        
        /** Save document records here Start*/
        $recordArray = [];
		$i = 0;
		if ((strtolower($result['ReturnStatus']) == 'success') && !empty($result['Result']['DocumentList'])) {
			$result = $result['Result']['DocumentList'];
            $addressIds = isset($result['Addresses']['Address']) ? array_column($result['Addresses']['Address'], 'Id') : [];
            /*$primaryDocIdFilter = $secondaryDocIdFilter = [];
			if (!empty($primaryNameToSearch)) {
				$primaryDocIdFilter = array_filter($result['Parties']['DocumentParty'], function($elem) use($primaryNameToSearch){
					return str_contains(strtolower($elem['Name']), strtolower($primaryNameToSearch));
				});
			}
			if (!empty($secondaryNameToSearch)) {
				$secondaryDocIdFilter = array_filter($result['Parties']['DocumentParty'], function($elem) use($secondaryNameToSearch){
					return str_contains(strtolower($elem['Name']), strtolower($secondaryNameToSearch));
				});
			}
			$docIdFilter = array_merge($primaryDocIdFilter, $secondaryDocIdFilter);
			$docIds = array_column($docIdFilter, 'Id');
			print_r($docIds);*/
			$documentIdentifications = $result['DocumentIdentifications']['DocumentIdentification'];
            $items = $result['Items'];
			if (isset($items['Item'])) {
                /*
                $docIdentificationId = [];
				foreach($items['Item'] as $key => $val) {
					$documentPartys = $val['Parties']['DocumentParty'];
					$docPartiesId = array_column(array_column($documentPartys, '@attributes'), 'Id');
					if (!empty(array_intersect($docIds, $docPartiesId))) {
						array_push($docIdentificationId,$val['DocumentIdentification']['@attributes']['Id']);
					}
				}*/

                /** Start All instrument number details fetched */
                
                foreach($items['Item'] as $key => $val) {
                    $id = $val['DocumentIdentification'];
                    if (isset($id['@attributes']['Id'])) {
                        $docId = $id['@attributes']['Id'];
                        $key = array_search($docId, array_column($documentIdentifications, 'Id'));
                        $existKey = '';
                        if ($val['DocumentType'] == 'DEG' || $val['DocumentType'] == 'TDD' || $val['DocumentType'] == 'ASE' || $val['DocumentType'] == 'LIS' || $val['DocumentType'] == 'FIN') {
                            
                            if (!empty($recordArray)) {
                                if (isset($val['DocumentType']) && isset($val['DocumentSubType']) && strlen($val['DocumentSubType']) > 1) {
                                    $docType = $val['DocumentType'].$val['DocumentSubType'];
                                    //echo "hete--".$docType;
                                    $existKey = array_search($docType, array_column($recordArray, 'document_type'));
                                } else if (isset($val['DocumentType'])) {
                                    $existKey = array_search($val['DocumentType'], array_column($recordArray, 'document_type'));
                                }
                                //echo "dcd".$existKey;
                                //print_r($recordArray);
                                if (strlen($existKey) > 0) {
                                    print_r($recordArray);
                                    //echo "dcd---".$existKey."---".$val['DocumentType']."--------".$val['DocumentSubType'];
                                    unset($recordArray[$existKey]);
                                    $recordArray = array_values($recordArray); 
                                    //print_r($recordArray);
                                    $i--;
                                    //echo $i;
                                }
                                
                            }

                            if (isset($documentIdentifications[$key]) && !empty($documentIdentifications[$key]['InstrumentNumber'])) {
                                $recordArray[$i]['title_point_id'] = $titlePointId;
                                $recordArray[$i]['instrument'] = $documentIdentifications[$key]['InstrumentNumber'];
                                $recordArray[$i]['recorded_date'] = $documentIdentifications[$key]['RecordingDate'];
                                $recordArray[$i]['document_name'] = $val['DocumentFullName'];
                                if (isset($val['DocumentSubType'])) {
                                    $recordArray[$i]['document_type'] = $val['DocumentType'].$val['DocumentSubType'];
                                } else {
                                    $recordArray[$i]['document_type'] = $val['DocumentType'];
                                }
                                $recordArray[$i]['document_sub_type'] = isset($val['DocumentSubType']) ? $val['DocumentSubType'] : null;
                                $recordArray[$i]['created_at'] = date("Y-m-d H:i:s");
                                $recordArray[$i]['amount'] = 0;
                                // $recordArray[$i]['AddressId'] = $addressId;
                                $i++;
                            }
                        }
                    }
                }
                /** End All instrument number details fetched */

                /* Start Address based instrument number details fetched  
				foreach($items['Item'] as $key => $val) {
					$id = $val['DocumentIdentification'];
					if (isset($id['@attributes']['Id']) && isset($val['DocumentAddresses']) && !empty($val['DocumentAddresses']['Address'])) {
						
						$addressId = $val['DocumentAddresses']['Address']['@attributes']['Id'];
						if (in_array($addressId, $addressIds)) {
							$docId = $id['@attributes']['Id'];
							$key = array_search($docId, array_column($documentIdentifications, 'Id'));
							if (!empty($key) && isset($documentIdentifications[$key]) && $documentIdentifications[$key]['InstrumentNumber']) {
								$recordArray[$i]['title_point_id'] = $titlePointId;
								$recordArray[$i]['instrument'] = $documentIdentifications[$key]['InstrumentNumber'];
								$recordArray[$i]['recorded_date'] = $documentIdentifications[$key]['RecordingDate'];
								$recordArray[$i]['document_name'] = $val['DocumentFullName'];
								$recordArray[$i]['created_at'] = date("Y-m-d H:i:s");
								$recordArray[$i]['amount'] = 0;
								$i++;
							}
						}
					}
				} 
                 End Address based instrument number details fetched  */

                $this->CI->db->delete('pct_title_point_document_records', array('title_point_id' => $titlePointId)); 
                $this->CI->titlePointDocumentRecords->insertMultipleRecords($recordArray);
			}
            // echo "hello";die;
        }
        /** Save document records here end*/
        $this->CI->apiLogs->syncLogs($userdata['id'], 'titlepoint', 'generate_geo_document', $request, $requestParams, $result, $orderId, $logid);

        return $response;
    }
    
    public function getGeoImageRequestStatus($requestId,$orderId)
    {
        $userdata = $this->CI->session->userdata('user');
        $requestParams = array(
                            'userID' => env('TP_USERNAME'),
                            'password' => env('TP_PASSWORD'),                    
                            'company' => '',
                            'department' => '',
                            'titleOfficer' => '',
                            'requestId'=>  $requestId,
                            'maxWaitSeconds' => '20'
                        );
        
        $requestUrl= env('TP_SERVICE_ENDPOINT') . TP_GEO_REQUEST_SUMMARY_URL;
        $request = $requestUrl.http_build_query($requestParams);
        // print_r($request);
        $logid = $this->CI->apiLogs->syncLogs($userdata['id'], 'titlepoint', 'geo_request_summary_status', $request, $requestParams, array(), $orderId, 0);

        $file = file_get_contents($request,false,$context);
        $xmlData = simplexml_load_string($file);
        $response = json_encode($xmlData);
        // echo "--------------------------";
        // print_r($response);
        $imgResult = json_decode($response, TRUE);
        // echo "<pre> Hello";
        // print_r($imgResult);die;
        $this->CI->apiLogs->syncLogs($userdata['id'], 'titlepoint', 'geo_request_summary_status', $request, $requestParams, $imgResult, $orderId, $logid);

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
                if($this->geocount < 3)
                {
                    sleep(1);
                    $this->geocount = $this->geocount + 1;
                    return $this->getGeoImageRequestStatus($requestId,$orderId);                    
                }
                else
                {
                    $this->geocount = 0;
                    return $response;
                }   
                
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
}
