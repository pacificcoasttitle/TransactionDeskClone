
<!DOCTYPE html>
<html>
<head>
	<title>Prosed Insured</title>
	<style>
	*{-webkit-box-sizing:border-box;-moz-box-sizing:border-box;box-sizing:border-box;}

	@page { sheet-size: A4; }
	@page bigger { sheet-size: 215.9mm 279.4mm; }
	@page toc { sheet-size: A4; }
	body{
		font-family:Roboto, 'Segoe UI', Tahoma, sans-serif; 
		font-size:16px; 
		color:#000000; 
		max-width:100%;
		-webkit-print-color-adjust:exact;
	}
	@page .pdf-wrapper{margin:auto; color:#000000;}

	.header-section, .title-officer-info {
		width:100%;
	}
	.header-section .logo, 
	.title-officer-info .title-officer-basic-info, 
	.customer-info .company-details, 
	.customer-info .order-number, 
	.customer-info .property-info {
		float:left;width:50%;
	}
	.customer-info .order-number,
	.customer-info .property-info { 
		width: 100%; 
	}

    .text-center {
    	text-align: center;
    }

    .header-section .company-details p, 
    .title-officer-basic-info p, 
    .title-officer-contact-info p, 
    .customer-info .company-details p,
    .customer-info .order-number p,
	.customer-info .property-info p,
	.content-info .basic-details p { 
    	margin-bottom: 0px;
    	margin-top: 0px; 
    }
    .customer-info .company-details p.heading-info,
    .customer-info .order-number p.heading-info,
	.customer-info .property-info p.heading-info {
    	margin-top: 20px !important;
    }
    .heading {
    	text-transform: uppercase;
    }
    .spacer-t30 {
	    margin-top: 30px;
	}
	</style>
</head>
<body>
	<div class="pdf-wrapper">
		<div class="header-section">
			<div class="logo">
				<img src="http://dev.pacificcoasttitle.com/assets/media/general/logo2-dark.png" alt=""/>
			</div>
			<div class="company-details text-center">
				<p>200 W. Glenoaks Blvd, Suite 100</p>
				<p>Glendale, CA 91202</p>
				<p>(818)662-6700</p>
			</div>
			<h5 class="text-center">Issuing Agent for Commonwealth Land Title Insurance Company</h5>			
		</div>
		<hr>
		<div class="title-officer-info">
			<div class="title-officer-basic-info">
				<p><span class="heading">Title Officer:</span> <?php echo isset($title_officer) && !empty($title_officer) ? $title_officer : ''; ?></p>
				<p><span class="heading">Title Officer Email:</span>  unit33@pct.com</p>
			</div>
			<div class="title-officer-contact-info">
				<p><span class="heading">Title Officer Phone:</span> (818)662-6771</p>
				<p><span class="heading">Title Officer Fax:</span>  (818)484-2540</p>
			</div>
			<div class= "customer-info">
				<div class="company-details">
					<p class="heading-info"><span class="heading">To:</span> <?php echo isset($company) && !empty($company) ? $company : ''; ?></p>
					<p><?php echo isset($address) && !empty($address) ? $address : ''; ?></p>
				</div>
				<div class="order-number">
					<p class="heading-info"><span class="heading">Order No.:</span> <?php echo isset($order_number) && !empty($order_number) ? $order_number : ''; ?></p>
				</div>
				<div class="property-info">
					<p class="heading-info"><span class="heading">Property Address:</span> <?php echo isset($property_address) && !empty($property_address) ? $property_address : ''; ?></p>
				</div>
			</div>
			<hr>
		</div>
		<div class="content-info">
			<div class="basic-details">
				<p class="text-center"><span class="heading">Supplemental report dated as of: </span><?php echo date('M d, Y'); ?></p>
				<p class="text-center"><span class="heading">Original preliminary report dated: </span></p>
			</div>
			<div class="note">
				<h2 class="heading text-center">Supplemental Report</h2>
				<p style="text-align: justify;">The above numbered report (including any Supplements or Amendments thereto) is hereby modified and/or supplemented in order to reflect the following additional items relating to the issuance of a Policy of Title Insurance as follows:</p>
				<p style="text-align: justify;">UPON THE CLOSE OF ESCROW AND CONFIRMATION OF RECORDING PACIFIC COAST TITLE WILL BE IN A POSITION TO ISSUE A TITLE POLICY IN FAVOR OF:</p>
			</div>
			<div>
				<p>Borrowers: Flor Ojeda, Oscar Eduardo Diaz and Maria Roselia Vaquerano</p>
				<p>Lender: Home Approvals Direct, Inc., DBA HomeFirst Mortgage Bankers, It’s Successors and/or Assigns.</p>
				<p>Loan # 200200183</p>
				<p>Loan Amount: <?php echo isset($loan_amount) && !empty($loan_amount) ? '$'.$loan_amount : ''; ?></p>
			</div>
			<div class="spacer-t30"></div>
			<div class="">
				<p>Sincerely,</p>
				<p><?php echo isset($title_officer) && !empty($title_officer) ? $title_officer : ''; ?></p>
				<p>Title Officer</p>
			</div>
		</div>
	</div>
</body>
</html>