<?php

(defined('BASEPATH')) OR exit('No direct script access allowed');

class DashboardMail extends MX_Controller {

    function __construct() {
        parent::__construct();
        $this->load->helper(
            array('file', 'url','form')
        );
        $this->load->library('session');
        $this->load->library('form_validation');
        $this->load->library('order/order');
        $this->load->model('order/apiLogs');
        $this->load->model('order/home_model');
		$this->load->model('order/fees_model');
		$this->load->library('order/resware');
        $this->load->library('order/twilio');
        $this->load->model('order/titleOfficer');
        $this->load->model('order/twilioMessage');
        $this->load->model('order/titlePointData');
        $this->load->library('order/titlepoint');
    }

    public function generateCplFromMail()
    {
        $data['errors'] = array();
        $data['success'] = array();
        if ($this->session->userdata('errors')) {
            $data['errors'] = $this->session->userdata('errors');
            $this->session->unset_userdata('errors');
        }
        if ($this->session->userdata('success')) {
            $data['success'] = $this->session->userdata('success');
            $this->session->unset_userdata('success');
        }
        $random_number = $this->uri->segment(2); 
        $order = $this->getOrderInfo($random_number);
        $fileId = $order[0]['file_id'];  
        $data['title'] = 'Smart Dashboard | Pacific Coast Title Company';
        $data['mail_dashboard'] = 1;
        $orderDetails = $this->order->get_order_details($fileId, 1);
        $data['file_number'] = $orderDetails['file_number'];
        $data['full_address'] = $orderDetails['full_address'];
        $file_id = $orderDetails['file_id'];

        if (!empty($orderDetails['cpl_document_name'])) {
            $documentName = $orderDetails['cpl_document_name'];
            $data['action'] = "<div style='display:flex;'><a href='".base_url()."/uploads/documents/$documentName' download><button class='btn btn-grad-2a' style='background: #d35411;' type='button'>Download</button></a>
                                <a onclick='return lender_pop_up(0, $file_id);' href='javascript:void(0);'><button class='btn btn-grad-2a generate button-color' type='button'>Edit</button></a></div>";
        } else if(!empty($orderDetails['westcor_file_id'])) {
            $westcorFileId = $orderDetails['westcor_file_id'];
            $westcorOrderId = $orderDetails['westcor_order_id'];
            $data['action'] = "<div style='display:flex;'><a onclick='download_for_pdf($westcorFileId, $westcorOrderId);' href='javascript:void(0);'><button class='btn btn-grad-2a' style='background: #d35411;' type='button'>Download</button></a>
                                <a onclick='return lender_pop_up(0, $file_id);' href='javascript:void(0);'><button class='btn btn-grad-2a generate button-color' type='button'>Edit</button></a></div>";
        } else {
            $data['action'] = "<div style='display:flex;'><form onclick='return lender_pop_up(0, $file_id);' action='".base_url()."create-cpl-mail/".$file_id."' method='POST'><button class='btn btn-grad-2a generate button-color' type='submit'>GENERATE</button></form>
                                <a onclick='return lender_pop_up(0, $file_id);' href='javascript:void(0);'><button class='btn btn-grad-2a generate button-color' type='button'>Edit</button></a></div>";
        }        
        $this->load->view('layout/head_dashboard', $data);
        $this->load->view('order/mail_cpl', $data);
    }

    public function generateFeesFromMail()
    {
        $data['title'] = 'Smart Dashboard | Pacific Coast Title Company';
        $data['mail_dashboard'] = 1;

        $random_number = $this->uri->segment(2); 
        $order = $this->getOrderInfo($random_number);
        $fileId = $order[0]['file_id'];

        $orderDetails = $this->order->get_order_details($fileId,1);
        
        $orderId = isset($orderDetails['order_id']) && !empty($orderDetails['order_id']) ? $orderDetails['order_id'] : '';

        $customerId = isset($orderDetails['customer_id']) && !empty($orderDetails['customer_id']) ? $orderDetails['customer_id'] : '';

        $condition = array(
            'id' => $customerId
        );
        $customerDetails = $this->home_model->get_customers($condition);

        $email_address = isset($customerDetails['email_address']) && !empty($customerDetails['email_address']) ? $customerDetails['email_address'] : '';
        $password = isset($customerDetails['random_password']) && !empty($customerDetails['random_password']) ? $customerDetails['random_password'] : '';
        $loginData = array('email'=>$email_address,'password'=>$password,'from_mail'=>1);

        /* start get fees details from resware */
        $request = array();

        $TransactionTypeID = isset($orderDetails['transaction_type']) && !empty($orderDetails['transaction_type']) ? $orderDetails['transaction_type'] : '';
        $ProductTypeID = isset($orderDetails['purchase_type']) && !empty($orderDetails['purchase_type']) ? $orderDetails['purchase_type'] : '';
        $request['TransactionProductType'] = array("TransactionTypeID" => $TransactionTypeID, 'ProductTypeID'=>$ProductTypeID);

        $propertyAddress = isset($orderDetails['address']) && !empty($orderDetails['address']) ? $orderDetails['address'] : '';

        $addressParts = explode(' ', $propertyAddress);

        $streetNumber = isset($addressParts[0]) && !empty($addressParts[0]) ? $addressParts[0] : '';

        $primaryStreetName = array_slice($addressParts, 1);
        $streetName = isset($primaryStreetName) && !empty($primaryStreetName) ? implode(" ", $primaryStreetName) : '';

        $FullProperty = isset($orderDetails['full_address']) && !empty($orderDetails['full_address']) ? $orderDetails['full_address'] : '';
               
        $PropertyZip = isset($orderDetails['property_zip']) && !empty($orderDetails['property_zip']) ? $orderDetails['property_zip'] : '';
        
        $propertyState = isset($orderDetails['property_state']) && !empty($orderDetails['property_state']) ? $orderDetails['property_state'] : '';

        $propertyCity = isset($orderDetails['property_city']) && !empty($orderDetails['property_city']) ? $orderDetails['property_city'] : '';      
        
        $county = isset($orderDetails['county']) && !empty($orderDetails['county']) ? $orderDetails['county'] : '';

        $request['Properties'][] = array('IsPrimary'=>'true', 'StreetNumber'=>$streetNumber, 'StreetName'=> $streetName, 'City'=> $propertyCity, 'State'=> $propertyState, 'County'=> $county, 'Zip'=>$PropertyZip);

        $loanAmount = isset($orderDetails['loan_amount']) && !empty($orderDetails['loan_amount']) ? $orderDetails['loan_amount'] : '';
        if(isset($loanAmount) && !empty($loanAmount))
        {
            $request['Loans'][]['LoanAmount'] = $loanAmount;
        }

        $salesAmount = isset($orderDetails['sales_amount']) && !empty($orderDetails['sales_amount']) ? $orderDetails['sales_amount'] : '';

        if(isset($salesAmount) && !empty($salesAmount))
        {
            $request['SalesPrice'] = $salesAmount;
            $condition = array(
                'where' => array(
                    'transaction_type' => 'sale',
                    'pct_order_fees.status' => 1
                )
            );
        }
        else
        {
            $condition = array(
                'where' => array(
                    'transaction_type' => 'loan',
                    'pct_order_fees.status' => 1
                )
            );
        }
        $fees_data = json_encode($request);
        $this->load->library('order/resware');


        $endPoint = 'estimates/closingfees';

        $logid = $this->apiLogs->syncLogs('', 'resware', 'mail_get_fees', env('RESWARE_ORDER_API').$endPoint, $fees_data, array(), $orderId, 0);
        $result = $this->resware->make_request('POST', $endPoint, $fees_data,$loginData);
        $this->apiLogs->syncLogs($userdata['id'], 'resware', 'mail_get_fees', env('RESWARE_ORDER_API').$endPoint, $fees_data, $result, $orderId, $logid);

        $product_type = isset($orderDetails['product_type']) && !empty($orderDetails['product_type']) ? $orderDetails['product_type'] : '';
        $data['productType'] = $product_type;

        $fees = array();
        if(isset($result) && !empty($result))
        {
            $response = json_decode($result,TRUE);
            $closing_fee_estimate_id = isset($response['ClosingFeeEstimate']['ClosingFeeEstimateID']) && !empty($response['ClosingFeeEstimate']['ClosingFeeEstimateID']) ? $response['ClosingFeeEstimate']['ClosingFeeEstimateID'] : '';

            if(isset($response['ClosingFeeEstimate']['Premiums']) && !empty(isset($response['ClosingFeeEstimate']['Premiums'])))
            {
                foreach ($response['ClosingFeeEstimate']['Premiums'] as $k => $v) 
                {
                    if($k == 'FullLendersPremium')
                    {
                        $k = 'Stand Alone Title Policy';
                    }
                    $fees['Title Fee'][] = array('amount' => $v, 'description' => $k);
                }
            }
        }
        $feesInfo = $this->fees_model->get_rows($condition);
        if(isset($feesInfo) && !empty(isset($feesInfo)))
        {
            foreach ($feesInfo as $k => $v) 
            {
                // $fees['AdditionalFees'][] = array('amount' => $v['value'], 'description' => $v['name']);

                $fees[$v['fee_type']][] = array('amount' => $v['value'], 'description' => $v['name']);
            }
        }

        if(strpos($product_type, 'Loan:') !== false)
        {
            if(isset($fees['Title Fee']) && !empty($fees['Title Fee']))
            {
                foreach ($fees['Title Fee'] as $key => $value)
                {
                    if($value['description'] == 'Stand Alone Title Policy')
                    {
                        unset($fees['Title Fee'][$key]);
                    }
                }
            }
        }
        $data['fees'] = $fees;
        $data['order_number'] = isset($orderDetails['file_number']) && !empty($orderDetails['file_number']) ? $orderDetails['file_number'] : '';
        $data['full_address'] = isset($orderDetails['full_address']) && !empty($orderDetails['full_address']) ? $orderDetails['full_address'] : '';
        $data['sales_amount'] = isset($orderDetails['sales_amount']) && !empty($orderDetails['sales_amount']) ? $orderDetails['sales_amount'] : '';
        $data['loan_amount'] = isset($orderDetails['loan_amount']) && !empty($orderDetails['loan_amount']) ? $orderDetails['loan_amount'] : '';

        
        $data['closing_fee_estimate_id'] = $closing_fee_estimate_id;
        /* end get fees details from resware */

        
        $this->load->view('layout/head_dashboard',$data);
        $this->load->view('order/mail_fees');
    }

    public function addLenderOnOrder()
    {
        $this->load->model('order/home_model');	
        $file_id = $this->input->post('file_id');
        $LenderId = $this->input->post('LenderId');
        $loan_amount = $this->input->post('loan_amount');
        $loan_number = $this->input->post('loan_number');
        $first_name = $this->input->post('first_name');
        $last_name = $this->input->post('last_name');
        $vesting = $this->input->post('vesting');	
        $new_existing_lender = $this->input->post('new_existing_lender');
        $primary_owner = $this->input->post('primary_owner_name');
		$secondaryOwner = $this->input->post('secondary_owner_name');
        $name = explode(" ",$this->input->post('LenderName'));  
        $editFlag = $this->input->post('editFlag');
        $orderDetails = $this->order->get_order_details($file_id, 1);
        $cplApi = $this->input->post('cpl_api');

        $lender_details = array(
            'first_name'    => $name[0],
            'last_name'  => !empty($name[1]) ? $name[1] : '',
            'state'  => !empty($this->input->post('LenderState')) ? $this->input->post('LenderState') : "",
            'email_address' => !empty($this->input->post('LenderEmailAddress')) ? $this->input->post('LenderEmailAddress') : "",
            'company_name'  => !empty($this->input->post('LenderCompany')) ? $this->input->post('LenderCompany') : "",
            'street_address' => !empty($this->input->post('LenderAddress')) ? $this->input->post('LenderAddress') : "",
            'city'  => !empty($this->input->post('LenderCity')) ? $this->input->post('LenderCity') : "",
            'zip_code'  => !empty($this->input->post('LenderZipcode')) ? $this->input->post('LenderZipcode') : "",
            'assignment_clause'  => !empty($this->input->post('assignment_clause')) ? $this->input->post('assignment_clause') : ""
        ); 

        $orderUser =  $this->home_model->get_user(array('id' => $orderDetails['customer_id']));
        if($new_existing_lender == 'add_lender') {
            $lender_details['partner_id'] = $this->input->post('partner_id');
            $lender_details['is_added_lender_by_cpl_proposed'] = 1;
            $lender_details['is_escrow'] = 0;
            $lender_details['status'] = 0;
            $LenderId = $this->home_model->insert($lender_details, 'customer_basic_details');		
        } else {
            $condition = array(
                'id' => $LenderId
            );
            $this->home_model->update($lender_details, $condition, 'customer_basic_details');
        }
        
        $partners = array();
        $lenderUserDetails = $this->home_model->get_user(array('id' => $LenderId));
        $secondaryEmp[] = array('UserID'=> $lenderUserDetails['resware_user_id']);
        $secondaryPartners = array(
            'SecondaryEmployees'=> $secondaryEmp,
            'PartnerTypeID' => 3,
            'PartnerID' => $lenderUserDetails['partner_id'],
            'PartnerType' => array(
                'PartnerTypeID' => 3
            )
        );
        $endPoint = 'files/'.$file_id.'/partners';
        $partnerUserData = array(
            'admin_api' => 1
        );	  
            
        if(!empty($lenderUserDetails['resware_user_id'])) {
            if ($orderUser['is_escrow'] == 1) {
                if(empty($orderDetails['escrow_lender_id'])) {
                    $partners[] = $secondaryPartners;
                } else if (!empty($orderDetails['escrow_lender_id']) && $orderDetails['escrow_lender_id'] != $LenderId) {
                    $partners[] = $secondaryPartners;
                    $removeLenderUserDetails = $this->home_model->get_user(array('id' => $orderDetails['escrow_lender_id']));
                    $removeSecondaryEmp[] = array('UserID'=> $removeLenderUserDetails['resware_user_id']);
                    $removeSecondaryPartners = array(
                        'SecondaryEmployees'=> $removeSecondaryEmp,
                        'PartnerTypeID' => 3,
                        'PartnerID' => $removeLenderUserDetails['partner_id'],
                        'PartnerType' => array(
                            'PartnerTypeID' => 3
                        )
                    );
                    $removePartners[] = $removeSecondaryPartners;
                    $removePartnerData = json_encode(array('Partners' => $removePartners));
                    $removeLogid = $this->apiLogs->syncLogs(0, 'resware', 'delete_partner', env('RESWARE_ORDER_API').$endPoint, $removePartnerData, array(), 0, 0);
                    $resultRemovePartner = $this->resware->make_request('DELETE', $endPoint, $removePartnerData, $partnerUserData);
                    $this->apiLogs->syncLogs(0, 'resware', 'delete_partner', env('RESWARE_ORDER_API').$endPoint, $removePartnerData, $resultRemovePartner, 0, $removeLogid);
                }
            } else {
                if(empty($orderDetails['cpl_lender_id'])) {
                    $partners[] = $secondaryPartners;
                } else if (!empty($orderDetails['cpl_lender_id']) && $orderDetails['cpl_lender_id'] != $LenderId) {
                    $partners[] = $secondaryPartners;
                    $removeLenderUserDetails = $this->home_model->get_user(array('id' => $orderDetails['cpl_lender_id']));
                    $removeSecondaryEmp[] = array('UserID'=> $removeLenderUserDetails['resware_user_id']);
                    $removeSecondaryPartners = array(
                        'SecondaryEmployees'=> $removeSecondaryEmp,
                        'PartnerTypeID' => 3,
                        'PartnerID' => $removeLenderUserDetails['partner_id'],
                        'PartnerType' => array(
                            'PartnerTypeID' => 3
                        )
                    );
                    $removePartners[] = $removeSecondaryPartners;
                    $removePartnerData = json_encode(array('Partners' => $removePartners));
                    $removeLogid = $this->apiLogs->syncLogs(0, 'resware', 'delete_partner', env('RESWARE_ORDER_API').$endPoint, $removePartnerData, array(), 0, 0);
                    $resultRemovePartner = $this->resware->make_request('DELETE', $endPoint, $removePartnerData, $partnerUserData);
                    $this->apiLogs->syncLogs(0, 'resware', 'delete_partner', env('RESWARE_ORDER_API').$endPoint, $removePartnerData, $resultRemovePartner, 0, $removeLogid);
                }
            }

            if(!empty($partners)) {
                $partnerData = json_encode(array('Partners' => $partners));
                $logid = $this->apiLogs->syncLogs(0, 'resware', 'add_partner', env('RESWARE_ORDER_API').$endPoint, $partnerData, array(), 0, 0);
                $resultPartner = $this->resware->make_request('POST', $endPoint, $partnerData, $partnerUserData);
                $this->apiLogs->syncLogs(0, 'resware', 'add_partner', env('RESWARE_ORDER_API').$endPoint, $partnerData, $resultPartner, 0, $logid);
            }	  
        }

        if ($orderDetails['sales_amount'] > 0) { 
            if ($orderUser['is_escrow'] == 1) {
                $propertyDetails = array('escrow_lender_id' => $LenderId);
            } else {
                $propertyDetails = array('cpl_lender_id' => $LenderId);
            }
            
            $this->home_model->update(array('loan_amount' => $loan_amount, 'loan_number' => $loan_number, 'borrower' => $primary_owner, 'secondary_borrower' => $secondaryOwner, 'vesting' => $vesting), array('id' => $orderDetails['transaction_id']), 'transaction_details');
            if ($cplApi == 'fnf' || $cplApi == 'westcor') {
                $this->home_model->update(array('fnf_agent_id' => $this->input->post('branch')), array('id' => $orderDetails['order_id']), 'order_details');
            }
            $this->home_model->update($propertyDetails, array('id' => $orderDetails['property_id']), 'property_details');
        } else {
            if ($orderUser['is_escrow'] == 1) {
                $propertyDetails = array('escrow_lender_id' => $LenderId, 'primary_owner' => $primary_owner, 'secondary_owner' => $secondaryOwner);
            } else {
                $propertyDetails = array('cpl_lender_id' => $LenderId, 'primary_owner' => $primary_owner, 'secondary_owner' => $secondaryOwner);
            }
            $this->home_model->update(array('loan_number' => $loan_number, 'vesting' => $vesting), array('id' => $orderDetails['transaction_id']), 'transaction_details');
            
            if ($cplApi == 'fnf' || $cplApi == 'westcor') {
                $this->home_model->update(array('fnf_agent_id' => $this->input->post('branch')), array('id' => $orderDetails['order_id']), 'order_details');
            }
            $this->home_model->update($propertyDetails, array('id' => $orderDetails['property_id']), 'property_details');
        }

        $this->home_model->update(array('is_regenerate_cpl' => $editFlag), array('id' => $orderDetails['order_id']), 'order_details');
        if ($cplApi == 'fnf') {
            redirect(base_url()."create-cpl-for-fnf-mail/".$file_id);
        } else if ($cplApi == 'westcor') {
            redirect(base_url()."create-cpl-mail/".$file_id);
        } else {
            redirect(base_url()."create-cpl-for-natic-mail/".$file_id);
        }
    }
    
