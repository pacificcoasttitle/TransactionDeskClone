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
            <form id="frm-add-sales-rep" method="POST" enctype="multipart/form-data">
        
                <div class="form-group row">
                    <label for="sales_rep_first_name" class="col-sm-2 col-form-label">First Name<span class="required"> *</span></label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" name="sales_rep_first_name" id="sales_rep_first_name" class="form-control" placeholder="Enter Sales Rep. First Name" value="<?php echo isset($sales_rep_info['first_name']) && !empty($sales_rep_info['first_name']) ? $sales_rep_info['first_name'] : ''?>">
                        <?php if(!empty($first_name_error_msg)){ ?>                     
                            <span class="error"><?php echo $first_name_error_msg; ?></span>
                        <?php } ?>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="sales_rep_last_name" class="col-sm-2 col-form-label">Last Name<span class="required"> *</span></label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" name="sales_rep_last_name" id="sales_rep_last_name" class="form-control" placeholder="Enter Sales Rep. Last Name" value="<?php echo isset($sales_rep_info['last_name']) && !empty($sales_rep_info['last_name']) ? $sales_rep_info['last_name'] : ''?>">
                        <?php if(!empty($last_name_error_msg)){ ?>                     
                            <span class="error"><?php echo $last_name_error_msg; ?></span>
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

                <div class="form-group row">
                    <label for="partner_id" class="col-sm-2 col-form-label">Partner Id<span class="required"> *</span></label>
                    <div class="col-sm-10">
                        <input type="number" class="form-control" name="partner_id" id="partner_id" class="form-control" placeholder="Partner Id">
                        <?php if(!empty($partner_id_error_msg)){ ?>                     
                            <span class="error"><?php echo $partner_id_error_msg; ?></span>
                        <?php } ?>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="partner_type_id" class="col-sm-2 col-form-label">Partner Type Id<span class="required"> *</span></label>
                    <div class="col-sm-10">
                        <input type="number" class="form-control" name="partner_type_id" id="partner_type_id" class="form-control" placeholder="Partner Type Id">
                        <?php if(!empty($partner_type_id_error_msg)){ ?>                     
                            <span class="error"><?php echo $partner_type_id_error_msg; ?></span>
                        <?php } ?>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="sales_rep_profile_img" class="col-sm-2 col-form-label">Profile Img</label>
                    <div class="col-sm-10">
                        <input type="file" class="form-control" name="sales_rep_profile_img" id="sales_rep_profile_img" accept=".png,.jpg" class="form-control">
                        <?php if(!empty($sales_rep_profile_img_error_msg)){ ?>                     
                            <span class="error"><?php echo $sales_rep_profile_img_error_msg; ?></span>
                        <?php } ?>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="telephone" class="col-sm-2 col-form-label">&nbsp;</label>
                    <div class="col-sm-10">
                        <input type="checkbox" class="" style="height:18px;width:18px;margin-right:10px;" name="is_mail_notification" id="is_mail_notification" class="form-control" placeholder="Mail Notification">Mail Notification
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
<script src="<?php echo base_url(); ?>assets/vendor/jquery/jquery.min.js"></script>
<script src="<?php echo base_url(); ?>assets/admin/js/jquery.validate.min.js"></script>
<script type="text/javascript">
    $(document).ready(function () {
        if(jQuery('#frm-add-sales-rep').length)
        {
           jQuery('#frm-add-sales-rep').validate({
                ignore:":not(:visible)",
                rules: {
                    sales_rep_first_name:"required",
                    sales_rep_last_name:"required",
                    email_address:"required",
                    telephone:"required",
                    partner_id:"required",
                    partner_type_id:"required"
                },
                messages: {
                    sales_rep_first_name:"Please Enter First Name",
                    sales_rep_last_name:"Please Enter Last Name",
                    email_address:"Please Enter Email address",
                    telephone:"Please Enter Phone Number",
                    partner_id:"Please Enter Partner Id",
                    partner_type_id:"Please Enter Partner Type Id",
                },
                submitHandler: function(form) {
                    form.submit();  
                }
            }); 
        }
    });
</script>