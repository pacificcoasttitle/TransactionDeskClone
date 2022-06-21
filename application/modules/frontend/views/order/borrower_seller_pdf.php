<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body class="">
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
	<section class="form_content">
		<div class="container">
			<div class="row">
				<div class="col-md-12">
					<form action="" method="post" name="borrower_seller_form" id="borrower_seller_form">
						<h2 class="blue_title">Seller Opening Package<br><span
								style="font-size:16px; padding-top:15px;">Property Address: 13321 Success Ave, Success
								City, CA 91253</span><br><span
								style="font-size:16px; padding-top:15px;">APN:000-000-0000</span></h2>
						<div class="accordion mt-4" id="accordionExample">
							<div class="accordion-item">
								<h2 class="accordion-header" id="headingOne">
									<button class="accordion-button" type="button" data-bs-toggle="collapse"
										data-bs-target="#collapseOne" aria-expanded="true"
										aria-controls="collapseOne">(1) Seller Information</button>
								</h2>
								<div id="collapseOne" class="accordion-collapse collapse" aria-labelledby="headingOne"
									data-bs-parent="#accordionExample">
									<div class="accordion-body">

										<div class="form-group sellerName mb-5">
											<label for="" class="mb-2"><b>Seller's Name exactly as shown on your Drivers
													license or government issued ID: <span>*</span></b></label>
											<div class="row">
												<div class="col-md-4">
													<div class="form-group position-relative">
														<input type="text" class="form-control" id="first_name" name="first_name" value="<?php echo $first_name;?>">
														<small class="small_label">First Name</small>
													</div>
												</div>
												<div class="col-md-4">
													<div class="form-group position-relative">
														<input type="text" class="form-control" id="middle_name"
															name="middle_name" value="<?php echo $middle_name;?>">
														<small class="small_label">Middle Name</small>
													</div>
												</div>
												<div class="col-md-4">
													<div class="form-group position-relative">
														<input type="text" class="form-control" id="last_name"
															name="last_name" value="<?php echo $last_name;?>">
														<small class="small_label">Last Name</small>
													</div>
												</div>
											</div>
										</div>

										<div class="form-group mb-3">
											<div class="row">
												<div class="col-md-4">
													<div class="form-group position-relative">
														<label for="" class="mb-2"><b>Seller 1 Preferred Phone Number
														<span>*</span></b></label>
														<input type="text" class="form-control" id="phone_number" name="phone_number" value="<?php echo $phone_number;?>">
													</div>
												</div>
												<div class="col-md-4">
													<div class="form-group position-relative">
														<label for="" class="mb-2"><b>Phone number is
																<span>*</span></b></label>
														<ul class="list-unstyled">
															<li>
																<input type="radio" name="phone_number_type" value="Home" id="Home" <?php echo ($phone_number_type == 'Home') ? 'checked="checked"' : '';?>>
																<label for="Home">Home Number</label>
															</li>
															<li>
																<input type="radio" name="phone_number_type" value="Cell" id="Cell" <?php echo ($phone_number_type == 'Cell') ? 'checked="checked"' : '';?>>
																<label for="Cell">Cell</label>
															</li>
															<li>
																<input type="radio" name="phone_number_type" value="Business" id="Business" <?php echo ($phone_number_type == 'Business') ? 'checked="checked"' : '';?>>
																<label for="Business">Business Phone</label>
															</li>
														</ul>
													</div>
												</div>
											</div>
										</div>

										<div class="form-group mb-4">
											<label for="" class="mb-2"><b>Is Seller a citizen or resident of a foreign country? <span>*</span></b></label>
											<ul class="list-inline">
												<li class="list-inline-item me-md-5">
													<input type="radio" value="yes" id="foreignYes" name="foreign_resident" <?php echo ($foreign_resident == 'yes') ? 'checked="checked"' : '';?>>
													<label for="foreignYes">Yes</label>
												</li>
												<li class="list-inline-item">
													<input type="radio" value="no" id="foreignNo" name="foreign_resident" <?php echo ($foreign_resident == 'no') ? 'checked="checked"' : '';?>>
													<label for="foreignNo">No</label>
												</li>
											</ul>
										</div>


										<div class="form-group mb-4">
											<label for="" class="mb-2"><b>Is there a Co-Seller for this property?<span>*</span></b></label>
											<ul class="list-inline">
												<li class="list-inline-item me-md-5">
													<input type="radio" value="yes" id="coSellerYes" name="co_seller" <?php echo ($co_seller == 'yes') ? 'checked="checked"' : '';?>>
													<label for="coSellerYes">Yes</label>
												</li>
												<li class="list-inline-item">
													<input type="radio" value="no" id="coSellerNo" name="co_seller" <?php echo ($co_seller == 'no') ? 'checked="checked"' : '';?>>
													<label for="coSellerNo">No</label>
												</li>
											</ul>
										</div>

										<div class="coSellerInfo <?php echo ($co_seller == 'yes') ? '' : 'd-none';?>">
											<div class="form-group sellerName mb-5">
												<label for="" class="mb-2"><b>Spouse/Co-Seller's Name exactly as shown
														on their Driver's License or other government issued ID:
														<span>*</span></b></label>
												<div class="row">
													<div class="col-md-4">
														<div class="form-group position-relative">
															<input type="text" class="form-control" id="co_seller_first_name" name="co_seller_first_name" value="<?php echo $co_seller_first_name;?>">
															<small class="small_label">First Name</small>
														</div>
													</div>
													
													<div class="col-md-4">
														<div class="form-group position-relative">
															<input type="text" class="form-control" id="co_seller_middle_name" name="co_seller_middle_name" value="<?php echo $co_seller_middle_name;?>">
															<small class="small_label">Middle Name</small>
														</div>
													</div>
													
													<div class="col-md-4">
														<div class="form-group position-relative">
															<input type="text" class="form-control" id="co_seller_last_name" name="co_seller_last_name" value="<?php echo $co_seller_last_name;?>">
															<small class="small_label">Last Name</small>
														</div>
													</div>
													
												</div>
											</div>

											<div class="form-group position-relative mb-5 row">
												<label for="" class="mb-2 col-md-12"><b>Expiration Date of their
														Driver's License or other government issued ID:
														<span>*</span></b></label>
												<div class="col-md-4">
													<div class="form-group position-relative">
														<input type="date" class="form-control" id="co_seller_expiration_date" name="co_seller_expiration_date" value="<?php echo $co_seller_expiration_date;?>">
														<small class="small_label">Date</small>
													</div>
												</div>
											</div>

											<div class="form-group mb-3 row">
												<label for="" class="mb-2 col-md-12"><b>Marital Status
														<span>*</span></b></label>
												<ul class="list-unstyled">
													<li>
														<input type="radio" value="single" id="singlecoSeller" name="co_seller_marital_status" <?php echo ($co_seller_marital_status == 'single') ? 'checked="checked"' : '';?>>
														<label for="singlecoSeller">Single</label>
													</li>
													<li>
														<input type="radio" value="married" id="marriedcoSeller" name="co_seller_marital_status" <?php echo ($co_seller_marital_status == 'married') ? 'checked="checked"' : '';?>>
														<label for="marriedcoSeller">Married</label>
													</li>
												</ul>
											</div>

											<div class="form-group mb-4 row">
												<label for="" class="mb-2 col-md-12"><b>Seller's Social Security/Tax ID:<span>*</span></b></label>
												<div class="col-md-4">
													<input type="text" class="form-control" id="co_seller_ssn" name="co_seller_ssn" value="<?php echo $co_seller_ssn;?>">
												</div>
											</div>

											<div class="form-group position-relative mb-5 row">
												<label for="" class="mb-2 col-md-12"><b>Email</b></label>
												<div class="col-md-6">
													<div class="form-group position-relative">
														<input type="email" class="form-control" id="co_seller_email" name="co_seller_email" value="<?php echo $co_seller_email;?>">
														<small class="small_label"> example@example.com</small>
													</div>
												</div>
											</div>

											<div class="form-group mb-3">
												<div class="row">
													<div class="col-md-4">
														<div class="form-group position-relative">
															<label for="" class="mb-2"><b>Preferred Phone Number
																	<span>*</span></b></label>
															<input type="text" class="form-control" id="co_seller_phone_number" name="co_seller_phone_number" value="<?php echo $co_seller_phone_number;?>">
														</div>
													</div>
													<div class="col-md-4">
														<div class="form-group position-relative">
															<label for="" class="mb-2"><b>Phone number is
																	<span>*</span></b></label>
															<ul class="list-unstyled">
																<li>
																	<input type="radio" name="co_seller_phone_number_type" value="Home" id="HomecoSeller" <?php echo ($co_seller_phone_number_type == 'Home') ? 'checked="checked"' : '';?>>
																	<label for="HomecoSeller">Home Number</label>
																</li>
																<li>
																	<input type="radio" name="co_seller_phone_number_type" value="Cell" id="CellcoSeller" <?php echo ($co_seller_phone_number_type == 'Cell') ? 'checked="checked"' : '';?>>
																	<label for="CellcoSeller">Cell</label>
																</li>
																<li>
																	<input type="radio" name="co_seller_phone_number_type" value="Business" id="BusinesscoSeller" <?php echo ($co_seller_phone_number_type == 'Business') ? 'checked="checked"' : '';?>>
																	<label for="BusinesscoSeller">Business Phone</label>
																</li>
															</ul>
														</div>
													</div>
												</div>
											</div>

											<div class="form-group mb-4">
												<label for="" class="mb-2"><b>Is Seller a citizen or resident of a
														foreign country? * <span>*</span></b></label>
												<ul class="list-inline">
													<li class="list-inline-item me-md-5">
														<input type="radio" value="yes" id="coSellerforeignYes" name="co_seller_foreign_resident" <?php echo ($co_seller_foreign_resident == 'yes') ? 'checked="checked"' : '';?>>
														<label for="coSellerforeignYes">Yes</label>
													</li>
													<li class="list-inline-item">
														<input type="radio" value="no" id="coSellerforeignNo" name="co_seller_foreign_resident" <?php echo ($co_seller_foreign_resident == 'no') ? 'checked="checked"' : '';?>>
														<label for="coSellerforeignNo">No</label>
													</li>
												</ul>
											</div>
										</div>

										<div class="form-group mb-4">
											<label for="" class="mb-2"><b>I/We will be attending closing
													<span>*</span></b></label>
											<ul class="list-inline">
												<li class="list-inline-item me-md-5">
													<input type="radio" value="yes" id="attendingYes" name="attending" <?php echo ($attending == 'yes') ? 'checked="checked"' : '';?>>
													<label for="attendingYes">Yes</label>
												</li>
												<li class="list-inline-item">
													<input type="radio" value="no" id="attendingNo" name="attending" <?php echo ($attending == 'no') ? 'checked="checked"' : '';?>>
													<label for="attendingNo">No</label>
												</li>
											</ul>
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
											<input type="text" class="form-control" name="property_address" id="property_address" value="<?php echo $property_address;?>">
										</div>
										<div class="form-group mb-4">
											<label for="" class="mb-2"><b>Is the above address the correct address of
													the property being sold? <span>*</span></b></label>
											<ul class="list-inline">
												<li class="list-inline-item me-md-5">
													<input type="radio" id="yesCorrectPropertyAddress" value="yes" name="is_correct_property_address" <?php echo ($is_correct_property_address == 'yes') ? 'checked="checked"' : '';?>>
													<label for="yesCorrect">Yes</label>
												</li>
												<li class="list-inline-item">
													<input type="radio" id="noCorrectPropertyAddress" value="no" name="is_correct_property_address" <?php echo ($is_correct_property_address == 'no') ? 'checked="checked"' : '';?>>
													<label for="noCorrect">No</label>
												</li>
											</ul>
											<div class="otherAddress <?php echo ($is_correct_property_address == 'no') ? '' : 'd-none';?>">
												<div class="form-group position-relative mb-3">
													<label for="" class="mb-2"><b>Enter the property address being sold
															<span>*</span> </b></label>
													<div class="form-group position-relative">
														<input type="text" class="form-control" id="property_street_address" name="property_street_address" value="<?php echo $property_street_address;?>">
														<small class="small_label">Street Address</small>
													</div>
												</div>
												<div class="row">
													<div class="col-md-6">
														<div class="form-group position-relative mb-3">
															<input type="text" class="form-control" id="property_city" name="property_city" value="<?php echo $property_city;?>">
															<small class="small_label">City</small>
														</div>
													</div>
													<div class="col-md-6">
														<div class="form-group position-relative mb-3">
															<select class="form-control" id="property_state" name="property_state">
																<option value="CA" selected>CA</option>
															</select>
															<small class="small_label">State</small>
														</div>
													</div>
												</div>
												<div class="form-group position-relative mb-3 col-md-6">
													<input type="text" class="form-control" id="property_zip_code" name="property_zip_code" value="<?php echo $property_zip_code;?>">
													<small class="small_label">Zip Code</small>
												</div>
											</div>
										</div>
										<div class="form-group mb-4">
											<label for="" class="mb-2"><b>Is the Property Address above your current
													address? <span>*</span></b></label>
											<ul class="list-inline">
												<li class="list-inline-item me-md-5">
													<input type="radio" id="yesCorrectPropertyAddressAsCurrentAddress" value="yes" name="is_property_address_as_current_address" <?php echo ($is_property_address_as_current_address == 'yes') ? 'checked="checked"' : '';?>>
													<label for="yesCurrent">Yes</label>
												</li>
												<li class="list-inline-item">
													<input type="radio" id="noCorrectPropertyAddressAsCurrentAddress" value="no" name="is_property_address_as_current_address" <?php echo ($is_property_address_as_current_address == 'no') ? 'checked="checked"' : '';?>>
													<label for="noCurrent">No</label>
												</li>
											</ul>
											<div class="otherAddress <?php echo ($is_property_address_as_current_address == 'no') ? '' : 'd-none';?>">
												<div class="form-group position-relative mb-3">
													<label for="" class="mb-2"><b>Current Address
															<span>*</span> </b></label>
													<div class="form-group position-relative">
														<input type="text" class="form-control" id="current_street_address" name="current_street_address" value="<?php echo $current_street_address;?>">
														<small class="small_label">Street Address</small>
													</div>
												</div>
												<div class="row">
													<div class="col-md-6">
														<div class="form-group position-relative mb-3">
															<input type="text" class="form-control" id="current_city" name="current_city" value="<?php echo $current_city;?>">
															<small class="small_label">City</small>
														</div>
													</div>
													<div class="col-md-6">
														<div class="form-group position-relative mb-3">
															<select class="form-control" id="current_state" name="current_state">
																<option value="CA" selected>CA</option>
															</select>
															<small class="small_label">State</small>
														</div>
													</div>
												</div>
												<div class="form-group position-relative mb-3 col-md-6">
													<input type="text" class="form-control" id="current_zip_code" name="current_zip_code" value="<?php echo $current_zip_code;?>">
													<small class="small_label">Zip Code</small>
												</div>
											</div>
										</div>
										<div class="form-group mb-4">
											<label for="" class="mb-2"><b>Is your Forwarding Address different from your
													Current Address? <span>*</span></b></label>
											<ul class="list-inline">
												<li class="list-inline-item me-md-5">
													<input type="radio" id="yesForwarding" value="yes" name="is_forwarding_address_different_from_current_address" <?php echo ($is_forwarding_address_different_from_current_address == 'yes') ? 'checked="checked"' : '';?>>
													<label for="yesForwarding">Yes</label>
												</li>
												<li class="list-inline-item">
													<input type="radio" id="noForwarding" value="no" name="is_forwarding_address_different_from_current_address" <?php echo ($is_forwarding_address_different_from_current_address == 'no') ? 'checked="checked"' : '';?>>
													<label for="noForwarding">No</label>
												</li>
											</ul>
											<div class="otherAddress <?php echo ($is_forwarding_address_different_from_current_address == 'yes') ? '' : 'd-none';?>">
												<div class="form-group position-relative mb-3">
													<label for="" class="mb-2"><b>Forwarding Address<span>*</span> </b></label>
													<div class="form-group position-relative">
														<input type="text" class="form-control" id="forwarding_street_address" name="forwarding_street_address" value="<?php echo $forwarding_street_address;?>">
														<small class="small_label">Street Address</small>
													</div>
												</div>
												<div class="row">
													<div class="col-md-6">
														<div class="form-group position-relative mb-3">
															<input type="text" class="form-control" id="forwarding_city" name="forwarding_city" value="<?php echo $forwarding_city;?>">
															<small class="small_label">City</small>
														</div>
													</div>
													<div class="col-md-6">
														<div class="form-group position-relative mb-3">
															<select class="form-control" id="forwarding_state" name="forwarding_state">
																<option value="CA" selected>CA</option>
															</select>
															<small class="small_label">State</small>
														</div>
													</div>
												</div>
												<div class="form-group position-relative mb-3 col-md-6">
													<input type="text" class="form-control" id="forwarding_zip_code" name="forwarding_zip_code" value="<?php echo $forwarding_zip_code;?>">
													<small class="small_label">Zip Code</small>
												</div>
											</div>
										</div>

										<div class="form-group mb-4">
											<label for="" class="mb-2"><b>This property was our<span>*</span></b></label>
											<ul class="list-inline">
												<li class="list-inline-item me-md-5">
													<input type="radio" id="primary" value="primary" name="residence" <?php echo ($residence == 'primary') ? 'checked="checked"' : '';?>>
													<label for="primary">Primary Residence</label>
												</li>
												<li class="list-inline-item me-md-5">
													<input type="radio" id="secondary" value="secondary" name="residence" <?php echo ($residence == 'secondary') ? 'checked="checked"' : '';?>>
													<label for="secondary">Second Home</label>
												</li>
												<li class="list-inline-item">
													<input type="radio" id="investment" value="investment" name="residence" <?php echo ($residence == 'investment') ? 'checked="checked"' : '';?>>
													<label for="investment">Investment Property</label>
												</li>
											</ul>
										</div>

										<div class="form-group mb-4">
											<label for="" class="mb-2"><b>Do you have your title insurance policy from
													when you purchased the house? (It will save some time in doing your
													title search because we will tack to your current
													policy.)</b></label>
											<ul class="list-inline">
												<li class="list-inline-item me-md-5">
													<input type="radio" id="yesinsurance" value="yes" name="is_insurance_policy" <?php echo ($is_insurance_policy == 'yes') ? 'checked="checked"' : '';?>>
													<label for="yesinsurance">Yes</label>
												</li>
												<li class="list-inline-item">
													<input type="radio" id="noinsurance" value="no" name="is_insurance_policy" <?php echo ($is_insurance_policy == 'no') ? 'checked="checked"' : '';?>>
													<label for="noinsurance">No</label>
												</li>
											</ul>
											<div class="insurance_policy_file_name d-none mb-4">
												<input type="file" name="insurance_policy_file_name" class="d-none" id="insurance_policy_file_name">
												<label for="insurance_policy_file_name">
													<b>Please upload your prior title insurance policy</b>
													<span>Browse Files</span>
												</label>
											</div>
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
													<input type="radio" id="yesRealEstate" value="yes" name="is_real_estate" <?php echo ($is_real_estate == 'yes') ? 'checked="checked"' : '';?>>
													<label for="yesRealEstate">Yes</label>
												</li>
												<li class="list-inline-item">
													<input type="radio" id="noRealEstate" value="no" name="is_real_estate" <?php echo ($is_real_estate == 'no') ? 'checked="checked"' : '';?>>
													<label for="noRealEstate">No</label>
												</li>
											</ul>
										</div>

										<div class="RealEstateInfo <?php echo ($is_real_estate == 'yes') ? '' : 'd-none';?>">
											<h3 class="text-center"><b>Real Estate Agent Information:</b></h3>
											<hr>
											<div class="form-group sellerName mb-5">
												<label for="" class="mb-2"><b>Seller Agent's Name
														<span>*</span></b></label>
												<div class="row">
													<div class="col-md-4">
														<div class="form-group position-relative">
															<input type="text" class="form-control" id="agent_first_name" name="agent_first_name" value="<?php echo $agent_first_name;?>">
															<small class="small_label">First Name</small>
														</div>
													</div>
													<div class="col-md-4">
														<div class="form-group position-relative">
															<input type="text" class="form-control" id="agent_middle_name" name="agent_middle_name" value="<?php echo $agent_middle_name;?>">
															<small class="small_label">Middle Name</small>
														</div>
													</div>
													<div class="col-md-4">
														<div class="form-group position-relative">
															<input type="text" class="form-control" id="agent_last_name" name="agent_last_name" value="<?php echo $agent_last_name;?>">
															<small class="small_label">Last Name</small>
														</div>
													</div>
												</div>
											</div>

											<div class="form-group row mb-4">
												<label for="" class="mb-2 col-12"><b>Agent's Company:<span>*</span></b></label>
												<div class="col-md-8">
													<input type="text" class="form-control" id="agent_company" name="agent_company" value="<?php echo $agent_company;?>">
												</div>
											</div>

											<div class="otherAddress mb-5">
												<div class="form-group position-relative mb-3">
													<label for="" class="mb-2"><b>Agent's Company Address </b></label>
													<div class="form-group position-relative">
														<input type="text" class="form-control" id="agent_company_address" name="agent_company_address" value="<?php echo $agent_company_address;?>">
														<small class="small_label">Street Address</small>
													</div>
												</div>
								
												<div class="row mb-3">
													<div class="col-md-6">
														<div class="form-group position-relative">
															<input type="text" class="form-control" id="agent_company_city" name="agent_company_city" value="<?php echo $agent_company_city;?>"> 
															<small class="small_label">City</small>
														</div>
													</div>
													
													<div class="col-md-6">
														<div class="form-group position-relative">
															<select name="state" class="form-control" id="agent_company_state" name="agent_company_state">
                                                                <option value="CA" selected>CA</option>
															</select>
															<small class="small_label">State</small>
														</div>
													</div>
												</div>
												<div class="form-group position-relative col-md-6">
													<input type="text" class="form-control" id="agent_company_zip_code" name="agent_company_zip_code" value="<?php echo $agent_company_zip_code;?>">
													<small class="small_label">Zip Code</small>
												</div>
											</div>

											<div class="row">
												<div class="col-md-6 mb-3">
													<div class="form-group">
														<label for=""><b>Amount/Percent of Commission:</b></label>
														<input type="text" class="form-control" id="amount_percent_commission" name="amount_percent_commission" value="<?php echo $amount_percent_commission;?>">
													</div>
												</div>
												<div class="col-md-6 mb-3">
													<div class="form-group">
														<label for=""><b>Amount of Any Deductions from Commission:
															</b></label>
														<input type="text" class="form-control" id="amount_deduction" name="amount_deduction" value="<?php echo $amount_deduction;?>">
													</div>
												</div>
												<div class="col-md-6 mb-3">
													<div class="form-group position-relative">
														<label for=""><b>Agent Phone</b></label>
														<input type="text" class="form-control"  id="agent_phone" name="agent_phone" value="<?php echo $agent_phone;?>">
														<small class="small_label">Cell Phone or Email is required</small>
													</div>
												</div>
											</div>

											<div class="form-group position-relative row mb-3">
												<label for="" class="mb-2 col-12"><b>Email<span></span></b></label>
												<div class="form-group position-relative col-md-8">
													<input type="text" class="form-control" id="agent_email" name="agent_email" value="<?php echo $agent_email;?>">
													<small class="small_label">Cell Phone or Email is required</small>
												</div>
											</div>
										</div>


										<div class="form-group mb-4">
											<label for="" class="mb-2"><b>Seller Will be Paying and providing invoices for</b></label>
											<ul class="list-unstyled">
												<li>
													<input type="checkbox" id="repair" value="repairs" name="seller_invoices[]" <?php echo (in_array('repairs', $seller_invoices)) ? 'checked="checked"' : '';?>>
													<label for="repair">Repairs</label>
												</li>
												<li>
													<input type="checkbox" id="warranty" value="warranty" name="seller_invoices[]" <?php echo (in_array('warranty', $seller_invoices)) ? 'checked="checked"' : '';?>>
													<label for="warranty">Home Warranty</label>
												</li>
												<li>
													<input type="checkbox" id="other" value="other" name="seller_invoices[]" <?php echo (in_array('other', $seller_invoices)) ? 'checked="checked"' : '';?>>
													<label for="other">Other</label>
												</li>
												<li>
													<input type="checkbox" id="none" value="none" name="seller_invoices[]" <?php echo (in_array('none', $seller_invoices)) ? 'checked="checked"' : '';?>>
													<label for="none"> None</label>
												</li>
											</ul>
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
													<input type="radio" id="yesmortgage" value="yes" name="is_mortgage" <?php echo ($is_mortgage == 'yes') ? 'checked="checked"' : '';?>>
													<label for="yesmortgage">Yes</label>
												</li>
												<li class="list-inline-item">
													<input type="radio" id="nomortgage" value="no" name="is_mortgage" <?php echo ($is_mortgage == 'no') ? 'checked="checked"' : '';?>>
													<label for="nomortgage">No</label>
												</li>
											</ul>
										</div>

										<div class="<?php echo ($is_mortgage == 'yes') ? '' : 'd-none';?>" id="mortgage">
											<div class="form-group mb-4">
												<label for="" class="mb-2"><b>Is this mortgage/loan a Line of Credit?</b></label>
												<ul class="list-inline">
													<li class="list-inline-item me-md-5">
														<input type="radio" id="yesCreditCard" value="yes" name="is_mortgage_credit" <?php echo ($is_mortgage_credit == 'yes') ? 'checked="checked"' : '';?>>
														<label for="yesCreditCard">Yes</label>
													</li>
													<li class="list-inline-item">
														<input type="radio" id="noCreditCard" value="no" name="is_mortgage_credit" <?php echo ($is_mortgage_credit == 'no') ? 'checked="checked"' : '';?>>
														<label for="noCreditCard">No</label>
													</li>
												</ul>
												<div class="form-group CreditCardLock <?php echo ($is_mortgage_credit == 'yes') ? '' : 'd-none';?> mb-4">
													<label for="" class="mb-2"><b>Do you want to close and lock this Line of Credit?</b></label>
													<ul class="list-inline">
														<li class="list-inline-item me-md-5">
															<input type="radio" id="yesCreditCardLock" value="yes" name="is_creditcard_lock" <?php echo ($is_creditcard_lock == 'yes') ? 'checked="checked"' : '';?>>
															<label for="yesCreditCardLock">Yes</label>
														</li>
														<li class="list-inline-item">
															<input type="radio" id="noCreditCardLock" value="no" name="is_creditcard_lock" <?php echo ($is_creditcard_lock == 'no') ? 'checked="checked"' : '';?>>
															<label for="noCreditCardLock">No</label>
														</li>
													</ul>
												</div>
											</div>
											<div class="form-group mb-4">
												<label for="" class="mb-2"><b>Lender/Mortgage Holder:</b></label>
												<input type="text" class="form-control" id="mortgage_holder" name="mortgage_holder" value="<?php echo $mortgage_holder;?>">
											</div>
											
											<div class="row">
												<div class="col-md-6 mb-4">
													<div class="form-group">
														<label for="" class="mb-2"><b>Original Loan Amount:</b></label>
														<input type="text" class="form-control" id="loan_amount" name="loan_amount" value="<?php echo $loan_amount;?>">
													</div>
												</div>
												<div class="col-md-6 mb-4">
													<div class="form-group">
														<label for="" class="mb-2"><b>Lender/Mortgage Holder Phone:</b></label>
														<input type="text" class="form-control" id="mortgage_phone" name="mortgage_phone" value="<?php echo $propmortgage_phoneerty_address;?>">
													</div>
												</div>
												<div class="col-md-6 mb-4">
													<div class="form-group">
														<label for="" class="mb-2"><b>Loan Number:</b></label>
														<input type="text" class="form-control" id="loan_number" name="loan_number" value="<?php echo $loan_number;?>">
													</div>
													
												</div>
												<div class="col-md-6 mb-4">
													<div class="form-group">
														<label for="" class="mb-2"><b>Approximate Loan
																Balance:</b></label>
														<input type="text" class="form-control" id="loan_balance" name="loan_balance" value="<?php echo $loan_balance;?>">
													</div>
													
												</div>
											</div>
											<div class="form-group mb-4">
												<label for="" class="mb-2"><b>Account Holder's Name:</b></label>
												<input type="text" class="form-control" id="account_holder_name" name="account_holder_name" value="<?php echo $account_holder_name;?>">
												
											</div>
									        
											<div class="form-group mb-3">
												<label for="" class="mb-2"><b>Is there a 2nd mortgage on the
														property?</b></label>
												<ul class="list-inline">
													<li class="list-inline-item me-md-5">
														<input type="radio" id="yesmortgage2" value="yes" name="is_second_mortgage" <?php echo ($is_second_mortgage == 'yes') ? 'checked="checked"' : '';?>>
														<label for="yesmortgage2">Yes</label>
													</li>
													<li class="list-inline-item">
														<input type="radio" id="nomortgage2" value="no" name="is_second_mortgage" <?php echo ($is_second_mortgage == 'no') ? 'checked="checked"' : '';?>>
														<label for="nomortgage2">No</label>
													</li>
												</ul>
												
												<div class="secondMortgage <?php echo ($is_second_mortgage == 'yes') ? '' : 'd-none';?>">
													<div class="form-group mb-4">
														<label for="" class="mb-2"><b>Is the 2nd mortgage a Line of
																Credit?</b></label>
														<ul class="list-inline">
															<li class="list-inline-item me-md-5">
																<input type="radio" id="yesCreditCard2" value="yes" name="is_second_mortgage_credit" <?php echo ($is_second_mortgage_credit == 'yes') ? 'checked="checked"' : '';?>>
																<label for="yesCreditCard2">Yes</label>
															</li>
															<li class="list-inline-item">
																<input type="radio" id="noCreditCard2" value="no" name="is_second_mortgage_credit" <?php echo ($is_second_mortgage_credit == 'no') ? 'checked="checked"' : '';?>>
																<label for="noCreditCard2">No</label>
															</li>
														</ul>
														
														<div class="form-group CreditCardLock <?php echo ($is_second_mortgage_credit == 'yes') ? '' : 'd-none';?> mb-4">
															<label for="" class="mb-2"><b>Do you want to close and lock this Line of Credit?</b></label>
															<ul class="list-inline">
																<li class="list-inline-item me-md-5">
																	<input type="radio" id="yesCreditCardLock2" value="yes" name="is_second_creditcard_lock" <?php echo ($is_second_creditcard_lock == 'yes') ? 'checked="checked"' : '';?>>
																	<label for="yesCreditCardLock2">Yes</label>
																</li>
																<li class="list-inline-item">
																	<input type="radio" id="noCreditCardLock2" value="no" name="is_second_creditcard_lock" <?php echo ($is_second_creditcard_lock == 'no') ? 'checked="checked"' : '';?>>
																	<label for="noCreditCardLock2">No</label>
																</li>
															</ul>
															
														</div>
													</div>
													<div class="form-group mb-4">
														<label for="" class="mb-2"><b>2nd Lender/Mortgage Holder:</b></label>
														<input type="text" class="form-control" id="second_mortgage_holder" name="second_mortgage_holder" value="<?php echo $second_mortgage_holder;?>">
														
													</div>
													<div class="row">
														<div class="col-md-6 mb-4">
															<div class="form-group">
																<label for="" class="mb-2"><b>2nd Original Loan Amount:</b></label>
																<input type="text" class="form-control" id="second_loan_amount" name="second_loan_amount" value="<?php echo $second_loan_amount;?>">
															</div>
															
														</div>
														<div class="col-md-6 mb-4">
															<div class="form-group">
																<label for="" class="mb-2"><b>2nd Lender/Mortgage Holder Phone:</b></label>
																<input type="text" class="form-control" id="second_mortgage_phone" name="second_mortgage_phone" value="<?php echo $second_mortgage_phone;?>">
															</div>
															
														</div>
														<div class="col-md-6 mb-4">
															<div class="form-group">
																<label for="" class="mb-2"><b>2nd Loan Number:</b></label>
																<input type="text" class="form-control" id="second_loan_number" name="second_loan_number" value="<?php echo $second_loan_number;?>">
															</div>
															
														</div>
														<div class="col-md-6 mb-4">
															<div class="form-group">
																<label for="" class="mb-2"><b> 2nd Approximate Loan
																		Balance:</b></label>
																<input type="text" class="form-control" id="second_loan_balance" name="second_loan_balance" value="<?php echo $second_loan_balance;?>">
															</div>
															
														</div>
													</div>
													<div class="form-group mb-4">
														<label for="" class="mb-2"><b>2nd Account Holder's Name:</b></label>
														<input type="text" class="form-control" id="second_account_holder_name" name="second_account_holder_name" value="<?php echo $second_account_holder_name;?>">
														
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
											<input type="checkbox" id="is_agree_593_c" name="is_agree_593_c" checked="checked">
											<label for="agree">I/We have read and agree to <span>*</span></label>
										</div>
										
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
															<input type="radio" id="exchangeeResidenceTrue" name="is_exchange_residence" value="true" <?php echo ($is_exchange_residence == 'true') ? 'checked="checked"' : '';?>>
															<label for="exchangeeResidenceTrue">True</label>
														</li>
														<li class="list-inline item me-md-5">
															<input type="radio" id="exchangeeResidenceFalse" value="false" name="is_exchange_residence" <?php echo ($is_exchange_residence == 'false') ? 'checked="checked"' : '';?>>
															<label for="exchangeeResidenceFalse">False</label>
														</li>
													</ul>
													
												</div>
											</li>
											<li>
												<div class="form-group mb-3">
													<label class="mb-2"><b>(2) I have not sold or exchanged another
															principle residence during the 2-year period ending on the
															date of the sale or exchange of the residence.</b></label>
													<ul class="list-inline">
														<li class="list-inline item me-md-5">
															<input type="radio" id="NotexchangeeResidenceTrue" name="is_not_exchange_residence" value="true" <?php echo ($is_not_exchange_residence == 'true') ? 'checked="checked"' : '';?>>
															<label for="NotexchangeeResidenceTrue">True</label>
														</li>
														<li class="list-inline item me-md-5">
															<input type="radio" id="NotexchangeeResidenceFalse" name="is_not_exchange_residence" value="false" <?php echo ($is_not_exchange_residence == 'false') ? 'checked="checked"' : '';?>>
															<label for="NotexchangeeResidenceFalse">False</label>
														</li>
													</ul>
													
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
															<input type="radio" id="formerSpouseTrue" name="is_former_spouse" value="true" <?php echo ($is_former_spouse == 'true') ? 'checked="checked"' : '';?>>
															<label for="formerSpouseTrue">True</label>
														</li>
														<li class="list-inline item me-md-5">
															<input type="radio" id="formerSpouseFalse" name="is_former_spouse" value="false" <?php echo ($is_former_spouse == 'false') ? 'checked="checked"' : '';?>>
															<label for="formerSpouseFalse">False</label>
														</li>
													</ul>
													
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
															<input type="radio" id="marriedTrue" name="is_married" value="true" <?php echo ($is_married == 'true') ? 'checked="checked"' : '';?>>
															<label for="marriedTrue">True</label>
														</li>
														<li class="list-inline item me-md-5">
															<input type="radio" id="marriedFalse" name="is_married" value="false" <?php echo ($is_married == 'false') ? 'checked="checked"' : '';?>>
															<label for="marriedFalse">False</label>
														</li>
													</ul>
													
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
															<input type="radio" id="periodTrue" name="is_period" value="true" <?php echo ($is_period == 'true') ? 'checked="checked"' : '';?>>
															<label for="periodTrue">True</label>
														</li>
														<li class="list-inline item me-md-5">
															<input type="radio" id="periodFalse" name="is_period" value="false" <?php echo ($is_period == 'false') ? 'checked="checked"' : '';?>>
															<label for="periodFalse">False</label>
														</li>
													</ul>
													
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
															<input type="radio" id="RevenueTrue" name="is_revenue"  value="true" <?php echo ($is_revenue == 'true') ? 'checked="checked"' : '';?>>
															<label for="RevenueTrue">True</label>
														</li>
														<li class="list-inline item me-md-5">
															<input type="radio" id="RevenueFalse" name="is_revenue" value="false" <?php echo ($is_revenue == 'false') ? 'checked="checked"' : '';?>>
															<label for="RevenueFalse">False</label>
														</li>
														<li class="list-inline item me-md-5">
															<input type="radio" id="RevenueNA" name="is_revenue" value="n/a" <?php echo ($is_revenue == 'n/a') ? 'checked="checked"' : '';?>>
															<label for="RevenueNA">N/A</label>
														</li>
													</ul>
													
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
													<input type="radio" id="attorney" value="no" name="is_attorney" <?php echo ($is_attorney == 'no') ? 'checked="checked"' : '';?>>
													<label for="attorney">I would like THIS ATTORNEY to prepare a deed
														and lien waiver for me pursuant to the understanding
														above.</label>
												</li>
												<li>
													<input type="radio" id="otherAttorney" value="yes" name="is_attorney" <?php echo ($is_attorney == 'yes') ? 'checked="checked"' : '';?>>
													<label for="otherAttorney">The following attorney will draft my deed
														and lien waiver and secure cancellation of all deeds of trust
														and other exceptions to title.</label>
												</li>
											</ul>
										</div>


										<div class="attorneyInfo <?php echo ($is_attorney == 'yes') ? '' : 'd-none';?>">
											<div class="row">
												<div class="col-md-6 mb-4">
													<div class="form-group">
														<label for="" class="mb-2"><b>Firm Name:</b></label>
														<input type="text" class="form-control" id="firm_name" name="firm_name" value="<?php echo $firm_name;?>">
													</div>
													
												</div>
												<div class="col-md-6 mb-4">
													<div class="form-group">
														<label for="" class="mb-2"><b>Phone Number:</b></label>
														<input type="text" class="form-control" id="firm_phone_number" name="firm_phone_number" value="<?php echo $firm_phone_number;?>">
													</div>
													
												</div>
											</div>
											<div class="row">
												<div class="col-md-4 mb-4">
													<div class="form-group">
														<label for="" class="mb-2"><b>Attorney Name:</b></label>
														<input type="text" class="form-control" id="attorney_name" name="attorney_name" value="<?php echo $attorney_name;?>">
													</div>
													
												</div>
												<div class="col-md-4 mb-4">
													<div class="form-group">
														<label for="" class="mb-2"><b>Attorney Phone No.:</b></label>
														<input type="text" class="form-control" id="attorney_phone_number" name="attorney_phone_number" value="<?php echo $attorney_phone_number;?>">
													</div>
													
												</div>
												<div class="col-md-4 mb-4">
													<div class="form-group position-relative">
														<label for="" class="mb-2"><b>Attorney Email:</b></label>
														<input type="text" class="form-control" id="attorney_email" name="attorney_email" value="<?php echo $attorney_email;?>">
														<small class="small_label">example@example.com</small>
													</div>
													
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
											<input type="checkbox" id="sign" name="sign" checked="checked">
											<label for="sign">My/Our Signature(s) below <span>*</span></label>
										</div>
										
										<div class="border p-3">
											CERTIFIES OUR RECEIPT, ACKNOWLEDGMENT, AND CONSENT TO THE TERMS OF OUR
											REPRESENTATION BY TITLE COMPANY NAME
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
											<input type="checkbox" id="agreementSign" name="agreementSign" class="me-2 mt-1" <?php echo ($agreementSign == 'on') ? 'checked="checked"' : '';?>>
											<label for="agreementSign" class="mb-2">By checking and signing below
												<span>*</span></label>
										</div>
										

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
													<input type="radio" id="yesHOA" value="yes" name="is_property_hoa" <?php echo ($is_property_hoa == 'yes') ? 'checked="checked"' : '';?>>
													<label for="yesHOA">Yes</label>
												</li>
												<li class="list-inline-item">
													<input type="radio" id="noHOA" value="no" name="is_property_hoa" <?php echo ($is_property_hoa == 'no') ? 'checked="checked"' : '';?>>
													<label for="noHOA">No</label>
												</li>
											</ul>
											
										</div>

										<div class="homeOwner <?php echo ($is_property_hoa == 'yes') ? '' : 'd-none';?>">
											<h3 class="mb-4 text-center"><b>Homeowners Association Management
													Information:</b></h3>

											<div class="row">
												<div class="col-md-6 mb-3">
													<div class="form-group">
														<label for="" class="mb-2">Name of Management Company:</label>
														<input type="text" class="form-control" id="hoa_management_company_name" name="hoa_management_company_name" value="<?php echo $hoa_management_company_name;?>">
													</div>
													
												</div>
												<div class="col-md-6 mb-3">
													<div class="form-group">
														<label for="" class="mb-2">Contact Person:</label>
														<input type="text" class="form-control" id="hoa_contact_person" name="hoa_contact_person" value="<?php echo $hoa_contact_person;?>">
													</div>
													
												</div>
											</div>
											<div class="row">
												<div class="col-md-6 mb-3">
													<div class="form-group position-relative">
														<label for="" class="mb-2">Email:</label>
														<input type="text" class="form-control" id="hoa_email" name="hoa_email" value="<?php echo $hoa_email;?>">
														<small class="small_label">example@example.com</small>
													</div>
													
												</div>
												<div class="col-md-6 mb-3">
													<div class="form-group">
														<label for="" class="mb-2">Phone:</label>
														<input type="text" class="form-control" id="hoa_phone" name="hoa_phone" value="<?php echo $hoa_phone;?>">
													</div>
													
												</div>
											</div>
											<div class="row">
												<div class="col-md-6 mb-3">
													<div class="form-group">
														<label for="" class="mb-2">HOA Dues:</label>
														<input type="text" class="form-control" id="hoa_dues" name="hoa_dues" value="<?php echo $hoa_dues;?>">
													</div>
													
												</div>
												<div class="col-md-6 mb-3">
													<div class="form-group">
														<label for="" class="mb-2">Dues Per</label>
														<ul class="list-unstyled">
															<li>
																<input type="radio" id="month" name="hoa_dues_per" value="month" <?php echo ($hoa_dues_per == 'month') ? 'checked="checked"' : '';?>>
																<label for="month">Month</label>
															</li>
															<li>
																<input type="radio" id="Quarter" value="quarter" name="hoa_dues_per" <?php echo ($hoa_dues_per == 'quarter') ? 'checked="checked"' : '';?>>
																<label for="Quarter">Quarter</label>
															</li>
															<li>
																<input type="radio" id="Semi-Annually" value="semi-annually" name="hoa_dues_per" <?php echo ($hoa_dues_per == 'semi-annually') ? 'checked="checked"' : '';?>>
																<label for="Semi-Annually">Semi-Annually</label>
															</li>
															<li>
																<input type="radio" id="Annually" value="annually" name="hoa_dues_per" <?php echo ($hoa_dues_per == 'annually') ? 'checked="checked"' : '';?>>
																<label for="Annually">Annually</label>
															</li>
														</ul>
														
													</div>
												</div>
											</div>
											<div class="form-group mb-3">
												<label for="" class="mb-2">Notes:</label>
												<input type="text" class="form-control" id="hoa_notes" name="hoa_notes" value="<?php echo $hoa_notes;?>">
												
											</div>
											

											<div class="form-group mb-4">
												<label for="" class="mb-2"><b>Does the property have a 2nd Home Owner's
														Association? <span>*</span></b></label>
												<ul class="list-inline">
													<li class="list-inline-item me-md-5">
														<input type="radio" id="yesHOA2" value="yes" name="is_property_second_hoa" <?php echo ($is_property_second_hoa == 'yes') ? 'checked="checked"' : '';?>>
														<label for="yesHOA2">Yes</label>
													</li>
													<li class="list-inline-item">
														<input type="radio" id="noHOA2" value="no" name="is_property_second_hoa" <?php echo ($is_property_second_hoa == 'no') ? 'checked="checked"' : '';?>>
														<label for="noHOA2">No</label>
													</li>
												</ul>
												
											</div>

											<div class="homeOwner2 <?php echo ($is_property_second_hoa == 'yes') ? '' : 'd-none';?>">
												<h3 class="mb-4 text-center"><b>2nd Homeowners Association Management Information:</b></h3>
												<div class="row">
													<div class="col-md-6 mb-3">
														<div class="form-group">
															<label for="" class="mb-2">Name of 2nd Management Company:</label>
															<input type="text" class="form-control" id="second_hoa_management_company_name" name="second_hoa_management_company_name" value="<?php echo $second_hoa_management_company_name;?>">
														</div>
														
													</div>
													<div class="col-md-6 mb-3">
														<div class="form-group">
															<label for="" class="mb-2">Contact Person:</label>
															<input type="text" class="form-control" id="second_hoa_contact_person" name="second_hoa_contact_person" value="<?php echo $second_hoa_contact_person;?>">
														</div>
														
													</div>
												</div>
												<div class="row">
													<div class="col-md-6 mb-3">
														<div class="form-group position-relative">
															<label for="" class="mb-2">Email:</label>
															<input type="text" class="form-control" id="second_hoa_email" name="second_hoa_email" value="<?php echo $second_hoa_email;?>">
															<small class="small_label">example@example.com</small>
														</div>
														
													</div>
													<div class="col-md-6 mb-3">
														<div class="form-group">
															<label for="" class="mb-2">Phone:</label>
															<input type="text" class="form-control" id="second_hoa_phone" name="second_hoa_phone" value="<?php echo $second_hoa_phone;?>">
														</div>
														
													</div>
												</div>
												<div class="row">
													<div class="col-md-6 mb-3">
														<div class="form-group">
															<label for="" class="mb-2">2nd HOA Dues:</label>
															<input type="text" class="form-control" id="second_hoa_dues" name="second_hoa_dues" value="<?php echo $second_hoa_dues;?>">
														</div>
														
													</div>
													<div class="col-md-6 mb-3">
														<div class="form-group">
															<label for="" class="mb-2">Dues Per</label>
															<ul class="list-unstyled">
																<li>
																	<input type="radio" id="month" name="second_hoa_dues_per" value="month" <?php echo ($second_hoa_dues_per == 'month') ? 'checked="checked"' : '';?>>
																	<label for="month">Month</label>
																</li>
																<li>
																	<input type="radio" id="Quarter" name="second_hoa_dues_per" value="quarter" <?php echo ($second_hoa_dues_per == 'quarter') ? 'checked="checked"' : '';?>>
																	<label for="Quarter">Quarter</label>
																</li>
																<li>
																	<input type="radio" id="Semi-Annually" name="second_hoa_dues_per" value="semi-annually" <?php echo ($second_hoa_dues_per == 'semi-annually') ? 'checked="checked"' : '';?>>
																	<label for="Semi-Annually">Semi-Annually</label>
																</li>
																<li>
																	<input type="radio" id="Annually" name="second_hoa_dues_per" value="annually" <?php echo ($second_hoa_dues_per == 'annually') ? 'checked="checked"' : '';?>>
																	<label for="Annually">Annually</label>
																</li>
															</ul>
															
														</div>
													</div>
												</div>
												<div class="form-group mb-3">
													<label for="" class="mb-2">2nd Notes:</label>
													<input type="text" class="form-control" id="second_hoa_notes" name="second_hoa_notes" value="<?php echo $second_hoa_notes;?>">
													
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
											<input type="checkbox" id="readAgree" name="readAgree" class="me-2 mt-1" checked="checked">
											<label for="readAgree" class="mb-2">I/We have read and agree to
												<span>*</span></label>
										</div>
										<div class="border p-3">
											the above requirements for Closing Day.
										</div>

									</div>
								</div>
							</div>
						</div>

						
					</form>
				</div>
			</div>
		</div>
	</section>

	<script src="<?php echo base_url();?>assets/frontend/js/order/jquery.min.js"></script>
    <script src="<?php echo base_url();?>assets/frontend/js/jquery.validate.min.js"></script>
	<script src="<?php echo base_url();?>assets/frontend/js/order/bootstrap.bundle.min.js"></script>
	<script src="<?php echo base_url();?>assets/frontend/js/order/script.js"></script>
</body>

</html>
