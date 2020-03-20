<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class User extends CI_Controller 
{

	public function __construct()
	{
		parent::__construct();
		$this->load->helper('url');
		$this->load->library('session');
		$this->load->library('pagination');
		$this->load->library('email');
		$this->load->model('welcome_model');
		$this->load->model('user_model');
	}

	public function is_user()
	{
		if($this->session->userdata('mpuserid'))
		{
			
		}
		else 
		{
			redirect("welcome/login");
		}
	}

	public function index()
	{
		if($this->session->userdata('mpuserid'))
		{
			$offset=0;	
		  	//print_r($_POST);die;
		  	if($this->uri->segment(3))
	          {
	            $offset=$this->uri->segment(3);
	          }
            $data['count']= $this->user_model->get_user_articles_count();
		    $config['base_url'] = base_url().'index.php/user/index/';
		    $config['uri_segment'] = 3;
            $config['per_page']= 6;
            $config['total_rows'] = $data['count'];
            $this->pagination->initialize($config);
	        $data['page_links']=$this->pagination->create_links();
	        $data['active'] = 'my_account';
            //$data['uri'] = $name1;
			$data['userarticles'] = $this->user_model->get_user_articles($config['per_page'],$offset);
			$data['departments'] = $this->welcome_model->get_departments();
			$data['user_info'] = $this->user_model->get_user_info($this->session->userdata('mpuserslug'));
			$this->load->view('front/header',$data);
			$this->load->view('front/my_profile',$data);
			$this->load->view('front/sidebar',$data);
			$this->load->view('front/footer',$data);
		}
		else 
		{
			redirect("welcome/login");
		}
	}


	public function dashboard()
	{
		if($this->session->userdata('mpuserid'))
		{
			$offset=0;	
		  	//print_r($_POST);die;
		  	if($this->uri->segment(3))
	          {
	            $offset=$this->uri->segment(3);
	          }
            $data['count']= $this->user_model->get_user_articles_count();
		    $config['base_url'] = base_url().'index.php/user/index/';
		    $config['uri_segment'] = 3;
            $config['per_page']= 6;
            $config['total_rows'] = $data['count'];
            $this->pagination->initialize($config);
	        $data['page_links']=$this->pagination->create_links();
	        $data['active'] = 'my_account';
            //$data['uri'] = $name1;
			$data['userarticles'] = $this->user_model->get_user_articles($config['per_page'],$offset);
			$data['departments'] = $this->welcome_model->get_departments();
			$data['user_info'] = $this->user_model->get_user_info($this->session->userdata('mpuserslug'));
			$this->load->view('front/header',$data);
			$this->load->view('front/dashboard',$data);
			$this->load->view('front/sidebar',$data);
			$this->load->view('front/footer',$data);
		}
		else 
		{
			redirect("welcome/login");
		}
	}


	public function create_my_e_portfolio($value='')
	{
		if($this->session->userdata('mpuserid'))
		{
			$id = $this->session->userdata('mpuserid');
			if ($_FILES["userfile1"]["error"] > 0)
                    {
                    }
                  else
                    {
                    $_POST['type'] = 'user';
                    $ext = end(explode('.', $_FILES["userfile1"]["name"])); 
                    $un =  uniqid();
                   $path = "upload/".$_POST['type']."/".$id;
                    if(!is_dir($path)){
                      mkdir($path);
                    }
                      /* new file name */
                      if($_FILES["userfile1"]["name"] != "")
                      {
                      	$path = 'upload/'.$_POST['type'].'/'.$id.'/'.$_FILES['userfile1']['name'];
                       if (file_exists('upload/'.$_POST['type'].'/'.$id.'/'.$_FILES["userfile1"]["name"]))
                        {
                        $un = uniqid();
                        $_FILES["userfile1"]["name"] = $un.".".$ext;
                        }
                         $path = 'upload/'.$_POST['type'].'/'.$id.'/'.$_FILES['userfile1']['name'];

                        move_uploaded_file($_FILES["userfile1"]["tmp_name"],
                         $path);
                        $this->welcome_model->change_cv_user($id,$_FILES["userfile1"]["name"]);    
                    }
                 }
                 if ($_FILES["userfile2"]["error"] > 0)
                    {
                    }
                  else
                    {
                     $_POST['type'] = 'user';
                    $ext = end(explode('.', $_FILES["userfile2"]["name"])); 
                    $un =  uniqid();
                   $path = "upload/".$_POST['type']."/".$id;
                    if(!is_dir($path)){
                      mkdir($path);
                    }
                      /* new file name */
                      if($_FILES["userfile2"]["name"] != "")
                      {
                      	$path = 'upload/'.$_POST['type'].'/'.$id.'/'.$_FILES['userfile2']['name'];
                       if (file_exists('upload/'.$_POST['type'].'/'.$id.'/'.$_FILES["userfile2"]["name"]))
                        {
                         $un = uniqid();
                        $_FILES["userfile2"]["name"] = $un.".".$ext;
                        }
                         $path = 'upload/'.$_POST['type'].'/'.$id.'/'.$_FILES['userfile2']['name'];

                        move_uploaded_file($_FILES["userfile2"]["tmp_name"],
                         $path);
                        $this->welcome_model->change_profile_user($id,$_FILES["userfile2"]["name"]);    
                        $this->session->set_flashdata('msg', 'Thank you for creating your Profile, you will be notified as soon as your Profile is ready. This takes about 24 hours to complete.');
                        redirect('user');
                    }
                 }
			$this->load->view('front/header');
			$data['page_content'] = $this->welcome_model->get_content('create_my_reposit');
			$this->load->view('front/create_my_e_portfolio',$data);
			$this->load->view('front/sidebar',$data);
			$this->load->view('front/footer');
		}
		else 
		{
			redirect("welcome/login");
		}
	}

public function upload_article($value='')
	{
		if($this->session->userdata('mpuserid'))
		{
			$data['page_content'] = $this->welcome_model->get_content('upload_file');
			$data['departments'] = $this->welcome_model->get_departments();
			$this->load->view('front/header');
			$this->load->view('front/upload_article',$data);
			$this->load->view('front/sidebar',$data);
			$this->load->view('front/footer');
		}
		else 
		{
			redirect("welcome/login");
		}
	}

	public function all_e_portfolio()
	{
		$this->is_user();
			$offset=0;	
		  	if($this->uri->segment(2))
	          {
	            $offset=$this->uri->segment(2);
	          }
 
            $data['count']= $this->user_model->get_all_department_user_count();
		    $config['base_url'] = base_url().'all-profiles/';
		    $config['uri_segment'] = 2;
            $config['per_page']= 8;
            $config['total_rows'] = $data['count'];
            $this->pagination->initialize($config);
	        $data['page_links']=$this->pagination->create_links();
	        $data['active'] = 'e_portfolios';
			$data['dept_users'] = $this->user_model->get_all_department_user($config['per_page'],$offset);
			$data['departments'] = $this->welcome_model->get_departments();
			$this->load->view('front/header',$data);
			$this->load->view('front/all_e_portfolio',$data);
			$this->load->view('front/sidebar',$data);
			$this->load->view('front/footer',$data);
		
	}
public function payment_plan()
	{
		$this->is_user();
		$data['page_content'] = $this->welcome_model->get_content('eportfolio');
		$this->load->view('front/header');
		$this->load->view('front/payment',$data);
		$this->load->view('front/footer');
	}

	public function e_portfolios($name='')
	{
		$this->is_user();
			$name1 = str_replace( "-"," ",$name);
			$offset=0;	
		  	//print_r($_POST);die;
		  	if($this->uri->segment(4))
	          {
	            $offset=$this->uri->segment(4);
	          }
 
            $data['count']= $this->user_model->get_department_user_count($name1);
		    $config['base_url'] = base_url().'speciality/'.$name."/";
		    $config['uri_segment'] = 4;
            $config['per_page']= 6;
            $config['total_rows'] = $data['count'];
            $this->pagination->initialize($config);
	        $data['page_links']=$this->pagination->create_links();
	        $data['active'] = 'e_portfolios';
            $data['uri'] = $name1;
			$data['dept_users'] = $this->user_model->get_department_user($name,$config['per_page'],$offset);
			$data['top_dept_users'] = $this->user_model->get_department_user($name,20,0);
			$data['departments'] = $this->welcome_model->get_departments();
			$this->load->view('front/header',$data);
			$this->load->view('front/special_e_portfolio',$data);
			$this->load->view('front/sidebar',$data);
			$this->load->view('front/footer',$data);
		
	}

	public function save_article()
	{
		if($this->session->userdata('mpuserid'))
		{
			if($this->input->is_ajax_request())
			{
				$id = $this->session->userdata('mpuserid');
				$articleid = $this->user_model->save_user_article();
				$limit = sizeof($_FILES["userfile"]["error"]);
				//print_r($_FILES);die;
				if($limit > 0)
				{
					for ($i=0; $i < $limit; $i++) 
					{ 
						if ($_FILES["userfile"]["error"][$i] > 0)
		                    {
		                    }
		                  else
		                    {
		                    $_POST['type'] = 'user';
		                    $ext = end(explode('.', $_FILES["userfile"]["name"][$i])); 
		                    $un =  uniqid();
		                   $path = "upload/".$_POST['type']."/".$id;
		                    if(!is_dir($path)){
		                      mkdir($path);
		                    }
		                    $path = "upload/".$_POST['type']."/".$id."/articles";
		                    if(!is_dir($path)){
		                      mkdir($path);
		                    }
		                      /* new file name */
		                      if($_FILES["userfile"]["name"][$i] != "")
		                      {

		                      	$path_parts = pathinfo($_FILES['userfile']['name'][$i]);
								/* new file name */
								$file = $this->slugify($path_parts['filename']);
								$_FILES['userfile2']['name'][$i] = $file.".".$ext;
		                      	$path = 'upload/'.$_POST['type'].'/'.$id.'/articles/'.$_FILES['userfile']['name'][$i];
		                       if (file_exists('upload/'.$_POST['type'].'/'.$id.'/articles/'.$_FILES["userfile"]["name"][$i]))
		                        {
		                        	$un = uniqid();
		                        	$_FILES["userfile"]["name"][$i] = $un.".".$ext;
		                        }
		                        $path = 'upload/'.$_POST['type'].'/'.$id.'/articles/'.$_FILES['userfile']['name'][$i];

		                        move_uploaded_file($_FILES["userfile"]["tmp_name"][$i],
		                         $path);
		                         $this->user_model->save_upload($articleid,$_FILES['userfile']['name'][$i]);
		                    }
		                 }
					}
					
				}

				$this->email->from('info@myreposit.com', 'MyReposit Password reset');
                    $this->email->to('info@myreposit.com');
                    $this->email->subject('Article Verifivation Pending.');
                    $this->email->message('Hi admin '."\n"."\n"
                    .'You have a request for Article Verification on MyReposit.'
                    ."\n"."\n"
                    .'Here is Article details'
                    ."\n"
                    .'Article Title : '.$_POST['title']
                    ."\n"."\n"
                    .'MyReposit Team'
                    ."\n"
                    .'http://www.MyReposit.com'
                    ."\n"."\n"."\n"
                    .'This is an automatically generated email. Please do not reply'
                      );
                    $this->email->send();
                 echo $articleid;
			}
		}
		else 
		{
			redirect("welcome/login");
		}
	}

	public function save_other_article()
	{
		if($this->session->userdata('mpuserid'))
		{
			if($this->input->is_ajax_request())
			{
				$id = $this->session->userdata('mpuserid');
				$articleid = $this->user_model->save_user_other_article();
				$limit = sizeof($_FILES["userfile"]["error"]);
				//print_r($_FILES);die;
				if($limit > 0)
				{
					for ($i=0; $i < $limit; $i++) 
					{ 
						if ($_FILES["userfile"]["error"][$i] > 0)
		                    {
		                    }
		                  else
		                    {
		                    $_POST['type'] = 'user';
		                    $ext = end(explode('.', $_FILES["userfile"]["name"][$i])); 
		                    $un =  uniqid();
		                   $path = "upload/".$_POST['type']."/".$id;
		                    if(!is_dir($path)){
		                      mkdir($path);
		                    }
		                    $path = "upload/".$_POST['type']."/".$id."/articles";
		                    if(!is_dir($path)){
		                      mkdir($path);
		                    }
		                      /* new file name */
		                      if($_FILES["userfile"]["name"][$i] != "")
		                      {

		                      	$path_parts = pathinfo($_FILES['userfile']['name'][$i]);
								/* new file name */
								$file = $this->slugify($path_parts['filename']);
								$_FILES['userfile2']['name'][$i] = $file.".".$ext;
		                      	$path = 'upload/'.$_POST['type'].'/'.$id.'/articles/'.$_FILES['userfile']['name'][$i];
		                       if (file_exists('upload/'.$_POST['type'].'/'.$id.'/articles/'.$_FILES["userfile"]["name"][$i]))
		                        {
		                        	$un = uniqid();
		                        	$_FILES["userfile"]["name"][$i] = $un.".".$ext;
		                        }
		                        $path = 'upload/'.$_POST['type'].'/'.$id.'/articles/'.$_FILES['userfile']['name'][$i];

		                        move_uploaded_file($_FILES["userfile"]["tmp_name"][$i],
		                         $path);
		                         $this->user_model->save_upload($articleid,$_FILES['userfile']['name'][$i]);
		                    }
		                 }
					}
					
				}

				$this->email->from('info@myreposit.com', 'MyReposit Password reset');
                    $this->email->to('info@myreposit.com');
                    $this->email->subject('Article Verifivation Pending.');
                    $this->email->message('Hi admin '."\n"."\n"
                    .'You have a request for Article Verification on MyReposit.'
                    ."\n"."\n"
                    .'Here is Article details'
                    ."\n"
                    .'Article Title : '.$_POST['title']
                    ."\n"."\n"
                    .'MyReposit Team'
                    ."\n"
                    .'http://www.MyReposit.com'
                    ."\n"."\n"."\n"
                    .'This is an automatically generated email. Please do not reply'
                      );
                    $this->email->send();
                 echo $articleid;
			}
		}
		else 
		{
			redirect("welcome/login");
		}
	}

		public function activate_article($orderid)
	{

		include('Crypto.php');
		$workingKey='1D2C01585FC86FE7219EEA1BF229D5AE';		//Working Key should be provided here.
		$encResponse=$_POST["encResp"];			//This is the response sent by the CCAvenue Server
		$rcvdString=decrypt($encResponse,$workingKey);		//Crypto Decryption used as per the specified working key.
		$order_status="";
		$decryptValues=explode('&', $rcvdString);
		$dataSize=sizeof($decryptValues);
		echo "<center>";

		for($i = 0; $i < $dataSize; $i++) 
		{
			$information=explode('=',$decryptValues[$i]);

			if($i==1)	$tracking=$information[1];
			if($i==3)	$order_status=$information[1];
			if($i==10)	$amount=$information[1];
		}

		if($order_status==="Success")
		{
			$order = array(
			
			'transaction_id' 	=>$tracking, 
			'payment_status' 	=>$order_status,
			'payment' => $amount,
			//'status'  => '1'  
			);
			$this->user_model->update_article($order,$orderid);
			//echo "<br>Thank you for shopping with us. Your credit card has been charged and your transaction is successful. We will be shipping your order to you soon.";
			$this->session->set_flashdata('msg', 'Your article is being verified. Please check in 24 hours.');
			redirect('user');
			
		}
		else if($order_status==="Aborted")
		{
			$order = array(
			
			'transaction_id' 	=>$tracking, 
			'payment_status' 	=>$order_status,
			'payment' => $amount,
			//'status'  => '1'  
			);
			$this->user_model->update_article($order,$orderid);
			//echo "<br>Thank you for shopping with us.We will keep you posted regarding the status of your order through e-mail";
			$this->session->set_flashdata('msg', 'Your article is being verified. Please check in 24 hours.');
			redirect('user');
		
		}
		else if($order_status==="Failure")
		{
			$order = array(
			
			'transaction_id' 	=>$tracking, 
			'payment_status' 	=>$order_status,
			'payment' => $amount,
			//'status'  => '1'  
			);
			//$this->user_model->update_article($order,$orderid);
			//echo "<br>Thank you for shopping with us.However,the transaction has been declined.";
			$this->session->set_flashdata('msg', 'Your article is being verified. Please check in 24 hours.');
			redirect('user');
		}
		else
		{
			$this->session->set_flashdata('msg', 'Access Denied. Security Error');
			redirect('user');
		}
	}

	public function activate_published_article()
	{
		$order = array(
			
			'transaction_id' 	=>$_GET['tx'], 
			'payment_status' 	=>$_GET['st'],
			'payment' => $_GET['amt'],
			//'status'  => '1'  
			);
			$this->user_model->update_article($order,$_GET['cm']);
			$this->session->set_flashdata('msg', 'Your article is being verified. Please check in 24 hours.');
			redirect('user');
	}

	public function download_article($value='')
	{
		$order = array(
			
			'articleid' 	=>$_GET['cm'], 
			'userid' 	=> $this->session->userdata('mpuserid'),
			'downloadpayment' => $_GET['amt'],
			);
			$this->user_model->make_payment($order);

			$order1 = array(
			
			'articleid' 	=>$_GET['cm'], 
			'userid' 	=> $this->session->userdata('mpuserid'),
			'candownload' => 1,
			);
			$this->user_model->can_download($order1);
			redirect("user/view_article/".$_GET['cm']);
	}

	public function ifdownload_article($articleid='')
	{
		$stat = $this->user_model->ifcan_download($articleid);
		//print_r($stat);die;
		if($stat)
		{
			$article_info =  $this->user_model->get_article_info($articleid);
			
			$file= 'upload/user/'.$article_info->userid.'/articles/'.$article_info->document;
			if(file_exists($file)) 
			{
				$this->user_model->can_not_download($articleid);
	            header('Content-Description: File Transfer');
	            header('Content-Type: application/octet-stream');
	            header('Content-Disposition: attachment; filename='.basename($file));
	            header('Content-Transfer-Encoding: binary');
	            header('Expires: 0');
	            header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
	            header('Pragma: public');
	            header('Content-Length: ' . filesize($file));
	            ob_clean();
	            flush();
	            readfile($file);
	            //print_r($file);die;
	            $this->session->set_flashdata('msg', 'Thank You for downloading.');
	            redirect('user/view_article/'.$articleid);
        	}
        	$this->session->set_flashdata('msg', 'File is no longer available');
			redirect('user/view_article/'.$articleid);
		}
		else
		{
			$this->session->set_flashdata('msg', 'No permission to download this file.');
			redirect('user/view_article/'.$articleid);
		}

		 
	}

	public function remove_article()
	{
		$order = array(
			'payment_status' 	=> $_GET['st'],
			'payment' => $_GET['amt'],
			'status'  => '0'  
			);
			$this->user_model->update_article($order,$_GET['cm']);
			$this->session->set_flashdata('msg', 'Payment cancelled.');
			redirect('user');
	}

	public function user_articles($slug)
	{
		//$name = str_replace( "-"," ",$name);
		$offset=0;	
	  	//print_r($_POST);die;
	  	if($this->uri->segment(4))
          {
            $offset=$this->uri->segment(4);
          }

        $data['count']= $this->user_model->get_articles_count($slug);
	    $config['base_url'] = base_url().'index.php/user/user_articles/'.$slug."/";
	    $config['uri_segment'] = 4;
        $config['per_page']= 10;
        $config['total_rows'] = $data['count'];
        $this->pagination->initialize($config);
        $data['page_links']=$this->pagination->create_links();
        $data['active'] = 'e_portfolios';
        $data['uri'] = $this->uri->segment(4);
		$data['articles'] = $this->user_model->get_articles($slug,$config['per_page'],$offset);
		$data['user_info'] = $this->user_model->get_user_info($slug);
		$data['departments'] = $this->welcome_model->get_departments();
		$this->load->view('front/header',$data);
		$this->load->view('front/user_profile',$data);
		$this->load->view('front/sidebar',$data);
		$this->load->view('front/footer',$data);
	}


public function reprint($articleid)
	{
		$data['article_info'] =  $this->user_model->get_article_info($articleid);
		if($data['article_info'] )
		{
			$data['user_info'] = $this->user_model->get_user_info($data['article_info']->slug);
			$data['departments'] = $this->welcome_model->get_departments();
			$this->load->view('front/header',$data);
			$this->load->view('front/reprint-permission-request',$data);
			$this->load->view('front/footer',$data);
		}
		else
		{
			redirect("user");
		}
		
	}

public function view_user($slug)
	{
		$this->is_user();
		$data['user_info'] = $this->user_model->get_user_info($slug);
		if($data['user_info'] )
		{
			$data['departments'] = $this->welcome_model->get_departments();
			$this->load->view('front/header',$data);
			$this->load->view('front/view_user',$data);
			$this->load->view('front/footer',$data);
		}
		else
		{
			redirect("user");
		}
		
	}

public function community_articles($slug)
	{
		$this->is_user();
		$slug = str_replace( "-"," ",$slug);
		$offset=0;	
	  	//print_r($_POST);die;
	  	if($this->uri->segment(4))
          {
            $offset=$this->uri->segment(4);
          }

        $data['count']= $this->user_model->get_community_articles_count($slug);
	    $config['base_url'] = base_url().'index.php/user/community_articles/'.$slug."/";
	    $config['uri_segment'] = 4;
        $config['per_page']= 10;
        $config['total_rows'] = $data['count'];
        $this->pagination->initialize($config);
        $data['page_links']=$this->pagination->create_links();
        $data['active'] = 'e_portfolios';
        $data['uri'] = $this->uri->segment(4);
		$data['articles'] = $this->user_model->get_community_articles($slug,$config['per_page'],$offset);
		$data['departments'] = $this->welcome_model->get_departments();
		$this->load->view('front/header',$data);
		$this->load->view('front/e-portfolio',$data);
		$this->load->view('front/footer',$data);
	}


	public function other_articles($slug)
	{
		$this->is_user();
		$slug = urldecode($slug);
		$offset=0;	
	  	//print_r($_POST);die;
	  	if($this->uri->segment(4))
          {
            $offset=$this->uri->segment(4);
          }

        $data['count']= $this->user_model->get_other_articles_count($slug);
	    $config['base_url'] = base_url().'index.php/user/other_articles/'.$slug."/";
	    $config['uri_segment'] = 4;
        $config['per_page']= 10;
        $config['total_rows'] = $data['count'];
        $this->pagination->initialize($config);
        $data['page_links']=$this->pagination->create_links();
        $data['active'] = 'e_portfolios';
        $data['uri'] = $this->uri->segment(4);
		$data['articles'] = $this->user_model->get_other_articles($slug,$config['per_page'],$offset);
		$data['departments'] = $this->welcome_model->get_departments();
		$this->load->view('front/header',$data);
		$this->load->view('front/e-portfolio',$data);
		$this->load->view('front/footer',$data);
	}

	public function view_article($articleid)
	{
		$this->is_user();
		$data['article_info'] =  $this->user_model->get_article_info($articleid);
		$data['can_download'] = $this->user_model->ifcan_download($articleid);
		$data['similar_articles'] = $this->related_articles($data['article_info']->keyword);
		$data['departments'] = $this->welcome_model->get_departments();
		$this->load->view('front/header',$data);
		if($data['article_info']->worktype == "Published" || $data['article_info']->worktype == "Accepted" || $data['article_info']->worktype == "In Review")
		{
			
			$this->load->view('front/full-title',$data);
		}
		else
		{
			$this->load->view('front/full-title2',$data);
		}
		
		$this->load->view('front/footer',$data);
	}

	public function get_document_info($articleid)
	{
		$article_info =  $this->user_model->get_article_info($articleid);
		//echo "<h5 class='main-title'><b>".$article_info->title."</b><button type='button' class='close' data-dismiss='modal' aria-hidden='true'>&times;</button></h5> <hr>";
		echo '<div class="modal-header">
				<button type="button" onclick="hide_div(this)" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title">'.$article_info->title.'</h4>
			</div>';
		echo '<div class="modal-body">'.$article_info->description.'</div>';


	}

	public function get_metrics_info($articleid)
	{
		 $views = $this->user_model->get_article_views($articleid);
		$downlods = $this->user_model->get_downlods_count($articleid);

		print_r("<p><strong>No. of Downloads: ".$downlods."</strong><br><strong>Views: ".$views."</strong><br></p>");
	}

	public function get_similar_articles($articleid='')
	{
		$data['article_info'] =  $this->user_model->get_article_info($articleid);
		$similar_articles = $this->related_articles($data['article_info']->keyword);
		if($similar_articles == "")
		{
			print_r("No Similar Articles Found.");
		}
		else
		{
			echo $similar_articles;
		}
		
	}

	public function edit_profile()
	{
		$this->is_user();
		if($this->input->post('fname'))
		{
			$this->user_model->edit_profile($this->session->userdata('mpuserid'));
			$this->session->set_flashdata('msg', 'Your Profile Has been updated');
			//redirect("user");
		}
		if ($_FILES["userfile2"]["error"] > 0)
            {
            }
          else
            {
             $_POST['type'] = 'user';
             $id = $this->session->userdata('mpuserid');
             $ext = end(explode('.', $_FILES["userfile2"]["name"])); 
             $un =  uniqid();
             $path = "upload/".$_POST['type']."/".$id;
            	if(!is_dir($path)){
             	 mkdir($path);
            	}
              /* new file name */
              if($_FILES["userfile2"]["name"] != "")
              {
              	$path = 'upload/'.$_POST['type'].'/'.$id.'/'.$_FILES['userfile2']['name'];
               if (file_exists('upload/'.$_POST['type'].'/'.$id.'/'.$_FILES["userfile2"]["name"]))
                {
                 $un = uniqid();
                $_FILES["userfile2"]["name"] = $un.".".$ext;
                }
                 $path = 'upload/'.$_POST['type'].'/'.$id.'/'.$_FILES['userfile2']['name'];

                move_uploaded_file($_FILES["userfile2"]["tmp_name"],
                 $path);
                $this->welcome_model->change_profile_user($id,$_FILES["userfile2"]["name"]);    
                //$this->session->set_flashdata('msg', 'Thank you for creating your e-portfolio, you will receive an email when your e-portfolio is ready. This takes about 24 hours to complete.');
                //redirect('user');
            }
         }
         if($this->input->server('REQUEST_METHOD') == "POST") 
			  {
			  	redirect('edit-profile');
			  }
			$data['user_info'] = $this->user_model->get_user_detail($this->session->userdata('mpuserid'));
			$data['departments'] = $this->welcome_model->get_departments();
			$data['active'] = "edit-profile";
			$this->load->view('front/header',$data);
			$this->load->view('front/edit-profile',$data);
			$this->load->view('front/sidebar',$data);
			$this->load->view('front/footer',$data);
	}

	public function edit_bank_profile()
	{
		$this->is_user();
		if($this->input->post('benificiary_name'))
		{
			
			$this->user_model->edit_profile($this->session->userdata('mpuserid'));
			$this->session->set_flashdata('msg', 'Bank Profile updated');
			redirect("edit-bank-profile");
		}
		$data['user_info'] = $this->user_model->get_user_detail($this->session->userdata('mpuserid'));
		$data['departments'] = $this->welcome_model->get_departments();
		$data['active'] = "edit-bank-profile";
		$this->load->view('front/header',$data);
		$this->load->view('front/edit-bank-profile',$data);
		$this->load->view('front/sidebar',$data);
		$this->load->view('front/footer',$data);
	}

	public function change_password()
	{
		
			$data['active'] = "change-password";
			$data['departments'] = $this->welcome_model->get_departments();
			$this->load->view('front/header',$data);
			$this->load->view('front/change-password',$data);
			$this->load->view('front/sidebar',$data);
			$this->load->view('front/footer',$data);
		
	}

	public function get_password()
	{
		if($this->session->userdata('mpuseremail'))	
		{  
			$old = $this->user_model->get_password($this->session->userdata('mpuseremail'));
			if($old[0]['password'] == md5($_GET['pass']))
			{
				echo "1";
			}
			else
			{
				echo "0";
			}

		}	
	}

	public function update_password()
	{
		if($this->session->userdata('mpuseremail'))	
		{  
	        $form_data = $_POST;
			$this->user_model->update_password($form_data,$this->session->userdata('mpuseremail'));
			$this->session->set_flashdata('msg', 'Your password has been updated');
		}	
			
	}

	public function downloaded_articles($value='')
	{
		if($this->session->userdata('mpuserid'))
		{
			$offset=0;	
		  	//print_r($_POST);die;
		  	if($this->uri->segment(3))
	          {
	            $offset=$this->uri->segment(3);
	          }
            $data['count']= $this->user_model->get_user_articles_count();
		    $config['base_url'] = base_url().'index.php/user/downloaded_articles/';
		    $config['uri_segment'] = 3;
            $config['per_page']= 10;
            $config['total_rows'] = $data['count'];
            $this->pagination->initialize($config);
	        $data['page_links']=$this->pagination->create_links();
	        $data['active'] = 'downloaded';
			$data['userarticles'] = $this->user_model->get_user_articles($config['per_page'],$offset);
			$data['departments'] = $this->welcome_model->get_departments();
			$this->load->view('front/header',$data);
			$this->load->view('front/my-work-downloaded',$data);
			$this->load->view('front/sidebar',$data);
			$this->load->view('front/footer',$data);
		}
		else 
		{
			redirect("welcome/login");
		}
	}


	public function purchased_articles()
	{
		if($this->session->userdata('mpuserid'))
		{
			$offset=0;	
		  	//print_r($_POST);die;
		  	if($this->uri->segment(3))
	          {
	            $offset=$this->uri->segment(3);
	          }
            $data['count']= $this->user_model->get_purchased_articles_count();
		    $config['base_url'] = base_url().'index.php/user/purchased_articles/';
		    $config['uri_segment'] = 3;
            $config['per_page']= 10;
            $config['total_rows'] = $data['count'];
            $this->pagination->initialize($config);
	        $data['page_links']=$this->pagination->create_links();
	        $data['active'] = 'purchased';
			$data['userarticles'] = $this->user_model->get_purchased_articles($config['per_page'],$offset);
			$data['departments'] = $this->welcome_model->get_departments();
			$this->load->view('front/header',$data);
			$this->load->view('front/purchased',$data);
			$this->load->view('front/sidebar',$data);
			$this->load->view('front/footer',$data);
		}
		else 
		{
			redirect("welcome/login");
		}
	}

	public function posted_articles($value='')
	{
		if($this->session->userdata('mpuserid'))
		{
			$offset=0;	
		  	//print_r($_POST);die;
		  	if($this->uri->segment(3))
	          {
	            $offset=$this->uri->segment(3);
	          }
            $data['count']= $this->user_model->get_user_articles_count();
		    $config['base_url'] = base_url().'index.php/user/posted_articles/';
		    $config['uri_segment'] = 3;
            $config['per_page']= 10;
            $config['total_rows'] = $data['count'];
            $this->pagination->initialize($config);
	        $data['page_links']=$this->pagination->create_links();
	        $data['active'] = 'my_account';
            //$data['uri'] = $name1;
			$data['userarticles'] = $this->user_model->get_user_articles($config['per_page'],$offset);
			$data['departments'] = $this->welcome_model->get_departments();
			$this->load->view('front/header',$data);
			$this->load->view('front/posted',$data);
			$this->load->view('front/footer',$data);
		}
		else 
		{
			redirect("welcome/login");
		}
	}


	public function saved_articles($value='')
	{
		if($this->session->userdata('mpuserid'))
		{
			$offset=0;	
		  	//print_r($_POST);die;
		  	if($this->uri->segment(3))
	          {
	            $offset=$this->uri->segment(3);
	          }
            $data['count']= $this->user_model->get_user_saved_articles_count();
		    $config['base_url'] = base_url().'index.php/user/saved_articles/';
		    $config['uri_segment'] = 3;
            $config['per_page']= 10;
            $config['total_rows'] = $data['count'];
            $this->pagination->initialize($config);
	        $data['page_links']=$this->pagination->create_links();
	        $data['active'] = 'saved';
            //$data['uri'] = $name1;
			$data['userarticles'] = $this->user_model->get_user_saved_articles($config['per_page'],$offset);
			$data['departments'] = $this->welcome_model->get_departments();
			$this->load->view('front/header',$data);
			$this->load->view('front/saved',$data);
			$this->load->view('front/sidebar',$data);
			$this->load->view('front/footer',$data);
		}
		else 
		{
			redirect("welcome/login");
		}
	}


static public function slugify($text)
{ 
  // replace non letter or digits by -
  $text = preg_replace('~[^\\pL\d]+~u', '-', $text);

  // trim
  $text = trim($text, '-');

  // transliterate
  $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);

  // lowercase
  $text = strtolower($text);

  // remove unwanted characters
  $text = preg_replace('~[^-\w]+~', '', $text);

  if (empty($text))
  {
    return 'n-a';
  }

  return $text;
}

