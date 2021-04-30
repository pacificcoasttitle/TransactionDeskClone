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
            New Users
            <div class="float-right">
                <a href="<?php echo base_url()?>order/admin/add-new-user" class="btn btn-secondary"> Add New User </a>
                <a href="javascript:void(0);" data-export-type="csv" id="export_new_user" class="btn btn-secondary"> Export </a>
            </div>
        </div>

        <div class="card-body">
            <div id="new_users_success_msg" class="w-100 alert alert-success alert-dismissible" style="display:none;"></div>
            <div id="new_users_error_msg" class="w-100 alert alert-danger alert-dismissible" style="display:none;"></div>
            <div class="table-responsive">
                <table class="table table-bordered" id="tbl-new-users-listing" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th class="not-take">First Name</th>
                            <th class="not-take">Last Name</th>
                            <th>Email</th>
                            <th class="not-take">Company</th>
                            <th>Current Password</th>
                            <th>Random Password</th>
                        </tr>
                    </thead>                
                    <tbody></tbody>
                </table>
            </div>
        </div>
    </div>
</div>