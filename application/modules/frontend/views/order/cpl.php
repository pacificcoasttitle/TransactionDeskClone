<style>
	.ui-autocomplete { position: absolute; cursor: default;z-index:10000 !important;}  
	.ui-autocomplete {
		max-height: 300px !important;
	} 
	.radio {
		top: 5px !important;
		margin: 0px 10px !important;
	}
	.radio:before {
		background: none !important;
	}
</style>

<section class="section-type-4a section-defaulta" style="padding-bottom:0px;">
	<div class="container">
		<div class="row">
			<div class="row">
				<div class="col-xs-12">
					<div class="typography-section__inner">
						<h2 class="ui-title-block ui-title-block_light">Closing Protection Letters</h2>
						<div class="ui-decor-1a bg-accent"></div>
						<h3 class="ui-title-block_light">Generate your CPL</h3>
					</div>
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
					<!-- <div class="loader"></div> -->
					<div class="typography-sectiona">
						<div class="col-md-12">
							<div class="table-container">
								<table class="table table-type-3 typography-last-elem no-footer" id="cpl_listing">
									<thead>
										<tr style="text-align: center;">
											<th>#</th>
											<th>File Number</th>
											<th>Property Address</th>
											<th>Created</th>
											<th>Action</th>
										</tr>
									</thead>
									<tbody>

									</tbody>
								</table>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>

<div class="modal fade" width="500px" id="lender_information" tabindex="-1" role="dialog"
	aria-labelledby="Lender Infromation" aria-hidden="true">
	<div class="modal-dialog modal-lg" role="document" style="width:40%;">
		<div class="modal-content">
			<form method="POST" action="<?php echo base_url();?>add-lender-order" enctype="multipart/form-data">
				<div class="smart-forms smart-container wrap-2" style="margin:30px">
					<div class="modal-body search-result">
						<div id="lender-details-fields" style="">
							<div class="spacer-b20">
								<div class="tagline"><span>Lender Details</span></div><!-- .tagline -->
							</div>

							<div class="frm-row">
								<div class="section colm colm12">
									<label class="field prepend-icon">
										<input class="radio" type="radio" name="new_existing_lender" id="add_lender" value="add_lender">New Lender	
										<input class="radio" type="radio" name="new_existing_lender" id="existing_lender" value="existing_lender">Existing Lender
									</label>
								</div>
							</div>

							<div class="frm-row">
								<div class="section colm colm12">
									<label class="field prepend-icon">
										<input type="text" name="LenderCompany" id="LenderCompany" class="gui-input ui-autocomplete-input"
											placeholder="Lender Company Name" required="required">
										<span class="field-icon"><i class="fa fa-user"></i></span>
										
										<input type="hidden" name="LenderId" id="LenderId" value="">
										<input type="hidden" name="file_id" id="file_id" value="">
										<input type="hidden" name="partner_id" id="partner_id" value="">
									</label>
								</div>
							</div>

							<div class="frm-row">
								<div class="section colm colm12">
									<label class="field prepend-icon">
										<input type="text" name="assignment_clause" id="assignment_clause" class="gui-input ui-autocomplete-input"
											placeholder="Assignment Clause">
										<span class="field-icon"><i class="fa fa-user"></i></span>
									</label>
								</div>
							</div>

							<div class="frm-row">
								<div class="section colm colm12">
									<label class="field prepend-icon">
										<input type="text" name="LenderName" id="LenderName"
											class="gui-input" placeholder="Attention"
											autocomplete="off">
										<span class="field-icon"><i class="fa fa-user"></i></span>
									</label>
								</div>
							</div>

							<div class="frm-row">
								<div class="section colm colm6">
									<label class="field prepend-icon">
										<input type="text" name="LenderAddress" id="LenderAddress" class="gui-input"
											placeholder="Lender Address" required="required">
										<span class="field-icon"><i class="fa fa-envelope"></i></span>
									</label>
								</div>

								<div class="section colm colm6">
									<label class="field prepend-icon">
										<input type="text" name="LenderCity" id="LenderCity" class="gui-input"
											placeholder="Lender City" required="required">
										<span class="field-icon"><i class="fa fa-envelope"></i></span>
									</label>
								</div>
							</div>

							<div class="frm-row">
								<div class="section colm colm6">
									<label class="field prepend-icon">
										<input type="text" name="LenderState" id="LenderState" class="gui-input"
											placeholder="Lender State">
										<span class="field-icon"><i class="fa fa-envelope"></i></span>
									</label>
								</div>

								<div class="section colm colm6">
									<label class="field prepend-icon">
										<input type="text" name="LenderZipcode" id="LenderZipcode" class="gui-input"
											placeholder="Lender Zipcode" required="required">
										<span class="field-icon"><i class="fa fa-envelope"></i></span>
									</label>
								</div>
							</div>

							<div class="spacer-b20">
								<div class="tagline"><span>Property Address</span></div>
							</div>

							<div class="frm-row">
								<div class="section colm colm6">
									<label class="field prepend-icon">
										<input required="required" type="text" class="gui-input" name="property_address" id="property_address" placeholder="Property Address">
										<span class="field-icon"><i class="fa fa-envelope"></i></span>
									</label>
								</div>

								<div class="section colm colm6">
									<label class="field prepend-icon">
										<input type="text" name="property_city" id="property_city" class="gui-input"
											placeholder="Property City" required="required">
										<span class="field-icon"><i class="fa fa-envelope"></i></span>
									</label>
								</div>
							</div>

							<div class="frm-row">
								<div class="section colm colm6">
									<label class="field prepend-icon">
										<input type="text" name="property_state" id="property_state" class="gui-input"
											placeholder="Property State" required="required">
										<span class="field-icon"><i class="fa fa-envelope"></i></span>
									</label>
								</div>

								<div class="section colm colm6">
									<label class="field prepend-icon">
										<input type="text" name="property_zipcode" id="property_zipcode" class="gui-input"
											placeholder="Property Zipcode" required="required">
										<span class="field-icon"><i class="fa fa-envelope"></i></span>
									</label>
								</div>
							</div>

							<div class="spacer-b20">
								<div class="tagline"><span>Loan Details</span></div><!-- .tagline -->
							</div>

							<div class="frm-row spacer-b15">
								<div class="section colm colm12">
									<label class="field">
										<input required="required" type="text" class="gui-input" name="loan_number" id="loan_number" placeholder="Loan Number">
									</label>
								</div>
							</div>

							<div class="spacer-b20">
								<div class="tagline"><span>Borrowers & Vesting</span></div><!-- .tagline -->
							</div>

							<div class="frm-row spacer-b15">
								<div class="section colm colm12">
									<label class="field prepend-icon">
										<input type="text" name="borrowers_vesting" id="borrowers_vesting" class="gui-input"
											placeholder="Primary Borrower Name"  required="required">
										<span class="field-icon"><i class="fa fa-user"></i></span>
									</label>
								</div>
							</div>

							<input type="hidden" id="cpl_api" name="cpl_api" value="">
							<div id="fnf">
								<div class="spacer-b20">
									<div class="tagline"><span>Select Branch</span></div>
								</div>

								<div class="frm-row">
									<div class="section colm colm12">
									<label class="field select">
											<select id="branch" name="branch">
												<option value="">Select Branch</option>
											</select>
											<i class="arrow double"></i>
										</label>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="form-footer" style="margin: 0px 20px;">
						<button type="submit" data-btntext-sending="Sending..."
							class="button btn-primary">Submit</button>
						<button type="reset" data-dismiss="modal" aria-label="Close" class="button">Cancel</button>
					</div>
				</div>
			</form>
		</div>
	</div>
</div>
	