public function reprint_article()
{
	if($this->session->userdata('mpuserid'))
		{
			$id = $this->user_model->reprint_article_request();
			print_r($id);
		}
		else 
		{
			redirect("welcome/login");
		}
}

public function activate_reprint_article($value='')
{
	$order = array(
			
			'transaction_id' 	=>$_GET['tx'], 
			'payment_status' 	=>$_GET['st'],
			'payment' => $_GET['amt'],
			//'status'  => '1'  
			);
	$this->user_model->activate_reprint_article($order,$_GET['cm']);
	$this->session->set_flashdata('msg', 'Payment received.Your request is being verified. Please Check in 24 hours.');
	redirect('user/licence/'.$_GET['tx']);
}


public function cancle_reprint_article()
{
	$order = array(
			
			'transaction_id' 	=>$_GET['tx'], 
			'payment_status' 	=>$_GET['st'],
			'payment' => $_GET['amt'],
			//'status'  => '1'  
			);
	$this->user_model->cancle_reprint_article($order,$_GET['cm']);
	$this->session->set_flashdata('msg', 'Transaction Cancelled. Please try again.');
	redirect('user/');
}

public function licence($tid)
	{
		$this->is_user();
		$data['licence_info'] = $this->user_model->get_licence_info($tid);
		//print_r($data);
		$data['departments'] = $this->welcome_model->get_departments();
		$this->load->view('front/header',$data);
		$this->load->view('front/license',$data);
		$this->load->view('front/footer',$data);
	}

