<style>
.ui-menu .ui-menu-item-wrapper {
    font-size : 13px;
}

.ui-autocomplete {
    max-height: 300px !important;
} 
</style>
<div class="content">
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

    <div class="container-fluid">
        <div class="row mb-3">
            <div class="col-sm-6">
                <h1 class="h3 text-gray-800">LP Document Types</h1>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Add New LP Document Types</h6>
                    </div>
                    <div class="card-body">        
                        <form id="add-new-user" method="POST">

                            <div class="form-group">
                                <label for="doc_type" class="col-sm-4 col-form-label">Doc Type<span class="required"> *</span></label>
                                <div class="col-sm-6">
                                    <input type="text" class="form-control" name="doc_type" id="doc_type" value="<?php echo set_value('doc_type')?>" class="form-control" placeholder="Doc Type">
                                    <?php if(!empty($doc_type_error_msg)){ ?>                     
                                        <span class="error"><?php echo $doc_type_error_msg; ?></span>
                                    <?php } ?>
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <label for="doc_type_description" class="col-sm-4 col-form-label">Doc Type Description<span class="required">*</span></label>
                                <div class="col-sm-6">
                                    <input type="text" class="form-control" name="doc_type_description" id="doc_type_description" value="<?php echo set_value('doc_type_description')?>" class="form-control" placeholder="Doc Type Description">
                                </div>
                            </div>
                            
                            <!-- <div class="form-group">
                                <label for="doc_sub_type" class="col-sm-4 col-form-label">Doc Sub Type<span class="required"> *</span></label>
                                <div class="col-sm-6">
                                    <input type="text" value="<?php echo set_value('doc_sub_type')?>" class="form-control" name="doc_sub_type" id="doc_sub_type" class="form-control" placeholder="Doc Sub Type">
                                    <?php if(!empty($doc_sub_type_error_msg)){ ?>                     
                                        <span class="error"><?php echo $doc_sub_type_error_msg; ?></span>
                                    <?php } ?>
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <label for="doc_sub_type_description" class="col-sm-4 col-form-label">Doc Sub Type Description<span class="required"> *</span></label>
                                <div class="col-sm-6">
                                    <input type="text" class="form-control" name="doc_sub_type_description" id="doc_sub_type_description" value="<?php echo set_value('doc_sub_type_description')?>" class="form-control" placeholder="Doc Sub Type Description">
                                    <?php if(!empty($doc_sub_type_description_error_msg)){ ?>                     
                                        <span class="error"><?php echo $doc_sub_type_description_error_msg; ?></span>
                                    <?php } ?>
                                </div>
                            </div> -->
                            <div class="form-group row ml-1">
                                <label for="subtype_flag" class="col-sm-2 col-form-label">Is Subtype</label>
                                <div class="col-sm-2">
                                    <input type="checkbox" value="1" class="form-control" style="width: 20px;"  name="subtype_flag" id="subtype_flag" class="form-control">
                                </div>
                            </div>
                            <div class="form-group selectsubtype ">
                                <label for="zipcode" class="col-sm-4 col-form-label">Select Sub types.</label>
                                <div class="col-sm-6">
                                    <select name="subtype[]"  class="selectpicker" multiple data-live-search="true" data-actions-box="true">
                                        <?php foreach($subtypeList as $list) {?>
                                            <?php 
                                            $selected = '';
                                                // if(set_value('sales_rep_users') && in_array($salesUser['id'], set_value('sales_rep_users')))  {
                                                //     $selected = 'selected';
                                                // } 
                                            ?> 
                                            <option <?php echo $selected;?> value="<?php echo $list['doc_type'];?>"><?php echo $list['doc_type'];?></option>
                                        <?php }?>
                                    </select>
                                </div>
                            </div>
                            <!-- <div class="form-group">
                                <label for="is_notice" class="col-sm-2 col-form-label">Is_ Notice</label>
                                <div class="col-sm-2">
                                    <input type="checkbox" value="1" class="form-control" style="width: 20px;"  name="is_notice" id="is_notice" class="form-control" placeholder="Is Notice">
                                </div>
                            </div> -->
                            
                            <div class="form-group">
                                <div class="col-sm-6">
                                    <button type="submit" class="btn btn-info btn-icon-split">
                                        <span class="icon text-white-50">
                                            <i class="fas fa-save"></i>
                                        </span>
                                        <span class="text">Add</span>
                                    </button>
                                    <a href="<?php echo base_url().'order/admin/lp-document-types'; ?>" class="btn btn-secondary btn-icon-split">
                                        <span class="icon text-white-50">
                                            <i class="fas fa-arrow-left"></i>
                                        </span>
                                        <span class="text">Cancel</span>
                                    </a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
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

        $("#title_company").autocomplete({
	        source: function(request, response) {
	            $.ajax({
	                url: base_url+"admin/order/home/get_title_company_list",
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
			minLength: 2,
	        select: function( event, ui ) {
	            event.preventDefault();
	            $("#title_company").val(ui.item.partner_name);
                $("#title_partner_id").val(ui.item.partner_id);
	        },
	        change: function( event, ui ) {
	            if (ui.item == null) {
	            	$("#title_company").parent().removeClass('state-success').addClass('state-error');
	            }
	        }
	    });
    });
</script>
