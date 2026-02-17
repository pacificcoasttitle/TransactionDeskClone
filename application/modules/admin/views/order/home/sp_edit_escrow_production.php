<div class="pct-admin-listing">
    <!-- Page Header -->
    <div class="page-header">
        <h1><i class="fas fa-edit"></i> Escrow Production</h1>
        <div class="action-buttons">
            <a href="<?php echo site_url('order/admin/softpro-escrow-production'); ?>" class="btn-action btn-action-secondary">
                <i class="fas fa-arrow-left"></i> Back
            </a>
        </div>
    </div>

    <!-- Edit Escrow Production Form Card -->
    <div class="modern-card">
        <div class="modern-card-header">
            <h2><i class="fas fa-file-contract"></i> Edit Escrow Production</h2>
        </div>
        <div class="modern-card-body">
            <?php if (!empty($success_msg)) {?>
                <div class="alert-modern alert-success-modern"><?php echo $success_msg; ?></div>
            <?php }?>
            <?php if (!empty($error_msg)) {?>
                <div class="alert-modern alert-danger-modern"><?php echo $error_msg; ?></div>
            <?php }?>

            <form id="frm-edit-escrow-production" method="POST">
                <div class="form-group">
                    <label for="first_name" class="col-sm-2 col-form-label">First Name<span class="required"> *</span></label>
                    <div class="col-sm-6">
                        <input type="text" class="form-control" name="first_name" id="first_name" value="<?php echo $escrow_production_info['first_name']; ?>" placeholder="First Name">
                        <?php if (!empty($first_name_error_msg)) {?>
                            <span class="error"><?php echo $first_name_error_msg; ?></span>
                        <?php }?>
                    </div>
                </div>

                <div class="form-group">
                    <label for="last_name" class="col-sm-2 col-form-label">Last Name<span class="required"> *</span></label>
                    <div class="col-sm-6">
                        <input type="text" class="form-control" name="last_name" id="last_name" value="<?php echo $escrow_production_info['last_name']; ?>" placeholder="Last Name">
                        <?php if (!empty($last_name_error_msg)) {?>
                            <span class="error"><?php echo $last_name_error_msg; ?></span>
                        <?php }?>
                    </div>
                </div>

                <div class="form-group">
                    <label for="email_address" class="col-sm-2 col-form-label">Email Address<span class="required"> *</span></label>
                    <div class="col-sm-6">
                        <input type="text" class="form-control" name="email_address" id="email_address" placeholder="Email Address" value="<?php echo isset($escrow_production_info['email_address']) && !empty($escrow_production_info['email_address']) ? $escrow_production_info['email_address'] : '' ?>">
                        <?php if (!empty($email_error_msg)) {?>
                            <span class="error"><?php echo $email_error_msg; ?></span>
                        <?php }?>
                    </div>
                </div>

                <div class="form-group">
                    <label for="telephone" class="col-sm-2 col-form-label">Phone Number</label>
                    <div class="col-sm-6">
                        <input type="text" class="form-control" name="telephone" id="telephone" placeholder="Phone Number" value="<?php echo isset($escrow_production_info['phone']) && !empty($escrow_production_info['phone']) ? $escrow_production_info['phone'] : '' ?>">
                    </div>
                </div>

                <div class="form-group">
                    <div class="col-sm-6">
                        <button type="submit" id="edit-escrow-production" name="edit-escrow-production" class="btn-action btn-action-primary">
                            <i class="fas fa-save"></i> Update
                        </button>
                        <a href="<?php echo site_url('order/admin/softpro-escrow-production'); ?>" class="btn-action btn-action-secondary">
                            <i class="fas fa-arrow-left"></i> Cancel
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>