
				<div class="container">
					<div class="content-wrapper">
						<section id="content">
							<?php include 'ext-menu.php';?>
							<ol class="breadcrumb">
								<li><a href="<?php echo base_url(); ?>">Home</a></li>
								<li class="active"><?=$uri?></li>
							</ol>
							<div class="clearfix"></div>
							<div class="row">
								<div class="col-md-3 pro-nav">
									
									<div class="panel panel-default flat">
										<div class="my-account-sidebar">
											
											<!-- start main side bar tab -->
											<div class="sidebar-nav">
											    <ul class="cat-nav1">
													 <?php $name = "" ; foreach ($departments as $key):    $name = str_replace(" ", "-", $key->departmentname); ?>
													<li>
														<a <?=($name==$uri)?'class="active"':NULL?> href="<?=base_url()?>speciality/<?=$name?>"><i><img src="<?=base_url()?>assets/front/images/icon/<?=$key->departmentname?>.jpg"></i> <?=$key->departmentname?></a>

													</li>

												<?php endforeach ?>					
																		
																		
												</ul>
											</div>
									
											
												
												<!-- end main side bar tab -->
												
											</div>
										</div>
										
									</div>
									
									
									<div class="col-xs-12 col-sm-9 col-md-9 col-lg-9 pro-content">
										
										
										
										<div class="panel panel-default flat">
											<div class="panel-body">
												
												<div class="row">
													<!-- start middle content -->
													
													<!-- end left tab -->
													
													<h3 class="panel-title" style="margin-top: -5px; padding-bottom: 5px; border-bottom: 1px solid rgb(204, 204, 204);"><?=$uri?> Profiles</h3>
													<p></p>
													<div >
														<!-- start doctor list -->
													<ul class="nav user-nav">
													<?php foreach ($dept_users as $key): ?>
													<li>
																<div class="row ">
																	<div class="col-xs-4 col-sm-2 col-md-2 col-lg-2">
																		<div class="well well-sm " >
																			<a href="<?=base_url()?>index.php/user/user_articles/<?=$key->slug?>"><img src="<?=base_url()?>upload/user/<?=$key->userid?>/<?=$key->profilepic?>" class="img-responsive" onerror=" this.src = '<?=base_url()?>assets/front/images/doctor.png'"></a>
																		</div>
																	</div>
																	<div class="col-xs-8 col-sm-10 col-md-7 col-lg-7 ">
																		<p ><b><a href="<?=base_url()?>index.php/user/user_articles/<?=$key->slug?>"><?=ucfirst($key->salutation." ".ucfirst($key->fname)." ".ucfirst($key->lname));?></a></b><br>
																		<?=$key->designation?><br>
																		<?=$key->current_position?></p>
															
														</div>
												

													</div>
													</li>
													<?php endforeach ?>
													</ul>
								<div class="clearfix">
									
								</div>
								<ul class="pagination pagination-sm pull-right">
									<?=$page_links;?>
								</ul>
							</div>
							
							
							
							
						</div>
						
						
					</div>
					<!-- end middle content -->
				</div>
			</div>
		</div>
	</section>
	