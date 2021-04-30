<style>
    td, th {
        line-height: 20px !important;
    }
</style>
<body>
	<?php
        $this->load->view('layout/header_dashboard');
    ?>
	<section class="section-type-4a section-default typography-section-border" style="margin-bottom:50px;">
		<div class="container">
			<div class="row">
				<div class="row">
					<div class="col-xs-12">
						<div class="typography-section__innera">
							<h2 class="ui-title-block ui-title-block_light">Welcome Back <?php echo $name; ?>,</h2>
							<div class="ui-decor-1a bg-accent"></div>
							<h3 class="ui-title-block_light">How can we help you today?</h3>
						</div>
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
							<h2 class="ui-title-block ui-title-block_light">Orders</h2>
							<div class="ui-decor-1a bg-accent"></div>
							<h3 class="ui-title-block_light">Below are all your orders.</h3>
						</div>
						<div class="typography-sectiona">
							<div class="col-md-12">
								<div class="table-container">
									<table class="table table-type-3 typography-last-elem" id="orders_listing">
										<thead>
											<tr>
                                                <th>#</th>
                                                <th>File Number</th>
												<th>Opened</th>
												<th>Property Address</th>
												<th>Buyer/Seller</th>
                                                <th>Sales Rep.</th>
                                                <th>Escrow Partner Company Name</th>
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
	<?php
        $this->load->view('layout/footer');
    ?>
</body>
</html>

<script>
    $(document).ready(function () {
		if ($('#orders_listing').length) {
			customer_list = $('#orders_listing').DataTable({
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
					url: base_url + "get-special-lenders-orders", // json datasource
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
						$("#orders_listing tbody").append(
							'<tr><td colspan="6" class="text-center">No records found</td></tr>');
						$("#corders_listing_processing").css("display", "none");
					}
				}
			});
		}
	});
</script>
