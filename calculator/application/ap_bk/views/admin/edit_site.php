 <!-- page content -->
            <div class="right_col" role="main">
                <div class="">
                
                    <div class="clearfix"></div>

                    <div class="row">

                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <div class="x_panel" style="height:1800px;">
                                <div class="x_title">
                                    <h2>Edit Site</h2>
                                    
                                    <div class="clearfix"></div>
                                </div>

                                <div class="x_content">
                                        <div class="row">
                
                <div class="position-center">                    
                   
                 
                       
                      <form name="form" id="" class="form-horizontal" action="<?=base_url()?>index.php/admin/update_site/<?=$site->site_id?>" method="post" enctype="multipart/form-data">
                       <div class="form-group col-lg-6">
                        <label for="">Name</label>
                        <input type="text" class="form-control" id="" placeholder="" name="site_name" value="<?=$site->site_name?>" required="required">
                    </div>
                    <div class="form-group  col-lg-6">
                        <label for="">Location</label>
                        <input type="text" class="form-control" id="" placeholder="" name="location" value="<?=$site->location?>" required="required">
                    </div>
                    <div class="form-group  col-lg-6">
                        <label for="">State</label>
                        <input type="text" class="form-control" id="" placeholder="" name="state" value="<?=$site->state?>" required="required">
                    </div>
                    <div class="form-group  col-lg-6">
                        <label for="">City</label>
                        <input type="text" class="form-control" id="" placeholder="" name="city" value="<?=$site->city?>" required="required">
                    </div>
                    <div class="form-group  col-lg-6">
                        <label for="">Rate (per square mtr.)</label>
                        <input type="text" class="form-control"  onkeypress="return isNumber(event)" id="" placeholder="" name="rate" value="<?=$site->rate?>" required="required">
                    </div>

                <div class="form-group  col-lg-6">
                        <label for="">Brief Description</label>
                        <textarea class="form-control" id="" placeholder="" name="description"  required="required"><?=$site->description?></textarea>
                    </div>
                   <div class="form-group  col-lg-6">
                        <label for="">Area</label>
                        <input type="text"  onkeypress="return isNumber(event)" class="form-control" id="" placeholder="" name="area" value="<?=$site->area?>" required="required">
                    </div>

                    <div class="form-group  col-lg-6">
                        <label for="">Road Area</label>
                        <input type="text" onkeypress="return isNumber(event)" class="form-control" id="" placeholder="" name="road_area" value="<?=$site->road_area?>" required="required">
                    </div>
                  <div class="form-group  col-lg-6">
                        <label for="">Plot Area</label>
                        <input type="text" onkeypress="return isNumber(event)" class="form-control" id="" placeholder="" name="plot_area" value="<?=$site->plot_area?>" required="required">
                    </div>
                    <div class="form-group  col-lg-6">
                        <label for="">Plan </label>
                        <select class="form-control" id="" placeholder="" name="plan_id_fk"  required="required">
                          <option value="">Select</option>
                          <?php 

                            foreach ($plans as $plan) {
                              echo '<option value="'.$plan->id.'"';
                              if($site->plan_id_fk==$plan->id){echo "selected";}
                              echo '  >'.$plan->plan_name.'</option>';
                            }
                          ?>
                        </select>
                    </div>
<div class="clearfix">

