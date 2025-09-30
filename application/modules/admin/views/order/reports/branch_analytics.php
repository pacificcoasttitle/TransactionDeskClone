<!-- Glendale Branch -->
<?php
$today = new DateTime();

// Get total days in current month
$totalDaysInMonth = $today->format('t');

// Get current day of month
$currentDay = $today->format('j');

// Days remaining in month (excluding today)
$daysRemaining = $totalDaysInMonth - $currentDay;

// Total days passed including today
$daysPassed = $currentDay;
$daysPassed = $summaryData['workedDays'];
$daysRemaining = $summaryData['workingDaysRemaining'];
$totalDaysInMonth = $daysPassed + $daysRemaining;
// echo "Today's Day of Month: " . $currentDay . PHP_EOL;
// echo "Days Remaining (excluding today): " . $daysRemaining . PHP_EOL;
// echo "Total Days Passed (including today): " . $daysPassed . PHP_EOL;die;

?>
<div class="executive-summary">
    <div class="summary-title">📊 Company Production Totals - All Branches</div>
        <table class="branch-table">
            <thead>
                <tr>
                    <th>Metric</th>
                    <th><?php echo $summaryData['todayDate'];?></th>
                    <th>Month to Date</th>
                    <th>Avg Per Day</th>
                    <th>Projected Month</th>
                    <th>Prior Month</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td><strong>Total Openings</strong></td>.
                    <td class="number"><?php echo $summaryData['todayTotalOpen'];?></td>
                    <td class="number"><?php echo $summaryData['mtdTotalOpen'];?></td>
                    <td class="number"><?php echo number_format(round($summaryData['mtdTotalOpen']/$daysPassed));?></td>
                    <td class="number"><?php echo number_format(round(($summaryData['mtdTotalOpen']/$daysPassed)*$totalDaysInMonth));?></td>
                    <td class="number"><?php echo number_format(round($summaryData['priorTotalOpen']));?></td>
                </tr>
                <tr>
                    <td><strong>Total Closings</strong></td>
                    <td class="number"><?php echo $summaryData['todayTotalClose'];?></td>
                    <td class="number"><?php echo $summaryData['mtdTotalClose'];?></td>
                    <td class="number"><?php echo number_format(round($summaryData['mtdTotalClose']/$daysPassed));?></td>
                    <td class="number"><?php echo number_format(round(($summaryData['mtdTotalClose']/$daysPassed)*$totalDaysInMonth));?></td>
                    <td class="number"><?php echo number_format(round($summaryData['priorTotalClose']));?></td>
                </tr>
                <tr>
                    <td><strong>Total Title Premiums</strong></td>
                    <td class="currency">$<?php echo number_format(round($summaryData['todayTotalRev']));?></td>
                    <td class="currency">$<?php echo number_format(round($summaryData['mtdTotalRev']));?></td>
                    <td class="currency">$<?php echo number_format(round($summaryData['mtdTotalRev']/$daysPassed));?></td>
                    <td class="currency">$<?php echo number_format(round(($summaryData['mtdTotalRev']/$daysPassed)*$totalDaysInMonth));?></td>
                    <td class="currency">$<?php echo number_format(round($summaryData['priorTotalRev']));?></td>
                </tr>
            </tbody>
        </table>
    
