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
      <div class="card-header">Edit Escrow Officer</div>
        <div class="card-body">        
            <form id="frm-edit-document-type" method="POST"> 
                <div class="form-group row">
                    <label for="category" class="col-sm-2 col-form-label">Category<span class="required">*</span></label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" name="category" id="category"  class="form-control" placeholder="Category" value="<?php echo isset($lp_document_info['category']) && !empty($lp_document_info['category']) ? $lp_document_info['category']: ''; ?>">
                        <?php if(!empty($category_error_msg)){ ?>                     
                            <span class="error"><?php echo $category_error_msg; ?></span>
                        <?php } ?>
                    </div>
                </div>       
                <div class="form-group row">
                    <label for="description" class="col-sm-2 col-form-label">Description<span class="required"> *</span></label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" name="description" id="description" class="form-control" placeholder="Description" value="<?php echo isset($lp_document_info['description']) && !empty($lp_document_info['description']) ? $lp_document_info['description']: ''; ?>">
                        <?php if(!empty($description_error_msg)){ ?>                     
                            <span class="error"><?php echo $description_error_msg; ?></span>
                        <?php } ?>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="doc_type" class="col-sm-2 col-form-label">Doc Type<span class="required"> *</span></label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" name="doc_type" id="doc_type" class="form-control" placeholder="Doc Type" value="<?php echo isset($lp_document_info['doc_type']) && !empty($lp_document_info['doc_type']) ? $lp_document_info['doc_type']: ''; ?>">
                        <?php if(!empty($doc_type_error_msg)){ ?>                     
                            <span class="error"><?php echo $doc_type_error_msg; ?></span>
                        <?php } ?>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="doc_sub_type" class="col-sm-2 col-form-label">Doc Sub Type<span class="required"> *</span></label>
                    <div class="col-sm-10">
                        <input type="text"  class="form-control" name="doc_sub_type" id="doc_sub_type" class="form-control" placeholder="Doc Sub Type" value="<?php echo isset($lp_document_info['doc_sub_type']) && !empty($lp_document_info['doc_sub_type']) ? $lp_document_info['doc_sub_type']: ''; ?>">
                        <?php if(!empty($doc_sub_type_error_msg)){ ?>                     
                            <span class="error"><?php echo $doc_sub_type_error_msg; ?></span>
                        <?php } ?>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="is_notice" class="col-sm-2 col-form-label">Is_ Notice</label>
                    <div class="col-sm-2">
                        <input type="checkbox" value="1" class="form-control" style="width: 20px;"  name="is_notice" id="is_notice" class="form-control" placeholder="Is Notice" <?php echo isset($lp_document_info['is_notice']) && !empty($lp_document_info['is_notice']) ? 'Checked' : ''; ?>>
                    </div>
                </div>               
                
                <div class="pull-right">
                    <button type="submit" id="add-sales-rep" name="add-sales-rep" class="btn btn-secondary">Update</button>
                    <a href="<?php echo site_url('order/admin/escrow-officers'); ?>" id="cancel" name="cancel" class="btn btn-secondary">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</div>
<script src="<?php echo base_url(); ?>assets/vendor/jquery/jquery.min.js"></script>
<script src="<?php echo base_url(); ?>assets/admin/js/jquery.validate.min.js"></script>
<script type="text/javascript">
    $(document).ready(function () {
        if(jQuery('#frm-edit-document-type').length)
        {
           jQuery('#frm-edit-document-type').validate({
                ignore:":not(:visible)",
                rules: {
                    partner_name:"required",
                    address:"required",
                    email_address:"required",
                    city:"required",
                    partner_id:"required",
                    state:"required",
                    zip:"required",
                    partner_type_id:"required"
                },
                messages: {
                    partner_name:"Please Enter Partner Name",
                    address:"Please Enter Address",
                    email_address:"Please Enter Email address",
                    city:"Please Enter City",
                    partner_id:"Please Enter Partner Id",
                    partner_type_id:"Please Enter Partner Type Id",
                    state:"Please Enter State",
                    zip: "Please Enter Zip",
                },
                submitHandler: function(form) {
                    form.submit();  
                }
            }); 
        }
    });
</script>