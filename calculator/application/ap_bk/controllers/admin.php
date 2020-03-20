<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends CI_Controller {

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
		$this->load->model('admin_model');
		$this->load->database();
	}


	public function upload_file(){
			$status = "";
	       $msg = "";
	       $fileuri='';
	       $file_element_name = 'fileToUpload';
	        
	       if ($status != "error")
	       {
	          $config['upload_path'] = 'assets/admin/images/';
	          $config['allowed_types'] = 'gif|jpg|png|doc|txt';
	          $config['max_size']  = 10240;
	          $config['encrypt_name'] = TRUE;
	     
	          $this->load->library('upload', $config);
	     
	          if (!$this->upload->do_upload($file_element_name))
	          {
	             $status = 'error';
	             $msg = $this->upload->display_errors('', '');
	          }
	          else
	          {
	             $data = $this->upload->data();
	             $status = "success";
	             $msg = "File successfully uploaded";
	             $fileuri=  $config['upload_path'].$data['file_name'];
	          }
	          // @unlink($_FILES[$file_element_name]);
	       }
	       if($fileuri!=''){
	           echo json_encode(array('status' => $status, 'msg' => $msg,'fileuri'=>$fileuri ) );
	       }else{
	           echo json_encode(array('status' => $status, 'msg' => $msg, 'message' =>'file not uploaded'));
	       }
	}

 	#######################         ADMIN INDEX PAGE ##############################
	public function index()
	{
		if($this->session->userdata('admin_email'))	
		{   
			redirect('admin/dashboard');
		}
		else
		{
			$this->load->view('admin/login');
		}
	}

	#######################         ADMIN LOGIN PAGE ##############################
	public function checklogin()
	{
		$query=$this->admin_model->login();
		//print_r($query);die;
		if(sizeof($query)>0)
		{
			$data=array(
				'admin_id'=>$query[0]['id'],
				'admin_email'=>$query[0]['user_name']
				);
			$this->session->set_userdata($data);
			redirect('admin/dashboard');
		}
		else
		{
			redirect('admin/index?status=0');
		}
	}
 	
 	#######################         ADMIN dashboard PAGE ##############################
	public function dashboard()
	{
		//print_r(date("h:i:s a"));die;
		if($this->session->userdata('admin_email'))	
		{   
			$data['active'] = "dashboard";
			$data['users_count'] = $this->admin_model->get_user_count();
			$data['asso_count'] = $this->admin_model->get_associate_count();
			$data['prod_count'] = $this->admin_model->get_product_count();
			$this->load->view('admin/header',$data);
			$this->load->view('admin/dashboard',$data);
			$this->load->view('admin/footer',$data);
		}
		else
		{
			redirect('admin/index');
		}
	}

	public function associates($value='')
	{
		if($this->session->userdata('admin_email'))	
		{   
			$data['active'] = "associates";
			$data['page_head'] = "Associates";
			$data['action'] = "Associa";
			$data['associates'] = $this->admin_model->get_associates();
			$this->load->view('admin/header',$data);
			$this->load->view('admin/associates',$data);
			$this->load->view('admin/footer',$data);
		}
		else
		{
			redirect('admin/index');
		}
	}

	public function users($value='')
	{
		if($this->session->userdata('admin_email'))	
		{   
			$data['active'] = "users";
			$data['page_head'] = "Users";
			$data['action'] = "Users";
			$data['associates'] = $this->admin_model->get_users();
			$this->load->view('admin/header',$data);
			$this->load->view('admin/associates',$data);
			$this->load->view('admin/footer',$data);
		}
		else
		{
			redirect('admin/index');
		}
	}



	public function add_associate()
	{
		if($this->session->userdata('admin_email'))	
		{   
			if($this->input->post('username'))
			{
				$_SESSION['stat']=1;
				$this->get_available_parent($_POST['parent_ref_id'],0);
				$val = $_SESSION['parent_id'];
				if($val != "FALSE")
				{
					$this->admin_model->add_user($val);
					$this->session->set_flashdata('msg', 'Details has been Added.');
					redirect('admin/associates','refresh');
				}
				else
				{
					$this->session->set_flashdata('msg', 'Levels are completed for this parent ID.');
					redirect('admin/associates','refresh');
				}
				
				
			}
			else
			{
				$data['active'] = "associate";
				$data['page_head'] = "Add Associate";
				$data['plots'] = $this->admin_model->get_plots($find);
				$data['countries'] = $this->admin_model->get_countries();
				$data['states'] = $this->admin_model->get_states();
				$data['cities'] = $this->admin_model->get_cities();
				$data['category'] = $this->admin_model->get_all_categories();
				$data['sites'] = $this->admin_model->get_sites();
				$this->load->view('admin/header',$data);
				$this->load->view('admin/add_user',$data);
				$this->load->view('admin/footer',$data);
			}
			
		}
		else
		{
			redirect('admin/index');
		}
	}


	public function plan_manager()
	{
		if($this->session->userdata('admin_email'))	
		{   
			$data['active'] = "plan_manager";
			$data['page_head'] = "Plan Manager";
			$data['action'] = "";
			$data['plans'] = $this->admin_model->get_plans();
			$this->load->view('admin/header',$data);
			$this->load->view('admin/plans',$data);
			$this->load->view('admin/footer',$data);
		}
		else
		{
			redirect('admin/index');
		}
	}

