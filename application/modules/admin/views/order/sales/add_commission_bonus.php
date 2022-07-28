<style>
.bootstrap-select:not([class*="col-"]):not([class*="form-control"]):not(.input-group-btn) {
    width: -webkit-fill-available;
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
      <div class="card-header">Add Bonus Range</div>
        <div class="card-body">        
            <form id="frm-add-bonus-range" method="POST" >


			<div class="form-group row">
				<label for="revenue_range" class="col-sm-4 col-form-label">From Revenue</label>
				<div class="col-sm-8">
					<input  step="1" min="0"  type="number" class="form-control" name="revenue_range_min" id="revenue_range_min" class="form-control" placeholder="From revenue" value="<?php echo set_value('revenue_range_min') ?>">
					<?php if(!empty(form_error('revenue_range_min'))){ ?>                     
						<span class="error"><?php echo form_error('revenue_range_min'); ?></span>
					<?php } ?>
				</div>
				
				
			</div>

			<div class="form-group row">
				<label for="bonus_amount" class="col-sm-4 col-form-label">Bonus</label>
				<div class="col-sm-8">
					<input  step="1" min="0"  type="number" class="form-control" name="bonus_amount" id="bonus_amount" class="form-control" placeholder="Enter Bonus Amout" value="<?php echo set_value('bonus_amount') ?>">
					<?php if(!empty(form_error('bonus_amount'))){ ?>                     
						<span class="error"><?php echo form_error('bonus_amount'); ?></span>
					<?php } ?>
				</div>
				
				
			</div>
			

			<div class="pull-right">
				<button type="submit" class="btn btn-secondary">Add</button>
				<a href="<?php echo site_url('order/admin/commission-bonus'); ?>" class="btn btn-secondary">Cancel</a>
			</div>
				
            </form>
        </div>
    </div>
</div>
