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
                    <th colspan="9">Closings by Production (August)</th>
                    <th colspan="9">Revenue by Production (August)</th>
                </tr>
                <tr>
                    <th colspan="3">Title Only - Resale</th>
                    <th colspan="3">Title Only - Refinance</th>
                    <th colspan="3">Escrow Orders</th>
                    <th colspan="3">Title Only - Resale</th>
                    <th colspan="3">Title Only - Refinance</th>
                    <th colspan="3">Escrow Orders</th>
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
                <?php foreach($branch['sales_reps'] as $salesId => $salesDetails) {
                    // echo "<pre>";
                    // print_r($branch);die;
                    ?>
                <tr>
                    <td class="salesrep-name"><?php echo $salesDetails['sales_rep'] ?></td>
                    <td class="percentage high-performance"><?php echo $salesDetails['closing_ratio'] ?>%</td>
                    
                    <td class="number"><?php echo $salesDetails['today_purchase_cnt'] ?></td>
                    <td class="number"><?php echo $salesDetails['mtd_purchase_cnt'] ?></td>
                    <td class="number"><?php echo $salesDetails['prior_purchase_cnt'] ?></td>
                    
                    <td class="number"><?php echo $salesDetails['today_refi_cnt'] ?></td>
                    <td class="number"><?php echo $salesDetails['mtd_refi_cnt'] ?></td>
                    <td class="number"><?php echo $salesDetails['prior_refi_cnt'] ?></td>
                    
                    <td class="number"><?php echo 0; ?></td>
                    <td class="number"><?php echo 0; ?></td>
                    <td class="number"><?php echo 0; ?></td>
                    
                    <td class="currency">$<?php echo $salesDetails['today_purchase_rev'] ?></td>
                    <td class="currency">$<?php echo $salesDetails['mtd_purchase_rev'] ?></td>
                    <td class="currency">$<?php echo $salesDetails['prior_purchase_rev'] ?></td>
                    
                    <td class="currency">$<?php echo $salesDetails['today_refi_rev'] ?></td>
                    <td class="currency">$<?php echo $salesDetails['mtd_refi_rev'] ?></td>
                    <td class="currency">$<?php echo $salesDetails['prior_refi_rev'] ?></td>
                    
                    <td class="currency">$<?php echo 0 ?></td>
                    <td class="currency">$<?php echo 0 ?></td>
                    <td class="currency">$<?php echo 0 ?></td>
                </tr>
                <?php }?>
                <!-- <tr>
                    <td class="salesrep-name">Angeline Wu</td>
                    <td class="percentage low-performance">54.7%</td>
                    
                    <td class="number">0</td>
                    <td class="number">12</td>
                    <td class="number">10</td>
                    
                    <td class="number">1</td>
                    <td class="number">33</td>
                    <td class="number">28</td>
                    
                    <td class="number">0</td>
                    <td class="number">2</td>
                    <td class="number">1</td>
                    
                    <td class="currency">$565</td>
                    <td class="currency">$11,292</td>
                    <td class="currency">$9,598</td>
                    
                    <td class="currency">$864</td>
                    <td class="currency">$17,280</td>
                    <td class="currency">$14,688</td>
                    
                    <td class="currency">$23</td>
                    <td class="currency">$466</td>
                    <td class="currency">$396</td>
                </tr>
                <tr>
                    <td class="salesrep-name">Christy Coffey</td>
                    <td class="percentage low-performance">57.5%</td>
                    
                    <td class="number">0</td>
                    <td class="number">2</td>
                    <td class="number">1</td>
                    
                    <td class="number">0</td>
                    <td class="number">1</td>
                    <td class="number">0</td>
                    
                    <td class="number">0</td>
                    <td class="number">0</td>
                    <td class="number">0</td>
                    
                    <td class="currency">$225</td>
                    <td class="currency">$4,503</td>
                    <td class="currency">$3,827</td>
                    
                    <td class="currency">$20</td>
                    <td class="currency">$405</td>
                    <td class="currency">$344</td>
                    
                    <td class="currency">$0</td>
                    <td class="currency">$0</td>
                    <td class="currency">$0</td>
                </tr>
                <tr>
                    <td class="salesrep-name">David Gomez</td>
                    <td class="percentage low-performance">14.3%</td>
                    
                    <td class="number">0</td>
                    <td class="number">0</td>
                    <td class="number">0</td>
                    
                    <td class="number">0</td>
                    <td class="number">0</td>
                    <td class="number">0</td>
                    
                    <td class="number">0</td>
                    <td class="number">0</td>
                    <td class="number">0</td>
                    
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
                <tr>
                    <td class="salesrep-name">Jane Phan</td>
                    <td class="percentage low-performance">28.3%</td>
                    
                    <td class="number">0</td>
                    <td class="number">0</td>
                    <td class="number">0</td>
                    
                    <td class="number">0</td>
                    <td class="number">2</td>
                    <td class="number">1</td>
                    
                    <td class="number">0</td>
                    <td class="number">0</td>
                    <td class="number">0</td>
                    
                    <td class="currency">$0</td>
                    <td class="currency">$0</td>
                    <td class="currency">$0</td>
                    
                    <td class="currency">$13</td>
                    <td class="currency">$259</td>
                    <td class="currency">$220</td>
                    
                    <td class="currency">$0</td>
                    <td class="currency">$0</td>
                    <td class="currency">$0</td>
                </tr>
                <tr>
                    <td class="salesrep-name">Laurie Briggs</td>
                    <td class="percentage low-performance">34.8%</td>
                    
                    <td class="number">0</td>
                    <td class="number">2</td>
                    <td class="number">1</td>
                    
                    <td class="number">0</td>
                    <td class="number">0</td>
                    <td class="number">0</td>
                    
                    <td class="number">0</td>
                    <td class="number">0</td>
                    <td class="number">0</td>
                    
                    <td class="currency">$80</td>
                    <td class="currency">$1,592</td>
                    <td class="currency">$1,353</td>
                    
                    <td class="currency">$0</td>
                    <td class="currency">$0</td>
                    <td class="currency">$0</td>
                    
                    <td class="currency">$0</td>
                    <td class="currency">$0</td>
                    <td class="currency">$0</td>
                </tr>
                <tr>
                    <td class="salesrep-name">Linda Ruiz</td>
                    <td class="percentage low-performance">37.8%</td>
                    
                    <td class="number">0</td>
                    <td class="number">2</td>
                    <td class="number">1</td>
                    
                    <td class="number">0</td>
                    <td class="number">7</td>
                    <td class="number">5</td>
                    
                    <td class="number">0</td>
                    <td class="number">0</td>
                    <td class="number">0</td>
                    
                    <td class="currency">$9</td>
                    <td class="currency">$179</td>
                    <td class="currency">$152</td>
                    
                    <td class="currency">$219</td>
                    <td class="currency">$4,386</td>
                    <td class="currency">$3,728</td>
                    
                    <td class="currency">$0</td>
                    <td class="currency">$0</td>
                    <td class="currency">$0</td>
                </tr>
                <tr>
                    <td class="salesrep-name">Lopez Team</td>
                    <td class="percentage medium-performance">60.0%</td>
                    
                    <td class="number">0</td>
                    <td class="number">2</td>
                    <td class="number">1</td>
                    
                    <td class="number">0</td>
                    <td class="number">0</td>
                    <td class="number">0</td>
                    
                    <td class="number">0</td>
                    <td class="number">0</td>
                    <td class="number">0</td>
                    
                    <td class="currency">$78</td>
                    <td class="currency">$1,567</td>
                    <td class="currency">$1,332</td>
                    
                    <td class="currency">$0</td>
                    <td class="currency">$0</td>
                    <td class="currency">$0</td>
                    
                    <td class="currency">$0</td>
                    <td class="currency">$0</td>
                    <td class="currency">$0</td>
                </tr>
                <tr>
                    <td class="salesrep-name">Michael Johnson</td>
                    <td class="percentage medium-performance">68.2%</td>
                    
                    <td class="number">0</td>
                    <td class="number">2</td>
                    <td class="number">1</td>
                    
                    <td class="number">0</td>
                    <td class="number">10</td>
                    <td class="number">8</td>
                    
                    <td class="number">0</td>
                    <td class="number">0</td>
                    <td class="number">0</td>
                    
                    <td class="currency">$134</td>
                    <td class="currency">$2,681</td>
                    <td class="currency">$2,279</td>
                    
                    <td class="currency">$272</td>
                    <td class="currency">$5,445</td>
                    <td class="currency">$4,628</td>
                    
                    <td class="currency">$0</td>
                    <td class="currency">$0</td>
                    <td class="currency">$0</td>
                </tr>
                <tr>
                    <td class="salesrep-name">Neil Torquato</td>
                    <td class="percentage low-performance">53.3%</td>
                    
                    <td class="number">0</td>
                    <td class="number">2</td>
                    <td class="number">1</td>
                    
                    <td class="number">0</td>
                    <td class="number">0</td>
                    <td class="number">0</td>
                    
                    <td class="number">0</td>
                    <td class="number">0</td>
                    <td class="number">0</td>
                    
                    <td class="currency">$76</td>
                    <td class="currency">$1,530</td>
                    <td class="currency">$1,300</td>
                    
                    <td class="currency">$0</td>
                    <td class="currency">$0</td>
                    <td class="currency">$0</td>
                    
                    <td class="currency">$0</td>
                    <td class="currency">$0</td>
                    <td class="currency">$0</td>
                </tr>
                <tr>
                    <td class="salesrep-name">Nicholas Watt</td>
                    <td class="percentage low-performance">32.3%</td>
                    
                    <td class="number">0</td>
                    <td class="number">4</td>
                    <td class="number">3</td>
                    
                    <td class="number">0</td>
                    <td class="number">1</td>
                    <td class="number">0</td>
                    
                    <td class="number">0</td>
                    <td class="number">0</td>
                    <td class="number">0</td>
                    
                    <td class="currency">$478</td>
                    <td class="currency">$9,569</td>
                    <td class="currency">$8,133</td>
                    
                    <td class="currency">$20</td>
                    <td class="currency">$405</td>
                    <td class="currency">$344</td>
                    
                    <td class="currency">$0</td>
                    <td class="currency">$0</td>
                    <td class="currency">$0</td>
                </tr>
                <tr>
                    <td class="salesrep-name">Nini Kerns</td>
                    <td class="percentage low-performance">46.2%</td>
                    
                    <td class="number">0</td>
                    <td class="number">1</td>
                    <td class="number">0</td>
                    
                    <td class="number">0</td>
                    <td class="number">1</td>
                    <td class="number">0</td>
                    
                    <td class="number">0</td>
                    <td class="number">0</td>
                    <td class="number">0</td>
                    
                    <td class="currency">$94</td>
                    <td class="currency">$1,872</td>
                    <td class="currency">$1,591</td>
                    
                    <td class="currency">$26</td>
                    <td class="currency">$518</td>
                    <td class="currency">$440</td>
                    
                    <td class="currency">$0</td>
                    <td class="currency">$0</td>
                    <td class="currency">$0</td>
                </tr>
                <tr>
                    <td class="salesrep-name">Orange Account</td>
                    <td class="percentage low-performance">0.0%</td>
                    
                    <td class="number">0</td>
                    <td class="number">0</td>
                    <td class="number">0</td>
                    
                    <td class="number">0</td>
                    <td class="number">0</td>
                    <td class="number">0</td>
                    
                    <td class="number">0</td>
                    <td class="number">0</td>
                    <td class="number">0</td>
                    
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
                <tr>
                    <td class="salesrep-name">Orange County House Account</td>
                    <td class="percentage low-performance">18.1%</td>
                    
                    <td class="number">0</td>
                    <td class="number">3</td>
                    <td class="number">2</td>
                    
                    <td class="number">0</td>
                    <td class="number">0</td>
                    <td class="number">0</td>
                    
                    <td class="number">0</td>
                    <td class="number">0</td>
                    <td class="number">0</td>
                    
                    <td class="currency">$51</td>
                    <td class="currency">$1,014</td>
                    <td class="currency">$862</td>
                    
                    <td class="currency">$0</td>
                    <td class="currency">$0</td>
                    <td class="currency">$0</td>
                    
                    <td class="currency">$0</td>
                    <td class="currency">$0</td>
                    <td class="currency">$0</td>
                </tr>
                <tr>
                    <td class="salesrep-name">Richard Bohn</td>
                    <td class="percentage low-performance">39.1%</td>
                    
                    <td class="number">0</td>
                    <td class="number">2</td>
                    <td class="number">1</td>
                    
                    <td class="number">0</td>
                    <td class="number">0</td>
                    <td class="number">0</td>
                    
                    <td class="number">0</td>
                    <td class="number">0</td>
                    <td class="number">0</td>
                    
                    <td class="currency">$65</td>
                    <td class="currency">$1,299</td>
                    <td class="currency">$1,104</td>
                    
                    <td class="currency">$0</td>
                    <td class="currency">$0</td>
                    <td class="currency">$0</td>
                    
                    <td class="currency">$0</td>
                    <td class="currency">$0</td>
                    <td class="currency">$0</td>
                </tr>
                <tr>
                    <td class="salesrep-name">Saeed Ghaffari</td>
                    <td class="percentage low-performance">33.3%</td>
                    
                    <td class="number">0</td>
                    <td class="number">0</td>
                    <td class="number">0</td>
                    
                    <td class="number">0</td>
                    <td class="number">0</td>
                    <td class="number">0</td>
                    
                    <td class="number">0</td>
                    <td class="number">0</td>
                    <td class="number">0</td>
                    
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
                <tr>
                    <td class="salesrep-name">Sandra Millar</td>
                    <td class="percentage low-performance">45.7%</td>
                    
                    <td class="number">0</td>
                    <td class="number">0</td>
                    <td class="number">0</td>
                    
                    <td class="number">1</td>
                    <td class="number">27</td>
                    <td class="number">22</td>
                    
                    <td class="number">0</td>
                    <td class="number">4</td>
                    <td class="number">3</td>
                    
                    <td class="currency">$0</td>
                    <td class="currency">$0</td>
                    <td class="currency">$0</td>
                    
                    <td class="currency">$64</td>
                    <td class="currency">$1,274</td>
                    <td class="currency">$1,083</td>
                    
                    <td class="currency">$28</td>
                    <td class="currency">$551</td>
                    <td class="currency">$468</td>
                </tr>
                <tr>
                    <td class="salesrep-name">Sonia Flores</td>
                    <td class="percentage low-performance">49.5%</td>
                    
                    <td class="number">0</td>
                    <td class="number">8</td>
                    <td class="number">6</td>
                    
                    <td class="number">0</td>
                    <td class="number">8</td>
                    <td class="number">6</td>
                    
                    <td class="number">0</td>
                    <td class="number">0</td>
                    <td class="number">0</td>
                    
                    <td class="currency">$385</td>
                    <td class="currency">$7,704</td>
                    <td class="currency">$6,549</td>
                    
                    <td class="currency">$128</td>
                    <td class="currency">$2,564</td>
                    <td class="currency">$2,179</td>
                    
                    <td class="currency">$0</td>
                    <td class="currency">$0</td>
                    <td class="currency">$0</td>
                </tr>
                <tr>
                    <td class="salesrep-name">Team Meza</td>
                    <td class="percentage low-performance">51.6%</td>
                    
                    <td class="number">0</td>
                    <td class="number">1</td>
                    <td class="number">0</td>
                    
                    <td class="number">0</td>
                    <td class="number">0</td>
                    <td class="number">0</td>
                    
                    <td class="number">0</td>
                    <td class="number">0</td>
                    <td class="number">0</td>
                    
                    <td class="currency">$52</td>
                    <td class="currency">$1,033</td>
                    <td class="currency">$878</td>
                    
                    <td class="currency">$0</td>
                    <td class="currency">$0</td>
                    <td class="currency">$0</td>
                    
                    <td class="currency">$0</td>
                    <td class="currency">$0</td>
                    <td class="currency">$0</td>
                </tr>
                <tr>
                    <td class="salesrep-name">Title Team</td>
                    <td class="percentage low-performance">59.1%</td>
                    
                    <td class="number">0</td>
                    <td class="number">2</td>
                    <td class="number">1</td>
                    
                    <td class="number">0</td>
                    <td class="number">0</td>
                    <td class="number">0</td>
                    
                    <td class="number">0</td>
                    <td class="number">0</td>
                    <td class="number">0</td>
                    
                    <td class="currency">$42</td>
                    <td class="currency">$841</td>
                    <td class="currency">$715</td>
                    
                    <td class="currency">$0</td>
                    <td class="currency">$0</td>
                    <td class="currency">$0</td>
                    
                    <td class="currency">$0</td>
                    <td class="currency">$0</td>
                    <td class="currency">$0</td>
                </tr>
                <tr>
                    <td class="salesrep-name">Ventura House Account</td>
                    <td class="percentage low-performance">42.9%</td>
                    
                    <td class="number">0</td>
                    <td class="number">4</td>
                    <td class="number">3</td>
                    
                    <td class="number">0</td>
                    <td class="number">2</td>
                    <td class="number">1</td>
                    
                    <td class="number">0</td>
                    <td class="number">0</td>
                    <td class="number">0</td>
                    
                    <td class="currency">$141</td>
                    <td class="currency">$2,822</td>
                    <td class="currency">$2,399</td>
                    
                    <td class="currency">$35</td>
                    <td class="currency">$700</td>
                    <td class="currency">$595</td>
                    
                    <td class="currency">$0</td>
                    <td class="currency">$0</td>
                    <td class="currency">$0</td>
                </tr>
                <tr>
                    <td class="salesrep-name">Zaccaria Ackad</td>
                    <td class="percentage low-performance">52.6%</td>
                    
                    <td class="number">0</td>
                    <td class="number">0</td>
                    <td class="number">0</td>
                    
                    <td class="number">0</td>
                    <td class="number">2</td>
                    <td class="number">1</td>
                    
                    <td class="number">0</td>
                    <td class="number">0</td>
                    <td class="number">0</td>
                    
                    <td class="currency">$0</td>
                    <td class="currency">$0</td>
                    <td class="currency">$0</td>
                    
                    <td class="currency">$8</td>
                    <td class="currency">$168</td>
                    <td class="currency">$142</td>
                    
                    <td class="currency">$0</td>
                    <td class="currency">$0</td>
                    <td class="currency">$0</td>
                </tr>
                <tr class="branch-totals">
                    <td class="salesrep-name">🏢 Orange TOTALS</td>
                    <td class="percentage">40.0%</td>
                    
                    <td class="number">2</td>
                    <td class="number">49</td>
                    <td class="number">41</td>
                    
                    <td class="number">4</td>
                    <td class="number">94</td>
                    <td class="number">79</td>
                    
                    <td class="number">0</td>
                    <td class="number">6</td>
                    <td class="number">5</td>
                    
                    <td class="currency">$2,475</td>
                    <td class="currency">$49,498</td>
                    <td class="currency">$42,073</td>
                    
                    <td class="currency">$1,670</td>
                    <td class="currency">$33,402</td>
                    <td class="currency">$28,391</td>
                    
                    <td class="currency">$51</td>
                    <td class="currency">$1,017</td>
                    <td class="currency">$864</td>
                </tr> -->
            </tbody>
        </table>
    </div>
