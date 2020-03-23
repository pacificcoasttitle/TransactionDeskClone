<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
//print_r($_SESSION);
   

date_default_timezone_set('Asia/Kolkata');

class Welcome extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -  
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in 
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see http://codeigniter.com/user_guide/general/urls.html
	 */

	public function __construct()
	{
		parent::__construct();
		$this->load->helper('url');
		 if(!isset($_SESSION)) 
    { 
      $this->load->library('session');
        session_start(); 
    } 
		$this->load->library('pagination');
		$this->load->library('email');
		$this->load->model('welcome_model');
		$this->load->model('user_model');
	}
	public function is_user($url)
	{
		if($this->session->userdata('mpuserid'))
		{
			
		}
		else 
		{
			redirect("welcome/login?return=".$url);
		}
	}


  public function index()
  {
    
    $data['active'] = 'homepage';
    $data['departments'] = $this->welcome_model->get_departments();
    
    $this->load->view('front/header',$data);
    $this->load->view('front/index',$data);
    $this->load->view('front/sidebar',$data);
    $this->load->view('front/footer',$data);
  }

	public function index1($offset='')
	{
		$data['departments'] = $this->welcome_model->get_departments();
		$offset=0;	
	  	//print_r($_POST);die;
	  	if($this->uri->segment(2))
          {
            $offset=$this->uri->segment(2);
          }
          if($this->input->server('REQUEST_METHOD') == "POST") 
           {
           	   $this->session->set_userdata('find_array',$_POST);
           	   $find = $_POST;
           }
           else
           {
           		$find = $this->session->userdata('find_array');
           }
           if(empty($find))
	           {
	           		$find = array('order_by' =>'date_created,DESC' ,'per_page'=>'10' );
	           		
	           }
        $data['count']= $this->user_model->get_articles_count("");
	    $config['base_url'] = base_url().'index.php/welcome/index1/';
	    $config['uri_segment'] = 2;
        $config['per_page']= $find['per_page'];
        $config['total_rows'] = $data['count'];
        $this->pagination->initialize($config);
        $data['page_links']=$this->pagination->create_links();
        $data['active'] = 'article';
        $data['find_array'] = $find;
        $data['uri'] = $this->uri->segment(2);
           
		$data['articles'] = $this->user_model->get_recent_articles($find,$config['per_page'],$offset);
		$data['departments'] = $this->welcome_model->get_departments();
		$this->load->view('front/header',$data);
		$this->load->view('front/inner',$data);
		$this->load->view('front/sidebar',$data);
		$this->load->view('front/footer',$data);
	}

	public function login()
	{
		//print_r($this->session->userdata);die;
		if($this->session->userdata('mpuserid'))
		{
			redirect("/");
		}
    $data['active'] = 'login';
		$this->load->view('front/header',$data);
    $this->load->view('front/login',$data);
		$this->load->view('front/sidebar',$data);
		$this->load->view('front/footer',$data);
	}

public function google_login($url="")
{
    ########## Google Settings.. Client ID, Client Secret from https://cloud.google.com/console #############
    $google_client_id 		= '232220596024-i6j493ojburn2vknqbk7054namsbiufv.apps.googleusercontent.com';
	$google_client_secret 	= 'Alk7RlpFNE6mNtnHjj5aqjch';
	$google_redirect_url 	= base_url().'index.php/welcome/google_login'; //path to your script
	$google_developer_key 	= 'AIzaSyAOys7RDC-LqryGANXjVU-efGHfB230jFc';

    //include google api files
    require_once 'src/Google_Client.php';
    require_once 'src/contrib/Google_Oauth2Service.php';

    //start session
    session_start();

    $gClient = new Google_Client();
    $gClient->setApplicationName('Aurasoft');
    $gClient->setClientId($google_client_id);
    $gClient->setClientSecret($google_client_secret);
    $gClient->setRedirectUri($google_redirect_url);
    $gClient->setDeveloperKey($google_developer_key);

    $google_oauthV2 = new Google_Oauth2Service($gClient);

    //If user wish to log out, we just unset Session variable
    if (isset($_REQUEST['reset'])) 
    {
      unset($_SESSION['token']);
      $gClient->revokeToken();
      header('Location: ' . filter_var($google_redirect_url, FILTER_SANITIZE_URL)); //redirect user back to page
    }

    //If code is empty, redirect user to google authentication page for code.
    //Code is required to aquire Access Token from google
    //Once we have access token, assign token to session variable
    //and we can redirect user back to page and login.
    if (isset($_GET['code'])) 
    { 
        $gClient->authenticate($_GET['code']);
        $_SESSION['token'] = $gClient->getAccessToken();
        header('Location: ' . filter_var($google_redirect_url, FILTER_SANITIZE_URL));
        return;
    }


    if (isset($_SESSION['token'])) 
    { 
        $gClient->setAccessToken($_SESSION['token']);
    }


    if ($gClient->getAccessToken()) 
    {
          //For logged in user, get details from google using access token
          $user                 = $google_oauthV2->userinfo->get();
          $user_id              = $user['id'];
          $first_name           = filter_var($user['given_name'], FILTER_SANITIZE_SPECIAL_CHARS);
          $user_profile['last_name']            = filter_var($user['family_name'], FILTER_SANITIZE_SPECIAL_CHARS);
          $profile_pic          = filter_var($user['picture'], FILTER_SANITIZE_SPECIAL_CHARS);
          $email                = filter_var($user['email'], FILTER_SANITIZE_EMAIL);
          $_SESSION['token']    = $gClient->getAccessToken();
          //print_r($user);die;
       $query = "select * from user where email='".$email."'";
                $requery=  mysql_query($query);
                $check_mailid_res = mysql_num_rows($requery);

            if($check_mailid_res)
            {
                $rows=mysql_fetch_array($requery);
                $query1="Update user set google_id='".$user_id."' where id='".$rows['userid']."' ";
                mysql_query($query1);
                if($rows['status'] == '1')
                {
                	$this->session->set_userdata('mpuserid',$rows['userid']);
                	$this->session->set_userdata('mpusername',$rows['fname']." ".$rows['lname']);
                	$this->session->set_userdata('mpuseremail',$rows['email']);
                	$this->session->set_userdata('google_login','1');
                }
                else
                {
                	$this->session->set_flashdata('msg', "Your account will be created shortly.");
                }
                
                if($rows['profile_pic'] == "" && $userfile != "https://lh3.googleusercontent.com/-XdUIqdMkCWA/AAAAAAAAAAI/AAAAAAAAAAA/4252rscbv5M/photo.jpg")
                {
		             $id = $this->session->userdata('mpuserid');
		             $ext = "jpg"; 
		             $un =  uniqid();
		             $path = "upload/user/".$id;
		            	if(!is_dir($path)){
		             	 mkdir($path);
		            	}
		             
		              	
		                 $un = uniqid();
		                 $userfile = $rows['fname']."_".$un.".".$ext;
		                 $path = 'upload/user/'.$id.'/'.$userfile;
		                copy($profile_pic,$path);
		                $this->welcome_model->change_profile_user($id,$userfile);    
		                
                }

                redirect($_GET['url']);
            }
            else
            {
            	$slug = "Mr. ".$first_name." ".$last_name;
          	    $slug = $this->slugify($slug);
          	    $pass = strtoupper(substr($first_name, 0,3))."".strtolower(substr($first_name, 0,3)).date('his');
          	    $verify = uniqid();
                    $query = "INSERT INTO user (salutation,fname,lname,google_id,email,slug,verification,password) VALUES ('Mr.','".$first_name."', '".$last_name."',  '".$userid."','".$email."','".$slug."','".$verify."','".md5($pass)."')";
                    mysql_query($query);
                    $last_insert_id = mysql_insert_id();
                    $new_query=mysql_query("select * from user where userid='".$last_insert_id."'");
                    $new_rows=mysql_fetch_array($new_query);
                    
                    $id = $last_insert_id;
		             $ext = "jpg"; 
		             $un =  uniqid();
		             $path = "upload/user/".$id;
		            	if(!is_dir($path)){
		             	 mkdir($path);
		            	}
		             
		              	if($userfile != "https://lh3.googleusercontent.com/-XdUIqdMkCWA/AAAAAAAAAAI/AAAAAAAAAAA/4252rscbv5M/photo.jpg")
		              	{
		              		 $un = uniqid();
			                 $userfile = $rows['fname']."_".$un.".".$ext;
			                 $path = 'upload/user/'.$id.'/'.$userfile;
			                copy($profile_pic,$path);
			                $this->welcome_model->change_profile_user($id,$userfile);
		              	}
		                 
                    $this->foo_verify($last_insert_id,$verify,$pass);
            }

    
    
    }
    else 
    {
        //For Guest user, get google login url
        $authUrl = $gClient->createAuthUrl();
        redirect($authUrl);
    }
}


 ////////////////////////////// ************* FB LOGIN **************** //////////////////

     public function fblogin($url="")
    {
                

        include('facebook.php');
        //print_r($_GET['url']);die;
        // Create our Application instance (replace this with your appId and secret).
        $facebook = new Facebook(array(
                'appId' => '1612034105702899',
                'secret'=> 'b6d91a534efe674d6ae3799953d0917c'
        ));

        $user = $facebook->getUser();
//print_r($user);
        if ($user)
         {
            try {
                $user_profile = $facebook->api('/me');
            }
            catch (FacebookApiException $e) {
                error_log($e);
                $user = null;
            }
        }
        
                
        if($user)
        {
            $logoutUrl = $facebook->getLogoutUrl();
              $query = "select * from user where email='".$user_profile['email']."'";
                $requery=  mysql_query($query);
                $check_mailid_res = mysql_num_rows($requery);

            if($check_mailid_res)
            {
                $rows=mysql_fetch_array($requery);
                 $query1="Update user set fb_id='".$user_profile['id']."' where userid='".$rows['userid']."' ";
                 mysql_query($query1);
               if($rows['status'] == '1')
                {
                	$this->session->set_userdata('mpuserid',$rows['userid']);
                	$this->session->set_userdata('mpusername',$rows['fname']." ".$rows['lname']);
                	$this->session->set_userdata('mpuseremail',$rows['email']);
                    $this->session->set_userdata('facebook_login','fb');
                  }
                else
                {
                	$this->session->set_flashdata('msg', "Your account will be created shortly.");
                }
                redirect($_GET['url']);
            }
            else
            {
            	$slug = "Mr. ".$user_profile['first_name']." ".$user_profile['last_name'];
          	    $slug = $this->slugify($slug);
          	    $pass = strtoupper(substr($user_profile['first_name'], 0,3))."".strtolower(substr($user_profile['first_name'], 0,3)).date('his');
          	    $verify = uniqid();
                    $query = "INSERT INTO user (salutation,fname,lname,fb_id,email,slug,verification,password) VALUES ('Mr.', '".$user_profile['first_name']."', '".$user_profile['last_name']."',  '".$user_profile['id']."','".$user_profile['email']."','".$slug."','".$verify."','".md5($pass)."')";
                    mysql_query($query);
                    $last_insert_id = mysql_insert_id();
                    $id = $last_insert_id;
                        //print_r("select * from user where id='".$last_insert_id."'");
                  $profile_pic = "https://graph.facebook.com/".$user_profile['id']."/picture?type=large";
                    $ext = "jpg"; 
                 $un =  uniqid();
                 $path = "upload/user/".$id;
                  if(!is_dir($path)){
                   mkdir($path);
                  }
                 
                    
                       $un = uniqid();
                       $userfile = $user_profile['first_name']."_".$un.".".$ext;
                       $path = 'upload/user/'.$id.'/'.$userfile;
                      copy($profile_pic,$path);
                      $this->welcome_model->change_profile_user($id,$userfile);
                    
                   $this->foo_verify($last_insert_id,$verify,$pass);
            }
           

        }
        else
        {
            $logoutUrl = $facebook->getLoginUrl(array(
                    'scope' => 'email,user_birthday'
            ));
            redirect($logoutUrl);
        }
    }




	public function about_repository()
	{
		$this->is_user();
		$data['page_content'] = $this->welcome_model->get_content('about_erp');
    $data['departments'] = $this->welcome_model->get_departments();
    $data['active'] = 'about';
		$this->load->view('front/header',$data);
		$this->load->view('front/about_repository',$data);
		$this->load->view('front/footer',$data);
	}
	

	public function about_e_portfolio()
	{
		//$this->is_user();
		$data['page_content'] = $this->welcome_model->get_content('eportfolio');
    $data['departments'] = $this->welcome_model->get_departments();
    $data['active'] = 'about';
		$this->load->view('front/header',$data);
		$this->load->view('front/about_e_portfolio',$data);
    $this->load->view('front/sidebar',$data); 
		$this->load->view('front/footer',$data);
	}

  public function deposit_manage_content()
  {
    //$this->is_user();
    $data['page_content'] = $this->welcome_model->get_content('eportfolio');
    $data['departments'] = $this->welcome_model->get_departments();
    $data['active'] = 'deposit_manage_content';
    $this->load->view('front/header',$data);
    $this->load->view('front/deposit_manage_content',$data);
    $this->load->view('front/sidebar',$data); 
    $this->load->view('front/footer',$data);
  }

