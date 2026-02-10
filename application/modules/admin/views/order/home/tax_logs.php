<div class="pct-admin-listing">
    <!-- Page Header -->
    <div class="page-header">
        <h1><i class="fas fa-receipt"></i> Tax Logs</h1>
    </div>

    <!-- Tax Logs Table Card -->
    <div class="modern-card">
        <div class="modern-card-header">
            <h2><i class="fas fa-list-alt"></i> Tax Log Listing</h2>
        </div>
        <div class="modern-card-body">
            <div id="customer_success_msg" class="alert-modern alert-success-modern" style="display:none;"></div>
            <div id="customer_error_msg" class="alert-modern alert-danger-modern" style="display:none;"></div>
            
            <div class="table-responsive">
                <table class="table table-bordered" id="tbl-tax-log-listing" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Sr No</th>
                            <th>Order No</th>
                            <th>Property Address</th>
                            <th>APN</th>
                            <th>Message</th>
                            <th>Created at</th>
                            <th>Action</th>
                        </tr>
                    </thead>                
                    <tbody></tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script>
    function regenerateTaxDocument(requestId, orderId, fileNumber) {
        $('body').animate({
            opacity: 0.5
        }, "slow");
        $.ajax({
            url: base_url + "order/admin/regenerate-tax-document",
            method: "POST",
            data: {
                request_id: requestId,
                order_id: orderId,
                file_number: fileNumber
            },
            success: function (data) {
                var result = jQuery.parseJSON(data);
                if (result.status == 'success') {
                    $('body').animate({
                        opacity: 1.0
                    }, "slow");
                    $('#customer_success_msg').html(result.message).show();
                    $([document.documentElement, document.body]).animate({
                        scrollTop: $("#customer_success_msg").offset().top
                    }, 1000);
                    log_list.ajax.reload(null, false);
                    setTimeout(function () {
                        $('#customer_success_msg').html('').hide();
                        $('#customer_error_msg').html('').hide();
                    }, 5000);
                } else {
                    $('body').animate({
                        opacity: 1.0
                    }, "slow");
                    $('#customer_error_msg').html(result.message).show();
                    $([document.documentElement, document.body]).animate({
                        scrollTop: $("#customer_error_msg").offset().top
                    }, 1000);
                    setTimeout(function () {
                        $('#customer_error_msg').html('').hide();
                    }, 5000);
                }
            },
            error: function (XMLHttpRequest, textStatus, errorThrown) {
                $('#customer_error_msg').html('Something went wrong. Please try it again.').show();
                $([document.documentElement, document.body]).animate({
                    scrollTop: $("#customer_success_msg").offset().top
                }, 1000);

                setTimeout(function () {
                    $('#customer_error_msg').html('').hide();
                }, 5000);
            }
        });
    }

    function generateTaxDocument(serviceId, orderId, fileNumber) {
        $('body').animate({
            opacity: 0.5
        }, "slow");
        $.ajax({
            url: base_url + "order/admin/generate-tax-document",
            method: "POST",
            data: {
                cs3_service_id: serviceId,
                order_id: orderId,
                file_number: fileNumber
            },
            success: function (data) {
                var result = jQuery.parseJSON(data);
                if (result.status == 'success') {
                    $('body').animate({
                        opacity: 1.0
                    }, "slow");
                    $('#customer_success_msg').html(result.message).show();
                    $([document.documentElement, document.body]).animate({
                        scrollTop: $("#customer_success_msg").offset().top
                    }, 1000);
                    log_list.ajax.reload(null, false);
                    setTimeout(function () {
                        $('#customer_success_msg').html('').hide();
                        $('#customer_error_msg').html('').hide();
                    }, 5000);
                } else {
                    $('body').animate({
                        opacity: 1.0
                    }, "slow");
                    $('#customer_error_msg').html(result.message).show();
                    $([document.documentElement, document.body]).animate({
                        scrollTop: $("#customer_error_msg").offset().top
                    }, 1000);
                    setTimeout(function () {
                        $('#customer_error_msg').html('').hide();
                    }, 5000);
                }
            },
            error: function (XMLHttpRequest, textStatus, errorThrown) {
                $('#customer_error_msg').html('Something went wrong. Please try it again.').show();
                $([document.documentElement, document.body]).animate({
                    scrollTop: $("#customer_success_msg").offset().top
                }, 1000);

                setTimeout(function () {
                    $('#customer_error_msg').html('').hide();
                }, 5000);
            }
        });
    }
</script>
