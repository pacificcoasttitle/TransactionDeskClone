
        <body>
          <div class="container">
            <div class="content-wrapper">
              <section id="content">
                <?php include 'ext-menu.php';?>
                <ol class="breadcrumb">
                  <li><a href="<?php echo base_url(); ?>">Home</a></li>
                  <li class="active">Edit Profile</li>
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
                    <div class="col-md-9 pro-content  ">
                      <div class="panel panel-default flat">
                        <div class="panel-body" id="" >
                          <h3 class="text-uppercase panel-title">Edit Profile</h3>
                          <hr>
                          <form class="" action="" method="POST" role="form" enctype="multipart/form-data">
                            <div class="form-group">
                              <label for="inputEmail3" class="control-label">Salutation</label>
                              <select name="salutation" id="inputSalutation" class="form-control"   data-placement="right" title="Status of Publication">
                                <option value="">-- Select One --</option>
                                <option <?=($user_info->salutation == "Dr.")?"selected='true'":NULL?>>Dr.</option> 
                                <option <?=($user_info->salutation == "Prof.")?"selected='true'":NULL?>>Prof.</option>
                                <option <?=($user_info->salutation == "Mr.")?"selected='true'":NULL?>>Mr.</option>
                                <option <?=($user_info->salutation == "Ms.")?"selected='true'":NULL?>>Ms.</option>
                              </select>
                            </div>
                            <div class="form-group">
                              <label for="inputEmail3" class="control-label">First Name</label>
                              <input type="text" class="form-control"  required id="inputPassword3" pattern="^[ a-zA-Z]+$" placeholder="First Name" value="<?=$user_info->fname?>" name="fname"  data-placement="right" title="First Name">
                            </div>
                            <div class="form-group">
                              <label for="inputEmail3" class="control-label">Last Name</label>
                              <input type="text" required class="form-control" id="inputPassword3" pattern="^[ a-zA-Z]+$" placeholder="Last Name"  data-placement="right" title="Last Name"value="<?=$user_info->lname?>" name="lname">
                            </div>
                            <div class="form-group">
                              <label for="inputEmail3" class="control-label">Designation</label>
                              <input type="text" required class="form-control" id="inputPassword3"  placeholder="Designation"  data-placement="right" title="Designation"value="<?=$user_info->designation?>" name="designation">
                            </div>
                            <div class="form-group">
                              <label for="inputEmail3" class="control-label">Hospital/University associated</label>
                              <input type="text" required class="form-control" id="inputPassword3" placeholder="Hospital/University associated"  data-placement="right" title="Hospital/University associated"value="<?=$user_info->current_position?>" name="current_position">
                            </div>
                            <div class="form-group">
                              <label for="inputEmail3" class="control-label">Curriculum vitae</label>
                              <textarea required id="input" class="form-control" rows="3" required  data-placement="right" title="Curriculum vitae" name="profile_desc"><?=$user_info->profile_desc?></textarea>
                            </div>
                            <div class="form-group">
                              <label for="inputEmail3" class="control-label">Phone</label>
                              <input required type="text" pattern="^[0-9]+$" maxlength="10" class="form-control" id="inputPassword3" placeholder="Phone"  data-placement="right" title="Phone" value="<?=$user_info->phone?>" name="phone">
                            </div>
                            <div class="form-group">
                              <label for="inputEmail3" class="control-label">Research Interest</label>
                              <input required type="text" maxlength="10" class="form-control" id="inputPassword3" placeholder="Research Interest"  data-placement="right" title="Research Interest" value="<?=$user_info->research_interest?>" name="research_interest">
                            </div>

                            <div class="form-group">
                              <label for="inputEmail3" class="control-label">Email ID</label>
                              <input type="email" pattern="^[ 0-9]+$" maxlength="10" class="form-control" id="inputPassword3" placeholder="Email ID"  data-placement="right" title="Email ID" value="<?=$user_info->email?>" name="email" readonly>
                            </div>
                             <div class="form-group">
                               <div class="col-xs-12 col-sm-9 col-md-9 col-lg-9">
                                  <label for="inputEmail3" class="control-label">Update Your Photo :</label>
                               </div>
                              
                            </div>
                             <div class="form-group">
                              <div class="col-xs-12 col-sm-9 col-md-9 col-lg-9">
                                  <input id="file" type="file" name="userfile2" >
                                 
                               </div>
                                <div class="col-xs-12 col-sm-3 col-md-3 col-lg-3">
                                 
                                 
                                    <img class="img-responsive" style = "border:1px solid #ccc" src="<?=base_url()?>upload/user/<?=$user_info->userid?>/<?=$user_info->profilepic?>" onerror=" this.src = '<?=base_url()?>assets/front/images/doctor.png'" class="imgResponsive pull-right">
                                    <div class="clr"></div>
                                 
                               </div>
                             </div>
                            <div class="form-group">
                              <div class="">
                                <button type="submit" class="btn btn-primary">Save</button>
                              </div>
                            </div>
                          </form>
                        </div>
                      </div>
                    </div>
                  </div>
                </section>
               