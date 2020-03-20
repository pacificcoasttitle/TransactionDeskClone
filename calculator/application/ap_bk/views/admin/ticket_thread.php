            <!-- Right side column. Contains the navbar and content of the page -->
            <aside class="right-side">
                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <h1>
                        Support ticket
                    </h1>
                    <ol class="breadcrumb">
                        <li><a href="<?=base_url()?>admin/dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
                        <li><a href="<?=base_url()?>admin/support_tickets">Thread detail</a></li>
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
                                     <h3 class="box-title">View Threads Details</h3> 
                                </div>
                               
                                     
                                    
                                </div>
                                   
                                    
                                </div><!-- /.box-header -->
                                <div class="box-body">
                                  <div class="row">
                                    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                                       <table class="table table-hover">
                                        <thead>
                                          <tr>
                                            <th colspan="4">Ticket #<?=$ticket_detail->number?> (<?=date("F j, Y, g:i a",strtotime($ticket_detail->created))?>) </th>
                                          </tr>
                                        </thead>
                                        <tbody>
                                          <tr>
                                            <td class="col-lg-1">Status</td> <td class="col-lg-3"><?=$ticket_detail->name?></td>
                                            <td class="col-lg-1">User</td> <td class="col-lg-3"><?=$ticket_detail->fname?></td>
                                           
                                            
                                           
                                          </tr>
                                          <tr>
                                            <td class="col-lg-1">User Email</td> <td class="col-lg-3"><?=$ticket_detail->email?></td>
                                            <td class="col-lg-1">Help Topic</td> <td class="col-lg-3"><?=$ticket_detail->topic?></td>
                                            
                                          </tr>
                                           <tr>
                                            <td class="col-lg-1">Last Message</td> <td class="col-lg-3"><?=date("F j, Y, g:i a",strtotime($ticket_detail->lastmessage))?></td>
                                            <td class="col-lg-1">Last Response</td> <td class="col-lg-3"><?=date("F j, Y, g:i a",strtotime($ticket_detail->lastresponse))?></td>
                                            
                                          </tr>
                                        </tbody>
                                         </table>
                                    </div>
                                  </div>
                                
                                   <legend><?=$ticket_detail->subject?>(<?=sizeof($thread_detail)?>) </legend>
                                    <!-- start article list -->
                                     <div class="panel-group" id="accordion">
                                               
                                        <?php $i = 1; foreach ($thread_detail as $key): ?>
                                           <div class="panel <?php if($key->user_id == 0){echo 'panel-default';}else{echo 'panel-success';}?>">
                                                    <div class="panel-heading">
                                                        <a data-toggle="collapse" data-parent="#accordion" href="#collapse<?=$key->id?>"><h4 class="panel-title"><?=date("F j, Y, g:i a",strtotime($key->created));?> <span class="text-danger pull-right">By <?=$key->poster?></span></h4></a>
                                                    </div>
                                                    <div id="collapse<?=$key->id?>" class="panel-collapse collapsed <?php if($i == sizeof($thread_detail)){echo 'in';}else{echo 'collapse';}?>">
                                                        <div class="panel-body">
                                                            <p><?=$key->body;?></p>
                                                        </div>
                                                    </div>
                                                </div>
                                        <?php $i++ ; endforeach ?>
                                           
                                        </div>   
                                      <hr>
                                      <div class="row">
                                        <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                                           <a type="button" class="btn btn-info" onclick="suport_togle()"><i class="fa fa-mail-reply"></i> Reply</a>   
                                        </div>
                                        <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                                           <a type="button" class="btn btn-info pull-right" href="<?=base_url()?>index.php/admin/support_tickets" ><i class="fa fa-arrow-left"></i> Back</a>  
                                        </div>
                                      </div>
                                     
                                  <!-- end article list -->
                                  <div class="row">
                                    <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 col-md-offset-3">
                                      <div id = "support_form" class="well well-sm" style="display:none">
                                    <form action="<?=base_url()?>index.php/admin/reply_ticket" method="post">
                                      <div class="row">
                                      <div class="col-sm-12 form-group" >
                                        
                                          <textarea rows = "5" cols = "60" name = "body" required="" placeholder="Write your Reply here !!"  id="supportTicketMsg" class = "form-control" class="form-input"></textarea>
                                         </div> 

                                        </div>
                                      <div class="col-sm-6 form-group">
                                         <select name="status_id" class="form-control">
                                           <option <?=($ticket_detail->status_id == 1)?'selected="true"':NULL?> value="1">Open<?=($ticket_detail->status_id == 1)?'(current)':NULL?></option>
                                           <option <?=($ticket_detail->status_id == 2)?'selected="true"':NULL?> value="2">Resolved<?=($ticket_detail->status_id == 2)?'(current)':NULL?></option>
                                           <option <?=($ticket_detail->status_id == 3)?'selected="true"':NULL?> value="3">Closed<?=($ticket_detail->status_id == 3)?'(current)':NULL?></option>
                                         </select>
                                        </div>
                                      <input type="hidden" name="ticket_id" id="inputTicket_id" class="form-control" value="<?=$ticket_detail->ticket_id;?>">
                                      <input type="hidden" name="number" id="inputTicket_id" class="form-control" value="<?=$ticket_detail->number;?>">
                                      <div class="row">
                                      <div class="col-sm-6 form-group">
                                        
                                          <button id="supportFormButton" class="btn btn-info" type="submit">Reply Ticket</button>
                                          <button id="supportFormButton" class="btn btn-success" onclick="suport_togle()" type="button">Cancle</button>
                                        
                                      </div>
                                      </div>
                                    </form>
                                    
                                  </div>
                              
                                    </div>
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
               
            });
        </script>




<script>
$(document).ready(function(){
  $("html, body").animate({ scrollTop: $(document).height() }, 800);
});
  
  function suport_togle (argument) 
  {
    $("#support_form").slideToggle();
    $("html, body").animate({ scrollTop: $(document).height() }, 600);
  }
</script>

    </body>
</html>
