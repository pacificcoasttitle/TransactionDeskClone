

<div class="pct-page-modern">
<section class="section-type-4a section-defaulta" style="padding-bottom:0px;">
    <div class="container-fluid px-4 py-4">
            
        <div class="row mb-4 align-items-center">
            <div class="col-sm-6">
                <h1 class="pct-page-title" style="font-size:1.5rem;font-weight:600;color:#1e293b;margin-bottom:0;">Review Files</h1>
            </div>
            <div class="col-sm-6 text-right">
                <a href="javascript:void(0)" onclick="fetchPrelimDocument();" class="btn btn-success btn-icon-split"> 
                    <span class="icon text-white-50">
                        <i class="fas fa-refresh"></i>
                    </span>
                    <span class="text"> Fetch All Prelims Doc </span> 
                </a>
            </div>
        </div>
        <div class="card shadow mb-4">
            <div class="card-header datatable-header">
                <div class="datatable-header-titles" > 
                    <span><i class="fas fa-file-alt"></i></span>
                    <h6 class="m-0 font-weight-bold text-primary pl-10">Below are all your orders</h6> 
                </div>
            </div>
            <div class="card-body">
                <?php if($this->session->flashdata('success')): ?>
                    <div class="alert alert-success" role="alert"><?php echo $this->session->flashdata('success');?></div>
                <?php endif; ?>
                <?php if($this->session->flashdata('error')) : ?>
                    <div class="alert alert-danger" role="alert"><?php echo $this->session->flashdata('error');?></div>
                <?php endif; ?>
                <div id="prelim_success_msg" class="w-100 alert alert-success alert-dismissible" style="display:none;"></div>
                <div id="prelim_error_msg" class="w-100 alert alert-danger alert-dismissible" style="display:none;"></div>
                
                <div class="table-responsive">
                    <table class="table table-bordered" id="prelim_files" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th width="5%">#</th>
                                <th width="10%">File Number</th>
                                <th width="60%">Property Address</th>
                                <th width="25%">Action</th>
                            </tr>
                        </thead>                
                        <tbody></tbody>
                    </table>
                </div>
            </div>
        </div>
        
    </div>
</section>
</div>

<!-- Note Modal -->
<div class="modal fade" id="note_information" tabindex="-1" role="dialog" aria-labelledby="Create a Note" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <form method="POST" action="" enctype="multipart/form-data" id="prelim_add_note_form">
                <div class="card shadow">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Add a Note</h6>
                    </div>
                    <div class="card-body"> 
                        <div class="modal-body">
                            <div class="form-group mb-3">
                                <label for="note_subject" class="col-form-label">Subject</label>
                                <input type="text" name="note_subject" id="note_subject" class="form-control" placeholder="Subject" required="">
                            </div>

                            <div class="form-group mb-3">
                                <label for="note" class="col-form-label">Note</label>
                                <textarea name="note" id="note" class="form-control" rows="4" placeholder="Note" autocomplete="off" required=""></textarea>
                            </div>

                            <div class="form-group mb-3">
                                <label for="file_upload" class="col-form-label">Upload File</label>
                                <input required="" name="file_upload" type="file" id="file_upload" class="form-control" accept="application/pdf" style="padding: 0.375rem 0.75rem; height: auto;">
                            </div>
                            
                            <input type="hidden" name="upload_file_id" id="upload_file_id" value="">
                            <input type="hidden" name="document_name" id="document_name" value="">
                            <input type="hidden" name="order_id" id="order_id" value="">
                        </div>

                        <div class="form-footer text-right" style="padding: 0 1rem 1rem;">
                            <button type="button" data-btntext-sending="Sending..." id="submitNotesBtn" class="btn btn-success btn-icon-split btn-sm">
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
            </form>
        </div>
    </div>
</div>
