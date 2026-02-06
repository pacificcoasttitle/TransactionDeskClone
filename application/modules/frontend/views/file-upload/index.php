<style>
/* Modernized styles */
.pct-page-modern {
    --pct-primary: #1e5f8a;
    --pct-primary-light: #2d7ab5;
    --pct-primary-soft: #e8f2f8;
    --pct-surface: #ffffff;
    --pct-surface-2: #f8fafc;
    --pct-text: #1e293b;
    --pct-text-muted: #64748b;
    --pct-border: #e2e8f0;
    --pct-radius: 12px;
    --pct-radius-sm: 8px;
    --pct-shadow: 0 1px 3px rgba(0,0,0,.06);
    font-family: 'Nunito', -apple-system, BlinkMacSystemFont, 'Segoe UI', system-ui, sans-serif;
    background: var(--pct-surface-2);
    min-height: 100vh;
    padding-bottom: 2rem;
}

/* Card */
.pct-page-modern .card.shadow {
    border: 1px solid var(--pct-border);
    border-radius: var(--pct-radius);
    box-shadow: var(--pct-shadow);
    overflow: hidden;
    background: var(--pct-surface);
}
.pct-page-modern .card-header {
    background: var(--pct-surface-2);
    border-bottom: 1px solid var(--pct-border);
    padding: 1rem 1.25rem;
}
.pct-page-modern .card-body { padding: 1.5rem; }

/* In-Page Headers */
.pct-page-modern .section-title {
    font-size: 1.25rem;
    font-weight: 700;
    color: var(--pct-text);
    margin-bottom: 1rem;
    display: flex;
    align-items: center;
}
.pct-page-modern .section-title i {
    margin-right: 0.5rem;
    color: var(--pct-primary);
}

/* Forms */
.pct-page-modern .form-group { margin-bottom: 1.25rem; }
.pct-page-modern .form-label {
    font-size: 0.875rem;
    font-weight: 600;
    color: var(--pct-text);
    margin-bottom: 0.5rem;
    display: block;
}
.pct-page-modern .form-control {
    display: block;
    width: 100%;
    padding: 0.625rem 0.875rem;
    font-size: 0.9375rem;
    line-height: 1.5;
    color: var(--pct-text);
    background-color: #fff;
    background-clip: padding-box;
    border: 1px solid var(--pct-border);
    border-radius: var(--pct-radius-sm);
    transition: border-color .15s ease-in-out,box-shadow .15s ease-in-out;
}
.pct-page-modern .form-control:focus {
    color: var(--pct-text);
    background-color: #fff;
    border-color: var(--pct-primary-light);
    outline: 0;
    box-shadow: 0 0 0 3px var(--pct-primary-soft);
}

/* Upload Container */
.pct-page-modern .upload-container {
    border: 2px dashed var(--pct-border);
    border-radius: var(--pct-radius);
    background: var(--pct-surface-2);
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    padding: 2rem;
    min-height: 200px;
    width: 100%;
    transition: all 0.2s ease;
    cursor: pointer;
    position: relative;
    color: var(--pct-text-muted);
}
.pct-page-modern .upload-container:hover,
.pct-page-modern .upload-container.dragover {
    border-color: var(--pct-primary);
    background: var(--pct-primary-soft);
    color: var(--pct-primary);
}
.pct-page-modern .upload-container p { margin-bottom: 1rem; font-weight: 500; }
.pct-page-modern .file-list {
    display: flex;
    flex-wrap: wrap;
    gap: 1rem;
    margin-top: 1rem;
    width: 100%;
    justify-content: center;
}
.pct-page-modern .file-item {
    display: flex;
    flex-direction: column;
    align-items: center;
    width: 120px;
    text-align: center;
    background: #fff;
    padding: 0.5rem;
    border-radius: 8px;
    box-shadow: 0 1px 2px rgba(0,0,0,0.05);
    border: 1px solid var(--pct-border);
}
.pct-page-modern .file-icon { font-size: 2rem; color: var(--pct-primary); margin-bottom: 0.25rem; }
.pct-page-modern .file-name { font-size: 0.75rem; word-break: break-all; color: var(--pct-text); line-height: 1.2; }

/* Table */
.pct-page-modern .table-responsive { overflow-x: auto; }
.pct-page-modern .table { width: 100%; margin-bottom: 1rem; color: var(--pct-text); border-color: var(--pct-border); }
.pct-page-modern .table-bordered { border: 1px solid var(--pct-border); }
.pct-page-modern .table thead th {
    vertical-align: bottom;
    border-bottom: 2px solid var(--pct-border);
    background: var(--pct-surface-2);
    color: var(--pct-text);
    font-weight: 600;
    font-size: 0.8125rem;
    text-transform: uppercase;
    letter-spacing: 0.03em;
    padding: 0.875rem 1rem;
}
.pct-page-modern .table tbody td {
    padding: 0.875rem 1rem;
    vertical-align: middle;
    border-top: 1px solid var(--pct-border);
    font-size: 0.875rem;
}

/* Pagination - Standardized */
.pct-page-modern .dataTables_paginate .page-item .page-link {
    min-width: 2rem; height: 2rem;
    padding: 0 0.5rem;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    font-size: 0.8125rem;
    font-weight: 500;
    color: var(--pct-text);
    background: var(--pct-surface);
    border: 1px solid var(--pct-border);
    border-radius: var(--pct-radius-sm);
    transition: all .15s ease;
}
.pct-page-modern .dataTables_paginate .page-item.active .page-link {
    background: var(--pct-primary);
    border-color: var(--pct-primary);
    color: #fff;
}

