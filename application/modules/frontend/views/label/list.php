<style type="text/css">
	.u-list {
	    margin-bottom: 15px;
	}
	.u-list, .u-list li {
	    margin: 0;
	    padding: 0;
	    list-style: none;
	}
	.u-list li:nth-child(2n+1) {
	    background: #f0f0f0;
	}
	.u-list li {
	    padding: 10px;
	    display: table;
	    width: 100%;
	}
	.u-list .u-pic, .u-list .u-info {
	    display: block;
	    vertical-align: top;
	}
	.u-list .u-pic {
	    width: 80px;
	    height: 80px;
	    overflow: hidden;
	    border-radius: 100%;
	    margin-right: 15px;
	    float: left;
	}
	.u-list .u-pic img {
	    margin: 0;
	    border: 0;
	    max-width: 100%;
	}
	.u-list .u-info {
	    padding-top: 5px;
	    margin-left: 35px;
	    float: left;
	}
	.u-list .u-name {
	    font-weight: bold;
	    color: #000;
	}
	.u-list .u-count {
		float: right;
		font-size: 20px;
    	margin-right: 10px;
	}
	.no-report-image {
	    text-align: center;
	    background: #f0f0f0;
	    height: 80px;
	    padding-top: 8px;
	    font-size: 30px;
	    font-weight: 600;
	}
	.u-list li:nth-child(2n+1) .no-report-image{
	    background: #ffffff;
	}
	.report_switch_btn {
		height: 42px;
	    background: #d35411;
	    line-height: 1px;
	    padding: 25px 18px;
	    vertical-align: top;
	    display: inline-block;
	    font-size: 18px;
	    color: #fff;
	}
	.pma_val {
	    color: #d35400;
	    font-weight: bold;
	    text-align: center;
	}
</style>

