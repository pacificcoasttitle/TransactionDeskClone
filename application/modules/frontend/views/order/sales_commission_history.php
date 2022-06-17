
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
											<?php foreach($commissionHistory as $commissionRecord) { ?>
												<tr>
													<td><?php echo $commissionRecord['month'];?></td>
													<th><?php echo ($commissionRecord['commission_data']) ? $commissionRecord['commission_data']->commission : '0.00';?> $ </th>
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
	



