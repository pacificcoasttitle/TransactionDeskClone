<style>
/* Title Officer Production History – same design tokens as dashboard */
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
.pct-home-modern .table tbody td a { color: var(--pct-primary); text-decoration: none; font-weight: 500; }
.pct-home-modern .table tbody td a:hover { text-decoration: underline; }

/* Empty state */
.pct-home-modern .empty-state td {
    padding: 2rem !important;
    color: var(--pct-text-muted);
    font-size: 0.9375rem;
}

/* Modal */
#revenue_model .modal-content {
    border-radius: 12px;
    border: 1px solid #e2e8f0;
    box-shadow: 0 4px 12px rgba(0,0,0,.08);
}
#revenue_model .card { border: none; box-shadow: none; }
#revenue_model .card-header {
    background: var(--pct-surface-2);
    border-bottom: 1px solid var(--pct-border);
}
</style>

<div class="pct-home-modern">
<section class="section-type-4a section-defaulta" style="padding-bottom:0;">
    <div class="container-fluid px-4 py-4">
        <!-- Page Header -->
        <div class="row mb-4">
            <div class="col-12">
                <h1 class="pct-page-title">Production History</h1>
                <p class="pct-page-sub">Below is list of your month order's count for the current year of <b class="month-name"><?php echo date('Y');?></b></p>
            </div>
        </div>

        <!-- Production History Table -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Monthly Production</h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="title_officer_production_history_tab" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>Month</th>
                                <th>Trending</th>
                                <th>Total Openings</th>
                                <th>Total Closings</th>
                                <th>Total Revenue</th>
                                <th>Closing %</th>
                            </tr>
                        </thead>
                        <?php if(!empty($salesHistory)) {?>
                            <tbody>
                                <?php foreach($salesHistory as $salesData) { ?>
                                    <tr>
                                        <td><?php echo $salesData['month'];?></td>
                                        <td><?php echo $salesData['trending'];?></td>
                                        <td><?php echo $salesData['total_open_count'];?></td>
                                        <td><?php echo $salesData['total_close_count'];?></td>
                                        <td><a href="javascript:void(0)" onclick="getRevenueDataBasedOnMonth('<?php echo $salesData['month_val']?>');"><?php echo "$".number_format($salesData['total_premium']);?></a></td>
                                        <td><?php echo $salesData['close_order_percetage']."%";?></td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        <?php } else {?>
                            <tbody>
                                <tr class="empty-state">
                                    <td colspan="6">No Records Found.</td>
                                </tr>
                            </tbody>
                        <?php } ?>
                    </table>
                </div>
            </div>
        </div>
    </div>
</section>
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
