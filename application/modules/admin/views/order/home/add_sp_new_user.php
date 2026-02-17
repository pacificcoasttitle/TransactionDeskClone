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
        <h1><i class="fas fa-user-plus"></i> Add New User</h1>
        <div class="action-buttons">
            <a href="<?php echo base_url() . 'order/admin/softpro-new-users'; ?>" class="btn-action btn-action-secondary">
                <i class="fas fa-arrow-left"></i> Back
            </a>
        </div>
    </div>

    <!-- Add New User Form Card -->
    <div class="modern-card">
        <div class="modern-card-header">
            <h2><i class="fas fa-user-plus"></i> Add New User</h2>
        </div>
        <div class="modern-card-body">
            <?php if (!empty($success_msg)) {?>
                <div class="alert-modern alert-success-modern"><?php echo $success_msg; ?></div>
            <?php }?>
            <?php if (!empty($error_msg)) {?>
                <div class="alert-modern alert-danger-modern"><?php echo $error_msg; ?></div>
            <?php }?>

            <form id="add-new-user" method="POST">
                <div class="form-group">
                    <label for="company" class="col-sm-2 col-form-label">Company Name<span class="required"> *</span></label>
                    <div class="col-sm-6">
                        <input type="hidden" class="form-control" name="flookup_code" id="flookup_code" value="<?php echo set_value('flookup_code'); ?>" >
                        <input type="text" class="form-control" name="company_name" id="company_name" value="<?php echo set_value('company_name'); ?>" placeholder="Company Name">
                        <?php if (!empty($company_name_error_msg)) {?>
                            <span class="error"><?php echo $company_name_error_msg; ?></span>
                        <?php }?>
                    </div>
                </div>

                <div class="form-group">
                    <label for="first_name" class="col-sm-2 col-form-label">First Name<span class="required"> *</span></label>
                    <div class="col-sm-6">
                        <input type="text" class="form-control" name="first_name" id="first_name" value="<?php echo set_value('first_name'); ?>" placeholder="First Name">
                        <?php if (!empty($first_name_error_msg)) {?>
                            <span class="error"><?php echo $first_name_error_msg; ?></span>
                        <?php }?>
                    </div>
                </div>

                <div class="form-group">
                    <label for="last_name" class="col-sm-2 col-form-label">Last Name<span class="required"> *</span></label>
                    <div class="col-sm-6">
                        <input type="text" class="form-control" name="last_name" id="last_name" value="<?php echo set_value('last_name'); ?>" placeholder="Last Name">
                        <?php if (!empty($last_name_error_msg)) {?>
                            <span class="error"><?php echo $last_name_error_msg; ?></span>
                        <?php }?>
                    </div>
                </div>

                <div class="form-group">
                    <label for="lookup_code" class="col-sm-2 col-form-label">Lookup Code<span class="required"> *</span></label>
                    <div class="col-sm-6">
                        <input type="text" class="form-control" name="lookup_code" id="lookup_code" value="<?php echo set_value('lookup_code'); ?>" placeholder="Lookup Code">
                        <?php if (!empty($lookup_code_error_msg)) {?>
                            <span class="error"><?php echo $lookup_code_error_msg; ?></span>
                        <?php }?>
                    </div>
                </div>

                <div class="form-group">
                    <label for="email_address" class="col-sm-2 col-form-label">Email Address<span class="required"> *</span></label>
                    <div class="col-sm-6">
                        <input type="email" value="<?php echo set_value('email_address'); ?>" class="form-control" name="email_address" id="email_address" placeholder="Email Address">
                        <?php if (!empty($email_address_error_msg)) {?>
                            <span class="error"><?php echo $email_address_error_msg; ?></span>
                        <?php }?>
                    </div>
                </div>

                <div class="form-group">
                    <label for="phone" class="col-sm-2 col-form-label">Telephone<span class="required"> *</span></label>
                    <div class="col-sm-6">
                        <input type="text" value="<?php echo set_value('phone'); ?>" class="form-control" name="phone" id="phone" placeholder="Telephone">
                        <?php if (!empty($phone_error_msg)) {?>
                            <span class="error"><?php echo $phone_error_msg; ?></span>
                        <?php }?>
                    </div>
                </div>

                <!-- <div class="form-group">
                    <label for="company" class="col-sm-2 col-form-label">Title Company<span class="required"> *</span></label>
                    <div class="col-sm-6">
                        <input type="text" class="form-control" name="title_company" id="title_company" value="<?php echo set_value('title_company'); ?>" class="form-control" placeholder="Title Company">
                        <?php if (!empty($title_company_error_msg)) {?>
                            <span class="error"><?php echo $title_company_error_msg; ?></span>
                        <?php }?>
                    </div>
                </div> -->

                <div class="form-group">
                    <label for="user_type" class="col-sm-2 col-form-label">User Type<span class="required"> *</span></label>
                    <div class="col-sm-6">
                        <select name="user_type" id="user_type" class="form-control">
                            <option value="">Select User Type</option>
                            <option <?php echo set_value('user_type') == 'lender' ? 'selected' : ''; ?> value="lender">Lender</option>
                            <option <?php echo set_value('user_type') == 'escrow' ? 'selected' : ''; ?> value="escrow">Escrow</option>
                            <option <?php echo set_value('user_type') == 'mortgage_broker' ? 'selected' : ''; ?> value="mortgage_broker">Mortgage Broker</option>
                            <option <?php echo set_value('user_type') == 'realtor' ? 'selected' : ''; ?> value="realtor">Realtor</option>
                        </select>
                        <?php if (!empty($user_type_error_msg)) {?>
                            <span class="error"><?php echo $user_type_error_msg; ?></span>
                        <?php }?>
                    </div>
                </div>

                <div class="form-group">
                    <label for="address" class="col-sm-2 col-form-label">Address<span class="required"> *</span></label>
                    <div class="col-sm-6">
                        <input type="text" class="form-control" name="address" id="address" value="<?php echo set_value('address'); ?>" placeholder="Address">
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
                    <div class="col-sm-6">
                        <button type="submit" class="btn-action btn-action-primary">
                            <i class="fas fa-save"></i> Add
                        </button>
                        <a href="<?php echo base_url() . 'order/admin/softpro-new-users'; ?>" class="btn-action btn-action-secondary">
                            <i class="fas fa-arrow-left"></i> Cancel
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
