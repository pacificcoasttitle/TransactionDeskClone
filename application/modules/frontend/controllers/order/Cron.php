<?php

(defined('BASEPATH')) OR exit('No direct script access allowed');

class Cron extends MX_Controller {

    function __construct() 
    {
        parent::__construct();
        $this->load->library('session');
        $this->load->model('order/home_model');
        $this->load->model('order/titlePointData');
        $this->load->model('order/productType');
        $this->load->model('order/apiLogs');
    }

    public function import_orders_all_users()
    {
        $condition = array(
            'where' => array(
                'email_address' => 'ghernandez@pct.com',
            )
        );
        $customers = $this->home_model->get_customers($condition);
        if(!empty($customers)) {
            foreach ($customers as $customer) {
                $this->import_orders($customer);
            }
        }
        echo "All orders synced successfully for all users";exit;
    }

    function import_orders($user = array()) 
    {
        ini_set('max_execution_time', 0); 
        ini_set('memory_limit','2048M');
        $this->load->library('order/resware');
        $this->load->model('order/apiLogs');

        if(empty($user)) {
            $userdata = $this->session->userdata('user');
        } else {
            $userdata = $user;
            $userdata['email'] = $userdata['email_address'];
        }
        
        $logid = $this->apiLogs->syncLogs($userdata['id'], 'resware', 'get_orders', RESWARE_ORDER_API.'files/search', array(), array(), 0, 0);
        $res = $this->make_request('POST', 'files/search', '',  $userdata);
        $this->apiLogs->syncLogs($userdata['id'], 'resware', 'get_orders', RESWARE_ORDER_API.'files/search', array(), $res, 0, $logid);
        $result = json_decode($res);

        $this->db->simple_query('SET SESSION group_concat_max_len=150000');
        $this->db->select('GROUP_CONCAT(file_id) as file_ids');
        $this->db->from('order_details');	
        $this->db->where('customer_id', $userdata['id']);
        $this->db->group_by('customer_id'); 
        $query = $this->db->get();
        $filesResult = $query->row_array();

        if (!empty($filesResult)) {
            $file_ids = explode(',', $filesResult['file_ids']);
        } else {
            $syncFlag = 0;
        }
   
        foreach($result->Files as $res) {
            if (!empty($file_ids)) {
                if (in_array((int)$res->FileID, $file_ids)) {
                    $syncFlag = 1;  
                } else {
                    $syncFlag = 0;  
                }
            } 
            if ($syncFlag == 0) {
                $FullProperty = $res->Properties[0]->StreetNumber." ".$res->Properties[0]->StreetDirection." ".$res->Properties[0]->StreetName." ".$res->Properties[0]->StreetSuffix.", ".$res->Properties[0]->City.", ".$res->Properties[0]->State.", ".$res->Properties[0]->Zip;
                $address = $res->Properties[0]->StreetNumber." ".$res->Properties[0]->StreetDirection." ".$res->Properties[0]->StreetName." ".$res->Properties[0]->StreetSuffix;
                $primary_owner = ($res->Buyers[0]->Primary && $res->Buyers[0]->Primary->First) ? $res->Buyers[0]->Primary->First : '';
                $primary_owner .= ($res->Buyers[0]->Primary && $res->Buyers[0]->Primary->Last) ? " ".$res->Buyers[0]->Primary->Last : '';
                $secondary_owner = ($res->Buyers[0]->Secondary && $res->Buyers[0]->Secondary->First) ? $res->Buyers[0]->Secondary->First : '';
                $secondary_owner .= ($res->Buyers[0]->Secondary && $res->Buyers[0]->Secondary->Last) ? " ".$res->Buyers[0]->Secondary->Last : '';


                /* get blackkight data */
                $locale = $res->Properties[0]->City;
                
                if (($locale)) 
                {
                    if(!empty($res->Properties[0]->State))
                    {
                        $locale .= ', '.$res->Properties[0]->State;
                    } 
                    else 
                    {
                        $locale .= ', CA';
                    }
                }
                
                $property_details = $this->getSearchResult($address, $locale);
                $property_type = isset($property_details['property_type']) && !empty($property_details['property_type']) ? $property_details['property_type'] : '';
                $LegalDescription = isset($property_details['legaldescription']) && !empty($property_details['legaldescription']) ? $property_details['legaldescription'] : '';
                $apn = isset($property_details['apn']) && !empty($property_details['apn']) ? $property_details['apn'] : '';
                /* get blackkight data */

                $propertyData = array(
                    'customer_id' => $userdata['id'],
                    'buyer_agent_id' => 0,
                    'listing_agent_id' => 0,
                    'escrow_lender_id' => 0,
                    'parcel_id' => $res->Properties[0]->ParcelID,
                    'address' => $address,
                    'city' => $res->Properties[0]->City,
                    'state' => $res->Properties[0]->State,
                    'zip' => $res->Properties[0]->Zip,
                    'property_type' => $property_type,
                    'full_address' => $FullProperty,
                    'apn' => $apn,
                    'county' => $res->Properties[0]->County,
                    'legal_description' => $LegalDescription,
                    'primary_owner' => $primary_owner,
                    'secondary_owner' => $SecondaryOwner,
                    'additional_details'=> '',
                    'status'=> 1
                );

                $propertyId = $this->home_model->insert($propertyData,'property_details');

                $transactionData = array(
                    'customer_id' => $userdata['id'],
                    'sales_amount' =>  !empty($res->SalesPrice) ? $res->SalesPrice : 0,
                    'loan_number' => !empty($res->Loans[0]->LoanNumber) ? $res->Loans[0]->LoanNumber : 0,
                    'loan_amount' => !empty($res->Loans[0]->LoanAmount) ? $res->Loans[0]->LoanAmount : 0,
                    'transaction_type' => $res->TransactionProductType->TransactionTypeID,
                    'purchase_type' => $res->TransactionProductType->ProductTypeID,
                    'status'=> 1
                );
                $transactionId = $this->home_model->insert($transactionData,'transaction_details');

                $time = round((int)(str_replace("-0000)/", "", str_replace("/Date(", "",$res->Dates->OpenedDate)))/1000);

                $created_date = date('Y-m-d H:i:s', $time);

                $orderData = array(
                    'customer_id' => $userdata['id'],
                    'file_id' => $res->FileID,
                    'file_number' => $res->FileNumber,
                    'property_id' => $propertyId,
                    'transaction_id' => $transactionId,
                    'created_at' => $created_date,
                    'status'=> 1
                );

                $orderId = $this->home_model->insert($orderData,'order_details');

                /* TitlePoint API */
                $fips = isset($property_details['fips']) && !empty($property_details['fips']) ? $property_details['fips'] : '';
                $tp_details = $this->getTPData($address,$res->Properties[0]->City, $fips);
                $tp_details['file_id'] = $res->FileID; 
                $tp_details['file_number'] = $res->FileNumber;
                $tpId = $this->titlePointData->insert($tp_details);
                /* TitlePoint API */

            }
        }
        echo "All orders synced successfully";
    }

