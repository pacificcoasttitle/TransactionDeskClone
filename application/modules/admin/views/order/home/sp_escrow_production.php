<div class="pct-admin-listing">
    <!-- Page Header -->
    <div class="page-header">
        <h1><i class="fas fa-file-contract"></i> Escrow Production</h1>
        
        <div class="action-buttons">
            <a href="<?php echo base_url() ?>order/admin/add-softpro-escrow-production" class="btn-action btn-action-primary">
                <i class="fas fa-plus"></i> Add
            </a>
        </div>
    </div>

    <!-- Escrow Production Table Card -->
    <div class="modern-card">
        <div class="modern-card-header">
            <h2><i class="fas fa-users"></i> Escrow Production Listing</h2>
        </div>
        <div class="modern-card-body">
            <div id="sp_escrow_production_success_msg" class="alert-modern alert-success-modern" style="display:none;"></div>
            <div id="sp_escrow_production_error_msg" class="alert-modern alert-danger-modern" style="display:none;"></div>
            
            <div class="table-responsive">
                <table class="table table-bordered" id="tbl-sp-escrow-production-listing" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Email Address</th>
                            <th>Telephone</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
        </div>
    </div>
</div>