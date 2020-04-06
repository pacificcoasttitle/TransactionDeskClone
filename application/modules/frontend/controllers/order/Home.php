<?php

(defined('BASEPATH')) OR exit('No direct script access allowed');

class Home extends MX_Controller {

    function __construct() {
        parent::__construct();
        $this->load->helper(array('file', 'url'));
        $this->load->library('session');
		$this->load->model('order/home_model');
		$this->load->library('form_validation');
		$this->load->library('order/order');
		$this->order->is_user();
    }

    function index() 
    {
		$userdata = $this->session->userdata('user');
		$this->load->model('order/apiLogs');
    	if(isset($_POST) && !empty($_POST))
    	{
    		$this->load->library("phpmailer_library");
        
    		$this->form_validation->set_rules('OpenName', 'First Name', 'required',array('required'=> 'Enter your first name'));
    		$this->form_validation->set_rules('OpenLastName', 'Last Name', 'required',array('required'=> 'Enter your last name'));
    		$this->form_validation->set_rules('OpenEmail', 'Email Address', 'required',array('required'=> 'Enter your email address'));
    		$this->form_validation->set_rules('sendermessage', 'Sender Message', 'required',array('required'=> 'Oops you forgot your message'));

    		if($this->form_validation->run($this) == true)
    		{
    			// $CustomerNumber = $this->input->post('CustomerNumber');
	        	$OpenName      = $this->input->post('OpenName');
	        	$OpenLastName      = $this->input->post('OpenLastName');
	        	$Opentelephone      = $this->input->post('Opentelephone');
	        	$OpenEmail      = $this->input->post('OpenEmail');
	        	$CompanyName      = $this->input->post('CompanyName');
	        	$StreetAddress      = $this->input->post('StreetAddress');
	        	$City      = $this->input->post('City');
	        	$Zipcode      = $this->input->post('Zipcode');
	        	$PropertyAddress      = $this->input->post('Property');

	        	$SplitPropertyAddress = explode(' ', $PropertyAddress);

				$StreetNumber = isset($SplitPropertyAddress[0]) && !empty($SplitPropertyAddress[0]) ? $SplitPropertyAddress[0] : '';

				$PrimaryStreetName = array_slice($SplitPropertyAddress, 1);

				$StreetName = isset($PrimaryStreetName) && !empty($PrimaryStreetName) ? implode(" ", $PrimaryStreetName) : '';

	        	$PropertyState      = $this->input->post('property-state');
	        	$PropertyCity      = $this->input->post('property-city');
	        	$PropertyFips      = $this->input->post('property-fips');
	        	$FullProperty      = $this->input->post('FullProperty');

	        	$AddressPropertyParts = explode(',', $FullProperty);	
				$PropertyZip = trim(end($AddressPropertyParts));

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
	        	$TitleOfficer      = $this->input->post('TitleOfficer');
	        	$LoanAmount      = $this->input->post('loanAmount');
	        	$SalesAmount      = $this->input->post('salesAmount');
	        	$TransactionTypeID = isset($_POST["TransactionTypeID"]) && !empty($_POST["TransactionTypeID"]) ? $_POST["TransactionTypeID"] : 3;
	        	$ProductTypeID      = $this->input->post('ProductTypeID');
	        	$CCR = isset($_POST["CCR"]) && !empty($_POST["CCR"]) ? 1 : 0;
				$Docs = isset($_POST["Docs"]) && !empty($_POST["Docs"]) ? 1 : 0;
				$Ease = isset($_POST["Ease"]) && !empty($_POST["Ease"]) ? 1 : 0;

	        	$sendermessage      = $this->input->post('sendermessage');
	        	$BuyerAgentId      = $this->input->post('BuyerAgentId');

	        	$parties_email = $buyers_agent_details = $listing_agent_details = array();
	        	if(isset($BuyerAgentId) && !empty($BuyerAgentId))
	        	{
	        		$BuyerAgentName      = $this->input->post('BuyerAgentName');
	        		$BuyerAgentEmailAddress      = $this->input->post('BuyerAgentEmailAddress');
	        		$BuyerAgentTelephone      = $this->input->post('BuyerAgentTelephone');
	        		$BuyerAgentCompany      = $this->input->post('BuyerAgentCompany');

	        		$parties_email[$BuyerAgentEmailAddress] = isset($_POST["BuyerAgentName"]) && !empty($_POST["BuyerAgentName"]) ? strip_tags(trim($_POST["BuyerAgentName"])) : '';

	        		$buyers_agent_details = array('name'=>$BuyerAgentName, 'email'=>$BuyerAgentEmailAddress, 'telephone'=> $BuyerAgentTelephone,'company'=>$BuyerAgentCompany);
	        	}
	        	
	        	
	        	$ListingAgentId      = $this->input->post('ListingAgentId');
	        	if(isset($ListingAgentId) && !empty($ListingAgentId))
	        	{
	        		$ListingAgentName      = $this->input->post('ListingAgentName');
	        		$ListingAgentEmailAddress = isset($_POST["ListingAgentEmailAddress"]) && !empty($_POST["ListingAgentEmailAddress"]) ? strip_tags(trim($_POST["ListingAgentEmailAddress"])) : '';
	        		$ListingAgentTelephone      = $this->input->post('ListingAgentTelephone');
	        		$ListingAgentCompany      = $this->input->post('ListingAgentCompany');
	        		

					$parties_email[$ListingAgentEmailAddress] = isset($_POST["ListingAgentEmailAddress"]) && !empty($_POST["ListingAgentEmailAddress"]) ? strip_tags(trim($_POST["ListingAgentEmailAddress"])) : '';

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
					$parties_email[$EscrowLenderEmail] = $EscrowLenderName;
				}

				/* Start place order at resware */
				$place_order = array();

				$legalEntity = array('EntityType'=>'INDIVIDUAL', 'IsPrimaryTransactee' => 'true', 'primary'=> array('First'=>$OwnerFirstName,'Last'=>$OwnerLastName),'Address'=>array('Address1'=>$PropertyAddress, 'City'=> $PropertyCity, 'State'=> $PropertyState, 'Zip'=>$PropertyZip));

				if($ProductTypeID == '19' || $ProductTypeID == '33')
				{
					$place_order['Buyers'][] = $legalEntity;
					$ProductType = 'Residential: Loan: Refinance';
				}
				elseif ($ProductTypeID == '20' || $ProductTypeID == '32') 
				{
					$place_order['Sellers'][] = $legalEntity;
					$place_order['SalesPrice'] = $SalesAmount;
					$ProductType = 'Residential: Sales: Purchase';
				}		
				
				$place_order['TransactionProductType'] = array("TransactionTypeID" => $TransactionTypeID, 'ProductTypeID'=>$ProductTypeID);

				if(isset($LoanAmount) && !empty($LoanAmount))
				{
					$place_order['Loans'][]['LoanAmount'] = $LoanAmount;
				}

				$place_order['Properties'][] = array('IsPrimary'=>'true', 'StreetNumber'=>$StreetNumber, 'StreetName'=> $StreetName, 'City'=> $PropertyCity, 'State'=> $PropertyState, 'County'=> $County, 'Zip'=>$PropertyZip);

				$order_data = json_encode($place_order);
				$this->load->library('order/resware');
				$logid = $this->apiLogs->syncLogs($userdata['id'], 'resware', 'create_order', RESWARE_ORDER_API.'orders', $order_data, array(), 0, 0);
				$result = $this->resware->make_request('POST', 'orders', $order_data);
				$this->apiLogs->syncLogs($userdata['id'], 'resware', 'create_order', RESWARE_ORDER_API.'orders', $order_data, $result, 0, $logid);
			
				if(isset($result) && !empty($result))
				{
					$response = json_decode($result,true);
					if(isset($response['ResponseStatus']) && !empty($response['ResponseStatus']))
					{
						$logDir = FCPATH.'logs/';
						if(!is_dir($logDir))
						{
							mkdir($logDir, 0777, true);
						}
						$logFile = $logDir.'place_order.log';

						$method = (file_exists($logFile)) ? 'a' : 'w';
						$fh = fopen($logFile,$method);

						fwrite($fh, date('m/d/Y H:i:s').' : '.$result."\n");
						fclose($fh);
					}
					$orderNumber = $file_id = '';

					if(isset($response['FileID']) && !empty($response['FileID']))
					{
						$orderNumber = isset($response['FileNumber']) && !empty($response['FileNumber']) ? $response['FileNumber'] : '';
						$file_id = isset($response['FileID']) && !empty($response['FileID']) ? $response['FileID'] : '';
						// $_SESSION['orderNumber'] = $orderNumber;
					}

					if($orderNumber)
					{
						/*$message = '<h3>Order Details:</h3><p>Customer Name: '.$OpenName.' '.$OpenLastName.'</p><p>Email Address: '.$OpenEmail.'</p><p>Order Number: '.$orderNumber.'</p>';*/
						$mail = $this->phpmailer_library->load();
						// $mail = new PHPMailer();
						$mail->isSendmail();
						$mail->IsHTML(true);
						$mail->setFrom($OpenEmail,$OpenName.' '.$OpenLastName);
						$mail->CharSet = "UTF-8";
						$mail->Encoding = "base64";
						$mail->Timeout = 200;
						$mail->ContentType = "text/html";
						$mail->addAddress('cs@pct.com', 'Open Order Desk');							
						$mail->Subject = "Order Placed at Resware";

						$data = array(
							'orderNumber'=> $orderNumber,
							'OpenName'=> $OpenName.' '.$OpenLastName,
							'Opentelephone'=> $Opentelephone,
							'OpenEmail'=> $OpenEmail,
							'CompanyName'=> $CompanyName,
							'StreetAddress'=> $StreetAddress,
							'City'=> $City,
							'Zipcode'=> $Zipcode,
							'PropertyAddress'=> $PropertyAddress,
							'FullProperty'=> $FullProperty,
							'APN'=> $apn,
							'County'=> $County,
							'LegalDescription'=> $LegalDescription,
							'PrimaryOwner'=> $PrimaryOwner,
							'SecondaryOwner'=> $SecondaryOwner,
							'SalesRep'=> $SalesRep,
							'TitleOfficer'=> $TitleOfficer,
							'ProductType'=> $ProductType,
							'SalesAmount'=> $SalesAmount,
							'LoanAmount'=> $LoanAmount,
							'sendermessage'=> $sendermessage,
							'buyers_agent'=> $buyers_agent_details,
							'listing_agent'=> $listing_agent_details,
							'lender_details'=> $lender_details,
							'escrow_details'=> $escrow_details,
							'currYear'=> CURRENT_YEAR
						 );

						$order_message_body = $this->load->view('emails/order.php',$data,TRUE);
						$mail->Body = $order_message_body;
						$mail->AltBody = "Use an HTML compatible email client";
						
						//send order deatils to all parties						
						if(isset($parties_email) && !empty($parties_email))
						{
							foreach($parties_email as $email => $name){
								$mail->AddBCC($email, $name);
							}
						}
						
						$mail->Send();
					} 

					$session_data = array(
						"orderNumber" => $orderNumber,
						"address" => $PropertyAddress,
						"city" => $PropertyCity,
						"apn" => $apn,
						"state" => $PropertyState,
						"county" => $County,
						"fipCode" => $PropertyFips
					);

					$this->session->set_userdata($session_data);
				}
				
				$customer_id = isset($_POST['id']) && !empty($_POST['id']) ? $_POST['id'] : '';

				$propertyData = array(
					'customer_id' => $customer_id,
					'buyer_agent_id' => $BuyerAgentId,
					'listing_agent_id' => $ListingAgentId,
					'escrow_lender_id' => $EscrowLenderId,
					'full_address' => $FullProperty,
					'apn' => $apn,
					'county' => $County,
					'legal_description' => $LegalDescription,
					'primary_owner' => $PrimaryOwner,
					'secondary_owner' => $SecondaryOwner,
					'additional_details'=> $sendermessage,
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
					'status'=> 1
				);

				$transactionId = $this->home_model->insert($transactionData,'transaction_details');

				$orderData = array(
					'customer_id' => $customer_id,
					'file_id' => $file_id,
					'file_number' => $orderNumber,
					'property_id' => $propertyId,
					'transaction_id' => $transactionId,
					'status'=> 1
				);

				$orderId = $this->home_model->insert($orderData,'order_details');

				echo '<div class="alert alert-success">Data saved successfully.</div>';
			

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
				
				if(isset($_FILES['orderfiles']) && !empty($_FILES['orderfiles']))
				{
					if ($_FILES['orderfiles']['error'] == 0) 
					{
						move_uploaded_file($_FILES['orderfiles']['tmp_name'], FCPATH.'smuploads/' .$order_upload);	
					
						
						// include dirname(__FILE__).'/templates/smartmessage.php';
							
						$mail = $this->phpmailer_library->load();
						$mail->isSendmail();
						$mail->IsHTML(true);
						$mail->setFrom($OpenEmail,$OpenEmail);
						$mail->CharSet = "UTF-8";
						$mail->Encoding = "base64";
						$mail->Timeout = 200;
						$mail->ContentType = "text/html";
						$mail->addAddress(RECEIVER_EMAIL, RECEIVER_NAME);
						$mail->Subject = RECEIVER_SUBJECT;
						$mail->AddAttachment(FCPATH.'smuploads/'.$order_upload);

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
					       'TitleOfficer'=> $TitleOfficer,
					       'LoanAmount'=> $LoanAmount,
					       'sendermessage'=> $sendermessage,
					       'poweredby_url'=> POWEREDBY_URL,
						   'poweredby_name'=> POWEREDBY_NAME,
						   'currYear'=> CURRENT_YEAR
					    );

						$message = $this->load->view('emails/smartmessage.php',$data,TRUE);	
						$mail->Body = $message;
						$mail->AltBody = "Use an HTML compatible email client";
								
						// For multiple email recepients from the form 
						// Simply change recepients from false to true
						// Then enter the recipients email addresses
						// echo $message;
						$recipients = false;
						if($recipients == true){
							$recipients = array(
								"rmcmahon@pct.com" => "Ryan",
								"openorders@pct.com" => "Open Order Desk"
							);
							
							foreach($recipients as $email => $name){
								$mail->AddBCC($email, $name);
							}	
						}
						
						if($mail->Send()) {
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
										
						  	echo '<div class="alert notification alert-success">Your title order is being submitted. Please wait for confirmation.</div>'; 
						  
							// Start delete function 
							// Automatically deletes files from the smuploads folder after successful sending
							// You can remove this function if you want to keep uploads on your server
							$files = glob(FCPATH.'smuploads/*'); 
							foreach($files as $file){ 
							  if(is_file($file))
								unlink($file); 
							}	  
						  
							} 
							else {
								echo '<div class="alert notification alert-error">Message not sent - server error occured!</div>';	
							}
					}
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
			$data['customer_data'] =  $this->home_model->get_user(array('id' => $userdata['id']));
	        $this->load->view('layout/head',$data);
	       	$this->load->view('order/home');
    	}
    	
        /* $this->load->view('layout/footer');*/
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
    	$isEscrow = isset($_POST['is_escrow']) && !empty($_POST['is_escrow']) ? $_POST['is_escrow'] : 0;


    	$condition = array(
            'name' => $searchTerm,
            'is_escrow' => $isEscrow,
        );

    	$userDetails = $this->home_model->get_customers($condition);
    	$userInfo = array();
    	if(isset($userDetails) && !empty($userDetails))
    	{
    		foreach ($userDetails as $key => $value) 
    		{
    			$data['id'] = isset($value['id']) && !empty($value['id']) ? $value['id'] : '';
            
	            $data['value'] = isset($value['value']) && !empty($value['value']) ? $value['value'] : '';

	            $data['name'] = isset($value['full_name']) && !empty($value['full_name']) ? $value['full_name'] : '';
	            $data['email_address'] = isset($value['email_address']) && !empty($value['email_address']) ? $value['email_address'] : '';
	            $data['telephone_no'] = isset($value['telephone_no']) && !empty($value['telephone_no']) ? $value['telephone_no'] : '';
	            $data['company'] = isset($value['company_name']) && !empty($value['company_name']) ? $value['company_name'] : '';
	            // array_push($userInfo, $data); 
	            $userInfo[] =$data;
    		}
    	}
    	echo json_encode($userInfo);
    }

    function orderSubmit()
    {
    	$data['title'] = 'Open Order | Pacific Coast Title Company';
    	$data['address'] = $this->session->userdata('address');
    	$data['city'] = $this->session->userdata('city');
    	$data['apn'] = $this->session->userdata('apn');
    	$data['state'] = $this->session->userdata('state');
    	$data['county'] = $this->session->userdata('county');
    	$data['fipCode'] = $this->session->userdata('fipCode');
    	$data['customer_number'] = $this->session->userdata('customer_number');
    	$data['orderNumber'] = $this->session->userdata('orderNumber');

        $this->load->view('layout/head',$data);
       	$this->load->view('order/order-submission',$data);

	}
	
	function logout()
	{
		$this->session->unset_userdata('user');
		redirect(base_url().'order');
	}

	function dashboard()
	{
		$userdata = $this->session->userdata('user');
		$name = isset($userdata['name']) && !empty($userdata['name']) ? $userdata['name'] : '';
		$data['name'] = $name;
		$data['title'] = 'Smart Dashboard | Pacific Coast Title Company';
		$this->load->view('layout/head_dashboard',$data);
		$this->load->view('order/dashboard');
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

			if((isset($customer_id) && !empty($customer_id)) || (isset($first_name) && !empty($first_name)))
			{
				$message = '<h3>User Details:</h3><p>Customer Number: '.$customer_no.'</p><p>Name: '.$first_name.' '.$last_name.'</p><p>Telephone: '.$telephone_no.'</p><p>Email Address: '.$email_address.'</p><p>Company Name: '.$company_name.'</p><p>Street Address: '.$street_address.'</p><p>City: '.$city.'</p><p>Zipcode: '.$zipcode.'</p><p>Property Address: '.$property.'</p>';

				$mail = $this->phpmailer_library->load();
				$mail->isSendmail();
				$mail->IsHTML(true);
				$mail->setFrom($email_address,$first_name.' '.$last_name);
				$mail->CharSet = "UTF-8";
				$mail->Encoding = "base64";
				$mail->Timeout = 200;
				$mail->ContentType = "text/html";
				$mail->addAddress('cs@pct.com', 'Find Property No Hit');					
				$mail->Subject = "Notification for No Hit on property search";				
				$mail->Body = $message;
				$mail->AltBody = "Use an HTML compatible email client";
				
				if($mail->Send())
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
}