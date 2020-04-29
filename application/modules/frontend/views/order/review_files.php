<body>
	<?php
	    $this->load->view('layout/header_dashboard');
	?>
	<section class="section-type-4a section-defaulta" style="padding-bottom:0px;">
		<div class="container">
			<div class="row">
				<div class="col-xs-12">
					<div class="typography-section__inner">
						<h2 class="ui-title-block ui-title-block_light">Review Files</h2>
						<div class="ui-decor-1a bg-accent"></div>
						<h3 class="ui-title-block_light">Below are all files</h3>
					</div>
					<div class="typography-sectiona">
						<div class="col-md-12">
							<div class="table-container">
								<table class="table table-type-3 typography-last-elem no-footer" id="prelim_files">
									<thead>
										<tr>
										  <th>#</th>
										  <th>File Number</th>
										  <th>Property Address</th>
										  <th>Files</th>
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
	</section>
	<?php
	    $this->load->view('layout/footer');
	?>
</body>
</html>

<script>
	$(document).ready(function () {
		if ($('#prelim_files').length) {
			customer_list = $('#prelim_files').DataTable({
				"paging": true,
				"lengthChange": false,
				"language": {
					paginate: {
						next: '<span class="fa fa-angle-right"></span>',
						previous: '<span class="fa fa-angle-left"></span>',
					},
					"emptyTable": "Record(s) not found.",
				},
				"searching": false,
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
					url: base_url + "get-orders-prelim", // json datasource
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
						$("#cpl_listing tbody").append(
							'<tr><td colspan="4" class="text-center">No records found</td></tr>');
						$("#cpl_listing_processing").css("display", "none");
					}
				}
			});
		}
	});
</script>