function get_article_likes($articleid='')
{
	if($this->input->is_ajax_request())
	{
		$likes_count = $this->user_model->get_article_likes($articleid);
		print $likes_count;
	}
	
}
function get_article_views($articleid='')
{
	if($this->input->is_ajax_request())
	{
		$views_count = $this->user_model->get_article_views($articleid);
		print $views_count;
	}
	
}

public function save_article_wishlist($articleid)
{
	if($this->session->userdata('mpuserid'))
		{
			$stat = $this->user_model->save_article($articleid);
			print $stat;
		}
		else 
		{
			print("login");
		}
}

function insert_like($articleid='')
{
	if($this->input->is_ajax_request())
	{
		$likes_count = $this->user_model->insert_like($articleid);
		print $likes_count;
	}
	
}

public function post_query($articleid='')
{
	$this->is_user();
	$data['article_info'] =  $this->user_model->get_article_info($articleid);
	$this->email->from('info@myreposit.com', 'MyReposit Admin');
    $this->email->to($data['article_info']->authoremail);
    $this->email->subject('MyReposit Article Query');
    $this->email->message('Hi '."\n"."\n"
    .'A New Query on the MyReposit regarding Your article.'
    ."\n"."\n"
    .'Please see follow details of user.'
    ."\n"
    .'Name: '.$this->session->userdata('mpusername')
    .'User Email Id: '.$this->session->userdata('mpusername')
   
    .'Query : '.$_POST['query']
    ."\n"
    .'MyReposit Team'
    ."\n"."\n"."\n"
    .'This is an automatically generated email. Please do not reply'
      );
    $this->email->send();
   $this->session->set_flashdata('msg', "Thank you for query. We will get back to you soon.");
   redirect('user/view_article/'.$articleid);
}

