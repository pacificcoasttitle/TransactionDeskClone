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
                                foreach($tasks as $task) { ?>
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
												<?php if(empty($task['notes'])) : ?>
													-
												<?php else : ?>
													<?php echo nl2br($task['notes']); ?>
												<?php endif; ?>
											</div>
										</div>
									</div>
                                    <!-- <div class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input" id="check_<?php echo $task['id']; ?>" name="task_done[]" value="<?php echo $task['id']; ?>" <?php if(in_array($task['id'],$completedTaskIds)) echo "checked";?>>
                                        <label class="custom-control-label" for="check_<?php echo $task['id']; ?>"><?php echo $task['name']; ?></label>
                                    </div> -->
                                <?php } 
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