</div>
                    <legend>Amenities</legend>

                       <div class="form-group  col-lg-6">
                        <label for="">Main Road</label>
                        <input type="text" class="form-control"  onkeypress="return isNumber(event)" id="" placeholder="" name="main_road" value="<?=$site->main_road?>" required="required">
                    </div>

                     <div class="form-group  col-lg-6">
                        <label for="">Inner Road</label>
                        <input type="text" class="form-control" onkeypress="return isNumber(event)" id="" placeholder="" name="inner_road" value="<?=$site->inner_road?>" required="required">
                    </div>

                    <div class="form-group  col-lg-6">
                        <label for="">Parking</label>
                        <div class="radio">
                          <label>
                            <input type="radio" name="parking" id="input" value="1" <?=($site->parking == '1')?'checked="checked"':NULL?> >
                            Yes
                          </label>
                          <label>
                            <input type="radio" name="parking" id="input" value="0" <?=($site->parking == '0')?'checked="checked"':NULL?>>
                            No
                          </label>

                        </div>

                    </div>

                    <div class="form-group  col-lg-6">
                        <label for="">Drainage</label>
                        <div class="radio">
                          <label>
                            <input type="radio" name="drainage" id="input" value="1" <?=($site->drainage == '1')?'checked="checked"':NULL?>>
                            Yes
                          </label>
                          <label>
                            <input type="radio" name="drainage" id="input" value="0" <?=($site->drainage == '0')?'checked="checked"':NULL?>>
                            No
                          </label>

                        </div>

                    </div>
                    <div class="form-group  col-lg-6">
                        <label for="">Lighting</label>
                        <div class="radio">
                          <label>
                            <input type="radio" name="lightning" id="input" value="1" <?=($site->lightning == '1')?'checked="checked"':NULL?>>
                            Yes
                          </label>
                          <label>
                            <input type="radio" name="lightning" id="input" value="0"  <?=($site->lightning == '0')?'checked="checked"':NULL?>>
                            No
                          </label>

                        </div>

                    </div>


                    <div class="form-group  col-lg-6">
                        <label for="">Road Type</label>
                        <select name="road_type" id="inputRoad_type" class="form-control" required="required">
                          <option value="">Select</option>
                          <option <?=($site->road_type == 'CC')?'selected="true"':NULL?> value="CC">CC</option>
                        </select>

                    </div>


                    <div class="form-group  col-lg-6">
                        <label for="">Green Belt</label>
                        <div class="radio">
                          <label>
                            <input type="radio" name="green_belt" id="input" value="1" checked="checked"  <?=($site->green_belt == '1')?'checked="checked"':NULL?> >
                            Yes
                          </label>
                          <label>
                            <input type="radio" name="green_belt" id="input" value="0"   <?=($site->green_belt == '0')?'checked="checked"':NULL?> >
                            No
                          </label>

                        </div>

                    </div>

                    <div class="form-group  col-lg-6">
                        <label for="">Lighting Infrastructure</label>
                        <div class="radio">
                          <label>
                            <input type="radio" name="lightning_infra" id="input" value="1"  <?=($site->lightning_infra == '1')?'checked="checked"':NULL?>>
                            Yes
                          </label>
                          <label>
                            <input type="radio" name="lightning_infra" id="input" value="0" <?=($site->lightning_infra == '0')?'checked="checked"':NULL?> >
                            No
                          </label>

                        </div>

                    </div>

                    <div class="form-group  col-lg-6">
                        <label for="">Water Supply</label>
                        <div class="radio">
                          <label>
                            <input type="radio" name="water_supply" id="input" value="1"  <?=($site->water_supply == '1')?'checked="checked"':NULL?> >
                            Yes
                          </label>
                          <label>
                            <input type="radio" name="water_supply" id="input" value="0" <?=($site->water_supply == '0')?'checked="checked"':NULL?> >
                            No
                          </label>

                        </div>

                    </div>

                    <div class="form-group  col-lg-6">
                        <label for="">Security</label>
                        <div class="radio">
                          <label>
                            <input type="radio" onchange="show('security_type',1)" name="security" value="1" <?=($site->security == '1')?'checked="checked"':NULL?> >
                            Yes
                          </label>
                          <label>
                            <input type="radio" name="security" onchange="show('security_type',0)" id="input" value="0" <?=($site->security == '0')?'checked="checked"':NULL?>>
                            No
                          </label>

                        </div>

                    </div>

                    <div class="form-group  col-lg-6" id="security_type_div" <?=($site->security == '0')?'style="display:none;"':NULL?> >
                        <label for="">Security Type</label>
                         <select name="security_type" id="inputRoad_type" class="form-control" >
                          <option value="">Select</option>
                          <option  <?=($site->security_type == 'CCTV')?'selected="true"':NULL?>  value="CCTV">CCTV</option>
                          <option  <?=($site->security_type == 'Guards')?'selected="true"':NULL?>  value="Guards">Guards</option>
                          <option <?=($site->security_type == 'CCTV , Guards')?'selected="true"':NULL?>   value="CCTV , Guards">Both</option>
                        </select>

                    </div>
              <div class="form-group  col-lg-6">
                        <label for="">Project Associated</label>
                        <div class="radio">
                          <label>
                            <input type="radio" onchange="show('association',1)" name="project_associate" id="input" value="1" <?=($site->project_associate == '1')?'checked="checked"':NULL?> >
                            Yes
                          </label>
                          <label>
                            <input type="radio" onchange="show('association',0)" name="project_associate" id="input" value="0" <?=($site->project_associate == '0')?'checked="checked"':NULL?> >
                            No
                          </label>

                        </div>

                    </div>
