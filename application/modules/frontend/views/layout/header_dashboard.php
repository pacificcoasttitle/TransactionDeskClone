<div id="page-preloader"><span class="spinner border-t_second_b border-t_prim_a"></span></div>
<div class="l-theme animated-css" style="height:auto;" data-header="sticky" data-header-top="200" data-canvas="container">
    
    <header class="header header-topbar-hidden header-boxed-width navbar-fixed-top header-background-trans header-color-white header-logo-white header-navibox-1-left header-navibox-2-right header-navibox-3-right header-navibox-4-right">
        <div class="container container-boxed-width">
            <nav class="navbar" id="nav">
                <div class="container">
                    <div class="header-navibox-1">
                        <!-- Mobile Trigger Start-->
                        <button class="menu-mobile-button visible-xs-block js-toggle-mobile-slidebar toggle-menu-button"><i class="toggle-menu-button-icon"><span></span><span></span><span></span><span></span><span></span><span></span></i></button>
                        <!-- Mobile Trigger End-->
                        <a class="navbar-brand scroll" href="<?php echo base_url(); ?>"><img class="normal-logo" src="<?php echo base_url(); ?>assets/media/general/logo2.png" alt="logo"><img class="scroll-logo hidden-xs" src="<?php echo base_url(); ?>assets/media/general/logo2-dark.png" alt="logo"></a>
                    </div>
                    <div class="header-navibox-2">
                        <ul class="yamm nav navbar-nav">
                            <?php if($is_special_lender == 0) { ?>
                                <li><a href="<?php echo base_url(); ?>dashboard">Dashboard Home</a></li>
                                <li><a href="<?php echo base_url().'order'; ?>">Open Order</a></li>
                                <li><a href="<?php echo base_url().'cpl-dashboard'; ?>">Generate CPL</a></li>
                                <li><a href="<?php echo base_url().'proposed-insured'; ?>">Proposed Insured</a></li>
                                <!-- <li><a href="<?php // echo base_url().'prelim-files'; ?>">Review Prelims</a></li> -->
                                <li><a href="<?php echo base_url().'logout'; ?>">Logout</a></li>    
                            <?php } else { ?>
                                <li><a href="<?php echo base_url().'special-dashboard/logout'; ?>">Logout</a></li>    
                            <?php } ?>
                        </ul>
                    </div>
                </div>
            </nav>
        </div>
    </header>

    <div class="section-title-page7q area-bg area-bg_blue area-bg_op_60 parallax">
        <div class="area-bg__inner">
            <div class="container">
                <div class="row">
                    <div class="col-xs-12">
                        <h1 class="b-title-page"></h1>
                        <div class="b-title-page__info"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
        