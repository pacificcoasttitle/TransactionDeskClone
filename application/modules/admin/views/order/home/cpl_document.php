<?php 
    $userdata = $this->session->userdata('admin');
	$roleList = $this->common_lib->getRoleList();
	$role_id = isset($userdata['role_id']) ? $userdata['role_id'] : 0;
	$roleName = $roleList[$role_id];
?>

<div class="pct-admin-listing">
    <!-- Page Header -->
    <div class="page-header">
        <h1><i class="fas fa-shield-alt"></i> CPL Documents</h1>
        <?php  if (!in_array($roleName, ['CS Admin'])) : ?>
            <div class="action-buttons">
                <a href="javascript:void(0);" data-export-type="csv" id="export_cpl_documents" class="btn-action btn-action-success">
                    <i class="fas fa-file-export"></i> Export
                </a>
            </div>
        <?php endif; ?>
    </div>

    <!-- CPL Documents Table Card -->
    <div class="modern-card">
        <div class="modern-card-header">
            <h2><i class="fas fa-list-alt"></i> CPL Documents</h2>
        </div>
        <div class="modern-card-body">
            <div id="cpl_document_success_msg" class="alert-modern alert-success-modern" style="display:none;"></div>
            <div id="cpl_document_error_msg" class="alert-modern alert-danger-modern" style="display:none;"></div>
            
            <div class="table-responsive">
                <table class="table table-bordered" id="tbl-cpl-documents-listing" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Sr No</th>
                            <th>File Number</th>
                            <th>Document Name</th>
                            <th>Sent To Softpro</th>
                            <th>Created At</th>
                            <th>Action</th>
                        </tr>
                    </thead>                
                    <tbody></tbody>
                </table>
            </div>
        </div>
    </div>
</div>