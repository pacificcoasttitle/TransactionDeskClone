

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
