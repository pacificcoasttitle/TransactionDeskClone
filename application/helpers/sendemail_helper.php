<?php 

if(!function_exists('send_email')){
	function send_email($fromemail, $from_name, $to, $subject, $content,$myPdf=array(),$ccTo=null,$bcc=array()){
		$instance = &get_instance();
		$instance->load->library('email');

		$config['protocol']     = 'smtp';
        $config['smtp_host']    = 'smtp.sendgrid.net';
        $config['smtp_port']    = '25';
        $config['smtp_timeout'] = '120';
        $config['smtp_user']    = 'pacificcoasttitlecompany';
        $config['smtp_pass']    = 'Alpha637#';
        $config['charset']      = 'utf-8';
        $config['newline']      = "\r\n";
        $config['mailtype']     = 'html'; // or html
        $config['validation']   = TRUE; // bool whether to validate email or not  
		$instance->email->initialize($config);
		    

        $instance->email->initialize($config);
		
		$instance->email->from($fromemail, $from_name);
        $instance->email->to($to); 
        if(!is_null($ccTo)){
            $instance->email->cc($ccTo);
        }
        $instance->email->subject($subject);
        $instance->email->message($content);  

        if(isset($bcc) && !empty($bcc))
        {
            $instance->email->bcc($bcc);
        }
        foreach($myPdf as $file){
            $instance->email->attach($file);
        }
        $result = $instance->email->send();
        var_dump($result);
        echo "<pre>"; print_r($bcc);
        echo $this->email->print_debugger();die;
        /*if($instance->email->send()){
         	return true;
        }else{
          	return false;
        }*/
	}          
}

?>
