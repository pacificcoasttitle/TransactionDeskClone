<?php
$userdata = $this->session->userdata('admin');
$roleList = $this->common_lib->getRoleList();
$role_id = isset($userdata['role_id']) ? $userdata['role_id'] : 0;
$roleName = $roleList[$role_id];
?>

<div class="pct-admin-listing">
    <!-- Page Header -->
    <div class="page-header">
        <h1><i class="fas fa-id-card"></i> Title Officers</h1>
        
        <div class="action-buttons">
            <a href="javascript:void(0);" onclick="syncSoftProTitleOfficer();" class="btn-action btn-action-success">
                <i class="fas fa-sync-alt"></i> Sync Title Officers
            </a>
        </div>
    </div>

    <!-- Title Officers Table Card -->
    <div class="modern-card">
        <div class="modern-card-header">
            <h2><i class="fas fa-users"></i> Title Officers Listing</h2>
        </div>
        <div class="modern-card-body">
            <div id="title_officer_success_msg" class="alert-modern alert-success-modern" style="display:none;"></div>
            <div id="title_officer_error_msg" class="alert-modern alert-danger-modern" style="display:none;"></div>
            
            <div class="table-responsive">
                <table class="table table-bordered" id="tbl-sp-title-officer-listing" width="100%" cellspacing="0">
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