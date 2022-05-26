<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $title;?></title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,300;0,400;0,500;0,600;0,700;1,200&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="<?php echo base_url();?>assets/frontend/css/buyer-seller-package/bootstrap.min.css">
    <link rel="stylesheet" href="<?php echo base_url();?>assets/frontend/css/buyer-seller-package/style.css">
</head>
<body class="">


        <!-- header -->

        <header>
        <div class="container">
            <div class="row align-items-center">
                <div class="col-6">
                    <a href="#"><img src="<?php echo base_url();?>assets/frontend/images/buyer-seller-package/alanna-logo.png" alt="..." class="img-fluid img_logo"></a>
                </div>
                <div class="col-6 text-end">
                    <select class="lang_selection form-control">
                        <option>English</option>
                        <option>Español</option>
                    </select>
                </div>
            </div>
        </div>
    </header>

    <!-- form content -->

    <section class="form_content">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <p class="mb-5">
                        This is an example of a Buyer Welcome Package.
                    </p>
                    <form action="">
                    <!--    <div class="form-group">
                            <label for="" class="mb-2"><b>FOR EXAMPLE ONLY Please enter your email address to receive a copy of the completed form </b></label>
                            <div class="col-xl-4 col-md-6">
                                <input type="text" class="form-control">
                            </div>
                        </div>  -->
                        <h2 class="blue_title">Buyer Opening Package<br><span style="font-size:16px; padding-top:15px;">Property Address: 13321 Success Ave, Success City, CA 91253</span><br><span style="font-size:16px; padding-top:15px;">APN:000-000-0000</span></h2>
                        <div class="accordion" id="accordionExample">
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="headingOne">
                                    <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">(1) Property Information</button>
                                </h2>
                                <div id="collapseOne" class="accordion-collapsed collapse" aria-labelledby="headingOne" data-bs-parent="#accordionExample">
                                    <div class="accordion-body">
                                        <div class="row mb-3">
                                      
                                            <div class="col-md-12">
                                                <div class="form-group position-relative mb-3 mt-3">
                                                    <label for="" class="mb-2"><b>Property Address Being Purchased</b></label>
                                                    <input type="text" class="form-control">
                                                    <small class="small_label">Street Address</small>
                                                </div>
                                                <div class="form-group position-relative mb-3">
                                                    <input type="text" class="form-control">
                                                    <small  class="small_label">Street Address Line 2</small>
                                                </div>
												
												<div class="row">
												
												<div class="col-md-6">
                                                <div class="form-group position-relative mb-3">
                                                    <input type="text" class="form-control">
                                                    <small  class="small_label">City</small>
                                                </div></div>
                                               <div class="col-md-6">
													<div class="form-group position-relative mb-3 ">
                                                    <input type="text" class="form-control">
                                                    <small  class="small_label">Zip Code</small>
													</div></div>
												</div>	
													
                                            </div>
                                        </div>
                                        </div>

                                       

                                       
                                    </div>
                                </div>
								<div class="accordion-item">
                                <h2 class="accordion-header" id="headingThirteen">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThirteen" aria-expanded="false" aria-controls="collapseThirteen">(2) Buyer Information</button>
                                </h2>
                                <div id="collapseThirteen" class="accordion-collapse collapse" aria-labelledby="headingThirteen" data-bs-parent="#accordionExample">
                                    <div class="accordion-body">
                                        <div class="row mb-3">
                                      
                                            <div class="col-md-12">
												 <div class="fieldset">
													<div class="legend">Enter Buyer #1 Name *</div>
					
												<div class="row">
													<div class="col-md-4">
														<div class="form-group">
															<label for="" class="mb-2">First Name</label>
															<input type="text" required class="form-control">
														</div>
													</div>
														<div class="col-md-4">
															<div class="form-group">
																<label for="" class="mb-2">Middle Name</label>
																<input type="text" required class="form-control">
															</div>
														</div>
														<div class="col-md-4">
															<div class="form-group">
																<label for="" class="mb-2">Last Name</label>
																<input type="text" required class="form-control">
															</div>
														</div>
													
														<div class="col-md-6 mt-2">
															<div class="form-group position-relative mb-4">
																<label for="" class="mb-2">Phone Number</label>
																<input type="text" class="form-control">
															
															</div>
														</div>
														<div class="col-md-6 mt-2">
															<div class="form-group position-relative mb-4">
																<label for="" class="mb-2">Email Address</label>
																<input type="text" class="form-control">
															
															</div>
														</div>
													</div>
												</div>
                                            </div>
											<div class="col-md-12">
												 <div class="fieldset">
													<div class="legend">Enter Buyer #2 Name *</div>
					
												<div class="row">
													<div class="col-md-4">
														<div class="form-group">
															<label for="" class="mb-2">First Name</label>
															<input type="text" required class="form-control">
														</div>
													</div>
														<div class="col-md-4">
															<div class="form-group">
																<label for="" class="mb-2">Middle Name</label>
																<input type="text" required class="form-control">
															</div>
														</div>
														<div class="col-md-4">
															<div class="form-group">
																<label for="" class="mb-2">Last Name</label>
																<input type="text" required class="form-control">
															</div>
														</div>
													
														<div class="col-md-6 mt-2">
															<div class="form-group position-relative mb-4">
																<label for="" class="mb-2">Phone Number</label>
																<input type="text" class="form-control">
															
															</div>
														</div>
														<div class="col-md-6 mt-2">
															<div class="form-group position-relative mb-4">
																<label for="" class="mb-2">Email Address</label>
																<input type="text" class="form-control">
															
															</div>
														</div>
													</div>
												</div>
                                            </div>
											
                                        </div>
										
									  
                                       
                                        <div class="form-group mb-3">
                                            <label for="" class="mb-2"><b>Forwarding Address after Closing</b></label>
                                            <ul class="list-inline">
                                                <li class="list-inline-item me-md-5">
                                                    <input type="radio" id="option11" value="same" name="forwardingAdd"> 
                                                    <label for="option11">Same as Property Address</label>
                                                </li>
                                                <li class="list-inline-item">
                                                    <input type="radio" id="option12" value="other" name="forwardingAdd"> 
                                                    <label for="option12">Other Address</label>
                                                </li>
                                            </ul>
                                            <div class="otherAddress d-none">
                                                <div class="form-group position-relative mb-3">
                                                    <label for="" class="mb-2"><b>Enter Forwarding Address After Closing </b></label>
                                                    <input type="text" class="form-control">
                                                    <small class="small_label">Street Address</small>
                                                </div>
                                                <div class="form-group position-relative mb-3">
                                                    <input type="text" class="form-control">
                                                    <small  class="small_label">Street Address Line 2</small>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="form-group position-relative mb-3">
                                                            <input type="text" class="form-control">
                                                            <small  class="small_label">City</small>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group position-relative mb-3">
                                                            <input type="text" class="form-control">
                                                            <small  class="small_label">State</small>
                                                        </div>
                                                    </div>    
                                                </div>
                                                <div class="form-group position-relative mb-3 col-md-6">
                                                    <input type="text" class="form-control">
                                                    <small  class="small_label">Zip Code</small>
                                                </div>
                                            </div>
                                        </div>
                                        
                                                                                
                                                                               

                                        </div>

                                       

                                       
                                    </div>
                                </div>
                        
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="headingTwo">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">(3) Escrow Instructions</button>
                                </h2>
                                <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo" data-bs-parent="#accordionExample">
                                    <div class="accordion-body">
                                        <div class="form-group mb-4">
                                            <label for="" class="mb-2"><b>Is there a Mortgage or equity line on the Property?</b></label>
                                            <ul class="list-inline">
                                                <li class="list-inline-item me-md-5">
                                                    <input type="radio" id="yesMortgage" value="yes" name="Mortgage"> 
                                                    <label for="yesMortgage">Yes</label>
                                                </li>
                                                <li class="list-inline-item">
                                                    <input type="radio" id="noMortgage" value="no" name="Mortgage"> 
                                                    <label for="noMortgage">No</label>
                                                </li>
                                            </ul>
                                        </div> 
                                        <div class="form-group mb-4">
                                            <label for="" class="mb-2"><b>Are there any other Liens on the Property?</b></label>
                                            <ul class="list-inline">
                                                <li class="list-inline-item me-md-5">
                                                    <input type="radio" id="yesLiens" value="yes" name="Liens"> 
                                                    <label for="yesLiens">Yes</label>
                                                </li>
                                                <li class="list-inline-item">
                                                    <input type="radio" id="noLiens" value="no" name="Liens"> 
                                                    <label for="noLiens">No</label>
                                                </li>
                                            </ul>
                                        </div>
                                        <div class="form-group mb-4">
                                            <label for="" class="mb-2"><b>Are there mandatory Homeowners or Condominium Associations?</b></label>
                                            <ul class="list-inline">
                                                <li class="list-inline-item me-md-5">
                                                    <input type="radio" id="yesCondominium" value="yes" name="Condominium"> 
                                                    <label for="yesCondominium">Yes</label>
                                                </li>
                                                <li class="list-inline-item">
                                                    <input type="radio" id="noCondominium" value="no" name="Condominium"> 
                                                    <label for="noCondominium">No</label>
                                                </li>
                                            </ul>
                                        </div>
                                        <div class="form-group mb-4">
                                            <label for="" class="mb-2"><b>Is this your primary residence / homestead property for tax purposes?</b></label>
                                            <ul class="list-inline">
                                                <li class="list-inline-item me-md-5">
                                                    <input type="radio" id="yesresidence" value="yes" name="residence"> 
                                                    <label for="yesresidence">Yes</label>
                                                </li>
                                                <li class="list-inline-item">
                                                    <input type="radio" id="noresidence" value="no" name="residence"> 
                                                    <label for="noresidence">No</label>
                                                </li>
                                            </ul>
                                        </div>
                                        <div class="form-group mb-4">
                                            <label for="" class="mb-2"><b>Has there been a divorce since the purchase of the property or are you currently in the process of getting divorced?</b></label>
                                            <ul class="list-inline">
                                                <li class="list-inline-item me-md-5">
                                                    <input type="radio" id="yesdivorced" value="yes" name="divorced"> 
                                                    <label for="yesdivorced">Yes</label>
                                                </li>
                                                <li class="list-inline-item">
                                                    <input type="radio" id="nodivorced" value="no" name="divorced"> 
                                                    <label for="nodivorced">No</label>
                                                </li>
                                            </ul>
                                            <div class="errorMsg text-danger d-none">Please provide a copy of the divorce decree or marriage settlement agreement.</div>
                                        </div>
                                        <div class="form-group mb-4">
                                            <label for="" class="mb-2"><b>Has your name changed since purchasing the Property?
                                            </b></label>
                                            <ul class="list-inline">
                                                <li class="list-inline-item me-md-5">
                                                    <input type="radio" id="yeschanged" value="yes" name="changed"> 
                                                    <label for="yeschanged">Yes</label>
                                                </li>
                                                <li class="list-inline-item">
                                                    <input type="radio" id="nochanged" value="no" name="changed"> 
                                                    <label for="nochanged">No</label>
                                                </li>
                                            </ul>
                                            <div class="errorMsg text-danger d-none">Please provide a copy of the marriage certificate or other legal document showing name change. </div>
                                        </div>
                                        <div class="form-group mb-4">
                                            <label for="" class="mb-2"><b>Has there been a death of an owner since taking title to the Property?
                                            </b></label>
                                            <ul class="list-inline">
                                                <li class="list-inline-item me-md-5">
                                                    <input type="radio" id="yesdeath" value="yes" name="death"> 
                                                    <label for="yesdeath">Yes</label>
                                                </li>
                                                <li class="list-inline-item">
                                                    <input type="radio" id="nodeath" value="no" name="death"> 
                                                    <label for="nodeath">No</label>
                                                </li>
                                            </ul>
                                            <div class="errorMsg text-danger d-none">We will need a certified copy of the original death certificate for recordation, The original death certificate will be returned after closing. 
                                            </div>
                                        </div>
                                        <div class="form-group mb-4">
                                            <label for="" class="mb-2"><b>Do you have an existing survey for the Property?</b></label>
                                            <ul class="list-inline">
                                                <li class="list-inline-item me-md-5">
                                                    <input type="radio" id="yessurvey" value="yes" name="survey"> 
                                                    <label for="yessurvey">Yes</label>
                                                </li>
                                                <li class="list-inline-item me-md-5">
                                                    <input type="radio" id="nosurvey" value="no" name="survey"> 
                                                    <label for="nosurvey">No</label>
                                                </li>
                                                <li class="list-inline-item">
                                                    <input type="radio" id="na" value="no" name="survey"> 
                                                    <label for="na">N/A - Property is a Condominium</label>
                                                </li>
                                            </ul>
                                            <div class="errorMsg d-none">
                                                <div class="text-danger mb-3"> Please provide a copy of the existing survey to our office.</div>
                                                <label for="" class="mb-2"><b>Has there been any structural changes or improvements to the Property since the date of the Survey (such as new construction, fences, pools, driveways, etc.)?</b></label>
                                                <ul class="list-inline">
                                                    <li class="list-inline-item me-md-5">
                                                        <input type="radio" id="yesstructural" value="yes" name="structural"> 
                                                        <label for="yesstructural">Yes</label>
                                                    </li>
                                                    <li class="list-inline-item">
                                                        <input type="radio" id="nostructural" value="no" name="structural"> 
                                                        <label for="nostructural">No</label>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                        <div class="form-group mb-4">
                                            <label for="" class="mb-2"><b>Do you have an existing Owner's Title Insurance Policy for the Property? (Note: Depending on your Sales Contract, the Seller could be penalized $150.00 for not delivering their current owner's title insurance policy to the Buyer within 10 days of the effective date of the Sales Contract.)</b></label>
                                            <ul class="list-inline">
                                                <li class="list-inline-item me-md-5">
                                                    <input type="radio" id="yesInsurance" value="yes" name="Insurance"> 
                                                    <label for="yesInsurance">Yes</label>
                                                </li>
                                                <li class="list-inline-item">
                                                    <input type="radio" id="noInsurance" value="no" name="Insurance"> 
                                                    <label for="noInsurance">No</label>
                                                </li>
                                            </ul>
                                            <div class="text-danger d-none errorMsg">Please provide a copy of the existing Owner'sTitle Insurance Policy to our office.</div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="form-group mb-4">
                                                    <label for="" class="mb-2"><b>Water Service (Please Check One): </b></label>
                                                    <ul class="list-unstyled">
                                                        <li>
                                                            <input type="radio" id="City" value="City" name="waterService"> 
                                                            <label for="City">City</label>
                                                        </li>
                                                        <li>
                                                            <input type="radio" id="County" value="County" name="waterService"> 
                                                            <label for="County">County</label>
                                                        </li>
                                                        <li>
                                                            <input type="radio" id="FGUA" value="FGUA" name="waterService"> 
                                                            <label for="FGUA">FGUA</label>
                                                        </li>
                                                        <li>
                                                            <input type="radio" id="Septic" value="Septic" name="waterService"> 
                                                            <label for="Septic">Well / Septic</label>
                                                        </li>
                                                        <li>
                                                            <input type="radio" id="County" value="County" name="waterService"> 
                                                            <label for="County"><input type="text" class="form-control" placeholder="Other"></label>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group mb-4">
                                                    <label for="" class="mb-2">Water Service Provider Name</label>
                                                    <input type="text" class="form-control">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="headingThree">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">   (4) Statement of Information</button>
                                </h2>
                                <div id="collapseThree" class="accordion-collapse collapse" aria-labelledby="headingThree" data-bs-parent="#accordionExample">
                                    <div class="accordion-body">
                                        <div class="form-group mb-4">
                                            <label for="" class="mb-2"><b>How would you like to receive the sale proceeds after closing?</b></label>
                                            <ul class="list-unstyled">
                                                <li>
                                                    <input type="radio" id="wire" value="wire" name="saleProceeds"> 
                                                    <label for="wire">Wire Funds</label>
                                                </li>
                                                <li>
                                                    <input type="radio" id="pickUp" value="pickUp" name="saleProceeds"> 
                                                    <label for="pickUp">Pick Up Check</label>
                                                </li>
                                                <li>
                                                    <input type="radio" id="mailCheck" value="mailCheck" name="saleProceeds"> 
                                                    <label for="mailCheck">Mail Check</label>
                                                </li>
                                            </ul>
                                            <div class="mailAddress d-none">
                                                <div class="form-group position-relative mb-3">
                                                    <label for="" class="mb-2"><b>Address Closing Proceeds to be Mailed To
                                                    </b></label>
                                                    <input type="text" class="form-control">
                                                    <small class="small_label">Street Address</small>
                                                </div>
                                                <div class="form-group position-relative mb-3">
                                                    <input type="text" class="form-control">
                                                    <small  class="small_label">Street Address Line 2</small>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="form-group position-relative mb-3">
                                                            <input type="text" class="form-control">
                                                            <small  class="small_label">City</small>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group position-relative mb-3">
                                                            <input type="text" class="form-control">
                                                            <small  class="small_label">State / Province</small>
                                                        </div>
                                                    </div>    
                                                </div>
                                                <div class="form-group position-relative mb-3 col-md-6">
                                                    <input type="text" class="form-control">
                                                    <small  class="small_label">Postal / Zip Code</small>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="accordion-item d-none" id="wireInstructions">
                                <h2 class="accordion-header" id="headingFour">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFour" aria-expanded="false" aria-controls="collapseFour">
                                        WIRE INSTRUCTIONS
                                    </button>
                                </h2>
                                <div id="collapseFour" class="accordion-collapse collapse" aria-labelledby="headingFour" data-bs-parent="#accordionExample">
                                    <div class="accordion-body">
                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="form-group mb-4">
                                                    <label for="" class="mb-2">Name On Account</label>
                                                    <input type="text" class="form-control">
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group mb-4">
                                                    <label for="" class="mb-2">Bank Name</label>
                                                    <input type="text" class="form-control">
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group mb-4">
                                                    <label for="" class="mb-2">Bank City</label>
                                                    <input type="text" class="form-control">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="form-group mb-4">
                                                    <label for="" class="mb-2">Bank State</label>
                                                    <input type="text" class="form-control">
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group mb-4">
                                                    <label for="" class="mb-2">Account Number</label>
                                                    <input type="text" class="form-control">
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group mb-4">
                                                    <label for="" class="mb-2">Routing Number</label>
                                                    <input type="text" class="form-control">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="mailAddress">
                                            <div class="form-group position-relative mb-3">
                                                <label for="" class="mb-2"><b>Address Associated with Account Number
                                                </b></label>
                                                <input type="text" class="form-control">
                                                <small class="small_label">Street Address</small>
                                            </div>
                                            <div class="form-group position-relative mb-3">
                                                <input type="text" class="form-control">
                                                <small  class="small_label">Street Address Line 2</small>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group position-relative mb-3">
                                                        <input type="text" class="form-control">
                                                        <small  class="small_label">City</small>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group position-relative mb-3">
                                                        <input type="text" class="form-control">
                                                        <small  class="small_label">State / Province</small>
                                                    </div>
                                                </div>    
                                            </div>
                                            <div class="form-group position-relative mb-3 col-md-6">
                                                <input type="text" class="form-control">
                                                <small  class="small_label">Postal / Zip Code</small>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="accordion-item d-none" id="mortgage">
                                <h2 class="accordion-header" id="headingFive">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFive" aria-expanded="false" aria-controls="collapseFive">
                                        Mortgage Information
                                    </button>
                                </h2>
                                <div id="collapseFive" class="accordion-collapse collapse" aria-labelledby="headingFive" data-bs-parent="#accordionExample">
                                    <div class="accordion-body">
                                        <h5><b>Please provide for all loans/mortgages against the property, including lines of credit, even if it has a zero balance.</b></h5>
                                        <div class="text-danger mb-4">Note that you should continue to make mortgage payments that are due and payable prior to closing. Do not close (freeze) any lines of credit prior to closing
                                        </div>

                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group mb-4">
                                                    <label for="" class="mb-2">1st Bank / Mortgage Company</label>
                                                    <input type="text" class="form-control">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="form-group mb-4">
                                                    <label for="" class="mb-2">Loan Number</label>
                                                    <input type="text" class="form-control">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group mb-3">
                                                    <label for="" class="mb-2">Phone Number</label>
                                                    <div class="row">
                                                        <div class="col-4 position-relative">
                                                            <input type="text" class="form-control">
                                                            <small class="small_label">Area Code</small>
                                                        </div>
                                                        <div class="col-8 position-relative">
                                                            <input type="text" class="form-control">
                                                            <small class="small_label">Phone Number</small>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <hr>

                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group mb-4">
                                                    <label for="" class="mb-2">2nd Bank / Mortgage Company</label>
                                                    <input type="text" class="form-control">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="form-group mb-4">
                                                    <label for="" class="mb-2">Loan Number</label>
                                                    <input type="text" class="form-control">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group mb-3">
                                                    <label for="" class="mb-2">Phone Number</label>
                                                    <div class="row">
                                                        <div class="col-4 position-relative">
                                                            <input type="text" class="form-control">
                                                            <small class="small_label">Area Code</small>
                                                        </div>
                                                        <div class="col-8 position-relative">
                                                            <input type="text" class="form-control">
                                                            <small class="small_label">Phone Number</small>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <hr>
                                        
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group mb-4">
                                                    <label for="" class="mb-2">3rd Bank / Mortgage Company</label>
                                                    <input type="text" class="form-control">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="form-group mb-4">
                                                    <label for="" class="mb-2">Loan Number</label>
                                                    <input type="text" class="form-control">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group mb-3">
                                                    <label for="" class="mb-2">Phone Number</label>
                                                    <div class="row">
                                                        <div class="col-4 position-relative">
                                                            <input type="text" class="form-control">
                                                            <small class="small_label">Area Code</small>
                                                        </div>
                                                        <div class="col-8 position-relative">
                                                            <input type="text" class="form-control">
                                                            <small class="small_label">Phone Number</small>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                            <div class="accordion-item d-none" id="lien">
                                <h2 class="accordion-header" id="headingSix">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseSix" aria-expanded="false" aria-controls="collapseSix">
                                  Other Lien Information
                                    </button>
                                </h2>
                                <div id="collapseSix" class="accordion-collapse collapse" aria-labelledby="headingSix" data-bs-parent="#accordionExample">
                                    <div class="accordion-body">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group mb-4">
                                                    <label for="" class="mb-2">Lienholder Name</label>
                                                    <input type="text" class="form-control">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group mb-4">
                                                    <label for="" class="mb-2">Amount Owed</label>
                                                    <input type="text" class="form-control">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group mb-4">
                                                    <label for="" class="mb-2">Lienholder Name</label>
                                                    <input type="text" class="form-control">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group mb-4">
                                                    <label for="" class="mb-2">Amount Owed</label>
                                                    <input type="text" class="form-control">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="accordion-item d-none" id="association">
                                <h2 class="accordion-header" id="headingSeven">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseSeven" aria-expanded="false" aria-controls="collapseSeven">
                                      (4) Association Information
                                    </button>
                                </h2>
                                <div id="collapseSeven" class="accordion-collapse collapse" aria-labelledby="headingSeven" data-bs-parent="#accordionExample">
                                    <div class="accordion-body">
                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="form-group mb-4">
                                                    <label for="" class="mb-2">Condominium / Homeowners Association 1</label>
                                                    <input type="text" class="form-control">
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group mb-4">
                                                    <label for="" class="mb-2">Property Management Company</label>
                                                    <input type="text" class="form-control">
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group mb-4">
                                                    <label for="" class="mb-2">Property Management Number</label>
                                                    <input type="text" class="form-control">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="form-group mb-4">
                                                    <label for="" class="mb-2">Condominium / Homeowners Association 2</label>
                                                    <input type="text" class="form-control">
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group mb-4">
                                                    <label for="" class="mb-2">Property Management Company</label>
                                                    <input type="text" class="form-control">
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group mb-4">
                                                    <label for="" class="mb-2">Property Management Number</label>
                                                    <input type="text" class="form-control">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="headingEight">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseEight" aria-expanded="false" aria-controls="collapseEight">
                                       (5) Vesting Form
                                    </button>
                                </h2>
                                <div id="collapseEight" class="accordion-collapse collapse" aria-labelledby="headingEight" data-bs-parent="#accordionExample">
                                    <div class="accordion-body">
                                        <h6 class="text-center"><b>AFFILIATED BUSINESS ARRANGEMENT DISCLOSURE STATEMENT</b></h6>
                                        To ("Seller"),  <br><br>

                                        From: THE TITLE COMPANY <br><br>

                                        Property Address: (Fill in from Title Production Software) <br><br> 

                                        This is an example of the ABA agreement.  It could also be another type of agreement. <br><br> 
                                        <b>Fees</b>
                                        <table class="table_fee_table">
                                            <tr>
                                                <td>Closing / Settlment Fees</td>
                                                <th>$250.00</th>
                                            </tr>
                                            <tr>
                                                <td>Owner's Title Insurance Policy</td>
                                                <th>Promulgated Rate</th>
                                            </tr>
                                            <tr>
                                                <td>Title Search Fee</td>
                                                <th>$75.00</th>
                                            </tr>
                                            <tr>
                                                <td>Electronic Signing / Remote Online Notarization Fee</td>
                                                <th>$150.00</th>
                                            </tr>
                                        </table>
                                        	
                                        <label for="" class="my-3"><b>Affiliated Business Arrangement Disclosure Statement <span>*</span></b></label>
                                        	
                                        <div class="form-group d-flex">
                                            <input type="checkbox" id="acknowledge" class="me-2 mt-1">
                                            <label for="acknowledge" class="mb-2 text-danger">I (we) the undersigned acknowledge that we have read and received a copy of this disclosure form and understand that THE TITLE COMPANY is referring me/us to purchase the above described service(s) and may receive a financial or other benefit as the result of that referral.</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="headingNine">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseNine" aria-expanded="false" aria-controls="collapseNine">
                                       (6) Preliminary Change of Ownership
                                    </button>
                                </h2>
                                <div id="collapseNine" class="accordion-collapse collapse" aria-labelledby="headingNine" data-bs-parent="#accordionExample">
                                    <div class="accordion-body">
                                        <label for="" class="my-3"><b>Third Party Authorization <span>*</span></b></label>
                                        	
                                        <div class="form-group d-flex">
                                                <input type="checkbox" id="acknowledge" class="me-2 mt-1">
                                                <label for="acknowledge" class="mb-2 text-danger">I authorize THE TITLE COMPANY to request and receive documentation from third parties to include payoff information from lender(s) and associatons listed above. I further authorize TITLE COMPANY to block / freeze my equity line, if applicable, and to utilize my signature below for such purpose.</label>
                                        </div>
                                    </div>
                                        
                                </div>
                            </div>
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="headingTen">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTen" aria-expanded="false" aria-controls="collapseTen">
                                       (7) Preliminary Report Approval
                                    </button>
                                </h2>
                                <div id="collapseTen" class="accordion-collapse collapse" aria-labelledby="headingTen" data-bs-parent="#accordionExample">
                                    <div class="accordion-body">
                                        <div class="form-group d-flex mb-2">
                                            <input type="checkbox" id="acknowledge" class="me-2 mt-1">
                                            <label for="acknowledge" class="mb-2">By clicking the submit button, I agree to terms & conditions.</label>
                                        </div>
                                        <div class="border text-danger p-3">
                                            IMPORTANT NOTICE: Cyber criminals are preying on those involved in real estate transactions. They will hack email accounts, spoof email addresses, and send emails with fake wiring or fake funds delivery instructions. These emails are convincing and sophisticated. Always independently confirm wiring and funding instructions in person or by telephone to our published office phone number of record. Never wire money without double-checking, in person or by telephone that the wiring instructions are correct. BE SKEPTICAL AND VIGILANT. 
                                        </div>
                                        <hr>

                                        <div class="form-group mb-4">
                                            <label for="" class="mb-2"><b>Signature</b></label>
                                            <textarea name="" id="" class="form-control h-auto" rows="5"></textarea>
                                            <a href="javascript:;" class="text-body text-end"> Clear</a>
                                        </div>

                                        <div class="d-flex align-items-center justify-content-center">
                                            <button class="btn-secondary btn me-3">Save</button>
                                            <button class="btn-primary btn">Submit</button>
                                        </div>

                                        <div class="row mt-5">
                                            <div class="col-md-4">
                                                <div class="form-group mb-3">
                                                    <label for="" class="mb-2"><b>TenantID</b></label>
                                                    <input type="text" class="form-control">
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group mb-3">
                                                    <label for="" class="mb-2"><b>DocType</b></label>
                                                    <input type="text" class="form-control">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
							<div class="accordion-item">
                                <h2 class="accordion-header" id="headingEleven">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseEleven" aria-expanded="false" aria-controls="collapseEleven">
                                        (8) NHD Receipt
                                    </button>
                                </h2>
                                <div id="collapseEleven" class="accordion-collapse collapse" aria-labelledby="headingEleven" data-bs-parent="#accordionExample">
                                    <div class="accordion-body">
                                        <div class="form-group d-flex mb-2">
                                            <input type="checkbox" id="acknowledge" class="me-2 mt-1">
                                            <label for="acknowledge" class="mb-2">By clicking the submit button, I agree to terms & conditions.</label>
                                        </div>
                                        <div class="border text-danger p-3">
                                            IMPORTANT NOTICE: Cyber criminals are preying on those involved in real estate transactions. They will hack email accounts, spoof email addresses, and send emails with fake wiring or fake funds delivery instructions. These emails are convincing and sophisticated. Always independently confirm wiring and funding instructions in person or by telephone to our published office phone number of record. Never wire money without double-checking, in person or by telephone that the wiring instructions are correct. BE SKEPTICAL AND VIGILANT. 
                                        </div>
                                        <hr>

                                        <div class="form-group mb-4">
                                            <label for="" class="mb-2"><b>Signature</b></label>
                                            <textarea name="" id="" class="form-control h-auto" rows="5"></textarea>
                                            <a href="javascript:;" class="text-body text-end"> Clear</a>
                                        </div>

                                        <div class="d-flex align-items-center justify-content-center">
                                            <button class="btn-secondary btn me-3">Save</button>
                                            <button class="btn-primary btn">Submit</button>
                                        </div>

                                        <div class="row mt-5">
                                            <div class="col-md-4">
                                                <div class="form-group mb-3">
                                                    <label for="" class="mb-2"><b>TenantID</b></label>
                                                    <input type="text" class="form-control">
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group mb-3">
                                                    <label for="" class="mb-2"><b>DocType</b></label>
                                                    <input type="text" class="form-control">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            
            
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>

    <script src="<?php echo base_url();?>assets/frontend/js/order/jquery.min.js"></script>
    <script src="<?php echo base_url();?>assets/frontend/js/order/bootstrap.bundle.min.js"></script>
    <script src="<?php echo base_url();?>assets/frontend/js/order/script.js"></script>
    <script src="<?php echo base_url();?>assets/frontend/js/order/signature_pad.min.js"></script>
</body>
</html>