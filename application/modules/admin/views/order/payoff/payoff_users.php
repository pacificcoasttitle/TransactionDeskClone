<div class="pct-admin-listing">
    <!-- Page Header -->
    <div class="page-header">
        <h1><i class="fas fa-users"></i> Payoff Users</h1>
        <div class="action-buttons">
            <a href="<?php echo base_url() ?>order/admin/add-payoff-user" class="btn-action btn-action-success">
                <i class="fas fa-plus"></i> Add
            </a>
        </div>
    </div>

    <!-- Payoff Users Table Card -->
    <div class="modern-card">
        <div class="modern-card-header">
            <h2><i class="fas fa-users"></i> Payoff Users</h2>
        </div>
        <div class="modern-card-body">
            <div id="payoff_user_success_msg" class="alert-modern alert-success-modern" style="display:none;"></div>
            <div id="payoff_user_error_msg" class="alert-modern alert-danger-modern" style="display:none;"></div>
            <div class="table-responsive">
                <table class="table table-bordered" id="tbl-payoff-users-listing" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Email Address</th>
                            <th>Company Name</th>
                            <!-- <th>Enable User</th> -->
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
        </div>
    </div>
</div>