</div>
<?php
foreach ($branchData as $branchName => $data) {
?>
<div class="branch-header" onclick="toggleSection('<?php echo $branchName; ?>')">
    <span>🏢 <?php echo $branchName; ?> Branch</span>
    <span class="toggle-icon" id="<?php echo $branchName; ?>-icon">▼</span>
</div>

<div class="branch-content" id="<?php echo $branchName; ?>-content">
    
    <div class="metric-header">📈 Openings Analysis</div>
    <table class="branch-table">
        <thead>
            <tr>
                <th>Service Type</th>
                <th><?php echo $summaryData['todayDate'];?></th>
                <th>Count for Month</th>
                <th>Average Per Day</th>
                <th>Projected For Month</th>
                <th>Prior Month Total</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td><strong>🏢 <?php echo $branchName; ?> TOTAL OPENINGS</strong></td>
                <td class="number"><?php echo ($data['today_escrow_open_cnt'] + $data['today_purchase_open_cnt'] + $data['today_refi_open_cnt']); ?></td>
                <td class="number"><?php echo ($data['mtd_escrow_open_cnt'] + $data['mtd_purchase_open_cnt'] + $data['mtd_refi_open_cnt']); ?></td>
                <td class="number"><?php echo number_format(round(($data['mtd_escrow_open_cnt'] + $data['mtd_purchase_open_cnt'] + $data['mtd_refi_open_cnt'])/$daysPassed)); ?></td>
                <td class="number"><?php echo number_format(round((($data['mtd_escrow_open_cnt'] + $data['mtd_purchase_open_cnt'] + $data['mtd_refi_open_cnt'])/$daysPassed)*$totalDaysInMonth)); ?></td>
                <td class="number"><?php echo ($data['prior_escrow_open_cnt'] + $data['prior_purchase_open_cnt'] + $data['prior_refi_open_cnt']); ?></td>
            </tr>
            <tr class="service-escrow">
                <td>📋 Escrow Orders</td>
                <td class="number"><?php echo $data['today_escrow_open_cnt']; ?></td>
                <td class="number"><?php echo $data['mtd_escrow_open_cnt']; ?></td>
                <td class="number"><?php echo number_format(round($data['mtd_escrow_open_cnt']/$daysPassed)); ?></td>
                <td class="number"><?php echo number_format(round(($data['mtd_escrow_open_cnt']/$daysPassed)*$totalDaysInMonth)); ?></td>
                <td class="number"><?php echo $data['prior_escrow_open_cnt']; ?></td>
            </tr>
            <tr class="service-title-resale">
                <td>📋 Title Only - Resale</td>
                <td class="number"><?php echo $data['today_purchase_open_cnt']; ?></td>
                <td class="number"><?php echo $data['mtd_purchase_open_cnt']; ?></td>
                <td class="number"><?php echo number_format(round($data['mtd_purchase_open_cnt']/$daysPassed)); ?></td>
                <td class="number"><?php echo number_format(round(($data['mtd_purchase_open_cnt']/$daysPassed)*$totalDaysInMonth)); ?></td>
                <td class="number"><?php echo $data['prior_purchase_open_cnt']; ?></td>
            </tr>
            <tr class="service-title-refi">
                <td>📋 Title Only - Refinance</td>
                <td class="number"><?php echo $data['today_refi_open_cnt']; ?></td>
                <td class="number"><?php echo $data['mtd_refi_open_cnt']; ?></td>
                <td class="number"><?php echo number_format(round($data['mtd_refi_open_cnt']/$daysPassed)); ?></td>
                <td class="number"><?php echo number_format(round(($data['mtd_refi_open_cnt']/$daysPassed)*$totalDaysInMonth)); ?></td>
                <td class="number"><?php echo $data['prior_refi_open_cnt']; ?></td>
            </tr>
        </tbody>
    </table>
    
    <div class="metric-header">🎯 Closings Analysis</div>
    <table class="branch-table">
        <thead>
            <tr>
                <th>Service Type</th>
                <th><?php echo $summaryData['todayDate'];?></th>
                <th>Count for Month</th>
                <th>Average Per Day</th>
                <th>Projected For Month</th>
                <th>Prior Month Total</th>
            </tr>
        </thead>
        <tbody >
            <tr>
                <td><strong>🏢 <?php echo $branchName; ?> TOTAL CLOSINGS</strong></td>
                <td class="number"><?php echo ($data['today_escrow_close_cnt'] + $data['today_purchase_close_cnt'] + $data['today_refi_close_cnt']); ?></td>
                <td class="number"><?php echo ($data['mtd_escrow_close_cnt'] + $data['mtd_purchase_close_cnt'] + $data['mtd_refi_close_cnt']); ?></td>
                <td class="number"><?php echo number_format(round(($data['mtd_escrow_close_cnt'] + $data['mtd_purchase_close_cnt'] + $data['mtd_refi_close_cnt'])/$daysPassed)); ?></td>
                <td class="number"><?php echo number_format(round((($data['mtd_escrow_close_cnt'] + $data['mtd_purchase_close_cnt'] + $data['mtd_refi_close_cnt'])/$daysPassed) * $totalDaysInMonth)); ?></td>
                <td class="number"><?php echo ($data['prior_escrow_close_cnt'] + $data['prior_purchase_close_cnt'] + $data['prior_refi_close_cnt']); ?></td>
            </tr>
            <tr class="service-escrow">
                <td>📋 Escrow Orders</td>
                <td class="number"><?php echo $data['today_escrow_close_cnt']; ?></td>
                <td class="number"><?php echo $data['mtd_escrow_close_cnt']; ?></td>
                <td class="number"><?php echo number_format(round($data['mtd_escrow_close_cnt']/$daysPassed)); ?></td>
                <td class="number"><?php echo number_format(round(($data['mtd_escrow_close_cnt']/$daysPassed)*$totalDaysInMonth)); ?></td>
                <td class="number"><?php echo $data['prior_escrow_close_cnt']; ?></td>
            </tr>
            <tr class="service-title-resale">
                <td>📋 Title Only - Resale</td>
                <td class="number"><?php echo $data['today_purchase_close_cnt']; ?></td>
                <td class="number"><?php echo $data['mtd_purchase_close_cnt']; ?></td>
                <td class="number"><?php echo number_format(round($data['mtd_purchase_close_cnt']/$daysPassed)); ?></td>
                <td class="number"><?php echo number_format(round(($data['mtd_purchase_close_cnt']/$daysPassed)*$totalDaysInMonth)); ?></td>
                <td class="number"><?php echo $data['prior_purchase_close_cnt']; ?></td>
            </tr>
            <tr class="service-title-refi">
                <td>📋 Title Only - Refinance</td>
                <td class="number"><?php echo $data['today_refi_close_cnt']; ?></td>
                <td class="number"><?php echo $data['mtd_refi_close_cnt']; ?></td>
                <td class="number"><?php echo number_format(round($data['mtd_refi_close_cnt']/$daysPassed)); ?></td>
                <td class="number"><?php echo number_format(round(($data['mtd_refi_close_cnt']/$daysPassed)*$totalDaysInMonth)); ?></td>
                <td class="number"><?php echo $data['prior_refi_close_cnt']; ?></td>
            </tr>
        </tbody>
    </table>
    
    <div class="metric-header">💰 Revenue Analysis</div>
    <table class="branch-table">
        <thead>
            <tr>
                <th>Service Type</th>
                <th><?php echo $summaryData['todayDate'];?></th>
                <th>Count for Month</th>
                <th>Average Per Day</th>
                <th>Projected For Month</th>
                <th>Prior Month Total</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td><stryong>🏢 <?php echo $branchName; ?> TOTAL REVENUE</strong></td>
                <td class="number">$<?php echo number_format(round(($data['today_escrow_rev'] + $data['today_purchase_rev'] + $data['today_refi_rev']))); ?></td>
                <td class="number">$<?php echo number_format(round(($data['mtd_escrow_rev'] + $data['mtd_purchase_rev'] + $data['mtd_refi_rev']))); ?></td>
                <td class="number">$<?php echo number_format(round(($data['mtd_escrow_rev'] + $data['mtd_purchase_rev'] + $data['mtd_refi_rev'])/$daysPassed)); ?></td>
                <td class="number">$<?php echo number_format(round((($data['mtd_escrow_rev'] + $data['mtd_purchase_rev'] + $data['mtd_refi_rev'])/$daysPassed) * $totalDaysInMonth)); ?></td>
                <td class="number">$<?php echo number_format(round(($data['prior_escrow_rev'] + $data['prior_purchase_rev'] + $data['prior_refi_rev']))); ?></td>
            </tr>
            <tr class="service-escrow">
                <td>📋 Escrow Orders</td>
                <td class="number">$<?php echo number_format(round($data['today_escrow_rev'])); ?></td>
                <td class="number">$<?php echo number_format(round($data['mtd_escrow_rev'])); ?></td>
                <td class="number">$<?php echo number_format(round($data['mtd_escrow_rev']/$daysPassed)); ?></td>
                <td class="number">$<?php echo number_format(round(($data['mtd_escrow_rev']/$daysPassed)*$totalDaysInMonth)); ?></td>
                <td class="number">$<?php echo number_format(round($data['prior_escrow_rev'])); ?></td>
            </tr>
            <tr class="service-title-resale">
                <td>📋 Title Only - Resale</td>
                <td class="number">$<?php echo number_format(round($data['today_purchase_rev'])); ?></td>
                <td class="number">$<?php echo number_format(round($data['mtd_purchase_rev'])); ?></td>
                <td class="number">$<?php echo number_format(round($data['mtd_purchase_rev']/$daysPassed)); ?></td>
                <td class="number">$<?php echo number_format(round(($data['mtd_purchase_rev']/$daysPassed)*$totalDaysInMonth)); ?></td>
                <td class="number">$<?php echo number_format(round($data['prior_purchase_rev'])); ?></td>
            </tr>
            <tr class="service-title-refi">
                <td>📋 Title Only - Refinance</td>
                <td class="number">$<?php echo number_format(round($data['today_refi_rev'])); ?></td>
                <td class="number">$<?php echo number_format(round($data['mtd_refi_rev'])); ?></td>
                <td class="number">$<?php echo number_format(round($data['mtd_refi_rev']/$daysPassed)); ?></td>
                <td class="number">$<?php echo number_format(round(($data['mtd_refi_rev']/$daysPassed)*$totalDaysInMonth)); ?></td>
                <td class="number">$<?php echo number_format(round($data['prior_refi_rev'])); ?></td>
            </tr>
        </tbody>
    </table>
</div>
<?php
}
?>

