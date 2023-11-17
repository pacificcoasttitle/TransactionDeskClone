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
	.section-type-4a .btn {
		width: 220px;
	}
</style>

<body>
	<?php
        $this->load->view('layout/header_dashboard');
    ?>

	<section class="section-type-4a section-defaulta" style="padding-bottom:100px;">
		<div class="container">
			<div class="row">
				<div class="row">
					<div class="col-xs-12">
						<div class="typography-section__inner" style="padding: 0px 17px;">
							<h2 class="ui-title-block ui-title-block_light">Buyer & Seller Package</h2>
							<div class="ui-decor-1a bg-accent"></div>
							<!-- <h3 class="ui-title-block_light">Generate your CPL</h3> -->
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
											<tr>
												<th>#</th>
												<th>File Number</th>
												<th>Property Address</th>
												<th>Created</th>
												<th>Action</th>
											</tr>
										</thead>
										<tbody>
											<?php if(!empty($file_number)) {?>
												<tr role="row" class="odd">
													<td>1</td>
													<td><?php echo $file_number;?></td>
													<td><?php echo $full_address;?></td>
													<td><?php echo $created;?></td>
													<td><?php echo $action;?></td> 
												</tr>
											<?php } else { ?>
												<tr role="row" class="odd"><td colspan="4" class="text-center">No record found</td></tr>
											<?php }  ?>
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

	<div class="modal fade" width="500px" id="buyer_welcome" tabindex="-1" role="dialog"
	aria-labelledby="Buyer Infromation" aria-hidden="true">
		<div class="modal-dialog modal-lg" role="document" style="width:40%;">
			<div class="modal-content">
				<form method="POST" action="<?php echo base_url();?>add-buyer-on-order-mail" enctype="multipart/form-data">
					<div class="smart-forms smart-container wrap-2" style="margin:30px">
						<div class="modal-body search-result">
							
								<div id="lender-details-fields" >
									
									<div class="spacer-b25">
										<div class="tagline"><span>Buyer Info</span></div>
									</div>

									<div id="buyer-info-clone-group-fields">
										<div class="toclone clone-widget">
											<div class="frm-row">
												<div class="section colm colm12">
													<label class="field prepend-icon">
														<input type="text" name="buyer_emails[]" id="buyer_email" class="gui-input ui-autocomplete-input"
															placeholder="Email Address" required="required">
														<span class="field-icon"><i class="fa fa-user"></i></span>
													</label>
												</div>

												<div class="section colm colm6">
													<label class="field prepend-icon">
														<input type="text" name="buyer_first_names[]" id="buyer_first_name" class="gui-input ui-autocomplete-input"
															placeholder="First Name" required="required">
														<span class="field-icon"><i class="fa fa-user"></i></span>
													</label>
												</div>
												<div class="section colm colm6">
													<label class="field prepend-icon">
														<input type="text" name="buyer_last_names[]" id="buyer_last_name" class="gui-input ui-autocomplete-input"
															placeholder="Last Name" required="required">
														<span class="field-icon"><i class="fa fa-user"></i></span>
													</label>
												</div>
												<div class="section colm colm12">	
													<label class="field prepend-icon">	
														<input class="radio" type="radio" name="is_main_buyer" id="is_main_buyer" value="is_main_buyer0" required="required">Primary Buyer		
													</label>	
												</div>
											</div>
											<a href="#" class="mr-5 clone button btn-primary"><i class="fa fa-plus"></i></a>
											<a href="#" class="delete button"><i class="fa fa-minus"></i></a>
										</div>
									</div>							
								</div>
							

							<input type="hidden" name="order_id" id="order_id" value="<?php echo $orderDetails['order_id'];?>">
							<input type="hidden" name="file_id" id="file_id" value="<?php echo $orderDetails['file_id'];?>">
						</div>

						<div class="form-footer" style="padding-top:0px;">
							<button type="submit" data-btntext-sending="Sending..."
								class="button btn-primary">Submit</button>
							<button type="button" data-dismiss="modal" aria-label="Close" class="button">Cancel</button>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>

	<div class="modal fade" width="500px" id="seller_welcome" tabindex="-1" role="dialog"
		aria-labelledby="Seller Infromation" aria-hidden="true">
		<div class="modal-dialog modal-lg" role="document" style="width:40%;">
			<div class="modal-content">
				<form method="POST" action="<?php echo base_url();?>add-seller-on-order-mail" enctype="multipart/form-data">
					<div class="smart-forms smart-container wrap-2" style="margin:30px">
						<div class="modal-body search-result">
							
								<div id="lender-details-fields" >
									
									<div class="spacer-b25">
										<div class="tagline"><span>Seller Info</span></div>
									</div>

									<div id="seller-info-clone-group-fields">
										<div class="toclone clone-widget">
											<div class="frm-row">
												<div class="section colm colm12">
													<label class="field prepend-icon">
														<input type="text" name="seller_emails[]" id="seller_email" class="gui-input ui-autocomplete-input"
															placeholder="Email Address" required="required">
														<span class="field-icon"><i class="fa fa-user"></i></span>
													</label>
												</div>

												<div class="section colm colm6">
													<label class="field prepend-icon">
														<input type="text" name="seller_first_names[]" id="seller_first_name" class="gui-input ui-autocomplete-input"
															placeholder="First Name" required="required">
														<span class="field-icon"><i class="fa fa-user"></i></span>
													</label>
												</div>
												<div class="section colm colm6">
													<label class="field prepend-icon">
														<input type="text" name="seller_last_names[]" id="seller_last_name" class="gui-input ui-autocomplete-input"
															placeholder="Last Name" required="required">
														<span class="field-icon"><i class="fa fa-user"></i></span>
													</label>
												</div>
												<div class="section colm colm12">	
													<label class="field prepend-icon">	
														<input class="radio" type="radio" name="is_main_seller" id="is_main_seller" value="is_main_seller0" required="required">Primary Seller		
													</label>	
												</div>
											</div>
											<a href="#" class="mr-5 clone button btn-primary"><i class="fa fa-plus"></i></a>
											<a href="#" class="delete button"><i class="fa fa-minus"></i></a>
										</div>
									</div>							
								</div>
							

							<input type="hidden" name="order_id" id="order_id" value="<?php echo $orderDetails['order_id'];?>">
							<input type="hidden" name="file_id" id="file_id" value="<?php echo $orderDetails['file_id'];?>">
						</div>

						<div class="form-footer" style="padding-top:0px;">
							<button type="submit" data-btntext-sending="Sending..."
								class="button btn-primary">Submit</button>
							<button type="button" data-dismiss="modal" aria-label="Close" class="button">Cancel</button>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>


	<?php
        $this->load->view('layout/footer');
    ?>
