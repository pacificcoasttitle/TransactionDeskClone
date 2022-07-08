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
      <div class="card-header">Edit Commission configuartio</div>
        <div class="card-body">        
            <form  method="POST" >

			

			<div class="form-group row">
				<label for="title" class="col-sm-4 col-form-label">Title<span class="required"> *</span></label>
				<div class="col-sm-8">
					<input type="text"  name="title" id="title" class="form-control" placeholder="Enter title" value="<?php echo set_value('title',$record->title);?>" required>
					<?php if(!empty(form_error('title'))){ ?>                     
						<span class="error"><?php echo form_error('title'); ?></span>
					<?php } ?>
				</div>
			</div>

			<div class="form-group row">
				<label for="value" class="col-sm-4 col-form-label">Commission %</label>
				<div class="col-sm-8">
				<input  step=".01" min="0"  type="number" class="form-control" name="commission" id="commission" class="form-control" placeholder="Enter Commission %" value="<?php echo set_value('commission',$record->value)?>">
				<?php if(!empty(form_error('commission'))){ ?>                     
					<span class="error"><?php echo form_error('commission'); ?></span>
				<?php } ?>
				</div>
			</div>

			<div class="pull-right">
				<button type="submit" class="btn btn-secondary">Update</button>
				<a href="<?php echo site_url('order/admin/commission-config'); ?>" class="btn btn-secondary">Cancel</a>
			</div>
				
            </form>
        </div>
    </div>
</div>
