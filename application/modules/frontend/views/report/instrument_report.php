<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Site details -->
    <meta charset="utf-8"> <!-- utf-8 works for most cases -->
    <meta name="viewport" content="width=device-width"> <!-- Forcing initial-scale shouldn't be necessary -->
    <meta http-equiv="X-UA-Compatible" content="IE=edge"> <!-- Use the latest (edge) version of IE rendering engine -->
    <meta name="x-apple-disable-message-reformatting"> <!-- Disable auto-scale in iOS 10 Mail entirely -->
    <title>PCT</title>
    <!-- <link rel="icon" type="image/x-icon" href="assets/images/fevicon.png"> -->
    <link href="fonts/fonts.css" rel="stylesheet">
    <style>
       body{
        font-family: 'Calibri';
        padding: 0px;
  margin: 0px;
       }
        @media print {
            @page {
                size: 8.5in 11in;
                margin: 0;
            }
        }

        table {
            width: 100%;
            margin-bottom: 0;
        }
        table td{
            vertical-align:top
        }

       
    </style>
</head>

<body class="background-color:#fff">

    <?php //echo "<pre>"; print_r($orderDetails['file_number']);die; ?>
    <!-- 1st page -->
    <table cellpadding="0" cellspacing="0" border="0" style="margin: 0 auto;max-width:1000px;height:100vh;background-image: url('<?php echo base_url("assets/frontend/images/bg.jpg") ?>');background-position: center; background-repeat: no-repeat;background-size: cover;">
        <tbody>
            <tr>
                <td style="padding-left: 70px; vertical-align: middle;">
                    <div style="height: 700px; display: flex;align-items: start;flex-direction: column;justify-content: center;">
                        <span style="font-size: 80px;color: #d35627; font-weight: 400;font-family: 'LushScript';"><i>Concierge</i></span>
                        <span style="font-size: 40px;color: #FFF;text-transform: uppercase;font-weight: 800;font-family: 'Montserrat';">LISTING PRELIM</span>
                        <span style="font-size: 25px;color: #d35627; font-weight:bold;text-transform: uppercase;font-family: 'Montserrat';">Report</span>
                        <span style="font-size: 25px;color: #fff; font-weight:400;text-transform: uppercase;font-family: 'Montserrat';"><?php echo $orderDetails['full_address'] ?></span>
                    </div>
                </td>
            </tr>
            <tr>
                <td>
                    <table cellpadding="0" cellspacing="0" border="0">
                        <tbody>
                            <tr>
                                <td style="height: 70px;"></td>
                            </tr>
                            <tr>
                                <td style="font-size: 22px; font-weight: 500;color: #fff;text-transform: uppercase;padding-left: 70px;font-family: 'Montserrat';">
                                    Prepared For: <br/><span style="font-size: 18px;font-weight: 300;"><?php echo $orderDetails['cust_first_name'] . ' ' . $orderDetails['cust_last_name'] ?></span>
                                </td>
                                <td align="right" style="padding-right: 70px;">
                                    <img src="<?php echo base_url('assets/frontend/images/pacific.png') ?>" style="width: 250px;" alt="pacific"/>
                                </td>
                            </tr>
                            <tr>
                                <td style="height: 70px;"></td>
                            </tr>
                        </tbody>
                    </table>
                </td>
            </tr>
        </tbody>        
    </table>
    <!-- 1st page -->

    <div class="page-break" style="page-break-after: always;"></div>

    <!-- 2st page -->
    <table cellpadding="0" cellspacing="0" border="0">
        <tr>
            <td style="padding: 20px;">
                <table cellpadding="0" cellspacing="0" border="0" style="margin: 0 auto;max-width:1000px">
                    <tbody>
                        <tr>
                            <td style="height:50px"></td>
                        </tr>
                        <tr>
                            <td style="font-size: 30px; font-weight: 300;letter-spacing: 1px;">
                                Congratulations
                            </td>
                        </tr>
                        <tr>
                            <td style="height: 15px;"></td>
                        </tr>
                        <tr>
                            <td>
                                <span style="width: 95px;border-bottom:5px solid #d35627;display: block;"></span>
                            </td>
                        </tr>
                        <tr>
                            <td style="height: 15px;"></td>
                        </tr>
                        <tr>
                            <td style="font-size: 22px; font-weight: 300;">
                                On your journey to selling
                            </td>
                        </tr>
                        <tr>
                            <td style="height: 20px;"></td>
                        </tr>
                        <tr>
                            <td style="font-size: 17px;; font-weight: 400;line-height: 25px;">
                                The purchase of a home is often the largest single financial investment many people may make in
                                their lifetime. The importance of fully protecting such an investment cannot be overly stressed. A
                                basic home ownership protection essential to the security of the home is safe, sound, reliable
                                title insurance.
                            </td>
                        </tr>
                        <tr>
                            <td style="height: 20px;"></td>
                        </tr>
                        <td style="font-size: 18px; font-weight: 400;line-height: 30px;">
                            Sincerely,
                        </td>
                        <tr>
                            <td style="font-size: 50px; font-weight: 400; color: #276fa8;font-family: 'LushScript';;font-style: italic;">
                                <?php echo $orderDetails['titleofficer_first_name'] . ' ' . $orderDetails['titleofficer_last_name']; ?>
                            </td>
                        </tr>
                        <tr>
                            <td style="height: 50px;"></td>
                        </tr>
                        <tr>
                            <td style="font-size: 30px; font-weight: 300;letter-spacing: 1px;">
                                About This Report
                            </td>
                        </tr>
                        <tr>
                            <td style="height: 15px;"></td>
                        </tr>
                        <tr>
                            <td>
                                <span style="width: 95px;border-bottom:5px solid #d35627;display: block;"></span>
                            </td>
                        </tr>
                        <tr>
                            <td style="height: 15px;"></td>
                        </tr>
                        <tr>
                            <td style="font-size: 22px; font-weight: 300;">
                                And its contents
                            </td>
                        </tr>
                        <tr>
                            <td style="height: 20px;"></td>
                        </tr>
                        <tr>
                            <td style="font-size: 17px;; font-weight: 400;line-height: 25px;">
                                The information is available through public sources as of <span
                                    style="color:#d35627; font-weight:600">02/28/2023</span>. Information provided by the
                                vendor and public records may not always match exactly depending on how often the information is
                                updated by each source. The items presented or those found that are directly tied to the property in
                                question. Items that are directly associated with the owner will require a statement of
                                information form to be fill out in order for us to conduct a more
                                thorough search. This docment is not a preliminary title report.
                            </td>
                        </tr>
                        <tr>
                            <td style="height: 50px;"></td>
                        </tr>
                        <tr>
                            <td style="border-top: 2px solid #231f20;">
                                <table>
                                    <tbody>
                                        <tr>
                                            <td style="font-size: 18px; font-weight: 400;line-height: 30px;">Listing Prelim Report</td>
                                            <td style="font-size: 18px; font-weight: 400;line-height: 30px;" align="right">Welcome</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </td>
        </tr>
    </table>

    <!-- 2st page -->
    
    <div class="page-break" style="page-break-after: always;"></div>
    
    <!-- 3st page -->
    
    <table cellpadding="0" cellspacing="0" border="0">
        <tr>
            <td style="padding: 20px;">
                <table cellpadding="0" cellspacing="0" border="0" style="margin: 0 auto;max-width:1000px;">
                    <tbody>
                        <tr>
                            <td>
                                <table>
                                    <tbody>
                                        <tr>
                                            <td>
                                                <img src="<?php echo base_url('assets/frontend/images/pacific.png') ?>" style="width: 250px;"
                                                    alt="pacificcoasttitle" />
                                            </td>
                                            <td align="right" style="font-size: 18px; font-weight: 400;line-height: 20px;">
                                                Pacific Coast Title Company<br />
                                                1111 E. Katella Ave Ste. 120<br />
                                                Orange, CA 92867
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </td>
                        </tr>
                        <tr>
                            <td style="height:20px"></td>
                        </tr>
                        <tr>
                            <td align="center" style="font-size: 18px; font-weight: 600;line-height: 30px;">Listing Prelim Report
                            </td>
                        </tr>
                        <tr>
                            <td style="border-top: 2px solid #231f20;"></td>
                        </tr>
                        <tr>
                            <td>
                                <table cellpadding="0" cellspacing="0" border="0">
                                    <tbody>
                                        <tr>
                                            <td style="font-weight: 600;">
                                                Feb 2nd. 4:50pm<br />
                                                Escrow No: <?php echo $orderDetails['escrow_number']; ?>
                                            </td>
                                            <td align="right" style="font-weight: 600;">
                                                Title Order #: <?php echo $orderDetails['file_number']; ?><br />
                                                Title Officer: <?php echo $orderDetails['titleofficer_first_name'] . ' ' . $orderDetails['titleofficer_last_name']; ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="2" style="height:20px"></td>
                                        </tr>
                                        <tr>
                                            <td>
                                                Nations Equity<br />
                                                <?php echo $orderDetails['cust_first_name'] . ' ' . $orderDetails['cust_last_name'] ?><br />
                                                <?php echo $orderDetails['address']; ?><br />
                                                <?php echo $orderDetails['county']; ?>, <?php echo $orderDetails['property_state']; ?> <?php echo $orderDetails['property_zip']; ?>
                                            </td>
                                            <td align="right">
                                                Transaction: <?php echo ($orderDetails['transaction_type'] == 2) ? 'Loan' : 'Sale' ?><br />
                                                Price: $<?php echo ($orderDetails['transaction_type'] == 2) ? $orderDetails['loan_amount'] : $orderDetails['sale_amount']; ?>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </td>
                        </tr>
                        <tr>
                            <td style="height:20px"></td>
                        </tr>
                        <tr>
                            <td style="border-bottom: 2px solid #231f20;font-size: 18px; font-weight: 600;line-height: 30px;">
                                Subject Property: <?php echo $orderDetails['full_address']; ?>
                            </td>
                        </tr>
                        <tr>
                            <td style="height:20px"></td>
                        </tr>
                        <tr>
                            <td style="font-size: 18px; font-weight: 300;line-height: 25px;">
                                <table cellpadding="5px" cellspacing="0" border="1" bordercolor="#bbbcbf">
                                    <tbody>
                                        <tr>
                                            <td colspan="2" style="font-weight: 600;line-height: 30px;background-color: #f2f3f4;font-family: 'Montserrat';">
                                                <i>Section A:</i> Property
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Property Address</td>
                                            <td>
                                                <?php echo $orderDetails['full_address']; ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>APN</td>
                                            <td>
                                                <?php echo $orderDetails['apn']; ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>County</td>
                                            <td>
                                                <?php echo $orderDetails['county']; ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="2" style="padding-top: 15px;padding-bottom: 15px;">
                                                <?php echo $orderDetails['legal_description']; ?>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </td>
                        </tr>
                        <tr>
                            <td style="height:20px"></td>
                        </tr>
                        <tr>
                            <td style="font-size: 18px; font-weight: 300;line-height: 25px;">
                                <table cellpadding="5px" cellspacing="0" border="1"bordercolor="#bbbcbf">
                                    <tbody>
                                        <tr>
                                            <td colspan="4" style="font-weight: 600;line-height: 30px;background-color: #f2f3f4;font-family: 'Montserrat';">
                                                <i>Section B:</i> Beds, Baths, & Zoning
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Bedrooms</td>
                                            <td><?php echo $titlePointDetails[0]['property_bedroom']; ?></td>
                                            <td>Property Type:</td>
                                            <td><?php echo $orderDetails['transaction_type']; ?></td>
                                        </tr>
                                        <tr>
                                            <td>Bathrooms</td>
                                            <td><?php echo $titlePointDetails[0]['property_bathroom']; ?></td>
                                            <td>Zoning:</td>
                                            <td><?php echo $titlePointDetails[0]['property_zoning']; ?></td>
                                        </tr>
                                        <tr>
                                            <td>Square Feet</td>
                                            <td><?php echo $titlePointDetails[0]['property_squarefeet']; ?></td>
                                            <td>ADU:</td>
                                            <td>Eligible</td>
                                        </tr>
                                        <tr>
                                            <td>Lot Size</td>
                                            <td><?php echo $titlePointDetails[0]['property_lotsize']; ?></td>
                                            <td></td>
                                            <td></td>
                                        </tr>
                                        <tr>
                                            <td># of Units</td>
                                            <td>1</td>
                                            <td></td>
                                            <td></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </td>
                        </tr>
                        <tr>
                            <td style="height:50px"></td>
                        </tr>
                        <tr>
                            <td style="border-top: 2px solid #231f20;">
                                <table>
                                    <tbody>
                                        <tr>
                                            <td style="font-size: 18px; font-weight: 400;line-height: 30px;">Listing Prelim Report</td>
                                            <td style="font-size: 18px; font-weight: 400;line-height: 30px;" align="right">Page-1</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </td>
                        </tr>
                    </tbody>                    
                </table>
            </td>
        </tr>
    </table>
    
    <!-- 3st page -->

    <div class="page-break" style="page-break-after: always;"></div>

    <!-- 4th page -->
    <table cellpadding="0" cellspacing="0" border="0">
        <tr>
            <td style="padding: 20px;">
                <table cellpadding="0" cellspacing="0" border="0" style="margin: 0 auto;max-width:1000px;">
                    <tbody>
                        <tr>
                            <td>
                                <table>
                                    <tbody>
                                        <tr>
                                            <td>
                                                <img src="<?php echo base_url('assets/frontend/images/pacific.png') ?>" style="width: 250px;"
                                                    alt="pacificcoasttitle" />
                                            </td>
                                            <td align="right" style="font-size: 18px; font-weight: 400;line-height: 20px;">
                                                Title Order #:<?php echo $orderDetails['file_number']; ?><br />
                                                Title Officer: <?php echo $orderDetails['titleofficer_first_name'] . ' ' . $orderDetails['titleofficer_last_name']; ?><br />
                                                <?php echo $orderDetails['titleofficer_first_name'] . ' ' . $orderDetails['titleofficer_last_name']; ?>
                                                Feb 2nd. 4:50pm<br/>
                                                Escrow No: <?php echo $orderDetails['escrow_number']; ?>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </td>
                        </tr>
                        <tr>
                            <td style="height:10px"></td>
                        </tr>
                        <tr>
                            <td style="font-size: 18px; font-weight: 300;line-height: 25px;">
                                <table cellpadding="5px" cellspacing="0" border="1"bordercolor="#bbbcbf">
                                    <tbody>
                                        <tr>
                                            <td colspan="2" style="font-weight: 600;line-height: 30px;background-color: #f2f3f4;font-family: 'Montserrat';">
                                                <i>Section C:</i> Owners
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Primary</td>
                                            <td><?php echo $orderDetails['primary_owner'] ?></td>
                                        </tr>
                                        <tr>
                                            <td>Mailing Address:</td>
                                            <td></td>
                                        </tr>
                                        <tr>
                                            <td>Secondary</td>
                                            <td><?php echo $orderDetails['secondary_owner'] ?></td>
                                        </tr>
                                        <tr>
                                            <td>Mailing Address</td>
                                            <td></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </td>
                        </tr>
                        <tr>
                            <td style="height: 20px;"></td>
                        </tr>
                        <?php  
                            $firstInstallment = json_decode($titlePointDetails[0]['first_installment'], true);
                            $secondInstallment = json_decode($titlePointDetails[0]['second_installment'], true);
                        ?>
                        <tr>
                            <td style="font-size: 18px; font-weight: 300;line-height: 25px;">
                                <table cellpadding="0" cellspacing="0" border="1" bordercolor="#bbbcbf">
                                    <tbody>
                                        <tr>
                                            <td colspan="2" style="font-weight: 600;line-height: 30px;background-color: #f2f3f4;font-family: 'Montserrat';padding: 5px;">
                                                <i>Section D:</i> Property Taxes
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <table cellpadding="3px" cellspacing="0">
                                                    <tbody>
                                                        <tr>
                                                            <td colspan="2" style="font-weight:600;border-bottom: 2px solid #bbbcbf;" align="center">
                                                                1st Installment
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td style="border-bottom: 2px solid #bbbcbf;border-right: 2px solid #bbbcbf;">Balance:</td>
                                                            <td style="border-bottom: 2px solid #bbbcbf;">$<?php echo $firstInstallment['Balance']; ?></td>
                                                        </tr>
                                                        <tr>
                                                            <td style="border-bottom: 2px solid #bbbcbf;border-right: 2px solid #bbbcbf;">Amount:</td>
                                                            <td style="border-bottom: 2px solid #bbbcbf;">$<?php echo $firstInstallment['Amount']; ?></td>
                                                        </tr>
                                                        <tr>
                                                            <td style="border-bottom: 2px solid #bbbcbf;border-right: 2px solid #bbbcbf;">Due Date:</td>
                                                            <td style="border-bottom: 2px solid #bbbcbf;"><?php echo $firstInstallment['DueDate']; ?></td>
                                                        </tr>
                                                        <tr>
                                                            <td style="border-bottom: 2px solid #bbbcbf;border-right: 2px solid #bbbcbf;">Number:</td>
                                                            <td style="border-bottom: 2px solid #bbbcbf;"><?php echo $firstInstallment['Number']; ?></td>
                                                        </tr>
                                                        <tr>
                                                            <td style="border-bottom: 2px solid #bbbcbf;border-right: 2px solid #bbbcbf;">Penalty Date:</td>
                                                            <td style="border-bottom: 2px solid #bbbcbf;"><?php //echo $firstInstallment['PaymentDate']; ?></td>
                                                        </tr>
                                                        <tr>
                                                            <td style="border-bottom: 2px solid #bbbcbf;border-right: 2px solid #bbbcbf;">Penalty Amount</td>
                                                            <td style="border-bottom: 2px solid #bbbcbf;">$<?php echo $firstInstallment['Penalty']; ?></td>
                                                        </tr>
                                                        <tr>
                                                            <td style="border-bottom: 2px solid #bbbcbf;border-right: 2px solid #bbbcbf;">Status:</td>
                                                            <td style="border-bottom: 2px solid #bbbcbf;"><?php echo $firstInstallment['Status']; ?></td>
                                                        </tr>
                                                        <tr>
                                                            <td style="border-bottom: 2px solid #bbbcbf;border-right: 2px solid #bbbcbf;">Amount Paid: </td>
                                                            <td style="border-bottom: 2px solid #bbbcbf;">$<?php echo $firstInstallment['AmountPaid']; ?></td>
                                                        </tr>
                                                        <tr>
                                                            <td style="border-right: 2px solid #bbbcbf;">Tax Year</td>
                                                            <td><?php echo $firstInstallment['TaxYear']; ?></td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </td>
                                            <td>
                                                <table cellpadding="3px" cellspacing="0">
                                                    <tbody>
                                                        <tr>
                                                            <td colspan="2" style="font-weight:600;border-bottom: 2px solid #bbbcbf;" align="center">
                                                                2nd Installment
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td style="border-bottom: 2px solid #bbbcbf;border-right: 2px solid #bbbcbf;">Balance:</td>
                                                            <td style="border-bottom: 2px solid #bbbcbf;">$<?php echo $secondInstallment['Balance']; ?></td>
                                                        </tr>
                                                        <tr>
                                                            <td style="border-bottom: 2px solid #bbbcbf;border-right: 2px solid #bbbcbf;">Amount:</td>
                                                            <td style="border-bottom: 2px solid #bbbcbf;">$<?php echo $secondInstallment['Amount']; ?></td>
                                                        </tr>
                                                        <tr>
                                                            <td style="border-bottom: 2px solid #bbbcbf;border-right: 2px solid #bbbcbf;">Due Date:</td>
                                                            <td style="border-bottom: 2px solid #bbbcbf;"><?php echo $secondInstallment['DueDate']; ?></td>
                                                        </tr>
                                                        <tr>
                                                            <td style="border-bottom: 2px solid #bbbcbf;border-right: 2px solid #bbbcbf;">Number:</td>
                                                            <td style="border-bottom: 2px solid #bbbcbf;"><?php echo $secondInstallment['Number']; ?></td>
                                                        </tr>
                                                        <tr>
                                                            <td style="border-bottom: 2px solid #bbbcbf;border-right: 2px solid #bbbcbf;">Penalty Date:</td>
                                                            <td style="border-bottom: 2px solid #bbbcbf;"><?php //echo $secondInstallment['PaymentDate']; ?></td>
                                                        </tr>
                                                        <tr>
                                                            <td style="border-bottom: 2px solid #bbbcbf;border-right: 2px solid #bbbcbf;">Penalty Amount</td>
                                                            <td style="border-bottom: 2px solid #bbbcbf;">$<?php echo $secondInstallment['Penalty']; ?></td>
                                                        </tr>
                                                        <tr>
                                                            <td style="border-bottom: 2px solid #bbbcbf;border-right: 2px solid #bbbcbf;">Status:</td>
                                                            <td style="border-bottom: 2px solid #bbbcbf;"><?php echo $secondInstallment['Status']; ?></td>
                                                        </tr>
                                                        <tr>
                                                            <td style="border-bottom: 2px solid #bbbcbf;border-right: 2px solid #bbbcbf;">Amount Paid: </td>
                                                            <td style="border-bottom: 2px solid #bbbcbf;"><?php echo $secondInstallment['AmountPaid']; ?></td>
                                                        </tr>
                                                        <tr>
                                                            <td style="border-right: 2px solid #bbbcbf;">Tax Year</td>
                                                            <td><?php echo $secondInstallment['TaxYear']; ?></td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </td>
                        </tr>
                        <tr>
                            <td style="height: 20px;"></td>
                        </tr>
                        <tr>
                            <td style="font-size: 18px; font-weight: 300;line-height: 25px;">
                                <table cellpadding="5px" cellspacing="0" border="0">
                                    <tr>
                                        <td style="font-weight: 600;line-height: 30px;background-color: #f2f3f4;font-family: 'Montserrat';padding: 5px;">
                                            <i>Section E:</i> Property Taxes
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>The land referred to herein below is situated in the city of <?php echo $orderDetails['property_city']; ?>, county of <?php echo $orderDetails['county']; ?>,
                                            state of <?php echo $orderDetails['property_state']; ?>, and is described as follows: lot 1 of tract no. 13005, in the city of <?php echo $orderDetails['property_city']; ?>,
                                            county of <?php echo $orderDetails['county']; ?>, state of <?php echo $orderDetails['property_state']; ?>, as per map recorded in book 259, pages 7 through 10
                                            inclusive of maps in the office of the county recorder of said county</td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                        <tr>
                            <td style="height: 10px;"></td>
                        </tr>
                        <tr>
                            <td style="font-size: 18px; font-weight: 300;line-height: 25px;">
                                <table cellpadding="5px" cellspacing="0" border="0">
                                    <tr>
                                        <td style="font-weight: 600;line-height: 30px;background-color: #f2f3f4;font-family: 'Montserrat';padding: 5px;">
                                            <i>Section F:</i> Property Vesting:
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><?php echo $orderDetails['legal_description']; ?></td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                       
                        <tr>
                            <td style="border-top: 2px solid #231f20;">
                                <table>
                                    <tbody>
                                        <tr>
                                            <td style="font-size: 18px; font-weight: 400;line-height: 30px;">Listing Prelim Report</td>
                                            <td style="font-size: 18px; font-weight: 400;line-height: 30px;" align="right">Page-2</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </td>
        </tr>
    </table>
    <!-- 4th page -->

    <div class="page-break" style="page-break-after: always;"></div>

    <!-- 5th page -->
    <table cellpadding="0" cellspacing="0" border="0">
        <tr>
            <td style="padding: 20px;">
                <table cellpadding="0" cellspacing="0" border="0" style="margin: 0 auto;max-width:1000px;">
                    <tbody>
                        <tr>
                            <td>
                                <table>
                                    <tbody>
                                        <tr>
                                            <td>
                                                <img src="<?php echo base_url('assets/frontend/images/pacific.png') ?>" style="width: 250px;"
                                                    alt="pacificcoasttitle" />
                                            </td>
                                            <td align="right" style="font-size: 18px; font-weight: 400;line-height: 20px;">
                                                Title Order #: <?php echo $orderDetails['file_number'] ?><br />
                                                Title Officer: <?php echo $orderDetails['titleofficer_first_name'] . ' ' . $orderDetails['titleofficer_last_name']; ?><br />
                                                <?php echo $orderDetails['titleofficer_first_name'] . ' ' . $orderDetails['titleofficer_last_name']; ?>
                                                Feb 2nd. 4:50pm<br/>
                                                Escrow No: <?php echo $orderDetails['escrow_number'] ?>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </td>
                        </tr>
                        <tr>
                            <td style="height:20px"></td>
                        </tr>
                        <!-- <tr>
                            <td style="font-size: 18px; font-weight: 300;line-height: 25px;">
                                <table cellpadding="5px" cellspacing="0" border="1" bordercolor="#bbbcbf">
                                    <tbody>
                                        <tr>
                                            <td colspan="5" style="font-weight: 600;line-height: 30px;background-color: #f2f3f4;font-family: 'Montserrat';">
                                                <i>Section G:</i> Open Loans:
                                            </td>
                                        </tr>
                                        <tr>
                                            <td></td>
                                            <td>Lender</td>
                                            <td>Amount</td>
                                            <td>Recorded</td>
                                            <td align="center">Instrument #</td>
                                        </tr>
                                        <tr>
                                            <td>1st</td>
                                            <td>Sterlings Bank</td>
                                            <td>$456,000</td>
                                            <td>04/31/2021</td>
                                            <td align="center" style="font-weight:600; color:#d35627">4645654654</td>
                                        </tr>
                                        <tr>
                                            <td>2nd</td>
                                            <td>Private Benny</td>
                                            <td>$75,000</td>
                                            <td>03/21/2022</td>
                                            <td align="center" style="font-weight:600; color:#d35627">21313156</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </td>
                        </tr> -->
                        <tr>
                            <td style="height:20px"></td>
                        </tr>
                        <?php if (!empty($titlePointInstrumentDetails)) { 
                                
                            ?>
                        <tr>
                            <td style="font-size: 18px; font-weight: 300;line-height: 25px;">
                                <table cellpadding="5px" cellspacing="0" border="1" bordercolor="#bbbcbf">
                                    <tbody>
                                        <tr>
                                            <td colspan="5" style="font-weight: 600;line-height: 30px;background-color: #f2f3f4;font-family: 'Montserrat';">
                                                <i>Section F:</i>  Liens & Items for Review
                                            </td>
                                        </tr>
                                        <tr>
                                            <td></td>
                                            <td>Document Name</td>
                                            <td>Amount</td>
                                            <td>Recorded</td>
                                            <td align="center">Instrument #</td>
                                        </tr>
                                        <?php  
                                            $i = 0; 
                                            foreach ($titlePointInstrumentDetails as $key => $val) {  ?>
                                        <tr>
                                            <td><?php echo $i + 1 . (($i == 0) ? 'st' : (($i == 1) ? 'nd' : (($i == 2) ? 'rd' : 'th'))); ?></td>
                                            <td><?php echo  $val['document_name']; ?></td>
                                            <td>$<?php echo  $val['amount']; ?></td>
                                            <td><?php echo  $val['recorded_date']; ?></td>
                                            <td align="center" style="font-weight:600; color:#d35627"><?php echo  $val['instrument']; ?></td>
                                        </tr>
                                        <?php $i++; } ?>
                                        <!-- <tr>
                                            <td>2nd</td>
                                            <td>Ficticious Doc #1</td>
                                            <td>$456,000</td>
                                            <td>04/31/2021</td>
                                            <td align="center" style="font-weight:600; color:#d35627">4645654654</td>
                                        </tr>
                                        <tr>
                                            <td>3rd</td>
                                            <td>Ficticious Doc #1</td>
                                            <td>N/A</td>
                                            <td>04/31/2021</td>
                                            <td align="center" style="font-weight:600; color:#d35627">4645654654</td>
                                        </tr>
                                        <tr>
                                            <td>4th</td>
                                            <td>Ficticious Doc #1</td>
                                            <td>N/A</td>
                                            <td>04/31/2021</td>
                                            <td align="center" style="font-weight:600; color:#d35627">4645654654</td>
                                        </tr>
                                        <tr>
                                            <td>5th</td>
                                            <td>Ficticious Doc #1</td>
                                            <td>N/A</td>
                                            <td>N/A</td>
                                            <td align="center" style="font-weight:600; color:#d35627">4645654654</td>
                                        </tr>
                                        <tr>
                                            <td>6th</td>
                                            <td>Ficticious Doc #1</td>
                                            <td>N/A</td>
                                            <td>N/A</td>
                                            <td align="center" style="font-weight:600; color:#d35627">4645654654</td>
                                        </tr>
                                        <tr>
                                            <td>7th</td>
                                            <td>Ficticious Doc #1</td>
                                            <td>N/A</td>
                                            <td>N/A</td>
                                            <td align="center" style="font-weight:600; color:#d35627">4645654654</td>
                                        </tr>
                                        <tr>
                                            <td>8th</td>
                                            <td>Ficticious Doc #1</td>
                                            <td>N/A</td>
                                            <td>N/A</td>
                                            <td align="center" style="font-weight:600; color:#d35627">4645654654</td>
                                        </tr>
                                        <tr>
                                            <td>9th</td>
                                            <td>Ficticious Doc #1</td>
                                            <td>N/A</td>
                                            <td>N/A</td>
                                            <td align="center" style="font-weight:600; color:#d35627">4645654654</td>
                                        </tr>
                                        <tr>
                                            <td>10th</td>
                                            <td>Ficticious Doc #1</td>
                                            <td>N/A</td>
                                            <td>N/A</td>
                                            <td align="center" style="font-weight:600; color:#d35627">4645654654</td>
                                        </tr> -->
                                        
                                    </tbody>
                                </table>
                            </td>
                        </tr>
                        <?php } ?>
                        <tr>
                            <td style="height:20px"></td>
                        </tr>
                        <!-- <tr>
                            <td style="font-size: 18px; font-weight: 300;line-height: 25px;">
                                <table cellpadding="5px" cellspacing="0" border="1" bordercolor="#bbbcbf">
                                    <tbody>
                                        <tr>
                                            <td colspan="5" style="font-weight: 600;line-height: 30px;background-color: #f2f3f4;font-family: 'Montserrat';">
                                                <i>Section G:</i> Foreclosure Activity
                                            </td>
                                        </tr>
                                        <tr>
                                            <td></td>
                                            <td>Lender</td>
                                            <td>Amount</td>
                                            <td>Recorded</td>
                                            <td align="center">Instrument #</td>
                                        </tr>
                                        <tr>
                                            <td>1st</td>
                                            <td>Notice Of Default</td>
                                            <td>$456,000</td>
                                            <td>04/31/2021</td>
                                            <td align="center" style="font-weight:600; color:#d35627">4645654654</td>
                                        </tr>
                                        <tr>
                                            <td>2nd</td>
                                            <td>Private Benny</td>
                                            <td>$75,000</td>
                                            <td>03/21/2022</td>
                                            <td align="center" style="font-weight:600; color:#d35627">21313156</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </td>
                        </tr> -->
                        <tr>
                            <td style="height:20px"></td>
                        </tr>
                        <tr>
                            <td style="border-top: 2px solid #231f20;">
                                <table>
                                    <tbody>
                                        <tr>
                                            <td style="font-size: 18px; font-weight: 400;line-height: 30px;">Listing Prelim Report</td>
                                            <td style="font-size: 18px; font-weight: 400;line-height: 30px;" align="right">Page-3</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </td>
        </tr>
    </table>
    <!-- 5th page -->

    <div class="page-break" style="page-break-after: always;"></div>

    <!-- 6th page -->
    <table cellpadding="0" cellspacing="0" border="0">
        <tr>
            <td style="padding: 20px;">
                <table cellpadding="0" cellspacing="0" border="0" style="margin: 0 auto;max-width:1000px;">
                    <tbody>
                        <tr>
                            <td>
                                <table>
                                    <tbody>
                                        <tr>
                                            <td>
                                                <img src="<?php echo base_url('assets/frontend/images/pacific.png') ?>" style="width: 250px;"
                                                    alt="pacificcoasttitle" />
                                            </td>
                                            <td align="right" style="font-size: 18px; font-weight: 400;line-height: 20px;">
                                                Title Order #: <?php echo $orderDetails['file_number']; ?><br />
                                                Title Officer: <?php echo $orderDetails['titleofficer_first_name'] . ' ' . $orderDetails['titleofficer_last_name']; ?><br />
                                                <?php echo $orderDetails['titleofficer_first_name'] . ' ' . $orderDetails['titleofficer_last_name']; ?>
                                                Feb 2nd. 4:50pm<br/>
                                                Escrow No: <?php echo $orderDetails['escrow_number']; ?>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </td>
                        </tr>
                        <tr>
                            <td style="height: 20px;"></td>
                        </tr>
                        <tr>
                            <td style="font-size: 18px; font-weight: 300;line-height: 25px;">
                                <table cellpadding="5px" cellspacing="0" border="0" bordercolor="#bbbcbf">
                                    <tbody>
                                        <tr>
                                            <td style="font-weight: 600;line-height: 30px;background-color: #f2f3f4;font-family: 'Montserrat';">
                                                <i>Section G:</i> Foreclosure Activity
                                            </td>
                                        </tr>
                                        <tr>
                                            <td style="height: 20px;"></td>
                                        </tr>
                                        <tr>
                                            <td align="center">
                                                <img src="diagram.png" alt="diagram" style="width: 80%;"/>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td style="height: 20px;"></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </td>
                        </tr>
                        <tr>
                            <td style="border-top: 2px solid #231f20;">
                                <table>
                                    <tbody>
                                        <tr>
                                            <td style="font-size: 18px; font-weight: 400;line-height: 30px;">Listing Prelim Report</td>
                                            <td style="font-size: 18px; font-weight: 400;line-height: 30px;" align="right">Page-4</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </td>
                        </tr>
                    </tbody>
                </table> 
            </td>
        </tr>
    </table>
    <!-- 6th page -->

    <div class="page-break" style="page-break-after: always;"></div>

    <!-- 7th page -->
    <table>
        <tr>
            <td style="padding: 20px;">
                <table cellpadding="0" cellspacing="0" border="0">
                    <tr>
                        <td style="padding: 20px;">
                            <table cellpadding="0" cellspacing="0" border="0" style="margin: 0 auto;max-width:1000px;">
                                <tbody>
                                    <tr>
                                        <td align="center" style="height:800px;vertical-align: middle;">
                                            <img src="<?php echo base_url('assets/frontend/images/pacific.png') ?>" alt="pacific" style="max-width:500px;width:100%"/>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </td>
                    </tr>
                    <tr>
                        <td style="border-top: 2px solid #231f20;">
                            <table>
                                <tbody>
                                    <tr>
                                        <td style="font-size: 18px; font-weight: 400;line-height: 30px;">Listing Prelim Report</td>
                                        <td style="font-size: 18px; font-weight: 400;line-height: 30px;" align="right">©2023 All Rights Reserved.</td>
                                    </tr>
                                </tbody>
                            </table>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
    
    <!-- 7th page -->
    
</body>

</html>