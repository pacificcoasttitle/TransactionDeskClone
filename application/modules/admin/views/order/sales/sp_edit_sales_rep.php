<style>
    .bootstrap-select:not([class*="col-"]):not([class*="form-control"]):not(.input-group-btn) {
        width: -webkit-fill-available;
    }
    #accordionEx .card-header a .fa-angle-down {
        display: none;
    }
    #accordionEx .card-header a.collapsed .fa-angle-up {
        display: none;
    }
    #accordionEx .card-header a.collapsed .fa-angle-down {
        display: inline-block;
    }
    .accordion > .card.managerInfoCard {
        overflow: initial;
    }
    .remove-btn-holder {
        position: absolute;
        right: -20px;
        top: -30px;
    }
    .remove-btn-holder .threshold-remove-btn {
        border-radius: 50%;
    }
    .accordion .commission-details .card{
        border-bottom: 1px solid rgba(0,0,0,.125) !important;
        border-bottom-left-radius: 0.25rem !important;
        border-bottom-right-radius: 0.25rem !important;
        margin-bottom:25px;
    }

    .threshold__amounts .clone-main-div .remove-btn-holder {
        display: none;
    }
    .commission-details .nav-pills .nav-link.active {
    position: relative;
    }

    .commission-details .nav-pills .nav-link.active:before {
        content: '';
        position: absolute;
        top: 0;
        right: 0;
        border-top: 23px solid #fff;
        border-bottom: 23px solid #fff;
        border-left: 29px solid transparent;
    }
