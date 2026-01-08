<style>
	.dataTables_length {
		width: 250px !important;
		float: left;
	}

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
<div class="container-fluid">
	<div class="row mb-3">
		<div class="col-sm-6">
			<h1 class="h3 text-gray-800">Manual Buying Agent</h1>
		</div>
		<div class="col-sm-6">
            <a href="javascript:void(0);" data-toggle="modal" data-target="#addBuyerModal"  class="btn btn-success btn-icon-split float-right mr-2"> 
                <span class="icon text-white-50">
                    <i class="fas fa-plus"></i>
                </span>
                <span class="text"> Add Buying Agent </span> 
            </a>
			<?php  if (!in_array($roleName, ['CS Admin'])) : ?>
                <a href="javascript:void(0);" data-export-type="csv" id="export-csv" class="btn btn-success btn-icon-split float-right mr-2"> 
                    <span class="icon text-white-50">
                        <i class="fas fa-file-export"></i>
                    </span>
                    <span class="text"> Export </span> 
                </a>
            <?php endif; ?>
		</div>
	</div>
	<div class="card shadow mb-4">
        <?php if($this->session->flashdata('error')) : ?>
            <div class="alert alert-danger" role="alert"><?php echo $this->session->flashdata('error');?></div>
        <?php elseif($this->session->flashdata('success')): ?>
            <div class="alert alert-success" role="alert"><?php echo $this->session->flashdata('success');?></div>
        <?php endif; ?>
        <div class="card-header datatable-header py-3">
            <div class="datatable-header-titles" > 
                <span>
                    <i class="fas fa-users"></i>
                </span>
                <h6 class="m-0 font-weight-bold text-primary pl-10">Buying Agent</h6> 
            </div>
        </div>
                
        <div class="card-body">
            <div id="tbl-manual_success_msg" class="w-100 alert alert-success alert-dismissible" style="display:none;"></div>
            <div id="tbl-manual_error_msg" class="w-100 alert alert-danger alert-dismissible" style="display:none;"></div>
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