<!-- <div class="branch-header" onclick="toggleSection('orange')">
    <span>🏢 Orange Branch</span>
    <span class="toggle-icon" id="orange-icon">▼</span>
</div>
<div class="branch-content" id="orange-content">
    
    <div class="metric-header">📈 Openings Analysis</div>
    <table class="branch-table">
        <thead>
            <tr>
                <th>Service Type</th>
                <th>Count for Day</th>
                <th>Count for Month</th>
                <th>Average Per Day</th>
                <th>Projected For Month</th>
                <th>Prior Month Total</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td><strong>🏢 Orange TOTAL OPENINGS</strong></td>
                <td class="number">17.65</td>
                <td class="number">353</td>
                <td class="number">17.65</td>
                <td class="number">706.0</td>
                <td class="number">300.05</td>
            </tr>
            <tr class="service-escrow">
                <td>📋 Escrow Orders</td>
                <td class="number">2.95</td>
                <td class="number">59</td>
                <td class="number">2.95</td>
                <td class="number">118.0</td>
                <td class="number">50.15</td>
            </tr>
            <tr class="service-title-resale">
                <td>📋 Title Only - Resale</td>
                <td class="number">4.9</td>
                <td class="number">98</td>
                <td class="number">4.9</td>
                <td class="number">196.0</td>
                <td class="number">83.3</td>
            </tr>
            <tr class="service-title-refi">
                <td>📋 Title Only - Refinance</td>
                <td class="number">9.8</td>
                <td class="number">196</td>
                <td class="number">9.8</td>
                <td class="number">392.0</td>
                <td class="number">166.6</td>
            </tr>
        </tbody>
    </table>
    
    <div class="metric-header">🎯 Closings Analysis</div>
    <table class="branch-table">
        <thead>
            <tr>
                <th>Service Type</th>
                <th>Count for Day</th>
                <th>Count for Month</th>
                <th>Average Per Day</th>
                <th>Projected For Month</th>
                <th>Prior Month Total</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td><strong>🏢 Orange TOTAL CLOSINGS</strong></td>
                <td class="number">7.45</td>
                <td class="number">149</td>
                <td class="number">7.45</td>
                <td class="number">298.0</td>
                <td class="number">126.65</td>
            </tr>
            <tr class="service-escrow">
                <td>📋 Escrow Orders</td>
                <td class="number">0.3</td>
                <td class="number">6</td>
                <td class="number">0.3</td>
                <td class="number">12.0</td>
                <td class="number">5.1</td>
            </tr>
            <tr class="service-title-resale">
                <td>📋 Title Only - Resale</td>
                <td class="number">2.45</td>
                <td class="number">49</td>
                <td class="number">2.45</td>
                <td class="number">98.0</td>
                <td class="number">41.65</td>
            </tr>
            <tr class="service-title-refi">
                <td>📋 Title Only - Refinance</td>
                <td class="number">4.7</td>
                <td class="number">94</td>
                <td class="number">4.7</td>
                <td class="number">188.0</td>
                <td class="number">79.9</td>
            </tr>
        </tbody>
    </table>
    
    <div class="metric-header">💰 Revenue Analysis</div>
    <table class="branch-table">
        <thead>
            <tr>
                <th>Service Type</th>
                <th>Count for Day</th>
                <th>Count for Month</th>
                <th>Average Per Day</th>
                <th>Projected For Month</th>
                <th>Prior Month Total</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td><strong>🏢 Orange TOTAL REVENUE</strong></td>
                <td class="currency">$4,195.81</td>
                <td class="currency">$83,916.21</td>
                <td class="currency">$4,195.81</td>
                <td class="currency">$167,832.42</td>
                <td class="currency">$71,328.78</td>
            </tr>
            <tr class="service-escrow">
                <td>📋 Escrow Orders</td>
                <td class="currency">$50.84</td>
                <td class="currency">$1,016.72</td>
                <td class="currency">$50.84</td>
                <td class="currency">$2,033.44</td>
                <td class="currency">$864.21</td>
            </tr>
            <tr class="service-title-resale">
                <td>📋 Title Only - Resale</td>
                <td class="currency">$2,474.89</td>
                <td class="currency">$49,497.78</td>
                <td class="currency">$2,474.89</td>
                <td class="currency">$98,995.56</td>
                <td class="currency">$42,073.11</td>
            </tr>
            <tr class="service-title-refi">
                <td>📋 Title Only - Refinance</td>
                <td class="currency">$1,670.09</td>
                <td class="currency">$33,401.71</td>
                <td class="currency">$1,670.09</td>
                <td class="currency">$66,803.42</td>
                <td class="currency">$28,391.45</td>
            </tr>
        </tbody>
    </table>
