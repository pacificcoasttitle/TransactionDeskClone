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
            Sales Rep
            <div class="float-right">
                <a href="<?php echo base_url()?>order/admin/add-sales-rep" class="btn btn-secondary">Add Sales Rep</a>
                <a href="javascript:void(0);" data-export-type="csv" id="export-sales-rep-data" class="btn btn-secondary">Export</a>
            </div>
        </div>
     
        <div class="card-body">
            <div id="sales_rep_success_msg" class="w-100 alert alert-success alert-dismissible" style="display:none;"></div>
            <div id="sales_rep_error_msg" class="w-100 alert alert-danger alert-dismissible" style="display:none;"></div>
            <div class="table-responsive">
                <table class="table table-bordered" id="tbl-sales-rep-listing" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Email Address</th>
                            <th>Telephone</th>
                            <th>Partner Id</th>
                            <th>Partner Type Id</th>
                            <th>Mail Notification</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>                
                    <tbody></tbody>
                </table>
            </div>
        </div>
    </div>
</div>