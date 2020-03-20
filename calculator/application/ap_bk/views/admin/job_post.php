          <style type="text/css">
     .btn .badge {
  position: absolute;
  right: -3px;
  top: -9px;
  z-index: 9999;
}
.badge.primary {
  background-color: #FFF;
color: #337ab7;
}
.badge.info {
  background-color: #FFF;
color: #1D9D73;
}
</style>

            <!-- Right side column. Contains the navbar and content of the page -->
            <aside class="right-side">
                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <h1>
                        Job Post
                    </h1>
                    <ol class="breadcrumb">
                        <li><a href="<?=base_url()?>index.php/admin/dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
                        <li class="active">Job Post</li>
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
                                     <h3 class="box-title">All Job Post</h3>
                                </div>
                                <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                                    <a class="btn btn-default pull-right" data-toggle="modal" href='#modal-id'>Add New Job Post</a>
                                </div>
                                     
                                    
                                </div>
                                   
                                    
                                </div><!-- /.box-header -->
                                <div class="box-body table-responsive">
                                      <table  width = "100%" class="table table-striped table-bordered table-hover" id="example1">
                                        <thead>
                                            <tr>
                                                <th>Sr. No.</th>
                                                <th>Job Title</th>
                                                <th>Department</th>
                                                <th>Type</th>
                                                <th>Status</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                       <?php $i=1; foreach ($all_job_posts as $key): ?>
                                            <tr>
                                                <td><?=$i?></td>
                                                <td><?=$key->job_title?></td>
                                                <td><?=$key->department?></td>
                                                <td><?=$key->type?></td>
                                                <td> <?=($key->status == '1')?"Active" : "Inactive"?></td>
                                                <td>
                                                    <div class="btn-group">
                                                        <a href="#modal-id<?=$key->job_id?>" data-toggle="modal" class="btn btn-default"><i class="fa fa-edit"></i> Edit</a>
                                                        <?php if ($key->status == 1): ?> 
                                                            <a type="button" href="<?=base_url()?>index.php/admin/deactivate_job_post/<?=$key->job_id?>" class="btn btn-default"><i class="fa fa-times"></i> Deactivate</a>
                                                        <?php else: ?>
                                                            <a type="button" href="<?=base_url()?>index.php/admin/activate_job_post/<?=$key->job_id?>"  class="btn btn-default"><i class="fa fa-check"></i> Activate</a>
                                                        <?php endif ?>
                                                         <a type="button" href="<?=base_url()?>index.php/admin/job_post_application/<?=$key->job_id?>" class="btn btn-default" title="Response Count" ><i class="fa fa-thumbs-o-up"></i> <span class="badge primary"><?=$key->response_count?></span> </a>

                                                        <a type="button" onclick = "return confirm('Do You really want to delete this Job Post')" href="<?=base_url()?>index.php/admin/delete_job_post/<?=$key->job_id?>" class="btn btn-default"><i class="fa fa-trash-o"></i> Delete</a>
                                                    </div>

                                                </td>
                                            </tr>
                                        <?php $i++; endforeach ?>
                                            
                                           
                                        </tbody>
                                        <tfoot>
                                              <th>Sr. No.</th>
                                                <th>Job Title</th>
                                                <th>Department</th>
                                                <th>Type</th>
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
        
<div class="modal fade" id="modal-id">
    <div class="modal-dialog">
        <div class="modal-content"> <form action="<?=base_url()?>index.php/admin/add_job_post" method="POST" role="form" enctype="multipart/form-data">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">Job Post</h4>
            </div>
            <div class="modal-body" style="height:500px;overflow-y:scroll;">
               
                    <legend>Add Job Post</legend>
                    <div class="form-group">
                        <label for="">Title</label>
                         <input type="text" name="job_title" id="input" class="form-control" >
                        
                    </div> 
                    <div class="form-group">
                        <label for="">Location</label>
                         <input type="text" name="location" id="input" class="form-control" >
                        
                    </div> 
                    <div class="form-group">
                        <label for="">Department</label>
                         <input type="text" name="department" id="input" class="form-control" >
                        
                    </div> 
                    <div class="form-group">
                        <label for="">Type</label>
                         <input type="text" name="type" id="input" class="form-control" >
                        
                    </div> 
                    <div class="form-group">
                        <label for="">Minimum Experience</label>
                         <input type="text" name="min_exp" id="input" class="form-control" >
                        
                    </div> 
                    <div class="form-group">
                        <label for="">Job Description</label>
                         <textarea name="job_desc" id="input" class="form-control ckeditor"  ></textarea>
                        
                    </div> 
                    <div class="form-group">
                        <label for="">Skills Required</label>
                         <textarea name="skill_req" id="input" class="form-control ckeditor"  ></textarea>
                        
                    </div> 

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Save changes</button>
            </div> 
            </form>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<?php foreach ($all_job_posts as $key): ?>
    <div class="modal fade" id="modal-id<?=$key->job_id?>">
    <div class="modal-dialog">
        <div class="modal-content">
           <form action="<?=base_url()?>index.php/admin/update_job_post/<?=$key->job_id?>" method="POST" role="form" enctype="multipart/form-data">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">Job Post</h4>
            </div>
            <div class="modal-body" style="height:500px;overflow-y:scroll;">
               
                    <legend>Edit Job Post</legend>
                    <div class="form-group">
                        <label for="">Title</label>
                         <input type="text" name="job_title" id="input" class="form-control" value="<?=$key->job_title?>" >
                        
                    </div> 
                    <div class="form-group">
                        <label for="">Location</label>
                         <input type="text" name="location" id="input" class="form-control" value="<?=$key->location?>" >
                        
                    </div> 
                    <div class="form-group">
                        <label for="">Department</label>
                         <input type="text" name="department" id="input" class="form-control" value="<?=$key->department?>" >
                        
                    </div> 
                    <div class="form-group">
                        <label for="">Type</label>
                         <input type="text" name="type" id="input" class="form-control" value="<?=$key->type?>" >
                        
                    </div> 
                    <div class="form-group">
                        <label for="">Minimum Experience</label>
                         <input type="text" name="min_exp" id="input" class="form-control" value="<?=$key->min_exp?>" >
                        
                    </div> 
                    <div class="form-group">
                        <label for="">Job Description</label>
                         <textarea name="job_desc" id="input" class="form-control ckeditor"  ><?=$key->job_desc?></textarea>
                        
                    </div> 
                    <div class="form-group">
                        <label for="">Skills Required</label>
                         <textarea name="skill_req" id="input" class="form-control ckeditor"  ><?=$key->skill_req?></textarea>
                        
                    </div>               
               
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Save changes</button>
            </div> 
            </form>
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
