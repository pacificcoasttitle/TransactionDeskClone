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
							<a href="<?php echo base_url().'order'; ?>">
								<button class="btn1 btn-type-1a btn-lg" type="button">New Title Order</button>
							</a>
							<a href="<?php echo base_url().'cpl-dashboard'; ?>">
								<button class="btn1 btn-type-1b btn-lg" type="button">Generate CPL</button>
							</a>
							<a href="<?php echo base_url().'proposed-insured'; ?>">
								<button class="btn1 btn-type-1e btn-lg" type="button">Proposed</button>
							</a>
						</div>
					</div>

					<div class="typography-sectionc">
						<div class="col-md-12">
							<?php if(isset($is_master) && empty($is_master)) { ?>
								<a href="<?php echo base_url().'fees'; ?>">
									<button class="btn1 btn-type-1g btn-lg" type="button">Fee Estimate</button>
								</a>
							<?php } ?>
							<a href="<?php echo base_url().'prelim-files'; ?>">
								<button class="btn1 btn-type-1c btn-lg" type="button">Review Prelim</button>
							</a>
							<a href="<?php echo base_url().'upload-doc-orders'; ?>">
								<button class="btn1 btn-type-1d btn-lg" type="button">Upload Doc</button>
							</a>
						</div>
					</div>
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
								<table class="table table-type-3 typography-last-elem" id="order_listing">
									<thead>
										<tr>
											<th>No</th>
											<th>#</th>
											<th>Status</th>
											<th>Opened</th>
											<th>Property Address</th>
											<th>Buyer/Seller</th>
											<th>Action</th>
										</tr>
									</thead>
									<tbody></tbody>
								</table>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>

<div class="modal fade" id="sendInviteModal" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-dialog modal-lg modal-dialog-centered" role="document">
		<div class="modal-content">
			<form id="inviteForm" method="post">
				<div class="modal-header">
					<button type="button" class="close pull-right" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
					<h4 class="modal-title">Send Invite to Borrower</h4>
				</div>
				<div class="modal-body search-result">
					<div class="error-cotent"></div>
					<div class="row">
						<div class="col-sm-12">
							<div class="form-group">
								<label class="col-sm-2 control-label" for="borrower_email">Email</label>
								<div class="col-sm-10">
									<input type="email" class="form-control" id="borrower_email" name="borrower_email"
										placeholder="Email" required="" />
								</div>
							</div>

							<div class="form-group">
								<label class="col-sm-2 control-label" for="borrower_name">Name</label>
								<div class="col-sm-10">
									<input type="text" class="form-control" id="borrower_name" name="borrower_name"
										placeholder="Email" />
								</div>
								<input type="hidden" id="invite_order_id" name="invite_order_id">
								<input type="hidden" id="property_address" name="property_address">
							</div>
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-warning" data-dismiss="modal">Close</button>
					<button type="button" class="btn btn-danger" id="sendInviteBtn">Send</button>
				</div>
			</form>
		</div> 
	</div>
</div>

