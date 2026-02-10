<style>
    .display-flex {
        display: flex;
    }
    .add-btn {
        display: flex;
        align-items: end;
        height: 35px;
    }
    .btn-danger.add-btn {
        margin-left: 20px;
    }
    .hide {
        display: none;
    }
</style>
<link rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.12.6/css/selectize.bootstrap3.min.css"
    integrity="sha256-ze/OEYGcFbPRmvCnrSeKbRTtjG4vGLHXgOqsyLFTRjg=" crossorigin="anonymous" />

<div class="pct-admin-listing">
    <!-- Page Header -->
    <div class="page-header">
        <h1><i class="fas fa-edit"></i> LP Document type</h1>
        <div class="action-buttons">
            <a href="<?php echo base_url() . 'order/admin/lp-document-types'; ?>" class="btn-action btn-action-secondary">
                <i class="fas fa-arrow-left"></i> Back
            </a>
        </div>
    </div>

    <!-- Edit LP Document Type Form Card -->
    <div class="modern-card">
        <div class="modern-card-header">
            <h2><i class="fas fa-file-alt"></i> Edit LP Document type</h2>
        </div>
        <div class="modern-card-body">
            <?php if (!empty($success_msg)) {?>
                <div class="alert-modern alert-success-modern"><?php echo $success_msg; ?></div>
            <?php }?>
            <?php if (!empty($error_msg)) {?>
                <div class="alert-modern alert-danger-modern"><?php echo $error_msg; ?></div>
            <?php }?>

            <form id="frm-edit-document-type" method="POST">
                <div class="form-group">
                    <label for="doc_type" class="col-sm-4 col-form-label">Doc Type<span class="required">
                            *</span></label>
                    <div class="col-sm-4">
                        <input type="text" class="form-control" name="doc_type" id="doc_type"
                            class="form-control" placeholder="Doc Type"
                            value="<?php echo isset($lp_document_info['doc_type']) && !empty($lp_document_info['doc_type']) ? $lp_document_info['doc_type'] : ''; ?>">
                        <?php if (!empty($doc_type_error_msg)) {?>
                            <span class="error">
                                <?php echo $doc_type_error_msg; ?>
                            </span>
                        <?php }?>
                    </div>
                </div>
                <div class="form-group">
                    <label for="doc_type_description" class="col-sm-4 col-form-label">Doc Type
                        Description<span class="required">*</span></label>
                    <div class="col-sm-4">
                        <input type="text" class="form-control" name="doc_type_description"
                            id="doc_type_description" class="form-control"
                            placeholder="Doc Type Description"
                            value="<?php echo isset($lp_document_info['doc_type_description']) && !empty($lp_document_info['doc_type_description']) ? $lp_document_info['doc_type_description'] : ''; ?>">
                        <?php if (!empty($doc_type_description_error_msg)) {?>
                            <span class="error">
                                <?php echo $doc_type_description_error_msg; ?>
                            </span>
                        <?php }?>
                    </div>
                </div>
                <!-- <div class="form-group">
                    <label for="doc_sub_type" class="col-sm-2 col-form-label">Doc Sub Type<span class="required"> *</span></label>
                    <div class="col-sm-10">
                        <input type="text"  class="form-control" name="doc_sub_type" id="doc_sub_type" class="form-control" placeholder="Doc Sub Type" value="<?php echo isset($lp_document_info['doc_sub_type']) && !empty($lp_document_info['doc_sub_type']) ? $lp_document_info['doc_sub_type'] : ''; ?>">
                        <?php if (!empty($doc_sub_type_error_msg)) {?>
                            <span class="error"><?php echo $doc_sub_type_error_msg; ?></span>
                        <?php }?>
                    </div>
                </div>
                <div class="form-group">
                    <label for="doc_sub_type_description" class="col-sm-2 col-form-label">Doc Sub Type Description<span class="required"> *</span></label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" name="doc_sub_type_description" id="doc_sub_type_description" class="form-control" placeholder="Doc Sub Type Description" value="<?php echo isset($lp_document_info['doc_sub_type_description']) && !empty($lp_document_info['doc_sub_type_description']) ? $lp_document_info['doc_sub_type_description'] : ''; ?>">
                        <?php if (!empty($doc_sub_type_description_error_msg)) {?>
                            <span class="error"><?php echo $doc_sub_type_description_error_msg; ?></span>
                        <?php }?>
                    </div>
                </div> -->

                <div class="form-group display-flex">
                    <label for="subtype_flag" class="col-sm-2 col-form-label">Is Subtype</label>
                    <div class="col-sm-2">
                        <input type="checkbox" value="1" class="form-control" style="width: 20px;"
                            name="subtype_flag" id="subtype_flag" class="form-control"
                            placeholder="Is Notice" <?php echo isset($lp_document_info['subtype_flag']) && !empty($lp_document_info['subtype_flag']) ? 'Checked' : ''; ?>>
                    </div>
                </div>
                <?php if (empty($lp_document_info['subtype_flag'])) {?>
                    <div class="form-group ">
                        <div class="subtype-wrapper display-flex" data-count="1">
                            <div class="col-sm-4">
                                <label class="col-sm-6 col-form-label">Select Sub types.</label>
                            </div>
                            <div class="col-sm-3">
                                <label class="col-sm-6 col-form-label">Select Section.</label>
                            </div>

                        </div>
                    </div>
                    <div class="form-group" id="clone-subtype-option">

                        <?php

    if (!empty($mapped_sub_type)) {
        foreach ($mapped_sub_type as $key => $val) {
            ?>
                                <div class="subtype-wrapper display-flex toclone clone-widget mb-2" data-count="1">
                                    <div class="col-sm-4">
                                        <div class="selectSubtype">
                                            <select name="subtype[]" id="subtype" class="form-control sectionSelect">
                                                <option value=""> Select Sub type </option>
                                                <?php foreach ($subtypeList as $list) {

                $selected = '';
                if ($list['doc_type'] == $val['doc_type']) {
                    $selected = 'selected';
                }
                ?>
                                                        <option <?php echo $selected; ?>
                                                            value="<?php echo $list['doc_type']; ?>">
                                                            <?php echo $list['doc_type']; ?></option>
                                                <?php
}?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                        <select name="map_in_section[]" class="sectionSelect">
                                            <option value=""> Select Section </option>
                                            <option value="G" <?php echo ($val['map_in_section'] == 'G') ? 'selected' : '' ?>> Section G </option>
                                            <option value="H" <?php echo ($val['map_in_section'] == 'H') ? 'selected' : '' ?>> Section H </option>
                                            <option value="I" <?php echo ($val['map_in_section'] == 'I') ? 'selected' : '' ?>> Section I </option>
                                        </select>

                                    </div>

                                    <a href="javascript:void(0)"
                                        class="clone-<?php echo $key + 1; ?> btn btn-success add-btn <?php echo ((count($mapped_sub_type) != ($key + 1)) ? 'hide' : '') ?> "
                                        onClick="addSubtypeInput(<?php echo $key + 1; ?>)">
                                        <span class="icon"> <i class="fas fa-plus"></i> </span></a>
                                </div>
                            <?php
}
    } else {?>
                        <div class="subtype-wrapper display-flex toclone clone-widget mb-2" data-count="1">
                            <div class="col-sm-4">
                                <div class="selectSubtype">
                                    <select name="subtype[]" id="subtype" class="form-control sectionSelect">
                                        <option value=""> Select Sub type </option>
                                        <?php foreach ($subtypeList as $list) {?>
                                            <option value="<?php echo $list['doc_type']; ?>"> <?php echo $list['doc_type']; ?></option>
                                        <?php }?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <select name="map_in_section[]" class="sectionSelect">
                                    <option value=""> Select Section </option>
                                    <option value="G"> Section G </option>
                                    <option value="H"> Section H </option>
                                    <option value="I"> Section I </option>
                                </select>

                            </div>

                            <a href="javascript:void(0)" class="clone-1 btn btn-success add-btn"
                                onClick="addSubtypeInput(1)">
                                <span class="icon"> <i class="fas fa-plus"></i> </span></a>
                        </div>
                    <?php }?>
                    </div>
                <?php }?>
                <!-- <div
                    class="form-group selectsubtype <?php echo isset($lp_document_info['subtype_flag']) && !empty($lp_document_info['subtype_flag']) ? 'hide' : '' ?> ">
                    <label for="subtype" class="col-sm-4 col-form-label">Select Sub types.</label>
                    <div class="col-sm-4">
                        <select name="subtype[]" class="selectpicker" multiple data-live-search="true"
                            data-actions-box="true">
                            <?php
