

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