<style>
/* Survey Results – same design tokens as dashboard */
.pct-home-modern {
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

/* Page header */
.pct-home-modern .pct-page-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    flex-wrap: wrap;
    gap: 1rem;
    margin-bottom: 1.5rem;
}
.pct-home-modern .pct-page-title { font-size: 1.5rem; font-weight: 600; color: var(--pct-text); margin: 0; }
.pct-home-modern .pct-page-sub { font-size: 0.9375rem; color: var(--pct-text-muted); margin: 0.25rem 0 0; }

/* All dropdowns with arrow indicator */
.pct-home-modern select,
.pct-home-modern .custom-select {
    border: 1px solid var(--pct-border);
    border-radius: var(--pct-radius-sm);
    padding: 0.375rem 2rem 0.375rem 0.75rem;
    font-size: 0.875rem;
    color: var(--pct-text);
    background: var(--pct-surface) url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 12 12'%3E%3Cpath fill='%2364748b' d='M2 4l4 4 4-4'/%3E%3C/svg%3E") no-repeat right 0.75rem center;
    background-size: 12px;
    -webkit-appearance: none;
    -moz-appearance: none;
    appearance: none;
    cursor: pointer;
}
.pct-home-modern select:focus,
.pct-home-modern .custom-select:focus {
    border-color: var(--pct-primary);
    outline: 0;
    box-shadow: 0 0 0 3px rgba(30, 95, 138, 0.1);
}

/* Card styling */
.pct-home-modern .card {
    border: 1px solid var(--pct-border);
    border-radius: var(--pct-radius);
    box-shadow: var(--pct-shadow);
    overflow: hidden;
}
.pct-home-modern .card-header.py-3 {
    background: var(--pct-surface-2);
    border-bottom: 1px solid var(--pct-border);
    padding: 1rem 1.25rem;
}
.pct-home-modern .card-header .font-weight-bold {
    font-size: 1rem;
    font-weight: 600;
    color: var(--pct-text);
}
.pct-home-modern .card-body { padding: 1.25rem; background: var(--pct-surface); }

