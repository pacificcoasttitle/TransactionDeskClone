<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title><?php echo $title;?></title>
	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link
		href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,300;0,400;0,500;0,600;0,700;1,200&display=swap"
		rel="stylesheet">
	<link rel="stylesheet" href="<?php echo base_url();?>assets/frontend/css/buyer-seller-package/bootstrap.min.css?v=01">
	<link rel="stylesheet" href="<?php echo base_url();?>assets/frontend/css/buyer-seller-package/style.css?v=01">
</head>

<style>
	.error2 {
		margin-top: 10px;
	}
	.form-control {
        width: 100%;
    }
</style>

<body class="">


	<!-- header -->

	<header>
		<div class="container">
			<div class="row align-items-center">
				<div class="col-6">
					<a href="#">
						<img src="<?php echo base_url();?>assets/frontend/images/buyer-seller-package/alanna-logo.png"
							alt="" class="img-fluid img_logo">
					</a>
				</div>
			</div>
		</div>
	</header>

	<!-- form content -->

	<section class="form_content">
		<div class="container">
			<div class="row">
				<div class="col-md-12">
					<?php if(!empty($success)) {?>
                        <div id="agent_success_msg" class="w-100 alert alert-success alert-dismissible">
                            <?php foreach($success as $sucess) {
                                    echo $sucess."<br \>";	
                                }?>
                        </div>
                    <?php } 
                    if(!empty($errors)) {?>
                        <div id="agent_error_msg" class="w-100 alert alert-danger alert-dismissible">
                            <?php foreach($errors as $error) {
                                    echo $error."<br \>";	
                                }?>
                        </div>
                    <?php } ?>
					<form action="<?php echo base_url().'borrower-seller-form/'.$orderDetails['file_id']; ?>" onsubmit="if (validateForm()) { document.forms['borrower_seller_form'].submit(); }" method="post" name="borrower_seller_form" id="borrower_seller_form">
						<h2 class="blue_title">Seller Opening Package<br><span
								style="font-size:16px; padding-top:15px;">Property Address: <?php echo $orderDetails['full_address'];?></span><br><span
								style="font-size:16px; padding-top:15px;">APN:<?php echo $orderDetails['apn'];?></span></h2>
						<div class="accordion mt-4" id="accordionExample">
							<div class="accordion-item">
								<h2 class="accordion-header" id="headingOne">
									<button class="accordion-button" type="button" data-bs-toggle="collapse"
										data-bs-target="#collapseOne" aria-expanded="true"
										aria-controls="collapseOne">(1) Seller Information</button>
								</h2>
								<div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne"
									data-bs-parent="#accordionExample">
									<div class="accordion-body">

										<div class="form-group sellerName mb-5">
											<label for="" class="mb-2"><b>Seller's Name exactly as shown on your Drivers
													license or government issued ID: <span>*</span></b></label>
											<div class="row">
												<div class="col-md-4">
													<div class="form-group position-relative">
														<input type="text" class="form-control" id="first_name"
															name="first_name" value="<?php echo $orderDetails['seller_first_name'];?>" required data-error="#first_name-error">
														<small class="small_label">First Name</small>
													</div>
													<label id="first_name-error" class="error text-danger error2" for="first_name"></label>
												</div>
												<input type="hidden" name="order_id" id="order_id" value="<?php echo $orderDetails['order_id'];?>">
												<div class="col-md-4">
													<div class="form-group position-relative">
														<input type="text" class="form-control" id="middle_name"
															name="middle_name" value="<?php echo $orderDetails['seller_middle_name'];?>" required data-error="#middle_name-error">
														<small class="small_label">Middle Name</small>
													</div>
													<label id="middle_name-error" class="error text-danger error2" for="middle_name"></label>
												</div>
												<div class="col-md-4">
													<div class="form-group position-relative">
														<input type="text" class="form-control" id="last_name"
															name="last_name" value="<?php echo $orderDetails['seller_last_name'];?>" required data-error="#last_name-error">
														<small class="small_label">Last Name</small>
													</div>
													<label id="last_name-error" class="error text-danger error2" for="last_name"></label>
												</div>
											</div>
										</div>

										<div class="form-group mb-3">
											<div class="row">
												<div class="col-md-4">
													<div class="form-group position-relative">
														<label for="" class="mb-2"><b>Seller 1 Preferred Phone Number
														<span>*</span></b></label>
														<input type="text" class="form-control" id="phone_number" name="phone_number" required>
													</div>
												</div>
												<div class="col-md-4">
													<div class="form-group position-relative">
														<label for="" class="mb-2"><b>Phone number is
																<span>*</span></b></label>
														<ul class="list-unstyled">
															<li>
																<input type="radio" name="phone_number_type" value="Home" id="Home" required data-error="#phone_number_type-error">
																<label for="Home">Home Number</label>
															</li>
															<li>
																<input type="radio" name="phone_number_type" value="Cell" id="Cell">
																<label for="Cell">Cell</label>
															</li>
															<li>
																<input type="radio" name="phone_number_type" value="Business" id="Business">
																<label for="Business">Business Phone</label>
															</li>
														</ul>
													</div>
													<label id="phone_number_type-error" class="error text-danger" for="phone_number_type"></label>
												</div>
											</div>
										</div>

										<div class="form-group mb-4">
											<label for="" class="mb-2"><b>Is Seller a citizen or resident of a foreign country? <span>*</span></b></label>
											<ul class="list-inline">
												<li class="list-inline-item me-md-5">
													<input type="radio" value="yes" id="foreignYes" name="foreign_resident" required data-error="#foreign_resident-error">
													<label for="foreignYes">Yes</label>
												</li>
												<li class="list-inline-item">
													<input type="radio" value="no" id="foreignNo" name="foreign_resident">
													<label for="foreignNo">No</label>
												</li>
											</ul>
											<label id="foreign_resident-error" class="error text-danger" for="foreign_resident"></label>
										</div>


										<div class="form-group mb-4">
											<label for="" class="mb-2"><b>Is there a Co-Seller for this property?<span>*</span></b></label>
											<ul class="list-inline">
												<li class="list-inline-item me-md-5">
													<input type="radio" value="yes" id="coSellerYes" name="co_seller" required data-error="#co_seller-error">
													<label for="coSellerYes">Yes</label>
												</li>
												<li class="list-inline-item">
													<input type="radio" value="no" id="coSellerNo" name="co_seller">
													<label for="coSellerNo">No</label>
												</li>
											</ul>
											<label id="co_seller-error" class="error text-danger" for="co_seller"></label>
										</div>

										<div class="coSellerInfo d-none">
											<div class="form-group sellerName mb-5">
												<label for="" class="mb-2"><b>Spouse/Co-Seller's Name exactly as shown
														on their Driver's License or other government issued ID:
														<span>*</span></b></label>
												<div class="row">
													<div class="col-md-4">
														<div class="form-group position-relative">
															<input type="text" class="form-control" id="co_seller_first_name" name="co_seller_first_name" value="<?php echo $orderDetails['second_seller_first_name'];?>" data-error="#co_seller_first_name-error">
															<small class="small_label">First Name</small>
														</div>
														<label id="co_seller_first_name-error" class="error text-danger error2" for="co_seller_first_name"></label>
													</div>
													
													<div class="col-md-4">
														<div class="form-group position-relative">
															<input type="text" class="form-control" id="co_seller_middle_name" name="co_seller_middle_name" value="<?php echo $orderDetails['second_seller_middle_name'];?>" data-error="#co_seller_middle_name-error">
															<small class="small_label">Middle Name</small>
														</div>
														<label id="co_seller_middle_name-error" class="error text-danger error2" for="co_seller_middle_name"></label>
													</div>
													
													<div class="col-md-4">
														<div class="form-group position-relative">
															<input type="text" class="form-control" id="co_seller_last_name" name="co_seller_last_name" value="<?php echo $orderDetails['second_seller_last_name'];?>" data-error="#co_seller_last_name-error">
															<small class="small_label">Last Name</small>
														</div>
														<label id="co_seller_last_name-error" class="error text-danger error2" for="co_seller_last_name"></label>
													</div>
													
												</div>
											</div>

											<div class="form-group position-relative mb-5 row">
												<label for="" class="mb-2 col-md-12"><b>Expiration Date of their
														Driver's License or other government issued ID:
														<span>*</span></b></label>
												<div class="col-md-4">
													<div class="form-group position-relative">
														<input type="date" class="form-control" id="co_seller_expiration_date" name="co_seller_expiration_date" data-error="#co_seller_expiration_date-error">
														<small class="small_label">Date</small>
													</div>
													<label id="co_seller_expiration_date-error" class="error text-danger error2" for="co_seller_expiration_date"></label>
												</div>
											</div>

											<div class="form-group mb-3 row">
												<label for="" class="mb-2 col-md-12"><b>Marital Status
														<span>*</span></b></label>
												<ul class="list-unstyled">
													<li>
														<input type="radio" value="single" id="singlecoSeller" name="co_seller_marital_status" data-error="#co_seller_marital_status-error">
														<label for="singlecoSeller">Single</label>
													</li>
													<li>
														<input type="radio" value="married" id="marriedcoSeller" name="co_seller_marital_status">
														<label for="marriedcoSeller">Married</label>
													</li>
												</ul>
												<label id="co_seller_marital_status-error" class="error text-danger" for="co_seller_marital_status"></label>
											</div>

											<div class="form-group mb-4 row">
												<label for="" class="mb-2 col-md-12"><b>Seller's Social Security/Tax ID:<span>*</span></b></label>
												<div class="col-md-4">
													<input type="text" class="form-control" id="co_seller_ssn" name="co_seller_ssn">
												</div>
											</div>

											<div class="form-group position-relative mb-5 row">
												<label for="" class="mb-2 col-md-12"><b>Email</b></label>
												<div class="col-md-6">
													<div class="form-group position-relative">
														<input type="email" class="form-control" id="co_seller_email" name="co_seller_email" data-error="#co_seller_email-error">
														<small class="small_label"> example@example.com</small>
													</div>
													<label id="co_seller_email-error" class="error text-danger error2" for="co_seller_email"></label>
												</div>
											</div>

											<div class="form-group mb-3">
												<div class="row">
													<div class="col-md-4">
														<div class="form-group position-relative">
															<label for="" class="mb-2"><b>Preferred Phone Number
																	<span>*</span></b></label>
															<input type="text" class="form-control" id="co_seller_phone_number" name="co_seller_phone_number">
														</div>
													</div>
													<div class="col-md-4">
														<div class="form-group position-relative">
															<label for="" class="mb-2"><b>Phone number is
																	<span>*</span></b></label>
															<ul class="list-unstyled">
																<li>
																	<input type="radio" name="co_seller_phone_number_type" value="Home" id="HomecoSeller" data-error="#co_seller_phone_number_type-error">
																	<label for="HomecoSeller">Home Number</label>
																</li>
																<li>
																	<input type="radio" name="co_seller_phone_number_type" value="Cell" id="CellcoSeller">
																	<label for="CellcoSeller">Cell</label>
																</li>
																<li>
																	<input type="radio" name="co_seller_phone_number_type" value="Business" id="BusinesscoSeller">
																	<label for="BusinesscoSeller">Business Phone</label>
																</li>
															</ul>
															<label id="co_seller_phone_number_type-error" class="error text-danger" for="co_seller_phone_number_type"></label>
														</div>
													</div>
												</div>
											</div>

											<div class="form-group mb-4">
												<label for="" class="mb-2"><b>Is Seller a citizen or resident of a
														foreign country? * <span>*</span></b></label>
												<ul class="list-inline">
													<li class="list-inline-item me-md-5">
														<input type="radio" value="yes" id="coSellerforeignYes" name="co_seller_foreign_resident" data-error="#co_seller_foreign_resident-error">
														<label for="coSellerforeignYes">Yes</label>
													</li>
													<li class="list-inline-item">
														<input type="radio" value="no" id="coSellerforeignNo" name="co_seller_foreign_resident">
														<label for="coSellerforeignNo">No</label>
													</li>
												</ul>
												<label id="co_seller_foreign_resident-error" class="error text-danger" for="co_seller_foreign_resident"></label>
											</div>
										</div>

										<div class="form-group mb-4">
											<label for="" class="mb-2"><b>I/We will be attending closing
													<span>*</span></b></label>
											<ul class="list-inline">
												<li class="list-inline-item me-md-5">
													<input type="radio" value="yes" id="attendingYes" name="attending" required data-error="#attending-error">
													<label for="attendingYes">Yes</label>
												</li>
												<li class="list-inline-item">
													<input type="radio" value="no" id="attendingNo" name="attending">
													<label for="attendingNo">No</label>
												</li>
											</ul>
											<label id="attending-error" class="error text-danger" for="attending"></label>
										</div>
									</div>
								</div>
							</div>
							<div class="accordion-item">
								<h2 class="accordion-header" id="headingTwo">
									<button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
										data-bs-target="#collapseTwo" aria-expanded="false"
										aria-controls="collapseTwo">(2) Property Address</button>
								</h2>
								<div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo"
									data-bs-parent="#accordionExample">
									<div class="accordion-body">
										<div class="form-group mb-4">
											<label for="" class="mb-2"><b>Property Address being sold: </b></label>
											<input type="text" class="form-control" name="property_address" id="property_address" value="<?php echo $orderDetails['full_address'];?>" required>
										</div>
										<div class="form-group mb-4">
											<label for="" class="mb-2"><b>Is the above address the correct address of
													the property being sold? <span>*</span></b></label>
											<ul class="list-inline">
												<li class="list-inline-item me-md-5">
													<input type="radio" id="yesCorrectPropertyAddress" value="yes" name="is_correct_property_address" required data-error="#is_correct_property_address-error">
													<label for="yesCorrect">Yes</label>
												</li>
												<li class="list-inline-item">
													<input type="radio" id="noCorrectPropertyAddress" value="no" name="is_correct_property_address">
													<label for="noCorrect">No</label>
												</li>
											</ul>
											<label id="is_correct_property_address-error" class="error text-danger" for="is_correct_property_address"></label>
											<div class="otherPropertyAddress d-none">
												<div class="form-group position-relative mb-3">
													<label for="" class="mb-2"><b>Enter the property address being sold
															<span>*</span> </b></label>
													<div class="form-group position-relative">
														<input type="text" class="form-control" id="property_street_address" name="property_street_address" data-error="#property_street_address-error">
														<small class="small_label">Street Address</small>
													</div>
													<label id="property_street_address-error" class="error text-danger error2" for="property_street_address"></label>
												</div>
												<div class="row">
													<div class="col-md-6">
														<div class="form-group position-relative mb-3">
															<input type="text" class="form-control" id="property_city" name="property_city" data-error="#property_city-error">
															<small class="small_label">City</small>
														</div>
														<label id="property_city-error" class="error text-danger error2" for="property_city"></label>
													</div>
													<div class="col-md-6">
														<div class="form-group position-relative mb-3">
															<select class="form-control" id="property_state" name="property_state" data-error="#property_state-error">
																<option value="CA" selected>CA</option>
															</select>
															<small class="small_label">State</small>
														</div>
														<label id="property_state-error" class="error text-danger error2" for="property_state"></label>
													</div>
												</div>
												<div class="form-group position-relative mb-3 col-md-6">
													<input type="text" class="form-control" id="property_zip_code" name="property_zip_code" data-error="#property_zip_code-error">
													<small class="small_label">Zip Code</small>
												</div>
												<label id="property_zip_code-error" class="error text-danger error2" for="property_zip_code"></label>
											</div>
										</div>
										<div class="form-group mb-4">
											<label for="" class="mb-2"><b>Is the Property Address above your current
													address? <span>*</span></b></label>
											<ul class="list-inline">
												<li class="list-inline-item me-md-5">
													<input type="radio" id="yesCorrectPropertyAddressAsCurrentAddress" value="yes" name="is_property_address_as_current_address" required data-error="#is_property_address_as_current_address-error">
													<label for="yesCurrent">Yes</label>
												</li>
												<li class="list-inline-item">
													<input type="radio" id="noCorrectPropertyAddressAsCurrentAddress" value="no" name="is_property_address_as_current_address">
													<label for="noCurrent">No</label>
												</li>
											</ul>
											<label id="is_property_address_as_current_address-error" class="error text-danger" for="is_property_address_as_current_address"></label>
											<div class="otherCurrentAddress d-none">
												<div class="form-group position-relative mb-3">
													<label for="" class="mb-2"><b>Current Address
															<span>*</span> </b></label>
													<div class="form-group position-relative">
														<input type="text" class="form-control" id="current_street_address" name="current_street_address" data-error="#current_street_address-error">
														<small class="small_label">Street Address</small>
													</div>
													<label id="current_street_address-error" class="error text-danger error2" for="current_street_address"></label>
												</div>
												<div class="row">
													<div class="col-md-6">
														<div class="form-group position-relative mb-3">
															<input type="text" class="form-control" id="current_city" name="current_city" data-error="#current_city-error">
															<small class="small_label">City</small>
														</div>
														<label id="current_city-error" class="error text-danger error2" for="current_city"></label>
													</div>
													<div class="col-md-6">
														<div class="form-group position-relative mb-3">
															<select class="form-control" id="current_state" name="current_state" data-error="#current_state-error">
																<option value="CA" selected>CA</option>
															</select>
															<small class="small_label">State</small>
														</div>
														<label id="current_state-error" class="error text-danger error2" for="current_state"></label>
													</div>
												</div>
												<div class="form-group position-relative mb-3 col-md-6">
													<input type="text" class="form-control" id="current_zip_code" name="current_zip_code" data-error="#current_zip_code-error">
													<small class="small_label">Zip Code</small>
												</div>
												<label id="current_zip_code-error" class="error text-danger error2" for="current_zip_code"></label>											
											</div>
										</div>
										<div class="form-group mb-4">
											<label for="" class="mb-2"><b>Is your Forwarding Address different from your
													Current Address? <span>*</span></b></label>
											<ul class="list-inline">
												<li class="list-inline-item me-md-5">
													<input type="radio" id="yesForwarding" value="yes" name="is_forwarding_address_different_from_current_address" required data-error="#is_forwarding_address_different_from_current_address-error">
													<label for="yesForwarding">Yes</label>
												</li>
												<li class="list-inline-item">
													<input type="radio" id="noForwarding" value="no" name="is_forwarding_address_different_from_current_address">
													<label for="noForwarding">No</label>
												</li>
											</ul>
											<label id="is_forwarding_address_different_from_current_address-error" class="error text-danger" for="is_forwarding_address_different_from_current_address"></label>
											<div class="otherForwardAddress d-none">
												<div class="form-group position-relative mb-3">
													<label for="" class="mb-2"><b>Forwarding Address<span>*</span> </b></label>
													<div class="form-group position-relative">
														<input type="text" class="form-control" id="forwarding_street_address" name="forwarding_street_address" data-error="#forwarding_street_address-error">
														<small class="small_label">Street Address</small>
													</div>
													<label id="forwarding_street_address-error" class="error text-danger error2" for="forwarding_street_address"></label>
												</div>
												<div class="row">
													<div class="col-md-6">
														<div class="form-group position-relative mb-3">
															<input type="text" class="form-control" id="forwarding_city" name="forwarding_city" data-error="#forwarding_city-error">
															<small class="small_label">City</small>
														</div>
														<label id="forwarding_city-error" class="error text-danger error2" for="forwarding_city"></label>
													</div>
													<div class="col-md-6">
														<div class="form-group position-relative mb-3">
															<select class="form-control" id="forwarding_state" name="forwarding_state" data-error="#forwarding_state-error">
																<option value="CA" selected>CA</option>
															</select>
															<small class="small_label">State</small>
														</div>
														<label id="forwarding_state-error" class="error text-danger error2" for="forwarding_state"></label>
													</div>
												</div>
												<div class="form-group position-relative mb-3 col-md-6">
													<input type="text" class="form-control" id="forwarding_zip_code" name="forwarding_zip_code" data-error="#forwarding_zip_code-error">
													<small class="small_label">Zip Code</small>
												</div>
												<label id="forwarding_zip_code-error" class="error text-danger error2" for="forwarding_zip_code"></label>	
											</div>
										</div>

										<div class="form-group mb-4">
											<label for="" class="mb-2"><b>This property was our<span>*</span></b></label>
											<ul class="list-inline">
												<li class="list-inline-item me-md-5">
													<input type="radio" id="primary" value="primary" name="residence" required data-error="#residence-error">
													<label for="primary">Primary Residence</label>
												</li>
												<li class="list-inline-item me-md-5">
													<input type="radio" id="secondary" value="secondary" name="residence">
													<label for="secondary">Second Home</label>
												</li>
												<li class="list-inline-item">
													<input type="radio" id="investment" value="investment" name="residence">
													<label for="investment">Investment Property</label>
												</li>
											</ul>
											<label id="residence-error" class="error text-danger" for="residence"></label>
										</div>

										<div class="form-group mb-4">
											<label for="" class="mb-2"><b>Do you have your title insurance policy from
													when you purchased the house? (It will save some time in doing your
													title search because we will tack to your current
													policy.)</b></label>
											<ul class="list-inline">
												<li class="list-inline-item me-md-5">
													<input type="radio" id="yesinsurance" value="yes" name="is_insurance_policy" required data-error="#is_insurance_policy-error">
													<label for="yesinsurance">Yes</label>
												</li>
												<li class="list-inline-item">
													<input type="radio" id="noinsurance" value="no" name="is_insurance_policy">
													<label for="noinsurance">No</label>
												</li>
											</ul>
											<label id="is_insurance_policy-error" class="error text-danger" for="is_insurance_policy"></label>
											<div class="insurance_policy_file_name d-none mb-4">
												<input type="file" name="insurance_policy_file_name" class="d-none" id="insurance_policy_file_name" data-error="#insurance_policy_file_name-error">
												<label for="insurance_policy_file_name">
													<b>Please upload your prior title insurance policy</b>
													<span>Browse Files</span>
												</label>
											</div>
											<label id="insurance_policy_file_name-error" class="error text-danger" for="insurance_policy_file_name"></label>
										</div>
									</div>
								</div>
							</div>
							<div class="accordion-item">
								<h2 class="accordion-header" id="headingThree">
									<button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
										data-bs-target="#collapseThree" aria-expanded="false"
										aria-controls="collapseThree">(3) Statement of Information</button>
								</h2>
								<div id="collapseThree" class="accordion-collapse collapse"
									aria-labelledby="headingThree" data-bs-parent="#accordionExample">
									<div class="accordion-body">

										<div class="form-group mb-4">
											<label for="" class="mb-2"><b>Are you being represented by a Real Estate
													Agent? <span>*</span></b></label>
											<ul class="list-inline">
												<li class="list-inline-item me-md-5">
													<input type="radio" id="yesRealEstate" value="yes" name="is_real_estate" required data-error="#is_real_estate-error">
													<label for="yesRealEstate">Yes</label>
												</li>
												<li class="list-inline-item">
													<input type="radio" id="noRealEstate" value="no" name="is_real_estate">
													<label for="noRealEstate">No</label>
												</li>
											</ul>
											<label id="is_real_estate-error" class="error text-danger" for="is_real_estate"></label>
										</div>

										<div class="RealEstateInfo d-none">
											<h3 class="text-center"><b>Real Estate Agent Information:</b></h3>
											<hr>
											<div class="form-group sellerName mb-5">
												<label for="" class="mb-2"><b>Seller Agent's Name
														<span>*</span></b></label>
												<div class="row">
													<div class="col-md-4">
														<div class="form-group position-relative">
															<input type="text" class="form-control" id="agent_first_name" name="agent_first_name" data-error="#agent_first_name-error">
															<small class="small_label">First Name</small>
														</div>
														<label id="agent_first_name-error" class="error text-danger error2" for="agent_first_name"></label>
													</div>
													<div class="col-md-4">
														<div class="form-group position-relative">
															<input type="text" class="form-control" id="agent_middle_name" name="agent_middle_name" data-error="#agent_middle_name-error">
															<small class="small_label">Middle Name</small>
														</div>
														<label id="agent_middle_name-error" class="error text-danger error2" for="agent_middle_name"></label>
													</div>
													<div class="col-md-4">
														<div class="form-group position-relative">
															<input type="text" class="form-control" id="agent_last_name" name="agent_last_name" data-error="#agent_last_name-error">
															<small class="small_label">Last Name</small>
														</div>
														<label id="agent_last_name-error" class="error text-danger error2" for="agent_last_name"></label>
													</div>
												</div>
											</div>

											<div class="form-group row mb-4">
												<label for="" class="mb-2 col-12"><b>Agent's Company:<span>*</span></b></label>
												<div class="col-md-8">
													<input type="text" class="form-control" id="agent_company" name="agent_company" data-error="#agent_company-error">
												</div>
												<label id="agent_company-error" class="error text-danger" for="agent_company"></label>
											</div>

											<div class="otherAddress mb-5">
												<div class="form-group position-relative mb-3">
													<label for="" class="mb-2"><b>Agent's Company Address </b></label>
													<div class="form-group position-relative">
														<input type="text" class="form-control" id="agent_company_address" name="agent_company_address" data-error="#agent_company_address-error">
														<small class="small_label">Street Address</small>
													</div>
													<label id="agent_company_address-error" class="error text-danger error2" for="agent_company_address"></label>
												</div>
								
												<div class="row mb-3">
													<div class="col-md-6">
														<div class="form-group position-relative">
															<input type="text" class="form-control" id="agent_company_city" name="agent_company_city" data-error="#agent_company_city-error">
															<small class="small_label">City</small>
														</div>
														<label id="agent_company_city-error" class="error text-danger error2" for="agent_company_city"></label>
													</div>
													
													<div class="col-md-6">
														<div class="form-group position-relative">
															<select name="state" class="form-control" id="agent_company_state" name="agent_company_state" data-error="#agent_company_state-error">
																<option value="CA" selected>CA</option>
															</select>
															<small class="small_label">State</small>
														</div>
														<label id="agent_company_state-error" class="error text-danger error2" for="agent_company_state"></label>
													</div>
												</div>
												<div class="form-group position-relative col-md-6">
													<input type="text" class="form-control" id="agent_company_zip_code" name="agent_company_zip_code" data-error="#agent_company_zip_code-error">
													<small class="small_label">Zip Code</small>
												</div>
												<label id="agent_company_zip_code-error" class="error text-danger error2" for="agent_company_zip_code"></label>
											</div>

											<div class="row">
												<div class="col-md-6 mb-3">
													<div class="form-group">
														<label for=""><b>Amount/Percent of Commission:</b></label>
														<input type="text" class="form-control" id="amount_percent_commission" name="amount_percent_commission" data-error="#amount_percent_commission-error">
													</div>
													<label id="amount_percent_commission-error" class="error text-danger" for="amount_percent_commission"></label>
												</div>
												<div class="col-md-6 mb-3">
													<div class="form-group">
														<label for=""><b>Amount of Any Deductions from Commission:
															</b></label>
														<input type="text" class="form-control" id="amount_deduction" name="amount_deduction" data-error="#amount_deduction-error">
													</div>
													<label id="amount_deduction-error" class="error text-danger" for="amount_deduction"></label>
												</div>
												<div class="col-md-6 mb-3">
													<div class="form-group position-relative">
														<label for=""><b>Agent Phone</b></label>
														<input type="text" class="form-control"  id="agent_phone" name="agent_phone" data-error="#agent_phone-error">
														<small class="small_label">Cell Phone or Email is required</small>
													</div>
													<label id="agent_phone-error" class="error text-danger error2" for="agent_phone"></label>
												</div>
											</div>

											<div class="form-group position-relative row mb-3">
												<label for="" class="mb-2 col-12"><b>Email<span></span></b></label>
												<div class="form-group position-relative col-md-8">
													<input type="text" class="form-control" id="agent_email" name="agent_email" data-error="#agent_email-error">
													<small class="small_label">Cell Phone or Email is required</small>
												</div>
												<label id="agent_email-error" class="error text-danger error2" for="agent_email"></label>
											</div>
										</div>


										<div class="form-group mb-4">
											<label for="" class="mb-2"><b>Seller Will be Paying and providing invoices for</b></label>
											<ul class="list-unstyled">
												<li>
													<input type="checkbox" id="repair" value="repairs" name="seller_invoices[]" required data-error="#seller_invoices-error">
													<label for="repair">Repairs</label>
												</li>
												<li>
													<input type="checkbox" id="warranty" value="warranty" name="seller_invoices[]">
													<label for="warranty">Home Warranty</label>
												</li>
												<li>
													<input type="checkbox" id="other" value="other" name="seller_invoices[]">
													<label for="other">Other</label>
												</li>
												<li>
													<input type="checkbox" id="none" value="none" name="seller_invoices[]">
													<label for="none"> None</label>
												</li>
											</ul>
											<label id="seller_invoices-error" class="error text-danger" for="seller_invoices"></label>
											<div class="seller_invoices_files d-none mb-4">
												<input type="file" name="seller_invoices_files" class="d-none" id="seller_invoices_files">
												<label for="seller_invoices_files">
													<b>Upload Invoice(s) if available</b>
													<span>Browse Files</span>
												</label>
											</div>
										</div>
									</div>
								</div>
							</div>
							<div class="accordion-item">
								<h2 class="accordion-header" id="headingFour">
									<button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
										data-bs-target="#collapseFour" aria-expanded="false"
										aria-controls="collapseFour">
										(4) 593-C
									</button>
								</h2>
								<div id="collapseFour" class="accordion-collapse collapse" aria-labelledby="headingFour"
									data-bs-parent="#accordionExample">
									<div class="accordion-body">
										<div class="form-group mb-4">
											<label for="" class="mb-2"><b> Is there a mortgage on the property?</b></label>
											<ul class="list-inline">
												<li class="list-inline-item me-md-5">
													<input type="radio" id="yesmortgage" value="yes" name="is_mortgage" required data-error="#is_mortgage-error">
													<label for="yesmortgage">Yes</label>
												</li>
												<li class="list-inline-item">
													<input type="radio" id="nomortgage" value="no" name="is_mortgage">
													<label for="nomortgage">No</label>
												</li>
											</ul>
											<label id="is_mortgage-error" class="error text-danger" for="is_mortgage"></label>
										</div>

										<div class="d-none" id="mortgage">
											<div class="form-group mb-4">
												<label for="" class="mb-2"><b>Is this mortgage/loan a Line of Credit?</b></label>
												<ul class="list-inline">
													<li class="list-inline-item me-md-5">
														<input type="radio" id="yesCreditCard" value="yes" name="is_mortgage_credit" data-error="#is_mortgage_credit-error">
														<label for="yesCreditCard">Yes</label>
													</li>
													<li class="list-inline-item">
														<input type="radio" id="noCreditCard" value="no" name="is_mortgage_credit">
														<label for="noCreditCard">No</label>
													</li>
												</ul>
												<label id="is_mortgage_credit-error" class="error text-danger" for="CreditCard"></label>
												<div class="form-group CreditCardLock d-none mb-4">
													<label for="" class="mb-2"><b>Do you want to close and lock this Line of Credit?</b></label>
													<ul class="list-inline">
														<li class="list-inline-item me-md-5">
															<input type="radio" id="yesCreditCardLock" value="yes" name="is_creditcard_lock" data-error="#is_creditcard_lock-error">
															<label for="yesCreditCardLock">Yes</label>
														</li>
														<li class="list-inline-item">
															<input type="radio" id="noCreditCardLock" value="no" name="is_creditcard_lock">
															<label for="noCreditCardLock">No</label>
														</li>
													</ul>
													<label id="is_creditcard_lock-error" class="error text-danger" for="is_creditcard_lock"></label>
												</div>
											</div>
											<div class="form-group mb-4">
												<label for="" class="mb-2"><b>Lender/Mortgage Holder:</b></label>
												<input type="text" class="form-control" id="mortgage_holder" name="mortgage_holder" data-error="#mortgage_holder-error">
												<label id="mortgage_holder-error" class="error text-danger" for="mortgage_holder"></label>
											</div>
											
											<div class="row">
												<div class="col-md-6 mb-4">
													<div class="form-group">
														<label for="" class="mb-2"><b>Original Loan Amount:</b></label>
														<input type="text" class="form-control" id="loan_amount" name="loan_amount" data-error="#loan_amount-error">
													</div>
													<label id="loan_amount-error" class="error text-danger" for="loan_amount"></label>
												</div>
												<div class="col-md-6 mb-4">
													<div class="form-group">
														<label for="" class="mb-2"><b>Lender/Mortgage Holder Phone:</b></label>
														<input type="text" class="form-control" id="mortgage_phone" name="mortgage_phone" data-error="#mortgage_phone-error">
													</div>
													<label id="mortgage_phone-error" class="error text-danger" for="mortgage_phone"></label>
												</div>
												<div class="col-md-6 mb-4">
													<div class="form-group">
														<label for="" class="mb-2"><b>Loan Number:</b></label>
														<input type="text" class="form-control" id="loan_number" name="loan_number" data-error="#loan_number-error">
													</div>
													<label id="loan_number-error" class="error text-danger" for="loan_number"></label>
												</div>
												<div class="col-md-6 mb-4">
													<div class="form-group">
														<label for="" class="mb-2"><b>Approximate Loan
																Balance:</b></label>
														<input type="text" class="form-control" id="loan_balance" name="loan_balance" data-error="#loan_balance-error">
													</div>
													<label id="loan_balance-error" class="error text-danger" for="loan_balance"></label>
												</div>
											</div>
											<div class="form-group mb-4">
												<label for="" class="mb-2"><b>Account Holder's Name:</b></label>
												<input type="text" class="form-control" id="account_holder_name" name="account_holder_name" data-error="#account_holder_name-error">
												<label id="account_holder_name-error" class="error text-danger" for="account_holder_name"></label>
											</div>
									        
											<div class="form-group mb-3">
												<label for="" class="mb-2"><b>Is there a 2nd mortgage on the
														property?</b></label>
												<ul class="list-inline">
													<li class="list-inline-item me-md-5">
														<input type="radio" id="yesmortgage2" value="yes" name="is_second_mortgage" data-error="#is_second_mortgage-error">
														<label for="yesmortgage2">Yes</label>
													</li>
													<li class="list-inline-item">
														<input type="radio" id="nomortgage2" value="no" name="is_second_mortgage">
														<label for="nomortgage2">No</label>
													</li>
												</ul>
												<label id="is_second_mortgage-error" class="error text-danger" for="is_second_mortgage"></label>
												<div class="secondMortgage d-none">
													<div class="form-group mb-4">
														<label for="" class="mb-2"><b>Is the 2nd mortgage a Line of
																Credit?</b></label>
														<ul class="list-inline">
															<li class="list-inline-item me-md-5">
																<input type="radio" id="yesCreditCard2" value="yes" name="is_second_mortgage_credit" data-error="#is_second_mortgage_credit-error">
																<label for="yesCreditCard2">Yes</label>
															</li>
															<li class="list-inline-item">
																<input type="radio" id="noCreditCard2" value="no" name="is_second_mortgage_credit">
																<label for="noCreditCard2">No</label>
															</li>
														</ul>
														<label id="is_second_mortgage_credit-error" class="error text-danger" for="is_second_mortgage_credit"></label>
														<div class="form-group CreditCardLock d-none mb-4">
															<label for="" class="mb-2"><b>Do you want to close and lock this Line of Credit?</b></label>
															<ul class="list-inline">
																<li class="list-inline-item me-md-5">
																	<input type="radio" id="yesCreditCardLock2" value="yes" name="is_second_creditcard_lock" data-error="#is_second_creditcard_lock-error">
																	<label for="yesCreditCardLock2">Yes</label>
																</li>
																<li class="list-inline-item">
																	<input type="radio" id="noCreditCardLock2" value="no" name="is_second_creditcard_lock">
																	<label for="noCreditCardLock2">No</label>
																</li>
															</ul>
															<label id="is_second_creditcard_lock-error" class="error text-danger" for="is_second_creditcard_lock"></label>
														</div>
													</div>
													<div class="form-group mb-4">
														<label for="" class="mb-2"><b>2nd Lender/Mortgage Holder:</b></label>
														<input type="text" class="form-control" id="second_mortgage_holder" name="second_mortgage_holder" data-error="#second_mortgage_holder-error">
														<label id="second_mortgage_holder-error" class="error text-danger" for="second_mortgage_holder"></label>
													</div>
													<div class="row">
														<div class="col-md-6 mb-4">
															<div class="form-group">
																<label for="" class="mb-2"><b>2nd Original Loan Amount:</b></label>
																<input type="text" class="form-control" id="second_loan_amount" name="second_loan_amount" data-error="#second_loan_amount-error">
															</div>
															<label id="second_loan_amount-error" class="error text-danger" for="second_loan_amount"></label>
														</div>
														<div class="col-md-6 mb-4">
															<div class="form-group">
																<label for="" class="mb-2"><b>2nd Lender/Mortgage Holder Phone:</b></label>
																<input type="text" class="form-control" id="second_mortgage_phone" name="second_mortgage_phone" data-error="#second_mortgage_phone-error">
															</div>
															<label id="second_mortgage_phone-error" class="error text-danger" for="second_mortgage_phone"></label>
														</div>
														<div class="col-md-6 mb-4">
															<div class="form-group">
																<label for="" class="mb-2"><b>2nd Loan Number:</b></label>
																<input type="text" class="form-control" id="second_loan_number" name="second_loan_number" data-error="#second_loan_number-error">
															</div>
															<label id="second_loan_number-error" class="error text-danger" for="second_loan_number"></label>
														</div>
														<div class="col-md-6 mb-4">
															<div class="form-group">
																<label for="" class="mb-2"><b> 2nd Approximate Loan
																		Balance:</b></label>
																<input type="text" class="form-control" id="second_loan_balance" name="second_loan_balance" data-error="#second_loan_balance-error">
															</div>
															<label id="second_loan_balance-error" class="error text-danger" for="second_loan_balance"></label>
														</div>
													</div>
													<div class="form-group mb-4">
														<label for="" class="mb-2"><b>2nd Account Holder's Name:</b></label>
														<input type="text" class="form-control" id="second_account_holder_name" name="second_account_holder_name" data-error="#second_account_holder_name-error">
														<label id="second_account_holder_name-error" class="error text-danger" for="second_account_holder_name"></label>
													</div>
												</div>
											</div>

											<h3 class="text-center mb-4"><b>AUTHORIZATION FOR THE RELEASE OF
													INFORMATION</b></h3>

											TO WHOM IT MAY CONCERN:<br><br>

											I (WE), The undersigned parties hereby release, authorize and direct TITLE
											COMPANY NAME to release all necessary loan information and data to my real
											estate broker, and other third party contractors including but not limited
											to lien holders, and title insurance companies. <br><br>

											I (WE), the undersigned parties hereby release, authorize and direct your
											respective companies to release all necessary loan information and data
											to:<br><br>

											TITLE COMPANY NAME, and lenders. Phone: &nbsp; (111) 111-1111 &nbsp;
											&nbsp;&nbsp;&nbsp; Fax: &nbsp; (111) 222-2222<br><br>

											For the purpose of obtaining payoffs of my loans below, for a Short Sale
											payoff of the same which may require such disclosures, and for Closing
											Instruction Compliance.<br><br>

											For your convenience, I (WE) have attached the following
											information:<br><br>

											<div class="mb-3"><b>FIRST LOAN / PRIMARY LOAN / MORTGAGE</b></div>
											<div class="row mb-3">
												<div class="col-md-6">
													<table class="table_fee_table">
														<tr>
															<td>Loan Number</td>
															<th></th>
														</tr>
														<tr>
															<td>Loan Amount</td>
															<th>$</th>
														</tr>
														<tr>
															<td>Lender's Name</td>
															<th>CASH</th>
														</tr>
														<tr>
															<td>Lender's Phone </td>
															<th></th>
														</tr>
													</table>
												</div>
												<div class="col-md-6">
													<table class="table_fee_table">
														<tr>
															<td>Account Balance</td>
															<th>$</th>
														</tr>
														<tr>
															<td>Account Holder's Name:</td>
															<th></th>
														</tr>
														<tr>
															<td>&nbsp;</td>
															<th>&nbsp;</th>
														</tr>
														<tr>
															<td>Phone Number: </td>
															<th></th>
														</tr>
													</table>
												</div>
											</div>
											<div class="mb-3"><b>SECOND LOAN / EQUITY LINE OF CREDIT</b></div>
											<div class="row mb-3">
												<div class="col-md-6">
													<table class="table_fee_table">
														<tr>
															<td>Loan Number</td>
															<th></th>
														</tr>
														<tr>
															<td>Loan Amount</td>
															<th>$</th>
														</tr>
														<tr>
															<td>Lender's Name</td>
															<th></th>
														</tr>
														<tr>
															<td>Lender's Phone </td>
															<th></th>
														</tr>
													</table>
												</div>
												<div class="col-md-6">
													<table class="table_fee_table">
														<tr>
															<td>Account Balance</td>
															<th>$</th>
														</tr>
														<tr>
															<td>Account Holder's Name:</td>
															<th></th>
														</tr>
														<tr>
															<td>&nbsp;</td>
															<th>&nbsp;</th>
														</tr>
														<tr>
															<td>Phone Number: </td>
															<th></th>
														</tr>
													</table>
												</div>
											</div>

											<div class="mb-5">
												I(We), authorize the release of the information and for the bank to
												close and freeze any equity line described above.
											</div>

										</div>

										<div class="form-group mb-2">
											<input type="checkbox" id="is_agree_593_c" name="is_agree_593_c" required data-error="#is_agree_593_c-error">
											<label for="agree">I/We have read and agree to <span>*</span></label>
										</div>
										<label id="is_agree_593_c-error" class="error text-danger" for="is_agree_593_c"></label>
										<div class="border p-3">
											the above payoff authorization as indicated by signing below.
										</div>
									</div>
								</div>
							</div>
							<div class="accordion-item">
								<h2 class="accordion-header" id="headingFive">
									<button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
										data-bs-target="#collapseFive" aria-expanded="false"
										aria-controls="collapseFive">
										(5) 1099-S
									</button>
								</h2>
								<div id="collapseFive" class="accordion-collapse collapse" aria-labelledby="headingFive"
									data-bs-parent="#accordionExample">
									<div class="accordion-body">

										<ul class="list-unstyled">
											<li>
												<div class="form-group mb-3">
													<label class="mb-2"><b>(1) I owned and used the residence as my
															principal residence for periods aggregating 2 years or more
															during the 5-year period ending on the date of the sale or
															exchange of the residence.</b></label>
													<ul class="list-inline">
														<li class="list-inline item me-md-5">
															<input type="radio" id="exchangeeResidenceTrue" name="is_exchange_residence" value="true" required data-error="#is_exchange_residence-error">
															<label for="exchangeeResidenceTrue">True</label>
														</li>
														<li class="list-inline item me-md-5">
															<input type="radio" id="exchangeeResidenceFalse" value="false" name="is_exchange_residence">
															<label for="exchangeeResidenceFalse">False</label>
														</li>
													</ul>
													<label id="is_exchange_residence-error" class="error text-danger" for="is_exchange_residence"></label>
												</div>
											</li>
											<li>
												<div class="form-group mb-3">
													<label class="mb-2"><b>(2) I have not sold or exchanged another
															principle residence during the 2-year period ending on the
															date of the sale or exchange of the residence.</b></label>
													<ul class="list-inline">
														<li class="list-inline item me-md-5">
															<input type="radio" id="NotexchangeeResidenceTrue" name="is_not_exchange_residence" value="true" required data-error="#is_not_exchange_residence-error">
															<label for="NotexchangeeResidenceTrue">True</label>
														</li>
														<li class="list-inline item me-md-5">
															<input type="radio" id="NotexchangeeResidenceFalse" name="is_not_exchange_residence" value="false">
															<label for="NotexchangeeResidenceFalse">False</label>
														</li>
													</ul>
													<label id="is_not_exchange_residence-error" class="error text-danger" for="is_not_exchange_residence"></label>
												</div>
											</li>
											<li>
												<div class="form-group mb-3">
													<label class="mb-2"><b>(3) I (or my spouse or former or former
															spouse, if I was married at any time during the period
															beginning after May 6, 1997, and ending today) have not used
															any portion of the residence for business or rental purposes
															after May 6, 1997..</b></label>
													<ul class="list-inline">
														<li class="list-inline item me-md-5">
															<input type="radio" id="formerSpouseTrue" name="is_former_spouse" value="true" required data-error="#is_former_spouse-error">
															<label for="formerSpouseTrue">True</label>
														</li>
														<li class="list-inline item me-md-5">
															<input type="radio" id="formerSpouseFalse" name="is_former_spouse" value="false">
															<label for="formerSpouseFalse">False</label>
														</li>
													</ul>
													<label id="is_former_spouse-error" class="error text-danger" for="is_former_spouse"></label>
												</div>
											</li>
											<li>
												<div class="form-group mb-3">
													<label class="mb-2">
														<b>(4) At least one of the following three statements
															applies:<br><br>
															The sale or exchange is of the entire residence for $250,000
															or less.<br><br>

															OR<br><br>

															I am married, the sale or exchange is of the entire
															residence for $500,000 or less, and the gain on the sale or
															exchange of the entire residence is $250,000 or
															less.<br><br>

															OR<br><br>

															I am married, the sale or exchange is of the entire
															residence for $500,000 or less, and (a) I intend to file a
															joint return for the year of the sale or exchange, (b) my
															spouse also used the residence as his or her principal
															residence for periods aggregating 2 years or more during the
															5 year period ending on the date of the sale or exchange of
															the residence, and (c) my spouse also has not sold or
															exchanged another principal residence during the 2-year
															period ending on the date of the sale or exchange of the
															principal residence.<br><br></b>
													</label>
													<ul class="list-inline">
														<li class="list-inline item me-md-5">
															<input type="radio" id="marriedTrue" name="is_married" value="true" required data-error="#is_married-error">
															<label for="marriedTrue">True</label>
														</li>
														<li class="list-inline item me-md-5">
															<input type="radio" id="marriedFalse" name="is_married" value="false">
															<label for="marriedFalse">False</label>
														</li>
													</ul>
													<label id="is_married-error" class="error text-danger" for="is_married"></label>
												</div>
											</li>
											<li>
												<div class="form-group mb-3">
													<label class="mb-2"><b>(5) During the 5-year period ending on the
															date of the sale or exchange of the residence, I did not
															acquire the residence in an exchange to which section 1031
															of the Internal Revenue Code applied.</b></label>
													<ul class="list-inline">
														<li class="list-inline item me-md-5">
															<input type="radio" id="periodTrue" name="is_period" value="true" required data-error="#is_period-error">
															<label for="periodTrue">True</label>
														</li>
														<li class="list-inline item me-md-5">
															<input type="radio" id="periodFalse" name="is_period" value="false">
															<label for="periodFalse">False</label>
														</li>
													</ul>
													<label id="is_period-error" class="error text-danger" for="is_period"></label>
												</div>
											</li>
											<li>
												<div class="form-group mb-3">
													<label class="mb-2"><b>(6) If my basis in the residence is
															determined by reference to the basis in the hands of a
															person who acquired the residence in an exchange to which
															section 1031 of the Internal Revenue Code applied, the
															exchange to which section 1031 applied occurred more than 5
															years prior to the date I sold or exchanged the
															residence.</b></label>
													<ul class="list-inline">
														<li class="list-inline item me-md-5">
															<input type="radio" id="RevenueTrue" name="is_revenue"  value="true" required data-error="#is_revenue-error">
															<label for="RevenueTrue">True</label>
														</li>
														<li class="list-inline item me-md-5">
															<input type="radio" id="RevenueFalse" name="is_revenue" value="false">
															<label for="RevenueFalse">False</label>
														</li>
														<li class="list-inline item me-md-5">
															<input type="radio" id="RevenueNA" name="is_revenue" value="n/a">
															<label for="RevenueNA">N/A</label>
														</li>
													</ul>
													<label id="is_revenue-error" class="error text-danger" for="is_revenue"></label>
												</div>
											</li>
										</ul>



									</div>
								</div>
							</div>
							<div class="accordion-item">
								<h2 class="accordion-header" id="headingSix">
									<button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
										data-bs-target="#collapseSix" aria-expanded="false" aria-controls="collapseSix">
										(6) FIRPTA Affidavit
									</button>
								</h2>
								<div id="collapseSix" class="accordion-collapse collapse" aria-labelledby="headingSix"
									data-bs-parent="#accordionExample">
									<div class="accordion-body">

										<h3 class="mb-4 text-ecnter"><b>SELLERS' CLOSING AGREEMENT AND DISCLOSURES</b>
										</h3>

										<p>
											<b>FEES AND COSTS</b> - Our standard closing fee has been disclosed to you.
											All fees paid to our firm will be designated on the Closing Disclosure or
											HUD, if applicable. If we are required to perform additional services beyond
											those described herein, we will charge extra for them. Please note this may
											cause a delay if we are not made aware of the change until the last minute,
											due to the disclosure tolerances. Without limiting the definition of
											“additional services”, examples would be preparation of a subordination
											agreement or release deed, powers of attorney or any other documents.
											Certain charges on the Closing Disclosure, Settlement Statement, including
											but not limited to overnight/courier and recording fees, may not reflect the
											actual costs paid by the settlement agent to a vendor. The additional amount
											is to cover our administrative aspects of handling the particular item or
											service. I/We hereby consent to and accept the above-referenced up-charges.
										</p>

										<p class="mb-0">
											<b>TERMS OF REPRESENTATION -</b>
										</p>
										<p>
											Unless explicitly stated in writing, we do NOT represent you, the Seller, in
											this transaction. We advise you to seek legal assistance. No member of our
											firm can give you legal advice other than to obtain independent counsel of
											your choice.
										</p>
										<p>
											As an accommodation to you, we are permitted by law to prepare the documents
											that you will need to sign at closing, such as the Seller’s Uniform Closing
											Disclosure, Settlement Statement, Deed and Lien Waiver. The drafting of
											these documents does not create an attorney–client relationship. We will
											prepare the documents consistent with the specifications of the purchase
											agreement. If the purchase agreement does not indicate specifications, we
											will prepare the documents to advance the interests of the Buyer.
										</p>
										<p>
											IF THE SELLER IS MARRIED, HIS /HER SPOUSE MUST ATTEND OR ARRANGE TO SIGN THE
											DEED AND LIEN WAIVER (THIS INCLUDES SEPARATION). TITLE COMPANY WILL NOT
											PERMIT A DEED AND LIEN WAIVER TO BE EXECUTED BY POWER OF ATTORNEY, EXCEPT IN
											EXTENUATING CIRCUMSTANCES.
										</p>

										<div class="text-primary text-center mb-3"><b> ********** Standard Closing Costs
												************</b></div>

										<div class="mb-3">
											<table class="table_fee_table mx-auto">
												<tr>
													<td>Seller Document Preparation</td>
													<th>$300</th>
												</tr>
												<tr>
													<td>Satisfaction Tracking</td>
													<th>$45</th>
												</tr>
												<tr>
													<td>1031 Exchange</td>
													<th>$200</th>
												</tr>
												<tr>
													<td>Wire Fee</td>
													<th>$25 per wire</th>
												</tr>
												<tr>
													<td>UPS</td>
													<th>$25 per package </th>
												</tr>
											</table>
										</div>
										<div class="text-center mb-3"><b>****Additional document(s) are on a
												case-by-case basis </b> </div>
										<p>
											You also have the choice of retaining your own attorney at your expense
											beyond the normal Closing Fee to draft your documents. In that event, please
											have the attorney send all necessary documents (at minimum, a deed and lien
											waiver) to our office at least 3 business days prior to closing for our
											review and possible changes.
										</p>
										<p>
											If you are using a 1031 Exchange, there will be an additional $200 fee for
											work related to the exchange. Call us as soon as possible if there is a 1031
											exchange.
										</p>

										<div class="form-group mb-3">
											<label for="" class="mb-2"><b>Select One: <span>*</span></b></label>
											<ul class="list-unstyled">
												<li>
													<input type="radio" id="attorney" value="no" name="is_attorney" required data-error="#is_attorney-error">
													<label for="attorney">I would like THIS ATTORNEY to prepare a deed
														and lien waiver for me pursuant to the understanding
														above.</label>
												</li>
												<li>
													<input type="radio" id="otherAttorney" value="yes" name="is_attorney">
													<label for="otherAttorney">The following attorney will draft my deed
														and lien waiver and secure cancellation of all deeds of trust
														and other exceptions to title.</label>
												</li>
											</ul>
											<label id="is_attorney-error" class="error text-danger" for="is_attorney"></label>
										</div>


										<div class="attorneyInfo d-none">
											<div class="row">
												<div class="col-md-6 mb-4">
													<div class="form-group">
														<label for="" class="mb-2"><b>Firm Name:</b></label>
														<input type="text" class="form-control" id="firm_name" name="firm_name" data-error="#firm_name-error">
													</div>
													<label id="firm_name-error" class="error text-danger" for="firm_name"></label>
												</div>
												<div class="col-md-6 mb-4">
													<div class="form-group">
														<label for="" class="mb-2"><b>Phone Number:</b></label>
														<input type="text" class="form-control" id="firm_phone_number" name="firm_phone_number" data-error="#firm_phone_number-error">
													</div>
													<label id="firm_phone_number-error" class="error text-danger" for="firm_phone_number"></label>
												</div>
											</div>
											<div class="row">
												<div class="col-md-4 mb-4">
													<div class="form-group">
														<label for="" class="mb-2"><b>Attorney Name:</b></label>
														<input type="text" class="form-control" id="attorney_name" name="attorney_name" data-error="#attorney_name-error">
													</div>
													<label id="attorney_name-error" class="error text-danger" for="attorney_name"></label>
												</div>
												<div class="col-md-4 mb-4">
													<div class="form-group">
														<label for="" class="mb-2"><b>Attorney Phone No.:</b></label>
														<input type="text" class="form-control" id="attorney_phone_number" name="attorney_phone_number" data-error="#attorney_phone_number-error">
													</div>
													<label id="attorney_phone_number-error" class="error text-danger" for="attorney_phone_number"></label>
												</div>
												<div class="col-md-4 mb-4">
													<div class="form-group position-relative">
														<label for="" class="mb-2"><b>Attorney Email:</b></label>
														<input type="text" class="form-control" id="attorney_email" name="attorney_email" data-error="#attorney_email-error">
														<small class="small_label">example@example.com</small>
													</div>
													<label id="attorney_email-error" class="error text-danger error2" for="attorney_email"></label>
												</div>
											</div>
										</div>


										<p>
											<b>WHAT SERVICES DO WE PERFORM-</b> We conduct the title examination of the
											property for the Buyer, we ensure that the deed of conveyance and the loan
											documents have been properly executed, that the closing funds are properly
											received and disbursed pursuant to the Settlement Statement to be prepared
											by us and reviewed by you at closing, and that the Buyers deed and deed of
											trust (mortgage) are duly recorded and that the owners’ and lender’s
											policies of title insurance are issued and delivered. If we are drafting the
											deed and lien waiver for the Seller we will furnish payoffs of the
											outstanding liens, along with cancellation of lien requests to the proper
											creditors; however, in the event the creditor does not comply with our
											cancellation request we will not pursue the creditor without being further
											retained by the buyer or seller.
										</p>
										<p>
											<b>CANCELLATION OF DEEDS OF TRUST-</b> Paragraph 8(e) of the OUR STATE Offer
											to Purchase and Contract, has places a legal duty on the Seller to ensure
											that all prior deeds of trust are canceled of record. The OUR STATE State
											Bar does not place the duty of cancellation on the Closing Attorney because
											the banks are required to cancel a Deed of Trust which is paid in full
											within 60 days of receiving payment in full. We will engage a third-party
											lien release company to guarantee your compliance with this duty at an
											additional fee collected on the settlement statement to the firm or our
											third party vendor. Please note, it is still your responsibility to release
											all liens and judgments from the public record. OUR LAW FIRM WILL NOT TAKE
											ANY ACTION BEYOND SENDING AN INITIAL LETTER OF REQUEST. A THIRD-PARTY VENDOR
											WILL CANCEL YOUR LIENS AT YOUR EXPENSE (APPROXIMATELY $35.00-$55.00 PER
											RELEASE).
										</p>
										<p>
											<b>FUNDS TO CLOSE-</b> Incoming Closing Funds- Any and all funds to close
											must be in the form of a wire from your bank. Please be sure to include your
											TITLE COMPANY File Number or Name, the property address as a reference. Our
											trust account is set up to not accept ACH, Book Transfers or any other form
											money transfer. <b> PLEASE NOTE TITLE COMPANY NAME WILL NOT ALTER ITS WIRING
												INSTRUCTIONS. IF YOU RECEIVE A MESSAGE FROM US THAT SAYS WE HAVE CHANGED
												OUR WIRING INSTRUCTIONS DO NOT SEND A WIRE AND CALL US IMMEDIATELY!</b>
										</p>
										<p>
											<b>OUTGOING PROCEEDS OR REFUNDS-</b> Should you elect to receive money from
											TITLE COMPANY NAME, via wire transfer we will require you to sign our wiring
											agreement (which is part of the closing package) and to provide us your
											wiring instructions. <b>If you must change your wiring instructions, we will
												require you to present us with new wiring instructions in person;
												otherwise we will deliver the funds via UPS, other expedited courier, or
												USPS.</b> If you elect to receive money from TITLE COMPANY NAME via
											check, you must cash or deposit the check within 90 days of the check date
											or the check becomes VOID. TITLE COMPANY NAME will make every effort to
											contact you, confirm that you have received the check and if needed, stop
											payment, recut and mail a replacement check to you. A reasonable dormancy
											fee shall be charged against any remaining funds in the client trust account
											which are unclaimed after the 90 days. Said fee shall not exceed $200.00 per
											year. The charge shall be based on time and effort spent making reasonable
											efforts to contact you and return the funds. Any de minimis amount of funds
											of $10.00 or less that remain in our trust account for a period of 6 months
											or longer will not be refunded to you, but will be applied to the dormancy
											fee charge and made payable to TITLE COMPANY NAME. <b>We appreciate your
												extra effort to quickly cash or deposit checks made payable to you,
												regardless of the amount. </b>
										</p>

										<p class="mb-0"><b class="text-underline">VERY IMPORTANT NOTICE!</b></p>

										<p><b>Proceeds will NOT be disbursed at the table. OUR STATE State Law mandates
												we must have the following to disburse funds:</b></p>

										<ul>
											<li>Good funds from the buyer and lender</li>
											<li>Funding authorization from the buyer’s lender</li>
											<li>Original signed documents in TITLE COMPANY Property office(s)</li>
											<li>Documents properly recorded within the Register of Deeds</li>
										</ul>

										<div class="form-group mb-2">
											<input type="checkbox" id="sign" name="sign" required data-error="#sign-error">
											<label for="sign">My/Our Signature(s) below <span>*</span></label>
										</div>
										<label id="sign-error" class="error text-danger error2" for="sign"></label>
										<div class="border p-3">
											CERTIFIES OUR RECEIPT, ACKNOWLEDGMENT, AND CONSENT TO THE TERMS OF OUR
											REPRESENTATION BY TITLE COMPANY NAME
										</div>
									</div>
								</div>
							</div>
							<div class="accordion-item d-none" id="association">
								<h2 class="accordion-header" id="headingSeven">
									<button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
										data-bs-target="#collapseSeven" aria-expanded="false"
										aria-controls="collapseSeven">
										Association Information
									</button>
								</h2>
								<div id="collapseSeven" class="accordion-collapse collapse"
									aria-labelledby="headingSeven" data-bs-parent="#accordionExample">
									<div class="accordion-body">
										<div class="row">z
											<div class="col-md-4">
												<div class="form-group mb-4">
													<label for="" class="mb-2">Condominium / Homeowners Association
														1</label>
													<input type="text" class="form-control">
												</div>
											</div>
											<div class="col-md-4">
												<div class="form-group mb-4">
													<label for="" class="mb-2">Property Management Company</label>
													<input type="text" class="form-control">
												</div>
											</div>
											<div class="col-md-4">
												<div class="form-group mb-4">
													<label for="" class="mb-2">Property Management Number</label>
													<input type="text" class="form-control">
												</div>
											</div>
										</div>
										<div class="row">
											<div class="col-md-4">
												<div class="form-group mb-4">
													<label for="" class="mb-2">Condominium / Homeowners Association
														2</label>
													<input type="text" class="form-control">
												</div>
											</div>
											<div class="col-md-4">
												<div class="form-group mb-4">
													<label for="" class="mb-2">Property Management Company</label>
													<input type="text" class="form-control">
												</div>
											</div>
											<div class="col-md-4">
												<div class="form-group mb-4">
													<label for="" class="mb-2">Property Management Number</label>
													<input type="text" class="form-control">
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
							<div class="accordion-item">
								<h2 class="accordion-header" id="headingEight">
									<button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
										data-bs-target="#collapseEight" aria-expanded="false"
										aria-controls="collapseEight">
										(7) NHD Receipt
									</button>
								</h2>
								<div id="collapseEight" class="accordion-collapse collapse"
									aria-labelledby="headingEight" data-bs-parent="#accordionExample">
									<div class="accordion-body">
										Name(s): <br><br>

										Date: 04-14-2022<br><br>

										Property Address: 202 Nice New St, City, ST 11111<br><br>

										<p>
											I/We the undersigned seller in the transaction contemplated hereunder
											acknowledge that from time to time, it is necessary to share information
											concerning this transaction with other parties to this transaction. I
											acknowledge that some of the information to be shared, may be protected as
											Non-Public Personal Information as defined by federal law.<br><br>

											I authorize TITLE COMPANY NAME., as the settlement agent to provide to the
											following parties with a copy of the Closing Disclosure, Loan Estimate,
											Title Insurance Policy and any Settlement Statement which is prepared and/or
											executed during the course of this transaction:<br><br>

											Buyer, their real estate agent and lender, the Seller and their real estate
											agent, asset management companies, the title insurance company/underwriter
											who is insuring this transaction, the service providers retained by the
											Borrower and/ or Seller to provide settlement services necessary to complete
											this transaction including but not limited to surveyors, pest inspectors,
											property inspectors, insurance agents, Seller’s counsel/settlement agent in
											this; or a related transaction.<br><br>

											I further authorize TITLE COMPANY to allow its third-party auditors and my
											title insurance company to review my file for accuracy and
											security/compliance purposes during the annual security audit of the law
											firm. TITLE COMPANY., will employ all necessary safeguards during such an
											audit to ensure the integrity and security of sensitive attorney client, and
											client financial information pursuant to federal law and OUR STATE State Bar
											Rules of Professional Conduct.
										</p>


										<div class="form-group mb-2 d-flex">
											<input type="checkbox" id="agreementSign" name="agreementSign" class="me-2 mt-1" required data-error="#agreementSign-error">
											<label for="agreementSign" class="mb-2">By checking and signing below
												<span>*</span></label>
										</div>
										<label id="agreementSign-error" class="error text-danger error2" for="agreementSign"></label>

										<div class="border p-3">
											we agree that a copy of this authorization may be accepted as an original.
										</div>
									</div>
								</div>
							</div>
							<div class="accordion-item">
								<h2 class="accordion-header" id="headingNine">
									<button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
										data-bs-target="#collapseNine" aria-expanded="false"
										aria-controls="collapseNine">
										(8) HOA ??
									</button>
								</h2>
								<div id="collapseNine" class="accordion-collapse collapse" aria-labelledby="headingNine"
									data-bs-parent="#accordionExample">
									<div class="accordion-body">

										<div class="form-group mb-4">
											<label for="" class="mb-2"><b>Does your property have an HOA?
													<span>*</span></b></label>
											<ul class="list-inline">
												<li class="list-inline-item me-md-5">
													<input type="radio" id="yesHOA" value="yes" name="is_property_hoa" required data-error="#is_property_hoa-error">
													<label for="yesHOA">Yes</label>
												</li>
												<li class="list-inline-item">
													<input type="radio" id="noHOA" value="no" name="is_property_hoa">
													<label for="noHOA">No</label>
												</li>
											</ul>
											<label id="is_property_hoa-error" class="error text-danger error2" for="is_property_hoa"></label>
										</div>

										<div class="homeOwner d-none">
											<h3 class="mb-4 text-center"><b>Homeowners Association Management
													Information:</b></h3>

											<div class="row">
												<div class="col-md-6 mb-3">
													<div class="form-group">
														<label for="" class="mb-2">Name of Management Company:</label>
														<input type="text" class="form-control" id="hoa_management_company_name" name="hoa_management_company_name" data-error="#hoa_management_company_name-error">
													</div>
													<label id="hoa_management_company_name-error" class="error text-danger" for="hoa_management_company_name"></label>
												</div>
												<div class="col-md-6 mb-3">
													<div class="form-group">
														<label for="" class="mb-2">Contact Person:</label>
														<input type="text" class="form-control" id="hoa_contact_person" name="hoa_contact_person" data-error="#hoa_contact_person-error">
													</div>
													<label id="hoa_management_company_name-error" class="error text-danger" for="hoa_management_company_name"></label>
												</div>
											</div>
											<div class="row">
												<div class="col-md-6 mb-3">
													<div class="form-group position-relative">
														<label for="" class="mb-2">Email:</label>
														<input type="text" class="form-control" id="hoa_email" name="hoa_email" data-error="#hoa_email-error">
														<small class="small_label">example@example.com</small>
													</div>
													<label id="hoa_email-error" class="error text-danger error2" for="hoa_email"></label>
												</div>
												<div class="col-md-6 mb-3">
													<div class="form-group">
														<label for="" class="mb-2">Phone:</label>
														<input type="text" class="form-control" id="hoa_phone" name="hoa_phone" data-error="#hoa_phone-error">
													</div>
													<label id="hoa_phone-error" class="error text-danger" for="hoa_phone"></label>
												</div>
											</div>
											<div class="row">
												<div class="col-md-6 mb-3">
													<div class="form-group">
														<label for="" class="mb-2">HOA Dues:</label>
														<input type="text" class="form-control" id="hoa_dues" name="hoa_dues" data-error="#hoa_dues-error">
													</div>
													<label id="hoa_dues-error" class="error text-danger" for="hoa_dues"></label>
												</div>
												<div class="col-md-6 mb-3">
													<div class="form-group">
														<label for="" class="mb-2">Dues Per</label>
														<ul class="list-unstyled">
															<li>
																<input type="radio" id="month" name="hoa_dues_per" value="month" data-error="#hoa_dues_per-error">
																<label for="month">Month</label>
															</li>
															<li>
																<input type="radio" id="Quarter" value="quarter" name="hoa_dues_per">
																<label for="Quarter">Quarter</label>
															</li>
															<li>
																<input type="radio" id="Semi-Annually" value="semi-annually" name="hoa_dues_per">
																<label for="Semi-Annually">Semi-Annually</label>
															</li>
															<li>
																<input type="radio" id="Annually" value="annually" name="hoa_dues_per">
																<label for="Annually">Annually</label>
															</li>
														</ul>
														<label id="hoa_dues_per-error" class="error text-danger" for="hoa_dues_per"></label>
													</div>
												</div>
											</div>
											<div class="form-group mb-3">
												<label for="" class="mb-2">Notes:</label>
												<input type="text" class="form-control" id="hoa_notes" name="hoa_notes" data-error="#hoa_notes-error">
												<label id="hoa_notes-error" class="error text-danger" for="hoa_notes"></label>
											</div>
											

											<div class="form-group mb-4">
												<label for="" class="mb-2"><b>Does the property have a 2nd Home Owner's
														Association? <span>*</span></b></label>
												<ul class="list-inline">
													<li class="list-inline-item me-md-5">
														<input type="radio" id="yesHOA2" value="yes" name="is_property_second_hoa" data-error="#is_property_second_hoa-error">
														<label for="yesHOA2">Yes</label>
													</li>
													<li class="list-inline-item">
														<input type="radio" id="noHOA2" value="no" name="is_property_second_hoa">
														<label for="noHOA2">No</label>
													</li>
												</ul>
												<label id="is_property_second_hoa-error" class="error text-danger" for="is_property_second_hoa"></label>
											</div>

											<div class="homeOwner2 d-none">
												<h3 class="mb-4 text-center"><b>2nd Homeowners Association Management Information:</b></h3>
												<div class="row">
													<div class="col-md-6 mb-3">
														<div class="form-group">
															<label for="" class="mb-2">Name of 2nd Management Company:</label>
															<input type="text" class="form-control" id="second_hoa_management_company_name" name="second_hoa_management_company_name" data-error="#second_hoa_management_company_name-error">
														</div>
														<label id="second_hoa_management_company_name-error" class="error text-danger" for="second_hoa_management_company_name"></label>
													</div>
													<div class="col-md-6 mb-3">
														<div class="form-group">
															<label for="" class="mb-2">Contact Person:</label>
															<input type="text" class="form-control" id="second_hoa_contact_person" name="second_hoa_contact_person" data-error="#second_hoa_contact_person-error">
														</div>
														<label id="second_hoa_contact_person-error" class="error text-danger" for="second_hoa_contact_person"></label>
													</div>
												</div>
												<div class="row">
													<div class="col-md-6 mb-3">
														<div class="form-group position-relative">
															<label for="" class="mb-2">Email:</label>
															<input type="text" class="form-control" id="second_hoa_email" name="second_hoa_email" data-error="#second_hoa_email-error">
															<small class="small_label">example@example.com</small>
														</div>
														<label id="second_hoa_email-error" class="error text-danger error2" for="second_hoa_email"></label>
													</div>
													<div class="col-md-6 mb-3">
														<div class="form-group">
															<label for="" class="mb-2">Phone:</label>
															<input type="text" class="form-control" id="second_hoa_phone" name="second_hoa_phone" data-error="#second_hoa_phone-error">
														</div>
														<label id="second_hoa_phone-error" class="error text-danger" for="second_hoa_phone"></label>
													</div>
												</div>
												<div class="row">
													<div class="col-md-6 mb-3">
														<div class="form-group">
															<label for="" class="mb-2">2nd HOA Dues:</label>
															<input type="text" class="form-control" id="second_hoa_dues" name="second_hoa_dues" data-error="#second_hoa_dues-error">
														</div>
														<label id="second_hoa_dues-error" class="error text-danger" for="second_hoa_dues"></label>
													</div>
													<div class="col-md-6 mb-3">
														<div class="form-group">
															<label for="" class="mb-2">Dues Per</label>
															<ul class="list-unstyled">
																<li>
																	<input type="radio" id="month" name="second_hoa_dues_per" value="month" data-error="#second_hoa_dues_per-error">
																	<label for="month">Month</label>
																</li>
																<li>
																	<input type="radio" id="Quarter" name="second_hoa_dues_per" value="quarter">
																	<label for="Quarter">Quarter</label>
																</li>
																<li>
																	<input type="radio" id="Semi-Annually" name="second_hoa_dues_per" value="semi-annually">
																	<label for="Semi-Annually">Semi-Annually</label>
																</li>
																<li>
																	<input type="radio" id="Annually" name="second_hoa_dues_per" value="annually">
																	<label for="Annually">Annually</label>
																</li>
															</ul>
															<label id="second_hoa_dues_per-error" class="error text-danger" for="second_hoa_dues_per"></label>
														</div>
													</div>
												</div>
												<div class="form-group mb-3">
													<label for="" class="mb-2">2nd Notes:</label>
													<input type="text" class="form-control" id="second_hoa_notes" name="second_hoa_notes" data-error="#second_hoa_notes-error">
													<label id="second_hoa_notes-error" class="error text-danger" for="second_hoa_notes"></label>
												</div>
												
											</div>

										</div>

										<div class="border p-3">
											* OUR STATE LAW PROHIBITS THE DISBURSEMENT OF CLOSING FUNDS PRIOR TO THE
											RECORDING OF THE DEED AND BUYER’S DEED OF TRUST. TITLE COMPANY NAME MAKES
											EVERY EFFORT TO EXPEDITE CLOSING AND RECORDING. PARTIES WILL BE NOTIFIED
											WHEN CLOSING DISBURSEMENTS ARE AVAILABLE. PARTIES WHO REQUEST FUNDS TO BE
											WIRED WILL INCUR A $25.00 WIRE FEE, WHICH IS DEDUCTED FROM WIRED FUNDS, AND
											MUST PROVIDE TITLE COMPANY NAME A VOIDED CHECK BEARING THE NAMES OF ALL
											PARTIES ENTITLED TO THE FUNDS, THE ACCOUNT NUMBER, AND BANK ROUTING NUMBER.
										</div>


									</div>
								</div>
							</div>
							<div class="accordion-item">
								<h2 class="accordion-header" id="headingTen">
									<button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
										data-bs-target="#collapseTen" aria-expanded="false" aria-controls="collapseTen">
										(9) Seller Closing Day??
									</button>
								</h2>
								<div id="collapseTen" class="accordion-collapse collapse" aria-labelledby="headingTen"
									data-bs-parent="#accordionExample">
									<div class="accordion-body">
										<p class="mb-4">Please have the following information and tangible items ready
											for the day of closing.</p>

										<ul>
											<li>
												<b>Non-Expired Photo Identification</b>
												<ul>
													<li>
														Please make sure you have a valid form of photo identification
														whether it is a driver’s license, passport or government issued
														identification. If any form of Identification that you choose is
														expired, you will not be able to sign your closing documents and
														it will result in a delay in closing. Additionally, we can not
														accept temporary drivers licenses.
													</li>
												</ul>
											</li>
											<li>
												<b>
													Wiring Instructions
												</b>
												<ul>
													<li>
														Please bring your wiring instructions (i.e. void check) or
														mailing address (cannot be a P.O. Box) for proceeds to closing.
													</li>
												</ul>
											</li>
											<li>
												<b>
													Spousal Attendance
												</b>
												<ul>
													<li>
														Spouse must attend closing, whether they are listed on the deed
														or not.
													</li>
												</ul>
											</li>
											<li>
												<b>
													Proceeds
												</b>
												<ul>
													<li>
														Proceeds will <b>NOT</b> be disbursed at the table.
													</li>
												</ul>
											</li>
										</ul>

										<img src="<?php echo base_url();?>assets/frontend/images/buyer-seller-package/sold.jpg"
											class="img-fluid d-block mx-auto my-5" alt="">



										<div class="form-group mb-2 d-flex">
											<input type="checkbox" id="readAgree" name="readAgree" class="me-2 mt-1" required data-error="#readAgree-error">
											<label for="readAgree" class="mb-2">I/We have read and agree to
												<span>*</span></label>
										</div>
										<label id="readAgree-error" class="error text-danger error2" for="readAgree"></label>
										<div class="border p-3">
											the above requirements for Closing Day.
										</div>

									</div>
								</div>
							</div>
						</div>

						<p class="my-4">
							Signing below indicates that the information included here is correct and complete to the
							best of my knowledge and ackowledges and accepts the information included in this document
						</p>
						<h4 class="text-orange text-center mb-5">
							You must click SUBMIT below to securely send your completed forms to<br> Pacific Coast Title
							Company.
						</h4>
						<div class="text-center"><button type="submit" class="btn btn-primary">Submit</button></div>
					</form>
				</div>
			</div>
		</div>
	</section>

	<script src="<?php echo base_url();?>assets/frontend/js/order/jquery.min.js"></script>
    <script src="<?php echo base_url();?>assets/frontend/js/jquery.validate.min.js"></script>
	<script src="<?php echo base_url();?>assets/frontend/js/order/bootstrap.bundle.min.js"></script>
	<script src="<?php echo base_url();?>assets/frontend/js/order/script.js?v=01"></script>
</body>

</html>
