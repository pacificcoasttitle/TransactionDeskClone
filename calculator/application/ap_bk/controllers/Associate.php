<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Associate extends CI_Controller {

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
		$this->load->library('email');
		$this->load->library('session');
		$this->load->helper('url');
		$this->load->helper('form');
		$this->load->library('cart');
		$this->load->model('associate_model');
		$this->load->database();
	}

 #######################         ADMIN INDEX PAGE ##############################


	public function index()
	{
		if($this->session->userdata('asso_email'))	
		{   
			redirect('associate/dashboard');
		}
		else
		{
			$this->load->view('associate/login');
		}
	}

#######################         ADMIN LOGIN PAGE ##############################


	public function checklogin()
	{
		$query=$this->associate_model->login();
		//print_r($query);die;
		if(sizeof($query)>0)
		{
			$data=array(
				'asso_id'=>$query[0]['id'],
				'asso_email'=>$query[0]['username'],
				'asso_name'=>$query[0]['name'],
				'asso_ref_id'=>$query[0]['ref_id']
				);
			$this->session->set_userdata($data);
			redirect('associate/dashboard');
		}
		else
		{
			redirect('associate/index?status=0');
		}
	}
 #######################         ADMIN dashboard PAGE ##############################
	public function dashboard()
	{
		//print_r(date("h:i:s a"));die;
		if($this->session->userdata('asso_email'))	
		{   
			$data['active'] = "dashboard";
			$data['users_count'] = $this->associate_model->get_user_count();
			$data['prod_count'] = $this->associate_model->get_product_count();
			$this->load->view('associate/header',$data);
			$this->load->view('associate/dashboard',$data);
			$this->load->view('associate/footer',$data);
		}
		else
		{
			redirect('associate/index');
		}
	}

	

public function users($value='')
	{
		if($this->session->userdata('asso_email'))	
		{   
			$data['active'] = "users";
			$data['page_head'] = "Users";
			$data['action'] = "Users";
			$data['associates'] = $this->associate_model->get_users();
			$this->load->view('associate/header',$data);
			$this->load->view('associate/associates',$data);
			$this->load->view('associate/footer',$data);
		}
		else
		{
			redirect('associate/index');
		}
	}



	public function add_associate()
	{
		if($this->session->userdata('asso_email'))	
		{   
			if($this->input->post('salutation'))
			{
				$_SESSION['stat']=1;
				$this->get_available_parent($_POST['parent_ref_id'],0);
				$val = $_SESSION['parent_id'];
				if($val != "FALSE")
				{
					$this->associate_model->add_user($val);
					$this->session->set_flashdata('msg', 'Details has been Added.');
					redirect('associate/associates','refresh');
				}
				else
				{
					$this->session->set_flashdata('msg', 'Levels are completed for this parent ID.');
					redirect('associate/associates','refresh');
				}
				
				
			}
			else
			{
				$data['active'] = "associate";
				$data['page_head'] = "Add Associate";
				$data['countries'] = $this->associate_model->get_countries();
				$data['states'] = $this->associate_model->get_states();
				$data['cities'] = $this->associate_model->get_cities();
				$data['category'] = $this->associate_model->get_all_categories();
				$this->load->view('associate/header',$data);
				$this->load->view('associate/add_user',$data);
				$this->load->view('associate/footer',$data);
			}
			
		}
		else
		{
			redirect('associate/index');
		}
	}

