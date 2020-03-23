
				<div class="container">
					<div class="content-wrapper">
						<section id="content">
							<?php include 'ext-menu.php';?>
							<ol class="breadcrumb">
								<li><a href="<?php echo base_url(); ?>">Home</a></li>
								<li class="active">External Jobs Application</li>
							</ol>
							<div class="clearfix"></div>
							<div class="panel panel-default flat">
								<div class="panel-body">
									<div class="row">
										<div class="col-xs-12 col-sm-8">
											<h3 class="text-uppercase  no-margin margin-top-5 ">Job Description</h3>
										</div>
										
										<div class="col-xs-12 col-sm-6 col-md-4 col-lg-4 text-right">
											<div class="btn-group "><a href="<?=base_url()?>external-jobs">
												
											<button type="button" class="btn btn-primary btn-sm" >External Jobs Application Openings</button></a>
										</div>
									</div>
									
								</div>
								<hr>

								<h3><?=$job_desc->job_title?></h4>
								<ul class="nav ">
									<li ><strong>Company Name: </strong><?=$job_desc->company_name?></li>
									<li ><strong>Location: </strong><?=$job_desc->location?></li>
									<li ><strong>Job Function: </strong><?=$job_desc->job_function?></li>
									<li ><strong>Job Type: </strong><?=$job_desc->job_type?></li>
									<li ><strong>Experience: </strong><?=$job_desc->experience?></li>
								</ul>
								<hr>
								<div class="clearfix">
									
								</div>
								<div class="row">
									<div class="col-xs-12 col-sm-12">
										<h5 class="no-margin"><b>Job Description</b></h5>
										<p><?=$job_desc->job_description?></p>
										
										<h5 class="no-margin"><b>Desired Qualification </b></h5>
										<?=$job_desc->desired_qualification?>

										<h5 class="no-margin"><b>Compensation package </b></h5>
										<p><?=$job_desc->compensation_package?></p>


									</div>
									
								</div>
								<a type="button" href="<?=$job_desc->apply_from?>" class="btn btn-primary">Apply on Company site</a>
							</div>
						</section>
						