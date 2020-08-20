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

	<section class="section-type-4a section-defaulta" style="padding-bottom:100px;">
		<div class="container">
			<div class="row">
				<div class="row">
					<div class="col-xs-12">
						<div class="typography-section__inner" style="padding: 0px 17px;">
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
												<th>Action</th>
											</tr>
										</thead>
										<tbody>
                                            <tr role="row" class="odd">
                                                <td>1</td>
                                                <td><?php echo $file_number;?></td>
                                                <td><?php echo $full_address;?></td>
                                                <td><?php echo $action;?></td> 
                                            </tr>
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
					<div class="smart-forms smart-container wrap-2" style="margin:30px">
						<div class="modal-body search-result">
							<div id="lender-details-fields" style="">
								<div class="spacer-b30">
									<div class="tagline"><span>Add Details</span></div><!-- .tagline -->
								</div>

								<div class="frm-row" id="title-officer-section">
									<input type="hidden" name="orderId" value="" id="orderId">

									<input type="hidden" name="property_id" value="" id="property_id">

									<input type="hidden" name="transaction_id" value="" id="transaction_id">

									<input type="hidden" name="fileId" value="" id="fileId">

									<input type="hidden" name="LenderId" value="" id="LenderId">

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

								<div class="frm-row" id="loan-number-section">
									<div class="section colm colm12">
										<label class="field prepend-icon">
											<input type="text" name="loan_number" id="loan_number" class="gui-input" placeholder="Loan Number">
											<span class="field-icon"><i class="fa fa-envelope"></i></span>
										</label>
									</div>
								</div>
								<div class="frm-row" id="borrower-section">
									<div class="section colm colm12">
										<label class="field prepend-icon">
											<input type="text" name="borrower" id="borrower" class="gui-input"
												placeholder="Borrower">
											<span class="field-icon"><i class="fa fa-user"></i></span>
										</label>
									</div>
								</div>
								<div class="frm-row" id="secondary-borrower-section">
									<div class="section colm colm12">
										<label class="field prepend-icon">
											<input type="text" name="secondary_borrower" id="secondary_borrower" class="gui-input"
												placeholder="Secondary Borrower">
											<span class="field-icon"><i class="fa fa-user"></i></span>
										</label>
									</div>
								</div>
								<div class="frm-row" id="lender-section">
									<div class="section colm colm12">
										<label class="field prepend-icon">
											<input type="text" name="lender" id="lender" class="gui-input"
												placeholder="Lender" required="required">
											<span class="field-icon"><i class="fa fa-user"></i></span>
										</label>
									</div>
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
						<div class="form-footer" style="padding-top:0px;">
							<button type="submit" data-btntext-sending="Sending..."
								class="button btn-primary">Submit</button>
							<button type="reset" data-dismiss="modal" aria-label="Close" class="button">Cancel</button>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>

	<!-- Edit info modal -->
	<div class="modal fade" width="500px" id="edit_information" tabindex="-1" role="dialog"
		aria-labelledby="" aria-hidden="true">
		<div class="modal-dialog modal-lg" role="document" style="width:40%;">
			<div class="modal-content">
				<form method="POST" id="edit-order-details" enctype="multipart/form-data">
					<div class="smart-forms smart-container wrap-2" style="margin:30px">
						<div class="modal-body search-result">
							<div id="lender-details-fields" style="">
								<div class="spacer-b30">
									<div class="tagline"><span>Edit Details</span></div><!-- .tagline -->
								</div>
								<div id="edit-data-result"></div>
								<div class="frm-row" id="loan-amount-section">
									<div class="section colm colm12">
										<label class="field prepend-icon">
											<input type="text" name="loan_amount" id="loan_amount" class="gui-input"
												placeholder="Loan Amount">
										</label>
									</div>
								</div>
								<div class="frm-row" id="borrower-section">
									<input type="hidden" name="edit_orderId" value="" id="edit_orderId">

									<input type="hidden" name="edit_property_id" value="" id="edit_property_id">

									<input type="hidden" name="edit_transaction_id" value="" id="edit_transaction_id">

									<input type="hidden" name="edit_fileId" value="" id="edit_fileId">

									<input type="hidden" name="edit_LenderId" value="" id="edit_LenderId">
									<div class="section colm colm12">
										<label class="field prepend-icon">
											<input type="text" name="primary_borrower" id="primary_borrower" class="gui-input"
												placeholder="Primary Borrower">
											<span class="field-icon"><i class="fa fa-user"></i></span>
										</label>
									</div>
								</div>
								<div class="frm-row" id="secondary-borrower-section">
									<div class="section colm colm12">
										<label class="field prepend-icon">
											<input type="text" name="edit_secondary_borrower" id="edit_secondary_borrower" class="gui-input"
												placeholder="Secondary Borrower">
											<span class="field-icon"><i class="fa fa-user"></i></span>
										</label>
									</div>
								</div>
								<div class="frm-row" id="edit-lender-section">
									<div class="section colm colm12">
										<label class="field prepend-icon">
											<input type="text" name="edit_lender" id="edit_lender" class="gui-input"
												placeholder="Lender" required="required">
											<span class="field-icon"><i class="fa fa-user"></i></span>
										</label>
									</div>
								</div>
								
							</div>
						</div>
						<div class="form-footer" style="padding-top:0px;">
							<button type="submit" data-btntext-sending="Sending..."
								class="button btn-primary">Submit</button>
							<button type="reset" data-dismiss="modal" aria-label="Close" class="button">Cancel</button>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
	<!-- Edit info modal -->

	<!-- show message modal -->
	<div class="modal fade" id="show_message" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-sm" role="document">
                <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title"></h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body search-result">
                	<h4 class="modal-title"></h4>
                        <div>Data updated successfully</div>
                </div>
                <!-- <div class="modal-footer">
                    <div class="apn-search-loader hidden"></div>
                </div> -->
                </div>
            </div>
            </div>
	<!-- show message modal -->
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
		

		if(jQuery('#add-order-details').length)
	    {
	       jQuery('#add-order-details').validate({
	       		ignore:":not(:visible)",
	            rules: {
	                TitleOfficer:"required",
	                loan_number:"required",
	                borrower:"required",
	                lender:"required",
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
	            	var TitleOfficer = $('#TitleOfficer').val();
	            	var loan_number = $('#loan_number').val();
	            	var borrower = $('#borrower').val();
	            	var secondary_borrower = $('#secondary_borrower').val();
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
	                    loan_number: loan_number,
	                    borrower: borrower,
	                    secondary_borrower: secondary_borrower,
	                    LenderId: LenderId,
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
							generateProposedInsured(res.fileId);
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
	    $("#lender").autocomplete({
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
				$("#lender").val(ui.item.value);
				$("#LenderId").val(ui.item.id);
	            
	        },
	        change: function( event, ui ) {
	            if (ui.item == null)
	            {
					$("#LenderId").val('');				
	            }
	        }
	    });

	    $("#edit_lender").autocomplete({
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
				$("#edit_lender").val(ui.item.value);
				$("#edit_LenderId").val(ui.item.id);
	            
	        },
	        change: function( event, ui ) {
	            if (ui.item == null)
	            {
					$("#LenderId").val('');				
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
		            loan_amount:"required",
		            primary_borrower:"required",
		            edit_lender:"required",
		        },
		        messages: {
		            loan_amount:"Please enter loan amount",
		            primary_borrower:"Please enter borrower",
		            edit_lender:"Please enter lender",
		        },
		        submitHandler: function(form) {
		        	$('#page-preloader').css('background-color', 'rgba(0,0,0,.5)');
					$('#page-preloader').css('display', 'block');
		        	
		        	var loan_amount = $('#loan_amount').val();
		        	var borrower = $('#primary_borrower').val();
		        	var edit_secondary_borrower = $('#edit_secondary_borrower').val();
		        	var LenderId = $('#edit_LenderId').val();
		        	var orderId = $('#edit_orderId').val();
		        	var transaction_id = $('#edit_transaction_id').val();
		        	var property_id = $('#edit_property_id').val();
		        	var fileId = $('#edit_fileId').val();

		            $.ajax({
		            url: base_url + "update-order-details",
		            type: "post",
		            data:{
		                loan_amount: loan_amount,
		                borrower: borrower,
		                LenderId: LenderId,
		                orderId: orderId,
		                transaction_id: transaction_id,
		                property_id: property_id,
		                fileId: fileId,
		                secondary_borrower: edit_secondary_borrower,
		            }, 
		            success: function(response) {
		            	$('#page-preloader').css('display', 'none');
		            	var res = JSON.parse(response);
						if(res.status == 'success')
						{							
							$('#edit-data-result').html('<div class="alert alert-success">Data updated successfully</div>');
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
            	$('#page-preloader').css('display', 'none');
            	var res = JSON.parse(response);
            	
            	if(res.status == 'dataRequired')
                {
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
                }
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
            url: base_url + "get-order-details",
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
                	var loan_amount = res.loan_amount;
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
                	$('#edit_LenderId').val(escrow_lender_id);
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
</script>
