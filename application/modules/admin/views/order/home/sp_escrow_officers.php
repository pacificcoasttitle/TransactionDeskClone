<div class="pct-admin-listing">
    <!-- Page Header -->
    <div class="page-header">
        <h1><i class="fas fa-file-signature"></i> Escrow Officers</h1>
        
        <div class="action-buttons">
            <a href="javascript:void(0);" onclick="syncSoftProEscrowOfficer();" class="btn-action btn-action-success">
                <i class="fas fa-sync-alt"></i> Sync Escrow Officers
            </a>
        </div>
    </div>

    <!-- Escrow Officers Table Card -->
    <div class="modern-card">
        <div class="modern-card-header">
            <h2><i class="fas fa-users"></i> Escrow Officers Listing</h2>
        </div>
        <div class="modern-card-body">
            <div id="escrow_officer_success_msg" class="alert-modern alert-success-modern" style="display:none;"></div>
            <div id="escrow_officer_error_msg" class="alert-modern alert-danger-modern" style="display:none;"></div>
            
            <div class="table-responsive">
                <table class="table table-bordered" id="tbl-sp-escrow-officers-listing" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Closer Examiner</th>
                            <th>Lookup Code</th>
                            <th>Officer Name</th>
                            <th>Action</th>
                        </tr>
                    </thead>                
                    <tbody></tbody>
                </table>
            </div>
        </div>
    </div>
</div>