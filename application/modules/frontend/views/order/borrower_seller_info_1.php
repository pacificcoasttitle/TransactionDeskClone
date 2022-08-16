<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="author" content="colorlib.com">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<title>Sign Up Form</title>

	<!-- Font Icon -->
	<link rel="stylesheet"
		href="<?php echo base_url();?>assets/buyer-seller-packets/fonts/material-icon/css/material-design-iconic-font.min.css">
	<link rel="stylesheet"
		href="<?php echo base_url();?>assets/buyer-seller-packets/vendor/nouislider/nouislider.min.css">

	<!-- Main css -->
	<link rel="stylesheet" href="<?php echo base_url();?>assets/buyer-seller-packets/css/style.css">

</head>

<style>
.d-none {
    display: none;
}
</style>

<body>
	<div class="main">
		<div class"File">
			<div class="container2">

				<h1>Seller Welcome Interview </h1>
				<h3><?php echo $orderDetails['full_address'];?></h3>
				<h4>APN:<?php echo $orderDetails['apn'];?> | File# <?php echo $orderDetails['file_number'];?> </h4>

			</div>
		</div>

		<div class="container">
			<?php if(!empty($success)) {?>
				<div id="agent_success_msg" class="w-100 alert alert-success alert-dismissible">
					<?php foreach($success as $sucess) {
							echo $sucess."<br \>";	
						}?>
						
				</div>
			<?php  } 
			if(!empty($errors)) {?>
				<div id="agent_error_msg" class="w-100 alert alert-danger alert-dismissible">
					<?php foreach($errors as $error) {
						echo $error."<br \>";	
					}?>	
				</div>
			<?php } ?>
			<form method="POST" id="signup-form" class="signup-form" action="<?php echo base_url().'seller-info/'.$orderDetails['file_id']; ?>">
				<div>
					
					<h3>About You</h3>
					<input type="hidden" name="order_id" id="order_id" value="<?php echo $orderDetails['order_id'];?>">
					<fieldset>
						<h2>Personal information</h2>
						<p class="desc">Please enter your infomation and proceed to next step so we can build your
							account</p>
						<div class="fieldset-content">
							<div class="form-row">
								<div class="form-flex">
									<div class="form-group">
										<label class="form-label">Name</label>
										<input type="text" name="first_name" id="first_name" required="required">
										<span class="text-input">example: John,Jane </span>
									</div>
									<div class="form-group">
										<label class="form-label">Last Name</label>
										<input type="text" name="last_name" id="last_name" required="required">
										<span class="text-input">example: Smith. </span>
									</div>
								</div>
							</div>
							<div class="form-row">
								<div class="form-flex">
									<div class="form-group">
										<label for="email" class="form-label">Email</label>
										<input type="email" name="email" id="email" required="required">
										<span class="text-input">example: jsmith@gmail.com </span>
									</div>
									<div class="form-group">
										<label for="phone" class="form-label">Phone</label>
										<input type="text" name="phone" id="phone" required="required">
										<span class="text-input">example: (000) 000-0000 </span>
									</div>
								</div>
							</div>

							<div class="form-row">
								<div class="form-flex">
									<div class="form-date" style="margin-left: 10px;">
										<label for="birth_date" class="form-label">Birth Date</label>
										<div class="form-date-group">
											<div class="form-date-item">
												<select id="birth_month" name="birth_month" required="required"></select>
												<span class="text-input">MM</span>
											</div>
											<div class="form-date-item">
												<select id="birth_date" name="birth_date" required="required"></select>
												<span class="text-input">DD</span>
											</div>
											<div class="form-date-item">
												<select id="birth_year" name="birth_year" required="required"></select>
												<span class="text-input">YYYY</span>
											</div>
										</div>
									</div>
									<div class="form-date" style="margin-left: 10px;">
										<label for="birth_date" class="form-label">Social Security No.</label>
										<div class="form-date-group">
											<div class="form-date-item">
												<input type="text" id="ssn1" name="ssn1" required="required"></input>
												<span class="text-input">XXX</span>
											</div>
											<div class="form-date-item">
												<input type="text" id="ssn2" name="ssn2" required="required"></input>
												<span class="text-input">XX</span>
											</div>
											<div class="form-date-item">
												<input type="text" id="ssn3" name="ssn3" required="required"></input>
												<span class="text-input">XXXX</span>
											</div>
										</div>
									</div>
								</div>
							</div>
							<div class="form-group">
								<label for="ssn" class="form-label">Current Mailing Address</label>
								<input type="text" name="current_mailing_address" id="current_mailing_address" required="required"/>
								<span class="text-input">456 Main St. Los Angeles, CA </span>

							</div>
							<div class="form-group">
								<label for="ssn" class="form-label">Mailing Address Post Closing</label>
								<input type="text" name="mailing_address_port_closing" id="mailing_address_port_closing" required="required">
								<span class="text-input">456 Main St. Los Angeles, CA </span>
							</div>

							<div class="form-row">
								<div class="form-group">
									<label class="form-label">Would You Like to Add Another Seller?</label>
									<select id="is_another_seller" name="is_another_seller" required="required">
										<option value="">Select</option>
										<option value="Yes">Yes</option>
										<option value="No">No</option>
									</select>
									<span class="text-input">example: Statefarm, Allstate, etc. </span>
								</div>
							</div>

                            <div class="d-none" id="second_seller">
								<div class="form-row">
									<div class="form-flex">
										<div class="form-group">
											<label class="form-label">Name</label>
											<input type="text" name="second_first_name" id="second_first_name">
											<span class="text-input">example: John,Jane </span>
										</div>
										<div class="form-group">
											<label class="form-label">Last Name</label>
											<input type="text" name="second_last_name" id="second_last_name">
											<span class="text-input">example: Smith. </span>
										</div>
									</div>
								</div>
								<div class="form-row">
									<div class="form-flex">
										<div class="form-group">
											<label for="email" class="form-label">Email</label>
											<input type="email" name="second_email" id="second_email">
											<span class="text-input">example: jsmith@gmail.com </span>
										</div>
										<div class="form-group">
											<label for="phone" class="form-label">Phone</label>
											<input type="text" name="second_phone" id="second_phone">
											<span class="text-input">example: (000) 000-0000 </span>
										</div>
									</div>
								</div>

								<div class="form-row">
									<div class="form-flex">
										<div class="form-date" style="margin-left: 10px;">
											<label for="birth_date" class="form-label">Birth Date</label>
											<div class="form-date-group">
												<div class="form-date-item">
													<select id="second_birth_month" name="second_birth_month"></select>
													<span class="text-input">MM</span>
												</div>
												<div class="form-date-item">
													<select id="second_birth_date" name="second_birth_date"></select>
													<span class="text-input">DD</span>
												</div>
												<div class="form-date-item">
													<select id="second_birth_year" name="second_birth_year"></select>
													<span class="text-input">YYYY</span>
												</div>
											</div>
										</div>
										<div class="form-date" style="margin-left: 10px;">
											<label for="birth_date" class="form-label">Social Security No.</label>
											<div class="form-date-group">
												<div class="form-date-item">
													<input type="text" id="second_ssn1" name="second_ssn1"></input>
													<span class="text-input">XXX</span>
												</div>
												<div class="form-date-item">
													<input type="text" id="second_ssn2" name="second_ssn2"></input>
													<span class="text-input">XX</span>
												</div>
												<div class="form-date-item">
													<input type="text" id="second_ssn3" name="second_ssn3"></input>
													<span class="text-input">XXXX</span>
												</div>
											</div>
										</div>
									</div>
								</div>
								<div class="form-group">
									<label for="ssn" class="form-label">Current Mailing Address</label>
									<input type="text" name="second_current_mailing_address" id="second_current_mailing_address"/>
									<span class="text-input">456 Main St. Los Angeles, CA </span>

								</div>
								<div class="form-group">
									<label for="ssn" class="form-label">Mailing Address Post Closing</label>
									<input type="text" name="second_mailing_address_port_closing" id="second_mailing_address_port_closing">
									<span class="text-input">456 Main St. Los Angeles, CA </span>
								</div>
                            </div>
							<div class="form-row">
								<div class="form-group">
									<label class="form-label">Is the Seller a Trustee or Trust?</label>
									<select id="is_trustee" name="is_trustee" required="required">
										<option value="">Select</option>
										<option value="Yes">Yes</option>
										<option value="No">No</option>
									</select>
									<span class="text-input">example: yes, no </span>
								</div>

								<div class="d-none" id="trustee_container">
									<div class="form-group">
										<label for="ssn" class="form-label">Who is/are the Current Acting Trustee(s)?</label>
										<input type="text" name="current_trustees" id="current_trustees"/>
										<span class="text-input">example: John,Jane </span>
									</div>

									<div class="form-group">
										<label class="form-label">Are they the Original Trustees Or Successor Trustee(s)?</label>
										<select id="is_original_trustees" name="is_original_trustees" required="required">
											<option value="">Select</option>
											<option value="Yes">Yes</option>
											<option value="No">No</option>
										</select>
										<span class="text-input">example: yes, no </span>
									</div>
								</div>
							</div>

							<div class="form-row">
								<div class="form-group">
									<label class="form-label">Is the Seller a as Limited Liability Company, Corporation,
										Partnership?</label>
									<select id="is_limited_company" name="is_limited_company" required="required">
										<option value="">Select</option>
										<option value="Yes">Yes</option>
										<option value="No">No</option>
									</select>
									<span class="text-input">example: yes, no </span>
								</div>
							</div>
							<div class="form-row">
								<div class="form-group">
									<label class="form-label">What is the Seller(s) current marital status?</label>
									<select id="is_married" name="is_married" required="required">
										<option value="">Select</option>
										<option value="single">Single</option>
										<option value="married">Married</option>
										<option value="widowed">Widowed</option>
										<option value="divorced">Divorced</option>
										<option value="separated">Separated</option>
									</select>
									<span class="text-input">example: single, married, divorced. </span>
								</div>
							</div>

						</div>
					</fieldset>

					<h3>Property & Loan</h3>
					<fieldset>
						<h2>About Your Loan</h2>
						<p class="desc">Tell us a little bit about the finances.</p>
						<div class="fieldset-content">

							<div class="form-row">
								<div class="form-group">
									<label class="form-label">Is the property you are selling: </label>
									<select id="is_property_sell" name="is_property_sell" required="required">
										<option value="">Select</option>
										<option value="Yes">Yes</option>
										<option value="No">No</option>
									</select>
									<span class="text-input">example: yes or no. </span>
								</div>
							</div>

							<div class="form-row">
								<div class="form-group">
									<label class="form-label">Is the property owned Free and Clear?</label>
									<select id="is_property_owned_free_clear" name="is_property_owned_free_clear" required="required">
										<option value="">Select</option>
										<option value="Yes">Yes</option>
										<option value="No">No</option>
									</select>
									<span class="text-input">example: yes or no. </span>
								</div>
							</div>

							<div class="d-none" id="property_owned_free_clear_no">
								<div class="form-group">
									<label for="ssn" class="form-label">Lender Name</label>
									<input type="text" name="lender_name" id="lender_name" />
									<span class="text-input">example: Wells Fargo, Bank of America </span>
								</div>
								<div class="form-group">
									<label for="ssn" class="form-label">Lender Address</label>
									<input type="text" name="lender_address" id="lender_address" />
									<span class="text-input">456 Main St. Los Angeles, CA </span>
								</div>

								<div class="form-row">
									<div class="form-flex">
										<div class="form-group">
											<label class="form-label">Loan Number</label>
											<input type="text" name="loan_number" id="loan_number" />
											<span class="text-input">example: 8845648974 </span>
										</div>
										<div class="form-group">
											<label class="form-label">Phone Number</label>
											<input type="text" name="lender_phone_number" id="lender_phone_number" />
											<span class="text-input">example: (800) 000-0000 </span>
										</div>
									</div>
								</div>

								<div class="form-row">
									<div class="form-flex">
										<div class="form-group">
											<label class="form-label">Unpaid Balance</label>
											<input type="text" name="unpaid_balance" id="unpaid_balance" />
											<span class="text-input">example: $585,452.00 </span>
										</div>
										<div class="form-group">
											<label class="form-label">Payment Due Date</label>
											<input type="text" name="payment_due_date" id="payment_due_date" />
											<span class="text-input">example: 10/15/2022 </span>
										</div>
									</div>
								</div>

								<div class="form-row">
									<div class="form-flex">
										<div class="form-group">
											<label class="form-label">Loan Type</label>
											<select id="loan_type" name="loan_type">
												<option value="">Select</option>
												<option value="VA">VA</option>
												<option value="FHA">FHA</option>
												<option value="Conventional">Conventional</option>
												<option value="Equity">Equity Line</option>
											</select>
											<span class="text-input">example: Conventional, FHA </span>
										</div>
										<div class="form-group">
											<label class="form-label">Impound Accouunt?</label>
											<select id="is_impound_account" name="is_impound_account">
												<option value="">Select</option>
												<option value="Yes">Yes</option>
												<option value="No">No</option>
											</select>
											<span class="text-input">example: Yes or No </span>
										</div>
									</div>
								</div>
								<div class="form-row">
									<div class="form-flex">
										<div class="form-group">
											<label class="form-label">Taxes Status</label>
											<select id="tax_status" name="tax_status">
												<option value="">Select</option>
												<option value="Paid">Paid</option>
												<option value="Unpaid">Unpaid</option>
											</select>
											<span class="text-input">example: Paid or Unpaid </span>
										</div>
										<div class="form-group">
											<label class="form-label">Paid via Impound</label>
											<select id="is_paid_impound" name="is_paid_impound">
												<option value="">Select</option>
												<option value="Yes">Yes</option>
												<option value="No">No</option>
											</select>
											<span class="text-input">example: Yes or No </span>
										</div>
									</div>
								</div>
							</div>

							<div class="form-row">
								<div class="form-group">
									<label class="form-label">Add Another Loan?</label>
									<select id="is_another_loan" name="is_another_loan" required="required">
										<option value="">Select</option>
										<option value="Yes">Yes</option>
										<option value="No">No</option>
									</select>
									<span class="text-input">example: yes or no. </span>
								</div>
							</div>

							<div class="d-none" id="another_loan_option">
								<div class="form-group">
									<label for="ssn" class="form-label">Lender Name</label>
									<input type="text" name="second_lender_name" id="second_lender_name" />
									<span class="text-input">example: Wells Fargo, Bank of America </span>
								</div>
								<div class="form-group">
									<label for="ssn" class="form-label">Lender Address</label>
									<input type="text" name="second_lender_address" id="second_lender_address" />
									<span class="text-input">456 Main St. Los Angeles, CA </span>
								</div>

								<div class="form-row">
									<div class="form-flex">
										<div class="form-group">
											<label class="form-label">Loan Number</label>
											<input type="text" name="second_loan_number" id="second_loan_number" />
											<span class="text-input">example: 8845648974 </span>
										</div>
										<div class="form-group">
											<label class="form-label">Phone Number</label>
											<input type="text" name="second_lender_phone_number" id="second_lender_phone_number" />
											<span class="text-input">example: (800) 000-0000 </span>
										</div>
									</div>
								</div>

								<div class="form-row">
									<div class="form-flex">
										<div class="form-group">
											<label class="form-label">Unpaid Balance</label>
											<input type="text" name="second_unpaid_balance" id="second_unpaid_balance" />
											<span class="text-input">example: $585,452.00 </span>
										</div>
										<div class="form-group">
											<label class="form-label">Payment Due Date</label>
											<input type="text" name="second_payment_due_date" id="second_payment_due_date" />
											<span class="text-input">example: 10/15/2022 </span>
										</div>
									</div>
								</div>

								<div class="form-row">
									<div class="form-flex">
										<div class="form-group">
											<label class="form-label">Loan Type</label>
											<select id="second_loan_type" name="second_loan_type">
												<option value="">Select</option>
												<option value="VA">VA</option>
												<option value="FHA">FHA</option>
												<option value="Conventional">Conventional</option>
												<option value="Equity">Equity Line</option>
											</select>
											<span class="text-input">example: Conventional, FHA </span>
										</div>
										<div class="form-group">
											<label class="form-label">Impound Accouunt?</label>
											<select id="second_is_impound_account" name="second_is_impound_account">
												<option value="">Select</option>
												<option value="Yes">Yes</option>
												<option value="No">No</option>
											</select>
											<span class="text-input">example: Yes or No </span>
										</div>
									</div>
								</div>
								<div class="form-row">
									<div class="form-flex">
										<div class="form-group">
											<label class="form-label">Taxes Status</label>
											<select id="second_tax_status" name="second_tax_status">
												<option value="">Select</option>
												<option value="Paid">Paid</option>
												<option value="Unpaid">Unpaid</option>
											</select>
											<span class="text-input">example: Paid or Unpaid </span>
										</div>
										<div class="form-group">
											<label class="form-label">Paid via Impound</label>
											<select id="second_is_paid_impound" name="second_is_paid_impound">
												<option value="">Select</option>
												<option value="Yes">Yes</option>
												<option value="No">No</option>
											</select>
											<span class="text-input">example: Yes or No </span>
										</div>
									</div>
								</div>
							</div>
						</div>
					</fieldset>
					<h3>Utilities & HOA</h3>
					<fieldset>
						<h2>Utilities</h2>
						<p class="desc">Let us know who services your home.</p>
						<div class="fieldset-content">
							<div class="form-row">
								<div class="form-group">
									<label class="form-label">Is there a Private Water Company with Water Stock Affecting the Property?</label>
									<select id="is_private_water_company" name="is_private_water_company" required="required">
										<option value="">Select</option>
										<option value="Yes">Yes</option>
										<option value="No">No</option>
									</select>
									<span class="text-input">example: yes or no. </span>
								</div>
							</div>

							<div class="d-none" id="water_company_container">
								<div class="form-group">
									<label for="ssn" class="form-label">Water Company Name</label>
									<input type="text" name="water_company" id="water_company" />
									<span class="text-input">example: abc water company </span>
								</div>
								<div class="form-group">
									<label for="ssn" class="form-label">Company Address</label>
									<input type="text" name="water_company_address" id="water_company_address" />
									<span class="text-input">456 Main St. Los Angeles, CA </span>
								</div>

								<div class="form-row">
									<div class="form-flex">
										<div class="form-group">
											<label class="form-label">Account Number</label>
											<input type="text" name="water_account_number" id="water_account_number" />
											<span class="text-input">example: 8582985455 </span>
										</div>
										<div class="form-group">
											<label class="form-label">Phone Number</label>
											<input type="text" name="water_phone_number" id="water_phone_number" />
											<span class="text-input">example: (000) 000-0000 </span>
										</div>
									</div>
								</div>
							</div>
						</div>
						<div class="fieldset-content">
							<div class="form-row">
								<div class="form-group">
									<label class="form-label">Are there any Homeowners Associations affecting the Property?</label>
									<select id="is_hoa" name="is_hoa" required="required">
										<option value="">Select</option>
										<option value="Yes">Yes</option>
										<option value="No">No</option>
									</select>
									<span class="text-input">example: yes or no. </span>
								</div>
							</div>

							<div class="d-none" id="hoa_container">
								<div class="form-group">
									<label for="ssn" class="form-label">HOA Management Company Name</label>
									<input type="text" name="hoa_company" id="hoa_company" />
									<span class="text-input">example: Ranch Hills Home Owners Association </span>

								</div>
								<div class="form-group">
									<label for="ssn" class="form-label">HOA Management Company Address</label>
									<input type="text" name="hoa_company_address" id="hoa_company_address" />
									<span class="text-input">456 Main St. Los Angeles, CA </span>

								</div>

								<div class="form-row">
									<div class="form-flex">
										<div class="form-group">
											<label class="form-label">HOA Contact Person</label>
											<input type="text" name="hoa_contact_person" id="hoa_contact_person" />
											<span class="text-input">example: HOA customer service </span>
										</div>
										<div class="form-group">
											<label class="form-label">HOA Contact Phone</label>
											<input type="text" name="hoa_contact_number" id="hoa_contact_number" />
											<span class="text-input">example: 000-000-0000</span>
										</div>
									</div>
								</div>
							</div>
						</div>
					</fieldset>


					<!--	<h3>Policy Affidavit</h3>
                
                <fieldset>                   
                    
                     <h2>About Your Property</h2>
                            <p class="desc">Please enter your infomation and proceed to next step so we can build your account</p>
                    <div class="fieldset-content">
                        <div class="form-row">
                         <div class="form-group">
                                 <label class="form-label">(1.) Is This Your Property?[Insert Property Address Here]</label>
                                  <select id="loan" name="loantype">
                                  <option value="Select">Select</option>
                                  <option value="Yes">Yes</option>
                                  <option value="No">No</option>
                                  <option value="Not">Not Sure</option>
                                 </select>
                                   <span class="text-input">example: yes or no. </span>
                        </div>
                        </div>
                        <div class="form-row">
                         <div class="form-group">
                                 <label class="form-label">(2.) The land is either a one-to-four family residence or a condominium and does not have a separate structure, garage or apartment used as a second residence.</label>
                                  <select id="loan" name="loantype">
                                  <option value="Select">Select</option>
                                  <option value="Yes">Yes</option>
                                  <option value="No">No</option>
                                   <option value="Not">Not Sure</option>
                                 </select>
                                  <span class="text-input">example: yes or no. </span>
                        </div>
                        </div>
                        <div class="form-row">
                         <div class="form-group">
                                 <label class="form-label">(3.) There are no liens against the land and no judgments or tax liens against us, except those liens described in the Preliminary Report/Commitment issued by Pacific Coast Title Company.</label>
                                  <select id="loan" name="loantype">
                                  <option value="Select">Select</option>
                                  <option value="Yes">Yes</option>
                                  <option value="No">No</option>
                                   <option value="Not">Not Sure</option>
                                 </select>
                                   <span class="text-input">example: yes or no. </span>
                        </div>
                        </div>
                        <div class="form-row">
                         <div class="form-group">
                                 <label class="form-label">(4.) All taxes and assessments by a taxing authority are paid through the Kern Tax Collector and there have been no special tax assessments granted on the land or tax exemptions that were not lawful.</label>
                                  <select id="loan" name="loantype">
                                  <option value="Select">Select</option>
                                  <option value="Yes">Yes</option>
                                  <option value="No">No</option>
                                   <option value="Not">Not Sure</option>
                                 </select>
                                   <span class="text-input">example: yes or no. </span>
                        </div>
                        </div>
                        <div class="form-row">
                         <div class="form-group">
                                 <label class="form-label">(5.) If applicable, all assessments by the homeowner’s association for the subdivision/condominium are paid current and outstanding assessments are not yet payable.</label>
                                  <select id="loan" name="loantype">
                                  <option value="Select">Select</option>
                                  <option value="Yes">Yes</option>
                                  <option value="No">No</option>
                                   <option value="Not">Not Sure</option>
                                 </select>
                                  <span class="text-input">example: yes or no. </span>
                        </div>
                        </div>
                        <div class="form-row">
                         <div class="form-group">
                                 <label class="form-label">(6.) There have been no improvements added to the land or construction on the land within the last year.</label>
                                  <select id="loan" name="loantype">
                                  <option value="Select">Select</option>
                                  <option value="Yes">Yes</option>
                                  <option value="No">No</option>
                                   <option value="Not">Not Sure</option>
                                 </select>
                                  <span class="text-input">example: yes or no. </span>
                        </div>
                        </div>
                        <div class="form-row">
                         <div class="form-group">
                                 <label class="form-label">(7.) There are no pending repairs or improvements to the street(s) adjacent to the land.</label>
                                  <select id="loan" name="loantype">
                                  <option value="Select">Select</option>
                                  <option value="Yes">Yes</option>
                                  <option value="No">No</option>
                                   <option value="Not">Not Sure</option>
                                 </select>
                                   <span class="text-input">example: yes or no. </span>
                        </div>
                        </div>
                        <div class="form-row">
                         <div class="form-group">
                                 <label class="form-label">(8.) If applicable, a building permit from the proper government office authorized all improvements that we made to the land.</label>
                                  <select id="loan" name="loantype">
                                  <option value="Select">Select</option>
                                  <option value="Yes">Yes</option>
                                  <option value="No">No</option>
                                   <option value="Not">Not Sure</option>
                                 </select>
                                  <span class="text-input">example: yes or no. </span>
                        </div>
                        </div>
                        <div class="form-row">
                         <div class="form-group">
                                 <label class="form-label">(9.) We are not aware of and have not been told that the improvements on the land violate any building ordinances/regulations, zoning ordinances/regulations, restrictions or covenants.</label>
                                  <select id="loan" name="loantype">
                                  <option value="Select">Select</option>
                                  <option value="Yes">Yes</option>
                                  <option value="No">No</option>
                                   <option value="Not">Not Sure</option>
                                 </select>
                                   <span class="text-input">example: yes or no. </span>
                        </div>
                        </div>
                        <div class="form-row">
                         <div class="form-group">
                                 <label class="form-label">(10.) We are not aware of and have not been told that the improvements on the land described in Exhibit "A" encroach over any easement, property or building setback lines.</label>
                                  <select id="loan" name="loantype">
                                  <option value="Select">Select</option>
                                  <option value="Yes">Yes</option>
                                  <option value="No">No</option>
                                   <option value="Not">Not Sure</option>
                                 </select>
                                   <span class="text-input">example: yes or no. </span>
                        </div>
                        </div>
                        <div class="form-row">
                         <div class="form-group">
                                 <label class="form-label">(11.) We are not aware of and have not been told that the improvements by our neighbors encroach over our property or building setback lines.</label>
                                  <select id="loan" name="loantype">
                                  <option value="Select">Select</option>
                                  <option value="Yes">Yes</option>
                                  <option value="No">No</option>
                                   <option value="Not">Not Sure</option>
                                 </select>
                                   <span class="text-input">example: yes or no. </span>
                        </div>
                        </div>
                        <div class="form-row">
                         <div class="form-group">
                                 <label class="form-label">(12.) The land has actual pedestrian and vehicular access based on a legal right of access to the land.</label>
                                  <select id="loan" name="loantype">
                                  <option value="Select">Select</option>
                                  <option value="Yes">Yes</option>
                                  <option value="No">No</option>
                                   <option value="Not">Not Sure</option>
                                 </select>
                                   <span class="text-input">example: yes or no. </span>
                        </div>
                        </div>
                        <div class="form-row">
                         <div class="form-group">
                                 <label class="form-label">(13.) The affiants indemnify and hold Pacific Coast Title Company harmless from any loss, liability, costs, expenses, including attorneys’ fees, that Pacific Coast Title Company may suffer from errors on incorrect statements in these representations, actually known to the affiant(s), upon which Pacific Coast Title Company relies to issue the buyers an ALTA Homeowners Policy of Title Insurance for a one-to-four family residence.</label>
                                  <select id="loan" name="loantype">
                                  <option value="Select">Select</option>
                                  <option value="Yes">Yes</option>
                                  <option value="No">No</option>
                                   <option value="Not">Not Sure</option>
                                 </select>
                                   <span class="text-input">example: yes or no. </span>
                        </div>
                        </div>
                    </div>
                </fieldset>  -->
				</div>
			</form>
		</div>

	</div>

	<!-- JS -->
	<script src="<?php echo base_url();?>assets/buyer-seller-packets/vendor/jquery/jquery.min.js"></script>
	<script
		src="<?php echo base_url();?>assets/buyer-seller-packets/vendor/jquery-validation/dist/jquery.validate.min.js">
	</script>
	<script
		src="<?php echo base_url();?>assets/buyer-seller-packets/vendor/jquery-validation/dist/additional-methods.min.js">
	</script>
	<script src="<?php echo base_url();?>assets/buyer-seller-packets/vendor/jquery-steps/jquery.steps.min.js"></script>
	<script src="<?php echo base_url();?>assets/buyer-seller-packets/vendor/minimalist-picker/dobpicker.js"></script>
	<script src="<?php echo base_url();?>assets/buyer-seller-packets/vendor/nouislider/nouislider.min.js"></script>
	<script src="<?php echo base_url();?>assets/buyer-seller-packets/vendor/wnumb/wNumb.js"></script>
	<script src="<?php echo base_url();?>assets/buyer-seller-packets/js/main.js"></script>
</body>

</html>
