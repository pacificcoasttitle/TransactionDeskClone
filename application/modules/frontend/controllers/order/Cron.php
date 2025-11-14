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
        $closedFileNumbers = [];
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
                            $updateArray['order_completed_date'] = $completed_date;
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
        // $enableSurveyEmailFlag = $configData['enable_survey_email']['is_enable'];
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

                    $cc = ['ghernandez@pct.com', $sales_email, 'piyush.j@crestinfosystems.com'];

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
                
                // if (($enableSurveyEmailFlag == 1) && !empty($res['escrow_officer_email'])) {
                //     $this->sendSurvayEmail($res);
                // }

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
        $logid = $this->apiLogs->syncLogs(0, 'softpro', 'fetch_lookup_code', 'fetch_lookup_code', $reqData, [], 0, 0);
        $response = $this->softpro->make_request('GET', 'fetch_lookup_code', $reqData, $queryParams);
        $this->apiLogs->syncLogs(0, 'softpro', 'fetch_lookup_code', 'fetch_lookup_code', $reqData, json_encode($response), 0, $logid);
        
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
                        $update_data[$key]['courtesy_title'] = $row['CourtesyTitle'] ?? '';
                        $update_data[$key]['first_name']     = $row['FirstName'] ?? '';
                        $update_data[$key]['middle_name']    = $row['MiddleName'] ?? '';
                        $update_data[$key]['last_name']      = $row['LastName'] ?? '';
                        $update_data[$key]['email_address']  = trim($row['Email']);
                        $update_data[$key]['phone']          = $row['Phone'] ?? '';
                        $update_data[$key]['phone_ext']      = $row['PhoneExt'] ?? '';
                        $update_data[$key]['suffix']         = $row['Suffix'] ?? '';
                        $update_data[$key]['title']          = $row['Title'] ?? '';
                        $update_data[$key]['fax']            = $row['Fax'] ?? '';
                        $update_data[$key]['cell']           = $row['Cell'] ?? '';
                        $update_data[$key]['pager']          = $row['Pager'] ?? '';
                        $update_data[$key]['gender_id']      = $row['GenderID'] ?? '';
                        $update_data[$key]['address1']       = $row['Address1'] ?? '';
                        $update_data[$key]['address2']       = $row['Address2'] ?? '';
                        $update_data[$key]['city']           = $row['City'] ?? '';
                        $update_data[$key]['state']          = $row['State'] ?? '';
                        $update_data[$key]['zip']            = $row['Zip'] ?? '';
                        $update_data[$key]['note']           = $row['Note'] ?? '';
                        $update_data[$key]['license_no']     = $row['License No'] ?? '';
                        $update_data[$key]['status']         = 1;
                        // $update_data[$key]['user_type'] = 'open_contact';
                    } else {
                        $insert_data[$key]['lookup_code']    = trim($row['LookupCode']);
                        $insert_data[$key]['flookup_code']   = $row['Filter: LookupCode'];
                        $insert_data[$key]['courtesy_title'] = $row['CourtesyTitle'] ?? '';
                        $insert_data[$key]['first_name']     = $row['FirstName'] ?? '';
                        $insert_data[$key]['middle_name']    = $row['MiddleName'] ?? '';
                        $insert_data[$key]['last_name']      = $row['LastName'] ?? '';
                        $insert_data[$key]['email_address']  = trim($row['Email']);
                        $insert_data[$key]['phone']          = $row['Phone'] ?? '';
                        $insert_data[$key]['phone_ext']      = $row['PhoneExt'] ?? '';
                        $insert_data[$key]['suffix']         = $row['Suffix'] ?? '';
                        $insert_data[$key]['title']          = $row['Title'] ?? '';
                        $insert_data[$key]['fax']            = $row['Fax'] ?? '';
                        $insert_data[$key]['cell']           = $row['Cell'] ?? '';
                        $insert_data[$key]['pager']          = $row['Pager'] ?? '';
                        $insert_data[$key]['gender_id']      = $row['GenderID'] ?? '';
                        $insert_data[$key]['address1']       = $row['Address1'] ?? '';
                        $insert_data[$key]['address2']       = $row['Address2'] ?? '';
                        $insert_data[$key]['city']           = $row['City'] ?? '';
                        $insert_data[$key]['state']          = $row['State'] ?? '';
                        $insert_data[$key]['zip']            = $row['Zip'] ?? '';
                        $insert_data[$key]['note']           = $row['Note'] ?? '';
                        $insert_data[$key]['license_no']     = $row['License No'] ?? '';
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
                    $company_update_data[$key]['payee_name']        = $row['Payee Name'] ?? '';
                    $company_update_data[$key]['address1']          = $row['Address (line 1)'] ?? '';
                    $company_update_data[$key]['address2']          = $row['Address (line 2)']  ?? '';
                    $company_update_data[$key]['city']              = $row['City'] ?? '';
                    $company_update_data[$key]['state']             = $row['State'] ?? '';
                    $company_update_data[$key]['zip']               = $row['Zip'] ?? '';
                    $company_update_data[$key]['phone']             = $row['Phone'] ?? '';
                    $company_update_data[$key]['fax']               = $row['Fax'] ?? '';
                    $company_update_data[$key]['email_address']     = $row['Email'];
                    // $update_data[$key]['user_type']         = 'escrow_company';

                    $company_update_data[$key]['signature_line']         = $row['Signature Line'] ?? '';
                    $company_update_data[$key]['fee_transfer_ledger']    = $row['Fee Transfer Ledger'] ?? '';
                    $company_update_data[$key]['state_of_incorporation'] = $row['State Of Incorporation'] ?? '';
                    $company_update_data[$key]['marketing_rep']          = $row['Marketing Rep'] ?? '';
                    $company_update_data[$key]['special_instructions']   = $row['Special Instructions'] ?? '';
                    // $company_update_data[$key]['row_state']              = $row['Row State'];
                } else {
                    $company_insert_data[$key]['lookup_code']       = $row['Lookup Code'];
                    $company_insert_data[$key]['name']              = $row['Name'];
                    $company_insert_data[$key]['is_escrow_company'] = 1;
                    $company_insert_data[$key]['payee_name']        = $row['Payee Name'] ?? '';
                    $company_insert_data[$key]['address1']          = $row['Address (line 1)'] ?? '';
                    $company_insert_data[$key]['address2']          = $row['Address (line 2)'] ?? '';
                    $company_insert_data[$key]['city']              = $row['City'] ?? '';
                    $company_insert_data[$key]['state']             = $row['State'] ?? '';
                    $company_insert_data[$key]['zip']               = $row['Zip'] ?? '';
                    $company_insert_data[$key]['phone']             = $row['Phone'] ?? '';
                    $company_insert_data[$key]['fax']               = $row['Fax'] ?? '';
                    $company_insert_data[$key]['email_address']     = $row['Email'];
                    // $company_insert_data[$key]['user_type'] = 'escrow_company';

                    $company_insert_data[$key]['signature_line']         = $row['Signature Line'] ?? '';
                    $company_insert_data[$key]['fee_transfer_ledger']    = $row['Fee Transfer Ledger'] ?? '';
                    $company_insert_data[$key]['state_of_incorporation'] = $row['State Of Incorporation'] ?? '';
                    $company_insert_data[$key]['marketing_rep']          = $row['Marketing Rep'] ?? '';
                    $company_insert_data[$key]['special_instructions']   = $row['Special Instructions'] ?? '';
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
                    $company_update_data[$key]['payee_name']    = $row['PayeeName'] ?? '';
                    $company_update_data[$key]['address1']      = $row['Address1'] ?? '';
                    $company_update_data[$key]['address2']      = $row['Address2'] ?? '';
                    $company_update_data[$key]['city']          = $row['City'] ?? '';
                    $company_update_data[$key]['state']         = $row['State'] ?? '';
                    $company_update_data[$key]['zip']           = $row['Zip'] ?? '';
                    $company_update_data[$key]['phone']         = $row['Phone'] ?? '';
                    $company_update_data[$key]['fax']           = $row['Fax'] ?? '';
                    $company_update_data[$key]['email_address'] = $row['Email'];

                    $company_update_data[$key]['legal_name']             = $row['LegalName'] ?? '';
                    $company_update_data[$key]['fee_transfer_ledger']    = $row['FeeTransferLedger'] ?? '';
                    $company_update_data[$key]['state_of_incorporation'] = $row['StateOfIncorporation'] ?? '';
                    $company_update_data[$key]['marketing_rep']          = $row['MarketingRep'] ?? '';
                    $company_update_data[$key]['funding_address1']       = $row['FundingAddress1'] ?? '';
                    $company_update_data[$key]['funding_address2']       = $row['FundingAddress2'] ?? '';
                    $company_update_data[$key]['funding_city']           = $row['FundingCity'] ?? '';
                    $company_update_data[$key]['funding_state']          = $row['FundingState'] ?? '';
                    $company_update_data[$key]['funding_zip']            = $row['FundingZip'] ?? '';
                    $company_update_data[$key]['funding_phone']          = $row['FundingPhone'] ?? '';
                    $company_update_data[$key]['funding_fax']            = $row['FundingFax'] ?? '';
                    $company_update_data[$key]['special_instructions']   = $row['Special Instructions'] ?? '';
                } else {
                    $company_insert_data[$key]['name']          = $row['Name'];
                    $company_insert_data[$key]['is_lender']     = 1;
                    $company_insert_data[$key]['lookup_code']   = $row['LookupCode'];
                    $company_insert_data[$key]['phone']         = $row['Phone'] ?? '';
                    $company_insert_data[$key]['address1']      = $row['Address1'] ?? '';
                    $company_insert_data[$key]['address2']      = $row['Address2'] ?? '';
                    $company_insert_data[$key]['city']          = $row['City'] ?? '';
                    $company_insert_data[$key]['state']         = $row['State'] ?? '';
                    $company_insert_data[$key]['zip']           = $row['Zip'] ?? '';
                    $company_insert_data[$key]['fax']           = $row['Fax'] ?? '';
                    $company_insert_data[$key]['payee_name']    = $row['PayeeName'] ?? '';
                    $company_insert_data[$key]['email_address'] = $row['Email'];

                    $company_insert_data[$key]['legal_name']             = $row['LegalName'] ?? '';
                    $company_insert_data[$key]['fee_transfer_ledger']    = $row['FeeTransferLedger'] ?? '';
                    $company_insert_data[$key]['state_of_incorporation'] = $row['StateOfIncorporation'] ?? '';
                    $company_insert_data[$key]['marketing_rep']          = $row['MarketingRep'] ?? '';
                    $company_insert_data[$key]['funding_address1']       = $row['FundingAddress1'] ?? '';
                    $company_insert_data[$key]['funding_address2']       = $row['FundingAddress2'] ?? '';
                    $company_insert_data[$key]['funding_city']           = $row['FundingCity'] ?? '';
                    $company_insert_data[$key]['funding_state']          = $row['FundingState'] ?? '';
                    $company_insert_data[$key]['funding_zip']            = $row['FundingZip'] ?? '';
                    $company_insert_data[$key]['funding_phone']          = $row['FundingPhone'] ?? '';
                    $company_insert_data[$key]['funding_fax']            = $row['FundingFax'] ?? '';
                    $company_insert_data[$key]['special_instructions']   = $row['Special Instructions'] ?? '';
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
                    $company_update_data[$key]['payee_name']         = $row['Payee Name'] ?? '';
                    $company_update_data[$key]['address1']           = $row['Address (line 1)'] ?? '';
                    $company_update_data[$key]['address2']           = $row['Address (line 2)'] ?? '';
                    $company_update_data[$key]['city']               = $row['City'] ?? '';
                    $company_update_data[$key]['state']              = $row['State'] ?? '';
                    $company_update_data[$key]['zip']                = $row['Zip'] ?? '';
                    $company_update_data[$key]['phone']              = $row['Phone'] ?? '';
                    $company_update_data[$key]['fax']                = $row['Fax'] ?? '';
                    $company_update_data[$key]['email_address']      = $row['Email'];

                    $company_update_data[$key]['fee_transfer_ledger']  = $row['Fee Transfer Ledger'] ?? '';
                    $company_update_data[$key]['marketing_rep']        = $row['Marketing Rep'] ?? '';
                    $company_update_data[$key]['special_instructions'] = $row['Special Instructions'] ?? '';
                    // $company_update_data[$key]['user_type']            = 'mortgage_broker';
                } else {
                    $company_insert_data[$key]['lookup_code']        = $row['Lookup Code'];
                    $company_insert_data[$key]['name']               = $row['Name'];
                    $company_insert_data[$key]['is_mortgage_broker'] = 1;
                    $company_insert_data[$key]['payee_name']         = $row['Payee Name'] ?? '';
                    $company_insert_data[$key]['address1']           = $row['Address (line 1)'] ?? '';
                    $company_insert_data[$key]['address2']           = $row['Address (line 2)'] ?? '';
                    $company_insert_data[$key]['city']               = $row['City'] ?? '';
                    $company_insert_data[$key]['state']              = $row['State'] ?? '';
                    $company_insert_data[$key]['zip']                = $row['Zip'] ?? '';
                    $company_insert_data[$key]['phone']              = $row['Phone'] ?? '';
                    $company_insert_data[$key]['fax']                = $row['Fax'] ?? '';
                    $company_insert_data[$key]['email_address']      = $row['Email'];

                    $company_insert_data[$key]['fee_transfer_ledger']  = $row['Fee Transfer Ledger'] ?? '';
                    $company_insert_data[$key]['marketing_rep']        = $row['Marketing Rep'] ?? '';
                    $company_insert_data[$key]['special_instructions'] = $row['Special Instructions'] ?? '';
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
                    $company_update_data[$key]['payee_name']       = $row['Payee Name'] ?? '';
                    $company_update_data[$key]['address1']         = $row['Address (line 1)'] ?? '';
                    $company_update_data[$key]['address2']         = $row['Address (line 2)'] ?? '';
                    $company_update_data[$key]['city']             = $row['City'] ?? '';
                    $company_update_data[$key]['state']            = $row['State'] ?? '';
                    $company_update_data[$key]['zip']              = $row['Zip'] ?? '';
                    $company_update_data[$key]['phone']            = $row['Phone'] ?? '';
                    $company_update_data[$key]['fax']              = $row['Fax'] ?? '';
                    $company_update_data[$key]['email_address']    = $row['Email'];

                    $company_update_data[$key]['home_phone']           = $row['Home Phone'] ?? '';
                    $company_update_data[$key]['fee_transfer_ledger']  = $row['Fee Transfer Ledger'] ?? '';
                    $company_update_data[$key]['represents']           = $row['Represents'] ?? '';
                    $company_update_data[$key]['marketing_rep']        = $row['Marketing Rep'] ?? '';
                    $company_update_data[$key]['license_no']           = $row['License No'] ?? '';
                    $company_update_data[$key]['special_instructions'] = $row['Special Instructions'] ?? '';

                } else {
                    $company_insert_data[$key]['lookup_code']      = $row['Lookup Code'];
                    $company_insert_data[$key]['name']             = $row['Name'];
                    $company_insert_data[$key]['is_selling_agent'] = 1;
                    $company_insert_data[$key]['payee_name']       = $row['Payee Name'] ?? '';
                    $company_insert_data[$key]['address1']         = $row['Address (line 1)'] ?? '';
                    $company_insert_data[$key]['address2']         = $row['Address (line 2)'] ?? '';
                    $company_insert_data[$key]['city']             = $row['City'] ?? '';
                    $company_insert_data[$key]['state']            = $row['State'] ?? '';
                    $company_insert_data[$key]['zip']              = $row['Zip'] ?? '';
                    $company_insert_data[$key]['phone']            = $row['Phone'] ?? '';
                    $company_insert_data[$key]['fax']              = $row['Fax'] ?? '';
                    $company_insert_data[$key]['email_address']    = $row['Email'];

                    $company_insert_data[$key]['home_phone']           = $row['Home Phone'] ?? '';
                    $company_insert_data[$key]['fee_transfer_ledger']  = $row['Fee Transfer Ledger'] ?? '';
                    $company_insert_data[$key]['represents']           = $row['Represents'] ?? '';
                    $company_insert_data[$key]['marketing_rep']        = $row['Marketing Rep'] ?? '';
                    $company_insert_data[$key]['license_no']           = $row['License No'] ?? '';
                    $company_insert_data[$key]['special_instructions'] = $row['Special Instructions'] ?? '';

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
                    $company_update_data[$key]['address1']       = $row['Address (line 1)'] ?? '';
                    $company_update_data[$key]['city']           = $row['City'] ?? '';
                    $company_update_data[$key]['state']          = $row['State'] ?? '';
                    $company_update_data[$key]['zip']            = $row['Zip'] ?? '';
                    $company_update_data[$key]['phone']          = $row['Phone'] ?? '';
                    $company_update_data[$key]['fax']            = $row['Fax'] ?? '';
                    $company_update_data[$key]['email_address']  = $row['Email'] ?? '';

                    $company_update_data[$key]['fee_transfer_ledger'] = $row['Fee Transfer Ledger'] ?? '';
                    // $company_update_data[$key]['county']                = $row['County'];
                    $company_update_data[$key]['splitTo_premiums']      = $row['SplitTo - Premiums'] ?? '';
                    $company_update_data[$key]['percent_premiums']      = $row['Percent - Premiums'] ?? '';
                    $company_update_data[$key]['billCode_premiums']     = $row['BillCode - Premiums'] ?? '';
                    $company_update_data[$key]['splitTo_endorsements']  = $row['SplitTo - Endorsements'] ?? '';
                    $company_update_data[$key]['percent_endorsements']  = $row['Percent - Endorsements'] ?? '';
                    $company_update_data[$key]['billCode_endorsements'] = $row['BillCode - Endorsements'] ?? '';
                } else {
                    $company_insert_data[$key]['lookup_code']    = $row['Lookup Code'];
                    $company_insert_data[$key]['name']           = $row['Name'];
                    $company_insert_data[$key]['is_underwriter'] = 1;
                    $company_insert_data[$key]['address1']       = $row['Address (line 1)'] ?? '';
                    $company_insert_data[$key]['city']           = $row['City'] ?? '';
                    $company_insert_data[$key]['state']          = $row['State'] ?? '';
                    $company_insert_data[$key]['zip']            = $row['Zip'] ?? '';
                    $company_insert_data[$key]['phone']          = $row['Phone'] ?? '';
                    $company_insert_data[$key]['fax']            = $row['Fax'] ?? '';
                    $company_insert_data[$key]['email_address']  = $row['Email'] ?? '';

                    $company_insert_data[$key]['fee_transfer_ledger'] = $row['Fee Transfer Ledger'] ?? '';
                    // $company_insert_data[$key]['county']                = $row['County'] ?? '';
                    $company_insert_data[$key]['splitTo_premiums']      = $row['SplitTo - Premiums'] ?? '';
                    $company_insert_data[$key]['percent_premiums']      = $row['Percent - Premiums'] ?? '';
                    $company_insert_data[$key]['billCode_premiums']     = $row['BillCode - Premiums'] ?? '';
                    $company_insert_data[$key]['splitTo_endorsements']  = $row['SplitTo - Endorsements'] ?? '';
                    $company_insert_data[$key]['percent_endorsements']  = $row['Percent - Endorsements'] ?? '';
                    $company_insert_data[$key]['billCode_endorsements'] = $row['BillCode - Endorsements'] ?? '';
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
                if (empty($value['document_name'])) {
                    $update_row = [
                        'is_synced' => 1,
                        'reason' => 'Document name is required'
                    ];
                    $this->db->where('id', $value['id']);
                    $this->db->update('sp_file_upload_logs', $update_row);
                } else {
                    $fileData = [
                        "Id" => $value['id'],
                        "OrderNumber"  => $value['order_number'],
                        "DocumentName" => $value['document_name'],
                        "FileList"     => json_decode($value['file_list']),
                    ];
                    $fileUploadReq[] = $fileData;
                }
            }
            $reqData = json_encode($fileUploadReq);
            $this->load->library('order/softPro');
            $logid = $this->apiLogs->syncLogs(0, 'softpro', 'upload_document_cron', 'upload_document', $reqData, [], 0, 0);
            $result = $this->softpro->make_request('POST', 'upload_document', $reqData);
            $response = json_decode($result, true);
            $this->apiLogs->syncLogs(0, 'softpro', 'upload_document_cron', 'upload_document', $reqData, json_encode($response), 0, $logid);

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
            if (!empty($updateData)) {
                foreach ($updateData as $key => $update_row) {
                    $this->db->where('id', $update_row['id']);
                    $this->db->update('sp_file_upload_logs', $update_row);
                }
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

        $query = $this->db->select('id, order_type')
            ->from('pct_softpro_order_type')
            ->get();

        $orderTypeList = array_column($query->result_array(), 'id', 'order_type');

        $queryParams = http_build_query($req);
        // print_r($queryParams);die;
        // $queryParams = "DateFrom=$startDate&DateTo=$endDate";
        // $queryParams = "DateFrom=03-26-2025&DateTo=03-26-2025";
        $apiEndPoints = SOFTPRO_API_END;
        $url          = getenv("SOFT_PRO_API") . $apiEndPoints['get_softpro_orders'] . '?' . $queryParams;
        $reqData     = json_encode($req);
        $logid = $this->apiLogs->syncLogs($userdata['id'], 'softpro', 'get_softpro_orders', $url, $reqData, [], 0, 0);
        $response    = $this->softpro->make_request('GET', 'get_softpro_orders', $reqData, $queryParams);
        $this->apiLogs->syncLogs($userdata['id'], 'softpro', 'get_softpro_orders', $url, $reqData, json_encode($response), 0, $logid);

        $sheetData = [];
        $importedOrderCount = 0;
        $updatedOrderCount = 0;
        $closedFileNumbers = [];
        if ($response['status'] == 'success' && !empty($response['data'])) {
            
            $orderList = $response['data'];
            foreach ($orderList as $key => $list) {
                $completed_date = null;
                $closed_date = null;
                // $order_number = $list['OrderNumber'] ?? null;
                $file_number  = $list['OrderNumber'] ?? null;
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
                // $order_number = '20010018OCT';
                // preg_match('/^\d+/', $order_number, $matches);
                // if (!empty($matches[0])) {
                //     $number = $matches[0];  // Output: 20010018
                // } else {
                //     continue;
                // }
                if (!empty($file_number )) {
                    $condition = [
                        'where' => [
                            'file_number' => $file_number,
                        ],
                    ];
                    // $order = $this->order->get_order_likewise($number);
                    $order = $this->order->get_order($condition);
                    
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
                        if (!empty($orderType) && !empty($orderTypeList[$orderType])) {
                            $transactionData['order_type'] = $orderTypeList[$orderType];
                        }
                        
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

                        if ($orderStatus == 'completed' || $orderStatus == 'closed') {
                            $closedFileNumbers[] = $file_number;
                        }
                        $orderId = $this->home_model->insert($orderData, 'order_details');
                        
                    } else {
                        // $file_number = $order['order_number'];
                        // $orderStatus = strtolower($orderStatus);
                        $orderData = [
                            'softpro_status' => $orderStatus,
                            // 'file_number'   => $file_number,
                        ];
                        if ($orderStatus == 'completed') {
                            $orderData['order_completed_date'] = $completed_date;
                            // $orderData['sent_to_accounting_date'] = $completed_date;
                        }

                        if ($orderStatus == 'closed' && $order['softpro_status'] != 'closed') {
                            $orderData['resware_closed_status_date'] = $closed_date;
                            $closedFileNumbers[] = $file_number;
                        }
                        
                        $condition = [
                            // 'id' => $order['id']
                            'file_number' => $file_number
                        ];

                        $orderId = $this->home_model->update($orderData, $condition, 'order_details');

                        $salesPrice = $list['SalesPrice'] ?? null;
                        
                        $result = $this->db->select('transaction_id')->from('order_details')->where($condition)->get()->row_array();
                        if (isset($result['transaction_id'])) {
                            $updateDate = ['sales_amount' => $salesPrice];
                            if (!empty($salesRepId)) {
                                $updateDate['sales_representative'] = $salesRepId;
                            }
                            if (!empty($orderType) && !empty($orderTypeList[$orderType])) {
                                $updateDate['order_type'] = $orderTypeList[$orderType];
                            }
                            $updatedOrderCount++;
                            $this->home_model->update($updateDate, ['id' => $result['transaction_id']], 'transaction_details');
                        }
                    }
                }
            } // end foreach
        }
        if (!empty($closedFileNumbers)) {
            $this->sendEmailForClosedOrder($closedFileNumbers);
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
        $logid = $this->apiLogs->syncLogs(0, 'softpro', 'get_single_prelim_report', 'get_single_prelim_report', $reqData, [], 0, 0);
        $response    = $this->softpro->make_request('GET', 'get_single_prelim_report', $reqData, $queryParams);
        $this->apiLogs->syncLogs(0, 'softpro', 'get_single_prelim_report', 'get_single_prelim_report', $reqData, json_encode($response), 0, $logid);
        
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
                } else {
                    $condition = array(
                        'id' => $filesResult['id'],
                    );
                    $data = array(
                        'prelim_summary_id' => $prelimSummaryDetails['id'],
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
        // $this->load->library('order/parsedown');
        $this->load->library('order/tessa');
        $reqData     = file_get_contents("php://input");
        // $reqData = '{"Status":200,"Message":"Success","OrderNumber":"20004763-GLT","Id":null,"FileUploadedStatus":false,"data":{"orderNumber":null,"vesting":null,"requirements":[{"description":"In order to complete this report, the Company requires a Statement of Information to be completed by the following party(s),\n\nParty(s):  ALL PARTIES\n\nThe Company reserves the right to add additional items or make further requirements after review of the requested Statement of Information.\n\nNOTE:  The Statement of Information is necessary to complete the search and examination of title under this order.  Any title search includes matters that are indexed by name only, and having a completed Statement of Information assists the Company in the elimination of certain matters which appear to involve the parties but in fact affect another party with the same or similar name. Be assured that the Statement of Information is essential and will be kept strictly confidential to this file."}],"lien":[{"LienBookPages":null,"LienID":0,"LienTypeID":0,"LienTypeName":null,"Against":null,"Amount":null,"Assignee":null,"AssigneeBook":null,"AssigneeInstrument":null,"AssigneeLiber":null,"AssigneePage":null,"AssigneeVolume":null,"Assignor":null,"Book":null,"BookPages":null,"CaseNumber":null,"County":null,"CourtDistrict":null,"CourtType":null,"Date":null,"DocumentName":null,"Endorsements":null,"Flagged":false,"Grantee":null,"Grantor":null,"Holder":null,"InFavorOf":null,"InstallmentAmount":null,"InstallmentNumber":null,"Instrument":null,"IsAllCaps":false,"Language":null,"Liber":null,"MaturityDate":null,"Page":null,"Purpose":null,"RecordedDate":null,"State":null,"StateDistrict":null,"TaxYears":null,"Trustee":null,"Volume":null}],"easements":[],"exceptions":[{"description":"Property taxes , which are a lien not yet due and payable, including any assessments collected with taxes to be levied for the fiscal year 2025-2026."},{"description":"Note: Property taxes for the fiscal year shown below are PAID.  For proration purposes the amounts were:\n\nTax Identification No.:\t181-383-008\nFiscal Year:  \t2024-2025\n1st  Installment:   \t$5,296.66  \n2nd Installment:   \t$5,296.66\nExemption:   \t$0.00\nLand:    \t$74,284.00\nImprovements:   \t$423,421.00\nPersonal Property:  \t$0.00\nCode Area:                    028-088"},{"description":"The herein described Land is within the boundaries of the Mello-Roos Community Facilities District(s). The annual assessments, if any, are collected with the county property taxes. Failure to pay said taxes prior to the delinquency date may result in the above assessment being removed from the county tax roll and subjected to Accelerated Judicial Bond Foreclosure. Inquiry should be made with said District for possible stripped assessments and prior delinquencies."},{"description":"The lien of supplemental taxes, if any, assessed pursuant to the provisions of Chapter 3.5 (Commencing with Section 75) of the Revenue and Taxation Code of the State of California."},{"description":"Water rights, claims or title to water, whether or not disclosed by the Public Records."},{"description":"Easement(s) for the purpose(s) shown below and rights incidental thereto, as granted in a document:\n\nGranted to:\tCalifornia Electric Power Company \nPurpose:\tPublic Utilities\nRecording Date:\tApril 15, 1947\nRecording No:\tin Book 831, Page 73, of Official Records\nAffects:\tSaid land"},{"description":"Easement(s) for the purpose(s) shown below and rights incidental thereto, as granted in a document:\n\nGranted to:\tPacific Telephone and Telegraph Company \nPurpose:\tPublic Utilities\nRecording Date:\tAugust 14, 1947\nRecording No:\tin Book 862, Page 130, of Official Records\nAffects:\tSaid land"},{"description":"A notice that said Land is included within a project area of the Redevelopment Agency shown below, and that proceedings for the redevelopment of said project have been instituted under the Redevelopment Law (such redevelopment to proceed only after the adoption of the redevelopment plan) as disclosed by a document \n\nRecording Date: July 10, 1996 \nRecording No: 96-256410, Official Records \nRedevelopment Agency:   Jurupa Valley Redevelopment Project Area Merger and Amendment (the\"Merger and Amendment Area\")"},{"description":"Matters contained in that certain document\n\nEntitled:\t\"Proposed Boundaries of Assessment District No. 07-02 California Statewide Communities Development Authority\"\nRecording Date:\tAugust 23, 2007\nRecording No:\t2007-544462, of Official Records\nWhich provides for, among other things:  .\n\nReference is hereby made to said document for full particulars."},{"description":"An irrevocable offer to dedicate an easement over a portion of said Land for \n\nPurpose(s): Public street and Public Utility Purposes \nRecording Date: June 13, 2016 \nRecording No.: in Book 451, Page 13 through 22, inclusive, of Maps\nAffects:  Lots A through K Inclusive"},{"description":"Recitals as shown on that certain map/plat\r\n\r\nRecording Date: June 13, 2016\r\nRecording No: Book 451, Page 13 through 22, inclusive, of Maps\r\n\r\nWhich among other things recites Lot 68 is retained for Park Purposes.\r\n\r\nReference is hereby made to said document for full particulars."},{"description":"Recitals as shown on that certain map/plat\r\n\r\nRecording Date: June 13, 2016\r\nRecording No: Book 451, Page 13 through 22, inclusive, of Maps\r\n\r\nWhich among other things recites Lots 69, 70, 71, 72 and 73 are retained for Open Space Purposes.\r\n\r\nReference is hereby made to said document for full particulars."},{"description":"Recitals as shown on that certain map/plat\n\nRecording Date: June 13, 2016\nRecording No: Book 451, Page 13 through 22, inclusive, of Maps\n\nWhich among other things recites Lots 67 is retained as a storm drain retention basin\n\nReference is hereby made to said document for full particulars."},{"description":"Recitals as shown on that certain map/plat\r\n\r\nRecording Date: June 13, 2016\r\nRecording No: Book 451, Page 13 through 22, inclusive, of Maps\r\n\r\nWhich among other things recites Lots 74 and 75 are retained for Landscape Purposes.\r\n\r\nReference is hereby made to said document for full particulars."},{"description":"Reciprocal easements, for the purpose(s) shown below and rights incidental thereto as created by the following document:\n\nDocument: Grant of Easements\nExecuted by: Loring Ranch 31503, L.P., a California limited partnership and D.R. Horton CA3, Inc., a Delaware Corporation\nPurpose: Temporary non-exclusive easements for removing excess dirt stockpiles\nRecording Date: August 19, 2016\nRecording No. 2016-356222, of Official Records\nAffects: Said Land"},{"description":"Easement(s) for the purpose(s) shown below and rights incidental thereto, as granted in a document:\n\nGranted to:\tSouthern California Edison \nPurpose:\tPublic Utilities\nRecording Date:\tDecember 14, 2016\nRecording No:\t2016-556301, of Official Records\nAffects:\tSaid Land"},{"description":"Easement(s) for the purpose(s) shown below and rights incidental thereto, as granted in a document:\n\nGranted to:\tSouthern California Gas Company, a California Corporation \nPurpose:\tPublic Utilities\nRecording Date:\tDecember 29, 2016\nRecording No:\t2016-581351, of Official Records\nAffects:\tSaid Land"},{"description":"Easement(s) for the purpose(s) shown below and rights incidental thereto, as granted in a document:\n\nGranted to:\tPacific Bell Telephone Company \nPurpose:\tPublic Utilities\nRecording Date:\tFebruary 9, 2017\nRecording No:\t2017-58325, of Official Records\nAffects:\tSaid Land"},{"description":"Covenants, conditions and restrictions but omitting any covenants or restrictions, if any, including but not limited to those based upon race, color, religion, sex, sexual orientation, familial status, marital status, disability, handicap, national origin, ancestry, source of income, gender, gender identity, gender expression, medical condition or genetic information, as set forth in applicable state or federal laws, except to the extent that said covenant or restriction is permitted by applicable law, as set forth in the document\n\nRecording Date:\tFebruary 14, 2017\nRecording No:\t2017-64885, of Official Records ."},{"description":"Said covenants, conditions and restrictions provide that a violation thereof shall not defeat the lien of any mortgage or deed of trust made in good faith and for value."},{"description":"Matters contained in that certain document\n\nEntitled:\tMaster Dispute Resolution Declaration for Skypark\nRecording Date:\tFebruary 21, 2017\nRecording No:\t2017-72693, of Official Records\nWhich provides for, among other things:  .\n\nReference is hereby made to said document for full particulars."},{"description":"Matters contained in that certain document\n\nEntitled:\tIndividual Dispute Resolution Agreement For Skypark\nExecuted by:\tDR. Horton Ca3, Inc, a Delaware corporation and between Eun Kyoung Sim\nRecording Date:\tSeptember 27, 2017\nRecording No:\t2017-399978, of Official Records\nWhich provides for, among other things:  .\n\nReference is hereby made to said document for full particulars."},{"description":"An easement for the purpose shown below and rights incidental thereto as set forth in a document \n\nPurpose: Establishment of Easement \nRecorded: September 27, 2017 \nRecording no.: 2017-399980, Official Records \nAffects:  Said Land"},{"description":"Easement(s) for the purpose(s) shown below and rights incidental thereto, as granted in a document:\n\nGranted to:\tSouthern California Edison Company \nPurpose:\tPublic utilities\nRecording Date:\tMarch 28, 2018\nRecording No:\t2018-116367, of Official Records\nAffects:\tAll Streets, highways, public places, and within six feet of all front lots lines, also three feet on each side of all side lot lines of lot 1 through 66, inclusive of tract no. 31503-1, as per map filed in book 451, Page 13 through 22, inclusive of maps, in the office of the county recorder of said county."},{"description":"A Deed of Trust to secure an indebtedness in the amount shown below, and any other obligations secured thereby: \n\nAmount: $446,682.00\nDated: July 20, 2020 \nTrustor: Sofia V. Sapia, a single woman \nTrustee:  Chicago Title Company \nBeneficiary: MORTGAGE ELECTRONIC REGISTRATION SYSTEMS, INC. (MERS) SOLELY AS NOMINEE FOR LENDER \nLender: Bay-Valley Mortgage Group\nLoan No.: Not set out\nRecording Date: July 28, 2020\nRecording No.: 2020-0336656, Official Records"},{"description":"This Company will require that the original note, the original deed of trust and a properly executed request for full reconveyance together with appropriate documentation (i.e., copy of trust, partnership agreement or corporate resolution) be in this office prior to the close of this transaction if the above-mentioned item is to be paid through this transaction or deleted from a policy of title insurance. \n\nAny demands submitted to us for payoff must be signed by all beneficiaries as shown on said deed of trust, and/or any assignments thereto. In the event said demand is submitted by an agent of the beneficiary(s), we will require the written approval of the demand by the beneficiary(s). Servicing agreements do not constitute approval for the purposes of this requirement. \n\nIf no amounts remain due under the obligation a zero balance demand will be required along with the reconveyance documents. \n\nIn addition, we require the written approval of said demand by the trustor(s) on said deed of trust or the current owners if applicable."}],"Restrictions":[],"Grantee":"Hai Minh Tran and Dung T Tu","Grantor":"Sofia V Sapia"}}';
        // $reqData = '{"Status":200,"Message":"Success","OrderNumber":"20009320-GLT","Id":null,"FileUploadedStatus":false,"data":{"orderNumber":"20009320-GLT","vesting":null,"requirements":[{"description":"In order to complete this report, the Company requires a Statement of Information to be completed by the following party(s), \n\nParty(s): All Parties \n\nThe Company reserves the right to add additional items or make further requirements after review of the requested Statement of Information. \n\nNOTE: The Statement of Information is necessary to complete the search and examination of title under this order. Any title search includes matters that are indexed by name only, and having a completed Statement of Information assists the Company in the elimination of certain matters which appear to involve the parties but in fact affect another party with the same or similar name. Be assured that the Statement of Information is essential and will be kept strictly confidential to this file."}],"lien":[{"LienBookPages":null,"LienID":0,"LienTypeID":0,"LienTypeName":null,"Against":null,"Amount":null,"Assignee":null,"AssigneeBook":null,"AssigneeInstrument":null,"AssigneeLiber":null,"AssigneePage":null,"AssigneeVolume":null,"Assignor":null,"Book":null,"BookPages":null,"CaseNumber":null,"County":null,"CourtDistrict":null,"CourtType":null,"Date":null,"DocumentName":null,"Endorsements":null,"Flagged":false,"Grantee":null,"Grantor":null,"Holder":null,"InFavorOf":null,"InstallmentAmount":null,"InstallmentNumber":null,"Instrument":null,"IsAllCaps":false,"Language":null,"Liber":null,"MaturityDate":null,"Page":null,"Purpose":null,"RecordedDate":null,"State":null,"StateDistrict":null,"TaxYears":null,"Trustee":null,"Volume":null}],"easements":[],"exceptions":[{"description":"Property taxes, including any personal property taxes and any assessments collected with taxes are as follows:\n\nTax Identification No.:  \t0394-103-20-0000\nFiscal Year:  \t2025-2026\n1st  Installment:   \t$2,235.11, Open \n2nd Installment:   \t$2,235.10, Open\nExemption:   \t$0.00\nLand:    \t$36,144.00\nImprovements:   \t$145,961.00\nPersonal Property:  \t$0.00\t"},{"description":"Any liens or other assessments, bonds, or special district liens including without limitation, Community Facility Districts, that arise by reason of any local, City, Municipal or County Project or Special District."},{"description":"The herein described Land is within the boundaries of the Mello-Roos Community Facilities District(s). The annual assessments, if any, are collected with the county property taxes. Failure to pay said taxes prior to the delinquency date may result in the above assessment being removed from the county tax roll and subjected to Accelerated Judicial Bond Foreclosure. Inquiry should be made with said District for possible stripped assessments and prior delinquencies."},{"description":"The lien of supplemental taxes, if any, assessed pursuant to the provisions of Chapter 3.5 (Commencing with Section 75) of the Revenue and Taxation Code of the State of California."},{"description":"Covenants, conditions, restrictions and agreements, if any, appearing in the Public Records, deleting therefrom any restrictions indicating any preference, limitation or discrimination based on race, color religion, sex, handicap, familial status or national origin. \n\nEasements or servitudes appearing in the Public Records. \n\nLeases, grants, exceptions or reservations of minerals or mineral rights appearing in the Public Records."},{"description":"A Deed of Trust to secure an indebtedness in the amount shown below, and any other obligations secured thereby: \n\nAmount: $138,519.00\nDated: June 11, 2010 \nTrustor:  Monique M Ramirez-Washington, a married woman as her sole and separate property \nTrustee:  ReconTrust Company, N.A. \nBeneficiary: MORTGAGE ELECTRONIC REGISTRATION SYSTEMS, INC. (MERS) SOLELY AS NOMINEE FOR LENDER \nLender: KBA Mortgage, LLC\nLoan No.: Not set out\nRecording Date: June 16, 2020\nRecording No.:  2010-0239528, Official Records"},{"description":"An agreement to modify the terms and provisions of said deed of trust as therein provided\n\nExecuted by:\t Monique M. Ramirez-Washington; Lakeview Loan Servicing, LLC \nRecording Date:\tAugust 5, 2015\nRecording No:\t2015-0334410, Official Records"},{"description":"An agreement to modify the terms and provisions of said deed of trust as therein provided\n\nExecuted by:\tMonique M. Ramirez-Washington; Lakeview Loan Servicing, LLC \nRecording Date:\tJanuary 9, 2018\nRecording No:\t2018-0007023, Official Records"},{"description":"An agreement to modify the terms and provisions of said deed of trust as therein provided\n\nExecuted by:\tMonique M. Ramirez-Washington; M&T Bank  \nRecording Date:\tMarch 17, 2022\nRecording No:\t 2022-0102155, Official Records"},{"description":"By various assignments, the beneficial interest thereunder is now held of record in:\n\nAssignee:\tLakeview Loan Servicing, LLC \nLoan No.:\t0053207155 \nRecording Date:\tMay 23, 2022\nRecording No:\t2022-0189356, Official Records"},{"description":"Pending assessment for the District shown below: \n\nDistrict: City-Wide Street Lighting Assessment District \nPreliminary Assessment: $13.98 per edu \nDisclosed by: City of Victorville \nRecording Date: September 25, 2013 \nRecording No.: 2013-0420245, Official Records \n\nWhen the Notice of Assessment is recorded in the public records, the assessment shall become a lien on said Land. "},{"description":"A Deed of Trust to secure an indebtedness in the amount shown below,\n\nAmount:\t$156,000.00\nDated:\tDecember 2, 2024\nTrustor\/Grantor:\tMonique M Ramirez-Washington, a married woman as her sole and separate property\nTrustee:\tCalifornia TD Specialists\nBeneficiary:\tPM Lender Financial Services LLC, a California Limited Liability Company\nLoan No.:\t1142024W\nRecording Date:\tDecember 6, 2024\nRecording No.:\t2024-0290982, of official records"},{"description":"A notice of default under the terms of said trust deed\n\nExecuted by:\tCalifornia TD Specialists \nRecording Date:\tOctober 2, 2025\nRecording No:\t2025-0238673, Official Records"},{"description":"Note: None of the items shown in this report will cause the Company to decline to attach CLTA Endorsement Form 100 to an Extended Coverage Loan Policy, when issued."},{"description":"Note:  The Company is not aware of any matters which would cause it to decline to attach CLTA Endorsement Form 116 indicating that there is located on said Land Single Family Residence known as 14383 Painted Horse Lane, Victorville, CA 92394 to an Extended Coverage Loan Policy."}],"Restrictions":[],"Grantee":"Marcella Ramirez and Monique M Ramirez-Washington","Grantor":""}}';
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
            $fileNumber = $response['OrderNumber'];
            $params = [
                'order_details.file_number' => $fileNumber,
            ];
            $orderDetails = $this->order->get_order_details($params);
            $orderId = $orderDetails['order_id'];
            $condition = [
                // 'file_number' => '20001146-GLT' //$response['OrderNumber'],
                'file_number' => $fileNumber
            ];
            
            $prelimRow = $this->order->get_row($condition, 'pct_order_prelim_summary');
            $getPrelimDocument = $this->order->get_prelim_document($orderId);
            if (empty($getPrelimDocument)) {
                $res = "Prelim document not found.";
                $this->apiLogs->syncLogs(0, 'softpro', 'received_prelim_summary', 'received_prelim_summary', $reqData, $res, 0, $logid);
                echo $res; exit;
            }
            $fileName = $getPrelimDocument['document_name'];
            // $filePath = 'https://pct-doc.s3-us-west-2.amazonaws.com/documents/' . $fileName;
            $filePath = env('AWS_PATH') .  'documents/' . $fileName;
            // echo "<pre> test it";
            // print_r($prelimRow);die;

            $response['data']['orderNumber'] = $fileNumber;
            if (empty($prelimRow)) {
                $prelimData = array(
                    'file_number' => $fileNumber,
                    'resware_json' => json_encode($response['data']),
                    'created_at' => date('Y-m-d H:i:s')
                );
                $prelimSumaryId = $this->home_model->insert($prelimData, 'pct_order_prelim_summary');
                // $prelimSumaryId = $this->db->insert('pct_order_prelim_summary', $prelimData);
                
                $condition = array(
                    'file_number' => $fileNumber,
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
            // $this->load->library('order/order');
            // $chatGptJsonRes = $this->order->getPrelimAISummary($responseData);
            $tessaJsonRes = $this->tessa->analyze_pdf_with_tessa($filePath, $fileName);
            $tessaRes    = json_decode($tessaJsonRes, true);
            $tessaText = $tessaRes['choices'][0]['message']['content'] ?? 'No content found.';
            // $html = $this->tessa->format_enhanced_analysis($tessaText, $fileName);
            $prelimData = array(
                'chatgpt_json' => $tessaJsonRes
            );
            $this->apiLogs->syncLogs(0, 'sendgrid', 'received_prelim_summary', 'received_prelim_summary', $reqData, $tessaJsonRes, 0, $logid);
            // $chatGptJsonRes = $this->chatgpt->make_request($prompt);
            
            
            // $chatGptRes    = json_decode($chatGptJsonRes, true);
            $prelimData = array(
                'chatgpt_json' => $tessaJsonRes,
                'is_tessa' => 1,
                'updated_at' => date('Y-m-d H:i:s')
            );
            $condition = [
                // 'file_number' => '20001146-GLT'
                'file_number' => $fileNumber
            ];
            $this->db->set($prelimData);
            $this->db->where($condition);
            $this->db->update('pct_order_prelim_summary');
            if ($prelimSummaryEmailFlag == 0) {
                $res = "Prelim Summary Email is disabled by Admin.";
                $this->apiLogs->syncLogs(0, 'sendgrid', 'send_mail_for_prelim_summary', 'send_mail_for_prelim_summary', $reqData, $res, 0, $logid);
                echo $res; exit;
            }
            // $markdown = $chatGptRes['choices'][0]['message']['content'] ?? 'No content received.';
            // $data['html'] = $this->parsedown->text($markdown);
            $tessaText = $tessaRes['choices'][0]['message']['content'] ?? 'No content found.';
            $data['html'] = $this->tessa->format_enhanced_analysis($tessaText, $fileName);
            $data['file_number'] = $fileNumber;
            // $data['adrress'] = $response['OrderNumber'];
            $message = $this->load->view('emails/prelim_summary.php', $data, true);
            $from_name = 'Pacific Coast Title Company';
            $from_mail = env('FROM_EMAIL');
            $to = 'ghernandez@pct.com';
            // $to = 'piyush.j@crestinfosystems.com';
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
            
            // echo "<pre>";
            // print_r($tessRes);die;
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
        $this->load->library('order/tessa');
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

            $params = [
                'order_details.file_number' => $fileNumber,
            ];
            $orderDetails = $this->order->get_order_details($params);
            $orderId = $orderDetails['order_id'];
            $getPrelimDocument = $this->order->get_prelim_document($orderId);
            if (empty($getPrelimDocument)) {
                $res = "Prelim document not found.";
                $this->apiLogs->syncLogs(0, 'softpro', 'received_prelim_summary', 'received_prelim_summary', $reqData, $res, 0, $logid);
                echo $res; exit;
            }
            $fileName = $getPrelimDocument['document_name'];
            // $filePath = 'https://pct-doc.s3-us-west-2.amazonaws.com/documents/' . $fileName;
            $filePath = env('AWS_PATH') .  'documents/' . $fileName;



            // $prelimSummaryJson = json_decode($value['resware_json'], true);
            
            // $chatGptJsonRes = $this->order->getPrelimAISummary($prelimSummaryJson);

            // $chatGptRes    = json_decode($chatGptJsonRes, true);

            $tessaJsonRes = $this->tessa->analyze_pdf_with_tessa($filePath, $fileName);
            $tessaRes    = json_decode($tessaJsonRes, true);
            // $tessaText = $tessaRes['choices'][0]['message']['content'] ?? 'No content found.';
            // $html = $this->tessa->format_enhanced_analysis($tessaText, $fileName);
            $prelimData = array(
                'chatgpt_json' => $tessaJsonRes,
                'is_tessa' => 1
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
        // print_r($dayOfWeek);die;
        
        // Determine date range based on day of week
        if ($dayOfWeek == 4) { // Wednesday
            $startDate = date('Y-m-d', strtotime('last monday'));
            $endDate = date('Y-m-d', strtotime('last wednesday'));
            // $endDate = date('Y-m-d'); // Today (Wednesday)
            $reportName = 'Monday-Wednesday Orders Report';
        } elseif ($dayOfWeek == 6) { // Thursday
            $startDate = date('Y-m-d', strtotime('last thursday'));
            $endDate = date('Y-m-d', strtotime('last friday'));
            // $endDate = date('Y-m-d'); // Today (Thursday)
            $reportName = 'Thurs-Friday Orders Report';
        } else {
            echo "Today is not Wednesday or Friday. No report generated.";
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
                return;
            }

            $recipients = [];
            if (empty($data['escrow_no_survey_notify']) && !empty($data['escrow_email'])) {
                $to[] = $data['escrow_email'];
                $recipients[] = [
                    'id' => $data['escrow_id'],
                    'email_address' => $data['escrow_email'],
                ];
                $data['survey_link'] = $data['survey_link'] . '&uid=' . $data['escrow_id'];
            }

            $message = $this->load->view('emails/surveymonkey_email.php', $data, true);
            // print_r($message);die;
            $from_name = 'Pacific Coast Title Company';
            $from_mail = env('FROM_EMAIL');
            // $subject = 'Thank You!';
            // $to = 'piyush-crest@yopmail.com';
            // if (!empty($data['escrow_officer_email'])) {
            //     $to[] = $data['escrow_officer_email'];
            // }
            // if (empty($data['lender_no_survey_notify']) && !empty($data['lender_email'])) {
            //     $to[] = $data['lender_email'];
            // }
            
    
            // $to = array('piyush.j@crestinfosystems.com');
            $cc = array(' rudy@pct.com');
    
            $from_name = 'Pacific Coast Title Company';
            $from_mail = env('FROM_EMAIL');
            $subject = "We'd Love Your Feedback -" . $data['file_number'];
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
            if (!empty($recipients)) {
                foreach($recipients as $key => $recipient) {
                    $logid = $this->apiLogs->syncLogs(0, 'sendgrid', 'survay_email_sent_mail_contacts', '', $mailParams, array(), $data['order_id'], 0);
                    $mail_result = send_email($from_mail, $from_name, $recipient['email_address'], $subject, $message, array(), $cc);
                    $this->apiLogs->syncLogs(0, 'sendgrid', 'survay_email_sent_mail_contacts', '', $mailParams, array('status' => $mail_result), $data['order_id'], $logid);
                }
                echo "Survay Mails sent successfully for Order Number : " . $data['file_number'] . " To: " . implode(', ', $to) . "And In CC : " . implode(', ', $cc) . "<br/>";
            } else {
                echo "No recepient found";
            }
        }
    }

    public function sendSurveyQueuedEmail() {
        $yesterday = date('Y-m-d', strtotime('-1 day'));
        // $yesterday = date('Y-m-d');
        $this->db->from('pct_email_queue');
        $this->db->where('status', 0);
        $this->db->where('email_type', 'survey');

        $this->db->where('DATE(created_at)', $yesterday);
        $this->db->order_by('id', 'desc');
        $query  = $this->db->get();
        $result = $query->result_array();
        // echo "<pre>";
        // print_r($result);die;
        if (empty($result)) {
            echo "No record found";exit;
        }
        $this->load->library('order/order');
        $configData    = $this->order->getConfigData();
        $enableSurveyEmailFlag = $configData['enable_survey_email']['is_enable'];
        foreach ($result as $order) {
            // lender_details.email_address as lender_email,
            // lender_details.no_survey_notify as lender_no_survey_notify,
            $this->db->select('
                order_details.file_number,
                order_details.id as order_id,
                order_details.prod_type,
                order_details.survey_notification_sent,
                property_details.full_address,
                escrow_details.id as escrow_id,
                escrow_details.email_address as escrow_email,
                escrow_details.no_survey_notify as escrow_no_survey_notify,
                title_officer.email_address as title_officer_email,
                escrow_officer.id as escrow_officer_id,
                escrow_officer.email_address as escrow_officer_email
                ');
            $this->db->from('order_details');
            $this->db->where('file_number', $order['file_number']);
            // $this->db->where('property_details.escrow_lender_id != ""');
            // $this->db->where('transaction_details.sales_representative != ""');
            $this->db->join('property_details', 'order_details.property_id = property_details.id', 'inner');
            $this->db->join('transaction_details', 'order_details.transaction_id = transaction_details.id', 'inner');
            $this->db->join('pct_softpro_lookup_table as escrow_details', 'escrow_details.id = property_details.escrow_id', 'left');
            // $this->db->join('pct_softpro_lookup_table as lender_details', 'lender_details.id = property_details.lender_id', 'left');
            $this->db->join('pct_softpro_lookup_table as title_officer', 'title_officer.id = transaction_details.title_officer', 'left');
            $this->db->join('pct_softpro_lookup_table as escrow_officer', 'escrow_officer.id = order_details.escrow_officer_id', 'left');
            // $this->db->order_by('transaction_details.sales_representative asc, property_details.escrow_lender_id asc');
            $query  = $this->db->get();
            $data = $query->row_array();
            if ( $enableSurveyEmailFlag == 1 && !empty($data) && empty($data['survey_notification_sent'])) {
                $this->sendSurvayEmail($data);
                // print_r($data);die;
                $updateData = ['survey_notification_sent' => 1];
                $this->db->set($updateData);
                $this->db->where('file_number', $order['file_number']);
                $this->db->update('order_details');
                // print_r($data);;die;
            }
            
            $updateData = ['status' => 1];
            $this->db->set($updateData);
            $this->db->where('file_number', $order['file_number']);
            $this->db->update('pct_email_queue');
        }
    }

    public function importRevenueData()
    {
        ini_set('max_execution_time', 0); 
        ini_set('memory_limit','2048M');
        $this->load->library('order/softPro');
        $this->load->model('order/apiLogs');
        $data = array();
        $data['title'] = 'PCT Order: Import Revenue Data From PowerBI';
        
        $query = $this->db->select('id, product_type')
            ->from('pct_softpro_product_type')
            ->get();

        $productTypeList = array_column($query->result_array(), 'id', 'product_type');

        $query = $this->db->select('id, order_type')
            ->from('pct_softpro_order_type')
            ->get();

        $orderTypeList = array_column($query->result_array(), 'id', 'order_type');

        // $startDate = new DateTime('2025-10-31');
        // $endDate   = new DateTime('2025-10-31');

        // for ($date = $startDate; $date <= $endDate; $date->modify('+1 day')) {
        //     // echo $date->format('Y-m-d') . "\n";
        //     $req['userPostedDate'] = $date->format('Y-m-d');
        
        // die;
        
        // foreach ($dateIntervalQueryParams as $key => $range) {
            // $startDate = date('2025-10-31');
            $startDate = date('Y-m-d');
            $req['userPostedDate'] = $startDate;

            $queryParams = http_build_query($req);
            $apiEndPoints = SOFTPRO_API_END;
            $url          = getenv("SOFT_PRO_API") . $apiEndPoints['power_bi_revenue'] . '?' . $queryParams;
            $reqData     = json_encode($req);
            $logid = $this->apiLogs->syncLogs($userdata['id'], 'softpro', 'power_bi_revenue', $url, $reqData, [], 0, 0);
            $response    = $this->softpro->make_request('GET', 'power_bi_revenue', $reqData, $queryParams);
            $this->apiLogs->syncLogs($userdata['id'], 'softpro', 'power_bi_revenue', $url, $reqData, json_encode($response), 0, $logid);
            // echo "<pre>";
            // print_r($response);die;
            $updateData = [];
            $billCodeFilter = ['TPC', 'TPW', 'ESC', 'TSGW', 'UPRE'];
            if ($response['status'] == 'success' && !empty($response['data'])) {
                
                $orderList = $response['data'];
                foreach ($orderList as $key => $list) {
                    // print_r($list);die;
                    $rowData = array();
                    $billCode = $list['[BillCode]'];
                    if (in_array($billCode, $billCodeFilter)) {
                        $amount = $list['[SumAmount]'];
                        // $amount = (float) str_replace(['$', ','], '', $data[42]);
                        // $amount = round($amt, 2);
                        $orderNumber = trim($list['[Number]']);
                        
                        $transactionDate = $list['[TransactionDate]'];
                        $transactionType = trim($list['[TransType]']);
                        $salesRep = $list['[SalesRep]'];
                        $fullAddress = $list['[FullAddress]'];
                        $address = $list['[Address1]'];
                        $city = $list['[City]'];
                        $state = $list['[PropState]'];
                        $zip = $list['[Zip]'];
                        $country = $list['[County]'];
                        $orderType = trim($list['[OrderType]']);
                        $escrowClosedDate = $list['[EscrowClosedDate]'];
                        if (array_key_exists($orderNumber, $updateData)) { 
                            $updateData[$orderNumber]['premium'] += $amount;
                        } else {
                            $updateData[$orderNumber] = [
                                'order_number' => $orderNumber,
                                'transaction_date' => $transactionDate,
                                'bill_code' => $billCode,
                                'transaction_type' => $transactionType,
                                'sales_rep' => $salesRep,
                                'full_address' => $fullAddress,
                                'address' => $address,
                                'city' => $city,
                                'state' => $state,
                                'zip' => $zip,
                                'country' => $country,
                                'premium' => round($amount, 2),
                                'order_type' => $orderType
                            ];
                        }
                    }
                    
                }
                // echo "<pre>";
                // print_r($updateData);die;
                if (!empty($updateData)) {
                    foreach ($updateData as $key => $value) {
                        $orderDetails = $this->db->select('id, property_id, transaction_id, premium, escrow_officer_id, softpro_status, file_number, is_softpro_order')->from('order_details')->where(['file_number' => trim($value['order_number']), 'is_softpro_order' => 1])->get()->row_array();
                        $prevPremium = $orderDetails['premium'] ?? 0;
                        if (!empty($orderDetails)) {
                            $salesRepDetails = $this->db->select('id')->from('pct_softpro_lookup_table')->where('full_name', $value['sales_rep'])->get()->row_array();

                            $updateOrderDetails = [
                                'premium' => $value['premium'],
                                'bill_code' => $value['bill_code'],
                                'transaction_date' => date('Y-m-d', strtotime($value['transaction_date'])),
                                'sent_to_accounting_date' => date('Y-m-d H:i:s', strtotime($value['transaction_date'])),
                                'updated_at' => date("Y-m-d H:i:s")
                            ];
                            if (!empty($value['transaction_type'])) {
                                $updateOrderDetails['prod_type'] = $value['transaction_type'];
                            }
                            $this->db->update('order_details', $updateOrderDetails, ['file_number' => $value['order_number']]);
                            $activity = 'Revenue data update for order :' . $value['order_number'] . ' and premium amount :' . $value['premium'] . ' Sales reps: ' . $value['sales_rep'] . ' Transaction Date: ' . $value['transaction_date'] . ' Bill Code: ' . $value['bill_code'];
                            $this->order->logAdminActivity($activity);
                            $updateCount++;
                            
                            $updateTransactionDetails = [];
                            if (!empty($salesRepDetails)) {
                                $updateTransactionDetails['sales_representative'] = $salesRepDetails['id'];
                            }
                            if (!empty($value['order_type']) && !empty($orderTypeList[$value['order_type']])) {
                                $updateTransactionDetails['order_type'] = $orderTypeList[$value['order_type']];
                            }
                            if (!empty($value['transaction_type'])) {
                                $updateTransactionDetails['transaction_type'] = $value['transaction_type'];
                            }
                            if (!empty($updateTransactionDetails)) {
                                $this->db->update('transaction_details', $updateTransactionDetails, array('id' => $orderDetails['transaction_id']));
                            }
                        }
                    }
                }

                
                $this->session->set_flashdata('revenue_success', 'Data updated for total ' . $updateCount . ' Orders');
            }
        // }
        unset($updateTransactionDetails);
        unset($updateCount);
        unset($updateData);
        unset($salesRepDetails);
        unset($updateOrderDetails);
        unset($orderList);
        unset($response);
        unset($orderTypeList);
        unset($productTypeList);
        unset($query);
    }

    public function updatePmaRepsId() {

        $this->db->select('p.id, sales_rep, c.id as c_id, l.id as look_id');
        $this->db->from('pct_pma_data as p');
        $this->db->join('customer_basic_details as c', '(c.id = p.sales_rep)', 'inner');
        $this->db->join('pct_softpro_lookup_table as l', '(c.first_name = l.first_name and c.last_name = l.last_name) or (c.email_address = l.email_address)', 'inner');
        $query  = $this->db->get();
        $result = $query->result_array();
        
        $keyed_results = [];

        foreach ($result as $row) {
            // Use the 'sales_rep' column value as the array key
            // Assign the entire row array to the new key
            $keyed_results[$row['sales_rep']] = $row;
        }
            // echo "<pre>";
            // print_r($keyed_results);die;
        



        $this->db->select('id, sales_rep');
        $this->db->from('pct_pma_data');
        $this->db->order_by('id', 'desc');
        $pmaList = $this->db->get()->result_array();
        // echo "<pre>";
        // print_r($pmaList);die;
        
        $count=0;
        $sales_rep = [];
        foreach ($pmaList as $key => $list) {
            if (array_key_exists($list['sales_rep'], $keyed_results)) {
                $updateData = [
                    'sales_rep' => $keyed_results[$list['sales_rep']]['look_id'],
                ];
                
            } else {
                if (!in_array($list['sales_rep'], $sales_rep)) {
                    $sales_rep[] = $list['sales_rep'];
                }
                $updateData = [
                    'sales_rep' => null,
                ];
            }
            $condition = [
                'id' => $list['id']
            ];
            $update = $this->db->update('pct_pma_data', $updateData, $condition);
        }
        
        print_r($sales_rep);die;
    }

    public function updatePmaRepsAddedId() {

        $this->db->select('p.id, added_by, c.id as c_id, l.id as look_id');
        $this->db->from('pct_pma_data as p');
        $this->db->join('customer_basic_details as c', '(c.id = p.added_by)', 'inner');
        $this->db->join('pct_softpro_lookup_table as l', '(c.first_name = l.first_name and c.last_name = l.last_name) or (c.email_address = l.email_address)', 'inner');
        $query  = $this->db->get();
        $result = $query->result_array();
        
        $keyed_results = [];

        foreach ($result as $row) {
            // Use the 'sales_rep' column value as the array key
            // Assign the entire row array to the new key
            $keyed_results[$row['added_by']] = $row;
        }
            // echo "<pre>";
            // print_r($keyed_results);die;
        



        $this->db->select('id, added_by');
        $this->db->from('pct_pma_data');
        $this->db->order_by('id', 'desc');
        $pmaList = $this->db->get()->result_array();
        // echo "<pre>";
        // print_r($pmaList);die;
        
        $count=0;
        $added_by = [];
        foreach ($pmaList as $key => $list) {
            if (array_key_exists($list['added_by'], $keyed_results)) {
                $updateData = [
                    'added_by' => $keyed_results[$list['added_by']]['look_id'],
                ];
                
            } else {
                if (!in_array($list['added_by'], $added_by)) {
                    $added_by[] = $list['added_by'];
                }
                $updateData = [
                    'added_by' => null,
                ];
            }
            $condition = [
                'id' => $list['id']
            ];
            $update = $this->db->update('pct_pma_data', $updateData, $condition);
        }
        
        print_r($added_by);die;
    }

    public function updateOrderTypeForImportedOrder() {
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

        $query = $this->db->select('id, order_type')
            ->from('pct_softpro_order_type')
            ->get();

        $orderTypeList = array_column($query->result_array(), 'id', 'order_type');

        $this->db->select('order_details.id, file_number, t.title_officer, transaction_id, escrow_officer_id');
        $this->db->from('order_details');
        $this->db->join('transaction_details as t', 'order_details.transaction_id = t.id', 'left');
        $this->db->where('is_softpro_order', 1);
        $this->db->where('t.order_type is null');
        $this->db->order_by('order_details.id', 'DESC');
        $this->db->limit(50);
        $orderList = $this->db->get()->result_array();
        // echo "<pre>";
        // print_r($orderList);die;
        $this->load->library('order/softPro');
        $this->load->model('order/apiLogs');
        $count=0;
        foreach ($orderList as $key => $list) {
            $req['DateFrom'] = '';
            $req['DateTo'] = '';
            $req['OrderNumber'] = "";
            if (!empty($list['file_number'])) {
                $orderNumber = $list['file_number'];
                $req['OrderNumber'] = $orderNumber;
            }

            $queryParams = http_build_query($req);
            $apiEndPoints = SOFTPRO_API_END;
            $url          = getenv("SOFT_PRO_API") . $apiEndPoints['get_softpro_orders'] . '?' . $queryParams;
            $reqData     = json_encode($req);
            $logid = $this->apiLogs->syncLogs($userdata['id'], 'softpro', 'update_order_type', $url, $reqData, [], 0, 0);
            $response    = $this->softpro->make_request('GET', 'get_softpro_orders', $reqData, $queryParams);
            $this->apiLogs->syncLogs($userdata['id'], 'softpro', 'update_order_type', $url, $reqData, json_encode($response), 0, $logid);

            $sheetData = [];
            $importedOrderCount = 0;
            $updatedOrderCount = 0;
            $closedFileNumbers = [];
            if ($response['status'] == 'success' && !empty($response['data'])) {
                
                $orderList = $response['data'];
                foreach ($orderList as $key => $list) {
                    $file_number = $list['OrderNumber'] ?? null;
                    $orderType = $list['OrderType'] ?? null;
                    $transactionType = $list['TransactionType'] ?? null;
                    $marketingRep = $list['MarketingRep'] ?? null;
                    
                    if (!empty($file_number)) {
                        $condition = [
                            'where' => [
                                'file_number' => $file_number,
                            ],
                        ];
                        $order = $this->order->get_order($condition);
                        
                        $salesRepId = (!empty($marketingRep)) ? $salesRepList[$marketingRep] : null;
                        $condition = [
                            'file_number' => $file_number
                        ];

                        $orderId = $this->home_model->update($orderData, $condition, 'order_details');
                        $result = $this->db->select('transaction_id')->from('order_details')->where($condition)->get()->row_array();
                        if (isset($result['transaction_id'])) {
                            if (!empty($salesRepId)) {
                                $updateDate['sales_representative'] = $salesRepId;
                            }
                            if (!empty($orderType) && !empty($orderTypeList[$orderType])) {
                                $updateDate['order_type'] = $orderTypeList[$orderType];
                            }
                            $this->home_model->update($updateDate, ['id' => $result['transaction_id']], 'transaction_details');
                            $count++;
                        }
                        
                    }
                } // end foreach
            }
            
            /** Cron log start */
            $res = $count .' Order updated successfully';
            $apiEndPoints = SOFTPRO_API_END;
            $url          = getenv("SOFT_PRO_API") . $apiEndPoints['get_softpro_orders'] . '?' . $queryParams;
            $this->order->syncLogs('softpro', 'get_softpro_orders', $url, $reqData, $res, 0, 0);
            /** Cron log end */
        }
        $res = json_encode(['updated' => $count]);
        print_r($res);die;
    
    }
    public function updateOrderScript()
    {
        $json = '{"status":"success","message":"Success","data":[{"OrderNumber":"20000278-OCT","OrderStatus":"InProcess","OrderType":"Title only","TransactionType":"Purchase","MarketingRep":"Linda Ruiz","Address":"1901 Saint Augustine Court","Zip":"95358","City":"Modesto","State":"CA","Country":"Stanislaus"},{"OrderNumber":"20000406-OCT","OrderStatus":"Canceled","OrderType":"Title only","TransactionType":"Purchase","MarketingRep":"Linda Ruiz","Address":"6442 Pepper Hill Drive, Unit 31","Zip":"92886","City":"Yorba Linda","State":"CA","Country":"Orange"},{"OrderNumber":"20000470-GLT","OrderStatus":"InProcess","OrderType":"Title only","TransactionType":"Refinance","MarketingRep":"Ventura House Account","Address":"13308 Loumont Street","Zip":"90601","City":"Los Angeles","State":"CA","Country":"Los Angeles"},{"OrderNumber":"20000962-GLT","OrderStatus":"InProcess","OrderType":"Title only","TransactionType":"Purchase","MarketingRep":"Justin Nouri","Address":"549 South E Street","Zip":"93030","City":"Oxnard","State":"CA","Country":"Ventura"},{"OrderNumber":"20001005-GLT","OrderStatus":"Closed","OrderType":"Title only","TransactionType":"Purchase","MarketingRep":"Ventura House Account","Address":"5451 Colt Lane, (Riverside Area)","Zip":"92509","City":"Jurupa Valley","State":"CA","Country":"Riverside"},{"OrderNumber":"20001022-OCT","OrderStatus":"Closed","OrderType":"Title only","TransactionType":"Refinance","MarketingRep":"Sonia Flores","Address":"9707 E Avenue S4","Zip":"93543","City":"Littlerock","State":"CA","Country":"Los Angeles"},{"OrderNumber":"20001041-OCT","OrderStatus":"InProcess","OrderType":"Title only","TransactionType":"Purchase","MarketingRep":"Ventura House Account","Address":"9305 Paloos Ct","Zip":"95451","City":"Kelseyville","State":"CA","Country":"Lake"},{"OrderNumber":"20001282-OCT","OrderStatus":"InProcess","OrderType":"Title only","TransactionType":"Purchase","MarketingRep":"Ventura House Account","Address":"6958 Clemson Street","Zip":"91710","City":"Chino","State":"CA","Country":"San Bernardino"},{"OrderNumber":"20001372-OCT","OrderStatus":"InProcess","OrderType":"Title only","TransactionType":"Refinance","MarketingRep":"Angeline Wu","Address":"32 Constellation Way","Zip":"92679","City":"Coto De Caza","State":"CA","Country":"Orange"},{"OrderNumber":"20001526-GLT","OrderStatus":"InProcess","OrderType":"Title only","TransactionType":"Purchase","MarketingRep":"Lopez Team","Address":"27857 Hummingbird Lane","Zip":"92342","City":"Helendale","State":"CA","Country":"San Bernardino"},{"OrderNumber":"20001581-OCT","OrderStatus":"InProcess","OrderType":"Title only","TransactionType":"Purchase","MarketingRep":"Lopez Team","Address":"2972 June Street","Zip":"92407","City":"San Bernardino","State":"CA","Country":"San Bernardino"},{"OrderNumber":"20001750-GLT","OrderStatus":"InProcess","OrderType":"Title only","TransactionType":"Purchase","MarketingRep":"Lopez Team","Address":"427 North Walnuthaven Drive","Zip":"91790","City":"West Covina","State":"CA","Country":"Los Angeles"},{"OrderNumber":"20001994-GLT","OrderStatus":"Completed","OrderType":"Title only","TransactionType":"Refinance","MarketingRep":"Team Meza","Address":"11223 Liggett Street","Zip":"90650","City":"Norwalk","State":"CA","Country":"Los Angeles"},{"OrderNumber":"20002235-OCT","OrderStatus":"InProcess","OrderType":"Title only","TransactionType":"Purchase","MarketingRep":"Laurie Briggs","Address":"12 Via Alcamo","Zip":"92673","City":"San Clemente","State":"CA","Country":"Orange"},{"OrderNumber":"20002319-GLT","OrderStatus":"InProcess","OrderType":"Title only","TransactionType":"Purchase","MarketingRep":"Chuck Cota","Address":"570 Oswald Road","Zip":"95991","City":"Yuba City","State":"CA","Country":"Sutter"},{"OrderNumber":"20002543-GLT","OrderStatus":"InProcess","OrderType":"Title only","TransactionType":"Purchase","MarketingRep":"Title Gals","Address":"919 N. Inglewood Avenue, Unit 10","Zip":"90302","City":"Inglewood","State":"CA","Country":"Los Angeles"},{"OrderNumber":"20002583-GLT","OrderStatus":"Completed","OrderType":"Title & Escrow","TransactionType":"Purchase","MarketingRep":"Title Gals","Address":"80782 Via Puerta Azul","Zip":"92253","City":"La Quinta","State":"CA","Country":"Riverside"},{"OrderNumber":"20002682-GLT","OrderStatus":"InProcess","OrderType":"Title only","TransactionType":"Purchase","MarketingRep":"Lopez Team","Address":"3381 Sequoia Court","Zip":"92570","City":"Perris","State":"CA","Country":"Riverside"},{"OrderNumber":"20002711-GLT","OrderStatus":"Closed","OrderType":"Title only","TransactionType":"Purchase","MarketingRep":"Ventura House Account","Address":"2413 Maynard Drive","Zip":"91010","City":"Duarte","State":"CA","Country":"Los Angeles"},{"OrderNumber":"20002728-GLT","OrderStatus":"InProcess","OrderType":"Title only","TransactionType":"Refinance","MarketingRep":"Michael Caballero","Address":"818 South Beechwood Avenue","Zip":"92376","City":"Rialto","State":"CA","Country":"San Bernardino"},{"OrderNumber":"20002750-GLT","OrderStatus":"InProcess","OrderType":"Title only","TransactionType":"Refinance","MarketingRep":"Felicia Pantoja","Address":"12820 Cobalt Road","Zip":"92392","City":"Victorville","State":"CA","Country":"San Bernardino"},{"OrderNumber":"20002950-GLT","OrderStatus":"InProcess","OrderType":"Title only","TransactionType":"Purchase","MarketingRep":"Michael Nouri","Address":"7323 Crenshaw Blvd","Zip":"90043","City":"Los Angeles","State":"CA","Country":"Los Angeles"},{"OrderNumber":"20002960-GLT","OrderStatus":"InProcess","OrderType":"Title only","TransactionType":"Purchase","MarketingRep":"Ventura House Account","Address":"25761 Le Parc #89","Zip":"92630","City":"Lake Forest","State":"CA","Country":"Orange"},{"OrderNumber":"20002970-OCT","OrderStatus":"InProcess","OrderType":"Title only","TransactionType":"Refinance","MarketingRep":"Sonia Flores","Address":"1731 N Oxford Ave","Zip":"91104","City":"Pasadena","State":"CA","Country":"Los Angeles"},{"OrderNumber":"20003063-GLT","OrderStatus":"Closed","OrderType":"Title only","TransactionType":"Purchase","MarketingRep":"Ventura House Account","Address":"4729 Fall Avenue","Zip":"94804","City":"Richmond","State":"CA","Country":"Contra Costa"},{"OrderNumber":"20003176-OCT","OrderStatus":"InProcess","OrderType":"Title only","TransactionType":"Purchase","MarketingRep":"Ventura House Account","Address":"4539 Maine Avenue","Zip":"91706","City":"Baldwin Park","State":"CA","Country":"Los Angeles"},{"OrderNumber":"20003300-GLT","OrderStatus":"Canceled","OrderType":"Title only","TransactionType":"Refinance","MarketingRep":"Sonia Flores","Address":"16178 Eastridge Court","Zip":"91709","City":"Chino Hills","State":"CA","Country":"San Bernardino"},{"OrderNumber":"20003315-OCT","OrderStatus":"Completed","OrderType":"Title only","TransactionType":"Refinance","MarketingRep":"Sandra Millar","Address":"640-642 South Mcbride Avenue","Zip":"90022","City":"Los Angeles","State":"CA","Country":"Los Angeles"},{"OrderNumber":"20003341-GLT","OrderStatus":"InProcess","OrderType":"Title only","TransactionType":"Purchase","MarketingRep":"Team Meza","Address":"842 E 83rd Street","Zip":"90001","City":"Los Angeles","State":"CA","Country":"Los Angeles"},{"OrderNumber":"20003425-OCT","OrderStatus":"Closed","OrderType":"Title only","TransactionType":"Purchase","MarketingRep":"Title Team","Address":"1270 Center Street, 314 Iowa Avenue","Zip":"92507","City":"Riverside","State":"CA","Country":"Riverside"},{"OrderNumber":"20003437-OCT","OrderStatus":"Closed","OrderType":"Title only","TransactionType":"Purchase","MarketingRep":"Simon Wu","Address":"110 Pixel","Zip":"92618","City":"Irvine","State":"CA","Country":"Orange"},{"OrderNumber":"20003604-OCT","OrderStatus":"InProcess","OrderType":"Title only","TransactionType":"Purchase","MarketingRep":"Nicholas Watt","Address":"5 Oceanfront Lane","Zip":"92629","City":"Dana Point","State":"CA","Country":"Orange"},{"OrderNumber":"20003708-OCT","OrderStatus":"Closed","OrderType":"Title only","TransactionType":"Purchase","MarketingRep":"Nicholas Watt","Address":"32512 Seven Seas Drive","Zip":"92629","City":"Dana Point","State":"CA","Country":"Orange"},{"OrderNumber":"20003872-OCT","OrderStatus":"Completed","OrderType":"Title only","TransactionType":"Purchase","MarketingRep":"Orange County House Account","Address":"308 East 16th Street","Zip":"95901","City":"Marysville","State":"CA","Country":"Yuba"},{"OrderNumber":"20003884-GLT","OrderStatus":"InProcess","OrderType":"Title only","TransactionType":"Purchase","MarketingRep":"Chuck Cota","Address":"460 Oswald Road","Zip":"95991","City":"Yuba City","State":"CA","Country":"Sutter"},{"OrderNumber":"99100279","OrderStatus":"Closed","OrderType":"Trustee Sale Guarantee","TransactionType":"Other","MarketingRep":"Dan Culnane","Address":"2200 NICHOLS CANYON ROAD","Zip":"90046","City":"Los Angeles","State":"CA","Country":"Los Angeles"},{"OrderNumber":"20003983-GLT","OrderStatus":"InProcess","OrderType":"Title only","TransactionType":"Refinance","MarketingRep":"Justin Nouri","Address":"17961 Martha Street","Zip":"91316","City":"Encino","State":"CA","Country":"Los Angeles"},{"OrderNumber":"20003995-GLT","OrderStatus":"InProcess","OrderType":"Title only","TransactionType":"Purchase","MarketingRep":"Title Gals","Address":"651 Viewpointe Lane","Zip":"92881","City":"Corona","State":"CA","Country":"Riverside"},{"OrderNumber":"20004050-OCT","OrderStatus":"InProcess","OrderType":"Title only","TransactionType":"Purchase","MarketingRep":"Sonia Flores","Address":"2311 Gillingham Circle","Zip":"91362","City":"Thousand Oaks","State":"CA","Country":"Ventura"},{"OrderNumber":"20004065-GLT","OrderStatus":"Completed","OrderType":"Title only","TransactionType":"Refinance","MarketingRep":"Kevin Green","Address":"7502 Farmdale Avenue, North Hollywood Area","Zip":"91605","City":"Los Angeles","State":"CA","Country":"Los Angeles"},{"OrderNumber":"20004072-GLT","OrderStatus":"Closed","OrderType":"Title only","TransactionType":"Purchase","MarketingRep":"Title Team","Address":"30036 Via Borica","Zip":"90275","City":"Rancho Palos Verdes","State":"CA","Country":"Los Angeles"},{"OrderNumber":"20004077-GLT","OrderStatus":"Closed","OrderType":"Title only","TransactionType":"Purchase","MarketingRep":"Veronica Sanchez","Address":"12907 Sunburst Street","Zip":"91331","City":"Los Angeles","State":"CA","Country":"Los Angeles"},{"OrderNumber":"20004084-OCT","OrderStatus":"Closed","OrderType":"Title only","TransactionType":"Purchase","MarketingRep":"Simon Wu","Address":"2250 Dorris Place","Zip":"90031","City":"Los Angeles","State":"CA","Country":"Los Angeles"},{"OrderNumber":"20004131-GLT","OrderStatus":"Closed","OrderType":"Title only","TransactionType":"Refinance","MarketingRep":"Saeed Ghaffari","Address":"24671 Venablo Drive","Zip":"92691","City":"Mission Viejo","State":"CA","Country":"Orange"},{"OrderNumber":"20004253-GLT","OrderStatus":"InProcess","OrderType":"Title only","TransactionType":"Purchase","MarketingRep":"Team Meza","Address":"3711 E Hedda Street","Zip":"90805","City":"Long Beach","State":"CA","Country":"Los Angeles"},{"OrderNumber":"20004327-GLT","OrderStatus":"Completed","OrderType":"Title only","TransactionType":"Refinance","MarketingRep":"Corey Velasquez","Address":"6945 E Overlook Ter","Zip":"92807","City":"Anaheim","State":"CA","Country":"Orange"},{"OrderNumber":"20004332-OCT","OrderStatus":"InProcess","OrderType":"Title only","TransactionType":"Purchase","MarketingRep":"Sandra Millar","Address":"3315 East Romelle Avenue","Zip":"92869","City":"Orange","State":"CA","Country":"Orange"},{"OrderNumber":"20004349-OCT","OrderStatus":"InProcess","OrderType":"Title only","TransactionType":"Refinance","MarketingRep":"Angeline Wu","Address":"2235 S Beverly Dr","Zip":"90034","City":"Los Angeles","State":"CA","Country":"Los Angeles"},{"OrderNumber":"20004440-GLT","OrderStatus":"InProcess","OrderType":"Title only","TransactionType":"Refinance","MarketingRep":"Linda Ruiz","Address":"1152 N West Street #23","Zip":"92801","City":"Anaheim","State":"CA","Country":"Orange"},{"OrderNumber":"20004449-OCT","OrderStatus":"InProcess","OrderType":"Title only","TransactionType":"Purchase","MarketingRep":"Sonia Flores","Address":"1210 East Cruces Street","Zip":"90744","City":"Wilmington","State":"CA","Country":"Los Angeles"},{"OrderNumber":"20004500-GLT","OrderStatus":"InProcess","OrderType":"Title only","TransactionType":"Purchase","MarketingRep":"Corey Velasquez","Address":"14947 Larch Street","Zip":"92345","City":"Hesperia","State":"CA","Country":"San Bernardino"},{"OrderNumber":"20004688-OCT","OrderStatus":"InProcess","OrderType":"Title only","TransactionType":"Refinance","MarketingRep":"Angeline Wu","Address":"17260 Armintrout Drive","Zip":"92504","City":"Riverside","State":"CA","Country":"Riverside"},{"OrderNumber":"20004725-OCT","OrderStatus":"InProcess","OrderType":"Title only","TransactionType":"Refinance","MarketingRep":"Angeline Wu","Address":"17541 Manchester Avenue","Zip":"92614","City":"Irvine","State":"CA","Country":"Orange"},{"OrderNumber":"20004739-GLT","OrderStatus":"InProcess","OrderType":"Title only","TransactionType":"Purchase","MarketingRep":"Chuck Cota","Address":"24952 Grissom Road","Zip":"92653","City":"Laguna Hills","State":"CA","Country":"Orange"},{"OrderNumber":"20004792-OCT","OrderStatus":"Completed","OrderType":"Title only","TransactionType":"Refinance","MarketingRep":"Angeline Wu","Address":"204 South Shasta Street","Zip":"92869","City":"Orange","State":"CA","Country":"Orange"},{"OrderNumber":"20004893-OCT","OrderStatus":"InProcess","OrderType":"Title only","TransactionType":"Refinance","MarketingRep":"Sandra Millar","Address":"5311 Cole Street","Zip":"92117","City":"San Diego","State":"CA","Country":"San Diego"},{"OrderNumber":"20004923-OCT","OrderStatus":"InProcess","OrderType":"Title only","TransactionType":"Purchase","MarketingRep":"Angeline Wu","Address":"2746 James M Wood Blvd","Zip":"90006","City":"Los Angeles","State":"CA","Country":"Los Angeles"},{"OrderNumber":"20005047-GLT","OrderStatus":"Completed","OrderType":"Title only","TransactionType":"Purchase","MarketingRep":"Lopez Team","Address":"3009 Delburn Street","Zip":"93304","City":"Bakersfield","State":"CA","Country":"Kern"},{"OrderNumber":"20005088-OCT","OrderStatus":"InProcess","OrderType":"Title only","TransactionType":"Purchase","MarketingRep":"David Gomez","Address":"1830 Wilson Avenue","Zip":"91784","City":"Upland","State":"CA","Country":"San Bernardino"},{"OrderNumber":"20005100-GLT","OrderStatus":"Completed","OrderType":"Title only","TransactionType":"Purchase","MarketingRep":"Title Gals","Address":"9958 Artesia Boulevard, Unit #1003","Zip":"90706","City":"Bellflower","State":"CA","Country":"Los Angeles"},{"OrderNumber":"20005164-GLT","OrderStatus":"Completed","OrderType":"Title only","TransactionType":"Purchase","MarketingRep":"Louis Morreale","Address":"5500 Lindley Avenue Unit 206","Zip":"91316","City":"Los Angeles","State":"CA","Country":"Los Angeles"},{"OrderNumber":"20005235-GLT","OrderStatus":"Completed","OrderType":"Title only","TransactionType":"Refinance","MarketingRep":"Ventura House Account","Address":"435 A Court","Zip":"92324","City":"Colton","State":"CA","Country":"San Bernardino"},{"OrderNumber":"20005289-GLT","OrderStatus":"Closed","OrderType":"Title only","TransactionType":"Purchase","MarketingRep":"Lopez Team","Address":"1821 Whispering Bells Road","Zip":"92582","City":"San Jacinto","State":"CA","Country":"Riverside"},{"OrderNumber":"20005292-OCT","OrderStatus":"InProcess","OrderType":"Title & Escrow","TransactionType":"Refinance","MarketingRep":"Sandra Millar","Address":"5332 Franklin Circle","Zip":"92683","City":"Westminster","State":"CA","Country":"Orange"},{"OrderNumber":"20005379-OCT","OrderStatus":"InProcess","OrderType":"Title only","TransactionType":"Refinance","MarketingRep":"Linda Ruiz","Address":"26675 Ironwood","Zip":"92555","City":"Moreno Valley","State":"CA","Country":"Riverside"},{"OrderNumber":"20005546-GLT","OrderStatus":"InProcess","OrderType":"Title only","TransactionType":"Purchase","MarketingRep":"Lopez Team","Address":"3949 Stockbridge Avenue","Zip":"90032","City":"Los Angeles","State":"CA","Country":"Los Angeles"},{"OrderNumber":"20005563-OCT","OrderStatus":"InProcess","OrderType":"Title only","TransactionType":"Refinance","MarketingRep":"Linda Ruiz","Address":"17499 Sequoia Street","Zip":"92345","City":"Hesperia","State":"CA","Country":"San Bernardino"},{"OrderNumber":"20005571-ONT","OrderStatus":"Closed","OrderType":"Title & Escrow","TransactionType":"Purchase","MarketingRep":"Lopez Team","Address":"2372 Palmdale Circle","Zip":"92545","City":"Hemet","State":"CA","Country":"Riverside"},{"OrderNumber":"20005586-GLT","OrderStatus":"Completed","OrderType":"Title only","TransactionType":"Purchase","MarketingRep":"Kevin Green","Address":"29502 Kristine Court","Zip":"91387","City":" ( Canyon Country area)","State":"CA","Country":"Los Angeles"},{"OrderNumber":"20005595-GLT","OrderStatus":"InProcess","OrderType":"Title only","TransactionType":"Purchase","MarketingRep":"Lopez Team","Address":"13546 Rincon Road","Zip":"92308","City":"Apple Valley","State":"CA","Country":"San Bernardino"},{"OrderNumber":"20005613-GLT","OrderStatus":"Closed","OrderType":"Title only","TransactionType":"Refinance","MarketingRep":"Team Meza","Address":"7956 Lindley Avenue","Zip":"91335","City":"Reseda Area, Los Angeles","State":"CA","Country":"Los Angeles"},{"OrderNumber":"20005685-GLT","OrderStatus":"Closed","OrderType":"Title only","TransactionType":"Purchase","MarketingRep":"Ventura House Account","Address":"1043 East 9th Street","Zip":"92223","City":"Beaumont","State":"CA","Country":"Riverside"},{"OrderNumber":"20005699-OCT","OrderStatus":"Closed","OrderType":"Title only","TransactionType":"Refinance","MarketingRep":"Sandra Millar","Address":"600 Cascada Way","Zip":"90049","City":"Los Angeles","State":"CA","Country":"Los Angeles"},{"OrderNumber":"20005719-OCT","OrderStatus":"Completed","OrderType":"Title only","TransactionType":"Refinance","MarketingRep":"Angeline Wu","Address":"3833 Springfield Court","Zip":"93560","City":"Rosamond","State":"CA","Country":"Kern"},{"OrderNumber":"20005724-GLT","OrderStatus":"Completed","OrderType":"Title only","TransactionType":"Refinance","MarketingRep":"Saeed Ghaffari","Address":"431 South Del Sol Lane","Zip":"91765","City":"Diamond Bar","State":"CA","Country":"Los Angeles"},{"OrderNumber":"20005742-GLT","OrderStatus":"Completed","OrderType":"Title only","TransactionType":"Refinance","MarketingRep":"Michael Nouri","Address":"6578 Monte Vista Drive","Zip":"92404","City":"San Bernardino Area","State":"CA","Country":"San Bernardino"},{"OrderNumber":"20005746-GLT","OrderStatus":"InProcess","OrderType":"Title only","TransactionType":"Purchase","MarketingRep":"Simon Wu","Address":"2608 W Grand Avenue","Zip":"91801","City":"Alhambra","State":"CA","Country":"Los Angeles"},{"OrderNumber":"20005769-GLT","OrderStatus":"InProcess","OrderType":"Title only","TransactionType":"Purchase","MarketingRep":"Team Meza","Address":"4162 South Budlong Avenue","Zip":"90037","City":"Los Angeles","State":"CA","Country":"Los Angeles"},{"OrderNumber":"20005880-OCT","OrderStatus":"Completed","OrderType":"Title only","TransactionType":"Purchase","MarketingRep":"Richard Bohn","Address":"3970 Scott Drive","Zip":"92008","City":"Carlsbad","State":"CA","Country":"San Diego"},{"OrderNumber":"20005894-OCT","OrderStatus":"InProcess","OrderType":"Title & Escrow","TransactionType":"Refinance","MarketingRep":"Sandra Millar","Address":"4 Inverness Lane","Zip":"92660","City":"Newport Beach","State":"CA","Country":"Orange"},{"OrderNumber":"20005898-GLT","OrderStatus":"InProcess","OrderType":"Title only","TransactionType":"Purchase","MarketingRep":"Lopez Team","Address":"4062 Running Oak Lane","Zip":"92407","City":"San Bernardino","State":"CA","Country":"San Bernardino"},{"OrderNumber":"20005901-GLT","OrderStatus":"InProcess","OrderType":"Title only","TransactionType":"Refinance","MarketingRep":"Kevin Green","Address":"8011 Woodman Avenue, Panorama City area","Zip":"91402","City":"Los Angeles","State":"CA","Country":"Los Angeles"},{"OrderNumber":"20005929-GLT","OrderStatus":"InProcess","OrderType":"Title only","TransactionType":"Refinance","MarketingRep":"Team Meza","Address":"1014 East 75th Street","Zip":"90001","City":"Los Angeles","State":"CA","Country":"Los Angeles"},{"OrderNumber":"20005950-GLT","OrderStatus":"InProcess","OrderType":"Title only","TransactionType":"Purchase","MarketingRep":"Justin Nouri","Address":"1449 E 75th Street","Zip":"90001","City":"Los Angeles","State":"CA","Country":"Los Angeles"},{"OrderNumber":"20005955-OCT","OrderStatus":"Closed","OrderType":"Title only","TransactionType":"Purchase","MarketingRep":"Richard Bohn","Address":"1408 South Burris Avenue","Zip":"90221","City":"Compton","State":"CA","Country":"Los Angeles"},{"OrderNumber":"20006004-GLT","OrderStatus":"Closed","OrderType":"Title only","TransactionType":"Refinance","MarketingRep":"Veronica Sanchez","Address":"21620 Calhoun Drive","Zip":"93505","City":"California City","State":"CA","Country":"Kern"},{"OrderNumber":"20006025-GLT","OrderStatus":"InProcess","OrderType":"Title only","TransactionType":"Purchase","MarketingRep":"Team Meza","Address":"26597 Meridian Street","Zip":"92544","City":"Hemet","State":"CA","Country":"Riverside"},{"OrderNumber":"99100373","OrderStatus":"Closed","OrderType":"Trustee Sale Guarantee","TransactionType":"Other","MarketingRep":"Sandra Millar","Address":"21605 DEL AMO STREET","Zip":"92557","City":"Moreno Valley","State":"CA","Country":"Riverside"},{"OrderNumber":"20006129-GLT","OrderStatus":"InProcess","OrderType":"Title only","TransactionType":"Purchase","MarketingRep":"Glendale  House Account","Address":"7868 Sea Salt Avenue","Zip":"92336","City":"Fontana","State":"CA","Country":"San Bernardino"},{"OrderNumber":"20006152-OCT","OrderStatus":"Closed","OrderType":"Title only","TransactionType":"Refinance","MarketingRep":"Angeline Wu","Address":"1764 West Coast Boulevard","Zip":"92377","City":"Rialto","State":"CA","Country":"San Bernardino"},{"OrderNumber":"20006186-OCT","OrderStatus":"InProcess","OrderType":"Title & Escrow","TransactionType":"Refinance","MarketingRep":"Sandra Millar","Address":"27699 Barcelona Avenue","Zip":"94545","City":"Hayward","State":"CA","Country":"Alameda"},{"OrderNumber":"20006242-GLT","OrderStatus":"InProcess","OrderType":"Title only","TransactionType":"Purchase","MarketingRep":"Ventura House Account","Address":"17772 Hurley Street","Zip":"91744","City":"Los Angeles","State":"CA","Country":"Los Angeles"},{"OrderNumber":"20006253-OCT","OrderStatus":"InProcess","OrderType":"Title only","TransactionType":"Purchase","MarketingRep":"Angeline Wu","Address":"1784 Del Mar Avenue","Zip":"92651","City":"Laguna Beach","State":"CA","Country":"Orange"},{"OrderNumber":"20006262-OCT","OrderStatus":"Closed","OrderType":"Title only","TransactionType":"Purchase","MarketingRep":"Ventura House Account","Address":"13643 Alcade Street","Zip":"91746","City":"(La Puente Area)","State":"CA","Country":"Los Angeles"},{"OrderNumber":"20006273-OCT","OrderStatus":"InProcess","OrderType":"Title only","TransactionType":"Refinance","MarketingRep":"Orange County House Account","Address":"862 Seneca Drive","Zip":"95969","City":"Paradise","State":"CA","Country":"Butte"},{"OrderNumber":"20006283-OCT","OrderStatus":"Completed","OrderType":"Title only","TransactionType":"Refinance","MarketingRep":"Angeline Wu","Address":"11038 Lavender Ave","Zip":"92708","City":"Fountain Valley","State":"CA","Country":"Orange"},{"OrderNumber":"20006304-GLT","OrderStatus":"InProcess","OrderType":"Title only","TransactionType":"Purchase","MarketingRep":"David Gomez","Address":"20267 Clear River Lane #7","Zip":"92886","City":"Yorba Linda","State":"CA","Country":"Orange"},{"OrderNumber":"20006339-OCT","OrderStatus":"Closed","OrderType":"Title only","TransactionType":"Refinance","MarketingRep":"Angeline Wu","Address":"18741 Wingfoot Court","Zip":"93561","City":"Tehachapi","State":"CA","Country":"Kern"},{"OrderNumber":"20006343-GLT","OrderStatus":"Closed","OrderType":"Title only","TransactionType":"Purchase","MarketingRep":"Justin Nouri","Address":"2633 Barnacle Cove","Zip":"93041","City":"Port Hueneme","State":"CA","Country":"Ventura"},{"OrderNumber":"20006362-OCT","OrderStatus":"InProcess","OrderType":"Title only","TransactionType":"Refinance","MarketingRep":"Angeline Wu","Address":"247 S St Andrews Pl","Zip":"90004","City":"Los Angeles","State":"CA","Country":"Los Angeles"},{"OrderNumber":"20006368-OCT","OrderStatus":"Completed","OrderType":"Title only","TransactionType":"Purchase","MarketingRep":"Richard Bohn","Address":"4055 Crystal Dawn Lane #202","Zip":"92122","City":"San Diego","State":"CA","Country":"San Diego"},{"OrderNumber":"20006384-OCT","OrderStatus":"Closed","OrderType":"Title only","TransactionType":"Refinance","MarketingRep":"Sandra Millar","Address":"2449 Moonstone Drive","Zip":"92123-3510","City":"San Diego","State":"CA","Country":"San Diego"},{"OrderNumber":"20006457-OCT","OrderStatus":"Completed","OrderType":"Title only","TransactionType":"Refinance","MarketingRep":"Sonia Flores","Address":"7714 Date Court","Zip":"92336","City":"Fontana","State":"CA","Country":"San Bernardino"},{"OrderNumber":"20006468-GLT","OrderStatus":"Closed","OrderType":"Title only","TransactionType":"Refinance","MarketingRep":"David Gomez","Address":"2433 Gaspar Avenue","Zip":"90040","City":"Commerce","State":"CA","Country":"Los Angeles"},{"OrderNumber":"20006475-GLT","OrderStatus":"Completed","OrderType":"Title only","TransactionType":"Purchase","MarketingRep":"Simon Wu","Address":"703 Calle Cumbre","Zip":"92673","City":"San Clemente","State":"CA","Country":"Orange"},{"OrderNumber":"20006481-GLT","OrderStatus":"Completed","OrderType":"Title only","TransactionType":"Purchase","MarketingRep":"Lopez Team","Address":"254 Roundabout Dr","Zip":"91744","City":"La Puente","State":"CA","Country":"Los Angeles"},{"OrderNumber":"20006485-OCT","OrderStatus":"Completed","OrderType":"Title only","TransactionType":"Refinance","MarketingRep":"David Gomez","Address":"7245 Latrobe Circle","Zip":"92139","City":"San Diego","State":"CA","Country":"San Diego"},{"OrderNumber":"20006509-PRV","OrderStatus":"InProcess","OrderType":"Title & Escrow","TransactionType":"Purchase","MarketingRep":"Orange County House Account","Address":"572 North Verdugo Street","Zip":"93257","City":"Porterville","State":"CA","Country":"Tulare"},{"OrderNumber":"20006525-OCT","OrderStatus":"Completed","OrderType":"Title only","TransactionType":"Refinance","MarketingRep":"Jane Phan","Address":"3627 E 4th Street","Zip":"90814","City":"Long Beach","State":"CA","Country":"Los Angeles"},{"OrderNumber":"20006533-GLT","OrderStatus":"Closed","OrderType":"Title only","TransactionType":"Refinance","MarketingRep":"Lopez Team","Address":"28855 Long Street","Zip":"92567","City":"Nuevo","State":"CA","Country":"Riverside"},{"OrderNumber":"20006548-GLT","OrderStatus":"InProcess","OrderType":"Title only","TransactionType":"Purchase","MarketingRep":"Ventura House Account","Address":"10815 Plumas Rd","Zip":"91701","City":"Rancho Cucamonga","State":"CA","Country":"San Bernardino"},{"OrderNumber":"20006566-OCT","OrderStatus":"Completed","OrderType":"Title only","TransactionType":"Refinance","MarketingRep":"Angeline Wu","Address":"5245 East Blossom Lane","Zip":"93725","City":"Fresno","State":"CA","Country":"Fresno"},{"OrderNumber":"20006569-OCT","OrderStatus":"InProcess","OrderType":"Title only","TransactionType":"Purchase","MarketingRep":"Sonia Flores","Address":"3541 Fashion Avenue","Zip":"90810","City":"Long Beach","State":"CA","Country":"Los Angeles"},{"OrderNumber":"20006570-OCT","OrderStatus":"Completed","OrderType":"Title only","TransactionType":"Refinance","MarketingRep":"Linda Ruiz","Address":"5041 Paseo Segovia","Zip":"92603","City":"Irvine","State":"CA","Country":"Orange"},{"OrderNumber":"20006611-GLT","OrderStatus":"InProcess","OrderType":"Title only","TransactionType":"Purchase","MarketingRep":"Louis Morreale","Address":"8641 Glenoaks Boulevard","Zip":"91352","City":"Sun Valley area","State":"CA","Country":"Los Angeles"},{"OrderNumber":"20006618-GLT","OrderStatus":"Closed","OrderType":"Title only","TransactionType":"Purchase","MarketingRep":"Title Gals","Address":"80240 Platinum Way","Zip":"92253","City":"La Quinta","State":"CA","Country":"Riverside"},{"OrderNumber":"20006633-GLT","OrderStatus":"Completed","OrderType":"Title only","TransactionType":"Refinance","MarketingRep":"Corey Velasquez","Address":"1664 Emerald Point Court","Zip":"92019","City":"El Cajon","State":"CA","Country":"San Diego"},{"OrderNumber":"20006643-OCT","OrderStatus":"InProcess","OrderType":"Title & Escrow","TransactionType":"Refinance","MarketingRep":"Sandra Millar","Address":"31 East Ellis Street","Zip":"90805","City":"Long Beach","State":"CA","Country":"Los Angeles"},{"OrderNumber":"20006646-OCT","OrderStatus":"Completed","OrderType":"Title only","TransactionType":"Refinance","MarketingRep":"Sandra Millar","Address":"2 Camino Del Monte","Zip":"94563","City":"Orinda","State":"CA","Country":"Contra Costa"},{"OrderNumber":"20006654-GLT","OrderStatus":"InProcess","OrderType":"Title only","TransactionType":"Purchase","MarketingRep":"Lopez Team","Address":"3070 Santo Tomas Avenue","Zip":"92571","City":"Perris","State":"CA","Country":"Riverside"},{"OrderNumber":"20006658-OCT","OrderStatus":"InProcess","OrderType":"Title only","TransactionType":"Purchase","MarketingRep":"Ventura House Account","Address":"6505 Emil Avenue","Zip":"90201","City":"Bell Gardens","State":"CA","Country":"Los Angeles"},{"OrderNumber":"20006706-GLT","OrderStatus":"InProcess","OrderType":"Title only","TransactionType":"Purchase","MarketingRep":"Lopez Team","Address":"24910 Alessandro Blvd","Zip":"92553","City":"Moreno Valley","State":"CA","Country":"Riverside"},{"OrderNumber":"20006722-OCT","OrderStatus":"Completed","OrderType":"Title only","TransactionType":"Refinance","MarketingRep":"Sonia Flores","Address":"5484 Cedar Street","Zip":"92509","City":"Jurupa Valley","State":"CA","Country":"Riverside"},{"OrderNumber":"20006728-OCT","OrderStatus":"InProcess","OrderType":"Title only","TransactionType":"Refinance","MarketingRep":"Corey Velasquez","Address":"112 East Madison Avenue","Zip":"92020","City":"El Cajon","State":"CA","Country":"San Diego"},{"OrderNumber":"20006730-GLT","OrderStatus":"Completed","OrderType":"Title only","TransactionType":"Purchase","MarketingRep":"Veronica Sanchez","Address":"36633 Silverspur Lane","Zip":"93550","City":"Palmdale","State":"CA","Country":"Los Angeles"},{"OrderNumber":"20006788-GLT","OrderStatus":"Closed","OrderType":"Title only","TransactionType":"Purchase","MarketingRep":"Simon Wu","Address":"9637 Seville Way","Zip":"90630","City":"Cypress","State":"CA","Country":"Orange"},{"OrderNumber":"20006789-GLT","OrderStatus":"InProcess","OrderType":"Title only","TransactionType":"Purchase","MarketingRep":"Team Meza","Address":"1452 West 60th Street","Zip":"90047","City":"Los Angeles","State":"CA","Country":"Los Angeles"},{"OrderNumber":"20006813-OCT","OrderStatus":"Completed","OrderType":"Title only","TransactionType":"Purchase","MarketingRep":"Sonia Flores","Address":"945 South Woods Avenue","Zip":"90022","City":"Los Angeles","State":"CA","Country":"Los Angeles"},{"OrderNumber":"20006843-OCT","OrderStatus":"Completed","OrderType":"Title only","TransactionType":"Purchase","MarketingRep":"Nicholas Watt","Address":"3 Red Rock Lane","Zip":"92677-5653","City":"Laguna Niguel","State":"CA","Country":"Orange"},{"OrderNumber":"20006846-GLT","OrderStatus":"InProcess","OrderType":"Title only","TransactionType":"Refinance","MarketingRep":"Kevin Green","Address":"340 N Griffith Park Drive","Zip":"91506","City":"Burbank","State":"CA","Country":"Los Angeles"},{"OrderNumber":"20006887-OCT","OrderStatus":"InProcess","OrderType":"Escrow only","TransactionType":"Refinance","MarketingRep":"Jorge Mesa","Address":"1512 North Chester Ave","Zip":"90221","City":"Compton","State":"CA","Country":"Los Angeles"},{"OrderNumber":"20006889-OCT","OrderStatus":"InProcess","OrderType":"Escrow only","TransactionType":"Refinance","MarketingRep":"Jorge Mesa","Address":"14667 Navajo Road","Zip":"92307","City":"Apple Valley","State":"CA","Country":"San Bernardino"},{"OrderNumber":"20006890-OCT","OrderStatus":"InProcess","OrderType":"Escrow only","TransactionType":"Refinance","MarketingRep":"Jorge Mesa","Address":"14146 Gladside Drive","Zip":"90638","City":"La Mirada","State":"CA","Country":"Los Angeles"},{"OrderNumber":"20006913-GLT","OrderStatus":"Completed","OrderType":"Title only","TransactionType":"Refinance","MarketingRep":"Ventura House Account","Address":"12835 10th Street #21","Zip":"91710","City":"Chino","State":"CA","Country":"San Bernardino"},{"OrderNumber":"20006923-OCT","OrderStatus":"InProcess","OrderType":"Escrow only","TransactionType":"Refinance","MarketingRep":"Jorge Mesa","Address":"11766 Angell Street","Zip":"90650","City":"Norwalk","State":"CA","Country":"Los Angeles"},{"OrderNumber":"20006975-GLT","OrderStatus":"Closed","OrderType":"Title only","TransactionType":"Purchase","MarketingRep":"Team Meza","Address":"203 W Reeve St","Zip":"90220","City":"Compton","State":"CA","Country":"Los Angeles"},{"OrderNumber":"20006980-OCT","OrderStatus":"Completed","OrderType":"Title only","TransactionType":"Refinance","MarketingRep":"Sonia Flores","Address":"2190 East Greenway Drive","Zip":"85282","City":"Tempe","State":"AZ","Country":"Maricopa"},{"OrderNumber":"20006983-OCT","OrderStatus":"InProcess","OrderType":"Title only","TransactionType":"Refinance","MarketingRep":"Orange County House Account","Address":"2233 East Catalina Avenue","Zip":"92705","City":"Santa Ana","State":"CA","Country":"Orange"},{"OrderNumber":"20007092-PRV","OrderStatus":"InProcess","OrderType":"Title & Escrow","TransactionType":"Purchase","MarketingRep":"Orange County House Account","Address":"601 South Avery Avenue","Zip":"93223-1909","City":"Farmersville","State":"CA","Country":"Tulare"},{"OrderNumber":"20007097-GLT","OrderStatus":"Completed","OrderType":"Title only","TransactionType":"Purchase","MarketingRep":"Kevin Green","Address":"9431 Irene Avenue","Zip":"93505","City":"California City","State":"CA","Country":"Kern"},{"OrderNumber":"20007115-GLT","OrderStatus":"Closed","OrderType":"Title only","TransactionType":"Purchase","MarketingRep":"Title Team","Address":"1308 Golden Coast Lane","Zip":"91748","City":"Rowland Heights area","State":"CA","Country":"Los Angeles"},{"OrderNumber":"20007150-GLT","OrderStatus":"InProcess","OrderType":"Title only","TransactionType":"Purchase","MarketingRep":"Team Meza","Address":"3746 Vineland Avenue","Zip":"91706","City":"Baldwin Park","State":"CA","Country":"Los Angeles"},{"OrderNumber":"20007154-OCT","OrderStatus":"Closed","OrderType":"Title only","TransactionType":"Refinance","MarketingRep":"Jane Phan","Address":"9701 Oma Place","Zip":"92841","City":"Garden Grove","State":"CA","Country":"Orange"},{"OrderNumber":"20007155-OCT","OrderStatus":"Closed","OrderType":"Title only","TransactionType":"Refinance","MarketingRep":"Angeline Wu","Address":"35153 El Diamante Drive","Zip":"92595","City":"Wildomar","State":"CA","Country":"Riverside"},{"OrderNumber":"20007166-GLT","OrderStatus":"InProcess","OrderType":"Title only","TransactionType":"Purchase","MarketingRep":"Title Team","Address":"21801 Calhoun Drive","Zip":"93505","City":"California City","State":"CA","Country":"Kern"},{"OrderNumber":"20007189-OCT","OrderStatus":"Closed","OrderType":"Title only","TransactionType":"Refinance","MarketingRep":"Jane Phan","Address":"9057 W Bluff Place","Zip":"92071","City":"Unincorporated Area of Santee","State":"CA","Country":"San Diego"},{"OrderNumber":"20007211-OCT","OrderStatus":"InProcess","OrderType":"Title only","TransactionType":"Purchase","MarketingRep":"Linda Ruiz","Address":"320 West Acacia Avenue","Zip":"92543","City":"Hemet","State":"CA","Country":"Riverside"},{"OrderNumber":"20007229-GLT","OrderStatus":"Closed","OrderType":"Title only","TransactionType":"Purchase","MarketingRep":"Team Meza","Address":"12782 Riggins Road","Zip":"92371","City":"Phelan area","State":"CA","Country":"San Bernardino"},{"OrderNumber":"20007231-GLT","OrderStatus":"InProcess","OrderType":"Title only","TransactionType":"Purchase","MarketingRep":"Lopez Team","Address":"26873 Mossway Street","Zip":"92346","City":"Highland","State":"CA","Country":"San Bernardino"},{"OrderNumber":"20007252-OCT","OrderStatus":"InProcess","OrderType":"Title & Escrow","TransactionType":"Refinance","MarketingRep":"Sandra Millar","Address":"1205 North Mclane Road","Zip":"85541","City":"Payson","State":"AZ","Country":"Gila"},{"OrderNumber":"20007271-OCT","OrderStatus":"Closed","OrderType":"Title only","TransactionType":"Refinance","MarketingRep":"Angeline Wu","Address":"10531 Imperial Highway","Zip":"90650","City":"Norwalk","State":"CA","Country":"Los Angeles"},{"OrderNumber":"20007279-OCT","OrderStatus":"Closed","OrderType":"Title only","TransactionType":"Refinance","MarketingRep":"Sandra Millar","Address":"45798 West Valeria Avenue","Zip":"93620","City":"Dos Palos","State":"CA","Country":"Merced"},{"OrderNumber":"20007308-OCT","OrderStatus":"Closed","OrderType":"Title only","TransactionType":"Refinance","MarketingRep":"Angeline Wu","Address":"1732 Park Place Lane","Zip":"92501","City":"Riverside","State":"CA","Country":"Riverside"},{"OrderNumber":"20007310-GLT","OrderStatus":"InProcess","OrderType":"Title only","TransactionType":"Purchase","MarketingRep":"Lopez Team","Address":"8447 45th Street","Zip":"92509","City":"Jurupa Valley","State":"CA","Country":"Riverside"},{"OrderNumber":"20007316-GLT","OrderStatus":"Completed","OrderType":"Title only","TransactionType":"Refinance","MarketingRep":"Michael Nouri","Address":"21053 Burton Street, Canoga Park Area","Zip":"91304","City":"Los Angeles","State":"CA","Country":"Los Angeles"},{"OrderNumber":"20007342-OCT","OrderStatus":"Closed","OrderType":"Title only","TransactionType":"Refinance","MarketingRep":"Angeline Wu","Address":"11433 Mountain View Drive, Unit 5","Zip":"91730","City":"Rancho Cucamonga","State":"CA","Country":"San Bernardino"},{"OrderNumber":"20007344-GLT","OrderStatus":"InProcess","OrderType":"Title only","TransactionType":"Purchase","MarketingRep":"Team Meza","Address":"9716 Oak Street","Zip":"90706","City":"Bellflower","State":"CA","Country":"Los Angeles"},{"OrderNumber":"20007346-GLT","OrderStatus":"Completed","OrderType":"Title only","TransactionType":"Purchase","MarketingRep":"David Gomez","Address":"3994 Modesto Drive","Zip":"92404","City":"San Bernardino","State":"CA","Country":"San Bernardino"},{"OrderNumber":"20007354-OCT","OrderStatus":"InProcess","OrderType":"Title only","TransactionType":"Refinance","MarketingRep":"Angeline Wu","Address":"64827  3rd Street South","Zip":"92252","City":"Joshua Tree","State":"CA","Country":"San Bernardino"},{"OrderNumber":"20007375-OCT","OrderStatus":"InProcess","OrderType":"Title only","TransactionType":"Purchase","MarketingRep":"Nicholas Watt","Address":"10 Agave Court","Zip":"92694","City":"Mission Viejo","State":"CA","Country":"Orange"},{"OrderNumber":"20007383-OCT","OrderStatus":"InProcess","OrderType":"Title & Escrow","TransactionType":"Refinance","MarketingRep":"Richard Bohn","Address":"4 Leatherwood Way","Zip":"92612","City":"Irvine","State":"CA","Country":"Orange"},{"OrderNumber":"20007390-OCT","OrderStatus":"Closed","OrderType":"Title only","TransactionType":"Purchase","MarketingRep":"Richard Bohn","Address":"1756 North 1st Street","Zip":"92021","City":"El Cajon","State":"CA","Country":"San Diego"},{"OrderNumber":"20007403-OCT","OrderStatus":"InProcess","OrderType":"Title only","TransactionType":"Purchase","MarketingRep":"Nicholas Watt","Address":"23892 Hillhurst Drive","Zip":"92677","City":"Laguna Niguel","State":"CA","Country":"Orange"},{"OrderNumber":"20007425-OCT","OrderStatus":"Closed","OrderType":"Title only","TransactionType":"Refinance","MarketingRep":"Zaccaria Ackad","Address":"1832 Via Rancho Parkway","Zip":"92029","City":"Escondido","State":"CA","Country":"San Diego"},{"OrderNumber":"20007447-GLT","OrderStatus":"Completed","OrderType":"Title only","TransactionType":"Purchase","MarketingRep":"Ventura House Account","Address":"4419 Radium Drive","Zip":"90032","City":"Los Angeles","State":"CA","Country":"Los Angeles"},{"OrderNumber":"20007448-OCT","OrderStatus":"Closed","OrderType":"Title only","TransactionType":"Refinance","MarketingRep":"Nini Kerns","Address":"19394 Avenue 304","Zip":"93221-9551","City":"Exeter","State":"CA","Country":"Tulare"},{"OrderNumber":"20007449-GLT","OrderStatus":"Closed","OrderType":"Title only","TransactionType":"Refinance","MarketingRep":"Tony Baumgartner","Address":"2226 South La Brea Avenue","Zip":"90016","City":"Los Angeles","State":"CA","Country":"Los Angeles"},{"OrderNumber":"20007490-GLT","OrderStatus":"Closed","OrderType":"Title only","TransactionType":"Purchase","MarketingRep":"Simon Wu","Address":"312 West Palm Drive","Zip":"91007","City":"Arcadia","State":"CA","Country":"Los Angeles"},{"OrderNumber":"20007521-GLT","OrderStatus":"Closed","OrderType":"Title only","TransactionType":"Purchase","MarketingRep":"Team Meza","Address":"230 E Ellis Street","Zip":"90805","City":"Long Beach","State":"CA","Country":"Los Angeles"},{"OrderNumber":"20007552-GLT","OrderStatus":"Closed","OrderType":"Title only","TransactionType":"Purchase","MarketingRep":"Sonia Flores","Address":"109 South San Antonio Avenue","Zip":"91786","City":"Upland","State":"CA","Country":"San Bernardino"},{"OrderNumber":"20007561-ONT","OrderStatus":"InProcess","OrderType":"Title & Escrow","TransactionType":"Refinance","MarketingRep":"Saeed Ghaffari","Address":"2428 Highland Avenue","Zip":"91950","City":"National City","State":"CA","Country":"San Diego"},{"OrderNumber":"20007572-OCT","OrderStatus":"Closed","OrderType":"Title only","TransactionType":"Refinance","MarketingRep":"Angeline Wu","Address":"2750 W 182nd Street Unit 126","Zip":"90504","City":"Torrance","State":"CA","Country":"Los Angeles"},{"OrderNumber":"20007581-GLT","OrderStatus":"Closed","OrderType":"Title only","TransactionType":"Purchase","MarketingRep":"Lopez Team","Address":"1394 Cross Street","Zip":"92404","City":"San Bernardino","State":"CA","Country":"San Bernardino"},{"OrderNumber":"20007589-OCT","OrderStatus":"Completed","OrderType":"Title only","TransactionType":"Refinance","MarketingRep":"Sandra Millar","Address":"214 Scenic Avenue","Zip":"94611","City":"Piedmont","State":"CA","Country":"Alameda"},{"OrderNumber":"20007602-GLT","OrderStatus":"Closed","OrderType":"Title only","TransactionType":"Purchase","MarketingRep":"Glendale  House Account","Address":"1526 W 71st Street","Zip":"90047","City":"Los Angeles","State":"CA","Country":"Los Angeles"},{"OrderNumber":"20007618-GLT","OrderStatus":"Closed","OrderType":"Title only","TransactionType":"Refinance","MarketingRep":"Veronica Sanchez","Address":"11233 Gaynor Avenue, Granada Hills Area","Zip":"91344","City":"Los Angeles","State":"CA","Country":"Los Angeles"},{"OrderNumber":"20007629-GLT","OrderStatus":"Closed","OrderType":"Title only","TransactionType":"Refinance","MarketingRep":"Veronica Sanchez","Address":"9701 Mercedes Avenue,  Arleta Area","Zip":"91331","City":"Los Angeles","State":"CA","Country":"Los Angeles"},{"OrderNumber":"20007632-GLT","OrderStatus":"InProcess","OrderType":"Title & Escrow","TransactionType":"Purchase","MarketingRep":"Corey Velasquez","Address":"0 Vacant Land / APN#064-133-07-00","Zip":"93555","City":"Inyokern","State":"CA","Country":"Kern"},{"OrderNumber":"20007634-GLT","OrderStatus":"Closed","OrderType":"Title only","TransactionType":"Refinance","MarketingRep":"Ventura House Account","Address":"157 S Cerritos Ave","Zip":"91702","City":"Azusa","State":"CA","Country":"Los Angeles"},{"OrderNumber":"20007640-OCT","OrderStatus":"InProcess","OrderType":"Title only","TransactionType":"Refinance","MarketingRep":"Richard Bohn","Address":"307 Taylor Street","Zip":"92084","City":"Vista","State":"CA","Country":"San Diego"},{"OrderNumber":"20007670-GLT","OrderStatus":"Closed","OrderType":"Title only","TransactionType":"Purchase","MarketingRep":"Kevin Green","Address":"5001 Petit Avenue (Encino Area)","Zip":"91436","City":"Los Angeles","State":"CA","Country":"Los Angeles"},{"OrderNumber":"20007675-OCT","OrderStatus":"Closed","OrderType":"Title only","TransactionType":"Purchase","MarketingRep":"Angeline Wu","Address":"3211 West Jeffries Avenue","Zip":"91505","City":"Burbank","State":"CA","Country":"Los Angeles"},{"OrderNumber":"20007687-OCT","OrderStatus":"Closed","OrderType":"Title only","TransactionType":"Purchase","MarketingRep":"Nicholas Watt","Address":"21351 Birdhollow Drive","Zip":"92679","City":"Trabuco Canyon","State":"CA","Country":"Orange"},{"OrderNumber":"20007689-OCT","OrderStatus":"InProcess","OrderType":"Title only","TransactionType":"Refinance","MarketingRep":"Angeline Wu","Address":"414 S 2nd Avenue, D","Zip":"91006","City":"Arcadia","State":"CA","Country":"Los Angeles"},{"OrderNumber":"20007709-GLT","OrderStatus":"InProcess","OrderType":"Title only","TransactionType":"Purchase","MarketingRep":"Simon Wu","Address":"14751 Palmera Court","Zip":"91706","City":"Baldwin Park","State":"CA","Country":"Los Angeles"},{"OrderNumber":"20007713-OCT","OrderStatus":"Closed","OrderType":"Title only","TransactionType":"Refinance","MarketingRep":"Sandra Millar","Address":"2259 Devon Place","Zip":"95035","City":"Milpitas","State":"CA","Country":"Santa Clara"},{"OrderNumber":"20007718-GLT","OrderStatus":"Closed","OrderType":"Title only","TransactionType":"Purchase","MarketingRep":"Justin Nouri","Address":"201 Featherstone Street","Zip":"93030","City":"Oxnard","State":"CA","Country":"Ventura"},{"OrderNumber":"20007722-GLT","OrderStatus":"Closed","OrderType":"Title only","TransactionType":"Purchase","MarketingRep":"Simon Wu","Address":"6 Woodland Lane","Zip":"91006","City":"Arcadia","State":"CA","Country":"Los Angeles"},{"OrderNumber":"20007733-GLT","OrderStatus":"InProcess","OrderType":"Title only","TransactionType":"Purchase","MarketingRep":"Kevin Green","Address":"13079 Eustace Street","Zip":"91331","City":"Los Angeles","State":"CA","Country":"Los Angeles"},{"OrderNumber":"20007750-OCT","OrderStatus":"Completed","OrderType":"Title only","TransactionType":"Refinance","MarketingRep":"Angeline Wu","Address":"625 South Berendo Street., #307","Zip":"90005","City":"Los Angeles","State":"CA","Country":"Los Angeles"},{"OrderNumber":"20007751-OCT","OrderStatus":"Closed","OrderType":"Title only","TransactionType":"Refinance","MarketingRep":"Sandra Millar","Address":"3104 Coyote Circle","Zip":"94517","City":"Clayton","State":"CA","Country":"Contra Costa"},{"OrderNumber":"20007774-OCT","OrderStatus":"Closed","OrderType":"Title only","TransactionType":"Refinance","MarketingRep":"Sandra Millar","Address":"1034 Bath Street","Zip":"93101","City":"Santa Barbara","State":"CA","Country":"Santa Barbara"},{"OrderNumber":"20007775-OCT","OrderStatus":"InProcess","OrderType":"Title only","TransactionType":"Purchase","MarketingRep":"Angeline Wu","Address":"17204 Guarda Drive","Zip":"91709","City":"Chino Hills","State":"CA","Country":"San Bernardino"},{"OrderNumber":"20007779-OCT","OrderStatus":"Closed","OrderType":"Title only","TransactionType":"Purchase","MarketingRep":"Nicholas Watt","Address":"716 Avenida Columbo","Zip":"92672","City":"San Clemente","State":"CA","Country":"Orange"},{"OrderNumber":"20007801-OCT","OrderStatus":"Closed","OrderType":"Title only","TransactionType":"Refinance","MarketingRep":"Sonia Flores","Address":"31910 Ariel Ct","Zip":"92586","City":"Menifee","State":"CA","Country":"Riverside"},{"OrderNumber":"20007804-GLT","OrderStatus":"Closed","OrderType":"Title only","TransactionType":"Refinance","MarketingRep":"Lopez Team","Address":"39583 Sunrose Dr","Zip":"92562","City":"Murrieta","State":"CA","Country":"Riverside"},{"OrderNumber":"20007812-OCT","OrderStatus":"Closed","OrderType":"Title only","TransactionType":"Purchase","MarketingRep":"Christy Coffey","Address":"19009 Sherman Way, Unit 22, (Reseda Area)","Zip":"91335","City":"Los Angeles","State":"CA","Country":"Los Angeles"},{"OrderNumber":"20007816-OCT","OrderStatus":"Closed","OrderType":"Title only","TransactionType":"Refinance","MarketingRep":"Nicholas Watt","Address":"5535 East 16th Street","Zip":"94621","City":"Oakland","State":"CA","Country":"Alameda"},{"OrderNumber":"20007821-GLT","OrderStatus":"InProcess","OrderType":"Title only","TransactionType":"Refinance","MarketingRep":"Kevin Green","Address":"1929 Olivera Drive","Zip":"91301","City":"Agoura Hills","State":"CA","Country":"Los Angeles"},{"OrderNumber":"20007830-GLT","OrderStatus":"Closed","OrderType":"Title only","TransactionType":"Refinance","MarketingRep":"Title Team","Address":"1131 Singing Wood Drive","Zip":"91006","City":"Arcadia","State":"CA","Country":"Los Angeles"},{"OrderNumber":"20007841-OCT","OrderStatus":"InProcess","OrderType":"Title only","TransactionType":"Refinance","MarketingRep":"Sonia Flores","Address":"1127 Montana Street","Zip":"93905","City":"Salinas","State":"CA","Country":"Monterey"},{"OrderNumber":"20007844-GLT","OrderStatus":"Closed","OrderType":"Title only","TransactionType":"Refinance","MarketingRep":"Kevin Green","Address":"8031 Nestle Avenue","Zip":"91335","City":"Reseda","State":"CA","Country":"Los Angeles"},{"OrderNumber":"20007851-GLT","OrderStatus":"Closed","OrderType":"Title only","TransactionType":"Purchase","MarketingRep":"David Gomez","Address":"16652 E. Masline Street","Zip":"91722","City":"Covina","State":"CA","Country":"Los Angeles"},{"OrderNumber":"99100438","OrderStatus":"Closed","OrderType":"Trustee Sale Guarantee","TransactionType":"Other","MarketingRep":"Sandra Millar","Address":"4248 ADRIATIC SEA WAY","Zip":"95834","City":"Sacramento","State":"CA","Country":"Sacramento"},{"OrderNumber":"20007883-OCT","OrderStatus":"InProcess","OrderType":"Title only","TransactionType":"Refinance","MarketingRep":"Angeline Wu","Address":"2316 Mesa Verde","Zip":"92833","City":"Fullerton","State":"CA","Country":"Orange"},{"OrderNumber":"20007890-OCT","OrderStatus":"Closed","OrderType":"Title & Escrow","TransactionType":"Refinance","MarketingRep":"Sonia Flores","Address":"27847 St. Bernard Lane","Zip":"92352","City":"Lake Arrowhead","State":"CA","Country":"San Bernardino"},{"OrderNumber":"20007898-GLT","OrderStatus":"Closed","OrderType":"Title only","TransactionType":"Refinance","MarketingRep":"Kevin Green","Address":"1333 W 98th St","Zip":"90044","City":"Los Angeles","State":"CA","Country":"Los Angeles"},{"OrderNumber":"20007907-OCT","OrderStatus":"InProcess","OrderType":"Title only","TransactionType":"Purchase","MarketingRep":"Ventura House Account","Address":"16280 Lorene Drive","Zip":"92395","City":"Victorville","State":"CA","Country":"San Bernardino"},{"OrderNumber":"20007916-OCT","OrderStatus":"InProcess","OrderType":"Title & Escrow","TransactionType":"Refinance","MarketingRep":"Richard Bohn","Address":"422 Andrew Avenue","Zip":"92024","City":"Encinitas","State":"CA","Country":"San Diego"},{"OrderNumber":"20007918-GLT","OrderStatus":"InProcess","OrderType":"Title & Escrow","TransactionType":"Purchase","MarketingRep":"Corey Velasquez","Address":"731 Randall Street","Zip":"93555-3309","City":"Ridgecrest","State":"CA","Country":"Kern"},{"OrderNumber":"20007924-OCT","OrderStatus":"InProcess","OrderType":"Title & Escrow","TransactionType":"Refinance","MarketingRep":"Sandra Millar","Address":"1050 Medford Road","Zip":"91107","City":"Pasadena","State":"CA","Country":"Los Angeles"},{"OrderNumber":"20007927-GLT","OrderStatus":"Completed","OrderType":"Title only","TransactionType":"Purchase","MarketingRep":"Team Meza","Address":"4114 and 4116 S Victoria Avenue","Zip":"90008","City":"View Park area","State":"CA","Country":"Los Angeles"},{"OrderNumber":"20007948-OCT","OrderStatus":"Closed","OrderType":"Title only","TransactionType":"Refinance","MarketingRep":"Laurie Briggs","Address":"893 D Street","Zip":"95648","City":"Lincoln","State":"CA","Country":"Placer"},{"OrderNumber":"20007950-OCT","OrderStatus":"Completed","OrderType":"Title only","TransactionType":"Refinance","MarketingRep":"Angeline Wu","Address":"2643 Military Avenue","Zip":"90064","City":"Los Angeles","State":"CA","Country":"Los Angeles"},{"OrderNumber":"20007955-GLT","OrderStatus":"InProcess","OrderType":"Title only","TransactionType":"Purchase","MarketingRep":"Nelson Torres","Address":"8456 San Clemente Way","Zip":"90620","City":"Buena Park","State":"CA","Country":"Orange"},{"OrderNumber":"20007966-OCT","OrderStatus":"InProcess","OrderType":"Title only","TransactionType":"Refinance","MarketingRep":"Orange County House Account","Address":"2447 19th Avenue","Zip":"94116","City":"San Francisco","State":"CA","Country":"San Francisco"},{"OrderNumber":"20007982-OCT","OrderStatus":"Closed","OrderType":"Title only","TransactionType":"Refinance","MarketingRep":"Sonia Flores","Address":"1067 N Mallard St","Zip":"92867","City":"Orange","State":"CA","Country":"Orange"},{"OrderNumber":"20007991-OCT","OrderStatus":"InProcess","OrderType":"Title only","TransactionType":"Refinance","MarketingRep":"Angeline Wu","Address":"18111 Kirk Avenue","Zip":"92780","City":"Tustin","State":"CA","Country":"Orange"},{"OrderNumber":"20007997-OCT","OrderStatus":"InProcess","OrderType":"Title & Escrow","TransactionType":"Refinance","MarketingRep":"Sandra Millar","Address":"330 West Carson Road","Zip":"85041-6808","City":"Phoenix","State":"AZ","Country":"Maricopa"},{"OrderNumber":"20008000-GLT","OrderStatus":"InProcess","OrderType":"Title only","TransactionType":"Purchase","MarketingRep":"Title Gals","Address":"1388 Nicholas Ct","Zip":"92377","City":"Rialto","State":"CA","Country":"San Bernardino"},{"OrderNumber":"20008006-OCT","OrderStatus":"InProcess","OrderType":"Title & Escrow","TransactionType":"Refinance","MarketingRep":"Sandra Millar","Address":"140 South 97th Street","Zip":"85208","City":"Mesa","State":"AZ","Country":"Maricopa"},{"OrderNumber":"99100443","OrderStatus":"Closed","OrderType":"Trustee Sale Guarantee","TransactionType":"Other","MarketingRep":"John Thaete","Address":"14448 PINNEY STREET","Zip":"91331","City":"Arleta","State":"CA","Country":"Los Angeles"},{"OrderNumber":"20008008-OCT","OrderStatus":"InProcess","OrderType":"Title only","TransactionType":"Purchase","MarketingRep":"Laurie Briggs","Address":"24321 Timothy Drive","Zip":"92629","City":"Dana Point","State":"CA","Country":"Orange"},{"OrderNumber":"20008009-OCT","OrderStatus":"Closed","OrderType":"Title only","TransactionType":"Refinance","MarketingRep":"Corey Velasquez","Address":"29093 Topeka Cir","Zip":"92596","City":"Winchester","State":"CA","Country":"Riverside"},{"OrderNumber":"20008010-GLT","OrderStatus":"InProcess","OrderType":"Title only","TransactionType":"Refinance","MarketingRep":"Tony Baumgartner","Address":"4170 Fair Ave., #103","Zip":"91602","City":"North Hollywood","State":"CA","Country":"Los Angeles"},{"OrderNumber":"20008017-OCT","OrderStatus":"InProcess","OrderType":"Title & Escrow","TransactionType":"Refinance","MarketingRep":"Sandra Millar","Address":"14312 Califa Street, (Van Nuys Area)","Zip":"91401","City":"Los Angeles","State":"CA","Country":"Los Angeles"},{"OrderNumber":"20008034-GLT","OrderStatus":"Completed","OrderType":"Title only","TransactionType":"Purchase","MarketingRep":"Lopez Team","Address":"16825 Maidstone Lane","Zip":"92336","City":"Fontana","State":"CA","Country":"San Bernardino"},{"OrderNumber":"20008057-GLT","OrderStatus":"InProcess","OrderType":"Title only","TransactionType":"Purchase","MarketingRep":"Title Team","Address":"18489 Stonegate Lane","Zip":"91748","City":"Area of Rowland Heights","State":"CA","Country":"Los Angeles"},{"OrderNumber":"20008093-GLT","OrderStatus":"InProcess","OrderType":"Title only","TransactionType":"Refinance","MarketingRep":"Kevin Green","Address":"29354 San Francisquito Canyon Road","Zip":"91390","City":"Santa Clarita","State":"CA","Country":"Los Angeles"},{"OrderNumber":"20008103-OCT","OrderStatus":"Closed","OrderType":"Title only","TransactionType":"Refinance","MarketingRep":"Team Meza","Address":"967 S Firefly Drive","Zip":"92808","City":"Anaheim","State":"CA","Country":"Orange"},{"OrderNumber":"20008109-OCT","OrderStatus":"InProcess","OrderType":"Title only","TransactionType":"Refinance","MarketingRep":"Title Gals","Address":"6689 Banyan Avenue","Zip":"92345","City":"Hesperia","State":"CA","Country":"San Bernardino"},{"OrderNumber":"20008113-OCT","OrderStatus":"Canceled","OrderType":"Title & Escrow","TransactionType":"Purchase","MarketingRep":"Orange County House Account","Address":"1 Reids Roost Road","Zip":"94062","City":"Woodside","State":"CA","Country":"San Mateo"},{"OrderNumber":"20008180-GLT","OrderStatus":"Completed","OrderType":"Title only","TransactionType":"Refinance","MarketingRep":"Team Meza","Address":"9653 Rose Street","Zip":"90706","City":"Bellflower","State":"CA","Country":"Los Angeles"},{"OrderNumber":"20008185-GLT","OrderStatus":"InProcess","OrderType":"Title only","TransactionType":"Purchase","MarketingRep":"Team Meza","Address":"425 W Aeroplane Blvd","Zip":"92314","City":"Big Bear City","State":"CA","Country":"San Bernardino"},{"OrderNumber":"20008187-GLT","OrderStatus":"InProcess","OrderType":"Title only","TransactionType":"Purchase","MarketingRep":"Team Meza","Address":"12428 Grayling Avenue","Zip":"90604","City":"Los Angeles","State":"CA","Country":"Los Angeles"},{"OrderNumber":"20008193-GLT","OrderStatus":"InProcess","OrderType":"Title only","TransactionType":"Purchase","MarketingRep":"Title Gals","Address":"10456 Sparrow Court","Zip":"92557","City":"Moreno Valley","State":"CA","Country":"Riverside"},{"OrderNumber":"20008219-OCT","OrderStatus":"InProcess","OrderType":"Title only","TransactionType":"Refinance","MarketingRep":"Richard Bohn","Address":"2822 Ben Lomond Drive","Zip":"93105","City":"Santa Barbara","State":"CA","Country":"Santa Barbara"},{"OrderNumber":"20008234-OCT","OrderStatus":"InProcess","OrderType":"Title only","TransactionType":"Refinance","MarketingRep":"Sonia Flores","Address":"11070 Spruce Ave","Zip":"92316","City":"Bloomington","State":"CA","Country":"San Bernardino"},{"OrderNumber":"20008250-GLT","OrderStatus":"InProcess","OrderType":"Title only","TransactionType":"Purchase","MarketingRep":"Team Meza","Address":"1553 E 110th Street","Zip":"90059","City":"Los Angeles","State":"CA","Country":"Los Angeles"},{"OrderNumber":"20008276-GLT","OrderStatus":"Closed","OrderType":"Title only","TransactionType":"Refinance","MarketingRep":"Lopez Team","Address":"7344 Morning Hills Drive","Zip":"92880","City":"Corona","State":"CA","Country":"Riverside"},{"OrderNumber":"20008295-OCT","OrderStatus":"Closed","OrderType":"Title only","TransactionType":"Purchase","MarketingRep":"Angeline Wu","Address":"26972 Venado Dr","Zip":"92691","City":"Mission Viejo","State":"CA","Country":"Orange"},{"OrderNumber":"20008325-GLT","OrderStatus":"Closed","OrderType":"Title only","TransactionType":"Purchase","MarketingRep":"Justin Nouri","Address":"1300 Saratoga Ave, Unit 401","Zip":"93003","City":"Ventura","State":"CA","Country":"Ventura"},{"OrderNumber":"20008330-OCT","OrderStatus":"Closed","OrderType":"Escrow only","TransactionType":"Refinance","MarketingRep":"Jorge Mesa","Address":"3716 Clark Avenue","Zip":"90808","City":"Long Beach","State":"CA","Country":"Los Angeles"},{"OrderNumber":"20008367-GLT","OrderStatus":"InProcess","OrderType":"Title only","TransactionType":"Refinance","MarketingRep":"Team Meza","Address":"17221 Clark Avenue","Zip":"90706","City":"Bellflower","State":"CA","Country":"Los Angeles"},{"OrderNumber":"20008384-GLT","OrderStatus":"InProcess","OrderType":"Title only","TransactionType":"Refinance","MarketingRep":"Simon Wu","Address":"1261 South Pennsylvania Avenue","Zip":"91740","City":"Glendora","State":"CA","Country":"Los Angeles"},{"OrderNumber":"20008444-OCT","OrderStatus":"Closed","OrderType":"Title only","TransactionType":"Purchase","MarketingRep":"Richard Bohn","Address":"323 Lila Lane","Zip":"92021","City":"El Cajon","State":"CA","Country":"San Diego"},{"OrderNumber":"20008457-OCT","OrderStatus":"InProcess","OrderType":"Title & Escrow","TransactionType":"Refinance","MarketingRep":"Nicholas Watt","Address":"205 West Avenida San Antonio","Zip":"92672","City":"San Clemente","State":"CA","Country":"Orange"},{"OrderNumber":"20008458-OCT","OrderStatus":"InProcess","OrderType":"Title only","TransactionType":"Refinance","MarketingRep":"Angeline Wu","Address":"19372 Discovery Place","Zip":"91748","City":"Rowland Heights","State":"CA","Country":"Los Angeles"},{"OrderNumber":"20008472-PRV","OrderStatus":"InProcess","OrderType":"Escrow only","TransactionType":"Refinance","MarketingRep":"Orange County House Account","Address":"712 Calmar Avenue","Zip":"94610","City":"Oakland","State":"CA","Country":"Alameda"},{"OrderNumber":"20008476-GLT","OrderStatus":"Closed","OrderType":"Title only","TransactionType":"Refinance","MarketingRep":"Nini Kerns","Address":"462 Swarthmore Ln","Zip":"92626","City":"Costa Mesa","State":"CA","Country":"Orange"},{"OrderNumber":"20008482-OCT","OrderStatus":"InProcess","OrderType":"Title only","TransactionType":"Purchase","MarketingRep":"Angeline Wu","Address":"430 Stoney Point Way #124","Zip":"92058","City":"Oceanside","State":"CA","Country":"San Diego"},{"OrderNumber":"20008484-GLT","OrderStatus":"InProcess","OrderType":"Title only","TransactionType":"Purchase","MarketingRep":"David Gomez","Address":"550 East Base Line Street","Zip":"92410","City":"San Bernardino","State":"CA","Country":"San Bernardino"},{"OrderNumber":"20008493-GLT","OrderStatus":"InProcess","OrderType":"Title only","TransactionType":"Purchase","MarketingRep":"Michael Nouri","Address":"7320, 7320 1/2, 7322 & 7322 1/2 Newcastle Avenue","Zip":"91335","City":"Reseda","State":"CA","Country":"Los Angeles"},{"OrderNumber":"20008506-OCT","OrderStatus":"InProcess","OrderType":"Title & Escrow","TransactionType":"Purchase","MarketingRep":"Jane Phan","Address":"7179 Westminster Boulevard","Zip":"92683","City":"Westminster","State":"CA","Country":"Orange"},{"OrderNumber":"20008518-OCT","OrderStatus":"Closed","OrderType":"Title & Escrow","TransactionType":"Refinance","MarketingRep":"Sandra Millar","Address":"2115 Roxanne Avenue","Zip":"90815","City":"Long Beach","State":"CA","Country":"Los Angeles"},{"OrderNumber":"20008524-OCT","OrderStatus":"InProcess","OrderType":"Escrow only","TransactionType":"Refinance","MarketingRep":"Jorge Mesa","Address":"1439 East 76th Street","Zip":"90001","City":"Los Angeles","State":"CA","Country":"Los Angeles"},{"OrderNumber":"20008540-OCT","OrderStatus":"InProcess","OrderType":"Title & Escrow","TransactionType":"Refinance","MarketingRep":"Angeline Wu","Address":"2325 Village Court, Unit 4","Zip":"91745","City":"Hacienda Heights","State":"CA","Country":"Los Angeles"},{"OrderNumber":"20008553-GLT","OrderStatus":"InProcess","OrderType":"Title only","TransactionType":"Refinance","MarketingRep":"Michael Nouri","Address":"10650 Ilex Avenue","Zip":"91331","City":"Pacoima","State":"CA","Country":"Los Angeles"},{"OrderNumber":"20008583-OCT","OrderStatus":"Closed","OrderType":"Title only","TransactionType":"Purchase","MarketingRep":"Sonia Flores","Address":"2122 West 10th Street","Zip":"92703","City":"Santa Ana","State":"CA","Country":"Orange"},{"OrderNumber":"20008617-GLT","OrderStatus":"InProcess","OrderType":"Title only","TransactionType":"Refinance","MarketingRep":"Kevin Green","Address":"2645 East Van Buren Street","Zip":"90810","City":"Carson","State":"CA","Country":"Los Angeles"},{"OrderNumber":"20008636-OCT","OrderStatus":"InProcess","OrderType":"Title only","TransactionType":"Refinance","MarketingRep":"Sonia Flores","Address":"2117 Clifford Street","Zip":"90026","City":"Los Angeles","State":"CA","Country":"Los Angeles"},{"OrderNumber":"20008638-GLT","OrderStatus":"Closed","OrderType":"Title & Escrow","TransactionType":"Refinance","MarketingRep":"Michael Nouri","Address":"463 Edna Place","Zip":"91723","City":"Covina Area","State":"CA","Country":"Los Angeles"},{"OrderNumber":"20008647-OCT","OrderStatus":"InProcess","OrderType":"Title only","TransactionType":"Refinance","MarketingRep":"Linda Ruiz","Address":"2750 Olivera Road","Zip":"92372","City":"Pinon Hills","State":"CA","Country":"San Bernardino"},{"OrderNumber":"20008650-OCT","OrderStatus":"Closed","OrderType":"Title & Escrow","TransactionType":"Refinance","MarketingRep":"Team Meza","Address":"1345 West Parade Street","Zip":"90810","City":"Long Beach","State":"CA","Country":"Los Angeles"},{"OrderNumber":"20008669-OCT","OrderStatus":"InProcess","OrderType":"Title only","TransactionType":"Refinance","MarketingRep":"Linda Ruiz","Address":"2024 West Saint Gertrude Place","Zip":"92704","City":"Santa Ana","State":"CA","Country":"Orange"},{"OrderNumber":"20008673-GLT","OrderStatus":"InProcess","OrderType":"Title only","TransactionType":"Refinance","MarketingRep":"Kevin Green","Address":"23611 Del Cerro Circle","Zip":"91304","City":"Canoga Park Area","State":"CA","Country":"Los Angeles"},{"OrderNumber":"20008681-OCT","OrderStatus":"Closed","OrderType":"Title only","TransactionType":"Refinance","MarketingRep":"Sonia Flores","Address":"6039 East Hackamore Lane","Zip":"92807","City":"Anaheim","State":"CA","Country":"Orange"},{"OrderNumber":"20008684-OCT","OrderStatus":"InProcess","OrderType":"Title only","TransactionType":"Refinance","MarketingRep":"Angeline Wu","Address":"3045 Reid Avenue","Zip":"90232","City":"Culver City","State":"CA","Country":"Los Angeles"},{"OrderNumber":"20008685-GLT","OrderStatus":"Closed","OrderType":"Title only","TransactionType":"Purchase","MarketingRep":"Team Meza","Address":"326 E Plymouth Street","Zip":"90805","City":"Long Beach","State":"CA","Country":"Los Angeles"},{"OrderNumber":"99100470","OrderStatus":"Closed","OrderType":"Trustee Sale Guarantee","TransactionType":"Other","MarketingRep":"John Thaete","Address":"4305 THYME AVE","Zip":"89110","City":"Las Vegas","State":"NV","Country":"Clark"},{"OrderNumber":"20008693-OCT","OrderStatus":"InProcess","OrderType":"Title & Escrow","TransactionType":"Refinance","MarketingRep":"Sandra Millar","Address":"1476 Hamner Avenue","Zip":"92860","City":"Norco","State":"CA","Country":"Riverside"},{"OrderNumber":"20008698-OCT","OrderStatus":"Closed","OrderType":"Title only","TransactionType":"Purchase","MarketingRep":"Linda Ruiz","Address":"24532 Corta Cresta Drive","Zip":"92630","City":"Lake Forest","State":"CA","Country":"Orange"},{"OrderNumber":"20008706-GLT","OrderStatus":"Closed","OrderType":"Title only","TransactionType":"Purchase","MarketingRep":"Lopez Team","Address":"14568 May Lane","Zip":"92553","City":"Moreno Valley","State":"CA","Country":"Riverside"},{"OrderNumber":"20008710-OCT","OrderStatus":"Closed","OrderType":"Escrow only","TransactionType":"Purchase","MarketingRep":"Jorge Mesa","Address":"24417 Periwinkle Way","Zip":"92532","City":"Lake Elsinore","State":"CA","Country":"Riverside"},{"OrderNumber":"20008711-GLT","OrderStatus":"InProcess","OrderType":"Title only","TransactionType":"Purchase","MarketingRep":"Simon Wu","Address":"2465 Lorain Road","Zip":"91108","City":"San Marino","State":"CA","Country":"Los Angeles"},{"OrderNumber":"20008713-OCT","OrderStatus":"InProcess","OrderType":"Escrow only","TransactionType":"Purchase","MarketingRep":"Jorge Mesa","Address":"702 West Vernon Avenue","Zip":"90037","City":"Los Angeles","State":"CA","Country":"Los Angeles"},{"OrderNumber":"20008719-GLT","OrderStatus":"InProcess","OrderType":"Title only","TransactionType":"Purchase","MarketingRep":"David Gomez","Address":"18627 Toehee Street","Zip":"92570","City":"Perris","State":"CA","Country":"Riverside"},{"OrderNumber":"20008725-OCT","OrderStatus":"InProcess","OrderType":"Title & Escrow","TransactionType":"Refinance","MarketingRep":"Angeline Wu","Address":"10691 Albany Circle","Zip":"92861","City":"Villa Park","State":"CA","Country":"Orange"},{"OrderNumber":"20008751-OCT","OrderStatus":"Closed","OrderType":"Title only","TransactionType":"Purchase","MarketingRep":"Angeline Wu","Address":"30210 Longhorn Drive","Zip":"92587","City":"Canyon Lake","State":"CA","Country":"Riverside"},{"OrderNumber":"20008763-GLT","OrderStatus":"InProcess","OrderType":"Title only","TransactionType":"Purchase","MarketingRep":"Corey Velasquez","Address":"8621 Cypress Avenue","Zip":"92335","City":"Fontana","State":"CA","Country":"San Bernardino"},{"OrderNumber":"20008779-GLT","OrderStatus":"Closed","OrderType":"Title only","TransactionType":"Refinance","MarketingRep":"Angeline Wu","Address":"1214 Ramos Drive","Zip":"95694","City":"Winters","State":"CA","Country":"Yolo"},{"OrderNumber":"20008782-OCT","OrderStatus":"InProcess","OrderType":"Title only","TransactionType":"Refinance","MarketingRep":"Neil Torquato","Address":"272 Pueblo Road","Zip":"92882","City":"Corona","State":"CA","Country":"Riverside"},{"OrderNumber":"20008785-GLT","OrderStatus":"Closed","OrderType":"Title only","TransactionType":"Refinance","MarketingRep":"Angeline Wu","Address":"1957 Lucca Lane","Zip":"95648","City":"Lincoln","State":"CA","Country":"Placer"},{"OrderNumber":"20008803-GLT","OrderStatus":"InProcess","OrderType":"Title only","TransactionType":"Purchase","MarketingRep":"Simon Wu","Address":"2271 Redwood Drive","Zip":"91741","City":"Glendora","State":"CA","Country":"Los Angeles"},{"OrderNumber":"20008809-GLT","OrderStatus":"InProcess","OrderType":"Title only","TransactionType":"Refinance","MarketingRep":"Kevin Green","Address":"36902 Aristo Place","Zip":"93550","City":"Palmdale","State":"CA","Country":"Los Angeles"},{"OrderNumber":"20008824-OCT","OrderStatus":"Completed","OrderType":"Title only","TransactionType":"Refinance","MarketingRep":"Angeline Wu","Address":"17391 Caminito Siega","Zip":"92127","City":"San Diego","State":"CA","Country":"San Diego"},{"OrderNumber":"20008825-GLT","OrderStatus":"Closed","OrderType":"Title only","TransactionType":"Purchase","MarketingRep":"Lopez Team","Address":"7597 Cram Road","Zip":"92346","City":"Highland","State":"CA","Country":"San Bernardino"},{"OrderNumber":"20008826-GLT","OrderStatus":"InProcess","OrderType":"Title only","TransactionType":"Refinance","MarketingRep":"Lopez Team","Address":"24260 Minton Road","Zip":"92548","City":"Homeland","State":"CA","Country":"Riverside"},{"OrderNumber":"20008836-GLT","OrderStatus":"InProcess","OrderType":"Title only","TransactionType":"Purchase","MarketingRep":"Veronica Sanchez","Address":"431 E Street","Zip":"93268","City":"Taft","State":"CA","Country":"Kern"},{"OrderNumber":"20008840-OCT","OrderStatus":"InProcess","OrderType":"Escrow only","TransactionType":"Purchase","MarketingRep":"Jorge Mesa","Address":"702 West Vernon Avenue","Zip":"90037","City":"Los Angeles","State":"CA","Country":"Los Angeles"},{"OrderNumber":"20008845-OCT","OrderStatus":"Closed","OrderType":"Title only","TransactionType":"Purchase","MarketingRep":"Neil Torquato","Address":"330 Ballena Drive","Zip":"91765","City":"Diamond Bar","State":"CA","Country":"Los Angeles"},{"OrderNumber":"20008848-OCT","OrderStatus":"Closed","OrderType":"Title only","TransactionType":"Purchase","MarketingRep":"Rouanne Garcia","Address":"120 Avenida Santa Margarita","Zip":"92672","City":"San Clemente","State":"CA","Country":"Orange"},{"OrderNumber":"20008856-GLT","OrderStatus":"InProcess","OrderType":"Title only","TransactionType":"Purchase","MarketingRep":"Justin Nouri","Address":"21808 Craggy View Street","Zip":"91311","City":"Chatsworth","State":"CA","Country":"Los Angeles"},{"OrderNumber":"20008858-OCT","OrderStatus":"Closed","OrderType":"Title & Escrow","TransactionType":"Refinance","MarketingRep":"Angeline Wu","Address":"6282 North Van Ness","Zip":"93711","City":"Fresno","State":"CA","Country":"Fresno"},{"OrderNumber":"20008880-GLT","OrderStatus":"InProcess","OrderType":"Title only","TransactionType":"Refinance","MarketingRep":"Simon Wu","Address":"751 Benchmark","Zip":"92618","City":"Irvine","State":"CA","Country":"Orange"},{"OrderNumber":"20008881-GLT","OrderStatus":"InProcess","OrderType":"Title only","TransactionType":"Refinance","MarketingRep":"Angeline Wu","Address":"107 Independence Ave","Zip":"95687","City":"Vacaville","State":"CA","Country":"Solano"},{"OrderNumber":"20008899-OCT","OrderStatus":"Closed","OrderType":"Title only","TransactionType":"Purchase","MarketingRep":"Simon Wu","Address":"51 Miren Place","Zip":"91006","City":"Arcadia","State":"CA","Country":"Los Angeles"},{"OrderNumber":"20008913-OCT","OrderStatus":"InProcess","OrderType":"Title only","TransactionType":"Refinance","MarketingRep":"Angeline Wu","Address":"6130 Village Way","Zip":"92130","City":"San Diego","State":"CA","Country":"San Diego"},{"OrderNumber":"20008918-GLT","OrderStatus":"InProcess","OrderType":"Title only","TransactionType":"Refinance","MarketingRep":"Justin Nouri","Address":"5815 E Wardlow Road","Zip":"90808","City":"Long Beach","State":"CA","Country":"Los Angeles"},{"OrderNumber":"20008919-GLT","OrderStatus":"InProcess","OrderType":"Title only","TransactionType":"Refinance","MarketingRep":"Justin Nouri","Address":"3274 Adriatic Avenu","Zip":"90810","City":"Long Beach","State":"CA","Country":"Los Angeles"},{"OrderNumber":"20008932-GLT","OrderStatus":"InProcess","OrderType":"Title only","TransactionType":"Purchase","MarketingRep":"Lopez Team","Address":"16459 Bunnell Avenue","Zip":"92394","City":"Victorville","State":"CA","Country":"San Bernardino"},{"OrderNumber":"20008933-OCT","OrderStatus":"Closed","OrderType":"Title & Escrow","TransactionType":"Refinance","MarketingRep":"Angeline Wu","Address":"3037 Pacific Ave.","Zip":"90806","City":"Long Beach","State":"CA","Country":"Los Angeles"},{"OrderNumber":"20008948-OCT","OrderStatus":"InProcess","OrderType":"Title only","TransactionType":"Refinance","MarketingRep":"Angeline Wu","Address":"1490 Descanso St #6","Zip":"93405","City":"San Luis Obispo","State":"CA","Country":"San Luis Obispo"},{"OrderNumber":"20008949-OCT","OrderStatus":"Closed","OrderType":"Title only","TransactionType":"Purchase","MarketingRep":"Ventura House Account","Address":"2052 Sheridan Street","Zip":"90033","City":"Los Angeles","State":"CA","Country":"Los Angeles"},{"OrderNumber":"20008951-OCT","OrderStatus":"InProcess","OrderType":"Title only","TransactionType":"Refinance","MarketingRep":"Laurie Briggs","Address":"1986 Fullerton Avenue","Zip":"92627","City":"Costa Mesa","State":"CA","Country":"Orange"},{"OrderNumber":"20008930-PRV","OrderStatus":"InProcess","OrderType":"Escrow only","TransactionType":"Purchase","MarketingRep":"Orange County House Account","Address":"5505 W Tulare Ave. Spc 340","Zip":"93277","City":"Visalia","State":"CA","Country":"Tulare"},{"OrderNumber":"20008965-OCT","OrderStatus":"InProcess","OrderType":"Title only","TransactionType":"Purchase","MarketingRep":"Ventura House Account","Address":"1062 Golden Rain Street","Zip":"91786","City":"Upland","State":"CA","Country":"San Bernardino"},{"OrderNumber":"20008974-OCT","OrderStatus":"InProcess","OrderType":"Title only","TransactionType":"Refinance","MarketingRep":"Nicholas Watt","Address":"6151 Trinette Avenue","Zip":"92845","City":"Garden Grove","State":"CA","Country":"Orange"},{"OrderNumber":"20008975-GLT","OrderStatus":"Closed","OrderType":"Title only","TransactionType":"Refinance","MarketingRep":"Kevin Green","Address":"8131 Louise Avenue","Zip":"91325","City":"Northridge","State":"CA","Country":"Los Angeles"},{"OrderNumber":"20008976-GLT","OrderStatus":"Closed","OrderType":"Title only","TransactionType":"Refinance","MarketingRep":"Kevin Green","Address":"19118 Strathern Street","Zip":"91335","City":"Los Angeles, Reseda area","State":"CA","Country":"Los Angeles"},{"OrderNumber":"20008978-GLT","OrderStatus":"InProcess","OrderType":"Title only","TransactionType":"Purchase","MarketingRep":"Kevin Green","Address":"1672 East 76th Street","Zip":"90001","City":"Los Angeles","State":"CA","Country":"Los Angeles"},{"OrderNumber":"20008991-GLT","OrderStatus":"InProcess","OrderType":"Title only","TransactionType":"Refinance","MarketingRep":"Veronica Sanchez","Address":"13080 Dronfield Ave., #36","Zip":"91342","City":"Los Angeles","State":"CA","Country":"Los Angeles"},{"OrderNumber":"20008995-OCT","OrderStatus":"InProcess","OrderType":"Title & Escrow","TransactionType":"Refinance","MarketingRep":"Jane Phan","Address":"6849 Via Media Circle","Zip":"90620","City":"Buena Park","State":"CA","Country":"Orange"},{"OrderNumber":"20008997-OCT","OrderStatus":"Closed","OrderType":"Title only","TransactionType":"Purchase","MarketingRep":"Linda Ruiz","Address":"6510 Airoso Avenue","Zip":"92120","City":"San Diego","State":"CA","Country":"San Diego"},{"OrderNumber":"20008999-GLT","OrderStatus":"InProcess","OrderType":"Title only","TransactionType":"Purchase","MarketingRep":"Sonia Flores","Address":"17463 Baldwin Street","Zip":"93638","City":"Madera","State":"CA","Country":"Madera"},{"OrderNumber":"20009027-OCT","OrderStatus":"InProcess","OrderType":"Title & Escrow","TransactionType":"Refinance","MarketingRep":"Sandra Millar","Address":"966 Willow Creek Road, Unit 31","Zip":"92352","City":"Lake Arrowhead","State":"CA","Country":"San Bernardino"},{"OrderNumber":"20009039-GLT","OrderStatus":"InProcess","OrderType":"Title only","TransactionType":"Purchase","MarketingRep":"Simon Wu","Address":"2424 S Laurelwood #143","Zip":"92704","City":"Santa Ana","State":"CA","Country":"Orange"},{"OrderNumber":"20009044-OCT","OrderStatus":"InProcess","OrderType":"Title only","TransactionType":"Refinance","MarketingRep":"Orange County House Account","Address":"5834 South Peach Avenue","Zip":"93725","City":"Fresno","State":"CA","Country":"Fresno"},{"OrderNumber":"20009047-OCT","OrderStatus":"Completed","OrderType":"Title only","TransactionType":"Purchase","MarketingRep":"Richard Bohn","Address":"3373 Armstrong Street","Zip":"92111","City":"San Diego","State":"CA","Country":"San Diego"},{"OrderNumber":"20009053-OCT","OrderStatus":"InProcess","OrderType":"Title only","TransactionType":"Purchase","MarketingRep":"Lopez Team","Address":"254 Roundabout Drive","Zip":"91744","City":"La Puente","State":"CA","Country":"Los Angeles"},{"OrderNumber":"20009054-OCT","OrderStatus":"InProcess","OrderType":"Title & Escrow","TransactionType":"Refinance","MarketingRep":"Linda Ruiz","Address":"1154 Mcfarland Avenue","Zip":"90744","City":"Los Angeles","State":"CA","Country":"Los Angeles"},{"OrderNumber":"20009063-OCT","OrderStatus":"InProcess","OrderType":"Title only","TransactionType":"Refinance","MarketingRep":"Angeline Wu","Address":"16581 Sightseer Place","Zip":"91708","City":"Chino","State":"CA","Country":"San Bernardino"},{"OrderNumber":"20009069-GLT","OrderStatus":"InProcess","OrderType":"Title only","TransactionType":"Refinance","MarketingRep":"Ventura House Account","Address":"6225 Eglise Avenue","Zip":"90660","City":"Pico Rivera","State":"CA","Country":"Los Angeles"},{"OrderNumber":"20009070-GLT","OrderStatus":"InProcess","OrderType":"Title only","TransactionType":"Purchase","MarketingRep":"David Gomez","Address":"27443 Big Horn","Zip":"92555","City":"Moreno Valley","State":"CA","Country":"Riverside"},{"OrderNumber":"20009084-OCT","OrderStatus":"Closed","OrderType":"Title only","TransactionType":"Purchase","MarketingRep":"Angeline Wu","Address":"16611 Shenandoah Avenue","Zip":"90703","City":"Cerritos","State":"CA","Country":"Los Angeles"},{"OrderNumber":"20009089-OCT","OrderStatus":"InProcess","OrderType":"Title only","TransactionType":"Refinance","MarketingRep":"Angeline Wu","Address":"26951 Ayamonte","Zip":"92692","City":"Mission Viejo","State":"CA","Country":"Orange"},{"OrderNumber":"20009091-OCT","OrderStatus":"InProcess","OrderType":"Title & Escrow","TransactionType":"Refinance","MarketingRep":"Jane Phan","Address":"4102 Blackfin Avenue","Zip":"92620","City":"Irvine","State":"CA","Country":"Orange"},{"OrderNumber":"20009093-OCT","OrderStatus":"Completed","OrderType":"Title only","TransactionType":"Refinance","MarketingRep":"Sandra Millar","Address":"1251 9th Street","Zip":"91932","City":"Imperial Beach","State":"CA","Country":"San Diego"},{"OrderNumber":"20009100-PRV","OrderStatus":"InProcess","OrderType":"Title & Escrow","TransactionType":"Refinance","MarketingRep":"Orange County House Account","Address":"19440 Richardson Road","Zip":"93267","City":"Strathmore","State":"CA","Country":"Tulare"},{"OrderNumber":"99100493","OrderStatus":"Closed","OrderType":"Trustee Sale Guarantee","TransactionType":"Other","MarketingRep":"John Thaete","Address":"5580 WEST DESERT INN RD","Zip":"89146","City":"Las Vegas","State":"NV","Country":"Clark"},{"OrderNumber":"20009106-GLT","OrderStatus":"InProcess","OrderType":"Title only","TransactionType":"Purchase","MarketingRep":"Ventura House Account","Address":"328 Wildflower Court","Zip":"91702","City":"Azusa","State":"CA","Country":"Los Angeles"},{"OrderNumber":"20009114-GLT","OrderStatus":"Closed","OrderType":"Title only","TransactionType":"Purchase","MarketingRep":"Maria Basilio","Address":"10058 Chardonnay Court","Zip":"91352","City":"Los Angeles","State":"CA","Country":"Los Angeles"},{"OrderNumber":"20009167-OCT","OrderStatus":"InProcess","OrderType":"Title & Escrow","TransactionType":"Refinance","MarketingRep":"Sandra Millar","Address":"6138 North Figueroa Street","Zip":"90042","City":"Los Angeles","State":"CA","Country":"Los Angeles"},{"OrderNumber":"20009169-OCT","OrderStatus":"InProcess","OrderType":"Title only","TransactionType":"Refinance","MarketingRep":"Sonia Flores","Address":"8171 E Bailey Way","Zip":"92808","City":"Anaheim","State":"CA","Country":"Orange"},{"OrderNumber":"20009172-OCT","OrderStatus":"InProcess","OrderType":"Title only","TransactionType":"Purchase","MarketingRep":"Ventura House Account","Address":"4073 Tamarind Ridge Road","Zip":"92530","City":"Lake Elsinore","State":"CA","Country":"Riverside"},{"OrderNumber":"20009185-OCT","OrderStatus":"InProcess","OrderType":"Title only","TransactionType":"Refinance","MarketingRep":"Nicholas Watt","Address":"418 Los Verdes Drive","Zip":"93111","City":"Santa Barbara","State":"CA","Country":"Santa Barbara"},{"OrderNumber":"20009193-OCT","OrderStatus":"InProcess","OrderType":"Title only","TransactionType":"Purchase","MarketingRep":"Title Team","Address":"18517 Betty Way","Zip":"90703","City":"Cerritos","State":"CA","Country":"Los Angeles"},{"OrderNumber":"20009208-OCT","OrderStatus":"Closed","OrderType":"Title only","TransactionType":"Refinance","MarketingRep":"Sandra Millar","Address":"3112 West Commonwealth Avenue","Zip":"91803","City":"Alhambra","State":"CA","Country":"Los Angeles"},{"OrderNumber":"20009209-OCT","OrderStatus":"InProcess","OrderType":"Title only","TransactionType":"Refinance","MarketingRep":"Orange County House Account","Address":"4433 Blossom Court","Zip":"95356","City":"Modesto","State":"CA","Country":"Stanislaus"},{"OrderNumber":"20009214-OCT","OrderStatus":"InProcess","OrderType":"Title & Escrow","TransactionType":"Refinance","MarketingRep":"Sandra Millar","Address":"335 Jane Drive","Zip":"94062","City":"Woodside","State":"CA","Country":"San Mateo"},{"OrderNumber":"20009215-GLT","OrderStatus":"InProcess","OrderType":"Title only","TransactionType":"Purchase","MarketingRep":"Lopez Team","Address":"6088 Vista De Oro","Zip":"92509","City":"Riverside","State":"CA","Country":"Riverside"},{"OrderNumber":"20009225-GLT","OrderStatus":"InProcess","OrderType":"Title only","TransactionType":"Purchase","MarketingRep":"Simon Wu","Address":"8252 Malachite Ave","Zip":"91730","City":"Rancho Cucamonga","State":"CA","Country":"San Bernardino"},{"OrderNumber":"20009226-OCT","OrderStatus":"InProcess","OrderType":"Title only","TransactionType":"Purchase","MarketingRep":"Sandra Millar","Address":"Vacant Land - 0459-108-17-0000 - Aster Road","Zip":"92301","City":"Adelanto","State":"CA","Country":"San Bernardino"},{"OrderNumber":"20009234-GLT","OrderStatus":"InProcess","OrderType":"Title only","TransactionType":"Purchase","MarketingRep":"Tony Baumgartner","Address":"1270 Tropical Ave","Zip":"91107","City":"Pasadena","State":"CA","Country":"Los Angeles"},{"OrderNumber":"20009247-GLT","OrderStatus":"InProcess","OrderType":"Title only","TransactionType":"Refinance","MarketingRep":"Title Team","Address":"2476 E Salem Street","Zip":"91761","City":"Ontario","State":"CA","Country":"San Bernardino"},{"OrderNumber":"20009248-OCT","OrderStatus":"InProcess","OrderType":"Title only","TransactionType":"Refinance","MarketingRep":"Linda Ruiz","Address":"9715 Brookbay Circle","Zip":"92646","City":"Huntington Beach","State":"CA","Country":"Orange"},{"OrderNumber":"20009251-GLT","OrderStatus":"InProcess","OrderType":"Title only","TransactionType":"Purchase","MarketingRep":"Corey Velasquez","Address":"14042 Hawes Street","Zip":"90605","City":"Whittier","State":"CA","Country":"Los Angeles"},{"OrderNumber":"20009254-GLT","OrderStatus":"InProcess","OrderType":"Title only","TransactionType":"Purchase","MarketingRep":"Michael Caballero","Address":"7948 Emerson Place","Zip":"91770","City":"Rosemead","State":"CA","Country":"Los Angeles"},{"OrderNumber":"20009255-ONT","OrderStatus":"InProcess","OrderType":"Title & Escrow","TransactionType":"Purchase","MarketingRep":"Team Meza","Address":"17883 Graystone Avenue #201","Zip":"91709","City":"Chino Hills","State":"CA","Country":"San Bernardino"},{"OrderNumber":"20009262-OCT","OrderStatus":"InProcess","OrderType":"Title only","TransactionType":"Purchase","MarketingRep":"Christy Coffey","Address":"2010 Vista Cajon","Zip":"92660","City":"Newport Beach","State":"CA","Country":"Orange"},{"OrderNumber":"20009273-OCT","OrderStatus":"Closed","OrderType":"Title only","TransactionType":"Refinance","MarketingRep":"Richard Bohn","Address":"28491 Via Princesa #A","Zip":"92563","City":"Murrieta","State":"CA","Country":"Riverside"},{"OrderNumber":"20009286-GLT","OrderStatus":"InProcess","OrderType":"Title only","TransactionType":"Purchase","MarketingRep":"David Gomez","Address":"1681 Aspen Village Way","Zip":"91791","City":"West Covina","State":"CA","Country":"Los Angeles"},{"OrderNumber":"20009297-OCT","OrderStatus":"InProcess","OrderType":"Title only","TransactionType":"Refinance","MarketingRep":"Orange County House Account","Address":"919 Washburn Avenue","Zip":"92882","City":"Corona","State":"CA","Country":"Riverside"},{"OrderNumber":"20009303-ONT","OrderStatus":"InProcess","OrderType":"Title & Escrow","TransactionType":"Refinance","MarketingRep":"Lopez Team","Address":"2403 Calle Grandon","Zip":"91913","City":"Chula Vista","State":"CA","Country":"San Diego"},{"OrderNumber":"20009312-GLT","OrderStatus":"Closed","OrderType":"Title only","TransactionType":"Purchase","MarketingRep":"Ventura House Account","Address":"1498 Powell Way","Zip":"92501","City":"Riverside","State":"CA","Country":"Riverside"},{"OrderNumber":"20009314-OCT","OrderStatus":"InProcess","OrderType":"Title only","TransactionType":"Refinance","MarketingRep":"Sandra Millar","Address":"14519 Greenleaf Street, (Sherman Oaks Area)","Zip":"91403","City":"Los Angeles","State":"CA","Country":"Los Angeles"},{"OrderNumber":"20009318-GLT","OrderStatus":"InProcess","OrderType":"Title only","TransactionType":"Refinance","MarketingRep":"Nini Kerns","Address":"439 Ala Wai Boulevard#139","Zip":"96150","City":"South Lake Tahoe","State":"CA","Country":"El Dorado"},{"OrderNumber":"20009325-GLT","OrderStatus":"Closed","OrderType":"Title only","TransactionType":"Refinance","MarketingRep":"Kevin Green","Address":"4555 Westview Drive","Zip":"91941","City":"La Mesa","State":"CA","Country":"San Diego"},{"OrderNumber":"20009326-GLT","OrderStatus":"InProcess","OrderType":"Title only","TransactionType":"Refinance","MarketingRep":"Maria Basilio","Address":"3310 W 78th Street","Zip":"90043","City":"Los Angeles","State":"CA","Country":"Los Angeles"},{"OrderNumber":"20009341-GLT","OrderStatus":"InProcess","OrderType":"Title only","TransactionType":"Purchase","MarketingRep":"Team Meza","Address":"6509 State Street","Zip":"90255","City":"Huntington Park","State":"CA","Country":"Los Angeles"},{"OrderNumber":"20009359-OCT","OrderStatus":"InProcess","OrderType":"Title & Escrow","TransactionType":"Refinance","MarketingRep":"Nicholas Watt","Address":"13 Hastings","Zip":"92677","City":"Laguna Niguel","State":"CA","Country":"Orange"},{"OrderNumber":"20009369-OCT","OrderStatus":"Closed","OrderType":"Title only","TransactionType":"Refinance","MarketingRep":"Angeline Wu","Address":"6567 Neddy Ave","Zip":"91307","City":"West Hills","State":"CA","Country":"Los Angeles"},{"OrderNumber":"20009371-OCT","OrderStatus":"InProcess","OrderType":"Title only","TransactionType":"Purchase","MarketingRep":"Orange County House Account","Address":"308 East 16th Street","Zip":"95901","City":"Marysville","State":"CA","Country":"Yuba"},{"OrderNumber":"20009382-GLT","OrderStatus":"InProcess","OrderType":"Title & Escrow","TransactionType":"Purchase","MarketingRep":"Michael Nouri","Address":"10582 Holman Avenue","Zip":"90024","City":"Los Angeles","State":"CA","Country":"Los Angeles"},{"OrderNumber":"20009384-OCT","OrderStatus":"InProcess","OrderType":"Title & Escrow","TransactionType":"Refinance","MarketingRep":"Sandra Millar","Address":"1817 Rial Lane","Zip":"90077","City":"Los Angeles","State":"CA","Country":"Los Angeles"},{"OrderNumber":"20009392-OCT","OrderStatus":"InProcess","OrderType":"Title only","TransactionType":"Refinance","MarketingRep":"Nicholas Watt","Address":"20734 Stephanie Drive, (Winnetka Area)","Zip":"91306","City":"Los Angeles","State":"CA","Country":"Los Angeles"},{"OrderNumber":"20009399-GLT","OrderStatus":"InProcess","OrderType":"Title only","TransactionType":"Purchase","MarketingRep":"Glendale  House Account","Address":"39600 Calle Gayube","Zip":"92544-9725","City":"Hemet","State":"CA","Country":"Riverside"},{"OrderNumber":"20009417-OCT","OrderStatus":"InProcess","OrderType":"Title only","TransactionType":"Refinance","MarketingRep":"Angeline Wu","Address":"837 Launer Road","Zip":"92821","City":"Brea","State":"CA","Country":"Orange"},{"OrderNumber":"20009419-GLT","OrderStatus":"InProcess","OrderType":"Title only","TransactionType":"Purchase","MarketingRep":"Team Meza","Address":"15366 Gundry Avenue","Zip":"90723","City":"Paramount","State":"CA","Country":"Los Angeles"},{"OrderNumber":"20009421-OCT","OrderStatus":"InProcess","OrderType":"Title only","TransactionType":"Refinance","MarketingRep":"Angeline Wu","Address":"42111 Osgood Road., Unit #301","Zip":"94539","City":"Fremont","State":"CA","Country":"Alameda"},{"OrderNumber":"20009433-GLT","OrderStatus":"InProcess","OrderType":"Title only","TransactionType":"Purchase","MarketingRep":"Maria Basilio","Address":"2465 S Ola Vista","Zip":"92672","City":"San Clemente","State":"CA","Country":"Orange"},{"OrderNumber":"20009439-OCT","OrderStatus":"InProcess","OrderType":"Title only","TransactionType":"Purchase","MarketingRep":"Sandra Millar","Address":"396 South Auburn Heights Lane","Zip":"92807","City":"Anaheim","State":"CA","Country":"Orange"},{"OrderNumber":"20009440-GLT","OrderStatus":"InProcess","OrderType":"Title only","TransactionType":"Refinance","MarketingRep":"Kevin Green","Address":"7514 Larsen Bay Street","Zip":"92880","City":"Eastvale","State":"CA","Country":"Riverside"},{"OrderNumber":"20009444-OCT","OrderStatus":"InProcess","OrderType":"Title only","TransactionType":"Refinance","MarketingRep":"Richard Bohn","Address":"2121 Woodbury Place","Zip":"92026","City":"Escondido","State":"CA","Country":"San Diego"},{"OrderNumber":"20009451-PRV","OrderStatus":"InProcess","OrderType":"Title & Escrow","TransactionType":"Purchase","MarketingRep":"Orange County House Account","Address":"125 North Martin Street","Zip":"93257","City":"Porterville","State":"CA","Country":"Tulare"},{"OrderNumber":"20009457-OCT","OrderStatus":"InProcess","OrderType":"Title & Escrow","TransactionType":"Refinance","MarketingRep":"Sandra Millar","Address":"3392 Chateau Road, Unit 40","Zip":"93546-9646","City":"Mammoth Lakes","State":"CA","Country":"Mono"},{"OrderNumber":"20009463-GLT","OrderStatus":"InProcess","OrderType":"Title only","TransactionType":"Purchase","MarketingRep":"Title Team","Address":"35 Del Cambrea","Zip":"92606","City":"Irvine","State":"CA","Country":"Orange"},{"OrderNumber":"20009476-OCT","OrderStatus":"InProcess","OrderType":"Title only","TransactionType":"Refinance","MarketingRep":"Sandra Millar","Address":"2901 Preece Street","Zip":"92111","City":"San Diego","State":"CA","Country":"San Diego"},{"OrderNumber":"20009480-GLT","OrderStatus":"InProcess","OrderType":"Title only","TransactionType":"Purchase","MarketingRep":"Team Meza","Address":"34212 Sundew Court","Zip":"92532","City":"Lake Elsinore","State":"CA","Country":"Riverside"},{"OrderNumber":"20009499-GLT","OrderStatus":"Closed","OrderType":"Title only","TransactionType":"Purchase","MarketingRep":"Title Team","Address":"17834 Calle Los Arboles","Zip":"91748","City":"Rowland Heights","State":"CA","Country":"Los Angeles"},{"OrderNumber":"20009514-GLT","OrderStatus":"InProcess","OrderType":"Title only","TransactionType":"Purchase","MarketingRep":"Corey Velasquez","Address":"1003 Corinthian Way","Zip":"91768","City":"Pomona","State":"CA","Country":"Los Angeles"},{"OrderNumber":"20009529-OCT","OrderStatus":"InProcess","OrderType":"Title & Escrow","TransactionType":"Refinance","MarketingRep":"Angeline Wu","Address":"1106 E 118th Street","Zip":"90059","City":"Los Angeles","State":"CA","Country":"Los Angeles"},{"OrderNumber":"20009530-GLT","OrderStatus":"InProcess","OrderType":"Title only","TransactionType":"Purchase","MarketingRep":"Team Meza","Address":"25411 Cottage Street","Zip":"92354","City":"Loma Linda","State":"CA","Country":"San Bernardino"},{"OrderNumber":"20009547-OCT","OrderStatus":"InProcess","OrderType":"Title only","TransactionType":"Refinance","MarketingRep":"Angeline Wu","Address":"5024 Vail Lane","Zip":"92407","City":"San Bernardino","State":"CA","Country":"San Bernardino"},{"OrderNumber":"20009550-OCT","OrderStatus":"InProcess","OrderType":"Title & Escrow","TransactionType":"Refinance","MarketingRep":"Christy Coffey","Address":"26122 Talega Avenue","Zip":"92653","City":"Laguna Hills","State":"CA","Country":"Orange"},{"OrderNumber":"20009551-OCT","OrderStatus":"InProcess","OrderType":"Title & Escrow","TransactionType":"Refinance","MarketingRep":"Sandra Millar","Address":"12941 West El Sueno Court","Zip":"85375","City":"Sun City West","State":"AZ","Country":"Maricopa"},{"OrderNumber":"20009553-OCT","OrderStatus":"InProcess","OrderType":"Title only","TransactionType":"Refinance","MarketingRep":"Angeline Wu","Address":"1316 North Wyeth Circle","Zip":"92867","City":"Orange","State":"CA","Country":"Orange"},{"OrderNumber":"20009558-GLT","OrderStatus":"Closed","OrderType":"Title only","TransactionType":"Refinance","MarketingRep":"Veronica Sanchez","Address":"14862 Envoy Street","Zip":"91342","City":"Sylmar Area, Los Angeles","State":"CA","Country":"Los Angeles"},{"OrderNumber":"20009570-GLT","OrderStatus":"InProcess","OrderType":"Title only","TransactionType":"Refinance","MarketingRep":"Kevin Green","Address":"3573 East Del Mar Boulevard","Zip":"91107","City":"Pasadena","State":"CA","Country":"Los Angeles"},{"OrderNumber":"20009596-GLT","OrderStatus":"InProcess","OrderType":"Title only","TransactionType":"Refinance","MarketingRep":"Saeed Ghaffari","Address":"2210 West 234th Street","Zip":"90501","City":"Torrance","State":"CA","Country":"Los Angeles"},{"OrderNumber":"20009601-OCT","OrderStatus":"InProcess","OrderType":"Title only","TransactionType":"Refinance","MarketingRep":"Angeline Wu","Address":"1414 Bryce Circle","Zip":"92870","City":"Placentia","State":"CA","Country":"Orange"},{"OrderNumber":"20009615-OCT","OrderStatus":"InProcess","OrderType":"Title only","TransactionType":"Purchase","MarketingRep":"Sonia Flores","Address":"1317 Via Santiago B","Zip":"92882","City":"Corona","State":"CA","Country":"Riverside"},{"OrderNumber":"20009624-OCT","OrderStatus":"InProcess","OrderType":"Title & Escrow","TransactionType":"Refinance","MarketingRep":"Angeline Wu","Address":"4636 Larwin Avenue","Zip":"90630","City":"Cypress","State":"CA","Country":"Orange"},{"OrderNumber":"20009639-OCT","OrderStatus":"InProcess","OrderType":"Title & Escrow","TransactionType":"Purchase","MarketingRep":"Jane Phan","Address":"95 Bellevue Avenue","Zip":"94014-1423","City":"Daly City","State":"CA","Country":"San Mateo"},{"OrderNumber":"20009685-GLT","OrderStatus":"InProcess","OrderType":"Title only","TransactionType":"Purchase","MarketingRep":"Team Meza","Address":"3711 E Hedda Street","Zip":"90805","City":"Long Beach","State":"CA","Country":"Los Angeles"},{"OrderNumber":"20009700-GLT","OrderStatus":"InProcess","OrderType":"Title only","TransactionType":"Purchase","MarketingRep":"Lopez Team","Address":"12594 Atsina Rd","Zip":"92371","City":"Phelan","State":"CA","Country":"San Bernardino"},{"OrderNumber":"20009709-OCT","OrderStatus":"InProcess","OrderType":"Title only","TransactionType":"Refinance","MarketingRep":"Angeline Wu","Address":"2210 Prospect Avenue","Zip":"93446","City":"Paso Robles","State":"CA","Country":"San Luis Obispo"},{"OrderNumber":"20009715-OCT","OrderStatus":"InProcess","OrderType":"Title only","TransactionType":"Refinance","MarketingRep":"Sandra Millar","Address":"14526 Skyline Truck Trail","Zip":"91935","City":"Jamul","State":"CA","Country":"San Diego"},{"OrderNumber":"20009716-GLT","OrderStatus":"InProcess","OrderType":"Title only","TransactionType":"Purchase","MarketingRep":"Title Team","Address":"284 Lamar Drive","Zip":"91711","City":"Claremont","State":"CA","Country":"Los Angeles"},{"OrderNumber":"20009720-OCT","OrderStatus":"InProcess","OrderType":"Title only","TransactionType":"Refinance","MarketingRep":"Angeline Wu","Address":"804 Pacific Ave","Zip":"90291","City":"Los Angeles","State":"CA","Country":"Los Angeles"},{"OrderNumber":"20009722-OCT","OrderStatus":"InProcess","OrderType":"Title only","TransactionType":"Refinance","MarketingRep":"Angeline Wu","Address":"573 Grand Blvd","Zip":"90291","City":"Los Angeles","State":"CA","Country":"Los Angeles"},{"OrderNumber":"20009737-OCT","OrderStatus":"InProcess","OrderType":"Title & Escrow","TransactionType":"Refinance","MarketingRep":"Sandra Millar","Address":"1226 North Hicks Avenue","Zip":"90063","City":"Los Angeles","State":"CA","Country":"Los Angeles"},{"OrderNumber":"20009751-GLT","OrderStatus":"InProcess","OrderType":"Title only","TransactionType":"Purchase","MarketingRep":"Kevin Green","Address":"44557 2nd Street East","Zip":"93535","City":"Lancaster","State":"CA","Country":"Los Angeles"},{"OrderNumber":"20009759-GLT","OrderStatus":"InProcess","OrderType":"Title only","TransactionType":"Purchase","MarketingRep":"Corey Velasquez","Address":"413 S Poplar Street","Zip":"92703","City":"Santa Ana","State":"CA","Country":"Orange"},{"OrderNumber":"20009767-OCT","OrderStatus":"InProcess","OrderType":"Title only","TransactionType":"Purchase","MarketingRep":"Orange County House Account","Address":"2204 Rossmoor Drive","Zip":"95670","City":"Rancho Cordova","State":"CA","Country":"Sacramento"},{"OrderNumber":"20009770-GLT","OrderStatus":"InProcess","OrderType":"Title only","TransactionType":"Purchase","MarketingRep":"Team Meza","Address":"15200 Atkinson Avenue","Zip":"90249","City":"Gardena","State":"CA","Country":"Los Angeles"},{"OrderNumber":"20009775-OCT","OrderStatus":"InProcess","OrderType":"Title only","TransactionType":"Refinance","MarketingRep":"Nicholas Watt","Address":"3316 Rancho Carrizo","Zip":"92009","City":"Carlsbad","State":"CA","Country":"San Diego"},{"OrderNumber":"20009779-OCT","OrderStatus":"InProcess","OrderType":"Title & Escrow","TransactionType":"Refinance","MarketingRep":"Christy Coffey","Address":"1311 3rd Street","Zip":"91340","City":"San Fernando","State":"CA","Country":"Los Angeles"},{"OrderNumber":"20009783-OCT","OrderStatus":"Closed","OrderType":"Title only","TransactionType":"Purchase","MarketingRep":"Title Team","Address":"21291 Calle Recreo","Zip":"92630","City":"Lake Forest","State":"CA","Country":"Orange"},{"OrderNumber":"20009788-OCT","OrderStatus":"Closed","OrderType":"Title only","TransactionType":"Refinance","MarketingRep":"Angeline Wu","Address":"3955 Cherry Ave","Zip":"95118","City":"San Jose","State":"CA","Country":"Santa Clara"},{"OrderNumber":"20009790-GLT","OrderStatus":"InProcess","OrderType":"Title only","TransactionType":"Purchase","MarketingRep":"Ventura House Account","Address":"4960 Woodruff Avenue","Zip":"90713","City":"Lakewood","State":"CA","Country":"Los Angeles"},{"OrderNumber":"20009798-OCT","OrderStatus":"InProcess","OrderType":"Escrow only","TransactionType":"Purchase","MarketingRep":"Jorge Mesa","Address":"16374 Bamboo Street","Zip":"91744","City":"La Puente","State":"CA","Country":"Los Angeles"},{"OrderNumber":"20009801-OCT","OrderStatus":"InProcess","OrderType":"Title only","TransactionType":"Purchase","MarketingRep":"Angeline Wu","Address":"255 Monte Vista#11","Zip":"92672","City":"San Clemente","State":"CA","Country":"Orange"},{"OrderNumber":"20009809-GLT","OrderStatus":"InProcess","OrderType":"Title only","TransactionType":"Purchase","MarketingRep":"Team Meza","Address":"395 West Wabash Street","Zip":"92405","City":"San Bernardino","State":"CA","Country":"San Bernardino"},{"OrderNumber":"20009810-OCT","OrderStatus":"InProcess","OrderType":"Title & Escrow","TransactionType":"Purchase","MarketingRep":"Jane Phan","Address":"12970 Newhope Street","Zip":"92840","City":"Garden Grove","State":"CA","Country":"Orange"},{"OrderNumber":"20009827-OCT","OrderStatus":"InProcess","OrderType":"Title only","TransactionType":"Refinance","MarketingRep":"Angeline Wu","Address":"13652 Taft Street","Zip":"92843","City":"Garden Grove","State":"CA","Country":"Orange"},{"OrderNumber":"20009830-GLT","OrderStatus":"InProcess","OrderType":"Title & Escrow","TransactionType":"Refinance","MarketingRep":"Christy Coffey","Address":"1319 West 131st Street","Zip":"90222","City":"Compton","State":"CA","Country":"Los Angeles"},{"OrderNumber":"20009838-OCT","OrderStatus":"InProcess","OrderType":"Title & Escrow","TransactionType":"Refinance","MarketingRep":"Neil Torquato","Address":"1020 West Road","Zip":"90631","City":"La Habra Heights","State":"CA","Country":"Los Angeles"},{"OrderNumber":"20009841-GLT","OrderStatus":"InProcess","OrderType":"Title & Escrow","TransactionType":"Refinance","MarketingRep":"Team Meza","Address":"11975 Dream St","Zip":"92557","City":"Moreno Valley","State":"CA","Country":"Riverside"},{"OrderNumber":"20009842-GLT","OrderStatus":"InProcess","OrderType":"Title & Escrow","TransactionType":"Refinance","MarketingRep":"Kevin Green","Address":"23021 Bretton Place, (Woodland Hills Area)","Zip":"91364","City":"Los Angeles","State":"CA","Country":"Los Angeles"},{"OrderNumber":"20009843-OCT","OrderStatus":"InProcess","OrderType":"Title only","TransactionType":"Refinance","MarketingRep":"Angeline Wu","Address":"281 Hillandale Court","Zip":"92507","City":"Riverside","State":"CA","Country":"Riverside"},{"OrderNumber":"20009845-GLT","OrderStatus":"InProcess","OrderType":"Title only","TransactionType":"Refinance","MarketingRep":"David Gomez","Address":"14341 Tradewinds Place","Zip":"92555","City":"Moreno Valley","State":"CA","Country":"Riverside"},{"OrderNumber":"20009853-OCT","OrderStatus":"InProcess","OrderType":"Title & Escrow","TransactionType":"Refinance","MarketingRep":"Sandra Millar","Address":"160 Crest Road (Redwood City Area)","Zip":"94062","City":"Woodside","State":"CA","Country":"San Mateo"},{"OrderNumber":"20009855-OCT","OrderStatus":"InProcess","OrderType":"Title only","TransactionType":"Refinance","MarketingRep":"Angeline Wu","Address":"9234 Robinson Ln","Zip":"92883","City":"Corona","State":"CA","Country":"Riverside"},{"OrderNumber":"20009856-OCT","OrderStatus":"InProcess","OrderType":"Title only","TransactionType":"Refinance","MarketingRep":"Sonia Flores","Address":"613 S Ross Street","Zip":"92701","City":"Santa Ana","State":"CA","Country":"Orange"},{"OrderNumber":"20009864-GLT","OrderStatus":"InProcess","OrderType":"Title only","TransactionType":"Refinance","MarketingRep":"Rouanne Garcia","Address":"737 Sarbonne Road","Zip":"90077","City":"Los Angeles","State":"CA","Country":"Los Angeles"},{"OrderNumber":"20009872-PRV","OrderStatus":"InProcess","OrderType":"Escrow only","TransactionType":"Refinance","MarketingRep":"Orange County House Account","Address":"4059 Country Club Dr.","Zip":"90712","City":"Lakewood","State":"CA","Country":"Los Angeles"},{"OrderNumber":"20009879-GLT","OrderStatus":"InProcess","OrderType":"Title & Escrow","TransactionType":"Purchase","MarketingRep":"Michael Nouri","Address":"6107 Mohawk Street","Zip":"93308","City":"Bakersfield","State":"CA","Country":"Kern"},{"OrderNumber":"20009880-OCT","OrderStatus":"InProcess","OrderType":"Title only","TransactionType":"Refinance","MarketingRep":"Angeline Wu","Address":"3308 W Martin Luther King Jr Boulevard","Zip":"90008","City":"Los Angeles","State":"CA","Country":"Los Angeles"},{"OrderNumber":"20009902-OCT","OrderStatus":"InProcess","OrderType":"Title only","TransactionType":"Refinance","MarketingRep":"Sandra Millar","Address":"2 Arrowmaker Trace","Zip":"93923","City":"Carmel","State":"CA","Country":"Monterey"},{"OrderNumber":"20009907-GLT","OrderStatus":"InProcess","OrderType":"Title only","TransactionType":"Purchase","MarketingRep":"Sonia Flores","Address":"3535 Jurupa Avenue","Zip":"92506","City":"Riverside","State":"CA","Country":"Riverside"},{"OrderNumber":"20009917-GLT","OrderStatus":"InProcess","OrderType":"Title only","TransactionType":"Purchase","MarketingRep":"Kevin Green","Address":"21901 Lassen Street, Unit 118","Zip":"91311","City":"Chatsworth","State":"CA","Country":"Los Angeles"},{"OrderNumber":"20009921-OCT","OrderStatus":"InProcess","OrderType":"Title only","TransactionType":"Purchase","MarketingRep":"Nicholas Watt","Address":"2205 Pacific Avenue Unit 101","Zip":"92627","City":"Costa Mesa","State":"CA","Country":"Orange"},{"OrderNumber":"20009922-OCT","OrderStatus":"InProcess","OrderType":"Title & Escrow","TransactionType":"Refinance","MarketingRep":"Linda Ruiz","Address":"10918 Firmona Avenue","Zip":"90304","City":"Inglewood","State":"CA","Country":"Los Angeles"},{"OrderNumber":"20009923-OCT","OrderStatus":"InProcess","OrderType":"Title & Escrow","TransactionType":"Refinance","MarketingRep":"Sandra Millar","Address":"31 Peppertree","Zip":"92660","City":"Newport Beach","State":"CA","Country":"Orange"},{"OrderNumber":"20009926-OCT","OrderStatus":"InProcess","OrderType":"Title only","TransactionType":"Refinance","MarketingRep":"Angeline Wu","Address":"1256 Ravenshoe Way","Zip":"95973","City":"Chico","State":"CA","Country":"Butte"},{"OrderNumber":"20009928-OCT","OrderStatus":"InProcess","OrderType":"Title only","TransactionType":"Purchase","MarketingRep":"Richard Bohn","Address":"13700 White Sail Drive","Zip":"92395","City":"Victorville","State":"CA","Country":"San Bernardino"},{"OrderNumber":"20009942-OCT","OrderStatus":"InProcess","OrderType":"Title only","TransactionType":"Purchase","MarketingRep":"Team Meza","Address":"13971 Clydesdale Run Lane","Zip":"92394","City":"Victorville","State":"CA","Country":"San Bernardino"},{"OrderNumber":"20009955-GLT","OrderStatus":"InProcess","OrderType":"Title only","TransactionType":"Refinance","MarketingRep":"Tony Baumgartner","Address":"Vacant Land 3023-006-051","Zip":"93553","City":"Palmdale","State":"CA","Country":"Los Angeles"},{"OrderNumber":"20009956-GLT","OrderStatus":"InProcess","OrderType":"Title only","TransactionType":"Refinance","MarketingRep":"Sonia Flores","Address":"7107 Santa Anita Circle","Zip":"90620","City":"Buena Park","State":"CA","Country":"Orange"},{"OrderNumber":"20009969-OCT","OrderStatus":"InProcess","OrderType":"Title only","TransactionType":"Refinance","MarketingRep":"Team Meza","Address":"2465 Easy Avenue","Zip":"90810","City":"Long Beach","State":"CA","Country":"Los Angeles"},{"OrderNumber":"20009971-GLT","OrderStatus":"InProcess","OrderType":"Title only","TransactionType":"Refinance","MarketingRep":"Kevin Green","Address":"348 East Avenue J14","Zip":"93535","City":"Lancaster","State":"CA","Country":"Los Angeles"},{"OrderNumber":"20009994-GLT","OrderStatus":"InProcess","OrderType":"Title only","TransactionType":"Refinance","MarketingRep":"Tony Baumgartner","Address":"7334 Vineland Avenue","Zip":"91352","City":"Los Angeles","State":"CA","Country":"Los Angeles"},{"OrderNumber":"20009995-GLT","OrderStatus":"InProcess","OrderType":"Title only","TransactionType":"Purchase","MarketingRep":"Louis Morreale","Address":"10451 Ormond Street","Zip":"91040","City":"Los Angeles","State":"CA","Country":"Los Angeles"},{"OrderNumber":"20009997-GLT","OrderStatus":"InProcess","OrderType":"Title only","TransactionType":"Refinance","MarketingRep":"Tony Baumgartner","Address":"1401 Valley View Road","Zip":"91202","City":"Glendale","State":"CA","Country":"Los Angeles"},{"OrderNumber":"20010007-GLT","OrderStatus":"InProcess","OrderType":"Title only","TransactionType":"Refinance","MarketingRep":"Tony Baumgartner","Address":"2431 Montrose Avenue","Zip":"91020","City":"Los Angeles","State":"CA","Country":"Los Angeles"},{"OrderNumber":"20010033-ONT","OrderStatus":"InProcess","OrderType":"Title & Escrow","TransactionType":"Refinance","MarketingRep":"Angeline Wu","Address":"80190 Via Capri","Zip":"92253","City":"La Quinta","State":"CA","Country":"Riverside"},{"OrderNumber":"20010034-OCT","OrderStatus":"InProcess","OrderType":"Title only","TransactionType":"Refinance","MarketingRep":"David Gomez","Address":"1563 Turningcrest Ln","Zip":"92223","City":"Beaumont","State":"CA","Country":"Riverside"},{"OrderNumber":"20010047-OCT","OrderStatus":"InProcess","OrderType":"Title & Escrow","TransactionType":"Refinance","MarketingRep":"Sandra Millar","Address":"45410 Cook Street","Zip":"92210","City":"Indian Wells","State":"CA","Country":"Riverside"},{"OrderNumber":"20010057-GLT","OrderStatus":"InProcess","OrderType":"Title only","TransactionType":"Purchase","MarketingRep":"David Gomez","Address":"5405 W 4th Street","Zip":"92703","City":"Santa Ana","State":"CA","Country":"Orange"},{"OrderNumber":"20010067-OCT","OrderStatus":"InProcess","OrderType":"Title & Escrow","TransactionType":"Refinance","MarketingRep":"Angeline Wu","Address":"2901 Calle Gaucho","Zip":"92673","City":"San Clemente","State":"CA","Country":"Orange"},{"OrderNumber":"20010068-OCT","OrderStatus":"InProcess","OrderType":"Title only","TransactionType":"Purchase","MarketingRep":"Richard Bohn","Address":"42120 Cosmic Drive","Zip":"92592","City":"Temecula","State":"CA","Country":"Riverside"},{"OrderNumber":"20010087-GLT","OrderStatus":"InProcess","OrderType":"Title only","TransactionType":"Purchase","MarketingRep":"Ventura House Account","Address":"6455 La Jolla Boulevard#206","Zip":"92037","City":"La Jolla","State":"CA","Country":"San Diego"},{"OrderNumber":"20010111-GLT","OrderStatus":"InProcess","OrderType":"Title only","TransactionType":"Purchase","MarketingRep":"Lopez Team","Address":"25175 Kalmia Avenue","Zip":"92557","City":"Moreno Valley","State":"CA","Country":"Riverside"},{"OrderNumber":"20010117-GLT","OrderStatus":"InProcess","OrderType":"Title only","TransactionType":"Refinance","MarketingRep":"Sonia Flores","Address":"2539 College Drive","Zip":"92410","City":"San Bernardino","State":"CA","Country":"San Bernardino"},{"OrderNumber":"20010120-OCT","OrderStatus":"InProcess","OrderType":"Title only","TransactionType":"Purchase","MarketingRep":"Christy Coffey","Address":"476 North Richard Street","Zip":"92869","City":"Orange","State":"CA","Country":"Orange"},{"OrderNumber":"20010125-GLT","OrderStatus":"InProcess","OrderType":"Title only","TransactionType":"Refinance","MarketingRep":"Kevin Green","Address":"13951 Addison Street","Zip":"91423","City":"Sherman Oaks","State":"CA","Country":"Los Angeles"},{"OrderNumber":"20010129-GLT","OrderStatus":"InProcess","OrderType":"Title only","TransactionType":"Purchase","MarketingRep":"Corey Velasquez","Address":"1045 East Walnut Avenue","Zip":"91501","City":"Burbank","State":"CA","Country":"Los Angeles"},{"OrderNumber":"20010130-OCT","OrderStatus":"InProcess","OrderType":"Title only","TransactionType":"Refinance","MarketingRep":"Team Meza","Address":"4387 Monte Verde Avenue","Zip":"91766","City":"Pomona","State":"CA","Country":"San Bernardino"},{"OrderNumber":"20010132-OCT","OrderStatus":"InProcess","OrderType":"Title & Escrow","TransactionType":"Refinance","MarketingRep":"Angeline Wu","Address":"4280 Colorado Avenue","Zip":"95382","City":"Turlock","State":"CA","Country":"Stanislaus"},{"OrderNumber":"20010134-GLT","OrderStatus":"InProcess","OrderType":"Title only","TransactionType":"Purchase","MarketingRep":"Ventura House Account","Address":"4729 Fall Avenue","Zip":"94804","City":"Richmond","State":"CA","Country":"Contra Costa"},{"OrderNumber":"99100532","OrderStatus":"Closed","OrderType":"Trustee Sale Guarantee","TransactionType":"Other","MarketingRep":"Dan Culnane","Address":"33350 ROBIN DRIVE","Zip":"92341","City":"Green Valley Lake","State":"CA","Country":"San Bernardino"},{"OrderNumber":"99100533","OrderStatus":"Closed","OrderType":"Trustee Sale Guarantee","TransactionType":"Other","MarketingRep":"Dan Culnane","Address":"1346 WEST SCHOOL ST","Zip":"90220","City":"Compton","State":"CA","Country":"Los Angeles"},{"OrderNumber":"20010137-GLT","OrderStatus":"InProcess","OrderType":"Title only","TransactionType":"Purchase","MarketingRep":"Team Meza","Address":"1125 Hemlock Lane","Zip":"92314","City":"Big Bear City","State":"CA","Country":"San Bernardino"},{"OrderNumber":"20010145-GLT","OrderStatus":"InProcess","OrderType":"Title only","TransactionType":"Purchase","MarketingRep":"Title Team","Address":"16978 Colchester Way","Zip":"91745","City":"Hacienda Heights","State":"CA","Country":"Los Angeles"},{"OrderNumber":"20010150-GLT","OrderStatus":"InProcess","OrderType":"Title only","TransactionType":"Refinance","MarketingRep":"Justin Nouri","Address":"5915 Vesper Avenue","Zip":"91411","City":"Sherman Oaks","State":"CA","Country":"Los Angeles"},{"OrderNumber":"20010155-OCT","OrderStatus":"InProcess","OrderType":"Title & Escrow","TransactionType":"Refinance","MarketingRep":"Sonia Flores","Address":"14351 Cronese Road","Zip":"92307","City":"Apple Valley","State":"CA","Country":"San Bernardino"},{"OrderNumber":"20010159-OCT","OrderStatus":"InProcess","OrderType":"Title only","TransactionType":"Refinance","MarketingRep":"Angeline Wu","Address":"1516 Teta Drive","Zip":"92882","City":"Corona","State":"CA","Country":"Riverside"},{"OrderNumber":"20010160-OCT","OrderStatus":"InProcess","OrderType":"Title & Escrow","TransactionType":"Refinance","MarketingRep":"Sandra Millar","Address":"4709 Cortland Drive (Corona Del Mar Area)","Zip":"92625","City":"Newport Beach","State":"CA","Country":"Orange"},{"OrderNumber":"20007662-OCT","OrderStatus":"InProcess","OrderType":"Title & Escrow","TransactionType":"Refinance","MarketingRep":"Neil Torquato","Address":"751 Spruce Street","Zip":"94118","City":"San Francisco","State":"CA","Country":"San Francisco"},{"OrderNumber":"20010167-GLT","OrderStatus":"InProcess","OrderType":"Title & Escrow","TransactionType":"Purchase","MarketingRep":"Corey Velasquez","Address":"Vacant Land APN#084-010-46-00-9","Zip":"93555","City":"Ridgecrest","State":"CA","Country":"Kern"},{"OrderNumber":"20010171-OCT","OrderStatus":"Canceled","OrderType":"Title only","TransactionType":"Purchase","MarketingRep":"Angeline Wu","Address":"21652 Hanakai Lane","Zip":"92646","City":"Huntington Beach","State":"CA","Country":"Orange"},{"OrderNumber":"20010174-OCT","OrderStatus":"InProcess","OrderType":"Title & Escrow","TransactionType":"Refinance","MarketingRep":"Sandra Millar","Address":"23640 North 35th Drive","Zip":"85310","City":"Glendale","State":"AZ","Country":"Maricopa"},{"OrderNumber":"99100535","OrderStatus":"Closed","OrderType":"Trustee Sale Guarantee","TransactionType":"Other","MarketingRep":"Sandra Millar","Address":"11751 VILLAGE POND WAY","Zip":"95742","City":"Rancho Cordova","State":"CA","Country":"Sacramento"},{"OrderNumber":"20010188-OCT","OrderStatus":"InProcess","OrderType":"Title only","TransactionType":"Refinance","MarketingRep":"Angeline Wu","Address":"14037 Charlemagne Avenue","Zip":"90706","City":"Bellflower","State":"CA","Country":"Los Angeles"},{"OrderNumber":"20010198-GLT","OrderStatus":"InProcess","OrderType":"Title only","TransactionType":"Refinance","MarketingRep":"Kevin Green","Address":"22105 Cajun Court, (Canoga Park Area)","Zip":"91303","City":"Los Angeles","State":"CA","Country":"Los Angeles"},{"OrderNumber":"20010199-GLT","OrderStatus":"InProcess","OrderType":"Title only","TransactionType":"Purchase","MarketingRep":"Corey Velasquez","Address":"5221 Ocotillo Ave","Zip":"93555","City":"Ridgecrest","State":"CA","Country":"Kern"},{"OrderNumber":"20010204-OCT","OrderStatus":"InProcess","OrderType":"Title only","TransactionType":"Purchase","MarketingRep":"Angeline Wu","Address":"2755 Alamo Street","Zip":"93065","City":"Simi Valley","State":"CA","Country":"Ventura"},{"OrderNumber":"20010220-OCT","OrderStatus":"Canceled","OrderType":"Title & Escrow","TransactionType":"Refinance","MarketingRep":"Sandra Millar","Address":"647 Vista Bonita","Zip":"92660","City":"Newport Beach","State":"CA","Country":"Orange"},{"OrderNumber":"20010232-OCT","OrderStatus":"InProcess","OrderType":"Title only","TransactionType":"Purchase","MarketingRep":"Sonia Flores","Address":"7406 West 85th Street","Zip":"90045","City":"Los Angeles","State":"CA","Country":"Los Angeles"},{"OrderNumber":"20010236-OCT","OrderStatus":"InProcess","OrderType":"Title & Escrow","TransactionType":"Refinance","MarketingRep":"Orange County House Account","Address":"2920 Concord Avenue","Zip":"91803","City":"Alhambra","State":"CA","Country":"Los Angeles"},{"OrderNumber":"99100537","OrderStatus":"Closed","OrderType":"Trustee Sale Guarantee","TransactionType":"Other","MarketingRep":"Sandra Millar","Address":"7228 S HALLDALE AVENUE","Zip":"90047","City":"Los Angeles","State":"CA","Country":"Los Angeles"},{"OrderNumber":"20010240-GLT","OrderStatus":"InProcess","OrderType":"Title only","TransactionType":"Refinance","MarketingRep":"Tony Baumgartner","Address":"109 North Westlake Avenue","Zip":"90026-5330","City":"Los Angeles","State":"CA","Country":"Los Angeles"},{"OrderNumber":"20010245-GLT","OrderStatus":"InProcess","OrderType":"Title only","TransactionType":"Purchase","MarketingRep":"Team Meza","Address":"8703 Mines Ave","Zip":"90660","City":"Pico Rivera","State":"CA","Country":"Los Angeles"},{"OrderNumber":"20010247-GLT","OrderStatus":"InProcess","OrderType":"Title only","TransactionType":"Purchase","MarketingRep":"Glendale  House Account","Address":"29253 Val Verde Road","Zip":"91384","City":"Los Angeles","State":"CA","Country":"Los Angeles"},{"OrderNumber":"20010255-OCT","OrderStatus":"InProcess","OrderType":"Title & Escrow","TransactionType":"Refinance","MarketingRep":"Sandra Millar","Address":"6311 North San Pablo Avenue","Zip":"93704","City":"Fresno","State":"CA","Country":"Fresno"},{"OrderNumber":"20010256-OCT","OrderStatus":"InProcess","OrderType":"Title & Escrow","TransactionType":"Purchase","MarketingRep":"Angeline Wu","Address":"2740 San Francisco","Zip":"90806","City":"Long Beach","State":"CA","Country":"Los Angeles"},{"OrderNumber":"20010257-OCT","OrderStatus":"InProcess","OrderType":"Title only","TransactionType":"Refinance","MarketingRep":"Angeline Wu","Address":"1025 Gallery Court","Zip":"92114","City":"San Diego","State":"CA","Country":"San Diego"},{"OrderNumber":"20010265-GLT","OrderStatus":"InProcess","OrderType":"Title only","TransactionType":"Purchase","MarketingRep":"Team Meza","Address":"642 Humboldt Court","Zip":"91764","City":"Ontario","State":"CA","Country":"San Bernardino"},{"OrderNumber":"20010275-OCT","OrderStatus":"InProcess","OrderType":"Title & Escrow","TransactionType":"Refinance","MarketingRep":"Orange County House Account","Address":"16206 Canterbury Court","Zip":"93314","City":"Bakersfield","State":"CA","Country":"Kern"},{"OrderNumber":"20010276-OCT","OrderStatus":"InProcess","OrderType":"Title & Escrow","TransactionType":"Purchase","MarketingRep":"Orange County House Account","Address":"21235 79th Street","Zip":"93505","City":"California City","State":"CA","Country":"Kern"},{"OrderNumber":"20010277-OCT","OrderStatus":"InProcess","OrderType":"Title & Escrow","TransactionType":"Refinance","MarketingRep":"Sandra Millar","Address":"22009/22017 Sherman Way","Zip":"91303","City":"Los Angeles","State":"CA","Country":"Los Angeles"},{"OrderNumber":"20010279-GLT","OrderStatus":"InProcess","OrderType":"Title only","TransactionType":"Refinance","MarketingRep":"Kevin Green","Address":"37860 MELTON AVE","Zip":"93550","City":"Palmdale","State":"CA","Country":"Los Angeles"},{"OrderNumber":"20010281-GLT","OrderStatus":"InProcess","OrderType":"Title only","TransactionType":"Refinance","MarketingRep":"Glendale  House Account","Address":"5627 South Central Avenue","Zip":"90011","City":"Los Angeles","State":"CA","Country":"Los Angeles"},{"OrderNumber":"20010291-GLT","OrderStatus":"InProcess","OrderType":"Title & Escrow","TransactionType":"Refinance","MarketingRep":"Michael Nouri","Address":"6915-6917, Krause Avenue","Zip":"94605","City":"Oakland","State":"CA","Country":"Alameda"},{"OrderNumber":"20010293-OCT","OrderStatus":"InProcess","OrderType":"Title only","TransactionType":"Purchase","MarketingRep":"Ventura House Account","Address":"3391 & 3391 1/2 Cazador Street","Zip":"90065","City":"Los Angeles","State":"CA","Country":"Los Angeles"},{"OrderNumber":"20010295-OCT","OrderStatus":"InProcess","OrderType":"Title & Escrow","TransactionType":"Refinance","MarketingRep":"Sandra Millar","Address":"7925 Lichen Drive","Zip":"95621","City":"Citrus Heights","State":"CA","Country":"Sacramento"},{"OrderNumber":"99100546","OrderStatus":"Closed","OrderType":"Trustee Sale Guarantee","TransactionType":"Other","MarketingRep":"Sandra Millar","Address":"39695 BERENDA RD","Zip":"92591","City":"Temecula","State":"CA","Country":"Riverside"},{"OrderNumber":"20010297-GLT","OrderStatus":"InProcess","OrderType":"Title only","TransactionType":"Purchase","MarketingRep":"Title Team","Address":"9406 South Harvard Boulevard","Zip":"90047","City":"Los Angeles","State":"CA","Country":"Los Angeles"},{"OrderNumber":"20010298-OCT","OrderStatus":"InProcess","OrderType":"Title only","TransactionType":"Refinance","MarketingRep":"Sandra Millar","Address":"1932 Fell Street, #1","Zip":"94117","City":"San Francisco","State":"CA","Country":"San Francisco"},{"OrderNumber":"20010299-OCT","OrderStatus":"InProcess","OrderType":"Title only","TransactionType":"Purchase","MarketingRep":"Simon Wu","Address":"101 Omar","Zip":"92620","City":"Irvine","State":"CA","Country":"Orange"},{"OrderNumber":"20010303-OCT","OrderStatus":"InProcess","OrderType":"Title & Escrow","TransactionType":"Refinance","MarketingRep":"Sandra Millar","Address":"8279 Melrose Lane","Zip":"92021","City":"El Cajon","State":"CA","Country":"San Diego"},{"OrderNumber":"20010305-OCT","OrderStatus":"InProcess","OrderType":"Title only","TransactionType":"Refinance","MarketingRep":"Sonia Flores","Address":"6838 Amestoy Avenue","Zip":"91406","City":"Van Nuys","State":"CA","Country":"Los Angeles"},{"OrderNumber":"20010318-OCT","OrderStatus":"InProcess","OrderType":"Title & Escrow","TransactionType":"Refinance","MarketingRep":"Sandra Millar","Address":"122 South Wilton Place","Zip":"90004","City":"Los Angeles","State":"CA","Country":"Los Angeles"},{"OrderNumber":"20010319-OCT","OrderStatus":"InProcess","OrderType":"Title & Escrow","TransactionType":"Refinance","MarketingRep":"Sandra Millar","Address":"Vacant Land","Zip":"92408","City":"San Bernardino","State":"CA","Country":"San Bernardino"},{"OrderNumber":"20010327-OCT","OrderStatus":"InProcess","OrderType":"Title only","TransactionType":"Refinance","MarketingRep":"Christy Coffey","Address":"8939 Rhine River Avenue","Zip":"92708","City":"Santa Ana","State":"CA","Country":"Orange"},{"OrderNumber":"20010331-OCT","OrderStatus":"InProcess","OrderType":"Title only","TransactionType":"Refinance","MarketingRep":"Linda Ruiz","Address":"204 E Plymouth Street, #20","Zip":"90302","City":"Inglewood","State":"CA","Country":"Los Angeles"},{"OrderNumber":"20010341-GLT","OrderStatus":"InProcess","OrderType":"Title only","TransactionType":"Purchase","MarketingRep":"Rouanne Garcia","Address":"2232 Meadowvale Avenue","Zip":"90031","City":"Los Angeles","State":"CA","Country":"Los Angeles"},{"OrderNumber":"20010342-PRV","OrderStatus":"InProcess","OrderType":"Title & Escrow","TransactionType":"Purchase","MarketingRep":"Orange County House Account","Address":"16632 Teresa Street","Zip":"93292","City":"Visalia","State":"CA","Country":"Tulare"},{"OrderNumber":"20010345-OCT","OrderStatus":"InProcess","OrderType":"Title & Escrow","TransactionType":"Refinance","MarketingRep":"Sandra Millar","Address":"2719 All View Way","Zip":"94002","City":"Belmont","State":"CA","Country":"San Mateo"},{"OrderNumber":"20010347-OCT","OrderStatus":"InProcess","OrderType":"Title only","TransactionType":"Refinance","MarketingRep":"Richard Bohn","Address":"2035 31st St","Zip":"92104","City":"San Diego","State":"CA","Country":"San Diego"},{"OrderNumber":"20010348-PRV","OrderStatus":"InProcess","OrderType":"Title & Escrow","TransactionType":"Purchase","MarketingRep":"Orange County House Account","Address":"16554 Dillon Avenue","Zip":"93292","City":"Visalia","State":"CA","Country":"Tulare"},{"OrderNumber":"20010349-GLT","OrderStatus":"InProcess","OrderType":"Title & Escrow","TransactionType":"Refinance","MarketingRep":"Michael Nouri","Address":"29471 Camino Saguaro","Zip":"91354","City":"Santa Clarita","State":"CA","Country":"Los Angeles"},{"OrderNumber":"20010354-OCT","OrderStatus":"InProcess","OrderType":"Title only","TransactionType":"Refinance","MarketingRep":"Angeline Wu","Address":"9466 Sunland Boulevard","Zip":"91352","City":"Sun Valley","State":"CA","Country":"Los Angeles"},{"OrderNumber":"20010365-OCT","OrderStatus":"InProcess","OrderType":"Title only","TransactionType":"Refinance","MarketingRep":"Angeline Wu","Address":"18190 Larkspur Rd","Zip":"92301","City":"Adelanto","State":"CA","Country":"San Bernardino"},{"OrderNumber":"20010366-OCT","OrderStatus":"InProcess","OrderType":"Title only","TransactionType":"Refinance","MarketingRep":"Angeline Wu","Address":"4 Moonlight Isle","Zip":"92694","City":"Mission Viejo","State":"CA","Country":"Orange"},{"OrderNumber":"20010367-OCT","OrderStatus":"InProcess","OrderType":"Title only","TransactionType":"Purchase","MarketingRep":"Angeline Wu","Address":"3965 S Western Ave","Zip":"90062","City":"Los Angeles","State":"CA","Country":"Los Angeles"},{"OrderNumber":"20010368-ONT","OrderStatus":"InProcess","OrderType":"Title & Escrow","TransactionType":"Refinance","MarketingRep":"Lopez Team","Address":"7087 Manhattan Drive","Zip":"92506","City":"Riverside","State":"CA","Country":"Riverside"},{"OrderNumber":"20010369-OCT","OrderStatus":"InProcess","OrderType":"Title only","TransactionType":"Refinance","MarketingRep":"Sonia Flores","Address":"4196 N Mountain View Avenue","Zip":"92407","City":"San Bernardino","State":"CA","Country":"San Bernardino"},{"OrderNumber":"20010371-GLT","OrderStatus":"InProcess","OrderType":"Title & Escrow","TransactionType":"Purchase","MarketingRep":"David Gomez","Address":"16590 Terrace Lane, Unit G","Zip":"92355","City":"Fontana","State":"CA","Country":"San Bernardino"},{"OrderNumber":"20010374-OCT","OrderStatus":"InProcess","OrderType":"Title & Escrow","TransactionType":"Refinance","MarketingRep":"Angeline Wu","Address":"537 Mcdonald Avenue","Zip":"90744","City":"Wilmington","State":"CA","Country":"Los Angeles"},{"OrderNumber":"20010376-OCT","OrderStatus":"InProcess","OrderType":"Title only","TransactionType":"Purchase","MarketingRep":"Team Meza","Address":"4548 Chelsea Court","Zip":"90630","City":"Cypress","State":"CA","Country":"Orange"},{"OrderNumber":"20010377-OCT","OrderStatus":"InProcess","OrderType":"Title only","TransactionType":"Refinance","MarketingRep":"Nicholas Watt","Address":"1740 S Helen Avenue","Zip":"91762","City":"Ontario","State":"CA","Country":"San Bernardino"},{"OrderNumber":"20010379-OCT","OrderStatus":"InProcess","OrderType":"Title only","TransactionType":"Purchase","MarketingRep":"Nicholas Watt","Address":"925 Lakeview Boulevard, Unit #1","Zip":"93546","City":"Mammoth Lakes","State":"CA","Country":"Mono"},{"OrderNumber":"20010382-GLT","OrderStatus":"InProcess","OrderType":"Title only","TransactionType":"Purchase","MarketingRep":"Louis Morreale","Address":"350 North Park Avenue","Zip":"92376","City":"Rialto","State":"CA","Country":"San Bernardino"},{"OrderNumber":"20010383-OCT","OrderStatus":"InProcess","OrderType":"Title only","TransactionType":"Refinance","MarketingRep":"Angeline Wu","Address":"147 Napoleon Street","Zip":"90293","City":"Playa Del Rey","State":"CA","Country":"Los Angeles"},{"OrderNumber":"20010388-GLT","OrderStatus":"InProcess","OrderType":"Title only","TransactionType":"Refinance","MarketingRep":"Kevin Green","Address":"303 Hoyt Court","Zip":"94585","City":"Suisun City","State":"CA","Country":"Solano"},{"OrderNumber":"20010391-OCT","OrderStatus":"InProcess","OrderType":"Title only","TransactionType":"Refinance","MarketingRep":"Sandra Millar","Address":"223 Monument Parkway","Zip":"92570","City":"Perris","State":"CA","Country":"Riverside"},{"OrderNumber":"20010393-GLT","OrderStatus":"InProcess","OrderType":"Title & Escrow","TransactionType":"Refinance","MarketingRep":"Michael Nouri","Address":"10711 South Western Avenue","Zip":"90047","City":"Los Angeles","State":"CA","Country":"Los Angeles"},{"OrderNumber":"20010394-GLT","OrderStatus":"InProcess","OrderType":"Title only","TransactionType":"Refinance","MarketingRep":"Michael Nouri","Address":"43240 7th Street East","Zip":"93535","City":"Lancaster","State":"CA","Country":"Los Angeles"},{"OrderNumber":"20010397-GLT","OrderStatus":"InProcess","OrderType":"Title only","TransactionType":"Refinance","MarketingRep":"Tony Baumgartner","Address":"8530 Minuet Place","Zip":"91402","City":"Los Angeles","State":"CA","Country":"Los Angeles"},{"OrderNumber":"20010398-GLT","OrderStatus":"InProcess","OrderType":"Title only","TransactionType":"Refinance","MarketingRep":"Kevin Green","Address":"12857 Herrick Avenue","Zip":"91342","City":"Sylmar","State":"CA","Country":"Los Angeles"},{"OrderNumber":"20010401-OCT","OrderStatus":"InProcess","OrderType":"Title & Escrow","TransactionType":"Refinance","MarketingRep":"Sandra Millar","Address":"206 Thorne Street","Zip":"90042","City":"Los Angeles","State":"CA","Country":"Los Angeles"},{"OrderNumber":"20010402-OCT","OrderStatus":"InProcess","OrderType":"Title & Escrow","TransactionType":"Refinance","MarketingRep":"Sandra Millar","Address":"1110 - 1114  University Avenue","Zip":"94702","City":"Berkeley","State":"CA","Country":"Alameda"},{"OrderNumber":"20010403-OCT","OrderStatus":"InProcess","OrderType":"Title & Escrow","TransactionType":"Refinance","MarketingRep":"Sandra Millar","Address":"663 Chicago Avenue","Zip":"95206","City":"Stockton","State":"CA","Country":"San Joaquin"},{"OrderNumber":"20010408-GLT","OrderStatus":"InProcess","OrderType":"Title only","TransactionType":"Refinance","MarketingRep":"Team Meza","Address":"201 S 4th Street","Zip":"90640","City":"Montebello","State":"CA","Country":"Los Angeles"},{"OrderNumber":"20010410-OCT","OrderStatus":"InProcess","OrderType":"Title only","TransactionType":"Refinance","MarketingRep":"Neil Torquato","Address":"10485 La Sombra Avenue","Zip":"92708","City":"Santa Ana","State":"CA","Country":"Orange"},{"OrderNumber":"20010412-GLT","OrderStatus":"InProcess","OrderType":"Title only","TransactionType":"Refinance","MarketingRep":"David Gomez","Address":"337 Lincoln Avenue","Zip":"91767","City":"Pomona","State":"CA","Country":"Los Angeles"},{"OrderNumber":"20010415-GLT","OrderStatus":"InProcess","OrderType":"Title only","TransactionType":"Refinance","MarketingRep":"Tony Baumgartner","Address":"5822 Holser Canyon Rd","Zip":"93040","City":"Piru","State":"CA","Country":"Ventura"},{"OrderNumber":"20010416-GLT","OrderStatus":"InProcess","OrderType":"Title only","TransactionType":"Refinance","MarketingRep":"Tony Baumgartner","Address":"0 VACANT LAND","Zip":"","City":"","State":"CA","Country":""},{"OrderNumber":"20010420-OCT","OrderStatus":"InProcess","OrderType":"Title only","TransactionType":"Purchase","MarketingRep":"Orange County House Account","Address":"1316 E Romneya Drive","Zip":"92805","City":"Anaheim","State":"CA","Country":"Orange"},{"OrderNumber":"20010421-GLT","OrderStatus":"InProcess","OrderType":"Title only","TransactionType":"Purchase","MarketingRep":"Glendale  House Account","Address":"12415 Mesa Verde Drive","Zip":"92082","City":"Valley Center","State":"CA","Country":"San Diego"},{"OrderNumber":"20010422-GLT","OrderStatus":"InProcess","OrderType":"Title only","TransactionType":"Purchase","MarketingRep":"Lopez Team","Address":"17507 Cottrell Blvd","Zip":"92530","City":"Lake Elsinore","State":"CA","Country":"Riverside"},{"OrderNumber":"20010425-GLT-CSS","OrderStatus":"Duplicate","OrderType":"Title & Escrow","TransactionType":"Refinance","MarketingRep":"Title Gals","Address":"80782 Via Puerta Azul","Zip":"92253","City":"La Quinta","State":"CA","Country":"Riverside"},{"OrderNumber":"20010431-GLT","OrderStatus":"InProcess","OrderType":"Title only","TransactionType":"Purchase","MarketingRep":"Lopez Team","Address":"220 West Highland Avenue","Zip":"92373","City":"Redlands","State":"CA","Country":"San Bernardino"},{"OrderNumber":"20010435-GLT","OrderStatus":"InProcess","OrderType":"Title only","TransactionType":"Refinance","MarketingRep":"Lopez Team","Address":"14795 Apple Valley Road","Zip":"92307","City":"Apple Valley","State":"CA","Country":"San Bernardino"},{"OrderNumber":"20010436-GLT","OrderStatus":"InProcess","OrderType":"Title only","TransactionType":"Purchase","MarketingRep":"Lopez Team","Address":"18340 Walnut Avenue","Zip":"92532","City":"Lake Elsinore","State":"CA","Country":"Riverside"},{"OrderNumber":"20010437-OCT","OrderStatus":"InProcess","OrderType":"Title only","TransactionType":"Refinance","MarketingRep":"Angeline Wu","Address":"39858 Everly Place","Zip":"92591","City":"Temecula","State":"CA","Country":"Riverside"},{"OrderNumber":"20010440-GLT","OrderStatus":"InProcess","OrderType":"Title & Escrow","TransactionType":"Refinance","MarketingRep":"Louis Morreale","Address":"2878 Crystal Springs Road","Zip":"95709","City":"Camino","State":"CA","Country":"El Dorado"},{"OrderNumber":"20010441-GLT","OrderStatus":"InProcess","OrderType":"Title only","TransactionType":"Refinance","MarketingRep":"David Gomez","Address":"Congress St","Zip":"92324","City":"Colton","State":"CA","Country":"San Bernardino"},{"OrderNumber":"20010445-OCT","OrderStatus":"InProcess","OrderType":"Escrow only","TransactionType":"Refinance","MarketingRep":"Team Meza","Address":"602 W. Granada Ct","Zip":"91762","City":"Ontario","State":"CA","Country":"San Bernardino"},{"OrderNumber":"20010447-GLT","OrderStatus":"InProcess","OrderType":"Title only","TransactionType":"Refinance","MarketingRep":"Michael Nouri","Address":"23047 Del Valle Street","Zip":"91364","City":"Los Angeles","State":"CA","Country":"Los Angeles"},{"OrderNumber":"20010449-OCT","OrderStatus":"InProcess","OrderType":"Title only","TransactionType":"Purchase","MarketingRep":"Christy Coffey","Address":"Vacant Land","Zip":"92262","City":"Palm Springs","State":"CA","Country":"Riverside"},{"OrderNumber":"20010450-GLT","OrderStatus":"InProcess","OrderType":"Title only","TransactionType":"Purchase","MarketingRep":"Justin Nouri","Address":"7107 Coldwater Canyon Avenue","Zip":"91605","City":"Los Angeles","State":"CA","Country":"Los Angeles"},{"OrderNumber":"20010451-GLT","OrderStatus":"InProcess","OrderType":"Title only","TransactionType":"Purchase","MarketingRep":"Team Meza","Address":"929 W Ashiya Road","Zip":"90640","City":"Montebello","State":"CA","Country":"Los Angeles"},{"OrderNumber":"20010452-GLT","OrderStatus":"InProcess","OrderType":"Title only","TransactionType":"Purchase","MarketingRep":"Vito D\'Alessandro","Address":"1480 E Colver Place","Zip":"91724","City":"Covina","State":"CA","Country":"Los Angeles"},{"OrderNumber":"20010453-GLT","OrderStatus":"InProcess","OrderType":"Title only","TransactionType":"Purchase","MarketingRep":"Team Meza","Address":"3330 W Stonybrook Dr","Zip":"92804","City":"Anaheim","State":"CA","Country":"Orange"},{"OrderNumber":"20010454-GLT","OrderStatus":"InProcess","OrderType":"Title only","TransactionType":"Refinance","MarketingRep":"Ventura House Account","Address":"11547 Bing Street","Zip":"92223","City":"Beaumont","State":"CA","Country":"Riverside"},{"OrderNumber":"20010455-OCT","OrderStatus":"InProcess","OrderType":"Title only","TransactionType":"Purchase","MarketingRep":"Angeline Wu","Address":"625 East Del Mar Boulevard #303","Zip":"91101","City":"Pasadena","State":"CA","Country":"Los Angeles"},{"OrderNumber":"20010456-GLT","OrderStatus":"InProcess","OrderType":"Title only","TransactionType":"Purchase","MarketingRep":"Team Meza","Address":"10755 Muller Road","Zip":"93307","City":"Bakersfield","State":"CA","Country":"Kern"},{"OrderNumber":"20010457-OCT","OrderStatus":"InProcess","OrderType":"Title only","TransactionType":"Refinance","MarketingRep":"David Gomez","Address":"954 N Napa Avenue","Zip":"91764","City":"Ontario","State":"CA","Country":"San Bernardino"},{"OrderNumber":"20010458-GLT","OrderStatus":"InProcess","OrderType":"Title only","TransactionType":"Purchase","MarketingRep":"Team Meza","Address":"12647 Lakewood Boulevard","Zip":"90242","City":"Downey","State":"CA","Country":"Los Angeles"},{"OrderNumber":"20010459-OCT","OrderStatus":"InProcess","OrderType":"Title only","TransactionType":"Refinance","MarketingRep":"Angeline Wu","Address":"1423 E 47th Street","Zip":"90011","City":"Los Angeles","State":"CA","Country":"Los Angeles"},{"OrderNumber":"20010460-GLT","OrderStatus":"InProcess","OrderType":"Title only","TransactionType":"Purchase","MarketingRep":"Kevin Green","Address":"198 N Pecos Rd","Zip":"89074","City":"Henderson","State":"NV","Country":"Clark"},{"OrderNumber":"20010461-GLT","OrderStatus":"InProcess","OrderType":"Title only","TransactionType":"Refinance","MarketingRep":"Glendale  House Account","Address":"1659 W 37th Steet","Zip":"90018","City":"Los Angeles","State":"CA","Country":"Los Angeles"},{"OrderNumber":"20010462-OCT","OrderStatus":"InProcess","OrderType":"Title only","TransactionType":"Refinance","MarketingRep":"Angeline Wu","Address":"28084 Oakhaven Ln","Zip":"92584","City":"Menifee","State":"CA","Country":"Riverside"},{"OrderNumber":"99100553","OrderStatus":"Closed","OrderType":"Trustee Sale Guarantee","TransactionType":"Other","MarketingRep":"Sandra Millar","Address":"2093 SAN LUIS STREET","Zip":"93635","City":"Los Banos","State":"CA","Country":"Merced"},{"OrderNumber":"20010463-OCT","OrderStatus":"InProcess","OrderType":"Title & Escrow","TransactionType":"Refinance","MarketingRep":"Sandra Millar","Address":"16321 Lakewood Blvd","Zip":"90706","City":"Bellflower","State":"CA","Country":"Los Angeles"},{"OrderNumber":"20010464-GLT","OrderStatus":"InProcess","OrderType":"Title only","TransactionType":"Refinance","MarketingRep":"Nini Kerns","Address":"390 E Arrow Hwy","Zip":"91767","City":"Pomona","State":"CA","Country":"Los Angeles"},{"OrderNumber":"20010465-GLT","OrderStatus":"InProcess","OrderType":"Title only","TransactionType":"Refinance","MarketingRep":"Saeed Ghaffari","Address":"30296 La Vue","Zip":"92677","City":"Laguna Niguel","State":"CA","Country":"Orange"},{"OrderNumber":"20010466-OCT","OrderStatus":"InProcess","OrderType":"Title only","TransactionType":"Refinance","MarketingRep":"Nicholas Watt","Address":"18023 Ibex Avenue","Zip":"90701","City":"Artesia","State":"CA","Country":"Los Angeles"},{"OrderNumber":"20010467-GLT","OrderStatus":"InProcess","OrderType":"Title only","TransactionType":"Refinance","MarketingRep":"Team Meza","Address":"3322 Olive St","Zip":"90255","City":"Huntington Park","State":"CA","Country":"Los Angeles"},{"OrderNumber":"20010468-OCT","OrderStatus":"InProcess","OrderType":"Title only","TransactionType":"Refinance","MarketingRep":"Angeline Wu","Address":"4215 Buckingham Avenue","Zip":"93619","City":"Clovis","State":"CA","Country":"Fresno"},{"OrderNumber":"20010469-OCT","OrderStatus":"InProcess","OrderType":"Title only","TransactionType":"Refinance","MarketingRep":"Sandra Millar","Address":"2719 Yucca Drive","Zip":"93012","City":"Santa Rosa Valley","State":"CA","Country":"Ventura"},{"OrderNumber":"20010470-OCT","OrderStatus":"InProcess","OrderType":"Title only","TransactionType":"Refinance","MarketingRep":"Sandra Millar","Address":"21601 Mayan Dr","Zip":"91311","City":"Chatsworth","State":"CA","Country":"Los Angeles"},{"OrderNumber":"20010471-OCT","OrderStatus":"InProcess","OrderType":"Title only","TransactionType":"Refinance","MarketingRep":"Christy Coffey","Address":"17429 Mayflower Drive","Zip":"91344","City":"Granada Hills","State":"CA","Country":"Los Angeles"},{"OrderNumber":"20010472-OCT","OrderStatus":"InProcess","OrderType":"Title only","TransactionType":"Refinance","MarketingRep":"Sandra Millar","Address":"2909 S Tech Center Dr","Zip":"92705","City":"Santa Ana","State":"CA","Country":"Orange"},{"OrderNumber":"20010473-OCT","OrderStatus":"InProcess","OrderType":"Title only","TransactionType":"Refinance","MarketingRep":"Angeline Wu","Address":"1201 Santiago Drive","Zip":"92660","City":"Newport Beach","State":"CA","Country":"Orange"},{"OrderNumber":"20010474-GLT","OrderStatus":"InProcess","OrderType":"Title only","TransactionType":"Refinance","MarketingRep":"Kevin Green","Address":"13706 Westdale Drive","Zip":"93314","City":"Bakersfield","State":"CA","Country":"Kern"},{"OrderNumber":"20010475-OCT","OrderStatus":"InProcess","OrderType":"Title only","TransactionType":"Refinance","MarketingRep":"Angeline Wu","Address":"27088 Ironwood Drive","Zip":"92653","City":"Laguna Hills","State":"CA","Country":"Orange"},{"OrderNumber":"20010476-GLT","OrderStatus":"InProcess","OrderType":"Title only","TransactionType":"Refinance","MarketingRep":"Sonia Flores","Address":"1523 South Visalia Avenue","Zip":"90220","City":"Compton","State":"CA","Country":"Los Angeles"},{"OrderNumber":"20010477-OCT","OrderStatus":"InProcess","OrderType":"Title only","TransactionType":"Refinance","MarketingRep":"Neil Torquato","Address":"2835 North Mountain View Avenue","Zip":"92405","City":"San Bernardino","State":"CA","Country":"San Bernardino"},{"OrderNumber":"20010478-OCT","OrderStatus":"InProcess","OrderType":"Title only","TransactionType":"Refinance","MarketingRep":"Sandra Millar","Address":"30505 Canyon Hills Road, Unit 401","Zip":"92532","City":"Lake Elsinore","State":"CA","Country":"Riverside"},{"OrderNumber":"20010479-OCT","OrderStatus":"InProcess","OrderType":"Title only","TransactionType":"Refinance","MarketingRep":"Sandra Millar","Address":"700 Front Street, Unit 2505","Zip":"92101","City":"San Diego","State":"CA","Country":"San Diego"},{"OrderNumber":"20010480-GLT","OrderStatus":"InProcess","OrderType":"Title only","TransactionType":"Purchase","MarketingRep":"Lopez Team","Address":"9625 Sylmar Avenue #29","Zip":"91402","City":"Van Nuys","State":"CA","Country":"Los Angeles"},{"OrderNumber":"20010481-GLT","OrderStatus":"InProcess","OrderType":"Title only","TransactionType":"Purchase","MarketingRep":"Team Meza","Address":"2543 Broderick Avenue","Zip":"91010","City":"Duarte","State":"CA","Country":"Los Angeles"},{"OrderNumber":"20010482-GLT","OrderStatus":"InProcess","OrderType":"Title only","TransactionType":"Purchase","MarketingRep":"Nini Kerns","Address":"913 S Truro AveNUE","Zip":"90301","City":"Inglewood","State":"CA","Country":"Los Angeles"},{"OrderNumber":"20010483-GLT","OrderStatus":"Canceled","OrderType":"Title only","TransactionType":"Purchase","MarketingRep":"Team Castaneda","Address":"27381 5th St","Zip":"92346","City":"Highland","State":"CA","Country":"San Bernardino"},{"OrderNumber":"20010484-GLT","OrderStatus":"InProcess","OrderType":"Title only","TransactionType":"Purchase","MarketingRep":"Team Meza","Address":"8635 Paramount Blvd","Zip":"90240","City":"Downey","State":"CA","Country":"Los Angeles"},{"OrderNumber":"20010485-GLT","OrderStatus":"InProcess","OrderType":"Title only","TransactionType":"Purchase","MarketingRep":"Laurie Briggs","Address":"437 W Glenoaks Blvd","Zip":"91202","City":"Glendale","State":"CA","Country":"Los Angeles"},{"OrderNumber":"20010486-GLT","OrderStatus":"InProcess","OrderType":"Title only","TransactionType":"Refinance","MarketingRep":"Team Meza","Address":"17827 Santa Ana Avenue","Zip":"92316","City":"Bloomington","State":"CA","Country":"San Bernardino"},{"OrderNumber":"20010487-OCT","OrderStatus":"InProcess","OrderType":"Title only","TransactionType":"Purchase","MarketingRep":"Sonia Flores","Address":"425 W 17th St","Zip":"92405","City":"San Bernardino","State":"CA","Country":"San Bernardino"},{"OrderNumber":"20010488-GLT","OrderStatus":"InProcess","OrderType":"Title only","TransactionType":"Purchase","MarketingRep":"David Gomez","Address":"13288 Choco Road","Zip":"92308","City":"Apple Valley","State":"CA","Country":"San Bernardino"},{"OrderNumber":"20010489-GLT","OrderStatus":"InProcess","OrderType":"Title only","TransactionType":"Purchase","MarketingRep":"David Gomez","Address":"23524 Heritage Oak Court","Zip":"91321","City":"Santa Clarita","State":"CA","Country":"Los Angeles"},{"OrderNumber":"20010490-GLT","OrderStatus":"InProcess","OrderType":"Title only","TransactionType":"Purchase","MarketingRep":"Team Meza","Address":"17811 Santa Ana Avenue","Zip":"92316","City":"Bloomington","State":"CA","Country":"San Bernardino"},{"OrderNumber":"20010491-GLT","OrderStatus":"InProcess","OrderType":"Title only","TransactionType":"Purchase","MarketingRep":"Simon Wu","Address":"1317 S Santa Anita Ave","Zip":"91006","City":"Arcadia","State":"CA","Country":"Los Angeles"},{"OrderNumber":"20010492-GLT","OrderStatus":"InProcess","OrderType":"Title only","TransactionType":"Refinance","MarketingRep":"Kevin Green","Address":"7019 Remmet Avenue","Zip":"91303","City":"Canoga Park","State":"CA","Country":"Los Angeles"},{"OrderNumber":"20010493-GLT","OrderStatus":"InProcess","OrderType":"Title only","TransactionType":"Purchase","MarketingRep":"Simon Wu","Address":"7179 Summerfield Place","Zip":"91701","City":"Rancho Cucamonga","State":"CA","Country":"San Bernardino"},{"OrderNumber":"20010494-GLT","OrderStatus":"InProcess","OrderType":"Title only","TransactionType":"Refinance","MarketingRep":"Michael Nouri","Address":"2882 Ronald Street","Zip":"92506","City":"Riverside","State":"CA","Country":"Riverside"},{"OrderNumber":"20010495-GLT","OrderStatus":"InProcess","OrderType":"Title only","TransactionType":"Purchase","MarketingRep":"Team Meza","Address":"10391 Arlington Ave","Zip":"92505","City":"Riverside","State":"CA","Country":"Riverside"},{"OrderNumber":"20010496-GLT","OrderStatus":"InProcess","OrderType":"Title only","TransactionType":"Purchase","MarketingRep":"Team Meza","Address":"2890 Dahlia Ave","Zip":"92154","City":"San Diego","State":"CA","Country":"San Diego"},{"OrderNumber":"20010497-GLT","OrderStatus":"InProcess","OrderType":"Title only","TransactionType":"Refinance","MarketingRep":"Justin Nouri","Address":"4501 El Caballero Drive","Zip":"91356","City":"Tarzana","State":"CA","Country":"Los Angeles"},{"OrderNumber":"20010498-OCT","OrderStatus":"InProcess","OrderType":"Title only","TransactionType":"Refinance","MarketingRep":"Nicholas Watt","Address":"10530 Lakeside Drive South A","Zip":"92840","City":"Garden Grove","State":"CA","Country":"Orange"},{"OrderNumber":"20010499-GLT","OrderStatus":"InProcess","OrderType":"Title only","TransactionType":"Refinance","MarketingRep":"Kevin Green","Address":"11921 S Budlong Avenue","Zip":"90044","City":"Los Angeles","State":"CA","Country":"Los Angeles"},{"OrderNumber":"20010500-GLT","OrderStatus":"InProcess","OrderType":"Title only","TransactionType":"Refinance","MarketingRep":"Saeed Ghaffari","Address":"11515 Stanford Ave","Zip":"90059","City":"Los Angeles","State":"CA","Country":"Los Angeles"},{"OrderNumber":"20010501-GLT","OrderStatus":"InProcess","OrderType":"Title only","TransactionType":"Purchase","MarketingRep":"Corey Velasquez","Address":"Vacant Land 0357-561-92-0000","Zip":"92345","City":"Hesperia","State":"CA","Country":"San Bernardino"},{"OrderNumber":"20010502-GLT","OrderStatus":"InProcess","OrderType":"Title only","TransactionType":"Purchase","MarketingRep":"David Gomez","Address":"2307 Troy Ave","Zip":"91733","City":"South El Monte","State":"CA","Country":"Los Angeles"},{"OrderNumber":"20010503-OCT","OrderStatus":"InProcess","OrderType":"Title & Escrow","TransactionType":"Refinance","MarketingRep":"Linda Ruiz","Address":"2914 Managua Place","Zip":"92009","City":"Carlsbad","State":"CA","Country":"San Diego"},{"OrderNumber":"20010504-OCT","OrderStatus":"InProcess","OrderType":"Title only","TransactionType":"Refinance","MarketingRep":"Nicholas Watt","Address":"423 Via Lido Soud","Zip":"92663","City":"Newport Beach","State":"CA","Country":"Orange"},{"OrderNumber":"20010505-OCT","OrderStatus":"InProcess","OrderType":"Title only","TransactionType":"Refinance","MarketingRep":"Linda Ruiz","Address":"1803 W 133rd Street","Zip":"90222","City":"Compton","State":"CA","Country":"Los Angeles"},{"OrderNumber":"20010506-GLT","OrderStatus":"InProcess","OrderType":"Title only","TransactionType":"Purchase","MarketingRep":"Corey Velasquez","Address":"Vacant Land 0357-561-93-0000","Zip":"92345","City":"Hesperia","State":"CA","Country":"San Bernardino"},{"OrderNumber":"20010507-OCT","OrderStatus":"InProcess","OrderType":"Title only","TransactionType":"Purchase","MarketingRep":"Sonia Flores","Address":"4213 Fay Cir","Zip":"92703","City":"Santa Ana","State":"CA","Country":"Orange"},{"OrderNumber":"20010508-GLT","OrderStatus":"InProcess","OrderType":"Title only","TransactionType":"Purchase","MarketingRep":"Kevin Green","Address":"14840 Polk Street","Zip":"91342","City":"Los Angeles","State":"CA","Country":"Los Angeles"},{"OrderNumber":"20010509-OCT","OrderStatus":"InProcess","OrderType":"Title only","TransactionType":"Refinance","MarketingRep":"Team Meza","Address":"13760 Summer Wind Street","Zip":"92394","City":"Victorville","State":"CA","Country":"San Bernardino"},{"OrderNumber":"20010510-OCT","OrderStatus":"InProcess","OrderType":"Title only","TransactionType":"Refinance","MarketingRep":"Zaccaria Ackad","Address":"230 San Marco Drive","Zip":"90803","City":"Long Beach","State":"CA","Country":"Los Angeles"},{"OrderNumber":"20010511-GLT","OrderStatus":"InProcess","OrderType":"Title only","TransactionType":"Refinance","MarketingRep":"Team Meza","Address":"1910 W Broadway","Zip":"92804","City":"Anaheim","State":"CA","Country":"Orange"},{"OrderNumber":"20010512-GLT","OrderStatus":"InProcess","OrderType":"Title only","TransactionType":"Refinance","MarketingRep":"Angeline Wu","Address":"6721 E Pageantry Street","Zip":"90808","City":"Long Beach","State":"CA","Country":"Los Angeles"},{"OrderNumber":"20010513-OCT","OrderStatus":"InProcess","OrderType":"Title only","TransactionType":"Refinance","MarketingRep":"Sandra Millar","Address":"219 East Bay Avenue","Zip":"92661","City":"Newport Beach","State":"CA","Country":"Orange"},{"OrderNumber":"20010514-OCT","OrderStatus":"InProcess","OrderType":"Title only","TransactionType":"Refinance","MarketingRep":"Sandra Millar","Address":"1160 Corta Vista St","Zip":"95380","City":"Turlock","State":"CA","Country":"Stanislaus"},{"OrderNumber":"20010515-GLT","OrderStatus":"InProcess","OrderType":"Title only","TransactionType":"Purchase","MarketingRep":"Kevin Green","Address":"3564 Poppy Drive","Zip":"91302","City":"Calabasas","State":"CA","Country":"Los Angeles"},{"OrderNumber":"20010516-GLT","OrderStatus":"InProcess","OrderType":"Title only","TransactionType":"Purchase","MarketingRep":"Michael Caballero","Address":"281 Lubken","Zip":"93545","City":"Lone Pine","State":"CA","Country":"Inyo"},{"OrderNumber":"20010517-OCT","OrderStatus":"InProcess","OrderType":"Title & Escrow","TransactionType":"Refinance","MarketingRep":"Sandra Millar","Address":"2604 N Tustin Ave","Zip":"92705","City":"Santa Ana","State":"CA","Country":"Orange"},{"OrderNumber":"20010518-GLT","OrderStatus":"InProcess","OrderType":"Title only","TransactionType":"Purchase","MarketingRep":"Team Meza","Address":"1019 N Burney Ave","Zip":"92376","City":"Rialto","State":"CA","Country":"San Bernardino"},{"OrderNumber":"20010519-OCT","OrderStatus":"InProcess","OrderType":"Title only","TransactionType":"Refinance","MarketingRep":"Lopez Team","Address":"2043 S Concord Ave","Zip":"91761","City":"Ontario","State":"CA","Country":"San Bernardino"},{"OrderNumber":"20010520-GLT","OrderStatus":"InProcess","OrderType":"Title only","TransactionType":"Refinance","MarketingRep":"Team Meza","Address":"858 E 105th St","Zip":"90002","City":"Los Angeles","State":"CA","Country":"Los Angeles"},{"OrderNumber":"20010521-OCT","OrderStatus":"InProcess","OrderType":"Title only","TransactionType":"Refinance","MarketingRep":"Angeline Wu","Address":"215 22nd St","Zip":"94801","City":"Richmond","State":"CA","Country":"Contra Costa"},{"OrderNumber":"20010522-GLT","OrderStatus":"InProcess","OrderType":"Title only","TransactionType":"Purchase","MarketingRep":"Kevin Green","Address":"11750 Christy St","Zip":"90703","City":"Cerritos","State":"CA","Country":"Los Angeles"},{"OrderNumber":"20010523-GLT","OrderStatus":"InProcess","OrderType":"Title only","TransactionType":"Refinance","MarketingRep":"David Gomez","Address":"Vacant Land 238-203-43-00-7","Zip":"93313","City":"Bakersfield","State":"CA","Country":"Kern"},{"OrderNumber":"20010524-GLT","OrderStatus":"InProcess","OrderType":"Title only","TransactionType":"Refinance","MarketingRep":"Michael Nouri","Address":"18148 Elkwood St","Zip":"91335","City":"Reseda","State":"CA","Country":"Los Angeles"},{"OrderNumber":"20010525-OCT","OrderStatus":"InProcess","OrderType":"Title only","TransactionType":"Refinance","MarketingRep":"Sonia Flores","Address":"1751 E Imperial Hwy","Zip":"90059","City":"Los Angeles","State":"CA","Country":"Los Angeles"},{"OrderNumber":"20010526-GLT","OrderStatus":"InProcess","OrderType":"Title only","TransactionType":"Purchase","MarketingRep":"Kevin Green","Address":"9268 Beech Ave","Zip":"92335","City":"Fontana","State":"CA","Country":"San Bernardino"},{"OrderNumber":"20010527-GLT","OrderStatus":"InProcess","OrderType":"Title only","TransactionType":"Purchase","MarketingRep":"Ventura House Account","Address":"10169 Columbine Ave","Zip":"91763","City":"Montclair","State":"CA","Country":"San Bernardino"},{"OrderNumber":"20010528-GLT","OrderStatus":"InProcess","OrderType":"Title only","TransactionType":"Refinance","MarketingRep":"Sonia Flores","Address":"13502 S San Pedro St","Zip":"90061","City":"Los Angeles","State":"CA","Country":"Los Angeles"},{"OrderNumber":"20010529-GLT","OrderStatus":"InProcess","OrderType":"Title only","TransactionType":"Purchase","MarketingRep":"Kevin Green","Address":"1201 S Grandee Ave","Zip":"90220","City":"Compton","State":"CA","Country":"Los Angeles"},{"OrderNumber":"20010530-OCT","OrderStatus":"InProcess","OrderType":"Title only","TransactionType":"Refinance","MarketingRep":"Angeline Wu","Address":"29771 Mill Pond Ct","Zip":"92675","City":"San Juan Capistrano","State":"CA","Country":"Orange"},{"OrderNumber":"20010531-GLT","OrderStatus":"InProcess","OrderType":"Title only","TransactionType":"Purchase","MarketingRep":"Kevin Green","Address":"1114 San Rafael Ave #7","Zip":"91202","City":"Glendale","State":"CA","Country":"Los Angeles"},{"OrderNumber":"20010532-GLT","OrderStatus":"InProcess","OrderType":"Title only","TransactionType":"Purchase","MarketingRep":"Title Team","Address":"343 Acaso Dr","Zip":"91789","City":"Walnut","State":"CA","Country":"Los Angeles"},{"OrderNumber":"20010533-GLT","OrderStatus":"InProcess","OrderType":"Title only","TransactionType":"Purchase","MarketingRep":"Kevin Green","Address":"1558 W 29th St","Zip":"90007","City":"Los Angeles","State":"CA","Country":"Los Angeles"},{"OrderNumber":"20010534-GLT","OrderStatus":"InProcess","OrderType":"Title only","TransactionType":"Refinance","MarketingRep":"Ventura House Account","Address":"8121 Regis Way","Zip":"90045","City":"Los Angeles","State":"CA","Country":"Los Angeles"},{"OrderNumber":"20010535-GLT","OrderStatus":"InProcess","OrderType":"Title only","TransactionType":"Purchase","MarketingRep":"Michael Caballero","Address":"1209 S Palmetto Ave Unit C","Zip":"91762","City":"Ontario","State":"CA","Country":"San Bernardino"},{"OrderNumber":"20010536-GLT","OrderStatus":"InProcess","OrderType":"Title & Escrow","TransactionType":"Refinance","MarketingRep":"Corey Velasquez","Address":"4836 Monument Street","Zip":"93063","City":"Simi Valley","State":"CA","Country":"Ventura"},{"OrderNumber":"20010537-OCT","OrderStatus":"InProcess","OrderType":"Title only","TransactionType":"Refinance","MarketingRep":"Angeline Wu","Address":"1563 Benedict Avenue","Zip":"91711","City":"Claremont","State":"CA","Country":"Los Angeles"},{"OrderNumber":"20010538-GLT","OrderStatus":"InProcess","OrderType":"Title only","TransactionType":"Refinance","MarketingRep":"Michael Nouri","Address":"22301 Marlin Place","Zip":"91303","City":"Canoga Park","State":"CA","Country":"Los Angeles"},{"OrderNumber":"20010539-OCT","OrderStatus":"InProcess","OrderType":"Title only","TransactionType":"Refinance","MarketingRep":"Linda Ruiz","Address":"1102 West St","Zip":"92703","City":"Santa Ana","State":"CA","Country":"Orange"},{"OrderNumber":"20010540-GLT","OrderStatus":"InProcess","OrderType":"Title only","TransactionType":"Purchase","MarketingRep":"Team Meza","Address":"29641 S Western Ave #310","Zip":"90275","City":"Rancho Palos Verdes","State":"CA","Country":"Los Angeles"},{"OrderNumber":"20010541-OCT","OrderStatus":"InProcess","OrderType":"Title only","TransactionType":"Refinance","MarketingRep":"Angeline Wu","Address":"1937 Worchester Ct","Zip":"92582","City":"San Jacinto","State":"CA","Country":"Riverside"},{"OrderNumber":"20010542-GLT","OrderStatus":"InProcess","OrderType":"Title only","TransactionType":"Purchase","Address":"","Zip":"","City":"","State":"","Country":""},{"OrderNumber":"20010425-GLT","OrderStatus":"InProcess","OrderType":"Title & Escrow","TransactionType":"Refinance","MarketingRep":"Title Gals","Address":"80782 Via Puerta Azul","Zip":"92253","City":"La Quinta","State":"CA","Country":"Riverside"},{"OrderNumber":"20010543-GLT","OrderStatus":"InProcess","OrderType":"Title only","TransactionType":"Purchase","MarketingRep":"Team Meza","Address":"1918 W Piru St","Zip":"90222","City":"Compton","State":"CA","Country":"Los Angeles"},{"OrderNumber":"20010544-GLT","OrderStatus":"InProcess","OrderType":"Title & Escrow","TransactionType":"Refinance","MarketingRep":"Corey Velasquez","Address":"26 Santa Catrina","Zip":"92688","City":"Rancho Santa Margarita","State":"CA","Country":"Orange"},{"OrderNumber":"99100554","OrderStatus":"Closed","OrderType":"Trustee Sale Guarantee","TransactionType":"Other","MarketingRep":"Sandra Millar","Address":"327 N. SUNKIST STREET","Zip":"92806","City":"Anaheim","State":"CA","Country":"Orange"},{"OrderNumber":"20010545-OCT","OrderStatus":"InProcess","OrderType":"Title only","TransactionType":"Refinance","MarketingRep":"Angeline Wu","Address":"3026 Muir Trail Drive","Zip":"92833","City":"Fullerton","State":"CA","Country":"Orange"},{"OrderNumber":"20010546-GLT","OrderStatus":"InProcess","OrderType":"Title & Escrow","TransactionType":"Refinance","MarketingRep":"Corey Velasquez","Address":"24280  Avenida De Marcia","Zip":"92887","City":"Yorba Linda","State":"CA","Country":"Orange"},{"OrderNumber":"20010547-GLT","OrderStatus":"InProcess","OrderType":"Title only","TransactionType":"Purchase","MarketingRep":"Saeed Ghaffari","Address":"2947 Dalton Ave","Zip":"90018","City":"Los Angeles","State":"CA","Country":"Los Angeles"},{"OrderNumber":"20010548-GLT","OrderStatus":"InProcess","OrderType":"Title only","TransactionType":"Refinance","MarketingRep":"Corey Velasquez","Address":"5746 Tampa Avenue","Zip":"91356","City":"Tarzana","State":"CA","Country":"Los Angeles"},{"OrderNumber":"20010549-OCT","OrderStatus":"InProcess","OrderType":"Title only","TransactionType":"Refinance","MarketingRep":"Angeline Wu","Address":"7975 East Monte Carlo Avenue","Zip":"92808-1536","City":"Anaheim","State":"CA","Country":"Orange"},{"OrderNumber":"20010550-OCT","OrderStatus":"InProcess","OrderType":"Title only","TransactionType":"Purchase","MarketingRep":"Linda Ruiz","Address":"12243 Orchid Ln","Zip":"92557","City":"Moreno Valley","State":"CA","Country":"Riverside"},{"OrderNumber":"20010551-GLT","OrderStatus":"InProcess","OrderType":"Title only","TransactionType":"Refinance","MarketingRep":"Justin Nouri","Address":"3485 Burlington Ave","Zip":"95966","City":"Oroville","State":"CA","Country":"Butte"},{"OrderNumber":"20010552-OCT","OrderStatus":"InProcess","OrderType":"Title only","TransactionType":"Refinance","MarketingRep":"Sandra Millar","Address":"10461 Shadyridge Drive","Zip":"92705","City":"Santa Ana","State":"CA","Country":"Orange"},{"OrderNumber":"20010553-GLT","OrderStatus":"InProcess","OrderType":"Title only","TransactionType":"Purchase","MarketingRep":"Team Meza","Address":"1925 E 130th St","Zip":"90222","City":"Compton","State":"CA","Country":"Los Angeles"},{"OrderNumber":"20010554-OCT","OrderStatus":"InProcess","OrderType":"Title only","TransactionType":"Refinance","MarketingRep":"Angeline Wu","Address":"9517 Sunnyside St","Zip":"94603","City":"Oakland","State":"CA","Country":"Alameda"},{"OrderNumber":"20010555-GLT","OrderStatus":"InProcess","OrderType":"Title only","TransactionType":"Purchase","MarketingRep":"Team Meza","Address":"6050 Olive Ave","Zip":"90805","City":"Long Beach","State":"CA","Country":"Los Angeles"},{"OrderNumber":"20010556-GLT","OrderStatus":"InProcess","OrderType":"Title only","TransactionType":"Purchase","MarketingRep":"Simon Wu","Address":"27170 Big Horn Mountain Way","Zip":"92887","City":"Yorba Linda","State":"CA","Country":"Orange"},{"OrderNumber":"20010557-GLT","OrderStatus":"InProcess","OrderType":"Title only","TransactionType":"Refinance","MarketingRep":"Michael Nouri","Address":"11954 Adelphia Ave","Zip":"91331","City":"Los Angeles","State":"CA","Country":"Los Angeles"},{"OrderNumber":"20010558-GLT","OrderStatus":"InProcess","OrderType":"Title & Escrow","TransactionType":"Refinance","MarketingRep":"Corey Velasquez","Address":"6834 Victoria Avenue","Zip":"92346","City":"Highland","State":"CA","Country":"San Bernardino"},{"OrderNumber":"20010559-GLT","OrderStatus":"InProcess","OrderType":"Title only","TransactionType":"Purchase","MarketingRep":"Title Team","Address":"828 E Hermosa Dr","Zip":"91775","City":"Los Angeles","State":"CA","Country":"Los Angeles"},{"OrderNumber":"20010560-OCT","OrderStatus":"InProcess","OrderType":"Title only","TransactionType":"Refinance","MarketingRep":"Angeline Wu","Address":"13017 Lookout Loop","Zip":"96161","City":"Truckee","State":"CA","Country":"Nevada"},{"OrderNumber":"20010561-GLT","OrderStatus":"InProcess","OrderType":"Title only","TransactionType":"Refinance","MarketingRep":"Glendale  House Account","Address":"414 N Orange Ave","Zip":"91755","City":"Monterey Park","State":"CA","Country":"Los Angeles"},{"OrderNumber":"20010562-GLT","OrderStatus":"InProcess","OrderType":"Title only","TransactionType":"Refinance","MarketingRep":"Glendale  House Account","Address":"1219 W Cubbon Street","Zip":"92703","City":"Santa Ana","State":"CA","Country":"Orange"},{"OrderNumber":"20010563-GLT","OrderStatus":"InProcess","OrderType":"Title only","TransactionType":"Refinance","MarketingRep":"Simon Wu","Address":"337 S Grandin Ave","Zip":"91702","City":"Los Angeles","State":"CA","Country":"Los Angeles"},{"OrderNumber":"20010564-GLT","OrderStatus":"InProcess","OrderType":"Title & Escrow","TransactionType":"Purchase","MarketingRep":"Michael Nouri","Address":"2037 East Kettering Street","Zip":"93535-1177","City":"Lancaster","State":"CA","Country":"Los Angeles"},{"OrderNumber":"20010565-OCT","OrderStatus":"InProcess","OrderType":"Title & Escrow","TransactionType":"Purchase","MarketingRep":"Team Meza","Address":"1925 E. 130th Street","Zip":"90222","City":"Compton","State":"CA","Country":"Los Angeles"},{"OrderNumber":"20010566-OCT","OrderStatus":"InProcess","OrderType":"Title only","TransactionType":"Refinance","MarketingRep":"Linda Ruiz","Address":"18131 Brentwell Circle","Zip":"92647","City":"Huntington Beach","State":"CA","Country":"Orange"},{"OrderNumber":"20010567-OCT","OrderStatus":"InProcess","OrderType":"Title only","TransactionType":"Refinance","MarketingRep":"Angeline Wu","Address":"16875 Orangecrest Ct","Zip":"92504","City":"Riverside","State":"CA","Country":"Riverside"},{"OrderNumber":"20010568-GLT","OrderStatus":"InProcess","OrderType":"Title only","TransactionType":"Refinance","MarketingRep":"Team Meza","Address":"1127 Hollister St","Zip":"91340","City":"San Fernando","State":"CA","Country":"Los Angeles"},{"OrderNumber":"20010569-OCT","OrderStatus":"InProcess","OrderType":"Title only","TransactionType":"Refinance","MarketingRep":"Sonia Flores","Address":"213 E 6th Ave","Zip":"92025","City":"Escondido","State":"CA","Country":"San Diego"},{"OrderNumber":"20010570-OCT","OrderStatus":"InProcess","OrderType":"Title & Escrow","TransactionType":"Refinance","MarketingRep":"Sonia Flores","Address":"1431 S Gaffey St","Zip":"90731","City":"San Pedro","State":"CA","Country":"Los Angeles"},{"OrderNumber":"20010571-GLT","OrderStatus":"InProcess","OrderType":"Title only","TransactionType":"Purchase","MarketingRep":"Glendale  House Account","Address":"5512 La Pinta Maria Dr","Zip":"93307","City":"Bakersfield","State":"CA","Country":"Kern"},{"OrderNumber":"20010572-OCT","OrderStatus":"InProcess","OrderType":"Title only","TransactionType":"Refinance","MarketingRep":"Angeline Wu","Address":"21652 Hanakai Ln","Zip":"92646","City":"Huntington Beach","State":"CA","Country":"Orange"},{"OrderNumber":"20010573-OCT","OrderStatus":"InProcess","OrderType":"Title only","TransactionType":"Refinance","MarketingRep":"Angeline Wu","Address":"1111-13 Koe St","Zip":"92114","City":"San Diego","State":"CA","Country":"San Diego"},{"OrderNumber":"20010574-GLT","OrderStatus":"InProcess","OrderType":"Title only","TransactionType":"Purchase","MarketingRep":"Team Meza","Address":"1634 Sweetbrier St","Zip":"93550","City":"Palmdale","State":"CA","Country":"Los Angeles"},{"OrderNumber":"20010575-GLT","OrderStatus":"InProcess","OrderType":"Title only","TransactionType":"Purchase","MarketingRep":"Team Meza","Address":"1326 N San Diego Ave","Zip":"91764","City":"Ontario","State":"CA","Country":"San Bernardino"},{"OrderNumber":"20010576-GLT","OrderStatus":"InProcess","OrderType":"Title only","TransactionType":"Purchase","MarketingRep":"Corey Velasquez","Address":"10420 Adel Way","Zip":"90604","City":"Whittier","State":"CA","Country":"Los Angeles"},{"OrderNumber":"20010577-GLT","OrderStatus":"InProcess","OrderType":"Title only","TransactionType":"Purchase","MarketingRep":"Corey Velasquez","Address":"4565 Firestone Blvd","Zip":"90280","City":"South Gate","State":"CA","Country":"Los Angeles"},{"OrderNumber":"20010578-OCT","OrderStatus":"InProcess","OrderType":"Title & Escrow","TransactionType":"Purchase","MarketingRep":"Orange County House Account","Address":"1330 Gladys Ave","Zip":"90804","City":"Long Beach","State":"CA","Country":"Los Angeles"}]}';
        $array1 = json_decode($json, true);
        echo "<pre>";
        // print_r($array1);

        $addressLookup = [];
        $salesLookup = [];
        foreach ($array1['data'] as $row1) {
            $key = $this->normalize_value($row1['Address']);
            $addressLookup[$key] = $row1['OrderNumber'];
            $salesLookup[$key] = $row1['MarketingRep'];
        }
        // print_r($addressLookup);
        $this->db->select('order_details.id, file_number, p.address');
        $this->db->from('order_details');
        $this->db->join('property_details as p', 'order_details.property_id = p.id', 'left');
        $this->db->where('is_softpro_order', 1);
        $this->db->where('file_number is null');
        $this->db->where('p.address is not null');
        $this->db->where('p.address !=', '');
        $this->db->order_by('order_details.id', 'DESC');
        // $this->db->limit(50);
        $array2  = $this->db->get()->result_array();
        // print_r($array2);
        $updatedCount = 0;
        $addressList = [];
        $updatedOrderNumber = [];
        foreach ($array2 as $row2) {
            $propertyAddress = $row2['address'];
            $normalized = $this->normalize_value($propertyAddress);
            // print_r($normalized);
            if (isset($addressLookup[$normalized])) {
                $addressList[] = $row2['address'];
                $orderNumber = $addressLookup[$normalized];
                
                $orderData = $this->getOrderData($orderNumber);
                $salesRepName = $salesLookup[$normalized];
                if (empty($orderData)) {
                    $orderWithAddress = $this->getOrderWithAdddress($propertyAddress, $salesRepName);
                    if (!empty($orderWithAddress)) {
                        $orderId = $orderWithAddress[0]['order_id'];
                        // $orderId = 161027;
                        // $orderNumber = '20010452-GLT';
                        $this->db->where('id', $orderId);
                        $this->db->update('order_details', ['file_number' => $orderNumber]);
                        $updatedOrderNumber[] = $orderNumber;
                        // echo 'Searching for address: ' . $propertyAddress . ' with Sales Rep: ' . $salesRepName . '<br>';
                        // $this->needToDelete($propertyAddress, $salesRepName);
                        $updatedCount++;
                    }
                    // print_r($orderWithAddress);
                    echo "Updated ID {$row2['id']} with {$orderNumber} and address is {$normalized}<br>";
                }
                
                // Update DB using CodeIgniter
                
            } else {
                // echo "No match found for {$row2['address']}<br>";
            }
        }
        echo "Updated records count: {$updatedCount}"; 
        print_r($updatedOrderNumber);die;
        // echo "<pre>";
        // print_r($addressList);die;
    }
    

    public function getOrderData($orderNumber) {
        $this->db->select('order_details.id, file_number, p.address, t.sales_representative');
        $this->db->from('order_details');
        $this->db->join('property_details as p', 'order_details.property_id = p.id', 'left');
        $this->db->join('transaction_details as t', 'order_details.transaction_id = t.id', 'left');
        $this->db->where('file_number =', $orderNumber);
        return $this->db->get()->result_array();
    }

    public function getOrderWithAdddress($propertyAddress, $salesRepName){
        $this->db->select('o.id as order_id, file_number, p.address, t.sales_representative, o.created_at, o.updated_at');
        $this->db->from('order_details as o');
        $this->db->join('property_details as p', 'o.property_id = p.id', 'left');
        $this->db->join('transaction_details as t', 'o.transaction_id = t.id', 'left');
        $this->db->join('pct_softpro_lookup_table as u', 't.sales_representative = u.id', 'left');
        $this->db->where('o.is_softpro_order =', 1);
        $this->db->where('p.address =', $propertyAddress);
        $this->db->where('u.full_name =', $salesRepName);
        $this->db->order_by('order_id', 'asc');
        $this->db->limit(1);
        return $this->db->get()->result_array();
    }

    public function needToDelete($propertyAddress, $salesRepName) {
        $this->db->select('GROUP_CONCAT(o.id) as orderIds');
        $this->db->from('order_details as o');
        $this->db->join('property_details as p', 'o.property_id = p.id', 'left');
        $this->db->join('transaction_details as t', 'o.transaction_id = t.id', 'left');
        $this->db->join('pct_softpro_lookup_table as u', 't.sales_representative = u.id', 'left');
        $this->db->where('o.is_softpro_order =', 1);
        $this->db->where('file_number is null');
        $this->db->where('p.address =', $propertyAddress);
        $this->db->where('u.full_name =', $salesRepName);
        $query       = $this->db->get();
        $orderIds = $query->row_array();
        if (!empty($orderIds['orderIds'])) {
            $orderIds = explode(',', $orderIds['orderIds']);
            if (count($orderIds) > 1) {
                // Delete all but the first one
                // $idsToDelete = array_slice($orderIds, 1);
                // $this->db->where_in('id', $orderIds);
                // $this->db->update('order_details', ['need_to_delete' => 1]);
                echo "Deleted duplicate orders with IDs: " . implode(', ', $orderIds) . "<br>";
            }
        }
        print_r($orderIds);
    }

    function normalize_value($address) {
        $address = strtolower(trim($address));
        $address = preg_replace('/\s+/', ' ', $address);
        return $address;
    }
}
