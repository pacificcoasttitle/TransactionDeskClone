<style type="text/css">
.text-success{
color: green;
}
.text-dander{
color: red;
}
</style>
<!-- page content -->
<div class="right_col" role="main">
  <div class="">
    
    <div class="clearfix">
      <ol class="breadcrumb">
        <li>
          <a href="<?=base_url()?>index.php/admin">Dashboard</a>
        </li> <li>
        <?php if ($page_head == "Add User"): ?>
        <a href="<?=base_url()?>index.php/admin/users">Users</a>
        <?php else: ?>
        <a href="<?=base_url()?>index.php/admin/associates">Associates</a>
        <?php endif ?>
        
      </li>
      <li class="active"><?=$page_head?></li>
    </ol>
  </div>
  <div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
      <div class="x_panel" >
        <div class="x_title">
          <h2><?=$page_head?></h2>
          
          <div class="clearfix"></div>
        </div>
        <div class="x_content">
          <form action="<?=base_url()?>index.php/admin/add_<?=$active?>/" method="POST" role="form" class="form-horizontal form-label-left">
            
            <div data-example-id="togglable-tabs" role="tabpanel" class="">
              <ul role="tablist" class="nav nav-tabs bar_tabs" id="myTab">
                
                <li class="active" role="presentation"><a aria-expanded="false" data-toggle="tab" id="profile-tab" role="tab" href="#tab_content2">Personal information</a>
              </li>
             
          </ul>
          <div class="tab-content" id="myTabContent">
            <!-- product -->
            <div aria-labelledby="home-tab" id="tab_content1" class="tab-pane fade " role="tabpanel">
              <a type="button" onclick="add_prod()"  class="btn btn-default pull-right">Add New Plot</a>
              
              <div id="add_plots" style="display:none;">
                <table id="example" class="table table-striped responsive-utilities jambo_table">
                  <thead>
                    <tr class="headings">
                      <!--  <th>
                        <input type="checkbox" class="tableflat">
                      </th> -->
                      <th>Sr. No.</th>
                      <th>Site Name</th>
                      <th>Plot Number</th>
                      <th>Size </th>
                      <th>Commercial</th>
                      <th>Corner</th>
                      <th>Prime Location</th>
                      <th>Price</th>
                      <th>Type </th>
                      <th class=" no-link last"><span class="nobr">Action</span>
                    </th>
                  </tr>
                </thead>
                <tbody>
                  <?php $i=1; foreach ($plots as $key): ?>
                  
                  
                  <tr class="even pointer">
                    <td><?=$i?></td>
                    <td class=" "><?=$key->site_name?></td>
                    <td class=" "><?=$key->plot_number?></td>
                    <td class=" "><?=$key->size?> </td>
                    <td class=" "><?=($key->commercial == '1')?'Yes':'No'?> </td>
                    <td class=" "><?=($key->corner == '1')?'Yes':'No'?> </td>
                    <td class=" "><?=($key->prime_location == '1')?'Yes':'No'?> </td>
                    <td class=" "><?php  echo $key->price;?></td>
                    <td class=" "><?php  echo $key->type;?></td>
                    <!-- <td class=" "><?=($key->status=="1")?"Active":"Inactive"?></td> -->
                    <td class=" last">
                      
                      <a type="button" href="<?=base_url()?>index.php/admin/choose_plot/<?=$key->plot_id?>"  ><i class="fa fa-check"></i> Choose</a>
                      
                    </td>
                  </tr>
                  <?php $i++; endforeach ?>
                </tbody>
              </table>
            </div>
            <div class="row">
              <div class="col-xs-12 ">
                <table class="table table-striped" >
                  <?php  if ($cart = $this->cart->contents()): ?>
                  <thead  >
                    
                    <th colspan="2">Site Name</th>
                    <th >Plot Number</th>
                    <th>Amount</th>
                    <th>Type</th>
                    <th>Options</th>
                  </thead>
                  <?php
                  //print_r($cart);
                  echo form_open('cart/update_cart');
                  $grand_total = 0; $i = 1;
                  
                  foreach ($cart as $item):
                  echo form_hidden('cart['. $item['id'] .'][id]', $item['id']);
                  echo form_hidden('cart['. $item['id'] .'][rowid]', $item['rowid']);
                  echo form_hidden('cart['. $item['id'] .'][name]', $item['name']);
                  echo form_hidden('cart['. $item['id'] .'][number]', $item['number']);
                  echo form_hidden('cart['. $item['id'] .'][price]', $item['price']);
                  echo form_hidden('cart['. $item['id'] .'][type]', $item['type']);
                  echo form_hidden('cart['. $item['id'] .'][qty]', $item['qty']);
                  ?>
                  <tbody>
                    <tr >
                      
                      <td>
                        <?php $key = $this->admin_model->get_site_images($item['id']);  // print_r($key);?>
                        <img src="<?=base_url()?>upload/site/<?=$this->session->userdata('admin_id')?>/<?=$key->site_id;?>/<?=$key->image1?>" width="70" height="70"  border="0" >
                      </td><td><?php echo $item['name']; ?>
                    </td>
                    <td>
                      <?php echo $item['plot_number']; ?>
                    </td>
                    
                    <?php $grand_total = $grand_total + $item['subtotal']; ?>
                    <td>
                      <i class="fa fa-inr"></i>&nbsp; <?php echo number_format($item['subtotal'],2) ?>
                    </td>
                    <td>
                      <?php echo ($item['type']) ?>
                    </td>
                    <td>
                      <?php echo anchor('admin/remove_product/'.$item['rowid'].'?type='.$active,'<i class="fa fa-remove"></i>',array('class' => 'btn btn-danger')); ?>
                    </td>
                    <?php endforeach; ?>
                  </tr>
                  <tr>
                    <td colspan="4"></td>
                    <td > Total:</td>
                    <td align="right"><b><i class="fa fa-inr"></i>&nbsp;<?php echo number_format($grand_total,2); ?></b></td>
                  </tr>
                  <tr>
                    
                    <td  style="text-align: right: "><h2 style="color: #555" >Total:</h2></td>
                    <td colspan="5"><h2 class="pull-right"><i class="fa fa-inr"></i>&nbsp;<?php echo number_format($grand_total,2); ?></h2></td>
                  </tr>
                  
                  <?php else: ?>
                  <tr><td>No Plot added. </td></tr>
                  <?php endif; ?>
                </tbody>
              </table>
              
              
            </div>
          </div>
        </div>
        <!-- personal -->
        <div aria-labelledby="profile-tab" id="tab_content2" class="tab-pane fade active in" role="tabpanel">
          
          <div class="form-group">
            <label for="" class="control-label col-md-3 col-sm-3 col-xs-12">Upline ID</label>
            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
              <input type="text"  class="form-control" id="parent_ref_id" placeholder="" name="parent_ref_id" required value="MLM" onblur="check_ref_id(this.value)">
              <div id="output" style="display:none;">
                <div id="output_div" >
                  <p class = "text-danger" id="output_body"></p>
                </div>
              </div>
            </div>
          </div>
          <div class="form-group">
            <label for="" class="control-label col-md-3 col-sm-3 col-xs-12">Date Of booking</label>
            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
              <input type="text" class="form-control" id="" placeholder="" name="booking_date" required value="<?=date('Y-m-d')?>">
            </div>
          </div>
          
          
          <div class="form-group">
            <label for="" class="control-label col-md-3 col-sm-3 col-xs-12">Customer Name</label>
            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
              <input type="text" class="form-control" id="" placeholder="" name="name" required value="">
            </div>
          </div>

          <!-- <div class="form-group">
            <label for="" class="control-label col-md-3 col-sm-3 col-xs-12">Customer Name</label>
            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
              <input type="text" class="form-control" id="" placeholder="" name="name" required value="">
              <select name="salutation"  class="form-control"> 
                <option>Dr.</option>
                <option>Prof.</option>
                <option>Mr.</option>
              </select>
            </div>
          </div> -->
          
          <div class="form-group">
            <label for="" class="control-label col-md-3 col-sm-3 col-xs-12">Email</label>
            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
              <input type="text" class="form-control" id="" placeholder="" name="username" required value="">
            </div>
          </div>
          
          <div class="form-group">
            <label for="" class="control-label col-md-3 col-sm-3 col-xs-12">Password</label>
            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
              <input type="text" class="form-control" id="" placeholder="" name="password" required value="">
            </div>
          </div>

          <div class="form-group">
            <label for="" class="control-label col-md-3 col-sm-3 col-xs-12">Gender</label>
            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
              <div class="radio">
                <label>
                  <input type="radio" name="gender" id="inputIndian" value="Male" checked="checked">
                  Male
                </label>
                
                <label>
                  <input type="radio" name="gender" id="inputIndian" value="Female" >
                  Female
                </label>
              </div>
            </div>
          </div>
          <div class="form-group">
            <label for="" class="control-label col-md-3 col-sm-3 col-xs-12">DOB</label>
            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
              <input type="date" class="form-control datepicker" placeholder="" name="travel_date"  >
            </div>
          </div>
          <div class="form-group">
            <label for="" class="control-label col-md-3 col-sm-3 col-xs-12">Nomine</label>
            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
              <input type="text" class="form-control" id="" placeholder="" name="name" required value="">
            </div>
          </div>
          <div class="form-group">
            <label for="" class="control-label col-md-3 col-sm-3 col-xs-12">Mobile</label>
            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
              <input type="text" pattern="^\d{10}$" onkeypress="return isNumber(event)" class="form-control" id="" maxlength="10" placeholder="" name="mobile" value="">
            </div>
          </div>
          <div class="form-group">
            <label for="" class="control-label col-md-3 col-sm-3 col-xs-12">Address</label>
            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
              <input type="text" class="form-control" id="" placeholder="" name="address" value="">
            </div>
          </div>
          <div class="form-group">
            <label for="" class="control-label col-md-3 col-sm-3 col-xs-12">Country</label>
            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
              <select name="country" id="country" onchange = "check_country(this.value)"  class="form-control">
                <option value="" class="s">Select Country</option>
                <?php foreach ($countries as $key): ?>
                <option value="<?=$key->country_title?>"><?=$key->country_title?></option>
                <?php endforeach ?>
              </select>
            </div>
          </div>
          
          <div class="form-group" id="state_p">
            <label for="" class="control-label col-md-3 col-sm-3 col-xs-12">State </label>
            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
              <select name="state" onchange = "get_cities(this.value)" id="state" class="form-control">
                <option value="">Select State</option>
                <?php foreach ($states as $key): ?>
                <option value="<?=$key->state_id?>,<?=$key->state?>"><?=$key->state?></option>
                <?php endforeach ?>
              </select>
              <input type="text" id = "state" name="" class="form-control" style="display:none">
            </div>
          </div>
          <div class="form-group"  id="city_p">
            <label for="" class="control-label col-md-3 col-sm-3 col-xs-12"> City </label>
            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
              <select name="city" id="city" class="form-control">
                <option value="">Select City</option>
                <?php foreach ($cities as $key): ?>
                <option class = "cities_<?=$key->state_id?>" value="<?=$key->city?>"><?=$key->city?></option>
                <?php endforeach ?>
              </select>
              <input type="text" id = "city" name="" class="form-control" style="display:none">
            </div>
          </div>
          
          
          <div class="form-group">
            <label for="" class="control-label col-md-3 col-sm-3 col-xs-12">Zipcode</label>
            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
              <input type="text" class="form-control" id="" placeholder="" name="zipcode" value="">
            </div>
          </div>
     
    <legend>Project Details</legend>

          
