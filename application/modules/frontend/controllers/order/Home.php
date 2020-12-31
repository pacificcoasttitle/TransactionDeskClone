<?php

(defined('BASEPATH')) OR exit('No direct script access allowed');

class Home extends MX_Controller {

    function __construct() {
        parent::__construct();
        $this->load->helper(array('file', 'url'));
        $this->load->library('session');
		$this->load->model('order/home_model');
		$this->load->model('order/agent_model');
		$this->load->library('form_validation');
		$this->load->library('order/order');
		$this->load->model('order/titlePointData');
		$this->load->model('order/productType');
		$this->order->is_user();
    }

    function index() 
    {
    	$userdata = $this->session->userdata('user');
		$this->load->model('order/apiLogs');
		$this->load->model('order/titleOfficer');
		$this->load->model('order/salesRep');
		$this->load->model('order/partnerApiLogs');
		$this->load->library('order/titlepoint');

    	if(isset($_POST) && !empty($_POST))
    	{
    		$random_number = $this->input->post('random_number');
    		if(isset($random_number) && !empty($random_number))
    		{
    			$condition = array(
		            'where' => array(
		                'session_id' => 'tp_api_id_'.$random_number,
		            ),
		            'returnType' => 'count'
		        );

				$count = $this->titlePointData->gettitlePointDetails($condition);

				if($count != 1)
				{
					$response = array('status'=>'error', 'message'=> 'Something went wrong.Please hard refresh(Ctrl+F5) your page.');
					echo json_encode($response); exit;
				}
    		}
    		else
    		{
    			$response = array('status'=>'error', 'message'=> 'Something went wrong.Please hard refresh (Ctrl+F5) your page.');
				echo json_encode($response); exit;
    		}
    		$this->form_validation->set_rules('OpenName', 'First Name', 'required',array('required'=> 'Enter your first name'));
    		$this->form_validation->set_rules('OpenLastName', 'Last Name', 'required',array('required'=> 'Enter your last name'));
			$this->form_validation->set_rules('OpenEmail', 'Email Address', 'required',array('required'=> 'Enter your email address'));
			
			$config['upload_path'] = './uploads/curative/';
			$config['allowed_types'] = 'doc|docx|gif|msg|pdf|tif|tiff|xls|xlsx|xml';   
			$config['max_size'] = 20000;
			$this->load->library('upload', $config);

			if (!empty($_FILES['upload_curative']['name'])) {
				if (! $this->upload->do_upload('upload_curative')) {
					$response = array('status'=>'error', 'message'=> $this->upload->display_errors());
					echo json_encode($response); exit;
				}
			}

			$result = $this->order->checkDuplicateOrder($this->input->post('apn'));
			if ($result) {	
				$response = array('status'=>'error', 'message'=> 'Order is already exist for this property.');
				echo json_encode($response); exit;
			}

    		$parties_email = array();
    		if($this->form_validation->run($this) == true)
    		{
	        	$OpenName      = $this->input->post('OpenName');
	        	$OpenLastName      = $this->input->post('OpenLastName');
	        	$Opentelephone      = $this->input->post('Opentelephone');
	        	$OpenEmail      = $this->input->post('OpenEmail');
	        	$CompanyName      = $this->input->post('CompanyName');
	        	$StreetAddress      = $this->input->post('StreetAddress');
	        	$City      = $this->input->post('City');
	        	$Zipcode      = $this->input->post('Zipcode');
	        	$PropertyAddress      = $this->input->post('Property');

	        	$SplitPropertyAddress = explode(' ',$PropertyAddress);

				$StreetNumber = isset($SplitPropertyAddress[0]) && !empty($SplitPropertyAddress[0]) ? $SplitPropertyAddress[0] : '';

				$PrimaryStreetName = array_slice($SplitPropertyAddress, 1);

				$StreetName = isset($PrimaryStreetName) && !empty($PrimaryStreetName) ? implode(" ", $PrimaryStreetName) : '';

	        	$PropertyState      = $this->input->post('property-state');
	        	$PropertyCity      = $this->input->post('property-city');
	        	$PropertyFips      = $this->input->post('property-fips');
	        	$PropertyZip      = $this->input->post('property-zip');
	        	$PropertyType      = $this->input->post('property-type');
	        	$FullProperty      = $this->input->post('FullProperty');

	        	$apn      = $this->input->post('apn');
	        	$County      = $this->input->post('County');
	        	$LegalDescription      = $this->input->post('LegalDescription');
	        	$PrimaryOwner      = $this->input->post('PrimaryOwner');

	        	$SplitName = explode(' ', $PrimaryOwner);
				$OwnerLastName = end($SplitName);
				$PrimaryName = array_slice($SplitName, 0, -1);
				$OwnerFirstName = implode(" ", $PrimaryName);

	        	$SecondaryOwner      = $this->input->post('SecondaryOwner');
	        	$SalesRep      = $this->input->post('SalesRep');

	        	/* Fetch details of Sales Rep */
	        	$condition = array(
	                'id' => $SalesRep	                
	            );

				$salesRepDetails = $this->home_model->getSalesRepDetails($condition);
				
				if ($salesRepDetails["is_mail_notification"] == 1) {
					$parties_email[] = isset($salesRepDetails["email_address"]) && !empty($salesRepDetails["email_address"]) ? $salesRepDetails["email_address"] : '';
				}
	        	$salesRepName = isset($salesRepDetails["name"]) && !empty($salesRepDetails["name"]) ? $salesRepDetails["name"] : '';
	        	/* Fetch details of Sales Rep */

	        	$TitleOfficer      = $this->input->post('TitleOfficer');

	        	/*Fetch details of Title Officer */
	        	$condition = array(
	                'id' => $TitleOfficer
	            );
				
				$titleOfficerDetails = $this->titleOfficer->getTitleOfficerDetails($condition);
				$titleOfficerName = isset($titleOfficerDetails['name']) && !empty($titleOfficerDetails['name']) ? $titleOfficerDetails['name'] : '';				
				/*Fetch details of Title Officer */
				
	        	$LoanAmount      = $this->input->post('loanAmount');
	        	$LoanNumber      = $this->input->post('loanNumber');
	        	$EscrowNumber      = $this->input->post('escrowNumber');
	        	$Notes      = $this->input->post('notes');
	        	$SalesAmount      = $this->input->post('salesAmount');
	        	$ProductTypeTxt      = $this->input->post('ProductType');
	        	$primaryBorrower      = $this->input->post('primaryBorrower');
	        	$secondaryBorrower      = $this->input->post('secondaryBorrower');
	        	$TransactionTypeID = isset($_POST["TransactionTypeID"]) && !empty($_POST["TransactionTypeID"]) ? $_POST["TransactionTypeID"] : 3;
	        	$ProductTypeID      = $this->input->post('ProductTypeID');
	        	$CCR = isset($_POST["CCR"]) && !empty($_POST["CCR"]) ? 1 : 0;
				$Docs = isset($_POST["Docs"]) && !empty($_POST["Docs"]) ? 1 : 0;
				$Ease = isset($_POST["Ease"]) && !empty($_POST["Ease"]) ? 1 : 0;

	        	$sendermessage      = $this->input->post('sendermessage');
				$BuyerAgentId      = $this->input->post('BuyerAgentId');
				$agentDetailFlag =  $this->input->post('add-agent-details');
				$user_data = array();

	        	$buyers_agent_details = $listing_agent_details = array();
	        	if((isset($BuyerAgentId) && !empty($BuyerAgentId)) || isset($agentDetailFlag))
	        	{
	        		$BuyerAgentName      = $this->input->post('BuyerAgentName');
	        		$BuyerAgentEmailAddress      = $this->input->post('BuyerAgentEmailAddress');
	        		$BuyerAgentTelephone      = $this->input->post('BuyerAgentTelephone');
	        		$BuyerAgentCompany      = $this->input->post('BuyerAgentCompany');

	        		
	        		$parties_email[] = $BuyerAgentEmailAddress;

	        		$buyers_agent_details = array('name'=>$BuyerAgentName, 'email'=>$BuyerAgentEmailAddress, 'telephone'=> $BuyerAgentTelephone,'company'=>$BuyerAgentCompany);
	        	} 
	        	
	        	
	        	$ListingAgentId      = $this->input->post('ListingAgentId');
	        	if((isset($ListingAgentId) && !empty($ListingAgentId)) || isset($agentDetailFlag))
	        	{
	        		$ListingAgentName      = $this->input->post('ListingAgentName');
	        		$ListingAgentEmailAddress = isset($_POST["ListingAgentEmailAddress"]) && !empty($_POST["ListingAgentEmailAddress"]) ? strip_tags(trim($_POST["ListingAgentEmailAddress"])) : '';
	        		$ListingAgentTelephone      = $this->input->post('ListingAgentTelephone');
	        		$ListingAgentCompany      = $this->input->post('ListingAgentCompany');
	        
					$parties_email[] = $ListingAgentEmailAddress;

					$listing_agent_details = array('name'=>$ListingAgentName, 'email'=>$ListingAgentEmailAddress, 'telephone'=> $ListingAgentTelephone,'company'=>$ListingAgentCompany);
	        	}
	        	
				$EscrowLenderId = $escrowLenderPartnerTypeID ='';
				$lender_details = $escrow_details = array();

				if(isset($userdata['is_master']) && !empty($userdata['is_master']))
				{
					$orderUser =  $this->home_model->get_user(array('id' => $_POST['id']));
					$is_escrow = $orderUser['is_escrow'];
					$user_data['email'] = $orderUser['email_address'];
					$user_data['password'] = $orderUser['random_password'];
					$con = array(
						'where' => array(
							'partner_id' => $orderUser['partner_id'],
						)
					);
					$companyData = $this->home_model->get_company_rows($con);
				} else {
					$orderUser =  $this->home_model->get_user(array('id' => $userdata['id']));
					$con = array(
						'where' => array(
							'partner_id' => $orderUser['partner_id'],
						)
					);
					$companyData = $this->home_model->get_company_rows($con);
				}


				$cplLenderId = 0;
				if(isset($_POST['EscrowId']) && !empty($_POST['EscrowId']))
				{
					$EscrowLenderId = $_POST['EscrowId'];
					$EscrowLenderName = isset($_POST['EscrowName']) && !empty($_POST['EscrowName']) ? $_POST['EscrowName'] : '';
					$EscrowLenderEmail = isset($_POST['EscrowEmailAddress']) && !empty($_POST['EscrowEmailAddress']) ? $_POST['EscrowEmailAddress'] : '';
					$EscrowLenderTelephone      = $this->input->post('EscrowTelephone');
	        		$EscrowLenderCompany      = $this->input->post('EscrowCompany');

					$escrow_details = array('name'=>$EscrowLenderName, 'email'=>$EscrowLenderEmail, 'telephone'=> $ListingAgentTelephone,'company'=>$ListingAgentCompany);
					$escrowLenderPartnerTypeID = '10006';
					$cplLenderId = $orderUser['id'];
				}
				elseif (isset($_POST['LenderId']) && !empty($_POST['LenderId'])) 
				{
					$EscrowLenderId = $_POST['LenderId'];
					$EscrowLenderName = isset($_POST['LenderName']) && !empty($_POST['LenderName']) ? $_POST['LenderName'] : '';
					$EscrowLenderEmail = isset($_POST['LenderEmailAddress']) && !empty($_POST['LenderEmailAddress']) ? $_POST['LenderEmailAddress'] : '';
					$EscrowLenderTelephone      = $this->input->post('LenderTelephone');
	        		$EscrowLenderCompany      = $this->input->post('LenderCompany');

					$lender_details = array('name'=>$EscrowLenderName, 'email'=>$EscrowLenderEmail, 'telephone'=> $EscrowLenderTelephone,'company'=>$EscrowLenderCompany);
					$escrowLenderPartnerTypeID = '3';
				}

				/* Partners API */
				$secondaryPartners = array();
				if(isset($EscrowLenderId) && !empty($EscrowLenderId))
				{
					$escrow_lender_user_details = $this->home_model->get_user(array('id' => $EscrowLenderId));

					$escrow_lender_resware_user_id = isset($escrow_lender_user_details['resware_user_id']) && !empty($escrow_lender_user_details['resware_user_id']) ? $escrow_lender_user_details['resware_user_id'] : '';

					$escrow_lender_partner_id = isset($escrow_lender_user_details['partner_id']) && !empty($escrow_lender_user_details['partner_id']) ? $escrow_lender_user_details['partner_id'] : '';

					$secondaryEmp[] = array('UserID'=> $escrow_lender_resware_user_id);

					$secondaryPartners = array(
							'SecondaryEmployees'=> $secondaryEmp,
							'PartnerTypeID' => $escrowLenderPartnerTypeID,
							'PartnerID' => $escrow_lender_partner_id,
							'PartnerType' => array(
								'PartnerTypeID' => $escrowLenderPartnerTypeID
							)
					);
				}
				/* Partners API */

				if(isset($EscrowLenderEmail) && !empty($EscrowLenderEmail))
				{
					$parties_email[] = $EscrowLenderEmail;
				}
				$AdditionalEmail = $this->input->post('AdditionalEmail');
				$AdditionalEmail1 = $this->input->post('AdditionalEmail1');
				$AdditionalEmail2 = $this->input->post('AdditionalEmail2');

				if(isset($AdditionalEmail) && !empty($AdditionalEmail))
				{
					$parties_email[] = $AdditionalEmail;
				}

				if(isset($AdditionalEmail1) && !empty($AdditionalEmail1))
				{
					$parties_email[] = $AdditionalEmail1;
				}

				if(isset($AdditionalEmail2) && !empty($AdditionalEmail2))
				{
					$parties_email[] = $AdditionalEmail2;
				}
							
				/* Start place order at resware */
				$place_order = array();

				$legalEntity = array('EntityType'=>'INDIVIDUAL', 'IsPrimaryTransactee' => 'true', 'primary'=> array('First'=>$OwnerFirstName,'Last'=>$OwnerLastName),'Address'=>array('Address1'=>$PropertyAddress, 'City'=> $PropertyCity, 'State'=> $PropertyState, 'Zip'=>$PropertyZip));

				if(strpos($ProductTypeTxt, 'Loan') !== false)
				{
					$place_order['Buyers'][] = $legalEntity;
				}
				elseif(strpos($ProductTypeTxt, 'Sale') !== false)
				{
					$borrowerName = explode(' ', $primaryBorrower);
					$borrowerLastName = end($borrowerName);
					$borrowerPrimaryName = array_slice($borrowerName, 0, -1);
					$borrowerFirstName = implode(" ", $borrowerPrimaryName);
					
					$borrowers = array('EntityType'=>'INDIVIDUAL', 'IsPrimaryTransactee' => 'true', 'primary'=> array('First'=>$borrowerFirstName,'Last'=>$borrowerLastName));

					$place_order['Sellers'][] = $legalEntity;
					$place_order['Buyers'][] = $borrowers;
					$place_order['SalesPrice'] = $SalesAmount;
				}
				
				$place_order['TransactionProductType'] = array("TransactionTypeID" => $TransactionTypeID, 'ProductTypeID'=>$ProductTypeID);
				$loan = array();
				if(isset($LoanAmount) && !empty($LoanAmount))
				{
					$loan['LoanAmount'] = $LoanAmount;
				}
				if(isset($LoanNumber) && !empty($LoanNumber))
				{
					$loan['LoanNumber'] = $LoanNumber;
				}
				$place_order['Loans'][] = $loan;
				$place_order['Properties'][] = array('IsPrimary'=>'true', 'StreetNumber'=>$StreetNumber, 'StreetName'=> $StreetName, 'City'=> $PropertyCity, 'State'=> $PropertyState, 'County'=> $County, 'Zip'=>$PropertyZip);

				$place_order['Note']['APN'] = $apn;
				$place_order['Note']['parcel_id'] = $apn;
				$place_order['Note']['legal_description'] = $LegalDescription;

				if (!empty($TitleOfficer)) {
					$place_order['Note']['title_Officer'] = $titleOfficerName;
				}
				if (!empty($SalesRep)) {
					$place_order['Note']['sales_rep'] = $salesRepName;
				}
				if (!empty($buyers_agent_details)) {
					$place_order['Note']['buyers_agent'] = $buyers_agent_details;
				}
				if (!empty($listing_agent_details)) {
					$place_order['Note']['listing_agent'] = $listing_agent_details;
				}
				if (!empty($lender_details)) {
					$place_order['Note']['lender_details'] = $lender_details;
				}
				if (!empty($escrow_details)) {
					$place_order['Note']['escrow_details'] = $escrow_details;
				}
				if (!empty($EscrowNumber)) {
					$place_order['Note']['EscrowNumber'] = $EscrowNumber;
				}
				if (!empty($Notes)) {
					$place_order['Note']['Notes'] = $Notes;
				}				
				
				$order_data = json_encode($place_order);
				
				
				
				
				$this->load->library('order/resware');
				$logid = $this->apiLogs->syncLogs($userdata['id'], 'resware', 'create_order', env('RESWARE_ORDER_API').'orders', $order_data, array(), 0, 0);
				$result = $this->resware->make_request('POST', 'orders', $order_data,$user_data);
				
				$this->apiLogs->syncLogs($userdata['id'], 'resware', 'create_order', env('RESWARE_ORDER_API').'orders', $order_data, $result, 0, $logid);

				if(isset($result) && !empty($result))
				{
					$response = json_decode($result,true);
					if(isset($response['ResponseStatus']) && !empty($response['ResponseStatus']))
					{
						$message = isset($response['ResponseStatus']['Message']) && !empty($response['ResponseStatus']['Message']) ? $response['ResponseStatus']['Message'] : '';
						$response = array('status'=>'error', 'message'=> $message);
						echo json_encode($response); exit;
					}
					else
					{
						$orderNumber = $file_id = '';

						if(isset($response['FileID']) && !empty($response['FileID']))
						{
							$orderNumber = isset($response['FileNumber']) && !empty($response['FileNumber']) ? $response['FileNumber'] : '';
							$file_id = isset($response['FileID']) && !empty($response['FileID']) ? $response['FileID'] : '';
						}

						if($orderNumber)
						{
							$partners = array();
							
							if(isset($secondaryPartners) && !empty($secondaryPartners))
							{
								$partners[] = $secondaryPartners;
							}

							if (!empty($salesRepDetails)) {
								if (!empty($salesRepDetails['partner_id']) && !empty($salesRepDetails['partner_type_id'])) {
									$partners[] = array(
										'PartnerTypeID' => $salesRepDetails['partner_type_id'],
										'PartnerID' => $salesRepDetails['partner_id'],
										'PartnerType' => array(
											'PartnerTypeID' => $salesRepDetails['partner_type_id']
										)
									);
								}
							}

							if (!empty($titleOfficerDetails)) {
								if (!empty($titleOfficerDetails['partner_id']) && !empty($titleOfficerDetails['partner_type_id'])) {
									$partners[] = array(
										'PartnerTypeID' => $titleOfficerDetails['partner_type_id'],
										'PartnerID' => $titleOfficerDetails['partner_id'],
										'PartnerType' => array(
											'PartnerTypeID' => $titleOfficerDetails['partner_type_id']
										)
									);
								}
							}

							// if (!empty($companyData)) {
							// 	if ($companyData[0]['underwriter'] == 'north_american') {
							// 		$partners[] = array(
							// 			'PartnerTypeID' => 7,
							// 			'PartnerID' => 39919,
							// 			'PartnerType' => array(
							// 				'PartnerTypeID' => 7
							// 			)
							// 		);
							// 	} else if ($companyData[0]['underwriter'] == 'commonwealth') {
							// 		$partners[] = array(
							// 			'PartnerTypeID' => 7,
							// 			'PartnerID' => 6,
							// 			'PartnerType' => array(
							// 				'PartnerTypeID' => 7
							// 			)
							// 		);
							// 	} else {
							// 		$partners[] = array(
							// 			'PartnerTypeID' => 7,
							// 			'PartnerID' => 201324,
							// 			'PartnerType' => array(
							// 				'PartnerTypeID' => 7
							// 			)
							// 		);
							// 	}
							// }

							$partnerData = json_encode(array('Partners' => $partners));
							$endPoint = 'files/'.$file_id.'/partners';
							$partnerUserData = array(
								'admin_api' => 1
							);
							$logid = $this->apiLogs->syncLogs($userdata['id'], 'resware', 'add_partner', env('RESWARE_ORDER_API').$endPoint, $partnerData, array(), 0, 0);
							$resultPartner = $this->resware->make_request('POST', $endPoint, $partnerData, $partnerUserData);
							$this->apiLogs->syncLogs($userdata['id'], 'resware', 'add_partner', env('RESWARE_ORDER_API').$endPoint, $partnerData, $resultPartner, 0, $logid);

							$remoteFileNumberData = json_encode(array('RemoteFileNumber' => $orderNumber));
							$remoteFileEndPoint = 'files/'.$file_id.'/partners/'.$orderUser['partner_id'];
							
							$logid = $this->apiLogs->syncLogs($userdata['id'], 'resware', 'remote_file_number', env('RESWARE_ORDER_API').$remoteFileEndPoint, $remoteFileNumberData, array(), 0, 0);
							$resultRemotePartner = $this->resware->make_request('PUT', $remoteFileEndPoint, $remoteFileNumberData, $partnerUserData);
							$this->apiLogs->syncLogs($userdata['id'], 'resware', 'remote_file_number', env('RESWARE_ORDER_API').$remoteFileEndPoint, $remoteFileNumberData, $resultRemotePartner, 0, $logid);

							/* Add partner api logs */
							$partnerApiData = array(
								'request_url' => env('RESWARE_ORDER_API').$endPoint,
								'request_data' => $partnerData,
								'response_data' => $resultPartner
							);

							$partnerApiId = $this->partnerApiLogs->insert($partnerApiData);
							/* Add partner api logs */

							$customer_id = isset($_POST['id']) && !empty($_POST['id']) ? $_POST['id'] : '';

							/* Buyers Agent */				
							if(isset($BuyerAgentId) && !empty($BuyerAgentId))
				        	{
				        		$buyerData = array(
									'name' => $BuyerAgentName,
									'email_address' => $BuyerAgentEmailAddress,
									'company' => $BuyerAgentCompany,
									'telephone_no' => $BuyerAgentTelephone,
									'status'=> 1
								);
								$condition = array(
									'id' => $BuyerAgentId
								);
								
								$this->agent_model->update($buyerData,$condition);
				        	} else if (isset($agentDetailFlag)) {
								$buyerData = array(
									'name' => $BuyerAgentName,
									'email_address' => $BuyerAgentEmailAddress,
									'company' => $BuyerAgentCompany,
									'telephone_no' => $BuyerAgentTelephone,
									'status'=> 1
								);
								$BuyerAgentId = $this->agent_model->insert($buyerData);
							}
							/* Buyers Agent */

							/* Listing Agent */				
							if(isset($ListingAgentId) && !empty($ListingAgentId))
				        	{
				        		$listngAgentData = array(
									'name' => $ListingAgentName,
									'email_address' => $ListingAgentEmailAddress,
									'company' => $ListingAgentCompany,
									'telephone_no' => $ListingAgentTelephone,
									'status'=> 1
								);
								$condition = array(
									'id' => $ListingAgentId
								);
								$this->agent_model->update($listngAgentData,$condition);
				        	} else if (isset($agentDetailFlag)) {
				        		$listngAgentData = array(
									'name' => $ListingAgentName,
									'email_address' => $ListingAgentEmailAddress,
									'company' => $ListingAgentCompany,
									'telephone_no' => $ListingAgentTelephone,
									'status'=> 1
								);
								$ListingAgentId = $this->agent_model->insert($listngAgentData);
							}
							/* Listing Agent */

							$propertyData = array(
								'customer_id' => $customer_id,
								'buyer_agent_id' => $BuyerAgentId,
								'listing_agent_id' => $ListingAgentId,
								'escrow_lender_id' => $EscrowLenderId,
								'cpl_lender_id' => $cplLenderId,
								'address' => $PropertyAddress,
								'city' => $PropertyCity,
								'state' => $PropertyState,
								'zip' => $PropertyZip,
								'property_type' => $PropertyType,
								'full_address' => $FullProperty,
								'apn' => $apn,
								'county' => $County,
								'legal_description' => $LegalDescription,
								'primary_owner' => $PrimaryOwner,
								'secondary_owner' => $SecondaryOwner,
								// 'additional_details'=> $sendermessage,
								'status'=> 1
							);

							$propertyId = $this->home_model->insert($propertyData,'property_details');				

							$transactionData = array(
								'customer_id' => $customer_id,
								'sales_representative' => $SalesRep,
								'title_officer' => $TitleOfficer,
								'sales_amount' => $SalesAmount,
								'loan_amount' => $LoanAmount,
								'loan_number' => $LoanNumber,
								'transaction_type' => $TransactionTypeID,
								'purchase_type' => $ProductTypeID,
								'is_ccr' => $CCR,
								'is_underlying_docs' => $Docs,
								'is_plotted_easements' => $Ease,
								'additional_email' => $AdditionalEmail,
								'additional_email_1' => $AdditionalEmail1,
								'additional_email_2' => $AdditionalEmail2,
								'borrower' => $primaryBorrower,
								'secondary_borrower' => $secondaryBorrower,
								'status'=> 1
							);

							$transactionId = $this->home_model->insert($transactionData,'transaction_details');

							$randomString = $this->order->randomPassword();
							
							$randomString = md5($orderUser['id'] . $orderUser['email_address'] .$randomString);
			

							$orderData = array(
								'customer_id' => $customer_id,
								'file_id' => $file_id,
								'file_number' => $orderNumber,
								'property_id' => $propertyId,
								'transaction_id' => $transactionId,
								'partner_api_log_id' => $partnerApiId,
								'created_by' => $userdata['id'],
								'random_number' => $randomString,
								'status'=> 1
							);

							$orderId = $this->home_model->insert($orderData,'order_details');

							/* Escrow Lender Details */					
							if(isset($EscrowLenderId) && !empty($EscrowLenderId))
				        	{
				        		$name = explode(' ', $EscrowLenderName);
				        		$first_name = $name[0];
				        		$last_name = $name[1];
				        		$EscrowLenderData = array(
									'first_name' => $first_name,
									'last_name' => $last_name,
									'email_address' => $EscrowLenderEmail,
									'company_name' => $EscrowLenderCompany,
									'telephone_no' => $EscrowLenderTelephone,
									'status'=> 1
								);
								$condition = array(
									'id' => $EscrowLenderId
								);
								
								$lenderId = $this->home_model->update($EscrowLenderData,$condition);
							}
							/* Escrow Lender Details */

							
							if($this->session->has_userdata('tp_api_id_'.$random_number))
							{
								$session_id = 'tp_api_id_'.$random_number;

								$condition = array(
									'session_id' => $session_id
								);
								$tpData = array(
									'file_id' => $file_id,
									'file_number' => $orderNumber,
								);
								$this->titlePointData->update($tpData,$condition);
								
								$this->load->library('order/titlepoint');

								$titlePointDetails = $this->titlePointData->gettitlePointDetails($condition);
								
								$tax_serviceId = isset($titlePointDetails['cs3_service_id']) && !empty($titlePointDetails['cs3_service_id']) ? $titlePointDetails['cs3_service_id'] : '';
								$this->titlepoint->generateTaxDoc($tax_serviceId,$orderNumber,$orderId);
								
								$serviceId = isset($titlePointDetails['cs4_service_id']) && !empty($titlePointDetails['cs4_service_id']) ? $titlePointDetails['cs4_service_id'] : '';
								$this->titlepoint->generateImg($serviceId,$orderNumber,$orderId);
								
								$instrumentNumber = isset($titlePointDetails['cs4_instrument_no']) && !empty($titlePointDetails['cs4_instrument_no']) ? $titlePointDetails['cs4_instrument_no'] : '';

								$recordedDate = isset($titlePointDetails['cs4_recorded_date']) && !empty($titlePointDetails['cs4_recorded_date']) ? $titlePointDetails['cs4_recorded_date'] : '';
								$fips = isset($titlePointDetails['fips']) && !empty($titlePointDetails['fips']) ? $titlePointDetails['fips'] : '';
								
								$this->titlepoint->generateGrantDeed($instrumentNumber,$recordedDate,$fips,$orderNumber,$orderId);
							}
							
							$orderDetails = $this->order->get_order_details($file_id);

							// Convert to PST
							
    						$timezone  = -8;

							$opened_date = gmdate("m-d-Y h:i A", strtotime($orderDetails['opened_date']) + 3600*($timezone+date("I")));

							// Convert to PST

							$data = array(
								'orderNumber'=> $orderNumber,
								'orderId'=> $file_id,
								'OpenName'=> $OpenName.' '.$OpenLastName,
								'Opentelephone'=> $Opentelephone,
								'OpenEmail'=> $OpenEmail,
								'CompanyName'=> $CompanyName,
								'StreetAddress'=> $StreetAddress,
								'City'=> $City,
								'Zipcode'=> $Zipcode,	
								'openAt'=> $opened_date,
								'PropertyAddress'=> $PropertyAddress,
								'FullProperty'=> $FullProperty,
								'APN'=> $apn,
								'County'=> $County,
								'LegalDescription'=> $LegalDescription,
								'PrimaryOwner'=> $PrimaryOwner,
								'SecondaryOwner'=> $SecondaryOwner,
								'SalesRep'=> $salesRepName,
								'TitleOfficer'=> $titleOfficerName,
								'ProductType'=> $ProductTypeTxt,
								'SalesAmount'=> $SalesAmount,
								'LoanAmount'=> $LoanAmount,
								'LoanNumber'=> $LoanNumber,
								'EscrowNumber'=> $EscrowNumber,
								'Notes'=> $Notes,
								'sendermessage'=> $sendermessage,
								'buyers_agent'=> $buyers_agent_details,
								'listing_agent'=> $listing_agent_details,
								'lender_details'=> $lender_details,
								'escrow_details'=> $escrow_details,
								'currYear'=> CURRENT_YEAR,
								'randomString'=> $randomString
							 );

							$from_name = 'Pacific Coast Title Company';
							$from_mail = env('FROM_EMAIL');
							$order_message_body = $this->load->view('emails/order.php',$data,TRUE);
							$message = $order_message_body; 
							$subject = 'Title Order Placed: PCT';
							$email_notification = $this->input->post('email_notification');

							
							if(($is_escrow == 0) && (isset($userdata['is_master']) && !empty($userdata['is_master'])) && (empty($email_notification)))
							{
								$to = env('OPEN_ORDER_ADMIN_EMAIL');
								/*$cc = array();*/
							}
							else
							{
								$to = $OpenEmail;
								$parties_email[] = env('OPEN_ORDER_ADMIN_EMAIL');
							}

							

							$file = array();
							$lvfilename = $orderNumber.'.pdf';
							$deedfilename = $orderNumber.'.pdf';
							$taxfilename = $orderNumber.'.pdf';
							// $orderDetails = $this->order->get_order_details($file_id);

							if (!empty($_FILES['upload_curative']['name'])) {
								$this->uploadCurativeDocsToResware($orderDetails); 
							}

							if (file_exists(FCPATH.'uploads/legal-vesting/'.$lvfilename)) {
								$file[] = base_url().'uploads/legal-vesting/'.$lvfilename;
								$this->uploadLvDocsToResware($lvfilename, $file_id, $orderDetails);
							}

							if (file_exists(FCPATH.'uploads/grant-deed/'.$deedfilename)) {
								$file[] = base_url().'uploads/grant-deed/'.$deedfilename;
								$this->uploadGrantDeedDocsToResware($deedfilename, $file_id, $orderDetails);
							}

							if (file_exists(FCPATH.'uploads/tax/'.$taxfilename)) {
								$file[] = base_url().'uploads/tax/'.$taxfilename;
								$this->uploadTaxDocsToResware($taxfilename, $file_id, $orderDetails);
							}
							
							/*$cc = array(env('OPEN_ORDER_ADMIN_EMAIL'));*/
							$parties_email[] = env('ORDER_ADMIN_EMAIL');
							$cc = isset($parties_email) && !empty($parties_email) ? $parties_email : array();
							$this->load->helper('sendemail');
							
							$mailParams= array(
								'from_mail'=>$from_mail, 
								'from_name'=>$from_name, 
								'to'=>$to,
								'subject'=>$subject,
								'message'=>json_encode($data),
								'file'=>json_encode($file),
								'cc'=>json_encode($cc)
							);
							$logid = $this->apiLogs->syncLogs($userdata['id'], 'sendgrid', 'send_confirmation_mail', '', $mailParams, array(), $orderId, 0);

							$mail_result = send_email($from_mail,$from_name, $to, $subject, $message,$file,$cc,array());

							$this->apiLogs->syncLogs($userdata['id'], 'sendgrid', 'send_confirmation_mail', '', $mailParams, array('status'=>$mail_result), $orderId, $logid);

							/* Escrow officer email */
						
							if (isset($orderUser) && !empty($orderUser))
							{
								$is_escrow_user = $orderUser['is_escrow'];

								if(isset($is_escrow_user) && !empty($is_escrow_user))
								{
									$escrow_email = $orderUser['email_address'];
								}
								else
								{
									$escrow_email = $escrow_lender_user_details['email_address'];
								}
							}

							/*$from_name = 'Pacific Coast Title Company';
							$from_mail = env('FROM_EMAIL');*/

							if($escrow_email == 'info@flaremedia.io')
							{
								

								$sales_rep_img = isset($salesRepDetails["sales_rep_profile_img"]) && !empty($salesRepDetails["sales_rep_profile_img"]) ? $salesRepDetails["sales_rep_profile_img"] : '';

								$email_data = array(
									'orderNumber'=> $orderNumber,
									'randomString'=> $randomString,
									'headerImg'=> $sales_rep_img,
									'currYear'=> CURRENT_YEAR
								);
								
								$borrower_message_body = $this->load->view('emails/borrower.php',$email_data,TRUE);
								$message_body = $borrower_message_body; 
								$subject = 'Statement Of Information: PCT';
								// $to = $escrow_email;
								$to = 'chirag.patel@crestinfosystems.com';

								$mailParams= array(
									'from_mail'=>$from_mail, 
									'from_name'=>$from_name, 
									'to'=>$to,
									'subject'=>$subject,
									'message'=>json_encode($email_data)
								);

								$logid = $this->apiLogs->syncLogs($userdata['id'], 'sendgrid', 'send_mail_to_escrow_officer', '', $mailParams, array(), $orderId, 0);

								$escrow_mail_result = send_email($from_mail,$from_name, $to, $subject, $message_body);

								$this->apiLogs->syncLogs($userdata['id'], 'sendgrid', 'send_mail_to_escrow_officer', '', $mailParams, array('status'=>$escrow_mail_result), $orderId, $logid);
							}					

							/* Escrow officer email */							
						}
											
						$response = array('status'=>'success', 'message'=> 'Data saved successfully.','file_id'=>$file_id);
						echo json_encode($response); exit;
					} 
				}
				else
				{
					
					$response = array('status'=>'error', 'message'=> 'Credentials error.');
					echo json_encode($response); exit;
				}
    		}
    		else
            {
                $data['OpenName_error_msg'] = form_error('OpenName');
                $data['OpenLastName_error_msg'] = form_error('OpenLastName');
                $data['OpenEmail_error_msg'] = form_error('OpenEmail');
                $data['sendermessage_error_msg'] = form_error('sendermessage');
            }
    	}
    	else
    	{
			$data['title'] = 'Open Order | Pacific Coast Title Company';
			$customer_data =  $this->home_model->get_user(array('id' => $userdata['id']));

			$is_master = isset($customer_data['is_master']) && !empty($customer_data['is_master']) ? $customer_data['is_master'] : '';

			/*$condition = array(
	            'where' => array(
	                'status' => 1,
	                'transaction_type_id' => 3
	            )
	        );
			
			$data['productType'] =  $this->productType->getProductTypes($condition);*/

			$condition = array(
                'where' => array(
                    'status' => 1
                )
            );

			$data['titleOfficer'] = $this->titleOfficer->getTitleOfficerDetails($condition);

			// $data['salesRep'] = $this->salesRep->getSalesRepDetails($condition);
			$condition = array(
                'where' => array(
                    'is_sales_rep' => 1,
                    'status' => 1,
                )
            );
			$data['salesRep'] = $this->home_model->getSalesRepDetails($condition);

	        if($is_master)
	        {
	        	$this->load->view('layout/head',$data);
	        	$this->load->view('order/master_order');
	        }
	        else 
	        {
	        	$data['customer_data'] = $customer_data;
	        	$this->load->view('layout/head',$data);
	        	$this->load->view('order/home');
	        }	       	
    	}
    }


