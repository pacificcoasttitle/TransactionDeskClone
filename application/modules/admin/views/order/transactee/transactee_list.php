<?php
$payoff_user = isset($payoff_user) && !empty($payoff_user) ? $payoff_user : array();
$payoff_user = json_encode($payoff_user);

?>
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
		height: auto;
		overflow-y: auto;
	}

    .transactee-modal .modal-dialog {
        max-width: 700px;
    }

    .success {
        color: #28a745 !important;
        font-size: 1rem !important;
        width: 100% !important;
        padding-top: 10px !important;
    }

</style>
<script>
    var payoff_user_list = '<?php echo $payoff_user; ?>';

    console.log('payoff_user_list ==', jQuery.parseJSON(payoff_user_list));
</script>
<section class="section-type-4a section-defaulta" style="padding-bottom:0px;">
	<div class="container-fluid pc__top-element">
        <div class="row mb-3">
            <div class="col-sm-6">
                <h1 class="h3 text-gray-800"> <?=$pageTitle?> </h1>
            </div>
            <div class="col-sm-6">
                <a href="<?php echo base_url() ?>order/admin/add-transactee"  class="btn btn-success btn-icon-split float-right mr-2">
                    <span class="icon text-white-50">
                        <i class="fas fa-plus"></i>
                    </span>
                    <span class="text"> Add Transctee </span>
                </a>
            </div>
        </div>
		<div class="card shadow mb-4">
            <div id="transactee_success_msg" class="w-100 alert alert-success alert-dismissible" style="display:none;"></div>
            <div id="transactee_error_msg" class="w-100 alert alert-danger alert-dismissible" style="display:none;"></div>

			<div class="card-header datatable-header py-3">
				<div class="datatable-header-titles" >
					<span>
						<i class="fas fa-users"></i>
					</span>
					<h6 class="m-0 font-weight-bold text-primary pl-10">Below is order list of transactees</h6>
				</div>
			</div>
			<?php if (!empty($success)) {?>
			<div id="success_msg" class="w-100 alert alert-success alert-dismissible">
<?php foreach ($success as $sucess) {echo $sucess . "<br \>";}?>
			</div>
<?php }if (!empty($errors)) {?>
			<div id="error_msg" class="w-100 alert alert-danger alert-dismissible">
				<?php foreach ($errors as $error) {echo $error . "<br \>";}?>
			</div>
			<?php }?>
			<div class="card-body">
				<div class="table-responsive">
					<table class="table table-bordered" id="tbl-transactees-listing" width="100%" cellspacing="0">
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
								<th>Aprroved Status</th>
								<th>Action</th>
							</tr>
						</thead>
						<tbody></tbody>
					</table>
				</div>
			</div>
		</div>
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

<div class="modal fade transactee-modal" id="openUploadModel" tabindex="-1" role="dialog" aria-labelledby="openUploadModel" aria-hidden="true">
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
														<input type="hidden" name="transactee_id" id="transactee_id">
														<input name="transactee_documents" type="file" id="transactee_documents" class="form-control" accept="application/pdf">
														<span class="error d-none" id="file_upload_err"></span>
														<span class="success d-none" id="file_upload_suc"></span>
													</div>
													<div class="col-sm-6">
														<a href="javascript:void(0);" id="upload_transactee_documents" class="btn btn-success btn-icon-split float-right mr-2">
															<span class="icon text-white-50"><i class="fas fa-file-import"></i></span><span class="text">Upload Document</span>
														</a>
													</div>
												</div>
											</form>
                                        </div>

										<table class="table" id="transactee_documents_list" width="100%" >
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

