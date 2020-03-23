
<div id="ext-menu">
                <div class="row">
                    <div class="clearfix text-uppercase top-mega-menu text-center">
                    <?php if ($this->session->userdata('mpuserid')): ?>
                        <div class="col-md-3 col-sm-6"><a href="<?=base_url()?>create-my-profile"><i class="icon-desktop"></i> Create  Portfolio</a></div>
                        <div class="col-md-3 col-sm-6"><a href="<?=base_url()?>uplaod-articles"><i class="icon-upload-alt"></i> Upload</a></div>
                        <div class="col-md-3 col-sm-6"><a href="<?=base_url()?>my-profile"><i class="icon-user"></i> My  Portfolio </a></div>
                        <div class="col-md-3 col-sm-6"><a href="<?=base_url()?>all-profiles"><i class="icon-group"></i> All  Portfolio</a></div>
                    <?php else: ?>
 						<div class="col-md-3 col-sm-6"><a href="<?=base_url()?>login?return=create-my-profile"><i class="icon-desktop"></i> Create  Portfolio </a></div>
                        <div class="col-md-3 col-sm-6"><a href="<?=base_url()?>login?return=uplaod-articles"><i class="icon-upload-alt"></i> Upload</a></div>
                        <div class="col-md-3 col-sm-6"><a href="<?=base_url()?>login?return=my-profile"><i class="icon-user"></i> My  Portfolio</a></div>
                        <div class="col-md-3 col-sm-6"><a href="<?=base_url()?>login?return=all-profiles"><i class="icon-group"></i> All  Portfolio</a></div>

					<?php endif ?>
                    </div>
                    
                </div><?php if($this->session->flashdata('msg'))
                {
                ?>
        
                    <div class='alert alert-success fade-in'>
                        <button data-dismiss='alert' class='close' type='button'>×</button>
                        <strong id = 'success'><?=$this->session->flashdata('msg');?></strong>
                    </div>
                
                <?php } ?>
            </div>