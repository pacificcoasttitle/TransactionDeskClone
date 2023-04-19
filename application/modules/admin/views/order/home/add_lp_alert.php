<style>
.ui-menu .ui-menu-item-wrapper {
    font-size : 13px;
}

.ui-autocomplete {
    max-height: 300px !important;
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
      <div class="card-header">Add New LP Alert</div>
        <div class="card-body">        
            <form id="add-alert" method="POST">

                <div class="form-group row">
                    <label for="days" class="col-sm-4 col-form-label">Days<span class="required"> *</span></label>
                    <div class="col-sm-8">
                        <input type="text" class="form-control" name="days" id="days" value="<?php echo set_value('days')?>" class="form-control" placeholder="Days">
                        <?php if(!empty($days_error_msg)){ ?>                     
                            <span class="error"><?php echo $days_error_msg; ?></span>
                        <?php } ?>
                    </div>
                </div>
                
                <div class="form-group row">
                    <label for="color_code" class="col-sm-4 col-form-label">Color Code</label>
                    <div class="col-sm-2">
                        <input type="color" class="form-control" name="color_code" id="color_code" value="#FFFFFF" class="form-control" placeholder="Color Code" style="width: 40%;" >
                    </div>
                </div>

                <div class="form-group row">
                    <label for="text_color" class="col-sm-4 col-form-label">Text Color</label>
                    <div class="col-sm-2">
                        <input type="color" class="form-control" name="text_color" id="text_color" value="#FFFFFF" class="form-control" placeholder="Text Code" style="width: 40%;" >
                    </div>
                </div>
                
                <div class="form-group row">
                    <label for="delete" class="col-sm-4 col-form-label">Delete</label>
                    <div class="col-sm-2">
                        <input type="checkbox" value="1" class="form-control" style="width: 20px;"  name="delete" id="delete" class="form-control">
                    </div>
                </div>
                <div class="pull-right">
                    <button type="submit" class="btn btn-secondary">Add</button>
                    <a href="<?php echo base_url().'order/admin/lp-alert'; ?>" id="cancel" name="cancel" class="btn btn-secondary">Cancel</a>
                </div>      
            </form>
        </div>
    </div>
</div>

<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/frontend/css/smart-forms.css">
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/frontend/css/jquery-ui.css">


<script src="<?php echo base_url(); ?>assets/libs/jquery-1.12.4.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/frontend/js/jquery-ui.min.js"></script>

<script type="text/javascript">
</script>
