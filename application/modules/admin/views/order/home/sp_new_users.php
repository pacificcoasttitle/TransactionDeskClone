<?php 
    $userdata = $this->session->userdata('admin');
    $roleList = $this->common_lib->getRoleList();
    $role_id = isset($userdata['role_id']) ? $userdata['role_id'] : 0;
    $roleName = $roleList[$role_id];
?>

<div class="pct-admin-listing">
    <!-- Page Header -->
    <div class="page-header">
        <h1><i class="fas fa-user-plus"></i> New Users</h1>
        
        <div class="action-buttons">
            <?php if (!in_array($roleName, ['CS Admin'])): ?>
                <a href="javascript:void(0);" data-export-type="csv" id="export_new_user" class="btn-action btn-action-success">
                    <i class="fas fa-file-export"></i> Export
                </a>
            <?php endif; ?>
            <a href="<?php echo base_url() ?>order/admin/add-softpro-new-user" class="btn-action btn-action-primary">
                <i class="fas fa-plus"></i> Add New User
            </a>
        </div>
    </div>

    <!-- New Users Table Card -->
    <div class="modern-card">
        <div class="modern-card-header">
            <h2><i class="fas fa-users"></i> New Users Listing</h2>
        </div>
        <div class="modern-card-body">
            <div id="customer_success_msg" class="alert-modern alert-success-modern" style="display:none;"></div>
            <div id="customer_error_msg" class="alert-modern alert-danger-modern" style="display:none;"></div>
            
            <div class="table-responsive">
                <table class="table table-bordered" id="tbl-sp-new-users-listing" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Lookup Code</th>
                            <th class="not-take">First Name</th>
                            <th class="not-take">Last Name</th>
                            <th>Email</th>
                            <th class="not-take">Company</th>
                            <th class="not-take">Action</th>
                        </tr>
                    </thead>                
                    <tbody></tbody>
                </table>
            </div>
        </div>
    </div>
</div>