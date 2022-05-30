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
      <div class="card-header">Add Underwriter Tier</div>
        <div class="card-body">        
            <form id="frm-add-commission-range" method="POST" >


			<div class="form-group row">
				<label for="zipcode" class="col-sm-4 col-form-label">Product Type<span class="required"> *</span></label>
				<div class="col-sm-8">
					<select name="product_type"  class="selectpicker" data-actions-box="true" required>
						<option value="">Select Product Type</option>
						<?php foreach($product_types as $product_type) {?>
							<?php $selected = '';
								if(set_value('product_type') && ($product_type == set_value('product_type')))  {
									$selected = 'selected';
								} 
							?> 
							<option <?php echo $selected;?> value="<?php echo $product_type;?>"><?php echo ucwords($product_type);?></option>
						<?php }?>
					</select>
					<?php if(!empty(form_error('product_type'))){ ?>                     
						<span class="error"><?php echo form_error('product_type'); ?></span>
					<?php } ?>
				</div>
			</div>

			

			<div class="form-group row">
				<label for="zipcode" class="col-sm-4 col-form-label">Underwriter<span class="required"> *</span></label>
				<div class="col-sm-8">
					<select name="underwriter_type"  class="selectpicker" data-actions-box="true" required>
						<option value="">Select Underwriter</option>
						<?php foreach($underwriter_types as $key=>$underwriter_type) {?>
							<?php $selected = '';
								if(set_value('underwriter_type') && ($key== set_value('underwriter_type')))  {
									$selected = 'selected';
								} 
							?> 
							<option <?php echo $selected;?> value="<?php echo $key;?>"><?php echo ucwords($key); ?></option>
						<?php }?>
					</select>
					<?php if(!empty(form_error('underwriter_type'))){ ?>                     
						<span class="error"><?php echo form_error('underwriter_type'); ?></span>
					<?php } ?>
				</div>
			</div>

			<div class="form-group row">
				<label for="title" class="col-sm-4 col-form-label">Title<span class="required"> *</span></label>
				<div class="col-sm-8">
					<input type="text"  name="title" id="title" class="form-control" placeholder="Enter Tier title" value="<?php echo set_value('title');?>" required>
					<?php if(!empty(form_error('title'))){ ?>                     
						<span class="error"><?php echo form_error('title'); ?></span>
					<?php } ?>
				</div>
			</div>

			<div class="form-group row">
				<label for="description" class="col-sm-4 col-form-label">Description</label>
				<div class="col-sm-8">
					<textarea class="form-control" name="description" id="description" placeholder="Enter Description"><?php echo set_value('description');?></textarea>
				</div>
			</div>

			<div class="pull-right">
				<button type="submit" class="btn btn-secondary">Add</button>
				<a href="<?php echo site_url('order/admin/underwriter-tier'); ?>" class="btn btn-secondary">Cancel</a>
			</div>
				
            </form>
        </div>
    </div>
</div>
