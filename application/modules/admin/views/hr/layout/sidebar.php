<!-- Sidebar -->
<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

	<!-- Sidebar - Brand -->
	<a class="sidebar-brand d-flex align-items-center justify-content-center"
		href="<?php echo base_url().'hr/admin/dashboard'; ?>">
		<img style="width:200px;" src="<?php echo base_url();?>assets/backend/hr/img/logo2.png">
	</a>

	<!-- Divider -->
	<hr class="sidebar-divider my-0">

	<li class="nav-item <?php if($this->uri->uri_string() == 'hr/admin/dashboard') { echo 'active'; } ?>">
		<a class="nav-link" href="<?php echo base_url().'hr/admin/dashboard'; ?>">
			<i class="fas fa-fw fa-tachometer-alt"></i>
			<span>Dashboard</span>
		</a>
	</li>

	<li
		class="nav-item <?php if($this->uri->uri_string() == 'hr/admin/time-cards' || $this->uri->uri_string() == 'hr/admin/add-time-card' || $this->uri->segment(3) == 'edit-time-card') { echo 'active'; } ?>">
		<a class="nav-link" href="<?php echo base_url().'hr/admin/time-cards'; ?>">
			<i class="fas fa-fw fa-tachometer-alt"></i>
			<span>Time Cards</span>
		</a>
	</li>

	<li
		class="nav-item <?php if($this->uri->uri_string() == 'hr/admin/vacation-requests' || $this->uri->uri_string() == 'hr/admin/add-vacation-request' || $this->uri->segment(3) == 'edit-vacation-request') { echo 'active'; } ?>">
		<a class="nav-link" href="<?php echo base_url().'hr/admin/vacation-requests'; ?>">
			<i class="fas fa-fw fa-tachometer-alt"></i>
			<span>Vacation Requests</span>
		</a>
	</li>

	<li
		class="nav-item <?php if($this->uri->uri_string() == 'hr/admin/incident-reports' || $this->uri->uri_string() == 'hr/admin/add-incident-report' || $this->uri->segment(3) == 'edit-incident-report') { echo 'active'; } ?>">
		<a class="nav-link" href="<?php echo base_url().'hr/admin/incident-reports'; ?>">
			<i class="fas fa-fw fa-tachometer-alt"></i>
			<span>Report Incident</span>
		</a>
	</li>

	<li
		class="nav-item <?php if($this->uri->uri_string() == 'hr/admin/users' || $this->uri->uri_string() == 'hr/admin/add-user' || $this->uri->segment(3) == 'edit-user' || $this->uri->uri_string() == 'hr/admin/admin-users' || $this->uri->uri_string() == 'hr/admin/add-admin-user' || $this->uri->segment(3) == 'edit-admin-user') { echo 'active'; } ?>">
		<a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#users_menu" aria-expanded="true"
			aria-controls="users_menu">
			<i class="fas fa-fw fa-wrench"></i>
			<span>Users</span>
		</a>
		<div id="users_menu" class="collapse" aria-labelledby="users_menu" data-parent="#accordionSidebar">
			<div class="bg-white py-2 collapse-inner rounded">
				<a class="collapse-item <?php if($this->uri->uri_string() == 'hr/admin/users' || $this->uri->uri_string() == 'hr/admin/add-user' || $this->uri->segment(3) == 'edit-user') { echo 'active'; } ?>"
					href="<?php echo base_url().'hr/admin/users'; ?>">Employees</a>
				<a class="collapse-item <?php if($this->uri->uri_string() == 'hr/admin/admin-users' || $this->uri->uri_string() == 'hr/admin/add-admin-user' || $this->uri->segment(3) == 'edit-admin-user') { echo 'active'; } ?>"
					href="<?php echo base_url().'hr/admin/admin-users'; ?>">Admin Users</a>

			</div>
		</div>
	</li>

	<!-- Divider -->
	<hr class="sidebar-divider d-none d-md-block">

	<!-- Sidebar Toggler (Sidebar) -->
	<div class="text-center d-none d-md-inline">
		<button class="rounded-circle border-0" id="sidebarToggle"></button>
	</div>

</ul>
<!-- End of Sidebar -->
