<style>

.dropdown-btn {
	border: none;
    background: none;
    width: 100%;
    text-align: left;
    color: #04415D;
    background: #ffffff;
    width: 100%;
    border-bottom: 2px #D0D0D0 dotted;
    padding: 10px 15px 10px 0;
}

.dropdown-container {
	display: none;
}

.active {
  border :none;
}

.fa-caret-down {
  float: right;
  padding-right: 8px;
}

.review_li {
	float: left;
	width: 100%;
}

.linked_doc {
	float: left;
    padding: 5px 0px 10px 0;
	border: none !important;
	font-weight:bold;
}

.yamm2 li a {
	width:100%;
}

.yamm2 li a:hover {
	width:100%;
}

button:focus {outline:0;}
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
						<div class="typography-section__inner">
							<h2 class="ui-title-block ui-title-block_light">Preliminary Report Review</h2>
							<div class="ui-decor-1a bg-accent"></div>
							<h3 class="ui-title-block_light">File Number <?php echo $orderDetails['file_number']; ?></h3>
							<h3 class="ui-title-block_light"></h3>
							<div style="width: 100%;">
                                <h3 class="ui-title-block_light" style="display: inline-block;"><?php echo $orderDetails['full_address'];?></h3>
								<span class="bg-border" style="float: right;background: #d35411;margin-left:10px;"><a style="color:#fff;" href="<?php echo base_url();?>update-prelim-action/<?php echo $orderDetails['file_id'];?>">Update Prelim Action</a></span>
								<span class="bg-border" style="float: right;cursor:pointer;background: #d35411;" onClick="window.location.reload();">Refresh</span>
							</div>

							<div style="width: 100%;margin-top:10px;">
								<?php if(!empty($success)) { ?>
									<div id="prelim_action_success_msg" class="w-100 alert alert-success alert-dismissible">
										<?php echo $success;?>
									</div>
								<?php } if(!empty($error)) { ?>
									<div id="prelim_action_success_msg" class="w-100 alert alert-danger alert-dismissible">
										<?php echo $error."<br \>";	?>
									</div>
								<?php } ?>
							</div>

							<input type="hidden" id="fileId" name="fileId" value="<?php echo $orderDetails['file_id'];?>">
							<input type="hidden" id="orderId" name="orderId" value="<?php echo $orderDetails['order_id'];?>">
						</div>

						<div class="typography-sectionabcd">
							<div class="col-md-12">
								<div class="col-md-3">
									<div class="typography-section__inner">
										<h3 class="ui-title-block_light">Doc Links</h3>
										<div class="ui-decor-1a bg-accent"></div>
									</div>
									<aside class="l-sidebarb l-sidebar_right">
										<section class="widget section-sidebara">

											<div class="widget-contenta">
												<div class="header-navibox-2">
													<ul class="yamm2 nav navbar-nav2">
														<li class="review_li"><a href="javascript:void(0);" onclick="summary();">Summary</a></li><br>
														<?php  if(!empty($prelimDocument)) { ?>
															<li class="review_li">
																<a onclick="load_doc(<?php echo $prelimDocument['is_sync'];?>, <?php echo $prelimDocument['api_document_id'];?>, <?php echo $prelimDocument['order_id'];?>);" href="javascript:void(0);" onclick="prelim();">
																	Prelim
																</a>
															</li>
															<br>
														<?php } else { ?>
															<li class="review_li">
																<a href="javascript:void(0);" >Prelim</a></li><br>
														<?php } ?>
														<li class="review_li">
															<button class="dropdown-btn">Linked Docs
																<i style="font-size:16px;" class="fa fa-caret-down"></i>
															</button>
															<div class="dropdown-container">
																<ol style="border-bottom: 2px #D35411 dotted !important;"> 
																<?php 
																	if(!empty($linked_doc)) {
																		$count = count($linked_doc);
																		$i = 1;
																		foreach($linked_doc as $document) { 
																			?>
																			<li style="width: 100%;"><a id="<?php echo $document['api_document_id'];?>" style="<?php echo $style;?>display: list-item;" onclick="load_doc(<?php echo $document['is_sync'];?>, <?php echo $document['api_document_id'];?>, <?php echo $document['order_id'];?>);" class="linked_doc" href="javascript:void(0);"><?php echo $document['index_number'].". ".$document['original_document_name'];?></a></li>
																		<?php  $i++; } 
																	 } else { ?>
																		<a class="linked_doc" href="#">No Documents Found</a>
																	<?php } 
																?>
															</ol>
															</div>
														</li>
														<br>
														<li class="review_li"><a href="javascript:void(0);" onclick="legal_vesting();">Legal Vesting</a></li><br>
														<li class="review_li"><a href="javascript:void(0);" onclick="plat_map();">Plat Map</a></li>
														<li class="review_li">
															<button class="dropdown-btn">Uploaded Docs
																<i style="font-size:16px;" class="fa fa-caret-down"></i>
															</button>
															<div class="dropdown-container">
																<ol style="border-bottom: 2px #D35411 dotted !important;"> 
																<?php 
																	if(!empty($uploaded_docs)) {
																		$count = count($uploaded_docs);
																		$i = 1;
																		foreach($uploaded_docs as $document) { 
																			?>
																			<li style="width: 100%;"><a id="<?php echo $document['api_document_id'];?>" style="<?php echo $style;?>display: list-item;" onclick="load_doc(<?php echo $document['is_sync'];?>, <?php echo $document['api_document_id'];?>, <?php echo $document['order_id'];?>);" class="linked_doc" href="javascript:void(0);"><?php echo $i.". ".$document['original_document_name'];?></a></li>
																		<?php  $i++; } 
																	 } else { ?>
																		<a class="linked_doc" href="#">No Documents Found</a>
																	<?php } 
																?>
															</ol>
															</div>
														</li>
													</ul>
												</div>
											</div>
										</section>

										<div class="typography-section__inner">
											<h3 class="ui-title-block_light">Order Details</h3>
											<div class="ui-decor-1a bg-accent"></div>
										</div>
										
										<section class="widget section-sidebar">
											<div class="widget-content2">
												<ul class="widget-list lista">
													<li class="widget-list__item"><a class="widget-list__link"
															href="">Borrower Name</a><br><?php echo $orderDetails['primary_owner'];?></li>
													<div class="ui-decor-3"></div>
													<li class="widget-list__itema"><a class="widget-list__link"
															href="">Transaction Type</a><br><?php echo $orderDetails['product_type']; ?></li>
													<div class="ui-decor-3"></div>
													<?php
														if(strpos($orderDetails['product_type'], 'Sale') !== false)
														{
															if(isset($orderDetails['sales_amount']) && !empty($orderDetails['sales_amount']))
										                    {
										                        $sales_amount = str_replace(",", "", $orderDetails['sales_amount']);
										                    }
													?>
															<li class="widget-list__itema"><a class="widget-list__link"
															href="">Sales Amount</a><br><?php echo isset($sales_amount) && !empty($sales_amount) ? "$".number_format($sales_amount) : '-' ;?></li>
															<div class="ui-decor-3"></div>

													<?php
														}
													?>
													<?php
									                    if(isset($orderDetails['loan_amount']) && !empty($orderDetails['loan_amount']))
									                    {
									                        $loan_amount = str_replace(",", "", $orderDetails['loan_amount']);
									                    }
									                ?>
													<li class="widget-list__itema"><a class="widget-list__link"
															href="">Loan Amount</a><br><?php echo isset($loan_amount) && !empty($loan_amount) ? "$".number_format($loan_amount) : '-' ;?></li>
													<div class="ui-decor-3"></div>
													<li class="widget-list__itema"><a class="widget-list__link"
															href="">Open Date</a><br><?php echo date("m/d/Y", strtotime($orderDetails['opened_date'])); ?></li>
												</ul>
											</div>
										</section>
										<!-- end .widget-->
									</aside>
								</div>

								<div class="col-md-1"></div>
								<div class="col-md-8" id="links_details">
									
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
	 $(document).ready(function(){
		summary();
	});

	var dropdown = document.getElementsByClassName("dropdown-btn");
	var i;
	for (i = 0; i < dropdown.length; i++) {
		dropdown[i].addEventListener("click", function() {
			this.classList.toggle("active");
			var dropdownContent = this.nextElementSibling;
			if (dropdownContent.style.display === "block") {
				dropdownContent.style.display = "none";
			} else {
				dropdownContent.style.display = "block";
			}
		});
	}

	function summary()
	{
		$('#page-preloader').css('background-color', 'rgba(0,0,0,.5)');
		$('#page-preloader').css('display', 'block');
		$.ajax({
			url: base_url + "summary",
			type: "post",
			data: {
				fileId: $('#fileId').val()
			},
			dataType: "html",
			success: function (response) {
				var results = JSON.parse(response);
				$('#links_details').html(results);
				$('#page-preloader').css('display', 'none');
			}
		});
	}

	function prelim()
	{
		$('#page-preloader').css('background-color', 'rgba(0,0,0,.5)');
		$('#page-preloader').css('display', 'block');
		$.ajax({
			url: base_url + "prelim",
			type: "post",
			data: {
				fileId: $('#fileId').val()
			},
			dataType: "html",
			success: function (response) {
				var results = JSON.parse(response);
				$('#links_details').html(results);
				$('#page-preloader').css('display', 'none');
			}
		});
	}

	function load_doc(is_sync, resware_document_id, order_id)
	{
		$('#page-preloader').css('background-color', 'rgba(0,0,0,.5)');
		$('#page-preloader').css('display', 'block');
		$.ajax({
			url: base_url + "load-doc",
			type: "post",
			data: {
				resware_document_id: resware_document_id,
				is_sync: is_sync,
				order_id: order_id
			},
			dataType: "html",
			success: function (response) {
				var results = JSON.parse(response);
				$('#links_details').html(results);
				$('#'+resware_document_id).attr("onclick", "load_doc(1, "+resware_document_id+", "+order_id+")");
				$('#page-preloader').css('display', 'none');
			}
		});
	}

	function legal_vesting()
	{
		$('#page-preloader').css('background-color', 'rgba(0,0,0,.5)');
		$('#page-preloader').css('display', 'block');
		$.ajax({
			url: base_url + "legal-vesting",
			type: "post",
			data: {
				fileId: $('#fileId').val()
			},
			dataType: "html",
			success: function (response) {
				var results = JSON.parse(response);
				$('#links_details').html(results);
				$('#page-preloader').css('display', 'none');
			}
		});
	}

	function plat_map()
	{
		$('#page-preloader').css('background-color', 'rgba(0,0,0,.5)');
		$('#page-preloader').css('display', 'block');
		$.ajax({
			url: base_url + "plat-map",
			type: "post",
			data: {
				fileId: $('#fileId').val()
			},
			dataType: "html",
			success: function (response) {
				var results = JSON.parse(response);
				$('#links_details').html(results);
				$('#page-preloader').css('display', 'none');
			}
		});
	}

	function download_document(resware_document_id, order_id, document_name) 
    {
		$('#page-preloader').css('background-color', 'rgba(0,0,0,.5)');
		$('#page-preloader').css('display', 'block');
		$.ajax({
			url: base_url + "download-document",
			type: "post",
			data: {
				resware_document_id: resware_document_id,
                order_id: order_id,
				document_name: document_name
			},
			success: function (response) {
				$('#page-preloader').css('display', 'none');
				if (response) {
					if (navigator.msSaveBlob) {
						var csvData = base64toBlob(response, 'application/octet-stream');
						var csvURL = navigator.msSaveBlob(csvData, 'FeeEstimation.pdf');
						var element = document.createElement('a');
						element.setAttribute('href', csvURL);
						element.setAttribute('download', document_name);
						element.style.display = 'none';
						document.body.appendChild(element);
						document.body.removeChild(element);
					} else {
						console.log(response);
						var csvURL = 'data:application/octet-stream;base64,' + response;
						var element = document.createElement('a');
						element.setAttribute('href', csvURL);
						element.setAttribute('download', document_name);
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
		return new Blob(byteArrays, {
			type: contentType
		});
	}
</script>
</html>
