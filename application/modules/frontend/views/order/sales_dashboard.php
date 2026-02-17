

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
<div class="modal fade" id="contactsModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title font-weight-bold text-primary">Contacts</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
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
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger btn-icon-split btn-sm" data-dismiss="modal">
                    <span class="icon text-white-50"><i class="fas fa-ban"></i></span>
                    <span class="text">Close</span>
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Revenue Modal -->
<div class="modal fade" id="revenue_model" tabindex="-1" role="dialog" aria-labelledby="Revenue Information" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title font-weight-bold text-primary">Revenue Information</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form method="POST" action="">
                <div class="modal-body">
                    <div class="smart-forms smart-container">
                        <div class="search-result">
                            <div id="deliverables-details-fields">
                                <div class="frm-row" id="clone_container">
                                    <div class="section colm colm12" id="clone-email-address" style="margin-bottom: 0 !important;">
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
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Close</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Note Modal -->
<div class="modal fade" id="note_information" tabindex="-1" role="dialog" aria-labelledby="Create a Note" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document" style="max-width: 600px;">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title font-weight-bold text-primary">Add a Note</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form method="POST" action="" enctype="multipart/form-data" id="prelim_add_note_form">
                <div class="modal-body">
                    <div class="smart-forms smart-container">
                        <div class="form-group">
                            <label for="note_subject" class="col-form-label">Subject</label>
                            <input type="text" name="note_subject" id="note_subject" class="form-control" placeholder="Enter subject" required>
                        </div>
                        <div class="form-group">
                            <label for="note" class="col-form-label">Note</label>
                            <textarea name="note" id="note" class="form-control" rows="4" placeholder="Enter note details" required></textarea>
                        </div>
                        <div class="form-group">
                            <label for="file_upload" class="col-form-label">Upload File (PDF only)</label>
                            <div class="custom-file">
                                <input type="file" name="file_upload" id="file_upload" class="custom-file-input" accept="application/pdf" required>
                                <label class="custom-file-label" for="file_upload">Choose file...</label>
                            </div>
                        </div>
                        <input type="hidden" name="upload_file_id" id="upload_file_id" value="">
                        <input type="hidden" name="document_name" id="document_name" value="">
                        <input type="hidden" name="order_id" id="order_id" value="">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger btn-icon-split btn-sm" data-dismiss="modal">
                        <span class="icon text-white-50"><i class="fas fa-ban"></i></span>
                        <span class="text">Cancel</span>
                    </button>
                    <button type="submit" data-btntext-sending="Sending..." class="btn btn-success btn-icon-split btn-sm prelim_add_note_form_submit">
                        <span class="icon text-white-50"><i class="fas fa-check"></i></span>
                        <span class="text">Submit</span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- AI Prelim Summary Modal -->
<div class="modal fade" id="aiPrelimSummary" tabindex="-1" role="dialog" aria-labelledby="Ai Prelim Summary" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document" style="max-width: 900px;">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title font-weight-bold text-primary">Prelim Summary</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row mb-3">
                    <div class="col-md-8">
                        <div class="d-flex align-items-center mb-1">
                            <span class="text-secondary mr-2">Property Address:</span>
                            <span id="prelim_property" class="font-weight-bold text-dark"></span>
                        </div>
                    </div>
                    <div class="col-md-4 text-md-right">
                        <div class="d-flex align-items-center justify-content-md-end mb-1">
                            <span class="text-secondary mr-2">File Name:</span>
                            <span id="prelim_file_number" class="font-weight-bold text-dark"></span>
                        </div>
                    </div>
                </div>
                <div style="border-bottom: 2px solid var(--pct-border); margin-bottom: 1.5rem;"></div>
                <div class="smart-forms smart-container prelim_summary"></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
