<style>
.hide {
    display: none;
}
</style>

<div class="pct-admin-listing">
    <!-- Page Header -->
    <div class="page-header">
        <h1><i class="fas fa-edit"></i> LP Alert</h1>
        <div class="action-buttons">
            <a href="<?php echo base_url() . 'order/admin/lp-alert'; ?>" class="btn-action btn-action-secondary">
                <i class="fas fa-arrow-left"></i> Back
            </a>
        </div>
    </div>

    <!-- Edit LP Alert Form Card -->
    <div class="modern-card">
        <div class="modern-card-header">
            <h2><i class="fas fa-bell"></i> Edit LP Alert</h2>
        </div>
        <div class="modern-card-body">
            <?php if (!empty($success_msg)) {?>
                <div class="alert-modern alert-success-modern"><?php echo $success_msg; ?></div>
            <?php }?>
            <?php if (!empty($error_msg)) {?>
                <div class="alert-modern alert-danger-modern"><?php echo $error_msg; ?></div>
            <?php }?>

            <form id="frm-edit-alert" method="POST">
                <div class="form-group">
                    <label for="days" class="col-sm-4 col-form-label">Days<span class="required"> *</span></label>
                    <div class="col-sm-6">
                        <input type="text" class="form-control" name="days" id="days" placeholder="Days" value="<?php echo isset($lp_alert['days']) && !empty($lp_alert['days']) ? $lp_alert['days'] : ''; ?>">
                        <?php if (!empty($days_error_msg)) {?>
                            <span class="error"><?php echo $days_error_msg; ?></span>
                        <?php }?>
                    </div>
                </div>

                <div class="form-group">
                    <label for="description" class="col-sm-4 col-form-label">Description</label>
                    <div class="col-sm-6">
                        <input type="text" class="form-control" name="description" id="description" placeholder="Add Description" value="<?php echo isset($lp_alert['description']) && !empty($lp_alert['description']) ? $lp_alert['description'] : ''; ?>">
                        <?php if (!empty($description_error_msg)) {?>
                            <span class="error"><?php echo $description_error_msg; ?></span>
                        <?php }?>
                    </div>
                </div>

                <div class="form-group row ml-1">
                    <label for="color_code" class="col-sm-4 col-form-label">Color Code<span class="required">*</span></label>
                    <div class="col-sm-2">
                        <input type="color" class="form-control" name="color_code" id="color_code" value="<?php echo isset($lp_alert['color_code']) && !empty($lp_alert['color_code']) ? $lp_alert['color_code'] : ''; ?>" style="width: 40%; border-radious:50;">
                    </div>
                </div>

                <div class="form-group row ml-1">
                    <label for="text_color" class="col-sm-4 col-form-label">Text Color<span class="required">*</span></label>
                    <div class="col-sm-2">
                        <input type="color" class="form-control" name="text_color" id="text_color" value="<?php echo isset($lp_alert['text_color']) && !empty($lp_alert['text_color']) ? $lp_alert['text_color'] : ''; ?>" style="width: 40%; border-radious:50;">
                    </div>
                </div>

                <div class="form-group row ml-1">
                    <label for="regular_order_color_code" class="col-sm-4 col-form-label"> Regular Order Color Code <span class="required">*</span></label>
                    <div class="col-sm-2">
                        <input type="color" class="form-control" name="regular_order_color_code" id="regular_order_color_code" value="<?php echo isset($lp_alert['regular_order_color_code']) && !empty($lp_alert['regular_order_color_code']) ? $lp_alert['regular_order_color_code'] : ''; ?>" style="width: 40%; border-radious:50;">
                    </div>
                </div>

                <div class="form-group row ml-1">
                    <label for="delete" class="col-sm-4 col-form-label">Is Notice</label>
                    <div class="col-sm-2">
                        <input type="checkbox" value="1" class="form-control" style="width: 20px;"  name="delete" id="delete" <?php echo isset($lp_alert['delete']) && !empty($lp_alert['delete']) ? 'Checked' : ''; ?>>
                    </div>
                </div>

                <div class="form-group">
                    <div class="col-sm-6">
                        <button type="submit" class="btn-action btn-action-primary">
                            <i class="fas fa-save"></i> Update
                        </button>
                        <a href="<?php echo site_url('order/admin/lp-alert'); ?>" class="btn-action btn-action-secondary">
                            <i class="fas fa-arrow-left"></i> Cancel
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>