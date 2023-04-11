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
            Escrows
            <div class="float-right">
                <a href="<?php echo base_url()?>order/admin/import" class="btn btn-secondary"> Import </a>
                <a href="javascript:void(0);" data-export-type="csv" id="export-csv" class="btn btn-secondary"> Export </a>
            </div>
        </div>
                
        <div class="card-body">
            <div id="customer_success_msg" class="w-100 alert alert-success alert-dismissible" style="display:none;"></div>
            <div id="customer_error_msg" class="w-100 alert alert-danger alert-dismissible" style="display:none;"></div>
            <div class="table-responsive">
                <table class="table table-bordered" id="tbl-customers-listing" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <!-- <th>Customer Number</th> -->
                            <th>First Name</th>
                            <th>Last Name</th>
                            <th>Email Address</th>
                            <th>Company Name</th>
                            <th>Street Address</th>
                            <th>City</th>
                            <th>Zipcode</th>
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