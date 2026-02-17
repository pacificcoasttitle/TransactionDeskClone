<div class="pct-admin-listing">
    <!-- Page Header -->
    <div class="page-header">
        <h1><i class="fas fa-plus-circle"></i> Add Daily Email Receiver</h1>
        <div class="action-buttons">
            <a href="<?php echo base_url() . 'order/admin/daily-email-control'; ?>" class="btn-action btn-action-secondary">
                <i class="fas fa-arrow-left"></i> Back
            </a>
        </div>
    </div>

    <!-- Add Daily Email Receiver Form Card -->
    <div class="modern-card">
        <div class="modern-card-header">
            <h2><i class="fas fa-envelope"></i> Add Daily Email Receiver</h2>
        </div>
        <div class="modern-card-body">
            <?php if (!empty($success_msg)) {?>
                <div class="alert-modern alert-success-modern"><?php echo $success_msg; ?></div>
            <?php }?>
            <?php if (!empty($error_msg)) {?>
                <div class="alert-modern alert-danger-modern"><?php echo $error_msg; ?></div>
            <?php }?>

            <form id="frm-add-holiday" method="POST">
                <div class="form-group">
                    <label for="email" class="col-sm-2 col-form-label">Receiver Email<span class="required"> *</span></label>
                    <div class="col-sm-6">
                        <input type="text" class="form-control" name="email" id="email" placeholder="Email">
                        <?php if (!empty($email_error_msg)) {?>
                            <span class="error"><?php echo $email_error_msg; ?></span>
                        <?php }?>
                    </div>
                </div>

                <div class="form-group">
                    <label for="branch" class="col-sm-2 col-form-label">Branch<span class="required"> *</span></label>
                    <div class="col-sm-6">
                        <select name="branch" id="branch" class="form-control" placeholder="Please select branch" >
                            <option value=""> Please Select Branch </option>
                            <option value="glendale" <?php echo ($receiver_info['branch'] == 'glendale') ? 'selected' : '' ?>>Glendale</option>
                            <option value="orange" <?php echo ($receiver_info['branch'] == 'orange') ? 'selected' : '' ?>>Orange</option>
                            <option value="both" <?php echo ($receiver_info['branch'] == 'both') ? 'selected' : '' ?>>Both</option>
                        </select>
                        <?php if (!empty($branch_error_msg)) {?>
                            <span class="error"><?php echo $branch_error_msg; ?></span>
                        <?php }?>
                    </div>
                </div>

                <div class="form-group">
                    <div class="col-sm-6">
                        <button type="submit" id="addEmailReceiver" name="addEmailReceiver" class="btn-action btn-action-primary">
                            <i class="fas fa-save"></i> Add
                        </button>
                        <a href="<?php echo base_url() . 'order/admin/daily-email-control'; ?>" class="btn-action btn-action-secondary">
                            <i class="fas fa-arrow-left"></i> Cancel
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