/* Survey category headers */
.pct-home-modern .survey-categories {
    display: flex;
    gap: 0.5rem;
    margin-bottom: 1rem;
    flex-wrap: wrap;
}
.pct-home-modern .survey-categories .category-header {
    flex: 1;
    min-width: 120px;
    text-align: center;
    font-size: 0.75rem;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.03em;
    padding: 0.5rem;
}
.pct-home-modern .survey-categories .text-primary { color: var(--pct-primary) !important; }
.pct-home-modern .survey-categories .text-success { color: #059669 !important; }
.pct-home-modern .survey-categories .text-info { color: #0891b2 !important; }
.pct-home-modern .survey-categories .text-warning { color: #d97706 !important; }
.pct-home-modern .survey-categories .text-danger { color: #dc2626 !important; }

/* Survey cards container */
.pct-home-modern .survey-cards { gap: 0.5rem; }

/* Section title */
.pct-home-modern .section-title {
    font-size: 0.9375rem;
    color: var(--pct-text-muted);
    margin: 1.5rem 0 1rem;
    font-weight: 400;
}

/* Table styling */
.pct-home-modern .table { margin-bottom: 0; }
.pct-home-modern .table thead th {
    background: var(--pct-surface-2);
    border-bottom: 2px solid var(--pct-border);
    font-size: 0.75rem;
    font-weight: 600;
    color: var(--pct-text);
    text-transform: uppercase;
    letter-spacing: 0.03em;
    padding: 0.625rem 0.75rem;
    text-align: center;
}
.pct-home-modern .table tbody td {
    padding: 0.625rem 0.75rem;
    font-size: 0.875rem;
    color: var(--pct-text);
    border-bottom: 1px solid var(--pct-border);
    vertical-align: middle;
    text-align: center;
}
.pct-home-modern .table tbody tr:hover { background: var(--pct-primary-soft); }
.pct-home-modern .table tbody tr:last-child td { border-bottom: none; }

/* Survey error */
.pct-home-modern .survey-error {
    text-align: center;
    color: #dc2626;
    font-weight: 600;
    padding: 2rem;
}

/* Star rating */
.pct-home-modern .filled-str { color: #eab308; }

/* Buttons */
.pct-home-modern .btn {
    font-weight: 500;
    font-size: 0.875rem;
    border-radius: var(--pct-radius-sm);
    transition: opacity .15s ease, background .15s ease, border-color .15s ease;
}
.pct-home-modern .btn-success { background: #059669; border-color: #059669; color: #fff; }
.pct-home-modern .btn-success:hover { background: #047857; border-color: #047857; color: #fff; }
.pct-home-modern .btn-danger { background: #dc2626; border-color: #dc2626; color: #fff; }
.pct-home-modern .btn-danger:hover { background: #b91c1c; border-color: #b91c1c; color: #fff; }
.pct-home-modern .btn-secondary { background: #64748b; border-color: #64748b; color: #fff; }
.pct-home-modern .btn-secondary:hover { background: #475569; border-color: #475569; color: #fff; }
.pct-home-modern .btn-icon-split { display: inline-flex; align-items: center; gap: 0.5rem; }

/* Form controls */
.pct-home-modern .form-control {
    padding: 0.5rem 0.75rem;
    font-size: 0.9375rem;
    border: 1px solid var(--pct-border);
    border-radius: var(--pct-radius-sm);
    color: var(--pct-text);
    background: var(--pct-surface);
}
.pct-home-modern .form-control:focus {
    border-color: var(--pct-primary);
    outline: 0;
    box-shadow: 0 0 0 3px rgba(30, 95, 138, 0.1);
}

/* Modals */
#send_sample_email .modal-content,
#commentModal .modal-content { 
    border-radius: 12px; 
    border: 1px solid #e2e8f0; 
    box-shadow: 0 4px 12px rgba(0,0,0,.08); 
}
#send_sample_email .card,
#commentModal .card { border: none; box-shadow: none; }
.pct-home-modern .modal-footer { border-top: 1px solid var(--pct-border); padding: 1rem; }

/* Alerts */
.pct-home-modern .alert { border-radius: var(--pct-radius-sm); font-size: 0.875rem; }
.pct-home-modern .alert-danger { background: #fee2e2; border-color: #fecaca; color: #991b1b; }

/* List group */
.pct-home-modern .list-group-item {
    border: 1px solid var(--pct-border);
    padding: 0.75rem 1rem;
    font-size: 0.9375rem;
    color: var(--pct-text);
}

/* Form footer */
.pct-home-modern .form-footer {
    display: flex;
    gap: 0.5rem;
    padding: 1rem 0;
}
</style>

<div class="pct-home-modern">
<section class="section-type-4a section-defaulta" style="padding-bottom:0;">
    <div class="container-fluid px-4 py-4">
        <!-- Page Header -->
        <div class="row mb-4">
            <div class="col-12">
                <h1 class="pct-page-title">View Survey Results</h1>
                <div style="display: flex; align-items: center; gap: 0.5rem; flex-wrap: wrap; margin-top: 0.25rem;">
                    <p class="pct-page-sub" style="margin: 0;">Below are the results for the following unit:</p>
                    <div id="sales_user_listing">
                        <select name="title_officer_list" id="title_officer_list" style="width:auto;">
                            <?php 
                            if (!empty($title_officer_list)) {
                            foreach ($title_officer_list as $key => $value) { ?>
                            <option value="<?php echo $value['id']; ?>"><?php echo $value['title']; ?></option>
                            <?php }}?>
                        </select>
                    </div>
                </div>
            </div>
        </div>

        <!-- Survey Category Headers -->
        <div class="survey-categories">
            <div class="category-header" style="flex: 0 0 8%;"></div>
            <div class="category-header text-primary">Service Satisfaction</div>
            <div class="category-header text-success">Transaction Experience</div>
            <div class="category-header text-info">Communication</div>
            <div class="category-header text-warning">Helpfulness</div>
            <div class="category-header text-danger">Refer</div>
            <div class="category-header" style="flex: 0 0 8%;"></div>
        </div>

        <!-- Survey Cards -->
        <div class="row survey-cards">
            <?php if (isset($error) && $error) {
                
            } else {
                echo $survey_cards; 
            }
            ?>
        </div>

        <!-- Survey Response List -->
        <h4 class="section-title">Below is list of all survey response.</h4>
        
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Survey Responses</h6>
            </div>
            <div class="card-body">
                <div class="table-responsive survey-table">
                    <?php if (isset($error) && $error) { ?>
                        <p class="survey-error"><?php echo $error; ?></p>
                    <?php } else { echo $survey_rating_details; }?>
                </div>
            </div>
        </div>
    </div>
</section>
</div>

<!-- Send Sample Email Modal -->
<div class="modal fade" id="send_sample_email" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document" style="width: 40%;">
        <div class="modal-content">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card shadow">
                        <div class="card-header py-3">
                            <div class="w-100 alert alert-danger alert-dismissible surveys_error_msg" style="display:none;"></div>
                            <h6 class="m-0 font-weight-bold text-primary">Send Sample Email</h6>
                        </div>
                        <div class="card-body">
                            <div class="smart-forms smart-container">
                                <div class="modal-body search-result">
                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-sm-12">
                                                <label for="email_address" class="col-form-label">Email Address</label>
                                                <input name="email_address" required="" type="text" class="form-control" id="email_address">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-footer">
                                    <button type="button" id="send_sample_mail_btn" data-btntext-sending="Sending..." class="btn btn-success btn-icon-split btn-sm">
                                        <span class="icon text-white-50"><i class="fas fa-check"></i></span>
                                        <span class="text">Send</span>
                                    </button>
                                    <button type="reset" data-dismiss="modal" aria-label="Close" class="btn btn-danger btn-icon-split btn-sm">
                                        <span class="icon text-white-50"><i class="fas fa-ban"></i></span>
                                        <span class="text">Cancel</span>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Comment Modal -->
<div class="modal fade" id="commentModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document" style="width: 40%;">
        <div class="modal-content">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card shadow">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Comments List</h6>
                        </div>
                        <div class="card-body">
                            <div class="smart-forms smart-container">
                                <ul id="commentList" class="list-group">
                                    <!-- List items will be added dynamically here -->
                                </ul>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="reset" data-dismiss="modal" aria-label="Close" class="btn btn-secondary btn-icon-split btn-sm">
                                <span class="text">Close</span>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    
</script>
