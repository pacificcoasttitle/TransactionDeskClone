
        <div class="container">
          <div class="content-wrapper">
            <section id="content">
             <?php include "ext-menu";?>
               
              <ol class="breadcrumb">
                <li><a href="<?php echo base_url(); ?>">Home</a></li>
                <li><a href="<?php echo base_url(); ?>support">Support</a></li>
                <li class="active">Ticket #<?=$ticket_detail->number;?></li>
              </ol>
              <div class="clearfix"></div>
              <div class="clearfix"></div>
              <div class="row">
                <div class="col-md-3 pro-nav">
                  <div class="panel panel-default flat">
                    <div class="my-account-sidebar">
                      <div class="affix-sidebar">
                        <!-- start main side bar tab -->
                        <div class="sidebar-nav">
                          <div class="navbar" role="navigation">
                            <div class="navbar-header">
                              <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target=".sidebar-navbar-collapse"><span class="sr-only">Toggle navigation</span><span class="icon-bar"></span><span class="icon-bar"></span><span class="icon-bar"></span></button>
                              <span class="visible-xs navbar-brand">Sidebar menu</span></div>
                             <?php include 'dashboard-menu.php';?>
                              <!--/.nav-collapse -->
                            </div>
                          </div>
                        </div>
                        <!-- end main side bar tab -->
                        <div class="clr"></div>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-9 pro-content">
                    <div class="panel panel-default flat">
                      <div class="panel-body" id="" >
                        <h3 class="text-uppercase panel-title">Ticket #<?=$ticket_detail->number;?></h3>
                        <hr>
                       <p>Ticket Status: <?=$ticket_detail->name;?></p>
                        
                       
                        <?php if (sizeof($thread_detail)): ?>
          <!-- start article list -->
             <div class="panel-group" id="accordion">
                       
                <?php $i = 1; foreach ($thread_detail as $key): ?>
                   <div class="panel <?php if($key->user_id == 0){echo 'panel-success';}else{echo 'panel-default';}?>">
                            <div class="panel-heading">
                                <a data-toggle="collapse" data-parent="#accordion" href="#collapse<?=$key->id?>"><h4 class="panel-title"><?=date("F j, Y, g:i a",strtotime($key->created));?></h4></a>
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
              <a type="button" class="btn btn-info" onclick="suport_togle()">Reply</a>   
          <!-- end article list -->
              <div id = "support_form" class="well well-lg" style="display:none">
            <form action="<?=base_url()?>index.php/welcome/reply_ticket" method="post">
              <div class="row">
              <div class="col-sm-12 form-group" >
                
                  <textarea name = "body" required="" placeholder="Write your Reply here !!"  id="supportTicketMsg" class = "form-control" class="form-input"></textarea>
                
                </div>
              </div>
              <input type="hidden" name="ticket_id" id="inputTicket_id" class="form-control" value="<?=$ticket_detail->ticket_id;?>">
              <input type="hidden" name="number" id="inputTicket_id" class="form-control" value="<?=$ticket_detail->number;?>">
              <div class="row">
              <div class="col-sm-12 form-group">
                
                  <button id="supportFormButton" class="btn btn-primary" type="submit">Create Ticket</button>
                  <button id="supportFormButton" class="btn btn-success" onclick="suport_togle()" type="button">Cancle</button>
                
              </div>
              </div>
            </form>
            
          </div>
          <?php else: ?>
            
            
          
            <?php endif ?>
                       
                      
                       
                   
                   
               
                      </div>
                    </div>
                  </div>
                </div>
              </section>
<script>
  
  function suport_togle (argument) 
  {
    $("#support_form").slideToggle();
  }

  function filter_support (st_id) 
  {
    $("#status").val(st_id);
    $("#support_filter").submit();
  }
</script>