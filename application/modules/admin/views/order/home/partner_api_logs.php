<?php 
    $salesRep = isset($salesRep['data']) && !empty($salesRep['data']) ? $salesRep['data'] : array();
    
    $sales_rep = json_encode($salesRep);

    $titleOfficer = isset($titleOfficer['data']) && !empty($titleOfficer['data']) ? $titleOfficer['data'] : array();
    
    $title_officer = json_encode($titleOfficer);

?>
<script type="text/javascript">
    var sales_rep = '<?php echo $sales_rep; ?>';
    var title_officer = '<?php echo $title_officer; ?>';
</script>
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
                <table class="table table-bordered" id="tbl-partner-api-log-listing" width="100%" cellspacing="0" >
                    <thead>
                        <tr>
                            <th>Sr No</th>
                            <th>Order No</th>
                            <th>Title Officer</th>
                            <th>Sales Rep</th>
                            <th>Underwriter</th>
                            <th>Message</th>
                            <th>Created At</th>
                        </tr>
                    </thead>                
                    <tbody></tbody>
                </table>
            </div>
        </div>
    </div>
</div><!-- /.container-fluid -->