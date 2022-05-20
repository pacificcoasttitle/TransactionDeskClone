<style>
.dataTables_length {
    width: 250px !important;
    float: left;
}
</style>
<div class="container-fluid">
    <div class="card mb-3">
        <div class="card-header">
            <i class="fas fa-table"></i>
            Sales Rep
            <div class="float-right">
                <a href="<?php echo base_url('order/admin/add-commission-range')?>" class="btn btn-secondary">Add Commission Range</a>
            </div>
        </div>
     
        <div class="card-body">
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
            <div class="table-responsive">
                <table class="table table-bordered cusom__common__datatable" id="tbl-commission-range-listing" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Product Type</th>
                            <th>Underwriter Tier</th>
                            <th>Minimum Revenue</th>
                            <th>Maximum Revenue</th>
                            <th>Total Commission</th>
                            <th>Additional Threshold</th>
                            <th>Action</th>
                        </tr>
						
                    </thead>                
                    <tbody>
					<?php foreach($commission_details as $commission_record): ?>
						<tr>
							<td><?php echo ucfirst($commission_record->product_type); ?></td>
							<td><?php echo ($commission_record->underwriter_tier_obj) ? $commission_record->underwriter_tier_obj->title : '-' ?></td>
							<td><?php echo $commission_record->min_revenue; ?></td>
							<td><?php echo $commission_record->max_revenue; ?></td>
							<td><?php echo $commission_record->total_commission; ?> %</td>
							<td><?php echo $commission_record->additional_threshold; ?></td>
							<td> <a href="<?php echo base_url('order/admin/edit-commission-range/'.$commission_record->id)?>" class='btn btn-action 'title ='Edit Commission Range'><span class='fa fa-edit' aria-hidden='true'></span></a>
								<button type="button"  class='btn btn-action delete-record-custom' data-url="<?php echo base_url('order/admin/delete-commission-range/'.$commission_record->id)?>" title ='Delete Commission Range'><span class='fa fa-trash' aria-hidden='true'></span></button>
							</td>
						</tr>
						<?php endforeach;?>
					</tbody>
                </table>
            </div>
        </div>
    </div>
</div>
