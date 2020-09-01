<?php 
    $salesRep = isset($salesRep['data']) && !empty($salesRep['data']) ? $salesRep['data'] : array();

    $product_type = isset($product_type) && !empty($product_type) ? $product_type : '';
    
    $sales_rep = json_encode($salesRep);
    
    $master_users = json_encode($master_users);

?>
<script type="text/javascript">
    var sales_rep = '<?php echo $sales_rep; ?>';
    var master_users = '<?php echo $master_users; ?>';
    var product_type = '<?php echo $product_type; ?>';
</script>
<style>
.dataTables_length {
    width: 250px !important;
    float: left;
}
</style>
<div class="container-fluid">
    <!-- DataTables Example -->
    <div class="card mb-3">
        <div class="card-header">
            <i class="fas fa-table"></i>
            Orders
            <div class="float-right">
                <a href="javascript:void(0);" data-export-type="csv" onclick="exportOrders();" id="export-orders-data" class="btn btn-secondary"> Export </a>
            </div>
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