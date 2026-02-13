


<div class="pct-page-modern pct-report-page">
    <div class="container-fluid px-4 py-4">
        
        <!-- Header & Actions -->
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-4">
            <h1 class="h3 mb-3 mb-md-0 text-gray-800" style="font-weight: 700; color: var(--pct-primary);">Labels</h1>
        </div>

        <div class="action-bar">
            <a href="<?php echo base_url('sales-activity-report'); ?>" class="action-btn">
                <i class="fas fa-chart-line"></i> <span>County Activity</span>
            </a>
            <a href="<?php echo base_url('sales-snap-shot'); ?>" class="action-btn">
                <i class="fa fa-camera"></i> <span>Sales Snap Shot</span>
            </a>
            <a href="<?php echo base_url('pmas'); ?>" class="action-btn">
                <i class="fas fa-concierge-bell"></i> <span>Create Concierge</span>
            </a>
            <a href="<?php echo base_url('reports'); ?>" class="action-btn">
                <i class="fas fa-file-alt"></i> <span>Create F.A.R</span>
            </a>
        </div>

        <div class="row">
            <!-- Left Column: Stats & Reps -->
            <div class="col-lg-3">
                <!-- Total Ran Stat -->
                <div class="stat-card shadow-sm">
                    <h5>Total Ran (Labels)</h5>
                    <h2 class="pma-total pma_val"><?php echo $report_total; ?></h2>
                </div>

                <!-- Sales Representatives -->
                <div class="card shadow">
                    <div class="card-header">
                        <h6 class="card-title">Representatives</h6>
                        <?php if (count($salesReps) > 10): ?>
                            <a href="<?=base_url('reports/sales_rep');?>" class="btn btn-sm btn-primary" style="padding: 0.2rem 0.5rem; font-size: 0.75rem;">View All</a>
                        <?php endif;?>
                    </div>
                    <div class="p-0">
                        <?php foreach ($salesReps as $key => $salesRep): ?>
                            <div class="rep-list-item">
                                <div class="rep-avatar">
                                    <?php 
                                    $image_url = trim(env('AWS_PATH') . $salesRep['sales_rep_report_image']);
                                    if (!empty($salesRep['sales_rep_report_image'])): ?>
                                        <img src="<?php echo $image_url; ?>" alt="User">
                                    <?php else: ?>
                                        <span><?php echo strtoupper(substr(trim($salesRep['first_name']), 0, 1) . substr(trim($salesRep['last_name']), 0, 1)); ?></span>
                                    <?php endif;?>
                                </div>
                                <div class="rep-details">
                                    <div class="rep-name"><?php echo $salesRep['first_name'] . ' ' . $salesRep['last_name']; ?></div>
                                    <div class="rep-info"><i class="fas fa-envelope mr-1"></i> <?php echo $salesRep['email_address']; ?></div>
                                    <div class="rep-info"><i class="fas fa-phone mr-1"></i> <?php echo $salesRep['telephone_no']; ?></div>
                                </div>
                                <div class="rep-count"><?php echo $salesRep['report_count']; ?></div>
                            </div>
                            <?php if ($key == 9) break; ?>
                        <?php endforeach; ?>
                    </div>
                    <?php if (count($salesReps) == 0): ?>
                        <div class="card-body text-center text-muted">No representatives found.</div>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Right Column: Form & Recent Reports -->
            <div class="col-lg-9">
                <!-- Create Report Form -->
                <div class="card shadow mb-4">
                    <div class="card-header">
                        <h6 class="card-title">Create New Label Report</h6>
                    </div>
                    <div class="card-body">
                        <?php $prev_data = $this->session->flashdata('_previous_data'); ?>
                        <?php if ($this->session->flashdata('error')): ?>
                            <div class="alert alert-danger" role="alert"><?php echo $this->session->flashdata('error'); ?></div>
                        <?php elseif ($this->session->flashdata('success')): ?>
                            <div class="alert alert-success" role="alert"><?php echo $this->session->flashdata('success'); ?></div>
                        <?php endif;?>

                        <form method="POST" id="smart-form" enctype="multipart/form-data" novalidate="novalidate" action="<?php echo base_url('labels/importData'); ?>">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-label">Upload CSV File</label>
                                        <div class="file-input-wrapper">
                                            <div class="file-input-btn">Choose File</div>
                                            <div class="file-input-text" id="uploader1-text">no file selected</div>
                                            <input type="file" name="csvFile" id="csvFile" accept=".csv" 
                                                onchange="document.getElementById('uploader1-text').innerText = this.files[0] ? this.files[0].name : 'no file selected';">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-label">File Name</label>
                                        <input type="text" class="form-control" name="file_name" value="<?php echo (!empty($prev_data['file_name'])) ? $prev_data['file_name'] : ''; ?>" placeholder="Enter file name">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-label">Sales Representative</label>
                                        <select id="sales_rep" name="sales_rep" class="form-control">
                                            <option value="">Select Sales Representative</option>
                                            <?php foreach ($salesReps as $salesRep): ?>
                                                <option value="<?php echo $salesRep['id']; ?>" <?php if (!empty($prev_data['sales_rep']) && $prev_data['sales_rep'] == $salesRep['id']) {echo 'selected';}?>><?php echo $salesRep['first_name'] . ' ' . $salesRep['last_name']; ?></option>
                                            <?php endforeach;?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row mt-2">
                                <div class="col-12 d-flex gap-2">
                                    <button type="submit" class="btn btn-success btn-icon-split mr-2">
                                        <span class="icon text-white-50"><i class="fas fa-save"></i></span>
                                        <span class="text">Submit Form</span>
                                    </button>
                                    <button type="reset" class="btn btn-danger btn-icon-split">
                                        <span class="icon text-white-50"><i class="fas fa-refresh"></i></span>
                                        <span class="text">Reset Form</span>
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Recent Activity Table -->
                <div class="card shadow">
                    <div class="card-header">
                        <h6 class="card-title">Recent Label Reports</h6>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered" id="label_listing" width="100%" cellspacing="0">
                                <thead>
                                    <tr>
                                        <th>Date</th>
                                        <th>Sales Rep</th>
                                        <th>File Name</th>
                                        <th class="text-center">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (!empty($labels_data)): 
                                        foreach ($labels_data as $label): 
                                    ?>
                                    <tr>
                                        <td>
                                            <span style="display:none;"><?php echo strtotime($label['created_at']); ?></span>
                                            <?php echo date('m/d/Y', strtotime($label['created_at'])); ?>
                                        </td>
                                        <td><?php echo $label['first_name'] . ' ' . $label['last_name']; ?></td>
                                        <td><?php echo $label['file_name']; ?></td>
                                        <td class="text-center">
                                            <div class="action-cell-btns">
                                                <a href="javascript:void(0)" class="btn btn-success btn-sm btn-icon-split" onclick="selectColumns(<?php echo $label['id'] ?>, '<?php echo $label['file_columns'] ?>', '<?php echo $label['original_file_name'] ?>');">
                                                    <span class="icon text-white-50"><i class="fas fa-download"></i></span>
                                                    <span class="text">Download</span>
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                    <?php endforeach; 
                                    else: ?>
                                        <tr>
                                            <td colspan="4" class="text-center text-muted">No Record Found</td>
                                        </tr>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

