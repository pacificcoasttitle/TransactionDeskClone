<?php 
    $userdata = $this->session->userdata('admin');
    $roleList = $this->common_lib->getRoleList();
    $role_id = isset($userdata['role_id']) ? $userdata['role_id'] : 0;
    $roleName = $roleList[$role_id];
?>

<div class="pct-admin-listing">
    <!-- Page Header -->
    <div class="page-header">
        <h1><i class="fas fa-landmark"></i> Lenders</h1>
        
        <div class="action-buttons">
            <a href="javascript:void(0);" onclick="syncSoftProOpenContacts('lender');" class="btn-action btn-action-success">
                <i class="fas fa-sync-alt"></i> Sync Lender
            </a>
        </div>
    </div>

    <!-- Lenders Table Card -->
    <div class="modern-card">
        <div class="modern-card-header">
            <h2><i class="fas fa-users"></i> Lenders Listing</h2>
        </div>
        <div class="modern-card-body">
            <div id="customer_success_msg" class="alert-modern alert-success-modern" style="display:none;"></div>
            <div id="customer_error_msg" class="alert-modern alert-danger-modern" style="display:none;"></div>
            
            <div class="table-responsive">
                <table class="table table-bordered" id="tbl-sp-lenders-listing" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Lookup Code</th>
                            <th>First Name</th>
                            <th>Last Name</th>
                            <th>Email Address</th>
                            <th>Company Name</th>
                            <th>Address</th>
                            <th>Email Recording</th>
                            <th>No Survey Notification</th>
                            <th>Action</th>
                        </tr>
                    </thead>                
                    <tbody></tbody>
                </table>
            </div>
        </div>
    </div>
</div>