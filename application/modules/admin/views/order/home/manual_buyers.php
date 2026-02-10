<style>
    .bootstrap-select:not([class*="col-"]):not([class*="form-control"]):not(.input-group-btn) {
        width: 100% !important;
    }
</style>
<?php 
    $userdata = $this->session->userdata('admin');
	$roleList = $this->common_lib->getRoleList();
	$role_id = isset($userdata['role_id']) ? $userdata['role_id'] : 0;
	$roleName = $roleList[$role_id];
?>

<div class="pct-admin-listing">
    <!-- Page Header -->
    <div class="page-header">
        <h1><i class="fas fa-user-tie"></i> Manual Buying Agent</h1>
        <div class="action-buttons">
			<?php  if (!in_array($roleName, ['CS Admin'])) : ?>
                <a href="javascript:void(0);" data-export-type="csv" id="export-csv" class="btn-action btn-action-success">
                    <i class="fas fa-file-export"></i> Export
                </a>
            <?php endif; ?>
            <a href="javascript:void(0);" data-toggle="modal" data-target="#addBuyerModal" class="btn-action btn-action-success">
                <i class="fas fa-plus"></i> Add Buying Agent
            </a>
        </div>
    </div>

    <!-- Manual Buyers Table Card -->
    <div class="modern-card">
        <div class="modern-card-header">
            <h2><i class="fas fa-users"></i> Buying Agent</h2>
        </div>
        <div class="modern-card-body">
            <?php if($this->session->flashdata('error')) : ?>
                <div class="alert-modern alert-danger-modern"><?php echo $this->session->flashdata('error');?></div>
            <?php elseif($this->session->flashdata('success')): ?>
                <div class="alert-modern alert-success-modern"><?php echo $this->session->flashdata('success');?></div>
            <?php endif; ?>

            <div id="tbl-manual_success_msg" class="alert-modern alert-success-modern" style="display:none;"></div>
            <div id="tbl-manual_error_msg" class="alert-modern alert-danger-modern" style="display:none;"></div>

            <div class="table-responsive">
                <table class="table table-bordered" id="tbl-manual-buyers" width="100%" cellspacing="0">
                    <thead>
                        <tr>
							<th>Sr No</th>
							<th>Order Number</th>
							<th>Property Address</th>
							<th>Name</th>
							<th>Company</th>
							<th>Office Name</th>
							<th>Office Address</th>
							<th>Office City</th>
							<th>Email</th>
							<th>Phone</th>
							<th>Sales Rep</th>
							<th>Created Date</th>
							<th>Email Sent Time</th>
							<th>Action</th>
                        </tr>
                    </thead>                
                    <tbody></tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Add Buyer Modal -->
