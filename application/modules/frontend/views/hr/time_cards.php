<section class="section-type-4a section-defaulta" style="padding-bottom:0px;">
    <div class="container">
        <div class="row">
            <div class="row">
                <div class="col-xs-12">
                    <div class="typography-section__inner">
                        <h2 class="ui-title-block ui-title-block_light">Timecard Exception Form,</h2>
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
                                    <form data-parsley-validate="" method="post" action="<?php echo base_url();?>hr/save-time-cards" id="time-cards-form">
                                        <div class="form-body">
                                            <div id="time-cards-clone-group-fields">
                                                <div class="toclone clone-widget">
                                                    <div class="frm-row">
                                                        <div class="spacer-b10 colm colm3">
                                                            <label class="field prepend-icon">
                                                                <input type="text" name="exception_date[]" id="exception_date" class="gui-input exp_date" placeholder="Exception Date" readonly required>
                                                                <span class="field-icon"><i class="fa fa-calendar-o"></i></span>
                                                            </label>
                                                        </div>
                                                        <div class="spacer-b10 colm colm2">
                                                            <label class="field select">
                                                                <select id="reg_hours" name="reg_hours[]" required>
                                                                    <option value="">Reg Hours</option>
                                                                    <option value="1">1</option>
                                                                    <option value="2">2</option>
                                                                    <option value="3">3</option>
                                                                    <option value="4">4</option>
                                                                    <option value="5">5</option>
                                                                    <option value="6">6</option>
                                                                    <option value="7">7</option>
                                                                    <option value="8">8</option>
                                                                </select>
                                                                <i class="arrow double"></i>
                                                            </label>
                                                        </div>
                                                        <div class="spacer-b10 colm colm2">
                                                            <label class="field select">
                                                                <select id="ot_hours" name="ot_hours[]" required>
                                                                    <option value="">OT Hours</option>
                                                                    <option value="1">1</option>
                                                                    <option value="2">2</option>
                                                                    <option value="3">3</option>
                                                                    <option value="4">4</option>
                                                                    <option value="5">5</option>
                                                                    <option value="6">6</option>
                                                                    <option value="7">7</option>
                                                                    <option value="8">8</option>
                                                                </select>
                                                                <i class="arrow double"></i>
                                                            </label>
                                                        </div>
                                                        <div class="spacer-b10 colm colm2">
                                                            <label class="field select">
                                                                <select id="double_ot" name="double_ot[]" required>
                                                                    <option value="">Double OT</option>
                                                                    <option value="1">1</option>
                                                                    <option value="2">2</option>
                                                                    <option value="3">3</option>
                                                                    <option value="4">4</option>
                                                                    <option value="5">5</option>
                                                                    <option value="6">6</option>
                                                                    <option value="7">7</option>
                                                                    <option value="8">8</option>
                                                                </select>
                                                                <i class="arrow double"></i>
                                                            </label>
                                                        </div>
                                                        <div class="spacer-b10 colm colm2">
                                                            <label class="prepend-icon">
                                                                <input type="text" name="total_hours[]" id="total_hours" class="gui-input" placeholder="Total Hours" readonly>
                                                                <span class="field-icon"><i class="fa fa-user"></i></span>
                                                            </label>
                                                        </div>

                                                        <div class="spacer-b10 colm colm11">
                                                            <label for="comment" class="field-label"> Questions &amp; Comments </label>
                                                            <label for="comment" class="field prepend-icon">
                                                                <textarea class="gui-textarea" id="comment" name="comment[]" placeholder="Your question or comment" required></textarea>
                                                                <span class="field-icon"><i class="fa fa-comments"></i></span>
                                                                <span class="input-hint">
                                                                    <strong>Please:</strong> Be as descriptive as possible
                                                                </span>
                                                            </label>
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
                        <h2 class="ui-title-block ui-title-block_light">Timecard Submission History,</h2>
                        <div class="ui-decor-1a bg-accent"></div>
                        <h3 class="ui-title-block_light">Below is a detail of all your requests.</h3>
                    </div>
                    <div class="typography-sectiona">
                        <div class="col-md-12">
                            <div class="table-container">
                                <table class="table table-type-3 typography-last-elem" id="time_card_listing">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Employee</th>
                                            <th>Date</th>
                                            <th>Reg Hours</th>
                                            <th>OT Hours</th>
                                            <th>Double OT</th>
                                            <th>Total Hours</th>
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