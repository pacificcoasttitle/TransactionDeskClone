<?php

	if (!isset($_SESSION)) session_start(); 
	if(!$_POST) exit;
	
	include dirname(__FILE__).'/settings/settings.php';
	include dirname(__FILE__).'/functions/emailValidation.php';
	// include dirname(__FILE__).'/phpmailer/PHPMailerAutoload.php';
	
	/* Current Date Year
	------------------------------- */		
	$currYear = date("Y");	
	
/*	---------------------------------------------------------------------------
	: Register all form field variables here
	--------------------------------------------------------------------------- */	
	$CustomerNumber = isset($_POST["CustomerNumber"]) && !empty($_POST["CustomerNumber"]) ? strip_tags(trim($_POST["CustomerNumber"])) : '';

	$OpenName = isset($_POST["OpenName"]) && !empty($_POST["OpenName"]) ? strip_tags(trim($_POST["OpenName"])) : '';

	$OpenLastName = isset($_POST["OpenLastName"]) && !empty($_POST["OpenLastName"]) ? strip_tags(trim($_POST["OpenLastName"])) : '';

	$Opentelephone = isset($_POST["Opentelephone"]) && !empty($_POST["Opentelephone"]) ? strip_tags(trim($_POST["Opentelephone"])) : '' ;

	$OpenEmail = isset($_POST["OpenEmail"]) && !empty($_POST["OpenEmail"]) ? strip_tags(trim($_POST["OpenEmail"])) : '' ;

	$CompanyName = isset($_POST["CompanyName"]) && !empty($_POST["CompanyName"]) ? strip_tags(trim($_POST["CompanyName"])) : '' ;

	$StreetAddress = isset($_POST["StreetAddress"]) && !empty($_POST["StreetAddress"]) ? strip_tags(trim($_POST["StreetAddress"])) : '' ;

	$City = isset($_POST["City"]) && !empty($_POST["City"]) ? strip_tags(trim($_POST["City"])) : '' ;

	$Zipcode = isset($_POST["Zipcode"]) && !empty($_POST["Zipcode"]) ? strip_tags(trim($_POST["Zipcode"])) : '' ;	

	$PropertyAddress = isset($_POST["Property"]) && !empty($_POST["Property"]) ? strip_tags(trim($_POST["Property"])) : '';
	$SplitPropertyAddress = explode(' ', $PropertyAddress);

	$StreetNumber = isset($SplitPropertyAddress[0]) && !empty($SplitPropertyAddress[0]) ? $SplitPropertyAddress[0] : '';

	$PrimaryStreetName = array_slice($SplitPropertyAddress, 1);

	$StreetName = isset($PrimaryStreetName) && !empty($PrimaryStreetName) ? implode(" ", $PrimaryStreetName) : '';

	$PropertyState = isset($_POST["property-state"]) && !empty($_POST["property-state"]) ? strip_tags(trim($_POST["property-state"])) : '';

	$PropertyCity = isset($_POST["property-city"]) && !empty($_POST["property-city"]) ? strip_tags(trim($_POST["property-city"])) : '';

	$PropertyFips = isset($_POST["property-fips"]) && !empty($_POST["property-fips"]) ? strip_tags(trim($_POST["property-fips"])) : '';

	$FullProperty = isset($_POST["FullProperty"]) && !empty($_POST["FullProperty"]) ? strip_tags(trim($_POST["FullProperty"])) : '';

	$AddressPropertyParts = explode(',', $FullProperty);
	
	$PropertyZip = trim(end($AddressPropertyParts));

	$apn = isset($_POST["apn"]) && !empty($_POST["apn"]) ? strip_tags(trim($_POST["apn"])) : '';

	$County = isset($_POST["County"]) && !empty($_POST["County"]) ? strip_tags(trim($_POST["County"])) : '';

	$LegalDescription = isset($_POST["LegalDescription"]) && !empty($_POST["LegalDescription"]) ? strip_tags(trim($_POST["LegalDescription"])) : '';

	$PrimaryOwner = isset($_POST["PrimaryOwner"]) && !empty($_POST["PrimaryOwner"]) ? strip_tags(trim($_POST["PrimaryOwner"])) : '';

	$SplitName = explode(' ', $PrimaryOwner);
	$OwnerLastName = end($SplitName);

	$PrimaryName = array_slice($SplitName, 0, -1);
	$OwnerFirstName = implode(" ", $PrimaryName);

	$SecondaryOwner = isset($_POST["SecondaryOwner"]) && !empty($_POST["SecondaryOwner"]) ? strip_tags(trim($_POST["SecondaryOwner"])) : '';

	$SalesRep = isset($_POST["SalesRep"]) && !empty($_POST["SalesRep"]) ? strip_tags(trim($_POST["SalesRep"])) : '' ;

	$TitleOfficer = isset($_POST["TitleOfficer"]) && !empty($_POST["TitleOfficer"]) ? strip_tags(trim($_POST["TitleOfficer"])) : '';

	$LoanAmount = isset($_POST["loanAmount"]) && !empty($_POST["loanAmount"]) ? strip_tags(trim($_POST["loanAmount"])) : '';

	$SalesAmount = isset($_POST["salesAmount"]) && !empty($_POST["salesAmount"]) ? strip_tags(trim($_POST["salesAmount"])) : '';

	$TransactionTypeID = isset($_POST["TransactionTypeID"]) && !empty($_POST["TransactionTypeID"]) ? $_POST["TransactionTypeID"] : '';

	$ProductTypeID = isset($_POST["ProductTypeID"]) && !empty($_POST["ProductTypeID"]) ? $_POST["ProductTypeID"] : '';

	$CCR = isset($_POST["CCR"]) && !empty($_POST["CCR"]) ? 1 : 0;
	$Docs = isset($_POST["Docs"]) && !empty($_POST["Docs"]) ? 1 : 0;
	$Ease = isset($_POST["Ease"]) && !empty($_POST["Ease"]) ? 1 : 0;

	$sendermessage = isset($_POST["sendermessage"]) && !empty($_POST["sendermessage"]) ? strip_tags(trim($_POST["sendermessage"])) : '';

	$AgentId = isset($_POST["AgentId"]) && !empty($_POST["AgentId"]) ? strip_tags(trim($_POST["AgentId"])) : '';

	$order_file = uniqid();
	$order_upload = $order_file.isset($_FILES['orderfiles']['name']) && !empty($_FILES['orderfiles']['name']) ? $_FILES['orderfiles']['name'] : '';	
	
