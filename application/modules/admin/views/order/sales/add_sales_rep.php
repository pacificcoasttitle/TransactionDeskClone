<style>
.bootstrap-select:not([class*="col-"]):not([class*="form-control"]):not(.input-group-btn) {
    width: -webkit-fill-available;
}
#accordionEx .card-header a .fa-angle-down {
	display: none;
}
#accordionEx .card-header a.collapsed .fa-angle-up {
	display: none;
}
#accordionEx .card-header a.collapsed .fa-angle-down {
	display: inline-block;
}
.accordion > .card.managerInfoCard {
	overflow: initial;
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
      <div class="card-header">Add Sales Rep</div>
        <div class="card-body">        
            <form id="frm-add-sales-rep" method="POST" enctype="multipart/form-data">

				<div class="accordion md-accordion" id="accordionEx">

					<div class="card mx-auto mt-5 mb-5" style="border-bottom: 1px solid rgba(0, 0, 0, 0.125);">
						<div class="card-header" role="tab" id="salesRepInfoTab">
							<a data-toggle="collapse" style="color: #000000;" data-parent="#accordionEx" href="#salesRepInfo" aria-expanded="true"
							aria-controls="salesRepInfo">
								<h5 class="mb-0">
								Sales Rep Info <i class="fas fa-angle-down pull-right"></i><i class="fas fa-angle-up pull-right"></i>
								</h5>
							</a>
						</div>
						<div id="salesRepInfo" class="collapse show" role="tabpanel" aria-labelledby="salesRepInfoTab" data-parent="#accordionEx">
							<div class="card-body">
								<div class="form-group row">
									<label for="sales_rep_first_name" class="col-sm-4 col-form-label">First Name<span class="required"> *</span></label>
									<div class="col-sm-8">
										<input type="text" class="form-control" name="sales_rep_first_name" id="sales_rep_first_name" class="form-control" placeholder="Enter Sales Rep. First Name" value="<?php echo isset($sales_rep_info['first_name']) && !empty($sales_rep_info['first_name']) ? $sales_rep_info['first_name'] : ''?>">
										<?php if(!empty($first_name_error_msg)){ ?>                     
											<span class="error"><?php echo $first_name_error_msg; ?></span>
										<?php } ?>
									</div>
								</div>
				
								<div class="form-group row">
									<label for="sales_rep_last_name" class="col-sm-4 col-form-label">Last Name<span class="required"> *</span></label>
									<div class="col-sm-8">
										<input type="text" class="form-control" name="sales_rep_last_name" id="sales_rep_last_name" class="form-control" placeholder="Enter Sales Rep. Last Name" value="<?php echo isset($sales_rep_info['last_name']) && !empty($sales_rep_info['last_name']) ? $sales_rep_info['last_name'] : ''?>">
										<?php if(!empty($last_name_error_msg)){ ?>                     
											<span class="error"><?php echo $last_name_error_msg; ?></span>
										<?php } ?>
									</div>
								</div>
				
								<div class="form-group row">
									<label for="email_address" class="col-sm-4 col-form-label">Email Address<span class="required"> *</span></label>
									<div class="col-sm-8">
										<input type="text" class="form-control" name="email_address" id="email_address" class="form-control" placeholder="Email Address">
										<?php if(!empty($email_error_msg)){ ?>                     
											<span class="error"><?php echo $email_error_msg; ?></span>
										<?php } ?>
									</div>
								</div>
				
								<div class="form-group row">
									<label for="telephone" class="col-sm-4 col-form-label">Phone Number<span class="required"> *</span></label>
									<div class="col-sm-8">
										<input type="text" class="form-control" name="telephone" id="telephone" class="form-control" placeholder="Phone Number">
										<?php if(!empty($phone_error_msg)){ ?>                     
											<span class="error"><?php echo $phone_error_msg; ?></span>
										<?php } ?>
									</div>
								</div>
							</div>
						</div>
					</div>

					<div class="card mx-auto mt-5 mb-5" style="border-bottom: 1px solid rgba(0, 0, 0, 0.125);">
						<div class="card-header" role="tab" id="reswareInfoTab">
							<a data-toggle="collapse" class="collapsed" style="color: #000000;" data-parent="#accordionEx" href="#reswareInfo" 
							aria-controls="reswareInfo">
								<h5 class="mb-0">
								Resware <i class="fas fa-angle-down pull-right"></i><i class="fas fa-angle-up pull-right"></i>
								</h5>
							</a>
						</div>
						<div id="reswareInfo" class="collapse" role="tabpanel" aria-labelledby="reswareInfoTab" data-parent="#accordionEx">
							<div class="card-body">
								<div class="form-group row">
									<label for="partner_id" class="col-sm-4 col-form-label">Partner Id<span class="required"> *</span></label>
									<div class="col-sm-8">
										<input type="number" class="form-control" name="partner_id" id="partner_id" class="form-control" placeholder="Partner Id">
										<?php if(!empty($partner_id_error_msg)){ ?>                     
											<span class="error"><?php echo $partner_id_error_msg; ?></span>
										<?php } ?>
									</div>
								</div>
				
								<div class="form-group row">
									<label for="partner_type_id" class="col-sm-4 col-form-label">Partner Type Id<span class="required"> *</span></label>
									<div class="col-sm-8">
										<input type="number" class="form-control" name="partner_type_id" id="partner_type_id" class="form-control" placeholder="Partner Type Id">
										<?php if(!empty($partner_type_id_error_msg)){ ?>                     
											<span class="error"><?php echo $partner_type_id_error_msg; ?></span>
										<?php } ?>
									</div>
								</div>
							</div>
						</div>
					</div>

					<div class="card mx-auto mt-5 mb-5" style="border-bottom: 1px solid rgba(0, 0, 0, 0.125);">
						<div class="card-header" role="tab" id="productionTab">
							<a data-toggle="collapse" class="collapsed" style="color: #000000;" data-parent="#accordionEx" href="#production" 
							aria-controls="production">
								<h5 class="mb-0">
								Production <i class="fas fa-angle-down pull-right"></i><i class="fas fa-angle-up pull-right"></i>
								</h5>
							</a>
						</div>
						<div id="production" class="collapse" role="tabpanel" aria-labelledby="productionTab" data-parent="#accordionEx">
							<div class="card-body">
								<div class="form-group row">
									<label for="sales_rep_no_of_open_orders" class="col-sm-4 col-form-label">Number of Open Orders<span class="required"> *</span></label>
									<div class="col-sm-8">
										<input type="text" class="form-control" name="sales_rep_no_of_open_orders" id="sales_rep_no_of_open_orders"  class="form-control">
										<?php if(!empty($sales_rep_no_of_open_orders_error_msg)){ ?>                     
											<span class="error"><?php echo $sales_rep_no_of_open_orders_error_msg; ?></span>
										<?php } ?>
									</div>
								</div>
				
								<div class="form-group row">
									<label for="sales_rep_no_of_close_orders" class="col-sm-4 col-form-label">Number of Closed Orders<span class="required"> *</span></label>
									<div class="col-sm-8">
										<input type="text" class="form-control" name="sales_rep_no_of_close_orders" id="sales_rep_no_of_close_orders"  class="form-control">
										<?php if(!empty($sales_rep_no_of_close_orders_error_msg)){ ?>                     
											<span class="error"><?php echo $sales_rep_no_of_close_orders_error_msg; ?></span>
										<?php } ?>
									</div>
								</div>
				
								<div class="form-group row">
									<label for="sales_rep_premium" class="col-sm-4 col-form-label">Revenue<span class="required"> *</span></label>
									<div class="col-sm-8">
										<input type="text" class="form-control" name="sales_rep_premium" id="sales_rep_premium" class="form-control">
										<?php if(!empty($sales_rep_premium_error_msg)){ ?>                     
											<span class="error"><?php echo $sales_rep_premium_error_msg; ?></span>
										<?php } ?>
									</div>
								</div>
							</div>
						</div>
					</div>

					<div class="card mx-auto mt-5 mb-5 managerInfoCard" style="border-bottom: 1px solid rgba(0, 0, 0, 0.125);">
						<div class="card-header" role="tab" id="managerTab">
							<a data-toggle="collapse" class="collapsed" style="color: #000000;" data-parent="#accordionEx" href="#managerInfo" 
							aria-controls="managerInfo">
								<h5 class="mb-0">
								Manager <i class="fas fa-angle-down pull-right"></i><i class="fas fa-angle-up pull-right"></i>
								</h5>
							</a>
						</div>
						<div id="managerInfo" class="collapse" role="tabpanel" aria-labelledby="managerTab" data-parent="#accordionEx">
							<div class="card-body">
								<div class="form-group row">
									<label for="language" class="col-sm-4 col-form-label">Sales Manager</label>
									<div class="col-sm-1">
										<input type="checkbox" class="form-control" name="is_sales_rep_manager" id="is_sales_rep_manager" class="form-control">
									</div>
								</div>
				
								<div class="form-group row">
									<label for="zipcode" class="col-sm-4 col-form-label">Select Sales Reps.</label>
									<div class="col-sm-8">
										<select name="sales_rep_users[]"  class="selectpicker" multiple data-live-search="true" data-actions-box="true">
											<?php foreach($salesUsers as $salesUser) {?>
												<?php $selected = '';
													if(set_value('sales_rep_users') && in_array($salesUser['id'], set_value('sales_rep_users')))  {
														$selected = 'selected';
													} 
												?> 
												<option <?php echo $selected;?> value="<?php echo $salesUser['id'];?>"><?php echo $salesUser['first_name']." ".$salesUser['last_name'];?></option>
											<?php }?>
										</select>
									</div>
								</div>
							</div>
						</div>
					</div>

					<div class="card mx-auto mt-5 mb-5" style="border-bottom: 1px solid rgba(0, 0, 0, 0.125);">
						<div class="card-header" role="tab" id="imagesTab">
							<a data-toggle="collapse" class="collapsed" style="color: #000000;" data-parent="#accordionEx" href="#imagesInfo" 
							aria-controls="imagesInfo">
								<h5 class="mb-0">
								Images <i class="fas fa-angle-down pull-right"></i><i class="fas fa-angle-up pull-right"></i>
								</h5>
							</a>
						</div>
						<div id="imagesInfo" class="collapse" role="tabpanel" aria-labelledby="imagesTab" data-parent="#accordionEx">
							<div class="card-body">
								<div class="form-group row">
									<label for="sales_rep_profile_img" class="col-sm-4 col-form-label">Profile Img For Borrower Email</label>
									<div class="col-sm-8">
										<input type="file" class="form-control" name="sales_rep_profile_img" id="sales_rep_profile_img" accept=".png,.jpg" class="form-control">
										<?php if(!empty($sales_rep_profile_img_error_msg)){ ?>                     
											<span class="error"><?php echo $sales_rep_profile_img_error_msg; ?></span>
										<?php } ?>
									</div>
								</div>
				
								<div class="form-group row">
									<label for="sales_rep_profile_thank_you_img" class="col-sm-4 col-form-label">Profile Img For Thank you Email</label>
									<div class="col-sm-8">
										<input type="file" class="form-control" name="sales_rep_profile_thank_you_img" id="sales_rep_profile_thank_you_img" accept=".png,.jpg" class="form-control">
										<?php if(!empty($sales_rep_profile_thank_you_img_error_msg)){ ?>                     
											<span class="error"><?php echo $sales_rep_profile_thank_you_img_error_msg; ?></span>
										<?php } ?>
									</div>
								</div>
							</div>
						</div>
					</div>

					<div class="card mx-auto mt-5 mb-5" style="border-bottom: 1px solid rgba(0, 0, 0, 0.125);">
						<div class="card-header" role="tab" id="notificationsTab">
							<a data-toggle="collapse" class="collapsed" style="color: #000000;" data-parent="#accordionEx" href="#notificationsInfo" 
							aria-controls="notificationsInfo">
								<h5 class="mb-0">
								Notifications<i class="fas fa-angle-down pull-right"></i><i class="fas fa-angle-up pull-right"></i>
								</h5>
							</a>
						</div>
						<div id="notificationsInfo" class="collapse" role="tabpanel" aria-labelledby="notificationsTab" data-parent="#accordionEx">
							<div class="card-body">
								<div class="form-group row">
									<label for="telephone" class="col-sm-4 col-form-label">&nbsp;</label>
									<div class="col-sm-8">
										<input type="checkbox" class="" style="height:18px;width:18px;margin-right:10px;" name="is_mail_notification" id="is_mail_notification" class="form-control" placeholder="Mail Notification">Mail Notification
									</div>
								</div>
							</div>
						</div>
					</div>

					<div class="card mx-auto mt-5 mb-5" style="border-bottom: 1px solid rgba(0, 0, 0, 0.125);">
						<div class="card-header" role="tab" id="commissionTab">
							<a data-toggle="collapse" class="collapsed" style="color: #000000;" data-parent="#accordionEx" href="#commissionInfo" 
							aria-controls="commissionInfo">
								<h5 class="mb-0">
								Commissions <i class="fas fa-angle-down pull-right"></i><i class="fas fa-angle-up pull-right"></i>
								</h5>
							</a>
						</div>
						<div id="commissionInfo" class="collapse" role="tabpanel" aria-labelledby="commissionTab" data-parent="#accordionEx">
							<div class="card-body">
								<div class="form-group row">
									<label for="loan_westcor" class="col-sm-4 col-form-label">Loan Westcor Commission %</label>
									<div class="col-sm-8">
									<input  step=".01" min="0"  type="number" class="form-control" name="loan_westcor" id="loan_westcor" class="form-control" placeholder="Enter Loan Westcor Commission" >
										<?php if(!empty($loan_westcor_error_msg)){ ?>                     
											<span class="error"><?php echo $loan_westcor_error_msg; ?></span>
										<?php } ?>
									</div>
								</div>
								<div class="form-group row">
									<label for="loan_natic" class="col-sm-4 col-form-label">Loan Natic Commission %</label>
									<div class="col-sm-8">
									<input  step=".01" min="0"  type="number" class="form-control" name="loan_natic" id="loan_natic" class="form-control" placeholder="Enter Loan Natic Commission" >
										<?php if(!empty($loan_natic_error_msg)){ ?>                     
											<span class="error"><?php echo $loan_natic_error_msg; ?></span>
										<?php } ?>
									</div>
								</div>
								<div class="form-group row">
									<label for="sale_westcor" class="col-sm-4 col-form-label">Sale Westcor Commission %</label>
									<div class="col-sm-8">
									<input  step=".01" min="0"  type="number" class="form-control" name="sale_westcor" id="sale_westcor" class="form-control" placeholder="Enter Sale Westcor Commission" >
										<?php if(!empty($sale_westcor_error_msg)){ ?>                     
											<span class="error"><?php echo $sale_westcor_error_msg; ?></span>
										<?php } ?>
									</div>
								</div>
							</div>
						</div>
					</div>



					
					<div class="pull-right">
						<button type="submit" id="add-sales-rep" name="add-sales-rep" class="btn btn-secondary">Add</button>
						<a href="<?php echo site_url('order/admin/sales-rep'); ?>" id="cancel" name="cancel" class="btn btn-secondary">Cancel</a>
					</div>
				</div>
            </form>
        </div>
    </div>
</div>
<script src="<?php echo base_url(); ?>assets/vendor/jquery/jquery.min.js"></script>
<script src="<?php echo base_url(); ?>assets/admin/js/jquery.validate.min.js"></script>
<script type="text/javascript">
    $(document).ready(function () {
        if(jQuery('#frm-add-sales-rep').length)
        {
           jQuery('#frm-add-sales-rep').validate({
                ignore:"",
                rules: {
                    sales_rep_first_name:"required",
                    sales_rep_last_name:"required",
                    email_address:"required",
                    telephone:"required",
                    partner_id:"required",
                    partner_type_id:"required",
                    sales_rep_no_of_open_orders:"required",
                    sales_rep_no_of_close_orders:"required",
                    sales_rep_premium:"required",
                },
                messages: {
                    sales_rep_first_name:"Please Enter First Name",
                    sales_rep_last_name:"Please Enter Last Name",
                    email_address:"Please Enter Email address",
                    telephone:"Please Enter Phone Number",
                    partner_id:"Please Enter Partner Id",
                    partner_type_id:"Please Enter Partner Type Id",
                },
				invalidHandler: function(event, validator) {
					if (validator.numberOfInvalids() > 0) {
						validator.showErrors();
						var collapse_class_id = $(":input.error").closest(".collapse").attr('id');
						$('#'+collapse_class_id).collapse('show');
					}
				},
                submitHandler: function(form) {
                    form.submit();  
                }
            }); 
        }
    });
</script>
