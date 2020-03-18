<?php 
// echo "<pre>"; print_r(base_url()); exit;
?>
<!DOCTYPE html>
<html>
<head>
	<title><?php echo $title; ?></title>
	<meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <meta content="We specialize in Residential, Commercial Title & Escrow Services" name="description">
    <meta content="" name="keywords">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="telephone=no" name="format-detection">
    <meta name="HandheldFriendly" content="true">
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/frontend/css/custom.css">
    <link rel="stylesheet" href="http://www.pct.com/assets/css/master.css">
    <link rel="icon" href="<?php echo base_url(); ?>assets/frontend/images/favicon.ico" type="image/x-icon">
    <link rel="stylesheet" type="text/css"  href="<?php echo base_url(); ?>assets/frontend/css/smart-forms.css">
    <link rel="stylesheet" type="text/css"  href="<?php echo base_url(); ?>assets/frontend/css/font-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/frontend/css/jquery-ui.css">

    <script type="text/javascript" src="<?php echo base_url(); ?>assets/frontend/js/jquery-1.9.1.min.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>assets/frontend/js/jquery.form.min.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>assets/frontend/js/jquery.validate.min.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>assets/frontend/js/additional-methods.min.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>assets/frontend/js/smart-form.js"></script>     
    <!-- <script type="text/javascript" src="<?php // echo BASE_URL; ?>js/en/jquery-cloneya.min.js"></script> -->
</head>
<body>
	<!-- Loader-->
    <!-- <div id="page-preloader">
        <span class="spinner border-t_second_b border-t_prim_a"></span>
    </div> -->

    <!-- Start theme layout -->
    <div class="l-theme animated-css" data-header="sticky" data-header-top="200" data-canvas="container">
            
    	<!-- start mobile menu -->
        <div data-off-canvas="mobile-slidebar left overlay">
            <ul class="yamm nav navbar-nav">
	            <li>
	            	<a href="<?php echo BASE_URL_MAIN; ?>index.html">Home</a>
	            </li>
               	<li class="dropdown">
               		<a class="dropdown-toggle" href="#" data-toggle="dropdown">About Us<b class="caret"></b>
          			</a>
          			<!-- Classic Dropdown-->
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
                <li class="dropdown">
                	<a class="dropdown-toggle" href="#" data-toggle="dropdown">Residential<b class="caret"></b>
          			</a>
          			<!-- Classic Dropdown-->
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
				<li class="dropdown">
				 	<a class="dropdown-toggle" href="#" data-toggle="dropdown">Commercial<b class="caret"></b></a>
		      		<!-- Classic Dropdown-->
	                <ul class="dropdown-menu">
	                   <li><a href="http://www.pct.com/commercial-services.html">Services</a></li>
	                    <li><a href="http://www.pct.com/commercial-expertise.html">Expertise</a></li>
	                    <li><a href="http://www.pct.com/commercial-resources.html">Resources</a></li>
	                </ul>
	            </li>
								
                <li class="dropdown">
                	<a class="dropdown-toggle" href="#" data-toggle="dropdown">Agent Resources<b class="caret"></b></a>
                	<!-- Classic Dropdown-->
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
						<li class="dropdown">
							<a class="dropdown-toggle" href="#" data-toggle="dropdown">Agent Tools<b style="color:#d35411;" class="caret"></b></a>
		          				<!-- Classic Dropdown-->
								<ul class="dropdown-menu">						
			                        <li><a href="http://www.pacificcoastagent.com/">Pacific Coast Agent</a></li>
									<li><a href="https://www.pcttitletoolbox.com/#!/">PCT Title Toolbox</a></li>
									<li><a href="#">Instant Profile</a></li>
								</ul>
		                </li>
						<li><a href="http://www.pct.com/training-center.html">Training center</a></li>
                    </ul>
                </li>
                <li class="dropdown">
                	<a class="dropdown-toggle" href="contact.html" data-toggle="dropdown">Contact<b class="caret"></b></a>
                	<!-- Classic Dropdown-->
                    <ul class="dropdown-menu">					
                        <li><a href="http://www.pct.com/downey.html">Downey</a></li>
                        <li><a href="http://www.pct.com/glendale.html">Glendale</a></li>
                        <li><a href="http://www.pct.com/orange.html">Orange</a></li>
						<li><a href="http://www.pct.com/oxnard.html">Oxnard</a></li>
                        <li><a href="http://www.pct.com/sandiego.html">San Diego</a></li>    
                        <li><a href="<?php echo base_url().'?logout'; ?>">Logout</a></li>                     
                    </ul>
                </li>
            </ul>
            </ul>
        </div>
        <!-- end mobile menu -->

        <!-- start full screen menu -->
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
                                    <li class="dropdown"><a class="dropdown-toggle" href="#" data-toggle="dropdown">Residential<b class="caret"></b></a>
                                    <!-- Classic Dropdown-->
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
                                            <li><a href="<?php echo base_url().'?logout'; ?>">Logout</a></li>  
                                            
                                        </ul>
                                    </li>
                </ul>
                                </ul>
                            </div>
                        </div>
                    </nav>
                </div>
            </header>
        <!-- end full screen menu -->
    	  
       
    <!-- End theme layout -->
</body>
</html>