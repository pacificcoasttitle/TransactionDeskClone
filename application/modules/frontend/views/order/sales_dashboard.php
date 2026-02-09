<style>
/* Sales Dashboard – same design tokens as dashboard */
.pct-home-modern {
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

/* Page header */
.pct-home-modern .pct-page-title { font-size: 1.5rem; font-weight: 600; color: var(--pct-text); margin-bottom: 0.25rem; }
.pct-home-modern .pct-page-sub-row {
    display: flex;
    align-items: center;
    flex-wrap: wrap;
    gap: 1rem;
    margin-top: 0.25rem;
}
.pct-home-modern .pct-page-sub { font-size: 0.9375rem; color: var(--pct-text-muted); margin: 0; }
.pct-home-modern .month-name { color: var(--pct-primary); }

/* All dropdowns with arrow indicator */
.pct-home-modern select,
.pct-home-modern .custom-select {
    border: 1px solid var(--pct-border);
    border-radius: var(--pct-radius-sm);
    padding: 0.375rem 2rem 0.375rem 0.75rem;
    font-size: 0.875rem;
    color: var(--pct-text);
    background: var(--pct-surface) url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 12 12'%3E%3Cpath fill='%2364748b' d='M2 4l4 4 4-4'/%3E%3C/svg%3E") no-repeat right 0.75rem center;
    background-size: 12px;
    -webkit-appearance: none;
    -moz-appearance: none;
    appearance: none;
    cursor: pointer;
}
.pct-home-modern select:focus,
.pct-home-modern .custom-select:focus {
    border-color: var(--pct-primary);
    outline: 0;
    box-shadow: 0 0 0 3px rgba(30, 95, 138, 0.1);
}

/* User filter dropdown inline */
.pct-home-modern .sales-user-listing { margin: 0; }

/* Stat cards row titles */
.pct-home-modern .stat-title-row {
    display: flex;
    gap: 1rem;
    margin-bottom: 0.75rem;
}
.pct-home-modern .stat-title-row .title {
    font-size: 0.8125rem;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.03em;
}

/* Stat cards */
.pct-home-modern .stat-card {
    background: var(--pct-surface);
    border: 1px solid var(--pct-border);
    border-radius: var(--pct-radius);
    box-shadow: var(--pct-shadow);
    padding: 1.25rem;
    height: 100%;
    position: relative;
    overflow: hidden;
}
.pct-home-modern .stat-card::before {
    content: '';
    position: absolute;
    left: 0;
    top: 0;
    bottom: 0;
    width: 4px;
}
.pct-home-modern .stat-card.stat-primary::before { background: var(--pct-primary); }
.pct-home-modern .stat-card.stat-success::before { background: #059669; }
.pct-home-modern .stat-card.stat-info::before { background: #0891b2; }
.pct-home-modern .stat-card.stat-warning::before { background: #d97706; }

.pct-home-modern .sales_loan_count {
    font-size: 1.75rem;
    font-weight: 700;
    margin-bottom: 0.5rem;
}
.pct-home-modern .salesdivider { border-top: 1px solid var(--pct-border); padding-top: 0.75rem; margin-top: 0.5rem; }
.pct-home-modern .sales_loan_section { font-size: 0.875rem; font-weight: 500; color: var(--pct-text); margin-bottom: 0.25rem; }
.pct-home-modern .projected_goal_section { font-size: 0.75rem; color: var(--pct-text-muted); margin-top: 0.5rem; }

/* Card styling */
.pct-home-modern .card.shadow.mb-4 {
    border: 1px solid var(--pct-border);
    border-radius: var(--pct-radius);
    box-shadow: var(--pct-shadow);
    overflow: hidden;
}
.pct-home-modern .card-header.py-3 {
    background: var(--pct-surface-2);
    border-bottom: 1px solid var(--pct-border);
    padding: 1rem 1.25rem;
}
.pct-home-modern .card-header .font-weight-bold {
    font-size: 1rem;
    font-weight: 600;
    color: var(--pct-text);
}
.pct-home-modern .card-body { padding: 1.25rem; background: var(--pct-surface); }

/* Table styling */
.pct-home-modern .table { margin-bottom: 0; }
.pct-home-modern .table thead th {
    background: var(--pct-surface-2);
    border-bottom: 2px solid var(--pct-border);
    font-size: 0.8125rem;
    font-weight: 600;
    color: var(--pct-text);
    text-transform: uppercase;
    letter-spacing: 0.03em;
    padding: 0.75rem 1rem;
    white-space: nowrap;
}
.pct-home-modern .table tbody td {
    padding: 0.875rem 1rem;
    font-size: 0.9375rem;
    color: var(--pct-text);
    border-bottom: 1px solid var(--pct-border);
    vertical-align: middle;
}
.pct-home-modern .table tbody tr:hover { background: var(--pct-primary-soft); }

/* Pagination – same as cpl.php */
.pct-home-modern .dataTables_wrapper { padding-top: 0.75rem; }
.pct-home-modern .dataTables_wrapper .row:last-child {
    align-items: center;
    padding: 0.75rem 0;
    border-top: 1px solid var(--pct-border);
    margin-top: 0.5rem;
}
.pct-home-modern .dataTables_wrapper .dataTables_length select,
.pct-home-modern .dataTables_wrapper select,
.pct-home-modern .dataTables_wrapper .custom-select {
    border: 1px solid var(--pct-border);
    border-radius: var(--pct-radius-sm);
    padding: 0.375rem 2rem 0.375rem 0.75rem;
    font-size: 0.875rem;
    color: var(--pct-text);
    background: var(--pct-surface) url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 12 12'%3E%3Cpath fill='%2364748b' d='M2 4l4 4 4-4'/%3E%3C/svg%3E") no-repeat right 0.75rem center;
    background-size: 12px;
    -webkit-appearance: none;
    -moz-appearance: none;
    appearance: none;
    cursor: pointer;
}
.pct-home-modern .dataTables_wrapper .dataTables_filter input {
    border: 1px solid var(--pct-border);
    border-radius: var(--pct-radius-sm);
    padding: 0.375rem 0.75rem;
    font-size: 0.875rem;
    color: var(--pct-text);
    background: var(--pct-surface);
}
.pct-home-modern .dataTables_wrapper .dataTables_filter input:focus {
    border-color: var(--pct-primary);
    outline: 0;
    box-shadow: 0 0 0 3px rgba(30, 95, 138, 0.1);
}
.pct-home-modern .dataTables_info { font-size: 0.8125rem; color: var(--pct-text-muted); font-weight: 500; }
.pct-home-modern .dataTables_paginate ul.pagination {
    margin: 0 !important;
    gap: 0.25rem;
    display: inline-flex;
    flex-wrap: wrap;
    justify-content: flex-end;
}
.pct-home-modern .dataTables_paginate .page-item .page-link {
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
.pct-home-modern .dataTables_paginate .page-item .page-link:hover {
    background: var(--pct-surface-2);
    border-color: var(--pct-primary-soft);
    color: var(--pct-primary);
}
.pct-home-modern .dataTables_paginate .page-item.active .page-link {
    background: var(--pct-primary);
    border-color: var(--pct-primary);
    color: #fff;
}
.pct-home-modern .dataTables_paginate .page-item.disabled .page-link {
    background: var(--pct-surface-2);
    color: var(--pct-text-muted);
    border-color: var(--pct-border);
    opacity: 0.8;
}

/* Buttons */
.pct-home-modern .btn {
    font-weight: 500;
    font-size: 0.875rem;
    border-radius: var(--pct-radius-sm);
    transition: opacity .15s ease, background .15s ease, border-color .15s ease;
}
.pct-home-modern .btn-primary { background: var(--pct-primary); border-color: var(--pct-primary); color: #fff; }
.pct-home-modern .btn-primary:hover { background: var(--pct-primary-light); border-color: var(--pct-primary-light); color: #fff; }
.pct-home-modern .btn-success { background: #059669; border-color: #059669; color: #fff; }
.pct-home-modern .btn-success:hover { background: #047857; border-color: #047857; color: #fff; }
.pct-home-modern .btn-danger { background: #dc2626; border-color: #dc2626; color: #fff; }
.pct-home-modern .btn-danger:hover { background: #b91c1c; border-color: #b91c1c; color: #fff; }
.pct-home-modern .btn-info { background: #0891b2; border-color: #0891b2; color: #fff; }
.pct-home-modern .btn-info:hover { background: #0e7490; border-color: #0e7490; color: #fff; }
.pct-home-modern .btn-icon-split { display: inline-flex; align-items: center; gap: 0.5rem; }

/* Alerts */
.pct-home-modern .alert { border-radius: var(--pct-radius-sm); font-size: 0.875rem; }
.pct-home-modern .alert-success { background: #d1fae5; border-color: #a7f3d0; color: #065f46; }
.pct-home-modern .alert-danger { background: #fee2e2; border-color: #fecaca; color: #991b1b; }

/* Form controls */
.pct-home-modern .form-control {
    padding: 0.5rem 0.75rem;
    font-size: 0.9375rem;
    border: 1px solid var(--pct-border);
    border-radius: var(--pct-radius-sm);
    color: var(--pct-text);
    background: var(--pct-surface);
}
.pct-home-modern .form-control:focus {
    border-color: var(--pct-primary-soft);
    outline: 0;
    box-shadow: 0 0 0 3px rgba(30, 95, 138, 0.1);
}
.pct-home-modern .col-form-label { font-size: 0.875rem; font-weight: 500; color: var(--pct-text); }

/* Description text */
.pct-home-modern .order-count-cotainer { margin: 1.5rem 0 1rem; }
.pct-home-modern .order-count-cotainer h4 { font-size: 0.9375rem; color: var(--pct-text-muted); font-weight: 400; margin: 0; }

/* Modals – scoped */
#contactsModal .modal-content,
#revenue_model .modal-content,
#note_information .modal-content,
#aiPrelimSummary .modal-content { border-radius: 12px; border: 1px solid #e2e8f0; box-shadow: 0 4px 12px rgba(0,0,0,.08); }
#contactsModal .card, #revenue_model .card, #note_information .card, #aiPrelimSummary .card { border: none; box-shadow: none; }
</style>

<div class="pct-home-modern">
<section class="section-type-4a section-defaulta" style="padding-bottom:0;">
    <div class="container-fluid px-4 py-4">
        <!-- Page Header -->
        <div class="row mb-4">
            <div class="col-12">
                <h1 class="pct-page-title">Welcome <?php echo $name; ?>,</h1>
                <div class="pct-page-sub-row">
                    <p class="pct-page-sub">Production figures for the current month of <b class="month-name"><?php echo date('F');?></b></p>
                    <?php if(!empty($salesUsers) && $is_sales_rep_manager == 1) { ?>
                        <div class="sales-user-listing">
                            <select name="sales_user_filter" id="sales_user_filter" style="width:auto;">
                                <?php foreach($salesUsers as $salesUser) { ?>
                                    <option <?php echo ($user_id == $salesUser['id']) ? 'selected' : '';?> value="<?php echo $salesUser['id'];?>"><?php echo $salesUser['first_name']." ".$salesUser['last_name'];?></option>
                                <?php }?>
                            </select>
                        </div>
                    <?php } else { ?>
                        <input type="hidden" name="sales_user_filter" id="sales_user_filter" value="<?php echo $user_id;?>">
                    <?php } ?>
                </div>
            </div>
        </div>

        <!-- Stat Cards Row -->
        <div class="row mb-2">
            <div class="col-md-3 col-sm-6 mb-2"><span class="title text-primary">Title Openings MTD</span></div>
            <div class="col-md-3 col-sm-6 mb-2"><span class="title text-success">Title Closings MTD</span></div>
            <div class="col-md-3 col-sm-6 mb-2"><span class="title text-info">Title Revenue MTD</span></div>
            <div class="col-md-3 col-sm-6 mb-2"><span class="title text-warning">Closings Ratio Avg</span></div>
        </div>

        <div class="row mb-4">
            <!-- Title Openings MTD -->
            <div class="col-md-3 col-sm-6 mb-3">
                <div class="stat-card stat-primary">
                    <div class="sales_loan_count text-primary" id="open_order_count"><?php echo $total_open_count; ?></div>
                    <div class="salesdivider">
                        <div class="sales_loan_section">Sales = <span id="sale_open_count"><?php echo $sale_open_count;?></span></div>
                        <div class="sales_loan_section">Refi's = <span id="refi_open_count"><?php echo $refi_open_count;?></span></div>
                    </div>
                    <div class="projected_goal_section text-primary">
                        Projected = <span id="projected_open_section"><?php echo $projected_open_count;?></span>
                        <?php if($sales_rep_info['sales_rep_no_of_open_orders'] > 0) { ?>
                            <div>Goal = <span id="goal_open_section"><?php echo round($sales_rep_info['sales_rep_no_of_open_orders']/12);?></span></div>
                        <?php } ?>
                    </div>
                </div>
            </div>
            <!-- Title Closings MTD -->
            <div class="col-md-3 col-sm-6 mb-3">
                <div class="stat-card stat-success">
                    <div class="sales_loan_count text-success" id="close_order_count"><?php echo $total_close_count; ?></div>
                    <div class="salesdivider">
                        <div class="sales_loan_section">Sales = <span id="sale_close_count"><?php echo $sale_close_count;?></span></div>
                        <div class="sales_loan_section">Refi's = <span id="refi_close_count"><?php echo $refi_close_count;?></span></div>
                    </div>
                    <div class="projected_goal_section text-success">
                        Projected = <span id="projected_close_section"><?php echo $projected_close_count;?></span>
                        <?php if($sales_rep_info['sales_rep_no_of_open_orders'] > 0) { ?>
                            <div>Goal = <span><?php echo round($sales_rep_info['sales_rep_no_of_open_orders']/12);?></span></div>
                        <?php } ?>
                    </div>
                </div>
            </div>
            <!-- Title Revenue MTD -->
            <div class="col-md-3 col-sm-6 mb-3">
                <div class="stat-card stat-info">
                    <div class="sales_loan_count text-info" id="total_premium">
                        <a class="text-info" href="javascript:void(0)" onclick="getRevenueData();">$<span id="total_premium"><?php echo number_format($total_premium); ?></span></a>
                    </div>
                    <div class="salesdivider">
                        <div class="sales_loan_section">Sales = $<span id="sale_total_premium"><?php echo $sale_total_premium;?></span></div>
                        <div class="sales_loan_section">Refi's = $<span id="refi_total_premium"><?php echo $refi_total_premium;?></span></div>
                    </div>
                    <div class="projected_goal_section text-info">
                        Projected = $<span id="projected_revenue_section"><?php echo number_format($projected_revenue);?></span>
                        <?php if($sales_rep_info['sales_rep_premium'] > 0) { ?>
                            <div>Goal = $<span id="goal_revenue_section"><?php echo number_format(round($sales_rep_info['sales_rep_premium']/12));?></span></div>
                        <?php } ?>
                    </div>
                </div>
            </div>
            <!-- Closings Ratio Avg -->
            <div class="col-md-3 col-sm-6 mb-3">
                <div class="stat-card stat-warning">
                    <div class="sales_loan_count text-warning" id="close_order_percetage"><?php echo $close_order_percetage; ?>%</div>
                    <div class="salesdivider">
                        <div class="sales_loan_section">Sales = <span id="sale_close_order_percetage"><?php echo $sale_close_order_percetage;?></span>%</div>
                        <div class="sales_loan_section">Refi's = <span id="refi_close_order_percetage"><?php echo $refi_close_order_percetage;?></span>%</div>
                    </div>
                    <div class="projected_goal_section text-warning">
                        Projected = <span>0%</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Orders Listing -->
        <div class="order-count-cotainer">
            <h4>Below is list of all your files. You can search for files by month that have a status open, closed, or cancelled.</h4>
        </div>

        <div class="card shadow mb-4">
            <div class="card-body">
                <div class="table-responsive">
                    <div id="order_listing_success_msg" class="w-100 alert alert-success alert-dismissible" style="display:none;"></div>
                    <div id="order_listing_error_msg" class="w-100 alert alert-danger alert-dismissible" style="display:none;"></div>
                    <table class="table table-bordered" id="orders_listing" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>#</th>
                                <?php if(!empty($salesUsers)) { ?>
                                    <th>Sales Rep</th>
                                <?php } ?>
                                <th>Opened</th>
                                <th>Property Address</th>
                                <th>Status</th>
                                <th>Action</th>
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

<!-- Contacts Modal -->
<div class="modal" id="contactsModal">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Contacts</h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="tbl-contacts-data" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>Type</th>
                                    <th>Company Name</th>
                                    <th>Name</th>
                                    <th>Email Address</th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                    <div class="form-footer mt-3">
                        <button type="reset" data-dismiss="modal" aria-label="Close" class="btn btn-danger btn-icon-split btn-sm">
                            <span class="icon text-white-50"><i class="fas fa-ban"></i></span>
                            <span class="text">Close</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Revenue Modal -->
<div class="modal fade" width="1200px" id="revenue_model" tabindex="-1" role="dialog" aria-labelledby="Revenue Information" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document" style="width:100%;height:auto;">
        <div class="modal-content">
            <form method="POST" action="">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card shadow mb-4">
                            <div class="card-header py-3">
                                <h6 class="m-0 font-weight-bold text-primary">Revenue Information</h6>
                            </div>
                            <div class="card-body">
                                <div class="smart-forms smart-container">
                                    <div class="search-result">
                                        <div id="deliverables-details-fields">
                                            <div class="frm-row" id="clone_container">
                                                <div class="section colm colm12" id="clone-email-address" style="margin-bottom: 0px !important;">
                                                    <div class="toclone">
                                                        <div class="spacer-b10">
                                                            <label class="field" id="revenue_container"></label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Note Modal -->
<div class="modal fade" width="500px" id="note_information" tabindex="-1" role="dialog" aria-labelledby="Create a Note" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document" style="width:40%;">
        <div class="modal-content">
            <form method="POST" action="" enctype="multipart/form-data" id="prelim_add_note_form">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card shadow">
                            <div class="card-header py-3">
                                <h6 class="m-0 font-weight-bold text-primary">Add a Note</h6>
                            </div>
                            <div class="card-body">
                                <div class="smart-forms smart-container">
                                    <div class="search-result">
                                        <div class="form-group">
                                            <div class="row">
                                                <div class="col-sm-12">
                                                    <label for="note_subject" class="col-form-label">Subject</label>
                                                    <input type="text" name="note_subject" id="note_subject" class="form-control gui-input ui-autocomplete-input" placeholder="Subject" required="">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="row">
                                                <div class="col-sm-12">
                                                    <label for="note" class="col-form-label">Note</label>
                                                    <textarea name="note" id="note" class="gui-input form-control" rows="4" placeholder="Note" autocomplete="off" required=""></textarea>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="recorded_date" class="col-form-label">Upload File</label>
                                            <input required="" name="file_upload" type="file" id="file_upload" class="form-control" accept="application/pdf">
                                        </div>
                                        <input type="hidden" name="upload_file_id" id="upload_file_id" value="">
                                        <input type="hidden" name="document_name" id="document_name" value="">
                                        <input type="hidden" name="order_id" id="order_id" value="">
                                    </div>
                                    <div class="form-footer mt-3">
                                        <button type="submit" data-btntext-sending="Sending..." class="btn btn-success btn-icon-split btn-sm prelim_add_note_form_submit">
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
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- AI Prelim Summary Modal -->
<div class="modal fade" width="800px" id="aiPrelimSummary" tabindex="-1" role="dialog" aria-labelledby="Ai Prelim Summary" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document" style="width:65%; max-width: 1200px">
        <div class="modal-content">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card shadow">
                        <div class="modal-header">
                            <h4 class="modal-title"><strong>Prelim Summary</strong></h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="card-body">
                            <div class="row mb-1">
                                <div class="col-md-8">
                                    <span><strong>Property Address:</strong> <span id="prelim_property"></span></span>
                                </div>
                                <div class="col-md-4">
                                    <span><strong>File Name:</strong> <span id="prelim_file_number"></span></span>
                                </div>
                            </div>
                            <div class="typography-section__inner">
                                <div style="border-bottom: 4px solid var(--pct-primary);"></div>
                            </div>
                            <div class="smart-forms smart-container prelim_summary"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
