<div class="container-fluid">
    <div class="card mb-3">
        <div class="card-header">
            <i class="fas fa-table"></i>
            Holidays
            <div class="float-right">
                <a href="<?php echo base_url(); ?>order/admin/add-holiday" class="btn btn-secondary"> Add Holiday </a>
            </div>
        </div>
        <div class="card-body">
            <div id="holidays_success_msg" class="w-100 alert alert-success alert-dismissible" style="display:none;"></div>
            <div id="holidays_error_msg" class="w-100 alert alert-danger alert-dismissible" style="display:none;"></div>
            <div class="table-responsive">
                <table class="table table-bordered" id="tbl-holidays" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Sr No</th>
                            <th>Name</th>
                            <th>Date</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
        </div>
    </div>
</div>