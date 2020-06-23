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

    	if(isset($_POST) && !empty($_POST))
    	{
    		$this->form_validation->set_rules('OpenName', 'First Name', 'required',array('required'=> 'Enter your first name'));
    		$this->form_validation->set_rules('OpenLastName', 'Last Name', 'required',array('required'=> 'Enter your last name'));
    		$this->form_validation->set_rules('OpenEmail', 'Email Address', 'required',array('required'=> 'Enter your email address'));
    		// $this->form_validation->set_rules('sendermessage', 'Sender Message', 'required',array('required'=> 'Oops you forgot your message'));
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
	        	$PropertyAddress      = strtolower($this->input->post('Property'));

	        	$SplitPropertyAddress = explode(' ', strtolower($PropertyAddress));

				$StreetNumber = isset($SplitPropertyAddress[0]) && !empty($SplitPropertyAddress[0]) ? $SplitPropertyAddress[0] : '';

				$PrimaryStreetName = array_slice($SplitPropertyAddress, 1);

				$StreetName = isset($PrimaryStreetName) && !empty($PrimaryStreetName) ? implode(" ", $PrimaryStreetName) : '';

	        	$PropertyState      = $this->input->post('property-state');
	        	$PropertyCity      = strtolower($this->input->post('property-city'));
	        	$PropertyFips      = $this->input->post('property-fips');
	        	$PropertyZip      = $this->input->post('property-zip');
	        	$PropertyType      = strtolower($this->input->post('property-type'));
	        	$FullProperty      = strtolower($this->input->post('FullProperty'));

	        	/*$AddressPropertyParts = explode(',', $FullProperty);	
				$PropertyZip = trim(end($AddressPropertyParts));*/

	        	$apn      = $this->input->post('apn');
	        	$County      = strtolower($this->input->post('County'));
	        	$LegalDescription      = strtolower($this->input->post('LegalDescription'));
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
	        	$salesRepDetails = $this->salesRep->getSalesRepDetails($condition);
	        	$parties_email[] = isset($salesRepDetails["email_address"]) && !empty($salesRepDetails["email_address"]) ? $salesRepDetails["email_address"] : '';
	        	$salesRepName = isset($salesRepDetails["name"]) && !empty($salesRepDetails["name"]) ? $salesRepDetails["name"] : '';
	        	/* Fetch details of Sales Rep */

	        	$TitleOfficer      = $this->input->post('TitleOfficer');

	        	/*Fetch details of Title Officer */
	        	$condition = array(
	                'id' => $TitleOfficer
	            );
				
				$titleOfficerDetails = $this->titleOfficer->getTitleOfficerDetails($condition);
				$titleOfficerName = isset($titleOfficerDetails['name']) && !empty($titleOfficerDetails['name']) ? $titleOfficerDetails['name'] : '';

				// $parties_email[] = isset($titleOfficerDetails['email_address']) && !empty($titleOfficerDetails['email_address']) ? $titleOfficerDetails['email_address'] : '';				
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

	        	$buyers_agent_details = $listing_agent_details = array();
	        	if((isset($BuyerAgentId) && !empty($BuyerAgentId)) || isset($agentDetailFlag))
	        	{
	        		$BuyerAgentName      = $this->input->post('BuyerAgentName');
	        		$BuyerAgentEmailAddress      = $this->input->post('BuyerAgentEmailAddress');
	        		$BuyerAgentTelephone      = $this->input->post('BuyerAgentTelephone');
	        		$BuyerAgentCompany      = $this->input->post('BuyerAgentCompany');

	        		// $parties_email[$BuyerAgentEmailAddress] = isset($_POST["BuyerAgentName"]) && !empty($_POST["BuyerAgentName"]) ? strip_tags(trim($_POST["BuyerAgentName"])) : '';
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
	        		

					/*$parties_email[$ListingAgentEmailAddress] = isset($_POST["ListingAgentEmailAddress"]) && !empty($_POST["ListingAgentEmailAddress"]) ? strip_tags(trim($_POST["ListingAgentEmailAddress"])) : '';*/
					$parties_email[] = $ListingAgentEmailAddress;

					$listing_agent_details = array('name'=>$ListingAgentName, 'email'=>$ListingAgentEmailAddress, 'telephone'=> $ListingAgentTelephone,'company'=>$ListingAgentCompany);
	        	}
	        	

				$EscrowLenderId = '';
				$lender_details = $escrow_details = array();
				if(isset($_POST['EscrowId']) && !empty($_POST['EscrowId']))
				{
					$EscrowLenderId = $_POST['EscrowId'];
					$EscrowLenderName = isset($_POST['EscrowName']) && !empty($_POST['EscrowName']) ? $_POST['EscrowName'] : '';
					$EscrowLenderEmail = isset($_POST['EscrowEmailAddress']) && !empty($_POST['EscrowEmailAddress']) ? $_POST['EscrowEmailAddress'] : '';
					$EscrowLenderTelephone      = $this->input->post('EscrowTelephone');
	        		$EscrowLenderCompany      = $this->input->post('EscrowCompany');

					$escrow_details = array('name'=>$EscrowLenderName, 'email'=>$EscrowLenderEmail, 'telephone'=> $ListingAgentTelephone,'company'=>$ListingAgentCompany);
				}
				elseif (isset($_POST['LenderId']) && !empty($_POST['LenderId'])) 
				{
					$EscrowLenderId = $_POST['LenderId'];
					$EscrowLenderName = isset($_POST['LenderName']) && !empty($_POST['LenderName']) ? $_POST['LenderName'] : '';
					$EscrowLenderEmail = isset($_POST['LenderEmailAddress']) && !empty($_POST['LenderEmailAddress']) ? $_POST['LenderEmailAddress'] : '';
					$EscrowLenderTelephone      = $this->input->post('LenderTelephone');
	        		$EscrowLenderCompany      = $this->input->post('LenderCompany');

					$lender_details = array('name'=>$EscrowLenderName, 'email'=>$EscrowLenderEmail, 'telephone'=> $EscrowLenderTelephone,'company'=>$EscrowLenderCompany);
				}
				if(isset($EscrowLenderEmail) && !empty($EscrowLenderEmail))
				{
					// $parties_email[$EscrowLenderEmail] = $EscrowLenderName;
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

				$legalEntity = array('EntityType'=>'INDIVIDUAL', 'IsPrimaryTransactee' => 'true', 'primary'=> array('First'=>$OwnerFirstName,'Last'=>$OwnerLastName),'Address'=>array('Address1'=>strtolower($PropertyAddress), 'City'=> strtolower($PropertyCity), 'State'=> $PropertyState, 'Zip'=>$PropertyZip));

				if(strpos($ProductTypeTxt, 'Loan') !== false)
				{
					$place_order['Buyers'][] = $legalEntity;
					// $ProductType = 'Residential: Loan: Refinance';
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
					// $ProductType = 'Residential: Sales: Purchase';
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
				$place_order['Properties'][] = array('IsPrimary'=>'true', 'StreetNumber'=>$StreetNumber, 'StreetName'=> $StreetName, 'City'=> strtolower($PropertyCity), 'State'=> $PropertyState, 'County'=> strtolower($County), 'Zip'=>$PropertyZip);

				$place_order['Note']['APN'] = $apn;
				$place_order['Note']['parcel_id'] = $apn;
				$place_order['Note']['legal_description'] = strtolower($LegalDescription);

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
				$user_data = array();
				
				if(isset($userdata['is_master']) && !empty($userdata['is_master']))
				{
					$orderUser =  $this->home_model->get_user(array('id' => $_POST['CustomerId']));
					echo "<pre>"; print_r($_POST); exit;
					$user_data['email'] = $orderUser['email_address'];
					$user_data['password'] = $orderUser['random_password'];
				}
				
				$this->load->library('order/resware');
				$logid = $this->apiLogs->syncLogs($userdata['id'], 'resware', 'create_order', RESWARE_ORDER_API.'orders', $order_data, array(), 0, 0);
				$result = $this->resware->make_request('POST', 'orders', $order_data,$user_data);
				
				$this->apiLogs->syncLogs($userdata['id'], 'resware', 'create_order', RESWARE_ORDER_API.'orders', $order_data, $result, 0, $logid);

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
							if($this->session->has_userdata('tp_api_id'))
							{
								$id = $this->session->userdata('tp_api_id');
								$condition = array(
									'id' => $id
								);
								$tpData = array(
									'file_id' => $file_id,
									'file_number' => $orderNumber,
								);					
								$this->titlePointData->update($tpData,$condition);
								
								$this->load->library('order/titlepoint');

								$titlePointDetails = $this->titlePointData->gettitlePointDetails($condition);
								
								$serviceId = isset($titlePointDetails['cs4_service_id']) && !empty($titlePointDetails['cs4_service_id']) ? $titlePointDetails['cs4_service_id'] : '';
								$result = $this->titlepoint->generateImg($serviceId,$orderNumber);

								$instrumentNumber = isset($titlePointDetails['cs4_instrument_no']) && !empty($titlePointDetails['cs4_instrument_no']) ? $titlePointDetails['cs4_instrument_no'] : '';

								$recordedDate = isset($titlePointDetails['cs4_recorded_date']) && !empty($titlePointDetails['cs4_recorded_date']) ? $titlePointDetails['cs4_recorded_date'] : '';
								$fips = isset($titlePointDetails['fips']) && !empty($titlePointDetails['fips']) ? $titlePointDetails['fips'] : '';

								$deedresult = $this->titlepoint->generateGrantDeed($instrumentNumber,$recordedDate,$fips,$orderNumber);
							}
							
							$data = array(
								'orderNumber'=> $orderNumber,
								'OpenName'=> $OpenName.' '.$OpenLastName,
								'Opentelephone'=> $Opentelephone,
								'OpenEmail'=> $OpenEmail,
								'CompanyName'=> $CompanyName,
								'StreetAddress'=> $StreetAddress,
								'City'=> $City,
								'Zipcode'=> $Zipcode,
								'PropertyAddress'=> strtolower($PropertyAddress),
								'FullProperty'=> strtolower($FullProperty),
								'APN'=> $apn,
								'County'=> strtolower($County),
								'LegalDescription'=> strtolower($LegalDescription),
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
								'currYear'=> CURRENT_YEAR
							 );

							$from_name = 'Pacific Coast Title Company';
							$from_mail = env('FROM_EMAIL');
							$order_message_body = $this->load->view('emails/order.php',$data,TRUE);
							$message = $order_message_body; 
							$subject = 'Order Placed at Resware';
							$to = $OpenEmail;
							
							$cc = array(env('ADMIN_EMAIL'));
							$bcc = isset($parties_email) && !empty($parties_email) ? $parties_email : array();
							$lvfilename = $orderNumber.'.pdf';
							$deedfilename = $orderNumber.'.pdf';
							$file = array(base_url().'uploads/legal-vesting/'.$lvfilename,base_url().'uploads/grant-deed/'.$deedfilename);
							$this->load->helper('sendemail');
							
							$mail_result = send_email($from_mail,$from_name, $to, $subject, $message,$file,$cc,$bcc);
							//send order deatils to all parties						
							/*if(isset($parties_email) && !empty($parties_email))
							{
								foreach($parties_email as $email => $name){
									$mail->AddBCC($email, $name);
								}
							}*/
						}
						
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
							'address' => strtolower($PropertyAddress),
							'city' => strtolower($PropertyCity),
							'state' => $PropertyState,
							'zip' => $PropertyZip,
							'property_type' => $PropertyType,
							'full_address' => strtolower($FullProperty),
							'apn' => $apn,
							'county' => strtolower($County),
							'legal_description' => strtolower($LegalDescription),
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

						$orderData = array(
							'customer_id' => $customer_id,
							'file_id' => $file_id,
							'file_number' => $orderNumber,
							'property_id' => $propertyId,
							'transaction_id' => $transactionId,
							'created_by' => $userdata['id'],
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

						$order_file = uniqid();
						$order_upload = $order_file.isset($_FILES['orderfiles']['name']) && !empty($_FILES['orderfiles']['name']) ? $_FILES['orderfiles']['name'] : '';	
				
						/*	----------------------------------------------------------------------
							: Prepare form field variables for CSV export
							----------------------------------------------------------------------- */
				
						/*if(GENERATE_CSV == true){
							$csvFile = CSV_FILE_NAME;	
							$csvData = array(
								"$sendername",
								"$emailaddress",
								"$telephone",
								"$senderwebsite",
								"$orderservices",
								"$orderbudget",
								"$ordertimeframe"			
							);
						}*/
						$mail_status= $mail_response = '';
						if(isset($_FILES['orderfiles']) && !empty($_FILES['orderfiles']))
						{
							if ($_FILES['orderfiles']['error'] == 0) 
							{
								move_uploaded_file($_FILES['orderfiles']['tmp_name'], FCPATH.'smuploads/' .$order_upload);

								$data = array(
							       'OpenName'=> $OpenName,
							       'OpenEmail'=> $OpenEmail,
							       'Opentelephone'=> $Opentelephone,
							       'OpenRole'=> $OpenRole,
							       'PartnerName'=> $PartnerName,
							       'ParnterEmailaddress'=> $ParnterEmailaddress,
							       'PartnerTelephone'=> $PartnerTelephone,
							       'PartnerRole'=> $PartnerRole,
							       'Property'=> $Property,
							       'SalesRep'=> $SalesRep,
							       'TitleOfficer'=> $titleOfficerName,
							       'LoanAmount'=> $LoanAmount,
							       'sendermessage'=> $sendermessage,
							       'poweredby_url'=> POWEREDBY_URL,
								   'poweredby_name'=> POWEREDBY_NAME,
								   'currYear'=> CURRENT_YEAR
							    );

								$from_name = 'Pacific Coast Title Company';
								$from_mail = env('FROM_EMAIL');
								$message = $this->load->view('emails/smartmessage.php',$data,TRUE);
								$subject = RECEIVER_SUBJECT;
								$to = RECEIVER_EMAIL;
								$file = FCPATH.'smuploads/'.$order_upload;
								$bcc = array('rmcmahon@pct.com', 'openorders@pct.com');

								$recipients = false;
								$bcc = array();
								if($recipients == true)
								{
									$bcc = array('rmcmahon@pct.com', 'openorders@pct.com');	
								}

								$this->load->helper('sendemail');
								
								$mail_result = send_email($from_mail,$from_name, $to, $subject, $message,array($file),'',$bcc);

								if($mail_result) {
									// -----------------------------------------------------------------
									// : Generate the CSV file and post values if its true
									// ----------------------------------------------------------------- 		
									if(GENERATE_CSV == true){	
										if (file_exists($csvFile)) {
											$csvFileData = fopen($csvFile, 'a');
											fputcsv($csvFileData, $csvData );
										} else {
											$csvFileData = fopen($csvFile, 'a'); 
											$headerRowFields = array(
												"Sender Name",
												"Email Address",
												"Telephone",
												"Website",
												"Services",
												"Budget",
												"Time Frame"										
											);
											fputcsv($csvFileData,$headerRowFields);
											fputcsv($csvFileData, $csvData );
										}
										fclose($csvFileData);
									}
									
									// ---------------------------------------------------------------------
									// : Send the auto responder message if its true
									// --------------------------------------------------------------------- 
									if(AUTORESPONDER == true){
										
										$automail = $this->phpmailer_library->load();
										$automail->isSendmail();
										$automail->setFrom(RECEIVER_EMAIL,RECEIVER_NAME);
										$automail->isHTML(true);                                 
										$automail->CharSet = "UTF-8";
										$automail->Encoding = "base64";
										$automail->Timeout = 200;
										$automail->ContentType = "text/html";
										$automail->AddAddress($OpenEmail, $OpenName);
										$automail->Subject = "Thank you for contacting us";
										$data = array(
									       'receiver_email'=> RECEIVER_EMAIL,
									       'sendername'=> $OpenName,
									       'poweredby_url'=> POWEREDBY_URL,
									       'poweredby_name'=> POWEREDBY_NAME,
									       'currYear'=> CURRENT_YEAR
									    );
									    $automessage = $this->load->view('emails/autoresponder.php',$data,TRUE);
										$automail->Body = $automessage;
										$automail->AltBody = "Use an HTML compatible email client";
										$automail->Send();	 
									}	
								  	
								  	$mail_status='success'; 
								  	$mail_response='Your title order is being submitted. Please wait for confirmation.'; 
								  
									// Start delete function 
									// Automatically deletes files from the smuploads folder after successful sending
									// You can remove this function if you want to keep uploads on your server
									$files = glob(FCPATH.'smuploads/*'); 
									foreach($files as $file){ 
									  if(is_file($file))
										unlink($file); 
									}	  
								  
									} 
									else 
									{
										$mail_status='error'; 
								  		$mail_response='Message not sent - server error occured!';	
									}
							}
						}
						
						$response = array('status'=>'success', 'message'=> 'Data saved successfully.','mail_status'=>$mail_status,'mail_response'=>$mail_response,'file_id'=>$file_id);
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

			$data['salesRep'] = $this->salesRep->getSalesRepDetails($condition);
	        
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
    	ini_set('max_execution_time', 300);
    	$request = $_GET['requrl'];        
		$request .= '&key=' . '22C75EF7-5DBF-4B26-B2DB-998BE080F29C';
        
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
        $file = file_get_contents($request,false,$context);
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
    	// $isEscrow = isset($_POST['is_escrow']) && !empty($_POST['is_escrow']) ? $_POST['is_escrow'] : 0;

		$is_master_search = isset($_POST['is_master_search']) && !empty($_POST['is_master_search']) ? $_POST['is_master_search'] : 0;

    	$condition = array(
            'company_name' => $searchTerm,
            // 'is_escrow' => $isEscrow,
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

    function orderSubmit()
    {
    	$fileId = $this->uri->segment(2);
    	$this->session->unset_userdata('tp_api_id');
		
		if($fileId)
		{
			$condition = array(
	            'where' => array(
	                'file_id' => $fileId,
	            )
	        );
			$titlePointDetails = $this->titlePointData->gettitlePointDetails($condition);

			$orderDetails = $this->order->get_order_details($fileId);

			$file_number = isset($orderDetails['file_number']) && !empty($orderDetails['file_number']) ? $orderDetails['file_number'] :'';

			$property_id = isset($orderDetails['property_id']) && !empty($orderDetails['property_id']) ? $orderDetails['property_id'] :'';
			$propertyData = $this->home_model->get_property_details($property_id);
			
			$county = isset($propertyData['county']) && !empty($propertyData['county']) ? $propertyData['county'] :'';
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
		}
		
		$data['tp_data'] = isset($titlePointDetails[0]) && !empty($titlePointDetails[0]) ? $titlePointDetails[0] : array();
		$data['state'] = isset($propertyState) && !empty($propertyState) ? $propertyState : array();
		$data['city'] = isset($propertyCity) && !empty($propertyCity) ? $propertyCity : array();
		$data['county'] = isset($county) && !empty($county) ? $county : array();
		
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
			$first_name = $this->input->post('first_name');
			$last_name = $this->input->post('last_name');
			$telephone_no = $this->input->post('telephone_no');
			$email_address = $this->input->post('email_address');
			$company_name = $this->input->post('company_name');
			$street_address = $this->input->post('street_address');
			$city = $this->input->post('city');
			$zipcode = $this->input->post('zipcode');
			$property = $this->input->post('property');
			$subject = $this->input->post('subject');

			if((isset($customer_id) && !empty($customer_id)) || (isset($first_name) && !empty($first_name)))
			{
				$message = '<h3>User Details:</h3><p>Customer Number: '.$customer_no.'</p><p>Name: '.$first_name.' '.$last_name.'</p><p>Telephone: '.$telephone_no.'</p><p>Email Address: '.$email_address.'</p><p>Company Name: '.$company_name.'</p><p>Street Address: '.$street_address.'</p><p>City: '.$city.'</p><p>Zipcode: '.$zipcode.'</p><p>Property Address: '.$property.'</p>';
				
				$from_name = 'Pacific Coast Title Company';
				$from_mail = env('FROM_EMAIL');
				$subject = 'Notification for'.$subject;
				$to = 'cs@pct.com';
				
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
    	$logid = $this->apiLogs->syncLogs($customerDetails['id'], 'resware', 'get_product_types', RESWARE_ORDER_API.$endPoint, $requestParams, array(), 0, 0);
        $this->load->library('order/resware');
        $result = $this->resware->make_request('GET', $endPoint, array(),$data);
       $this->apiLogs->syncLogs($customerDetails['id'], 'resware', 'get_product_types', RESWARE_ORDER_API.$endPoint, array(), $result, 0, $logid);
        $response = json_decode($result,TRUE);
        $product_types = array();
        if(isset($response) && !empty($response))
        {        
        	          
            foreach ($response as $key => $value) 
            {            	
            	if(isset($value['TransactionTypeID']) && $value['TransactionTypeID'] == 3)
                {
                    $product_types[$value['ProductTypeID']] = $value['ProductType']; 
                }
            }
        }
    	echo json_encode($product_types); exit;
    }
}