<?php if ($active == 'associate'): ?>
<div class="form-group">
            <label for="" class="control-label col-md-3 col-sm-3 col-xs-12">Associate Type</label>
            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
              <input type="radio" name="role_id" value="1" checked> Project associate
              <input type="radio" name="role_id" value="3"> Sales Associate
              <input type="radio" name="role_id" value="4"> Frenchise Associate
            </div>
          </div>
  

  <?php endif ?> 
  
  <?php if ($active == 'user'): ?>
    <input type="hidden" name="role_id" id="inputRole_id" class="form-control" value="2">

  <?php endif ?> 


          <div class="form-group">
            <label for="" class="control-label col-md-3 col-sm-3 col-xs-12">Project</label>
            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
              <select name="project_id" id="project_sites" class="form-control"  required="required">
                <option value="0">Select Plot</option>
                <?php 
                  foreach ($sites as $key => $site) {
                    echo '<option value="'.$site->site_id.'">'.$site->site_name.'</option>';
                  }
                 ?>
              </select>
            </div>
          </div>


<?php if ($active == 'user'): ?>
       
   

          <div class="form-group">
            <label for="" class="control-label col-md-3 col-sm-3 col-xs-12">Plot Type</label>
            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
              <input type="checkbox" name="plot_type" value="corner" checked> Corner
              <input type="checkbox" name="plot_type" value="commercial"> Commercial
              <input type="checkbox" name="plot_type" value="prime_location"> Prime
            </div>
          </div>

          <div class="form-group">
            <label for="" class="control-label col-md-3 col-sm-3 col-xs-12">Plot Number</label>
            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
              <select name="plot_number" id="project_plots"  class="form-control" required="required">
                
              </select>
              <!-- <input type="text"  class="form-control" placeholder=""   name="plot_number" required value=""> -->
            </div>
          </div>
          <div class="form-group">
            <label for="" class="control-label col-md-3 col-sm-3 col-xs-12">Plot Area</label>
            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
              <input type="text"  class="form-control" placeholder=""   name="plot_area" required value="">
            </div>
          </div>
          <div class="form-group">
            <label for="" class="control-label col-md-3 col-sm-3 col-xs-12">Plot Rate</label>
            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
              <input type="text"  class="form-control" placeholder=""   name="rate" required value="">
            </div>
          </div>
          <div class="form-group">
            <label for="" class="control-label col-md-3 col-sm-3 col-xs-12">Total Plot Amount</label>
            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
              <input type="text"  class="form-control" placeholder=""   name="total_plot_amount" required value="">
            </div>
          </div>
          <div class="form-group">
            <label for="" class="control-label col-md-3 col-sm-3 col-xs-12">Instalments </label>
            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
              <input type="text"  class="form-control" placeholder=""   name="installments_count" required value="">
            </div>
          </div>
            
          <legend>Payment Details</legend>
          
          
          <div class="form-group">
            <label for="" class="control-label col-md-3 col-sm-3 col-xs-12">Downpayment</label>
            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
              <input type="text"  class="form-control" id="email" placeholder=""   name="paid_amount" required value="">
            </div>
          </div>
          <div class="form-group">
            <label for="" class="control-label col-md-3 col-sm-3 col-xs-12">Total Amount</label>
            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
              <input type="text"  class="form-control" id="email" placeholder="" readonly=""  name="total_amount" required value="<?php if($grand_total){echo number_format($grand_total,2,'.',''); }?>">
            </div>
          </div>
          <div class="form-group">
            <label for="" class="control-label col-md-3 col-sm-3 col-xs-12">Payment Option</label>
            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
              <select name="payment_option" id="inputPayment_option" onchange="get_emi_option(this.value)" class="form-control" required="required">
                <option>Cash</option>
                <option>EMI</option>
              </select>
            </div>
          </div>
           <?php endif ?> 
          <legend>Bank Details</legend>
          <div class="form-group">
            <label for="" class="control-label col-md-3 col-sm-3 col-xs-12">Benificiary Name</label>
            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
              <input type="text" class="form-control" id="" placeholder="" name="benificiary_name" value="<?=$user_info->benificiary_name?>">
            </div>
          </div>
          <div class="form-group">
            <label for="" class="control-label col-md-3 col-sm-3 col-xs-12">Bank Name</label>
            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
              <input type="text" class="form-control" id="" placeholder="" name="bank_name" value="<?=$user_info->bank_name?>">
            </div>
          </div>
          <div class="form-group">
            <label for="" class="control-label col-md-3 col-sm-3 col-xs-12">Branch Name</label>
            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
              <input type="text" class="form-control" id="" placeholder="" name="branch_name" value="<?=$user_info->bank_name?>">
            </div>
          </div>
          <div class="form-group">
            <label for="" class="control-label col-md-3 col-sm-3 col-xs-12">Address</label>
            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
              <input type="text" class="form-control" id="" placeholder="" name="bank_address" value="<?=$user_info->bank_address?>">
            </div>
          </div>
          <div class="form-group">
            <label for="" class="control-label col-md-3 col-sm-3 col-xs-12">Account Number</label>
            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
              <input type="text" class="form-control" id="" placeholder="" name="account_no" value="<?=$user_info->account_no?>">
            </div>
          </div>
          <div class="form-group">
            <label for="" class="control-label col-md-3 col-sm-3 col-xs-12">IFSC Code</label>
            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
              <input type="text" class="form-control" id="" placeholder="" name="ifsc" value="<?=$user_info->ifsc?>">
            </div>
          </div>
          <div class="form-group">
            <label for="" class="control-label col-md-3 col-sm-3 col-xs-12">Pan Card</label>
            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
              <input type="text" class="form-control" id="" placeholder="" name="pancard" value="<?=$user_info->ifsc?>">
            </div>
          </div>
          
          <input type="hidden" name="" id="inputref_stat" class="form-control" value="">
          <button id="button_user" type="submit" class="btn btn-primary pull-right">Add</button>
        </div>
        
      </div>
    </div>
    
    
    
    
    
  </form>
  
