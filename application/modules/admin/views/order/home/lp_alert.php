<style>
.dataTables_length {
    width: 250px !important;
    float: left;
}
.FilterOrderListing {
    width: 100%;
    display: flex;
}
</style>
<div class="container-fluid">
    <?php if(!empty($this->session->userdata('success'))){ ?>
        <div class="col-xs-12">
            <div class="alert alert-success"><?php echo $this->session->userdata('success'); ?></div>
        </div>
    <?php } ?>

    <?php if(!empty($error_msg)){ ?>
        <div class="col-xs-12">
            <div class="alert alert-danger"><?php echo $error_msg; ?></div>
        </div>
    <?php } ?>
    <div id="lp_order_success_msg" class="w-100 alert alert-success alert-dismissible" style="display:none;"></div>
    <div id="lp_order_error_msg" class="w-100 alert alert-danger alert-dismissible" style="display:none;"></div>
    <div class="card mb-3">
        <div class="card-header">
            <i class="fas fa-table"></i>
            LP Alert
            <div class="float-right">
                <a href="<?php echo base_url()?>order/admin/add-lp-alert" class="btn btn-secondary"> Add LP Alert </a>
            </div>
        </div>
                
        <div class="card-body">
            <div id="lp_alert_success_msg" class="w-100 alert alert-success alert-dismissible" style="display:none;"></div>
            <div id="lp_alert_error_msg" class="w-100 alert alert-danger alert-dismissible" style="display:none;"></div>
            <div class="table-responsive">
                <table class="table table-bordered" id="tbl-lp-alert-listing" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Sr No</th>
                            <th>Days</th>
                            <th>Color Code</th>
                            <th>Text Color</th>
                            <th>Delete flag</th>
                            <th>Action</th>
                        </tr>
                    </thead>                
                    <tbody></tbody>
                </table>
            </div>
        </div>
    </div>
</div>