</div>

<div class="branch-header" onclick="toggleSection('inland-empire')">
    <span>🏢 Inland Empire Branch</span>
    <span class="toggle-icon" id="inland-empire-icon">▼</span>
</div>
<div class="branch-content" id="inland-empire-content">
    
    <div class="metric-header">📈 Openings Analysis</div>
    <table class="branch-table">
        <thead>
            <tr>
                <th>Service Type</th>
                <th>Count for Day</th>
                <th>Count for Month</th>
                <th>Average Per Day</th>
                <th>Projected For Month</th>
                <th>Prior Month Total</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td><strong>🏢 Inland Empire TOTAL OPENINGS</strong></td>
                <td class="number">0.25</td>
                <td class="number">5</td>
                <td class="number">0.25</td>
                <td class="number">10.0</td>
                <td class="number">4.25</td>
            </tr>
            <tr class="service-escrow">
                <td>📋 Escrow Orders</td>
                <td class="number">0.25</td>
                <td class="number">5</td>
                <td class="number">0.25</td>
                <td class="number">10.0</td>
                <td class="number">4.25</td>
            </tr>
            <tr class="service-title-resale">
                <td>📋 Title Only - Resale</td>
                <td class="number">0.0</td>
                <td class="number">0</td>
                <td class="number">0.0</td>
                <td class="number">0.0</td>
                <td class="number">0.0</td>
            </tr>
            <tr class="service-title-refi">
                <td>📋 Title Only - Refinance</td>
                <td class="number">0.0</td>
                <td class="number">0</td>
                <td class="number">0.0</td>
                <td class="number">0.0</td>
                <td class="number">0.0</td>
            </tr>
        </tbody>
    </table>
    
    <div class="metric-header">🎯 Closings Analysis</div>
    <table class="branch-table">
        <thead>
            <tr>
                <th>Service Type</th>
                <th>Count for Day</th>
                <th>Count for Month</th>
                <th>Average Per Day</th>
                <th>Projected For Month</th>
                <th>Prior Month Total</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td><strong>🏢 Inland Empire TOTAL CLOSINGS</strong></td>
                <td class="number">0.3</td>
                <td class="number">6</td>
                <td class="number">0.3</td>
                <td class="number">12.0</td>
                <td class="number">5.1</td>
            </tr>
            <tr class="service-escrow">
                <td>📋 Escrow Orders</td>
                <td class="number">0.3</td>
                <td class="number">6</td>
                <td class="number">0.3</td>
                <td class="number">12.0</td>
                <td class="number">5.1</td>
            </tr>
            <tr class="service-title-resale">
                <td>📋 Title Only - Resale</td>
                <td class="number">0.0</td>
                <td class="number">0</td>
                <td class="number">0.0</td>
                <td class="number">0.0</td>
                <td class="number">0.0</td>
            </tr>
            <tr class="service-title-refi">
                <td>📋 Title Only - Refinance</td>
                <td class="number">0.0</td>
                <td class="number">0</td>
                <td class="number">0.0</td>
                <td class="number">0.0</td>
                <td class="number">0.0</td>
            </tr>
        </tbody>
    </table>
    
    <div class="metric-header">💰 Revenue Analysis</div>
    <table class="branch-table">
        <thead>
            <tr>
                <th>Service Type</th>
                <th>Count for Day</th>
                <th>Count for Month</th>
                <th>Average Per Day</th>
                <th>Projected For Month</th>
                <th>Prior Month Total</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td><strong>🏢 Inland Empire TOTAL REVENUE</strong></td>
                <td class="currency">$197.73</td>
                <td class="currency">$3,954.60</td>
                <td class="currency">$197.73</td>
                <td class="currency">$7,909.20</td>
                <td class="currency">$3,361.41</td>
            </tr>
            <tr class="service-escrow">
                <td>📋 Escrow Orders</td>
                <td class="currency">$197.73</td>
                <td class="currency">$3,954.60</td>
                <td class="currency">$197.73</td>
                <td class="currency">$7,909.20</td>
                <td class="currency">$3,361.41</td>
            </tr>
            <tr class="service-title-resale">
                <td>📋 Title Only - Resale</td>
                <td class="currency">$0.00</td>
                <td class="currency">$0.00</td>
                <td class="currency">$0.00</td>
                <td class="currency">$0.00</td>
                <td class="currency">$0.00</td>
            </tr>
            <tr class="service-title-refi">
                <td>📋 Title Only - Refinance</td>
                <td class="currency">$0.00</td>
                <td class="currency">$0.00</td>
                <td class="currency">$0.00</td>
                <td class="currency">$0.00</td>
                <td class="currency">$0.00</td>
            </tr>
        </tbody>
    </table>
