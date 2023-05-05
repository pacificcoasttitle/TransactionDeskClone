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
.FilterOrderListing {
    display: flex;
    justify-content: space-between;
    width: 100%;
}
</style>
<div class="container-fluid">
    <!-- DataTables Example -->
    <div class="row mb-3">
		<div class="col-sm-6">
			<h1 class="h3 text-gray-800">Orders Listing</h1>
		</div>
		<div class="col-sm-6">
            <a href="javascript:void(0);" data-export-type="csv" onclick="exportOrders();" id="export-orders-data" class="btn btn-success btn-icon-split float-right mr-2"> 
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

<script>
function avoidDuplication()
{    
    $('input[type="checkbox"]').on('change', function() {
        $('body').animate({ opacity: 0.5 }, "slow");
        var property_id = $(this).attr('id');
        if ($(this).is(":checked")) {
            var avoidFlag = 1;
        } else {
            var avoidFlag = 0;
        }
        $.ajax({
            url: base_url+"update-avoid-duplication-flag",
            method: "POST",
            data : {
                property_id: property_id,
                avoidFlag: avoidFlag
            },
            success: function(data){
                var result = jQuery.parseJSON(data);
                if (result.status == 'success') {
                    $('body').animate({ opacity: 1.0 }, "slow");
                    $('#order_success_msg').html(result.msg).show();
                    $([document.documentElement, document.body]).animate({
                        scrollTop: $("#order_success_msg").offset().top
                    }, 1000);
                    order_list.ajax.reload( null, false );
                    setTimeout(function () {
                        $('#order_success_msg').html('').hide();
                    }, 4000);
                } else {
                    $('#order_error_msg').html(result.message).show();
                    $([document.documentElement, document.body]).animate({
                        scrollTop: $("#order_error_msg").offset().top
                    }, 1000);

                    setTimeout(function () {
                        $('#order_error_msg').html('').hide();
                    }, 4000);
                }
            },
            error: function (XMLHttpRequest, textStatus, errorThrown) {
                $('#order_error_msg').html('Something went wrong. Please try it again.').show();
                $([document.documentElement, document.body]).animate({
                    scrollTop: $("#order_success_msg").offset().top
                }, 1000);

                setTimeout(function () {
                    $('#order_error_msg').html('').hide();
                }, 4000);
            }
        });
    });
}
</script>