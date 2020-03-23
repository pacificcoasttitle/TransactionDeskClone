 <aside class="right-side">
                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <h1>
                        Users List
                    </h1>
                    <ol class="breadcrumb">
                        <li><a href="<?=base_url()?>index.php/admin/dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
                        <li class="active"><i class="fa fa-users"></i> Users List</li>
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
                                     <h3 class="box-title">All Users</h3>
                                </div>
                                 <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                                    <a class="btn btn-default pull-right" href='<?=base_url()?>index.php/admin/add_user'>Add New User</a>
                                </div>
                                     
                                    
                                </div>
                                   
                                    
                                </div><!-- /.box-header -->
                                <div class="box-body table-responsive">
          <table  width = "100%" class="table table-striped table-bordered table-hover" id="example1">
              <thead>
                  <tr>
                      <th class="col-md-1">Sr. no.</th>
                      <th  class="col-md-2" >Name</th>
                      <th  class="col-md-2" >Email Id</th> <th>Status</th>
                      <th  class="col-md-2" >Email verification</th>
                     
                      <th  class="col-md-5" width="50%">Actions</th>        
                  </tr>
              </thead>
              <tbody>
              <?php $i = 1; foreach ($all_users as $key): ?>
                   <tr>
                      <td><?=$i;?></td>
                      <td><?=$key->fname;?> <?=$key->lname;?> <?=($key->profilepic !="")?'<i title = "Profile picture has been uploaded." class="fa fa-user-md pull-right"></i>':NULL?><?=($key->cv !="")?'<i title = "CV has been uploaded." class="fa fa-file-pdf-o pull-right"></i>':NULL?></td>
                      <td><?=$key->email;?></td>
                       <td> <?=($key->status == '1')?"Active" : "Inactive"?></td>
                       <td> <?=($key->email_verification == '1')?"Verified" : "Not Verified"?></td>
                      <td>
                        <div class="btn-group">
                          <?php if ($key->status == 1): ?> 
                              <a type="button" href="<?=base_url()?>index.php/admin/deactivate_user/<?=$key->userid?>" class="btn btn-default"><i class="fa fa-times"></i> Deactivate</a>
                          <?php else: ?>
                              <a type="button" href="<?=base_url()?>index.php/admin/activate_user/<?=$key->userid?>"  class="btn btn-default"><i class="fa fa-check"></i> Activate</a>
                          <?php endif ?>
                          <a type="button" href="<?=base_url()?>index.php/admin/view_user/<?=$key->userid?>"  class="btn btn-default"><i class="fa fa-eye"></i> View </a>
                          <a type="button" href="<?=base_url()?>index.php/admin/uploaded_article/<?=$key->userid?>"  class="btn btn-default"><i class="fa fa-upload"></i> Uploaded Articles</a>
                          <a type="button" href="<?=base_url()?>index.php/admin/downloaded_article/<?=$key->userid?>"  class="btn btn-default"><i class="fa fa-download"></i> Downloaded Articles</a>
                          <a type="button" data-toggle="modal" href="#email_pro" onclick="send_promo_email(<?=$key->userid?>)"  class="btn btn-default"><i class="fa fa-envelope"></i> Send Promotional mail</a>
                          <a  class="btn btn-default" href="<?=base_url()?>index.php/admin/delete_user/<?=$key->userid;?>" onclick="return confirm('Really want to delete this user ??')"><i class="fa fa-trash-o" title="Delete"> Delete</i> </a>
                        </div>
                      </td>
                  </tr>
              <?php $i++; endforeach ?>                                 
              </tbody>
          </table>     
            </table>
                                </div><!-- /.box-body -->
                            </div><!-- /.box -->
                        </div>
                    </div>

                </section><!-- /.content -->
            </aside><!-- /.right-side -->
        </div><!-- ./wrapper -->


        <div class="modal fade" id="email_pro">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">Send Promotional Email</h4>
              </div>
              <div class="modal-body">
                <form action="<?=base_url()?>index.php/admin/send_promo_email" method="POST" role="form" id="#promo_form">
                  <legend>Edit Promotional Email</legend>
                
                  <div class="form-group">
                    <label for="">User Email</label>
                    <input type="email" name = "email" id="promo_form_email" class="form-control" id="" placeholder="Input Email">
                  </div>
                  
                 <div id="demo"></div>
                  
                
                  <button type="submit" class="btn btn-primary"><i class="fa fa-send"></i> Send</button>
                </form>
              </div>
             
            </div><!-- /.modal-content -->
          </div><!-- /.modal-dialog -->
        </div><!-- /.modal -->
 <script src="http://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
        <!-- page script -->
        <script type="text/javascript">
           

var desc_id1 = 0;
var desc_id2 = 1;
    function send_promo_email (id) 
    {
        $("#content_edit").html("");
        $("#cke_content_edit").remove();
        $.ajax({
            url     : "<?=base_url()?>index.php/admin/send_promo_email/"+id,
            type    : "POST",
            contentType: false,
            cache: false,
            processData: false,
            success : function( data )
            {
               var obj = $.parseJSON(data);
                $.each(obj,function(key,val)
                {
                    if(key == 'email')
                    {
                         $("#promo_form_email").val(val);
                    }

                    if(key == 'message')
                    {
                          $("#demo").html('<textarea  name="message" id="description_'+desc_id2+'" rows="5"  class="form-control" ></textarea>');

                            
                                  $("#description_"+desc_id2).html(val); 
                                  $("#description_"+desc_id2).show(); 
                                  desc_id1 = desc_id2;
                                  desc_id2 +=1;
                                  CKEDITOR.replace( 'description_'+desc_id1 );
                    }

                });
            },
            error   : function( xhr, err )
            {
            $("#error").show();
            }
            });
    }
        </script>