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
            Agents
            <div class="float-right">
                <a href="<?php echo base_url()?>order/admin/import-agents" class="btn btn-secondary"> Import </a>
                <a href="javascript:void(0);" data-export-type="csv" id="export-agent-data" class="btn btn-secondary"> Export </a>
            </div>
        </div>

                
        <div class="card-body">
            <div id="agent_success_msg" class="w-100 alert alert-success alert-dismissible" style="display:none;"></div>
            <div id="agent_error_msg" class="w-100 alert alert-danger alert-dismissible" style="display:none;"></div>
            <div class="table-responsive">
                <table class="table table-bordered" id="tbl-agents-listing" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Partner Id</th>
                            <th>Name</th>
                            <!-- <th>Last Name</th> -->
                            <th>Email Address</th>
                            <th>Telephone</th>
                            <th>Company</th>
                            <th>Full Address</th>
                            <th>Action</th>
                        </tr>
                    </thead>                
                    <tbody></tbody>
                </table>
            </div>
        </div>
    </div>
</div><!-- /.container-fluid -->