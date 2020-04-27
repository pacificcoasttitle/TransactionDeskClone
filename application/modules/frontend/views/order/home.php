<body>
    <?php
        $this->load->view('layout/header');
    ?>
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
                                    <form method="POST" id="smart-form" enctype="multipart/form-data">
                                        <div class="form-body">
                                            <div class="spacer-b30 spacer-t30">
                                                <div class="tagline"><span>Your Details (Will Be AutoFilled) </span></div><!-- .tagline -->
                                            </div>                 

                                            <div class="frm-row">
                                                <div class="section colm colm6">
                                                    <label class="field prepend-icon">
                                                        <input value="<?php echo $customer_data['first_name'];?>" type="text" name="OpenName" id="OpenName" class="gui-input" placeholder=" First Name">
                                                        <span class="field-icon"><i class="fa fa-user"></i></span>
                                                        <input type="hidden" name="id" id="CustomerId" value="<?php echo $customer_data['id'];?>">
                                                    </label>
                                                </div><!-- end section --> 

                                                <div class="section colm colm6">
                                                    <label class="field prepend-icon">
                                                        <input value="<?php echo $customer_data['last_name'];?>" type="text" name="OpenLastName" id="OpenLastName" class="gui-input" placeholder="Last Name">
                                                        <span class="field-icon"><i class="fa fa-user"></i></span>  
                                                    </label>
                                                </div><!-- end section -->
                                            </div><!-- end frm-row section -->

                                            <div class="frm-row">
                                                <div class="section colm colm6">
                                                    <label class="field prepend-icon">
                                                        <input value="<?php echo $customer_data['telephone_no'];?>" type="tel" name="Opentelephone" id="Opentelephone" class="gui-input" placeholder="Telephone">
                                                        <span class="field-icon"><i class="fa fa-phone-square"></i></span>  
                                                    </label>
                                                </div><!-- end section --> 
                                                <div class="section colm colm6">
                                                    <label class="field prepend-icon">
                                                        <input value="<?php echo $customer_data['email_address'];?>" type="email" name="OpenEmail" id="OpenEmail" class="gui-input" placeholder="Email address">
                                                        <span class="field-icon"><i class="fa fa-envelope"></i></span>  
                                                    </label>
                                                </div><!-- end section -->
                                            </div><!-- end frm-row section -->

                                            <div class="frm-row">                       
                                                <div class="section colm colm6">
                                                    <label class="field prepend-icon">
                                                        <input value="<?php echo $customer_data['company_name'];?>" type="text" name="CompanyName" id="CompanyName" class="gui-input" placeholder="Company Name">
                                                        <span class="field-icon"><i class="fa fa-user"></i></span>
                                                    </label>
                                                </div><!-- end section --> 
                                            
                                                <div class="section colm colm6">
                                                    <label class="field prepend-icon">
                                                        <input value="<?php echo $customer_data['street_address'];?>" type="text" name="StreetAddress" id="StreetAddress" class="gui-input" placeholder="Street Address">
                                                        <span class="field-icon"><i class="fa fa-envelope"></i></span>  
                                                    </label>
                                                </div><!-- end section -->         
                                            </div><!-- end frm-row section -->

                                            <div class="frm-row">                       
                                                <div class="section colm colm6">
                                                    <label class="field prepend-icon">
                                                        <input value="<?php echo $customer_data['city'];?>" type="text" name="City" id="City" class="gui-input" placeholder="City">
                                                        <span class="field-icon"><i class="fa fa-user"></i></span>
                                                    </label>
                                                </div><!-- end section --> 
                                                
                                                <div class="section colm colm6">
                                                    <label class="field prepend-icon">
                                                        <input value="<?php echo $customer_data['zip_code'];?>" type="text" name="Zipcode" id="Zipcode" class="gui-input" placeholder="Zipcode">
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
                                                        <input type="hidden" name="property-type" id="property-type" value="">
                                                        <input type="hidden" name="property-zip" id="property-zip" value="">
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
                                                            <option value="33">Loan: Refinance</option>
                                                	    <option value="32">Sales: Purchase</option>
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
                                                <?php 
                                                    $is_escrow = isset($customer_data['is_escrow']) && !empty($customer_data['is_escrow']) ?  $customer_data['is_escrow'] : 0;
                                                ?>
                                                <?php 
                                                    if($is_escrow == 1)
                                                    {
                                                ?>
                                                        <div class="section colm colm4" id= "add-lender-section">
                                                            <div class="option-group field">
                                                                <label class="option block spacer-t10">
                                                                    <input type="checkbox" name="add-lender-details" id= "add-lender-details">
                                                                    <span class="checkbox"></span> Add Lender         
                                                                </label>
                                                            </div><!-- end .option-group section -->
                                                        </div>
                                                <?php
                                                    }
                                                ?>
                                                <?php 
                                                    if($is_escrow == 0)
                                                    {
                                                ?>
                                                        <div class="section colm colm4" id= "add-escrow-section">
                                                            <div class="option-group field">
                                                                <label class="option block spacer-t10">
                                                                    <input type="checkbox" name="add-escrow-details" id= "add-escrow-details">
                                                                    <span class="checkbox"></span> Add Escrow         
                                                                </label>
                                                            </div><!-- end .option-group section -->
                                                        </div>
                                                <?php
                                                    }
                                                ?>
                                                
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
                                    <li style="margin-bottom:15px;" class="b-isotope-grid__item grid-item pctttb"><a class="b-isotope- lightbox" href="https://www.youtube.com/watch?v=ICczHNfT7cA"><img src="<?php echo base_url(); ?>assets/frontend/images/OpenOrderFormVideo.jpg" alt="foto"></a></li>
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
          
          <?php
                $this->load->view('layout/footer_above_section');
        ?>
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
                        <form method="POST" action="" id="find-customer-form">
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
<?php
    $this->load->view('layout/footer');
?>
<script type="text/javascript">
    var L_V_CreateService,L_V_GetRequestSummary,L_V_GetResultById;
    var Tax_CreateService,Tax_GetRequestSummary,Tax_GetResultById;
</script>
<link rel="stylesheet" type="text/css"  href="<?php echo base_url(); ?>assets/frontend/css/smart-forms.css">
<link rel="stylesheet" type="text/css"  href="<?php echo base_url(); ?>assets/frontend/css/font-awesome.min.css">
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/frontend/css/jquery-ui.css">


<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCoMfJn9Q37LUYQucbUdgWF8JGWRuTZlt4&libraries=places&sensor=false"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/frontend/js/jquery.form.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/frontend/js/jquery.validate.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/frontend/js/additional-methods.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/frontend/js/smart-form.js"></script> 
<script type="text/javascript" src="<?php echo base_url(); ?>assets/frontend/js/custom.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/frontend/js/jquery-ui.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/frontend/js/order.js"></script>
