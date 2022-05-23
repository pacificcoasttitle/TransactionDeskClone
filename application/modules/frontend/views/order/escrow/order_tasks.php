<style>
tr {
	text-align: center;
}
td {
	border: none !important;
}
.table-type-3 {
	border-bottom: none !important;
}
.card.custom__task_card {
	background: #f2f2f2;
}
.custom__task_collapse {
	background: #fff;
}
.spacer-b30 {
	margin-bottom: 30px;
}
.spacer-t30 {
	margin-top: 30px;
}
.smart-forms a.button {
	height: 35px;
	line-height: 35px;
}
.mt-105 {
	margin-top: 105px;
}
.radio {
	top: 5px !important;
	margin: 0px 10px !important;
}
.radio:before {
	background: none !important;
}
</style>
<section class="section-type-4a section-defaulta b-contact b-contact_mod-a" style="padding-bottom:0px;">
	<div class="content">
		<div class="container">
			<div class="row mb-3" style="margin-bottom:40px;">
				<div class="col-sm-8">
					<div class="typography-section__inner">	
						<div class="row">
							<div class="col-lg-6 col-md-6 col-sm-7 col-xs-6">
								<h2 class="ui-title-block ui-title-block_light">Order Tasks</h2>
								<div class="ui-decor-1a bg-accent"></div>
								<h3 class="ui-title-block_light">File Number <?php echo $orderDetails['file_number'];?></h3>
								<h3 class="ui-title-block_light"><?php echo $orderDetails['full_address'];?></h3>
							</div>
							
						</div>
					</div>
				</div>
				<div class="col-sm-4 text-right custom__task_button  mt-20">
					<div class="typography-section__inner">
						<button type="button" class="btn button-color task_check_all"><i class="fa fa-check"></i></button>
						<button type="button" class="btn button-color task_un_check_all"><i class="fa fa-square"></i></button>
						<button type="button" class="btn button-color task_show_all"><i class="fa fa-plus"></i></button>
						<button type="button" class="btn button-color task_hide_all"><i class="fa fa-minus"></i></button>
					</div>
					<div class="mt-105">
						<div class="progress-holder mt-20">
							<div role="progressbar" class="custom__task_progress" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100">20%</div>
							<div>&nbsp;Task items are ✓</div>
						</div>
					</div>
				</div>
				<div id="result"></div>
			</div>
			<?php if(!empty($success)) {?>
				<div class="w-100 alert alert-success alert-dismissible">
					<?php
					if(is_array($success)){
						foreach($success as $sucess) {
							echo $sucess."<br \>";	
						}
					} 
					else {
						echo $success;
					}
					?>
				</div>
			<?php } 
			if(!empty($errors)) {?>
				<div class="w-100 alert alert-danger alert-dismissible">
					<?php foreach($errors as $error) {
						echo $error."<br \>";	
					}?>
				</div>
			<?php } ?>

			<div id="order_tasks_success_msg" class="w-100 alert alert-success alert-dismissible" style="display:none;"></div>
			<div id="order_tasks_error_msg" class="w-100 alert alert-danger alert-dismissible" style="display:none;"></div>

			<input type="hidden" name="order_id" id="order_id" value="<?php echo $orderDetails['order_id'];?>">
			<input type="hidden" name="file_id" id="file_id" value="<?php echo $orderDetails['file_id'];?>">
			<form method="post" >
				<div class="row">
					<div class="col-md-12">
						<div class="b-task-list__item task__info">
						<?php if (!empty($tasks)) {
									foreach($tasks as $task) { 
										if ($task['parent_task_id'] == 0) {
											$keys = array();
											$keys = array_keys(array_column($tasks, 'parent_task_id'), $task['id']);?>
											<div class="card custom__task_card">
												<div class="card-header py-3">
													<div class="row">
														<div class="col-xs-10" style="padding-left: 40px;margin-top: 15px;">
															<label class="custom-control custom-checkbox task__name">
																<input data-child="0" type="checkbox" class="custom-control-input custom__task_checkbox" id="check_<?php echo $task['id']; ?>" name="task_done[]" value="<?php echo $task['id']; ?>" <?php if(in_array($task['id'],$completedTaskIds)) echo "checked";?>>
																<div class="check_box_text"> <?php echo $task['name']; ?></div>
																<span class="checkmark"></span>
															</label>
														</div>
														<div class="col-xs-2 text-right">
															<a href="#collapseCard_<?php echo $task['id']; ?>" class="custom__collapse_arrow collapsed" data-toggle="collapse"
																role="button" aria-expanded="false" aria-controls="collapseCard_<?php echo $task['id']; ?>">
																<i class="fa fa-angle-down"></i>
																<i class="fa fa-angle-up"></i>
															</a>
														</div>
													</div>
												</div>
												<div class="collapse custom__task_collapse" id="collapseCard_<?php echo $task['id']; ?>">
													<div class="card-body">
														<!-- <?php if(empty($task['notes'])) : ?>
															-
														<?php else : ?>
															<?php echo nl2br($task['notes']); ?>
														<?php endif; ?> -->

														<?php if (!empty($keys)) { ?>
															<div class="" id="sub_task_<?php echo $task['id']; ?>">
																<div class="smart-forms spacer-b30 spacer-t30">
																	<div class="tagline" style="<?php echo $task['id'] == 4 ? 'width:80%;' : '';?>"><span>Sub Task </span></div>
																	<?php if ($task['id'] == 4) { ?>
																		<a href="#borrower_information" data-toggle="collapse"
																			role="button" aria-expanded="false" aria-controls="borrower_information" href="#" class="btn button btn-primary" style="height: 35px;float:right;line-height:35px;margin: -15px 15px 0 0;">
																			<span class="text">Send Package</span>
																		</a>
																	<?php } ?>
																</div>
																
																<?php foreach($keys as $key) {?>
																	<label class="custom-control custom-checkbox task__name">
																		<input data-child="1" data-parent-task="<?php echo $task['id']; ?>" type="checkbox" class="custom-control-input custom_sub_task_checkbox" id="check_<?php echo $tasks[$key]['id']; ?>" name="task_done[]" value="<?php echo $tasks[$key]['id']; ?>" <?php if(in_array($tasks[$key]['id'],$completedTaskIds)) echo "checked";?>>
																		<div class="check_box_text"> <?php echo $tasks[$key]['name']; ?></div>
																		<span class="checkmark"></span>
																	</label>
																<?php } ?>
															</div>
														<?php } ?>
														
														<div class="" id="">
															<div class="smart-forms spacer-b30 spacer-t30">
																<div class="tagline" style="width:80%;"><span>Notes </span></div>
																
																<a href="#note_<?php echo $task['id']; ?>" data-toggle="collapse"
																		role="button" aria-expanded="false" aria-controls="note_<?php echo $task['id']; ?>" href="#" class="btn button btn-primary" style="height: 35px;float:right;line-height:35px;margin: -15px 15px 0 0;">
																									<span class="text">Add Note</span>
																								</a>
															</div>
															<ul id="notes_<?php echo $task['id']; ?>">
																<?php $i = 0;
																foreach($order_task_notes as $order_task_note) { 
																	if ($order_task_note['task_id'] == $task['id']) { 
																		$i++; ?>
																		<li><b><?php echo $order_task_note['subject']?></b>: <?php echo $order_task_note['note']?></li>
																	<?php }
																} ?>
																<?php if ($i == 0)  { ?>
																	<li>No notes found for this task.</li>
																<?php } ?>
															</ul>

															<div class="form-reply ui-form-1 collapse" id="note_<?php echo $task['id']; ?>">
																<div class="smart-forms spacer-b30 spacer-t30">
																	<div class="tagline"><span>Create a Note</span></div>
																</div>
																<div class="row">
																	<div class="col-xs-10">
																		<input class="form-control" type="text" name="subject_<?php echo $task['id']; ?>" id="subject_<?php echo $task['id']; ?>" placeholder="Subject">
																	</div>
																</div>

																<input type="hidden" name="num_of_notes_<?php echo $task['id']; ?>" id="num_of_notes_<?php echo $task['id']; ?>" value="<?php echo $i; ?>">
																
																<div class="row">
																	<div class="col-xs-10">
																		<textarea class="form-control" rows="4" name="note_desc_<?php echo $task['id']; ?>" id="note_desc_<?php echo $task['id']; ?>" placeholder="Note"></textarea>
																	</div>
																</div>
																					
																<div class="row">
																	<div class="col-xs-12 smart-forms">
																		<a onclick="return create_note(<?php echo $task['id']; ?>);"  href="#" class="btn button btn-primary" style="height: 35px;line-height:35px;">
																			<span class="text">Create</span>
																		</a>
																	</div>
																</div>
															</div>

														</div>
													
														<div class="" id="">
															<div class="smart-forms spacer-b30 spacer-t30">
																<div class="tagline"><span>Documents</span></div>
															</div>
															<table class="table table-type-3 typography-last-elem no-footer">
																<thead>
																	<tr>
																		<th>#</th>
																		<th>Document Name</th>
																		<th>Action</th>
																	</tr>
																</thead>
																<tbody>
																	<?php $j = 1;
																		if(!empty($borrowerDocuments)) {
																			foreach ($borrowerDocuments as $document) {
																				if ($document['task_id'] == $task['id']) { ?>
																					<tr role="row" class="odd">
																						<td><?php echo $j;?></td>
																						<td><?php echo $document['original_document_name'];?></td>
																						<td>
																							<div class="custom__task_actions smart-forms" style="display: inline-block;">
																								<a target="_blank" href="<?php echo env('AWS_PATH').'borrower/'.$document['document_name'];?>" class="btn button btn-primary">
																									<span class="text">View</span>
																								</a>
																								<?php if ($document['api_document_id'] > 0) { ?>
																									<a href="#" class="btn button btn-default" style="width:auto;">
																										<span class="text">Approved & Pushed</span>
																									</a>
																								<?php } else { ?>
																									<a style="width:auto;" href="<?php echo base_url()."upload-documet-resware/".$document['id'];?>" class="btn button btn-default">
																										<span class="text">Approve & Push</span>
																									</a>
																								<?php }  ?>
																								<div class="clearfix"></div>
																							</div>
																						</td> 
																					</tr>
																				<?php $j++;
																				} 
																			}
																		}
																		if ($j == 1)  { ?>
																			<tr role="row" class="odd"><td colspan="4" class="text-center">No documents found</td></tr>
																	<?php } ?>
																</tbody>
															</table>
														</div>
													</div>
												</div>
											</div>
										
									<?php }
									} 
								} else { ?>
									<div>No Task Found</div>
								<?php } ?>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-md-6 custom__task_actions smart-forms">
						<button type="submit" class="btn button btn-primary">
							<span class="text">Save</span>
						</button>
						<a href="#" class="btn button btn-default" style="line-height: 42px;height: 42px;">
							<span class="text">Cancel</span>
						</a>
						<div class="clearfix"></div>
					</div>
				</div>
			</form> 
		</div>
		<div class="typography-sectionab"></div>
	</div>