    public function createCPlForFnf()
    {
        $this->load->library('order/fnf');
        $this->load->model('order/home_model');
        $this->load->model('order/document');
        $errors = array();
        $success = array();
        $fileId = $this->uri->segment(2);    
        $orderDetails = $this->order->get_order_details($fileId, 1);
        $vendorTokenData = $this->fnf->get_vendor_token();

        if ($vendorTokenData === false) {
            $vendorTokenData = $this->fnf->generateVendorToken($orderDetails);
        }

        $userTokenData = $this->fnf->get_user_token();

        if ($userTokenData === false) {
            $userTokenData = $this->fnf->generateUserToken($orderDetails);
        }

        if (!empty($orderDetails['fnf_document_id'])) {
            $editCplResponse = $this->fnf->editCpl($orderDetails, $vendorTokenData, $userTokenData);
            if ($editCplResponse['success']) {
                $cplCount = $this->document->countCplDocument($orderDetails['order_id']);
                $document_name = "fnf_".$cplCount."_".$fileId.".pdf";
                if (!is_dir('uploads/documents')) {
                    mkdir('./uploads/documents', 0777, TRUE);
                }
                file_put_contents('./uploads/documents/'.$document_name, base64_decode($editCplResponse['response']['a:Content']));
                $this->home_model->update(array('cpl_document_name' => $document_name, 'fnf_document_id' => $generateCplResponse['response']['a:DocumentId']), array('file_id' => $fileId), 'order_details');
                $success[] = "CPL document edited successfully for file number - ".$orderDetails['file_number'];
                $this->uploadCPLDocumentToResware($document_name, $orderDetails, $generateCplResponse['response']['a:Content']);
            } else {
                $errors[] = $editCplResponse['error'];
            }
            $data = array(
                "errors" =>  $errors,
                "success" => $success
            );
            $this->session->set_userdata($data);
            redirect(base_url().'generate-cpl/'.$orderDetails['random_number']);
        }

        $getCPLFormNameResponse = $this->fnf->getCPLForm($orderDetails, $vendorTokenData, $userTokenData);
        if ($getCPLFormNameResponse['success'])  {
            $key = array_search('Lender', array_column($getCPLFormNameResponse['response'], 'a:RecipientType'));
            $orderDetails['formname'] = $getCPLFormNameResponse['response'][$key]['a:FormName'];
            $generateCplResponse = $this->fnf->generateCpl($orderDetails, $vendorTokenData, $userTokenData);
            
            if ($generateCplResponse['success']) {
                $cplCount = $this->document->countCplDocument($orderDetails['order_id']);
                $document_name = "fnf_".$cplCount."_".$fileId.".pdf";
                if (!is_dir('uploads/documents')) {
                    mkdir('./uploads/documents', 0777, TRUE);
                }
                file_put_contents('./uploads/documents/'.$document_name, base64_decode($generateCplResponse['response']['a:Content']));
                $this->home_model->update(array('cpl_document_name' => $document_name, 'fnf_document_id' => $generateCplResponse['response']['a:DocumentId']), array('file_id' => $fileId), 'order_details');
                $success[] = "Generated CPL request successfully for file number - ".$orderDetails['file_number'];
                $this->uploadCPLDocumentToResware($document_name, $orderDetails, $generateCplResponse['response']['a:Content']);
            } else {
                $errors[] = $generateCplResponse['error'];
            }
            $data = array(
                "errors" =>  $errors,
                "success" => $success
            );
			$this->session->set_userdata($data);
			redirect(base_url().'generate-cpl/'.$orderDetails['random_number']);
        } else {
            $errors[] = $getCPLFormNameResponse['error'];
            $data = array(
                "errors" =>  $errors,
                "success" => $success
            );
            $this->session->set_userdata($data);
            redirect(base_url().'generate-cpl/'.$orderDetails['random_number']);
        }   
    }
    
    public function create_cpl()
    {
        $this->load->model('order/apiLogs');
        $this->load->library('order/westcor');
        $this->load->model('order/home_model');
        $this->load->model('order/document');  

        $fileId = $this->uri->segment(2);    
        $errors = array();
        $success = array();
        $orderDetails = $this->order->get_order_details($fileId, 1);
        $res = array();

        $resToken = $this->westcor->get_token($orderDetails['fnf_agent_id'], $orderDetails['order_id']);
        $orderUser =  $this->home_model->get_user(array('id' => $orderDetails['customer_id']));

        $propertyDetail = explode(",", $orderDetails['full_address']);
        $propery[] = array (
            'PropertyID' => 0,
            'tvid' =>  0,
            'CountyName' => $orderDetails['county'].' County',
            'ShortLegal' => $orderDetails['legal_description'] ? $orderDetails['legal_description'] : null,
            'StreetAddress' => $orderDetails['address'] ? $orderDetails['address'] : trim($propertyDetail[0])." ".trim($propertyDetail[1]),
            'City' => $orderDetails['property_city'] ? $orderDetails['property_city'] : trim($propertyDetail[2]),
            'State' => $orderDetails['property_state'] ? $orderDetails['property_state'] : trim($propertyDetail[3]),
            'Zip' => $orderDetails['property_zip'] ? $orderDetails['property_zip'] : trim($propertyDetail[4]),
            'PropertyType' => 'R'
        );

        $primary_owner = explode(" ", $orderDetails['primary_owner']);
        $secondary_owner = explode(" ", $orderDetails['secondary_owner']);
        if ($orderDetails['sales_amount'] > 0)  {	

            $sellerBorrowerName = $orderDetails['primary_owner'];

			if(!empty($orderDetails['secondary_owner'])) { 
				$sellerBorrowerName .= " and ".$orderDetails['secondary_owner'];
			}

			if(!empty($orderDetails['vesting'])) { 
				$sellerBorrowerName .= ' '.$orderDetails['vesting'];
			}
			 
			$sellers[] = array (
				'NameID' =>  $orderDetails['westcor_seller_id'] ? $orderDetails['westcor_seller_id'] : 0,
				'Last' => '-',
				'First' => $sellerBorrowerName,
				'NameType' => 2,
				'JoiningPhrase' => 'single',
				'tvid' => 0,
				'Sequence' => 1,
				'City' => null,
				'State' => null,
				'Zip' => null,
				'Address' => null,
			);   

            $purchase_price = $orderDetails['sales_amount'];
            $buyers = array();

            if (!empty($orderDetails['borrower'])) {
				
				$buyerBorrowerName = $orderDetails['borrower'];

				if(!empty($orderDetails['secondary_borrower'])) { 
					$buyerBorrowerName .= " and ".$orderDetails['secondary_borrower'];
				}
	
				$buyers[] = array (
					'NameID' => $orderDetails['westcor_secondary_buyer_id'] ? $orderDetails['westcor_secondary_buyer_id'] : 0,
					'Last' => '-',
					'First' => $buyerBorrowerName,
					'NameType' => 1,
					'JoiningPhrase' => 'single',
					'tvid' => 0,
					'Sequence' => 1,
					'City' => null,
					'State' => null,
					'Zip' => null,
					'Address' => null
				);	
			} 	

        } else {
            $buyers = array();
			$buyerBorrowerName = $orderDetails['primary_owner'];

			if(!empty($orderDetails['secondary_owner'])) { 
				$buyerBorrowerName .= " and ".$orderDetails['secondary_owner'];
			}

			if(!empty($orderDetails['vesting'])) { 
				$buyerBorrowerName .= ' '.$orderDetails['vesting'];
			}
			$buyers[] = array (
				'NameID' => $orderDetails['westcor_buyer_id'] ? $orderDetails['westcor_buyer_id'] : 0,
				'Last' => '-',
				'First' => $buyerBorrowerName,
				'NameType' => 1,
				'JoiningPhrase' => 'single',
				'tvid' => 0,
				'Sequence' => 1,
				'City' => null,
				'State' => null,
				'Zip' => null,
				'Address' => null
			);
			$purchase_price = $orderDetails['loan_amount'];
			$sellers = array();
        }	 

        if ($orderUser['is_escrow'] == 1) {
			$name = $orderDetails['lender_first_name']." ".$orderDetails['lender_last_name'];
			if (!empty($orderDetails['escrow_lender_id'])) {
				$lenders[] =  array (
					'Id' =>  $orderDetails['westcor_lender_id'] ? $orderDetails['westcor_lender_id'] : 0,
					'tvid' => 0,
					'name' => $orderDetails['lender_company_name'],
					'city' => $orderDetails['lender_city'],
					'state' => 'CA',
					'zip' => $orderDetails['lender_zipcode'],
					'address' => $orderDetails['lender_address'],
					'phone' => $orderDetails['lender_telephone_no'],
					'email' => $orderDetails['lender_email'],
					'countyFIPS' => null,
					'assignment' => $orderDetails['lender_assignment_clause'] ? $orderDetails['lender_assignment_clause']."\n".$name : "\n".$name,
					'mortgageType' => null,
					'amount' => 0,
					'loan_number' => $orderDetails['loan_number'] ? $orderDetails['loan_number'] : '',
					'vendorInternalID' => $orderDetails['escrow_lender_id']
				);
			} 
		} else {
			$lenderDetails = $this->home_model->get_user(array('id' => $orderDetails['cpl_lender_id']));
			$name = $lenderDetails['first_name']." ".$lenderDetails['last_name'];
			if (!empty($lenderDetails)) {
				$lenders[] =  array (
					'Id' =>  $orderDetails['westcor_lender_id'] ? $orderDetails['westcor_lender_id'] : 0,
					'tvid' => 0,
					'name' => $lenderDetails['company_name'],
					'city' => $lenderDetails['city'],
					'state' => 'CA',
					'zip' => $lenderDetails['zip_code'],
					'address' => $lenderDetails['street_address'],
					'phone' => $lenderDetails['telephone_no'],
					'email' => $lenderDetails['email_address'],
					'countyFIPS' => null,
					'assignment' => $lenderDetails['assignment_clause'] ? $lenderDetails['assignment_clause']."\n".$name : "\n".$name,
					'mortgageType' => null,
					'amount' => 0,
					'loan_number' => $orderDetails['loan_number'] ? $orderDetails['loan_number'] : '',
					'vendorInternalID' => $lenderDetails['id']
				);
			} 
		}
        
        $cplPostData = array (
            'tvid' =>  0,
            'agentnumber' => $resToken['original_agent_number'],
            'agent_file_number' => $orderDetails['file_number'],
            'email_requestor' => isset($orderUser['email_address']) ? $orderUser['email_address'] : 'cpl@pct.com',
            'purchase_price' => $purchase_price,
            'property' =>  $propery,
            'buyers' => $buyers,
            'sellers' => $sellers,
            'lenders' => $lenders,
            'search' => null,
            'commitment' => null,
            'jacket' => null,
            'sdn' => null,
            'history' => null,
            'notes' => !empty($orderDetails['addtional_details']) ? $orderDetails['addtional_details'] : null,
            'messages' => array(
                'success' => [],
                'warning' => [],
                'error' => []
            ),
            'actions' =>  array (
                'sdn' => false,
                'update_base' => true,
                'update_property' => true,
                'update_lender' => true,
                'update_buyers' => true,
                'update_sellers' => true,
                'update_attorneys' => false,
                'update_cpls' => false,
                'update_jacket' => false,
                'update_search' => false,
                'update_reinsurance' => false,
                'update_priors' => false,
            ),
            'partnerCode' => (int)getenv('WESTCORE_INTEGRATION_PARTNER'),
            'cpl' => null,
            'priors' => null
        );

        if(empty($orderDetails['westcor_order_id'])) {
            $endPointCreateOrder = 'VendorApi/Order/Update/'.getenv('WESTCORE_INTEGRATION_PARTNER');
            $cplPostData = json_encode($cplPostData);
            $res = array();
            $logid = $this->apiLogs->syncLogs(0, 'westcor', 'create_cpl_order', getenv('WESTCORE_URL').$endPointCreateOrder, $cplPostData, array(), $orderDetails['order_id'], 0);
            $result = $this->westcor->make_request('POST', $endPointCreateOrder, $cplPostData, 0, $resToken['token']);
            $this->apiLogs->syncLogs(0, 'westcor', 'create_cpl_order', getenv('WESTCORE_URL').$endPointCreateOrder, $cplPostData, $result, $orderDetails['order_id'], $logid);
            $res = json_decode($result, true);
            if(is_array($res)) {
                if ($res['Message']) {
                    $errors[] = $res['Message'];
                    $data = array(
                        "errors" =>  $errors,
                        "success" => $success
                    );
					$this->session->set_userdata($data);
					redirect(base_url().'generate-cpl/'.$orderDetails['random_number']);
                }
                $order_details = array(
                    'westcor_order_id'  => $res['tvid'],
                    'westcor_buyer_id'  => !empty($res['buyers']) ? $res['buyers'][0]['NameID'] : 0,
                    'westcor_seller_id'  => !empty($res['sellers']) ? $res['sellers'][0]['NameID'] : 0,
                    'westcor_secondary_buyer_id'  => !empty($res['buyers']) ? $res['buyers'][1]['NameID'] : 0,
                    'westcor_secondary_seller_id'  => !empty($res['sellers']) ? $res['sellers'][1]['NameID'] : 0,
                    'westcor_lender_id' => !empty($res['lenders']) ? $res['lenders'][0]['Id']: 0,
                );
                $condition = array(
                    'id' => $orderDetails['order_id']
                );
                if(!empty($buyers)) {
                    $buyers[0]['NameID'] = !empty($res['buyers']) ? $res['buyers'][0]['NameID'] : 0;
                    
                }

                if(!empty($sellers)) {
                    $sellers[0]['NameID'] = !empty($res['sellers']) ? $res['sellers'][0]['NameID'] : 0;
                    
                }

                $lenders[0]['Id'] = !empty($res['lenders']) ? $res['lenders'][0]['Id']: 0;
                
                $this->home_model->update($order_details, $condition, 'order_details');
                $this->home_model->update(array('westcor_property_id' => !empty($res['property']) ? $res['property'][0]['PropertyID'] : 0), array('id' => $orderDetails['property_id']), 'property_details');
                $orderDetails['westcor_order_id'] = $res['tvid'];
                $orderDetails['westcor_buyer_id']  = !empty($res['buyers']) ? $res['buyers'][0]['NameID'] : 0;
                $orderDetails['westcor_seller_id']  = !empty($res['sellers']) ? $res['sellers'][0]['NameID'] : 0;
                $orderDetails['westcor_secondary_buyer_id']  = !empty($res['buyers']) ? $res['buyers'][1]['NameID'] : 0;
                $orderDetails['westcor_secondary_seller_id']  = !empty($res['sellers']) ? $res['sellers'][1]['NameID'] : 0;
                $orderDetails['westcor_lender_id'] = !empty($res['lenders']) ? $res['lenders'][0]['Id']: 0;

            } else {
                $errors[] = $result;
                $data = array(
                    "errors" =>  $errors,
                    "success" => $success
                );
                $this->session->set_userdata($data);
                redirect(base_url().'generate-cpl/'.$orderDetails['random_number']);
            }
        }
        
        if(!empty($orderDetails['westcor_order_id'])) {
            $res = array();
            $endPointGetOrdeData = 'VendorApi/Order/'.$orderDetails['westcor_order_id'].'/'.getenv('WESTCORE_INTEGRATION_PARTNER');
            $logid = $this->apiLogs->syncLogs(0, 'westcor', 'get_order_data', getenv('WESTCORE_URL').$endPointGetOrdeData, array(), array(), $orderDetails['order_id'], 0);
            $resultForGetOrderData = $this->westcor->make_request('GET', $endPointGetOrdeData, array(), 0, $resToken['token']);
            $this->apiLogs->syncLogs(0, 'westcor', 'get_order_data', getenv('WESTCORE_URL').$endPointGetOrdeData, array(), $resultForGetOrderData, $orderDetails['order_id'], $logid);    
            $res = json_decode($resultForGetOrderData, true);
            $res['cpl'] = array();
            

            $resCPL = array();
            $endPointForCPL = 'VendorApi/ClosingLetters/PrepareAddCPL/'.$orderDetails['westcor_order_id'].'/'.getenv('WESTCORE_INTEGRATION_PARTNER');
            $logid = $this->apiLogs->syncLogs(0, 'westcor', 'get_cpl_data', getenv('WESTCORE_URL').$endPointForCPL, array(), array(), $orderDetails['order_id'], 0);
            $cplData = $this->westcor->make_request('GET', $endPointForCPL, array(), 0, $resToken['token']);
            $this->apiLogs->syncLogs(0, 'westcor', 'get_cpl_data', getenv('WESTCORE_URL').$endPointForCPL, array(), $cplData, $orderDetails['order_id'], $logid); 
            $resCPL = json_decode($cplData, true);
            
            $resCPL['CPL']['LetterName'] = $resCPL['CPL']['Forms'][1]['FormName'];
            $resCPL['CPL']['FileInformation'] = null;
            $resCPL['CPL']['CPLID'] = -1;
            $resCPL['CPL']['LenderID'] = $orderDetails['westcor_lender_id'];
            $resCPL['CPL']['PolicyProducingAgentAddressID'] = $resToken['agent_number'];
            $resCPL['CPL']['PolicyProducingAgentAddress'] = $resToken['address'];
            $resCPL['CPL']['PolicyProducingAgentCity'] = $resToken['city'];
            $resCPL['CPL']['PolicyProducingAgentState'] = $resToken['state'];
            $resCPL['CPL']['PolicyProducingAgentZip'] = $resToken['zip'];
            $resCPL['CPL']['ProtectLender'] = true;
            
                        
            $res['cpl'][] = $resCPL['CPL'];
            $res['lenders'] = $lenders;
            $res['buyers'] = $buyers;
            $res['sellers'] = $sellers;
            $res['actions']['update_cpls'] = true;
            $res['actions']['update_buyers'] = true;
            $res['actions']['update_sellers'] = true;
            $res['actions']['update_lender'] = true;
            $res['purchase_price']= $purchase_price;
            
            $generateCplPostData = json_encode($res);
            $endPointCreateCPL = 'VendorApi/Order/Update/'.getenv('WESTCORE_INTEGRATION_PARTNER');
            $resultResCPL = array();
            $logid = $this->apiLogs->syncLogs(0, 'westcor', 'generate_cpl', getenv('WESTCORE_URL').$endPointCreateCPL, $generateCplPostData, array(), $orderDetails['order_id'], 0);
            $resultCPL = $this->westcor->make_request('POST', $endPointCreateCPL, $generateCplPostData, 0, $resToken['token']);
            $this->apiLogs->syncLogs(0, 'westcor', 'generate_cpl', getenv('WESTCORE_URL').$endPointCreateCPL, $generateCplPostData, $resultCPL, $orderDetails['order_id'], $logid);
            $resultResCPL = json_decode($resultCPL, true);

            if (is_array($resultResCPL)) {
                if ($resultResCPL['Message']) {
                    $errors[] = $res['Message'];
                    $data = array(
                        "errors" =>  $errors,
                        "success" => $success
                    );
                    $this->session->set_userdata($data);
                    redirect(base_url().'generate-cpl/'.$orderDetails['random_number']);
                }

                $cplCount = count($resultResCPL['cpl']) - 1;

                $order_details = array(
                    'westcor_cpl_id'    => $resultResCPL['cpl'][$cplCount]['CPLID'],
                    'westcor_file_id'   => $resultResCPL['cpl'][$cplCount]['FileInformation']['FileAsDataVaultFileID'],
                    'westcor_buyer_id'  => !empty($resultResCPL['buyers']) ? $resultResCPL['buyers'][0]['NameID'] : 0,
                    'westcor_seller_id'  => !empty($resultResCPL['sellers']) ? $resultResCPL['sellers'][0]['NameID'] : 0,
                    'westcor_secondary_buyer_id'  => !empty($resultResCPL['buyers']) ? $resultResCPL['buyers'][1]['NameID'] : 0,
                    'westcor_secondary_seller_id'  => !empty($resultResCPL['sellers']) ? $resultResCPL['sellers'][1]['NameID'] : 0
                );

                if(!empty($resultResCPL['cpl'][$cplCount]['FileInformation']['FileAsBase64'])) {
                    $cplDocumentCount = $this->document->countCplDocument($orderDetails['order_id']);
                    $document_name = "westcor_".$cplDocumentCount."_".$fileId.".pdf";
                    if (!is_dir('uploads/documents')) {
                        mkdir('./uploads/documents', 0777, TRUE);
                    }
                    file_put_contents('./uploads/documents/'.$document_name, base64_decode($resultResCPL['cpl'][$cplCount]['FileInformation']['FileAsBase64']));
                    $this->home_model->update(array('cpl_document_name' => $document_name), array('file_id' => $fileId), 'order_details');
                }
                
                 
                $condition = array(
                    'id' => $orderDetails['order_id']
                );
    
                $this->home_model->update($order_details, $condition, 'order_details');
                $this->uploadCPLDocumentToResware($document_name, $orderDetails, $resultResCPL['cpl'][$cplCount]['FileInformation']['FileAsBase64']);
                $success[] = "Generated CPL request successfully for file number - ".$orderDetails['file_number'];
            } else {
                $errors[] = $resultCPL;
            }
        
            $data = array(
                "errors" =>  $errors,
                "success" => $success
            );
            $this->session->set_userdata($data);
            redirect(base_url().'generate-cpl/'.$orderDetails['random_number']);
        }
    }
    