public function mlm_conf()
	{
		if($this->session->userdata('asso_email'))	
		{   
			if($this->input->post('maximum_allowed_levels'))
			{
				$this->associate_model->update_mlm_info();
				$this->session->set_flashdata('msg', 'Details has been updated.');
				redirect('associate/mlm_conf','refresh');
			}
			else
			{
				$data['active'] = "mlm";
				$data['page_head'] = "Tree Configuration";
				$data['mlm_info'] = $this->associate_model->get_mlm_info();
				$this->load->view('associate/header',$data);
				$this->load->view('associate/mlm_conf',$data);
				$this->load->view('associate/footer',$data);
			}
			
		}
		else
		{
			redirect('associate/index');
		}
	}



	public function edit_associate($id)
	{
		if($this->session->userdata('asso_email'))	
		{   
			
				$data['active'] = "associate";
				$data['page_head'] = "Edit Associate";
				$data['countries'] = $this->associate_model->get_countries();
				$data['states'] = $this->associate_model->get_states();
				$data['cities'] = $this->associate_model->get_cities();
				$data['user_info'] = $this->associate_model->get_user_info($id);
				$this->load->view('associate/header',$data);
				$this->load->view('associate/edit_user',$data);
				$this->load->view('associate/footer',$data);
		
		}
		else
		{
			redirect('associate/index');
		}
	}


public function add_user()
	{
		if($this->session->userdata('asso_email'))	
		{  
		  
			if($this->input->post('salutation'))
			{ 
				$stat =  $this->check_adding_allowed($_POST['total_amount']);
				if ($stat) 
				{
					$_SESSION['stat']=1;
					$this->get_available_parent($_POST['parent_ref_id'],0);
					$val = $_SESSION['parent_id'];
					if($val != "FALSE")
					{
						$this->associate_model->add_user($val);
						$this->session->set_flashdata('msg', 'Details has been Added.');
						redirect('associate/users','refresh');
					}
					else
					{
						$this->session->set_flashdata('msg', 'Levels are completed for this parent ID.');
						redirect('associate/users','refresh');
					}
				}
				else
				{
					$this->session->set_flashdata('msg', 'Adding amount is beyond credit limit.Please Contact Admin.');
					redirect('associate/users','refresh');
				}
						
				
			}
			else
			{
				$data['active'] = "user";
				$data['page_head'] = "Add User";
				$data['countries'] = $this->associate_model->get_countries();
				$data['states'] = $this->associate_model->get_states();
				$data['cities'] = $this->associate_model->get_cities();
				$data['category'] = $this->associate_model->get_all_categories();
				$this->load->view('associate/header',$data);
				$this->load->view('associate/add_user',$data);
				$this->load->view('associate/footer',$data);
			}
				}
			
		
		else
		{
			redirect('associate/index');
		}
	}


	public function edit_user($id)
	{
		if($this->session->userdata('asso_email'))	
		{   
			
				$data['active'] = "user";
				$data['page_head'] = "Edit User";
				$data['countries'] = $this->associate_model->get_countries();
				$data['states'] = $this->associate_model->get_states();
				$data['cities'] = $this->associate_model->get_cities();
				$data['user_info'] = $this->associate_model->get_user_info($id);
				$this->load->view('associate/header',$data);
				$this->load->view('associate/edit_user',$data);
				$this->load->view('associate/footer',$data);
		
		}
		else
		{
			redirect('associate/index');
		}
	}




	public function update_user($userid)
	{
		if($this->session->userdata('asso_email'))	
		{   

			$this->associate_model->update_user($userid);
			$this->session->set_flashdata('msg', 'Details has been updated.');
			redirect('associate/edit_profile','refresh');
		}
		else
		{
			redirect('associate/index');
		}
	}

	public function activate_user($id,$active)
	{
		if($this->session->userdata('asso_email'))	
		{ 
			$this->associate_model->activate_user($id);
			$this->session->set_flashdata('msg', 'Details Has been activated.');
			redirect('associate/'.$active.'s');
		}
		else
		{
			redirect('associate/index');
		}
	}

	public function deactivate_user($id,$active)
	{
		if($this->session->userdata('asso_email'))	
		{ 
			$this->associate_model->deactivate_user($id);
			$this->session->set_flashdata('msg', 'Details Has been deactivated.');
			redirect('associate/'.$active.'s');
		}
		else
		{
			redirect('associate/index');
		}
	}
	