    function getSearchResults()
    {
    	$userdata = $this->session->userdata('user');
    	
    	ini_set('max_execution_time', 300);
    	$request = $_GET['requrl'];
    	$api_key = env('BLACK_KNIGHT_KEY');        
		$request .= '&key=' . $api_key;

		$query_string = parse_url($request,PHP_URL_QUERY);
        parse_str($query_string, $requestParams);
        
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
        $this->load->model('order/apiLogs');

        $logid = $this->apiLogs->syncLogs($userdata['id'], 'black knight', 'address_search', $request, $requestParams, array(), 0, 0);

        $file = file_get_contents($request,false,$context);
        $xmlData = simplexml_load_string($file);
		$response = json_encode($xmlData);
		$result = json_decode($response,TRUE);

		$this->apiLogs->syncLogs($userdata['id'], 'black knight', 'address_search', $request, array(), $result, 0, $logid);

        
        echo trim($file);
    }

    function checkEmail()
    {
    	$email = isset($_POST['CustomerEmail']) && !empty($_POST['CustomerEmail']) ? $_POST['CustomerEmail'] : '';

    	$condition = array(
            'where' => array(
                'email_address' => $email,
            ),
            'returnType' => 'count'
        );
        $count = $this->home_model->get_customers($condition);

        if($count > 0)
        {
        	echo 'true'; 
        }
    	else
	    {
	        echo 'false';
	    }
    }

