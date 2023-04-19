<style>
.hide {
    display: none;
} 
</style>
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
      <div class="card-header">Edit LP Alert</div>
        <div class="card-body">        
            <form id="frm-edit-alert" method="POST">
                <div class="form-group row">
                    <label for="days" class="col-sm-4 col-form-label">Days<span class="required"> *</span></label>
                    <div class="col-sm-8">
                        <input type="text" class="form-control" name="days" id="days" class="form-control" placeholder="Doc Type" value="<?php echo isset($lp_alert['days']) && !empty($lp_alert['days']) ? $lp_alert['days']: ''; ?>">
                        <?php if(!empty($days_error_msg)){ ?>                     
                            <span class="error"><?php echo $days_error_msg; ?></span>
                        <?php } ?>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="color_code" class="col-sm-4 col-form-label">Color Code<span class="required">*</span></label>
                    <div class="col-sm-2">
                        <input type="color" class="form-control" name="color_code" id="color_code"  class="form-control" value="<?php echo isset($lp_alert['color_code']) && !empty($lp_alert['color_code']) ? $lp_alert['color_code']: ''; ?>" style="width: 40%; border-radious:50;">
                    </div>
                </div>
                
                <div class="form-group row">
                    <label for="text_color" class="col-sm-4 col-form-label">Text Color<span class="required">*</span></label>
                    <div class="col-sm-2">
                        <input type="color" class="form-control" name="text_color" id="text_color"  class="form-control" value="<?php echo isset($lp_alert['text_color']) && !empty($lp_alert['text_color']) ? $lp_alert['text_color']: ''; ?>" style="width: 40%; border-radious:50;">
                    </div>
                </div>

                <div class="form-group row">
                    <label for="delete" class="col-sm-4 col-form-label">Is_ Notice</label>
                    <div class="col-sm-4">
                        <input type="checkbox" value="1" class="form-control" style="width: 20px;"  name="delete" id="delete" class="form-control" <?php echo isset($lp_alert['delete']) && !empty($lp_alert['delete']) ? 'Checked' : ''; ?>>
                    </div>
                </div>               
                
                <div class="pull-right">
                    <button type="submit" id="add-sales-rep" name="add-sales-rep" class="btn btn-secondary">Update</button>
                    <a href="<?php echo site_url('order/admin/lp-alert'); ?>" id="cancel" name="cancel" class="btn btn-secondary">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</div>
<script src="<?php echo base_url(); ?>assets/vendor/jquery/jquery.min.js"></script>
<script src="<?php echo base_url(); ?>assets/admin/js/jquery.validate.min.js"></script>
<script type="text/javascript">
    $(document).ready(function () {
        if(jQuery('#frm-edit-alert').length)
        {
           jQuery('#frm-edit-alert').validate({
                ignore:":not(:visible)",
                rules: {
                    days:"required"
                },
                messages: {
                    days:"Please Enter Days"
                },
                submitHandler: function(form) {
                    form.submit();  
                }
            }); 
        }
    });
</script>