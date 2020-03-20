 <!-- page content -->
            <div class="right_col" role="main">
                <div class="">
                    
                    <div class="clearfix">
                      <ol class="breadcrumb">
                        <li>
                          <a href="<?=base_url()?>index.php/admin">Dashboard</a>
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

                                     <form action="<?=base_url()?>index.php/admin/update_user/<?=$user_info->id?>" method="POST" role="form" class="form-horizontal form-label-left">
                                    
                                     <div class="row">
                                        <div class="col-md-6">
                                          <div class="row">
                                            <div class="col-md-2">
                                            </div>
                                            <div class="col-md-3">
                                              <div class="form-group">
                                                <a href="javascript:;" id="change-user-pic">
                                                  <?php 

                                                  if(empty($user_info->profile_pic)){
                                                    $profile_pic =  base_url().'assets/admin/images/user.png'; 
                                                  }else{
                                                    $profile_pic =  base_url().$user_info->profile_pic; 
                                                  }
                                                  ?>

                                                  <img class="img-circle" src="<?php echo $profile_pic; ?>" style="width:100px;height:100px;">
                                                  <input name="user_pic" value=""  hidden/> 
                                                </a>
                                                  <input type="file" id="change-user-pic-file" class="hide" />
                                              </div>
                                            </div>
                                            <div class="col-md-7" align="left">
                                              
                                              <div class="form-group">
                                                  <label for="" class="control-label col-md-3 col-sm-3 col-xs-12">Name</label>
                                                  <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                                                      <input type="text" class="form-control" id="" placeholder="" name="name" required value="<?=$user_info->name?>">
                                                  </div>
                                              </div>

                                               

                                               
                                              <div class="form-group">
                                                  <label for="" class="control-label col-md-3 col-sm-3 col-xs-12">Gender</label>
                                                  <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                                                       <div class="radio">
                                                          <label>
                                                              <input type="radio" name="gender" id="inputIndian" value="Male" <?=($user_info->gender=='Male')?'checked="checked"':NULL?>>
                                                              Male
                                                          </label>
                                                          
                                                          <label>
                                                              <input type="radio" name="gender" id="inputIndian" value="Female" <?=($user_info->gender=='Female')?'checked="checked"':NULL?>>
                                                              Female
                                                          </label>
                                                      </div>
                                                  </div>
                                              </div>
                                            </div>
                                          </div>


                                          <div class="form-group">
                                              <label for="" class="control-label col-md-3 col-sm-3 col-xs-12">Mobile</label>
                                              <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                                                  <input type="text" pattern="^[0-9]+$" class="form-control" id="" maxlength="10" placeholder="" name="mobile" value="<?=$user_info->mobile?>">
                                              </div>
                                          </div>

                                          <div class="form-group">
                                              <label for="" class="control-label col-md-3 col-sm-3 col-xs-12">Address</label>
                                              <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                                                  <input type="text" class="form-control" id="" placeholder="" name="address" value="<?=$user_info->address?>">
                                              </div>
                                          </div> 
                                          
                                          <div class="form-group">
                                              <label for="" class="control-label col-md-3 col-sm-3 col-xs-12">Country</label>
                                              <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                                               <select name="country" id="country" onchange = "check_country(this.value)"  class="form-control">
                                                  <option value="" class="s">Select Country</option>
                                                  <?php foreach ($countries as $key): ?>
                                                     <option <?=($user_info->country==$key->country_title)?'selected="true"':NULL?> value="<?=$key->country_title?>"><?=$key->country_title?></option>
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
                                                   <option <?=($user_info->state== $key->state_id.",".$key->state)?'selected="true"':NULL?> value="<?=$key->state_id?>,<?=$key->state?>"><?=$key->state?></option>
                                                <?php endforeach ?>
                                              </select>
                                              <input type="text" id = "state" name="" class="form-control" style="display:none" value="<?=$user_info->state?>">
                                            </div>
                                          </div>
                                          
                                          <div class="form-group"  id="city_p">
                                           <label for="" class="control-label col-md-3 col-sm-3 col-xs-12"> City </label>
                                           <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                                            <select name="city" id="city" class="form-control">
                                              <option value="">Select City</option>
                                               <?php foreach ($cities as $key): ?>
                                                 <option <?=($user_info->city== $key->city)?'selected="true"':NULL?> class = "cities_<?=$key->state_id?>" value="<?=$key->city?>"><?=$key->city?></option>
                                              <?php endforeach ?>
                                            </select>
                                            <input type="text" id = "city" name="" class="form-control" style="display:none" value="<?=$user_info->city?>">
                                            </div>
                                          </div>
                                          

                                          

                                          <div class="form-group">
                                              <label for="" class="control-label col-md-3 col-sm-3 col-xs-12">Zipcode</label>
                                              <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                                                  <input type="text" class="form-control" id="" placeholder="" name="zipcode" value="<?=$user_info->zipcode?>">
                                              </div>
                                          </div>

                                        </div>


                                        <div class="col-md-6">
                                          <div class="form-group">
                                              <label for="" class="control-label col-md-3 col-sm-3 col-xs-12">Username</label>
                                              <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                                                  <input type="text"  class="form-control" id="" placeholder="" name="username" required value="<?=$user_info->username?>" readonly>
                                              </div>
                                          </div>
                                          <div class="form-group">
                                              <label for="" class="control-label col-md-3 col-sm-3 col-xs-12">Parent Reference ID</label>
                                              <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                                                  <input type="text"  class="form-control" id="" placeholder="" name="parent_ref_id" required value="<?=$user_info->parent_ref_id?>" readonly>
                                              </div>
                                          </div>
                                         <div class="form-group">
                                              <label for="" class="control-label col-md-3 col-sm-3 col-xs-12">User ID</label>
                                              <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                                                  <input type="text"  class="form-control" id="" placeholder="" name="ref_id" required value="<?=$user_info->ref_id?>" readonly>
                                              </div>
                                          </div>

                                          <div class="form-group">
                                              <label for="" class="control-label col-md-3 col-sm-3 col-xs-12">Company Name</label>
                                              <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                                                  <input type="text" class="form-control" id="" placeholder="" name="company_name" value="<?=$user_info->company_name?>">
                                              </div>
                                            </div>
                                            <div class="form-group" <?=($active=='user')?'style="display:none;"':NULL?>>
                                              <label for="" class="control-label col-md-3 col-sm-3 col-xs-12">Credit Limit</label>
                                              <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                                                  <input type="text" class="form-control" id="" placeholder="" name="credit_limit" value="<?=$user_info->credit_limit?>">
                                              </div>
                                          </div>
                                          
                                          <div class="form-group">
                                              <label for="" class="control-label col-md-3 col-sm-3 col-xs-12">Additional Information</label>
                                              <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                                                  <input type="text" class="form-control" id="" placeholder="" name="additional" value="<?=$user_info->additional?>">
                                              </div>
                                          </div>
                                          
                                          <div class="form-group">
                                              <label for="" class="control-label col-md-3 col-sm-3 col-xs-12">Level Acieve</label>
                                              <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                                                  <input type="text" class="form-control" id="" placeholder="" name="level_achieve" value="<?=$user_info->additional?>">
                                              </div>
                                          </div>
                                    
                                          <div class="form-group">
                                              <label for="" class="control-label col-md-3 col-sm-3 col-xs-12">Level Title</label>
                                              <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                                                  <input type="text" class="form-control" id="" placeholder="" name="level_title" value="<?=$user_info->additional?>">
                                              </div>
                                          </div>
                                          
                                          <div class="form-group">
                                              <label for="" class="control-label col-md-3 col-sm-3 col-xs-12">Last Payout</label>
                                              <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                                                  <input type="text" class="form-control" id="" placeholder="" name="last_payout" value="<?=$user_info->additional?>">
                                              </div>
                                          </div>
                                          <div class="form-group">
                                              <label for="" class="control-label col-md-3 col-sm-3 col-xs-12">Payout Date</label>
                                              <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                                                  <input type="text" class="form-control" id="" placeholder="" name="payout_date" value="<?=$user_info->additional?>">
                                              </div>
                                          </div>
                                    
                                        </div>
                                        
                                     </div>



                                    
                                      
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

                                    <!-- Current Month Payout -->
                                    <legend>Level wise payout</legend>
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

                                   
                                    <!-- Current Month Payout -->
                                    <legend>Due installments</legend>
                                    <table class="table table-hover">
                                      <thead>
                                        <tr>
                                          <th>Amount</th>
                                          <th>Due Date</th>
                                          <th>User ID</th>
                                          <th>User Name</th>
                                          <th>Status</th>
                                        </tr>
                                      </thead>
                                      <tbody>

                                        <?php 
                                          foreach ($installments as $key => $install_ment) {
                                        ?>

                                        <tr>
                                          <td><?php echo $install_ment->amount; ?></td>
                                          <td><?php echo $install_ment->due_date; ?></td>
                                          <td><?php echo $install_ment->user_id_fk; ?></td>
                                          <td><?php echo $install_ment->name; ?></td>
                                          <td><?php if($install_ment->is_paid=='N'){ echo 'Not Paid'; }else{echo 'Paid';} ; ?></td>
                                        </tr>
                                        
                                        <?php
                                          }
                                        ?>
                                      </tbody>
                                    </table>

                                   
                                    <input type="hidden" name="role_id" id="inputRole_id" class="form-control" value="2">
                                    
                                
                                    <button type="submit" class="btn btn-primary pull-right">Update</button>
                                </form>
                            
                                </div>
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
                </script>