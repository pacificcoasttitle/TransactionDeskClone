

<div class="pct-page-modern pct-report-page">
    <div class="container-fluid px-4 py-4">
        
        <!-- Header & Actions -->
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-4">
            <h1 class="h3 mb-3 mb-md-0 text-gray-800" style="font-weight: 700; color: var(--pct-primary);">Concierge Profile</h1>
        </div>

        <div class="action-bar">
            <a href="<?php echo base_url('sales-activity-report'); ?>" class="action-btn">
                <i class="fa fa-tag"></i> <span>County Activity</span>
            </a>
            <a href="<?php echo base_url('sales-snap-shot'); ?>" class="action-btn">
                <i class="fa fa-camera"></i> <span>Sales Snap Shot</span>
            </a>
            <a href="<?php echo base_url('reports'); ?>" class="action-btn">
                <i class="fas fa-file-alt"></i> <span>Create F.A.R</span>
            </a>
            <a href="<?php echo base_url('labels'); ?>" class="action-btn">
                <i class="fa fa-tag"></i> <span>Create Labels</span>
            </a>
        </div>

        <div class="row">
            <!-- Left Column: Stats & Reps -->
            <div class="col-lg-3">
                <!-- Start Stats -->
                <div class="row">
                    <div class="col-12">
                        <div class="stat-card shadow-sm mb-3">
                            <h5>Total List Ran</h5>
                            <h2 class="pma-total pma_val">0</h2>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <div class="stat-card shadow-sm mb-4" style="background: linear-gradient(135deg, #36b9cc 0%, #2c9faf 100%);">
                            <h5>Accumulated Cost</h5>
                            <h2 class="accrued-cost pma_val">0</h2>
                        </div>
                    </div>
                </div>

                <!-- Sales Representatives -->
                <div class="card shadow">
                    <div class="card-header">
                        <h6 class="card-title">Representatives</h6>
                        <div class="hide" id="show_all_rep">
                            <a href="<?=base_url('reports/sales_rep');?>" class="btn btn-sm btn-primary" style="padding: 0.2rem 0.5rem; font-size: 0.75rem;">View All</a>
                        </div>
                    </div>
                    <div class="p-0">
                        <ul id="rep-list-data" >
                            <!-- Content loaded via AJAX -->
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Right Column: Form & Tables -->
            <div class="col-lg-9">
                <!-- Create Report Form -->
                <div class="card shadow mb-4">
                    <div class="card-header">
                        <h6 class="card-title">Create New Report</h6>
                    </div>
                    <div class="card-body">
                        <?php $prev_data = $this->session->flashdata('_previous_data'); ?>
                        <?php if ($this->session->flashdata('error')): ?>
                            <div class="alert alert-danger" role="alert"><?php echo $this->session->flashdata('error'); ?></div>
                        <?php elseif ($this->session->flashdata('success')): ?>
                            <div class="alert alert-success" role="alert"><?php echo $this->session->flashdata('success'); ?></div>
                        <?php endif;?>

                        <form method="POST" id="smart-form" enctype="multipart/form-data" novalidate="novalidate" action="<?php echo base_url('pma/importData') ?>">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-label">Property Address / APN</label>
                                        <div class="input-group mb-2">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text bg-light border-right-0"><i class="fa fa-map-marker text-muted"></i></span>
                                            </div>
                                            <!-- Address Input -->
                                            <input type="text" class="js-pma-address form-control border-left-0" name="address_input" id="js-property-search"
                                                value="<?php echo (!empty($prev_data['address_input'])) ? $prev_data['address_input'] : ''; ?>" placeholder="Property Address">
                                            <!-- APN Input (Hidden toggle) -->
                                            <input id="js-apn-search" placeholder="APN" class="formpma js-pma-apn form-control border-left-0" type="text" value="" name="subject" style="display:none;"> 
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-label">City</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text bg-light border-right-0"><i class="fa fa-map-marker text-muted"></i></span>
                                            </div>
                                            <input type="text" class="js-pma-city js-pma-fips form-control border-left-0" name="city_input" value="<?php echo (!empty($prev_data['city_input'])) ? $prev_data['city_input'] : ''; ?>" placeholder="City">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row mt-2">
                                <div class="col-12 d-flex gap-2">
                                    <button type="button" class="btn btn-danger btn-icon-split js-find-property js-search-button mr-2">
                                        <span class="icon text-white-50"><i class="fas fa-search"></i></span>
                                        <span class="text">Find Property</span>
                                    </button>
                                    <button type="button" class="btn btn-success btn-icon-split switch-search js-switch-search">
                                        <span class="icon text-white-50"><i class="fas fa-random"></i></span>
                                        <span class="text">Switch to APN Search</span>
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Search Results (Hidden by default) -->
                <div class="card shadow mb-4 hide search-result-div">
                    <div class="card-header">
                        <h6 class="card-title">Search Results</h6>
                    </div>
                    <div class="card-body">
                        <div class="pma-error alert alert-danger hide"></div>
                        <div class="table-responsive">
                            <table class="table table-bordered result-table" id="cpl_listing_1">
                                <thead>
                                    <tr>
                                        <th>APN</th>
                                        <th>Address</th>
                                        <th>City</th>
                                        <th>Create</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td><span class="result-apn"></span></td>
                                        <td><span class="result-address"></span></td>
                                        <td><span class="result-city"></span></td>
                                        <td><button type="button" class="btn btn-sm btn-info js-run-pma-button">Create</button></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- Recent Reports -->
                <div class="card shadow">
                    <div class="card-header">
                        <h6 class="card-title">Recent Concierge Property Profiles</h6>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered recent-reports" id="cpl_listing">
                                <thead>
                                    <tr>
                                        <th>Date</th>
                                        <th>PCT Rep</th>
                                        <th>Address</th>
                                        <th>Download</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <!-- Populated by JS -->
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

