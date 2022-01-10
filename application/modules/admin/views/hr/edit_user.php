<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Edit User</h4>
                    </div>
                    <div class="card-body">
                        <form method="post" name="user_form" >
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="email">Email address<span class="required"> *</span></label>
                                        <input type="email" value="<?php echo $userInfo['email'];?>" class="form-control" placeholder="Email" name="email" id="email" required="required" disabled>
                                    </div>
                                    <?php if(!empty($email_error_msg)){ ?>       
                                        <div class="typography-line text-danger">
                                            <?php echo $email_error_msg;?>
                                        </div>
                                    <?php } ?>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="first_name">First Name<span class="required"> *</span></label>
                                        <input type="text" value="<?php echo $userInfo['first_name'];?>" class="form-control" placeholder="First Name" name="first_name" id="first_name" value="" required="required">
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
                                        <input type="text" value="<?php echo $userInfo['last_name'];?>" class="form-control" placeholder="Last Name" name="last_name" id="last_name" value="" required="required">
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
                                        <label>Position<span class="required"> *</span></label>
                                        <select name="position" id="position" class="form-control" required>
                                            <option value="">Select Position</option>
                                            <?php foreach($hrPositions as $hrPosition) {?>
                                                <option value="<?php echo $hrPosition['id'];?>" <?php echo $userInfo['position_id'] == $hrPosition['id'] ? 'selected' : '';?>><?php echo $hrPosition['name'];?></option>
                                            <?php } ?>
                                        </select> 
                                    </div>
                                    <?php if(!empty($position_error_msg)){ ?>  
                                        <div class="typography-line text-danger">
                                            <?php echo $position_error_msg;?>
                                        </div>
                                    <?php } ?>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Hire Date<span class="required"> *</span></label>
                                        <input type="text" class="form-control" value="<?php echo date("m/d/Y", strtotime($userInfo['hire_date']));?>" placeholder="Hire Date" name="hire_date" id="hire_date" value="" required="required">
                                    </div>
                                    <input type="hidden" id="hire_date_val" name="hire_date_val" value="<?php echo date("m/d/Y", strtotime($userInfo['hire_date']));?>">
                                    <?php if(!empty($hire_date_error_msg)){ ?>  
                                        <div class="typography-line text-danger">
                                            <?php echo $hire_date_error_msg;?>
                                        </div>
                                    <?php } ?>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label style="width:100%;">User Type<span class="required"> *</span></label>
                                        <?php foreach($userTypes as $userType) {?>
                                            <input style="width:15px;height:15px;" <?php echo $userInfo['user_type_id'] == $userType['id'] ? 'checked' : '';?> class="" type="radio" name="user_type" value="<?php echo $userType['id'];?>" required>&nbsp;<?php echo $userType['name'];?>&nbsp;
                                        <?php } ?>
                                    </div>
                                    <?php if(!empty($hire_date_error_msg)){ ?>  
                                        <div class="typography-line text-danger">
                                            <?php echo $hire_date_error_msg;?>
                                        </div>
                                    <?php } ?>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-info btn-fill pull-left">Update</button>
                            <a style="margin-left:10px;" href="<?php echo base_url().'hr/admin/users'; ?>" id="cancel" name="cancel" class="btn btn-info btn-fill pull-left">Cancel</a>
                            <div class="clearfix"></div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>