public function independent_peer_review()
  {
    //$this->is_user();
    $data['page_content'] = $this->welcome_model->get_content('eportfolio');
    $data['departments'] = $this->welcome_model->get_departments();
    $data['active'] = 'independent_peer_review';
    $this->load->view('front/header',$data);
    $this->load->view('front/independent_peer_review',$data);
    $this->load->view('front/sidebar',$data); 
    $this->load->view('front/footer',$data);
  }

public function become_reviewer()
  {
    //$this->is_user();
    $data['page_content'] = $this->welcome_model->get_content('eportfolio');
    $data['departments'] = $this->welcome_model->get_departments();
    $data['countries'] = $this->welcome_model->get_countries();
    $data['user_info'] = $this->user_model->get_user_detail($this->session->userdata('mpuserid'));
    $data['active'] = 'become_reviewer';
    $this->load->view('front/header',$data);
    $this->load->view('front/become_reviewer',$data);
    $this->load->view('front/sidebar',$data); 
    $this->load->view('front/footer',$data);
  }

  public function become_reviewer_apply()
  {
    $this->is_user('become-reviewer');
    if($this->input->post('fname'))
      {
        $this->user_model->edit_profile($this->session->userdata('mpuserid'));
        //$this->session->set_flashdata('msg', 'Your Profile Has been updated');
        //redirect("user");
      }
      
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
                       // $this->session->set_flashdata('msg', 'Thank you for creating your Profile, you will be notified as soon as your Profile is ready. This takes about 24 hours to complete.');
                        //redirect('user');
                    }
                 }
    $id  = $this->welcome_model->become_reviewer_apply();
    if($id)
    {
      $this->session->set_flashdata('msg', 'Thanks for submission of become reviewer request.');
      redirect('become-reviewer','refresh');
    }
    else
    {
       $this->session->set_flashdata('msg', 'You have already applied for become reviewer.');
       redirect('become-reviewer');
    }
    
  }

public function publish_sell()
  {
    //$this->is_user();
    $data['page_content'] = $this->welcome_model->get_content('eportfolio');
    $data['departments'] = $this->welcome_model->get_departments();
    $data['user_info'] = $this->user_model->get_user_info($this->session->userdata('mpuserslug'));
    $data['active'] = 'publish_sell';
    $this->load->view('front/header',$data);
    $this->load->view('front/publish_sell',$data);
    $this->load->view('front/sidebar',$data); 
    $this->load->view('front/footer',$data);
  }
  
public function manuscript_development()
  {
    //$this->is_user();
    $data['page_content'] = $this->welcome_model->get_content('eportfolio');
    $data['departments'] = $this->welcome_model->get_departments();
    $data['active'] = 'manuscript_development';
    $this->load->view('front/header',$data);
    $this->load->view('front/manuscript_development',$data);
    $this->load->view('front/sidebar',$data); 
    $this->load->view('front/footer',$data);
  }

public function editing()
  {
    session_start();
   // print_r($_SESSION);
    $this->is_user('editing');
    $this->remove_temporary_files("server/php/files/".$this->session->userdata('mpuserid')."/");
    $data['page_content'] = $this->welcome_model->get_content('eportfolio');
    $data['departments'] = $this->welcome_model->get_departments();
    $data['active'] = 'editing';
    $this->load->view('front/header',$data);
    $this->load->view('front/editing',$data);
    $this->load->view('front/sidebar',$data); 
    $this->load->view('front/footer',$data);
  }

  
public function remove_temporary_files( $str) 
{
    if (is_file($str)) {
        return @unlink($str);
    }
    elseif (is_dir($str)) {
        $scan = glob(rtrim($str,'/').'/*');
        foreach($scan as $index=>$path) {
            $this->remove_temporary_files($path);
        }
        return @rmdir($str);
    }

  }

