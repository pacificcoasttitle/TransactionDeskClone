

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
