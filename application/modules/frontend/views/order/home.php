<style>
/* Open Order – same design tokens as dashboard */
.pct-home-modern {
    --pct-primary: #1e5f8a;
    --pct-primary-light: #2d7ab5;
    --pct-primary-soft: #e8f2f8;
    --pct-surface: #ffffff;
    --pct-surface-2: #f8fafc;
    --pct-text: #1e293b;
    --pct-text-muted: #64748b;
    --pct-border: #e2e8f0;
    --pct-radius: 12px;
    --pct-radius-sm: 8px;
    --pct-shadow: 0 1px 3px rgba(0,0,0,.06);
    font-family: 'Nunito', -apple-system, BlinkMacSystemFont, 'Segoe UI', system-ui, sans-serif;
    background: var(--pct-surface-2);
    padding-bottom: 2rem;
}
.pct-home-modern .ui-autocomplete { max-height: 300px !important; overflow: hidden !important; }
.pct-home-modern .progress { height: auto; margin-bottom: 0; }
.pct-home-modern .align-display { flex-direction: row; align-items: center; display: flex; }
.pct-home-modern .w-20 { width: 20px; min-width: 20px; }

/* Section headings (taglines) – dashboard-style */
.pct-home-modern .form-grp-title { margin-top: 2rem; margin-bottom: 1.25rem; }
.pct-home-modern .tagline {
    height: 0;
    border-top: 1px solid var(--pct-border);
    text-align: left;
    margin: 0;
}
.pct-home-modern .tagline span {
    display: inline-block;
    position: relative;
    padding: 0 0.75rem 0 0;
    background: var(--pct-surface);
    color: var(--pct-primary);
    top: -0.65em;
    font-size: 0.8125rem;
    font-weight: 600;
    letter-spacing: 0.03em;
    text-transform: uppercase;
}

.pct-home-modern .center-wrapper { margin: 0 auto; max-width: 100%; }
.pct-home-modern .card.shadow.mb-4 {
    border: 1px solid var(--pct-border);
    border-radius: var(--pct-radius);
    box-shadow: var(--pct-shadow);
    overflow: hidden;
}
.pct-home-modern .card-header.py-3 {
    background: var(--pct-surface-2);
    border-bottom: 1px solid var(--pct-border);
    padding: 1rem 1.25rem;
}
.pct-home-modern .card-header .font-weight-bold {
    font-size: 1rem;
    font-weight: 600;
    color: var(--pct-text);
}
.pct-home-modern .card-body { padding: 1.5rem 1.25rem; }

/* Form fields – same spacing and alignment as dashboard */
.pct-home-modern .form-control {
    padding: 0.5rem 0.75rem;
    font-size: 0.9375rem;
    border: 1px solid var(--pct-border);
    border-radius: var(--pct-radius-sm);
    color: var(--pct-text);
    background: var(--pct-surface);
}
.pct-home-modern .form-control:focus {
    border-color: var(--pct-primary-soft);
    outline: 0;
    box-shadow: 0 0 0 3px rgba(30, 95, 138, 0.1);
}
.pct-home-modern select.form-control {
    height: 2.75rem;
    padding: 0.5rem 0.75rem;
}
.pct-home-modern .form-group { margin-bottom: 1rem; }
.pct-home-modern .form-group .row { margin-left: -0.5rem; margin-right: -0.5rem; }
.pct-home-modern .form-group .col-sm-6,
.pct-home-modern .form-group .col-sm-12,
.pct-home-modern .form-group .col-sm-10,
.pct-home-modern .form-group .col-sm-3 { padding-left: 0.5rem; padding-right: 0.5rem; }

