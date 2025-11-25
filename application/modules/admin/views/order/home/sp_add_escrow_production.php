<div class="content">
    <?php if (!empty($success_msg)) {?>
        <div class="col-xs-12">
            <div class="alert alert-success"><?php echo $success_msg; ?></div>
        </div>
    <?php }?>
    <?php if (!empty($error_msg)) {?>
        <div class="col-xs-12">
            <div class="alert alert-danger"><?php echo $error_msg; ?></div>
        </div>
    <?php }?>
    <div class="container-fluid">
        <div class="row mb-3">
            <div class="col-sm-6">
                <h1 class="h3 text-gray-800">Escrow Production</h1>
            </div>
            <div class="col-sm-6">
                <a href="<?php echo site_url('order/admin/escrow-production'); ?>" class="btn btn-info btn-icon-split float-right mr-2">
                    <span class="icon text-white-50">
                        <i class="fas fa-arrow-left"></i>
                    </span>
                    <span class="text"> Back </span>
                </a>
            </div>
        </div>
        <div class="row">
                <div class="col-md-12">
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Add Escrow Production</h6>
                        </div>
                        <div class="card-body">
                            <form id="frm-add-escrow-production" method="POST">

                                <div class="form-group">
                                    <label for="title_officer_name" class="col-sm-2 col-form-label">First Name<span class="required"> *</span></label>
                                    <div class="col-sm-6">
                                        <input type="text" class="form-control" name="first_name" id="first_name" class="form-control" placeholder="First Name">
                                        <?php if (!empty($first_name_error_msg)) {?>
                                            <span class="error"><?php echo $first_name_error_msg; ?></span>
                                        <?php }?>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="title_officer_name" class="col-sm-2 col-form-label">Last Name<span class="required"> *</span></label>
                                    <div class="col-sm-6">
                                        <input type="text" class="form-control" name="last_name" id="last_name" class="form-control" placeholder="Last Name">
                                        <?php if (!empty($last_name_error_msg)) {?>
                                            <span class="error"><?php echo $last_name_error_msg; ?></span>
                                        <?php }?>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="email_address" class="col-sm-2 col-form-label">Email Address<span class="required"> *</span></label>
                                    <div class="col-sm-6">
                                        <input type="text" class="form-control" name="email_address" id="email_address" class="form-control" placeholder="Email Address">
                                        <?php if (!empty($email_error_msg)) {?>
                                            <span class="error"><?php echo $email_error_msg; ?></span>
                                        <?php }?>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="telephone" class="col-sm-2 col-form-label">Phone Number</label>
                                    <div class="col-sm-6">
                                        <input type="text" class="form-control" name="telephone" id="telephone" class="form-control" placeholder="Phone Number">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-sm-6">
                                        <button type="submit" id="add-escrow-production" name="add-escrow-production" class="btn btn-info btn-icon-split">
                                            <span class="icon text-white-50">
                                                <i class="fas fa-save"></i>
                                            </span>
                                            <span class="text">Add</span>
                                        </button>
                                        <!-- <button type="submit" class="btn btn-secondary">Update</button> -->
                                        <a href="<?php echo site_url('order/admin/softpro-escrow-production'); ?>" class="btn btn-secondary btn-icon-split">
                                            <span class="icon text-white-50">
                                                <i class="fas fa-arrow-left"></i>
                                            </span>
                                            <span class="text">Cancel</span>
                                        </a>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
            </div>
        </div>
    </div>
</div>