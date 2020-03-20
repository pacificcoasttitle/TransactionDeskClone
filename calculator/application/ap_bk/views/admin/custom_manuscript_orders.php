            <!-- Right side column. Contains the navbar and content of the page -->
            <aside class="right-side">
                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <h1>
                        Custom Quote Requests
                    </h1>
                    <ol class="breadcrumb">
                        <li><a href="<?=base_url()?>index.php/admin/dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
                        <li class="active">Custom Quote Requests</li>
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
                                     <h3 class="box-title">All Custom Quote Requests</h3>
                                </div>
                                <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
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
                                                <th>Requirement</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                       <?php $i=1; foreach ($all_custom_manuscript_orders as $key): ?>
                                            <tr>
                                                <td><?=$i?></td>
                                                <td><?=$key->fname?> <?=$key->lname?></td>
                                                <td><?=$key->email?></td>
                                                <td><?=$key->requirement?></td>
                                                <td>
                                                    <div class="btn-group">
                                                        <a href="<?=base_url()?>admin/view_custom_manuscript_order/<?=$key->id?>" data-toggle="modal" class="btn btn-default"><i class="fa fa-eye"></i> View</a>
                                                      </div>
                                                </td>
                                            </tr>
                                        <?php $i++; endforeach ?>
                                            
                                           
                                        </tbody>
                                        <tfoot>
                                             <th>Sr. No.</th>
                                                <th>Name</th>
                                                <th>Email</th>
                                                <th>Requirement</th>
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


 <script src="http://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
        <!-- page script -->
        <script type="text/javascript">
            $(function() {
                $("#example1").dataTable();
             

            });
        </script>