</div>
</div>
</div>
</div>
</div>
<div class="modal fade" id="add_prod">
<div class="modal-dialog">
<div class="modal-content">
<div class="modal-header">
<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
<h4 class="modal-title">Add New Product</h4>
</div>
<div class="modal-body">
<form action="" method="POST" role="form" id="product_search_form">
  <div class="form-group clearfix">
    <label class="col-lg-3">Product Category:</label>
    <div class="col-lg-5">
      
      <select class="form-control" name = "cat_id" id = "cat_id" onchange="get_sub(1,this.value)">
        <option value=""> -- Select one -- </option>
        <?php foreach ($category as $key): ?>
        <?php if ($key->parent_category_id == 0): ?>
        <option value="<?=$key->category_id?>"><?=$key->category_name?></option>
        <?php endif ?>
        <?php endforeach ?>
      </select>
      
    </div>
    <!--  <div class="col-lg-4">
      <button type="button" onclick = "show_fields(1)" class="btn btn-primary">Add product for this category</button>
    </div> -->
  </div>
  <div class="form-group clearfix"  id="sub_1" style="display:none;">
    <label class="col-lg-3">Product sub Category(1):</label>
    <div class="col-lg-5">
      
      <select class="form-control" name = "sub_catid1" id="sub_sel_1" onchange="get_sub(2,this.value)">
        <option value=""> -- Select one -- </option>
        <?php foreach ($category as $key): ?>
        <?php if ($key->parent_category_id != 0): ?>
        <option style="display:none;" class = "sub1_<?=$key->parent_category_id?>" value="<?=$key->category_id?>"><?=$key->category_name?></option>
        <?php endif ?>
        <?php endforeach ?>
      </select>
      
    </div>
    <!--  <div class="col-lg-4">
      <button type="button" onclick = "show_fields(2)" class="btn btn-primary">Add product for this sub-category</button>
    </div> -->
  </div>
  <div class="form-group clearfix" id="sub_2" style="display:none;">
    <label class="col-lg-3">Product sub Category(2):</label>
    <div class="col-lg-5">
      
      <select class="form-control" name = "sub_catid2" id="sub_sel_2" onchange="get_sub(3,this.value)">
        <option value=""> -- Select one -- </option>
        <?php foreach ($category as $key): ?>
        <?php if ($key->parent_category_id != 0): ?>
        <option style="display:none;" class = "sub2_<?=$key->parent_category_id?>" value="<?=$key->category_id?>"><?=$key->category_name?></option>
        <?php endif ?>
        <?php endforeach ?>
      </select>
      
    </div>
    <!--  <div class="col-lg-4">
      <button type="button" onclick = "show_fields(3)" class="btn btn-primary">Add product for this sub-category</button>
    </div> -->
  </div>
  <div class="form-group clearfix"   id="sub_3" style="display:none;">
    <label class="col-lg-3">Product sub Category(3):</label>
    <div class="col-lg-5">
      
      <select class="form-control" name = "sub_catid3" id="sub_sel_3" onchange="get_sub(4,this.value)">
        <option value=""> -- Select one -- </option>
        <?php foreach ($category as $key): ?>
        <?php if ($key->parent_category_id != 0): ?>
        <option style="display:none;" class = "sub3_<?=$key->parent_category_id?>" value="<?=$key->category_id?>"><?=$key->category_name?></option>
        <?php endif ?>
        <?php endforeach ?>
      </select>
      
    </div>
  </div>
  <input type="hidden" name="return" id="inputReturn" class="form-control" value="<?=$active?>">
  <button  type="button" id="product_search" style="display:none;" onclick="product_searchac()" class="btn btn-primary">Search Product</button>
  <table id="product_search_table" class="table table-bordered table-hover" style="display:none;">
    <thead>
      <tr>
        <th>Product Name</th>
        <th>Price</th>
        <!-- <th>Image</th> -->
        <th>Action</th>
      </tr>
    </thead>
    <tbody id="product_search_res">
      
    </tbody>
  </table>
