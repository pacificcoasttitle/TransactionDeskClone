<style>
	.typography-section__inner {
        margin-top: 67px;
        margin-left: 10%;
        margin-bottom: 0px !important;
    }

	.ui-autocomplete {
		max-height: 300px !important;
	} 

</style>

<body>
	<?php
        $this->load->view('layout/header_dashboard');
    ?>

	<section class="section-type-4a section-defaulta" style="padding-bottom:0px;">
		<div class="container">
			<div class="row">
				<div class="typography-section__inner">
					<h2 class="ui-title-block ui-title-block_light">Open Order Form</h2>
					<div class="ui-decor-1a bg-accent"></div>
					<h3 class="ui-title-block_light">Helping Get Your Transaction Started.</h3>
				</div>
				<div class="col-md-9">
					<div class="smart-wrap">
						<div class="smart-forms smart-container wrap-2">
							
							<!-- Start Form -->
							<form method="POST" id="smart-form" enctype="multipart/form-data">
								<div class="form-body">
									<div class="spacer-b30 spacer-t30">
										<div class="tagline"><span>Your Details (Will Be AutoFilled) </span></div>
										<!-- .tagline -->
									</div>
									<div class="frm-row">
										<div class="section colm colm12">
											<label class="field prepend-icon">
												<input value="" type="text"
													name="CompanyName" id="CompanyName" class="gui-input"
													placeholder="Company Name">
												<span class="field-icon"><i class="fa fa-user"></i></span>
											</label>
										</div><!-- end section -->
									</div>

									<div class="frm-row">
										<div class="section colm colm12">
											<label class="field prepend-icon">
												<input value=""
													type="email" name="OpenEmail" id="OpenEmail" class="gui-input"
													placeholder="Email address">
												<span class="field-icon"><i class="fa fa-envelope"></i></span>
											</label>
										</div>
									</div>

									<div class="frm-row">
										<div class="section colm colm6">
											<label class="field prepend-icon">
												<input value="" type="text"
													name="OpenName" id="OpenName" class="gui-input"
													placeholder=" First Name">
												<span class="field-icon"><i class="fa fa-user"></i></span>
												<input type="hidden" name="id" id="CustomerId"
													value="">
											</label>
										</div><!-- end section -->

										<div class="section colm colm6">
											<label class="field prepend-icon">
												<input value="" type="text"
													name="OpenLastName" id="OpenLastName" class="gui-input"
													placeholder="Last Name">
												<span class="field-icon"><i class="fa fa-user"></i></span>
											</label>
										</div><!-- end section -->
									</div><!-- end frm-row section -->

									<div class="frm-row">
										<div class="section colm colm6">
											<label class="field prepend-icon">
												<input value="" type="tel"
													name="Opentelephone" id="Opentelephone" class="gui-input"
													placeholder="Telephone">
												<span class="field-icon"><i class="fa fa-phone-square"></i></span>
											</label>
										</div><!-- end section -->
										<div class="section colm colm6">
											<label class="field prepend-icon">
												<input value=""
													type="text" name="StreetAddress" id="StreetAddress"
													class="gui-input" placeholder="Street Address">
												<span class="field-icon"><i class="fa fa-envelope"></i></span>
											</label>
										</div><!-- end section -->
									</div><!-- end frm-row section -->

									<div class="frm-row">
										<div class="section colm colm6">
											<label class="field prepend-icon">
												<input value="" type="text"
													name="City" id="City" class="gui-input" placeholder="City">
												<span class="field-icon"><i class="fa fa-user"></i></span>
											</label>
										</div><!-- end section -->

										<div class="section colm colm6">
											<label class="field prepend-icon">
												<input value="" type="text"
													name="Zipcode" id="Zipcode" class="gui-input" placeholder="Zipcode">
												<span class="field-icon"><i class="fa fa-envelope"></i></span>
											</label>
										</div><!-- end section -->
										<div class="section colm colm4" id="email-notification-section" style="display: none;">
											<div class="option-group field">
												<label class="option block spacer-t10">
													<input type="checkbox" name="email_notification"

													id="email-notification" value="">
													<span class="checkbox"></span> Email Notification
												</label>
											</div><!-- end .option-group section -->
										</div>

										
									</div>

									<div class="spacer-b30 spacer-t30">
										<div class="tagline">
											<span>Find Your Property</span>
										</div><!-- .tagline -->
									</div>

									<input type="hidden" name="property-state" id="property-state" value="">
									<input type="hidden" name="property-city" id="property-city" value="">
									<input type="hidden" name="neighbourhood" id="neighbourhood" value="">
									<input type="hidden" name="property-fips" id="property-fips" value="">
									<input type="hidden" name="property-full-address"
										id="property-full-address" value="">
									<input type="hidden" name="property-type" id="property-type" value="">
									<input type="hidden" name="property-zip" id="property-zip" value="">
									<input type="hidden" name="random_number" id="random_number" value="">
									<div id="address_container">
										<div class="frm-row">
											<div class="section colm colm12">
												<label class="field prepend-icon">
													<input type="text" name="Property" id="property-search"
														class="gui-input" placeholder="Property Address">
													<span class="field-icon"><i class="fa fa-user"></i></span>
												</label>
											</div>
										</div>

										<div class="frm-row">
											<div class="section colm colm3">
												<a class="button btn-primary search-property search-property-button"
													href="javascript:void(0);" id="search-btn">Property Search</a>
											</div>
											<div class="section colm colm4">
												<a class="button switch-apn-button search-property-button"
													href="javascript:void(0);" id="switch-apn-btn">Switch To APN Search</a>
											</div>
										</div>
									</div>

									<div id="apn_container" style="display:none;">
										<div class="frm-row">
											<div class="section colm colm6">
												<label class="field prepend-icon">
													<input type="text" name="apn_num" id="apn_num"
														class="gui-input" placeholder="APN">
													<span class="field-icon"><i class="fa fa-user"></i></span>
													
												</label>
											</div>

											<div class="section colm colm6">
												<label class="field prepend-icon">
													<input type="text" name="apn_county" id="apn_county"
														class="gui-input" placeholder="County">
													<span class="field-icon"><i class="fa fa-envelope"></i></span>
												</label>
											</div>
										</div>

										<div class="frm-row">
											<div class="section colm">
												<a class="button btn-primary search-apn search-apn-button"
													href="javascript:void(0);" id="search-apn-btn">APN Search</a>
											</div>
											<div class="section colm colm5">
												<a class="button switch-property-button search-apn-button"
													href="javascript:void(0);" id="switch-property-btn">Switch To Property Search</a>
											</div>
										</div>
									</div>

									<div class="pma-error alert alert-danger" style="display:none;"></div>
									<div class="search-loader hidden"></div>

									<div class="spacer-b30 spacer-t30">
										<div class="tagline"><span> Property Details (Will Be AutoFilled) </span></div>
									</div>

									<div class="frm-row">
										<div class="section colm colm12">
											<label class="field prepend-icon">
												<input type="text" name="FullProperty" id="FullProperty"
													class="gui-input" placeholder="Full Street Address">
												<span class="field-icon"><i class="fa fa-user"></i></span>
											</label>
										</div><!-- end section -->
									</div>

									<div class="frm-row">
										<div class="section colm colm6">
											<label class="field prepend-icon">
												<input type="text" name="apn" id="apn" class="gui-input"
													placeholder="APN">
												<span class="field-icon"><i class="fa fa-user"></i></span>
											</label>
										</div><!-- end section -->

										<div class="section colm colm6">
											<label class="field prepend-icon">
												<input type="text" name="County" id="County" class="gui-input"
													placeholder="County">
												<span class="field-icon"><i class="fa fa-envelope"></i></span>
											</label>
										</div><!-- end section -->
									</div>

									<div class="frm-row">
										<div class="section colm colm12">
											<label class="field prepend-icon">
												<input type="text" name="LegalDescription" id="LegalDescription"
													class="gui-input" placeholder="Brief Legal Desription">
												<span class="field-icon"><i class="fa fa-user"></i></span>
											</label>
										</div><!-- end section -->
									</div>

									<div class="spacer-b30 spacer-t30">
										<div class="tagline"><span>Seller Details (Will Be AutoFilled)</span></div>
										<!-- .tagline -->
									</div>

									<div class="frm-row">
										<div class="section colm colm12">
											<label class="field prepend-icon">
												<input type="text" name="PrimaryOwner" id="PrimaryOwner"
													class="gui-input" placeholder="Primary Owner">
												<span class="field-icon"><i class="fa fa-user"></i></span>
											</label>
										</div><!-- end section -->

										<div class="section colm colm12">
											<label class="field prepend-icon">
												<input type="text" name="SecondaryOwner" id="SecondaryOwner"
													class="gui-input" placeholder="Secondary Owner">
												<span class="field-icon"><i class="fa fa-user"></i></span>
											</label>
										</div><!-- end section -->
									</div>

									<div class="spacer-b30 spacer-t30">
										<div class="tagline"><span> Transaction Details </span></div><!-- .tagline -->
									</div>

									<div class="frm-row">
										<div class="section colm colm6">
											<label class="field select">
												<select id="SalesRep" name="SalesRep">
													<option value="">Sales Rep...</option>
													<?php
														if(isset($salesRep) && !empty($salesRep))
														{
															foreach ($salesRep as $k => $v) 
															{
													?>
																<option value="<?php
																 echo $v['id']; ?>"><?php
																 echo $v['name']; ?></option>
													<?php
															}
														} 
													?>
												</select>
												<i class="arrow double"></i>
											</label>
										</div><!-- end section -->

										<div class="section colm colm6">
											<label class="field select">
												<select id="TitleOfficer" name="TitleOfficer">
													<option value="">Title Officer</option>
													<?php 
													if(isset($titleOfficer) && !empty($titleOfficer))
													{
														foreach ($titleOfficer as $key => $value) 
														{
												?>
															<option value="<?php echo $value['id']; ?>"><?php echo $value['name']; ?></option>
												<?php
														}
													}
												?>
												</select>
												<i class="arrow double"></i>
											</label>
										</div><!-- end section -->
									</div><!-- end frm-row section -->

									<div class="frm-row">
										<!-- <div class="section colm colm6">
                                                    <label class="field select">
                                                        <select id="TransactionTypeID" name="TransactionTypeID">
                                                            <option value="">Select Transaction Type</option>
                                                            <option value="3">Residential</option>
                                                            <option value="2">Commercial</option>
                                                        </select>
                                                        <i class="arrow double"></i>
                                                    </label>
                                                </div> -->
										<div class="section colm colm12">
											<label class="field select">
												<input type="hidden" name="ProductType" id="ProductType">
												<select id="ProductTypeID" name="ProductTypeID">
													<option value="">Select Product</option>
												<?php
													if(isset($productType) && !empty($productType))
													{
														foreach ($productType as $key => $value) 
														{
												?>
															<option value="<?php echo $value['product_type_id']; ?>"><?php echo $value['display_name'];  ?></option>
												<?php
														}
													} 
												?>
												</select>
												<i class="arrow double"></i>
											</label>
										</div>
									</div>

									<div class="frm-row" id="sales-loan-amount-fields" style="display: none;">
										<div class="section colm colm12">
											<label class="field">
												<input type="text" class="gui-input" name="salesAmount" id="salesAmount"
													placeholder="Sales Amount">
											</label>
											<div class="spacer-b10"></div>
											<label class="field">
												<input type="text" class="gui-input" name="loanAmount" id="loanAmount"
													placeholder="Loan Amount">
											</label>
											
											<div class="spacer-b10"></div>
											<label class="field">
												<input type="text" class="gui-input" name="primaryBorrower" id="primaryBorrower"
													placeholder="Primary Borrower">
											</label>
											<div class="spacer-b10"></div>
											<label class="field">
												<input type="text" class="gui-input" name="secondaryBorrower" id="secondaryBorrower"
													placeholder="Secondary Borrower">
											</label>
										</div>
									</div>
									<label class="field">
										<input type="text" class="gui-input" name="escrowNumber" id="escrowNumber"
											placeholder="Escrow Number">
									</label>
									<div class="spacer-b10"></div>
									<label class="field">
										<input type="text" class="gui-input" name="loanNumber" id="loanNumber"
											placeholder="Loan Number">
									</label>
									<div class="section spacer-t20">
                                        <label class="field prepend-icon">
                                            <textarea class="gui-textarea" id="notes" name="notes" placeholder="Additional details"></textarea>
                                            <span class="field-icon"><i class="fa fa-comments"></i></span>        
                                        </label>
                                    </div>
									<div class="spacer-t30">
										<div class="tagline"><span> Special Instructions </span></div><!-- .tagline -->
									</div>
									<div class="frm-row">
										<div class="section colm colm4">
											<div class="option-group field">
												<label class="option block spacer-t10">
													<input type="checkbox" name="CCR" value="CCR's">
													<span class="checkbox"></span> CCR's
												</label>
											</div><!-- end .option-group section -->
										</div><!-- end .colm section -->

										<div class="section colm colm4">
											<div class="option-group field">
												<label class="option block spacer-t10">
													<input type="checkbox" name="Docs" value="Underlying Docs">
													<span class="checkbox"></span> Underlying Docs
												</label>
											</div><!-- end .option-group section -->
										</div><!-- end .colm section -->

										<div class="section colm colm4">
											<div class="option-group field">
												<label class="option block spacer-t10">
													<input type="checkbox" name="Ease" value="Plotted Easements">
													<span class="checkbox"></span> Plotted Easements
												</label>
											</div><!-- end .option-group section -->
										</div><!-- end .colm section -->
									</div>

									<!-- <div class="section spacer-t20">
                                                <label class="field prepend-icon">
                                                    <textarea class="gui-textarea" id="sendermessage" name="sendermessage" placeholder="Additional details"></textarea>
                                                    <span class="field-icon"><i class="fa fa-comments"></i></span>
                                                    <span class="input-hint"> <strong>NOTE:</strong> Be as detailed as possible for better feedback.</span>   
                                                </label>
                                            </div> -->
									<!-- end section -->
									<div class="spacer-b30 spacer-t30">
										<div class="tagline"><span>Add Deliverables</span></div>
										<!-- .tagline -->
									</div>

									<div class="frm-row">
										<div class="section colm colm12" id="clone-email-address">
											
										<div class="toclone clone-widget">
											<div class="spacer-b10">
												<label class="field">
													<input type="email" class="gui-input" name="AdditionalEmail"
														id="AdditionalEmail" placeholder="Email Address">
												</label>
											</div>
											<a href="#" class="clone button btn-primary"><i class="fa fa-plus"></i></a>
											<a href="#" class="delete button"><i class="fa fa-minus"></i></a>
										</div>
									
										</div><!-- end section -->

									</div>
									
									<!-- start agent details -->
									<div class="spacer-t30">
										<div class="tagline"><span> Add Parties</span></div><!-- .tagline -->
									</div>
									<div class="frm-row">
										<div class="section colm colm4">
											<div class="option-group field">
												<label class="option block spacer-t10">
													<input type="checkbox" name="add-agent-details"
														id="add-agent-details">
													<span class="checkbox"></span> Add Agent Details
												</label>
											</div><!-- end .option-group section -->
										</div><!-- end .colm section -->
										
										
										<div class="section colm colm4" id="add-lender-section" style="display: none;">
											<div class="option-group field">
												<label class="option block spacer-t10">
													<input type="checkbox" name="add-lender-details"
														id="add-lender-details">
													<span class="checkbox"></span> Add Lender
												</label>
											</div><!-- end .option-group section -->
										</div>
										
										
										<div class="section colm colm4" id="add-escrow-section" style="display: none;">
											<div class="option-group field">
												<label class="option block spacer-t10">
													<input type="checkbox" name="add-escrow-details"
														id="add-escrow-details">
													<span class="checkbox"></span> Add Escrow
												</label>
											</div><!-- end .option-group section -->
										</div>
									</div>

									<div id="agent-details-fields" style="display: none;">
										<div class="frm-row">
											<div class="spacer-b10"></div>
											<div class="section colm colm6 tagline">
												<span>
													Buyers Agent
												</span>
											</div><!-- end section -->
											<div class="section colm colm6 tagline">
												<span>
													Listing Agent
												</span>
											</div><!-- end section -->
										</div>
										<div class="frm-row">
											<div class="section colm colm6">
												<label class="field prepend-icon">
													<input type="text" name="BuyerAgentName" id="BuyerAgentName"
														class="gui-input" placeholder="Agent Name">
													<span class="field-icon"><i class="fa fa-user"></i></span>
													<input type="hidden" name="BuyerAgentId" id="BuyerAgentId" value="">
												</label>
											</div><!-- end section -->
											<div class="section colm colm6">
												<label class="field prepend-icon">
													<input type="text" name="ListingAgentName" id="ListingAgentName"
														class="gui-input" placeholder="Agent Name">
													<span class="field-icon"><i class="fa fa-user"></i></span>
													<input type="hidden" name="ListingAgentId" id="ListingAgentId"
														value="">
												</label>
											</div><!-- end section -->
										</div>

										<div class="frm-row">
											<div class="section colm colm6">
												<label class="field prepend-icon">
													<input type="email" name="BuyerAgentEmailAddress"
														id="BuyerAgentEmailAddress" class="gui-input"
														placeholder="Agent Email address">
													<span class="field-icon"><i class="fa fa-envelope"></i></span>
												</label>
											</div><!-- end section -->

											<div class="section colm colm6">
												<label class="field prepend-icon">
													<input type="email" name="ListingAgentEmailAddress"
														id="ListingAgentEmailAddress" class="gui-input"
														placeholder="Agent Email address">
													<span class="field-icon"><i class="fa fa-envelope"></i></span>
												</label>
											</div><!-- end section -->
										</div><!-- end frm-row section -->

										<div class="frm-row">
											<div class="section colm colm6">
												<label class="field prepend-icon">
													<input type="tel" name="BuyerAgentTelephone"
														id="BuyerAgentTelephone" class="gui-input"
														placeholder="Agent Telephone">
													<span class="field-icon"><i class="fa fa-phone-square"></i></span>
												</label>
											</div><!-- end section -->

											<div class="section colm colm6">
												<label class="field prepend-icon">
													<input type="tel" name="ListingAgentTelephone"
														id="ListingAgentTelephone" class="gui-input"
														placeholder="Agent Telephone">
													<span class="field-icon"><i class="fa fa-phone-square"></i></span>
												</label>
											</div><!-- end section -->
										</div><!-- end frm-row section -->
										<div class="frm-row">
											<div class="section colm colm6">
												<label class="field prepend-icon">
													<input type="text" name="BuyerAgentCompany" id="BuyerAgentCompany"
														class="gui-input" placeholder="Agent Company Name">
													<span class="field-icon"><i class="fa fa-user"></i></span>
												</label>
											</div><!-- end section -->
											<div class="section colm colm6">
												<label class="field prepend-icon">
													<input type="text" name="ListingAgentCompany"
														id="ListingAgentCompany" class="gui-input"
														placeholder="Agent Company Name">
													<span class="field-icon"><i class="fa fa-user"></i></span>
												</label>
											</div><!-- end section -->
										</div>
									</div>
									<!-- end agent details -->

									<!-- start lender details  -->

									<div id="lender-details-fields" style="display: none;">

										<div class="spacer-b30">
											<div class="tagline"><span> Add Lender Details</span></div><!-- .tagline -->
										</div>
										<div class="frm-row">
											<div class="section colm colm12">
												<label class="field prepend-icon">
													<input type="text" name="LenderCompany" id="LenderCompany"
														class="gui-input" placeholder="Lender Company Name">
													<span class="field-icon"><i class="fa fa-user"></i></span>
												</label>
											</div><!-- end section -->
										</div>
										<div class="frm-row">
											<div class="section colm colm12">
												<label class="field prepend-icon">
													<input type="text" name="LenderName" id="LenderName"
														class="gui-input" placeholder="Lender Name">
													<span class="field-icon"><i class="fa fa-user"></i></span>
													<input type="hidden" name="LenderId" id="LenderId" value="">
												</label>
											</div><!-- end section -->
										</div>

										<div class="frm-row">
											<div class="section colm colm6">
												<label class="field prepend-icon">
													<input type="email" name="LenderEmailAddress"
														id="LenderEmailAddress" class="gui-input"
														placeholder="Lender Email address">
													<span class="field-icon"><i class="fa fa-envelope"></i></span>
												</label>
											</div><!-- end section -->

											<div class="section colm colm6">
												<label class="field prepend-icon">
													<input type="tel" name="LenderTelephone" id="LenderTelephone"
														class="gui-input" placeholder="Lender Telephone">
													<span class="field-icon"><i class="fa fa-phone-square"></i></span>
												</label>
											</div><!-- end section -->
										</div><!-- end frm-row section -->
										


									</div>
									<!-- end lender details  -->

									<!-- start escrow details -->
									<div id="escrow-details-fields" style="display: none;">

										<div class="spacer-b30">
											<div class="tagline"><span> Add Escrow Details</span></div><!-- .tagline -->
										</div>
										<div class="frm-row">
											<div class="section colm colm12">
												<label class="field prepend-icon">
													<input type="text" name="EscrowCompany" id="EscrowCompany"
														class="gui-input" placeholder="Escrow Company Name">
													<span class="field-icon"><i class="fa fa-user"></i></span>
												</label>
											</div><!-- end section -->
										</div>
										<div class="frm-row">
											<div class="section colm colm12">
												<label class="field prepend-icon">
													<input type="text" name="EscrowName" id="EscrowName"
														class="gui-input" placeholder="Escrow Name">
													<span class="field-icon"><i class="fa fa-user"></i></span>
													<input type="hidden" name="EscrowId" id="EscrowId" value="">
												</label>
											</div><!-- end section -->
										</div>

										<div class="frm-row">
											<div class="section colm colm6">
												<label class="field prepend-icon">
													<input type="email" name="EscrowEmailAddress"
														id="EscrowEmailAddress" class="gui-input"
														placeholder="Escrow Email address">
													<span class="field-icon"><i class="fa fa-envelope"></i></span>
												</label>
											</div><!-- end section -->

											<div class="section colm colm6">
												<label class="field prepend-icon">
													<input type="tel" name="EscrowTelephone" id="EscrowTelephone"
														class="gui-input" placeholder="Escrow Telephone"
														readonly="readonly">
													<span class="field-icon"><i class="fa fa-phone-square"></i></span>
												</label>
											</div><!-- end section -->
										</div><!-- end frm-row section -->
										
									</div>
									<!-- end escrow details -->

									<div id="upload_lender" style="display: none;">
										<div class="spacer-b20 spacer-t30">
											<div class="tagline"><span> Upload Curative Document</span></div>
										</div>
										<div class="frm-row">
											<div class="section colm colm12" id="upload_1003">
												<div class="option-group field">
													<div class="spacer-t20">
														<label class="button btn-primary search-file-btn">
															<input name="upload_curative" id="upload_curative" type="file" style="display:None;"> <span>Upload 1003</span>
														</label>
														<span></span>
													</div>
												</div>
											</div>
										</div>
									</div>
									
									<div id="upload_escrow" style="display: none;">
										<div class="spacer-b20 spacer-t30">
											<div class="tagline"><span> Upload Curative Document</span></div>
										</div>
										<div class="frm-row">
											<div class="section colm colm12" id="upload_rpa">
												<div class="option-group field">
													<div class="spacer-t20">
														<label class="button btn-primary search-file-btn">
															<input name="upload_curative" id="upload_curative" type="file" style="display:None;"> <span>Upload RPA</span>
														</label>
														<span></span>
													</div>
												</div><!-- end .option-group section -->
											</div>
										</div>
									</div>
									

									<div class="result spacer-b10"></div><!-- end .result  section -->

									<!-- <div class="section progress-section">
                                                <div class="progress-bar progress-animated bar-primary">
                                                    <div class="bar"></div>
                                                    <div class="percent">0%</div>
                                                </div>
                                            </div> -->
									<!-- end progress section -->

									<div class='' id="progressDivId">
										<div class='' id='progressBar'></div>
										<div class='' id='percent'>0%</div>
									</div>
									<div style="height: 10px;"></div>

								</div><!-- end .form-body section -->
								<div class="form-footer">
									<button type="submit" data-btntext-sending="Sending..."
										class="button btn-primary">Submit</button>
									<button type="reset" class="button">Cancel</button>
									<a style="border: 0;height: 42px;color: #243140;line-height: 1;font-size: 15px;cursor: pointer;padding: 0 18px;text-align: center;vertical-align: top;background: #bdc3c7;display: inline-block;-webkit-user-drag: none;text-shadow: 0 1px rgba(255, 255, 255, 0.2);margin-right: 10px;margin-bottom: 5px;text-decoration: none;border-radius: 3px;padding-top: 13px;"
										href="http://www.pct.com">Homepage</a>
								</div>
							</form>
							<!-- End Form -->
						</div><!-- end .smart-forms section -->
					</div><!-- end .smart-wrap section -->
				</div>
				<div class="col-md-3">
					<section class="b-sm-about">
						<ul class="b-isotope-grid grid list-unstyled">
							<li class="grid-sizer"></li>
							<li style="margin-bottom:15px;" class="b-isotope-grid__item grid-item pctttb"><a
									class="b-isotope- lightbox" href="https://www.youtube.com/watch?v=ICczHNfT7cA"><img
										src="<?php echo base_url(); ?>assets/frontend/images/OpenOrderFormVideo.jpg"
										alt="foto"></a></li>
						</ul>
						<h3 class="b-sm-about__title">Video Tutorial - Smart Form</h3>
						<p>We have created a quick video that shows you how our smart open order form works.</p>
					</section>
				</div>
			</div>
		</div>
	</section>
	<!-- end .section-type-14-->
	<br><br>

	<?php
                $this->load->view('layout/footer_above_section');
        ?>
	<div class="modal fade" id="searchResultModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
		aria-hidden="true">
		<div class="modal-dialog modal-lg modal-dialog-centered" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h4 class="modal-title">Search Results</h4>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body search-result">
					<table class="table-search-results" width="100%">
						<thead>
							<tr>
								<th width="21%">APN</th>
								<th width="22%">Address</th>
								<!-- <th width="21%">County</th> -->
								<th width="21%">City</th>
								<th width="15%">Run Listing</th>
							</tr>
						</thead>
						<tbody></tbody>
					</table>
				</div>
				<div class="modal-footer">
					<div class="apn-search-loader hidden"></div>
				</div>
			</div>
		</div>
	</div>
	<!-- End Property search result Modal -->

	<!-- Start Find Customer Number Modal -->
	<div class="modal fade smart-forms" id="findCustomerModal" tabindex="-1" role="dialog"
		aria-labelledby="customerModalLabel" aria-hidden="true">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h4 class="modal-title">Find Customer Number</h4>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body search-result">
					<form method="POST" action="" id="find-customer-form">
						<div class="form-body">
							<div class="frm-row">
								<div class="section colm colm12">
									<label class="field prepend-icon">
										<input type="email" name="CustomerEmail" id="CustomerEmail" class="gui-input"
											placeholder="Email address">
										<span class="field-icon"><i class="fa fa-envelope"></i></span>
									</label>
								</div>
							</div>
						</div>

						<div class="find-customer-result"></div>
				</div>
				<div class="modal-footer">
					<button type="submit" class="button btn-primary">Submit</button>
					<button type="button" class="button btn-primary" data-dismiss="modal">Cancel</button>
				</div>
				</form>
			</div>
		</div>
	</div>
	<!-- End Find Customer Number Modal -->

	<!-- Start Show Customer Number Modal -->
	<div class="modal fade smart-forms" id="showCustomernumberModal" tabindex="-1" role="dialog"
		aria-labelledby="showCustomernumberModalLabel" aria-hidden="true">
		<div class="modal-dialog modal-dialog-centered" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h4 class="modal-title">Customer Number</h4>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body search-result">
					<div class="form-body">
						<div id="showCustomerNumber"></div>
					</div>
					<!-- <div class="find-customer-result"></div> -->
				</div>
				<div class="modal-footer">
					<button type="button" class="button btn-primary" data-dismiss="modal">Close</button>
				</div>
			</div>
		</div>
	</div>
	<!-- End Show Customer Number Modal -->
