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
      <div class="card-header">Edit Sales Rep</div>
        <div class="card-body">        
            <form id="frm-add-sales-rep" method="POST">
        
                <div class="form-group row">
                    <label for="sales_rep_name" class="col-sm-2 col-form-label">Name<span class="required"> *</span></label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" name="sales_rep_name" id="sales_rep_name" class="form-control" placeholder="Sales Rep. Name" value="<?php echo isset($sales_rep_info['name']) && !empty($sales_rep_info['name']) ? $sales_rep_info['name'] : ''?>">
                        <?php if(!empty($name_error_msg)){ ?>                     
                            <span class="error"><?php echo $name_error_msg; ?></span>
                        <?php } ?>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="email_address" class="col-sm-2 col-form-label">Email Address<span class="required"> *</span></label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" name="email_address" id="email_address" class="form-control" placeholder="Email Address" value="<?php echo isset($sales_rep_info['email_address']) && !empty($sales_rep_info['email_address']) ? $sales_rep_info['email_address'] : ''?>">
                        <?php if(!empty($email_error_msg)){ ?>                     
                            <span class="error"><?php echo $email_error_msg; ?></span>
                        <?php } ?>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="telephone" class="col-sm-2 col-form-label">Phone Number<span class="required"> *</span></label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" name="telephone" id="telephone" class="form-control" placeholder="Phone Number" value="<?php echo isset($sales_rep_info['telephone']) && !empty($sales_rep_info['telephone']) ? $sales_rep_info['telephone'] : ''?>">
                        <?php if(!empty($phone_error_msg)){ ?>                     
                            <span class="error"><?php echo $phone_error_msg; ?></span>
                        <?php } ?>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="partner_id" class="col-sm-2 col-form-label">Partner Id<span class="required"> *</span></label>
                    <div class="col-sm-10">
                        <input type="number" class="form-control" name="partner_id" id="partner_id" class="form-control" placeholder="Partner Id" value="<?php echo isset($sales_rep_info['partner_id']) && !empty($sales_rep_info['partner_id']) ? $sales_rep_info['partner_id'] : ''?>">
                        <?php if(!empty($partner_id_error_msg)){ ?>                     
                            <span class="error"><?php echo $partner_id_error_msg; ?></span>
                        <?php } ?>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="partner_type_id" class="col-sm-2 col-form-label">Partner Type Id<span class="required"> *</span></label>
                    <div class="col-sm-10">
                        <input type="number" class="form-control" name="partner_type_id" id="partner_type_id" class="form-control" placeholder="Partner Type Id" value="<?php echo isset($sales_rep_info['partner_type_id']) && !empty($sales_rep_info['partner_type_id']) ? $sales_rep_info['partner_type_id'] : ''?>">
                        <?php if(!empty($partner_type_id_error_msg)){ ?>                     
                            <span class="error"><?php echo $partner_type_id_error_msg; ?></span>
                        <?php } ?>
                    </div>
                </div>

                
                <div class="form-group row">
                    <label for="telephone" class="col-sm-2 col-form-label">&nbsp;</label>
                    <div class="col-sm-10">
                        <input type="checkbox" <?php echo ($sales_rep_info['is_mail_notification'] == 1) ?  'checked' : ''?> class="" style="height:18px;width:18px;margin-right:10px;" name="is_mail_notification" id="is_mail_notification" class="form-control" placeholder="Mail Notification">Mail Notification
                    </div>
                </div>
                
                <div class="pull-right">
                    <button type="submit" id="edit-sales-rep" name="add-sales-rep" class="btn btn-secondary">Edit</button>
                    <a href="<?php echo site_url('order/admin/sales-rep'); ?>" id="cancel" name="cancel" class="btn btn-secondary">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</div>