 <!-- page content -->
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
                                    <h2>Manage <?=$page_head?></h2><a type="button" href="<?=base_url()?>index.php/admin/add_site" data-toggle="modal" class="btn btn-default pull-right">Add New</a>
                                   
                                    <div class="clearfix"></div>
                                </div>
                                <div class="x_content">
                                    <table id="example" class="table table-striped responsive-utilities jambo_table">
                                        <thead>
                                            <tr class="headings">
                                               <!--  <th>
                                                    <input type="checkbox" class="tableflat">
                                                </th> -->
                                                <th>Sr. No.</th> 
                                                <th>Image</th> 
                                                <th>Site Name</th>
                                                <th>Location</th>
                                                <th>Rate</th>
                                                <th>Status </th>
                                                <th class=" no-link last"><span class="nobr">Action</span> </th>
                                            </tr>
                                        </thead>

                                        <tbody>
                                        <?php $i=1; foreach ($sites as $key): ?>
                                            
                                       
                                            <tr class="even pointer">
                                               <td><?=$i?></td>
                                               <td class=" "><img src="<?=base_url()?>upload/site/<?=$this->session->userdata('admin_id')?>/<?=$key->site_id;?>/<?=$key->image1?>" style="max-height:100px;" class="img-responsive" alt="No Image"></td>
                                                <td class=" "><?=$key->site_name?></td>
                                                <td class=" "><?=$key->location?></td>
                                                <td class=" "><?=$key->rate?></td>
                                                <td class=" "><?=($key->status=="1")?"Active":"Inactive"?></td>
                                                <td class=" last">
                                                <a href="<?=base_url()?>index.php/admin/edit_site/<?=$key->site_id?>"><i class="fa fa-eye"></i>  View/Edit</a> |


                                                 <?php if ($key->status == "1"): ?> 
                                                      <a type="button" href="<?=base_url()?>index.php/admin/deactivate_site/<?=$key->site_id?>" ><i class="fa fa-times"></i> Deactivate</a> |
                                                  <?php else: ?>
                                                      <a type="button" href="<?=base_url()?>index.php/admin/activate_site/<?=$key->site_id?>"  ><i class="fa fa-check"></i> Activate</a> |
                                                  <?php endif ?>
                                                      <a onclick = "return confirm('Do you really want to delete this <?=$active?>??')" type="button" href="<?=base_url()?>index.php/admin/delete_site/<?=$key->site_id?>"  ><i class="fa fa-trash-o"></i> Detele</a>

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