public function translation()
  {
    //$this->is_user();
    $this->is_user('translation');
    $this->remove_temporary_files("server/php/files/".$this->session->userdata('mpuserid')."/");
    $data['page_content'] = $this->welcome_model->get_content('eportfolio');
    $data['departments'] = $this->welcome_model->get_departments();
    $data['active'] = 'translation';
    $this->load->view('front/header',$data);
    $this->load->view('front/translation',$data);
    $this->load->view('front/sidebar',$data); 
    $this->load->view('front/footer',$data);
  }

  public function formatting()
  {
    $this->is_user('formatting');
    $this->remove_temporary_files("server/php/files/".$this->session->userdata('mpuserid')."/");
    $data['page_content'] = $this->welcome_model->get_content('eportfolio');
    $data['departments'] = $this->welcome_model->get_departments();
    $data['active'] = 'formatting';
    $this->load->view('front/header',$data);
    $this->load->view('front/formatting',$data);
    $this->load->view('front/sidebar',$data); 
    $this->load->view('front/footer',$data);
  }

 public function figure_prep()
  {
    $this->is_user('figure_prep');
    $data['page_content'] = $this->welcome_model->get_content('eportfolio');
    $data['departments'] = $this->welcome_model->get_departments();
    $data['active'] = 'figure_prep';
    $this->load->view('front/header',$data);
    $this->load->view('front/figure_prep',$data);
    $this->load->view('front/sidebar',$data); 
    $this->load->view('front/footer',$data);
  }

 public function charges()
  {
    //$this->is_user();
    $data['page_content'] = $this->welcome_model->get_content('eportfolio');
    $data['departments'] = $this->welcome_model->get_departments();
    $data['active'] = 'charges';
    $this->load->view('front/header',$data);
    $this->load->view('front/charges',$data);
    $this->load->view('front/sidebar',$data); 
    $this->load->view('front/footer',$data);
  }

	public function data_protection()
	{
		//$this->is_user();
    $data['page_content'] = $this->welcome_model->get_content('data_protection');
    $data['departments'] = $this->welcome_model->get_departments();
		$this->load->view('front/header',$data);
    $this->load->view('front/data_protection',$data);
    $this->load->view('front/sidebar',$data);
		$this->load->view('front/footer',$data);
	}

	public function terms_of_services()
	{
		//$this->is_user();
		$data['page_content'] = $this->welcome_model->get_content('terms');
    $data['departments'] = $this->welcome_model->get_departments();
		$this->load->view('front/header',$data);
		$this->load->view('front/terms_of_services',$data);
		$this->load->view('front/sidebar',$data);

		$this->load->view('front/footer',$data);
	}

	public function faq()
	{
		//$this->is_user();
		$offset=0;	
	  	//print_r($_POST);die;
	  	if($this->uri->segment(3))
          {
            $offset=$this->uri->segment(3);
          }

        $data['count']= $this->welcome_model->get_faqs_count();
	    $config['base_url'] = base_url().'index.php/welcome/faq/';
	    $config['uri_segment'] = 3;
        $config['per_page']= 10;
        $config['total_rows'] = $data['count'];
        $this->pagination->initialize($config);
        $data['page_links']=$this->pagination->create_links();
        $data['active'] = 'faqs';
        $data['uri'] = $this->uri->segment(3);
		$data['faqs'] = $this->welcome_model->get_faqs($config['per_page'],$offset);
		$this->load->view('front/header',$data);
    $this->load->view('front/faq',$data);
		$this->load->view('front/sidebar',$data);
		$this->load->view('front/footer',$data);
	}

public function books()
	{
		$data['departments'] = $this->welcome_model->get_departments();
    $offset=0;  
      //print_r($_POST);die;
      if($this->uri->segment(2))
          {
            $offset=$this->uri->segment(2);
          }
          if($this->input->server('REQUEST_METHOD') == "POST") 
           {
               $this->session->set_userdata('find_array',$_POST);
               $find = $_POST;
           }
           else
           {
              $find = $this->session->userdata('find_array');
           }
           if(empty($find))
             {
                $find = array('order_by' =>'date_created,DESC' ,'per_page'=>'10' );
                
             }
        $data['count']= $this->welcome_model->get_books_count("");
      $config['base_url'] = base_url().'index.php/welcome/index1/';
      $config['uri_segment'] = 2;
        $config['per_page']= $find['per_page'];
        $config['total_rows'] = $data['count'];
        $this->pagination->initialize($config);
        $data['page_links']=$this->pagination->create_links();
        $data['active'] = 'article';
        $data['find_array'] = $find;
        $data['uri'] = $this->uri->segment(2);
           
    $data['books'] = $this->welcome_model->get_books($find,$config['per_page'],$offset);
    $data['departments'] = $this->welcome_model->get_departments();
    $this->load->view('front/header',$data);
    $this->load->view('front/books',$data);
    $this->load->view('front/sidebar',$data);
    $this->load->view('front/footer',$data);
	}




public function events()
	{
		$this->is_user('events');
		$offset=0;	
	  	//print_r($_POST);die;
	  	if($this->uri->segment(3))
          {
            $offset=$this->uri->segment(3);
          }

        $data['count']= $this->welcome_model->get_events_count();
	    $config['base_url'] = base_url().'index.php/welcome/events/';
	    $config['uri_segment'] = 3;
        $config['per_page']= 12;
        $config['total_rows'] = $data['count'];
        $this->pagination->initialize($config);
        $data['page_links']=$this->pagination->create_links();
        $data['active'] = 'events';
        $data['uri'] = $this->uri->segment(3);
		$data['events'] = $this->welcome_model->get_events($config['per_page'],$offset);
		$this->load->view('front/header',$data);
		$this->load->view('front/events',$data);
		$this->load->view('front/footer',$data);
	}

	public function ngos()
	{
		$this->is_user('ngos');
		$offset=0;	
	  	//print_r($_POST);die;
	  	if($this->uri->segment(3))
          {
            $offset=$this->uri->segment(3);
          }

        $data['count']= $this->welcome_model->get_ngos_count();
	    $config['base_url'] = base_url().'index.php/welcome/ngos/';
	    $config['uri_segment'] = 3;
        $config['per_page']= 15;
        $config['total_rows'] = $data['count'];
        $this->pagination->initialize($config);
        $data['page_links']=$this->pagination->create_links();
        $data['active'] = 'ngos';
        $data['uri'] = $this->uri->segment(3);
		$data['ngos'] = $this->welcome_model->get_ngos($config['per_page'],$offset);
		$data['departments'] = $this->welcome_model->get_departments();
		$this->load->view('front/header',$data);
		$this->load->view('front/ngos',$data);
		$this->load->view('front/footer',$data);
	}

	public function institutions()
	{
		
        $data['active'] = 'institutions';
        $data['uri'] = $this->uri->segment(3);
		$this->load->view('front/header',$data);
		$this->load->view('front/institutions',$data);
		$this->load->view('front/footer',$data);
	}


public function view_book($bookid)
	{
		
    $data['active'] = 'books';
		$data['departments'] = $this->welcome_model->get_departments();
    $data['book_detail'] = $this->welcome_model->get_book_detail($bookid);
		$this->load->view('front/header',$data);
    $this->load->view('front/view-book',$data);
		$this->load->view('front/sidebar',$data);
		$this->load->view('front/footer',$data);
	}

public function order_book()
	{
		
    $data['active'] = 'books';
		$data['departments'] = $this->welcome_model->get_departments();
		$this->load->view('front/header',$data);
		$this->load->view('front/order_book',$data);
		$this->load->view('front/footer',$data);
	}
	public function event_dtl()
	{
		
    $data['active'] = 'event_dtl';
		$data['departments'] = $this->welcome_model->get_departments();
		$this->load->view('front/header',$data);
		$this->load->view('front/event_dtl',$data);
		$this->load->view('front/footer',$data);
	}





	public function contact()
	{
		//$this->is_user();
		if($this->input->post('name'))
		{
			$this->welcome_model->insert_contact();
			$this->email->from('info@myreposit.com', 'MyReposit Admin');
            $this->email->to('info@myreposit.com');
            $this->email->subject('MyReposit Contact Query');
            $this->email->message('Hi '."\n"."\n"
            .'A New Contact Query on the site.'
            ."\n"."\n"
            .'Please see follow details of user.'
            ."\n"
            .'User Name: '.$_POST['name']
            .'User Email Id: '.$_POST['email']
            .'User Address: '.$_POST['address']
            .'Contact No. : '.$_POST['phone']
            .'Comments : '.$_POST['comments']
            ."\n"
            .'MyReposit Team'
            ."\n"."\n"."\n"
            .'This is an automatically generated email. Please do not reply'
              );
            $this->email->send();
           $this->session->set_flashdata('msg', "Thank you. We will get back to you soon.");
           redirect('contact');
		}
    $data['page_content'] = $this->welcome_model->get_content('contact');
		$data['active'] = 'contact';
		$this->load->view('front/header',$data);
    $this->load->view('front/contact',$data);
		$this->load->view('front/sidebar',$data);
		$this->load->view('front/footer',$data);
	}


  public function career()
  {
    
    $data['jobs'] = $this->welcome_model->get_jobs();
    $data['active'] = 'career';
    $this->load->view('front/header',$data);
    $this->load->view('front/career',$data);
    $this->load->view('front/sidebar',$data);
    $this->load->view('front/footer',$data);
  }




	public function login_user()
	{

		$data['msg']="";
		if(isset($_POST['email']))
		{
			$email=$this->input->post('email');
			$password=$this->input->post('password');
			$user=$this->welcome_model->get_login_user($email,$password);
			//print_r($user);
			if($user)
			{
				
					if($user->status == '1')
						{
							  $this->session->set_userdata('mpuserid',$user->userid);
							  $this->session->set_userdata('mpusername',$user->fname);
							  $this->session->set_userdata('mpuseremail',$user->email);
                $this->session->set_userdata('mpusertype',$user->type);
							  $this->session->set_userdata('mpuserslug',$user->slug);
							  if ($this->input->is_ajax_request()) 
							  {
			                       print_r("1,user");
			                       die;
			                    }
			                    else{
							  redirect('welcome/dashboard');
							    }
						}
						elseif($user->status == '0' && $user->email_verification == '1')
            {
              if ($this->input->is_ajax_request()) 
              {
                print_r("##");
                die;
              }
              else{
                $data['msg']="Email not verified";
              }
            }
            elseif($user->status == '0')
            {
              if ($this->input->is_ajax_request()) 
              {
                print_r("#");
                die;
              }
              else{
                $data['msg']="Email not verified";
              }
            }
			}
			else
			{
				if ($this->input->is_ajax_request()) 
			  {
                   print_r("0");
                   die;
               }
             else{
				$data['msg']="Incorrect email or password";
				}
			}
		}
		//redirect('welcome/dashboard');
}

