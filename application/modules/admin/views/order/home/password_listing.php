<style>
.dataTables_length {
    width: 250px !important;
    float: left;
}
.password_listing_filter {
    display: flex;
    justify-content: end;
}
</style>
<div class="container-fluid">
    <!-- DataTables Example -->
    <div class="row mb-3">
		<div class="col-sm-6">
			<h1 class="h3 text-gray-800">Users</h1>
		</div>
	</div>
    <div class="card shadow mb-4">
        <div class="card-header datatable-header py-3">
            <div class="datatable-header-titles" > 
                <span>
                    <i class="fas fa-key"></i>
                </span>
                <h6 class="m-0 font-weight-bold text-primary pl-10">Users</h6> 
            </div>
        </div>
        <div class="card-body">
            <div id="password_listing_success_msg" class="w-100 alert alert-success alert-dismissible" style="display:none;"></div>
            <div id="password_listing_error_msg" class="w-100 alert alert-danger alert-dismissible" style="display:none;"></div>
            <div class="table-responsive">
                <table class="table table-bordered" id="tbl-password-listing" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <!-- <th>Customer Number</th> -->
                            <th>First Name</th>
                            <th>Last Name</th>
                            <th>Email Address</th>
                            <th>User Type</th>
                            <th>Company Name</th>
                            <th>Street Address</th>
                            <th>City</th>
                            <th>Zipcode</th>
                            <th>Password Required</th>
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
    function isPasswordRequired()
    {    
        $('input[type="checkbox"]').on('change', function() {
            $('body').animate({ opacity: 0.5 }, "slow");
            var user_id = $(this).attr('id');
            if ($(this).is(":checked")) {
                var is_password_required = 1;
            } else {
                var is_password_required = 0;
            }
            $.ajax({
                url: base_url+"is-password-required",
                method: "POST",
                data : {
                    user_id: user_id,
                    is_password_required: is_password_required
                },
                success: function(data){
                    var result = jQuery.parseJSON(data);
                    if (result.status == 'success') {
                        $('body').animate({ opacity: 1.0 }, "slow");
                        $('#password_listing_success_msg').html(result.msg).show();
                        $([document.documentElement, document.body]).animate({
                            scrollTop: $("#password_listing_success_msg").offset().top
                        }, 1000);
                        customer_list.ajax.reload( null, false );
                        setTimeout(function () {
                            $('#password_listing_success_msg').html('').hide();
                        }, 4000);
                    } else {
                        $('#password_listing_error_msg').html(result.message).show();
                        $([document.documentElement, document.body]).animate({
                            scrollTop: $("#password_listing_error_msg").offset().top
                        }, 1000);

                        setTimeout(function () {
                            $('#password_listing_error_msg').html('').hide();
                        }, 4000);
                    }
                },
                error: function (XMLHttpRequest, textStatus, errorThrown) {
                    $('#password_listing_error_msg').html('Something went wrong. Please try it again.').show();
                    $([document.documentElement, document.body]).animate({
                        scrollTop: $("#password_listing_success_msg").offset().top
                    }, 1000);

                    setTimeout(function () {
                        $('#password_listing_error_msg').html('').hide();
                    }, 4000);
                }
            });
        });
    }
</script>