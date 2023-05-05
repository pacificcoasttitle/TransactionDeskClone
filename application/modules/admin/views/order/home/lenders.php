<style>
.dataTables_length {
    width: 250px !important;
    float: left;
}
</style>
<div class="container-fluid">
    <div class="row mb-3">
		<div class="col-sm-6">
			<h1 class="h3 text-gray-800">Lenders </h1>
		</div>
		<div class="col-sm-6">
            <a href="<?php echo base_url()?>order/admin/import-lenders"  class="btn btn-success btn-icon-split float-right mr-2"> 
                <span class="icon text-white-50">
                    <i class="fas fa-file-import"></i>
                </span>
                <span class="text"> Import </span> 
            </a>
            <a href="javascript:void(0);" data-export-type="csv" id="export-csv" class="btn btn-success btn-icon-split float-right mr-2"> 
                <span class="icon text-white-50">
                    <i class="fas fa-file-export"></i>
                </span>
                <span class="text"> Export </span> 
            </a>
		</div>
	</div>
    <!-- DataTables Example -->
    <div class="card shadow mb-4">
        <div class="card-header datatable-header py-3">
            <div class="datatable-header-titles" > 
                <span>
                    <i class="fas fa-users"></i>
                </span>
                <h6 class="m-0 font-weight-bold text-primary pl-10">Lenders</h6> 
            </div>
        </div>

                
        <div class="card-body">
            <div id="customer_success_msg" class="w-100 alert alert-success alert-dismissible" style="display:none;"></div>
            <div id="customer_error_msg" class="w-100 alert alert-danger alert-dismissible" style="display:none;"></div>
            <div class="table-responsive">
                <table class="table table-bordered" id="tbl-lenders-listing" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>First Name</th>
                            <th>Last Name</th>
                            <th>Email Address</th>
                            <th>Company Name</th>
                            <th>Address</th>
                            <th>Mortgage User</th>
                            <th>User Type</th>
                            <th>Dual CPL</th>
                            <th>Allow Only Resware Order</th>
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
    function changeLenderUserType(id, selectValue) 
    {
        $.ajax({
            url: base_url+'admin/order/home/changeLenderUserType',
            type: "POST",
            data: {
                user_id: id,
                selectValue: selectValue
            },
            async: false,
            success: function (data) {
                var res = jQuery.parseJSON(data);
                if (res.success === true) {
                    $('body').animate({ opacity: 1.0 }, "slow");
                    $('#customer_success_msg').html('Lender user type updated successfully.').show();
                    $([document.documentElement, document.body]).animate({
                        scrollTop: $("#customer_success_msg").offset().top
                    }, 1000);
                    
                    setTimeout(function () {
                        $('#customer_success_msg').html('').hide();
                    }, 4000);
                } else {
                    $('#customer_error_msg').html('Lender User Type failed due to some error. Please try again.').show();
                    $([document.documentElement, document.body]).animate({
                        scrollTop: $("#customer_error_msg").offset().top
                    }, 1000);

                    setTimeout(function () {
                        $('#customer_error_msg').html('').hide();
                    }, 4000);
                }
            }
        });
    }

    function isMortgageUser()
    {    
        $('input[type="checkbox"]').on('change', function() {
            $('body').animate({ opacity: 0.5 }, "slow");
            var user_id = $(this).attr('id');
            if ($(this).is(":checked")) {
                var mortgageUserFlag = 1;
            } else {
                var mortgageUserFlag = 0;
            }
            $.ajax({
                url: base_url+"update-mortgage-user",
                method: "POST",
                data : {
                    user_id: user_id,
                    mortgageUserFlag: mortgageUserFlag
                },
                success: function(data){
                    var result = jQuery.parseJSON(data);
                    if (result.status == 'success') {
                        $('body').animate({ opacity: 1.0 }, "slow");
                        $('#customer_success_msg').html(result.msg).show();
                        $([document.documentElement, document.body]).animate({
                            scrollTop: $("#customer_success_msg").offset().top
                        }, 1000);
                        customer_list.ajax.reload( null, false );
                        setTimeout(function () {
                            $('#customer_success_msg').html('').hide();
                        }, 4000);
                    } else {
                        $('#customer_error_msg').html(result.message).show();
                        $([document.documentElement, document.body]).animate({
                            scrollTop: $("#customer_error_msg").offset().top
                        }, 1000);

                        setTimeout(function () {
                            $('#customer_error_msg').html('').hide();
                        }, 4000);
                    }
                },
                error: function (XMLHttpRequest, textStatus, errorThrown) {
                    $('#customer_error_msg').html('Something went wrong. Please try it again.').show();
                    $([document.documentElement, document.body]).animate({
                        scrollTop: $("#customer_success_msg").offset().top
                    }, 1000);

                    setTimeout(function () {
                        $('#customer_error_msg').html('').hide();
                    }, 4000);
                }
            });
        });
    }
</script>