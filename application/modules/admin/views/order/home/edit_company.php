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
                <h1 class="h3 text-gray-800">Edit Company</h1>
            </div>
            <div class="col-sm-6">
                <a href="<?php echo base_url() . 'order/admin/softpro-companies'; ?>" class="btn btn-info btn-icon-split float-right mr-2">
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
                        <h6 class="m-0 font-weight-bold text-primary">Edit Company</h6>
                    </div>
                    <div class="card-body">
                        <form id="add-company" method="POST">
                            <div class="form-group">
                                <label for="name" class="col-sm-2 col-form-label">Name<span class="required"> *</span></label>
                                <div class="col-sm-6">
                                    <?php $name = isset($userDetails['name']) ? $userDetails['name'] : set_value('name'); ?>
                                    <?php $lookup_code = isset($userDetails['lookup_code']) ? $userDetails['lookup_code'] : set_value('lookup_code'); ?>
                                    <input type="hidden" name="lookup_code" id="lookup_code" value="<?php echo $lookup_code; ?>">
                                    <input type="text" name="name" id="name" value="<?php echo $name; ?>" class="form-control" placeholder="Name">
                                    <?php if (!empty($name_error_msg)) {?>
                                        <span class="error"><?php echo $name_error_msg; ?></span>
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
                                        <option <?php echo ($userDetails['is_lender'] == 1) ? 'selected' : ''; ?> value="">Select User Type</option>
                                        <option <?php echo ($userDetails['is_escrow_company'] == 1) ? 'selected' : ''; ?> value="escrow">Escrow Company</option>
                                        <option <?php echo ($userDetails['is_lender'] == 1) ? 'selected' : ''; ?> value="lender">Lender</option>
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
                                    <input type="text" class="form-control" name="address1" id="address1" value="<?php echo $address1; ?>" placeholder="Address">
                                    <?php if (!empty($address1_error_msg)) {?>
                                        <span class="error"><?php echo $address1_error_msg; ?></span>
                                    <?php }?>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="city" class="col-sm-2 col-form-label">City<span class="required"> *</span></label>
                                <div class="col-sm-6">
                                    <?php $city = isset($userDetails['city']) ? $userDetails['city'] : set_value('city'); ?>
                                    <input type="text" class="form-control" name="city" id="city" value="<?php echo $city; ?>" placeholder="City">
                                    <?php if (!empty($city_error_msg)) {?>
                                        <span class="error"><?php echo $city_error_msg; ?></span>
                                    <?php }?>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="state" class="col-sm-2 col-form-label">State<span class="required"> *</span></label>
                                <div class="col-sm-6">
                                    <?php $state = isset($userDetails['state']) ? $userDetails['state'] : set_value('state'); ?>
                                    <input type="text" class="form-control" name="state" id="state" value="<?php echo $state; ?>" placeholder="State">
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
                                    <?php if (!empty($zip_error_msg)) {?>
                                        <span class="error"><?php echo $zip_error_msg; ?></span>
                                    <?php }?>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-sm-6">
                                    <button type="submit" class="btn btn-info btn-icon-split">
                                        <span class="icon text-white-50">
                                            <i class="fas fa-save"></i>
                                        </span>
                                        <span class="text">Update</span>
                                    </button>
                                    <!-- <button type="submit" class="btn btn-secondary">Update</button> -->
                                    <a href="<?php echo base_url() . 'order/admin/softpro-companies'; ?>" class="btn btn-secondary btn-icon-split">
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
