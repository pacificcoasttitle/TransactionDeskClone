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
							<h4 class="ui-title-block_light">Below is your production figures for the current month of <b><?php echo date('F');?></b></h3>
						</div>
						<div class="order-count-cotainer">
							<div class="col-md-3 title">Title Openings MTD</div>
							<div class="col-md-3 title">Title Closings MTD</div>
							<div class="col-md-3 title">Title Revenue MTD</div>
							<div class="col-md-3 title">Closings Ratio Avg</div>

							<div class="col-md-3 square-box">
								<div class="sales_loan_count" id="open_order_count"><?Php echo $total_open_count; ?></div>
								<div class="salesdivider">
								<div class="sales_loan_section">Sales = <span id="sale_open_count"><?Php echo $sale_open_count;?></span></div>
								<div class="sales_loan_section">Refi's = <span id="refi_open_count"><?Php echo $refi_open_count;?></span></div>
								</div>
								<div style="margin-top: 20px;" class="projected_goal_section">Projected = <span id="projected_open_section"><?Php echo $projected_open_count;?></span></div>
								<?php if($sales_rep_info['sales_rep_no_of_open_orders'] > 0) { ?>
									<div class="projected_goal_section">Goal = <span id="goal_open_section"><?Php echo round($sales_rep_info['sales_rep_no_of_open_orders']/12);?></span></div>
								<?php } ?>
							</div>

							<div class="col-md-3 square-box">
								<div class="sales_loan_count" id="close_order_count"><?Php echo $total_close_count; ?></div>
								<div class="salesdivider">
								<div class="sales_loan_section">Sales = <span id="sale_close_count"><?Php echo $sale_close_count;?></span></div>
								<div class="sales_loan_section">Refi's = <span id="refi_close_count"><?Php echo $refi_close_count;?></span></div>
								</div>
								<div style="margin-top: 20px;" class="projected_goal_section">Projected = <span id="projected_close_section"><?Php echo $projected_close_count;?></span></div>
								<?php if($sales_rep_info['sales_rep_no_of_close_orders'] > 0) { ?>
									<div class="projected_goal_section">Goal = <span id="goal_close_section"><?Php echo round($sales_rep_info['sales_rep_no_of_close_orders']/12);?></span></div>
								<?php } ?>
							</div>

							<div class="col-md-3 square-box">
								<div class="sales_loan_count">$<span id="total_premium"><?php echo number_format($total_premium); ?></span></div>
								<div class="salesdivider">
								<div class="sales_loan_section">Sales = $<span id="sale_total_premium"><?php echo number_format($sale_total_premium); ?></span></div>
								<div class="sales_loan_section">Refi's = $<span id="refi_total_premium"><?php echo number_format($refi_total_premium); ?></span></div>
								</div>
								<div style="margin-top: 20px;" class="projected_goal_section">Projected = $<span id="projected_revenue_section"><?Php echo $projected_revenue;?></span></div>
								<?php if($sales_rep_info['sales_rep_premium'] > 0) { ?>
									<div class="projected_goal_section">Goal = $<span id="goal_revenue_section"><?Php echo round($sales_rep_info['sales_rep_premium']/12);?></span></div>
								<?php } ?>
							</div>

							<div class="col-md-3 square-box">
								<div class="sales_loan_count"><span id="close_order_percetage"><?Php echo $close_order_percetage;?></span>%</div>
								<div class="salesdivider">
								<div class="sales_loan_section">Sales = <span id="sale_close_order_percetage"><?Php echo $sale_close_order_percetage;?></span>%</div>
								<div class="sales_loan_section">Refi's = <span id="refi_close_order_percetage"><?Php echo $refi_close_order_percetage;?></span>%</div>
								</div>
								<div style="margin-top: 20px;" class="projected_goal_section">Projected = <span id="refi_open_count">0%</span></div>
								<!-- <div class="projected_goal_section">Goal = <span id="refi_open_count">0%</span></div> -->
							</div>

							<h4 class="ui-title-block_light">Below is list of all your files. You can search for files by month that have a status open, closed, or cancelled.</h3>
						</div>	
						
						<div class="typography-sectiona">
							<div class="col-md-12">
								<div class="table-container">
									<table class="table table-type-3 typography-last-elem" id="orders_listing">
										<thead>
											<tr>
												<th>#</th>
												<!-- <th>Opened</th> -->
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
		</div>

	</section>
	<!-- Partners Modal -->
    <div class="modal" id="partnersModal">
	  <div class="modal-dialog modal-lg">
	    <div class="modal-content">

	      <!-- Modal Header -->
	      <div class="modal-header">
	        <h4 class="modal-title">Partners</h4>
	        <!-- <button type="button" class="close" data-dismiss="modal">&times;</button> -->
	      </div>

	      	<!-- Modal body -->
	      	<div class="modal-body">
	            <table class="table table-striped" id="tbl-partners-data">
				    <thead>
				      <tr>
				        <th>PartnerID</th>
				        <th>PartnerTypeID</th>
				        <th>PartnerTypeName</th>
				        <th>PartnerName</th>
				        <!-- <th>EmailAddress</th> -->
				      </tr>
				    </thead>
				    <tbody></tbody>
			    </table>
			</div>

	      <!-- Modal footer -->
	      <div class="modal-footer">
	        <button type="button" class="btn btn-danger" data-dismiss="modal" style="background: #d35411;">Close</button>
	      </div>

	    </div>
	  </div>
	</div>
    <!-- Partners Modal -->
	<?php
           $this->load->view('layout/footer');
        ?>


