<style>
th {
	text-align: center;
}
</style>
<body>
	<?php
        $this->load->view('layout/header_dashboard');
    ?>
	<section class="section-type-4a section-default typography-section-border" style="padding-bottom:0px;">
		<div class="container">
			<div class="row">
				<div class="row">
					<div class="col-xs-12">
						<div class="typography-section__innera">
							<h2 class="ui-title-block ui-title-block_light">Welcome Back <?php echo $name; ?>,</h2>
							<div class="ui-decor-1a bg-accent"></div>
							<h3 class="ui-title-block_light">How can we help you today?</h3>
						</div>
						
						
								<div class="typography-sectiona">
									<div class="col-md-12">
									
									
									<a href="<?php echo base_url().'order'; ?>">
											<button class="btn1 btn-type-1a btn-lg" type="button">New Title Order</button>
										</a>
										<a href="<?php echo base_url().'cpl-dashboard'; ?>">
											<button class="btn1 btn-type-1b btn-lg" type="button">Generate CPL</button>
										</a>
										
										<a href="<?php echo base_url().'proposed-insured'; ?>">
											<button class="btn1 btn-type-1e btn-lg" type="button">Proposed</button>
										</a>
										
										
									</div>
								</div>
					
								<div class="typography-sectionc">
									<div class="col-md-12">
									
										<?php
											if(isset($is_master) && empty($is_master))
											{
										?>
												<a href="<?php echo base_url().'fees'; ?>">
													<button class="btn1 btn-type-1g btn-lg" type="button">Fee Estimate</button>
												</a>
										<?php
											}
											
										?>
										
										<?php if (isset($user_email) && !empty($user_email) && (trim($user_email) == 'gladys@greenforestescrow.net' || trim($user_email) == 'openorders@empowerescrow.com' || trim($user_email) == 'docs@greenforestescrow.net' || trim($user_email) == 'patricia@greenforestescrow.net' || trim($user_email) == 'ashley@legacyfirstescrow.com')) { ?>
											<a href="<?php echo base_url().'prelim-files'; ?>">
												<button class="btn1 btn-type-1c btn-lg" type="button">Review Prelim</button>
											</a>
										<?php } ?>
										
										
										<a href="<?php // echo base_url().'attach-files'; ?>">
											<button class="btn1 btn-type-1d btn-lg" type="button">Upload Doc</button>
										</a>
									
									
									</div>
							    </div>
							
							
							
							<!-- 
								<div class="col-md-3">
									<div class="card-block"></div>
								</div>
								<div class="col-md-3">
									<div class="card-block"></div>
								</div>
								<div class="col-md-3">
									<div class="card-block"></div>
								</div>
								<div class="col-md-3">
									<div class="card-block"></div>
								</div>
							     -->
								
								
								
							
								
								
								
                  				
								
						
							
							<!--
							   <div class="col-md-3">
									<div class="card-block"></div>
								</div>
								<div class="col-md-3">
									<div class="card-block"></div>
								</div>
								<div class="col-md-3">
									<div class="card-block"></div>
								</div>
								<div class="col-md-3">
									<div class="card-block"></div>
								</div> -->
							
							
							
								<!-- <a href="<?php // echo base_url().'proposed-insured'; ?>">
									<button class="btn1 btn-type-1e btn-lg" type="button">Proposed</button>
								</a> -->
								<!-- <a href="<?php // echo base_url().'recordings'; ?>">
									<button class="btn1 btn-type-1f btn-lg" style="" type="button">Confirmations</button>
								</a> -->
								<!-- <a href="<?php // echo base_url().'fees'; ?>">
									<button class="btn1 btn-type-1g btn-lg" type="button">Fee Estimate</button>
								</a> -->
								<!-- <a href="<?php // echo base_url().'notes'; ?>">
									<button class="btn1 btn-type-1h btn-lg" type="button">Notes on Files</button>
								</a> --> 
								
								
						
					</div>
				</div>
			</div>
		</div>


	</section>
	<section class="section-type-4a section-defaulta" style="padding-bottom:0px;">
		<div class="container">
			<div class="row">
				<div class="row">
					<div class="col-xs-12">
						<div class="typography-section__inner">
							<h2 class="ui-title-block ui-title-block_light">Recent Orders,</h2>
							<div class="ui-decor-1a bg-accent"></div>
							<h3 class="ui-title-block_light">Below are all your orders.</h3>
						</div>
						<div class="typography-sectiona">
							<div class="col-md-12">
								<div class="table-container">
									<table class="table table-type-3 typography-last-elem" id="order_listing">
										<thead>
											<tr>
												<th>No</th>
												<th>#</th>
												<th>Opened</th>
												<th>Property Address</th>
												<th>Buyer/Seller</th>
												<th>Action</th>
											</tr>
										</thead>
										<tbody>
											<?php 
												/*if(!empty($order_lists)) {
													foreach($order_lists as $order) { ?>
														<tr>
															<td><?php echo $order['file_number']; ?></td>
															
															<td><?php echo date("m/d/Y", strtotime($order['created_at'])); ?></td>
															
															<td><?php echo $order['full_address']; ?></td>
															<td><?php echo $order['primary_owner']; ?></td>
															<td>
																<a href="<?php echo base_url()."cpl-dashboard";?>" style="margin-right:10px;"><i class="fa fa-upload" aria-hidden="true"></i></a>
																<a href="<?php echo base_url()."proposed-insured/";?>"><i class="fa fa-sticky-note-o"></i></a>
																<?php
																	if($order['borrower_invited'] == 0) :
																?>
																<a title="Send Invite" href="#" data-owner="<?php echo $order['primary_owner'] ?>" data-order="<?php echo $order['id'] ?>"  data-toggle="modal" class="sendInvite" data-address="<?php echo $order['full_address']; ?>" style="margin-left: 10px;"><i class="fa fa-envelope"></i></a>
																
																<?php endif; ?>

															</td>
														</tr>
													<?php } 
												} else { ?>
													<tr>
														<td colspan="8">No Records Found.</td>
													</tr>
												<?php }
											*/?>	
										</tbody>
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
		</div>

	</section>

	<div class="modal fade" id="sendInviteModal" tabindex="-1" role="dialog" 
		aria-hidden="true">
		<div class="modal-dialog modal-lg modal-dialog-centered" role="document">
			<div class="modal-content">
				<form  id="inviteForm" method="post">
					<div class="modal-header">
						<button type="button" class="close pull-right" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
						<h4 class="modal-title">Send Invite to Borrower</h4>
					</div>
					<div class="modal-body search-result">
							
							<div class="error-cotent">
								
							</div>
							<div class="row">
								<div class="col-sm-12">
									<div class="form-group">
					                    <label  class="col-sm-2 control-label" for="borrower_email">Email</label>
					                    <div class="col-sm-10">
					                        <input type="email" class="form-control" id="borrower_email" name="borrower_email" placeholder="Email" required="" />
					                    </div>
				                  	</div>

				                  	<div class="form-group">
					                    <label  class="col-sm-2 control-label" for="borrower_name">Name</label>
					                    <div class="col-sm-10">
					                        <input type="text" class="form-control" id="borrower_name" name="borrower_name" placeholder="Email"/>
					                    </div>
					                    <input type="hidden"  id="invite_order_id" name="invite_order_id">
					                    <input type="hidden"  id="property_address" name="property_address">
				                  	</div>		
								</div>
							</div>

					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-warning" data-dismiss="modal">Close</button>
						<button type="button" class="btn btn-danger" id="sendInviteBtn">Send</button>
					</div>
				</form>
			</div> <!-- content-->
		</div>
	</div>
	<?php
           $this->load->view('layout/footer');
        ?>