public function edit_plan($plan_id)
	{
		if($this->session->userdata('admin_email'))	
		{   
			if($this->input->post('maximum_allowed_levels'))
			{
				$this->admin_model->update_mlm_info($plan_id);
				$this->session->set_flashdata('msg', 'Details has been updated.');
				redirect('admin/edit_plan/'.$plan_id,'refresh');
			}
			else
			{
				$data['active'] = "plan";
				$data['page_head'] = "Edit Plan";
				$data['mlm_info'] = $this->admin_model->get_mlm_info($plan_id);
				$this->load->view('admin/header',$data);
				$this->load->view('admin/mlm_conf',$data);
				$this->load->view('admin/footer',$data);
			}
			
		}
		else
		{
			redirect('admin/index');
		}
	}

	public function add_plan()
	{
		if($this->session->userdata('admin_email'))	
		{   
			if($this->input->post('maximum_allowed_levels'))
			{
				// $this->admin_model->update_mlm_info($plan_id);
				// $this->session->set_flashdata('msg', 'Details has been updated.');
				// redirect('admin/edit_plan/'.$plan_id,'refresh');

				$data = array(
						'plan_name'=> mysql_real_escape_string($this->input->post('plan_name')),
						'maximum_allowed_levels' => mysql_real_escape_string($this->input->post('maximum_allowed_levels')),
						'minimum_amount'=> mysql_real_escape_string($this->input->post('minimum_amount')),
						'allowed_members_per_level'=> mysql_real_escape_string($this->input->post('allowed_members_per_level')),
						'price_per_child'=> mysql_real_escape_string($this->input->post('price_per_child')),
						'default_per_level_child'=> mysql_real_escape_string($this->input->post('default_per_level_child')),
						'discount_overall'=> mysql_real_escape_string($this->input->post('discount_overall')),
						'deduction_per_month'=> mysql_real_escape_string($this->input->post('deduction_per_month')),
						'corner_charges'=> mysql_real_escape_string($this->input->post('corner_charges')),
						'commercial_charges'=> mysql_real_escape_string($this->input->post('commercial_charges')),
						'plc_charges'=> mysql_real_escape_string($this->input->post('plc_charges')),
						'premium_project_share'=> mysql_real_escape_string($this->input->post('premium_project_share')),
						'prime_project_share'=> mysql_real_escape_string($this->input->post('prime_project_share')),
						'rural_project_share'=> mysql_real_escape_string($this->input->post('rural_project_share')),
						'sales_commission_monthly_target'=> mysql_real_escape_string($this->input->post('sales_commission_monthly_target')),
						'business_in_rs'=> mysql_real_escape_string($this->input->post('business_in_rs')),
						'max_sale_area'=> mysql_real_escape_string($this->input->post('max_sale_area')),
						'security_amount'=> mysql_real_escape_string($this->input->post('security_amount')),
						'min_rs'=> mysql_real_escape_string($this->input->post('min_rs')),
						'max_rs'=> mysql_real_escape_string($this->input->post('max_rs')),
						'franchise_commission'=> mysql_real_escape_string($this->input->post('franchise_commission')),
						'no_month'=> mysql_real_escape_string($this->input->post('no_month')),
						'special_commission'=> mysql_real_escape_string($this->input->post('special_commission')),
						'late_instalment_charges'=> mysql_real_escape_string($this->input->post('late_instalment_charges')),
						'limit_for_registration_month'=> mysql_real_escape_string($this->input->post('limit_for_registration_month'))
						);
				$this->admin_model->add_mlm_info($data);
				redirect('admin/plan_manager/','refresh');

			}
			else
			{
				$data['active'] = "plan";
				$data['page_head'] = "Add New Plan";
				
				$this->load->view('admin/header',$data);
				$this->load->view('admin/mlm_conf',$data);
				$this->load->view('admin/footer',$data);
			}
			
		}
		else
		{
			redirect('admin/index');
		}
	}

	public function delete_plan($id){
		if($this->session->userdata('admin_email'))	
		{ 
			$this->admin_model->delete_plan($id);
			//$this->rrmdir("upload/user/".$id);
			$this->session->set_flashdata('msg', 'Details Has been deleted.');
			redirect('admin/plan_manager');
		}
		else
		{
			redirect('admin/index');
		}
	}


	public function edit_associate($id)
	{
		if($this->session->userdata('admin_email'))	
		{   
			
				$data['active'] = "associate";
				$data['page_head'] = "Edit Associate";
				$data['countries'] = $this->admin_model->get_countries();
				$data['states'] = $this->admin_model->get_states();
				$data['cities'] = $this->admin_model->get_cities();
				$data['user_info'] = $this->admin_model->get_user_info($id);
				$data['installments'] = $this->admin_model->get_installments($id);
				$this->load->view('admin/header',$data);
				$this->load->view('admin/edit_user',$data);
				$this->load->view('admin/footer',$data);
		
		}
		else
		{
			redirect('admin/index');
		}
	}


	public function add_user()
	{
		if($this->session->userdata('admin_email'))	
		{   
			if($this->input->post('username'))
			{
				$_SESSION['stat']=1;
				$this->get_available_parent($_POST['parent_ref_id'],0);
				$val = $_SESSION['parent_id'];
				if($val != "FALSE")
				{
					$this->admin_model->add_user($val);
					$this->session->set_flashdata('msg', 'Details has been Added.');
					redirect('admin/users','refresh');
				}
				else
				{
					$this->session->set_flashdata('msg', 'Levels are completed for this parent ID.');
					redirect('admin/users','refresh');
				}
				
			}
			else
			{
				$data['active'] = "user";
				$data['page_head'] = "Add User";
				$data['plots'] = $this->admin_model->get_plots($find);
				$data['countries'] = $this->admin_model->get_countries();
				$data['states'] = $this->admin_model->get_states();
				$data['cities'] = $this->admin_model->get_cities();
				$data['category'] = $this->admin_model->get_all_categories();
				$data['sites'] = $this->admin_model->get_sites();
				
				$this->load->view('admin/header',$data);
				$this->load->view('admin/add_user',$data);
				$this->load->view('admin/footer',$data);
			}
			
		}
		else
		{
			redirect('admin/index');
		}
	}



	public function edit_user($id)
	{
		if($this->session->userdata('admin_email'))	
		{   
			
				$data['active'] = "user";
				$data['page_head'] = "Edit User";
				$data['countries'] = $this->admin_model->get_countries();
				$data['states'] = $this->admin_model->get_states();
				$data['cities'] = $this->admin_model->get_cities();
				$data['user_info'] = $this->admin_model->get_user_info($id);
				$data['installments'] = $this->admin_model->get_installments($id);
				$this->load->view('admin/header',$data);
				$this->load->view('admin/edit_user',$data);
				$this->load->view('admin/footer',$data);
		}
		else
		{
			redirect('admin/index');
		}
	}




	public function update_user($userid)
	{
		if($this->session->userdata('admin_email'))	
		{   

			$this->admin_model->update_user($userid);
			$this->session->set_flashdata('msg', 'Details has been updated.');
			redirect('admin/users','refresh');
		}
		else
		{
			redirect('admin/index');
		}
	}

	public function activate_user($id,$active)
	{
		if($this->session->userdata('admin_email'))	
		{ 
			$this->admin_model->activate_user($id);
			$this->session->set_flashdata('msg', 'Details Has been activated.');
			redirect('admin/'.$active.'s');
		}
		else
		{
			redirect('admin/index');
		}
	}

	public function deactivate_user($id,$active)
	{
		if($this->session->userdata('admin_email'))	
		{ 
			$this->admin_model->deactivate_user($id);
			$this->session->set_flashdata('msg', 'Details Has been deactivated.');
			redirect('admin/'.$active.'s');
		}
		else
		{
			redirect('admin/index');
		}
	}
	
