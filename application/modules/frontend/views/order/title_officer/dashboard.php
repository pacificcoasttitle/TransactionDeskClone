
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

		select#month_filter, select#orders_filter, select#order_type_filter {
			margin-bottom: 0px;
			margin-left: 0.5em;
			border: 1px solid #cbd2d6;
			border-radius: 3px;
			padding: 0px 22px 0px;
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
			/* text-align: center; */
			color: #a0a0a0;
			width: 23% !important;
			/* margin-right: 2%; */
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

		.fa-info-circle {
			font-size: 16px;
		}

		.fs-2 {
			font-size: 20px;
		}

		.fs-1-half {
			font-size: 15px;
		}

		.text-center {
			text-align: center;
		}

		.anchor-hover {
			position: absolute;
			z-index: 1;
			height: 100%;
			top: 0;
			width: 100%;
		}

		.padding-0 {
			padding: 0;
		}

		.dashboard-menu-icon {
			height: 4rem;
			width: 4rem;
		}
		.main-wrapper {
			scale: 95%;
		}
	</style>
	<!-- <section class="section-type-4a section-defaulta" style="padding-bottom:0px;"> -->
	<div class="container-fluid p-5 main-wrapper">
		<div class="row">
			<div class="col-md-12">
				<div class="typography-section__innera">
					<h2 class="ui-title-block ui-title-block_light mb-5">Welcome Back <?php echo $name; ?></h2>
					<div class="ui-decor-1a bg-accent"></div>
					<div class="sales-user-listing mb-4">
						<h4 class="ui-title-block_light fs-16">Production figures for the current month of <b class="month-name"><?php echo date('F');?></b></h3>
						<input type="hidden" name="user_id" id="user_id" value="<?php echo $user_id;?>">
					</div>
				</div>
			</div>
		</div>

		<div class="row mb-4">
			<div class="col-sm-12">
				<div class="row mb-2" >
						<div class="col-md-3 col-sm-12 title text-primary">Title Openings MTD</div>
						<div class="col-md-3 col-sm-12 title text-success">Title Closings MTD</div>
						<div class="col-md-3 col-sm-12 title text-info">Title Revenue MTD</div>
						<div class="col-md-3 col-sm-12 title text-warning">Closings Ratio Avg</div>
					
				</div>

				<div class="row">
					<div class="col-md-3 col-sm-12">
						<div class="card border-left-primary shadow h-100 py-2">
							<div class="card-body">
								<div class="row no-gutters align-items-center">
									<div class="col mr-2">
										<div class="text-xs font-weight-bold text-primary text-uppercase mb-1 sales_loan_count" id="open_order_count"><?Php echo $total_open_count; ?></div>
										<div class="salesdivider">
										<div class="h5 mb-0 font-weight-bold text-gray-800 sales_loan_section">Sales = <span id="sale_open_count"><?Php echo $sale_open_count;?></span></div>
										<div class="h5 mb-0 font-weight-bold text-gray-800 sales_loan_section">Refi's = <span id="refi_open_count"><?Php echo $refi_open_count;?></span></div>
										</div>
									</div>
								</div>
								<div class="clearfix small z-1 viewDetails text-primary projected_goal_section">
									Projected = <span id="projected_open_section"><?Php echo $projected_open_count;?></span>
									<?php if($sales_rep_info['sales_rep_no_of_open_orders'] > 0) { ?>
										<div class="projected_goal_section">Goal = <span id="goal_open_section"><?Php echo round($sales_rep_info['sales_rep_no_of_open_orders']/12);?></span></div>
									<?php } else { ?>
										<div class="projected_goal_section">&nbsp;</div>
									<?php } ?>
								</div>
							</div>
						</div>
					</div>
					<div class="col-md-3 col-sm-12">
						<div class="card border-left-success shadow h-100 py-2">
							<div class="card-body">
								<div class="row no-gutters align-items-center">
									<div class="col mr-2">
										<div class="text-xs font-weight-bold text-success text-uppercase mb-1 sales_loan_count" id="close_order_count"><?Php echo $total_close_count; ?></div>
										<div class="salesdivider">
										<div class="h5 mb-0 font-weight-bold text-gray-800 sales_loan_section">Sales = <span id="sale_close_count"><?Php echo $sale_close_count;?></span></div>
										<div class="h5 mb-0 font-weight-bold text-gray-800 sales_loan_section">Refi's = <span id="refi_close_count"><?Php echo $refi_close_count;?></span></div>
										</div>
									</div>
								</div>
								<div class="clearfix small z-1 viewDetails text-success projected_goal_section">
									Projected = <span id="projected_close_section"><?Php echo $projected_close_count;?></span>
									<?php if($sales_rep_info['sales_rep_no_of_open_orders'] > 0) { ?>
										<div class="projected_goal_section">Goal = <span id="goal_open_section"><?Php echo round($sales_rep_info['sales_rep_no_of_open_orders']/12);?></span></div>
									<?php } else { ?>
										<div class="projected_goal_section">&nbsp;</div>
									<?php } ?>
								</div>
							</div>
						</div>
					</div>
					<div class="col-md-3 col-sm-12">
						<div class="card border-left-info shadow h-100 py-2">
							<div class="card-body">
								<div class="row no-gutters align-items-center">
									<div class="col mr-2">
										<div class="text-xs font-weight-bold text-info text-uppercase mb-1 sales_loan_count" id="total_premium"><a class="text-info" href="javascript:void(0)" onclick="getRevenueData();">$<span id="total_premium"><?php echo number_format($total_premium); ?></span></a></div>
										<div class="salesdivider">
										<div class="h5 mb-0 font-weight-bold text-gray-800 sales_loan_section">Sales = $<span id="sale_total_premium"><?Php echo $sale_total_premium;?></span></div>
										<div class="h5 mb-0 font-weight-bold text-gray-800 sales_loan_section">Refi's = $<span id="refi_total_premium"><?Php echo $refi_total_premium;?></span></div>
										</div>
									</div>
								</div>
								<div class="clearfix small z-1 viewDetails text-info projected_goal_section">
									Projected = $<span id="projected_revenue_section"><?Php echo number_format($projected_revenue);?></span>
									<?php if($sales_rep_info['sales_rep_premium'] > 0) { ?>
										<div class="projected_goal_section">Goal = $<span id="goal_revenue_section"><?Php echo number_format(round($sales_rep_info['sales_rep_premium']/12));?></span></div>
									<?php } else { ?>
										<div class="projected_goal_section">&nbsp;</div>
									<?php } ?>
								</div>
							</div>
						</div>
					</div>
					<div class="col-md-3 col-sm-12">
						<div class="card border-left-warning shadow h-100 py-2">
							<div class="card-body">
								<div class="row no-gutters align-items-center">
									<div class="col mr-2">
										<div class="text-xs font-weight-bold text-warning text-uppercase mb-1 sales_loan_count" id="close_order_percetage"><?Php echo $close_order_percetage; ?>%</div>
										<div class="salesdivider">
										<div class="h5 mb-0 font-weight-bold text-gray-800 sales_loan_section">Sales = <span id="sale_close_order_percetage"><?Php echo $sale_close_order_percetage;?></span>%</div>
										<div class="h5 mb-0 font-weight-bold text-gray-800 sales_loan_section">Refi's = <span id="refi_close_order_percetage"><?Php echo $refi_close_order_percetage;?></span>%</div>
										</div>
									</div>
								</div>
								
								<div class="clearfix small z-1 viewDetails text-warning projected_goal_section">
									Projected = <span id="refi_open_count">0%</span>
									<div class="projected_goal_section">&nbsp;</div>
								</div>
							</div>
						</div>
					</div>

				</div>
			</div>
		</div>
		<!-- <div class="row mb-4">
			<div class="col-md-4 col-sm-12">
				<div class="card border-left-primary shadow h-100 py-2">
					<div class="card-body">
						<div class="row no-gutters align-items-center" style="flex-direction: column; text-align: center;" >
							<div class="col-auto">
								<img class="dashboard-menu-icon" src="<?php echo base_url()?>assets/frontend/images/New.png">
							</div>
							<div class="col mr-2 mt-3">
								<div class="text-xl font-weight-bold text-primary text-uppercase mb-1">Blank Forms</div>
							</div>
						</div>
					</div>
					<a href="<?php echo base_url('uplod-file-document') ?>" class="anchor-hover"></a>
				</div>
			</div>

			<div class="col-md-4 col-sm-12">
				<div class="card border-left-primary shadow h-100 py-2">
					<div class="card-body">
						<div class="row no-gutters align-items-center" style="flex-direction: column; text-align: center;" >
							<div class="col-auto">
								<img class="dashboard-menu-icon" src="<?php echo base_url()?>assets/frontend/images/CPL.png">
							</div>
							<div class="col mr-2 mt-3">
								<div class="text-xl font-weight-bold text-primary text-uppercase mb-1">Generate CPL</div>
							</div>
						</div>
					</div>
					<a href="<?php echo base_url().'cpl-dashboard'; ?>" class="anchor-hover"></a>
				</div>
			</div>

			<div class="col-md-4 col-sm-12">
				<div class="card border-left-primary shadow h-100 py-2">
					<div class="card-body">
						<div class="row no-gutters align-items-center" style="flex-direction: column; text-align: center;" >
							<div class="col-auto">
								<img class="dashboard-menu-icon" src="<?php echo base_url()?>assets/frontend/images/Proposed.png">
							</div>
							<div class="col mr-2 mt-3">
								<div class="text-xl font-weight-bold text-primary text-uppercase mb-1">Proposed</div>
							</div>
						</div>
					</div>
					<a href="<?php echo base_url().'proposed-insured'; ?>" class="anchor-hover"></a>
				</div>
			</div>
		</div> -->

		<!-- <div class="row mt-3 mb-4">
			<div class="col-md-4 col-sm-12">
				<div class="card border-left-primary shadow h-100 py-2">
					<div class="card-body">
						<div class="row no-gutters align-items-center" style="flex-direction: column; text-align: center;" >
							<div class="col-auto">
								<img class="dashboard-menu-icon" src="<?php echo base_url()?>assets/frontend/images/Fees.png">
							</div>
							<div class="col mr-2 mt-3">
								<div class="text-xl font-weight-bold text-primary text-uppercase mb-1">Add Notes</div>
							</div>
						</div>
					</div>
					<a href="<?php echo base_url().'notes'; ?>" class="anchor-hover"></a>
				</div>
			</div>

			<div class="col-md-4 col-sm-12">
				<div class="card border-left-primary shadow h-100 py-2">
					<div class="card-body">
						<div class="row no-gutters align-items-center" style="flex-direction: column; text-align: center;" >
							<div class="col-auto">
								<img class="dashboard-menu-icon" src="<?php echo base_url()?>assets/frontend/images/Prelim.png">
							</div>
							<div class="col mr-2 mt-3">
								<div class="text-xl font-weight-bold text-primary text-uppercase mb-1">Review Prelime</div>
							</div>
						</div>
					</div>
					<a href="<?php echo base_url().'prelim-files'; ?>" class="anchor-hover"></a>
				</div>
			</div>

			<div class="col-md-4 col-sm-12">
				<div class="card border-left-primary shadow h-100 py-2">
					<div class="card-body">
						<div class="row no-gutters align-items-center" style="flex-direction: column; text-align: center;" >
							<div class="col-auto">
								<img class="dashboard-menu-icon" src="<?php echo base_url()?>assets/frontend/images/Upload.png">
							</div>
							<div class="col mr-2 mt-3">
								<div class="text-xl font-weight-bold text-primary text-uppercase mb-1">Upload Docs</div>
							</div>
						</div>
					</div>
					<a href="<?php echo base_url().'upload-doc-orders'; ?>" class="anchor-hover"></a>
				</div>
			</div>
		</div>
	
		<section class="section-type-4a section-defaulta mt-5" style="padding-bottom:0px;">
			<div class="container-fluid padding-0">
				<div class="row mb-3">
					<div class="col-sm-12">
						<h1 class="h3 text-gray-800 text-center">Recent Orders </h1>
					</div>
				</div>
				<div class="card shadow mb-4">
					<div class="card-header datatable-header py-3">
						<div class="datatable-header-titles" > 
							
							<h6 class="m-0 font-weight-bold text-primary pl-10">Below are all your orders</h6> 
						</div>
					</div>
					<div class="card-body">
						<div class="table-responsive">
							<div id="listing_success_msg" class="w-100 alert alert-success alert-dismissible" style="display:none;"></div>
							<div id="listing_error_msg" class="w-100 alert alert-danger alert-dismissible" style="display:none;"></div>
							<table class="table table-bordered" id="title_officer_orders_listing" width="100%" cellspacing="0">
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
						</div>
					</div>
				</div>
				
			</div>
		</section> -->
	</div>
	<!-- </section> -->
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

<div class="modal fade" width="1200px" id="revenue_model" tabindex="-1" role="dialog" aria-labelledby="Revenue Information" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document" style="width:100%;height:auto;">
        <div class="modal-content">
            <form method="POST" action="">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card shadow mb-4">
                            <div class="card-header py-3">
                                <h6 class="m-0 font-weight-bold text-primary">Revenue Information</h6>
                            </div>
                            <div class="card-body">
                                <div class="smart-forms smart-container">
                                    <div class="search-result">
                                        <div id="deliverables-details-fields">
                                            <div class="frm-row" id="clone_container">
                                                <div class="section colm colm12" id="clone-email-address"
                                                    style="margin-bottom: 0px !important;">
                                                    <div class="toclone">
                                                        <div class="spacer-b10">
                                                            <label class="field" id="revenue_container">
															
                                                            </label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
	


