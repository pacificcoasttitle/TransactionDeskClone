<body>
	<?php
        $this->load->view('layout/header_dashboard');
    ?>
    <style type="text/css">

		table#orders_listing tr td:last-child {
			display: inline-flex;
		}

		.ui-autocomplete {
			max-height: 300px !important;
		}

    	

    	

    	.button-color {
		    color: #888888;
		}

		td.dataTables_empty {
			display: table-cell !important;
		}

		.modal-dialog{
		    overflow-y: initial !important
		}
		
		.modal-body{
		    height: 700px;
		    overflow-y: auto;
		}

		.square-box{
			background-color: #f0f0f0;
			width: 23% !important;
			margin-right: 2%;
			margin-bottom: 50px;
			padding-bottom: 35px;
	    	padding-top: 15px;
		}

		.order-count-cotainer {
			margin-top: 50px;
		}

		.title {
			text-align: center;
			color: #a0a0a0;
			width: 23% !important;
			margin-right: 2%;
			text-transform: uppercase;
			font-size: 15px;
			letter-spacing: 0px;
		}

		.sales_loan_count {
			font-size: 48px;
			color: #0D5772;
			text-align: center;
			font-weight: 800;
			letter-spacing: -1.00px;
			border-bottom: 1px solid #fff;
		}

		.sales_loan_section {
			text-align: center;
			text-transform: uppercase;
			font-size: 21px;
			line-height: 27px;
			color: #a0a0a0;
		}
		
		.salesdivider {
			border-bottom: 1px solid #fff;
            padding-top: 20px;
            padding-bottom: 20px;
		}

		.projected_goal_section {
    		color: #d35411;
    		/* font-weight: bold;*/
			text-align: center;
			text-transform: uppercase;
			font-size: large;
			line-height: 21px;
		}

		#orders_listing_filter {
			margin-bottom: 20px;
		}

    </style>
	<section class="section-type-4a section-defaulta" style="padding-bottom:0px;">
		<div class="container">
			<div class="row">
				<div class="row">
					<div class="col-xs-12">
						<div class="typography-section__inner">
							<h2 class="ui-title-block ui-title-block_light">Welcome Back <?php echo $name; ?>,</h2>
							<div class="ui-decor-1a bg-accent"></div>
							<h4 class="ui-title-block_light">Below is order list of pay off.</b></h3>
						</div>
					
						<div class="typography-sectiona">
							<div class="col-md-12">
								<div class="table-container">
									<table class="table table-type-3 typography-last-elem" id="pay_off_orders_listing">
										<thead>
											<tr>
												<th>#</th>
												<th>Opened</th>
												<th>Property Address</th>
												<!-- <th>Buyer/Seller</th> -->
												<th>Status</th>
												<th>Action</th>
											</tr>
										</thead>
										<tbody></tbody>
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
	<?php
        $this->load->view('layout/footer');
    ?>
</body>

</html>
<script>
	$(document).ready(function () {
		var pay_off_orders_listing = '';
		if ($('#pay_off_orders_listing').length) {
			pay_off_orders_listing = $('#pay_off_orders_listing').DataTable({
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
				initComplete: function () {
					
					
                },
				"dom": 'lfrtip',
				buttons: [],
				"drawCallback": function () {
					
				},
				"ordering": false,
				"serverSide": true,
				"ajax": {
					url: base_url + "get-pay-off-orders", // json datasource
					type: "post", // method  , by default get
					data   : function( d ) {
	                  
	                },
					dataFilter: function(data){

						var json = jQuery.parseJSON( data );
						var countingData = json.count_data;
						
						json.recordsTotal = json.recordsTotal;
						json.recordsFiltered = json.recordsFiltered;
						json.data = json.data;
						return JSON.stringify( json );
					},
					error: function (XMLHttpRequest, textStatus, errorThrown) {
						if (parseInt(XMLHttpRequest.status) == 419) {
							alert("You are logged out. Please login.");
						}
						if (parseInt(XMLHttpRequest.status) == 419) {
							setTimeout(function () {
								location.reload();
							}, 1000);
						}
						$("#orders_listing tbody").append(
							'<tr><td colspan="4" class="text-center">No records found</td></tr>');
						$("#orders_listing_processing").css("display", "none");

					}
				}
			});
		}
	});
</script>