</section>

<div class="modal fade" width="500px" id="borrower_information" tabindex="-1" role="dialog"
	aria-labelledby="Borrower Infromation" aria-hidden="true">
	<div class="modal-dialog modal-lg" role="document" style="width:40%;">
		<div class="modal-content">
			<form method="POST" action="<?php echo base_url();?>add-borrower-on-order" enctype="multipart/form-data">
				<div class="smart-forms smart-container wrap-2" style="margin:30px">
					<div class="modal-body search-result">
						<div id="lender-details-fields" >
							<div class="spacer-b20">
								<div class="tagline"><span>Select Package</span></div>
							</div>

							<div class="frm-row spacer-b25">
								<div class="section colm colm12">
									<label class="field prepend-icon">
										<input class="radio" type="radio" name="package_type" id="buyer" value="buyer" required>Buyer
										<input class="radio" type="radio" name="package_type" id="seller" value="seller">Seller
									</label>
								</div>
							</div>

							<div class="spacer-b25">
								<div class="tagline"><span>Borrower Email Address</span></div>
							</div>

							<div class="frm-row">
								<div class="section colm colm12">
									<label class="field prepend-icon">
										<input type="text" name="LenderCompany" id="LenderCompany" class="gui-input ui-autocomplete-input"
											placeholder="Enter Borrower Email Address" required="required">
										<span class="field-icon"><i class="fa fa-user"></i></span>
										<input type="hidden" name="partner_id" id="partner_id" value="">
									</label>
								</div>
							</div>							
						</div>
					</div>

					<input type="hidden" name="order_id" id="order_id" value="<?php echo $orderDetails['order_id'];?>">
					<input type="hidden" name="file_id" id="file_id" value="<?php echo $orderDetails['file_id'];?>">

					<div class="form-footer" style="padding-top:0px;">
						<button type="submit" data-btntext-sending="Sending..."
							class="button btn-primary">Submit</button>
						<button type="button" data-dismiss="modal" aria-label="Close" class="button">Cancel</button>
					</div>
				</div>
			</form>
		</div>
	</div>
</div>
