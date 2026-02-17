<div class="pct-admin-listing">
    <!-- Session/Error Messages -->
    <?php if(!empty($this->session->userdata('success'))){ ?>
        <div class="alert-modern alert-success-modern"><?php echo $this->session->userdata('success'); ?></div>
    <?php } ?>

    <?php if(!empty($error_msg)){ ?>
        <div class="alert-modern alert-danger-modern"><?php echo $error_msg; ?></div>
    <?php } ?>

    <div id="lp_order_success_msg" class="alert-modern alert-success-modern" style="display:none;"></div>
    <div id="lp_order_error_msg" class="alert-modern alert-danger-modern" style="display:none;"></div>

    <!-- Page Header -->
    <div class="page-header">
        <h1><i class="fas fa-exclamation-triangle"></i> LP Alert</h1>
        <div class="action-buttons">
            <a href="<?php echo base_url()?>order/admin/add-lp-alert" class="btn-action btn-action-success">
                <i class="fas fa-plus"></i> Add LP Alert
            </a>
        </div>
    </div>

    <!-- LP Alert Table Card -->
    <div class="modern-card">
        <div class="modern-card-header">
            <h2><i class="fas fa-list-alt"></i> LP Alert</h2>
        </div>
        <div class="modern-card-body">
            <div id="lp_alert_success_msg" class="alert-modern alert-success-modern" style="display:none;"></div>
            <div id="lp_alert_error_msg" class="alert-modern alert-danger-modern" style="display:none;"></div>
            <div class="table-responsive">
                <table class="table table-bordered" id="tbl-lp-alert-listing" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th width="5%">Sr No</th>
                            <th width="5%">Days</th>
                            <th width="20%">Description</th>
                            <th width="15%">Color Code</th>
                            <th width="15%">Text Color</th>
                            <th width="20%">Regular Order Code</th>
                            <th width="10%">Delete flag</th>
                            <th width="10%">Action</th>
                        </tr>
                    </thead>                
                    <tbody></tbody>
                </table>
            </div>
        </div>
    </div>
</div>
