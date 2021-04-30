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
            Lenders
            <div class="float-right">
                <a href="<?php echo base_url()?>order/admin/import-lenders" class="btn btn-secondary"> Import </a>
                <a href="javascript:void(0);" data-export-type="csv" id="export-csv" class="btn btn-secondary"> Export </a>
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
                            <!-- <th>Telephone</th> -->
                            <th>Company Name</th>
                            <th>Street Address</th>
                            <th>City</th>
                            <th>Zipcode</th>
                            <th>User Type</th>
                            <!-- <th>Lender Type</th> -->
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
        console.log('hi');
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
</script>