<div class="container">
    <?php if(!empty($success_msg)){ ?>
        <div class="col-xs-12">
            <div class="alert alert-success"><?php echo $success_msg; ?></div>
        </div>
    <?php } ?>
    <?php if(!empty($error_msg)){ ?>
        <div class="col-xs-12">
            <div class="alert alert-danger"><?php echo $error_msg; ?></div>
        </div>
    <?php } ?>
    <div class="card mx-auto mt-5">
      <div class="card-header">Add Sales Rep</div>
        <div class="card-body">        
            <form id="frm-add-sales-rep" method="POST">
        
                <div class="form-group row">
                    <label for="sales_rep_name" class="col-sm-2 col-form-label">Name<span class="required"> *</span></label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" name="sales_rep_name" id="sales_rep_name" class="form-control" placeholder="Sales Rep. Name">
                        <?php if(!empty($name_error_msg)){ ?>                     
                            <span class="error"><?php echo $name_error_msg; ?></span>
                        <?php } ?>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="email_address" class="col-sm-2 col-form-label">Email Address<span class="required"> *</span></label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" name="email_address" id="email_address" class="form-control" placeholder="Email Address">
                        <?php if(!empty($email_error_msg)){ ?>                     
                            <span class="error"><?php echo $email_error_msg; ?></span>
                        <?php } ?>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="telephone" class="col-sm-2 col-form-label">Phone Number<span class="required"> *</span></label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" name="telephone" id="telephone" class="form-control" placeholder="Phone Number">
                        <?php if(!empty($phone_error_msg)){ ?>                     
                            <span class="error"><?php echo $phone_error_msg; ?></span>
                        <?php } ?>
                    </div>
                </div>
                
                <div class="pull-right">
                    <button type="submit" id="add-sales-rep" name="add-sales-rep" class="btn btn-secondary">Add</button>
                    <a href="<?php echo site_url('order/admin/sales-rep'); ?>" id="cancel" name="cancel" class="btn btn-secondary">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</div>