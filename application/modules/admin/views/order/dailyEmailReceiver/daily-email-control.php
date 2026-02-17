<div class="pct-admin-listing">
    <!-- Page Header -->
    <div class="page-header">
        <h1><i class="fas fa-envelope"></i> Daily Email Control</h1>
        <div class="action-buttons">
            <a href="<?php echo base_url(); ?>order/admin/add-daily-emailer" class="btn-action btn-action-success">
                <i class="fas fa-plus"></i> Add Daily Email Receiver
            </a>
        </div>
    </div>

    <!-- Daily Email Control Table Card -->
    <div class="modern-card">
        <div class="modern-card-header">
            <h2><i class="fas fa-list-alt"></i> Daily Email Control</h2>
        </div>
        <div class="modern-card-body">
            <div id="tbl-daily-email-control_success_msg" class="alert-modern alert-success-modern" style="display:none;"></div>
            <div id="tbl-daily-email-control_error_msg" class="alert-modern alert-danger-modern" style="display:none;"></div>
            <div class="table-responsive">
                <table class="table table-bordered" id="tbl-daily-email-control" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th width="10%">Sr No</th>
                            <th width="40%">Email</th>
                            <th width="20%">Status</th>
                            <th width="20%">Branch</th>
                            <th width="10%">Action</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
        </div>
    </div>
</div>