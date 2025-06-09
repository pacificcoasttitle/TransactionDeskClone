<?php

(defined('BASEPATH')) or exit('No direct script access allowed');

class Home extends MX_Controller
{

    private $version  = '06';
    private $custom_js_version = '07';

    public function __construct()
    {
        parent::__construct();
        $this->load->helper(['file', 'url']);
        $this->load->library('session');
        $this->load->library('order/template');
        $this->load->library('order/salesDashboardTemplate');
        $this->load->model('order/home_model');
        $this->load->model('order/agent_model');
        $this->load->library('form_validation');
        $this->load->library('order/order');
        $this->load->model('order/titlePointData');
        $this->load->model('order/productType');
        $this->load->library('order/softPro');
        $this->order->is_user();

        // $this->load->model('order/apiLogs');
    }

    public function index()
    {
        $userdata = $this->session->userdata('user');

        $this->load->model('order/apiLogs');
        $this->load->model('order/titleOfficer');
        $this->load->model('order/partnerApiLogs');
        $this->load->library('order/titlepoint');
        if (isset($_POST) && !empty($_POST)) {
            $random_number = $this->input->post('random_number');

            if (isset($random_number) && !empty($random_number)) {
                $condition = [
                    'where'      => [
                        'session_id' => 'tp_api_id_' . $random_number,
                    ],
                    'returnType' => 'count',
                ];
                $count = $this->titlePointData->gettitlePointDetails($condition);
                if ($count != 1) {
                    $response = ['status' => 'error', 'message' => 'Something went wrong.Please hard refresh(Ctrl+F5) your page.'];
                    echo json_encode($response);
                    exit;
                }
            } else {
                $response = ['status' => 'error', 'message' => 'Something went wrong.Please hard refresh (Ctrl+F5) your page.'];
                echo json_encode($response);
                exit;
            }
            // echo "<pre>";
            // print_r($_POST);die;
            $this->form_validation->set_rules('OpenName', 'Open Name', 'required', ['required' => 'Enter your first name']);
            $this->form_validation->set_rules('OpenLastName', 'Open Last Name', 'required', ['required' => 'Enter your last name']);
            $this->form_validation->set_rules('OpenEmail', 'Open Email', 'required', ['required' => 'Enter your email address']);
            $this->form_validation->set_rules('TransactionType', 'Transaction Type', 'required', ['required' => 'Please select Transaction Type']);
            $this->form_validation->set_rules('OrderTypeID', 'Order Type ID', 'required', ['required' => 'Please select Order Type']);
            $this->form_validation->set_rules('ProductType', 'Product Type', 'required', ['required' => 'Please select Product Type']);
            // $this->form_validation->set_rules('escrow_officer', 'Escrow Officer', 'callback_escrow_officer_validation');
            // $this->form_validation->set_rules('escrow_officer', 'Escrow Officer', 'callback_escrow_officer_validation');

            if (! is_dir('uploads/curative')) {
                mkdir('./uploads/curative', 0777, true);
            }

            $config['upload_path']   = './uploads/curative/';
            $config['allowed_types'] = 'doc|docx|gif|msg|pdf|tif|tiff|xls|xlsx|xml';
            $config['max_size']      = 20000;
            $this->load->library('upload', $config);

            if (!empty($_FILES['upload_curative']['name'])) {
                if (!$this->upload->do_upload('upload_curative')) {
                    $response = ['status' => 'error', 'message' => $this->upload->display_errors()];
                    echo json_encode($response);
                    exit;
                }
            }

            $result = $this->order->checkDuplicateOrder($this->input->post('apn'));
            if ($result) {
                $response = ['status' => 'error', 'message' => 'Order is already exist for this property.'];
                echo json_encode($response);
                exit;
            }
            $parties_email = [];
            if ($this->form_validation->run($this) == true) {
                $OpenName          = $this->input->post('OpenName');
                $OpenLastName      = $this->input->post('OpenLastName');
                $Opentelephone     = $this->input->post('Opentelephone');
                $OpenEmail         = $this->input->post('OpenEmail');
                $CompanyName       = $this->input->post('CompanyName');
                $StreetAddress     = $this->input->post('StreetAddress');
                $City              = $this->input->post('City');
                $Zipcode           = $this->input->post('Zipcode');
                $ClientLookupCode  = $this->input->post('ClientLookupCode');
                $CompanyLookupCode = $this->input->post('CompanyLookupCode');
                $ClientType        = $this->input->post('ClientType');

                $PropertyAddress      = $this->input->post('Property');
                $SplitPropertyAddress = explode(' ', $PropertyAddress);
                $StreetNumber         = isset($SplitPropertyAddress[0]) && !empty($SplitPropertyAddress[0]) ? $SplitPropertyAddress[0] : '';
                $PrimaryStreetName    = array_slice($SplitPropertyAddress, 1);
                $StreetName           = isset($PrimaryStreetName) && !empty($PrimaryStreetName) ? implode(" ", $PrimaryStreetName) : '';

                $PropertyState = $this->input->post('property-state');
                $PropertyCity  = $this->input->post('property-city');
                $PropertyFips  = $this->input->post('property-fips');
                $PropertyZip   = $this->input->post('property-zip');
                $PropertyType  = $this->input->post('property-type');
                $FullProperty  = $this->input->post('FullProperty');

                $apn              = $this->input->post('apn');
                $County           = $this->input->post('County');
                $LegalDescription = $this->input->post('LegalDescription');
                $PrimaryOwner     = $this->input->post('PrimaryOwner');
                $SplitName        = explode(' ', $PrimaryOwner);
                $OwnerLastName    = end($SplitName);
                $PrimaryName      = array_slice($SplitName, 0, -1);
                $OwnerFirstName   = implode(" ", $PrimaryName);
                $SecondaryOwner   = $this->input->post('SecondaryOwner');
                $primaryOwnerArray = $this->order->splitFullName($PrimaryOwner);
                $secondaryOwnerArray = $this->order->splitFullName($SecondaryOwner);

                $SalesRep  = $this->input->post('SalesRep');
                $condition = [
                    'id' => $SalesRep,
                ];
                // $salesRepDetails = $this->home_model->getSalesRepDetails($condition);
                $salesRepDetails = $this->home_model->getSPSalesRepDetails($condition);
                
                if ($salesRepDetails["is_mail_notification"] == 1) {
                    $parties_email[] = isset($salesRepDetails["email_address"]) && !empty($salesRepDetails["email_address"]) ? $salesRepDetails["email_address"] : '';
                }
                $salesRepName = isset($salesRepDetails["lookup_code"]) && !empty($salesRepDetails["lookup_code"]) ? $salesRepDetails["lookup_code"] : '';

                $TitleOfficer = $this->input->post('TitleOfficer');
                $condition    = [
                    'id' => $TitleOfficer,
                ];
                // $titleOfficerDetails = $this->titleOfficer->getTitleOfficerDetails($condition);
                $titleOfficerDetails = $this->order->getTitleOfficerLookupDetails($condition);
                // echo "<pre>";
                // print_r($titleOfficerDetails);die;
                $titleOfficerName       = isset($titleOfficerDetails['closer_examiner']) && !empty($titleOfficerDetails['closer_examiner']) ? $titleOfficerDetails['closer_examiner'] : '';
                $titleOfficerLookupCode = isset($titleOfficerDetails['lookup_code']) && !empty($titleOfficerDetails['lookup_code']) ? $titleOfficerDetails['lookup_code'] : '';

                $LoanAmount   = $this->input->post('loanAmount');
                // print_r($LoanAmount);die;
                $LoanNumber   = $this->input->post('loanNumber');
                $EscrowNumber = $this->input->post('escrowNumber');
                $Notes        = $this->input->post('notes');
                $SalesAmount  = $this->input->post('salesAmount');
                $SalesAmount  = str_replace(',', '', $SalesAmount);
                $LoanAmount   = str_replace(',', '', $LoanAmount);
                // $LoanAmount = 25000;
                // $SalesAmount = 11000;
                $ProductTypeTxt       = $this->input->post('ProductType');
                $primaryBorrower      = $this->input->post('primaryBorrower');
                $secondaryBorrower    = $this->input->post('secondaryBorrower');
                $primaryBorrowerArray = $this->order->splitFullName($primaryBorrower);
                $secondaryBorrowerArray = $this->order->splitFullName($secondaryBorrower);
                
                $TransactionTypeID    = isset($_POST["TransactionTypeID"]) && !empty($_POST["TransactionTypeID"]) ? $_POST["TransactionTypeID"] : 3;
                $TransactionType      = $this->input->post('TransactionType');
                $ProductTypeID        = $this->input->post('ProductTypeID');
                $softproProductType   = $this->input->post('ProductType');
                $softproProductTypeId = $this->input->post('ProductTypeID');
                $softproOrderType     = $this->input->post('OrderType');
                $softproOrderTypeId   = $this->input->post('OrderTypeID');
                $CCR                  = isset($_POST["CCR"]) && !empty($_POST["CCR"]) ? 1 : 0;
                $Docs                 = isset($_POST["Docs"]) && !empty($_POST["Docs"]) ? 1 : 0;
                $Ease                 = isset($_POST["Ease"]) && !empty($_POST["Ease"]) ? 1 : 0;

                $sendermessage        = $this->input->post('sendermessage');
                $BuyerAgentId         = $this->input->post('BuyerAgentId');
                $agentDetailFlag      = $this->input->post('add-agent-details');
                $escrowOfficerFlag    = $this->input->post('add-escrow-officer-details');
                $escrowOfficer        = $this->input->post('escrow_officer');

                $con = [
                        'where'      => [
                            'closer_examiner'   => $escrowOfficer,
                            'is_escrow_officer'       => 1,
                        ]
                ];
            
                $escrowOfficerDetails = $this->order->get_rows($con, 'pct_softpro_lookup_table');
                $escrowOfficerId       = isset($escrowOfficerDetails['id']) && !empty($escrowOfficerDetails['id']) ? $escrowOfficerDetails['id'] : '';

                $escrowOfficerKey     = '';
                $user_data            = [];
                $orderReq             = [];
                $buyers_agent_details = $listing_agent_details = [];
                if ((isset($BuyerAgentId) && !empty($BuyerAgentId)) || isset($agentDetailFlag)) {
                    $BuyerAgentName                 = $this->input->post('BuyerAgentName');
                    $BuyerAgentEmailAddress         = $this->input->post('BuyerAgentEmailAddress');
                    $BuyerAgentTelephone            = $this->input->post('BuyerAgentTelephone');
                    $BuyerAgentCompany              = $this->input->post('BuyerAgentCompany');
                    $BuyerAgentCompanyLookupCode    = $this->input->post('BuyerAgentCompanyLookupCode');
                    $BuyerAgentClientLookUpCode     = $this->input->post('BuyerAgentClientLookUpCode');
                    $parties_email[]                = $BuyerAgentEmailAddress;
                    $buyers_agent_details           = ['name' => $BuyerAgentName, 'email' => $BuyerAgentEmailAddress, 'telephone' => $BuyerAgentTelephone, 'company' => $BuyerAgentCompany];
                    $orderReq['buyersAgentDetails'] = [
                        'Name'              => $BuyerAgentName,
                        'Email'             => $BuyerAgentEmailAddress,
                        'Telephone'         => $BuyerAgentTelephone,
                        'CompanyName'       => $BuyerAgentCompany,
                        "CompanyLookUpCode" => $BuyerAgentCompanyLookupCode,
                        "ClientLookUpCode"  => $BuyerAgentClientLookUpCode,
                    ];
                }

                $ListingAgentId = $this->input->post('ListingAgentId');
                if ((isset($ListingAgentId) && !empty($ListingAgentId)) || isset($agentDetailFlag)) {
                    $ListingAgentName                = $this->input->post('ListingAgentName');
                    $ListingAgentEmailAddress        = isset($_POST["ListingAgentEmailAddress"]) && !empty($_POST["ListingAgentEmailAddress"]) ? strip_tags(trim($_POST["ListingAgentEmailAddress"])) : '';
                    $ListingAgentTelephone           = $this->input->post('ListingAgentTelephone');
                    $ListingAgentCompany             = $this->input->post('ListingAgentCompany');
                    $ListingAgentCompanyLookupCode   = $this->input->post('ListingAgentCompanyLookupCode');
                    $ListingAgentClientLookUpCode    = $this->input->post('ListingAgentClientLookUpCode');
                    $parties_email[]                 = $ListingAgentEmailAddress;
                    $listing_agent_details           = ['name' => $ListingAgentName, 'email' => $ListingAgentEmailAddress, 'telephone' => $ListingAgentTelephone, 'company' => $ListingAgentCompany];
                    $orderReq['listingAgentDetails'] = [
                        'Name'              => $ListingAgentName,
                        'Email'             => $ListingAgentEmailAddress,
                        'Telephone'         => $ListingAgentTelephone,
                        'CompanyName'       => $ListingAgentCompany,
                        "CompanyLookUpCode" => $ListingAgentCompanyLookupCode,
                        "ClientLookUpCode"  => $ListingAgentClientLookUpCode,
                    ];
                }

                $escrowId = $lenderId = $lenderPartnerTypeID = $escrowPartnerTypeID = $openUserCompanyId = 0;
                $lender_details     = $escrow_details     = [];
                $lender_details_api = $escrow_details_api = [];

                if (isset($userdata['is_master']) && !empty($userdata['is_master'])) {
                    $orderUser             = $this->home_model->sp_get_user(['id' => $_POST['id']]);
                    $is_escrow             = $orderUser['is_escrow'];
                    $user_data['email']    = $orderUser['email_address'];
                    $user_data['password'] = $orderUser['random_password'];
                } else {
                    $orderUser = $this->home_model->sp_get_user(['id' => $userdata['id']]);
                }

                if ($orderUser['is_escrow']) {
                    $escrowId = $orderUser['id'];
                } else if ($orderUser['is_lender']) {
                    $lenderId = $orderUser['id'];
                }
                

                $cplLenderId    = 0;
                $EscrowLenderId = 0;
                if (isset($_POST['EscrowId']) && !empty($_POST['EscrowId'])) {
                    $escrowId       = $_POST['EscrowId'];
                    $EscrowLenderId = $_POST['EscrowId'];
                    // $escrow_user_details = $this->home_model->get_user(array('id' => $escrowId));
                    $escrowName                = isset($_POST['EscrowName']) && !empty($_POST['EscrowName']) ? $_POST['EscrowName'] : '';
                    $escrowEmail               = isset($_POST['EscrowEmailAddress']) && !empty($_POST['EscrowEmailAddress']) ? $_POST['EscrowEmailAddress'] : '';
                    $escrowTelephone           = $this->input->post('EscrowTelephone');
                    $escrowCompany             = $this->input->post('EscrowCompany');
                    $escrowCompanyLookUpCode   = $this->input->post('EscrowCompanyLookUpCode');
                    $escrowClientLookUpCode    = $this->input->post('EscrowClientLookUpCode');
                    $escrow_details            = ['name' => $escrowName, 'email' => $escrowEmail, 'telephone' => $escrowName, 'company' => $escrowCompany];
                    $orderReq['escrowDetails'] = [
                        'CompanyLookUpCode' => $escrowCompanyLookUpCode,
                        'ClientLookUpCode'  => $escrowClientLookUpCode,
                        'Name'              => $escrowName,
                        'Email'             => $escrowEmail,
                        'Telephone'         => $escrowTelephone,
                        'CompanyName'       => $escrowCompany,
                        // 'EscrowOfficerName' => $escrowOfficer,
                        // "LookUpCodeEscrowOfficer" => $escrowOfficer,
                    ];
                    $escrow_details_api = ['name' => $escrowName, 'email' => $escrowEmail, 'phone' => $escrowTelephone, 'company' => $escrowCompany];
                    if ($orderUser['is_primary_mortgage_user'] == 1) {
                        $cplLenderId = 0;
                    } else {
                        $cplLenderId = $orderUser['id'];
                    }
                }

                if (isset($_POST['LenderId']) && !empty($_POST['LenderId'])) {
                    $lenderId = $_POST['LenderId'];
                    // $lenderId = 7948;
                    // $lender_user_details = $this->home_model->get_user(array('id' => $lenderId));
                    // print_r($lender_user_details);die;
                    $lenderName              = isset($_POST['LenderName']) && !empty($_POST['LenderName']) ? $_POST['LenderName'] : '';
                    $lenderEmail             = isset($_POST['LenderEmailAddress']) && !empty($_POST['LenderEmailAddress']) ? $_POST['LenderEmailAddress'] : '';
                    $lenderTelephone         = $this->input->post('LenderTelephone');
                    $lenderCompany           = $this->input->post('LenderCompany');
                    $lenderCompanyLookUpCode = $this->input->post('LenderCompanyLookUpCode');
                    $lenderClientLookUpCode  = $this->input->post('LenderClientLookUpCode');
                    $lender_details          = ['name' => $lenderName, 'email' => $lenderEmail, 'telephone' => $lenderTelephone, 'company' => $lenderCompany];
                    if (!empty($lenderEmail)) {
                        // echo "Hello";die;
                        $orderReq['lenderDetails'] = [
                            'CompanyLookUpCode' => $lenderCompanyLookUpCode,
                            'ClientLookUpCode'  => $lenderClientLookUpCode,
                            'Name'              => $lenderName,
                            'Email'             => $lenderEmail,
                            'Telephone'         => $lenderTelephone,
                            'CompanyName'       => $lenderCompany,
                        ];
                    }
                    $lender_details_api  = ['name' => $lenderName, 'email' => $lenderEmail, 'phone' => $lenderTelephone, 'company' => $lenderCompany];
                    $lenderPartnerTypeID = '3';
                    if ($orderUser['is_primary_mortgage_user'] == 1) {
                        $cplLenderId = $lenderId;
                    } else {
                        $EscrowLenderId = $lenderId;
                    }
                }

                if (isset($escrowEmail) && !empty($escrowEmail)) {
                    $parties_email[] = $escrowEmail;
                }

                if (isset($lenderEmail) && !empty($lenderEmail)) {
                    $parties_email[] = $lenderEmail;
                }

                $AdditionalEmails = $this->input->post('AdditionalEmail');
                if (isset($AdditionalEmails) && !empty($AdditionalEmails)) {
                    foreach ($AdditionalEmails as $AdditionalEmail) {
                        $parties_email[] = $AdditionalEmail;
                    }
                }

                /** Start Get config value to check Lp Enable or not */
                $configData                  = $this->order->getConfigData();
                $addUnderwritenPartnerViaApi = $configData['add_underwriten_partner_via_api']['is_enable'];

                $isEnable          = $configData['escrow_commission']['is_enable'];
                $titlePointShutOff = $configData['title_point_shut_off']['is_enable'];

                /** End Get config value to check Lp Enable or not */
                $underWriter = '';

                // if (empty($_POST['EscrowId']) && empty($_POST['escrow_officer']) && ($isEnable == 1 || ($SalesRep == '15340')) && ($orderUser['is_allow_only_resware_orders'] == 0) && ($orderUser['is_escrow'] != 1) && $ProductTypeID == '20') {
                // if (empty($_POST['EscrowId']) && empty($_POST['escrow_officer']) && ($isEnable == 1 || ($SalesRep == '67082')) && ($orderUser['is_allow_only_resware_orders'] == 0) && ($orderUser['is_escrow'] != 1) && ($softproOrderType == 'Title only')) {
                if (empty($_POST['EscrowId']) && empty($_POST['escrow_officer']) && ($isEnable == 1 || (strtolower($salesRepDetails['lookup_code']) == 'patrickkane')) && ($orderUser['is_allow_only_resware_orders'] == 0) && ($orderUser['is_escrow'] != 1) && ($softproOrderType == 'Title only')) {
                    $lpOrderFlag = 1;
                } else {
                    $place_order                 = [];
                    $orderReq['personalDetails'] = [
                        "CompanyName"        => $CompanyName,
                        "Email"              => $OpenEmail,
                        "FirstName"          => $OpenName,
                        "LastName"           => $OpenLastName,
                        "Telephone"          => $Opentelephone,
                        "Address"            => $StreetAddress,
                        "City"               => $City,
                        "ZipCode"            => $Zipcode,
                        "EmailNotifications" => true,
                        "State"              => "",
                        "SalesRep"           => $salesRepName,
                        "ClientLookupCode"   => $ClientLookupCode,
                        "CompanyLookupCode"  => $CompanyLookupCode,
                        "UserType"           => $ClientType,
                    ];
                    $orderReq['propertyDetails'] = [
                        "Address1"           => $PropertyAddress,
                        "Address2"           => "",
                        "APNNumberParcelID"  => $apn,
                        "Country"            => $County,
                        "Description"        => $LegalDescription,
                        "City"               => $PropertyCity,
                        "State"              => $PropertyState,
                        "Zip"                => $PropertyZip,
                        "EscrowBriefLegal"   => $LegalDescription,
                        "IsPrimaryResidence" => true,
                        "State"              => "CA",
                    ];
                    
                    $transactionDetailsReq = [
                        "LookUpCodeTitleOffice" => $titleOfficerLookupCode,
                        "TitleOffice"           => $titleOfficerName,
                        "Product"                => $softproProductType,
                        "EscrowNumber"           => $EscrowNumber,
                        // "PrimaryBorrower"        => $primaryBorrower,
                        // "SecondaryBorrower"      => $secondaryBorrower,
                        'PrimaryBorrowerFirstName' => $primaryBorrowerArray['first_name'],
                        'PrimaryBorrowerMiddleName' => $primaryBorrowerArray['middle_name'],
                        'PrimaryBorrowerLastName' => $primaryBorrowerArray['last_name'],
                        'SecondaryBorrowerFirstName' => $secondaryBorrowerArray['first_name'],
                        'SecondaryBorrowerMiddleName' => $secondaryBorrowerArray['middle_name'],
                        'SecondaryBorrowerLastName' => $secondaryBorrowerArray['last_name'],
                        // "LoanAmount" => $LoanAmount,
                    ];

                    if (!empty($SalesAmount)) {
                        $transactionDetailsReq["SalesAmount"] = $SalesAmount;
                    }
                    // $orderReq["buyersAgentDetails"] = [
                    //     "Name" => "Agent Doe",
                    //     "Email" => "agent.john@example.com",
                    //     "Telephone" => "321-654-0987",
                    //     "CompanyName" => "Realty Experts",
                    // ];
                    // $orderReq["listingAgentDetails"] = [
                    //     "Name" => "Agent Jane",
                    //     "Email" => "agent.jane@example.com",
                    //     "Telephone" => "987-654-3210",
                    //     "CompanyName" => "Prime Properties",
                    // ];
                    // $orderReq["escrowDetails"] = [
                    //     "Name" => "Sarah Carter",
                    //     "Email" => "escrow.sarah@example.com",
                    //     "Telephone" => "555-123-4567",
                    //     "CompanyName" => "Escrow Secure LLC",
                    //     "EscrowOfficerName" => "Mark Lee",
                    // ];
                    $loanFlag = 1;
                    // $legalEntity = array('EntityType' => 'INDIVIDUAL', 'IsPrimaryTransactee' => 'true', 'primary' => array('First' => $OwnerFirstName, 'Last' => $OwnerLastName), 'Address' => array('Address1' => $PropertyAddress, 'City' => $PropertyCity, 'State' => $PropertyState, 'Zip' => $PropertyZip));

                    // if (strpos($ProductTypeTxt, 'Loan') !== false) {
                    $transactionDetailsReq['TransactionType'] = $TransactionType;
                    if (!empty($escrowOfficer)) {
                        $transactionDetailsReq['EscrowOfficerName']       = ""; //$escrowOfficer;
                        $transactionDetailsReq['LookUpCodeEscrowOfficer'] = $escrowOfficer;
                    }
                    $orderReq['orderType'] = $TransactionType; //$softproOrderType;
                    if ($TransactionType != 'Purchase') {
                        $transactionDetailsReq["LoanAmount"] = $LoanAmount;
                        // $orderReq['orderType'] = "Refinance";
                        // $transactionDetailsReq['PrimaryBorrower '] = $OwnerFirstName . ' ' . $OwnerLastName;
                        $transactionDetailsReq['PrimaryBorrowerFirstName'] = $primaryOwnerArray['first_name'];
                        $transactionDetailsReq['PrimaryBorrowerMiddleName'] = $primaryOwnerArray['middle_name'];
                        $transactionDetailsReq['PrimaryBorrowerLastName'] = $primaryOwnerArray['last_name'];
                        // $place_order['Buyers'][] = $legalEntity; //
                    } else {
                        $borrowerName        = explode(' ', $primaryBorrower);
                        $borrowerLastName    = end($borrowerName);
                        $borrowerPrimaryName = array_slice($borrowerName, 0, -1);
                        $borrowerFirstName   = implode(" ", $borrowerPrimaryName);
                        $borrowers           = ['EntityType' => 'INDIVIDUAL', 'IsPrimaryTransactee' => 'true', 'primary' => ['First' => $borrowerFirstName, 'Last' => $borrowerLastName]];
                        if (isset($SalesAmount) && !empty($SalesAmount)) {
                            $transactionDetailsReq['SalesAmount'] = $SalesAmount;
                        }
                        // $transactionDetailsReq['TransactionType'] = "Purchase";
                        $loanFlag = 0;
                        $orderReq['sellerDetails'] = [
                            // "PrimaryOwner"   => $PrimaryOwner,
                            // "SecondaryOwner" => $SecondaryOwner,
                            "PrimaryOwnerFirstName"   => $primaryOwnerArray['first_name'],
                            "PrimaryOwnerMiddleName"   => $primaryOwnerArray['middle_name'],
                            "PrimaryOwnerLastName"   => $primaryOwnerArray['last_name'],
                            "SecondaryOwnerFirstName" => $secondaryOwnerArray['first_name'],
                            "SecondaryOwnerMiddleName" => $secondaryOwnerArray['middle_name'],
                            "SecondaryOwnerLastName" => $secondaryOwnerArray['last_name'],
                        ];
                        // $place_order['Sellers'][] = $legalEntity; //
                        // $place_order['Buyers'][] = $borrowers; //
                        // $place_order['SalesPrice'] = $SalesAmount; //
                    }
                    // $place_order['TransactionProductType'] = array("TransactionTypeID" => $TransactionTypeID, 'ProductTypeID' => $ProductTypeID);
                    $loan = [];
                    if (isset($LoanAmount) && !empty($LoanAmount)) {
                        $loan['LoanAmount']                  = $LoanAmount;
                        $transactionDetailsReq['LoanAmount'] = $LoanAmount;
                    }

                    if (isset($LoanNumber) && !empty($LoanNumber)) {
                        $loan['LoanNumber']                  = $LoanNumber;
                        $transactionDetailsReq['LoanNumber'] = $LoanNumber;
                    }

                    // if ($ProductTypeID == '4' || $ProductTypeID == '5' || $ProductTypeID == '36') {
                    if ($softproOrderType == 'Title & Escrow') {
                        $loan['LienPosition'] = 0;
                        $loan['LoanType']     = 'ConvIns';
                        // $place_order['SettlementStatementVersion'] = 'HUD';
                    }
                    // $orderReq['Loans']              = $loan;
                    $orderReq['transactionDetails'] = $transactionDetailsReq;
                    // echo "<pre>";
                    // print_r($orderReq);die;
                    /*$place_order['Loans'][] = $loan; //
                    $place_order['Properties'][] = array('IsPrimary' => 'true', 'StreetNumber' => $StreetNumber, 'StreetName' => $StreetName, 'City' => $PropertyCity, 'State' => $PropertyState, 'County' => $County, 'Zip' => $PropertyZip);
                    $place_order['Note']['APN'] = $apn; //
                    $place_order['Note']['parcel_id'] = $apn; //
                    $place_order['Note']['legal_description'] = $LegalDescription; //

                    if (!empty($TitleOfficer)) {
                    $place_order['Note']['title_Officer'] = $titleOfficerName; //
                    }

                    if (!empty($SalesRep)) {
                    $place_order['Note']['sales_rep'] = $salesRepName; //
                    }

                    if (!empty($buyers_agent_details)) {
                    $place_order['Note']['buyers_agent'] = $buyers_agent_details; //
                    }

                    if (!empty($listing_agent_details)) {
                    $place_order['Note']['listing_agent'] = $listing_agent_details; //
                    }

                    if (!empty($lender_details)) {
                    $place_order['Note']['lender_details'] = $lender_details; //
                    }

                    if (!empty($escrow_details)) {
                    $place_order['Note']['escrow_details'] = $escrow_details; //
                    }

                    if (!empty($EscrowNumber)) {
                    $place_order['Note']['EscrowNumber'] = $EscrowNumber; //
                    $place_order['ClientFileNumber'] = $EscrowNumber; //
                    }

                    if (!empty($Notes)) {
                    $place_order['Note']['Notes'] = $Notes; // Not Needed
                    } */
                    $orderReq['baseDetails'] = [
                        "IsRushOrder" => true,
                        "ProjectName" => "PCT",
                        "OrderType"   => $softproOrderType,
                    ];

                    // $order_data = json_encode($place_order);
                    
                    $order_data = json_encode($orderReq);

                    $logid = $this->apiLogs->syncLogs($userdata['id'], 'softpro', 'create_order', 'create_order', $order_data, [], 0, 0);
                    $response = $this->softpro->make_request('POST', 'create_order', $order_data, $user_data);
                    $this->apiLogs->syncLogs($userdata['id'], 'softpro', 'create_order', 'create_order', $order_data, json_encode($response), 0, $logid);
                    // $this->load->library('order/resware');
                    // $result = $this->resware->make_request('POST', 'orders', $order_data, $user_data);
                    $lpOrderFlag = 0;

                    if (isset($response) && !empty($response)) {
                        if ((isset($response['status']) && $response['status'] == 'error') || !isset($response['OrderNumber'])) {
                            // $message = isset($response['message']) && !empty($response['message']) ? $response['message'] : '';
                            /* Start add softpro api logs */
                            $softproLog = [
                                'request_type' => 'create_order_in_softpro',
                                'request_url'  => 'create_order',
                                'request'      => $order_data,
                                'response'     => json_encode($response),
                                'status'       => 'error',
                                'created_at'   => date("Y-m-d H:i:s"),
                            ];

                            $this->db->insert('pct_resware_log', $softproLog);
                            /* End add softpro api logs */

                            echo json_encode($response);
                            exit;
                        } else {
                            // $response = $response['data'];
                            $orderNumber = $file_id = '';
                            if (isset($response['OrderNumber']) && !empty($response['OrderNumber'])) {
                                $orderNumber = isset($response['OrderNumber']) && !empty($response['OrderNumber']) ? $response['OrderNumber'] : '';
                                /* Start add softpro api logs */
                                $softproLog = [
                                    'request_type' => 'create_order_in_softpro',
                                    'request_url'  => 'create_order',
                                    'request'      => $order_data,
                                    'response'     => json_encode($response),
                                    'status'       => 'success',
                                    // 'file_id' => $file_id,
                                    'file_number'  => $orderNumber,
                                    'created_at'   => date("Y-m-d H:i:s"),
                                ];
                                // print_r($softproLog);die;
                                $this->db->insert('pct_resware_log', $softproLog);
                                $this->order->updateTaskStatus('open_order', $orderNumber);
                               
                            }

                            /* End add softpro api logs */
                        }
                    } else {
                        $response = ['status' => 'error', 'message' => 'Credentials error.'];
                        echo json_encode($response);
                        exit;
                    }
                }

                $lp_file_number = null;
                $customer_id    = isset($_POST['id']) && !empty($_POST['id']) ? $_POST['id'] : '';
                if ($lpOrderFlag == 1) {
                    $orderInfo = $this->home_model->getLastFileNumberForLpOrders();
                    if (empty($orderInfo)) {
                        $lp_file_number = 'LP-00000001';
                        // $file_id = 90000001;
                    } else {
                        $lp_file_number = ++$orderInfo['lp_file_number'];
                        // $file_id = ++$orderInfo['file_id'];
                        $splitNum = explode('-', $lp_file_number);
                        if (count($splitNum) > 1) {
                            $number = ltrim($splitNum[1], '0');
                            // $file_id = 90000000 + (int) $number;
                        }
                    }

                }

                
                $spCompanyCond = [
                    "where" => array('lookup_code' => $CompanyLookupCode)
                ];
                $getCompanyDetails = $this->home_model->get_sp_company($spCompanyCond);
                if (!empty($getCompanyDetails)) {
                    $openUserCompanyId = $getCompanyDetails[0]['id'];
                }

                $propertyData = [
                    'customer_id'       => $customer_id,
                    'buyer_agent_id'    => $BuyerAgentId,
                    'listing_agent_id'  => $ListingAgentId,
                    'escrow_lender_id'  => $EscrowLenderId,
                    'lender_id'         => $lenderId,
                    'escrow_id'         => $escrowId,
                    'cpl_lender_id'     => $cplLenderId,
                    'cpl_lender_company_id' => $openUserCompanyId,
                    'address'           => removeMultipleSpace($PropertyAddress),
                    'city'              => $PropertyCity,
                    'state'             => $PropertyState,
                    'zip'               => $PropertyZip,
                    'property_type'     => $PropertyType,
                    'full_address'      => removeMultipleSpace($FullProperty),
                    'apn'               => $apn,
                    'county'            => $County,
                    'legal_description' => $LegalDescription,
                    'primary_owner'     => $PrimaryOwner,
                    'secondary_owner'   => $SecondaryOwner,
                    'unit_number'       => $this->input->post('unit_number'),
                    'status'            => 1,
                ];

                $propertyId = $this->home_model->insert($propertyData, 'property_details');

                $transactionData = [
                    'customer_id'          => $customer_id,
                    'sales_representative' => $SalesRep,
                    'title_officer'        => $TitleOfficer,
                    'sales_amount'         => $SalesAmount,
                    'loan_amount'          => $LoanAmount,
                    'loan_number'          => $LoanNumber,
                    'transaction_type'     => $TransactionType,
                    'purchase_type'        => $softproProductTypeId,
                    'product_type'         => $softproProductTypeId,
                    'order_type'           => $softproOrderTypeId,
                    'is_ccr'               => $CCR,
                    'is_underlying_docs'   => $Docs,
                    'is_plotted_easements' => $Ease,
                    'additional_email'     => implode(',', $AdditionalEmails),
                    'borrower'             => $primaryBorrower,
                    'secondary_borrower'   => $secondaryBorrower,
                    'escrow_number'        => $EscrowNumber,
                    'status'               => 1,
                ];

                $transactionId = $this->home_model->insert($transactionData, 'transaction_details');
                $randomString  = $this->order->randomPassword();
                $randomString  = md5($orderUser['id'] . $orderUser['email_address'] . $randomString);
                $orderData     = [
                    'customer_id'       => $customer_id,
                    'file_number'       => isset($orderNumber) && !empty($orderNumber) ? $orderNumber : 0,
                    'lp_file_number'    => $lp_file_number,
                    'property_id'       => $propertyId,
                    'transaction_id'    => $transactionId,
                    'created_by'        => $userdata['id'],
                    'random_number'     => $randomString,
                    'escrow_officer_id' => $escrowOfficerId,
                    'prod_type'         => $TransactionType,
                    'softpro_status'    => ($lpOrderFlag == 1) ? 'open' : '',
                    'status'            => 1,
                    'is_softpro_order' => 1
                ];

                $orderId = $this->home_model->insert($orderData, 'order_details');

                if ($userdata['is_master'] == 1) {
                    $message          = 'Order number #' . $orderNumber . ' has assigned to you.';
                    $notificationData = [
                        'sent_user_id' => $customer_id,
                        'message'      => $message,
                        'is_admin'     => 0,
                        'type'         => 'assigned',
                    ];
                    $this->home_model->insert($notificationData, 'pct_order_notifications');
                    $this->order->sendNotification($message, 'assigned', $customer_id, 0);
                }

                if ($lpOrderFlag == 1) {
                    $orderNumber = $lp_file_number;
                } else {
                    $postData['file_number'] = $orderNumber;
                    $postData['order_id']    = $orderId;
                    $postData['state']       = $PropertyState;
                    $postData['county']      = $County;
                    $postData['property']    = $PropertyAddress;
                    $postData['apn']         = $apn;
                    $postData['unit_number'] = $this->input->post('unit_number');

                    //$this->titlepoint->generateGeoDoc($postData, 1);
                    //$this->order->checkGrantDoc($orderNumber, false);
                }

                /* Escrow Details */
                if (isset($escrowId) && !empty($escrowId)) {
                    // $name       = explode(' ', $escrowName);
                    // $first_name = $name[0];
                    // $last_name  = $name[1];
                    // $escrowData = [
                    //     'first_name'    => $first_name,
                    //     'last_name'     => $last_name,
                    //     'email_address' => $escrowEmail,
                    //     'company_name'  => $escrowCompany,
                    //     'telephone_no'  => $escrowTelephone,
                    //     'status'        => 1,
                    // ];
                    // $condition = [
                    //     'id' => $escrowId,
                    // ];
                    // $this->home_model->update($escrowData, $condition);
                    $message          = 'You have added on order number #' . $orderNumber;
                    $notificationData = [
                        'sent_user_id' => $escrowId,
                        'message'      => $message,
                        'is_admin'     => 0,
                        'type'         => 'added',
                    ];
                    $this->home_model->insert($notificationData, 'pct_order_notifications');
                    $this->order->sendNotification($message, 'added', $escrowId, 0);
                }
                /* Escrow Details */

                /* Lender Details */
                if (isset($lenderId) && !empty($lenderId)) {
                    // $name       = explode(' ', $lenderName);
                    // $first_name = $name[0];
                    // $last_name  = $name[1];
                    /*$lenderData = array(
                    'first_name' => $first_name,
                    'last_name' => $last_name,
                    'email_address' => $lenderEmail,
                    'company_name' => $lenderCompany,
                    'telephone_no' => $lenderTelephone,
                    'status' => 1,
                    );
                    $condition = array(
                    'id' => $lenderId,
                    );
                    $lenderId = $this->home_model->update($lenderData, $condition);*/
                    $message          = 'You have added on order number #' . $orderNumber;
                    $notificationData = [
                        'sent_user_id' => $lenderId,
                        'message'      => $message,
                        'is_admin'     => 0,
                        'type'         => 'added',
                    ];
                    $this->home_model->insert($notificationData, 'pct_order_notifications');
                    $this->order->sendNotification($message, 'added', $lenderId, 0);
                }
                /*Lender Details */

                if (!empty($SalesRep)) {
                    $message          = 'You have added on order number #' . $orderNumber;
                    $notificationData = [
                        'sent_user_id' => $SalesRep,
                        'message'      => $message,
                        'is_admin'     => 0,
                        'type'         => 'added',
                    ];
                    $this->home_model->insert($notificationData, 'pct_order_notifications');
                    $this->order->sendNotification($message, 'added', $SalesRep, 0);
                }

                if (!empty($TitleOfficer)) {
                    $message          = 'You have added on order number #' . $orderNumber;
                    $notificationData = [
                        'sent_user_id' => $TitleOfficer,
                        'message'      => $message,
                        'is_admin'     => 0,
                        'type'         => 'added',
                    ];
                    $this->home_model->insert($notificationData, 'pct_order_notifications');
                    $this->order->sendNotification($message, 'added', $TitleOfficer, 0);
                }

                if ($this->session->has_userdata('tp_api_id_' . $random_number)) {
                    $session_id = 'tp_api_id_' . $random_number;

                    $condition = [
                        'session_id' => $session_id,
                    ];
                    $tpData = [
                        // 'file_id' => $file_id,
                        'order_id'    => $orderId,
                        'file_number' => $orderNumber,
                    ];
                    $this->titlePointData->update($tpData, $condition);

                    $this->load->library('order/titlepoint');

                    if ($lpOrderFlag == 0) {
                        $postData['file_number'] = $orderNumber;
                        $postData['order_id']    = $orderId;
                        $postData['state']       = $PropertyState;
                        $postData['county']      = $County;
                        $postData['property']    = $PropertyAddress;
                        $postData['apn']         = $apn;
                        $postData['unit_number'] = $this->input->post('unit_number');
                        $this->titlepoint->generateGeoDoc($postData, 1);
                        // $this->order->checkGrantDoc($orderNumber, false);
                    }

                    // $tax_file_path = FCPATH . 'uploads/tax/' . $session_id . '.pdf';
                    // if (file_exists($tax_file_path)) {
                    //     rename(FCPATH . "/uploads/tax/" . $session_id . '.pdf', FCPATH . "/uploads/tax/" . $orderNumber .'.pdf');
                    //     $this->order->uploadDocumentOnAwsS3($orderNumber .'.pdf', 'tax');
                    // }
                    $titlePointDetails = $this->titlePointData->gettitlePointDetails($condition);
                    /** If Title point shuf off is enabled from admin setting then Legal Vesting, Tax Doc, Grant deed title point api will not call */
                    /**
                     * Comment from Jerry (26-03-2024)
                     * The manual shutoff refrains from calling legal and vesting, tax document and grant deed. It  will allow for open order to be submitted to resware,
                     * order number retrieved, and email confirmation to go out to all parties
                     */
                    if (empty($titlePointShutOff) || $titlePointShutOff == 0) {
                        $tax_serviceId = isset($titlePointDetails['cs3_service_id']) && !empty($titlePointDetails['cs3_service_id']) ? $titlePointDetails['cs3_service_id'] : '';
                        $this->titlepoint->generateTaxDoc($tax_serviceId, $orderNumber, $orderId);
                        
                        $serviceId = isset($titlePointDetails['cs4_service_id']) && !empty($titlePointDetails['cs4_service_id']) ? $titlePointDetails['cs4_service_id'] : '';
                        $this->titlepoint->generateImg($serviceId, $orderNumber, $orderId);
                        
                        $instrumentNumber = isset($titlePointDetails['cs4_instrument_no']) && !empty($titlePointDetails['cs4_instrument_no']) ? $titlePointDetails['cs4_instrument_no'] : '';
                        
                        $recordedDate = isset($titlePointDetails['cs4_recorded_date']) && !empty($titlePointDetails['cs4_recorded_date']) ? $titlePointDetails['cs4_recorded_date'] : '';
                        $fips         = isset($titlePointDetails['fips']) && !empty($titlePointDetails['fips']) ? $titlePointDetails['fips'] : '';
                        
                        $this->titlepoint->generateGrantDeed($instrumentNumber, $recordedDate, $fips, $orderNumber, $orderId);
                    }

                    $this->order->generateFeesEstimationPdf($orderId);
                    
                }
                $params = [
                    'order_details.file_number' => $orderNumber,
                ];
                if ($lpOrderFlag == 1) {
                    $params = [
                        'order_details.lp_file_number' => $orderNumber,
                    ];
                }
                // print_r($orderNumber);die;
                $orderDetails = $this->order->get_order_details($params);

                // Convert to PST
                
                $timezone = -8;
                
                $opened_date = gmdate("m-d-Y h:i A", strtotime($orderDetails['opened_date']) + 3600 * ($timezone + date("I")));
                
                // Convert to PST
                
                $data = [
                    'orderNumber'       => $orderNumber,
                    // 'orderId' => $file_id,
                    'OpenName'          => $OpenName . ' ' . $OpenLastName,
                    'Opentelephone'     => $Opentelephone,
                    'OpenEmail'         => $OpenEmail,
                    'CompanyName'       => $CompanyName,
                    'StreetAddress'     => $StreetAddress,
                    'City'              => $City,
                    'Zipcode'           => $Zipcode,
                    'openAt'            => $opened_date,
                    'PropertyAddress'   => $PropertyAddress,
                    'FullProperty'      => $FullProperty,
                    'APN'               => $apn,
                    'County'            => $County,
                    'LegalDescription'  => $LegalDescription,
                    'PrimaryOwner'      => $PrimaryOwner,
                    'SecondaryOwner'    => $SecondaryOwner,
                    'SalesRep'          => $salesRepName,
                    'TitleOfficer'      => $titleOfficerName,
                    'ProductType'       => $ProductTypeTxt,
                    'SalesAmount'       => $SalesAmount,
                    'LoanAmount'        => $LoanAmount,
                    'LoanNumber'        => $LoanNumber,
                    'EscrowNumber'      => $EscrowNumber,
                    'Notes'             => $Notes,
                    'sendermessage'     => $sendermessage,
                    'buyers_agent'      => $buyers_agent_details,
                    'listing_agent'     => $listing_agent_details,
                    'lender_details'    => $lender_details,
                    'escrow_details'    => $escrow_details,
                    'currYear'          => CURRENT_YEAR,
                    'randomString'      => $randomString,
                    'titlePointDetails' => $titlePointDetails,
                    'titlePointShutOff' => $titlePointShutOff,
                ];

                $from_name          = 'Pacific Coast Title Company';
                $from_mail          = env('FROM_EMAIL');
                $order_message_body = $this->load->view('emails/order.php', $data, true);
                $message            = $order_message_body;
                $addInSubject       = '';
                if (str_contains(strtolower($PropertyType), 'vacant land')) {
                    $addInSubject = ' - APN: ' . $apn;
                }
                $subject            = $orderNumber . ' - PCT Title Order Placed' . $addInSubject;
                $email_notification = $this->input->post('email_notification');

                $this->session->set_userdata('email_notification', $email_notification);
                if (($is_escrow == 0) && (isset($userdata['is_master']) && !empty($userdata['is_master'])) && (empty($email_notification))) {
                    $to = env('OPEN_ORDER_ADMIN_EMAIL');
                    /*$cc = array();*/
                } else {
                    $to              = $OpenEmail;
                    $parties_email[] = env('OPEN_ORDER_ADMIN_EMAIL');
                }
                $file                = [];
                $lvfilename          = $orderNumber . '.pdf';
                $deedfilename        = $orderNumber . '.pdf';
                $taxfilename         = $orderNumber . '.pdf';
                $reportFileName      = $orderNumber . '.pdf';
                $uploadFileToSoftPro = [];
                $documentIds = [];
                $this->load->model('order/document');
                if (!empty($_FILES['upload_curative']['name'])) {
                    // $this->uploadCurativeDocsToResware($orderDetails);
                    $uploadFileToSoftPro[] = [
                        "FolderName" => 'curative',
                        "FileURL"    => env('AWS_PATH') . "curative/" . $fileName,
                    ];
                    $documentData = [
                        'document_name'          => $fileName,
                        'original_document_name' => $data['file_name'],
                        'document_type_id'       => 1033,
                        'document_size'          => 0,
                        'user_id'                => $userdata['id'],
                        'order_id'               => $orderDetails['order_id'],
                        'description'            => 'Curative Documents',
                        'is_sync'                => 0,
                        'is_curative_doc'        => 1,
                    ];
            
                    $$documentIds[] = $this->document->insert($documentData);
                }
                $isLvDocs = false;
                if ((empty($titlePointShutOff) || $titlePointShutOff == 0) && $this->order->fileExistOrNotOnS3('legal-vesting/' . $lvfilename)) {
                    $file[] = env('AWS_PATH') . "legal-vesting/" . $lvfilename;
                    // $this->uploadLvDocsToResware($lvfilename, $file_id, $orderDetails, $lpOrderFlag);
                    $uploadFileToSoftPro[] = [
                        "FolderName" => 'legal-vesting',
                        "FileURL"    => env('AWS_PATH') . "legal-vesting/" . $lvfilename,
                    ];
                    $isLvDocs = true;
                    $fileSize = filesize(env('AWS_PATH') . "legal-vesting/" . $lvfilename);
                    $documentData = [
                        'document_name'          => $lvfilename,
                        'original_document_name' => $lvfilename,
                        'document_type_id'       => 1037,
                        'document_size'          => $fileSize,
                        'user_id'                => $userdata['id'],
                        'order_id'               => $orderDetails['order_id'],
                        'description'            => 'Legal & Vesting Document',
                        'is_sync'                => 0,
                        'is_prelim_document'     => 0,
                        'is_lv_doc'              => 1,
                    ];
                    $documentIds[] = $this->document->insert($documentData);
                }

                if ((empty($titlePointShutOff) || $titlePointShutOff == 0) && $this->order->fileExistOrNotOnS3('grant-deed/' . $deedfilename)) {
                    $file[] = env('AWS_PATH') . "grant-deed/" . $deedfilename;
                    // $this->uploadGrantDeedDocsToResware($deedfilename, $file_id, $orderDetails, $lpOrderFlag);
                    $uploadFileToSoftPro[] = [
                        "FolderName" => 'grant-deed',
                        "FileURL"    => env('AWS_PATH') . "grant-deed/" . $deedfilename,
                    ];
                    $fileSize = filesize(env('AWS_PATH') . "grant-deed/" . $deedfilename);
                    $documentData = [
                        'document_name'          => $deedfilename,
                        'original_document_name' => $deedfilename,
                        'document_type_id'       => 1037,
                        'document_size'          => $fileSize,
                        'user_id'                => $userdata['id'],
                        'order_id'               => $orderDetails['order_id'],
                        'description'            => 'Grant Deed Document',
                        'is_sync'                => 0,
                        'is_prelim_document'     => 0,
                        'is_grant_doc'           => 1,
                    ];
                    $documentIds[] = $this->document->insert($documentData);
                }

                if ((empty($titlePointShutOff) || $titlePointShutOff == 0) && $this->order->fileExistOrNotOnS3('tax/' . $taxfilename)) {
                    $file[] = env('AWS_PATH') . "tax/" . $taxfilename;
                    // $this->uploadTaxDocsToResware($taxfilename, $file_id, $orderDetails, $lpOrderFlag);
                    $uploadFileToSoftPro[] = [
                        "FolderName" => 'tax',
                        "FileURL"    => env('AWS_PATH') . "tax/" . $taxfilename,
                    ];
                    $fileSize = filesize(env('AWS_PATH') . "tax/" . $taxfilename);
                    $documentData = [
                        'document_name'          => $taxfilename,
                        'original_document_name' => $taxfilename,
                        'document_type_id'       => 1037,
                        'document_size'          => $fileSize,
                        'user_id'                => $userdata['id'],
                        'order_id'               => $orderDetails['order_id'],
                        'description'            => 'Tax Document',
                        'is_sync'                => 0,
                        'is_prelim_document'     => 0,
                        'is_tax_doc'             => 1,
                    ];
                    $documentIds[] = $this->document->insert($documentData);
                }

                if ($this->order->fileExistOrNotOnS3('fees-pdf/' . $reportFileName)) {
                    $file[] = env('AWS_PATH') . "fees-pdf/" . $reportFileName;
                    $uploadFileToSoftPro[] = [
                        "FolderName" => 'tax',
                        "FileURL"    => env('AWS_PATH') . "fees-pdf/" . $reportFileName,
                    ];
                    $fileSize = filesize(env('AWS_PATH') . "fees-pdf/" . $reportFileName);
                    $documentData = [
                        'document_name'          => $reportFileName,
                        'original_document_name' => $reportFileName,
                        'document_type_id'       => 1037,
                        'document_size'          => $fileSize,
                        'user_id'                => $userdata['id'],
                        'order_id'               => $orderId,
                        'description'            => 'Fees estimation',
                        'is_sync'                => 0,
                        'is_prelim_document'     => 0,
                        'is_tax_doc'             => 0,
                    ];
                    $documentIds[] = $this->document->insert($documentData);
                }

                if (!empty($uploadFileToSoftPro) && $lpOrderFlag == 0 && !empty($orderNumber)) {
                    $logData = [
                        'order_number' => $orderNumber,
                        'document_name' => $orderNumber,
                        'file_list' => json_encode($uploadFileToSoftPro),
                        "document_ids" => json_encode($documentIds)
                    ];
                    
                    $fileUploadLogId = $this->order->save_sp_file_upload_log($logData);

                    $fileData = [
                        "Id" => $fileUploadLogId,
                        "OrderNumber"  => $orderNumber,
                        "DocumentName" => $orderNumber,
                        "FileList"     => $uploadFileToSoftPro,
                    ];
                    $fileUploadReq[] = $fileData;
                    $reqData = json_encode($fileUploadReq);
                    // $reqData = json_encode($fileData);
                    // print_r($reqData);
                    $logid = $this->apiLogs->syncLogs($userdata['id'], 'softpro', 'upload_document', 'upload_document', $reqData, [], 0, 0);
                    $result = $this->softpro->make_request('POST', 'upload_document', $reqData);
                    $this->apiLogs->syncLogs($userdata['id'], 'softpro', 'upload_document', 'upload_document', $reqData, json_encode($response), 0, $logid);

                    $response = json_decode($result, true);
                    if (isset($response) && !empty($response)) {
                        foreach ($response as $key => $res) {
                            if ($res['Status'] == 200) {
                                $updateData[] = [
                                    'is_synced' => 1,
                                    'id' => $res['Id']
                                ];
                                $this->db->where_in('id', $documentIds);
                                $this->db->update('pct_order_documents', ['is_sync' => 1]);
                            } else {
                                $updateArr = [
                                    'is_synced' =>  (strpos(strtolower($res['Message']), "locked for editing by user") !== false) ? 0 : 1,
                                    'id' => $res['Id'],
                                    'reason' => $res['Message']
                                ];
                                if ($updateArr['is_synced'] && $isLvDocs) {
                                    $this->order->updateTaskStatus('lv_client', $orderNumber);
                                }
                                $updateData[] = $updateArr;
                            }
                        }
                    }

                    foreach ($updateData as $key => $update_row) {
                        $this->db->where('id', $update_row['id']);
                        $this->db->update('sp_file_upload_logs', $update_row);
                    }

                    /* Start upload softpro api logs */
                    $softproLog = [
                        'request_type' => 'upload_file_in_softpro',
                        'request_url'  => 'upload_file',
                        'request'      => $reqData,
                        'response'     => $result,
                        'status'       => '',//$response['status'],
                        'file_number'  => $orderNumber,
                        'created_at'   => date("Y-m-d H:i:s"),
                    ];
                    $this->db->insert('pct_resware_log', $softproLog);
                    /* End upload softpro api logs */
                }

                // $escrow_officer_email = '';

                // if (isset($escrowOfficer) && !empty($escrowOfficer) && ($ProductTypeID == '4' || $ProductTypeID == '5' || $ProductTypeID == '36')) {
                // if (isset($escrowOfficer) && !empty($escrowOfficer) && ($softproOrderType == 'Title & Escrow')) {
                //     $con = array(
                //         'where' => array(
                //             'partner_id' => $escrowOfficer,
                //         ),
                //     );
                //     $escrowCompanyData = $this->home_model->get_company_rows($con);
                //     $escrow_officer_email = $escrowCompanyData[0]['email'];
                //     //$escrow_officer_email = 'hitesh.p@crestinfosystems.com';
                //     $parties_email[] = $escrow_officer_email;
                // }

                $parties_email[] = 'openorders@pct.com';
                /*$cc = array(env('OPEN_ORDER_ADMIN_EMAIL'));*/
                //$parties_email[] = env('ORDER_ADMIN_EMAIL');
                $cc = isset($parties_email) && !empty($parties_email) ? $parties_email : [];
                $this->load->helper('sendemail');

                $mailParams = [
                    'from_mail' => $from_mail,
                    'from_name' => $from_name,
                    'to'        => $to,
                    'subject'   => $subject,
                    'message'   => json_encode($data),
                    'file'      => json_encode($file),
                    'cc'        => json_encode($cc),
                ];

                $condition = [
                    'where' => [
                        'file_number' => $orderNumber,
                    ],
                ];
                $titlePointDetails = $this->titlePointData->gettitlePointDetails($condition);
                $lvDocStatus       = strtolower($titlePointDetails[0]['lv_file_status']);
                $taxDocStatus      = strtolower($titlePointDetails[0]['tax_file_status']);
                $taxDataStatus     = strtolower($titlePointDetails[0]['tax_data_status']);
                $emailSentFlag     = strtolower($titlePointDetails[0]['email_sent_status']);
                $this->apiLogs->syncLogs(0, 'email-check-order', 'email-check-order', $orderNumber, ['$titlePointShutOff' => $titlePointShutOff, '$emailSentFlag' => $emailSentFlag, '$taxDocStatus' => $taxDocStatus, 'tax_data_status' => $taxDataStatus, '$lvDocStatus' => $lvDocStatus, 'lp_file_number' => $orderDetails['lp_file_number']], [], 0, 0);

                if ((! isset($orderDetails['lp_file_number']) || empty($orderDetails['lp_file_number'])) &&
                    $emailSentFlag != 1 &&
                    ((($lvDocStatus == 'success' || $lvDocStatus == 'failed' || $lvDocStatus == 'exception') &&
                        ($taxDocStatus == 'success' || $taxDocStatus == 'failed' || $taxDocStatus == 'exception')) || $titlePointShutOff == 1)
                ) {
                    // $to = 'hitesh.p@crestinfosystems.com';
                    // $cc = ['piyush.j@crestinfosystems.net'];
                    if (isset($titleOfficerDetails['email_address']) && !empty($titleOfficerDetails['email_address'])) {
                        $cc[] = $titleOfficerDetails['email_address'];
                    }
                    $logid       = $this->apiLogs->syncLogs($userdata['id'], 'sendgrid', 'send_confirmation_resware_order_mail_home_index_' . $orderNumber, '', $mailParams, [], $orderId, 0);
                    $mail_result = send_email($from_mail, $from_name, $to, $subject, $message, $file, $cc, []);
                    $this->apiLogs->syncLogs($userdata['id'], 'sendgrid', 'send_confirmation_resware_order_mail_home_index_' . $orderNumber, '', $mailParams, ['status' => $mail_result], $orderId, $logid);
                    // $to = ['piyush.j@crestinfosystems.net'];
                    // $cc[] = 'piyush.j@crestinfosystems.net';
                    // $taxDataStatus = 'falied';
                    if ($taxDataStatus != 'success') {
                        // $subject = $orderNumber . ' - PCT Title Order Placed But Tax details not found';
                        //send_email($from_mail, $from_name, $to, $subject, $message, $file, $cc, array());
                        //$this->apiLogs->syncLogs($userdata['id'], 'sendgrid', 'send_confirmation_order_mail_CS_notification', '', $mailParams, array('status' => $mail_result), $orderId, $logid);
                    }

                    $tpData = [
                        'email_sent_status' => ($mail_result) ? 1 : 0,
                    ];

                    $condition = [
                        'file_number' => $orderNumber,
                    ];
                    $this->titlePointData->update($tpData, $condition);
                }

                // if ((!empty($escrowEmail) && $loanFlag == 1) || (!empty($escrow_officer_email))) {
                if (!empty($escrowEmail) && $loanFlag == 1) {

                    $sales_rep_img = isset($salesRepDetails["sales_rep_profile_img"]) && !empty($salesRepDetails["sales_rep_profile_img"]) ? $salesRepDetails["sales_rep_profile_img"] : '';
                    if (!empty($sales_rep_img)) {
                        $sales_rep_img = env('AWS_PATH') . str_replace('uploads/', '', $sales_rep_img);
                    }

                    $email_data = [
                        'orderNumber'     => $orderNumber,
                        'PropertyAddress' => $PropertyAddress,
                        'randomString'    => $randomString,
                        'headerImg'       => $sales_rep_img,
                        'currYear'        => CURRENT_YEAR,
                        'productTypeID'   => $ProductTypeID,
                        'productType'     => $softproProductType,
                        'orderType'       => $softproOrderType,
                        'OpenEmail'       => $OpenEmail,
                    ];

                    $borrower_message_body = $this->load->view('emails/borrower.php', $email_data, true);
                    $message_body          = $borrower_message_body;
                    $subject               = $orderNumber . ' - Borrower Verification';

                    $mailParams = [
                        'from_mail' => $from_mail,
                        'from_name' => $from_name,
                        'subject'   => $subject,
                        'message'   => json_encode($email_data),
                    ];

                    if (!empty($escrowEmail) && $loanFlag == 1) {
                        $to               = $escrowEmail;
                        $mailParams['to'] = $to;
                        $logid            = $this->apiLogs->syncLogs($userdata['id'], 'sendgrid', 'send_mail_to_escrow_client', '', $mailParams, [], $orderId, 0);
                        $escrow_mail_result = send_email($from_mail, $from_name, $to, $subject, $message_body);
                        $this->apiLogs->syncLogs($userdata['id'], 'sendgrid', 'send_mail_to_escrow_client', '', $mailParams, ['status' => $escrow_mail_result], $orderId, $logid);
                    }

                    // if (!empty($escrow_officer_email)) {
                    //     $to = $escrow_officer_email;
                    //     $mailParams['to'] = $to;
                    //     $logid = $this->apiLogs->syncLogs($userdata['id'], 'sendgrid', 'send_mail_to_escrow_officer', '', $mailParams, array(), $orderId, 0);
                    //     //$escrow_mail_result = send_email($from_mail, $from_name, $to, $subject, $message_body);
                    //     $this->apiLogs->syncLogs($userdata['id'], 'sendgrid', 'send_mail_to_escrow_officer', '', $mailParams, array('status' => $escrow_mail_result), $orderId, $logid);
                    // }
                }

                /* Send notification to admin based on rules */
                $condition = [
                    'where' => [
                        'title' => 'Send notification for open orders',
                    ],
                ];
                $rules = $this->home_model->get_rules_rows($condition);

                if (isset($rules) && !empty($rules)) {
                    $counties_rule = isset($rules[0]['value']) && !empty($rules[0]['value']) ? $rules[0]['value'] : [];
                    $counties_ids  = explode(',', $counties_rule);

                    $counties = [];
                    foreach ($counties_ids as $key => $value) {
                        $condition = [
                            'id' => $value,
                        ];
                        $county_data = $this->home_model->get_counties_rows($condition);
                        $counties[]  = $county_data['county'];

                        if (in_array($County, $counties)) {
                            $search_data = [
                                'orderNumber'      => $orderNumber,
                                'property_address' => $FullProperty,
                                'apn'              => $apn,
                                'currYear'         => CURRENT_YEAR,
                            ];

                            $search_package_body         = $this->load->view('emails/search_package.php', $search_data, true);
                            $search_package_message_body = $search_package_body;
                            $subject                     = 'Starter Need: ' . $PropertyAddress;
                            $to                          = env('ADMIN_EMAIL');
                            $mailParams                  = [
                                'from_mail' => env('FROM_EMAIL'),
                                'to'        => $to,
                                'subject'   => $subject,
                                'message'   => json_encode($search_data),
                            ];

                            $logid = $this->apiLogs->syncLogs($userdata['id'], 'sendgrid', 'send_mail_to_admin_for_search_package', '', $mailParams, [], $orderId, 0);

                            $search_mail_result = send_email($from_mail, $from_name, $to, $subject, $search_package_message_body, [], [], []);

                            $this->apiLogs->syncLogs($userdata['id'], 'sendgrid', 'send_mail_to_admin_for_search_package', '', $mailParams, ['status' => $search_mail_result], $orderId, $logid);
                        }
                    }
                }
                /* Send notification to admin based on rules */

                /* Call HomeDocs API  */
                if (count($escrow_details_api) || count($lender_details_api)) {

                    $api_data                           = [];
                    $FullProperty                       = $this->input->post('property_address');
                    $api_data['escrow_details']         = $escrow_details_api;
                    $api_data['lender_details']         = $lender_details_api;
                    $api_data['borrwer_details']        = [];
                    $api_data['escrow_officer_details'] = [];

                    $api_data['property_details'] = [
                        'address' => $this->input->post('property-full-address'),
                    ];
                    $this->load->helper('homedocsapi');
                    // $result = true;

                    $result = call_homedocs_api($api_data);
                }
                /* Call HomeDocs API  */

                $response = ['status' => 'success', 'message' => 'Data saved successfully.', 'file_id' => $orderNumber];
                echo json_encode($response);
                exit;
            } else {
                $data['OpenName_error_msg']        = form_error('OpenName');
                $data['OpenLastName_error_msg']    = form_error('OpenLastName');
                $data['OpenEmail_error_msg']       = form_error('OpenEmail');
                $data['ProductType_error_msg']     = form_error('ProductType');
                $data['OrderType_error_msg']       = form_error('OrderType');
                $data['TransactionType_error_msg'] = form_error('TransactionType');
                $data['sendermessage_error_msg']   = form_error('sendermessage');
                $data['EscrowOfficer_error_msg']   = form_error('escrow_officer');
                $errMsg                            = form_error('OpenName') . ' ' . form_error('OpenLastName') . ' ' . form_error('OpenName') . ' ' . form_error('OpenEmail') . ' ' . form_error('ProductType') . ' ' . form_error('OrderType') . ' ' . form_error('TransactionType') . ' ' . form_error('sendermessage') . ' ' . form_error('escrow_officer');

                $response = ['status' => 'error', 'message' => $errMsg];
                echo json_encode($response);
                exit;
            }
        } else {
            $data['title'] = 'Open Order | Pacific Coast Title Company';
            $customer_data = $this->home_model->get_user(['id' => $userdata['id']]);
            $is_master     = isset($customer_data['is_master']) && !empty($customer_data['is_master']) ? $customer_data['is_master'] : '';

            /*$condition = array(
            'where' => array(
            'status' => 1,
            'transaction_type_id' => 3
            )
            );

            $data['productType'] =  $this->productType->getProductTypes($condition);*/

            $condition = [
                // 'where' => array(
                //     'status' => 1,
                // ),
            ];

            // $data['titleOfficer'] = $this->titleOfficer->getTitleOfficerDetails($condition);
            $data['titleOfficer'] = $this->order->getTitleOfficerLookupDetails($condition);
            // $data['salesRep'] = $this->salesRep->getSalesRepDetails($condition);
            $condition = [
                'where' => [
                    'is_sales_rep' => 1,
                    'status'       => 1,
                ],
            ];
            // $data['salesRep'] = $this->home_model->getSalesRepDetails($condition);
            $data['salesRep'] = $this->home_model->getSPSalesRepDetails($condition);
            // $data['escrowOfficers'] = $this->home_model->getEscrowOfficerDetails();
            $data['escrowOfficers'] = $this->home_model->getEscrowOfficerLookupDetails();
            // echo "<pre>";
            // print_r($data['salesRep']);die;
            $data['productType'] = $this->home_model->get_product_types();
            // echo "<pre>";
            // print_r($data);die;
            $data['orderType']        = $this->home_model->get_order_types();
            $configData               = $this->order->getConfigData();
            $data['submitButtonFlag'] = $configData['enable_create_order_submit_button']['is_enable'];
            // $this->template->addJS('https://maps.googleapis.com/maps/api/js?key=' . env('GOOGLE_MAP_KEY') . '&libraries=places&sensor=false');
            // $this->template->addJS(base_url('assets/frontend/js/additional-methods.min.js'));
            // $this->template->addJS(base_url('assets/frontend/js/smart-form.js'));
            // $this->template->addJS(base_url('assets/frontend/js/jquery-cloneya.min.js'));
            // $this->template->addJS(base_url('assets/frontend/js/custom.js?v=' . $this->version));
            // $this->template->addJS(base_url('assets/frontend/js/order.js?v=' . $this->version));
            $this->salesdashboardtemplate->addJS('https://maps.googleapis.com/maps/api/js?key=' . env('GOOGLE_MAP_KEY') . '&libraries=places&sensor=false');
            $this->salesdashboardtemplate->addJS(base_url('assets/frontend/js/additional-methods.min.js'));
            $this->salesdashboardtemplate->addJS(base_url('assets/frontend/js/smart-form.js?v=1'));
            $this->salesdashboardtemplate->addJS(base_url('assets/frontend/js/jquery-cloneya.min.js'));
            $this->salesdashboardtemplate->addJS(base_url('assets/frontend/js/custom.js?v=' . $this->version));
            $this->salesdashboardtemplate->addJS(base_url('assets/frontend/js/order.js?v=' . $this->version));
            $this->salesdashboardtemplate->addCss(base_url('assets/frontend/css/custom.css?v=' . $this->version));
            // $this->salesdashboardtemplate->addCss( base_url('assets/libs/bootstrap/bootstrap.css'));
            if ($is_master) {
            $this->salesdashboardtemplate->show("order", "master_order", $data);
                // $this->template->show("order", "master_order", $data);
            } else {
                $data['customer_data'] = $customer_data;
                // $con = array(
                //     'where' => array(
                //         'partner_id' => $customer_data['partner_id'],
                //     ),
                // );
                // $companyData = $this->home_model->get_company_rows($con);
                // $data['deliverables'] = !empty($companyData[0]['deliverables']) ? explode(',', $companyData[0]['deliverables']) : array();
                $data['deliverables'] = [];
                $this->salesdashboardtemplate->show("order", "home", $data);
                // $this->template->show("order", "home", $data);
            }
        }
    }

