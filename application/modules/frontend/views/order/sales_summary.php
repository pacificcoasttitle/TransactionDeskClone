

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
