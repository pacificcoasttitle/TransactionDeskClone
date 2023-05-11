<style>
.hide {
    display: none;
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
                <h1 class="h3 text-gray-800">LP Document type</h1>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Edit LP Document type</h6>
                    </div>
                    <div class="card-body">        
                        <form id="frm-edit-document-type" method="POST">
                            <div class="form-group">
                                <label for="doc_type" class="col-sm-4 col-form-label">Doc Type<span class="required"> *</span></label>
                                <div class="col-sm-4">
                                    <input type="text" class="form-control" name="doc_type" id="doc_type" class="form-control" placeholder="Doc Type" value="<?php echo isset($lp_document_info['doc_type']) && !empty($lp_document_info['doc_type']) ? $lp_document_info['doc_type']: ''; ?>">
                                    <?php if(!empty($doc_type_error_msg)){ ?>                     
                                        <span class="error"><?php echo $doc_type_error_msg; ?></span>
                                    <?php } ?>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="doc_type_description" class="col-sm-4 col-form-label">Doc Type Description<span class="required">*</span></label>
                                <div class="col-sm-4">
                                    <input type="text" class="form-control" name="doc_type_description" id="doc_type_description"  class="form-control" placeholder="Doc Type Description" value="<?php echo isset($lp_document_info['doc_type_description']) && !empty($lp_document_info['doc_type_description']) ? $lp_document_info['doc_type_description']: ''; ?>">
                                    <?php if(!empty($doc_type_description_error_msg)){ ?>                     
                                        <span class="error"><?php echo $doc_type_description_error_msg; ?></span>
                                    <?php } ?>
                                </div>
                            </div> 
                            <!-- <div class="form-group">
                                <label for="doc_sub_type" class="col-sm-2 col-form-label">Doc Sub Type<span class="required"> *</span></label>
                                <div class="col-sm-10">
                                    <input type="text"  class="form-control" name="doc_sub_type" id="doc_sub_type" class="form-control" placeholder="Doc Sub Type" value="<?php echo isset($lp_document_info['doc_sub_type']) && !empty($lp_document_info['doc_sub_type']) ? $lp_document_info['doc_sub_type']: ''; ?>">
                                    <?php if(!empty($doc_sub_type_error_msg)){ ?>                     
                                        <span class="error"><?php echo $doc_sub_type_error_msg; ?></span>
                                    <?php } ?>
                                </div>
                            </div>      
                            <div class="form-group">
                                <label for="doc_sub_type_description" class="col-sm-2 col-form-label">Doc Sub Type Description<span class="required"> *</span></label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" name="doc_sub_type_description" id="doc_sub_type_description" class="form-control" placeholder="Doc Sub Type Description" value="<?php echo isset($lp_document_info['doc_sub_type_description']) && !empty($lp_document_info['doc_sub_type_description']) ? $lp_document_info['doc_sub_type_description']: ''; ?>">
                                    <?php if(!empty($doc_sub_type_description_error_msg)){ ?>                     
                                        <span class="error"><?php echo $doc_sub_type_description_error_msg; ?></span>
                                    <?php } ?>
                                </div>
                            </div> -->
                            
                            <!-- <div class="form-group">
                                <label for="is_notice" class="col-sm-4 col-form-label">Is Subtype</label>
                                <div class="col-sm-4">
                                    <input type="checkbox" value="1" class="form-control" style="width: 20px;"  name="subtype_flag" id="subtype_flag" class="form-control" placeholder="Is Notice" <?php echo isset($lp_document_info['subtype_flag']) && !empty($lp_document_info['subtype_flag']) ? 'Checked' : ''; ?>>
                                </div>
                            </div> -->
                            <?php $selectedList = explode(',',$lp_document_info['sub_type_list']); 
                            
                            // echo "<pre>";
                            // print_r($selectedList);die;
                            ?>
                            <div class="form-group selectsubtype <?php echo isset($lp_document_info['subtype_flag']) && !empty($lp_document_info['subtype_flag']) ? 'hide' : '' ?> ">
                                <label for="subtype" class="col-sm-4 col-form-label">Select Sub types.</label>
                                <div class="col-sm-4">
                                    <select name="subtype[]"  class="selectpicker" multiple data-live-search="true" data-actions-box="true">
                                        <?php 
                                                // print_r($lp_document_info);die;
                                        foreach($subtypeList as $list) {?>
                                            <?php 
                                                $selected = '';
                                                if(in_array($list['doc_type'], $selectedList))  {
                                                    $selected = 'selected';
                                                } 
                                            ?> 
                                            <option <?php echo $selected;?> value="<?php echo $list['doc_type'];?>"><?php echo $list['doc_type'];?></option>
                                        <?php }?>
                                    </select>
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <div class="col-sm-6">
                                    <button type="submit" id="edit-lp-doc-type" name="edit-lp-doc-type" class="btn btn-info btn-icon-split">
                                        <span class="icon text-white-50">
                                            <i class="fas fa-save"></i>
                                        </span>
                                        <span class="text">Update</span>
                                    </button>
                                    <a href="<?php echo site_url('order/admin/lp-document-types'); ?>" class="btn btn-secondary btn-icon-split">
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