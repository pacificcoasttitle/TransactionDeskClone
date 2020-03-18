<ul class="sidebar navbar-nav">
      <li class="nav-item <?php if($this->uri->uri_string() == 'dashboard') { echo 'active'; } ?>">
        <a class="nav-link" href="<?php echo base_url().'admin/dashboard'; ?>">
          <i class="fas fa-fw fa-tachometer-alt"></i>
          <span>Dashboard</span>
        </a>
      </li>
      <li class="nav-item <?php if($this->uri->uri_string() == 'agents' || $this->uri->uri_string() == 'import-agents' || $this->uri->segment(1) == 'edit-agent') { echo 'active'; } ?>">
        <a class="nav-link" href="<?php echo base_url().'admin/agents'; ?>">
          <i class="fas fa-fw fa-users"></i>
          <span>Agents</span></a>
      </li>
    </ul>