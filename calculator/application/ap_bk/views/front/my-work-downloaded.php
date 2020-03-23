
        <div class="container">
          <div class="content-wrapper">
            <section id="content">
             <?php include 'ext-menu.php';?>
              <ol class="breadcrumb">
                <li><a href="<?php echo base_url(); ?>">Home</a></li>
                <li class="active">Downloaded</li>
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
                        <h3 class="text-uppercase panel-title">downloaded</h3>
                        <hr>
                        <table class="table table-striped  margin-top20">
                          <thead>
                            <tr>
                              <th width="15%">Date</th>
                              <th width="49%">Title</th>
                              <th width="20%">Downloads</th>
                              <th width="16%">Receipts</th>
                            </tr>
                          </thead>
                          <tbody>
                             <?php foreach ($userarticles as $key): ?>
                        <tr>
                          <td>
                            <?=date("F Y",strtotime($key->rdate))?>
                          </td>
                          <td>
                            <a  href="javascript:;"> <b><?=$key->title?></b></a>
                            <p>Keyword : <?=$key->Keyword?></p>
                          </td>
                          <td>
                            <?=$key->community?>
                          </td>
                          <td>
                            <?=$key->worktype?>
                          </td>
                        </tr>
                      <?php endforeach ?>
                          </tbody>
                        </table>
                      </div>
                    </div>
                  </div>
                </div>
              </section>
          