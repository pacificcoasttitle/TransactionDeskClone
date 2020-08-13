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
        if (!is_dir('uploads/logs')) 
        {
            mkdir('./uploads/logs', 0777, TRUE);
        }

        $file = FCPATH.'uploads/logs/email.log';
        if (file_exists($file)) 
        {
          $fh = fopen($file, 'a');
        } 
        else 
        {
          $fh = fopen($file, 'w');
        }

        if($result = $instance->email->send())
        {
            $res = $this->email->print_debugger();
            fwrite($fh, date("Y-m-d H:i:s").": ".$res."\n");
            fclose($fh);
         	return true;
        }
        else
        {
            $res = $this->email->print_debugger();
            fwrite($fh, date("Y-m-d H:i:s").": ".$res."\n");
            fclose($fh);
          	return false;
        }
        
	}          
}

?>
