<section class="section-type-4a section-defaulta b-contact b-contact_mod-a" style="padding-bottom:0px;">
<div class="content">
    <div class="container">
        <div class="row mb-3">
            <div class="col-sm-8">
				<div class="typography-section__inner">
						
						<div class="row">
							<div class="col-lg-5 col-md-6 col-sm-7 col-xs-6">
								<h2 class="ui-title-block ui-title-block_light">Order Tasks</h2>
								<div class="ui-decor-1a bg-accent"></div>
							</div>
							<div class="col-xs-3">
								<div class="progress-holder mt-20">

									<div role="progressbar" class="custom__task_progress" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100">20%</div>
									<div>&nbsp;Task items are ✓</div>
								</div>
								

							</div>

						</div>
                        
                        <!-- <h3 class="ui-title-block_light">Please check the task which is completed.</h3> -->
				</div>
            </div>
			<div class="col-sm-4 text-right custom__task_button  mt-20">
			<div class="typography-section__inner">

				<button type="button" class="btn button-color task_check_all"><i class="fa fa-check"></i></button>
				<button type="button" class="btn button-color task_un_check_all"><i class="fa fa-square"></i></button>
				<button type="button" class="btn button-color task_show_all"><i class="fa fa-plus"></i></button>
				<button type="button" class="btn button-color task_hide_all"><i class="fa fa-minus"></i></button>
			</div>
			</div>
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
                                foreach($tasks as $task) { ?>
									<div class="card custom__task_card">
										<div class="card-header py-3">
											<div class="row">
												<div class="col-xs-10">
													<label class="custom-control custom-checkbox task__name">
														<input type="checkbox" class="custom-control-input custom__task_checkbox" id="check_<?php echo $task['id']; ?>" name="task_done[]" value="<?php echo $task['id']; ?>" <?php if(in_array($task['id'],$completedTaskIds)) echo "checked";?>>
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
												<?php if(empty($task['notes'])) : ?>
													-
												<?php else : ?>
													<?php echo nl2br($task['notes']); ?>
												<?php endif; ?>
											</div>
										</div>
									</div>
                                    
                                <?php } 
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
