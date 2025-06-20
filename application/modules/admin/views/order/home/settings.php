
<div class="content">
    <?php if (!empty($this->session->userdata('success'))) {?>
        <div class="col-xs-12">
            <div class="alert alert-success"><?php echo $this->session->userdata('success'); ?></div>
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
                <h1 class="h3 text-gray-800">Settings</h1>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Settings</h6>
                    </div>
                    <div class="card-body">
                        <form id="setting_form" method="POST">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group row ml-1">
                                        <label for="escrow_commission" class="col-sm-6 col-form-label">Is LP Enable<span class="required"> *</span></label>
                                        <div class="col-sm-2">
                                            <input type="checkbox" value="1" class="form-control" style="width:20px;"  name="escrow_commission" id="escrow_commission" <?php echo isset($escrow_commission) && !empty($escrow_commission) ? 'Checked' : ''; ?>>
                                            <input type="hidden" value="" name="lp_enable" >
                                        </div>
                                    </div>

                                    <div class="form-group row ml-1">
                                        <label for="title_point_shut_off" class="col-sm-6 col-form-label">Title Point Shut Off<span class="required"> *</span></label>
                                        <div class="col-sm-2">
                                            <input type="checkbox" value="1" class="form-control" style="width:20px;"  name="title_point_shut_off" id="title_point_shut_off" <?php echo isset($title_point_shut_off) && !empty($title_point_shut_off) ? 'Checked' : ''; ?>>
                                            <!-- <input type="hidden" value="" name="title_point_shut_off" > -->
                                        </div>
                                    </div>

                                    <div class="form-group row ml-1">
                                        <label for="loan_order_closed_email_send_off" class="col-sm-6 col-form-label">Loan Order Closed Email Send Off<span class="required"> *</span></label>
                                        <div class="col-sm-2">
                                            <input type="checkbox" value="1" class="form-control" style="width:20px;"  name="loan_order_closed_email_send_off" id="loan_order_closed_email_send_off" <?php echo isset($loan_order_closed_email_send_off) && !empty($loan_order_closed_email_send_off) ? 'Checked' : ''; ?>>
                                            <!-- <input type="hidden" value="" name="loan_order_closed_email_send_off" > -->
                                        </div>
                                    </div>

                                    <div class="form-group row ml-1">
                                        <label for="sale_order_closed_email_send_off" class="col-sm-6 col-form-label">Sale Order Closed Email Send Off<span class="required"> *</span></label>
                                        <div class="col-sm-2">
                                            <input type="checkbox" value="1" class="form-control" style="width:20px;"  name="sale_order_closed_email_send_off" id="sale_order_closed_email_send_off" <?php echo isset($sale_order_closed_email_send_off) && !empty($sale_order_closed_email_send_off) ? 'Checked' : ''; ?>>
                                            <!-- <input type="hidden" value="" name="sale_order_closed_email_send_off" > -->
                                        </div>
                                    </div>

                                    <div class="form-group row ml-1">
                                        <label for="enable_lv_with_address_apn" class="col-sm-6 col-form-label">Enable LV with Address + APN </label>
                                        <div class="col-sm-2">
                                            <input type="checkbox" value="1" class="form-control" style="width:20px;"  name="enable_lv_with_address_apn" id="enable_lv_with_address_apn" <?php echo isset($enable_lv_with_address_apn) && !empty($enable_lv_with_address_apn) ? 'Checked' : ''; ?>>
                                            <!-- <input type="hidden" value="" name="sale_order_closed_email_send_off" > -->
                                        </div>
                                    </div>

                                    <div class="form-group row ml-1">
                                        <label for="enable_vesting_document_type_filter" class="col-sm-6 col-form-label">Enable Vesting Document Type Filter </label>
                                        <div class="col-sm-2">
                                            <input type="checkbox" value="1" class="form-control" style="width:20px;"  name="enable_vesting_document_type_filter" id="enable_vesting_document_type_filter" <?php echo isset($enable_vesting_document_type_filter) && !empty($enable_vesting_document_type_filter) ? 'Checked' : ''; ?>>
                                        </div>
                                    </div>

                                    <div class="form-group row ml-1">
                                        <label for="enable_create_order_submit_button" class="col-sm-6 col-form-label">Default Enable Create Order Submit Button </label>
                                        <div class="col-sm-2">
                                            <input type="checkbox" value="1" class="form-control" style="width:20px;"  name="enable_create_order_submit_button" id="enable_create_order_submit_button" <?php echo isset($enable_create_order_submit_button) && !empty($enable_create_order_submit_button) ? 'Checked' : ''; ?>>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group row ml-1">
                                        <label for="add_underwriten_partner_via_api" class="col-sm-6 col-form-label">Add Underwritten Partner Via API </label>
                                        <div class="col-sm-2">
                                            <input type="checkbox" value="1" class="form-control" style="width:20px;"  name="add_underwriten_partner_via_api" id="add_underwriten_partner_via_api" <?php echo isset($add_underwriten_partner_via_api) && !empty($add_underwriten_partner_via_api) ? 'Checked' : ''; ?>>
                                        </div>
                                    </div>

                                    <div class="form-group row ml-1">
                                        <label for="recording_confirmation_shut_off" class="col-sm-6 col-form-label">Recording Confirmation Notification Shut Off </label>
                                        <div class="col-sm-2">
                                            <input type="checkbox" value="1" class="form-control" style="width:20px;"  name="recording_confirmation_shut_off" id="recording_confirmation_shut_off" <?php echo isset($recording_confirmation_shut_off) && !empty($recording_confirmation_shut_off) ? 'Checked' : ''; ?>>
                                        </div>
                                    </div>

                                    <div class="form-group row ml-1">
                                        <label for="disburse_funds_shut_off" class="col-sm-6 col-form-label">Disburse Funds Notification Shut Off </label>
                                        <div class="col-sm-2">
                                            <input type="checkbox" value="1" class="form-control" style="width:20px;"  name="disburse_funds_shut_off" id="disburse_funds_shut_off" <?php echo isset($disburse_funds_shut_off) && !empty($disburse_funds_shut_off) ? 'Checked' : ''; ?>>
                                        </div>
                                    </div>

                                    <div class="form-group row ml-1">
                                        <label for="fees_pdf_confirmation_email_shut_off" class="col-sm-6 col-form-label">Fees Pdf Confirmation Email Shut Off </label>
                                        <div class="col-sm-2">
                                            <input type="checkbox" value="1" class="form-control" style="width:20px;"  name="fees_pdf_confirmation_email_shut_off" id="fees_pdf_confirmation_email_shut_off" <?php echo isset($fees_pdf_confirmation_email_shut_off) && !empty($fees_pdf_confirmation_email_shut_off) ? 'Checked' : ''; ?>>
                                        </div>
                                    </div>

                                    <div class="form-group row ml-1">
                                        <label for="enable_fees_email_for_refinance" class="col-sm-6 col-form-label">Enable Fees Email For Refinance </label>
                                        <div class="col-sm-2">
                                            <input type="checkbox" value="1" class="form-control" style="width:20px;"  name="enable_fees_email_for_refinance" id="enable_fees_email_for_refinance" <?php echo isset($enable_fees_email_for_refinance) && !empty($enable_fees_email_for_refinance) ? 'Checked' : ''; ?>>
                                        </div>
                                    </div>

                                    <div class="form-group row ml-1">
                                        <label for="enable_fees_email_for_resale" class="col-sm-6 col-form-label">Enable Fees Email For Resale </label>
                                        <div class="col-sm-2">
                                            <input type="checkbox" value="1" class="form-control" style="width:20px;"  name="enable_fees_email_for_resale" id="enable_fees_email_for_resale" <?php echo isset($enable_fees_email_for_resale) && !empty($enable_fees_email_for_resale) ? 'Checked' : ''; ?>>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-sm-6">
                                    <button type="submit" class="btn btn-info btn-icon-split">
                                        <span class="icon text-white-50">
                                            <i class="fas fa-save"></i>
                                        </span>
                                        <span class="text">Save</span>
                                    </button>
                                    <a href="<?php echo site_url('order/admin'); ?>" class="btn btn-secondary btn-icon-split">
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