<script type="text/javascript">
	$(document).ready(function () {
		if ($('#order_listing').length) {
			order_listing = $('#order_listing').DataTable({
				"paging": true,
				"lengthChange": false,
				"language": {
					searchPlaceholder: "Search File# or Address",
					paginate: {
						next: '<span class="fa fa-angle-right"></span>',
						previous: '<span class="fa fa-angle-left"></span>',
					},
					"emptyTable": "Record(s) not found.",
					"search": "",
				},
				/*"searching": false,*/
				"bStateSave": true,
				"fnStateSave": function (oSettings, oData) {
					localStorage.setItem('offersDataTables', JSON.stringify(oData));
				},
				"fnStateLoad": function (oSettings) {
					return JSON.parse(localStorage.getItem('offersDataTables'));
				},
				initComplete: function () {


				},
				dom: 'Bfrtip',
				buttons: [],
				"drawCallback": function () {

				},
				"ordering": false,
				"serverSide": true,
				"ajax": {
					url: base_url + "get-orders-dashboard", // json datasource
					type: "post", // method  , by default get
					error: function (XMLHttpRequest, textStatus, errorThrown) {
						if (parseInt(XMLHttpRequest.status) == 419) {
							alert("You are logged out. Please login.");
						}
						if (parseInt(XMLHttpRequest.status) == 419) {
							setTimeout(function () {
								location.reload();
							}, 1000);
						}
						$("#order_listing tbody").append(
							'<tr><td colspan="4" class="text-center">No records found</td></tr>');
						$("#order_listing_processing").css("display", "none");
					}
				}
			});
		}
	});

	$(document).on('click','.sendInvite',function(){
		var orderId = $(this).data('order');
		var owner = $(this).data('owner');
		var address = $(this).data('address');
		$("#borrower_name").val(owner);
		$("#invite_order_id").val(orderId);
		$("#property_address").val(address);
		$("#sendInviteModal").modal('show');
	});

	$(document).on('click','#sendInviteBtn',function(){
		$(this).attr('disabled',true);
		var form_data = $('#inviteForm').serialize();
		var url = "<?php echo base_url('send_invite')?>";
		$('.error-cotent').html('');
		$.ajax({
	        type:"POST",
	        url:url,
	        data:form_data,
	        dataType : 'json',
	        success:function (data) {
	            if(data.status == true) {
	            	location.reload();
	            }
	            else {
	            	$('.error-cotent').html(`<div class="alert alert-danger" role="alert">`+data.message+`</div>`);
	            }
	        },
	        complete: function() {
				$('#sendInviteBtn').removeAttr('disabled');
	        }
        });   
	});
	
</script>
</body>

</html>