</body>

</html>

<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/frontend/css/smart-forms.css">
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/frontend/css/font-awesome.min.css">
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/frontend/css/jquery-ui.css">


<script type="text/javascript" src="<?php echo base_url(); ?>assets/frontend/js/jquery.form.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/frontend/js/jquery.validate.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/frontend/js/additional-methods.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/frontend/js/smart-form.js"></script> 
<script type="text/javascript" src="<?php echo base_url(); ?>assets/frontend/js/jquery-ui.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/frontend/js/jquery-cloneya.min.js"></script>



<script>
	/* Lender autocomplete */
	$(document).ready(function () {
		$('#seller-info-clone-group-fields').cloneya({
			maximum: 5
		}).on('after_append.cloneya', function (event, toclone, newclone) {
			var id = $(newclone).find("input[name='is_main_seller']").attr('id');
			$('#'+id).val(id);
		}).off('remove.cloneya').on('remove.cloneya', function (event, clone) {
			$(clone).slideToggle('slow', function () {
				$(clone).remove();
			})
		});
		$('#buyer-info-clone-group-fields').cloneya({
			maximum: 5
		}).on('after_append.cloneya', function (event, toclone, newclone) {
			var id = $(newclone).find("input[name='is_main_seller']").attr('id');
			$('#'+id).val(id);
		}).off('remove.cloneya').on('remove.cloneya', function (event, clone) {
			$(clone).slideToggle('slow', function () {
				$(clone).remove();
			})
		});
	});
</script>
