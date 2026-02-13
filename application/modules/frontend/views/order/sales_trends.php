

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
