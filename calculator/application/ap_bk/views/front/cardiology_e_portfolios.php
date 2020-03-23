

			<div class="row">
				<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
					<p class="breadkaram"><a href="<?=base_url()?>">Home</a> <i class="fa fa-angle-right"></i> <a href="<?=base_url()?>index.php/user/all_e_portfolio">All Reposits </a><i class="fa fa-angle-right"></i> <?=$uri?></p>
				</div>
			</div>
			<div class="row">
				<!-- start middle content -->
				
				<div class="col-xs-12 col-sm-12 col-md-3 col-lg-3 ">

					<h2 class="main-title">Specialities</h2>
					<div class="box">
						<div class="side-bar-margin">
							<ul class="sideNav">
                      <?php $name = "" ; foreach ($departments as $key):    $name = str_replace(" ", "-", $key->departmentname); ?>
						<li>
							<a href="<?=base_url()?>index.php/user/e_portfolios/<?=$name?>"><i><img src="<?=base_url()?>assets/front/images/icon/<?=$key->departmentname?>.jpg"></i> <?=$key->departmentname?></a>

						</li>

					<?php endforeach ?>
                    	</ul>
						</div>
						<div class="clr"></div>
					</div>
				</div>
				<!-- end left tab -->
				<div class="col-xs-12 col-sm-10 col-md-9 col-lg-9 left-border">
					<h3 class="inner-title"><?=$uri?></h3>
					
					<div class="row margin-top20">
					<?php if (sizeof($top_dept_users)): ?>
						
						<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
							<!-- start doctor list -->
							<?php foreach ($dept_users as $key): ?>
								<div class="row margin-top20 box-shadow">
								<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
									<div class="row">
										<div class="col-xs-4 col-sm-2 col-md-2 col-lg-2">
											<div class="doctor-photo-bg1 ">
												<a href="<?=base_url()?>index.php/user/user_articles/<?=$key->slug?>"><img src="<?=base_url()?>upload/user/<?=$key->userid?>/<?=$key->profilepic?>" class="imgResponsive" onerror=" this.src = '<?=base_url()?>assets/front/images/doctor.png'"></a>
											</div>
										</div>
										<div class="col-xs-8 col-sm-10 col-md-7 col-lg-7 nill_4">
											<p class="landing-text1"><b><a href="<?=base_url()?>index.php/user/user_articles/<?=$key->slug?>"><?=ucfirst($key->salutation." ".ucfirst($key->fname)." ".ucfirst($key->lname));?></a></b><br>
											<?=$key->designation?><br>
											<?=$key->current_position?>
										</div>
									</div>
								</div>
							</div>
							<hr class="innerBorder">
							<?php endforeach ?>
							
							
							<!-- end doctor list -->
						<div class="pageButton">
                            <ul>
                            	 <?=$page_links;?>
                               
                            </ul>
                        </div>
                        </div>
					<?php else: ?>
						<br>
						<div class="alert alert-danger">
							<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
							<span> No Articles.</span>
						</div>
						
					
						<?php endif ?>
					</div>

				</div>
				<!-- end middle content -->
	
</div>


<div class="clearfix"></div>
</div>
<?php include('right_content.php');?>
</div>
</div>
	<!-- end main content -->
