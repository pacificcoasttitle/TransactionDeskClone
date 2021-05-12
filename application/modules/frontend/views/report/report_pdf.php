<!DOCTYPE html>
<html lang="en">
<head>
    <title>Document</title>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0"> 
    

</head>
<body>
    <style type="text/css">
        body {
  margin: 0;
  padding: 0;
  font-family: 'Montserrat', sans-serif;
  font-size: 16px;
  color: #333;
}
::selection {
  color: #fff;
  background: #ffd758;
  text-shadow: none;
}
* {
  box-sizing: border-box;
}
.font {
  font-family: 'Roboto', sans-serif;
}
.text-left {
  text-align: left !important;
}
.text-right {
  text-align: right !important;
}
h3,
h4,
h5,
h6 {
  font-weight: normal;
}
.d-flex:after {
  content: '';
  display: table;
  width: 100%;
  height: 100%;
}
.d-flex > * {
  float: left;
}
.col-30 {
  width: 33.33% !important;
  padding: 10px 0 0;
}
.col-40 {
  width: 40% !important;
}
.col-50 {
  width: 50% !important;
}
.col-60 {
  width: 60% !important;
}
.col-12 {
  width: 100% !important;
}
.mt-130 {
  margin-top: 139px !important;
}
.text-center {
  text-align: center;
}
.my-20 {
  margin: 20px 0;
}
page {
  position: relative;
  display: block;
  overflow: hidden;
  box-shadow: 0 0 10px rgb(0 0 0 / 10%);
  padding: 45px 50px;
  width: 816px;
  height: 1056px;
  margin: 0 auto;
}
.border-right {
  border-right: 2px dotted rgba(168,169,173,0.70);
}
.border-bottom {
  border-bottom: 2px dotted rgba(168,169,173,0.70);
}
.number {
  font-weight: 900;
  font-size: 36px;
}
.green_number {
  color: #00ff5b;
}
.purple_number {
  color: #aa79d9;
}
.equa_number {
  color: #0ff2db;
}
.red_number {
  color: #f23e16;
}
.blue_number {
  color: #4a849f;
}
.yellow_number {
  color: #fbb416;
}
/* footer */
.footer {
  padding: 0 30px 20px;
  color: #14425d;
}
.logo img {
  width: 120px;
  height: auto;
}
.logo {
  width: 30%;
}
.horizontal_sign.signature {
  width: 500px;
  text-align: left;
  position: relative;
}
.horizontal_sign.signature > * {
  float: left;
}
.horizontal_sign > img {
  margin-right: 12px;
  margin-top: 0;
}
.signature + .logo {
  width: auto;
  flex: initial;
  position: absolute;
  right: 55px;
  text-align: right;
  color: #d35400;
  font-weight: 500;
  font-size: 18px;
  margin-top: 50px;
}
.signature + .logo a {
  color: #808285;
}
.profile_img {
  width: 130px;
  border-radius: 50%;
  height: 130px;
  object-fit: cover;
  object-position: top;
}
.profile_name {
  font-size: 28px;
  margin: 20px 0 0;
  font-weight: 700;
  line-height: 28px;
}
.profile_title {
  font-size: 17px;
  color: #d35400;
}
.tel_number {
  display: block;
  color: #14425d;
  text-decoration: none;
  font-size: 15px;
  line-height: 20px;
  font-weight: 700;
}
/* Market Update */
.sales_activity {
  padding: 0;
}
.sales_activity_hero {
  background: linear-gradient(
      to right,
      rgba(17,78,107,0.60),
      rgba(17,78,107,0.60)
    ),
    url(/assets/media/reports/Santa-Barbara-USA-taken-in-2015.jpg);
  background: -webkit-gradient( linear, left top, right top, from(rgba(17,78,107,0.60)), to(rgba(17,78,107,0.60)) ), url(/assets/media/reports/Santa-Barbara-USA-taken-in-2015.jpg);
  background-size: cover;
  color: #fff;
  padding: 30px 30px 25px;
  background-position: center;
}
.sales_activity_hero h1 {
  font-size: 38px;
  font-weight: 300;
  margin: 5px 0;
}
.orange_line {
  width: 50px;
  height: 8px;
  background: #d35400;
}
.sales_activity_hero h2 {
  font-size: 30px;
  font-weight: 900;
  margin: 5px 0;
}
.img-fluid {
  max-width: 100%;
}
.media {
  display: -webkit-box;
  display: flex;
  margin-top: 40px;
}
.media img {
  width: 50px;
  margin-right: 5px;
}
.media-body {
  font-size: 30px;
  font-weight: 300;
  line-height: 15px;
}
.media-body span {
  font-size: 13px;
  letter-spacing: 10px;
}
h4.table_title {
  color: #a8a9ad;
  font-weight: 700;
  font-size: 20px;
  margin: 0 0 15px;
}
h4.table_title span {
  font-weight: 400;
  font-size: 16px;
}
.market_update_table {
  padding: 30px;
}
.market_update_table table {
  width: 100%;
  border-collapse: collapse;
}
tr:nth-of-type(odd) {
  background-color: #e6e7e8;
}
.market_update_table table th {
  text-align: center;
  padding: 10px 0;
  color: #808285;
  font-weight: 700;
  vertical-align: middle;
  font-family: 'Roboto', sans-serif;
}
.market_update_table table td {
  font-size: 14px;
  color: #808285;
  vertical-align: middle;
  text-align: center;
  padding: 6px 0;
  font-family: 'Roboto', sans-serif;
  border-right: 2px dotted rgba(168,169,173,0.70);
}
.market_update_table table td:last-child {
  border: 0;
}

    </style>
    <page class="sales_activity">
            <div class="sales_activity_hero">
                <div class="d-flex">
                    <div class="col-60">
                        <h1>FARM AREA ANALYSIS</h1>
                        <div class="orange_line"></div>
                        <h2>EDDM CARRIER ROUTES</h2>
                    </div>
                    <div class="col-40">
                        <div class="media">
                            
                            <div class="media-body">
                                PACIFIC COAST
                                <span>TITLE COMPANY</span>
                            </div>                        
                        </div>
                    </div>
                </div>
            </div>



            <div class="market_update_table">
                <h4 class="table_title">AREA: | <span>SANTA MONICA, CA</span></h4>
                <div class="d-flex text-center my-20">
                    <div class="col-30 border-right border-bottom">
                        <span class="number green_number">13%</span>
                        <h4 class="table_title"><span>ROUTE: C024 <br>HIGHEST TURNOVER RATIO</span></h4>
                    </div>
                    <div class="col-30  border-right border-bottom">
                        <span class="number purple_number">12%</span>
                        <h4 class="table_title"><span>ROUTE: C024 <br>HIGHEST NON-OWNER</span></h4>
                    </div>
                    <div class="col-30  border-bottom">
                        <span class="number equa_number">15</span>
                        <h4 class="table_title"><span>ROUTE: C024 <br>LONG AVG YR OWNED</span></h4>
                    </div>
                    <div class="col-30  border-right">
                        <span class="number red_number">207</span>
                        <h4 class="table_title"><span>ROUTE: C024 <br>MOST UNITS</span></h4>
                    </div>
                    <div class="col-30  border-right">
                        <span class="number blue_number">18</span>
                        <h4 class="table_title"><span>ROUTE: C024 <br>MOST SALES</span></h4>
                    </div> 
                    <div class="col-30">
                        <span class="number yellow_number">540K</span>
                        <h4 class="table_title"><span>ROUTE: C024 <br>AVG. SALES PRICE ALL</span></h4>
                    </div>
                </div>
                 
                <h4 class="table_title">TOP 10 CARRIER ROUTES | <span>BY TURN-OVER %</span></h4>
                <table>
                    <tr>
                        <th>Route</th>
                        <th>Avg. Price</th>
                        <th>#Of Sales</th>
                        <th>NOO %</th>
                        <th>AVG YR</th>
                        <th># of Units</th>
                        <th>Zipcode</th>
                    </tr>
                    <?php
                    foreach ($records as $key => $record) { ?>
                        <tr>
                            <td><?php echo $record['carrier_route'] ?></td>
                            <td>$<?php echo number_format($record['avg_price'])  ?></td>
                            <td><?php echo $record['total_sales'] ?></td>
                            <td><?php echo $record['NOO_ratio'] ?></td>
                            <td><?php echo $record['avg_yr_owned'] ?></td>
                            <td><?php echo $record['total_units'] ?></td>
                            <td><?php echo $record['sa_site_zip'] ?></td>
                        </tr>
                        
                    <?php 
                    }
                    ?>
                </table>
            </div>


            <div class="footer">
                <div class="d-flex">
                    <div class="signature horizontal_sign">
                    <?php
                    $image_url = trim(env('AWS_PATH').$salesRep['sales_rep_report_image']);
                    if (!empty($salesRep['sales_rep_report_image']) && checkRemoteFile($image_url)):
                    ?>
                    <img src="<?php echo $image_url;?>" alt="Profile-Pic" class="profile_img"/>
                    <?php endif; ?>

                            
                        <div>
                            <div class="profile_name"><?php echo $salesRep['first_name'].' '.$salesRep['last_name']; ?></div>
                            
                            <a class="tel_number" href="tel:<?php echo $salesRep['telephone_no'];?>"><?php echo $salesRep['telephone_no'];?></a>
                            <a href="mailto:<?php echo $salesRep['email_address'];?>" class="tel_number"><?php echo $salesRep['email_address'];?></a>
                        </div>
                    </div>
                    <div class="logo">
                        CUSTOMER SERVICE<br>
                        <a href="tel:(866) 724-1050">(866) 724-1050</a> | <a href="mailto:cs@pct.com">cs@pct.com</a>
                    </div>
                </div>
            </div>
    </page>
</body>
</html>