</div>
<?php }?>

<!-- <div class="branch-section">
    <button class="branch-toggle" onclick="toggleBranch('glendale')">
        <span>🏢 Glendale Branch (34 Sales Reps)</span>
        <span class="toggle-icon" id="glendale-icon">▼</span>
    </button>
    <div class="branch-content" id="glendale">

        <table class="salesrep-table">
            <thead>
                <tr>
                    <th rowspan="3">Sales Representative</th>
                    <th rowspan="3">4-Month<br>Closing Ratio</th>
                    <th colspan="9">Closings by Production (August)</th>
                    <th colspan="9">Revenue by Production (August)</th>
                </tr>
                <tr>
                    <th colspan="3">Title Only - Resale</th>
                    <th colspan="3">Title Only - Refinance</th>
                    <th colspan="3">Escrow Orders</th>
                    <th colspan="3">Title Only - Resale</th>
                    <th colspan="3">Title Only - Refinance</th>
                    <th colspan="3">Escrow Orders</th>
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
                    <td class="salesrep-name">Angeline Wu</td>
                    <td class="percentage medium-performance">63.6%</td>
                    
                    <td class="number">0</td>
                    <td class="number">1</td>
                    <td class="number">0</td>
                    
                    <td class="number">0</td>
                    <td class="number">0</td>
                    <td class="number">0</td>
                    
                    <td class="number">0</td>
                    <td class="number">0</td>
                    <td class="number">0</td>
                    
                    <td class="currency">$36</td>
                    <td class="currency">$727</td>
                    <td class="currency">$618</td>
                    
                    <td class="currency">$0</td>
                    <td class="currency">$0</td>
                    <td class="currency">$0</td>
                    
                    <td class="currency">$0</td>
                    <td class="currency">$0</td>
                    <td class="currency">$0</td>
                </tr>
                <tr>
                    <td class="salesrep-name">Anthony Zamora</td>
                    <td class="percentage low-performance">0.0%</td>
                    
                    <td class="number">0</td>
                    <td class="number">0</td>
                    <td class="number">0</td>
                    
                    <td class="number">0</td>
                    <td class="number">0</td>
                    <td class="number">0</td>
                    
                    <td class="number">0</td>
                    <td class="number">0</td>
                    <td class="number">0</td>
                    
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
                <tr>
                    <td class="salesrep-name">Chuck Cota</td>
                    <td class="percentage low-performance">35.1%</td>
                    
                    <td class="number">0</td>
                    <td class="number">2</td>
                    <td class="number">1</td>
                    
                    <td class="number">0</td>
                    <td class="number">0</td>
                    <td class="number">0</td>
                    
                    <td class="number">0</td>
                    <td class="number">0</td>
                    <td class="number">0</td>
                    
                    <td class="currency">$81</td>
                    <td class="currency">$1,613</td>
                    <td class="currency">$1,371</td>
                    
                    <td class="currency">$0</td>
                    <td class="currency">$0</td>
                    <td class="currency">$0</td>
                    
                    <td class="currency">$0</td>
                    <td class="currency">$0</td>
                    <td class="currency">$0</td>
                </tr>
                <tr>
                    <td class="salesrep-name">Corey Velasquez</td>
                    <td class="percentage low-performance">38.0%</td>
                    
                    <td class="number">0</td>
                    <td class="number">5</td>
                    <td class="number">4</td>
                    
                    <td class="number">0</td>
                    <td class="number">3</td>
                    <td class="number">2</td>
                    
                    <td class="number">0</td>
                    <td class="number">0</td>
                    <td class="number">0</td>
                    
                    <td class="currency">$379</td>
                    <td class="currency">$7,577</td>
                    <td class="currency">$6,440</td>
                    
                    <td class="currency">$159</td>
                    <td class="currency">$3,186</td>
                    <td class="currency">$2,708</td>
                    
                    <td class="currency">$0</td>
                    <td class="currency">$0</td>
                    <td class="currency">$0</td>
                </tr>
                <tr>
                    <td class="salesrep-name">David Gomez</td>
                    <td class="percentage low-performance">57.7%</td>
                    
                    <td class="number">0</td>
                    <td class="number">8</td>
                    <td class="number">6</td>
                    
                    <td class="number">0</td>
                    <td class="number">3</td>
                    <td class="number">2</td>
                    
                    <td class="number">0</td>
                    <td class="number">0</td>
                    <td class="number">0</td>
                    
                    <td class="currency">$508</td>
                    <td class="currency">$10,154</td>
                    <td class="currency">$8,631</td>
                    
                    <td class="currency">$110</td>
                    <td class="currency">$2,196</td>
                    <td class="currency">$1,867</td>
                    
                    <td class="currency">$0</td>
                    <td class="currency">$0</td>
                    <td class="currency">$0</td>
                </tr>
                <tr>
                    <td class="salesrep-name">Felicia Pantoja</td>
                    <td class="percentage low-performance">25.0%</td>
                    
                    <td class="number">0</td>
                    <td class="number">0</td>
                    <td class="number">0</td>
                    
                    <td class="number">0</td>
                    <td class="number">0</td>
                    <td class="number">0</td>
                    
                    <td class="number">0</td>
                    <td class="number">0</td>
                    <td class="number">0</td>
                    
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
                <tr>
                    <td class="salesrep-name">Gerardo Hernandez</td>
                    <td class="percentage low-performance">0.0%</td>
                    
                    <td class="number">0</td>
                    <td class="number">0</td>
                    <td class="number">0</td>
                    
                    <td class="number">0</td>
                    <td class="number">0</td>
                    <td class="number">0</td>
                    
                    <td class="number">0</td>
                    <td class="number">0</td>
                    <td class="number">0</td>
                    
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
                <tr>
                    <td class="salesrep-name">Glendale  House Account</td>
                    <td class="percentage low-performance">25.0%</td>
                    
                    <td class="number">0</td>
                    <td class="number">1</td>
                    <td class="number">0</td>
                    
                    <td class="number">0</td>
                    <td class="number">0</td>
                    <td class="number">0</td>
                    
                    <td class="number">0</td>
                    <td class="number">0</td>
                    <td class="number">0</td>
                    
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
                <tr>
                    <td class="salesrep-name">Glendale Account</td>
                    <td class="percentage low-performance">0.0%</td>
                    
                    <td class="number">0</td>
                    <td class="number">0</td>
                    <td class="number">0</td>
                    
                    <td class="number">0</td>
                    <td class="number">0</td>
                    <td class="number">0</td>
                    
                    <td class="number">0</td>
                    <td class="number">0</td>
                    <td class="number">0</td>
                    
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
                <tr>
                    <td class="salesrep-name">Israel Lopez</td>
                    <td class="percentage low-performance">0.0%</td>
                    
                    <td class="number">0</td>
                    <td class="number">0</td>
                    <td class="number">0</td>
                    
                    <td class="number">0</td>
                    <td class="number">0</td>
                    <td class="number">0</td>
                    
                    <td class="number">0</td>
                    <td class="number">0</td>
                    <td class="number">0</td>
                    
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
                <tr>
                    <td class="salesrep-name">Jesse Lopez</td>
                    <td class="percentage high-performance">100.0%</td>
                    
                    <td class="number">0</td>
                    <td class="number">0</td>
                    <td class="number">0</td>
                    
                    <td class="number">0</td>
                    <td class="number">0</td>
                    <td class="number">0</td>
                    
                    <td class="number">0</td>
                    <td class="number">0</td>
                    <td class="number">0</td>
                    
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
                <tr>
                    <td class="salesrep-name">Jorge Mesa</td>
                    <td class="percentage low-performance">0.0%</td>
                    
                    <td class="number">0</td>
                    <td class="number">0</td>
                    <td class="number">0</td>
                    
                    <td class="number">0</td>
                    <td class="number">0</td>
                    <td class="number">0</td>
                    
                    <td class="number">0</td>
                    <td class="number">0</td>
                    <td class="number">0</td>
                    
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
                <tr>
                    <td class="salesrep-name">Justin Nouri</td>
                    <td class="percentage low-performance">43.4%</td>
                    
                    <td class="number">0</td>
                    <td class="number">3</td>
                    <td class="number">2</td>
                    
                    <td class="number">0</td>
                    <td class="number">2</td>
                    <td class="number">1</td>
                    
                    <td class="number">0</td>
                    <td class="number">0</td>
                    <td class="number">0</td>
                    
                    <td class="currency">$156</td>
                    <td class="currency">$3,127</td>
                    <td class="currency">$2,658</td>
                    
                    <td class="currency">$41</td>
                    <td class="currency">$820</td>
                    <td class="currency">$697</td>
                    
                    <td class="currency">$0</td>
                    <td class="currency">$0</td>
                    <td class="currency">$0</td>
                </tr>
                <tr>
                    <td class="salesrep-name">Kevin Green</td>
                    <td class="percentage low-performance">35.9%</td>
                    
                    <td class="number">0</td>
                    <td class="number">5</td>
                    <td class="number">4</td>
                    
                    <td class="number">0</td>
                    <td class="number">13</td>
                    <td class="number">11</td>
                    
                    <td class="number">0</td>
                    <td class="number">1</td>
                    <td class="number">0</td>
                    
                    <td class="currency">$356</td>
                    <td class="currency">$7,114</td>
                    <td class="currency">$6,047</td>
                    
                    <td class="currency">$415</td>
                    <td class="currency">$8,302</td>
                    <td class="currency">$7,057</td>
                    
                    <td class="currency">$8</td>
                    <td class="currency">$153</td>
                    <td class="currency">$130</td>
                </tr>
                <tr>
                    <td class="salesrep-name">Lopez Team</td>
                    <td class="percentage low-performance">36.0%</td>
                    
                    <td class="number">1</td>
                    <td class="number">25</td>
                    <td class="number">21</td>
                    
                    <td class="number">0</td>
                    <td class="number">2</td>
                    <td class="number">1</td>
                    
                    <td class="number">0</td>
                    <td class="number">0</td>
                    <td class="number">0</td>
                    
                    <td class="currency">$1,365</td>
                    <td class="currency">$27,296</td>
                    <td class="currency">$23,202</td>
                    
                    <td class="currency">$40</td>
                    <td class="currency">$810</td>
                    <td class="currency">$688</td>
                    
                    <td class="currency">$0</td>
                    <td class="currency">$0</td>
                    <td class="currency">$0</td>
                </tr>
                <tr>
                    <td class="salesrep-name">Louis Martinez</td>
                    <td class="percentage low-performance">0.0%</td>
                    
                    <td class="number">0</td>
                    <td class="number">0</td>
                    <td class="number">0</td>
                    
                    <td class="number">0</td>
                    <td class="number">0</td>
                    <td class="number">0</td>
                    
                    <td class="number">0</td>
                    <td class="number">0</td>
                    <td class="number">0</td>
                    
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
                <tr>
                    <td class="salesrep-name">Louis Morreale</td>
                    <td class="percentage high-performance">87.5%</td>
                    
                    <td class="number">0</td>
                    <td class="number">5</td>
                    <td class="number">4</td>
                    
                    <td class="number">0</td>
                    <td class="number">1</td>
                    <td class="number">0</td>
                    
                    <td class="number">0</td>
                    <td class="number">0</td>
                    <td class="number">0</td>
                    
                    <td class="currency">$248</td>
                    <td class="currency">$4,959</td>
                    <td class="currency">$4,215</td>
                    
                    <td class="currency">$3</td>
                    <td class="currency">$64</td>
                    <td class="currency">$54</td>
                    
                    <td class="currency">$0</td>
                    <td class="currency">$0</td>
                    <td class="currency">$0</td>
                </tr>
                <tr>
                    <td class="salesrep-name">Maria Basilio</td>
                    <td class="percentage low-performance">22.2%</td>
                    
                    <td class="number">0</td>
                    <td class="number">0</td>
                    <td class="number">0</td>
                    
                    <td class="number">0</td>
                    <td class="number">1</td>
                    <td class="number">0</td>
                    
                    <td class="number">0</td>
                    <td class="number">0</td>
                    <td class="number">0</td>
                    
                    <td class="currency">$0</td>
                    <td class="currency">$0</td>
                    <td class="currency">$0</td>
                    
                    <td class="currency">$20</td>
                    <td class="currency">$405</td>
                    <td class="currency">$344</td>
                    
                    <td class="currency">$0</td>
                    <td class="currency">$0</td>
                    <td class="currency">$0</td>
                </tr>
                <tr>
                    <td class="salesrep-name">Michael Caballero</td>
                    <td class="percentage high-performance">100.0%</td>
                    
                    <td class="number">0</td>
                    <td class="number">4</td>
                    <td class="number">3</td>
                    
                    <td class="number">0</td>
                    <td class="number">1</td>
                    <td class="number">0</td>
                    
                    <td class="number">0</td>
                    <td class="number">0</td>
                    <td class="number">0</td>
                    
                    <td class="currency">$221</td>
                    <td class="currency">$4,420</td>
                    <td class="currency">$3,757</td>
                    
                    <td class="currency">$38</td>
                    <td class="currency">$756</td>
                    <td class="currency">$643</td>
                    
                    <td class="currency">$0</td>
                    <td class="currency">$0</td>
                    <td class="currency">$0</td>
                </tr>
                <tr>
                    <td class="salesrep-name">Michael Nouri</td>
                    <td class="percentage low-performance">42.9%</td>
                    
                    <td class="number">0</td>
                    <td class="number">2</td>
                    <td class="number">1</td>
                    
                    <td class="number">0</td>
                    <td class="number">7</td>
                    <td class="number">5</td>
                    
                    <td class="number">0</td>
                    <td class="number">0</td>
                    <td class="number">0</td>
                    
                    <td class="currency">$104</td>
                    <td class="currency">$2,078</td>
                    <td class="currency">$1,766</td>
                    
                    <td class="currency">$184</td>
                    <td class="currency">$3,684</td>
                    <td class="currency">$3,131</td>
                    
                    <td class="currency">$0</td>
                    <td class="currency">$0</td>
                    <td class="currency">$0</td>
                </tr>
                <tr>
                    <td class="salesrep-name">Nelson Torres</td>
                    <td class="percentage low-performance">37.5%</td>
                    
                    <td class="number">0</td>
                    <td class="number">0</td>
                    <td class="number">0</td>
                    
                    <td class="number">0</td>
                    <td class="number">0</td>
                    <td class="number">0</td>
                    
                    <td class="number">0</td>
                    <td class="number">0</td>
                    <td class="number">0</td>
                    
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
                <tr>
                    <td class="salesrep-name">Nini Kerns</td>
                    <td class="percentage medium-performance">68.2%</td>
                    
                    <td class="number">0</td>
                    <td class="number">0</td>
                    <td class="number">0</td>
                    
                    <td class="number">0</td>
                    <td class="number">3</td>
                    <td class="number">2</td>
                    
                    <td class="number">0</td>
                    <td class="number">0</td>
                    <td class="number">0</td>
                    
                    <td class="currency">$0</td>
                    <td class="currency">$0</td>
                    <td class="currency">$0</td>
                    
                    <td class="currency">$194</td>
                    <td class="currency">$3,879</td>
                    <td class="currency">$3,297</td>
                    
                    <td class="currency">$0</td>
                    <td class="currency">$0</td>
                    <td class="currency">$0</td>
                </tr>
                <tr>
                    <td class="salesrep-name">Richard Bohn</td>
                    <td class="percentage medium-performance">62.5%</td>
                    
                    <td class="number">0</td>
                    <td class="number">1</td>
                    <td class="number">0</td>
                    
                    <td class="number">0</td>
                    <td class="number">1</td>
                    <td class="number">0</td>
                    
                    <td class="number">0</td>
                    <td class="number">0</td>
                    <td class="number">0</td>
                    
                    <td class="currency">$60</td>
                    <td class="currency">$1,191</td>
                    <td class="currency">$1,012</td>
                    
                    <td class="currency">$38</td>
                    <td class="currency">$756</td>
                    <td class="currency">$643</td>
                    
                    <td class="currency">$0</td>
                    <td class="currency">$0</td>
                    <td class="currency">$0</td>
                </tr>
                <tr>
                    <td class="salesrep-name">Rouanne Garcia</td>
                    <td class="percentage low-performance">59.1%</td>
                    
                    <td class="number">0</td>
                    <td class="number">2</td>
                    <td class="number">1</td>
                    
                    <td class="number">0</td>
                    <td class="number">0</td>
                    <td class="number">0</td>
                    
                    <td class="number">0</td>
                    <td class="number">0</td>
                    <td class="number">0</td>
                    
                    <td class="currency">$252</td>
                    <td class="currency">$5,050</td>
                    <td class="currency">$4,292</td>
                    
                    <td class="currency">$0</td>
                    <td class="currency">$0</td>
                    <td class="currency">$0</td>
                    
                    <td class="currency">$0</td>
                    <td class="currency">$0</td>
                    <td class="currency">$0</td>
                </tr>
                <tr>
                    <td class="salesrep-name">Simon Wu</td>
                    <td class="percentage medium-performance">65.3%</td>
                    
                    <td class="number">0</td>
                    <td class="number">3</td>
                    <td class="number">2</td>
                    
                    <td class="number">0</td>
                    <td class="number">2</td>
                    <td class="number">1</td>
                    
                    <td class="number">0</td>
                    <td class="number">0</td>
                    <td class="number">0</td>
                    
                    <td class="currency">$88</td>
                    <td class="currency">$1,755</td>
                    <td class="currency">$1,492</td>
                    
                    <td class="currency">$46</td>
                    <td class="currency">$922</td>
                    <td class="currency">$784</td>
                    
                    <td class="currency">$0</td>
                    <td class="currency">$0</td>
                    <td class="currency">$0</td>
                </tr>
                <tr>
                    <td class="salesrep-name">Sonia Flores</td>
                    <td class="percentage high-performance">86.4%</td>
                    
                    <td class="number">0</td>
                    <td class="number">3</td>
                    <td class="number">2</td>
                    
                    <td class="number">0</td>
                    <td class="number">1</td>
                    <td class="number">0</td>
                    
                    <td class="number">0</td>
                    <td class="number">0</td>
                    <td class="number">0</td>
                    
                    <td class="currency">$68</td>
                    <td class="currency">$1,367</td>
                    <td class="currency">$1,162</td>
                    
                    <td class="currency">$3</td>
                    <td class="currency">$50</td>
                    <td class="currency">$43</td>
                    
                    <td class="currency">$0</td>
                    <td class="currency">$0</td>
                    <td class="currency">$0</td>
                </tr>
                <tr>
                    <td class="salesrep-name">Team Meza</td>
                    <td class="percentage low-performance">43.0%</td>
                    
                    <td class="number">1</td>
                    <td class="number">33</td>
                    <td class="number">28</td>
                    
                    <td class="number">0</td>
                    <td class="number">10</td>
                    <td class="number">8</td>
                    
                    <td class="number">0</td>
                    <td class="number">0</td>
                    <td class="number">0</td>
                    
                    <td class="currency">$1,418</td>
                    <td class="currency">$28,358</td>
                    <td class="currency">$24,104</td>
                    
                    <td class="currency">$257</td>
                    <td class="currency">$5,136</td>
                    <td class="currency">$4,365</td>
                    
                    <td class="currency">$0</td>
                    <td class="currency">$0</td>
                    <td class="currency">$0</td>
                </tr>
                <tr>
                    <td class="salesrep-name">Title Gals</td>
                    <td class="percentage low-performance">37.5%</td>
                    
                    <td class="number">0</td>
                    <td class="number">4</td>
                    <td class="number">3</td>
                    
                    <td class="number">0</td>
                    <td class="number">2</td>
                    <td class="number">1</td>
                    
                    <td class="number">0</td>
                    <td class="number">0</td>
                    <td class="number">0</td>
                    
                    <td class="currency">$191</td>
                    <td class="currency">$3,821</td>
                    <td class="currency">$3,248</td>
                    
                    <td class="currency">$59</td>
                    <td class="currency">$1,188</td>
                    <td class="currency">$1,010</td>
                    
                    <td class="currency">$0</td>
                    <td class="currency">$0</td>
                    <td class="currency">$0</td>
                </tr>
                <tr>
                    <td class="salesrep-name">Title Team</td>
                    <td class="percentage low-performance">54.7%</td>
                    
                    <td class="number">0</td>
                    <td class="number">4</td>
                    <td class="number">3</td>
                    
                    <td class="number">0</td>
                    <td class="number">1</td>
                    <td class="number">0</td>
                    
                    <td class="number">0</td>
                    <td class="number">0</td>
                    <td class="number">0</td>
                    
                    <td class="currency">$262</td>
                    <td class="currency">$5,246</td>
                    <td class="currency">$4,459</td>
                    
                    <td class="currency">$26</td>
                    <td class="currency">$518</td>
                    <td class="currency">$440</td>
                    
                    <td class="currency">$0</td>
                    <td class="currency">$0</td>
                    <td class="currency">$0</td>
                </tr>
                <tr>
                    <td class="salesrep-name">Tony Baumgartner</td>
                    <td class="percentage low-performance">59.0%</td>
                    
                    <td class="number">0</td>
                    <td class="number">0</td>
                    <td class="number">0</td>
                    
                    <td class="number">0</td>
                    <td class="number">5</td>
                    <td class="number">4</td>
                    
                    <td class="number">0</td>
                    <td class="number">0</td>
                    <td class="number">0</td>
                    
                    <td class="currency">$0</td>
                    <td class="currency">$0</td>
                    <td class="currency">$0</td>
                    
                    <td class="currency">$143</td>
                    <td class="currency">$2,851</td>
                    <td class="currency">$2,423</td>
                    
                    <td class="currency">$0</td>
                    <td class="currency">$0</td>
                    <td class="currency">$0</td>
                </tr>
                <tr>
                    <td class="salesrep-name">Ventura Account</td>
                    <td class="percentage low-performance">0.0%</td>
                    
                    <td class="number">0</td>
                    <td class="number">0</td>
                    <td class="number">0</td>
                    
                    <td class="number">0</td>
                    <td class="number">0</td>
                    <td class="number">0</td>
                    
                    <td class="number">0</td>
                    <td class="number">0</td>
                    <td class="number">0</td>
                    
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
                <tr>
                    <td class="salesrep-name">Ventura House Account</td>
                    <td class="percentage low-performance">49.7%</td>
                    
                    <td class="number">0</td>
                    <td class="number">9</td>
                    <td class="number">7</td>
                    
                    <td class="number">0</td>
                    <td class="number">3</td>
                    <td class="number">2</td>
                    
                    <td class="number">0</td>
                    <td class="number">0</td>
                    <td class="number">0</td>
                    
                    <td class="currency">$530</td>
                    <td class="currency">$10,598</td>
                    <td class="currency">$9,008</td>
                    
                    <td class="currency">$85</td>
                    <td class="currency">$1,706</td>
                    <td class="currency">$1,450</td>
                    
                    <td class="currency">$0</td>
                    <td class="currency">$0</td>
                    <td class="currency">$0</td>
                </tr>
                <tr>
                    <td class="salesrep-name">Veronica Sanchez</td>
                    <td class="percentage medium-performance">62.3%</td>
                    
                    <td class="number">0</td>
                    <td class="number">2</td>
                    <td class="number">1</td>
                    
                    <td class="number">0</td>
                    <td class="number">1</td>
                    <td class="number">0</td>
                    
                    <td class="number">0</td>
                    <td class="number">0</td>
                    <td class="number">0</td>
                    
                    <td class="currency">$91</td>
                    <td class="currency">$1,819</td>
                    <td class="currency">$1,546</td>
                    
                    <td class="currency">$30</td>
                    <td class="currency">$594</td>
                    <td class="currency">$505</td>
                    
                    <td class="currency">$0</td>
                    <td class="currency">$0</td>
                    <td class="currency">$0</td>
                </tr>
                <tr>
                    <td class="salesrep-name">Vito D'Alessandro</td>
                    <td class="percentage high-performance">100.0%</td>
                    
                    <td class="number">0</td>
                    <td class="number">1</td>
                    <td class="number">0</td>
                    
                    <td class="number">0</td>
                    <td class="number">0</td>
                    <td class="number">0</td>
                    
                    <td class="number">0</td>
                    <td class="number">0</td>
                    <td class="number">0</td>
                    
                    <td class="currency">$48</td>
                    <td class="currency">$966</td>
                    <td class="currency">$821</td>
                    
                    <td class="currency">$0</td>
                    <td class="currency">$0</td>
                    <td class="currency">$0</td>
                    
                    <td class="currency">$0</td>
                    <td class="currency">$0</td>
                    <td class="currency">$0</td>
                </tr>
                <tr class="branch-totals">
                    <td class="salesrep-name">🏢 Glendale TOTALS</td>
                    <td class="percentage">44.0%</td>
                    
                    <td class="number">6</td>
                    <td class="number">123</td>
                    <td class="number">104</td>
                    
                    <td class="number">3</td>
                    <td class="number">62</td>
                    <td class="number">52</td>
                    
                    <td class="number">0</td>
                    <td class="number">1</td>
                    <td class="number">0</td>
                    
                    <td class="currency">$6,462</td>
                    <td class="currency">$129,234</td>
                    <td class="currency">$109,849</td>
                    
                    <td class="currency">$1,891</td>
                    <td class="currency">$37,821</td>
                    <td class="currency">$32,148</td>
                    
                    <td class="currency">$8</td>
                    <td class="currency">$153</td>
                    <td class="currency">$130</td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
