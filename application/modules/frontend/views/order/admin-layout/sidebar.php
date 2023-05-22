<?php $userdata = $this->session->userdata('hr_admin');?>
<!-- Sidebar -->
<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

	<!-- Sidebar - Brand -->
	<a class="sidebar-brand d-flex align-items-center justify-content-center"
		href="<?php echo base_url().'order/admin/dashboard'; ?>">
		<img style="width:200px;" src="<?php echo base_url();?>assets/backend/hr/img/logo2.png">
	</a>

	<!-- Divider -->
	<hr class="sidebar-divider my-0">
    <?php
        $userdata = $this->session->userdata('user');
		if($role_id != 3):
	?>
	<li class="nav-item <?php if($this->uri->segment(2) == 'sales-dashboard') { echo 'active'; } ?>">
		<a class="nav-link" href="<?php echo base_url(); ?>sales-dashboard/<?php echo $userdata['id']; ?>">
			<i class="fas fa fa-dashboard"></i>
			<span>Dashboard</span>
		</a>
	</li>
    <li class="nav-item <?php if($this->uri->uri_string() == 'sales-current-month-history') { echo 'active'; } ?>">
		<a class="nav-link" href="<?php echo base_url(); ?>sales-current-month-history">
			<i class="fas fa fa-calendar  "></i>
			<span>Daily</span>
		</a>
	</li>
    <li class="nav-item <?php if($this->uri->segment(2) == 'sales-current-month-history') { echo 'active'; } ?>">
		<a class="nav-link" href="<?php echo base_url(); ?>sales-production-history/<?php echo $userdata['id']; ?>">
			<i class="fas fa fa-history"></i>
			<span>Production History</span>
		</a>
	</li>
    <li class="nav-item <?php if($this->uri->segment(2) == 'trends') { echo 'active'; } ?>">
		<a class="nav-link" href="<?php echo base_url(); ?>trends/<?php echo $userdata['id']; ?>">
            <i class="fa fa-line-chart"></i>
			<span>Trends</span>
		</a>
	</li>
    <li class="nav-item <?php if($this->uri->segment(2) == 'sales-summary') { echo 'active'; } ?>">
		<a class="nav-link" href="<?php echo base_url(); ?>sales-summary/<?php echo $userdata['id']; ?>">
			<i class="fa fa-list-alt"></i>
			<span>Summary</span>
		</a>
	</li>
    <?php endif; ?>
	

	<!-- Divider -->
	<hr class="sidebar-divider d-none d-md-block">

	<!-- Sidebar Toggler (Sidebar) -->
	<div class="text-center d-none d-md-inline">
		<button class="rounded-circle border-0" id="sidebarToggle"></button>
	</div>

</ul>
<!-- End of Sidebar -->
