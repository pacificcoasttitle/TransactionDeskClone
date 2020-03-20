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
                    <?php $active = 'plan';?>
          
                        
                   
                    <div class="row">

                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <div class="x_panel">
                                <div class="x_title">
                                    <h2>Manage <?=$page_head?></h2><a type="button" href="<?=base_url()?>index.php/admin/add_<?=$active?>" class="btn btn-default pull-right">Add New</a>
                                   
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
                                                <th>Plan Name</th>
                                                <th>Max Levels </th> 
                                                <th>Max Legs</th>
                                               
                                                <th class=" no-link last"><span class="nobr">Action</span>
                                                </th>
                                            </tr>
                                        </thead>

                                        <tbody>
                                        <?php $i=1; foreach ($plans as $key): ?>
                                            
                                       
                                            <tr class="even pointer">
                                               <td><?=$i?></td>
                                                <td class=" "><?=$key->plan_name?></td>
                                                <td class=" "><?=$key->maximum_allowed_levels?></td>
                                                <td class=" "><?=$key->allowed_members_per_level?> </td>
                                                <td class=" last">
                                                <a  href="<?=base_url()?>index.php/admin/edit_<?=$active?>/<?=$key->id?>"><i class="fa fa-eye"></i>  View/Edit</a> |
                                                <a onclick = "return confirm('Do you really want to delete this <?=$active?>??')" type="button" href="<?=base_url()?>index.php/admin/delete_plan/<?=$key->id?>/<?=$active?>"  ><i class="fa fa-trash-o"></i> Detele</a>

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