    public function checkEmail()
    {
        $email = isset($_POST['CustomerEmail']) && !empty($_POST['CustomerEmail']) ? $_POST['CustomerEmail'] : '';

        $condition = [
            'where'      => [
                'email_address' => $email,
            ],
            'returnType' => 'count',
        ];
        $count = $this->home_model->get_customers($condition);

        if ($count > 0) {
            echo 'true';
        } else {
            echo 'false';
        }
    }

    public function getCustomerNumber()
    {
        $email = isset($_POST['email_address']) && !empty($_POST['email_address']) ? $_POST['email_address'] : '';

        $condition = [
            'where' => [
                'email_address' => $email,
            ],
        ];
        $result = $this->home_model->get_customers($condition);

        $data = [];
        if (isset($result) && !empty($result)) {
            $customer_number         = isset($result[0]['customer_number']) && !empty($result[0]['customer_number']) ? $result[0]['customer_number'] : '';
            $data['customer_number'] = $customer_number;
        }

        echo json_encode($data);
        exit;
    }

    public function getCustomerDetails()
    {
        $customer_no = isset($_POST['customer_no']) && !empty($_POST['customer_no']) ? $_POST['customer_no'] : '';

        $condition = [
            'where' => [
                'customer_number' => $customer_no,
            ],
        ];
        $result = $this->home_model->get_customers($condition);

        $data = [];
        if (isset($result) && !empty($result)) {
            foreach ($result as $key => $value) {
                $data['id']              = isset($value['id']) && !empty($value['id']) ? $value['id'] : '';
                $data['customer_number'] = isset($value['customer_number']) && !empty($value['customer_number']) ? $value['customer_number'] : '';
                $data['first_name']      = isset($value['first_name']) && !empty($value['first_name']) ? $value['first_name'] : '';
                $data['last_name']       = isset($value['last_name']) && !empty($value['last_name']) ? $value['last_name'] : '';
                $data['telephone_no']    = isset($value['telephone_no']) && !empty($value['telephone_no']) ? $value['telephone_no'] : '';
                $data['email_address']   = isset($value['email_address']) && !empty($value['email_address']) ? $value['email_address'] : '';
                $data['company_name']    = isset($value['company_name']) && !empty($value['company_name']) ? $value['company_name'] : '';
                $data['street_address']  = isset($value['street_address']) && !empty($value['street_address']) ? $value['street_address'] : '';
                $data['city']            = isset($value['city']) && !empty($value['city']) ? $value['city'] : '';
                $data['zip_code']        = isset($value['zip_code']) && !empty($value['zip_code']) ? $value['zip_code'] : '';
                $data['is_escrow']       = isset($value['is_escrow']) && !empty($value['is_escrow']) ? $value['is_escrow'] : 0;
            }
        }

        echo json_encode($data);
    }

