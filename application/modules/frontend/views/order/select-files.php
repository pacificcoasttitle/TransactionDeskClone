<body>
	<?php
	    $this->load->view('layout/header_dashboard');
	?>
	<section class="section-type-4a section-defaulta" style="padding-bottom:0px;">
		<div class="container">
			<div class="row">
				<div class="col-xs-12">
					<div class="typography-section__inner">
						<h2 class="ui-title-block ui-title-block_light">Upload a Document</h2>
						<div class="ui-decor-1a bg-primary"></div>
						<h3 class="ui-title-block_light">Below are all files</h3>
					</div>
					<div class="typography-sectiona">
						<div class="col-md-12">
							<div class="table-container">
								<table class="table table_primary">
									<thead>
										<tr>
										  <th>#</th>
										  <th>File Number</th>
										  <th>Property Address</th>
										  <th>Files</th>
										</tr>
									</thead>
									<tbody>
										<tr>
										  <td>1</td>
										  <td>10149407</td>
										  <td>123456 Success Ave. Los Angeles</td>
										  <td><a href="view-prelim.html">Review File</a></td>
										</tr>
									</tbody>
								</table>
								<div class="typography-sectionab">
									<ul class="pagination pagination-1">
										<li><a href="#"><span class="fa fa-angle-left"></span></a></li>
										<li><a href="#">1</a></li>
										<li class="active"><a href="#">2</a></li>
										<li><a href="#">3</a></li>
										<li><a href="#"><span class="fa fa-angle-right"></span></a></li>
								  	</ul>
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