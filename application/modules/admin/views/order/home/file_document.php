<style>
    #fileUploadModal .form-control {
        height: auto;
    }
    .bootstrap-select:not([class*="col-"]):not([class*="form-control"]):not(.input-group-btn) {
        width: 100% !important;
    }
</style>

<div class="pct-admin-listing">
    <!-- Page Header -->
    <div class="page-header">
        <h1><i class="fas fa-folder-open"></i> Forms</h1>
        <div class="action-buttons">
            <a href="javascript:void(0);" data-export-type="csv" data-toggle="modal" data-target="#fileUploadModal" class="btn-action btn-action-success">
                <i class="fa fa-upload"></i> Upload
            </a>
        </div>
    </div>

    <!-- File Documents Table Card -->
    <div class="modern-card">
        <div class="modern-card-header">
            <h2><i class="fas fa-list-alt"></i> Forms</h2>
        </div>
        <div class="modern-card-body">
            <?php if($this->session->flashdata('error')) : ?>
                <div class="alert-modern alert-danger-modern"><?php echo $this->session->flashdata('error');?></div>
            <?php elseif($this->session->flashdata('success')): ?>
                <div class="alert-modern alert-success-modern"><?php echo $this->session->flashdata('success');?></div>
            <?php endif; ?>
            
            <div id="forms_success_msg" class="alert-modern alert-success-modern" style="display:none;"></div>
            <div id="forms_error_msg" class="alert-modern alert-danger-modern" style="display:none;"></div>
            
            <div class="table-responsive">
                <table class="table table-bordered" id="tbl-file-documents-listing" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Sr No</th>
                            <th>Name</th>
                            <th>Description</th>
                            <th>Created At</th>
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
<div class="modal fade" id="fileUploadModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form enctype="multipart/form-data" method="post">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Upload File</h5>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="file-upload" class="col-form-label">Select File:</label>
                        <input required="" name="file" type="file" id="file-upload" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="file-name" class="col-form-label">Enter Name:</label>
                        <input name="name" required="" type="text" class="form-control" id="file-name">
                    </div>
                    <div class="form-group">
                        <label for="title-officer" class="col-form-label">Select Title Officer</label>
                        <div class="">
                            <select required="" name="titleOfficers[]" class="selectpicker" multiple data-live-search="true">
                                <option value="all">All</option>
                                <?php foreach($titleOfficers as $titleOfficer) {?>
                                    <option value="<?php echo $titleOfficer['id'];?>"> <?php echo $titleOfficer['first_name']." ".$titleOfficer['last_name'];?></option>
                                <?php }?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="file-description" class="col-form-label">Enter Description:</label>
                        <textarea name="description" class="form-control" id="file-description"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button class="btn btn-primary">Upload</button>
                </div>
                <input type="hidden" name="formId" id="formId" value="">
            </form>
        </div>
    </div>
</div>
