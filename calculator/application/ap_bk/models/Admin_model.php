<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Admin_model extends CI_Model 
{
	public function __construct()
	{
		parent::__construct();
		$this->load->database();
		
	}

	public function login() 
	{
	  $this->db->where('user_name',$_POST['user_name']);
	  $this->db->where('password',md5($_POST['password']));
	  $query=$this->db->get('admin');
	  return $query->result_array();
	}

#######################          Article SECTION (Start) ##############################

public function get_all_article()
	{
  //   $this->db->select('article.*,count(article_views.*) as views_count,count(article_likes.*) as likes_count');
  //   $this->db->join('article_views', 'article.articleid = article_views.articleid', 'left');
  //   $this->db->join('article_likes', 'article.articleid = article_likes.articleid', 'left');
		// $this->db->order_by('articleid', 'desc');
		// $query = $this->db->get('article');
    $sql = "SELECT distinct `article`.*, (SELECT COUNT(*) FROM article_likes where `article_likes`.`articleid` = `article`.`articleid`) as likes_count,(SELECT COUNT(*) FROM article_views where `article_views`.`articleid` = `article`.`articleid`) as views_count FROM (`article`) LEFT JOIN `article_views` ON `article`.`articleid` = `article_views`.`articleid` LEFT JOIN `article_likes` ON `article`.`articleid` = `article_likes`.`articleid` ORDER BY `articleid` desc ";
		$query = $this->db->query($sql);
    return $query->result();
	}


public function get_user_articles($userid='')
	{
		$this->db->where('userid', $userid);
		$this->db->order_by('articleid', 'desc');
		$query = $this->db->get('article');
		return $query->result();
	}

  public function get_likes_list($articleid='')
  {
    $this->db->select('user.*,article_likes.*');
      $this->db->where('articleid', $articleid);
      $this->db->join('user', 'user.userid = article_likes.userid', 'left');
      $query = $this->db->get('article_likes');
      return $query->result();
  }

public function get_views_list($articleid='')
  {
    $this->db->select('user.*,article_views.*');
      $this->db->where('articleid', $articleid);
      $this->db->join('user', 'user.userid = article_views.userid', 'left');
      $query = $this->db->get('article_views');
      return $query->result();
  }
public function downloaded_article($userid='')
	{
		$this->db->distinct();
		$this->db->select('article.*');
		$this->db->where('downloads.userid', $userid);
		$this->db->join('article', 'article.articleid = downloads.articleid', 'left');
		$query = $this->db->get('downloads');
		return $query->result();
	}

public function get_article_detail($id)
	{
		$this->db->where('articleid', $id);
		$query = $this->db->get('article');
		return $query->row();
	}

public function get_article_documents($id)
	{
		$this->db->where('articleid', $id);
		$query = $this->db->get('uploads');
		return $query->result();
	}


public function get_file_name($id='')
{
	$this->db->where('uploadid', $id);
		$query = $this->db->get('uploads');
		return $query->row();
}

public function delete_article($id)
	{
		$this->db->where('articleid', $id);
		$this->db->delete('article');	
	}

public function deactivate_article($ques_id='')
	{
		$row = array('status' => '0');
		$this->db->where('articleid', $ques_id);
		$this->db->update('article', $row);
	}

	
public function activate_article($ques_id='')
	{
		$this->db->where('articleid', $ques_id);
		$query = $this->db->get('article');
		$row =  $query->row();
		//print_r($row);die;
		//if($row->downloadpayment == "" or $row->downloadpayment == 0)
		if(0)
		{
			$this->session->set_flashdata('msg', 'Article Has not activated yet. please fill the download price for article.');
			return 0;
		}
		else
		{
			$row = array('status' => '1');
			$this->db->where('articleid', $ques_id);
			$this->db->update('article', $row);
			return $this->db->affected_rows();
		}
		
	}

public function update_article_document($id='',$name)
	{
		$row = array(
			'document' =>$name
			);
		$this->db->where('articleid', $id);
		$this->db->update('article',$row);
	}
public function update_article_screenshot($id='',$name)
	{
		$row = array(
			'screenshot' =>$name
			);
		$this->db->where('articleid', $id);
		$this->db->update('article',$row);
	}

public function update_article_xml($id='',$name)
	{
		$row = array(
			'xml_doc' =>$name
			);
		$this->db->where('articleid', $id);
		$this->db->update('article',$row);
	}

public function update_article_detail($id='')
	{
    $data = array(

     'doi'               =>$_POST['doi'],
     'discipline'        =>$_POST['discipline'],
     'subject'           =>$_POST['subject'],
     'category'          =>$_POST['category'],
     'type'              =>$_POST['type'],
     'rdate'             =>$_POST['rdate'],
     'author'             =>$_POST['author'],
     'title'             =>$_POST['title'],
     'description'       =>$_POST['description'],
     'journal'           =>$_POST['journal'],
     'volume'            =>$_POST['volume'],
     'issue'             =>$_POST['issue'],
     'spageno'           =>$_POST['spageno'],
     'epageno'           =>$_POST['epageno'],
     'publisher'         =>$_POST['publisher'],
     'userid'            =>$_POST['userid'],
     'keyword'           =>$_POST['keyword'],
     'authoremail'       =>$_POST['authoremail'],
     'othercontributors' =>$_POST['othercontributors'],
     'orgnization'       =>$_POST['orgnization'],
     'worktype'         =>$_POST['worktype']

      );
		$this->db->where('articleid', $id);
		$this->db->update('article',$data);
    $this->db->where('article_id', $id);
    $this->db->delete('article_contributers');
    
foreach ($_POST['contri_name'] as $key => $value) 
    {
        $crow = array('article_id' => $id ,'author_name'=> $_POST['contri_name'][$key],'author_email'=> $_POST['contri_email'][$key] );
        $this->db->insert('article_contributers', $crow);
    }


	}
#######################         ADMIN FACULTY SECTION (END) ##############################

public function check_old_password()
{
	$this->db->select('password');
	$this->db->where('email_id', $this->session->userdata('admin_email'));
	$query = $this->db->get('admin');
	$pass = $query->row();

	$old = $pass->password;
	if($old == md5($_POST['password_old']))
	{
		return 1;
	}
	else
	{
		return 0;
	}
}

public function update_password()
{
	$row = array('password'=>md5($_POST['password_new']));
	$this->db->where('email_id', $this->session->userdata('admin_email'));
	$this->db->update('admin', $row);
}

public function get_page_content($value='')
{
	$this->db->where('keyword', $_GET['page']);
	$query = $this->db->get('manage_pages');
	return $query->row();	
}

public function update_page_content()
{
	$this->db->where('id', $_POST['id']);
	$row = array('content' =>$_POST['content']);
	$this->db->update('manage_pages', $row);
}

public function update_content_image($keyword,$image)
{
	$this->db->where('keyword', $keyword);
	$query = $this->db->get('page_images');
	$count = $query->num_rows();
	if($count)
	{
		$this->db->where('keyword', $keyword);
		$row = array('image' =>$image);
		$this->db->update('page_images', $row);
	}
	else
	{
		$row = array('keyword' => $keyword , 'image' =>$image);
		$this->db->insert('page_images', $row);
	}
	
}

public function get_all_users()
{
  $this->db->order_by('userid', 'desc');
  $query = $this->db->get('user');
  return $query->result();
}


public function activate_users($id)
{
  $row = $_POST;
  //print_r($_POST);die;
  $row['status'] = 1;
  $row['email_verification'] = 1;
  $this->db->where('userid', $id);
  //$this->db->where('email_verification', 1);
  $query = $this->db->update('user', $row);
  if($this->db->affected_rows() > 0)
       {
          return 1;
       }
       else
       {
         return 0;
       }


}

public function update_user_detail($userid='')
{
	$this->db->where('userid', $userid);
    $this->db->update('user', $_POST);
}

public function add_user_detail()
{
  //$this->db->where('userid', $userid);
    $this->db->insert('user', $_POST);
    return $this->db->insert_id();
}

public function update_profile_pic($id,$name)
{
  $row['profilepic'] = $name;
  $this->db->where('userid', $id);
  $this->db->update('user', $row);
}

public function update_cv($id,$name)
{
  $row['cv'] = $name;
  $this->db->where('userid', $id);
  $this->db->update('user', $row);
}

public function deactivate_user($id)
{
  $row = $_POST;
  //print_r($_POST);die;
  $row['status'] = 0;
  $this->db->where('userid', $id);
  $this->db->update('user', $row);
}

public function user_portfolio($id='')
{
	$this->db->where('userid', $id);
  $query = $this->db->get('user');
  return $query->row();
}

public function get_department($value='')
{
	$query = $this->db->get('departments');
	return $query->result();
}


public function delete_user($id)
{
  $this->db->where('userid', $id);
  $this->db->delete('user');

$this->db->where('userid', $id);
  $this->db->delete('article');

$this->db->where('userid', $id);
  $this->db->delete('downloads');

$this->db->where('userid', $id);
  $this->db->delete('uploads');
}

public function contact_leads()
{
	$query = $this->db->get('contact');
	return $query->result();
}

public function ideas()
{
	$query = $this->db->get('submitted_ideas');
	return $query->result();
}

public function get_support_tickets()
{
	$this->db->select('ost_ticket.*,ost_ticket__cdata.subject,ost_ticket_status.name,ost_help_topic.topic,ost_ticket_thread.ticket_id,count(*) as thread_count');
	if($this->input->post('status'))
	$this->db->where('ost_ticket.status_id', $this->input->post('status'));
    $this->db->join('ost_help_topic', 'ost_help_topic.topic_id = ost_ticket.topic_id', 'left');
    $this->db->join('ost_ticket__cdata', 'ost_ticket__cdata.ticket_id = ost_ticket.ticket_id', 'left');
    $this->db->join('ost_ticket_thread', 'ost_ticket_thread.ticket_id = ost_ticket.ticket_id', 'left');
    $this->db->join('ost_ticket_status', 'ost_ticket_status.id = ost_ticket.status_id', 'left');
    $this->db->group_by('ost_ticket_thread.ticket_id');
    $query = $this->db->get('ost_ticket');
    return $query->result();
}


  public function get_ticket_detail($number)
  {
    $this->db->select('ost_ticket.*,ost_ticket__cdata.subject,ost_ticket_status.name,user.fname,user.lname,user.email,ost_help_topic.topic');
    $this->db->where('ost_ticket.number', $number);
    $this->db->join('ost_ticket__cdata', 'ost_ticket__cdata.ticket_id = ost_ticket.ticket_id', 'left');
    $this->db->join('ost_help_topic', 'ost_help_topic.topic_id = ost_ticket.topic_id', 'left');
    $this->db->join('ost_ticket_status', 'ost_ticket_status.id = ost_ticket.status_id', 'left');
    $this->db->join('user', 'user.userid = ost_ticket.user_id', 'left');
    $query = $this->db->get('ost_ticket');
    return $query->row();
  }

  public function get_ticket_thread($number)
  {
    $this->db->select('ost_ticket.*');
    $this->db->where('ost_ticket.number', $number);
    $query = $this->db->get('ost_ticket');
    $data =  $query->row();

    $this->db->where('ost_ticket_thread.ticket_id', $data->ticket_id);
    $query = $this->db->get('ost_ticket_thread');
    return $query->result();
  }


public function reply_ticket($value='')
  {
     $ost_ticket_thread  = array(
                          'ticket_id' => $this->input->post('ticket_id'),
                          'staff_id' => $this->session->userdata('admin_id'),
                          'body' => $this->input->post('body'),
                          'thread_type' => "R",
                          'poster' => $this->session->userdata('admin_email')

      );

     $this->db->insert('ost_ticket_thread', $ost_ticket_thread);
     $date = new DateTime(date("Y-m-d h:i:s A"));
	 $lastresponse = $date->format('Y-m-d G:i:s') ;
     $status_id = array('status_id' => $this->input->post('status_id'),'lastresponse'=>$lastresponse,'isanswered'=>1);
     $this->db->where('ticket_id', $this->input->post('ticket_id'));
     $this->db->update('ost_ticket', $status_id);
  }

public function get_support_ticket_count_total()
  {
   $query = $this->db->get('ost_ticket');
   return $query->num_rows();
  }

  public function get_support_ticket_count_resolved($find='')
  {
    $this->db->where('status_id', 2);
    $query = $this->db->get('ost_ticket');
    return $query->num_rows();
  }

  public function get_support_ticket_count_open($find='')
  {
    $this->db->where('status_id', 1);
    $query = $this->db->get('ost_ticket');
    return $query->num_rows();
  }

  public function get_support_ticket_count_closed($find='')
  {
     $this->db->where('status_id', 3);
    $query = $this->db->get('ost_ticket');
    return $query->num_rows();
  }

  public function get_article_reprint($value='')
  {
  	$this->db->select('reprint_article_request.*, article.*,user.*');
    $this->db->join('article', 'article.articleid = reprint_article_request.article_id');
    $this->db->join('user', 'user.userid = article.userid');
  	$query = $this->db->get('reprint_article_request');
    return $query->result();
  }


  public function get_all_faqs()
{
  //$this->db->where('faqtype', '2');
  $query = $this->db->get('faq');
  return $query->result();
}


public function activate_faq($id)
{
  $row = $_POST;
  //print_r($_POST);die;
  $row['status'] = 1;
  $this->db->where('faqid', $id);
  $this->db->update('faq', $row);
}

public function update_faq_detail($faqid='')
{
	$this->db->where('faqid', $faqid);
    $this->db->update('faq', $_POST);
}

 public function add_faq_detail()
{
    $this->db->insert('faq', $_POST);
    return $this->db->insert_id();
}
   

public function deactivate_faq($id)
{
  $row = $_POST;
  //print_r($_POST);die;
  $row['status'] = 0;
  $this->db->where('faqid', $id);
  $this->db->update('faq', $row);
}





public function delete_faq($id)
{
  $this->db->where('faqid', $id);
  $this->db->delete('faq');
}

public function get_all_books()
{
  //$this->db->where('booktype', '2');
  $query = $this->db->get('books');
  return $query->result();
}


public function activate_book($id)
{
  //print_r($_POST);die;
  $row['status'] = 1;
  $this->db->where('bookid', $id);
  $this->db->update('books', $row);
}

public function update_book_detail($bookid='')
{
	$row=array(
 'book_title'=>$_POST['book_title'],
     'sub_title'=>$_POST['sub_title'],
     'speciality'=>$_POST['department'],
     'author'=>$_POST['author'],
     'price'=>$_POST['price'],
     'about'=>$_POST['profile_desc'],
     'isbn'=>$_POST['isbn'],
     'isbn_ebook'=>$_POST['isbn_ebook'],
     'isbn_soft'=>$_POST['isbn_soft'],
     'doi'=>$_POST['doi'],
     'book_format'=>$_POST['book_format'],
     'copyright'=>$_POST['copyright'],
     'publisher'=>$_POST['publisher'],
     'copyright_holder'=>$_POST['copyright_holder'],
     'edition'=>$_POST['edition'],
     'pages'=>$_POST['pages']);
	  $this->db->where('bookid', $bookid);
    $this->db->update('books',$row);

    $this->db->where('bookid', $bookid);
    $this->db->delete('book_toc');

  foreach ($_POST['contri_title'] as $key => $value) 
  {
      $trow =array(
        'content_title'=>$_POST['contri_title'][$key],
        'subtitle'=>$_POST['contri_subtitle'][$key],
        'pages'=>$_POST['contri_pages'][$key],
        'bookid'=>$bookid
        );
      $this->db->insert('book_toc', $trow);
  }
}

public function get_book_detail($bookid='')
{
  $this->db->where('bookid', $bookid);
  $query =   $this->db->get('books');
  return $query->row();
}


public function get_book_toc($bookid='')
{
  $this->db->where('bookid', $bookid);
  $query =   $this->db->get('book_toc');
  return $query->result();
}



 public function add_book_detail()
{
	$row=array(
     'book_title'=>$_POST['book_title'],
     'sub_title'=>$_POST['sub_title'],
     'speciality'=>$_POST['department'],
     'author'=>$_POST['author'],
     'price'=>$_POST['price'],
     'about'=>$_POST['profile_desc'],
     'isbn'=>$_POST['isbn'],
     'isbn_ebook'=>$_POST['isbn_ebook'],
     'isbn_soft'=>$_POST['isbn_soft'],
     'doi'=>$_POST['doi'],
     'book_format'=>$_POST['book_format'],
     'copyright'=>$_POST['copyright'],
     'publisher'=>$_POST['publisher'],
     'copyright_holder'=>$_POST['copyright_holder'],
     'edition'=>$_POST['edition'],
     'pages'=>$_POST['pages']);

    $this->db->insert('books', $row);

    $bookid =  $this->db->insert_id();
    foreach ($_POST['contri_title'] as $key => $value) 
      {
          $trow =array(
            'content_title'=>$_POST['contri_title'][$key],
            'subtitle'=>$_POST['contri_subtitle'][$key],
            'pages'=>$_POST['contri_pages'][$key],
            'bookid'=>$bookid
            );
          $this->db->insert('book_toc', $trow);
      }

      return $bookid;

}
   

public function deactivate_book($id)
{
  $row = $_POST;
  //print_r($_POST);die;
  $row['status'] = 0;
  $this->db->where('bookid', $id);
  $this->db->update('books', $row);
}

public function update_books_image($id='',$name)
{
	$row=array('image'=> $name);
	$this->db->where('bookid', $id);
	$this->db->update('books', $row);
}



public function delete_book($id)
{
  $this->db->where('bookid', $id);
  $this->db->delete('books');
}

public function get_all_events()
{
  //$this->db->where('eventtype', '2');
  $query = $this->db->get('events');
  return $query->result();
}


public function activate_event($id)
{
  //print_r($_POST);die;
  $row['status'] = 1;
  $this->db->where('eventid', $id);
  $this->db->update('events', $row);
}

public function update_event_detail($eventid='')
{
	$row=array(
  'link' => $_POST['link'],
  'event_title' => $_POST['event_title'],
  'event_date' => $_POST['event_date'],
  'short_desc' => $_POST['short_desc']
  );
	$this->db->where('eventid', $eventid);
    $this->db->update('events',$row);
}

 public function add_event_detail()
{
	$row=array(
  'link' => $_POST['link'],
  'event_title' => $_POST['event_title'],
  'event_date' => $_POST['event_date'],
  'short_desc' => $_POST['short_desc']
  );
    $this->db->insert('events', $row);
    return $this->db->insert_id();
}
   

public function deactivate_event($id)
{
  $row = $_POST;
  //print_r($_POST);die;
  $row['status'] = 0;
  $this->db->where('eventid', $id);
  $this->db->update('events', $row);
}

public function update_events_image($id='',$name)
{
	$row=array('image'=> $name);
	$this->db->where('eventid', $id);
	$this->db->update('events', $row);
}



public function delete_event($id)
{
  $this->db->where('eventid', $id);
  $this->db->delete('events');
}

public function get_all_ngos()
{
  //$this->db->where('ngotype', '2');
  $query = $this->db->get('ngos');
  return $query->result();
}


public function activate_ngo($id)
{
  //print_r($_POST);die;
  $row['status'] = 1;
  $this->db->where('ngoid', $id);
  $this->db->update('ngos', $row);
}

public function update_ngo_detail($ngoid='')
{
	$row=array(
  'link' => $_POST['link'],
  'event_title' => $_POST['event_title'],
  'short_desc' => $_POST['short_desc']
  );
	$this->db->where('eventid', $ngoid);
    $this->db->update('ngos',$row);
}

 public function add_ngo_detail()
{
	$row=array(
  'link' => $_POST['link'],
  'event_title' => $_POST['event_title'],
  'short_desc' => $_POST['short_desc']
  );
    $this->db->insert('ngos', $row);
    return $this->db->insert_id();
}
   

public function deactivate_ngo($id)
{
  $row = $_POST;
  //print_r($_POST);die;
  $row['status'] = 0;
  $this->db->where('eventid', $id);
  $this->db->update('ngos', $row);
}

public function update_ngos_image($id='',$name)
{
	$row=array('image'=> $name);
	$this->db->where('eventid', $id);
	$this->db->update('ngos', $row);
}



public function delete_ngo($id)
{
  $this->db->where('eventid', $id);
  $this->db->delete('ngos');
}


public function get_all_institutions()
{
  $query = $this->db->get('institutions');
  return $query->result();
}


public function activate_institution($id)
{
  //print_r($_POST);die;
  $row['status'] = 1;
  $this->db->where('eventid', $id);
  $this->db->update('institutions', $row);
}

public function update_institution_detail($eventid='')
{
  $row=array(
  'link' => $_POST['link'],
  'event_title' => $_POST['event_title'],
  'short_desc' => $_POST['short_desc']
  );
  $this->db->where('eventid', $eventid);
    $this->db->update('institutions',$row);
}

 public function add_institution_detail()
{
  $row=array(
  'link' => $_POST['link'],
  'event_title' => $_POST['event_title'],
  'short_desc' => $_POST['short_desc']
  );
    $this->db->insert('institutions', $row);
    return $this->db->insert_id();
}
   

public function deactivate_institution($id)
{
  $row = $_POST;
  //print_r($_POST);die;
  $row['status'] = 0;
  $this->db->where('eventid', $id);
  $this->db->update('institutions', $row);
}

public function update_institutions_image($id='',$name)
{
  $row=array('image'=> $name);
  $this->db->where('eventid', $id);
  $this->db->update('institutions', $row);
}



public function delete_institution($id)
{
  $this->db->where('eventid', $id);
  $this->db->delete('institutions');
}


public function get_all_promos()
{
  //$this->db->where('promotype', '2');
  $query = $this->db->get('promo_codes');
  return $query->result();
}


public function activate_promo($id)
{
  //print_r($_POST);die;
  $row['status'] = 1;
  $this->db->where('id', $id);
  $this->db->update('promo_codes', $row);
}

public function update_promo_detail($id='')
{
  $row=array('code' => $_POST['code']);
  $this->db->where('id', $id);
    $this->db->update('promo_codes',$row);
}

 public function add_promo_detail()
{
  $row=array('code' => $_POST['code']);
    $this->db->insert('promo_codes', $row);
    return $this->db->insert_id();
}
   

public function deactivate_promo($id)
{
  $row = $_POST;
  //print_r($_POST);die;
  $row['status'] = 0;
  $this->db->where('id', $id);
  $this->db->update('promo_codes', $row);
}

public function update_promos_image($id='',$name)
{
  $row=array('image'=> $name);
  $this->db->where('id', $id);
  $this->db->update('promo_codes', $row);
}



public function delete_promo($id)
{
  $this->db->where('id', $id);
  $this->db->delete('promo_codes');
}

public function get_all_job_posts()
{
   $sql = "SELECT distinct `job_posting`.*, (SELECT COUNT(*) FROM applied_for_post where `applied_for_post`.`job_post_id` = `job_posting`.`job_id`) as response_count FROM (`job_posting`) LEFT JOIN `applied_for_post` ON `job_posting`.`job_id` = `applied_for_post`.`job_post_id`  ORDER BY `job_id` desc ";
    $query = $this->db->query($sql);
    return $query->result();
  $query = $this->db->get('job_posting');
  return $query->result();
}


public function activate_job_post($id)
{
  //print_r($_POST);die;
  $row['status'] = 1;
  $this->db->where('job_id', $id);
  $this->db->update('job_posting', $row);
}

public function update_job_post_detail($id='')
{
  $row=array('code' => $_POST['code']);
  $this->db->where('job_id', $id);
    $this->db->update('job_posting',$_POST);
}

 public function add_job_post_detail()
{
  $row=array('code' => $_POST['code']);
    $this->db->insert('job_posting', $row);
    return $this->db->insert_id();
}
   

public function deactivate_job_post($id)
{
  $row = $_POST;
  //print_r($_POST);die;
  $row['status'] = 0;
  $this->db->where('job_id', $id);
  $this->db->update('job_posting', $row);
}

public function update_job_posts_image($id='',$name)
{
  $row=array('image'=> $name);
  $this->db->where('job_id', $id);
  $this->db->update('job_posting', $row);
}



public function delete_job_post($id)
{
  $this->db->where('job_id', $id);
  $this->db->delete('job_posting');
}

public function get_all_job_post_applications($job_id)
{
   $this->db->where('job_post_id', $job_id);
   $query = $this->db->get('applied_for_post');
   return $query->result();
}

public function delete_job_post_application($applied_id)
{
  $this->db->where('applied_id', $applied_id);
  $this->db->delete('applied_for_post');
}

public function get_all_reviewer_applications()
{
   $query = $this->db->get('applied_for_reviewer');
   return $query->result();
}

public function delete_reviewer_application($applied_id)
{
  $this->db->where('applied_id', $applied_id);
  $this->db->delete('applied_for_reviewer');
}

public function get_all_publish_sell_applications()
{
  $this->db->select('publish_sell_book_request.*, user.*');
   $this->db->join('user', 'user.userid = publish_sell_book_request.userid', 'left');
   $query = $this->db->get('publish_sell_book_request');
   return $query->result();
}

public function delete_publish_sell_application($applied_id)
{
  $this->db->where('applied_id', $applied_id);
  $this->db->delete('publish_sell_req');
}


public function get_all_manuscript_orders()
{
  $query = $this->db->get('manuscript_editing_orders');
  return $query->result();
}


public function manuscript_order_info($value='')
{
   $this->db->where('order_id', $value );
   $query = $this->db->get('manuscript_editing_orders');
  return $query->row();
}

public function get_all_custom_manuscript_orders()
{
  $query = $this->db->get('custom_quote_request');
  return $query->result();
}
public function custom_manuscript_order_info($value='')
{
   $this->db->where('id', $value );
   $query = $this->db->get('custom_quote_request');
  return $query->row();
}


public function get_contributers($articleid='')
{
   
  $this->db->where('article_id', $articleid );
  $query = $this->db->get('article_contributers');
  return $query->result();

}


public function get_all_external_job_posts()
{
  $query = $this->db->get('external_jobs');
  return $query->result();
}


public function activate_external_job_post($id)
{
  $row['status'] = 1;
  $this->db->where('id', $id);
  $this->db->update('external_jobs', $row);
}

public function deactivate_external_job_post($id)
{
  $row = $_POST;
  //print_r($_POST);die;
  $row['status'] = 0;
  $this->db->where('id', $id);
  $this->db->update('external_jobs', $row);
}

public function delete_external_job_post($id)
{
  $this->db->where('id', $id);
  $this->db->delete('external_jobs');
}



}

/* End of file admin_model.php */
/* Location: ./application/models/admin_model.php */