    public function orderSubmit()
    {
        $fileNum = $this->uri->segment(2);
        // print_r($fileNum);die;
        $this->load->library('order/order');
        $data = [];
        if ($fileNum) {
            $condition = [
                'where' => [
                    'file_number' => $fileNum,
                ],
            ];
            $titlePointDetails = $this->titlePointData->gettitlePointDetails($condition);
            $session_id        = isset($titlePointDetails[0]['session_id']) && !empty($titlePointDetails[0]['session_id']) ? $titlePointDetails[0]['session_id'] : '';
            $order_id          = $titlePointDetails[0]['order_id'];
            $params            = [
                'order_details.id' => $order_id,
            ];
            $this->session->unset_userdata($session_id);
            $orderDetails = $this->order->get_order_details($params);
            // echo "<pre>";
            // print_r($orderDetails);die;
            $file_number = isset($orderDetails['file_number']) && !empty($orderDetails['file_number']) ? $orderDetails['file_number'] : '';

            $property_id  = isset($orderDetails['property_id']) && !empty($orderDetails['property_id']) ? $orderDetails['property_id'] : '';
            $customer_id  = isset($orderDetails['customer_id']) && !empty($orderDetails['customer_id']) ? $orderDetails['customer_id'] : '';
            $propertyData = $this->home_model->get_property_details($property_id);
            $orderId      = isset($orderDetails['order_id']) && !empty($orderDetails['order_id']) ? $orderDetails['order_id'] : '';
            $county       = isset($propertyData['county']) && !empty($propertyData['county']) ? $propertyData['county'] : '';
            $apn          = isset($propertyData['apn']) && !empty($propertyData['apn']) ? $propertyData['apn'] : '';
            $FullProperty = isset($propertyData['full_address']) && !empty($propertyData['full_address']) ? $propertyData['full_address'] : '';
            $address      = isset($propertyData['address']) && !empty($propertyData['address']) ? $propertyData['address'] : '';

            $propertyState = isset($propertyData['state']) && !empty($propertyData['state']) ? $propertyData['state'] : '';
            $lpFileNumber  = isset($orderDetails['lp_file_number']) && !empty($orderDetails['lp_file_number']) ? $orderDetails['lp_file_number'] : '';

            $propertyCity = isset($propertyData['city']) && !empty($propertyData['city']) ? $propertyData['city'] : '';
            $escrowId     = isset($propertyData['escrow_lender_id']) && !empty($propertyData['escrow_lender_id']) ? $propertyData['escrow_lender_id'] : '';
            $fileNumber   = ((isset($file_number) && !empty($file_number)) ? $file_number : ((isset($lpFileNumber) && !empty($lpFileNumber)) ? $lpFileNumber : ''));
            $lv_file_url  = '';
            if (env('AWS_ENABLE_FLAG') == 1) {
                if ($this->order->fileExistOrNotOnS3('legal-vesting/' . $fileNumber . '.pdf')) {
                    $lv_file_url = env('AWS_PATH') . "legal-vesting/" . $fileNumber . '.pdf';
                }
            } else {
                $lv_file_path = FCPATH . 'uploads/legal-vesting/' . $fileNumber . '.pdf';
                if (file_exists($lv_file_path)) {
                    $lv_file_url = base_url() . 'uploads/legal-vesting/' . $fileNumber . '.pdf';
                }
            }
            $data['lv_file_url'] = $lv_file_url;

            $deed_file_url = '';
            if (env('AWS_ENABLE_FLAG') == 1) {
                if ($this->order->fileExistOrNotOnS3('grant-deed/' . $fileNumber . '.pdf')) {
                    $deed_file_url = env('AWS_PATH') . "grant-deed/" . $fileNumber . '.pdf';
                }
            } else {
                $deed_file_path = FCPATH . 'uploads/grant-deed/' . $fileNumber . '.pdf';
                if (file_exists($deed_file_path)) {
                    $deed_file_url = base_url() . 'uploads/grant-deed/' . $fileNumber . '.pdf';
                }
            }
            $data['deed_file_url'] = $deed_file_url;

            $tax_file_url = '';
            if (env('AWS_ENABLE_FLAG') == 1) {
                if ($this->order->fileExistOrNotOnS3('tax/' . $fileNumber . '.pdf')) {
                    $tax_file_url = env('AWS_PATH') . "tax/" . $fileNumber . '.pdf';
                }
            } else {
                $tax_file_path = FCPATH . 'uploads/tax/' . $fileNumber . '.pdf';
                if (file_exists($tax_file_path)) {
                    $tax_file_url = base_url() . 'uploads/tax/' . $fileNumber . '.pdf';
                }
            }
            $data['tax_file_url'] = $tax_file_url;
        }

        $data['tp_data']       = isset($titlePointDetails[0]) && !empty($titlePointDetails[0]) ? $titlePointDetails[0] : [];
        $data['state']         = isset($propertyState) && !empty($propertyState) ? $propertyState : '';
        $data['city']          = isset($propertyCity) && !empty($propertyCity) ? $propertyCity : '';
        $data['county']        = isset($county) && !empty($county) ? $county : '';
        $data['apn']           = isset($apn) && !empty($apn) ? $apn : '';
        $data['property']      = isset($FullProperty) && !empty($FullProperty) ? $FullProperty : '';
        $data['address']       = isset($address) && !empty($address) ? $address : '';
        $data['customer_id']   = isset($customer_id) && !empty($customer_id) ? $customer_id : '';
        $data['file_num']      = $file_number;
        $data['order_id']      = $orderId;
        $data['escrow_id']     = $escrowId;
        $data['lpFileNumber']  = $lpFileNumber;
        $data['lpFileStatus']  = $titlePointDetails[0]['lv_file_status'];
        $data['taxFileStatus'] = $titlePointDetails[0]['tax_file_status'];
        // $this->salesdashboardtemplate->addJS( base_url('assets/frontend/js/jquery-1.9.1.min.js?v=' . $this->version) );
        $this->salesdashboardtemplate->addJS(base_url('assets/frontend/js/jquery-cloneya.min.js?v=' . $this->version));
        $this->salesdashboardtemplate->addJS(base_url('assets/frontend/js/order.js?v=' . $this->version));
        $this->salesdashboardtemplate->show("order", "order-submission", $data);
        // $this->load->view('layout/head', $data);
        // $this->load->view('order/order-submission', $data);

    }

