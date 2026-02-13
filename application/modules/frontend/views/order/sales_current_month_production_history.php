

<div class="pct-home-modern">
<section class="section-type-4a section-defaulta" style="padding-bottom:0;">
    <div class="container-fluid px-4 py-4">
        <!-- Page Header -->
        <div class="row mb-4">
            <div class="col-12">
                <h1 class="pct-page-title">Sales Production History</h1>
                <p class="pct-page-sub">Production figures for the current month of <b class="month-name"><?php echo date('F');?></b></p>
            </div>
        </div>

        <!-- Production History Table -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Current Month Summary</h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="production_history_table" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>Sales Rep.</th>
                                <th>Total Openings</th>
                                <th>Total Closings</th>
                                <th>Total Revenue</th>
                            </tr>
                        </thead>
                        <?php if(!empty($salesHistory)) {?>
                            <tbody>
                                <?php foreach($salesHistory as $salesData) { ?>
                                    <tr>
                                        <td><?php echo $salesData['sales_rep'];?></td>
                                        <td><?php echo $salesData['total_open_count'];?></td>
                                        <td><?php echo $salesData['total_close_count'];?></td>
                                        <td><?php echo "$".number_format($salesData['total_premium']);?></td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        <?php } else {?>
                            <tbody>
                                <tr>
                                    <td colspan="4" class="empty-state">No Records Found.</td>
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
