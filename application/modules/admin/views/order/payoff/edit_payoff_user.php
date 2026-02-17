<div class="pct-admin-listing">
    <!-- Page Header -->
    <div class="page-header">
        <h1><i class="fas fa-user-edit"></i> <?=$pageTitle?></h1>
        <div class="action-buttons">
            <a href="<?php echo site_url('order/admin/payoff-users'); ?>" class="btn-action btn-action-secondary">
                <i class="fas fa-arrow-left"></i> Back
            </a>
        </div>
    </div>

    <!-- Edit Payoff User Form Card -->
    <div class="modern-card">
        <div class="modern-card-header">
            <h2><i class="fas fa-user-edit"></i> Edit <?=$pageTitle?></h2>
        </div>
        <div class="modern-card-body">
            <?php if (!empty($success_msg)) {?>
                <div class="alert-modern alert-success-modern"><?php echo $success_msg; ?></div>
            <?php }?>
            <?php if (!empty($error_msg)) {?>
                <div class="alert-modern alert-danger-modern"><?php echo $error_msg; ?></div>
            <?php }?>

            <form id="frm-add-title-officer-rep" method="POST">

                <div class="form-group">
                    <label for="title_officer_name" class="col-sm-2 col-form-label">First Name<span class="required"> *</span></label>
                    <div class="col-sm-6">
                        <input type="text" class="form-control" name="first_name" id="first_name" value="<?php echo $payoff_user_info['first_name']; ?>" placeholder="First Name">
                        <?php if (!empty($first_name_error_msg)) {?>
                            <span class="error"><?php echo $first_name_error_msg; ?></span>
                        <?php }?>
                    </div>
                </div>

                <div class="form-group">
                    <label for="title_officer_name" class="col-sm-2 col-form-label">Last Name<span class="required"> *</span></label>
                    <div class="col-sm-6">
                        <input type="text" class="form-control" name="last_name" id="last_name" value="<?php echo $payoff_user_info['last_name']; ?>" placeholder="Last Name">
                        <?php if (!empty($last_name_error_msg)) {?>
                            <span class="error"><?php echo $last_name_error_msg; ?></span>
                        <?php }?>
                    </div>
                </div>

                <div class="form-group">
                    <label for="email_address" class="col-sm-2 col-form-label">Email Address<span class="required"> *</span></label>
                    <div class="col-sm-6">
                        <input type="text" class="form-control" name="email_address" id="email_address" placeholder="Email Address" value="<?php echo isset($payoff_user_info['email_address']) && !empty($payoff_user_info['email_address']) ? $payoff_user_info['email_address'] : '' ?>">
                        <?php if (!empty($email_error_msg)) {?>
                            <span class="error"><?php echo $email_error_msg; ?></span>
                        <?php }?>
                    </div>
                </div>

                <div class="form-group">
                    <label for="company_name" class="col-sm-2 col-form-label">Company Name<span class="required"> *</span></label>
                    <div class="col-sm-6">
                        <input type="text" class="form-control" name="company_name" id="company_name" placeholder="Company Name" value="<?php echo isset($payoff_user_info['company_name']) && !empty($payoff_user_info['company_name']) ? $payoff_user_info['company_name'] : '' ?>">
                        <?php if (!empty($company_name_error_msg)) {?>
                            <span class="error"><?php echo $company_name_error_msg; ?></span>
                        <?php }?>
                    </div>
                </div>

                <div class="form-group">
                    <label for="street_address" class="col-sm-2 col-form-label">Address</label>
                    <div class="col-sm-6">
                        <input type="text" class="form-control" name="street_address" id="street_address" placeholder="Address" value="<?php echo isset($payoff_user_info['address1']) && !empty($payoff_user_info['address1']) ? $payoff_user_info['address1'] : '' ?>">
                        <?php if (!empty($street_address_error_msg)) {?>
                            <span class="error"><?php echo $street_address_error_msg; ?></span>
                        <?php }?>
                    </div>
                </div>

                <div class="form-group">
                    <label for="city" class="col-sm-2 col-form-label">City</label>
                    <div class="col-sm-6">
                        <input type="text" class="form-control" name="city" id="city" placeholder="City" value="<?php echo isset($payoff_user_info['city']) && !empty($payoff_user_info['city']) ? $payoff_user_info['city'] : '' ?>">
                        <?php if (!empty($city_error_msg)) {?>
                            <span class="error"><?php echo $city_error_msg; ?></span>
                        <?php }?>
                    </div>
                </div>

                <div class="form-group">
                    <label for="state" class="col-sm-2 col-form-label">State</label>
                    <div class="col-sm-6">
                        <input type="text" class="form-control" name="state" id="state" placeholder="State" value="<?php echo isset($payoff_user_info['state']) && !empty($payoff_user_info['state']) ? $payoff_user_info['state'] : '' ?>">
                        <?php if (!empty($state_error_msg)) {?>
                            <span class="error"><?php echo $state_error_msg; ?></span>
                        <?php }?>
                    </div>
                </div>

                <div class="form-group">
                    <label for="zip" class="col-sm-2 col-form-label">Zip Code</label>
                    <div class="col-sm-6">
                        <input type="number" class="form-control" name="zip" id="zip" placeholder="Zip Code" value="<?php echo isset($payoff_user_info['zip']) && !empty($payoff_user_info['zip']) ? $payoff_user_info['zip'] : '' ?>">
                        <?php if (!empty($zip_error_msg)) {?>
                            <span class="error"><?php echo $zip_error_msg; ?></span>
                        <?php }?>
                    </div>
                </div>

                <div class="form-group">
                    <div class="col-sm-6">
                        <button type="submit" id="edit-title-officer" name="update-payoff-users" class="btn-action btn-action-primary">
                            <i class="fas fa-save"></i> Update
                        </button>
                        <!-- <button type="submit" class="btn btn-secondary">Update</button> -->
                        <a href="<?php echo site_url('order/admin/payoff-users'); ?>" class="btn-action btn-action-secondary">
                            <i class="fas fa-arrow-left"></i> Cancel
                        </a>
                    </div>
                    <!-- <a href="<?php echo base_url() . 'order/admin/agents'; ?>" id="cancel" name="cancel" class="btn btn-secondary">Cancel</a> -->
                </div>
            </form>
        </div>
    </div>
</div>