<!-- Report Info Modal -->
<div class="modal fade" id="run-pma-dialog" title="Report Info" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <form id="run-pma-form">
                <div class="modal-header">
                    <h5 class="modal-title">Profile Details</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body search-result">
                    <div class="alert alert-danger alert-dismissible pma-alert" role="alert" style="display: none">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
                        <span class="error_msg"></span>
                    </div>

                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label font-weight-bold" for="rep-name">Rep:</label>
                        <div class="col-sm-9">
                            <select name="rep-name" type="text" id="rep-name" class="form-control"></select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label font-weight-bold" for="realtor-name">Realtor Name:</label>
                        <div class="col-sm-9">
                            <input type="text" name="realtor-name" id="realtor-name" class="form-control" />
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label font-weight-bold" for="realtor-company">Company:</label>
                        <div class="col-sm-9">
                            <input type="text" name="realtor-company" id="realtor-company" class="form-control" />
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label font-weight-bold" for="realtor-address">Address:</label>
                        <div class="col-sm-9">
                            <input type="text" name="realtor-address" id="realtor-address" class="form-control" />
                        </div>
                    </div>
                    <div class="form-group row hide">
                        <label class="col-sm-3 col-form-label font-weight-bold" for="tabs">Include Tabs?</label>
                        <div class="col-sm-9">
                            <select id="tabs" name="tabs" class="form-control">
                                <option value="Yes">Yes</option>
                                <option value="No">No</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row include-docs hide">
                        <label class="col-sm-3 col-form-label font-weight-bold" for="docs">Include Docs?</label>
                        <div class="col-sm-9">
                            <select id="include-docs" name="include-docs" class="form-control">
                                <option value="Yes">Yes</option>
                                <option value="No" selected="selected">No</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label font-weight-bold" for="comps">Select Comps</label>
                        <div class="col-sm-9">
                            <select id="include-comps" name="include-comps" class="form-control">
                                <option value="Yes">Yes</option>
                                <option value="No" selected="selected">No</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label font-weight-bold" for="report_lang">Report Language:</label>
                        <div class="col-sm-9">
                            <select id="report_lang" name="report_lang" class="form-control">
                                <option value="english" selected="selected">English</option>
                                <option value="spanish">Spanish</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary pma-modal-submit" style="background-color: var(--pct-primary); border-color: var(--pct-primary);">Submit</button>
                </div>
            </form>
        </div>
    </div>
</div> 

<!-- Comps Modal -->
<div class="modal fade" id="comps-dialog" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
        <div class="modal-content">
            <form id="comps-form">
                <div class="modal-header">
                    <h5 class="modal-title">Select Comparable Sales</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div> <!-- Added missing closing div -->
                <div class="modal-body search-result">
                    <div class="alert alert-info">
                        Please select up to 8 comparable sales to feature prominently in your property profile. You can also ensure that properties will <em>not</em> be included in the profile by clicking the corresponding red "X" when you hover over a property.
                    </div>
                    <div class="comps-error"></div>
                    <div class="table-responsive">
                        <table id="comps-table" class="table table-bordered table-striped">
                            <colgroup>
                                <col span="1" style="width: 20%;">
                                <col span="1" style="width: 13%;">
                                <col span="1" style="width: 12%;">
                                <col span="1" style="width: 11%;">
                                <col span="1" style="width: 12%;">
                                <col span="1" style="width: 12%;">
                                <col span="1" style="width: 12%;">
                                <col span="1" style="width: 8%;">
                            </colgroup>
                            <thead class="thead-light">
                                <tr>
                                    <th>Address</th>
                                    <th>Living Area</th>
                                    <th>Lot Size</th>
                                    <th>BDs/BRs</th>
                                    <th>Sale Date</th>
                                    <th>Distance</th>
                                    <th>Sale Price</th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                    <div class="comps-error"></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary comps-submit" style="background-color: var(--pct-primary); border-color: var(--pct-primary);">Submit</button>
                </div>
            </form>
        </div>
    </div>
</div>
