

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