public function register()
	{
		if(isset($_POST['email']))
		{
			include 'recaptchalib.php';
      $publickey = "6LfjhggTAAAAAJmOuFzVcux_LT2HPbhsmpGQliUo";
      $privatekey = "6LfjhggTAAAAAPi_Fo4w_X4NZGrVH_AqaFXM_Roq";
      # the response from reCAPTCHA
      $resp = null;
      # the error code from reCAPTCHA, if any
      $error = null;
      //print_r($_POST);die;

      if (isset($_POST["recaptcha_response_field"])) {
        $resp = recaptcha_check_answer ($privatekey,
                                        $_SERVER["REMOTE_ADDR"],
                                        $_POST["recaptcha_challenge_field"],
                                        $_POST["recaptcha_response_field"]);
        if ($resp->is_valid) {
               // echo "You got it!";
        } else {
                # set the error code so that we can display it
                 $this->session->set_flashdata('msg', "Captcha is not correct.");
              redirect('signup');
        }
}

			if($this->welcome_model->check_email_exist($this->input->post('email'),'user'))
          {
              $this->session->set_flashdata('msg', "Email already registered.");
              redirect('signup');
          }
          else
          {  
          	$unique=uniqid();
          	$slug = $_POST['salutation']." ".$_POST['fname']." ".$_POST['lname'];
          	$slug = $this->slugify($slug);
			$id = $this->welcome_model->user_register($unique,$slug);
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
			if($id)
			{
        
				$config = array (
                  'mailtype' => 'html',
                  'charset'  => 'utf-8',
                  'priority' => '1'
                   );
        		$this->email->initialize($config);
				$this->email->from('info@myreposit.com', 'MyReposit');
				$this->email->to($_POST['email']);
				$this->email->subject('Welcome to MyReposit!');
				$message = '
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>e-Reposit</title>

</head>

<body>
<table width="800" border="0" style="margin:0 auto;">
 
  <tr>
    <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;  <img src="'.base_url().'assets/front/images/MyReposit logo1.png" height="45"><br>
      <p style="font-size:15px; color:#5b5a5a;"> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Thank you for your interest in MyReposit.com<br>
     &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b>Please <a  href="'.base_url().'index.php/welcome/verify/'.$id.'/'.$unique.'" target="_blank">VERIFY </a> your registration</b></p></td>
   
  </tr>
   <tr style="border:none;">
    <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<p style="margin-top: -17px;font-size:15px; color:#5b5a5a;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;In case the verify tab does not work,<br>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;please copy and paste this URL into your browser<br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a style="font-size:12px;" href="'.base_url().'index.php/welcome/verify/'.$id.'/'.$unique.'" target="_blank">'.base_url().'index.php/welcome/verify/'.$id.'/'.$unique.'</a></p>
</td>
  </tr>
   <tr style="border:none;">
    <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<p style="font-size:15px; color:#333">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<strong>MyReposit Team</strong><br>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a style="font-size:15px; " href="http://www.myreposit.com" target="_blank">www.myreposit.com</a></p><br>
<p style="font-size:10px;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;This is an automatically generated email. Please do not reply</p>
</td>
  </tr>
</table>

</body>
</html>


';
				$this->email->message($message);
				$this->email->send();
			 } 
			$this->session->set_flashdata('msg', 'Thank you for registering. Please check your email for account verification link.');
			redirect("/");
	    
	    }
	}
	else
	{
		$data['departments'] = $this->welcome_model->get_departments();
		$data['countries'] = $this->welcome_model->get_countries();
		$data['departments'] = $this->welcome_model->get_departments();
    $data['active'] = 'register';
		$this->load->view('front/header',$data);
    $this->load->view('front/register',$data);
		$this->load->view('front/sidebar',$data);
		$this->load->view('front/footer',$data);
	}
}



public function forget_password()
{
       
     if(isset($_POST['email'])) 
     {
        if($this->welcome_model->check_email_exist($_POST['email']))
        {
          $pass = uniqid();
	          $email = $_POST['email']; 
            $this->welcome_model->reset_password($_POST['email'],$pass);
            $this->email->from('info@myreposit.com', 'MyReposit Password reset');
                    $this->email->to($email);
                    $this->email->subject('Welcome to MyReposit');
                    $this->email->message('Hi '."\n"."\n"
                    .'You have requested for new password on MyReposit.'
                    ."\n"."\n"
                    .'Here is your login details'
                    ."\n"
                    .'your email id : '.$_POST['email']
                    ."\n"
                     .'your new password : '.$pass
                    ."\n"."\n"
                    .'MyReposit Team'
                    ."\n"
                    .'http://www.MyReposit.com'
                    ."\n"."\n"."\n"
                    .'This is an automatically generated email. Please do not reply'
                      );

                    $this->email->send();
        print_r(0);
       }
       else
       {
        print_r(1);
     
        }
     }
 }

 public function check_availability_email()
	{
	  if($this->welcome_model->check_email_exist($_GET['email']))
	  {
	      print("0");
	  }
	  else
	  {
	    print("1");
	  }
	}

	public function get_password()
	{
	   if($this->session->userdata('mpuserid'))
	        {

	        $old = $this->welcome_model->get_password($this->session->userdata('mpuserid'));
	        print_r($old[0]['password']);
	      }
	}

	public function update_password()
	{

	  if($this->session->userdata('mpuserid'))
	        {
	        $form_data = $_POST;
	        $this->welcome_model->update_password($form_data,$this->session->userdata('mpuserid'));
	        }
	        //redirect('store/profile');        
	}


