
				<div class="container">
					<div class="content-wrapper">
						<section id="content">
							<?php include 'ext-menu.php'; ?>
							<ol class="breadcrumb">
								<li><a href="<?php echo base_url(); ?>">Home</a></li>
								<li class="active">Career At MyReposit</li>
							</ol>
							<div class="clearfix"></div>
							<div class="panel panel-default flat">
								<div class="panel-body">
									<div class="row">
										<div class="col-xs-12 col-sm-10">
											<h3 class="text-uppercase  no-margin  "><?=$job_desc->job_title?></h3>
										</div>
										
										<div class="col-xs-12 col-sm-6 col-md-2 col-lg-2 text-right">
											<div class="btn-group "><a href="<?=base_url()?>career">
												
											<button type="button" class="btn btn-primary btn-sm" >Job Openings</button></a>
										</div>
									</div>
									
								</div>
								<hr>
								<ul class="nav nav-pills nav-space">
									<li ><strong>Location: </strong><?=$job_desc->location?></li>
									<li ><strong>Department: </strong><?=$job_desc->department?></li>
									<li ><strong>Type: </strong><?=$job_desc->type?></li>
									<li ><strong>Min. Experience: </strong><?=$job_desc->min_exp?></li>
								</ul>
								<hr>
								<div class="clearfix">
									
								</div>
								<div class="row">
									<div class="col-xs-12 col-sm-6">
										<h5><b>Job Description</b></h5>
										<?=$job_desc->job_desc?>
										
										<h5><b>Skill Required</b></h5>
										<?=$job_desc->skill_req?>
										
									</div>
									<div class="col-xs-12 col-sm-6">
										<form class="" action="<?=base_url()?>index.php/welcome/apply_job/" method="post" enctype="multipart/form-data">
											<h3>To Apply for this position, fill the form below</h3>
											<p class="pull-right"><swap>*</swap> Required fields</p>
											<div class="form-group">
												<label class="control-label"><swap>* </swap>First Name</label>
												<input type="text" name="fname" pattern="^[ a-zA-Z]+$" id="input" class="form-control" required="required">
											</div>
											<div class="form-group">
												<label class="control-label"><swap>* </swap>Last Name</label>
												<input type="text" name="lname" pattern="^[ a-zA-Z]+$" id="input" class="form-control" required="required">
											</div>
											<div class="form-group">
												<label class="control-label"><swap>* </swap>Email Address</label>
												<input type="email" name="email" id="input" class="form-control" required="required">
											</div>
											<div class="form-group">
												<label class="control-label"><swap>* </swap>Location</label>
												<input type="text" name="location" id="input" class="form-control" required="required" placeholder="Address">
												<div class="form-group"></div>
												<div class="row">
													<div class="col-cs-12 col-sm-6">
														<input name="city" type="text" pattern="^[ a-zA-Z]+$"  required="required" class="form-control" placeholder="City">
													</div>
													<div class="col-cs-12 col-sm-3">
														<input  name="state" type="text" pattern="^[ a-zA-Z]+$" required="required"  class="form-control" placeholder="State">
													</div>
													<div class="col-cs-12 col-sm-3">
														<input name="zipcode" type="text" class="form-control" required="required"  placeholder="Postal">
													</div>
												</div>
											</div>
											<div class="form-group">
												<label class="control-label"><swap>* </swap>Phone </label>
												<input type="text" name="phone" pattern="^[ 0-9]+$" maxlength="10" id="input" class="form-control" required="required">
											</div>
											<div class="form-group">
												<label class="control-label">LinkedIn profile URL </label>
												<input type="url" name=""  maxlength="10" id="input" class="form-control" required="required">
											</div>


											<div class="form-group">
												<label class="control-label"><swap>* </swap>Resume</label><br>
												<input type="file" name="userfile1" id="input"  required="required">
											</div>
											<input type="hidden" name="job_post_id" id="inputJob_id" class="form-control" value="<?=$job_desc->job_id?>">
											
											
											<div class="form-group">
												<label class=""><swap>* </swap>Describe in 150 words why we should consider your application.</label>
												<textarea maxlength="150" name="brief" id="input" class="form-control" rows="5" required="required"></textarea>
												
											</div>
											
											<button class="btn btn-primary btn-block">Submit Application</button>
										</form>
									</div>
								</div>
							</div>
						</section>
						