/* Buttons */
.pct-page-modern .btn-icon-split {
    padding: 0;
    display: inline-flex;
    align-items: stretch;
    justify-content: center;
    overflow: hidden;
    border-radius: 8px;
}
.pct-page-modern .btn-icon-split .icon {
    background: rgba(0,0,0,0.15);
    display: flex;
    align-items: center;
    padding: 0.375rem 0.75rem;
}
.pct-page-modern .btn-icon-split .text {
    display: flex;
    align-items: center;
    padding: 0.375rem 0.75rem;
    font-size: 0.875rem;
    font-weight: 500;
}
.pct-page-modern .btn-primary { background: #1e5f8a; border-color: #1e5f8a; color: #fff; }
.pct-page-modern .btn-primary:hover { background: #164e73; border-color: #164e73; color: #fff; }
.pct-page-modern .btn-secondary { background: #64748b; border-color: #64748b; color: #fff; }
.pct-page-modern .btn-secondary:hover { background: #475569; border-color: #475569; color: #fff; }
.pct-page-modern .btn-info { background: #33C3F0; border-color: #33C3F0; color: #fff; } /* Preserving color but modernizing structure */
.pct-page-modern .btn-info:hover { background: #2CB3E0; border-color: #2CB3E0; }

</style>

<?php
$userdata = $this->session->userdata('user');
if ($userdata['is_sales_rep'] == 1) {
    $dashboardUrl = base_url() . 'sales-dashboard/' . $userdata['id'];
} else if ($userdata['is_title_officer'] == 1) {
    $dashboardUrl = base_url() . 'title-officer-dashboard';
} else if ($userdata['is_escrow_officer'] == 1) {
    $dashboardUrl = base_url() . 'escrow-dashboard';
} else if ($userdata['is_payoff_user'] == 1) {
    $dashboardUrl = base_url() . 'pay-off-dashboard';
} else if ($userdata['is_special_lender'] == 1) {
    $dashboardUrl = base_url() . 'special-lender-dashboard';
} else {
    $dashboardUrl = base_url() . 'dashboard';
}
?>

<div class="pct-page-modern">
    <div class="container-fluid px-4 py-4">
        
        <!-- Upload Section -->
        <div class="row justify-content-center mb-4">
            <div class="col-lg-12">
                <div class="card shadow">
                    <div class="card-header">
                        <h6 class="m-0 font-weight-bold text-primary">Upload Document</h6>
                    </div>
                    <div class="card-body">
                        <form method="POST" id="smart-form" enctype="multipart/form-data" novalidate="novalidate">
                            <?php $prev_data = $this->session->flashdata('_previous_data');?>
                            <?php if ($this->session->flashdata('error')): ?>
                                <div class="alert alert-danger" role="alert"><?php echo $this->session->flashdata('error'); ?></div>
                            <?php elseif ($this->session->flashdata('success')): ?>
                                <div class="alert alert-success" role="alert"><?php echo $this->session->flashdata('success'); ?></div>
                            <?php endif;?>

                            <div class="row">
                                <div class="col-md-5">
                                    <div class="form-group">
                                        <label class="form-label">Order Number</label>
                                        <input type="text" class="form-control" name="order_number" value="" placeholder="Enter Order Number">
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label">Document Name</label>
                                        <input type="text" class="form-control" name="document_name" value="" placeholder="Enter Document Name">
                                    </div>
                                    <div class="mt-4 d-flex align-items-center" style="gap: 1rem;">
                                        <button type="submit" id="submit-button" class="btn btn-info btn-icon-split">
                                            <span class="icon text-white-50">
                                                <i class="fas fa-save"></i>
                                            </span>
                                            <span class="text">Submit</span>
                                        </button>
                                        <a class="btn btn-secondary btn-icon-split" href="<?php echo $dashboardUrl; ?>">
                                            <span class="icon text-white-50">
                                                <i class="fas fa-arrow-left"></i>
                                            </span>
                                            <span class="text">Cancel</span>
                                        </a>
                                    </div>
                                </div>
                                <div class="col-md-7">
                                    <div class="form-group h-100">
                                        <div class="upload-container" id="upload-container">
                                            <i class="fas fa-cloud-upload-alt fa-3x mb-3" style="color: var(--pct-text-muted);"></i>
                                            <p>Drag files to upload, or</p>
                                            <a type="button" class="btn btn-primary btn-sm mb-3" id="browse-button">Browse Files</a>
                                            <input type="file" id="file-input" name="multiFiles[]" multiple style="display: none;">
                                            <div class="file-list" id="file-list"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Document List Section -->
        <div class="row">
            <div class="col-lg-12">
                <div class="card shadow">
                    <div class="card-header datatable-header py-3 d-flex align-items-center">
                         <span class="mr-2"><i class="fas fa-list text-primary"></i></span>
                         <h6 class="m-0 font-weight-bold text-primary">Document List</h6>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered" id="uploaded_document_list" width="100%" cellspacing="0">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Name</th>
                                        <th>File Number</th>
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
        </div>

    </div>
</div>