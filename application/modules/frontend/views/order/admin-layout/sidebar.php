<?php $userdata = $this->session->userdata('hr_admin');?>
<!-- Sidebar -->
<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">
    <?php
        $userdata = $this->session->userdata('user');
		
	?>

	<!-- Sidebar - Brand -->
	<a class="sidebar-brand d-flex align-items-center justify-content-center"
		href="<?php echo base_url(); ?>sales-dashboard/<?php echo $userdata['id']; ?>">
		<img style="width:200px;" src="<?php echo base_url();?>assets/backend/hr/img/logo2.png">
	</a>

	<!-- Divider -->
	<hr class="sidebar-divider my-0">
	<li class="nav-item <?php if($this->uri->segment(1) == 'sales-dashboard') { echo 'active'; } ?>">
		<a class="nav-link" href="<?php echo base_url(); ?>sales-dashboard/<?php echo $userdata['id']; ?>">
			<i class="fas fa fa-dashboard"></i>
			<span>Dashboard</span>
		</a>
	</li>
    <li class="nav-item <?php if($this->uri->uri_string(1) == 'sales-current-month-history') { echo 'active'; } ?>">
		<a class="nav-link" href="<?php echo base_url(); ?>sales-current-month-history">
			<i class="fas fa fa-calendar  "></i>
			<span>Daily</span>
		</a>
	</li>
    <li class="nav-item <?php if($this->uri->segment(1) == 'sales-production-history') { echo 'active'; } ?>">
		<a class="nav-link" href="<?php echo base_url(); ?>sales-production-history/<?php echo $userdata['id']; ?>">
			<i class="fas fa fa-history"></i>
			<span>Production History</span>
		</a>
	</li>
    <li class="nav-item <?php if($this->uri->segment(1) == 'trends') { echo 'active'; } ?>">
		<a class="nav-link" href="<?php echo base_url(); ?>trends/<?php echo $userdata['id']; ?>">
            <i class="fa fa-line-chart"></i>
			<span>Trends</span>
		</a>
	</li>
    <li class="nav-item <?php if($this->uri->segment(1) == 'sales-summary') { echo 'active'; } ?>">
		<a class="nav-link" href="<?php echo base_url(); ?>sales-summary/<?php echo $userdata['id']; ?>">
			<i class="fa fa-list-alt"></i>
			<span>Summary</span>
		</a>
	</li>
    <li class="nav-item <?php if($this->uri->segment(1) == 'logout') { echo 'active'; } ?>">
		<a class="nav-link" href="<?php echo base_url().'logout'; ?>">
			<i class="fa fa-sign-out"></i>
			<span>Logout</span>
		</a>
	</li>
	

	<!-- Divider -->
	<hr class="sidebar-divider d-none d-md-block">

	<!-- Sidebar Toggler (Sidebar) -->
	<div class="text-center d-none d-md-inline">
		<button class="rounded-circle border-0" id="sidebarToggle"></button>
	</div>

</ul>
<!-- End of Sidebar -->
