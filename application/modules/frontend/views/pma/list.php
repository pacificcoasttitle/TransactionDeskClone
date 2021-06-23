<link rel="stylesheet" type="text/css" href="http://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css">
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/frontend/css/smart-forms.css">
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
	.loading-screen #page-preloader {
		background: rgba(1,1,1,0.5);
		display: block !important;
	}
	.search-result-div .btn {
		padding: 10px 15px;
	}
	#run-pma-form .form-control {
		border-radius: 5px;
    	border: 1px solid #aaaaaa;
    	color: inherit;
	    font-size: inherit;
	    font-family: inherit;
	}
	.modal .close:hover, .modal .close:focus {
		color: #111;
	}
	.ui-autocomplete {
		max-height: 200px;
	}
	.ui-autocomplete .ui-menu-item {
		background: none;
		padding: 5px 10px;
	}
	.ui-autocomplete .ui-menu-item:hover{
		background: blue;
	}
	.ui-state-hover, .ui-widget-content .ui-state-hover, .ui-widget-header .ui-state-hover, .ui-state-focus, .ui-widget-content .ui-state-focus, .ui-widget-header .ui-state-focus {
		border: 0px;
		background: none;
	}
	.ui-autocomplete .ui-menu-item:hover a{
		color: #fff;
	}
	#cpl_listing tbody {
		display: table-row-group !important;
	}
