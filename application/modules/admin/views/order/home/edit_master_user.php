<style>
.bootstrap-select:not([class*="col-"]):not([class*="form-control"]):not(.input-group-btn) {
    width: -webkit-fill-available;
}
.bootstrap-select.show-tick .dropdown-menu li a span.text {
    margin-left: 20px;
}
.bootstrap-select.show-tick .dropdown-menu .selected span.check-mark {
    right: initial;
    left: 15px;
    top: 10px;
}
</style>
<div class="pct-admin-listing">
    <!-- Page Header -->
    <div class="page-header">
        <h1><i class="fas fa-user-edit"></i> Master User</h1>
        <div class="action-buttons">
            <a href="<?php echo base_url() . 'order/admin/master-users'; ?>" class="btn-action btn-action-secondary">
                <i class="fas fa-arrow-left"></i> Back
            </a>
        </div>
    </div>

    <!-- Edit Master User Form Card -->
    <div class="modern-card">
        <div class="modern-card-header">
            <h2><i class="fas fa-user-edit"></i> Edit Master User</h2>
        </div>
        <div class="modern-card-body">
            <?php if (!empty($success_msg)) {?>
                <div class="alert-modern alert-success-modern"><?php echo $success_msg; ?></div>
            <?php }?>
            <?php if (!empty($error_msg)) {?>
                <div class="alert-modern alert-danger-modern"><?php echo $error_msg; ?></div>
            <?php }?>

            <form id="add-new-master-user" method="POST">
                <div class="form-group">
                    <label for="first_name" class="col-sm-2 col-form-label">First Name<span class="required"> *</span></label>
                    <div class="col-sm-6">
                        <input type="text" class="form-control" name="first_name" id="first_name" value="<?php echo set_value('first_name') ? set_value('first_name') : $master_user_info['first_name']; ?>" placeholder="First Name">
                        <?php if (!empty($first_name_error_msg)) {?>
                            <span class="error"><?php echo $first_name_error_msg; ?></span>
                        <?php }?>
                    </div>
                </div>

                <div class="form-group">
                    <label for="last_name" class="col-sm-2 col-form-label">Last Name<span class="required"> *</span></label>
                    <div class="col-sm-6">
                        <input type="text" class="form-control" name="last_name" id="last_name" value="<?php echo set_value('last_name') ? set_value('last_name') : $master_user_info['last_name']; ?>" placeholder="Last Name">
                        <?php if (!empty($last_name_error_msg)) {?>
                            <span class="error"><?php echo $last_name_error_msg; ?></span>
                        <?php }?>
                    </div>
                </div>

                <div class="form-group">
                    <label for="email_address" class="col-sm-2 col-form-label">Email Address<span class="required"> *</span></label>
                    <div class="col-sm-6">
                        <input type="email" value="<?php echo set_value('email_address') ? set_value('email_address') : $master_user_info['email_address']; ?>" class="form-control" name="email_address" id="email_address" placeholder="Email Address">
                        <?php if (!empty($email_address_error_msg)) {?>
                            <span class="error"><?php echo $email_address_error_msg; ?></span>
                        <?php }?>
                    </div>
                </div>

                <div class="form-group">
                    <label for="telephone_no" class="col-sm-2 col-form-label">Telephone</label>
                    <div class="col-sm-6">
                        <input type="text" value="<?php echo set_value('telephone_no') ? set_value('telephone_no') : $master_user_info['phone']; ?>" class="form-control" name="telephone_no" id="telephone_no" placeholder="Telephone">
                    </div>
                </div>

                <div class="form-group">
                    <label for="company" class="col-sm-2 col-form-label">Company<span class="required"> *</span></label>
                    <div class="col-sm-6">
                        <input type="text" class="form-control" name="company" id="company" value="<?php echo set_value('company') ? set_value('company') : $master_user_info['company_name']; ?>" placeholder="Company">
                        <?php if (!empty($company_error_msg)) {?>
                            <span class="error"><?php echo $company_error_msg; ?></span>
                        <?php }?>
                    </div>
                </div>

                <div class="form-group">
                    <label for="address" class="col-sm-2 col-form-label">Address<span class="required"> *</span></label>
                    <div class="col-sm-6">
                        <input type="text" class="form-control" name="address" id="address" value="<?php echo set_value('address') ? set_value('address') : $master_user_info['address1']; ?>" placeholder="Address">
                        <?php if (!empty($address_error_msg)) {?>
                            <span class="error"><?php echo $address_error_msg; ?></span>
                        <?php }?>
                    </div>
                </div>

                <div class="form-group">
                    <label for="city" class="col-sm-2 col-form-label">City<span class="required"> *</span></label>
                    <div class="col-sm-6">
                        <input type="text" class="form-control" name="city" id="city" value="<?php echo set_value('city') ? set_value('city') : $master_user_info['city']; ?>" placeholder="City">
                        <?php if (!empty($city_error_msg)) {?>
                            <span class="error"><?php echo $city_error_msg; ?></span>
                        <?php }?>
                    </div>
                </div>

                <div class="form-group">
                    <label for="state" class="col-sm-2 col-form-label">State<span class="required"> *</span></label>
                    <div class="col-sm-6">
                        <input type="text" class="form-control" name="state" id="state" value="<?php echo set_value('state') ? set_value('state') : $master_user_info['state']; ?>" placeholder="State">
                        <?php if (!empty($state_error_msg)) {?>
                            <span class="error"><?php echo $state_error_msg; ?></span>
                        <?php }?>
                    </div>
                </div>

                <div class="form-group">
                    <label for="zipcode" class="col-sm-2 col-form-label">Zipcode<span class="required"> *</span></label>
                    <div class="col-sm-6">
                        <input type="text" class="form-control" name="zipcode" id="zipcode" value="<?php echo set_value('zipcode') ? set_value('zipcode') : $master_user_info['zip'] ?>" placeholder="Zipcode">
                        <?php if (!empty($zipcode_error_msg)) {?>
                            <span class="error"><?php echo $zipcode_error_msg; ?></span>
                        <?php }?>
                    </div>
                </div>

                <div class="form-group">
                    <div class="col-sm-6">
                        <button type="submit" class="btn-action btn-action-primary">
                            <i class="fas fa-save"></i> Update
                        </button>
                        <a href="<?php echo base_url() . 'order/admin/master-users'; ?>" class="btn-action btn-action-secondary">
                            <i class="fas fa-arrow-left"></i> Cancel
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
