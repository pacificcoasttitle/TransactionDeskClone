 <!-- page content -->
            <div class="right_col" role="main">
                <div class="">
                
                    <div class="clearfix"></div>

                    <div class="row">

                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <div class="x_panel" style="height:800px;">
                                <div class="x_title">
                                    <h2>Edit Site Plots</h2>
                                    
                                    <div class="clearfix"></div>
                                </div>

                                <div class="x_content">
                                        <div class="row">
                
                <div class="position-center">                    
                   
                 
                       
                      <form name="form" id="" class="form-horizontal" action="<?=base_url()?>index.php/admin/update_site_plot/<?=$site->site_id?>" method="post" enctype="multipart/form-data">
                      <div class="plot_types" >
                      <div class="form-group col-lg-6">
                        <label for="">Plot Type</label>
                        <select name="plot_type" id="inputPlot_type" class="form-control" required="required">
                            <option >Plot</option>
                            <option >Villa</option>
                            <option >Apartment</option>
                        </select>
                    </div>
                     <div class="form-group col-lg-5">
                        <label for="">No. of Plots</label>
                        <input type="text" class="form-control" id="plot_numbers" onkeypress="return isNumber(event)" placeholder="" name="no_plots" value="" > 
                        

                    </div>
                     <div class="col-xs-1 col-sm-1 col-md-1 col-lg-1">
                     <label for=""></label>
                      <button type="button" onclick="add_plot()"  class="btn btn-default"><i class="fa fa-plus" ></i> Plots</button>
                    </div>

                     <div class="col-lg-12 plot_info" id="plot_info">
                     <?php 
                          $plots = $this->admin_model->get_site_plots($site->site_id);
                     ?> <input type="hidden" class="form-control" id="plot_count"  value="<?=sizeof($plots)?>">
                     <table id="example" class="table table-striped responsive-utilities jambo_table">
                      <thead>
                        <tr>
                          <th class="col-lg-1">Plot No</th>
                          <th class="col-lg-1">length(in Mtr.)</th>
                          <th class="col-lg-1">Width (in Mtr.)</th>
                          <th class="col-lg-1">Size(in sq. Mtr.)</th>

                          <th class="col-lg-1">Cost</th>
                          <th class="col-lg-1">Type</th>
                          <th class="col-lg-1">Corner</th>
                          <th class="col-lg-1">Commercial</th>
                          <th class="col-lg-1">Prime</th>
                          <th class="col-lg-2">Action</th>
                          
                        </tr>
                      </thead>
                      <tbody id="plot_array">
                        <?php $i=1; foreach ($plots as $key): ?>
                          <tr>
                            <td><?=$key->plot_number?></td>
                            <td><input style="width:100px" id="plot_length_<?=$key->plot_id?>" onkeyup="calculate(<?=$key->plot_id?>)" type="text" required="required" onkeypress="return isNumber(event)" name="plot_length[<?=$i?>]" value="<?=$key->length?>"></td>
                            <td><input style="width:100px" id="plot_width_<?=$key->plot_id?>" onkeyup="calculate(<?=$key->plot_id?>)" type="text" required="required" onkeypress="return isNumber(event)" name="plot_width[<?=$i?>]" value="<?=$key->width?>"></td>
                            <td><input style="width:100px" id="plot_size_<?=$key->plot_id?>" type="text" required="required"  readonly="" name="plot_size[<?=$i?>]" value="<?=$key->size?>"></td>
                            <td><input style="width:100px" id="plot_price_<?=$key->plot_id?>" type="text" name="plot_price[<?=$i?>]" readonly="" onkeypress="return isNumber(event)" required="required" value="<?=$key->price?>">
                            <input type="hidden" name="plot_type[<?=$i?>]" value="<?=$key->type?>">
                            <input type="hidden" id="unit_rate"  value="<?=$site->rate?>">

                            </td>
                            <td><?=$key->type?></td>
                            <td><input type="checkbox" name="plot_corner[<?=$i?>]" <?=($key->corner==1)?'checked="true"':NULL?> value="1"></td>
                            <td><input type="checkbox" name="plot_commercial[<?=$i?>]" <?=($key->commercial==1)?'checked="true"':NULL?> value="1"></td>
                            <td><input type="checkbox" name="plot_prime[<?=$i?>]" value="1" <?=($key->prime_location==1)?'checked="true"':NULL?> ></td>
                            <td style="cursor:pointer;"  onclick="remove_contri(this)" ><i class="fa fa-times"></i> Remove</td>
                          </tr>
                        <?php $i++; endforeach ?>
                      </tbody>
                    </table>
                  </div> 
                        
                    
                   
<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
    
                        <input  type="hidden" value="1" name="store_id">
                        <input  type="submit"  class="btn btn-success" value="Update" onclick="form_validation(this.form)" >
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
                      var uuid = guid();
                      $("#plot_count").val(plot_count);
                      $("#plot_array").append('<tr><td>'+plot_count+'</td><td><input style="width:100px" type="text" id="plot_length_'+uuid+'" onkeyup="calculate(\''+uuid+'\')" required="required" onkeypress="return isNumber(event)" name="plot_length['+plot_count+']" value=""></td><td><input style="width:100px" type="text" id="plot_width_'+uuid+'" onkeyup="calculate(\''+uuid+'\')" required="required" onkeypress="return isNumber(event)" name="plot_width['+plot_count+']" value=""></td><td><input style="width:100px" type="text" id="plot_size_'+uuid+'" onkeyup="calculate(\''+uuid+'\')" required="required" onkeypress="return isNumber(event)" name="plot_size['+plot_count+']" value=""></td><td><input type="text" id="plot_price_'+uuid+'" onkeypress="return isNumber(event)" style="width:100px" name="plot_price['+plot_count+']" required="required" value=""><input type="hidden" name="plot_type['+plot_count+']" value="'+plot_type+'"></td><td>'+plot_type+'</td><td><input type="checkbox" name="plot_corner['+plot_count+']" value="1"></td><td><input type="checkbox" name="plot_commercial['+plot_count+']" value="1"></td><td><input type="checkbox" name="plot_prime['+plot_count+']" value="1"></td><td style="cursor:pointer;"  onclick="remove_contri(this)" ><i class="fa fa-times"></i> Remove</td></tr>');
                   };

                   $(".table-bordered").show();

                }

       function remove_contri (cross) 
{
  var parentRow = $(cross).closest('tr');
  $(parentRow).remove();
}



function calculate (plot_id) 
{

  var x = parseFloat($("#plot_length_"+plot_id).val());
  var y = parseFloat($("#plot_width_"+plot_id).val());
  var z = parseFloat((x*y).toFixed(2));
  $("#plot_size_"+plot_id).val(z);
  var r =  parseFloat($("#unit_rate").val());
  var p = parseFloat((z*r).toFixed(2));
  $("#plot_price_"+plot_id).val(p);
}


function guid() {
  function s4() {
    return Math.floor((1 + Math.random()) * 0x10000)
      .toString(16)
      .substring(1);
  }
  return s4()
}


        </script>



