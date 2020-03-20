
        <div class="container">
          <div class="content-wrapper">
            <section id="content">
             <?php include "ext-menu";?>
               
              <ol class="breadcrumb">
                <li><a href="<?php echo base_url(); ?>">Home</a></li>
                <li class="active">Support</li>
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
                        <h3 class="text-uppercase panel-title">Support Center</h3>
                        <hr>
                        <a onclick="suport_togle()" class="btn btn-info" type="button">New Ticket</a>
                        <div class="btn-group pull-right">
            <a type="button" class="btn <?=($find_array['status'] == '')?'btn-primary':'btn-bordered'?>" onclick="filter_support('')">Total <span class="badge"><?=$count_total?></span></a>
            <a type="button" class="btn <?=($find_array['status'] == '1')?'btn-primary':'btn-bordered'?>" onclick="filter_support(1)">Open <span class="badge"><?=$count_open?></span></a>
            <a type="button" class="btn <?=($find_array['status'] == '2')?'btn-primary':'btn-bordered'?>" onclick="filter_support(2)">Resolved <span class="badge"><?=$count_resolved?></span></a>
            <a type="button" class="btn <?=($find_array['status'] == '3')?'btn-primary':'btn-bordered'?>" onclick="filter_support(3)">Closed <span class="badge"><?=$count_closed?></span></a>
          </div>
          <form id="support_filter" action="" method="POST" role="form">
            <input type="hidden" class="form-control" id="status" name = "status" value="" >
          </form>
                        <hr>
                        
                        <div class="well well-lg" id="support_form" style="display:none">
                         <form action="<?=base_url()?>index.php/welcome/generate_ticket" method="post">
                            <div class="form-group">
                              <div class="row">
                                <div class="col-sm-6">
                                  <input type="text" class="form-control"id="ticketSubject" name="subject" placeholder="Write ticket subject" required>
                                </div>
                                <div class="col-sm-6">
                                  <select class="form-control"name = "ticket_topic" required="">
                                    <option selected="selected" value="">— Select a Help Topic —</option>
                                    <option value="2">Feedback</option>
                                    <option value="1">General Inquiry</option>
                                    <option value="10">Report a Problem</option>
                                    <option value="11">Report a Problem / Access Issue</option>
                                </select>
                                </div>
                              </div>
                            </div>
                            <div class="form-group">
                              <textarea name = "body" id="input" class="form-control" rows="3" placeholder="Write your question here !!" required></textarea>
                            </div>
                            <div class="form-group">
                              <button type="submit" onclick="" class="btn btn-primary" id="">Create Ticket</button>
                              <button type="button" onclick="" class="btn btn-primary" id="">Cancel</button>
                            </div>
                          </form>
                        </div>
                        <br>
                        <?php if (sizeof($support_ticket)): ?>
          <!-- start article list -->
            <table class="table table-striped  margin-top20">
                <thead>
                    <tr>
                        <th width="15%">Ticket #</th>
                        <th width="25%">Create date</th>
                        <th width="39%">Subject</th>
                        <th width="16%">Status</th>
                    </tr>
                </thead>
                <?php foreach ($support_ticket as $key): ?>
                   <tr>
                        <td><p class="main-article-text"><a href="<?=base_url()?>view-ticket-thread/<?=$key->number?>"><?=$key->number?></p></td>
                        <td><p class="main-article-text1"><?=date("j F Y",strtotime($key->created))?></p></td>
                        <td><p class="main-article-text1"><?=$key->subject?></p></td>
                
                        <td><?=$key->name?></td>
                    </tr>
                <?php endforeach ?>
                   
                   
                </table>
          <!-- end article list -->
          <!-- start pegination -->
            <div class="pageButton">
                            <ul>
                                <?=$page_links?>
                            </ul>
                        </div>
          <!-- end pegination -->
          <?php else: ?>
            <br>
            <div class="alert alert-danger">
              <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
              <span> Tickets(s) Not found. !! Create Ticket Now.</span>
            </div>
            
          
            <?php endif ?>
                      </div>
                    </div>
                  </div>
                </div>
              </section>
