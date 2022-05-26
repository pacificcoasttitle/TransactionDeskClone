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
      <div class="card-header">Edit Commission Range</div>
        <div class="card-body">        
            <form id="frm-add-commission-range" method="POST" >

			<div class="form-group row">
				<label for="zipcode" class="col-sm-4 col-form-label">Product Type</label>
				<div class="col-sm-8">
					<select name="product_type"  class="selectpicker" data-actions-box="true">
						<option value="">Select Product Type</option>
						<?php foreach($product_types as $product_type) {?>
							<?php $selected = '';
								if( ($product_type == set_value('product_type',$record->product_type)))  {
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
				<label for="zipcode" class="col-sm-4 col-form-label">Underwriter Tier</label>
				<div class="col-sm-8">
					<select name="underwriter_tier"  class="selectpicker" data-actions-box="true">
						<option value="">Select Underwriter Tiers</option>
						<?php $last_label = ''; ?>
						<?php foreach($underwriter_tiers as $underwriter_tier) {?>
							<?php if($last_label == '') : ?>
							<optgroup label="<?php echo ucwords( $underwriter_tier->underwriter); ?>">
							<?php
							elseif ($last_label != $underwriter_tier->underwriter) : ?>
							</optgroup>
							<optgroup label="<?php echo ucwords($underwriter_tier->underwriter); ?>">
							<?php 
							endif;
							$last_label = $underwriter_tier->underwriter; 
							?>
							
							<?php $selected = '';
								if(($underwriter_tier->id == set_value('underwriter_tier',$record->underwriter_tier)))  {
									$selected = 'selected';
								} 
							?> 
							<option <?php echo $selected;?> value="<?php echo $underwriter_tier->id;?>"><?php echo $underwriter_tier->title;?></option>
							
						<?php }?>
						<?php if($last_label != '') : ?>
							</optgroup>
						<?php endif; ?>
					</select>
					<?php if(!empty(form_error('underwriter_tier'))){ ?>                     
						<span class="error"><?php echo form_error('underwriter_tier'); ?></span>
					<?php } ?>
				</div>
			</div>

			<div class="form-group row">
				<label for="revenue_range" class="col-sm-4 col-form-label">Revenue Range </label>
				<div class="col-sm-4">
					<input  step="1" min="0"  type="number" class="form-control" name="revenue_range_min" id="revenue_range_min" class="form-control" placeholder="Minumum Value" value="<?php echo set_value('revenue_range_min',$record->min_revenue) ?>">
					<?php if(!empty(form_error('revenue_range_min'))){ ?>                     
						<span class="error"><?php echo form_error('revenue_range_min'); ?></span>
					<?php } ?>
				</div>
				
				<div class="col-sm-4">
					<input  step="1" min="0"  type="number" class="form-control" name="revenue_range_max" id="revenue_range_max" class="form-control" placeholder="Maximum Value" value="<?php echo set_value('revenue_range_max',$record->max_revenue)?>">
					<?php if(!empty(form_error('revenue_range_max'))){ ?>                     
						<span class="error"><?php echo form_error('revenue_range_max'); ?></span>
					<?php } ?>
				</div>
			</div>

			<div class="form-group row">
				<label for="total_commission" class="col-sm-4 col-form-label">Total Commission %</label>
				<div class="col-sm-8">
				<input  step=".01" min="0"  type="number" class="form-control" name="total_commission" id="total_commission" class="form-control" placeholder="Enter Total Commission" value="<?php echo set_value('total_commission',$record->total_commission)?>">
				<?php if(!empty(form_error('total_commission'))){ ?>                     
					<span class="error"><?php echo form_error('total_commission'); ?></span>
				<?php } ?>
				</div>
			</div>

			<div class="form-group row"style="display: none !important;">
				<label for="additional_threshold" class="col-sm-4 col-form-label">Additional Threshold Amount</label>
				<div class="col-sm-8">
				<input  step=".01" min="0"  type="number" class="form-control" name="additional_threshold" id="additional_threshold" class="form-control" placeholder="Enter Additional Threshold Amount" value="<?php echo set_value('additional_threshold',$record->additional_threshold)?>">
				<?php if(!empty(form_error('additional_threshold'))){ ?>                     
					<span class="error"><?php echo form_error('additional_threshold'); ?></span>
				<?php } ?>
				</div>
			</div>

					<div class="pull-right">
						<button type="submit"  class="btn btn-secondary">Update</button>
						<a href="<?php echo site_url('order/admin/commission-range'); ?>"class="btn btn-secondary">Cancel</a>
					</div>
				
            </form>
        </div>
    </div>
</div>

