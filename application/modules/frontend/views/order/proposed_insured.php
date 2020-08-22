<style>
	.smart-forms .prepend-icon .field-icon {
		top: 14px !important;
	}
	.ui-autocomplete { position: absolute; cursor: default;z-index:10000 !important;} 
	.error {
		color: #FF2F0F !important;
	}
	.ui-helper-clearfix:before, .ui-helper-clearfix:after {
		border: none !important;
	}
	.ui-datepicker {
		margin-top: 0px !important;
	}

	table#orders_listing tr td:last-child {
		display: inline-flex;
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
				<div class="row">
					<div class="col-xs-12">
						<div class="typography-section__inner">
							<h2 class="ui-title-block ui-title-block_light">Generate Proposed Insured</h2>
							<div class="ui-decor-1a bg-accent"></div>
							<h3 class="ui-title-block_light">Below are all files</h3>
						</div>
						<div class="typography-sectiona">
							<div class="col-md-12">
								<div class="table-container">
									<table class="table table-type-3 typography-last-elem no-footer" id="orders_listing">
										<thead>
											<tr>
												<th>#</th>
												<th>File Number</th>
												<th>Property Address</th>
												<th style="text-align: center;">Action</th>
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

	<?php
           $this->load->view('layout/footer');
    ?>
    <div class="modal fade" width="500px" id="lender_information" tabindex="-1" role="dialog"
		aria-labelledby="Lender Infromation" aria-hidden="true">
		<div class="modal-dialog modal-lg" role="document" style="width:40%;">
			<div class="modal-content">
				<form method="POST" id="add-order-details" enctype="multipart/form-data">
					<input type="hidden" name="orderId" value="" id="orderId">

					<input type="hidden" name="property_id" value="" id="property_id">

					<input type="hidden" name="transaction_id" value="" id="transaction_id">

					<input type="hidden" name="fileId" value="" id="fileId">

					<input type="hidden" name="LenderId" value="" id="LenderId">
					<div class="smart-forms smart-container wrap-2" style="margin:30px">
						<div class="modal-body search-result">
							<div id="lender-details-fields" style="">
								<div class="spacer-b20">
									<div class="tagline"><span>Lender Details</span></div><!-- .tagline -->
								</div>
								<div class="frm-row">
								<div class="section colm colm12">
									<label class="field prepend-icon">
										<input type="text" name="LenderCompany" id="LenderCompany" class="gui-input ui-autocomplete-input"
											placeholder="Lender Company Name">
										<span class="field-icon"><i class="fa fa-user"></i></span>
										
										
									</label>
								</div><!-- end section -->
							</div>
							<div class="frm-row">
								<div class="section colm colm6">
									<label class="field prepend-icon">
										<input type="email" name="LenderEmailAddress" id="LenderEmailAddress"
											class="gui-input" placeholder="Lender Email address" >
										<span class="field-icon"><i class="fa fa-envelope"></i></span>
									</label>
								</div>
								<div class="section colm colm6">
									<label class="field prepend-icon">
										<input type="tel" name="LenderTelephone" id="LenderTelephone" class="gui-input"
											placeholder="Lender Telephone" >
										<span class="field-icon"><i class="fa fa-phone-square"></i></span>
									</label>
								</div>
							</div>
							<div class="frm-row">
								<div class="section colm colm6">
									<label class="field prepend-icon">
										<input type="text" name="LenderName" id="LenderName"
											class="gui-input" placeholder="Lender Name"
											autocomplete="off">
										<span class="field-icon"><i class="fa fa-user"></i></span>
									</label>
								</div>
								<div class="section colm colm6">
									<label class="field prepend-icon">
										<input type="text" name="LenderAddress" id="LenderAddress" class="gui-input"
											placeholder="Lender Address" >
										<span class="field-icon"><i class="fa fa-envelope"></i></span>
									</label>
								</div>
							</div>
							<div class="frm-row spacer-b15">
								<div class="section colm colm6">
									<label class="field prepend-icon">
										<input type="text" name="LenderCity" id="LenderCity" class="gui-input"
											placeholder="Lender City" >
										<span class="field-icon"><i class="fa fa-user"></i></span>
									</label>
								</div>
								<div class="section colm colm6">
									<label class="field prepend-icon">
										<input type="text" name="LenderZipcode" id="LenderZipcode" class="gui-input"
											placeholder="Lender Zipcode" >
										<span class="field-icon"><i class="fa fa-envelope"></i></span>
									</label>
								</div>
							</div>
							</div>
							<div id="title-officer-section">
							<div class="spacer-b20">
								<div class="tagline"><span>Title Officer Details</span></div><!-- .tagline -->
							</div>
							<div class="frm-row">
								<div class="section colm colm12">
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
							</div>
							</div>
							<div id="loan-details-section">
							<div class="spacer-b20">
								<div class="tagline"><span>Loan Details</span></div><!-- .tagline -->
							</div>
							<div class="frm-row spacer-b15">
									<div class="section colm colm6">
										<label class="field">
											<input type="text" class="gui-input" name="loan_amount" id="loan_amount" placeholder="Loan Amount">
										</label>
									</div>
									<div class="section colm colm6">
										<label class="field">
											<input type="text" class="gui-input" name="loan_number" id="loan_number" placeholder="Loan Number">
										</label>
									</div>
								</div>
							</div>
							<div id="primary-borrower-section">
							<div class="spacer-b20">
								<div class="tagline"><span>Primary Borrower Information</span></div><!-- .tagline -->
							</div>
							<div class="frm-row spacer-b15">
								<div class="section colm colm6">
									<label class="field prepend-icon">
										<input type="text" name="primary_first_name" id="primary_first_name" class="gui-input"
											placeholder="First Name" >
										<span class="field-icon"><i class="fa fa-user"></i></span>
									</label>
								</div>
								<div class="section colm colm6">
									<label class="field prepend-icon">
										<input type="text" name="primary_last_name" id="primary_last_name" class="gui-input"
											placeholder="Last Name" >
										<span class="field-icon"><i class="fa fa-user"></i></span>
									</label>
								</div>
							</div>
							</div>
							<div id="secondary-borrower-section">
							<div class="spacer-b20">
								<div class="tagline"><span>Secondary Borrower Information</span></div><!-- .tagline -->
							</div>
							<div class="frm-row spacer-b15">
								<div class="section colm colm6">
									<label class="field prepend-icon">
										<input type="text" name="first_name" id="first_name" class="gui-input"
											placeholder="First Name">
										<span class="field-icon"><i class="fa fa-user"></i></span>
									</label>
								</div>
								<div class="section colm colm6">
									<label class="field prepend-icon">
										<input type="text" name="last_name" id="last_name" class="gui-input"
											placeholder="Last Name">
										<span class="field-icon"><i class="fa fa-user"></i></span>
									</label>
								</div>
							</div>
							</div>
							<div id="report-date-section">
							<div class="spacer-b20">
								<div class="tagline"><span>Report Date Section</span></div><!-- .tagline -->
							</div>
							<div class="frm-row">
								<div class="section colm colm6" id="s-date-section">
									<label class="field prepend-icon">
										<input type="text" name="supplemental_report_date" id="supplemental_report_date" class="gui-input" placeholder="Supplemental Report Date" value="<?php echo date('m/d/Y'); ?>">
										<span class="field-icon"><i class="fa fa-calendar"></i></span>
									</label>
								</div>
								<div class="section colm colm6" id="p-date-section">
									<label class="field prepend-icon">
										<input type="text" name="preliminary_report_date" id="preliminary_report_date" class="gui-input" placeholder="Preliminary Report Date" value="<?php echo date('m/d/Y'); ?>">
										<span class="field-icon"><i class="fa fa-calendar"></i></span>
									</label>
								</div>
							</div>
							</div>
						</div>
						<div class="form-footer" style="margin: 0px 20px;">
							<button type="submit" data-btntext-sending="Sending..." class="button btn-primary">Submit</button>
							<button type="reset" data-dismiss="modal" aria-label="Close" class="button">Cancel</button>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>

	<!-- Edit info modal -->
	<div class="modal fade" width="500px" id="edit_information" tabindex="-1" role="dialog"
		aria-labelledby="Lender Infromation" aria-hidden="true">
		<div class="modal-dialog modal-lg" role="document" style="width:40%;">
			<div class="modal-content">
				<form method="POST" id="edit-order-details" enctype="multipart/form-data">
					<input type="hidden" name="orderId" value="" id="edit_orderId">

					<input type="hidden" name="property_id" value="" id="edit_property_id">

					<input type="hidden" id="edit_transaction_id" value="" name="transaction_id">

					<input type="hidden" name="fileId" value="" id="edit_fileId">

					<input type="hidden" name="LenderId" value="" id="edit_LenderId">
					<div class="smart-forms smart-container wrap-2" style="margin:30px">
						<div class="modal-body search-result">
							<div id="edit-data-result" class="spacer-b20"></div>
							<div id="lender-details-fields" style="">
								<div class="spacer-b20">
									<div class="tagline"><span>Lender Details</span></div><!-- .tagline -->
								</div>
								<div class="frm-row">
								<div class="section colm colm12">
									<label class="field prepend-icon">
										<input type="text" name="LenderCompany" id="edit_LenderCompany" class="gui-input ui-autocomplete-input"
											placeholder="Lender Company Name">
										<span class="field-icon"><i class="fa fa-user"></i></span>
										
										
									</label>
								</div><!-- end section -->
							</div>
							<div class="frm-row">
								<div class="section colm colm6">
									<label class="field prepend-icon">
										<input type="email" name="LenderEmailAddress" id="edit_LenderEmailAddress"
											class="gui-input" placeholder="Lender Email address" >
										<span class="field-icon"><i class="fa fa-envelope"></i></span>
									</label>
								</div>
								<div class="section colm colm6">
									<label class="field prepend-icon">
										<input type="tel" name="LenderTelephone" id="edit_LenderTelephone" class="gui-input"
											placeholder="Lender Telephone" >
										<span class="field-icon"><i class="fa fa-phone-square"></i></span>
									</label>
								</div>
							</div>
							<div class="frm-row">
								<div class="section colm colm6">
									<label class="field prepend-icon">
										<input type="text" name="LenderName" id="edit_LenderName"
											class="gui-input" placeholder="Lender Name"
											autocomplete="off">
										<span class="field-icon"><i class="fa fa-user"></i></span>
									</label>
								</div>
								<div class="section colm colm6">
									<label class="field prepend-icon">
										<input type="text" name="LenderAddress" id="edit_LenderAddress" class="gui-input"
											placeholder="Lender Address" >
										<span class="field-icon"><i class="fa fa-envelope"></i></span>
									</label>
								</div>
							</div>
							<div class="frm-row spacer-b15">
								<div class="section colm colm6">
									<label class="field prepend-icon">
										<input type="text" name="LenderCity" id="edit_LenderCity" class="gui-input"
											placeholder="Lender City" >
										<span class="field-icon"><i class="fa fa-user"></i></span>
									</label>
								</div>
								<div class="section colm colm6">
									<label class="field prepend-icon">
										<input type="text" name="LenderZipcode" id="edit_LenderZipcode" class="gui-input"
											placeholder="Lender Zipcode" >
										<span class="field-icon"><i class="fa fa-envelope"></i></span>
									</label>
								</div>
							</div>
							</div>
							<div id="title-officer-section">
							<div class="spacer-b20">
								<div class="tagline"><span>Title Officer Details</span></div><!-- .tagline -->
							</div>
							<div class="frm-row">
								<div class="section colm colm12">
									<label class="field select">
                                        <select id="edit_TitleOfficer" name="TitleOfficer">
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
							</div>
							</div>
							<div id="loan-details-section">
							<div class="spacer-b20">
								<div class="tagline"><span>Loan Details</span></div><!-- .tagline -->
							</div>
							<div class="frm-row spacer-b15">
									<div class="section colm colm6">
										<label class="field">
											<input type="text" class="gui-input" name="loan_amount" id="edit_loan_amount" placeholder="Loan Amount">
										</label>
									</div>
									<div class="section colm colm6">
										<label class="field">
											<input type="text" class="gui-input" name="loan_number" id="edit_loan_number" placeholder="Loan Number">
										</label>
									</div>
								</div>
							</div>
							<div id="primary-borrower-section">
							<div class="spacer-b20">
								<div class="tagline"><span>Primary Borrower Information</span></div><!-- .tagline -->
							</div>
							<div class="frm-row spacer-b15">
								<div class="section colm colm6">
									<label class="field prepend-icon">
										<input type="text" name="primary_first_name" id="edit_primary_first_name" class="gui-input"
											placeholder="First Name" >
										<span class="field-icon"><i class="fa fa-user"></i></span>
									</label>
								</div>
								<div class="section colm colm6">
									<label class="field prepend-icon">
										<input type="text" name="primary_last_name" id="edit_primary_last_name" class="gui-input"
											placeholder="Last Name" >
										<span class="field-icon"><i class="fa fa-user"></i></span>
									</label>
								</div>
							</div>
							</div>
							<div id="secondary-borrower-section">
							<div class="spacer-b20">
								<div class="tagline"><span>Secondary Borrower Information</span></div><!-- .tagline -->
							</div>
							<div class="frm-row spacer-b15">
								<div class="section colm colm6">
									<label class="field prepend-icon">
										<input type="text" name="first_name" id="edit_first_name" class="gui-input"
											placeholder="First Name">
										<span class="field-icon"><i class="fa fa-user"></i></span>
									</label>
								</div>
								<div class="section colm colm6">
									<label class="field prepend-icon">
										<input type="text" name="last_name" id="edit_last_name" class="gui-input"
											placeholder="Last Name">
										<span class="field-icon"><i class="fa fa-user"></i></span>
									</label>
								</div>
							</div>
							</div>
							<div id="report-date-section">
							<div class="spacer-b20">
								<div class="tagline"><span>Report Date Section</span></div><!-- .tagline -->
							</div>
							<div class="frm-row">
								<div class="section colm colm6" id="s-date-section">
									<label class="field prepend-icon">
										<input type="text" name="supplemental_report_date" id="edit_supplemental_report_date" class="gui-input" placeholder="Supplemental Report Date" value="<?php echo date('m/d/Y'); ?>">
										<span class="field-icon"><i class="fa fa-calendar"></i></span>
									</label>
								</div>
								<div class="section colm colm6" id="p-date-section">
									<label class="field prepend-icon">
										<input type="text" name="preliminary_report_date" id="edit_preliminary_report_date" class="gui-input" placeholder="Preliminary Report Date" value="<?php echo date('m/d/Y'); ?>">
										<span class="field-icon"><i class="fa fa-calendar"></i></span>
									</label>
								</div>
							</div>
							</div>
						</div>
						<div class="form-footer" style="margin: 0px 20px;">
							<button type="submit" data-btntext-sending="Sending..." class="button btn-primary">Submit</button>
							<button type="reset" data-dismiss="modal" aria-label="Close" class="button">Cancel</button>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
	<!-- Edit info modal -->
