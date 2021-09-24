<style>
	.dataTables_length {
		width: 250px !important;
		float: left;
	}

	#fileUploadModal .form-control {
		height: auto;
	}

    .bootstrap-select:not([class*="col-"]):not([class*="form-control"]):not(.input-group-btn) {
        width: 100% !important;
    }
</style>
<div class="container-fluid">
	<div class="card mb-3">
		<div class="card-header">
			<i class="fas fa-table"></i>
			Forms
			<div class="float-right">
				<a href="javascript:void(0);" class="btn btn-secondary" data-toggle="modal"
					data-target="#fileUploadModal"> Upload </a>
			</div>
		</div>

		<div class="card-body">
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
			<div id="forms_success_msg" class="w-100 alert alert-success alert-dismissible"
				style="display:none;"></div>
			<div id="forms_error_msg" class="w-100 alert alert-danger alert-dismissible"
				style="display:none;"></div>
			<div class="table-responsive">
				<table class="table table-bordered" id="tbl-file-documents-listing" width="100%" cellspacing="0">
					<thead>
						<tr>
							<th>Sr No</th>
							<th>Name</th>
							<th>Description</th>
							<th>Created At</th>
							<th>Action</th>
						</tr>
					</thead>
					<tbody></tbody>
				</table>
			</div>
		</div>
	</div>
</div>

<!-- Modal -->
<div class="modal fade" id="fileUploadModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
	aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<form enctype="multipart/form-data" method="post">
				<div class="modal-header">
					<h5 class="modal-title" id="exampleModalLabel">Upload File</h5>
				</div>
				<div class="modal-body">
					<div class="form-group">
						<label for="file-upload" class="col-form-label">Select File:</label>
						<input required="" name="file" type="file" id="file-upload" class="form-control">
					</div>
					<div class="form-group">
						<label for="file-name" class="col-form-label">Enter Name:</label>
						<input name="name" required="" type="text" class="form-control" id="file-name">
					</div>
					<div class="form-group">
						<label for="title-officer" class="col-form-label">Select Title Officer</label>
						<div class="">
							<select required="" name="titleOfficers[]" class="selectpicker" multiple data-live-search="true">
                                <option value="all">All</option>
								<?php foreach($titleOfficers as $titleOfficer) {?>
                                    <option value="<?php echo $titleOfficer['id'];?>"> <?php echo $titleOfficer['first_name']." ".$titleOfficer['last_name'];?></option>
                                <?php }?>
							</select>
						</div>
					</div>
					<div class="form-group">
						<label for="file-description" class="col-form-label">Enter Description:</label>
						<textarea name="description" class="form-control" id="file-description"></textarea>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
					<button class="btn btn-primary">Upload</button>
				</div>
                <input type="hidden" name="formId" id="formId" value="">
			</form>
		</div>
	</div>
</div>

<script>
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
				url: url
			},
			async: false,
			success: function (response) {
				if (response) {
					if (navigator.msSaveBlob) {
						var csvData = base64toBlob(response, 'application/octet-stream');
						var csvURL = navigator.msSaveBlob(csvData, filename);
						var element = document.createElement('a');
						element.setAttribute('href', csvURL);
						element.setAttribute('download', documentType + "_" + filename);
						element.style.display = 'none';
						document.body.appendChild(element);
						document.body.removeChild(element);
					} else {
						console.log(response);
						var csvURL = 'data:application/octet-stream;base64,' + response;
						var element = document.createElement('a');
						element.setAttribute('href', csvURL);
						element.setAttribute('download', documentType + "_" + filename);
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

    function editFormInfo(formId) 
    {
		$('#formId').val(formId);
        $('#page-preloader').css('background-color', 'rgba(0,0,0,.5)');
        $('#page-preloader').css('display', 'block');
        $.ajax({
            url: base_url + "get-form-details",
            type: "post",
            data: {
                formId: formId
            },
            success: function (response) {
                var res = jQuery.parseJSON(response);
				$("#file-upload").prop('required', false);
                if(res.status == 'success') {
                    $("#file-name").val(res.formDetails['name']);
                    $("#file-description").val(res.formDetails['description']);
					var selected = [];
					for (var i = 0; i < res.titleOfficers.length; i++) {
						selected.push(res.titleOfficers[i]['user_id']);
					}
					console.log(selected);
					$('select[name=titleOfficers]').val(selected);
					$('.selectpicker').selectpicker('refresh');
					
					
                }  
                $('#page-preloader').css('display', 'none');
                $('#fileUploadModal').modal('show');
            }
        });
        return false;
	}
</script>