    public function checkDocument()
    {
        $fileNumber = $this->input->post('file_number');
        $docType    = $this->input->post('doc_type');
        $url        = null;
        if ($docType == 'tax') {
            if (env('AWS_ENABLE_FLAG') == 1) {
                if ($this->order->fileExistOrNotOnS3('tax/' . $fileNumber . '.pdf')) {
                    $url = env('AWS_PATH') . "tax/" . $fileNumber . '.pdf';
                }
            } else {
                $tax_file_path = FCPATH . 'uploads/tax/' . $fileNumber . '.pdf';
                if (file_exists($tax_file_path)) {
                    $url = base_url() . 'uploads/tax/' . $fileNumber . '.pdf';
                }
            }
        }

        if ($docType == 'lv') {
            if (env('AWS_ENABLE_FLAG') == 1) {
                if ($this->order->fileExistOrNotOnS3('legal-vesting/' . $fileNumber . '.pdf')) {
                    $url = env('AWS_PATH') . "legal-vesting/" . $fileNumber . '.pdf';
                }
            } else {
                $lv_file_path = FCPATH . 'uploads/legal-vesting/' . $fileNumber . '.pdf';
                if (file_exists($lv_file_path)) {
                    $url = base_url() . 'uploads/legal-vesting/' . $fileNumber . '.pdf';
                }
            }
        }
        echo json_encode(['url' => $url]);
        exit;
    }

