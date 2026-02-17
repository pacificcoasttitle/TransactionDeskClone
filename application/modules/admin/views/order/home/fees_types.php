<div class="pct-admin-listing">
    <!-- Page Header -->
    <div class="page-header">
        <h1><i class="fas fa-tags"></i> Fees Type</h1>
        <div class="action-buttons">
            <a href="<?php echo base_url(); ?>order/admin/add-fee-type" class="btn-action btn-action-success">
                <i class="fas fa-plus"></i> Add Fees Type
            </a>
        </div>
    </div>

    <!-- Fees Type Table Card -->
    <div class="modern-card">
        <div class="modern-card-header">
            <h2><i class="fas fa-list-alt"></i> Fees Type</h2>
        </div>
        <div class="modern-card-body">
            <div id="fees_success_msg" class="alert-modern alert-success-modern" style="display:none;"></div>
            <div id="fees_error_msg" class="alert-modern alert-danger-modern" style="display:none;"></div>
            <div class="table-responsive">
                <table class="table table-bordered" id="tbl-fees-types" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th width="20%" >Sr No</th>
                            <th width="70%">Name</th>
                            <th width="10%">Action</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
        </div>
    </div>
</div>