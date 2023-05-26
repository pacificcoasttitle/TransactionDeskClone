<style>
	body {
		font-family: Nunito,-apple-system,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,sans-serif,"Apple Color Emoji","Segoe UI Emoji","Segoe UI Symbol","Noto Color Emoji";
	}
	.dropdown-btn {
		border: none;
		background: none;
		width: 100%;
		text-align: left;
		color: #04415D;
		background: #ffffff;
		width: 100%;
		border-bottom: 2px #D0D0D0 dotted;
		padding: 10px 15px 10px 0;
	}

	.dropdown-container {
		display: none;
	}

	.active {
		border :none;
	}

	.fa-caret-down {
		float: right;
		padding-right: 8px;
	}

	.review_li {
		float: left;
		width: 100%;
		font-size: 20px;
	}

	.review_li ol {
		list-style-type: none;
	}

	.review_li ol  li {
		font-size: 15px;
	}

	.linked_doc {
		float: left;
		padding: 5px 0px 10px 0;
		border: none !important;
		font-weight:bold;
	}

	.yamm2 {
		flex-direction: column;
	}
	.yamm2 li a {
		width:100%;
	}

	.yamm2 li a:hover {
		width:100%;
	}

	button:focus {
		outline:0;
	}

	.wrapper-alignment {
		display: flex;
		flex-direction: row;
		justify-content: space-between;
		width: 100%;
	}

	.fn-36 {
		font-size: 36px;
	}

	.fs-20 {
		font-size: 20px;
	}

	.nav-bottom-border {
		border-bottom: 2px #D35411 dotted !important;
	}
	.ui-decor-3 {
		border-bottom: 1px solid #D35411
	}
	.ui-decor-3:after {
		background-color: #D35411;
	}
</style>

