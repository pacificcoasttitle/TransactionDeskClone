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
            Companies
            <div class="float-right">
                <a href="<?php echo base_url()?>order/admin/add-company" class="btn btn-secondary"> Add Company </a>
                <a href="javascript:void(0);" data-export-type="csv" id="export_companies" class="btn btn-secondary"> Export </a>
            </div>
        </div>
     
        <div class="card-body">
            <div id="companies_success_msg" class="w-100 alert alert-success alert-dismissible" style="display:none;"></div>
            <div id="companies_error_msg" class="w-100 alert alert-danger alert-dismissible" style="display:none;"></div>
            <div class="table-responsive">
                <table class="table table-bordered" id="tbl-companies-listing" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Partner Company Id</th>
                            <th>Partner Company Name</th>
                            <th>Address</th>
                            <th>City</th>
                            <th>State</th>
                            <th>Zipcode</th>
                        </tr>
                    </thead>                
                    <tbody></tbody>
                </table>
            </div>
        </div>
    </div>
</div><!-- /.container-fluid -->