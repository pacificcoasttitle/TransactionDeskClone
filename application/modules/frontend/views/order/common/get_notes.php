<style type="text/css">
	.error {
		color: #FF2F0F;
	}
    th {
        text-align: center;
    }
</style>
<section class="section-type-4a section-defaulta" style="padding-bottom:0px;">
	<div class="container">
		<div class="row">
			<div class="row">
				<div class="col-xs-12">
					<div class="typography-section__inner" style="margin-bottom: 20px;">
						<h2 class="ui-title-block ui-title-block_light">Create a Note</h2>
						<div class="ui-decor-1a bg-primary"></div>
						<h3 class="ui-title-block_light">File Number <?php echo $orderDetails['file_number'];?></h3>
						<h3 class="ui-title-block_light"><?php echo $orderDetails['full_address'];?></h3>
					</div>
					<?php if(!empty($success)) {?>
					<div id="agent_success_msg" class="w-100 alert alert-success alert-dismissible">
						<?php foreach($success as $sucess) {
								echo $sucess."<br \>";	
							}?>
					</div>
					<?php } 
						if(!empty($errors)) {?>
					<div id="agent_error_msg" class="w-100 alert alert-danger alert-dismissible">
						<?php foreach($errors as $error) {
								echo $error."<br \>";	
							}?>
					</div>
					<?php } ?>
					<div class="loader"></div>

					<div class="typography-sectione typography-section-border">
						<div class="container">
							<div class="row">
								<section class="section-reply-form" id="section-reply-form" style="margin-top: 20px;">
									<form class="form-reply ui-form-1" action="<?php echo base_url();?>create-note" method="POST" id="create-note" name="create-note"
										method="POST">
										<div class="row">
											<div class="col-xs-10">
												<input class="form-control" type="text" name="subject" id="subject" placeholder="Subject" required>
												<input type="hidden" name="fileId" id="fileId" value="<?php echo $orderDetails['file_id']; ?>">
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
														<?php foreach($tasks as $task) {?>
															<option value="<?php echo $task->id;?>"><?php echo $task->name;?></option>
														<?php } ?>
													</select>
												</div>
											</div>
										<?php } ?>
										<div class="row">
											<div class="col-xs-12">
												<button type="submit" class="btn btn-default btn-round btn-block">create</button>
											</div>
										</div>
									</form>
									<div id="result"></div>
								</section>
								<section class="section-type-4a section-defaulta" style="padding-bottom:0px;">
									<div class="container">
										<div class="row">
											<div class="row">
												<div class="col-xs-12">
													<div class="typography-section__inner">
														<h2 class="ui-title-block ui-title-block_light">Notes</h2>
														<div class="ui-decor-1a bg-accent"></div>
														<h3 class="ui-title-block_light">Below is list of all your notes.</h3>
													</div>
													<div class="typography-sectiona">
														<div class="col-md-12">
															<div class="table-container">
																<table class="table table_primary" id="notes_listing">
																	<thead>
																		<tr>
																			<th>#</th>
																			<th>Subject</th>
																			<th>Note</th>
																			<th>Task</th>
																			<th>Created</th>
																		</tr>
																	</thead>
																	<tbody>
																		<?php if(!empty($notes)) {
																			$i = 1;
																			foreach($notes as $note) { ?>
																			<tr>
																				<td><?php echo $i;?></td>
																				<td><?php echo $note['subject'];?></td>
																				<td><?php echo $note['note'];?></td>
																				<td><?php echo $note['name'];?></td>
																				<td><?php echo date("m/d/Y", strtotime($note['created_at']));?></td>
																			</tr>
																			<?php $i++; } 
																		} else { ?>
																			<tr>
																				<td colspan="5">No Records Found.</td>
																			</tr>
																		<?php }?>
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
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>
	
