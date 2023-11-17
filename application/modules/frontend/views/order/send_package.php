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

	<div class="modal fade" width="500px" id="buyer_welcome" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document" style="width:40%;">
            <div class="modal-content">
                <form method="POST" action="<?php echo base_url(); ?>add-buyer-on-order"
                    enctype="multipart/form-data">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="card shadow mb-4">
                                <div class="card-header py-3">
                                    <h6 class="m-0 font-weight-bold text-primary">Buyer Information</h6>
                                </div>
                                <input type="hidden" name="order_id" id="order_id" value="<?php echo $orderDetails['order_id']; ?>">
                                <input type="hidden" name="file_id" id="file_id" value="<?php echo $orderDetails['file_id']; ?>">

                                <div class="card-body">
                                    <div id="buyer-info-clone-group-fields">
                                        <div class="toclone clone-widget">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label>Buyer Email<span class="required"> *</span></label>
                                                        <input type="text" class="form-control" placeholder="Buyer Email"
                                                            name="buyer_emails[]" id="buyer_email" value="" required="required">
                                                    </div>
                                                </div>

                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label>First Name<span class="required"> *</span></label>
                                                        <input type="text" class="form-control" name="buyer_first_names[]" id="buyer_first_name" placeholder="First Name" required="required">
                                                    </div>
                                                </div>

                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label>Last Name<span class="required"> *</span></label>
                                                        <input type="text" class="form-control" name="buyer_last_names[]" id="buyer_last_names" placeholder="Last Name" required="required">
                                                    </div>
                                                </div>

                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <input class="" type="radio" name="is_main_buyer" id="is_main_buyer" value="is_main_buyer0" required="required">&nbsp;&nbsp;Primary Buyer
                                                    </div>
                                                </div>

                                            </div>
                                            <a href="#" style="height:fit-content;" class="mb-3 clone btn btn-success"><i class="fa fa-plus"></i></a>
                                                <a href="#" style="height:fit-content;" class="mb-3 delete btn btn-danger"><i class="fa fa-minus"></i></a>

                                        </div>
                                    </div>
                                    <button type="submit" data-btntext-sending="Sending..."
                                        class="btn btn-success btn-icon-split btn-sm">
                                        <span class="icon text-white-50">
                                            <i class="fas fa-check"></i>
                                        </span>
                                        <span class="text">Submit</span>
                                    </button>
                                    <button type="reset" data-dismiss="modal" aria-label="Close"
                                        class="btn btn-danger btn-icon-split btn-sm">
                                        <span class="icon text-white-50">
                                            <i class="fas fa-ban"></i>
                                        </span>
                                        <span class="text">Cancel</span>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="modal fade" width="500px" id="seller_welcome" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document" style="width:40%;">
            <div class="modal-content">
                <form method="POST" action="<?php echo base_url(); ?>add-seller-on-order"
                    enctype="multipart/form-data">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="card shadow mb-4">
                                <div class="card-header py-3">
                                    <h6 class="m-0 font-weight-bold text-primary">Seller Information</h6>
                                </div>
                                <input type="hidden" name="order_id" id="order_id" value="<?php echo $orderDetails['order_id']; ?>">
                                <input type="hidden" name="file_id" id="file_id" value="<?php echo $orderDetails['file_id']; ?>">

                                <div class="card-body">
                                    <div id="seller-info-clone-group-fields">
                                        <div class="toclone clone-widget">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label>Seller Email<span class="required"> *</span></label>
                                                        <input type="text" class="form-control" placeholder="Seller Email"
                                                            name="seller_emails[]" id="seller_email" value="" required="required">
                                                    </div>
                                                </div>

                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label>First Name<span class="required"> *</span></label>
                                                        <input type="text" class="form-control" name="seller_first_names[]" id="seller_first_name" placeholder="First Name" required="required">
                                                    </div>
                                                </div>

                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label>Last Name<span class="required"> *</span></label>
                                                        <input type="text" class="form-control" name="seller_last_names[]" id="seller_last_names" placeholder="Last Name" required="required">
                                                    </div>
                                                </div>

                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <input class="" type="radio" name="is_main_seller" id="is_main_seller" value="is_main_seller0" required="required">&nbsp;&nbsp;Primary Seller
                                                    </div>
                                                </div>


                                            </div>
                                            <a href="#" style="height:fit-content;" class="mb-3 clone btn btn-success"><i class="fa fa-plus"></i></a>
                                                <a href="#" style="height:fit-content;" class="mb-3 delete btn btn-danger"><i class="fa fa-minus"></i></a>

                                        </div>
                                    </div>
                                    <button type="submit" data-btntext-sending="Sending..."
                                        class="btn btn-success btn-icon-split btn-sm">
                                        <span class="icon text-white-50">
                                            <i class="fas fa-check"></i>
                                        </span>
                                        <span class="text">Submit</span>
                                    </button>
                                    <button type="reset" data-dismiss="modal" aria-label="Close"
                                        class="btn btn-danger btn-icon-split btn-sm">
                                        <span class="icon text-white-50">
                                            <i class="fas fa-ban"></i>
                                        </span>
                                        <span class="text">Cancel</span>
                                    </button>
                                </div>
                            </div>
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
						url: base_url+'getDetailsByName',
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
					
					if(ui.item.state) {
						$("#LenderState").val(ui.item.state).parent().addClass('state-success');           
					} else {
						$("#LenderState").val('').parent().removeClass('state-success').addClass('state-error');
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

					if(ui.item.assignment_clause) {
						$("#assignment_clause").val(ui.item.assignment_clause);
					} else {
						$("#assignment_clause").val('');
					}
					$("#LenderId").val(ui.item.id);
					
				},
				change: function( event, ui ) {
					if (ui.item == null)
					{
						$("#LenderState").val('').parent().removeClass('state-success').addClass('state-error');
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
			$("#LenderName").val('');
			$("#LenderState").val('');
			$("#LenderCompany").val('');
			$("#LenderAddress").val('');
			$("#LenderCity").val('');
			$("#LenderZipcode").val('');
			$("#assignment_clause").val('');
			$("#LenderId").val('');
		});
	});
	
    function lender_pop_up(lenderFlag, fileId) 
    {
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
						var optionsAsString = "";
						for(var i = 0; i < res.orderDetails['agents_data'].length; i++) {
							var selected = '';
							if(res.orderDetails['agents_data'][i]['id'] == res.orderDetails['fnf_agent_id']) {
								selected = 'selected';
							}
							if (res.orderDetails['cpl_api'] == 'westcor' || res.orderDetails['cpl_api'] == 'natic') {
								optionsAsString += "<option "+ selected +" value='" + res.orderDetails['agents_data'][i]['id'] + "'>" + res.orderDetails['agents_data'][i]['city'] + "</option>";
							} else {
								optionsAsString += "<option "+ selected +" value='" + res.orderDetails['agents_data'][i]['id'] + "'>" + res.orderDetails['agents_data'][i]['location_city'] + "</option>";
							}
								
						}
						$('select[name="branch"]').children('option:not(:first)').remove();
						$( 'select[name="branch"]' ).append( optionsAsString );
						$("#branch").prop('required',true);
						
						$('#cpl_api').val(res.orderDetails['cpl_api']);
						$("#LenderName").val(res.orderDetails['lender_name']);
						$("#LenderState").val(res.orderDetails['lender_state']);
						$("#LenderCompany").val(res.orderDetails['lender_company_name']);
						$("#assignment_clause").val(res.orderDetails['lender_assignment_clause']);
						$("#LenderAddress").val(res.orderDetails['lender_address']);
						$("#LenderCity").val(res.orderDetails['lender_city']);
						$("#LenderZipcode").val(res.orderDetails['lender_zipcode']);
						$("#LenderId").val(res.orderDetails['lender_id']);
						$("#borrowers_vesting").val(res.orderDetails['borrowers_vesting']);
						$("#loan_number").val(res.orderDetails['loan_number']);
						if(res.orderDetails['unit_number']) {
							$("#property_address").val(res.orderDetails['unit_number']+", "+res.orderDetails['property_address']);
						} else {
							$("#property_address").val(res.orderDetails['property_address']);
						}
						$("#property_city").val(res.orderDetails['property_city']);
						$("#property_state").val(res.orderDetails['property_state']);
						$("#property_zipcode").val(res.orderDetails['property_zipcode']);
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

	function downloadDocumentFromAws(url, documentType)
    {
        $('#page-preloader').css('background-color', 'rgba(0,0,0,.5)');
		$('#page-preloader').css('display', 'block');
        var fileNameIndex = url.lastIndexOf("/") + 1;
        var filename = url.substr(fileNameIndex);
        $.ajax({
			url: base_url + "download-aws-document",
			type: "post",
			data: {
				url : url
			},
            async: false,
			success: function (response) {
				if (response) {
					if (navigator.msSaveBlob) {
						var csvData = base64toBlob(response, 'application/octet-stream');
						var csvURL = navigator.msSaveBlob(csvData, filename);
						var element = document.createElement('a');
						element.setAttribute('href', csvURL);
						element.setAttribute('download', documentType+"_"+filename);
						element.style.display = 'none';
						document.body.appendChild(element);
						document.body.removeChild(element);
					} else {
						console.log(response);
						var csvURL = 'data:application/octet-stream;base64,' + response;
						var element = document.createElement('a');
						element.setAttribute('href', csvURL);
						element.setAttribute('download', documentType+"_"+filename);
						element.style.display = 'none';
						document.body.appendChild(element);
						element.click();
						document.body.removeChild(element);
					}
				}
                $('#page-preloader').css('display', 'none');
			}
        });
    }

</script>
