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
								<a href="<?php echo base_url().'order'; ?>"><button class="btn btn-type-1a btn-lg" type="button">Open
										Order</button></a>
								<button class="btn btn-type-1b btn-lg" type="button">View CPL's</button>
								<a href="<?php echo base_url().'select-files'; ?>"><button class="btn btn-type-1a btn-lg"
										type="button">Review Prelim</button></a>
                  <a href="<?php echo base_url().'attach-files'; ?>"><button class="btn btn-type-1d btn-lg" type="button">Attach Doc</button>
							</div>
						</div>
						<div class="typography-sectionc">
							<div class="col-md-12">
								<button class="btn btn-type-1e btn-lg" type="button">View Proposed</button>
								<a href="<?php echo base_url().'recordings'; ?>"><button class="btn btn-type-1f btn-lg"
										type="button">View Recordings</button></a>
								<button class="btn btn-type-1a btn-lg" type="button">Fee Estimate</button>
								<button class="btn btn-type-1b btn-lg" type="button">View All Notes</button>
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
												<th>First Name</th>
												<th>Last Name</th>
												<th>user id</th>
												<th>Email</th>
											</tr>
										</thead>
										<tbody>
											<tr>
												<td>1</td>
												<td>Mark</td>
												<td>Otto</td>
												<td>nomdo</td>
												<td>mark.otto@mdo.net</td>
											</tr>
											<tr>
												<td>2</td>
												<td>Jacob</td>
												<td>Thornton</td>
												<td>wrfat</td>
												<td>jacob.thrnton321@fatbeer.org</td>
											</tr>
											<tr>
												<td>3</td>
												<td>Larry</td>
												<td>the Bird</td>
												<td>kotwitter</td>
												<td>larry.king.live@twitterhack.com</td>
											</tr>
											<tr>
												<td>3</td>
												<td>Larry</td>
												<td>the Bird</td>
												<td>kotwitter</td>
												<td>larry.king.live@twitterhack.com</td>
											</tr>
											<tr>
												<td>3</td>
												<td>Larry</td>
												<td>the Bird</td>
												<td>kotwitter</td>
												<td>larry.king.live@twitterhack.com</td>
											</tr>
											<tr>
												<td>3</td>
												<td>Larry</td>
												<td>the Bird</td>
												<td>kotwitter</td>
												<td>larry.king.live@twitterhack.com</td>
											</tr>
											<tr>
												<td>3</td>
												<td>Larry</td>
												<td>the Bird</td>
												<td>kotwitter</td>
												<td>larry.king.live@twitterhack.com</td>
											</tr>
										</tbody>
									</table>

									<div class="typography-sectionab">

										<ul class="pagination pagination-1">
											<li><a href="#"><span class="fa fa-angle-left"></span></a></li>
											<li><a href="#">1</a></li>
											<li class="active"><a href="#">2</a></li>
											<li><a href="#">3</a></li>
											<li><a href="#"><span class="fa fa-angle-right"></span></a></li>
										</ul>
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