    public function make_request($http_method, $endpoint, $body_params='', $userdata)
    {
        $login =  $userdata['email'];
        
        if ($userdata['email'] == 'ghernandez@pct.com') {
            $password= 'Alpha637#';
        } else {
            $password= 'Pacific12';
        }
        $ch = curl_init(RESWARE_ORDER_API.$endpoint);                                    
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $http_method);                        
        curl_setopt($ch, CURLOPT_POSTFIELDS, $body_params);                   
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
        curl_setopt($ch, CURLOPT_USERPWD, "$login:$password");
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(                                
            'Content-Type: application/json',
            'Content-Length: ' . strlen($body_params))                                 
        ); 
        $error_msg = curl_error($ch);
        $result = curl_exec($ch);
        return $result;
    }


    public function getSearchResult($address, $locale)
    {
        $data=new stdClass();
        $data->Address= $address;
        $data->LastLine= (string) $locale;
        $data->ClientReference= '<CustCompFilter><CompNum>8</CompNum><MonthsBack>12</MonthsBack></CustCompFilter>';
        $data->OwnerName= '';
        $data->key= '22C75EF7-5DBF-4B26-B2DB-998BE080F29C';
        $data->ReportType= '187';

        $request = 'http://api.sitexdata.com/sitexapi/sitexapi.asmx/AddressSearch?';

        $requestUrl = $request.http_build_query($data);

        $getsortedresults = isset($_GET['getsortedresults'])?$_GET['getsortedresults']:'false';
        
        $opts = array(
            'http'=>array(
                'header' => "User-Agent:MyAgent/1.0\r\n"
            ),
            "ssl"=>array(
                "verify_peer"=>false,
                "verify_peer_name"=>false,
            )
        );
        $context = stream_context_create($opts);
        $file = file_get_contents($requestUrl,false,$context);
        $xmlData = simplexml_load_string($file);
        $response = json_encode($xmlData);
        $result = json_decode($response,TRUE);
        $property_info = array();
        if(isset($result['Status']) && !empty($result['Status']) && $result['Status'] == 'OK')
        {
            $reportUrl = (isset($result['ReportURL']) && !empty($result['ReportURL'])) ? $result['ReportURL'] : '';

            if($reportUrl)
            {
                $rdata=new stdClass();
                $rdata->key= '22C75EF7-5DBF-4B26-B2DB-998BE080F29C';
                $requestUrl = $reportUrl.http_build_query($rdata);
                $reportFile = file_get_contents($requestUrl,false,$context);
                $reportData = simplexml_load_string($reportFile);
                $response = json_encode($reportData);
                $details = json_decode($response,TRUE);

                $property_info['property_type'] = isset($details['PropertyProfile']['PropertyCharacteristics']['UseCode']) && !empty($details['PropertyProfile']['PropertyCharacteristics']['UseCode']) ? $details['PropertyProfile']['PropertyCharacteristics']['UseCode'] : '';
                $property_info['legaldescription'] = isset($details['PropertyProfile']['LegalDescriptionInfo']['LegalBriefDescription']) && !empty($details['PropertyProfile']['LegalDescriptionInfo']['LegalBriefDescription']) ? $details['PropertyProfile']['LegalDescriptionInfo']['LegalBriefDescription'] : '';
                $property_info['apn'] = isset($details['PropertyProfile']['APN']) && !empty($details['PropertyProfile']['APN']) ? $details['PropertyProfile']['APN'] : '';
                
                $property_info['fips'] = isset($details['SubjectValueInfo']['FIPS']) && !empty($details['SubjectValueInfo']['FIPS']) ? $details['SubjectValueInfo']['FIPS'] : '';
            }
        }

        return $property_info;
    }

    public function getTPData($address, $city, $fips)
    {
        $requestParams = array(
            'userID' => TP_USERNAME,
            'password' => TP_PASSWORD,
            'orderNo' =>  '',
            'customerRef'=>  '',
            'company'=>  '',
            'department'=>  '',
            'titleOfficer'=>  '',
            'orderComment'=>  '',
            'starterRemarks'=>  '',
        );

        $requestParams['serviceType'] = SERVICE_TYPE;
        $requestParams['parameters'] = 'Address1='.$address.';City='.$city.';LvLookup=Address;LvLookupValue='.$address.', '.$city.';LvReportFormat=LV;IncludeTaxAssessor=true';
        $requestParams['fipsCode'] = $fips;
        $requestUrl= TP_CREATE_SERVICE_ENDPOINT;
        $request = $requestUrl.http_build_query($requestParams);

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
        $responseStatus = isset($result['ReturnStatus']) && !empty($result['ReturnStatus']) ? $result['ReturnStatus'] : '';
        
        if($responseStatus == 'Success')
        {
            $tpData = array();
            $requestId = isset($result['RequestID']) && !empty($result['RequestID']) ? $result['RequestID'] : '';
            if($requestId)
            {
                $summary_requestParams = array(
                    'userID' => TP_USERNAME,
                    'password' => TP_PASSWORD,
                    'company'=>  '',
                    'department'=>  '',
                    'titleOfficer'=>  '',
                    'requestId'=>  $requestId,
                    'maxWaitSeconds'=>  20
                );

                $summary_request = TP_REQUEST_SUMMARY_ENDPOINT.http_build_query($summary_requestParams);

                $context = stream_context_create($opts);
                $summary_file = file_get_contents($summary_request,false,$context);
                $summary_xmlData = simplexml_load_string($summary_file);
                $summary_response = json_encode($summary_xmlData);
                $summary_result = json_decode($summary_response,TRUE);
                
                $summary_responseStatus = isset($summary_result['ReturnStatus']) && !empty($summary_result['ReturnStatus']) ? $summary_result['ReturnStatus'] : '';
                if($summary_responseStatus == 'Success')
                {
                    $resultId = isset($summary_result['RequestSummaries']['RequestSummary']['Order']['Services']['Service']['ThumbNails']['ResultThumbNail'][0]['ID']) && !empty($summary_result['RequestSummaries']['RequestSummary']['Order']['Services']['Service']['ThumbNails']['ResultThumbNail'][0]['ID']) ? $summary_result['RequestSummaries']['RequestSummary']['Order']['Services']['Service']['ThumbNails']['ResultThumbNail'][0]['ID'] : ''; 
                    $serviceId = isset($summary_result['RequestSummaries']['RequestSummary']['Order']['Services']['Service']['ID']) && !empty($summary_result['RequestSummaries']['RequestSummary']['Order']['Services']['Service']['ID']) ? $summary_result['RequestSummaries']['RequestSummary']['Order']['Services']['Service']['ID'] : '';
                    
                    $tpData['cs4_result_id'] = $resultId;
                    $tpData['cs4_service_id'] = $serviceId;

                    $output_requestParams = array(
                        'userID' => TP_USERNAME,
                        'password' => TP_PASSWORD,
                        'company'=>  '',
                        'department'=>  '',
                        'titleOfficer'=>  '',
                        'resultID'=>  $resultId
                    );

                    $output_resultUrl = TP_GET_RESULT_BY_ID;

                    $output_request = $output_resultUrl.http_build_query($output_requestParams);
                    $context = stream_context_create($opts);
                    $output_file = file_get_contents($output_request,false,$context);

                    $output_xmlData = simplexml_load_string($output_file);
                    $output_response = json_encode($output_xmlData);
                    $output_result = json_decode($output_response,TRUE);
                    
                    $output_responseStatus = isset($output_result['ReturnStatus']) && !empty($output_result['ReturnStatus']) ? $output_result['ReturnStatus'] : '';
                    if($output_responseStatus == 'Success')
                    {
                        $briefLegal = isset($output_result['Result']['BriefLegal']) && !empty($output_result['Result']['BriefLegal']) ? $output_result['Result']['BriefLegal'] : 'No data found.';
                        
                        $vesting = isset($output_result['Result']['Vesting']) && !empty($output_result['Result']['Vesting']) ? $output_result['Result']['Vesting'] : 'No data found.';
                        
                        $instrumentNumber = isset($output_result['Result']['LvDeeds']['LegalAndVesting2DeedInfo'][0]['InstrumentNumber']) && !empty($output_result['Result']['LvDeeds']['LegalAndVesting2DeedInfo'][0]['InstrumentNumber']) ? $output_result['Result']['LvDeeds']['LegalAndVesting2DeedInfo'][0]['InstrumentNumber'] : '';
                        $recordedDate = isset($output_result['Result']['LvDeeds']['LegalAndVesting2DeedInfo'][0]['RecordedDate']) && !empty($output_result['Result']['LvDeeds']['LegalAndVesting2DeedInfo'][0]['RecordedDate']) ? $output_result['Result']['LvDeeds']['LegalAndVesting2DeedInfo'][0]['RecordedDate'] : '';

                        $tpData['legal_description'] = $briefLegal;
                        $tpData['vesting_information'] = $vesting;
                        $tpData['cs4_instrument_no'] = $instrumentNumber;
                        $tpData['cs4_recorded_date'] = $recordedDate;
                    }
                }
            }
            $tpData['cs4_request_id'] =   $requestId;
        }

        return $tpData;
    }

    public function import_product_types()
    {
        if(empty($user)) 
        {
            $userdata = $this->session->userdata('user');
        } 
        else 
        {
            $userdata = $user;
            $userdata['email'] = $userdata['email_address'];
        }
        
        $endPoint = 'types/products';

        $logid = $this->apiLogs->syncLogs($userdata['id'], 'resware', 'get_product_types', RESWARE_ORDER_API.$endPoint, array(), array(), 0, 0);
        $result = $this->make_request('GET', $endPoint, '',$userdata);
        $this->apiLogs->syncLogs($userdata['id'], 'resware', 'get_product_types', RESWARE_ORDER_API.$endPoint, array(), $result, 0, $logid);
        $response = json_decode($result,TRUE);

        if(isset($response) && !empty($response))
        {
            foreach ($response as $key => $value) 
            {
                $display_name = '';
                $status = 0;
                if((isset($value['ProductTypeID']) && $value['ProductTypeID'] == 19) && (isset($value['TransactionTypeID']) && $value['TransactionTypeID'] == 3))
                {
                    $display_name = 'Loan: Refinance';
                    $status = 1;
                }
                elseif((isset($value['ProductTypeID']) && $value['ProductTypeID'] == 20) && (isset($value['TransactionTypeID']) && $value['TransactionTypeID'] == 3))
                {
                    $display_name = 'Sales: Purchase';
                    $status = 1;
                }

                $data = array(
                    'transaction_type' =>trim($value['TransactionType']),
                    'transaction_type_id' => trim($value['TransactionTypeID']),
                    'product_type' => trim($value['ProductType']),
                    'product_type_id' => trim($value['ProductTypeID']),
                   'display_name' => $display_name,
                   'status' => $status
                );
               $this->productType->insert($data);
            }
        }
        

        echo "Product types imported successfully.";
    }
}