public function delete_user($id,$active)
	{
		if($this->session->userdata('admin_email'))	
		{ 
			$this->admin_model->delete_user($id);
			//$this->rrmdir("upload/user/".$id);
			$this->session->set_flashdata('msg', 'Details Has been deleted.');
			redirect('admin/'.$active.'s');
		}
		else
		{
			redirect('admin/index');
		}
	}


	public function logout()
	{
		$this->session->unset_userdata('admin_email');
		redirect('admin/index');
	}

public function get_city_list($state_id)
     {
     	$html = " <option>Select City</option>";
     	$data = $this->admin_model->get_city_list($state_id);
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
	$stat = $this->admin_model->check_ref_id($ref_id);
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
	$stat = $this->admin_model->check_availability_email($email);
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
	
		if($this->session->userdata('admin_email'))	
		{   

			if(isset($_POST['level']))
			{
				$this->admin_model->update_level_pricing();
				$this->session->set_flashdata('msg', 'Details has been Added.');
				redirect('admin/pricing','refresh');
			}
			else
			{
				$data['active'] = "pricing";
				$data['page_head'] = "Pricing Per Level ";
				$data['max_level'] = $this->admin_model->get_max_level();
				$data['pricing'] = $this->admin_model->get_level_pricing();
				$this->load->view('admin/header',$data);
				$this->load->view('admin/level_pricing',$data);
				$this->load->view('admin/footer',$data);
			}
			
		}
		else
		{
			redirect('admin/index');
		}
	
}

