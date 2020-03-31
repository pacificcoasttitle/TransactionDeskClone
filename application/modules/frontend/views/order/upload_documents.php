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
							<h2 class="ui-title-block ui-title-block_light">Upload a Document</h2>
							<div class="ui-decor-1a bg-primary"></div>
							<h3 class="ui-title-block_light">File Number <?php echo $orderDetails['file_number'];?></h3>
							<h3 class="ui-title-block_light"><?php echo $orderDetails['full_address'];?></h3>
						</div>
						<div class="typography-sectiona">
							<div class="col-md-12">
								<div class="table-container">

									<div class="typography-sectione typography-section-border">
										<div class="container">
											<div class="row">
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
																<select class="dropdown-toggle">
																	<option value="">DOCUMENT TYPE:</option>
																	<?php foreach($documentTypes as $documentType) { ?>
																	<option
																		value="<?php echo $documentType['api_id'];?>">
																		<?php echo $documentType['name'];?></option>
																	<?php } ?>
																</select>
															</div>
															<div class="input-group">

																<div class="custom-file">
																	<input type="file" class="custom-file-input"
																		id="inputGroupFile01"
																		aria-describedby="inputGroupFileAddon01">

																</div>
															</div>
															<div class="header-language-nav dropdown">

																<div class="" style="margin-top: 10px;">
																	<textarea rows="3" cols="44" type="file"
																		class="custom-file-input" id="inputGroupFile01"
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
																	#2</span></cite>
														</footer>
														<div class="b-blockquote-3__content">
															<div class="header-language-nav dropdown">
																<select class="dropdown-toggle">
																	<option value="">DOCUMENT TYPE:</option>
																	<?php foreach($documentTypes as $documentType) { ?>
																	<option
																		value="<?php echo $documentType['api_id'];?>">
																		<?php echo $documentType['name'];?></option>
																	<?php } ?>
																</select>
															</div>
															<div class="input-group">

																<div class="custom-file">
																	<input type="file" class="custom-file-input"
																		id="inputGroupFile01"
																		aria-describedby="inputGroupFileAddon01">

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
																	#3</span></cite>
														</footer>
														<div class="b-blockquote-3__content">
															<div class="header-language-nav dropdown">
																<select class="dropdown-toggle">
																	<option value="">DOCUMENT TYPE:</option>
																	<?php foreach($documentTypes as $documentType) { ?>
																	<option
																		value="<?php echo $documentType['api_id'];?>">
																		<?php echo $documentType['name'];?></option>
																	<?php } ?>
																</select>
															</div>
															<div class="input-group">

																<div class="custom-file">
																	<input type="file" class="custom-file-input"
																		id="inputGroupFile01"
																		aria-describedby="inputGroupFileAddon01">

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
																<select class="dropdown-toggle">
																	<option value="">DOCUMENT TYPE:</option>
																	<?php foreach($documentTypes as $documentType) { ?>
																	<option
																		value="<?php echo $documentType['api_id'];?>">
																		<?php echo $documentType['name'];?></option>
																	<?php } ?>
																</select>
															</div>
															<div class="input-group">

																<div class="custom-file">
																	<input type="file" class="custom-file-input"
																		id="inputGroupFile01"
																		aria-describedby="inputGroupFileAddon01">

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
																	#5</span></cite>
														</footer>
														<div class="b-blockquote-3__content">
															<div class="header-language-nav dropdown">
																<select class="dropdown-toggle">
																	<option value="">DOCUMENT TYPE:</option>
																	<?php foreach($documentTypes as $documentType) { ?>
																	<option
																		value="<?php echo $documentType['api_id'];?>">
																		<?php echo $documentType['name'];?></option>
																	<?php } ?>
																</select>
															</div>
															<div class="input-group">

																<div class="custom-file">
																	<input type="file" class="custom-file-input"
																		id="inputGroupFile01"
																		aria-describedby="inputGroupFileAddon01">

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
																<select class="dropdown-toggle">
																	<option value="">DOCUMENT TYPE:</option>
																	<?php foreach($documentTypes as $documentType) { ?>
																	<option
																		value="<?php echo $documentType['api_id'];?>">
																		<?php echo $documentType['name'];?></option>
																	<?php } ?>
																</select>
															</div>
															<div class="input-group">

																<div class="custom-file">
																	<input type="file" class="custom-file-input"
																		id="inputGroupFile01"
																		aria-describedby="inputGroupFileAddon01">

																</div>
															</div>

														</div>

													</blockquote>
													<!-- end .b-blockquote-->
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

		</div>
		</div>
	</section>

	<?php
           $this->load->view('layout/footer');
        ?>
</body>

</html>
