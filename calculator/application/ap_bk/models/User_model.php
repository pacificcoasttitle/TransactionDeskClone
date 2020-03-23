<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class User_model extends CI_Model 
{
	public function __construct()
	{
		parent::__construct();
		$this->load->database();
		
	}

	public function login() 
	{
	  $this->db->where('username',$_POST['user_name']);
	  $this->db->where('password',md5($_POST['password']));
	  $this->db->where('role_id',2);
	  $query=$this->db->get('mlm_users');
	  return $query->result_array();
	}

	public function get_user_count()
	{
	  $this->db->where('role_id',2);
	  $query=$this->db->get('mlm_users');
	  return $query->num_rows();
	}

	public function get_associate_count()
	{
	  $this->db->where('role_id',1);
	  $query=$this->db->get('mlm_users');
	  return $query->num_rows();
	}

	public function get_product_count()
	{
	  $query=$this->db->get('products');
	  return $query->num_rows();
	}

	public function get_associates()
	{
		$this->db->where('role_id',1);
	  $query=$this->db->get('mlm_users');
	  return $query->result();
	}

	public function get_users()
	{
		$this->db->where('role_id',2);
	  $query=$this->db->get('mlm_users');
	  return $query->result();
	}

	public function update_user($userid)
	{
		$row = array(
			'username'         =>$_POST['username'],
			'salutation'       =>$_POST['salutation'],
			'name'             =>$_POST['name'],
			'nationality'      =>$_POST['nationality'],
			'age'              =>$_POST['age'],
			'gender'           =>$_POST['gender'],
			'mobile'           =>$_POST['mobile'],
			'address'          =>$_POST['address'],
			'country'          =>$_POST['country'],
			'state'            =>$_POST['state'],
			'city'             =>$_POST['city'],
			'zipcode'          =>$_POST['zipcode'],
			'company_name'     =>$_POST['company_name'],
			'additional'       =>$_POST['additional'],
			'role_id'          =>$_POST['role_id'],
			'credit_limit'     =>$_POST['credit_limit'],
			'benificiary_name' =>$_POST['benificiary_name'],
			'bank_name'        =>$_POST['bank_name'],
			'bank_address'     =>$_POST['bank_address'],
			'account_no'       =>$_POST['account_no'],
			'ifsc'             =>$_POST['ifsc']
			);
	  $this->db->where('id',$userid);
	  $query=$this->db->update('mlm_users',$row);

	  return $this->db->affected_rows();
	}

	public function add_user($parent_ref_id)
	{
		
      //echo "<pre>";
		//print_r($_POST);die;
	$ref = uniqid();
    $ref = substr($ref, 6,5);
    $ref = "MLM".$ref;

		$row = array(
			'username'         =>$_POST['username'],
			'salutation'       =>$_POST['salutation'],
			'name'             =>$_POST['name'],
			'nationality'      =>$_POST['nationality'],
			'age'              =>$_POST['age'],
			'gender'           =>$_POST['gender'],
			'mobile'           =>$_POST['mobile'],
			'address'          =>$_POST['address'],
			'country'          =>$_POST['country'],
			'state'            =>$_POST['state'],
			'city'             =>$_POST['city'],
			'zipcode'          =>$_POST['zipcode'],
			'company_name'     =>$_POST['company_name'],
			'additional'       =>$_POST['additional'],
			'role_id'          =>$_POST['role_id'],
			'ref_id'           => $ref,
			'parent_ref_id'    => $parent_ref_id,
			'direct_id'        => $_POST['parent_ref_id'],
			'total_amount'     => $_POST['total_amount'],
			'credit_limit'     => $_POST['credit_limit'],
			'paid_amount'      => $_POST['paid_amount'],
			'payment_option'   => $_POST['payment_option'],
			'emi_type'         => $_POST['emi_type'],
			'benificiary_name' =>$_POST['benificiary_name'],
			'bank_name'        =>$_POST['bank_name'],
			'bank_address'     =>$_POST['bank_address'],
			'account_no'       =>$_POST['account_no'],
			'ifsc'             =>$_POST['ifsc']

			);
	  $query=$this->db->insert('mlm_users',$row);
	  $u_id =  $this->db->insert_id();

	  if ($cart = $this->cart->contents())
	  {
	  	 foreach ($cart as $item)
	  	 {
	  	 	$pr_row = array(
	  	 		'user_id' => $u_id,
	  	 		'product_id'=>$item['id'],
	  	 		'price'=>$item['price']

	  	 		);
	  	 	$query=$this->db->insert('mlm_user_products',$pr_row);
	  	 }
	  	 $this->cart->destroy();
	  }


	  $this->update_revenue($u_id,$_POST['paid_amount']);

	  $this->update_direct_income($_POST['parent_ref_id'],$_POST['paid_amount']);

	  return $u_id;
	}


public function get_parent_reference_id($id)
	{
		$this->db->select('parent_ref_id');
		$this->db->where('mlm_users.id', $id);
        $query=  $this->db->get('mlm_users');
        $res =  $query->row();
        return $res->parent_ref_id;
	}


	public function update_revenue($userid,$amount)
	{
		$parent_ref_id = $this->get_parent_reference_id($userid);

		if($parent_ref_id)
		{
			
			$userid = $this->get_user_id($parent_ref_id);
			$this->db->where('user_id', $userid);
			$query = $this->db->get('monthly_revenue');
			$count =  $query->num_rows();
			if($count)
			{
				
				$sql = 'UPDATE `monthly_revenue` SET `total_revenue`= total_revenue+'.$amount.' WHERE `user_id`="'.$userid.'"';
				$this->db->query($sql);
				$this->update_revenue($userid,$amount);
				
			}
			else
			{
				$row = array(
						'user_id' => $userid,
						'reference_id' => $parent_ref_id,
						'total_revenue'=> $amount
					);
				$this->db->insert('monthly_revenue', $row);
				$this->update_revenue($userid,$amount);
			}

		}
	}

	public function update_direct_income($ref_id,$amount)
	{
		$dir_income = $amount*10/100;
		$sql = 'UPDATE `monthly_revenue` SET `direct_income`= direct_income+'.$dir_income.' WHERE `reference_id`="'.$ref_id.'"';
		$this->db->query($sql);
	}

	public function get_user_info($id='')
	{
		 $this->db->where('mlm_users.id', $id);
        $query=  $this->db->get('mlm_users');
        return $query->row();
	}

	public function get_user_id($ref_id)
	{
		 $this->db->where('mlm_users.ref_id', $ref_id);
        $query=  $this->db->get('mlm_users');
         $res =  $query->row();
        return $res->id;
	}

	public function deactivate_user($id)
{
  $row = $_POST;
  //print_r($_POST);die;
  $row['status'] = "F";
  $this->db->where('id', $id);
  $this->db->update('mlm_users', $row);
}

public function activate_user($id)
{
  $row = $_POST;
  //print_r($_POST);die;
  $row['status'] = "T";
  $this->db->where('id', $id);
  $this->db->update('mlm_users', $row);
}


public function delete_user($id)
{
  $this->db->where('id', $id);
  $this->db->delete('mlm_users');

}

	

	public function get_countries($value='')
   {
   	  $query = $this->db->get('mlm_countries');
   	  return $query->result();
   }

   public function get_states($value='')
   {
   	  $query = $this->db->get('states');
   	  return $query->result();
   }
   public function get_cities($value='')
   {
   	  $query = $this->db->get('states_cities');
   	  return $query->result();
   }
	
	public function get_city_list($state_id)
{
	$this->db->where('state_id', $state_id);
	$query = $this->db->get('states_cities');
	return $query->result();
}


public function check_ref_id($ref_id)
{
	$this->db->where('ref_id', $ref_id);
	$query = $this->db->get('mlm_users');
	$count =  $query->num_rows();
	if($count)
	{
		
		return $count;
		
	}
	else
	{
		return $count;
	}
}

public function get_child_count($ref_id)
{
	$this->db->where('parent_ref_id', $ref_id);
	$query = $this->db->get('mlm_users');
	return $query->num_rows();
}
public function get_child_ids($ref_id)
{
	$this->db->select('id,ref_id');
	$this->db->where('parent_ref_id', $ref_id);
	$query = $this->db->get('mlm_users');
	return $query->result();
}

public function check_availability_email($email)
{
	$this->db->where('username', $email);
	$query = $this->db->get('mlm_users');
	return $query->num_rows();
}

public function get_mlm_info()
{
	$query = $this->db->get('mlm_options');
	return $query->row();
}

public function update_mlm_info($value='')
{
	$this->db->where('id', 1);
    $this->db->update('mlm_options',$_POST);
}



public function get_level_pricing($value='')
{
	$max_level = $this->get_max_level;
	$qqer = $this->db->get('mlm_pricing_per_level', $max_level);

    $pricing = array();
	$res =  $qqer->result();
	foreach ($res as $key) 
	{
		$pricing[$key->level] = $key->price_percent;
	}
	return $pricing;
}

public function get_max_level()
{
	$query = $this->db->get('mlm_options');
	$res = $query->row();
	$max_level = $res->maximum_allowed_levels;
	return $max_level;
}

public function get_max_child_per_level()
{
	$query = $this->db->get('mlm_options');
	$res = $query->row();
	$max_child = $res->allowed_members_per_level;
	return $max_child;
}



public function update_level_pricing()
{
	foreach ($_POST['level'] as $key => $value) 
	{
		$this->db->where('level', $key);
		$count_query = $this->db->get('mlm_pricing_per_level');
		$count = $count_query->num_rows();
		if($count)
		{
			$this->db->where('level', $key);
			$update = array('price_percent' => $value);
			$this->db->update('mlm_pricing_per_level', $update);
		}
		else
		{
			$update = array('price_percent' => $value,'level'=>$key);
			$this->db->insert('mlm_pricing_per_level', $update);
		}
	}
}

public function get_user_referece_ids()
{
	$this->db->select('id,ref_id,parent_ref_id');
	$query = $this->db->get('mlm_users');
	return $query->result();
}

public function get_all_categories()
{
	$query = $this->db->get('category_list');
	return $query->result();
}


public function add_product_type()
{
	$row = array('category_name' => $_POST['type_name'],
                 'parent_category_id' => $_POST['parent_category_id']
	 );
	$this->db->insert('category_list', $row);
}

public function edit_product_type()
{
	$row = array('category_name' => $_POST['type_name_edit'],
                
	 );
	$this->db->where('category_id', $_POST['id']);
	$this->db->update('category_list', $row);
}

public function delete_product_type($id)
{
	$this->db->where('category_id', $id);
	$this->db->delete('category_list');
}



public function manage_product()
{
$this->db->select('products.*,mlm_users.name as store_name');

$this->db->join('mlm_users', 'products.store_id = mlm_users.id','left');
$this->db->from('products');
$query = $this->db->get();
//echo $this->db->last_query();
return $query->result();
}
public function deleteproduct($id){
//echo "ddddd";
$this->db->where('product_id',$id);
$this->db->delete('products');
}
public function verifyproduct($id){
$data=array('status'=>1);
$this->db->where('product_id',$id);
$this->db->update('products',$data);
}
public function unverifyproduct($id){
$data=array('status'=>0);
$this->db->where('product_id',$id);
$this->db->update('products',$data);
}


public function get_product_detail($id,$p_id)
{
	$this->db->select('*');
	if($id)
	$this->db->where('store_id',$id);
    $this->db->where('product_id',$p_id);
	$query = $this->db->get('products');
	return $query->result();
	
}

public function add_product_image($file_name,$store_id,$product_id)
{
	$row = array('store_id' =>$store_id , 
		          'product_id' =>$product_id,
		          'image_name' =>$file_name);
	$this->db->insert('product_images', $row);
}

public function img_delete($id)
{
  $this->db->where('id',$id);
  $this->db->delete('product_images');
}



public function product_update($data,$p_id)
{
	$row = array(
			'product_id'       =>$data['product_id'],
			'product_name'     =>$data['product_name'],
			'bnb_product_code' =>$data['bnb_product_code'],
			'style'            =>$data['style'],
			'description'      =>$data['description'],
			'cat_id'           =>$data['cat_id'],
			'sub_catid1'       =>$data['sub_catid1'],
			'sub_catid2'       =>$data['sub_catid2'],
			'sub_catid3'       =>$data['sub_catid3'],
			'tags'             =>$data['tags'],
			'length'           =>$data['length'],
			'breadth'          =>$data['breadth'],
			'height'           =>$data['height'],
			'prd_act_weight'   =>$data['prd_act_weight'],
			'prd_vol_weight'   =>$data['prd_vol_weight'],
			'tax_rate'         =>$data['tax_rate'],
			'insurance_cost'   =>$data['insurance_cost'],
			'shipping_cost'    =>$data['shipping_cost'],
			'selling_price'    =>$data['selling_price'],
			'quantity'         =>$data['quantity']

		);
	$this->db->where('product_id',$p_id);
	$this->db->update('products',$data);
	
}

public function product_add($data)
{
	//$this->db->insert('product_id',$p_id);
	
	$query = $this->db->insert('products',$data);
	$p_id = $this->db->insert_id();
	return $p_id;
}

public function get_images($product_id)
{
	$this->db->where('product_id', $product_id);
	$query = $this->db->get('product_images');
	return $query->result();
}




public function get_product_images($productid)
{
    $this->db->select('*');
    $this->db->where('product_id',$productid);
  $query = $this->db->get('product_images');
  return $query->result();
}

public function show_custom_feilds($cat_id,$subcat_id1,$subcat_id2,$subcat_id3)
{
	$this->db->where('category_id', $cat_id);
	$this->db->where('sub_category_id1', $subcat_id1);
	$this->db->where('sub_category_id2', $subcat_id2);
	$this->db->where('sub_category_id3', $subcat_id3);
	$query = $this->db->get('product_custom_fields');
	return $query->result_array();
}


public function search_product()
{
	$this->db->select('products.product_name,products.product_id,products.selling_price,');
	$this->db->where('cat_id', $_POST['cat_id']);
	$this->db->where('status', 1);
	if($_POST['sub_catid1'])
	{
		$this->db->where('sub_catid1', $_POST['sub_catid1']);
	}
	if($_POST['sub_catid2'])
	{
		$this->db->where('sub_catid2', $_POST['sub_catid2']);
	}
	if($_POST['sub_catid3'])
	{
		$this->db->where('sub_catid3', $_POST['sub_catid3']);
	}
	$query = $this->db->get('products');
	return $query->result();
}

public function get_payout_detail($value='')
{
	$this->db->where('user_id', $this->session->userdata('admin_id'));
	$query = $this->db->get('monthly_revenue');

	return $query->row();
}

public function get_credit_limit()
{
	$this->db->select('credit_limit');
	$this->db->where('id', $this->session->userdata('admin_id'));
	$query = $this->db->get('mlm_users');
	return $query->row();
}

}