<!-- <section class="section-type-4a section-defaulta" style="padding-bottom:0px;"> -->
	<div class="container-fluid">
		<div class="card shadow mb-4">
			<div class="card-body">
				<div class="col-xs-12">
					<div class="typography-section__inner mt-0">
						<h2 class="ui-title-block ui-title-block_light fn-36">Preliminary Report Review</h2>
						<div class="ui-decor-1a bg-accent mt-0 mb-0"></div>
						<h3 class="ui-title-block_light">File Number <?php echo $orderDetails['file_number']; ?></h3>
						<h3 class="ui-title-block_light"></h3>
						<div class="wrapper-alignment">
							<h3 class="ui-title-block_light" style="display: inline-block;"><?php echo $orderDetails['full_address'];?></h3>
							<!-- <span class="bg-border" style="float: right;background: #d35411;margin-left:10px;"><a style="color:#fff;" href="<?php echo base_url();?>update-prelim-action/<?php echo $orderDetails['file_id'];?>">Update Prelim Action</a></span> -->
							<div>
								<button class="btn-success btn-icon-split btn-sm" onClick="window.location.reload();">
									<span class="icon text-white-50">
										<i class="fa fa-refresh"></i>
									</span>
									<span class="text">Refresh</span>
								</button>
								<a class="btn-success btn-icon-split btn-sm" href="<?php echo base_url();?>update-prelim-action/<?php echo $orderDetails['file_id'];?>">
									<span class="icon text-white-50">
										<i class="fa fa-upload"></i>
									</span>
									<span class="text">Update Prelim Action</span>
								</a>
							</div>

							<!-- <span class="bg-border" style="float: right;cursor:pointer;background: #d35411;" onClick="window.location.reload();">Refresh</span> -->
						</div>

						<div style="width: 100%;margin-top:10px;">
							<?php if(!empty($success)) { ?>
								<div id="prelim_action_success_msg" class="w-100 alert alert-success alert-dismissible">
									<?php echo $success;?>
								</div>
							<?php } if(!empty($error)) { ?>
								<div id="prelim_action_success_msg" class="w-100 alert alert-danger alert-dismissible">
									<?php echo $error."<br \>";	?>
								</div>
							<?php } ?>
						</div>

						<input type="hidden" id="fileId" name="fileId" value="<?php echo $orderDetails['file_id'];?>">
						<input type="hidden" id="orderId" name="orderId" value="<?php echo $orderDetails['order_id'];?>">
					</div>

					<div class="typography-sectionabcd">
						<div class="row col-md-12">
							<div class="col-md-3">
								<div class="typography-section__inner">
									<h3 class="ui-title-block_light">Doc Links</h3>
									<div class="ui-decor-1a bg-accent"></div>
								</div>
								<aside class="l-sidebarb l-sidebar_right">
									<section class="widget section-sidebara">

										<div class="widget-contenta">
											<div class="header-navibox-2">
												<ul class="yamm2 nav navbar-nav2">
													<li class="review_li"><a href="javascript:void(0);" onclick="summary();">Summary</a></li><br>
													<?php  if(!empty($prelimDocument)) { ?>
														<li class="review_li">
															<a onclick="load_doc(<?php echo $prelimDocument['is_sync'];?>, <?php echo $prelimDocument['api_document_id'];?>, <?php echo $prelimDocument['order_id'];?>, <?php echo $prelimDocument['id'];?>);" href="javascript:void(0);">
																Prelim
															</a>
														</li>
														<br>
													<?php } else { ?>
														<li class="review_li">
															<a href="javascript:void(0);" >Prelim</a></li><br>
													<?php } ?>
													<li class="review_li nav-bottom-border">
														<button class="dropdown-btn">Linked Docs
															<i style="font-size:16px;" class="fa fa-caret-down"></i>
														</button>
														<div class="dropdown-container">
															<ol> 
															<?php 
																if(!empty($linked_doc)) {
																	$count = count($linked_doc);
																	$i = 1;
																	
																	foreach($linked_doc as $document) { 
																		if (!empty($document['original_document_name'])) {
																			
																		?>
																		<li ><a id="<?php echo $document['api_document_id'];?>" style="<?php echo $style;?>" onclick="load_doc(<?php echo $document['is_sync'];?>, <?php echo $document['api_document_id'];?>, <?php echo $document['order_id'];?>, <?php echo $document['id'];?>);" class="linked_doc" href="javascript:void(0);"><?php echo $document['index_number'].". ".$document['original_document_name'];?></a></li>
																	<?php  } $i++; } 
																	} else { ?>
																	<a class="linked_doc" href="#">No Documents Found</a>
																<?php } 
															?>
														</ol>
														</div>
													</li>
													<br>
													<li class="review_li"><a href="javascript:void(0);" onclick="legal_vesting();">Legal Vesting</a></li><br>
													<li class="review_li"><a href="javascript:void(0);" onclick="plat_map();">Plat Map</a></li>
													<li class="review_li nav-bottom-border">
														<button class="dropdown-btn">Uploaded Docs
															<i style="font-size:16px;" class="fa fa-caret-down"></i>
														</button>
														<div class="dropdown-container">
															<ol > 
															<?php 
																if(!empty($uploaded_docs)) {
																	$count = count($uploaded_docs);
																	$i = 1;
																	foreach($uploaded_docs as $document) { 
																		?>
																		<li style="width: 100%;"><a id="<?php echo $document['api_document_id'];?>" style="<?php echo $style;?>display: list-item;" onclick="load_doc(<?php echo $document['is_sync'];?>, <?php echo $document['api_document_id'];?>, <?php echo $document['order_id'];?>, <?php echo $document['id'];?>);" class="linked_doc" href="javascript:void(0);"><?php echo $i.". ".$document['original_document_name'];?></a></li>
																	<?php  $i++; } 
																	} else { ?>
																	<a class="linked_doc" href="#">No Documents Found</a>
																<?php } 
															?>
														</ol>
														</div>
													</li>
												</ul>
											</div>
										</div>
									</section>

									<div class="typography-section__inner">
										<h3 class="ui-title-block_light">Order Details</h3>
										<div class="ui-decor-1a bg-accent"></div>
									</div>
									
									<section class="widget section-sidebar">
										<div class="widget-content2">
											<ul class="widget-list lista">
												<li class="widget-list__item"><a class="widget-list__link fs-20"
														href="javascript:void(0)">Borrower Name</a><br><?php echo $orderDetails['primary_owner'];?></li>
												<div class="ui-decor-3"></div>
												<li class="widget-list__itema"><a class="widget-list__link fs-20"
														href="javascript:void(0)">Transaction Type</a><br><?php echo $orderDetails['product_type']; ?></li>
												<div class="ui-decor-3"></div>
												<?php
													if(strpos($orderDetails['product_type'], 'Sale') !== false)
													{
														if(isset($orderDetails['sales_amount']) && !empty($orderDetails['sales_amount']))
														{
															$sales_amount = str_replace(",", "", $orderDetails['sales_amount']);
														}
												?>
														<li class="widget-list__itema"><a class="widget-list__link fs-20"
														href="javascript:void(0)">Sales Amount</a><br><?php echo isset($sales_amount) && !empty($sales_amount) ? "$".number_format($sales_amount) : '-' ;?></li>
														<div class="ui-decor-3"></div>

												<?php
													}
												?>
												<?php
													if(isset($orderDetails['loan_amount']) && !empty($orderDetails['loan_amount']))
													{
														$loan_amount = str_replace(",", "", $orderDetails['loan_amount']);
													}
												?>
												<li class="widget-list__itema"><a class="widget-list__link fs-20"
														href="javascript:void(0)">Loan Amount</a><br><?php echo isset($loan_amount) && !empty($loan_amount) ? "$".number_format($loan_amount) : '-' ;?></li>
												<div class="ui-decor-3"></div>
												<li class="widget-list__itema"><a class="widget-list__link fs-20"
														href="javascript:void(0)">Open Date</a><br><?php echo date("m/d/Y", strtotime($orderDetails['opened_date'])); ?></li>
											</ul>
										</div>
									</section>
									<!-- end .widget-->
								</aside>
							</div>

							<!-- <div class="col-md-1"></div> -->
							<div class="col-md-9" id="links_details">
								
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
<!-- </section> -->

