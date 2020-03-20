            <!-- Right side column. Contains the navbar and content of the page -->
            <aside class="right-side">
                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <h1>
                        Order
                    </h1>
                    <ol class="breadcrumb">
                        <li><a href="<?=base_url()?>index.php/admin/dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
                        <li><a href="<?=base_url()?>index.php/admin/users">Order List</a></li>
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
                                     <h3 class="box-title">View Order Details</h3> 
                                </div>
                               
                                     
                                    
                                </div>
                                   
                                    
                                </div><!-- /.box-header -->
                                <div class="box-body">
                               
                                    <div class="row">
                                     <form action="" class="form col-lg-6 col-md-offset-3" method="POST" role="form" enctype="multipart/form-data">
                                       <legend>View Order </legend>
                                        <ul class="nav nav-tabs">
                                          <li id="tab1default_li" class="active"><a href="#tab1default" data-toggle="tab">Order Details</a></li>
                                          <li id="tab2default_li" ><a href="#tab2default" data-toggle="tab">Documents</a></li>
                                          </ul>
                                        <div class="tab-content">
                                          <div class="tab-pane fade in active" id="tab1default">
                                      
                                        <div class="form-group">
                                        <table class="table">
                                          
                                          <tbody>
                                          <tr><td><label for="">Name</label> </td><td><?=$order_info->fname?> <?=$order_info->lname?></td></tr>
                                          <tr><td><label for="">Email</label> </td><td><?=$order_info->email?></td></tr>
                                          <tr><td><label for="">Requirement</label> </td><td><?=$order_info->requirement?></td></tr>
                                          
                                          </tbody>
                                        </table>
                                           </div>
                                  
                                       
                                       
                                      </div>
                                   <!--  Tab 1 end -->
                                      <div class="tab-pane fade " id="tab2default">
                                      <div class="row">
                                           <h3>Uploaded Documents </h3> <br>
                                            <?php 
                        
                         $dirname = "upload/manuscript_development/custom/".$order_info->id;
                         $stru = base_url()."upload/manuscript_development/custom/".$order_info->id;
                          $handle = opendir($dirname);
                          while($file = readdir($handle)){
                              if($file !== '.' && $file !== '..'){ 
                             
                                 
                           $thumb = "";   
                          $extension =  end(explode('.', $file));
        switch ($extension) { 
        case 'jpeg' : {
            //Get small thumbnail of jpeg image here and store that in $data[$key]['preview']; 
             $thumb = "<img src='".$stru."/".$file."' style='width:75px;height:50px'>";
            break;
        }
        case 'jpg' : {
            //Get small thumbnail of jpeg image here and store that in $data[$key]['preview']; 
             $thumb = "<img src='".$stru."/".$file."' style='width:75px;height:50px'>";
            break;
        }
        case 'png' : {
            //Get small thumbnail of png image here and store that in $data[$key]['preview'];
            $thumb = "<img src='".$stru."/".$file."' style='width:75px;height:50px'>";
            break;
        }
        case 'pdf' : {
            //Get small thumbnail of pdf here and store that in $data[$key]['preview']; 
            $thumb = '<i class="fa fa-5x fa-file-pdf-o"></i>';
            break;
        }

         case 'txt' : {
            //Get small thumbnail of pdf here and store that in $data[$key]['preview']; 
            $thumb = '<i class="fa fa-5x fa-file-text-o"></i>';
            break;
        }

         case 'psd' : {
            //Get small thumbnail of pdf here and store that in $data[$key]['preview']; 
            $thumb = '<i class="fa fa-5x fa-file-image-o"></i>';
            break;
        }

        case 'doc' : {
            //Get small thumbnail of pdf here and store that in $data[$key]['preview']; 
            $thumb = '<i class="fa fa-5x fa-file-word-o"></i>';
            break;
        }
        case 'docx' : {
            //Get small thumbnail of pdf here and store that in $data[$key]['preview']; 
            $thumb = '<i class="fa fa-5x fa-file-word-o"></i>';
            break;
        }
        case 'xls' : {
            //Get small thumbnail of pdf here and store that in $data[$key]['preview']; 
            $thumb = '<i class="fa fa-5x fa-file-excel-o"></i>';
            break;
        }
        case 'xlsx' : {
            //Get small thumbnail of pdf here and store that in $data[$key]['preview']; 
            $thumb = '<i class="fa fa-5x fa-file-excel-o"></i>';
            break;
        }
        case 'ppt' : {
            //Get small thumbnail of pdf here and store that in $data[$key]['preview']; 
            $thumb = '<i class="fa fa-5x fa-file-powerpoint-o"></i>';
            break;
        }
        case 'pptx' : {
            //Get small thumbnail of pdf here and store that in $data[$key]['preview']; 
            $thumb = '<i class="fa fa-5x fa-file-powerpoint-o"></i>';
            break;
        }

        default:{
           $thumb = '<i class="fa fa-5x fa-file"></i>';
            break;
        }





      }
        ?>
         <div class="col-lg-4">
                <?=$thumb?>
                                  <div class="caption">
                                
                                <?=$file;?>
                                <p><a class="btn btn-success" href="<?=base_url()?>admin/download_file/<?=$order_info->id?>?file=<?=$file?>&order_for=custom" >Download</a> </p>
                            
                        </div> 
</div>
                           <?php    }
                          }
                          
                        ?>
                                             
                                      </div>

                                     
                                     
                                     
                                   
                                    
                                  
                                    </div>
                                    <!--  Tab 2 end -->
                         
                                       <button type="submit" class="btn btn-primary">Submit</button>
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
<div class="modal fade" id="modal-id">
    <div class="modal-dialog">
        <div class="modal-content"> <form action="<?=base_url()?>admin/add_news" method="POST" role="form">
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
