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
.pct-page-modern .card {
    border: 1px solid var(--pct-border);
    border-radius: var(--pct-radius);
    box-shadow: var(--pct-shadow);
    background: var(--pct-surface);
    margin-bottom: 1.5rem;
}
.pct-page-modern .card-header {
    background: var(--pct-surface-2);
    border-bottom: 1px solid var(--pct-border);
    padding: 1rem 1.25rem;
    display: flex;
    justify-content: space-between;
    align-items: center;
}
.pct-page-modern .card-title {
    margin: 0;
    font-weight: 700;
    color: var(--pct-primary);
    font-size: 1rem;
}
.pct-page-modern .card-body { padding: 1.5rem; }

/* Stat Card */
.pct-page-modern .stat-card {
    text-align: center;
    padding: 1.5rem;
    background: linear-gradient(135deg, var(--pct-primary) 0%, var(--pct-primary-light) 100%);
    color: white;
    border-radius: var(--pct-radius);
    margin-bottom: 1.5rem;
}
.pct-page-modern .stat-card h5 { margin: 0 0 0.5rem; opacity: 0.9; font-size: 0.9rem; text-transform: uppercase; letter-spacing: 0.5px; }
.pct-page-modern .stat-card h2 { margin: 0; font-size: 2.5rem; font-weight: 800; }

/* Action Bar */
.pct-page-modern .action-bar {
    display: flex;
    gap: 1rem;
    flex-wrap: wrap;
    margin-bottom: 1.5rem;
}
.pct-page-modern .action-btn {
    background: #fff;
    border: 1px solid var(--pct-border);
    padding: 0.75rem 1rem;
    border-radius: var(--pct-radius-sm);
    color: var(--pct-primary);
    font-weight: 600;
    display: flex;
    align-items: center;
    gap: 0.5rem;
    transition: all 0.2s;
    text-decoration: none;
    box-shadow: 0 1px 2px rgba(0,0,0,0.05);
}
.pct-page-modern .action-btn:hover {
    background: var(--pct-primary-soft);
    border-color: var(--pct-primary-light);
    color: var(--pct-primary);
    transform: translateY(-1px);
}

/* Sales Rep List */
.pct-page-modern .rep-list-item {
    display: flex;
    padding: 1rem;
    border-bottom: 1px solid var(--pct-border);
    align-items: flex-start;
}
.pct-page-modern .rep-list-item:last-child { border-bottom: none; }
.pct-page-modern .rep-avatar {
    width: 48px;
    height: 48px;
    border-radius: 50%;
    background: var(--pct-surface-2);
    display: flex;
    align-items: center;
    justify-content: center;
    overflow: hidden;
    margin-right: 1rem;
    flex-shrink: 0;
    border: 1px solid var(--pct-border);
    color: var(--pct-primary);
    font-weight: 700;
    font-size: 1.2rem;
}
.pct-page-modern .rep-avatar img { width: 100%; height: 100%; object-fit: cover; }
.pct-page-modern .rep-details { flex-grow: 1; }
.pct-page-modern .rep-name { font-weight: 700; color: var(--pct-text); font-size: 0.95rem; margin-bottom: 0.25rem; }
.pct-page-modern .rep-info { font-size: 0.8rem; color: var(--pct-text-muted); line-height: 1.4; }
.pct-page-modern .rep-count {
    background: var(--pct-primary-soft);
    color: var(--pct-primary);
    padding: 0.25rem 0.6rem;
    border-radius: 20px;
    font-size: 0.85rem;
    font-weight: 700;
    margin-left: 0.5rem;
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
    color: var(--pct-text);
    background-color: #fff;
    border: 1px solid var(--pct-border);
    border-radius: var(--pct-radius-sm);
    transition: all 0.2s;
}
.pct-page-modern .form-control:focus {
    border-color: var(--pct-primary-light);
    box-shadow: 0 0 0 3px var(--pct-primary-soft);
    outline: 0;
}

/* File Input Custom Style */
.pct-page-modern .file-input-wrapper {
    position: relative;
    border: 1px solid var(--pct-border);
    border-radius: var(--pct-radius-sm);
    background: #fff;
    display: flex;
    align-items: center;
    overflow: hidden;
}
.pct-page-modern .file-input-wrapper input[type=file] {
    position: absolute;
    top: 0; left: 0; width: 100%; height: 100%;
    opacity: 0; cursor: pointer;
    z-index: 2;
}
.pct-page-modern .file-input-btn {
    background: var(--pct-surface-2);
    padding: 0.625rem 1rem;
    border-right: 1px solid var(--pct-border);
    color: var(--pct-text);
    font-weight: 600;
    font-size: 0.85rem;
}
.pct-page-modern .file-input-text {
    padding: 0.625rem 1rem;
    color: var(--pct-text-muted);
    font-size: 0.875rem;
    flex-grow: 1;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}

/* Input Group Icon */
.pct-page-modern .input-group-text {
    background-color: var(--pct-surface-2);
    border-color: var(--pct-border);
    color: var(--pct-text-muted);
}

