            <!-- Right side column. Contains the navbar and content of the page -->
            <aside class="right-side">
                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <h1>
                        Faqs
                    </h1>
                    <ol class="breadcrumb">
                        <li><a href="<?=base_url()?>index.php/admin/dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
                        <li class="active">Faqs</li>
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
                                     <h3 class="box-title">All Faqs</h3>
                                </div>
                                <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                                    <a class="btn btn-default pull-right" data-toggle="modal" href='#modal-id'>Add New Faqs</a>
                                </div>
                                     
                                    
                                </div>
                                   
                                    
                                </div><!-- /.box-header -->
                                <div class="box-body table-responsive">
                                    <table id="example1" class="table table-bordered table-striped">
                                        <thead>
                                            <tr>
                                                <th>Sr. No.</th>
                                                <th>Question</th>
                                                <th>Answer</th>
                                                <th>Status</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                       <?php $i=1; foreach ($all_faqs as $key): ?>
                                            <tr>
                                                <td><?=$i?></td>
                                                <td><?=ucfirst(substr($key->question,0,30))?>...</td>
                                                <td><?=ucfirst(substr($key->answer,0,30))?>...</td>
                                                <td> <?=($key->status == '1')?"Active" : "Inactive"?></td>
                                                <td>
                                                    <div class="btn-group">
                                                        <a href="#modal-id<?=$key->faqid?>" data-toggle="modal" class="btn btn-default"><i class="fa fa-edit"></i> Edit</a>
                                                        <?php if ($key->status == 1): ?> 
                                                            <a type="button" href="<?=base_url()?>index.php/admin/deactivate_faq/<?=$key->faqid?>" class="btn btn-default"><i class="fa fa-times"></i> Deactivate</a>
                                                        <?php else: ?>
                                                            <a type="button" href="<?=base_url()?>index.php/admin/activate_faq/<?=$key->faqid?>"  class="btn btn-default"><i class="fa fa-check"></i> Activate</a>
                                                        <?php endif ?>
                                                        <a type="button" onclick "return confirm('Do You really want to delete this Faq')" href="<?=base_url()?>index.php/admin/delete_faq/<?=$key->faqid?>" class="btn btn-default"><i class="fa fa-trash-o"></i> Delete</a>
                                                    </div>
                                                </td>
                                            </tr>
                                        <?php $i++; endforeach ?>
                                            
                                           
                                        </tbody>
                                        <tfoot>
                                             <th>Sr. No.</th>
                                                <th>Question</th>
                                                <th>Answer</th>
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
        <div class="modal-content"> <form action="<?=base_url()?>index.php/admin/add_faq" method="POST" role="form">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">Faq</h4>
            </div>
            <div class="modal-body">
               
                    <legend>Add Faq</legend>
                    <div class="form-group">
                        <label for="">Question</label>
                        
                        <textarea name="question" class="form-control" placeholder="Insert Faq Question"></textarea>
                    </div>

                    <div class="form-group">
                        <label for="">Answer</label>
                        <textarea name="answer" class="form-control ckeditor" placeholder="Insert Answer"></textarea>
                        
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

<?php foreach ($all_faqs as $key): ?>
    <div class="modal fade" id="modal-id<?=$key->faqid?>">
    <div class="modal-dialog">
        <div class="modal-content">
           <form action="<?=base_url()?>index.php/admin/update_faq/<?=$key->faqid?>" method="POST" role="form">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">Faq</h4>
            </div>
            <div class="modal-body">
               
                    <legend>Edit Faq</legend>
                     <div class="form-group">
                        <label for="">Question</label>
                        
                        <textarea name="question" class="form-control" value = "" placeholder="Insert Faq Question"><?=$key->question?></textarea>
                    </div>

                    <div class="form-group">
                        <label for="">Answer</label>
                        <textarea name="answer" class="form-control ckeditor" value = "" placeholder="Insert Answer"><?=$key->answer?></textarea>
                        
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
    $(function() {
                $("#datepicker_ed1<?=$key->faqid?>").datepicker({ dateFormat: 'yy-mm-dd',
                        onSelect: function(dateText, inst) {

                    if (inst.id == 'datepicker_ed1<?=$key->faqid?>') {
                                   // alert(hi);
                                $("#datepicker_ed2<?=$key->faqid?>").datepicker("option", "minDate", dateText);

                            }
                        }
                    });
                $("#datepicker_ed2<?=$key->faqid?>").datepicker({ dateFormat: 'yy-mm-dd' });

            });
</script>
<?php endforeach ?>

 <script src="http://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
        <!-- page script -->
        <script type="text/javascript">
            $(function() {
                $("#example1").dataTable();
             

            });
        </script>



    </body>
</html>
