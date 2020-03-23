            <!-- Right side column. Contains the navbar and content of the page -->
            <aside class="right-side">
                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <h1>
                        Books
                    </h1>
                    <ol class="breadcrumb">
                        <li><a href="<?=base_url()?>index.php/admin/dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
                        <li class="active">Books</li>
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
                                     <h3 class="box-title">All Books</h3>
                                </div>
                                <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                                    <a class="btn btn-default pull-right" data-toggle="modal" href='<?=base_url()?>index.php/admin/add_book'>Add New Book</a>
                                </div>
                                     
                                    
                                </div>
                                   
                                    
                                </div><!-- /.box-header -->
                                <div class="box-body table-responsive">
                                      <table  width = "100%" class="table table-striped table-bordered table-hover" id="example1">
                                        <thead>
                                            <tr>
                                                <th>Sr. No.</th>
                                                <th>Image</th>
                                                <th>Book Title</th>
                                                <th>Book Author</th>
                                                <th>Status</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                       <?php $i=1; foreach ($all_books as $key): ?>
                                            <tr>
                                                <td><?=$i?></td>
                                                <td><img src="<?=base_url()?>upload/books/<?=$key->bookid?>/<?=$key->image?>"  style="max-height:100px;" ></td>
                                                <td><?=$key->book_title?></td>
                                                <td><?=$key->author?></td>
                                                <td> <?=($key->status == '1')?"Active" : "Inactive"?></td>
                                                <td>
                                                    <div class="btn-group">
                                                        <a href="<?=base_url()?>admin/edit_book/<?=$key->bookid?>" data-toggle="modal" class="btn btn-default"><i class="fa fa-edit"></i> Edit</a>
                                                        <?php if ($key->status == 1): ?> 
                                                            <a type="button" href="<?=base_url()?>index.php/admin/deactivate_book/<?=$key->bookid?>" class="btn btn-default"><i class="fa fa-times"></i> Deactivate</a>
                                                        <?php else: ?>
                                                            <a type="button" href="<?=base_url()?>index.php/admin/activate_book/<?=$key->bookid?>"  class="btn btn-default"><i class="fa fa-check"></i> Activate</a>
                                                        <?php endif ?>
                                                        <a type="button" onclick = "return confirm('Do You really want to delete this Book')" href="<?=base_url()?>index.php/admin/delete_book/<?=$key->bookid?>" class="btn btn-default"><i class="fa fa-trash-o"></i> Delete</a>
                                                    </div>
                                                </td>
                                            </tr>
                                        <?php $i++; endforeach ?>
                                            
                                           
                                        </tbody>
                                        <tfoot>
                                              <th>Sr. No.</th>
                                                <th>Image</th>
                                                <th>Book Title</th>
                                                <th>Book Author</th>
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


 <script src="http://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
        <!-- page script -->
        <script type="text/javascript">
            $(function() {
                $("#example1").dataTable();
             

            });
        </script>