</style>
<div class="pct-admin-listing">
    <!-- Page Header -->
    <div class="page-header">
        <h1><i class="fas fa-user-tie"></i> Sales Rep</h1>
        <div class="action-buttons">
            <a href="<?php echo site_url('order/admin/softpro-sales-reps'); ?>" class="btn-action btn-action-secondary">
                <i class="fas fa-arrow-left"></i> Back
            </a>
        </div>
    </div>

    <!-- Edit Sales Rep Form Card -->
    <div class="modern-card">
        <div class="modern-card-header">
            <h2><i class="fas fa-user-tie"></i> Edit Sales Rep</h2>
        </div>
        <div class="modern-card-body">
            <?php if (!empty($success_msg)) {?>
                <div class="alert-modern alert-success-modern"><?php echo $success_msg; ?></div>
            <?php }?>
            <?php if (!empty($error_msg)) {?>
                <div class="alert-modern alert-danger-modern"><?php echo $error_msg; ?></div>
            <?php }?>

            <form id="frm-add-sales-rep" method="POST" enctype="multipart/form-data">

                <div class="accordion md-accordion" id="accordionEx">

                    <div class="card mx-auto mt-5 mb-5" style="border-bottom: 1px solid rgba(0, 0, 0, 0.125);">
                        <div class="card-header" role="tab" id="salesRepInfoTab">
                            <a data-toggle="collapse" style="color: #000000;" data-parent="#accordionEx" href="#salesRepInfo" aria-expanded="true"
                            aria-controls="salesRepInfo">
                                <h5 class="mb-0 text-primary">
                                Sales Rep Info <i class="fas fa-angle-down pull-right"></i><i class="fas fa-angle-up pull-right"></i>
                                </h5>
                            </a>
                        </div>
                        <div id="salesRepInfo" class="collapse show" role="tabpanel" aria-labelledby="salesRepInfoTab" data-parent="#accordionEx">
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="sales_rep_first_name" class="col-sm-4 col-form-label">First Name<span class="required"> *</span></label>
                                    <div class="col-sm-6">
                                        <input type="text" class="form-control" name="sales_rep_first_name" id="sales_rep_first_name" placeholder="Enter Sales Rep. First Name" value="<?php echo isset($sales_rep_info['first_name']) && !empty($sales_rep_info['first_name']) ? $sales_rep_info['first_name'] : '' ?>">
                                        <?php if (!empty($first_name_error_msg)) {?>
                                            <span class="error"><?php echo $first_name_error_msg; ?></span>
                                        <?php }?>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="sales_rep_last_name" class="col-sm-4 col-form-label">Last Name<span class="required"> *</span></label>
                                    <div class="col-sm-6">
                                        <input type="text" class="form-control" name="sales_rep_last_name" id="sales_rep_last_name" placeholder="Enter Sales Rep. Last Name" value="<?php echo isset($sales_rep_info['last_name']) && !empty($sales_rep_info['last_name']) ? $sales_rep_info['last_name'] : '' ?>">
                                        <?php if (!empty($last_name_error_msg)) {?>
                                            <span class="error"><?php echo $last_name_error_msg; ?></span>
                                        <?php }?>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="email_address" class="col-sm-4 col-form-label">Email Address<span class="required"> *</span></label>
                                    <div class="col-sm-6">
                                        <input type="text" class="form-control" name="email_address" id="email_address" placeholder="Email Address" value="<?php echo isset($sales_rep_info['email_address']) && !empty($sales_rep_info['email_address']) ? $sales_rep_info['email_address'] : '' ?>">
                                        <?php if (!empty($email_error_msg)) {?>
                                            <span class="error"><?php echo $email_error_msg; ?></span>
                                        <?php }?>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="telephone" class="col-sm-4 col-form-label">Phone Number<span class="required"> *</span></label>
                                    <div class="col-sm-6">
                                        <input type="text" class="form-control" name="telephone" id="telephone" placeholder="Phone Number" value="<?php echo isset($sales_rep_info['phone']) && !empty($sales_rep_info['phone']) ? $sales_rep_info['phone'] : '' ?>">
                                        <?php if (!empty($phone_error_msg)) {?>
                                            <span class="error"><?php echo $phone_error_msg; ?></span>
                                        <?php }?>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="language" class="col-sm-4 col-form-label">Disable</label>
                                    <div class="col-sm-1">
                                        <input <?php echo $sales_rep_info['status'] == 0 ? "checked" : ""; ?>  type="checkbox" class="form-control" name="status" id="status">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card mx-auto mt-5 mb-5" style="border-bottom: 1px solid rgba(0, 0, 0, 0.125);">
                        <div class="card-header" role="tab" id="productionTab">
                            <a data-toggle="collapse" class="collapsed" style="color: #000000;" data-parent="#accordionEx" href="#production"
                            aria-controls="production">
                                <h5 class="mb-0 text-primary">
                                Production <i class="fas fa-angle-down pull-right"></i><i class="fas fa-angle-up pull-right"></i>
                                </h5>
                            </a>
                        </div>
                        <div id="production" class="collapse" role="tabpanel" aria-labelledby="productionTab" data-parent="#accordionEx">
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="sales_rep_no_of_open_orders" class="col-sm-4 col-form-label">Number of Open Orders<span class="required"></span></label>
                                    <div class="col-sm-6">
                                        <input type="text" class="form-control" name="sales_rep_no_of_open_orders" id="sales_rep_no_of_open_orders" value="<?php echo isset($sales_rep_info['sales_rep_no_of_open_orders']) && !empty($sales_rep_info['sales_rep_no_of_open_orders']) ? $sales_rep_info['sales_rep_no_of_open_orders'] : '' ?>">
                                        <?php if (!empty($sales_rep_no_of_open_orders_error_msg)) {?>
                                            <span class="error"><?php echo $sales_rep_no_of_open_orders_error_msg; ?></span>
                                        <?php }?>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="sales_rep_no_of_close_orders" class="col-sm-4 col-form-label">Number of Closed Orders<span class="required"></span></label>
                                    <div class="col-sm-6">
                                        <input type="text" class="form-control" name="sales_rep_no_of_close_orders" id="sales_rep_no_of_close_orders" value="<?php echo isset($sales_rep_info['sales_rep_no_of_close_orders']) && !empty($sales_rep_info['sales_rep_no_of_close_orders']) ? $sales_rep_info['sales_rep_no_of_close_orders'] : '' ?>">
                                        <?php if (!empty($sales_rep_no_of_close_orders_error_msg)) {?>
                                            <span class="error"><?php echo $sales_rep_no_of_close_orders_error_msg; ?></span>
                                        <?php }?>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="sales_rep_premium" class="col-sm-4 col-form-label">Revenue<span class="required"></span></label>
                                    <div class="col-sm-6">
                                        <input type="text" class="form-control" name="sales_rep_premium" id="sales_rep_premium" value="<?php echo isset($sales_rep_info['sales_rep_premium']) && !empty($sales_rep_info['sales_rep_premium']) ? $sales_rep_info['sales_rep_premium'] : '' ?>">
                                        <?php if (!empty($sales_rep_premium_error_msg)) {?>
                                            <span class="error"><?php echo $sales_rep_premium_error_msg; ?></span>
                                        <?php }?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card mx-auto mt-5 mb-5 managerInfoCard" style="border-bottom: 1px solid rgba(0, 0, 0, 0.125);">
                        <div class="card-header" role="tab" id="managerTab">
                            <a data-toggle="collapse" class="collapsed" style="color: #000000;" data-parent="#accordionEx" href="#managerInfo"
                            aria-controls="managerInfo">
                                <h5 class="mb-0 text-primary">
                                Manager <i class="fas fa-angle-down pull-right"></i><i class="fas fa-angle-up pull-right"></i>
                                </h5>
                            </a>
                        </div>
                        <div id="managerInfo" class="collapse" role="tabpanel" aria-labelledby="managerTab" data-parent="#accordionEx">
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="language" class="col-sm-4 col-form-label">Sales Manager</label>
                                    <div class="col-sm-1">
                                        <input <?php echo $sales_rep_info['is_sales_rep_manager'] == 1 ? "checked" : ""; ?>  type="checkbox" class="form-control" name="is_sales_rep_manager" id="is_sales_rep_manager">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="saled_rep_drop" class="col-sm-4 col-form-label">Select Sales Reps.</label>
                                    <div class="col-sm-6">
                                        <select name="sales_rep_users[]" id="saled_rep_drop"  class="selectpicker" multiple data-live-search="true" data-actions-box="true" >
                                            <?php foreach ($salesUsers as $salesUser) {
    $selected = '';
    if (set_value('sales_rep_users') && in_array($salesUser['id'], set_value('sales_rep_users'))) {
        $selected = 'selected';
    } else {

        $sales_rep_users = explode(',', $sales_rep_info['sales_rep_users']);
        if (in_array($salesUser['id'], $sales_rep_users)) {
            $selected = 'selected';
        }
    }
    ?>
                                                <option <?php echo $selected; ?> value="<?php echo $salesUser['id']; ?>"><?php echo $salesUser['first_name'] . " " . $salesUser['last_name']; ?></option>
                                            <?php
}?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card mx-auto mt-5 mb-5" style="border-bottom: 1px solid rgba(0, 0, 0, 0.125);">
                        <div class="card-header" role="tab" id="imagesTab">
                            <a data-toggle="collapse" class="collapsed" style="color: #000000;" data-parent="#accordionEx" href="#imagesInfo"
                            aria-controls="imagesInfo">
                                <h5 class="mb-0 text-primary">
                                Images <i class="fas fa-angle-down pull-right"></i><i class="fas fa-angle-up pull-right"></i>
                                </h5>
                            </a>
                        </div>
                        <div id="imagesInfo" class="collapse" role="tabpanel" aria-labelledby="imagesTab" data-parent="#accordionEx">
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="sales_rep_profile_img" class="col-sm-4 col-form-label">Profile Img For Borrower Email</label>
                                    <div class="col-sm-6">
                                        <input type="file" class="form-control" name="sales_rep_profile_img" id="sales_rep_profile_img" accept=".png,.jpg">
                                        <?php if (!empty($sales_rep_profile_img_error_msg)) {?>
                                            <span class="error"><?php echo $sales_rep_profile_img_error_msg; ?></span>
                                        <?php }?>
                                    </div>
                                    <div class="col-sm-4">
                                        <?php
