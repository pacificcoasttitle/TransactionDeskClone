<section class="section-type-4a section-default typography-section-border" style="padding-bottom:0px;">
    <div class="container">
        <div class="row">
            <div class="row">
                <div class="col-xs-12">
                    <div class="typography-section__innera">
                        <?php $userdata = $this->session->userdata('hr_user');?>
						<div class="row">
							<div class="col-sm-8">
								<h2 class="ui-title-block ui-title-block_light">Welcome <?php echo $userdata['name'];?>,</h2>
							</div>
							<div class="col-sm-4">
							<div class="pull-right row">
								<?php
								$clock_in_cls = '';
								$clock_out_cls = 'hide';
								if($clock_event == 'OUT'):
									$clock_in_cls = 'hide';
									$clock_out_cls = '';
								endif;
								?>
								<div id="timeClock" class="col-sm-6"></div>
								<div class="col-sm-6">

									<button type="button" class="btn btn-warning time-start track-time-btn <?php echo $clock_in_cls; ?>">Start Timer</button>
									<button type="button" class="btn btn-warning time-stop track-time-btn <?php echo $clock_out_cls; ?>">Stop Timer</button>
								</div>
							</div>
							</div>

						</div>
                        <div class="ui-decor-1a bg-accent"></div>
                        <h3 class="ui-title-block_light">How can we help you today?</h3>
                    </div>
                    <div class="typography-sectionButton">
                        <div class="col-md-12">
                            <div class="col-md-4">
                                <a href=https://myapps.paychex.com/landing_remote/login.do?TYPE=33554433&REALMOID=06-fd3ba6b8-7a2f-1013-ba03-83af2ce30cb3&GUID=&SMAUTHREASON=0&METHOD=GET&SMAGENTNAME=-SM-DcRXd3RBkM%2bIAuUkJhio4qMQPGHXSlwC5NHvGd60RCkP6guTqWS4qLnJtYdJd9Ge&TARGET=-SM-https%3a%2f%2fmyapps%2epaychex%2ecom%2f" target="_blank">
                                    <div class="buttonOuter">
                                        <button class="btn2 btn-type-6a btn-lg2" type="button">
                                            <img src="<?php echo base_url(); ?>assets/media/hr/paychex.png" class="buttImg">
                                            <p class="buttP">Access Paychex</p>
                                        </button>
                                    </div>
                                </a>
                            </div>
                            <div class="col-md-4">
                                <a href="<?php echo base_url(); ?>hr/profile"> 
                                    <div class="buttonOuter">
                                        <button class="btn2 btn-type-6a btn-lg2" type="button">
                                            <img src="<?php echo base_url(); ?>assets/media/hr/profile.png" class="buttImg">
                                            <p class="buttP">My Profile</p>
                                        </button>
                                    </div>
                                </a>
                            </div>
                            <div class="col-md-4">
                                <a href="<?php echo base_url(); ?>hr/time-cards">
                                    <div class="buttonOuter">
                                        <button class="btn2 btn-type-6a btn-lg2" type="button">
                                            <img src="<?php echo base_url(); ?>assets/media/hr/timecard.png" class="buttImg">
                                            <p class="buttP">Time Cards</p>
                                        </button>
                                    </div>
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="typography-sectionButton-2">
                        <div class="col-md-12">
                            <div class="col-md-4">
                                <a href="<?php echo base_url(); ?>hr/vacation-requests">
                                    <div class="buttonOuter">
                                        <button class="btn2 btn-type-6a btn-lg2" type="button">
                                            <img src="<?php echo base_url(); ?>assets/media/hr/vacation.png" class="buttImg">
                                            <p class="buttP">Vacation Requests</p>
                                        </button>
                                    </div>
                                </a>
                            </div>
                            <div class="col-md-4">
                                <a href="<?php echo base_url(); ?>hr/trainings">
                                    <div class="buttonOuter">
                                        <button class="btn2 btn-type-6a btn-lg2" type="button">
                                            <img src="<?php echo base_url(); ?>assets/media/hr/training.png" class="buttImg">
                                            <p class="buttP">Trainings</p>
                                        </button>
                                    </div>
                                </a>
                            </div>
                            <div class="col-md-4">
                                <a href="<?php echo base_url(); ?>hr/incident-reports">
                                    <div class="buttonOuter">
                                        <button class="btn2 btn-type-6a btn-lg2" type="button">
                                            <img src="<?php echo base_url(); ?>assets/media/hr/incident.png" class="buttImg">
                                            <p class="buttP">Report Incident</p>
                                        </button>
                                    </div>
                                </a>
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
            <div class="col-xs-12" style="padding:50px;">
                <div class="typography-section__innera">
                    <h2 class="ui-title-block ui-title-block_light">Vacation Requests Calendar,</h2>
                    <div class="ui-decor-1a bg-accent"></div>
                </div>
                <div id='loading'>loading...</div>	
                <div id='calendar'></div>
            </div>1
        </div>
    </div>
</section>
