            <!-- Right side column. Contains the navbar and content of the page -->
            <aside class="right-side">
                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <h1>
                        Job Post Application
                    </h1>
                    <ol class="breadcrumb">
                        <li><a href="<?=base_url()?>index.php/admin/dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
                        <li class="active">Job Post Application</li>
                    </ol>
                </section>

                <!-- Main content -->
                <section class="content">
                    <div class="row">
                        <div class="col-xs-12">
                            <div class="box">
                                <div class="box-header">
                                <div class="row">
                                <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                                     <h3 class="box-title">All Job Post Application</h3>
                                </div>
                                <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                                    <a class="btn btn-default pull-right" data-toggle="modal" href='#modal-id'>Add New Job Post Application</a>
                                </div>
                                     
                                    
                                </div>
                                   
                                    
                                </div><!-- /.box-header -->
                                <div class="box-body table-responsive">
                                      <table  width = "100%" class="table table-striped table-bordered table-hover" id="example1">
                                        <thead>
                                            <tr>
                                                <th>Sr. No.</th>
                                                <th>Name</th>
                                                <th>Email</th>
                                                <th>Phone</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                       <?php $i=1; foreach ($all_job_post_applications as $key): ?>
                                            <tr>
                                                <td><?=$i?></td>
                                                <td><?=$key->fname?> <?=$key->lname?></td>
                                                <td><?=$key->email?></td>
                                                <td><?=$key->phone?></td>
                                                <td>
                                                    <div class="btn-group">
                                                        <a href="#modal-id<?=$key->applied_id?>" data-toggle="modal" class="btn btn-default"><i class="fa fa-eye"></i> View</a>
                                                       
                                                        <a type="button" onclick = "return confirm('Do You really want to delete this Job Post Application')" href="<?=base_url()?>index.php/admin/delete_job_post_application/<?=$key->job_id?>" class="btn btn-default"><i class="fa fa-trash-o"></i> Delete</a>
                                                    </div>
                                                </td>
                                            </tr>
                                        <?php $i++; endforeach ?>
                                            
                                           
                                        </tbody>
                                        <tfoot>
                                             <th>Sr. No.</th>
                                                <th>Code</th>
                                                <th>Status</th>
                                                <th>Actions</th>
                                        </tfoot>
                                    </table>
                                </div><!-- /.box-body -->
                            </div><!-- /.box -->
                        </div>
                    </div>

                </section><!-- /.content -->
            </aside><!-- /.right-side -->
        </div><!-- ./wrapper -->


<?php foreach ($all_job_post_applications as $key): ?>
    <div class="modal fade" id="modal-id<?=$key->applied_id?>">
    <div class="modal-dialog">
        <div class="modal-content">
          
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">Job Post Application</h4>
            </div>
            <div class="modal-body" style="height:500px;overflow-y:scroll;">
               
                    <legend>Edit Job Post Application</legend>
                    <div class="form-group">
                        <label for="">Name </label>
                         <input type="text" name="job_title" id="input" class="form-control" value="<?=$key->fname?> <?=$key->lname?>" >
                        
                    </div> 
                    <div class="form-group">
                        <label for="">Email</label>
                         <input type="text" name="location" id="input" class="form-control" value="<?=$key->email?>" >
                        
                    </div> 
                    <div class="form-group">
                        <label for="">Location</label>
                         <input type="text" name="department" id="input" class="form-control" value="<?=$key->location?>" >
                        
                    </div> 
                    <div class="form-group">
                        <label for="">City, State, Zip Code</label>
                         <input type="text" name="type" id="input" class="form-control" value="<?=$key->city?>, <?=$key->state?>, <?=$key->zipcode?>" >
                        
                    </div> 
                    <div class="form-group">
                        <label for="">Phone Number</label>
                         <input type="text" name="min_exp" id="input" class="form-control" value="<?=$key->phone?>" >
                        
                    </div> 
                    <div class="form-group">
                        <label for="">Brief Description</label>
                         <textarea name="job_desc" id="input" class="form-control"  ><?=$key->brief?></textarea>
                        
                    </div> 
                    <div class="form-group">
                        <label for="">Attached Resume</label>
                         <a  target="_blank" class="btn btn-default" href="<?=base_url()?>upload/job/<?=$key->resume?>">Download</a>
                    </div>               
               
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<?php endforeach ?>


 <script src="http://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
        <!-- page script -->
        <script type="text/javascript">
            $(function() {
                $("#example1").dataTable();
             

            });
        </script>
