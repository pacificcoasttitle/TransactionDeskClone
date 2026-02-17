<div class="pct-admin-listing">
    <!-- Page Header -->
    <div class="page-header">
        <h1><i class="fas fa-edit"></i> Fee Type</h1>
        <div class="action-buttons">
            <a href="<?php echo base_url() . 'order/admin/fees-types'; ?>" class="btn-action btn-action-secondary">
                <i class="fas fa-arrow-left"></i> Back
            </a>
        </div>
    </div>

    <!-- Edit Fee Type Form Card -->
    <div class="modern-card">
        <div class="modern-card-header">
            <h2><i class="fas fa-tag"></i> Edit Fee Type</h2>
        </div>
        <div class="modern-card-body">
            <?php if (!empty($success_msg)) {?>
                <div class="alert-modern alert-success-modern"><?php echo $success_msg; ?></div>
            <?php }?>
            <?php if (!empty($error_msg)) {?>
                <div class="alert-modern alert-danger-modern"><?php echo $error_msg; ?></div>
            <?php }?>

            <form id="frm-edit-fee-type" method="POST">
                <div class="form-group">
                    <label for="fee_type" class="col-sm-2 col-form-label">Fee Type<span class="required"> *</span></label>
                    <div class="col-sm-6">
                        <?php
$fee_type = isset($fees_info['name']) && !empty($fees_info['name']) ? $fees_info['name'] : '';
?>
                        <input type="text" class="form-control" name="fee_type" id="fee_type" value="<?php echo $fee_type; ?>" placeholder="Fee Type">
                        <?php if (!empty($name_error_msg)) {?>
                            <span class="error"><?php echo $name_error_msg; ?></span>
                        <?php }?>
                    </div>
                </div>

                <div class="form-group">
                    <div class="col-sm-6">
                        <button type="submit" id="updateFeeType" name="updateFeeType" class="btn-action btn-action-primary">
                            <i class="fas fa-save"></i> Update
                        </button>
                        <a href="<?php echo base_url() . 'order/admin/fees-types'; ?>" class="btn-action btn-action-secondary">
                            <i class="fas fa-arrow-left"></i> Cancel
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>