public function delete_user($id,$active)
	{
		if($this->session->userdata('asso_email'))	
		{ 
			$this->associate_model->delete_user($id);
			//$this->rrmdir("upload/user/".$id);
			$this->session->set_flashdata('msg', 'Details Has been deleted.');
			redirect('associate/'.$active.'s');
		}
		else
		{
			redirect('associate/index');
		}
	}


	public function logout()
	{
		$this->session->unset_userdata('asso_email');
		redirect('associate/index');
	}

public function get_city_list($state_id)
     {
     	$html = " <option>Select City</option>";
     	$data = $this->associate_model->get_city_list($state_id);
     	//print_r($data);
     	foreach ($data as $key) 
     	{
     		$html .= "<option value='".$key->city."'>".$key->city."</option>";
     	}
     	print_r($html);
     }


public function check_ref_id()
{
	$ref_id = $_GET['ref_id'];
	$stat = $this->associate_model->check_ref_id($ref_id);
	if($stat)
	{
		$_SESSION['stat']=1;
		$this->get_available_parent($ref_id,0);
		if($_SESSION['parent_id'] != "FALSE")
		print $stat;
	else
		print_r("#");
	}
	else
	{
		print $stat;
	}
	
}

public function check_availability_email()
{
	$email = $_GET['email'];
	$stat = $this->associate_model->check_availability_email($email);
	if($stat)
	{
		print_r('0');
	}
	else
	{
		print_r('1');
	}
}


public function pricing()
{
	
		if($this->session->userdata('asso_email'))	
		{   

			if(isset($_POST['level']))
			{
				$this->associate_model->update_level_pricing();
				$this->session->set_flashdata('msg', 'Details has been Added.');
				redirect('associate/pricing','refresh');
			}
			else
			{
				$data['active'] = "pricing";
				$data['page_head'] = "Pricing Per Level ";
				$data['max_level'] = $this->associate_model->get_max_level();
				$data['pricing'] = $this->associate_model->get_level_pricing();
				$this->load->view('associate/header',$data);
				$this->load->view('associate/level_pricing',$data);
				$this->load->view('associate/footer',$data);
			}
			
		}
		else
		{
			redirect('associate/index');
		}
	
}

public function generate_tree()
{
	   
	$data['active'] = "tree";
	$data['user_references'] = $this->associate_model->get_user_referece_ids();
	$data['user_info'] = $this->associate_model->get_user_info($this->session->userdata('asso_id'));
	$this->load->view('associate/tree',$data);
			
}


public function get_available_parent($parent_id,$i=0)
{
	  $i = $i;
	 $c = $this->associate_model->get_max_child_per_level();
	  $l = $this->associate_model->get_max_level();


if($_SESSION['stat'] == 1)
{
	for (; $i < $l ;$i++) 
	{ 
		
		//print_r("<br>");
		$c_count = $this->associate_model->get_child_count($parent_id);
		$child_ids = $this->associate_model->get_child_ids($parent_id);//print_r($child_ids);
		if($c_count < $c && $l >= $i && $_SESSION['stat'] == 1)
		{
			$parent_id =  $parent_id;
			$abc = array('parent_id' => $parent_id);
			$this->session->set_userdata($abc);
			$_SESSION['stat'] = "0";
			break ;
		}
		elseif($_SESSION['stat'] == 1)
		{
			$abc = array('parent_id' => "FALSE");
			$this->session->set_userdata($abc);
		    $_SESSION['stat'] = $_SESSION['stat'];
			foreach ($child_ids as $key)
			{
				 $c_count2 = $this->associate_model->get_child_count($key->ref_id);
		         //$child_ids2 = $this->associate_model->get_child_ids($key->ref_id);
		         
		        if($c_count2 < $c && $l > $i+1 && $_SESSION['stat'] == 1)
				{
					//print_r($key->ref_id);
				    $parent_id = $key->ref_id;
					$abc = array('parent_id' => $parent_id);
					$this->session->set_userdata($abc);
					$_SESSION['stat'] = "0";
					break;
				}
			}
			//print_r($_SESSION['stat']);
			if($_SESSION['stat'] == 1)
			{
				foreach ($child_ids as $key2)
				{
					$this->get_available_parent($key2->ref_id,$i+1);
				}
				//break;
			}
			else
			{
				//print_r($_SESSION);
			}
			

		}
	}
}



}