    public function preListingDocs()
    {
        $userdata = $this->session->userdata('user');
        $this->load->library('order/titlepoint');
        $this->load->model('order/note');
        // $this->load->library('order/resware');
        $escrowId = (!empty($_POST['escrow_id'])) ? $_POST['escrow_id'] : '';
        if (!empty($escrowId)) {
            $orderUser = $this->home_model->sp_get_user(['id' => $escrowId]);
        }

        if ((! isset($escrowId) || empty($escrowId)) || (!empty($orderUser) && $orderUser['is_escrow'] == 0)) {
            $fileNumber = $_POST['file_number'];

            $this->order->createLpReport($fileNumber, false, true);

            $this->order->sendOrderEmail($fileNumber);

            /** Start Execute all document creation in background */
            try {
                //code...
                $command = "php " . FCPATH . "index.php frontend/order/cron generatealldocumentfromtitlepoint $fileNumber > /dev/null &";
                exec($command);
            } catch (\Throwable $th) {
                // print_r($th->getMessages());
            }
            /** End Execute all document creation in background */

        }

    }

    public function logout()
    {
        $this->session->sess_destroy();
        $this->session->unset_userdata('user');
        redirect(base_url() . 'order');
    }

    public function notifyAdmin()
    {
        if ($this->input->post()) {
            $customer_id = $this->input->post('customer_id');
            $subject     = $this->input->post('subject');

            if (isset($customer_id) && !empty($customer_id)) {
                $condition = [
                    'id' => $customer_id,
                ];
                $customerDetails = $this->home_model->get_customers($condition);
                $first_name      = isset($customerDetails['first_name']) && !empty($customerDetails['first_name']) ? $customerDetails['first_name'] : '';
                $last_name       = isset($customerDetails['last_name']) && !empty($customerDetails['last_name']) ? $customerDetails['last_name'] : '';
                $telephone_no    = isset($customerDetails['telephone_no']) && !empty($customerDetails['telephone_no']) ? $customerDetails['telephone_no'] : '';
                $email_address   = isset($customerDetails['email_address']) && !empty($customerDetails['email_address']) ? $customerDetails['email_address'] : '';
                $company_name    = isset($customerDetails['company_name']) && !empty($customerDetails['company_name']) ? $customerDetails['company_name'] : '';
                $street_address  = isset($customerDetails['street_address']) && !empty($customerDetails['street_address']) ? $customerDetails['street_address'] : '';
                $city            = isset($customerDetails['city']) && !empty($customerDetails['city']) ? $customerDetails['city'] : '';
                $zipcode         = isset($customerDetails['zip_code']) && !empty($customerDetails['zip_code']) ? $customerDetails['zip_code'] : '';

                $property = $this->input->post('property');

                $message = '<h3>User Details:</h3><p>Name: ' . $first_name . ' ' . $last_name . '</p><p>Telephone: ' . $telephone_no . '</p><p>Email Address: ' . $email_address . '</p><p>Company Name: ' . $company_name . '</p><p>Street Address: ' . $street_address . '</p><p>City: ' . $city . '</p><p>Zipcode: ' . $zipcode . '</p><p>Property Address: ' . $property . '</p>';

                $from_name = 'Pacific Coast Title Company';
                $from_mail = env('FROM_EMAIL');
                $subject   = 'Notification for ' . $subject;
                $to        = env('ADMIN_EMAIL');

                $this->load->helper('sendemail');

                $mail_result = send_email($from_mail, $from_name, $to, $subject, $message);

                if ($mail_result) {
                    echo 'success';
                    exit;
                } else {
                    echo 'error';
                    exit;
                }
            }
        }
    }

