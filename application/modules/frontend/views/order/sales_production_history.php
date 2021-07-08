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

    	#orders_listing_filter {
    		display: inline-flex;
    		float: right;
    	}

    	select#month_filter {
    		margin-bottom: 0px;
		    margin-left: 0.5em;
		    border: 1px solid #cbd2d6;
		    border-radius: 3px;
		    padding: 9px 22px 12px;
    	}

		select#orders_filter {
    		margin-bottom: 0px;
		    margin-left: 0.5em;
		    border: 1px solid #cbd2d6;
		    border-radius: 3px;
		    padding: 9px 22px 12px;
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
			font-size: 14px;
			letter-spacing: 1px;
		}

		.sales_loan_count {
			font-size: 40px;
			color: #0A3B5B;
			text-align: center;
			font-weight: 800;
			letter-spacing: -1.00px;
		}

		.sales_loan_section {
			text-align: center;
			text-transform: uppercase;
			font-size: large;
			line-height: 21px;
			color: #a0a0a0;
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
							<h4 class="ui-title-block_light">Below is list of all your files for the current year of <b><?php echo date('Y');?></b></h3>
						</div>
						<div class="typography-sectiona">
							<div class="col-md-12">
								<div class="table-container">
									<table class="table table-type-3 typography-last-elem" id="production_history">
										<thead>
											<tr>
                                                <th>No</th>
												<th>#</th>
												<th>Opened</th>
												<th>Property Address</th>
												<th>Revenue</th>
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
	
    <!-- Partners Modal -->
	<?php
        $this->load->view('layout/footer');
    ?>

</body>
</html>
<script>
	$(document).ready(function () {
		if ($('#production_history').length) {
			order_list = $('#production_history').DataTable({
				// "pageLength": 2,
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
				initComplete: function () {
					
					
                },
				// dom: 'Bfrtip',
				"dom": 'lf<"production_history_filter">rtip',
				buttons: [],
				"drawCallback": function () {
					
				},
				"ordering": false,
				"serverSide": true,
				"ajax": {
					url: base_url + "get-sales-production-history", // json datasource
					type: "post", // method  , by default get
					data   : function( d ) {
	                  
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
						$("#production_history tbody").append(
							'<tr><td colspan="7" class="text-center">No records found</td></tr>');
						$("#production_history_processing").css("display", "none");
					}
				}
			});
		}
	});	
</script>