public function verify($user_id="",$unique="")
	{
		$data['msg']="";
		$user_type = "user";
		$verify=$this->welcome_model->verify_registration($user_id,$unique);
		if($verify->status=="1")
		{
           $this->session->set_flashdata('msg', "Your account has already been verified. Please Log in to continue.");

		}
		else
		{
			$verified=$this->welcome_model->update_verfication($user_id,$unique,$user_type);
			if($verified)
			{
			    $this->session->set_flashdata('msg', "Thanks for registering at MyReposit. Your account will be created shortly.");
			    $message1 = '<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>MyReposit</title>

</head>

<body>
<table width="800" border="0" style="padding-left: 30px;margin:0 auto; border:2px groove #333333;">
 
  <tr>
    <td >  <img src="https://myreposit.com/assets/front/images/MyReposit%20logo1.png" height="60">
      <p style="font-size:24px; color:#5b5a5a;"> Attention Admin.<br>You have an Account Approval request. Log in here. 
  
</p>
     
  </tr>

   <tr style="border:none;">
    <td>
</td>
  </tr>
  <tr style="border:none;">
    <td>
</td>
  </tr>
   <tr style="border:none;">
    <td><p style="font-size:10px; color:#333">This message (including any attachments) may contain confidential, proprietary, privileged and/or private information. The information is intended to be for the use of the individual or entity designated above. If you are not the intended recipient of this message, please notify the sender immediately, and delete the  message and any attachments. Any disclosure, reproduction, distribution or other use of this message or any attachments by an individual or entity other than the intended recipient is prohibited. 
</p>
</td>
  </tr>
</table>

</body>
</html>';
          $config = array (
                  'mailtype' => 'html',
                  'charset'  => 'utf-8',
                  'priority' => '1'
                   );
            $this->email->initialize($config);
			     $this->email->from('info@myreposit.com', 'MyReposit');
                    $this->email->to('info@myreposit.com');
                    $this->email->subject('Account Verifivation Pending.');
                    $this->email->message($message1);
                    $this->email->send();

 $message2 = '<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>MyReposit</title>

</head>

<body>
<table width="800" border="0" style="padding-left: 30px;margin:0 auto; border:2px groove #333333;">
 
  <tr>
    <td >  <img src="https://myreposit.com/assets/front/images/MyReposit%20logo1.png" height="60">
      <p style="font-size:24px; color:#5b5a5a;"> Dear '.$verify->salutation.' '.ucfirst($verify->fname).' '.ucfirst($verify->lname).'<br>Thank you for your interest in MyReposit. Your account is being created. We will inform you as soon as this is done. 
  
</p>
     
  </tr>

   <tr style="border:none;">
    <td><p style="font-size:24px; color:#5b5a5a;">We thank you for your participation. <br><br>
MyReposit Team</p>
</td>
  </tr>
  <tr style="border:none;">
    <td><p style="font-size:18px; color:#5b5a5a;">Got queries?  Write to  us at info@myreposit.com 
</p>
</td>
  </tr>
   <tr style="border:none;">
    <td><p style="font-size:10px; color:#333">This message (including any attachments) may contain confidential, proprietary, privileged and/or private information. The information is intended to be for the use of the individual or entity designated above. If you are not the intended recipient of this message, please notify the sender immediately, and delete the  message and any attachments. Any disclosure, reproduction, distribution or other use of this message or any attachments by an individual or entity other than the intended recipient is prohibited. 
</p>
</td>
  </tr>
</table>

</body>
</html>
';
$this->email->from('info@myreposit.com', 'MyReposit');
                    $this->email->to($verify->email);
                    $this->email->subject('Account Verifivation Pending.');
                    $this->email->message($message2);
                    $this->email->send();
			}
            else{
			    $this->session->set_flashdata('msg', "Account could not be identified.");
            }
		}
		redirect("/");

	}

public function foo_verify($user_id="",$unique="",$password="")
	{
		$data['msg']="";
		$user_type = "user";
		$verify=$this->welcome_model->verify_registration($user_id,$unique);
		if($verify->status=="1")
		{
           $this->session->set_flashdata('msg', "Your account has already been verified. Please Log in to continue.");

		}
		else
		{
			$verified=$this->welcome_model->update_verfication($user_id,$unique,$user_type);
			if($verified)
			{
			    $this->session->set_flashdata('msg', "Thanks for registering at MyReposit. Your account will be created shortly.");
			    $message1 = '<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>MyReposit</title>

</head>

<body>
<table width="800" border="0" style="padding-left: 30px;margin:0 auto; border:2px groove #333333;">
 
  <tr>
    <td >  <img src="https://myreposit.com/assets/front/images/MyReposit%20logo1.png" height="60">
      <p style="font-size:24px; color:#5b5a5a;"> Attention Admin.<br>You have an Account Approval request. Log in here. 
  
</p>
     
  </tr>

   <tr style="border:none;">
    <td>
</td>
  </tr>
  <tr style="border:none;">
    <td>
</td>
  </tr>
   <tr style="border:none;">
    <td><p style="font-size:10px; color:#333">This message (including any attachments) may contain confidential, proprietary, privileged and/or private information. The information is intended to be for the use of the individual or entity designated above. If you are not the intended recipient of this message, please notify the sender immediately, and delete the  message and any attachments. Any disclosure, reproduction, distribution or other use of this message or any attachments by an individual or entity other than the intended recipient is prohibited. 
</p>
</td>
  </tr>
</table>

</body>
</html>';
$config = array (
                  'mailtype' => 'html',
                  'charset'  => 'utf-8',
                  'priority' => '1'
                   );
            $this->email->initialize($config);
			     $this->email->from('info@myreposit.com', 'MyReposit');
                    $this->email->to('info@myreposit.com');
                    $this->email->subject('Account Verifivation Pending.');
                    $this->email->message($message1);
                    $this->email->send();

 $message2 = '<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>MyReposit</title>

</head>

<body>
<table width="800" border="0" style="padding-left: 30px;margin:0 auto; border:2px groove #333333;">
 
  <tr>
    <td >  <img src="https://myreposit.com/assets/front/images/MyReposit%20logo1.png" height="60">
      <p style="font-size:24px; color:#5b5a5a;"> Dear '.$verify->salutation.' '.ucfirst($verify->fname).' '.ucfirst($verify->lname).'<br>Thank you for your interest in MyReposit. Your account is being created. We will inform you as soon as this is done. 
  
</p>
     
  </tr>
 <tr style="border:none;">
    <td><p style="font-size:20px; color:#5b5a5a;"><br>Your Email id : <b>'.$verify->email.'</b><br>
Your Password : <b>'.$password.'</b><br><br></p>
</td>
  </tr>
   <tr style="border:none;">
    <td><p style="font-size:24px; color:#5b5a5a;">We thank you for your participation. <br><br>
MyReposit Team</p>
</td>
  </tr>
  <tr style="border:none;">
    <td><p style="font-size:18px; color:#5b5a5a;">Got queries?  Write to  us at info@myreposit.com 
</p>
</td>
  </tr>
   <tr style="border:none;">
    <td><p style="font-size:10px; color:#333">This message (including any attachments) may contain confidential, proprietary, privileged and/or private information. The information is intended to be for the use of the individual or entity designated above. If you are not the intended recipient of this message, please notify the sender immediately, and delete the  message and any attachments. Any disclosure, reproduction, distribution or other use of this message or any attachments by an individual or entity other than the intended recipient is prohibited. 
</p>
</td>
  </tr>
</table>

</body>
</html>
';
//print_r($message2);
$config = array (
                  'mailtype' => 'html',
                  'charset'  => 'utf-8',
                  'priority' => '1'
                   );
            $this->email->initialize($config);
$this->email->from('info@myreposit.com', 'MyReposit');
                    $this->email->to($verify->email);
                    $this->email->subject('Account Verifivation Pending.');
                    $this->email->message($message2);
                    $this->email->send();
			}
            else{
			    $this->session->set_flashdata('msg', "Account could not be identified.");
            }
		}
		redirect("/");

	}



	public function specialty($name='')
	{
		//$this->is_user();
		$name = urldecode($name);
		$name1 = str_replace( "-"," ",$name);
		$offset=0;	
		$order=0;
		$page_no = 1;	
        $config['per_page']= 10;
	  	if($this->uri->segment(4))
          {
            $offset=$this->uri->segment(4);
            $page_no = ($offset/$config['per_page'])+1;
          }
       
	  	if($this->input->server('REQUEST_METHOD') == "POST") 
           {
           	   $this->session->set_userdata('find_array',$_POST);
           	   $find = $_POST;
           	   $offset= $_POST['page_no'];
           	   if($offset)
           	   redirect("welcome/specialty/".$name."/".$offset);
           		else
           		redirect("welcome/specialty/".$name);
           }
           else
           {
           		$find = $this->session->userdata('find_array');
           }
           if(!sizeof($find))
	           {
	           		$find = array('order' =>'asc' ,'page_no'=>'1' );
	           		
	           }
           if(isset($page_no))
           		{
           			$find['page_no'] = $page_no;
           		}
       		if(!isset($find['order']))
           		{
           			$find['order'] = 'asc';
           		}
        $data['count']= $this->welcome_model->get_specialty_article_count($name1);
	      $config['base_url'] = base_url().'index.php/welcome/specialty/'.$name."/";
	      $config['uri_segment'] = 2;
        $config['total_rows'] = $data['count'];
        $this->pagination->initialize($config);
        $data['page_links']=$this->pagination->create_links();
        $data['active'] = $name;
        $data['uri'] = $this->uri->segment(2);
        $data['find_array'] = $find;
        $data['per_page'] = $config['per_page'];
        $data['title'] = 'Speciality';
        $data['sub_title'] = $name1;
    		$data['articles'] = $this->welcome_model->get_specialty_article($name1,$config['per_page'],$offset,$find);
    		$data['departments'] = $this->welcome_model->get_departments();
    		$this->load->view('front/header',$data);
        $this->load->view('front/inner',$data);
    		$this->load->view('front/sidebar',$data);
    		$this->load->view('front/footer',$data);
	}


