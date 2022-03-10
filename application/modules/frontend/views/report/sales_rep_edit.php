<section class="section-type-4a section-defaulta" style="padding-bottom:0px;">
	<div class="container">
		<div class="row">
			<div class="col-sm-12">
				<div class="">
					<h2 class="ui-title-block ui-title-block_light">Sales Representative</h2>
					<div class="ui-decor-1a bg-accent"></div>
					
				</div>
			</div>
		</div>
		<div class="">
			<div class="row">
				<div class="row">
					<div class="col-md-12">
						<h2>Edit Record <span class="pull-right" style="font-size: 16px"> <a href="<?php echo base_url('reports/sales_rep') ?>">Sales Representative</a> / Edit </span></h2>
						<div class="smart-forms smart-container">
							<form method="POST" id="smart-form" enctype="multipart/form-data" novalidate="novalidate" action="<?php echo base_url('reports/sales_rep').'/'.$salesRep['id'] ?>">
								<div class="form-body">
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
									<div class="frm-row">
										<?php
										$image_found = false;
										$image_url = trim(env('AWS_PATH').$salesRep['sales_rep_report_image']);
										if (!empty($salesRep['sales_rep_report_image']) && checkRemoteFile($image_url)):
											$image_found = true;
										?>
										<div class="section colm colm12 text-center">

											<div style="margin: 20px">
												<img src="<?php echo $image_url;?>" height="200" width="200" style="border-radius: 50%">
											</div>
										</div>
										<?php endif; ?>
										<div class="section colm colm4">

											<label class="field prepend-icon">
												<input type="text" class="gui-input" name="first_name" value="<?=$salesRep['first_name'];?>" placeholder="First Name">
												<span class="field-icon"><i class="fa fa-user"></i></span>
											</label>
											
										</div>

										<div class="section colm colm4">

											<label class="field prepend-icon">
												<input type="text" class="gui-input" name="last_name" value="<?=$salesRep['last_name'];?>" placeholder="Last Name">
												<span class="field-icon"><i class="fa fa-user"></i></span>
											</label>
											
										</div>

										<div class="section colm colm4">

											<label class="field prepend-icon">
												<input type="text" class="gui-input" name="title" value="<?=$salesRep['title'];?>" placeholder="Title"> 
												<span class="field-icon"><i class="fa fa-user"></i></span>
											</label>
											
										</div>

										<div class="section colm colm6">

											<label class="field prepend-icon">
												<input type="tel" class="gui-input" name="telephone_no" value="<?=$salesRep['telephone_no'];?>">
												<span class="field-icon"><i class="fa fa-phone-square"></i></span>
											</label>
											
										</div>

										<div class="section colm colm6">

											<label class="field prepend-icon">
												<input type="email" class="gui-input" name="email_address" value="<?=$salesRep['email_address'];?>">
												<span class="field-icon"><i class="fa fa fa-envelope"></i></span>
											</label>
											
										</div>
										<div class="section colm colm12 text-center">

												<label class="field prepend-icon file">
												<?php
												$image_url = trim(env('AWS_PATH').$salesRep['sales_rep_report_image']);
												if (!empty($salesRep['sales_rep_report_image']) && $image_found):
												?>
												<span class="button"> Change Image </span>
												<?php
												else:
												?>
												
												<span class="button"> Upload Image </span>
												<?php
												endif;
												?>
												<input type="file" class="gui-file" name="sales_rep_report_image" id="report_image" 
												onChange="document.getElementById('uploader1').value = this.value;">
												<input type="text" class="gui-input" id="uploader1" placeholder="no file selected" readonly>
												<span class="field-icon"><i class="fa fa-upload"></i></span>
											</label>
										</div>
								
										<div class="section colm colm4">
											
												
											<button type="reset" class="button btn-default">Reset Form</button>
											<button type="submit" class="button btn-primary">Submit Form</button>
							
										</div>
												
											
									</div>
								</div>
							</form>
						</div>
						
					</div>
				</div>
			</div>
		</div>
	</div>
</section>

	