public function check_promo($promo_code='')
{
	$promo_code = $this->input->get('code');
	$stat = $this->user_model->check_promo_code($promo_code);
	echo $stat;
}


public function related_articles($keyword)
{
	$doi = $_GET['doi'];
	$url = "http://www.ebi.ac.uk/europepmc/webservices/rest/search/query=".urlencode($keyword)."%20sort_date:y"; 
	//$url = "http://www.ebi.ac.uk/europepmc/webservices/rest/search/query=Neisseria gonorrhoeae, Molecular Beacon.%20sort_date:y";
	//print_r($url);
	// create curl resource
        $ch = curl_init();

        // set url
        curl_setopt($ch, CURLOPT_URL, $url);

        //return the transfer as a string
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
//echo "<pre>";
        // $output contains the output string
        $output = curl_exec($ch);
        //$data = json_decode($output);
        $xml = simplexml_load_string($output);
$json = json_encode($xml);
$array = json_decode($json);//print_r($array);
       //print_r($json);echo '</pre>'; 
  // die;
       $resp = "";
        
        	//echo"<pre>";print_r($data);die;
        		$i =1;
        		foreach ($array->resultList->result as $key) 
        		{
        			//if($i < 9)
        			$resp .= "<li><a target = '_blank' href='http://dx.doi.org/".$key->DOI."'>".$key->title."</a></li>";
        			$i++;
        		}
        	
       //print_r($resp);die;
        
        // close curl resource to free up system resources
        curl_close($ch);
        if($this->input->is_ajax_request())
        {
        	//$resp = "<h3 class = 'main-title'>Similar Articles </h3> <hr><ol>".$resp."</ol>";
        	$resp = '<div class="modal-header">
				<button type="button" onclick="hide_div(this)" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title">Similar Articles</h4>
			</div><div class="modal-body"><ol>'.$resp.'</ol></div>';
        	return $resp;

        }
        else{
        	return $resp ;
        } 
       
}