<section class="section-sm section-defaulta" >
	<div class="container">
		<div class="row">
			<div class="col-sm-12">
				<div class="">
					<h2 class="ui-title-block ui-title-block_light">Labels
						<a href="<?php echo base_url('pmas'); ?>" class="pull-right report_switch_btn">Create Concierge</a>
						<a style="margin-right:10px;" href="<?php echo base_url('reports'); ?>" class="pull-right report_switch_btn">Create F.A.R</a>
					</h2>
					<div class="ui-decor-1a bg-accent"></div>
				</div>
			</div>
		</div>
		<div class="">
			<div class="row">
				<div class="row">
				<div class="row">
				<div class="col-md-4">
						<div class="row">
							<div class="col-sm-9">
								<h5>Total Ran</h5>
							</div>
							<div class="col-sm-3">
								<h4 class="pma-total pma_val"> <?php echo $report_total; ?> </h4>
							</div>
						</div>
						<ul class="u-list">
							<?php foreach($salesReps as $key=>$salesRep): ?>
								<li>
									<div class="u-pic">
										<?php $image_url = trim(env('AWS_PATH').$salesRep['sales_rep_report_image']);
											if (!empty($salesRep['sales_rep_report_image'])): ?>
													<img src="<?php echo $image_url;?>" alt="main-logo" class="retina">
										<?php else : ?>
											<div class="no-report-image"><span><?php echo strtoupper(substr(trim($salesRep['first_name']) , 0,1).substr(trim($salesRep['last_name']) , 0,1)) ?></span></div>
										<?php endif; ?>
									</div>
									<div class="u-info">
										<div class="u-name"><?php echo $salesRep['first_name'].' '.$salesRep['last_name'] ?></div>
										<div><?php echo $salesRep['email_address'];?></div>
										<div>
											<?php echo $salesRep['telephone_no'];?>
										</div>
									</div>
									<div class="u-count">
										<div class="pma_val"><?php echo $salesRep['report_count'];?></div>
									</div>
								</li>
							<?php
							if($key == 9) {
								break;
							}
							endforeach;
							?>
						</ul>
							<?php if(count($salesReps) > 10) : ?>
								<div class="pull-right">
									<a href="<?=base_url('reports/sales_rep')?>" class="btn btn-success">View All</a>
								</div>
							<?php endif; ?>
					</div>
					<div class="col-md-8">
						<h2><span>Create New Label Report</span></h2>
						<div class="smart-forms smart-container">
							<form method="POST" id="smart-form" enctype="multipart/form-data" novalidate="novalidate" action="<?php echo base_url('labels/importData') ?>">
								<div class="form-body">
									<?php $prev_data = $this->session->flashdata('_previous_data');
									if($this->session->flashdata('error')) : ?>
										<div class="alert alert-danger" role="alert"><?php echo $this->session->flashdata('error');?></div>
									<?php elseif($this->session->flashdata('success')): ?>
										<div class="alert alert-success" role="alert"><?php echo $this->session->flashdata('success');?></div>
									<?php endif; ?>
									<div class="frm-row">
										<div class="section colm colm6">
											<label class="field prepend-icon file">
												<span class="button"> Choose File </span>
												<input type="file" class="gui-file" name="csvFile" id="csvFile" 
												onChange="document.getElementById('uploader1').value = this.value;" accept=".csv">
												<input type="text" class="gui-input" id="uploader1" placeholder="no file selected" readonly>
												<span class="field-icon"><i class="fa fa-upload"></i></span>
											</label>
										</div>

										<div class="section colm colm6">
											<label class="field prepend-icon">
												<input type="text" class="gui-input" name="file_name" value="<?php echo (!empty($prev_data['file_name'])) ? $prev_data['file_name'] : '';?>" placeholder="File Name">
												<span class="field-icon"><i class="fa fa-file"></i></span>
											</label>
										</div>
											
										<div class="section colm colm4">
											<label class="field select">
												<select id="sales_rep" name="sales_rep">
													<option value="">Select Sales Representative</option>
													<?php
													foreach($salesReps as $salesRep):
													?>
													<option value="<?php echo $salesRep['id']; ?>" <?php if(!empty($prev_data['sales_rep']) && $prev_data['sales_rep'] ==  $salesRep['id']) {echo 'selected' ;}?>><?php echo $salesRep['first_name'].' '.$salesRep['last_name']; ?></option>
													<?php endforeach; ?>
												</select>
												<i class="arrow"></i>
											</label>
										</div>
										
										<div class="section colm colm4">	
											<button type="reset" class="button btn-default">Reset Form</button>
											<button type="submit" class="button btn-primary">Submit Form</button>
										</div>
									</div>
								</div>
							</form>
						</div>
						<div>
							<h2>Recent Sales Activity Reports</h2>
							<div class="table-container1">
								<table class="table table-type-3 typography-last-elem no-footer" id="label_listing">
									<thead>
										<tr>
											<th>Date</th>
											<th>Sales Rep</th>
											<th>File Name</th>
											<th>Download</th>
										</tr>
									</thead>
									<tbody>
										<?php
										foreach ($labels_data as $label) { ?>
											<tr>
												<td><span style="display:none;"><?php echo strtotime($label['created_at']); ?></span><?php echo date('d M y H:i',strtotime($label['created_at'])); ?></td>
												<td><?php echo $label['first_name'].' '.$label['last_name']; ?></td>
												<td><?php echo $label['file_name']; ?></td>
												<td>
													<a href="javascript:void(0)" onclick="selectColumns(<?php echo $label['id']?>, '<?php echo $label['file_columns']?>', '<?php echo $label['original_file_name']?>');">Download</a>
												</td>
											</tr>
										<?php } ?>
									</tbody>
								</table>
							</div>
						</div>
						
					</div>
				</div>
			</div>
		</div>
	</div>