    function getCustomerNumber()
    {
    	$email = isset($_POST['email_address']) && !empty($_POST['email_address']) ? $_POST['email_address'] : '';

    	$condition = array(
            'where' => array(
                'email_address' => $email,
            )
        );
        $result = $this->home_model->get_customers($condition);

        $data = array();
        if(isset($result) && !empty($result))
        {
        	$customer_number = isset($result[0]['customer_number']) && !empty($result[0]['customer_number']) ? $result[0]['customer_number'] : '';
            $data['customer_number'] = $customer_number;
        }

        echo json_encode($data); exit;
    }

    function getCustomerDetails()
    {
    	$customer_no = isset($_POST['customer_no']) && !empty($_POST['customer_no']) ? $_POST['customer_no'] : '';

    	$condition = array(
            'where' => array(
                'customer_number' => $customer_no,
            )
        );
        $result = $this->home_model->get_customers($condition);

        $data = array(); 
        if(isset($result) && !empty($result))
        {
        	foreach ($result as $key => $value) 
        	{
        		$data['id'] = isset($value['id']) && !empty($value['id']) ? $value['id'] : '';
        		$data['customer_number'] = isset($value['customer_number']) && !empty($value['customer_number']) ? $value['customer_number'] : '';
		        $data['first_name'] = isset($value['first_name']) && !empty($value['first_name']) ? $value['first_name'] : '';
		        $data['last_name'] = isset($value['last_name']) && !empty($value['last_name']) ? $value['last_name'] : '';
		        $data['telephone_no'] = isset($value['telephone_no']) && !empty($value['telephone_no']) ? $value['telephone_no'] : '';
		        $data['email_address'] = isset($value['email_address']) && !empty($value['email_address']) ? $value['email_address'] : '';
		        $data['company_name'] = isset($value['company_name']) && !empty($value['company_name']) ? $value['company_name'] : '';
		        $data['street_address'] = isset($value['street_address']) && !empty($value['street_address']) ? $value['street_address'] : '';
		        $data['city'] = isset($value['city']) && !empty($value['city']) ? $value['city'] : '';
		        $data['zip_code'] = isset($value['zip_code']) && !empty($value['zip_code']) ? $value['zip_code'] : '';
		        $data['is_escrow'] = isset($value['is_escrow']) && !empty($value['is_escrow']) ? $value['is_escrow'] : 0;
        	}
        }

        echo json_encode($data); 
    }

