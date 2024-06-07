
<style type="text/css">

	table#orders_listing tr td:last-child {
		display: inline-flex;
	}

	.ui-autocomplete {
		max-height: 300px !important;
	}

	th, td {
		text-align: center;
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
	<div class="container-fluid pc__top-element">
		<!-- <div class="row mb-3">
			<div class="col-sm-6">
				<h1 class="h3 text-gray-800">Welcome Back <?php echo $name; ?> </h1>
			</div>
		</div> -->
		<div class="card shadow mb-4">
			<div class="card-header datatable-header py-3">
				<div class="datatable-header-titles" >
					<span>
						<i class="fas fa-users"></i>
					</span>
					<h6 class="m-0 font-weight-bold text-primary pl-10">Below is order list of vendos</h6>
				</div>
			</div>
			<?php if (!empty($success)) {?>
			<div id="agent_success_msg" class="w-100 alert alert-success alert-dismissible">
<?php foreach ($success as $sucess) {echo $sucess . "<br \>";}?>
			</div>
<?php }if (!empty($errors)) {?>
			<div id="agent_error_msg" class="w-100 alert alert-danger alert-dismissible">
				<?php foreach ($errors as $error) {echo $error . "<br \>";}?>
			</div>
			<?php }?>
			<div class="card-body">
				<div class="table-responsive">
					<table class="table table-bordered" id="pay_off_orders_listing" width="100%" cellspacing="0">
						<thead>
							<tr>
								<th>#</th>
								<th>Transctee Name</th>
								<th>File Number</th>
								<th>Account Number</th>
								<th>ABA/Routing #</th>
								<th>Bank Name</th>
								<th>Submitted</th>
								<th>Approved</th>
								<th>Notes</th>
								<th>Action</th>
							</tr>
						</thead>
						<tbody></tbody>
					</table>
				</div>
			</div>
		</div>
		<!-- <div class="row">
			<div class="row">
				<div class="col-xs-12">
					<div class="typography-section__inner">
						<h2 class="ui-title-block ui-title-block_light">Welcome Back <?php echo $name; ?>,</h2>
						<div class="ui-decor-1a bg-accent"></div>
						<h4 class="ui-title-block_light">Below is order list of pay off.</b></h3>
					</div>
					<?php if (!empty($success)) {?>
					<div id="agent_success_msg" class="w-100 alert alert-success alert-dismissible">
						<?php foreach ($success as $sucess) {
    echo $sucess . "<br \>";
}?>
					</div>
					<?php }
if (!empty($errors)) {?>
					<div id="agent_error_msg" class="w-100 alert alert-danger alert-dismissible">
						<?php foreach ($errors as $error) {
    echo $error . "<br \>";
}?>
					</div>
					<?php }?>
					<div class="typography-sectiona">
						<div class="col-md-12">
							<div class="table-container">
								<table class="table table-type-3 typography-last-elem" id="pay_off_orders_listing">
									<thead>
										<tr>
											<th>#</th>
											<th>Opened Date</th>
											<th>File Number</th>
											<th>Title Officer</th>
											<th>Status</th>
											<th>Action</th>
										</tr>
									</thead>
									<tbody></tbody>
								</table>
								<div class="typography-sectionab"></div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div> -->
	</div>
</section>
<div class="modal fade" id="notesModal" tabindex="-1" role="dialog" aria-labelledby="notesModal" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<form  method="post" id="notes-form">
			    <div class="row">
                    <div class="col-lg-12">
                        <div class="card shadow">
                            <div class="card-header py-3">
                                <h6 class="m-0 font-weight-bold text-primary">Review Notes</h6>
                            </div>
                            <div class="card-body">
                                <div class="smart-forms smart-container">
                                    <div class="modal-body search-result">

                                        <div class="form-group">
                                            <div class="row">
                                                <div class="col-sm-12">
                                                    <label for="email_id" class="col-form-label">Notes</label>
													<textarea class="form-control" name="notes" id="notes" readonly></textarea>
                                                    <!-- <input name="email_id" required="" type="email" class="form-control" id="email_id"> -->
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="row">
                                                <div class="col-sm-12">
                                                    <label for="admin_notes" class="col-form-label">Admin Notes</label>
													<textarea class="form-control" name="admin_notes" id="admin_notes" readonly></textarea>
                                                    <!-- <input name="email_id" required="" type="email" class="form-control" id="email_id"> -->
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
			</form>
		</div>
	</div>
</div>

<div class="modal fade vendor-modal" id="openUploadModel" tabindex="-1" role="dialog" aria-labelledby="openUploadModel" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<form  method="post" id="notes-form">
			    <div class="row">
                    <div class="col-lg-12">
                        <div class="card shadow">
                            <div class="card-header py-3">
								<div class="row">
									<div class="col-sm-6">
										<!-- <h1 class="h3 text-gray-800">CPL Documents</h1> -->
										<h6 class="m-0 font-weight-bold text-primary" >Document List</h6>
									</div>
								</div>

                            </div>
                            <div class="card-body">
                                <div class="smart-forms smart-container">
                                    <div class="modal-body search-result">
										<div class="form-group uploadDocWrapper mb-4">
											<form action="">
												<div class="row">
													<div class="col-sm-6">
														<input type="hidden" name="vendor_id" id="vendor_id">
														<input name="vendor_documents" type="file" id="vendor_documents" class="form-control" accept="application/pdf">
														<span class="error d-none" id="file_upload_err"></span>
														<span class="success d-none" id="file_upload_suc"></span>
													</div>
													<div class="col-sm-6">
														<a href="javascript:void(0);" id="upload_vendor_documents" class="btn btn-secondary btn-icon-split float-right mr-2">
															<span class="icon text-white-50"><i class="fas fa-file-import"></i></span><span class="text">Upload Document</span>
														</a>
													</div>
												</div>
											</form>
                                        </div>

										<table class="table" id="vendor_documents_list" width="100%" >
											<thead>
												<tr>
													<th scope="col">#</th>
													<th scope="col">Document Name</th>
													<th scope="col">Action</th>
												</tr>
											</thead>
											<tbody>
												<!-- <tr>
													<th scope="row">1</th>
													<td>Mark</td>
													<td>Otto</td>
												</tr>
												<tr>
													<th scope="row">2</th>
													<td>Jacob</td>
													<td>Thornton</td>
												</tr>
												<tr>
													<th scope="row">3</th>
													<td>Larry</td>
													<td>the Bird</td>
												</tr> -->
											</tbody>
										</table>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
			</form>
		</div>
	</div>
</div>

<script>

$(document).ready(function () {
    $('#upload_vendor_documents').click(function () {
		$('#file_upload_suc, #file_upload_err').addClass('d-none');
		var fileInput = $('#vendor_documents')[0];
		var vendor_id = $('#vendor_id').val();
		if (fileInput.files.length === 0) {
			alert('Please select a file to upload.');
            return;
        }

		if (!vendor_id) {
			alert('Invalid vendor, Please try again.');
            return;
		}

		$('#upload_vendor_documents').addClass('disabled');
        var formData = new FormData();
        formData.append('vendor_documents', fileInput.files[0]);
        formData.append('vendor_id', vendor_id);

        $.ajax({
            url: 'upload-vendor-documents', // URL to your CodeIgniter controller method
            type: 'POST',
            data: formData,
            contentType: false,
            processData: false,
            success: function (response) {
                let res = JSON.parse(response);
				if (res.success != null) {
					$('#file_upload_suc').text(res.success);
					$('#file_upload_suc').removeClass('d-none');
					vendor_list.ajax.reload();
				} else if (res.error != null) {
					$('#file_upload_err').text(res.error);
					$('#file_upload_err').removeClass('d-none');
				}
				// $('#vendor_id').val('');
				$('#vendor_documents').val('');
				$('#upload_vendor_documents').removeClass('disabled');
            },
            error: function (xhr, status, error) {
                alert('An error occurred while uploading the file');
                console.log(xhr, status, error);
				$('#file_upload_err').text(error);
				$('#file_upload_err').removeClass('d-none');
				$('#upload_vendor_documents').removeClass('disabled');
            }
        });
    });
});

function openNotes(id, notes, admin_notes) {
	$("#admin_notes").val(admin_notes)
	$("#notes").val(notes)
	$('#notesModal').modal('show');
}

function getDocuments(id) {
	$('#vendor_id').val(id);
	$('#openUploadModel').modal('show');
	if ($('#vendor_documents_list').length) {
        vendor_list = $('#vendor_documents_list').DataTable({
            "paging": false,
            // "lengthChange": false,
            "language": {
                // searchPlaceholder: "Search File# or Address",
                paginate: false,
                "emptyTable": "Record(s) not found.",
                // "search": "",
            },
			"bDestroy": true,
            "searching": false,
            // "bStateSave": true,

            // dom: 'Bfrtip',
            buttons: [],
            "drawCallback": function () {

            },
            // "ordering": false,
            // "serverSide": true,
            "ajax": {
                url: base_url + "get-vendor-document-list", // json datasource
                type: "post", // method  , by default get
				data: {id: id},
                beforeSend: function () {
                    $('#page-list-loader').css('background-color', 'rgba(0,0,0,.5)');
                    $('#page-list-loader').css('display', 'block');
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
                    $("#vendor_documents_list tbody").append(
                        '<tr><td colspan="4" class="text-center">No records found</td></tr>');
                    $("#vendor_documents_list_processing").css("display", "none");
                },
                complete: function () {
                    $("#page-list-loader").hide();
                    $('#page-list-loader').css('display', 'none');
                }
            }
        });
    }
}
</script>

