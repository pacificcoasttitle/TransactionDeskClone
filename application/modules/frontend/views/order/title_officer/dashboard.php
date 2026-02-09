<style>
/* Title Officer Dashboard – same design tokens as dashboard */
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
.pct-home-modern .pct-page-sub { font-size: 0.9375rem; color: var(--pct-text-muted); margin: 0; }
.pct-home-modern .month-name { color: var(--pct-primary); font-weight: 600; }

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
}
.pct-home-modern .stat-card.border-left-primary { border-left: 4px solid var(--pct-primary); }
.pct-home-modern .stat-card.border-left-success { border-left: 4px solid #059669; }
.pct-home-modern .stat-card.border-left-info { border-left: 4px solid #0891b2; }
.pct-home-modern .stat-card.border-left-warning { border-left: 4px solid #d97706; }

.pct-home-modern .stat-card .stat-value {
    font-size: 2.5rem;
    font-weight: 700;
    text-align: center;
    line-height: 1.1;
    margin-bottom: 0.5rem;
}
.pct-home-modern .stat-card .stat-value.text-primary { color: var(--pct-primary); }
.pct-home-modern .stat-card .stat-value.text-success { color: #059669; }
.pct-home-modern .stat-card .stat-value.text-info { color: #0891b2; }
.pct-home-modern .stat-card .stat-value.text-warning { color: #d97706; }
.pct-home-modern .stat-card .stat-value a { color: inherit; text-decoration: none; }
.pct-home-modern .stat-card .stat-value a:hover { opacity: 0.8; }

.pct-home-modern .stat-card .stat-divider {
    border-top: 1px solid var(--pct-border);
    padding-top: 0.75rem;
    margin-top: 0.5rem;
}
.pct-home-modern .stat-card .stat-detail {
    font-size: 0.875rem;
    color: var(--pct-text-muted);
    text-align: center;
    text-transform: uppercase;
    margin-bottom: 0.25rem;
}
.pct-home-modern .stat-card .stat-projected {
    font-size: 0.875rem;
    font-weight: 600;
    text-align: center;
    text-transform: uppercase;
    margin-top: 0.75rem;
}
.pct-home-modern .stat-card .stat-projected.text-primary { color: var(--pct-primary); }
.pct-home-modern .stat-card .stat-projected.text-success { color: #059669; }
.pct-home-modern .stat-card .stat-projected.text-info { color: #0891b2; }
.pct-home-modern .stat-card .stat-projected.text-warning { color: #d97706; }

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

/* Modals */
#partnersModal .modal-content,
#revenue_model .modal-content {
    border-radius: 12px;
    border: 1px solid #e2e8f0;
    box-shadow: 0 4px 12px rgba(0,0,0,.08);
}
#partnersModal .modal-header,
#revenue_model .card-header {
    background: var(--pct-surface-2);
    border-bottom: 1px solid var(--pct-border);
}
#partnersModal .modal-footer { border-top: 1px solid var(--pct-border); }
#revenue_model .card { border: none; box-shadow: none; }

/* Buttons */
.pct-home-modern .btn {
    font-weight: 500;
    font-size: 0.875rem;
    border-radius: var(--pct-radius-sm);
}
.pct-home-modern .btn-danger { background: #dc2626; border-color: #dc2626; color: #fff; }
.pct-home-modern .btn-danger:hover { background: #b91c1c; border-color: #b91c1c; color: #fff; }

/* Alerts */
.pct-home-modern .alert { border-radius: var(--pct-radius-sm); font-size: 0.875rem; }
.pct-home-modern .alert-success { background: #d1fae5; border-color: #a7f3d0; color: #065f46; }
.pct-home-modern .alert-danger { background: #fee2e2; border-color: #fecaca; color: #991b1b; }

/* Card styling */
.pct-home-modern .card {
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
</style>

<div class="pct-home-modern">
<section class="section-type-4a section-defaulta" style="padding-bottom:0;">
    <div class="container-fluid px-4 py-4">
        <!-- Page Header -->
        <div class="row mb-4">
            <div class="col-12">
                <h1 class="pct-page-title">Welcome Back <?php echo $name; ?></h1>
                <p class="pct-page-sub">Production figures for the current month of <b class="month-name"><?php echo date('F');?></b></p>
                <input type="hidden" name="user_id" id="user_id" value="<?php echo $user_id;?>">
            </div>
        </div>

        <!-- Stat Cards Title Row -->
        <div class="row mb-2">
            <div class="col-md-3 col-sm-12">
                <div class="title text-primary" style="font-size: 0.8125rem; font-weight: 600; text-transform: uppercase; letter-spacing: 0.03em;">Title Openings MTD</div>
            </div>
            <div class="col-md-3 col-sm-12">
                <div class="title text-success" style="font-size: 0.8125rem; font-weight: 600; text-transform: uppercase; letter-spacing: 0.03em; color: #059669;">Title Closings MTD</div>
            </div>
            <div class="col-md-3 col-sm-12">
                <div class="title text-info" style="font-size: 0.8125rem; font-weight: 600; text-transform: uppercase; letter-spacing: 0.03em; color: #0891b2;">Title Revenue MTD</div>
            </div>
            <div class="col-md-3 col-sm-12">
                <div class="title text-warning" style="font-size: 0.8125rem; font-weight: 600; text-transform: uppercase; letter-spacing: 0.03em; color: #d97706;">Closings Ratio Avg</div>
            </div>
        </div>

        <!-- Stat Cards Row -->
        <div class="row mb-4">
            <!-- Title Openings MTD -->
            <div class="col-md-3 col-sm-12 mb-3">
                <div class="stat-card border-left-primary">
                    <div class="stat-value text-primary" id="open_order_count"><?php echo $total_open_count; ?></div>
                    <div class="stat-divider">
                        <div class="stat-detail">Sales = <span id="sale_open_count"><?php echo $sale_open_count;?></span></div>
                        <div class="stat-detail">Refi's = <span id="refi_open_count"><?php echo $refi_open_count;?></span></div>
                    </div>
                    <div class="stat-projected text-primary">
                        Projected = <span id="projected_open_section"><?php echo $projected_open_count;?></span>
                    </div>
                </div>
            </div>

            <!-- Title Closings MTD -->
            <div class="col-md-3 col-sm-12 mb-3">
                <div class="stat-card border-left-success">
                    <div class="stat-value text-success" id="close_order_count"><?php echo $total_close_count; ?></div>
                    <div class="stat-divider">
                        <div class="stat-detail">Sales = <span id="sale_close_count"><?php echo $sale_close_count;?></span></div>
                        <div class="stat-detail">Refi's = <span id="refi_close_count"><?php echo $refi_close_count;?></span></div>
                    </div>
                    <div class="stat-projected text-success">
                        Projected = <span id="projected_close_section"><?php echo $projected_close_count;?></span>
                    </div>
                </div>
            </div>

            <!-- Title Revenue MTD -->
            <div class="col-md-3 col-sm-12 mb-3">
                <div class="stat-card border-left-info">
                    <div class="stat-value text-info" id="total_premium">
                        <a href="javascript:void(0)" onclick="getRevenueData();">$<span id="total_premium"><?php echo number_format($total_premium); ?></span></a>
                    </div>
                    <div class="stat-divider">
                        <div class="stat-detail">Sales = $<span id="sale_total_premium"><?php echo $sale_total_premium;?></span></div>
                        <div class="stat-detail">Refi's = $<span id="refi_total_premium"><?php echo $refi_total_premium;?></span></div>
                    </div>
                    <div class="stat-projected text-info">
                        Projected = $<span id="projected_revenue_section"><?php echo number_format($projected_revenue);?></span>
                    </div>
                </div>
            </div>

            <!-- Closings Ratio Avg -->
            <div class="col-md-3 col-sm-12 mb-3">
                <div class="stat-card border-left-warning">
                    <div class="stat-value text-warning" id="close_order_percetage"><?php echo $close_order_percetage; ?>%</div>
                    <div class="stat-divider">
                        <div class="stat-detail">Sales = <span id="sale_close_order_percetage"><?php echo $sale_close_order_percetage;?></span>%</div>
                        <div class="stat-detail">Refi's = <span id="refi_close_order_percetage"><?php echo $refi_close_order_percetage;?></span>%</div>
                    </div>
                    <div class="stat-projected text-warning">
                        Projected = 0%
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
</div>

<!-- Partners Modal -->
<div class="modal" id="partnersModal">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Partners</h4>
            </div>
            <div class="modal-body">
                <table class="table table-striped" id="tbl-partners-data">
                    <thead>
                        <tr>
                            <th>PartnerID</th>
                            <th>PartnerTypeID</th>
                            <th>PartnerTypeName</th>
                            <th>PartnerName</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
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
