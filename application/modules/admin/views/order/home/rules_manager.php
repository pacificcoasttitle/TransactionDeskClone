<style>
.bootstrap-select:not([class*="col-"]):not([class*="form-control"]):not(.input-group-btn) {
    width: -webkit-fill-available;
}
</style>

<div class="pct-admin-listing">
    <!-- Page Header -->
    <div class="page-header">
        <h1><i class="fas fa-gavel"></i> Rules Manager</h1>
    </div>

    <!-- Rules Manager Table Card -->
    <div class="modern-card">
        <div class="modern-card-header">
            <h2><i class="fas fa-list-alt"></i> Rules Manager</h2>
        </div>
        <div class="modern-card-body">
            <div id="rules_success_msg" class="alert-modern alert-success-modern" style="display:none;"></div>
            <div id="rules_error_msg" class="alert-modern alert-danger-modern" style="display:none;"></div>
            <div class="table-responsive">
                <table class="table table-bordered" id="tbl-rules-manager" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Sr No</th>
                            <th>Title</th>
                            <th>Value</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
        </div>
    </div>
</div>