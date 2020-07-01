<style>
.ui-menu .ui-menu-item-wrapper {
    font-size : 13px;
}

.ui-autocomplete {
    max-height: 300px !important;
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
      <div class="card-header">Add New User</div>
        <div class="card-body">        
            <form id="add-new-user" method="POST">
                <div class="form-group row">
                    <label for="first_name" class="col-sm-2 col-form-label">First Name<span class="required"> *</span></label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" name="first_name" id="first_name" value="<?php echo set_value('first_name')?>" class="form-control" placeholder="First Name">
                        <?php if(!empty($first_name_error_msg)){ ?>                     
                            <span class="error"><?php echo $first_name_error_msg; ?></span>
                        <?php } ?>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="last_name" class="col-sm-2 col-form-label">Last Name<span class="required"> *</span></label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" name="last_name" id="last_name" value="<?php echo set_value('last_name')?>" class="form-control" placeholder="Last Name">
                        <?php if(!empty($last_name_error_msg)){ ?>                     
                            <span class="error"><?php echo $last_name_error_msg; ?></span>
                        <?php } ?>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="email_address" class="col-sm-2 col-form-label">Email Address<span class="required"> *</span></label>
                    <div class="col-sm-10">
                        <input type="email" value="<?php echo set_value('email_address')?>" class="form-control" name="email_address" id="email_address" class="form-control" placeholder="Email Address">
                        <?php if(!empty($email_address_error_msg)){ ?>                     
                            <span class="error"><?php echo $email_address_error_msg; ?></span>
                        <?php } ?>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="telephone_no" class="col-sm-2 col-form-label">Telephone</label>
                    <div class="col-sm-10">
                        <input type="text" value="<?php echo set_value('telephone_no')?>" class="form-control" name="telephone_no" id="telephone_no" class="form-control" placeholder="Telephone">
                    </div>
                </div>

                <div class="form-group row">
                    <label for="company" class="col-sm-2 col-form-label">Company<span class="required"> *</span></label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" name="company" id="company" value="<?php echo set_value('company')?>" class="form-control" placeholder="Company">
                        <?php if(!empty($company_error_msg)){ ?>                     
                            <span class="error"><?php echo $company_error_msg; ?></span>
                        <?php } ?>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="user_type" class="col-sm-2 col-form-label">User Type<span class="required"> *</span></label>
                    <div class="col-sm-10">
                        <select name="user_type" id="user_type" class="form-control">
                            <option value="">Select User Type</option>
                            <option <?php echo set_value('user_type') == 'lender' ? 'selected' : ''; ?> value="lender">Lender</option>
                            <option <?php echo set_value('user_type') == 'escrow' ? 'selected' : ''; ?> value="escrow">Escrow</option>
                        </select>
                        <?php if(!empty($user_type_error_msg)){ ?>                     
                            <span class="error"><?php echo $user_type_error_msg; ?></span>
                        <?php } ?>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="address" class="col-sm-2 col-form-label">Address<span class="required"> *</span></label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" name="address" id="address" value="<?php echo set_value('address')?>" class="form-control" placeholder="Address">
                        <?php if(!empty($address_error_msg)){ ?>                     
                            <span class="error"><?php echo $address_error_msg; ?></span>
                        <?php } ?>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="city" class="col-sm-2 col-form-label">City<span class="required"> *</span></label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" name="city" id="city" value="<?php echo set_value('city')?>" class="form-control" placeholder="City">
                        <?php if(!empty($city_error_msg)){ ?>                     
                            <span class="error"><?php echo $city_error_msg; ?></span>
                        <?php } ?>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="state" class="col-sm-2 col-form-label">State<span class="required"> *</span></label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" name="state" id="state" value="<?php echo set_value('state')?>" class="form-control" placeholder="State">
                        <?php if(!empty($state_error_msg)){ ?>                     
                            <span class="error"><?php echo $state_error_msg; ?></span>
                        <?php } ?>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="zipcode" class="col-sm-2 col-form-label">Zipcode<span class="required"> *</span></label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" name="zipcode" id="zipcode" value="<?php echo set_value('zipcode')?>" class="form-control" placeholder="Zipcode">
                        <?php if(!empty($zipcode_error_msg)){ ?>                     
                            <span class="error"><?php echo $zipcode_error_msg; ?></span>
                        <?php } ?>
                    </div>
                </div>

                <input type="hidden" name="partner_id" id="partner_id" value="<?php echo set_value('partner_id')?>">     
               
                <div class="pull-right">
                    <button type="submit" class="btn btn-secondary">Add</button>
                    <a href="<?php echo base_url().'order/admin/new-users'; ?>" id="cancel" name="cancel" class="btn btn-secondary">Cancel</a>
                </div>      
            </form>
        </div>
    </div>
</div>

<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/frontend/css/smart-forms.css">
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/frontend/css/jquery-ui.css">


<script src="<?php echo base_url(); ?>assets/libs/jquery-1.12.4.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/frontend/js/jquery-ui.min.js"></script>

<script type="text/javascript">
    jQuery(document).ready(function ($) {
        $("#company").autocomplete({
	        source: function(request, response) {
	            $.ajax({
	                url: base_url+"admin/order/home/get_company_list",
	                data: {
						term : request.term        
	                },
	                type: "POST",
	                dataType: "json",
	                success: function (data) {
						if (data.length > 0) {
                            response($.map(data, function (item) {
                                return item;
                            }))
                        } else {
                            response([{ label: 'No results found.', val: -1}]);
                        }
					}
	            });
			},
			delay: 0,
			minLength: 3,
	        select: function( event, ui ) {
	            event.preventDefault();
	            $("#company").val(ui.item.partner_name);
                $("#partner_id").val(ui.item.partner_id);
                $("#address").val(ui.item.address1);
                $("#city").val(ui.item.city);
                $("#state").val(ui.item.state);
                $("#zipcode").val(ui.item.zip);
	        },
	        change: function( event, ui ) {
	            if (ui.item == null) {
	            	$("#company").parent().removeClass('state-success').addClass('state-error');
	            }
	        }
	    });
    });
</script>
