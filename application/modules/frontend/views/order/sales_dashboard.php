
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
		padding: 9px 22px 12px;
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
	
	#sales_user_listing {
		float:left;
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
</style>
<section class="section-type-4a section-defaulta" style="padding-bottom:0px;">
	<div class="container">
		<div class="row">
			<div class="row">
				<div class="col-xs-12">
					
					<div class="typography-section__inner">
						<div class="row">
							<div class="col-sm-7">
								<h2 class="ui-title-block ui-title-block_light">Welcome <?php echo $name; ?>,</h2>
								<div class="ui-decor-1a bg-accent"></div>
								
								<h4 class="ui-title-block_light">Production figures for the current month of <b><?php echo date('F');?></b></h3>
								<?php if(!empty($salesUsers) && $is_sales_rep_manager == 1) { ?>
									<div id="sales_user_listing">
										<label>
											<select style="width:auto;" name="sales_user_filter" id="sales_user_filter" class="custom-select custom-select-sm form-control form-control-sm"> 
												<!-- <option value="all"> All Sales Rep Users </option> -->
												<?php foreach($salesUsers as $salesUser) { ?>
													<option <?Php echo ($user_id == $salesUser['id']) ? 'selected' : '';?> value="<?php echo $salesUser['id'];?>"><?php echo $salesUser['first_name']." ".$salesUser['last_name'];?></option>
												<?php }?>
											</select>
										</label>
									</div>
								<?php } ?>
								<?php if($is_sales_rep_manager == 1) { ?>
									<!-- <a href="<?php echo base_url(); ?>sales-current-month-history"><button style="width: 60%;margin: 0px !important;" class="btn btn-grad-2a button-color" type="button">View Current Month Production History</button></a> -->
								<?php } ?>
							</div>

							<!-- <div class="col-sm-5 text-right">
								<h2 class="ui-title-block ui-title-block_light">$<?php echo number_format($sales_commission,2); ?></h2>
								<div class="ui-decor-1a bg-accent"></div>
								<h4 class="ui-title-block_light">Estimated commission for the month of <b><?php echo date('F');?></b></h3>
							</div> -->

						</div>
					</div>
					
					<div class="order-count-cotainer">
						<div class="col-md-3 title">Title Openings MTD</div>
						<div class="col-md-3 title">Title Closings MTD</div>
						<div class="col-md-3 title">Title Revenue MTD</div>
						<div class="col-md-3 title">Closings Ratio Avg</div>

						<div class="col-md-3 square-box">
							<div class="sales_loan_count" id="open_order_count"><?Php echo $total_open_count; ?></div>
							<div class="salesdivider">
							<div class="sales_loan_section">Sales = <span id="sale_open_count"><?Php echo $sale_open_count;?></span></div>
							<div class="sales_loan_section">Refi's = <span id="refi_open_count"><?Php echo $refi_open_count;?></span></div>
							</div>
						<div style="margin-top: 20px;" class="projected_goal_section">Projected = <span id="projected_open_section"><?Php echo $projected_open_count;?></span></div>
							<?php if($sales_rep_info['sales_rep_no_of_open_orders'] > 0) { ?>
								<div class="projected_goal_section">Goal = <span id="goal_open_section"><?Php echo round($sales_rep_info['sales_rep_no_of_open_orders']/12);?></span></div>
							<?php } else { ?>
								<div class="projected_goal_section">&nbsp;</div>
							<?php } ?>
						</div>

						<div class="col-md-3 square-box">
							<div class="sales_loan_count" id="close_order_count"><?Php echo $total_close_count; ?></div>
							<div class="salesdivider">
							<div class="sales_loan_section">Sales = <span id="sale_close_count"><?Php echo $sale_close_count;?></span></div>
							<div class="sales_loan_section">Refi's = <span id="refi_close_count"><?Php echo $refi_close_count;?></span></div>
							</div>
							<div style="margin-top: 20px;" class="projected_goal_section">Projected = <span id="projected_close_section"><?Php echo $projected_close_count;?></span></div>
							<?php if($sales_rep_info['sales_rep_no_of_close_orders'] > 0) { ?>
								<div class="projected_goal_section">Goal = <span id="goal_close_section"><?Php echo round($sales_rep_info['sales_rep_no_of_close_orders']/12);?></span></div>
							<?php } else { ?>
								<div class="projected_goal_section">&nbsp;</div>
							<?php } ?>
						</div>

						<div class="col-md-3 square-box">
							<div class="sales_loan_count">$<span id="total_premium"><?php echo number_format($total_premium); ?></span></div>
							<div class="salesdivider">
							<div class="sales_loan_section">Sales = $<span id="sale_total_premium"><?php echo number_format($sale_total_premium); ?></span></div>
							<div class="sales_loan_section">Refi's = $<span id="refi_total_premium"><?php echo number_format($refi_total_premium); ?></span></div>
							</div>
							<div style="margin-top: 20px;" class="projected_goal_section">Projected = $<span id="projected_revenue_section"><?Php echo number_format($projected_revenue);?></span></div>
							<?php if($sales_rep_info['sales_rep_premium'] > 0) { ?>
								<div class="projected_goal_section">Goal = $<span id="goal_revenue_section"><?Php echo number_format(round($sales_rep_info['sales_rep_premium']/12));?></span></div>
							<?php } else { ?>
								<div class="projected_goal_section">&nbsp;</div>
							<?php } ?>
						</div>

						<div class="col-md-3 square-box">
							<div class="sales_loan_count"><span id="close_order_percetage"><?Php echo $close_order_percetage;?></span>%</div>
							<div class="salesdivider">
							<div class="sales_loan_section">Sales = <span id="sale_close_order_percetage"><?Php echo $sale_close_order_percetage;?></span>%</div>
							<div class="sales_loan_section">Refi's = <span id="refi_close_order_percetage"><?Php echo $refi_close_order_percetage;?></span>%</div>
							</div>
							<div style="margin-top: 20px;" class="projected_goal_section">Projected = <span id="refi_open_count">0%</span></div>
							<div class="projected_goal_section">&nbsp;</div>
						</div>

						<h4 class="ui-title-block_light">Below is list of all your files. You can search for files by month that have a status open, closed, or cancelled.</h3>
					</div>	
					
					<div class="typography-sectiona">
						<div class="col-md-12">
							<div class="table-container">
								<table class="table table-type-3 typography-last-elem" id="orders_listing">
									<thead>
										<tr>
											<th>#</th>
											<?php if(!empty($salesUsers)) { ?>
												<th>Sales Rep</th>
											<?php } ?>
											<th>Opened</th>
											<th>Property Address</th>
											<!-- <th>Buyer/Seller</th> -->
											<th>Status</th>
											<th>Action</th>
										</tr>
									</thead>
									<tbody></tbody>
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
</section>
<!-- Partners Modal -->
<div class="modal" id="partnersModal">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title">Partners</h4>
				<!-- <button type="button" class="close" data-dismiss="modal">&times;</button> -->
			</div>

			<div class="modal-body">
				<table class="table table-striped" id="tbl-partners-data">
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
			<div class="modal-footer">
				<button type="button" class="btn btn-danger" data-dismiss="modal" style="background: #d35411;">Close</button>
			</div>
		</div>
	</div>
</div>