</form>
</div>
<div class="modal-footer">
<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
<button type="button" class="btn btn-primary">Save changes</button>
</div>
</div>
</div>
</div>
<script type="text/javascript">
function check_country (name)
{
if(name != "India")
{
$("#state_p select").attr("name","");
$("#state_p select").attr("id","state_");
$("#state_p select").attr("class"," ");
$("#state_p select").hide();
$("#city_p select").attr("name","");
$("#city_p select").attr("id","city_");
$("#city_p select").attr("class"," ");
$("#city_p select").hide();
$("#state_p input").attr("name","state");
$("#state_p input").attr("id","state");
$("#state_p input").attr("class","form-control");
$("#state_p input").show();
$("#city_p input").attr("name","city");
$("#city_p input").attr("id","city");
$("#city_p input").attr("class","form-control");
$("#city_p input").show();
}
else
{
$("#state_p select").attr("name","state");
$("#state_p select").attr("id","state");
$("#state_p select").attr("class","form-control");
$("#state_p select").show();
$("#city_p select").attr("name","city");
$("#city_p select").attr("id","city");
$("#city_p select").attr("class","form-control");
$("#city_p select").show();
$("#state_p input").attr("name","");
$("#state_p input").attr("id","state_");
$("#state_p input").attr("class"," ");
$("#state_p input").hide();
$("#city_p input").attr("name","");
$("#city_p input").attr("id","city_");
$("#city_p input").attr("class"," ");
$("#city_p input").hide();
}
}
function get_cities (value)
{
var con_id = value.split(",");
$.ajax({
url     : "<?=base_url()?>index.php/admin/get_city_list/"+con_id[0],
type    : "POST",
success : function( data )
{

$("#city").html(data);
},
error   : function( xhr, err )
{
alert('Error');
return false;
}
});
}
function check_ref_id (ref_id)
{
$.ajax({
url     : "<?=base_url()?>index.php/admin/check_ref_id?ref_id="+ref_id,
type    : "get",
success : function( data )
{
if(data == 0){
$("#output_body").html("");
$("#output_div").attr("class","text-danger");
$("#output_body").attr("class","text-danger");
$("#output_body").html("This reference-id is not Correct. !!");
$("#output").show();
$("#parent_ref_id").focus();
//$("#button_user").prop("type",'button');
$("#button_user").attr("disabled","disabled");
$("#inputref_stat").val(0);
return false;
}
else if(data == "#")
{
$("#output").hide();
$("#output_div").attr("class","text-danger");
$("#output_body").attr("class","text-danger");
$("#output_body").html("Maximum Levels are Completed for this reference-id.");
$("#output").show();
$("#submit_btn").prop("type",'submit');
$("#button_user").attr("disabled","disabled");
$("#inputref_stat").val(0);
return false;
}
else
{
$("#output").hide();
$("#output_div").attr("class","text-success");
$("#output_body").attr("class","text-success");
$("#output_body").html("Reference-id is Correct !!");
$("#output").show();
$("#submit_btn").prop("type",'submit');
$("#button_user").removeAttr("disabled");
$("#inputref_stat").val(1);
return true;
}
},
});
}
function check_email()
{
var email_id = $("#email").val();
var ref_id = $("#parent_ref_id").val();
var ref_stat =  $("#inputref_stat").val();
if(ref_stat == 0)
{
$("#parent_ref_id").focus();
return false;
}
//alert(email_id);
if(email_id == "")
{
$("#output_body").attr("class","text-danger");
$("#output_body").html("please fill email first.!!");
$("#output").show();
$("#email_id").focus();
}
else
{
$("#output_body").html("");
$("#output").hide();
$("#output_div").attr("class","text-danger");
$("#output_body").attr("class","text-danger");
var regex = /^([a-zA-Z0-9_\.\-\+])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
if(!regex.test(email_id))
{
$("#output_body").html("INCORRECT EMAIL ID! ");
$("#output").show();
$("#email_id").focus();
return false;
}
$.ajax({
url     : "<?=base_url()?>index.php/admin/check_availability_email?email="+email_id,
type    : "post",
success : function( data )
{
if(data == 0){
$("#output_body").html("");
$("#output_body").html("This email-id is not available. !!");
$("#output").show();
//$("#button_user").prop("type",'button');
$("#button_user").attr("disabled","disabled");
return false;
}
else
{
$("#output").hide();
$("#output_div").attr("class","text-success");
$("#output_body").attr("class","text-success");
$("#output_body").html("This email-id is available. !!");
$("#output").show();
$("#submit_btn").prop("type",'submit');
$("#button_user").removeAttr("disabled");
return true;
}
},
});
}
}
function get_sub(id,p_id)
{
$("#sub_"+id+" option").hide();
var count = $(".sub"+id+"_"+p_id);
for(var i = id+1;i<=4;i++)
{
$("#sub_"+i).hide();
}
if(count.length)
{
$(".sub"+id+"_"+p_id).show();
$("#sub_"+id).slideDown('500');
$("#sub_sel_"+id).val("");
$("#product_search").hide();


}
else
{
$("#product_search").show();
}


}
function product_searchac()
{
var form_data = $("#product_search_form").serialize();
$.ajax({
url     : "<?=base_url()?>index.php/admin/search_product",
type    : "post",
data    : form_data,
success : function( data )
{
//alert(data);
if(data)
{
$("#product_search_res").html(data);
$("#product_search_table").show();
}

},
});
}
function get_emi_option(val)
{
if(val=='EMI')
{
$("#emi_option_field").show();
$("#emi_option_select").attr('required','required');
}
else
{
$("#emi_option_field").hide();
$("#emi_option_select").removeAttr('required');
}
}
function add_prod (argument) {
$("#add_plots").show();
}
</script>