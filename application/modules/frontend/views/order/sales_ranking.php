

<div class="pct-home-modern">
<section class="section-type-4a section-defaulta" style="padding-bottom:0;">
    <div class="container-fluid px-4 py-4">
        <!-- Page Header -->
        <div class="row mb-4">
            <div class="col-12">
                <h1 class="pct-page-title">Sales Ranking</h1>
                <p class="pct-page-sub month-title">Ranking based on production figures for <b class="month-name"><?php echo date('F');?></b></p>
                <p class="pct-page-sub year-title" style="display: none;">Ranking based on production figures for the year <b class="year-name"><?php echo date('Y');?></b></p>
            </div>
        </div>

        <!-- Ranking Table -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Ranking Overview</h6>
                <div class="filter-row">
                    <div id="year_listing">
                        <select name="year" id="year" style="width:auto;">
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
                                <option value="<?php echo $value;?>"><?php echo $value;?></option>
                            <?php }?>
                        </select>
                    </div>
                    <div id="month_listing">
                        <select name="month_year" id="month_year" style="width:auto;">
                            <option value="">Select Month</option>
                            <?php 
                            $currentMonth = date("Y-m");
                            for ($i = 0; $i < 12; $i++) { 
                                $date = strtotime("-$i month");
                                $value = date("Y-m", $date);
                                $label = date("F Y", $date);
                                if ((int)date('Y', $date) < 2025) {
                                    break;
                                }
                                if (((int)date('m', $date) < 3) && ((int)date('Y', $date) == 2025)) {
                                    break;
                                }
                            ?>
                                <option <?php echo ($value == $currentMonth) ? 'selected' : ''; ?> value="<?php echo $value;?>"><?php echo $label;?></option>
                            <?php }?>
                        </select>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div id="sales_ranking_success_msg" class="w-100 alert alert-success alert-dismissible" style="display:none;"></div>
                <div id="sales_ranking_error_msg" class="w-100 alert alert-danger alert-dismissible" style="display:none;"></div>
                <div class="table-responsive">
                    <table class="table table-bordered" id="sales_ranking" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>Sales Rep.</th>
                                <th>Total Openings</th>
                                <th>Total Closings</th>
                                <th>Total Revenue</th>
                                <th>Closing Ratio</th>
                                <th>Rank</th>
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
