<div class="container-fluid">
    <div class="card mb-3">
        <div class="card-header">
            <i class="fas fa-table"></i>
            Cron Logs            
        </div>
        <div class="card-body">
            <div id="admin_user_logs_success_msg" class="w-100 alert alert-success alert-dismissible" style="display:none;"></div>
            <div id="admin_user_logs_error_msg" class="w-100 alert alert-danger alert-dismissible" style="display:none;"></div>
            <div class="table-responsive">
                <table class="table table-bordered" id="tbl-cron-logs" style="table-layout: fixed;" width="100%" cellspacing="0">
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