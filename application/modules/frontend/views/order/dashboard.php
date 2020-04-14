<body>
	<?php
        $this->load->view('layout/header_dashboard');
    ?>
	<section class="section-type-4a section-default typography-section-border" style="padding-bottom:0px;">
		<div class="container">
			<div class="row">
				<div class="row">
					<div class="col-xs-12">
						<div class="typography-section__innera">
							<h2 class="ui-title-block ui-title-block_light">Welcome Back <?php echo $name; ?>,</h2>
							<div class="ui-decor-1a bg-primary"></div>
							<h3 class="ui-title-block_light">What would you like to do?</h3>
						</div>
						<div class="typography-sectiona">
							<div class="col-md-12">
								<a href="<?php echo base_url().'order'; ?>">
									<button class="btn btn-type-1a btn-lg" type="button">Open New Order</button>
								</a>
								<a href="<?php echo base_url().'cpl-dashboard'; ?>">
									<button class="btn btn-type-1b btn-lg" type="button">Generate CPL</button>
								</a>
								<a href="<?php echo base_url().'prelim-files'; ?>">
									<button class="btn btn-type-1a btn-lg" type="button">Prelim Review</button>
								</a>
                  				<a href="<?php echo base_url().'attach-files'; ?>">
                  					<button class="btn btn-type-1d btn-lg" type="button">Upload a Document</button>
                  				</a>
							</div>
						</div>
						<div class="typography-sectionc">
							<div class="col-md-12">
								<a href="<?php echo base_url().'proposed-insured'; ?>">
									<button class="btn btn-type-1e btn-lg" type="button">Proposed Insured</button>
								</a>
								<a href="<?php echo base_url().'recordings'; ?>">
									<button class="btn btn-type-1f btn-lg" style="padding-left:16px;" type="button">Recording Confirmations</button>
								</a>
								<a href="<?php echo base_url().'fees'; ?>">
									<button class="btn btn-type-1a btn-lg" type="button">Get Fee Estimate</button>
								</a>
								<a href="<?php echo base_url().'notes'; ?>">
									<button class="btn btn-type-1b btn-lg" type="button">Notes on Files</button>
								</a>
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
							<h2 class="ui-title-block ui-title-block_light">Recent Orders,</h2>
							<div class="ui-decor-1a bg-primary"></div>
							<h3 class="ui-title-block_light">Below are all your orders.</h3>
						</div>
						<div class="typography-sectiona">
							<div class="col-md-12">
								<div class="table-container">
									<table class="table table_primary">
										<thead>
											<tr>
												<th>#</th>
												<th>Date Opened</th>
												<th>Property Address</th>
												<th>Buyer/Seller</th>
												<th>Action</th>
											</tr>
										</thead>
										<tbody>
											<?php 
												if(!empty($order_lists)) {
													foreach($order_lists as $order) { ?>
														<tr>
															<td><?php echo $order['file_number']; ?></td>
															
															<td><?php echo date("m/d/Y", strtotime($order['created_at'])); ?></td>
															
															<td><?php echo $order['full_address']; ?></td>
															<td><?php echo $order['primary_owner']; ?></td>
															<td>
																<a href="<?php echo base_url()."upload-documents/".$order['file_id'];?>" style="margin-right:10px;"><i class="fa fa-upload" aria-hidden="true"></i></a>
																<a href="<?php echo base_url()."get-notes/".$order['file_id'];?>"><i class="fa fa-sticky-note-o"></i></a>
															</td>
														</tr>
													<?php } 
												} else { ?>
													<tr>
														<td colspan="8">No Records Found.</td>
													</tr>
												<?php }
											?>	
										</tbody>
									</table>

									<div class="typography-sectionab">

										
									</div>

								</div>
							</div>
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
