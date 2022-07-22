
<style type="text/css">
	th {
		text-align: center;
	}
	.custom__collapse_arrow .div__expand {
    display: none;
}
	.custom__collapse_arrow.collapsed .div__expand {
	display: inline-block;
}
.custom__collapse_arrow.collapsed .div__collapse {
	display: none;
}
.table > tbody > tr.custom__total > th ,.table > tbody > tr.custom__total > td {
	border-top: 2px solid;
}
.custom__task_collapse .card-body {
    padding-left: 35px;
    font-size: 16px;
    background: #f2f2f2;
    margin-bottom: 25px;
    padding-bottom: 20px;
    padding-top: 30px;
    /* border: 1px solid #d0c9c9; */
    /* border-radius: 10px; */
    padding-right: 30px;
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
											<th >Month</th>
											<th>Commission</th>
											
											<th>File Name</th>
											<th>Action</th>
										</tr>
									</thead>
									<?php if(!empty($commissionHistory)) {?>
										<tbody>
											<?php foreach($commissionHistory as $key=>$commissionRecord) { ?>
												<?php
													$total_commission = ($commissionRecord['commission_data']) ? $commissionRecord['commission_data']->commission : 0;
													$details_json = $commissionRecord['commission_data']->commission_details;
													$details = array();
													$draw_amount = $commission_sub_total=$escrow_commission=$first_in_threshold=$override_sub = $override_add = 0;
													if(!empty( $details_json) && json_decode( $details_json)) {

														$details = json_decode($details_json);
													}
													$details_arr = array();
													$prod_array = PRODUCT_TYPE;
													$underwriter_array = UNDERWRITERS;
													$underwriter_array['escrow'] = 'Escrow';
													foreach($prod_array as $prod) {
														foreach($underwriter_array as $und_key=>$underwriter) {
															$details_arr[$prod][$und_key] = 0;
														}
													}

													foreach($details as $detail_json) {
														$detail = json_decode($detail_json);
														$prod_type = $detail->prod_type;
														$underwriter = $detail->underwriter;
														if( in_array($prod_type,$prod_array)) {
															
															if(isset($details_arr[$prod_type][$underwriter])) {
																$details_arr[$prod_type][$underwriter] += $detail->commisison;
															}
															else {
																$details_arr[$prod_type][$underwriter] = $detail->commisison;
															}
														}
														elseif($prod_type == 'draw') {
															$draw_amount = $detail->commisison;
														}
														elseif($prod_type == 'first_threshold') {
															$first_in_threshold = $detail->commisison;
														}
														elseif($prod_type == 'override_sub') {
															$override_sub = abs($detail->commisison);
															$total_commission = $total_commission - $override_sub;
														}
														elseif($prod_type == 'override_add') {
															$override_add = abs($detail->commisison);
															$total_commission = $total_commission + $override_add;
														}
													}
													?>
												<tr>
													<td><?php echo $commissionRecord['month'];?></td>
													<th>$ <?php echo number_format($total_commission,2);?> </th>
													
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
													
													<a style="background-color: buttonface;color:black" href="#collapseCard_<?php echo $key; ?>" class="btn custom__collapse_arrow collapsed" data-toggle="collapse" role="button" aria-expanded="false" aria-controls="collapseCard_<?php echo $key; ?>">
															<span class="div__expand">Expand</span>
															<span class="div__collapse">Collapse</span>
														</a>
													</td>
												</tr> 
												<tr  class="custom__task_collapse collapse" id="collapseCard_<?php echo $key; ?>" aria-expanded="false">
													<td colspan="4">
														<div class="card">
															<div class="card-body">
																<table class="table">
																	
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
																					if(++$comm_i === $numItems) : 
																						$commission_sub_total += $total_commission_val;
																					?>
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
																	<tr class="custom__total">
																		<th class="text-left">Commission SubTotal : ( <?= implode(' + ',array_map("ucwords", PRODUCT_TYPE)); ?> )</th>
																		<td class="text-right">$ <?php echo number_format($commission_sub_total,2); ?></td>
																	</tr>
																	<?php if ($draw_amount) : ?>
																	<tr class="custom__total">
																		<th class="text-left">Draw Amount</th>
																		<td class="text-right">- $ <?php echo number_format(abs($draw_amount),2); ?></td>
																	</tr>
																	<?php endif; ?>
																	<?php if ($first_in_threshold) : ?>
																	<tr class="custom__total">
																		<th class="text-left">First In Threshold Amount</th>
																		<td class="text-right">- $ <?php echo number_format(abs($first_in_threshold),2); ?></td>
																	</tr>
																	<?php endif; ?>
																	<?php if ($override_sub) : ?>
																	<tr class="custom__total">
																		<th class="text-left">Override</th>
																		<td class="text-right">- $ <?php echo number_format($override_sub,2); ?></td>
																	</tr>
																	<?php endif; ?>
																	<?php if ($override_add) : ?>
																	<tr class="custom__total">
																		<th class="text-left">Extra Commission</th>
																		<td class="text-right">$ <?php echo number_format($override_add,2); ?></td>
																	</tr>
																	<?php endif; ?>
																	
																	<tr class="custom__total">
																		<th class="text-left">Total Commission</th>
																		<td class="text-right"> $ <?php echo number_format(($commission_sub_total - abs($draw_amount) - $override_sub + $override_add),2); ?></td>
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
												<td align="center" colspan="4"> No Records Found.</td>
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
	