// print_r($lp_document_info);die;
foreach ($subtypeList as $list) {?>
                                <?php
$selected = '';
    if (in_array($list['doc_type'], $selectedList)) {
        $selected = 'selected';
    }
    ?>
                                <option <?php echo $selected; ?> value="<?php echo $list['doc_type']; ?>"><?php echo $list['doc_type']; ?></option>
                            <?php }?>
                        </select>
                    </div>
                </div> -->

                <div class="form-group">
                    <div class="col-sm-6">
                        <button type="submit" id="edit-lp-doc-type" name="edit-lp-doc-type" class="btn-action btn-action-primary">
                            <i class="fas fa-save"></i> Update
                        </button>
                        <a href="<?php echo site_url('order/admin/lp-document-types'); ?>" class="btn-action btn-action-secondary">
                            <i class="fas fa-arrow-left"></i> Cancel
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    function addSubtypeInput(num) {
        $('.clone-' + num).hide();
        num = num + 1;
        var subtypeList = <?php echo json_encode($subtypeList); ?>;
        var options = '<option>  </option>';
        subtypeList.forEach((type, i) => {
            options += "<option value=" + type.doc_type + " > " + type.doc_type + " </option>";
        });
        var selectInput = '<select id="sub-type-select-' + num + '" name="subtype[]" placeholder="Select Sub Type"  class="sectionSelect">' + options + '</select>';
        var sectionInput = '<select id="section-select-' + num + '" name="map_in_section[]" data-live-search="true" data-actions-box="true" class="sectionSelect"><option value=""> Select Section </option><option value="G"> Section G </option><option value="H"> Section H </option><option value="I"> Section I </option></select>';
        // var wrapper = '<div class="subtype-wrapper display-flex mt-2 " data-count=' + num + ' ><div class="col-sm-4"><div class="selectSubtype">' + selectInput + '</div></div><div class="col-sm-3"><div class="">    </div></div><div class="col-sm-2 add-btn"><a href="javascript:void(0)" class="btn btn-success" onClick="addSubtypeInput(' + num + ')"> <span class="icon">  <i class="fas fa-plus" ></i> </span></a></div></div>';

        var wrapp = '<div class="subtype-wrapper display-flex toclone clone-widget mb-2" data-count="1"><div class="col-sm-4"><div class="selectSubtype">' + selectInput + '</div ></div ><div class="col-sm-3">' + sectionInput + '</div><a href="javascript:void(0)" class="clone-' + num + ' btn btn-success add-btn" onClick="addSubtypeInput(' + num + ')"> <span class="icon"> <i class="fas fa-plus"></i> </span></a></div>';
        $('#clone-subtype-option').append(wrapp);
        // console.log("#sub-type-select-" + num);
        $("#sub-type-select-" + num).selectize({
            sortField: 'text'
        });
        $("#section-select-" + num).selectize({
            sortField: 'text'
        });
    }

</script>