</body>

</html>
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/frontend/css/smart-forms.css">
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/frontend/css/font-awesome.min.css">
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/frontend/css/jquery-ui.css">
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/frontend/css/ui-lightness/jquery-ui.css">

<script type="text/javascript" src="<?php echo base_url(); ?>assets/frontend/js/jquery.validate.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/frontend/js/jquery-ui.min.js"></script>
<script>
	$(document).ready(function () {

		$('#supplemental_report_date').datepicker();
		$('#preliminary_report_date').datepicker();
		$('#edit_supplemental_report_date').datepicker();
		$('#edit_preliminary_report_date').datepicker();

		if ($('#orders_listing').length) {
			order_list = $('#orders_listing').DataTable({
				// "pageLength": 2,
				"paging": true,
				"lengthChange": false,
				"language": {
					searchPlaceholder: "Search File# or Address",
					paginate: {
						next: '<span class="fa fa-angle-right"></span>',
						previous: '<span class="fa fa-angle-left"></span>',
					},
					"emptyTable": "Record(s) not found.",
					"search": "",
                },
                /*"searching": false,*/
				initComplete: function () {
					
					
                },
				dom: 'Bfrtip',
				buttons: [],
				"drawCallback": function () {
					
				},
				"ordering": false,
				"serverSide": true,
				"ajax": {
					url: base_url + "get-proposed-orders", // json datasource
					type: "post", // method  , by default get
					error: function (XMLHttpRequest, textStatus, errorThrown) {
						if (parseInt(XMLHttpRequest.status) == 419) {
							alert("You are logged out. Please login.");
						}
						if (parseInt(XMLHttpRequest.status) == 419) {
							setTimeout(function () {
								location.reload();
							}, 1000);
						}
						$("#orders_listing tbody").append(
							'<tr><td colspan="4" class="text-center">No records found</td></tr>');
						$("#orders_listing_processing").css("display", "none");

					}
				}
			});
		}

		if(jQuery('#add-order-details').length)
	    {
	       jQuery('#add-order-details').validate({
	       		ignore:":not(:visible)",
	            rules: {
	                LenderCompany:"required",
	                LenderEmailAddress:"required",
	                LenderName:"required",
	                TitleOfficer:"required",
	                loan_amount:"required",
	                loan_number:"required",
	                primary_first_name:"required",
	                primary_last_name:"required",
	                supplemental_report_date:"required",
	                preliminary_report_date:"required",
	            },
	            messages: {
	                TitleOfficer:"Please select title officer",
	                loan_number:"Please enter loan number",
	                borrower:"Please enter borrower",
	                lender:"Please enter lender",
	                supplemental_report_date:"Please select date",
	                preliminary_report_date:"Please select date",
	            },
	            submitHandler: function(form) {
	            	$('#page-preloader').css('background-color', 'rgba(0,0,0,.5)');
					$('#page-preloader').css('display', 'block');
	            	var LenderCompany = $('#LenderCompany').val();
	            	var LenderEmailAddress = $('#LenderEmailAddress').val();
	            	var LenderTelephone = $('#LenderTelephone').val();
	            	var LenderName = $('#LenderName').val();
	            	var LenderAddress = $('#LenderAddress').val();
	            	var LenderCity = $('#LenderCity').val();
	            	var LenderZipcode = $('#LenderZipcode').val();
	            	var TitleOfficer = $('#TitleOfficer').val();
	            	var loan_amount = $('#loan_amount').val();
	            	var loan_number = $('#loan_number').val();
	            	var primary_first_name = $('#primary_first_name').val();
	            	var primary_last_name = $('#primary_last_name').val();
	            	var secondary_first_name = $('#first_name').val();
	            	var secondary_last_name = $('#last_name').val();
	            	var LenderId = $('#LenderId').val();
	            	var orderId = $('#orderId').val();
	            	var transaction_id = $('#transaction_id').val();
	            	var property_id = $('#property_id').val();
	            	var fileId = $('#fileId').val();
	            	var supplemental_report_date = $('#supplemental_report_date').val();
	            	var preliminary_report_date = $('#preliminary_report_date').val();

	                $.ajax({
	                url: base_url + "add-order-details",
	                type: "post",
	                data:{
	                    TitleOfficer: TitleOfficer,
	                    loan_amount: loan_amount,
	                    loan_number: loan_number,
	                    primary_first_name: primary_first_name,
	                    primary_last_name: primary_last_name,
	                    secondary_first_name: secondary_first_name,
	                    secondary_last_name: secondary_last_name,
	                    LenderId: LenderId,
	                    LenderCompany:LenderCompany,
	            		LenderEmailAddress:LenderEmailAddress,
	            		LenderTelephone:LenderTelephone,
	            		LenderName:LenderName,
	            		LenderAddress:LenderAddress,
	            		LenderCity:LenderCity,
	            		LenderZipcode:LenderZipcode,
	                    orderId: orderId,
	                    transaction_id: transaction_id,
	                    property_id: property_id,
	                    fileId: fileId,
	                    s_report_date: supplemental_report_date,
	                    p_report_date: preliminary_report_date,
	                }, 
	                success: function(response) {
	                	$('#page-preloader').css('display', 'none');
	                	var res = JSON.parse(response);
						if(res.status == 'success')
						{
							$('#lender_information').modal('hide');
							if(res.data)
							{
								var binaryData = res.data;
								downloadFile(binaryData);
							}							
							/*generateProposedInsured(res.fileId);*/
							location.reload(true);
						}
						else if(res.status == 'error')
						{
							$('.modal-body.search-result').append('<div class="error">Something went wrong. Please try again.</div>');
							$('#lender_information').modal('hide');
						}
	                }
	            });
	            }
	        }); 
	    }

	    /* Lender autocomplete */
	    
	    $("#LenderCompany").autocomplete({
	        // source: "php/usersearch.php",
	        source: function(request, response) {
	            $.ajax({
	                url: base_url+'home/getDetailsByName',
	                data: {
	                    term : request.term,//the value of the input is here
	                    is_escrow : 0                    
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
	            $("#LenderName").val(ui.item.name);
	            $("#LenderEmailAddress").val(ui.item.email_address).parent().addClass('state-success');
	            $("#LenderTelephone").val(ui.item.telephone_no).parent().addClass('state-success');           
	            $("#LenderCompany").val(ui.item.company).parent().addClass('state-success');
	            $("#LenderId").val(ui.item.id);
	        },
	        change: function( event, ui ) {
	            if (ui.item == null)
	            {
	               /* $("#LenderEmailAddress").val('').parent().removeClass('state-success').addClass('state-error');
	                $("#LenderTelephone").val('').parent().removeClass('state-success').addClass('state-error');
	                $("#LenderCompany").val('').parent().removeClass('state-success').addClass('state-error');
	                $("#LenderId").val('');*/
	            }
	        }
	    });

	    $("#edit_LenderCompany").autocomplete({
	        // source: "php/usersearch.php",
	        source: function(request, response) {
	            $.ajax({
	                url: base_url+'home/getDetailsByName',
	                data: {
	                    term : request.term,//the value of the input is here
	                    is_escrow : 0                    
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
	            $("#edit_LenderName").val(ui.item.name);
	            $("#edit_LenderEmailAddress").val(ui.item.email_address).parent().addClass('state-success');
	            $("#edit_LenderTelephone").val(ui.item.telephone_no).parent().addClass('state-success');           
	            $("#edit_LenderCompany").val(ui.item.company).parent().addClass('state-success');
	            $("#edit_LenderId").val(ui.item.id);
	        },
	        change: function( event, ui ) {
	            if (ui.item == null)
	            {
	               /* $("#LenderEmailAddress").val('').parent().removeClass('state-success').addClass('state-error');
	                $("#LenderTelephone").val('').parent().removeClass('state-success').addClass('state-error');
	                $("#LenderCompany").val('').parent().removeClass('state-success').addClass('state-error');
	                $("#LenderId").val('');*/
	            }
	        }
	    });
		/* Lender autocomplete */

		$('#lender_information,#edit_information').on('hidden.bs.modal', function (e) {
		  $(this)
		    .find("input,textarea,select")
		       .val('')
		       .end()
		    .find("input[type=checkbox], input[type=radio]")
		       .prop("checked", "")
		       .end();
		});

		/* Edit modal validations */
		if(jQuery('#edit-order-details').length)
		{
		   jQuery('#edit-order-details').validate({
		   		ignore:":not(:visible)",
		        rules: {
		            LenderCompany:"required",
	                LenderEmailAddress:"required",
	                LenderName:"required",
	                TitleOfficer:"required",
	                loan_amount:"required",
	                loan_number:"required",
	                primary_first_name:"required",
	                primary_last_name:"required",
	                supplemental_report_date:"required",
	                preliminary_report_date:"required",
		        },
		        messages: {
		            TitleOfficer:"Please select title officer",
	                loan_number:"Please enter loan number",
	                borrower:"Please enter borrower",
	                lender:"Please enter lender",
	                supplemental_report_date:"Please select date",
	                preliminary_report_date:"Please select date",
		        },
		        submitHandler: function(form) {
		        	$('#page-preloader').css('background-color', 'rgba(0,0,0,.5)');
					$('#page-preloader').css('display', 'block');
	            	var LenderCompany = $('#edit_LenderCompany').val();
	            	var LenderEmailAddress = $('#edit_LenderEmailAddress').val();
	            	var LenderTelephone = $('#edit_LenderTelephone').val();
	            	var LenderName = $('#edit_LenderName').val();
	            	var LenderAddress = $('#edit_LenderAddress').val();
	            	var LenderCity = $('#edit_LenderCity').val();
	            	var LenderZipcode = $('#edit_LenderZipcode').val();
	            	var TitleOfficer = $('#edit_TitleOfficer').val();
	            	var loan_amount = $('#edit_loan_amount').val();
	            	var loan_number = $('#edit_loan_number').val();
	            	var primary_first_name = $('#edit_primary_first_name').val();
	            	var primary_last_name = $('#edit_primary_last_name').val();
	            	var secondary_first_name = $('#edit_first_name').val();
	            	var secondary_last_name = $('#edit_last_name').val();
	            	var LenderId = $('#edit_LenderId').val();
	            	var orderId = $('#edit_orderId').val();
	            	var transaction_id = $('#edit_transaction_id').val();
	            	var property_id = $('#edit_property_id').val();
	            	var fileId = $('#edit_fileId').val();
	            	var supplemental_report_date = $('#edit_supplemental_report_date').val();
	            	var preliminary_report_date = $('#edit_preliminary_report_date').val();

		            $.ajax({
		            url: base_url + "add-order-details",
		            type: "post",
		            data:{
		                TitleOfficer: TitleOfficer,
	                    loan_amount: loan_amount,
	                    loan_number: loan_number,
	                    primary_first_name: primary_first_name,
	                    primary_last_name: primary_last_name,
	                    secondary_first_name: secondary_first_name,
	                    secondary_last_name: secondary_last_name,
	                    LenderId: LenderId,
	                    LenderCompany:LenderCompany,
	            		LenderEmailAddress:LenderEmailAddress,
	            		LenderTelephone:LenderTelephone,
	            		LenderName:LenderName,
	            		LenderAddress:LenderAddress,
	            		LenderCity:LenderCity,
	            		LenderZipcode:LenderZipcode,
	                    orderId: orderId,
	                    transaction_id: transaction_id,
	                    property_id: property_id,
	                    fileId: fileId,
	                    s_report_date: supplemental_report_date,
	                    p_report_date: preliminary_report_date,
		            }, 
		            success: function(response) {
		            	$('#page-preloader').css('display', 'none');
		            	var res = JSON.parse(response);
						if(res.status == 'success')
						{			
							$('#edit-data-result').html('<div class="alert alert-success">Data updated successfully</div>');
							if(res.data)
							{
								var binaryData = res.data;
								downloadFile(binaryData);
							}							
							/*generateProposedInsured(res.fileId);*/
							location.reload(true);	
						}
						else if(res.status == 'error')
						{
							$('#edit-data-result').html('<div class="alert alert-error">Something went wrong. Please try again.</div>');
						}
						$('#edit-data-result').fadeOut( 5000, function() {
						    $('#edit_information').modal('hide');
						});						
		            }
		        });
		        }
		    }); 
		}
		/* Edit modal validations */
	});

function generateProposedInsured(fileId)
{
	if(fileId)
	{
		$('#page-preloader').css('background-color', 'rgba(0,0,0,.5)');
		$('#page-preloader').css('display', 'block');
		$.ajax({
            url: base_url + "generate-proposed-insured",
            type: "post",
            data:{
                fileId: fileId,
            },
            success: function(response) {
            	var res = JSON.parse(response);
            	console.log(res);
            	/*if(res.status == 'dataRequired')
                {
                	console.log(res);
                	$('#orderId').val(res.data.orderId);
                	$('#transaction_id').val(res.data.transaction_id);
                	$('#property_id').val(res.data.property_id);
                	$('#fileId').val(res.data.fileId);
                	if(res.data.is_title_officer == 1)
                	{
                		$('#title-officer-section').css('display','none');
                	}
                	if(res.data.is_loan_number == 1)
                	{
                		$('#loan-number-section').css('display','none');
                	}
                	if(res.data.is_borrower == 1)
                	{
                		$('#borrower-section').css('display','none');
                	}
                	if(res.data.is_secondary_borrower == 1)
                	{
                		$('#secondary-borrower-section').css('display','none');
                	}
                	if(res.data.is_lender == 1)
                	{
                		$('#lender-section').css('display','none');
                	}
                	if(res.data.is_supplemental_report_date == 1)
                	{
                		$('#s-date-section').css('display','none');
                	}
                	if(res.data.is_preliminary_report_date == 1)
                	{
                		$('#p-date-section').css('display','none');
                	}
                    $('#lender_information').modal('show');
                }
                else
                {
                	if (navigator.msSaveBlob)
                    {                       
                        var csvData = base64toBlob(res.data,'application/octet-stream');
                        var csvURL = navigator.msSaveBlob(csvData, 'ProposedInsured.pdf');
                        var element = document.createElement('a');
                        element.setAttribute('href', csvURL);
                        element.setAttribute('download', 'ProposedInsured.pdf');
                        element.style.display = 'none';
                        document.body.appendChild(element);
                        document.body.removeChild(element);
                    }
                    else
                    {

                        var csvURL = 'data:application/octet-stream;base64,'+res.data;
                        var element = document.createElement('a');
                        element.setAttribute('href', csvURL);
                        element.setAttribute('download', 'ProposedInsured.pdf');
                        element.style.display = 'none';
                        document.body.appendChild(element);
                        element.click();
                        document.body.removeChild(element);
                    }

                    location.reload(true);
                }*/
                if(res.status == 'success') 
                {
                	if(res.orderDetails['is_escrow'] == 1 && (res.orderDetails['escrow_lender_id'] == null || res.orderDetails['escrow_lender_id'] == undefined || res.orderDetails['escrow_lender_id'].length == 0))
                	{
                		$('#lender-details-fields').show();
                	}
                	else
                	{
                		$('#lender-details-fields').hide();
                	}
                	$("#LenderName").val(res.orderDetails['lender_name']);
					$("#LenderEmailAddress").val(res.orderDetails['lender_email']);
					$("#LenderTelephone").val(res.orderDetails['lender_telephone_no']);
					$("#LenderCompany").val(res.orderDetails['lender_company_name']);
					$("#LenderAddress").val(res.orderDetails['lender_address']);
					$("#LenderCity").val(res.orderDetails['lender_city']);
					$("#LenderZipcode").val(res.orderDetails['lender_zipcode']);
					$("#LenderId").val(res.orderDetails['lender_id']);

					if((res.orderDetails['primary_owner_first_name'] == null || res.orderDetails['primary_owner_first_name'] == undefined || res.orderDetails['primary_owner_first_name'].length == 0) || (res.orderDetails['primary_owner_last_name'] == null || res.orderDetails['primary_owner_last_name'] == undefined || res.orderDetails['primary_owner_last_name'].length == 0))
                	{
                		$('#primary-borrower-section').show();
                	}
                	else
                	{
                		$('#primary-borrower-section').hide();
                	}

					$("#primary_first_name").val(res.orderDetails['primary_owner_first_name']);
					$("#primary_last_name").val(res.orderDetails['primary_owner_last_name']);

					if((res.orderDetails['secondary_owner_first_name'] == null || res.orderDetails['secondary_owner_first_name'] == undefined || res.orderDetails['secondary_owner_first_name'].length == 0) || (res.orderDetails['secondary_owner_last_name'] == null || res.orderDetails['secondary_owner_last_name'] == undefined || res.orderDetails['secondary_owner_last_name'].length == 0))
                	{
                		$('#secondary-borrower-section').show();
                	}
                	else
                	{
                		$('#secondary-borrower-section').hide();
                	}

					$("#first_name").val(res.orderDetails['secondary_owner_first_name']);
					$("#last_name").val(res.orderDetails['secondary_owner_last_name']);

					if((res.orderDetails['loan_amount'] == null || res.orderDetails['loan_amount'] == undefined || res.orderDetails['loan_amount'].length == 0) || (res.orderDetails['loan_number'] == null || res.orderDetails['loan_number'] == undefined || res.orderDetails['loan_number'].length == 0) )
                	{
                		$('#loan-details-section').show();
                	}
                	else
                	{
                		$('#loan-details-section').hide();
                	}

					$("#loan_amount").val(res.orderDetails['loan_amount']);
					$("#loan_number").val(res.orderDetails['loan_number']);

					if(res.orderDetails['title_officer'] == null || res.orderDetails['title_officer'] == undefined || res.orderDetails['title_officer'].length == 0 )
                	{
                		$('#title-officer-section').show();
                	}
                	else
                	{
                		$('#title-officer-section').hide();
                	}
					$("#TitleOfficer").val(res.orderDetails['title_officer']);

					if((res.orderDetails['preliminary_report_date'] == null || res.orderDetails['preliminary_report_date'] == undefined || res.orderDetails['preliminary_report_date'].length == 0) || (res.orderDetails['supplemental_report_date'] == null || res.orderDetails['supplemental_report_date'] == undefined || res.orderDetails['supplemental_report_date'].length == 0))
                	{
                		$('#report-date-section').show();
                	}
                	else
                	{
                		$('#report-date-section').hide();
                	}

                	$('#supplemental_report_date').val(res.orderDetails['supplemental_report_date']);
                	$('#preliminary_report_date').val(res.orderDetails['preliminary_report_date']);

                }
                $('#page-preloader').css('display', 'none');
				$('#lender_information').modal('show');
				// $('#file_id').val(fileId);
				$('#LenderId').val(res.orderDetails.lender_id);
				$('#orderId').val(res.orderDetails.orderId);
            	$('#transaction_id').val(res.orderDetails.transaction_id);
            	$('#property_id').val(res.orderDetails.property_id);
            	$('#fileId').val(res.orderDetails.fileId);
            }
        });
	}
	else
	{
		alert("File ID required.");
	}
}

function base64toBlob(base64Data, contentType) 
{
    contentType = contentType || '';
    var sliceSize = 1024;
    var byteCharacters = (base64Data);
    var bytesLength = byteCharacters.length;
    var slicesCount = Math.ceil(bytesLength / sliceSize);
    var byteArrays = new Array(slicesCount);

    for (var sliceIndex = 0; sliceIndex < slicesCount; ++sliceIndex) {
        var begin = sliceIndex * sliceSize;
        var end = Math.min(begin + sliceSize, bytesLength);

        var bytes = new Array(end - begin);
        for (var offset = begin, i = 0; offset < end; ++i, ++offset) {
            bytes[i] = byteCharacters[offset].charCodeAt(0);
        }
        byteArrays[sliceIndex] = new Uint8Array(bytes);
    }
    return new Blob(byteArrays, { type: contentType });
}

function editInformation(fileId)
{
	if(fileId)
	{
		$('#page-preloader').css('background-color', 'rgba(0,0,0,.5)');
		$('#page-preloader').css('display', 'block');
		
		$.ajax({
            // url: base_url + "get-order-details",
            url: base_url + "generate-proposed-insured",
            type: "post",
            data:{
                fileId: fileId,
            },
            success: function(response) {
            	$('#page-preloader').css('display', 'none');
            	
            	var res = JSON.parse(response);
            	console.log(res);
            	if(res.status == 'success')
                {
                	/*var loan_amount = res.loan_amount;
                	var borrower = res.borrower;
                	var secondary_borrower = res.secondary_borrower;
                	var lenderName = res.lender;
                	var property_id = res.property_id;
                	var transaction_id = res.transaction_id;
                	var fileId = res.fileId;
                	var orderId = res.orderId;
                	var escrow_lender_id = res.escrow_lender_id;
                	$('#loan_amount').val(loan_amount);
                	$('#primary_borrower').val(borrower);
                	$('#edit_secondary_borrower').val(secondary_borrower);
                	$('#edit_lender').val(lenderName);
                	$('#edit_property_id').val(property_id);
                	$('#edit_transaction_id').val(transaction_id);
                	$('#edit_fileId').val(fileId);
                	$('#edit_orderId').val(orderId);
                	$('#edit_LenderId').val(escrow_lender_id);*/
                	if(res.status == 'success') 
	                {
	                	if(res.orderDetails['is_escrow'] == 1)
	                	{
	                		$('#edit-order-details #lender-details-fields').show();
	                	}
	                	else
	                	{
	                		$('#edit-order-details #lender-details-fields').hide();
	                	}
	                	$("#edit_LenderName").val(res.orderDetails['lender_name']);
						$("#edit_LenderEmailAddress").val(res.orderDetails['lender_email']);
						$("#edit_LenderTelephone").val(res.orderDetails['lender_telephone_no']);
						$("#edit_LenderCompany").val(res.orderDetails['lender_company_name']);
						$("#edit_LenderAddress").val(res.orderDetails['lender_address']);
						$("#edit_LenderCity").val(res.orderDetails['lender_city']);
						$("#edit_LenderZipcode").val(res.orderDetails['lender_zipcode']);
						$("#edit_LenderId").val(res.orderDetails['lender_id']);

						

						$("#edit_primary_first_name").val(res.orderDetails['primary_owner_first_name']);
						$("#edit_primary_last_name").val(res.orderDetails['primary_owner_last_name']);

						

						$("#edit_first_name").val(res.orderDetails['secondary_owner_first_name']);
						$("#edit_last_name").val(res.orderDetails['secondary_owner_last_name']);

						
						$("#edit_loan_amount").val(res.orderDetails['loan_amount']);
						$("#edit_loan_number").val(res.orderDetails['loan_number']);

						
						$("#edit_TitleOfficer").val(res.orderDetails['title_officer']);

						

	                	$('#edit_supplemental_report_date').val(res.orderDetails['supplemental_report_date']);
	                	$('#edit_preliminary_report_date').val(res.orderDetails['preliminary_report_date']);

	                }
	                $('#edit_LenderId').val(res.orderDetails.lender_id);
					$('#edit_orderId').val(res.orderDetails.orderId);
	            	$('#edit_transaction_id').val(res.orderDetails.transaction_id);
	            	$('#edit_property_id').val(res.orderDetails.property_id);
	            	$('#edit_fileId').val(res.orderDetails.fileId);
                	$('#edit_information').modal('show');
                }
                else
                {
                	alert("Something went wrong. Please try again.");
                }
            }
        });
	}
	else
	{
		alert("File ID required.");
	}
}

function downloadFile(binaryData)
{
	if (navigator.msSaveBlob)
    {                       
        var csvData = base64toBlob(binaryData,'application/octet-stream');
        var csvURL = navigator.msSaveBlob(csvData, 'ProposedInsured.pdf');
        var element = document.createElement('a');
        element.setAttribute('href', csvURL);
        element.setAttribute('download', 'ProposedInsured.pdf');
        element.style.display = 'none';
        document.body.appendChild(element);
        document.body.removeChild(element);
    }
    else
    {

        var csvURL = 'data:application/octet-stream;base64,'+binaryData;
        var element = document.createElement('a');
        element.setAttribute('href', csvURL);
        element.setAttribute('download', 'ProposedInsured.pdf');
        element.style.display = 'none';
        document.body.appendChild(element);
        element.click();
        document.body.removeChild(element);
    }
}

</script>