    public function getProductTypes()
    {
        $this->load->model('order/apiLogs');
        $userdata = $this->session->userdata('user');

        $email      = isset($_POST['email']) && !empty($_POST['email']) ? $_POST['email'] : '';
        $customerId = isset($_POST['customerId']) && !empty($_POST['customerId']) ? $_POST['customerId'] : '';

        $condition = [
            'id' => $customerId,
        ];
        $customerDetails = $this->home_model->get_customers($condition);

        $email_address = isset($customerDetails['email_address']) && !empty($customerDetails['email_address']) ? $customerDetails['email_address'] : '';
        $password      = isset($customerDetails['random_password']) && !empty($customerDetails['random_password']) ? $customerDetails['random_password'] : '';
        $data          = ['email' => $email_address, 'password' => $password];

        $resware_user_id = isset($customerDetails['resware_user_id']) && !empty($customerDetails['resware_user_id']) ? $customerDetails['resware_user_id'] : '';
        $endPoint        = 'types/products?ClientsClientID=' . $resware_user_id;
        $logid           = $this->apiLogs->syncLogs($customerDetails['id'], 'resware', 'get_product_types', env('RESWARE_ORDER_API') . $endPoint, $data, [], 0, 0);
        $this->load->library('order/resware');
        $result = $this->resware->make_request('GET', $endPoint, [], $data);
        $this->apiLogs->syncLogs($customerDetails['id'], 'resware', 'get_product_types', env('RESWARE_ORDER_API') . $endPoint, $data, $result, 0, $logid);
        $response      = json_decode($result, true);
        $product_types = [];

        if (isset($response) && !empty($response)) {
            foreach ($response as $key => $value) {
                if (isset($value['TransactionTypeID']) && $value['TransactionTypeID'] == 3) {
                    $con = [
                        'where'      => [
                            'product_type_id' => $value['ProductTypeID'],
                            'status'          => 1,
                        ],
                        'returnType' => 'count',
                    ];
                    $prevCount = $this->home_model->get_product_types($con);
                    if (empty($prevCount)) {
                        $productData = [
                            'transaction_type'    => trim($value['TransactionType']),
                            'transaction_type_id' => $value['TransactionTypeID'],
                            'product_type'        => trim($value['ProductType']),
                            'product_type_id'     => $value['ProductTypeID'],
                            'state'               => 'CA',
                            'status'              => 1,
                        ];
                        $insert = $this->home_model->insert($productData, 'pct_order_product_types');
                    }

                    $product_types[$value['ProductTypeID']] = $value['ProductType'];
                }
            }
        }
        echo json_encode($product_types);
        exit;
    }

