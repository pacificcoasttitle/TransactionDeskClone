<ul class="sidebar navbar-nav">
	<li class="nav-item <?php if($this->uri->uri_string() == 'order/admin/dashboard' || $this->uri->uri_string() == 'order/admin/import') { echo 'active'; } ?>">
		<a class="nav-link" href="<?php echo base_url().'order/admin/dashboard'; ?>">
			<i class="fas fa-fw fa-users"></i>
			<span>Escrow</span>
		</a>
	</li>
	<li
		class="nav-item <?php if($this->uri->uri_string() == 'order/admin/agents' || $this->uri->uri_string() == 'order/admin/import-agents' || $this->uri->segment(3) == 'edit-agent') { echo 'active'; } ?>">
		<a class="nav-link" href="<?php echo base_url().'order/admin/agents'; ?>">
			<i class="fas fa-fw fa-users"></i>
			<span>Agents</span></a>
	</li>
	<li
		class="nav-item <?php if($this->uri->uri_string() == 'order/admin/lenders' || $this->uri->uri_string() == 'order/admin/import-lenders' || $this->uri->segment(3) == 'edit-lender') { echo 'active'; } ?>">
		<a class="nav-link" href="<?php echo base_url().'order/admin/lenders'; ?>">
			<i class="fas fa-fw fa-users"></i>
			<span>Lenders</span></a>
	</li>
	<li
		class="nav-item <?php if($this->uri->uri_string() == 'order/admin/sales-rep' || $this->uri->uri_string() == 'order/admin/add-sales-rep' || $this->uri->segment(3) == 'edit-sales-rep') { echo 'active'; } ?>">
		<a class="nav-link" href="<?php echo base_url().'order/admin/sales-rep'; ?>">
			<i class="fas fa-fw fa-users"></i>
			<span>Sales Rep.</span></a>
	</li>
	<li
		class="nav-item <?php if($this->uri->uri_string() == 'order/admin/title-officers' || $this->uri->uri_string() == 'order/admin/add-title-officer' || $this->uri->segment(3) == 'edit-title-officer') { echo 'active'; } ?>">
		<a class="nav-link" href="<?php echo base_url().'order/admin/title-officers'; ?>">
			<i class="fas fa-fw fa-users"></i>
			<span>Title Officer</span></a>
	</li>

	<li
		class="nav-item <?php if($this->uri->uri_string() == 'order/admin/credentials-check') { echo 'active'; } ?>">
		<a class="nav-link" href="<?php echo base_url().'order/admin/credentials-check'; ?>">
			<i class="fas fa-fw fa-check"></i>
			<span>Credentials Check</span></a>
	</li>

	<li
		class="nav-item <?php if($this->uri->uri_string() == 'order/admin/lv-log') { echo 'active'; } ?>">
		<a class="nav-link" href="<?php echo base_url().'order/admin/lv-log'; ?>">
			<i class="fas fa-fw fa-list"></i>
			<span>LV Log</span></a>
	</li>
</ul>
