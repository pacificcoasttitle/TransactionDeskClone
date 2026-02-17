<div class="pct-admin-listing">
    <!-- Session/Error Messages -->
    <?php if(!empty($success)){ ?>
        <div class="alert-modern alert-success-modern"><?php echo $success; ?></div>
    <?php } ?>

    <?php if(!empty($errors)){ ?>
        <div class="alert-modern alert-danger-modern"><?php echo $errors; ?></div>
    <?php } ?>

    <div id="manual_report_success_msg" class="alert-modern alert-success-modern" style="display:none;"></div>
    <div id="manual_report_error_msg" class="alert-modern alert-danger-modern" style="display:none;"></div>

    <!-- Page Header -->
    <div class="page-header">
        <h1><i class="fas fa-paper-plane"></i> Manual Report</h1>
    </div>

    <!-- Daily Production Card -->
    <div class="modern-card">
        <div class="modern-card-header">
            <h2><i class="fas fa-chart-line"></i> Daily Production</h2>
        </div>
        <div class="modern-card-body">
            <div class="form-group">
                <div class="col-sm-6">
                    <button type="submit" class="btn-action btn-action-success" onclick="sendDailyProductionReport();">
                        <i class="fas fa-paper-plane"></i> Send Daily Production Email
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- LP Reports Stats Card -->
    <div class="modern-card">
        <div class="modern-card-header">
            <h2><i class="fas fa-chart-bar"></i> LP reports Stats</h2>
        </div>
        <div class="modern-card-body">
            <div class="form-group">
                <div class="col-sm-6">
                    <button type="submit" class="btn-action btn-action-success" onclick="sendLPReports();">
                        <i class="fas fa-paper-plane"></i> Send LP Stats Email
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Closed Order Sample Email Card -->
    <div class="modern-card">
        <div class="modern-card-header">
            <h2><i class="fas fa-envelope-open-text"></i> Closed Order Sample Email</h2>
        </div>
        <div class="modern-card-body">
            <div class="form-group">
                <div class="col-sm-6">
                    <button type="submit" class="btn-action btn-action-success" onclick="sendClosedOrderAgentEmail();">
                        <i class="fas fa-paper-plane"></i> Send Sample Email For Closed Order
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Top Closers Card -->
    <div class="modern-card">
        <div class="modern-card-header">
            <h2><i class="fas fa-trophy"></i> Top Closers</h2>
        </div>
        <div class="modern-card-body">
            <form id="resware-admin-credential" method="POST" action="<?php echo base_url();?>send-summary-mail-sales-rep">
                <div class="form-group">
                    <label for="user_type" class="col-sm-2 col-form-label">Sales Rep<span class="required"> *</span></label>
                    <div class="col-sm-6">
                        <select name="sales_rep" id="sales_rep" class="form-control" required>
                            <option value="">Select Sales Rep</option>
                            <?php foreach($salesUsers as $salesUser) { ?>
                                <option value="<?php echo $salesUser['id'];?>"><?php echo $salesUser['first_name']." ".$salesUser['last_name'];?></option>
                            <?php }?>
                        </select>
                    </div>
                </div>
              
                <div class="form-group">
                    <div class="col-sm-6">
                        <button type="submit" class="btn-action btn-action-success">
                            <i class="fas fa-save"></i> Send Summary Email
                        </button>
                        <a href="<?php echo site_url('order/admin'); ?>" class="btn-action btn-action-secondary">
                            <i class="fas fa-arrow-left"></i> Cancel
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Non-Openers Card -->
    <div class="modern-card">
        <div class="modern-card-header">
            <h2><i class="fas fa-envelope"></i> Non-Openers - New</h2>
        </div>
        <div class="modern-card-body">
            <form id="resware-admin-credential" method="POST" action="<?php echo base_url();?>send-non-openers-email">
                <div class="form-group">
                    <label for="user_type" class="col-sm-2 col-form-label">Sales Rep<span class="required"> *</span></label>
                    <div class="col-sm-6">
                        <select name="sales_rep" id="sales_rep" class="form-control" required>
                            <option value="">Select Sales Rep</option>
                            <?php foreach($salesUsers as $salesUser) { ?>
                                <option value="<?php echo $salesUser['id'];?>"><?php echo $salesUser['first_name']." ".$salesUser['last_name'];?></option>
                            <?php }?>
                        </select>
                    </div>
                </div>
              
                <div class="form-group">
                    <div class="col-sm-6">
                        <button type="submit" class="btn-action btn-action-success">
                            <i class="fas fa-save"></i> Send Non Openers Email
                        </button>
                        <a href="<?php echo site_url('order/admin'); ?>" class="btn-action btn-action-secondary">
                            <i class="fas fa-arrow-left"></i> Cancel
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
