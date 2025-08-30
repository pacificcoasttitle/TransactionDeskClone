
 <?php 
    foreach($branches as $branchName => $branch) {
        // echo "<pre>";
        // print_r($branchName);
        // print_r($branch);die;
    // }
?>
<div class="branch-section">
    <button class="branch-toggle" onclick="toggleBranch('<?php echo $branchName; ?>')">
        <span>🏢 <?php echo $branchName; ?> Branch (2 Title Officers)</span>
        <span class="toggle-icon" id="<?php echo $branchName; ?>-icon">▼</span>
    </button>
    <div class="branch-content" id="<?php echo $branchName; ?>">

        <table class="title-table">
            <thead>
                <tr>
                    <th rowspan="3">Title Officer</th>
                    <th rowspan="3">Quality<br>Rating</th>
                    <th colspan="9">Policies Issued by Type</th>
                    <th colspan="9">Revenue by Policy Type</th>
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
                    <td class="percentage low-performance"><?php echo $titleOfficerDetails['closing_ratio'] ?>%</td>
                    
                    <td class="number"><?php echo $titleOfficerDetails['today_purchase_cnt'] ?></td>
                    <td class="number"><?php echo $titleOfficerDetails['mtd_purchase_cnt'] ?></td>
                    <td class="number"><?php echo $titleOfficerDetails['prior_purchase_cnt'] ?></td>
                    
                    <td class="number"><?php echo $titleOfficerDetails['today_refi_cnt'] ?></td>
                    <td class="number"><?php echo $titleOfficerDetails['mtd_refi_cnt'] ?></td>
                    <td class="number"><?php echo $titleOfficerDetails['prior_refi_cnt'] ?></td>
                    
                    <td class="number"><?php echo 0; ?></td>
                    <td class="number"><?php echo 0; ?></td>
                    <td class="number"><?php echo 0; ?></td>
                    
                    <td class="currency">$<?php echo $titleOfficerDetails['today_purchase_rev']; ?></td>
                    <td class="currency">$<?php echo $titleOfficerDetails['mtd_purchase_rev']; ?></td>
                    <td class="currency">$<?php echo $titleOfficerDetails['prior_purchase_rev']; ?></td>
                    
                    <td class="currency">$<?php echo $titleOfficerDetails['today_refi_rev']; ?></td>
                    <td class="currency">$<?php echo $titleOfficerDetails['mtd_refi_rev']; ?></td>
                    <td class="currency">$<?php echo $titleOfficerDetails['prior_refi_rev']; ?></td>
                    
                    <td class="currency">$<?php echo 0; ?></td>
                    <td class="currency">$<?php echo 0; ?></td>
                    <td class="currency">$<?php echo 0; ?></td>
                </tr>
                <?php }?>
                <!-- <tr>
                    <td class="title-officer-name">Rachel Barcena</td>
                    <td class="percentage low-performance">89.7%</td>
                    
                    <td class="number">2</td>
                    <td class="number">47</td>
                    <td class="number">39</td>
                    
                    <td class="number">1</td>
                    <td class="number">36</td>
                    <td class="number">30</td>
                    
                    <td class="number">0</td>
                    <td class="number">0</td>
                    <td class="number">0</td>
                    
                    <td class="currency">$2,715</td>
                    <td class="currency">$54,304</td>
                    <td class="currency">$46,158</td>
                    
                    <td class="currency">$1,204</td>
                    <td class="currency">$24,080</td>
                    <td class="currency">$20,468</td>
                    
                    <td class="currency">$0</td>
                    <td class="currency">$0</td>
                    <td class="currency">$0</td>
                </tr>
                <tr class="branch-totals">
                    <td class="title-officer-name">🏢 Glendale TOTALS</td>
                    <td class="percentage">89.6%</td>
                    
                    <td class="number">6</td>
                    <td class="number">120</td>
                    <td class="number">102</td>
                    
                    <td class="number">3</td>
                    <td class="number">63</td>
                    <td class="number">53</td>
                    
                    <td class="number">0</td>
                    <td class="number">0</td>
                    <td class="number">0</td>
                    
                    <td class="currency">$6,452</td>
                    <td class="currency">$129,049</td>
                    <td class="currency">$109,692</td>
                    
                    <td class="currency">$1,899</td>
                    <td class="currency">$37,974</td>
                    <td class="currency">$32,278</td>
                    
                    <td class="currency">$0</td>
                    <td class="currency">$0</td>
                    <td class="currency">$0</td>
                </tr> -->
            </tbody>
        </table>
    </div>
