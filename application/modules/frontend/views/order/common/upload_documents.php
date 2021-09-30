<style type="text/css">
    th {
        text-align: center;
    }
	.table-container {
		overflow-y: initial !important;
	}
</style>
<body>
	<?php
        $this->load->view('layout/header_dashboard');
    ?>
	<section class="section-type-4a section-defaulta" style="padding-bottom:0px;">
		<div class="container">
			<div class="row">
				<div class="row">
					<div class="col-xs-12">
						<div class="typography-section__inner" style="margin-bottom: 20px;">
							<h2 class="ui-title-block ui-title-block_light">Upload a Document</h2>
							<div class="ui-decor-1a bg-primary"></div>
							<h3 class="ui-title-block_light">File Number <?php echo $orderDetails['file_number'];?></h3>
							<h3 class="ui-title-block_light"><?php echo $orderDetails['full_address'];?></h3>
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

									<div class="typography-sectione typography-section-border">
										<div class="container">
											<div class="row">
												<form id="files_upload" action="<?php echo base_url();?>files-upload" method="POST" enctype="multipart/form-data">
													<div class="col-md-12">
														<a href="">
															<button id="up_btn" style="color: #c7c7c7;width: 220px;" class="btn btn-grad-2a" type="submit">Upload Documents</button>
														</a>
													</div>
													<input type="hidden" id="file_id" name="file_id" value="<?php echo $orderDetails['file_id'];?>">
													<input type="hidden" id="order_id" name="order_id" value="<?php echo $orderDetails['order_id'];?>">
													<div class="col-md-6">
														<blockquote class="b-blockquote b-blockquote-3">
															<footer class="b-blockquote-3__footer">
																<cite class="b-blockquote-3__cite"
																	title="Blockquote Title"><span
																		class="b-blockquote-3__author">Document
																		#1</span></cite>
															</footer>
															<div class="b-blockquote-3__content">
																<div class="header-language-nav dropdown">
																	<select name="document_type_1" id="document_type_1" class="dropdown-toggle" required="required">
																		<option value="">DOCUMENT TYPE:</option>
																		<?php foreach($documentTypes as $documentType) { ?>
																		<option
																			value="<?php echo $documentType['api_id'];?>">
																			<?php echo $documentType['name'];?></option>
																		<?php } ?>
																	</select>
																	<span style="color:red;">*</span>
																</div>
																<div class="input-group" style="width: 100%;margin-left: 14%;">
																	<div class="custom-file"  style="float:left;">
																		<input type="file" accept=".doc,.docx,.gif,.msg,.pdf,.tif,.tiff,.xls,.xlsx,.xml" class="custom-file-input"
																			id="document_1" name="document_1" required="required">
																	</div>
																	<span style="color:red;float:left;">*</span>
																</div>
																<div class="header-language-nav dropdown">
																	<div class="" style="margin-top: 10px;float:left;">
																		<textarea name="description_1" id="description_1" placeholder="DESCRIPTION" rows="3" cols="52" type="file"
																			class="custom-file-input dropdown-toggle" id="inputGroupFile01"
																			style="border: 1px solid rgba(238,238,238);" required="required"></textarea>
																	</div>
																	<span style="color:red;float:left;">*</span>
																</div>

															</div>

														</blockquote>
														<!-- end .b-blockquote-->
													</div>
													<div class="col-md-6">
														<blockquote class="b-blockquote b-blockquote-3">
															<footer class="b-blockquote-3__footer">
																<cite class="b-blockquote-3__cite"
																	title="Blockquote Title"><span
																		class="b-blockquote-3__author">Document
																		#2</span></cite>
															</footer>
															<div class="b-blockquote-3__content">
																<div class="header-language-nav dropdown">
																	<select name="document_type_2" id="document_type_2" class="dropdown-toggle">
																		<option value="">DOCUMENT TYPE:</option>
																		<?php foreach($documentTypes as $documentType) { ?>
																		<option
																			value="<?php echo $documentType['api_id'];?>">
																			<?php echo $documentType['name'];?></option>
																		<?php } ?>
																	</select>
																	
																</div>
																<div class="input-group" style="width: 100%;margin-left: 15%;">
																	<div class="custom-file"  style="float:left;">
																		<input type="file" accept=".doc,.docx,.gif,.msg,.pdf,.tif,.tiff,.xls,.xlsx,.xml" class="custom-file-input"
																			id="document_2" name="document_2">
																	</div>
																	
																</div>
																<div class="header-language-nav dropdown">
																	<div class="" style="margin-top: 10px;float:left;">
																		<textarea name="description_2" id="description_2" placeholder="DESCRIPTION" rows="3" cols="52" type="file"
																			class="custom-file-input dropdown-toggle" id="inputGroupFile01"
																			style="border: 1px solid rgba(238,238,238);"></textarea>
																	</div>
																	
																</div>

															</div>

														</blockquote>
														<!-- end .b-blockquote-->
													</div>
													<div class="col-md-12">
													<div class="col-md-6">
														<blockquote class="b-blockquote b-blockquote-3">
															<footer class="b-blockquote-3__footer">
																<cite class="b-blockquote-3__cite"
																	title="Blockquote Title"><span
																		class="b-blockquote-3__author">Document
																		#3</span></cite>
															</footer>
															<div class="b-blockquote-3__content">
																<div class="header-language-nav dropdown">
																	<select name="document_type_3" id="document_type_3" class="dropdown-toggle">
																		<option value="">DOCUMENT TYPE:</option>
																		<?php foreach($documentTypes as $documentType) { ?>
																		<option
																			value="<?php echo $documentType['api_id'];?>">
																			<?php echo $documentType['name'];?></option>
																		<?php } ?>
																	</select>
																	
																</div>
																<div class="input-group" style="width: 100%;margin-left: 14%;">
																	<div class="custom-file"  style="float:left;">
																		<input type="file" accept=".doc,.docx,.gif,.msg,.pdf,.tif,.tiff,.xls,.xlsx,.xml" class="custom-file-input"
																			id="document_3" name="document_3">
																	</div>
																	
																</div>
																<div class="header-language-nav dropdown">
																	<div class="" style="margin-top: 10px;float:left;">
																		<textarea name="description_3" id="description_3" placeholder="DESCRIPTION" rows="3" cols="52" type="file"
																			class="custom-file-input dropdown-toggle" id="inputGroupFile01"
																			style="border: 1px solid rgba(238,238,238);"></textarea>
																	</div>
																	
																</div>

															</div>

														</blockquote>
														<!-- end .b-blockquote-->
													</div>
													<div class="col-md-6">
														<blockquote class="b-blockquote b-blockquote-3">
															<footer class="b-blockquote-3__footer">
																<cite class="b-blockquote-3__cite"
																	title="Blockquote Title"><span
																		class="b-blockquote-3__author">Document
																		#4</span></cite>
															</footer>
															<div class="b-blockquote-3__content">
																<div class="header-language-nav dropdown">
																	<select name="document_type_4" id="document_type_4" class="dropdown-toggle">
																		<option value="">DOCUMENT TYPE:</option>
																		<?php foreach($documentTypes as $documentType) { ?>
																		<option
																			value="<?php echo $documentType['api_id'];?>">
																			<?php echo $documentType['name'];?></option>
																		<?php } ?>
																	</select>
																	
																</div>
																<div class="input-group" style="width: 100%;margin-left: 14%;">
																	<div class="custom-file"  style="float:left;">
																		<input type="file" accept=".doc,.docx,.gif,.msg,.pdf,.tif,.tiff,.xls,.xlsx,.xml" class="custom-file-input"
																			id="document_4" name="document_4">
																	</div>
																	
																</div>
																<div class="header-language-nav dropdown">
																	<div class="" style="margin-top: 10px;float:left;">
																		<textarea name="description_4" id="description_4" placeholder="DESCRIPTION" rows="3" cols="52" type="file"
																			class="custom-file-input dropdown-toggle" id="inputGroupFile01"
																			style="border: 1px solid rgba(238,238,238);"></textarea>
																	</div>
																	
																</div>

															</div>

														</blockquote>
														<!-- end .b-blockquote-->
													</div>
												</div>
													<div class="col-md-6">
														<blockquote class="b-blockquote b-blockquote-3">
															<footer class="b-blockquote-3__footer">
																<cite class="b-blockquote-3__cite"
																	title="Blockquote Title"><span
																		class="b-blockquote-3__author">Document
																		#5</span></cite>
															</footer>
															<div class="b-blockquote-3__content">
																<div class="header-language-nav dropdown">
																	<select name="document_type_5" id="document_type_5" class="dropdown-toggle">
																		<option value="">DOCUMENT TYPE:</option>
																		<?php foreach($documentTypes as $documentType) { ?>
																		<option
																			value="<?php echo $documentType['api_id'];?>">
																			<?php echo $documentType['name'];?></option>
																		<?php } ?>
																	</select>
																	
																</div>
																<div class="input-group" style="width: 100%;margin-left: 15%;">
																	<div class="custom-file"  style="float:left;">
																		<input type="file" accept=".doc,.docx,.gif,.msg,.pdf,.tif,.tiff,.xls,.xlsx,.xml" class="custom-file-input"
																			id="document_5" name="document_5">
																	</div>
																	
																</div>
																<div class="header-language-nav dropdown">
																	<div class="" style="margin-top: 10px;float:left;">
																		<textarea name="description_5" id="description_5" placeholder="DESCRIPTION" rows="3" cols="52" type="file"
																			class="custom-file-input dropdown-toggle" id="inputGroupFile01"
																			style="border: 1px solid rgba(238,238,238);"></textarea>
																	</div>
																	
																</div>

															</div>

														</blockquote>
														<!-- end .b-blockquote-->
													</div>
													<div class="col-md-6">
														<blockquote class="b-blockquote b-blockquote-3">
															<footer class="b-blockquote-3__footer">
																<cite class="b-blockquote-3__cite"
																	title="Blockquote Title"><span
																		class="b-blockquote-3__author">Document
																		#6</span></cite>
															</footer>
															<div class="b-blockquote-3__content">
																<div class="header-language-nav dropdown">
																	<select name="document_type_6" id="document_type_6" class="dropdown-toggle">
																		<option value="">DOCUMENT TYPE:</option>
																		<?php foreach($documentTypes as $documentType) { ?>
																		<option
																			value="<?php echo $documentType['api_id'];?>">
																			<?php echo $documentType['name'];?></option>
																		<?php } ?>
																	</select>
																	
																</div>
																<div class="input-group" style="width: 100%;margin-left: 15%;">
																	<div class="custom-file"  style="float:left;">
																		<input type="file" accept=".doc,.docx,.gif,.msg,.pdf,.tif,.tiff,.xls,.xlsx,.xml" class="custom-file-input"
																			id="document_6" name="document_6">
																	</div>
																	
																</div>
																<div class="header-language-nav dropdown">
																	<div class="" style="margin-top: 10px;float:left;">
																		<textarea name="description_6" id="description_6" placeholder="DESCRIPTION" rows="3" cols="52" type="file"
																			class="custom-file-input dropdown-toggle" id="inputGroupFile01"
																			style="border: 1px solid rgba(238,238,238);"></textarea>
																	</div>
																	
																</div>

															</div>

														</blockquote>
														<!-- end .b-blockquote-->
													</div>
													<div class="col-md-12">
														<a href="">
															<button id="down_btn" style="color: #c7c7c7;width: 220px;" class="btn btn-grad-2a" type="submit">Upload Documents</button>
														</a>
													</div>
												</form>
											</div>
											
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
	<section class="section-type-4a section-defaulta" style="padding-bottom:0px;">
		<div class="container">
			<div class="row">
				<div class="row">
					<div class="col-xs-12">
						<div class="typography-section__inner">
							<h2 class="ui-title-block ui-title-block_light">Documents</h2>
							<div class="ui-decor-1a bg-accent"></div>
							<h3 class="ui-title-block_light">Below is list of all your documents.</h3>
						</div>
						<div class="typography-sectiona">
							<div class="col-md-12">
								<div class="table-container">
									<table class="table table_primary" id="document_listing">
										<thead>
											<tr>
												<th>#</th>
												<th>Document Name</th>
												<th>Created</th>
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

