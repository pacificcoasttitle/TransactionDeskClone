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
            CPL Documents
            <div class="float-right">
                <a href="javascript:void(0);" data-export-type="csv" id="export_cpl_documents" class="btn btn-secondary"> Export </a>
            </div>
        </div>

        <div class="card-body">
            <div id="cpl_document_success_msg" class="w-100 alert alert-success alert-dismissible" style="display:none;"></div>
            <div id="cpl_document_error_msg" class="w-100 alert alert-danger alert-dismissible" style="display:none;"></div>
            <div class="table-responsive">
                <table class="table table-bordered" id="tbl-cpl-documents-listing" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>File Number</th>
                            <th>Document Name</th>
                            <th>Sent To Resware</th>
                            <th>Action</th>
                        </tr>
                    </thead>                
                    <tbody></tbody>
                </table>
            </div>
        </div>
    </div>
</div>