<?php 

if(!function_exists('send_email')) {

	function send_email($fromemail, $from_name, $to, $subject, $content, $pdfs =array(), $ccTo=null, $bcc=array())
    {
        $email = new SendGrid\Mail\Mail();
        $email->setFrom($fromemail, $from_name);
        $email->setSubject($subject);
        $email->addTo($to, "To User");

        if(isset($ccTo) && !empty($ccTo)) {
            $email->addCc($ccTo);
        }

        if(isset($bcc) && !empty($bcc)) {
            $email->addBcc($bcc);
        }
         
        $email->addContent(
            "text/html", $content
        );
        if(!empty($pdfs)) {
            foreach($pdfs as $pdf) {
                $email->addAttachment(
                    file_get_contents($pdf),
                    "application/pdf",
                    $pdf,
                    "attachment"
                );
            }
        }
        
        $sendgrid = new SendGrid(getenv('SENDGRID_API_KEY'));
        try {
            $response = $sendgrid->send($email);
            if($response->statusCode() == 202 || $response->statusCode() == 200) {
                return true;
            } else {
                return false;
            }
            
        } catch (Exception $e) {
           return false;
        }
        exit;  
	}          
}

?>