public function tree()
{
	
		if($this->session->userdata('asso_email'))	
		{   

			
				
				$this->load->view('associate/header',$data);
				$this->load->view('associate/generate_tree',$data);
				$this->load->view('associate/footer',$data);
			
			
		}
		else
		{
			redirect('associate/index');
		}
}


  public function product_types()
     {
     	if($this->session->userdata('asso_email'))	
		{
			if(isset($_POST['type_name']))
			{
				$this->associate_model->add_product_type();
				$this->session->set_flashdata('msg', 'New Category has been added.');
				redirect('associate/product_types');
			}
			if(isset($_POST['type_name_edit']))
			{
				$this->associate_model->edit_product_type();
				$this->session->set_flashdata('msg', 'Category has been updated.');
				redirect('associate/product_types');
			}
			$data['category'] = $this->associate_model->get_all_categories();
			$data['active'] = "product_types";
			$this->load->view('associate/header',$data);
			$this->load->view('associate/product_types',$data);
			$this->load->view('associate/footer',$data);

		}
		else
		{
			redirect('associate/index');
		}
     }

public function delete_product_type($id)
     {
     	if($this->session->userdata('asso_email'))	
		{
			$this->session->set_flashdata('msg', 'Category has been deleted.');	
			$this->associate_model->delete_product_type($id);
			redirect('associate/product_types');
		}
		else
		{
			redirect('associate/index');
		}
     }


