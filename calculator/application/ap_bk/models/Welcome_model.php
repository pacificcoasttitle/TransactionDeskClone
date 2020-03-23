<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Welcome_model extends CI_Model 
{

	public function __construct()
	{
		parent::__construct();
		$this->load->database();
	}

	 public function check_email_exist($email)
     {
       $this->db->select('*');
       $this->db->where('email',$email);
       $query=$this->db->get('user');
       if($query->num_rows()>0)
       {
          return $query->row();
       }
       else
       {
         return false;
       }
     }

       public function user_register($verification,$slug)  
    {
      //echo "<pre>";
      //print_r($_POST);die;
       $temp = $slug;
        for ($i=2; $i <999 ; $i++) 
        { 

            $this->db->where('slug', $slug);
            $query = $this->db->get('user');
            $count = $query->num_rows();
            if($count == 0)
            {
              break;
            }
            else
            {
              $slug = $temp."-".$i;
            }
        }
        
        $row = array(
          'salutation'        =>$_POST['salutation'], 
          'fname'        =>$_POST['fname'], 
          'lname'        =>$_POST['lname'], 
          'email'        =>$_POST['email'], 
          'phone'        =>$_POST['phone'], 
          'designation'  =>$_POST['designation'],
          'country'  =>  $_POST['country'],
          'department'   =>$_POST['department'],
          'password'     =>md5($_POST['password']),
          'verification' => $verification,
          'slug'         => $slug,
          'high_education'   =>$_POST['high_education'],
          'college'   =>$_POST['college'],
          'blog_url'   =>$_POST['blog_url']
          );
        $this->db->insert('user',$row);
        $id =   $this->db->insert_id();
        
        return $id;

     }

     public function change_profile_user($id,$name)
     {
       $row = array('profilepic' => $name);
       $this->db->where('userid', $id);
       $this->db->update('user', $row);
     }

public function change_cv_user($id,$name)
     {
       $row = array('cv' => $name);
       $this->db->where('userid', $id);
       $this->db->update('user', $row);
     }
public function get_login_user($email,$password)
      {
         $this->db->select('*');
         $this->db->where('email',$email);
         $this->db->where('password',md5($password));
         $query=$this->db->get('user');
         if($query->num_rows()>0)
         {
           return $query->row();
         }
         else
         {
           return false;
         }
       }
     


  public function verify_registration($user_id,$unique)
     {
       $this->db->select('*');
       $this->db->where('userid',$user_id);
       $this->db->where('verification',$unique);
       $query=$this->db->get("user");
       if($query->num_rows()>0)
       {
          return $query->row();
       }
       else
       {
         return 0;
       }
     }

     public function update_verfication($id,$unique)
     {
       $data=array('email_verification'=>"1");
       $this->db->where('userid',$id);
       $this->db->where('verification',$unique);
       $this->db->update("user",$data);
       if ($this->db->affected_rows() > 0)
           return true;
       else
          return false;
     }

     public function reset_password($data,$pass)
  {
 
    $i1 = array(
            'password'=>md5($pass));
    $this->db->where('email',$data);
   $this->db->update('user',$i1);
    
  }


public function get_departments()
{
   $this->db->where('status', '1');
   $this->db->where('parent_id', '1');
   $this->db->order_by('departmentname', 'asc');
   $query = $this->db->get('departments');
   return $query->result();
}


public function get_countries()
{
  $this->db->order_by('country_name', 'asc');
  $query = $this->db->get('countries');
   return $query->result();
}


public function get_specialty_article_count($name='')
   {
      $this->db->select('article.*,user.department,departments.departmentname');
      if($name != 'all')
      $this->db->where('article.subject', $name);
      $this->db->where('article.status', 1);
      $this->db->join('user', 'user.userid = article.userid', 'left');
      $this->db->join('departments', 'departments.departmentid = user.department', 'left');
      $query = $this->db->get('article');
      return $query->num_rows();
   }

public function get_specialty_article($name='',$num,$offset,$find)
   {
      $this->db->select('article.*,departments.departmentname');
      if($name != 'all')
     $this->db->where('article.subject', $name);
   $this->db->where('article.status', 1);
      $this->db->join('user', 'user.userid = article.userid', 'left');
      $this->db->join('departments', 'departments.departmentid = user.department', 'left');
      $this->db->order_by('article.rdate', $find['order']);
      $query = $this->db->get('article',$num,$offset);
      return $query->result();
   }

public function get_search_article_count($find='')
   {
      $this->db->select('article.*,user.department,departments.departmentname');
      $this->db->where('article.status', 1);
      $this->db->like('article.'.$find['cat'], $find[$find['cat'].'_name']);
      $this->db->join('user', 'user.userid = article.userid', 'left');
      $this->db->join('departments', 'departments.departmentid = user.department', 'left');
      $query = $this->db->get('article');
      return $query->num_rows();
   }

public function get_search_article($num,$offset,$find)
   {
      $this->db->select('article.*,departments.departmentname');
      $this->db->where('article.status', 1);
      $this->db->like('article.'.$find['cat'], $find[$find['cat'].'_name']);
      $this->db->join('user', 'user.userid = article.userid', 'left');
      $this->db->join('departments', 'departments.departmentid = user.department', 'left');
      $this->db->order_by('article.rdate', $find['order']);
      $query = $this->db->get('article',$num,$offset);
      return $query->result();
   }

public function get_community_article_count($name='')
   {
      $this->db->select('article.*,user.department,departments.departmentname');
      $this->db->where('article.community', $name);
      $this->db->where('article.status', 1);
      $this->db->join('user', 'user.userid = article.userid', 'left');
      $this->db->join('departments', 'departments.departmentid = user.department', 'left');
      $query = $this->db->get('article');
      return $query->num_rows();
   }

public function get_community_article($name='',$num,$offset,$find)
   {
      $this->db->select('article.*,departments.departmentname');
      $this->db->where('article.community', $name);
      $this->db->where('article.status', 1);
      $this->db->join('user', 'user.userid = article.userid', 'left');
      $this->db->join('departments', 'departments.departmentid = user.department', 'left');
      $this->db->order_by('article.rdate', $find['order']);
      $query = $this->db->get('article',$num,$offset);
      return $query->result();
   }

public function get_other_contributers($articleid)
{
  $this->db->select('article_contributers.*, user.userid,user.salutation,user.slug,user.slug');
   $this->db->where('article_contributers.article_id', $articleid);
   $this->db->join('user', 'user.email = article_contributers.author_email', 'left');
   $query = $this->db->get('article_contributers');
   return $query->result();
}


public function insert_contact()
   {
    $row=array(
        'name'=>$_POST['name']." ".$_POST['lname'],
        'email'=>$_POST['email'],
        'phone'=>$_POST['phone'],
        'comments'=>$_POST['comments']
      );
      $this->db->insert('contact',$row);
   }

public function post_idea()
   {
       $this->db->insert('submitted_ideas',$_POST);
   }

  public function get_content($keyword)
  {
    $this->db->select('manage_pages.*');
    $this->db->where('manage_pages.keyword', $keyword);
    $query = $this->db->get('manage_pages');
    return $query->row(); 
  }

  public function get_support_ticket_count_total()
  {
     $this->db->where('user_id', $this->session->userdata('mpuserid'));

   $query = $this->db->get('ost_ticket');
   return $query->num_rows();
  }

  public function get_support_ticket_count($find='')
  {
     $this->db->where('user_id', $this->session->userdata('mpuserid'));
     if($find['status'] != "")
     $this->db->where('status_id', $find['status']);
   $query = $this->db->get('ost_ticket');
   return $query->num_rows();
  }

  public function get_support_ticket_count_open($find='')
  {
     $this->db->where('user_id', $this->session->userdata('mpuserid'));
     $this->db->where('status_id', 1);
   $query = $this->db->get('ost_ticket');
   return $query->num_rows();
  }

  public function get_support_ticket_count_closed($find='')
  {
     $this->db->where('user_id', $this->session->userdata('mpuserid'));
     $this->db->where('status_id', 3);
   $query = $this->db->get('ost_ticket');
   return $query->num_rows();
  }
public function get_support_ticket_count_resolved($find='')
  {
     $this->db->where('user_id', $this->session->userdata('mpuserid'));
     $this->db->where('status_id', 2);
   $query = $this->db->get('ost_ticket');
   return $query->num_rows();
  }
public function get_support_ticket($num,$offset,$find='')
  {
    $this->db->select('ost_ticket.*,ost_ticket__cdata.subject,ost_ticket_status.name');
    $this->db->where('ost_ticket.user_id', $this->session->userdata('mpuserid'));
    if($find['status'] != "")
    $this->db->where('status_id', $find['status']);
    $this->db->join('ost_ticket__cdata', 'ost_ticket__cdata.ticket_id = ost_ticket.ticket_id', 'left');
    $this->db->join('ost_ticket_status', 'ost_ticket_status.id = ost_ticket.status_id', 'left');
    $query = $this->db->get('ost_ticket',$num,$offset);
    return $query->result();
  }

  public function generate_ticket()
  {
    $cdata = array('subject' =>$this->input->post('subject'));
    $this->db->insert('ost_ticket__cdata', $cdata);
    $id = $this->db->insert_id();
    $number = 323232;
    for ($i=2; $i <999 ; $i++) 
        { 
            $number = $this->random_numbers(6);

            $this->db->where('number', $number);
            $query = $this->db->get('ost_ticket');
            $count = $query->num_rows();
            if($count == 0)
            {
              break;
            }
        }
$date = new DateTime(date("Y-m-d h:i:s A"));
   $lastmessage = $date->format('Y-m-d G:i:s') ;
     $ost_ticket = array( 
                    'ticket_id' => $id,
                    'number' => $number, 
                    'user_id' => $this->session->userdata('mpuserid'), 
                    'status_id' =>1 , 
                    'topic_id' =>$_POST['ticket_topic'] , 
                    'created' =>$lastmessage,
                    'lastmessage' =>$lastmessage,
                    );
     $this->db->insert('ost_ticket', $ost_ticket);

     $ost_ticket_thread  = array(
                          'pid' => 0,
                          'ticket_id' => $id,
                          'user_id' => $this->session->userdata('mpuserid'),
                          'body' => $this->input->post('body'),
                          'poster' => $this->session->userdata('mpusername')
      );

     $this->db->insert('ost_ticket_thread', $ost_ticket_thread);




  }

  public function reply_ticket($value='')
  {
     $ost_ticket_thread  = array(
                          'ticket_id' => $this->input->post('ticket_id'),
                          'user_id' => $this->session->userdata('mpuserid'),
                          'body' => $this->input->post('body'),
                           'poster' => $this->session->userdata('mpusername')

      );

     $this->db->insert('ost_ticket_thread', $ost_ticket_thread);

     $date = new DateTime(date("Y-m-d h:i:s A"));
   $lastmessage = $date->format('Y-m-d G:i:s') ;
     $ost_ticket = array(
     'status_id'=> '1', 
                    'lastmessage' =>$lastmessage,
                    );
     $this->db->where('ticket_id', $this->input->post('ticket_id'));
     $this->db->update('ost_ticket', $ost_ticket);
  }


  public function get_ticket_detail($number)
  {
    $this->db->select('ost_ticket.*,ost_ticket__cdata.subject,,ost_ticket_status.name');
    $this->db->where('ost_ticket.user_id', $this->session->userdata('mpuserid'));
    $this->db->where('ost_ticket.number', $number);
    $this->db->join('ost_ticket__cdata', 'ost_ticket__cdata.ticket_id = ost_ticket.ticket_id', 'left');
    $this->db->join('ost_ticket_status', 'ost_ticket_status.id = ost_ticket.status_id', 'left');
    $query = $this->db->get('ost_ticket');
    return $query->row();
  }

  public function get_ticket_thread($number)
  {
    $this->db->select('ost_ticket.*');
    $this->db->where('ost_ticket.user_id', $this->session->userdata('mpuserid'));
    $this->db->where('ost_ticket.number', $number);
    $query = $this->db->get('ost_ticket');
    $data =  $query->row();

    $this->db->where('ost_ticket_thread.ticket_id', $data->ticket_id);
    $query = $this->db->get('ost_ticket_thread');
    return $query->result();
  }

  function random_numbers($digits) {
    $min = pow(10, $digits - 1);
    $max = pow(10, $digits) - 1;
    return mt_rand($min, $max);
}

public function get_faqs($num,$offset)
{
   $this->db->where('status', '1');
   $query = $this->db->get('faq',$num,$offset);
   return $query->result();
}

public function get_faqs_count()
{
   $this->db->where('status', '1');
   $query = $this->db->get('faq');
   return $query->num_rows();

}
public function get_books($find,$num,$offset)
   {
      $expl = explode(",", $find['order_by']);
      $this->db->select('user.*,books.*,departments.departmentname');
      $this->db->where('books.status', '1');
      $this->db->join('user', 'user.userid = books.userid');
      $this->db->join('departments', 'departments.departmentid = user.department');
      $this->db->order_by('books.date_created', $expl[1]);
      $query = $this->db->get('books',$num,$offset);
      return $query->result();
}

public function get_book_detail($bookid)
   {
      $this->db->select('user.*,books.*,departments.departmentname');
      $this->db->where('books.bookid', $bookid);
      $this->db->where('books.status', '1');
      $this->db->join('user', 'user.userid = books.userid');
      $this->db->join('departments', 'departments.departmentid = user.department');
      $query = $this->db->get('books',$num,$offset);
      return $query->row();
}

public function get_book_toc($bookid)
   {
      $this->db->where('bookid', $bookid);
      $query = $this->db->get('book_toc');
      return $query->result();
}


public function get_books_count()
{
   $this->db->where('status', '1');
   $query = $this->db->get('books');
   return $query->num_rows();

}

public function book_order($bookid)
{
  $row = array('userid' =>$this->session->userdata('mpuserid') ,'bookid'=> $bookid );
  $this->db->insert('books_order', $row);
  return $this->db->insert_id();
}

public function get_events($num,$offset)
{
   $this->db->where('status', '1');
   $query = $this->db->get('events',$num,$offset);
   return $query->result();
}

public function get_events_count()
{
   $this->db->where('status', '1');
   $query = $this->db->get('events');
   return $query->num_rows();

}

public function get_ngos($num,$offset)
{
   $this->db->where('status', '1');
   $query = $this->db->get('ngos',$num,$offset);
   return $query->result();
}

public function get_ngos_count()
{
   $this->db->where('status', '1');
   $query = $this->db->get('ngos');
   return $query->num_rows();

}

public function get_institutions($num,$offset)
{
   $this->db->where('status', '1');
   $query = $this->db->get('institutions',$num,$offset);
   return $query->result();
}

public function get_institutions_count()
{
   $this->db->where('status', '1');
   $query = $this->db->get('institutions');
   return $query->num_rows();

}
public function get_article_rating($article_id)
{
    $this->db->where('article_id', $article_id);
    $query = $this->db->get('rating');
    if($query->num_rows())
    {
      return $query->row();
    }
    else
    {
      return 0;
    }
}

public function change_rating($rating,$articleid)
{
   $this->db->where('article_id', $articleid);
    $query = $this->db->get('rating');
    if($query->num_rows())
    {
      $sql = "update rating set rating = rating + ".$rating.", total_review = total_review +1 WHERE article_id=".$articleid ;

      $query = $this->db->query($sql); 
      return $this->db->affected_rows();
    }
    else
    {
      $row = array(
            'rating'=> $rating,
            'total_review'=>1,
            'article_id'=>$articleid
        );
      $this->db->insert('rating', $row);
      return $this->db->insert_id();
    }
}

public function get_jobs()
{
  $this->db->where('expire_on >', date("Y-m-d"));
  $this->db->order_by('job_id', 'desc');
  $query = $this->db->get('job_posting');
  return $query->result();
}

public function get_job_desc($job_id)
{
  $this->db->where('job_id', $job_id);
  $query = $this->db->get('job_posting');
  return $query->row();
}



public function apply_job()
{

  $this->db->where('job_post_id', $_POST['job_post_id']);
  $this->db->where('email', $_POST['email']);
  $query = $this->db->get('applied_for_post');
  if($query->num_rows())
  {
    return 0;
  }
  else
  {
    $this->db->insert('applied_for_post', $_POST);
    return $this->db->insert_id();
  }

  
}



public function become_reviewer_apply()
{

  $this->db->where('email', $this->session->userdata('mpuseremail'));
  $query = $this->db->get('applied_for_reviewer');
  if($query->num_rows())
  {
    return 0;
  }
  else
  {
    $row = array('userid' =>$this->session->userdata('mpuserid'),'email'=>$this->session->userdata('mpuseremail'));
    $this->db->insert('applied_for_reviewer', $row);
    return $this->db->insert_id();
  }

  
}

public function publish_sell_submit()
{
    $this->db->insert('publish_sell_req', $_POST);
    return $this->db->insert_id();
}

public function publish_sell_submit_request()
{
  $row = array('userid' => $this->session->userdata('mpuserid'),'booktype' =>$_POST['book_type'],'manuscript_ready'=>$_POST['manuscript_ready']  );
    $this->db->insert('publish_sell_book_request',$row);
    return $this->db->insert_id();
}

public function submit_resume()
{
    $this->db->insert('submitted_resume', $_POST);
    return $this->db->insert_id();
}



public function submit_manuscript()
{

    $row = array(
      'study_type' =>$_POST['study_type'] , 
      'study_title' =>$_POST['study_title'] , 
      'abstract' =>$_POST['abstract'] , 
      'keyword' =>$_POST['keyword'] , 
      'author_name1' =>$_POST['author_name1'] , 
      'email1' =>$_POST['email1']
      );
    $this->db->insert('manuscript_submission', $row);
    $manu_id = $this->db->insert_id();
    

    foreach ($_POST['contri_name'] as $key => $value) 
    {
        $crow = array('manu_sub_id' => $manu_id ,'author_name'=> $_POST['contri_name'][$key],'author_email'=> $_POST['contri_email'][$key] );
        $this->db->insert('manuscript_contributers', $crow);
    }
    return $manu_id;
  
  
}

public function upload_file_name($applied_id,$file_name)
{
    $row = array('resume' => $file_name);
    $this->db->where('applied_id', $applied_id);
    $this->db->update('applied_for_post', $row);
}

public function upload_file_name2($applied_id,$file_name)
{
    $row = array('resume' => $file_name);
    $this->db->where('applied_id', $applied_id);
    $this->db->update('applied_for_reviewer', $row);
}

public function upload_file_name3($applied_id,$file_name)
{
    $row = array('document' => $file_name);
    $this->db->where('id', $applied_id);
    $this->db->update('publish_sell_req', $row);
}
public function upload_file_name4($applied_id,$file_name)
{
    $row = array('document' => $file_name);
    $this->db->where('id', $applied_id);
    $this->db->update('manuscript_submission', $row);
}
public function upload_file_name5($applied_id,$file_name)
{
    $row = array('resume' => $file_name);
    $this->db->where('id', $applied_id);
    $this->db->update('submitted_resume', $row);
}

public function manuscript_editing_order($order_for)
{
   $row = array(
    'speciality' =>$_POST['speciality'] , 
    'journal' =>$_POST['journal'] , 
    'journal_link' =>$_POST['journal_link'] , 
    'document_title' =>$_POST['document_title'] , 
    'farmat_figure' =>$_POST['farmat_figures'] , 
    'format_document' =>$_POST['format_document'] , 
    'special_request' => $_POST['special_req'],
    'order_for' => $order_for
    );
   $this->db->insert('manuscript_editing_orders', $row);
   return $this->db->insert_id();
}



public function manuscript_figure_order($order_for)
{
   $row = array(
    'speciality' =>$_POST['speciality'] , 
    'journal' =>$_POST['journal'] , 
    'journal_link' =>$_POST['journal_link'] , 
    'order_for' => $order_for,
    'figure_count' => $_POST['figure_count'],
    'ilu_count' => $_POST['ilu_count']
    );
   $this->db->insert('manuscript_editing_orders', $row);
   return $this->db->insert_id();
}

public function manuscript_custom_order()
{
   $row = array(
    'fname' =>$_POST['fname'] , 
    'lname' =>$_POST['lname'] , 
    'email' =>$_POST['email'] , 
    'requirement' => $_POST['requirement']
    );
   $this->db->insert('custom_quote_request', $row);
   return $this->db->insert_id();
}


public function get_sub_departments($depart)
{
  $this->db->select('departmentid');
  $this->db->where('departmentname', $depart);
  $query = $this->db->get('departments');
  $res = $query->result();
  $parent_id = $res[0]->departmentid;
  $this->db->where('parent_id', $parent_id);
  $this->db->where('status', 1);
  $query = $this->db->get('departments');
  return $query->result();
}

public function get_multimedia_article()
{
  $this->db->select('media_article.*,user.*');
  $this->db->where('media_article.status', 1);
  $this->db->join('user', 'media_article.userid = user.userid', 'left');
  $query = $this->db->get('media_article');
  return $query->result();
}

public function get_book_order_details()
{
  $this->db->select('media_article.*,user.*');
  $this->db->where('media_article.status', 1);
  $this->db->join('user', 'media_article.userid = user.userid', 'left');
  $query = $this->db->get('media_article');
  return $query->result();
}
  
public function get_storymedia_article()
{
  $this->db->select('media_stories.*,user.*');
  $this->db->where('media_stories.status', 1);
  $this->db->join('user', 'media_stories.userid = user.userid', 'left');
  $query = $this->db->get('media_stories');
  return $query->result();
}
  public function get_external_jobs()
  {
    $this->db->where('external_jobs.status', 1);
    if($this->input->get('job_function'))
    {
      $this->db->where('job_function',urldecode($_GET['job_function']));
    }
if($this->input->get('experience'))
    {
      $this->db->where('experience',urldecode($_GET['experience']));
    }
    
    $query = $this->db->get('external_jobs');
    return $query->result();
  }

public function get_external_job_desc($job_id)
{
  $this->db->where('id', $job_id);
  $query = $this->db->get('external_jobs');
  return $query->row();
}

public function add_external_job($value='')
{
  $this->db->insert('external_jobs', $_POST);
  return $this->db->insert_id();
}

public function follow_user($userid)
{
   $this->db->where('userid', $userid);
   $this->db->where('followerid', $this->session->userdata('mpuserid'));
   $query = $this->db->get('author_follower');
   if($query->num_rows())
   {
      return 0;
   }
   else
   {
     $row = array('userid' =>$userid ,'followerid' => $this->session->userdata('mpuserid'));
     $this->db->insert('author_follower', $row);
     return $this->db->insert_id();
   }

}


public function newsletter_submit($userid)
{
  $email = $_POST['email'];
   $this->db->where('email_id', $email);
   $query = $this->db->get('newsletter_subscription');
   if($query->num_rows())
   {
      return 0;
   }
   else
   {
     $row = array('email_id'=> $email);
     $this->db->insert('newsletter_subscription', $row);
     return $this->db->insert_id();
   }

}


}

/* End of file welcome_model.php */
/* Location: ./application/models/welcome_model.php */