<div class="modal fade" id="addTransacteeModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
	aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<form  method="post" id="add-edit-transactee-form">
			<div class="row">
                    <div class="col-lg-12">
                        <div class="card shadow">
                            <div class="card-header py-3">
                                <h6 class="m-0 font-weight-bold text-primary" > View / Edit Transactee </h6>
                            </div>
                            <div class="card-body">
                                <div class="smart-forms smart-container">
                                    <div class="modal-body search-result">

                                        <div class="form-group">
                                            <div class="row">
                                                <div class="col-sm-12">
                                                    <label for="transctee_name" class="col-form-label">Transctee name</label>
                                                    <input name="transctee_name" required="" type="email" class="form-control" id="transctee_name">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <div class="row">
                                                <div class="col-sm-12">
                                                    <label for="file_number" class="col-form-label">File Number</label>
                                                    <input name="file_number" required="" type="text" class="form-control" id="file_number">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <div class="row">
                                                <div class="col-sm-12">
                                                    <label for="account_number" class="col-form-label">Account Number</label>
                                                    <input name="account_number" required="" type="text" class="form-control" id="account_number">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <div class="row">
                                                <div class="col-sm-12">
                                                    <label for="aba" class="col-form-label">ABA / Routing #</label>
                                                    <input name="aba" required="" type="text" class="form-control" id="aba">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <div class="row">
                                                <div class="col-sm-12">
                                                    <label for="bank_name" class="col-form-label">Bank Name</label>
                                                    <input name="bank_name" required="" type="text" class="form-control" id="bank_name">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <div class="row">
                                                <div class="col-sm-12">
                                                    <label for="note" class="col-form-label">Note</label>
                                                    <textarea name="note" required="" type="text" class="form-control" id="note"></textarea>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <div class="row">
                                                <div class="col-sm-12">
                                                    <label for="admin_note" class="col-form-label">Admin Note</label>
                                                    <textarea name="admin_note" required="" type="text" class="form-control" id="admin_note"></textarea>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                    <div class="form-footer" style="padding: 0px 1rem !important;">
                                        <button type="submit" data-btntext-sending="Sending..." class="btn btn-success btn-icon-split btn-sm">
                                            <span class="icon text-white-50">
                                                <i class="fas fa-check"></i>
                                            </span>
                                            <span class="text">Submit</span>
                                        </button>
                                        <button type="reset" data-dismiss="modal" aria-label="Close" class="btn btn-danger btn-icon-split btn-sm">
                                            <span class="icon text-white-50">
                                                <i class="fas fa-ban"></i>
                                            </span>
                                            <span class="text">Cancel</span>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
				<input type="hidden" name="transactee_id" id="transactee_id" value="">
			</form>
		</div>
	</div>
</div>

<script>

