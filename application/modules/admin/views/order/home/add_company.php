
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
      <div class="card-header">Add Company</div>
        <div class="card-body">        
            <form id="add-new-user" method="POST">
                <div class="form-group row">
                    <label for="resware_company_id" class="col-sm-4 col-form-label">Resware Partner Company Id<span class="required"> *</span></label>
                    <div class="col-sm-8">
                        <input type="number" class="form-control" name="resware_company_id" id="resware_company_id" value="<?php echo set_value('resware_company_id')?>" class="form-control" placeholder="Resware Partner Company Id">
                        <?php if(!empty($resware_company_id_error_msg)){ ?>                     
                            <span class="error"><?php echo $resware_company_id_error_msg; ?></span>
                        <?php } ?>
                    </div>
                </div>

                <div class="pull-right">
                    <button type="submit" class="btn btn-secondary">Add</button>
                    <a href="<?php echo base_url().'order/admin/companies'; ?>" id="cancel" name="cancel" class="btn btn-secondary">Cancel</a>
                </div>      
            </form>
        </div>
    </div>
</div>


