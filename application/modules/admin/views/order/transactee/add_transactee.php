<div class="pct-admin-listing">
    <!-- Page Header -->
    <div class="page-header">
        <h1><i class="fas fa-plus-circle"></i> Add Transctee</h1>
        <div class="action-buttons">
            <a href="<?php echo site_url('order/admin/transactees-list'); ?>" class="btn-action btn-action-secondary">
                <i class="fas fa-arrow-left"></i> Back
            </a>
        </div>
    </div>

    <!-- Add Transactee Form Card -->
    <div class="modern-card">
        <div class="modern-card-header">
            <h2><i class="fas fa-exchange-alt"></i> Add Transctee</h2>
        </div>
        <div class="modern-card-body">
            <?php if (!empty($success_msg)) {?>
                <div class="alert-modern alert-success-modern"><?php echo $success_msg; ?></div>
            <?php }?>
            <?php if (!empty($error_msg)) {?>
                <div class="alert-modern alert-danger-modern"><?php echo $error_msg; ?></div>
            <?php }?>

            <form id="frm-add-transactee" method="POST" enctype="multipart/form-data">

                <div class="form-group">
                    <label for="transctee_name" class="col-sm-2 col-form-label">Transactee Name<span class="required"> *</span></label>
                    <div class="col-sm-6">
                        <input type="text" class="form-control" name="transctee_name" id="transctee_name" value="<?php echo set_value('transctee_name'); ?>"  placeholder="Transactee Name">
                        <?php if (!empty($transctee_name_error_msg)) {?>
                            <span class="error"><?php echo $transctee_name_error_msg; ?></span>
                        <?php }?>
                    </div>
                </div>

                <div class="form-group">
                    <label for="file_number" class="col-sm-2 col-form-label">File Number<span class="required"> *</span></label>
                    <div class="col-sm-6">
                        <input type="text" class="form-control" name="file_number" id="file_number" value="<?php echo set_value('file_number'); ?>" placeholder="File Number">
                        <?php if (!empty($file_number_error_msg)) {?>
                            <span class="error"><?php echo $file_number_error_msg; ?></span>
                        <?php }?>
                    </div>
                </div>

                <div class="form-group">
                    <label for="account_number" class="col-sm-2 col-form-label">Account Number<span class="required"> *</span></label>
                    <div class="col-sm-6">
                        <input type="text" class="form-control" name="account_number" id="account_number" value="<?php echo set_value('account_number'); ?>" placeholder="Account Number">
                        <?php if (!empty($account_number_error_msg)) {?>
                            <span class="error"><?php echo $account_number_error_msg; ?></span>
                        <?php }?>
                    </div>
                </div>

                <div class="form-group">
                    <label for="aba" class="col-sm-2 col-form-label">ABA/Routing #<span class="required"> *</span></label>
                    <div class="col-sm-6">
                        <input type="text" class="form-control" name="aba" id="aba" value="<?php echo set_value('aba'); ?>" placeholder="ABA/Routing">
                        <?php if (!empty($aba_error_msg)) {?>
                            <span class="error"><?php echo $aba_error_msg; ?></span>
                        <?php }?>
                    </div>
                </div>

                <div class="form-group">
                    <label for="bank_name" class="col-sm-2 col-form-label">Bank Name<span class="required"> *</span></label>
                    <div class="col-sm-6">
                        <input type="text" class="form-control" name="bank_name" id="bank_name" value="<?php echo set_value('bank_name'); ?>" placeholder="Bank Name">
                        <?php if (!empty($bank_name_error_msg)) {?>
                            <span class="error"><?php echo $bank_name_error_msg; ?></span>
                        <?php }?>
                    </div>
                </div>

                <div class="form-group">
                    <label for="admin_notes" class="col-sm-2 col-form-label">Add Admin Notes</label>
                    <div class="col-sm-6">
                        <textarea type="text" class="form-control" name="admin_notes" id="admin_notes" placeholder="Add Admin Notes"> <?php echo set_value('admin_notes'); ?> </textarea>
                        <?php if (!empty($admin_notes_error_msg)) {?>
                            <span class="error"><?php echo $admin_notes_error_msg; ?></span>
                        <?php }?>
                    </div>
                </div>

                <div class="form-group">
                    <label for="transactee_documents" class="col-sm-2 col-form-label">Upload Document<span class="required"> *</span></label>
                    <div class="col-sm-6">
                        <input type="file" class="form-control" name="transactee_documents" id="transactee_documents" accept="application/pdf">
                        <?php if (!empty($transactee_documents_error_msg)) {?>
                            <span class="error"><?php echo $transactee_documents_error_msg; ?></span>
                        <?php }?>
                    </div>
                </div>

                <div class="form-group">
                    <div class="col-sm-6">
                        <button type="submit" id="add-transactee" name="add-transactee" class="btn-action btn-action-primary">
                            <i class="fas fa-save"></i> Add
                        </button>
                        <a href="<?php echo site_url('order/admin/transactees-list'); ?>" class="btn-action btn-action-secondary">
                            <i class="fas fa-arrow-left"></i> Cancel
                        </a>
                    </div>
                </div>

            </form>
        </div>
    </div>
</div>
