

<div class="pct-home-modern">
<section class="section-type-4a section-defaulta" style="padding-bottom:0;">
    <div class="container-fluid px-4 py-4">
        <!-- Page Header -->
        <div class="pct-page-header">
            <h1 class="pct-page-title">Farming Reports</h1>
            <a href="<?php echo base_url(); ?>sales-dashboard/<?php echo $sales_user_id; ?>" class="btn btn-info btn-icon-split">
                <span class="icon text-white-50"><i class="fas fa-arrow-left"></i></span>
                <span class="text">Back</span>
            </a>
        </div>

        <!-- Reports Table -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Your Generated Reports</h6>
            </div>
            <div class="card-body">
                <div class="alert alert-success hide" id="successMsg"></div>
                <div class="alert alert-danger hide" id="errorMsg"></div>
                <div class="table-responsive">
                    <table class="table table-bordered" id="report_listing" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>Date</th>
                                <th>Report Type</th>
                                <th>Input Options</th>
                                <th>Download</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php if (!empty($reports_data)) {
                            $monthNameList = [1 => "January", 2 => "February", 3 => "March", 4 => "April", 5 => "May", 6 => "June", 7 => "July", 8 => "August", 9 => "September", 10 => "October", 11 => "November", 12 => "December"];
                            foreach ($reports_data as $report) {
                                $pdf_url = '';
                                $area = $report['area'];
                                $option = $report['option'];
                                if ($report['report_type'] == 'County Report') {
                                    $pdf_url = trim(env('AWS_PATH') . 'sales-activity/' . $report['report_url']);
                                    $option = $monthNameList[$report['option']];
                                } else if ($report['report_type'] == 'Sales Activity') {
                                    $pdf_url = trim(env('AWS_PATH') . 'sales-snap-shot/' . $report['report_url']);
                                } else if ($report['report_type'] == 'FAR Report') {
                                    $pdf_url = trim(env('AWS_PATH') . 'sales-rep/pdf/' . $report['report_url']);
                                }
                                $email = $report['email_address'];?>
                            <tr>
                                <td><span style="display:none;"><?php echo strtotime($report['created_at']); ?></span><?php echo date('m/d/Y', strtotime($report['created_at'])); ?></td>
                                <td><?php echo $report['report_type']; ?></td>
                                <td><?php echo $option; ?> & <?php echo $area; ?></td>
                                <td class="align-btn">
                                    <?php if (!empty($report['report_url'])): ?>
                                        <a href="<?php echo $pdf_url; ?>" class="btn btn-success btn-icon-split" target="_blank" download>
                                            <span class="icon text-white-50"><i class="fas fa-download"></i></span>
                                            <span class="text">Download</span>
                                        </a>
                                    <?php endif;?>
                                </td>
                            </tr>
                            <?php }
                        } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</section>
</div>
