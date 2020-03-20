 <aside class="right-side">
                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <h1>
                        Contact Leads
                    </h1>
                    <ol class="breadcrumb">
                        <li><a href="<?=base_url()?>index.php/admin/dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
                        <li class="active"> <i class="fa fa-mobile"></i> Contact list</li>
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
                                     <h3 class="box-title">All Submmitted Contact details</h3>
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
                      <th  class="col-md-2" >Address</th>
                      <th  class="col-md-2" >Phone</th>  
                      <th  class="col-md-4" >Article</th>  
                      <th  class="col-md-1" >Actions</th>  
                  </tr>
              </thead>
              <tbody>
              <?php $i = 1; foreach ($reprint as $key): ?>
                   <tr>
                      <td><?=$i;?></td>
                      <td><?=$key->fullname;?></td>
                      <td><?=$key->email;?></td>
                      <td><?=$key->address1;?> <?=$key->address1;?></td>
                      <td><?=$key->phone;?></td>
                      <td><?=$key->title;?></td>
                     <td><a class="btn btn-primary" data-toggle="modal" href='#modal-id<?=$key->id;?>'>view</a>
                     <div class="modal fade" id="modal-id<?=$key->id;?>">
                       <div class="modal-dialog">
                         <div class="modal-content">
                           <div class="modal-header">
                             <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                             <h4 class="modal-title">Article Copy Request</h4>
                           </div>
                           <div class="modal-body" style="height:500px;overflow-y: scroll;">
                             <table class="table table-hover">
                               <tbody>
                                 <tr><td>Article Name</td><td><?=$key->title;?></td></tr>
                                 <tr><td>Requester Name</td><td><?=$key->fullname;?></td></tr>
                                 <tr><td>Requester Email</td><td><?=$key->email;?></td></tr>
                                 <tr><td>Orgnization</td><td><?=$key->orgnization;?></td></tr>
                                 <tr><td>Address Line 1</td><td><?=$key->address1;?></td></tr>
                                 <tr><td>Address Line 1</td><td><?=$key->address2;?></td></tr>
                                 <tr><td>City</td><td><?=$key->city;?></td></tr>
                                 <tr><td>State</td><td><?=$key->state;?></td></tr>
                                 <tr><td>Zipcode</td><td><?=$key->zipcode;?></td></tr>
                                 <tr><td>Phone</td><td><?=$key->phone;?></td></tr>
                                 <tr><td>fax</td><td><?=$key->fax;?></td></tr>
                                 <tr><td>No. of Prints</td><td><?=$key->no_prints;?></td></tr>
                                 <tr><td>Prints Used for</td><td><?=$key->used_for;?></td></tr>
                                 <tr><td>Payment Status</td><td><?=$key->payment_status;?></td></tr>
                                 <tr><td>Transaction Id</td><td><?=$key->transaction_id;?></td></tr>
                                 <tr><td>Paid Amount</td><td>$ <?=$key->payment;?> </td></tr>
                               </tbody>
                             </table>
                           </div>
                           <div class="modal-footer">
                             <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                           </div>
                         </div><!-- /.modal-content -->
                       </div><!-- /.modal-dialog -->
                     </div><!-- /.modal --></td>
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