<div class="modal fade" id="addBuyerModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
	aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<form method="post" id="add-Buyer-form">
				<div class="modal-header">
					<h5 class="modal-title"><i class="fas fa-user-plus"></i> Add Buying Agent</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<div class="form-group">
						<label for="order_number" class="col-form-label">Order Number</label>
						<input name="order_number" required="" type="text" class="form-control" id="order_number">
						<?php if(!empty($order_number_error_msg)){ ?>
							<span class="error"><?php echo $order_number_error_msg; ?></span>
						<?php } ?>
					</div>
					<div class="form-group">
						<label for="property_address" class="col-form-label">Property Address</label>
						<input name="property_address" required="" type="text" class="form-control" id="property_address">
						<?php if(!empty($property_address_error_msg)){ ?>
							<span class="error"><?php echo $property_address_error_msg; ?></span>
						<?php } ?>
					</div>
					<div class="form-group">
						<label for="buyer_name" class="col-form-label">Buying Agent Name</label>
						<input name="buyer_name" required="" type="text" class="form-control" id="buyer_name">
						<?php if(!empty($buyer_name_error_msg)){ ?>
							<span class="error"><?php echo $buyer_name_error_msg; ?></span>
						<?php } ?>
					</div>
					<div class="form-group">
						<label for="buyer_company_name" class="col-form-label">Buying Agent Company Name</label>
						<input name="buyer_company_name" type="text" class="form-control" id="buyer_company_name">
					</div>
					<div class="form-group">
						<label for="buyer_email" class="col-form-label">Buying Agent Email</label>
						<input name="buyer_email" required="" type="text" class="form-control" id="buyer_email">
						<?php if(!empty($buyer_email_error_msg)){ ?>
							<span class="error"><?php echo $buyer_email_error_msg; ?></span>
						<?php } ?>
					</div>
					<div class="form-group">
						<label for="buyer_phone_no" class="col-form-label">Buyer Phone</label>
						<input name="buyer_phone_no" required="" type="text" class="form-control" id="buyer_phone_no">
						<?php if(!empty($buyer_phone_no_error_msg)){ ?>
							<span class="error"><?php echo $buyer_phone_no_error_msg; ?></span>
						<?php } ?>
					</div>
					<div class="form-group">
						<label for="buyer_office_name" class="col-form-label">Buying Agent Office Name</label>
						<input name="buyer_office_name" required="" type="text" class="form-control" id="buyer_office_name">
						<?php if(!empty($buyer_office_name_error_msg)){ ?>
							<span class="error"><?php echo $buyer_office_name_error_msg; ?></span>
						<?php } ?>
					</div>
					<div class="form-group">
						<label for="buyer_office_address" class="col-form-label">Buying Agent Office Address</label>
						<input name="buyer_office_address" required="" type="text" class="form-control" id="buyer_office_address">
					</div>
					<div class="form-group">
						<label for="buyer_office_city" class="col-form-label">Buying Agent Office City</label>
						<input name="buyer_office_city" required="" type="text" class="form-control" id="buyer_office_city">
					</div>
					<div class="form-group">
						<label for="sales_rep_id" class="col-form-label">Sales Rep</label>
						<input name="sales_rep_name" type="hidden" class="form-control" id="sales_rep_name">
						<select id="sales_rep_id" name="sales_rep_id" class="form-control" placeholder="Sales Rep" required="">
							<option value="">Sales Rep...</option>
							<?php
								if (isset($salesRep) && ! empty($salesRep)) {
									foreach ($salesRep as $k => $v) {
										$full_name = $v['full_name'];
									?>
										<option value="<?php echo $v['id']; ?>"><?php echo $full_name; ?></option>
									<?php
									}
								}
							?>
						</select>
						<?php if(!empty($sales_rep_id_error_msg)){ ?>
							<span class="error"><?php echo $sales_rep_id_error_msg; ?></span>
						<?php } ?>
					</div>
				</div>
				<div class="modal-footer">
					<button type="submit" data-btntext-sending="Sending..." class="btn-action btn-action-primary">
						<i class="fas fa-check"></i> Submit
					</button>
					<button type="reset" data-dismiss="modal" aria-label="Close" class="btn-action btn-action-secondary">
						<i class="fas fa-ban"></i> Cancel
					</button>
				</div>
			</form>
		</div>
	</div>
</div>

<!-- Send Email Modal -->
<div class="modal fade" id="addBuyerRecipientModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
	aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<form method="post" id="send-email-form" action="<?php echo base_url();?>send-email-to-buyer-recipient">
				<div class="modal-header">
					<h5 class="modal-title"><i class="fas fa-paper-plane"></i> Send Email</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<div class="form-group">
						<label for="buyer_recipient_email" class="col-form-label">Enter Sales Managers Email</label>
						<input name="buyer_recipient_email" required="" type="text" class="form-control" id="buyer_recipient_email">
						<input name="buyer_id" type="hidden" class="form-control" id="buyer_id">
					</div>
				</div>
				<div class="modal-footer">
					<button type="submit" data-btntext-sending="Sending..." class="btn-action btn-action-primary">
						<i class="fas fa-check"></i> Send
					</button>
					<button type="reset" data-dismiss="modal" aria-label="Close" class="btn-action btn-action-secondary">
						<i class="fas fa-ban"></i> Cancel
					</button>
				</div>
			</form>
		</div>
	</div>
</div>

<script>

    function editRoleInfo(formId,title) 
    {
		$('#formId').val(formId);
        $('#page-preloader').css('background-color', 'rgba(0,0,0,.5)');
        $('#page-preloader').css('display', 'block');
		$('#role-title').val(title);
		$('#page-preloader').css('display', 'none');
        $('#addBuyerModal').modal('show');
		
       
        return false;
	}

    function addBuyerEmailRecipient(buyerId) {
        $('#send-email-form #buyer_id').val(buyerId);
        $('#addBuyerRecipientModal').modal('show');
    }

    $('#sales_rep_id').change(function () {
        var selectedText = $(this).find('option:selected').text();
        $('#sales_rep_name').val(selectedText);
    });
</script>
