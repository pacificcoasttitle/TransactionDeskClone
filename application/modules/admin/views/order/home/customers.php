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
            Credentials Check
            <div class="float-right">
                <a href="javascript:void(0);" id="refresh-data" class="btn btn-secondary">All Users</a>
                <a href="javascript:void(0);" id="refresh-new-users-data" class="btn btn-secondary">New Users</a>
                <a href="javascript:void(0);" data-export-type="csv" id="export_customer" class="btn btn-secondary"> Export </a>
            </div>
        </div>

                
        <div class="card-body">
            <div id="customer_success_msg" class="w-100 alert alert-success alert-dismissible" style="display:none;"></div>
            <div id="customer_error_msg" class="w-100 alert alert-danger alert-dismissible" style="display:none;"></div>
            <div class="table-responsive">
                <table class="table table-bordered" id="tbl-credentials-customers-listing" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>First Name</th>
                            <th>Last Name</th>
                            <th>Email Address</th>
                            <th>Telephone</th>
                            <th>Company Name</th>
                            <th>property Address</th>
                            <th>Password</th>
                            <th>Customer Type</th>
                            <th>Crediential</th>
                            <th>Error Message</th>
                        </tr>
                    </thead>                
                    <tbody></tbody>
                </table>
            </div>
        </div>
    </div>
</div><!-- /.container-fluid -->