/* Buttons – same as dashboard (primary, secondary, danger, success, info) */
.pct-home-modern .btn {
    font-weight: 500;
    font-size: 0.875rem;
    border-radius: var(--pct-radius-sm);
    /* padding: 0.5rem 1rem; */
    transition: opacity .15s ease, background .15s ease, border-color .15s ease;
}
.pct-home-modern .btn-primary { background: var(--pct-primary); border-color: var(--pct-primary); color: #fff; }
.pct-home-modern .btn-primary:hover { background: var(--pct-primary-light); border-color: var(--pct-primary-light); color: #fff; }
.pct-home-modern .btn-secondary { background: #64748b; border-color: #64748b; color: #fff; }
.pct-home-modern .btn-secondary:hover { background: #475569; border-color: #475569; color: #fff; }
.pct-home-modern .btn-danger { background: #dc2626; border-color: #dc2626; color: #fff; }
.pct-home-modern .btn-danger:hover { background: #b91c1c; border-color: #b91c1c; color: #fff; }
.pct-home-modern .btn-success { background: #059669; border-color: #059669; color: #fff; }
.pct-home-modern .btn-success:hover { background: #047857; border-color: #047857; color: #fff; }
.pct-home-modern .btn-info { background: var(--pct-primary); border-color: var(--pct-primary); color: #fff; }
.pct-home-modern .btn-info:hover { background: var(--pct-primary-light); border-color: var(--pct-primary-light); color: #fff; }
.pct-home-modern .btn-icon-split .text { font-size: 0.75rem; padding: 0.4rem 4px; }
.pct-home-modern .search-property-button,
.pct-home-modern .search-apn-button { margin-right: 0.5rem; margin-bottom: 0.5rem; }
.pct-home-modern .clone-widget .btn { margin-right: 0.5rem; }

/* Checkboxes */
.pct-home-modern input[type="checkbox"].form-control { height: 1.25rem; width: 1.25rem; cursor: pointer; }

/* Error and alert states */
.pct-home-modern .alert-danger,
.pct-home-modern .pma-error { font-size: 0.875rem; border-radius: var(--pct-radius-sm); }
.pct-home-modern .search-file-btn { cursor: pointer; margin-bottom: 0; }

/* Modals – match dashboard (use literals so they work outside wrapper) */
.pct-home-modern ~ .modal .modal-content,
#searchResultModal .modal-content,
#findCustomerModal .modal-content,
#showCustomernumberModal .modal-content { border-radius: 12px; border: 1px solid #e2e8f0; box-shadow: 0 4px 12px rgba(0,0,0,.08); }
.pct-home-modern ~ .modal .card-header h6,
.modal .card-header h6 { font-weight: 600; color: #1e293b; }
.pct-home-modern ~ .modal .table thead th,
.modal .table thead th { background: #f8fafc; font-weight: 600; font-size: 0.8125rem; }
</style>

<div class="pct-home-modern">
<section class="section-type-4a section-defaulta" style="padding-bottom:0;">
	<div class="container-fluid px-4 py-4">
        <div class="row mb-4">
            <div class="col-3 center-wrapper">
                <h1 class="pct-page-title" style="font-size:1.5rem;font-weight:600;color:#1e293b;margin-bottom:0.25rem;">Open Order Form</h1>
                <p class="pct-page-sub" style="font-size:0.9375rem;color:#64748b;margin:0;">Helping get your transaction started.</p>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-10 col-xl-9 center-wrapper">
                <div class="card shadow mb-4 smart-forms">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Helping Get Your Transaction Started.</h6>
                    </div>
                    <div class="card-body">
                        <form id="smart-form" method="POST"  enctype="multipart/form-data">
							<div class="row form-grp-title">
								<div class="col-sm-12">
									<div class="tagline"><span> YOUR DETAILS (WILL BE AUTOFILLED) </span></div>
								</div>
							</div>
                            <div class="row form-group">
								<div class="col-sm-6">
									<!-- <label for="resware_client_id" class="col-sm-2 col-form-label">Resware Client Id</label> -->
									<input value="<?php echo $customer_data['first_name']; ?>" type="text" name="OpenName" id="OpenName" class="form-control" placeholder=" First Name">
									<input type="hidden" name="id" id="CustomerId" value="<?php echo $customer_data['id']; ?>">
                                </div>
								<div class="col-sm-6">
									<input value="<?php echo $customer_data['last_name']; ?>" type="text" name="OpenLastName" id="OpenLastName" class="form-control" placeholder="Last Name">
                                </div>
                            </div>

							<div class="row form-group">
								<div class="col-sm-6">
									<input value="<?php echo $customer_data['telephone_no']; ?>" type="tel" name="Opentelephone" id="Opentelephone" class="form-control" placeholder="Telephone">
                                </div>
								<div class="col-sm-6">
									<input value="<?php echo $customer_data['email_address']; ?>" type="email" name="OpenEmail" id="OpenEmail" class="form-control" placeholder="Email address">
                                </div>
                            </div>

							<div class="row form-group">
								<div class="col-sm-6">
									<input value="<?php echo $customer_data['company_name']; ?>" type="text"
												name="CompanyName" id="CompanyName" class="form-control"
												placeholder="Company Name">
                                </div>
								<div class="col-sm-6">
									<input value="<?php echo $customer_data['street_address']; ?>"
												type="text" name="StreetAddress" id="StreetAddress"
												class="form-control" placeholder="Street Address">
                                </div>
                            </div>

							<div class="row form-group">
								<div class="col-sm-6">
									<input value="<?php echo $customer_data['city']; ?>" type="text" name="City" id="City" class="form-control" placeholder="City">
                                </div>
								<div class="col-sm-6">
									<input value="<?php echo $customer_data['zip_code']; ?>" type="text" name="Zipcode" id="Zipcode" class="form-control" placeholder="Zipcode">
									<input value="<?php echo $customer_data['lookup_code'] ?? ''; ?>" type="hidden" name="ClientLookupCode" id="ClientLookupCode" class="form-control" placeholder="ClientLookupCode">
									<input value="<?php echo $customer_data['flookup_code'] ?? ''; ?>" type="hidden" name="CompanyLookupCode" id="CompanyLookupCode" class="form-control" placeholder="ClientLookupCode">

                                </div>

                            </div>

							<div class="row form-group">
								<div class="col-sm-6">
									<select id="ClientType" name="ClientType" class="form-control" placeholder="ClientType">
										<?php if (!empty($customer_data['is_escrow'])) { ?>
											<option value="EscrowCompany"> Escrow Company </option>;
										 <?php } if (!empty($customer_data['is_lender'])) { ?>
											<option value="Lender"> Lender </option>
										<?php } if (!empty($customer_data['is_selling_agent'])) { ?>
											<option value="ListingAgentBroker"> Listing Agent Broker </option>
										<?php } if (!empty($customer_data['is_mortgage_broker'])) { ?>
											<option value="MortgageBroker"> Mortgage Broker </option>
										<?php } ?> 
									</select>
                                </div>
                            </div>

							<div class="row form-group">
								<div class="col-sm-3 align-display">
									<input type="checkbox" class="form-control w-20 mr-3" name="email_notification" id="email-notification">
									<span>Email Notification</span>
								</div>
							</div>

							<div class="row form-grp-title">
								<div class="col-sm-12">
									<div class="tagline">
										<span>Find Your Property</span>
									</div>
								</div>
							</div>
							<div id="address_container">
								<div class="row form-group">
									<input type="hidden" name="property-state" id="property-state" value="">
									<input type="hidden" name="property-city" id="property-city" value="">
									<input type="hidden" name="neighbourhood" id="neighbourhood" value="">
									<input type="hidden" name="property-fips" id="property-fips" value="">
									<input type="hidden" name="property-full-address" id="property-full-address" value="">
									<input type="hidden" name="property-type" id="property-type" value="">
									<input type="hidden" name="property-zip" id="property-zip" value="">
									<input type="hidden" name="random_number" id="random_number" value="">

									<div class="col-sm-12">
										<input type="text" name="Property" id="property-search" class="form-control gui-input pac-target-input" placeholder="Property Address">
									</div>
								</div>

								<div class="row form-group">
									<div class="col-sm-12">
										<a class="button btn btn-primary search-property search-property-button" href="javascript:void(0);" id="search-btn">Property Search</a>
										<a class="button btn btn-secondary switch-apn-button search-property-button" href="javascript:void(0);" id="switch-apn-btn">Switch To APN Search</a>
									</div>
								</div>
							</div>

							<div id="apn_container" style="display:none;">
								<div class="row form-group">
									<div class="col-sm-6">
										<input type="text" name="apn_num" id="apn_num" class="form-control" placeholder="APN">
									</div>
									<div class="col-sm-6">
										<input type="text" name="apn_county" id="apn_county" class="form-control" placeholder="County">
									</div>
								</div>

								<div class="row form-group">
									<div class="col-sm-12">
										<a class="button btn btn-primary search-apn search-apn-button" href="javascript:void(0);" id="search-apn-btn">APN Search</a>
										<a class="button btn btn-secondary switch-property-button search-apn-button" href="javascript:void(0);" id="switch-property-btn">Switch To Property Search</a>
									</div>
								</div>
							</div>
							<div class="row form-group">
								<div class="col-sm-6 pma-error alert alert-danger text-center" style="display:none;"></div>
								<div class="search-loader hidden"></div>
							</div>

							<div class="row form-grp-title">
								<div class="col-sm-12">
									<div class="tagline"><span> Property Details (Will Be AutoFilled) </span></div>
								</div>
							</div>

							<div class="row form-group">
								<div class="col-sm-6">
									<input type="text" name="FullProperty" id="FullProperty" class="form-control" placeholder="Full Street Address">
								</div>
								<div class="col-sm-6">
									<input type="text" name="apn" id="apn" class="form-control" placeholder="APN">
								</div>
							</div>
							<input type="hidden" id="unit_number" name="unit_number" value="">

							<div class="row form-group">
								<div class="col-sm-6">
									<input type="text" name="County" id="County" class="form-control" placeholder="County">
								</div>
								<div class="col-sm-6">
									<input type="text" name="LegalDescription" id="LegalDescription" class="form-control" placeholder="Brief Legal Desription">
								</div>
							</div>

							<div class="row form-grp-title">
								<div class="col-sm-12">
									<div class="tagline"><span>Seller Details (Will Be AutoFilled)</span></div>
								</div>
							</div>

							<div class="row form-group">
								<div class="col-sm-6">
									<input type="text" name="PrimaryOwner" id="PrimaryOwner" class="form-control" placeholder="Primary Owner">
								</div>
								<div class="col-sm-6">
									<input type="text" name="SecondaryOwner" id="SecondaryOwner" class="form-control" placeholder="Secondary Owner">
								</div>
							</div>

							<div class="row form-group">

								<div class="col-sm-3 align-display">

									<input type="checkbox" class="form-control w-20 mr-5" name="IsOrganization" id="IsOrganization" value="1">

									<span>Is Organization</span>

								</div>

							</div>



							<div id="organization-type-fields" style="display: none;">
								<div class="row form-group">
									<div class="col-sm-12">
										<select id="OrganizationType" name="OrganizationType" class="form-control">
											<option value="">Select Organization Type</option>
											<option value="Corporation"> Corporation  </option>
											<option value="Limited Liability Corp"> Limited Liability Corp  </option>
											<option value="Limited Liability Company"> Limited Liability Company  </option>
											<option value="Limited Partnership"> Limited Partnership  </option>
											<option value="Partnership"> Partnership  </option>
											<option value="Trust"> Trust  </option>
											<option value="Estate"> Estate  </option>
											<option value="Other"> Other  </option>
										</select>
									</div>
								</div>
							</div>

							<div class="row form-grp-title">
								<div class="col-sm-12">
									<div class="tagline"><span>Transaction Details</span></div>
								</div>
							</div>

							<div class="row form-group">
								<div class="col-sm-12">
									<select id="SalesRep" name="SalesRep" class="form-control">
										<option value="">Sales Rep...</option>
										<?php
										if (isset($salesRep) && ! empty($salesRep)) {
											foreach ($salesRep as $k => $v) {
												// $name      = [$v['first_name'], $v['last_name']];
												// $full_name = implode(' ', $name);
												$full_name = $v['full_name'];
											?>
													<option value="<?php echo $v['id']; ?>"><?php echo $full_name; ?></option>
											<?php
												}}
											?>
									</select>
								</div>
							</div>
							<div class="row form-group">
								<div class="col-sm-12">
									<select id="TitleOfficer" name="TitleOfficer" class="form-control">
										<option value="">Title Officer</option>
										<?php
                                            if (isset($titleOfficer) && ! empty($titleOfficer)) {
											foreach ($titleOfficer as $key => $value) {
											?>
												<option value="<?php echo $value['id']; ?>"><?php echo $value['name']; ?></option>
											<?php
												}}
											?>
									</select>
								</div>
							</div>

							<div class="row form-group">
								<div class="col-sm-12">
									<input type="hidden" name="ProductType" id="ProductType">
									<select id="ProductTypeID" name="ProductTypeID" class="form-control">
										<option value="">Select Product Type</option>
										<?php foreach ($productType as $key => $type) {?>
											<option value="<?php echo $type['id'] ?>"><?php echo $type['product_type'] ?></option>
											<?php }?>
									</select>
								</div>
							</div>

							<div class="row form-group">
								<div class="col-sm-12">
									<input type="hidden" id="OrderType" name="OrderType">
									<select id="OrderTypeID" name="OrderTypeID" class="form-control">
										<option value="">Select Order Type</option>
										<?php foreach ($orderType as $key => $type) {?>
										<option value="<?php echo $type['id'] ?>"><?php echo $type['order_type'] ?></option>
										<?php }?>
									</select>
								</div>
							</div>
							
							<div class="row form-group">
								<div class="col-sm-12">
									<select id="TransactionType" name="TransactionType" class="form-control">
										<option value="">Select Transaction Type</option>
										<option value="Purchase">Purchase</option>
										<option value="Refinance">Refinance</option>
										<option value="Equity">Equity</option>
										<option value="Other">Other</option>

									</select>
								</div>
							</div>

							<div id="organization-borrower-type-fields" style="display: none;">
								<div class="row form-group">
									<div class="col-sm-6 align-display">
										<input type="checkbox" class="form-control w-20 mr-5" name="IsBorrowerOrganization" id="IsBorrowerOrganization" value="1">
										<span>Is Borrower Organization</span>
									</div>
								</div>

								<div class="row form-group" id="organization-borrower-type" style="display: none;">
									<div class="col-sm-12">
										<select id="BorrowerOrganizationType" name="BorrowerOrganizationType" class="form-control">
											<option value="">Select Borrower Organization Type</option>
											<option value="Corporation"> Corporation  </option>
											<option value="Limited Liability Corp"> Limited Liability Corp  </option>
											<option value="Limited Liability Company"> Limited Liability Company  </option>
											<option value="Limited Partnership"> Limited Partnership  </option>
											<option value="Partnership"> Partnership  </option>
											<option value="Trust"> Trust  </option>
											<option value="Estate"> Estate  </option>
											<option value="Other"> Other  </option>
										</select>
									</div>
								</div>
							</div>


							<div id="sales-loan-amount-fields" style="display:none;">
								<div class="row form-group">
									<div class="col-sm-12">
										<input type="text" class="form-control" data-type="number"  name="salesAmount" id="salesAmount" placeholder="Sales Amount">
									</div>
								</div>
								<div class="row form-group">
									<div class="col-sm-12">
										<input type="text" class="form-control" data-type="number"  name="loanAmount" id="loanAmount" placeholder="Loan Amount">
									</div>
								</div>

								<div class="row form-group coverage-field" style="display:none;">
									<div class="col-sm-12">
										<input type="text" class="form-control" data-type="number"  name="coverageAmount" id="coverageAmount" placeholder="Coverage Amount">
									</div>
								</div>

								<div class="row form-group">
									<div class="col-sm-12">
										<input type="text" class="form-control" name="primaryBorrower" id="primaryBorrower" placeholder="Primary Borrower">
									</div>
								</div>
								<div class="row form-group">
									<div class="col-sm-12">
										<input type="text" class="form-control" name="secondaryBorrower" id="secondaryBorrower" placeholder="Secondary Borrower">
									</div>
								</div>
							</div>

							<div class="row form-group">
								<div class="col-sm-12">
									<input type="text" class="form-control" name="escrowNumber" id="escrowNumber" placeholder="Escrow Number">
								</div>
							</div>
							<div class="row form-group">
								<div class="col-sm-12">
									<input type="text" class="form-control" name="loanNumber" id="loanNumber" placeholder="Loan Number">
								</div>
							</div>

							<div class="row form-grp-title">
								<div class="col-sm-12">
									<div class="tagline"><span>Add Deliverables</span></div>
								</div>
							</div>

							<div id="clone-email-address" class="cloneya-wrap" >
								<?php if (!empty($deliverables)) {
    $i = 0;
    foreach ($deliverables as $deliverable) {?>
											<div class="row form-group toclone clone-widget cloneya">
												<div class="col-sm-10">
														<?php if ($i == 0) {?>
															<input type="email" class="form-control" name="AdditionalEmail[]" id="AdditionalEmail" placeholder="Email Address" value="<?php echo $deliverable; ?>">
														<?php } else {?>
															<input type="email" class="form-control" name="AdditionalEmail[]" id="AdditionalEmail<?php echo $i; ?>" placeholder="Email Address" value="<?php echo $deliverable; ?>">
														<?php }?>
												</div>
												<a href="javascript:void(0)" class="clone button btn btn-primary mr-2"><i class="fa fa-plus pt-2"></i></a>
												<a href="javascript:void(0)" class="delete button btn btn-danger mr-2"><i class="fa fa-minus pt-2"></i></a>

											</div>

										<?php $i++;}
} else {?>
									<div class="row form-group toclone clone-widget cloneya">
										<div class="col-sm-10">
											<input type="email" class="form-control" name="AdditionalEmail[]" id="AdditionalEmail" placeholder="Email Address">
										</div>
										<a href="javascript:void(0)" class="clone button  btn btn-primary mr-2"><i class="fa fa-plus pt-2"></i></a>
										<a href="javascript:void(0)" class="delete button btn btn-danger mr-2"><i class="fa fa-minus pt-2"></i></a>
									</div>
								<?php }?>
							</div>

							<div class="row form-grp-title">
								<div class="col-sm-12">
									<div class="tagline"><span> Add Parties </span></div>
								</div>
							</div>


							<div class="row form-group">
								<div class="col-sm-3 align-display">
									<input type="checkbox" class="form-control w-20 mr-5" name="add-agent-details" id="add-agent-details">
									<span>Add Agent Details</span>
								</div>

								<?php
$is_escrow                = isset($customer_data['is_escrow']) && ! empty($customer_data['is_escrow']) ? $customer_data['is_escrow'] : 0;
$is_lender                = isset($customer_data['is_lender']) && ! empty($customer_data['is_lender']) ? $customer_data['is_lender'] : 0;
$is_selling_agent                = isset($customer_data['is_selling_agent']) && ! empty($customer_data['is_selling_agent']) ? $customer_data['is_selling_agent'] : 0;
$is_primary_mortgage_user = isset($customer_data['is_primary_mortgage_user']) && ! empty($customer_data['is_primary_mortgage_user']) ? $customer_data['is_primary_mortgage_user'] : 0;
    if ($is_escrow == 1 || $is_primary_mortgage_user == 1 || $is_selling_agent == 1) {
?>
										<div class="col-sm-3 align-display" id="add-lender-section" style="display: none;">
											<input type="checkbox" class="form-control w-20 mr-5" name="add-lender-details" id="add-lender-details">
											<span >Add Lender</span>
										</div>
<?php } if ($is_lender == 1 || $is_primary_mortgage_user == 1 || $is_selling_agent == 1) {?>
										<div class="col-sm-3 align-display" id="add-escrow-section" style="display: none;">
											<input type="checkbox" class="form-control w-20 mr-5" name="add-escrow-details" id="add-escrow-details">
											<span >Add Escrow</span>
										</div>
								<?php }?>

								<div class="col-sm-3 align-display" id="add-escrow-officer-section" style="display:none;">
									<input type="checkbox" class="form-control w-20 mr-5" name="add-escrow-officer-details" id="add-escrow-officer-details">
									<span >Add Escrow Officer</span>
								</div>
							</div>

							<div id="agent-details-fields" style="display: none;">
								<div class="row form-group">
									<div class="col-sm-6 text-center">
										<div class="tagline">
											<span>
												Buyers Agent
											</span>
										</div>
									</div>
									<div class="col-sm-6 text-center">
										<div class="tagline">
										<span>
											Listing Agent
										</span>
										</div>
									</div>
								</div>

								<div class="row form-group">
									<div class="col-sm-6">
										<input type="text" name="BuyerAgentName" id="BuyerAgentName" class="form-control" placeholder="Agent Name">
										<input type="hidden" name="BuyerAgentId" id="BuyerAgentId" value="">
										<input type="hidden" name="BuyerAgentCompanyLookupCode" id="BuyerAgentCompanyLookupCode" value="">
										<input type="hidden" name="BuyerAgentClientLookUpCode" id="BuyerAgentClientLookUpCode" value="">
										<input type="hidden" name="buyer_agent_partner_id" id="buyer_agent_partner_id" value="">
									</div>

									<div class="col-sm-6">
										<input type="text" name="ListingAgentName" id="ListingAgentName" class="form-control" placeholder="Agent Name">
										<input type="hidden" name="ListingAgentId" id="ListingAgentId" value="">
										<input type="hidden" name="ListingAgentCompanyLookupCode" id="ListingAgentCompanyLookupCode" value="">
										<input type="hidden" name="ListingAgentClientLookUpCode" id="ListingAgentClientLookUpCode" value="">
										<input type="hidden" name="listing_agent_partner_id" id="listing_agent_partner_id" value="">
									</div>
								</div>

								<div class="row form-group">
									<div class="col-sm-6">
										<input type="email" name="BuyerAgentEmailAddress" id="BuyerAgentEmailAddress" class="form-control" placeholder="Agent Email address">
									</div>

									<div class="col-sm-6">
										<input type="email" name="ListingAgentEmailAddress" id="ListingAgentEmailAddress" class="form-control" placeholder="Agent Email address">
									</div>
								</div>

								<div class="row form-group">
									<div class="col-sm-6">
										<input type="tel" name="BuyerAgentTelephone" id="BuyerAgentTelephone" class="form-control" placeholder="Agent Telephone">
									</div>

									<div class="col-sm-6">
										<input type="tel" name="ListingAgentTelephone" id="ListingAgentTelephone" class="form-control" placeholder="Agent Telephone">
									</div>
								</div>

								<div class="row form-group">
									<div class="col-sm-6">
										<input type="text" name="BuyerAgentCompany" id="BuyerAgentCompany" class="form-control" placeholder="Agent Company Name">
									</div>

									<div class="col-sm-6">
										<input type="text" name="ListingAgentCompany" id="ListingAgentCompany" class="form-control" placeholder="Agent Company Name">
									</div>
								</div>

								<div class="row form-group">
									<div class="col-sm-6">
										<div style="display: none;" class="alert notification alert-error" id="required-agent-details">Enter Buyers Agent or Listing Agent details</div>
									</div>
								</div>
							</div>

							<div id="lender-details-fields" style="display: none;">
								<div class="row mb-5">
									<div class="col-sm-12">
										<div class="tagline"><span> Add Lender Details </span></div>
									</div>
								</div>
								<div class="row form-group">
									<div class="col-sm-6">
										<input type="text" name="LenderCompany" id="LenderCompany" class="form-control" placeholder="Lender Company Name">
									</div>
									<div class="col-sm-6">
										<input type="text" name="LenderName" id="LenderName" class="form-control" placeholder="Lender Name">
									</div>
									<input type="hidden" name="LenderId" id="LenderId" value="">
									<input type="hidden" name="LenderCompanyLookUpCode" id="LenderCompanyLookUpCode" value="">
									<input type="hidden" name="LenderClientLookUpCode" id="LenderClientLookUpCode" value="">
								</div>

								<div class="row form-group">
									<div class="col-sm-6">
										<input type="email" name="LenderEmailAddress" id="LenderEmailAddress" class="form-control" placeholder="Lender Email address">
									</div>

									<div class="col-sm-6">
										<input type="tel" name="LenderTelephone" id="LenderTelephone" class="form-control" placeholder="Lender Telephone">
									</div>
								</div>
							</div>

							<div id="escrow-details-fields" style="display: none;">
								<div class="row mb-5">
									<div class="col-sm-12">
										<div class="tagline"><span> Add Escrow Details </span></div>
									</div>
								</div>
								<div class="row form-group">
									<div class="col-sm-6">
										<input type="text" name="EscrowCompany" id="EscrowCompany" class="form-control" placeholder="Escrow Company Name">
									</div>
									<div class="col-sm-6">
										<input type="text" name="EscrowName" id="EscrowName" class="form-control" placeholder="Escrow Name">
									</div>
									<input type="hidden" name="EscrowId" id="EscrowId" value="">
									<input type="hidden" name="EscrowCompanyLookUpCode" id="EscrowCompanyLookUpCode" value="">
									<input type="hidden" name="EscrowClientLookUpCode" id="EscrowClientLookUpCode" value="">
								</div>

								<div class="row form-group">
									<div class="col-sm-6">
										<input type="email" name="EscrowEmailAddress" id="EscrowEmailAddress" class="form-control" placeholder="Escrow Email address">
									</div>

									<div class="col-sm-6">
										<input type="tel" name="EscrowTelephone" id="EscrowTelephone" class="form-control" placeholder="Escrow Telephone" readonly="readonly">
									</div>
								</div>
							</div>

							<div class="spacer-b30" id="escrow-officer-field" style="display: none;">
								<div class="row spacer-b30 spacer-t30 form-grp-title">
									<div class="col-sm-12">
										<div class="tagline"><span> Select Escrow Officer </span></div>
									</div>
								</div>
								<div class="row form-group">
									<div class="col-sm-6">
										<select id="escrow_officer" name="escrow_officer" class="form-control">
											<option value="">----Select Escrow Officer----</option>
											<?php
                                                if (isset($escrowOfficers) && ! empty($escrowOfficers)) {
                                                foreach ($escrowOfficers as $escrowOfficer) {?>
														<option value="<?php echo $escrowOfficer['closer_examiner']; ?>"><?php echo $escrowOfficer['name']; ?></option>
												<?php
													}
												}?>
										</select>
									</div>
								</div>

							</div>

							<?php if ($is_escrow == 0) {?>
							<div class="row form-grp-title">
								<div class="col-sm-12">
									<div class="tagline"><span>Upload Curative Document</span></div>
								</div>
							</div>

							<div class="row form-group">
								<div class="col-sm-6">
									<label class="button btn btn-primary search-file-btn">
										<input name="upload_curative" id="upload_curative" type="file" style="display:None;"> <span>Upload 1003</span>
									</label>
									<span> </span>
								</div>
							</div>

							<?php }?>

							<?php if ($is_escrow == 1) {?>
							<div class="row form-grp-title">
								<div class="col-sm-12">
									<div class="tagline"><span>Upload Curative Document</span></div>
								</div>
							</div>

							<div class="row form-group">
								<div class="col-sm-6">
									<label class="button btn btn-primary search-file-btn">
										<input name="upload_curative" id="upload_curative" type="file" style="display:None;"> <span>Upload RPA</span>
									</label>
									<span> </span>
								</div>
							</div>

							<?php }?>
							<div class="row form-group">
								<div class="col-sm-12">
									<div class="result spacer-b10"></div>
								</div>
							</div>

							<div class="row form-group">
								<div class="col-sm-12" id="progressDivId">
									<div class='' id='progressBar'></div>
									<div class='' id='percent'>0%</div>
								</div>
							</div>
                            <div class="form-group">
                                <div class="col-sm-6">
                                    <button type="submit" class="btn btn-success btn-icon-split home-submit" <?php echo ($submitButtonFlag == 0) ? "disabled" : ""; ?> >
                                        <span class="icon text-white-50">
                                            <i class="fas fa-save"></i>
                                        </span>
                                        <span class="text">Submit</span>
                                    </button>
                                    <button type="reset" class="btn btn-secondary btn-icon-split">
                                        <span class="icon text-white-50">
                                            <i class="fas fa-arrow-left"></i>
                                        </span>
                                        <span class="text">Cancel</span>
									</button>
									<a class="btn btn-info btn-icon-split" href="http://www.pct.com">
										<span class="icon text-white-50">
                                            <i class="fas fa-home"></i>
                                        </span>
                                        <span class="text">Homepage</span>
									</a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
</div>

<div class="modal fade" id="searchResultModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
	aria-hidden="true">
	<div class="modal-dialog modal-lg modal-dialog-centered" role="document">
		<div class="modal-content">
			<div class="row">
				<div class="col-lg-12">
					<div class="card shadow mb-4">
						<div class="card-header py-3">
							<button type="button" class="close" data-dismiss="modal" aria-label="Close">
								<span aria-hidden="true">&times;</span>
							</button>
							<h6 class="m-0 font-weight-bold text-primary">Search Results</h6>
						</div>
						<div class="card-body">
							<div class="smart-forms smart-container">
								<div class="modal-body search-result">
									<table class="table table-bordered" width="100%">
										<thead>
											<tr>
												<th width="21%">APN</th>
												<th width="40%">Address</th>
												<!-- <th width="21%">City</th> -->
												<th width="21%">Unit Number</th>
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
				</div>
			</div>
			<!-- <div class="modal-header">
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
							<th width="21%">City</th>
							<th width="21%">Unit Number</th>
							<th width="15%">Run Listing</th>
						</tr>
					</thead>
					<tbody></tbody>
				</table>
			</div>
			<div class="modal-footer">
				<div class="apn-search-loader hidden"></div>
			</div> -->
		</div>
	</div>
</div>

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