public function generate_tree()
{
	   

			
				$data['active'] = "tree";
				$data['user_references'] = $this->admin_model->get_user_referece_ids();
				$this->load->view('admin/tree',$data);
			
			
}


public function get_available_parent($parent_id,$i=0)
{
	  $i = $i;
	 $c = $this->admin_model->get_max_child_per_level();
	  $l = $this->admin_model->get_max_level();


if($_SESSION['stat'] == 1)
{
	for (; $i < $l ;$i++) 
	{ 
		
		//print_r("<br>");
		$c_count = $this->admin_model->get_child_count($parent_id);
		$child_ids = $this->admin_model->get_child_ids($parent_id);//print_r($child_ids);
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
				 $c_count2 = $this->admin_model->get_child_count($key->ref_id);
		         //$child_ids2 = $this->admin_model->get_child_ids($key->ref_id);
		         
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
	
		if($this->session->userdata('admin_email'))	
		{   

			
				
				$this->load->view('admin/header',$data);
				$this->load->view('admin/generate_tree',$data);
				$this->load->view('admin/footer',$data);
			
			
		}
		else
		{
			redirect('admin/index');
		}
}


  public function product_types()
     {
     	if($this->session->userdata('admin_email'))	
		{
			if(isset($_POST['type_name']))
			{
				$this->admin_model->add_product_type();
				$this->session->set_flashdata('msg', 'New Category has been added.');
				redirect('admin/product_types');
			}
			if(isset($_POST['type_name_edit']))
			{
				$this->admin_model->edit_product_type();
				$this->session->set_flashdata('msg', 'Category has been updated.');
				redirect('admin/product_types');
			}
			$data['category'] = $this->admin_model->get_all_categories();
			$data['active'] = "product_types";
			$this->load->view('admin/header',$data);
			$this->load->view('admin/product_types',$data);
			$this->load->view('admin/footer',$data);

		}
		else
		{
			redirect('admin/index');
		}
     }

public function delete_product_type($id)
     {
     	if($this->session->userdata('admin_email'))	
		{
			$this->session->set_flashdata('msg', 'Category has been deleted.');	
			$this->admin_model->delete_product_type($id);
			redirect('admin/product_types');
		}
		else
		{
			redirect('admin/index');
		}
     }


public function manage_product()
	{
		if($this->session->userdata('admin_email'))	
		{
			$data['active'] = "manage_product";
			$data['products'] = $this->admin_model->manage_product();
			$data['category'] = $this->admin_model->get_all_categories();
			$this->load->view('admin/header',$data);
			$this->load->view('admin/manage_product',$data);
			$this->load->view('admin/footer',$data);
		}
		else
		{
			redirect('admin/index');
		}
		
	}
	public function deleteproduct($id)
	{
		if($this->session->userdata('admin_email'))	
		{
			$this->admin_model->deleteproduct($id);
			redirect('admin/manage_product');
		}
		else
		{
			redirect('admin/index');
		}

	}	
	public function verifyproduct($id)
	{
		if($this->session->userdata('admin_email'))	
		{
			$this->admin_model->verifyproduct($id);
			redirect('admin/manage_product');
		}
		else
		{
			redirect('admin/index');
		}

	}	
	public function unverifyproduct($id)
	{
		if($this->session->userdata('admin_email'))	
		{
			$this->admin_model->unverifyproduct($id);
			redirect('admin/manage_product');
		}
		else
		{
			redirect('admin/index');
		}

	}	


  public function product_detail($p_id,$store_id="")
        {
          
          if($this->session->userdata('mpstoreid'))
          {
            $store_id = $this->session->userdata('mpstoreid');
          }

           $product_detail = $this->admin_model->get_product_detail($store_id,$p_id);
            $info = $product_detail[0];
            $category = $this->admin_model->get_all_categories();
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
                $images = $this->admin_model->get_images($p_id);
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
          
         
           $product_detail = $this->admin_model->get_product_detail($store_id,$p_id);
           $this->load->model('admin_model');
        $data = $this->admin_model->show_custom_feilds($product_detail[0]->cat_id,$product_detail[0]->sub_catid1,$product_detail[0]->sub_catid2,$product_detail[0]->sub_catid3);
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
           $prod_images = $this->admin_model->get_product_images($product_detail[0]->product_id);
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
          $img=$this->admin_model->img_delete($id);
          unlink('upload/store/'.$store_id."/".$product_id."/".$name);
          print 1;
      }


      public function product_update($id)
      {
          
          $id = $_POST['product_id'];
          $product_detail = $this->admin_model->get_product_detail($store_id=0,$id);
          $store_id = $product_detail[0]->store_id;
          //echo "<pre>" ;print_r($store_id);die;
          $this->admin_model->product_update($_POST,$id);

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
                        $this->admin_model->add_product_image($_FILES["userfile"]["name"][$i],$store_id,$id);
                        
                    }
                  }
            }
            $this->session->set_flashdata('msg', 'Your product has  been updated.');
          redirect('admin/manage_product');
      }

    public function product_add()
    {
    	//print_r($this->session->userdata);
        if(isset($_POST['product_name']))
        {
            $id = $this->admin_model->product_add($_POST);

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
                   $path = "upload/store/".$this->session->userdata('admin_id');
 
                    if(!is_dir($path)){
                      mkdir($path);
                    }

                     $path = "upload/store/".$this->session->userdata('admin_id')."/".$id;
                    if(!is_dir($path)){
                      mkdir($path);
                    }
                      /* new file name */
                      if($_FILES["userfile"]["name"][$i] != "")
                      {
                      $path = 'upload/store/'.$this->session->userdata('admin_id').'/'.$id.'/'.$_FILES['userfile']['name'][$i];
                       if (file_exists("upload/store/".$this->session->userdata('admin_id')."/".$id."/" . $_FILES["userfile"]["name"][$i]))
                        {
                        //echo $_FILES["userfile"]["name"][$i] . " already exists. ";
                        $_FILES["userfile"]["name"][$i] = $un.".".$ext;
                        }
                         $path = 'upload/store/'.$this->session->userdata('admin_id').'/'.$id.'/'.$_FILES['userfile']['name'][$i];

                        move_uploaded_file($_FILES["userfile"]["tmp_name"][$i],
                         $path);
                        //echo "Stored in: " . "upload/" . $_FILES["userfile"]["name"][$i];
                        $this->admin_model->add_product_image($_FILES["userfile"]["name"][$i],$this->session->userdata('admin_id'),$id);
                        
                    }
                  }
            }

            

           $this->session->set_flashdata('message', 'Your product has  been added.');

           redirect('admin/manage_product');
        }
       $data['active'] = "product_add";
       $data['category'] = $this->admin_model->get_all_categories();
       $this->load->view('admin/header',$data);
       $this->load->view('admin/product_add',$data);
       $this->load->view('admin/footer',$data);

    }

    public function search_product()
    {
    	$products = $this->admin_model->search_product();
    	$html ="";
    	if(sizeof($products))
    	{
    		foreach ($products as $key) 
	    	{
	    		$html .='<tr><td>'.$key->product_name.'</td><td>'.$key->selling_price.'</td><td><a class="btn btn-primary btn-sm" href="'.base_url().'index.php/admin/choose_product/'.$key->product_id.'/'.$_POST["return"].'">Select</a></td></tr>';
	    	}
    	}
    	else
    	{
    		$html .='No product availabe.';
    	}
    	

    	print_r($html);
    }

    public function choose_plot($plot_id='',$return='user')
    {
    	$plot_detail = $this->admin_model->get_plot_detail($plot_id);
		$insert_plot = array(
			'id' => $plot_detail->plot_id,
			'name' => $plot_detail->site_name,
			'price' => $plot_detail->price,
			'qty' => 1,
			'type'=>$plot_detail->type,
			'plot_number'=>$plot_detail->plot_number
		);	
		//print_r($insert_plot);die;	
		$this->cart->insert($insert_plot);	
		redirect('admin/add_'.$return);
		
    }


   public function remove_product($rowid='')
   {
   	$type = $_GET['type'];
   	   	$data = array(
				'rowid'   => $rowid,
				'qty'     => 0
			);

			$this->cart->update($data);
			redirect('admin/add_'.$type,'refresh');
   }


