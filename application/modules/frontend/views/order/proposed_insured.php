<style>
	.smart-forms .prepend-icon .field-icon {
		top: 14px !important;
	}
	.ui-autocomplete { position: absolute; cursor: default;z-index:10000 !important;} 
	.error {
		color: #FF2F0F !important;
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
							<div class="ui-decor-1a bg-primary"></div>
							<h3 class="ui-title-block_light">Below are all files</h3>
						</div>
						<div class="typography-sectiona">
							<div class="col-md-12">
								<div class="table-container">
									<table class="table table_primary" id="orders_listing">
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

									<div class="section colm colm12">
										<label class="field select">
                                            <select id="TitleOfficer" name="TitleOfficer">
                                                <option value="">Title Officer</option>
                                                <option value="Albert Wassif">Albert Wassif</option>
                                                <option value="Clive Virata">Clive Virata</option>
                                                <option value="Eddie LasMarias">Eddie LasMarias</option>
                                                <option value="Jim Jean">Jim Jean</option>
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
								<div class="frm-row" id="lender-section">
									<div class="section colm colm12">
										<label class="field prepend-icon">
											<input type="text" name="lender" id="lender" class="gui-input"
												placeholder="Lender" readonly="readonly" required="required">
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
</body>

</html>
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/frontend/css/smart-forms.css">
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/frontend/css/font-awesome.min.css">
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/frontend/css/jquery-ui.css">

<script type="text/javascript" src="<?php echo base_url(); ?>assets/frontend/js/jquery.validate.min.js"></script>
<script>
	$(document).ready(function () {
		if ($('#orders_listing').length) {
			order_list = $('#orders_listing').DataTable({
				// "pageLength": 2,
				"paging": true,
				"lengthChange": false,
				"language": {
					paginate: {
						next: '<span class="fa fa-angle-right"></span>',
						previous: '<span class="fa fa-angle-left"></span>',
					},
					"emptyTable": "Record(s) not found.",
                },
                "searching": false,
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
	                TitleOfficer:"required",
	                loan_number:"required",
	                borrower:"required",
	                lender:"required"
	            },
	            messages: {
	                TitleOfficer:"Please select title officer",
	                loan_number:"Please enter loan number",
	                borrower:"Please enter borrower",
	                lender:"Please enter lender",
	            },
	            submitHandler: function(form) {
	            	var TitleOfficer = $('#TitleOfficer').val();
	            	var loan_number = $('#loan_number').val();
	            	var borrower = $('#borrower').val();
	            	var lender = $('#lender').val();
	            	var orderId = $('#orderId').val();
	            	var transaction_id = $('#transaction_id').val();
	            	var property_id = $('#property_id').val();
	            	var fileId = $('#fileId').val();

	                $.ajax({
	                url: base_url + "add-order-details",
	                type: "post",
	                data:{
	                    TitleOfficer: TitleOfficer,
	                    loan_number: loan_number,
	                    borrower: borrower,
	                    lender: lender,
	                    orderId: orderId,
	                    transaction_id: transaction_id,
	                    property_id: property_id,
	                    fileId: fileId,
	                }, 
	                success: function(response) {
	                	var res = JSON.parse(response);
						if(res.status == 'success')
						{
							$('#lender_information').modal('hide');
							generateProposedInsured(res.fileId);
						}
						/*else if(res.status == 'success')
						{
							$('#result').html('<div class="alert alert-success">'+res.message+'</div>');
						}
						$('#result').show().delay(7000).fadeOut("normal", function(){
	        					$('#result').html('');
	        					$('#subject').val('');
	            				$('#body').val('');
	    				});*/
	                }
	            });
	            }
	        }); 
	    }
	});

function generateProposedInsured(fileId)
{
	if(fileId)
	{
		$.ajax({
            url: base_url + "generate-proposed-insured",
            type: "post",
            data:{
                fileId: fileId,
            },
            success: function(response) {
            	var res = JSON.parse(response);
            	console.log(res);
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
                	if(res.data.is_lender == 1)
                	{
                		$('#lender-section').css('display','none');
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
</script>