<script>
	var documents_list = '';
    $(document).ready(function(){
		$("#files_upload").submit(function( event ) {
			$('#page-preloader').css('background-color', 'rgba(0,0,0,.5)');
			$('#page-preloader').css('display', 'block');
		});

		$("#document_1").change(function(){
			$('#up_btn').css({"background": "#d35411", "color": "white"});
			$('#down_btn').css({"background": "#d35411", "color": "white"});
		});

        $("#document_2").change(function(){
			$("#document_type_2").prop('required',true);
			$("#description_2").prop('required',true);
			$('#up_btn').css({"background": "#d35411", "color": "white"});
			$('#down_btn').css({"background": "#d35411", "color": "white"});
		});
		
		$("#document_3").change(function(){
			$("#document_type_3").prop('required',true);
			$("#description_3").prop('required',true);
			$('#up_btn').css({"background": "#d35411", "color": "white"});
			$('#down_btn').css({"background": "#d35411", "color": "white"});
		});
		
		$("#document_4").change(function(){
			$("#document_type_4").prop('required',true);
			$("#description_4").prop('required',true);
			$('#up_btn').css({"background": "#d35411", "color": "white"});
			$('#down_btn').css({"background": "#d35411", "color": "white"});
		});
		
		$("#document_5").change(function(){
			$("#document_type_5").prop('required',true);
			$("#description_5").prop('required',true);
			$('#up_btn').css({"background": "#d35411", "color": "white"});
			$('#down_btn').css({"background": "#d35411", "color": "white"});
		});
		
		$("#document_6").change(function(){
			$("#document_type_6").prop('required',true);
			$("#description_6").prop('required',true);
			$('#up_btn').css({"background": "#d35411", "color": "white"});
			$('#down_btn').css({"background": "#d35411", "color": "white"});
        });	
		
		if ($('#document_listing').length) {
			documents_list = $('#document_listing').DataTable({
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
				initComplete: function () {
					
					
                },
				dom: 'Bfrtip',
				buttons: [],
				"drawCallback": function () {
					
				},
				"ordering": false,
				"serverSide": true,
				"ajax": {
					url: base_url + "get-order-documents", 
					type: "post", 
					data: {
						order_id: $('#order_id').val()
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
						$("#document_listing tbody").append(
							'<tr><td colspan="4" class="text-center">No records found</td></tr>');
						$("#document_listing_processing").css("display", "none");
					}
				}
			});
		}
    });

	function downloadDocumentFromAws(url, documentType)
	{
		$('#page-preloader').css('background-color', 'rgba(0,0,0,.5)');
		$('#page-preloader').css('display', 'block');
		var fileNameIndex = url.lastIndexOf("/") + 1;
		var filename = url.substr(fileNameIndex);
		$.ajax({
			url: base_url + "download-aws-document",
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
</html>