<div class="clearfix">

</div>
                    <div class="form-group  col-lg-6" id="association_div">
                        <label for="">Association</label>
                         <select name="association" id="inputRoad_type" class="form-control" >
                          <option value="">Select</option>
                          <option <?=($site->association == 'Prime')?'selected="true"':NULL?> value="Prime">Prime</option>
                          <option <?=($site->association == 'Normal')?'selected="true"':NULL?> value="Normal">Normal</option>
                          <option <?=($site->association == 'Rural')?'selected="true"':NULL?> value="Rural">Rural</option>
                        </select>

                    </div>







                     
                        <div class="form-group clearfix">
                            <label class="col-lg-3">Update Site Image:</label>
                           
                             <?php for($i=0;$i<5;$i++){ ?>  <div class="col-lg-3">                                                             
                                <input class="btn btn-white" type="file" name="userfile[<?php echo $i; ?>]" accept="image/*"/>
                             </div>  <?php } ?>
                            
                        </div>
                      <div class="form-group  col-lg-3">
                       <img src="<?=base_url()?>upload/site/<?=$this->session->userdata('admin_id')?>/<?=$site->site_id;?>/<?=$site->image1?>" class="img-responsive" alt="No Image">
                    </div>
                      <div class="form-group  col-lg-3">
                       <img src="<?=base_url()?>upload/site/<?=$this->session->userdata('admin_id')?>/<?=$site->site_id;?>/<?=$site->image2?>" class="img-responsive" alt="No Image">
                    </div>
                    <div class="form-group  col-lg-3">
                       <img src="<?=base_url()?>upload/site/<?=$this->session->userdata('admin_id')?>/<?=$site->site_id;?>/<?=$site->image3?>" class="img-responsive" alt="No Image">
                    </div>
                    <div class="form-group  col-lg-3">
                       <img src="<?=base_url()?>upload/site/<?=$this->session->userdata('admin_id')?>/<?=$site->site_id;?>/<?=$site->image4?>" class="img-responsive" alt="No Image">
                    </div>
                    <div class="form-group  col-lg-3">
                       <img src="<?=base_url()?>upload/site/<?=$this->session->userdata('admin_id')?>/<?=$site->site_id;?>/<?=$site->image5?>" class="img-responsive" alt="No Image">
                    </div>
                     <div class="col-lg-12 plot_info" id="plot_info">
                     <?php 
                          $plots = $this->admin_model->get_site_plots($site->site_id);
                          $no_plot =0;
                          $no_villa = 0;
                          $no_apartment = 0;
                          foreach ($plots as $key) 
                          {
                              switch ($key->type) {
                                case 'Plot':
                                  $no_plot++;
                                  break;
                                   case 'Villa':
                                  $no_villa++;
                                  break;
                                   case 'Apartment':
                                  $no_apartment++;
                                  break;
                                
                                default:
                                  # code...
                                  break;
                              }
                          }
                     ?>
                     <?php if ($no_plot) { ?>
                        <div class="plot_types" >
                      <div class="form-group col-lg-6">
                        <label for="">Plot Type</label>
                        <select name="plot_type[]" disabled id="inputPlot_type" class="form-control" required="required">
                            <option selected="true">Plot</option>
                            <option <?=($site->plot_type=="Villa")?'selected="true"':NULL?>>Villa</option>
                            <option <?=($site->plot_type=="Apartment")?'selected="true"':NULL?>>Apartment</option>
                        </select>
                    </div>
                     <div class="form-group col-lg-6">
                        <label for="">No. of Plots</label>
                        <input type="text" class="form-control" id="plot_numbers[]" readonly placeholder="" onkeypress="return isNumber(event)" name="no_plots[]" value="<?=$no_plot?>" required="required"> 
                        <input type="hidden" class="form-control" id="plot_count"  value="0"> 

                    </div>
                   <?php  }?>

                    <?php if ($no_villa) { ?>
                        <div class="plot_types" >
                      <div class="form-group col-lg-6">
                        <label for="">Plot Type</label>
                        <select name="plot_type[]" disabled id="inputPlot_type" class="form-control" required="required">
                            <option >Plot</option>
                            <option selected="true">Villa</option>
                            <option <?=($site->plot_type=="Apartment")?'selected="true"':NULL?>>Apartment</option>
                        </select>
                    </div>
                     <div class="form-group col-lg-6">
                        <label for="">No. of Plots</label>
                        <input type="text" class="form-control" id="plot_numbers[]" readonly placeholder="" onkeypress="return isNumber(event)" name="no_plots[]" value="<?=$no_villa?>" required="required"> 
                        <input type="hidden" class="form-control" id="plot_count"  value="0"> 

                    </div>
                   <?php  }?>

                    <?php if ($no_apartment) { ?>
                        <div class="plot_types" >
                      <div class="form-group col-lg-6">
                        <label for="">Plot Type</label>
                        <select name="plot_type[]" disabled id="inputPlot_type" class="form-control" required="required">
                            <option >Plot</option>
                            <option >Villa</option>
                            <option selected="true">Apartment</option>
                        </select>
                    </div>
                     <div class="form-group col-lg-6">
                        <label for="">No. of Plots</label>
                        <input type="text" class="form-control" id="plot_numbers[]" readonly  placeholder="" onkeypress="return isNumber(event)" name="no_plots[]" value="<?=$no_apartment?>" required="required"> 
                        <input type="hidden" class="form-control" id="plot_count"  value="0"> 

                    </div>
                   <?php  }?>

                  
                  
                  </div> 
                        
                    
                   
