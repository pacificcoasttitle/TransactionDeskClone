<?php
$userdata = $this->session->userdata('admin');
$roleList = $this->common_lib->getRoleList();
$role_id = isset($userdata['role_id']) ? $userdata['role_id'] : 0;
$roleName = $roleList[$role_id];
?>

<div class="pct-admin-listing">
    <!-- Page Header -->
    <div class="page-header">
        <h1><i class="fas fa-building"></i> Companies</h1>
        
        <div class="action-buttons">
            <a href="<?php echo base_url() ?>order/admin/softpro-add-company" class="btn-action btn-action-primary">
                <i class="fas fa-plus"></i> Add Company
            </a>
        </div>
    </div>

    <!-- Companies Table Card -->
    <div class="modern-card">
        <div class="modern-card-header">
            <h2><i class="fas fa-building"></i> Softpro Companies</h2>
        </div>
        <div class="modern-card-body">
            <?php if (!empty($success)) { ?>
                <div class="alert-modern alert-success-modern"><?php echo $success; ?></div>
            <?php } ?>
            <?php if (!empty($errors)) { ?>
                <div class="alert-modern alert-danger-modern"><?php echo $errors; ?></div>
            <?php } ?>
            
            <div id="companies_success_msg" class="alert-modern alert-success-modern" style="display:none;"></div>
            <div id="companies_error_msg" class="alert-modern alert-danger-modern" style="display:none;"></div>
            
            <div class="table-responsive">
                <table class="table table-bordered" id="tbl-softpro-companies-listing" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Sr No</th>
                            <th>Lookup Code</th>
                            <th>Company Name</th>
                            <th>Address</th>
                            <th>Sales Rep</th>
                            <th>Title Officer</th>
                            <th>Loan Underwriter</th>
                            <th>Sales Underwriter</th>
                            <th>Deliverables</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Deliverables Modal -->
<div class="modal fade pct-admin-listing" id="deliverables_information" tabindex="-1" role="dialog" aria-labelledby="Deliverables" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document" style="max-width: 500px;">
        <div class="modal-content">
            <form method="POST" action="<?php echo base_url(); ?>sp-store-deliverables">
                <div class="modal-header">
                    <h5 class="modal-title"><i class="fas fa-envelope mr-2"></i>Deliverables</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div id="deliverables-details-fields">
                        <div class="form-group">
                            <label class="font-weight-bold">Email Addresses</label>
                            <div id="clone_container">
                                <div class="input-group mb-2">
                                    <input type="email" class="form-control" name="AdditionalEmail[]" placeholder="Email Address">
                                    <div class="input-group-append">
                                        <button type="button" class="btn btn-primary clone"><i class="fa fa-plus"></i></button>
                                        <button type="button" class="btn btn-secondary delete"><i class="fa fa-minus"></i></button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <input type="hidden" id="lookup_code" name="lookup_code" value="">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">
                        <i class="fas fa-times mr-1"></i> Cancel
                    </button>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save mr-1"></i> Submit
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>