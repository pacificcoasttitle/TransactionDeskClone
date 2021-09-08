<section class="section-type-4a section-defaulta" style="padding-bottom:0px;">
    <div class="container">
        <div class="row">
            <div class="row">
                <div class="col-xs-12">
                    <div class="typography-section__inner">
                        <h2 class="ui-title-block ui-title-block_light">Vacation Request Form,</h2>
                        <div class="ui-decor-1a bg-accent"></div>
                        <h3 class="ui-title-block_light">Use the form below to report your time exception.</h3><br>
                        <h4 class="ui-title-block_light"><strong>Employee Name:</strong> <?php echo $name;?>.</h4>
                        <h4 class="ui-title-block_light"><strong>Today's Date:</strong> <?php echo date('m/d/Y');?></h4>
                        <h4 class="ui-title-block_light"><strong>Manager Name:</strong> </h4>
                    </div>
                    <div class="typography-sectionabcde">
                        <div class="col-md-12">
                            <div class="smart-wrap">
                                <div class="smart-forms smart-container wrap-4">
                                    <?php if(!empty($success)) {?>
                                        <div id="time_card_success_msg" class="w-100 alert alert-success alert-dismissible">
                                            <?php foreach($success as $sucess) {
                                                echo $sucess."<br \>";	
                                            }?>
                                        </div>
                                    <?php } 
                                    if(!empty($errors)) {?>
                                        <div id="time_card_error_msg" class="w-100 alert alert-danger alert-dismissible">
                                            <?php foreach($errors as $error) {
                                                echo $error."<br \>";	
                                            }?>
                                        </div>
                                    <?php } ?>
                                    <form data-parsley-validate="" method="post" action="<?php echo base_url();?>hr/save-vacation-requests" id="vacation-requests-form">
                                        <div class="form-body">
                                            <div id="vacation-requests-clone-group-fields">
                                                <div class="toclone clone-widget">
                                                    <div class="frm-row">
                                                        <div class="spacer-t10 spacer-b10 colm colm5">
                                                            <label class="field prepend-icon">
                                                                <input type="text" name="from_dates[]" id="from_dates" class="gui-input from_date" placeholder="From Date" readonly required>
                                                                <span class="field-icon"><i class="fa fa-calendar-o"></i></span>
                                                            </label>
                                                        </div>

                                                        <div class="spacer-t10 spacer-b10 colm colm5">
                                                            <label class="field prepend-icon">
                                                                <input type="text" name="to_dates[]" id="to_dates" class="gui-input to_date" placeholder="To Date " readonly required>
                                                                <span class="field-icon"><i class="fa fa-calendar-o"></i></span>
                                                            </label>
                                                        </div>

                                                        <div class="spacer-t10 colm colm10">
                                                            <label for="comment" class="field prepend-icon">
                                                                <textarea class="gui-textarea" id="comments" name="comments[]" placeholder="Your question or comment" required></textarea>
                                                                <span class="field-icon"><i class="fa fa-comments"></i></span>
                                                                <span class="input-hint">
                                                                    <strong>Please:</strong> Be as descriptive as possible
                                                                </span>
                                                            </label>
                                                        </div>

                                                        <div class="spacer-t10 colm colm10">
                                                            <div class="option-group field">
                                                                <div class="section colm colm6">
                                                                    <label class="option block">
                                                                        <input type="checkbox" id="is_salary_deductions" name="is_salary_deductions[]">
                                                                        <span class="checkbox"></span> Salary Deduction(s) be made for such time
                                                                    </label>
                                                                </div>

                                                                <div class="section colm colm5">
                                                                    <label class="option block">
                                                                        <input type="checkbox" id="is_time_charged_vacations" name="is_time_charged_vacations[]">
                                                                        <span class="checkbox"></span> The time is charged against vacation
                                                                    </label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <a href="#" class="clone button btn-primary"><i class="fa fa-plus"></i></a>
                                                    <a href="#" class="delete button"><i class="fa fa-minus"></i></a>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-footer">
                                            <button type="submit" class="button btn-primary"> Send Form </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="section-type-4a section-defaulta" style="padding-bottom:0px;">
    <div class="container">
        <div class="row">
            <div class="row">
                <div class="col-xs-12">
                    <div class="typography-section__inner">
                        <h2 class="ui-title-block ui-title-block_light">Vaction Request History,</h2>
                        <div class="ui-decor-1a bg-accent"></div>
                        <h3 class="ui-title-block_light">Below is a detail of all your requests.</h3>
                    </div>
                    <div class="typography-sectiona">
                        <div class="col-md-12">
                            <div class="table-container">
                                <table class="table table-type-3 typography-last-elem" id="vacation_requests_listing">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Employee</th>
                                            <th>From Date</th>
                                            <th>To Date</th>
                                            <th>Salary Deduction</th>
                                            <th>Time Charged Vacation</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        
                                    </tbody>
                                </table>
                                <div class="typography-sectionab"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>