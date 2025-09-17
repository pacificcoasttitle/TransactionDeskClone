
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
                    <th rowspan="3">Quality<br>Rating</th>
                    <th colspan="9">Closings by Production (<?php echo $monthName; ?>)</th>
                    <th colspan="9">Revenue by Production (<?php echo $monthName; ?>)</th>
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
                    <th>Today</th>
                    <th>MTD</th>
                    <th>Prior</th>
                    <th>Today</th>
                    <th>MTD</th>
                    <th>Prior</th>
                    <th>Today</th>
                    <th>MTD</th>
                    <th>Prior</th>
                    <th>Today</th>
                    <th>MTD</th>
                    <th>Prior</th>
                    <th>Today</th>
                    <th>MTD</th>
                    <th>Prior</th>
                    <th>Today</th>
                    <th>MTD</th>
                    <th>Prior</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($branch['title_officer'] as $titleOfficerId => $titleOfficerDetails) {
                    // echo "<pre>";
                    // print_r($branch);die;
                    ?>
                <tr>
                    <td class="title-officer-name"><?php echo $titleOfficerDetails['officer_name'] ?></td>
                    <!-- <td class="percentage low-performance"><?php echo $titleOfficerDetails['closing_ratio'] ?>%</td> -->
                    <td class="percentage low-performance"><?php echo 0; ?>%</td>
                    
                    <td class="number"><?php echo $titleOfficerDetails['today_purchase_cnt'] ?></td>
                    <td class="number"><?php echo $titleOfficerDetails['mtd_purchase_cnt'] ?></td>
                    <td class="number"><?php echo $titleOfficerDetails['prior_purchase_cnt'] ?></td>
                    
                    <td class="number"><?php echo $titleOfficerDetails['today_refi_cnt'] ?></td>
                    <td class="number"><?php echo $titleOfficerDetails['mtd_refi_cnt'] ?></td>
                    <td class="number"><?php echo $titleOfficerDetails['prior_refi_cnt'] ?></td>
                    
                    <td class="number">0</td>
                    <td class="number">0</td>
                    <td class="number">0</td>
                    
                    <td class="currency">$<?php echo round($titleOfficerDetails['today_purchase_rev'], 2); ?></td>
                    <td class="currency">$<?php echo round($titleOfficerDetails['mtd_purchase_rev'], 2); ?></td>
                    <td class="currency">$<?php echo round($titleOfficerDetails['prior_purchase_rev'], 2); ?></td>
                    
                    <td class="currency">$<?php echo round($titleOfficerDetails['today_refi_rev'], 2); ?></td>
                    <td class="currency">$<?php echo round($titleOfficerDetails['mtd_refi_rev'], 2); ?></td>
                    <td class="currency">$<?php echo round($titleOfficerDetails['prior_refi_rev'], 2); ?></td>
                    
                    <td class="currency">$0</td>
                    <td class="currency">$0</td>
                    <td class="currency">$0</td>
                </tr>
                <?php }?>
                
            </tbody>
        </table>
    </div>
</div>
<?php }?>

<!-- <div class="report-footer">
    <p>Report generated on August 21, 2025 at 03:21 PM | Pacific Coast Title Company</p>
    <p>Title Officer Performance Analysis - Mapping File ONLY (No Cross-Branch)</p>
</div> -->