$(document).ready(function () {
    $('#upload_transactee_documents').click(function () {
		$('#file_upload_suc, #file_upload_err').addClass('d-none');
		var fileInput = $('#transactee_documents')[0];
		var transactee_id = $('#transactee_id').val();
		if (fileInput.files.length === 0) {
			alert('Please select a file to upload.');
            return;
        }

		if (!transactee_id) {
			alert('Invalid transactee, Please try again.');
            return;
		}

		$('#upload_transactee_documents').addClass('disabled');
        var formData = new FormData();
        formData.append('transactee_documents', fileInput.files[0]);
        formData.append('transactee_id', transactee_id);

        $.ajax({
            url: 'upload-transactee-documents', // URL to your CodeIgniter controller method
            type: 'POST',
            data: formData,
            contentType: false,
            processData: false,
            success: function (response) {
                let res = JSON.parse(response);
				if (res.success != null) {
					$('#file_upload_suc').text(res.success);
					$('#file_upload_suc').removeClass('d-none');
					transactee_list.ajax.reload();
				} else if (res.error != null) {
					$('#file_upload_err').text(res.error);
					$('#file_upload_err').removeClass('d-none');
				}
				// $('#transactee_id').val('');
				$('#transactee_documents').val('');
				$('#upload_transactee_documents').removeClass('disabled');
            },
            error: function (xhr, status, error) {
                alert('An error occurred while uploading the file');
                console.log(xhr, status, error);
				$('#file_upload_err').text(error);
				$('#file_upload_err').removeClass('d-none');
				$('#upload_transactee_documents').removeClass('disabled');
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
	$('#transactee_id').val(id);
	$('#openUploadModel').modal('show');
	if ($('#transactee_documents_list').length) {
        transactee_list = $('#transactee_documents_list').DataTable({
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
                url: base_url + "order/admin/get-transactee-document-list", // json datasource
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
                    $("#transactee_documents_list tbody").append(
                        '<tr><td colspan="4" class="text-center">No records found</td></tr>');
                    $("#transactee_documents_list_processing").css("display", "none");
                },
                complete: function () {
                    $("#page-list-loader").hide();
                    $('#page-list-loader').css('display', 'none');
                }
            }
        });
    }
}

function activateTransactee() {
    $('input[type="checkbox"]').on('change', function () {
    console.log('change event');
        $('body').animate({ opacity: 0.5 }, "slow");
        var id = $(this).attr('id');
        if ($(this).is(":checked")) {
            var status = 1;
        } else {
            var status = 0;
        }
        $.ajax({
            url: base_url + "order/admin/update-transactee-status",
            method: "POST",
            data: {
                id: id,
                status: status
            },
            success: function (data) {
                var result = jQuery.parseJSON(data);
                if (result.status == 'success') {
                    $('body').animate({ opacity: 1.0 }, "slow");
                    $('#transactee_success_msg').html(result.msg).show();
                    $([document.documentElement, document.body]).animate({
                        scrollTop: $("#transactee_success_msg").offset().top
                    }, 1000);
                    transactee_list.ajax.reload(null, false);
                    setTimeout(function () {
                        $('#transactee_success_msg').html('').hide();
                    }, 4000);
                } else {
                    $('#transactee_error_msg').html(result.message).show();
                    $([document.documentElement, document.body]).animate({
                        scrollTop: $("#transactee_error_msg").offset().top
                    }, 1000);

                    setTimeout(function () {
                        $('#transactee_error_msg').html('').hide();
                    }, 4000);
                }
            },
            error: function (XMLHttpRequest, textStatus, errorThrown) {
                $('#transactee_error_msg').html('Something went wrong. Please try it again.').show();
                $([document.documentElement, document.body]).animate({
                    scrollTop: $("#transactee_success_msg").offset().top
                }, 1000);

                setTimeout(function () {
                    $('#transactee_error_msg').html('').hide();
                }, 4000);
            }
        });
    });
}

function editTransactee(id, editFlag)
{
    $('#transactee_id').val(id);
    // $('#page-preloader').css('background-color', 'rgba(0,0,0,.5)');
    // $('#page-preloader').css('display', 'block');

    $.ajax({
        url: base_url + "order/admin/get-transactee-details",
        type: "post",
        data: {
            transactee_id: id
        },
        success: function (response) {
            // console.log('editTransactee', response);
            // return;
            var res = $.parseJSON(response);
            console.log('editTransactee', res);
            if(res.status) {
                res_data = res.data;
                $('#transctee_name').val(res_data.transctee_name);
                $('#file_number').val(res_data.file_number);
                $('#account_number').val(res_data.account_number);
                $('#aba').val(res_data.aba);
                $('#bank_name').val(res_data.bank_name);
                $('#note').val(res_data.notes);
                $('#admin_note').val(res_data.admin_notes);
                $('input, textarea').attr('disabled', true);
                $('.form-footer').addClass('d-none');
                if(editFlag) {
                    $('input, textarea').attr('disabled', false);
                    $('.form-footer').removeClass('d-none');
                }
            }
            $('#page-preloader').css('display', 'none');
            $('#addTransacteeModal').modal('show');
        }
    });
    return false;
}

function deleteTransactee(id)
{
    if (id == '') {
        alert('Transactee ID is required.');
        return false;
    }

    var ready = confirm("Are you sure want to delete?");

    if (ready) {
        $.ajax({
            url: base_url + "order/admin/delete-transactee-details",
            method: "POST",
            data: {
                id: id
            },
            success: function (data) {
                var result = jQuery.parseJSON(data);
                if (result.status == 'success') {
                    $('#transactee_success_msg').html(result.message).show();
                    $([document.documentElement, document.body]).animate({
                        scrollTop: $("#transactee_success_msg").offset().top
                    }, 1000);
                    transactee_list.ajax.reload(null, false);
                    setTimeout(function () {
                        $('#transactee_success_msg').html('').hide();
                    }, 4000);
                } else {
                    $('#transactee_error_msg').html(result.message).show();
                    $([document.documentElement, document.body]).animate({
                        scrollTop: $("#transactee_error_msg").offset().top
                    }, 1000);

                    setTimeout(function () {
                        $('#transactee_error_msg').html('').hide();
                    }, 4000);
                }
            },
            error: function (XMLHttpRequest, textStatus, errorThrown) {
                $('#transactee_error_msg').html('Something went wrong. Please try it again.').show();
                $([document.documentElement, document.body]).animate({
                    scrollTop: $("#transactee_success_msg").offset().top
                }, 1000);

                setTimeout(function () {
                    $('#transactee_error_msg').html('').hide();
                }, 4000);
            }
        })
    } else {
        return false;
    }
}

function downloadDocumentFromAws(url, documentType)
{
    $('#page-preloader').css('background-color', 'rgba(0,0,0,.5)');
    $('#page-preloader').css('display', 'block');
    var fileNameIndex = url.lastIndexOf("/") + 1;
    var filename = url.substr(fileNameIndex);
    $.ajax({
        url: base_url + "download-aws-document-admin",
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
</script>

