<div class="pct-admin-listing">
    <!-- Page Header -->
    <div class="page-header">
        <h1><i class="fas fa-clock"></i> Cron Logs</h1>
    </div>

    <!-- Cron Logs Table Card -->
    <div class="modern-card">
        <div class="modern-card-header">
            <h2><i class="fas fa-list-alt"></i> Cron Log Listing</h2>
        </div>
        <div class="modern-card-body">
            <div id="admin_user_logs_success_msg" class="alert-modern alert-success-modern" style="display:none;"></div>
            <div id="admin_user_logs_error_msg" class="alert-modern alert-danger-modern" style="display:none;"></div>
            
            <div class="table-responsive">
                <table class="table table-bordered" id="tbl-cron-logs" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th width="5%">Sr No</th>
                            <th width="15%">Cron name</th>
                            <th width="25%">Request</th>
                            <th width="40%">Response</th>
                            <th width="15%">Created</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
        </div>
    </div>
</div>