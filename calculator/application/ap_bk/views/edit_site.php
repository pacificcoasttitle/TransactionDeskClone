 <!-- page content -->
            <div class="right_col" role="main">
                <div class="">
                
                    <div class="clearfix"></div>

                    <div class="row">

                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <div class="x_panel" style="height:800px;">
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
                     
                        <div class="form-group clearfix">
                            <label class="col-lg-3">Update Site Image:</label>
                           
                             <?php for($i=0;$i<3;$i++){ ?>  <div class="col-lg-3">                                                             
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
                   <div class="plot_types" >
                      <div class="form-group col-lg-6">
                        <label for="">Plot Type</label>
                        <select name="plot_type" id="inputPlot_type" class="form-control" required="required">
                            <option <?=($site->plot_type=="Plot")?'selected="true"':NULL?>>Plot</option>
                            <option <?=($site->plot_type=="Villa")?'selected="true"':NULL?>>Villa</option>
                            <option <?=($site->plot_type=="Apartment")?'selected="true"':NULL?>>Apartment</option>
                        </select>
                    </div>
                     <div class="form-group col-lg-5">
                        <label for="">No. of Plots</label>
                        <input type="text" class="form-control" id="plot_numbers" onkeypress="return isNumber(event)" placeholder="" name="no_plots" value="<?=$site->no_plots?>" required="required"> 
                        <input type="hidden" class="form-control" id="plot_count"  value="0"> 

                    </div>
                    <div class="col-xs-1 col-sm-1 col-md-1 col-lg-1">
                     <label for=""></label>
                      <button type="button" onclick="add_plot()"  class="btn btn-default"><i class="fa fa-plus" ></i> Plots</button>
                    </div>
                     <div class="col-lg-12 plot_info" id="plot_info">
                     <?php 
                          $plots = $this->admin_model->get_site_plots($site->site_id);
                     ?>
                    <table class="table table-bordered" style="display:block;">
                      <thead>
                        <tr>
                          <th class="col-lg-1">Plot Number</th>
                          <th class="col-lg-2">Size</th>
                          <th class="col-lg-2">Cost</th>
                          <th class="col-lg-2">Type</th>
                          <th class="col-lg-1">Corner</th>
                          <th class="col-lg-1">Commercial</th>
                          <th class="col-lg-1">Prime</th>
                          <th class="col-lg-2">Action</th>
                          
                        </tr>
                      </thead>
                      <tbody id="plot_array">
                        <?php foreach ($plots as $key): ?>
                          <tr>
                            <td><?=$key->plot_number?></td>
                            <td><input type="text" required="required" onkeypress="return isNumber(event)" name="plot_size[]" value="<?=$key->size?>"></td>
                            <td><input type="text" name="plot_price[]" onkeypress="return isNumber(event)" required="required" value="<?=$key->price?>">
                              <input type="hidden" name="plot_type[]" value="<?=$key->type?>">
                            </td>
                            <td><?=$key->type?></td>
                            <td><input type="checkbox" name="plot_corner[]" <?=($key->corner==1)?'checked="true"':NULL?> value="1"></td>
                            <td><input type="checkbox" name="plot_commercial[]" <?=($key->commercial==1)?'checked="true"':NULL?> value="1"></td>
                            <td><input type="checkbox" name="plot_prime[]" value="1" <?=($key->prime==1)?'checked="true"':NULL?> ></td>
                            <td style="cursor:pointer;"  onclick="remove_contri(this)" ><i class="fa fa-times"></i> Remove</td>
                          </tr>
                        <?php endforeach ?>
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


        </script>