<!-- Modal: Select Columns (IDs preserved for label.js compatibility) -->
<div class="modal fade" id="select_columns" tabindex="-1" role="dialog" aria-labelledby="selectColumnsLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="selectColumnsLabel">Select Columns</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form method="POST" id="select_columns_form" name="select_columns_form" onsubmit="return generatePdf();">
                <div class="modal-body">
                    <input type="hidden" id="label_id" name="label_id" value="">
                    <input type="hidden" id="file_name" name="file_name" value="">

                    <!-- OR Current Resident -->
                    <div class="form-group">
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input" id="or_current_resident" name="or_current_resident">
                            <label class="custom-control-label font-weight-bold" for="or_current_resident">OR CURRENT RESIDENT</label>
                        </div>
                    </div>

                    <hr>

                    <!-- Line 1 Config -->
                    <div class="form-group">
                        <label class="font-weight-bold">How many columns do you want to display on line 1?</label>
                        <div class="d-flex">
                            <div class="custom-control custom-radio mr-4">
                                <input type="radio" id="line1_col1" name="line_1_columns" value="1" class="custom-control-input" checked>
                                <label class="custom-control-label" for="line1_col1">1</label>
                            </div>
                            <div class="custom-control custom-radio mr-4">
                                <input type="radio" id="line1_col2" name="line_1_columns" value="2" class="custom-control-input">
                                <label class="custom-control-label" for="line1_col2">2</label>
                            </div>
                            <div class="custom-control custom-radio mr-4">
                                <input type="radio" id="line1_col3" name="line_1_columns" value="3" class="custom-control-input">
                                <label class="custom-control-label" for="line1_col3">3</label>
                            </div>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="col-md-4 form-group" id="line_1_1_container" style="display:none">
                             <select id="line_1_1" name="line_1_1" class="form-control">
                                 <option value="">---- Select Column ----</option>
                             </select>
                        </div>
                        <div class="col-md-4 form-group" id="line_1_2_container" style="display:none">
                             <select id="line_1_2" name="line_1_2" class="form-control">
                                 <option value="">---- Select Column ----</option>
                             </select>
                        </div>
                        <div class="col-md-4 form-group" id="line_1_3_container" style="display:none">
                             <select id="line_1_3" name="line_1_3" class="form-control">
                                 <option value="">---- Select Column ----</option>
                             </select>
                        </div>
                    </div>

                    <hr>

                    <!-- Line 2 Config -->
                    <div class="form-group">
                        <label class="font-weight-bold">How many columns do you want to display on line 2?</label>
                        <div class="d-flex">
                            <div class="custom-control custom-radio mr-4">
                                <input type="radio" id="line2_col1" name="line_2_columns" value="1" class="custom-control-input" checked>
                                <label class="custom-control-label" for="line2_col1">1</label>
                            </div>
                            <div class="custom-control custom-radio mr-4">
                                <input type="radio" id="line2_col2" name="line_2_columns" value="2" class="custom-control-input">
                                <label class="custom-control-label" for="line2_col2">2</label>
                            </div>
                            <div class="custom-control custom-radio mr-4">
                                <input type="radio" id="line2_col3" name="line_2_columns" value="3" class="custom-control-input">
                                <label class="custom-control-label" for="line2_col3">3</label>
                            </div>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="col-md-4 form-group" id="line_2_1_container" style="display:none">
                             <select id="line_2_1" name="line_2_1" class="form-control">
                                 <option value="">---- Select Column ----</option>
                             </select>
                        </div>
                        <div class="col-md-4 form-group" id="line_2_2_container" style="display:none">
                             <select id="line_2_2" name="line_2_2" class="form-control">
                                 <option value="">---- Select Column ----</option>
                             </select>
                        </div>
                        <div class="col-md-4 form-group" id="line_2_3_container" style="display:none">
                             <select id="line_2_3" name="line_2_3" class="form-control">
                                 <option value="">---- Select Column ----</option>
                             </select>
                        </div>
                    </div>

                    <hr>

                    <!-- Line 3 Config -->
                    <div class="form-group">
                        <label class="font-weight-bold">How many columns do you want to display on line 3?</label>
                        <div class="d-flex">
                            <div class="custom-control custom-radio mr-4">
                                <input type="radio" id="line3_col1" name="line_3_columns" value="1" class="custom-control-input" checked>
                                <label class="custom-control-label" for="line3_col1">1</label>
                            </div>
                            <div class="custom-control custom-radio mr-4">
                                <input type="radio" id="line3_col2" name="line_3_columns" value="2" class="custom-control-input">
                                <label class="custom-control-label" for="line3_col2">2</label>
                            </div>
                            <div class="custom-control custom-radio mr-4">
                                <input type="radio" id="line3_col3" name="line_3_columns" value="3" class="custom-control-input">
                                <label class="custom-control-label" for="line3_col3">3</label>
                            </div>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="col-md-4 form-group" id="line_3_1_container" style="display:none">
                             <select id="line_3_1" name="line_3_1" class="form-control">
                                 <option value="">---- Select Column ----</option>
                             </select>
                        </div>
                        <div class="col-md-4 form-group" id="line_3_2_container" style="display:none">
                             <select id="line_3_2" name="line_3_2" class="form-control">
                                 <option value="">---- Select Column ----</option>
                             </select>
                        </div>
                        <div class="col-md-4 form-group" id="line_3_3_container" style="display:none">
                             <select id="line_3_3" name="line_3_3" class="form-control">
                                 <option value="">---- Select Column ----</option>
                             </select>
                        </div>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Export PDF</button>
                </div>
            </form>
        </div>
    </div>
</div>
