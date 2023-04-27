<?php 
    $salesRep = isset($salesRep['data']) && !empty($salesRep['data']) ? $salesRep['data'] : array();
    $product_type = isset($product_type) && !empty($product_type) ? $product_type : '';
    $sales_rep = json_encode($salesRep);
    $master_users = json_encode($master_users);
?>
<script type="text/javascript">
	var lp_sales_rep = '<?php echo $sales_rep; ?>';
	var lp_master_users = '<?php echo $master_users; ?>';
	var lp_product_type = '<?php echo $product_type; ?>';

</script>
<style>
	.dataTables_length {
		width: 250px !important;
		float: left;
	}

    input[type=checkbox] {
        height: 20px !important;
        width: 20px !important;
    }
	.FilterOrderListing {
		display: flex;
		width: 100%
	}
	@media (min-width: 992px) {
		.modal-lg {
			max-width: 1400px !important;
		}
	}	
</style>
<div class="container-fluid">
	<!-- DataTables Example -->
	<div class="card mb-3">
		<div class="card-header">
			<i class="fas fa-table"></i>
			Lp Orders
			<div class="float-right">
                <a href="javascript:void(0);" data-export-type="csv" onclick="exportLPOrders();" id="export-orders-data" class="btn btn-secondary"> Export </a>
            </div>
		</div>


		<div class="card-body">
            <?php if(!empty($success)) {?>
                <div id="" class="w-100 alert alert-success alert-dismissible"><?php echo $success;?></div>
            <?php }   
            if(!empty($errors)) {?>
                <div id="" class="w-100 alert alert-danger alert-dismissible"><?php echo $errors;?></div>
            <?php } ?>
			<div id="lp_order_success_msg" class="w-100 alert alert-success alert-dismissible" style="display:none;">
			</div>
			<div id="lp_order_error_msg" class="w-100 alert alert-danger alert-dismissible" style="display:none;"></div>
			<div class="table-responsive">
				<table class="table table-bordered" id="tbl-lp-orders-listing" width="100%" cellspacing="0">
					<thead>
						<tr>
							<th>Sr No</th>
							<th>Order#</th>
							<th>Property Address</th>
							<th>Product Type</th>
							<th>Sales Rep</th>
							<th>Created By</th>
							<th>Lp Document Name</th>
							<th>Report Status</th>
							<th>Sync To Resware</th>      
							<th>Created At</th>
							<th>Action</th>
						</tr>
					</thead>
					<tbody></tbody>
				</table>
			</div>
		</div>
	</div>
</div><!-- /.container-fluid -->

<div class="modal fade" width="1200px" id="instrument_model" tabindex="-1" role="dialog" aria-labelledby="Lender Infromation" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document" style="width:90%;">
                <div class="modal-content">
                    <form method="POST" action="<?php echo base_url();?>order/admin/store-lp-document-info">
                        <div class="smart-forms smart-container" style="margin:30px">
                            <div class="modal-body search-result">
                                <div id="deliverables-details-fields">
                                    <div class="spacer-b20">
                                        <div class="tagline"><span>Select Documents</span></div>
                                    </div>
                                    <div class="frm-row" id="clone_container">
										<div class="section colm colm12" id="clone-email-address" style="margin-bottom: 0px !important;">
                                            <div class="toclone">
                                                <div class="spacer-b10">
                                                    <label class="field" id="instrument_number_container">
                                                        
                                                    </label>
                                                </div>
                                                
                                            </div>
										</div>
									</div>
                                </div>
                            </div>
                            <div class="form-footer" style="padding: 0px 1rem !important;">
                                <button type="submit" data-btntext-sending="Sending..."
                                    class="button btn-primary">Submit</button>
                                <button type="reset" data-dismiss="modal" aria-label="Close" class="button">Cancel</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div><!-- /.container-fluid -->

<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/frontend/css/smart-forms.css">
	
