<?php 

if(!function_exists('send_email')) {

	function send_email($fromemail, $from_name, $to, $subject, $content, $pdfs =array(), $ccs = array(), $bccs = array())
    {
        
        $email = new SendGrid\Mail\Mail();
        $email->setFrom($fromemail, $from_name);
        $email->setSubject($subject);
        $email->addTo($to, "To User");
        $ccEmails = array();
        $bccEmails = array();

        if(isset($ccs) && !empty($ccs)) {
           foreach($ccs as $cc) {
                $ccEmails[$cc] = 'Cc User';
           }
           $email->addCcs($ccEmails);
        }

        if(isset($bccs) && !empty($bccs)) {
            foreach($bccs as $bcc) {
                $bccEmails[$bcc] = 'Bcc User';
            }
            $email->addBccs($bccEmails);
        }

        $email->addContent(
            "text/html", $content
        );
        if(!empty($pdfs)) {
            foreach($pdfs as $pdf) {
                $documentName = pathinfo($pdf);
                $email->addAttachment(
                    file_get_contents($pdf),
                    "application/pdf",
                    $documentName['basename'],
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
                return "failuer";
            }
            
        } catch (Exception $e) {
           return false;
        }
        exit;  
	}          
}

?>
