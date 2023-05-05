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
		if($role_id != 3):
	?>
	<li class="nav-item <?php if($this->uri->uri_string() == 'order/admin/dashboard' || $this->uri->segment(3) == 'order-details') { echo 'active'; } ?>">
		<a class="nav-link" href="<?php echo base_url().'order/admin/dashboard'; ?>">
			<i class="fas fa fa-dashboard"></i>
			<span>Dashboard</span>
		</a>
	</li>
    <?php endif; ?>
	<?php if($userdata['user_type_id'] == 4 && $userdata['department_id'] == 4) : ?>
		<li class="nav-item <?php if($this->uri->uri_string() == 'hr/admin/orders' || $this->uri->segment(3) == 'order-tasks') { echo 'active'; } ?>">
			<a class="nav-link" href="<?php echo base_url().'hr/admin/orders'; ?>">
				<i class="fas fa-list"></i>
				<span>Orders</span>
			</a>
		</li>
	<?php endif; ?>
    
    <li class="nav-item dropdown">
		<a class="nav-link dropdown-toggle" href="#" id="ordersDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
			<i class="fas fa-fw fa-list"></i>
			<span>Orders</span>
        </a>
        <div class="dropdown-menu" aria-labelledby="ordersDropdown" id="ordersDropdown_list">
        	<a class="dropdown-item <?php if($this->uri->uri_string() == 'order/admin/orders' || $this->uri->segment(3) == 'order-details' || $this->uri->segment(4) == 'loan' || $this->uri->segment(4) == 'sale') { echo 'active'; } ?>" href="<?php echo base_url().'order/admin/orders'; ?>">
				Orders
			</a>
			<?php
				if($role_id != 3):
			?>
			<a class="dropdown-item <?php if($this->uri->uri_string() == 'order/admin/lp-orders') { echo 'active'; } ?>" href="<?php echo base_url().'order/admin/lp-orders'; ?>">
				LP Orders
			</a> 
			
			<?php endif; ?>
        </div>
	</li>
    
    <?php
		if($role_id != 3):
	?>
	<li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="usersDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
			<i class="fas fa-fw fa-users"></i>
			<span>Users</span>
        </a>
		<div class="dropdown-menu" aria-labelledby="usersDropdown" id="users">
			<?php if($role_id == 1) : ?>
			<a class="dropdown-item <?php if($this->uri->uri_string() == 'order/admin/admin_users' ) { echo 'active'; } ?>" href="<?php echo base_url().'order/admin/admin_users'; ?>">Admin</a>
			<?php endif; ?>
			<a class="dropdown-item <?php if($this->uri->uri_string() == 'order/admin/escrow' || $this->uri->uri_string() == 'order/admin/import') { echo 'active'; } ?>" href="<?php echo base_url().'order/admin/escrow'; ?>">Escrow</a>
			<a class="dropdown-item <?php if($this->uri->uri_string() == 'order/admin/agents' || $this->uri->uri_string() == 'order/admin/import-agents' || $this->uri->segment(3) == 'edit-agent') { echo 'active'; } ?>" href="<?php echo base_url().'order/admin/agents'; ?>">Agents</a>
			<a class="dropdown-item <?php if($this->uri->uri_string() == 'order/admin/lenders' || $this->uri->uri_string() == 'order/admin/import-lenders' || $this->uri->segment(3) == 'edit-lender') { echo 'active'; } ?>" href="<?php echo base_url().'order/admin/lenders'; ?>">Lenders</a>
			<a class="dropdown-item <?php if($this->uri->uri_string() == 'order/admin/mortgage-brokers') { echo 'active'; } ?>" href="<?php echo base_url().'order/admin/mortgage-brokers'; ?>">Mortgage Brokers</a>
			
			<a class="dropdown-item <?php if($this->uri->uri_string() == 'order/admin/sales-rep' || $this->uri->uri_string() == 'order/admin/add-sales-rep' || $this->uri->segment(3) == 'edit-sales-rep') { echo 'active'; } ?>" href="<?php echo base_url().'order/admin/sales-rep'; ?>">Sales Rep.</a>
			
			<a class="dropdown-item <?php if($this->uri->uri_string() == 'order/admin/title-officers' || $this->uri->uri_string() == 'order/admin/add-title-officer' || $this->uri->segment(3) == 'edit-title-officer') { echo 'active'; } ?>" href="<?php echo base_url().'order/admin/title-officers'; ?>">Title Officer</a>
			<a class="dropdown-item <?php if($this->uri->uri_string() == 'order/admin/new-users' || $this->uri->uri_string() == 'order/admin/add-new-user') { echo 'active'; } ?>" href="<?php echo base_url().'order/admin/new-users'; ?>">New Users</a>
			<a class="dropdown-item <?php if($this->uri->uri_string() == 'order/admin/master-users' || $this->uri->uri_string() == 'order/admin/add-new-master-user' || $this->uri->segment(3) == 'edit-master-user') { echo 'active'; } ?>" href="<?php echo base_url().'order/admin/master-users'; ?>">Master Users</a>
			<a class="dropdown-item <?php if($this->uri->uri_string() == 'order/admin/companies' || $this->uri->uri_string() == 'order/admin/add-company') { echo 'active'; } ?>" href="<?php echo base_url().'order/admin/companies'; ?>">Companies</a>
			<a class="dropdown-item <?php if($this->uri->uri_string() == 'order/admin/incorrect-users') { echo 'active'; } ?>" href="<?php echo base_url().'order/admin/incorrect-users'; ?>">Incorrect Users</a>
			<a class="dropdown-item <?php if($this->uri->uri_string() == 'order/admin/cpl-proposed-users' || $this->uri->segment(3) == 'edit-cpl-proposed-user') { echo 'active'; } ?>" href="<?php echo base_url().'order/admin/cpl-proposed-users'; ?>">CPL/Proposed Users</a>
			<a class="dropdown-item <?php if($this->uri->uri_string() == 'order/admin/escrow-officers' || $this->uri->segment(3) == 'edit-escrow-officer' || $this->uri->segment(3) == 'add-escrow-officer') { echo 'active'; } ?>" href="<?php echo base_url().'order/admin/escrow-officers'; ?>">Escrow Officers</a>
        </div>
	</li>

	<li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="logsDropDown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
			<i class="fas fa-fw fa-book"></i>
			<span>Logs</span>
        </a>
		<div class="dropdown-menu" aria-labelledby="logsDropDown" id="logs">
			<a class="dropdown-item <?php if($this->uri->uri_string() == 'order/admin/lv-log') { echo 'active'; } ?>" href="<?php echo base_url().'order/admin/lv-log'; ?>">Legal Vesting</a>
			<a class="dropdown-item <?php if($this->uri->uri_string() == 'order/admin/pre-listing') { echo 'active'; } ?>" href="<?php echo base_url().'order/admin/pre-listing'; ?>">Pre Listing</a>
			<a class="dropdown-item <?php if($this->uri->uri_string() == 'order/admin/grant-deed-log') { echo 'active'; } ?>" href="<?php echo base_url().'order/admin/grant-deed-log'; ?>">Grant Deed</a>
			<a class="dropdown-item <?php if($this->uri->uri_string() == 'order/admin/tax-log') { echo 'active'; } ?>" href="<?php echo base_url().'order/admin/tax-log'; ?>">Tax</a>
			<a class="dropdown-item <?php if($this->uri->uri_string() == 'order/admin/partner-api-log') { echo 'active'; } ?>" href="<?php echo base_url().'order/admin/partner-api-log'; ?>">Partner Api</a>
			<a class="dropdown-item <?php if($this->uri->uri_string() == 'order/admin/cpl-error-logs') { echo 'active'; } ?>" href="<?php echo base_url().'order/admin/cpl-error-logs'; ?>">CPL Error</a>
			<a class="dropdown-item <?php if($this->uri->uri_string() == 'order/admin/lp-xml-logs') { echo 'active'; } ?>" href="<?php echo base_url().'order/admin/lp-xml-logs'; ?>">LP Xml</a>
			<?php if($role_id == 1) : ?>
				<a class="dropdown-item <?php if($this->uri->uri_string() == 'order/admin/admin-user-logs' ) { echo 'active'; } ?>" href="<?php echo base_url().'order/admin/admin-user-logs'; ?>">Admin User</a>
			<?php endif; ?>
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
			<a class="dropdown-item <?php if($this->uri->uri_string() == 'order/admin/file-documents') { echo 'active'; } ?>" href="<?php echo base_url().'order/admin/file-documents'; ?>">Forms</a>
			<!-- <a class="dropdown-item <?php if($this->uri->uri_string() == 'order/admin/pre-listing-documents') { echo 'active'; } ?>" href="<?php echo base_url().'order/admin/pre-listing-documents'; ?>">Pre Listing</a>
			<a class="dropdown-item <?php if($this->uri->uri_string() == 'order/admin/lp-listing-documents') { echo 'active'; } ?>" href="<?php echo base_url().'order/admin/lp-listing-documents'; ?>">LP Listing</a> -->
        </div>
	</li>

	<li class="nav-item dropdown">
		<a class="nav-link dropdown-toggle" href="#" id="cpl_branches" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
			<i class="fas fa-fw fa-sitemap"></i>
			<span>Branches</span>
        </a>
		<div class="dropdown-menu" aria-labelledby="cpl_branches" id="cpl_branches_section">
			<a class="dropdown-item <?php if($this->uri->uri_string() == 'order/admin/north-american-branches') { echo 'active'; } ?>" href="<?php echo base_url().'order/admin/north-american-branches'; ?>">CPL - North American</a>
			<a class="dropdown-item <?php if($this->uri->uri_string() == 'order/admin/westcor-branches') { echo 'active'; } ?>" href="<?php echo base_url().'order/admin/westcor-branches'; ?>">CPL - Westcor</a>
			<a class="dropdown-item <?php if($this->uri->uri_string() == 'order/admin/commonwealth-branches') { echo 'active'; } ?>" href="<?php echo base_url().'order/admin/commonwealth-branches'; ?>">CPL - Commonwealth</a>
			<a class="dropdown-item <?php if($this->uri->uri_string() == 'order/admin/proposed-branches') { echo 'active'; } ?>" href="<?php echo base_url().'order/admin/proposed-branches'; ?>">Proposed Insured</a>
        </div>
	</li>

	<li class="nav-item dropdown">
		<a class="nav-link dropdown-toggle" href="#" id="li_settings" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
			<i class="fas fa-fw fa-gear"></i>
			<span>Settings</span>
        </a>
        <div class="dropdown-menu" aria-labelledby="li_settings" id="li_settings_list">
			<?php if($role_id == 1) : ?>
				<a class="dropdown-item <?php if($this->uri->uri_string() == 'order/admin/roles') { echo 'active'; } ?>" href="<?php echo base_url().'order/admin/roles'; ?>">
        		User Roles
			</a>
			<?php endif; ?>
        	<a class="dropdown-item <?php if($this->uri->uri_string() == 'order/admin/credentials-check') { echo 'active'; } ?>" href="<?php echo base_url().'order/admin/credentials-check'; ?>">
        		Credentials Check
			</a>
			<a class="dropdown-item <?php if($this->uri->uri_string() == 'order/admin/resware-admin-credential') { echo 'active'; } ?>" href="<?php echo base_url().'order/admin/resware-admin-credential'; ?>">
				Resware Admin
			</a>
			<a class="dropdown-item <?php if($this->uri->uri_string() == 'order/admin/send-password') { echo 'active'; } ?>" href="<?php echo base_url().'order/admin/send-password'; ?>">
				Send Password
			</a>
			<a class="dropdown-item <?php if($this->uri->uri_string() == 'order/admin/primary-check') { echo 'active'; } ?>" href="<?php echo base_url().'order/admin/primary-check'; ?>">
				Primary Accounts
			</a>
			<a class="dropdown-item <?php if($this->uri->uri_string() == 'order/admin/fees-types' || $this->uri->segment(3) == 'add-fee-type' || $this->uri->segment(3) == 'edit-fee-type') { echo 'active'; } ?>" href="<?php echo base_url().'order/admin/fees-types'; ?>">
				Fees Types
			</a>
			<a class="dropdown-item <?php if($this->uri->uri_string() == 'order/admin/fees' || $this->uri->segment(3) == 'add-fee' || $this->uri->segment(3) == 'edit-fee') { echo 'active'; } ?>" href="<?php echo base_url().'order/admin/fees'; ?>">
				Fees
			</a>
			<a class="dropdown-item <?php if($this->uri->uri_string() == 'order/admin/import-orders') { echo 'active'; } ?>" href="<?php echo base_url().'order/admin/code-book'; ?>">
				Code Book
			</a>
			<a class="dropdown-item <?php if($this->uri->uri_string() == 'order/admin/rules-manager') { echo 'active'; } ?>" href="<?php echo base_url().'order/admin/rules-manager'; ?>">
				Rules Manager
			</a>
			<a class="dropdown-item <?php if($this->uri->uri_string() == 'order/admin/notifications') { echo 'active'; } ?>" href="<?php echo base_url().'order/admin/notifications'; ?>">
				Notifications
			</a>
			<a class="dropdown-item <?php if($this->uri->uri_string() == 'order/admin/holidays' || $this->uri->segment(3) == 'add-holiday' || $this->uri->segment(3) == 'edit-holiday') { echo 'active'; } ?>" href="<?php echo base_url().'order/admin/holidays'; ?>">
				Holidays
			</a>
			<a class="dropdown-item <?php if(preg_match('/order\/admin\/([a-z\-])*lp-document-type*/',$this->uri->uri_string())) { echo 'active'; } ?>" href="<?php echo base_url().'order/admin/lp-document-types'; ?>">
				LP Document Types
			</a>
			<a class="dropdown-item <?php if(preg_match('/order\/admin\/([a-z\-])*lp-alert*/',$this->uri->uri_string())) { echo 'active'; } ?>" href="<?php echo base_url().'order/admin/lp-alert'; ?>">
				LP Alert
			</a>
        </div>
	</li>
	<?php 
	if($role_id == 1) : ?>
	<li class="nav-item dropdown">
		<a class="nav-link dropdown-toggle" href="#" id="li_commissions" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
			<i class="fas fa-fw fa-gear"></i>
			<span>Commissions</span>
        </a>
		<div class="dropdown-menu" aria-labelledby="li_commissions" id="li_commissons_list">
			<a class="dropdown-item <?php if(preg_match('/order\/admin\/([a-z\-])*underwriter-tier*/',$this->uri->uri_string())) { echo 'active'; } ?>" href="<?php echo base_url().'order/admin/underwriter-tier'; ?>">
				Underwriter Tier
			</a>
			<a class="dropdown-item <?php if(preg_match('/order\/admin\/([a-z\-])*commission-range*/',$this->uri->uri_string())) { echo 'active'; } ?>" href="<?php echo base_url().'order/admin/commission-range'; ?>">
				Commission Range
			</a>
			<a class="dropdown-item <?php if(preg_match('/order\/admin\/([a-z\-])*commission-file*/',$this->uri->uri_string())) { echo 'active'; } ?>" href="<?php echo base_url().'order/admin/commission-files'; ?>">
				Commission Files
			</a>
			<a class="dropdown-item <?php if(preg_match('/order\/admin\/([a-z\-])*commission-config*/',$this->uri->uri_string())) { echo 'active'; } ?>" href="<?php echo base_url().'order/admin/commission-config'; ?>">
				Escrow Commisison
			</a>
			<a class="dropdown-item <?php if(preg_match('/order\/admin\/([a-z\-])*commission-bonus*/',$this->uri->uri_string())) { echo 'active'; } ?>" href="<?php echo base_url().'order/admin/commission-bonus'; ?>">
				Bonus
			</a>
		</div>
	</li>
	<?php endif; ?>
    <?php endif; ?>


	<!-- Divider -->
	<hr class="sidebar-divider d-none d-md-block">

	<!-- Sidebar Toggler (Sidebar) -->
	<div class="text-center d-none d-md-inline">
		<button class="rounded-circle border-0" id="sidebarToggle"></button>
	</div>

</ul>
<!-- End of Sidebar -->