public function manage_product()
	{
		if($this->session->userdata('asso_email'))	
		{
			$data['active'] = "manage_product";
			$data['products'] = $this->associate_model->manage_product();
			$data['category'] = $this->associate_model->get_all_categories();
			$this->load->view('associate/header',$data);
			$this->load->view('associate/manage_product',$data);
			$this->load->view('associate/footer',$data);
		}
		else
		{
			redirect('associate/index');
		}
		
	}
	public function deleteproduct($id)
	{
		if($this->session->userdata('asso_email'))	
		{
			$this->associate_model->deleteproduct($id);
			redirect('associate/manage_product');
		}
		else
		{
			redirect('associate/index');
		}

	}	
	public function verifyproduct($id)
	{
		if($this->session->userdata('asso_email'))	
		{
			$this->associate_model->verifyproduct($id);
			redirect('associate/manage_product');
		}
		else
		{
			redirect('associate/index');
		}

	}	
	public function unverifyproduct($id)
	{
		if($this->session->userdata('asso_email'))	
		{
			$this->associate_model->unverifyproduct($id);
			redirect('associate/manage_product');
		}
		else
		{
			redirect('associate/index');
		}

	}	


  public function product_detail($p_id,$store_id="")
        {
          
          if($this->session->userdata('mpstoreid'))
          {
            $store_id = $this->session->userdata('mpstoreid');
          }

           $product_detail = $this->associate_model->get_product_detail($store_id,$p_id);
            $info = $product_detail[0];
            $category = $this->associate_model->get_all_categories();
            $html = '
            <div class="modal-dialog">
             <div class="modal-content">
             <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
               <h4 class="modal-title">View Product Details </h4>
            </div>
           <div class="modal-body">
            <div class="row" style="height:400px;overflow-Y:scroll;">
            <table cellpadding="0" cellspacing="0" width="100%" class="sOrders table">
            <thead>
                <tr><th width="40%">Property</th> <th>Value</th> </tr>       
                </thead>
                <tbody>
                <tr><td>Product Name</td><td>'.$info->product_name.'</td></tr>';
                foreach ($category as $key) 
                {
                  if($key->category_id == $info->cat_id )
                  {
                      $html .= ' <tr><td>Category</td><td>'.$key->category_name.'</td></tr>';
                  }
                  elseif($info->cat_id == 0)
                  {
                    $html .= ' <tr><td>Category</td><td>N/A</td></tr>';
                  }
                }
                foreach ($category as $key) 
                {
                  if($key->category_id == $info->sub_catid1 )
                  {
                      $html .= ' <tr><td>Sub Category (1)</td><td>'.$key->category_name.'</td></tr>';
                  }
                  elseif($info->sub_catid1 == 0)
                  {
                    $html .= ' <tr><td>Sub Category (1)</td><td>N/A</td></tr>';
                    break;
                  }
                }
                foreach ($category as $key) 
                {
                  if($key->category_id == $info->sub_catid2 )
                  {
                      $html .= ' <tr><td>Sub Category (2)</td><td>'.$key->category_name.'</td></tr>';
                  }
                 elseif($info->sub_catid2 == 0)
                  {
                    $html .= ' <tr><td>Sub Category (2)</td><td>N/A</td></tr>';
                    break;
                  }
                }
                foreach ($category as $key) 
                {
                  if($key->category_id == $info->sub_catid3 )
                  {
                      $html .= ' <tr><td>Sub Category (3)</td><td>'.$key->category_name.'</td></tr>';
                  }
                  elseif($info->sub_catid3 == 0)
                  {
                    $html .= ' <tr><td>Sub Category (3)</td><td>N/A</td></tr>';
                    break;
                  }
                }
                $html .='<tr><td>Product Description</td><td>'.$info->description.'</td></tr>
                <tr><td>Product Shipping Cost</td><td>'.$info->shipping_cost.'</td></tr>
                <tr><td>Product Selling Cost</td><td>'.$info->selling_price.'</td></tr>
                <tr><td>Product Quantity</td><td>'.$info->quantity.'</td></tr>
                </tbody>
                </table>';
                $img = "";
                $images = $this->associate_model->get_images($p_id);
                //print_r($images);die;
              foreach ($images as $key){
                 
              $html = $html .'<label for="id<?=$key->id?>"> <img src="'.base_url().'upload/store/'.$info->store_id.'/'.$info->product_id.'/'.$key->image_name.'" width="70" height="70"/> </label>';

              }
             
           $html = $html.' </div>
            </div>
            <div class="modal-footer">
            <button aria-hidden="true" data-dismiss="modal" class="btn btn-danger">Close</button>            
            </div>
            </div>
            </div>


    ';
            
            print_r($html);


        
      }


       public function product_edit($p_id,$store_id="")
        {
          
         
           $product_detail = $this->associate_model->get_product_detail($store_id,$p_id);
           $this->load->model('associate_model');
        $data = $this->associate_model->show_custom_feilds($product_detail[0]->cat_id,$product_detail[0]->sub_catid1,$product_detail[0]->sub_catid2,$product_detail[0]->sub_catid3);
        //print_r($product_detail[0]->cat_id);
        $html = "";
        $i = 1;
        foreach ($data as $key => $value) 
        {
          switch ($value['type']) 
          {
            case 'text':
             $html .= '<div class="form-group clearfix">
                            <label class="col-lg-3">'.$value['discription'].':</label>
                            <div class="col-lg-9"><input class="form-control" type="text" name = "'.$value['field_name'].'" value="'.$product_detail[0]->$value['field_name'].'" required></div>
                        </div>';
              break;
              case 'number':
             $html .= '<div class="form-group clearfix">
                            <label class="col-lg-3">'.$value['discription'].':</label>
                            <div class="col-lg-9"><input class="form-control" type="number" name = "'.$value['field_name'].'" value="'.$product_detail[0]->$value['field_name'].'" required></div>
                        </div>';
              break;
              case 'select':
              $html .= ' <div class="form-group clearfix">
                            <label class="col-lg-3">'.$value['discription'].':</label>
                            <div class="col-lg-9">
                             
                            <select class="form-control" name = "'.$value['field_name'].'" >
                            <option value=""> -- Select one -- </option>';
                            $ex = explode(":", $value['value']);
                                 foreach ($ex as $key){
                                 	if($key == $product_detail[0]->$value['field_name'])
                                 	{
                                 		$html .='<option selected = "true">'.$key.'</option>';
                                 	}
                                 	else{
                                       $html .='<option >'.$key.'</option>';
                                   }
                               }
                            $html .='</select>
                            
                             </div>
                        </div>';
              break;
              case 'radio':
              $html .= ' <div class="form-group clearfix">
                            <label class="col-lg-3">'.$value['discription'].':</label>
                            <div class="col-lg-9">
                             ';
                            $ex = explode(":", $value['value']);
                                 foreach ($ex as $key){

                                 	if($key == $product_detail[0]->$value['field_name'])
                                 	{
                                 		$html .='<label class="radio-inline">
                                          <input type="radio" name = "'.$value['field_name'].'" id="input" value="'.$key.'" checked="checked">
                                          '.$key.'
                                      </label>';
                                 	}
                                 	else{
                                      $html .='<label class="radio-inline">
                                          <input type="radio" name = "'.$value['field_name'].'" id="input" value="'.$key.'" >
                                          '.$key.'
                                      </label>';
                                   }
                                   
                               }
                            $html .='
                            
                             </div>
                        </div>';
              break;
              case 'checkbox':
              $html .= ' <div class="form-group clearfix">
                            <label class="col-lg-3">'.$value['discription'].':</label>
                            <div class="col-lg-9">
                             ';
                            $ex = explode(":", $value['value']);
                                 foreach ($ex as $key){
                                 		if($key == $product_detail[0]->$value['field_name'])
                                 	{
                                 		 $html .='<label class="checkbox-inline">
                                          <input type="checkbox" name = "'.$value['field_name'].'" id="input" value="'.$key.'" checked="true">
                                          '.$key.'
                                      </label>';
                                 	}
                                 	else{
                                        $html .='<label class="checkbox-inline">
                                          <input type="checkbox" name = "'.$value['field_name'].'" id="input" value="'.$key.'" >
                                          '.$key.'
                                      </label>';
                                   }

                                      
                                   
                               }
                            $html .='
                            
                             </div>
                        </div>';
              break;
              case 'textarea':
              $html .= ' <div class="form-group clearfix">
                            <label class="col-lg-3">'.$value['discription'].':</label>
                            <div class="col-lg-9">
                             ';
                            $ex = explode(":", $value['value']);
                                 foreach ($ex as $key){
                                       $html .='<textarea  id = "texteditor" class="form-control ckeditor" name = "'.$value['field_name'].'">
                                     '.$product_detail[0]->$value['field_name'].'</textarea>';
                                   
                               }
                            $html .='
                            
                             </div>
                        </div>';
              break;
            
            default:
              # code...
              break;
          }
          $i += 1;
        }
           $prod_images = $this->associate_model->get_product_images($product_detail[0]->product_id);
           $array=array();
           foreach ($prod_images as $value)
           {
               $array[]=$value;
           }
          
           $countimage=count($prod_images);
           
           $info = $product_detail[0];
           $img=array('images'=>$array,'imagecount'=>$countimage,'no_of_image_limit'=>3,'custom_fields'=>$html);
           $res=array_merge((array)$info,(array)$img);
           echo json_encode($res);


        
      }

      public function img_delete($id,$store_id,$product_id,$name)
      {
          $img=$this->associate_model->img_delete($id);
          unlink('upload/store/'.$store_id."/".$product_id."/".$name);
          print 1;
      }


      public function product_update($id)
      {
          
          $id = $_POST['product_id'];
          $product_detail = $this->associate_model->get_product_detail($store_id=0,$id);
          $store_id = $product_detail[0]->store_id;
          //echo "<pre>" ;print_r($store_id);die;
          $this->associate_model->product_update($_POST,$id);

          for($i=0;$i<=sizeof($_FILES["userfile"]["name"]);$i++)
            {
                 if ($_FILES["userfile"]["error"][$i] > 0)
                    {
                      //echo "Error: " . $_FILES["userfile"]["error"][$i] . "<br>";
                    }
                  else
                    {
                    //echo "Upload: " . $_FILES["userfile"]["name"][$i] . "<br>";
                    //echo "Type: " . $_FILES["userfile"]["type"][$i] . "<br>";
                    //echo "Size: " . ($_FILES["userfile"]["size"][$i] / 1024) . " kB<br>";
                    
                    $ext = end(explode('.', $_FILES["userfile"]["name"][$i]));
                    
                    $un =  uniqid();
                    $path = "upload/store/";
 
                    if(!is_dir($path)){
                      mkdir($path);
                    }

                   $path = "upload/store/".$store_id;
 
                    if(!is_dir($path)){
                      mkdir($path);
                    }

                     $path = "upload/store/".$store_id."/".$id;
                    if(!is_dir($path)){
                      mkdir($path);
                    }
                      /* new file name */
                      if($_FILES["userfile"]["name"][$i] != "")
                      {
                      $path = 'upload/store/'.$store_id.'/'.$id.'/'.$_FILES['userfile']['name'][$i];
                       if (file_exists("upload/store/".$store_id."/".$id."/" . $_FILES["userfile"]["name"][$i]))
                        {
                        //echo $_FILES["userfile"]["name"][$i] . " already exists. ";
                        $_FILES["userfile"]["name"][$i] = $un.".".$ext;
                        }
                  $path = 'upload/store/'.$store_id.'/'.$id.'/'.$_FILES['userfile']['name'][$i];

                        move_uploaded_file($_FILES["userfile"]["tmp_name"][$i],
                         $path);
                        //echo "Stored in: " . "upload/" . $_FILES["userfile"]["name"][$i];
                        $this->associate_model->add_product_image($_FILES["userfile"]["name"][$i],$store_id,$id);
                        
                    }
                  }
            }
            $this->session->set_flashdata('msg', 'Your product has  been updated.');
          redirect('associate/manage_product');
      }

    public function product_add()
    {
    	//print_r($this->session->userdata);
        if(isset($_POST['product_name']))
        {
            $id = $this->associate_model->product_add($_POST);

            for($i=0;$i<=sizeof($_FILES["userfile"]["name"]);$i++)
            {
                 if ($_FILES["userfile"]["error"][$i] > 0)
                    {
                    //echo "Error: " . $_FILES["userfile"]["error"][$i] . "<br>";
                    }
                  else
                    {
                    //echo "Upload: " . $_FILES["userfile"]["name"][$i] . "<br>";
                    //echo "Type: " . $_FILES["userfile"]["type"][$i] . "<br>";
                    //echo "Size: " . ($_FILES["userfile"]["size"][$i] / 1024) . " kB<br>";
                    
                    $ext = end(explode('.', $_FILES["userfile"]["name"][$i]));
                    
                    $un =  uniqid();
                   $path = "upload/store/".$this->session->userdata('asso_id');
 
                    if(!is_dir($path)){
                      mkdir($path);
                    }

                     $path = "upload/store/".$this->session->userdata('asso_id')."/".$id;
                    if(!is_dir($path)){
                      mkdir($path);
                    }
                      /* new file name */
                      if($_FILES["userfile"]["name"][$i] != "")
                      {
                      $path = 'upload/store/'.$this->session->userdata('asso_id').'/'.$id.'/'.$_FILES['userfile']['name'][$i];
                       if (file_exists("upload/store/".$this->session->userdata('asso_id')."/".$id."/" . $_FILES["userfile"]["name"][$i]))
                        {
                        //echo $_FILES["userfile"]["name"][$i] . " already exists. ";
                        $_FILES["userfile"]["name"][$i] = $un.".".$ext;
                        }
                         $path = 'upload/store/'.$this->session->userdata('asso_id').'/'.$id.'/'.$_FILES['userfile']['name'][$i];

                        move_uploaded_file($_FILES["userfile"]["tmp_name"][$i],
                         $path);
                        //echo "Stored in: " . "upload/" . $_FILES["userfile"]["name"][$i];
                        $this->associate_model->add_product_image($_FILES["userfile"]["name"][$i],$this->session->userdata('asso_id'),$id);
                        
                    }
                  }
            }

            

           $this->session->set_flashdata('message', 'Your product has  been added.');

           redirect('associate/manage_product');
        }
       $data['active'] = "product_add";
       $data['category'] = $this->associate_model->get_all_categories();
       $this->load->view('associate/header',$data);
       $this->load->view('associate/product_add',$data);
       $this->load->view('associate/footer',$data);

    }

    public function search_product()
    {
    	$products = $this->associate_model->search_product();
    	$html ="";
    	if(sizeof($products))
    	{
    		foreach ($products as $key) 
	    	{
	    		$html .='<tr><td>'.$key->product_name.'</td><td>'.$key->selling_price.'</td><td><a class="btn btn-primary btn-sm" href="'.base_url().'index.php/associate/choose_product/'.$key->product_id.'/'.$_POST["return"].'">Select</a></td></tr>';
	    	}
    	}
    	else
    	{
    		$html .='No product availabe.';
    	}
    	

    	print_r($html);
    }

    public function choose_product($product_id='',$return)
    {
    	$product_detail = $this->associate_model->get_product_detail($store_id,$product_id);
		$insert_product = array(
			'id' => $product_detail[0]->product_id,
			'name' => $product_detail[0]->product_name,
			'price' => $product_detail[0]->selling_price,
			'qty' => 1
		);	
		//print_r($insert_product);die;	
		$this->cart->insert($insert_product);	
		redirect('associate/add_'.$return);
		
    }

   public function remove_product($rowid='')
   {
   	$type = $_GET['type'];
   	   	$data = array(
				'rowid'   => $rowid,
				'qty'     => 0
			);

			$this->cart->update($data);
			redirect('associate/add_'.$type,'refresh');
   }