</div>

<div class="branch-header" onclick="toggleSection('porterville')">
    <span>🏢 Porterville Branch</span>
    <span class="toggle-icon" id="porterville-icon">▼</span>
</div>
<div class="branch-content" id="porterville-content">
    
    <div class="metric-header">📈 Openings Analysis</div>
    <table class="branch-table">
        <thead>
            <tr>
                <th>Service Type</th>
                <th>Count for Day</th>
                <th>Count for Month</th>
                <th>Average Per Day</th>
                <th>Projected For Month</th>
                <th>Prior Month Total</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td><strong>🏢 Porterville TOTAL OPENINGS</strong></td>
                <td class="number">0.8</td>
                <td class="number">16</td>
                <td class="number">0.8</td>
                <td class="number">32.0</td>
                <td class="number">13.6</td>
            </tr>
            <tr class="service-escrow">
                <td>📋 Escrow Orders</td>
                <td class="number">0.8</td>
                <td class="number">16</td>
                <td class="number">0.8</td>
                <td class="number">32.0</td>
                <td class="number">13.6</td>
            </tr>
            <tr class="service-title-resale">
                <td>📋 Title Only - Resale</td>
                <td class="number">0.0</td>
                <td class="number">0</td>
                <td class="number">0.0</td>
                <td class="number">0.0</td>
                <td class="number">0.0</td>
            </tr>
            <tr class="service-title-refi">
                <td>📋 Title Only - Refinance</td>
                <td class="number">0.0</td>
                <td class="number">0</td>
                <td class="number">0.0</td>
                <td class="number">0.0</td>
                <td class="number">0.0</td>
            </tr>
        </tbody>
    </table>
    
    <div class="metric-header">🎯 Closings Analysis</div>
    <table class="branch-table">
        <thead>
            <tr>
                <th>Service Type</th>
                <th>Count for Day</th>
                <th>Count for Month</th>
                <th>Average Per Day</th>
                <th>Projected For Month</th>
                <th>Prior Month Total</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td><strong>🏢 Porterville TOTAL CLOSINGS</strong></td>
                <td class="number">0.1</td>
                <td class="number">2</td>
                <td class="number">0.1</td>
                <td class="number">4.0</td>
                <td class="number">1.7</td>
            </tr>
            <tr class="service-escrow">
                <td>📋 Escrow Orders</td>
                <td class="number">0.1</td>
                <td class="number">2</td>
                <td class="number">0.1</td>
                <td class="number">4.0</td>
                <td class="number">1.7</td>
            </tr>
            <tr class="service-title-resale">
                <td>📋 Title Only - Resale</td>
                <td class="number">0.0</td>
                <td class="number">0</td>
                <td class="number">0.0</td>
                <td class="number">0.0</td>
                <td class="number">0.0</td>
            </tr>
            <tr class="service-title-refi">
                <td>📋 Title Only - Refinance</td>
                <td class="number">0.0</td>
                <td class="number">0</td>
                <td class="number">0.0</td>
                <td class="number">0.0</td>
                <td class="number">0.0</td>
            </tr>
        </tbody>
    </table>
    
    <div class="metric-header">💰 Revenue Analysis</div>
    <table class="branch-table">
        <thead>
            <tr>
                <th>Service Type</th>
                <th>Count for Day</th>
                <th>Count for Month</th>
                <th>Average Per Day</th>
                <th>Projected For Month</th>
                <th>Prior Month Total</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td><strong>🏢 Porterville TOTAL REVENUE</strong></td>
                <td class="currency">$33.20</td>
                <td class="currency">$663.90</td>
                <td class="currency">$33.20</td>
                <td class="currency">$1,327.80</td>
                <td class="currency">$564.31</td>
            </tr>
            <tr class="service-escrow">
                <td>📋 Escrow Orders</td>
                <td class="currency">$33.20</td>
                <td class="currency">$663.90</td>
                <td class="currency">$33.20</td>
                <td class="currency">$1,327.80</td>
                <td class="currency">$564.31</td>
            </tr>
            <tr class="service-title-resale">
                <td>📋 Title Only - Resale</td>
                <td class="currency">$0.00</td>
                <td class="currency">$0.00</td>
                <td class="currency">$0.00</td>
                <td class="currency">$0.00</td>
                <td class="currency">$0.00</td>
            </tr>
            <tr class="service-title-refi">
                <td>📋 Title Only - Refinance</td>
                <td class="currency">$0.00</td>
                <td class="currency">$0.00</td>
                <td class="currency">$0.00</td>
                <td class="currency">$0.00</td>
                <td class="currency">$0.00</td>
            </tr>
        </tbody>
    </table>
