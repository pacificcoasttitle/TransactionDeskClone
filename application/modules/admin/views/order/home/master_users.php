<style>
.dataTables_length {
    width: 250px !important;
    float: left;
}
</style>
<div class="container-fluid">
    <div class="card mb-3">
        <div class="card-header">
            <i class="fas fa-table"></i>
            Master Users
            <div class="float-right">
                <a href="<?php echo base_url()?>order/admin/add-new-master-user" class="btn btn-secondary"> Add New Master User </a>
                <a href="javascript:void(0);" data-export-type="csv" id="export_master_users" class="btn btn-secondary"> Export </a>
            </div>
        </div>

        <div class="card-body">
            <div id="master_users_success_msg" class="w-100 alert alert-success alert-dismissible" style="display:none;"></div>
            <div id="master_users_error_msg" class="w-100 alert alert-danger alert-dismissible" style="display:none;"></div>
            <div class="table-responsive">
                <table class="table table-bordered" id="tbl-master-users-listing" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>First Name</th>
                            <th>Last Name</th>
                            <th>Email</th>
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