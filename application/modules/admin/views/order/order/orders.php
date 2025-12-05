<?php 
    $salesRep = isset($salesRep['data']) && !empty($salesRep['data']) ? $salesRep['data'] : array();

    $product_type = isset($product_type) && !empty($product_type) ? $product_type : '';
    
    // $sales_rep = json_encode($salesRep);
    
    $master_users = json_encode($master_users);

    $userdata = $this->session->userdata('admin');
	$roleList = $this->common->getRoleList();
	$role_id = isset($userdata['role_id']) ? $userdata['role_id'] : 0;
	$roleName = $roleList[$role_id];
?>
<script type="text/javascript">
    var sales_rep = <?php echo json_encode($sales_rep, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP); ?>
    // var sales_rep = JSON.parse('<?php echo addslashes(json_encode($sales_rep)); ?>');
    var master_users = '<?php echo $master_users; ?>';
    var product_type = '<?php echo $product_type; ?>';
</script>
<style>
.dataTables_length {
    width: 250px !important;
    float: left;
}
.FilterOrderListing {
    display: flex;
    justify-content: space-between;
    width: 100%;
}
</style>
<div class="container-fluid">
    <!-- DataTables Example -->
    <div class="row mb-3">
		<div class="col-sm-2">
			<h1 class="h3 text-gray-800">Orders Listing</h1>
		</div>

        <?php  if (!in_array($roleName, ['CS Admin'])) : ?>
            <div class="col-sm-10">
                <a href="javascript:void(0);" data-export-type="csv" onclick="exportOrders();" id="export-orders-data" class="btn btn-success btn-icon-split float-right mr-2"> 
                    <span class="icon text-white-50">
                        <i class="fas fa-file-export"></i>
                    </span>
                    <span class="text"> Export </span> </a>
                <a href="javascript:void(0);" onclick="syncSoftProOrders();" id="export-orders-data" class="btn btn-success btn-icon-split float-right mr-2"> 
                    <span class="icon text-white-50">
                        <i class="fas fa-refresh"></i>
                    </span>
                    <span class="text"> Sync All Order </span> </a>
                <a href="javascript:void(0);" onclick="syncSoftProOrdersStatus();" id="export-orders-data" class="btn btn-success btn-icon-split float-right mr-2"> 
                    <span class="icon text-white-50">
                        <i class="fas fa-refresh"></i>
                    </span>
                    <span class="text"> Sync Order Status</span> </a>
                <a href="javascript:void(0);" onclick="fetchRevenueReport();" id="fetch-revenue-data" class="btn btn-success btn-icon-split float-right mr-2"> 
                    <span class="icon text-white-50">
                        <i class="fas fa-refresh"></i>
                    </span>
                    <span class="text"> Sync Revenue</span> </a>
                <a href="javascript:void(0);" onclick="openSoftproOrderPopup();" id="fetch-revenue-data" class="btn btn-success btn-icon-split float-right mr-2"> 
                    <span class="icon text-white-50">
                        <i class="fas fa-refresh"></i>
                    </span>
                    <span class="text"> Sync Order</span> </a>
            </div>
        <?php endif; ?>

	</div>
    <div class="card shadow mb-4">
        <div class="card-header datatable-header py-3">
            <div class="datatable-header-titles" > 
                <span>
                    <i class="fas fa-table"></i>
                </span>
                <h6 class="m-0 font-weight-bold text-primary pl-10">Orders Listing</h6> 
            </div>
            
            <!-- <div class="float-right">
                <a href="javascript:void(0);" data-export-type="csv" onclick="exportOrders();" id="export-orders-data" class="btn btn-success btn-icon-split float-right mr-2"> 
                <span class="icon text-white-50">
                    <i class="fas fa-file-export"></i>
                </span>
                <span class="text"> Export </span> </a>
            </div> -->
        </div>

                
        <div class="card-body">
            <div id="order_success_msg" class="w-100 alert alert-success alert-dismissible" style="display:none;"></div>
            <div id="order_error_msg" class="w-100 alert alert-danger alert-dismissible" style="display:none;"></div>
            <div class="table-responsive">
                <table class="table table-bordered" id="tbl-orders-listing" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Sr No</th>
                            <th>Order#</th>
                            <th>Property Address</th>
                            <th>Product Type</th>
                            <th>Sales Rep</th> 
                            <th>Created By</th>   
                            <th>Email Status</th>          
                            <th>Avoid Duplication</th>           
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

<div class="modal fade" id="fetchOrderNumber" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<form  method="post" id="sync-order-number-form" method="POST">
				<div class="row">
					<div class="col-lg-12">
						<div class="card shadow">
							<div class="card-header py-3">
								<h6 class="m-0 font-weight-bold text-primary">Sync Order Number </h6>
							</div>
							<div class="card-body"> 
                                <div class="smart-forms smart-container">
                                    <div class="modal-body search-result">
                                        
                                        <div class="form-group">
                                            <div class="row">
                                                <div class="col-sm-12">
                                                    <label for="order_number" class="col-form-label">Enter Order Number</label>
													<input name="order_number" required="" type="text" class="form-control" id="order_number">
                                                    <div id="sync_order_number_error_msg" class="error" style="display:none;"></div>
												</div>
											</div>
                                            
										</div>
									</div>
									<div class="form-footer" style="padding: 0px 1rem !important;">
										<button type="submit" data-btntext-sending="Sending..." onclick="syncOrderNumberFromSoftpro(event);" class="btn btn-success btn-icon-split btn-sm">
											<span class="icon text-white-50">
												<i class="fas fa-check"></i>
											</span>
											<span class="text">Sync Now</span>
										</button>
										<button type="reset" data-dismiss="modal" aria-label="Close" class="btn btn-danger btn-icon-split btn-sm">
											<span class="icon text-white-50">
												<i class="fas fa-ban"></i>
											</span>
											<span class="text">Cancel</span>
										</button>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</form>
		</div>
	</div>
</div>