<div class="branch-section">
    <button class="branch-toggle" onclick="toggleBranch('inland-empire')">
        <span>🏢 Inland Empire Branch (4 Sales Reps)</span>
        <span class="toggle-icon" id="inland-empire-icon">▼</span>
    </button>
    <div class="branch-content" id="inland-empire">

        <table class="salesrep-table">
            <thead>
                <tr>
                    <th rowspan="3">Sales Representative</th>
                    <th rowspan="3">4-Month<br>Closing Ratio</th>
                    <th colspan="9">Closings by Production (August)</th>
                    <th colspan="9">Revenue by Production (August)</th>
                </tr>
                <tr>
                    <th colspan="3">Title Only - Resale</th>
                    <th colspan="3">Title Only - Refinance</th>
                    <th colspan="3">Escrow Orders</th>
                    <th colspan="3">Title Only - Resale</th>
                    <th colspan="3">Title Only - Refinance</th>
                    <th colspan="3">Escrow Orders</th>
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
                <?php foreach($branch as $salesId => $salesDetails) ?>
                <tr>
                    <td class="salesrep-name"><?php echo $salesDetails['sales_rep'] ?></td>
                    <td class="percentage high-performance"><?php echo $salesDetails['closing_ratio'] ?>%</td>
                    
                    <td class="number"><?php echo $salesDetails['today_purchase_cnt'] ?></td>
                    <td class="number"><?php echo $salesDetails['mtd_purchase_cnt'] ?></td>
                    <td class="number"><?php echo $salesDetails['prior_purchase_cnt'] ?></td>
                    
                    <td class="number"><?php echo $salesDetails['today_refi_cnt'] ?></td>
                    <td class="number"><?php echo $salesDetails['mtd_refi_cnt'] ?></td>
                    <td class="number"><?php echo $salesDetails['prior_refi_cnt'] ?></td>
                    
                    <td class="number"><?php echo 0; ?></td>
                    <td class="number"><?php echo 0; ?></td>
                    <td class="number"><?php echo 0; ?></td>
                    
                    <td class="currency">$<?php echo $salesDetails['today_purchase_rev'] ?></td>
                    <td class="currency">$<?php echo $salesDetails['mtd_purchase_rev'] ?></td>
                    <td class="currency">$<?php echo $salesDetails['prior_purchase_rev'] ?></td>
                    
                    <td class="currency">$<?php echo $salesDetails['today_refi_rev'] ?></td>
                    <td class="currency">$<?php echo $salesDetails['mtd_refi_rev'] ?></td>
                    <td class="currency">$<?php echo $salesDetails['prior_refi_rev'] ?></td>
                    
                    <td class="currency">$<?php echo 0 ?></td>
                    <td class="currency">$<?php echo 0 ?></td>
                    <td class="currency">$<?php echo 0 ?></td>
                </tr>
                <tr>
                    <td class="salesrep-name">Lopez Team</td>
                    <td class="percentage low-performance">28.6%</td>
                    
                    <td class="number">0</td>
                    <td class="number">0</td>
                    <td class="number">0</td>
                    
                    <td class="number">0</td>
                    <td class="number">0</td>
                    <td class="number">0</td>
                    
                    <td class="number">0</td>
                    <td class="number">3</td>
                    <td class="number">2</td>
                    
                    <td class="currency">$0</td>
                    <td class="currency">$0</td>
                    <td class="currency">$0</td>
                    
                    <td class="currency">$0</td>
                    <td class="currency">$0</td>
                    <td class="currency">$0</td>
                    
                    <td class="currency">$91</td>
                    <td class="currency">$1,815</td>
                    <td class="currency">$1,543</td>
                </tr>
                <tr>
                    <td class="salesrep-name">Michael Caballero</td>
                    <td class="percentage low-performance">50.0%</td>
                    
                    <td class="number">0</td>
                    <td class="number">0</td>
                    <td class="number">0</td>
                    
                    <td class="number">0</td>
                    <td class="number">0</td>
                    <td class="number">0</td>
                    
                    <td class="number">0</td>
                    <td class="number">1</td>
                    <td class="number">0</td>
                    
                    <td class="currency">$0</td>
                    <td class="currency">$0</td>
                    <td class="currency">$0</td>
                    
                    <td class="currency">$0</td>
                    <td class="currency">$0</td>
                    <td class="currency">$0</td>
                    
                    <td class="currency">$50</td>
                    <td class="currency">$1,005</td>
                    <td class="currency">$855</td>
                </tr>
                <tr>
                    <td class="salesrep-name">Nicholas Watt</td>
                    <td class="percentage high-performance">100.0%</td>
                    
                    <td class="number">0</td>
                    <td class="number">0</td>
                    <td class="number">0</td>
                    
                    <td class="number">0</td>
                    <td class="number">0</td>
                    <td class="number">0</td>
                    
                    <td class="number">0</td>
                    <td class="number">1</td>
                    <td class="number">0</td>
                    
                    <td class="currency">$0</td>
                    <td class="currency">$0</td>
                    <td class="currency">$0</td>
                    
                    <td class="currency">$0</td>
                    <td class="currency">$0</td>
                    <td class="currency">$0</td>
                    
                    <td class="currency">$27</td>
                    <td class="currency">$540</td>
                    <td class="currency">$459</td>
                </tr>
                <tr class="branch-totals">
                    <td class="salesrep-name">🏢 Inland Empire TOTALS</td>
                    <td class="percentage">69.6%</td>
                    
                    <td class="number">0</td>
                    <td class="number">0</td>
                    <td class="number">0</td>
                    
                    <td class="number">0</td>
                    <td class="number">0</td>
                    <td class="number">0</td>
                    
                    <td class="number">0</td>
                    <td class="number">6</td>
                    <td class="number">5</td>
                    
                    <td class="currency">$0</td>
                    <td class="currency">$0</td>
                    <td class="currency">$0</td>
                    
                    <td class="currency">$0</td>
                    <td class="currency">$0</td>
                    <td class="currency">$0</td>
                    
                    <td class="currency">$198</td>
                    <td class="currency">$3,955</td>
                    <td class="currency">$3,361</td>
                </tr>
            </tbody>
        </table>
    </div>
