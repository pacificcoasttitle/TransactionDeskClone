
<style type="text/css">

	/* table#orders_listing tr td:last-child {
		 display: inline-flex; 
	} */

	.ui-autocomplete {
		max-height: 300px !important;
	}

	#orders_listing_filter {
		display: inline-flex;
		float: right;
	}

	select#order_type_filter {
		margin-bottom: 0px;
		margin-left: 0.5em;
		border: 1px solid #cbd2d6;
		border-radius: 3px;
		padding: 0.25rem 1.5rem;
	}

	select#month_filter {
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

	.modal-dialog{
		overflow-y: initial !important
	}
	
	.modal-body{
		height: 700px;
		overflow-y: auto;
	}

	.square-box{
		background-color: #f0f0f0;
		width: 23% !important;
		margin-right: 2%;
		margin-bottom: 50px;
		padding-bottom: 35px;
		padding-top: 15px;
		border-radius: 5px;
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
		font-size: 21px;
		line-height: 27px;
		color: #00B489;
	}
	
	.salesdivider {
		border-bottom: 1px solid #fff;
		padding-top: 20px;
		padding-bottom: 20px;
	}

	.projected_goal_section {
		color: #06445a;
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
	.sales-user-listing {
		display: flex;
		align-items: center;
	}
	#sales_user_listing {
		float:left;
		margin: 0 25px;
		/* width: 100%; */
	}
	.custom-select {
		border-radius: 5px;
	}
	.ui-title-block {
		font-size: 36px;
	}
	.card-body .btn {
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
		display: block;
		/* padding: 10px 20px; */
		clear: both;
		font-weight: normal;
		line-height: 1;
		color: #333333;
		white-space: nowrap;
	}
	.dropdown-menu > li > a {
		padding: 5px 0px 5px 0px;
	}
	
	.dropdown-menu > li > a:hover, .dropdown-menu > li > a:focus {
		text-decoration: none;
		background-color: #eeeeee;
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
	.fs-28 {
		font-size: 28px;
	}
	.fs-16 {
		font-size: 16px;
	}
	.section-type-4 .ui-subtitle-block {
		padding-top: 24px;
	}

	.btn {
		display: inline-block;
		margin-bottom: 0;
		padding: 9px 41px;
		font-weight: 700;
		font-size: 13px;
		text-align: center;
		vertical-align: middle;
		-ms-touch-action: manipulation;
		touch-action: manipulation;
		cursor: pointer;
		background-image: none;
		border: 1px solid transparent;
		white-space: nowrap;
		-webkit-user-select: none;
		-moz-user-select: none;
		-ms-user-select: none;
		user-select: none;
		text-transform: uppercase;
		color: white;
		transition: all .3s;
	}

	.section-type-4 .btn {
		margin-top: 53px;
	}

	.card-body .btn {
		margin-top: 0px;
		margin-right:5px;
		margin-left: 5px;
		width:180px;
		font-weight:600;
		position: relative;
	}

	.card-body .btn1 {
		margin-top: 0px;
		margin-right:5px;
		margin-left: 5px;
		font-weight:400;
		
	}


	.btn:hover {
		opacity: 1;
		box-shadow: 0 0 1px 0 #000;
		/* text-shadow: 0 0 1px #000; */
	}
	
	.btn-grad-2a:hover {
		color: #fff;
	}
	.caret {
		display: inline-block;
		width: 0;
		height: 0;
		margin-left: 3px;
		vertical-align: middle;
		border-top: 3px dashed;
		border-top: 3px solid;
		border-right: 3px solid transparent;
		border-left: 3px solid transparent;
	}
	.btn .caret {
		margin-left: 0;
	}
	.btn:after {
		position: absolute;
		top: 0;
		left: 0;
		width: 110%;
		height: 100%;
		content: '';
		-webkit-transform: skewX(-50deg);
		transform: skewX(-50deg);
		background: -webkit-linear-gradient(right, rgba(255, 255, 255, 0), rgba(255, 255, 255, 0.8), rgba(255, 255, 255, 0)) no-repeat -2em 0;
		background: linear-gradient(to left, rgba(255, 255, 255, 0), rgba(255, 255, 255, 0.8), rgba(255, 255, 255, 0)) no-repeat -2em 0;
		background-size: 2em 100%;
	}
	.btn:hover:after {
		-webkit-transition: .7s linear;
		transition: .7s linear;
		background-position: 150% 0;
	}
	.dropdown-toggle::after {
		border-top: none;
	}
	.button-color {
		color: #888888;
	}
	.month-name {
		text-decoration: underline;
		color: #d35411
	}
</style>
<!-- <section class="section-type-4a section-defaulta container-fluid" style="padding-bottom:0px;"> -->
	<div class="container-fluid">
		<div class="card shadow mb-4">
			<div class="card-body">
				<div class="col-xs-12">
					
					<div class="typography-section__inner">
						<div class="row">
							<div class="col-sm-12">
								<h2 class="ui-title-block ui-title-block_light fs-28">Welcome <?php echo $name; ?>,</h2>
								<div class="ui-decor-1a bg-accent"></div>
								<div class="sales-user-listing mb-4">
									<h4 class="ui-title-block_light fs-16">Production figures for the current month of <b class="month-name"><?php echo date('F');?></b></h3>
									<?php if(!empty($salesUsers) && $is_sales_rep_manager == 1) { ?>
										<div id="sales_user_listing">
											<label>
												<select style="width:auto;" name="sales_user_filter" id="sales_user_filter" class="custom-select custom-select-sm form-control form-control-sm"> 
													<?php foreach($salesUsers as $salesUser) { ?>
														<option <?Php echo ($user_id == $salesUser['id']) ? 'selected' : '';?> value="<?php echo $salesUser['id'];?>"><?php echo $salesUser['first_name']." ".$salesUser['last_name'];?></option>
													<?php }?>
												</select>
											</label>
										</div>
									<?php } ?>
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
													<div class="col-auto">
														<i class="fa fa-first-order fa-2x text-gray-300"></i>
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
													<div class="col-auto">
														<i class="fa fa-first-order fa-2x text-gray-300"></i>
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
														<div class="text-xs font-weight-bold text-info text-uppercase mb-1 sales_loan_count" id="total_premium">$<span id="total_premium"><?php echo number_format($total_premium); ?></span></div>
														<div class="salesdivider">
														<div class="h5 mb-0 font-weight-bold text-gray-800 sales_loan_section">Sales = $<span id="sale_total_premium"><?Php echo $sale_total_premium;?></span></div>
														<div class="h5 mb-0 font-weight-bold text-gray-800 sales_loan_section">Refi's = $<span id="refi_total_premium"><?Php echo $refi_total_premium;?></span></div>
														</div>
													</div>
													<div class="col-auto">
														<i class="fa fa-first-order fa-2x text-gray-300"></i>
													</div>
												</div>
												<div class="clearfix small z-1 viewDetails text-info projected_goal_section">
													Projected = $<span id="projected_revenue_section">$<?Php echo number_format($projected_revenue);?></span>
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
													<div class="col-auto">
														<i class="fa fa-first-order fa-2x text-gray-300"></i>
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
					<div class="order-count-cotainer">
						<h4 class="ui-title-block_light">Below is list of all your files. You can search for files by month that have a status open, closed, or cancelled.</h3>
					</div>	
					
					<div class="card shadow mb-4">
						<div class="card-body">
							<div class="table-responsive">
								<table class="table table-bordered" id="orders_listing" width="100%" cellspacing="0">
									<thead>
										<tr>
											<th>#</th>
											<?php if(!empty($salesUsers)) { ?>
												<th>Sales Rep</th>
											<?php } ?>
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
			</div>
		</div>
	</div>
<!-- </section> -->
<!-- Partners Modal -->
<div class="modal" id="partnersModal">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="card shadow mb-4">
				<div class="card-header py-3">
					<h6 class="m-0 font-weight-bold text-primary" >Partners</h6>
				</div>
				
				<div class="card-body"> 
					<div class="table-responsive">
						<table class="table table-bordered" id="tbl-partners-data" width="100%" cellspacing="0">
							<thead>
								<tr>
									<th>PartnerID</th>
									<th>PartnerTypeID</th>
									<th>PartnerTypeName</th>
									<th>PartnerName</th>
									<!-- <th>EmailAddress</th> -->
								</tr>
							</thead>            
							<tbody></tbody>
						</table>
					</div>
					<div class="form-footer">
						<button type="reset" data-dismiss="modal" aria-label="Close" class="btn-danger btn-icon-split btn-sm">
							<span class="icon text-white-50">
								<i class="fas fa-ban"></i>
							</span>
							<span class="text">Cancel</span>
						</button>
						<!-- <button type="button" class="btn btn-success" data-dismiss="modal" >Close</button> -->
					</div>
				</div>
			</div>
			<!-- <div class="modal-header">
				<h4 class="modal-title">Partners</h4>
			</div> -->

			<!-- <div class="modal-body">
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
				<button type="button" class="btn btn-danger" data-dismiss="modal" style="background: #d35411;">Close</button>
			</div> -->
		</div>
	</div>
</div>