/*add site*/
public function manage_site($value='')
	{
		if($this->session->userdata('admin_email'))	
		{   
			$data['active'] = "manage_site";
			$data['page_head'] = "Project";
			$data['action'] = "Project";
			$data['sites'] = $this->admin_model->get_sites();
			$this->load->view('admin/header',$data);
			$this->load->view('admin/sites',$data);
			$this->load->view('admin/footer',$data);
		}
		else
		{
			redirect('admin/index');
		}
	}

 public function add_site()
 {

 	if($_POST['site_name'])
 	{
 		$id = $this->admin_model->add_site();
 		$this->session->set_flashdata('message', 'Your project has  been added.');
 	}

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
                     $path = "upload/site/";
 
                    if(!is_dir($path)){
                      mkdir($path);
                    }

                    $un =  uniqid();
                   $path = "upload/site/".$this->session->userdata('admin_id');
 
                    if(!is_dir($path)){
                      mkdir($path);
                    }

                     $path = "upload/site/".$this->session->userdata('admin_id')."/".$id;
                    if(!is_dir($path)){
                      mkdir($path);
                    }
                      /* new file name */
                      if($_FILES["userfile"]["name"][$i] != "")
                      {
                      $path = 'upload/site/'.$this->session->userdata('admin_id').'/'.$id.'/'.$_FILES['userfile']['name'][$i];
                       if (file_exists("upload/site/".$this->session->userdata('admin_id')."/".$id."/" . $_FILES["userfile"]["name"][$i]))
                        {
                        //echo $_FILES["userfile"]["name"][$i] . " already exists. ";
                        $_FILES["userfile"]["name"][$i] = $un.".".$ext;
                        }
                         $path = 'upload/site/'.$this->session->userdata('admin_id').'/'.$id.'/'.$_FILES['userfile']['name'][$i];

                        move_uploaded_file($_FILES["userfile"]["tmp_name"][$i],
                         $path);
                        //echo "Stored in: " . "upload/" . $_FILES["userfile"]["name"][$i];
                        $this->admin_model->add_site_image($_FILES["userfile"]["name"][$i],$this->session->userdata('admin_id'),$id,$i);
                        
                    }

                  }
            }

			$data['page_head'] = "Project";
			$data['action'] = "Project";
			//$data['sites'] = $this->admin_model->get_sites();
			$data['plans']=$this->admin_model->get_plans();
			$this->load->view('admin/header',$data);
			$this->load->view('admin/add_site',$data);
			$this->load->view('admin/footer',$data);
 }

