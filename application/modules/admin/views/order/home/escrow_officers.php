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
            Escrow Officers
            <div class="float-right">
                <a href="<?php echo base_url()?>order/admin/add-escrow-officer" class="btn btn-secondary"> Add </a>
            </div>
        </div>               
        <div class="card-body">
            <div id="escrow_officer_success_msg" class="w-100 alert alert-success alert-dismissible" style="display:none;"></div>
            <div id="escrow_officer_error_msg" class="w-100 alert alert-danger alert-dismissible" style="display:none;"></div>
            <div class="table-responsive">
                <table class="table table-bordered" id="tbl-escrow-officers-listing" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Partner ID</th>
                            <th>Partner Type ID</th>
                            <th>Name</th>
                            <th>Email Address</th>
                            <th>Action</th>
                        </tr>
                    </thead>                
                    <tbody></tbody>
                </table>
            </div>
        </div>
    </div>
</div><!-- /.container-fluid -->