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
        $fileId = $this->uri->segment(2);    
        $data['title'] = 'Smart Dashboard | Pacific Coast Title Company';
        $data['mail_dashboard'] = 1;
        $orderDetails = $this->order->get_order_details($fileId);
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
        $fileId = $this->uri->segment(2);    
        $data['title'] = 'Smart Dashboard | Pacific Coast Title Company';
        $data['mail_dashboard'] = 1;

        $orderDetails = $this->order->get_order_details($fileId);
        
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
            $condition = array(
                'where' => array(
                    'transaction_type' => 'loan',
                    'status' => 1
                )
            );
        }

        $salesAmount = isset($orderDetails['sales_amount']) && !empty($orderDetails['sales_amount']) ? $orderDetails['sales_amount'] : '';

        if(isset($salesAmount) && !empty($salesAmount))
        {
            $request['SalesPrice'] = $salesAmount;
            $condition = array(
                'where' => array(
                    'transaction_type' => 'sale',
                    'status' => 1
                )
            );
        }

        $fees_data = json_encode($request);
        $this->load->library('order/resware');


        $endPoint = 'estimates/closingfees';

        $logid = $this->apiLogs->syncLogs('', 'resware', 'mail_get_fees', env('RESWARE_ORDER_API').$endPoint, $fees_data, array(), $orderId, 0);
        $result = $this->resware->make_request('POST', $endPoint, $fees_data,$loginData);
        $this->apiLogs->syncLogs($userdata['id'], 'resware', 'mail_get_fees', env('RESWARE_ORDER_API').$endPoint, $fees_data, $result, $orderId, $logid);

        $fees = array();
        if(isset($result) && !empty($result))
        {
            $response = json_decode($result,TRUE);
            $closing_fee_estimate_id = isset($response['ClosingFeeEstimate']['ClosingFeeEstimateID']) && !empty($response['ClosingFeeEstimate']['ClosingFeeEstimateID']) ? $response['ClosingFeeEstimate']['ClosingFeeEstimateID'] : '';

            if(isset($response['ClosingFeeEstimate']['HUDFees']) && !empty(isset($response['ClosingFeeEstimate']['HUDFees'])))
            {
                
                foreach ($response['ClosingFeeEstimate']['HUDFees'] as $key => $value) 
                {
                    $fees['HUDFees'][$key] = array('amount' => $value['Amount'], 'description' => $value['Description']);
                }
            }

            if(isset($response['ClosingFeeEstimate']['GFE']) && !empty(isset($response['ClosingFeeEstimate']['GFE'])))
            {
                foreach ($response['ClosingFeeEstimate']['GFE'] as $k => $v) 
                {
                    $fees['GFE'][$k] = array('amount' => $v['Amount'], 'description' => $v['Description']);
                }
            }

            if(isset($response['ClosingFeeEstimate']['Premiums']) && !empty(isset($response['ClosingFeeEstimate']['Premiums'])))
            {
                foreach ($response['ClosingFeeEstimate']['Premiums'] as $k => $v) 
                {
                    $fees['Premiums'][] = array('amount' => $v, 'description' => $k);
                }
            }
        }
        $feesInfo = $this->fees_model->get_rows($condition);
        if(isset($feesInfo) && !empty(isset($feesInfo)))
        {
            foreach ($feesInfo as $k => $v) 
            {
                $fees['AdditionalFees'][] = array('amount' => $v['value'], 'description' => $v['name']);
            }
        }
        $data['fees'] = $fees;
        $data['order_number'] = isset($orderDetails['file_number']) && !empty($orderDetails['file_number']) ? $orderDetails['file_number'] : '';
        $data['full_address'] = isset($orderDetails['full_address']) && !empty($orderDetails['full_address']) ? $orderDetails['full_address'] : '';
        $data['sales_amount'] = isset($orderDetails['sales_amount']) && !empty($orderDetails['sales_amount']) ? $orderDetails['sales_amount'] : '';
        $data['loan_amount'] = isset($orderDetails['loan_amount']) && !empty($orderDetails['loan_amount']) ? $orderDetails['loan_amount'] : '';
        /*if(isset($orderDetails['sales_amount']) && !empty($orderDetails['sales_amount']))
        {
            $productType = 'Residential: Sales: Purchase';
        }
        if(isset($orderDetails['loan_amount']) && !empty($orderDetails['loan_amount']))
        {
            $productType = 'Residential: Loan: Refinance';
        }*/

        $data['productType'] = isset($orderDetails['product_type']) && !empty($orderDetails['product_type']) ? $orderDetails['product_type'] : '';
        $data['closing_fee_estimate_id'] = $closing_fee_estimate_id;
        
        

        /*$this->load->model('order/fee');
        $feesData = array(
            'closing_fee_estimate_id' => $closing_fee_estimate_id,
            'user_id' => $userdata['id'],
            'order_id' => $orderId
        );

        $feeId = $this->fee->insert($feesData);*/

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
        $primary_first_name = $this->input->post('primary_first_name');
        $primary_last_name = $this->input->post('primary_last_name');
        $primary_owner = $primary_first_name." ".$primary_last_name;
        $secondaryOwner = $first_name." ".$last_name;
        $name = explode(" ",$this->input->post('LenderName'));  
        $editFlag = $this->input->post('editFlag');
        $orderDetails = $this->order->get_order_details($file_id);
        $cplApi = $this->input->post('cpl_api');

        $lender_details = array(
            'first_name'    => $name[0],
            'last_name'  => !empty($name[1]) ? $name[1] : '',
            'telephone_no'  => !empty($this->input->post('LenderTelephone')) ? $this->input->post('LenderTelephone') : "",
            'email_address' => !empty($this->input->post('LenderEmailAddress')) ? $this->input->post('LenderEmailAddress') : "",
            'company_name'  => !empty($this->input->post('LenderCompany')) ? $this->input->post('LenderCompany') : "",
            'street_address' => !empty($this->input->post('LenderAddress')) ? $this->input->post('LenderAddress') : "",
            'city'  => !empty($this->input->post('LenderCity')) ? $this->input->post('LenderCity') : "",
            'zip_code'  => !empty($this->input->post('LenderZipcode')) ? $this->input->post('LenderZipcode') : ""
        );
        $condition = array(
            'id' => $LenderId
        );
        $orderUser =  $this->home_model->get_user(array('id' => $orderDetails['customer_id']));
		$this->home_model->update($lender_details, $condition, 'customer_basic_details');
		
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

        if ($orderDetails['sales_amount'] > 0) { 
            if ($orderUser['is_escrow'] == 1) {
                $propertyDetails = array('escrow_lender_id' => $LenderId);
            } else {
                $propertyDetails = array('cpl_lender_id' => $LenderId);
            }
            
            $this->home_model->update(array('loan_amount' => $loan_amount, 'loan_number' => $loan_number, 'borrower' => $primary_owner, 'secondary_borrower' => $secondaryOwner), array('id' => $orderDetails['transaction_id']), 'transaction_details');
            if ($cplApi == 'fnf') {
                $propertyDetails['buyer_agent_id'] = $this->input->post('agent_id');
                $this->home_model->update(array('fnf_agent_id' => $this->input->post('branch')), array('id' => $orderDetails['order_id']), 'order_details');
            }
            $this->home_model->update($propertyDetails, array('id' => $orderDetails['property_id']), 'property_details');
        } else {
            if ($orderUser['is_escrow'] == 1) {
                $propertyDetails = array('escrow_lender_id' => $LenderId, 'primary_owner' => $primary_owner, 'secondary_owner' => $secondaryOwner);
            } else {
                $propertyDetails = array('cpl_lender_id' => $LenderId, 'primary_owner' => $primary_owner, 'secondary_owner' => $secondaryOwner);
            }
            $this->home_model->update(array('loan_amount' => $loan_amount, 'loan_number' => $loan_number), array('id' => $orderDetails['transaction_id']), 'transaction_details');
            
            if ($cplApi == 'fnf') {
                $propertyDetails['buyer_agent_id'] = $this->input->post('agent_id');
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
        $orderDetails = $this->order->get_order_details($fileId);
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
            redirect(base_url().'generate-cpl/'.$fileId);
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
			redirect(base_url().'generate-cpl/'.$fileId);
        } else {
            $errors[] = $getCPLFormNameResponse['error'];
            $data = array(
                "errors" =>  $errors,
                "success" => $success
            );
            $this->session->set_userdata($data);
            redirect(base_url().'generate-cpl/'.$fileId);
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
        $orderDetails = $this->order->get_order_details($fileId);
        $res = array();

        $resToken = $this->order->get_token();
        $orderUser =  $this->home_model->get_user(array('id' => $orderDetails['customer_id']));

        if ($resToken === false) {
            $resToken = $this->westcor->createToken($orderDetails['order_id']);
        } 

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
            $sellers[] = array (
                'NameID' =>  $orderDetails['westcor_seller_id'] ? $orderDetails['westcor_seller_id'] : 0,
                'Last' => $primary_owner[1],
                'First' => $primary_owner[0],
                'NameType' => 2,
                'JoiningPhrase' => 'single',
                'tvid' => 0,
                'Sequence' => 1,
                'City' => $orderDetails['property_city'] ? $orderDetails['property_city'] : trim($propertyDetail[2]),
                'State' => $orderDetails['property_state'] ? $orderDetails['property_state'] : trim($propertyDetail[3]),
                'Zip' => $orderDetails['property_zip'] ? $orderDetails['property_zip'] : trim($propertyDetail[4]),
                'Address' => $orderDetails['address'] ? $orderDetails['address'] : trim($propertyDetail[0])." ".trim($propertyDetail[1]),
            );
            if(!empty($secondary_owner)) {
                $sellers[] = array (
                    'NameID' => $orderDetails['westcor_secondary_seller_id'] ? $orderDetails['westcor_secondary_seller_id'] : 0,
                    'Last' => $secondary_owner[1],
                    'First' => $secondary_owner[0],
                    'NameType' => 1,
                    'JoiningPhrase' => 'single',
                    'tvid' => 0,
                    'Sequence' => 2,
                    'City' => $orderDetails['property_city'] ? $orderDetails['property_city'] : trim($propertyDetail[2]),
                    'State' => $orderDetails['property_state'] ? $orderDetails['property_state'] : trim($propertyDetail[3]),
                    'Zip' => $orderDetails['property_zip'] ? $orderDetails['property_zip'] : trim($propertyDetail[4]),
                    'Address' => $orderDetails['address'] ? $orderDetails['address'] : trim($propertyDetail[0])." ".trim($propertyDetail[1])
                );  
            }
            $purchase_price = $orderDetails['sales_amount'];
            $buyers = array();

            if (!empty($orderDetails['borrower'])) {
                $primary_owner = explode(' ', $orderDetails['borrower']);
                $buyers[] = array (
                    'NameID' => $orderDetails['westcor_secondary_buyer_id'] ? $orderDetails['westcor_secondary_buyer_id'] : 0,
                    'Last' => $primary_owner[1],
                    'First' => $primary_owner[0],
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
            if (!empty($orderDetails['secondary_borrower'])) {
                $secondary_owner = explode(' ', $orderDetails['secondary_borrower']);
                $buyers[] = array (
                    'NameID' => $orderDetails['westcor_secondary_buyer_id'] ? $orderDetails['westcor_secondary_buyer_id'] : 0,
                    'Last' => $secondary_owner[1],
                    'First' => $secondary_owner[0],
                    'NameType' => 1,
                    'JoiningPhrase' => 'single',
                    'tvid' => 0,
                    'Sequence' => 2,
                    'City' => null,
                    'State' => null,
                    'Zip' => null,
                    'Address' => null
                );  
            } 
        } else {
            $buyers[] = array (
                'NameID' => $orderDetails['westcor_buyer_id'] ? $orderDetails['westcor_buyer_id'] : 0,
                'Last' => $primary_owner[1],
                'First' => $primary_owner[0],
                'NameType' => 1,
                'JoiningPhrase' => 'single',
                'tvid' => 0,
                'Sequence' => 1,
                'City' => $orderDetails['property_city'] ? $orderDetails['property_city'] : trim($propertyDetail[2]),
                'State' => $orderDetails['property_state'] ? $orderDetails['property_state'] : trim($propertyDetail[3]),
                'Zip' => $orderDetails['property_zip'] ? $orderDetails['property_zip'] : trim($propertyDetail[4]),
                'Address' => $orderDetails['address'] ? $orderDetails['address'] : trim($propertyDetail[0])." ".trim($propertyDetail[1])
            );
            if(!empty($secondary_owner)) {
                $buyers[] = array (
                    'NameID' => $orderDetails['westcor_secondary_buyer_id'] ? $orderDetails['westcor_secondary_buyer_id'] : 0,
                    'Last' => $secondary_owner[1],
                    'First' => $secondary_owner[0],
                    'NameType' => 1,
                    'JoiningPhrase' => 'single',
                    'tvid' => 0,
                    'Sequence' => 2,
                    'City' => $orderDetails['property_city'] ? $orderDetails['property_city'] : trim($propertyDetail[2]),
                    'State' => $orderDetails['property_state'] ? $orderDetails['property_state'] : trim($propertyDetail[3]),
                    'Zip' => $orderDetails['property_zip'] ? $orderDetails['property_zip'] : trim($propertyDetail[4]),
                    'Address' => $orderDetails['address'] ? $orderDetails['address'] : trim($propertyDetail[0])." ".trim($propertyDetail[1])
                );  
            }
            $purchase_price = $orderDetails['loan_amount'];
            $sellers = array();
        }

        if (!empty($orderDetails['escrow_lender_id'])) {
            $lenders[] =  array (
                'Id' =>  $orderDetails['westcor_lender_id'] ? $orderDetails['westcor_lender_id'] : 0,
                'tvid' => 0,
                'name' => $orderDetails['lender_first_name']." ".$orderDetails['lender_last_name'],
                'city' => $orderDetails['lender_city'],
                'state' => 'CA',
                'zip' => $orderDetails['lender_zipcode'],
                'address' => $orderDetails['lender_address'],
                'phone' => $orderDetails['lender_telephone_no'],
                'email' => $orderDetails['lender_email'],
                'countyFIPS' => null,
                'assignment' => null,
                'mortgageType' => null,
                'amount' => 0,
                'loan_number' => $orderDetails['property_zip'] ? $orderDetails['property_zip'] : trim($propertyDetail[4]),
                'vendorInternalID' => $orderDetails['escrow_lender_id']
            );
        } 
        
        $cplPostData = array (
            'tvid' =>  0,
            'agentnumber' => $resToken['agent_number'],
            'agent_file_number' => $orderDetails['file_number'],
            'email_requestor' => $orderUser['email_address'],
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
					redirect(base_url().'generate-cpl/'.$fileId);
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
                    if(!empty($secondary_owner)) { 
                        $buyers[1]['NameID'] = !empty($res['buyers']) ? $res['buyers'][1]['NameID'] : 0;
                    }
                }

                if(!empty($sellers)) {
                    $sellers[0]['NameID'] = !empty($res['sellers']) ? $res['sellers'][0]['NameID'] : 0;
                    if(!empty($secondary_owner)) { 
                        $sellers[1]['NameID'] = !empty($res['sellers']) ? $res['sellers'][1]['NameID'] : 0;
                    }
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
                redirect(base_url().'generate-cpl/'.$fileId);
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
            
                        
            // $cpl[] = array (
            //  'TVID' => $res['tvid'],
            //  'CPLID' => -1,
            //  'FileInformation' => null,
            //  'LetterName' => 'ALTA CPL Single Trans 2018 2.0',
            //  'IssueDate' => date('Y-m-d H:i:s'),
            //  'CancelDate' => null,
            //  'CancelReason' => null,
            //  'CancelUser' => null,
            //  'CreatedBy'=> null,
            //  'PolicyProducingAgentNumber' => $resToken['agent_number'],
            //  'PolicyProducingAgentAddressID' => $resToken['agent_number'],
            //  'PolicyProducingAgentName' => $resToken['agency_name'],
            //  'PolicyProducingAgentAddress' => $resToken['address'],
            //  'PolicyProducingAgentCity' => $resToken['city'],
            //  'PolicyProducingAgentState' => $resToken['state'],
            //  'PolicyProducingAgentZip' => $resToken['zip'],
            //  'ClosingAgentNumber'=> null,
            //  'ClosingAgentAddressID'=> null,
            //  'ClosingAgentName'=> null,
            //  'ClosingAgentAddress'=> null,
            //  'ClosingAgentCity'=> null,
            //  'ClosingAgentState'=> null,
            //  'ClosingAgentZip'=> null,
            //  'IsAuthorizedforDualCPLs' => false,
            //  'IsDualCPL' => false,
            //  'LenderID' => !empty($res['lenders']) ? $res['lenders'][0]['Id'] : 0,
            //  'CustomFields'=> null,
            //  'DualCombinedInfo'=> [],
            //  'ProtectBorrower' => false,
            //  'ProtectBuyer' => false,
            //  'ProtectLender' => true,
            //  'ProtectSeller' => false,
            //  'ProtectSeller'=> false,
            //  'ProtectAnyone'=> false,
            //  'ProtectAnyoneValue'=> null,
            //  'FreeInfoText'=> 'Some additional information about the closing would go here.',
            //  'AdditionalAgencyLocationsJSON'=> null,
            //  'ShowAdditionalAgencyLocations'=> false
            // ) ;

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
                    redirect(base_url().'generate-cpl/'.$fileId);
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
            redirect(base_url().'generate-cpl/'.$fileId);
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
        $orderDetails = $this->order->get_order_details($fileId);
        $responseArr = $this->natic->getDocumentContentForCpl($fileId);
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
        redirect(base_url().'generate-cpl/'.$fileId);
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
        $fileId = $this->uri->segment(2);    
        $data['title'] = 'Smart Dashboard | Pacific Coast Title Company';
		$data['mail_dashboard'] = 1;
		$orderDetails = $this->order->get_order_details($fileId);
        $data['file_number'] = $orderDetails['file_number'];
        $data['full_address'] = $orderDetails['full_address'];
		$data['action'] = '<a href="javascript:void(0);" onclick="generateProposedInsured('.$orderDetails['file_id'].');"><button class="btn btn-grad-2a button-color" type="button">Generate</button></a>';
		$data['action'] .= '<a href="javascript:void(0);" onclick="editInformation('.$orderDetails['file_id'].');"><button class="btn btn-grad-2a button-color" type="button">Edit</button></a>';
        $this->load->view('layout/head_dashboard',$data);
        $this->load->view('order/mail_proposed_insured', $data);
	}
	
	public function getOrderDetailsCpl()
	{
		$this->load->library('order/fnf');
		$this->load->model('order/home_model');
		$this->load->library('order/resware');
		$fileId = $this->input->post('fileId');
		$orderDetails = $this->order->get_order_details($fileId);
		$orderUser =  $this->home_model->get_user(array('id' => $orderDetails['customer_id']));
			
		if ($orderUser['is_escrow'] == 1) {
			if ($orderDetails['is_escrow'] == 1) {
				$orderDetails['lender_first_name'] =  '';
				$orderDetails['lender_last_name'] ='';
				$orderDetails['lender_email'] = '';
				$orderDetails['lender_telephone_no'] = '';
				$orderDetails['lender_company_name'] = '';
				$orderDetails['lender_address'] = '';
				$orderDetails['lender_city'] = '';
				$orderDetails['lender_zipcode'] = '';
				$orderDetails['lender_id'] = '';
			} else {			
				$orderDetails['lender_first_name'] = $orderDetails['lender_first_name'] ? $orderDetails['lender_first_name'] : '';
				$orderDetails['lender_last_name'] = $orderDetails['lender_last_name'] ? $orderDetails['lender_last_name'] : '';
				$orderDetails['lender_email'] = $orderDetails['lender_email'] ? $orderDetails['lender_email'] : '';
				$orderDetails['lender_telephone_no'] = $orderDetails['lender_telephone_no'] ? $orderDetails['lender_telephone_no'] : '';
				$orderDetails['lender_company_name'] = $orderDetails['lender_company_name'] ? $orderDetails['lender_company_name'] : '';
				$orderDetails['lender_address'] = $orderDetails['lender_address'] ? $orderDetails['lender_address'] : '';
				$orderDetails['lender_city'] = $orderDetails['lender_city'] ? $orderDetails['lender_city'] : '';
				$orderDetails['lender_zipcode'] = $orderDetails['lender_zipcode'] ? $orderDetails['lender_zipcode'] : '';
				$orderDetails['lender_id'] = $orderDetails['lender_id'] ? $orderDetails['lender_id'] : '';
			}
		} else {
			if (!empty($orderDetails['cpl_lender_id'])) {
				$lenderDetails =  $this->home_model->get_user(array('id' => $orderDetails['cpl_lender_id']));
				$orderDetails['lender_first_name'] = $lenderDetails['first_name'] ? $lenderDetails['first_name'] : '';
				$orderDetails['lender_last_name'] = $lenderDetails['last_name'] ? $lenderDetails['last_name'] : '';
				$orderDetails['lender_email'] = $lenderDetails['email_address'] ? $lenderDetails['email_address'] : '';
				$orderDetails['lender_telephone_no'] = $lenderDetails['telephone_no'] ? $lenderDetails['telephone_no'] : '';
				$orderDetails['lender_company_name'] = $lenderDetails['company_name'] ? $lenderDetails['company_name'] : '';
				$orderDetails['lender_address'] = $lenderDetails['street_address'] ? $lenderDetails['street_address'] : '';
				$orderDetails['lender_city'] = $lenderDetails['city'] ? $lenderDetails['city'] : '';
				$orderDetails['lender_zipcode'] = $lenderDetails['zip_code'] ? $lenderDetails['zip_code'] : '';
				$orderDetails['lender_id'] = $lenderDetails['id'] ? $lenderDetails['id'] : '';
			} else {
				$orderDetails['lender_first_name'] =  '';
				$orderDetails['lender_last_name'] ='';
				$orderDetails['lender_email'] = '';
				$orderDetails['lender_telephone_no'] = '';
				$orderDetails['lender_company_name'] = '';
				$orderDetails['lender_address'] = '';
				$orderDetails['lender_city'] = '';
				$orderDetails['lender_zipcode'] = '';
				$orderDetails['lender_id'] = '';
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
				$primary_owner = explode(' ', $orderDetails['borrower']);
				$orderDetails['primary_owner_first_name'] = !empty($primary_owner[0]) ? $primary_owner[0] : '';
				$orderDetails['primary_owner_last_name'] = !empty($primary_owner[1]) ? $primary_owner[1] : '';
			} else {
				$orderDetails['primary_owner_first_name'] = '';
				$orderDetails['primary_owner_last_name'] = '';
			}
	
			if (!empty($orderDetails['secondary_borrower'])) {
				$secondary_owner = explode(' ', $orderDetails['secondary_borrower']);
				$orderDetails['secondary_owner_first_name'] = !empty($secondary_owner[0]) ? $secondary_owner[0] : '';
				$orderDetails['secondary_owner_last_name'] = !empty($secondary_owner[1]) ? $secondary_owner[1] : '';
			} else {
				$orderDetails['secondary_owner_first_name'] = '';
				$orderDetails['secondary_owner_last_name'] = '';
			}
		} else {
			if (!empty($orderDetails['primary_owner'])) {
				$primary_owner = explode(' ', $orderDetails['primary_owner']);
				$orderDetails['primary_owner_first_name'] = !empty($primary_owner[0]) ? $primary_owner[0] : '';
				$orderDetails['primary_owner_last_name'] = !empty($primary_owner[1]) ? $primary_owner[1] : '';
			} else {
				$orderDetails['primary_owner_first_name'] = '';
				$orderDetails['primary_owner_last_name'] = '';
			}
	
			if (!empty($orderDetails['secondary_owner'])) {
				$secondary_owner = explode(' ', $orderDetails['secondary_owner']);
				$orderDetails['secondary_owner_first_name'] = !empty($secondary_owner[0]) ? $secondary_owner[0] : '';
				$orderDetails['secondary_owner_last_name'] = !empty($secondary_owner[1]) ? $secondary_owner[1] : '';
			} else {
				$orderDetails['secondary_owner_first_name'] = '';
				$orderDetails['secondary_owner_last_name'] = '';
			}
		}
		
		$endPoint = 'files/'. $fileId .'/partners';
		$logid = $this->apiLogs->syncLogs(0, 'resware', 'get_partners', env('RESWARE_ORDER_API').$endPoint, array(), array(), $orderDetails['order_id'], 0);
		
		$orderUser =  $this->home_model->get_user(array('id' => $orderDetails['customer_id']));
		$user_data['email'] = $orderUser['email_address'];
		$user_data['password'] = $orderUser['random_password'];
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
			}
		}
		$orderDetails['loan_amount'] = $orderDetails['loan_amount'] ? $orderDetails['loan_amount'] : '';
		$orderDetails['loan_number'] = $orderDetails['loan_number'] ? $orderDetails['loan_number'] : '';
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
				$data['zip_code'] = isset($value['zip_code']) && !empty($value['zip_code']) ? $value['zip_code'] : '';
				$data['is_escrow'] = isset($value['is_escrow']) && !empty($value['is_escrow']) ? $value['is_escrow'] : '';
	            // array_push($userInfo, $data); 
	            $userInfo[] =$data;
    		}
    	}
    	echo json_encode($userInfo);
    }
    
}