</style>
<body>
	<?php
        $this->load->view('layout/header_dashboard');
    ?>
    <section class="section-type-4a1 section-defaulta" style="padding-bottom:0px;">
		<div class="container">
			<div class="row">
				<div class="col-sm-12">
					<div class="">
						<h2 class="ui-title-block ui-title-block_light">Concierge Profile<a href="<?php echo base_url('reports'); ?>" class="pull-right report_switch_btn">Create F.A.R</a></h2>
						<div class="ui-decor-1a bg-accent"></div>
						
					</div>
				</div>
			</div>
			<div class="">
				<div class="row">
					<div class="row">
						<div class="col-md-4">
							<div>
								
								<h4>Total Ran</h4>
								<div class="pma-total"> 0 </div>
							</div>
							<div>
								<h4>Accumilated Cost</h4>
								<div class="accrued-cost"> 0 </div>
							</div>
							<ul class="u-list">
					          	<?php
					          	/* foreach($salesReps as $key=>$salesRep):
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
						              <div>
						              	PMA's :<?php echo $salesRep['pma'];?>
						              </div>
						            </div>
						            <div class="u-count">
						            	<div><?php echo $salesRep['pma_count'];?></div>
						            </div>
					          	</li>
					          	<?php
					          	if($key == 9) {
					          		break;
					          	}
					          	endforeach; */
						        ?>
					        </ul>
						        <?php /* if(count($salesReps) > 10) : ?>
						        	<div class="pull-right">
						        		<a href="<?=base_url('reports/sales_rep')?>" class="btn btn-success">View All</a>
						        	</div>
						        <?php endif; */ ?>
						</div>

						<div class="col-md-8">
							<!-- <h2>Create New Report</h2> -->
							<div class="smart-forms smart-container">
								<form method="POST" id="smart-form" enctype="multipart/form-data" novalidate="novalidate" action="<?php echo base_url('pma/importData') ?>">
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
											<div class="section colm colm8">

												<label class="field prepend-icon">
						                            
						                			<input type="text" class="js-pma-address gui-input" name="address_input" id="js-property-search" 
						                            value="<?php echo (!empty($prev_data['address_input'])) ? $prev_data['address_input'] : '';?>" placeholder="Property Address">
						                            <input id="js-apn-search" placeholder="APN" class="formpma js-pma-apn gui-input" type="text" value="" name="subject">
						                            <span class="field-icon"><i class="fa fa-map-marker"></i></span>
						                        </label>
											</div>

											<div class="section colm colm4">
												<label class="field prepend-icon">
													<input type="text" class="gui-input js-pma-city js-pma-fips" name="city_input" value="<?php echo (!empty($prev_data['city_input'])) ? $prev_data['city_input'] : '';?>" placeholder="City">
													<span class="field-icon"><i class="fa fa-map-marker "></i></span>
												</label>
											</div>
											
													
											

											<div class="section colm colm12">
												
													
												
												<button type="button" class="button btn-primary js-find-property js-search-button">Find Property</button>
												<button type="button" class="button btn-default switch-search js-switch-search">Switch to APN Search</button>
								
											</div>
													
												
										</div>
									</div>
								</form>
							</div>

							
							<div style="margin-bottom: 50px" class="hide search-result-div">
								<h2>Search Results</h2>
								<div class="address-result">
									<div class="pma-error"></div>
									<table class="table table-type-3 typography-last-elem no-footer result-table" id="cpl_listing_1">
										<thead>
											<tr>
												<th>APN</th>
												<th>Address</th>
												<th>City</th>
												<th>Create</th>
											</tr>
										</thead>
										<tbody>
											<td><span class="result-apn"></span></td>
											<td><span class="result-address"></span></td>
											<td><span class="result-city"></span></td>
											<td><button type="button" class="btn btn-info js-run-pma-button">Create</button></td>
											
										</tbody>
									</table>
								</div>
							</div>

							<div>
								<h2>Recent Concierge Property Profiles</h2>
								<div class="table-container1">
									<table class="table table-type-3 typography-last-elem no-footer recent-reports" id="cpl_listing">
										<thead>
											<tr>
												<th>Date</th>
												<th>PCT Rep</th>
												<th>Address</th>
												<th>Download</th>
											</tr>
										</thead>
										<tbody>
											
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

	<div class="modal fade" id="run-pma-dialog" title="Report Info" tabindex="-1" role="dialog" aria-hidden="true">
		<div class="modal-dialog modal-dialog-centered modal-lg" role="document">
			<div class="modal-content">
			  	<form id="run-pma-form">
			  		<div class="modal-header" style="padding: 25px;">
						<button type="button" class="close pull-right" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
						<h2 class="modal-title">Profile Details</h2>
					</div>
					<div class="modal-body search-result">
				  		<fieldset>
				  		<div class="custom-pma-field form-group">
				  			<label class="control-label col-sm-2" for="rep-name" >Rep:</label>
				  			<div class="col-sm-10">
					  			<select name="rep-name" type="text" id="rep-name" class="form-control">
								</select>
							</div>
						</div>
				  		<div class="custom-pma-field form-group">
						    <label class="control-label col-sm-2" for="realtor-name">Realtor Name:</label>
						    <div class="col-sm-10">
						    	<input type="text" name="realtor-name" id="realtor-name" class="text  form-control" />
						    </div>
						</div>
						<div class="custom-pma-field form-group">
					   		<label class="control-label col-sm-2" for="realtor-company"> Company:</label>
					   		<div class="col-sm-10">
					   			<input type="text" name="realtor-company" id="realtor-company" value="" class="text  form-control" />
					   		</div>
						</div>
						<div class="custom-pma-field form-group">
						    <label class="control-label col-sm-2" for="realtor-address"> Address:</label>
						    <div class="col-sm-10">
						    	<input type="text" name="realtor-address" id="realtor-address" value="" class="text  form-control" />
						    </div>
				  		</div>
				  		<div class="custom-pma-field form-group hide">
				  			<label class="control-label col-sm-2" for="tabs">Include Tabs?</label>
				  			<div class="col-sm-10">
					  			<select id="tabs" name="tabs" class="form-control">
					  				<option value="Yes">Yes</option>
					  				<option value="No">No</option>
					  			</select>
					  		</div>
				  		</div>
				  		<div class="custom-pma-field form-group include-docs hide">
				  			<label class="control-label col-sm-2" for="docs">Include Docs?</label>
				  			<div class="col-sm-10">
					  			<select id="include-docs" name="include-docs" class="form-control">
					  				<option value="Yes">Yes</option>
					  				<option value="No" selected="selected">No</option>
					  			</select>
					  		</div>
				  		</div>
				  		<div class="custom-pma-field form-group">
				  			<label class="control-label col-sm-2" for="comps">Select Comps</label>
				  			<div class="col-sm-10">
					  			<select id="include-comps" name="include-comps" class="form-control">
					  				<option value="Yes">Yes</option>
					  				<option value="No" selected="selected">No</option>
					  			</select>
					  		</div>
				  		</div>
				  		</fieldset>
					</div>
					<div class="modal-footer">
				  		<button type="button" class="btn button blueButton pma-modal-submit" style="background: #d35411;">Submit</button>
					</div>
			  </form>
	  		</div>
		</div>
	</div> <!-- Report Info Modal-->
	<div class="modal fade" id="comps-dialog" tabindex="-1" role="dialog" aria-hidden="true">
		<div class="modal-dialog modal-dialog-centered modal-lg" role="document">
			<div class="modal-content">

				<form id="comps-form">
			  		<div class="modal-header comps-header">
						<button type="button" class="close pull-right" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
						<h4 class="modal-title ">Please select up to 8 comparable sales to feature prominently in your property profile. You can also ensure that properties will <em>not</em> be included in the profile by clicking the corresponding red "X" when you hover over a property</h4>
					</div>

					<div class="modal-body search-result">
						<div class="comps-error"></div>
				  		<table id="comps-table">
				  		<colgroup>
					        <col span="1" style="width: 20%;">
					        <col span="1" style="width: 13%;">
					        <col span="1" style="width: 12%;">
					        <col span="1" style="width: 11%;">
					        <col span="1" style="width: 12%;">
					        <col span="1" style="width: 12%;">
					        <col span="1" style="width: 12%;">
					        <col span="1" style="width: 8%;">
				        </colgroup>
				  		<thead>
				  		<tr>
							<th>Address</th>
							<th>Living Area</th>
							<th>Lot Size</th>
							<th>BDs/BRs</th>
							<th>Sale Date</th>
							<th>Distance</th>
							<th>Sale Price</th>
						</tr>
				  		</thead>
				  		</table>
				  		<div class="comps-error"></div>
					</div>
			  		<div class="modal-footer">
				  		<button type="button" class="btn comps-submit" style="background: #d35411;">Submit</button>
					</div>
			 	</form>

			</div>
		</div>
	  	
	</div><!-- comp selection -->
	
	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/frontend/css/tablesorter-blue.css"  media="screen" type="text/css" />


	<?php
        $this->load->view('layout/footer');
    ?>

    <script type="text/javascript" src="http://maps.googleapis.com/maps/api/js?key=AIzaSyCoMfJn9Q37LUYQucbUdgWF8JGWRuTZlt4&libraries=places&sensor=false"></script>
	<script type="text/javascript" src="http://code.jquery.com/ui/1.10.3/jquery-ui.js"></script>
	<script type="text/javascript" src="<?php echo base_url(); ?>assets/frontend/js/jquery.tablesorter.min.js"></script> 

    <script src="<?php echo base_url(); ?>assets/frontend/js/pma.js?v=0.2"></script>

    <script type="text/javascript">
    	/*function autoComplete() {
		    // use Google Places API to autocomplete address searches and bias suggestions to California
		    var input = document.getElementById('address_input');
		    var defaultBounds = new google.maps.LatLngBounds(
		        new google.maps.LatLng(-32.30, 114.8),
		        new google.maps.LatLng(-42, 124.24)); // latitude and longitude ranges of California
		    var options = {
		        componentRestrictions: {
		            country: 'us'
		        },
		        bounds: defaultBounds
		    };
		    autocomplete = new google.maps.places.Autocomplete(input, options);
		    google.maps.event.addListener(autocomplete, 'place_changed', function() {
		        var place = autocomplete.getPlace(); // get address, without city and state
		        setTimeout(function() {
		            $('.js-pma-address').val(place.name);
		        }, 25); // just display street address
		        for (var i = 0; i < place.address_components.length; i++) {
		            for (var j = 0; j < place.address_components[i].types.length; j++) {
		                if (place.address_components[i].types[j] === ("locality" || "political")) {
		                    var city = place.address_components[i].long_name;
		                    $('.js-pma-city').val(city);
		                }
		            }
		        }
		    });
		} */

    	$(document).ready(function(){

    		autoComplete();

    		
    	});
    </script>
</body>
</html>

