<style>
.ui-menu .ui-menu-item-wrapper {
    font-size : 13px;
}

.ui-autocomplete {
    max-height: 300px !important;
}
</style>
<div class="content">
    <?php if (!empty($success_msg)) {?>
        <div class="col-xs-12">
            <div class="alert alert-success"><?php echo $success_msg; ?></div>
        </div>
    <?php }?>

    <?php if (!empty($error_msg)) {?>
        <div class="col-xs-12">
            <div class="alert alert-danger"><?php echo $error_msg; ?></div>
        </div>
    <?php }?>


    <div class="container-fluid">
        <div class="row mb-3">
            <div class="col-sm-6">
                <h1 class="h3 text-gray-800">Edit User</h1>
            </div>
            <div class="col-sm-6">
                <a href="<?php echo $back_url ?>" class="btn btn-info btn-icon-split float-right mr-2">
                    <span class="icon text-white-50">
                        <i class="fas fa-arrow-left"></i>
                    </span>
                    <span class="text"> Back </span>
                </a>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Edit User</h6>
                    </div>
                    <div class="card-body">
                        <form id="edit-new-user" method="POST">
                            <div class="form-group">
                                <label for="company" class="col-sm-2 col-form-label">Company Name<span class="required"> *</span></label>
                                <div class="col-sm-6">
                                    <?php $flookup_code = isset($userDetails['flookup_code']) ? $userDetails['flookup_code'] : set_value('flookup_code'); ?>
                                    <?php $company_name = isset($userDetails['company_name']) ? $userDetails['company_name'] : set_value('company_name'); ?>
                                    
                                    <input type="hidden" class="form-control" name="flookup_code" id="flookup_code" value="<?php echo $flookup_code; ?>" class="form-control" >
                                    <input type="text" class="form-control" name="company_name" id="company_name" value="<?php echo $company_name; ?>" class="form-control" placeholder="Company Name">
                                    <?php if (!empty($company_name_error_msg)) {?>
                                        <span class="error"><?php echo $company_name_error_msg; ?></span>
                                    <?php }?>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="first_name" class="col-sm-2 col-form-label">First Name<span class="required"> *</span></label>
                                <div class="col-sm-6">
                                    <?php $first_name = isset($userDetails['first_name']) ? $userDetails['first_name'] : set_value('first_name'); ?>
                                    <input type="text" class="form-control" name="first_name" id="first_name" value="<?php echo $first_name; ?>" class="form-control" placeholder="First Name">
                                    <?php if (!empty($first_name_error_msg)) {?>
                                        <span class="error"><?php echo $first_name_error_msg; ?></span>
                                    <?php }?>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="last_name" class="col-sm-2 col-form-label">Last Name<span class="required"> *</span></label>
                                <div class="col-sm-6">
                                <?php $last_name = isset($userDetails['last_name']) ? $userDetails['last_name'] : set_value('last_name'); ?>
                                    <input type="text" class="form-control" name="last_name" id="last_name" value="<?php echo $last_name; ?>" class="form-control" placeholder="Last Name">
                                    <?php if (!empty($last_name_error_msg)) {?>
                                        <span class="error"><?php echo $last_name_error_msg; ?></span>
                                    <?php }?>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="lookup_code" class="col-sm-2 col-form-label">Lookup Code<span class="required"> *</span></label>
                                <div class="col-sm-6">
                                <?php $lookup_code = isset($userDetails['lookup_code']) ? $userDetails['lookup_code'] : set_value('lookup_code'); ?>
                                    <input type="text" class="form-control" name="lookup_code" id="lookup_code" readyonly value="<?php echo $lookup_code; ?>" class="form-control" placeholder="Lookup Code">
                                    <?php if (!empty($lookup_code_error_msg)) {?>
                                        <span class="error"><?php echo $lookup_code_error_msg; ?></span>
                                    <?php }?>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="email_address" class="col-sm-2 col-form-label">Email Address</label>
                                <div class="col-sm-6">
                                <?php $email_address = isset($userDetails['email_address']) ? $userDetails['email_address'] : set_value('email_address'); ?>
                                    <input type="email" value="<?php echo $email_address; ?>" class="form-control" name="email_address" id="email_address" class="form-control" placeholder="Email Address">
                                    <?php if (!empty($email_address_error_msg)) {?>
                                        <span class="error"><?php echo $email_address_error_msg; ?></span>
                                    <?php }?>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="phone" class="col-sm-2 col-form-label">Telephone</label>
                                <div class="col-sm-6">
                                <?php $phone = isset($userDetails['phone']) ? $userDetails['phone'] : set_value('phone'); ?>
                                    <input type="text" value="<?php echo $phone; ?>" class="form-control" name="phone" id="phone" class="form-control" placeholder="Telephone">
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
                                        <option <?php echo ($userDetails['is_lender'] == 1) ? 'selected' : ''; ?> value="lender">Lender</option>
                                        <option <?php echo ($userDetails['is_escrow'] == 1) ? 'selected' : ''; ?> value="escrow">Escrow</option>
                                        <option <?php echo ($userDetails['is_mortgage_broker'] == 1) ? 'selected' : ''; ?> value="mortgage_broker">Mortgage Broker</option>
                                        <option <?php echo ($userDetails['is_selling_agent'] == 1) ? 'selected' : ''; ?> value="realtor">Realtor</option>
                                    </select>
                                    <?php if (!empty($user_type_error_msg)) {?>
                                        <span class="error"><?php echo $user_type_error_msg; ?></span>
                                    <?php }?>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="address" class="col-sm-2 col-form-label">Address<span class="required"> *</span></label>
                                <div class="col-sm-6">
                                <?php $address1 = isset($userDetails['address1']) ? $userDetails['address1'] : set_value('address1'); ?>
                                    <input type="text" class="form-control" name="address1" id="address1" value="<?php echo $address1; ?>" class="form-control" placeholder="Address">
                                    <?php if (!empty($address_error_msg)) {?>
                                        <span class="error"><?php echo $address_error_msg; ?></span>
                                    <?php }?>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="city" class="col-sm-2 col-form-label">City<span class="required"> *</span></label>
                                <div class="col-sm-6">
                                <?php $city = isset($userDetails['city']) ? $userDetails['city'] : set_value('city'); ?>
                                    <input type="text" class="form-control" name="city" id="city" value="<?php echo $city; ?>" class="form-control" placeholder="City">
                                    <?php if (!empty($city_error_msg)) {?>
                                        <span class="error"><?php echo $city_error_msg; ?></span>
                                    <?php }?>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="state" class="col-sm-2 col-form-label">State<span class="required"> *</span></label>
                                <div class="col-sm-6">
                                <?php $state = isset($userDetails['state']) ? $userDetails['state'] : set_value('state'); ?>
                                    <input type="text" class="form-control" name="state" id="state" value="<?php echo $state; ?>" class="form-control" placeholder="State">
                                    <?php if (!empty($state_error_msg)) {?>
                                        <span class="error"><?php echo $state_error_msg; ?></span>
                                    <?php }?>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="zipcode" class="col-sm-2 col-form-label">Zipcode<span class="required"> *</span></label>
                                <div class="col-sm-6">
                                <?php $zip = isset($userDetails['zip']) ? $userDetails['zip'] : set_value('zip'); ?>
                                    <input type="text" class="form-control" name="zip" id="zip" value="<?php echo $zip; ?>" class="form-control" placeholder="Zipcode">
                                    <?php if (!empty($zipcode_error_msg)) {?>
                                        <span class="error"><?php echo $zipcode_error_msg; ?></span>
                                    <?php }?>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-sm-6">
                                    <button type="submit" class="btn btn-info btn-icon-split">
                                        <span class="icon text-white-50">
                                            <i class="fas fa-save"></i>
                                        </span>
                                        <span class="text">Add</span>
                                    </button>
                                    <a href="<?php echo $back_url ?>" class="btn btn-secondary btn-icon-split">
                                        <span class="icon text-white-50">
                                            <i class="fas fa-arrow-left"></i>
                                        </span>
                                        <span class="text">Cancel</span>
                                    </a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