public function get_comments($articleid='',$div_id)
{
	$comments = $this->user_model->get_comments($articleid);
    $re = " ";
    if(sizeof($comments))
    {
    	foreach ($comments as $key) 
		{
			$re .= '<li class="list-group-item">
	    <div class="row">
	      <div class="col-xs-4 col-md-2">
	      <img style="width:45px;height:45px;" src="'.base_url().'upload/user/'.$key->userid.'/'.$key->profilepic.'"  onerror=" this.src = \''.base_url().'assets/front/images/doctor.png\'" class=" img-responsive" alt="" /></div>
	      <div class="col-xs-8 col-md-10">
	        <div>
	          <div class="comment-text">
	            '.$key->message.'
	          </div>
	          <div class="mic-info">
	            <i class="fa fa-user"></i> '.$key->user_name.' <i class="fa fa-clock-o"></i> '.date("F j, Y, g:i A", strtotime($key->date)).'
	          </div>
	        </div>
	        
	        
	      </div>
	    </div>
	  </li>';
		}
		if($this->session->userdata('mpuserid'))
		{
			$add_btn = "<a type='button' onclick = 'add_comment(".$articleid.")' data-toggle='modal' href='#add_comment' class='btn btn-sm btn-default pull-right'>Add</a>";
		}
		else
		{
			$add_btn = "<a  class='btn btn-sm btn-default pull-right' href=".base_url()."login>Add</a>";
		}

		$resp = "<div class='row'><h4 class = 'main-title col-lg-6'>Recent Comments </h4> ".$add_btn."</div><ul class='nav list-group'>".$re."</ul>";
    }
    else
    {
		$resp = "<div class='' style='border:none;'><button type='button' onclick='hide_div(this)' class='close' data-dismiss='modal' aria-hidden='true'>&times;</button><span>No comments. </span></div>";

    }
	
    print $resp;
}


public function add_new_comment()
{
	$this->is_user();
	$this->user_model->add_new_comment();
	redirect('articles');
}


}

/* End of file user.php */
/* Location: ./application/controllers/user.php */
