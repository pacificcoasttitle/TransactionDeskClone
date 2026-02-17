<style>
.ui-menu .ui-menu-item-wrapper {
    font-size : 13px;
}

.ui-autocomplete {
    max-height: 300px !important;
}
</style>
<div class="pct-admin-listing">
    <!-- Page Header -->
    <div class="page-header">
        <h1><i class="fas fa-building"></i> Add Company</h1>
        <div class="action-buttons">
            <a href="<?php echo base_url() . 'order/admin/softpro-companies'; ?>" class="btn-action btn-action-secondary">
                <i class="fas fa-arrow-left"></i> Back
            </a>
        </div>
    </div>

    <!-- Add Company Form Card -->
    <div class="modern-card">
        <div class="modern-card-header">
            <h2><i class="fas fa-building"></i> Add Company</h2>
        </div>
        <div class="modern-card-body">
            <?php if (!empty($success_msg)) {?>
                <div class="alert-modern alert-success-modern"><?php echo $success_msg; ?></div>
            <?php }?>
            <?php if (!empty($error_msg)) {?>
                <div class="alert-modern alert-danger-modern"><?php echo $error_msg; ?></div>
            <?php }?>

            <form id="add-company" method="POST">
                <div class="form-group">
                    <label for="name" class="col-sm-2 col-form-label">Name<span class="required"> *</span></label>
                    <div class="col-sm-6">
                        <input type="text" class="form-control" name="name" id="name" value="<?php echo set_value('name'); ?>" placeholder="Name">
                        <?php if (!empty($name_error_msg)) {?>
                            <span class="error"><?php echo $name_error_msg; ?></span>
                        <?php }?>
                    </div>
                </div>

                <div class="form-group">
                    <label for="email_address" class="col-sm-2 col-form-label">Email Address</label>
                    <div class="col-sm-6">
                        <input type="email" value="<?php echo set_value('email_address'); ?>" class="form-control" name="email_address" id="email_address" placeholder="Email Address">
                        <?php if (!empty($email_address_error_msg)) {?>
                            <span class="error"><?php echo $email_address_error_msg; ?></span>
                        <?php }?>
                    </div>
                </div>

                <div class="form-group">
                    <label for="phone" class="col-sm-2 col-form-label">Telephone</label>
                    <div class="col-sm-6">
                        <input type="text" value="<?php echo set_value('phone'); ?>" class="form-control" name="phone" id="phone" placeholder="Telephone">
                        <?php if (!empty($phone_error_msg)) {?>
                            <span class="error"><?php echo $phone_error_msg; ?></span>
                        <?php }?>
                    </div>
                </div>

                <div class="form-group">
                    <label for="user_type" class="col-sm-2 col-form-label">User Type<span class="required"> *</span></label>
                    <div class="col-sm-6">
                        <select name="user_type" id="user_type" class="form-control">
                            <option value="">Select User Type</option>
                            <option value="escrow">Escrow Company</option>
                            <option value="lender">Lender</option>
                            <option value="mortgage_broker">Mortgage Broker</option>
                            <option value="realtor">Realtor</option>
                        </select>
                        <?php if (!empty($user_type_error_msg)) {?>
                            <span class="error"><?php echo $user_type_error_msg; ?></span>
                        <?php }?>
                    </div>
                </div>

                <div class="form-group">
                    <label for="address1" class="col-sm-2 col-form-label">Address1<span class="required"> *</span></label>
                    <div class="col-sm-6">
                        <input type="text" class="form-control" name="address1" id="address1" value="<?php echo set_value('address1'); ?>" placeholder="Address">
                        <?php if (!empty($address_error_msg)) {?>
                            <span class="error"><?php echo $address_error_msg; ?></span>
                        <?php }?>
                    </div>
                </div>

                <div class="form-group">
                    <label for="city" class="col-sm-2 col-form-label">City<span class="required"> *</span></label>
                    <div class="col-sm-6">
                        <input type="text" class="form-control" name="city" id="city" value="<?php echo set_value('city'); ?>" placeholder="City">
                        <?php if (!empty($city_error_msg)) {?>
                            <span class="error"><?php echo $city_error_msg; ?></span>
                        <?php }?>
                    </div>
                </div>

                <div class="form-group">
                    <label for="state" class="col-sm-2 col-form-label">State<span class="required"> *</span></label>
                    <div class="col-sm-6">
                        <input type="text" class="form-control" name="state" id="state" value="<?php echo set_value('state'); ?>" placeholder="State">
                        <?php if (!empty($state_error_msg)) {?>
                            <span class="error"><?php echo $state_error_msg; ?></span>
                        <?php }?>
                    </div>
                </div>

                <div class="form-group">
                    <label for="zipcode" class="col-sm-2 col-form-label">Zipcode<span class="required"> *</span></label>
                    <div class="col-sm-6">
                        <input type="text" class="form-control" name="zipcode" id="zipcode" value="<?php echo set_value('zipcode'); ?>" placeholder="Zipcode">
                        <?php if (!empty($zipcode_error_msg)) {?>
                            <span class="error"><?php echo $zipcode_error_msg; ?></span>
                        <?php }?>
                    </div>
                </div>

                <div class="form-group">
                    <label for="lookup_code" class="col-sm-2 col-form-label">Lookup Code</label>
                    <div class="col-sm-6">
                        <input type="text" value="<?php echo set_value('lookup_code'); ?>" class="form-control" name="lookup_code" id="lookup_code" placeholder="Lookup Code">
                        <?php if (!empty($lookup_code_error_msg)) {?>
                            <span class="error"><?php echo $lookup_code_error_msg; ?></span>
                        <?php }?>
                    </div>
                </div>

                <div class="form-group">
                    <div class="col-sm-6">
                        <button type="submit" class="btn-action btn-action-primary">
                            <i class="fas fa-save"></i> Add
                        </button>
                        <a href="<?php echo base_url() . 'order/admin/softpro-companies'; ?>" class="btn-action btn-action-secondary">
                            <i class="fas fa-arrow-left"></i> Cancel
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