</div>
<?php }?>
<!-- <div class="branch-section">
    <button class="branch-toggle" onclick="toggleBranch('orange')">
        <span>🏢 Orange Branch (2 Title Officers)</span>
        <span class="toggle-icon" id="orange-icon">▼</span>
    </button>
    <div class="branch-content" id="orange">

        <table class="title-table">
            <thead>
                <tr>
                    <th rowspan="3">Title Officer</th>
                    <th rowspan="3">Quality<br>Rating</th>
                    <th colspan="9">Policies Issued by Type</th>
                    <th colspan="9">Revenue by Policy Type</th>
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
                <tr>
                    <td class="title-officer-name">Clive Virata</td>
                    <td class="percentage low-performance">87.0%</td>
                    
                    <td class="number">0</td>
                    <td class="number">19</td>
                    <td class="number">16</td>
                    
                    <td class="number">3</td>
                    <td class="number">75</td>
                    <td class="number">63</td>
                    
                    <td class="number">0</td>
                    <td class="number">0</td>
                    <td class="number">0</td>
                    
                    <td class="currency">$778</td>
                    <td class="currency">$15,551</td>
                    <td class="currency">$13,219</td>
                    
                    <td class="currency">$1,121</td>
                    <td class="currency">$22,429</td>
                    <td class="currency">$19,065</td>
                    
                    <td class="currency">$0</td>
                    <td class="currency">$0</td>
                    <td class="currency">$0</td>
                </tr>
                <tr>
                    <td class="title-officer-name">Jim Jean</td>
                    <td class="percentage low-performance">89.2%</td>
                    
                    <td class="number">1</td>
                    <td class="number">30</td>
                    <td class="number">25</td>
                    
                    <td class="number">1</td>
                    <td class="number">25</td>
                    <td class="number">21</td>
                    
                    <td class="number">0</td>
                    <td class="number">0</td>
                    <td class="number">0</td>
                    
                    <td class="currency">$1,697</td>
                    <td class="currency">$33,947</td>
                    <td class="currency">$28,855</td>
                    
                    <td class="currency">$599</td>
                    <td class="currency">$11,989</td>
                    <td class="currency">$10,191</td>
                    
                    <td class="currency">$0</td>
                    <td class="currency">$0</td>
                    <td class="currency">$0</td>
                </tr>
                <tr class="branch-totals">
                    <td class="title-officer-name">🏢 Orange TOTALS</td>
                    <td class="percentage">88.1%</td>
                    
                    <td class="number">2</td>
                    <td class="number">49</td>
                    <td class="number">41</td>
                    
                    <td class="number">5</td>
                    <td class="number">100</td>
                    <td class="number">85</td>
                    
                    <td class="number">0</td>
                    <td class="number">0</td>
                    <td class="number">0</td>
                    
                    <td class="currency">$2,475</td>
                    <td class="currency">$49,498</td>
                    <td class="currency">$42,073</td>
                    
                    <td class="currency">$1,721</td>
                    <td class="currency">$34,418</td>
                    <td class="currency">$29,256</td>
                    
                    <td class="currency">$0</td>
                    <td class="currency">$0</td>
                    <td class="currency">$0</td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
<div class="branch-section">
    <button class="branch-toggle" onclick="toggleBranch('tsg')">
        <span>🏢 TSG Branch (1 Title Officers)</span>
        <span class="toggle-icon" id="tsg-icon">▼</span>
    </button>
    <div class="branch-content" id="tsg">

        <table class="title-table">
            <thead>
                <tr>
                    <th rowspan="3">Title Officer</th>
                    <th rowspan="3">Quality<br>Rating</th>
                    <th colspan="9">Policies Issued by Type</th>
                    <th colspan="9">Revenue by Policy Type</th>
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
                <tr>
                    <td class="title-officer-name">Susan Dana</td>
                    <td class="percentage low-performance">85.0%</td>
                    
                    <td class="number">0</td>
                    <td class="number">0</td>
                    <td class="number">0</td>
                    
                    <td class="number">0</td>
                    <td class="number">0</td>
                    <td class="number">0</td>
                    
                    <td class="number">1</td>
                    <td class="number">28</td>
                    <td class="number">23</td>
                    
                    <td class="currency">$0</td>
                    <td class="currency">$0</td>
                    <td class="currency">$0</td>
                    
                    <td class="currency">$0</td>
                    <td class="currency">$0</td>
                    <td class="currency">$0</td>
                    
                    <td class="currency">$0</td>
                    <td class="currency">$0</td>
                    <td class="currency">$0</td>
                </tr>
                <tr class="branch-totals">
                    <td class="title-officer-name">🏢 TSG TOTALS</td>
                    <td class="percentage">85.0%</td>
                    
                    <td class="number">0</td>
                    <td class="number">0</td>
                    <td class="number">0</td>
                    
                    <td class="number">0</td>
                    <td class="number">0</td>
                    <td class="number">0</td>
                    
                    <td class="number">1</td>
                    <td class="number">28</td>
                    <td class="number">23</td>
                    
                    <td class="currency">$0</td>
                    <td class="currency">$0</td>
                    <td class="currency">$0</td>
                    
                    <td class="currency">$0</td>
                    <td class="currency">$0</td>
                    <td class="currency">$0</td>
                    
                    <td class="currency">$0</td>
                    <td class="currency">$0</td>
                    <td class="currency">$0</td>
                </tr>
            </tbody>
        </table>
    </div>
</div> -->

<!-- <div class="report-footer">
    <p>Report generated on August 21, 2025 at 03:21 PM | Pacific Coast Title Company</p>
    <p>Title Officer Performance Analysis - Mapping File ONLY (No Cross-Branch)</p>
</div> -->