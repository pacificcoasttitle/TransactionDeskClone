<body>
	<?php
        $this->load->view('layout/header_dashboard');
    ?>
    <style type="text/css">
    	#fileUploadModal .form-control {
    		border: 1px solid;
    	}
    	#fileUploadModal .btn-default {
    		color: #222222;
    	}
    	#orders_listing_filter {
    		display: none;
    	}
    </style>

	<section class="section-type-4a section-defaulta" style="padding-bottom:0px;">
		<div class="container">
				<div class="row">
					<div class="col-xs-12">
						<div class="typography-section__inner">
							<h2 class="ui-title-block ui-title-block_light"><span>Files</span>
								<!-- <span class="pull-right"><button type="button" class="btn btn-warning" data-toggle="modal" data-target="#fileUploadModal">Upload New</button></span> -->
							</h2>
							<div class="ui-decor-1a bg-primary"></div>
							<h3 class="ui-title-block_light">Below you will find all uploaded fiels</h3>
						</div>
						<?php
							if($this->session->flashdata('error')) :
							?>
							<div class="alert alert-danger" role="alert"><?php echo $this->session->flashdata('error');?></div>
							<?php
							elseif($this->session->flashdata('success')):
							?>
							<div class="alert alert-success" role="alert"><?php echo $this->session->flashdata('success');?></div>
							<?php
							endif;
						?>
						<div class="typography-sectiona">
							<div class="col-md-12">
								<div class="table-container">
									
									<table class="table table_primary" id="orders_listing">
										<thead>
											<tr>
												<th>#</th>
												<th>Name</th>
												<th>Description</th>
												<th>Created At</th>
												<th>Download</th>
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

	<!-- Modal -->
<div class="modal fade" id="fileUploadModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
    <form enctype="multipart/form-data" method="post">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Upload File</h5><!-- 
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button> -->
      </div>
      <div class="modal-body">
          <div class="form-group">
            <label for="file-upload" class="col-form-label">Select File:</label>
            <input required="" name="file" type="file" id="file-upload" class="form-control">
          </div>
          <div class="form-group">
            <label for="file-name" class="col-form-label">Enter Name:</label>
            <input  name="name" required="" type="text" class="form-control" id="file-name">
          </div>
          <div class="form-group">
            <label  for="file-description" class="col-form-label">Enter Description:</label>
            <textarea name="description" class="form-control" id="file-description"></textarea>
          </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button class="btn btn-warning">Upload</button>
      </div>
    </form>
    </div>
  </div>
</div>

	<?php
           $this->load->view('layout/footer');
        ?>
</body>

</html>

<script>
	function downloadDocumentFromAws(url, documentType)
    {
        $('#page-preloader').css('background-color', 'rgba(0,0,0,.5)');
		$('#page-preloader').css('display', 'block');
        var fileNameIndex = url.lastIndexOf("/") + 1;
        var filename = url.substr(fileNameIndex);
        $.ajax({
			url: base_url + "download-aws-file",
			type: "post",
			data: {
				url : url
			},
            async: false,
			success: function (response) {
				if (response) {
					if (navigator.msSaveBlob) {
						var csvData = base64toBlob(response, 'application/octet-stream');
						var csvURL = navigator.msSaveBlob(csvData, filename);
						var element = document.createElement('a');
						element.setAttribute('href', csvURL);
						element.setAttribute('download', documentType+"_"+filename);
						element.style.display = 'none';
						document.body.appendChild(element);
						document.body.removeChild(element);
					} else {
						console.log(response);
						var csvURL = 'data:application/octet-stream;base64,' + response;
						var element = document.createElement('a');
						element.setAttribute('href', csvURL);
						element.setAttribute('download', documentType+"_"+filename);
						element.style.display = 'none';
						document.body.appendChild(element);
						element.click();
						document.body.removeChild(element);
					}
				}
                $('#page-preloader').css('display', 'none');
			}
        });
    }
	$(document).ready(function () {
		if ($('#orders_listing').length) {
			customer_list = $('#orders_listing').DataTable({
				// "pageLength": 2,
				"paging": true,
				"lengthChange": false,
				"language": {
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
				dom: 'Bfrtip',
				buttons: [],
				"drawCallback": function () {
					
				},
				"ordering": false,
				"serverSide": true,
				"ajax": {
					url: base_url + "get-file-document", // json datasource
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

</script>
