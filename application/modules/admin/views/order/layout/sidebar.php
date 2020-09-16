<ul class="sidebar navbar-nav">
	<li class="nav-item <?php if($this->uri->uri_string() == 'order/admin/dashboard' || $this->uri->segment(3) == 'order-details') { echo 'active'; } ?>">
		<a class="nav-link" href="<?php echo base_url().'order/admin/dashboard'; ?>">
			<i class="fas fa fa-dashboard"></i>
			<span>Dashboard</span>
		</a>
	</li>

	<li class="nav-item <?php if($this->uri->uri_string() == 'order/admin/orders' || $this->uri->segment(3) == 'order-details' || $this->uri->segment(4) == 'loan' || $this->uri->segment(4) == 'sale') { echo 'active'; } ?>">
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
			<a class="dropdown-item <?php if($this->uri->uri_string() == 'order/admin/escrow' || $this->uri->uri_string() == 'order/admin/import') { echo 'active'; } ?>" href="<?php echo base_url().'order/admin/escrow'; ?>">Escrow</a>
			<a class="dropdown-item <?php if($this->uri->uri_string() == 'order/admin/agents' || $this->uri->uri_string() == 'order/admin/import-agents' || $this->uri->segment(3) == 'edit-agent') { echo 'active'; } ?>" href="<?php echo base_url().'order/admin/agents'; ?>">Agents</a>
			<a class="dropdown-item <?php if($this->uri->uri_string() == 'order/admin/lenders' || $this->uri->uri_string() == 'order/admin/import-lenders' || $this->uri->segment(3) == 'edit-lender') { echo 'active'; } ?>" href="<?php echo base_url().'order/admin/lenders'; ?>">Lenders</a>
			<a class="dropdown-item <?php if($this->uri->uri_string() == 'order/admin/sales-rep' || $this->uri->uri_string() == 'order/admin/add-sales-rep' || $this->uri->segment(3) == 'edit-sales-rep') { echo 'active'; } ?>" href="<?php echo base_url().'order/admin/sales-rep'; ?>">Sales Rep.</a>
			<a class="dropdown-item <?php if($this->uri->uri_string() == 'order/admin/title-officers' || $this->uri->uri_string() == 'order/admin/add-title-officer' || $this->uri->segment(3) == 'edit-title-officer') { echo 'active'; } ?>" href="<?php echo base_url().'order/admin/title-officers'; ?>">Title Officer</a>
			<a class="dropdown-item <?php if($this->uri->uri_string() == 'order/admin/new-users' || $this->uri->uri_string() == 'order/admin/add-new-user') { echo 'active'; } ?>" href="<?php echo base_url().'order/admin/new-users'; ?>">New Users</a>
			<a class="dropdown-item <?php if($this->uri->uri_string() == 'order/admin/master-users' || $this->uri->uri_string() == 'order/admin/add-new-master-user') { echo 'active'; } ?>" href="<?php echo base_url().'order/admin/master-users'; ?>">Master Users</a>
			<a class="dropdown-item <?php if($this->uri->uri_string() == 'order/admin/companies' || $this->uri->uri_string() == 'order/admin/add-company') { echo 'active'; } ?>" href="<?php echo base_url().'order/admin/companies'; ?>">Companies</a>
			<a class="dropdown-item <?php if($this->uri->uri_string() == 'order/admin/incorrect-users') { echo 'active'; } ?>" href="<?php echo base_url().'order/admin/incorrect-users'; ?>">Incorrect Users</a>
        </div>
	</li>
	
	<li class="nav-item <?php if($this->uri->uri_string() == 'order/admin/credentials-check') { echo 'active'; } ?>">
		<a class="nav-link" href="<?php echo base_url().'order/admin/credentials-check'; ?>">
			<i class="fas fa-fw fa-check"></i>
			<span>Credentials Check</span>
		</a>
	</li>

	<li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id=logsDropDown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
			<i class="fas fa-fw fa-file"></i>
			<span>Logs</span>
        </a>
		<div class="dropdown-menu" aria-labelledby=logsDropDown" id="logs">
			<a class="dropdown-item <?php if($this->uri->uri_string() == 'order/admin/lv-log') { echo 'active'; } ?>" href="<?php echo base_url().'order/admin/lv-log'; ?>">Legal Vesting</a>
			<a class="dropdown-item <?php if($this->uri->uri_string() == 'order/admin/grant-deed-log') { echo 'active'; } ?>" href="<?php echo base_url().'order/admin/grant-deed-log'; ?>">Grant Deed</a>
			<a class="dropdown-item <?php if($this->uri->uri_string() == 'order/admin/tax-log') { echo 'active'; } ?>" href="<?php echo base_url().'order/admin/tax-log'; ?>">Tax</a>

			<a class="dropdown-item <?php if($this->uri->uri_string() == 'order/admin/partner-api-log') { echo 'active'; } ?>" href="<?php echo base_url().'order/admin/partner-api-log'; ?>">Partner Api</a>
        </div>
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
			<a class="dropdown-item <?php if($this->uri->uri_string() == 'order/admin/tax-documents') { echo 'active'; } ?>" href="<?php echo base_url().'order/admin/tax-documents'; ?>">Tax</a>
			<a class="dropdown-item <?php if($this->uri->uri_string() == 'order/admin/curative-documents') { echo 'active'; } ?>" href="<?php echo base_url().'order/admin/curative-documents'; ?>">Curative</a>
        </div>
	</li>

	<li class="nav-item <?php if($this->uri->uri_string() == 'order/admin/primary-check') { echo 'active'; } ?>">
		<a class="nav-link" href="<?php echo base_url().'order/admin/primary-check'; ?>">
			<i class="fas fa-fw fa-list"></i>
			<span>Primary Accounts</span>
		</a>
	</li>

	<li class="nav-item <?php if($this->uri->uri_string() == 'order/admin/fees' || $this->uri->segment(3) == 'add-fee' || $this->uri->segment(3) == 'edit-fee') { echo 'active'; } ?>">
		<a class="nav-link" href="<?php echo base_url().'order/admin/fees'; ?>">
			<i class="fa fa-money"></i>
			<span>Fees</span>
		</a>
	</li>

	<li class="nav-item <?php if($this->uri->uri_string() == 'order/admin/fees-types' || $this->uri->segment(3) == 'add-fee-type' || $this->uri->segment(3) == 'edit-fee-type') { echo 'active'; } ?>">
		<a class="nav-link" href="<?php echo base_url().'order/admin/fees-types'; ?>">
			<i class="fa fa-money"></i>
			<span>Fees Types</span>
		</a>
	</li>
	
	<li class="nav-item <?php if($this->uri->uri_string() == 'order/admin/code-book' || $this->uri->uri_string() == 'order/admin/import-code-book') { echo 'active'; } ?>">
		<a class="nav-link" href="<?php echo base_url().'order/admin/code-book'; ?>">
			<i class="fa fa-code"></i>
			<span>Code Book</span>
		</a>
	</li>
</ul>