/* Buttons */
.pct-page-modern .btn-icon-split {
    display: inline-flex;
    align-items: stretch;
    justify-content: center;
    border-radius: var(--pct-radius-sm);
    overflow: hidden;
    padding: 0;
    border: none;
    font-weight: 500;
    transition: all 0.2s;
    text-decoration: none;
}
.pct-page-modern .btn-icon-split .icon {
    background: rgba(0,0,0,0.15);
    padding: 0.5rem 0.75rem;
    display: flex;
    align-items: center;
}
.pct-page-modern .btn-icon-split .text {
    padding: 0.5rem 1rem;
    display: flex;
    align-items: center;
}
.pct-page-modern .btn-primary { background: var(--pct-primary); color: #fff; }
.pct-page-modern .btn-primary:hover { background: #164e73; color: #fff; }
.pct-page-modern .btn-success { background: #1cc88a; color: #fff; }
.pct-page-modern .btn-success:hover { background: #17a673; color: #fff; }
.pct-page-modern .btn-danger { background: #e74a3b; color: #fff; }
.pct-page-modern .btn-danger:hover { background: #be2617; color: #fff; }
.pct-page-modern .btn-info { background: #36b9cc; color: #fff; }
.pct-page-modern .btn-info:hover { background: #2c9faf; color: #fff; }


/* Table */
.pct-page-modern .table-responsive { overflow-x: auto; }
.pct-page-modern .table { width: 100%; margin-bottom: 0; color: var(--pct-text); border-collapse: collapse; }
.pct-page-modern .table th {
    background: var(--pct-surface-2);
    color: var(--pct-text);
    font-weight: 700;
    text-transform: uppercase;
    font-size: 0.75rem;
    padding: 0.875rem 1rem;
    border-bottom: 2px solid var(--pct-border);
}
.pct-page-modern .table td {
    padding: 0.875rem 1rem;
    vertical-align: middle;
    border-bottom: 1px solid var(--pct-border);
    font-size: 0.9rem;
}
.pct-page-modern .table-bordered { border: 1px solid var(--pct-border); }
.pct-page-modern .table-bordered th, .pct-page-modern .table-bordered td { border: 1px solid var(--pct-border); }
.pct-page-modern .action-cell-btns { display: flex; gap: 0.5rem; justify-content: center; }

/* Alerts */
.pct-page-modern .alert {
    border-radius: var(--pct-radius-sm);
    padding: 1rem;
    margin-bottom: 1rem;
    border: 1px solid transparent;
}
.pct-page-modern .alert-success { background: #dcfce7; border-color: #bbf7d0; color: #166534; }
.pct-page-modern .alert-danger { background: #fee2e2; border-color: #fecaca; color: #991b1b; }
.hide { display: none; }
.show { display: block; }

</style>

<div class="pct-page-modern">
    <div class="container-fluid px-4 py-4">
        
        <!-- Header & Actions -->
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-4">
            <h1 class="h3 mb-3 mb-md-0 text-gray-800" style="font-weight: 700; color: var(--pct-primary);">Sales Snap Shot</h1>
        </div>

        <div class="action-bar">
            <a href="<?php echo base_url('sales-activity-report'); ?>" class="action-btn">
                <i class="fa fa-tag"></i> <span>County Activity</span>
            </a>
            <a href="<?php echo base_url('reports'); ?>" class="action-btn">
                <i class="fas fa-file-alt"></i> <span>Create F.A.R</span>
            </a>
            <a href="<?php echo base_url('pmas'); ?>" class="action-btn">
                <i class="fas fa-concierge-bell"></i> <span>Create Concierge</span>
            </a>
            <a href="<?php echo base_url('labels'); ?>" class="action-btn">
                <i class="fa fa-tag"></i> <span>Create Labels</span>
            </a>
        </div>

        <div class="row">
            <!-- Left Column: Stats & Reps -->
            <div class="col-lg-3">
                <!-- Total Ran Stat -->
                <div class="stat-card shadow-sm">
                    <h5>Total List Ran</h5>
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
                        <h6 class="card-title">Create New Report</h6>
                    </div>
                    <div class="card-body">
                        <?php $prev_data = $this->session->flashdata('_previous_data'); ?>
                        <?php if ($this->session->flashdata('error')): ?>
                            <div class="alert alert-danger" role="alert"><?php echo $this->session->flashdata('error'); ?></div>
                        <?php elseif ($this->session->flashdata('success')): ?>
                            <div class="alert alert-success" role="alert"><?php echo $this->session->flashdata('success'); ?></div>
                        <?php endif;?>

                        <form method="POST" id="smart-form" enctype="multipart/form-data" novalidate="novalidate" action="<?php echo base_url('sales-snap-shot/importData'); ?>">
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
                                        <label class="form-label">Area Name</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text bg-light border-right-0"><i class="fa fa-map-marker text-muted"></i></span>
                                            </div>
                                            <input type="text" class="form-control border-left-0" name="area_name" value="<?php echo (!empty($prev_data['area_name'])) ? $prev_data['area_name'] : ''; ?>" placeholder="What Area?">
                                        </div>
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
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-label">Month Option</label>
                                        <select id="month_option" name="month_option" class="form-control">
                                            <option value="">Select Month Option</option>
                                            <option value="3" <?php if (!empty($prev_data['month_option']) && $prev_data['month_option'] == "3") {echo 'selected';}?>>3</option>
                                            <option value="6" <?php if (!empty($prev_data['month_option']) && $prev_data['month_option'] == "6") {echo 'selected';}?>>6</option>
                                            <option value="12" <?php if (!empty($prev_data['month_option']) && $prev_data['month_option'] == "12") {echo 'selected';}?>>12</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-label">Property Type</label>
                                        <select id="property_type" name="property_type" class="form-control">
                                            <option value="">Select Types of Properties</option>
                                            <option value="SFR" <?php if (!empty($prev_data['property_type']) && $prev_data['property_type'] == "SFR") {echo 'selected';}?>>SFR</option>
                                            <option value="Condo" <?php if (!empty($prev_data['property_type']) && $prev_data['property_type'] == "Condo") {echo 'selected';}?>>Condo</option>
                                            <option value="2-4 Units" <?php if (!empty($prev_data['property_type']) && $prev_data['property_type'] == "2-4 Units") {echo 'selected';}?>>2-4 Units</option>
                                            <option value="5 Units & Up" <?php if (!empty($prev_data['property_type']) && $prev_data['property_type'] == "5 Units & Up") {echo 'selected';}?>>5 Units & Up</option>
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
                        <h6 class="card-title">Recent Sales Snap Shot</h6>
                    </div>
                    <div class="card-body">
                        <!-- AJAX Alerts -->
                        <div class="alert alert-success hide" id="successMsg"></div>
                        <div class="alert alert-danger hide" id="errorMsg"></div>

                        <div class="table-responsive">
                            <table class="table table-bordered" id="report_listing" width="100%" cellspacing="0">
                                <thead>
                                    <tr>
                                        <th>Date</th>
                                        <th>Sales Rep</th>
                                        <th>Area Name</th>
                                        <th class="text-center">Download</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php 
                                    if (!empty($reports_data)):
                                        foreach ($reports_data as $report): 
                                            $pdf_url = trim(env('AWS_PATH') . 'sales-snap-shot/' . $report['report_url']);
                                            $email = $report['email_address'];
                                    ?>
                                    <tr>
                                        <td>
                                            <span style="display:none;"><?php echo strtotime($report['created_at']); ?></span>
                                            <?php echo date('d M y H:i', strtotime($report['created_at'])); ?>
                                        </td>
                                        <td><?php echo $report['first_name'] . ' ' . $report['last_name']; ?></td>
                                        <td><?php echo $report['area_name']; ?></td>
                                        <td class="text-center">
                                            <div class="action-cell-btns">
                                                <?php if (!empty($report['report_url'])): ?>
                                                    <a href="<?php echo $pdf_url; ?>" class="btn btn-sm btn-success btn-icon-split" target="_blank" download>
                                                        <span class="icon text-white-50"><i class="fas fa-download"></i></span>
                                                        <span class="text">Download</span>
                                                    </a>
                                                    <a href="javascript:void(0);" class="btn btn-sm btn-info btn-icon-split" onclick="sendEmailToSalesRep('<?=$email;?>', '<?=$pdf_url;?>');">
                                                        <span class="icon text-white-50"><i class="fas fa-envelope"></i></span>
                                                        <span class="text">Send</span>
                                                    </a>
                                                <?php else: ?>
                                                    <span class="text-muted"><small>N/A</small></span>
                                                <?php endif;?>
                                            </div>
                                        </td>
                                    </tr>
                                    <?php endforeach; 
                                    else: ?>
                                        <tr>
                                            <td colspan="4" class="text-center">No reports found.</td>
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

<script src="<?php echo base_url(); ?>assets/libs/jquery-1.12.4.min.js"></script>

<script>
    function sendEmailToSalesRep(email, url) {
        $("#page-preloader").show();
        $.ajax({
            url: base_url + "send-sales-snap-shot-email",
            type: "post",
            data: {
                email : email,
                url: url,
                key: 'snapshot-email'
            },
            success: function (response) {
                let res = JSON.parse(response);
                console.log(res);
                if (res.status == "success") {
                    $('#successMsg').html(res.message).removeClass('hide').addClass('show');
                    setTimeout(function () {
                        $('#successMsg').html('').removeClass('show').addClass('hide');
                    },3000);
                } else {
                    $('#errorMsg').html(res.message).removeClass('hide').addClass('show');
                    setTimeout(function () {
                        $('#errorMsg').html('').removeClass('show').addClass('hide');
                    },3000);
                }
                $("#page-preloader").hide();
            },
            complete: function (res) {
                $("#page-preloader").hide();
            }
        });
    }
</script>
