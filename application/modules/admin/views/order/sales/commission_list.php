<style>
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
</style>
<div class="container-fluid">
    <div class="card mb-3">
        <div class="card-header">
            <i class="fas fa-table"></i>
            Sales Rep Commissison
          
        </div>
     
        <div class="card-body">
		
            <div class="table-responsive">
                <table class="table " id="tbl-sales-rep-commission-listing" width="100%" cellspacing="0">
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
													$details_json = $commissionRecord['commission_data']->commission_details;
													$details = array();
													$draw_amount = $commission_sub_total=$escrow_commission = 0;
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
														// elseif($prod_type == 'escrow') {
														// 	$escrow_commission += $detail->commisison;
														// }
													}
													?>
												<tr class="text-center">
													<td><?php echo $commissionRecord['month'];?></td>
													<th>$ <?php echo ($commissionRecord['commission_data']) ? number_format($commissionRecord['commission_data']->commission,2) : '0.00';?> </th>
													
													<td><?php echo ($commissionRecord['commission_data']) ? $commissionRecord['commission_data']->pdf_name : '';?></td>
													<td>
													<?php
													if($commissionRecord['commission_data'] && $commissionRecord['commission_data']->commisssion_pdf) :
														$documentUrl = env('AWS_PATH')."file_document/".$commissionRecord['commission_data']->commisssion_pdf;
														?>
														<a class="btn btn-info"   target='_blank' href='<?php echo $documentUrl;?>'>View</a>
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
																						<th colspan="2" class="text-center"><?php echo ucwords($prod_key); ?></th>
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
																	<tr class="custom__total">
																		<th class="text-left">Draw Amount</th>
																		<td class="text-right">- $ <?php echo number_format(abs($draw_amount),2); ?></td>
																	</tr>
																	<tr class="custom__total">
																		<th class="text-left">Total Commission</th>
																		<td class="text-right"> $ <?php echo number_format(($commission_sub_total - abs($draw_amount)),2); ?></td>
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
            </div>
        </div>
    </div>
</div>
