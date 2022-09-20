
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
						<h4 class="ui-title-block_light">Below is list of your month order's count for the current year of <b><?php echo date('Y');?></b></h3>
					</div>
					
					<div class="typography-sectiona">
						<div class="col-md-12">
							<div class="table-container">
								<table class="table table-type-3 typography-last-elem" id="production_history_tab">
									<thead>
										<tr>
											<th>Sales Rep.</th>
											<th>Total Openings</th>
											<th>Total Closings</th>
											<th>Total Revenue</th>
										</tr>
									</thead>
									<?php if(!empty($salesHistory)) {?>
										<tbody>
											<?php foreach($salesHistory as $salesData) { ?>
												<tr>
													<td><?php echo $salesData['sales_rep'];?></td>
													<td><?php echo $salesData['total_open_count'];?></td>
													<td><?php echo $salesData['total_close_count'];?></td>
													<td><?php echo "$".number_format($salesData['total_premium']);?></td>
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
	



