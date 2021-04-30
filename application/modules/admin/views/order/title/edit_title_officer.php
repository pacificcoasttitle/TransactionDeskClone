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
      <div class="card-header">Edit Title Officer</div>
        <div class="card-body">        
            <form id="frm-add-title-officer-rep" method="POST">
        
                <div class="form-group row">
                    <label for="title_officer_name" class="col-sm-2 col-form-label">Name<span class="required"> *</span></label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" name="title_officer_name" id="title_officer_name" class="form-control" placeholder="Title Officer Name" value="<?php echo isset($title_officer_info['name']) && !empty($title_officer_info['name']) ? $title_officer_info['name'] : ''?>">
                        <?php if(!empty($name_error_msg)){ ?>                     
                            <span class="error"><?php echo $name_error_msg; ?></span>
                        <?php } ?>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="email_address" class="col-sm-2 col-form-label">Email Address<span class="required"> *</span></label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" name="email_address" id="email_address" class="form-control" placeholder="Email Address" value="<?php echo isset($title_officer_info['email_address']) && !empty($title_officer_info['email_address']) ? $title_officer_info['email_address'] : ''?>">
                        <?php if(!empty($email_error_msg)){ ?>                     
                            <span class="error"><?php echo $email_error_msg; ?></span>
                        <?php } ?>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="telephone" class="col-sm-2 col-form-label">Phone Number<span class="required"> *</span></label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" name="telephone" id="telephone" class="form-control" placeholder="Phone Number" value="<?php echo isset($title_officer_info['phone']) && !empty($title_officer_info['phone']) ? $title_officer_info['phone'] : ''?>">
                        <?php if(!empty($phone_error_msg)){ ?>                     
                            <span class="error"><?php echo $phone_error_msg; ?></span>
                        <?php } ?>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="partner_id" class="col-sm-2 col-form-label">Partner Id<span class="required"> *</span></label>
                    <div class="col-sm-10">
                        <input type="number" class="form-control" name="partner_id" id="partner_id" class="form-control" placeholder="Partner Id" value="<?php echo isset($title_officer_info['partner_id']) && !empty($title_officer_info['partner_id']) ? $title_officer_info['partner_id'] : ''?>">
                        <?php if(!empty($partner_id_error_msg)){ ?>                     
                            <span class="error"><?php echo $partner_id_error_msg; ?></span>
                        <?php } ?>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="partner_type_id" class="col-sm-2 col-form-label">Partner Type Id<span class="required"> *</span></label>
                    <div class="col-sm-10">
                        <input type="number" class="form-control" name="partner_type_id" id="partner_type_id" class="form-control" placeholder="Partner Type Id" value="<?php echo isset($title_officer_info['partner_type_id']) && !empty($title_officer_info['partner_type_id']) ? $title_officer_info['partner_type_id'] : ''?>">
                        <?php if(!empty($partner_type_id_error_msg)){ ?>                     
                            <span class="error"><?php echo $partner_type_id_error_msg; ?></span>
                        <?php } ?>
                    </div>
                </div>

                
                <div class="pull-right">
                    <button type="submit" id="edit-title-officer" name="add-title-officer" class="btn btn-secondary">Edit</button>
                    <a href="<?php echo site_url('order/admin/title-officers'); ?>" id="cancel" name="cancel" class="btn btn-secondary">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</div>