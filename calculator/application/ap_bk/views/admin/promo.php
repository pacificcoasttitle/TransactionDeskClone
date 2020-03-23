            <!-- Right side column. Contains the navbar and content of the page -->
            <aside class="right-side">
                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <h1>
                        Voucher Codes
                    </h1>
                    <ol class="breadcrumb">
                        <li><a href="<?=base_url()?>index.php/admin/dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
                        <li class="active">Voucher Codes</li>
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
                                     <h3 class="box-title">All Voucher Codes</h3>
                                </div>
                                <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                                    <a class="btn btn-default pull-right" data-toggle="modal" href='#modal-id'>Add New Voucher Codes</a>
                                </div>
                                     
                                    
                                </div>
                                   
                                    
                                </div><!-- /.box-header -->
                                <div class="box-body table-responsive">
                                      <table  width = "100%" class="table table-striped table-bordered table-hover" id="example1">
                                        <thead>
                                            <tr>
                                                <th>Sr. No.</th>
                                                
                                                <th>Code</th>
                                                <th>Status</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                       <?php $i=1; foreach ($all_promos as $key): ?>
                                            <tr>
                                                <td><?=$i?></td>
                                                <td><?=$key->code?></td>
                                                <td> <?=($key->status == '1')?"Active" : "Inactive"?></td>
                                                <td>
                                                    <div class="btn-group">
                                                        <a href="#modal-id<?=$key->id?>" data-toggle="modal" class="btn btn-default"><i class="fa fa-edit"></i> Edit</a>
                                                        <?php if ($key->status == 1): ?> 
                                                            <a type="button" href="<?=base_url()?>index.php/admin/deactivate_promo/<?=$key->id?>" class="btn btn-default"><i class="fa fa-times"></i> Deactivate</a>
                                                        <?php else: ?>
                                                            <a type="button" href="<?=base_url()?>index.php/admin/activate_promo/<?=$key->id?>"  class="btn btn-default"><i class="fa fa-check"></i> Activate</a>
                                                        <?php endif ?>
                                                        <a type="button" onclick = "return confirm('Do You really want to delete this Voucher Code')" href="<?=base_url()?>index.php/admin/delete_promo/<?=$key->id?>" class="btn btn-default"><i class="fa fa-trash-o"></i> Delete</a>
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
        
<div class="modal fade" id="modal-id">
    <div class="modal-dialog">
        <div class="modal-content"> <form action="<?=base_url()?>index.php/admin/add_promo" method="POST" role="form" enctype="multipart/form-data">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">Voucher Code</h4>
            </div>
            <div class="modal-body">
               
                    <legend>Add Voucher Code</legend>
                    <div class="form-group">
                        <label for="">code</label>
                         <input type="text" name="code" id="input" class="form-control" class="btn" >
                        
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

<?php foreach ($all_promos as $key): ?>
    <div class="modal fade" id="modal-id<?=$key->id?>">
    <div class="modal-dialog">
        <div class="modal-content">
           <form action="<?=base_url()?>index.php/admin/update_promo/<?=$key->id?>" method="POST" role="form" enctype="multipart/form-data">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">Voucher Code</h4>
            </div>
            <div class="modal-body">
               
                    <legend>Edit Voucher Code</legend>
                    <div class="form-group">
                        <label for="">code</label>
                         <input type="text" name="code" id="input" class="form-control" class="btn" value="<?=$key->code?>" >
                        
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
