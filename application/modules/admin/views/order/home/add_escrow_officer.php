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
      <div class="card-header">Add Escrow Officer</div>
        <div class="card-body">        
            <form id="frm-add-escrow-officer" method="POST" enctype="multipart/form-data">
        
                <div class="form-group row">
                    <label for="partner_id" class="col-sm-2 col-form-label">Partner ID<span class="required"> *</span></label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" name="partner_id" id="partner_id" class="form-control" placeholder="Enter Partner ID" value="">
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
                    <label for="sales_rep_last_name" class="col-sm-2 col-form-label">Partner Name<span class="required"> *</span></label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" name="partner_name" id="partner_name" class="form-control" placeholder="Enter Partner Name" value="">
                        <?php if(!empty($partner_name_error_msg)){ ?>                     
                            <span class="error"><?php echo $partner_name_error_msg; ?></span>
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
                    <label for="address" class="col-sm-2 col-form-label">Address<span class="required"> *</span></label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" name="address" id="address" class="form-control" placeholder="Enter Address">
                        <?php if(!empty($address_error_msg)){ ?>                     
                            <span class="error"><?php echo $address_error_msg; ?></span>
                        <?php } ?>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="city" class="col-sm-2 col-form-label">City<span class="required"> *</span></label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" name="city" id="city" class="form-control" placeholder="Enter City">
                        <?php if(!empty($city_error_msg)){ ?>                     
                            <span class="error"><?php echo $city_error_msg; ?></span>
                        <?php } ?>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="state" class="col-sm-2 col-form-label">State<span class="required"> *</span></label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" name="state" id="state" class="form-control" placeholder="Enter State">
                        <?php if(!empty($state_error_msg)){ ?>                     
                            <span class="error"><?php echo $state_error_msg; ?></span>
                        <?php } ?>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="zip" class="col-sm-2 col-form-label">Zip<span class="required"> *</span></label>
                    <div class="col-sm-10">
                        <input type="number" class="form-control" name="zip" id="zip" class="form-control" placeholder="Enter Zip">
                        <?php if(!empty($zip_error_msg)){ ?>                     
                            <span class="error"><?php echo $zip_error_msg; ?></span>
                        <?php } ?>
                    </div>
                </div>                
                
                <div class="pull-right">
                    <button type="submit" id="add-sales-rep" name="add-sales-rep" class="btn btn-secondary">Add</button>
                    <a href="<?php echo site_url('order/admin/escrow-officers'); ?>" id="cancel" name="cancel" class="btn btn-secondary">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</div>
<script src="<?php echo base_url(); ?>assets/vendor/jquery/jquery.min.js"></script>
<script src="<?php echo base_url(); ?>assets/admin/js/jquery.validate.min.js"></script>
<script type="text/javascript">
    $(document).ready(function () {
        if(jQuery('#frm-add-escrow-officer').length)
        {
           jQuery('#frm-add-escrow-officer').validate({
                ignore:":not(:visible)",
                rules: {
                    partner_name:"required",
                    address:"required",
                    email_address:"required",
                    city:"required",
                    partner_id:"required",
                    state:"required",
                    zip:"required",
                    partner_type_id:"required"
                },
                messages: {
                    partner_name:"Please Enter Partner Name",
                    address:"Please Enter Address",
                    email_address:"Please Enter Email address",
                    city:"Please Enter City",
                    partner_id:"Please Enter Partner Id",
                    partner_type_id:"Please Enter Partner Type Id",
                    state:"Please Enter State",
                    zip: "Please Enter Zip",
                },
                submitHandler: function(form) {
                    form.submit();  
                }
            }); 
        }
    });
</script>