    public function createCPlForNatic()
    {
        $this->load->library('order/natic');
        $this->load->model('order/home_model');
        $this->load->model('order/document');
        $errors = array();
        $success = array();
        $fileId = $this->uri->segment(2);    
        $orderDetails = $this->order->get_order_details($fileId, 1);
        $responseArr = $this->natic->getDocumentContentForCpl($fileId, $orderDetails);
        if ($responseArr['success']) {
            $cplCount = $this->document->countCplDocument($orderDetails['order_id']);
            $document_name = "natic_".$cplCount."_".$fileId.".pdf";
            if (!is_dir('uploads/documents')) {
                mkdir('./uploads/documents', 0777, TRUE);
            }
            file_put_contents('./uploads/documents/'.$document_name, base64_decode($responseArr['content']));
            $this->home_model->update(array('cpl_document_name' => $document_name), array('file_id' => $fileId), 'order_details');
            $success[] = "Generated CPL request successfully for file number - ".$orderDetails['file_number'];
            $this->uploadCPLDocumentToResware($document_name, $orderDetails, $responseArr['content']);
        } else {
            $errors[] = $responseArr['error'];
        }
        $data = array(
            "errors" =>  $errors,
            "success" => $success
        );
        $this->session->set_userdata($data);
        redirect(base_url().'generate-cpl/'.$orderDetails['random_number']);
    }
    
    public function uploadCPLDocumentToResware($document_name, $orderDetails, $binaryData)
	{
		$this->load->model('order/document');
		$this->load->library('order/resware');
		$this->load->model('order/apiLogs');
		$fileSize = filesize('./uploads/documents/'.$document_name);
		$documentData = array(
			'document_name' => $document_name,
			'original_document_name' => $document_name,
			'document_type_id' => 1051,
			'document_size' => $fileSize,
			'user_id' => 0,
			'order_id' => $orderDetails['order_id'],
			'description' => 'CPL Document',
			'is_sync' => 1,
			'is_prelim_document' => 0,
			'is_cpl_doc' => 1
		);
		$documentId = $this->document->insert($documentData);
		$endPoint = 'files/'.$orderDetails['file_id'].'/documents';
		$documentApiData = array(			
			'DocumentName' => $document_name,
			'DocumentType' => array(
				'DocumentTypeID' => 1051,
			),
			'Description' => 'CPL Document',
			'InternalOnly' => false,
			'DocumentBody' => $binaryData
		);
		$document_api_data = json_encode($documentApiData, JSON_UNESCAPED_SLASHES);

		
		$orderUser =  $this->home_model->get_user(array('id' => $orderDetails['customer_id']));
		$user_data['email'] = $orderUser['email_address'];
		$user_data['password'] = $orderUser['random_password'];
		$user_data['from_mail'] = 1;
		
		$logid = $this->apiLogs->syncLogs(0, 'resware', 'create_document', env('RESWARE_ORDER_API').$endPoint, $documentApiData, array(), $orderDetails['order_id'], 0);
		$result = $this->resware->make_request('POST', $endPoint, $document_api_data, $user_data);
		$this->apiLogs->syncLogs(0, 'resware', 'create_document', env('RESWARE_ORDER_API').$endPoint, $documentApiData, $result, $orderDetails['order_id'], $logid);
		$res = json_decode($result);
		$this->document->update(array('api_document_id' => $res->Document->DocumentID), array('id' => $documentId));

		/*$from_name = 'Pacific Coast Title Company';
		$from_mail = env('FROM_EMAIL');
		$order_message_body = 'Please check attachment for CPL document.';
		$message = $order_message_body; 
		$subject = 'CPL Document';
		$to = $orderDetails['lender_email'];
		$cc = array();
		if (!empty($orderDetails['sales_representative'])) {
			$this->db->select('*')
            	->from('pct_order_sales_rep');
			$this->db->where('id', $orderDetails['sales_representative']);
			$query = $this->db->get();
			$salesResult = $query->row_array();
			if (!empty($salesResult)) {
				$cc = array($salesResult['email_address']);
			}
		}
		$bcc = array();
		$file = array(base_url().'uploads/documents/'.$document_name);
		$this->load->helper('sendemail');
		$mail_result = send_email($from_mail,$from_name, $to, $subject, $message,$file,$cc,$bcc);*/
	}

	public function proposedInsured()
    {
        $data['errors'] = array();
		$data['success'] = array();

		if ($this->session->userdata('errors')) {
			$data['errors'] = $this->session->userdata('errors');
			$this->session->unset_userdata('errors');
		}

		if ($this->session->userdata('success')) {
			$data['success'] = $this->session->userdata('success');
			$this->session->unset_userdata('success');
        }
        $random_number = $this->uri->segment(2); 
        $order = $this->getOrderInfo($random_number);
        $fileId = $order[0]['file_id']; 
        $data['title'] = 'Smart Dashboard | Pacific Coast Title Company';
		$data['mail_dashboard'] = 1;
		$orderDetails = $this->order->get_order_details($fileId,1);
        $data['file_number'] = $orderDetails['file_number'];
        $data['full_address'] = $orderDetails['full_address'];
		

        if (!empty($orderDetails['proposed_insured_document_name'])) 
        {
            $file_id = $orderDetails['file_id'];
            $documentName = $orderDetails['proposed_insured_document_name'];
            

            $action = '<a href="'.base_url().'/uploads/proposed-insured/'.$documentName.'" download><button class="btn btn-grad-2a" type="button" style="background: #d35411;">Download</button></a>';
        }
        else
        {
            $action = '<a href="javascript:void(0);" onclick="generateProposedInsured('.$orderDetails['file_id'].');"><button class="btn btn-grad-2a button-color" type="button">Generate</button></a>';
        }

		$action .= '<a href="javascript:void(0);" onclick="editInformation('.$orderDetails['file_id'].');"><button class="btn btn-grad-2a button-color" type="button">Edit</button></a>';

        $data['action'] = $action;
        $condition = array(
            'where' => array(
                'status' => 1
            )
        );
        
        $data['titleOfficer'] = $this->titleOfficer->getTitleOfficerDetails($condition);

        $this->load->view('layout/head_dashboard',$data);
        $this->load->view('order/mail_proposed_insured', $data);
	}
	
