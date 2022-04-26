<!-- Sidebar -->
<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

	<a class="sidebar-brand d-flex align-items-center justify-content-center"
		href="<?php echo base_url().'hr/admin/dashboard'; ?>">
		<img style="width:200px;" src="<?php echo base_url();?>assets/backend/hr/img/logo2.png">
	</a>

	
	<hr class="sidebar-divider my-0">

	<?php $userdata = $this->session->userdata('escrow_admin');?>
	<?php if($userdata['is_escrow_manager'] == 1) { ?>
		<li class="nav-item <?php if($this->uri->uri_string() == 'escrow/admin/dashboard') { echo 'active'; } ?>">
			<a class="nav-link" href="<?php echo base_url().'escrow/admin/dashboard'; ?>">
				<i class="fas fa-fw fa-tachometer-alt"></i>
				<span>Dashboard</span>
			</a>
		</li>
	<?php } ?>

	<li class="nav-item <?php if($this->uri->uri_string() == 'escrow/admin/orders') { echo 'active'; } ?>">
		<a class="nav-link" href="<?php echo base_url().'escrow/admin/orders'; ?>">
			<i class="fas fa-list"></i>
			<span>Orders</span>
		</a>
	</li>

	<?php if($userdata['is_escrow_manager'] == 1) { ?>
		<li class="nav-item <?php if($this->uri->uri_string() == 'escrow/admin/users') { echo 'active'; } ?>">
			<a class="nav-link" href="<?php echo base_url().'escrow/admin/users'; ?>">
				<i class="fas fa-fw fa-users"></i>
				<span>Users</span>
			</a>
		</li>

		<li
			class="nav-item <?php if($this->uri->uri_string() == 'escrow/admin/notifications') { echo 'active'; } ?>">
			<a class="nav-link" href="<?php echo base_url().'escrow/admin/notifications'; ?>">
				<i class="fas fa-bell fa-fw"></i>
				<span>Notifications</span>
			</a>
		</li>

		<li
			class="nav-item <?php if($this->uri->uri_string() == 'escrow/admin/tasks') { echo 'active'; } ?>">
			<a class="nav-link" href="<?php echo base_url().'escrow/admin/tasks'; ?>">
				<i class="fas fa-tasks fa-fw"></i>
				<span>Task List</span>
			</a>
		</li>
	<?php } ?>
	
	
	<hr class="sidebar-divider d-none d-md-block">

	<div class="text-center d-none d-md-inline">
		<button class="rounded-circle border-0" id="sidebarToggle"></button>
	</div>

</ul>
<!-- End of Sidebar -->
