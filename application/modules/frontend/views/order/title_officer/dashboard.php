
	<style type="text/css">
		table#orders_listing tr td:last-child {
			display: inline-flex;
		}

		.ui-autocomplete {
			max-height: 300px !important;
		}

		#orders_listing_filter {
			display: inline-flex;
			float: right;
		}

		select#month_filter {
			margin-bottom: 0px;
			margin-left: 0.5em;
			border: 1px solid #cbd2d6;
			border-radius: 3px;
			padding: 9px 22px 12px;
		}

		select#order_type_filter {
			margin-bottom: 0px;
			margin-left: 0.5em;
			border: 1px solid #cbd2d6;
			border-radius: 3px;
			padding: 9px 22px 12px;
		}

		select#orders_filter {
			margin-bottom: 0px;
			margin-left: 0.5em;
			border: 1px solid #cbd2d6;
			border-radius: 3px;
			padding: 9px 22px 12px;
		}

		.button-color {
			color: #888888;
		}

		td.dataTables_empty {
			display: table-cell !important;
		}

		.modal-dialog {
			overflow-y: initial !important
		}

		.modal-body {
			height: 700px;
			overflow-y: auto;
		}

		.square-box {
			background-color: #f0f0f0;
			width: 23% !important;
			margin-right: 2%;
			margin-bottom: 50px;
			padding-bottom: 35px;
			padding-top: 15px;
		}

		.order-count-cotainer {
			margin-top: 50px;
		}

		.title {
			text-align: center;
			color: #a0a0a0;
			width: 23% !important;
			margin-right: 2%;
			text-transform: uppercase;
			font-size: 15px;
			letter-spacing: 0px;
		}

		.sales_loan_count {
			font-size: 48px;
			color: #0D5772;
			text-align: center;
			font-weight: 800;
			letter-spacing: -1.00px;
			border-bottom: 1px solid #fff;
		}

		.sales_loan_section {
			text-align: center;
			text-transform: uppercase;
			font-size: 20px;
			line-height: 23px;
			color: #a0a0a0;
		}

		.salesdivider {
			border-bottom: 1px solid #fff;
			padding-top: 20px;
			padding-bottom: 20px;
		}

		.projected_goal_section {
			color: #d35411;
			font-weight: bold;
			text-align: center;
			text-transform: uppercase;
			font-size: large;
			line-height: 21px;
		}

		#orders_listing_filter {
			margin-bottom: 20px;
		}

		th {
			text-align: center;
		}

		#title_officer_orders_listing {
			margin-right: 25px;
			width: 100%;
		}
		.custom-select {
			border-radius: 5px;
		}
		.ui-title-block {
			font-size: 36px;
		}
		.section-type-4a .btn {
			border-radius: 5px;
		}
		.pagination > li > a {
			border-radius: 5px;
		}
		.dropdown-menu {
			margin-top: 0px !important
		}
		.dropdown-menu > li > a {
			padding: 5px 0px 5px 0px;
		}
		.dropdown .click-action-type {
			color: #222222;
			text-decoration: none;
		}
		.tooltiptext {
			visibility: hidden;
			/* width: 120px; */
			background-color: #969393;
			color: #fff;
			text-align: center;
			border-radius: 6px;
			padding: 5px;
			margin-left: 5px;
			margin-top: 15px;
			position: absolute;
			z-index: 1;
		}
	</style>
	<section class="section-type-4a section-defaulta" style="padding-bottom:0px;">
		<div class="container">
			<div class="row">
				<div class="row">
					<div class="col-xs-12">
						<div class="typography-section__inner">
							<h2 class="ui-title-block ui-title-block_light">Welcome Back <?php echo $name; ?>,</h2>
							<div class="ui-decor-1a bg-accent"></div>
							<div class="typography-sectiona">
								<div class="col-md-12">
									<a href="<?php echo base_url('uplod-file-document') ?>">
										<button class="btn1 btn-type-1a btn-lg" type="button">Blank Forms</button>
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
									<a href="<?php echo base_url().'notes'; ?>">
										<button class="btn1 btn-type-1g btn-lg" type="button">Add Notes</button>
									</a>
									
									<a href="<?php echo base_url().'prelim-files'; ?>">
										<button class="btn1 btn-type-1c btn-lg" type="button">Review Prelim</button>
									</a>
									<a href="<?php echo base_url().'upload-doc-orders'; ?>">
										<button class="btn1 btn-type-1d btn-lg" type="button">Upload Doc</button>
									</a>
								</div>
							</div>
							<!-- <h4 class="ui-title-block_light">Below is your production figures for the current month of
								<b><?php echo date('F');?></b></h3> -->
						</div>
						<!-- <div class="order-count-cotainer">
							<div class="col-md-3 title">Title Openings MTD</div>
							<div class="col-md-3 title">Title Closings MTD</div>
							<div class="col-md-3 title">Title Revenue MTD</div>
							<div class="col-md-3 title">Closings Ratio Avg</div>

							<div class="col-md-3 square-box">
								<div class="sales_loan_count" id="open_order_count">
									<?Php echo $total_open_count; ?>
								</div>
								<div class="salesdivider">
									<div class="sales_loan_section">Sales = <span id="sale_open_count">
											<?Php echo $sale_open_count;?></span></div>
									<div class="sales_loan_section">Refi's = <span id="refi_open_count">
											<?Php echo $refi_open_count;?></span></div>
								</div>
								<div style="margin-top: 20px;" class="projected_goal_section">Projected = <span
										id="projected_open_section">
										<?Php echo $projected_open_count;?></span></div>
								<div class="projected_goal_section">Goal = <span id="goal_open_section">
										<?Php echo round($sales_rep_info['sales_rep_no_of_open_orders']/12);?></span>
								</div>
							</div>

							<div class="col-md-3 square-box">
								<div class="sales_loan_count" id="close_order_count">
									<?Php echo $total_close_count; ?>
								</div>
								<div class="salesdivider">
									<div class="sales_loan_section">Sales = <span id="sale_close_count">
											<?Php echo $sale_close_count;?></span></div>
									<div class="sales_loan_section">Refi's = <span id="refi_close_count">
											<?Php echo $refi_close_count;?></span></div>
								</div>
								<div style="margin-top: 20px;" class="projected_goal_section">Projected = <span
										id="projected_close_section">
										<?Php echo $projected_close_count;?></span></div>
								<div class="projected_goal_section">Goal = <span id="goal_close_section">
										<?Php echo round($sales_rep_info['sales_rep_no_of_close_orders']/12);?></span>
								</div>
							</div>

							<div class="col-md-3 square-box">
								<div class="sales_loan_count">$<span
										id="total_premium"><?php echo number_format($total_premium); ?></span></div>
								<div class="salesdivider">
									<div class="sales_loan_section">Sales = $<span
											id="sale_total_premium"><?php echo number_format($sale_total_premium); ?></span>
									</div>
									<div class="sales_loan_section">Refi's = $<span
											id="refi_total_premium"><?php echo number_format($refi_total_premium); ?></span>
									</div>
								</div>
								<div style="margin-top: 20px;" class="projected_goal_section">Projected = $<span
										id="projected_revenue_section">
										<?Php echo $projected_revenue;?></span></div>
								<div class="projected_goal_section">Goal = $<span id="goal_revenue_section">
										<?Php echo round($sales_rep_info['sales_rep_premium']/12);?></span></div>
							</div>

							<div class="col-md-3 square-box">
								<div class="sales_loan_count"><span id="close_order_percetage">
										<?Php echo $close_order_percetage;?></span>%</div>
								<div class="salesdivider">
									<div class="sales_loan_section">Sales = <span id="sale_close_order_percetage">
											<?Php echo $sale_close_order_percetage;?></span>%</div>
									<div class="sales_loan_section">Refi's = <span id="refi_close_order_percetage">
											<?Php echo $refi_close_order_percetage;?></span>%</div>
								</div>
								<div style="margin-top: 20px;" class="projected_goal_section">Projected = <span
										id="refi_open_count">0%</span></div>
								<div class="projected_goal_section">Goal = <span id="refi_open_count">0%</span></div>
							</div>

							<h4 class="ui-title-block_light">Below is list of all your files. You can search for files
								by month that have a status open, closed, or cancelled.</h3>
						</div> -->

						<div class="typography-sectiona">
							<div class="col-md-12">
								<div class="table-container">
									<table class="table table-type-3 typography-last-elem" id="title_officer_orders_listing">
										<thead>
											<tr>
												<th>#</th>
												<th>Opened</th>
												<th>Property Address</th>
												<th>Status</th>
												<th>Action</th>
											</tr>
										</thead>
										<tbody></tbody>
									</table>
									<div class="typography-sectionab"></div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
	<div class="modal" id="partnersModal">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<div class="modal-header">
					<h4 class="modal-title">Partners</h4>
				</div>

				<div class="modal-body">
					<table class="table table-striped" id="tbl-partners-data">
						<thead>
							<tr>
								<th>PartnerID</th>
								<th>PartnerTypeID</th>
								<th>PartnerTypeName</th>
								<th>PartnerName</th>
							</tr>
						</thead>
						<tbody></tbody>
					</table>
				</div>

				<div class="modal-footer">
					<button type="button" class="btn btn-danger" data-dismiss="modal"
						style="background: #d35411;">Close</button>
				</div>

			</div>
		</div>
	</div>
	


