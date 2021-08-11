<div class="sidebar">     
	<div class="sidebar-wrapper">
		<div class="logo">
			<a class="simple-text" href="<?php echo base_url().'hr/admin/dashboard'; ?>">
				<img src="<?php echo base_url();?>assets/backend/hr/img/logo2.png">
			</a>
		</div>
		<ul class="nav">
			<li class="nav-item <?php if($this->uri->uri_string() == 'hr/admin/dashboard') { echo 'active'; } ?>">
				<a class="nav-link" href="<?php echo base_url().'hr/admin/dashboard'; ?>">
					<i class="nc-icon nc-chart-pie-35"></i>
					<p>Dashboard</p>
				</a>
			</li>
			<li class="<?php if($this->uri->uri_string() == 'hr/admin/employee' || $this->uri->uri_string() == 'hr/admin/add-employee' || $this->uri->segment(3) == 'edit-employee') { echo 'active'; } ?>">
				<a class="nav-link" href="<?php echo base_url().'hr/admin/employee'; ?>">
					<i class="nc-icon nc-notes"></i>
					<p>Employee</p>
				</a>
			</li>
			<li class="<?php if($this->uri->uri_string() == 'hr/admin/admin-users' || $this->uri->uri_string() == 'hr/admin/add-admin-user' || $this->uri->segment(3) == 'edit-admin-user') { echo 'active'; } ?>">
				<a class="nav-link" href="<?php echo base_url().'hr/admin/admin-users'; ?>">
					<i class="nc-icon nc-notes"></i>
					<p>Admin Users</p>
				</a>
			</li>
		</ul>
	</div>
</div>