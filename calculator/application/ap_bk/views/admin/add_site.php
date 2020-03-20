 <!-- page content -->
            <div class="right_col" role="main">
                <div class="">
                   
                    <div class="clearfix"></div>

                    <div class="row">

                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <div class="x_panel" style="height:1800px;">
                                <div class="x_title">
                                    <h2>Add Site</h2>
                                    
                                    <div class="clearfix"></div>
                                </div>

                                <div class="x_content">
                                        <div class="row">
                
                <div class="position-center">                    
                   
                 
                       
                      <form name="form" id="" class="form-horizontal" action="" method="post" enctype="multipart/form-data">
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
                              echo '<option value="'.$plan->id.'">'.$plan->plan_name.'</option>';
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
                            <input type="radio" name="parking" id="input" value="1" <?=(1 == '1')?'checked="checked"':NULL?> >
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
                            <input type="radio" name="drainage" id="input" value="1" <?=(1 == '1')?'checked="checked"':NULL?>>
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
                            <input type="radio" name="lightning" id="input" value="1" <?=(1 == '1')?'checked="checked"':NULL?>>
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
                            <input type="radio" name="green_belt" id="input" value="1"   <?=(1 == '1')?'checked="checked"':NULL?> >
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
                            <input type="radio" name="lightning_infra" id="input" value="1"  <?=(1 == '1')?'checked="checked"':NULL?>>
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
                            <input type="radio" name="water_supply" id="input" value="1"  <?=(1 == '1')?'checked="checked"':NULL?> >
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
                            <input type="radio" onchange="show('security_type',1)" name="security" value="1" <?=(1 == '1')?'checked="checked"':NULL?> >
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
                            <input type="radio" onchange="show('association',1)" name="project_associate" id="input" value="1" <?=(1 == '1')?'checked="checked"':NULL?> >
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
                    <div class="form-group  col-lg-6" id="association_div" <?=($site->project_associate == '0')?'style="display:none;"':NULL?>>
                        <label for="">Association</label>
                         <select name="association" id="inputRoad_type" class="form-control" >
                          <option value="">Select</option>
                          <option <?=($site->association == 'Prime')?'selected="true"':NULL?> value="Prime">Prime</option>
                          <option <?=($site->association == 'Normal')?'selected="true"':NULL?> value="Normal">Normal</option>
                          <option <?=($site->association == 'Rural')?'selected="true"':NULL?> value="Rural">Rural</option>
                        </select>

                    </div>
                     <div class="clearfix">
                     
                     </div>
                        <div class="form-group clearfix">
                            <label class="col-lg-1">Site Image:</label>
                           
                             <?php for($i=0;$i<5;$i++){ ?>  <div class="col-lg-3">                                                             
                                <input class="btn btn-white" type="file" name="userfile[<?php echo $i; ?>]" accept="image/*"/>
                             </div>  <?php } ?>
                            
                        </div>
                   <div class="plot_types" >
                      <div class="form-group col-lg-6">
                        <label for="">Plot Type</label>
                        <select name="plot_type[]" id="inputPlot_type" class="form-control" required="required">
                            <option <?=($site->plot_type=="Plot")?'selected="true"':NULL?>>Plot</option>
                            <option <?=($site->plot_type=="Villa")?'selected="true"':NULL?>>Villa</option>
                            <option <?=($site->plot_type=="Apartment")?'selected="true"':NULL?>>Apartment</option>
                        </select>
                    </div>
                     <div class="form-group col-lg-6">
                        <label for="">No. of Plots</label>
                        <input type="text" class="form-control" id="plot_numbers[]" placeholder="" onkeypress="return isNumber(event)" name="no_plots[]" value="<?=$site->no_plots?>" required="required"> 
                        <input type="hidden" class="form-control" id="plot_count"  value="0"> 

                    </div>
                    <div id="add_plots">
                      
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 ">
                      <button type="button" onclick="add_plot()" class="btn btn-default pull-right"><i class="fa fa-plus" ></i> Plots</button>
                    </div>
                    </div>




                     <div class="col-lg-12 plot_info" id="plot_info">
                    <table class="table table-bordered" style="display:none;">
                      <thead>
                        <tr>
                          <th>Sr. No.</th>
                          <th>Size</th>
                          <th>Cost</th>
                          <th>Type</th>
                          <th>Corner</th>
                          <th>Commercial</th>
                          <th>Prime</th>
                          <th>Action</th>
                          
                        </tr>
                      </thead>
                      <tbody id="plot_array">
                        
                      </tbody>
                    </table>
                  </div> 
                        
                    
                   
<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
    
                        <input  type="hidden" value="1" name="store_id">
                        <input  type="submit"  class="btn btn-success" value="save" onclick="form_validation(this.form)" >
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


function add_plot (argument) 
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