if (isset($sales_rep_info['sales_rep_profile_img']) && !empty($sales_rep_info['sales_rep_profile_img'])) {
    if (env('AWS_ENABLE_FLAG') == 1) {
        $sales_rep_info['sales_rep_profile_img'] = str_replace('uploads/', '', $sales_rep_info['sales_rep_profile_img']);
        $img = env('AWS_PATH') . $sales_rep_info['sales_rep_profile_img'];
    } else {
        $img = base_url() . $sales_rep_info['sales_rep_profile_img'];
    }

}
?>
                                        <?php
if (isset($img) && !empty($img)) {
    ?>
                                            <img src="<?php echo $img; ?>" width="100" height="100">
                                            <a href="javascript:void(0);" onclick="removeSalesRepProfileImg(<?php echo $sales_rep_info['id']; ?>);">Remove img</a>
                                        <?php
}
?>

                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="sales_rep_profile_thank_you_img" class="col-sm-4 col-form-label">Profile Img For Thank you Email</label>
                                    <div class="col-sm-6">
                                        <input type="file" class="form-control" name="sales_rep_profile_thank_you_img" id="sales_rep_profile_thank_you_img" accept=".png,.jpg">
                                        <?php if (!empty($sales_rep_profile_thank_you_img_error_msg)) {?>
                                            <span class="error"><?php echo $sales_rep_profile_thank_you_img_error_msg; ?></span>
                                        <?php }?>
                                    </div>
                                    <div class="col-sm-4">
                                        <?php