public function update_site($id)
 {

 	if($_POST['site_name'])
 	{
 		$this->admin_model->update_site($id);
 	}


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
                     $path = "upload/site/";
 
                    if(!is_dir($path)){
                      mkdir($path);
                    }

                    $un =  uniqid();
                   $path = "upload/site/".$this->session->userdata('admin_id');
 
                    if(!is_dir($path)){
                      mkdir($path);
                    }

                     $path = "upload/site/".$this->session->userdata('admin_id')."/".$id;
                    if(!is_dir($path)){
                      mkdir($path);
                    }
                      /* new file name */
                      if($_FILES["userfile"]["name"][$i] != "")
                      {
                      $path = 'upload/site/'.$this->session->userdata('admin_id').'/'.$id.'/'.$_FILES['userfile']['name'][$i];
                       if (file_exists("upload/site/".$this->session->userdata('admin_id')."/".$id."/" . $_FILES["userfile"]["name"][$i]))
                        {
                        //echo $_FILES["userfile"]["name"][$i] . " already exists. ";
                        $_FILES["userfile"]["name"][$i] = $un.".".$ext;
                        }
                         $path = 'upload/site/'.$this->session->userdata('admin_id').'/'.$id.'/'.$_FILES['userfile']['name'][$i];

                        move_uploaded_file($_FILES["userfile"]["tmp_name"][$i],
                         $path);
                        //echo "Stored in: " . "upload/" . $_FILES["userfile"]["name"][$i];
                        $this->admin_model->add_site_image($_FILES["userfile"]["name"][$i],$this->session->userdata('admin_id'),$id,$i);
                        
                    }
                  }
            }
