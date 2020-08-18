<div class="container-fluid">
    <div class="card mb-3">
        <div class="card-header">
            <i class="fas fa-table"></i>
            Fees
            <div class="float-right">
                <a href="<?php echo base_url(); ?>order/admin/add-fee" class="btn btn-secondary"> Add Fees </a>
            </div>
        </div>
        <div class="card-body">
            <div id="fees_success_msg" class="w-100 alert alert-success alert-dismissible" style="display:none;"></div>
            <div id="fees_error_msg" class="w-100 alert alert-danger alert-dismissible" style="display:none;"></div>
            <div class="table-responsive">
                <table class="table table-bordered" id="tbl-fees" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Sr No</th>
                            <th>Transaction Type</th>
                            <th>Name</th>
                            <th>Value</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
        </div>
    </div>
</div>