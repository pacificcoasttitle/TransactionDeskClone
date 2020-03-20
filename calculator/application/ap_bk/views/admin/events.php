            <!-- Right side column. Contains the navbar and content of the page -->
            <aside class="right-side">
                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <h1>
                        Events
                    </h1>
                    <ol class="breadcrumb">
                        <li><a href="<?=base_url()?>index.php/admin/dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
                        <li class="active">Events</li>
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
                                     <h3 class="box-title">All Events</h3>
                                </div>
                                <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                                    <a class="btn btn-default pull-right" data-toggle="modal" href='#modal-id'>Add New Events</a>
                                </div>
                                     
                                    
                                </div>
                                   
                                    
                                </div><!-- /.box-header -->
                                <div class="box-body table-responsive">
                                      <table  width = "100%" class="table table-striped table-bordered table-hover" id="example1">
                                        <thead>
                                            <tr>
                                                <th>Sr. No.</th>
                                                <th >Image</th>
                                                <th >Event name</th>
                                                <th>Link</th>
                                                <th>Status</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                       <?php $i=1; foreach ($all_events as $key): ?>
                                            <tr>
                                                <td><?=$i?></td>
                                                <td><img style="max-width:200px;" class="img-responsive" src="<?=base_url()?>upload/events/<?=$key->eventid?>/<?=$key->image?>"></td>
                                                <td><a target="_blank" href="<?=$key->link?>"><?=$key->event_title?></a></td>
                                                <td><a target="_blank" href="<?=$key->link?>"><?=$key->link?></a></td>
                                                
                                                <td> <?=($key->status == '1')?"Active" : "Inactive"?></td>
                                                <td>
                                                    <div class="btn-group">
                                                        <a href="#modal-id<?=$key->eventid?>" data-toggle="modal" class="btn btn-default"><i class="fa fa-edit"></i> Edit</a>
                                                        <?php if ($key->status == 1): ?> 
                                                            <a type="button" href="<?=base_url()?>index.php/admin/deactivate_event/<?=$key->eventid?>" class="btn btn-default"><i class="fa fa-times"></i> Deactivate</a>
                                                        <?php else: ?>
                                                            <a type="button" href="<?=base_url()?>index.php/admin/activate_event/<?=$key->eventid?>"  class="btn btn-default"><i class="fa fa-check"></i> Activate</a>
                                                        <?php endif ?>
                                                        <a type="button" onclick = "return confirm('Do You really want to delete this Event')" href="<?=base_url()?>index.php/admin/delete_event/<?=$key->eventid?>" class="btn btn-default"><i class="fa fa-trash-o"></i> Delete</a>
                                                    </div>
                                                </td>
                                            </tr>
                                        <?php $i++; endforeach ?>
                                            
                                           
                                        </tbody>
                                        <tfoot>
                                             <th>Sr. No.</th>
                                                <th >Image</th>
                                                <th >Event name</th>
                                                <th>Link</th>
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
        <div class="modal-content"> <form action="<?=base_url()?>index.php/admin/add_event" method="POST" role="form" enctype="multipart/form-data">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">Event</h4>
            </div>
            <div class="modal-body">
               
                    <legend>Add Event</legend>
                    <div class="form-group">
                        <label for="">Image</label>
                        
                       <input type="file" name="userfile" id="input" class="btn" >
                    </div>

                    <div class="form-group">
                        <label for="">Event Name</label>
                         <input type="text" name="event_title" id="input" class="form-control" class="btn" value="" >
                        
                    </div>

                    <div class="form-group">
                        <label for="">Link</label>
                         <input type="text" name="link" id="input" class="form-control" class="btn" value="" >
                        
                    </div>

                    <div class="form-group">
                        <label for="">Event Date</label>
                         <input type="text" name="event_date" id="datepicker" class="form-control" class="btn" value="" >
                        
                    </div>
<div class="form-group">
                        <label for="">Short Description</label>
                         <textarea name="short_desc" id="inputShort_desc" class="form-control" rows="3" required="required"></textarea>
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
 <script src="http://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
<?php foreach ($all_events as $key): ?>
    <div class="modal fade" id="modal-id<?=$key->eventid?>">
    <div class="modal-dialog">
        <div class="modal-content">
           <form action="<?=base_url()?>index.php/admin/update_event/<?=$key->eventid?>" method="POST" role="form" enctype="multipart/form-data">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">Event</h4>
            </div>
            <div class="modal-body">
               
                    <legend>Edit Event</legend>
                    <div class="form-group">
                        <label for="">Image</label>
                        <img  style="max-width:300px;" class="img-responsive" src="<?=base_url()?>upload/events/<?=$key->eventid?>/<?=$key->image?>">
                        <input type="file" name="userfile" id="input" class="btn" >
                        <input type="hidden" name="old_file" id="input" value="<?=$key->image?>">
                    </div>

                    <div class="form-group">
                        <label for="">Event Name</label>
                         <input type="text" name="event_title" id="input" class="form-control" class="btn" value="<?=$key->event_title?>" >
                        
                    </div>

                    <div class="form-group">
                        <label for="">Link</label>
                         <input type="text" name="link" id="input" class="form-control" class="btn" value="<?=$key->link?>" >
                        
                    </div>

                    <div class="form-group">
                        <label for="">Event Date</label>
                         <input type="text" name="event_date" id="datepicker<?=$key->eventid?>" class="form-control" class="btn" value="<?=$key->event_date?>" >
                        
                    </div>
<div class="form-group">
                        <label for="">Short Description</label>
                         <textarea name="short_desc" id="inputShort_desc" class="form-control" rows="3" required="required"><?=$key->short_desc?></textarea>
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

<script type="text/javascript">
$(document).ready(function() {
    

    $("#datepicker<?=$key->eventid?>" ).datepicker($.extend( {

                dateFormat: 'yy-mm-dd',

            }));
  });

</script>
<?php endforeach ?>



        <!-- page script -->
        <script type="text/javascript">
            $(function() {
                $("#example1").dataTable();
             

            });
        </script>
