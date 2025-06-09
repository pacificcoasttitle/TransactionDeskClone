<html>
<head>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="<?php echo base_url(); ?>assets/frontend/fonts/fontawesome/fonts.css"  rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Lato:ital,wght@0,300;0,400;0,700;0,900;1,700&family=Montserrat:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,600&display=swap" rel="stylesheet">
    
    <style>
        body{
            font-family: 'Montserrat', sans-serif;
            margin: 0;
            padding: 0;
        }
        *{
            box-sizing: border-box;
        }
        /* .size_a4 { width: 8.3in; height: 11.7in; } */
        .size_letter { width: 11.5in; height: 14in; }
        .pdf_page {
            margin: 0 auto;
            box-sizing: border-box;
            background-color: #fff;
            color: #333;
            position: relative;
            font-family: 'Lato', sans-serif;
        }
        .pdf_header {
            position: absolute;
            top: 0;
            height: .8in;
            left: 0;
            right: 0;
        }
        .pdf_footer {
            position: absolute;
            bottom: 0;
            height: .5in;
            left: 0;
            right: 0;
            padding-top: 10px;
            border-top: 4px solid #333;
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
            top: 1in;
            bottom: 1.2in;
            left: 0;
            right: 0;
        }
        .logo_container{
            float: left;
        }
        .logo_container img{
            width: 240px;
        }
        .header_address {
            float: right;
            text-align: right; 
            color: #121212;
        }
        .main_title{
            font-size: 40px;
        }
        .listing_report{
            text-align: center;
            border-bottom: 2px solid;
            padding-bottom: 8px;
            margin-bottom: 8px;
        }
        .report_info {
            font-size: 16px;
            font-weight: 700;
            line-height: 20px;
        }
        .float_left{
            float: left;
        }
        .float_right{
            float: right;
        }
        .clearfix{
            clear: both;
        }
        .mb-80{
            margin-bottom: 80px;
        }
        
        .table_title {
            font-weight: 900;
            background-color: #f2f3f4;
            border: 1px solid #e8e9ea;
            padding: 5px 8px;
            font-size: 18px;
            margin-top: 40px;
        }
        .table{
            border: 1px solid #e8e9ea;
            border-top:0;
            width: 100%;
            border-collapse: collapse;
        }
        .table td{
            padding: 5px 8px;
        }
        .table td:not(:last-child){
            border-right: 1px solid #c2d1d7;
        }
        .table tr:not(:last-child) td {
            border-bottom: 1px solid #c2d1d7;
        }
        .table_a td:first-child {
            width: 80%;
        }
    </style>
</head>
<body>
    
    <div class="page_container">
        <div style="height:50px"></div>
        <div class="pdf_page size_letter">
            <div class="pdf_header">
                <div class="logo_container">
                    <img src="<?php echo base_url('assets/frontend/images/pacific.png') ?>" alt="">
                </div>
                <div class="header_address">
                    Pacific Coast Title - Fee Estimate
                </div>
            </div>
            <div class="pdf_body">
                <div class="listing_report"><b>Fee Estimate</b></div>
                <div class="report_info">
                    <div class="float_left">
                        Order Number #:<?php echo isset($order_number) && !empty($order_number) ? $order_number : '-'; ?><br>
                        Property Location: <?php echo isset($full_address) && !empty($full_address) ?$full_address : '-'; ?>
                    </div>
                    <div class="float_right text_right">
                        Transaction Type #:<?php echo isset($transactionType) && !empty($transactionType) ? $transactionType : '-'; ?><br>
                        Loan Amount: <?php echo (isset($loan_amount) && !empty($loan_amount)) ? "$".number_format($loan_amount, 2) : '-'; ?><br>
                        Sales Amount: <?php echo (isset($sales_amount) && !empty($sales_amount)) ? "$".number_format($sales_amount, 2) : '-'; ?>
                    </div>
                </div>
                <div class="clearfix"></div>
                
                <div class="mb-80"></div>
                <div class="table_title"><em>Fees changes:</em></div>
                <table class="table_a table">
                    <?php if (!empty($calcResult)) { 
                        foreach($calcResult as $fee)  { ?>
                            <tr>
                                <td><?php echo $fee['Description'];?></td>
                                <td class="aright">
                                    <?php echo $fee['Amount']; ?>
                                </td>
                            </tr>
                        <?php } ?>
                        <tr>
                            <td><b>Total</b></td>
                            <td class="aright">
                                <b><?php echo "$".number_format($totalAmount , 2); ?></b>
                            </td>
                        </tr>
                    <?php } ?>
                </table>
                
            </div>           
            <div class="pdf_footer">
                <p class="page_title">Fees estimation report</p>
                <p class="page_text">1</p>
            </div>
        </div>
    </div>
</body>