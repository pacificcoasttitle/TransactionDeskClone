<!-- Right side column. Contains the navbar and content of the page -->
<aside class="right-side">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
    Book
    </h1>
    <ol class="breadcrumb">
      <li><a href="<?=base_url()?>index.php/admin/dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
      <li><a href="<?=base_url()?>index.php/admin/users">Book List</a></li>
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
                <h3 class="box-title">Add Book Details</h3>
              </div>
              
              
              
            </div>
            
            
            </div><!-- /.box-header -->
            <div class="box-body">
              
              <div class="row">
                <form action="" class="form col-lg-6 col-md-offset-3" method="POST" role="form" enctype="multipart/form-data">
                  <legend>Add Book <span class="text-info pull-right">* (Required Fields)</span></legend>
                  <ul class="nav nav-tabs">
                    <li id="tab1default_li" class="active"><a href="#tab1default" data-toggle="tab">Book Details</a></li>
                    <li id="tab2default_li" ><a href="#tab2default" data-toggle="tab">Bibiliography</a></li>
                    <li id="tab3default_li" ><a href="#tab3default" data-toggle="tab">Table of Content</a></li>
                  </ul>
                  <div class="tab-content">
                    <div class="tab-pane fade in active" id="tab1default">
                      
                      <div class="form-group">
                        <label for="">Book Title :<span class="text-danger">*</span> </label>
                        <input type="text"  class="form-control" id="" value = "<?=$book_detail->book_title?>" name="book_title"  >
                      </div>
                      
                      <div class="form-group">
                        <label for="">Book Sub-Title :<span class="text-danger">*</span> </label>
                        <input type="text"  class="form-control" id="" value = "<?=$book_detail->sub_title?>" name="sub_title"  >
                      </div>
                      <div class="form-group">
                        <label for="">Department  :<span class="text-danger">*</span></label>
                        <select  name="department" id="de" class="form-control" required="required">
                          <option value="">Select Department</option>
                          <?php foreach ($departments as $department): ?>
                          <option <?=($book_detail->speciality == $department->departmentname)?"selected='true'":NULL?> value="<?=$department->departmentname?>"><?=$department->departmentname?></option>
                          <?php endforeach ?>
                        </select>
                        
                      </div>
                      <div class="form-group">
                        <label for="">Author :<span class="text-danger">*</span></label>
                        <input type="text"  class="form-control" value = "<?=$book_detail->author?>" name="author"  required>
                        
                      </div>
                      <div class="form-group">
                        <label for="">Price :<span class="text-danger">*</span></label>
                        <input type="text"  class="form-control" value = "<?=$book_detail->price?>" name="price" required >
                        <input type="hidden" name="old_file" value="<?=$book_detail->image?>">
                      </div>
                      
                      
                      
                      <div class="form-group">
                        <label for="">About  :</label>
                        <textarea name="profile_desc" class="form-control ckeditor"><?=$book_detail->about;?></textarea>
                      </div>
                    </div>
                    <!--  Tab 1 end -->
                    <div class="tab-pane fade " id="tab2default">
                      <legend>Bibiliographic Information</legend>
                      <div class="form-group">
                        <label for="">ISBN :<span class="text-danger">*</span></label>
                        <input type="text"  class="form-control" value = "<?=$book_detail->isbn?>" name="isbn" required >
                        
                      </div>
                      <div class="form-group">
                        <label for="">ISBN(eBook) :<span class="text-danger">*</span></label>
                        <input type="text"  class="form-control" value = "<?=$book_detail->isbn_ebook?>" name="isbn_ebook" required >
                        
                      </div>
                      <div class="form-group">
                        <label for="">ISBN(Softcopy) :<span class="text-danger">*</span></label>
                        <input type="text"  class="form-control" value = "<?=$book_detail->isbn_soft?>" name="isbn_soft" required >
                        
                      </div>
                      <div class="form-group">
                        <label for="">DOI :<span class="text-danger">*</span></label>
                        <input type="text"  class="form-control" value = "<?=$book_detail->doi?>" name="doi" required >
                        
                      </div>
                      <div class="form-group">
                        <label for="">Book Format :<span class="text-danger">*</span></label>
                        <input type="text"  class="form-control" value = "<?=$book_detail->book_format?>" name="book_format" required >
                        
                      </div>
                      <div class="form-group">
                        <label for="">Copyright :<span class="text-danger">*</span></label>
                        <input type="text"  class="form-control" value = "<?=$book_detail->copyright?>" name="copyright" required >
                        
                      </div>
                      <div class="form-group">
                        <label for="">Publisher :<span class="text-danger">*</span></label>
                        <input type="text"  class="form-control" value = "<?=$book_detail->publisher?>" name="publisher" required >
                        
                      </div>
                      <div class="form-group">
                        <label for="">Copyright Holder :<span class="text-danger">*</span></label>
                        <input type="text"  class="form-control" value = "<?=$book_detail->copyright_holder?>" name="copyright_holder" required >
                        
                      </div>
                      <div class="form-group">
                        <label for="">Edition :<span class="text-danger">*</span></label>
                        <input type="text"  class="form-control" value = "<?=$book_detail->edition?>" name="edition" required >
                        
                      </div>
                      <div class="form-group">
                        <label for="">Pages :<span class="text-danger">*</span></label>
                        <input type="text"  class="form-control" value = "<?=$book_detail->pages?>" name="pages" required >
                        
                      </div>
                      <div class="row">
                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                          <div class="form-group">
                            <label for="">Upload book Image : </label>
                            <input class="btn btn-default" type="file" name="userfile" accept="image/*" >
                            
                            
                          </div>
                        </div>
                      </div>
                      
                      
                      
                      
                    </div>
                    <!--  Tab 2 end -->
                    <div class="tab-pane fade in" id="tab3default">
                      <div id="box_contriadvanced">
                        <?php foreach ($book_toc as $key): ?>
                        
                        <div class="clone">
                          <div class="form-group col-lg-12">
                            <label for="">Title :</label>
                            <input type="text" name = "contri_title[]" placeholder="Title" value="<?=$key->content_title?>"  maxlength="100"    class="form-control">
                            
                          </div>
                          
                          <div class="form-group col-lg-6">
                            <label for="">Sub-title :</label>
                            <input type="text" name = "contri_subtitle[]" placeholder="Sub-title" maxlength="10"  value="<?=$key->subtitle?>"  class="form-control">
                          </div>
                          <div class="form-group col-lg-6">
                            <label for="">Pages :</label>
                            <div class="input-group">
                              <input type="text" name = "contri_pages[]"  placeholder="Pages"  maxlength="10" value="<?=$key->pages?>" class="form-control">
                              <div style="cursor:pointer;" onclick="remove_contri(this)" class="input-group-addon"><i class="fa fa-times"></i>
                              </div>
                              
                            </div>
                          </div>
                          
                          <small>&nbsp;</small>
                        </div>
                        <?php endforeach ?>
                        
                        
                      </div>
                      <button onclick="add_contributers('advanced')" type="button" class="btn btn-primary btn-sm pull-right"><i class="fa fa-plus" ></i> </button>
                      
                    </div>
                    <!--  Tab 3 end -->
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                      <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                    
                  </form>
                </div>
                
                
                
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
            <script type="text/javascript" >
            
            function add_contributers (id)
            {
            if(id=="advanced")
            {
            $("#box_contri"+id).append(' <div class="clone"><div class="form-group col-lg-12"><label for="">Title :</label><input type="text" name = "contri_title[]" placeholder="Title" value=""  maxlength="100"    class="form-control"></div><div class="form-group col-lg-6"><label for="">Sub-title :</label><input type="text" name = "contri_subtitle[]" placeholder="Sub-title" maxlength="10"  value=""  class="form-control"></div><div class="form-group col-lg-6"><label for="">Pages :</label><div class="input-group"><input type="text" name = "contri_pages[]"  placeholder="Pages"  maxlength="10" value="" class="form-control"><div style="cursor:pointer;" onclick="remove_contri(this)" class="input-group-addon"><i class="fa fa-times"></i></div></div></div><small>&nbsp;</small></div>');
            }
            else
            {
            $("#box_contri"+id).append('<div class="clone"><input type="text" name = "contri_name[]" placeholder="Name*" maxlength="100"  required="required"  class="form-control"><input type="text" name = "contri_unit[]" placeholder="Units"  maxlength="15"  class="form-control"><input type="hidden" name = "contri_type[]" value="Normal"><input type="text" name = "contri_lower[]" placeholder="Lower Bound" maxlength="10"   class="form-control"><div class="input-group"><input type="text" name = "contri_upper[]"  placeholder="Upper Bound"  maxlength="10" class="form-control"> <div style="cursor:pointer;" onclick="remove_contri(this)" class="input-group-addon"><i class="fa fa-times"></i></div></div><small>&nbsp;</small></div>');
            }
            }
            function remove_contri (cross)
            {
            var parentRow = $(cross).closest('div .clone');
            $(parentRow).remove();
            }
            </script>
          </body>
        </html>