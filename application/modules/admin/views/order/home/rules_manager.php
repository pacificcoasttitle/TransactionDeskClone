<style>
.bootstrap-select:not([class*="col-"]):not([class*="form-control"]):not(.input-group-btn) {
    width: -webkit-fill-available;
}
</style>
<div class="container-fluid">
    <div class="card mb-3">
        <div class="card-header">
            <i class="fas fa-table"></i>
            Rules Manager
            <!-- <div class="float-right">
                <a href="<?php // echo base_url(); ?>order/admin/add-fee" class="btn btn-secondary"> Add Fees </a>
            </div> -->
        </div>
        <div class="card-body">
            <div id="rules_success_msg" class="w-100 alert alert-success alert-dismissible" style="display:none;"></div>
            <div id="rules_error_msg" class="w-100 alert alert-danger alert-dismissible" style="display:none;"></div>
            <div class="table-responsive">
                <table class="table table-bordered" id="tbl-rules-manager" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Sr No</th>
                            <th>Title</th>
                            <th>Value</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<script src="<?php echo base_url(); ?>assets/libs/jquery-1.12.4.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/frontend/js/jquery-ui.min.js"></script>
<script type="text/javascript">
    $(document).ready(function() {
        
  
    }); 
</script>