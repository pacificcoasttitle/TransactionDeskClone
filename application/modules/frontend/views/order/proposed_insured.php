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
							<h2 class="ui-title-block ui-title-block_light">Generate Proposed Insured</h2>
							<div class="ui-decor-1a bg-primary"></div>
							<h3 class="ui-title-block_light">Below are all files</h3>
						</div>
						<div class="typography-sectiona">
							<div class="col-md-12">
								<div class="table-container">
									<table class="table table_primary" id="orders_listing">
										<thead>
											<tr>
												<th>#</th>
												<th>File Number</th>
												<th>Property Address</th>
												<th>Action</th>
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
			order_list = $('#orders_listing').DataTable({
				// "pageLength": 2,
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
					url: base_url + "get-proposed-orders", // json datasource
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
							'<tr><td colspan="4" class="text-center">No records found</td></tr>');
						$("#orders_listing_processing").css("display", "none");

					}
				}
			});
		}
	});

function generateProposedInsured(fileId)
{
	if(fileId)
	{
		$.ajax({
            url: base_url + "generate-proposed-insured",
            type: "post",
            data:{
                fileId: fileId,
            },
            success: function(response) {
            	if(response)
                {
                    if (navigator.msSaveBlob)
                    {                       
                        var csvData = base64toBlob(response,'application/octet-stream');
                        var csvURL = navigator.msSaveBlob(csvData, 'ProposedInsured.pdf');
                        var element = document.createElement('a');
                        element.setAttribute('href', csvURL);
                        element.setAttribute('download', 'ProposedInsured.pdf');
                        element.style.display = 'none';
                        document.body.appendChild(element);
                        document.body.removeChild(element);
                    }
                    else
                    {

                        var csvURL = 'data:application/octet-stream;base64,'+response;
                        var element = document.createElement('a');
                        element.setAttribute('href', csvURL);
                        element.setAttribute('download', 'ProposedInsured.pdf');
                        element.style.display = 'none';
                        document.body.appendChild(element);
                        element.click();
                        document.body.removeChild(element);
                    }
                }
            }
        });
	}
	else
	{
		alert("File ID required.");
	}
}

function base64toBlob(base64Data, contentType) 
{
    contentType = contentType || '';
    var sliceSize = 1024;
    var byteCharacters = (base64Data);
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
