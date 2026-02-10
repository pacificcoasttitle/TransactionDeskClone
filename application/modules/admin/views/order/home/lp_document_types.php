<div class="pct-admin-listing">
    <!-- Session/Error Messages -->
    <?php if(!empty($this->session->userdata('success'))){ ?>
        <div class="alert-modern alert-success-modern"><?php echo $this->session->userdata('success'); ?></div>
    <?php } ?>

    <?php if(!empty($error_msg)){ ?>
        <div class="alert-modern alert-danger-modern"><?php echo $error_msg; ?></div>
    <?php } ?>

    <div id="lp_order_success_msg" class="alert-modern alert-success-modern" style="display:none;"></div>
    <div id="lp_order_error_msg" class="alert-modern alert-danger-modern" style="display:none;"></div>

    <!-- Page Header -->
    <div class="page-header">
        <h1><i class="fas fa-file-alt"></i> LP Document Types</h1>
        <div class="action-buttons">
            <a href="<?php echo base_url()?>order/admin/add-lp-document-types" class="btn-action btn-action-success">
                <i class="fas fa-plus"></i> Add LP Document Type
            </a>
            <a href="<?php echo base_url()?>order/admin/import-lp-document-types" class="btn-action btn-action-success">
                <i class="fas fa-file-import"></i> Import
            </a>
        </div>
    </div>

    <!-- LP Document Types Table Card -->
    <div class="modern-card">
        <div class="modern-card-header">
            <h2><i class="fas fa-list-alt"></i> LP Document Types</h2>
        </div>
        <div class="modern-card-body">
            <div id="lp_document_types_success_msg" class="alert-modern alert-success-modern" style="display:none;"></div>
            <div id="lp_document_types_error_msg" class="alert-modern alert-danger-modern" style="display:none;"></div>
            <div class="table-responsive">
                <table class="table table-bordered" id="tbl-lp-document-types-listing" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Sr No</th>
                            <th>Code</th>
                            <th>Instrument Type</th>
                            <th>Is Subtype</th>
                            <th>Selected Subtype Code</th>
                            <th>Select Section</th>
                            <th>Is Display</th>
                            <th>Is Ves</th>
                            <th>Action</th>
                        </tr>
                    </thead>                
                    <tbody></tbody>
                </table>
            </div>
        </div>
    </div>
</div>