<style>
.form-footer {
    color: #fff;
    display: flex;
    justify-content: flex-start;
}

.form-footer .btn {
    color: #fff;
}
.dropdown-menu {
    margin-top: 0px !important;
}
.center-align {
    display: flex;
    justify-content: center;
}
.modal-footer .btn {
    padding: 5px 10px;
}

.filled-str {
    color: #e6e63a
}

.order-count-cotainer {
    display: flex;
    justify-content: space-between;
    margin-bottom: 20px;
}

.card-body .btn {
    width: auto;
}

.modal-body {
    height: auto;
}
.survey-error {
    text-align: center;
    color: red;
    font-weight: bold;
}
</style>

<div class="pct-admin-listing">
    <!-- Page Header -->
    <div class="page-header">
        <h1><i class="fas fa-star"></i> View Survey Results</h1>
    </div>

    <!-- Survey Results Card -->
    <div class="modern-card">
        <div class="modern-card-body">
            <div class="col-xs-12">
                
                <div class="typography-section__inner">
                    <div class="row">
                        <div class="col-sm-12">
                            <h2 class="ui-title-block ui-title-block_light fs-28">View Survey Results</h2>
                            <div class="ui-decor-1a bg-accent"></div>
                            <div class="sales-user-listing mb-4">
                                <h4 class="ui-title-block_light fs-16">Below are the results for the following unit: </h4>
                                <div id="sales_user_listing">
                                    <label>
                                        <select style="width:auto;" name="title_officer_list" id="title_officer_list" class="custom-select custom-select-sm form-control form-control-sm">
                                            <?php 
                                            if (!empty($title_officer_list)) {
                                            foreach ($title_officer_list as $key => $value) { ?>
                                            <option value="<?php echo $value['id']; ?>"><?php echo $value['title']; ?></option>
                                            <?php }}?>
                                        </select>
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row mb-4">
                    <div class="col-sm-12">
                        <div class="row mb-2" >
                            <div class="col-md-1 col-sm-12 title text-primary center-align"></div>
                            <div class="col-md-2 col-sm-12 title text-primary center-align">SERVICE SATISFACTION</div>
                            <div class="col-md-2 col-sm-12 title text-success center-align">TRANSACTION EXPERIENCE</div>
                            <div class="col-md-2 col-sm-12 title text-info center-align">COMMUNICATION</div>
                            <div class="col-md-2 col-sm-12 title text-warning center-align">HELPFULNESS</div>
                            <div class="col-md-2 col-sm-12 title text-danger center-align">REFER</div>
                            <div class="col-md-1 col-sm-12 title center-align"></div>
                        </div>
                        <?php 
                        ?>
                        <div class="row survey-cards">
                        <?php if (isset($error) && $error) { ?>
                            <p class="survey-error"><?php echo $error; ?></p>
                            
                        <?php } else {
                            echo $survey_cards; 
                        }
                        ?>
                        </div>
                        <?php ?>
                    </div>
                </div>
                <div class="order-count-cotainer">
                    <h3 class="ui-title-block_light">Below is list of all survey response.</h3>
                    <a href="javascript:void(0)" class="btn-action btn-action-success" onclick="$('#send_sample_email').modal('show')">
                                <i class="fas fa-plus"></i> Send Sample Email</a>
                            
                </div>	
                
                <div class="modern-card">
                    <div class="modern-card-body">
                        <div class="table-responsive survey-table">
                            <?php 
                                if (isset($error) && $error) { ?>
                                    <p class="survey-error"><?php echo $error; ?></p>
                                <?php } else {
                                    echo $survey_rating_details; 
                                }
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="send_sample_email" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document" style="width: 40%;">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><i class="fas fa-paper-plane"></i> Send Sample Email</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="w-100 alert alert-danger alert-dismissible surveys_error_msg" style="display:none;"></div>
                <div class="form-group">
                    <label for="email_address" class="col-form-label">Email Address</label>
                    <input name="email_address" required="" type="text" class="form-control" id="email_address">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" id="send_sample_mail_btn" data-btntext-sending="Sending..." class="btn-action btn-action-primary">
                    <i class="fas fa-check"></i> Send
                </button>
                <button type="reset" data-dismiss="modal" aria-label="Close" class="btn-action btn-action-secondary">
                    <i class="fas fa-ban"></i> Cancel
                </button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="commentModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document" style="width: 40%;">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><i class="fas fa-comments"></i> Comments List</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <ul id="commentList" class="list-group">
                    <!-- List items will be added dynamically here -->
                </ul>
            </div>
            <div class="modal-footer">
                <button type="reset" data-dismiss="modal" aria-label="Close" class="btn-action btn-action-secondary">
                    <i class="fas fa-times"></i> Close
                </button>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).on('click', '#send_sample_mail_btn', function() {
        console.log('send_sample_mail_btn');
        $('#surveys_error_msg').hide();
        var email_address = $('#email_address').val();
        if (!email_address) {
            $('#surveys_error_msg, .surveys_error_msg').html('Please enter email address.').show();
            setTimeout(function () {
                $('#surveys_error_msg, .surveys_error_msg').html('').hide();
            }, 5000);
            return;
        }
        $.ajax({
            url: base_url + "send-survey-sample-email",
            method: "POST",
            data: {
                email_address: $('#email_address').val()
            },
            success: function (data) {
                var result = jQuery.parseJSON(data);
                $('#send_sample_email').modal('hide');
                $('#surveys_success_msg').html(result.message).show();
            },
            error: function (XMLHttpRequest, textStatus, errorThrown) {
                $('#send_sample_email').modal('hide');
                $('#surveys_error_msg').html('Something went wrong. Please try it again.').show();
                $([document.documentElement, document.body]).animate({
                    scrollTop: $("#surveys_success_msg").offset().top
                }, 1000);

                setTimeout(function () {
                    $('#surveys_error_msg').html('').hide();
                }, 5000);
            }
        });
    });
    $(document).ready(function() {
    });
    function displayComment(commentsArray) {
        $("#commentList").html("");
        if (commentsArray.length > 0) {
            let listHtml = "";
            commentsArray.forEach(function (comment) {
                listHtml += `<li class="list-group-item">${comment}</li>`;
            });
            $("#commentList").html(listHtml);
            $("#commentModal").modal("show");
        }
    }
</script>
