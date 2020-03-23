<div class="navbar-collapse sidebar-navbar-collapse collapse" aria-expanded="true">
                                <ul class="nav navbar-nav" id="sidenav01">
                                  <li class="sideBarHeading">
                                    <h4>Dashboard</h4>
                                  </li>
                                  <!-- <li><a data-toggle="collapse" data-target="#toggleDemo" data-parent="#sidenav01" class="collapsed" href="<?=base_url()?>my-work"><i class="icon-file"></i>My Work</a></li>
                                   --><li><a <?php if($active=="my_account"){?> class="active" <?php }?>href="<?=base_url()?>uploaded-articles"><i class="icon-check"></i>Uploaded</a></li>
                                  <li><a <?php if($active=="downloaded"){?> class="active" <?php }?>href="<?=base_url()?>downloaded-articles"><i class="icon-download"></i>Downloaded</a></li>
                                  <li><a <?php if($active=="purchased"){?> class="active" <?php }?> href="<?=base_url()?>purchased-articles"><i class="icon-file-text"></i>Articles Purchased</a></li>
                                  <li><a <?php if($active=="saved"){?> class="active" <?php }?> href="<?=base_url()?>saved-articles"><i class="icon-save"></i>Saved Articles</a></li>
                                  <li><a <?php if($active=="edit-profile"){?> class="active" <?php }?> href="<?=base_url()?>edit-profile"><i class="icon-pencil"></i>Edit Profile</a></li>
                                  <li><a <?php if($active=="edit-bank-profile"){?> class="active" <?php }?> href="<?=base_url()?>edit-bank-profile"><i class="icon-building"></i>Bank Details</a></li>
                                  <li><a <?php if($active=="change-password"){?> class="active" <?php }?> href="<?=base_url()?>change-password"><i class="icon-credit-card"></i>Change Password</a></li>
                                  <li><a <?php if($active=="contact"){?> class="active" <?php }?> href="<?=base_url()?>contact"><i class="icon-envelope"></i>Contact Admin</a></li>
                                  <li><a <?php if($active=="support"){?> class="active" <?php }?> href="<?=base_url()?>support"><i class="icon-edit"></i>Support</a></li>
                                  <li><a <?php if($active=="logout"){?> class="active" <?php }?> href="<?=base_url()?>login"><i class="icon-power-off"></i>Logout</a></li>
                                </ul>
                              </div>