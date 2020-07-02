<ul class="sidebar navbar-nav">
	<li class="nav-item <?php if($this->uri->uri_string() == 'order/admin/orders' || $this->uri->segment(3) == 'order-details') { echo 'active'; } ?>">
		<a class="nav-link" href="<?php echo base_url().'order/admin/orders'; ?>">
			<i class="fas fa-fw fa-list"></i>
			<span>Orders</span>
		</a>
	</li>

	<li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="usersDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
			<i class="fas fa-fw fa-users"></i>
			<span>Users</span>
        </a>
		<div class="dropdown-menu" aria-labelledby="usersDropdown" id="users">
			<a class="dropdown-item <?php if($this->uri->uri_string() == 'order/admin/dashboard' || $this->uri->uri_string() == 'order/admin/import') { echo 'active'; } ?>" href="<?php echo base_url().'order/admin/dashboard'; ?>">Escrow</a>
			<a class="dropdown-item <?php if($this->uri->uri_string() == 'order/admin/agents' || $this->uri->uri_string() == 'order/admin/import-agents' || $this->uri->segment(3) == 'edit-agent') { echo 'active'; } ?>" href="<?php echo base_url().'order/admin/agents'; ?>">Agents</a>
			<a class="dropdown-item <?php if($this->uri->uri_string() == 'order/admin/lenders' || $this->uri->uri_string() == 'order/admin/import-lenders' || $this->uri->segment(3) == 'edit-lender') { echo 'active'; } ?>" href="<?php echo base_url().'order/admin/lenders'; ?>">Lenders</a>
			<a class="dropdown-item <?php if($this->uri->uri_string() == 'order/admin/sales-rep' || $this->uri->uri_string() == 'order/admin/add-sales-rep' || $this->uri->segment(3) == 'edit-sales-rep') { echo 'active'; } ?>" href="<?php echo base_url().'order/admin/sales-rep'; ?>">Sales Rep.</a>
			<a class="dropdown-item <?php if($this->uri->uri_string() == 'order/admin/title-officers' || $this->uri->uri_string() == 'order/admin/add-title-officer' || $this->uri->segment(3) == 'edit-title-officer') { echo 'active'; } ?>" href="<?php echo base_url().'order/admin/title-officers'; ?>">Title Officer</a>
			<a class="dropdown-item <?php if($this->uri->uri_string() == 'order/admin/new-users' || $this->uri->uri_string() == 'order/admin/add-new-user') { echo 'active'; } ?>" href="<?php echo base_url().'order/admin/new-users'; ?>">New Users</a>
        </div>
	</li>
	
	<li class="nav-item <?php if($this->uri->uri_string() == 'order/admin/credentials-check') { echo 'active'; } ?>">
		<a class="nav-link" href="<?php echo base_url().'order/admin/credentials-check'; ?>">
			<i class="fas fa-fw fa-check"></i>
			<span>Credentials Check</span>
		</a>
	</li>

	<li class="nav-item <?php if($this->uri->uri_string() == 'order/admin/lv-log') { echo 'active'; } ?>">
		<a class="nav-link" href="<?php echo base_url().'order/admin/lv-log'; ?>">
			<i class="fas fa-fw fa-list"></i>
			<span>LV Log</span>
		</a>
	</li>

	<li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="documentDropDown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
			<i class="fas fa-fw fa-file"></i>
			<span>Documents</span>
        </a>
		<div class="dropdown-menu" aria-labelledby="documentDropDown" id="documents">
			<a class="dropdown-item <?php if($this->uri->uri_string() == 'order/admin/cpl-documents') { echo 'active'; } ?>" href="<?php echo base_url().'order/admin/cpl-documents'; ?>">CPL</a>
			<a class="dropdown-item <?php if($this->uri->uri_string() == 'order/admin/grant-deed-documents') { echo 'active'; } ?>" href="<?php echo base_url().'order/admin/grant-deed-documents'; ?>">Grant Deed</a>
			<a class="dropdown-item <?php if($this->uri->uri_string() == 'order/admin/lv-documents') { echo 'active'; } ?>" href="<?php echo base_url().'order/admin/lv-documents'; ?>">Legal & Vesting</a>
        </div>
	</li>
</ul>
