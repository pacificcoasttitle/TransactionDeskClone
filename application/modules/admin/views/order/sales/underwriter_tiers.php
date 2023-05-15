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
                <a href="<?php echo base_url('order/admin/add-underwriter-tier')?>" class="btn btn-secondary">Add Underwriter Tier</a>
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
                <table class="table table-bordered cusom__common__datatable" id="tbl-underwriter-tier-listing" width="100%" cellspacing="0">
                    <thead>
                        <tr>
							<th>Product Type</th>
                            <th>Underwriter</th>
                            <th>Title</th>
                            <th>Commission</th>
                            <th>Description</th>
                            <th>Action</th>
                        </tr>
						
                    </thead>                
                    <tbody>
					<?php foreach($underwriter_tier_details as $underwriter_tier_record): ?>
						<tr>
							<td><?php echo ucfirst($underwriter_tier_record->product_type); ?></td>
							<td><?php echo ucfirst($underwriter_tier_record->underwriter); ?></td>
							<td><?php echo $underwriter_tier_record->title; ?></td>
							<td><?php echo $underwriter_tier_record->commission; ?> %</td>
							<td><?php echo substr($underwriter_tier_record->description,0,60); ?></td>
							<td> <a href="<?php echo base_url('order/admin/edit-underwriter-tier/'.$underwriter_tier_record->id)?>" class='btn btn-action 'title ='Edit Underwriter Tier'><span class='fas fa-edit' aria-hidden='true'></span></a>
								<button type="button"  class='btn btn-action delete-record-custom' data-url="<?php echo base_url('order/admin/delete-underwriter-tier/'.$underwriter_tier_record->id)?>" title ='Delete Underwriter Tier'><span class='fas fa-trash' aria-hidden='true'></span></button>
							</td>
						</tr>
						<?php endforeach;?>
					</tbody>
                </table>
            </div>
        </div>
    </div>
</div>
