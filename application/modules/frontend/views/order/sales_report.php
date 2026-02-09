<style>
/* Sales Report – same design tokens as dashboard */
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
.pct-home-modern .pct-page-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    flex-wrap: wrap;
    gap: 1rem;
    margin-bottom: 1.5rem;
}
.pct-home-modern .pct-page-title { font-size: 1.5rem; font-weight: 600; color: var(--pct-text); margin: 0; }

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
    text-align: center;
    white-space: nowrap;
}
.pct-home-modern .table tbody td {
    padding: 0.875rem 1rem;
    font-size: 0.9375rem;
    color: var(--pct-text);
    border-bottom: 1px solid var(--pct-border);
    vertical-align: middle;
    text-align: center;
}
.pct-home-modern .table tbody tr:hover { background: var(--pct-primary-soft); }
.pct-home-modern .table tbody tr:last-child td { border-bottom: none; }

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
.pct-home-modern .btn-info { background: var(--pct-primary); border-color: var(--pct-primary); color: #fff; }
.pct-home-modern .btn-info:hover { background: var(--pct-primary-light); border-color: var(--pct-primary-light); color: #fff; }
/* .pct-home-modern .btn-icon-split { display: inline-flex; align-items: center; gap: 0.5rem; }
.pct-home-modern .btn-icon-split .icon { display: flex; } */
.pct-home-modern .btn-icon-split .text { font-size: 0.875rem; }

/* Alerts */
.pct-home-modern .alert { border-radius: var(--pct-radius-sm); font-size: 0.875rem; margin-bottom: 1rem; }
.pct-home-modern .alert-success { background: #d1fae5; border-color: #a7f3d0; color: #065f46; }
.pct-home-modern .alert-danger { background: #fee2e2; border-color: #fecaca; color: #991b1b; }
.pct-home-modern .alert.hide { display: none; }

/* Action buttons in table */
.pct-home-modern .align-btn {
    display: flex;
    justify-content: center;
    gap: 0.5rem;
}

/* Pagination – same as cpl.php */
.pct-home-modern .dataTables_wrapper { padding-top: 0.75rem; }
.pct-home-modern .dataTables_wrapper .row:last-child {
    align-items: center;
    padding: 0.75rem 0;
    border-top: 1px solid var(--pct-border);
    margin-top: 0.5rem;
}
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
</style>

<div class="pct-home-modern">
<section class="section-type-4a section-defaulta" style="padding-bottom:0;">
    <div class="container-fluid px-4 py-4">
        <!-- Page Header -->
        <div class="pct-page-header">
            <h1 class="pct-page-title">Farming Reports</h1>
            <a href="<?php echo base_url(); ?>sales-dashboard/<?php echo $sales_user_id; ?>" class="btn btn-info btn-icon-split">
                <span class="icon text-white-50"><i class="fas fa-arrow-left"></i></span>
                <span class="text">Back</span>
            </a>
        </div>

        <!-- Reports Table -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Your Generated Reports</h6>
            </div>
            <div class="card-body">
                <div class="alert alert-success hide" id="successMsg"></div>
                <div class="alert alert-danger hide" id="errorMsg"></div>
                <div class="table-responsive">
                    <table class="table table-bordered" id="report_listing" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>Date</th>
                                <th>Report Type</th>
                                <th>Input Options</th>
                                <th>Download</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php if (!empty($reports_data)) {
                            $monthNameList = [1 => "January", 2 => "February", 3 => "March", 4 => "April", 5 => "May", 6 => "June", 7 => "July", 8 => "August", 9 => "September", 10 => "October", 11 => "November", 12 => "December"];
                            foreach ($reports_data as $report) {
                                $pdf_url = '';
                                $area = $report['area'];
                                $option = $report['option'];
                                if ($report['report_type'] == 'County Report') {
                                    $pdf_url = trim(env('AWS_PATH') . 'sales-activity/' . $report['report_url']);
                                    $option = $monthNameList[$report['option']];
                                } else if ($report['report_type'] == 'Sales Activity') {
                                    $pdf_url = trim(env('AWS_PATH') . 'sales-snap-shot/' . $report['report_url']);
                                } else if ($report['report_type'] == 'FAR Report') {
                                    $pdf_url = trim(env('AWS_PATH') . 'sales-rep/pdf/' . $report['report_url']);
                                }
                                $email = $report['email_address'];?>
                            <tr>
                                <td><span style="display:none;"><?php echo strtotime($report['created_at']); ?></span><?php echo date('m/d/Y', strtotime($report['created_at'])); ?></td>
                                <td><?php echo $report['report_type']; ?></td>
                                <td><?php echo $option; ?> & <?php echo $area; ?></td>
                                <td class="align-btn">
                                    <?php if (!empty($report['report_url'])): ?>
                                        <a href="<?php echo $pdf_url; ?>" class="btn btn-success btn-icon-split" target="_blank" download>
                                            <span class="icon text-white-50"><i class="fas fa-download"></i></span>
                                            <span class="text">Download</span>
                                        </a>
                                    <?php endif;?>
                                </td>
                            </tr>
                            <?php }
                        } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</section>
</div>
