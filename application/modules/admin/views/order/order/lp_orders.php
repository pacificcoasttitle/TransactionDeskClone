<?php
$salesRep = isset($salesRep['data']) && !empty($salesRep['data']) ? $salesRep['data'] : array();
$product_type = isset($product_type) && !empty($product_type) ? $product_type : '';
$sales_rep = json_encode($salesRep);
$master_users = json_encode($master_users);

$userdata = $this->session->userdata('admin');
$roleList = $this->common_lib->getRoleList();
$role_id = isset($userdata['role_id']) ? $userdata['role_id'] : 0;
$roleName = $roleList[$role_id];
?>
<script type="text/javascript">
    // var sales_rep = '<?php echo $sales_rep; ?>';
    var sales_rep = <?php echo json_encode($sales_rep, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP); ?>;
    console.log('sales_rep ===', sales_rep);
    var lp_master_users = '<?php echo $master_users; ?>';
    var lp_product_type = '<?php echo $product_type; ?>';
</script>

<style>
    /* Additional styles for LP Orders specific modal widths */
    @media (min-width: 992px) {
        .modal-lg { max-width: 1400px !important; }
    }
    .ui-autocomplete { max-height: 300px !important; }
    input[type=checkbox] { height: 20px !important; width: 20px !important; }
</style>

<div class="pct-admin-listing">
    <!-- Page Header -->
    <div class="page-header">
        <h1><i class="fas fa-file-alt"></i> LP Orders</h1>
        
        <?php if (!in_array($roleName, ['CS Admin'])): ?>
        <div class="action-buttons">
            <a href="javascript:void(0);" data-export-type="csv" onclick="exportLPOrders();" id="export-orders-data" class="btn-action btn-action-success">
                <i class="fas fa-file-export"></i> Export
            </a>
        </div>
        <?php endif; ?>
    </div>

    <!-- LP Orders Table Card -->
    <div class="modern-card">
        <div class="modern-card-header">
            <h2><i class="fas fa-table"></i> LP Orders Listing</h2>
        </div>
        <div class="modern-card-body">
            <?php if (!empty($success)) { ?>
                <div class="alert-modern alert-success-modern"><?php echo $success; ?></div>
            <?php } ?>
            <?php if (!empty($errors)) { ?>
                <div class="alert-modern alert-danger-modern"><?php echo $errors; ?></div>
            <?php } ?>
            
            <div id="lp_order_success_msg" class="alert-modern alert-success-modern" style="display:none;"></div>
            <div id="lp_order_error_msg" class="alert-modern alert-danger-modern" style="display:none;"></div>
            
            <div class="table-responsive">
                <table class="table table-bordered" id="tbl-lp-orders-listing" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Sr No</th>
                            <th>Order#</th>
                            <th>Property Address</th>
                            <th>Product Type</th>
                            <th>Sales Rep</th>
                            <th>Created By</th>
                            <th>Email Status</th>
                            <th>Report Status</th>
                            <th>Avoid Duplication</th>
                            <th>Sync To Resware / Softpro</th>
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

<!-- Instrument Selection Modal -->
<div class="modal fade pct-admin-listing" id="instrument_model" tabindex="-1" role="dialog" aria-labelledby="Lender Information" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
            <form method="POST" action="<?php echo base_url(); ?>order/admin/store-lp-document-info">
                <div class="modal-header">
                    <h5 class="modal-title"><i class="fas fa-file-alt mr-2"></i>Select Documents</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div id="instrument_number_container"></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">
                        <i class="fas fa-times mr-1"></i> Cancel
                    </button>
                    <button type="submit" class="btn btn-success">
                        <i class="fas fa-check mr-1"></i> Submit
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Vesting Info Modal -->
<div class="modal fade pct-admin-listing" id="vesting_model" tabindex="-1" role="dialog" aria-labelledby="Vesting Information" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document" style="max-width: 500px;">
        <div class="modal-content">
            <form method="POST" action="<?php echo base_url(); ?>order/admin/store-vesting-info">
                <div class="modal-header">
                    <h5 class="modal-title"><i class="fas fa-user-check mr-2"></i>Add Vesting Info</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="vesting_info" class="font-weight-bold">Vesting Information</label>
                        <textarea id="vesting_info" name="vesting_info" class="form-control" rows="6" required></textarea>
                    </div>
                    <input type="hidden" name="order_id" id="order_id" value="">
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

<!-- File Upload Modal -->
<div class="modal fade pct-admin-listing" id="fileUploadModel" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document" style="max-width: 700px;">
        <div class="modal-content">
            <form method="post" id="instrument-file-upload-form" name="instrument-file-upload-form" enctype="multipart/form-data" action="<?php echo base_url(); ?>order/admin/add-instrument-info">
                <div class="modal-header">
                    <h5 class="modal-title"><i class="fas fa-upload mr-2"></i>Add Document</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="document_type" class="font-weight-bold">Document Type</label>
                                <input name="document_type" required type="text" class="form-control" id="document_type">
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="document_sub_type" class="font-weight-bold">Document Sub Type</label>
                                <input name="document_sub_type" type="text" class="form-control" id="document_sub_type">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="instrument_number" class="font-weight-bold">Instrument Number</label>
                                <input required name="instrument_number" type="text" id="instrument_number" class="form-control">
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="recorded_date" class="font-weight-bold">Recorded Date</label>
                                <input required name="recorded_date" type="text" id="recorded_date" class="form-control">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="amount" class="font-weight-bold">Amount</label>
                                <input name="amount" type="text" class="form-control" id="amount">
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="parties" class="font-weight-bold">Parties</label>
                                <input required name="parties" type="text" id="parties" class="form-control">
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="file_upload" class="font-weight-bold">Upload File</label>
                        <input required name="file_upload" type="file" id="file_upload" class="form-control" accept="application/pdf">
                    </div>
                    <input type="hidden" name="upload_order_id" id="upload_order_id" value="">
                    <input type="hidden" name="document_name" id="document_name" value="">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">
                        <i class="fas fa-times mr-1"></i> Cancel
                    </button>
                    <button type="submit" class="btn btn-success">
                        <i class="fas fa-check mr-1"></i> Submit
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Change Client Modal -->
<div class="modal fade pct-admin-listing" id="changeClientModel" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document" style="max-width: 600px;">
        <div class="modal-content">
            <form method="post" enctype="multipart/form-data" action="<?php echo base_url(); ?>order/admin/change-client">
                <div class="modal-header">
                    <h5 class="modal-title"><i class="fas fa-user-edit mr-2"></i>Change Client</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="company_name" class="font-weight-bold">Company Name</label>
                        <input name="company_name" required type="text" class="form-control" id="company_name">
                    </div>
                    <div class="form-group">
                        <label for="email_address" class="font-weight-bold">Email Address</label>
                        <input name="email_address" required type="email" class="form-control" id="email_address">
                    </div>
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="first_name" class="font-weight-bold">First Name</label>
                                <input name="first_name" required type="text" class="form-control" id="first_name">
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="last_name" class="font-weight-bold">Last Name</label>
                                <input name="last_name" required type="text" class="form-control" id="last_name">
                            </div>
                        </div>
                    </div>
                    <input type="hidden" name="client_id" id="client_id" value="">
                    <input type="hidden" name="client_order_id" id="client_order_id" value="">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">
                        <i class="fas fa-times mr-1"></i> Cancel
                    </button>
                    <button type="submit" class="btn btn-success">
                        <i class="fas fa-check mr-1"></i> Submit
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
