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
							<div class="col-xs-3">
								<div class="progress-holder mt-20">
									<div role="progressbar" class="custom__task_progress" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100">20%</div>
									<div>&nbsp;Task items are ✓</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="col-sm-4 text-right custom__task_button  mt-20">
					<div class="typography-section__inner">
						<button id="show-hide-form-btn" type="button" class="btn button-color"><i class="fa fa-plus"></i>&nbsp;&nbsp;Add Note</button>
						<button type="button" class="btn button-color task_check_all"><i class="fa fa-check"></i></button>
						<button type="button" class="btn button-color task_un_check_all"><i class="fa fa-square"></i></button>
						<button type="button" class="btn button-color task_show_all"><i class="fa fa-plus"></i></button>
						<button type="button" class="btn button-color task_hide_all"><i class="fa fa-minus"></i></button>
					</div>
				</div>

				<form style="padding-left: 15px;margin-bottom: 40px;" class="form-reply ui-form-1 show-hide-form-div hide" action="<?php echo base_url();?>create-note" method="POST" id="create-note" name="create-note" method="POST">
					<div class="row">
						<div class="col-xs-10" style="margin-top: 50px;">
						<h1 class="ui-title-block_light">Create a Note</h1>
							<input class="form-control" type="text" name="subject" id="subject" placeholder="Subject" required>
							<input type="hidden" name="fileId" id="fileId" value="<?php echo $orderDetails['file_id']; ?>">
							<input type="hidden" name="order_task_page" id="order_task_page" value="1">
						</div>
					</div>
					<div class="row">
						<div class="col-xs-10">
							<textarea class="form-control" rows="4" name="body" id="body" placeholder="Note" required></textarea>
						</div>
					</div>
					<?php if (!empty($tasks)) { ?>
						<div class="row">
							<div class="col-xs-10">
								<select class="form-control" id="task_id" name="task_id" required>
									<option value="">Select Task</option>
									<?php foreach($tasks as $task) { 
											if(!empty($task['parent_task_id'] == 0)) {?>
												<option value="<?php echo $task['id'];?>"><?php echo $task['name'];?></option>
											<?php } ?>
									<?php } ?>
								</select>
							</div>
						</div>
					<?php } ?>
					<div class="row">
						<div class="col-xs-12">
							<button type="submit" class="btn btn-default btn-round btn-block">create </button>
						</div>
					</div>
				</form>
				<div id="result"></div>
			</div>
			<?php if(!empty($success)) {?>
				<div id="time_card_success_msg" class="w-100 alert alert-success alert-dismissible">
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
				<div id="time_card_error_msg" class="w-100 alert alert-danger alert-dismissible">
					<?php foreach($errors as $error) {
						echo $error."<br \>";	
					}?>
				</div>
			<?php } ?>
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
														<div class="col-xs-10">
															<label class="custom-control custom-checkbox task__name">
																<input data-child="0" type="checkbox" class="custom-control-input custom__task_checkbox" id="check_<?php echo $task['id']; ?>" name="task_done[]" value="<?php echo $task['id']; ?>" <?php if(in_array($task['id'],$completedTaskIds)) echo "checked";?>>
																<div class="check_box_text"> <?php echo $task['name']; ?></div>
																<span class="checkmark"></span>
																
															</label>
															<!-- <h6 class="m-0 font-weight-bold text-primary">Collapsable Card Example</h6> -->
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
															<h3 class="m-0 font-weight-bold text-primary">Sub Task</h3>
															<hr style="border-top: 2px solid #d0c9c9;"/>
															<?php foreach($keys as $key) {?>
																<label class="custom-control custom-checkbox task__name">
																	<input data-child="1" data-parent-task="<?php echo $task['id']; ?>" type="checkbox" class="custom-control-input custom_sub_task_checkbox" id="check_<?php echo $tasks[$key]['id']; ?>" name="task_done[]" value="<?php echo $tasks[$key]['id']; ?>" <?php if(in_array($tasks[$key]['id'],$completedTaskIds)) echo "checked";?>>
																	<div class="check_box_text"> <?php echo $tasks[$key]['name']; ?></div>
																	<span class="checkmark"></span>
																</label>
															<?php }
														} ?>
														
														<h3 class="m-0 font-weight-bold text-primary">Notes</h3>
														<hr style="border-top: 1px solid #d0c9c9;"/> 
														<ul>
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
													
														<h3 class="m-0 font-weight-bold text-primary" style="margin-top:20px;">
															Documents	
														</h3>
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
																						<div class="custom__task_actions" style="display: inline-block;">
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
										
									<?php }
									} 
								} else { ?>
									<div>No Task Found</div>
								<?php } ?>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-md-6 custom__task_actions">
						<button type="submit" class="btn button btn-primary">
							<span class="text">Save</span>
						</button>
						<a href="#" class="btn button btn-default">
							
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
