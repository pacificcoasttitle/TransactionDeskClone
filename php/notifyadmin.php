<?php

include dirname(__FILE__).'/phpmailer/PHPMailerAutoload.php';

$customer_no = isset($_POST["customer_no"]) && !empty($_POST["customer_no"]) ? strip_tags(trim($_POST["customer_no"])) : '-';

$first_name = isset($_POST["first_name"]) && !empty($_POST["first_name"]) ? strip_tags(trim($_POST["first_name"])) : '-';

$last_name = isset($_POST["last_name"]) && !empty($_POST["last_name"]) ? strip_tags(trim($_POST["last_name"])) : '-';

$telephone_no = isset($_POST["telephone_no"]) && !empty($_POST["telephone_no"]) ? strip_tags(trim($_POST["telephone_no"])) : '-';

$email_address = isset($_POST["email_address"]) && !empty($_POST["email_address"]) ? strip_tags(trim($_POST["email_address"])) : '-';

$company_name = isset($_POST["company_name"]) && !empty($_POST["company_name"]) ? strip_tags(trim($_POST["company_name"])) : '-';

$street_address = isset($_POST["street_address"]) && !empty($_POST["street_address"]) ? strip_tags(trim($_POST["street_address"])) : '-';

$city = isset($_POST["city"]) && !empty($_POST["city"]) ? strip_tags(trim($_POST["city"])) : '-';

$zipcode = isset($_POST["zipcode"]) && !empty($_POST["zipcode"]) ? strip_tags(trim($_POST["zipcode"])) : '-';

$zipcode = isset($_POST["zipcode"]) && !empty($_POST["zipcode"]) ? strip_tags(trim($_POST["zipcode"])) : '-';

$property = isset($_POST["property"]) && !empty($_POST["property"]) ? strip_tags(trim($_POST["property"])) : '-';

if((isset($customer_no) && !empty($customer_no)) || (isset($first_name) && !empty($first_name)))
{
	$message = '<h3>User Details:</h3><p>Customer Number: '.$customer_no.'</p><p>Name: '.$first_name.' '.$last_name.'</p><p>Telephone: '.$telephone_no.'</p><p>Email Address: '.$email_address.'</p><p>Company Name: '.$company_name.'</p><p>Street Address: '.$street_address.'</p><p>City: '.$city.'</p><p>Zipcode: '.$zipcode.'</p><p>Property Address: '.$property.'</p>';

	$mail = new PHPMailer();
	$mail->isSendmail();
	$mail->IsHTML(true);
	$mail->setFrom($email_address,$first_name.' '.$last_name);
	$mail->CharSet = "UTF-8";
	$mail->Encoding = "base64";
	$mail->Timeout = 200;
	$mail->ContentType = "text/html";
	// $mail->addAddress('cs@pct.com', 'Find Property No Hit');
	$mail->addAddress('a.parmar@crestinfosystems.net', 'Find Property No Hit');
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