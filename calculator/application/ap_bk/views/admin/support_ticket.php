  <style type="text/css">
    .btn-bordered {
  border: 1px solid #b4b4b4 !important; 
}

</style>
            <!-- Right side column. Contains the navbar and content of the page -->
            <aside class="right-side">
                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <h1>
                        Support Tickets
                    </h1>
                    <ol class="breadcrumb">
                        <li><a href="<?=base_url()?>index.php/admin/dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
                        <li class="active">Support Ticket List</li>
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
                                     <h3 class="box-title">All Support Tickets</h3>
                                      <div class="btn-group pull-right">
                        <a type="button" class="btn <?=($find_array['status'] == '')?'btn-primary':'btn-bordered'?>" onclick="filter_support('')">Total <span class="badge"><?=$count_total?></span></a>
                        <a type="button" class="btn <?=($find_array['status'] == '1')?'btn-primary':'btn-bordered'?>" onclick="filter_support(1)">Open <span class="badge"><?=$count_open?></span></a>
                        <a type="button" class="btn <?=($find_array['status'] == '3')?'btn-primary':'btn-bordered'?>" onclick="filter_support(3)">Closed <span class="badge"><?=$count_closed?></span></a>
                        <a type="button" class="btn <?=($find_array['status'] == '2')?'btn-primary':'btn-bordered'?>" onclick="filter_support(2)">Resolved <span class="badge"><?=$count_resolved?></span></a>
                    </div>
                    <form id="support_filter" action="" method="POST" role="form">
                        <input type="hidden" class="form-control" id="status" name = "status" value="" >
                    </form>
                                </div>
                                
                                     
                                    
                                </div>
                                   
                                    
                                </div><!-- /.box-header -->
                                <div class="box-body table-responsive">

                                    <table id="example1" class="table table-bordered table-striped">
                                        <thead>
                                            <tr>
                                               <th>Answered</th>
                                                <th>Ticket. No.</th>
                                                <th>Topic</th>
                                                <th>Subject</th> 
                                                <th>Create date</th>
                                                <th>Status</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                       <?php $i=1; foreach ($all_tickets as $key): ?>
                                            <tr>
                                            <td><i class = "fa <?=($key->isanswered == 1)?'fa-check':'fa-times'?>"></i></td>
                                                <td><?=$key->number?></td>
                                                <td><?=ucfirst($key->topic)?></td>
                                                <td><a href="<?=base_url()?>index.php/admin/view_ticket_thread/<?=$key->number?>"><?=ucfirst($key->subject)?></a>(<?=ucfirst($key->thread_count)?> <i class="fa fa-comments"></i>)</td>
                                                 <td><?=date("j F Y",strtotime($key->created))?></td>
                                                <td> <?=$key->name?></td>
                                                <td>
                                                    <div class="btn-group">
                                                         <a type="button" href="<?=base_url()?>index.php/admin/view_ticket_thread/<?=$key->number?>" class="btn btn-default"><i class="fa fa-eye"></i> View Thread</a>
                                                        <!-- <a type="button" onclick= "return confirm('Do You really want to delete this ticket_')" href="<?=base_url()?>index.php/admin/delete_ticket/<?=$key->ticket_id?>" class="btn btn-default"><i class="fa fa-trash-o"></i> Delete</a> -->
                                                    </div>
                                                </td>
                                            </tr>
                                        <?php $i++; endforeach ?>
                                            
                                           
                                        </tbody>
                                        <tfoot>
                                             <tr>
                                                <th>Ticket. No.</th>
                                                <th>Topic</th>
                                                <th>Subject</th> 
                                                <th>Create date</th>
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




<script>
    

    function filter_support (st_id) 
    {
        $("#status").val(st_id);
        $("#support_filter").submit();
    }
</script>
    </body>
</html>
