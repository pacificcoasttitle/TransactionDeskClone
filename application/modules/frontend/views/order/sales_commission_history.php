
<style type="text/css">
	th {
		text-align: center;
	}
	.custom__collapse_arrow .fa-angle-down {
    display: none;
}
	.custom__collapse_arrow.collapsed .fa-angle-down {
	display: inline-block;
}
.custom__collapse_arrow.collapsed .fa-angle-up {
	display: none;
}
.table > tbody > tr.custom__total > th ,.table > tbody > tr.custom__total > td {
	border-top: 2px solid;
}
.custom__task_collapse .card-body {
    padding-left: 35px;
    font-size: 16px;
    /* background: #f2f2f2; */
    margin-bottom: 25px;
    padding-bottom: 15px;
    padding-top: 15px;
    border: 1px solid #d0c9c9;
    border-radius: 10px;
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
								<select style="width:auto;" name="sales_user_commission_filter" id="sales_user_commission_filter" class="custom-select custom-select-sm form-control form-control-sm"> 
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
											<th>Commission</th>
											<th>File Name</th>
											<th>Action</th>
										</tr>
									</thead>
									<?php if(!empty($commissionHistory)) {?>
										<tbody>
											<?php foreach($commissionHistory as $key=>$commissionRecord) { ?>
												<tr>
													<td><?php echo $commissionRecord['month'];?></td>
													<th>$ <?php echo ($commissionRecord['commission_data']) ? $commissionRecord['commission_data']->commission : '0.00';?> </th>
													<td><?php echo ($commissionRecord['commission_data']) ? $commissionRecord['commission_data']->pdf_name : '';?></td>
													<td>
													<?php
													if($commissionRecord['commission_data'] && $commissionRecord['commission_data']->commisssion_pdf) :
														$documentUrl = env('AWS_PATH')."file_document/".$commissionRecord['commission_data']->commisssion_pdf;
														?>
														<a class="btn btn-grad-2a" style="background: #d35411;"  target='_blank' href='<?php echo $documentUrl;?>'>View</a>
														<?php
													else : ?>
														 &nbsp;
													<?php endif; ?>
													<a href="#collapseCard_<?php echo $key; ?>" class="custom__collapse_arrow collapsed" data-toggle="collapse" role="button" aria-expanded="false" aria-controls="collapseCard_<?php echo $key; ?>">
															<i class="fa fa-angle-down"></i>
															<i class="fa fa-angle-up"></i>
														</a>
													</td>
												</tr> 
												<tr  class="custom__task_collapse collapse" id="collapseCard_<?php echo $key; ?>" aria-expanded="false">
													<td colspan="4">
														<div class="card">
															<div class="card-body">
																<table class="table">
																	<?php
																	$details_json = $commissionRecord['commission_data']->commission_details;
																	$details = array();
																	if(!empty( $details_json) && json_decode( $details_json)) {
		
																		$details = json_decode($details_json);
																	}
																	$details_arr = array();
																	$prod_array = PRODUCT_TYPE;
																	$underwriter_array = UNDERWRITERS;
																	foreach($prod_array as $prod) {
																		foreach($underwriter_array as $und_key=>$underwriter) {
																			$details_arr[$prod][$und_key] = 0;
																		}
																	}
		
																	foreach($details as $detail_json) {
																		$detail = json_decode($detail_json);
																		$prod_type = $detail->prod_type;
																		$underwriter = $detail->underwriter;
																		if(isset($details_arr[$prod_type][$underwriter])) {
																			$details_arr[$prod_type][$underwriter] += $detail->commisison;
																		}
																		else {
																			$details_arr[$prod_type][$underwriter] = $detail->commisison;
																		}
																	}
																	?>
																	<tr>
																		<?php
																		foreach($details_arr as $prod_key=>$details_obj) :
																			$total_commission_val = 0;
																		?>
																		<td style="border: none;">
																			
																			<table class="table">
																				<?php
																				$numItems = count($details_obj);
																				$comm_i = 0;
																					foreach($details_obj as $und_key=>$commission_val):
																						$total_commission_val += $commission_val;
																						if($comm_i == 0) : 
																					?>
																					<tr>
																						<th colspan="2"><?php echo ucwords($prod_key); ?></th>
																					</tr>
																					<?php
																						endif;
																					?>
																					<tr>
																						<th class="text-left"><?php echo ucwords($und_key); ?></th>
																						<td class="text-right">$ <?php echo number_format($commission_val,2) ; ?></td>
				
																					</tr>
																					
																				<?php
																					if(++$comm_i === $numItems) : ?>
																					<tr class="custom__total">
																						<th class="text-left">Total Commission</th>
																						<td class="text-right">$ <?php echo number_format($total_commission_val,2); ?></td>
																					</tr>
		
																				<?php
																					endif;
																					endforeach;
																				?>
																			</table>
																					
																				
																			
		
																		</td>
																			
																			
																		<?php
																		endforeach;
																		?>
		
																	</tr>
																	
		
																</table>

															</div>

														</div>
														
													</td>

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
	



