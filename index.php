<?php
    include dirname(__FILE__).'/config/config.php';
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Open Order | Pacific Coast Title Company</title>
        <meta charset="utf-8">
        <meta http-equiv="x-ua-compatible" content="ie=edge">
        <meta content="We specialize in Residential, Commercial Title & Escrow Services" name="description">
        <meta content="" name="keywords">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta content="telephone=no" name="format-detection">
        <meta name="HandheldFriendly" content="true">
        <link rel="stylesheet" href="<?php echo BASE_URL; ?>css/custom.css">
        <link rel="stylesheet" href="http://www.pct.com/assets/css/master.css">
        <link rel="icon" href="<?php echo BASE_URL; ?>/images/favicon.ico" type="image/x-icon">
        <link rel="stylesheet" type="text/css"  href="<?php echo BASE_URL; ?>css/smart-forms.css">
        <link rel="stylesheet" type="text/css"  href="<?php echo BASE_URL; ?>css/font-awesome.min.css">
        <link rel="stylesheet" type="text/css" href="<?php echo BASE_URL; ?>css/jquery-ui.css">
        
        <!--[if lte IE 8]>
            <link type="text/css" rel="stylesheet" href="<?php // echo BASE_URL; ?>css/smart-forms-ie8.css">
        <![endif]-->

        <!--[if lt IE 9 ]>
        <script src="/assets/js/separate-js/html5shiv-3.7.2.min.js" type="text/javascript"></script><meta content="no" http-equiv="imagetoolbar">
        <![endif]-->
        <script type="text/javascript" src="<?php echo BASE_URL; ?>js/jquery-1.9.1.min.js"></script>
        <script type="text/javascript" src="<?php echo BASE_URL; ?>js/jquery.form.min.js"></script>
        <script type="text/javascript" src="<?php echo BASE_URL; ?>js/jquery.validate.min.js"></script>
        <script type="text/javascript" src="<?php echo BASE_URL; ?>js/additional-methods.min.js"></script>
        <script type="text/javascript" src="<?php echo BASE_URL; ?>js/smart-form.js"></script>   
        <script type="text/javascript" src="<?php echo BASE_URL; ?>js/en/jquery-cloneya.min.js"></script>
        <!--[if lte IE 9]>
            <script type="text/javascript" src="<?php // echo BASE_URL; ?>js/jquery.placeholder.min.js"></script>
        <![endif]-->
    </head>

    <body class="">
    	<!-- Loader-->
        <div id="page-preloader">
            <span class="spinner border-t_second_b border-t_prim_a"></span>
        </div>
        <!-- Loader end-->

        <div class="l-theme animated-css" data-header="sticky" data-header-top="200" data-canvas="container">
            
            <!-- ==========================-->
            <!-- MOBILE MENU-->
            <!-- ==========================-->
            <div data-off-canvas="mobile-slidebar left overlay">
                <ul class="yamm nav navbar-nav">
                   <li><a href="<?php echo BASE_URL_MAIN; ?>index.html">Home</a></li>
                                   <li class="dropdown"><a class="dropdown-toggle" href="#" data-toggle="dropdown">About Us<b class="caret"></b>
                              <!-- Classic Dropdown--></a>
                                        <ul class="dropdown-menu">
                                             <li><h4>How We Help</h4></li>
    										<li><a href="http://www.pct.com/our-role.html">Our Role in Title</a></li>
    										<li><a href="http://www.pct.com/protecting-you.html">Protecting You</a></li>
    										<li><a href="http://www.pct.com/why-pacific-coast-title.html">Why Pacific Coast Title</a></li>
    										<li><h4>About Us</h4></li>
    										<li><a href="http://www.pct.com/about-us.html">About Our Company</a></li>
    										<li><a href="http://www.pct.com/assets/downloads/PacificCoastTitle-FinancialStrength.pdf">Financial Strength</a></li>
    										<li><a href="http://www.pct.com/join-our-team.html">Join our Team</a></li>
                                            
                                        </ul>
                                    </li>
                                    <li class="dropdown"><a class="dropdown-toggle" href="#" data-toggle="dropdown">Residential<b class="caret"></b>
                              <!-- Classic Dropdown--></a>
                                        <ul class="dropdown-menu">
                                            <li><h4>Our Services</h4></li>
                                            <li><a href="http://www.pct.com/residential-title.html">Residential Title</a></li>
                                            <li><a href="http://www.pct.com/escrow-settlement.html">Escrow Settlement</a></li>
    										 <li><h4>About Title</h4></li>
    										 <li><a href="http://www.pct.com/what-is-title-insurance.html">What Is Title Insurance</a></li>
    										<li><a href="http://www.pct.com/benefits-title-insurance.html">Benefits of Title Insurance</a></li>
    										<li><a href="http://www.pct.com/life-of-title-search.html">Life of a Title Search</a></li>
    										<li><a href="http://www.pct.com/top-10-title-problems.html">Top 10 Title Concerns</a></li>
    										<li><h4>About Escrow</h4></li>
    										<li><a href="http://www.pct.com/what-is-escrow.html">What is Escrow</a></li>
    										<li><a href="http://www.pct.com/life-of-escrow.html">Life of an Escrow</a></li>
    										<li><a href="http://www.pct.com/escrow-terms.html">Escrow Terms</a></li>
                                        </ul>
                                    </li>
    								 <li class="dropdown"><a class="dropdown-toggle" href="#" data-toggle="dropdown">Commercial<b class="caret"></b>
                              <!-- Classic Dropdown--></a>
                                        <ul class="dropdown-menu">
                                           <li><a href="http://www.pct.com/commercial-services.html">Services</a></li>
                                            <li><a href="http://www.pct.com/commercial-expertise.html">Expertise</a></li>
                                            <li><a href="http://www.pct.com/commercial-resources.html">Resources</a></li>
                                        </ul>
                                    </li>
    								
                                    <li class="dropdown"><a class="dropdown-toggle" href="#" data-toggle="dropdown">Agent Resources<b class="caret"></b>
                              <!-- Classic Dropdown--></a>
                                        <ul class="dropdown-menu">
    										 <li><h4>Forms & Flyers</h4></li>
                                            <li><a href="http://www.pct.com/blank-forms.html">Blank Forms</a></li>
    										<li><a href="http://www.pct.com/educational-booklets.html">Educational Booklets</a></li>
    										<li><a href="http://www.pct.com/flyer-center.html">Flyer Center</a></li>
    										 <li class="divider"></li>
    										 <li><h4>Rates & Fees</h4></li>
    										<li><a href="http://www.pct.com/calculator/">Rate Calculator</a></li>
    										<li><a href="http://www.pct.com/calculator/index.php?welcome/signup">Lender Rate Portal</a></li>
    										<li><a href="http://www.pct.com/recording-fees.html">Recording Fees</a></li>
    										<li><a href="http://www.pct.com/assets/downloads/2019-RecordersCalendar.pdf">Recorders Holidays</a></li>
    										<li><a href="http://www.pct.com/assets/downloads/TransferTaxes.pdf">Transfer Tax Info</a></li>
    										<li><a href="http://www.pct.com/rate-book.html">Rate Book</a></li>
    										 <li class="divider"></li>
    										  <li><h4>Tools & Video</h4></li>
    										<li class="dropdown"><a class="dropdown-toggle" href="#" data-toggle="dropdown">Agent Tools<b style="color:#d35411;" class="caret"></b>
                              <!-- Classic Dropdown--></a>
    										<ul class="dropdown-menu">
    										
                                            <li><a href="http://www.pacificcoastagent.com/">Pacific Coast Agent</a></li>
    										<li><a href="https://www.pcttitletoolbox.com/#!/">PCT Title Toolbox</a></li>
    										<li><a href="#">Instant Profile</a></li>
    										
    										
    										 </ul>
                                    </li>
    								<li><a href="http://www.pct.com/training-center.html">Training center</a></li>
                                        </ul>
    									
                                    </li>
                                    <li class="dropdown"><a class="dropdown-toggle" href="contact.html" data-toggle="dropdown">Contact<b class="caret"></b>
                              <!-- Classic Dropdown--></a>
                                        <ul class="dropdown-menu">
    									
                                            <li><a href="http://www.pct.com/downey.html">Downey</a></li>
                                            <li><a href="http://www.pct.com/glendale.html">Glendale</a></li>
                                            <li><a href="http://www.pct.com/orange.html">Orange</a></li>
    										<li><a href="http://www.pct.com/oxnard.html">Oxnard</a></li>
                                            <li><a href="http://www.pct.com/sandiego.html">San Diego</a></li>
                                            
                                        </ul>
                                    </li>
                </ul>
                </ul>
            </div>
            <!-- ==========================-->
            <!-- FULL SCREEN MENU-->
            <!-- ==========================-->
          

            <header class="header header-topbar-hidden header-boxed-width navbar-fixed-top header-background-trans header-color-white header-logo-white header-navibox-1-left header-navibox-2-right header-navibox-3-right header-navibox-4-right">
                <div class="container container-boxed-width">
                    
                    <nav class="navbar" id="nav">
                        <div class="container">
                            <div class="header-navibox-1">
                                <!-- Mobile Trigger Start-->
                                <button class="menu-mobile-button visible-xs-block js-toggle-mobile-slidebar toggle-menu-button"><i class="toggle-menu-button-icon"><span></span><span></span><span></span><span></span><span></span><span></span></i></button>
                                <!-- Mobile Trigger End-->
                                <a class="navbar-brand scroll" href="<?php echo BASE_URL_MAIN; ?>index.html"><img class="normal-logo" src="http://www.pct.com/assets/media/general/logo2.png" alt="logo"><img class="scroll-logo hidden-xs" src="http://www.pct.com/assets/media/general/logo2-dark.png" alt="logo"></a>
                            </div>
                            <div class="header-navibox-2">
                                <ul class="yamm main-menu nav navbar-nav">
                                    <li><a href="<?php echo BASE_URL_MAIN; ?>index.html">Home</a></li>
                                   <li class="dropdown"><a class="dropdown-toggle" href="#" data-toggle="dropdown">About Us<b class="caret"></b>
                              <!-- Classic Dropdown--></a>
                                        <ul class="dropdown-menu">
                                             <li><h4>How We Help</h4></li>
    										<li><a href="http://www.pct.com/our-role.html">Our Role in Title</a></li>
    										<li><a href="http://www.pct.com/protecting-you.html">Protecting You</a></li>
    										<li><a href="http://www.pct.com/why-pacific-coast-title.html">Why Pacific Coast Title</a></li>
    										<li><h4>About Us</h4></li>
    										<li><a href="http://www.pct.com/about-us.html">About Our Company</a></li>
    										<li><a href="http://www.pct.com/assets/downloads/PacificCoastTitle-FinancialStrength.pdf">Financial Strength</a></li>
    										<li><a href="http://www.pct.com/join-our-team.html">Join our Team</a></li>
                                            
                                        </ul>
                                    </li>
                                    <li class="dropdown"><a class="dropdown-toggle" href="#" data-toggle="dropdown">Residential<b class="caret"></b>
                              <!-- Classic Dropdown--></a>
                                        <ul class="dropdown-menu">
                                            <li><h4>Our Services</h4></li>
                                            <li><a href="http://www.pct.com/residential-title.html">Residential Title</a></li>
                                            <li><a href="http://www.pct.com/escrow-settlement.html">Escrow Settlement</a></li>
    										 <li><h4>About Title</h4></li>
    										 <li><a href="http://www.pct.com/what-is-title-insurance.html">What Is Title Insurance</a></li>
    										<li><a href="http://www.pct.com/benefits-title-insurance.html">Benefits of Title Insurance</a></li>
    										<li><a href="http://www.pct.com/life-of-title-search.html">Life of a Title Search</a></li>
    										<li><a href="http://www.pct.com/top-10-title-problems.html">Top 10 Title Concerns</a></li>
    										<li><h4>About Escrow</h4></li>
    										<li><a href="http://www.pct.com/what-is-escrow.html">What is Escrow</a></li>
    										<li><a href="http://www.pct.com/life-of-escrow.html">Life of an Escrow</a></li>
    										<li><a href="http://www.pct.com/escrow-terms.html">Escrow Terms</a></li>
                                        </ul>
                                    </li>
    								 <li class="dropdown"><a class="dropdown-toggle" href="#" data-toggle="dropdown">Commercial<b class="caret"></b>
                              <!-- Classic Dropdown--></a>
                                        <ul class="dropdown-menu">
                                           <li><a href="http://www.pct.com/commercial-services.html">Services</a></li>
                                            <li><a href="http://www.pct.com/commercial-expertise.html">Expertise</a></li>
                                            <li><a href="http://www.pct.com/commercial-resources.html">Resources</a></li>
                                        </ul>
                                    </li>
    								
                                    <li class="dropdown"><a class="dropdown-toggle" href="#" data-toggle="dropdown">Agent Resources<b class="caret"></b>
                              <!-- Classic Dropdown--></a>
                                        <ul class="dropdown-menu">
    										 <li><h4>Forms & Flyers</h4></li>
                                            <li><a href="http://www.pct.com/blank-forms.html">Blank Forms</a></li>
    										<li><a href="http://www.pct.com/educational-booklets.html">Educational Booklets</a></li>
    										<li><a href="http://www.pct.com/flyer-center.html">Flyer Center</a></li>
    										 <li class="divider"></li>
    										 <li><h4>Rates & Fees</h4></li>
    										<li><a href="http://www.pct.com/calculator/">Rate Calculator</a></li>
    										<li><a href="http://www.pct.com/calculator/index.php?welcome/signup">Lender Rate Portal</a></li>
    										<li><a href="http://www.pct.com/recording-fees.html">Recording Fees</a></li>
    										<li><a href="http://www.pct.com/assets/downloads/2019-RecordersCalendar.pdf">Recorders Holidays</a></li>
    										<li><a href="http://www.pct.com/assets/downloads/TransferTaxes.pdf">Transfer Tax Info</a></li>
    										<li><a href="http://www.pct.com/rate-book.html">Rate Book</a></li>
    										 <li class="divider"></li>
    										  <li><h4>Tools & Video</h4></li>
    										<li class="dropdown"><a class="dropdown-toggle" href="#" data-toggle="dropdown">Agent Tools<b style="color:#d35411;" class="caret"></b>
                              <!-- Classic Dropdown--></a>
    										<ul class="dropdown-menu">
    										
                                            <li><a href="http://www.pacificcoastagent.com/">Pacific Coast Agent</a></li>
    										<li><a href="https://www.pcttitletoolbox.com/#!/">PCT Title Toolbox</a></li>
    										<li><a href="#">Instant Profile</a></li>
    										
    										
    										 </ul>
                                    </li>
    								<li><a href="http://www.pct.com/training-center.html">Training center</a></li>
                                        </ul>
    									
                                    </li>
                                    <li class="dropdown"><a class="dropdown-toggle" href="contact.html" data-toggle="dropdown">Contact<b class="caret"></b>
                              <!-- Classic Dropdown--></a>
                                        <ul class="dropdown-menu">
    									
                                            <li><a href="http://www.pct.com/downey.html">Downey</a></li>
                                            <li><a href="http://www.pct.com/glendale.html">Glendale</a></li>
                                            <li><a href="http://www.pct.com/orange.html">Orange</a></li>
    										<li><a href="http://www.pct.com/oxnard.html">Oxnard</a></li>
                                            <li><a href="http://www.pct.com/sandiego.html">San Diego</a></li>
                                            
                                        </ul>
                                    </li>
                </ul>
                                </ul>
                            </div>
                        <!--   <div class="header-navibox-3">
                                <ul class="nav navbar-nav hidden-xs clearfix vcenter">
                                  <!--  <li><a class="btn_header_search" href="#"><i class="fa fa-search"></i></a></li>
                                    <li>
                                        <button class="js-toggle-screen toggle-menu-button"><i class="toggle-menu-button-icon"><span></span><span></span><span></span><span></span><span></span><span></span></i></button>
                                    </li>
                                </ul>
                            </div> -->
                          <!--  <div class="header-navibox-4">
                                <div class="header-cart"><a href="#"><i class="fa fa-shopping-basket" aria-hidden="true"></i></a><span class="header-cart-count">3</span></div>
                                <div class="header-language-nav dropdown">
                                    <button class="dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown">English<span class="caret"></span></button>
                                    <ul class="dropdown-menu">
                                        <li><a href="#">English</a></li>
                                        <li><a href="#">Italy</a></li>
                                        <li><a href="#">France</a></li>
                                    </ul>
                                </div>
                            </div> -->
                        </div>
                    </nav>
                </div>
            </header>
            <!-- end .header-->
            <div class="section-title-page7m area-bg area-bg_blue area-bg_op_60 parallax">
              <div class="area-bg__inner">
                <div class="container">
                  <div class="row">
                    <div class="col-xs-12">
                      <h1 class="b-title-page">Open Order Form</h1>
                      <div class="b-title-page__info">Helping Get Your Transaction Started.</div>
                      <!-- end breadcrumb-->
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <!-- end .b-title-page-->
    		
            <section class="section-type-4 section-default" style="padding-bottom:0px; padding-top:40px;">
                <div class="container">
                    <div class="row">
                        <div class="col-md-9">
                            <div class="smart-wrap">
                                <div class="smart-forms smart-container wrap-2">
                                    <div class="form-header header-primary">
                                        <h4>Open Your Title Order</h4>
                                    </div><!-- end .form-header section -->
                                    <!-- Start Form -->
                                    <form method="POST" action="<?php echo BASE_URL; ?>php/smartprocess.php" id="smart-form" enctype="multipart/form-data">
                                        <div class="form-body">
                                            <div class="spacer-b30 spacer-t30">
                                                <div class="tagline"><span>Customer Number</span></div>
                                            </div>   <!-- .tagline -->

                                            <div class="frm-row">
                                                <div class="section colm colm9">
                                                    <label class="field" style="padding-right:8px;">
                                                    <input type="text" class="gui-input" name="CustomerNumber" id="CustomerNumber" placeholder="Customer Number">
                                                    </label>
                                                    <em id="CustomerNumber-error" class="state-error" style="display: none;"></em>                     
                                                </div>
                                                <div class="section colm colm3">
                                                    <a href="javascript:void(0);" id="getCustomerInfo" class="clone button btn-primary"><i class="fa fa-check"></i></a>
                                                    <a href="javascript:void(0);" id="findCustomerNumber" class="delete button"><i class="fa fa-question"></i></a>
                                                </div>
                                            </div><!-- end frm-row section -->

                                            <div class="spacer-b30 spacer-t30">
                                                <div class="tagline"><span>Your Details (Will Be AutoFilled) </span></div><!-- .tagline -->
                                            </div>                 

                                            <div class="frm-row">
                                                <div class="section colm colm6">
                                                    <label class="field prepend-icon">
                                                        <input type="text" name="OpenName" id="OpenName" class="gui-input" placeholder=" First Name">
                                                        <span class="field-icon"><i class="fa fa-user"></i></span>
                                                        <input type="hidden" name="id" id="CustomerId" value="">
                                                    </label>
                                                </div><!-- end section --> 

                                                <div class="section colm colm6">
                                                    <label class="field prepend-icon">
                                                        <input type="text" name="OpenLastName" id="OpenLastName" class="gui-input" placeholder="Last Name">
                                                        <span class="field-icon"><i class="fa fa-user"></i></span>  
                                                    </label>
                                                </div><!-- end section -->
                                            </div><!-- end frm-row section -->

                                            <div class="frm-row">
                                                <div class="section colm colm6">
                                                    <label class="field prepend-icon">
                                                        <input type="tel" name="Opentelephone" id="Opentelephone" class="gui-input" placeholder="Telephone">
                                                        <span class="field-icon"><i class="fa fa-phone-square"></i></span>  
                                                    </label>
                                                </div><!-- end section --> 
                                                <div class="section colm colm6">
                                                    <label class="field prepend-icon">
                                                        <input type="email" name="OpenEmail" id="OpenEmail" class="gui-input" placeholder="Email address">
                                                        <span class="field-icon"><i class="fa fa-envelope"></i></span>  
                                                    </label>
                                                </div><!-- end section -->
                                            </div><!-- end frm-row section -->

                                            <div class="frm-row">                       
                                                <div class="section colm colm6">
                                                    <label class="field prepend-icon">
                                                        <input type="text" name="CompanyName" id="CompanyName" class="gui-input" placeholder="Company Name">
                                                        <span class="field-icon"><i class="fa fa-user"></i></span>
                                                    </label>
                                                </div><!-- end section --> 
                                            
                                                <div class="section colm colm6">
                                                    <label class="field prepend-icon">
                                                        <input type="text" name="StreetAddress" id="StreetAddress" class="gui-input" placeholder="Street Address">
                                                        <span class="field-icon"><i class="fa fa-envelope"></i></span>  
                                                    </label>
                                                </div><!-- end section -->         
                                            </div><!-- end frm-row section -->

                                            <div class="frm-row">                       
                                                <div class="section colm colm6">
                                                    <label class="field prepend-icon">
                                                        <input type="text" name="City" id="City" class="gui-input" placeholder="City">
                                                        <span class="field-icon"><i class="fa fa-user"></i></span>
                                                    </label>
                                                </div><!-- end section --> 
                                                
                                                <div class="section colm colm6">
                                                    <label class="field prepend-icon">
                                                        <input type="text" name="Zipcode" id="Zipcode" class="gui-input" placeholder="Zipcode">
                                                        <span class="field-icon"><i class="fa fa-envelope"></i></span>  
                                                    </label>
                                                </div><!-- end section -->  
                                            </div>

                                            <div class="spacer-b30 spacer-t30">
                                                <div class="tagline">
                                                    <span>Find Your Property</span>
                                                </div><!-- .tagline -->
                                            </div>

                                            <div class="frm-row">
                                                <div class="section colm colm10">
                                                    <label class="field prepend-icon">
                                                        <input type="text" name="Property" id="property-search" class="gui-input" placeholder="Property Address"> 
                                                        <span class="field-icon"><i class="fa fa-user"></i></span>
                                                        <input type="hidden" name="property-state" id="property-state" value="">
                                                        <input type="hidden" name="property-city" id="property-city" value="">
                                                        <input type="hidden" name="property-fips" id="property-fips" value="">
                                                        <input type="hidden" name="property-full-address" id="property-full-address" value="">
                                                    </label>
                                                </div>                                        
                                                <div class="section colm colm2">    
                                                    <!-- <button type="" data-btntext-sending="Searching..." class="button btn-primary">Search</button> -->

                                                    <a class="button btn-primary search-property search-property-button" href="javascript:void(0);" id="search-btn">Search</a>  
                                                </div> 
                                           </div>
                                           <div class="pma-error alert alert-danger" style="display:none;"></div>
                                            <div class="search-loader hidden"></div>

                                           <div class="spacer-b30 spacer-t30">
                                                <div class="tagline"><span> Property Details (Will Be AutoFilled) </span></div>
                                            </div>

                                            <div class="frm-row">
                                                <div class="section colm colm12">
                                                    <label class="field prepend-icon">
                                                        <input type="text" name="FullProperty" id="FullProperty" class="gui-input" placeholder="Full Street Address">
                                                        <span class="field-icon"><i class="fa fa-user"></i></span>
                                                    </label>
                                                </div><!-- end section -->
                                            </div>

                                            <div class="frm-row">                       
                                                <div class="section colm colm6">
                                                    <label class="field prepend-icon">
                                                        <input type="text" name="apn" id="apn" class="gui-input" placeholder="APN">
                                                        <span class="field-icon"><i class="fa fa-user"></i></span>
                                                    </label>
                                                </div><!-- end section --> 
                                                
                                                <div class="section colm colm6">
                                                    <label class="field prepend-icon">
                                                        <input type="text" name="County" id="County" class="gui-input" placeholder="County">
                                                        <span class="field-icon"><i class="fa fa-envelope"></i></span>  
                                                    </label>
                                                </div><!-- end section --> 
                                            </div>

                                            <div class="frm-row">
                                                <div class="section colm colm12">
                                                    <label class="field prepend-icon">
                                                        <input type="text" name="LegalDescription" id="LegalDescription" class="gui-input" placeholder="Brief Legal Desription">
                                                        <span class="field-icon"><i class="fa fa-user"></i></span>
                                                    </label>
                                                </div><!-- end section -->
                                            </div>

                                            <div class="spacer-b30 spacer-t30">
                                                <div class="tagline"><span>Seller Details (Will Be AutoFilled)</span></div><!-- .tagline -->
                                            </div>

                                            <div class="frm-row">
                                                <div class="section colm colm12">
                                                    <label class="field prepend-icon">
                                                        <input type="text" name="PrimaryOwner" id="PrimaryOwner" class="gui-input" placeholder="Primary Owner">
                                                        <span class="field-icon"><i class="fa fa-user"></i></span>
                                                    </label>
                                                </div><!-- end section -->

                                                <div class="section colm colm12">
                                                    <label class="field prepend-icon">
                                                        <input type="text" name="SecondaryOwner" id="SecondaryOwner" class="gui-input" placeholder="Secondary Owner">
                                                        <span class="field-icon"><i class="fa fa-user"></i></span>
                                                    </label>
                                                </div><!-- end section --> 
                                            </div>

                                            <div class="spacer-b30 spacer-t30">
                                                <div class="tagline"><span> Transaction Details </span></div><!-- .tagline -->
                                            </div>

                                            <div class="frm-row">
                                                <div class="section colm colm6">
                                                    <label class="field select">
                                                        <select id="SalesRep" name="SalesRep">
                                                            <option value="">Sales Rep...</option>
                                                            <option value="Angeline Ahn">Angeline Ahn</option>
                                                            <option value="Bethany Cummins">Bethany Cummins</option>
                                                            <option value="Cibeli Tregembo">Cibeli Tregembo</option>
                                                            <option value="David Gomez">David Gomez</option>
                                                            <option value="Edgar Rivas">Edgar Rivas</option>
                                                            <option value="Eddie Castro">Eddie Castro</option>
                                                            <option value="Evelyn Lindgren">Evelyn Lindgren</option>
                                                            <option value="Felicia Pantoja">Felicia Pantoja</option>
                                                            <option value="Hai Tran">Hai Tran</option>
                                                            <option value="Hugo Lopez">Hugo Lopez</option>
                                                            <option value="Justin Nouri">Justin Nouri</option>
                                                            <option value="Kim Buchok">Kim Buchok</option>
                                                            <option value="Linda Ruiz">Linda Ruiz</option>
                                                            <option value="Lisa Lee">Lisa Lee</option>
                                                            <option value="Lou Morreale">Lou Morreale</option>
                                                            <option value="Malay Wadhwa">Malay Wadhwa</option>
                                                            <option value="Max Galindo">Max Galindo</option>
                                                            <option value="Meza Group">Meza Group</option>
                                                            <option value="Michael Nouri">Michael Nouri</option>
                                                            <option value="Mike Johnson">Mike Johnson</option>
                                                            <option value="Nelson Torres">Nelson Torres</option>
                                                            <option value="Richard Bohn">Richard Bohn</option>
                                                            <option value="Scott Smith">Scott Smith</option>
                                                            <option value="Sonia Flores">Sonia Flores</option>
                                                        </select>
                                                        <i class="arrow double"></i>                    
                                                    </label>  
                                                </div><!-- end section -->

                                                <div class="section colm colm6">
                                                    <label class="field select">
                                                        <select id="TitleOfficer" name="TitleOfficer">
                                                            <option value="">Title Officer</option>
                                                            <option value="Albert Wassif">Albert Wassif</option>
                                                            <option value="Clive Virata">Clive Virata</option>
                                                            <option value="Eddie LasMarias">Eddie LasMarias</option>
                                                            <option value="Jim Jean">Jim Jean</option>
                                                        </select>
                                                        <i class="arrow double"></i>                    
                                                    </label>  
                                                </div><!-- end section -->       
                                            </div><!-- end frm-row section -->
                                            
                                            <div class="frm-row">
                                                <!-- <div class="section colm colm6">
                                                    <label class="field select">
                                                        <select id="TransactionTypeID" name="TransactionTypeID">
                                                            <option value="">Select Transaction Type</option>
                                                            <option value="3">Residential</option>
                                                            <option value="2">Commercial</option>
                                                        </select>
                                                        <i class="arrow double"></i>
                                                    </label>
                                                </div> -->
                                                <div class="section colm colm12">
                                                    <label class="field select">
                                                        <select id="ProductTypeID" name="ProductTypeID">
                                                            <option value="">Select Product</option>
                                                            <option value="33">Loan: Title Only (Outside Escrow) Westcor</option>
                                                            <option value="32">Sales: Title Only (Outside Escrow) Westcor</option>
                                                        </select>
                                                        <i class="arrow double"></i>
                                                    </label>
                                                </div>
                                            </div>

                                            <div class="frm-row" id="sales-loan-amount-fields" style="display: none;">
                                                <div class="section colm colm12">
                                                    <label class="field">
                                                        <input type="text" class="gui-input" name="salesAmount" id="salesAmount" placeholder="Sales Amount">
                                                    </label>
                                                    <div class="spacer-b10"></div>
                                                    <label class="field">
                                                        <input type="text" class="gui-input" name="loanAmount" id="loanAmount" placeholder="Loan Amount">
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="spacer-t30">
                                                <div class="tagline"><span> Special Instructions </span></div><!-- .tagline -->
                                            </div>
                                            <div class="frm-row">
                                                <div class="section colm colm4">
                                                    <div class="option-group field">
                                                        <label class="option block spacer-t10">
                                                            <input type="checkbox" name="CCR" value="CCR's">
                                                            <span class="checkbox"></span> CCR's           
                                                        </label>
                                                    </div><!-- end .option-group section -->
                                                </div><!-- end .colm section -->

                                                <div class="section colm colm4">
                                                    <div class="option-group field">
                                                        <label class="option block spacer-t10">
                                                            <input type="checkbox" name="Docs" value="Underlying Docs">
                                                            <span class="checkbox"></span> Underlying Docs           
                                                        </label>                                
                                                    </div><!-- end .option-group section -->
                                                </div><!-- end .colm section -->

                                                <div class="section colm colm4">
                                                    <div class="option-group field">
                                                        <label class="option block spacer-t10">
                                                            <input type="checkbox" name="Ease" value="Plotted Easements">
                                                            <span class="checkbox"></span> Plotted Easements           
                                                        </label>
                                                    </div><!-- end .option-group section -->
                                                </div><!-- end .colm section -->
                                            </div>

                                            <div class="section spacer-t20">
                                                <label class="field prepend-icon">
                                                    <textarea class="gui-textarea" id="sendermessage" name="sendermessage" placeholder="Additional details"></textarea>
                                                    <span class="field-icon"><i class="fa fa-comments"></i></span>
                                                    <span class="input-hint"> <strong>NOTE:</strong> Be as detailed as possible for better feedback.</span>   
                                                </label>
                                            </div><!-- end section -->

                                            <!-- start agent details -->
                                            <div class="spacer-t30">
                                                <div class="tagline"><span> Add Parties</span></div><!-- .tagline -->
                                            </div>
                                            <div class="frm-row">
                                                <div class="section colm colm4">
                                                    <div class="option-group field">
                                                        <label class="option block spacer-t10">
                                                            <input type="checkbox" name="add-agent-details" id= "add-agent-details">
                                                            <span class="checkbox"></span> Add Agent Details         
                                                        </label>
                                                    </div><!-- end .option-group section -->
                                                </div><!-- end .colm section -->

                                                <div class="section colm colm4" style="display: none;" id= "add-lender-section">
                                                    <div class="option-group field">
                                                        <label class="option block spacer-t10">
                                                            <input type="checkbox" name="add-lender-details" id= "add-lender-details">
                                                            <span class="checkbox"></span> Add Lender         
                                                        </label>
                                                    </div><!-- end .option-group section -->
                                                </div>

                                                <div class="section colm colm4" style="display: none;" id= "add-escrow-section">
                                                    <div class="option-group field">
                                                        <label class="option block spacer-t10">
                                                            <input type="checkbox" name="add-escrow-details" id= "add-escrow-details">
                                                            <span class="checkbox"></span> Add Escrow         
                                                        </label>
                                                    </div><!-- end .option-group section -->
                                                </div>
                                            </div>

                                            <div id="agent-details-fields" style="display: none;">
                                                <div class="frm-row">
                                                    <div class="spacer-b10"></div>
                                                    <div class="section colm colm6 tagline">
                                                        <span>
                                                            Buyers Agent
                                                        </span>
                                                    </div><!-- end section -->
                                                    <div class="section colm colm6 tagline">
                                                        <span>
                                                            Listing Agent
                                                        </span>
                                                    </div><!-- end section -->
                                                </div>
                                                <div class="frm-row">
                                                    <div class="section colm colm6">
                                                        <label class="field prepend-icon">
                                                            <input type="text" name="BuyerAgentName" id="BuyerAgentName" class="gui-input" placeholder="Agent Name">
                                                            <span class="field-icon"><i class="fa fa-user"></i></span>
                                                            <input type="hidden" name="BuyerAgentId" id="BuyerAgentId" value="">
                                                        </label>
                                                    </div><!-- end section -->
                                                    <div class="section colm colm6">
                                                        <label class="field prepend-icon">
                                                            <input type="text" name="ListingAgentName" id="ListingAgentName" class="gui-input" placeholder="Agent Name">
                                                            <span class="field-icon"><i class="fa fa-user"></i></span>
                                                            <input type="hidden" name="ListingAgentId" id="ListingAgentId" value="">
                                                        </label>
                                                    </div><!-- end section -->
                                                </div>

                                                <div class="frm-row">           
                                                    <div class="section colm colm6">
                                                        <label class="field prepend-icon">
                                                            <input type="email" name="BuyerAgentEmailAddress" id="BuyerAgentEmailAddress" class="gui-input" placeholder="Agent Email address" readonly="readonly">
                                                            <span class="field-icon"><i class="fa fa-envelope"></i></span>  
                                                        </label>
                                                    </div><!-- end section -->

                                                    <div class="section colm colm6">
                                                        <label class="field prepend-icon">
                                                            <input type="email" name="ListingAgentEmailAddress" id="ListingAgentEmailAddress" class="gui-input" placeholder="Agent Email address" readonly="readonly">
                                                            <span class="field-icon"><i class="fa fa-envelope"></i></span>  
                                                        </label>
                                                    </div><!-- end section -->
                                                </div><!-- end frm-row section -->

                                                <div class="frm-row">           
                                                    <div class="section colm colm6">
                                                        <label class="field prepend-icon">
                                                            <input type="tel" name="BuyerAgentTelephone" id="BuyerAgentTelephone" class="gui-input" placeholder="Agent Telephone" readonly="readonly">
                                                            <span class="field-icon"><i class="fa fa-phone-square"></i></span>  
                                                        </label>
                                                    </div><!-- end section -->

                                                    <div class="section colm colm6">
                                                        <label class="field prepend-icon">
                                                            <input type="tel" name="ListingAgentTelephone" id="ListingAgentTelephone" class="gui-input" placeholder="Agent Telephone" readonly="readonly">
                                                            <span class="field-icon"><i class="fa fa-phone-square"></i></span>  
                                                        </label>
                                                    </div><!-- end section -->
                                                </div><!-- end frm-row section -->
                                                <div class="frm-row">
                                                    <div class="section colm colm6">
                                                        <label class="field prepend-icon">
                                                            <input type="text" name="BuyerAgentCompany" id="BuyerAgentCompany" class="gui-input" placeholder="Agent Company Name" readonly="readonly">
                                                            <span class="field-icon"><i class="fa fa-user"></i></span>
                                                        </label>
                                                    </div><!-- end section -->
                                                    <div class="section colm colm6">
                                                        <label class="field prepend-icon">
                                                            <input type="text" name="ListingAgentCompany" id="ListingAgentCompany" class="gui-input" placeholder="Agent Company Name" readonly="readonly">
                                                            <span class="field-icon"><i class="fa fa-user"></i></span>
                                                        </label>
                                                    </div><!-- end section -->
                                                </div>
                                            </div>
                                            <!-- end agent details -->

                                            <!-- start lender details  -->

                                            <div id="lender-details-fields" style="display: none;">
                                                
                                                <div class="spacer-b30">
                                                    <div class="tagline"><span> Add Lender Details</span></div><!-- .tagline -->
                                                </div>

                                                <div class="frm-row">
                                                    <div class="section colm colm12">
                                                        <label class="field prepend-icon">
                                                            <input type="text" name="LenderName" id="LenderName" class="gui-input" placeholder="Lender Name">
                                                            <span class="field-icon"><i class="fa fa-user"></i></span>
                                                            <input type="hidden" name="LenderId" id="LenderId" value="">
                                                        </label>
                                                    </div><!-- end section -->
                                                </div>

                                                <div class="frm-row">           
                                                    <div class="section colm colm6">
                                                        <label class="field prepend-icon">
                                                            <input type="email" name="LenderEmailAddress" id="LenderEmailAddress" class="gui-input" placeholder="Lender Email address" readonly="readonly">
                                                            <span class="field-icon"><i class="fa fa-envelope"></i></span>  
                                                        </label>
                                                    </div><!-- end section -->

                                                    <div class="section colm colm6">
                                                        <label class="field prepend-icon">
                                                            <input type="tel" name="LenderTelephone" id="LenderTelephone" class="gui-input" placeholder="Lender Telephone" readonly="readonly">
                                                            <span class="field-icon"><i class="fa fa-phone-square"></i></span>  
                                                        </label>
                                                    </div><!-- end section -->
                                                </div><!-- end frm-row section -->
                                                <div class="frm-row">
                                                    <div class="section colm colm12">
                                                        <label class="field prepend-icon">
                                                            <input type="text" name="LenderCompany" id="LenderCompany" class="gui-input" placeholder="Lender Company Name" readonly="readonly">
                                                            <span class="field-icon"><i class="fa fa-user"></i></span>
                                                        </label>
                                                    </div><!-- end section -->
                                                </div>
                                                
                                                
                                            </div>
                                            <!-- end lender details  -->

                                            <!-- start escrow details -->
                                            <div id="escrow-details-fields" style="display: none;">
                                                
                                                <div class="spacer-b30">
                                                    <div class="tagline"><span> Add Escrow Details</span></div><!-- .tagline -->
                                                </div>

                                                <div class="frm-row">
                                                    <div class="section colm colm12">
                                                        <label class="field prepend-icon">
                                                            <input type="text" name="EscrowName" id="EscrowName" class="gui-input" placeholder="Escrow Name">
                                                            <span class="field-icon"><i class="fa fa-user"></i></span>
                                                            <input type="hidden" name="EscrowId" id="EscrowId" value="">
                                                        </label>
                                                    </div><!-- end section -->
                                                </div>

                                                <div class="frm-row">           
                                                    <div class="section colm colm6">
                                                        <label class="field prepend-icon">
                                                            <input type="email" name="EscrowEmailAddress" id="EscrowEmailAddress" class="gui-input" placeholder="Escrow Email address" readonly="readonly">
                                                            <span class="field-icon"><i class="fa fa-envelope"></i></span>  
                                                        </label>
                                                    </div><!-- end section -->

                                                    <div class="section colm colm6">
                                                        <label class="field prepend-icon">
                                                            <input type="tel" name="EscrowTelephone" id="EscrowTelephone" class="gui-input" placeholder="Escrow Telephone" readonly="readonly">
                                                            <span class="field-icon"><i class="fa fa-phone-square"></i></span>  
                                                        </label>
                                                    </div><!-- end section -->
                                                </div><!-- end frm-row section -->
                                                <div class="frm-row">
                                                    <div class="section colm colm12">
                                                        <label class="field prepend-icon">
                                                            <input type="text" name="EscrowCompany" id="EscrowCompany" class="gui-input" placeholder="Escrow Company Name" readonly="readonly">
                                                            <span class="field-icon"><i class="fa fa-user"></i></span>
                                                        </label>
                                                    </div><!-- end section -->
                                                </div>
                                            </div>
                                            <!-- end escrow details -->

                                            <div class="result spacer-b10"></div><!-- end .result  section -->

                                            <!-- <div class="section progress-section">
                                                <div class="progress-bar progress-animated bar-primary">
                                                    <div class="bar"></div>
                                                    <div class="percent">0%</div>
                                                </div>
                                            </div> --><!-- end progress section -->

                                            <div class='' id="progressDivId">
                                                <div class='' id='progressBar'></div>
                                                <div class='' id='percent'>0%</div>
                                            </div>
                                            <div style="height: 10px;"></div>

                                        </div><!-- end .form-body section -->
                                        <div class="form-footer">
                                            <button type="submit" data-btntext-sending="Sending..." class="button btn-primary">Submit</button>
                                            <button type="reset" class="button">Cancel</button>
                                            <a style="border: 0;height: 42px;color: #243140;line-height: 1;font-size: 15px;cursor: pointer;padding: 0 18px;text-align: center;vertical-align: top;background: #bdc3c7;display: inline-block;-webkit-user-drag: none;text-shadow: 0 1px rgba(255, 255, 255, 0.2);margin-right: 10px;margin-bottom: 5px;text-decoration: none;border-radius: 3px;padding-top: 13px;" href="http://www.pct.com">Homepage</a>
                                        </div>
                                    </form>
                                    <!-- End Form -->
                                </div><!-- end .smart-forms section -->
                            </div><!-- end .smart-wrap section -->
                        </div>
                        <div class="col-md-3">
                            <section class="b-sm-about">  
                                <ul class="b-isotope-grid grid list-unstyled">
                                    <li class="grid-sizer"></li>
                                    <li style="margin-bottom:15px;" class="b-isotope-grid__item grid-item pctttb"><a class="b-isotope- lightbox" href="https://www.youtube.com/watch?v=ICczHNfT7cA"><img src="http://www.pct.com/order/images/OpenOrderFormVideo.jpg" alt="foto"></a></li>
                                </ul>
                                <h3  class="b-sm-about__title">Video Tutorial - Smart Form</h3>
                                <p>We have created a quick video that shows you how our smart open order form works.</p>
                            </section>
                        </div>
                    </div>
                </div>
            </section>
          <!-- end .section-type-14-->
    	  <br><br>
    	  <section class="section-type-1 section-sm parallax area-bg area-bg_grad-2 area-bg_op_80">
            <div class="area-bg__inner">
              <div class="container">
                <div class="row">
                  <div class="col-md-7">
                    <h2 class="ui-title-block-3">Ready to work with us?</h2>
                    <div class="ui-subtitle-block-2">we are ready to help.</div>
                  </div>
                  <div class="col-md-5"><a class="btn btn-default btn-round pull-right" href="https://clients.pacificcoasttitle.com/login.aspx?ReturnUrl=/&officeid=1">open orders</a><a class="btn btn-default btn-round pull-right" href="rate-book.html">get rates</a></div>
                </div>
              </div>
            </div>
          </section>
    	  
           <footer class="footer">
                <div class="container">
                    <div class="row">
                        <div class="col-xs-12">
                            <ul class="footer-social-nets">
                                <li class="footer-social-nets__item"><a class="footer-social-nets__link" href="https://www.facebook.com/PacificCoastTitleCompany/">facebook</a></li>
                                <li class="footer-social-nets__item"><a class="footer-social-nets__link" href="https://twitter.com/mypct?lang=en">twitter</a></li>                      
                                <li class="footer-social-nets__item"><a class="footer-social-nets__link" href="#">instagram</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="footer__main">
                    <div class="container">
                        <div class="row">
                            <div class="col-sm-4">
                                <div class="footer-section">
                                    <a class="footer__logo" href="<?php echo BASE_URL_MAIN; ?>index.html"><img class="img-responsive" src="http://www.pct.com/assets/media/general/logo-lg2.png" alt="Logo"></a>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <section class="footer-section footer-section_links">
                                    <h3 class="footer-section__title">useful links</h3>
                                    <ul class="footer-list list-unstyled">
                                        <li class="footer-list__item"><a class="footer-list__link" href="<?php echo BASE_URL_MAIN; ?>about-us.html">About Us</a></li>
                                        <li class="footer-list__item"><a class="footer-list__link" href="<?php echo BASE_URL_MAIN; ?>contact.html">Contact Us</a></li>
                                        <li class="footer-list__item"><a class="footer-list__link" href="<?php echo BASE_URL_MAIN; ?>how-we-protect-you.html">Our Role</a></li>
                                        <li class="footer-list__item"><a class="footer-list__link" href="<?php echo BASE_URL_MAIN; ?>blank-forms.html">Blank Forms</a></li>
                                        <li class="footer-list__item"><a class="footer-list__link" href="<?php echo BASE_URL_MAIN; ?>what-is-title-insurance.html">What Is Title Ins.</a></li>
                                        <li class="footer-list__item"><a class="footer-list__link" href="<?php echo BASE_URL_MAIN; ?>information-flyers.html">Info Flyers</a></li>
    									<li class="footer-list__item"><a class="footer-list__link" href="<?php echo BASE_URL_MAIN; ?>notices.html">Notices</a></li>
                                       <li class="footer-list__item"><a class="footer-list__link" href="<?php echo BASE_URL_MAIN; ?>sb2-forms.html">SB2-Forms</a></li>
                                    </ul>
                                </section>
                            </div>
                            <div class="col-sm-4">
                                <section class="footer-section">
                                    <h3 class="footer-section__title">Corporate Contact Info</h3>
                                    <p>Address: 1111 E. Katella Ave Ste. 120 Orange, CA 92867</p>
                                    <p>Phone: (714) 516-6700 / (866) 724-1050</p>
                                    <p>Email: info@pct.com</p><a class="footer__link" href="https://goo.gl/maps/Hrjgqrh1imP2">get directions</a>
                                </section>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="copyright">
                    <div class="container">
                    <div class="row">
                        <div class="col-xs-12">©<a class="copyright__link" href="<?php echo BASE_URL_MAIN; ?>"> PACIFIC COAST TITLE COMPANY</a> All rights reserved.</div>
                    </div>
                        </div>
                </div>
            </footer>
            <!-- .footer-->
        </div>
    <!-- end layout-theme-->
   
        <!-- ++++++++++++-->
        <!-- MAIN SCRIPTS-->
        <!-- ++++++++++++-->
        <!-- <script src="http://www.pct.com/assets/libs/jquery-1.12.4.min.js"></script> -->
        <script src="http://www.pct.com/assets/libs/jquery-migrate-1.2.1.js"></script>
        <!-- Bootstrap-->
        <script src="http://www.pct.com/assets/libs/bootstrap/bootstrap.min.js"></script>

        <!---->
        <!-- Select customization & Color scheme-->
        <script src="http://www.pct.com/assets/plugins/bootstrap-select/js/bootstrap-select.js"></script>
        <!-- Slider-->
        <script src="http://www.pct.com/assets/plugins/owl-carousel/owl.carousel.min.js"></script>
        <!-- Pop-up window-->
        <script src="http://www.pct.com/assets/plugins/magnific-popup/jquery.magnific-popup.min.js"></script>
        <!-- Headers scripts-->
        <script src="http://www.pct.com/assets/plugins/headers/slidebar.js"></script>
        <script src="http://www.pct.com/assets/plugins/headers/header.js"></script>
        <!-- Mail scripts-->
        <script src="http://www.pct.com/assets/plugins/jqBootstrapValidation.js"></script>
        <!-- <script src="http://www.pct.com/assets/plugins/contact_me.js"></script> -->
        <!-- Video player-->
        <script src="http://www.pct.com/assets/plugins/flowplayer/flowplayer.min.js"></script>
        <!-- Filter and sorting images-->
        <script src="http://www.pct.com/assets/plugins/isotope/isotope.pkgd.min.js"></script>
        <script src="http://www.pct.com/assets/plugins/isotope/imagesLoaded.js"></script>
        <!-- Progress numbers-->
        <script src="http://www.pct.com/assets/plugins/rendro-easy-pie-chart/jquery.easypiechart.min.js"></script>
        <script src="http://www.pct.com/assets/plugins/rendro-easy-pie-chart/waypoints.min.js"></script>
        <!-- Animations-->
        <script src="http://www.pct.com/assets/plugins/scrollreveal/scrollreveal.min.js"></script>
        <script src="http://www.pct.com/assets/plugins/revealer/js/anime.min.js"></script>
        <script src="http://www.pct.com/assets/plugins/revealer/js/scrollMonitor.js"></script>
        <script src="http://www.pct.com/assets/plugins/revealer/js/main.js"></script>
        <script src="http://www.pct.com/assets/plugins/animate/wow.min.js"></script>
        <script src="http://www.pct.com/assets/plugins/animate/jquery.shuffleLetters.js"></script>
        <script src="http://www.pct.com/assets/plugins/animate/jquery.scrollme.min.js"></script>
        <script type="text/javascript" src="<?php echo BASE_URL; ?>js/jquery-ui.min.js"></script>
        <!-- User customization-->
        <script src="http://www.pct.com/assets/js/custom.js"></script>
        <script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCoMfJn9Q37LUYQucbUdgWF8JGWRuTZlt4&libraries=places&sensor=false"></script>
        <script type="text/javascript" src="<?php echo BASE_URL; ?>js/custom.js"></script>
        <!-- Facebook Pixel Code -->
        <script>
        !function(f,b,e,v,n,t,s){if(f.fbq)return;n=f.fbq=function(){n.callMethod?
        n.callMethod.apply(n,arguments):n.queue.push(arguments)};if(!f._fbq)f._fbq=n;
        n.push=n;n.loaded=!0;n.version='2.0';n.queue=[];t=b.createElement(e);t.async=!0;
        t.src=v;s=b.getElementsByTagName(e)[0];s.parentNode.insertBefore(t,s)}(window,
        document,'script','https://connect.facebook.net/en_US/fbevents.js');
        fbq('init', '307916942954456', {
        em: 'insert_email_variable'
        });
        fbq('track', 'PageView');
        </script>
        <noscript><img height="1" width="1" style="display:none"
        src="https://www.facebook.com/tr?id=307916942954456&ev=PageView&noscript=1"
        /></noscript>
        <!-- DO NOT MODIFY -->
        <!-- End Facebook Pixel Code -->


        <!-- Start Property search result Modal -->
        <div class="modal fade" id="searchResultModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
          <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h4 class="modal-title">Search Results</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body search-result">
                    <table class="table-search-results" width="100%">
                        <thead>
                            <tr>
                                <th width="21%">APN</th>
                                <th width="22%">Address</th>
                                <!-- <th width="21%">County</th> -->
                                <th width="21%">City</th>
                                <th width="15%">Run Listing</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
              </div>
              <div class="modal-footer">
                <div class="apn-search-loader hidden"></div>
            </div>
            </div>
          </div>
        </div>
        <!-- End Property search result Modal -->

        <!-- Start Find Customer Number Modal -->
        <div class="modal fade smart-forms" id="findCustomerModal" tabindex="-1" role="dialog" aria-labelledby="customerModalLabel" aria-hidden="true">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h4 class="modal-title">Find Customer Number</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
                <div class="modal-body search-result">
                    <form method="POST" action="<?php echo BASE_URL; ?>php/findcustomernumber.php" id="find-customer-form">
                        <div class="form-body">
                            <div class="frm-row">
                                <div class="section colm colm12">
                                    <label class="field prepend-icon">
                                        <input type="email" name="CustomerEmail" id="CustomerEmail" class="gui-input" placeholder="Email address">
                                        <span class="field-icon"><i class="fa fa-envelope"></i></span>  
                                    </label>
                                </div>
                            </div>
                        </div>
                    
                    <div class="find-customer-result"></div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="button btn-primary">Submit</button>
                    <button type="button" class="button btn-primary" data-dismiss="modal">Cancel</button>
                </div>
                </form>
            </div>
          </div>
        </div>
        <!-- End Find Customer Number Modal -->

        <!-- Start Show Customer Number Modal -->
        <div class="modal fade smart-forms" id="showCustomernumberModal" tabindex="-1" role="dialog" aria-labelledby="showCustomernumberModalLabel" aria-hidden="true">
          <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h4 class="modal-title">Customer Number</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
                <div class="modal-body search-result">                    
                        <div class="form-body">                            
                            <div id="showCustomerNumber"></div>
                        </div>                    
                        <!-- <div class="find-customer-result"></div> -->
                </div>
                <div class="modal-footer">
                    <button type="button" class="button btn-primary" data-dismiss="modal">Close</button>
                </div>
            </div>
          </div>
        </div>
        <!-- End Show Customer Number Modal -->
    </body>
</html>
