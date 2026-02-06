<style>
/* Modernized styles based on CPL page */
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
    padding-bottom: 2rem;
}

.pct-page-modern .ui-autocomplete { position: absolute; cursor: default; z-index: 10000 !important; max-height: 300px !important; overflow: hidden !important; }
.pct-page-modern .radio { top: 2px !important; margin: 0 0.5rem 0 0 !important; }
.pct-page-modern .radio:before { background: none !important; }
.pct-page-modern .fs-2 { font-size: 0.9375rem; }
.pct-page-modern .mt-0 { margin-top: 0; }
.pct-page-modern .error { color: #dc2626 !important; font-size: 0.8125rem; }

/* Section headings (taglines) */
.pct-page-modern .form-grp-title { margin-top: 1.5rem; margin-bottom: 1rem; }
.pct-page-modern .form-grp-title .tagline {
    height: 0;
    border-top: 1px solid var(--pct-border);
    text-align: left;
    margin: 0;
}
.pct-page-modern .form-grp-title .tagline span {
    display: inline-block;
    position: relative;
    padding: 0 0.75rem 0 0;
    background: var(--pct-surface);
    color: var(--pct-primary);
    top: -0.65em;
    font-size: 0.8125rem;
    font-weight: 600;
    letter-spacing: 0.03em;
    text-transform: uppercase;
}

/* Card */
.pct-page-modern .card.shadow.mb-4 {
    border: 1px solid var(--pct-border);
    border-radius: var(--pct-radius);
    box-shadow: var(--pct-shadow);
    overflow: hidden;
    background: var(--pct-surface);
}
.pct-page-modern .card-header.datatable-header {
    background: var(--pct-surface-2);
    border-bottom: 1px solid var(--pct-border);
    padding: 1rem 1.25rem;
}
.pct-page-modern .card-header.datatable-header h6 {
    font-size: 1rem;
    font-weight: 600;
    color: var(--pct-text);
    margin: 0;
}
.pct-page-modern .card-header .pl-10 { padding-left: 0.5rem; }
.pct-page-modern .card-body { padding: 1.25rem; }

/* Table */
.pct-page-modern #orders_listing thead th {
    background: var(--pct-surface-2);
    color: var(--pct-text);
    font-weight: 600;
    font-size: 0.8125rem;
    text-transform: uppercase;
    letter-spacing: 0.03em;
    border-bottom: 1px solid var(--pct-border);
    padding: 0.875rem 1rem;
}
.pct-page-modern #orders_listing tbody td {
    padding: 0.875rem 1rem;
    font-size: 0.875rem;
    color: var(--pct-text);
    border-bottom: 1px solid var(--pct-border);
    vertical-align: middle;
}
.pct-page-modern #orders_listing tbody tr:hover td { background: var(--pct-surface-2); }
.pct-page-modern td.dataTables_empty { display: table-cell !important; }

/* Pagination */
.pct-page-modern .dataTables_wrapper { padding-top: 0.75rem; }
.pct-page-modern .dataTables_wrapper .row:last-child {
    align-items: center;
    padding: 0.75rem 0;
    border-top: 1px solid var(--pct-border);
    margin-top: 0.5rem;
}
.pct-page-modern .dataTables_info { font-size: 0.8125rem; color: var(--pct-text-muted); font-weight: 500; }
.pct-page-modern .dataTables_paginate ul.pagination {
    margin: 0 !important;
    gap: 0.25rem;
    display: inline-flex;
    flex-wrap: wrap;
    justify-content: flex-end;
}
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
    transition: background .15s ease, border-color .15s ease, color .15s ease;
}
.pct-page-modern .dataTables_paginate .page-item .page-link:hover {
    background: var(--pct-surface-2);
    border-color: var(--pct-primary-soft);
    color: var(--pct-primary);
}
.pct-page-modern .dataTables_paginate .page-item.active .page-link {
    background: var(--pct-primary);
    border-color: var(--pct-primary);
    color: #fff;
}
.pct-page-modern .dataTables_paginate .page-item.disabled .page-link {
    background: var(--pct-surface-2);
    color: var(--pct-text-muted);
    border-color: var(--pct-border);
    opacity: 0.8;
}

