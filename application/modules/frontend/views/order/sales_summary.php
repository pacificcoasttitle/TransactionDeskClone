<style>
/* Sales Summary – same design tokens as dashboard */
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
.pct-home-modern .pct-page-sub { font-size: 0.9375rem; color: var(--pct-text-muted); margin: 0.25rem 0 0; }

/* Header actions */
.pct-home-modern .header-actions {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    flex-wrap: wrap;
}

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

/* Buttons */
.pct-home-modern .btn {
    font-weight: 500;
    font-size: 0.875rem;
    border-radius: var(--pct-radius-sm);
    transition: opacity .15s ease, background .15s ease, border-color .15s ease;
}
.pct-home-modern .btn-primary { background: var(--pct-primary); border-color: var(--pct-primary); color: #fff; }
.pct-home-modern .btn-primary:hover { background: var(--pct-primary-light); border-color: var(--pct-primary-light); color: #fff; }
.pct-home-modern .btn-sm { padding: 0.375rem 0.75rem; min-width: 2rem; }

/* Card styling */
.pct-home-modern .card {
    border: 1px solid var(--pct-border);
    border-radius: var(--pct-radius);
    box-shadow: var(--pct-shadow);
    overflow: hidden;
    margin-bottom: 0.75rem;
}
.pct-home-modern .card-body { padding: 1.25rem; background: var(--pct-surface); }

/* Summary cards */
.pct-home-modern .custom__task_card {
    border: 1px solid var(--pct-border);
    border-radius: var(--pct-radius-sm);
    background: var(--pct-surface);
    margin-bottom: 0.5rem;
}
.pct-home-modern .custom__task_card.header-card {
    background: var(--pct-surface-2);
}
.pct-home-modern .summary-row {
    display: flex;
    align-items: center;
    padding: 0.875rem 1.25rem;
}
.pct-home-modern .summary-col {
    font-size: 0.9375rem;
    color: var(--pct-text);
}
.pct-home-modern .summary-col.title {
    font-size: 0.8125rem;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.03em;
    color: var(--pct-text-muted);
}
.pct-home-modern .summary-col-rep { flex: 0 0 25%; }
.pct-home-modern .summary-col-company { flex: 0 0 45%; }
.pct-home-modern .summary-col-deals { flex: 0 0 15%; text-align: center; }
.pct-home-modern .summary-col-action { flex: 0 0 15%; text-align: right; }

/* Collapse arrow */
.pct-home-modern .custom__collapse_arrow {
    color: var(--pct-primary);
    font-size: 1rem;
    padding: 0.25rem 0.5rem;
}
.pct-home-modern .custom__collapse_arrow .fa-angle-up { display: none; }
.pct-home-modern .custom__collapse_arrow.collapsed .fa-angle-down { display: inline; }
.pct-home-modern .custom__collapse_arrow.collapsed .fa-angle-up { display: none; }
.pct-home-modern .custom__collapse_arrow:not(.collapsed) .fa-angle-down { display: none; }
.pct-home-modern .custom__collapse_arrow:not(.collapsed) .fa-angle-up { display: inline; }

/* Collapse content */
.pct-home-modern .custom__task_collapse .card-body {
    border-top: 1px solid var(--pct-border);
    background: var(--pct-surface-2);
    padding: 1rem 1.25rem;
}
.pct-home-modern .tagline { font-size: 0.875rem; font-weight: 600; color: #059669; margin-bottom: 0.75rem; }

/* Table styling */
.pct-home-modern .table { margin-bottom: 0; }
.pct-home-modern .table thead th {
    background: var(--pct-surface);
    border-bottom: 2px solid var(--pct-border);
    font-size: 0.75rem;
    font-weight: 600;
    color: var(--pct-text);
    text-transform: uppercase;
    letter-spacing: 0.03em;
    padding: 0.625rem 0.75rem;
    text-align: left;
}
.pct-home-modern .table tbody td {
    padding: 0.625rem 0.75rem;
    font-size: 0.875rem;
    color: var(--pct-text);
    border-bottom: 1px solid var(--pct-border);
    vertical-align: middle;
}
.pct-home-modern .table tbody tr:hover { background: var(--pct-primary-soft); }
.pct-home-modern .table tbody tr:last-child td { border-bottom: none; }

/* Empty state */
.pct-home-modern .empty-state {
    text-align: center;
    padding: 2rem;
    color: var(--pct-text-muted);
    font-size: 0.9375rem;
}
</style>

<div class="pct-home-modern">
<section class="section-type-4a section-defaulta" style="padding-bottom:0;">
    <div class="container-fluid px-4 py-4">
        <!-- Page Header -->
        <div class="pct-page-header">
            <div>
                <h1 class="pct-page-title">Sales Summary</h1>
                <p class="pct-page-sub">Below you will find a summary of the clients who you closed a transaction(s) with this year.</p>
            </div>
            <div class="header-actions custom__task_button">
                <?php if (!empty($salesUsers)) { ?>
                    <select name="sales_user_summary_filter" id="sales_user_summary_filter" class="select_user" style="width:auto;">
                        <?php foreach($salesUsers as $salesUser) { ?>
                            <option <?php echo ($sales_user_id == $salesUser['id']) ? 'selected' : '' ;?> value="<?php echo $salesUser['id'];?>"><?php echo $salesUser['first_name']." ".$salesUser['last_name'];?></option>
                        <?php }?>
                    </select>
                <?php } ?>
                <button type="button" class="btn btn-primary btn-sm task_show_all"><i class="fa fa-plus"></i></button>
                <button type="button" class="btn btn-primary btn-sm task_hide_all"><i class="fa fa-minus"></i></button>
            </div>
        </div>
        <div id="result"></div>

        <!-- Summary Cards -->
        <form method="post">
            <!-- Header Row -->
            <div class="custom__task_card header-card">
                <div class="summary-row">
                    <div class="summary-col summary-col-rep title">Sales Rep</div>
                    <div class="summary-col summary-col-company title">Company Name</div>
                    <div class="summary-col summary-col-deals title"># of Deals</div>
                    <div class="summary-col summary-col-action"></div>
                </div>
            </div>

            <?php if (!empty($summary_info)) {
                foreach($summary_info as $summary) {
                    if ($summary['parent_id'] == 0) { 
                        $keys = array();
                        $keys = array_keys(array_column($summary_info, 'parent_id'), $summary['company_id']);?>
                        <div class="custom__task_card">
                            <div class="summary-row">
                                <div class="summary-col summary-col-rep"><?php echo $summary['sales_name']; ?></div>
                                <div class="summary-col summary-col-company"><?php echo $summary['company_name']; ?></div>
                                <div class="summary-col summary-col-deals"><?php echo $summary['num_of_deals']; ?></div>
                                <div class="summary-col summary-col-action">
                                    <a href="#collapseCard_<?php echo $summary['company_id']; ?>" class="custom__collapse_arrow collapsed" data-toggle="collapse"
                                        role="button" aria-expanded="false" aria-controls="collapseCard_<?php echo $summary['company_id']; ?>">
                                        <i class="fa fa-angle-down"></i>
                                        <i class="fa fa-angle-up"></i>
                                    </a>
                                </div>
                            </div>
                            <div class="collapse custom__task_collapse" id="collapseCard_<?php echo $summary['company_id']; ?>">
                                <div class="card-body">
                                    <div class="tagline"><span>Client Summary</span></div>
                                    <table class="table table-bordered" width="100%" cellspacing="0">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Client Source Name</th>
                                                <th>Company Name</th>
                                                <th># of Deals</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php $j = 1;
                                            if (!empty($keys)) { 
                                                foreach ($keys as $key) { ?>
                                                    <tr role="row" class="odd">
                                                        <td><?php echo $j;?></td>
                                                        <td><?php echo $summary_info[$key]['name'];?></td>
                                                        <td><?php echo $summary_info[$key]['company_name'];?></td>
                                                        <td><?php echo $summary_info[$key]['num_of_deals'];?></td>
                                                    </tr>
                                                <?php $j++; }
                                            } ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    <?php }
                }
            } else { ?>
                <div class="custom__task_card">
                    <div class="empty-state">No Records Found</div>
                </div>
            <?php } ?>
        </form>
    </div>
</section>
</div>