<!-- Modal -->
<div class="modal fade" id="addBuyerModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
	aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<form  method="post" id="add-Buyer-form">
				<div class="row">
					<div class="col-lg-12">
						<div class="card shadow">
							<div class="card-header py-3">
								<h6 class="m-0 font-weight-bold text-primary" >Add Buying Agent</h6>
							</div>
							<div class="card-body"> 
								<div class="smart-forms smart-container">
									<div class="modal-body search-result">
									
										<div class="form-group">
											<div class="row">
												<div class="col-sm-12">
													<label for="order_number" class="col-form-label">Order Number</label>
													<input name="order_number" required="" type="text" class="form-control" id="order_number">
                                                    <?php if(!empty($order_number_error_msg)){ ?>
                                                            <div class="alert alert-danger"><?php echo $order_number_error_msg; ?></div>
                                                    <?php } ?>
												</div>
                                                <div class="col-sm-12">
													<label for="property_address" class="col-form-label">Property Address</label>
													<input name="property_address" required="" type="text" class="form-control" id="property_address">
                                                    <?php if(!empty($property_address_error_msg)){ ?>
                                                            <div class="alert alert-danger"><?php echo $property_address_error_msg; ?></div>
                                                    <?php } ?>
												</div>
                                                <div class="col-sm-12">
													<label for="buyer_name" class="col-form-label">Buying Agent Name</label>
													<input name="buyer_name" required="" type="text" class="form-control" id="buyer_name" >
                                                    <?php if(!empty($buyer_name_error_msg)){ ?>
                                                            <div class="alert alert-danger"><?php echo $buyer_name_error_msg; ?></div>
                                                    <?php } ?>
												</div>
												<div class="col-sm-12">
													<label for="buyer_company_name" class="col-form-label">Buying Agent Company Name</label>
													<input name="buyer_company_name" type="text" class="form-control" id="buyer_company_name" >
												</div>
                                                <div class="col-sm-12">
													<label for="buyer_email" class="col-form-label">Buying Agent Email</label>
													<input name="buyer_email" required="" type="text" class="form-control" id="buyer_email" >
                                                    <?php if(!empty($buyer_email_error_msg)){ ?>
                                                            <div class="alert alert-danger"><?php echo $buyer_email_error_msg; ?></div>
                                                    <?php } ?>
												</div>
                                                <div class="col-sm-12">
													<label for="buyer_phone_no" class="col-form-label">Buyer Phone</label>
													<input name="buyer_phone_no" required="" type="text" class="form-control" id="buyer_phone_no" >
                                                    <?php if(!empty($buyer_phone_no_error_msg)){ ?>
                                                            <div class="alert alert-danger"><?php echo $buyer_phone_no_error_msg; ?></div>
                                                    <?php } ?>
												</div>
                                                <div class="col-sm-12">
													<label for="buyer_office_name" class="col-form-label">Buying Agent Office Name</label>
													<input name="buyer_office_name" required="" type="text" class="form-control" id="buyer_office_name" >
                                                    <?php if(!empty($buyer_office_name_error_msg)){ ?>
                                                            <div class="alert alert-danger"><?php echo $buyer_office_name_error_msg; ?></div>
                                                    <?php } ?>
												</div>
												<div class="col-sm-12">
													<label for="buyer_office_address" class="col-form-label">Buying Agent Office Address</label>
													<input name="buyer_office_address" required="" type="text" class="form-control" id="buyer_office_address" >
												</div>
												<div class="col-sm-12">
													<label for="buyer_office_city" class="col-form-label">Buying Agent Office City</label>
													<input name="buyer_office_city" required="" type="text" class="form-control" id="buyer_office_city" >
												</div>
                                                
                                                <div class="col-sm-12">
                                                    <label for="sales_rep_id" class="col-form-label">Sales Rep</label>
                                                    <input name="sales_rep_name" type="hidden" class="form-control" id="sales_rep_name" >
													<select id="sales_rep_id" name="sales_rep_id" class="form-control" placeholder="Sales Rep" required="">
                                                        <option value="">Sales Rep...</option>
                                                        <?php
                                                            if (isset($salesRep) && ! empty($salesRep)) {
                                                                foreach ($salesRep as $k => $v) {
                                                                    // $name      = [$v['first_name'], $v['last_name']];
                                                                    // $full_name = implode(' ', $name);
                                                                    $full_name = $v['full_name'];
                                                                ?>
                                                                        <option value="<?php echo $v['id']; ?>"><?php echo $full_name; ?></option>
                                                                <?php
                                                                    }
                                                                    }
                                                                ?>
                                                    </select>
                                                    <?php if(!empty($sales_rep_id_error_msg)){ ?>
                                                            <div class="alert alert-danger"><?php echo $sales_rep_id_error_msg; ?></div>
                                                    <?php } ?>
												</div>
											</div>
                                            
										</div>
									</div>
									<div class="form-footer" style="padding: 0px 1rem !important;">
										<button type="submit" data-btntext-sending="Sending..." class="btn btn-success btn-icon-split btn-sm">
											<span class="icon text-white-50">
												<i class="fas fa-check"></i>
											</span>
											<span class="text">Submit</span>
										</button>
										<button type="reset" data-dismiss="modal" aria-label="Close" class="btn btn-danger btn-icon-split btn-sm">
											<span class="icon text-white-50">
												<i class="fas fa-ban"></i>
											</span>
											<span class="text">Cancel</span>
										</button>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</form>
		</div>
	</div>
</div>

<div class="modal fade" id="addBuyerRecipientModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
	aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<form  method="post" id="send-email-form" method="POST" action="<?php echo base_url();?>send-email-to-buyer-recipient">
				<div class="row">
					<div class="col-lg-12">
						<div class="card shadow">
							<div class="card-header py-3">
								<h6 class="m-0 font-weight-bold text-primary" >Send Email </h6>
							</div>
							<div class="card-body"> 
								<div class="smart-forms smart-container">
									<div class="modal-body search-result">
									
										<div class="form-group">
											<div class="row">
												<div class="col-sm-12">
													<label for="buyer_recipient_email" class="col-form-label">Enter Sales Managers Email</label>
													<input name="buyer_recipient_email" required="" type="text" class="form-control" id="buyer_recipient_email">
													<input name="buyer_id" type="hidden" class="form-control" id="buyer_id">
												</div>
											</div>
                                            
										</div>
									</div>
									<div class="form-footer" style="padding: 0px 1rem !important;">
										<button type="submit" data-btntext-sending="Sending..." class="btn btn-success btn-icon-split btn-sm">
											<span class="icon text-white-50">
												<i class="fas fa-check"></i>
											</span>
											<span class="text">Send</span>
										</button>
										<button type="reset" data-dismiss="modal" aria-label="Close" class="btn btn-danger btn-icon-split btn-sm">
											<span class="icon text-white-50">
												<i class="fas fa-ban"></i>
											</span>
											<span class="text">Cancel</span>
										</button>
									</div>
								</div>
							</div>
						</div>
					</div>
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