</body>

</html>
<script>
	$(document).ready(function () {
		//getSalesRepOrderCount();
		var order_list='';
		if ($('#orders_listing').length) {
			order_list = $('#orders_listing').DataTable({
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
				"dom": 'lf<"orders_listing_filter">rtip',
				buttons: [],
				"drawCallback": function () {
					
				},
				"ordering": false,
				"serverSide": true,
				"ajax": {
					url: base_url + "get-sales-orders", // json datasource
					type: "post", // method  , by default get
					data   : function( d ) {
	                  d.status = $('#orders_filter').val();
					  d.month = $('#month_filter').val();
	                },
					dataFilter: function(data){

						var json = jQuery.parseJSON( data );
						var countingData = json.count_data;
						// if (countingData) {
						// 	console.log(countingData.refi_open_count);
						// 	$('#refi_open_count').html(countingData.refi_open_count);
						// 	$('#sale_open_count').html(countingData.sale_open_count);
						// 	$('#open_order_count').html(countingData.open_order_count);

						// 	$('#refi_close_count').html(countingData.refi_close_count);
						// 	$('#sale_close_count').html(countingData.sale_close_count);
						// 	$('#close_order_count').html(countingData.close_order_count);

						// 	$('#refi_total_premium').html(countingData.refi_total_premium);
						// 	$('#sale_total_premium').html(countingData.sale_total_premium);
						// 	$('#total_premium').html(countingData.total_premium);

						// 	$('#refi_close_order_percetage').html(countingData.refi_close_order_percetage);
						// 	$('#sale_close_order_percetage').html(countingData.sale_close_order_percetage);
						// 	$('#close_order_percetage').html(countingData.close_order_percetage);
							
						// } 
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

			$("div#orders_listing_filter").append('<label><select style="width:auto;" name="month_filter" id="month_filter" class="custom-select custom-select-sm form-control form-control-sm"> <option value="01"> January </option><option value="02">February</option><option value="03">March</option><option value="04">April</option><option value="05">May</option><option value="06">June</option><option value="07">July</option><option value="08">August</option><option value="09">September</option><option value="10">October</option><option value="11">November</option><option value="12">December</option></select></label><label><select style="width:auto;" name="orders_filter" id="orders_filter" class="custom-select custom-select-sm form-control form-control-sm"> <option value="open"> Open </option><option value="closed">Closed</option><option value="cancelled">Cancelled</option></select></label><a href="javascript:void(0);" style="margin-bottom: 5px;"><!-- <button class="btn btn-grad-2a" id="btn-refresh" style="background: #d35411;height: 42px;line-height: 28px;" type="button" onClick="importSalesRepOrders();">Refresh</button></a>-->');

    		var d = new Date(),

				m = d.getMonth(),

				y = d.getFullYear();

			$('#month_filter option:eq('+m+')').prop('selected', true);
		}

		$("#orders_filter").on("change", function(){
	        order_list.ajax.reload();
	    });

		$("#month_filter").on("change", function(){
	        order_list.ajax.reload();
	    });
	});

	function getPartners(fileId) 
	{
		$('#page-preloader').css('background-color', 'rgba(0,0,0,.5)');
		$('#page-preloader').css('display', 'block');
		$.ajax({
			url: base_url + "get-partners",
			type: "post",
			data: {
				fileId: fileId
			},
			dataType: "html",
			success: function (response) {

				var results = JSON.parse(response);
				
				var table_data = '';
				if(results.status == 'success')
				{
					if(!jQuery.isEmptyObject(results.partners))
					{
						$.each(results.partners, function( key, value ) {
			              	table_data += '<tr><td>'+value.PartnerID+'</td><td>'+value.PartnerTypeID+'</td><td>'+value.PartnerType.PartnerTypeName+'</td><td>'+value.PartnerName+'</td></tr>';
			            });
					}
					else
					{
						table_data += '<tr><td colspan="4" style="text-align: center;">No records found.</td></tr>';
					}
					$('#tbl-partners-data tbody').html(table_data);
					$('#partnersModal').modal('show');
				}
				else if(results.status == 'error')
				{
					alert(results.msg);
				}
				$('#page-preloader').css('display', 'none');
			}
		});
	}

	function importSalesRepOrders()
	{
		$('#page-preloader').css('background-color', 'rgba(0,0,0,.5)');
		$('#page-preloader').css('display', 'block');

		$.ajax({
			url: base_url + "import-sales-rep-orders",
			type: "post",
			success: function (response) {

				var results = JSON.parse(response);
				
				if(results.status == 'success')
				{
					$('#btn-refresh').css('background','#d35411');
					order_list.ajax.reload();
				}
				else if(results.status == 'error')
				{
					alert(results.msg);
				}
				$('#page-preloader').css('display', 'none');
			}
		});
	}

	function getSalesRepOrderCount()
	{
		$('#page-preloader').css('background-color', 'rgba(0,0,0,.5)');
		$('#page-preloader').css('display', 'block');

		$.ajax({
			url: base_url + "get-sales-rep-orders-count",
			type: "post",
			success: function (response) {

				var results = JSON.parse(response);
				
				if((results.resware_open_count > results.open_count) || (results.resware_closed_count > results.closed_count))
				{
					// $('#btn-refresh').css('background','#469a47f2');
					$('#btn-refresh').css('background','rgb(0, 102, 68)');
				}
				else
				{
					$('#btn-refresh').css('background','#d35411');
				}
				
				$('#page-preloader').css('display', 'none');
			}
		});
	}
</script>