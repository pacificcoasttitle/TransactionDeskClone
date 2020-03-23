 <!-- page content -->
            <div class="right_col" role="main">
                <div class="">
                    
                    <div class="clearfix">
                        <ol class="breadcrumb">
                        <li>
                          <a href="<?=base_url()?>index.php/associate">Dashboard</a>
                        </li>
                        <li class="active">
                          <?=$page_head?>
                        </li>
                        
                      </ol>
                    </div>
                    <?php  if ($page_head == 'Users'){$active = 'user';}?>
                    <?php  if ($page_head == 'Associates'){$active = 'associate';}?>
                        
                   
                    <div class="row">

                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <div class="x_panel">
                                <div class="x_title">
                                    <h2>Manage <?=$page_head?></h2><a type="button" href="<?=base_url()?>index.php/associate/add_<?=$active?>" class="btn btn-default pull-right">Add New</a>
                                   
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
                                                <th>Username</th>
                                                <th>Mobile </th> 
                                                <th>City</th>
                                                <th>State</th>
                                                <th>Status </th>
                                                <th class=" no-link last"><span class="nobr">Action</span>
                                                </th>
                                            </tr>
                                        </thead>

                                        <tbody>
                                        <?php $i=1; foreach ($associates as $key): ?>
                                            
                                       
                                            <tr class="even pointer">
                                               <td><?=$i?></td>
                                                <td class=" "><?=$key->username?></td>
                                                <td class=" "><?=$key->mobile?></td>
                                                <td class=" "><?=$key->city?> </td>
                                                <td class=" "><?php $state = end(explode(',',$key->state)); echo $state;?></td>
                                                <td class=" "><?=($key->status=="T")?"Active":"Inactive"?></td>
                                                <td class=" last">
                                                <a data-toggle="modal" href="<?=base_url()?>index.php/associate/edit_<?=$active?>/<?=$key->id?>"><i class="fa fa-eye"></i>  View/Edit</a> |


                                                
                              <a onclick = "return confirm('Do you really want to delete this <?=$active?>??')" type="button" href="<?=base_url()?>index.php/associate/delete_user/<?=$key->id?>/<?=$active?>"  ><i class="fa fa-trash-o"></i> Detele</a>

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

