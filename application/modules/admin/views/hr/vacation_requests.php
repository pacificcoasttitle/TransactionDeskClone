<div class="content">
    <?php if(!empty($success)) {?>
        <div class="alert alert-success">
            <button type="button" aria-hidden="true" class="close" data-dismiss="alert">
                <i class="nc-icon nc-simple-remove"></i>
            </button>
            <span><?php echo $success;?></span>
        </div>
    <?php } 
    if(!empty($errors)) {?>
        <div class="alert alert-danger">
            <button type="button" aria-hidden="true" class="close" data-dismiss="alert">
                <i class="nc-icon nc-simple-remove"></i>
            </button>
            <span><?php echo $errors;?></span>
        </div>
    <?php } ?>

    <div id="vacation_requests_success_msg" class="alert alert-success" style="display:none;"></div>
    <div id="vacation_requests_error_msg" class="alert alert-danger" style="display:none;"></div>
    
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card strpied-tabled-with-hover">
                    <div class="card-header ">
                        <a style="float:right;" class="btn btn-info btn-fill btn-wd" href="<?php echo base_url().'hr/admin/add-vacation-request'; ?>">
                            Add Vacation Request
                        </a>
                    </div>
                    <div class="card-body table-full-width table-responsive">
                        <table style="width:100%;" class="table table-hover table-striped" id="vacation_requests">
                            <thead>
                                <th>No</th>
                                <th>Employee</th>
                                <th>From Date</th>
                                <th>To Date</th>
                                <th>Salary Deduction</th>
                                <th>Time Charged Vacation</th>
                                <th>Action</th>
                            </thead>
                            <tbody>
                                
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