	public function getOrderDetailsCpl()
	{
		$this->load->library('order/fnf');
		$this->load->model('order/home_model');
		$this->load->library('order/resware');
		$fileId = $this->input->post('fileId');	 

		$orderDetails = $this->order->get_order_details($fileId, 1);
		$orderUser =  $this->home_model->get_user(array('id' => $orderDetails['customer_id']));
			
		if ($orderUser['is_escrow'] == 1) {
			if ($orderDetails['is_escrow'] == 1) {
				$orderDetails['lender_first_name'] =  '';
				$orderDetails['lender_last_name'] ='';
				$orderDetails['lender_email'] = '';
				$orderDetails['lender_state'] = '';
				$orderDetails['lender_company_name'] = '';
				$orderDetails['lender_address'] = '';
				$orderDetails['lender_city'] = '';
				$orderDetails['lender_zipcode'] = '';
                $orderDetails['lender_id'] = '';
                $orderDetails['lender_assignment_clause'] = '';
			} else {			
				$orderDetails['lender_first_name'] = $orderDetails['lender_first_name'] ? $orderDetails['lender_first_name'] : '';
				$orderDetails['lender_last_name'] = $orderDetails['lender_last_name'] ? $orderDetails['lender_last_name'] : '';
				$orderDetails['lender_email'] = $orderDetails['lender_email'] ? $orderDetails['lender_email'] : '';
				$orderDetails['lender_state'] = $orderDetails['lender_state'] ? $orderDetails['lender_state'] : '';
				$orderDetails['lender_company_name'] = $orderDetails['lender_company_name'] ? $orderDetails['lender_company_name'] : '';
				$orderDetails['lender_address'] = $orderDetails['lender_address'] ? $orderDetails['lender_address'] : '';
				$orderDetails['lender_city'] = $orderDetails['lender_city'] ? $orderDetails['lender_city'] : '';
                $orderDetails['lender_zipcode'] = $orderDetails['lender_zipcode'] ? $orderDetails['lender_zipcode'] : '';
                $orderDetails['lender_assignment_clause'] = $orderDetails['lender_assignment_clause'] ? $orderDetails['lender_assignment_clause'] : '';
				$orderDetails['lender_id'] = $orderDetails['lender_id'] ? $orderDetails['lender_id'] : '';
			}
		} else {
			if (!empty($orderDetails['cpl_lender_id'])) {
				$lenderDetails =  $this->home_model->get_user(array('id' => $orderDetails['cpl_lender_id']));
				$orderDetails['lender_first_name'] = $lenderDetails['first_name'] ? $lenderDetails['first_name'] : '';
				$orderDetails['lender_last_name'] = $lenderDetails['last_name'] ? $lenderDetails['last_name'] : '';
				$orderDetails['lender_email'] = $lenderDetails['email_address'] ? $lenderDetails['email_address'] : '';
				$orderDetails['lender_state'] = $lenderDetails['state'] ? $lenderDetails['state'] : '';
				$orderDetails['lender_company_name'] = $lenderDetails['company_name'] ? $lenderDetails['company_name'] : '';
				$orderDetails['lender_address'] = $lenderDetails['street_address'] ? $lenderDetails['street_address'] : '';
				$orderDetails['lender_city'] = $lenderDetails['city'] ? $lenderDetails['city'] : '';
                $orderDetails['lender_zipcode'] = $lenderDetails['zip_code'] ? $lenderDetails['zip_code'] : '';
                $orderDetails['lender_assignment_clause'] = $lenderDetails['assignment_clause'] ? $lenderDetails['assignment_clause'] : '';
				$orderDetails['lender_id'] = $lenderDetails['id'] ? $lenderDetails['id'] : '';
			} else {
				$orderDetails['lender_first_name'] = $orderUser['first_name'] ? $orderUser['first_name'] : '';
				$orderDetails['lender_last_name'] = $orderUser['last_name'] ? $orderUser['last_name'] : '';
				$orderDetails['lender_email'] = $orderUser['email_address'] ? $orderUser['email_address'] : '';
				$orderDetails['lender_state'] = $orderUser['state'] ? $orderUser['state'] : '';
				$orderDetails['lender_company_name'] = $orderUser['company_name'] ? $orderUser['company_name'] : '';
				$orderDetails['lender_address'] = $orderUser['street_address'] ? $orderUser['street_address'] : '';
				$orderDetails['lender_city'] = $orderUser['city'] ? $orderUser['city'] : '';
				$orderDetails['lender_zipcode'] = $orderUser['zip_code'] ? $orderUser['zip_code'] : '';
				$orderDetails['lender_assignment_clause'] = $orderUser['assignment_clause'] ? $orderUser['assignment_clause'] : '';
				$orderDetails['lender_id'] = $orderUser['id'] ? $orderUser['id'] : '';
			}
			$orderUser =  $this->home_model->get_user(array('id' => $orderDetails['customer_id']));
		}

		if(empty($orderDetails['lender_first_name']) && empty($orderDetails['lender_last_name'])) {
			$orderDetails['lender_name'] = '';
		} else if(empty($orderDetails['lender_first_name']) && !empty($orderDetails['lender_last_name'])) {
			$orderDetails['lender_name'] = $orderDetails['lender_last_name'];
		} else if(!empty($orderDetails['lender_first_name']) && empty($orderDetails['lender_last_name'])) {
			$orderDetails['lender_name'] = $orderDetails['lender_first_name'];
		} else if(!empty($orderDetails['lender_first_name']) && !empty($orderDetails['lender_last_name'])) {
			$orderDetails['lender_name'] = $orderDetails['lender_first_name']." ".$orderDetails['lender_last_name'];
		}

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
                $orderDetails['secondary_owner_name'] =  $orderDetails['secondary_owner'];
			} else {
				$orderDetails['secondary_owner_name'] = '';
			}
		}
		
		$endPoint = 'files/'. $fileId .'/partners';
        $logid = $this->apiLogs->syncLogs(0, 'resware', 'get_partners', env('RESWARE_ORDER_API').$endPoint, array(), array(), $orderDetails['order_id'], 0);
    
        $user_data['admin_api'] = 1;
        $user_data['from_mail'] = 1; 
    		 
		$resultPartners = $this->resware->make_request('GET', $endPoint, '', $user_data);
		$this->apiLogs->syncLogs(0, 'resware', 'get_partners', env('RESWARE_ORDER_API').$endPoint, array(), $resultPartners, $orderDetails['order_id'], $logid);
		$resPartners = json_decode($resultPartners, true);	  
		if(!empty($resPartners)) {
			$key = array_search(7, array_column($resPartners['Partners'], 'PartnerTypeID'));
 			if ($resPartners['Partners'][$key]['PartnerName'] == 'North American Title Insurance Company') {
				$orderDetails['cpl_api'] = 'natic';
			} elseif ($resPartners['Partners'][$key]['PartnerName'] == 'Westcor Land Title Insurance Company') {
                $orderDetails['cpl_api'] = 'westcor';
				$this->load->library('order/westcor');
				$agentsData = $this->westcor->getBranches($orderDetails['order_id']);
				$orderDetails['agents_data'] = $agentsData;
			} else if ($resPartners['Partners'][$key]['PartnerName'] == 'Commonwealth Land Title Insurance Company') {
				$orderDetails['cpl_api'] = 'fnf';
				$agentsData = $this->fnf->getAgents();
				if ($agentsData === false) {
					$orderDetails['email'] = $orderUser['email_address'];
					$agentsData = $this->fnf->getAgentsFromApi($orderDetails);
				}
				$orderDetails['agents_data'] = $agentsData;
			} else {
                $orderDetails['cpl_api'] = 'westcor';
				$this->load->library('order/westcor');
				$agentsData = $this->westcor->getBranches($orderDetails['order_id']);
				$orderDetails['agents_data'] = $agentsData;
			}
		}
		$orderDetails['loan_amount'] = $orderDetails['loan_amount'] ? $orderDetails['loan_amount'] : '';
		$orderDetails['loan_number'] = $orderDetails['loan_number'] ? $orderDetails['loan_number'] : '';
        $orderDetails['vesting'] = $orderDetails['vesting'] ? $orderDetails['vesting'] : '';  
        $response = array('status'=>'success', 'orderDetails' => $orderDetails); 
		echo json_encode($response); exit;
	}

	function getDetailsByName()
    {
    	$searchTerm = isset($_POST['term']) && !empty($_POST['term']) ? $_POST['term'] : '';
    	// $isEscrow = isset($_POST['is_escrow']) && !empty($_POST['is_escrow']) ? $_POST['is_escrow'] : 0;

		$is_master_search = isset($_POST['is_master_search']) && !empty($_POST['is_master_search']) ? $_POST['is_master_search'] : 0;

    	$condition = array(
            'company_name' => $searchTerm
        );
        $condition['where']['is_sales_rep'] = 0;
    	if(isset($_POST['is_escrow']))
    	{
    		$isEscrow = $_POST['is_escrow'];
    		$condition['is_escrow'] = $isEscrow;
    	}

    	$userDetails = $this->home_model->get_customers($condition, $is_master_search);
    	$userInfo = array();
    	if(isset($userDetails) && !empty($userDetails))
    	{
    		foreach ($userDetails as $key => $value) 
    		{
    			$data['id'] = isset($value['id']) && !empty($value['id']) ? $value['id'] : '';
            
	            $data['value'] = isset($value['value']) && !empty($value['value']) ? $value['value'] : '';

	            $data['name'] = isset($value['full_name']) && !empty($value['full_name']) ? $value['full_name'] : '';
	            $data['fname'] = isset($value['first_name']) && !empty($value['first_name']) ? $value['first_name'] : '';
	            $data['lname'] = isset($value['last_name']) && !empty($value['last_name']) ? $value['last_name'] : '';
	            $data['email_address'] = isset($value['email_address']) && !empty($value['email_address']) ? $value['email_address'] : '';
	            $data['telephone_no'] = isset($value['telephone_no']) && !empty($value['telephone_no']) ? $value['telephone_no'] : '';
				$data['company'] = isset($value['company_name']) && !empty($value['company_name']) ? $value['company_name'] : '';
				$data['address'] = isset($value['street_address']) && !empty($value['street_address']) ? $value['street_address'] : '';
                $data['city'] = isset($value['city']) && !empty($value['city']) ? $value['city'] : '';
                $data['state'] = isset($value['state']) && !empty($value['state']) ? $value['state'] : '';
				$data['zip_code'] = isset($value['zip_code']) && !empty($value['zip_code']) ? $value['zip_code'] : '';
                $data['is_escrow'] = isset($value['is_escrow']) && !empty($value['is_escrow']) ? $value['is_escrow'] : '';
                $data['assignment_clause'] = isset($value['assignment_clause']) && !empty($value['assignment_clause']) ? $value['assignment_clause'] : '';
	            // array_push($userInfo, $data); 
	            $userInfo[] =$data;
    		}
    	}
    	echo json_encode($userInfo);
    }

    public function generate_mail_proposed_insured()
    {
        $fileId = isset($_POST['fileId']) && !empty($_POST['fileId']) ? $_POST['fileId'] : '';
        $data['fileId'] = $fileId;

        $orderDetails = $this->order->get_order_details($fileId,1);
        $orderId = isset($orderDetails['order_id']) && !empty($orderDetails['order_id']) ? $orderDetails['order_id'] : '';
        $data['orderId'] = $orderId;
        $transaction_id = isset($orderDetails['transaction_id']) && !empty($orderDetails['transaction_id']) ? $orderDetails['transaction_id'] : '';
        $data['transaction_id'] = $transaction_id;
        $vesting = isset($orderDetails['vesting']) && !empty($orderDetails['vesting']) ? $orderDetails['vesting'] : '';
        $data['vesting'] = $vesting;
        $property_id = isset($orderDetails['property_id']) && !empty($orderDetails['property_id']) ? $orderDetails['property_id'] : '';
        $data['property_id'] = $property_id;
        $customer_id = isset($orderDetails['customer_id']) && !empty($orderDetails['customer_id']) ? $orderDetails['customer_id'] : '';

        $this->load->model('order/home_model');
        $customer_data =  $this->home_model->get_user(array('id' => $customer_id));

        $data['company'] = isset($customer_data['company_name']) && !empty($customer_data['company_name']) ? $customer_data['company_name'] : '';
    
        $address = array();
        $street_address = isset($customer_data['street_address']) && !empty($customer_data['street_address']) ? $customer_data['street_address'] : '';
        if($street_address)
        {
            $address[] = $street_address;
        }
        $city = isset($customer_data['city']) && !empty($customer_data['city']) ? $customer_data['city'] : '';
        if($city)
        {
            $address[] = $city;
        }

        $zip_code = isset($customer_data['zip_code']) && !empty($customer_data['zip_code']) ? $customer_data['zip_code'] : '';
        if($zip_code)
        {
            $address[] = $zip_code;
        }
        $data['address'] = implode(', ', $address);
        $data['order_number'] = isset($orderDetails['file_number']) && !empty($orderDetails['file_number']) ? $orderDetails['file_number'] : '';
        $data['property_address'] = isset($orderDetails['full_address']) && !empty($orderDetails['full_address']) ? $orderDetails['full_address'] : '';
        $data['sales_amount'] = isset($orderDetails['sales_amount']) && !empty($orderDetails['sales_amount']) ? $orderDetails['sales_amount'] : '';
        $data['loan_amount'] = isset($orderDetails['loan_amount']) && !empty($orderDetails['loan_amount']) ? $orderDetails['loan_amount'] : '';
        $data['loan_number'] = isset($orderDetails['loan_number']) && !empty($orderDetails['loan_number']) ? $orderDetails['loan_number'] : '';
        $data['title_officer']= isset($orderDetails['title_officer']) && !empty($orderDetails['title_officer']) ? $orderDetails['title_officer'] : '';

        if ($orderDetails['sales_amount'] > 0) 
        {
            if (!empty($orderDetails['borrower'])) {
                $data['primary_owner_first_name'] = !empty($orderDetails['borrower']) ? $orderDetails['borrower'] : '';
            } else {
                $data['primary_owner_first_name'] = '';
            }
    
            if (!empty($orderDetails['secondary_borrower'])) {
                $data['secondary_owner_first_name'] = !empty($orderDetails['secondary_borrower']) ? $orderDetails['secondary_borrower'] : '';
            } else {
                $data['secondary_owner_first_name'] = '';
            }
        } 
        else 
        {
            if (!empty($orderDetails['primary_owner'])) {
                $data['primary_owner_first_name'] = !empty($orderDetails['primary_owner']) ? $orderDetails['primary_owner'] : '';
            } else {
                $data['primary_owner_first_name'] = '';
            }
    
            if (!empty($orderDetails['secondary_owner'])) {
                $data['secondary_owner_first_name'] = !empty($orderDetails['secondary_owner']) ? $orderDetails['secondary_owner'] : '';
            } else {
                $data['secondary_owner_first_name'] = '';
            }
        }

        if(!empty($orderDetails['supplemental_report_date']) && $orderDetails['supplemental_report_date'] != '0000-00-00')
        {
            $s_report_date = date("m/d/Y",strtotime($orderDetails['supplemental_report_date']));
        }
        
        $data['supplemental_report_date']= isset($s_report_date) && !empty($s_report_date) ? $s_report_date : '';

        if(!empty($orderDetails['preliminary_report_date']) && $orderDetails['preliminary_report_date'] != '0000-00-00')
        {
            $p_report_date = date("m/d/Y",strtotime($orderDetails['preliminary_report_date']));
        }
        
        $data['preliminary_report_date'] = isset($p_report_date) && !empty($p_report_date) ? $p_report_date : '';

        $data['is_escrow'] = $customer_data['is_escrow'];

        if ($customer_data['is_escrow'] == 1) {
    
            if (!empty($orderDetails['cpl_lender_id'])) {
                $lenderDetails =  $this->home_model->get_user(array('id' => $orderDetails['cpl_lender_id']));    
                $data['lender_first_name'] =  $lenderDetails['first_name'] ? $lenderDetails['first_name'] : '';
                $data['lender_last_name'] = $lenderDetails['last_name'] ? $lenderDetails['last_name'] : '';
                $data['lender_email'] = $lenderDetails['email_address'] ? $lenderDetails['email_address'] : '';
                $data['lender_state'] = $lenderDetails['state'] ? $lenderDetails['state'] : '';
                $data['lender_company_name'] = $lenderDetails['company_name'] ? $lenderDetails['company_name'] : '';
                $data['lender_address'] = $lenderDetails['street_address'] ? $lenderDetails['street_address'] : '';
                $data['lender_city'] = $lenderDetails['city'] ? $lenderDetails['city'] : '';
                $data['lender_zipcode'] = $lenderDetails['zip_code'] ? $lenderDetails['zip_code'] : '';
                $data['lender_id'] = $lenderDetails['id'] ? $lenderDetails['id'] : '';   
            } 
            else 
            {
                // $data['escrow_lender_id'] = $orderDetails['escrow_lender_id'] ? $orderDetails['escrow_lender_id'] : ''; 
                $data['lender_first_name'] = $orderDetails['lender_first_name'] ? $orderDetails['lender_first_name'] : '';    
                $data['lender_last_name'] = $orderDetails['lender_last_name'] ? $orderDetails['lender_last_name'] : '';
                $data['lender_email'] = $orderDetails['lender_email'] ? $orderDetails['lender_email'] : '';    
                $data['lender_state'] = $orderDetails['lender_state'] ? $orderDetails['lender_state'] : '';    
                $data['lender_company_name'] = $orderDetails['lender_company_name'] ? $orderDetails['lender_company_name'] : '';    
                $data['lender_address'] = $orderDetails['lender_address'] ? $orderDetails['lender_address'] : '';    
                $data['lender_city'] = $orderDetails['lender_city'] ? $orderDetails['lender_city'] : '';    
                $data['lender_zipcode'] = $orderDetails['lender_zipcode'] ? $orderDetails['lender_zipcode'] : '';
                $data['lender_id'] = $orderDetails['lender_id'] ? $orderDetails['lender_id'] : '';
    
            }
    
        } else {
    
            if (!empty($orderDetails['cpl_lender_id'])) {
    
                $lenderDetails =  $this->home_model->get_user(array('id' => $orderDetails['cpl_lender_id']));
                $data['cpl_lender_id'] = $orderDetails['cpl_lender_id'];

                $data['lender_first_name'] = $lenderDetails['first_name'] ? $lenderDetails['first_name'] : '';
    
                $data['lender_last_name'] = $lenderDetails['last_name'] ? $lenderDetails['last_name'] : '';
    
                $data['lender_email'] = $lenderDetails['email_address'] ? $lenderDetails['email_address'] : '';
    
                $data['lender_state'] = $lenderDetails['state'] ? $lenderDetails['state'] : '';
    
                $data['lender_company_name'] = $lenderDetails['company_name'] ? $lenderDetails['company_name'] : '';
    
                $data['lender_address'] = $lenderDetails['street_address'] ? $lenderDetails['street_address'] : '';
    
                $data['lender_city'] = $lenderDetails['city'] ? $lenderDetails['city'] : '';
    
                $data['lender_zipcode'] = $lenderDetails['zip_code'] ? $lenderDetails['zip_code'] : '';

                $data['lender_id'] = $lenderDetails['id'] ? $lenderDetails['id'] : '';
    
            } else {
                
                // $data['cpl_lender_id'] = $customer_data['id']; 
                $data['lender_first_name'] = $customer_data['first_name'] ? $customer_data['first_name'] : '';
    
                $data['lender_last_name'] = $customer_data['last_name'] ? $customer_data['last_name'] : '';
    
                $data['lender_email'] = $customer_data['email_address'] ? $customer_data['email_address'] : '';
    
                $data['lender_state'] = $customer_data['state'] ? $customer_data['state'] : '';
    
                $data['lender_company_name'] = $customer_data['company_name'] ? $customer_data['company_name'] : '';
    
                $data['lender_address'] = $customer_data['street_address'] ? $customer_data['street_address'] : '';
    
                $data['lender_city'] = $customer_data['city'] ? $customer_data['city'] : '';
    
                $data['lender_zipcode'] = $customer_data['zip_code'] ? $customer_data['zip_code'] : '';
    
                $data['lender_assignment_clause'] = $customer_data['assignment_clause'] ? $customer_data['assignment_clause'] : '';
    
                $data['lender_id'] = $customer_data['id'] ? $customer_data['id'] : '';
    
            }
    
            $orderUser =  $this->home_model->get_user(array('id' => $orderDetails['customer_id']));
            }

        if(empty($data['lender_first_name']) && empty($data['lender_last_name'])) {
            $data['lender_name'] = '';
        } else if(empty($data['lender_first_name']) && !empty($data['lender_last_name'])) {
            $data['lender_name'] = $data['lender_last_name'];
        } else if(!empty($data['lender_first_name']) && empty($data['lender_last_name'])) {
            $data['lender_name'] = $data['lender_first_name'];  
        } else if(!empty($data['lender_first_name']) && !empty($data['lender_last_name'])) {
            $data['lender_name'] = $data['lender_first_name']." ".$data['lender_last_name'];
        }
        
        $response = array('status'=>'success', 'orderDetails' => $data);
        echo json_encode($response); exit;
    }

    public function add_mail_order_details()
    {
        $orderId = $this->input->post('orderId');
        $this->load->library('order/resware');

        if($orderId)
        {
            $this->load->model('order/home_model');

            $TitleOfficer = $this->input->post('TitleOfficer');
            $loan_amount = $this->input->post('loan_amount');
            $loan_number = $this->input->post('loan_number');
            
            $primary_owner = $this->input->post('primary_first_name');
            
            $secondaryOwner = $this->input->post('secondary_first_name');
            $name = explode(" ",$this->input->post('LenderName'));
            $vesting = $this->input->post('vesting');
            $new_existing_lender = $this->input->post('new_existing_lender');
            $LenderId = $this->input->post('LenderId');
            $transaction_id = $this->input->post('transaction_id');
            $property_id = $this->input->post('property_id');
            $fileId = $this->input->post('fileId');
            $s_report_date = $this->input->post('s_report_date');
            $p_report_date = $this->input->post('p_report_date');
            $s_report_date = date("Y-m-d",strtotime($s_report_date));
            $p_report_date = date("Y-m-d",strtotime($p_report_date));
            
            $orderDetails = $this->order->get_order_details($fileId,1);

            
            $lender_details = array(
                'first_name'    => $name[0],
                'last_name'  => !empty($name[1]) ? $name[1] : '',
                'state'  => !empty($this->input->post('LenderState')) ? $this->input->post('LenderState') : "",
                'email_address' => !empty($this->input->post('LenderEmailAddress')) ? $this->input->post('LenderEmailAddress') : "",
                'company_name'  => !empty($this->input->post('LenderCompany')) ? $this->input->post('LenderCompany') : "",
                'street_address' => !empty($this->input->post('LenderAddress')) ? $this->input->post('LenderAddress') : "",
                'city'  => !empty($this->input->post('LenderCity')) ? $this->input->post('LenderCity') : "",
                'zip_code'  => !empty($this->input->post('LenderZipcode')) ? $this->input->post('LenderZipcode') : ""
            );

            if($new_existing_lender == 'add_lender') 
            {
                $lender_details['partner_id'] = $this->input->post('partner_id');
                $lender_details['state'] = empty($this->input->post('state')) ? $this->input->post('state') : 'CA';
                $lender_details['is_added_lender_by_cpl_proposed'] = 1;
                $lender_details['is_escrow'] = 0;
                $lender_details['status'] = 0;
                $LenderId = $this->home_model->insert($lender_details, 'customer_basic_details');       
            }
            else
            {
                $condition = array(
                    'id' => $LenderId
                );
                $this->home_model->update($lender_details, $condition, 'customer_basic_details');
            }
                

            if(empty($lender_details['first_name']) && empty($lender_details['lender_last_name'])) {
                $lender_details['lender_name'] = '';
            } else if(empty($lender_details['first_name']) && !empty($lender_details['last_name'])) {
                $lender_details['lender_name'] = $lender_details['last_name'];
            } else if(!empty($lender_details['first_name']) && empty($lender_details['last_name'])) {
                $lender_details['lender_name'] = $lender_details['first_name'];
            } else if(!empty($lender_details['first_name']) && !empty($lender_details['last_name'])) {
                $lender_details['lender_name'] = $lender_details['first_name']." ".$lender_details['last_name'];
            }
            $lender_address = array();
            $street_address = $this->input->post('LenderAddress');
            if($street_address)
            {
                $lender_address[] = $street_address;
            }
            $city = $this->input->post('LenderCity');
            if($city)
            {
                $lender_address[] = $city;
            }

            $lendeUser =  $this->home_model->get_user(array('id' => $LenderId));

            $state = isset($lendeUser['state']) && !empty($lendeUser['state']) ? $lendeUser['state'] : '';

            if($state)
            {
                $lender_address[] = $state;
            }

            $zip_code = $this->input->post('LenderZipcode');
            if($zip_code)
            {
                $lender_address[] = $zip_code;
            }

            $pdfData['lender'] = array(
                'lender_name'=> $lender_details['lender_name'],
                'address'=> implode(', ', $lender_address),
                'company_name'=> $lender_details['company_name']
            );  
            

            $orderUser =  $this->home_model->get_user(array('id' => $orderDetails['customer_id']));
            
            if ($orderDetails['sales_amount'] > 0) 
            {
                /*if ($orderUser['is_escrow'] == 1) {
                    $propertyDetails = array('escrow_lender_id' => $LenderId);
                } else {*/
                    $propertyDetails = array('cpl_lender_id' => $LenderId);
                /*}*/
                
                $property_update_flag = $this->home_model->update($propertyDetails, array('id' => $orderDetails['property_id']), 'property_details');

                $transaction_update_flag = $this->home_model->update(array('loan_amount' => $loan_amount, 'loan_number' => $loan_number, 'borrower' => $primary_owner, 'secondary_borrower' => $secondaryOwner,'title_officer'=>$TitleOfficer,'preliminary_report_date'=>$p_report_date,'supplemental_report_date'=>$s_report_date,'vesting'=>$vesting), array('id' => $orderDetails['transaction_id']), 'transaction_details');
            } 
            else 
            {

                /*if ($orderUser['is_escrow'] == 1) {
                    $propertyDetails = array('escrow_lender_id' => $LenderId, 'primary_owner' => $primary_owner, 'secondary_owner' => $secondaryOwner);
                } else {*/    
                    $propertyDetails = array('cpl_lender_id' => $LenderId, 'primary_owner' => $primary_owner, 'secondary_owner' => $secondaryOwner);    
                /*}*/
                
                $property_update_flag = $this->home_model->update($propertyDetails, array('id' => $orderDetails['property_id']), 'property_details');

                $transaction_update_flag = $this->home_model->update(array('loan_amount' => $loan_amount, 'loan_number' => $loan_number,'title_officer'=>$TitleOfficer,'preliminary_report_date'=>$p_report_date,'supplemental_report_date'=>$s_report_date,'vesting'=>$vesting), array('id' => $orderDetails['transaction_id']), 'transaction_details');
            }

            if($property_update_flag || $transaction_update_flag)
            {
                $orderDetails = $this->order->get_order_details($fileId,1);
                
                $pdfData['company'] = isset($orderUser['company_name']) && !empty($orderUser['company_name']) ? $orderUser['company_name'] : '';
    
                $address = array();
                $street_address = isset($orderUser['street_address']) && !empty($orderUser['street_address']) ? $orderUser['street_address'] : '';
                if($street_address)
                {
                    $address[] = $street_address;
                }
                $city = isset($orderUser['city']) && !empty($orderUser['city']) ? $orderUser['city'] : '';
                if($city)
                {
                    $address[] = $city;
                }

                $zip_code = isset($orderUser['zip_code']) && !empty($orderUser['zip_code']) ? $orderUser['zip_code'] : '';
                if($zip_code)
                {
                    $address[] = $zip_code;
                }
                $pdfData['address'] = implode(', ', $address);
                $pdfData['order_number'] = isset($orderDetails['file_number']) && !empty($orderDetails['file_number']) ? $orderDetails['file_number'] : '';
                $pdfData['property_address'] = isset($orderDetails['full_address']) && !empty($orderDetails['full_address']) ? $orderDetails['full_address'] : '';
                $pdfData['sales_amount'] = isset($orderDetails['sales_amount']) && !empty($orderDetails['sales_amount']) ? $orderDetails['sales_amount'] : '';
                $pdfData['loan_amount'] = isset($orderDetails['loan_amount']) && !empty($orderDetails['loan_amount']) ? $orderDetails['loan_amount'] : '';
                $pdfData['loan_number'] = isset($orderDetails['loan_number']) && !empty($orderDetails['loan_number']) ? $orderDetails['loan_number'] : '';
                
                if(isset($orderDetails['title_officer']) && !empty($orderDetails['title_officer']))
                {
                    if(preg_match('/\\d/', $orderDetails['title_officer']) > 0)
                    {
                        $condition = array(
                            'id' => $orderDetails['title_officer'],
                            'status' => 1
                        );
                        $titleOfficerDetails = $this->titleOfficer->getTitleOfficerDetails($condition); 
                    }
                    else
                    {
                        $condition = array(
                            'where' => array(
                                'name' => $orderDetails['title_officer'],
                                'status' => 1
                            )
                        );
                        $officerDetails = $this->titleOfficer->getTitleOfficerDetails($condition);
                        $titleOfficerDetails = isset($officerDetails[0]) && !empty($officerDetails[0]) ? $officerDetails[0] : array();
                    }
                
                    $pdfData['title_officer'] = isset($titleOfficerDetails['name']) && !empty($titleOfficerDetails['name']) ? $titleOfficerDetails['name'] : '';;
                    $pdfData['title_officer_email'] = isset($titleOfficerDetails['email_address']) && !empty($titleOfficerDetails['email_address']) ? $titleOfficerDetails['email_address'] : '';
                    $pdfData['title_officer_phone'] = isset($titleOfficerDetails['phone']) && !empty($titleOfficerDetails['phone']) ? $titleOfficerDetails['phone'] : '';
                }

                if ($orderDetails['sales_amount'] > 0) 
                {
                    if (!empty($orderDetails['borrower'])) {
                        $pdfData['primary_owner'] = $orderDetails['borrower'];
                        
                    } else {
                        $pdfData['primary_owner'] =  '';
                    }
            
                    if (!empty($orderDetails['secondary_borrower'])) 
                    {
                        $pdfData['secondary_owner'] = $orderDetails['secondary_borrower'];
                    } else {
                        $pdfData['secondary_owner'] = '';
                    }   
                } 
                else 
                {
                    if (!empty($orderDetails['primary_owner'])) {
                        $pdfData['primary_owner'] = $orderDetails['primary_owner'];
                        
                    } else {
                        $pdfData['primary_owner'] = '';
                    }
                    
                    if (!empty($orderDetails['secondary_owner'])) 
                    {
                        $pdfData['secondary_owner'] = $orderDetails['secondary_owner'];
                    } else {
                        $pdfData['secondary_owner'] = '';
                    }
                }
                $pdfData['vesting'] = isset($orderDetails['vesting']) && !empty($orderDetails['vesting']) ? $orderDetails['vesting'] : '';
                $pdfData['supplemental_report_date']= isset($orderDetails['supplemental_report_date']) && !empty($orderDetails['supplemental_report_date']) ? date("m/d/Y h:i:s A", strtotime($orderDetails['supplemental_report_date'])) : '';

                $pdfData['preliminary_report_date'] = isset($orderDetails['preliminary_report_date']) && !empty($orderDetails['preliminary_report_date']) ? date("m/d/Y h:i:s A", strtotime($orderDetails['preliminary_report_date'])) : '';

                $pdfData['underwriter'] = '';
                $endPoint = 'files/'. $fileId .'/partners';
                $logid = $this->apiLogs->syncLogs($orderUser['id'], 'resware', 'get_partners', env('RESWARE_ORDER_API').$endPoint, array(), array(), $orderDetails['order_id'], 0);

                $user_data['email'] = $orderUser['email_address'];
                $user_data['password'] = $orderUser['random_password'];
                $user_data['from_mail'] = 1;
                
                $resultPartners = $this->resware->make_request('GET', $endPoint, '', $user_data);
                $this->apiLogs->syncLogs($orderUser['id'], 'resware', 'get_partners', env('RESWARE_ORDER_API').$endPoint, array(), $resultPartners, $orderDetails['order_id'], $logid);
                $resPartners = json_decode($resultPartners, true);
                if(!empty($resPartners)) {
                    $key = array_search(7, array_column($resPartners['Partners'], 'PartnerTypeID'));
                    $pdfData['underwriter'] = $resPartners['Partners'][$key]['PartnerName'];
                }

                $html=$this->load->view('order/proposed_insured_pdf',$pdfData, true);
                $this->load->library('m_pdf');
                $this->m_pdf->pdf->WriteHTML($html);
                $this->load->model('order/document');
                $proposedDocumentCount = $this->document->countProposedInsuredDocument($orderDetails['order_id']);
                $document_name = "proposed_".$proposedDocumentCount."_".$fileId.".pdf";

                if (!is_dir('uploads/proposed-insured')) {
                    mkdir('./uploads/proposed-insured', 0777, TRUE);
                }

                $pdfFilePath = './uploads/proposed-insured/'.$document_name;
                $this->m_pdf->pdf->Output($pdfFilePath,'F');
                $contents = file_get_contents($pdfFilePath);
                $binaryData   = base64_encode($contents);       
                // unlink($pdfFilePath);
                $this->home_model->update(array('proposed_insured_document_name' => $document_name), array('file_id' => $fileId), 'order_details');

                $this->uploadProposedDocumentToResware($document_name, $orderDetails, $binaryData);

                /*$fileSize = filesize('./uploads/proposed-insured/'.$document_name);
                $documentData = array(
                    'document_name' => $document_name,
                    'original_document_name' => $document_name,
                    'document_type_id' => 1031,
                    'document_size' => $fileSize,
                    'user_id' => $orderUser['id'],
                    'order_id' => $orderDetails['order_id'],
                    'description' => 'Proposed Insured Document',
                    'is_sync' => 0,
                    'is_prelim_document' => 0,
                    'is_proposed_insured_doc' => 1
                );
                $documentId = $this->document->insert($documentData);*/

                $data = array('status'=>'success','data'=>$binaryData);
            }
            else
            {
                $data = array('status'=>'error');
            }
        }
        else
        {
            $data = array('status'=>'error');
        }
        echo json_encode($data); exit;
    }

    public function uploadProposedDocumentToResware($document_name, $orderDetails, $binaryData)
    {
        $this->load->model('order/document');
        $this->load->library('order/resware');
        $this->load->model('order/apiLogs');

        $userdata = $this->session->userdata('user');

        $fileSize = filesize('./uploads/proposed-insured/'.$document_name);

        $documentData = array(
            'document_name' => $document_name,
            'original_document_name' => $document_name,
            'document_type_id' => 1037,
            'document_size' => $fileSize,
            'user_id' => 0,
            'order_id' => $orderDetails['order_id'],
            'description' => 'Proposed Insured Document',
            'is_sync' => 1,
            'is_prelim_document' => 0,
            'is_proposed_insured_doc' => 1
        );

        $documentId = $this->document->insert($documentData);

        $endPoint = 'files/'.$orderDetails['file_id'].'/documents';

        $documentApiData = array(           
            'DocumentName' => $document_name,
            'DocumentType' => array(
                'DocumentTypeID' => 1037,
            ),
            'Description' => 'Proposed Insured Document',
            'InternalOnly' => false,
            'DocumentBody' => $binaryData
        );
        $document_api_data = json_encode($documentApiData, JSON_UNESCAPED_SLASHES);

        $orderUser =  $this->home_model->get_user(array('id' => $orderDetails['customer_id']));
        $user_data['email'] = $orderUser['email_address'];
        $user_data['password'] = $orderUser['random_password'];
        $user_data['from_mail'] = 1;
        
        $logid = $this->apiLogs->syncLogs(0, 'resware', 'create_document', env('RESWARE_ORDER_API').$endPoint, $documentApiData, array(), $orderDetails['order_id'], 0);

        $result = $this->resware->make_request('POST', $endPoint, $document_api_data, $user_data);

        $this->apiLogs->syncLogs(0, 'resware', 'create_document', env('RESWARE_ORDER_API').$endPoint, $documentApiData, $result, $orderDetails['order_id'], $logid);

        $res = json_decode($result);

        $this->document->update(array('api_document_id' => $res->Document->DocumentID), array('id' => $documentId));
    }

    public function borrowerInformation()
    {
        $random_number = $this->uri->segment(2);
        $condition = array(
            'where' => array(
                'random_number' => $random_number,
            )
        );
        $order = $this->order->get_order($condition);

        if(!empty($order)) {
            $orderNumber = isset($order[0]['file_number']) && !empty($order[0]['file_number']) ? $order[0]['file_number'] : '';
            $fileId = isset($order[0]['file_id']) && !empty($order[0]['file_id']) ? $order[0]['file_id'] : '';
            $borrower_info_submitted = $order[0]['borrower_info_submitted'];
            $is_code_verified = $order[0]['is_code_verified'];
            $orderDetails = $this->order->get_order_details($fileId, 1);

            if ($is_code_verified == 1 && $borrower_info_submitted == 1) {
                $data['is_borrower_info_submitted'] = 1;
                $data['mail_dashboard'] = 1;
                $data['order_id'] = $order[0]['id'];
                $data['errors'] = array();
                $data['success'] = array();
                if ($this->session->userdata('errors')) {
                    $data['errors'] = $this->session->userdata('errors');
                    $this->session->unset_userdata('errors');
                }
                if ($this->session->userdata('success')) {
                    $data['success'] = $this->session->userdata('success');
                    $this->session->unset_userdata('success');
                }
                $this->load->view('layout/head_dashboard', $data);
                $this->load->view('order/borrower', $data);
            } else if ($is_code_verified == 1 && $borrower_info_submitted == 0) {
                $data['is_borrower_info_submitted'] = 0;
                $data['mail_dashboard'] = 1;
                $data['order_id'] = $order[0]['id'];
                $data['errors'] = array();
                $data['success'] = array();
                if ($this->session->userdata('errors')) {
                    $data['errors'] = $this->session->userdata('errors');
                    $this->session->unset_userdata('errors');
                }
                if ($this->session->userdata('success')) {
                    $data['success'] = $this->session->userdata('success');
                    $this->session->unset_userdata('success');
                }
                $this->load->view('layout/head_dashboard', $data);
                $this->load->view('order/borrower', $data); 
            } else {
                $propertyAddress = isset($orderDetails['full_address']) && !empty($orderDetails['full_address']) ? $orderDetails['full_address'] : '';
                $data['orderNumber'] = $orderNumber;
                $data['propertyAddress'] = $propertyAddress;
                $data['randomNumber'] = $random_number;
                $data['fileId'] = $fileId;
                $this->load->view('order/borrower_login', $data);
            }
        } else {
            redirect(base_url().'order');
        }
    }

    public function generate_verification_code()
    {
        $phoneNumber = $this->input->post('phone_number');

        if(isset($phoneNumber) && !empty($phoneNumber))
        {
            $randomNumber = $this->input->post('random_number');
            // $code = $this->order->randomPassword();
            $code = rand(10000000,99999999);
            $sid = env('TWILIO_SID');
            $token = env('TWILIO_TOKEN');
            $from = env('TWILIO_FROM');

            $logid = $this->apiLogs->syncLogs('', 'twilio', 'send_message', '', array('code'=>$code,'account_sid'=>$sid,'token'=>$token,'to'=>$to, 'from'=>$from), array(), 0, 0);

            try {
                $result = $this->twilio->message($phoneNumber, $code,'',array('from'=>$from));
                $response = $result->toArray();
                $response['msg_status'] = 'success';
                $response['code'] = $code;

            }
            catch (Exception $e) {
                $response['sid'] = '';
                $response['to'] = $phoneNumber;
                $response['msg_status'] = 'error';
                $response['errorCode'] = $e->getCode();
                $response['errorMessage'] = $e->getMessage();
                // $response = (object)$response;
            } catch (\Twilio\Exceptions\RestException $e) {
                $response['sid'] = '';
                $response['to'] = $phoneNumber;
                $response['msg_status'] = 'error';
                $response['errorCode'] = $e->getCode();
                $response['errorMessage'] = $e->getMessage();
                // $response = (object)$response;
            }

            $this->apiLogs->syncLogs('', 'twilio', 'send_message', '', array('code'=>$code,'account_sid'=>$sid,'token'=>$token,'to'=>$to, 'from'=>$from), $response, 0, $logid);

            if($response['msg_status'] == 'success')
            {
                $this->home_model->update(array('verification_code' => $code,'is_code_verified' => 0,'code_created_at'=> date("Y-m-d H:i:s")), array('random_number' => $randomNumber), 'order_details');

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
                // $result = $response;
                $result = array('msg_status'=>'success', 'message'=> 'Code generated successfully.');
            }
            else
            {
                $result = array('msg_status'=>'error', 'error_message'=> $response['errorMessage']);
            }
            
        }
        else
        {
            $result = array('msg_status'=>'error', 'error_message'=> 'Please enter phone number.');               
        }

        echo json_encode($result); exit;
    }

    public function borrowerInfoSubmit()
    {
        $errors = array();
        $success = array();
        $condition = array(
            'where' => array(
                'id' =>  $this->input->post('order_id'),
            )
        );
        $order = $this->order->get_order($condition);
        $fileId = isset($order[0]['file_id']) && !empty($order[0]['file_id']) ? $order[0]['file_id'] : '';
        $orderDetails = $this->order->get_order_details($fileId, 1);
        $this->db->delete('pct_order_borrower_info', array('order_id' => $this->input->post('order_id')));
        $borrowerInfoData = array(
            'first_name' => $this->input->post('firstname'),
            'middle_name' => $this->input->post('middlename'),
            'last_name' => $this->input->post('lastname'),
            'mobile' => $this->input->post('mobile'),
            'telephone' => $this->input->post('telephone'),
            'date_of_birth' => $this->input->post('date_of_birth'),
            'birthplace' => $this->input->post('birthplace'),
            'ssn' => $this->input->post('ssn'),
            'dln' => $this->input->post('dln'),
            'status' => $this->input->post('status'),
            'spouse_first_name' => $this->input->post('spouse_firstname'),
            'spouse_middle_name' => $this->input->post('spouse_middlename'),
            'spouse_last_name' => $this->input->post('spouse_lastname'),
            'spouse_mobile' => $this->input->post('spouse_mobile'),
            'spouse_telephone' => $this->input->post('spouse_telephone'),
            'spouse_date_of_birth' => $this->input->post('spouse_date_of_birth'),
            'spouse_birthplace' => $this->input->post('spouse_birthplace'),
            'spouse_ssn' => $this->input->post('spouse_ssn'),
            'spouse_dln' => $this->input->post('spouse_dln'),
            'partner_first_name' => $this->input->post('partner_firstname'),
            'partner_middle_name' => $this->input->post('partner_middlename'),
            'partner_last_name' => $this->input->post('partner_lastname'),
            'partner_mobile' => $this->input->post('partner_mobile'),
            'partner_telephone' => $this->input->post('partner_telephone'),
            'partner_date_of_birth' => $this->input->post('partner_date_of_birth'),
            'partner_birthplace' => $this->input->post('partner_birthplace'),
            'partner_ssn' => $this->input->post('partner_ssn'),
            'partner_dln' => $this->input->post('partner_dln'),
            'order_id' => $this->input->post('order_id'),
            'partnership_status' => $this->input->post('partnership_status'),
            'prior_spouse_name' => $this->input->post('partnership_status') == 'both' ? $this->input->post('prior_spouse_name_both') : $this->input->post('prior_spouse_name'),
            'prior_spouse_reason' => $this->input->post('partnership_status') == 'both' ? $this->input->post('prior_spouse_reason_both') : $this->input->post('prior_spouse_reason'),
            'prior_spouse_end' => $this->input->post('partnership_status') == 'both' ? $this->input->post('prior_spouse_end_both') : $this->input->post('prior_spouse_end'),
            'current_spouse_prior_spouse_name' => $this->input->post('partnership_status') == 'both' ? $this->input->post('current_spouse_prior_spouse_name_both') : $this->input->post('current_spouse_prior_spouse_name'),
            'current_spouse_prior_spouse_reason' => $this->input->post('partnership_status') == 'both' ? $this->input->post('current_spouse_prior_spouse_reason_both') : $this->input->post('current_spouse_prior_spouse_reason'),
            'current_spouse_prior_spouse_end' => $this->input->post('partnership_status') == 'both' ? $this->input->post('current_spouse_prior_spouse_end_both') : $this->input->post('current_spouse_prior_spouse_end'),
            'street_address' => $this->input->post('street_address'),
            'buyer_intends_to_reside' => $this->input->post('buyer_intends'),
            'land_is_unimproved' => $this->input->post('land_is_unimproved'),
            'type_of_property' => $this->input->post('type_of_property'),
            'general_terms' => 1,
            'signature' => $this->input->post('signature'),
            'spouse_signature' => $this->input->post('spouse_signature'),
            'created_at' => date('Y-m-d H:i:s')
        );
        $borrowerId = $this->home_model->insert($borrowerInfoData,'pct_order_borrower_info');

        $residence_addresses = $this->input->post('residence_addresses');
        $residence_from_dates = $this->input->post('residence_from_dates');
        $residence_to_dates = $this->input->post('residence_to_dates');
        $i = 0;
        $this->db->delete('pct_order_borrower_residence_info', array('order_id' => $this->input->post('order_id')));

        foreach($residence_addresses as $residence_address) {
            $borrowerResidenceData = array(
                'address' => $residence_address,
                'from_date' => $residence_from_dates[$i],
                'to_date' => $residence_to_dates[$i],
                'order_id' => $this->input->post('order_id'),
                'created_at' => date('Y-m-d H:i:s'),
            );
            $this->home_model->insert($borrowerResidenceData, 'pct_order_borrower_residence_info');
            $i++;
        }

        $business_names = $this->input->post('business_names');
        $employment_addresses = $this->input->post('employment_addresses');
        $employment_from_dates = $this->input->post('employment_from_dates');
        $employment_to_dates = $this->input->post('employment_to_dates');
        $j = 0;
        $this->db->delete('pct_order_borrower_employment_info', array('order_id' => $this->input->post('order_id')));

        foreach($business_names as $business_name) {
            $borrowerEmploymentData = array(
                'business_name' => $business_name,
                'address' => $employment_addresses[$j],
                'from_date' => $employment_from_dates[$j],
                'to_date' => $employment_to_dates[$j],
                'order_id' => $this->input->post('order_id'),
                'is_partner_info' => 0,
                'created_at' => date('Y-m-d H:i:s'),
            );
            $this->home_model->insert($borrowerEmploymentData, 'pct_order_borrower_employment_info');
            $j++;
        }

        $partner_business_names = $this->input->post('partner_business_names');
        $partner_addresses = $this->input->post('partner_addresses');
        $partner_from_dates = $this->input->post('partner_from_dates');
        $partner_to_dates = $this->input->post('partner_to_dates');
        $k = 0;

        if(!empty($partner_business_names)) {
            foreach($partner_business_names as $partner_business_name) {
                $borrowerEmploymentPartnerData = array(
                    'business_name' => $partner_business_name,
                    'address' => $partner_addresses[$k],
                    'from_date' => $partner_from_dates[$k],
                    'to_date' => $partner_to_dates[$k],
                    'order_id' => $this->input->post('order_id'),
                    'is_partner_info' => 1,
                    'created_at' => date('Y-m-d H:i:s'),
                );
                $this->home_model->insert($borrowerEmploymentPartnerData, 'pct_order_borrower_employment_info');
                $k++;
            }
        }
        $this->home_model->update(array('borrower_info_submitted' => 1), array('random_number' => $order[0]['random_number']), 'order_details');

        /* Generate PDF */
        
        $borrower_info = $this->order->get_borrower_info($this->input->post('order_id'));

        $borrower_residence_info = $this->order->get_borrower_residence_info($this->input->post('order_id'));

        $borrower_employment_info = $this->order->get_borrower_employment_info($this->input->post('order_id'));

        $borrower_data['borrower_info'] = isset($borrower_info) && !empty($borrower_info) ? $borrower_info : array();

        $borrower_data['borrower_residence_info'] = isset($borrower_residence_info) && !empty($borrower_residence_info) ? $borrower_residence_info : array();

        $borrower_data['borrower_employment_info'] = isset($borrower_employment_info) && !empty($borrower_employment_info) ? $borrower_employment_info : array();

        
        $this->load->library('m_pdf');

        $html=$this->load->view('order/borrower_pdf',$borrower_data, true);

        $stylesheet = file_get_contents('assets/frontend/css/bootstrap.min.css');

        $customCss = '@media print { @page { size: auto; } }';

        $combinedCss = $stylesheet . $customCss;


        $this->m_pdf->pdf->WriteHTML($combinedCss, 1); // CSS Script goes here.
        $this->m_pdf->pdf->WriteHTML($html,2);
        // $document_name = "borrower_".$proposedDocumentCount."_".$fileId.".pdf";
        $document_name = "borrower_".$fileId.".pdf";
        $this->load->model('order/document');
        $borrowerDocumentCount = $this->document->countBorrowerDocument($orderDetails['order_id']);
        $document_name = "borrower_".$borrowerDocumentCount."_".$fileId.".pdf";
        if (!is_dir('uploads/borrower-information')) {
            mkdir('./uploads/borrower-information', 0777, TRUE);
        }

        $pdfFilePath = './uploads/borrower-information/'.$document_name;
        $this->m_pdf->pdf->Output($pdfFilePath,'F');

        $contents = file_get_contents($pdfFilePath);
        $binaryData   = base64_encode($contents);

        $this->home_model->update(array('borrower_information_document_name' => $document_name), array('file_id' => $fileId), 'order_details');

        $this->uploadBorrowerDocumentToResware($document_name, $orderDetails, $binaryData);
        /* Generate PDF */

        $success[] = "Borrwer information added successfully";
        $data = array(
            "errors" =>  $errors,
            "success" => $success
        );
        $this->session->set_userdata($data);
        redirect(base_url().'/borrower-information/'.$order[0]['random_number']);
    }
    
    public function code_verification()
    {
        $code = $this->input->post('code');

        if(isset($code) && !empty($code))
        {
            $fileId = $this->input->post('fileId');

            $orderDetails = $this->order->get_order_details($fileId, 1);

            $verification_code = isset($orderDetails['verification_code']) && !empty($orderDetails['verification_code']) ? $orderDetails['verification_code'] : '';

            $code_created_at = isset($orderDetails['code_created_at']) && !empty($orderDetails['code_created_at']) ? $orderDetails['code_created_at'] : '';

            if($verification_code == $code)
            {
                $expire_date = date('Y-m-d H:i',strtotime('+3 minutes',strtotime($code_created_at)));

                $now = date("Y-m-d H:i:s"); //current time


                if ($now > $expire_date) 
                { //if current time is greater then created time
                    $response = array('status'=>'error', 'message'=> 'Your verification code has been expired.');
                }
                else
                {
                    $this->home_model->update(array('is_code_verified' => 1), array('id' => $orderDetails['order_id']), 'order_details');
                    $response = array('status'=>'success');
                }                
            }
            else
            {
                $response = array('status'=>'error', 'message'=> 'Please enter valid verification code.');
            }
            
        }
        else
        {
            $response = array('status'=>'error', 'message'=> 'Please enter verification code.');
        }

        echo json_encode($response); exit;
    }


    public function genericLandingPage()
    {
        if ($this->input->post()) { 
            $this->form_validation->set_rules('order_number', 'Order Number', 'trim|required', array('required'=> 'Please enter Order Number'));
            if ($this->form_validation->run($this) == FALSE) {
                $response = array('status'=>'error', 'order_number_php_error'=> form_error('order_number'));
                echo json_encode($response); exit;
            } else {
                $order_number = $this->input->post('order_number');
                $condition = array(
                    'where' => array(
                        'file_number' => $order_number,
                    )
                );
                $order = $this->order->get_order($condition);
                if (!empty($order)) {
                    if (empty($order[0]['random_number'])) {
                        $randomString = $this->order->randomPassword();
                        $randomString = md5($order[0]['id'].$randomString);
                        $this->home_model->update(array('random_number' => $randomString), array('id' => $order[0]['id']), 'order_details');
                        $order[0]['random_number'] = $randomString;
                    }
                    $response = array('status'=> 'success', 'random_number'=> $order[0]['random_number']);
                    echo json_encode($response); exit;
                } else {
                    $data = json_encode(array('FileNumber' => $order_number));
                    $userData = array(
                        'admin_api' => 1
                    );	
                    $logid = $this->apiLogs->syncLogs(0, 'resware', 'get_order_information', env('RESWARE_ORDER_API').'files/search', $data, array(), 0, 0);
                    $res = $this->resware->make_request('POST', 'files/search', $data, $userData);
                    $this->apiLogs->syncLogs(0, 'resware', 'get_order_information', env('RESWARE_ORDER_API').'files/search', $data, $res, 0, $logid);
                    $result = json_decode($res,TRUE);
    
                    if (isset($result['Files']) && !empty($result['Files'])) {

                        foreach ($result['Files'] as $res) {
                            $FullProperty = $res['Properties'][0]['StreetNumber']." ".$res['Properties'][0]['StreetDirection']." ".$res['Properties'][0]['StreetName']." ".$res['Properties'][0]['StreetSuffix'].", ".$res['Properties'][0]['City'].", ".$res['Properties'][0]['State'].", ".$res['Properties'][0]['Zip'];
                            $address = $res['Properties'][0]['StreetNumber']." ".$res['Properties'][0]['StreetDirection']." ".$res['Properties'][0]['StreetName']." ".$res['Properties'][0]['StreetSuffix'];
                            $locale = $res['Properties'][0]['City'];
                            
                            if (($locale)) {
                                if (!empty($res['Properties'][0]['State'])) {
                                    $locale .= ', '.$res['Properties'][0]['State'];
                                } else {
                                    $locale .= ', CA';
                                }
                            }
                            $property_details = $this->getSearchResult($address, $locale);
                            
                            $property_type = isset($property_details['property_type']) && !empty($property_details['property_type']) ? $property_details['property_type'] : '';
                            $LegalDescription = isset($property_details['legaldescription']) && !empty($property_details['legaldescription']) ? $property_details['legaldescription'] : '';
                            $apn = isset($property_details['apn']) && !empty($property_details['apn']) ? $property_details['apn'] : '';
                            
                            $propertyData = array(
                                'customer_id' => 0,
                                'buyer_agent_id' => 0,
                                'listing_agent_id' => 0,
                                'escrow_lender_id' => 0,
                                'parcel_id' => $res['Properties'][0]['ParcelID'],
                                'address' => $address,
                                'city' => $res['Properties'][0]['City'],
                                'state' => $res['Properties'][0]['State'],
                                'zip' => $res['Properties'][0]['Zip'],
                                'property_type' => $property_type,
                                'full_address' => $FullProperty,
                                'apn' => $apn,
                                'county' => $res['Properties'][0]['County'],
                                'legal_description' => $LegalDescription,
                                'status'=> 1
                            );

                            $transactionData = array(
                                'customer_id' => 0,
                                'sales_amount' =>  !empty($res['SalesPrice']) ? $res['SalesPrice'] : 0,
                                'loan_number' => !empty($res['Loans'][0]['LoanNumber']) ? $res['Loans'][0]['LoanNumber'] : 0,
                                'loan_amount' => !empty($res['Loans'][0]['LoanAmount']) ? $res['Loans'][0]['LoanAmount'] : 0,
                                'transaction_type' => $res['TransactionProductType']['TransactionTypeID'],
                                'purchase_type' => $res['TransactionProductType']['ProductTypeID'],
                                'status'=> 1
                            );

                            $primary_owner = ($res['Buyers'][0]['Primary']['First'] && $res['Buyers'][0]['Primary']['First']) ? $res['Buyers'][0]['Primary']['First'] : '';
                            $primary_owner .= ($res['Buyers'][0]['Primary']['Middle'] && $res['Buyers'][0]['Primary']['Middle']) ? " ".$res['Buyers'][0]['Primary']['Middle'] : '';
                            $primary_owner .= ($res['Buyers'][0]['Primary']['Last'] && $res['Buyers'][0]['Primary']['Last']) ? " ".$res['Buyers'][0]['Primary']['Last'] : '';
                            $secondary_owner = ($res['Buyers'][0]['Secondary']['First'] && $res['Buyers'][0]['Secondary']['First']) ? $res['Buyers'][0]['Secondary']['First'] : '';
                            $secondary_owner .= ($res['Buyers'][0]['Secondary']['Middle'] && $res['Buyers'][0]['Secondary']['Middle']) ? $res['Buyers'][0]['Secondary']['Middle'] : '';
                            $secondary_owner .= ($res['Buyers'][0]['Secondary']['Last'] && $res['Buyers'][0]['Secondary']['Last']) ? " ".$res['Buyers'][0]['Secondary']['Last'] : '';
                            $ProductTypeTxt = $res['TransactionProductType']['ProductType'];

                            if (strpos($ProductTypeTxt, 'Loan') !== false) {
                                $propertyData['primary_owner'] = $primary_owner;
                                $propertyData['secondary_owner'] = $secondary_owner;
                            } elseif(strpos($ProductTypeTxt, 'Sale') !== false) {
                                $transactionData['borrower'] = $primary_owner;
                                $transactionData['secondary_borrower'] = $secondary_owner;
                                $propertyData['primary_owner'] = isset($property_info['primary_owner']) && !empty($property_info['primary_owner']) ? $property_info['primary_owner'] : '';
                                $propertyData['secondary_owner'] = isset($property_info['secondary_owner']) && !empty($property_info['secondary_owner']) ? $property_info['secondary_owner'] : '';
                            }
                            
                            $propertyId = $this->home_model->insert($propertyData,'property_details');
                            $transactionId = $this->home_model->insert($transactionData,'transaction_details');
                            $time = round((int)(str_replace("-0000)/", "", str_replace("/Date(", "",$res['Dates']['OpenedDate'])))/1000);
                            $created_date = date('Y-m-d H:i:s', $time);
                            $randomString = $this->order->randomPassword();
							
							$randomString = md5($randomString);

                            $orderData = array(
                                'customer_id' => 0,
                                'file_id' => $res['FileID'],
                                'file_number' => $res['FileNumber'],
                                'property_id' => $propertyId,
                                'transaction_id' => $transactionId,
                                'created_at' => $created_date,
                                'status'=> 1,
                                'is_imported'=> 1,
                                'is_sales_rep_order'=> 0,
                                'random_number' => $randomString,
                                'resware_status'=> strtolower($res['Status']['Name']),
                            );

                            $orderId = $this->home_model->insert($orderData,'order_details');
                            $random_number = time() + (floor(rand() * (10000 - 1 + 1)) + 1);
                            $propertyData['fipsCode'] = isset($property_details['fips']) && !empty($property_details['fips']) ? $property_details['fips'] : '';
                            $propertyData['address'] = $address;
                            $propertyData['city'] = isset($res['Properties'][0]['City']) && !empty($res['Properties'][0]['City']) ? $res['Properties'][0]['City'] : '';
                            $propertyData['unit_no'] = isset($property_details['unit_no']) && !empty($property_details['unit_no']) ? $property_details['unit_no'] : '';
                            $propertyData['apn'] = $apn;
                            $propertyData['state'] = isset($res['Properties'][0]['State']) && !empty($res['Properties'][0]['State']) ? $res['Properties'][0]['State'] : '';
                            $propertyData['county'] = isset($res['Properties'][0]['County']) && !empty($res['Properties'][0]['County']) ? $res['Properties'][0]['County'] : '';
                            $this->tpCreateService(4,$random_number,$propertyData,$userdata);                   
                            $this->tpCreateService(3,$random_number,$propertyData,$userdata);

                            $session_id = 'tp_api_id_'.$random_number;

                            $tp_condition = array(
                                'session_id' => $session_id
                            );

                            $tpData = array(
                                'file_id' => $res['FileID'],
                                'file_number' => $res['FileNumber'],
                            );
                            
                            $this->titlePointData->update($tpData,$tp_condition);

                            $titlePointDetails = $this->titlePointData->gettitlePointDetails($tp_condition);

                            $serviceId = isset($titlePointDetails['cs4_service_id']) && !empty($titlePointDetails['cs4_service_id']) ? $titlePointDetails['cs4_service_id'] : '';
                            $this->titlepoint->generateImg($serviceId,$res['FileNumber'],$orderId);
                            $instrumentNumber = isset($titlePointDetails['cs4_instrument_no']) && !empty($titlePointDetails['cs4_instrument_no']) ? $titlePointDetails['cs4_instrument_no'] : '';

                            $recordedDate = isset($titlePointDetails['cs4_recorded_date']) && !empty($titlePointDetails['cs4_recorded_date']) ? $titlePointDetails['cs4_recorded_date'] : '';
                            $fips = isset($titlePointDetails['fips']) && !empty($titlePointDetails['fips']) ? $titlePointDetails['fips'] : '';
                                
                            $this->titlepoint->generateGrantDeed($instrumentNumber,$recordedDate,$fips,$res['FileNumber'],$orderId);

                            $tax_serviceId = isset($titlePointDetails['cs3_service_id']) && !empty($titlePointDetails['cs3_service_id']) ? $titlePointDetails['cs3_service_id'] : '';

                            $this->titlepoint->generateTaxDoc($tax_serviceId,$res['FileNumber'],$orderId);
                            $response = array('status'=> 'success', 'random_number'=> $randomString);
                            echo json_encode($response); exit;
                        }
                    } else {
                        $response = array('status'=>'error', 'order_number_php_error'=> 'Please enter correct order number');
                    }
                    echo json_encode($response); exit;
                }
            }
        } else {
            $this->load->view('order/order_number_cpl');
        }
    }

    public function uploadBorrowerDocumentToResware($document_name, $orderDetails, $binaryData)
    {
        $this->load->model('order/document');
        $this->load->library('order/resware');
        $this->load->model('order/apiLogs');
        $fileSize = filesize('./uploads/borrower-information/'.$document_name);
        $documentData = array(
            'document_name' => $document_name,
            'original_document_name' => $document_name,
            'document_type_id' => 1037,
            'document_size' => $fileSize,
            'user_id' => 0,
            'order_id' => $orderDetails['order_id'],
            'description' => 'Statement Of Information Document',
            'is_sync' => 1,
            'is_prelim_document' => 0,
            'is_cpl_doc' => 0,
            'is_borrower_doc' => 1,
        );
        $documentId = $this->document->insert($documentData);
        $endPoint = 'files/'.$orderDetails['file_id'].'/documents';
        $documentApiData = array(           
            'DocumentName' => $document_name,
            'DocumentType' => array(
                'DocumentTypeID' => 1037,
            ),
            'Description' => 'Statement Of Information Document',
            'InternalOnly' => false,
            'DocumentBody' => $binaryData
        );
        $document_api_data = json_encode($documentApiData, JSON_UNESCAPED_SLASHES);

        
        $orderUser =  $this->home_model->get_user(array('id' => $orderDetails['customer_id']));
        $user_data['email'] = $orderUser['email_address'];
        $user_data['password'] = $orderUser['random_password'];
        $user_data['from_mail'] = 1;
        
        $logid = $this->apiLogs->syncLogs(0, 'resware', 'create_document', env('RESWARE_ORDER_API').$endPoint, $documentApiData, array(), $orderDetails['order_id'], 0);
        $result = $this->resware->make_request('POST', $endPoint, $document_api_data, $user_data);
        $this->apiLogs->syncLogs(0, 'resware', 'create_document', env('RESWARE_ORDER_API').$endPoint, $documentApiData, $result, $orderDetails['order_id'], $logid);
        $res = json_decode($result);
        $this->document->update(array('api_document_id' => $res->Document->DocumentID), array('id' => $documentId));
    }

    public function getSearchResult($address, $locale)
    {
        $data=new stdClass();
        $data->Address= $address;
        $data->LastLine= (string) $locale;
        $data->ClientReference= '<CustCompFilter><CompNum>8</CompNum><MonthsBack>12</MonthsBack></CustCompFilter>';
        $data->OwnerName= '';
        $data->key= env('BLACK_KNIGHT_KEY');
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
                $rdata->key= env('BLACK_KNIGHT_KEY');
                $requestUrl = $reportUrl.http_build_query($rdata);
                $reportFile = file_get_contents($requestUrl,false,$context);
                $reportData = simplexml_load_string($reportFile);
                $response = json_encode($reportData);
                $details = json_decode($response,TRUE);

                $property_info['property_type'] = isset($details['PropertyProfile']['PropertyCharacteristics']['UseCode']) && !empty($details['PropertyProfile']['PropertyCharacteristics']['UseCode']) ? $details['PropertyProfile']['PropertyCharacteristics']['UseCode'] : '';
                $property_info['legaldescription'] = isset($details['PropertyProfile']['LegalDescriptionInfo']['LegalBriefDescription']) && !empty($details['PropertyProfile']['LegalDescriptionInfo']['LegalBriefDescription']) ? $details['PropertyProfile']['LegalDescriptionInfo']['LegalBriefDescription'] : '';
                $property_info['apn'] = isset($details['PropertyProfile']['APN']) && !empty($details['PropertyProfile']['APN']) ? $details['PropertyProfile']['APN'] : '';

                $property_info['unit_no'] = isset($details['PropertyProfile']['SiteUnit']) && !empty($details['PropertyProfile']['SiteUnit']) ? $details['PropertyProfile']['SiteUnit'] : '';
                
                $property_info['fips'] = isset($details['SubjectValueInfo']['FIPS']) && !empty($details['SubjectValueInfo']['FIPS']) ? $details['SubjectValueInfo']['FIPS'] : '';

                $primaryOwner = isset($details['PropertyProfile']['PrimaryOwnerName']) && !empty($details['PropertyProfile']['PrimaryOwnerName']) ? $details['PropertyProfile']['PrimaryOwnerName'] : '';
                $secondaryOwner = isset($details['PropertyProfile']['SecondaryOwnerName']) && !empty($details['PropertyProfile']['SecondaryOwnerName']) ? $details['PropertyProfile']['SecondaryOwnerName'] : '';
                $property_info['primary_owner'] = $primaryOwner;
                $property_info['secondary_owner'] = $secondaryOwner;
            }
        }

        return $property_info;
    }

    public function tpCreateService($methodId,$random_number,$propertyData=array(), $userdata = array())
    {
        /* Insert into table */        
        if($random_number)
        {
            $session_id = 'tp_api_id_'.$random_number;
        
            $con =  array(
                        'where' => array(
                            'session_id' => $session_id
                        ),
                        'returnType' => 'count'
                    );

            $prevCount = $this->titlePointData->gettitlePointDetails($con);
            if($prevCount < 0)
            {
                $tpData = array(
                        'session_id' => $session_id,
                    );
                $tpId = $this->titlePointData->insert($tpData);
            }
            
        }        
        /* Insert into table */

        $requestParams = array(
            'userID' => env('TP_USERNAME'),
            'password' => env('TP_PASSWORD'),
            'orderNo' =>  '',
            'customerRef'=>  '',
            'company'=>  '',
            'department'=>  '',
            'titleOfficer'=>  '',
            'orderComment'=>  '',
            'starterRemarks'=>  '',
        );

        if($methodId == 4)
        {
            $fipsCode = isset($propertyData['fipsCode']) && !empty($propertyData['fipsCode']) ? $propertyData['fipsCode'] : '';
            $address = isset($propertyData['address']) && !empty($propertyData['address']) ? $propertyData['address'] : '';
            $city = isset($propertyData['city']) && !empty($propertyData['city']) ? $propertyData['city'] : '';
            $unit_no = isset($propertyData['unit_no']) && !empty($propertyData['unit_no']) ? $propertyData['unit_no'] : '';
            $apn = isset($propertyData['apn']) && !empty($propertyData['apn']) ? $propertyData['apn'] : '';
            if($unit_no)
            {
                $unitinfo =  'UnitNumber '.$unit_no.', '; 
            }

            $requestParams['serviceType'] = env('SERVICE_TYPE');

            $requestParams['parameters'] = 'Address1='.$address.';City='.$city.';Pin='.$apn.';LvLookup=Address;LvLookupValue='.$address.', '.$unitinfo.$city.';LvReportFormat=LV;IncludeTaxAssessor=true';
            $requestParams['fipsCode'] = $fipsCode;
            $requestUrl= env('TP_CREATE_SERVICE_ENDPOINT');
            $request_type= 'sales_create_service_4';
        }
        else if($methodId == 3)
        {
            $apn = isset($propertyData['apn']) && !empty($propertyData['apn']) ? $propertyData['apn'] : '';
            $apn = str_replace('0000', '0-000', $apn);

            $state = isset($propertyData['state']) && !empty($propertyData['state']) ? $propertyData['state'] : '';

            $county = isset($propertyData['county']) && !empty($propertyData['county']) ? $propertyData['county'] : '';

            $requestParams['serviceType'] = env('TAX_SEARCH_SERVICE_TYPE');

            $requestParams['parameters'] = 'Tax.APN='.$apn.';General.AutoSearchTaxes=true;General.AutoSearchProperty=false';
            $requestParams['state'] = $state;
            $requestParams['county'] = $county;
            $requestUrl= env('TP_TAX_INSTRUMENT_CREATE_SERVICE_ENDPOINT');
            $request_type= 'sales_create_service_3';
        }
        $request = $requestUrl.http_build_query($requestParams);

        $logid = $this->apiLogs->syncLogs(0, 'titlepoint', $request_type, $request, $requestParams, array(), $random_number, 0);

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

        $this->apiLogs->syncLogs(0, 'titlepoint', $request_type, $request, $requestParams, $result, $random_number, $logid);
        $session_id = 'tp_api_id_'.$random_number;
        $con =  array(
                    'where' => array(
                        'session_id' => $session_id
                    ),
                    'returnType' => 'count'
                );
        $prevCount = $this->titlePointData->gettitlePointDetails($con);

        if(isset($result) && empty($result))
        {
            $tpData =   array(
                'cs4_message' => 'Failed',
            );
            
            
            if($prevCount > 0) 
            {
                $session_id = 'tp_api_id_'.$random_number;
                $condition = array(
                    'session_id' => $session_id
                );              
                $this->titlePointData->update($tpData,$condition);
            }
            else
            {
                $tpData['session_id'] = 'tp_api_id_'.$random_number;
                

                $tpId = $this->titlePointData->insert($tpData);
            }
        }
        else
        {
            
            $responseStatus = isset($result['ReturnStatus']) && !empty($result['ReturnStatus']) ? $result['ReturnStatus'] : '';
        
            if($methodId == 4)
            {
                if($responseStatus == 'Success')
                {
                    $requestId = isset($result['RequestID']) && !empty($result['RequestID']) ? $result['RequestID'] : '';
                    $tpData =   array(
                                    'cs4_request_id' => $requestId,
                                );

                    if ($prevCount > 0) 
                    {
                        $condition = array(
                            'session_id' => $session_id
                        );              
                        $this->titlePointData->update($tpData,$condition);
                    }
                    else
                    {
                        $tpData['session_id'] = 'tp_api_id_'.$random_number;
                        

                        $tpId = $this->titlePointData->insert($tpData);
                    }

                    /* Get Request Summary */
                    $response = $this->tpGetRequestSummaries(4,$requestId, $random_number);
                    /* Get Request Summary */
                }
                else
                {
                    $error = isset($result['ReturnErrors']['ReturnError']['ErrorDescription']) && !empty($result['ReturnErrors']['ReturnError']['ErrorDescription']) ? $result['ReturnErrors']['ReturnError']['ErrorDescription'] : '';
                    $this->addLogs($methodId,$responseStatus,'',$error,$random_number);
                }
                
            }
            if($methodId == 3)
            {
                if($responseStatus == 'Success')
                {
                    $requestId = isset($result['RequestID']) && !empty($result['RequestID']) ? $result['RequestID'] : '';

                    $tpData =   array(
                                    'cs3_request_id' => $requestId,
                                );

                    if($prevCount > 0) 
                    {
                        $condition = array(
                            'session_id' => $session_id
                        );              
                        $this->titlePointData->update($tpData,$condition);
                    }
                    else
                    {
                        $tpData['session_id'] = 'tp_api_id_'.$random_number;
                        

                        $tpId = $this->titlePointData->insert($tpData);
                    }

                    /* Get Request Summary */
                    $response = $this->tpGetRequestSummaries(3,$requestId, $random_number);
                    /* Get Request Summary */
                }
                else
                {
                    $error = isset($result['ReturnErrors']['ReturnError']['ErrorDescription']) && !empty($result['ReturnErrors']['ReturnError']['ErrorDescription']) ? $result['ReturnErrors']['ReturnError']['ErrorDescription'] : '';
                    $this->addLogs($methodId,$responseStatus,'',$error,$random_number);
                }
            }
        }
    }

    public function addLogs($methodId,$returnStatus,$status='',$error,$random_number)
    {
        if($returnStatus == 'Failed')
        {
            if($methodId == 4)
            {
                $tpData =   array(
                                'cs4_message' => $error,
                            );
            }
            elseif($methodId == 3)
            {
                $tpData =   array(
                                'cs3_message' => $error,
                            );
            }
            
        }
        else
        {
            if($methodId == 4)
            {
                $tpData =   array(
                                'cs4_message' => $status,
                            );
            }
            elseif($methodId == 3)
            {
                $tpData =   array(
                                'cs3_message' => $status,
                            );
            }
        }

        $session_id = 'tp_api_id_'.$random_number;
        $con =  array(
                    'where' => array(
                        'session_id' => $session_id
                    ),
                    'returnType' => 'count'
                );
        $prevCount = $this->titlePointData->gettitlePointDetails($con);

        if ($prevCount > 0) 
        {
            $condition = array(
                'session_id' => $session_id
            );              
            $this->titlePointData->update($tpData,$condition);
        }
        else
        {
            $tpData['session_id'] = 'tp_api_id_'.$random_number;            

            $tpId = $this->titlePointData->insert($tpData);
        }
        
    }

    public function tpGetRequestSummaries($methodId, $requestId, $random_number)
    {
        $requestParams = array(
                            'userID' => env('TP_USERNAME'),
                            'password' => env('TP_PASSWORD'),
                            'company'=>  '',
                            'department'=>  '',
                            'titleOfficer'=>  '',
                            'requestId'=>  $requestId,
                            'maxWaitSeconds'=>  20
                        );

        $request = env('TP_REQUEST_SUMMARY_ENDPOINT').http_build_query($requestParams);

        $logid = $this->apiLogs->syncLogs(0, 'titlepoint', 'get_request_summary_'.$methodId, $request, $requestParams, array(), $random_number, 0);

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

        $this->apiLogs->syncLogs(0, 'titlepoint', 'sales_get_request_summary_'.$methodId, $request, $requestParams, $result, $random_number, $logid);

        $session_id = 'tp_api_id_'.$random_number;

        $con =  array(
                    'where' => array(
                        'session_id' => $session_id
                    ),
                    'returnType' => 'count'
                );
        $prevCount = $this->titlePointData->gettitlePointDetails($con);

        if(isset($result) && empty($result))
        {
            $tpData =   array(
                'cs4_message' => 'Failed',
            );

            if($prevCount > 0) 
            {
                $condition = array(
                    'session_id' => $session_id
                );              
                $this->titlePointData->update($tpData,$condition);
            }
            else
            {
                $tpData['session_id'] = 'tp_api_id_'.$random_number;                

                $tpId = $this->titlePointData->insert($tpData);
            }
        }
        else
        {
            $responseStatus = isset($result['ReturnStatus']) && !empty($result['ReturnStatus']) ? $result['ReturnStatus'] : '';

            $session_data = array();

            if($methodId == 4)
            {
                if($responseStatus == 'Success')
                {
                    $status = isset($result['RequestSummaries']['RequestSummary']['Status']) && !empty($result['RequestSummaries']['RequestSummary']['Status']) ? $result['RequestSummaries']['RequestSummary']['Status'] : '';
                    
                    if($status == 'Complete')
                    {
                        $resultId = isset($result['RequestSummaries']['RequestSummary']['Order']['Services']['Service']['ThumbNails']['ResultThumbNail'][0]['ID']) && !empty($result['RequestSummaries']['RequestSummary']['Order']['Services']['Service']['ThumbNails']['ResultThumbNail'][0]['ID']) ? $result['RequestSummaries']['RequestSummary']['Order']['Services']['Service']['ThumbNails']['ResultThumbNail'][0]['ID'] : ''; 
                        $serviceId = isset($result['RequestSummaries']['RequestSummary']['Order']['Services']['Service']['ID']) && !empty($result['RequestSummaries']['RequestSummary']['Order']['Services']['Service']['ID']) ? $result['RequestSummaries']['RequestSummary']['Order']['Services']['Service']['ID'] : '';
                        
                        $tpData =   array(
                            'cs4_result_id' => $resultId,
                            'cs4_service_id' => $serviceId,
                        );
                    }
                    else
                    {
                        $tpData =   array(
                            'cs4_message' => $status,
                        );
                    }

                    if($prevCount > 0) 
                    {
                        $condition = array(
                            'session_id' => $session_id
                        );              
                        $this->titlePointData->update($tpData,$condition);
                    }
                    else
                    {
                        $tpData['session_id'] = 'tp_api_id_'.$random_number;
                        

                        $tpId = $this->titlePointData->insert($tpData);
                    }

                    if($status == 'Complete')
                    {
                        $this->tpGetResultById(4,$resultId,$random_number);
                    }

                }
                else
                {
                    $error = isset($result['ReturnErrors']['ReturnError']['ErrorDescription']) && !empty($result['ReturnErrors']['ReturnError']['ErrorDescription']) ? $result['ReturnErrors']['ReturnError']['ErrorDescription'] : '';
                    $this->addLogs($methodId,$responseStatus,'',$error,$random_number);
                }
            }
            if($methodId == 3)
            {
                if($responseStatus == 'Success')
                {
                    $status = isset($result['RequestSummaries']['RequestSummary']['Status']) && !empty($result['RequestSummaries']['RequestSummary']['Status']) ? $result['RequestSummaries']['RequestSummary']['Status'] : '';

                    if($status == 'Complete')
                    {
                        $resultId = isset($result['RequestSummaries']['RequestSummary']['Order']['Services']['Service']['ThumbNails']['ResultThumbNail']['ID']) && !empty($result['RequestSummaries']['RequestSummary']['Order']['Services']['Service']['ThumbNails']['ResultThumbNail']['ID']) ? $result['RequestSummaries']['RequestSummary']['Order']['Services']['Service']['ThumbNails']['ResultThumbNail']['ID'] : '';
                        $serviceId = isset($result['RequestSummaries']['RequestSummary']['Order']['Services']['Service']['ID']) && !empty($result['RequestSummaries']['RequestSummary']['Order']['Services']['Service']['ID']) ? $result['RequestSummaries']['RequestSummary']['Order']['Services']['Service']['ID'] : '';
                        $tpData =   array(
                            'cs3_result_id' => $resultId,
                            'cs3_service_id' => $serviceId,
                        );
                    }
                    else
                    {
                        $tpData =   array(
                            'cs3_message' => $status,
                        );
                    }
                    
                    
                    if($prevCount > 0) 
                    {
                        $condition = array(
                            'session_id' => $session_id
                        );              
                        $this->titlePointData->update($tpData,$condition);
                    }
                    else
                    {
                        $tpData['session_id'] = 'tp_api_id_'.$random_number;                  

                        $tpId = $this->titlePointData->insert($tpData);
                    }
                    if($status == 'Complete')
                    {
                        $this->tpGetResultById(3,$resultId,$random_number);
                    }
                }
                else
                {
                    $error = isset($result['ReturnErrors']['ReturnError']['ErrorDescription']) && !empty($result['ReturnErrors']['ReturnError']['ErrorDescription']) ? $result['ReturnErrors']['ReturnError']['ErrorDescription'] : '';
                    $this->addLogs($methodId,$responseStatus,'',$error,$random_number);
                }
            }
        }
    }

    public function tpGetResultById($methodId,$resultId, $random_number)
    {
        $requestParams = array(
                            'userID' => env('TP_USERNAME'),
                            'password' => env('TP_PASSWORD'),
                            'company'=>  '',
                            'department'=>  '',
                            'titleOfficer'=>  '',
                            'resultID'=>  $resultId
                        );

        $resultUrl = env('TP_GET_RESULT_BY_ID');

        if($methodId == 3)
        {
            $requestParams['requestingTPXML'] = 'true';
            $resultUrl = env('TP_GET_RESULT_BY_ID_3');
        }

        $request = $resultUrl.http_build_query($requestParams);

        $logid = $this->apiLogs->syncLogs(0, 'titlepoint', 'sales_get_result_by_id_'.$methodId, $request, $requestParams, array(), $random_number, 0);

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

        $this->apiLogs->syncLogs(0, 'titlepoint', 'sales_get_result_by_id_'.$methodId, $request, $requestParams, $result, $random_number, $logid);

        $session_id = 'tp_api_id_'.$random_number;
        
        $con =  array(
                    'where' => array(
                        'session_id' => $session_id
                    ),
                    'returnType' => 'count'
                );
        $prevCount = $this->titlePointData->gettitlePointDetails($con);

        if(isset($result) && empty($result))
        {
            $tpData =   array(
                'cs4_message' => 'Failed',
            );

            if($prevCount > 0) 
            {
                $condition = array(
                    'session_id' => $session_id
                );              
                $this->titlePointData->update($tpData,$condition);
            }
            else
            {
                $tpData['session_id'] = 'tp_api_id_'.$random_number;                

                $tpId = $this->titlePointData->insert($tpData);
            }
        }
        else
        {
            $responseStatus = isset($result['ReturnStatus']) && !empty($result['ReturnStatus']) ? $result['ReturnStatus'] : '';
            $session_data = array();
            
            if($methodId == 4)
            {
                if($responseStatus == 'Success')
                {
                    $briefLegal = isset($result['Result']['BriefLegal']) && !empty($result['Result']['BriefLegal']) ? $result['Result']['BriefLegal'] : '';
                    
                    $vesting = isset($result['Result']['Vesting']) && !empty($result['Result']['Vesting']) ? $result['Result']['Vesting'] : '';

                    $fips = isset($result['Result']['Fips']) && !empty($result['Result']['Fips']) ? $result['Result']['Fips'] : '';
                    
                    $legal_vesting_info = isset($result['Result']['LvDeeds']['LegalAndVesting2DeedInfo']) && !empty($result['Result']['LvDeeds']['LegalAndVesting2DeedInfo']) ? $result['Result']['LvDeeds']['LegalAndVesting2DeedInfo'] : array();
                    
                    if (count($legal_vesting_info) == count($legal_vesting_info, COUNT_RECURSIVE))
                    {
                        $docType = isset($result['Result']['LvDeeds']['LegalAndVesting2DeedInfo']['DocType']) && !empty($result['Result']['LvDeeds']['LegalAndVesting2DeedInfo']['DocType']) ? $result['Result']['LvDeeds']['LegalAndVesting2DeedInfo']['DocType'] : '';
                        $docType = strtolower($docType);

                        if($docType == 'grant deed' || $docType == 'intrafamily transfer & dissolution' || $docType == 'quit claim deed' || $docType == 'intra-family transfer or dissolution')
                        {
                            $instrumentNumber = isset($result['Result']['LvDeeds']['LegalAndVesting2DeedInfo']['InstrumentNumber']) && !empty($result['Result']['LvDeeds']['LegalAndVesting2DeedInfo']['InstrumentNumber']) ? $result['Result']['LvDeeds']['LegalAndVesting2DeedInfo']['InstrumentNumber'] : '';
                            $recordedDate = isset($result['Result']['LvDeeds']['LegalAndVesting2DeedInfo']['RecordedDate']) && !empty($result['Result']['LvDeeds']['LegalAndVesting2DeedInfo']['RecordedDate']) ? $result['Result']['LvDeeds']['LegalAndVesting2DeedInfo']['RecordedDate'] : '';
                        }
                        
                    }
                    else
                    {
                        foreach ($legal_vesting_info as $key => $value) 
                        {
                            $docType = isset($value['DocType']) && !empty($value['DocType']) ? $value['DocType'] : '';
                            $docType = strtolower($docType);
                            
                            if($docType == 'grant deed' || $docType == 'intrafamily transfer & dissolution' || $docType == 'quit claim deed' || $docType == 'intra-family transfer or dissolution')
                            {
                                $instrumentNumber = isset($value['InstrumentNumber']) && !empty($value['InstrumentNumber']) ? $value['InstrumentNumber'] : '';
                                $recordedDate = isset($value['RecordedDate']) && !empty($value['RecordedDate']) ? $value['RecordedDate'] : '';
                                break;
                            }
                        }                   
                    }
                    $status = isset($result['Result']['Status']) && !empty($result['Result']['Status']) ? $result['Result']['Status'] : '';

                    $tpData =   array(
                        'legal_description' => $briefLegal,
                        'vesting_information' => $vesting,
                        'cs4_instrument_no' => $instrumentNumber,
                        'cs4_recorded_date' => $recordedDate,
                        'grant_deed_type' => $docType,
                        'fips' => $fips,
                        // 'cs4_result_id_status' => $status,
                    );

                    if($prevCount > 0) 
                    {
                        $condition = array(
                            'session_id' => $session_id
                        );              
                        $this->titlePointData->update($tpData,$condition);
                    }
                    else
                    {
                        $tpData['session_id'] = 'tp_api_id_'.$random_number;
                        

                        $tpId = $this->titlePointData->insert($tpData);

                    }
                    $this->addLogs($methodId,$responseStatus,$status,$error,$random_number);
                }
                else
                {
                    $error = isset($result['ReturnErrors']['ReturnError']['ErrorDescription']) && !empty($result['ReturnErrors']['ReturnError']['ErrorDescription']) ? $result['ReturnErrors']['ReturnError']['ErrorDescription'] : '';
                    $this->addLogs($methodId,$responseStatus,'',$error,$random_number);
                }
            }
            if($methodId == 3)
            {
                if($responseStatus == 'Success')
                {
                    $firstInstallment = $secondInstallment = array();
                    if(isset($result['Result']['TaxReport']['Installments']['Item'][0]) && !empty($result['Result']['TaxReport']['Installments']['Item'][0]))
                    {
                        $firstInstallment = $result['Result']['TaxReport']['Installments']['Item'][0];                  
                    }

                    if(isset($result['Result']['TaxReport']['Installments']['Item'][1]) && !empty($result['Result']['TaxReport']['Installments']['Item'][1]))
                    {
                        $secondInstallment = $result['Result']['TaxReport']['Installments']['Item'][1];         
                    }
                    
                    $status = isset($result['Result']['TaxReport']['Status']) && !empty($result['Result']['TaxReport']['Status']) ? $result['Result']['TaxReport']['Status'] : '';
                    if($status == 'Success')
                    {
                        $message = 'Success';
                    }
                    else
                    {
                        $message = isset($result['Result']['TaxReport']['WarningMessage']) && !empty($result['Result']['TaxReport']['WarningMessage']) ? $result['Result']['TaxReport']['WarningMessage'] : '';
                    }
                    
                    $tpData =   array(
                        'first_installment' => json_encode($firstInstallment),
                        'second_installment' => json_encode($secondInstallment),
                    );

                    if($prevCount > 0) 
                    {
                        $condition = array(
                            'session_id' => $session_id
                        );              
                        $this->titlePointData->update($tpData,$condition);
                    }
                    else
                    {
                        $tpData['session_id'] = 'tp_api_id_'.$random_number;                 

                        $tpId = $this->titlePointData->insert($tpData);
                    }
                    $this->addLogs($methodId,$responseStatus,$message,$error,$random_number);
                }
                else
                {
                    $error = isset($result['ReturnErrors']['ReturnError']['ErrorDescription']) && !empty($result['ReturnErrors']['ReturnError']['ErrorDescription']) ? $result['ReturnErrors']['ReturnError']['ErrorDescription'] : '';
                    $this->addLogs($methodId,$responseStatus,'',$error,$random_number);
                }
            }
        }
    }

    public function getOrderInfo($FileIdOrRandomNum)
    {
        $this->db->select('*')
            ->from('order_details');
        $this->db->group_start()
            ->where("file_id", $FileIdOrRandomNum)
            ->or_where('random_number',$FileIdOrRandomNum)
            ->group_end();    
        $query = $this->db->get();
        if ($query->num_rows() > 0)  {
            return $query->result_array();
        } else {
            return array();
        }         
    }
}