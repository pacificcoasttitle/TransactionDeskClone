            <!-- Right side column. Contains the navbar and content of the page -->
            <aside class="right-side">
                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <h1>
                        Article List
                    </h1>
                    <ol class="breadcrumb">
                        <li><a href="<?=base_url()?>index.php/admin/dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
                        <li><a href="<?=base_url()?>index.php/admin/users"><i class="fa fa-users"></i> Users</a></li>
                        <li class="active">User Articles List</li>
                    </ol>
                </section>

                <!-- Main content -->
                <section class="content">
                    <div class="row">
                        <div class="col-xs-12">
                            <div class="box">
                                <div class="box-header">
                                <div class="row">
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                     <h3 class="box-title">User Articles</h3>
                                </div>
                                
                                     
                                    
                                </div>
                                   
                                    
                                </div><!-- /.box-header -->
                                <div class="box-body table-responsive">
                                    <table id="example1" class="table table-bordered table-striped">
                                        <thead>
                                            <tr>
                                                <th>Sr. No.</th>
                                                <th>Title</th>
                                                <th>Release date</th> 
                                                <th>Status</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                       <?php $i=1; foreach ($all_article as $key): ?>
                                            <tr>
                                                <td><?=$i?></td>
                                                <td><?=ucfirst($key->title)?></td>
                                                 <td><?=$key->rdate?></td>
                                                <td> <?=($key->status == '1')?"Active" : "Inactive"?></td>
                                              
                                                <td>
                                                    <div class="btn-group">
                                                        <!-- <a href="<?=base_url()?>index.php/admin/edit_faculty/<?=$key->articleid?>" data-toggle="modal" class="btn btn-default"><i class="fa fa-edit"></i> Edit</a> -->
                                                        <?php if ($key->status == 1): ?> 
                                                            <a type="button" href="<?=base_url()?>index.php/admin/deactivate_article/<?=$key->articleid?>" class="btn btn-default"><i class="fa fa-times"></i> Deactivate</a>
                                                        <?php else: ?>
                                                            <a type="button" href="<?=base_url()?>index.php/admin/activate_article/<?=$key->articleid?>"  class="btn btn-default"><i class="fa fa-check"></i> Activate</a>
                                                        <?php endif ?>
                                                         <a type="button" href="<?=base_url()?>index.php/admin/view_article/<?=$key->articleid?>" class="btn btn-default"><i class="fa fa-eye"></i> View</a>
                                                        <a type="button" onclick= "return confirm('Do You really want to delete this article')" href="<?=base_url()?>index.php/admin/delete_article/<?=$key->articleid?>" class="btn btn-default"><i class="fa fa-trash-o"></i> Delete</a>
                                                    </div>
                                                </td>
                                            </tr>
                                        <?php $i++; endforeach ?>
                                            
                                           
                                        </tbody>
                                        <tfoot>
                                             <tr>
                                               <th>Sr. No.</th>
                                                <th>Title</th>
                                                <th>Release date</th> 
                                                <th>Status</th>
                                                <th>Actions</th>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div><!-- /.box-body -->
                            </div><!-- /.box -->
                        </div>
                    </div>

                </section><!-- /.content -->
            </aside><!-- /.right-side -->
        </div><!-- ./wrapper -->

        <script src="http://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
        <!-- page script -->
        <script type="text/javascript">
            $(function() {
                $("#example1").dataTable();
                $("#datepicker").datepicker({ dateFormat: 'yy-mm-dd' });

                $('#example2').dataTable({
                    "bPaginate": true,
                    "bLengthChange": false,
                    "bFilter": false,
                    "bSort": true,
                    "bInfo": true,
                    "bAutoWidth": false
                });
            });
        </script>
<div class="modal fade" id="modal-id">
    <div class="modal-dialog">
        <div class="modal-content"> <form action="<?=base_url()?>index.php/admin/add_news" method="POST" role="form">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">News</h4>
            </div>
            <div class="modal-body">
               
                    <legend>Add News</legend>
                
                    <div class="form-group">
                        <label for="">Date</label>
                        <input type="text" name = "date_news" class="form-control" id="datepicker" placeholder="Input Date">
                    </div>

                    <div class="form-group">
                        <label for="">News Heading</label>
                        <input type="text" name = "news_heading" class="form-control" placeholder="Insert News Title">
                    </div>

                    <div class="form-group">
                        <label for="">Heading Link</label>
                        <input type="text" name = "news_link" class="form-control" placeholder="Insert News Title">
                    </div>

                    <div class="form-group">
                        <label for="">Image</label>
                        <input type="file" name = "user_file" >
                    </div>

                     <div class="form-group">
                        <label for="">Description</label>
                        <textarea name="description" class="form-control ckeditor"></textarea>
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





    </body>
</html>
