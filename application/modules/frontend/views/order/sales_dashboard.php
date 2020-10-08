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

    </style>
	<section class="section-type-4a section-defaulta" style="padding-bottom:0px;">
		<div class="container">
			<div class="row">
				<div class="row">
					<div class="col-xs-12">
						<div class="typography-section__inner">
							<h2 class="ui-title-block ui-title-block_light">Welcome Back <?php echo $name; ?>,</h2>
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
	                  d.status= $('#orders_filter').val();
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

			$("div#orders_listing_filter").append('<label><select style="width:auto;" name="orders_filter" id="orders_filter" class="custom-select custom-select-sm form-control form-control-sm"> <option value="open"> Open </option><option value="closed">Closed</option></select></label>');
		}

		$("#orders_filter").on("change", function(){
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
					$.each(results.partners, function( key, value ) {
						console.log(value.PartnerType.PartnerTypeName);
		              	table_data += '<tr><td>'+value.PartnerID+'</td><td>'+value.PartnerTypeID+'</td><td>'+value.PartnerType.PartnerTypeName+'</td><td>'+value.PartnerName+'</td></tr>'
		            });
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
</script>