/*	----------------------------------------------------------------------
	: Prepare form field variables for CSV export
	----------------------------------------------------------------------- */	
	if($generateCSV == true){
		$csvFile = $csvFileName;	
		$csvData = array(
			"$sendername",
			"$emailaddress",
			"$telephone",
			"$senderwebsite",
			"$orderservices",
			"$orderbudget",
			"$ordertimeframe"			
		);
	}

/*	-------------------------------------------------------------------------
	: Prepare serverside validation 
	------------------------------------------------------------------------- */
	$errors = array();
	 //validate name
	if(isset($_POST["sendername"])){
			if (!$sendername) {
				$errors[] = "You must enter a name.";
			} elseif(strlen($sendername) < 2)  {
				$errors[] = "Name must be at least 2 characters.";
			}
	}
	
	//validate email address
	if(isset($_POST["emailaddress"])){
		if (!$emailaddress) {
			$errors[] = "You must enter an email.";
		} else if (!validEmail($emailaddress)) {
			$errors[] = "Your must enter a valid email address.";
		}
	}
		
	//validate services
	if(isset($_POST["orderservices"])){
			if (!$orderservices) {
				$errors[] = "You must select a service.";
			}
	}
	
	//validate file uploads
	if(isset($_FILES['orderfiles'])) {
		// maximum file size :: 2MB
		$maxsize    =  2097152; 
		// File must be attached
		if (empty($_FILES['orderfiles']['name'])) {
			$errors[] = "You must browse or attach a file.";
		}
		// File size must be 2MB or less
		if ($_FILES['orderfiles']['size'] > $maxsize) {
			$errors[] = "File uploaded is too large. Try 2MB or less.";
		}
		// Detect allowed file extentions
		$valid_file_extensions = array(".jpg", ".jpeg", ".png");
		$file_extension = strrchr($_FILES["orderfiles"]["name"], ".");
		// Check that the uploaded file is actually an image
		if (!in_array($file_extension, $valid_file_extensions)) {
			$errors[] = "Please upload a jpg or png image file.";
		}		
	}	
	
	//validate message / comment
	if(isset($_POST["sendermessage"])){
		if (strlen($sendermessage) < 10) {
			if (!$sendermessage) {
				$errors[] = "You must enter a message.";
			} else {
				$errors[] = "Message must be at least 10 characters.";
			}
		}
	}
	
	// validate security captcha 
	if(isset($_POST["captcha"])){
		if (!$captcha) {
			$errors[] = "You must enter the captcha code";
		} else if (($captcha) != $_SESSION['gfm_captcha']) {
			$errors[] = "Captcha code is incorrect";
		}
	}
	
	//In case there are errors, output them in a list
	if ($errors) 
	{
		$errortext = "";
		foreach ($errors as $error) {
			$errortext .= '<li>'. $error . "</li>";
		}
		echo '<div class="alert notification alert-error">The following errors occured:<br><ul>'. $errortext .'</ul></div>';
	
	} 
	else
	{
		// Store data to DB
		include dirname(__FILE__).'/../config/database.php';
		include dirname(__FILE__).'/../config/config.php';

		/* Start place order at resware */
		$place_order = array();

		$legalEntity = array('EntityType'=>'INDIVIDUAL', 'IsPrimaryTransactee' => 'true', 'primary'=> array('First'=>$OwnerFirstName,'Last'=>$OwnerLastName),'Address'=>array('Address1'=>$PropertyAddress, 'City'=> $PropertyCity, 'State'=> $PropertyState, 'Zip'=>$PropertyZip));

		if($ProductTypeID == '19' || $ProductTypeID == '33')
		{
			$place_order['Buyers'][] = $legalEntity;
		}
		elseif ($ProductTypeID == '20' || $ProductTypeID == '32') 
		{
			$place_order['Sellers'][] = $legalEntity;
			$place_order['SalesPrice'] = $SalesAmount;
		}		
		
		$place_order['TransactionProductType'] = array("TransactionTypeID" => $TransactionTypeID, 'ProductTypeID'=>$ProductTypeID);

		if(isset($LoanAmount) && !empty($LoanAmount))
		{
			$place_order['Loans'][]['LoanAmount'] = $LoanAmount;
		}

		$place_order['Properties'][] = array('IsPrimary'=>'true', 'StreetNumber'=>$StreetNumber, 'StreetName'=> $StreetName, 'City'=> $PropertyCity, 'State'=> $PropertyState, 'County'=> $County, 'Zip'=>$PropertyZip);

		$order_data = json_encode($place_order);

		$login = 'Ghernandez@pct.com';
		$password= 'Alpha637#';

		/*$login_array = array('djorns@capstoneescrow.com','bfong@americantrustescrow.com','angiebao@jadeescrow.com','jrodriguez@capstoneescrow.com','ghernandez@pct.com');*/
		$password= 'Pacific2';

		if($conn)
		{
			
			$query = $conn->query("SELECT password FROM customer_basic_details WHERE email_address = '".$OpenEmail."'");

				$userPassword = '';
				if($query->num_rows > 0)
				{ 
					$userRow = $query->fetch_assoc();
					$userPassword = isset($userRow['password']) && !empty($userRow['password']) ? $userRow['password'] : '';
				}
		}

		/*if(in_array($OpenEmail, $login_array) && md5($password) == $userPassword)
		{*/
			$ch = curl_init(PLACE_ORDER_API);                                    
			curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");                        
			curl_setopt($ch, CURLOPT_POSTFIELDS, $order_data);                   
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
			// curl_setopt($ch, CURLOPT_USERPWD, "$OpenEmail:$password");
			curl_setopt($ch, CURLOPT_USERPWD, "$login:$password");
			curl_setopt($ch, CURLOPT_HTTPHEADER, array(                                
			    'Content-Type: application/json',
			    'Content-Length: ' . strlen($order_data))                                 
			); 
			$error_msg = curl_error($ch);
			$result = curl_exec($ch);

			if(isset($result) && !empty($result))
			{
				$response = json_decode($result,true);
				
				if(isset($response['ResponseStatus']) && !empty($response['ResponseStatus']))
				{
					$logDir = __DIR__.'/../logs/';
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
				$orderNumber = '';

				if(isset($response['FileID']) && !empty($response['FileID']))
				{
					$orderNumber = isset($response['FileNumber']) && !empty($response['FileNumber']) ? $response['FileNumber'] : '';
					$_SESSION['orderNumber'] = $orderNumber;
				}

				/*if($orderNumber)
				{
					$message = '<h3>Order Details:</h3><p>Customer Name: '.$OpenName.' '.$OpenLastName.'</p><p>Email Address: '.$OpenEmail.'</p><p>Order Number: '.$orderNumber.'</p>';
					$mail = new PHPMailer();
					$mail->isSendmail();
					$mail->IsHTML(true);
					$mail->setFrom($OpenEmail,$OpenName.' '.$OpenLastName);
					$mail->CharSet = "UTF-8";
					$mail->Encoding = "base64";
					$mail->Timeout = 200;
					$mail->ContentType = "text/html";
					$mail->addAddress('openorders@pct.com', 'Open Order Desk');
					$mail->Subject = "Order Placed at Resware";						
					$mail->Body = $message;
					$mail->AltBody = "Use an HTML compatible email client";

					$mail->Send();
					
				}*/

				$_SESSION['address'] = $PropertyAddress;
				$_SESSION['city'] = $PropertyCity;
				$_SESSION['apn'] = $apn;
				$_SESSION['state'] = $PropertyState;
				$_SESSION['county'] = $County;
				$_SESSION['fipCode'] = $PropertyFips;
			}
		/*}*/
		/* End place order at resware */

		$data = array();
		if($conn)
		{
			$password = md5('Pacific2');
			if(empty($_POST['id']))
			{
				$time = date("Y-m-d H:i:s");
				$query = $conn->query("SELECT random_num
						FROM (
						  SELECT FLOOR(1000 + ( RAND( ) * 8999 )) AS random_num 
						  UNION
						  SELECT FLOOR(1000 + ( RAND( ) * 8999 )) AS random_num
						) AS customer_basic_details_plus_1
						WHERE `random_num` NOT IN (SELECT customer_number FROM customer_basic_details)
						LIMIT 1");

				$customer_number = '';
				if($query->num_rows > 0)
				{ 
					$row = $query->fetch_assoc();
					$customer_number = isset($row['random_num']) && !empty($row['random_num']) ? $row['random_num'] : '';
					// $data['customer_number'] = $customer_number;
					$_SESSION['customer_number'] = $customer_number;
				}
				
				$sql = "INSERT INTO `pctorder`.`customer_basic_details` (`customer_number`,`first_name`,`last_name`,`telephone_no`,`email_address`,`password`,`company_name`,`street_address`,`city`,`zip_code`,`status`,`created_at`) 
				VALUES
				('".$customer_number."', '".$OpenName."','".$OpenLastName."','".$Opentelephone."','".$OpenEmail."','".$password."','".$CompanyName."','".$StreetAddress."','".$City."','".$Zipcode."','1','".$time."'
			    );";

				if ($conn->query($sql) === TRUE) 
				{
					$id = $conn->insert_id;
					if($id)
					{

						$property_query = "INSERT INTO `pctorder`.`property_details` (`customer_id`,`agent_id`,`address`,`full_address`,`apn`,`county`,`legal_description`,`primary_owner`,`secondary_owner`,`additional_details`,`status`,`created_at`) 
						VALUES
						('".$id."','".$AgentId."','".$PropertyAddress."','".$FullProperty."','".$apn."','".$County."','".$LegalDescription."','".$PrimaryOwner."','".$SecondaryOwner."','".$sendermessage."','1','".date("Y-m-d H:i:s")."'
						);";

						$conn->query($property_query);

						$transaction_query = "INSERT INTO `pctorder`.`transaction_details` (`customer_id`,`sales_representative`,`title_officer`,`sales_amount`,`loan_amount`,`transaction_type`,`purchase_type`,`is_ccr`,`is_underlying_docs`,`is_plotted_easements`,`status`,`created_at`)
							VALUES
							('".$id."','".$SalesRep."','".$TitleOfficer."','".$SalesAmount."','".$LoanAmount."','".$TransactionTypeID."','".$ProductTypeID."','".$CCR."','".$Docs."','".$Ease."','1','".date("Y-m-d H:i:s")."'
							);";

						$conn->query($transaction_query);
						// $data['msg'] = '<div class="alert alert-success">Data saved successfully.</div>';
					}
					echo '<div class="alert alert-success">Data saved successfully.</div>';
					// echo json_encode($data);								    
				} 
				else 
				{
				    // echo "Error: " . $sql . "<br>" . $conn->error;
				    echo '<div class="alert alert-danger">Something went wrong.</div>';
				    /*$data['msg'] = '<div class="alert alert-danger">Something went wrong.</div>';
				    echo json_encode($data);*/
				}
			}
			else
			{
				//update details table
				$customer_id = isset($_POST['id']) && !empty($_POST['id']) ? $_POST['id'] : '';

				$time = date("Y-m-d H:i:s");

				$property_query = "INSERT INTO `pctorder`.`property_details` (`customer_id`,`agent_id`,`address`,`full_address`,`apn`,`county`,`legal_description`,`primary_owner`,`secondary_owner`,`additional_details`,`status`,`created_at`) 
				VALUES
				('".$customer_id."','".$AgentId."','".$PropertyAddress."','".$FullProperty."','".$apn."','".$County."','".$LegalDescription."','".$PrimaryOwner."','".$SecondaryOwner."','".$sendermessage."','1','".date("Y-m-d H:i:s")."'
				);";

				$conn->query($property_query);


				$transaction_query = "INSERT INTO `pctorder`.`transaction_details` (`customer_id`,`sales_representative`,`title_officer`,`sales_amount`,`loan_amount`,`transaction_type`,`purchase_type`,`is_ccr`,`is_underlying_docs`,`is_plotted_easements`,`status`,`created_at`)
				VALUES
				('".$customer_id."','".$SalesRep."','".$TitleOfficer."','".$SalesAmount."','".$LoanAmount."','".$TransactionTypeID."','".$ProductTypeID."','".$CCR."','".$Docs."','".$Ease."','1','".date("Y-m-d H:i:s")."'
				);";

				$conn->query($transaction_query);

				echo '<div class="alert alert-success">Data saved successfully.</div>';
				// $data['msg'] = '<div class="alert alert-success">Data saved successfully.</div>';
				// echo json_encode($data);
			}
			
		}

		$redirectForm = true;
		if($redirectForm == true)
		{
			echo '<script>setTimeout(function () { window.location.replace("http://localhost/beta-pct-calc/order/order-submitted.php") }, 8000); </script>';
		}

		/*if ($_FILES['orderfiles']['error'] == 0) 
		{
			move_uploaded_file($_FILES['orderfiles']['tmp_name'], '../smuploads/' .$order_upload);	
		
			
			include dirname(__FILE__).'/templates/smartmessage.php';
				
			$mail = new PHPMailer();
			$mail->isSendmail();
			$mail->IsHTML(true);
			$mail->setFrom($emailaddress,$sendername);
			$mail->CharSet = "UTF-8";
			$mail->Encoding = "base64";
			$mail->Timeout = 200;
			$mail->ContentType = "text/html";
			$mail->addAddress($receiver_email, $receiver_name);
			$mail->Subject = $receiver_subject;
			$mail->AddAttachment('../smuploads/'.$order_upload);	
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
				if($generateCSV == true){	
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
				if($autoResponder == true){
				
					include dirname(__FILE__).'/templates/autoresponder.php';
					
					$automail = new PHPMailer();
					$automail->isSendmail();
					$automail->setFrom($receiver_email,$receiver_name);
					$automail->isHTML(true);                                 
					$automail->CharSet = "UTF-8";
					$automail->Encoding = "base64";
					$automail->Timeout = 200;
					$automail->ContentType = "text/html";
					$automail->AddAddress($emailaddress, $sendername);
					$automail->Subject = "Thank you for contacting us";
					$automail->Body = $automessage;
					$automail->AltBody = "Use an HTML compatible email client";
					$automail->Send();	 
				}
				
				if($redirectForm == true){
					echo '<script>setTimeout(function () { window.location.replace("'.$redirectForm_url.'") }, 8000); </script>';
				}
							
			  	echo '<div class="alert notification alert-success">Your title order is being submitted. Please wait for confirmation.</div>'; 
			  
				// Start delete function 
				// Automatically deletes files from the smuploads folder after successful sending
				// You can remove this function if you want to keep uploads on your server
				$files = glob('../smuploads/*'); 
				foreach($files as $file){ 
				  if(is_file($file))
					unlink($file); 
				}	  
			  
				} 
				else {
					echo '<div class="alert notification alert-error">Message not sent - server error occured!</div>';	
				}
		}*/
	}
?>