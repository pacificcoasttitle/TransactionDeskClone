<div class="branch-section">
    <!-- <button class="branch-toggle" onclick="toggleBranch('<?php echo $branchName; ?>')">
        <span>🏢 <?php echo $branchName; ?> Branch (<?php echo count($branch['sales_reps']); ?> Sales Reps)</span>
        <span class="toggle-icon" id="<?php echo $branchName; ?>-icon">▼</span>
    </button> -->
    <div class="branch-content">

        <table class="salesrep-table">
            <thead>
                <tr>
                    <!-- <th rowspan="3">Sales Representative</th>
                    <th rowspan="3">4-Month<br>Closing Ratio</th>
                    <th colspan="9">Closings by Production (<?php echo $daysDetails['monthName']; ?>)</th>
                    <th colspan="9">Revenue by Production (<?php echo $daysDetails['monthName']; ?>)</th> -->
                    <th rowspan="2">Sales Representative</th>
                    <th rowspan="2">4-Month<br>Closing Ratio</th>
                    <th colspan="3">Revenue by Production (<?php echo $daysDetails['monthName']; ?>)</th>
                    <!-- <th colspan="9">Revenue by Production (<?php echo $daysDetails['monthName']; ?>)</th> -->
                </tr>
                <tr>
                    <th>Total Revenue</th>
                    <th>Projected</th>
                    <th>Prior</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                    $totalRev = $totalProjectedRev = $totalPriorRev = 0;
                    foreach($branches as $salesName => $salesDetails) {
                ?>
                <tr>
                    <td class="salesrep-name"><?php echo $salesDetails['sales_rep'] ?></td>
                    <td class="percentage high-performance"><?php echo $salesDetails['closing_ratio'] ?>%</td>
                    
                    <td class="number"><?php echo number_format(round($salesDetails['total_rev'])); ?></td>
                    <td class="number"><?php echo number_format(round($salesDetails['projected_rev'])); ?></td>
                    <td class="number"><?php echo number_format(round($salesDetails['prior_rev'])); ?></td>
                    
                    
                    <?php
                        
                        $totalRev += $salesDetails['total_rev'];
                        $totalProjectedRev += $salesDetails['projected_rev'];
                        $totalPriorRev += $salesDetails['prior_rev'];

                    ?>
                </tr>
                <?php }?>
                <tr>
                    <td class="salesrep-name"><strong>Total</strong></td>
                    <td class="percentage high-performance">-</td>
                    
                    <td class="number"><strong><?php echo number_format(round($totalRev)); ?></strong></td>
                    <td class="number"><strong><?php echo number_format(round($totalProjectedRev)); ?></strong></td>
                    <td class="number"><strong><?php echo number_format(round($totalPriorRev)); ?></strong></td>
                    
                </tr>
            </tbody>
        </table>
    </div>
</div>

<!-- <div class="report-footer">
    <p>Report generated on August 21, 2025 at 02:59 PM | Pacific Coast Title Company</p>
    <p>Sales Representative Performance Analysis - R-14 Report | Mapping File Based Assignment</p>
</div> -->