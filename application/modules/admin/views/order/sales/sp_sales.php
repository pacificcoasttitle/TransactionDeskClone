<?php 
    $userdata = $this->session->userdata('admin');
    $roleList = $this->common_lib->getRoleList();
    $role_id = isset($userdata['role_id']) ? $userdata['role_id'] : 0;
    $roleName = $roleList[$role_id];
?>

<div class="pct-admin-listing">
    <!-- Page Header -->
    <div class="page-header">
        <h1><i class="fas fa-user-tie"></i> Sales Rep</h1>
        
        <div class="action-buttons">
            <a href="javascript:void(0);" onclick="syncSoftProSalesReps();" class="btn-action btn-action-success">
                <i class="fas fa-sync-alt"></i> Sync Sales Reps
            </a>
        </div>
    </div>

    <!-- Sales Rep Table Card -->
    <div class="modern-card">
        <div class="modern-card-header">
            <h2><i class="fas fa-users"></i> Sales Rep Listing</h2>
        </div>
        <div class="modern-card-body">
            <input type="hidden" name="sales_rep_status_flag" id="sales_rep_status_flag" value="<?php echo $sales_rep_status_flag;?>">
            
            <div id="sales_rep_success_msg" class="alert-modern alert-success-modern" style="display:none;"></div>
            <div id="sales_rep_error_msg" class="alert-modern alert-danger-modern" style="display:none;"></div>
            
            <div class="table-responsive">
                <table class="table table-bordered" id="tbl-sp-sales-rep-listing" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Lookup Code</th>
                            <th>Name</th>
                            <th>Email Address</th>
                            <th>Telephone</th>
                            <th>Sales Rep Type</th>
                            <th>Mail Notification</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>                
                    <tbody></tbody>
                </table>
            </div>
        </div>
    </div>
</div>
