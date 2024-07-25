
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

                            <div class="form-group row ml-1">
                                <label for="escrow_commission" class="col-sm-3 col-form-label">Is LP Enable<span class="required"> *</span></label>
                                <div class="col-sm-2">
                                    <input type="checkbox" value="1" class="form-control" style="width:20px;"  name="escrow_commission" id="escrow_commission" <?php echo isset($escrow_commission) && !empty($escrow_commission) ? 'Checked' : ''; ?>>
                                    <input type="hidden" value="" name="lp_enable" >
                                </div>
                            </div>

                            <div class="form-group row ml-1">
                                <label for="title_point_shut_off" class="col-sm-3 col-form-label">Title Point Shut Off<span class="required"> *</span></label>
                                <div class="col-sm-2">
                                    <input type="checkbox" value="1" class="form-control" style="width:20px;"  name="title_point_shut_off" id="title_point_shut_off" <?php echo isset($title_point_shut_off) && !empty($title_point_shut_off) ? 'Checked' : ''; ?>>
                                    <!-- <input type="hidden" value="" name="title_point_shut_off" > -->
                                </div>
                            </div>

                            <div class="form-group row ml-1">
                                <label for="loan_order_closed_email_send_off" class="col-sm-3 col-form-label">Loan Order Closed Email Send Off<span class="required"> *</span></label>
                                <div class="col-sm-2">
                                    <input type="checkbox" value="1" class="form-control" style="width:20px;"  name="loan_order_closed_email_send_off" id="loan_order_closed_email_send_off" <?php echo isset($loan_order_closed_email_send_off) && !empty($loan_order_closed_email_send_off) ? 'Checked' : ''; ?>>
                                    <!-- <input type="hidden" value="" name="loan_order_closed_email_send_off" > -->
                                </div>
                            </div>

                            <div class="form-group row ml-1">
                                <label for="sale_order_closed_email_send_off" class="col-sm-3 col-form-label">Sale Order Closed Email Send Off<span class="required"> *</span></label>
                                <div class="col-sm-2">
                                    <input type="checkbox" value="1" class="form-control" style="width:20px;"  name="sale_order_closed_email_send_off" id="sale_order_closed_email_send_off" <?php echo isset($sale_order_closed_email_send_off) && !empty($sale_order_closed_email_send_off) ? 'Checked' : ''; ?>>
                                    <!-- <input type="hidden" value="" name="sale_order_closed_email_send_off" > -->
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




