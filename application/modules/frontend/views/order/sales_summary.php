
<style type="text/css">
	th {
		text-align: center;
	}
</style>
<section class="section-type-4a section-defaulta" style="padding-bottom:0px;">
	<div class="container">
		<div class="row">
			<div class="row">
				<div class="col-xs-12">
					<div class="typography-section__inner">
						<h4 class="ui-title-block_light">Below you will find a summary the clients who you closed a transaction(s) with in this year.</h3>
					</div>
					<?php if(!empty($salesUsers)) { ?>
						<div id="sales_user_listing">
							<label>
								<select style="width:auto;" name="sales_user_summary_filter" id="sales_user_summary_filter" class="custom-select custom-select-sm form-control form-control-sm"> 
									<!-- <option value="all"> All Sales Rep Users </option> -->
									<?php foreach($salesUsers as $salesUser) { ?>
										<option <?php echo ($sales_user_id == $salesUser['id']) ? 'selected' : '' ;?> value="<?php echo $salesUser['id'];?>"><?php echo $salesUser['first_name']." ".$salesUser['last_name'];?></option>
									<?php }?>
								</select>
							</label>
						</div>
					<?php } ?>
					<div class="typography-sectiona">
						<div class="col-md-12">
							<div class="table-container">
								<table class="table table-type-3 typography-last-elem" id="production_history_tab">
									<thead>
										<tr>
											<th>Sales Rep</th>
											<th>Client Source Name</th>
											<th>Company Name</th>
											<th># Of Deals</th>
										</tr>
									</thead>
									<?php if(!empty($summary_info)) {?>
										<tbody>
											<?php foreach($summary_info as $summary) { ?>
												<tr>
													<td><?php echo $summary['sales_name'];?></td>
													<th><?php echo $summary['name'];?></th>
													<td><?php echo $summary['company_name'];?></td>
													<td><?php echo $summary['num_of_deals'];?></td>
												</tr> 
											<?php } ?> 
										</tbody>
									<?php } else {?>
										<tbody>
											<tr>
												<td align="center" colspan="5"> No Records Found.</td>
											</tr>
										</tbody>
									<?php } ?>
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
	
   

