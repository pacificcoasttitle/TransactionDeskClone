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
        $data['created'] = !empty($orderDetails['created']) ? date("m/d/Y", strtotime($orderDetails['created'])) : '';
        $file_id = $orderDetails['file_id'];

        if (!empty($orderDetails['cpl_document_name'])) {
            $documentName = $orderDetails['cpl_document_name'];
            if (env('AWS_ENABLE_FLAG') == 1) {
                $documentUrl = env('AWS_PATH')."documents/".$documentName;
                $data['action'] = "<div style='display:flex;'><a href='#' onclick='downloadDocumentFromAws(".'"'.$documentUrl.'"'.", ".'"cpl"'.");'><button class='btn btn-grad-2a' style='background: #d35411;' type='button'>Download</button></a>
                                <a onclick='return lender_pop_up(0, $file_id);' href='javascript:void(0);'><button class='btn btn-grad-2a generate button-color' type='button'>Edit</button></a></div>";
            } else {
                $documentUrl = FCPATH.'uploads/documents/'.$documentName;
                $data['action'] = "<div style='display:flex;'><a href='$documentUrl' download><button class='btn btn-grad-2a' style='background: #d35411;' type='button'>Download</button></a>
                                <a onclick='return lender_pop_up(0, $file_id);' href='javascript:void(0);'><button class='btn btn-grad-2a generate button-color' type='button'>Edit</button></a></div>";
            }
            
        } else if(!empty($orderDetails['westcor_file_id'])) {
            $westcorFileId = $orderDetails['westcor_file_id'];
            $westcorOrderId = $orderDetails['westcor_order_id'];
            $data['action'] = "<div style='display:flex;'><a onclick='download_for_pdf($westcorFileId, $westcorOrderId);' href='javascript:void(0);'><button class='btn btn-grad-2a' style='background: #d35411;' type='button'>Download</button></a>
                                <a onclick='return lender_pop_up(0, $file_id);' href='javascript:void(0);'><button class='btn btn-grad-2a generate button-color' type='button'>Edit</button></a></div>";
        } else {
            $data['action'] = "<div style='display:flex;'><form onclick='return lender_pop_up(0, $file_id);' action='".base_url()."create-cpl/".$file_id."' method='POST'><button class='btn btn-grad-2a generate button-color' type='submit'>GENERATE</button></form>
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

        $product_type = isset($orderDetails['product_type']) && !empty($orderDetails['product_type']) ? $orderDetails['product_type'] : '';
        $data['productType'] = $product_type;

        if(isset($salesAmount) && !empty($salesAmount))
        {
            $request['SalesPrice'] = $salesAmount;
            $condition = array(
                'where' => array(
                    'transaction_type' => 'sale',
                    'pct_order_fees.status' => 1
                ),
                'product_type' => $product_type,
            );
        }
        else
        {
            $condition = array(
                'where' => array(
                    'transaction_type' => 'loan',
                    'pct_order_fees.status' => 1
                ),
                'product_type' => $product_type,
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

            $feesInfo = $this->fees_model->get_rows($condition);
            if(isset($feesInfo) && !empty(isset($feesInfo)))
            {
                foreach ($feesInfo as $k => $v) 
                {

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
        }
        
        $this->load->view('layout/head_dashboard',$data);
        $this->load->view('order/mail_fees');
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
		$data['created'] = !empty($orderDetails['proposed_document_created_date']) ? date("m/d/Y", strtotime($orderDetails['proposed_document_created_date'])) : '';

        if (!empty($orderDetails['proposed_insured_document_name'])) 
        {
            $file_id = $orderDetails['file_id'];
            $documentName = $orderDetails['proposed_insured_document_name'];
            if (env('AWS_ENABLE_FLAG') == 1) {
                $documentUrl = env('AWS_PATH')."proposed-insured/".$documentName;
                $action = "<a href='#' onclick='downloadDocumentFromAws(".'"'.$documentUrl.'"'.", ".'"proposed_insured"'.");'><button class='btn btn-grad-2a' type='button' style='background: #d35411;'>Download</button></a>";
            } else {
                $documentUrl = FCPATH.'uploads/proposed-insured/'.$documentName;
                $action = '<a href="'.$documentUrl.'" download><button class="btn btn-grad-2a" type="button" style="background: #d35411;">Download</button></a>';
            }
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
        $data['proposedBranches'] = $this->order->getProposedBranches();

        $this->load->view('layout/head_dashboard',$data);
        $this->load->view('order/mail_proposed_insured', $data);
	}
	
    public function borrowerInformation()
    {
        $random_number = $this->uri->segment(2);
        if ($random_number == 'seller') {
            $sellerFlag = 1;
            $random_number = $this->uri->segment(3);
        } else {
            $sellerFlag = 0;
        }

        $condition = array(
            'where' => array(
                'random_number' => $random_number,
            )
        );
        $order = $this->order->get_order($condition);

        if(!empty($order)) {
            $orderNumber = isset($order[0]['file_number']) && !empty($order[0]['file_number']) ? $order[0]['file_number'] : '';
            $fileId = isset($order[0]['file_id']) && !empty($order[0]['file_id']) ? $order[0]['file_id'] : '';
            $data['sellerFlag'] = $sellerFlag;
            $orderDetails = $this->order->get_order_details($fileId, 1);
            if ($sellerFlag) {
                $borrower_info_submitted = $order[0]['borrower_info_submitted_for_seller'];
                $is_code_verified = $order[0]['is_code_verified_for_seller'];
                $borrower_mobile_number = isset($orderDetails['borrower_mobile_number_for_seller']) && !empty($orderDetails['borrower_mobile_number_for_seller']) ? $orderDetails['borrower_mobile_number_for_seller'] : '';
            } else {
                $borrower_info_submitted = $order[0]['borrower_info_submitted'];
                $is_code_verified = $order[0]['is_code_verified'];
                $borrower_mobile_number = isset($orderDetails['borrower_mobile_number']) && !empty($orderDetails['borrower_mobile_number']) ? $orderDetails['borrower_mobile_number'] : '';
            }

            if(!empty($orderDetails['escrow_officer_id'])) {
                $escrowOfficerCon = array(
                    'where' => array(
                        'partner_id' => $orderDetails['escrow_officer_id'],
                    )
                );
                $escrowOfficerData = $this->home_model->get_company_rows($escrowOfficerCon);
                $data['escrow_officer'] =  $escrowOfficerData[0]['partner_name'];
            } else {
                $data['escrow_officer'] = '';
            }
            
        
            if ($orderDetails['sales_amount'] > 0) {
                if ($sellerFlag) {
                    if (!empty($orderDetails['primary_owner'])) {
                        $borrowerNameInfo = explode(" ", $orderDetails['primary_owner']);
                        if(count($borrowerNameInfo) == 3) {
                            $data['borrower_first_name'] = $borrowerNameInfo[0];
                            $data['borrower_middle_name'] = $borrowerNameInfo[1];
                            $data['borrower_last_name'] = $borrowerNameInfo[2];
                        } else if(count($borrowerNameInfo) == 2) {
                            $data['borrower_first_name'] = $borrowerNameInfo[0];
                            $data['borrower_middle_name'] = '' ;
                            $data['borrower_last_name'] = $borrowerNameInfo[1];
                        } else {
                            $data['borrower_first_name'] = '' ;
                            $data['borrower_middle_name'] = '' ;
                            $data['borrower_last_name'] = '' ;
                        }
                    } else {
                        $data['borrower_first_name'] = '' ;
                        $data['borrower_middle_name'] = '' ;
                        $data['borrower_last_name'] = '' ;
                    }
                } else {
                    if (!empty($orderDetails['borrower'])) {
                        $borrowerNameInfo = explode(" ", $orderDetails['borrower']);
                        if(count($borrowerNameInfo) == 3) {
                            $data['borrower_first_name'] = $borrowerNameInfo[0];
                            $data['borrower_middle_name'] = $borrowerNameInfo[1];
                            $data['borrower_last_name'] = $borrowerNameInfo[2];
                        } else if(count($borrowerNameInfo) == 2) {
                            $data['borrower_first_name'] = $borrowerNameInfo[0];
                            $data['borrower_middle_name'] = '' ;
                            $data['borrower_last_name'] = $borrowerNameInfo[1];
                        } else {
                            $data['borrower_first_name'] = '' ;
                            $data['borrower_middle_name'] = '' ;
                            $data['borrower_last_name'] = '' ;
                        }
                    } else {
                        $data['borrower_first_name'] = '' ;
                        $data['borrower_middle_name'] = '' ;
                        $data['borrower_last_name'] = '' ;
                    }
                }
            } else {
                if (!empty($orderDetails['primary_owner'])) {
                    $borrowerNameInfo = explode(" ", $orderDetails['primary_owner']);
                    if(count($borrowerNameInfo) == 3) {
                        $data['borrower_first_name'] = $borrowerNameInfo[0];
                        $data['borrower_middle_name'] = $borrowerNameInfo[1];
                        $data['borrower_last_name'] = $borrowerNameInfo[2];
                    } else if(count($borrowerNameInfo) == 2) {
                        $data['borrower_first_name'] = $borrowerNameInfo[0];
                        $data['borrower_middle_name'] = '' ;
                        $data['borrower_last_name'] = $borrowerNameInfo[1];
                    } else {
                        $data['borrower_first_name'] = '' ;
                        $data['borrower_middle_name'] = '' ;
                        $data['borrower_last_name'] = '' ;
                    }
                } else {
                    $data['borrower_first_name'] = '' ;
                    $data['borrower_middle_name'] = '' ;
                    $data['borrower_last_name'] = '' ;
                }
            }

            if ($borrower_info_submitted == 1) {
                $data['is_borrower_info_submitted'] = 1;
                $propertyAddress = isset($orderDetails['full_address']) && !empty($orderDetails['full_address']) ? $orderDetails['full_address'] : '';
                $data['mail_dashboard'] = 1;
                $data['order_id'] = $order[0]['id'];
                $data['file_id'] = $fileId;
                $data['propertyAddress'] = $propertyAddress;
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
                $borrowerInfo = $this->order->get_borrower_info($order[0]['id'], $sellerFlag ? 0 : 1);
                $borrowerResidenceInfo = $this->order->get_borrower_residence_info($order[0]['id'], $sellerFlag ? 0 : 1);
                $data['borrower_name'] = $borrowerInfo['first_name']." ".$borrowerInfo['middle_name']." ".$borrowerInfo['last_name'];
                $data['borrower_address'] = $borrowerResidenceInfo[0]['address'];
                $this->load->view('layout/head_dashboard', $data);
                $this->load->view('order/borrower', $data);
            } else if ($is_code_verified == 1 && $borrower_info_submitted == 0) {
                $propertyAddress = isset($orderDetails['full_address']) && !empty($orderDetails['full_address']) ? $orderDetails['full_address'] : '';
                $data['is_borrower_info_submitted'] = 0;
                $data['mail_dashboard'] = 1;
                $data['propertyAddress'] = $propertyAddress;
                $data['order_id'] = $order[0]['id'];
                $data['file_id'] = $fileId;
                $data['errors'] = array();
                $data['success'] = array();
                
                $data['borrower_mobile_number'] =  $borrower_mobile_number;
                if ($this->session->userdata('errors')) {
                    $data['errors'] = $this->session->userdata('errors');
                    $this->session->unset_userdata('errors');
                }
                if ($this->session->userdata('success')) {
                    $data['success'] = $this->session->userdata('success');
                    $this->session->unset_userdata('success');
                }
                if ($sellerFlag) {
                    $this->home_model->update(array('is_code_verified_for_seller' => 0), array('file_id' => $fileId), 'order_details');
                } else {
                    $this->home_model->update(array('is_code_verified' => 0), array('file_id' => $fileId), 'order_details');
                }
                $this->load->view('layout/head_dashboard', $data);
                $this->load->view('order/borrower', $data); 
            } else {
                $propertyAddress = isset($orderDetails['full_address']) && !empty($orderDetails['full_address']) ? $orderDetails['full_address'] : '';
                $data['orderNumber'] = $orderNumber;
                $data['propertyAddress'] = $propertyAddress;
                $data['randomNumber'] = $random_number;
                $data['fileId'] = $fileId;
                $data['borrower_mobile_number'] = $borrower_mobile_number;
                $this->load->view('order/borrower_login', $data);
            }
        } else {
            redirect(base_url().'order');
        }
    }

    public function generate_verification_code()
    {
        $phoneNumber = $this->input->post('phone_number');
        $is_seller = $this->input->post('is_seller');

        if(isset($phoneNumber) && !empty($phoneNumber)) {
            $randomNumber = $this->input->post('random_number');
            $code = rand(10000000,99999999);
            $sid = env('TWILIO_SID');
            $token = env('TWILIO_TOKEN');
            $from = env('TWILIO_FROM');
            $message = "Your Pacific Coast Safe Wire code is: ".$code;
            $logid = $this->apiLogs->syncLogs('', 'twilio', 'send_message', '', array('message' => $message, 'account_sid' => $sid, 'token' => $token,'to'=>'', 'from'=>$from), array(), 0, 0);

            try {
                $result = $this->twilio->message($phoneNumber, $message,'',array('from'=>$from));
                $response = $result->toArray();
                $response['msg_status'] = 'success';
                $response['code'] = $code;

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

            $this->apiLogs->syncLogs('', 'twilio', 'send_message', '', array('code'=>$code,'account_sid'=>$sid,'token'=>$token,'to'=>'', 'from'=>$from), $response, 0, $logid);

            if($response['msg_status'] == 'success') {

                if($is_seller) {
                    $this->home_model->update(array('borrower_mobile_number_for_seller' => $phoneNumber, 'verification_code_for_seller' => $code,'is_code_verified_for_seller' => 0,'code_created_at_for_seller'=> date("Y-m-d H:i:s")), array('random_number' => $randomNumber), 'order_details');
                } else {
                    $this->home_model->update(array('borrower_mobile_number' => $phoneNumber, 'verification_code' => $code,'is_code_verified' => 0,'code_created_at'=> date("Y-m-d H:i:s")), array('random_number' => $randomNumber), 'order_details');
                }
            
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
                $result = array('msg_status'=>'success', 'message'=> 'Code generated successfully.');
            } else {
                $result = array('msg_status'=>'error', 'error_message'=> $response['errorMessage']);
            }
        } else {
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
        $is_seller = $this->input->post('is_seller');
        $fileId = isset($order[0]['file_id']) && !empty($order[0]['file_id']) ? $order[0]['file_id'] : '';
        $orderDetails = $this->order->get_order_details($fileId, 1);
        $borrowerInfoData = array(
            'first_name' => $this->input->post('firstname'),
            'middle_name' => $this->input->post('middlename'),
            'last_name' => $this->input->post('lastname'),
            'mobile' => $this->input->post('mobile'),
            //'telephone' => $this->input->post('telephone'),
            'date_of_birth' => $this->input->post('date_of_birth'),
            //'birthplace' => $this->input->post('birthplace'),
            'ssn' => $this->input->post('ssn'),
            'email' => $this->input->post('email'),
            'dln' => $this->input->post('dln'),
            'status' => $this->input->post('status'),
            'spouse_first_name' => $this->input->post('spouse_firstname'),
            'spouse_middle_name' => $this->input->post('spouse_middlename'),
            'spouse_last_name' => $this->input->post('spouse_lastname'),
            'spouse_mobile' => $this->input->post('spouse_mobile'),
            //'spouse_telephone' => $this->input->post('spouse_telephone'),
            //'spouse_date_of_birth' => $this->input->post('spouse_date_of_birth'),
            //'spouse_birthplace' => $this->input->post('spouse_birthplace'),
            'spouse_ssn' => $this->input->post('spouse_ssn'),
            //'spouse_dln' => $this->input->post('spouse_dln'),
            'partner_first_name' => $this->input->post('partner_firstname'),
            'partner_middle_name' => $this->input->post('partner_middlename'),
            'partner_last_name' => $this->input->post('partner_lastname'),
            'partner_mobile' => $this->input->post('partner_mobile'),
            //'partner_telephone' => $this->input->post('partner_telephone'),
            //'partner_date_of_birth' => $this->input->post('partner_date_of_birth'),
            //'partner_birthplace' => $this->input->post('partner_birthplace'),
            'partner_ssn' => $this->input->post('partner_ssn'),
            //'partner_dln' => $this->input->post('partner_dln'),
            'order_id' => $this->input->post('order_id'),
            //'partnership_status' => $this->input->post('partnership_status'),
            //'prior_spouse_name' => $this->input->post('partnership_status') == 'both' ? $this->input->post('prior_spouse_name_both') : $this->input->post('prior_spouse_name'),
            //'prior_spouse_reason' => $this->input->post('partnership_status') == 'both' ? $this->input->post('prior_spouse_reason_both') : $this->input->post('prior_spouse_reason'),
            //'prior_spouse_end' => $this->input->post('partnership_status') == 'both' ? $this->input->post('prior_spouse_end_both') : $this->input->post('prior_spouse_end'),
            //'current_spouse_prior_spouse_name' => $this->input->post('partnership_status') == 'both' ? $this->input->post('current_spouse_prior_spouse_name_both') : $this->input->post('current_spouse_prior_spouse_name'),
            //'current_spouse_prior_spouse_reason' => $this->input->post('partnership_status') == 'both' ? $this->input->post('current_spouse_prior_spouse_reason_both') : $this->input->post('current_spouse_prior_spouse_reason'),
            //'current_spouse_prior_spouse_end' => $this->input->post('partnership_status') == 'both' ? $this->input->post('current_spouse_prior_spouse_end_both') : $this->input->post('current_spouse_prior_spouse_end'),
            'street_address' => $this->input->post('street_address'),
            'buyer_intends_to_reside' => $this->input->post('buyer_intends'),
            'land_is_unimproved' => $this->input->post('land_is_unimproved'),
            'type_of_property' => $this->input->post('type_of_property'),
            'work_done_last_6_month' => $this->input->post('work_done_last_6_month'),
            'previously_married' => $this->input->post('previously_married'),
            'general_terms' => 1,
            'signature' => $this->input->post('signature'),
            'is_buyer' => $this->input->post('is_seller') == 1 ? 0 : 1,
            'spouse_signature' => $this->input->post('spouse_signature'),
            'created_at' => date('Y-m-d H:i:s')
        );
        $borrowerId = $this->home_model->insert($borrowerInfoData,'pct_order_borrower_info');

        $residence_addresses = $this->input->post('residence_addresses');
        $residence_from_dates = $this->input->post('residence_from_dates');
        $residence_to_dates = $this->input->post('residence_to_dates');
        $i = 0;

        foreach($residence_addresses as $residence_address) {
            $borrowerResidenceData = array(
                'address' => $residence_address,
                'from_date' => $residence_from_dates[$i],
                'to_date' => $residence_to_dates[$i],
                'order_id' => $this->input->post('order_id'),
                'is_buyer' => $this->input->post('is_seller') == 1 ? 0 : 1,
                'created_at' => date('Y-m-d H:i:s'),
            );
            $this->home_model->insert($borrowerResidenceData, 'pct_order_borrower_residence_info');
            $i++;
        }

        $employment_status = $this->input->post('employment_status');
        if($employment_status == 'add_business') {
            $business_names = $this->input->post('business_names');
            $employment_addresses = $this->input->post('employment_addresses');
            $employment_from_dates = $this->input->post('employment_from_dates');
            $employment_to_dates = $this->input->post('employment_to_dates');
            $j = 0;

            foreach($business_names as $business_name) {
                $borrowerEmploymentData = array(
                    'business_name' => $business_name,
                    'address' => $employment_addresses[$j],
                    'from_date' => $employment_from_dates[$j],
                    'to_date' => $employment_to_dates[$j],
                    'order_id' => $this->input->post('order_id'),
                    'is_partner_info' => 0,
                    'is_buyer' => $this->input->post('is_seller') == 1 ? 0 : 1,
                    'created_at' => date('Y-m-d H:i:s'),
                );
                $this->home_model->insert($borrowerEmploymentData, 'pct_order_borrower_employment_info');
                $j++;
            }

            /*$partner_business_names = $this->input->post('partner_business_names');
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
            }*/
        }

        if($is_seller == 1) {
            $this->home_model->update(array('borrower_info_submitted_for_seller' => 1), array('random_number' => $order[0]['random_number']), 'order_details');
        } else {
            $this->home_model->update(array('borrower_info_submitted' => 1), array('random_number' => $order[0]['random_number']), 'order_details');
        }
       

        /* Generate PDF */
        
        $borrower_info = $this->order->get_borrower_info($this->input->post('order_id'), $this->input->post('is_seller') == 1 ? 0 : 1);

        $borrower_residence_info = $this->order->get_borrower_residence_info($this->input->post('order_id'), $this->input->post('is_seller') == 1 ? 0 : 1);

        $borrower_employment_info = $this->order->get_borrower_employment_info($this->input->post('order_id'), $this->input->post('is_seller') == 1 ? 0 : 1);

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
        $this->order->uploadDocumentOnAwsS3($document_name, 'borrower-information');
        /* Generate PDF */

        $success[] = "Borrower form submitted successfully.";
        $endPoint = 'files/'. $fileId.'/actions';
        $user_data['admin_api'] = 1; 
        $logid = $this->apiLogs->syncLogs(0, 'resware', 'get_actions_for_order', env('RESWARE_ORDER_API').$endPoint, array(), array(), 0, 0);
        $res = $this->resware->make_request('GET', $endPoint, array(), $user_data);
        $this->apiLogs->syncLogs(0, 'resware', 'get_actions_for_order', env('RESWARE_ORDER_API').$endPoint, array(), $res, 0, $logid);
        $result = json_decode($res,TRUE);

        if (isset($result['Actions']) && !empty($result['Actions'])) {
            $array_keymap = $this->order->array_recursive_search_key_map(108, $result['Actions']);
            if(!empty($array_keymap)) {
                $actionData = array(
                    'StartTask' => array(
                        'CoordinatorTypeID'=> 19,
                        'DueDate' => '/Date('.(strtotime(date('Y-m-d H:i:s'))*1000).'-0000)/'
                    ),
                    'CompleteTask' => array(
                        'CoordinatorTypeID' => 30,
                        'DueDate' => '/Date('.(strtotime("+1 day", strtotime(date('Y-m-d H:i:s')))*1000).'-0000)/'
                    ),
                );
                $endPoint = 'files/'. $fileId.'/actions/'.$result['Actions'][$array_keymap[0]]['FileActionID'];
                $user_data['admin_api'] = 1; 
                $actionData = json_encode($actionData);
                $logid = $this->apiLogs->syncLogs(0, 'resware', 'update_actions_for_order', env('RESWARE_ORDER_API').$endPoint, $actionData, array(), $this->input->post('order_id'), 0);
                $res = $this->resware->make_request('PUT', $endPoint,  $actionData, $user_data);
                $this->apiLogs->syncLogs(0, 'resware', 'update_actions_for_order', env('RESWARE_ORDER_API').$endPoint,  $actionData, $res, $this->input->post('order_id'), $logid);
                $result = json_decode($res,TRUE);
            } else {
                $actionData = array(
                    'ActionType' => array(
                        'ActionTypeID' => 108
                    ),
                    'Group' => array(
                        'ActionGroupID' => 6
                    ),    
                    'StartTask' => array(
                        'CoordinatorTypeID'=> 19,
                        'DueDate' => '/Date('.(strtotime(date('Y-m-d H:i:s'))*1000).'-0000)/'
                    ),
                    'CompleteTask' => array(
                        'CoordinatorTypeID' => 30,
                        'DueDate' => '/Date('.(strtotime("+1 day", strtotime(date('Y-m-d H:i:s')))*1000).'-0000)/'
                    ),
                );
                $endPoint = 'files/'. $fileId.'/actions/';
                $user_data['admin_api'] = 1; 
                $actionData = json_encode($actionData);
                $logid = $this->apiLogs->syncLogs(0, 'resware', 'add_actions_for_order', env('RESWARE_ORDER_API').$endPoint, $actionData, array(), $this->input->post('order_id'), 0);
                $res = $this->resware->make_request('POST', $endPoint, $actionData, $user_data);
                $this->apiLogs->syncLogs(0, 'resware', 'add_actions_for_order', env('RESWARE_ORDER_API').$endPoint, $actionData, $res, $this->input->post('order_id'), $logid);
                $result = json_decode($res,TRUE);
            }
        } 
        $data = array(
            "errors" =>  $errors,
            "success" => $success
        );
        $this->session->set_userdata($data);
        if($is_seller == 1) {
            redirect(base_url().'/borrower-information/seller/'.$order[0]['random_number']);
        } else {
            redirect(base_url().'/borrower-information/'.$order[0]['random_number']);
        }
    }
    
    public function code_verification()
    {
        $code = $this->input->post('code');
        $is_seller = $this->input->post('is_seller');

        if(isset($code) && !empty($code))
        {
            $fileId = $this->input->post('fileId');

            $orderDetails = $this->order->get_order_details($fileId, 1);

            if($is_seller) {
                $verification_code = isset($orderDetails['verification_code_for_seller']) && !empty($orderDetails['verification_code_for_seller']) ? $orderDetails['verification_code_for_seller'] : '';
                $code_created_at = isset($orderDetails['code_created_at_for_seller']) && !empty($orderDetails['code_created_at_for_seller']) ? $orderDetails['code_created_at_for_seller'] : '';
            } else {
                $verification_code = isset($orderDetails['verification_code']) && !empty($orderDetails['verification_code']) ? $orderDetails['verification_code'] : '';
                $code_created_at = isset($orderDetails['code_created_at']) && !empty($orderDetails['code_created_at']) ? $orderDetails['code_created_at'] : '';
            }

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
                    if($is_seller) {
                        $this->home_model->update(array('is_code_verified_for_seller' => 1), array('id' => $orderDetails['order_id']), 'order_details');
                    } else {
                        $this->home_model->update(array('is_code_verified' => 1), array('id' => $orderDetails['order_id']), 'order_details');
                    }
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

                        foreach ($result['Files'] as $res) 
                        {
                            /* partners details */
                            $partner_fname = $res['Partners'][0]['PrimaryEmployee']['FirstName'];
                            $partner_lname = $res['Partners'][0]['PrimaryEmployee']['LastName'];
                            $partner_name = $res['Partners'][0]['PartnerName'];

                            $condition = array(
                                'first_name' => $partner_fname,
                                'last_name' => $partner_lname,
                                'company_name' => $partner_name,
                                'is_pass' => $partner_name,
                            );
                            $user_details =  $this->home_model->get_user_by_name($condition);

                            $customerId = 0;
                            if(isset($user_details) && !empty($user_details))
                            {
                                $customerId = $user_details['id'];
                            }
                            /* partners details */
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
                                'customer_id' => $customerId,
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
                                'customer_id' => $customerId,
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
                                'customer_id' => $customerId,
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
                            /*$random_number = time() + (floor(rand() * (10000 - 1 + 1)) + 1);
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

                            $this->titlepoint->generateTaxDoc($tax_serviceId,$res['FileNumber'],$orderId);*/
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

    public function createOrderSafewire()
    {
        $file_id = $this->input->post('file_id');
        $order_id = $this->input->post('order_id');
        $orderDetails = $this->order->get_order_details($file_id);
        if ($orderDetails['sales_amount'] > 0)  {
            $purchase_price = $orderDetails['sales_amount'];
        } else {
            $purchase_price = $orderDetails['loan_amount'];
        }
        $orderData = array(
            'FileNumber' =>  $orderDetails['file_number'],
            'FileID' => $orderDetails['file_id'],
            'Properties' => array(
                array(
                    'Address' => $orderDetails['address'],
                    'City' => $orderDetails['property_city'],
                    'State' => $orderDetails['property_state'],
                    'County' => $orderDetails['county'],
                    'Zip' => $orderDetails['property_zip'], 
                )
            ),
            'Buyers' => array(
                array(
                    'FirstName' => $this->input->post('firstname'),
                    'LastName' => $this->input->post('lastname'),
                    'MobilePhone' => $this->input->post('mobile'),
                    'Email' => $this->input->post('email')
                )
            ),
            'SalesPrice' => $purchase_price,
        );

        if(!empty($orderDetails['escrow_officer_id'])) {
            $escrowOfficerCon = array(
                'where' => array(
                    'partner_id' => $orderDetails['escrow_officer_id'],
                )
            );
            $escrowOfficerData = $this->home_model->get_company_rows($escrowOfficerCon);
            if(!empty($escrowOfficerData)) {
                $name = explode(" ", $escrowOfficerData[0]['partner_name']);
                $orderData['EscrowPartner'][] =  array(
                    'PartnerID' => $orderDetails['escrow_officer_id'],
                    'FirstName' =>  $name[0],
                    'LastName' => $name[1],
                    'Email' => $escrowOfficerData[0]['email'],
                    'MobilePhone' => null
                );
            }
            
        }
       
        $bodyParams = array('FileInformations' => $orderData);
        $body_params = json_encode($bodyParams, JSON_UNESCAPED_SLASHES);
        if ($orderDetails['is_create_order_on_safewire'] == 1) {
            $url = env('SAFEWIRE_URL').$file_id."/synchronize";
            $method = 'GET';
        } else {
            $url = env('SAFEWIRE_URL')."invite";
            $method = 'POST';
        }
       
        $logid = $this->apiLogs->syncLogs(0, 'safewire', 'create_order_on_safewire', $url, $body_params, array(), $order_id, 0);
        $ch = curl_init($url);                                    
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $method);                        
        curl_setopt($ch, CURLOPT_POSTFIELDS, $body_params);                   
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Api-Key: '.env('SAFEWIRE_API_KEY'),
            'Content-Type: application/json',
            'Content-Length: ' . strlen($body_params))
        );
        $error_msg = curl_error($ch);
        $result = curl_exec($ch);
        $this->apiLogs->syncLogs(0, 'safewire', 'create_order_on_safewire', $url, $body_params, $result, $order_id, $logid);
        $res = json_decode($result, true);
        if(isset($res['action_link']) && !empty($res['action_link'])) {
            $this->home_model->update(array('is_create_order_on_safewire' => 1, 'safewire_action_link' => $res['action_link']), array('id' => $orderDetails['order_id']), 'order_details');
            $response = array('success' => true, 'message'=> 'order created successfully', 'action_link' => $res['action_link']);
        } else if(isset($res['result']) && $res['result'] == 'success') {
            $response = array('success' => true, 'message'=> 'order updated successfully', 'action_link' => $orderDetails['safewire_action_link']);
        } else {
            if(isset($error_msg) && !empty($error_msg)) {
                $response = array('success' => false, 'message'=> $error_msg);
            } else {
                $response = array('success' => false, 'message'=> $res['error']);
            }
        }
        echo json_encode($response); exit;
    }

    public function getSafewireOrderStatus()
    {
        ini_set('max_execution_time', 0); 
		ini_set('memory_limit','2048M');
        $json = file_get_contents('php://input');
        $response = array();
        $logId = $this->apiLogs->syncLogs(0, 'safewire', 'send_order_status', null, $json, array());
        $order_id = 0;

		if ($json) { 
            $data = json_decode($json,TRUE);
            $orderDetails = $this->order->get_order_details($data['order_id'], 1);
            if(!empty($orderDetails)) {
                $order_id = $orderDetails['order_id'];
                $this->order->syncSafewireDocuments($data['order_details'], $data['wire_instruction_details'], $orderDetails);
                $this->home_model->update(array('safewire_order_status' => $data['status']), array('file_id' => $data['order_id']), 'order_details');
                $response = array('success' => true, 'message' => 'Received order information successfully.');
            } else {
                $response = array('success' => false, 'error_msg' => 'Order not found');
            }
        } else {
            $response = array('success' => false, 'error_msg' => 'No data received.');
        }
        $this->apiLogs->syncLogs(0, 'safewire', 'send_order_status', null, $json, $response, $order_id, $logId);
        header('HTTP/1.0 200 OK');
        header('Content-type: application/json');
        echo json_encode($response, true);
        exit;
    }

    public function policy()
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
        $data['title'] = 'Get Policy | Pacific Coast Title Company';
        $data['mail_dashboard'] = 1;
        $orderDetails = $this->order->get_order_details($fileId, 1);
        $data['file_number'] = $orderDetails['file_number'];
        $data['full_address'] = $orderDetails['full_address'];
        $data['file_id'] = $orderDetails['file_id'];
        $data['order_id'] = $orderDetails['order_id'];
        $data['created'] = !empty($orderDetails['opened_date']) ? date("m/d/Y", strtotime($orderDetails['opened_date'])) : '';
        $user_data['admin_api'] = 1;
        $user_data['from_mail'] = 1; 
        $endPoint = 'files/'.$fileId.'/documents';
					
        $logid = $this->apiLogs->syncLogs(0, 'resware', 'get_resware_document', env('RESWARE_ORDER_API').$endPoint, array(), array(), $orderDetails['order_id'], 0);
        $result = $this->resware->make_request('GET', $endPoint, '', $user_data);
        $this->apiLogs->syncLogs(0, 'resware', 'get_resware_document', env('RESWARE_ORDER_API').$endPoint, array(), $result,  $orderDetails['order_id'], $logid);
        $res = json_decode($result, true);
        
        $policyDocuments = array();
        $i = 0;
        foreach($res['Documents'] as $document) {
            if ($document['DocumentType']['DocumentTypeID'] == 103) {
                $policyDocuments[$i]['no'] = $i + 1;
                $policyDocuments[$i]['api_document_id'] = $document['DocumentID'];
                $policyDocuments[$i]['document_name'] = $document['DocumentName'];
                $time = round((int)(str_replace("-0000)/", "", str_replace("/Date(", "", $document['CreateDate'])))/1000);
                $created_date = date('m/d/Y', $time);
                $policyDocuments[$i]['created_at'] = $created_date;
                $i++;
            }
        }

        $data['policyDocuments'] = $policyDocuments;
        $this->load->view('layout/head_dashboard', $data);
        $this->load->view('order/mail_policy_package', $data);
    }

    public function downloadPolicyDoc()
	{
		$documentId = $this->input->post('documentId');
        $order_id = $this->input->post('order_id');
        $endPoint = 'documents/'.$documentId.'?format=json';
        $user_data['admin_api'] = 1;
        $user_data['from_mail'] = 1; 
        			
        $logid = $this->apiLogs->syncLogs(0, 'resware', 'get_resware_document', env('RESWARE_ORDER_API').$endPoint, array(), array(), $order_id, 0);
        $result = $this->resware->make_request('GET', $endPoint, '', $user_data);
        $this->apiLogs->syncLogs(0, 'resware', 'get_resware_document', env('RESWARE_ORDER_API').$endPoint, array(), $result,  $order_id, $logid);
        $res = json_decode($result, true);
        //echo "<pre>";
        //print_r($res);exit;
		if (isset($res['Document']) && !empty($res['Document'])) {
			echo $res['Document']['DocumentBody'];exit;
		}	
	}

    public function uploadBorrowerDocument($random_number)
    {
        $this->load->model('admin/escrow/tasks_model');
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
        $order = $this->getOrderInfo($random_number);
        $fileId = $order[0]['file_id'];  
        $data['title'] = 'Smart Dashboard | Pacific Coast Title Company';
        $data['mail_dashboard'] = 1;
        $data['orderDetails'] = $this->order->get_order_details($fileId, 1);
        $prod_type = $data['orderDetails']['prod_type'];
        $data['borrowerDocuments'] = $this->order->getBorrowerDocuments($data['orderDetails']['order_id']);
        $data['tasks'] = $this->tasks_model->get_many_by("(status = 1 and parent_task_id = 0 and (prod_type = 'both' or prod_type = '$prod_type') )");
        $this->load->view('layout/head_dashboard', $data);
        $this->load->view('order/mail_borrower_document', $data);
    }

    public function borrower_document_upload() 
	{
        $this->load->model('order/document');
		$success = array();
        $errors = array();
        $documentNames = array();
        $config['upload_path'] = './uploads/borrower/';
		$config['allowed_types'] = 'doc|docx|gif|msg|pdf|tif|tiff|xls|xlsx|xml';   
		$config['max_size'] = 18000;
		$this->load->library('upload', $config);
        $fileId = $this->input->post('file_id');

        if (!is_dir('uploads/borrower')) {
			mkdir('./uploads/borrower', 0777, TRUE);
		}

        if (!empty($_FILES['document_files']['name'])) {
            foreach ($_FILES['document_files']['name'] as $key => $file) {
                $_FILES['file']['name']= $_FILES['document_files']['name'][$key];
                $_FILES['file']['type']= $_FILES['document_files']['type'][$key];
                $_FILES['file']['tmp_name']= $_FILES['document_files']['tmp_name'][$key];
                $_FILES['file']['error']= $_FILES['document_files']['error'][$key];
                $_FILES['file']['size']= $_FILES['document_files']['size'][$key];
               
                if (! $this->upload->do_upload('file')) {
                    $errors[] = $this->upload->display_errors();
                } else { 
                    $data = $this->upload->data();
                    $contents = file_get_contents($data['full_path']);
                    $binaryData   = base64_encode($contents); 
                    $document_name = date('YmdHis')."_".$data['file_name'];
                    rename(FCPATH."/uploads/borrower/".$data['file_name'], FCPATH."/uploads/borrower/".$document_name);
                    $this->order->uploadDocumentOnAwsS3($document_name, 'borrower');

                    $documentData = array(
						'document_name' => $document_name,
						'original_document_name' => $data['file_name'],
						'document_type_id' => 1041,
						'document_size' => ($data['file_size'] * 1000),
						'user_id' => 0,
						'order_id' => $this->input->post('order_id'),
						'task_id' => $this->input->post('task_id'),
						'description' => 'Borrower Document',
						'is_sync' => 1,
						'is_uploaded_by_borrower' => 1
					);
                    $this->document->insert($documentData);
                    $success[] = $data['file_name']." uploaded successfully";
                    $documentNames[] = $data['file_name'];
                }
            }
        }		
	
		$data = array(
			"errors" =>  $errors,
			"success" => $success
		);
        
        $this->load->model('admin/escrow/order_model');
        $this->load->model('admin/escrow/escrow_user_model');
        $this->load->library('order/common');
        $this->load->model('admin/hr/order_users_model');
        $this->load->model('admin/hr/users_model');
        
        $orderInfo = $this->order_model->get($this->input->post('order_id'));
        if (count($documentNames) == 1 ) {
            $message = implode(',', $documentNames)." document uploaded by borrower for file number ".$orderInfo->file_number;
        } else {
            $message = implode(',', $documentNames)." documents uploaded by borrower for file number ".$orderInfo->file_number;
        }
		$this->session->set_userdata($data);
        if (!empty($orderInfo->escrow_officer_id)) {
            $escrowInfoFromOrder = $this->common->getEscrowOfficerInfoBasedOnIdFromOrder($orderInfo->escrow_officer_id); 
            $notificationData = array(
                'sent_user_id' => $escrowInfoFromOrder['id'],
                'message' => $message,
                'type' =>  'completed'
            );
            $this->home_model->insert($notificationData, 'pct_order_notifications');
            $this->order->sendNotification($message, 'completed', $escrowInfoFromOrder['id'], 0);
            
            $escrowHrInfo = $this->escrow_user_model->get_by(array('email' => $escrowInfoFromOrder['email_address']));
            $assistantUsersInfo = json_decode(json_encode($this->escrow_user_model->get_many_by(array('branch_id' => $escrowHrInfo->branch_id, 'position_id' => 15))), true);
            $assistantUserEmails = array_column($assistantUsersInfo, 'email');	
            $assistantOrderUsersInfo = $this->common->getAssistantUsers($assistantUserEmails); 
            
            if (!empty($assistantOrderUsersInfo)) {
                foreach ($assistantOrderUsersInfo as $assistantUser) {
                    $notificationData = array(
                        'sent_user_id' => $assistantUser['id'],
                        'message' => $message,
                        'type' =>  'completed'
                    );
                    $this->home_model->insert($notificationData, 'pct_order_notifications');
                    $this->order->sendNotification($message, 'completed', $assistantUser['id'], 0);
                }
            }

            $managersInfo = $this->users_model->get_many_by(array('user_type_id' => 4, 'department_id' => 4));
            foreach ($managersInfo as $manager) { 
                $notificationData = array(
                    'sent_user_id' => $manager->id,
                    'message' => $message,
                    'type' =>  'completed'
                );
                $this->home_model->insert($notificationData, 'pct_hr_notifications');
                $this->order->sendNotification($message, 'completed', $manager->id, 1);
            }
        }
		redirect(base_url().'borrower-document/'.$fileId);
	}

    public function borrowerSellerForm($random_number)
    {
        $data['title'] = 'Smart Dashboard | Pacific Coast Title Company';
        $data['mail_dashboard'] = 1;
        $order = $this->getOrderInfo($random_number);
        $data['orderDetails'] = $this->order->get_order_details($order[0]['file_id'], 1);
        $errors = array();
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

        if ($this->input->post()) {
            $borrowerSellerInfoData = array(
                'order_id' => $this->input->post('order_id'),
                'first_name' => $this->input->post('first_name'),
                'middle_name' => $this->input->post('middle_name'),
                'last_name' => $this->input->post('last_name'),
                'phone_number' => $this->input->post('phone_number'),
                'phone_number_type' => $this->input->post('phone_number_type'),
                'foreign_resident' => $this->input->post('foreign_resident'),
                'co_seller' => $this->input->post('co_seller'),
                'co_seller_first_name' => $this->input->post('co_seller_first_name') ? $this->input->post('co_seller_first_name') : null,
                'co_seller_middle_name' => $this->input->post('co_seller_middle_name') ? $this->input->post('co_seller_middle_name') : null,
                'co_seller_last_name' => $this->input->post('co_seller_last_name') ? $this->input->post('co_seller_last_name') : null,
                'co_seller_expiration_date' => $this->input->post('co_seller_expiration_date') ? $this->input->post('co_seller_expiration_date') : null,
                'co_seller_marital_status' => $this->input->post('co_seller_marital_status') ? $this->input->post('co_seller_marital_status') : null,
                'co_seller_ssn' => $this->input->post('co_seller_ssn') ? $this->input->post('co_seller_ssn') : null,
                'co_seller_email' => $this->input->post('co_seller_email') ? $this->input->post('co_seller_email') : null,
                'co_seller_phone_number' => $this->input->post('co_seller_phone_number') ? $this->input->post('co_seller_phone_number') : null,
                'co_seller_phone_number_type' => $this->input->post('co_seller_phone_number_type') ? $this->input->post('co_seller_phone_number_type') : null,
                'co_seller_foreign_resident' => $this->input->post('co_seller_foreign_resident') ? $this->input->post('co_seller_foreign_resident') : null,
                'attending' => $this->input->post('attending'),
            );
            $this->home_model->insert($borrowerSellerInfoData,'pct_order_borrower_selller_info');

            $borrowerSellerPropertyInfoData = array(
                'order_id' => $this->input->post('order_id'),
                'property_address' => $this->input->post('property_address'),
                'is_correct_property_address' => $this->input->post('is_correct_property_address'),
                'property_street_address' => $this->input->post('property_street_address') ? $this->input->post('property_street_address') : null,
                'property_city' => $this->input->post('property_city') ? $this->input->post('property_city') : null,
                'property_state' => $this->input->post('property_state') ? $this->input->post('property_state') : null,
                'property_zip_code' => $this->input->post('property_zip_code') ? $this->input->post('property_zip_code') : null,
                'is_property_address_as_current_address' => $this->input->post('is_property_address_as_current_address'),
                'current_street_address' => $this->input->post('current_street_address') ? $this->input->post('current_street_address') : null,
                'current_city' => $this->input->post('current_city') ? $this->input->post('current_city') : null,
                'current_state' => $this->input->post('current_state') ? $this->input->post('current_state') : null,
                'current_zip_code' => $this->input->post('current_zip_code') ? $this->input->post('current_zip_code') : null,
                'is_forwarding_address_different_from_current_address' => $this->input->post('is_forwarding_address_different_from_current_address'),
                'forwarding_street_address' => $this->input->post('forwarding_street_address') ? $this->input->post('forwarding_street_address') : null,
                'forwarding_city' => $this->input->post('forwarding_city') ? $this->input->post('forwarding_city') : null,
                'forwarding_state' => $this->input->post('forwarding_state') ? $this->input->post('forwarding_state') : null,
                'forwarding_zip_code' => $this->input->post('forwarding_zip_code') ? $this->input->post('forwarding_zip_code') : null,
                'residence' => $this->input->post('residence'),
                'is_insurance_policy' => $this->input->post('is_insurance_policy'),
                'insurance_policy_file_name' => $this->input->post('insurance_policy_file_name') ? $this->input->post('insurance_policy_file_name') : null,
            );
            $this->home_model->insert($borrowerSellerPropertyInfoData, 'pct_order_borrower_selller_property_info');

            $borrowerSellerAgentInfoData = array(
                'order_id' => $this->input->post('order_id'),
                'is_real_estate' => $this->input->post('is_real_estate'),
                'agent_first_name' => $this->input->post('agent_first_name') ? $this->input->post('agent_first_name') : null,
                'agent_middle_name' => $this->input->post('agent_middle_name') ? $this->input->post('agent_middle_name') : null,
                'agent_last_name' => $this->input->post('agent_last_name') ? $this->input->post('agent_last_name') : null,
                'agent_company' => $this->input->post('agent_company') ? $this->input->post('agent_company') : null,
                'agent_company_address' => $this->input->post('agent_company_address') ? $this->input->post('agent_company_address') : null,
                'agent_company_city' => $this->input->post('agent_company_city') ? $this->input->post('agent_company_city') : null,
                'agent_company_state' => $this->input->post('agent_company_state') ? $this->input->post('agent_company_state') : null,
                'agent_company_zip_code' => $this->input->post('agent_company_zip_code') ? $this->input->post('agent_company_zip_code') : null,
                'amount_percent_commission' => $this->input->post('amount_percent_commission') ? $this->input->post('amount_percent_commission') : null,
                'amount_deduction' => $this->input->post('amount_deduction') ? $this->input->post('amount_deduction') : null,
                'agent_phone' => $this->input->post('agent_phone') ? $this->input->post('agent_phone') : null,
                'agent_email' => $this->input->post('agent_email') ? $this->input->post('agent_email') : null,
                'seller_invoices' => $this->input->post('seller_invoices') ? implode(',', $this->input->post('seller_invoices')) : null,
            );
            $this->home_model->insert($borrowerSellerAgentInfoData, 'pct_order_borrower_selller_agent_info');

            $borrowerSellerMortgageInfoData = array(
                'order_id' => $this->input->post('order_id'),
                'is_mortgage' => $this->input->post('is_mortgage'),
                'is_mortgage_credit' => $this->input->post('is_mortgage_credit') ? $this->input->post('is_mortgage_credit') : null,
                'mortgage_holder' => $this->input->post('mortgage_holder') ? $this->input->post('mortgage_holder') : null,
                'loan_amount' => $this->input->post('loan_amount') ? $this->input->post('loan_amount') : null,
                'mortgage_phone' => $this->input->post('mortgage_phone') ? $this->input->post('mortgage_phone') : null,
                'loan_number' => $this->input->post('loan_number') ? $this->input->post('loan_number') : null,
                'loan_balance' => $this->input->post('loan_balance') ? $this->input->post('loan_balance') : null,
                'account_holder_name' => $this->input->post('account_holder_name') ? $this->input->post('account_holder_name') : null,
                'is_creditcard_lock' => $this->input->post('is_creditcard_lock') ? $this->input->post('is_creditcard_lock') : null,
                'is_second_mortgage' => $this->input->post('is_second_mortgage') ? $this->input->post('is_second_mortgage') : null,
                'is_second_mortgage_credit' => $this->input->post('is_second_mortgage_credit') ? $this->input->post('is_second_mortgage_credit') : null,
                'second_mortgage_holder' => $this->input->post('second_mortgage_holder') ? $this->input->post('second_mortgage_holder') : null,
                'second_loan_amount' => $this->input->post('second_loan_amount') ? $this->input->post('second_loan_amount') : null,
                'second_mortgage_phone' => $this->input->post('second_mortgage_phone') ? $this->input->post('second_mortgage_phone') : null,
                'second_loan_number' => $this->input->post('second_loan_number') ? $this->input->post('second_loan_number') : null,
                'second_loan_balance' => $this->input->post('second_loan_balance') ? $this->input->post('second_loan_balance') : null,
                'second_account_holder_name' => $this->input->post('second_account_holder_name') ? $this->input->post('second_account_holder_name') : null,
                'is_second_creditcard_lock' => $this->input->post('is_second_creditcard_lock') ? $this->input->post('is_second_creditcard_lock') : null,
            );
            $this->home_model->insert($borrowerSellerMortgageInfoData, 'pct_order_borrower_selller_mortgage_info');    
  
            $borrowerSellerOtherInfoData = array(
                'order_id' => $this->input->post('order_id'),
                'is_exchange_residence' => $this->input->post('is_exchange_residence'),
                'is_not_exchange_residence' => $this->input->post('is_not_exchange_residence'),
                'is_former_spouse' => $this->input->post('is_former_spouse'),
                'is_married' => $this->input->post('is_married'),
                'is_period' => $this->input->post('is_period'),
                'is_revenue' => $this->input->post('is_revenue'),
                'is_attorney' => $this->input->post('is_attorney'),
                'firm_name' => $this->input->post('firm_name') ? $this->input->post('firm_name') : null,
                'firm_phone_number' => $this->input->post('firm_phone_number') ? $this->input->post('firm_phone_number') : null,
                'attorney_name' => $this->input->post('attorney_name') ? $this->input->post('attorney_name') : null,
                'attorney_phone_number' => $this->input->post('attorney_phone_number') ? $this->input->post('attorney_phone_number') : null,
                'attorney_email' => $this->input->post('attorney_email') ? $this->input->post('attorney_email') : null,
            );
            $this->home_model->insert($borrowerSellerOtherInfoData, 'pct_order_borrower_selller_other_info');    

            $borrowerSellerHoaInfoData = array(
                'order_id' => $this->input->post('order_id'),
                'is_property_hoa' => $this->input->post('is_property_hoa'),
                'hoa_management_company_name' => $this->input->post('hoa_management_company_name') ? $this->input->post('hoa_management_company_name') : null,
                'hoa_contact_person' => $this->input->post('hoa_contact_person') ? $this->input->post('hoa_contact_person') : null,
                'hoa_email' => $this->input->post('hoa_email') ? $this->input->post('hoa_email') : null,
                'hoa_phone' => $this->input->post('hoa_phone') ? $this->input->post('hoa_phone') : null,
                'hoa_dues' => $this->input->post('hoa_dues') ? $this->input->post('hoa_dues') : null,
                'hoa_dues_per' => $this->input->post('hoa_dues_per') ? $this->input->post('hoa_dues_per') : null,
                'hoa_notes' => $this->input->post('hoa_notes') ? $this->input->post('hoa_notes') : null,
                'is_property_second_hoa' => $this->input->post('is_property_second_hoa') ? $this->input->post('is_property_second_hoa') : null,
                'second_hoa_management_company_name' => $this->input->post('second_hoa_management_company_name') ? $this->input->post('second_hoa_management_company_name') : null,
                'second_hoa_contact_person' => $this->input->post('second_hoa_contact_person') ? $this->input->post('second_hoa_contact_person') : null,
                'second_hoa_email' => $this->input->post('second_hoa_email') ? $this->input->post('second_hoa_email') : null,
                'second_hoa_phone' => $this->input->post('second_hoa_phone') ? $this->input->post('second_hoa_phone') : null,
                'second_hoa_dues' => $this->input->post('second_hoa_dues') ? $this->input->post('second_hoa_dues') : null,
                'second_hoa_dues_per' => $this->input->post('second_hoa_dues_per') ? $this->input->post('second_hoa_dues_per') : null,
                'second_hoa_notes' => $this->input->post('second_hoa_notes') ? $this->input->post('second_hoa_notes') : null,
            );
            $this->home_model->insert($borrowerSellerHoaInfoData, 'pct_order_borrower_selller_hoa_info');   
            
            $pdfData = array_merge($borrowerSellerInfoData, $borrowerSellerPropertyInfoData, $borrowerSellerAgentInfoData, $borrowerSellerMortgageInfoData, $borrowerSellerOtherInfoData, $borrowerSellerHoaInfoData);
            $pdfData['seller_invoices'] = $this->input->post('seller_invoices');
            $pdfData['full_address'] = $data['orderDetails']['full_address'];
            $pdfData['apn'] = $data['orderDetails']['apn'];

            $this->load->model('order/document');
            $borrowerDocumentCount = $this->document->countBorrowerDocument($data['orderDetails']['id']);
            $document_name = "borrower_seller_".$borrowerDocumentCount."_".$order[0]['file_id'].".pdf";
            if (!is_dir('uploads/borrower')) {
                mkdir('./uploads/borrower', 0777, TRUE);
            }
            $pdfFilePath = './uploads/borrower/'.$document_name;

            try {
                ob_clean(); 
                $mpdf = new \Mpdf\Mpdf();
                ini_set("pcre.backtrack_limit", "5000000");
                $html = $this->load->view('order/borrower_seller_pdf', $pdfData, true);
                $stylesheet = file_get_contents('https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,300;0,400;0,500;0,600;0,700;1,200&display=swap');
                $mpdf->WriteHTML($stylesheet, 1);
                $stylesheet1 = file_get_contents('assets/frontend/css/buyer-seller-package/bootstrap.min.css');
                $mpdf->WriteHTML($stylesheet1, 1);
                $stylesheet2 = file_get_contents('assets/frontend/css/buyer-seller-package/style_pdf.css');
                $mpdf->WriteHTML($stylesheet2, 1);
                $mpdf->WriteHTML($html,2);
                $mpdf->Output($pdfFilePath,'F');
                ob_end_flush();
            } catch (\Mpdf\MpdfException $e) {
                echo $e->getMessage();
            }

            $this->home_model->update(array('borrower_information_document_name' => $document_name), array('file_id' => $data['orderDetails']['file_id']), 'order_details');
            $documentData = array(
                'document_name' => $document_name,
                'original_document_name' => $document_name,
                'document_type_id' => 1041,
                'document_size' => 0,
                'user_id' => 0,
                'order_id' => $data['orderDetails']['order_id'],
                'task_id' => 4,
                'description' => 'Borrower Seller Document',
                'is_sync' => 1,
                'is_uploaded_by_borrower' => 1
            );
            $this->document->insert($documentData);
            $this->order->uploadDocumentOnAwsS3($document_name, 'borrower');

            $success[] = "Borrower seller info saved successfully and sent to Escrow officer/assistant users to verify data.";
            $data = array(
                "errors" =>  $errors,
                "success" => $success
            );
            $this->session->set_userdata($data);
            redirect(base_url().'borrower-seller-form/'.$random_number);exit;
        }
        $this->load->view('order/borrower_seller', $data);
    }

    public function borrowerBuyerForm($random_number)
    {
        echo "heheh1";
        error_reporting(E_ALL);
ini_set('display_errors', '1');
        $data['title'] = 'Smart Dashboard | Pacific Coast Title Company';
        $data['mail_dashboard'] = 1;
        $order = $this->getOrderInfo($random_number);
        $data['orderDetails'] = $this->order->get_order_details($order[0]['file_id'], 1);
        $errors = array();
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

        if ($this->input->post()) {
            $borrowerBuyerInfoData = array(
                'order_id' => $this->input->post('order_id'),
                'property_address' => $this->input->post('property_address'),
                'property_address2' => $this->input->post('property_address2'),
                'property_city' => $this->input->post('property_city'),
                'property_state' => 'CA',
                'property_zip_code' => $this->input->post('property_zipcode'),
                'first_name' => $this->input->post('first_name'),
                'middle_name' => $this->input->post('middle_name'),
                'last_name' => $this->input->post('last_name'),
                'phone_number' => $this->input->post('phone_number'),
                'email' => $this->input->post('email'),
                'second_buyer_first_name' => $this->input->post('second_buyer_first_name'),
                'second_buyer_middle_name' => $this->input->post('second_buyer_middle_name'),
                'second_buyer_last_name' => $this->input->post('second_buyer_last_name'),
                'second_buyer_phone_number' => $this->input->post('second_buyer_phone_number'),
                'second_buyer_email' => $this->input->post('second_buyer_email'),
                'is_same_property_address_as_forwarding_address' => $this->input->post('is_same_property_address_as_forwarding_address'),
                'forwarding_street_address' => $this->input->post('forwarding_street_address') ? $this->input->post('forwarding_street_address') : null,
                'forwarding_street_address2' => $this->input->post('forwarding_street_address2') ? $this->input->post('forwarding_street_address2') : null,
                'forwarding_city' => $this->input->post('forwarding_city') ? $this->input->post('forwarding_city') : null,
                'forwarding_state' => $this->input->post('forwarding_state') ? $this->input->post('forwarding_state') : null,
                'forwarding_zip_code' => $this->input->post('forwarding_zip_code') ? $this->input->post('forwarding_zip_code') : null,
                'vesting_form_date' => $this->input->post('vesting_form_date'),
                'vesting_form_signature' => $this->input->post('vesting_form_signature'),
                'tenant_id' => $this->input->post('tenant_id'),
                'doc_type' => $this->input->post('doc_type')
            );
            $this->home_model->insert($borrowerBuyerInfoData,'pct_order_borrower_buyer_info');

            $borrowerBuyerEscrowInsData = array(
                'order_id' => $this->input->post('order_id'),
                'is_mortgage' => $this->input->post('is_mortgage'),
                'is_liens' => $this->input->post('is_liens'),
                'is_condominium' => $this->input->post('is_condominium'),
                'is_residence' => $this->input->post('is_residence'),
                'is_divorced' => $this->input->post('is_divorced'),
                'is_changed' => $this->input->post('is_changed') ,
                'is_death' => $this->input->post('is_death'),
                'is_survey' => $this->input->post('is_survey'),
                'is_structural' => $this->input->post('is_structural'),
                'is_insurance' => $this->input->post('is_insurance'),
                'water_service' => $this->input->post('water_service'),
                'other_water_service_name' => $this->input->post('other_water_service_name') ? $this->input->post('other_water_service_name') : null,
                'water_service_provider_name' => $this->input->post('water_service_provider_name'),
                'first_mortgage_company' => $this->input->post('first_mortgage_company') ? $this->input->post('first_mortgage_company') : null,
                'first_mortgage_loan_number' => $this->input->post('first_mortgage_loan_number') ? $this->input->post('first_mortgage_loan_number') : null,
                'first_mortgage_area_code' => $this->input->post('first_mortgage_area_code') ? $this->input->post('first_mortgage_area_code') : null,
                'first_mortgage_phone_number' => $this->input->post('first_mortgage_phone_number') ? $this->input->post('first_mortgage_phone_number') : null,
                'second_mortgage_company' => $this->input->post('second_mortgage_company') ? $this->input->post('second_mortgage_company') : null,
                'second_mortgage_loan_number' => $this->input->post('second_mortgage_loan_number') ? $this->input->post('second_mortgage_loan_number') : null,
                'second_mortgage_area_code' => $this->input->post('second_mortgage_area_code') ? $this->input->post('second_mortgage_area_code') : null,
                'second_mortgage_phone_number' => $this->input->post('second_mortgage_phone_number') ? $this->input->post('second_mortgage_phone_number') : null,
                'third_mortgage_company' => $this->input->post('third_mortgage_company') ? $this->input->post('third_mortgage_company') : null,
                'third_mortgage_loan_number' => $this->input->post('third_mortgage_loan_number') ? $this->input->post('third_mortgage_loan_number') : null,
                'third_mortgage_area_code' => $this->input->post('third_mortgage_area_code') ? $this->input->post('third_mortgage_area_code') : null,
                'third_mortgage_phone_number' => $this->input->post('third_mortgage_phone_number') ? $this->input->post('third_mortgage_phone_number') : null,
                'first_lien_holder_name' => $this->input->post('first_lien_holder_name') ? $this->input->post('first_lien_holder_name') : null,
                'first_amount_owed' => $this->input->post('first_amount_owed') ? $this->input->post('first_amount_owed') : null,
                'second_lien_holder_name' => $this->input->post('second_lien_holder_name') ? $this->input->post('second_lien_holder_name') : null,
                'second_amount_owed' => $this->input->post('second_amount_owed') ? $this->input->post('second_amount_owed') : null,
                'first_homeowners_association' => $this->input->post('first_homeowners_association') ? $this->input->post('first_homeowners_association') : null,
                'first_property_management_company' => $this->input->post('first_property_management_company') ? $this->input->post('first_property_management_company') : null,
                'first_property_management_number' => $this->input->post('first_property_management_number') ? $this->input->post('first_property_management_number') : null,
                'second_homeowners_association' => $this->input->post('second_homeowners_association') ? $this->input->post('second_homeowners_association') : null,
                'second_property_management_company' => $this->input->post('second_property_management_company') ? $this->input->post('second_property_management_company') : null,
                'second_property_management_number' => $this->input->post('second_property_management_number') ? $this->input->post('second_property_management_number') : null,
            );
            $this->home_model->insert($borrowerBuyerEscrowInsData, 'pct_order_borrower_buyer_escrow_instructions');

            $borrowerBuyerStatementInfoData = array(
                'order_id' => $this->input->post('order_id'),
                'sale_proceeds' => $this->input->post('sale_proceeds'),
                'name_on_account' => $this->input->post('name_on_account') ? $this->input->post('name_on_account') : null,
                'bank_name' => $this->input->post('bank_name') ? $this->input->post('bank_name') : null,
                'bank_city' => $this->input->post('bank_city') ? $this->input->post('bank_city') : null,
                'bank_state' => $this->input->post('bank_state') ? $this->input->post('bank_state') : null,
                'account_number' => $this->input->post('account_number') ? $this->input->post('account_number') : null,
                'routing_number' => $this->input->post('routing_number') ? $this->input->post('routing_number') : null,
                'street_address_for_account' => $this->input->post('street_address_for_account') ? $this->input->post('street_address_for_account') : null,
                'street_address2_for_account' => $this->input->post('street_address2_for_account') ? $this->input->post('street_address2_for_account') : null,
                'city_for_account' => $this->input->post('city_for_account') ? $this->input->post('city_for_account') : null,
                'state_for_account' => $this->input->post('state_for_account') ? $this->input->post('state_for_account') : null,
                'zipcode_for_account' => $this->input->post('zipcode_for_account') ? $this->input->post('zipcode_for_account') : null,
                'closing_proceeds_street_address' => $this->input->post('closing_proceeds_street_address') ? $this->input->post('closing_proceeds_street_address') : null,
                'closing_proceeds_street_address2' => $this->input->post('closing_proceeds_street_address2') ? $this->input->post('closing_proceeds_street_address2') : null,
                'closing_proceeds_city' => $this->input->post('closing_proceeds_city') ? $this->input->post('closing_proceeds_city') : null,
                'closing_proceeds_state' => $this->input->post('closing_proceeds_state') ? $this->input->post('closing_proceeds_state') : null,
                'closing_proceeds_zipcode' => $this->input->post('closing_proceeds_zipcode') ? $this->input->post('closing_proceeds_zipcode') : null
            );
            $this->home_model->insert($borrowerBuyerStatementInfoData, 'pct_order_borrower_buyer_statement_of_info');   

            $borrowerBuyerPreliminaryInfoData = array(
                'order_id' => $this->input->post('order_id'),
                'assessors_parcel_number' => $this->input->post('assessors_parcel_number'),
                'transferor' => $this->input->post('transferor'),
                'buyer_daytime_phone_number' => $this->input->post('buyer_daytime_phone_number'),
                'buyer_email_address' => $this->input->post('buyer_email_address'),
                'real_property_addres' => $this->input->post('real_property_addres'),
                'is_principal_residence' => $this->input->post('is_principal_residence'),
                'date_of_occupancy' => $this->input->post('intended_occupancy_day')."-".$this->input->post('intended_occupancy_month')."-".$this->input->post('intended_occupancy_year'),
                'is_disabled_veteran' => $this->input->post('is_disabled_veteran') ,
                'mail_property_tax_name' => $this->input->post('mail_property_tax_name'),
                'mail_property_tax_address' => $this->input->post('mail_property_tax_address'),
                'mail_property_tax_city' => $this->input->post('mail_property_tax_city'),
                'mail_property_tax_state' => $this->input->post('mail_property_tax_state'),
                'mail_property_tax_zipcode' => $this->input->post('mail_property_tax_zipcode')
            );
            $this->home_model->insert($borrowerBuyerPreliminaryInfoData, 'pct_order_borrower_buyer_preliminary_change_info');

            $borrowerBuyerTransferInfoData = array(
                'order_id' => $this->input->post('order_id'),
                'is_transfer_between_spouses' => $this->input->post('is_transfer_between_spouses'),
                'is_transfer_between_domestic_partners' => $this->input->post('is_transfer_between_domestic_partners'),
                'is_transfer' => $this->input->post('is_transfer'),
                'is_parent_child_transfer' => $this->input->post('is_parent_child_transfer'),
                'is_principal_residence' => $this->input->post('is_principal_residence'),
                'date_of_death' => $this->input->post('date_of_death'),
                'bank_name' => $this->input->post('bank_name') ? $this->input->post('bank_name') : '',
                'is_replace_principal_residence_own' => $this->input->post('is_replace_principal_residence_own'),
                'is_replace_principal_residence_own_in_same_county' => $this->input->post('is_replace_principal_residence_own_in_same_county'),
                'is_replace_principal_residence_person_disabled' => $this->input->post('is_replace_principal_residence_person_disabled') ,
                'is_replace_principal_residence_person_disabled_in_same_county' => $this->input->post('is_replace_principal_residence_person_disabled_in_same_county'),
                'is_replace_principal_residence_damaged' => $this->input->post('is_replace_principal_residence_damaged'),
                'is_replace_principal_residence_damaged_in_same_county' => $this->input->post('is_replace_principal_residence_damaged_in_same_county'),
                'is_name_change' => $this->input->post('is_name_change'),
                'name_change_reason' => $this->input->post('name_change_reason') ? $this->input->post('name_change_reason') : '',
                'is_lender_interest' => $this->input->post('is_lender_interest'),
                'is_financing_purpose' => $this->input->post('is_financing_purpose'),
                'financing_purpose_reason' => $this->input->post('financing_purpose_reason') ? $this->input->post('financing_purpose_reason') : null,
                'is_trustee_of_trust' => $this->input->post('is_trustee_of_trust'),
                'is_transfer_property' => $this->input->post('is_transfer_property'),
                'benefit' => $this->input->post('benefit'),
                'trustor' => $this->input->post('trustor'),
                'is_subject_to_lease' => $this->input->post('is_subject_to_lease'),
                'is_transfer_between_parties' => $this->input->post('is_transfer_between_parties'),
                'is_subsidized_low_income' => $this->input->post('is_subsidized_low_income'),
                'is_solar_energy_system' => $this->input->post('is_solar_energy_system'),
                'is_transfer_other' => $this->input->post('is_transfer_other'),
                'other_transfer' => $this->input->post('other_transfer') ? $this->input->post('other_transfer') : null,
                'recording_date' => $this->input->post('recording_date'),
                'types_of_transfer' => implode(",", $this->input->post('types_of_transfer')),
                'date_of_contract' => $this->input->post('date_of_contract'),
                'date_of_lease_began' => $this->input->post('date_of_lease_began'),
                'original_terms_in_year' => $this->input->post('original_terms_in_year') ? $this->input->post('original_terms_in_year') : null,
                'remaining_terms_in_year' => $this->input->post('remaining_terms_in_year') ? $this->input->post('remaining_terms_in_year') : null,
                'is_partial_interest' => $this->input->post('is_partial_interest'),
                'start_percentage_range' => $this->input->post('start_percentage_range') ? $this->input->post('start_percentage_range') : null,
                'end_percentage_range' => $this->input->post('end_percentage_range') ? $this->input->post('end_percentage_range') : null,
            );
            $this->home_model->insert($borrowerBuyerTransferInfoData, 'pct_order_borrower_buyer_transfer_info');    
    

            $borrowerBuyerPurchaseSaleInfoData = array(
                'order_id' => $this->input->post('order_id'),
                'total_purchase_price' => $this->input->post('total_purchase_price'),
                'cash_down_payment' => $this->input->post('cash_down_payment'),
                'first_deed_of_trust_interest' => $this->input->post('first_deed_of_trust_interest') ? $this->input->post('first_deed_of_trust_interest') : null,
                'first_deed_of_trust_years' => $this->input->post('first_deed_of_trust_years') ? $this->input->post('first_deed_of_trust_years') : null,
                'first_deed_of_trust_monthly_payment' => $this->input->post('first_deed_of_trust_monthly_payment') ? $this->input->post('first_deed_of_trust_monthly_payment') : null,
                'first_deed_payment_types' => $this->input->post('first_deed_payment_types') ? implode(',', $this->input->post('first_deed_payment_types')) : null,
                'first_deed_due_date' => $this->input->post('first_deed_due_date') ? $this->input->post('first_deed_due_date') : null,
                'second_deed_of_trust_interest' => $this->input->post('second_deed_of_trust_interest') ? $this->input->post('second_deed_of_trust_interest') : null,
                'second_deed_of_trust_years' => $this->input->post('second_deed_of_trust_years') ? $this->input->post('second_deed_of_trust_years') : null,
                'second_deed_of_trust_monthly_payment' => $this->input->post('second_deed_of_trust_monthly_payment') ? $this->input->post('second_deed_of_trust_monthly_payment') : null,
                'second_deed_of_trust_amount' => $this->input->post('second_deed_of_trust_amount') ? $this->input->post('second_deed_of_trust_amount') : null,
                'second_deed_payment_types' => $this->input->post('second_deed_payment_types') ? implode(',', $this->input->post('second_deed_payment_types')) : null,
                'ballon_payment' => $this->input->post('ballon_payment') ? $this->input->post('ballon_payment') : null,
                'second_deed_due_date' => $this->input->post('second_deed_due_date') ? $this->input->post('second_deed_due_date') : null,
                'is_financing' => $this->input->post('is_financing') ? $this->input->post('is_financing') : null,
                'outstanding_balance' => $this->input->post('outstanding_balance') ? $this->input->post('outstanding_balance') : null,
                'real_estate_commission' => $this->input->post('real_estate_commission') ? $this->input->post('real_estate_commission') : null,
                'property_purchase_via' => $this->input->post('property_purchase_via'),
                'broker_phone_number' => $this->input->post('broker_phone_number') ? $this->input->post('broker_phone_number') : null,
                'property_purchase_via_name' => $this->input->post('property_purchase_via_name') ? $this->input->post('property_purchase_via_name') : null,
                'broker_name' => $this->input->post('broker_name') ? $this->input->post('broker_name') : null,
                'other_through' => $this->input->post('other_through') ? $this->input->post('other_through') : null,
                'types_of_property_transferred' => implode(',', $this->input->post('types_of_property_transferred')),
                'num_of_units' => $this->input->post('num_of_units') ? $this->input->post('num_of_units') : null,
                'is_personal_property' => $this->input->post('is_personal_property'),
                'peronal_property_value' => $this->input->post('peronal_property_value') ? $this->input->post('peronal_property_value') : null,
                'incentives' => $this->input->post('incentives') ? $this->input->post('incentives') : null,
                'is_manufacture_home_included_in_purchase_price' => $this->input->post('is_manufacture_home_included_in_purchase_price'),
                'value_manufacture_home' => $this->input->post('value_manufacture_home') ? $this->input->post('value_manufacture_home') : null,
                'is_manufacture_home_tax' => $this->input->post('is_manufacture_home_tax'),
                'deal_number' => $this->input->post('deal_number') ? $this->input->post('deal_number') : null,
                'is_property_produce_income' => $this->input->post('is_property_produce_income'),
                'income_type' => $this->input->post('income_type') ? $this->input->post('income_type') : null,
                'other_income_type' => $this->input->post('other_income_type') ? $this->input->post('other_income_type') : null,
                'property_condition' => $this->input->post('property_condition'),
                'property_condition_describe' => $this->input->post('property_condition_describe') ? $this->input->post('property_condition_describe') : null,
                'signature_corporate_officer_date' => $this->input->post('signature_corporate_officer_date'),
                'corporate_officer_telephone' => $this->input->post('corporate_officer_telephone'),
                'corporate_officer_name' => $this->input->post('corporate_officer_name'),
                'corporate_officer_email' => $this->input->post('corporate_officer_email'),
            );
            $this->home_model->insert($borrowerBuyerPurchaseSaleInfoData, 'pct_order_borrower_buyer_purchase_sale_info');   
            
            $pdfData = array_merge($borrowerBuyerInfoData, $borrowerBuyerEscrowInsData, $borrowerBuyerStatementInfoData, $borrowerBuyerPreliminaryInfoData, $borrowerBuyerTransferInfoData, $borrowerBuyerPurchaseSaleInfoData);
            $pdfData['full_address'] = $data['orderDetails']['full_address'];
            $pdfData['types_of_transfer'] = $this->input->post('types_of_transfer');
            $pdfData['first_deed_payment_types'] = $this->input->post('first_deed_payment_types') ? $this->input->post('first_deed_payment_types') : array();
            $pdfData['types_of_property_transferred'] = $this->input->post('types_of_property_transferred') ? $this->input->post('types_of_property_transferred') : array();
            $pdfData['second_deed_payment_types'] = $this->input->post('second_deed_payment_types') ? $this->input->post('second_deed_payment_types') : array();
            
            $this->load->model('order/document');
            $borrowerDocumentCount = $this->document->countBorrowerDocument($data['orderDetails']['id']);
            $document_name = "borrower_buyer_".$borrowerDocumentCount."_".$order[0]['file_id'].".pdf";
            if (!is_dir('uploads/borrower')) {
                mkdir('./uploads/borrower', 0777, TRUE);
            }
            $pdfFilePath = './uploads/borrower/'.$document_name;

            try {
                //ob_clean(); 
                $mpdf = new \Mpdf\Mpdf();
                // ini_set("pcre.backtrack_limit", "5000000");
                // $html = $this->load->view('order/borrower_buyer_pdf', $pdfData, true);
                // $stylesheet = file_get_contents('https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,300;0,400;0,500;0,600;0,700;1,200&display=swap');
                // $mpdf->WriteHTML($stylesheet, 1);
                // //$stylesheet1 = file_get_contents('assets/frontend/css/buyer-seller-package/bootstrap.min.css');
                // //$mpdf->WriteHTML($stylesheet1, 1);
                // $stylesheet2 = file_get_contents('assets/frontend/css/buyer-seller-package/style_pdf.css');
                // $mpdf->WriteHTML($stylesheet2, 1);
                // $mpdf->WriteHTML($html,2);
                // $mpdf->Output($pdfFilePath,'F');
                // ob_end_flush();
            } catch (\Mpdf\MpdfException $e) { 
                //echo $e->getMessage();
            }

            // $this->home_model->update(array('borrower_information_document_name' => $document_name), array('file_id' => $data['orderDetails']['file_id']), 'order_details');
            // $documentData = array(
            //     'document_name' => $document_name,
            //     'original_document_name' => $document_name,
            //     'document_type_id' => 1041,
            //     'document_size' => 0,
            //     'user_id' => 0,
            //     'order_id' => $data['orderDetails']['order_id'],
            //     'task_id' => 4,
            //     'description' => 'Borrower Buyer Document',
            //     'is_sync' => 1,
            //     'is_uploaded_by_borrower' => 1
            // );
            // $this->document->insert($documentData);
            // $this->order->uploadDocumentOnAwsS3($document_name, 'borrower');
            // $success[] = "Borrower buyer info saved successfully and sent to Escrow officer/assistant users to verify data.";
            // $data = array(
            //     "errors" =>  $errors,
            //     "success" => $success
            // );
            // $this->session->set_userdata($data);
            //redirect(base_url().'borrower-buyer-form/'.$random_number);exit;
        }
        $this->load->view('order/borrower_buyer', $data);
    }
}