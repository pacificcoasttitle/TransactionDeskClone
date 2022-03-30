
<style type="text/css">
	th {
		text-align: center;
	}

	.chart-container {
		background-color: #f8f6f6;
		border: 1px solid rgba(000, 000, 000, 0.15);
		margin-bottom: 50px;
	}
</style>
<section class="section-type-4a section-defaulta" style="padding-bottom:0px;">
	<div class="container">
		<div class="row">
			<div class="row">
				<div class="col-xs-12">
					<div class="typography-section__inner">
						<h2 class="ui-title-block ui-title-block_light">Trends</h2>
						<div class="ui-decor-1a bg-accent"></div>
						<?php if(!empty($salesUsers) && $is_sales_rep_manager == 1) { ?>
							<div id="sales_user_listing">
								<label>
									<select style="width:auto;" name="sales_user_trend_filter" id="sales_user_trend_filter" class="custom-select custom-select-sm form-control form-control-sm"> 
										<!-- <option value="all"> All Sales Rep Users </option> -->
										<?php foreach($salesUsers as $salesUser) { ?>
											<option <?Php echo ($sales_user_id == $salesUser['id']) ? 'selected' : '';?> value="<?php echo $salesUser['id'];?>"><?php echo $salesUser['first_name']." ".$salesUser['last_name'];?></option>
										<?php }?>
									</select>
								</label>
							</div>
						<?php } ?>
					</div>  
					
					<div class="typography-sectiona">
						<div class="col-md-12 chart-container">
							<div class="card shadow mb-4">
								<!-- Card Header - Dropdown -->
								<div
									class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
									<h3 class="m-0 font-weight-bold text-primary">Title Openings MTD Overview</h3>
									
								</div>
								<!-- Card Body -->
								<div class="card-body">
									<div class="chart-area">
										<div class="chartjs-size-monitor">
											<div class="chartjs-size-monitor-expand">
												<div class=""></div>
											</div>
											<div class="chartjs-size-monitor-shrink">
												<div class=""></div>
											</div>
										</div>
										<canvas id="openOrdersChart"
											style="display: block; height: 320px; width: 782px;" width="977"
											height="400" class="chartjs-render-monitor"></canvas>
									</div>
								</div>
							</div>
						</div>
					</div>

					<div class="typography-sectiona">
						<div class="col-md-12 chart-container">
							<div class="card shadow mb-4">
								<!-- Card Header - Dropdown -->
								<div
									class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
									<h3 class="m-0 font-weight-bold text-primary">Title Closings MTD Overview</h3>
									
								</div>
								<!-- Card Body -->
								<div class="card-body">
									<div class="chart-area">
										<div class="chartjs-size-monitor">
											<div class="chartjs-size-monitor-expand">
												<div class=""></div>
											</div>
											<div class="chartjs-size-monitor-shrink">
												<div class=""></div>
											</div>
										</div>
										<canvas id="closedOrderChart"
											style="display: block; height: 320px; width: 782px;" width="977"
											height="400" class="chartjs-render-monitor"></canvas>
									</div>
								</div>
							</div>
						</div>
					</div>

					<div class="typography-sectiona">
						<div class="col-md-12 chart-container">
							<div class="card shadow mb-4">
								<!-- Card Header - Dropdown -->
								<div
									class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
									<h3 class="m-0 font-weight-bold text-primary">Title Revenue MTD Overview</h3>
									
								</div>
								<!-- Card Body -->
								<div class="card-body">
									<div class="chart-area">
										<div class="chartjs-size-monitor">
											<div class="chartjs-size-monitor-expand">
												<div class=""></div>
											</div>
											<div class="chartjs-size-monitor-shrink">
												<div class=""></div>
											</div>
										</div>
										<canvas id="premiumTotalChart"
											style="display: block; height: 320px; width: 782px;" width="977"
											height="400" class="chartjs-render-monitor"></canvas>
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

<script>
    var salesData = <?php echo json_encode($salesHistory);?>;
</script>
