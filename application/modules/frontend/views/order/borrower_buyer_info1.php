<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="author" content="colorlib.com">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<title>Sign Up Form - Buyer</title>

	<!-- Font Icon -->
	<link rel="stylesheet"
		href="<?=base_url('assets/buyer-seller-packets/fonts/material-icon/css/material-design-iconic-font.min.css');?>">
	<!-- <link rel="stylesheet" href="<?=base_url('assets/buyer-seller-packets/vendor/nouislider/nouislider.min.css');?>"> -->

	<!-- Main css -->
	<link rel="stylesheet" href="<?=base_url('assets/buyer-seller-packets/css/style.css?buyer_v='.time());?>">
</head>

<style>
	.d-none {
		display: none;
	}

</style>

<body>

	<div class="main">

		<div>
			<div class="container2">

				<h1>Buyer Welcome Interview </h1>
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

			<form method="POST" id="signup-form" class="signup-form">
				<div>
					<h3>About You</h3>
					<input type="hidden" name="order_id" id="order_id" value="<?php echo $orderDetails['order_id'];?>">
					<fieldset>
						<h2>Personal information</h2>
						<p class="desc">Please enter your infomation and proceed to next step so we can build your
							account</p>
						<div class="fieldset-content">
							<?php if(count($buyers)) :?>
							<?php foreach($buyers as $key_buyer=>$buyer) :?>
							<div class="form-group">
								<p class="buyer_desc">
									<span class="desc_title">Buyer <?=($key_buyer+1)?></span>
									<span class="desc_border"></span>
								</p>
							</div>
							<div class="form-row">
								<div class="form-flex">
									<div class="form-group">
										<label class="form-label">First Name</label>
										<input type="text" name="buyer[<?=$buyer['id']?>][first_name]"
											required="required" value="<?=$buyer['first_name']?>" />
										<span class="text-input">example: John </span>
									</div>
									<div class="form-group">
										<label class="form-label">Last Name</label>
										<input type="text" name="buyer[<?=$buyer['id']?>][last_name]"
											required="required" value="<?=$buyer['last_name']?>" />
										<span class="text-input">example: Smith </span>
									</div>
								</div>
							</div>
							<div class="form-row">
								<div class="form-flex">
									<div class="form-group">
										<label for="email" class="form-label">Email</label>
										<input type="email" name="buyer[<?=$buyer['id']?>][email]" required="required"
											value="<?=$buyer['email']?>" />
										<span class="text-input">example: johnsmith@gmail.com </span>
									</div>
									<div class="form-group">
										<label for="phone" class="form-label">Mobile Phone #</label>
										<input class="phone_mask" type="text" name="buyer[<?=$buyer['id']?>][phone]"
											required="required" value="<?=$buyer['phone']?>"
											pattern="\(\d{3}\)[ ]?\d{3}[-]?\d{4}" />
										<span class="text-input">example: (000) 000-0000 </span>
									</div>
								</div>
							</div>

							<div class="form-row">
								<div class="form-flex">
									<div class="form-group form-date dob_date_picker_div">
										<label class="form-label">Birth Date</label>
										<div class="form-date-group">
											<div class="form-date-item">
												<select class="dob_birth_date" id="birth_date<?=$buyer['id']?>"
													name="buyer[<?=$buyer['id']?>][birth_date]" required="required"
													data-val="<?=$buyer['birth_date']?>"></select>
												<span class="text-input">DD</span>
											</div>
											<div class="form-date-item">
												<select class="dob_birth_month" id="birth_month<?=$buyer['id']?>"
													name="buyer[<?=$buyer['id']?>][birth_month]" required="required"
													data-val="<?=$buyer['birth_month']?>"></select>
												<span class="text-input">MM</span>
											</div>
											<div class="form-date-item">
												<select class="dob_birth_year" id="birth_year<?=$buyer['id']?>"
													name="buyer[<?=$buyer['id']?>][birth_year]" required="required"
													data-val="<?=$buyer['birth_year']?>"></select>
												<span class="text-input">YYYY</span>
											</div>
										</div>
									</div>

									<div class="form-group">
										<label class="form-label">Social Security No.</label>
										<input class="ssn" type="text" name="buyer[<?=$buyer['id']?>][ssn]"
											required="required" pattern="\d{3}-?\d{2}-?\d{4}"
											value="<?=$buyer['ssn']?>" />
										<span class="text-input">example: XXX-XX-XXXX </span>
									</div>

								</div>
							</div>
							<div class="form-group">
								<label class="form-label">Current Mailing Address</label>
								<input type="text" name="buyer[<?=$buyer['id']?>][current_mailing_address]"
									required="required" value="<?=$buyer['current_mailing_address']?>" />
								<span class="text-input">456 Main St. Los Angeles, CA </span>

							</div>
							<div class="form-group">
								<label class="form-label">Mailing Address Post Closing</label>
								<input type="text" name="buyer[<?=$buyer['id']?>][mailing_address_port_closing]"
									required="required"
									value="<?php echo ($buyer['mailing_address_port_closing'])?$buyer['mailing_address_port_closing']:$orderDetails['full_address'];?>" />
								<span class="text-input">456 Main St. Los Angeles, CA </span>

							</div>



							<?php  endforeach; ?>

							<?php endif; ?>

							<div class="form-row">
								<div class="form-group">
									<label class="form-label">Would You like to add another buyer?</label>
									<select name="is_another_buyer" class="buyer__show_hide_action"
										data-action="another_buyer" id="is_another_buyer" required="required">
										<option value="">Select</option>
										<option value="1">Yes</option>
										<option value="0">No</option>
									</select>
									<span class="text-input">example: yes or no. </span>
								</div>
							</div>

						</div>


						<div class="another_buyer buyer__show_hide_div" style="display: none;">
							<div class="fieldset-content">
								<div class="form-row">
									<div class="form-flex">
										<div class="form-group">
											<label class="form-label">First Name</label>
											<input type="text" name="buyer[new][first_name]" id="buyer_new_first_name"
												required="required" />
											<span class="text-input">example: John </span>
										</div>
										<div class="form-group">
											<label class="form-label">Last Name</label>
											<input type="text" name="buyer[new][last_name]" id="buyer_new_last_name"
												required="required" />
											<span class="text-input">example: Smith </span>
										</div>
									</div>
								</div>
								<div class="form-row">
									<div class="form-flex">
										<div class="form-group">
											<label for="email" class="form-label">Email</label>
											<input type="email" name="buyer[new][email]" required="required" />
											<span class="text-input">example: johnsmith@gmail.com </span>
										</div>
										<div class="form-group">
											<label for="phone" class="form-label">Mobile Phone #</label>
											<input class="phone_mask" type="text" name="buyer[new][phone]"
												required="required" pattern="\(\d{3}\)[ ]?\d{3}[-]?\d{4}" />
											<span class="text-input">example: (000) 000-0000 </span>
										</div>
									</div>
								</div>

								<div class="form-row">
									<div class="form-flex">
										<div class="form-group form-date dob_date_picker_div">
											<label class="form-label">Birth Date</label>
											<div class="form-date-group">
												<div class="form-date-item">
													<select class="dob_birth_date" id="birth_datenew"
														name="buyer[new][birth_date]" required="required"></select>
													<span class="text-input">DD</span>
												</div>
												<div class="form-date-item">
													<select class="dob_birth_month" id="birth_monthnew"
														name="buyer[new][birth_month]" required="required"></select>
													<span class="text-input">MM</span>
												</div>
												<div class="form-date-item">
													<select class="dob_birth_year" id="birth_yearnew"
														name="buyer[new][birth_year]" required="required"></select>
													<span class="text-input">YYYY</span>
												</div>
											</div>
										</div>
										<div class="form-group">
											<label class="form-label">Social Security No.</label>
											<input class="ssn" type="text" name="buyer[new][ssn]" required="required"
												pattern="\d{3}-?\d{2}-?\d{4}" />
											<span class="text-input">example: XXX-XX-XXXX </span>
										</div>

									</div>
								</div>
								<div class="form-group">
									<label class="form-label">Current Mailing Address</label>
									<input type="text" name="buyer[new][current_mailing_address]" required="required" />
									<span class="text-input">456 Main St. Los Angeles, CA </span>

								</div>
								<div class="form-group">
									<label class="form-label">Mailing Address Post Closing</label>
									<input type="text" name="buyer[new][mailing_address_port_closing]"
										required="required" value="<?php echo $orderDetails['full_address'];?>" />
									<span class="text-input">456 Main St. Los Angeles, CA </span>

								</div>

							</div>
						</div>
					</fieldset>


					<h3>Property & Loan</h3>

					<fieldset>

						<h2>About Your Property</h2>
						<p class="desc">Please enter your infomation and proceed to next step so we can build your
							account</p>
						<div class="form-row">
							<div class="form-group">
								<label class="form-label">Is this the property that you are buying:
									<?php echo $orderDetails['full_address'];?> </label>
								<select name="is_same_property" required="required">
									<option value="">Select</option>
									<option value="1">Yes</option>
									<option value="0">No</option>
								</select>
								<span class="text-input">example: yes or no. </span>
							</div>
						</div>
						<div class="form-group">
							<label class="form-label">Enter the Loan Amount that you applied For:</label>
							<input class="amount_mask" type="text" name="loan_amount" id="appliedloan"
								required="required" />
							<span class="text-input">example: $674,950 </span>

						</div>
						<div class="form-group">
							<label class="form-label">What is the Name of Your Lender?</label>
							<input type="text" name="lender_name" required="required" />
							<span class="text-input">Wells Fargo, Bank of America, etc. </span>

						</div>
						<div class="form-group">
							<label for="loanofficer" class="form-label">Enter You Loan Officers Name ( if applicable
								)</label>
							<input type="text" name="loan_officer_name" id="loanofficer" />
							<span class="text-input">John Smith </span>

						</div>

						<div class="form-row">
							<div class="form-flex">
								<div class="form-group">
									<label class="form-label">Enter Loan Officer Email ( if applicable )</label>
									<input type="email" name="loan_officer_email" id="loemail" />
									<span class="text-input">example: Johnsmith@abcloancompany.com </span>
								</div>
								<div class="form-group">
									<label class="form-label">Enter Loan Officer Phone Number ( if applicable )</label>
									<input class="phone_mask" type="text" name="loan_officer_phone" id="lophone"
										pattern="\(\d{3}\)[ ]?\d{3}[-]?\d{4}" />
									<span class="text-input">example: (800) 000-0000 </span>
								</div>
							</div>
						</div>


						<div class="form-row">
							<div class="form-group">
								<label class="form-label">Are you working with a loan processor?</label>
								<select name="is_loan_processor" class="buyer__show_hide_action"
									data-action="loan_processor_div" required="required">
									<option value="">Select</option>
									<option value="1">Yes</option>
									<option value="0">No</option>
								</select>
								<span class="text-input">example: yes or no. </span>
							</div>
						</div>

						<div class="loan_processor_div" style="display: none;">
							<div class="form-group">
								<label for="lpanofficer" class="form-label">Enter You Loan Processor Name </label>
								<input type="text" name="loan_processor_name" id="lpanofficer" required="required" />
								<span class="text-input">John Smith </span>

							</div>

							<div class="form-row">
								<div class="form-flex">
									<div class="form-group">
										<label class="form-label">Enter Loan Processor Email </label>
										<input type="email" name="loan_processor_email" id="lpemail"
											required="required" />
										<span class="text-input">example: Johnsmith@abcloancompany.com </span>
									</div>
									<div class="form-group">
										<label class="form-label">Enter Loan Processor Phone Number</label>
										<input class="phone_mask" type="text" name="loan_processor_phone" id="lpphone"
											required="required" pattern="\(\d{3}\)[ ]?\d{3}[-]?\d{4}" />
										<span class="text-input">example: (800) 000-0000 </span>
									</div>
								</div>
							</div>
						</div>



					</fieldset>

					<h3>About Your Insurance</h3>
					<fieldset>
						<h2>Home Insurance</h2>
						<p class="desc">Tell us a little bit about it. </p>
						<div class="fieldset-content">


							<div class="form-row">
								<div class="form-group">
									<label class="form-label">Insurance</label>
									<select name="is_home_ins" class="buyer__show_hide_action"
										data-action="home_ins_div" required="required">
										<option value="">Select</option>
										<option value="1">Yes</option>
										<option value="0">No</option>
									</select>
									<span class="text-input">example: yes or no.</span>
								</div>
							</div>
							<div class="home_ins_div" style="display: none;">

								<div class="form-row">
									<div class="form-group">
										<label class="form-label">Insuance Agency Name</label>
										<input type="text" name="ins_agency_name" required="required" />
										<span class="text-input">example: Statefarm, Allstate, etc. </span>
									</div>
								</div>

								<div class="form-row">
									<div class="form-group">
										<label class="form-label">Insurance Agent Name</label>
										<input type="text" name="ins_agent_name" required="required" />
										<span class="text-input">example: Statefarm, Allstate, etc. </span>
									</div>
								</div>


								<div class="form-row">
									<div class="form-flex">
										<div class="form-group">
											<label class="form-label">Insurance Agent's Email</label>
											<input type="email" name="ins_agent_email" required="required" />
											<span class="text-input">example: johnsmith@abcinsurance.com </span>
										</div>
										<div class="form-group">
											<label class="form-label">Insurance Agent's Phone Number</label>
											<input class="phone_mask" type="text" name="ins_agent_phone"
												required="required" pattern="\(\d{3}\)[ ]?\d{3}[-]?\d{4}" />
											<span class="text-input">example: (800) 000-0000 </span>
										</div>
									</div>
								</div>

								<div class="form-row">
									<div class="form-group">
										<label class="form-label">What Annual Premium were you quoted?</label>
										<input class="amount_mask" type="text" name="annual_premium"
											required="required" />
										<span class="text-input">example:$3600 annual premium </span>
									</div>
								</div>
							</div>



						</div>
					</fieldset>

					<h3>Vesting & Ownership</h3>
					<fieldset>
						<h2>Vesting & Ownership</h2>
						<p class="desc">Please review the relationship and martial status of each of the buyers </p>

						<?php if(count($buyers)) :?>
						<?php foreach($buyers as $key_buyer=>$buyer) :?>
						<div class="form-row vesting-buyer-div" data-id="<?=$buyer['id']?>">
							<div class="form-flex">
								<div class="form-group">
									<label for="email" class="form-label">Buyer <?=($key_buyer+1)?></label>
									<input type="text" name="" id=""
										value="<?=$buyer['first_name']." ".$buyer['last_name']?>" />
								</div>
								<div class="form-group">
									<label for="email" class="form-label">Marital Status</label>
									<select id="buyer_<?=$buyer['id']?>_marital_status"
										name="buyer[<?=$buyer['id']?>][marital_status]" required="required" class="buyer__show_hide_action has__data_val marital_status_select" data-action="married-to-option<?=$buyer['id']?>">
										<option value="" data-val="0">Select</option>
										<?php foreach($marital_status as $marital_status_key=>$marital_status_val) : ?>
											<option value="<?=$marital_status_key?>" data-val="<?=$marital_status_val['show_married_option'];?>"><?=$marital_status_val['text'];?></option>
										<?php endforeach; ?>
									</select>
								</div>
								<div class="form-group married-to-option<?=$buyer['id']?>" style="display: none;" >
									<label for="email" class="form-label">Married To:</label>
									<select class="married married_option_change" id="buyer_<?=$buyer['id']?>_married_to"
										name="buyer[<?=$buyer['id']?>][married_to]" data-related="">
										<option value="">Select</option>
										<?php foreach($buyers as $key_buyer_married_to=>$buyer_married_to) :?>
										<?php if($buyer_married_to['id'] != $buyer['id']) :?>
										<option value="<?=$buyer_married_to['id']?>">
											<?=$buyer_married_to['first_name']." ".$buyer_married_to['last_name']?>
										</option>
										<?php endif; ?>
										<?php endforeach; ?>
									</select>
								</div>
							</div>
						</div>
						<?php $new_buyer_index = $key_buyer+1;?>
						<?php endforeach; ?>
						<?php endif; ?>

						<div class="form-row d-none" id="new_buyer_vesting_container" class="vesting-buyer-div" data-id="new">
							<div class="form-flex">
								<div class="form-group">
									<label for="email" class="form-label">Buyer <?=($new_buyer_index+1)?></label>
									<input type="text" name="new_buyer_name" id="new_buyer_name" value="" />
								</div>
								<div class="form-group">
									<label for="email" class="form-label">Marital Status</label>
									<select id="buyer_new_marital_status" name="buyer[new][marital_status]"
										required="required" class="buyer__show_hide_action has__data_val" data-action="married-to-optionnew">
										<option value="">Select</option>
										<?php foreach($marital_status as $marital_status_key=>$marital_status_val) : ?>
											<option value="<?=$marital_status_key?>" data-val="<?=$marital_status_val['show_married_option'];?>"><?=$marital_status_val['text'];?></option>
										<?php endforeach; ?>
									</select>
								</div>
								<div class="form-group married-to-optionnew" style="display: none;" >
									<label for="email" class="form-label">Married To:</label>
									<select class="married married_option_change"  id="buyer_new_married_to" name="buyer[new][married_to]" data-related="">
										<option value="">Select</option>
										<?php foreach($buyers as $key_buyer_married_to=>$buyer_married_to) :?>

										<option value="<?=$buyer_married_to['id']?>">
											<?=$buyer_married_to['first_name']." ".$buyer_married_to['last_name']?>
										</option>
										<?php endforeach; ?>
									</select>
								</div>
							</div>
						</div>

						<div class="form-row">
							<div class="form-group">
								<label class="form-label">Please tell us how the property will be vested:</label>
								<select id="property_vested" name="property_vested" required="required">
									<option value="">Select</option>
									<?php foreach($vesting_choice as $vesting_choice_key=>$vesting_choice_val) : ?>
											<option value="<?=$vesting_choice_key?>" ><?=$vesting_choice_val['text'];?></option>
										<?php endforeach; ?>
								</select>
								<!-- <span class="text-input">example: yes or no. </span> -->
							</div>
						</div>
					</fieldset>
					<h3>Confirmation</h3>
					<fieldset>
						<h2>Confirmation</h2>
						<p>&nbsp;</p>
						<p class="desc">Signing below indicates that the information included here is correct and
							complete to the best of my knowledge and ackowledges and accepts the information included in
							this document.</p>
						<p class="desc">You must click below Finish button to securely send your completed forms to
							Pacific Coast Title Company.</p>
					</fieldset>
				</div>
			</form>
		</div>
	</div>

	<!-- JS -->
	<script src="<?=base_url('assets/buyer-seller-packets/vendor/jquery/jquery.min.js');?>"></script>
	<script src="<?=base_url('assets/buyer-seller-packets/vendor/jquery-validation/dist/jquery.validate.min.js');?>">
	</script>
	<script src="<?=base_url('assets/buyer-seller-packets/vendor/jquery-validation/dist/additional-methods.min.js');?>">
	</script>
	<script src="<?=base_url('assets/buyer-seller-packets/vendor/jquery-steps/jquery.steps.min.js');?>"></script>
	<script src="<?=base_url('assets/buyer-seller-packets/vendor/minimalist-picker/dobpicker.js');?>"></script>
	<script src="<?=base_url('assets/buyer-seller-packets/vendor/nouislider/nouislider.min.js');?>"></script>
	<script src="<?=base_url('assets/buyer-seller-packets/vendor/wnumb/wNumb.js');?>"></script>
	<script src="<?=base_url('assets/buyer-seller-packets/vendor/input-mask/jquery.mask.min.js');?>"></script>
	<script src="<?=base_url('assets/buyer-seller-packets/js/buyer-main.js?buyer_v='.time());?>"></script>
</body>

</html>
