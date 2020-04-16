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
							<div class="ui-decor-1a bg-primary"></div>
							<h3 class="ui-title-block_light">File Number <?php echo $orderDetails['file_number'];?></h3>
							<h3 class="ui-title-block_light"><?php echo $orderDetails['full_address'];?></h3>
							<input type="hidden" id="fileId" name="fileId" value="<?php echo $orderDetails['file_id'];?>">
							<input type="hidden" id="orderId" name="orderId" value="<?php echo $orderDetails['order_id'];?>">
						</div>

						<div class="typography-sectionabcd">
							<div class="col-md-12">
								<div class="col-md-2">
									<div class="typography-section__inner">
										<h3 class="ui-title-block_light">Doc Links</h3>
										<div class="ui-decor-1a bg-primary"></div>
									</div>
									<aside class="l-sidebarb l-sidebar_right">
										<section class="widget section-sidebara">

											<div class="widget-contenta">
												<div class="header-navibox-2">
													<ul class="yamm2 nav navbar-nav2">
														<li><a href="javascript:void(0);" onclick="summary();">Summary</a></li><br>
														<li><a href="javascript:void(0);" onclick="prelim();">Prelim</a></li><br>
														<li><a href="javascript:void(0);" onclick="linked_doc();">Linked Docs</a></li><br>
														<li><a href="javascript:void(0);" onclick="legal_vesting();">Legal Vesting</a></li><br>
														<li><a href="javascript:void(0);" onclick="plat_map();">Plat Map</a></li>

													</ul>
												</div>
											</div>
										</section>

										<div class="typography-section__inner">
											<h3 class="ui-title-block_light">Order Details</h3>
											<div class="ui-decor-1a bg-primary"></div>
										</div>

										<section class="widget section-sidebar">
											<div class="widget-content2">
												<ul class="widget-list lista">
													<li class="widget-list__item"><a class="widget-list__link"
															href="">Borrower Name</a><br>Jackson Storm</li>
													<div class="ui-decor-3"></div>
													<li class="widget-list__itema"><a class="widget-list__link"
															href="">Transaction Type</a><br>Refinance</li>
													<div class="ui-decor-3"></div>
													<li class="widget-list__itema"><a class="widget-list__link"
															href="">Loan Amount</a><br>650,000</li>
													<div class="ui-decor-3"></div>
													<li class="widget-list__itema"><a class="widget-list__link"
															href="">Open Date</a><br>04/11/1983</li>
												</ul>
											</div>
										</section>
										<!-- end .widget-->
									</aside>
								</div>

								<div class="col-md-1"></div>
								<div class="col-md-9" id="links_details">
									
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

	function linked_doc()
	{
		$('#page-preloader').css('background-color', 'rgba(0,0,0,.5)');
		$('#page-preloader').css('display', 'block');
		$.ajax({
			url: base_url + "linked-doc",
			type: "post",
			data: {
				fileId: $('#fileId').val(),
				orderId: $('#orderId').val()
			},
			dataType: "html",
			success: function (response) {
				var results = JSON.parse(response);
				$('#links_details').html(results);
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
			url: base_url + "download-resware-document",
			type: "post",
			data: {
				resware_document_id: resware_document_id,
                order_id: order_id
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
