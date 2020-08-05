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
            Partner Api Logs
            <!-- <div class="float-right">
                <a href="javascript:void(0);" data-export-type="csv" id="export-csv" class="btn btn-secondary"> Export </a>
            </div> -->
        </div>

                
        <div class="card-body">
            <div id="customer_success_msg" class="w-100 alert alert-success alert-dismissible" style="display:none;"></div>
            <div id="customer_error_msg" class="w-100 alert alert-danger alert-dismissible" style="display:none;"></div>
            <div class="table-responsive">
                <table class="table table-bordered" id="tbl-partner-api-log-listing" style="table-layout: fixed;" width="100%" cellspacing="0" >
                    <thead>
                        <tr>
                            <th style="width: 10% !important;">Order No</th>
                            <th style="width: 20% !important;">Title Officer</th>
                            <th style="width: 25% !important;">Sales Rep</th>
                            <th style="width: 25%  !important;">Message</th>
                            <th style="width: 20% !important;">Created At</th>
                        </tr>
                    </thead>                
                    <tbody></tbody>
                </table>
            </div>
        </div>
    </div>
</div><!-- /.container-fluid -->