</div>

<div class="branch-header" onclick="toggleSection('tsg')">
    <span>🏢 TSG Branch</span>
    <span class="toggle-icon" id="tsg-icon">▼</span>
</div>
<div class="branch-content" id="tsg-content">
    
    <div class="metric-header">📈 Openings Analysis</div>
    <table class="branch-table">
        <thead>
            <tr>
                <th>Service Type</th>
                <th>Count for Day</th>
                <th>Count for Month</th>
                <th>Average Per Day</th>
                <th>Projected For Month</th>
                <th>Prior Month Total</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td><strong>🏢 TSG TOTAL OPENINGS</strong></td>
                <td class="number">1.55</td>
                <td class="number">31</td>
                <td class="number">1.55</td>
                <td class="number">62.0</td>
                <td class="number">26.35</td>
            </tr>
            <tr class="service-escrow">
                <td>📋 Escrow Orders</td>
                <td class="number">0.0</td>
                <td class="number">0</td>
                <td class="number">0.0</td>
                <td class="number">0.0</td>
                <td class="number">0.0</td>
            </tr>
            <tr class="service-title-resale">
                <td>📋 Title Only - Resale</td>
                <td class="number">1.55</td>
                <td class="number">31</td>
                <td class="number">1.55</td>
                <td class="number">62.0</td>
                <td class="number">26.35</td>
            </tr>
            <tr class="service-title-refi">
                <td>📋 Title Only - Refinance</td>
                <td class="number">0.0</td>
                <td class="number">0</td>
                <td class="number">0.0</td>
                <td class="number">0.0</td>
                <td class="number">0.0</td>
            </tr>
        </tbody>
    </table>
    
    <div class="metric-header">🎯 Closings Analysis</div>
    <table class="branch-table">
        <thead>
            <tr>
                <th>Service Type</th>
                <th>Count for Day</th>
                <th>Count for Month</th>
                <th>Average Per Day</th>
                <th>Projected For Month</th>
                <th>Prior Month Total</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td><strong>🏢 TSG TOTAL CLOSINGS</strong></td>
                <td class="number">1.4</td>
                <td class="number">28</td>
                <td class="number">1.4</td>
                <td class="number">56.0</td>
                <td class="number">23.8</td>
            </tr>
            <tr class="service-escrow">
                <td>📋 Escrow Orders</td>
                <td class="number">0.0</td>
                <td class="number">0</td>
                <td class="number">0.0</td>
                <td class="number">0.0</td>
                <td class="number">0.0</td>
            </tr>
            <tr class="service-title-resale">
                <td>📋 Title Only - Resale</td>
                <td class="number">1.4</td>
                <td class="number">28</td>
                <td class="number">1.4</td>
                <td class="number">56.0</td>
                <td class="number">23.8</td>
            </tr>
            <tr class="service-title-refi">
                <td>📋 Title Only - Refinance</td>
                <td class="number">0.0</td>
                <td class="number">0</td>
                <td class="number">0.0</td>
                <td class="number">0.0</td>
                <td class="number">0.0</td>
            </tr>
        </tbody>
    </table>
    
    <div class="metric-header">💰 Revenue Analysis</div>
    <table class="branch-table">
        <thead>
            <tr>
                <th>Service Type</th>
                <th>Count for Day</th>
                <th>Count for Month</th>
                <th>Average Per Day</th>
                <th>Projected For Month</th>
                <th>Prior Month Total</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td><strong>🏢 TSG TOTAL REVENUE</strong></td>
                <td class="currency">$0.00</td>
                <td class="currency">$0.00</td>
                <td class="currency">$0.00</td>
                <td class="currency">$0.00</td>
                <td class="currency">$0.00</td>
            </tr>
            <tr class="service-escrow">
                <td>📋 Escrow Orders</td>
                <td class="currency">$0.00</td>
                <td class="currency">$0.00</td>
                <td class="currency">$0.00</td>
                <td class="currency">$0.00</td>
                <td class="currency">$0.00</td>
            </tr>
            <tr class="service-title-resale">
                <td>📋 Title Only - Resale</td>
                <td class="currency">$0.00</td>
                <td class="currency">$0.00</td>
                <td class="currency">$0.00</td>
                <td class="currency">$0.00</td>
                <td class="currency">$0.00</td>
            </tr>
            <tr class="service-title-refi">
                <td>📋 Title Only - Refinance</td>
                <td class="currency">$0.00</td>
                <td class="currency">$0.00</td>
                <td class="currency">$0.00</td>
                <td class="currency">$0.00</td>
                <td class="currency">$0.00</td>
            </tr>
        </tbody>
    </table>
