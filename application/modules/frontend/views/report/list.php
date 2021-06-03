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
</style>
<body>
	<?php
        $this->load->view('layout/header_dashboard');
    ?>
    <section class="section-type-4a section-defaulta" style="padding-bottom:0px;">
		<div class="container">
			<div class="row">
				<div class="col-sm-12">
					<div class="">
						<h2 class="ui-title-block ui-title-block_light">Reports</h2>
						<div class="ui-decor-1a bg-accent"></div>
						
					</div>
				</div>
			</div>
			<div class="">
				<div class="row">
					<div class="row">
						<div class="col-md-4">
							<h2>Representative(s)</h2>
							<ul class="u-list">
					          	<?php
					          	foreach($salesReps as $key=>$salesRep):
					          	?>
					          	<li>
					          		<div class="u-pic">
				          			<?php 
				          			$image_url = trim(env('AWS_PATH').$salesRep['sales_rep_report_image']);
				          			if (!empty($salesRep['sales_rep_report_image']) && checkRemoteFile($image_url)): ?>
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
						            	<div><?php echo $salesRep['report_count'];?></div>
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
							<h2>Create New Report</h2>
							<div class="smart-forms smart-container">
								<form method="POST" id="smart-form" enctype="multipart/form-data" novalidate="novalidate" action="<?php echo base_url('reports/importData') ?>">
									<div class="form-body">
										<?php
										$prev_data = $this->session->flashdata('_previous_data');
										if($this->session->flashdata('error')) :
										?>
										<div class="alert alert-danger" role="alert"><?php echo $this->session->flashdata('error');?></div>
										<?php
										elseif($this->session->flashdata('success')):
										?>
										<div class="alert alert-success" role="alert"><?php echo $this->session->flashdata('success');?></div>
										<?php
										endif;
										?>
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
													<input type="text" class="gui-input" name="area_name" value="<?php echo (!empty($prev_data['area_name'])) ? $prev_data['area_name'] : '';?>" placeholder="What Area?">
													<span class="field-icon"><i class="fa fa-map-marker "></i></span>
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
											<?php 
											$field_names = [
												'carrier_route'=>'Route',
												'avg_price' => 'Avg. Price',
												'total_sales' => '#of Sales',
												'NOO_ratio' => 'NOO %',
												'avg_yr_owned' => 'AVG YR',
												'total_units' => '# of Units',
												'sa_site_zip' => 'Zipcode'

											];

											?>
											<div class="section colm colm4">
												<label class="field select">
					                                <select id="sort_by" name="sort_by">
					                                	<option value="">Select Sorting Order</option>
					                                	<?php
					                                	foreach($field_names as $key=>$field_name):
					                                	?>
					                                	<option value="<?php echo $key; ?>" <?php if(!empty($prev_data['sort_by']) && $prev_data['sort_by'] ==  $key) {echo 'selected' ;}?>><?php echo $field_name; ?></option>
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
								<div class="table-container">
									<table class="table table-type-3 typography-last-elem no-footer" id="cpl_listing">
										<thead>
											<tr>
												<th>Date</th>
												<th>Sales Rep</th>
												<th>Zipcode</th>
												<th>Download</th>
											</tr>
										</thead>
										<tbody>
											<?php
											foreach ($reports_data as $report) {

												$pdf_url = trim(env('AWS_PATH').'sales-rep/pdf/'.$report['report_url']);
											?>
											<tr>
												<td><?php echo date('d M y H:i',strtotime($report['created_at'])); ?></td>
												<td><?php echo $report['first_name'].' '.$report['last_name']; ?></td>
												<td><?php echo $report['zip_code']; ?></td>
												<td>
												<?php
												if(!empty($report['report_url'])) : ?>
												<a href="<?php echo $pdf_url;?>" target="_blank" download>Download</a>
												<?php endif; ?>
												</td>
											</tr>
											<?php
											}
											?>
											
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

	<?php
        $this->load->view('layout/footer');
    ?>
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/frontend/css/smart-forms.css">
</body>
</html>

