<style>
	.smart-forms .prepend-icon .field-icon {
		top: 14px !important;
	}
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
											<tr>
												<th>#</th>
												<th>File Number</th>
												<th>Property Address</th>
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
											<input type="hidden" name="state" id="state" value="">
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
									<div class="section colm colm6">
										<label class="field prepend-icon">
											<input type="email" name="LenderEmailAddress" id="LenderEmailAddress"
												class="gui-input" placeholder="Lender Email address">
											<span class="field-icon"><i class="fa fa-envelope"></i></span>
										</label>
									</div>
									<div class="section colm colm6">
										<label class="field prepend-icon">
											<input type="tel" name="LenderTelephone" id="LenderTelephone" class="gui-input"
												placeholder="Lender Telephone">
											<span class="field-icon"><i class="fa fa-phone-square"></i></span>
										</label>
									</div>
								</div>
								<div class="frm-row">
									<div class="section colm colm6">
										<label class="field prepend-icon">
											<input type="text" name="LenderName" id="LenderName"
												class="gui-input" placeholder="Attention"
												autocomplete="off" required="required">
											<span class="field-icon"><i class="fa fa-user"></i></span>
										</label>
									</div>
									<div class="section colm colm6">
										<label class="field prepend-icon">
											<input type="text" name="LenderAddress" id="LenderAddress" class="gui-input"
												placeholder="Lender Address" required="required">
											<span class="field-icon"><i class="fa fa-envelope"></i></span>
										</label>
									</div>
								</div>
								<div class="frm-row spacer-b15">
									<div class="section colm colm6">
										<label class="field prepend-icon">
											<input type="text" name="LenderCity" id="LenderCity" class="gui-input"
												placeholder="Lender City" required="required">
											<span class="field-icon"><i class="fa fa-user"></i></span>
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
									<div class="tagline"><span>Loan Details</span></div><!-- .tagline -->
								</div>

								<div class="frm-row spacer-b15">
									<!-- <div class="section colm colm6">
										<label class="field">
											<input type="text" class="gui-input" name="loan_amount" id="loan_amount" placeholder="Loan Amount">
										</label>
									</div> -->
									<div class="section colm colm12">
										<label class="field">
											<input required="required" type="text" class="gui-input" name="loan_number" id="loan_number" placeholder="Loan Number">
										</label>
									</div>
								</div>

								<div class="spacer-b20">
									<div class="tagline"><span>Primary Borrower Information</span></div><!-- .tagline -->
								</div>

								<div class="frm-row spacer-b15">
									<div class="section colm colm6">
										<label class="field prepend-icon">
											<input type="text" name="primary_first_name" id="primary_first_name" class="gui-input"
												placeholder="First Name"  required="required">
											<span class="field-icon"><i class="fa fa-user"></i></span>
										</label>
									</div>
									<div class="section colm colm6">
										<label class="field prepend-icon">
											<input type="text" name="primary_last_name" id="primary_last_name" class="gui-input"
												placeholder="Last Name"  required="required">
											<span class="field-icon"><i class="fa fa-user"></i></span>
										</label>
									</div>
								</div>

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

								<div class="spacer-b20">
									<div class="tagline"><span>Vesting Information</span></div><!-- .tagline -->
								</div>

								<div class="frm-row spacer-b15">
									<div class="section colm colm12">
										<label class="field prepend-icon">
											<input type="text" name="vesting" id="vesting" class="gui-input"
												placeholder="Vesting">
											<span class="field-icon"><i class="fa fa-user"></i></span>
										</label>
									</div>
								</div>

								<input type="hidden" id="cpl_api" name="cpl_api" value="">
								
								<div id="fnf" style="display:none">
									<!-- <div class="spacer-b20">
										<div class="tagline"><span>Agent Details</span></div>
									</div>

									<input type="hidden" id="agent_id" name="agent_id" value="">

									<div class="frm-row spacer-b15">
										<div class="section colm colm12">
											<label class="field prepend-icon">
												<input type="text" name="agent_name" id="agent_name" class="gui-input ui-autocomplete-input"
													placeholder="Agent Name">
												<span class="field-icon"><i class="fa fa-user"></i></span>
											</label>
										</div>
									</div> -->

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


