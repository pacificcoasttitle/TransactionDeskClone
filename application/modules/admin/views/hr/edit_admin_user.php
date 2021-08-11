<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Edit Admin User</h4>
                    </div>
                    <div class="card-body">
                        <form method="post" name="admin_user_form" >
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="email">Email address<span class="required"> *</span></label>
                                        <input type="email" class="form-control" placeholder="Email" name="email" id="email" value="<?php echo $adminUserInfo['email_id'];?>" disabled="disabled" required="required">
                                    </div>
                                    <?php if(!empty($email_error_msg)){ ?>       
                                        <div class="typography-line text-danger">
                                            <?php echo $email_error_msg;?>
                                        </div>
                                    <?php } ?>
                                </div>
                            </div>
                            <?php $name = explode(" ", $adminUserInfo['user_name']);?>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="first_name">First Name<span class="required"> *</span></label>
                                        <input type="text" class="form-control" placeholder="First Name" name="first_name" id="first_name" value="<?php echo $name[0];?>" required="required">
                                    </div>
                                    <?php if(!empty($first_name_error_msg)){ ?>  
                                        <div class="typography-line text-danger">
                                           <?php echo $first_name_error_msg;?>
                                        </div>
                                    <?php } ?>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Last Name<span class="required"> *</span></label>
                                        <input type="text" class="form-control" placeholder="Last Name" name="last_name" id="last_name" value="<?php echo $name[1];?>" required="required">
                                    </div>
                                    <?php if(!empty($last_name_error_msg)){ ?>  
                                        <div class="typography-line text-danger">
                                            <?php echo $last_name_error_msg;?>
                                        </div>
                                    <?php } ?>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Password<span class="required"> *</span></label>
                                        <input type="password" class="form-control" placeholder="Password" name="password" id="password" value="" required="required">
                                    </div>
                                    <?php if(!empty($password_error_msg)){ ?>  
                                        <div class="typography-line text-danger">
                                            <?php echo $password_error_msg;?>
                                        </div>
                                    <?php } ?>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-info btn-fill pull-left">Save</button>
                            <a style="margin-left:10px;" href="<?php echo base_url().'hr/admin/admin-users'; ?>" id="cancel" name="cancel" class="btn btn-info btn-fill pull-left">Cancel</a>
                            <div class="clearfix"></div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>