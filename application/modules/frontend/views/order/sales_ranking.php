
<style type="text/css">
	th {
		text-align: center;
	}
	.month-name, .year-name {
		text-decoration: underline;
		color: #d35411;
		margin-left: 10px;
	}
	.align-wrapper {
		display: flex;
		align-items: center;
		flex-direction: row;
		justify-content: space-between;
	}
</style>
<div class="container-fluid">
		<div class="card shadow mb-4">
			<div class="card-body">
				<div class="col-xs-12">
					<div class="typography-section__inner align-wrapper">
						<h4 class="ui-title-block_light month-title align-wrapper">Ranking based on production figures for <b class="month-name"><?php echo date('F');?></b></h3>
						<h4 class="ui-title-block_light year-title" style="display: none;">Ranking based on production figures for the year <b class="year-name"><?php echo date('Y');?></b></h3>
						<div id="year_listing">
							<label>
								<select style="width:auto;" name="year" id="year" class="custom-select custom-select-sm form-control form-control-sm"> 								
									<option value="">Select Year</option>
									<?php 
                                    $currentYear = date("Y");
                                    for ($i = 0; $i < 5; $i++) { 
										$date = strtotime("-$i year");
										$value = date("Y", $date); // for option value (e.g., 2024-07)
									?>
										<option value="<?php echo $value;?>"><?php echo $value;?></option>
									<?php }?>
								</select>
							</label>
						</div>
						<div id="month_listing">
							<label>
								<select style="width:auto;" name="month_year" id="month_year" class="custom-select custom-select-sm form-control form-control-sm"> 
									<option value="">Select Month</option>
									<?php 
                                    $currentMonth = date("Y-m");
                                    for ($i = 0; $i < 12; $i++) { 
										$date = strtotime("-$i month");
										$value = date("Y-m", $date); // for option value (e.g., 2024-07)
										$label = date("F Y", $date); // for display (e.g., July 2024)
									?>
										<option <?php echo ($value == $currentMonth) ? 'selected' : ''; ?> value="<?php echo $value;?>"><?php echo $label;?></option>
									<?php }?>
								</select>
							</label>
						</div>
					</div>
					<div class="card shadow mb-4">
						<div class="card-body">
							<div class="table-responsive">
                                <div id="sales_ranking_success_msg" class="w-100 alert alert-success alert-dismissible" style="display:none;"></div>
								<div id="sales_ranking_error_msg" class="w-100 alert alert-danger alert-dismissible" style="display:none;"></div>
								<table class="table table-bordered" id="sales_ranking" width="100%" cellspacing="0">
									<thead>
										<tr>
											<th>Sales Rep.</th>
											<th>Total Openings</th>
											<th>Total Closings</th>
											<th>Total Revenue</th>
											<th>Closing Ratio</th>
											<th>Rank</th>
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
