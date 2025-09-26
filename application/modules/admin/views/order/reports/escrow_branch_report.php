<?php 
    foreach($branches as $branchName => $branch) {
        // echo "<pre>";
        // print_r($branchName);
        // print_r($branch);die;
    // }
?>
<div class="branch-section">
    <button class="branch-toggle" onclick="toggleBranch('<?php echo $branchName; ?>')">
        <span>🏢 <?php echo $branchName; ?> Branch (<?php echo count($branch['sales_reps']); ?> Sales Reps)</span>
        <span class="toggle-icon" id="<?php echo $branchName; ?>-icon">▼</span>
    </button>
    <div class="branch-content" id="<?php echo $branchName; ?>">

        <table class="salesrep-table">
            <thead>
                <tr>
                    <th rowspan="3">Sales Representative</th>
                    <th rowspan="3">4-Month<br>Closing Ratio</th>
                    <th colspan="3">Closings by Production (<?php echo $daysDetails['monthName']; ?>)</th>
                    <th colspan="3">Revenue by Production (<?php echo $daysDetails['monthName']; ?>)</th>
                </tr>
                <tr>
                    <!-- <th colspan="3">Title Only - Resale</th>
                    <th colspan="3">Title Only - Refinance</th> -->
                    <th colspan="3">Escrow Orders</th>
                    <!-- <th colspan="3">Title Only - Resale</th>
                    <th colspan="3">Title Only - Refinance</th> -->
                    <th colspan="3">Escrow Orders</th>
                </tr>
                <tr>
                    <!-- <th><?php echo date('m-d-Y', strtotime('-1 day')) ?></th>
                    <th>MTD</th>
                    <th>Prior</th>
                    <th><?php echo date('m-d-Y', strtotime('-1 day')) ?></th>
                    <th>MTD</th>
                    <th>Prior</th> -->
                    <th><?php echo date('m-d-Y', strtotime('-1 day')) ?></th>
                    <th>MTD</th>
                    <th>Prior</th>
                    <!-- <th><?php echo date('m-d-Y', strtotime('-1 day')) ?></th>
                    <th>MTD</th>
                    <th>Prior</th>
                    <th><?php echo date('m-d-Y', strtotime('-1 day')) ?></th>
                    <th>MTD</th>
                    <th>Prior</th> -->
                    <th><?php echo date('m-d-Y', strtotime('-1 day')) ?></th>
                    <th>MTD</th>
                    <th>Prior</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                    $totalTodayEscrowCnt = $totalMtdEscrowCnt = $totalPriorEscrowCnt = 0;
                    $totalTodayEscrowRev = $totalMtdEscrowRev = $totalPriorEscrowRev = 0;
                    foreach($branch['sales_reps'] as $salesId => $salesDetails) {
                ?>
                <tr>
                    <td class="salesrep-name"><?php echo $salesDetails['sales_rep'] ?></td>
                    <td class="percentage high-performance"><?php echo $salesDetails['closing_ratio'] ?>%</td>
                    
                    <!-- <td class="number"><?php echo $salesDetails['today_purchase_cnt']; ?></td>
                    <td class="number"><?php echo $salesDetails['mtd_purchase_cnt']; ?></td>
                    <td class="number"><?php echo $salesDetails['prior_purchase_cnt']; ?></td>
                    
                    <td class="number"><?php echo $salesDetails['today_refi_cnt']; ?></td>
                    <td class="number"><?php echo $salesDetails['mtd_refi_cnt']; ?></td>
                    <td class="number"><?php echo $salesDetails['prior_refi_cnt']; ?></td> -->
                    
                    <td class="number"><?php echo $salesDetails['today_escrow_cnt']; ?></td>
                    <td class="number"><?php echo $salesDetails['mtd_escrow_cnt']; ?></td>
                    <td class="number"><?php echo $salesDetails['prior_escrow_cnt']; ?></td>
                    
                    <!-- <td class="currency">$<?php echo number_format(round($salesDetails['today_purchase_rev'])); ?></td>
                    <td class="currency">$<?php echo number_format(round($salesDetails['mtd_purchase_rev'])); ?></td>
                    <td class="currency">$<?php echo number_format(round($salesDetails['prior_purchase_rev'])); ?></td>
                    
                    <td class="currency">$<?php echo number_format(round($salesDetails['today_refi_rev'])); ?></td>
                    <td class="currency">$<?php echo number_format(round($salesDetails['mtd_refi_rev'])); ?></td>
                    <td class="currency">$<?php echo number_format(round($salesDetails['prior_refi_rev'])); ?></td> -->
                    
                    <td class="currency">$<?php echo number_format(round($salesDetails['today_escrow_rev'])); ?></td>
                    <td class="currency">$<?php echo number_format(round($salesDetails['mtd_escrow_rev'])); ?></td>
                    <td class="currency">$<?php echo number_format(round($salesDetails['prior_escrow_rev'])); ?></td>
                    <?php
                        
                        // $totalTodayPurchaseCnt += $salesDetails['today_purchase_cnt'];
                        // $totalMtdPurchaseCnt += $salesDetails['mtd_purchase_cnt'];
                        // $totalPriorPurchaseCnt += $salesDetails['prior_purchase_cnt'];

                        // $totalTodayRefiCnt += $salesDetails['today_refi_cnt'];
                        // $totalMtdRefiCnt += $salesDetails['mtd_refi_cnt'];
                        // $totalPriorRefiCnt += $salesDetails['prior_refi_cnt'];

                        $totalTodayEscrowCnt += $salesDetails['today_escrow_cnt'];
                        $totalMtdEscrowCnt += $salesDetails['mtd_escrow_cnt'];
                        $totalPriorEscrowCnt += $salesDetails['prior_escrow_cnt'];

                        // $totalTodayPurchaseRev += $salesDetails['today_purchase_rev'];
                        // $totalMtdPurchaseRev += $salesDetails['mtd_purchase_rev'];
                        // $totalPriorPurchaseRev += $salesDetails['prior_purchase_rev'];

                        // $totalTodayRefiRev += $salesDetails['today_refi_rev'];
                        // $totalMtdRefiRev += $salesDetails['mtd_refi_rev'];
                        // $totalPriorRefiRev += $salesDetails['prior_refi_rev'];

                        $totalTodayEscrowRev += $salesDetails['today_escrow_rev'];
                        $totalMtdEscrowRev += $salesDetails['mtd_escrow_rev'];
                        $totalPriorEscrowRev += $salesDetails['prior_escrow_rev'];
                    ?>
                </tr>
                <?php }?>
                <tr>
                    <td class="salesrep-name"><strong>Total</strong></td>
                    <td class="percentage high-performance">-</td>
                    
                    <!-- <td class="number"><strong><?php echo $totalTodayPurchaseCnt; ?></strong></td>
                    <td class="number"><strong><?php echo $totalMtdPurchaseCnt; ?></strong></td>
                    <td class="number"><strong><?php echo $totalPriorPurchaseCnt; ?></strong></td>
                    
                    <td class="number"><strong><?php echo $totalTodayRefiCnt; ?></strong></td>
                    <td class="number"><strong><?php echo $totalMtdRefiCnt; ?></strong></td>
                    <td class="number"><strong><?php echo $totalPriorRefiCnt; ?></strong></td> -->
                    
                    <td class="number"><strong><?php echo $totalTodayEscrowCnt; ?></strong></td>
                    <td class="number"><strong><?php echo $totalMtdEscrowCnt; ?></strong></td>
                    <td class="number"><strong><?php echo $totalPriorEscrowCnt; ?></strong></td>
                    
                    <!-- <td class="currency"><strong>$<?php echo number_format(round($totalTodayPurchaseRev)); ?></strong></td>
                    <td class="currency"><strong>$<?php echo number_format(round($totalMtdPurchaseRev)); ?></strong></td>
                    <td class="currency"><strong>$<?php echo number_format(round($totalPriorPurchaseRev)); ?></strong></td>
                    
                    <td class="currency"><strong>$<?php echo number_format(round($totalTodayRefiRev)); ?></strong></td>
                    <td class="currency"><strong>$<?php echo number_format(round($totalMtdRefiRev)); ?></strong></td>
                    <td class="currency"><strong>$<?php echo number_format(round($totalPriorRefiRev)); ?></strong></td>
                     -->
                    <td class="currency"><strong>$<?php echo number_format(round($totalTodayEscrowRev)); ?></strong></td>
                    <td class="currency"><strong>$<?php echo number_format(round($totalMtdEscrowRev)); ?></strong></td>
                    <td class="currency"><strong>$<?php echo number_format(round($totalPriorEscrowRev)); ?></strong></td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
<?php }?>

<!-- <div class="report-footer">
    <p>Report generated on August 21, 2025 at 02:59 PM | Pacific Coast Title Company</p>
    <p>Sales Representative Performance Analysis - R-14 Report | Mapping File Based Assignment</p>
</div> -->