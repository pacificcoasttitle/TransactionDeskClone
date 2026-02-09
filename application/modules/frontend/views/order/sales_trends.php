<style>
/* Sales Trends – same design tokens as dashboard */
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
.pct-home-modern .pct-page-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    flex-wrap: wrap;
    gap: 1rem;
    margin-bottom: 1.5rem;
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

/* Chart area */
.pct-home-modern .chart-area {
    position: relative;
    height: 300px;
    width: 100%;
}
</style>

<div class="pct-home-modern">
<section class="section-type-4a section-defaulta" style="padding-bottom:0;">
    <div class="container-fluid px-4 py-4">
        <!-- Page Header -->
        <div class="pct-page-header">
            <h1 class="pct-page-title">Trends</h1>
            <?php if(!empty($salesUsers) && $is_sales_rep_manager == 1) { ?>
                <div id="sales_user_listing">
                    <select name="sales_user_trend_filter" id="sales_user_trend_filter" style="width:auto;">
                        <?php foreach($salesUsers as $salesUser) { ?>
                            <option <?php echo ($sales_user_id == $salesUser['id']) ? 'selected' : '';?> value="<?php echo $salesUser['id'];?>"><?php echo $salesUser['first_name']." ".$salesUser['last_name'];?></option>
                        <?php }?>
                    </select>
                </div>
            <?php } ?>
        </div>

        <!-- Title Openings Chart -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Title Openings MTD Overview</h6>
            </div>
            <div class="card-body">
                <div class="chart-area">
                    <canvas id="openOrdersChart"></canvas>
                </div>
            </div>
        </div>

        <!-- Title Closings Chart -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Title Closings MTD Overview</h6>
            </div>
            <div class="card-body">
                <div class="chart-area">
                    <canvas id="closedOrderChart"></canvas>
                </div>
            </div>
        </div>

        <!-- Title Revenue Chart -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Title Revenue MTD Overview</h6>
            </div>
            <div class="card-body">
                <div class="chart-area">
                    <canvas id="premiumTotalChart"></canvas>
                </div>
            </div>
        </div>
    </div>
</section>
</div>

<script>
    var salesData = <?php echo json_encode($salesHistory);?>;
</script>