<script>
	/* Lender autocomplete */
    
	$("#LenderCompany" ).focusin(function() {
		if ($('input[name="new_existing_lender"]:checked').val() == 'existing_lender') {
			if($('.ui-widget.ui-autocomplete').length > 0) {
				$('#LenderCompany').autocomplete( "enable" );
			}
			$("#LenderCompany").autocomplete({
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
					$("#LenderCompany").val(ui.item.company);
					if(ui.item.email_address) {
						$("#LenderEmailAddress").val(ui.item.email_address).parent().addClass('state-success');
					} else {
						$("#LenderEmailAddress").val('').parent().removeClass('state-success').addClass('state-error');
					}

					if(ui.item.telephone_no) {
						$("#LenderTelephone").val(ui.item.telephone_no).parent().addClass('state-success');           
					} else {
						$("#LenderTelephone").val('').parent().removeClass('state-success').addClass('state-error');
					}

					if(ui.item.name) {
						$("#LenderName").val(ui.item.name).parent().addClass('state-success');       
					} else {
						$("#LenderName").val('').parent().removeClass('state-success').addClass('state-error');
					}

					if(ui.item.address) {
						$("#LenderAddress").val(ui.item.address).parent().addClass('state-success');
					} else {
						$("#LenderAddress").val('').parent().removeClass('state-success').addClass('state-error');
					}

					if(ui.item.city) {
						$("#LenderCity").val(ui.item.city).parent().addClass('state-success');
					} else {
						$("#LenderCity").val('').parent().removeClass('state-success').addClass('state-error');
					}
						
					if(ui.item.zip_code) {
						$("#LenderZipcode").val(ui.item.zip_code).parent().addClass('state-success');
					} else {
						$("#LenderZipcode").val('').parent().removeClass('state-success').addClass('state-error');
					}

					if (ui.item.assignment_clause) {
						$("#assignment_clause").val(ui.item.assignment_clause);
					} else {
						$("#assignment_clause").val('');
					}
					$("#LenderId").val(ui.item.id);
					
				},
				change: function( event, ui ) {
					if (ui.item == null)
					{
						$("#LenderEmailAddress").val('').parent().removeClass('state-success').addClass('state-error');
						$("#LenderTelephone").val('').parent().removeClass('state-success').addClass('state-error');
						$("#LenderCompany").val('').parent().removeClass('state-success').addClass('state-error');
						$("#LenderAddress").val('').parent().removeClass('state-success').addClass('state-error');
						$("#LenderCity").val('').parent().removeClass('state-success').addClass('state-error');
						$("#LenderZipcode").val('').parent().removeClass('state-success').addClass('state-error');
						$("#assignment_clause").val('');
						$("#LenderId").val('');
					}
				}
			});
		} else {
			if($('.ui-widget.ui-autocomplete').length > 0) {
				$('#LenderCompany').autocomplete( "disable" );
			}
			// $("#LenderCompany").autocomplete({
			// 	source: function(request, response) {
			// 		$.ajax({
			// 			url: base_url+"admin/order/home/get_company_list",
			// 			data: {
			// 				term : request.term        
			// 			},
			// 			type: "POST",
			// 			dataType: "json",
			// 			success: function (data) {
			// 				if (data.length > 0) {
			// 					response($.map(data, function (item) {
			// 						return item;
			// 					}))
			// 				} else {
			// 					response([{ label: 'No results found.', val: -1}]);
			// 				}
			// 			}
			// 		});
			// 	},
			// 	delay: 0,
			// 	minLength: 3,
			// 	select: function( event, ui ) {
			// 		event.preventDefault();
			// 		$("#LenderCompany").val(ui.item.partner_name);
				
			// 		if(ui.item.address1) {
			// 			$("#LenderAddress").val(ui.item.address1).parent().addClass('state-success');
			// 		} else {
			// 			$("#LenderAddress").val('').parent().removeClass('state-success').addClass('state-error');
			// 		}

			// 		if(ui.item.city) {
			// 			$("#LenderCity").val(ui.item.city).parent().addClass('state-success');
			// 		} else {
			// 			$("#LenderCity").val('').parent().removeClass('state-success').addClass('state-error');
			// 		}
						
			// 		if(ui.item.zip) {
			// 			$("#LenderZipcode").val(ui.item.zip).parent().addClass('state-success');
			// 		} else {
			// 			$("#LenderZipcode").val('').parent().removeClass('state-success').addClass('state-error');
			// 		}
			// 		$("#LenderId").val('');
			// 		$("#state").val(ui.item.state);
			// 		$("#partner_id").val(ui.item.partner_id);
			// 	},
			// 	change: function( event, ui ) {
			// 		if (ui.item == null) {
			// 			$("#LenderCompany").parent().removeClass('state-success').addClass('state-error');
			// 		}
			// 	}
			// });
		}
    });
	/* Lender autocomplete */ 

	/* Agent autocomplete */
    $("#agent_name").autocomplete({
        source: function(request, response) {
            $.ajax({
                url: base_url+'agent/getAgentDetails',
                data: {
                    term : request.term
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
			$("#agent_name").val(ui.item.name);
			$("#agent_id").val(ui.item.id);
        },
        change: function( event, ui ) {
            
        }
    });
	/* Agent autocomplete */ 
	
	$(document).ready(function () {
		$("input[name=new_existing_lender]").change(function(){
			$("#LenderEmailAddress").val('');
			$("#LenderName").val('');
			$("#LenderTelephone").val('');
			$("#LenderCompany").val('');
			$("#LenderAddress").val('');
			$("#LenderCity").val('');
			$("#LenderZipcode").val('');
			$("#assignment_clause").val('');
			$("#LenderId").val('');
		});
		if ($('#cpl_listing').length) {
			customer_list = $('#cpl_listing').DataTable({
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
				"bStateSave": true,
				"fnStateSave": function (oSettings, oData) {
					localStorage.setItem('offersDataTables', JSON.stringify(oData));
				},
				"fnStateLoad": function (oSettings) {
					return JSON.parse(localStorage.getItem('offersDataTables'));
				},
				initComplete: function () {


				},
				dom: 'Bfrtip',
				buttons: [],
				"drawCallback": function () {

				},
				"ordering": false,
				"serverSide": true,
				"ajax": {
					url: base_url + "get-orders-cpl", // json datasource
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
						$("#cpl_listing tbody").append(
							'<tr><td colspan="4" class="text-center">No records found</td></tr>');
						$("#cpl_listing_processing").css("display", "none");
					}
				}
			});
		}
	});
	
	function lender_pop_up(lenderFlag, fileId) {
		if (lenderFlag == 1) {
			$(this).form.submit();
		} else {
			$('#page-preloader').css('background-color', 'rgba(0,0,0,.5)');
			$('#page-preloader').css('display', 'block');
			$.ajax({
				url: base_url + "get-order-details-cpl",
				type: "post",
				data: {
					fileId: fileId
				},
				success: function (response) {
					var res = jQuery.parseJSON(response);
					if(res.status == 'success') {
						if (res.orderDetails['cpl_api'] == 'fnf') {
							$('#fnf').show();
							var optionsAsString = "";
							for(var i = 0; i < res.orderDetails['agents_data'].length; i++) {
								var selected = '';
								if(res.orderDetails['agents_data'][i]['id'] == res.orderDetails['fnf_agent_id']) {
									selected = 'selected';
								}
								optionsAsString += "<option "+ selected +" value='" + res.orderDetails['agents_data'][i]['id'] + "'>" + res.orderDetails['agents_data'][i]['location_city'] + "</option>";
							}
							$('select[name="branch"]').children('option:not(:first)').remove();
							$( 'select[name="branch"]' ).append( optionsAsString );
							$("#branch").prop('required',true);
						} else if (res.orderDetails['cpl_api'] == 'westcor') { 
							$('#fnf').show();
							var optionsAsString = "";
							for(var i = 0; i < res.orderDetails['agents_data'].length; i++) {
								var selected = '';
								if(res.orderDetails['agents_data'][i]['id'] == res.orderDetails['fnf_agent_id']) {
									selected = 'selected';
								}
								optionsAsString += "<option "+ selected +" value='" + res.orderDetails['agents_data'][i]['id'] + "'>" + res.orderDetails['agents_data'][i]['city'] + "</option>";
							}
							$('select[name="branch"]').children('option:not(:first)').remove();
							$( 'select[name="branch"]' ).append( optionsAsString );
							$("#branch").prop('required',true);
						} else {
							$('#fnf').hide();
							$("#branch").prop('required',false);
						}
						
						$('#cpl_api').val(res.orderDetails['cpl_api']);
						$("#LenderName").val(res.orderDetails['lender_name']);
						$("#LenderEmailAddress").val(res.orderDetails['lender_email']);
						$("#LenderTelephone").val(res.orderDetails['lender_telephone_no']);
						$("#LenderCompany").val(res.orderDetails['lender_company_name']);
						$("#assignment_clause").val(res.orderDetails['lender_assignment_clause']);
						$("#LenderAddress").val(res.orderDetails['lender_address']);
						$("#LenderCity").val(res.orderDetails['lender_city']);
						$("#LenderZipcode").val(res.orderDetails['lender_zipcode']);
						$("#LenderId").val(res.orderDetails['lender_id']);
						$("#primary_first_name").val(res.orderDetails['primary_owner_first_name']);
						$("#primary_last_name").val(res.orderDetails['primary_owner_last_name']);
						$("#first_name").val(res.orderDetails['secondary_owner_first_name']);
						$("#last_name").val(res.orderDetails['secondary_owner_last_name']);
						//$("#loan_amount").val(res.orderDetails['loan_amount']);
						$("#loan_number").val(res.orderDetails['loan_number']);
						$("#vesting").val(res.orderDetails['vesting']);
						if (res.orderDetails['lender_id'] != '') {
							$("#existing_lender").prop("checked", true);
						} else {
							$("#add_lender").prop("checked", true);
						}
					}  
					$('#page-preloader').css('display', 'none');
					$('#lender_information').modal('show');
					$('#file_id').val(fileId);
				}
			});
			return false;
		}
	}

	$("form").submit(function(){
		$('#page-preloader').css('background-color', 'rgba(0,0,0,.5)');
		$('#page-preloader').css('display', 'block');
	});

	function download_for_pdf(westcor_file_id, westcor_order_id) {
		$('#page-preloader').css('background-color', 'rgba(0,0,0,.5)');
		$('#page-preloader').css('display', 'block');
		$.ajax({
			url: base_url + "download-cpl-pdf",
			type: "post",
			data: {
				westcor_file_id: westcor_file_id,
				westcor_order_id: westcor_order_id,
			},
			success: function (response) {
				$('#page-preloader').css('display', 'none');
				if (response) {
					if (navigator.msSaveBlob) {
						var csvData = base64toBlob(response, 'application/octet-stream');
						var csvURL = navigator.msSaveBlob(csvData, 'FeeEstimation.pdf');
						var element = document.createElement('a');
						element.setAttribute('href', csvURL);
						element.setAttribute('download', 'cpl_'+westcor_file_id+'.pdf');
						element.style.display = 'none';
						document.body.appendChild(element);
						document.body.removeChild(element);
					} else {
						var csvURL = 'data:application/octet-stream;base64,' + response;
						var element = document.createElement('a');
						element.setAttribute('href', csvURL);
						element.setAttribute('download', 'cpl_'+westcor_file_id+'.pdf');
						element.style.display = 'none';
						document.body.appendChild(element);
						element.click();
						document.body.removeChild(element);
					}
				}
			}
		});
	}

	function base64toBlob(base64Data, contentType) {
		contentType = contentType || '';
		var sliceSize = 1024;
		var byteCharacters = atob(base64Data);
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
		return new Blob(byteArrays, {
			type: contentType
		});
	}

</script>
