<body>
	<?php
        $this->load->view('layout/header_dashboard');
    ?>
	<section class="section-type-4a section-defaulta" style="padding-bottom:0px;">
		<div class="container">
			<div class="row">
				<div class="row">
					<div class="col-xs-12">
						<div class="typography-section__inner">
							<h2 class="ui-title-block ui-title-block_light">Preliminary Report Review</h2>
							<div class="ui-decor-1a bg-primary"></div>
							<h3 class="ui-title-block_light">File Number <?php echo $orderDetails['file_number'];?></h3>
							<h3 class="ui-title-block_light"><?php echo $orderDetails['full_address'];?></h3>
						</div>

						<div class="typography-sectionabcd">
							<div class="col-md-12">
								<div class="col-md-2">
									<div class="typography-section__inner">
										<h3 class="ui-title-block_light">Doc Links</h3>
										<div class="ui-decor-1a bg-primary"></div>
									</div>
									<aside class="l-sidebarb l-sidebar_right">
										<section class="widget section-sidebara">

											<div class="widget-contenta">
												<div class="header-navibox-2">
													<ul class="yamm2 nav navbar-nav2">
														<li><a href="<?php echo base_url().'review-file/'.$orderDetails['file_id'].'/summary';?>">Summary</a></li><br>
														<li><a href="<?php echo base_url().'review-file/'.$orderDetails['file_id'].'/prelim';?>">Prelim</a></li><br>
														<li><a href="<?php echo base_url().'review-file/'.$orderDetails['file_id'].'/linked-doc';?>">Linked Docs</a></li><br>
														<li><a href="<?php echo base_url().'review-file/'.$orderDetails['file_id'].'/legal-vesting';?>">Legal Vesting</a></li><br>
														<li><a href="<?php echo base_url().'review-file/'.$orderDetails['file_id'].'/plat-map';?>">Plat Map</a></li>

													</ul>
												</div>
											</div>
										</section>

										<div class="typography-section__inner">
											<h3 class="ui-title-block_light">Order Details</h3>
											<div class="ui-decor-1a bg-primary"></div>
										</div>

										<section class="widget section-sidebar">
											<div class="widget-content2">
												<ul class="widget-list lista">
													<li class="widget-list__item"><a class="widget-list__link"
															href="">Borrower Name</a><br>Jackson Storm</li>
													<div class="ui-decor-3"></div>
													<li class="widget-list__itema"><a class="widget-list__link"
															href="">Transaction Type</a><br>Refinance</li>
													<div class="ui-decor-3"></div>
													<li class="widget-list__itema"><a class="widget-list__link"
															href="">Loan Amount</a><br>650,000</li>
													<div class="ui-decor-3"></div>
													<li class="widget-list__itema"><a class="widget-list__link"
															href="">Open Date</a><br>04/11/1983</li>
												</ul>
											</div>
										</section>
										<!-- end .widget-->
									</aside>
								</div>

								<div class="col-md-1"></div>
								<?php 
									if($type == 'summary') { 
										$data['orderDetails'] = $orderDetails;
										$this->load->view('order/review_file_summary', $data);
									} else if($type == 'prelim') { 
										$this->load->view('order/review_file_prelim');
									} else if($type == 'linked-doc') { 
										$this->load->view('order/review_file_attach_doc');
									} else if($type == 'legal-vesting') { 
										$this->load->view('order/review_file_legal_vesting');
									} else if($type == 'plat-map') { 
										$this->load->view('order/review_file_plat_map');
									} 
								?>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
	<?php
        $this->load->view('layout/footer');
    ?>
</body>

</html>