<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
    
                        <input  type="hidden" value="1" name="store_id">
                        <input  type="submit"  class="btn btn-success" value="Update" onclick="form_validation(this.form)" >
                        <a type="button" href="<?=base_url()?>index.php/admin/edit_site_plots/<?=$site->site_id?>" class="btn btn-success  pull-right">Manage Plots</a>
</div>
                     

                            </form>

                      
                </div>                                
                
            </div>  
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                 <script type="text/javascript">
       
                function add_plot ()
                {
                    var plot_count = $("#plot_count").val();
                   var plot_add = $("#plot_numbers").val();
                   var plot_type = $("#inputPlot_type").val();
                   
                   for (var i = 0; i < plot_add; i++) 
                   {

                      plot_count++;
                      $("#plot_count").val(plot_count);
                      $("#plot_array").append('<tr><td>'+plot_count+'</td><td><input type="text" required="required" onkeypress="return isNumber(event)" name="plot_size[]" value=""></td><td><input type="text" onkeypress="return isNumber(event)" name="plot_price[]" required="required" value=""><input type="hidden" name="plot_type[]" value="'+plot_type+'"></td><td>'+plot_type+'</td><td><input type="checkbox" name="plot_corner[]" value="1"></td><td><input type="checkbox" name="plot_commercial[]" value="1"></td><td><input type="checkbox" name="plot_prime[]" value="1"></td><td style="cursor:pointer;"  onclick="remove_contri(this)" ><i class="fa fa-times"></i> Remove</td></tr>');
                   };

                   $(".table-bordered").show();

                }

       function remove_contri (cross) 
{
  var parentRow = $(cross).closest('tr');
  $(parentRow).remove();
}


function add_plots22 (argument) 
{
    $("#add_plots").append('<div class="form-group col-lg-6"><label for="">Plot Type</label><select name="plot_type[]" id="inputPlot_type" class="form-control" required="required">    <option <?=($site->plot_type=="Plot")?'selected="true"':NULL?>>Plot</option>    <option <?=($site->plot_type=="Villa")?'selected="true"':NULL?>>Villa</option>    <option <?=($site->plot_type=="Apartment")?'selected="true"':NULL?>>Apartment</option></select></div> <div class="form-group col-lg-6"><label for="">No. of Plots</label><input type="text" class="form-control" id="plot_numbers" placeholder="" onkeypress="return isNumber(event)" name="no_plots[]" value="<?=$site->no_plots?>" required="required">  </div>');
  
}

function show (div,state) 
{
  if(state)
  {
    $("#"+div+"_div").show();
  }
  else
  {
    $("#"+div+"_div").hide();
    $("[name="+div+"]").val("");
  }
}

        </script>