public function payout_detail()
{
	$data['payout']=$this->associate_model->get_payout_detail();
	$data['credit_limit'] = $this->associate_model->get_credit_limit();
	$this->load->view('associate/header',$data);
    $this->load->view('associate/payout_detail',$data);
    $this->load->view('associate/footer',$data);
}

public function edit_profile()
	{
		if($this->session->userdata('asso_email'))	
		{   
			
				$data['active'] = "user";
				$data['page_head'] = "Edit Profile";
				$data['countries'] = $this->associate_model->get_countries();
				$data['states'] = $this->associate_model->get_states();
				$data['cities'] = $this->associate_model->get_cities();
				$data['user_info'] = $this->associate_model->get_user_info($this->session->userdata('asso_id'));
				$this->load->view('associate/header',$data);
				$this->load->view('associate/edit_user',$data);
				$this->load->view('associate/footer',$data);
		
		}
		else
		{
			redirect('user/index');
		}
	}


public function check_adding_allowed($adding_amount)
{
	$credit_limit = $this->associate_model->get_credit_limit();
	$payout       =$this->associate_model->get_payout_detail();

	
	$current_revenue = $payout->total_revenue;

	$added_reve = $current_revenue + $adding_amount;

	if ($added_reve > $credit_limit->credit_limit) 
	{
		return 0;
	}
	else
	{
		return true;
	}

}

}
