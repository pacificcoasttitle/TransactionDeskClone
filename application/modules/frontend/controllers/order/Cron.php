<?php

(defined('BASEPATH')) or exit('No direct script access allowed');

use phpseclib3\Net\SFTP;

class Cron extends MX_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->library('session');
        $this->load->model('order/home_model');
        $this->load->model('order/titlePointData');
        $this->load->model('order/productType');
        $this->load->model('order/apiLogs');
        $this->load->library('order/titlepoint');
    }

    public $taxcount = 0;
    public $lvcount  = 0;

    public function import_orders_all_users()
    {
        $condition = [
            'where' => [
                'status'              => 1,
                'is_master'           => 0,
                'is_password_updated' => 1,
                'is_sales_rep'        => 0,
            ],
        ];
        $customers = $this->home_model->get_customers($condition);
        if (!empty($customers)) {
            foreach ($customers as $customer) {
                $this->import_orders($customer);
            }
        }
        echo "All orders synced successfully for all users";exit;
    }

    public function import_orders($user = [])
    {
        $order_status = ['open', 'closed'];

        ini_set('max_execution_time', 0);
        ini_set('memory_limit', '2048M');
        $this->load->library('order/resware');
        $this->load->model('order/apiLogs');

        if ($this->input->post('is_admin') == 1) {
            $id                = $this->input->post('id');
            $userdata          = $this->home_model->get_user(['id' => $id]);
            $userdata['email'] = $userdata['email_address'];
        } else {
            if (empty($user)) {
                $userdata = $this->session->userdata('user');
            } else {
                $userdata          = $user;
                $userdata['email'] = $userdata['email_address'];
            }
        }
        if (isset($userdata) && !empty($userdata)) {
            $msg = '';
            foreach ($order_status as $key => $value) {
                $status = [];
                if ($value == 'closed') {
                    $status['Statuses'][] = ['StatusID' => 9, 'Name' => 'Closed'];
                } else {
                    $status['Statuses'][] = ['StatusID' => 2, 'Name' => 'Open'];
                }

                $logid = $this->apiLogs->syncLogs($userdata['id'], 'resware', 'get_orders', env('RESWARE_ORDER_API') . 'files/search', json_encode($status), [], 0, 0);

                $res = $this->make_request('POST', 'files/search', json_encode($status), $userdata);

                $this->apiLogs->syncLogs($userdata['id'], 'resware', 'get_orders', env('RESWARE_ORDER_API') . 'files/search', json_encode($status), $res, 0, $logid);

                $result = json_decode($res, true);

                if (isset($result['Files']) && !empty($result['Files'])) {
                    $this->db->simple_query('SET SESSION group_concat_max_len=150000');
                    $this->db->select('GROUP_CONCAT(file_id) as file_ids');
                    $this->db->from('order_details');
                    $this->db->where('customer_id', $userdata['id']);
                    $this->db->group_by('customer_id');
                    $query       = $this->db->get();
                    $filesResult = $query->row_array();

                    if (!empty($filesResult)) {
                        $file_ids = explode(',', $filesResult['file_ids']);
                    } else {
                        $syncFlag = 0;
                    }

                    foreach ($result['Files'] as $res) {
                        $partner_fname = $res['Partners'][0]['PrimaryEmployee']['FirstName'];
                        $partner_lname = $res['Partners'][0]['PrimaryEmployee']['LastName'];
                        $partner_name  = $res['Partners'][0]['PartnerName'];
                        if ($partner_name == $userdata['company_name'] && strpos($userdata['last_name'], $partner_lname) !== false && strpos($userdata['first_name'], $partner_fname) !== false) {
                            if (!empty($file_ids)) {
                                if (in_array((int) $res['FileID'], $file_ids)) {
                                    $syncFlag = 1;
                                } else {
                                    $syncFlag = 0;
                                }
                            }

                            if ($syncFlag == 0) {
                                $FullProperty = $res['Properties'][0]['StreetNumber'] . " " . $res['Properties'][0]['StreetDirection'] . " " . $res['Properties'][0]['StreetName'] . " " . $res['Properties'][0]['StreetSuffix'] . ", " . $res['Properties'][0]['City'] . ", " . $res['Properties'][0]['State'] . ", " . $res['Properties'][0]['Zip'];
                                $address      = $res['Properties'][0]['StreetNumber'] . " " . $res['Properties'][0]['StreetDirection'] . " " . $res['Properties'][0]['StreetName'] . " " . $res['Properties'][0]['StreetSuffix'];

                                /* get blackkight data */
                                $locale = $res['Properties'][0]['City'];

                                if (($locale)) {
                                    if (!empty($res['Properties'][0]['State'])) {
                                        $locale .= ', ' . $res['Properties'][0]['State'];
                                    } else {
                                        $locale .= ', CA';
                                    }
                                }

                                $property_details = $this->getSearchResult($address, $locale);

                                $property_type    = isset($property_details['property_type']) && !empty($property_details['property_type']) ? $property_details['property_type'] : '';
                                $LegalDescription = isset($property_details['legaldescription']) && !empty($property_details['legaldescription']) ? $property_details['legaldescription'] : '';
                                $apn              = isset($property_details['apn']) && !empty($property_details['apn']) ? $property_details['apn'] : '';
                                /* get blackkight data */

                                $propertyData = [
                                    'customer_id'       => $userdata['id'],
                                    'buyer_agent_id'    => 0,
                                    'listing_agent_id'  => 0,
                                    'escrow_lender_id'  => 0,
                                    'parcel_id'         => $res['Properties'][0]['ParcelID'],
                                    'address'           => removeMultipleSpace($address),
                                    'city'              => $res['Properties'][0]['City'],
                                    'state'             => $res['Properties'][0]['State'],
                                    'zip'               => $res['Properties'][0]['Zip'],
                                    'property_type'     => $property_type,
                                    'full_address'      => removeMultipleSpace($FullProperty),
                                    'apn'               => $apn,
                                    'county'            => $res['Properties'][0]['County'],
                                    'legal_description' => $LegalDescription,
                                    /*'primary_owner' => $primary_owner,
                                    'secondary_owner' => $SecondaryOwner,*/
                                    // 'additional_details'=> '',
                                    // 'is_imported'=> 1,
                                    'status'            => 1,
                                ];

                                $transactionData = [
                                    'customer_id'      => $userdata['id'],
                                    'sales_amount'     => !empty($res['SalesPrice']) ? $res['SalesPrice'] : 0,
                                    // 'sales_representative' =>  $userdata['id'],
                                    'loan_number'      => !empty($res['Loans'][0]['LoanNumber']) ? $res['Loans'][0]['LoanNumber'] : 0,
                                    'loan_amount'      => !empty($res['Loans'][0]['LoanAmount']) ? $res['Loans'][0]['LoanAmount'] : 0,
                                    'transaction_type' => $res['TransactionProductType']['TransactionTypeID'],
                                    'purchase_type'    => $res['TransactionProductType']['ProductTypeID'],
                                    'status'           => 1,
                                ];

                                $primary_owner = isset($res['Buyers'][0]['Primary']['First']) && !empty($res['Buyers'][0]['Primary']['First']) ? $res['Buyers'][0]['Primary']['First'] : '';

                                $primary_owner .= isset($res['Buyers'][0]['Primary']['Middle']) && !empty($res['Buyers'][0]['Primary']['Middle']) ? " " . $res['Buyers'][0]['Primary']['Middle'] : '';
                                $primary_owner .= isset($res['Buyers'][0]['Primary']['Last']) && !empty($res['Buyers'][0]['Primary']['Last']) ? " " . $res['Buyers'][0]['Primary']['Last'] : '';

                                $secondary_owner = isset($res['Buyers'][0]['Secondary']['First']) && !empty($res['Buyers'][0]['Secondary']['First']) ? $res['Buyers'][0]['Secondary']['First'] : '';
                                $secondary_owner .= isset($res['Buyers'][0]['Secondary']['Middle']) && !empty($res['Buyers'][0]['Secondary']['Middle']) ? $res['Buyers'][0]['Secondary']['Middle'] : '';
                                $secondary_owner .= isset($res['Buyers'][0]['Secondary']['Last']) && !empty($res['Buyers'][0]['Secondary']['Last']) ? " " . $res['Buyers'][0]['Secondary']['Last'] : '';

                                $ProductTypeTxt = $res['TransactionProductType']['ProductType'];
                                if (strpos($ProductTypeTxt, 'Loan') !== false) {
                                    $propertyData['primary_owner']   = $primary_owner;
                                    $propertyData['secondary_owner'] = $secondary_owner;
                                } elseif (strpos($ProductTypeTxt, 'Sale') !== false) {
                                    $transactionData['borrower']           = $primary_owner;
                                    $transactionData['secondary_borrower'] = $secondary_owner;

                                    $propertyData['primary_owner']   = isset($property_info['primary_owner']) && !empty($property_info['primary_owner']) ? $property_info['primary_owner'] : '';
                                    $propertyData['secondary_owner'] = isset($property_info['secondary_owner']) && !empty($property_info['secondary_owner']) ? $property_info['secondary_owner'] : '';
                                }

                                $propertyId = $this->home_model->insert($propertyData, 'property_details');

                                $transactionId = $this->home_model->insert($transactionData, 'transaction_details');

                                $time = round((int) (str_replace("-0000)/", "", str_replace("/Date(", "", $res['Dates']['OpenedDate']))) / 1000);

                                $created_date = date('Y-m-d H:i:s', $time);

                                $orderData = [
                                    'customer_id'        => $userdata['id'],
                                    'file_id'            => $res['FileID'],
                                    'file_number'        => $res['FileNumber'],
                                    'property_id'        => $propertyId,
                                    'transaction_id'     => $transactionId,
                                    'created_at'         => $created_date,
                                    'status'             => 1,
                                    'is_imported'        => 1,
                                    'is_sales_rep_order' => 0,
                                    'resware_status'     => strtolower($res['Status']['Name']),
                                ];

                                $orderId = $this->home_model->insert($orderData, 'order_details');
                            } else if ($syncFlag == 1) {
                                $orderData = [
                                    'resware_status' => strtolower($res['Status']['Name']),
                                ];
                                $condition = [
                                    'file_id'     => $res['FileID'],
                                    'file_number' => $res['FileNumber'],
                                ];

                                $orderId = $this->home_model->update($orderData, $condition, 'order_details');
                            }
                        }

                    }
                    $import_status = 'success';
                    $msg .= "All orders with status " . $value . " synced successfully for user: " . $userdata['email'] . "<br>";
                    // $response = array('status'=>'success','msg'=>"All orders synced successfully for user: ".$userdata['email']);
                } else {
                    // $response = array('status'=>'error','msg'=> "No orders found for user: ".$userdata['email']);

                    $import_status = 'error';
                    $msg .= "No orders found with status " . $value . " for user: " . $userdata['email'] . "<br>";
                }
            } // end foreach
            $response = ['status' => $import_status, 'msg' => $msg];
        } else {
            $response = ['status' => 'error', 'msg' => "User not selected."];
        }

        echo json_encode($response);
    }

    public function make_request($http_method, $endpoint, $body_params = '', $userdata)
    {

        if ($userdata['email'] == 'admin@pct24.com' || (isset($userdata['admin_api']) && $userdata['admin_api'] == 1)) {
            $this->load->library('order/order');
            $credResult = $this->order->get_resware_admin_credential();
            $login      = $credResult['username'];
            $password   = $credResult['password'];
        } else {
            $login    = $userdata['email'];
            $password = $userdata['random_password'];
        }
        $ch = curl_init(env('RESWARE_ORDER_API') . $endpoint);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $http_method);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $body_params);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
        curl_setopt($ch, CURLOPT_USERPWD, "$login:$password");
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Content-Type: application/json',
            'Content-Length: ' . strlen($body_params)]
        );
        $error_msg = curl_error($ch);
        $result    = curl_exec($ch);
        return $result;
    }

    public function getSearchResult($address, $locale)
    {
        $data                  = new stdClass();
        $data->Address         = $address;
        $data->LastLine        = (string) $locale;
        $data->ClientReference = '<CustCompFilter><CompNum>8</CompNum><MonthsBack>12</MonthsBack></CustCompFilter>';
        $data->OwnerName       = '';
        $data->key             = env('BLACK_KNIGHT_KEY');
        $data->ReportType      = '187';

        $request = 'http://api.sitexdata.com/sitexapi/sitexapi.asmx/AddressSearch?';

        $requestUrl = $request . http_build_query($data);

        $getsortedresults = isset($_GET['getsortedresults']) ? $_GET['getsortedresults'] : 'false';

        $opts = [
            'http' => [
                'header' => "User-Agent:MyAgent/1.0\r\n",
            ],
            "ssl"  => [
                "verify_peer"      => false,
                "verify_peer_name" => false,
            ],
        ];
        $context       = stream_context_create($opts);
        $file          = file_get_contents($requestUrl, false, $context);
        $xmlData       = simplexml_load_string($file);
        $response      = json_encode($xmlData);
        $result        = json_decode($response, true);
        $property_info = [];
        if (isset($result['Status']) && !empty($result['Status']) && $result['Status'] == 'OK') {
            $reportUrl = (isset($result['ReportURL']) && !empty($result['ReportURL'])) ? $result['ReportURL'] : '';

            if ($reportUrl) {
                $rdata      = new stdClass();
                $rdata->key = env('BLACK_KNIGHT_KEY');
                $requestUrl = $reportUrl . http_build_query($rdata);
                $reportFile = file_get_contents($requestUrl, false, $context);
                $reportData = simplexml_load_string($reportFile);
                $response   = json_encode($reportData);
                $details    = json_decode($response, true);

                $property_info['property_type']    = isset($details['PropertyProfile']['PropertyCharacteristics']['UseCode']) && !empty($details['PropertyProfile']['PropertyCharacteristics']['UseCode']) ? $details['PropertyProfile']['PropertyCharacteristics']['UseCode'] : '';
                $property_info['legaldescription'] = isset($details['PropertyProfile']['LegalDescriptionInfo']['LegalBriefDescription']) && !empty($details['PropertyProfile']['LegalDescriptionInfo']['LegalBriefDescription']) ? $details['PropertyProfile']['LegalDescriptionInfo']['LegalBriefDescription'] : '';
                $property_info['apn']              = isset($details['PropertyProfile']['APN']) && !empty($details['PropertyProfile']['APN']) ? $details['PropertyProfile']['APN'] : '';

                $property_info['unit_no'] = isset($details['PropertyProfile']['SiteUnit']) && !empty($details['PropertyProfile']['SiteUnit']) ? $details['PropertyProfile']['SiteUnit'] : '';

                $property_info['fips'] = isset($details['SubjectValueInfo']['FIPS']) && !empty($details['SubjectValueInfo']['FIPS']) ? $details['SubjectValueInfo']['FIPS'] : '';

                $primaryOwner                     = isset($details['PropertyProfile']['PrimaryOwnerName']) && !empty($details['PropertyProfile']['PrimaryOwnerName']) ? $details['PropertyProfile']['PrimaryOwnerName'] : '';
                $secondaryOwner                   = isset($details['PropertyProfile']['SecondaryOwnerName']) && !empty($details['PropertyProfile']['SecondaryOwnerName']) ? $details['PropertyProfile']['SecondaryOwnerName'] : '';
                $property_info['primary_owner']   = $primaryOwner;
                $property_info['secondary_owner'] = $secondaryOwner;
            }
        }

        return $property_info;
    }

    public function getTPData($address, $city, $fips)
    {
        $requestParams = [
            'userID'         => env('TP_USERNAME'),
            'password'       => env('TP_PASSWORD'),
            'orderNo'        => '',
            'customerRef'    => '',
            'company'        => '',
            'department'     => '',
            'titleOfficer'   => '',
            'orderComment'   => '',
            'starterRemarks' => '',
        ];

        $requestParams['serviceType'] = env('SERVICE_TYPE');
        $requestParams['parameters']  = 'Address1=' . $address . ';City=' . $city . ';LvLookup=Address;LvLookupValue=' . $address . ', ' . $city . ';LvReportFormat=LV;IncludeTaxAssessor=true';
        $requestParams['fipsCode']    = $fips;
        $requestUrl                   = env('TP_CREATE_SERVICE_ENDPOINT');
        $request                      = $requestUrl . http_build_query($requestParams);

        $opts = [
            "ssl" => [
                "verify_peer"      => false,
                "verify_peer_name" => false,
            ],
        ];
        $context = stream_context_create($opts);
        $file    = file_get_contents($request, false, $context);

        $xmlData        = simplexml_load_string($file);
        $response       = json_encode($xmlData);
        $result         = json_decode($response, true);
        $responseStatus = isset($result['ReturnStatus']) && !empty($result['ReturnStatus']) ? $result['ReturnStatus'] : '';

        if ($responseStatus == 'Success') {
            $tpData    = [];
            $requestId = isset($result['RequestID']) && !empty($result['RequestID']) ? $result['RequestID'] : '';
            if ($requestId) {
                $summary_requestParams = [
                    'userID'         => env('TP_USERNAME'),
                    'password'       => env('TP_PASSWORD'),
                    'company'        => '',
                    'department'     => '',
                    'titleOfficer'   => '',
                    'requestId'      => $requestId,
                    'maxWaitSeconds' => 20,
                ];

                $summary_request = env('TP_REQUEST_SUMMARY_ENDPOINT') . http_build_query($summary_requestParams);

                $context          = stream_context_create($opts);
                $summary_file     = file_get_contents($summary_request, false, $context);
                $summary_xmlData  = simplexml_load_string($summary_file);
                $summary_response = json_encode($summary_xmlData);
                $summary_result   = json_decode($summary_response, true);

                $summary_responseStatus = isset($summary_result['ReturnStatus']) && !empty($summary_result['ReturnStatus']) ? $summary_result['ReturnStatus'] : '';
                if ($summary_responseStatus == 'Success') {
                    $resultId  = isset($summary_result['RequestSummaries']['RequestSummary']['Order']['Services']['Service']['ThumbNails']['ResultThumbNail'][0]['ID']) && !empty($summary_result['RequestSummaries']['RequestSummary']['Order']['Services']['Service']['ThumbNails']['ResultThumbNail'][0]['ID']) ? $summary_result['RequestSummaries']['RequestSummary']['Order']['Services']['Service']['ThumbNails']['ResultThumbNail'][0]['ID'] : '';
                    $serviceId = isset($summary_result['RequestSummaries']['RequestSummary']['Order']['Services']['Service']['ID']) && !empty($summary_result['RequestSummaries']['RequestSummary']['Order']['Services']['Service']['ID']) ? $summary_result['RequestSummaries']['RequestSummary']['Order']['Services']['Service']['ID'] : '';

                    $tpData['cs4_result_id']  = $resultId;
                    $tpData['cs4_service_id'] = $serviceId;

                    $output_requestParams = [
                        'userID'       => env('TP_USERNAME'),
                        'password'     => env('TP_PASSWORD'),
                        'company'      => '',
                        'department'   => '',
                        'titleOfficer' => '',
                        'resultID'     => $resultId,
                    ];

                    $output_resultUrl = env('TP_GET_RESULT_BY_ID');

                    $output_request = $output_resultUrl . http_build_query($output_requestParams);
                    $context        = stream_context_create($opts);
                    $output_file    = file_get_contents($output_request, false, $context);

                    $output_xmlData  = simplexml_load_string($output_file);
                    $output_response = json_encode($output_xmlData);
                    $output_result   = json_decode($output_response, true);

                    $output_responseStatus = isset($output_result['ReturnStatus']) && !empty($output_result['ReturnStatus']) ? $output_result['ReturnStatus'] : '';
                    if ($output_responseStatus == 'Success') {
                        $briefLegal = isset($output_result['Result']['BriefLegal']) && !empty($output_result['Result']['BriefLegal']) ? $output_result['Result']['BriefLegal'] : 'No data found.';

                        $vesting = isset($output_result['Result']['Vesting']) && !empty($output_result['Result']['Vesting']) ? $output_result['Result']['Vesting'] : 'No data found.';

                        $instrumentNumber = isset($output_result['Result']['LvDeeds']['LegalAndVesting2DeedInfo'][0]['InstrumentNumber']) && !empty($output_result['Result']['LvDeeds']['LegalAndVesting2DeedInfo'][0]['InstrumentNumber']) ? $output_result['Result']['LvDeeds']['LegalAndVesting2DeedInfo'][0]['InstrumentNumber'] : '';
                        $recordedDate     = isset($output_result['Result']['LvDeeds']['LegalAndVesting2DeedInfo'][0]['RecordedDate']) && !empty($output_result['Result']['LvDeeds']['LegalAndVesting2DeedInfo'][0]['RecordedDate']) ? $output_result['Result']['LvDeeds']['LegalAndVesting2DeedInfo'][0]['RecordedDate'] : '';

                        $tpData['legal_description']   = $briefLegal;
                        $tpData['vesting_information'] = $vesting;
                        $tpData['cs4_instrument_no']   = $instrumentNumber;
                        $tpData['cs4_recorded_date']   = $recordedDate;
                    }
                }
            }
            $tpData['cs4_request_id'] = $requestId;
        }

        return $tpData;
    }

    public function import_product_types()
    {
        ini_set('max_execution_time', 0);
        ini_set('memory_limit', '2048M');
        if (empty($user)) {
            $userdata = $this->session->userdata('user');
        } else {
            $userdata          = $user;
            $userdata['email'] = $userdata['email_address'];
        }

        $counties = ['Alameda', 'Alpine', 'Amador', 'Butte', 'Calaveras', 'Colusa', 'Contra Costa', 'Del Norte', 'El Dorado', 'Fresno', 'Glenn', 'Humboldt', 'Imperial', 'Inyo', 'Kern', 'Kings', 'Lake', 'Lassen', 'Los Angeles', 'Madera', 'Marin', 'Mariposa', 'Mendocino', 'Merced', 'Modoc', 'Mono', 'Monterey', 'Napa', 'Nevada', 'Orange', 'Placer', 'Plumas', 'Riverside', 'Sacramento', 'San Benito', 'San Bernardino', 'San Diego', 'San Francisco', 'San Joaquin', 'San Luis', 'San Mateo', 'Santa Barbara', 'Santa Clara', 'Santa Cruz', 'Shasta', 'Sierra', 'Siskiyou', 'Solano', 'Sonoma', 'Stanislaus', 'Sutter', 'Tehama', 'Trinity', 'Tulare', 'Tuolumne', 'Ventura', 'Yolo', 'Yuba'];

        $endPoint = 'types/products';

        if (isset($counties) && !empty($counties)) {
            $insertCount = $updateCount = $rowCount = $notAddCount = 0;
            foreach ($counties as $k => $v) {
                $requestParams = json_encode(['State' => 'CA', 'County' => $v]);

                $logid  = $this->apiLogs->syncLogs($userdata['id'], 'resware', 'get_product_types', env('RESWARE_ORDER_API') . $endPoint, $requestParams, [], 0, 0);
                $result = $this->make_request('GET', $endPoint, $requestParams, $userdata);

                $this->apiLogs->syncLogs($userdata['id'], 'resware', 'get_product_types', env('RESWARE_ORDER_API') . $endPoint, [], $result, 0, $logid);
                $response = json_decode($result, true);

                if (isset($response) && !empty($response)) {
                    foreach ($response as $key => $value) {
                        $rowCount++;
                        // $display_name = '';
                        $status = 0;
                        /*if((isset($value['ProductTypeID']) && $value['ProductTypeID'] == 19) && (isset($value['TransactionTypeID']) && $value['TransactionTypeID'] == 3))
                        {
                        $display_name = 'Loan: Refinance';
                        $status = 1;
                        }
                        elseif((isset($value['ProductTypeID']) && $value['ProductTypeID'] == 20) && (isset($value['TransactionTypeID']) && $value['TransactionTypeID'] == 3))
                        {
                        $display_name = 'Sales: Purchase';
                        $status = 1;
                        }*/

                        if (isset($value['TransactionTypeID']) && $value['TransactionTypeID'] == 3) {
                            $status = 1;
                        }

                        $data = [
                            'transaction_type'    => trim($value['TransactionType']),
                            'transaction_type_id' => trim($value['TransactionTypeID']),
                            'product_type'        => trim($value['ProductType']),
                            'product_type_id'     => trim($value['ProductTypeID']),
                            'county'              => trim($v),
                            'state'               => 'CA',
                            'product_type_id'     => trim($value['ProductTypeID']),
                            // 'display_name' => $display_name,
                            'status'              => $status,
                        ];

                        $con = [
                            'where'      => [
                                'transaction_type_id' => $value['TransactionTypeID'],
                                'product_type_id'     => $value['ProductTypeID'],
                                'county'              => $v,
                                'state'               => 'CA',
                                'status'              => $status,
                            ],
                            'returnType' => 'count',
                        ];
                        $prevCount = $this->productType->getProductTypes($con);
                        if ($prevCount > 0) {
                            $condition = [
                                'transaction_type_id' => $value['TransactionTypeID'],
                                'product_type_id'     => $value['ProductTypeID'],
                            ];

                            $update = $this->productType->update($data, $condition);
                            if ($update) {
                                $updateCount++;
                            }
                        } else {
                            $insert = $this->productType->insert($data);
                            if ($insert) {
                                $insertCount++;
                            }
                        }
                        $notAddCount = ($rowCount - ($insertCount + $updateCount));
                        $successMsg  = 'Product types imported successfully. Total Rows (' . $rowCount . ') | Inserted (' . $insertCount . ') | Updated (' . $updateCount . ') | Not Inserted (' . $notAddCount . ')';
                    }
                }
            }
        }

        echo $successMsg;
    }

    public function check_update_password()
    {
        ini_set('max_execution_time', 0);
        ini_set('memory_limit', '2048M');
        $userdata = $this->session->userdata('admin');
        $this->load->library('order/order');
        if ($this->input->post('new_users') == 1) {
            $condition = [
                'where' => [
                    'status'      => 1,
                    'is_master'   => 0,
                    'is_new_user' => 1,
                ],
            ];
        } else {
            $condition = [
                'where' => [
                    'status'    => 1,
                    'is_master' => 0,
                ],
            ];
        }

        $customer_lists = $this->home_model->get_customers($condition);
        $insertCount    = $updateCount    = $rowCount    = $notUpdatePasswordCount    = 0;

        if (isset($customer_lists) && !empty($customer_lists)) {

            foreach (array_chunk($customer_lists, 50) as $key => $value) {

                if (isset($value) && !empty($value)) {

                    foreach ($value as $k => $v) {
                        $userdata          = $v;
                        $userdata['email'] = $v['email_address'];
                        $condition         = [
                            'id' => $userdata['id'],
                        ];

                        if (!empty($v['random_password']) && $v['is_sales_rep'] == 0 && $v['is_title_officer'] == 0) {
                            $logid  = $this->apiLogs->syncLogs($userdata['id'], 'resware', 'password_check', env('RESWARE_ORDER_API') . 'me', [], [], 0, 0);
                            $result = $this->make_request('GET', 'me', '', $userdata);
                            $this->apiLogs->syncLogs($userdata['id'], 'resware', 'password_check', env('RESWARE_ORDER_API') . 'me', [], $result, 0, $logid);

                            if (isset($result) && !empty($result)) {
                                $response = json_decode($result, true);

                                if (isset($response['Me']) && !empty($response['Me'])) {
                                    $customerData = [
                                        'is_password_updated' => 1,
                                        'resware_error_msg'   => null,
                                    ];
                                    $update = $this->home_model->update($customerData, $condition, 'customer_basic_details');
                                    /** Save user Activity */
                                    $activity = 'From Cron - check_update_password : Password updated status 1 for :- ' . $v['email_address'];
                                    $this->order->logAdminActivity($activity);
                                    /** End Save user activity */
                                    if ($update) {
                                        $updateCount++;
                                    }
                                } else {
                                    if ($v['is_sales_rep'] == 0 && $v['is_title_officer'] == 0) {
                                        $customerData = [
                                            'is_password_updated' => 0,
                                        ];
                                        $update = $this->home_model->update($customerData, $condition, 'customer_basic_details');
                                        /** Save user Activity */
                                        $activity = 'From Cron - check_update_password : Password updated status 0 for :- ' . $v['email_address'];
                                        $this->order->logAdminActivity($activity);
                                        /** End Save user activity */
                                        $notUpdatePasswordCount++;
                                    }
                                }
                            } else {
                                if ($v['is_sales_rep'] == 0 && $v['is_title_officer'] == 0) {
                                    $customerData = [
                                        'is_password_updated' => 0,
                                    ];
                                    $update = $this->home_model->update($customerData, $condition, 'customer_basic_details');
                                    /** Save user Activity */
                                    $activity = 'From Cron - check_update_password : Password updated status 0 for :- ' . $v['email_address'];
                                    $this->order->logAdminActivity($activity);
                                    /** End Save user activity */
                                    $notUpdatePasswordCount++;
                                }
                            }
                        } else {
                            if ($v['is_sales_rep'] == 0 && $v['is_title_officer'] == 0) {
                                $customerData = [
                                    'is_password_updated' => 0,
                                ];
                                $update = $this->home_model->update($customerData, $condition, 'customer_basic_details');
                                /** Save user Activity */
                                $activity = 'From Cron - check_update_password : Password updated status 0 for :- ' . $v['email_address'];
                                $this->order->logAdminActivity($activity);
                                /** End Save user activity */
                                $notUpdatePasswordCount++;
                            }
                        }
                    }
                    $successMsg = 'Password updated successfully. Total Rows (' . $rowCount . ') | Updated (' . $updateCount . ') | NotUpdated (' . $notUpdatePasswordCount . ')';
                }
            }
            $data = ['status' => 'success', 'msg' => $successMsg];
            echo json_encode($data);
        } else {
            $data = ['status' => 'success', 'msg' => 'No records found for credential check.'];
            echo json_encode($data);
        }
    }

    public function update_user_details()
    {
        ini_set('max_execution_time', 0);
        ini_set('memory_limit', '2048M');

        $condition = [
            'where' => [
                'status'    => 1,
                'is_master' => 0,
            ],
        ];

        $customer_lists = $this->home_model->get_customers($condition);

        $updateCount = $rowCount = $notAddCount = 0;
        if (isset($customer_lists) && !empty($customer_lists)) {

            foreach (array_chunk($customer_lists, 50) as $key => $value) {
                if (isset($value) && !empty($value)) {
                    foreach ($value as $k => $v) {
                        $rowCount++;
                        $userdata          = $v;
                        $userdata['email'] = $v['email_address'];
                        $logid             = $this->apiLogs->syncLogs($userdata['id'], 'resware', 'update_user_partner_id', env('RESWARE_ORDER_API') . 'me', $userdata, [], 0, 0);

                        $result = $this->make_request('GET', 'me?IncludeCompany=true', '', $userdata);

                        $this->apiLogs->syncLogs($userdata['id'], 'resware', 'validate_user', env('RESWARE_ORDER_API') . 'me', [], $result, 0, $logid);

                        if (isset($result) && !empty($result)) {
                            $response = json_decode($result, true);

                            if (isset($response['Me']) && !empty($response['Me'])) {
                                $condition = [
                                    'id' => $userdata['id'],
                                ];
                                $userId       = isset($response['Me']['UserID']) && !empty($response['Me']['UserID']) ? $response['Me']['UserID'] : '';
                                $partnerId    = isset($response['MyCompany']['PartnerID']) && !empty($response['MyCompany']['PartnerID']) ? $response['MyCompany']['PartnerID'] : '';
                                $customerData = [
                                    'resware_user_id' => $userId,
                                    'partner_id'      => $partnerId,
                                ];

                                $update = $this->home_model->update($customerData, $condition, 'customer_basic_details');
                                if ($update) {
                                    $updateCount++;
                                }
                                $successMsg = 'Password updated successfully. Total Rows (' . $rowCount . ') | Updated (' . $updateCount . ')';
                            }
                        }
                    }
                }

            }

            echo $successMsg;
        }
    }

    public function updatePassword()
    {
        ini_set('max_execution_time', 0);
        ini_set('memory_limit', '2048M');
        $this->load->library('order/order');
        $userdata  = $this->session->userdata('admin');
        $condition = [
            'where' => [
                'status'              => 1,
                'is_master'           => 0,
                'is_password_updated' => 0,
            ],
        ];
        $customer_lists      = $this->home_model->get_customers($condition);
        $updatePasswordCount = $notUpdatePasswordCount = 0;

        if (isset($customer_lists) && !empty($customer_lists)) {

            foreach (array_chunk($customer_lists, 50) as $key => $value) {

                if (isset($value) && !empty($value)) {

                    foreach ($value as $k => $v) {

                        if (!empty($v['resware_user_id']) && !empty($v['partner_id']) && !empty($v['email_address'])) {
                            $endPoint       = 'admin/partners/' . $v['partner_id'] . '/employees/' . $v['resware_user_id'];
                            $userUpdateData = [
                                'Password'               => 'Pacific1',
                                'Enabled'                => true,
                                'Roles'                  => [
                                    0  => [
                                        'RoleID' => 5033,
                                        'Name'   => 'Web Services: Access All Files for ResWare-to-ResWare Services',
                                    ],
                                    1  => [
                                        'RoleID' => 6013,
                                        'Name'   => 'Web Services: Add Actions',
                                    ],
                                    2  => [
                                        'RoleID' => 6005,
                                        'Name'   => 'Web Services: Add Documents',
                                    ],
                                    3  => [
                                        'RoleID' => 6002,
                                        'Name'   => 'Web Services: Add Notes',
                                    ],
                                    4  => [
                                        'RoleID' => 6009,
                                        'Name'   => 'Web Services: Add Partners',
                                    ],
                                    5  => [
                                        'RoleID' => 6015,
                                        'Name'   => 'Web Services: Add WebURL Documents',
                                    ],
                                    6  => [
                                        'RoleID' => 5027,
                                        'Name'   => 'Web Services: Bypass Address Validation',
                                    ],
                                    7  => [
                                        'RoleID' => 6003,
                                        'Name'   => 'Web Services: Cancel Files',
                                    ],
                                    8  => [
                                        'RoleID' => 5023,
                                        'Name'   => 'Web Services: Estimate Costs as 2010 HUD',
                                    ],
                                    9  => [
                                        'RoleID' => 6016,
                                        'Name'   => 'Web Services: Expense Reports',
                                    ],
                                    10 => [
                                        'RoleID' => 6012,
                                        'Name'   => 'Web Services: Get Actions',
                                    ],
                                    11 => [
                                        'RoleID' => 6007,
                                        'Name'   => 'Web Services: Get Custom Fields',
                                    ],
                                    12 => [
                                        'RoleID' => 6006,
                                        'Name'   => 'Web Services: Get Documents',
                                    ],
                                    13 => [
                                        'RoleID' => 6001,
                                        'Name'   => 'Web Services: Get Notes',
                                    ],
                                    14 => [
                                        'RoleID' => 6010,
                                        'Name'   => 'Web Services: Get Partners',
                                    ],
                                    15 => [
                                        'RoleID' => 69,
                                        'Name'   => 'Web Services: Order Placement',
                                    ],
                                    16 => [
                                        'RoleID' => 6004,
                                        'Name'   => 'Web Services: Override Property Address Validation and Reformatting',
                                    ],
                                    17 => [
                                        'RoleID' => 6011,
                                        'Name'   => 'Web Services: Remove Partners',
                                    ],
                                    18 => [
                                        'RoleID' => 6014,
                                        'Name'   => 'Web Services: Search Files',
                                    ],
                                    19 => [
                                        'RoleID' => 6019,
                                        'Name'   => 'Web Services: Update Partner',
                                    ],
                                    20 => [
                                        'RoleID' => 6008,
                                        'Name'   => 'Web Services: Write Custom Fields',
                                    ],
                                    21 => [
                                        'RoleID' => 51,
                                        'Name'   => 'Website',
                                    ],
                                ],
                                'WebsiteAccess'          => true,
                                'Name'                   => $v['email_address'],
                                'PasswordExpirationDate' => '/Date(3025656585000-0000)/',
                                'FirstName'              => $v['first_name'],
                                'LastName'               => $v['last_name'],
                                'ContactInformation'     => [
                                    'EmailAddress' => $v['email_address'],
                                ],
                            ];
                            $userdata['email'] = $userdata['email_address'];
                            $userUpdateData    = json_encode($userUpdateData);

                            $logid  = $this->apiLogs->syncLogs($v['id'], 'resware', 'update_password', env('RESWARE_ORDER_API') . $endPoint, $userUpdateData, [], 0, 0);
                            $result = $this->make_request('PUT', $endPoint, $userUpdateData, $userdata);
                            $this->apiLogs->syncLogs($v['id'], 'resware', 'update_password', env('RESWARE_ORDER_API') . $endPoint, $userUpdateData, $result, 0, $logid);
                            if (isset($result) && !empty($result)) {
                                $response = json_decode($result, true);

                                if (isset($response['Employee']) && !empty($response['Employee'])) {
                                    $random_password = $this->order->randomPassword();
                                    $condition       = [
                                        'id' => $v['id'],
                                    ];
                                    $customerData = [
                                        'is_password_updated' => 0,
                                        'random_password'     => $random_password,
                                        'password'            => md5('Pacific1'),
                                    ];
                                    $update = $this->home_model->update($customerData, $condition, 'customer_basic_details');

                                    if ($update) {
                                        $updatePasswordCount++;
                                    }
                                } else {
                                    $notUpdatePasswordCount++;
                                }
                            } else {
                                $notUpdatePasswordCount++;
                            }
                            $successMsg = 'Password updated successfully. Updated (' . $updatePasswordCount . ') | Not Updated (' . $notUpdatePasswordCount . ')';
                        }
                    }
                }
            }
            echo $successMsg;
        }
    }

    public function getCompanyInformation()
    {
        ini_set('max_execution_time', 0);
        ini_set('memory_limit', '2048M');
        $userdata = $this->session->userdata('admin');
        $this->db->select('company_name, partner_id');
        $this->db->group_by('company_name,partner_id');
        $customer_lists      = $this->db->get('customer_basic_details')->result_array();
        $insertedPartnerInfo = $updatedPartnerInfo = $notInsertedPartnerInfo = 0;

        if (isset($customer_lists) && !empty($customer_lists)) {
            foreach (array_chunk($customer_lists, 50) as $key => $value) {
                if (isset($value) && !empty($value)) {
                    foreach ($value as $k => $v) {
                        if (!empty($v['company_name']) && !empty($v['partner_id'])) {
                            $endPoint          = 'admin/partners/' . $v['partner_id'];
                            $userdata['email'] = $userdata['email_address'];
                            $logid             = $this->apiLogs->syncLogs($v['id'], 'resware', 'get_partner_information', env('RESWARE_ORDER_API') . $endPoint, [], [], 0, 0);
                            $result            = $this->make_request('GET', $endPoint, [], $userdata);
                            $this->apiLogs->syncLogs($v['id'], 'resware', 'get_partner_information', env('RESWARE_ORDER_API') . $endPoint, [], $result, 0, $logid);

                            if (isset($result) && !empty($result)) {
                                $response = json_decode($result, true);

                                if (isset($response['AdminPartner']) && !empty($response['AdminPartner'])) {

                                    $con = [
                                        'where'      => [
                                            'partner_id' => trim($response['AdminPartner']['PartnerCompanyID']),
                                        ],
                                        'returnType' => 'count',
                                    ];
                                    $prevCount = $this->home_model->get_company_rows($con);

                                    $partnerTyepIds = [];
                                    if (!empty($response['AdminPartner']['PartnerTypes'])) {
                                        foreach ($response['AdminPartner']['PartnerTypes'] as $partnerType) {
                                            $partnerTyepIds[] = $partnerType['PartnerTypeID'];
                                        }
                                    }

                                    if ($prevCount > 0) {
                                        $customerData = [
                                            'partner_name'    => trim($response['AdminPartner']['PartnerName']),
                                            'email'           => !empty($response['AdminPartner']['ContactInformation']['EmailAddress']) ? $response['AdminPartner']['ContactInformation']['EmailAddress'] : null,
                                            'address1'        => trim($response['AdminPartner']['MailingAddress']['Address1']),
                                            'city'            => trim($response['AdminPartner']['MailingAddress']['City']),
                                            'state'           => trim($response['AdminPartner']['MailingAddress']['State']),
                                            'zip'             => trim($response['AdminPartner']['MailingAddress']['Zip']),
                                            'partner_type_id' => implode(",", $partnerTyepIds),
                                        ];
                                        $condition = ['partner_id' => trim($response['AdminPartner']['PartnerCompanyID'])];
                                        $update    = $this->home_model->update($customerData, $condition, 'pct_order_partner_company_info');

                                        if ($update) {
                                            $updatedPartnerInfo++;
                                        }
                                    } else {
                                        $customerData = [
                                            'partner_id'      => trim($response['AdminPartner']['PartnerCompanyID']),
                                            'email'           => !empty($response['AdminPartner']['ContactInformation']['EmailAddress']) ? $response['AdminPartner']['ContactInformation']['EmailAddress'] : null,
                                            'partner_name'    => trim($response['AdminPartner']['PartnerName']),
                                            'address1'        => trim($response['AdminPartner']['MailingAddress']['Address1']),
                                            'city'            => trim($response['AdminPartner']['MailingAddress']['City']),
                                            'state'           => trim($response['AdminPartner']['MailingAddress']['State']),
                                            'zip'             => trim($response['AdminPartner']['MailingAddress']['Zip']),
                                            'partner_type_id' => implode(",", $partnerTyepIds),
                                        ];
                                        $insert = $this->home_model->insert($customerData, 'pct_order_partner_company_info');

                                        if ($insert) {
                                            $insertedPartnerInfo++;
                                        }
                                    }
                                } else {
                                    $notInsertedPartnerInfo++;
                                }
                            } else {
                                $notInsertedPartnerInfo++;
                            }
                            $successMsg = 'Partner Information updated successfully. Inserted (' . $insertedPartnerInfo . ') | Updated (' . $updatedPartnerInfo . ') | Not Inserted (' . $notInsertedPartnerInfo . ')';
                        }
                    }
                }
            }
        }

        $agents_lists = $this->db->get('agents')->result_array();
        if (isset($agents_lists) && !empty($agents_lists)) {
            foreach (array_chunk($agents_lists, 50) as $key => $value) {
                if (isset($value) && !empty($value)) {
                    foreach ($value as $k => $v) {
                        if (!empty($v['company']) && !empty($v['partner_id'])) {
                            $endPoint          = 'admin/partners/' . $v['partner_id'];
                            $userdata['email'] = $userdata['email_address'];
                            $logid             = $this->apiLogs->syncLogs($v['id'], 'resware', 'get_partner_information', env('RESWARE_ORDER_API') . $endPoint, [], [], 0, 0);
                            $result            = $this->make_request('GET', $endPoint, [], $userdata);
                            $this->apiLogs->syncLogs($v['id'], 'resware', 'get_partner_information', env('RESWARE_ORDER_API') . $endPoint, [], $result, 0, $logid);

                            if (isset($result) && !empty($result)) {
                                $response = json_decode($result, true);
                                if (isset($response['AdminPartner']) && !empty($response['AdminPartner'])) {
                                    $con = [
                                        'where'      => [
                                            'partner_id' => trim($response['AdminPartner']['PartnerCompanyID']),
                                        ],
                                        'returnType' => 'count',
                                    ];
                                    $prevCount = $this->home_model->get_company_rows($con);

                                    $partnerTyepIds = [];
                                    if (!empty($response['AdminPartner']['PartnerTypes'])) {
                                        foreach ($response['AdminPartner']['PartnerTypes'] as $partnerType) {
                                            $partnerTyepIds[] = $partnerType['PartnerTypeID'];
                                        }
                                    }

                                    if ($prevCount > 0) {
                                        $customerData = [
                                            'partner_name'    => trim($response['AdminPartner']['PartnerName']),
                                            'email'           => !empty($response['AdminPartner']['ContactInformation']['EmailAddress']) ? $response['AdminPartner']['ContactInformation']['EmailAddress'] : null,
                                            'address1'        => trim($response['AdminPartner']['MailingAddress']['Address1']),
                                            'city'            => trim($response['AdminPartner']['MailingAddress']['City']),
                                            'state'           => trim($response['AdminPartner']['MailingAddress']['State']),
                                            'zip'             => trim($response['AdminPartner']['MailingAddress']['Zip']),
                                            'partner_type_id' => implode(",", $partnerTyepIds),
                                        ];
                                        $condition = ['partner_id' => trim($response['AdminPartner']['PartnerCompanyID'])];
                                        $update    = $this->home_model->update($customerData, $condition, 'pct_order_partner_company_info');

                                        if ($update) {
                                            $updatedPartnerInfo++;
                                        }
                                    } else {
                                        $customerData = [
                                            'partner_id'      => trim($response['AdminPartner']['PartnerCompanyID']),
                                            'email'           => !empty($response['AdminPartner']['ContactInformation']['EmailAddress']) ? $response['AdminPartner']['ContactInformation']['EmailAddress'] : null,
                                            'partner_name'    => trim($response['AdminPartner']['PartnerName']),
                                            'address1'        => trim($response['AdminPartner']['MailingAddress']['Address1']),
                                            'city'            => trim($response['AdminPartner']['MailingAddress']['City']),
                                            'state'           => trim($response['AdminPartner']['MailingAddress']['State']),
                                            'zip'             => trim($response['AdminPartner']['MailingAddress']['Zip']),
                                            'partner_type_id' => implode(",", $partnerTyepIds),
                                        ];
                                        $insert = $this->home_model->insert($customerData, 'pct_order_partner_company_info');

                                        if ($insert) {
                                            $insertedPartnerInfo++;
                                        }
                                    }
                                } else {
                                    $notInsertedPartnerInfo++;
                                }
                            } else {
                                $notInsertedPartnerInfo++;
                            }
                            $successMsg = 'Partner Information updated successfully. Inserted (' . $insertedPartnerInfo . ') | Updated (' . $updatedPartnerInfo . ') | Not Inserted (' . $notInsertedPartnerInfo . ')';
                        }
                    }
                }
            }
            $data = ['status' => 'success', 'msg' => $successMsg];
            echo json_encode($data);exit;
        }
    }

    public function updateRemoteFileNumberForAllOrders()
    {
        $condition = [
            'where' => [
                'status'    => 1,
                'is_master' => 0,
            ],
        ];
        $customers = $this->home_model->get_customers($condition);
        $this->db->select('*');
        $this->db->from('order_details');
        $this->db->where('is_imported', 0);
        $query        = $this->db->get();
        $orderDetails = $query->result_array();

        if (!empty($orderDetails)) {
            foreach ($orderDetails as $orderDetail) {
                $key                  = array_search($orderDetail['customer_id'], array_column($customers, 'id'));
                $userdata['email']    = 'admin@pct24.com';
                $remoteFileNumberData = json_encode(['RemoteFileNumber' => $orderDetail['file_number']]);
                $remoteFileEndPoint   = 'files/' . $orderDetail['file_id'] . '/partners/' . $customers[$key]['partner_id'];
                $logid                = $this->apiLogs->syncLogs($orderDetail['customer_id'], 'resware', 'remote_file_number', env('RESWARE_ORDER_API') . $remoteFileEndPoint, $remoteFileNumberData, [], 0, 0);
                $resultRemotePartner  = $this->make_request('PUT', $remoteFileEndPoint, $remoteFileNumberData, $userdata);
                $this->apiLogs->syncLogs($orderDetail['customer_id'], 'resware', 'remote_file_number', env('RESWARE_ORDER_API') . $remoteFileEndPoint, $remoteFileNumberData, $resultRemotePartner, 0, $logid);

            }
            echo "Updated remote file number for all orders";exit;
        } else {
            echo "No orders found to update remote file number";exit;
        }
    }

    public function import_all_sales_rep_orders()
    {
        // $order_status = $this->uri->segment(2);

        $condition = [
            'where' => [
                'status'       => 1,
                'is_sales_rep' => 1,
            ],
        ];

        $customer_lists = $this->home_model->get_customers($condition);

        if (isset($customer_lists) && !empty($customer_lists)) {
            foreach ($customer_lists as $key => $salesRep) {
                $this->import_sales_rep_orders($salesRep);
            }
        }

    }

    public function import_sales_rep_orders($salesRep = [])
    {
        // $order_status = $this->uri->segment(2);
        $order_status = ['open', 'closed'];

        ini_set('max_execution_time', 0);
        ini_set('memory_limit', '2048M');

        $this->load->library('order/resware');
        $this->load->model('order/apiLogs');

        if (empty($salesRep)) {
            $userdata = $this->session->userdata('user');

        } else {
            $userdata          = $salesRep;
            $userdata['email'] = $userdata['email_address'];
        }

        if (isset($userdata) && !empty($userdata)) {
            /* Fetch records from resware */
            foreach ($order_status as $key => $value) {
                $status = [];
                if ($value == 'closed') {
                    $status['Statuses'][] = ['StatusID' => 9, 'Name' => 'Closed'];
                } else {
                    $status['Statuses'][] = ['StatusID' => 2, 'Name' => 'Open'];
                }

                $logid = $this->apiLogs->syncLogs($userdata['id'], 'resware', 'get_sales_rep_orders', env('RESWARE_ORDER_API') . 'files/search', json_encode($status), [], 0, 0);

                $res = $this->make_request('POST', 'files/search', json_encode($status), $userdata);

                $this->apiLogs->syncLogs($userdata['id'], 'resware', 'get_sales_rep_orders', env('RESWARE_ORDER_API') . 'files/search', json_encode($status), $res, 0, $logid);

                $result = json_decode($res, true);

                if (isset($result['Files']) && !empty($result['Files'])) {
                    $this->db->simple_query('SET SESSION group_concat_max_len=150000');
                    $this->db->select('GROUP_CONCAT(file_id) as file_ids');
                    $this->db->from('order_details');
                    $this->db->where('transaction_details.sales_representative', $userdata['id']);
                    $this->db->join('transaction_details', 'order_details.transaction_id = transaction_details.id', 'left');
                    $this->db->group_by('transaction_details.sales_representative');
                    $query = $this->db->get();

                    $filesResult = $query->row_array();

                    if (!empty($filesResult)) {
                        $file_ids = explode(',', $filesResult['file_ids']);
                    } else {
                        $syncFlag = 0;
                    }
                    foreach ($result['Files'] as $res) {
                        if (!empty($file_ids)) {
                            if (in_array((int) $res['FileID'], $file_ids)) {
                                $syncFlag = 1;
                            } else {
                                $syncFlag = 0;
                            }
                        }

                        if ($syncFlag == 0) {
                            $FullProperty = $res['Properties'][0]['StreetNumber'] . " " . $res['Properties'][0]['StreetDirection'] . " " . $res['Properties'][0]['StreetName'] . " " . $res['Properties'][0]['StreetSuffix'] . ", " . $res['Properties'][0]['City'] . ", " . $res['Properties'][0]['State'] . ", " . $res['Properties'][0]['Zip'];
                            $address      = $res['Properties'][0]['StreetNumber'] . " " . $res['Properties'][0]['StreetDirection'] . " " . $res['Properties'][0]['StreetName'] . " " . $res['Properties'][0]['StreetSuffix'];

                            /* get blackkight data */
                            $locale = $res['Properties'][0]['City'];

                            if (($locale)) {
                                if (!empty($res['Properties'][0]['State'])) {
                                    $locale .= ', ' . $res['Properties'][0]['State'];
                                } else {
                                    $locale .= ', CA';
                                }
                            }

                            $property_details = $this->getSearchResult($address, $locale);

                            $property_type    = isset($property_details['property_type']) && !empty($property_details['property_type']) ? $property_details['property_type'] : '';
                            $LegalDescription = isset($property_details['legaldescription']) && !empty($property_details['legaldescription']) ? $property_details['legaldescription'] : '';
                            $apn              = isset($property_details['apn']) && !empty($property_details['apn']) ? $property_details['apn'] : '';
                            /* get blackkight data */

                            $propertyData = [
                                'customer_id'       => 0,
                                'buyer_agent_id'    => 0,
                                'listing_agent_id'  => 0,
                                'escrow_lender_id'  => 0,
                                'parcel_id'         => $res['Properties'][0]['ParcelID'],
                                'address'           => removeMultipleSpace($address),
                                'city'              => $res['Properties'][0]['City'],
                                'state'             => $res['Properties'][0]['State'],
                                'zip'               => $res['Properties'][0]['Zip'],
                                'property_type'     => $property_type,
                                'full_address'      => removeMultipleSpace($FullProperty),
                                'apn'               => $apn,
                                'county'            => $res['Properties'][0]['County'],
                                'legal_description' => $LegalDescription,
                                /*'primary_owner' => $primary_owner,
                                'secondary_owner' => $SecondaryOwner,*/
                                // 'additional_details'=> '',
                                // 'is_imported'=> 1,
                                'status'            => 1,
                            ];

                            $transactionData = [
                                'customer_id'          => 0,
                                'sales_amount'         => !empty($res['SalesPrice']) ? $res['SalesPrice'] : 0,
                                'sales_representative' => $userdata['id'],
                                'loan_number'          => !empty($res['Loans'][0]['LoanNumber']) ? $res['Loans'][0]['LoanNumber'] : 0,
                                'loan_amount'          => !empty($res['Loans'][0]['LoanAmount']) ? $res['Loans'][0]['LoanAmount'] : 0,
                                'transaction_type'     => $res['TransactionProductType']['TransactionTypeID'],
                                'purchase_type'        => $res['TransactionProductType']['ProductTypeID'],
                                'status'               => 1,
                            ];

                            $primary_owner = isset($res['Buyers'][0]['Primary']['First']) && !empty($res['Buyers'][0]['Primary']['First']) ? $res['Buyers'][0]['Primary']['First'] : '';

                            $primary_owner .= isset($res['Buyers'][0]['Primary']['Middle']) && !empty($res['Buyers'][0]['Primary']['Middle']) ? " " . $res['Buyers'][0]['Primary']['Middle'] : '';
                            $primary_owner .= isset($res['Buyers'][0]['Primary']['Last']) && !empty($res['Buyers'][0]['Primary']['Last']) ? " " . $res['Buyers'][0]['Primary']['Last'] : '';

                            $secondary_owner = isset($res['Buyers'][0]['Secondary']['First']) && !empty($res['Buyers'][0]['Secondary']['First']) ? $res['Buyers'][0]['Secondary']['First'] : '';
                            $secondary_owner .= isset($res['Buyers'][0]['Secondary']['Middle']) && !empty($res['Buyers'][0]['Secondary']['Middle']) ? $res['Buyers'][0]['Secondary']['Middle'] : '';
                            $secondary_owner .= isset($res['Buyers'][0]['Secondary']['Last']) && !empty($res['Buyers'][0]['Secondary']['Last']) ? " " . $res['Buyers'][0]['Secondary']['Last'] : '';

                            $ProductTypeTxt = $res['TransactionProductType']['ProductType'];
                            if (strpos($ProductTypeTxt, 'Loan') !== false) {
                                $propertyData['primary_owner']   = $primary_owner;
                                $propertyData['secondary_owner'] = $secondary_owner;
                            } elseif (strpos($ProductTypeTxt, 'Sale') !== false) {
                                $transactionData['borrower']           = $primary_owner;
                                $transactionData['secondary_borrower'] = $secondary_owner;

                                $propertyData['primary_owner']   = isset($property_info['primary_owner']) && !empty($property_info['primary_owner']) ? $property_info['primary_owner'] : '';
                                $propertyData['secondary_owner'] = isset($property_info['secondary_owner']) && !empty($property_info['secondary_owner']) ? $property_info['secondary_owner'] : '';
                            }

                            $propertyId = $this->home_model->insert($propertyData, 'property_details');

                            $transactionId = $this->home_model->insert($transactionData, 'transaction_details');

                            $time = round((int) (str_replace("-0000)/", "", str_replace("/Date(", "", $res['Dates']['OpenedDate']))) / 1000);

                            $created_date = date('Y-m-d H:i:s', $time);

                            $orderData = [
                                'customer_id'        => 0,
                                'file_id'            => $res['FileID'],
                                'file_number'        => $res['FileNumber'],
                                'property_id'        => $propertyId,
                                'transaction_id'     => $transactionId,
                                'created_at'         => $created_date,
                                'status'             => 1,
                                'is_imported'        => 1,
                                'is_sales_rep_order' => 1,
                                'resware_status'     => strtolower($res['Status']['Name']),
                            ];

                            $orderId = $this->home_model->insert($orderData, 'order_details');

                            /* TP call */
                            $random_number = time() + (floor(rand() * (10000 - 1 + 1)) + 1);

                            $propertyData['fipsCode'] = isset($property_details['fips']) && !empty($property_details['fips']) ? $property_details['fips'] : '';

                            $propertyData['address'] = $address;

                            $propertyData['city'] = isset($res['Properties'][0]['City']) && !empty($res['Properties'][0]['City']) ? $res['Properties'][0]['City'] : '';

                            $propertyData['unit_no'] = isset($property_details['unit_no']) && !empty($property_details['unit_no']) ? $property_details['unit_no'] : '';
                            $propertyData['apn']     = $apn;

                            $propertyData['state']  = isset($res['Properties'][0]['State']) && !empty($res['Properties'][0]['State']) ? $res['Properties'][0]['State'] : '';
                            $propertyData['county'] = isset($res['Properties'][0]['County']) && !empty($res['Properties'][0]['County']) ? $res['Properties'][0]['County'] : '';

                            $this->tpCreateService(4, $random_number, $propertyData, $userdata);

                            $this->tpCreateService(3, $random_number, $propertyData, $userdata);

                            $session_id = 'tp_api_id_' . $random_number;

                            $tp_condition = [
                                'session_id' => $session_id,
                            ];

                            $tpData = [
                                'file_id'     => $res['FileID'],
                                'file_number' => $res['FileNumber'],
                            ];

                            $this->titlePointData->update($tpData, $tp_condition);

                            $titlePointDetails = $this->titlePointData->gettitlePointDetails($tp_condition);

                            $serviceId = isset($titlePointDetails['cs4_service_id']) && !empty($titlePointDetails['cs4_service_id']) ? $titlePointDetails['cs4_service_id'] : '';
                            $this->titlepoint->generateImg($serviceId, $res['FileNumber'], $orderId);
                            $instrumentNumber = isset($titlePointDetails['cs4_instrument_no']) && !empty($titlePointDetails['cs4_instrument_no']) ? $titlePointDetails['cs4_instrument_no'] : '';

                            $recordedDate = isset($titlePointDetails['cs4_recorded_date']) && !empty($titlePointDetails['cs4_recorded_date']) ? $titlePointDetails['cs4_recorded_date'] : '';
                            $fips         = isset($titlePointDetails['fips']) && !empty($titlePointDetails['fips']) ? $titlePointDetails['fips'] : '';

                            $this->titlepoint->generateGrantDeed($instrumentNumber, $recordedDate, $fips, $res['FileNumber'], $orderId);

                            $tax_serviceId = isset($titlePointDetails['cs3_service_id']) && !empty($titlePointDetails['cs3_service_id']) ? $titlePointDetails['cs3_service_id'] : '';

                            $this->titlepoint->generateTaxDoc($tax_serviceId, $res['FileNumber'], $orderId);

                            /* TP call */
                        } else if ($syncFlag == 1) {
                            $orderData = [
                                'resware_status' => strtolower($res['Status']['Name']),
                            ];
                            $condition = [
                                'file_id'     => $res['FileID'],
                                'file_number' => $res['FileNumber'],
                            ];

                            $orderId = $this->home_model->update($orderData, $condition, 'order_details');
                        }
                    }
                    // echo "All orders with status ".$value." synced successfully for user: ".$userdata['email']."<br>";
                    $response[$value] = ['status' => 'success', 'msg' => "All orders with status " . $value . " synced successfully for user: " . $userdata['email'] . "<br>"];
                } else {
                    // echo "No orders found for user: ".$userdata['email']."<br>";
                    $response[$value] = ['status' => 'error', 'msg' => "No orders found with status " . $value . " for user: " . $userdata['email'] . "<br>"];
                }
            }

            echo json_encode($response);
            /* Fetch records from resware */
        }
    }

    public function tpCreateService($methodId, $random_number, $propertyData = [], $userdata = [])
    {
        /* Insert into table */
        if ($random_number) {
            $session_id = 'tp_api_id_' . $random_number;

            $con = [
                'where'      => [
                    'session_id' => $session_id,
                ],
                'returnType' => 'count',
            ];

            $prevCount = $this->titlePointData->gettitlePointDetails($con);
            if ($prevCount < 0) {
                $tpData = [
                    'session_id' => $session_id,
                ];
                $tpId = $this->titlePointData->insert($tpData);
            }

        }
        /* Insert into table */

        $requestParams = [
            'userID'         => env('TP_USERNAME'),
            'password'       => env('TP_PASSWORD'),
            'orderNo'        => '',
            'customerRef'    => '',
            'company'        => '',
            'department'     => '',
            'titleOfficer'   => '',
            'orderComment'   => '',
            'starterRemarks' => '',
        ];

        if ($methodId == 4) {
            $fipsCode = isset($propertyData['fipsCode']) && !empty($propertyData['fipsCode']) ? $propertyData['fipsCode'] : '';
            $address  = isset($propertyData['address']) && !empty($propertyData['address']) ? $propertyData['address'] : '';
            $city     = isset($propertyData['city']) && !empty($propertyData['city']) ? $propertyData['city'] : '';
            $unit_no  = isset($propertyData['unit_no']) && !empty($propertyData['unit_no']) ? $propertyData['unit_no'] : '';
            $apn      = isset($propertyData['apn']) && !empty($propertyData['apn']) ? $propertyData['apn'] : '';
            if ($unit_no) {
                $unitinfo = 'UnitNumber ' . $unit_no . ', ';
            }

            $requestParams['serviceType'] = env('SERVICE_TYPE');

            $requestParams['parameters'] = 'Address1=' . $address . ';City=' . $city . ';Pin=' . $apn . ';LvLookup=Address;LvLookupValue=' . $address . ', ' . $unitinfo . $city . ';LvReportFormat=LV;IncludeTaxAssessor=true';
            $requestParams['fipsCode']   = $fipsCode;
            $requestUrl                  = env('TP_CREATE_SERVICE_ENDPOINT');
            $request_type                = 'sales_create_service_4';
        } else if ($methodId == 3) {
            $apn = isset($propertyData['apn']) && !empty($propertyData['apn']) ? $propertyData['apn'] : '';
            $apn = str_replace('0000', '0-000', $apn);

            $state = isset($propertyData['state']) && !empty($propertyData['state']) ? $propertyData['state'] : '';

            $county = isset($propertyData['county']) && !empty($propertyData['county']) ? $propertyData['county'] : '';

            $requestParams['serviceType'] = env('TAX_SEARCH_SERVICE_TYPE');

            $requestParams['parameters'] = 'Tax.APN=' . $apn . ';General.AutoSearchTaxes=true;General.AutoSearchProperty=false';
            $requestParams['state']      = $state;
            $requestParams['county']     = $county;
            $requestUrl                  = env('TP_TAX_INSTRUMENT_CREATE_SERVICE_ENDPOINT');
            $request_type                = 'sales_create_service_3';
        }
        $request = $requestUrl . http_build_query($requestParams);

        $logid = $this->apiLogs->syncLogs(0, 'titlepoint', $request_type, $request, $requestParams, [], $random_number, 0);

        $opts = [
            "ssl" => [
                "verify_peer"      => false,
                "verify_peer_name" => false,
            ],
        ];

        $context = stream_context_create($opts);
        $file    = file_get_contents($request, false, $context);

        $xmlData  = simplexml_load_string($file);
        $response = json_encode($xmlData);
        $result   = json_decode($response, true);

        $this->apiLogs->syncLogs(0, 'titlepoint', $request_type, $request, $requestParams, $result, $random_number, $logid);
        $session_id = 'tp_api_id_' . $random_number;
        $con        = [
            'where'      => [
                'session_id' => $session_id,
            ],
            'returnType' => 'count',
        ];
        $prevCount = $this->titlePointData->gettitlePointDetails($con);

        if (isset($result) && empty($result)) {
            $tpData = [
                'cs4_message' => 'Failed',
            ];

            if ($prevCount > 0) {
                $session_id = 'tp_api_id_' . $random_number;
                $condition  = [
                    'session_id' => $session_id,
                ];
                $this->titlePointData->update($tpData, $condition);
            } else {
                $tpData['session_id'] = 'tp_api_id_' . $random_number;

                $tpId = $this->titlePointData->insert($tpData);
            }
        } else {

            $responseStatus = isset($result['ReturnStatus']) && !empty($result['ReturnStatus']) ? $result['ReturnStatus'] : '';

            if ($methodId == 4) {
                if ($responseStatus == 'Success') {
                    $requestId = isset($result['RequestID']) && !empty($result['RequestID']) ? $result['RequestID'] : '';
                    $tpData    = [
                        'cs4_request_id' => $requestId,
                    ];

                    if ($prevCount > 0) {
                        $condition = [
                            'session_id' => $session_id,
                        ];
                        $this->titlePointData->update($tpData, $condition);
                    } else {
                        $tpData['session_id'] = 'tp_api_id_' . $random_number;

                        $tpId = $this->titlePointData->insert($tpData);
                    }

                    /* Get Request Summary */
                    $response = $this->tpGetRequestSummaries(4, $requestId, $random_number);
                    /* Get Request Summary */
                } else {
                    $error = isset($result['ReturnErrors']['ReturnError']['ErrorDescription']) && !empty($result['ReturnErrors']['ReturnError']['ErrorDescription']) ? $result['ReturnErrors']['ReturnError']['ErrorDescription'] : '';
                    $this->addLogs($methodId, $responseStatus, '', $error, $random_number);
                }

            }
            if ($methodId == 3) {
                if ($responseStatus == 'Success') {
                    $requestId = isset($result['RequestID']) && !empty($result['RequestID']) ? $result['RequestID'] : '';

                    $tpData = [
                        'cs3_request_id' => $requestId,
                    ];

                    if ($prevCount > 0) {
                        $condition = [
                            'session_id' => $session_id,
                        ];
                        $this->titlePointData->update($tpData, $condition);
                    } else {
                        $tpData['session_id'] = 'tp_api_id_' . $random_number;

                        $tpId = $this->titlePointData->insert($tpData);
                    }

                    /* Get Request Summary */
                    $response = $this->tpGetRequestSummaries(3, $requestId, $random_number);
                    /* Get Request Summary */
                } else {
                    $error = isset($result['ReturnErrors']['ReturnError']['ErrorDescription']) && !empty($result['ReturnErrors']['ReturnError']['ErrorDescription']) ? $result['ReturnErrors']['ReturnError']['ErrorDescription'] : '';
                    $this->addLogs($methodId, $responseStatus, '', $error, $random_number);
                }
            }
        }
    }

    public function addLogs($methodId, $returnStatus, $status = '', $error, $random_number)
    {
        if ($returnStatus == 'Failed') {
            if ($methodId == 4) {
                $tpData = [
                    'cs4_message' => $error,
                ];
            } elseif ($methodId == 3) {
                $tpData = [
                    'cs3_message' => $error,
                ];
            }

        } else {
            if ($methodId == 4) {
                $tpData = [
                    'cs4_message' => $status,
                ];
            } elseif ($methodId == 3) {
                $tpData = [
                    'cs3_message' => $status,
                ];
            }
        }

        $session_id = 'tp_api_id_' . $random_number;
        $con        = [
            'where'      => [
                'session_id' => $session_id,
            ],
            'returnType' => 'count',
        ];
        $prevCount = $this->titlePointData->gettitlePointDetails($con);

        if ($prevCount > 0) {
            $condition = [
                'session_id' => $session_id,
            ];
            $this->titlePointData->update($tpData, $condition);
        } else {
            $tpData['session_id'] = 'tp_api_id_' . $random_number;

            $tpId = $this->titlePointData->insert($tpData);
        }

    }

    public function tpGetRequestSummaries($methodId, $requestId, $random_number)
    {
        $requestParams = [
            'userID'         => env('TP_USERNAME'),
            'password'       => env('TP_PASSWORD'),
            'company'        => '',
            'department'     => '',
            'titleOfficer'   => '',
            'requestId'      => $requestId,
            'maxWaitSeconds' => 20,
        ];

        $request = env('TP_REQUEST_SUMMARY_ENDPOINT') . http_build_query($requestParams);

        $logid = $this->apiLogs->syncLogs(0, 'titlepoint', 'get_request_summary_' . $methodId, $request, $requestParams, [], $random_number, 0);

        $opts = [
            "ssl" => [
                "verify_peer"      => false,
                "verify_peer_name" => false,
            ],
        ];
        $context  = stream_context_create($opts);
        $file     = file_get_contents($request, false, $context);
        $xmlData  = simplexml_load_string($file);
        $response = json_encode($xmlData);
        $result   = json_decode($response, true);

        $this->apiLogs->syncLogs(0, 'titlepoint', 'sales_get_request_summary_' . $methodId, $request, $requestParams, $result, $random_number, $logid);

        $session_id = 'tp_api_id_' . $random_number;

        $con = [
            'where'      => [
                'session_id' => $session_id,
            ],
            'returnType' => 'count',
        ];
        $prevCount = $this->titlePointData->gettitlePointDetails($con);

        if (isset($result) && empty($result)) {
            $tpData = [
                'cs4_message' => 'Failed',
            ];

            if ($prevCount > 0) {
                $condition = [
                    'session_id' => $session_id,
                ];
                $this->titlePointData->update($tpData, $condition);
            } else {
                $tpData['session_id'] = 'tp_api_id_' . $random_number;

                $tpId = $this->titlePointData->insert($tpData);
            }
        } else {
            $responseStatus = isset($result['ReturnStatus']) && !empty($result['ReturnStatus']) ? $result['ReturnStatus'] : '';

            $session_data = [];

            if ($methodId == 4) {
                if ($responseStatus == 'Success') {
                    $status = isset($result['RequestSummaries']['RequestSummary']['Status']) && !empty($result['RequestSummaries']['RequestSummary']['Status']) ? $result['RequestSummaries']['RequestSummary']['Status'] : '';

                    if ($status == 'Complete') {
                        $resultId  = isset($result['RequestSummaries']['RequestSummary']['Order']['Services']['Service']['ThumbNails']['ResultThumbNail'][0]['ID']) && !empty($result['RequestSummaries']['RequestSummary']['Order']['Services']['Service']['ThumbNails']['ResultThumbNail'][0]['ID']) ? $result['RequestSummaries']['RequestSummary']['Order']['Services']['Service']['ThumbNails']['ResultThumbNail'][0]['ID'] : '';
                        $serviceId = isset($result['RequestSummaries']['RequestSummary']['Order']['Services']['Service']['ID']) && !empty($result['RequestSummaries']['RequestSummary']['Order']['Services']['Service']['ID']) ? $result['RequestSummaries']['RequestSummary']['Order']['Services']['Service']['ID'] : '';

                        $tpData = [
                            'cs4_result_id'  => $resultId,
                            'cs4_service_id' => $serviceId,
                        ];
                    } else {
                        $tpData = [
                            'cs4_message' => $status,
                        ];
                    }

                    if ($prevCount > 0) {
                        $condition = [
                            'session_id' => $session_id,
                        ];
                        $this->titlePointData->update($tpData, $condition);
                    } else {
                        $tpData['session_id'] = 'tp_api_id_' . $random_number;

                        $tpId = $this->titlePointData->insert($tpData);
                    }

                    if ($status == 'Complete') {
                        $this->tpGetResultById(4, $resultId, $random_number);
                    }

                } else {
                    $error = isset($result['ReturnErrors']['ReturnError']['ErrorDescription']) && !empty($result['ReturnErrors']['ReturnError']['ErrorDescription']) ? $result['ReturnErrors']['ReturnError']['ErrorDescription'] : '';
                    $this->addLogs($methodId, $responseStatus, '', $error, $random_number);
                }
            }
            if ($methodId == 3) {
                if ($responseStatus == 'Success') {
                    $status = isset($result['RequestSummaries']['RequestSummary']['Status']) && !empty($result['RequestSummaries']['RequestSummary']['Status']) ? $result['RequestSummaries']['RequestSummary']['Status'] : '';

                    if ($status == 'Complete') {
                        $resultId  = isset($result['RequestSummaries']['RequestSummary']['Order']['Services']['Service']['ThumbNails']['ResultThumbNail']['ID']) && !empty($result['RequestSummaries']['RequestSummary']['Order']['Services']['Service']['ThumbNails']['ResultThumbNail']['ID']) ? $result['RequestSummaries']['RequestSummary']['Order']['Services']['Service']['ThumbNails']['ResultThumbNail']['ID'] : '';
                        $serviceId = isset($result['RequestSummaries']['RequestSummary']['Order']['Services']['Service']['ID']) && !empty($result['RequestSummaries']['RequestSummary']['Order']['Services']['Service']['ID']) ? $result['RequestSummaries']['RequestSummary']['Order']['Services']['Service']['ID'] : '';
                        $tpData    = [
                            'cs3_result_id'  => $resultId,
                            'cs3_service_id' => $serviceId,
                        ];
                    } else {
                        $tpData = [
                            'cs3_message' => $status,
                        ];
                    }

                    if ($prevCount > 0) {
                        $condition = [
                            'session_id' => $session_id,
                        ];
                        $this->titlePointData->update($tpData, $condition);
                    } else {
                        $tpData['session_id'] = 'tp_api_id_' . $random_number;

                        $tpId = $this->titlePointData->insert($tpData);
                    }
                    if ($status == 'Complete') {
                        $this->tpGetResultById(3, $resultId, $random_number);
                    }
                } else {
                    $error = isset($result['ReturnErrors']['ReturnError']['ErrorDescription']) && !empty($result['ReturnErrors']['ReturnError']['ErrorDescription']) ? $result['ReturnErrors']['ReturnError']['ErrorDescription'] : '';
                    $this->addLogs($methodId, $responseStatus, '', $error, $random_number);
                }
            }
        }
    }

    public function tpGetResultById($methodId, $resultId, $random_number)
    {
        $requestParams = [
            'userID'       => env('TP_USERNAME'),
            'password'     => env('TP_PASSWORD'),
            'company'      => '',
            'department'   => '',
            'titleOfficer' => '',
            'resultID'     => $resultId,
        ];

        $resultUrl = env('TP_GET_RESULT_BY_ID');

        if ($methodId == 3) {
            $requestParams['requestingTPXML'] = 'true';
            $resultUrl                        = env('TP_GET_RESULT_BY_ID_3');
        }

        $request = $resultUrl . http_build_query($requestParams);

        $logid = $this->apiLogs->syncLogs(0, 'titlepoint', 'sales_get_result_by_id_' . $methodId, $request, $requestParams, [], $random_number, 0);

        $opts = [
            "ssl" => [
                "verify_peer"      => false,
                "verify_peer_name" => false,
            ],
        ];
        $context = stream_context_create($opts);
        $file    = file_get_contents($request, false, $context);

        $xmlData  = simplexml_load_string($file);
        $response = json_encode($xmlData);
        $result   = json_decode($response, true);

        $this->apiLogs->syncLogs(0, 'titlepoint', 'sales_get_result_by_id_' . $methodId, $request, $requestParams, $result, $random_number, $logid);

        $session_id = 'tp_api_id_' . $random_number;

        $con = [
            'where'      => [
                'session_id' => $session_id,
            ],
            'returnType' => 'count',
        ];
        $prevCount = $this->titlePointData->gettitlePointDetails($con);

        if (isset($result) && empty($result)) {
            $tpData = [
                'cs4_message' => 'Failed',
            ];

            if ($prevCount > 0) {
                $condition = [
                    'session_id' => $session_id,
                ];
                $this->titlePointData->update($tpData, $condition);
            } else {
                $tpData['session_id'] = 'tp_api_id_' . $random_number;

                $tpId = $this->titlePointData->insert($tpData);
            }
        } else {
            $responseStatus = isset($result['ReturnStatus']) && !empty($result['ReturnStatus']) ? $result['ReturnStatus'] : '';
            $session_data   = [];

            if ($methodId == 4) {
                if ($responseStatus == 'Success') {
                    $briefLegal = isset($result['Result']['BriefLegal']) && !empty($result['Result']['BriefLegal']) ? $result['Result']['BriefLegal'] : '';

                    $vesting = isset($result['Result']['Vesting']) && !empty($result['Result']['Vesting']) ? $result['Result']['Vesting'] : '';

                    $fips = isset($result['Result']['Fips']) && !empty($result['Result']['Fips']) ? $result['Result']['Fips'] : '';

                    $legal_vesting_info = isset($result['Result']['LvDeeds']['LegalAndVesting2DeedInfo']) && !empty($result['Result']['LvDeeds']['LegalAndVesting2DeedInfo']) ? $result['Result']['LvDeeds']['LegalAndVesting2DeedInfo'] : [];

                    if (count($legal_vesting_info) == count($legal_vesting_info, COUNT_RECURSIVE)) {
                        $docType = isset($result['Result']['LvDeeds']['LegalAndVesting2DeedInfo']['DocType']) && !empty($result['Result']['LvDeeds']['LegalAndVesting2DeedInfo']['DocType']) ? $result['Result']['LvDeeds']['LegalAndVesting2DeedInfo']['DocType'] : '';
                        $docType = strtolower($docType);

                        if ($docType == 'grant deed' || $docType == 'intrafamily transfer & dissolution' || $docType == 'quit claim deed' || $docType == 'intra-family transfer or dissolution') {
                            $instrumentNumber = isset($result['Result']['LvDeeds']['LegalAndVesting2DeedInfo']['InstrumentNumber']) && !empty($result['Result']['LvDeeds']['LegalAndVesting2DeedInfo']['InstrumentNumber']) ? $result['Result']['LvDeeds']['LegalAndVesting2DeedInfo']['InstrumentNumber'] : '';
                            $recordedDate     = isset($result['Result']['LvDeeds']['LegalAndVesting2DeedInfo']['RecordedDate']) && !empty($result['Result']['LvDeeds']['LegalAndVesting2DeedInfo']['RecordedDate']) ? $result['Result']['LvDeeds']['LegalAndVesting2DeedInfo']['RecordedDate'] : '';
                        }

                    } else {
                        foreach ($legal_vesting_info as $key => $value) {
                            $docType = isset($value['DocType']) && !empty($value['DocType']) ? $value['DocType'] : '';
                            $docType = strtolower($docType);

                            if ($docType == 'grant deed' || $docType == 'intrafamily transfer & dissolution' || $docType == 'quit claim deed' || $docType == 'intra-family transfer or dissolution') {
                                $instrumentNumber = isset($value['InstrumentNumber']) && !empty($value['InstrumentNumber']) ? $value['InstrumentNumber'] : '';
                                $recordedDate     = isset($value['RecordedDate']) && !empty($value['RecordedDate']) ? $value['RecordedDate'] : '';
                                break;
                            }
                        }
                    }
                    $status = isset($result['Result']['Status']) && !empty($result['Result']['Status']) ? $result['Result']['Status'] : '';

                    $tpData = [
                        'legal_description'   => $briefLegal,
                        'vesting_information' => $vesting,
                        'cs4_instrument_no'   => $instrumentNumber,
                        'cs4_recorded_date'   => $recordedDate,
                        'grant_deed_type'     => $docType,
                        'fips'                => $fips,
                        // 'cs4_result_id_status' => $status,
                    ];

                    if ($prevCount > 0) {
                        $condition = [
                            'session_id' => $session_id,
                        ];
                        $this->titlePointData->update($tpData, $condition);
                    } else {
                        $tpData['session_id'] = 'tp_api_id_' . $random_number;

                        $tpId = $this->titlePointData->insert($tpData);

                    }
                    $this->addLogs($methodId, $responseStatus, $status, $error, $random_number);
                } else {
                    $error = isset($result['ReturnErrors']['ReturnError']['ErrorDescription']) && !empty($result['ReturnErrors']['ReturnError']['ErrorDescription']) ? $result['ReturnErrors']['ReturnError']['ErrorDescription'] : '';
                    $this->addLogs($methodId, $responseStatus, '', $error, $random_number);
                }
            }
            if ($methodId == 3) {
                if ($responseStatus == 'Success') {
                    $firstInstallment = $secondInstallment = [];
                    if (isset($result['Result']['TaxReport']['Installments']['Item'][0]) && !empty($result['Result']['TaxReport']['Installments']['Item'][0])) {
                        $firstInstallment = $result['Result']['TaxReport']['Installments']['Item'][0];
                    }

                    if (isset($result['Result']['TaxReport']['Installments']['Item'][1]) && !empty($result['Result']['TaxReport']['Installments']['Item'][1])) {
                        $secondInstallment = $result['Result']['TaxReport']['Installments']['Item'][1];
                    }

                    $status = isset($result['Result']['TaxReport']['Status']) && !empty($result['Result']['TaxReport']['Status']) ? $result['Result']['TaxReport']['Status'] : '';
                    if ($status == 'Success') {
                        $message = 'Success';
                    } else {
                        $message = isset($result['Result']['TaxReport']['WarningMessage']) && !empty($result['Result']['TaxReport']['WarningMessage']) ? $result['Result']['TaxReport']['WarningMessage'] : '';
                    }

                    $tpData = [
                        'first_installment'  => json_encode($firstInstallment),
                        'second_installment' => json_encode($secondInstallment),
                    ];

                    if ($prevCount > 0) {
                        $condition = [
                            'session_id' => $session_id,
                        ];
                        $this->titlePointData->update($tpData, $condition);
                    } else {
                        $tpData['session_id'] = 'tp_api_id_' . $random_number;

                        $tpId = $this->titlePointData->insert($tpData);
                    }
                    $this->addLogs($methodId, $responseStatus, $message, $error, $random_number);
                } else {
                    $error = isset($result['ReturnErrors']['ReturnError']['ErrorDescription']) && !empty($result['ReturnErrors']['ReturnError']['ErrorDescription']) ? $result['ReturnErrors']['ReturnError']['ErrorDescription'] : '';
                    $this->addLogs($methodId, $responseStatus, '', $error, $random_number);
                }
            }
        }
    }

    public function removeApiLogs()
    {
        $this->db->where("DATE(created) < (curdate() - INTERVAL " . getenv('NO_OF_DAYS_TO_KEEP_API_LOGS') . " DAY)");
        $this->db->delete('pct_order_api_logs');

        $this->db->where("DATE(created) < (curdate() - INTERVAL 1 DAY)");
        $this->db->where("request_type", "upload_document_cron");
        $this->db->delete('pct_order_api_logs');
        $this->db->query('OPTIMIZE TABLE pct_order_api_logs');

        $this->db->where("DATE(created) < (curdate() - INTERVAL " . getenv('NO_OF_DAYS_TO_KEEP_API_LOGS') . " DAY)");
        $this->db->delete('pct_order_cron_logs');

        $this->db->where("DATE(created_at) < (curdate() - INTERVAL 1 DAY)");
        $this->db->where("is_synced", 1);
        $this->db->delete('sp_file_upload_logs');
        $this->db->query('OPTIMIZE TABLE sp_file_upload_logs');
    }

    public function exportUsers()
    {
        define('USE_AUTHENTICATION', 1);
        define('USERNAME', 'ghernandez@pct.com');
        define('PASSWORD', 'hsk@12dhk');

        if (USE_AUTHENTICATION == 1) {
            if (! isset($_SERVER['PHP_AUTH_USER']) || ! isset($_SERVER['PHP_AUTH_PW']) ||
                $_SERVER['PHP_AUTH_USER'] != USERNAME || $_SERVER['PHP_AUTH_PW'] != PASSWORD) {
                header('WWW-Authenticate: Basic realm="WINCACHE Log In!"');
                header('HTTP/1.0 401 Unauthorized');
                exit;
            } else {
                $user = $this->uri->segment(2);
                $this->db->select('*');

                if (isset($user) && $user == 'escrows') {
                    $this->db->from('customer_basic_details');
                    $this->db->where('is_password_updated', 1);
                    $this->db->where('status', 1);
                    $this->db->where('is_escrow', 1);
                } else if (isset($user) && $user == 'lenders') {
                    $this->db->from('customer_basic_details');
                    $this->db->where('is_password_updated', 1);
                    $this->db->where('status', 1);
                    $this->db->where('is_escrow', 0);
                } else if (isset($user) && $user == 'realtors') {
                    $this->db->from('agents');
                    $this->db->where('status', 1);
                }
                $query  = $this->db->get();
                $result = $query->result_array();

                if (!empty($result)) {
                    $delimiter = ",";

                    if (isset($user) && $user == 'escrows') {
                        $filename = "escrows_" . date('Y-m-d') . ".csv";
                    } else if (isset($user) && $user == 'lenders') {
                        $filename = "lenders_" . date('Y-m-d') . ".csv";
                    } else if (isset($user) && $user == 'realtors') {
                        $filename = "realtors_" . date('Y-m-d') . ".csv";
                    }

                    $f = fopen('php://memory', 'w');

                    if (isset($user) && $user == 'realtors') {
                        $fields = ['Sr no', 'Name', 'Email', 'Company', 'Street Address', 'City', 'Zip code', 'List Unit', 'List Volume', 'Selected Revenue', 'Telephone No'];
                        fputcsv($f, $fields, $delimiter);

                        $i = 1;
                        foreach ($result as $res) {
                            $lineData = [$i, $res['name'], $res['email_address'], $res['company'], $res['address'], $res['city'], $res['zipcode'], $res['list_unit'], $res['list_volume'], $res['selected_revenue'], $res['telephone_no']];
                            fputcsv($f, $lineData, $delimiter);
                            $i++;
                        }
                    } else {
                        $fields = ['Sr no', 'First Name', 'Last Name', 'Password', 'Phone', 'Company Name', 'Email', 'Street Address', 'City', 'State', 'Zip code'];
                        fputcsv($f, $fields, $delimiter);

                        $i = 1;
                        foreach ($result as $res) {
                            $lineData = [$i, $res['first_name'], $res['last_name'], $res['random_password'], $res['telephone_no'], $res['company_name'], $res['email_address'], $res['street_address'], $res['city'], $res['state'], $res['zip_code']];
                            fputcsv($f, $lineData, $delimiter);
                            $i++;
                        }
                    }
                    fseek($f, 0);
                    header('Content-Type: text/csv');
                    header('Content-Disposition: attachment; filename="' . $filename . '";');
                    fpassthru($f);
                }
                exit;
            }
        }
    }

    public function getOrderInformation()
    {
        $login    = 'ghernandez@pct.com';
        $pass     = 'hsk@12dhk';
        $fileId   = $this->uri->segment(2);
        $response = [];

        if (($_SERVER['PHP_AUTH_PW'] != $pass || $_SERVER['PHP_AUTH_USER'] != $login) || ! $_SERVER['PHP_AUTH_USER']) {
            header('WWW-Authenticate: Basic realm="Test auth"');
            header('HTTP/1.0 401 Unauthorized');
            $response = ['success' => false, 'error_msg' => 'Please enter proper Authorization details.'];
        } else {
            $this->load->library('order/order');
            $orderDetails = $this->order->get_order_details($fileId);
            if (!empty($orderDetails)) {
                if ($orderDetails['sales_amount'] > 0) {
                    if (!empty($orderDetails['borrower'])) {
                        $orderDetails['primary_owner_name'] = $orderDetails['borrower'];
                    } else {
                        $orderDetails['primary_owner_name'] = '';
                    }

                    if (!empty($orderDetails['secondary_borrower'])) {
                        $orderDetails['secondary_owner_name'] = $orderDetails['secondary_borrower'];
                    } else {
                        $orderDetails['secondary_owner_name'] = '';
                    }
                } else {
                    if (!empty($orderDetails['primary_owner'])) {
                        $orderDetails['primary_owner_name'] = $orderDetails['primary_owner'];
                    } else {
                        $orderDetails['primary_owner_name'] = '';
                    }

                    if (!empty($orderDetails['secondary_owner'])) {
                        $orderDetails['secondary_owner_name'] = $orderDetails['secondary_owner'];
                    } else {
                        $orderDetails['secondary_owner_name'] = '';
                    }
                }

                $orderUser = $this->home_model->sp_get_user(['id' => $orderDetails['customer_id']]);

                if (!empty($orderUser) && $orderUser['is_escrow'] == 1) {
                    if (!empty($orderDetails['cpl_lender_id'])) {
                        $lenderDetails                            = $this->home_model->sp_get_user(['id' => $orderDetails['cpl_lender_id']]);
                        $orderDetails['lender_first_name']        = $lenderDetails['first_name'] ? $lenderDetails['first_name'] : '';
                        $orderDetails['lender_last_name']         = $lenderDetails['last_name'] ? $lenderDetails['last_name'] : '';
                        $orderDetails['lender_email']             = $lenderDetails['email_address'] ? $lenderDetails['email_address'] : '';
                        $orderDetails['lender_state']             = $lenderDetails['state'] ? $lenderDetails['state'] : '';
                        $orderDetails['lender_company_name']      = $lenderDetails['company_name'] ? $lenderDetails['company_name'] : '';
                        $orderDetails['lender_address']           = $lenderDetails['street_address'] ? $lenderDetails['street_address'] : '';
                        $orderDetails['lender_city']              = $lenderDetails['city'] ? $lenderDetails['city'] : '';
                        $orderDetails['lender_zipcode']           = $lenderDetails['zip_code'] ? $lenderDetails['zip_code'] : '';
                        $orderDetails['lender_assignment_clause'] = $lenderDetails['assignment_clause'] ? $lenderDetails['assignment_clause'] : '';
                        $orderDetails['lender_id']                = $lenderDetails['id'] ? $lenderDetails['id'] : '';
                    } else {
                        $orderDetails['lender_first_name']        = $orderDetails['lender_first_name'] ? $orderDetails['lender_first_name'] : '';
                        $orderDetails['lender_last_name']         = $orderDetails['lender_last_name'] ? $orderDetails['lender_last_name'] : '';
                        $orderDetails['lender_email']             = $orderDetails['lender_email'] ? $orderDetails['lender_email'] : '';
                        $orderDetails['lender_state']             = $orderDetails['lender_state'] ? $orderDetails['lender_state'] : '';
                        $orderDetails['lender_company_name']      = $orderDetails['lender_company_name'] ? $orderDetails['lender_company_name'] : '';
                        $orderDetails['lender_address']           = $orderDetails['lender_address'] ? $orderDetails['lender_address'] : '';
                        $orderDetails['lender_city']              = $orderDetails['lender_city'] ? $orderDetails['lender_city'] : '';
                        $orderDetails['lender_zipcode']           = $orderDetails['lender_zipcode'] ? $orderDetails['lender_zipcode'] : '';
                        $orderDetails['lender_assignment_clause'] = $orderDetails['lender_assignment_clause'] ? $orderDetails['lender_assignment_clause'] : '';
                        $orderDetails['lender_id']                = $orderDetails['lender_id'] ? $orderDetails['lender_id'] : '';
                    }
                } else {
                    if (!empty($orderDetails['cpl_lender_id'])) {
                        $lenderDetails                            = $this->home_model->sp_get_user(['id' => $orderDetails['cpl_lender_id']]);
                        $orderDetails['lender_first_name']        = $lenderDetails['first_name'] ? $lenderDetails['first_name'] : '';
                        $orderDetails['lender_last_name']         = $lenderDetails['last_name'] ? $lenderDetails['last_name'] : '';
                        $orderDetails['lender_email']             = $lenderDetails['email_address'] ? $lenderDetails['email_address'] : '';
                        $orderDetails['lender_state']             = $lenderDetails['state'] ? $lenderDetails['state'] : '';
                        $orderDetails['lender_company_name']      = $lenderDetails['company_name'] ? $lenderDetails['company_name'] : '';
                        $orderDetails['lender_address']           = $lenderDetails['street_address'] ? $lenderDetails['street_address'] : '';
                        $orderDetails['lender_city']              = $lenderDetails['city'] ? $lenderDetails['city'] : '';
                        $orderDetails['lender_zipcode']           = $lenderDetails['zip_code'] ? $lenderDetails['zip_code'] : '';
                        $orderDetails['lender_assignment_clause'] = $lenderDetails['assignment_clause'] ? $lenderDetails['assignment_clause'] : '';
                        $orderDetails['lender_id']                = $lenderDetails['id'] ? $lenderDetails['id'] : '';
                    } else {
                        $orderDetails['lender_first_name']        = $orderUser['first_name'] ? $orderUser['first_name'] : '';
                        $orderDetails['lender_last_name']         = $orderUser['last_name'] ? $orderUser['last_name'] : '';
                        $orderDetails['lender_email']             = $orderUser['email_address'] ? $orderUser['email_address'] : '';
                        $orderDetails['lender_state']             = $orderUser['state'] ? $orderUser['state'] : '';
                        $orderDetails['lender_company_name']      = $orderUser['company_name'] ? $orderUser['company_name'] : '';
                        $orderDetails['lender_address']           = $orderUser['street_address'] ? $orderUser['street_address'] : '';
                        $orderDetails['lender_city']              = $orderUser['city'] ? $orderUser['city'] : '';
                        $orderDetails['lender_zipcode']           = $orderUser['zip_code'] ? $orderUser['zip_code'] : '';
                        $orderDetails['lender_assignment_clause'] = $orderUser['assignment_clause'] ? $orderUser['assignment_clause'] : '';
                        $orderDetails['lender_id']                = $orderUser['id'] ? $orderUser['id'] : '';
                    }
                    $orderUser = $this->home_model->sp_get_user(['id' => $orderDetails['customer_id']]);
                }

                $orderData = [
                    'Loans'              => [
                        'LoanNumber'  => $orderDetails['loan_number'],
                        'SalesAmount' => $orderDetails['sales_amount'],
                        'LoanAmount'  => $orderDetails['loan_amount'],
                    ],
                    'FileNumber'         => $orderDetails['file_number'],
                    'FileID'             => $orderDetails['file_id'],
                    'Product'            => $orderDetails['product_type'],
                    'Borrower'           => [
                        'PrimaryName'   => $orderDetails['primary_owner_name'],
                        'SecondaryName' => $orderDetails['secondary_owner_name'],
                        'Email'         => 'ghernandez@pct.com',
                        'Mobile'        => '(213) 309-7286',
                    ],
                    'Properties'         => [
                        'Address' => $orderDetails['address'],
                        'City'    => $orderDetails['property_city'],
                        'State'   => $orderDetails['property_state'],
                        'County'  => $orderDetails['county'],
                        'Zip'     => $orderDetails['property_zip'],
                    ],
                    'LenderInformations' => [
                        'FirstName'   => $orderDetails['lender_first_name'],
                        'LastName'    => $orderDetails['lender_last_name'],
                        'CompanyName' => $orderDetails['lender_company_name'],
                        'Email'       => $orderDetails['lender_email'],
                        'Address'     => $orderDetails['lender_address'],
                        'City'        => $orderDetails['lender_city'],
                        'State'       => $orderDetails['lender_state'],
                        'Zip'         => $orderDetails['lender_zipcode'],
                    ],
                ];
                $response = ['FileInformations' => $orderData];
            } else {
                $response = ['success' => false, 'error_msg' => 'Please enter the correct file id to get order information.'];
            }
        }
        header('Content-type: application/json');
        echo json_encode($response, true);
        exit;
    }

    public function updateOrderStatus()
    {
        $this->db->select('file_id, customer_id, file_number, on_hold_mail_sent');
        $this->db->from('order_details');
        $query       = $this->db->get();
        $filesResult = $query->result_array();

        $status                = [];
        $userdata['admin_api'] = 1;
        $status['Statuses'][]  = ['StatusID' => 6, 'Name' => 'Hold'];
        $logid                 = $this->apiLogs->syncLogs(0, 'resware', 'get_orders', env('RESWARE_ORDER_API') . 'files/search', json_encode($status), [], 0, 0);
        $res                   = $this->make_request('POST', 'files/search', json_encode($status), $userdata);
        $this->apiLogs->syncLogs(0, 'resware', 'get_orders', env('RESWARE_ORDER_API') . 'files/search', json_encode($status), $res, 0, $logid);
        $result   = json_decode($res, true);
        $file_ids = [];

        if (isset($result['Files']) && !empty($result['Files'])) {
            foreach ($result['Files'] as $res) {
                $key = array_search($res['FileID'], array_column($filesResult, 'file_id'));
                if ($key) {
                    $on_hold_mail_sent = $filesResult[$key]['on_hold_mail_sent'];
                    if ($on_hold_mail_sent == 0) {
                        $file_ids[] = $filesResult[$key]['file_id'];
                        $filesResult[$key]['file_number'];

                        $file_number = $filesResult[$key]['file_number'];
                        /*$customer_id = $filesResult[$key]['customer_id'];
                        $condition = array(
                        'id' => $customer_id
                        );
                        $customerDetails = $this->home_model->get_customers($condition);
                        $first_name = isset($customerDetails['first_name']) && !empty($customerDetails['first_name']) ? $customerDetails['first_name'] : '';
                        $last_name = isset($customerDetails['last_name']) && !empty($customerDetails['last_name']) ? $customerDetails['last_name'] : '';
                        $telephone_no = isset($customerDetails['telephone_no']) && !empty($customerDetails['telephone_no']) ? $customerDetails['telephone_no'] : '';
                        $email_address = isset($customerDetails['email_address']) && !empty($customerDetails['email_address']) ? $customerDetails['email_address'] : '';
                        $company_name = isset($customerDetails['company_name']) && !empty($customerDetails['company_name']) ? $customerDetails['company_name'] : '';
                        $street_address = isset($customerDetails['street_address']) && !empty($customerDetails['street_address']) ? $customerDetails['street_address'] : '';
                        $city = isset($customerDetails['city']) && !empty($customerDetails['city']) ? $customerDetails['city'] : '';
                        $zipcode = isset($customerDetails['zip_code']) && !empty($customerDetails['zip_code']) ? $customerDetails['zip_code'] : '';
                        $property = $res['Properties'][0]['StreetNumber']." ".$res['Properties'][0]['StreetDirection']." ".$res['Properties'][0]['StreetName']." ".$res['Properties'][0]['StreetSuffix'].", ".$res['Properties'][0]['City'].", ".$res['Properties'][0]['State'].", ".$res['Properties'][0]['Zip'];
                        $message = '<h3>User Details:</h3><p>Name: '.$first_name.' '.$last_name.'</p><p>Telephone: '.$telephone_no.'</p><p>Email Address: '.$email_address.'</p><p>Company Name: '.$company_name.'</p><p>Street Address: '.$street_address.'</p><p>City: '.$city.'</p><p>Zipcode: '.$zipcode.'</p><p>Property Address: '.$property.'</p><p>File Number: '.$file_number.'</p>';*/

                        $data['file_number'] = $file_number;
                        $message             = $this->load->view('emails/onhold.php', $data, true);
                        $from_name           = 'Pacific Coast Title Company';
                        $from_mail           = env('FROM_EMAIL');
                        $subject             = 'Notification For On Hold Order';
                        $to                  = 'cs@pct.com';
                        $cc                  = ['ghernandez@pct.com'];
                        $this->load->helper('sendemail');
                        send_email($from_mail, $from_name, $to, $subject, $message, $cc);
                    }
                }
            }
            if (!empty($file_ids)) {
                $updateData = ['resware_status' => 'hold', 'on_hold_mail_sent' => 1];
                $this->db->set($updateData);
                $this->db->where_in('file_id', $file_ids);
                $this->db->update('order_details');
                echo "All orders with status hold updated successfully";exit;
            } else {
                echo "No orders found with status hold";exit;
            }
        } else {
            echo "No orders found with status hold";exit;
        }
    }

    public function getOrderStatus()
    {
        echo date('Y-m-d H:i:s') . "----";
        $this->db->select('file_id, customer_id, file_number, on_hold_mail_sent, resware_status');
        $this->db->from('order_details');
        $this->db->where('resware_status != "closed" OR resware_status IS NULL');
        $this->db->order_by("id", "desc");
        $query       = $this->db->get();
        $filesResult = $query->result_array();

        if (isset($filesResult) && !empty($filesResult)) {
            foreach ($filesResult as $file) {
                $data                  = [];
                $userdata['admin_api'] = 1;
                $data                  = ['FileNumber' => $file['file_number']];
                $res                   = $this->make_request('POST', 'files/search', json_encode($data), $userdata);
                $result                = json_decode($res, true);

                if (strtolower($result['Files'][0]['Status']['Name']) != $file['resware_status']) {
                    $orderData = [
                        'resware_status' => strtolower($result['Files'][0]['Status']['Name']),
                    ];

                    if (strtolower($result['Files'][0]['Status']['Name']) == 'closed') {
                        $orderData['resware_closed_status_date'] = date('Y-m-d H:i:s');
                    }

                    $condition = [
                        'file_id'     => $file['file_id'],
                        'file_number' => $file['file_number'],
                    ];

                    $this->home_model->update($orderData, $condition, 'order_details');
                }
            }
        }
        echo date('Y-m-d H:i:s');exit;
    }

    public function updateSafewireStatusForAllorders()
    {
        $this->db->select('*');
        $this->db->from('order_details');
        $this->db->where('is_create_order_on_safewire = 1');
        $query  = $this->db->get();
        $result = $query->result_array();

        if (!empty($result)) {
            foreach ($result as $res) {
                $url   = env('SAFEWIRE_URL') . $res['file_id'] . '/status';
                $logid = $this->apiLogs->syncLogs(0, 'safewire', 'get_order_status', $url, [], [], $res['id'], 0);
                $ch    = curl_init($url);
                curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
                curl_setopt($ch, CURLOPT_POSTFIELDS, []);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch, CURLOPT_HTTPHEADER, [
                    'Api-Key: ' . env('SAFEWIRE_API_KEY'),
                    'Content-Type: application/json',
                ]
                );
                $error_msg = curl_error($ch);
                $result    = curl_exec($ch);
                $this->apiLogs->syncLogs(0, 'safewire', 'get_wire_detail_pdf', $url, [], $result, $res['id'], $logid);

                $resultSafewire = json_decode($result, true);
                if (isset($resultSafewire['order_id']) && !empty($resultSafewire['order_id'])) {
                    $this->home_model->update(['safewire_order_status' => $resultSafewire['status']], ['file_id' => $res['file_id']], 'order_details');
                    if ($resultSafewire['status'] == 'completed' && $res['safewire_order_status'] != 'completed') {
                        $this->load->library('order/order');
                        $orderDetails = $this->order->get_order_details($res['file_id']);
                        $this->order->syncSafewireDocuments($resultSafewire['order_details'], $resultSafewire['wire_instruction_details'], $orderDetails);
                    }
                }
                $response = ['success' => true, 'message' => 'Safewire order status updated successfully.'];
            }
        } else {
            $response = ['success' => false, 'message' => 'No Order found for update status'];
        }
        echo json_encode($response);exit;
    }

    public function sendMailEscrowUsers()
    {
        $month = sprintf('%02d', date('m') - 1);
        $this->db->select('order_details.file_id,
            order_details.file_number,
            order_details.id as order_id,
            order_details.resware_status,
            order_details.resware_closed_status_date,
            property_details.full_address,
            customer_basic_details.first_name,
            customer_basic_details.last_name,
            customer_basic_details.email_address as sales_email,
            customer_basic_details.sales_rep_profile_thank_you_img,
            property_details.escrow_lender_id,
            escrow_details.email_address,
            transaction_details.sales_representative');
        $this->db->from('order_details');
        $this->db->where('MONTH(order_details.resware_closed_status_date)', $month);
        $this->db->where('YEAR(order_details.resware_closed_status_date)', date('Y'));
        $this->db->where('order_details.prod_type', 'loan');
        $this->db->where('property_details.escrow_lender_id != ""');
        $this->db->where('transaction_details.sales_representative != ""');
        $this->db->join('property_details', 'order_details.property_id = property_details.id', 'inner');
        $this->db->join('transaction_details', 'order_details.transaction_id = transaction_details.id', 'inner');
        $this->db->join('customer_basic_details', 'customer_basic_details.id = transaction_details.sales_representative', 'inner');
        $this->db->join('customer_basic_details as escrow_details', 'escrow_details.id = property_details.escrow_lender_id', 'inner');
        $this->db->order_by('transaction_details.sales_representative asc, property_details.escrow_lender_id asc');
        $query  = $this->db->get();
        $result = $query->result_array();

        if (!empty($result)) {
            $checkFlag = 0;
            $data      = [];
            $i         = 0;
            foreach ($result as $res) {
                if ($checkFlag == 0) {
                    $sales_rep_user_id    = $res['sales_representative'];
                    $escrow_user_id       = $res['escrow_lender_id'];
                    $escrow_email_address = $res['email_address'];
                    $checkFlag            = 1;
                }
                if ($res['sales_representative'] == $sales_rep_user_id && $res['escrow_lender_id'] == $escrow_user_id) {
                    $data['order_info'][$i]['order_number']   = $res['file_number'];
                    $data['order_info'][$i]['address']        = $res['full_address'];
                    $data['order_info'][$i]['resware_status'] = $res['resware_status'] ? $res['resware_status'] : 'closed';
                    $data['order_info'][$i]['closed_date']    = date("m/d/Y", strtotime($res['resware_closed_status_date']));
                    $data['sales_rep_profile_thank_you_img']  = !empty($res['sales_rep_profile_thank_you_img']) ? $res['sales_rep_profile_thank_you_img'] : '';
                    if (!empty($data['sales_rep_profile_thank_you_img'])) {
                        $data['sales_rep_profile_thank_you_img'] = env('AWS_PATH') . str_replace('uploads/', '', $data['sales_rep_profile_thank_you_img']);
                    }
                    $data['sales_email'] = !empty($res['sales_email']) ? $res['sales_email'] : '';
                    $i++;
                } else {
                    $message    = $this->load->view('emails/thank_you_escrow.php', $data, true);
                    $from_name  = 'Pacific Coast Title Company';
                    $from_mail  = env('FROM_EMAIL');
                    $subject    = 'Thank You!';
                    $to         = $escrow_email_address;
                    $cc         = ['ghernandez@pct.com', $data['sales_email']];
                    $mailParams = [
                        'from_mail' => $from_mail,
                        'from_name' => $from_name,
                        'to'        => $to,
                        'subject'   => $subject,
                        'message'   => json_encode($data),
                        'cc'        => $data['sales_email'],
                    ];
                    //$to = 'hitesh.p@crestinfosystems.com';
                    //$cc = array();
                    $this->load->helper('sendemail');
                    $logid              = $this->apiLogs->syncLogs(0, 'sendgrid', 'send_mail_to_escrow_user', '', $mailParams, [], $res['order_id'], 0);
                    $escrow_mail_result = send_email($from_mail, $from_name, $to, $subject, $message, [], $cc);
                    $this->apiLogs->syncLogs(0, 'sendgrid', 'send_mail_to_escrow_user', '', $mailParams, ['status' => $escrow_mail_result], $res['orderId'], $logid);
                    $data                                     = [];
                    $sales_rep_user_id                        = $res['sales_representative'];
                    $escrow_user_id                           = $res['escrow_lender_id'];
                    $escrow_email_address                     = $res['email_address'];
                    $data['order_info'][$i]['order_number']   = $res['file_number'];
                    $data['order_info'][$i]['address']        = $res['full_address'];
                    $data['order_info'][$i]['resware_status'] = $res['resware_status'] ? $res['resware_status'] : 'closed';
                    $data['order_info'][$i]['closed_date']    = date("m/d/Y", strtotime($res['resware_closed_status_date']));
                    $data['sales_rep_profile_thank_you_img']  = !empty($res['sales_rep_profile_thank_you_img']) ? $res['sales_rep_profile_thank_you_img'] : '';
                    if (!empty($data['sales_rep_profile_thank_you_img'])) {
                        $data['sales_rep_profile_thank_you_img'] = env('AWS_PATH') . str_replace('uploads/', '', $data['sales_rep_profile_thank_you_img']);
                    }
                    $data['sales_email'] = !empty($res['sales_email']) ? $res['sales_email'] : '';
                    $i++;
                }
                $sales_email = $res['sales_email'];
                $order_id    = $res['order_id'];
            }
            if (!empty($data)) {
                $message   = $this->load->view('emails/thank_you_escrow.php', $data, true);
                $from_name = 'Pacific Coast Title Company';
                $from_mail = env('FROM_EMAIL');
                $subject   = 'Thank You!';
                $to        = $escrow_email_address;

                $cc = ['ghernandez@pct.com', $sales_email];
                $this->load->helper('sendemail');
                $mailParams = [
                    'from_mail' => $from_mail,
                    'from_name' => $from_name,
                    'to'        => $to,
                    'subject'   => $subject,
                    'message'   => json_encode($data),
                    'cc'        => $sales_email,
                ];
                //$to = 'hitesh.p@crestinfosystems.com';
                //$cc = array();

                $logid              = $this->apiLogs->syncLogs(0, 'sendgrid', 'send_mail_to_escrow_user', '', $mailParams, [], $order_id, 0);
                $escrow_mail_result = send_email($from_mail, $from_name, $to, $subject, $message, [], $cc);
                $this->apiLogs->syncLogs(0, 'sendgrid', 'send_mail_to_escrow_user', '', $mailParams, ['status' => $escrow_mail_result], $order_id, $logid);
            }
            echo "Mails sent successfully to Escow user ";exit;
        }
    }

    public function transferAllFilesOnAws()
    {
        //$this->load->library('order/order');
        //$credResult = $this->order->uploadDocumentOnAwsS3('3795645.pdf', 'test');
        //echo $credResult;exit;

        $bucket = env('AWS_BUCKET');
        try {
            $s3Client = new Aws\S3\S3Client([
                'region'      => env('AWS_REGION'),
                'version'     => '2006-03-01',
                'credentials' => [
                    'key'    => env('AWS_ACCESS_KEY_ID'),
                    'secret' => env('AWS_SECRET_ACCESS_KEY'),
                ],
            ]);
            $dir       = FCPATH . "/uploads";
            $keyPrefix = '';

            $result = $s3Client->uploadDirectory($dir, $bucket, $keyPrefix, [
                'params'      => ['ACL' => 'public-read'],
                'concurrency' => 50,
                'debug'       => true,
            ]);

        } catch (Aws\Exception\AwsException $e) {
            return $e->getMessage() . "\n";
        }
        echo "All files uploaded successfully on AWS S3.";exit;

        /*$this->load->library('order/order');
    $folders = array();
    $path = FCPATH."/uploads/";
    $sub_folder = scandir($path);
    $num = count($sub_folder);
    for ($i = 2; $i < $num; $i++) {
    if (is_file($path.'\\'.$sub_folder[$i])) {
    $syncResult = $this->order->uploadDocumentOnAwsS3($sub_folder[$i]);
    echo $syncResult;
    } else {
    $folders[] = $sub_folder[$i];
    }
    }

    foreach ($folders as $folder) {
    $fileSystemIterator = new FilesystemIterator(FCPATH."/uploads/".$folder."/");
    foreach ($fileSystemIterator as $fileInfo) {
    $credResult = $this->order->uploadDocumentOnAwsS3($fileInfo->getFilename(), $folder);
    echo $credResult;
    }
    }*/

    }

    public function importDataFromCsvFile()
    {
        $sftp     = new SFTP(env('SFTP_HOST'));
        $username = env('SFTP_USERNAME');
        $password = env('SFTP_PASSWORD');

        if (! $sftp->login($username, $password)) {
            exit('Login Failed');
        }

        if (! ($files = $sftp->nlist('/' . env('SFTP_FOLDER') . '/open-closed-orders/', true))) {
            die("Cannot read directory contents");
        }

        foreach ($files as $file) {
            if ($file != '.' && $file != '..' && $file != '.protected') {
                if (! is_dir('uploads/open-closed-orders')) {
                    mkdir('./uploads/open-closed-orders', 0777, true);
                }
                $sftp->get(env('SFTP_FOLDER') . '/open-closed-orders/' . $file, FCPATH . 'uploads/open-closed-orders/' . trim($file) . ".csv");
                chmod(FCPATH . 'uploads/open-closed-orders/' . $file . ".csv", 0755);
                $sftp->delete(env('SFTP_FOLDER') . '/open-closed-orders/' . $file);
            }
        }
        $files = glob("uploads/open-closed-orders/*csv");

        $this->db->select("id, LOWER(CONCAT_WS(' ', first_name, last_name)) AS sales_name, LOWER(email_address) as email");
        $this->db->from('customer_basic_details');
        $this->db->where('is_sales_rep', 1);
        $query      = $this->db->get();
        $salesUsers = $query->result_array();

        if (is_array($files) && count($files) > 0) {
            foreach ($files as $filePath) {
                $row           = 1;
                $headerColumns = [];
                if (($handle = fopen($filePath, "r")) !== false) {
                    $documentName        = pathinfo($filePath);
                    $file_numbers        = [];
                    $salesRepNameArr     = [];
                    $titleOfficerNameArr = [];
                    $i                   = 0;
                    $j                   = 0;
                    while (($data = fgetcsv($handle, 1000, ",", '"')) !== false) {
                        $num = count($data);
                        if ($row == 1) {
                            for ($c = 0; $c < $num; $c++) {
                                $headerColumns[] = trim($data[$c]);
                            }
                        }

                        $fileKey                = '';
                        $prodkey                = '';
                        $premiumkey             = '';
                        $saleskey               = '';
                        $emailkey               = '';
                        $closedDate             = '';
                        $salesRepId             = 0;
                        $sales_rep_img          = '';
                        $escrow_email           = '';
                        $titleOfficerId         = 0;
                        $titleOfficerColumnFlag = 0;
                        $salesRepColumnFlag     = 0;

                        if (in_array('File Number', $headerColumns)) {
                            $fileKey     = array_search("File Number", $headerColumns);
                            $file_number = $data[$fileKey];
                        }

                        if (in_array('Prod Type', $headerColumns)) {
                            $prodkey  = array_search("Prod Type", $headerColumns);
                            $prodType = $data[$prodkey];
                        }

                        if (in_array('Total Premium', $headerColumns)) {
                            $premiumkey = array_search("Total Premium", $headerColumns);
                            $premium    = $data[$premiumkey];
                            $premium    = str_replace('$', '', $premium);
                            $premium    = str_replace(',', '', $premium);
                        }

                        if (in_array('Email', $headerColumns)) {
                            $emailkey    = array_search("Email", $headerColumns);
                            $sales_email = strtolower(trim($data[$emailkey]));
                            if (!empty($sales_email)) {
                                $saleUserKey = array_search($sales_email, array_column($salesUsers, 'email'));
                                if (isset($saleUserKey) && !empty($saleUserKey)) {
                                    $salesRepId = $salesUsers[$saleUserKey]['id'];
                                }
                            }
                        }

                        if ($salesRepId == 0) {
                            $salesRepName = '';
                            if (in_array('Sales Rep', $headerColumns)) {
                                $saleskey     = array_search("Sales Rep", $headerColumns);
                                $salesRepName = strtolower(trim($data[$saleskey]));

                                if (!empty($salesRepName)) {
                                    $saleUserKey = array_search($salesRepName, array_column($salesUsers, 'sales_name'));
                                    if (isset($saleUserKey) && !empty($saleUserKey)) {
                                        $salesRepId = $salesUsers[$saleUserKey]['id'];
                                    }
                                }

                                // $key = array_search($salesRepName, array_column($salesRepNameArr, 'name'));
                                // if (isset($key) && !empty($key)) {
                                // $salesRepId =  $salesRepNameArr[$key]['id'];
                                // $sales_rep_img = $salesRepNameArr[$key]['sales_rep_img'];
                                // } else {
                                //     $salesRepNameArr[$i]['name'] =  $salesRepName;
                                // }
                                // $salesRepColumnFlag = 1;
                            }
                        }

                        $titleOfficerName = '';
                        if (in_array('Title Officer', $headerColumns)) {
                            $titleOfficerkey  = array_search("Title Officer", $headerColumns);
                            $titleOfficerName = $data[$titleOfficerkey];
                            $titleOfficerName = str_replace(' ', '_', $titleOfficerName);
                            $titleOfficerName = preg_replace('/[^A-Za-z0-9&\_-]/', '', $titleOfficerName);
                            $titleOfficerName = str_replace('_', ' ', $titleOfficerName);
                            $titleOfckey      = array_search($titleOfficerName, array_column($titleOfficerNameArr, 'name'));
                            if (isset($titleOfckey) && !empty($titleOfckey)) {
                                $titleOfficerId = $titleOfficerNameArr[$titleOfckey]['id'];
                            } else {
                                $titleOfficerNameArr[$j]['name'] = $titleOfficerName;
                            }
                            $titleOfficerColumnFlag = 1;
                        }

                        if (in_array('Sent To External Accounting', $headerColumns)) {
                            $closedDatekey = array_search("Sent To External Accounting", $headerColumns);
                            $closedDate    = $data[$closedDatekey];
                        }

                        if ($row != 1) {
                            //echo $file_number."---".$prodType."----".$premium."----".$salesRepName."---".$closedDate;exit;
                            // $resultSales = array();
                            // if(!empty($salesRepName)) {
                            //     if ($salesRepId == 0) {
                            //         $this->db->select('*');
                            //         $this->db->from('customer_basic_details');
                            //         $this->db->like("CONCAT_WS(' ', first_name, last_name)", $salesRepName);
                            //         $this->db->where('is_sales_rep', 1);
                            //         $query = $this->db->get();
                            //         $resultSales = $query->row_array();
                            //         if (!empty($resultSales)) {
                            //             $salesRepId =  $resultSales['id'];
                            //             $sales_rep_img = isset($resultSales["sales_rep_profile_img"]) && !empty($resultSales["sales_rep_profile_img"]) ? $resultSales["sales_rep_profile_img"] : '';
                            //             if(!empty($sales_rep_img)) {
                            //                 $sales_rep_img = env('AWS_PATH').str_replace('uploads/', '', $sales_rep_img);
                            //             }
                            //             $salesRepNameArr[$i]['id'] = $salesRepId;
                            //             $salesRepNameArr[$i]['sales_rep_img'] = $sales_rep_img;
                            //             $i++;
                            //         } else {
                            //             if (!empty(trim($salesRepNameArr[$i]['name']))) {
                            //                 $salesRepNameArr[$i]['id'] = 0;
                            //                 $i++;
                            //             }
                            //         }
                            //     }
                            // }

                            $resultTitleOfficer = [];
                            if (!empty($titleOfficerName)) {
                                if ($titleOfficerId == 0) {
                                    $this->db->select('*');
                                    $this->db->from('customer_basic_details');
                                    $this->db->like("CONCAT_WS(' ', first_name, last_name)", $titleOfficerName);
                                    $this->db->where('is_title_officer', 1);
                                    $query              = $this->db->get();
                                    $resultTitleOfficer = $query->row_array();
                                    if (!empty($resultTitleOfficer)) {
                                        $titleOfficerId                = $resultTitleOfficer['id'];
                                        $titleOfficerNameArr[$j]['id'] = $titleOfficerId;
                                        $j++;
                                    } else {
                                        if (!empty(trim($titleOfficerNameArr[$i]['name']))) {
                                            $titleOfficerNameArr[$j]['id'] = 0;
                                            $j++;
                                        }
                                    }
                                }
                            }

                            $completed_date = null;
                            if (!empty($closedDate)) {
                                $myDateTime     = DateTime::createFromFormat('n/j/Y g:i:s A', $closedDate);
                                $completed_date = $myDateTime->format('Y-m-d H:i:s');
                            }

                            if (!empty($file_number)) {
                                $condition = [
                                    'where' => [
                                        'file_number' => $file_number,
                                    ],
                                ];
                                $order = $this->order->get_order($condition);

                                if (!empty($order)) {
                                    if (in_array($file_number, $file_numbers)) {
                                        if (!empty($premium)) {
                                            $premium = (float) $premium + $order[0]['premium'];
                                        }
                                    }
                                    $file_numbers[] = $file_number;
                                    $orderData      = [];

                                    if (!empty($prodType)) {
                                        $orderData['prod_type'] = strtolower($prodType);
                                    }

                                    if (!empty($premium)) {
                                        $orderData['premium'] = (float) $premium;
                                    }

                                    if (!empty($completed_date)) {
                                        $orderData['sent_to_accounting_date'] = $completed_date;
                                    }

                                    if (!empty($orderData)) {
                                        $this->home_model->update(
                                            $orderData,
                                            [
                                                'id' => $order[0]['id'],
                                            ],
                                            'order_details'
                                        );
                                    }

                                    $orderDetails    = $this->order->get_order_details($order[0]['file_id']);
                                    $propertyAddress = $orderDetails['address'];
                                    $productTypeID   = $orderDetails['purchase_type'];
                                    $orderId         = $order[0]['id'];
                                    if (!empty($salesRepId)) {
                                        $this->home_model->update(
                                            [
                                                'sales_representative' => $salesRepId,
                                            ],
                                            [
                                                'id' => $orderDetails['transaction_id'],
                                            ],
                                            'transaction_details'
                                        );
                                    } else {
                                        if ($salesRepColumnFlag == 1) {
                                            $this->home_model->update(
                                                [
                                                    'sales_representative' => 0,
                                                ],
                                                [
                                                    'id' => $orderDetails['transaction_id'],
                                                ],
                                                'transaction_details'
                                            );
                                        }
                                    }

                                    if (!empty($titleOfficerId)) {
                                        $this->home_model->update(
                                            [
                                                'title_officer' => $titleOfficerId,
                                            ],
                                            [
                                                'id' => $orderDetails['transaction_id'],
                                            ],
                                            'transaction_details'
                                        );
                                    } else {
                                        if ($titleOfficerColumnFlag == 1) {
                                            $this->home_model->update(
                                                [
                                                    'title_officer' => 0,
                                                ],
                                                [
                                                    'id' => $orderDetails['transaction_id'],
                                                ],
                                                'transaction_details'
                                            );
                                        }
                                    }
                                } else {
                                    $file_numbers[] = $file_number;
                                    $data           = json_encode(['FileNumber' => $file_number]);
                                    $userData       = [
                                        'admin_api' => 1,
                                    ];
                                    $logid = $this->apiLogs->syncLogs(0, 'resware', 'get_order_information', env('RESWARE_ORDER_API') . 'files/search', $data, [], 0, 0);
                                    $res   = $this->make_request('POST', 'files/search', $data, $userData);
                                    $this->apiLogs->syncLogs(0, 'resware', 'get_order_information', env('RESWARE_ORDER_API') . 'files/search', $data, $res, 0, $logid);
                                    $result = json_decode($res, true);

                                    if (isset($result['Files']) && !empty($result['Files'])) {
                                        foreach ($result['Files'] as $res) {
                                            if (count($result['Files']) > 1 && strtolower($res['Status']['Name']) == 'cancelled') {
                                                continue;
                                            }
                                            $partner_fname = $res['Partners'][0]['PrimaryEmployee']['FirstName'];
                                            $partner_lname = $res['Partners'][0]['PrimaryEmployee']['LastName'];
                                            $partner_name  = $res['Partners'][0]['PartnerName'];
                                            $condition     = [
                                                'first_name'   => $partner_fname,
                                                'last_name'    => $partner_lname,
                                                'company_name' => $partner_name,
                                                'is_pass'      => $partner_name,
                                            ];
                                            $user_details = $this->home_model->get_user_by_name($condition);
                                            $customerId   = 0;

                                            if (isset($user_details) && !empty($user_details)) {
                                                $customerId = $user_details['id'];
                                            }

                                            $FullProperty = $res['Properties'][0]['StreetNumber'] . " " . $res['Properties'][0]['StreetDirection'] . " " . $res['Properties'][0]['StreetName'] . " " . $res['Properties'][0]['StreetSuffix'] . ", " . $res['Properties'][0]['City'] . ", " . $res['Properties'][0]['State'] . ", " . $res['Properties'][0]['Zip'];
                                            $address      = $res['Properties'][0]['StreetNumber'] . " " . $res['Properties'][0]['StreetDirection'] . " " . $res['Properties'][0]['StreetName'] . " " . $res['Properties'][0]['StreetSuffix'];
                                            $locale       = $res['Properties'][0]['City'];

                                            if (($locale)) {
                                                if (!empty($res['Properties'][0]['State'])) {
                                                    $locale .= ', ' . $res['Properties'][0]['State'];
                                                } else {
                                                    $locale .= ', CA';
                                                }
                                            }

                                            $property_details = $this->getSearchResult($address, $locale);
                                            $property_type    = isset($property_details['property_type']) && !empty($property_details['property_type']) ? $property_details['property_type'] : '';
                                            $LegalDescription = isset($property_details['legaldescription']) && !empty($property_details['legaldescription']) ? $property_details['legaldescription'] : '';
                                            $apn              = isset($property_details['apn']) && !empty($property_details['apn']) ? $property_details['apn'] : '';
                                            $propertyData     = [
                                                'customer_id'       => $customerId,
                                                'buyer_agent_id'    => 0,
                                                'listing_agent_id'  => 0,
                                                'escrow_lender_id'  => 0,
                                                'parcel_id'         => $res['Properties'][0]['ParcelID'],
                                                'address'           => removeMultipleSpace($address),
                                                'city'              => $res['Properties'][0]['City'],
                                                'state'             => $res['Properties'][0]['State'],
                                                'zip'               => $res['Properties'][0]['Zip'],
                                                'property_type'     => $property_type,
                                                'full_address'      => removeMultipleSpace($FullProperty),
                                                'apn'               => $apn,
                                                'county'            => $res['Properties'][0]['County'],
                                                'legal_description' => $LegalDescription,
                                                'status'            => 1,
                                            ];

                                            $transactionData = [
                                                'customer_id'          => $customerId,
                                                'sales_amount'         => !empty($res['SalesPrice']) ? $res['SalesPrice'] : 0,
                                                'loan_number'          => !empty($res['Loans'][0]['LoanNumber']) ? $res['Loans'][0]['LoanNumber'] : 0,
                                                'loan_amount'          => !empty($res['Loans'][0]['LoanAmount']) ? $res['Loans'][0]['LoanAmount'] : 0,
                                                'transaction_type'     => $res['TransactionProductType']['TransactionTypeID'],
                                                'purchase_type'        => $res['TransactionProductType']['ProductTypeID'],
                                                'sales_representative' => $salesRepId,
                                                'title_officer'        => $titleOfficerId,
                                                'status'               => 1,
                                            ];

                                            $propertyAddress = $address;
                                            $productTypeID   = $res['TransactionProductType']['ProductTypeID'];
                                            $primary_owner   = ($res['Buyers'][0]['Primary']['First'] && $res['Buyers'][0]['Primary']['First']) ? $res['Buyers'][0]['Primary']['First'] : '';
                                            $primary_owner .= ($res['Buyers'][0]['Primary']['Middle'] && $res['Buyers'][0]['Primary']['Middle']) ? " " . $res['Buyers'][0]['Primary']['Middle'] : '';
                                            $primary_owner .= ($res['Buyers'][0]['Primary']['Last'] && $res['Buyers'][0]['Primary']['Last']) ? " " . $res['Buyers'][0]['Primary']['Last'] : '';
                                            $secondary_owner = ($res['Buyers'][0]['Secondary']['First'] && $res['Buyers'][0]['Secondary']['First']) ? $res['Buyers'][0]['Secondary']['First'] : '';
                                            $secondary_owner .= ($res['Buyers'][0]['Secondary']['Middle'] && $res['Buyers'][0]['Secondary']['Middle']) ? $res['Buyers'][0]['Secondary']['Middle'] : '';
                                            $secondary_owner .= ($res['Buyers'][0]['Secondary']['Last'] && $res['Buyers'][0]['Secondary']['Last']) ? " " . $res['Buyers'][0]['Secondary']['Last'] : '';
                                            $ProductTypeTxt = $res['TransactionProductType']['ProductType'];

                                            if (strpos($ProductTypeTxt, 'Loan') !== false) {
                                                $propertyData['primary_owner']   = $primary_owner;
                                                $propertyData['secondary_owner'] = $secondary_owner;
                                            } elseif (strpos($ProductTypeTxt, 'Sale') !== false) {
                                                $transactionData['borrower']           = $primary_owner;
                                                $transactionData['secondary_borrower'] = $secondary_owner;
                                                $propertyData['primary_owner']         = isset($property_details['primary_owner']) && !empty($property_details['primary_owner']) ? $property_details['primary_owner'] : '';
                                                $propertyData['secondary_owner']       = isset($property_details['secondary_owner']) && !empty($property_details['secondary_owner']) ? $property_details['secondary_owner'] : '';
                                            }

                                            $propertyId    = $this->home_model->insert($propertyData, 'property_details');
                                            $transactionId = $this->home_model->insert($transactionData, 'transaction_details');
                                            $time          = round((int) (str_replace("-0000)/", "", str_replace("/Date(", "", $res['Dates']['OpenedDate']))) / 1000);
                                            $created_date  = date('Y-m-d H:i:s', $time);
                                            $randomString  = $this->order->randomPassword();
                                            $randomString  = md5($randomString);

                                            $completed_date = null;
                                            if (empty($closedDate)) {
                                                if (!empty($res['Dates']['FileCompletedDate'])) {
                                                    $time           = round((int) (str_replace("-0000)/", "", str_replace("/Date(", "", $res['Dates']['FileCompletedDate']))) / 1000);
                                                    $completed_date = date('Y-m-d H:i:s', $time);
                                                }
                                            }

                                            $orderData = [
                                                'customer_id'                => $customerId,
                                                'file_id'                    => $res['FileID'],
                                                'file_number'                => $res['FileNumber'],
                                                'property_id'                => $propertyId,
                                                'transaction_id'             => $transactionId,
                                                'created_at'                 => $created_date,
                                                'prod_type'                  => strtolower($prodType),
                                                'premium'                    => $premium,
                                                'status'                     => 1,
                                                'is_imported'                => 1,
                                                'is_sales_rep_order'         => 1,
                                                'random_number'              => $randomString,
                                                'resware_closed_status_date' => $completed_date,
                                                'resware_status'             => strtolower($res['Status']['Name']),
                                                'sent_to_accounting_date'    => $completed_date,
                                            ];

                                            if (!empty($premium)) {
                                                $orderData['premium'] = (float) $premium;
                                            }

                                            if (!empty($completed_date)) {
                                                $orderData['sent_to_accounting_date'] = $completed_date;
                                            }

                                            $orderId = $this->home_model->insert($orderData, 'order_details');
                                        }
                                    }
                                }
                                if (!empty($escrow_email)) {
                                    $from_name  = 'Pacific Coast Title Company';
                                    $from_mail  = env('FROM_EMAIL');
                                    $email_data = [
                                        'orderNumber'     => $file_number,
                                        'PropertyAddress' => $propertyAddress,
                                        'randomString'    => $randomString,
                                        'headerImg'       => $sales_rep_img,
                                        'currYear'        => CURRENT_YEAR,
                                        'productTypeID'   => $productTypeID,
                                    ];
                                    $borrower_message_body = $this->load->view('emails/borrower.php', $email_data, true);
                                    $message_body          = $borrower_message_body;
                                    $subject               = $file_number . ' - Borrower Verification';
                                    //$escrow_email = 'hitesh.p@crestinfosystems.com';
                                    $mailParams = [
                                        'from_mail' => $from_mail,
                                        'from_name' => $from_name,
                                        'to'        => $escrow_email,
                                        'subject'   => $subject,
                                        'message'   => json_encode($email_data),
                                    ];
                                    $logid = $this->apiLogs->syncLogs(0, 'sendgrid', 'send_mail_to_escrow_officer', '', $mailParams, [], $orderId, 0);
                                    //$escrow_mail_result = send_email($from_mail,$from_name, $escrow_email, $subject, $message_body);
                                    $this->apiLogs->syncLogs(0, 'sendgrid', 'send_mail_to_escrow_officer', '', $mailParams, ['status' => $escrow_mail_result], $orderId, $logid);
                                }
                            }
                        }
                        $row++;
                    }
                    fclose($handle);
                }
                $documentName = pathinfo($filePath);
                $fileName     = date('YmdHis') . "_" . $documentName['basename'];
                rename(FCPATH . "/uploads/open-closed-orders/" . $documentName['basename'], FCPATH . "/uploads/open-closed-orders/" . $fileName);
                $this->order->uploadDocumentOnAwsS3($fileName, 'open-closed-orders', 1);
            }
        } else {
            echo "No files found";exit;
        }
        echo "All data exported successfully";exit;
    }

    public function sendMailEscrowUsersForBorrowerVerification()
    {
        $this->db->select('order_details.file_id,
            order_details.file_number,
            order_details.id as orderId,
            order_details.random_number,
            property_details.address,
            pct_order_partner_company_info.email,
            transaction_details.sales_representative');
        $this->db->from('order_details');
        $this->db->where('((order_details.resware_status != "closed" AND order_details.resware_status != "cancelled") OR order_details.resware_status IS NULL)');
        $this->db->where('transaction_details.purchase_type = 4');
        $this->db->where('order_details.escrow_officer_id IS NOT NULL');
        $this->db->where('order_details.borrower_information_document_name IS NULL');
        $this->db->where('order_details.file_number IN (10231167,10232453,10232646,10230875,10231110,10231114,10231186,10231250,10231659,10231758,10231974,10231981,10231999,10232000,10232286,10232287,10232400,10232448,10232543,10232547,10232595,10232597)');
        $this->db->join('property_details', 'order_details.property_id = property_details.id', 'inner');
        $this->db->join('transaction_details', 'order_details.transaction_id = transaction_details.id', 'inner');
        $this->db->join('pct_order_partner_company_info', 'pct_order_partner_company_info.partner_id = order_details.escrow_officer_id', 'inner');
        $query  = $this->db->get();
        $result = $query->result_array();

        if (!empty($result)) {
            foreach ($result as $res) {
                $salesRepDetails = [];
                if (!empty($res['sales_representative'])) {
                    $condition = [
                        'id' => $res['sales_representative'],
                    ];
                    $salesRepDetails = $this->home_model->getSalesRepDetails($condition);
                }

                $sales_rep_img = isset($salesRepDetails["sales_rep_profile_img"]) && !empty($salesRepDetails["sales_rep_profile_img"]) ? $salesRepDetails["sales_rep_profile_img"] : '';
                if (!empty($sales_rep_img)) {
                    $sales_rep_img = env('AWS_PATH') . str_replace('uploads/', '', $sales_rep_img);
                }
                $email_data = [
                    'orderNumber'     => $res['file_number'],
                    'PropertyAddress' => $res['address'],
                    'randomString'    => $res['random_number'],
                    'headerImg'       => $sales_rep_img,
                    'currYear'        => CURRENT_YEAR,
                    'productTypeID'   => 4,
                ];

                $borrower_message_body = $this->load->view('emails/borrower.php', $email_data, true);
                $from_name             = 'Pacific Coast Title Company';
                $from_mail             = env('FROM_EMAIL');

                $message_body = $borrower_message_body;
                $subject      = $res['file_number'] . ' - Borrower Verification';
                $to           = $res['email'];
                $cc           = ['ghernandez@pct.com'];
                //$cc = array();
                //$to = 'hitesh.p@crestinfosystems.com';
                $mailParams = [
                    'from_mail' => $from_mail,
                    'from_name' => $from_name,
                    'to'        => $to,
                    'subject'   => $subject,
                    'message'   => json_encode($email_data),
                ];

                $logid = $this->apiLogs->syncLogs(0, 'sendgrid', 'send_mail_to_escrow_officer', '', $mailParams, [], $res['orderId'], 0);
                $this->load->helper('sendemail');
                $escrow_mail_result = send_email($from_mail, $from_name, $to, $subject, $message_body, [], $cc);
                $this->apiLogs->syncLogs(0, 'sendgrid', 'send_mail_to_escrow_officer', '', $mailParams, ['status' => $escrow_mail_result], $res['orderId'], $logid);
            }
        }
    }

    public function importOrdersUsingFileNumber()
    {
        $ordersInfo = [
            [
                'file_number'  => 10231167,
                'sales_person' => 'Jared Armas',
            ],
            [
                'file_number'  => 10232453,
                'sales_person' => 'Malay Wadhwa',
            ],
            [
                'file_number'  => 10232646,
                'sales_person' => 'Jared Armas',
            ],
            [
                'file_number'  => 10230875,
                'sales_person' => 'Lisa Lee',
            ],
            [
                'file_number'  => 10231110,
                'sales_person' => 'Max Galindo',
            ],
            [
                'file_number'  => 10231114,
                'sales_person' => 'Max Galindo',
            ],
            [
                'file_number'  => 10231186,
                'sales_person' => 'Louis Morreale',
            ],
            [
                'file_number'  => 10231250,
                'sales_person' => 'Cibeli Tregembo',
            ],
            [
                'file_number'  => 10231659,
                'sales_person' => 'Jared Armas',
            ],
            [
                'file_number'  => 10231758,
                'sales_person' => 'Jared Armas',
            ],
            [
                'file_number'  => 10231974,
                'sales_person' => 'Max Galindo',
            ],
            [
                'file_number'  => 10231981,
                'sales_person' => 'Daphne Alt',
            ],
            [
                'file_number'  => 10231999,
                'sales_person' => 'Cibeli Tregembo',
            ],
            // array(
            //     'file_number' => 10232000,
            //     'sales_person' => 'In House - SoCal Ventura',
            // ),
            [
                'file_number'  => 10232286,
                'sales_person' => 'Jared Armas',
            ],
            [
                'file_number'  => 10232287,
                'sales_person' => 'Cibeli Tregembo',
            ],
            [
                'file_number'  => 10232400,
                'sales_person' => 'Justin Nouri',
            ],
            [
                'file_number'  => 10232448,
                'sales_person' => 'Cibeli Tregembo',
            ],
            [
                'file_number'  => 10232543,
                'sales_person' => 'Louis Morreale',
            ],
            [
                'file_number'  => 10232547,
                'sales_person' => 'Louis Morreale',
            ],
        ];
        foreach ($ordersInfo as $orderInfo) {
            $data               = [];
            $data['FileNumber'] = $orderInfo['file_number'];
            $this->db->select('*');
            $this->db->from('order_details');
            $this->db->where('file_number', $orderInfo['file_number']);
            $query        = $this->db->get();
            $resultorders = $query->row_array();

            $sales_rep_name = explode(' ', $orderInfo['sales_person']);
            $this->db->select('*');
            $this->db->from('customer_basic_details');
            $this->db->like('first_name', $sales_rep_name[0]);
            $this->db->like('last_name', $sales_rep_name[1]);
            $this->db->where('is_sales_rep', 1);
            $query       = $this->db->get();
            $salesResult = $query->row_array();

            if (empty($resultorders)) {
                $data     = json_encode(['FileNumber' => $orderInfo['file_number']]);
                $userData = [
                    'admin_api' => 1,
                ];
                $logid = $this->apiLogs->syncLogs(0, 'resware', 'get_order_information', env('RESWARE_ORDER_API') . 'files/search', $data, [], 0, 0);
                $res   = $this->make_request('POST', 'files/search', $data, $userData);
                $this->apiLogs->syncLogs(0, 'resware', 'get_order_information', env('RESWARE_ORDER_API') . 'files/search', $data, $res, 0, $logid);
                $result = json_decode($res, true);

                if (isset($result['Files']) && !empty($result['Files'])) {
                    foreach ($result['Files'] as $res) {
                        $partner_fname = $res['Partners'][0]['PrimaryEmployee']['FirstName'];
                        $partner_lname = $res['Partners'][0]['PrimaryEmployee']['LastName'];
                        $partner_name  = $res['Partners'][0]['PartnerName'];
                        $condition     = [
                            'first_name'   => $partner_fname,
                            'last_name'    => $partner_lname,
                            'company_name' => $partner_name,
                            'is_pass'      => $partner_name,
                        ];
                        $user_details = $this->home_model->get_user_by_name($condition);
                        $customerId   = 0;

                        if (isset($user_details) && !empty($user_details)) {
                            $customerId = $user_details['id'];
                        }

                        $FullProperty = $res['Properties'][0]['StreetNumber'] . " " . $res['Properties'][0]['StreetDirection'] . " " . $res['Properties'][0]['StreetName'] . " " . $res['Properties'][0]['StreetSuffix'] . ", " . $res['Properties'][0]['City'] . ", " . $res['Properties'][0]['State'] . ", " . $res['Properties'][0]['Zip'];
                        $address      = $res['Properties'][0]['StreetNumber'] . " " . $res['Properties'][0]['StreetDirection'] . " " . $res['Properties'][0]['StreetName'] . " " . $res['Properties'][0]['StreetSuffix'];
                        $locale       = $res['Properties'][0]['City'];

                        if (($locale)) {
                            if (!empty($res['Properties'][0]['State'])) {
                                $locale .= ', ' . $res['Properties'][0]['State'];
                            } else {
                                $locale .= ', CA';
                            }
                        }

                        $property_details = $this->getSearchResult($address, $locale);

                        $property_type    = isset($property_details['property_type']) && !empty($property_details['property_type']) ? $property_details['property_type'] : '';
                        $LegalDescription = isset($property_details['legaldescription']) && !empty($property_details['legaldescription']) ? $property_details['legaldescription'] : '';
                        $apn              = isset($property_details['apn']) && !empty($property_details['apn']) ? $property_details['apn'] : '';

                        $propertyData = [
                            'customer_id'       => $customerId,
                            'buyer_agent_id'    => 0,
                            'listing_agent_id'  => 0,
                            'escrow_lender_id'  => 0,
                            'parcel_id'         => $res['Properties'][0]['ParcelID'],
                            'address'           => removeMultipleSpace($address),
                            'city'              => $res['Properties'][0]['City'],
                            'state'             => $res['Properties'][0]['State'],
                            'zip'               => $res['Properties'][0]['Zip'],
                            'property_type'     => $property_type,
                            'full_address'      => removeMultipleSpace($FullProperty),
                            'apn'               => $apn,
                            'county'            => $res['Properties'][0]['County'],
                            'legal_description' => $LegalDescription,
                            'status'            => 1,
                        ];

                        $transactionData = [
                            'customer_id'          => $customerId,
                            'sales_amount'         => !empty($res['SalesPrice']) ? $res['SalesPrice'] : 0,
                            'loan_number'          => !empty($res['Loans'][0]['LoanNumber']) ? $res['Loans'][0]['LoanNumber'] : 0,
                            'loan_amount'          => !empty($res['Loans'][0]['LoanAmount']) ? $res['Loans'][0]['LoanAmount'] : 0,
                            'transaction_type'     => $res['TransactionProductType']['TransactionTypeID'],
                            'purchase_type'        => $res['TransactionProductType']['ProductTypeID'],
                            'sales_representative' => !empty($salesResult) ? $salesResult['id'] : 0,
                            'status'               => 1,
                        ];

                        $primary_owner = ($res['Buyers'][0]['Primary']['First'] && $res['Buyers'][0]['Primary']['First']) ? $res['Buyers'][0]['Primary']['First'] : '';
                        $primary_owner .= ($res['Buyers'][0]['Primary']['Middle'] && $res['Buyers'][0]['Primary']['Middle']) ? " " . $res['Buyers'][0]['Primary']['Middle'] : '';
                        $primary_owner .= ($res['Buyers'][0]['Primary']['Last'] && $res['Buyers'][0]['Primary']['Last']) ? " " . $res['Buyers'][0]['Primary']['Last'] : '';
                        $secondary_owner = ($res['Buyers'][0]['Secondary']['First'] && $res['Buyers'][0]['Secondary']['First']) ? $res['Buyers'][0]['Secondary']['First'] : '';
                        $secondary_owner .= ($res['Buyers'][0]['Secondary']['Middle'] && $res['Buyers'][0]['Secondary']['Middle']) ? $res['Buyers'][0]['Secondary']['Middle'] : '';
                        $secondary_owner .= ($res['Buyers'][0]['Secondary']['Last'] && $res['Buyers'][0]['Secondary']['Last']) ? " " . $res['Buyers'][0]['Secondary']['Last'] : '';
                        $ProductTypeTxt = $res['TransactionProductType']['ProductType'];

                        if (strpos($ProductTypeTxt, 'Loan') !== false) {
                            $propertyData['primary_owner']   = $primary_owner;
                            $propertyData['secondary_owner'] = $secondary_owner;
                        } elseif (strpos($ProductTypeTxt, 'Sale') !== false) {
                            $transactionData['borrower']           = $primary_owner;
                            $transactionData['secondary_borrower'] = $secondary_owner;
                            $propertyData['primary_owner']         = isset($property_info['primary_owner']) && !empty($property_info['primary_owner']) ? $property_info['primary_owner'] : '';
                            $propertyData['secondary_owner']       = isset($property_info['secondary_owner']) && !empty($property_info['secondary_owner']) ? $property_info['secondary_owner'] : '';
                        }

                        $propertyId    = $this->home_model->insert($propertyData, 'property_details');
                        $transactionId = $this->home_model->insert($transactionData, 'transaction_details');
                        $time          = round((int) (str_replace("-0000)/", "", str_replace("/Date(", "", $res['Dates']['OpenedDate']))) / 1000);
                        $created_date  = date('Y-m-d H:i:s', $time);
                        $randomString  = $this->order->randomPassword();

                        $randomString = md5($randomString);

                        if ($orderInfo['file_number'] == 10231167 || $orderInfo['file_number'] == 10232453 || $orderInfo['file_number'] == 10232646) {
                            $escrow_officer_id = 318384;
                        } else {
                            $escrow_officer_id = 304961;
                        }

                        $orderData = [
                            'customer_id'        => $customerId,
                            'file_id'            => $res['FileID'],
                            'file_number'        => $res['FileNumber'],
                            'property_id'        => $propertyId,
                            'transaction_id'     => $transactionId,
                            'created_at'         => $created_date,
                            'status'             => 1,
                            'is_imported'        => 1,
                            'is_sales_rep_order' => 0,
                            'escrow_officer_id'  => $escrow_officer_id,
                            'random_number'      => $randomString,
                            'resware_status'     => strtolower($res['Status']['Name']),
                        ];

                        $this->home_model->insert($orderData, 'order_details');
                    }
                }
            } else {
                if ($orderInfo['file_number'] == 10231167 || $orderInfo['file_number'] == 10232453 || $orderInfo['file_number'] == 10232646) {
                    $escrow_officer_id = 318384;
                } else {
                    $escrow_officer_id = 304961;
                }

                $condition = [
                    'file_number' => $orderInfo['FileNumber'],
                ];

                $orderData = [
                    'escrow_officer_id' => $escrow_officer_id,
                ];

                $this->home_model->update($orderData, $condition, 'order_details');

                $transCondition = [
                    'id' => $resultorders['transaction_id'],
                ];

                $transData = [
                    'sales_representative' => !empty($salesResult) ? $salesResult['id'] : 0,
                ];

                $this->home_model->update($transData, $transCondition, 'transaction_details');
            }
        }
        echo "All orders imported successfully.";exit;
    }

    public function passwordUpdateAll()
    {
        $this->load->model('order/apiLogs');
        $this->load->library('order/resware');
        $this->load->library('order/order');
        $this->db->select('*');
        $this->db->from('customer_basic_details');
        $this->db->where('(is_password_updated = 0 and random_password != "")');
        $query  = $this->db->get();
        $result = $query->result_array();

        if (!empty($result)) {
            foreach ($result as $customerData) {
                $endPoint = 'admin/partners/' . $customerData['partner_id'] . '/employees/' . $customerData['resware_user_id'];
                $method   = 'PUT';
                $apiType  = 'update_user';

                $newUserData = [
                    'Password'               => 'Pacific1',
                    'Enabled'                => true,
                    'Roles'                  => [
                        0  => [
                            'RoleID' => 5033,
                            'Name'   => 'Web Services: Access All Files for ResWare-to-ResWare Services',
                        ],
                        1  => [
                            'RoleID' => 6013,
                            'Name'   => 'Web Services: Add Actions',
                        ],
                        2  => [
                            'RoleID' => 6005,
                            'Name'   => 'Web Services: Add Documents',
                        ],
                        3  => [
                            'RoleID' => 6002,
                            'Name'   => 'Web Services: Add Notes',
                        ],
                        4  => [
                            'RoleID' => 6009,
                            'Name'   => 'Web Services: Add Partners',
                        ],
                        5  => [
                            'RoleID' => 6015,
                            'Name'   => 'Web Services: Add WebURL Documents',
                        ],
                        6  => [
                            'RoleID' => 5027,
                            'Name'   => 'Web Services: Bypass Address Validation',
                        ],
                        7  => [
                            'RoleID' => 6003,
                            'Name'   => 'Web Services: Cancel Files',
                        ],
                        8  => [
                            'RoleID' => 5023,
                            'Name'   => 'Web Services: Estimate Costs as 2010 HUD',
                        ],
                        9  => [
                            'RoleID' => 6016,
                            'Name'   => 'Web Services: Expense Reports',
                        ],
                        10 => [
                            'RoleID' => 6012,
                            'Name'   => 'Web Services: Get Actions',
                        ],
                        11 => [
                            'RoleID' => 6007,
                            'Name'   => 'Web Services: Get Custom Fields',
                        ],
                        12 => [
                            'RoleID' => 6006,
                            'Name'   => 'Web Services: Get Documents',
                        ],
                        13 => [
                            'RoleID' => 6001,
                            'Name'   => 'Web Services: Get Notes',
                        ],
                        14 => [
                            'RoleID' => 6010,
                            'Name'   => 'Web Services: Get Partners',
                        ],
                        15 => [
                            'RoleID' => 69,
                            'Name'   => 'Web Services: Order Placement',
                        ],
                        16 => [
                            'RoleID' => 6004,
                            'Name'   => 'Web Services: Override Property Address Validation and Reformatting',
                        ],
                        17 => [
                            'RoleID' => 6011,
                            'Name'   => 'Web Services: Remove Partners',
                        ],
                        18 => [
                            'RoleID' => 6014,
                            'Name'   => 'Web Services: Search Files',
                        ],
                        19 => [
                            'RoleID' => 6019,
                            'Name'   => 'Web Services: Update Partner',
                        ],
                        20 => [
                            'RoleID' => 6008,
                            'Name'   => 'Web Services: Write Custom Fields',
                        ],
                        21 => [
                            'RoleID' => 51,
                            'Name'   => 'Website',
                        ],
                    ],
                    'WebsiteAccess'          => true,
                    'Name'                   => $customerData['email_address'],
                    'PasswordExpirationDate' => '/Date(3025656585000-0000)/',
                    'FirstName'              => $customerData['first_name'],
                    'LastName'               => $customerData['last_name'],
                    'ContactInformation'     => [
                        'EmailAddress' => $customerData['email_address'],
                    ],
                ];

                $userdata['admin_api'] = 1;
                $newUserData           = json_encode($newUserData);
                $logid                 = $this->apiLogs->syncLogs(0, 'resware', $apiType, env('RESWARE_ORDER_API') . $endPoint, $newUserData, [], 0, 0);
                $res                   = $this->make_request($method, $endPoint, $newUserData, $userdata);

                $this->apiLogs->syncLogs(0, 'resware', $apiType, env('RESWARE_ORDER_API') . $endPoint, $newUserData, $res, 0, $logid);

                if (isset($res) && !empty($res)) {
                    $response = json_decode($res, true);
                    if (isset($response['Employee']) && !empty($response['Employee'])) {
                        $res = [
                            'resware_user_id' => $response['Employee']['UserID'],
                            'msg'             => !empty($customerData['resware_user_id']) ? 'User created successfully on Resware Side' : 'User updated successfully on Resware Side',
                            'success'         => true,
                        ];
                        $customerDataUpdate                    = [];
                        $customerDataUpdate['resware_user_id'] = $response['Employee']['UserID'];
                        $customerDataUpdate['random_password'] = $this->order->randomPassword();
                        $reswareUpdatePwdData                  = [
                            'user_name'    => $customerData['email_address'],
                            'password'     => 'Pacific1',
                            'new_password' => $customerDataUpdate['random_password'],
                        ];
                        $logid           = $this->apiLogs->syncLogs($userdata['id'], 'resware', 'change_password', env('RESWARE_UPDATE_PWD_API'), $reswareUpdatePwdData, [], 0, 0);
                        $updatePwdResult = $this->updatePasswordResware($reswareUpdatePwdData);
                        $this->apiLogs->syncLogs($userdata['id'], 'resware', 'change_password', env('RESWARE_UPDATE_PWD_API'), $reswareUpdatePwdData, $updatePwdResult, 0, $logid);
                        $responsePwd = json_decode($updatePwdResult, true);

                        if (!empty($responsePwd['message'])) {
                            $customerDataUpdate['resware_error_msg'] = $responsePwd['message'];
                        } else {
                            $customerDataUpdate['is_password_updated'] = 1;
                        }
                        $updateCondition = [
                            'id' => $customerData['id'],
                        ];
                        $this->home_model->update($customerDataUpdate, $updateCondition, 'customer_basic_details');
                    }
                }
            }
        }
    }

    public function updatePasswordResware($postData)
    {
        $body_params = http_build_query($postData);
        $ch          = curl_init(env('RESWARE_UPDATE_PWD_API'));
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($ch, CURLOPT_FAILONERROR, 1);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $body_params);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_MAXREDIRS, 10);
        $result = curl_exec($ch);
        return $result;
    }

    public function updateAllOrderStatus()
    {
        echo date('Y-m-d H:i:s') . "<br>";
        $sftp     = new SFTP(env('SFTP_HOST'));
        $username = env('SFTP_USERNAME');
        $password = env('SFTP_PASSWORD');

        if (! $sftp->login($username, $password)) {
            exit('Login Failed');
        }

        if (! ($files = $sftp->nlist('/' . env('SFTP_FOLDER') . '/order-status/', true))) {
            die("Cannot read directory contents");
        }

        foreach ($files as $file) {
            if ($file != '.' && $file != '..' && $file != '.protected') {
                if (! is_dir('uploads/order-status')) {
                    mkdir('./uploads/order-status', 0777, true);
                }
                $ext = pathinfo($file, PATHINFO_EXTENSION);
                if (!empty($ext)) {
                    $sftp->get(env("SFTP_FOLDER") . '/order-status/' . $file, FCPATH . 'uploads/order-status/' . trim($file));
                    chmod(FCPATH . 'uploads/order-status/' . $file, 0755);
                } else {
                    $sftp->get(env("SFTP_FOLDER") . '/order-status/' . $file, FCPATH . 'uploads/order-status/' . trim($file) . '.csv');
                    chmod(FCPATH . 'uploads/order-status/' . trim($file) . '.csv', 0755);
                }
                $sftp->delete(env("SFTP_FOLDER") . '/order-status/' . $file);
            }
        }

        /** get all sales reps */
        $this->db->select("id, LOWER(CONCAT_WS(' ', first_name, last_name)) AS sales_name, LOWER(email_address) as email");
        $this->db->from('customer_basic_details');
        $this->db->where('is_sales_rep', 1);
        $query      = $this->db->get();
        $salesUsers = $query->result_array();
        /** End get all sales reps */
        $files = glob("uploads/order-status/*csv", GLOB_NOSORT);

        $closedFileNumbers = [];
        if (is_array($files) && count($files) > 0) {
            foreach ($files as $filePath) {
                $row                    = 1;
                $headerColumns          = [];
                $updateArray            = [];
                $duplicationUpdateArray = [];
                if (($handle = fopen($filePath, "r")) !== false) {
                    while (($data = fgetcsv($handle, 1000, ",", '"')) !== false) {
                        $num = count($data);
                        if ($row == 1) {
                            for ($c = 0; $c < $num; $c++) {
                                $headerColumns[] = trim($data[$c]);
                            }
                        }

                        $file_number  = '';
                        $fileStatus   = '';
                        $closedDate   = '';
                        $loan_amount  = '';
                        $sales_amount = '';
                        $prodType     = '';
                        $salesRepId   = 0;

                        if (in_array('File Number', $headerColumns)) {
                            $fileKey     = array_search("File Number", $headerColumns);
                            $file_number = $data[$fileKey];
                        }

                        if (in_array('File Status', $headerColumns)) {
                            $fileStatusKey = array_search("File Status", $headerColumns);
                            $fileStatus    = $data[$fileStatusKey];
                        }

                        if (in_array('Closed Date', $headerColumns)) {
                            $closedDateKey = array_search("Closed Date", $headerColumns);
                            $closedDate    = $data[$closedDateKey];
                        }

                        if (in_array('Loan Amount', $headerColumns)) {
                            $loanAmountKey = array_search("Loan Amount", $headerColumns);
                            $loan_amount   = $data[$loanAmountKey];
                        }

                        if (in_array('Sales Price', $headerColumns)) {
                            $salePriceKey = array_search("Sales Price", $headerColumns);
                            $sales_amount = $data[$salePriceKey];
                        }

                        if (in_array('Prod Type', $headerColumns)) {
                            $prodkey  = array_search("Prod Type", $headerColumns);
                            $prodType = $data[$prodkey];
                        }

                        /** Check and update sales rep logic */
                        if (in_array('Email', $headerColumns)) {
                            $emailkey    = array_search("Email", $headerColumns);
                            $sales_email = strtolower(trim($data[$emailkey]));
                            if (!empty($sales_email)) {
                                $saleUserKey = array_search($sales_email, array_column($salesUsers, 'email'));
                                if (isset($saleUserKey) && !empty($saleUserKey)) {
                                    $salesRepId = $salesUsers[$saleUserKey]['id'];
                                }
                            }
                        }

                        if ($salesRepId == 0) {
                            $salesRepName = '';
                            if (in_array('Sales Rep', $headerColumns)) {
                                $saleskey     = array_search("Sales Rep", $headerColumns);
                                $salesRepName = strtolower(trim(preg_replace('/\s+/', ' ', $data[$saleskey])));
                                if (!empty($salesRepName)) {
                                    $saleUserKey = array_search($salesRepName, array_column($salesUsers, 'sales_name'));
                                    if (isset($saleUserKey) && !empty($saleUserKey)) {
                                        $salesRepId = $salesUsers[$saleUserKey]['id'];
                                    }
                                }
                            }
                        }
                        /** End Check and update sales rep logic */

                        if ($row != 1) {
                            if (1 === preg_match('~[0-9]~', $file_number)) {
                                $completed_date = null;
                                if (!empty($closedDate)) {
                                    $myDateTime     = DateTime::createFromFormat('M d, Y', $closedDate);
                                    $completed_date = $myDateTime->format('Y-m-d H:i:s');
                                }
                                if (strtolower($fileStatus) == 'closed') {
                                    if (isset($completed_date) && (date('Y', strtotime($completed_date)) == date('Y')) && (date('m', strtotime($completed_date)) == date('m'))) {
                                        if (strtolower($prodType) == 'sale' || strtolower($prodType) == 'loan') {
                                            if (! in_array($file_number, $closedFileNumbers)) {
                                                $closedFileNumbers[] = (int) $file_number;
                                            }
                                        }
                                    }
                                }

                                $updateArray[] = [
                                    'file_number'                => (int) $file_number,
                                    'resware_status'             => strtolower($fileStatus),
                                    'resware_closed_status_date' => strtolower($fileStatus) == 'closed' ? $completed_date : null,
                                    'loan_amount'                => (int) $loan_amount,
                                    'sales_amount'               => (int) $sales_amount,
                                    'updated_at'                 => date('Y-m-d H:i:s'),
                                ];

                                $this->db->from('order_details as o');
                                $this->db->select('o.file_number, o.transaction_id, transaction_details.sales_representative');
                                $this->db->join('transaction_details', 'o.transaction_id = transaction_details.id', 'inner');
                                $this->db->where('o.file_number', $file_number);
                                $query        = $this->db->get();
                                $salesDetails = $query->row_array();
                                if ($salesDetails['sales_representative'] != $salesRepId) {
                                    $updateData = ['sales_representative' => $salesRepId];

                                    $this->db->set($updateData);
                                    $this->db->where('id', $salesDetails['transaction_id']);
                                    $this->db->update('transaction_details');
                                    /** Save user Activity */
                                    $activity = 'Sales rep changed from update order status cron from :- ' . $salesDetails['sales_representative'] . ' to :- ' . $salesRepId . ' For order number: ' . $file_number;
                                    $this->order->logAdminActivity($activity);
                                    /** End Save user activity */
                                }
                            }
                        }
                        $row++;
                    }
                    fclose($handle);

                    if (!empty($updateArray)) {
                        $chunk1 = array_chunk($updateArray, 100);
                        for ($i = 0; $i < count($chunk1); $i++) {
                            $this->db->update_batch('order_details', $chunk1[$i], 'file_number') . "<br>";
                        }
                    }
                }

                $updateData = ['resware_status' => 'open'];
                $this->db->set($updateData);
                $this->db->where('lp_file_number IS NOT NULL');
                $this->db->where('file_number', 0);
                $this->db->update('order_details');

                $documentName = pathinfo($filePath);
                $fileName     = date('YmdHis') . "_" . $documentName['basename'];
                rename(FCPATH . "/uploads/order-status/" . $documentName['basename'], FCPATH . "/uploads/order-status/" . $fileName);
                $this->order->uploadDocumentOnAwsS3($fileName, 'order-status', 1);

                if (!empty($closedFileNumbers)) {
                    // $param = $closedFileNumbers;
                    // $command = "php ".FCPATH."index.php frontend/order/cron sendThankYouEmailForClosedOrder $param";
                    // if (substr(php_uname(), 0, 7) == "Windows"){
                    //     pclose(popen("start /B ". $command, "r"));
                    // }
                    // else {
                    //     exec($command . " > /dev/null &");
                    // }

                    /** Commented this function to avoid duplicate email suggested by Jerry on 10/05/2024 */
                    // $this->sendThankYouEmailForClosedOrder($closedFileNumbers);

                    $this->sendEmailForClosedOrder($closedFileNumbers);

                }
                echo "All orders status updated successfully" . "<br>";
                $this->updateAllowDuplicationFlag();
                echo date('Y-m-d H:i:s');exit;
            }
        } else {
            echo "No files found";exit;
        }
    }

    public function updateAllSoftProOrderStatus()
    {
        $this->load->library('order/softPro');
        $this->load->model('order/apiLogs');
        ini_set('max_execution_time', 0);
        ini_set('memory_limit', '2048M');
        $req['DateFrom'] = '';
        if (isset($_GET['DateFrom'])) {
            if (!empty($_GET['DateFrom'])) {
                $startDate = date('m-d-Y', strtotime($_GET['DateFrom']));
                $req['DateFrom'] = $startDate;
            }
        }

        $req['DateTo'] = '';
        if (isset($_GET['DateTo'])) {
            if (!empty($_GET['DateTo'])) {
                $endDate = date('m-d-Y', strtotime($_GET['DateTo']));
                $req['DateTo'] = $endDate;
            }
        }

        if (empty($_GET)) {
            $startDate = date('01-03-2025');
            $endDate = date('d-m-Y');
            $req['DateFrom'] = $startDate;
            $req['DateTo'] = $endDate;
        }

        $dateIntervalQueryParams = $this->getDateIntervals($startDate, $endDate, 10);
        // echo "<pre>";
        // print_r($dateIntervalQueryParams);die;
        $apiEndPoints = SOFTPRO_API_END;

        foreach ($dateIntervalQueryParams as $key => $range) {
            $reqData = $queryParams = $range;
            $reqUrl  = getenv("SOFT_PRO_API") . $apiEndPoints['get_all_order_status'] . '?'.$queryParams;
            $logid = $this->apiLogs->syncLogs($userdata['id'], 'softpro', 'get_all_order_status', $reqUrl, $reqData, [], 0, 0);
            $response    = $this->softpro->make_request('GET', 'get_all_order_status', $reqData, $queryParams);
            $this->apiLogs->syncLogs($userdata['id'], 'softpro', 'get_all_order_status', $reqUrl, $reqData, json_encode($response), 0, $logid);
            
            // $response = json_decode($result, true);
            if ($response['status'] == 'success' && isset($response['data']) && !empty($response['data'])) {
                // Get existing emails from the database
                $orderData   = $response['data'];
                
                $updateArray = [];
                foreach ($orderData as $key => $order) {
                    $file_number = '';
                    $fileStatus  = '';
                    $closedDate  = '';
                    $completedDate  = '';
    
                    $file_number = $order['OrderNumber'];
                    $fileStatus  = strtolower($order['OrderStatus']);
                    $completedDate  = $order['CompletedDate'] ?? '';
                    $closedDate  = ($fileStatus == 'closed') ? $order['LastModifiedOn'] : '';
    
                    // print_r($order);die;
                    $completed_date = null;
                    $order_closed_date = null;
                    if (!empty($completedDate)) {
                        $myDateTime     = DateTime::createFromFormat('m/d/Y h:i:s A', $completedDate);
                        $completed_date = $myDateTime->format('Y-m-d H:i:s');
                    }

                    if (!empty($closedDate)) {
                        $myDateTime     = DateTime::createFromFormat('m/d/Y h:i:s A', $closedDate);
                        $order_closed_date = $myDateTime->format('Y-m-d H:i:s');
                    }
                    // echo "<pre>";
                    // print_r($completed_date);die;
    
                    $orderCondition = array(
                            'file_number' => $file_number
                    );
                    $orderDetails = $this->order->get_order_details_with_buyeragent($orderCondition);
                    if (strtolower($orderDetails['softpro_status']) != $fileStatus) {
                        $updateArray = [
                            'file_number'                => $file_number,
                            'softpro_status'             => $fileStatus,
                            'order_completed_date' => ($fileStatus == 'completed') ? $completed_date : null,
                            // 'resware_closed_status_date' => strtolower($fileStatus) == 'closed' ? $completed_date : null,
                            // 'sent_to_accounting_date'    => strtolower($fileStatus) == 'closed' ? $completed_date : null,
                            'updated_at'                 => date('Y-m-d H:i:s'),
                        ];

                        if ($orderDetails['softpro_status'] != 'closed' && $fileStatus == 'closed') {
                            $updateArray['resware_closed_status_date'] = $order_closed_date;
                        }

                        if (($orderDetails['softpro_status'] == 'closed' && $fileStatus == 'closed' && empty($orderDetails['resware_closed_status_date']))) {
                            $updateArray['resware_closed_status_date'] = $order_closed_date;
                        }

                        if ($orderDetails['softpro_status'] == 'completed' && empty($orderDetails['resware_closed_status_date'])) {
                            $updateArray['resware_closed_status_date'] = $completed_date;
                        }

                        $this->home_model->update($updateArray, $orderCondition, 'order_details');
                        if (!in_array($file_number, $closedFileNumbers) && ($fileStatus == 'closed')) {
                            $closedFileNumbers[] = $file_number;
                        }
                    }

                    
                    // if (!empty($orderDetails) && $orderDetails['softpro_status'] != 'closed' && true) {
                        // if (!empty($orderDetails) && $orderDetails['softpro_status'] != 'closed' && strtolower($fileStatus) == 'closed' && $orderDetails['transaction_type'] == 'Purchase') {
                            // $this->sendEmailToBuyerAgent($orderDetails);
                            // }
                }
            }
        }
        if (!empty($closedFileNumbers)) {
            $this->sendEmailForClosedOrder($closedFileNumbers);
        }
        $updateData = ['softpro_status' => 'open'];
        $this->db->set($updateData);
        $this->db->where('lp_file_number IS NOT NULL');
        $this->db->where('file_number', 0);
        $this->db->update('order_details');
        echo json_encode(['status' => 'success','message' => 'All orders status updated successfully']);exit;




        // $logid = $this->apiLogs->syncLogs($userdata['id'], 'softpro', 'get_all_order_status', 'get_all_order_status', null, [], 0, 0);
        // $response = $this->softpro->make_request('GET', 'get_all_order_status');
        // $this->apiLogs->syncLogs($userdata['id'], 'softpro', 'get_all_order_status', 'get_all_order_status', null, json_encode($response), 0, $logid);
        // $closedFileNumbers = [];
        // if ($response['status'] == 'success') {
        //     // Get existing emails from the database
        //     $orderData   = $response['data'];
        //     $updateArray = [];
        //     foreach ($orderData as $key => $order) {
        //         $file_number = '';
        //         $fileStatus  = '';
        //         $closedDate  = '';

        //         $file_number = $order['OrderNumber'];
        //         $fileStatus  = $order['OrderStatus'];
        //         $closedDate  = $order['LastModifiedOn'];

        //         // print_r($order);die;
        //         $completed_date = null;
        //         if (!empty($closedDate)) {
        //             $myDateTime     = DateTime::createFromFormat('m/d/Y h:i:s A', $closedDate);
        //             $completed_date = $myDateTime->format('Y-m-d H:i:s');
        //         }
        //         // echo "<pre>";
        //         // print_r($completed_date);die;

        //         if (strtolower($fileStatus) == 'closed') {
        //             if (isset($completed_date) && (date('Y', strtotime($completed_date)) == date('Y')) && (date('m', strtotime($completed_date)) == date('m'))) {
        //                 if (!in_array($file_number, $closedFileNumbers)) {
        //                     $closedFileNumbers[] = $file_number;
        //                 }
        //             }
        //         }

        //         $updateArray[] = [
        //             'file_number'                => $file_number,
        //             'softpro_status'             => strtolower($fileStatus),
        //             'resware_closed_status_date' => strtolower($fileStatus) == 'closed' ? $completed_date : null,
        //             // 'resware_closed_status_date' => strtolower($fileStatus) == 'closed' ? $completed_date : null,
        //             'updated_at'                 => date('Y-m-d H:i:s'),
        //         ];
        //     }
        //     // echo "<pre>";
        //     // print_r($updateArray);die;
        //     if (!empty($updateArray)) {
        //         $chunk1 = array_chunk($updateArray, 100);
        //         for ($i = 0; $i < count($chunk1); $i++) {
        //             $this->db->update_batch('order_details', $chunk1[$i], 'file_number') . "<br>";
        //         }
        //     }

        //     $updateData = ['softpro_status' => 'open'];
        //     $this->db->set($updateData);
        //     $this->db->where('lp_file_number IS NOT NULL');
        //     $this->db->where('file_number', 0);
        //     $this->db->update('order_details');

        //     if (!empty($closedFileNumbers)) {
        //         // $this->sendEmailForClosedOrder($closedFileNumbers);

        //     }
            
        //     $this->updateAllowDuplicationFlag();
        //     echo json_encode(['status' => 'success','message' => 'All orders status updated successfully']);exit;

        // }

    }


    public function removeDocServer()
    {
        $this->load->library('order/order');
        $folders          = [];
        $path             = "uploads/";
        $sub_folder       = scandir($path);
        $num              = count($sub_folder);
        $countSyncFiles   = 0;
        $countUnlinkFiles = 0;
        for ($i = 2; $i < $num; $i++) {
            if (is_file($path . $sub_folder[$i])) {
                $fileExist = $this->order->fileExistOrNotOnS3($sub_folder[$i]);
                if ($fileExist) {
                    chmod($path . $sub_folder[$i], 0644);
                    gc_collect_cycles();
                    unlink($path . $sub_folder[$i]);
                    $countUnlinkFiles++;
                } else {
                    $this->order->uploadDocumentOnAwsS3($sub_folder[$i]);
                    $countSyncFiles++;
                }
            } else {
                if ($sub_folder[$i] != 'orders') {
                    $folders[] = $sub_folder[$i];
                }
            }
        }

        foreach ($folders as $folder) {
            $fileSystemIterator = new FilesystemIterator("uploads/" . $folder . "/");
            foreach ($fileSystemIterator as $fileInfo) {
                if ($folder == 'sales-rep' && $fileInfo->getFilename() == 'default.jpg') {
                    continue;
                }
                $fileExist = $this->order->fileExistOrNotOnS3($folder . "/" . $fileInfo->getFilename());
                if ($fileExist) {
                    chmod($path . $folder . "/" . $fileInfo->getFilename(), 0644);
                    gc_collect_cycles();
                    unlink($path . $folder . "/" . $fileInfo->getFilename());
                    $countUnlinkFiles++;
                } else {
                    $this->order->uploadDocumentOnAwsS3($fileInfo->getFilename(), $folder);
                    $countSyncFiles++;
                }
            }
        }
        echo $countSyncFiles . " files synced successfully on S3 <br/>";
        echo $countUnlinkFiles . " files unlinked successfully from server <br/>";
        exit;
    }

    public function sendMessageRecordingConfirmation()
    {
        $this->load->model('order/twilioMessage');
        $this->load->library('order/twilio');
        $sftp     = new SFTP(env('SFTP_HOST'));
        $username = env('SFTP_USERNAME');
        $password = env('SFTP_PASSWORD');

        if (! $sftp->login($username, $password)) {
            exit('Login Failed');
        }

        if (! ($files = $sftp->nlist('/' . env('SFTP_FOLDER') . '/recording-confirmation/', true))) {
            die("Cannot read directory contents");
        }

        foreach ($files as $file) {
            if ($file != '.' && $file != '..' && $file != '.protected') {
                if (! is_dir('uploads/recording-confirmation')) {
                    mkdir('./uploads/recording-confirmation', 0777, true);
                }
                $sftp->get(env("SFTP_FOLDER") . '/recording-confirmation/' . $file, FCPATH . 'uploads/recording-confirmation/' . trim($file) . '.csv');
                chmod(FCPATH . 'uploads/recording-confirmation/' . $file . '.csv', 0755);
                $sftp->delete(env("SFTP_FOLDER") . '/recording-confirmation/' . $file);
            }
        }
        $files = glob("uploads/recording-confirmation/*csv", GLOB_NOSORT);

        if (is_array($files) && count($files) > 0) {
            foreach ($files as $filePath) {
                $row           = 1;
                $headerColumns = [];
                if (($handle = fopen($filePath, "r")) !== false) {
                    while (($data = fgetcsv($handle, 1000, ",", '"')) !== false) {
                        $num = count($data);
                        if ($row == 1) {
                            for ($c = 0; $c < $num; $c++) {
                                $headerColumns[] = trim($data[$c]);
                            }
                        }

                        $file_number  = '';
                        $salesRepName = '';
                        $message      = '';

                        if (in_array('File Number', $headerColumns)) {
                            $fileKey     = array_search("File Number", $headerColumns);
                            $file_number = $data[$fileKey];
                        }

                        $salesRepName = '';
                        if (in_array('Sales Rep', $headerColumns)) {
                            $saleskey     = array_search("Sales Rep", $headerColumns);
                            $salesRepName = $data[$saleskey];
                            $salesRepName = str_replace(' ', '-', $salesRepName);
                            $salesRepName = preg_replace('/[^A-Za-z0-9\-]/', '', $salesRepName);
                            $salesRepName = str_replace('-', ' ', $salesRepName);
                        }

                        if (in_array('Body', $headerColumns)) {
                            $messageKey = array_search("Body", $headerColumns);
                            $message    = $data[$messageKey];
                        }

                        if ($row != 1) {
                            // echo $file_number."---".$salesRepName."--------".$salesRepName."---";exit;
                            $condition = [
                                'where' => [
                                    'file_number' => $file_number,
                                ],
                            ];
                            $order = $this->order->get_order($condition);
                            if (!empty($order)) {
                                $orderDetails = $this->order->get_order_details($order[0]['file_id']);
                                $resultSales  = [];
                                if (!empty($salesRepName) && empty($orderDetails['sales_representative'])) {
                                    $this->db->select('*');
                                    $this->db->from('customer_basic_details');
                                    $this->db->like("CONCAT_WS(' ', first_name, last_name)", $salesRepName);
                                    $this->db->where('is_sales_rep', 1);
                                    $query       = $this->db->get();
                                    $resultSales = $query->row_array();
                                } else {
                                    $this->db->select('*');
                                    $this->db->from('customer_basic_details');
                                    $this->db->where("id", $orderDetails['sales_representative']);
                                    $this->db->where('is_sales_rep', 1);
                                    $query       = $this->db->get();
                                    $resultSales = $query->row_array();
                                }
                                if (!empty($resultSales)) {
                                    if (isset($resultSales['telephone_no']) && !empty($resultSales['telephone_no'])) {
                                        $phoneNumber = $resultSales['telephone_no'];
                                        $sid         = env('TWILIO_SID');
                                        $token       = env('TWILIO_TOKEN');
                                        $from        = env('TWILIO_FROM');
                                        $data        = [
                                            'message'     => $message,
                                            'account_sid' => $sid,
                                            'token'       => $token,
                                            'to'          => $phoneNumber,
                                            'from'        => $from,
                                        ];

                                        $logid = $this->apiLogs->syncLogs('', 'twilio', 'send_message', '', $data, [], 0, 0);

                                        /*try {
                                    $result = $this->twilio->message($phoneNumber, $message, '', array('from' => $from));
                                    $response = $result->toArray();
                                    $response['msg_status'] = 'success';
                                    } catch (Exception $e) {
                                    $response['sid'] = '';
                                    $response['to'] = $phoneNumber;
                                    $response['msg_status'] = 'error';
                                    $response['errorCode'] = $e->getCode();
                                    $response['errorMessage'] = $e->getMessage();
                                    } catch (\Twilio\Exceptions\RestException $e) {
                                    $response['sid'] = '';
                                    $response['to'] = $phoneNumber;
                                    $response['msg_status'] = 'error';
                                    $response['errorCode'] = $e->getCode();
                                    $response['errorMessage'] = $e->getMessage();
                                    }
                                    $this->apiLogs->syncLogs('', 'twilio', 'send_message', '', $data, $response, 0, $logid);

                                    if($response['msg_status'] == 'success') {

                                    $this->home_model->update(array('is_sent_recording_msg_sales_user' => 1), array('file_number' => $file_number), 'order_details');

                                    $data = array(
                                    'message' => $response['body'],
                                    'sent_from' => $response['from'],
                                    'sent_to' => $response['to'],
                                    'status' => $response['status'],
                                    'message_sid' => $response['sid'],
                                    'error_code' => $response['errorCode'],
                                    'error_message' => $response['errorMessage'],
                                    );
                                    $this->twilioMessage->insert($data);
                                    } */
                                    }
                                }
                            } else {
                                $data     = json_encode(['FileNumber' => $file_number]);
                                $userData = [
                                    'admin_api' => 1,
                                ];
                                $logid = $this->apiLogs->syncLogs(0, 'resware', 'get_order_information', env('RESWARE_ORDER_API') . 'files/search', $data, [], 0, 0);
                                $res   = $this->make_request('POST', 'files/search', $data, $userData);
                                $this->apiLogs->syncLogs(0, 'resware', 'get_order_information', env('RESWARE_ORDER_API') . 'files/search', $data, $res, 0, $logid);
                                $result = json_decode($res, true);

                                if (isset($result['Files']) && !empty($result['Files'])) {
                                    foreach ($result['Files'] as $res) {
                                        $partner_fname = $res['Partners'][0]['PrimaryEmployee']['FirstName'];
                                        $partner_lname = $res['Partners'][0]['PrimaryEmployee']['LastName'];
                                        $partner_name  = $res['Partners'][0]['PartnerName'];
                                        $condition     = [
                                            'first_name'   => $partner_fname,
                                            'last_name'    => $partner_lname,
                                            'company_name' => $partner_name,
                                            'is_pass'      => $partner_name,
                                        ];
                                        $user_details = $this->home_model->get_user_by_name($condition);
                                        $customerId   = 0;

                                        if (isset($user_details) && !empty($user_details)) {
                                            $customerId = $user_details['id'];
                                        }

                                        $FullProperty = $res['Properties'][0]['StreetNumber'] . " " . $res['Properties'][0]['StreetDirection'] . " " . $res['Properties'][0]['StreetName'] . " " . $res['Properties'][0]['StreetSuffix'] . ", " . $res['Properties'][0]['City'] . ", " . $res['Properties'][0]['State'] . ", " . $res['Properties'][0]['Zip'];
                                        $address      = $res['Properties'][0]['StreetNumber'] . " " . $res['Properties'][0]['StreetDirection'] . " " . $res['Properties'][0]['StreetName'] . " " . $res['Properties'][0]['StreetSuffix'];
                                        $locale       = $res['Properties'][0]['City'];

                                        if (($locale)) {
                                            if (!empty($res['Properties'][0]['State'])) {
                                                $locale .= ', ' . $res['Properties'][0]['State'];
                                            } else {
                                                $locale .= ', CA';
                                            }
                                        }

                                        $property_details = $this->getSearchResult($address, $locale);
                                        $property_type    = isset($property_details['property_type']) && !empty($property_details['property_type']) ? $property_details['property_type'] : '';
                                        $LegalDescription = isset($property_details['legaldescription']) && !empty($property_details['legaldescription']) ? $property_details['legaldescription'] : '';
                                        $apn              = isset($property_details['apn']) && !empty($property_details['apn']) ? $property_details['apn'] : '';
                                        $propertyData     = [
                                            'customer_id'       => $customerId,
                                            'buyer_agent_id'    => 0,
                                            'listing_agent_id'  => 0,
                                            'escrow_lender_id'  => 0,
                                            'parcel_id'         => $res['Properties'][0]['ParcelID'],
                                            'address'           => removeMultipleSpace($address),
                                            'city'              => $res['Properties'][0]['City'],
                                            'state'             => $res['Properties'][0]['State'],
                                            'zip'               => $res['Properties'][0]['Zip'],
                                            'property_type'     => $property_type,
                                            'full_address'      => removeMultipleSpace($FullProperty),
                                            'apn'               => $apn,
                                            'county'            => $res['Properties'][0]['County'],
                                            'legal_description' => $LegalDescription,
                                            'status'            => 1,
                                        ];

                                        $resultSales = [];
                                        if (!empty($salesRepName)) {
                                            $this->db->select('*');
                                            $this->db->from('customer_basic_details');
                                            $this->db->like("CONCAT_WS(' ', first_name, last_name)", $salesRepName);
                                            $this->db->where('is_sales_rep', 1);
                                            $query       = $this->db->get();
                                            $resultSales = $query->row_array();
                                        }

                                        $transactionData = [
                                            'customer_id'          => $customerId,
                                            'sales_amount'         => !empty($res['SalesPrice']) ? $res['SalesPrice'] : 0,
                                            'loan_number'          => !empty($res['Loans'][0]['LoanNumber']) ? $res['Loans'][0]['LoanNumber'] : 0,
                                            'loan_amount'          => !empty($res['Loans'][0]['LoanAmount']) ? $res['Loans'][0]['LoanAmount'] : 0,
                                            'transaction_type'     => $res['TransactionProductType']['TransactionTypeID'],
                                            'purchase_type'        => $res['TransactionProductType']['ProductTypeID'],
                                            'sales_representative' => !empty($resultSales) ? $resultSales['id'] : 0,
                                            'status'               => 1,
                                        ];

                                        $primary_owner = ($res['Buyers'][0]['Primary']['First'] && $res['Buyers'][0]['Primary']['First']) ? $res['Buyers'][0]['Primary']['First'] : '';
                                        $primary_owner .= ($res['Buyers'][0]['Primary']['Middle'] && $res['Buyers'][0]['Primary']['Middle']) ? " " . $res['Buyers'][0]['Primary']['Middle'] : '';
                                        $primary_owner .= ($res['Buyers'][0]['Primary']['Last'] && $res['Buyers'][0]['Primary']['Last']) ? " " . $res['Buyers'][0]['Primary']['Last'] : '';
                                        $secondary_owner = ($res['Buyers'][0]['Secondary']['First'] && $res['Buyers'][0]['Secondary']['First']) ? $res['Buyers'][0]['Secondary']['First'] : '';
                                        $secondary_owner .= ($res['Buyers'][0]['Secondary']['Middle'] && $res['Buyers'][0]['Secondary']['Middle']) ? $res['Buyers'][0]['Secondary']['Middle'] : '';
                                        $secondary_owner .= ($res['Buyers'][0]['Secondary']['Last'] && $res['Buyers'][0]['Secondary']['Last']) ? " " . $res['Buyers'][0]['Secondary']['Last'] : '';
                                        $ProductTypeTxt = $res['TransactionProductType']['ProductType'];

                                        if (strpos($ProductTypeTxt, 'Loan') !== false) {
                                            $propertyData['primary_owner']   = $primary_owner;
                                            $propertyData['secondary_owner'] = $secondary_owner;
                                            $loanFlag                        = 1;
                                        } elseif (strpos($ProductTypeTxt, 'Sale') !== false) {
                                            $transactionData['borrower']           = $primary_owner;
                                            $transactionData['secondary_borrower'] = $secondary_owner;
                                            $propertyData['primary_owner']         = isset($property_info['primary_owner']) && !empty($property_info['primary_owner']) ? $property_info['primary_owner'] : '';
                                            $propertyData['secondary_owner']       = isset($property_info['secondary_owner']) && !empty($property_info['secondary_owner']) ? $property_info['secondary_owner'] : '';
                                            $loanFlag                              = 0;
                                        }

                                        $propertyId    = $this->home_model->insert($propertyData, 'property_details');
                                        $transactionId = $this->home_model->insert($transactionData, 'transaction_details');
                                        $time          = round((int) (str_replace("-0000)/", "", str_replace("/Date(", "", $res['Dates']['OpenedDate']))) / 1000);
                                        $created_date  = date('Y-m-d H:i:s', $time);
                                        $randomString  = $this->order->randomPassword();
                                        $randomString  = md5($randomString);

                                        $completed_date = null;
                                        if (!empty($closedDate)) {
                                            $myDateTime     = DateTime::createFromFormat('M d, Y', $closedDate);
                                            $completed_date = $myDateTime->format('Y-m-d H:i:s');
                                        } else {
                                            if (!empty($res['Dates']['FileCompletedDate'])) {
                                                $time           = round((int) (str_replace("-0000)/", "", str_replace("/Date(", "", $res['Dates']['FileCompletedDate']))) / 1000);
                                                $completed_date = date('Y-m-d H:i:s', $time);
                                            }
                                        }

                                        $orderData = [
                                            'customer_id'                => $customerId,
                                            'file_id'                    => $res['FileID'],
                                            'file_number'                => $res['FileNumber'],
                                            'property_id'                => $propertyId,
                                            'transaction_id'             => $transactionId,
                                            'created_at'                 => $created_date,
                                            'prod_type'                  => $loanFlag == 1 ? 'loan' : 'sale',
                                            'status'                     => 1,
                                            'is_imported'                => 1,
                                            'is_sales_rep_order'         => 1,
                                            'random_number'              => $randomString,
                                            'resware_closed_status_date' => $completed_date,
                                            'resware_status'             => strtolower($res['Status']['Name']),
                                            'sent_to_accounting_date'    => $completed_date,
                                        ];
                                        $this->home_model->insert($orderData, 'order_details');
                                        if (!empty($resultSales)) {
                                            if (isset($resultSales['telephone_no']) && !empty($resultSales['telephone_no'])) {
                                                $phoneNumber = $resultSales['telephone_no'];
                                                $sid         = env('TWILIO_SID');
                                                $token       = env('TWILIO_TOKEN');
                                                $from        = env('TWILIO_FROM');
                                                $data        = [
                                                    'message'     => $message,
                                                    'account_sid' => $sid,
                                                    'token'       => $token,
                                                    'to'          => $phoneNumber,
                                                    'from'        => $from,
                                                ];

                                                $logid = $this->apiLogs->syncLogs('', 'twilio', 'send_message', '', $data, [], 0, 0);

                                                /*try {
                                            $result = $this->twilio->message($phoneNumber, $message, '', array('from' => $from));
                                            $response = $result->toArray();
                                            $response['msg_status'] = 'success';
                                            } catch (Exception $e) {
                                            $response['sid'] = '';
                                            $response['to'] = $phoneNumber;
                                            $response['msg_status'] = 'error';
                                            $response['errorCode'] = $e->getCode();
                                            $response['errorMessage'] = $e->getMessage();
                                            } catch (\Twilio\Exceptions\RestException $e) {
                                            $response['sid'] = '';
                                            $response['to'] = $phoneNumber;
                                            $response['msg_status'] = 'error';
                                            $response['errorCode'] = $e->getCode();
                                            $response['errorMessage'] = $e->getMessage();
                                            }
                                            $this->apiLogs->syncLogs('', 'twilio', 'send_message', '', $data, $response, 0, $logid);

                                            if($response['msg_status'] == 'success') {

                                            $this->home_model->update(array('is_sent_recording_msg_sales_user' => 1), array('file_number' => $file_number), 'order_details');

                                            $data = array(
                                            'message' => $response['body'],
                                            'sent_from' => $response['from'],
                                            'sent_to' => $response['to'],
                                            'status' => $response['status'],
                                            'message_sid' => $response['sid'],
                                            'error_code' => $response['errorCode'],
                                            'error_message' => $response['errorMessage'],
                                            );
                                            $this->twilioMessage->insert($data);
                                            } */
                                            }
                                        }
                                    }
                                }
                            }
                        }
                        $row++;
                    }
                    fclose($handle);
                }
                $documentName = pathinfo($filePath);
                $fileName     = date('YmdHis') . "_" . $documentName['basename'];
                rename(FCPATH . "/uploads/recording-confirmation/" . $documentName['basename'], FCPATH . "/uploads/recording-confirmation/" . $fileName);
                $this->order->uploadDocumentOnAwsS3($fileName, 'recording-confirmation', 1);
            }
        } else {
            echo "No files found";exit;
        }
        echo "All messages sent to sales users successfully";exit;
    }

    public function syncPrelimData()
    {
        $this->db->select('*');
        $this->db->from('pct_order_api_logs');
        $this->db->where('request_type', 'get_prelim');
        $query  = $this->db->get();
        $result = $query->result_array();
        foreach ($result as $res) {
            $logSyncId = $this->apiLogs->syncLogs(0, 'local', 'sync_prelim_data', 'https://mypctrep.com/ReceiveSearchDataService.svc?wsdl', ['ReceiveSearchDataService' => true], []);
            $url       = "http://app.pacificcoasttitle.com/resware-fetch-data";
            $curl      = curl_init($url);
            curl_setopt($curl, CURLOPT_HEADER, false);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curl, CURLOPT_HTTPHEADER,
                ["Content-type: application/json"]);
            curl_setopt($curl, CURLOPT_POST, true);
            curl_setopt($curl, CURLOPT_POSTFIELDS, $res['response_data']);
            $json_response = curl_exec($curl);
            $status        = curl_getinfo($curl, CURLINFO_HTTP_CODE);
            $this->apiLogs->syncLogs(0, 'local', 'sync_prelim_data', 'https://mypctrep.com/ReceiveSearchDataService.svc?wsdl', [], $json_response, 0, $logSyncId);
            curl_close($curl);
        }
        echo "All prelim data synced successfully";
    }

    public function sendSummaryMailSalesRepUsers()
    {
        $result = $this->order->sendSummaryMail(0);
        echo "Mails sent successfully to Sales Managers";exit;
    }

    public function addPartnerForOrders()
    {
        $this->db->select('*');
        $this->db->from('order_details');
        $this->db->where('created_at BETWEEN DATE_SUB(NOW(), INTERVAL 45 DAY) AND NOW()');
        $this->db->where('((order_details.resware_status != "closed" AND order_details.resware_status != "cancelled") OR order_details.resware_status IS NULL)');
        $query        = $this->db->get();
        $orderDetails = $query->result_array();
        $userdata     = [];

        if (!empty($orderDetails)) {
            foreach ($orderDetails as $orderDetail) {
                $partners = [
                    'PartnerTypeID' => 10049,
                    'PartnerID'     => 400023,
                    'PartnerType'   => [
                        'PartnerTypeID' => 10049,
                    ],
                ];
                $userdata['email'] = 'admin@pct24.com';
                $partnerData       = json_encode(['Partners' => $partners]);
                $endPoint          = 'files/' . $orderDetail['file_id'] . '/partners';
                $logid             = $this->apiLogs->syncLogs(0, 'resware', 'add_partner', env('RESWARE_ORDER_API') . $endPoint, $partnerData, [], 0, 0);
                $resultPartner     = $this->make_request('POST', $endPoint, $partnerData, $userdata);
                $this->apiLogs->syncLogs(0, 'resware', 'add_partner', env('RESWARE_ORDER_API') . $endPoint, $partnerData, $resultPartner, 0, $logid);
            }
            echo "Updated partner for last 45 days orders";exit;
        } else {
            echo "No orders found to update partner";exit;
        }
    }

    public function importDataForPayOff()
    {
        $sftp     = new SFTP(env('SFTP_HOST'));
        $username = env('SFTP_USERNAME');
        $password = env('SFTP_PASSWORD');

        if (! $sftp->login($username, $password)) {
            exit('Login Failed');
        }

        if (! ($files = $sftp->nlist('/' . env('SFTP_FOLDER') . '/payoff/', true))) {
            die("Cannot read directory contents");
        }

        foreach ($files as $file) {
            if ($file != '.' && $file != '..' && $file != '.protected') {
                if (! is_dir('uploads/payoff')) {
                    mkdir('./uploads/payoff', 0777, true);
                }
                $sftp->get(env('SFTP_FOLDER') . '/payoff/' . $file, FCPATH . 'uploads/payoff/' . trim($file) . ".csv");
                chmod(FCPATH . 'uploads/payoff/' . $file . ".csv", 0755);
                $sftp->delete(env('SFTP_FOLDER') . '/payoff/' . $file);
            }
        }
        $files = glob("uploads/payoff/*csv");

        if (is_array($files) && count($files) > 0) {
            foreach ($files as $filePath) {
                $row           = 1;
                $headerColumns = [];
                if (($handle = fopen($filePath, "r")) !== false) {
                    $documentName        = pathinfo($filePath);
                    $file_numbers        = [];
                    $salesRepNameArr     = [];
                    $titleOfficerNameArr = [];
                    $i                   = 0;
                    $j                   = 0;
                    while (($data = fgetcsv($handle, 1000, ",", '"')) !== false) {
                        $num = count($data);
                        if ($row == 1) {
                            for ($c = 0; $c < $num; $c++) {
                                $headerColumns[] = trim($data[$c]);
                            }
                        }

                        $fileKey         = '';
                        $saleskey        = '';
                        $titleOfficerkey = '';
                        $salesRepId      = 0;
                        $titleOfficerId  = 0;

                        if (in_array('File Number', $headerColumns)) {
                            $fileKey     = array_search("File Number", $headerColumns);
                            $file_number = $data[$fileKey];
                        }

                        $salesRepName = '';
                        if (in_array('Sales Rep', $headerColumns)) {
                            $saleskey     = array_search("Sales Rep", $headerColumns);
                            $salesRepName = $data[$saleskey];
                            $salesRepName = str_replace(' ', '_', $salesRepName);
                            $salesRepName = preg_replace('/[^A-Za-z0-9\_-]/', '', $salesRepName);
                            $salesRepName = str_replace('_', ' ', $salesRepName);
                            $key          = array_search($salesRepName, array_column($salesRepNameArr, 'name'));
                            if (isset($key) && !empty($key)) {
                                $salesRepId = $salesRepNameArr[$key]['id'];
                            } else {
                                $salesRepNameArr[$i]['name'] = $salesRepName;
                            }
                        }

                        $titleOfficerName = '';
                        if (in_array('Title Officer', $headerColumns)) {
                            $titleOfficerkey  = array_search("Title Officer", $headerColumns);
                            $titleOfficerName = $data[$titleOfficerkey];
                            $titleOfficerName = str_replace(' ', '_', $titleOfficerName);
                            $titleOfficerName = preg_replace('/[^A-Za-z0-9\_-]/', '', $titleOfficerName);
                            $titleOfficerName = str_replace('_', ' ', $titleOfficerName);
                            $titleOfckey      = array_search($titleOfficerName, array_column($titleOfficerNameArr, 'name'));
                            if (isset($titleOfckey) && !empty($titleOfckey)) {
                                $titleOfficerId = $titleOfficerNameArr[$titleOfckey]['id'];
                            } else {
                                $titleOfficerNameArr[$j]['name'] = $titleOfficerName;
                            }
                        }

                        if ($row != 1) {
                            //echo $file_number."---".$prodType."----".$premium."----".$salesRepName."---".$closedDate;exit;
                            $resultSales = [];
                            if (!empty($salesRepName)) {
                                if ($salesRepId == 0) {
                                    $this->db->select('*');
                                    $this->db->from('customer_basic_details');
                                    $this->db->like("CONCAT_WS(' ', first_name, last_name)", $salesRepName);
                                    $this->db->where('is_sales_rep', 1);
                                    $query       = $this->db->get();
                                    $resultSales = $query->row_array();
                                    if (!empty($resultSales)) {
                                        $salesRepId                = $resultSales['id'];
                                        $salesRepNameArr[$i]['id'] = $salesRepId;
                                        $i++;
                                    } else {
                                        if (!empty(trim($salesRepNameArr[$i]['name']))) {
                                            $salesRepNameArr[$i]['id'] = 0;
                                            $i++;
                                        }
                                    }
                                }
                            }

                            $resultTitleOfficer = [];
                            if (!empty($titleOfficerName)) {
                                if ($titleOfficerId == 0) {
                                    $this->db->select('*');
                                    $this->db->from('customer_basic_details');
                                    $this->db->like("CONCAT_WS(' ', first_name, last_name)", $titleOfficerName);
                                    $this->db->where('is_title_officer', 1);
                                    $query              = $this->db->get();
                                    $resultTitleOfficer = $query->row_array();
                                    if (!empty($resultTitleOfficer)) {
                                        $titleOfficerId                = $resultTitleOfficer['id'];
                                        $titleOfficerNameArr[$j]['id'] = $titleOfficerId;
                                        $j++;
                                    } else {
                                        if (!empty(trim($titleOfficerNameArr[$i]['name']))) {
                                            $titleOfficerNameArr[$j]['id'] = 0;
                                            $j++;
                                        }
                                    }
                                }
                            }

                            $condition = [
                                'where' => [
                                    'file_number' => $file_number,
                                ],
                            ];
                            $order = $this->order->get_order($condition);
                            if (!empty($order)) {
                                $this->home_model->update(
                                    [
                                        'is_payoff_order' => 1,
                                    ],
                                    [
                                        'id' => $order[0]['id'],
                                    ],
                                    'order_details'
                                );
                                $orderDetails = $this->order->get_order_details($order[0]['file_id']);
                                if (!empty($salesRepId)) {
                                    $this->home_model->update(
                                        [
                                            'sales_representative' => $salesRepId,
                                        ],
                                        [
                                            'id' => $orderDetails['transaction_id'],
                                        ],
                                        'transaction_details'
                                    );
                                    $file_numbers[] = $file_number;
                                } else {
                                    $this->home_model->update(
                                        [
                                            'sales_representative' => 0,
                                        ],
                                        [
                                            'id' => $orderDetails['transaction_id'],
                                        ],
                                        'transaction_details'
                                    );
                                }
                                if (!empty($titleOfficerId)) {
                                    $this->home_model->update(
                                        [
                                            'title_officer' => $titleOfficerId,
                                        ],
                                        [
                                            'id' => $orderDetails['transaction_id'],
                                        ],
                                        'transaction_details'
                                    );
                                    $file_numbers[] = $file_number;
                                } else {
                                    $this->home_model->update(
                                        [
                                            'title_officer' => 0,
                                        ],
                                        [
                                            'id' => $orderDetails['transaction_id'],
                                        ],
                                        'transaction_details'
                                    );
                                }
                            } else {
                                $data     = json_encode(['FileNumber' => $file_number]);
                                $userData = [
                                    'admin_api' => 1,
                                ];
                                $logid = $this->apiLogs->syncLogs(0, 'resware', 'get_order_information', env('RESWARE_ORDER_API') . 'files/search', $data, [], 0, 0);
                                $res   = $this->make_request('POST', 'files/search', $data, $userData);
                                $this->apiLogs->syncLogs(0, 'resware', 'get_order_information', env('RESWARE_ORDER_API') . 'files/search', $data, $res, 0, $logid);
                                $result = json_decode($res, true);

                                if (isset($result['Files']) && !empty($result['Files'])) {
                                    foreach ($result['Files'] as $res) {
                                        if (count($result['Files']) > 1 && strtolower($res['Status']['Name']) == 'cancelled') {
                                            continue;
                                        }
                                        $partner_fname = $res['Partners'][0]['PrimaryEmployee']['FirstName'];
                                        $partner_lname = $res['Partners'][0]['PrimaryEmployee']['LastName'];
                                        $partner_name  = $res['Partners'][0]['PartnerName'];
                                        $condition     = [
                                            'first_name'   => $partner_fname,
                                            'last_name'    => $partner_lname,
                                            'company_name' => $partner_name,
                                            'is_pass'      => $partner_name,
                                        ];
                                        $user_details = $this->home_model->get_user_by_name($condition);
                                        $customerId   = 0;

                                        if (isset($user_details) && !empty($user_details)) {
                                            $customerId = $user_details['id'];
                                        }

                                        $FullProperty = $res['Properties'][0]['StreetNumber'] . " " . $res['Properties'][0]['StreetDirection'] . " " . $res['Properties'][0]['StreetName'] . " " . $res['Properties'][0]['StreetSuffix'] . ", " . $res['Properties'][0]['City'] . ", " . $res['Properties'][0]['State'] . ", " . $res['Properties'][0]['Zip'];
                                        $address      = $res['Properties'][0]['StreetNumber'] . " " . $res['Properties'][0]['StreetDirection'] . " " . $res['Properties'][0]['StreetName'] . " " . $res['Properties'][0]['StreetSuffix'];
                                        $locale       = $res['Properties'][0]['City'];

                                        if (($locale)) {
                                            if (!empty($res['Properties'][0]['State'])) {
                                                $locale .= ', ' . $res['Properties'][0]['State'];
                                            } else {
                                                $locale .= ', CA';
                                            }
                                        }

                                        $property_details = $this->getSearchResult($address, $locale);
                                        $property_type    = isset($property_details['property_type']) && !empty($property_details['property_type']) ? $property_details['property_type'] : '';
                                        $LegalDescription = isset($property_details['legaldescription']) && !empty($property_details['legaldescription']) ? $property_details['legaldescription'] : '';
                                        $apn              = isset($property_details['apn']) && !empty($property_details['apn']) ? $property_details['apn'] : '';
                                        $propertyData     = [
                                            'customer_id'       => $customerId,
                                            'buyer_agent_id'    => 0,
                                            'listing_agent_id'  => 0,
                                            'escrow_lender_id'  => 0,
                                            'parcel_id'         => $res['Properties'][0]['ParcelID'],
                                            'address'           => removeMultipleSpace($address),
                                            'city'              => $res['Properties'][0]['City'],
                                            'state'             => $res['Properties'][0]['State'],
                                            'zip'               => $res['Properties'][0]['Zip'],
                                            'property_type'     => $property_type,
                                            'full_address'      => removeMultipleSpace($FullProperty),
                                            'apn'               => $apn,
                                            'county'            => $res['Properties'][0]['County'],
                                            'legal_description' => $LegalDescription,
                                            'status'            => 1,
                                        ];

                                        $transactionData = [
                                            'customer_id'          => $customerId,
                                            'sales_amount'         => !empty($res['SalesPrice']) ? $res['SalesPrice'] : 0,
                                            'loan_number'          => !empty($res['Loans'][0]['LoanNumber']) ? $res['Loans'][0]['LoanNumber'] : 0,
                                            'loan_amount'          => !empty($res['Loans'][0]['LoanAmount']) ? $res['Loans'][0]['LoanAmount'] : 0,
                                            'transaction_type'     => $res['TransactionProductType']['TransactionTypeID'],
                                            'purchase_type'        => $res['TransactionProductType']['ProductTypeID'],
                                            'sales_representative' => $salesRepId,
                                            'title_officer'        => $titleOfficerId,
                                            'status'               => 1,
                                        ];

                                        $primary_owner = ($res['Buyers'][0]['Primary']['First'] && $res['Buyers'][0]['Primary']['First']) ? $res['Buyers'][0]['Primary']['First'] : '';
                                        $primary_owner .= ($res['Buyers'][0]['Primary']['Middle'] && $res['Buyers'][0]['Primary']['Middle']) ? " " . $res['Buyers'][0]['Primary']['Middle'] : '';
                                        $primary_owner .= ($res['Buyers'][0]['Primary']['Last'] && $res['Buyers'][0]['Primary']['Last']) ? " " . $res['Buyers'][0]['Primary']['Last'] : '';
                                        $secondary_owner = ($res['Buyers'][0]['Secondary']['First'] && $res['Buyers'][0]['Secondary']['First']) ? $res['Buyers'][0]['Secondary']['First'] : '';
                                        $secondary_owner .= ($res['Buyers'][0]['Secondary']['Middle'] && $res['Buyers'][0]['Secondary']['Middle']) ? $res['Buyers'][0]['Secondary']['Middle'] : '';
                                        $secondary_owner .= ($res['Buyers'][0]['Secondary']['Last'] && $res['Buyers'][0]['Secondary']['Last']) ? " " . $res['Buyers'][0]['Secondary']['Last'] : '';
                                        $ProductTypeTxt = $res['TransactionProductType']['ProductType'];

                                        if (strpos($ProductTypeTxt, 'Loan') !== false) {
                                            $propertyData['primary_owner']   = $primary_owner;
                                            $propertyData['secondary_owner'] = $secondary_owner;
                                        } elseif (strpos($ProductTypeTxt, 'Sale') !== false) {
                                            $transactionData['borrower']           = $primary_owner;
                                            $transactionData['secondary_borrower'] = $secondary_owner;
                                            $propertyData['primary_owner']         = isset($property_info['primary_owner']) && !empty($property_info['primary_owner']) ? $property_info['primary_owner'] : '';
                                            $propertyData['secondary_owner']       = isset($property_info['secondary_owner']) && !empty($property_info['secondary_owner']) ? $property_info['secondary_owner'] : '';
                                        }

                                        $propertyId    = $this->home_model->insert($propertyData, 'property_details');
                                        $transactionId = $this->home_model->insert($transactionData, 'transaction_details');
                                        $time          = round((int) (str_replace("-0000)/", "", str_replace("/Date(", "", $res['Dates']['OpenedDate']))) / 1000);
                                        $created_date  = date('Y-m-d H:i:s', $time);
                                        $randomString  = $this->order->randomPassword();
                                        $randomString  = md5($randomString);

                                        $completed_date = null;
                                        if (empty($closedDate)) {
                                            if (!empty($res['Dates']['FileCompletedDate'])) {
                                                $time           = round((int) (str_replace("-0000)/", "", str_replace("/Date(", "", $res['Dates']['FileCompletedDate']))) / 1000);
                                                $completed_date = date('Y-m-d H:i:s', $time);
                                            }
                                        }

                                        $orderData = [
                                            'customer_id'                => $customerId,
                                            'file_id'                    => $res['FileID'],
                                            'file_number'                => $res['FileNumber'],
                                            'property_id'                => $propertyId,
                                            'transaction_id'             => $transactionId,
                                            'created_at'                 => $created_date,
                                            'status'                     => 1,
                                            'is_imported'                => 1,
                                            'is_payoff_order'            => 1,
                                            'random_number'              => $randomString,
                                            'resware_closed_status_date' => $completed_date,
                                            'resware_status'             => strtolower($res['Status']['Name']),
                                            'sent_to_accounting_date'    => $completed_date,
                                        ];
                                        $this->home_model->insert($orderData, 'order_details');
                                    }
                                }
                            }
                        }
                        $row++;
                    }
                    fclose($handle);
                }
                $documentName = pathinfo($filePath);
                $fileName     = date('YmdHis') . "_" . $documentName['basename'];
                rename(FCPATH . "/uploads/payoff/" . $documentName['basename'], FCPATH . "/uploads/payoff/" . $fileName);
                $this->order->uploadDocumentOnAwsS3($fileName, 'payoff', 1);
            }
        } else {
            echo "No files found";exit;
        }
        echo "All data imported successfully";exit;
    }

    // Sent Memo acknowledge mail to assigned User
    public function sendMemoMail($memo_assign_id)
    {
        //Get pending mails to be sent

        $this->db->select('pct_hr_assigned_memo_users.id,pct_hr_assigned_memo_users.user_id,pct_hr_users.email,pct_hr_users.first_name,pct_hr_users.last_name,,pct_hr_memos.subject,pct_hr_memos.description');
        $this->db->from('pct_hr_assigned_memo_users');
        $this->db->join('pct_hr_users', 'pct_hr_users.id = pct_hr_assigned_memo_users.user_id');
        $this->db->join('pct_hr_memos', 'pct_hr_memos.id = pct_hr_assigned_memo_users.memo_id');
        $this->db->where('pct_hr_assigned_memo_users.id', $memo_assign_id);

        $query      = $this->db->get();
        $memo_mails = $query->result_array();
        $this->load->library('encryption');

        foreach ($memo_mails as $memo_mail) {
            // var_dump($memo_mail);

            $memoId              = urlencode($this->encryption->encrypt($memo_mail['id']));
            $userId              = urlencode($this->encryption->encrypt($memo_mail['user_id']));
            $data                = [];
            $data['subject']     = $memo_mail['subject'];
            $data['description'] = $memo_mail['description'];
            $data['user_name']   = $memo_mail['first_name'] . ' ' . $memo_mail['last_name'];
            $data['botton_url']  = base_url('hr/acknowledge-memo/' . $memoId . '/' . $userId);
            $message             = $this->load->view('emails/memo_assigned', $data, true);
            $from_name           = 'Pacific Coast Title Company';
            $from_mail           = env('FROM_EMAIL');
            $subject             = 'Memo Created';
            $to                  = $memo_mail['email'];
            // $to = 'cs@pct.com';
            $cc = [];
            $this->load->helper('sendemail');
            $check_mail = send_email($from_mail, $from_name, $to, $subject, $message, $cc);
            if ($check_mail) {
                $update_data              = [];
                $update_data['mail_sent'] = 1;
                $condition                = [];
                $condition['id']          = $memo_mail['id'];
                $update                   = $this->home_model->update($update_data, $condition, 'pct_hr_assigned_memo_users');
            }
        }

        // $data['file_number'] = $file_number;
    }

    public function importEscrowFee()
    {
        $sftp     = new SFTP(env('SFTP_HOST'));
        $username = env('SFTP_USERNAME');
        $password = env('SFTP_PASSWORD');

        if (! $sftp->login($username, $password)) {
            exit('Login Failed');
        }

        if (! ($files = $sftp->nlist('/' . env('SFTP_FOLDER') . '/escrow-orders/', true))) {
            die("Cannot read directory contents");
        }

        foreach ($files as $file) {
            if ($file != '.' && $file != '..' && $file != '.protected') {
                if (! is_dir('uploads/escrow-orders')) {
                    mkdir('./uploads/escrow-orders', 0777, true);
                }
                $sftp->get(env('SFTP_FOLDER') . '/escrow-orders/' . $file, FCPATH . 'uploads/escrow-orders/' . trim($file) . ".csv");
                chmod(FCPATH . 'uploads/escrow-orders/' . $file . ".csv", 0755);
                $sftp->delete(env('SFTP_FOLDER') . '/escrow-orders/' . $file);
            }
        }
        $files = glob("uploads/escrow-orders/*csv");

        if (is_array($files) && count($files) > 0) {
            foreach ($files as $filePath) {
                $row           = 1;
                $headerColumns = [];
                if (($handle = fopen($filePath, "r")) !== false) {
                    $documentName    = pathinfo($filePath);
                    $file_numbers    = [];
                    $salesRepNameArr = [];
                    $i               = 0;

                    while (($data = fgetcsv($handle, 1000, ",", '"')) !== false) {
                        $num = count($data);
                        if ($row == 1) {
                            for ($c = 0; $c < $num; $c++) {
                                $headerColumns[] = trim($data[$c]);
                            }
                        }

                        $titleOfficerId     = 0;
                        $fileKey            = '';
                        $prodkey            = '';
                        $escrowAmountKey    = '';
                        $saleskey           = '';
                        $closedDate         = '';
                        $salesRepId         = 0;
                        $sales_rep_img      = '';
                        $salesRepColumnFlag = 0;

                        if (in_array('File Number', $headerColumns)) {
                            $fileKey     = array_search("File Number", $headerColumns);
                            $file_number = $data[$fileKey];
                        }

                        if (in_array('Prod Type', $headerColumns)) {
                            $prodkey  = array_search("Prod Type", $headerColumns);
                            $prodType = $data[$prodkey];
                        }

                        if (in_array('Amt', $headerColumns)) {
                            $escrowAmountKey = array_search("Amt", $headerColumns);
                            $escrowAmount    = $data[$escrowAmountKey];
                            $escrowAmount    = str_replace('$', '', $escrowAmount);
                            $escrowAmount    = str_replace(',', '', $escrowAmount);
                        }

                        $salesRepName = '';
                        if (in_array('Sales Rep', $headerColumns)) {
                            $saleskey     = array_search("Sales Rep", $headerColumns);
                            $salesRepName = $data[$saleskey];
                            $salesRepName = str_replace(' ', '_', $salesRepName);
                            $salesRepName = preg_replace('/[^A-Za-z0-9\_-]/', '', $salesRepName);
                            $salesRepName = str_replace('_', ' ', $salesRepName);
                            $key          = array_search($salesRepName, array_column($salesRepNameArr, 'name'));
                            if (isset($key) && !empty($key)) {
                                $salesRepId    = $salesRepNameArr[$key]['id'];
                                $sales_rep_img = $salesRepNameArr[$key]['sales_rep_img'];
                            } else {
                                $salesRepNameArr[$i]['name'] = $salesRepName;
                            }
                            $salesRepColumnFlag = 1;
                        }

                        if (in_array('Sent To External Accounting', $headerColumns)) {
                            $closedDatekey = array_search("Sent To External Accounting", $headerColumns);
                            $closedDate    = $data[$closedDatekey];
                        }

                        if ($row != 1) {
                            //echo $file_number."---".$prodType."----".$premium."----".$salesRepName."---".$closedDate;exit;
                            $resultSales = [];
                            if (!empty($salesRepName)) {
                                if ($salesRepId == 0) {
                                    $this->db->select('*');
                                    $this->db->from('customer_basic_details');
                                    $this->db->like("CONCAT_WS(' ', first_name, last_name)", $salesRepName);
                                    $this->db->where('is_sales_rep', 1);
                                    $query       = $this->db->get();
                                    $resultSales = $query->row_array();
                                    if (!empty($resultSales)) {
                                        $salesRepId    = $resultSales['id'];
                                        $sales_rep_img = isset($resultSales["sales_rep_profile_img"]) && !empty($resultSales["sales_rep_profile_img"]) ? $resultSales["sales_rep_profile_img"] : '';
                                        if (!empty($sales_rep_img)) {
                                            $sales_rep_img = env('AWS_PATH') . str_replace('uploads/', '', $sales_rep_img);
                                        }
                                        $salesRepNameArr[$i]['id']            = $salesRepId;
                                        $salesRepNameArr[$i]['sales_rep_img'] = $sales_rep_img;
                                        $i++;
                                    } else {
                                        if (!empty(trim($salesRepNameArr[$i]['name']))) {
                                            $salesRepNameArr[$i]['id'] = 0;
                                            $i++;
                                        }
                                    }
                                }
                            }

                            $completed_date = null;
                            if (!empty($closedDate)) {
                                $myDateTime     = DateTime::createFromFormat('M d, Y', $closedDate);
                                $completed_date = $myDateTime->format('Y-m-d H:i:s');
                            }

                            if (!empty($file_number)) {
                                $condition = [
                                    'where' => [
                                        'file_number' => $file_number,
                                    ],
                                ];
                                $order = $this->order->get_order($condition);

                                if (!empty($order)) {
                                    if (in_array($file_number, $file_numbers)) {
                                        if (!empty($escrowAmount)) {
                                            $escrowAmount = (float) $escrowAmount + $order[0]['escrow_amount'];
                                        }
                                    }
                                    $file_numbers[] = $file_number;
                                    $orderData      = [];

                                    if (!empty($prodType)) {
                                        $orderData['prod_type'] = strtolower($prodType);
                                    }

                                    if (!empty($escrowAmount)) {
                                        $orderData['escrow_amount'] = (float) $escrowAmount;
                                    }

                                    if (!empty($completed_date)) {
                                        $orderData['sent_to_accounting_date'] = $completed_date;
                                    }

                                    if (!empty($orderData)) {
                                        $this->home_model->update(
                                            $orderData,
                                            [
                                                'id' => $order[0]['id'],
                                            ],
                                            'order_details'
                                        );
                                    }

                                    $orderDetails = $this->order->get_order_details($order[0]['file_id']);
                                    if (!empty($salesRepId)) {
                                        $this->home_model->update(
                                            [
                                                'sales_representative' => $salesRepId,
                                            ],
                                            [
                                                'id' => $orderDetails['transaction_id'],
                                            ],
                                            'transaction_details'
                                        );
                                    } else {
                                        if ($salesRepColumnFlag == 1) {
                                            $this->home_model->update(
                                                [
                                                    'sales_representative' => 0,
                                                ],
                                                [
                                                    'id' => $orderDetails['transaction_id'],
                                                ],
                                                'transaction_details'
                                            );
                                        }
                                    }
                                } else {
                                    $file_numbers[] = $file_number;
                                    $data           = json_encode(['FileNumber' => $file_number]);
                                    $userData       = [
                                        'admin_api' => 1,
                                    ];
                                    $logid = $this->apiLogs->syncLogs(0, 'resware', 'get_order_information', env('RESWARE_ORDER_API') . 'files/search', $data, [], 0, 0);
                                    $res   = $this->make_request('POST', 'files/search', $data, $userData);
                                    $this->apiLogs->syncLogs(0, 'resware', 'get_order_information', env('RESWARE_ORDER_API') . 'files/search', $data, $res, 0, $logid);
                                    $result = json_decode($res, true);

                                    if (isset($result['Files']) && !empty($result['Files'])) {
                                        foreach ($result['Files'] as $res) {
                                            if (count($result['Files']) > 1 && strtolower($res['Status']['Name']) == 'cancelled') {
                                                continue;
                                            }
                                            $partner_fname = $res['Partners'][0]['PrimaryEmployee']['FirstName'];
                                            $partner_lname = $res['Partners'][0]['PrimaryEmployee']['LastName'];
                                            $partner_name  = $res['Partners'][0]['PartnerName'];
                                            $condition     = [
                                                'first_name'   => $partner_fname,
                                                'last_name'    => $partner_lname,
                                                'company_name' => $partner_name,
                                                'is_pass'      => $partner_name,
                                            ];
                                            $user_details = $this->home_model->get_user_by_name($condition);
                                            $customerId   = 0;

                                            if (isset($user_details) && !empty($user_details)) {
                                                $customerId = $user_details['id'];
                                            }

                                            $FullProperty = $res['Properties'][0]['StreetNumber'] . " " . $res['Properties'][0]['StreetDirection'] . " " . $res['Properties'][0]['StreetName'] . " " . $res['Properties'][0]['StreetSuffix'] . ", " . $res['Properties'][0]['City'] . ", " . $res['Properties'][0]['State'] . ", " . $res['Properties'][0]['Zip'];
                                            $address      = $res['Properties'][0]['StreetNumber'] . " " . $res['Properties'][0]['StreetDirection'] . " " . $res['Properties'][0]['StreetName'] . " " . $res['Properties'][0]['StreetSuffix'];
                                            $locale       = $res['Properties'][0]['City'];

                                            if (($locale)) {
                                                if (!empty($res['Properties'][0]['State'])) {
                                                    $locale .= ', ' . $res['Properties'][0]['State'];
                                                } else {
                                                    $locale .= ', CA';
                                                }
                                            }

                                            $property_details = $this->getSearchResult($address, $locale);
                                            $property_type    = isset($property_details['property_type']) && !empty($property_details['property_type']) ? $property_details['property_type'] : '';
                                            $LegalDescription = isset($property_details['legaldescription']) && !empty($property_details['legaldescription']) ? $property_details['legaldescription'] : '';
                                            $apn              = isset($property_details['apn']) && !empty($property_details['apn']) ? $property_details['apn'] : '';
                                            $propertyData     = [
                                                'customer_id'       => $customerId,
                                                'buyer_agent_id'    => 0,
                                                'listing_agent_id'  => 0,
                                                'escrow_lender_id'  => 0,
                                                'parcel_id'         => $res['Properties'][0]['ParcelID'],
                                                'address'           => removeMultipleSpace($address),
                                                'city'              => $res['Properties'][0]['City'],
                                                'state'             => $res['Properties'][0]['State'],
                                                'zip'               => $res['Properties'][0]['Zip'],
                                                'property_type'     => $property_type,
                                                'full_address'      => removeMultipleSpace($FullProperty),
                                                'apn'               => $apn,
                                                'county'            => $res['Properties'][0]['County'],
                                                'legal_description' => $LegalDescription,
                                                'status'            => 1,
                                            ];

                                            $transactionData = [
                                                'customer_id'          => $customerId,
                                                'sales_amount'         => !empty($res['SalesPrice']) ? $res['SalesPrice'] : 0,
                                                'loan_number'          => !empty($res['Loans'][0]['LoanNumber']) ? $res['Loans'][0]['LoanNumber'] : 0,
                                                'loan_amount'          => !empty($res['Loans'][0]['LoanAmount']) ? $res['Loans'][0]['LoanAmount'] : 0,
                                                'transaction_type'     => $res['TransactionProductType']['TransactionTypeID'],
                                                'purchase_type'        => $res['TransactionProductType']['ProductTypeID'],
                                                'sales_representative' => $salesRepId,
                                                'title_officer'        => $titleOfficerId,
                                                'status'               => 1,
                                            ];

                                            $primary_owner = ($res['Buyers'][0]['Primary']['First'] && $res['Buyers'][0]['Primary']['First']) ? $res['Buyers'][0]['Primary']['First'] : '';
                                            $primary_owner .= ($res['Buyers'][0]['Primary']['Middle'] && $res['Buyers'][0]['Primary']['Middle']) ? " " . $res['Buyers'][0]['Primary']['Middle'] : '';
                                            $primary_owner .= ($res['Buyers'][0]['Primary']['Last'] && $res['Buyers'][0]['Primary']['Last']) ? " " . $res['Buyers'][0]['Primary']['Last'] : '';
                                            $secondary_owner = ($res['Buyers'][0]['Secondary']['First'] && $res['Buyers'][0]['Secondary']['First']) ? $res['Buyers'][0]['Secondary']['First'] : '';
                                            $secondary_owner .= ($res['Buyers'][0]['Secondary']['Middle'] && $res['Buyers'][0]['Secondary']['Middle']) ? $res['Buyers'][0]['Secondary']['Middle'] : '';
                                            $secondary_owner .= ($res['Buyers'][0]['Secondary']['Last'] && $res['Buyers'][0]['Secondary']['Last']) ? " " . $res['Buyers'][0]['Secondary']['Last'] : '';
                                            $ProductTypeTxt = $res['TransactionProductType']['ProductType'];

                                            if (strpos($ProductTypeTxt, 'Loan') !== false) {
                                                $propertyData['primary_owner']   = $primary_owner;
                                                $propertyData['secondary_owner'] = $secondary_owner;
                                            } elseif (strpos($ProductTypeTxt, 'Sale') !== false) {
                                                $transactionData['borrower']           = $primary_owner;
                                                $transactionData['secondary_borrower'] = $secondary_owner;
                                                $propertyData['primary_owner']         = isset($property_info['primary_owner']) && !empty($property_info['primary_owner']) ? $property_info['primary_owner'] : '';
                                                $propertyData['secondary_owner']       = isset($property_info['secondary_owner']) && !empty($property_info['secondary_owner']) ? $property_info['secondary_owner'] : '';
                                            }

                                            $propertyId    = $this->home_model->insert($propertyData, 'property_details');
                                            $transactionId = $this->home_model->insert($transactionData, 'transaction_details');
                                            $time          = round((int) (str_replace("-0000)/", "", str_replace("/Date(", "", $res['Dates']['OpenedDate']))) / 1000);
                                            $created_date  = date('Y-m-d H:i:s', $time);
                                            $randomString  = $this->order->randomPassword();
                                            $randomString  = md5($randomString);

                                            $resware_closed_status_date = null;
                                            if (empty($closedDate)) {
                                                if (!empty($res['Dates']['FileCompletedDate'])) {
                                                    $time                       = round((int) (str_replace("-0000)/", "", str_replace("/Date(", "", $res['Dates']['FileCompletedDate']))) / 1000);
                                                    $resware_closed_status_date = date('Y-m-d H:i:s', $time);
                                                }
                                            }

                                            $orderData = [
                                                'customer_id'                => $customerId,
                                                'file_id'                    => $res['FileID'],
                                                'file_number'                => $res['FileNumber'],
                                                'property_id'                => $propertyId,
                                                'transaction_id'             => $transactionId,
                                                'created_at'                 => $created_date,
                                                'prod_type'                  => strtolower($prodType),
                                                'escrow_amount'              => (float) $escrowAmount,
                                                'status'                     => 1,
                                                'is_imported'                => 1,
                                                'is_sales_rep_order'         => 1,
                                                'random_number'              => $randomString,
                                                'resware_closed_status_date' => $resware_closed_status_date,
                                                'resware_status'             => strtolower($res['Status']['Name']),
                                                'sent_to_accounting_date'    => $completed_date,
                                            ];
                                            $this->home_model->insert($orderData, 'order_details');
                                        }
                                    }
                                }
                            }
                        }
                        $row++;
                    }
                    fclose($handle);
                }
                $documentName = pathinfo($filePath);
                $fileName     = date('YmdHis') . "_" . $documentName['basename'];
                rename(FCPATH . "/uploads/escrow-orders/" . $documentName['basename'], FCPATH . "/uploads/escrow-orders/" . $fileName);
                $this->order->uploadDocumentOnAwsS3($fileName, 'escrow-orders', 1);
            }
        } else {
            echo "No files found";exit;
        }
        echo "All data exported successfully";exit;
    }

    public function sendDataToHomeDocs($fileId)
    {
        $orderDetails = $this->order->get_order_details($fileId);
        $this->load->model('order/titlePointData');
        $condition = [
            'where' => [
                'file_id' => $fileId,
            ],
        ];
        $titlePointDetails = $this->titlePointData->gettitlePointDetails($condition);
        $this->load->helper('homedocsapi_helper');
        $homedocs_array = [
            'order_token'        => $orderDetails['random_number'],
            'apn'                => $orderDetails['apn'],
            'fips'               => $titlePointDetails[0]['fips'],
            'address'            => $orderDetails['address'],
            'last_line'          => $orderDetails['property_city'] . ', ' . $orderDetails['property_state'],
            'full_address'       => $orderDetails['full_address'],
            'file_id'            => $orderDetails['file_id'],
            'file_number'        => $orderDetails['file_number'],
            'vesting_info'       => $titlePointDetails[0]['vesting_information'],
            'first_installment'  => $titlePointDetails[0]['first_installment'],
            'second_installment' => $titlePointDetails[0]['second_installment'],
            'borrower_email'     => $orderDetails['borrower_email'],
            'borrower_name'      => $orderDetails['primary_owner'],
        ];

        $logid  = $this->apiLogs->syncLogs(0, 'homedocs', 'send_order_info', env('HOMEDOCS_URL') . 'api/store-property-detail', json_encode($homedocs_array, JSON_UNESCAPED_SLASHES), [], $orderDetails['order_id'], 0);
        $result = send_order_data($homedocs_array);
        $this->apiLogs->syncLogs(0, 'homedocs', 'send_order_info', env('HOMEDOCS_URL') . 'api/store-property-detail', json_encode($homedocs_array, JSON_UNESCAPED_SLASHES), $result, $orderDetails['order_id'], $logid);
    }

    public function update_underwriters_data()
    {
        $table = 'order_details';
        $this->load->library('order/resware');

        $this->db->select('id,file_id');
        $this->db->from($table);
        $this->db->where('is_underwriter_updated', 0);
        $this->db->order_by('id', 'DESC');
        $this->db->limit(500);
        $query                  = $this->db->get();
        $result                 = $query->result();
        $user_data              = [];
        $user_data['admin_api'] = 1;
        foreach ($result as $record) {
            $file_id        = $record->file_id;
            $endPoint       = 'files/' . $file_id . '/partners';
            $resultPartners = $this->resware->make_request('GET', $endPoint, '', $user_data);
            $resPartners    = json_decode($resultPartners, true);

            $underWriter = '';
            if (!empty($resPartners)) {
                $key = array_search(7, array_column($resPartners['Partners'], 'PartnerTypeID'));
                if (str_contains($resPartners['Partners'][$key]['PartnerName'], 'Doma Title Insurance') || $resPartners['Partners'][$key]['PartnerName'] == 'North American Title Insurance Company') {
                    $underWriter = 'north_american';
                } elseif ($resPartners['Partners'][$key]['PartnerName'] == 'Westcor Land Title Insurance Company') {
                    $underWriter = 'westcor';
                } else if ($resPartners['Partners'][$key]['PartnerName'] == 'Commonwealth Land Title Insurance Company') {
                    $underWriter = 'commonwealth';
                } else {
                    if ($key) {
                        $underWriter = 'other';
                    } else {
                        $underWriter = 'not_set';
                    }
                }
            }
            //Update Underwriter
            $order_details = [
                'underwriter'            => $underWriter,
                'is_underwriter_updated' => 1,

            ];
            $condition = [
                'file_id' => $file_id,
            ];
            $this->db->update($table, $order_details, $condition);

        }
    }

    public function sendEmailForClosedOrder($fileNumbers)
    {
        $this->db->select('
            order_details.file_number,
            order_details.id as order_id,
            order_details.resware_status,
            order_details.resware_closed_status_date,
            order_details.prod_type,
            client.first_name,
            client.last_name,
            client.email_address as sales_email,
            client.sales_rep_profile_thank_you_img,
            property_details.id,
            property_details.apn,
            property_details.full_address,
            property_details.address,
            property_details.city,
            property_details.state,
            property_details.county,
            property_details.zip,
            escrow_details.email_address as escrow_email,
            lender_details.email_address as lender_email,
            title_officer.email_address as title_officer_email,
            listing_agent.email_address as listing_agent_email,
            buyer_agent.email_address as buyer_agent_email,
            sales_details.email_address as sales_rep_email,
            escrow_officer.email_address as escrow_officer_email,
            transaction_details.sales_representative');
        $this->db->from('order_details');
        $this->db->where_in('order_details.file_number', $fileNumbers);
        $this->db->where('order_details.customer_id > 0');
        // $this->db->where('property_details.escrow_lender_id != ""');
        // $this->db->where('transaction_details.sales_representative != ""');
        $this->db->join('property_details', 'order_details.property_id = property_details.id', 'inner');
        $this->db->join('transaction_details', 'order_details.transaction_id = transaction_details.id', 'inner');
        $this->db->join('pct_softpro_lookup_table as client ', 'client.id = order_details.customer_id', 'inner');
        $this->db->join('pct_softpro_lookup_table as sales_details ', 'sales_details.id = transaction_details.sales_representative', 'inner');
        $this->db->join('pct_softpro_lookup_table as escrow_details', 'escrow_details.id = property_details.escrow_id', 'left');
        $this->db->join('pct_softpro_lookup_table as lender_details', 'lender_details.id = property_details.lender_id', 'left');
        $this->db->join('pct_softpro_lookup_table as title_officer', 'title_officer.id = transaction_details.title_officer', 'left');
        $this->db->join('pct_softpro_lookup_table as buyer_agent', 'buyer_agent.id = property_details.buyer_agent_id', 'left');
        $this->db->join('pct_softpro_lookup_table as listing_agent', 'listing_agent.id = property_details.listing_agent_id', 'left');
        $this->db->join('pct_softpro_lookup_table as escrow_officer', 'escrow_officer.id = order_details.escrow_officer_id', 'left');
        // $this->db->order_by('transaction_details.sales_representative asc, property_details.escrow_lender_id asc');
        $query  = $this->db->get();
        $result = $query->result_array();
        $configData               = $this->order->getConfigData();
        $loanOrderEmailSendStatus = $configData['loan_order_closed_email_send_off']['is_enable'];
        $saleOrderEmailSendStatus = $configData['sale_order_closed_email_send_off']['is_enable'];
        $enableSurveyEmailFlag = $configData['enable_survey_email']['is_enable'];
        // echo "<pre>";
        // print_r($result);
        // print_r($configData);
        // die;

        if (!empty($result)) {
            $checkFlag = 0;
            $data      = [];
            $i         = 0;
            foreach ($result as $res) {
                // echo 'res ===';
                if (((empty($loanOrderEmailSendStatus) || $loanOrderEmailSendStatus == 0) && $res['prod_type'] === 'Refinance') || ((empty($saleOrderEmailSendStatus) || $saleOrderEmailSendStatus == 0) && $res['prod_type'] === 'Purchase')) {
                    $sales_email = !empty($res['sales_rep_email']) ? $res['sales_rep_email'] : '';

                    $to = [];
                    if (!empty($res['escrow_email'])) {
                        array_push($to, $res['escrow_email']);
                    }
                    if (!empty($res['listing_agent_email'])) {
                        array_push($to, $res['listing_agent_email']);
                    }
                    if (!empty($res['buyer_agent_email'])) {
                        array_push($to, $res['buyer_agent_email']);
                    }
                    if (!empty($res['sales_email'])) {
                        array_push($to, $res['sales_email']);
                    }

                    // echo 'after if ===';
                    // print_r($res);
                    $message   = $this->load->view('emails/close_order_email.php', $data, true);
                    $from_name = 'Pacific Coast Title Company';
                    $from_mail = env('FROM_EMAIL');
                    // $subject = 'Thank You!';
                    // $to = $escrow_email_address;

                    $cc = ['ghernandez@pct.com', $sales_email];

                    $from_name = 'Pacific Coast Title Company';
                    $from_mail = env('FROM_EMAIL');
                    $subject   = 'Your Order ' . $res['file_number'] . ' has been closed';
                    // $to = $escrow_email_address;
                    // $cc = array('piyush.j@crestinfosystems.com', $sales_email);
                    // $cc = array('piyush.j@crestinfosystems.com');
                    $mailParams = [
                        'from_mail' => $from_mail,
                        'from_name' => $from_name,
                        'to'        => $to,
                        'subject'   => $subject,
                        'message'   => json_encode($data),
                        'cc'        => $cc,
                    ];
                    // $to = ['piyush.j@crestinfosystems.net', 'ghernandez@pct.com'];
                    // $cc = array();
                    $this->load->helper('sendemail');
                    $logid              = $this->apiLogs->syncLogs(0, 'sendgrid', 'send_mail_to_all_parties', '', $mailParams, [], $res['order_id'], 0);
                    $escrow_mail_result = send_email($from_mail, $from_name, $to, $subject, $message, [], $cc);
                    $this->apiLogs->syncLogs(0, 'sendgrid', 'send_mail_to_all_parties', '', $mailParams, ['status' => $escrow_mail_result], $res['orderId'], $logid);
                    echo "Mails sent successfully for Order Number : " . $res['file_number'] . " To: " . implode(', ', $to) . "And In CC : " . implode(', ', $cc) . "<br/>";
                }
                
                if (($enableSurveyEmailFlag == 1) && !empty($res['escrow_officer_email'])) {
                    $this->sendSurvayEmail($res);
                }

            }

        }
    }

    function normalizeAddress($address) {
        $replacements = [
            ' St' => ' Street',
            ' Rd' => ' Road',
            ' Dr' => ' Drive',
            ' Ave' => ' Avenue',
            ' Ln' => ' Lane',
            ' Ct' => ' Court',
            ' Pl' => ' Place',
            ' Blvd' => ' Boulevard',
            // add more as needed
        ];
        
        foreach ($replacements as $abbr => $full) {
            $address = preg_replace('/\b' . preg_quote($abbr, '/') . '\b/i', $full, $address);
        }
    
        return $address;
    }

    public function sendEmailToBuyerAgent($orderDetails) {

        // if (!empty($orderDetails['buyer_agent_email_address'])) {
            
        // } else {
            $address = $orderDetails['address'];
            $retsData = $this->createPipeDriveContact($address);
            if (!empty($retsData)) {
                $retsPropertyDetails = $retsData[0];
                print_r($retsPropertyDetails['agent']);
                if (!empty($retsPropertyDetails['agent']) && !empty($retsPropertyDetails['agent']['contact'])) {
                    $orderDetails['buyer_agent_first_name'] = $retsPropertyDetails['agent']['firstName'];
                    $orderDetails['buyer_agent_last_name'] = $retsPropertyDetails['agent']['lastName'];
                    $orderDetails['buyer_agent_email_address'] = $retsPropertyDetails['agent']['contact']['email'];
                    $orderDetails['buyer_agent_phone'] = $retsPropertyDetails['agent']['contact']['cell'];
                    $orderDetails['buyer_agent_company'] = $retsPropertyDetails['agent']['contact']['office'];
                    $orderDetails['buyer_agent_address'] = $retsPropertyDetails['agent']['contact']['address'];
                    $officeMlsId = $retsPropertyDetails['agent']['id'];
                    $query = "?q=" . urlencode($officeMlsId);
            
                    // // print_r($query);
                    // echo "<br>";
                    $agentApiResult = $this->rets->callSimplyRetsAgent($query);
                    echo "<pre>";
                    print_r($agentApiResult);
                }
            }

        // }
        echo "<pre>";
        print_r($retsPropertyDetails['agent']);die;
        $this->order->sendClosedOrderAgentEmail($orderDetails);

    }

    public function createPipeDriveContact($address) {
        try {
            $this->load->library('order/rets');
            $address = "1750 La Mesa Oaks Dr";
            $address = $this->normalizeAddress($address);
            
            $query = "?q=" . urlencode($address);
            
            // print_r($query);die;
            
            $result = $this->rets->callSimplyRets($query);
            return json_decode($result, true);
        } catch (\Throwable $e) {
            echo "Login failed: " . $e->getMessage();die;
        }
    }

    public function sendThankYouEmailForClosedOrder($fileNumbers)
    {
        $this->db->select('order_details.file_id,
            order_details.file_number,
            order_details.id as order_id,
            order_details.resware_status,
            order_details.resware_closed_status_date,
            property_details.full_address,
            client.first_name,
            client.last_name,
            client.email_address as sales_email,
            client.sales_rep_profile_thank_you_img,
            property_details.escrow_lender_id,
            escrow_details.email_address,
            transaction_details.sales_representative');
        $this->db->from('order_details');
        $this->db->where_in('order_details.file_number', $fileNumbers);
        //$this->db->where('order_details.is_thank_you_email_sent', 0);
        $this->db->where('order_details.customer_id > 0');
        $this->db->where('property_details.escrow_lender_id != ""');
        $this->db->where('transaction_details.sales_representative != ""');
        $this->db->join('property_details', 'order_details.property_id = property_details.id', 'inner');
        $this->db->join('transaction_details', 'order_details.transaction_id = transaction_details.id', 'inner');
        $this->db->join('customer_basic_details as client ', 'client.id = order_details.customer_id', 'inner');
        $this->db->join('customer_basic_details as sales_details ', 'sales_details.id = transaction_details.sales_representative', 'inner');
        $this->db->join('customer_basic_details as escrow_details', 'escrow_details.id = property_details.escrow_lender_id', 'inner');
        $this->db->join('agents as buyer_agent', 'buyer_agent.id = property_details.buyer_agent_id', 'left');
        $this->db->join('agents as listing_agent', 'listing_agent.id = property_details.listing_agent_id', 'left');
        $this->db->order_by('transaction_details.sales_representative asc, property_details.escrow_lender_id asc');
        $query  = $this->db->get();
        $result = $query->result_array();

        if (!empty($result)) {
            $checkFlag = 0;
            $data      = [];
            $i         = 0;
            foreach ($result as $res) {
                if ($checkFlag == 0) {
                    $sales_rep_user_id    = $res['sales_representative'];
                    $escrow_user_id       = $res['escrow_lender_id'];
                    $escrow_email_address = $res['email_address'];
                    $checkFlag            = 1;
                }
                if ($res['sales_representative'] == $sales_rep_user_id && $res['escrow_lender_id'] == $escrow_user_id) {
                    $data['order_info'][$i]['order_number']   = $res['file_number'];
                    $data['order_info'][$i]['address']        = $res['full_address'];
                    $data['order_info'][$i]['resware_status'] = $res['resware_status'] ? $res['resware_status'] : 'closed';
                    $data['order_info'][$i]['closed_date']    = date("m/d/Y", strtotime($res['resware_closed_status_date']));
                    $data['sales_rep_profile_thank_you_img']  = !empty($res['sales_rep_profile_thank_you_img']) ? $res['sales_rep_profile_thank_you_img'] : '';
                    if (!empty($data['sales_rep_profile_thank_you_img'])) {
                        $data['sales_rep_profile_thank_you_img'] = env('AWS_PATH') . str_replace('uploads/', '', $data['sales_rep_profile_thank_you_img']);
                    }
                    $data['sales_email'] = !empty($res['sales_email']) ? $res['sales_email'] : '';
                    $i++;
                } else {
                    $message    = $this->load->view('emails/thank_you_escrow.php', $data, true);
                    $from_name  = 'Pacific Coast Title Company';
                    $from_mail  = env('FROM_EMAIL');
                    $subject    = 'Thank You!';
                    $to         = $escrow_email_address;
                    $cc         = ['ghernandez@pct.com', $data['sales_email']];
                    $mailParams = [
                        'from_mail' => $from_mail,
                        'from_name' => $from_name,
                        'to'        => $to,
                        'subject'   => $subject,
                        'message'   => json_encode($data),
                        'cc'        => $data['sales_email'],
                    ];
                    // $to = 'piyush.j@crestinfosystems.net';
                    $cc = [];
                    $this->load->helper('sendemail');
                    $logid              = $this->apiLogs->syncLogs(0, 'sendgrid', 'send_mail_to_escrow_user', '', $mailParams, [], $res['order_id'], 0);
                    $escrow_mail_result = send_email($from_mail, $from_name, $to, $subject, $message, [], $cc);
                    $this->apiLogs->syncLogs(0, 'sendgrid', 'send_mail_to_escrow_user', '', $mailParams, ['status' => $escrow_mail_result], $res['orderId'], $logid);
                    $data                                     = [];
                    $sales_rep_user_id                        = $res['sales_representative'];
                    $escrow_user_id                           = $res['escrow_lender_id'];
                    $escrow_email_address                     = $res['email_address'];
                    $data['order_info'][$i]['order_number']   = $res['file_number'];
                    $data['order_info'][$i]['address']        = $res['full_address'];
                    $data['order_info'][$i]['resware_status'] = $res['resware_status'] ? $res['resware_status'] : 'closed';
                    $data['order_info'][$i]['closed_date']    = date("m/d/Y", strtotime($res['resware_closed_status_date']));
                    $data['sales_rep_profile_thank_you_img']  = !empty($res['sales_rep_profile_thank_you_img']) ? $res['sales_rep_profile_thank_you_img'] : '';
                    if (!empty($data['sales_rep_profile_thank_you_img'])) {
                        $data['sales_rep_profile_thank_you_img'] = env('AWS_PATH') . str_replace('uploads/', '', $data['sales_rep_profile_thank_you_img']);
                    }
                    $data['sales_email'] = !empty($res['sales_email']) ? $res['sales_email'] : '';
                    $i++;
                }
                $sales_email = $res['sales_email'];
                $order_id    = $res['order_id'];
            }
            if (!empty($data)) {
                $message   = $this->load->view('emails/thank_you_escrow.php', $data, true);
                $from_name = 'Pacific Coast Title Company';
                $from_mail = env('FROM_EMAIL');
                $subject   = 'Thank You!';
                $to        = $escrow_email_address;

                $cc = ['ghernandez@pct.com', $sales_email];
                $this->load->helper('sendemail');
                $mailParams = [
                    'from_mail' => $from_mail,
                    'from_name' => $from_name,
                    'to'        => $to,
                    'subject'   => $subject,
                    'message'   => json_encode($data),
                    'cc'        => $sales_email,
                ];
                // $to = 'piyush.j@crestinfosystems.net';
                $cc = [];

                $logid              = $this->apiLogs->syncLogs(0, 'sendgrid', 'send_mail_to_escrow_user', '', $mailParams, [], $order_id, 0);
                $escrow_mail_result = send_email($from_mail, $from_name, $to, $subject, $message, [], $cc);
                $this->apiLogs->syncLogs(0, 'sendgrid', 'send_mail_to_escrow_user', '', $mailParams, ['status' => $escrow_mail_result], $order_id, $logid);
            }
            $order_details = [
                'is_thank_you_email_sent' => 1,
            ];
            // $this->db->where_in('order_details.file_number', $fileNumbers);
            // $this->db->update('order_details', $order_details);
            echo "Mails sent successfully to Escow user ";exit;
        }
    }

    public function getFileNumbers()
    {
        $fileNumbers = [];
        $this->db->select('*');
        $this->db->from('pct_order_api_logs');
        $this->db->where('request_type', 'get_prelim');
        $this->db->order_by('id', 'DESC');
        $this->db->limit(200);
        $query  = $this->db->get();
        $result = $query->result_array();
        foreach ($result as $res) {
            $data = json_decode($res['response_data'], true);
            if (isset($data['FileNumber']) && ! in_array($data['FileNumber'], $fileNumbers)) {
                $fileNumbers[] = $data['FileNumber'];
            }
        }
        echo "<pre>";
        print_r($fileNumbers);
        echo "All prelim data synced successfully";
    }

    public function update_databackup_partner()
    {
        $table = 'order_details';
        $this->load->library('order/resware');
        $this->db->select('id,file_id');
        $this->db->from($table);
        $this->db->where('is_imported', 1);
        $this->db->where('is_added_databackup_partner', 0);
        $this->db->order_by('id', 'asc');
        $this->db->limit(10000);
        $query                  = $this->db->get();
        $result                 = $query->result();
        $user_data              = [];
        $user_data['admin_api'] = 1;
        foreach ($result as $record) {
            $file_id        = $record->file_id;
            $endPoint       = 'files/' . $file_id . '/partners';
            $resultPartners = $this->resware->make_request('GET', $endPoint, '', $user_data);
            $resPartners    = json_decode($resultPartners, true);
            $key            = '';
            if (!empty($resPartners)) {
                $key = array_search(10049, array_column($resPartners['Partners'], 'PartnerTypeID'));
                if (isset($key) && strlen($key) > 0) {
                    $order_details = [
                        'is_added_databackup_partner' => 1,
                    ];
                    $condition = [
                        'file_id' => $file_id,
                    ];
                    $this->db->update($table, $order_details, $condition);
                } else {
                    $partners = [
                        'PartnerTypeID' => 10049,
                        'PartnerID'     => 400023,
                        'PartnerType'   => [
                            'PartnerTypeID' => 10049,
                        ],
                    ];
                    $partnerData   = json_encode(['Partners' => $partners]);
                    $endPoint      = 'files/' . $file_id . '/partners';
                    $logid         = $this->apiLogs->syncLogs(0, 'resware', 'add_partner', env('RESWARE_ORDER_API') . $endPoint, $partnerData, [], 0, 0);
                    $resultPartner = $this->make_request('POST', $endPoint, $partnerData, $user_data);
                    $this->apiLogs->syncLogs(0, 'resware', 'add_partner', env('RESWARE_ORDER_API') . $endPoint, $partnerData, $resultPartner, 0, $logid);
                    if (empty($resultPartner)) {
                        $order_details = [
                            'is_added_databackup_partner' => 1,
                        ];
                        $condition = [
                            'file_id' => $file_id,
                        ];
                        $this->db->update($table, $order_details, $condition);
                    }
                }

            }
        }
    }

    public function sendDailyProductionReport()
    {
        $result = $this->order->sendDailyProductionReport(0);
        echo "Mails sent successfully to Sales Managers";exit;
    }

    public function sendDailyProductionTOReport()
    {
        $result = $this->order->sendDailyProductionTOReport(0);
        echo "Mails sent successfully to Title Officers";exit;
    }

    public function sendLPReports()
    {
        $result = $this->order->sendLPReports(0);
        echo "Mails sent successfully to Sales Managers";exit;
    }

    public function generateAllDocumentFromTitlePoint($file_number)
    {
        $this->load->model('order/apiLogs');
        $titlePointInstrumentDetails = $this->titlePointData->getInstrumentDetails($file_number, 1);
        if (!empty($titlePointInstrumentDetails)) {
            foreach ($titlePointInstrumentDetails as $insDetail) {
                $fileExist = $this->order->fileExistOrNotOnS3("title-point/" . $insDetail['id'] . '.pdf');
                if ($fileExist) {
                    continue;
                }
                $recordedDate = $insDetail['recorded_date'];
                $docId        = $insDetail['instrument'];
                $fips         = $insDetail['fips'];
                $type         = $insDetail['type'];
                $sub_type     = $insDetail['sub_type'];
                $order_number = $insDetail['order_number'];

                if (isset($recordedDate) && !empty($recordedDate)) {
                    $time = strtotime($recordedDate);
                    $year = date('Y', $time);
                }

                if (!empty($order_number)) {
                    $parameters = 'FIPS=' . $fips . ',TYPE=' . $type . ',ORDER=' . $order_number . ',SUBTYPE=' . $sub_type . ',YEAR=' . $year . ',INST=' . $docId . '';
                } else {
                    $parameters = 'FIPS=' . $fips . ',TYPE=REC,SUBTYPE=ALL,YEAR=' . $year . ',INST=' . $docId . '';
                }

                $docId         = (string) ((int) ($docId));
                $requestParams = [
                    'parameters'     => $parameters,
                    'username'       => env('TP_USERNAME'),
                    'password'       => env('TP_PASSWORD'),
                    'company'        => '',
                    'department'     => '',
                    'titleOfficer'   => '',
                    'pages'          => '',
                    'propertyOnly'   => 'FALSE',
                    'maxPageCount'   => 0,
                    'maxSizeInKB'    => 0,
                    'additionalInfo' => '',
                    'customerRef'    => '',
                    'fileType'       => 'PDF',
                ];

                $request = env('GRANT_DEED_ENDPOINT') . http_build_query($requestParams);

                $opts = [
                    "ssl" => [
                        "verify_peer"      => false,
                        "verify_peer_name" => false,
                    ],
                ];

                $context  = stream_context_create($opts);
                $logid    = $this->apiLogs->syncLogs(0, 'titlepoint', 'generate_instrument_document', $request, $requestParams, [], $file_number, 0);
                $file     = file_get_contents($request, false, $context);
                $xmlData  = simplexml_load_string($file);
                $response = json_encode($xmlData);
                $result   = json_decode($response, true);
                $this->apiLogs->syncLogs(0, 'titlepoint', 'generate_instrument_document', $request, $requestParams, $result, $file_number, $logid);
                $responseStatus = isset($result['Status']['Msg']) && !empty($result['Status']['Msg']) ? $result['Status']['Msg'] : '';
                $docStatus      = isset($result['Documents']['DocumentResponse']['DocStatus']['Msg']) && !empty($result['Documents']['DocumentResponse']['DocStatus']['Msg']) ? $result['Documents']['DocumentResponse']['DocStatus']['Msg'] : '';
                $docStatus      = strtolower($docStatus);

                if (isset($docStatus) && !empty($docStatus) && $docStatus == 'ok') {
                    $base64_data = isset($result['Documents']['DocumentResponse']['Document']['Body']['Body']) && !empty($result['Documents']['DocumentResponse']['Document']['Body']['Body']) ? $result['Documents']['DocumentResponse']['Document']['Body']['Body'] : '';

                    if (isset($base64_data) && !empty($base64_data)) {
                        $bin = base64_decode($base64_data, true);

                        if (! is_dir('uploads/title-point')) {
                            mkdir('./uploads/title-point', 0777, true);
                        }
                        $fileExist = $this->order->fileExistOrNotOnS3("title-point/" . $insDetail['id'] . '.pdf');
                        if ($fileExist) {

                        }
                        $pdfFilePath = './uploads/title-point/' . $insDetail['id'] . '.pdf';
                        file_put_contents($pdfFilePath, $bin);
                        $this->order->uploadDocumentOnAwsS3($insDetail['id'] . '.pdf', 'title-point');
                    }
                }
            }
        }
    }

    public function generateTaxDocument($requestId, $orderId, $fileNumber)
    {
        $userdata      = $this->session->userdata('user');
        $requestParams = [
            'username'  => env('TP_USERNAME'),
            'password'  => env('TP_PASSWORD'),
            'requestId' => $requestId,
        ];
        // print_r($requestParams);die;
        $request    = env('TP_GENERATE_IMAGE') . http_build_query($requestParams);
        $requestUrl = env('TP_GENERATE_IMAGE');
        $logid      = $this->apiLogs->syncLogs($userdata['id'], 'titlepoint', 'generate_tax_image_BG', $request, $requestParams, [], $orderId, 0);
        $response   = $this->order->curl_post($requestUrl, $requestParams);

        $result = json_decode($response, true);

        $this->apiLogs->syncLogs($userdata['id'], 'titlepoint', 'generate_tax_image_BG', $request, $response, $result, $orderId, $logid);

        $imgReturnStatus = isset($result['ReturnStatus']) && !empty($result['ReturnStatus']) ? $result['ReturnStatus'] : '';
        $imgReturnStatus = strtolower($imgReturnStatus);

        $generateImgStatus = isset($result['Status']) && !empty($result['Status']) ? $result['Status'] : '';
        $generateImgStatus = strtolower($generateImgStatus);

        if ($imgReturnStatus == 'success') {
            if ($generateImgStatus == 'processing') {
                if ($this->taxcount <= 10) {
                    sleep(3);
                    $this->taxcount = $this->taxcount + 1;
                    return $this->generateTaxDocument($requestId, $orderId, $fileNumber);
                } else {
                    $generateImgStatus = 'failed';
                }
            } else if ($generateImgStatus == 'success') {
                $base64_data = isset($result['Data']) && !empty($result['Data']) ? $result['Data'] : '';

                if (isset($base64_data) && !empty($base64_data)) {
                    $bin = base64_decode($base64_data, true);

                    if (! is_dir('uploads/tax')) {
                        mkdir('./uploads/tax', 0777, true);
                    }

                    $pdfFilePath = './uploads/tax/' . $fileNumber . '.pdf';
                    file_put_contents($pdfFilePath, $bin);
                    $this->order->uploadDocumentOnAwsS3($fileNumber . '.pdf', 'tax');
                }
            }
        }

        $tpData = [
            'tax_file_status' => $generateImgStatus,
        ];

        $condition = [
            'file_number' => $fileNumber,
        ];
        $this->titlePointData->update($tpData, $condition);

        $condition = [
            'where' => [
                'file_number' => $fileNumber,
            ],
        ];
        $titlePointDetails = $this->titlePointData->gettitlePointDetails($condition);
        $lvDocStatus       = strtolower($titlePointDetails[0]['lv_file_status']);
        $taxDataStatus     = strtolower($titlePointDetails[0]['tax_data_status']);
        $taxDocStatus      = strtolower($titlePointDetails[0]['tax_file_status']);
        $emailSentFlag     = strtolower($titlePointDetails[0]['email_sent_status']);
        $this->apiLogs->syncLogs(0, 'email-check-Tax', 'email-check-Tax', '', ['$emailSentFlag' => $emailSentFlag, '$taxDocStatus' => $taxDocStatus, 'tax_data_status' => $taxDataStatus, '$lvDocStatus' => $lvDocStatus], [], 0, 0);
        // if ($emailSentFlag != 1  && ($taxDocStatus == 'success' || $taxDocStatus == 'failed' || $taxDocStatus == 'exception') && ($lvDocStatus == 'success' || $lvDocStatus == 'failed' || $lvDocStatus == 'exception'))
        if ($emailSentFlag != 1 && ($lvDocStatus == 'success' || $lvDocStatus == 'failed' || $lvDocStatus == 'exception') && ($taxDocStatus == 'success' || $taxDocStatus == 'failed' || $taxDocStatus == 'exception')) {
            $this->order->sendOrderEmail($fileNumber);
            $this->session->set_userdata('email_sent_flag', 1);
        }
    }

    public function generateLVDocument($requestId, $orderId, $fileNumber)
    {
        $userdata      = $this->session->userdata('user');
        $requestParams = [
            'username'  => env('TP_USERNAME'),
            'password'  => env('TP_PASSWORD'),
            'requestId' => $requestId,
        ];

        $request     = env('TP_GENERATE_IMAGE') . http_build_query($requestParams);
        $requestName = 'generate_lv_image';
        $requestUrl  = env('TP_GENERATE_IMAGE');
        $logid       = $this->apiLogs->syncLogs($userdata['id'], 'titlepoint', 'generate_lv_image_BG', $request, $requestParams, [], $orderId, 0);
        $response    = $this->order->curl_post($requestUrl, $requestParams);

        $result = json_decode($response, true);
        $this->apiLogs->syncLogs($userdata['id'], 'titlepoint', 'generate_lv_image_BG', $request, $requestParams, $result, $orderId, $logid);

        $imgReturnStatus = isset($result['ReturnStatus']) && !empty($result['ReturnStatus']) ? $result['ReturnStatus'] : '';
        $imgReturnStatus = strtolower($imgReturnStatus);

        $generateImgStatus = isset($result['Status']) && !empty($result['Status']) ? $result['Status'] : '';
        $generateImgStatus = strtolower($generateImgStatus);

        if ($imgReturnStatus == 'success') {
            if ($generateImgStatus == 'processing') {
                if ($this->lvcount <= 10) {
                    sleep(3);
                    $this->lvcount += 1;
                    return $this->generateLVDocument($requestId, $orderId, $fileNumber);
                } else {
                    $generateImgStatus = 'failed';
                }
            } else if ($generateImgStatus == 'success') {
                $base64_data = isset($result['Data']) && !empty($result['Data']) ? $result['Data'] : '';

                if (isset($base64_data) && !empty($base64_data)) {
                    $bin = base64_decode($base64_data, true);

                    if (! is_dir('uploads/legal-vesting')) {
                        mkdir('./uploads/legal-vesting', 0777, true);
                    }
                    $pdfFilePath = './uploads/legal-vesting/' . $fileNumber . '.pdf';
                    file_put_contents($pdfFilePath, $bin);
                    $this->order->uploadDocumentOnAwsS3($fileNumber . '.pdf', 'legal-vesting');
                }
            }
        }

        $tpData = [
            'lv_file_status' => $generateImgStatus,
        ];

        $condition = [
            'file_number' => $fileNumber,
        ];
        $this->titlePointData->update($tpData, $condition);

        $condition = [
            'where' => [
                'file_number' => $fileNumber,
            ],
        ];
        $titlePointDetails = $this->titlePointData->gettitlePointDetails($condition);
        $lvDocStatus       = strtolower($titlePointDetails[0]['lv_file_status']);
        $taxDataStatus     = strtolower($titlePointDetails[0]['tax_data_status']);
        $taxDocStatus      = strtolower($titlePointDetails[0]['tax_file_status']);
        $emailSentFlag     = strtolower($titlePointDetails[0]['email_sent_status']);
        $this->apiLogs->syncLogs(0, 'email-check-LV', 'email-check-LV', '', ['$emailSentFlag' => $emailSentFlag, '$taxDocStatus' => $taxDocStatus, '$taxDataStatus' => $taxDataStatus, '$lvDocStatus' => $lvDocStatus], [], 0, 0);
        // if ($emailSentFlag != 1  && ($taxDocStatus == 'success' || $taxDocStatus == 'failed' || $taxDocStatus == 'exception') && ($lvDocStatus == 'success' || $lvDocStatus == 'failed' || $lvDocStatus == 'exception'))
        if ($emailSentFlag != 1 && ($lvDocStatus == 'success' || $lvDocStatus == 'failed' || $lvDocStatus == 'exception') && ($taxDocStatus == 'success' || $taxDocStatus == 'failed' || $taxDocStatus == 'exception')) {
            $this->order->sendOrderEmail($fileNumber);
            $this->session->set_userdata('email_sent_flag', 1);
        }

    }

    public function updateAllowDuplicationFlag()
    {
        $this->db->select('order_details.property_id');
        $this->db->from('order_details');
        $this->db->where('order_details.softpro_status = "closed" OR order_details.softpro_status = "clear for policy"');
        $this->db->where('property_details.allow_duplication = 0');
        $this->db->join('property_details', 'order_details.property_id = property_details.id', 'inner');
        $this->db->order_by("order_details.id", "desc");
        $query       = $this->db->get();
        $filesResult = $query->result_array();

        $duplicationUpdateArray = [];
        if (isset($filesResult) && !empty($filesResult)) {
            foreach ($filesResult as $file) {
                $duplicationUpdateArray[] = $file['property_id'];
            }
        }

        if (!empty($duplicationUpdateArray)) {
            $chunk = array_chunk($duplicationUpdateArray, 500);
            for ($i = 0; $i < count($chunk); $i++) {
                $updateDuplicationData = ['allow_duplication' => 1];
                $this->db->set($updateDuplicationData);
                $this->db->where_in("id", $chunk[$i]);
                $this->db->update('property_details');
            }
        }
    }

    public function updateLpReportStatus()
    {
        $this->db->select('*');
        $this->db->from('order_details');
        $this->db->where('lp_file_number IS NOT NULL');
        $this->db->where('file_number IS NOT NULL and file_number != 0');
        $query  = $this->db->get();
        $result = $query->result_array();

        if (!empty($result)) {
            foreach ($result as $res) {
                $orderData = [
                    'lp_report_status' => 'converted',
                ];
                $condition = [
                    'file_id' => $res['file_id'],
                ];

                $this->home_model->update($orderData, $condition, 'order_details');
            }
        }

    }

    public function updateLpReportStatusForOldOrders()
    {
        $this->db->select('*');
        $this->db->from('order_details');
        $this->db->where('lp_file_number IS NOT NULL');
        $this->db->where('created_at <= (NOW() - INTERVAL 90 DAY)');
        $this->db->where('lp_report_status', 'pending');
        $query  = $this->db->get();
        $result = $query->result_array();

        if (!empty($result)) {
            foreach ($result as $res) {
                $orderData = [
                    'lp_report_status' => 'denied',
                ];
                $condition = [
                    'file_id' => $res['file_id'],
                ];

                $this->home_model->update($orderData, $condition, 'order_details');
            }
        }
    }

    public function getIdealUsers()
    {
        $startDate = date('Y-m-d 00:00:00', strtotime('-97 days', strtotime(date('Y-m-d'))));
        $endDate   = date('Y-m-d 23:59:59', strtotime('-7 days', strtotime(date('Y-m-d'))));
        $this->db->select('*')
            ->from('order_details')
            ->join('transaction_details', 'order_details.transaction_id = transaction_details.id');
        $this->db->where('order_details.lp_file_number is not null');
        $this->db->where('order_details.created_at BETWEEN "' . $startDate . '" and "' . $endDate . '"');
        $this->db->where_in('transaction_details.sales_representative', 11942);
        $this->db->where('order_details.`is_imported` = 0');
        $this->db->where('order_details.`file_number` != 0');
        $query = $this->db->get();
        echo $this->db->last_query();exit;
        $result = $query->result_array();
        return $result;
    }

    public function deleteOldLogs()
    {
        // Define the path to the logs directory
        $log_path = APPPATH . 'logs/';

                                              // Define the retention period (30 days)
        $retention_period = 5 * 24 * 60 * 60; // 30 days in seconds

        // Get the current time
        $current_time = time();

        // Open the logs directory
        if ($handle = opendir($log_path)) {
            while (false !== ($file = readdir($handle))) {
                // Skip current and parent directory links
                if ($file != "." && $file != "..") {
                    $file_path = $log_path . $file;

                    // Ensure it is a file and ends with .php
                    if (is_file($file_path) && pathinfo($file_path, PATHINFO_EXTENSION) == 'php') {
                        // Check if the file is older than the retention period
                        if (($current_time - filemtime($file_path)) > $retention_period) {
                            // Delete the file
                            unlink($file_path);
                            echo "Deleted old log file: $file\n";
                        }
                    }
                }
            }
            closedir($handle);
        }
    }

    public function softproOpenContactLookupCode()
    {
        ini_set('max_execution_time', 0);
        ini_set('memory_limit', '4048M');
        $this->load->library('order/softPro');
        $this->load->model('order/apiLogs');
        $req['userType'] = 'Order Contact - Person';
        // $queryParams['userType'] = 'Order Contact - Person';
        $queryParams = "userType=" . urlencode('Order Contact - Person');
        $reqData     = json_encode($req);

        // echo "<pre>";
        // print_r($existingAgent);
        $logid = $this->apiLogs->syncLogs($userdata['id'], 'softpro', 'fetch_lookup_code', 'fetch_lookup_code', $reqData, [], 0, 0);
        $response = $this->softpro->make_request('GET', 'fetch_lookup_code', $reqData, $queryParams);
        $this->apiLogs->syncLogs($userdata['id'], 'softpro', 'fetch_lookup_code', 'fetch_lookup_code', $reqData, json_encode($response), 0, $logid);
        
        if ($response['status'] == 'success') {
            // Get existing emails from the database
            $existing_lookupcode = $this->db->select('lookup_code')->from('pct_softpro_lookup_table')->get()->result_array();
            $existing_lookupcode = array_column($existing_lookupcode, 'lookup_code');

            $new_data = $response['data'];
            $update_data = [];
            $insert_data = [];
            // $insertCustomerData = [];
            foreach ($new_data as $key => $row) {
                if (!empty($row['Email'])) {
                    if (in_array(trim($row['LookupCode']), $existing_lookupcode)) {
                        // $update_data[$key]['lookup_code'] = $row['LookupCode'];
                        $update_data[$key]['flookup_code']   = $row['Filter: LookupCode'];
                        $update_data[$key]['courtesy_title'] = $row['CourtesyTitle'];
                        $update_data[$key]['first_name']     = $row['FirstName'];
                        $update_data[$key]['middle_name']    = $row['MiddleName'];
                        $update_data[$key]['last_name']      = $row['LastName'];
                        $update_data[$key]['email_address']  = trim($row['Email']);
                        $update_data[$key]['phone']          = $row['Phone'];
                        $update_data[$key]['phone_ext']      = $row['PhoneExt'];
                        $update_data[$key]['suffix']         = $row['Suffix'];
                        $update_data[$key]['title']          = $row['Title'];
                        $update_data[$key]['fax']            = $row['Fax'];
                        $update_data[$key]['cell']           = $row['Cell'];
                        $update_data[$key]['pager']          = $row['Pager'];
                        $update_data[$key]['gender_id']      = $row['GenderID'];
                        $update_data[$key]['address1']       = $row['Address1'];
                        $update_data[$key]['address2']       = $row['Address2'];
                        $update_data[$key]['city']           = $row['City'];
                        $update_data[$key]['state']          = $row['State'];
                        $update_data[$key]['zip']            = $row['Zip'];
                        $update_data[$key]['note']           = $row['Note'];
                        $update_data[$key]['license_no']     = $row['License No'];
                        $update_data[$key]['status']         = 1;
                        // $update_data[$key]['user_type'] = 'open_contact';
                    } else {
                        $insert_data[$key]['lookup_code']    = $row['LookupCode'];
                        $insert_data[$key]['flookup_code']   = $row['Filter: LookupCode'];
                        $insert_data[$key]['courtesy_title'] = $row['CourtesyTitle'];
                        $insert_data[$key]['first_name']     = $row['FirstName'];
                        $insert_data[$key]['middle_name']    = $row['MiddleName'];
                        $insert_data[$key]['last_name']      = $row['LastName'];
                        $insert_data[$key]['email_address']  = trim($row['Email']);
                        $insert_data[$key]['phone']          = $row['Phone'];
                        $insert_data[$key]['phone_ext']      = $row['PhoneExt'];
                        $insert_data[$key]['suffix']         = $row['Suffix'];
                        $insert_data[$key]['title']          = $row['Title'];
                        $insert_data[$key]['fax']            = $row['Fax'];
                        $insert_data[$key]['cell']           = $row['Cell'];
                        $insert_data[$key]['pager']          = $row['Pager'];
                        $insert_data[$key]['gender_id']      = $row['GenderID'];
                        $insert_data[$key]['address1']       = $row['Address1'];
                        $insert_data[$key]['address2']       = $row['Address2'];
                        $insert_data[$key]['city']           = $row['City'];
                        $insert_data[$key]['state']          = $row['State'];
                        $insert_data[$key]['zip']            = $row['Zip'];
                        $insert_data[$key]['note']           = $row['Note'];
                        $insert_data[$key]['license_no']     = $row['License No'];
                        $insert_data[$key]['status']         = 1;
                        $insert_data[$key]['user_type']      = 'open_contact';
                    }
                }

            }

            if (!empty($update_data)) {
                foreach ($update_data as $update_row) {
                    $this->db->where('lookup_code', $update_row['lookup_code']);
                    $this->db->update('pct_softpro_lookup_table', $update_row);
                }
            }

            if (!empty($insert_data)) {
                $this->db->insert_batch('pct_softpro_lookup_table', $insert_data);
            }

            $res = json_encode(['status' => 'success', 'updated' => count($update_data), 'inserted' => count($insert_data)]);
            $apiEndPoints = SOFTPRO_API_END;
            $url          = getenv("SOFT_PRO_API") . $apiEndPoints['fetch_lookup_code'] . '?' . $queryParams;
            $this->order->syncLogs('softpro', 'fetch_lookup_code', $url, $reqData, $res, 0, 0);
            print_r($res);
        }
    }

    public function softproEscrowCompanyLookupCode()
    {
        ini_set('max_execution_time', 0);
        ini_set('memory_limit', '2048M');
        $this->load->library('order/softPro');
        $this->load->model('order/apiLogs');
        $req['userType'] = 'Escrow Company';
        $queryParams = "userType=" . urlencode('Escrow Company');
        $reqData     = json_encode($req);
        $logid = $this->apiLogs->syncLogs($userdata['id'], 'softpro', 'fetch_lookup_code', 'fetch_lookup_code', $reqData, [], 0, 0);
        $response = $this->softpro->make_request('GET', 'fetch_lookup_code', $reqData, $queryParams);
        $this->apiLogs->syncLogs($userdata['id'], 'softpro', 'fetch_lookup_code', 'fetch_lookup_code', $reqData, json_encode($response), 0, $logid);
        
        if ($response['status'] == 'success') {
            // Get existing emails from the database
            $new_data = $response['data'];

            $existing_flookupcode = $this->db->select('flookup_code')->from('pct_softpro_lookup_table')->get()->result_array();
            $existing_flookupcode = array_column($existing_flookupcode, 'flookup_code');

            $existing_lookupcode = $this->db->select('lookup_code')->from('sp_company')->where('is_escrow_company', 1)->get()->result_array();
            $existing_lookupcode = array_column($existing_lookupcode, 'lookup_code');

            // Separate data into updates and inserts
            $update_data = $insert_data = $company_insert_data = $company_update_data = [];
            foreach ($new_data as $key => $row) {
                if (in_array($row['Lookup Code'], $existing_flookupcode)) {
                    $update_data[$key]['flookup_code'] = $row['Lookup Code'];
                    $update_data[$key]['company_name'] = $row['Name'];
                    $update_data[$key]['is_escrow']    = 1;
                    // $update_data[$key]['payee_name'] = $row['Payee Name'];
                    // $update_data[$key]['address1'] = $row['Address (line 1)'];
                    // $update_data[$key]['address2'] = $row['Address (line 2)'];
                    // $update_data[$key]['city'] = $row['City'];
                    // $update_data[$key]['state'] = $row['State'];
                    // $update_data[$key]['zip'] = $row['Zip'];
                    // $update_data[$key]['phone'] = $row['Phone'];
                    // $update_data[$key]['fax'] = $row['Fax'];
                    // $update_data[$key]['email_address'] = $row['Email'];
                    // $update_data[$key]['user_type'] = 'escrow_company';

                    // $update_data[$key]['signature_line'] = $row['Signature Line'];
                    // $update_data[$key]['fee_transfer_ledger'] = $row['Fee Transfer Ledger'];
                    // $update_data[$key]['state_of_incorporation'] = $row['State Of Incorporation'];
                    // $update_data[$key]['marketing_rep'] = $row['Marketing Rep'];
                    // $update_data[$key]['special_instructions'] = $row['Special Instructions'];
                } else {
                    // $insert_data[$key]['lookup_code'] = $row['Lookup Code'];
                    // $insert_data[$key]['first_name'] = $row['Name'];
                    // $insert_data[$key]['payee_name'] = $row['Payee Name'];
                    // $insert_data[$key]['address1'] = $row['Address (line 1)'];
                    // $insert_data[$key]['address2'] = $row['Address (line 2)'];
                    // $insert_data[$key]['city'] = $row['City'];
                    // $insert_data[$key]['state'] = $row['State'];
                    // $insert_data[$key]['zip'] = $row['Zip'];
                    // $insert_data[$key]['phone'] = $row['Phone'];
                    // $insert_data[$key]['fax'] = $row['Fax'];
                    // $insert_data[$key]['email_address'] = $row['Email'];
                    // $insert_data[$key]['user_type'] = 'escrow_company';

                    // $insert_data[$key]['signature_line'] = $row['Signature Line'];
                    // $insert_data[$key]['fee_transfer_ledger'] = $row['Fee Transfer Ledger'];
                    // $insert_data[$key]['state_of_incorporation'] = $row['State Of Incorporation'];
                    // $insert_data[$key]['marketing_rep'] = $row['Marketing Rep'];
                    // $insert_data[$key]['special_instructions'] = $row['Special Instructions'];
                }

                if (in_array($row['Lookup Code'], $existing_lookupcode)) {
                    $company_update_data[$key]['lookup_code']       = $row['Lookup Code'];
                    $company_update_data[$key]['name']              = $row['Name'];
                    $company_update_data[$key]['is_escrow_company'] = 1;
                    $company_update_data[$key]['payee_name']        = $row['Payee Name'];
                    $company_update_data[$key]['address1']          = $row['Address (line 1)'];
                    $company_update_data[$key]['address2']          = $row['Address (line 2)'];
                    $company_update_data[$key]['city']              = $row['City'];
                    $company_update_data[$key]['state']             = $row['State'];
                    $company_update_data[$key]['zip']               = $row['Zip'];
                    $company_update_data[$key]['phone']             = $row['Phone'];
                    $company_update_data[$key]['fax']               = $row['Fax'];
                    $company_update_data[$key]['email_address']     = $row['Email'];
                    // $update_data[$key]['user_type']         = 'escrow_company';

                    $company_update_data[$key]['signature_line']         = $row['Signature Line'];
                    $company_update_data[$key]['fee_transfer_ledger']    = $row['Fee Transfer Ledger'];
                    $company_update_data[$key]['state_of_incorporation'] = $row['State Of Incorporation'];
                    $company_update_data[$key]['marketing_rep']          = $row['Marketing Rep'];
                    $company_update_data[$key]['special_instructions']   = $row['Special Instructions'];
                    // $company_update_data[$key]['row_state']              = $row['Row State'];
                } else {
                    $company_insert_data[$key]['lookup_code']       = $row['Lookup Code'];
                    $company_insert_data[$key]['name']              = $row['Name'];
                    $company_insert_data[$key]['is_escrow_company'] = 1;
                    $company_insert_data[$key]['payee_name']        = $row['Payee Name'];
                    $company_insert_data[$key]['address1']          = $row['Address (line 1)'];
                    $company_insert_data[$key]['address2']          = $row['Address (line 2)'];
                    $company_insert_data[$key]['city']              = $row['City'];
                    $company_insert_data[$key]['state']             = $row['State'];
                    $company_insert_data[$key]['zip']               = $row['Zip'];
                    $company_insert_data[$key]['phone']             = $row['Phone'];
                    $company_insert_data[$key]['fax']               = $row['Fax'];
                    $company_insert_data[$key]['email_address']     = $row['Email'];
                    // $company_insert_data[$key]['user_type'] = 'escrow_company';

                    $company_insert_data[$key]['signature_line']         = $row['Signature Line'];
                    $company_insert_data[$key]['fee_transfer_ledger']    = $row['Fee Transfer Ledger'];
                    $company_insert_data[$key]['state_of_incorporation'] = $row['State Of Incorporation'];
                    $company_insert_data[$key]['marketing_rep']          = $row['Marketing Rep'];
                    $company_insert_data[$key]['special_instructions']   = $row['Special Instructions'];
                    // $company_insert_data[$key]['row_state']              = $row['Row State'];
                }
            }
            // Perform batch update for existing emails
            if (!empty($update_data)) {
                foreach ($update_data as $update_row) {
                    $this->db->where('flookup_code', $update_row['flookup_code']);
                    $this->db->update('pct_softpro_lookup_table', $update_row);
                }
            }

            if (!empty($company_update_data)) {
                foreach ($company_update_data as $update_row) {
                    $this->db->where('lookup_code', $update_row['lookup_code']);
                    $this->db->update('sp_company', $update_row);
                }
            }

            // Perform batch insert for new emails
            if (!empty($company_insert_data)) {
                $this->db->insert_batch('sp_company', $company_insert_data);
            }
            $res = json_encode(['status' => 'success', 'updated' => count($update_data), 'inserted' => count($insert_data), 'company_updated' => count($company_update_data), 'company_inserted' => count($company_insert_data)]);
            $apiEndPoints = SOFTPRO_API_END;
            $url          = getenv("SOFT_PRO_API") . $apiEndPoints['fetch_lookup_code'] . '?' . $queryParams;
            $this->order->syncLogs('softpro', 'fetch_lookup_code', $url, $reqData, $res, 0, 0);
            print_r($res);
        }
    }

    public function softproEscrowOfficerLookupCode()
    {
        ini_set('max_execution_time', 0);
        ini_set('memory_limit', '2048M');
        $this->load->library('order/softPro');
        $this->load->model('order/apiLogs');
        $req['userType'] = 'Escrow Officer';
        // $queryParams['userType'] = 'Escrow Officer';
        $queryParams = "userType=" . urlencode('Escrow Officer');
        $reqData     = json_encode($req);
        $logid = $this->apiLogs->syncLogs($userdata['id'], 'softpro', 'fetch_lookup_code', 'fetch_lookup_code', $reqData, [], 0, 0);
        $response = $this->softpro->make_request('GET', 'fetch_lookup_code', $reqData, $queryParams);
        $this->apiLogs->syncLogs($userdata['id'], 'softpro', 'fetch_lookup_code', 'fetch_lookup_code', $reqData, json_encode($response), 0, $logid);
        
        if ($response['status'] == 'success') {
            // Get existing emails from the database
            $new_data            = $response['data'];
            $existing_lookupcode = $this->db->select('closer_examiner')->from('pct_softpro_lookup_table')->where('is_escrow_officer', 1)->get()->result_array();
            $existing_lookupcode = array_column($existing_lookupcode, 'closer_examiner');

            // Separate data into updates and inserts
            $update_data = [];
            $insert_data = [];
            foreach ($new_data as $key => $row) {
                if (in_array($row['Escrow officer/Closer'], $existing_lookupcode)) {
                    $update_data[$key]['closer_examiner'] = $row['Escrow officer/Closer'];
                    $update_data[$key]['lookup_code']     = $row['Office LookupCode'];
                    $update_data[$key]['officer_name']    = $row['Officer Name'];
                    $update_data[$key]['email_address']    = $row['Email'];
                } else {
                    $insert_data[$key]['closer_examiner']   = $row['Escrow officer/Closer'];
                    $insert_data[$key]['lookup_code']       = $row['Office LookupCode'];
                    $insert_data[$key]['officer_name']      = $row['Officer Name'];
                    $insert_data[$key]['email_address']    = $row['Email'];
                    $insert_data[$key]['is_escrow_officer'] = 1;
                }
            }

            // Perform batch update for existing emails
            if (!empty($update_data)) {
                foreach ($update_data as $update_row) {
                    $this->db->where('closer_examiner', $update_row['closer_examiner']);
                    $this->db->where('is_escrow_officer', 1);
                    $this->db->update('pct_softpro_lookup_table', $update_row);
                }
            }

            // Perform batch insert for new emails
            if (!empty($insert_data)) {
                $this->db->insert_batch('pct_softpro_lookup_table', $insert_data);
            }

            $res = json_encode(['status' => 'success', 'updated' => count($update_data), 'inserted' => count($insert_data)]);
            $apiEndPoints = SOFTPRO_API_END;
            $url          = getenv("SOFT_PRO_API") . $apiEndPoints['fetch_lookup_code'] . '?' . $queryParams;
            $this->order->syncLogs('softpro', 'fetch_lookup_code', $url, $reqData, $res, 0, 0);
            print_r($res);
        }
    }

    public function softproLenderLookupCode()
    {
        ini_set('max_execution_time', 0);
        ini_set('memory_limit', '2048M');
        $this->load->library('order/softPro');
        $this->load->model('order/apiLogs');
        $req['userType'] = 'Lender';
        // $queryParams['userType'] = 'Lender';
        $queryParams = "userType=" . urlencode('Lender');
        $reqData     = json_encode($req);
        $logid = $this->apiLogs->syncLogs($userdata['id'], 'softpro', 'fetch_lookup_code', 'fetch_lookup_code', $reqData, [], 0, 0);
        $response = $this->softpro->make_request('GET', 'fetch_lookup_code', $reqData, $queryParams);
        $this->apiLogs->syncLogs($userdata['id'], 'softpro', 'fetch_lookup_code', 'fetch_lookup_code', $reqData, json_encode($response), 0, $logid);
        // echo "<pre> Lender";
        // print_r($response);
        // echo "Hello";die;
        if ($response['status'] == 'success') {
            // Get existing emails from the database
            $new_data             = $response['data'];
            $existing_flookupcode = $this->db->select('flookup_code')->from('pct_softpro_lookup_table')->get()->result_array();
            $existing_flookupcode = array_column($existing_flookupcode, 'flookup_code');

            $existing_lookupcode = $this->db->select('lookup_code')->from('sp_company')->where('is_lender', 1)->get()->result_array();
            $existing_lookupcode = array_column($existing_lookupcode, 'lookup_code');

            // Separate data into updates and inserts
            $update_data = $insert_data = $company_insert_data = $company_update_data = [];
            foreach ($new_data as $key => $row) {
                if (in_array($row['LookupCode'], $existing_flookupcode)) {
                    $update_data[$key]['flookup_code'] = $row['LookupCode'];
                    $update_data[$key]['company_name'] = $row['Name'];
                    $update_data[$key]['is_lender']    = 1;
                } else {
                }

                if (in_array($row['LookupCode'], $existing_lookupcode)) {
                    $company_update_data[$key]['name']      = $row['Name'];
                    $company_update_data[$key]['is_lender'] = 1;

                    $company_update_data[$key]['lookup_code']   = $row['LookupCode'];
                    $company_update_data[$key]['payee_name']    = $row['PayeeName'];
                    $company_update_data[$key]['address1']      = $row['Address1'];
                    $company_update_data[$key]['address2']      = $row['Address2'];
                    $company_update_data[$key]['city']          = $row['City'];
                    $company_update_data[$key]['state']         = $row['State'];
                    $company_update_data[$key]['zip']           = $row['Zip'];
                    $company_update_data[$key]['phone']         = $row['Phone'];
                    $company_update_data[$key]['fax']           = $row['Fax'];
                    $company_update_data[$key]['email_address'] = $row['Email'];

                    $company_update_data[$key]['legal_name']             = $row['LegalName'];
                    $company_update_data[$key]['fee_transfer_ledger']    = $row['FeeTransferLedger'];
                    $company_update_data[$key]['state_of_incorporation'] = $row['StateOfIncorporation'];
                    $company_update_data[$key]['marketing_rep']          = $row['MarketingRep'];
                    $company_update_data[$key]['funding_address1']       = $row['FundingAddress1'];
                    $company_update_data[$key]['funding_address2']       = $row['FundingAddress2'];
                    $company_update_data[$key]['funding_city']           = $row['FundingCity'];
                    $company_update_data[$key]['funding_state']          = $row['FundingState'];
                    $company_update_data[$key]['funding_zip']            = $row['FundingZip'];
                    $company_update_data[$key]['funding_phone']          = $row['FundingPhone'];
                    $company_update_data[$key]['funding_fax']            = $row['FundingFax'];
                    $company_update_data[$key]['special_instructions']   = $row['Special Instructions'];
                } else {
                    $company_insert_data[$key]['name']          = $row['Name'];
                    $company_insert_data[$key]['is_lender']     = 1;
                    $company_insert_data[$key]['lookup_code']   = $row['LookupCode'];
                    $company_insert_data[$key]['phone']         = $row['Phone'];
                    $company_insert_data[$key]['address1']      = $row['Address1'];
                    $company_insert_data[$key]['address2']      = $row['Address2'];
                    $company_insert_data[$key]['city']          = $row['City'];
                    $company_insert_data[$key]['state']         = $row['State'];
                    $company_insert_data[$key]['zip']           = $row['Zip'];
                    $company_insert_data[$key]['fax']           = $row['Fax'];
                    $company_insert_data[$key]['payee_name']    = $row['PayeeName'];
                    $company_insert_data[$key]['email_address'] = $row['Email'];

                    $company_insert_data[$key]['legal_name']             = $row['LegalName'];
                    $company_insert_data[$key]['fee_transfer_ledger']    = $row['FeeTransferLedger'];
                    $company_insert_data[$key]['state_of_incorporation'] = $row['StateOfIncorporation'];
                    $company_insert_data[$key]['marketing_rep']          = $row['MarketingRep'];
                    $company_insert_data[$key]['funding_address1']       = $row['FundingAddress1'];
                    $company_insert_data[$key]['funding_address2']       = $row['FundingAddress2'];
                    $company_insert_data[$key]['funding_city']           = $row['FundingCity'];
                    $company_insert_data[$key]['funding_state']          = $row['FundingState'];
                    $company_insert_data[$key]['funding_zip']            = $row['FundingZip'];
                    $company_insert_data[$key]['funding_phone']          = $row['FundingPhone'];
                    $company_insert_data[$key]['funding_fax']            = $row['FundingFax'];
                    $company_insert_data[$key]['special_instructions']   = $row['Special Instructions'];
                }
            }

            // Perform batch update for existing emails
            if (!empty($update_data)) {
                foreach ($update_data as $update_row) {
                    $this->db->where('flookup_code', $update_row['flookup_code']);
                    $this->db->update('pct_softpro_lookup_table', $update_row);
                }
            }

            if (!empty($company_update_data)) {
                foreach ($company_update_data as $update_row) {
                    $this->db->where('lookup_code', $update_row['lookup_code']);
                    $this->db->update('sp_company', $update_row);
                }
            }

            // Perform batch insert for new emails
            if (!empty($company_insert_data)) {
                $this->db->insert_batch('sp_company', $company_insert_data);
            }

            $res = json_encode(['status' => 'success', 'updated' => count($update_data), 'inserted' => count($insert_data), 'company_updated' => count($company_update_data), 'company_inserted' => count($company_insert_data)]);
            $apiEndPoints = SOFTPRO_API_END;
            $url          = getenv("SOFT_PRO_API") . $apiEndPoints['fetch_lookup_code'] . '?' . $queryParams;
            $this->order->syncLogs('softpro', 'fetch_lookup_code', $url, $reqData, $res, 0, 0);
            print_r($res);
            
        }
    }

    public function softproMortgageBrokerLookupCode()
    {
        ini_set('max_execution_time', 0);
        ini_set('memory_limit', '2048M');
        $this->load->library('order/softPro');
        $this->load->model('order/apiLogs');
        $req['userType'] = 'Mortgage Broker';
        // $queryParams['userType'] = 'Mortgage Broker';
        $queryParams = "userType=" . urlencode('Mortgage Broker');
        $reqData     = json_encode($req);
        $logid = $this->apiLogs->syncLogs($userdata['id'], 'softpro', 'fetch_lookup_code', 'fetch_lookup_code', $reqData, [], 0, 0);
        $response = $this->softpro->make_request('GET', 'fetch_lookup_code', $reqData, $queryParams);
        $this->apiLogs->syncLogs($userdata['id'], 'softpro', 'fetch_lookup_code', 'fetch_lookup_code', $reqData, json_encode($response), 0, $logid);
        
        if ($response['status'] == 'success') {
            // Get existing emails from the database
            $new_data             = $response['data'];
            $existing_flookupcode = $this->db->select('flookup_code')->from('pct_softpro_lookup_table')->get()->result_array();
            $existing_flookupcode = array_column($existing_flookupcode, 'flookup_code');

            $existing_lookupcode = $this->db->select('lookup_code')->from('sp_company')->where('is_mortgage_broker', 1)->get()->result_array();
            $existing_lookupcode = array_column($existing_lookupcode, 'lookup_code');

            // Separate data into updates and inserts
            $update_data = $insert_data = $company_insert_data = $company_update_data = [];
            foreach ($new_data as $key => $row) {
                if (in_array($row['Lookup Code'], $existing_flookupcode)) {
                    $update_data[$key]['flookup_code']       = $row['Lookup Code'];
                    $update_data[$key]['company_name']       = $row['Name'];
                    $update_data[$key]['is_mortgage_broker'] = 1;
                    // $update_data[$key]['lookup_code'] = $row['Lookup Code'];
                    // $update_data[$key]['first_name'] = $row['Name'];
                    // $update_data[$key]['payee_name'] = $row['Payee Name'];
                    // $update_data[$key]['address1'] = $row['Address (line 1)'];
                    // $update_data[$key]['address2'] = $row['Address (line 2)'];
                    // $update_data[$key]['city'] = $row['City'];
                    // $update_data[$key]['state'] = $row['State'];
                    // $update_data[$key]['zip'] = $row['Zip'];
                    // $update_data[$key]['phone'] = $row['Phone'];
                    // $update_data[$key]['fax'] = $row['Fax'];
                    // $update_data[$key]['email_address'] = $row['Email'];

                    // $update_data[$key]['fee_transfer_ledger'] = $row['Fee Transfer Ledger'];
                    // $update_data[$key]['marketing_rep'] = $row['Marketing Rep'];
                    // $update_data[$key]['special_instructions'] = $row['Special Instructions'];
                    // $update_data[$key]['user_type'] = 'mortgage_broker';
                } else {
                }

                if (in_array($row['Lookup Code'], $existing_lookupcode)) {
                    $company_update_data[$key]['lookup_code']        = $row['Lookup Code'];
                    $company_update_data[$key]['name']               = $row['Name'];
                    $company_update_data[$key]['is_mortgage_broker'] = 1;
                    $company_update_data[$key]['payee_name']         = $row['Payee Name'];
                    $company_update_data[$key]['address1']           = $row['Address (line 1)'];
                    $company_update_data[$key]['address2']           = $row['Address (line 2)'];
                    $company_update_data[$key]['city']               = $row['City'];
                    $company_update_data[$key]['state']              = $row['State'];
                    $company_update_data[$key]['zip']                = $row['Zip'];
                    $company_update_data[$key]['phone']              = $row['Phone'];
                    $company_update_data[$key]['fax']                = $row['Fax'];
                    $company_update_data[$key]['email_address']      = $row['Email'];

                    $company_update_data[$key]['fee_transfer_ledger']  = $row['Fee Transfer Ledger'];
                    $company_update_data[$key]['marketing_rep']        = $row['Marketing Rep'];
                    $company_update_data[$key]['special_instructions'] = $row['Special Instructions'];
                    // $company_update_data[$key]['user_type']            = 'mortgage_broker';
                } else {
                    $company_insert_data[$key]['lookup_code']        = $row['Lookup Code'];
                    $company_insert_data[$key]['name']               = $row['Name'];
                    $company_insert_data[$key]['is_mortgage_broker'] = 1;
                    $company_insert_data[$key]['payee_name']         = $row['Payee Name'];
                    $company_insert_data[$key]['address1']           = $row['Address (line 1)'];
                    $company_insert_data[$key]['address2']           = $row['Address (line 2)'];
                    $company_insert_data[$key]['city']               = $row['City'];
                    $company_insert_data[$key]['state']              = $row['State'];
                    $company_insert_data[$key]['zip']                = $row['Zip'];
                    $company_insert_data[$key]['phone']              = $row['Phone'];
                    $company_insert_data[$key]['fax']                = $row['Fax'];
                    $company_insert_data[$key]['email_address']      = $row['Email'];

                    $company_insert_data[$key]['fee_transfer_ledger']  = $row['Fee Transfer Ledger'];
                    $company_insert_data[$key]['marketing_rep']        = $row['Marketing Rep'];
                    $company_insert_data[$key]['special_instructions'] = $row['Special Instructions'];
                    // $insert_data[$key]['user_type'] = 'mortgage_broker';
                }
            }

            // print_r($update_data);die;
            // Perform batch update for existing emails
            if (!empty($update_data)) {
                foreach ($update_data as $update_row) {
                    $this->db->where('flookup_code', $update_row['flookup_code']);
                    $this->db->update('pct_softpro_lookup_table', $update_row);
                }
            }

            if (!empty($company_update_data)) {
                foreach ($company_update_data as $update_row) {
                    $this->db->where('lookup_code', $update_row['lookup_code']);
                    $this->db->update('sp_company', $update_row);
                }
            }

            // Perform batch insert for new emails
            if (!empty($company_insert_data)) {
                $this->db->insert_batch('sp_company', $company_insert_data);
            }

            $res = json_encode(['status' => 'success', 'updated' => count($update_data), 'inserted' => count($insert_data), 'company_updated' => count($company_update_data), 'company_inserted' => count($company_insert_data)]);
            $apiEndPoints = SOFTPRO_API_END;
            $url          = getenv("SOFT_PRO_API") . $apiEndPoints['fetch_lookup_code'] . '?' . $queryParams;
            $this->order->syncLogs('softpro', 'fetch_lookup_code', $url, $reqData, $res, 0, 0);
            print_r($res);
        }
    }

    public function softproSellingAgentLookupCode()
    {
        ini_set('max_execution_time', 0);
        ini_set('memory_limit', '2048M');
        $this->load->library('order/softPro');
        $this->load->model('order/apiLogs');
        $req['userType'] = 'Selling Agent/Broker';
        // $queryParams['userType'] = 'Selling Agent/Broker';
        $queryParams = "userType=" . urlencode('Selling Agent/Broker');
        $reqData     = json_encode($req);
        $logid = $this->apiLogs->syncLogs($userdata['id'], 'softpro', 'fetch_lookup_code', 'fetch_lookup_code', $reqData, [], 0, 0);
        $response = $this->softpro->make_request('GET', 'fetch_lookup_code', $reqData, $queryParams);
        $this->apiLogs->syncLogs($userdata['id'], 'softpro', 'fetch_lookup_code', 'fetch_lookup_code', $reqData, json_encode($response), 0, $logid);
        // echo "<pre> Selling Agent/Broker";
        // print_r($response);
        // echo "Hello";die;
        if ($response['status'] == 'success') {
            // Get existing emails from the database
            $new_data             = $response['data'];
            $existing_flookupcode = $this->db->select('flookup_code')->from('pct_softpro_lookup_table')->get()->result_array();
            $existing_flookupcode = array_column($existing_flookupcode, 'flookup_code');

            $existing_lookupcode = $this->db->select('lookup_code')->from('sp_company')->where('is_selling_agent', 1)->get()->result_array();
            $existing_lookupcode = array_column($existing_lookupcode, 'lookup_code');

            // Separate data into updates and inserts
            $update_data = $insert_data = $company_insert_data = $company_update_data = [];
            foreach ($new_data as $key => $row) {
                if (in_array($row['Lookup Code'], $existing_flookupcode)) {
                    $update_data[$key]['flookup_code']     = $row['Lookup Code'];
                    $update_data[$key]['company_name']     = $row['Name'];
                    $update_data[$key]['is_selling_agent'] = 1;

                } else {
                }

                if (in_array($row['Lookup Code'], $existing_lookupcode)) {
                    $company_update_data[$key]['lookup_code']      = $row['Lookup Code'];
                    $company_update_data[$key]['name']             = $row['Name'];
                    $company_update_data[$key]['is_selling_agent'] = 1;
                    $company_update_data[$key]['payee_name']       = $row['Payee Name'];
                    $company_update_data[$key]['address1']         = $row['Address (line 1)'];
                    $company_update_data[$key]['address2']         = $row['Address (line 2)'];
                    $company_update_data[$key]['city']             = $row['City'];
                    $company_update_data[$key]['state']            = $row['State'];
                    $company_update_data[$key]['zip']              = $row['Zip'];
                    $company_update_data[$key]['phone']            = $row['Phone'];
                    $company_update_data[$key]['fax']              = $row['Fax'];
                    $company_update_data[$key]['email_address']    = $row['Email'];

                    $company_update_data[$key]['home_phone']           = $row['Home Phone'];
                    $company_update_data[$key]['fee_transfer_ledger']  = $row['Fee Transfer Ledger'];
                    $company_update_data[$key]['represents']           = $row['Represents'];
                    $company_update_data[$key]['marketing_rep']        = $row['Marketing Rep'];
                    $company_update_data[$key]['license_no']           = $row['License No'];
                    $company_update_data[$key]['special_instructions'] = $row['Special Instructions'];

                } else {
                    $company_insert_data[$key]['lookup_code']      = $row['Lookup Code'];
                    $company_insert_data[$key]['name']             = $row['Name'];
                    $company_insert_data[$key]['is_selling_agent'] = 1;
                    $company_insert_data[$key]['payee_name']       = $row['Payee Name'];
                    $company_insert_data[$key]['address1']         = $row['Address (line 1)'];
                    $company_insert_data[$key]['address2']         = $row['Address (line 2)'];
                    $company_insert_data[$key]['city']             = $row['City'];
                    $company_insert_data[$key]['state']            = $row['State'];
                    $company_insert_data[$key]['zip']              = $row['Zip'];
                    $company_insert_data[$key]['phone']            = $row['Phone'];
                    $company_insert_data[$key]['fax']              = $row['Fax'];
                    $company_insert_data[$key]['email_address']    = $row['Email'];

                    $company_insert_data[$key]['home_phone']           = $row['Home Phone'];
                    $company_insert_data[$key]['fee_transfer_ledger']  = $row['Fee Transfer Ledger'];
                    $company_insert_data[$key]['represents']           = $row['Represents'];
                    $company_insert_data[$key]['marketing_rep']        = $row['Marketing Rep'];
                    $company_insert_data[$key]['license_no']           = $row['License No'];
                    $company_insert_data[$key]['special_instructions'] = $row['Special Instructions'];

                }
            }
            
            if (!empty($update_data)) {
                foreach ($update_data as $update_row) {
                    $this->db->where('flookup_code', $update_row['flookup_code']);
                    $this->db->update('pct_softpro_lookup_table', $update_row);
                }
            }

            if (!empty($company_update_data)) {
                foreach ($company_update_data as $update_row) {
                    $this->db->where('lookup_code', $update_row['lookup_code']);
                    $this->db->update('sp_company', $update_row);
                }
            }

            // Perform batch insert for new emails
            if (!empty($company_insert_data)) {
                $this->db->insert_batch('sp_company', $company_insert_data);
            }

            $res = json_encode(['status' => 'success', 'updated' => count($update_data), 'inserted' => count($insert_data), 'company_updated' => count($company_update_data), 'company_inserted' => count($company_insert_data)]);
            $apiEndPoints = SOFTPRO_API_END;
            $url          = getenv("SOFT_PRO_API") . $apiEndPoints['fetch_lookup_code'] . '?' . $queryParams;
            $this->order->syncLogs('softpro', 'fetch_lookup_code', $url, $reqData, $res, 0, 0);
            print_r($res);
            
        }
    }

    public function softproTitleOfficerLookupCode()
    {
        ini_set('max_execution_time', 0);
        ini_set('memory_limit', '2048M');
        $this->load->library('order/softPro');
        $this->load->model('order/apiLogs');
        $req['userType'] = 'Title Officer';
        // $queryParams['userType'] = 'Title Officer';
        $queryParams = "userType=" . urlencode('Title Officer');
        $reqData     = json_encode($req);
        $logid = $this->apiLogs->syncLogs($userdata['id'], 'softpro', 'fetch_lookup_code', 'fetch_lookup_code', $reqData, [], 0, 0);
        $response = $this->softpro->make_request('GET', 'fetch_lookup_code', $reqData, $queryParams);
        $this->apiLogs->syncLogs($userdata['id'], 'softpro', 'fetch_lookup_code', 'fetch_lookup_code', $reqData, json_encode($response), 0, $logid);

        if ($response['status'] == 'success') {
            // Get existing emails from the database
            $new_data        = $response['data'];
            $closer_examiner = $this->db->select('closer_examiner')->from('pct_softpro_lookup_table')->where('is_title_officer', 1)->get()->result_array();
            $closer_examiner = array_column($closer_examiner, 'closer_examiner');

            // Separate data into updates and inserts
            $update_data = [];
            $insert_data = [];
            foreach ($new_data as $key => $row) {
                // print_r($row);
                if (in_array($row['Title officer/Examiner'], $closer_examiner)) {
                    $update_data[$key]['closer_examiner'] = $row['Title officer/Examiner'];
                    $update_data[$key]['lookup_code']     = $row['Office LookupCode'];
                    $update_data[$key]['officer_name']    = $row['Officer Name'];
                    $update_data[$key]['email_address']    = $row['Email'];
                } else {
                    $insert_data[$key]['closer_examiner']  = $row['Title officer/Examiner'];
                    $insert_data[$key]['lookup_code']      = $row['Office LookupCode'];
                    $insert_data[$key]['officer_name']     = $row['Officer Name'];
                    $insert_data[$key]['email_address']     = $row['Email'];
                    $insert_data[$key]['is_title_officer'] = 1;
                }
            }
            
            // Perform batch update for existing emails
            if (!empty($update_data)) {
                foreach ($update_data as $update_row) {
                    $this->db->where('closer_examiner', $update_row['closer_examiner']);
                    $this->db->where('is_title_officer', 1);
                    $this->db->update('pct_softpro_lookup_table', $update_row);
                }
            }

            // Perform batch insert for new emails
            if (!empty($insert_data)) {
                $this->db->insert_batch('pct_softpro_lookup_table', $insert_data);
            }

            $res = json_encode(['status' => 'success', 'updated' => count($update_data), 'inserted' => count($insert_data)]);
            $apiEndPoints = SOFTPRO_API_END;
            $url          = getenv("SOFT_PRO_API") . $apiEndPoints['fetch_lookup_code'] . '?' . $queryParams;
            $this->order->syncLogs('softpro', 'fetch_lookup_code', $url, $reqData, $res, 0, 0);
            print_r($res);
        }
    }

    public function softproSalesrepsLookupCode()
    {
        ini_set('max_execution_time', 0);
        ini_set('memory_limit', '2048M');
        $this->load->library('order/softPro');
        $this->load->model('order/apiLogs');

        $logid = $this->apiLogs->syncLogs($userdata['id'], 'softpro', 'fetch_sales_reps', 'fetch_sales_reps', null, [], 0, 0);
        $response = $this->softpro->make_request('GET', 'fetch_sales_reps');
        $this->apiLogs->syncLogs($userdata['id'], 'softpro', 'fetch_sales_reps', 'fetch_sales_reps', null, json_encode($response), 0, $logid);
        
        if ($response['status'] == 'success') {
            // Get existing emails from the database
            $new_data        = $response['data'];
            // $closer_examiner = $this->db->select('closer_examiner')->from('sp_officers')->where('is_sales_rep', 1)->get()->result_array();
            // $closer_examiner = array_column($closer_examiner, 'closer_examiner');
            
            $this->db->where('is_sales_rep', 1);
            $this->db->update('pct_softpro_lookup_table', ['status' => 0]);
            
            $existingLookupcode = $this->db->select('lookup_code')->from('pct_softpro_lookup_table')->where('is_sales_rep', 1)->get()->result_array();
            $existingLookupcode = array_column($existingLookupcode, 'lookup_code');

            // Separate data into updates and inserts
            $update_data = [];
            $insert_data = [];
            foreach ($new_data as $key => $row) {
                $spliteFullName = $this->order->splitFullName($row['FullName']);
                if (in_array($row['LookUpCode'], $existingLookupcode)) {
                    $update_data[$key]['lookup_code'] = $row['LookUpCode'];
                    $update_data[$key]['first_name']    = $spliteFullName['first_name'];
                    $update_data[$key]['last_name']    = $spliteFullName['last_name'];
                    $update_data[$key]['full_name']    = $row['FullName'];
                    $update_data[$key]['email_address']    = $row['Email'];
                    $update_data[$key]['phone']    = preg_replace('/\D/', '', $row['Phone']);
                    $update_data[$key]['is_sales_rep'] = 1;
                    $update_data[$key]['status'] = 1;
                } else {
                    $insert_data[$key]['lookup_code'] = $row['LookUpCode'];
                    $insert_data[$key]['first_name']    = $spliteFullName['first_name'];
                    $insert_data[$key]['last_name']    = $spliteFullName['last_name'];
                    $insert_data[$key]['phone']    = preg_replace('/\D/', '', $row['Phone']);
                    $insert_data[$key]['full_name']    = $row['FullName'];
                    $insert_data[$key]['email_address']    = $row['Email'];
                    $insert_data[$key]['is_sales_rep'] = 1;
                    $insert_data[$key]['status'] = 1;
                }
            }

            // Perform batch update for existing emails
            if (!empty($update_data)) {
                foreach ($update_data as $update_row) {
                    $this->db->where('lookup_code', $update_row['lookup_code']);
                    $this->db->where('is_sales_rep', 1);
                    $this->db->update('pct_softpro_lookup_table', $update_row);
                }
            }

            // Perform batch insert for new emails
            if (!empty($insert_data)) {
                $this->db->insert_batch('pct_softpro_lookup_table', $insert_data);
            }

            $res = json_encode(['status' => 'success','updated' => count($update_data), 'inserted' => count($insert_data)]);
            $apiEndPoints = SOFTPRO_API_END;
            $url          = getenv("SOFT_PRO_API") . $apiEndPoints['fetch_sales_reps'] . '?' . $queryParams;
            $this->order->syncLogs('softpro', 'fetch_sales_reps', $url, $reqData, $res, 0, 0);
            echo $res;
            exit;
        }
    }

    public function softproUnderwriterLookupCode()
    {
        ini_set('max_execution_time', 0);
        ini_set('memory_limit', '2048M');
        $this->load->library('order/softPro');
        $this->load->model('order/apiLogs');
        $req['userType'] = 'Underwriter';
        // $queryParams['userType'] = 'Underwriter';
        $queryParams = "userType=" . urlencode('Underwriter');
        $reqData     = json_encode($req);
        $logid = $this->apiLogs->syncLogs($userdata['id'], 'softpro', 'fetch_lookup_code', 'fetch_lookup_code', $reqData, [], 0, 0);
        $response    = $this->softpro->make_request('GET', 'fetch_lookup_code', $reqData, $queryParams);
        $this->apiLogs->syncLogs($userdata['id'], 'softpro', 'fetch_lookup_code', 'fetch_lookup_code', $reqData, json_encode($response), 0, $logid);
        
        if ($response['status'] == 'success') {
            // Get existing emails from the database
            $new_data             = $response['data'];
            $existing_flookupcode = $this->db->select('flookup_code')->from('pct_softpro_lookup_table')->where('user_type', 'underwriter')->get()->result_array();
            $existing_flookupcode = array_column($existing_flookupcode, 'lookup_code');

            $existing_lookupcode = $this->db->select('lookup_code')->from('sp_company')->where('is_underwriter', 1)->get()->result_array();
            $existing_lookupcode = array_column($existing_lookupcode, 'lookup_code');
            // print_r($existing_lookupcode);
            // echo "Hello";die;
            // Separate data into updates and inserts
            $update_data = $insert_data = $company_insert_data = $company_update_data = [];
            foreach ($new_data as $key => $row) {
                if (in_array($row['Lookup Code'], $existing_flookupcode)) {
                    $update_data[$key]['flookup_code']   = $row['Lookup Code'];
                    $update_data[$key]['company_name']   = $row['Name'];
                    $update_data[$key]['is_underwriter'] = 1;
                } else {
                }

                if (in_array($row['Lookup Code'], $existing_lookupcode)) {
                    $company_update_data[$key]['lookup_code']    = $row['Lookup Code'];
                    $company_update_data[$key]['name']           = $row['Name'];
                    $company_update_data[$key]['is_underwriter'] = 1;
                    $company_update_data[$key]['address1']       = $row['Address (line 1)'];
                    $company_update_data[$key]['city']           = $row['City'];
                    $company_update_data[$key]['state']          = $row['State'];
                    $company_update_data[$key]['zip']            = $row['Zip'];
                    $company_update_data[$key]['phone']          = $row['Phone'];
                    $company_update_data[$key]['fax']            = $row['Fax'];
                    $company_update_data[$key]['email_address']  = $row['Email'] ?? '';

                    $company_update_data[$key]['fee_transfer_ledger'] = $row['Fee Transfer Ledger'];
                    // $company_update_data[$key]['county']                = $row['County'];
                    $company_update_data[$key]['splitTo_premiums']      = $row['SplitTo - Premiums'];
                    $company_update_data[$key]['percent_premiums']      = $row['Percent - Premiums'];
                    $company_update_data[$key]['billCode_premiums']     = $row['BillCode - Premiums'];
                    $company_update_data[$key]['splitTo_endorsements']  = $row['SplitTo - Endorsements'];
                    $company_update_data[$key]['percent_endorsements']  = $row['Percent - Endorsements'];
                    $company_update_data[$key]['billCode_endorsements'] = $row['BillCode - Endorsements'];
                } else {
                    $company_insert_data[$key]['lookup_code']    = $row['Lookup Code'];
                    $company_insert_data[$key]['name']           = $row['Name'];
                    $company_insert_data[$key]['is_underwriter'] = 1;
                    $company_insert_data[$key]['address1']       = $row['Address (line 1)'];
                    $company_insert_data[$key]['city']           = $row['City'];
                    $company_insert_data[$key]['state']          = $row['State'];
                    $company_insert_data[$key]['zip']            = $row['Zip'];
                    $company_insert_data[$key]['phone']          = $row['Phone'];
                    $company_insert_data[$key]['fax']            = $row['Fax'];
                    $company_insert_data[$key]['email_address']  = $row['Email'] ?? '';

                    $company_insert_data[$key]['fee_transfer_ledger'] = $row['Fee Transfer Ledger'];
                    // $company_insert_data[$key]['county']                = $row['County'];
                    $company_insert_data[$key]['splitTo_premiums']      = $row['SplitTo - Premiums'];
                    $company_insert_data[$key]['percent_premiums']      = $row['Percent - Premiums'];
                    $company_insert_data[$key]['billCode_premiums']     = $row['BillCode - Premiums'];
                    $company_insert_data[$key]['splitTo_endorsements']  = $row['SplitTo - Endorsements'];
                    $company_insert_data[$key]['percent_endorsements']  = $row['Percent - Endorsements'];
                    $company_insert_data[$key]['billCode_endorsements'] = $row['BillCode - Endorsements'];
                }
            }

            // Perform batch update for existing emails
            if (!empty($update_data)) {
                foreach ($update_data as $update_row) {
                    $this->db->where('flookup_code', $update_row['flookup_code']);
                    $this->db->update('pct_softpro_lookup_table', $update_row);
                }
            }

            if (!empty($company_update_data)) {
                foreach ($company_update_data as $update_row) {
                    $this->db->where('lookup_code', $update_row['lookup_code']);
                    $this->db->update('sp_company', $update_row);
                }
            }

            // Perform batch insert for new emails
            if (!empty($company_insert_data)) {
                $this->db->insert_batch('sp_company', $company_insert_data);
            }

            $res = json_encode(['status' => 'success', 'updated' => count($update_data), 'inserted' => count($insert_data), 'company_updated' => count($company_update_data), 'company_inserted' => count($company_insert_data)]);
            $apiEndPoints = SOFTPRO_API_END;
            $url          = getenv("SOFT_PRO_API") . $apiEndPoints['fetch_lookup_code'] . '?' . $queryParams;
            $this->order->syncLogs('softpro', 'fetch_lookup_code', $url, $reqData, $res, 0, 0);
            print_r($res);
            
        }
    }

    public function spSyncFailedDocument() {
        
        $records = $this->db->select('id, order_number, file_list, document_name, document_ids')
                            ->from('sp_file_upload_logs')
                            ->where('is_synced', 0)
                            ->limit(10)
                            ->order_by('id', 'asc')
                            // ->group_by('order_number')
                            ->get()->result_array();
        if (!empty($records)) {
            foreach ($records as $key => $value) {
                $fileData = [
                    "Id" => $value['id'],
                    "OrderNumber"  => $value['order_number'],
                    "DocumentName" => $value['document_name'],
                    "FileList"     => json_decode($value['file_list']),
                ];
                $fileUploadReq[] = $fileData;
            }
            $reqData = json_encode($fileUploadReq);
            $this->load->library('order/softPro');
            $logid = $this->apiLogs->syncLogs($userdata['id'], 'softpro', 'upload_document_cron', 'upload_document', $reqData, [], 0, 0);
            $result = $this->softpro->make_request('POST', 'upload_document', $reqData);
            $response = json_decode($result, true);
            $this->apiLogs->syncLogs($userdata['id'], 'softpro', 'upload_document_cron', 'upload_document', $reqData, json_encode($response), 0, $logid);

            if (isset($response) && !empty($response)) {
                foreach ($response as $key => $res) {
                    if ($res['Status'] == 200) {
                        $updateData[] = [
                            'is_synced' => 1,
                            'id' => $res['Id']
                        ];
                        if (!empty($value['document_ids'])) {
                            $docIds = json_decode($value['document_ids'], true);
                            if (!empty($docIds)) {
                                $this->db->where_in('id', $docIds);
                                $this->db->update('pct_order_documents', ['is_sync' => 1]);
                            }
                        }
                    } else {
                        $updateData[] = [
                            'is_synced' =>  (strpos(strtolower($res['Message']), "locked for editing by user") !== false) ? 0 : 1, //(strtolower($res['Message']) == 'order was not found.') ? 1 : 0,
                            'id' => $res['Id'],
                            'reason' => $res['Message'],
                        ];
                    }
                }
            }
            foreach ($updateData as $key => $update_row) {
                $this->db->where('id', $update_row['id']);
                $this->db->update('sp_file_upload_logs', $update_row);
            }
        }
    }

    public function fetchPrelimDocument() 
    {
        echo date('Y-m-d H:i:s') . "----";
        $this->db->select('o.id, o.customer_id, o.file_number, o.softpro_status');
        $this->db->from('order_details as o');
        $this->db->join('pct_order_documents as doc', 'o.id = doc.order_id', 'left');
        $this->db->where('doc.order_id IS NULL');
        // $this->db->where_not_in('id', function() {
        //     $this->db->select('order_id')->from('pct_order_documents')->where('is_prelim_document', 1);
        // });
        // $this->db->where('o.softpro_status', 'closed');
        $this->db->where('o.is_softpro_order', 1);
        $this->db->where('o.file_number !=', '0');
        $this->db->where('o.prelim_summary_id', 0);
        $this->db->order_by("o.id", "desc");
        $query       = $this->db->get();
        $filesResult = $query->result_array();
        $newSyncedFile = [];
        if (isset($filesResult) && !empty($filesResult)) {
            foreach ($filesResult as $file) {
                $data                  = [];
                $this->load->library('order/softPro');
                $queryParams = "orderNumber=" . urlencode($file['file_number']);
                $req['orderNumber'] = $file_number = $file['file_number'];
                $reqData     = json_encode($req);
                
                $logid = $this->apiLogs->syncLogs($userdata['id'], 'softpro', 'get_prelim_documents', 'get_prelim_documents', $reqData, [], 0, 0);
                $response = $this->softpro->make_request('GET', 'get_prelim_documents', $reqData, $queryParams);
                $this->apiLogs->syncLogs($userdata['id'], 'softpro', 'get_prelim_documents', 'get_prelim_documents', $reqData, json_encode($response), 0, $logid);
                
                // $response = json_decode($result, true);
                if ($response['status'] == 'success' && !empty($response['data'])) {
                    $data = $response['data'];
                    $url = $data[0];
                    $documentName = basename($url);
                    $document_name = time() . "_prelim_doc_" . $file_number . '.pdf';
                    $uploadStatus = $this->order->uploadDocumentUsingLinkOnAwsS3($url, $document_name, 'documents');
                    // echo '$uploadStatus ==' . $uploadStatus;
                    if ($uploadStatus) {
                        $this->load->model('order/document');
                        $documentData = array(
                            'document_name' => $document_name,
                            'original_document_name' => urldecode($documentName),
                            'user_id' => $file['customer_id'],
                            'order_id' => $file['id'],
                            'description' => $documentName,
                            'created' => $created_date,
                            'is_sync' => 1,
                            'is_prelim_document' => 1,
                        );
                        $documentId = $this->document->insert($documentData);
                    }
                    $newSyncedFile[] = $file_number;
                }
            }
            $res = json_encode(['prelim inserted' => count($newSyncedFile), 'orders_inserted' => $newSyncedFile]);
        } else {
            $res = "No prelim details found.";
        }
        /** Cron log start */
        $apiEndPoints = SOFTPRO_API_END;
        $url          = getenv("SOFT_PRO_API") . $apiEndPoints['get_prelim_documents'] . '?' . $queryParams;
        $this->order->syncLogs('softpro', 'get_prelim_documents', $url, $reqData, $res, 0, 0);
        /** Cron log end */
        
        print_r($res); exit;
    }

    

    public function transferLoginDetails() {
        $salesrepList = $this->db->select('lookup_code, email_address, id')
                                    ->from('pct_softpro_lookup_table')
                                    ->where(['status' => 1])
                                    ->where(['is_title_officer' => 1])
                                    // ->where('password is null')
                                    ->get()
                                    ->result_array();
        // echo "<pre>";
        $count = 0;
        foreach ($salesrepList as $key => $value) {
            // print_r($value);
            $pctSalesRep = $this->db->select('email_address, password, random_password, is_tmp_password, is_password_required, is_password_updated, id, is_sales_rep_manager, sales_rep_users')
                                    ->from('customer_basic_details')
                                    ->where([
                                        'status' => 1,
                                        // 'email_address' => 'teammeza@pct.com'
                                        'email_address' => $value['email_address']
                                        ])
                                    ->where('password is not null')
                                    ->get()->row_array();
            // print_r($pctSalesRep);
            if (!empty($pctSalesRep)) {
                $updateData = [
                    "password" => $pctSalesRep['password'],
                    "random_password" => $pctSalesRep['random_password'],
                    "is_tmp_password" => $pctSalesRep['is_tmp_password'],
                    "is_password_required" => $pctSalesRep['is_password_required'],
                    "is_password_updated" => $pctSalesRep['is_password_updated'],
                    "allow_login" => 1,
                ];
                $lookupSalesIdsImpload = null;
                if ($pctSalesRep['is_sales_rep_manager'] == 1) {
                    $salesUser = explode(',', $pctSalesRep['sales_rep_users']);
                    $salesRepUsers = $this->db->select('email_address')
                                            ->from('customer_basic_details')
                                            ->where_in('id', $salesUser)
                                            ->get()->result_array();
                    $salesRepUsersEmail = array_column($salesRepUsers, 'email_address');
                    if (!empty($salesRepUsersEmail)) {
                        $lookupSalesIds = $this->db->select('id')
                                        ->from('pct_softpro_lookup_table')
                                        ->where_in('email_address', $salesRepUsersEmail)
                                        // ->where('password is null')
                                        ->get()
                                        ->result_array();
                        $lookupSalesIds = array_column($lookupSalesIds, 'id');
                        $lookupSalesIdsImpload = implode(',', $lookupSalesIds);
                    }
                    $updateData['is_sales_rep_manager'] = $pctSalesRep['is_sales_rep_manager'];
                    $updateData['sales_rep_users'] = $lookupSalesIdsImpload;
                    
                }
                $this->db->where('id', $value['id']);
                $this->db->update('pct_softpro_lookup_table', $updateData);

                // $updateOrder = [
                //     'created_by' => $value['id']
                // ];
                // $this->db->where(['created_by' => $pctSalesRep['id'], 'is_softpro_order' => 1]);
                // $this->db->update('order_details', $updateOrder);
                $count++;
            }
        }
        // print_r($salesrepList);die;
        $res = json_encode(['updated' => $count]);
        print_r($res);die;
        
    }


    public function transferMasterUserLoginDetails() {
        $pctMasterUsers = $this->db->select('id, email_address, password, random_password, is_tmp_password, is_password_required, is_password_updated, first_name, last_name, telephone_no, company_name, street_address, city, state, zip_code, is_master, is_title_production, status, is_mail_notification')
                                    ->from('customer_basic_details')
                                    ->where('is_master', 1)
                                    ->or_where('is_title_production', 1)
                                    ->get()->result_array();

        // echo "<pre>";
        // print_r($pctMasterUsers);die;
        echo "count of master user in pct: " . count($pctMasterUsers);
        echo "<br>";
        $i = 0;
        foreach ($pctMasterUsers as $key => $user) {
            $pctSalesRep = $this->db->select('email_address')
                                    ->from('pct_softpro_lookup_table')
                                    ->where('email_address', $user['email_address'])
                                    ->get()
                                    ->row_array();
            if (empty($pctSalesRep)) {
                $insertData = [
                    "company_name" => $user["company_name"],
                    "email_address" => $user["email_address"],
                    "password" => $user["password"],
                    "random_password" => $user["random_password"],
                    "is_tmp_password" => $user["is_tmp_password"],
                    "is_password_required" => $user["is_password_required"],
                    "is_password_updated" => $user["is_password_updated"],
                    "first_name" => $user["first_name"],
                    "last_name" => $user["last_name"],
                    "phone" => $user["telephone_no"],
                    "address1" => $user["street_address"],
                    "city" => $user["city"],
                    "state" => $user["state"],
                    "zip" => $user["zip_code"],
                    "is_master" => $user["is_master"],
                    "is_title_production" => $user["is_title_production"],
                    "status" => $user["status"],
                    "is_mail_notification" => $user["is_mail_notification"],
                ];

                $insert = $this->db->insert('pct_softpro_lookup_table', $insertData);
                if ($insert) {
                    $id = $this->db->insert_id();
                    $updateOrder = [
                        'created_by' => $id
                    ];
                    $this->db->where(['created_by' => $user['id'], 'is_softpro_order' => 1]);
                    $this->db->update('order_details', $updateOrder);
                }
                $i++;
            }
        }
        echo "count of inserted master user in lookup: " . $i;
    }

    public function fetchSoftproOrders() {
        $this->load->library('order/softPro');
        $this->load->model('order/apiLogs');
        ini_set('max_execution_time', 0);
        ini_set('memory_limit', '2048M');
        $req['DateFrom'] = '';
        if (isset($_GET['DateFrom'])) {
            if (!empty($_GET['DateFrom'])) {
                $startDate = date('m-d-Y', strtotime($_GET['DateFrom']));
                $req['DateFrom'] = $startDate;
            }
        }

        $req['DateTo'] = '';
        if (isset($_GET['DateTo'])) {
            if (!empty($_GET['DateTo'])) {
                $endDate = date('m-d-Y', strtotime($_GET['DateTo']));
                $req['DateTo'] = $endDate;
            }
        }

        $req['OrderNumber'] = "";
        if (isset($_GET['orderNumber'])) {
            $orderNumber = $_GET['orderNumber'];
            $req['OrderNumber'] = $orderNumber;
        }

        if (empty($_GET)) {
            $startDate = date('m-d-Y', strtotime('-1 day', strtotime(date('Y-m-d'))));
            $endDate = date('m-d-Y');
            $req['DateFrom'] = $startDate;
            $req['DateTo'] = $endDate;
        }
        
        // $startDate = date('m-d-Y', strtotime('-1 day', strtotime(date('Y-m-d'))));
        $query = $this->db->select('id, product_type')
                      ->from('pct_softpro_product_type')
                      ->get();

        $productTypeList = array_column($query->result_array(), 'id', 'product_type');

        $query = $this->db->select('id, full_name')
                      ->from('pct_softpro_lookup_table')
                      ->where('is_sales_rep', 1) 
                      ->get();

        $salesRepList = array_column($query->result_array(), 'id', 'full_name');

        $query = $this->db->select('id, officer_name')
                      ->from('pct_softpro_lookup_table')
                      ->where('is_title_officer', 1) 
                      ->get();

        $titleOfficerList = array_column($query->result_array(), 'id', 'officer_name');

        $queryParams = http_build_query($req);
        // print_r($queryParams);die;
        // $queryParams = "DateFrom=$startDate&DateTo=$endDate";
        // $queryParams = "DateFrom=03-26-2025&DateTo=03-26-2025";
        $reqData     = json_encode($req);
        $logid = $this->apiLogs->syncLogs($userdata['id'], 'softpro', 'get_softpro_orders', 'get_softpro_orders', $reqData, [], 0, 0);
        $response    = $this->softpro->make_request('GET', 'get_softpro_orders', $reqData, $queryParams);
        $this->apiLogs->syncLogs($userdata['id'], 'softpro', 'get_softpro_orders', 'get_softpro_orders', $reqData, json_encode($response), 0, $logid);

        $sheetData = [];
        $importedOrderCount = 0;
        $updatedOrderCount = 0;
        if ($response['status'] == 'success' && !empty($response['data'])) {
            
            $orderList = $response['data'];
            foreach ($orderList as $key => $list) {
                $completed_date = null;
                $closed_date = null;
                $file_number = $list['OrderNumber'] ?? null;
                $orderStatus = $list['OrderStatus'] ?? null;
                $orderStatus = strtolower($orderStatus);
                $marketingSource = $list['MarketingSource'] ?? null;
                $orderType = $list['OrderType'] ?? null;
                $address = $list['Address'] ?? null;
                $city = $list['City'] ?? null;
                $state = $list['State'] ?? null;
                $country = $list['Country'] ?? null;
                $titleOfficer = $list['TitleOfficer'] ?? null;
                $salesPrice = $list['SalesPrice'] ?? null;
                $transactionType = $list['TransactionType'] ?? null;
                $productType = $list['ProductType'] ?? null;
                $receivedDate = $list['ReceivedDate'] ?? null;
                $completedDate = $list['CompletedDate'] ?? null;
                $closedDate = ($orderStatus == 'closed') ? $list['ModifiedDate'] : null;
                $marketingRep = $list['MarketingRep'] ?? null;
                if (!empty($completedDate)) {
                    // $myDateTime     = DateTime::createFromFormat('M d, Y', $closedDate);
                    $myDateTime = DateTime::createFromFormat('n/j/Y g:i:s A', trim($completedDate));
                    $completed_date = $myDateTime->format('Y-m-d H:i:s');
                }

                if (!empty($closedDate)) {
                    // $myDateTime     = DateTime::createFromFormat('M d, Y', $closedDate);
                    $myDateTime = DateTime::createFromFormat('n/j/Y g:i:s A', trim($closedDate));
                    $closed_date = $myDateTime->format('Y-m-d H:i:s');
                }

                if (!empty($file_number)) {
                    $condition = [
                        'where' => [
                            'file_number' => $file_number,
                        ],
                    ];
                    $order = $this->order->get_order($condition);
                    // echo 'order ==';
                    // print_r($order);
                    $salesRepId = (!empty($marketingRep)) ? $salesRepList[$marketingRep] : null;
                    if (empty($order)) {
                        $customerId   = 0;
                        $importedOrderCount++;
                        $FullProperty = $address;
                        // $address      = $res['Properties'][0]['StreetNumber'] . " " . $res['Properties'][0]['StreetDirection'] . " " . $res['Properties'][0]['StreetName'] . " " . $res['Properties'][0]['StreetSuffix'];
                        $locale       = $city;

                        if (($locale)) {
                            $FullProperty .= ', ' .  $city;
                            if (!empty($state)) {
                                $FullProperty .= ', ' . $state;
                                $locale .= ', ' . $state;
                            } else {
                                $locale .= ', CA';
                                $FullProperty .= ' CA';
                            }
                            if (!empty($zip)) {
                                $FullProperty .= ' ' . $zip;
                            }
                        }

                        $property_details = $this->getSearchResult($address, $locale);
                        
                        $property_type    = isset($property_details['property_type']) && !empty($property_details['property_type']) ? $property_details['property_type'] : '';
                        $LegalDescription = isset($property_details['legaldescription']) && !empty($property_details['legaldescription']) ? $property_details['legaldescription'] : '';
                        $apn              = isset($property_details['apn']) && !empty($property_details['apn']) ? $property_details['apn'] : '';
                        
                        $titleOfficerId = (!empty($titleOfficer)) ? $titleOfficerList[$titleOfficer] : null;
                        $productTypeId = (!empty($productType)) ? $productTypeList[$productType] : null;
                        $orderOpenDate = date("Y-m-d H:i:s", strtotime($receivedDate));
                        $propertyData     = [
                            'customer_id'       => $customerId,
                            'buyer_agent_id'    => 0,
                            'listing_agent_id'  => 0,
                            'escrow_lender_id'  => 0,
                            'parcel_id'         => null,
                            'address'           => removeMultipleSpace($address),
                            'city'              => $city,
                            'state'             => $state,
                            'zip'               => $zip,
                            'property_type'     => $property_type,
                            'full_address'      => removeMultipleSpace($FullProperty),
                            'apn'               => $apn,
                            'county'            => $country,
                            'legal_description' => $LegalDescription,
                            'status'            => 1,
                        ];

                        $transactionData = [
                            'customer_id'          => $customerId,
                            'sales_amount'         => $salesPrice,
                            // 'loan_number'          => !empty($res['Loans'][0]['LoanNumber']) ? $res['Loans'][0]['LoanNumber'] : 0,
                            // 'loan_amount'          => !empty($res['Loans'][0]['LoanAmount']) ? $res['Loans'][0]['LoanAmount'] : 0,
                            'transaction_type'     => $transactionType,
                            'purchase_type'        => $productTypeId,
                            'product_type'         => $productTypeId,
                            'sales_representative' => $salesRepId,
                            'title_officer'        => $titleOfficerId,
                            'status'               => 1,
                        ];
                        
                        $propertyId    = $this->home_model->insert($propertyData, 'property_details');
                        $transactionId = $this->home_model->insert($transactionData, 'transaction_details');
                        $randomString  = $this->order->randomPassword();
                        $randomString  = md5($randomString);

                        

                        $orderData = [
                            'customer_id'                => $customerId,
                            'file_number'                => $file_number,
                            'property_id'                => $propertyId,
                            'transaction_id'             => $transactionId,
                            'created_at'                 => $orderOpenDate,
                            'prod_type'                  => $transactionType,
                            // 'premium'                    => $premium,
                            'status'                     => 1,
                            'is_imported'                => 1,
                            // 'is_sales_rep_order'         => 1,
                            'random_number'              => $randomString,
                            'resware_closed_status_date' => $closed_date,
                            'order_completed_date' => $completed_date,
                            'softpro_status'             => $orderStatus,
                            // 'sent_to_accounting_date'    => $completed_date,
                            'is_softpro_order'          => 1
                        ];
                        
                        $orderId = $this->home_model->insert($orderData, 'order_details');
                        
                    } else {
                        // $orderStatus = strtolower($orderStatus);
                        $orderData = [
                            'softpro_status' => $orderStatus,
                        ];
                        if ($orderStatus == 'completed') {
                            $orderData['order_completed_date'] = $completed_date;
                            // $orderData['sent_to_accounting_date'] = $completed_date;
                        }

                        if ($orderStatus == 'closed' && $order['softpro_status'] != 'closed') {
                            $orderData['resware_closed_status_date'] = $closed_date;
                        }
                        
                        $condition = [
                            'file_number' => $file_number
                        ];

                        $orderId = $this->home_model->update($orderData, $condition, 'order_details');

                        $salesPrice = $list['SalesPrice'] ?? null;
                        
                        $result = $this->db->select('id')->from('order_details')->where($condition)->get()->row_array();
                        if (isset($result['id'])) {
                            $updateDate = ['sales_amount' => $salesPrice];
                            if (!empty($salesRepId)) {
                                $updateDate['sales_representative'] = $salesRepId;
                            }
                            $updatedOrderCount++;
                            $this->home_model->update($updateDate, ['id' => $result['id']], 'transaction_details');
                        }
                    }
                }
            } // end foreach
        }

        /** Cron log start */
        $res = $importedOrderCount . ' Orders imported and ' .$updatedOrderCount .' Order updated successfully';
        $apiEndPoints = SOFTPRO_API_END;
        $url          = getenv("SOFT_PRO_API") . $apiEndPoints['get_softpro_orders'] . '?' . $queryParams;
        $this->order->syncLogs('softpro', 'get_softpro_orders', $url, $reqData, $res, 0, 0);
        /** Cron log end */
        echo json_encode(['status' => 'success','message' => $res]);
    }

    public function getDateIntervals($start, $end, $intervalDays = 10)
    {
        $startTime = strtotime($start);  // e.g. "01-03-2025"
        $endTime = strtotime($end);      // e.g. "15-04-2025"

        $intervals = [];

        while ($startTime <= $endTime) {
            $from = date('m-d-Y', $startTime);

            $nextTime = strtotime("+$intervalDays days", $startTime);
            if ($nextTime > $endTime) {
                $nextTime = $endTime;
            }

            $to = date('m-d-Y', $nextTime);
            $req['DateFrom'] = $from;
            $req['DateTo'] = $to;
            $intervals[] = http_build_query($req);

            $startTime = strtotime('+1 day', $nextTime); 
        }
        rsort($intervals);
        return $intervals;
    }

    public function fetchBulkPrelimreport() {
        $this->load->library('order/softPro');
        $this->load->model('order/apiLogs');
        ini_set('max_execution_time', 0);
        ini_set('memory_limit', '2048M');
        $prelimFetchedCount= 0;
        if (isset($_GET['DateFrom'])) {
            $req['DateFrom'] = '';
            if (!empty($_GET['DateFrom'])) {
                $startDate = date('m-d-Y', strtotime($_GET['DateFrom']));
                $req['DateFrom'] = $startDate;
            }
        }

        if (isset($_GET['DateTo'])) {
            $req['DateTo'] = '';
            if (!empty($_GET['DateTo'])) {
                $endDate = date('m-d-Y', strtotime($_GET['DateTo']));
                $req['DateTo'] = $endDate;
            }
        }

        if (empty($_GET)) {
            // $startDate = date('m-d-Y', strtotime('-10 day', strtotime(date('Y-m-d'))));
            $startDate = date('01-03-2025');
            $endDate = date('d-m-Y');
            $req['DateFrom'] = $startDate;
            $req['DateTo'] = $endDate;
        }
        // print_r($req);die;
        $dateIntervalQueryParams = $this->getDateIntervals($startDate, $endDate, 6);
        // echo "<pre>";
        // print_r($dateIntervalQueryParams);die;
        // $queryParams = http_build_query($req);
        
        // $queryParams = "DateFrom=$startDate&DateTo=$endDate";
        // $queryParams = "DateFrom=03-26-2025&DateTo=03-26-2025";
        $apiEndPoints = SOFTPRO_API_END;
        foreach ($dateIntervalQueryParams as $key => $range) {
            $newSyncedFile = [];
            $reqData = $queryParams = $range;
            $reqUrl  = getenv("SOFT_PRO_API") . $apiEndPoints['get_bulk_prelim_report'] . '?'.$queryParams;
            $logid = $this->apiLogs->syncLogs($userdata['id'], 'softpro', 'get_bulk_prelim_report', $reqUrl, $reqData, [], 0, 0);
            $result    = $this->softpro->make_request('GET', 'get_bulk_prelim_report', $reqData, $queryParams);
            $this->apiLogs->syncLogs($userdata['id'], 'softpro', 'get_bulk_prelim_report', $reqUrl, $reqData, $result, 0, $logid);
            
            $response = json_decode($result, true);
            
            if (!empty($response)) {
                
                foreach ($response as $key => $data) {
                    if ($data['Status'] == 200 && !empty($data['data'])) {
                        $this->db->select('o.id, o.customer_id, o.file_number, o.softpro_status');
                        $this->db->from('order_details as o');
                        $this->db->where('o.file_number', $data['OrderNumber']);
                        $filesResult = $this->db->get()->row_array();
    
                        $this->db->select('*');
                        $this->db->from('pct_order_prelim_summary as s');
                        $this->db->where('file_number', $data['OrderNumber']);
                        $prelimSummaryDetails = $this->db->get()->row_array();
    
                        // if (empty($prelimSummaryDetails) && !empty($filesResult) && !empty($data['data'])) {
                        if (!empty($filesResult) && !empty($data['data'])) {
                            $prelimLink = $data['data'][0];
                            $ext = pathinfo(parse_url($prelimLink, PHP_URL_PATH), PATHINFO_EXTENSION);
                            if (strtolower($ext) === 'pdf') {
                                $orderId = $filesResult['id'];
                                $file_number = $data['OrderNumber'];
                                $prelimFetchedCount++;
                                $getPrelimCount = $this->document->countPrelimDocument($orderId);
                                if ($getPrelimCount == 0) {
                                    $documentName = basename($prelimLink);
                                    $document_name = time() . "_prelim_doc_" . $file_number . '.pdf';
                                    $uploadStatus = $this->order->uploadDocumentUsingLinkOnAwsS3($prelimLink, $document_name, 'documents');
                                    
                                    if ($uploadStatus) {
                                        $this->load->model('order/document');
                                        $documentData = array(
                                            'document_name' => $document_name,
                                            'original_document_name' => urldecode($documentName),
                                            'user_id' => $filesResult['customer_id'],
                                            'order_id' => $filesResult['id'],
                                            'description' => $documentName,
                                            'created' => date('Y-m-d H:i:s'),
                                            'is_sync' => 1,
                                            'is_prelim_document' => 1,
                                        );
                                        $this->document->insert($documentData);
                                        $newSyncedFile[] = $file_number;
                                    }
                                }

                                if (empty($prelimSummaryDetails)) {
                                    $summaryData = [
                                        'file_number' => $filesResult['file_number'],
                                        'created_at' => date('Y-m-d H:i:s'),
                                    ];
                                    // $id = $this->db->insert('pct_order_prelim_summary', $summaryData);
                                    $id = $this->home_model->insert($summaryData, 'pct_order_prelim_summary');
                                    $condition = array(
                                        'id' => $filesResult['id'],
                                    );
                                    $data = array(
                                        'prelim_summary_id' => $id,
                                    );
                                    $this->order->update($data, $condition);
                                }
                                // else {
                                //     $prelimData = array(
                                //         'is_doc_updated' => 1
                                //     );
                                //     $prelimCondition = [
                                //         'file_number' => $file_number
                                //     ];
                                //     $this->order->updateRecords($prelimData, $prelimCondition, 'pct_order_prelim_summary');
                                // }
                            }
                        }
                    }
                } // end foreach
                // print_r($res); exit;
            } else {
                $res = "No prelim details found.";
            }

            /** Cron log start */
            $res = json_encode(['prelim inserted' => count($newSyncedFile), 'orders_inserted' => $newSyncedFile]);
            $url = $reqUrl;
            $this->order->syncLogs('softpro', 'get_bulk_prelim_report', $url, $reqData, $res, 0, 0);
            /** Cron log end */

        }
        
        
        echo json_encode(['status' => 'success','message' => $prelimFetchedCount . ' Orders prelim document updated successfully']);
    }

    public function fetchSinglePrelimreport() {
        $this->load->library('order/softPro');
        $this->load->model('order/apiLogs');
        ini_set('max_execution_time', 0);
        ini_set('memory_limit', '2048M');
        if (isset($_GET['orderNumber'])) {
            $req['orderNumber'] = $_GET['orderNumber'];
            $req['isAutomationCall'] = false;
        } else {
            exit;
        }
        
        $queryParams = http_build_query($req);
        // $queryParams = "DateFrom=$startDate&DateTo=$endDate";
        // $queryParams = "DateFrom=03-26-2025&DateTo=03-26-2025";
        $reqData     = json_encode($req);
        $logid = $this->apiLogs->syncLogs($userdata['id'], 'softpro', 'get_single_prelim_report', 'get_single_prelim_report', $reqData, [], 0, 0);
        $response    = $this->softpro->make_request('GET', 'get_single_prelim_report', $reqData, $queryParams);
        $this->apiLogs->syncLogs($userdata['id'], 'softpro', 'get_single_prelim_report', 'get_single_prelim_report', $reqData, json_encode($response), 0, $logid);
        
        $prelimFetchedCount= 0;
        if (!empty($response) && $response['status'] == 'success') {
            
            $this->db->select('o.id, o.customer_id, o.file_number, o.softpro_status');
            $this->db->from('order_details as o');
            $this->db->where('o.file_number', $response['OrderNumber']);
            $filesResult = $this->db->get()->row_array();

            $this->db->select('*');
            $this->db->from('pct_order_prelim_summary as s');
            $this->db->where('file_number', $response['OrderNumber']);
            $prelimSummaryDetails = $this->db->get()->row_array();

            // if (empty($prelimSummaryDetails) && !empty($response['data'])) {
            if (!empty($response['data']) && !empty($filesResult)) {
                $orderId = $filesResult['id'];
                $file_number = $response['OrderNumber'];
                $prelimLink = $response['data'][0];
                $prelimFetchedCount++;
                $documentName = basename($prelimLink);
                $document_name = time() . "_prelim_doc_" . $file_number . '.pdf';
                $uploadStatus = $this->order->uploadDocumentUsingLinkOnAwsS3($prelimLink, $document_name, 'documents');

                if ($uploadStatus) {
                    $this->load->model('order/document');
                    $getPrelimCount = $this->document->countPrelimDocument($orderId);
                    if ($getPrelimCount == 0) {
                        $documentData = array(
                            'document_name' => $document_name,
                            'original_document_name' => urldecode($documentName),
                            'user_id' => $filesResult['customer_id'],
                            'order_id' => $filesResult['id'],
                            'description' => $documentName,
                            'created' => date('Y-m-d H:i:s'),
                            'is_sync' => 1,
                            'is_prelim_document' => 1,
                        );
                        $this->document->insert($documentData);
                    } 
                    // else {
                    //     $documentData = array(
                    //         'document_name' => $document_name,
                    //         'original_document_name' => urldecode($documentName),
                    //         'description' => $documentName,
                    //         'is_sync' => 1
                    //     );
                    //     $condition = [
                    //         'order_id' => $orderId,
                    //         'is_prelim_document' => 1,
                    //     ];
                    //     $this->document->update($documentData, $condition);
                    // }
                    
                    $res = json_encode(['prelim inserted' => 1, 'orders_inserted' => $file_number]);
                }
                if (empty($prelimSummaryDetails)) {
                    $summaryData = [
                        'file_number' => $filesResult['file_number'],
                        'created_at' => date('Y-m-d H:i:s'),
                    ];
                    // $id = $this->db->insert('pct_order_prelim_summary', $summaryData);
                    $id = $this->home_model->insert($summaryData, 'pct_order_prelim_summary');
                    $condition = array(
                        'id' => $filesResult['id'],
                    );
                    $data = array(
                        'prelim_summary_id' => $id,
                    );
                    $this->order->update($data, $condition);
                } 
                // else {
                //     $prelimData = array(
                //         'is_doc_updated' => 1
                //     );
                //     $prelimCondition = [
                //         'file_number' => $file_number
                //     ];
                //     $this->order->updateRecords($prelimData, $prelimCondition, 'pct_order_prelim_summary');
                // }
            } else {
                $res = "Prelim summury details not exist for order number: " . $req['orderNumber'];
            }
        } else {
            $res = json_encode($response);
        }

        /** Cron log start */
        $apiEndPoints = SOFTPRO_API_END;
        $url          = getenv("SOFT_PRO_API") . $apiEndPoints['get_single_prelim_report'] . '?' . $queryParams;
        $this->order->syncLogs('softpro', 'get_single_prelim_report', $url, $reqData, $res, 0, 0);
        /** Cron log end */

        echo json_encode(['status' => 'success','message' => $prelimFetchedCount . ' Orders prelim document updated successfully']);
    }

    public function postPrelimreport() {
        $this->load->model('order/apiLogs');
        
        $reqData     = file_get_contents("php://input");
        $logid =  $this->apiLogs->syncLogs($userdata['id'], 'softpro', 'received_prelim_report', 'received_prelim_report', $reqData, [], 0, 0);
        
        $response    = json_decode($reqData, true);
        if (!empty($response) && $response['Status'] == 200) {
            
            $this->db->select('o.id, o.customer_id, o.file_number, o.softpro_status');
            $this->db->from('order_details as o');
            $this->db->where('o.file_number', $response['OrderNumber']);
            $filesResult = $this->db->get()->row_array();

            $this->db->select('*');
            $this->db->from('pct_order_prelim_summary as s');
            $this->db->where('file_number', $response['OrderNumber']);
            $prelimSummaryDetails = $this->db->get()->row_array();
            // if (empty($prelimSummaryDetails) && !empty($response['data']) && !empty($filesResult)) {
            if (!empty($response['data']) && !empty($filesResult)) {
                $orderId = $filesResult['id'];
                $file_number = $response['OrderNumber'];
                $prelimLink = $response['data'][0];
                $prelimFetchedCount++;
                $documentName = basename($prelimLink);
                $document_name = time() . "_prelim_doc_" . $file_number . '.pdf';
                $uploadStatus = $this->order->uploadDocumentUsingLinkOnAwsS3($prelimLink, $document_name, 'documents');
                if ($uploadStatus) {
                    $this->load->model('order/document');
                    $getPrelimCount = $this->document->countPrelimDocument($orderId);
                    if ($getPrelimCount == 0) {
                        $documentData = array(
                            'document_name' => $document_name,
                            'original_document_name' => urldecode($documentName),
                            'user_id' => $filesResult['customer_id'],
                            'order_id' => $orderId,
                            'description' => $documentName,
                            'created' => date('Y-m-d H:i:s'),
                            'is_sync' => 1,
                            'is_prelim_document' => 1,
                        );
                        $documentId = $this->document->insert($documentData);

                        if (empty($prelimSummaryDetails)) {
                            $summaryData = [
                                'file_number' => $filesResult['file_number'],
                                'created_at' => date('Y-m-d H:i:s'),
                            ];
                            // $id = $this->db->insert('pct_order_prelim_summary', $summaryData);
                            $id = $this->home_model->insert($summaryData, 'pct_order_prelim_summary');

                            $condition = array(
                                'id' => $filesResult['id'],
                            );
                            $data = array(
                                'prelim_summary_id' => $id,
                            );
                            $this->order->update($data, $condition);
                        }
                    } else {
                        $documentData = array(
                            'document_name' => $document_name,
                            'original_document_name' => urldecode($documentName),
                            'description' => $documentName,
                            'is_sync' => 1
                        );
                        $condition = [
                            'order_id' => $orderId,
                            'is_prelim_document' => 1,
                        ];
                        $this->document->update($documentData, $condition);

                        $prelimData = array(
                            'is_doc_updated' => 1
                        );
                        $prelimCondition = [
                            'file_number' => $file_number
                        ];
                        $this->order->updateRecords($documentData, $condition, 'pct_order_prelim_summary');
                    }

                    $status = 'success';
                    $msg = "Document uploaded sucecssfully.";
                } else {
                    $status = 'error';
                    $msg = "Error while uploading.";
                }
            } else {
                $status = 'error';
                $msg = "Invalid request or Prelim already exist or order number not found.";
            }
            // echo '$uploadStatus ==' . $uploadStatus;
            
        } else {
            $status = 'error';
            $msg = "Invalid request or order number not found.";
        }
        $apiEndPoints = SOFTPRO_API_END;
        // $url          = getenv("SOFT_PRO_API") . $apiEndPoints['received_prelim_report'] . '?' . $queryParams;
        
        /** Cron log start */
        $res = json_encode(['status' => $status, 'message' => $msg]);
        $this->order->syncLogs('softpro', 'received_prelim_report', 'received_prelim_report', $reqData, $msg, 0, 0);
        /** Cron log end */

        $this->apiLogs->syncLogs($userdata['id'], 'softpro', 'received_prelim_report', 'received_prelim_report', $reqData, $res, 0, $logid);
        echo $res;exit;
    }

    public function postPrelimSummary() {
        $this->load->model('order/apiLogs');
        // $this->load->library('order/chatgpt');
        $this->load->library('order/parsedown');
        $reqData     = file_get_contents("php://input");
        // $reqData = '{"Status":200,"Message":"Success","OrderNumber":"20004763-GLT","Id":null,"FileUploadedStatus":false,"data":{"orderNumber":null,"vesting":null,"requirements":[{"description":"In order to complete this report, the Company requires a Statement of Information to be completed by the following party(s),\n\nParty(s):  ALL PARTIES\n\nThe Company reserves the right to add additional items or make further requirements after review of the requested Statement of Information.\n\nNOTE:  The Statement of Information is necessary to complete the search and examination of title under this order.  Any title search includes matters that are indexed by name only, and having a completed Statement of Information assists the Company in the elimination of certain matters which appear to involve the parties but in fact affect another party with the same or similar name. Be assured that the Statement of Information is essential and will be kept strictly confidential to this file."}],"lien":[{"LienBookPages":null,"LienID":0,"LienTypeID":0,"LienTypeName":null,"Against":null,"Amount":null,"Assignee":null,"AssigneeBook":null,"AssigneeInstrument":null,"AssigneeLiber":null,"AssigneePage":null,"AssigneeVolume":null,"Assignor":null,"Book":null,"BookPages":null,"CaseNumber":null,"County":null,"CourtDistrict":null,"CourtType":null,"Date":null,"DocumentName":null,"Endorsements":null,"Flagged":false,"Grantee":null,"Grantor":null,"Holder":null,"InFavorOf":null,"InstallmentAmount":null,"InstallmentNumber":null,"Instrument":null,"IsAllCaps":false,"Language":null,"Liber":null,"MaturityDate":null,"Page":null,"Purpose":null,"RecordedDate":null,"State":null,"StateDistrict":null,"TaxYears":null,"Trustee":null,"Volume":null}],"easements":[],"exceptions":[{"description":"Property taxes , which are a lien not yet due and payable, including any assessments collected with taxes to be levied for the fiscal year 2025-2026."},{"description":"Note: Property taxes for the fiscal year shown below are PAID.  For proration purposes the amounts were:\n\nTax Identification No.:\t181-383-008\nFiscal Year:  \t2024-2025\n1st  Installment:   \t$5,296.66  \n2nd Installment:   \t$5,296.66\nExemption:   \t$0.00\nLand:    \t$74,284.00\nImprovements:   \t$423,421.00\nPersonal Property:  \t$0.00\nCode Area:                    028-088"},{"description":"The herein described Land is within the boundaries of the Mello-Roos Community Facilities District(s). The annual assessments, if any, are collected with the county property taxes. Failure to pay said taxes prior to the delinquency date may result in the above assessment being removed from the county tax roll and subjected to Accelerated Judicial Bond Foreclosure. Inquiry should be made with said District for possible stripped assessments and prior delinquencies."},{"description":"The lien of supplemental taxes, if any, assessed pursuant to the provisions of Chapter 3.5 (Commencing with Section 75) of the Revenue and Taxation Code of the State of California."},{"description":"Water rights, claims or title to water, whether or not disclosed by the Public Records."},{"description":"Easement(s) for the purpose(s) shown below and rights incidental thereto, as granted in a document:\n\nGranted to:\tCalifornia Electric Power Company \nPurpose:\tPublic Utilities\nRecording Date:\tApril 15, 1947\nRecording No:\tin Book 831, Page 73, of Official Records\nAffects:\tSaid land"},{"description":"Easement(s) for the purpose(s) shown below and rights incidental thereto, as granted in a document:\n\nGranted to:\tPacific Telephone and Telegraph Company \nPurpose:\tPublic Utilities\nRecording Date:\tAugust 14, 1947\nRecording No:\tin Book 862, Page 130, of Official Records\nAffects:\tSaid land"},{"description":"A notice that said Land is included within a project area of the Redevelopment Agency shown below, and that proceedings for the redevelopment of said project have been instituted under the Redevelopment Law (such redevelopment to proceed only after the adoption of the redevelopment plan) as disclosed by a document \n\nRecording Date: July 10, 1996 \nRecording No: 96-256410, Official Records \nRedevelopment Agency:   Jurupa Valley Redevelopment Project Area Merger and Amendment (the\"Merger and Amendment Area\")"},{"description":"Matters contained in that certain document\n\nEntitled:\t\"Proposed Boundaries of Assessment District No. 07-02 California Statewide Communities Development Authority\"\nRecording Date:\tAugust 23, 2007\nRecording No:\t2007-544462, of Official Records\nWhich provides for, among other things:  .\n\nReference is hereby made to said document for full particulars."},{"description":"An irrevocable offer to dedicate an easement over a portion of said Land for \n\nPurpose(s): Public street and Public Utility Purposes \nRecording Date: June 13, 2016 \nRecording No.: in Book 451, Page 13 through 22, inclusive, of Maps\nAffects:  Lots A through K Inclusive"},{"description":"Recitals as shown on that certain map/plat\r\n\r\nRecording Date: June 13, 2016\r\nRecording No: Book 451, Page 13 through 22, inclusive, of Maps\r\n\r\nWhich among other things recites Lot 68 is retained for Park Purposes.\r\n\r\nReference is hereby made to said document for full particulars."},{"description":"Recitals as shown on that certain map/plat\r\n\r\nRecording Date: June 13, 2016\r\nRecording No: Book 451, Page 13 through 22, inclusive, of Maps\r\n\r\nWhich among other things recites Lots 69, 70, 71, 72 and 73 are retained for Open Space Purposes.\r\n\r\nReference is hereby made to said document for full particulars."},{"description":"Recitals as shown on that certain map/plat\n\nRecording Date: June 13, 2016\nRecording No: Book 451, Page 13 through 22, inclusive, of Maps\n\nWhich among other things recites Lots 67 is retained as a storm drain retention basin\n\nReference is hereby made to said document for full particulars."},{"description":"Recitals as shown on that certain map/plat\r\n\r\nRecording Date: June 13, 2016\r\nRecording No: Book 451, Page 13 through 22, inclusive, of Maps\r\n\r\nWhich among other things recites Lots 74 and 75 are retained for Landscape Purposes.\r\n\r\nReference is hereby made to said document for full particulars."},{"description":"Reciprocal easements, for the purpose(s) shown below and rights incidental thereto as created by the following document:\n\nDocument: Grant of Easements\nExecuted by: Loring Ranch 31503, L.P., a California limited partnership and D.R. Horton CA3, Inc., a Delaware Corporation\nPurpose: Temporary non-exclusive easements for removing excess dirt stockpiles\nRecording Date: August 19, 2016\nRecording No. 2016-356222, of Official Records\nAffects: Said Land"},{"description":"Easement(s) for the purpose(s) shown below and rights incidental thereto, as granted in a document:\n\nGranted to:\tSouthern California Edison \nPurpose:\tPublic Utilities\nRecording Date:\tDecember 14, 2016\nRecording No:\t2016-556301, of Official Records\nAffects:\tSaid Land"},{"description":"Easement(s) for the purpose(s) shown below and rights incidental thereto, as granted in a document:\n\nGranted to:\tSouthern California Gas Company, a California Corporation \nPurpose:\tPublic Utilities\nRecording Date:\tDecember 29, 2016\nRecording No:\t2016-581351, of Official Records\nAffects:\tSaid Land"},{"description":"Easement(s) for the purpose(s) shown below and rights incidental thereto, as granted in a document:\n\nGranted to:\tPacific Bell Telephone Company \nPurpose:\tPublic Utilities\nRecording Date:\tFebruary 9, 2017\nRecording No:\t2017-58325, of Official Records\nAffects:\tSaid Land"},{"description":"Covenants, conditions and restrictions but omitting any covenants or restrictions, if any, including but not limited to those based upon race, color, religion, sex, sexual orientation, familial status, marital status, disability, handicap, national origin, ancestry, source of income, gender, gender identity, gender expression, medical condition or genetic information, as set forth in applicable state or federal laws, except to the extent that said covenant or restriction is permitted by applicable law, as set forth in the document\n\nRecording Date:\tFebruary 14, 2017\nRecording No:\t2017-64885, of Official Records ."},{"description":"Said covenants, conditions and restrictions provide that a violation thereof shall not defeat the lien of any mortgage or deed of trust made in good faith and for value."},{"description":"Matters contained in that certain document\n\nEntitled:\tMaster Dispute Resolution Declaration for Skypark\nRecording Date:\tFebruary 21, 2017\nRecording No:\t2017-72693, of Official Records\nWhich provides for, among other things:  .\n\nReference is hereby made to said document for full particulars."},{"description":"Matters contained in that certain document\n\nEntitled:\tIndividual Dispute Resolution Agreement For Skypark\nExecuted by:\tDR. Horton Ca3, Inc, a Delaware corporation and between Eun Kyoung Sim\nRecording Date:\tSeptember 27, 2017\nRecording No:\t2017-399978, of Official Records\nWhich provides for, among other things:  .\n\nReference is hereby made to said document for full particulars."},{"description":"An easement for the purpose shown below and rights incidental thereto as set forth in a document \n\nPurpose: Establishment of Easement \nRecorded: September 27, 2017 \nRecording no.: 2017-399980, Official Records \nAffects:  Said Land"},{"description":"Easement(s) for the purpose(s) shown below and rights incidental thereto, as granted in a document:\n\nGranted to:\tSouthern California Edison Company \nPurpose:\tPublic utilities\nRecording Date:\tMarch 28, 2018\nRecording No:\t2018-116367, of Official Records\nAffects:\tAll Streets, highways, public places, and within six feet of all front lots lines, also three feet on each side of all side lot lines of lot 1 through 66, inclusive of tract no. 31503-1, as per map filed in book 451, Page 13 through 22, inclusive of maps, in the office of the county recorder of said county."},{"description":"A Deed of Trust to secure an indebtedness in the amount shown below, and any other obligations secured thereby: \n\nAmount: $446,682.00\nDated: July 20, 2020 \nTrustor: Sofia V. Sapia, a single woman \nTrustee:  Chicago Title Company \nBeneficiary: MORTGAGE ELECTRONIC REGISTRATION SYSTEMS, INC. (MERS) SOLELY AS NOMINEE FOR LENDER \nLender: Bay-Valley Mortgage Group\nLoan No.: Not set out\nRecording Date: July 28, 2020\nRecording No.: 2020-0336656, Official Records"},{"description":"This Company will require that the original note, the original deed of trust and a properly executed request for full reconveyance together with appropriate documentation (i.e., copy of trust, partnership agreement or corporate resolution) be in this office prior to the close of this transaction if the above-mentioned item is to be paid through this transaction or deleted from a policy of title insurance. \n\nAny demands submitted to us for payoff must be signed by all beneficiaries as shown on said deed of trust, and/or any assignments thereto. In the event said demand is submitted by an agent of the beneficiary(s), we will require the written approval of the demand by the beneficiary(s). Servicing agreements do not constitute approval for the purposes of this requirement. \n\nIf no amounts remain due under the obligation a zero balance demand will be required along with the reconveyance documents. \n\nIn addition, we require the written approval of said demand by the trustor(s) on said deed of trust or the current owners if applicable."}],"Restrictions":[],"Grantee":"Hai Minh Tran and Dung T Tu","Grantor":"Sofia V Sapia"}}';
        // $reqData = '{"Status":200,"Message":"Success","OrderNumber":"20005202-GLT","Id":null,"FileUploadedStatus":false,"data":{"orderNumber":null,"vesting":null,"requirements":[{"description":"In order to complete this report, the Company requires a Statement of Information to be completed by the following party(s),\n\nParty(s):  ALL PARTIES\n\nThe Company reserves the right to add additional items or make further requirements after review of the requested Statement of Information.\n\nNOTE:  The Statement of Information is necessary to complete the search and examination of title under this order.  Any title search includes matters that are indexed by name only, and having a completed Statement of Information assists the Company in the elimination of certain matters which appear to involve the parties but in fact affect another party with the same or similar name. Be assured that the Statement of Information is essential and will be kept strictly confidential to this file."}],"lien":[{"LienBookPages":null,"LienID":0,"LienTypeID":0,"LienTypeName":null,"Against":null,"Amount":null,"Assignee":null,"AssigneeBook":null,"AssigneeInstrument":null,"AssigneeLiber":null,"AssigneePage":null,"AssigneeVolume":null,"Assignor":null,"Book":null,"BookPages":null,"CaseNumber":null,"County":null,"CourtDistrict":null,"CourtType":null,"Date":null,"DocumentName":null,"Endorsements":null,"Flagged":false,"Grantee":null,"Grantor":null,"Holder":null,"InFavorOf":null,"InstallmentAmount":null,"InstallmentNumber":null,"Instrument":null,"IsAllCaps":false,"Language":null,"Liber":null,"MaturityDate":null,"Page":null,"Purpose":null,"RecordedDate":null,"State":null,"StateDistrict":null,"TaxYears":null,"Trustee":null,"Volume":null}],"easements":[],"exceptions":[{"description":"Property taxes, which are a lien not yet due and payable, including any assessments collected with taxes to be levied for the fiscal year 2025-2026. \n\nTax Identification No.: 149-281-027"},{"description":"Note: Property taxes for the fiscal year shown below are PAID.  For proration purposes the amounts were:\n\nTax Identification No.:\t149-281-027\nFiscal Year:  \t2024-2025\n1st  Installment:   \t$3,342.38  \n2nd Installment:   \t$3,342.38\nExemption:   \t$7,000.00\nLand:    \t$78,112.00\nImprovements:   \t$474,717.00\nPersonal Property:  \t$0.00\nCode Area:\t009-175"},{"description":"Any liens or other assessments, bonds, or special district liens including without limitation, Community Facility Districts, that arise by reason of any local, City, Municipal or County Project or Special District."},{"description":"The lien of supplemental taxes, if any, assessed pursuant to the provisions of Chapter 3.5 (Commencing with Section 75) of the Revenue and Taxation Code of the State of California."},{"description":"Water rights, claims or title to water, whether or not disclosed by the Public Records."},{"description":"Easement(s) for the purpose(s) shown below and rights incidental thereto, as granted in a document:\n\nGranted to:\tLa Sierra Heights Water Company, a Corporation\nPurpose:\tRight of way arid water rights together with right of entry for the purpose of laying, maintaining and constructing water, ditches, canals, pipelines, flumes and conduits, for conveying and distributing water for domestic and irrigation purposes\nRecording Date:\tMay 17, 1911\nRecording No:\tBook 327 Page 227, of Deeds\nAffects:\tSaid land more particularly described therein"},{"description":"Easement(s) for the purpose(s) shown below and rights incidental thereto, as granted in a document:\n\nGranted to:\tTwin Buttes Water Company, a Corporation\nPurpose:\tRight of way arid water rights together with right of entry for the purpose of laying, maintaining and constructing water, ditches, canals, pipelines, flumes and conduits, for conveying and distributing water for domestic and irrigation purposes\nRecording Date:\tAugust 11, 1919\nRecording No:\tBook 508 Page 101, of Deeds\nAffects:\tSaid land more particularly described therein"},{"description":"Discrepancies, conflicts in boundary lines, shortage in area, encroachments, or any other matters shown on\n\nMap:\t\tRecord of Survey\nRecording No:\tBook 29 Page 40"},{"description":"All easements, recitals, offers and dedications as shown on the official map \n\nParcel Map:\t\t25330 "},{"description":"A notice that said Land is included within a project area of the Redevelopment Agency shown below, and that proceedings for the redevelopment of said project have been instituted under the Redevelopment Law (such redevelopment to proceed only after the adoption of the redevelopment plan) as disclosed by a document \n\nRecording Date: July 29, 2004 \nRecording No: 2004-0588604, Official Records \nRedevelopment Agency:   La Sierra/Arlanza Redevelopment Project"},{"description":"A Deed of Trust to secure an indebtedness in the amount shown below, and any other obligations secured thereby: \n\nAmount: \t\t$369,550.00\nDated: \t\t\tFebruary 26, 2021 \nTrustor: \t\tJose Perez Flores, an unmarried man and Albert Perez, a single man \nTrustee:  \t\tHeather Lovier \nBeneficiary: \t\tMORTGAGE ELECTRONIC REGISTRATION SYSTEMS, INC. (MERS) SOLELY AS NOMINEE FOR LENDER \nLender: \t\tQuicken Loans, LLC, a Limited Liability Company\nLoan No.: \t\tNot Shown\nRecording Date: \tMarch 3, 2021\nRecording No.: \t\t2021-0136449, Official Records"}],"Restrictions":[],"Grantee":"Generic Buyer","Grantor":"Jose Perez Flores and Perez Aurora Garcia De"}}';
        $logid =  $this->apiLogs->syncLogs(0, 'softpro', 'received_prelim_summary', 'received_prelim_summary', $reqData, [], 0, 0);
        // print_r($logid);exit;
        $response    = json_decode($reqData, true);
        $configData  = $this->order->getConfigData();
        $prelimSummaryEmailFlag = $configData['enable_prelim_summary_email']['is_enable'];
        $prelimSummaryShutOffFlag = $configData['prelim_summary_shut_off']['is_enable'];
        
        if ($prelimSummaryShutOffFlag == 1) {
            $res = "Admin has disabled Prelim Summary Process.";
            $this->apiLogs->syncLogs(0, 'softpro', 'received_prelim_summary', 'received_prelim_summary', $reqData, $res, 0, $logid);
            echo $res; exit;
        }
        if (!empty($response) && $response['Status'] == 200 && !empty($response['data'])) {
            $responseData = $response['data'];
            $condition = [
                // 'file_number' => '20001146-GLT' //$response['OrderNumber'],
                'file_number' => $response['OrderNumber']
            ];

            $prelimRow = $this->order->get_row($condition, 'pct_order_prelim_summary');
            // echo "<pre> test it";
            // print_r($prelimRow);die;

            $response['data']['orderNumber'] = $response['OrderNumber'];
            if (empty($prelimRow)) {
                $prelimData = array(
                    'file_number' => $response['OrderNumber'],
                    'resware_json' => json_encode($response['data']),
                    'created_at' => date('Y-m-d H:i:s')
                );
                $prelimSumaryId = $this->home_model->insert($prelimData, 'pct_order_prelim_summary');
                // $prelimSumaryId = $this->db->insert('pct_order_prelim_summary', $prelimData);
                
                $condition = array(
                    'file_number' => $response['OrderNumber'],
                );
                $data = array(
                    'prelim_summary_id' => $prelimSumaryId,
                );
                $this->order->update($data, $condition);
            } else {
                $prelimData = array(
                    'resware_json' => json_encode($response['data']),
                    'updated_at' => date('Y-m-d H:i:s')
                );
                $this->db->set($prelimData);
                $this->db->where($condition);
                $this->db->update('pct_order_prelim_summary');
            }
            $this->load->library('order/order');
            $chatGptJsonRes = $this->order->getPrelimAISummary($responseData);
            $this->apiLogs->syncLogs(0, 'sendgrid', 'received_prelim_summary', 'received_prelim_summary', $reqData, $chatGptJsonRes, 0, $logid);
            // $chatGptJsonRes = $this->chatgpt->make_request($prompt);

            // $chatGptJsonRes = '{
            //     "id": "chatcmpl-BmvJkdviDDtGzbXLLUpNmreoOtd3C",
            //     "object": "chat.completion",
            //     "created": 1750999772,
            //     "model": "gpt-4o-mini-2024-07-18",
            //     "choices": [
            //         {
            //         "index": 0,
            //         "message": {
            //             "role": "assistant",
            //             "content": "### Requirements\n- A Statement of Information is needed from all parties involved.\n- This statement is crucial for completing the title search.\n- It helps identify and eliminate confusion related to names.\n- The information will remain confidential.\n\n### Liens\n- **None recorded**\n\n### Easements\n- **None recorded**\n\n### Exceptions\n- Property taxes that are not yet due for the fiscal year 2025-2026.\n  - **Tax Identification No.:** 6144-019-015\n- Property taxes for the fiscal year 2024-2025 are paid.\n  - **Tax Identification No.:** 6144-019-015\n  - **1st Installment:** $4,445.62\n  - **2nd Installment:** $4,445.62\n  - **Exemption:** $0.00\n  - **Land Value:** $271,804.00\n  - **Improvements Value:** $118,473.00\n  - **Personal Property Value:** $0.00\n  - **Code Area:** 11252\n- Liens or assessments from local projects or special districts.\n- Supplemental taxes according to California law.\n- Water rights or claims to water.\n- **Easements:**\n  - Single channel easement for Compton Creek (Recorded: March 3, 1923).\n  - Utility easement (Unlocated, Book 3208, Page 173).\n  - Public street easement affecting the southerly 25 feet of specific lots (Book 3208, Page 1).\n- Deed of Trust to secure a loan of $296,250.00.\n  - **Trustor/Grantor:** Iris Yolanda Martinez\n  - **Trustee:** Fidelity National Title\n  - **Beneficiary:** Metwest Commercial Lender, Inc.\n  - **Recording Date:** June 29, 2007\n- Assignment of rental moneys for additional security.\n  - **Assigned to:** Bayview Loan Servicing LLC\n  - **Recording Date:** February 26, 2008\n- Assignment of beneficial interest under the deed of trust.\n  - **Assignee:** Bayview Loan Servicing LLC\n  - **Loan No.:** 2142284\n  - **Recording Date:** February 25, 2008\n- Financing statement for Iris Yolanda Martinez.\n  - **Secured Party:** Bayview Loan Servicing, LLC\n  - **Recording Date:** August 23, 2007\n- Continuation of the financing statement.\n  - **Recording Date:** June 23, 2022\n- Notice of land inclusion in a redevelopment project area.\n  - **Recording Date:** December 14, 2007\n  - **Redevelopment Agency:** The Walnut Industrial Park Redevelopment Project\n\n### Restrictions\n- **None recorded**\n\n### Grantee\n- **Not provided**\n\n### Grantor\n- **Iris Yolanda Martinez**",
            //             "refusal": null,
            //             "annotations": []
            //         },
            //         "logprobs": null,
            //         "finish_reason": "stop"
            //         }
            //     ],
            //     "usage": {
            //         "prompt_tokens": 1575,
            //         "completion_tokens": 609,
            //         "total_tokens": 2184,
            //         "prompt_tokens_details": {
            //         "cached_tokens": 0,
            //         "audio_tokens": 0
            //         },
            //         "completion_tokens_details": {
            //         "reasoning_tokens": 0,
            //         "audio_tokens": 0,
            //         "accepted_prediction_tokens": 0,
            //         "rejected_prediction_tokens": 0
            //         }
            //     },
            //     "service_tier": "default",
            //     "system_fingerprint": "fp_34a54ae93c"
            // }';

            $chatGptRes    = json_decode($chatGptJsonRes, true);
            $prelimData = array(
                'chatgpt_json' => $chatGptJsonRes,
                'updated_at' => date('Y-m-d H:i:s')
            );
            $condition = [
                // 'file_number' => '20001146-GLT'
                'file_number' => $response['OrderNumber']
            ];
            $this->db->set($prelimData);
            $this->db->where($condition);
            $this->db->update('pct_order_prelim_summary');
            if ($prelimSummaryEmailFlag == 0) {
                $res = "Prelim Summary Email is disabled by Admin.";
                $this->apiLogs->syncLogs(0, 'sendgrid', 'send_mail_for_prelim_summary', 'send_mail_for_prelim_summary', $reqData, $res, 0, $logid);
                echo $res; exit;
            }
            $markdown = $chatGptRes['choices'][0]['message']['content'] ?? 'No content received.';
            $data['html'] = $this->parsedown->text($markdown);
            $data['file_number'] = $response['OrderNumber'];
            // $data['adrress'] = $response['OrderNumber'];
            $message = $this->load->view('emails/prelim_summary.php', $data, true);
            $from_name = 'Pacific Coast Title Company';
            $from_mail = env('FROM_EMAIL');
            $to = 'ghernandez@pct.com';
            $subject = 'Prelim Summary : '. $response['OrderNumber'];
            $cc = ['piyush-crest@yopmail.com'];
            $mailParams = array(
                'from_mail' => $from_mail,
                'from_name' => $from_name,
                'to' => $to,
                'subject' => $subject,
                'message' => $response['OrderNumber'],
                'cc' => $cc,
            );
            //$to = 'ghernandez@pct.com';
            //$cc = array();
            $this->load->helper('sendemail');
            $logid = $this->apiLogs->syncLogs(0, 'sendgrid', 'send_mail_for_prelim_summary', '', $mailParams, array(), 0, 0);
            $mail_result = send_email($from_mail, $from_name, $to, $subject, $message, [], $cc, []);
            $this->apiLogs->syncLogs(0, 'sendgrid', 'send_mail_for_prelim_summary', '', $mailParams, array('status' => $mail_result), 0, $logid);
            // return $mail_result;
            // echo "<pre>";
            // print_r($mail_result);die;
            
            echo "<pre>";
            print_r($chatGptRes);die;
        }
    }

    public function postPolicyDocument() {
        $this->load->model('order/apiLogs');
        
        $reqData     = file_get_contents("php://input");
        // $reqData = '{"Status":200,"Message":"Success","OrderNumber":"TEST-20001579-OCT","Id":null,"FileUploadedStatus":true,"data":[{"FileName":"Lender\'s Policy","FileUrl":"http://100.29.181.61/SoftProIntegrate/assets/Lender%27s%20Policy_105516.pdf"}]}';
        // $reqData = '{"Status":200,"Message":"Success","OrderNumber":"20002347-GLT","Id":null,"FileUploadedStatus":true,"data":[{"FileName":"Owne\'s Policy Jacket","FileUrl":"http://100.29.181.61/SoftProProduction/assets/Owner%27s%20Policy%20Jacket_181648.pdf"}]}';
        $logid =  $this->apiLogs->syncLogs($userdata['id'], 'softpro', 'received_policy_document', 'received_policy_document', $reqData, [], 0, 0);
        $response    = json_decode($reqData, true);
        // echo "<pre>";
        // print_r($response);die;
        
        if (!empty($response) && $response['Status'] == 200) {
            $this->load->library('order/softPro');
            $this->db->select('o.id, o.customer_id, o.file_number, o.softpro_status, o.lender_policy_sent, o.owner_policy_sent, o.supplement_statement_sent, p.full_address, p.address, p.city, p.state, p.zip, p.escrow_id, u.email_address, p.id as property_id');
            $this->db->from('order_details as o');
            $this->db->join('property_details as p', 'o.property_id = p.id');
            $this->db->join('pct_softpro_lookup_table as u', 'p.escrow_id = u.id', 'left');
            $this->db->where('o.file_number', $response['OrderNumber']);
            $filesResult = $this->db->get()->row_array();
            $fileNumber = $response['OrderNumber'];
            $propertyId = $filesResult['property_id'];
            // echo "<pre>";
            // print_r($filesResult);die;
            
            // print_r($softproContacts);die;
            if (!empty($response['data']) && !empty($filesResult)) {
                $orderId = $filesResult['id'];
                $file_number = $response['OrderNumber'];

                $documentList = $response['data'];
                $this->load->model('order/document');
                $updateOrderDetails = [];
                $policyDocFlag = $supplementDocFlag = false;
                foreach ($documentList as $key => $doc) {
                    $docType = $doc['FileName'];
                    $docLink = $doc['FileUrl'];
                    $documentBaseName = basename($docLink);
                    $condition = [
                        'order_id' => $orderId
                    ];
                    $is_lender_policy = $is_owner_policy = $is_supplement_statement = false;
                    if (strpos(strtolower($docType), 'policy') !== false) {
                        if (strpos(strtolower($docType), 'lender') !== false) {
                            if ($filesResult['lender_policy_sent'] == 1) {
                                $status = 'error';
                                $msg = "Email already sent.";
                                continue; // Skip if lender policy already sent
                            }
                            $is_lender_policy = 1;
                            $condition['is_lender_policy'] = 1;
                        } else {
                            if ($filesResult['owner_policy_sent'] == 1) {
                                $status = 'error';
                                $msg = "Email already sent.";
                                continue; // Skip if owner policy already sent
                            }
                            $is_owner_policy = 1;
                            $condition['is_owner_policy'] = 1;
                        }
                        $document_name = time() . "_policy_" . str_replace(["'", " "], "", $docType) . '_' . $file_number . '.pdf';
                        $policyDocFlag = true;
                    } else if (strpos(strtolower($docType), 'supplement') !== false) {
                        if ($filesResult['supplement_statement_sent'] == 1) {
                            $status = 'error';
                            $msg = "Email already sent.";
                            continue; // Skip if supplement statement already sent
                        }
                        $condition['is_supplement_statement'] = 1;
                        $document_name = time() . "_supplement_" . str_replace(["'", " "], "", $docType) . '_' . $file_number . '.pdf';
                        $is_supplement_statement = 1;
                        $supplementDocFlag = true;
                    } else {
                        continue;
                    }

                    $uploadStatus = $this->order->uploadDocumentUsingLinkOnAwsS3($docLink, $document_name, 'documents');

                    // print_r($condition);die;
                    // if (true) {
                    // if (true) {
                    if ($uploadStatus) {
                        $policyDocumentsList = $this->order->getPolicyDocuments($condition);
                        // echo "<pre>";
                        // print_r($policyDocumentsList);die;
                        if (empty($policyDocumentsList)) {
                            $documentData = array(
                                'document_name' => $document_name,
                                'original_document_name' => urldecode($documentBaseName),
                                'user_id' => $filesResult['customer_id'],
                                'order_id' => $orderId,
                                'description' => $documentBaseName,
                                'created' => date('Y-m-d H:i:s'),
                                'is_sync' => 1,
                                'is_lender_policy' => $is_lender_policy,
                                'is_owner_policy' => $is_owner_policy,
                                'is_supplement_statement' => $is_supplement_statement,
                            );
                            $documentId = $this->document->insert($documentData);
                            
                        } else {
                            $existingLink = 'documents/' . $policyDocumentsList['document_name'];
                            $this->order->deleteDocumentOnAwsS3($existingLink);
                            $documentData = array(
                                'document_name' => $document_name,
                                'original_document_name' => urldecode($documentBaseName),
                                'description' => $documentBaseName,
                                'is_sync' => 1,
                                'is_lender_policy' => $is_lender_policy,
                                'is_owner_policy' => $is_owner_policy,
                            );
                            $documentId = $this->document->update($documentData, $condition);
                        }
                        if ($documentId) {
                            if ($policyDocFlag) {
                                $files['policy'][] = env('AWS_PATH') . "documents/" . $document_name;
                            } else if ($supplementDocFlag) {
                                $files['supplement'][] = env('AWS_PATH') . "documents/" . $document_name;
                            }
                        }
                        if ($is_lender_policy) {
                            $updateOrderDetails['lender_policy_sent'] = 1;
                        }
                        if ($is_owner_policy) {
                            $updateOrderDetails['owner_policy_sent'] = 1;
                        }
                        if ($is_supplement_statement) {
                            $updateOrderDetails['supplement_statement_sent'] = 1;
                        }
                        $status = 'success';
                        $msg = "Document uploaded sucecssfully.";
                        $policyDocFlag = $supplementDocFlag = false;
                    } else {
                        $status = 'error';
                        $msg = "Error while uploading.";
                    }
                }

                $softproContacts = $this->order->fetchAndSyncContacts($fileNumber);
                if (!empty($softproContacts) && !empty($softproContacts['escrow'])) {
                    $filesResult['email_address'] = $softproContacts['escrow']['email_address'];
                } else {
                    $status = 'error';
                    $msg = "Escrow not found or escrow email not exist.";
                }
                // echo "<pre>";
                // print_r($softproContacts);
                // print_r($files);die;

                if (!empty($filesResult['email_address'])) {
                    $filesResult['email_to'] = $filesResult['email_address'];
                    
                    if (!empty($files['supplement'])) {
                        $suppData = $filesResult; // Clone
                        $suppData['doc_type'] = "Supplement Statement Document";
                        $suppData['file_links'] = $files['supplement'];
                        $email_status = $this->order->sendSuppPolicyEmail($suppData);
                    }

                    if(!empty($files['policy'])) {
                        $policyData = $filesResult; // Clone
                        $policyData['doc_type'] = "Policy Document";
                        $policyData['file_links'] = $files['policy'];
                        $email_status = $this->order->sendSuppPolicyEmail($policyData);
                    } 
                    
                    
                    if ($email_status && !empty($updateOrderDetails)) {
                        $condition = ['id' => $orderId];
                        $this->order->update($updateOrderDetails, $condition);
                    }
                }
            } else {
                $status = 'error';
                $msg = "Invalid request or Prelim already exist or order number not found.";
            }
        } else {
            $status = 'error';
            $msg = "Invalid request or order number not found.";
        }
        // 1747052002_policy_Lenders Policy_TEST-20001550-OCT.pdf
        /** Cron log start */
        $res = json_encode(['status' => $status, 'message' => $msg]);
        $this->order->syncLogs('softpro', 'received_policy_document', 'received_policy_document', $reqData, $msg, 0, 0);
        /** Cron log end */

        $this->apiLogs->syncLogs($userdata['id'], 'softpro', 'received_policy_document', 'received_policy_document', $reqData, $res, 0, $logid);
        echo $res;exit;
    }

    public function postMileStone() {
        $this->load->model('order/apiLogs');
        $this->load->model('order/twilioMessage');
        $reqData     = file_get_contents("php://input");

        // $reqData = '{"Status":200,"Message":"Success","OrderNumber":"TEST-20001696-OCT","Id":"04-035","FileUploadedStatus":false,"data":null}';
        // $reqData = '{"Status":200,"Message":"Success","OrderNumber":"TEST-20001696-OCT","Id":"03-020","FileUploadedStatus":false,"data":null}';
        // $reqData = '{"Status":200,"Message":"Success","OrderNumber":"20000881-OCT","Id":"03-020","FileUploadedStatus":false,"data":null}';
        $logid =  $this->apiLogs->syncLogs(0, 'softpro', 'received_milestone_update', 'received_milestone_update', $reqData, [], 0, 0);
        $response    = json_decode($reqData, true);
        
        // echo "<pre>";
        // print_r($response);die;
        

        if (!empty($response) && $response['Status'] == 200 && !empty($response['Id'])) {
            $taskId = $response['Id'];
            $configData                  = $this->order->getConfigData();
            $recordingConfirmationShutOff = $configData['recording_confirmation_shut_off']['is_enable'];
            $disburseFundsShutOff = $configData['disburse_funds_shut_off']['is_enable'];

            if ($taskId == '03-020' && $recordingConfirmationShutOff == 1) {
                $res = "Admin has disabled recording confirmation notification.";
                $this->apiLogs->syncLogs($userdata['id'], 'softpro', 'received_milestone_request', 'received_milestone_request', $reqData, $res, 0, $logid);
                echo $res; exit;
            }

            if ($taskId == '04-035' && $disburseFundsShutOff == 1) {
                $res = "Admin has disabled Disburse Funds notification.";
                $this->apiLogs->syncLogs($userdata['id'], 'softpro', 'received_milestone_request', 'received_milestone_request', $reqData, $res, 0, $logid);
                echo $res; exit; 
            }

            $this->load->library('order/softPro');
            $this->db->select('o.id, o.file_number, p.full_address, p.address, p.city, p.state, p.zip, p.id as property_id, u.id as sales_rep_id, u.email_address, u.phone, u.first_name, u.last_name, u.notify_disburse_funds, u.notify_recording_confirm, escrow.email_address as escrow_email, escrow.first_name as escrow_first_name, escrow.last_name as escrow_last_name, escrow.notify_disburse_funds as escrow_notify_disburse_funds, escrow.notify_recording_confirm as escrow_notify_recording_confirm, lender.email_address as lender_email, lender.first_name as lender_first_name, lender.last_name as lender_last_name, lender.notify_disburse_funds as lender_notify_disburse_funds, lender.notify_recording_confirm as lender_notify_recording_confirm');
            $this->db->from('order_details as o');
            $this->db->join('property_details as p', 'o.property_id = p.id');
            $this->db->join('transaction_details as t', 'o.transaction_id = t.id');
            $this->db->join('pct_softpro_lookup_table as u', 't.sales_representative = u.id', 'left');
            $this->db->join('pct_softpro_lookup_table as lender', 'p.lender_id = lender.id', 'left');
            $this->db->join('pct_softpro_lookup_table as escrow', 'p.escrow_id = escrow.id', 'left');
            $this->db->where('o.file_number', $response['OrderNumber']);
            $filesResult = $this->db->get()->row_array();
            $fileNumber = $response['OrderNumber'];
            $from        = env('TWILIO_FROM');
            // echo "<pre>";
            // print_r($filesResult);die;
            if (!empty($filesResult) && !empty($filesResult['phone'])) {
            // if (!empty($filesResult)) {
                if ($taskId == '03-020' && $filesResult['notify_recording_confirm'] == 0) {
                // if (false) {
                    $twilio['message'] = $reqData;
                    $twilio['sent_from'] = $from;
                    $twilio['status'] = $status = 'error';
                    $twilio['error_message'] = $resMsg = $res = "Sales Rep has disabled recording confirmation notification.";
                    $this->apiLogs->syncLogs($userdata['id'], 'softpro', 'received_milestone_request', 'received_milestone_request', $reqData, $res, 0, $logid);
                    // echo $res; exit;
                } else if ($taskId == '04-035' && $filesResult['notify_disburse_funds'] == 0) {
                // } else if (false) {
                    $twilio['message'] = $reqData;
                    $twilio['sent_from'] = $from;
                    $twilio['status'] = $status = 'error';
                    $twilio['error_message'] = $resMsg = $res = "Sales Rep has disabled Disburse Funds notification.";
                    $this->apiLogs->syncLogs($userdata['id'], 'softpro', 'received_milestone_request', 'received_milestone_request', $reqData, $res, 0, $logid);
                    // echo $res; exit; 
                } else {
                    $this->load->library('order/twilio');
                    $this->load->library('order/common');
                    $orderId = $filesResult['id'];
                    $file_number = $response['OrderNumber'];
                    // $phoneNumber = "2133097286"; //$filesResult['phone'];
                    $phoneNumber = $filesResult['phone'];
                    $phoneNumber = preg_replace('/\D/', '', $phoneNumber);
                    $propertyAddress = $filesResult['full_address'];
                    $filesResult['timestamp'] = $timestamp = $this->common->convertTimezone(date('Y-m-d H:i:s'), 'g:ia m/d/Y','America/Los_Angeles');
                    
                    $message = "";
                    if ($taskId == '03-020') {
                        // $message = "Hi " . $filesResult['first_name'] . " " . $filesResult['last_name'] . ", \n i. Recording Confirmation: " . $file_number . " \n ii. Property Address: " . $filesResult['full_address'] . " \n iii. @ " . $timestamp;
                        $message = "Hi {$filesResult['first_name']} {$filesResult['last_name']},\n"
                        . "i. Recording Confirmation: {$file_number}\n"
                        . "ii. Property Address: {$filesResult['full_address']}\n"
                        . "iii. @ {$timestamp}";
                    } 

                    if ($taskId == '04-035') {
                        // $message = "Hi " . $filesResult['first_name'] . " " . $filesResult['last_name'] . ", \n i. Disbursement Completed: " . $file_number . " \n ii. Property Address: " . $filesResult['full_address'] . " \n iii. @ " . $timestamp;
                        $message = "Hi {$filesResult['first_name']} {$filesResult['last_name']},\n"
                            . "i. Disbursement Completed: {$file_number}\n"
                            . "ii. Property Address: {$filesResult['full_address']}\n"
                            . "iii. @ {$timestamp}";
                    }
                    // echo "<pre>";
                    // print_r($message);die;
                    $sid         = env('TWILIO_SID');
                    $token       = env('TWILIO_TOKEN');
                    
                    $data        = [
                        'message'     => $message,
                        'account_sid' => $sid,
                        'token'       => $token,
                        'to'          => $phoneNumber,
                        'from'        => $from,
                    ];

                    $logid = $this->apiLogs->syncLogs(0, 'twilio', 'twilio_send_message', 'twilio_send_message', $data, [], 0, 0);

                    try {
                        $result = $this->twilio->message($phoneNumber, $message, '', array('from' => $from));
                        $res = $result->toArray();
                        $res['msg_status'] = 'success';
                    } catch (\Twilio\Exceptions\RestException $e) {
                        $res['msg_status'] = 'error';
                        $res['errorCode'] = $e->getCode();
                        $res['errorMessage'] = $resMsg = $e->getMessage();
                    } catch (Exception $e) {
                        $res['msg_status'] = 'error';
                        $res['errorCode'] = $e->getCode();
                        $res['errorMessage'] = $resMsg = $e->getMessage();
                    }

                    // echo "<pre>";
                    // print_r($res);
                    $this->apiLogs->syncLogs(0, 'twilio', 'twilio_send_message', 'twilio_send_message', $data, $res, 0, $logid);
                    $twilio['message'] = $resMsg = $res['body'] ?? $message;
                    $twilio['sent_from'] = $res['from'] ?? $from;
                    $twilio['sent_to'] = $res['to'] ?? $phoneNumber;
                    $twilio['status'] = $status = $res['msg_status'];
                    $twilio['message_sid'] = $res['sid'] ?? $sid;
                    $twilio['error_code'] = $res['errorCode'];
                    $twilio['error_message'] = $res['errorMessage'];
                }    
            } else {
                $twilio['message'] = $message;
                $twilio['sent_from'] = $from;
                $twilio['status'] = $status = 'error';
                $twilio['error_message'] = $resMsg = "Order number not exist or Sales rep phone number not linked.";
                $this->apiLogs->syncLogs($userdata['id'], 'softpro', 'received_milestone_request', 'received_milestone_request', $reqData, $resMsg, 0, $logid);
            }
            
            if ($taskId == '03-020' && ($filesResult['lender_notify_recording_confirm'] == 1 || $filesResult['escrow_notify_recording_confirm'] == 1)) {
                $this->order->sendRecordingConfirmationEmail($filesResult, 'recording_confirmation');
            }
            
            if ($taskId == '04-035' && ($filesResult['lender_notify_disburse_funds'] == 1 || $filesResult['escrow_notify_disburse_funds'] == 1)) {
                // $this->order->sendRecordingConfirmationEmail($filesResult, 'disburse_funds');
            }
            
        } else {
            $twilio['message'] = $reqData;
            $twilio['sent_from'] = $from;
            $twilio['status'] = $status = 'error';
            $twilio['error_message'] = $resMsg = "Invalid request or order number not found.";
            $this->apiLogs->syncLogs($userdata['id'], 'softpro', 'received_milestone_request', 'received_milestone_request', $reqData, $resMsg, 0, $logid);
        }
        $this->twilioMessage->insert($twilio);
        $res = json_encode(['status' => $status, 'message' => $resMsg]);
        echo $res;exit;
        
    }

    public function updateOrderOfficers() {
        $this->db->select('order_details.id, file_number, t.title_officer, transaction_id, escrow_officer_id');
        $this->db->from('order_details');
        $this->db->join('transaction_details as t', 'order_details.transaction_id = t.id', 'left');
        $this->db->where('is_softpro_order', 1);
        $this->db->where('t.title_officer is not null');
        $this->db->order_by('order_details.id', 'DESC');
        $orderList = $this->db->get()->result_array();
        $titleOfficerMapping = [
            5 => 14415, //'Clive Virata'
            6 => 14416, // 'Eddie LasMarias'
            7 => 14417, // 'Jim Jean' 
            8 => 14418, // 'Kevin Cameron'
            9 => 0,
            10 => 14419, // 'Rachel Barcena'
            11 => 14420 // 'Susan Dana'
        ];
        $count=0;
        foreach ($orderList as $key => $list) {
            $file_number = $list['file_number'];
            $transactionId = $list['transaction_id'];
            $titleOfficerId = $list['title_officer'];
            
            if (array_key_exists($titleOfficerId, $titleOfficerMapping)) {
                $updateData = [
                    'title_officer' => $titleOfficerMapping[$titleOfficerId],
                ];
                $condition = [
                    'id' => $transactionId
                ];
                $this->home_model->update($updateData, $condition, 'transaction_details');
                // echo "<pre>";
                // print_r($updateData);
                // print_r($list);die;
                $count++;
            } else {
                // echo "Transaction ID not found for file number: " . $file_number;die;
            }
        }
        $res = json_encode(['updated' => $count]);
        print_r($res);die;
    }

    public function createFeesPdf() {
        $this->order->generateFeesEstimationPdf(153367);
    }

    public function borrowerEmailAutomation() {
        $this->load->model('order/apiLogs');
        $reqData     = file_get_contents("php://input");
        // $reqData = '{"Status":200,"Message":"Success","OrderNumber":"TEST-20001146-GLT","Id":null,"FileUploadedStatus":true,"data":{"Requirements":[{"description":"A Statement of Information is needed from all parties involved. This statement is crucial for completing the title search and helps identify and eliminate confusion related to names. The information will remain confidential."}],"Liens":[{"description":"None recorded"}],"Easements":[{"description":"None recorded"}],"Exceptions":[{"description":"Property taxes that are not yet due for the fiscal year 2025-2026. Tax Identification No.: 6144-019-015"},{"description":"Property taxes for the fiscal year 2024-2025 are paid. Tax Identification No.: 6144-019-015, 1st Installment: $4,445.62, 2nd Installment: $4,445.62, Exemption: $0.00, Land Value: $271,804.00, Improvements Value: $118,473.00, Personal Property Value: $0.00, Code Area: 11252"},{"description":"Liens or assessments from local projects or special districts."},{"description":"Supplemental taxes according to California law."},{"description":"Water rights or claims to water."},{"description":"Easements:\nSingle channel easement for Compton Creek (Recorded: March 3, 1923).\nUtility easement (Unlocated, Book 3208, Page 173).\nPublic street easement affecting the southerly 25 feet of specific lots (Book 3208, Page 1)."},{"description":"Deed of Trust to secure a loan of $296,250.00.\nTrustor/Grantor: Iris Yolanda Martinez\nTrustee: Fidelity National Title\nBeneficiary: Metwest Commercial Lender, Inc.\nRecording Date: June 29, 2007"},{"description":"Assignment of rental moneys for additional security.\nAssigned to: Bayview Loan Servicing LLC\nRecording Date: February 26, 2008"},{"description":"Assignment of beneficial interest under the deed of trust.\nAssignee: Bayview Loan Servicing LLC\nLoan No.: 214228
        $from = date('Y-m-d 00:00:00', strtotime('-1 day'));
        $to   = date('Y-m-d 23:59:59', strtotime('-1 day'));
        // echo "From: $from, To: $to";die;
        
        // $orders = $this->db->get('order_details')->result_array();
        $params = [
            'order_details.created_at >=' => $from,
            'order_details.created_at <=' => $to,
        ];
        $orderDetails = $this->order->get_all_order_details($params);

        // echo "<pre>";
        // print_r($orderDetails);die;
        foreach ($orderDetails as $order) {
            $file_number = $order['file_number'];
            $borrower_email = 'ghernandez@pct.com';
            $cc = array('piyush.j@crestinfosystems.com');
            $package_type = (strtolower($order['prod_type']) == 'refinance') ? 'buyer' : 'seller';
            
            $escrowOffCond = array(
                'where' => array(
                    'id' => $order['escrow_officer_id'],
                ),
            );

            $escrowOffDetails = $this->order->get_rows($escrowOffCond, 'pct_softpro_lookup_table');
            $from_name = 'Pacific Coast Title Company';
            $from_mail = env('FROM_EMAIL');
            $order_id = $order['order_id'];
            $this->home_model->update(array('borrower_email' => $borrower_email), array('id' => $order_id), 'order_details');
            
            if ($package_type == 'seller') {
                $form_url = base_url().'seller-info/'.$order['random_number'];
                $subject = $order['file_number']. ' - Seller: Required Info Needed';
            } else {
                $form_url = base_url().'buyer-info/'.$order['random_number'];
                $subject = $order['file_number']. ' - Buyer: Required Info Needed';
            }
            
            $email_data = array(
                'file_number'=> $order['file_number'],
                'property_address'=> $order['full_address'],
                'random_number'=>  $order['random_number'],
                'borrrower'=> $order['primary_owner'],
                'form_url' => $form_url,
                'escrow_officer' => (!empty($$escrowOffDetails)) ? $escrowOffDetails['officer_name'] : '',
                'is_seller_flag' => $package_type == 'seller' ? 1 : 0
            );
            
            if ($package_type == 'seller') {
                $borrower_message_body = $this->load->view('emails/borrower_seller.php', $email_data, TRUE);
            } else {
                $borrower_message_body = $this->load->view('emails/borrower_buyer.php', $email_data, TRUE);
            }
            $message_body = $borrower_message_body;
            
            $mailParams = array(
                'from_mail' => $from_mail, 
                'from_name' => $from_name, 
                'subject' => $subject,
                'message'=>json_encode($email_data)
            );
            
            if (!empty($borrower_email)) {
                $to = $borrower_email;
                $mailParams['to'] = $to;
                $this->load->helper('sendemail');
                $logid = $this->apiLogs->syncLogs(0, 'sendgrid', 'send_mail_to_borrower', 'send_mail_to_borrower', $mailParams, array(), $order_id, 0);
                $borrower_mail_result = send_email($from_mail,$from_name, $to, $subject, $message_body,[], $cc, []);
                $this->apiLogs->syncLogs(0, 'sendgrid', 'send_mail_to_borrower', 'send_mail_to_borrower', $mailParams, array('status'=>$borrower_mail_result), $order_id, $logid);
            }
        }
        
        // $params = [
        //     'order_details.file_number' => $file_number,
        // ];
        // $orderDetails = $this->order->get_order_details($params);
        
    }  
    
    public function automatePrelimSummary() {
        $this->load->library('order/softPro');
        $this->load->model('order/apiLogs');
        $this->db->select('id, file_number, chatgpt_json, resware_json');
        $this->db->from('pct_order_prelim_summary');
        $this->db->where('chatgpt_json is null');
        $this->db->order_by('id', 'desc');
        $query = $this->db->get();
        // echo $this->CI->db->last_query();exit;
        $prelimData = $query->result_array();
        // echo "<pre>";
        // print_r($prelimData);die;
        foreach($prelimData as $key => $value) {
            $fileNumber = $value['file_number'];
            if (empty($value['resware_json'])) {
                $apiEndPoints = SOFTPRO_API_END;
                $req['orderNumber'] = $fileNumber;
                
                $queryParams = http_build_query($req);
                $reqData     = json_encode($req);
                $reqUrl  = getenv("SOFT_PRO_API") . $apiEndPoints['get_prelim_summary'] . '?'.$queryParams;
                
                $logid = $this->apiLogs->syncLogs($userdata['id'], 'softpro', 'get_prelim_summary', $reqUrl, $reqData, [], 0, 0);
                $response    = $this->softpro->make_request('GET', 'get_prelim_summary', $reqData, $queryParams);
                $this->apiLogs->syncLogs($userdata['id'], 'softpro', 'get_prelim_summary', 'get_prelim_summary', $reqData, json_encode($response), 0, $logid);
                if (!empty($response) && $response['status'] == 'success') {
                    $prelimSummaryJson = $response['data'];
                    // print_r($prelimSummaryJson);die;
                    $prelimData = array(
                        'resware_json' => json_encode($prelimSummaryJson)
                    );
                    $condition = [
                        // 'file_number' => '20001146-GLT' //$response['OrderNumber'],
                        'file_number' => $fileNumber,
                    ];
                    $this->db->set($prelimData);
                    $this->db->where($condition);
                    $this->db->update('pct_order_prelim_summary');

                }
            }
            $prelimSummaryJson = json_decode($value['resware_json'], true);
            
            $chatGptJsonRes = $this->order->getPrelimAISummary($prelimSummaryJson);

            $chatGptRes    = json_decode($chatGptJsonRes, true);
            $prelimData = array(
                'chatgpt_json' => $chatGptJsonRes
            );
            $condition = [
                'file_number' => $fileNumber,
            ];
            $this->db->set($prelimData);
            $this->db->where($condition);
            $this->db->update('pct_order_prelim_summary');
            // echo "<pre>";
            // print_r($value);die;
        }
        
    }

    public function updatePrelimSummaryId() {
        $this->load->library('order/softPro');
        $this->load->model('order/apiLogs');
        $this->db->select('o.id, o.file_number, o.prelim_summary_id, p.id as p_id');
        $this->db->from('pct_order_prelim_summary as p');
        $this->db->join('order_details as o', 'o.file_number = p.file_number');
        $this->db->where('o.prelim_summary_id', 0);
        $this->db->order_by('id', 'desc');
        $query = $this->db->get();
        // echo $this->CI->db->last_query();exit;
        $prelimData = $query->result_array();
        // echo "<pre>";
        // print_r($prelimData);die;
        foreach($prelimData as $key => $value) {
            $fileNumber = $value['file_number'];
            // if ($fileNumber != '20005171-GLT') { 
            //     continue;
            // }
            $orderData = array(
                'prelim_summary_id' => $value['p_id'],
                'updated_at' => date('Y-m-d H:i:s')
            );
            $condition = [
                'file_number' => $fileNumber,
            ];
            $this->db->set($orderData);
            $this->db->where($condition);
            $this->db->update('order_details');
            // echo "<pre>";
            // print_r($value);die;
        }
        
    }

    public function updatePrelimDocument() {
        ini_set('max_execution_time', 0);
        ini_set('memory_limit', '2048M');
        $this->load->library('order/softPro');
        $this->load->model('order/apiLogs');
        $this->db->select('o.id, o.customer_id, o.file_number, o.prelim_summary_id');
        $this->db->from('order_details as o');
        $this->db->join('pct_order_documents as d', 'd.order_id = o.id AND d.is_prelim_document = 1', 'left');
        $this->db->where('o.prelim_summary_id !=', 0);
        $this->db->where('d.id IS NULL', null, false); // Raw condition for NULL check
        $this->db->order_by('o.id', 'DESC');
        $query = $this->db->get();
        // echo $this->db->last_query();exit;
        $prelimData = $query->result_array();
        // echo "<pre>";
        // print_r($prelimData);die;
        $count = 0;
        foreach($prelimData as $key => $value) {
            $fileNumber = $value['file_number'];
            $req['orderNumber'] = $fileNumber;
            $req['isAutomationCall'] = false;
            
            echo "<pre>";
            print_r($value);
            
            $queryParams = http_build_query($req);
            $reqData     = json_encode($req);
            $logid = $this->apiLogs->syncLogs($userdata['id'], 'softpro', 'get_single_prelim_report', 'get_single_prelim_report', $reqData, [], 0, 0);
            $response    = $this->softpro->make_request('GET', 'get_single_prelim_report', $reqData, $queryParams);
            $this->apiLogs->syncLogs($userdata['id'], 'softpro', 'get_single_prelim_report', 'get_single_prelim_report', $reqData, json_encode($response), 0, $logid);
            
            print_r($response);
            
            if (!empty($response) && $response['status'] == 'success') {
            
                $this->db->select('id, o.order_id');
                $this->db->from('pct_order_documents as o');
                $this->db->where('is_prelim_document', 1);
                $this->db->where('order_id', $value['id']);
                $documentData = $this->db->get()->row_array();
                print_r($documentData);
                // $this->db->select('*');
                // $this->db->from('pct_order_prelim_summary as s');
                // $this->db->where('file_number', $response['OrderNumber']);
                // $prelimSummaryDetails = $this->db->get()->row_array();

                if (!empty($response['data'])) {
                    $file_number = $response['OrderNumber'];
                    $prelimLink = $response['data'][0];
                    $prelimFetchedCount++;
                    $documentName = basename($prelimLink);
                    $document_name = time() . "_prelim_doc_" . $file_number . '.pdf';
                    $uploadStatus = $this->order->uploadDocumentUsingLinkOnAwsS3($prelimLink, $document_name, 'documents');

                    if ($uploadStatus) {
                        $this->load->model('order/document');
                        $documentData = array(
                            'document_name' => $document_name,
                            'original_document_name' => urldecode($documentName),
                            'user_id' => $value['customer_id'],
                            'order_id' => $value['id'],
                            'description' => $documentName,
                            'created' => date('Y-m-d H:i:s'),
                            'is_sync' => 1,
                            'is_prelim_document' => 1,
                        );
                        $documentId = $this->document->insert($documentData);
                        $count++;
                        // print_r($documentId);die;
                        // $summaryData = [
                        //     'file_number' => $filesResult['file_number'],
                        //     'created_at' => date('Y-m-d H:i:s'),
                        // ];
                        // $id = $this->db->insert('pct_order_prelim_summary', $summaryData);
                        // $condition = array(
                        //     'id' => $filesResult['id'],
                        // );
                        // $data = array(
                        //     'prelim_summary_id' => $id,
                        // );
                        // $this->order->update($data, $condition);

                        $res = json_encode(['prelim inserted' => 1, 'orders_inserted' => $file_number]);

                    }
                } else {
                    $res = "Prelim summury details not exist for order number: " . $req['orderNumber'];
                }
            } else {
                $res = json_encode($response);
            }

            /** Cron log start */
            $apiEndPoints = SOFTPRO_API_END;
            $url          = getenv("SOFT_PRO_API") . $apiEndPoints['get_single_prelim_report'] . '?' . $queryParams;
            $this->order->syncLogs('softpro', 'get_single_prelim_report', $url, $reqData, $res, 0, 0);
            /** Cron log end */

        }
        echo json_encode(['status' => 'success','message' => $count . ' Orders prelim document updated successfully']);
        
    }

    public function recallFailedAPI() {
        
        $records = $this->db->select('id, request_type, request_url, request_data')
                            ->from('pct_failed_api_logs')
                            ->where('status', 0)
                            ->limit(20)
                            ->order_by('id', 'asc')
                            // ->group_by('order_number')
                            ->get()->result_array();
        if (!empty($records)) {
            foreach ($records as $key => $value) {
                $this->load->library('order/softPro');
                $logid = $this->apiLogs->syncLogs($userdata['id'], 'softpro', $value['request_type'], $value['request_url'], $value['request_data'], [], 0, 0);
                $result = $this->softpro->make_request('POST', $value['request_type'], $value['request_data']);
                $response = json_decode($result, true);
                $this->apiLogs->syncLogs($userdata['id'], 'softpro', $value['request_type'], $value['request_url'], $value['request_data'], json_encode($response), 0, $logid);
                
                if (isset($response) && !empty($response)) {
                    foreach ($response as $key => $res) {
                        if ($response[0]['Status'] == 200) {
                            $this->db->where('id', $value['id']);
                            $this->db->update('pct_failed_api_logs', ['status' => 1]);
                        }
                    }
                }
            }
        }
    
    }

    public function generateAndSendReport()
    {
        $today = date('Y-m-d');
        $dayOfWeek = date('N'); // 1=Monday, 7=Sunday
        
        // Determine date range based on day of week
        if ($dayOfWeek == 2) { // Wednesday
            $startDate = date('Y-m-d', strtotime('last friday'));
            $endDate = date('Y-m-d'); // Today (Tuesday)
            $reportName = 'Fri-Tuesday Orders Report';
        } elseif ($dayOfWeek == 4) { // Thursday
            $startDate = date('Y-m-d', strtotime('last wednesday'));
            $endDate = date('Y-m-d'); // Today (Thursday)
            $reportName = 'Wed-Thursday Orders Report';
        } else {
            echo "Today is not Tuesday or Thursday. No report generated.";
            return;
        }
        // echo $startDate . " to " . $endDate . "<br>";die;
        // Get closed orders within date range
        $orders = $this->getClosedOrders($startDate, $endDate);
        // echo "<pre>";
        // print_r($orders);die;
        if (empty($orders)) {
            echo "No closed orders found for the period.";
            return;
        }

        // Generate CSV
        $csvPath = $this->generateCSV($orders, $reportName);
        
        // Send email
        $this->sendEmail($csvPath, $reportName, $startDate, $endDate);
        
        echo "Report generated and sent successfully.";
    }

    private function getClosedOrders($startDate, $endDate)
    {
        $this->db->select('
            DATE(o.sent_to_accounting_date) as transaction_date,
            o.softpro_status,
            o.file_number as order_number,
            CONCAT(p.address, ", ", p.city, ", ", p.state) as property_address,
            p.address,
            p.city,
            p.state,
            p.zip,
            CONCAT(u.first_name, " ", u.last_name) as sales_rep
        ');
        $this->db->from('order_details o');
        $this->db->join('property_details p', 'o.property_id = p.id', 'left');
        $this->db->join('transaction_details t', 'o.transaction_id = t.id', 'left');
        $this->db->join('pct_softpro_lookup_table u', 't.sales_representative = u.id', 'left');
        // $this->db->where('o.softpro_status', 'closed');
        // $this->db->where('o.is_imported', 1);
        $this->db->where('DATE(o.sent_to_accounting_date) >=', $startDate);
        $this->db->where('DATE(o.sent_to_accounting_date) <=', $endDate);
        $this->db->order_by('o.sent_to_accounting_date', 'Desc');
        
        return $this->db->get()->result_array();
    }

    private function generateCSV($orders, $reportName)
    {
        $filename = $reportName . '_' . date('Ymd') . '.csv';
        $filepath = FCPATH . 'uploads/reports/' . $filename;
        
        // Create directory if not exists
        if (!is_dir(FCPATH . 'uploads/reports')) {
            mkdir(FCPATH . 'uploads/reports', 0777, true);
        }
        
        $file = fopen($filepath, 'w');
        
        // Add CSV headers
        fputcsv($file, [
            'Transaction Date',
            'Order Number',
            'Property Address',
            'City',
            'State',
            'Zip',
            'Sales Rep'
        ]);
        // echo "<pre>";
        // print_r($orders);die;
        // Add order data
        foreach ($orders as $order) {
            fputcsv($file, [
                convertTimezone($order['transaction_date'], 'm/d/Y'),
                $order['order_number'],
                $order['address'] . ", " . $order['city'] . ", " . $order['state'] . ", " . $order['zip'],
                $order['city'],
                $order['state'],
                $order['zip'],
                $order['sales_rep']
            ]);
        }
        
        fclose($file);
        
        return $filepath;
    }

    private function sendEmail($csvPath, $reportName, $startDate, $endDate)
    {
        $from_name = 'Pacific Coast Title Company';
        $from_mail = env('FROM_EMAIL');
        $to = 'shuklap871@gmail.com';
        $cc = ['piyush.j@crestinfosystems.com', 'ghernandez@pct.com'];
        // $to = 'piyush.j@crestinfosystems.com';
        // $cc = ['piyush.j@crestinfosystems.com'];
        $subject = 'Weekly closed order report ' . ' (' . date('M j, Y') . ')';
        
        $data['startDate'] = $startDate;
        $data['endDate'] = $endDate;

        $message    = $this->load->view('emails/weekly_completed_order.php', $data, true);
        
        $mailParams = [
            'from_mail' => $from_mail,
            'from_name' => $from_name,
            'to' => $to,
            'cc' => $cc,
            'subject' => $subject,
            'message' => $message,
            'attachment' => $csvPath
        ];
        
        $this->load->helper('sendemail');
        $logid = $this->apiLogs->syncLogs(0, 'weekly_order_report', 'send_email', '', $mailParams, [], 0, 0);
        // $result = send_email($from_mail, $from_name, $to, $subject, $message, [], [], [$csvPath]);
        $result = send_email($from_mail, $from_name, $to, $subject, $message, [$csvPath], $cc, []);
        $this->apiLogs->syncLogs(0, 'weekly_order_report', 'send_email', '', $mailParams, ['status' => $result], 0, $logid);
        
        // Delete CSV after sending
        if (file_exists($csvPath)) {
            unlink($csvPath);
        }
    }

    public function sendSurvayEmail($data) {
        if (!empty($data['title_officer_email'])) {
            $data['title_officer_email'] = strtolower($data['title_officer_email']);
            if ($data['title_officer_email'] == 'unit66@pct.com') { 
                $data['survey_link'] = 'https://www.surveymonkey.com/r/KR5G38W?order_id=' . $data['order_id']; // Clive - 143260
            } else if ($data['title_officer_email'] == 'jjean@pct.com') {
                $data['survey_link'] = 'https://www.surveymonkey.com/r/P3X7KX8?order_id=' . $data['order_id']; // Jim
            } else if ($data['title_officer_email'] == 'unit33@pct.com') {
                $data['survey_link'] = 'https://www.surveymonkey.com/r/PG7SJRG?order_id=' . $data['order_id']; // Eddie
            } else if ($data['title_officer_email'] == 'unit88@pct.com') {
                $data['survey_link'] = 'https://www.surveymonkey.com/r/6BJZ79Y?order_id=' . $data['order_id']; // Rachel
            } else {
                exit;
            }
        }
        $message = $this->load->view('emails/surveymonkey_email.php', $data, true);
        $from_name = 'Pacific Coast Title Company';
        $from_mail = env('FROM_EMAIL');
        // $subject = 'Thank You!';
        // $to = 'piyush-crest@yopmail.com';
        $to = $data['escrow_officer_email'];

        // $to = array('piyush.j@crestinfosystems.com', 'ghernandez@pct.com');
        $cc = array('piyush.j@crestinfosystems.com');

        $from_name = 'Pacific Coast Title Company';
        $from_mail = env('FROM_EMAIL');
        $subject = "We'd Love Your Feedback";
        // $to = $escrow_email_address;
        // $cc = array('piyush.j@crestinfosystems.com', $sales_email);
        // $cc = array('piyush.j@crestinfosystems.com');
        $mailParams = array(
            'from_mail' => $from_mail,
            'from_name' => $from_name,
            'to' => $to,
            'subject' => $subject,
            'message' => json_encode($data),
            'cc' => $cc,
        );
        // $to = ['piyush.j@crestinfosystems.net', 'ghernandez@pct.com'];
        // $cc = array();
        $this->load->helper('sendemail');
        $logid = $this->apiLogs->syncLogs(0, 'sendgrid', 'survay_email_sent_mail_to_escrow_officer', '', $mailParams, array(), $data['order_id'], 0);
        $mail_result = send_email($from_mail, $from_name, $to, $subject, $message, array(), $cc);
        $this->apiLogs->syncLogs(0, 'sendgrid', 'survay_email_sent_mail_to_escrow_officer', '', $mailParams, array('status' => $mail_result), $data['orderId'], $logid);
        echo "Survay Mails sent successfully for Order Number : " . $data['file_number'] . " To: " . implode(', ', $to) . "And In CC : " . implode(', ', $cc) . "<br/>";
    }

    public function sendQueuedEmail() {
        $this->db->from('pct_email_queue');
        $this->db->where('status', 0);
        
        $query  = $this->db->get();
        $result = $query->result_array();
        
        foreach ($result as $order) {
            $closedFileNumbers[] = $order['file_number'];
            $this->sendEmailForClosedOrder($closedFileNumbers);
            $updateData = ['status' => 1];

            $this->db->set($updateData);
            $this->db->where('file_number', $order['file_number']);
            $this->db->update('pct_email_queue');

        }
    }
}
