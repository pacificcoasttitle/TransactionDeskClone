<?php 
    $userdata = $this->session->userdata('admin');
    $roleList = $this->common_lib->getRoleList();
    $role_id = isset($userdata['role_id']) ? $userdata['role_id'] : 0;
    $roleName = $roleList[$role_id];
?>

<div class="pct-admin-listing">
    <!-- Page Header -->
    <div class="page-header">
        <h1><i class="fas fa-crown"></i> Master Users</h1>
        
        <div class="action-buttons">
            <?php if (!in_array($roleName, ['CS Admin'])): ?>
                <a href="javascript:void(0);" data-export-type="csv" id="export_master_users" class="btn-action btn-action-success">
                    <i class="fas fa-file-export"></i> Export
                </a>
            <?php endif; ?>
            <a href="<?php echo base_url() ?>order/admin/add-new-master-user" class="btn-action btn-action-primary">
                <i class="fas fa-plus"></i> Add New Master User
            </a>
        </div>
    </div>

    <!-- Master Users Table Card -->
    <div class="modern-card">
        <div class="modern-card-header">
            <h2><i class="fas fa-users"></i> Master Users Listing</h2>
        </div>
        <div class="modern-card-body">
            <div id="master_users_success_msg" class="alert-modern alert-success-modern" style="display:none;"></div>
            <div id="master_users_error_msg" class="alert-modern alert-danger-modern" style="display:none;"></div>
            
            <div class="table-responsive">
                <table class="table table-bordered" id="tbl-master-users-listing" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>First Name</th>
                            <th>Last Name</th>
                            <th>Email</th>
                            <th>Address</th>
                            <th>Action</th>
                        </tr>
                    </thead>                
                    <tbody></tbody>
                </table>
            </div>
        </div>
    </div>
</div>