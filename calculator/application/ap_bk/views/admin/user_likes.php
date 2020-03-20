 <aside class="right-side">
                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <h1>
                        Users Likes List
                    </h1>
                    <ol class="breadcrumb">
                        <li><a href="<?=base_url()?>index.php/admin/dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
                        <li class="active"><i class="fa fa-users"></i> Users Likes List</li>
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
                                     <h3 class="box-title">Article Title : <?=$article_detail->title?></h3>
                                </div>
                                
                                     
                                    
                                </div>
                                   
                                    
                                </div><!-- /.box-header -->
                                <div class="box-body table-responsive">
          <table  width = "100%" class="table table-striped table-bordered table-hover" id="example1">
              <thead>
                  <tr>
                      <th class="col-md-1">Sr. no.</th>
                      <th  class="col-md-2" >Name</th>
                      <th  class="col-md-2" >Email Id</th>  
                  </tr>
              </thead>
              <tbody>
              <?php $i = 1; foreach ($users_list as $key): ?>
                   <tr>
                      <td><?=$i;?></td>
                      <td><?=$key->fname;?> <?=$key->lname;?> </td>
                      <td><?=$key->email;?></td>
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
 <script src="http://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
        <!-- page script -->
        <script type="text/javascript">
            $(function() {
                $("#example1").dataTable();
             

            });
        </script>