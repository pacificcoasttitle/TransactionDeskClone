

<div class="pct-home-modern">
<section class="section-type-4a section-defaulta" style="padding-bottom:0;">
    <div class="container-fluid px-4 py-4">
        <!-- Page Header -->
        <div class="row mb-4">
            <div class="col-12">
                <h1 class="pct-page-title">Sales Production History</h1>
                <p class="pct-page-sub">Order history for the year of <b class="month-name"><?php echo date('Y');?></b></p>
            </div>
        </div>

        <!-- Production History Table -->
        <div class="card shadow mb-4">
            <div class="card-header py-3" style="display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 1rem;">
                <h6 class="m-0 font-weight-bold text-primary">Monthly Production Summary</h6>
                <div style="display: flex; align-items: center; gap: 0.75rem; flex-wrap: wrap;">
                    <div id="year_listing">
                        <select name="productionYear" id="productionYear" style="width:auto;">
                            <option value="">Select Year</option>
                            <?php
                            $currentYear = date("Y");
                            for ($i = 0; $i < 5; $i++) {
                                $date = strtotime("-$i year");
                                $value = date("Y", $date);
                                if ((int)$value < 2025) {
                                    break;
                                }
                            ?>
                                <option <?php echo ($value == $currentYear) ? "selected" : '' ;?> value="<?php echo $value;?>"><?php echo $value;?></option>
                            <?php }?>
                        </select>
                    </div>
                    <?php if(!empty($salesUsers)) { ?>
                        <div id="sales_user_listing">
                            <select name="sales_user_production_filter" id="sales_user_production_filter" style="width:auto;">
                                <?php foreach($salesUsers as $salesUser) { ?>
                                    <option <?php echo ($sales_user_id == $salesUser['id']) ? 'selected' : '' ;?> value="<?php echo $salesUser['id'];?>"><?php echo $salesUser['first_name']." ".$salesUser['last_name'];?></option>
                                <?php }?>
                            </select>
                        </div>
                    <?php } ?>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="production_history_tab" width="100%" cellspacing="0">
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
                        <tbody></tbody>
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