</div>

<div class="branch-header" onclick="toggleSection('production')">
    <span>🏢 Production Branch</span>
    <span class="toggle-icon" id="production-icon">▼</span>
</div>
<div class="branch-content" id="production-content">
    
    <div class="metric-header">📈 Openings Analysis</div>
    <table class="branch-table">
        <thead>
            <tr>
                <th>Service Type</th>
                <th>Count for Day</th>
                <th>Count for Month</th>
                <th>Average Per Day</th>
                <th>Projected For Month</th>
                <th>Prior Month Total</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td><strong>🏢 Production TOTAL OPENINGS</strong></td>
                <td class="number">0.9</td>
                <td class="number">18</td>
                <td class="number">0.9</td>
                <td class="number">36.0</td>
                <td class="number">15.3</td>
            </tr>
            <tr class="service-escrow">
                <td>📋 Escrow Orders</td>
                <td class="number">0.0</td>
                <td class="number">0</td>
                <td class="number">0.0</td>
                <td class="number">0.0</td>
                <td class="number">0.0</td>
            </tr>
            <tr class="service-title-resale">
                <td>📋 Title Only - Resale</td>
                <td class="number">0.9</td>
                <td class="number">18</td>
                <td class="number">0.9</td>
                <td class="number">36.0</td>
                <td class="number">15.3</td>
            </tr>
            <tr class="service-title-refi">
                <td>📋 Title Only - Refinance</td>
                <td class="number">0.0</td>
                <td class="number">0</td>
                <td class="number">0.0</td>
                <td class="number">0.0</td>
                <td class="number">0.0</td>
            </tr>
        </tbody>
    </table>
    
    <div class="metric-header">🎯 Closings Analysis</div>
    <table class="branch-table">
        <thead>
            <tr>
                <th>Service Type</th>
                <th>Count for Day</th>
                <th>Count for Month</th>
                <th>Average Per Day</th>
                <th>Projected For Month</th>
                <th>Prior Month Total</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td><strong>🏢 Production TOTAL CLOSINGS</strong></td>
                <td class="number">0.05</td>
                <td class="number">1</td>
                <td class="number">0.05</td>
                <td class="number">2.0</td>
                <td class="number">0.85</td>
            </tr>
            <tr class="service-escrow">
                <td>📋 Escrow Orders</td>
                <td class="number">0.0</td>
                <td class="number">0</td>
                <td class="number">0.0</td>
                <td class="number">0.0</td>
                <td class="number">0.0</td>
            </tr>
            <tr class="service-title-resale">
                <td>📋 Title Only - Resale</td>
                <td class="number">0.05</td>
                <td class="number">1</td>
                <td class="number">0.05</td>
                <td class="number">2.0</td>
                <td class="number">0.85</td>
            </tr>
            <tr class="service-title-refi">
                <td>📋 Title Only - Refinance</td>
                <td class="number">0.0</td>
                <td class="number">0</td>
                <td class="number">0.0</td>
                <td class="number">0.0</td>
                <td class="number">0.0</td>
            </tr>
        </tbody>
    </table>
    
    <div class="metric-header">💰 Revenue Analysis</div>
    <table class="branch-table">
        <thead>
            <tr>
                <th>Service Type</th>
                <th>Count for Day</th>
                <th>Count for Month</th>
                <th>Average Per Day</th>
                <th>Projected For Month</th>
                <th>Prior Month Total</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td><strong>🏢 Production TOTAL REVENUE</strong></td>
                <td class="currency">$42.12</td>
                <td class="currency">$842.40</td>
                <td class="currency">$42.12</td>
                <td class="currency">$1,684.80</td>
                <td class="currency">$716.04</td>
            </tr>
            <tr class="service-escrow">
                <td>📋 Escrow Orders</td>
                <td class="currency">$0.00</td>
                <td class="currency">$0.00</td>
                <td class="currency">$0.00</td>
                <td class="currency">$0.00</td>
                <td class="currency">$0.00</td>
            </tr>
            <tr class="service-title-resale">
                <td>📋 Title Only - Resale</td>
                <td class="currency">$42.12</td>
                <td class="currency">$842.40</td>
                <td class="currency">$42.12</td>
                <td class="currency">$1,684.80</td>
                <td class="currency">$716.04</td>
            </tr>
            <tr class="service-title-refi">
                <td>📋 Title Only - Refinance</td>
                <td class="currency">$0.00</td>
                <td class="currency">$0.00</td>
                <td class="currency">$0.00</td>
                <td class="currency">$0.00</td>
                <td class="currency">$0.00</td>
            </tr>
        </tbody>
    </table>
</div> -->