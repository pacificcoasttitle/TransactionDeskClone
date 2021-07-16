<body>
	<?php
        $this->load->view('layout/header_dashboard');
    ?>
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
						<div class="typography-sectiona">
							<div class="col-md-12">
								<div class="table-container">
									<table class="table table-type-3 typography-last-elem" id="production_history_tab">
										<thead>
											<tr>
												<th align="center">Month</th>
												<th>Total Openings</th>
												<th>Total Closings</th>
												<th>Total Revenue</th>
												<th>Closing %</th>
											</tr>
										</thead>
										<?php if(!empty($salesHistory)) {?>
											<tbody>
												<?php foreach($salesHistory as $salesData) { ?>
													<tr>
														<td><?php echo $salesData['month'];?></td>
														<td><?php echo $salesData['total_open_count'];?></td>
														<td><?php echo $salesData['total_close_count'];?></td>
														<td><?php echo "$".number_format($salesData['total_premium']);?></td>
														<td><?php echo $salesData['close_order_percetage']."%";?></td>
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