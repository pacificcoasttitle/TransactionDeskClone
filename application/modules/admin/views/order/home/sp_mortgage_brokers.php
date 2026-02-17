<div class="pct-admin-listing">
    <!-- Page Header -->
    <div class="page-header">
        <h1><i class="fas fa-home"></i> Mortgage Users</h1>
        
        <div class="action-buttons">
            <a href="javascript:void(0);" onclick="syncSoftProOpenContacts('mortgage');" class="btn-action btn-action-success">
                <i class="fas fa-sync-alt"></i> Sync Mortgage
            </a>
        </div>
    </div>

    <!-- Mortgage Users Table Card -->
    <div class="modern-card">
        <div class="modern-card-header">
            <h2><i class="fas fa-users"></i> Mortgage Users Listing</h2>
        </div>
        <div class="modern-card-body">
            <div id="customer_success_msg" class="alert-modern alert-success-modern" style="display:none;"></div>
            <div id="customer_error_msg" class="alert-modern alert-danger-modern" style="display:none;"></div>
            <div id="mortgage_success_msg" class="alert-modern alert-success-modern" style="display:none;"></div>
            <div id="mortgage_error_msg" class="alert-modern alert-danger-modern" style="display:none;"></div>
            
            <div class="table-responsive">
                <table class="table table-bordered" id="tbl-sp-mortgage-listing" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Lookup Code</th>
                            <th>First Name</th>
                            <th>Last Name</th>
                            <th>Email Address</th>
                            <th>Company Name</th>
                            <th>Address</th>
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
    function isMortgagePrimaryUser() {    
        $('input[type="checkbox"]').on('change', function() {
            $('body').animate({ opacity: 0.5 }, "slow");
            var user_id = $(this).attr('id');
            var primaryMortgageUserFlag = $(this).is(":checked") ? 1 : 0;
            
            $.ajax({
                url: base_url + "is-mortgage-primary-user",
                method: "POST",
                data: {
                    user_id: user_id,
                    primaryMortgageUserFlag: primaryMortgageUserFlag
                },
                success: function(data) {
                    var result = jQuery.parseJSON(data);
                    if (result.status == 'success') {
                        $('body').animate({ opacity: 1.0 }, "slow");
                        $('#mortgage_success_msg').html(result.msg).show();
                        $([document.documentElement, document.body]).animate({
                            scrollTop: $("#mortgage_success_msg").offset().top
                        }, 1000);
                        customer_list.ajax.reload(null, false);
                        setTimeout(function() {
                            $('#mortgage_success_msg').html('').hide();
                        }, 4000);
                    } else {
                        $('#mortgage_error_msg').html(result.message).show();
                        $([document.documentElement, document.body]).animate({
                            scrollTop: $("#mortgage_error_msg").offset().top
                        }, 1000);
                        setTimeout(function() {
                            $('#mortgage_error_msg').html('').hide();
                        }, 4000);
                    }
                },
                error: function(XMLHttpRequest, textStatus, errorThrown) {
                    $('#mortgage_error_msg').html('Something went wrong. Please try it again.').show();
                    $([document.documentElement, document.body]).animate({
                        scrollTop: $("#mortgage_success_msg").offset().top
                    }, 1000);
                    setTimeout(function() {
                        $('#mortgage_error_msg').html('').hide();
                    }, 4000);
                }
            });
        });
    }
</script>