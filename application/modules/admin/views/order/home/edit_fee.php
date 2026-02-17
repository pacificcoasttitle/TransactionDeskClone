<div class="pct-admin-listing">
    <!-- Page Header -->
    <div class="page-header">
        <h1><i class="fas fa-edit"></i> Edit Fee</h1>
        <div class="action-buttons">
            <a href="<?php echo base_url() . 'order/admin/fees'; ?>" class="btn-action btn-action-secondary">
                <i class="fas fa-arrow-left"></i> Back
            </a>
        </div>
    </div>

    <!-- Edit Fee Form Card -->
    <div class="modern-card">
        <div class="modern-card-header">
            <h2><i class="fas fa-dollar-sign"></i> Edit Fee</h2>
        </div>
        <div class="modern-card-body">
            <?php if (!empty($success_msg)) {?>
                <div class="alert-modern alert-success-modern"><?php echo $success_msg; ?></div>
            <?php }?>
            <?php if (!empty($error_msg)) {?>
                <div class="alert-modern alert-danger-modern"><?php echo $error_msg; ?></div>
            <?php }?>

            <form id="frm-edit-fee" method="POST">
                <div class="form-group">
                    <label for="txn_type" class="col-sm-2 col-form-label">Transaction Type<span class="required"> *</span></label>
                    <div class="col-sm-6">
                        <select name="txn_type" id="txn_type" class="form-control">
                            <option value="">Select</option>
                            <option value="sale" <?php if ($fees_info['transaction_type'] == 'sale') {echo "selected";}?>>Sale</option>
                            <option value="loan" <?php if ($fees_info['transaction_type'] == 'loan') {echo "selected";}?>>Loan</option>
                        </select>
                    <?php if (!empty($txn_type_error_msg)) {?>
                        <span class="error"><?php echo $txn_type_error_msg; ?></span>
                    <?php }?>
                    </div>
                </div>

                <?php
if (isset($fee_types) && !empty($fee_types)) {
    ?>
                    <div class="form-group">
                        <label for="fee_type" class="col-sm-2 col-form-label">Fee Type<span class="required"> *</span></label>
                        <div class="col-sm-6">
                            <select name="fee_type" id="fee_type" class="form-control">
                                <option value="">Select</option>
                                <?php
foreach ($fee_types as $key => $value) {
        ?>
                                    <option value="<?php echo $value['id']; ?>" <?php if ($value['id'] == $fees_info['fee_type_id']) {echo "selected";}?>><?php echo $value['name']; ?></option>
                                <?php
}
    ?>
                            </select>
                        <?php if (!empty($fee_type_id_error_msg)) {?>
                            <span class="error"><?php echo $fee_type_id_error_msg; ?></span>
                        <?php }?>
                        </div>
                    </div>
                <?php
}
?>

                <div class="form-group">
                    <label for="fee_name" class="col-sm-2 col-form-label">Fee Name<span class="required"> *</span></label>
                    <div class="col-sm-6">
                        <?php
$fee_name = isset($fees_info['name']) && !empty($fees_info['name']) ? $fees_info['name'] : '';
?>
                        <input type="text" class="form-control" name="fee_name" id="fee_name" value="<?php echo $fee_name; ?>" placeholder="Fee Name">
                        <?php if (!empty($name_error_msg)) {?>
                            <span class="error"><?php echo $name_error_msg; ?></span>
                        <?php }?>
                    </div>
                </div>

                <div class="form-group">
                    <label for="fee_value" class="col-sm-2 col-form-label">Fee Value<span class="required"> *</span></label>
                    <div class="col-sm-6">
                        <?php
$fee_value = isset($fees_info['value']) && !empty($fees_info['value']) ? $fees_info['value'] : '';
?>
                        <input type="text" class="form-control" name="fee_value" id="fee_value" value="<?php echo $fee_value; ?>" placeholder="Fee Value">
                        <?php if (!empty($value_error_msg)) {?>
                            <span class="error"><?php echo $value_error_msg; ?></span>
                        <?php }?>
                    </div>
                </div>

                <div class="form-group">
                    <div class="col-sm-6">
                        <button type="submit" id="addFee" name="addFee" class="btn-action btn-action-primary">
                            <i class="fas fa-save"></i> Update
                        </button>
                        <a href="<?php echo base_url() . 'order/admin/fees'; ?>" class="btn-action btn-action-secondary">
                            <i class="fas fa-arrow-left"></i> Cancel
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>