<div class="container-fluid">
    <div class="card mb-3">
        <div class="card-header">
            <i class="fas fa-table"></i>
            Code Book
            <div class="float-right">
                <a href="<?php echo base_url(); ?>order/admin/import-code-book" class="btn btn-secondary"> Import </a>
                <a href="<?php echo base_url(); ?>order/admin/add-code-book" class="btn btn-secondary" style="display: none;"> Add </a>
            </div>
        </div>
        <div class="card-body">
            <div id="code_book_success_msg" class="w-100 alert alert-success alert-dismissible" style="display:none;"></div>
            <div id="code_book_error_msg" class="w-100 alert alert-danger alert-dismissible" style="display:none;"></div>
            <div class="table-responsive">
                <table class="table table-bordered" id="tbl-code-book" style="table-layout: fixed;" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th style="width: 7%;">Sr No</th>
                            <th style="width: 10%;">Code</th>
                            <th style="width: 10%;">Type Id</th>
                            <th style="width: 12%;">Type</th>
                            <th style="width: 40%;">Language</th>
                            <th style="width: 10%;">Required Number</th>
                            <th style="width: 10%;">Action</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
        </div>
    </div>
</div>