redirect('admin/manage_site','refresh');


 }

public function update_site_plot($id='')
{
	$this->admin_model->update_site_plot($id);
	redirect('admin/manage_site','refresh');
}


public function edit_site($id)
{
	$data['page_head'] = "Sites";
	$data['action'] = "Sites";
	$data['site'] = $this->admin_model->get_site_info($id);
	$data['plans']=$this->admin_model->get_plans();
	$this->load->view('admin/header',$data);
	$this->load->view('admin/edit_site',$data);
	$this->load->view('admin/footer',$data);
}

public function edit_site_plots($id)
{
	$data['page_head'] = "Sites";
	$data['action'] = "Sites";
	$data['site'] = $this->admin_model->get_site_info($id);
	$this->load->view('admin/header',$data);
	$this->load->view('admin/edit_site_plots',$data);
	$this->load->view('admin/footer',$data);
}


public function get_site($id=0,$plot_type,$plot_id=0){
	if($id==0){
		$resp = $this->admin_model->get_sites();
	}else{
		$data = $this->admin_model->get_site_info($id);
		if($plot_id==0){
			
			$plots = $this->admin_model->get_site_plots($data->site_id,$plot_type);
		}else{
			$plots[]=$this->admin_model->get_plot_detail($plot_id);
		}
		
		$plan = $this->admin_model->get_mlm_info($data->plan_id_fk);

		$resp['site_plots'] 	= $plots;
 
	 	$resp['plot_area']		= $plots[0]->size;
		$resp['rate']			= $plots[0]->price;
		$resp['installment']	= $plan->no_month;
		
		$commercial_charges = 0;
		$corner_charges = 0;
		$prime_location_charges = 0;
		if($plots[0]->commercial==1){
			$commercial_charges =  $plots[0]->price * $plan->commercial_charges /100;
		}
		if($plots[0]->corner==1){
			$corner_charges = $plots[0]->price * $plan->corner_charges /100;
		}
		if($plots[0]->prime_location==1){
			$prime_location_charges = $plots[0]->price * $plan->plc_charges /100;
		}
		$resp['total_plot_amount'] = $plots[0]->price + $commercial_charges + $corner_charges + $prime_location_charges;
	}

	echo json_encode($resp);
}