</div>

<div class="branch-section">
    <button class="branch-toggle" onclick="toggleBranch('porterville')">
        <span>🏢 Porterville Branch (1 Sales Reps)</span>
        <span class="toggle-icon" id="porterville-icon">▼</span>
    </button>
    <div class="branch-content" id="porterville">

        <table class="salesrep-table">
            <thead>
                <tr>
                    <th rowspan="3">Sales Representative</th>
                    <th rowspan="3">4-Month<br>Closing Ratio</th>
                    <th colspan="9">Closings by Production (August)</th>
                    <th colspan="9">Revenue by Production (August)</th>
                </tr>
                <tr>
                    <th colspan="3">Title Only - Resale</th>
                    <th colspan="3">Title Only - Refinance</th>
                    <th colspan="3">Escrow Orders</th>
                    <th colspan="3">Title Only - Resale</th>
                    <th colspan="3">Title Only - Refinance</th>
                    <th colspan="3">Escrow Orders</th>
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
                    <td class="salesrep-name">Orange County House Account</td>
                    <td class="percentage low-performance">24.5%</td>
                    
                    <td class="number">0</td>
                    <td class="number">0</td>
                    <td class="number">0</td>
                    
                    <td class="number">0</td>
                    <td class="number">0</td>
                    <td class="number">0</td>
                    
                    <td class="number">0</td>
                    <td class="number">2</td>
                    <td class="number">1</td>
                    
                    <td class="currency">$0</td>
                    <td class="currency">$0</td>
                    <td class="currency">$0</td>
                    
                    <td class="currency">$0</td>
                    <td class="currency">$0</td>
                    <td class="currency">$0</td>
                    
                    <td class="currency">$33</td>
                    <td class="currency">$664</td>
                    <td class="currency">$564</td>
                </tr>
                <tr class="branch-totals">
                    <td class="salesrep-name">🏢 Porterville TOTALS</td>
                    <td class="percentage">24.5%</td>
                    
                    <td class="number">0</td>
                    <td class="number">0</td>
                    <td class="number">0</td>
                    
                    <td class="number">0</td>
                    <td class="number">0</td>
                    <td class="number">0</td>
                    
                    <td class="number">0</td>
                    <td class="number">2</td>
                    <td class="number">1</td>
                    
                    <td class="currency">$0</td>
                    <td class="currency">$0</td>
                    <td class="currency">$0</td>
                    
                    <td class="currency">$0</td>
                    <td class="currency">$0</td>
                    <td class="currency">$0</td>
                    
                    <td class="currency">$33</td>
                    <td class="currency">$664</td>
                    <td class="currency">$564</td>
                </tr>
            </tbody>
        </table>
    </div>
</div>

<div class="branch-section">
    <button class="branch-toggle" onclick="toggleBranch('tsg')">
        <span>🏢 TSG Branch (5 Sales Reps)</span>
        <span class="toggle-icon" id="tsg-icon">▼</span>
    </button>
    <div class="branch-content" id="tsg">

        <table class="salesrep-table">
            <thead>
                <tr>
                    <th rowspan="3">Sales Representative</th>
                    <th rowspan="3">4-Month<br>Closing Ratio</th>
                    <th colspan="9">Closings by Production (August)</th>
                    <th colspan="9">Revenue by Production (August)</th>
                </tr>
                <tr>
                    <th colspan="3">Title Only - Resale</th>
                    <th colspan="3">Title Only - Refinance</th>
                    <th colspan="3">Escrow Orders</th>
                    <th colspan="3">Title Only - Resale</th>
                    <th colspan="3">Title Only - Refinance</th>
                    <th colspan="3">Escrow Orders</th>
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
                    <td class="salesrep-name">Dan Culnane</td>
                    <td class="percentage high-performance">96.8%</td>
                    
                    <td class="number">0</td>
                    <td class="number">0</td>
                    <td class="number">0</td>
                    
                    <td class="number">0</td>
                    <td class="number">0</td>
                    <td class="number">0</td>
                    
                    <td class="number">0</td>
                    <td class="number">0</td>
                    <td class="number">0</td>
                    
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
                <tr>
                    <td class="salesrep-name">John Thaete</td>
                    <td class="percentage medium-performance">73.4%</td>
                    
                    <td class="number">0</td>
                    <td class="number">0</td>
                    <td class="number">0</td>
                    
                    <td class="number">0</td>
                    <td class="number">0</td>
                    <td class="number">0</td>
                    
                    <td class="number">0</td>
                    <td class="number">0</td>
                    <td class="number">0</td>
                    
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
                <tr>
                    <td class="salesrep-name">Kevin Cameron</td>
                    <td class="percentage low-performance">0.0%</td>
                    
                    <td class="number">0</td>
                    <td class="number">0</td>
                    <td class="number">0</td>
                    
                    <td class="number">0</td>
                    <td class="number">0</td>
                    <td class="number">0</td>
                    
                    <td class="number">0</td>
                    <td class="number">0</td>
                    <td class="number">0</td>
                    
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
                <tr>
                    <td class="salesrep-name">Sandra Millar</td>
                    <td class="percentage high-performance">98.3%</td>
                    
                    <td class="number">0</td>
                    <td class="number">0</td>
                    <td class="number">0</td>
                    
                    <td class="number">0</td>
                    <td class="number">0</td>
                    <td class="number">0</td>
                    
                    <td class="number">0</td>
                    <td class="number">0</td>
                    <td class="number">0</td>
                    
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
                <tr>
                    <td class="salesrep-name">Zaccaria Ackad</td>
                    <td class="percentage low-performance">0.0%</td>
                    
                    <td class="number">0</td>
                    <td class="number">0</td>
                    <td class="number">0</td>
                    
                    <td class="number">0</td>
                    <td class="number">0</td>
                    <td class="number">0</td>
                    
                    <td class="number">0</td>
                    <td class="number">0</td>
                    <td class="number">0</td>
                    
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
                    <td class="salesrep-name">🏢 TSG TOTALS</td>
                    <td class="percentage">53.7%</td>
                    
                    <td class="number">0</td>
                    <td class="number">0</td>
                    <td class="number">0</td>
                    
                    <td class="number">0</td>
                    <td class="number">0</td>
                    <td class="number">0</td>
                    
                    <td class="number">0</td>
                    <td class="number">0</td>
                    <td class="number">0</td>
                    
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
</div>

<div class="branch-section">
    <button class="branch-toggle" onclick="toggleBranch('production')">
        <span>🏢 Production Branch (2 Sales Reps)</span>
        <span class="toggle-icon" id="production-icon">▼</span>
    </button>
    <div class="branch-content" id="production">

        <table class="salesrep-table">
            <thead>
                <tr>
                    <th rowspan="3">Sales Representative</th>
                    <th rowspan="3">4-Month<br>Closing Ratio</th>
                    <th colspan="9">Closings by Production (August)</th>
                    <th colspan="9">Revenue by Production (August)</th>
                </tr>
                <tr>
                    <th colspan="3">Title Only - Resale</th>
                    <th colspan="3">Title Only - Refinance</th>
                    <th colspan="3">Escrow Orders</th>
                    <th colspan="3">Title Only - Resale</th>
                    <th colspan="3">Title Only - Refinance</th>
                    <th colspan="3">Escrow Orders</th>
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
                    <td class="salesrep-name">Lopez Team</td>
                    <td class="percentage low-performance">6.7%</td>
                    
                    <td class="number">0</td>
                    <td class="number">0</td>
                    <td class="number">0</td>
                    
                    <td class="number">0</td>
                    <td class="number">0</td>
                    <td class="number">0</td>
                    
                    <td class="number">0</td>
                    <td class="number">0</td>
                    <td class="number">0</td>
                    
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
                <tr>
                    <td class="salesrep-name">Sandra Millar</td>
                    <td class="percentage low-performance">0.0%</td>
                    
                    <td class="number">0</td>
                    <td class="number">0</td>
                    <td class="number">0</td>
                    
                    <td class="number">0</td>
                    <td class="number">0</td>
                    <td class="number">0</td>
                    
                    <td class="number">0</td>
                    <td class="number">0</td>
                    <td class="number">0</td>
                    
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
                    <td class="salesrep-name">🏢 Production TOTALS</td>
                    <td class="percentage">3.3%</td>
                    
                    <td class="number">0</td>
                    <td class="number">0</td>
                    <td class="number">0</td>
                    
                    <td class="number">0</td>
                    <td class="number">0</td>
                    <td class="number">0</td>
                    
                    <td class="number">0</td>
                    <td class="number">0</td>
                    <td class="number">0</td>
                    
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
    <p>Report generated on August 21, 2025 at 02:59 PM | Pacific Coast Title Company</p>
    <p>Sales Representative Performance Analysis - R-14 Report | Mapping File Based Assignment</p>
</div> -->