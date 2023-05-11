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
	<div class="row mb-3">
		<div class="col-sm-6">
			<h1 class="h3 text-gray-800">Lp Orders</h1>
		</div>
		<div class="col-sm-6">
            <a href="javascript:void(0);" data-export-type="csv" onclick="exportLPOrders();" id="export-orders-data" class="btn btn-success btn-icon-split float-right mr-2"> 
                <span class="icon text-white-50">
                    <i class="fas fa-file-export"></i>
                </span>
                <span class="text"> Export </span> </a>
		</div>
	</div>
	<div class="card shadow mb-4">
        <div class="card-header datatable-header py-3">
            <div class="datatable-header-titles" > 
                <span>
                    <i class="fas fa-table"></i>
                </span>
                <h6 class="m-0 font-weight-bold text-primary pl-10">Orders Listing</h6> 
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
							<th width="5%" >Sr No</th>
							<th width="10%">Order#</th>
							<th width="10%">Property Address</th>
							<th width="10%">Product Type</th>
							<th width="7%">Sales Rep</th>
							<th width="7%">Created By</th>
							<th width="10%">Lp Document Name</th>
							<th width="15%">Report Status</th>
							<th width="5%">Sync To Resware</th>      
							<th width="10%">Created At</th>
							<th width="10%">Action</th>
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