public function all_articles($name='all')
	{
		//$this->is_user();
		$name1 = str_replace( "-"," ",$name);
		$offset=0;	
		$order=0;
		$page_no = 1;	
        $config['per_page']= 10;
	  	if($this->uri->segment(4))
          {
            $offset=$this->uri->segment(4);
            $page_no = ($offset/$config['per_page'])+1;
          }
       
	  	if($this->input->server('REQUEST_METHOD') == "POST") 
           {
           	   $this->session->set_userdata('find_array',$_POST);
           	   $find = $_POST;
           	   $offset= $_POST['page_no'];
           	   if($offset)
           	   redirect("welcome/all_articles/".$name."/".$offset);
           		else
           		redirect("welcome/all_articles/");
           }
           else
           {
           		$find = $this->session->userdata('find_array');
           		
           }
           if(!isset($find) || sizeof($find))
           {
           		$find = array('order' =>'asc' ,'page_no'=>'1' );
				//print_r($find);die;
           		
           }
           if(isset($page_no))
           		{
           			$find['page_no'] = $page_no;
           		}
           		if(!isset($find['order']))
           		{
           			$find['order'] = 'asc';
           		}
        $data['count']= $this->welcome_model->get_specialty_article_count($name1);
	    $config['base_url'] = base_url().'index.php/welcome/all_articles/all';
	    $config['uri_segment'] = 4;
        $config['total_rows'] = $data['count'];
        $this->pagination->initialize($config);
        $data['page_links']=$this->pagination->create_links();
        $data['active'] = $name;
        $data['uri'] = $this->uri->segment(4);
        $data['find_array'] = $find;
        $data['per_page'] = $config['per_page'];
        $data['title'] = 'All Articles';
		$data['specialty_article'] = $this->welcome_model->get_specialty_article($name1,$config['per_page'],$offset,$find);
		$data['departments'] = $this->welcome_model->get_departments();
		$this->load->view('front/header',$data);
		$this->load->view('front/all-articles',$data);
		$this->load->view('front/footer',$data);
	}

public function community($name='')
	{
		$this->is_user();
		$name1 = str_replace( "-"," ",$name);
		$offset=0;	
		$order=0;
		$page_no = 1;	
        $config['per_page']= 10;
	  	if($this->uri->segment(4))
          {
            $offset=$this->uri->segment(4);
            $page_no = ($offset/$config['per_page'])+1;
          }
       
	  	if($this->input->server('REQUEST_METHOD') == "POST") 
           {
           	   $this->session->set_userdata('find_array',$_POST);
           	   $find = $_POST;
           	   $offset= $_POST['page_no'];
           	   if($offset)
           	   redirect("welcome/community/".$name."/".$offset);
           		else
           		redirect("welcome/community/".$name);
           }
        else
           {
           		$find = $this->session->userdata('find_array');
           }
        if(!sizeof($find))
           {
           		$find = array('order' =>'asc' ,'page_no'=>'1' );	
           }
        if(isset($page_no))
       		{
       			$find['page_no'] = $page_no;
       		}
        if(!isset($find['order']))
       		{
       			$find['order'] = 'asc';
       		}
        $data['count']= $this->welcome_model->get_community_article_count($name1);
	    $config['base_url'] = base_url().'index.php/welcome/community/'.$name."/";
	    $config['uri_segment'] = 4;
        $config['total_rows'] = $data['count'];
        $this->pagination->initialize($config);
        $data['page_links']=$this->pagination->create_links();
        $data['active'] = $name;
        $data['uri'] = $this->uri->segment(4);
        $data['find_array'] = $find;
        $data['per_page'] = $config['per_page'];
        $data['title'] = 'Community';
        $data['sub_title'] = $name1;
		$data['specialty_article'] = $this->welcome_model->get_community_article($name1,$config['per_page'],$offset,$find);
		$data['departments'] = $this->welcome_model->get_departments();
		$this->load->view('front/header',$data);
		$this->load->view('front/speciality',$data);
		$this->load->view('front/footer',$data);
	}

public function search()
	{
     
		//$this->is_user();
			$offset=0;	
			$order=0;
			$page_no = 1;	
	        $config['per_page']= 10;
		  	if($this->uri->segment(3))
	          {
	            $offset=$this->uri->segment(3);
	            $page_no = ($offset/$config['per_page'])+1;
	          }
	       
		  	if($this->input->server('REQUEST_METHOD') == "POST") 
	           {
	           	   $this->session->set_userdata('find_array',$_POST);
	           	   $find = $_POST;
	           	   $offset= $_POST['page_no'];
	           	   if($offset)
	           	   redirect("search/".$offset);
	           		else
	           		redirect("search/");
	           }
	        else
	           {
	           		$find = $this->session->userdata('find_array');
	           }
	        if(!sizeof($find))
	           {
	           		$find = array('order' =>'asc' ,'page_no'=>'1' );	
	           }
	        if(isset($page_no))
	       		{
	       			$find['page_no'] = $page_no;
	       		}
	        if(!isset($find['order']))
	       		{
	       			$find['order'] = 'asc';
	       		}
	        $data['count']= $this->welcome_model->get_search_article_count($find);
		    $config['base_url'] = base_url().'index.php/welcome/search/';
		    $config['uri_segment'] = 3;
	        $config['total_rows'] = $data['count'];
	        $this->pagination->initialize($config);
	        $data['page_links']=$this->pagination->create_links();
	        $data['uri'] = $this->uri->segment(3);
	        $data['find_array'] = $find;
	        $data['per_page'] = $config['per_page'];
	        if($find['cat'] == 'author')
	        {
	        	$data['title'] = 'Titles By '.$find['author_name'];
	        }
	        else
	        {
	        	$data['title'] = 'Search Results';
	        }
	       
			$data['specialty_article'] = $this->welcome_model->get_search_article($config['per_page'],$offset,$find);
			$data['departments'] = $this->welcome_model->get_departments();
			$this->load->view('front/header',$data);
      $this->load->view('front/search_result',$data);
			$this->load->view('front/sidebar',$data);
			$this->load->view('front/footer',$data);
		
	}	


public function post_idea($value='')
	{
		$this->is_user();
		if($this->input->server('REQUEST_METHOD') == "POST") 
           {
           	   $this->welcome_model->post_idea();
           	   $this->session->set_flashdata('msg', 'Thank you for your suggesions. We will revert soon. ');
           	   redirect('welcome/contact');
           }
           else
           {
           		redirect('welcome/index');
           }
	}


public function logout()
	{
		$this->session->unset_userdata('mpuserid');
		$this->session->unset_userdata('mpuseremail');
		$this->session->unset_userdata('mpusername');
		$this->session->unset_userdata('mpusertype');
    session_destroy();
		redirect('/');
	}

