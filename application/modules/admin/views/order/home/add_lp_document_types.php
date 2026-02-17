<style>
    .ui-menu .ui-menu-item-wrapper {
        font-size: 13px;
    }
    .ui-autocomplete {
        max-height: 300px !important;
    }
    .display-flex {
        display: flex;
    }
    .add-btn {
        display: flex;
        align-items: end;
        height: 40px;
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
        <h1><i class="fas fa-plus-circle"></i> LP Document Types</h1>
        <div class="action-buttons">
            <a href="<?php echo base_url() . 'order/admin/lp-document-types'; ?>" class="btn-action btn-action-secondary">
                <i class="fas fa-arrow-left"></i> Back
            </a>
        </div>
    </div>

    <!-- Add LP Document Types Form Card -->
    <div class="modern-card">
        <div class="modern-card-header">
            <h2><i class="fas fa-file-alt"></i> Add New LP Document Types</h2>
        </div>
        <div class="modern-card-body">
            <?php if (!empty($success_msg)) {?>
                <div class="alert-modern alert-success-modern"><?php echo $success_msg; ?></div>
            <?php }?>
            <?php if (!empty($error_msg)) {?>
                <div class="alert-modern alert-danger-modern"><?php echo $error_msg; ?></div>
            <?php }?>

            <form id="add-new-user" method="POST">

                <div class="form-group">
                    <label for="doc_type" class="col-sm-4 col-form-label">Doc Type<span class="required">
                            *</span></label>
                    <div class="col-sm-6">
                        <input type="text" class="form-control" name="doc_type" id="doc_type" value="
                                <?php echo set_value('doc_type') ?>" class="form-control"
                            placeholder="Doc Type">
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
                    <div class="col-sm-6">
                        <input type="text" class="form-control" name="doc_type_description"
                            id="doc_type_description"
                            value="<?php echo set_value('doc_type_description') ?>" class="form-control"
                            placeholder="Doc Type Description">
                    </div>
                </div>

                <!-- <div class="form-group">
                    <label for="doc_sub_type" class="col-sm-4 col-form-label">Doc Sub Type<span class="required"> *</span></label>
                    <div class="col-sm-6">
                        <input type="text" value="<?php echo set_value('doc_sub_type') ?>" class="form-control" name="doc_sub_type" id="doc_sub_type" class="form-control" placeholder="Doc Sub Type">
                        <?php if (!empty($doc_sub_type_error_msg)) {?>
                            <span class="error"><?php echo $doc_sub_type_error_msg; ?></span>
                        <?php }?>
                    </div>
                </div>

                <div class="form-group">
                    <label for="doc_sub_type_description" class="col-sm-4 col-form-label">Doc Sub Type Description<span class="required"> *</span></label>
                    <div class="col-sm-6">
                        <input type="text" class="form-control" name="doc_sub_type_description" id="doc_sub_type_description" value="<?php echo set_value('doc_sub_type_description') ?>" class="form-control" placeholder="Doc Sub Type Description">
                        <?php if (!empty($doc_sub_type_description_error_msg)) {?>
                            <span class="error"><?php echo $doc_sub_type_description_error_msg; ?></span>
                        <?php }?>
                    </div>
                </div> -->
                <div class="form-group row ml-1">
                    <label for="subtype_flag" class="col-sm-2 col-form-label">Is Subtype</label>
                    <div class="col-sm-2">
                        <input type="checkbox" value="1" class="form-control" style="width: 20px;"
                            name="subtype_flag" id="subtype_flag" class="form-control">
                    </div>
                </div>
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
                    <div class="subtype-wrapper display-flex toclone clone-widget mb-2" data-count="1">
                        <div class="col-sm-4">
                            <div class="selectSubtype">
                                <select name="subtype[]" id="subtype" class="form-control sectionSelect">
                                    <option value=""> Select Sub type </option>
                                    <?php foreach ($subtypeList as $list) {?>
                                        <option <?php echo $selected; ?>
                                            value="<?php echo $list['doc_type']; ?>">
                                            <?php echo $list['doc_type']; ?></option>
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
                </div>

                <div class="form-group">
                    <div class="col-sm-6">
                        <button type="submit" class="btn-action btn-action-primary">
                            <i class="fas fa-save"></i> Add
                        </button>
                        <a href="<?php echo base_url() . 'order/admin/lp-document-types'; ?>" class="btn-action btn-action-secondary">
                            <i class="fas fa-arrow-left"></i> Cancel
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.12.6/js/standalone/selectize.min.js"
    integrity="sha256-+C0A5Ilqmu4QcSPxrlGpaZxJ04VjsRjKu+G82kl5UJk=" crossorigin="anonymous"></script> -->
<script>
    function addSubtypeInput(num) {
        $('.clone-' + num).hide();
        num = num + 1;
        console.log(num);
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
        console.log("#sub-type-select-" + num);
        $("#sub-type-select-" + num).selectize({
            sortField: 'text'
        });
        $("#section-select-" + num).selectize({
            sortField: 'text'
        });
        console.log(subtypeList);
    }

</script>