</section>
<div class="modal fade" width="700px" id="select_columns" tabindex="-1" role="dialog"
	aria-labelledby="Select Columns" aria-hidden="true">
	<div class="modal-dialog modal-lg" role="document" style="width:50%;">
		<div class="modal-content">
			<form method="POST" id="select_columns_form" name="select_columns_form" onsubmit="return generatePdf();">
				<div class="smart-forms smart-container wrap-2" style="margin:30px">
					<div class="modal-body search-result">
						<div id="lender-details-fields" style="">
							<div class="spacer-b30">
								<div class="tagline"><span>Select Columns</span></div>
							</div>

							<input type="hidden" id="label_id" name="label_id" value="">
							<input type="hidden" id="file_name" name="file_name" value="">

							<div class="frm-row spacer-b20">
								<div class="section colm colm12">
									<input style="top:5px;margin-right: 15px;" class="field checkbox" type="checkbox" id="or_current_resident" name="or_current_resident">OR CURRENT RESIDENT
								</div>
							</div>
							
							<div class="spacer-b20">
								<div class="tagline"><span style="text-transform: none;">How many columns are you want to display on line1?</span></div>
							</div>
							
							<div class="frm-row">
								<div class="section colm colm12">
									<input checked style="top:5px;margin-right: 15px;" class="field radio" type="radio" name="line_1_columns" value="1">1 
								  	<input style="top:5px;margin-left:30px;margin-right: 15px;" class="field radio" type="radio" name="line_1_columns" value="2">2  
								  	<input style="top:5px;margin-left:30px;margin-right: 15px;" class="field radio" type="radio" name="line_1_columns" value="3">3
								</div>
							</div>

							<div class="frm-row spacer-b20">
								<div class="section colm colm4" id="line_1_1_container" style="display:none">
									<label class="field select">
										<select id="line_1_1" name="line_1_1">
											<option value="">---- Select Column ----</option>
										</select>
										<i class="arrow double"></i>
									</label>
								</div>
								<div class="section colm colm4" id="line_1_2_container" style="display:none">
									<label class="field select">
										<select id="line_1_2" name="line_1_2">
											<option value="">---- Select Column ----</option>
										</select>
										<i class="arrow double"></i>
									</label>
								</div>
								<div class="section colm colm4" id="line_1_3_container" style="display:none">
									<label class="field select">
										<select id="line_1_3" name="line_1_3">
											<option value="">---- Select Column ----</option>
										</select>
										<i class="arrow double"></i>
									</label>
								</div>
							</div>

							<div class="spacer-b20">
								<div class="tagline"><span style="text-transform: none;">How many columns are you want to display on line2?</span></div>
							</div>
							
							<div class="frm-row">
								<div class="section colm colm12">
									<input checked style="top:5px;margin-right: 15px;" class="field radio" type="radio" name="line_2_columns" value="1">1 
								  	<input style="top:5px;margin-left:30px;margin-right: 15px;" class="field radio" type="radio" name="line_2_columns" value="2">2  
								  	<input style="top:5px;margin-left:30px;margin-right: 15px;" class="field radio" type="radio" name="line_2_columns" value="3">3
								</div>
							</div>

							<div class="frm-row spacer-b20">
								<div class="section colm colm4" id="line_2_1_container" style="display:none">
									<label class="field select">
										<select id="line_2_1" name="line_2_1">
											<option value="">---- Select Column ----</option>
										</select>
										<i class="arrow double"></i>
									</label>
								</div>
								<div class="section colm colm4">
									<label class="field select" id="line_2_2_container" style="display:none">
										<select id="line_2_2" name="line_2_2">
											<option value="">---- Select Column ----</option>
										</select>
										<i class="arrow double"></i>
									</label>
								</div>
								<div class="section colm colm4">
									<label class="field select" id="line_2_3_container" style="display:none">
										<select id="line_2_3" name="line_2_3">
											<option value="">---- Select Column ----</option>
										</select>
										<i class="arrow double"></i>
									</label>
								</div>
							</div>

							<div class="spacer-b20">
								<div class="tagline"><span style="text-transform: none;">How many columns are you want to display on line3?</span></div>
							</div>
							
							<div class="frm-row">
								<div class="section colm colm12">
									<input checked style="top:5px;margin-right: 15px;" class="field radio" type="radio" name="line_3_columns" value="1">1 
								  	<input style="top:5px;margin-left:30px;margin-right: 15px;" class="field radio" type="radio" name="line_3_columns" value="2">2  
								  	<input style="top:5px;margin-left:30px;margin-right: 15px;" class="field radio" type="radio" name="line_3_columns" value="3">3
								</div>
							</div>

							<div class="frm-row">
								<div class="section colm colm4">
									<label class="field select" id="line_3_1_container" style="display:none">
										<select id="line_3_1" name="line_3_1">
											<option value="">---- Select Column ----</option>
										</select>
										<i class="arrow double"></i>
									</label>
								</div>
								<div class="section colm colm4" id="line_3_2_container" style="display:none">
									<label class="field select">
										<select id="line_3_2" name="line_3_2">
											<option value="">---- Select Column ----</option>
										</select>
										<i class="arrow double"></i>
									</label>
								</div>
								<div class="section colm colm4" id="line_3_3_container" style="display:none">
									<label class="field select">
										<select id="line_3_3" name="line_3_3">
											<option value="">---- Select Column ----</option>
										</select>
										<i class="arrow double"></i>
									</label>
								</div>
							</div>
						</div>
					</div>
					<div class="form-footer" style="margin: 0px 20px;">
						<button type="submit" class="button btn-primary">Export PDF</button>
						<button type="reset" data-dismiss="modal" aria-label="Close" class="button">Cancel</button>
					</div>
				</div>
			</form>
		</div>
	</div>
</div>