    public function uploadLvDocsToResware($document_name, $fileId, $orderDetails, $lpOrderFlag)
    {
        $this->load->model('order/document');
        $this->load->library('order/resware');
        $this->load->model('order/apiLogs');
        $userdata = $this->session->userdata('user');
        if (env('AWS_ENABLE_FLAG') == 1) {
            $fileSize = filesize(env('AWS_PATH') . "legal-vesting/" . $document_name);
            $contents = file_get_contents(env('AWS_PATH') . "legal-vesting/" . $document_name);
        } else {
            $fileSize = filesize(FCPATH . 'uploads/legal-vesting/' . $document_name);
            $contents = file_get_contents(base_url() . 'uploads/legal-vesting/' . $document_name);
        }
        $binaryData = base64_encode($contents);

        $documentData = [
            'document_name'          => $document_name,
            'original_document_name' => $document_name,
            'document_type_id'       => 1037,
            'document_size'          => $fileSize,
            'user_id'                => $userdata['id'],
            'order_id'               => $orderDetails['order_id'],
            'description'            => 'Legal & Vesting Document',
            'is_sync'                => 1,
            'is_prelim_document'     => 0,
            'is_lv_doc'              => 1,
        ];
        $documentId = $this->document->insert($documentData);
        if ($lpOrderFlag == 0) {
            $endPoint        = 'files/' . $orderDetails['file_id'] . '/documents';
            $documentApiData = [
                'DocumentName' => $document_name,
                'DocumentType' => [
                    'DocumentTypeID' => 1037,
                ],
                'Description'  => 'Legal & Vesting Document',
                'InternalOnly' => false,
                'DocumentBody' => $binaryData,
            ];
            $document_api_data = json_encode($documentApiData, JSON_UNESCAPED_SLASHES);

            if ($userdata['is_master'] == 1) {
                $orderUser             = $this->home_model->sp_get_user(['id' => $orderDetails['customer_id']]);
                $user_data['email']    = $orderUser['email_address'];
                $user_data['password'] = $orderUser['random_password'];
            } else {
                $user_data = [];
            }

            $logid  = $this->apiLogs->syncLogs($userdata['id'], 'resware', 'create_document', env('RESWARE_ORDER_API') . $endPoint, $documentApiData, [], $orderDetails['order_id'], 0);
            $result = $this->resware->make_request('POST', $endPoint, $document_api_data, $user_data);
            $this->apiLogs->syncLogs($userdata['id'], 'resware', 'create_document', env('RESWARE_ORDER_API') . $endPoint, $documentApiData, $result, $orderDetails['order_id'], $logid);
            $res = json_decode($result);
            /* Start add resware api logs */
            $reswareLogData = [
                'request_type' => 'upload_lv_document_to_resware',
                'request_url'  => env('RESWARE_ORDER_API') . $endPoint,
                'request'      => $document_api_data,
                'response'     => $result,
                'status'       => 'success',
                'created_at'   => date("Y-m-d H:i:s"),
            ];
            $this->db->insert('pct_resware_log', $reswareLogData);
            /* End add resware api logs */
            $this->document->update(['api_document_id' => $res->Document->DocumentID], ['id' => $documentId]);
        }
    }

