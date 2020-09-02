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
							<div class="ui-decor-1a bg-accent"></div>
							<h3 class="ui-title-block_light">How can we help you today?</h3>
						</div>
						<div class="typography-sectiona">
							<div class="col-md-12">
							
							<!-- 
								<div class="col-md-3">
									<div class="card-block"></div>
								</div>
								<div class="col-md-3">
									<div class="card-block"></div>
								</div>
								<div class="col-md-3">
									<div class="card-block"></div>
								</div>
								<div class="col-md-3">
									<div class="card-block"></div>
								</div>
							     -->
								<a href="<?php echo base_url().'order'; ?>">
									<button class="btn1 btn-type-1a btn-lg" type="button">New Title Order</button>
								</a>
								<a href="<?php echo base_url().'cpl-dashboard'; ?>">
									<button class="btn1 btn-type-1b btn-lg" type="button">Generate CPL</button>
								</a>
								<a href="<?php echo base_url().'proposed-insured'; ?>">
									<button class="btn1 btn-type-1e btn-lg" type="button">Proposed</button>
								</a>
								<?php
									if(isset($is_master) && empty($is_master))
									{
								?>
										<a href="<?php echo base_url().'fees'; ?>">
											<button class="btn1 btn-type-1g btn-lg" type="button">Fee Estimate</button>
										</a>
								<?php
									}
									
								?>
								
								
								
                  				<!--<a href="<?php // echo base_url().'attach-files'; ?>">
                  					<button class="btn1 btn-type-1d btn-lg" type="button">Upload Doc</button>
                  				</a> -->
								
								
							</div>
						</div>
						<div class="typography-sectionc">
							<div class="col-md-12">
							<?php if (isset($user_email) && !empty($user_email) && trim($user_email) == 'gladys@greenforestescrow.net') { ?>
									<a href="<?php echo base_url().'prelim-files'; ?>">
										<button class="btn1 btn-type-1c btn-lg" type="button">Review Prelim</button>
									</a>
								<?php } ?>
							<!--
							   <div class="col-md-3">
									<div class="card-block"></div>
								</div>
								<div class="col-md-3">
									<div class="card-block"></div>
								</div>
								<div class="col-md-3">
									<div class="card-block"></div>
								</div>
								<div class="col-md-3">
									<div class="card-block"></div>
								</div> -->
							
							
							
								<!-- <a href="<?php // echo base_url().'proposed-insured'; ?>">
									<button class="btn1 btn-type-1e btn-lg" type="button">Proposed</button>
								</a> -->
								<!-- <a href="<?php // echo base_url().'recordings'; ?>">
									<button class="btn1 btn-type-1f btn-lg" style="" type="button">Confirmations</button>
								</a> -->
								<!-- <a href="<?php // echo base_url().'fees'; ?>">
									<button class="btn1 btn-type-1g btn-lg" type="button">Fee Estimate</button>
								</a> -->
								<!-- <a href="<?php // echo base_url().'notes'; ?>">
									<button class="btn1 btn-type-1h btn-lg" type="button">Notes on Files</button>
								</a> --> 
								
								
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
							<div class="ui-decor-1a bg-accent"></div>
							<h3 class="ui-title-block_light">Below are all your orders.</h3>
						</div>
						<div class="typography-sectiona">
							<div class="col-md-12">
								<div class="table-container">
									<table class="table table-type-3 typography-last-elem">
										<thead>
											<tr>
												<th>#</th>
												<th>Opened</th>
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
																<a href="<?php echo base_url()."cpl-dashboard";?>" style="margin-right:10px;"><i class="fa fa-upload" aria-hidden="true"></i></a>
																<a href="<?php echo base_url()."proposed-insured/";?>"><i class="fa fa-sticky-note-o"></i></a>
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
