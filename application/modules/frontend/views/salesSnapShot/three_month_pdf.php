<html>
<head>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700;900&family=Poppins:wght@400;500;700;900&display=swap" rel="stylesheet">
    <style>
        body{
            font-family: 'Montserrat', sans-serif;
            margin: 0;
            padding: 0;
        }
        *{
            box-sizing: border-box;
        }
        .size_a4 { width: 8.3in; height: 11.7in; }
        .size_letter { width: 8.5in; height: 11in; }
        .size_executive { width: 7.25in; height: 10.5in; }
        .pdf_page {
            margin: 0 auto;
            box-sizing: border-box;
            background-color: #fff;
            color: #333;
            position: relative;
        }
        .pdf_header {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            background: url('../../../../../assets/sales_snap_shot/GenericBG.jpg') no-repeat;
            background-size: cover;
            padding: 40px;
            height: 240px;
            background-position: center;
        }
        .pacific_logo {
            position: absolute;
            right: 40px;
            top: 50%;
            transform: translateY(-50%);
            width: 230px;
        }
        .pdf_header h1{
            font-size: 50px;
            font-weight: 900;
            color: #fff;
            margin: 0;
            line-height: 60px;
        }
        .overview_text{
            font-size: 32px;
            font-weight: 500;
            color: #fff;
        }
        .santa_monica {
            font-size: 32px;
            font-weight: 700;
            color: #f26a2a;
            margin-top: 20px;
        }
        .pdf_footer {
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            padding-top: 10px;
            text-align: left;
            font-size: 16px;
            font-weight: 600;
        }
        .pdf_footer p{
            margin: 0;
        }
        .page_text{
            float: right;
        }
        .page_title{
            float: left;
        }
        .pdf_body {
            position: absolute;
            top: 270px;
            bottom: 1.2in;
            left: 0;
            right: 0;
        }
        .grid{
            margin-bottom: 20px;
        }
        .grid::after{
            display: table;
            content: '';
            width: 100%;
        }
        .grid > div {
            float: left;
            width: 33.33%;
            text-align: center;
        }
        .grid > div img {
            width: 90px;
        }
        .grid h4{
            font-size: 20px;
            color: #0a2a3d;
            font-weight: 500;
            margin: 10px 0;
        }
        .count {
            font-size: 40px;
            font-weight: 900;
            color: #0a2a3d;
            text-align: center;
            line-height: 48px;
            font-family: 'Poppins', sans-serif;
        }
        table{
            width: 100%;
            border-collapse: collapse;
        }
        table th {
            color: #717171;
            font-weight: 500;
            font-size: 20px;
            border-bottom: 4px solid #9ba4aa;
            padding-bottom: 5px;
        }
        table td{
            font-size: 20px;
            color: #717171;
            font-weight: 500;
            text-align: center;
            font-family: 'Poppins', sans-serif;
            padding: 10px 0;
            border-bottom: 2px solid #ccd1d4;
        }
        table tr:last-child td{
            border-bottom: 4px solid #9ba4aa;
        }
        table td:first-child{
            text-align: left;
            font-weight: bold;
            color: #f26a2a;
            font-family: 'Montserrat', sans-serif;
        }
        .media-object img {
            width: 150px;
            height: 150px;
            border-radius: 50%;
            background: #8dc9ff;
            margin-right: 15px;
        }
        .media-object > *{
            float: left;
        }
        .zoe-name {
            color: #04415d;
            font-size: 24px;
            font-weight: 700;
            margin-top: 20px;
        }
        .occupation {
            color: #d35400;
            font-size: 18px;
            font-weight: 400;
            margin-bottom: 5px;
        }
        .contact-detail a {
            color: #04415d;
            text-decoration: none;
            font-weight: 700;
            display: block;
            font-size: 18px;
        }
        .sales-price {
            float: right;
            color: #717171;
            font-weight: 400;
            font-family: Arial;
            text-align: right;
            line-height: 26px;
            font-size: 20px;
            margin-top: 35px;
        }
    </style>
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
