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
            Title Officer
            <div class="float-right">
                <a href="<?php echo base_url()?>order/admin/add-title-officer" class="btn btn-secondary">Add Title Officer</a>
                <a href="javascript:void(0);" data-export-type="csv" id="export-title-officer-data" class="btn btn-secondary">Export</a>
            </div>
        </div>
  
        <div class="card-body">
            <div id="title_officer_success_msg" class="w-100 alert alert-success alert-dismissible" style="display:none;"></div>
            <div id="title_officer_error_msg" class="w-100 alert alert-danger alert-dismissible" style="display:none;"></div>
            <div class="table-responsive">
                <table class="table table-bordered" id="tbl-title-officer-listing" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>First Name</th>
                            <th>Last Name</th>
                            <th>Email Address</th>
                            <th>Telephone</th>
                            <th>Partner Id</th>
                            <th>Partner Type Id</th>
                            <th>Action</th>
                        </tr>
                    </thead>                
                    <tbody></tbody>
                </table>
            </div>
        </div>
    </div>
</div>