<script>
	function getInstrumentData(file_id) {
        $('body').animate({
			opacity: 0.5
		}, "slow");
		$.ajax({
			url: base_url + "order/admin/get-instrument-data",
			method: "POST",
			data: {
				file_id: file_id
			},
			success: function (data) {
				var result = jQuery.parseJSON(data);
                $('body').animate({
						opacity: 1.0
                }, "slow");
				if (result.status == 'success') {
					$('#instrument_number_container').html(result.data);
					$('#instrument_model').modal('show');
				} else {
					$('#instrument_number_container').html(result.data);
					$('#instrument_model').modal('show');
				}
			},
			error: function (XMLHttpRequest, textStatus, errorThrown) {
				$('#lp_order_error_msg').html('Something went wrong. Please try it again.').show();
				$([document.documentElement, document.body]).animate({
					scrollTop: $("#lp_order_success_msg").offset().top
				}, 1000);

				setTimeout(function () {
					$('#lp_order_error_msg').html('').hide();
				}, 5000);
			}
		});
	}

	function regenerateReport(file_id) {
        $('body').animate({
			opacity: 0.5
		}, "slow");
		$.ajax({
			url: base_url + "order/admin/regenerate-report",
			method: "POST",
			data: {
				file_id: file_id
			},
			success: function (data) {
				var result = jQuery.parseJSON(data);
                $('body').animate({
						opacity: 1.0
                }, "slow");
				$('#lp_order_success_msg').html(result.message).show();
				$([document.documentElement, document.body]).animate({
						scrollTop: $("#lp_order_success_msg").offset().top
				}, 1000);
				lp_order_list.ajax.reload(null, false);
				setTimeout(function () {
					$('#lp_order_success_msg').html('').hide();
				}, 5000);
				
			},
			error: function (XMLHttpRequest, textStatus, errorThrown) {
				$('#lp_order_error_msg').html('Something went wrong. Please try it again.').show();
				$([document.documentElement, document.body]).animate({
					scrollTop: $("#lp_order_success_msg").offset().top
				}, 1000);

				setTimeout(function () {
					$('#lp_order_error_msg').html('').hide();
				}, 5000);
			}
		});
	}

	function sendOrderToResware(file_id) {
		$('body').animate({
			opacity: 0.5
		}, "slow");
		$.ajax({
			url: base_url + "order/admin/send-order-to-resware",
			method: "POST",
			data: {
				file_id: file_id
			},
			success: function (data) {
				var result = jQuery.parseJSON(data);
				if (result.status == 'success') {
					$('body').animate({
						opacity: 1.0
					}, "slow");
					$('#lp_order_success_msg').html(result.message).show();
					$([document.documentElement, document.body]).animate({
						scrollTop: $("#lp_order_success_msg").offset().top
					}, 1000);
					lp_order_list.ajax.reload(null, false);
					setTimeout(function () {
						$('#lp_order_success_msg').html('').hide();
					}, 5000);
				} else {
					$('body').animate({
						opacity: 1.0
					}, "slow");
					$('#lp_order_error_msg').html(result.message).show();
					$([document.documentElement, document.body]).animate({
						scrollTop: $("#lp_order_error_msg").offset().top
					}, 1000);
					setTimeout(function () {
						$('#lp_order_error_msg').html('').hide();
					}, 5000);
				}
			},
			error: function (XMLHttpRequest, textStatus, errorThrown) {
				$('#lp_order_error_msg').html('Something went wrong. Please try it again.').show();
				$([document.documentElement, document.body]).animate({
					scrollTop: $("#lp_order_success_msg").offset().top
				}, 1000);

				setTimeout(function () {
					$('#lp_order_error_msg').html('').hide();
				}, 5000);
			}
		});
	}

	function updateLpReportStatus(file_id, status) {
		$('body').animate({
			opacity: 0.5
		}, "slow");
		$.ajax({
			url: base_url + "order/admin/update-lp-report-status",
			method: "POST",
			data: {
				file_id: file_id,
				status: status
			},
			success: function (data) {
				var result = jQuery.parseJSON(data);
				if (result.status == 'success') {
					$('body').animate({
						opacity: 1.0
					}, "slow");
					$('#lp_order_success_msg').html(result.msg).show();
					$([document.documentElement, document.body]).animate({
						scrollTop: $("#lp_order_success_msg").offset().top
					}, 1000);
					companies_list.ajax.reload(null, false);
					setTimeout(function () {
						$('#lp_order_success_msg').html('').hide();
					}, 4000);
				} else {
					$('#lp_order_error_msg').html(result.message).show();
					$([document.documentElement, document.body]).animate({
						scrollTop: $("#lp_order_error_msg").offset().top
					}, 1000);

					setTimeout(function () {
						$('#lp_order_error_msg').html('').hide();
					}, 4000);
				}
			},
			error: function (XMLHttpRequest, textStatus, errorThrown) {
				$('#lp_order_error_msg').html('Something went wrong. Please try it again.').show();
				$([document.documentElement, document.body]).animate({
					scrollTop: $("#lp_order_error_msg").offset().top
				}, 1000);

				setTimeout(function () {
					$('#lp_order_error_msg').html('').hide();
				}, 4000);
			}
		});
	}

	function downloadDocumentFromAws(url, documentType) {
		$('#page-preloader').css('background-color', 'rgba(0,0,0,.5)');
		$('#page-preloader').css('display', 'block');
		var fileNameIndex = url.lastIndexOf("/") + 1;
		var filename = url.substr(fileNameIndex);
		$.ajax({
			url: base_url + "download-aws-document-admin",
			type: "post",
			data: {
				url: url
			},
			async: false,
			success: function (response) {
				if (response) {
					if (navigator.msSaveBlob) {
						var csvData = base64toBlob(response, 'application/octet-stream');
						var csvURL = navigator.msSaveBlob(csvData, filename);
						var element = document.createElement('a');
						element.setAttribute('href', csvURL);
						element.setAttribute('download', documentType + "_" + filename);
						element.style.display = 'none';
						document.body.appendChild(element);
						document.body.removeChild(element);
					} else {
						console.log(response);
						var csvURL = 'data:application/octet-stream;base64,' + response;
						var element = document.createElement('a');
						element.setAttribute('href', csvURL);
						element.setAttribute('download', documentType + "_" + filename);
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
