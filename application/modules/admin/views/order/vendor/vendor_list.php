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
		height: 700px;
		overflow-y: auto;
	}

    .vendor-modal .modal-dialog {
        max-width: 700px;
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
                <a href="<?php echo base_url() ?>order/admin/add-vendor"  class="btn btn-success btn-icon-split float-right mr-2">
                    <span class="icon text-white-50">
                        <i class="fas fa-plus"></i>
                    </span>
                    <span class="text"> Add Transctee</span>
                </a>
            </div>
        </div>
		<div class="card shadow mb-4">
            <div id="vendor_success_msg" class="w-100 alert alert-success alert-dismissible" style="display:none;"></div>
            <div id="vendor_error_msg" class="w-100 alert alert-danger alert-dismissible" style="display:none;"></div>

			<div class="card-header datatable-header py-3">
				<div class="datatable-header-titles" >
					<span>
						<i class="fas fa-users"></i>
					</span>
					<h6 class="m-0 font-weight-bold text-primary pl-10">Below is order list of vendors</h6>
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
					<table class="table table-bordered" id="tbl-vendors-listing" width="100%" cellspacing="0">
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
														<a href="javascript:void(0);" id="upload_vendor_documents" class="btn btn-success btn-icon-split float-right mr-2">
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

<div class="modal fade" id="addVendorModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
	aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<form  method="post" id="add-edit-vendor-form">
			<div class="row">
                    <div class="col-lg-12">
                        <div class="card shadow">
                            <div class="card-header py-3">
                                <h6 class="m-0 font-weight-bold text-primary" > View / Edit Vendor </h6>
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
				<input type="hidden" name="vendor_id" id="vendor_id" value="">
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
                url: base_url + "order/admin/get-vendor-document-list", // json datasource
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

function activateVendor() {
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
            url: base_url + "order/admin/update-vendor-status",
            method: "POST",
            data: {
                id: id,
                status: status
            },
            success: function (data) {
                var result = jQuery.parseJSON(data);
                if (result.status == 'success') {
                    $('body').animate({ opacity: 1.0 }, "slow");
                    $('#vendor_success_msg').html(result.msg).show();
                    $([document.documentElement, document.body]).animate({
                        scrollTop: $("#vendor_success_msg").offset().top
                    }, 1000);
                    vendor_list.ajax.reload(null, false);
                    setTimeout(function () {
                        $('#vendor_success_msg').html('').hide();
                    }, 4000);
                } else {
                    $('#vendor_error_msg').html(result.message).show();
                    $([document.documentElement, document.body]).animate({
                        scrollTop: $("#vendor_error_msg").offset().top
                    }, 1000);

                    setTimeout(function () {
                        $('#vendor_error_msg').html('').hide();
                    }, 4000);
                }
            },
            error: function (XMLHttpRequest, textStatus, errorThrown) {
                $('#vendor_error_msg').html('Something went wrong. Please try it again.').show();
                $([document.documentElement, document.body]).animate({
                    scrollTop: $("#vendor_success_msg").offset().top
                }, 1000);

                setTimeout(function () {
                    $('#vendor_error_msg').html('').hide();
                }, 4000);
            }
        });
    });
}

function editVendor(id, editFlag)
    {
        $('#vendor_id').val(id);
        // $('#page-preloader').css('background-color', 'rgba(0,0,0,.5)');
        // $('#page-preloader').css('display', 'block');

        $.ajax({
            url: base_url + "order/admin/get-vendor-details",
            type: "post",
            data: {
                vendor_id: id
            },
            success: function (response) {
                // console.log('editVendor', response);
                // return;
                var res = $.parseJSON(response);
                console.log('editVendor', res);
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
                $('#addVendorModal').modal('show');
            }
        });
        return false;
	}

    function deleteVendor(id) {
        if (id == '') {
            alert('Vendor ID is required.');
            return false;
        }

        var ready = confirm("Are you sure want to delete?");

        if (ready) {
            $.ajax({
                url: base_url + "order/admin/delete-vendor-details",
                method: "POST",
                data: {
                    id: id
                },
                success: function (data) {
                    var result = jQuery.parseJSON(data);
                    if (result.status == 'success') {
                        $('#vendor_success_msg').html(result.message).show();
                        $([document.documentElement, document.body]).animate({
                            scrollTop: $("#vendor_success_msg").offset().top
                        }, 1000);
                        vendor_list.ajax.reload(null, false);
                        setTimeout(function () {
                            $('#vendor_success_msg').html('').hide();
                        }, 4000);
                    } else {
                        $('#vendor_error_msg').html(result.message).show();
                        $([document.documentElement, document.body]).animate({
                            scrollTop: $("#vendor_error_msg").offset().top
                        }, 1000);

                        setTimeout(function () {
                            $('#vendor_error_msg').html('').hide();
                        }, 4000);
                    }
                },
                error: function (XMLHttpRequest, textStatus, errorThrown) {
                    $('#vendor_error_msg').html('Something went wrong. Please try it again.').show();
                    $([document.documentElement, document.body]).animate({
                        scrollTop: $("#vendor_success_msg").offset().top
                    }, 1000);

                    setTimeout(function () {
                        $('#vendor_error_msg').html('').hide();
                    }, 4000);
                }
            })
        } else {
            return false;
        }
    }
</script>

