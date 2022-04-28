<style>
	.custom-checkbox input[type="checkbox"]:checked+label{  text-decoration: line-through;}
	
	.task__info label {
		text-transform: capitalize;
		display: block;
		position: relative;
		padding-left: 35px;
		margin-bottom: 12px;
		cursor: pointer;
		font-size: 16px;
		-webkit-user-select: none;
		-moz-user-select: none;
		-ms-user-select: none;
		user-select: none;
		font-weight: normal;
	}

	.card-header {padding: 5px;}

	.card.custom__task_card {border: 1px solid;border-left: 0;border-right: 0;}
	.custom__task_collapse .card-body {
		padding-left: 35px;
		font-size: 16px;
		background: #eee;
	}
	.custom__collapse_arrow {
		padding: 15px;
		font-size: 20px;
	}

		/* Hide the browser's default checkbox */
	.task__info label input {
		position: absolute;
		opacity: 0;
		cursor: pointer;
		height: 0;
		width: 0;
	}

		/* Create a custom checkbox */
	.checkmark {
		position: absolute;
		top: 6px;
		left: 0;
		height: 20px;
		width: 20px;
		/* background-color: #eee; */
		border: 1px solid #da7047;
	}

		
		/* Create the checkmark/indicator (hidden when not checked) */
	.checkmark:after {
		content: "";
		position: absolute;
		display: none;
	}

		/* Show the checkmark when checked */
	.task__info label input:checked ~ .checkmark:after {
		display: block;
	}

		/* Style the checkmark/indicator */
	.task__info label .checkmark:after {
		left: 5px;
		top: 2px;
		width: 7px;
		height: 12px;
		border: solid #da7047;
		border-width: 0 3px 3px 0;
		-webkit-transform: rotate(45deg);
		-ms-transform: rotate(45deg);
		transform: rotate(45deg);
	}
		
	.task__info label input:checked ~ .check_box_text {
		text-decoration: line-through;
	}

	.b-task-list__item.task__info {
		margin-bottom: 20px;
	}
	.custom__task_button .btn {
		width: auto;
		border: 0;
	}
	#progress_bar {
        width: 100%;
        height: 5.5rem;
       
    }
	.progress__bg {
		width: 100%;
		background: #ababab;
		height: 25px;
	}
	.progress-bar.custom__task_progress {
		background: #5e7ead;
		color: #fff;
	}
	.mt-20 {
		margin-top: 20px;
	}
	
		
</style>
<section class="section-type-4a section-defaulta b-contact b-contact_mod-a" style="padding-bottom:0px;">
<div class="content">
    <div class="container">
        <div class="row mb-3">
            <div class="col-sm-8">
				<div class="typography-section__inner">
						
						<div class="row">
							<div class="col-sm-7">
								<h2 class="ui-title-block ui-title-block_light">Order Tasks</h2>
							</div>
							<div class="col-sm-3">
								<!-- <div class="progress mt-1">
									<div class="progress-bar custom__task_progress" role="progressbar" style="width: 0%" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100">0%</div>
								</div> -->
								<div class="progress__bg mt-20">
									<div class="progress-bar custom__task_progress">0%</div>
								</div>
							</div>

						</div>
                        <div class="ui-decor-1a bg-accent"></div>
                        <!-- <h3 class="ui-title-block_light">Please check the task which is completed.</h3> -->
				</div>
            </div>
			<div class="col-sm-4 text-right custom__task_button  mt-20">
			<div class="typography-section__inner">

				<button type="button" class="btn btn-primary btn-sm task_check_all"><i class="fa fa-check"></i></button>
				<button type="button" class="btn btn-primary btn-sm task_un_check_all"><i class="fa fa-square"></i></button>
				<button type="button" class="btn btn-primary btn-sm task_show_all"><i class="fa fa-plus"></i></button>
				<button type="button" class="btn btn-primary btn-sm task_hide_all"><i class="fa fa-minus"></i></button>
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
												<div class="col-sm-10">
													<label class="custom-control custom-checkbox task__name">
														<input type="checkbox" class="custom-control-input custom__task_checkbox" id="check_<?php echo $task['id']; ?>" name="task_done[]" value="<?php echo $task['id']; ?>" <?php if(in_array($task['id'],$completedTaskIds)) echo "checked";?>>
														<div class="check_box_text"> <?php echo $task['name']; ?></div>
														<span class="checkmark"></span>
														
													</label>
													<!-- <h6 class="m-0 font-weight-bold text-primary">Collapsable Card Example</h6> -->
												</div>
												<div class="col-sm-2 text-right">
													<a href="#collapseCard_<?php echo $task['id']; ?>" class="custom__collapse_arrow " data-toggle="collapse"
														role="button" aria-expanded="false" aria-controls="collapseCard_<?php echo $task['id']; ?>">
														<i class="fa fa-angle-down"></i>
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
				<div class="col-md-6">
					<button type="submit" class="btn btn-info btn-icon-split">
						<span class="text">Save</span>
					</button>
					<a href="#" class="btn btn-danger btn-icon-split">
						
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