</body>

</html>
<?php
    $this->load->view('layout/footer');
?>

<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/frontend/css/smart-forms.css">
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/frontend/css/font-awesome.min.css">
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/frontend/css/jquery-ui.css">


<script type="text/javascript"
	src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCoMfJn9Q37LUYQucbUdgWF8JGWRuTZlt4&libraries=places&sensor=false">
</script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/frontend/js/jquery.form.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/frontend/js/jquery.validate.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/frontend/js/additional-methods.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/frontend/js/smart-form.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/frontend/js/custom.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/frontend/js/jquery-ui.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/frontend/js/order.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/frontend/js/jquery-cloneya.min.js"></script>

<script type="text/javascript">
	
	jQuery(document).ready(function ($) {

		$('#clone-email-address').cloneya({
			maximum: 3
		}).on('after_append.cloneya', function (event, toclone, newclone) {
			var name = $(newclone).find("input[type='email']").attr('id');
			$(newclone).find("input[type='email']").attr('name', name);
		}).off('remove.cloneya').on('remove.cloneya', function (event, clone) {
			$(clone).slideToggle('slow', function () {
				$(clone).remove();
			})
		});

		$('.search-file-btn').children("input").bind('change', function() {
			var fileName = '';
			fileName = $(this).val().split("\\").slice(-1)[0];
			$(this).parent().parent().children("span").html(fileName);
		});

		$("#CompanyName").autocomplete({
	        source: function(request, response) {
	            $.ajax({
	                url: base_url+'home/getDetailsByName',
	                data: {
						term : request.term,
						is_master_search: 1           
	                },
	                type: "POST",
	                dataType: "json",
	                success: function (data) {
						if (data.length > 0) {
                            response($.map(data, function (item) {
                                return item;
                            }))
                        } else {
                            response([{ label: 'No results found.', val: -1}]);
                        }
					}
	            });
			},
			delay: 0,
			minLength: 3,
	        select: function( event, ui ) {
	            event.preventDefault();
	            $("#CompanyName").val(ui.item.company);
	            $("#OpenEmail").val(ui.item.email_address).parent().addClass('state-success');
	            $("#Opentelephone").val(ui.item.telephone_no).parent().addClass('state-success');           
	            $("#OpenName").val(ui.item.fname).parent().addClass('state-success');
	            $("#OpenLastName").val(ui.item.lname).parent().addClass('state-success');
	            $("#StreetAddress").val(ui.item.address).parent().addClass('state-success');
	            $("#City").val(ui.item.city).parent().addClass('state-success');
	            $("#Zipcode").val(ui.item.zip_code).parent().addClass('state-success');
	            $("#CustomerId").val(ui.item.id);

	            var is_escrow = ui.item.is_escrow;

	            if(is_escrow == 1)
	            {
	            	$('#add-lender-section').show();
					$('#add-escrow-section').hide();
					$('#escrow-details-fields').hide();
					$("#add-escrow-details").prop( "checked", false );
					$('#upload_lender').hide();
					$('#upload_escrow').show();
					$('#email-notification-section').hide();
	            }
	            else
	            {
	            	$('#add-lender-section').hide();
	            	$('#lender-details-fields').hide();
	            	$("#add-lender-details").prop( "checked", false );
					$('#add-escrow-section').show();
					$('#email-notification-section').show();
					$('#upload_lender').show();
					$('#upload_escrow').hide();
	            }
	            getProductTypes();
	        },
	        change: function( event, ui ) {
	            if (ui.item == null)
	            {
	            	$("#CompanyName").parent().removeClass('state-success').addClass('state-error');
		            $("#OpenEmail").val('').parent().removeClass('state-success').addClass('state-error');
		            $("#Opentelephone").val('').parent().removeClass('state-success').addClass('state-error');
		            $("#OpenName").val('').parent().removeClass('state-success').addClass('state-error');
		            $("#OpenLastName").val('').parent().removeClass('state-success').addClass('state-error');
		            $("#StreetAddress").val('').parent().removeClass('state-success').addClass('state-error');
		            $("#City").val('').parent().removeClass('state-success').addClass('state-error');
		            $("#Zipcode").val('').parent().removeClass('state-success').addClass('state-error');
		            $("#CustomerId").val('');
	            }
	        }
	    });

		$('#email-notification').on('click' , function(){
			if ( $(this).is(":checked") ) 
			{
			    $(this).val(1);
			}
			else 
			{
			    $(this).val(0);
			}
		});
	    function getProductTypes()
		{
			var email = $('#OpenEmail').val();
			var customerId = $('#CustomerId').val();
			if(email)
			{
				$.ajax({
			       url: base_url+'get-product-types',
			       type: "POST",//type of posting the data
			       data: {
			            email: email,
			            customerId: customerId
			       },
			       success: function (data) {
			            var res = jQuery.parseJSON(data);
			            
			            if(res)
			            {
			                var output = [];
			                output.push('<option value="">Select Product</option>')
			                $.each(res, function(key, value) {
			                    output.push('<option value="'+ key +'">'+ value +'</option>');
			                });
			                $('#ProductTypeID').html(output.join(''));
			            }
			       },
			       error: function(xhr, ajaxOptions, thrownError){
			          
			       },
			  });
			}
		}
	});

</script>