/* Modals & Forms */
.modal-content { border-radius: 12px; border: 1px solid #e2e8f0; box-shadow: 0 4px 12px rgba(0,0,0,.08); }
.modal .card { border: none; box-shadow: none !important; }
.modal .card-body { padding: 1rem 1.25rem; }
.modal .card-header { background: transparent; border-bottom: 1px solid #e2e8f0; padding: 1rem; }
.modal .card-header h6 { color: #1e5f8a; font-size: 1rem; }

.form-control {
    padding: 0.5rem 0.75rem;
    font-size: 0.9375rem;
    border: 1px solid #e2e8f0;
    border-radius: 8px;
    color: #1e293b;
    background: #fff;
}
.form-control:focus {
    border-color: #e8f2f8;
    outline: 0;
    box-shadow: 0 0 0 3px rgba(30, 95, 138, 0.1);
}
.col-form-label { font-size: 0.875rem; font-weight: 500; color: #1e293b; margin-bottom: 0.25rem; }
.btn { font-weight: 500; font-size: 0.875rem; border-radius: 8px; }
.btn-success { background: #059669; border-color: #059669; color: #fff; }
.btn-success:hover { background: #047857; border-color: #047857; color: #fff; }
.btn-danger { background: #dc2626; border-color: #dc2626; color: #fff; }
.btn-danger:hover { background: #b91c1c; border-color: #b91c1c; color: #fff; }
.btn-icon-split .text { font-size: 0.75rem; padding: 0.4rem 4px; }

/* Modal Taglines */
.modal .form-grp-title .tagline span { color: #1e5f8a; font-size: 0.8125rem; font-weight: 600; background: #fff; }
.modal .form-grp-title .tagline { border-top-color: #e2e8f0; }

</style>

<div class="pct-page-modern">
<section class="section-type-4a section-defaulta" style="padding-bottom:0;">
    <div class="container-fluid px-4 py-4">
        <div class="row mb-4">
            <div class="col-12">
                <h1 class="pct-page-title" style="font-size:1.5rem;font-weight:600;color:#1e293b;margin-bottom:0;">Proposed Insured</h1>
            </div>
        </div>
        <div class="card shadow mb-4">
            <div class="card-header datatable-header">
                <div class="datatable-header-titles">
                    <span><i class="fas fa-file"></i></span>
                    <h6 class="m-0 font-weight-bold text-primary pl-10">Generate Proposed Insured</h6>
                </div>
            </div>
        
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="orders_listing" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>File Number</th>
                                <th>Property Address</th>
                                <th>Created</th>
                                <th style="text-align: center;">Action</th>
                            </tr>
                        </thead>                
                        <tbody></tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</section>
</div>

<!-- Add Order Modal -->
<div class="modal fade" id="lender_information" tabindex="-1" role="dialog" aria-labelledby="Lender Information" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <form method="POST" id="add-order-details" enctype="multipart/form-data">
                <div class="card shadow">
                    <!-- <div class="card-header"><h6 class="m-0 font-weight-bold text-primary">Lender Details</h6></div> -->
                    <div class="card-body"> 
                        <div class="smart-container">
                            <div class="modal-body search-result">

                                <input type="hidden" name="orderId" value="" id="orderId">
                                <input type="hidden" name="fileNumber" value="" id="fileNumber">
                                <input type="hidden" name="property_id" value="" id="property_id">
                                <input type="hidden" name="transaction_id" value="" id="transaction_id">
                                <input type="hidden" name="LenderCompanyId" value="" id="LenderCompanyId">
                                <input type="hidden" name="LenderCompanyLookupCode" value="" id="LenderCompanyLookupCode">
                                <input type="hidden" name="partner_id" id="partner_id" value="">
                                <input type="hidden" name="state" id="state" value="">
                                
                                <div class="form-group">
                                    <div class="row form-grp-title mt-0">
                                        <div class="col-sm-12">
                                            <div class="tagline"><span> LENDER DETAILS </span></div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-12 d-flex align-items-center">
                                            <div class="custom-control custom-radio custom-control-inline d-flex align-items-center">
                                                <input class="radio" type="radio" name="new_existing_lender" id="add_lender" value="add_lender">
                                                <label class="mb-0" for="add_lender">New Lender</label>
                                            </div>
                                            <div class="custom-control custom-radio custom-control-inline d-flex align-items-center ml-3">
                                                <input class="radio" type="radio" name="new_existing_lender" id="existing_lender" value="existing_lender">
                                                <label class="mb-0" for="existing_lender">Existing Lender</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <label for="LenderCompany" class="col-form-label">Lender Company</label>
                                            <input type="text" name="LenderCompany" id="LenderCompany" class="form-control gui-input ui-autocomplete-input" placeholder="Lender Company Name" required="required">
                                        </div>
                                    </div>
                                    <div class="row mt-3">
                                        <div class="col-sm-12">
                                            <label for="assignment_clause" class="col-form-label">Assignment Clause</label>
                                            <input type="text" name="assignment_clause" id="assignment_clause" class="form-control gui-input ui-autocomplete-input" placeholder="Assignment Clause">
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <label for="LenderAddress" class="col-form-label">Lender Address</label>
                                            <input type="text" name="LenderAddress" id="LenderAddress" class="form-control" placeholder="Lender Address" required="required">
                                        </div>
                                        <div class="col-sm-6">
                                            <label for="LenderCity" class="col-form-label">Lender City</label>
                                            <input type="text" name="LenderCity" id="LenderCity" class="form-control" placeholder="Lender City" required="required">
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <label for="LenderState" class="col-form-label">Lender State</label>
                                            <input type="text" name="LenderState" id="LenderState" class="form-control" placeholder="Lender State">
                                        </div>
                                        <div class="col-sm-6">
                                            <label for="LenderZipcode" class="col-form-label">Lender Zipcode</label>
                                            <input type="text" name="LenderZipcode" id="LenderZipcode" class="form-control" placeholder="Lender Zipcode" required="required">
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="row form-grp-title">
                                        <div class="col-sm-12">
                                            <div class="tagline"><span> PROPERTY DETAILS </span></div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <label for="property_address" class="col-form-label">Property Address</label>
                                            <input required="required" type="text" class="form-control" name="property_address" id="property_address" placeholder="Property Address">
                                        </div>
                                        <div class="col-sm-6">
                                            <label for="property_city" class="col-form-label">Property City</label>
                                            <input type="text" name="property_city" id="property_city" class="form-control" placeholder="Property City" required="required">
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <label for="property_state" class="col-form-label">Property State</label>
                                            <input type="text" name="property_state" id="property_state" class="form-control" placeholder="Property State" required="required">
                                        </div>
                                        <div class="col-sm-6">
                                            <label for="property_zipcode" class="col-form-label">Property Zipcode</label>
                                            <input type="text" name="property_zipcode" id="property_zipcode" class="form-control" placeholder="Property Zipcode" required="required">
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="row form-grp-title">
                                        <div class="col-sm-12">
                                            <div class="tagline"><span> TITLE OFFICER DETAILS </span></div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <label for="titleOfficer" class="col-form-label">Title Officer Details</label>
                                            <select id="titleOfficer" name="titleOfficer" class="form-control">
                                                <option value="">Title Officer</option>
                                                <?php 
                                                if(isset($titleOfficer) && !empty($titleOfficer))
                                                {
                                                    foreach ($titleOfficer as $key => $value) 
                                                    {
                                                ?>
                                                        <option value="<?php echo $value['id']; ?>"><?php echo $value['name']; ?></option>
                                                <?php
                                                    }
                                                }
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="row form-grp-title">
                                        <div class="col-sm-12">
                                            <div class="tagline"><span> LOAN DETAILS </span></div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <label for="loan_amount" class="col-form-label">Loan Amount</label>
                                            <input required="required" type="text" class="form-control" name="loan_amount" id="loan_amount" placeholder="Loan Amount">
                                        </div>
                                        <div class="col-sm-6">
                                            <label for="loan_number" class="col-form-label">Loan Number</label>
                                            <input required="required" type="text" class="form-control" name="loan_number" id="loan_number" placeholder="Loan Number">
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="row form-grp-title">
                                        <div class="col-sm-12">
                                            <div class="tagline"><span> BORROWERS & VESTING </span></div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <label for="borrowers_vesting" class="col-form-label">Primary Borrower Name</label>
                                            <input type="text" name="borrowers_vesting" id="borrowers_vesting" class="form-control" placeholder="Primary Borrower Name" required="required">
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="form-group">
                                    <div class="row form-grp-title">
                                        <div class="col-sm-12">
                                            <div class="tagline"><span> REPORT DATE SECTION </span></div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <label for="supplemental_report_date" class="col-form-label">Supplemental Report Date</label>
                                            <input required="required" type="text" class="form-control" name="supplemental_report_date" id="supplemental_report_date" placeholder="Supplemental Report Date" value="<?php echo date('m/d/Y'); ?>">
                                        </div>
                                    </div>
                                    <div class="row" style="display:none;">
                                        <div class="col-sm-6">
                                            <label for="preliminary_report_date" class="col-form-label">Preliminary Report Date</label>
                                            <input required="required" type="text" class="form-control" name="preliminary_report_date" id="preliminary_report_date" placeholder="Preliminary Report Date" value="<?php echo date('m/d/Y'); ?>">
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="row form-grp-title">
                                        <div class="col-sm-12">
                                            <div class="tagline"><span> SELECT BRANCH </span></div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <label for="branch" class="col-form-label">Select Branch</label>
                                            <select id="branch" name="branch" class="form-control">
                                                <option value="">Select Branch</option>
                                                <?php 
                                                    if (isset($proposedBranches) && !empty($proposedBranches)) {
                                                        foreach ($proposedBranches as $proposedBranch) {
                                                ?>
                                                    <option value="<?php echo $proposedBranch['id']; ?>"><?php echo $proposedBranch['city']; ?></option>
                                                <?php
                                                        }
                                                    }
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                            </div>
                            <!-- Form Footer -->
                            <div class="form-footer" style="padding: 1rem !important; text-align: right;">
                                <button type="submit" data-btntext-sending="Sending..." class="btn btn-success btn-icon-split btn-sm">
                                    <span class="icon text-white-50"><i class="fas fa-check"></i></span>
                                    <span class="text">Submit</span>
                                </button>
                                <button type="reset" data-dismiss="modal" aria-label="Close" class="btn btn-danger btn-icon-split btn-sm">
                                    <span class="icon text-white-50"><i class="fas fa-ban"></i></span>
                                    <span class="text">Cancel</span>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Edit Order Modal -->
<div class="modal fade" id="edit_information" tabindex="-1" role="dialog" aria-labelledby="Edit Information" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <form method="POST" id="edit-order-details" enctype="multipart/form-data">
                <div class="card shadow">
                    <!-- <div class="card-header"><h6 class="m-0 font-weight-bold text-primary">Lender Details</h6></div> -->
                    <div class="card-body"> 
                        <div class="smart-container">
                            <div class="modal-body search-result">

                                <input type="hidden" name="orderId" value="" id="edit_orderId">
                                <input type="hidden" name="fileNumber" value="" id="edit_fileNumber">
                                <input type="hidden" name="property_id" value="" id="edit_property_id">
                                <input type="hidden" id="edit_transaction_id" value="" name="transaction_id">
                                <input type="hidden" name="LenderCompanyId" value="" id="edit_LenderCompanyId">
                                <input type="hidden" name="LenderCompanyLookupCode" value="" id="edit_LenderCompanyLookupCode">
                                <input type="hidden" name="fileId" value="" id="edit_fileId">
                                <input type="hidden" name="partner_id" id="edit_partner_id" value="">    
                                <input type="hidden" name="state" id="edit_state" value="">
                                
                                <div class="form-group">
                                    <div class="row form-grp-title mt-0">
                                        <div class="col-sm-12">
                                            <div class="tagline"><span> LENDER DETAILS </span></div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-12 d-flex align-items-center">
                                            <div class="custom-control custom-radio custom-control-inline d-flex align-items-center">
                                                <input class="radio" type="radio" name="edit_new_existing_lender" id="edit_add_lender" value="add_lender">
                                                <label class="mb-0" for="edit_add_lender">New Lender</label>
                                            </div>
                                            <div class="custom-control custom-radio custom-control-inline d-flex align-items-center ml-3">
                                                <input class="radio" type="radio" name="edit_new_existing_lender" id="edit_existing_lender" value="existing_lender">
                                                <label class="mb-0" for="edit_existing_lender">Existing Lender</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <label for="edit_LenderCompany" class="col-form-label">Lender Company</label>
                                            <input type="text" name="LenderCompany" id="edit_LenderCompany" class="form-control gui-input ui-autocomplete-input" placeholder="Lender Company Name" required="required">
                                        </div>
                                    </div>
                                    <div class="row mt-3">
                                        <div class="col-sm-12">
                                            <label for="edit_assignment_clause" class="col-form-label">Assignment Clause</label>
                                            <input type="text" name="assignment_clause" id="edit_assignment_clause" class="form-control gui-input ui-autocomplete-input" placeholder="Assignment Clause">
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <label for="edit_LenderAddress" class="col-form-label">Lender Address</label>
                                            <input type="text" name="LenderAddress" id="edit_LenderAddress" class="form-control" placeholder="Lender Address" required="required">
                                        </div>
                                        <div class="col-sm-6">
                                            <label for="edit_LenderCity" class="col-form-label">Lender City</label>
                                            <input type="text" name="LenderCity" id="edit_LenderCity" class="form-control" placeholder="Lender City" required="required">
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <label for="edit_LenderState" class="col-form-label">Lender State</label>
                                            <input type="text" name="LenderState" id="edit_LenderState" class="form-control" placeholder="Lender State">
                                        </div>
                                        <div class="col-sm-6">
                                            <label for="edit_LenderZipcode" class="col-form-label">Lender Zipcode</label>
                                            <input type="text" name="LenderZipcode" id="edit_LenderZipcode" class="form-control" placeholder="Lender Zipcode" required="required">
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="row form-grp-title">
                                        <div class="col-sm-12">
                                            <div class="tagline"><span> PROPERTY DETAILS </span></div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <label for="edit_property_address" class="col-form-label">Property Address</label>
                                            <input required="required" type="text" class="form-control" name="property_address" id="edit_property_address" placeholder="Property Address">
                                        </div>
                                        <div class="col-sm-6">
                                            <label for="edit_property_city" class="col-form-label">Property City</label>
                                            <input type="text" name="property_city" id="edit_property_city" class="form-control" placeholder="Property City" required="required">
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <label for="edit_property_state" class="col-form-label">Property State</label>
                                            <input type="text" name="property_state" id="edit_property_state" class="form-control" placeholder="Property State" required="required">
                                        </div>
                                        <div class="col-sm-6">
                                            <label for="edit_property_zipcode" class="col-form-label">Property Zipcode</label>
                                            <input type="text" name="property_zipcode" id="edit_property_zipcode" class="form-control" placeholder="Property Zipcode" required="required">
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="row form-grp-title">
                                        <div class="col-sm-12">
                                            <div class="tagline"><span> TITLE OFFICER DETAILS </span></div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <label for="edit_TitleOfficer" class="col-form-label">Title Officer Details</label>
                                            <select id="edit_TitleOfficer" name="titleOfficer" class="form-control">
                                                <option value="">Title Officer</option>
                                                <?php 
                                                if(isset($titleOfficer) && !empty($titleOfficer))
                                                {
                                                    foreach ($titleOfficer as $key => $value) 
                                                    {
                                                ?>
                                                        <option value="<?php echo $value['id']; ?>"><?php echo $value['name']; ?></option>
                                                <?php
                                                    }
                                                }
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="row form-grp-title">
                                        <div class="col-sm-12">
                                            <div class="tagline"><span> LOAN DETAILS </span></div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <label for="edit_loan_amount" class="col-form-label">Loan Amount</label>
                                            <input required="required" type="text" class="form-control" name="loan_amount" id="edit_loan_amount" placeholder="Loan Amount">
                                        </div>
                                        <div class="col-sm-6">
                                            <label for="edit_loan_number" class="col-form-label">Loan Number</label>
                                            <input required="required" type="text" class="form-control" name="loan_number" id="edit_loan_number" placeholder="Loan Number">
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="row form-grp-title">
                                        <div class="col-sm-12">
                                            <div class="tagline"><span> BORROWERS & VESTING </span></div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <label for="edit_borrowers_vesting" class="col-form-label">Primary Borrower Name</label>
                                            <input type="text" name="borrowers_vesting" id="edit_borrowers_vesting" class="form-control" placeholder="Primary Borrower Name" required="required">
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="form-group">
                                    <div class="row form-grp-title">
                                        <div class="col-sm-12">
                                            <div class="tagline"><span> REPORT DATE SECTION </span></div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <label for="edit_supplemental_report_date" class="col-form-label">Supplemental Report Date</label>
                                            <input required="required" type="text" class="form-control" name="supplemental_report_date" id="edit_supplemental_report_date" placeholder="Supplemental Report Date" value="<?php echo date('m/d/Y'); ?>">
                                        </div>
                                    </div>
                                    <div class="row" style="display:none;">
                                        <div class="col-sm-6">
                                            <label for="edit_preliminary_report_date" class="col-form-label">Preliminary Report Date</label>
                                            <input required="required" type="text" class="form-control" name="preliminary_report_date" id="edit_preliminary_report_date" placeholder="Preliminary Report Date" value="<?php echo date('m/d/Y'); ?>">
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="row form-grp-title">
                                        <div class="col-sm-12">
                                            <div class="tagline"><span> SELECT BRANCH </span></div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <label for="edit_branch" class="col-form-label">Select Branch</label>
                                            <select id="edit_branch" name="edit_branch" class="form-control">
                                                <option value="">Select Branch</option>
                                                <?php 
                                                    if (isset($proposedBranches) && !empty($proposedBranches)) {
                                                        foreach ($proposedBranches as $proposedBranch) {
                                                ?>
                                                    <option value="<?php echo $proposedBranch['id']; ?>"><?php echo $proposedBranch['city']; ?></option>
                                                <?php
                                                        }
                                                    }
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                            </div>
                            <!-- Form Footer -->
                            <div class="form-footer" style="padding: 1rem !important; text-align: right;">
                                <button type="submit" data-btntext-sending="Sending..." class="btn btn-success btn-icon-split btn-sm">
                                    <span class="icon text-white-50"><i class="fas fa-check"></i></span>
                                    <span class="text">Submit</span>
                                </button>
                                <button type="reset" data-dismiss="modal" aria-label="Close" class="btn btn-danger btn-icon-split btn-sm">
                                    <span class="icon text-white-50"><i class="fas fa-ban"></i></span>
                                    <span class="text">Cancel</span>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