    public function uploadGrantDeedDocsToResware($document_name, $fileId, $orderDetails, $lpOrderFlag)
    {
        $this->load->model('order/document');
        $this->load->library('order/resware');
        $this->load->model('order/apiLogs');
        $userdata = $this->session->userdata('user');
        if (env('AWS_ENABLE_FLAG') == 1) {
            $fileSize = filesize(env('AWS_PATH') . "grant-deed/" . $document_name);
            $contents = file_get_contents(env('AWS_PATH') . "grant-deed/" . $document_name);
        } else {
            $fileSize = filesize(FCPATH . 'uploads/grant-deed/' . $document_name);
            $contents = file_get_contents(base_url() . 'uploads/grant-deed/' . $document_name);
        }
        $binaryData = base64_encode($contents);

        $documentData = [
            'document_name'          => $document_name,
            'original_document_name' => $document_name,
            'document_type_id'       => 1037,
            'document_size'          => $fileSize,
            'user_id'                => $userdata['id'],
            'order_id'               => $orderDetails['order_id'],
            'description'            => 'Grant Deed Document',
            'is_sync'                => 1,
            'is_prelim_document'     => 0,
            'is_grant_doc'           => 1,
        ];
        $documentId = $this->document->insert($documentData);
        if ($lpOrderFlag == 0) {
            $endPoint        = 'files/' . $orderDetails['file_id'] . '/documents';
            $documentApiData = [
                'DocumentName' => $document_name,
                'DocumentType' => [
                    'DocumentTypeID' => 1037,
                ],
                'Description'  => 'Grant Deed Document',
                'InternalOnly' => false,
                'DocumentBody' => $binaryData,
            ];
            $document_api_data = json_encode($documentApiData, JSON_UNESCAPED_SLASHES);

            if ($userdata['is_master'] == 1) {
                $orderUser             = $this->home_model->sp_get_user(['id' => $orderDetails['customer_id']]);
                $user_data['email']    = $orderUser['email_address'];
                $user_data['password'] = $orderUser['random_password'];
            } else {
                $user_data = [];
            }

            $logid  = $this->apiLogs->syncLogs($userdata['id'], 'resware', 'create_document', env('RESWARE_ORDER_API') . $endPoint, $documentApiData, [], $orderDetails['order_id'], 0);
            $result = $this->resware->make_request('POST', $endPoint, $document_api_data, $user_data);
            $this->apiLogs->syncLogs($userdata['id'], 'resware', 'create_document', env('RESWARE_ORDER_API') . $endPoint, $documentApiData, $result, $orderDetails['order_id'], $logid);
            $res = json_decode($result);
            /* Start add resware api logs */
            $reswareLogData = [
                'request_type' => 'upload_grantdeed_document_to_resware',
                'request_url'  => env('RESWARE_ORDER_API') . $endPoint,
                'request'      => $document_api_data,
                'response'     => $result,
                'status'       => 'success',
                'created_at'   => date("Y-m-d H:i:s"),
            ];
            $this->db->insert('pct_resware_log', $reswareLogData);
            /* End add resware api logs */
            $this->document->update(['api_document_id' => $res->Document->DocumentID], ['id' => $documentId]);
        }

    }

    public function uploadTaxDocsToResware($document_name, $fileId, $orderDetails, $lpOrderFlag)
    {
        $this->load->model('order/document');
        $this->load->library('order/resware');
        $this->load->model('order/apiLogs');
        $userdata = $this->session->userdata('user');
        if (env('AWS_ENABLE_FLAG') == 1) {
            $fileSize = filesize(env('AWS_PATH') . "tax/" . $document_name);
            $contents = file_get_contents(env('AWS_PATH') . "tax/" . $document_name);
        } else {
            $fileSize = filesize(FCPATH . 'uploads/tax/' . $document_name);
            $contents = file_get_contents(base_url() . 'uploads/tax/' . $document_name);
        }

        $binaryData = base64_encode($contents);

        $documentData = [
            'document_name'          => $document_name,
            'original_document_name' => $document_name,
            'document_type_id'       => 1037,
            'document_size'          => $fileSize,
            'user_id'                => $userdata['id'],
            'order_id'               => $orderDetails['order_id'],
            'description'            => 'Tax Document',
            'is_sync'                => 1,
            'is_prelim_document'     => 0,
            'is_tax_doc'             => 1,
        ];
        $documentId = $this->document->insert($documentData);

        if ($lpOrderFlag == 0) {
            $endPoint        = 'files/' . $orderDetails['file_id'] . '/documents';
            $documentApiData = [
                'DocumentName' => $document_name,
                'DocumentType' => [
                    'DocumentTypeID' => 1037,
                ],
                'Description'  => 'Tax Document',
                'InternalOnly' => false,
                'DocumentBody' => $binaryData,
            ];
            $document_api_data = json_encode($documentApiData, JSON_UNESCAPED_SLASHES);

            if ($userdata['is_master'] == 1) {
                $orderUser             = $this->home_model->sp_get_user(['id' => $orderDetails['customer_id']]);
                $user_data['email']    = $orderUser['email_address'];
                $user_data['password'] = $orderUser['random_password'];
            } else {
                $user_data = [];
            }

            $logid  = $this->apiLogs->syncLogs($userdata['id'], 'resware', 'create_document', env('RESWARE_ORDER_API') . $endPoint, $documentApiData, [], $orderDetails['order_id'], 0);
            $result = $this->resware->make_request('POST', $endPoint, $document_api_data, $user_data);
            $this->apiLogs->syncLogs($userdata['id'], 'resware', 'create_document', env('RESWARE_ORDER_API') . $endPoint, $documentApiData, $result, $orderDetails['order_id'], $logid);
            $res = json_decode($result);
            /* Start add resware api logs */
            $reswareLogData = [
                'request_type' => 'upload_tax_document_to_resware',
                'request_url'  => env('RESWARE_ORDER_API') . $endPoint,
                'request'      => $document_api_data,
                'response'     => $result,
                'status'       => 'success',
                'created_at'   => date("Y-m-d H:i:s"),
            ];
            $this->db->insert('pct_resware_log', $reswareLogData);
            /* End add resware api logs */
            $this->document->update(['api_document_id' => $res->Document->DocumentID], ['id' => $documentId]);
        }

    }

    public function uploadPreListingDocsToResware($document_name, $fileId, $orderDetails)
    {
        $this->load->model('order/document');
        $this->load->library('order/resware');
        $this->load->model('order/apiLogs');
        $userdata   = $this->session->userdata('user');
        $fileSize   = filesize(env('AWS_PATH') . "pre-listing-doc/" . $document_name);
        $contents   = file_get_contents(env('AWS_PATH') . "pre-listing-doc/" . $document_name);
        $binaryData = base64_encode($contents);

        $documentData = [
            'document_name'          => $document_name,
            'original_document_name' => $document_name,
            'document_type_id'       => 1037,
            'document_size'          => $fileSize,
            'user_id'                => $userdata['id'],
            'order_id'               => $orderDetails['order_id'],
            'description'            => 'Pre Listing Document',
            'is_sync'                => 1,
            'is_prelim_document'     => 0,
            'is_pre_listing_doc'     => 1,
        ];
        $condition = ['is_pre_listing_doc' => 1, 'order_id' => $orderDetails['order_id']];
        $this->document->delete($documentData, $condition);
        $documentId = $this->document->insert($documentData);

        /** Upload records to resware  */

        /*
    $endPoint = 'files/'.$orderDetails['file_id'].'/documents';

    $documentApiData = array(
    'DocumentName' => $document_name,
    'DocumentType' => array(
    'DocumentTypeID' => 1037,
    ),
    'Description' => 'Pre Listing Document',
    'InternalOnly' => false,
    'DocumentBody' => $binaryData
    );
    $document_api_data = json_encode($documentApiData, JSON_UNESCAPED_SLASHES);

    if ($userdata['is_master'] == 1) {
    $orderUser =  $this->home_model->get_user(array('id' => $orderDetails['customer_id']));
    $user_data['email'] = $orderUser['email_address'];
    $user_data['password'] = $orderUser['random_password'];
    // $user_data['admin_api'] = 1;
    } else {
    $user_data = array();
    }

    $user_data['admin_api'] = 1;
    $logid = $this->apiLogs->syncLogs($userdata['id'], 'resware', 'create_document', env('RESWARE_ORDER_API').$endPoint, $documentApiData, array(), $orderDetails['order_id'], 0);
    $result = $this->resware->make_request('POST', $endPoint, $document_api_data, $user_data);
    $this->apiLogs->syncLogs($userdata['id'], 'resware', 'create_document', env('RESWARE_ORDER_API').$endPoint, $documentApiData, $result, $orderDetails['order_id'], $logid);
    $res = json_decode($result);
    $this->document->update(array('api_document_id' => $res->Document->DocumentID), array('id' => $documentId));*/
    }

    public function checkDuplicateOrder()
    {
        $apn    = $this->input->post('apn');
        $result = $this->order->checkDuplicateOrder($apn);
        if ($result) {
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false]);
        }
    }

    public function uploadCurativeDocsToResware($orderDetails)
    {
        $this->load->model('order/document');
        $this->load->model('order/apiLogs');
        $this->load->library('order/resware');
        $userdata      = $this->session->userdata('user');
        $data          = $this->upload->data();
        $contents      = file_get_contents($data['full_path']);
        $binaryData    = base64_encode($contents);
        $document_name = date('YmdHis') . "_" . $data['file_name'];
        rename(FCPATH . "/uploads/curative/" . $data['file_name'], FCPATH . "/uploads/curative/" . $document_name);

        $documentData = [
            'document_name'          => $document_name,
            'original_document_name' => $data['file_name'],
            'document_type_id'       => 1033,
            'document_size'          => ($data['file_size'] * 1000),
            'user_id'                => $userdata['id'],
            'order_id'               => $orderDetails['order_id'],
            'description'            => 'Curative Documents',
            'is_sync'                => 1,
            'is_curative_doc'        => 1,
        ];

        $documentId = $this->document->insert($documentData);

        $endPoint = 'files/' . $orderDetails['file_id'] . '/documents';

        $documentApiData = [
            'DocumentName' => $data['file_name'],
            'DocumentType' => [
                'DocumentTypeID' => 1033,
            ],
            'Description'  => 'Curative Documents',
            'InternalOnly' => false,
            'DocumentBody' => $binaryData,
        ];
        $document_api_data = json_encode($documentApiData, JSON_UNESCAPED_SLASHES);

        if ($userdata['is_master'] == 1) {
            $orderUser             = $this->home_model->sp_get_user(['id' => $orderDetails['customer_id']]);
            $user_data['email']    = $orderUser['email_address'];
            $user_data['password'] = $orderUser['random_password'];
        } else {
            $user_data = [];
        }

        $logid  = $this->apiLogs->syncLogs($userdata['id'], 'resware', 'create_document', env('RESWARE_ORDER_API') . $endPoint, $documentApiData, [], $orderDetails['order_id'], 0);
        $result = $this->resware->make_request('POST', $endPoint, $document_api_data, $user_data);
        $this->apiLogs->syncLogs($userdata['id'], 'resware', 'create_document', env('RESWARE_ORDER_API') . $endPoint, $documentApiData, $result, $orderDetails['order_id'], $logid);
        $res = json_decode($result);

        /* Start add resware api logs */
        $reswareLogData = [
            'request_type' => 'upload_curative_document_to_resware',
            'request_url'  => env('RESWARE_ORDER_API') . $endPoint,
            'request'      => $document_api_data,
            'response'     => $result,
            'status'       => 'success',
            'created_at'   => date("Y-m-d H:i:s"),
        ];
        $this->db->insert('pct_resware_log', $reswareLogData);
        /* End add resware api logs */

        $this->document->update(['api_document_id' => $res->Document->DocumentID], ['id' => $documentId]);
        $this->order->uploadDocumentOnAwsS3($document_name, 'curative');
    }

    public function send_invite()
    {

        $this->form_validation->set_rules('borrower_email', 'Email', 'required|valid_email', ['required' => 'Enter borrower Email', 'valid_email' => 'Enter valid Email']);
        $this->form_validation->set_rules('borrower_name', 'Name', 'required', ['required' => 'Enter borrower Name']);

        $response_data = [
            'status'  => false,
            'message' => 'Something went wrong',
        ];

        if ($this->form_validation->run() === true) {

            $borrower_details = ['name' => $this->input->post('borrower_name'), 'email' => $this->input->post('borrower_email')];

            /* Call HomeDocs API  */
            $api_data                           = [];
            $FullProperty                       = $this->input->post('property_address');
            $api_data['escrow_details']         = [];
            $api_data['lender_details']         = [];
            $api_data['borrwer_details']        = $borrower_details;
            $api_data['escrow_officer_details'] = [];
            $api_data['property_details']       = [
                'address' => $FullProperty,
            ];

            $this->load->helper('homedocsapi');
            // $result = true;

            $result = call_homedocs_api($api_data);
            /* Call HomeDocs API  */
            if ($result) {
                $update_data                     = [];
                $update_data['borrower_invited'] = true;
                $where['id']                     = $this->input->post('invite_order_id');
                $this->order->update($update_data, $where);
                $response_data['status']  = true;
                $response_data['message'] = 'Success';
            }

        } else {
            $response_data['message'] = validation_errors();
        }

        echo json_encode($response_data);
    }

    public function getDeliverables()
    {
        $partner_id = $this->input->post('partner_id');
        $this->db->select('*');
        $this->db->from('pct_order_partner_company_info');
        $this->db->where('partner_id', $partner_id);
        $query       = $this->db->get();
        $partnerInfo = $query->row_array();

        if (!empty($partnerInfo['deliverables'])) {
            $deliverables = explode(',', $partnerInfo['deliverables']);
            $result       = ['deliverables' => $deliverables];
        } else {
            $result = ['deliverables' => []];
        }
        echo json_encode($result);
        exit;
    }
}
