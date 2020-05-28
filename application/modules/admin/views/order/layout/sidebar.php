<ul class="sidebar navbar-nav">

	<li class="nav-item <?php if($this->uri->uri_string() == 'dashboard') { echo 'active'; } ?>">
		<a class="nav-link" href="<?php echo base_url().'order/admin/dashboard'; ?>">
			<i class="fas fa-fw fa-users"></i>
			<span>Escrow</span>
		</a>
	</li>
	<li
		class="nav-item <?php if($this->uri->uri_string() == 'agents' || $this->uri->uri_string() == 'import-agents' || $this->uri->segment(1) == 'edit-agent') { echo 'active'; } ?>">
		<a class="nav-link" href="<?php echo base_url().'order/admin/agents'; ?>">
			<i class="fas fa-fw fa-users"></i>
			<span>Agents</span></a>
	</li>
	<li
		class="nav-item <?php if($this->uri->uri_string() == 'agents' || $this->uri->uri_string() == 'import-agents' || $this->uri->segment(1) == 'edit-agent') { echo 'active'; } ?>">
		<a class="nav-link" href="<?php echo base_url().'order/admin/lenders'; ?>">
			<i class="fas fa-fw fa-users"></i>
			<span>Lenders</span></a>
	</li>
</ul>
