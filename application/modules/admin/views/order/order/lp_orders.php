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
</style>
<div class="container-fluid">
    <!-- DataTables Example -->
    <div class="card mb-3">
        <div class="card-header">
            <i class="fas fa-table"></i>
            Lp Orders
        </div>

                
        <div class="card-body">
            <div id="lp_order_success_msg" class="w-100 alert alert-success alert-dismissible" style="display:none;"></div>
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
                            <th>Lp Document Name</th> 
                            <th>Report Status</th> 
                            <th>Created By</th>           
                            <!-- <th>Avoid Duplication</th>            -->
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

function sendOrderToResware(file_id)
{    
    $('body').animate({ opacity: 0.5 }, "slow");
    $.ajax({
        url: base_url+"order/admin/send-order-to-resware",
        method: "POST",
        data : {
            file_id: file_id
        },
        success: function(data){
            var result = jQuery.parseJSON(data);
            if (result.status == 'success') {
                $('body').animate({ opacity: 1.0 }, "slow");
                $('#lp_order_success_msg').html(result.message).show();
                $([document.documentElement, document.body]).animate({
                    scrollTop: $("#lp_order_success_msg").offset().top
                }, 1000);
                lp_order_list.ajax.reload( null, false );
                setTimeout(function () {
                    $('#lp_order_success_msg').html('').hide();
                }, 5000);
            } else {
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

function updateLpReportStatus(file_id, status)
{
    $('body').animate({ opacity: 0.5 }, "slow");
    $.ajax({
        url: base_url+"order/admin/update-lp-report-status",
        method: "POST",
        data : {
            file_id: file_id,
            status: status
        },
        success: function(data){
            var result = jQuery.parseJSON(data);
            if (result.status == 'success') {
                $('body').animate({ opacity: 1.0 }, "slow");
                $('#lp_order_success_msg').html(result.msg).show();
                $([document.documentElement, document.body]).animate({
                    scrollTop: $("#lp_order_success_msg").offset().top
                }, 1000);
                companies_list.ajax.reload( null, false );
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

function downloadDocumentFromAws(url, documentType)
{
    console.log('url ==', url);
    console.log('documentType ==', documentType);
    $('#page-preloader').css('background-color', 'rgba(0,0,0,.5)');
    $('#page-preloader').css('display', 'block');
    var fileNameIndex = url.lastIndexOf("/") + 1;
    var filename = url.substr(fileNameIndex);
    console.log('filename ==', filename);
    $.ajax({
        url: base_url + "download-aws-document-admin",
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