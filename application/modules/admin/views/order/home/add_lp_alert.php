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
        <h1><i class="fas fa-plus-circle"></i> LP Alert</h1>
        <div class="action-buttons">
            <a href="<?php echo base_url() . 'order/admin/lp-alert'; ?>" class="btn-action btn-action-secondary">
                <i class="fas fa-arrow-left"></i> Back
            </a>
        </div>
    </div>

    <!-- Add LP Alert Form Card -->
    <div class="modern-card">
        <div class="modern-card-header">
            <h2><i class="fas fa-bell"></i> Add New LP Alert</h2>
        </div>
        <div class="modern-card-body">
            <?php if (!empty($success_msg)) {?>
                <div class="alert-modern alert-success-modern"><?php echo $success_msg; ?></div>
            <?php }?>
            <?php if (!empty($error_msg)) {?>
                <div class="alert-modern alert-danger-modern"><?php echo $error_msg; ?></div>
            <?php }?>

            <form id="add-alert" method="POST">

                <div class="form-group">
                    <label for="days" class="col-sm-4 col-form-label">Days<span class="required"> *</span></label>
                    <div class="col-sm-6">
                        <input type="text" class="form-control" name="days" id="days" value="<?php echo set_value('days') ?>" placeholder="Days">
                        <?php if (!empty($days_error_msg)) {?>
                            <span class="error"><?php echo $days_error_msg; ?></span>
                        <?php }?>
                    </div>
                </div>

                <div class="form-group">
                    <label for="description" class="col-sm-4 col-form-label">Description</label>
                    <div class="col-sm-6">
                        <input type="text" class="form-control" name="description" id="description" value="<?php echo set_value('description') ?>" placeholder="Add Description">
                        <?php if (!empty($description_error_msg)) {?>
                            <span class="error"><?php echo $description_error_msg; ?></span>
                        <?php }?>
                    </div>
                </div>

                <div class="form-group row ml-1">
                    <label for="color_code" class="col-sm-2 col-form-label">Color Code</label>
                    <div class="col-sm-2">
                        <input type="color" class="form-control" name="color_code" id="color_code" value="#FFFFFF" placeholder="Color Code" style="width: 40%;" >
                    </div>
                </div>

                <div class="form-group row ml-1">
                    <label for="text_color" class="col-sm-2 col-form-label">Text Color</label>
                    <div class="col-sm-2">
                        <input type="color" class="form-control" name="text_color" id="text_color" value="#FFFFFF" placeholder="Text Code" style="width: 40%;" >
                    </div>
                </div>

                <div class="form-group row ml-1">
                    <label for="regular_order_color_code" class="col-sm-2 col-form-label"> Regular Order Code </label>
                    <div class="col-sm-2">
                        <input type="color" class="form-control" name="regular_order_color_code" id="regular_order_color_code" value="#FFFFFF" style="width: 40%;" >
                    </div>
                </div>

                <div class="form-group row ml-1">
                    <label for="delete" class="col-sm-2 col-form-label">Delete</label>
                    <div class="col-sm-2">
                        <input type="checkbox" value="1" class="form-control" style="width: 20px;"  name="delete" id="delete">
                    </div>
                </div>

                <div class="form-group">
                    <div class="col-sm-6">
                        <button type="submit" class="btn-action btn-action-primary">
                            <i class="fas fa-save"></i> Add
                        </button>
                        <a href="<?php echo base_url() . 'order/admin/lp-alert'; ?>" class="btn-action btn-action-secondary">
                            <i class="fas fa-arrow-left"></i> Cancel
                        </a>
                    </div>
                </div>

            </form>
        </div>
    </div>
</div>
