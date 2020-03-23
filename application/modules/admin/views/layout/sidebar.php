<ul class="sidebar navbar-nav">

	<li class="nav-item <?php if($this->uri->uri_string() == 'admin/dashboard' || $this->uri->uri_string() == 'admin/import') { echo 'active'; } ?>">
		<a class="nav-link" href="<?php echo base_url().'admin/dashboard'; ?>">
			<i class="fas fa-fw fa-tachometer-alt"></i>
			<span>Dashboard</span>
		</a>
	</li>
	<li
		class="nav-item <?php if($this->uri->uri_string() == 'admin/agents' || $this->uri->uri_string() == 'admin/import-agents' || $this->uri->segment(2) == 'edit-agent') { echo 'active'; } ?>">
		<a class="nav-link" href="<?php echo base_url().'admin/agents'; ?>">
			<i class="fas fa-fw fa-users"></i>
			<span>Agents</span></a>
	</li>
	<li
		class="nav-item <?php if($this->uri->uri_string() == 'admin/lenders' || $this->uri->uri_string() == 'admin/import-lenders' || $this->uri->segment(2) == 'edit-lender') { echo 'active'; } ?>">
		<a class="nav-link" href="<?php echo base_url().'admin/lenders'; ?>">
			<i class="fas fa-fw fa-users"></i>
			<span>Lenders</span></a>
	</li>
</ul>
