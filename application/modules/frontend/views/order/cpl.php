<body>
	<?php
        $this->load->view('layout/header_dashboard');
    ?>

	<section class="section-type-4a section-defaulta" style="padding-bottom:0px;">
		<div class="container">
			<div class="row">
				<div class="row">
					<div class="col-xs-12">
                        <div class="typography-section__inner">
                            <h2 class="ui-title-block ui-title-block_light">Closing Protection Letters</h2>
                            <div class="ui-decor-1a bg-primary"></div>
                            <h3 class="ui-title-block_light">Generate your CPL</h3>
						</div>
						<?php if(!empty($success)) {?>
							<div id="agent_success_msg" class="w-100 alert alert-success alert-dismissible" >
								<?php foreach($success as $sucess) {
									echo $sucess."<br \>";	
								}?>
							</div>
						<?php } 
						 if(!empty($errors)) {?>
							<div id="agent_error_msg" class="w-100 alert alert-danger alert-dismissible" >
								<?php foreach($errors as $error) {
									echo $error."<br \>";	
								}?>
							</div>
						<?php } ?>
						<div class="loader"></div>
						<div class="typography-sectiona">
							<div class="col-md-12">
								<div class="table-container">
									<table class="table table_primary" id="cpl_listing">
										<thead>
											<tr>
												<th>#</th>
												<th>File Number</th>
												<th>Property Address</th>
												<th></th>
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
		if ($('#cpl_listing').length) {
			customer_list = $('#cpl_listing').DataTable({
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
				initComplete: function () {
					
					
                },
				dom: 'Bfrtip',
				buttons: [],
				"drawCallback": function () {
					
				},
				"ordering": false,
				"serverSide": true,
				"ajax": {
					url: base_url + "get-orders-cpl", // json datasource
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

		$("#files_upload").submit(function( event ) {
			$('#page-preloader').css('background-color', 'rgba(0,0,0,.5)');
			$('#page-preloader').css('display', 'block');
		});

	});

	function download_for_pdf(westcor_file_id, westcor_order_id)
	{
		$('#page-preloader').css('background-color', 'rgba(0,0,0,.5)');
		$('#page-preloader').css('display', 'block');
		$.ajax({
			url: base_url + "download-cpl-pdf",
			type: "post",
			data:{
				westcor_file_id: westcor_file_id,
				westcor_order_id: westcor_order_id,
			}, 
			success: function(response) {
				$('#page-preloader').css('display', 'none');
				if (response) {
					if (navigator.msSaveBlob) {                       
						var csvData = base64toBlob(response,'application/octet-stream');
						var csvURL = navigator.msSaveBlob(csvData, 'FeeEstimation.pdf');
						var element = document.createElement('a');
						element.setAttribute('href', csvURL);
						element.setAttribute('download', 'FeeEstimation.pdf');
						element.style.display = 'none';
						document.body.appendChild(element);
						document.body.removeChild(element);
					} else {
						var csvURL = 'data:application/octet-stream;base64,'+response;
						var element = document.createElement('a');
						element.setAttribute('href', csvURL);
						element.setAttribute('download', 'FeeEstimation.pdf');
						element.style.display = 'none';
						document.body.appendChild(element);
						element.click();
						document.body.removeChild(element);
					}
				}
			}
		});
	}

	function base64toBlob(base64Data, contentType) 
	{
		contentType = contentType || '';
		var sliceSize = 1024;
		var byteCharacters = atob(base64Data);
		var bytesLength = byteCharacters.length;
		var slicesCount = Math.ceil(bytesLength / sliceSize);
		var byteArrays = new Array(slicesCount);

		for (var sliceIndex = 0; sliceIndex < slicesCount; ++sliceIndex) {
			var begin = sliceIndex * sliceSize;
			var end = Math.min(begin + sliceSize, bytesLength);

			var bytes = new Array(end - begin);
			for (var offset = begin, i = 0; offset < end; ++i, ++offset) {
				bytes[i] = byteCharacters[offset].charCodeAt(0);
			}
			byteArrays[sliceIndex] = new Uint8Array(bytes);
		}
		return new Blob(byteArrays, { type: contentType });
	}
</script>
