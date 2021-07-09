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
      <div class="card-header">Add Holiday</div>
        <div class="card-body">        
            <form id="frm-add-holiday" method="POST">
                <div class="form-group row">
                    <label for="holiday_name" class="col-sm-2 col-form-label">Holiday Name<span class="required"> *</span></label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" name="holiday_name" id="holiday_name" class="form-control" placeholder="Holiday Name">
                        <?php if(!empty($holiday_name_error_msg)){ ?>                     
                            <span class="error"><?php echo $holiday_name_error_msg; ?></span>
                        <?php } ?>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="holiday_date" class="col-sm-2 col-form-label">Holiday Date<span class="required"> *</span></label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" name="holiday_date" id="holiday_date" class="form-control" placeholder="Holiday Date">
                        <?php if(!empty($holiday_date_error_msg)){ ?>                     
                            <span class="error"><?php echo $holiday_date_error_msg; ?></span>
                        <?php } ?>
                    </div>
                </div>
                
                <div class="pull-right">
                    <button type="submit" id="addFee" name="addHoliday" class="btn btn-secondary">Add</button>
                    <a href="<?php echo base_url().'order/admin/holidays'; ?>" id="cancel" name="cancel" class="btn btn-secondary">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</div>

<script type="text/javascript">
    $(document).ready(function () {
        $('#holiday_date').datepicker().datepicker("setDate", new Date());
    });
</script>