public function get_plot($id=0){
	$resp = $this->admin_model->get_site_plots($id);
	echo json_encode($resp);
}




 public function delete_site($id)
	{
		if($this->session->userdata('admin_email'))	
		{
			$this->admin_model->delete_site($id);
			redirect('admin/manage_site');
		}
		else
		{
			redirect('admin/index');
		}

	}	
	public function activate_site($id)
	{
		if($this->session->userdata('admin_email'))	
		{
			$this->admin_model->activate_site($id);
			redirect('admin/manage_site');
		}
		else
		{
			redirect('admin/index');
		}

	}	
	public function deactivate_site($id)
	{
		if($this->session->userdata('admin_email'))	
		{
			$this->admin_model->deactivate_site($id);
			redirect('admin/manage_site');
		}
		else
		{
			redirect('admin/index');
		}

	}	





public function manage_plots($value='')
{
	if($this->session->userdata('admin_email'))	
		{   
			if($this->input->server('REQUEST_METHOD') == "POST")
			  {
			    $this->session->set_userdata('find_array',$_POST);
			    $find = $_POST;
			  }
			  else
			  {
			      $find = $this->session->userdata('find_array');
			  }
			$data['active'] = "manage_site";
			$data['page_head'] = "Plots";
			$data['action'] = "Plots";
			$data['plots'] = $this->admin_model->get_plots($find);
			$this->load->view('admin/header',$data);
			$this->load->view('admin/plots',$data);
			$this->load->view('admin/footer',$data);
		}
		else
		{
			redirect('admin/index');
		}
}


public function update_plot($id='')
{
	if($this->session->userdata('admin_email'))	
		{
			$this->admin_model->update_plot($id);
			redirect('admin/manage_plots');
		}
		else
		{
			redirect('admin/index');
		}
}

	public function activate_plot($id)
	{
		if($this->session->userdata('admin_email'))	
		{
			$this->admin_model->activate_plot($id);
			redirect('admin/manage_plots');
		}
		else
		{
			redirect('admin/index');
		}

	}	
	public function deactivate_plot($id)
	{
		if($this->session->userdata('admin_email'))	
		{
			$this->admin_model->deactivate_plot($id);
			redirect('admin/manage_plots');
		}
		else
		{
			redirect('admin/index');
		}

	}	


	



}
