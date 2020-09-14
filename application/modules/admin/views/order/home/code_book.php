<div class="container-fluid">
    <div class="card mb-3">
        <div class="card-header">
            <i class="fas fa-table"></i>
            Fees Types
            <div class="float-right">
                <a href="<?php echo base_url(); ?>order/admin/import-code-book" class="btn btn-secondary"> Import </a>
                <a href="<?php echo base_url(); ?>order/admin/add-code-book" class="btn btn-secondary"> Add </a>
            </div>
        </div>
        <div class="card-body">
            <div id="code_book_success_msg" class="w-100 alert alert-success alert-dismissible" style="display:none;"></div>
            <div id="code_book_error_msg" class="w-100 alert alert-danger alert-dismissible" style="display:none;"></div>
            <div class="table-responsive">
                <table class="table table-bordered" id="tbl-code-book" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Sr No</th>
                            <th>Code</th>
                            <th>Type</th>
                            <th>Language</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
        </div>
    </div>
</div>