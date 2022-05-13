<style>
.card .card-header[data-toggle=collapse] {
		border: none;
	}
.card .custom-control-label {
	cursor: pointer;
	width: 100%;
}
.custom-checkbox input[type="checkbox"]:checked+label{  text-decoration: line-through;}
.custom-checkbox .custom-control-label::before,.custom-control-label::after {
	left: -2rem;
	width: 1.5rem;
    height: 1.5rem;
	top: 0;
	border-radius: 0;
}
</style>
<div class="content">
    <div class="container-fluid">
        <div class="row mb-3">
            <div class="col-sm-8">
				<div class="row">
					<div class="col-sm-4">
						<h1 class="h3 text-gray-800">Order's Tasks</h1>
					</div>
					<div class="col-sm-3">
						<div class="progress mt-1">
							<div class="progress-bar custom__task_progress" role="progressbar" style="width: 0%" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100">0%</div>
						</div>
					</div>

				</div>
                
				
            </div>
			<div class="col-sm-4 text-right custom__task_button">
				<button type="button" class="btn btn-primary btn-sm task_check_all"><i class="fa fa-check"></i></button>
				<button type="button" class="btn btn-primary btn-sm task_un_check_all"><i class="fa fa-square"></i></button>
				<button type="button" class="btn btn-primary btn-sm task_show_all"><i class="fa fa-plus"></i></button>
				<button type="button" class="btn btn-primary btn-sm task_hide_all"><i class="fa fa-minus"></i></button>
			</div>
        </div>
		<form method="post" >
			<div class="row">
				<div class="col-md-12">
					<div class="card shadow mb-4">
						<div class="card-header py-3">
							<h6 class="m-0 font-weight-bold text-primary">Tasks List</h6>
						</div>

                        <div class="card-body">
                            <?php if (!empty($tasks)) {
                                foreach($tasks as $task) { 
									if ($task['parent_task_id'] == 0) {
										$keys = array();
										$keys = array_keys(array_column($tasks, 'parent_task_id'), $task['id']);?>
											<div class="card custom__task_card">
												<div class="card-header py-3">
													<div class="row">
														<div class="col-sm-10">
															<div class="custom-control custom-checkbox">
																<input type="checkbox" class="custom-control-input custom__task_checkbox" id="check_<?php echo $task['id']; ?>" name="task_done[]" value="<?php echo $task['id']; ?>" <?php if(in_array($task['id'],$completedTaskIds)) echo "checked";?>>
																<label class="custom-control-label" for="check_<?php echo $task['id']; ?>"><?php echo $task['name']; ?></label>
															</div>
															<!-- <h6 class="m-0 font-weight-bold text-primary">Collapsable Card Example</h6> -->
														</div>
														<div class="col-sm-2 text-right">
															<a href="#collapseCard_<?php echo $task['id']; ?>" class=" card-header" data-toggle="collapse"
																role="button" aria-expanded="false" aria-controls="collapseCard_<?php echo $task['id']; ?>">
																
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

														<?php $j=0; if (!empty($keys)) { ?>
															<h3 class="font-weight-bold text-primary">Sub Task</h3>
															<hr style="border-top: 2px solid #d0c9c9;"/>
															<?php foreach($keys as $key) { $j++;?>
																<div class="custom-control custom-checkbox" style="margin: 10px 10px;">
																	<input type="checkbox" class="custom-control-input" id="check_<?php echo $tasks[$key]['id']; ?>" name="task_done[]" value="<?php echo $tasks[$key]['id']; ?>" <?php if(in_array($tasks[$key]['id'],$completedTaskIds)) echo "checked";?>>
																	<label class="custom-control-label" for="check_<?php echo $tasks[$key]['id']; ?>"><?php echo $tasks[$key]['name']; ?></label>
																</div>
															<?php }
														} ?>
														
														
														<h3 class="font-weight-bold text-primary" <?php echo $j > 0 ? 'style="margin-top: 25px !important;"' : '';?>>Notes</h3>
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
														
														
														<h3 class="font-weight-bold text-primary" style="margin-top:20px;margin-bottom:20px;">
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
																							<a target="_blank" href="<?php echo env('AWS_PATH').'borrower/'.$document['document_name'];?>" class="btn button btn-info">
																								<span class="text">View</span>
																							</a>
																							<?php if ($document['api_document_id'] > 0) { ?>
																								<a href="#" class="btn button btn-success" style="width:auto;">
																									<span class="text">Approved & Pushed</span>
																								</a>
																							<?php } else { ?>
																								<a style="width:auto;" href="<?php echo base_url()."hr/admin/upload-documet-resware/".$document['id'];?>" class="btn button btn-success">
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
                                    <!-- <div class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input" id="check_<?php echo $task['id']; ?>" name="task_done[]" value="<?php echo $task['id']; ?>" <?php if(in_array($task['id'],$completedTaskIds)) echo "checked";?>>
                                        <label class="custom-control-label" for="check_<?php echo $task['id']; ?>"><?php echo $task['name']; ?></label>
                                    </div> -->
                                <?php } }
                            } else { ?>
                                <div>No Task Found</div>
                            <?php } ?>
                        </div>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-md-6">
					<button type="submit" class="btn btn-info btn-icon-split">
						<span class="icon text-white-50">
							<i class="fas fa-save"></i>
						</span>
						<span class="text">Save</span>
					</button>
					<a href="<?php echo base_url().'hr/admin/orders'; ?>" class="btn btn-secondary btn-icon-split">
						<span class="icon text-white-50">
							<i class="fas fa-arrow-right"></i>
						</span>
						<span class="text">Cancel</span>
					</a>
					<div class="clearfix"></div>
				</div>
			</div>
		</form> 
    </div>
</div>


