<body>
	<?php
        $this->load->view('layout/header_dashboard');
    ?>
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
						<?php if(!empty($salesUsers)) { ?>
							<div id="sales_user_listing">
								<label>
									<select style="width:auto;" name="sales_user_filter" id="sales_user_filter" class="custom-select custom-select-sm form-control form-control-sm"> 
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
												<th align="center">Month</th>
												<th>Trending</th>
												<th>Total Openings</th>
												<th>Total Closings</th>
												<th>Total Revenue</th>
												<th>Closing %</th>
											</tr>
										</thead>
										<?php if(!empty($salesHistory)) {?>
											<tbody>
												<?php foreach($salesHistory as $salesData) { ?>
													<tr>
														<td><?php echo $salesData['month'];?></td>
														<th><?php echo $salesData['trending'];?></th>
														<td><?php echo $salesData['total_open_count'];?></td>
														<td><?php echo $salesData['total_close_count'];?></td>
														<td><?php echo "$".number_format($salesData['total_premium']);?></td>
														<td><?php echo $salesData['close_order_percetage']."%";?></td>
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
	
    <!-- Partners Modal -->
	<?php
        $this->load->view('layout/footer');
    ?>

</body>
</html>

<script>
	$(document).ready(function () {
		$("#sales_user_filter").on("change", function(){
			var user_id = $(this).val();
	        window.location.replace('<?php echo base_url();?>sales-production-history/'+user_id);
	    });
	});
</script>
