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
            LP Document Types
            <div class="float-right">
                <a href="<?php echo base_url()?>order/admin/import-lp-document-types" class="btn btn-secondary"> Import </a>
                <a href="javascript:void(0);" class="btn btn-secondary"> Add LP Document Type </a>
            </div>
        </div>
                
        <div class="card-body">
            <div id="lp_document_types_success_msg" class="w-100 alert alert-success alert-dismissible" style="display:none;"></div>
            <div id="lp_document_types_error_msg" class="w-100 alert alert-danger alert-dismissible" style="display:none;"></div>
            <div class="table-responsive">
                <table class="table table-bordered" id="tbl-lp-document-types-listing" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Sr No</th>
                            <th>Category</th>
                            <th>Description</th>
                            <th>Doc Type</th>
                            <th>Doc Subtype</th>
                            <th>Is Notice</th>
                            <th>Action</th>
                        </tr>
                    </thead>                
                    <tbody></tbody>
                </table>
            </div>
        </div>
    </div>
</div>