    function getDetailsByName()
    {
    	$searchTerm = isset($_POST['term']) && !empty($_POST['term']) ? $_POST['term'] : '';

		$is_master_search = isset($_POST['is_master_search']) && !empty($_POST['is_master_search']) ? $_POST['is_master_search'] : 0;

    	$condition = array(
            'company_name' => $searchTerm
        );

    	if(isset($_POST['is_escrow']))
    	{
    		$isEscrow = $_POST['is_escrow'];
    		$condition['is_escrow'] = $isEscrow;
    	}
    	

    	if(isset($_POST['is_escrow']))
    	{
    		$isEscrow = $_POST['is_escrow'];
    		$condition['is_escrow'] = $isEscrow;
    	}
    	$condition['where']['is_sales_rep'] = 0;

    	$is_from_order_form = $this->input->post('is_from_order_form');
    	$condition['is_from_order_form'] = isset($is_from_order_form) && !empty($is_from_order_form) ? $is_from_order_form : 0;

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

    function orderSubmit()
    {
    	$fileId = $this->uri->segment(2);
    	
		
		if($fileId)
		{
			$condition = array(
	            'where' => array(
	                'file_id' => $fileId,
	            )
	        );
			$titlePointDetails = $this->titlePointData->gettitlePointDetails($condition);
			
			$session_id = isset($titlePointDetails[0]['session_id']) && !empty($titlePointDetails[0]['session_id']) ? $titlePointDetails[0]['session_id'] : '';

			$this->session->unset_userdata($session_id);

			$orderDetails = $this->order->get_order_details($fileId);

			$file_number = isset($orderDetails['file_number']) && !empty($orderDetails['file_number']) ? $orderDetails['file_number'] :'';

			$property_id = isset($orderDetails['property_id']) && !empty($orderDetails['property_id']) ? $orderDetails['property_id'] :'';
			$customer_id = isset($orderDetails['customer_id']) && !empty($orderDetails['customer_id']) ? $orderDetails['customer_id'] :'';
			$propertyData = $this->home_model->get_property_details($property_id);
			
			$county = isset($propertyData['county']) && !empty($propertyData['county']) ? $propertyData['county'] :'';
			$apn = isset($propertyData['apn']) && !empty($propertyData['apn']) ? $propertyData['apn'] :'';
			$FullProperty = isset($propertyData['full_address']) && !empty($propertyData['full_address']) ? $propertyData['full_address'] :'';
			
	        $propertyState = isset($propertyData['state']) && !empty($propertyData['state']) ? $propertyData['state'] :'';
	        
	        $propertyCity = isset($propertyData['city']) && !empty($propertyData['city']) ? $propertyData['city'] :'';

	        $lv_file_path = FCPATH.'uploads/legal-vesting/'.$file_number.'.pdf';

	        $lv_file_url = '';

			if (file_exists($lv_file_path)) 
			{
			    $lv_file_url = base_url().'uploads/legal-vesting/'.$file_number.'.pdf';
			}
			$data['lv_file_url'] = $lv_file_url;

			$deed_file_path = FCPATH.'uploads/grant-deed/'.$file_number.'.pdf';

	        $deed_file_url = '';

			if (file_exists($deed_file_path)) 
			{
			    $deed_file_url = base_url().'uploads/grant-deed/'.$file_number.'.pdf';
			}
			$data['deed_file_url'] = $deed_file_url;

			$tax_file_url = '';
			$tax_file_path = FCPATH.'uploads/tax/'.$file_number.'.pdf';
			if (file_exists($tax_file_path)) 
			{
			    $tax_file_url = base_url().'uploads/tax/'.$file_number.'.pdf';
			}
			$data['tax_file_url'] = $tax_file_url;		
		}
		
		$data['tp_data'] = isset($titlePointDetails[0]) && !empty($titlePointDetails[0]) ? $titlePointDetails[0] : array();
		$data['state'] = isset($propertyState) && !empty($propertyState) ? $propertyState : '';
		$data['city'] = isset($propertyCity) && !empty($propertyCity) ? $propertyCity : '';
		$data['county'] = isset($county) && !empty($county) ? $county : '';
		$data['apn'] = isset($apn) && !empty($apn) ? $apn : '';
		$data['property'] = isset($FullProperty) && !empty($FullProperty) ? $FullProperty : '';
		$data['customer_id'] = isset($customer_id) && !empty($customer_id) ? $customer_id : '';
		
        $this->load->view('layout/head',$data);
       	$this->load->view('order/order-submission',$data);

	}
	
	function logout()
	{
		$this->session->sess_destroy();
		$this->session->unset_userdata('user');
		redirect(base_url().'order');
	}

	function notifyAdmin()
	{
		if($this->input->post())
		{
			$customer_id = $this->input->post('customer_id');
			$subject = $this->input->post('subject');

			if(isset($customer_id) && !empty($customer_id))
			{
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

		        $property = $this->input->post('property');

				$message = '<h3>User Details:</h3><p>Name: '.$first_name.' '.$last_name.'</p><p>Telephone: '.$telephone_no.'</p><p>Email Address: '.$email_address.'</p><p>Company Name: '.$company_name.'</p><p>Street Address: '.$street_address.'</p><p>City: '.$city.'</p><p>Zipcode: '.$zipcode.'</p><p>Property Address: '.$property.'</p>';
				
				$from_name = 'Pacific Coast Title Company';
				$from_mail = env('FROM_EMAIL');
				$subject = 'Notification for '.$subject;
				$to = env('ADMIN_EMAIL');
				
				$this->load->helper('sendemail');
				
				$mail_result = send_email($from_mail,$from_name, $to, $subject, $message);

				if($mail_result)
				{
					echo 'success'; exit;
				}
				else
				{
					echo 'error'; exit;
				}
			}
		}
	}

	function selectFiles()
    {
		$data['title'] = 'Smart Dashboard | Pacific Coast Title Company';
		$this->load->view('layout/head_dashboard',$data);
		$this->load->view('order/dashboard');
    }

    function getProductTypes()
    {
    	$this->load->model('order/apiLogs');
    	$userdata = $this->session->userdata('user');
    	
    	$email = isset($_POST['email']) && !empty($_POST['email']) ? $_POST['email'] : '';
    	$customerId = isset($_POST['customerId']) && !empty($_POST['customerId']) ? $_POST['customerId'] : '';
    	
    	$condition = array(
            'id' => $customerId
        );
        $customerDetails = $this->home_model->get_customers($condition);
        
        $email_address = isset($customerDetails['email_address']) && !empty($customerDetails['email_address']) ? $customerDetails['email_address'] : '';
        $password = isset($customerDetails['random_password']) && !empty($customerDetails['random_password']) ? $customerDetails['random_password'] : '';
        $data = array('email'=>$email_address,'password'=>$password);

        $resware_user_id = isset($customerDetails['resware_user_id']) && !empty($customerDetails['resware_user_id']) ? $customerDetails['resware_user_id'] : '';
        $endPoint = 'types/products?ClientsClientID='.$resware_user_id;
    	$logid = $this->apiLogs->syncLogs($customerDetails['id'], 'resware', 'get_product_types', env('RESWARE_ORDER_API').$endPoint, $requestParams, array(), 0, 0);
        $this->load->library('order/resware');
        $result = $this->resware->make_request('GET', $endPoint, array(),$data);
       $this->apiLogs->syncLogs($customerDetails['id'], 'resware', 'get_product_types', env('RESWARE_ORDER_API').$endPoint, array(), $result, 0, $logid);
        $response = json_decode($result,TRUE);
        $product_types = array();

        if(isset($response) && !empty($response))
        {	          
            foreach ($response as $key => $value) 
            {
            	if(isset($value['TransactionTypeID']) && $value['TransactionTypeID'] == 3)
                {
                	$con = array(
                        'where' => array(
                            'product_type_id' => $value['ProductTypeID'],
                            'status' => 1
                        ),
                        'returnType' => 'count'
                    );
                    $prevCount = $this->home_model->get_product_types($con);
                    if(empty($prevCount))
                    {
                    	$productData = array(
                                    'transaction_type'=> trim($value['TransactionType']),
                                    'transaction_type_id'=> $value['TransactionTypeID'],
                                    'product_type'=> trim($value['ProductType']),
                                    'product_type_id'=> $value['ProductTypeID'],
                                    'state'=> 'CA',
                                    'status'=> 1,
                                );
                    	$insert = $this->home_model->insert($productData,'pct_order_product_types');
                    }

                    $product_types[$value['ProductTypeID']] = $value['ProductType']; 
                }
            }
        }
    	echo json_encode($product_types); exit;
	}
	
	public function uploadLvDocsToResware($document_name, $fileId, $orderDetails)
	{
		$this->load->model('order/document');
		$this->load->library('order/resware');
		$this->load->model('order/apiLogs');
		$userdata = $this->session->userdata('user');
		$fileSize = filesize(FCPATH.'uploads/legal-vesting/'.$document_name);
		$contents = file_get_contents(base_url().'uploads/legal-vesting/'.$document_name);
		$binaryData   = base64_encode($contents); 

		$documentData = array(
			'document_name' => $document_name,
			'original_document_name' => $document_name,
			'document_type_id' => 1037,
			'document_size' => $fileSize,
			'user_id' => $userdata['id'],
			'order_id' => $orderDetails['order_id'],
			'description' => 'Legal & Vesting Document',
			'is_sync' => 1,
			'is_prelim_document' => 0,
			'is_lv_doc' => 1
		);
		$documentId = $this->document->insert($documentData);
		$endPoint = 'files/'.$orderDetails['file_id'].'/documents';
		$documentApiData = array(			
			'DocumentName' => $document_name,
			'DocumentType' => array(
				'DocumentTypeID' => 1037,
			),
			'Description' => 'Legal & Vesting Document',
			'InternalOnly' => false,
			'DocumentBody' => $binaryData
		);
		$document_api_data = json_encode($documentApiData, JSON_UNESCAPED_SLASHES);

		if ($userdata['is_master'] == 1) {
			$orderUser =  $this->home_model->get_user(array('id' => $orderDetails['customer_id']));
			$user_data['email'] = $orderUser['email_address'];
			$user_data['password'] = $orderUser['random_password'];
		} else {
			$user_data = array();
		}
		
		$logid = $this->apiLogs->syncLogs($userdata['id'], 'resware', 'create_document', env('RESWARE_ORDER_API').$endPoint, $documentApiData, array(), $orderDetails['order_id'], 0);
		$result = $this->resware->make_request('POST', $endPoint, $document_api_data, $user_data);
		$this->apiLogs->syncLogs($userdata['id'], 'resware', 'create_document', env('RESWARE_ORDER_API').$endPoint, $documentApiData, $result, $orderDetails['order_id'], $logid);
		$res = json_decode($result);
		$this->document->update(array('api_document_id' => $res->Document->DocumentID), array('id' => $documentId));
    }
    

    public function uploadGrantDeedDocsToResware($document_name, $fileId, $orderDetails)
	{
		$this->load->model('order/document');
		$this->load->library('order/resware');
		$this->load->model('order/apiLogs');
		$userdata = $this->session->userdata('user');
		$fileSize = filesize(FCPATH.'uploads/grant-deed/'.$document_name);
		$contents = file_get_contents(base_url().'uploads/grant-deed/'.$document_name);
		$binaryData   = base64_encode($contents); 

		$documentData = array(
			'document_name' => $document_name,
			'original_document_name' => $document_name,
			'document_type_id' => 1037,
			'document_size' => $fileSize,
			'user_id' => $userdata['id'],
			'order_id' => $orderDetails['order_id'],
			'description' => 'Grant Deed Document',
			'is_sync' => 1,
			'is_prelim_document' => 0,
			'is_grant_doc' => 1
		);
		$documentId = $this->document->insert($documentData);
		$endPoint = 'files/'.$orderDetails['file_id'].'/documents';
		$documentApiData = array(			
			'DocumentName' => $document_name,
			'DocumentType' => array(
				'DocumentTypeID' => 1037,
			),
			'Description' => 'Grant Deed Document',
			'InternalOnly' => false,
			'DocumentBody' => $binaryData
		);
		$document_api_data = json_encode($documentApiData, JSON_UNESCAPED_SLASHES);

		if ($userdata['is_master'] == 1) {
			$orderUser =  $this->home_model->get_user(array('id' => $orderDetails['customer_id']));
			$user_data['email'] = $orderUser['email_address'];
			$user_data['password'] = $orderUser['random_password'];
		} else {
			$user_data = array();
		}
		
		$logid = $this->apiLogs->syncLogs($userdata['id'], 'resware', 'create_document', env('RESWARE_ORDER_API').$endPoint, $documentApiData, array(), $orderDetails['order_id'], 0);
		$result = $this->resware->make_request('POST', $endPoint, $document_api_data, $user_data);
		$this->apiLogs->syncLogs($userdata['id'], 'resware', 'create_document', env('RESWARE_ORDER_API').$endPoint, $documentApiData, $result, $orderDetails['order_id'], $logid);
		$res = json_decode($result);
		$this->document->update(array('api_document_id' => $res->Document->DocumentID), array('id' => $documentId));
	}

	public function uploadTaxDocsToResware($document_name, $fileId, $orderDetails)
	{
		$this->load->model('order/document');
		$this->load->library('order/resware');
		$this->load->model('order/apiLogs');
		$userdata = $this->session->userdata('user');
		$fileSize = filesize(FCPATH.'uploads/tax/'.$document_name);
		$contents = file_get_contents(base_url().'uploads/tax/'.$document_name);
		$binaryData   = base64_encode($contents); 

		$documentData = array(
			'document_name' => $document_name,
			'original_document_name' => $document_name,
			'document_type_id' => 1037,
			'document_size' => $fileSize,
			'user_id' => $userdata['id'],
			'order_id' => $orderDetails['order_id'],
			'description' => 'Tax Document',
			'is_sync' => 1,
			'is_prelim_document' => 0,
			'is_tax_doc' => 1
		);
		$documentId = $this->document->insert($documentData);
		$endPoint = 'files/'.$orderDetails['file_id'].'/documents';
		$documentApiData = array(			
			'DocumentName' => $document_name,
			'DocumentType' => array(
				'DocumentTypeID' => 1037,
			),
			'Description' => 'Tax Document',
			'InternalOnly' => false,
			'DocumentBody' => $binaryData
		);
		$document_api_data = json_encode($documentApiData, JSON_UNESCAPED_SLASHES);

		if ($userdata['is_master'] == 1) {
			$orderUser =  $this->home_model->get_user(array('id' => $orderDetails['customer_id']));
			$user_data['email'] = $orderUser['email_address'];
			$user_data['password'] = $orderUser['random_password'];
		} else {
			$user_data = array();
		}
		
		$logid = $this->apiLogs->syncLogs($userdata['id'], 'resware', 'create_document', env('RESWARE_ORDER_API').$endPoint, $documentApiData, array(), $orderDetails['order_id'], 0);
		$result = $this->resware->make_request('POST', $endPoint, $document_api_data, $user_data);
		$this->apiLogs->syncLogs($userdata['id'], 'resware', 'create_document', env('RESWARE_ORDER_API').$endPoint, $documentApiData, $result, $orderDetails['order_id'], $logid);
		$res = json_decode($result);
		$this->document->update(array('api_document_id' => $res->Document->DocumentID), array('id' => $documentId));
	}

	public function checkDuplicateOrder()
    {
		$apn = $this->input->post('apn');
		$result = $this->order->checkDuplicateOrder($apn);
		if ($result) {
			echo json_encode(array('success' => true)); 
		} else {
			echo json_encode(array('success' => false)); 
		} 
	}

	public function uploadCurativeDocsToResware($orderDetails)
	{
		$this->load->model('order/document');
		$this->load->model('order/apiLogs');
		$this->load->library('order/resware');
		$userdata = $this->session->userdata('user');
		$data = $this->upload->data();
		$contents = file_get_contents($data['full_path']);
		$binaryData   = base64_encode($contents); 
		$document_name = date('YmdHis')."_".$data['file_name'];
		rename(FCPATH."/uploads/curative/".$data['file_name'], FCPATH."/uploads/curative/".$document_name);
		
		$documentData = array(
			'document_name' => $document_name,
			'original_document_name' => $data['file_name'],
			'document_type_id' => 1033,
			'document_size' => ($data['file_size'] * 1000),
			'user_id' => $userdata['id'],
			'order_id' => $orderDetails['order_id'],
			'description' => 'Curative Documents',
			'is_sync' => 1,
			'is_curative_doc' => 1
		);
		
		$documentId = $this->document->insert($documentData);
		
		$endPoint = 'files/'.$orderDetails['file_id'].'/documents';
		
		$documentApiData = array(			
			'DocumentName' => $data['file_name'],
			'DocumentType' => array(
				'DocumentTypeID' => 1033,
			),
			'Description' => 'Curative Documents',
			'InternalOnly' => false,
			'DocumentBody' => $binaryData
		);
		$document_api_data = json_encode($documentApiData, JSON_UNESCAPED_SLASHES);

		if ($userdata['is_master'] == 1) {
			$orderUser =  $this->home_model->get_user(array('id' => $orderDetails['customer_id']));
			$user_data['email'] = $orderUser['email_address'];
			$user_data['password'] = $orderUser['random_password'];
		} else {
			$user_data = array();
		}
		
		$logid = $this->apiLogs->syncLogs($userdata['id'], 'resware', 'create_document', env('RESWARE_ORDER_API').$endPoint, $documentApiData, array(), $orderDetails['order_id'], 0);
		$result = $this->resware->make_request('POST', $endPoint, $document_api_data, $user_data);
		$this->apiLogs->syncLogs($userdata['id'], 'resware', 'create_document', env('RESWARE_ORDER_API').$endPoint, $documentApiData, $result, $orderDetails['order_id'], $logid);
		$res = json_decode($result);
		$this->document->update(array('api_document_id' => $res->Document->DocumentID), array('id' => $documentId));
	}	
}