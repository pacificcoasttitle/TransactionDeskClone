
        <div class="container">
          <div class="content-wrapper">
            <section id="content">
              <?php include 'ext-menu.php';?>
              <ol class="breadcrumb">
                <li><a href="<?php echo base_url(); ?>">Home</a></li>
                <li class="active">Bank Details</li>
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
                        <h3 class="text-uppercase panel-title">BANK DETAILS</h3>
                        <hr>
                        <form class="" action="" method="POST" role="form" enctype="">
                          <div class="form-group">
                            <label for="inputEmail3" class="control-label">Name of Beneficiary</label>
                            <input type="text" class="form-control" pattern="^[ a-zA-Z]+$" id="inputPassword3" placeholder="Name of Beneficiary" data-toggle="tooltip" data-placement="right" title="Name of Beneficiary" value="<?=$user_info->benificiary_name?>" name="benificiary_name">
                          </div>
                          <div class="form-group">
                            <label for="inputEmail3" class="control-label">Account No.</label>
                            <input type="text" class="form-control" id="inputPassword3" pattern="^[ a-zA-Z0-9]+$" placeholder="Account No." data-toggle="tooltip" data-placement="right" title="Account No." value="<?=$user_info->account_no?>" name="account_no">
                          </div>
                          <div class="form-group">
                            <label for="inputEmail3" class="control-label">Name &amp; Address of Bank</label>
                            <textarea  id="input" class="form-control" rows="3" required data-toggle="tooltip" data-placement="right" pattern="^[ a-zA-Z0-9]+$" title="Name &amp; Address of Bank" name="bank_name_address"><?=$user_info->bank_name_address?></textarea>
                          </div>
                          <div class="form-group">
                            <label for="inputEmail3" class="control-label">IFSC Code</label>
                            <input type="text" class="form-control" id="inputPassword3" placeholder="IFSC Code" pattern="^[ a-zA-Z0-9]+$" data-toggle="tooltip" data-placement="right" title="IFSC Code" value="<?=$user_info->ifsc?>" name="ifsc">
                          </div>
                          <div class="form-group">
                            <div class="">
                              <button type="submit" class="btn btn-primary">Save</button>
                            </div>
                          </div>
                        </form>
                        <p>Why are we asking for your Bank Details??</p>
                        <p>WE USE YOUR BANK DETAILS TO TRANSFER PAYMENTS FOR YOUR DOWNLOADS DIRECTLY INTO YOUR ACCOUNT.</p>
                        <p><strong>NOTE:</strong>AS POLICY, WE DO NOT SHARE YOUR PERSONAL AND/OR CONFIDENTIAL INFORMATION WITH ANY UNAUTHORIZED INDIVIDUAL OR IN ANY PUBLIC DOMAIN SUCH AS BLOGS, FORUMS, SOCIAL NETWORK SITES AND OTHER MEDIA. MYREPOSIT DOES IT REQUEST CONFIDENTIAL INFORMATION SUCH AS INTERNET BANKING PASSWORD, PINS (ATM, DEBIT CARD, CREDIT CARD, PHONE BANKING) OR CREDIT CARD CVV NUMBERS ETC. IN CASE OF ANY SUSPICION, PLEASE CONTACT THE BANK IMMEDIATELY.</p>
                      </div>
                    </div>
                  </div>
                </div>
              </section>
            