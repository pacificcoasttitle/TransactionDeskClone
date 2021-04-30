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
      <div class="card-header">Add Fee Type</div>
        <div class="card-body">        
            <form id="frm-add-fee-type" method="POST">
                <div class="form-group row">
                    <label for="fee_type" class="col-sm-2 col-form-label">Fee Type<span class="required"> *</span></label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" name="fee_type" id="fee_type" class="form-control" placeholder="Fee Type">

                        <?php if(!empty($name_error_msg)){ ?>                     
                            <span class="error"><?php echo $name_error_msg; ?></span>
                        <?php } ?>
                    </div>
                </div>

                <div class="pull-right">
                    <button type="submit" id="addFeeType" name="addFeeType" class="btn btn-secondary">Add</button>
                    <a href="<?php echo base_url().'order/admin/fees-types'; ?>" id="cancel" name="cancel" class="btn btn-secondary">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</div>