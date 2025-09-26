
 <?php 
    foreach($branches as $branchName => $branch) {
        // echo "<pre>";
        // print_r($branchName);
        // print_r($branch);die;
    // }
?>
<div class="branch-section">
    <button class="branch-toggle" onclick="toggleBranch('<?php echo $branchName; ?>')">
        <span>🏢 <?php echo $branchName; ?> Branch (<?php echo count($branch['title_officer']); ?> Title Officers)</span>
        <span class="toggle-icon" id="<?php echo $branchName; ?>-icon">▼</span>
    </button>
    <div class="branch-content" id="<?php echo $branchName; ?>">

        <table class="title-table">
            <thead>
                <tr>
                    <th rowspan="3">Title Officer</th>
                    <!-- <th rowspan="3">Quality<br>Rating</th> -->
                    <th colspan="9">Closings by Production (<?php echo $daysDetails['monthName']; ?>)</th>
                    <th colspan="9">Revenue by Production (<?php echo $daysDetails['monthName']; ?>)</th>
                </tr>
                <tr>
                    <th colspan="3">Resale</th>
                    <th colspan="3">Refinance</th>
                    <th colspan="3">Commercial</th>
                    <th colspan="3">Resale</th>
                    <th colspan="3">Refinance</th>
                    <th colspan="3">Commercial</th>
                </tr>
                <tr>
                    <th><?php echo date('m-d-Y', strtotime('-1 day')) ?></th>
                    <th>MTD</th>
                    <th>Prior</th>
                    <th><?php echo date('m-d-Y', strtotime('-1 day')) ?></th>
                    <th>MTD</th>
                    <th>Prior</th>
                    <th><?php echo date('m-d-Y', strtotime('-1 day')) ?></th>
                    <th>MTD</th>
                    <th>Prior</th>
                    <th><?php echo date('m-d-Y', strtotime('-1 day')) ?></th>
                    <th>MTD</th>
                    <th>Prior</th>
                    <th><?php echo date('m-d-Y', strtotime('-1 day')) ?></th>
                    <th>MTD</th>
                    <th>Prior</th>
                    <th><?php echo date('m-d-Y', strtotime('-1 day')) ?></th>
                    <th>MTD</th>
                    <th>Prior</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                    $totalTodayPurchaseCnt = $totalMtdPurchaseCnt = $totalPriorPurchaseCnt = $totalTodayRefiCnt = $totalMtdRefiCnt = $totalPriorRefiCnt = $totalTodayEscrowCnt = $totalMtdEscrowCnt = $totalPriorEscrowCnt = 0;
                    $totalTodayPurchaseRev = $totalMtdPurchaseRev = $totalPriorPurchaseRev = $totalTodayRefiRev = $totalMtdRefiRev = $totalPriorRefiRev = $totalTodayEscrowRev = $totalMtdEscrowRev = $totalPriorEscrowRev = 0;
                    foreach($branch['title_officer'] as $titleOfficerId => $titleOfficerDetails) {
                    // echo "<pre>";
                    // print_r($branch);die;
                    if ($titleOfficerDetails['today_purchase_cnt'] > 0 || $titleOfficerDetails['mtd_purchase_cnt'] > 0 || $titleOfficerDetails['prior_purchase_cnt'] > 0 || $titleOfficerDetails['today_refi_cnt'] > 0 || $titleOfficerDetails['mtd_refi_cnt'] > 0 || $titleOfficerDetails['prior_refi_cnt'] > 0 ){
                    ?>
                <tr>
                    <td class="title-officer-name"><?php echo $titleOfficerDetails['officer_name'] ?></td>
                    <!-- <td class="percentage low-performance"><?php echo $titleOfficerDetails['closing_ratio'] ?>%</td> -->
                    <!-- <td class="percentage low-performance"><?php echo 0; ?>%</td> -->
                    
                    <td class="number"><?php echo $titleOfficerDetails['today_purchase_cnt'] ?></td>
                    <td class="number"><?php echo $titleOfficerDetails['mtd_purchase_cnt'] ?></td>
                    <td class="number"><?php echo $titleOfficerDetails['prior_purchase_cnt'] ?></td>
                    
                    <td class="number"><?php echo $titleOfficerDetails['today_refi_cnt'] ?></td>
                    <td class="number"><?php echo $titleOfficerDetails['mtd_refi_cnt'] ?></td>
                    <td class="number"><?php echo $titleOfficerDetails['prior_refi_cnt'] ?></td>
                    
                    <td class="number">0</td>
                    <!-- <td class="number"><?php echo $titleOfficerDetails['mtd_escrow_cnt'] ?></td> -->
                    <td class="number">0</td>
                    <td class="number">0</td>
                    
                    <td class="currency">$<?php echo number_format(round($titleOfficerDetails['today_purchase_rev'])); ?></td>
                    <td class="currency">$<?php echo number_format(round($titleOfficerDetails['mtd_purchase_rev'])); ?></td>
                    <td class="currency">$<?php echo number_format(round($titleOfficerDetails['prior_purchase_rev'])); ?></td>
                    
                    <td class="currency">$<?php echo number_format(round($titleOfficerDetails['today_refi_rev'])); ?></td>
                    <td class="currency">$<?php echo number_format(round($titleOfficerDetails['mtd_refi_rev'])); ?></td>
                    <td class="currency">$<?php echo number_format(round($titleOfficerDetails['prior_refi_rev'])); ?></td>
                    
                    <td class="currency">$0</td>
                    <!-- <td class="currency">$<?php echo number_format(round($titleOfficerDetails['mtd_escrow_rev'])); ?></td> -->
                    <td class="currency">$0</td>
                    <td class="currency">$0</td>
                </tr>
                <?php
                        
                        $totalTodayPurchaseCnt += $titleOfficerDetails['today_purchase_cnt'];
                        $totalMtdPurchaseCnt += $titleOfficerDetails['mtd_purchase_cnt'];
                        $totalPriorPurchaseCnt += $titleOfficerDetails['prior_purchase_cnt'];

                        $totalTodayRefiCnt += $titleOfficerDetails['today_refi_cnt'];
                        $totalMtdRefiCnt += $titleOfficerDetails['mtd_refi_cnt'];
                        $totalPriorRefiCnt += $titleOfficerDetails['prior_refi_cnt'];

                        // $totalTodayEscrowCnt += $titleOfficerDetails['today_escrow_cnt'];
                        // $totalMtdEscrowCnt += $titleOfficerDetails['mtd_escrow_cnt'];
                        // $totalPriorEscrowCnt += $titleOfficerDetails['prior_escrow_cnt'];

                        $totalTodayPurchaseRev += $titleOfficerDetails['today_purchase_rev'];
                        $totalMtdPurchaseRev += $titleOfficerDetails['mtd_purchase_rev'];
                        $totalPriorPurchaseRev += $titleOfficerDetails['prior_purchase_rev'];

                        $totalTodayRefiRev += $titleOfficerDetails['today_refi_rev'];
                        $totalMtdRefiRev += $titleOfficerDetails['mtd_refi_rev'];
                        $totalPriorRefiRev += $titleOfficerDetails['prior_refi_rev'];

                        // $totalTodayEscrowRev += $titleOfficerDetails['today_escrow_rev'];
                        // $totalMtdEscrowRev += $titleOfficerDetails['mtd_escrow_rev'];
                        // $totalPriorEscrowRev += $titleOfficerDetails['prior_escrow_rev'];
                    ?>
                <?php }}?>
                    <tr>
                        <td class="title-officer-name"><strong>Total</strong></td>
                        
                        <td class="number"><?php echo $totalTodayPurchaseCnt; ?></td>
                        <td class="number"><?php echo $totalMtdPurchaseCnt; ?></td>
                        <td class="number"><?php echo $totalPriorPurchaseCnt; ?></td>
                        
                        <td class="number"><?php echo $totalTodayRefiCnt; ?></td>
                        <td class="number"><?php echo $totalMtdRefiCnt; ?></td>
                        <td class="number"><?php echo $totalPriorRefiCnt; ?></td>
                        
                        <td class="number">0</td>
                        <td class="number">0</td>
                        <td class="number">0</td>
                        
                        <td class="currency">$<?php echo number_format(round($totalTodayPurchaseRev)); ?></td>
                        <td class="currency">$<?php echo number_format(round($totalMtdPurchaseRev)); ?></td>
                        <td class="currency">$<?php echo number_format(round($totalPriorPurchaseRev)); ?></td>
                        
                        <td class="currency">$<?php echo number_format(round($totalTodayRefiRev)); ?></td>
                        <td class="currency">$<?php echo number_format(round($totalMtdRefiRev)); ?></td>
                        <td class="currency">$<?php echo number_format(round($totalPriorRefiRev)); ?></td>
                        
                        <td class="currency">$0</td>
                        <td class="currency">$0</td>
                        <td class="currency">$0</td>
                    </tr>
                
            </tbody>
        </table>
    </div>
</div>
<?php }?>

<!-- <div class="report-footer">
    <p>Report generated on August 21025 at 03:21 PM | Pacific Coast Title Company</p>
    <p>Title Officer Performance Analysis - Mapping File ONLY (No Cross-Branch)</p>
</div> -->