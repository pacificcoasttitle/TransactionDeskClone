 <!-- page content -->
 <?php
$find = $this->session->userdata('find_array');
  ?>
            <div class="right_col" role="main">
                <div class="">
                    
                    <div class="clearfix">
                        <ol class="breadcrumb">
                        <li>
                          <a href="<?=base_url()?>index.php/admin">Dashboard</a>
                        </li>
                        <li class="active">
                          <?=$page_head?>
                        </li>
                        
                      </ol>
                    </div>
                    <?php  if ($page_head == 'Users'){$active = 'sites';}?>
                    <?php  if ($page_head == 'Associates'){$active = 'associate';}?>
                        
                   
                    <div class="row">

                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <div class="x_panel">
                                <div class="x_title">
                                    <h2>Manage <?=$page_head?></h2><a type="button" href="#modal-add" data-toggle="modal" class="btn btn-default pull-right">Add New</a>
                                   
                                    <div class="clearfix"></div>
                                </div>
                                <div class="x_content">
                                <form action="" method="POST" class="form-horizontal" role="form">
                                       
                                      <div class="form-group col-lg-3">
                                            <label class="sr-only" for="">Location</label>
                                            <input type="text" name="location" class="form-control" value="<?=$find['location']?>" placeholder="Location">
                                        </div>
                                         <div class="form-group col-lg-3">
                                            <label class="sr-only" for="">State</label>
                                            <input type="text" name="state" class="form-control" value="<?=$find['state']?>" placeholder="State">
                                        </div>
                                         <div class="form-group col-lg-3">
                                            <label class="sr-only" for="">City</label>
                                            <input type="text" name="city" class="form-control" value="<?=$find['city']?>" placeholder="City">
                                        </div>
                                        <div class="form-group">
                                            <div class="col-sm-2 col-sm-offset-1">
                                                <button type="submit" class="btn btn-primary">Submit</button>
                                            </div>
                                        </div>
                                        <hr>
                                </form>
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
                                                <th>Status </th>
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
                                                <td class=" "><?=($key->status=="1")?"Active":"Inactive"?></td>
                                                <td class=" last">
                                                <a data-toggle="modal" href="#modal-edit<?=$key->plot_id?>"><i class="fa fa-edit"></i>  </a> |


                                                 <?php if ($key->status == "1"): ?> 
                                                      <a type="button" href="<?=base_url()?>index.php/admin/deactivate_plot/<?=$key->plot_id?>" ><i class="fa fa-times"></i> </a> |
                                                  <?php else: ?>
                                                      <a type="button" href="<?=base_url()?>index.php/admin/activate_plot/<?=$key->plot_id?>"  ><i class="fa fa-check"></i> </a> |
                                                  <?php endif ?>
                                                      <a onclick = "return confirm('Do you really want to delete this <?=$active?>??')" type="button" href="<?=base_url()?>index.php/admin/delete_site/<?=$key->plot_id?>"  ><i class="fa fa-trash-o"></i> </a>

                                                </td>
                                            </tr>
                                            <?php $i++; endforeach ?>
                                        </tbody>

                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>


<div class="modal fade" id="modal-add">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">Add Site</h4>
            </div>
            <div class="modal-body">
                <form action="<?=base_url()?>index.php/admin/add_site" method="POST" role="form" enctype="multipart/form-data">
               
                    <div class="form-group">
                        <label for="">Name</label>
                        <input type="text" class="form-control" id="" placeholder="" name="site_name">
                    </div>
                    <div class="form-group">
                        <label for="">Location</label>
                        <input type="text" class="form-control" id="" placeholder="" name="location">
                    </div>
                    <div class="form-group">
                        <label for="">State</label>
                        <input type="text" class="form-control" id="" placeholder="" name="state">
                    </div>
                    <div class="form-group">
                        <label for="">City</label>
                        <input type="text" class="form-control" id="" placeholder="" name="city">
                    </div>
                     <div class="form-group">
                        <label for="">Plot Type</label>
                        <select name="plot_type" id="inputPlot_type" class="form-control" required="required">
                            <option>Plot</option>
                            <option>Villa</option>
                            <option>Apartment</option>
                        </select>
                    </div>
                     <div class="form-group">
                        <label for="">No. of Plots</label>
                        <input type="text" class="form-control" id="" placeholder="" name="no_plots">
                    </div>
                <input type="file" name="userfile" value="" placeholder="">
                
                    
                
                    <button type="submit" class="btn btn-primary">Submit</button>
                </form>
            </div>
            
        </div>
    </div>
</div>
<?php foreach ($plots as $plot): ?>
    <div class="modal fade" id="modal-edit<?=$plot->plot_id?>">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">Edit Plot</h4>
            </div>
            <div class="modal-body">
                <form action="<?=base_url()?>index.php/admin/update_plot/<?=$plot->plot_id?>" method="POST" role="form" enctype="multipart/form-data">
               
                    <div class="form-group">
                        <label for="">Size</label>
                        <input type="text" class="form-control" id="" placeholder="" name="size" value="<?=$site->size?>">
                    </div>
                    <div class="form-group">
                        <label for="">Commercial</label>
                        <select name="commercial" id="inputPlot_type" class="form-control" required="required">
                            <option <?=($site->commercial=="0")?'selected="true"':NULL?> value="0">No</option>
                            <option <?=($site->commercial=="1")?'selected="true"':NULL?> value="1">Yes</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="">Corner</label>
                        <select name="corner" id="inputPlot_type" class="form-control" required="required">
                            <option <?=($site->corner=="0")?'selected="true"':NULL?> value="0">No</option>
                            <option <?=($site->corner=="1")?'selected="true"':NULL?> value="1">Yes</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="">Prime Location</label>
                        <select name="prime_location" id="inputPlot_type" class="form-control" required="required">
                            <option <?=($site->prime_location=="0")?'selected="true"':NULL?> value="0">No</option>
                            <option <?=($site->prime_location=="1")?'selected="true"':NULL?> value="1">Yes</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="">Price</label>
                        <input type="text" class="form-control" id="" placeholder="" name="price" value="<?=$site->price?>">
                       
                    </div>
                     
                   
              
                
                
                    <button type="submit" class="btn btn-primary">Submit</button>
                </form>
            </div>
            
        </div>
    </div>
</div>
<?php endforeach ?>