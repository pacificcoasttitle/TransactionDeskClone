<style>
/* Modernized styles based on CPL/Proposed Insured pages */
.pct-page-modern {
    --pct-primary: #1e5f8a;
    --pct-primary-light: #2d7ab5;
    --pct-primary-soft: #e8f2f8;
    --pct-surface: #ffffff;
    --pct-surface-2: #f8fafc;
    --pct-text: #1e293b;
    --pct-text-muted: #64748b;
    --pct-border: #e2e8f0;
    --pct-radius: 12px;
    --pct-radius-sm: 8px;
    --pct-shadow: 0 1px 3px rgba(0,0,0,.06);
    font-family: 'Nunito', -apple-system, BlinkMacSystemFont, 'Segoe UI', system-ui, sans-serif;
    background: var(--pct-surface-2);
    padding-bottom: 2rem;
}

.pct-page-modern .error { color: #dc2626 !important; font-size: 0.8125rem; }

/* Custom buttons for prelim status */
.pct-page-modern .update-prelim-btn {
    background-color: #94a3b8 !important; /* Slate-400 equivalent for B0BEC5 */
    border-color: #94a3b8 !important;
    color: #fff !important;
    border-radius: var(--pct-radius-sm);
    /* padding: 0.375rem 0.75rem; */
    font-size: 0.875rem;
    font-weight: 500;
}
.pct-page-modern .updated-prelim-btn {
    background-color: #f97316 !important; /* Orange-500 equivalent for F26B2B */
    border-color: #f97316 !important;
    color: #fff !important;
    border-radius: var(--pct-radius-sm);
    padding: 0.375rem 0.75rem;
    font-size: 0.875rem;
    font-weight: 500;
}

/* Card */
.pct-page-modern .card.shadow.mb-4 {
    border: 1px solid var(--pct-border);
    border-radius: var(--pct-radius);
    box-shadow: var(--pct-shadow);
    overflow: hidden;
    background: var(--pct-surface);
}
.pct-page-modern .card-header.datatable-header {
    background: var(--pct-surface-2);
    border-bottom: 1px solid var(--pct-border);
    padding: 1rem 1.25rem;
}
.pct-page-modern .card-header.datatable-header h6 {
    font-size: 1rem;
    font-weight: 600;
    color: var(--pct-text);
    margin: 0;
}
.pct-page-modern .card-header .pl-10 { padding-left: 0.5rem; }
.pct-page-modern .card-body { padding: 1.25rem; }

/* Table */
.pct-page-modern #prelim_files thead th {
    background: var(--pct-surface-2);
    color: var(--pct-text);
    font-weight: 600;
    font-size: 0.8125rem;
    text-transform: uppercase;
    letter-spacing: 0.03em;
    border-bottom: 1px solid var(--pct-border);
    padding: 0.875rem 1rem;
}
.pct-page-modern #prelim_files tbody td {
    padding: 0.875rem 1rem;
    font-size: 0.875rem;
    color: var(--pct-text);
    border-bottom: 1px solid var(--pct-border);
    vertical-align: middle;
}
.pct-page-modern #prelim_files tbody tr:hover td { background: var(--pct-surface-2); }
.pct-page-modern td.dataTables_empty { display: table-cell !important; }

/* Pagination */
.pct-page-modern .dataTables_wrapper { padding-top: 0.75rem; }
.pct-page-modern .dataTables_wrapper .row:last-child {
    align-items: center;
    padding: 0.75rem 0;
    border-top: 1px solid var(--pct-border);
    margin-top: 0.5rem;
}
.pct-page-modern .dataTables_info { font-size: 0.8125rem; color: var(--pct-text-muted); font-weight: 500; }
.pct-page-modern .dataTables_paginate ul.pagination {
    margin: 0 !important;
    gap: 0.25rem;
    display: inline-flex;
    flex-wrap: wrap;
    justify-content: flex-end;
}
.pct-page-modern .dataTables_paginate .page-item .page-link {
    min-width: 2rem; height: 2rem;
    padding: 0 0.5rem;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    font-size: 0.8125rem;
    font-weight: 500;
    color: var(--pct-text);
    background: var(--pct-surface);
    border: 1px solid var(--pct-border);
    border-radius: var(--pct-radius-sm);
    transition: background .15s ease, border-color .15s ease, color .15s ease;
}
.pct-page-modern .dataTables_paginate .page-item .page-link:hover {
    background: var(--pct-surface-2);
    border-color: var(--pct-primary-soft);
    color: var(--pct-primary);
}
.pct-page-modern .dataTables_paginate .page-item.active .page-link {
    background: var(--pct-primary);
    border-color: var(--pct-primary);
    color: #fff;
}
.pct-page-modern .dataTables_paginate .page-item.disabled .page-link {
    background: var(--pct-surface-2);
    color: var(--pct-text-muted);
    border-color: var(--pct-border);
    opacity: 0.8;
}

/* Modals & Forms */
.modal-content { border-radius: 12px; border: 1px solid #e2e8f0; box-shadow: 0 4px 12px rgba(0,0,0,.08); }
.modal .card { border: none; box-shadow: none !important; }
.modal .card-body { padding: 1rem 1.25rem; }
.modal .card-header { background: transparent; border-bottom: 1px solid #e2e8f0; padding: 1rem; }
.modal .card-header h6 { color: #1e5f8a; font-size: 1rem; }

.form-control {
    padding: 0.5rem 0.75rem;
    font-size: 0.9375rem;
    border: 1px solid #e2e8f0;
    border-radius: 8px;
    color: #1e293b;
    background: #fff;
    width: 100%;
}
.form-control:focus {
    border-color: #e8f2f8;
    outline: 0;
    box-shadow: 0 0 0 3px rgba(30, 95, 138, 0.1);
}
.col-form-label { font-size: 0.875rem; font-weight: 500; color: #1e293b; margin-bottom: 0.25rem; display: block; }
.btn { font-weight: 500; font-size: 0.875rem; border-radius: 8px; }
.btn-success { background: #059669; border-color: #059669; color: #fff; }
.btn-success:hover { background: #047857; border-color: #047857; color: #fff; }
.btn-danger { background: #dc2626; border-color: #dc2626; color: #fff; }
.btn-danger:hover { background: #b91c1c; border-color: #b91c1c; color: #fff; }
.btn-icon-split .text { font-size: 0.75rem; padding: 0.4rem 4px; }
.btn-icon-split .icon { background: rgba(0,0,0,0.1); display: inline-block; padding: 0.375rem 0.75rem; border-radius: 8px 0 0 8px; }

</style>

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