public function support($value='')
	{
		$this->is_user('support');
		if($this->session->userdata('mpuserid'))
		{
			$offset=0;	
			$order=0;
			$page_no = 1;	
	        $config['per_page']= 10;
		  	if($this->uri->segment(3))
	          {
	            $offset=$this->uri->segment(3);
	            $page_no = ($offset/$config['per_page'])+1;
	          }
	       
		  	if($this->input->server('REQUEST_METHOD') == "POST") 
	           {
	           	   $this->session->set_userdata('find_array',$_POST);
	           	   $find = $_POST;
	           	   $offset= $_POST['page_no'];
	           	   if($offset)
	           	   redirect("support/".$offset);
	           		else
	           		redirect("support/");
	           }
	        else
	           {
	           		$find = $this->session->userdata('find_array');
	           }
	        if(!sizeof($find))
	           {
	           		$find = array('order' =>'asc' ,'page_no'=>'1' );	
	           }
	        if(isset($page_no))
	       		{
	       			$find['page_no'] = $page_no;
	       		}
	        if(!isset($find['order']))
	       		{
	       			$find['order'] = 'asc';
	       		}
	        $data['count']= $this->welcome_model->get_support_ticket_count($find);
	        $data['count_total']= $this->welcome_model->get_support_ticket_count_total();
	        $data['count_open']= $this->welcome_model->get_support_ticket_count_open($find);
	        $data['count_closed']= $this->welcome_model->get_support_ticket_count_closed($find);
	        $data['count_resolved']= $this->welcome_model->get_support_ticket_count_resolved($find);
		    $config['base_url'] = base_url().'index.php/welcome/support/';
		    $config['uri_segment'] = 3;
	        $config['total_rows'] = $data['count'];
	        $this->pagination->initialize($config);
	        $data['page_links']=$this->pagination->create_links();
	        $data['uri'] = $this->uri->segment(3);
	        $data['find_array'] = $find;
	        $data['per_page'] = $config['per_page'];
	        $data['title'] = 'Support Tickets';
	        //$data['sub_title'] = $find;
			$data['support_ticket'] = $this->welcome_model->get_support_ticket($config['per_page'],$offset,$find);
			//print_r($data);die;
			$data['departments'] = $this->welcome_model->get_departments();
			$this->load->view('front/header',$data);
      $this->load->view('front/support',$data);
			$this->load->view('front/sidebar',$data);
			$this->load->view('front/footer',$data);
		}
		else
		{
			redirect('welcome/index');
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


public function generate_ticket($value='')
{
	 if($this->session->userdata('mpuserid'))
        {
          if($this->input->server('REQUEST_METHOD') == "POST") 
           {
           		$id = $this->welcome_model->generate_ticket();
           		$this->session->set_flashdata('msg', 'Your ticket has been generated. We will get back to you soon.');
           		redirect('welcome/support');
           }
        }
}



public function view_ticket_thread($number)
{
	 if($this->session->userdata('mpuserid'))
        {
			$data['ticket_detail'] = $this->welcome_model->get_ticket_detail($number);
			$data['thread_detail'] = $this->welcome_model->get_ticket_thread($number);
			if(sizeof($data['thread_detail']))
			{
				$data['departments'] = $this->welcome_model->get_departments();
				$this->load->view('front/header',$data);
        $this->load->view('front/ticket_thread',$data);
				$this->load->view('front/sidebar',$data);
				$this->load->view('front/footer',$data);
			}
			else
			{
				redirect('/');
			}
		}
}

public function reply_ticket()
{
  if($this->session->userdata('mpuserid'))
    {
    	if($this->input->server('REQUEST_METHOD') == "POST") 
           {
           	  $this->welcome_model->reply_ticket();
           	  $this->session->set_flashdata('msg', 'Message posted successfully');
           	  redirect('welcome/view_ticket_thread/'.$_POST['number']);
           }
           else
			{
				redirect('/');
			}
    }
    else
		{
			redirect('/');
		}

}




public function demo()
{
	$doi = $_GET['doi'];
  $url = "http://api.altmetric.com/v1/doi/".$doi; 
	//$url = "http://api.crossref.org/works/".$doi; 
	// create curl resource
        $ch = curl_init();

        // set url
        curl_setopt($ch, CURLOPT_URL, $url);

        //return the transfer as a string
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
//echo "<pre>";
        // $output contains the output string
        $output = curl_exec($ch);
       print_r($output);
        // close curl resource to free up system resources
        curl_close($ch); 
}


public function doi_info()
{
  $doi = $_GET['doi'];
  //$url = "http://api.altmetric.com/v1/doi/".$doi; 
  $url = "http://api.crossref.org/works/".$doi; 
  //10.1155/2015/597432
  // create curl resource
        $ch = curl_init();

        // set url
        curl_setopt($ch, CURLOPT_URL, $url);

        //return the transfer as a string
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        //echo "<pre>";
        // $output contains the output string
        $output = curl_exec($ch);
       print_r($output);
        // close curl resource to free up system resources
        curl_close($ch); 
}






public function career_inner($job_id)
{
    
    $data['job_desc'] = $this->welcome_model->get_job_desc($job_id);
    $data['active'] = 'career';
    $this->load->view('front/header',$data);
    $this->load->view('front/career-inner',$data);
    $this->load->view('front/sidebar',$data);
    $this->load->view('front/footer',$data);
  
}


public function apply_job()
{
   
   $id = $this->welcome_model->apply_job();
   $job_id = $_POST['job_id'];
   if($id)
   {

    if ($_FILES["userfile1"]["error"] > 0)
                    {
                    }
                  else
                    {

                    $_POST['type'] = 'job';
                    $ext = end(explode('.', $_FILES["userfile1"]["name"])); 
                    $un =  uniqid();
                    $path = "upload/".$_POST['type']."/".$job_id;
                    if(!is_dir($path)){
                      mkdir($path);
                    }
                      /* new file name */
                      if($_FILES["userfile1"]["name"] != "")
                      {
                        $path = 'upload/'.$_POST['type'].'/'.$job_id.'/'.$_FILES['userfile1']['name'];
                       if (file_exists('upload/'.$_POST['type'].'/'.$job_id.'/'.$_FILES["userfile1"]["name"]))
                        {
                        $un = uniqid();
                        $_FILES["userfile1"]["name"] = $un.".".$ext;
                        }
                         $path = 'upload/'.$_POST['type'].'/'.$job_id.'/'.$_FILES['userfile1']['name'];

                        move_uploaded_file($_FILES["userfile1"]["tmp_name"],
                         $path);
                        $this->welcome_model->upload_file_name($id,$_FILES["userfile1"]["name"]);    
                    }
                 }
      $this->session->set_flashdata('msg', 'You have successfully applied for this job.');
              redirect('welcome/career');
            }
            else
            {
               $this->session->set_flashdata('msg', 'You have already applied for this job.');
              redirect('welcome/career');
            }
}


public function apply_for_reviewer()
{
   
   $id = $this->welcome_model->apply_for_reviewer();
   $job_id = $_POST['job_id'];
   if($id)
   {

    if ($_FILES["userfile1"]["error"] > 0)
                    {
                    }
                  else
                    {

                    $_POST['type'] = 'reviewer';
                    $ext = end(explode('.', $_FILES["userfile1"]["name"])); 
                    $un =  uniqid();
                    $path = "upload/".$_POST['type']."/".$job_id;
                    if(!is_dir($path)){
                      mkdir($path);
                    }
                      /* new file name */
                      if($_FILES["userfile1"]["name"] != "")
                      {
                        $path = 'upload/'.$_POST['type'].'/'.$job_id.'/'.$_FILES['userfile1']['name'];
                       if (file_exists('upload/'.$_POST['type'].'/'.$job_id.'/'.$_FILES["userfile1"]["name"]))
                        {
                        $un = uniqid();
                        $_FILES["userfile1"]["name"] = $un.".".$ext;
                        }
                         $path = 'upload/'.$_POST['type'].'/'.$job_id.'/'.$_FILES['userfile1']['name'];

                        move_uploaded_file($_FILES["userfile1"]["tmp_name"],
                         $path);
                        $this->welcome_model->upload_file_name2($id,$_FILES["userfile1"]["name"]);    
                    }
                 }
      $this->session->set_flashdata('msg', 'You have applied for become reviewer.');
              redirect('become-reviewer');
            }
            else
            {
               $this->session->set_flashdata('msg', 'You have already applied for become reviewer.');
               redirect('become-reviewer');
            }
}


public function publish_sell_submit($value='')
{
    $id = $this->welcome_model->publish_sell_submit();
   print $job_id = $id;
   if($id)
   {

    if ($_FILES["userfile1"]["error"] > 0)
                    {
                    }
                  else
                    {

                    $_POST['type'] = 'publish_sell';
                    $ext = end(explode('.', $_FILES["userfile1"]["name"])); 
                    $un =  uniqid();
                    $path = "upload/".$_POST['type']."/".$job_id;
                    if(!is_dir($path)){
                      mkdir($path);
                    }
                      /* new file name */
                      if($_FILES["userfile1"]["name"] != "")
                      {
                        $path = 'upload/'.$_POST['type'].'/'.$job_id.'/'.$_FILES['userfile1']['name'];
                       if (file_exists('upload/'.$_POST['type'].'/'.$job_id.'/'.$_FILES["userfile1"]["name"]))
                        {
                        $un = uniqid();
                        $_FILES["userfile1"]["name"] = $un.".".$ext;
                        }
                         $path = 'upload/'.$_POST['type'].'/'.$job_id.'/'.$_FILES['userfile1']['name'];

                        move_uploaded_file($_FILES["userfile1"]["tmp_name"],
                         $path);
                        $this->welcome_model->upload_file_name3($id,$_FILES["userfile1"]["name"]);    
                    }
                 }
      $this->session->set_flashdata('msg', 'You document has been sent to myreposit.');
              redirect('publish-sell');
            }
            
}

public function change_rating($rating,$articleid)
{
   $stat =  $this->welcome_model->change_rating($rating,$articleid);
   return $stat;
}

public function publish_sell_submit_request()
{
  $stat =  $this->welcome_model->publish_sell_submit_request();
  $this->session->set_flashdata('msg', 'You request has been sent to myreposit.');
  redirect('publish-sell');
  return $stat;
}

public function peer_review_steps()
{
   $data['active'] = 'peer_review_steps';
    $data['departments'] = $this->welcome_model->get_departments();
    $this->load->view('front/header',$data);
    $this->load->view('front/peer_review_steps',$data);
    $this->load->view('front/sidebar',$data);
    $this->load->view('front/footer',$data);
}

public function manuscript_submission()
{
  $data['active'] = 'manuscript_submission';
    $data['departments'] = $this->welcome_model->get_departments();
    $this->load->view('front/header',$data);
    $this->load->view('front/manuscript_submission',$data);
    $this->load->view('front/sidebar',$data);
    $this->load->view('front/footer',$data);
}

public function job_reference()
{
  $data['active'] = 'job_reference';
    $data['departments'] = $this->welcome_model->get_departments();
    $this->load->view('front/header',$data);
    $this->load->view('front/job_reference',$data);
    $this->load->view('front/sidebar',$data);
    $this->load->view('front/footer',$data);
}

public function submit_resume()
{
  if(isset($_POST['fname']))
  {
    $job_id = $this->welcome_model->submit_resume();
    if ($_FILES["userfile1"]["error"] > 0)
                    {
                    }
                  else
                    {

                    $_POST['type'] = 'resumes';
                    $ext = end(explode('.', $_FILES["userfile1"]["name"])); 
                    $un =  uniqid();
                    $path = "upload/".$_POST['type']."/".$job_id;
                    if(!is_dir($path)){
                      mkdir($path);
                    }
                      /* new file name */
                      if($_FILES["userfile1"]["name"] != "")
                      {
                        $path = 'upload/'.$_POST['type'].'/'.$job_id.'/'.$_FILES['userfile1']['name'];
                       if (file_exists('upload/'.$_POST['type'].'/'.$job_id.'/'.$_FILES["userfile1"]["name"]))
                        {
                        $un = uniqid();
                        $_FILES["userfile1"]["name"] = $un.".".$ext;
                        }
                         $path = 'upload/'.$_POST['type'].'/'.$job_id.'/'.$_FILES['userfile1']['name'];

                        move_uploaded_file($_FILES["userfile1"]["tmp_name"],
                         $path);
                        $this->welcome_model->upload_file_name5($id,$_FILES["userfile1"]["name"]);    
                    }
                 }
    $this->session->set_flashdata('msg', 'You document has been sent to myreposit.');
    redirect('submit-resume');
  }
  $data['active'] = 'submit_resume';
    $data['departments'] = $this->welcome_model->get_departments();
    $this->load->view('front/header',$data);
    $this->load->view('front/submit_resume',$data);
    $this->load->view('front/sidebar',$data);
    $this->load->view('front/footer',$data);
}


public function submit_manuscript()
{
    $id = $this->welcome_model->submit_manuscript();
    $job_id = $id;
   if($id)
   {

    if ($_FILES["userfile1"]["error"] > 0)
                    {
                    }
                  else
                    {

                    $_POST['type'] = 'manuscript_submission';
                    $ext = end(explode('.', $_FILES["userfile1"]["name"])); 
                    $un =  uniqid();
                    $path = "upload/".$_POST['type']."/".$job_id;
                    if(!is_dir($path)){
                      mkdir($path);
                    }
                      /* new file name */
                      if($_FILES["userfile1"]["name"] != "")
                      {
                        $path = 'upload/'.$_POST['type'].'/'.$job_id.'/'.$_FILES['userfile1']['name'];
                       if (file_exists('upload/'.$_POST['type'].'/'.$job_id.'/'.$_FILES["userfile1"]["name"]))
                        {
                        $un = uniqid();
                        $_FILES["userfile1"]["name"] = $un.".".$ext;
                        }
                         $path = 'upload/'.$_POST['type'].'/'.$job_id.'/'.$_FILES['userfile1']['name'];

                        move_uploaded_file($_FILES["userfile1"]["tmp_name"],
                         $path);
                        $this->welcome_model->upload_file_name4($id,$_FILES["userfile1"]["name"]);    
                    }
                 }
      $this->session->set_flashdata('msg', 'You document has been sent to myreposit.');
              redirect('manuscript-submission');
            }
}


public function manuscript_editing_order()
{

  if($this->input->post('speciality'))
  {

    $ord_id = $this->welcome_model->manuscript_editing_order('editing');


    $files = scandir("server/php/files/".$this->session->userdata('mpuserid'));
     $oldfolder = "server/php/files/".$this->session->userdata('mpuserid')."/";
   
     $newfolder = "upload/manuscript_development/editing/".$ord_id."/";
                  if(!is_dir($newfolder)){
                      mkdir($newfolder);
                    }
    foreach($files as $fname) {
        if($fname != '.' && $fname != '..') {
            rename($oldfolder.$fname, $newfolder.$fname);
        }
    }
    $this->remove_temporary_files($newfolder."thumbnail/");
    $this->session->set_flashdata('msg', 'request submitted');
    print_r($ord_id);
  }
}


public function manuscript_formatting_order()
{

  if($this->input->post('speciality'))
  {

    $ord_id = $this->welcome_model->manuscript_editing_order('formatting');


    $files = scandir("server/php/files/".$this->session->userdata('mpuserid'));
    $oldfolder = "server/php/files/".$this->session->userdata('mpuserid')."/";
   
    $newfolder = "upload/manuscript_development/formatting/".$ord_id."/";
                  if(!is_dir($newfolder)){
                      mkdir($newfolder);
                    }
    foreach($files as $fname) {
        if($fname != '.' && $fname != '..') {
            rename($oldfolder.$fname, $newfolder.$fname);
        }
    }
    $this->remove_temporary_files($newfolder."thumbnail/");
    $this->session->set_flashdata('msg', 'request submitted');
    redirect('formatting');
  }
}


public function manuscript_translation_order()
{

  if($this->input->post('speciality'))
  {

    $ord_id = $this->welcome_model->manuscript_editing_order('translation');


    $files = scandir("server/php/files/".$this->session->userdata('mpuserid'));
    $oldfolder = "server/php/files/".$this->session->userdata('mpuserid')."/";
   
    $newfolder = "upload/manuscript_development/translation/".$ord_id."/";
                  if(!is_dir($newfolder)){
                      mkdir($newfolder);
                    }
    foreach($files as $fname) {
        if($fname != '.' && $fname != '..') {
            rename($oldfolder.$fname, $newfolder.$fname);
        }
    }
    $this->remove_temporary_files($newfolder."thumbnail/");
    $this->session->set_flashdata('msg', 'request submitted');
    redirect('translation');
  }
}


public function request_quote()
{
    $this->is_user();
    $this->remove_temporary_files("server/php/files/".$this->session->userdata('mpuserid')."/");
    $data['active'] = 'request_quote';
    $data['departments'] = $this->welcome_model->get_departments();
    $this->load->view('front/header',$data);
    $this->load->view('front/request_quote',$data);
    $this->load->view('front/sidebar',$data);
    $this->load->view('front/footer',$data);
}


public function manuscript_custom_order()
{

  if($this->input->post('fname'))
  {

    $ord_id = $this->welcome_model->manuscript_custom_order();


    $files = scandir("server/php/files/".$this->session->userdata('mpuserid'));
    $oldfolder = "server/php/files/".$this->session->userdata('mpuserid')."/";
   
    $newfolder = "upload/manuscript_development/custom/".$ord_id."/";
                  if(!is_dir($newfolder)){
                      mkdir($newfolder);
                    }
    foreach($files as $fname) {
        if($fname != '.' && $fname != '..') {
            rename($oldfolder.$fname, $newfolder.$fname);
        }
    }
    $this->remove_temporary_files($newfolder."thumbnail/");
    $this->session->set_flashdata('msg', 'request submitted');
    redirect('request-quote');
  }
}



public function manuscript_figure_order()
{
  
  if($this->input->post('speciality'))
  {
    $id = $this->welcome_model->manuscript_figure_order('figure_formation');


   foreach ($_FILES["userfile1"]["error"] as $key => $value)
   {
     if ($_FILES["userfile1"]["error"][$key] > 0)
                    {
                    }
                  else
                    {
                    $_POST['type'] = 'manuscript_development/figure_formation';
                    $ext = end(explode('.', $_FILES["userfile1"]["name"][$key])); 
                    $un =  uniqid();
                   $path = "upload/".$_POST['type']."/".$id;
                    if(!is_dir($path)){
                      mkdir($path);
                    }
                      /* new file name */
                      if($_FILES["userfile1"]["name"][$key] != "")
                      {
                        $path = 'upload/'.$_POST['type'].'/'.$id.'/'.$_FILES['userfile1']['name'][$key];
                       if (file_exists('upload/'.$_POST['type'].'/'.$id.'/'.$_FILES["userfile1"]["name"][$key]))
                        {
                        $un = uniqid();
                        $_FILES["userfile1"]["name"][$key] = $un.".".$ext;
                        }
                         $path = 'upload/'.$_POST['type'].'/'.$id.'/'.$_FILES['userfile1']['name'][$key];

                        move_uploaded_file($_FILES["userfile1"]["tmp_name"][$key],
                         $path);
                        $this->welcome_model->change_cv_user($id,$_FILES["userfile1"]["name"][$key]);    
                    }
                 }
   }
   
    $this->session->set_flashdata('msg', 'request submitted');
    redirect('figure_prep');
  }
}


public function multimedia()
{
   $data['active'] = 'job_reference';
    $data['departments'] = $this->welcome_model->get_departments();
    $data['multimedia_article'] = $this->welcome_model->get_multimedia_article();

    $this->load->view('front/header',$data);
    $this->load->view('front/multimedia',$data);
    $this->load->view('front/sidebar',$data);
    $this->load->view('front/footer',$data);
}




}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */