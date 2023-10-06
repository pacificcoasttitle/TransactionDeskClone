<html>
<head>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700;900&family=Poppins:wght@400;500;700;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="<?php echo base_url('assets/frontend/css/sales-snap-shot/style.css');?>">
</head>
<body>
    <div class="page_container">
        <div class="pdf_page size_letter">
            <div class="pdf_header">
                <h1>SALES SNAP SHOT</h1>
                <div class="overview_text">3 MONTH OVERVIEW</div>
                <div class="santa_monica"><?php echo $area_name;?></div>
                <img src="<?php echo base_url('assets/sales_snap_shot/logo.png') ?>" class="pacific_logo" alt="">
            </div>
            <div class="pdf_body">
                <div class="grid">
                    <div>
                        <img src="<?php echo base_url('assets/sales_snap_shot/report.png') ?>" alt="report">
                        <h4>Total SFR Sales</h4>
                        <div class="count"><?php echo $total_records;?></div>
                    </div>
                    <div>
                        <img src="<?php echo base_url('assets/sales_snap_shot/Price.png') ?>" alt="report">
                        <h4>Avg. Sales Price</h4>
                        <div class="count">$<?php echo number_format($avg_sales_price);?></div>
                    </div>
                    <div>
                        <img src="<?php echo base_url('assets/sales_snap_shot/home.png') ?>" alt="report">
                        <h4>Avg. Price Per Sqft</h4>
                        <div class="count">$<?php echo number_format($avg_price_per_sq_ft);?></div>
                    </div>
                </div>
                <div class="grid">
                    <div>
                        <img src="<?php echo base_url('assets/sales_snap_shot/Bed.png') ?>" alt="report">
                        <h4>Avg. Beds</h4>
                        <div class="count"><?php echo number_format($avg_beds, 1);?></div>
                    </div>
                    <div>
                        <img src="<?php echo base_url('assets/sales_snap_shot/Bath.png') ?>" alt="report">
                        <h4>Avg. Baths</h4>
                        <div class="count"><?php echo number_format($avg_baths,1);?></div>
                    </div>
                    <div>
                        <img src="<?php echo base_url('assets/sales_snap_shot/Rent.png') ?>" alt="report">
                        <h4>Absentee %</h4>
                        <div class="count"><?php echo number_format($absentee,2);?>%</div>
                    </div>
                </div>
                <table>
                    <thead>
                        <tr>
                            <th>MONTH BY MONTH</th>
                            <th>AVG. SALES PRICE</th>
                            <th>AVG. $ SQFT</th>
                            <th>PRICE % CHANGE</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>SEPTEMBER - 2023</td>
                            <td>$425,000</td>
                            <td>$325</td>
                            <td>0.125%</td>
                        </tr>
                        <tr>
                            <td>AUGUST - 2023</td>
                            <td>$425,000</td>
                            <td>$325</td>
                            <td>3.025%</td>
                        </tr>
                        <tr>
                            <td>JULY - 2023</td>
                            <td>$425,000</td>
                            <td>$325</td>
                            <td>0.001%</td>
                        </tr>
                    </tbody>
                </table>
            </div>           
            <div class="pdf_footer">
                <div class="media-object">
                    <img src="img/ZoeNoelleSmall.png" alt="">
                    <div>
                        <div class="zoe-name">Zoe Noelle</div>
                        <div class="occupation">Account Executive</div>
                        <div class="contact-detail">
                            <a href="tel:213-909-6541">213-909-6541</a>
                            <a href="mailto:ecastro@pct.com">ecastro@pct.com</a>
                        </div>
                    </div>
                </div>
                <div class="sales-price">
                    Report as of 10/03/2023 <br>
                    995K Max Sales Price <br>
                    SFR’s Only
                </div>
            </div>
        </div>
    </div>
</body>