if (env('AWS_ENABLE_FLAG') == 1) {
    $sales_rep_info['sales_rep_profile_thank_you_img'] = str_replace('uploads/', '', $sales_rep_info['sales_rep_profile_thank_you_img']);
    $imgThank = env('AWS_PATH') . $sales_rep_info['sales_rep_profile_thank_you_img'];
} else {
    $imgThank = base_url() . $sales_rep_info['sales_rep_profile_thank_you_img'];
}
?>
                                        <?php
if (isset($imgThank) && !empty($imgThank)) {
    ?>
                                            <img src="<?php echo $imgThank; ?>" width="100" height="100">
                                            <a href="javascript:void(0);" onclick="removeSalesRepThankYouProfileImg(<?php echo $sales_rep_info['id']; ?>);">Remove img</a>
                                        <?php
}
?>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card mx-auto mt-5 mb-5" style="border-bottom: 1px solid rgba(0, 0, 0, 0.125);">
                        <div class="card-header" role="tab" id="notificationsTab">
                            <a data-toggle="collapse" class="collapsed" style="color: #000000;" data-parent="#accordionEx" href="#notificationsInfo"
                            aria-controls="notificationsInfo">
                                <h5 class="mb-0 text-primary">
                                Notifications<i class="fas fa-angle-down pull-right"></i><i class="fas fa-angle-up pull-right"></i>
                                </h5>
                            </a>
                        </div>
                        <div id="notificationsInfo" class="collapse" role="tabpanel" aria-labelledby="notificationsTab" data-parent="#accordionEx">
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="is_mail_notification" class="col-sm-4 col-form-label">&nbsp;</label>
                                    <div class="col-sm-6">
                                        <input type="checkbox" <?php echo ($sales_rep_info['is_mail_notification'] == 1) ? 'checked' : '' ?> class="" style="height:18px;width:18px;margin-right:10px;" name="is_mail_notification" id="is_mail_notification" placeholder="Mail Notification">Mail Notification
                                    </div>

                                    <label for="notify_recording_confirm" class="col-sm-4 col-form-label">&nbsp;</label>
                                    <div class="col-sm-6">
                                        <input type="checkbox" <?php echo ($sales_rep_info['notify_recording_confirm'] == 1) ? 'checked' : '' ?> class="" style="height:18px;width:18px;margin-right:10px;" name="notify_recording_confirm" id="notify_recording_confirm">Notify Recording Confirm
                                    </div>

                                    <label for="notify_disburse_funds" class="col-sm-4 col-form-label">&nbsp;</label>
                                    <div class="col-sm-6">
                                        <input type="checkbox" <?php echo ($sales_rep_info['notify_disburse_funds'] == 1) ? 'checked' : '' ?> class="" style="height:18px;width:18px;margin-right:10px;" name="notify_disburse_funds" id="notify_disburse_funds">Notify Disburse Funds
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-sm-6">
                            <button type="submit" id="edit-sales-rep" name="edit-sales-rep" class="btn-action btn-action-primary">
                                <i class="fas fa-save"></i> Update
                            </button>
                            <a href="<?php echo site_url('order/admin/sales-rep'); ?>" class="btn-action btn-action-secondary">
                                <i class="fas fa-arrow-left"></i> Cancel
                            </a>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
