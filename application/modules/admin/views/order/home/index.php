<div id="content-wrapper">
    <div class="container-fluid">
        <!-- Icon Cards-->
		<div class="row mb-4">
			<div class="col-md-6 col-sm-12">
					<div class="row">
						<div class="col-sm-12 mb-4">
							<div class="card-header  bg-primary text-white">
							Open Orders of <?=date('F Y')?>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-md-6 col-sm-12">
							<div class="card border-primary">

								<div class="card-body text-primary">
									<div class="mr-5"><?php echo $openSalesCount.' Sales Orders'; ?></div>
								</div>
	
								<a class="card-footer clearfix small z-1 bg-primary text-white" href="<?php echo base_url().'order/admin/orders' ?>">
									<span class="float-left">View Details</span>
									<span class="float-right">
										<i class="fas fa-angle-right"></i>
									</span>
								</a>
							</div>
							
						</div>
						<div class="col-md-6 col-sm-12">
							<div class="card border-primary">

								<div class="card-body text-primary">
									<div class="mr-5"><?php echo $openLoanCount.' Refi Orders'; ?></div>
								</div>
								<a class="card-footer clearfix small z-1 bg-primary text-white" href="<?php echo base_url().'order/admin/orders' ?>">
									<span class="float-left">View Details</span>
									<span class="float-right">
										<i class="fas fa-angle-right"></i>
									</span>
								</a>
							</div>
						</div>
					</div>
					
				
			</div>
			<div class="col-md-6 col-sm-12">
					<div class="row">
						<div class="col-sm-12 mb-4">
							<div class="card-header bg-primary text-white">
							Closed Orders of <?=date('F Y')?>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-md-6 col-sm-12">
							<div class="card border-primary">

								<div class="card-body text-primary">
									<div class="mr-5"><?php echo $closedSalesCount.' Sales Orders'; ?></div>
								</div>
	
								<a class="card-footer clearfix small z-1 bg-primary text-white" href="<?php echo base_url().'order/admin/orders' ?>">
									<span class="float-left">View Details</span>
									<span class="float-right">
										<i class="fas fa-angle-right"></i>
									</span>
								</a>
							</div>
							
						</div>
						<div class="col-md-6 col-sm-12">
							<div class="card border-primary">

								<div class="card-body text-primary">
									<div class="mr-5"><?php echo $closedLoanCount.' Refi Orders'; ?></div>
								</div>
								<a class="card-footer clearfix small z-1 bg-primary text-white" href="<?php echo base_url().'order/admin/orders' ?>">
									<span class="float-left">View Details</span>
									<span class="float-right">
										<i class="fas fa-angle-right"></i>
									</span>
								</a>
							</div>
						</div>
					</div>
			</div>
		</div>


		<div class="row mb-4">
			<div class="col-sm-12">
					<div class="row">
						<div class="col-sm-12 mb-4">
							<div class="card-header bg-info text-white">
							# of Clients
							</div>
						</div>
					</div>

					<div class="row">
						<div class="col-md-4 col-sm-12">
							<div class="card">

								<div class="card-body text-info">
									<div class="mr-5"><?php echo $escrowUsersCount.' Escrows'; ?></div>
								</div>

								<a class="card-footer clearfix small z-1 bg-info text-white" href="<?php echo base_url('order/admin/escrow'); ?>">
									<span class="float-left">View Details</span>
									<span class="float-right">
										<i class="fas fa-angle-right"></i>
									</span>
								</a>
							</div>

						</div>

						<div class="col-md-4 col-sm-12">
							<div class="card">

								<div class="card-body text-info">
									<div class="mr-5"><?php echo $lenderUsersCount.' Lenders'; ?></div>
								</div>

								<a class="card-footer clearfix small z-1 bg-info text-white" href="<?php echo base_url('order/admin/lenders'); ?>">
									<span class="float-left">View Details</span>
									<span class="float-right">
										<i class="fas fa-angle-right"></i>
									</span>
								</a>
							</div>

						</div>

						<div class="col-md-4 col-sm-12">
							<div class="card">

								<div class="card-body text-info">
									<div class="mr-5"><?php echo $salesRepUsersCount.' Sales Rep'; ?></div>
								</div>

								<a class="card-footer clearfix small z-1 bg-info text-white" href="<?php echo base_url('order/admin/sales-rep'); ?>">
									<span class="float-left">View Details</span>
									<span class="float-right">
										<i class="fas fa-angle-right"></i>
									</span>
								</a>
							</div>

						</div>

					</div>
			</div>
		</div>
		<div class="row mb-4">
				<div class="col-md-6 col-sm-12">
					<div class="card">

						<div class="card-header bg-danger text-white">
							# of expired passwords
						</div>

						<div class="card-body text-danger">
							<div class="mr-5"><?php echo $expiredPasswordCount.' Password expired'; ?></div>
						</div>

						<a class="card-footer clearfix small z-1 bg-danger text-white" href="<?php echo base_url('order/admin/incorrect-users'); ?>">
							<span class="float-left">View Details</span>
							<span class="float-right">
								<i class="fas fa-angle-right"></i>
							</span>
						</a>
					</div>

				</div>

				<div class="col-md-6 col-sm-12">
					<div class="card">

						<div class="card-header bg-danger text-white">
							Not received JSON
						</div>

						<div class="card-body text-danger">
							<div class="mr-5"><?php echo $failedJsonCount.' files'; ?></div>
						</div>

						<div class="card-footer clearfix small z-1 bg-danger text-white">
							<span class="float-left">&nbsp;</span>
							<span class="float-right">
								<!-- <i class="fas fa-angle-right"></i> -->
							</span>
						</div>
					</div>

				</div>
		</div>

    </div>
    <!-- /.container-fluid -->
</div>
<!-- /.content-wrapper -->
