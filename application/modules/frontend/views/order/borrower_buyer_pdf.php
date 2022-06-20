<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0"> 
</head>


<body class="">

    <header>
        <div class="container">
            <div class="row align-items-center">
                <div class="col-6">
                    <a href="#"><img src="<?php echo base_url();?>assets/frontend/images/buyer-seller-package/alanna-logo.png" alt="..." class="img-fluid img_logo"></a>
                </div>
                
            </div>
        </div>
    </header>

    <section class="form_content">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <!-- <p class="mb-5">
                        This is an example of a Buyer Welcome Package.
                    </p> -->
                    
                    <form name="borrower_buyer_form" id="borrower_buyer_form">
                        <h2 class="blue_title">Buyer Opening Package<br><span style="font-size:16px; padding-top:15px;">Property Address: <?php echo $orderDetails['full_address'];?></span><br><span style="font-size:16px; padding-top:15px;">APN:<?php echo $orderDetails['apn'];?></span></h2>
                        <div class="accordion" id="accordionExample">
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="headingOne">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne"><b>(1) Property Information</b></button>
                                </h2>
                                <div id="collapseOne" class="accordion-collapsed collapse" aria-labelledby="headingOne" data-bs-parent="#accordionExample">
                                    <div class="accordion-body">
                                        <div class="row mb-3">
                                            <div class="col-md-12">
                                                <div class="form-group position-relative mb-3 mt-3">
                                                    <label for="" class="mb-2"><b>Property Address Being Purchased</b></label>
                                                    <input type="text" class="form-control" id="property_address" name="property_address" value="<?php echo $property_address;?>">
                                                    <small class="small_label">Street Address</small>
                                                </div>

                                               

                                                <div class="form-group position-relative mb-3">
                                                    <input type="text" class="form-control" id="property_address2" name="property_address2" value="<?php echo $property_address2;?>">
                                                    <small  class="small_label">Street Address Line 2</small>
                                                </div>
                                                

												<div class="row">
                                                    <div class="col-md-6">
                                                        <div class="form-group position-relative mb-3">
                                                            <input type="text" class="form-control" id="property_city" name="property_city" id="property_city" name="property_city" value="<?php echo $property_city;?>">
                                                            <small  class="small_label">City</small>
                                                        </div>
                                                        
                                                    </div>

                                                    <div class="col-md-6">
                                                        <div class="form-group position-relative mb-3 ">
                                                            <input type="text" class="form-control" id="property_zipcode" name="property_zipcode" value="<?php echo $property_zip_code;?>">
                                                            <small  class="small_label">Zip Code</small>
                                                        </div>
                                                        
                                                    </div>
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
                                <div id="collapseThirteen" class="accordion-collapse collapse show" aria-labelledby="headingThirteen" data-bs-parent="#accordionExample">
                                    <div class="accordion-body">
                                        <div class="row mb-3">
                                            <div class="col-md-12">
                                                <div class="fieldset">
													<div class="legend">Enter Buyer #1 Name *</div>
                                                    <div class="row">
                                                        <div class="col-md-4">
                                                            <div class="form-group">
                                                                <label for="" class="mb-2">First Name</label>
                                                                <input type="text" class="form-control" id="first_name" name="first_name" value="<?php echo $first_name;?>">
                                                            </div>
                                                            
                                                        </div>
                                                        <div class="col-md-4">
                                                            <div class="form-group">
                                                                <label for="" class="mb-2">Middle Name</label>
                                                                <input type="text" class="form-control" id="middle_name" name="middle_name" value="<?php echo $middle_name;?>">
                                                            </div>
                                                            
                                                        </div>
                                                        <div class="col-md-4">
                                                            <div class="form-group">
                                                                <label for="" class="mb-2">Last Name</label>
                                                                <input type="text" class="form-control" id="last_name" name="last_name" value="<?php echo $last_name;?>">
                                                            </div>
                                                            
                                                        </div>
                                                    
                                                        <div class="col-md-6 mt-2">
                                                            <div class="form-group position-relative">
                                                                <label for="" class="mb-2">Phone Number</label>
                                                                <input type="text" class="form-control" id="phone_number" name="phone_number" value="<?php echo $phone_number;?>">
                                                                
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6 mt-2">
                                                            <div class="form-group position-relative">
                                                                <label for="" class="mb-2">Email Address</label>
                                                                <input type="text" class="form-control" id="email" name="email" value="<?php echo $email;?>">
                                                                
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
                                                                <input type="text" class="form-control" id="second_buyer_first_name" name="second_buyer_first_name" value="<?php echo $second_buyer_first_name;?>">
                                                            </div>
                                                            
                                                        </div>
                                                        <div class="col-md-4">
                                                            <div class="form-group">
                                                                <label for="" class="mb-2">Middle Name</label>
                                                                <input type="text" class="form-control" id="second_buyer_middle_name" name="second_buyer_middle_name" value="<?php echo $second_buyer_middle_name;?>">
                                                            </div>
                                                            
                                                        </div>
                                                        <div class="col-md-4">
                                                            <div class="form-group">
                                                                <label for="" class="mb-2">Last Name</label>
                                                                <input type="text" class="form-control" id="second_buyer_last_name" name="second_buyer_last_name" value="<?php echo $second_buyer_last_name;?>">
                                                            </div>
                                                            
                                                        </div>
                                                    
                                                        <div class="col-md-6 mt-2">
                                                            <div class="form-group position-relative mb-4">
                                                                <label for="" class="mb-2">Phone Number</label>
                                                                <input type="text" class="form-control" id="second_buyer_phone_number" name="second_buyer_phone_number" value="<?php echo $second_buyer_phone_number;?>">
                                                                
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6 mt-2">
                                                            <div class="form-group position-relative mb-4">
                                                                <label for="" class="mb-2">Email Address</label>
                                                                <input type="email" class="form-control" id="second_buyer_email" name="second_buyer_email" value="<?php echo $second_buyer_email;?>">
                                                                
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
                                                    <input type="radio" id="sameAddress" <?php echo ($is_same_property_address_as_forwarding_address == 'same') ? 'checked="checked"' : '';?> value="same" name="is_same_property_address_as_forwarding_address"> 
                                                    <label for="option11">   Same as Property Address</label>
                                                </li>
                                                <li class="list-inline-item">
                                                    <input type="radio" id="otherAddress" <?php echo ($is_same_property_address_as_forwarding_address == 'other') ? 'checked="checked"' : '';?> value="other" name="is_same_property_address_as_forwarding_address"> 
                                                    <label for="option12">   Other Address</label>
                                                </li>
                                            </ul>
                                            
                                            <div class="otherAddress <?php echo ($is_same_property_address_as_forwarding_address == 'other') ? '' : 'd-none';?>">
                                                <div class="form-group position-relative mb-3">
                                                    <label for="" class="mb-2"><b>Enter Forwarding Address After Closing </b></label>
                                                    <input type="text" class="form-control" id="forwarding_street_address" name="forwarding_street_address" value="<?php echo $forwarding_street_address;?>">
                                                    <small class="small_label">Street Address</small>
                                                </div>
                                                
                                                <div class="form-group position-relative mb-3">
                                                    <input type="text" class="form-control" id="forwarding_street_address2" name="forwarding_street_address2" value="<?php echo $forwarding_street_address2;?>">
                                                    <small  class="small_label">Street Address Line 2</small>
                                                </div>
                                                
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="form-group position-relative mb-3">
                                                            <input type="text" class="form-control" id="forwarding_city" name="forwarding_city" value="<?php echo $forwarding_city;?>">
                                                            <small  class="small_label">City</small>
                                                        </div>
                                                        
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group position-relative mb-3">
                                                            <input type="text" class="form-control" id="forwarding_state" name="forwarding_state" value="<?php echo $forwarding_state;?>">
                                                            <small  class="small_label">State</small>
                                                        </div>
                                                        
                                                    </div>    
                                                </div>
                                                <div class="form-group position-relative mb-3 col-md-6">
                                                    <input type="text" class="form-control" id="forwarding_zip_code" name="forwarding_zip_code" value="<?php echo $forwarding_zip_code;?>">
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
                                <div id="collapseTwo" class="accordion-collapse collapse show" aria-labelledby="headingTwo" data-bs-parent="#accordionExample">
                                    <div class="accordion-body">
                                        <div class="form-group mb-4">
                                            <label for="" class="mb-2"><b>Is there a Mortgage or equity line on the Property?</b></label>
                                            <ul class="list-inline mb-0">
                                                <li class="list-inline-item me-md-5">
                                                    <input  type="radio" id="yesMortgage" value="yes" <?php echo ($is_mortgage == 'yes') ? 'checked="checked"' : '';?> name="is_mortgage">&nbsp;&nbsp;&nbsp;
                                                    <label class="escrow_radio" for="yesMortgage">Yes</label>
                                                </li>
                                                <li class="list-inline-item">
                                                    <input  type="radio" id="noMortgage" <?php echo ($is_mortgage == 'no') ? 'checked="checked"' : '';?> value="no" name="is_mortgage">&nbsp;&nbsp;&nbsp;
                                                    <label class="escrow_radio" for="noMortgage">No</label>
                                                </li>
                                            </ul>
                                            
                                        </div> 
                                        <div class="form-group mb-4">
                                            <label for="" class="mb-2"><b>Are there any other Liens on the Property?</b></label>
                                            <ul class="list-inline mb-0">
                                                <li class="list-inline-item me-md-5">
                                                    <input type="radio" id="yesLiens" <?php echo ($is_liens == 'yes') ? 'checked="checked"' : '';?> value="yes" name="is_liens">&nbsp;&nbsp;&nbsp;
                                                    <label for="yesLiens">Yes</label>
                                                </li>
                                                <li class="list-inline-item">
                                                    <input type="radio" id="noLiens" <?php echo ($is_liens == 'no') ? 'checked="checked"' : '';?> value="no" name="is_liens">&nbsp;&nbsp;&nbsp;
                                                    <label for="noLiens">No</label>
                                                </li>
                                            </ul>
                                            
                                        </div>
                                        <div class="form-group mb-4">
                                            <label for="" class="mb-2"><b>Are there mandatory Homeowners or Condominium Associations?</b></label>
                                            <ul class="list-inline mb-0">
                                                <li class="list-inline-item me-md-5">
                                                    <input type="radio" id="yesCondominium" <?php echo ($is_condominium == 'yes') ? 'checked="checked"' : '';?> value="yes" name="is_condominium">&nbsp;&nbsp;&nbsp;
                                                    <label for="yesCondominium">Yes</label>
                                                </li>
                                                <li class="list-inline-item">
                                                    <input type="radio" id="noCondominium" <?php echo ($is_condominium == 'no') ? 'checked="checked"' : '';?> value="no" name="is_condominium">&nbsp;&nbsp;&nbsp;
                                                    <label for="noCondominium">No</label>
                                                </li>
                                            </ul>
                                            
                                        </div>
                                        <div class="form-group mb-4">
                                            <label for="" class="mb-2"><b>Is this your primary residence / homestead property for tax purposes?</b></label>
                                            <ul class="list-inline mb-0">
                                                <li class="list-inline-item me-md-5">
                                                    <input type="radio" id="yesresidence" <?php echo ($is_residence == 'yes') ? 'checked="checked"' : '';?> value="yes" name="is_residence">&nbsp;&nbsp;&nbsp;
                                                    <label for="yesresidence">Yes</label>
                                                </li>
                                                <li class="list-inline-item">
                                                    <input type="radio" id="noresidence" <?php echo ($is_residence == 'no') ? 'checked="checked"' : '';?> value="no" name="is_residence"> &nbsp;&nbsp;&nbsp;
                                                    <label for="noresidence">No</label>
                                                </li>
                                            </ul>
                                            
                                        </div>
                                        <div class="form-group mb-4">
                                            <label for="" class="mb-2"><b>Has there been a divorce since the purchase of the property or are you currently in the process of getting divorced?</b></label>
                                            <ul class="list-inline mb-0">
                                                <li class="list-inline-item me-md-5">
                                                    <input type="radio" id="yesdivorced" <?php echo ($is_divorced == 'yes') ? 'checked="checked"' : '';?> value="yes" name="is_divorced">&nbsp;&nbsp;&nbsp;
                                                    <label for="yesdivorced">Yes</label>
                                                </li>
                                                <li class="list-inline-item">
                                                    <input type="radio" id="nodivorced" <?php echo ($is_divorced == 'no') ? 'checked="checked"' : '';?> value="no" name="is_divorced">&nbsp;&nbsp;&nbsp;
                                                    <label for="nodivorced">No</label>
                                                </li>
                                            </ul>
                                            
                                            <div class="errorMsg text-danger d-none">Please provide a copy of the divorce decree or marriage settlement agreement.</div>
                                        </div>
                                        <div class="form-group mb-4">
                                            <label for="" class="mb-2"><b>Has your name changed since purchasing the Property?
                                            </b></label>
                                            <ul class="list-inline mb-0">
                                                <li class="list-inline-item me-md-5">
                                                    <input type="radio" id="yeschanged" <?php echo ($is_changed == 'yes') ? 'checked="checked"' : '';?> value="yes" name="is_changed">&nbsp;&nbsp;&nbsp;
                                                    <label for="yeschanged">Yes</label>
                                                </li>
                                                <li class="list-inline-item">
                                                    <input type="radio" id="nochanged" <?php echo ($is_changed == 'no') ? 'checked="checked"' : '';?> value="no" name="is_changed">&nbsp;&nbsp;&nbsp;
                                                    <label for="nochanged">No</label>
                                                </li>
                                            </ul>
                                            
                                            <div class="errorMsg text-danger d-none">Please provide a copy of the marriage certificate or other legal document showing name change. </div>
                                        </div>
                                        <div class="form-group mb-4">
                                            <label for="" class="mb-2"><b>Has there been a death of an owner since taking title to the Property?
                                            </b></label>
                                            <ul class="list-inline mb-0">
                                                <li class="list-inline-item me-md-5">
                                                    <input type="radio" id="yesdeath" value="yes" <?php echo ($is_death == 'yes') ? 'checked="checked"' : '';?> name="is_death">&nbsp;&nbsp;&nbsp;
                                                    <label for="yesdeath">Yes</label>
                                                </li>
                                                <li class="list-inline-item">
                                                    <input type="radio" id="nodeath" value="no" <?php echo ($is_death == 'no') ? 'checked="checked"' : '';?> name="is_death">&nbsp;&nbsp;&nbsp;
                                                    <label for="nodeath">No</label>
                                                </li>
                                            </ul>
                                            
                                            <div class="errorMsg text-danger d-none">We will need a certified copy of the original death certificate for recordation, The original death certificate will be returned after closing. 
                                            </div>
                                        </div>
                                        <div class="form-group mb-4">
                                            <label for="" class="mb-2"><b>Do you have an existing survey for the Property?</b></label>
                                            <ul class="list-inline mb-0">
                                                <li class="list-inline-item me-md-5">
                                                    <input type="radio" id="yessurvey" value="yes" name="is_survey" <?php echo ($is_survey == 'yes') ? 'checked="checked"' : '';?>>&nbsp;&nbsp;&nbsp;
                                                    <label for="yessurvey">Yes</label>
                                                </li>
                                                <li class="list-inline-item me-md-5">
                                                    <input type="radio" id="nosurvey" value="no" name="is_survey" <?php echo ($is_survey == 'no') ? 'checked="checked"' : '';?>>&nbsp;&nbsp;&nbsp;
                                                    <label for="nosurvey">No</label>
                                                </li>
                                                <li class="list-inline-item">
                                                    <input type="radio" id="na" value="n/a" name="is_survey" <?php echo ($is_survey == 'n/a') ? 'checked="checked"' : '';?>>&nbsp;&nbsp;&nbsp;
                                                    <label for="na">N/A - Property is a Condominium</label>
                                                </li>
                                            </ul>
                                            
                                            <div class="errorMsg d-none">
                                                <div class="text-danger mb-3"> Please provide a copy of the existing survey to our office.</div>
                                                <label for="" class="mb-2"><b>Has there been any structural changes or improvements to the Property since the date of the Survey (such as new construction, fences, pools, driveways, etc.)?</b></label>
                                                <ul class="list-inline mb-0">
                                                    <li class="list-inline-item me-md-5">
                                                        <input type="radio" id="yesstructural" value="yes" name="is_structural" <?php echo ($is_structural == 'yes') ? 'checked="checked"' : '';?>>&nbsp;&nbsp;&nbsp;
                                                        <label for="yesstructural">Yes</label>
                                                    </li>
                                                    <li class="list-inline-item">
                                                        <input type="radio" id="nostructural" value="no" name="is_structural" <?php echo ($is_structural == 'no') ? 'checked="checked"' : '';?>>&nbsp;&nbsp;&nbsp;
                                                        <label for="nostructural">No</label>
                                                    </li>
                                                </ul>
                                                
                                            </div>
                                        </div>
                                        <div class="form-group mb-4">
                                            <label for="" class="mb-2"><b>Do you have an existing Owner's Title Insurance Policy for the Property? (Note: Depending on your Sales Contract, the Seller could be penalized $150.00 for not delivering their current owner's title insurance policy to the Buyer within 10 days of the effective date of the Sales Contract.)</b></label>
                                            <ul class="list-inline mb-0">
                                                <li class="list-inline-item me-md-5">
                                                    <input type="radio" id="yesInsurance" value="yes" name="is_insurance" <?php echo ($is_insurance == 'yes') ? 'checked="checked"' : '';?>>&nbsp;&nbsp;&nbsp;  
                                                    <label for="yesInsurance">Yes</label>
                                                </li>
                                                <li class="list-inline-item">
                                                    <input type="radio" id="noInsurance" value="no" name="is_insurance" <?php echo ($is_insurance == 'no') ? 'checked="checked"' : '';?>>&nbsp;&nbsp;&nbsp;
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
                                                            <input type="radio" id="City" value="City" name="water_service" <?php echo ($water_service == 'City') ? 'checked="checked"' : '';?>>&nbsp;&nbsp;&nbsp;
                                                            <label for="City">City</label>
                                                        </li>
                                                        <li>
                                                            <input type="radio" id="County" value="County" name="water_service" <?php echo ($water_service == 'County') ? 'checked="checked"' : '';?>>&nbsp;&nbsp;&nbsp;
                                                            <label for="County">County</label>
                                                        </li>
                                                        <li>
                                                            <input type="radio" id="FGUA" value="FGUA" name="water_service" <?php echo ($water_service == 'FGUA') ? 'checked="checked"' : '';?>>&nbsp;&nbsp;&nbsp;
                                                            <label for="FGUA">FGUA</label>
                                                        </li>
                                                        <li>
                                                            <input type="radio" id="Septic" value="Septic" name="water_service" <?php echo ($water_service == 'Septic') ? 'checked="checked"' : '';?>>&nbsp;&nbsp;&nbsp;
                                                            <label for="Septic">Well / Septic</label>
                                                        </li>
                                                        <li>
                                                            <input type="radio" id="other" value="other" name="water_service" <?php echo ($water_service == 'other') ? 'checked="checked"' : '';?>>&nbsp;&nbsp;&nbsp; 
                                                            <label for="County"><input type="text" class="form-control" placeholder="Other" id="other_water_service_name" name="other_water_service_name" value="<?php echo $other_water_service_name;?>"></label>
                                                        </li>
                                                        
                                                    </ul>
                                                   
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group mb-4">
                                                    <label for="" class="mb-2">Water Service Provider Name</label>
                                                    <input type="text" class="form-control" id="water_service_provider_name" name="water_service_provider_name" value="<?php echo $water_service_provider_name;?>">
                                                    
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="accordion-item <?php echo ($is_mortgage == 'yes') ? '' : 'd-none';?>" id="mortgage">
                                <h2 class="accordion-header" id="headingFive">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFive" aria-expanded="false" aria-controls="collapseFive">
                                        Mortgage Information
                                    </button>
                                </h2>
                                <div id="collapseFive" class="accordion-collapse collapse show" aria-labelledby="headingFive" data-bs-parent="#accordionExample">
                                    <div class="accordion-body">
                                        <h5><b>Please provide for all loans/mortgages against the property, including lines of credit, even if it has a zero balance.</b></h5>
                                        <div class="text-danger 
                                        mb-4">Note that you should continue to make mortgage payments that are due and payable prior to closing. Do not close (freeze) any lines of credit prior to closing
                                        </div>

                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group mb-4">
                                                    <label for="" class="mb-2">1st Bank / Mortgage Company</label>
                                                    <input type="text" class="form-control" id="first_mortgage_company" name="first_mortgage_company" value="<?php echo $first_mortgage_company;?>">
                                                    
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="form-group mb-4">
                                                    <label for="" class="mb-2">Loan Number</label>
                                                    <input type="text" class="form-control" id="first_mortgage_loan_number" name="first_mortgage_loan_number" value="<?php echo $first_mortgage_loan_number;?>">
                                                    
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group mb-3">
                                                    <label for="" class="mb-2">Phone Number</label>
                                                    <div class="row">
                                                        <div class="col-4 position-relative mb-3">
                                                            <input type="text" class="form-control" id="first_mortgage_area_code" name="first_mortgage_area_code" value="<?php echo $first_mortgage_area_code;?>">
                                                            <small class="small_label">Area Code</small>
                                                        </div>
                                                        
                                                        <div class="col-8 position-relative mb-3">
                                                            <input type="text" class="form-control" id="first_mortgage_phone_number" name="first_mortgage_phone_number" value="<?php echo $first_mortgage_phone_number;?>">
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
                                                    <input type="text" class="form-control" id="second_mortgage_company" name="second_mortgage_company" value="<?php echo $second_mortgage_company;?>">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="form-group mb-4">
                                                    <label for="" class="mb-2">Loan Number</label>
                                                    <input type="text" class="form-control" id="second_mortgage_loan_number" name="second_mortgage_loan_number" value="<?php echo $second_mortgage_loan_number;?>">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group mb-3">
                                                    <label for="" class="mb-2">Phone Number</label>
                                                    <div class="row">
                                                        <div class="col-4 position-relative">
                                                            <input type="text" class="form-control" id="second_mortgage_area_code" name="second_mortgage_area_code" value="<?php echo $second_mortgage_area_code;?>">
                                                            <small class="small_label">Area Code</small>
                                                        </div>
                                                        <div class="col-8 position-relative">
                                                            <input type="text" class="form-control" id="second_mortgage_phone_number" name="second_mortgage_phone_number" value="<?php echo $second_mortgage_phone_number;?>">
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
                                                    <input type="text" class="form-control" id="third_mortgage_company" name="third_mortgage_company" value="<?php echo $third_mortgage_company;?>">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="form-group mb-4">
                                                    <label for="" class="mb-2">Loan Number</label>
                                                    <input type="text" class="form-control" id="third_mortgage_loan_number" name="third_mortgage_loan_number" value="<?php echo $third_mortgage_loan_number;?>">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group mb-3">
                                                    <label for="" class="mb-2">Phone Number</label>
                                                    <div class="row">
                                                        <div class="col-4 position-relative">
                                                            <input type="text" class="form-control" id="third_mortgage_area_code" name="third_mortgage_area_code" value="<?php echo $third_mortgage_area_code;?>">
                                                            <small class="small_label">Area Code</small>
                                                        </div>
                                                        <div class="col-8 position-relative">
                                                            <input type="text" class="form-control" id="third_mortgage_phone_number" name="third_mortgage_phone_number" value="<?php echo $third_mortgage_phone_number;?>">
                                                            <small class="small_label">Phone Number</small>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>

                            <div class="accordion-item <?php echo ($is_liens == 'yes') ? '' : 'd-none';?>" id="lien">
                                <h2 class="accordion-header" id="headingSix">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseSix" aria-expanded="false" aria-controls="collapseSix">
                                  Other Lien Information
                                    </button>
                                </h2>
                                <div id="collapseSix" class="accordion-collapse collapse show" aria-labelledby="headingSix" data-bs-parent="#accordionExample">
                                    <div class="accordion-body">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group mb-4">
                                                    <label for="" class="mb-2">Lienholder Name 1</label>
                                                    <input type="text" class="form-control" id="first_lien_holder_name" name="first_lien_holder_name" value="<?php echo $first_lien_holder_name;?>">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group mb-4">
                                                    <label for="" class="mb-2">Amount Owed 1</label>
                                                    <input type="text" class="form-control" id="first_amount_owed" name="first_amount_owed" value="<?php echo $first_amount_owed;?>">
                                                    
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group mb-4">
                                                    <label for="" class="mb-2">Lienholder Name 2</label>
                                                    <input type="text" class="form-control" id="second_lien_holder_name" name="second_lien_holder_name" value="<?php echo $second_lien_holder_name;?>">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group mb-4">
                                                    <label for="" class="mb-2">Amount Owed 2</label>
                                                    <input type="text" class="form-control" id="second_amount_owed" name="second_amount_owed" value="<?php echo $second_amount_owed;?>">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="accordion-item <?php echo ($is_condominium == 'yes') ? '' : 'd-none';?>" id="association">
                                <h2 class="accordion-header" id="headingSeven">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseSeven" aria-expanded="false" aria-controls="collapseSeven">
                                      Association Information
                                    </button>
                                </h2>
                                <div id="collapseSeven" class="accordion-collapse collapse show" aria-labelledby="headingSeven" data-bs-parent="#accordionExample">
                                    <div class="accordion-body">
                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="form-group mb-4">
                                                    <label for="" class="mb-2">Condominium / Homeowners Association 1</label>
                                                    <input type="text" class="form-control" id="first_homeowners_association" name="first_homeowners_association" value="<?php echo $first_homeowners_association;?>">
                                                    
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group mb-4">
                                                    <label for="" class="mb-2">Property Management Company</label>
                                                    <input type="text" class="form-control" id="first_property_management_company" name="first_property_management_company" value="<?php echo $first_property_management_company;?>">
                                                    
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group mb-4">
                                                    <label for="" class="mb-2">Property Management Number</label>
                                                    <input type="text" class="form-control" id="first_property_management_number" name="first_property_management_number" value="<?php echo $first_property_management_number;?>">
                                                    
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="form-group mb-4">
                                                    <label for="" class="mb-2">Condominium / Homeowners Association 2</label>
                                                    <input type="text" class="form-control" id="second_homeowners_association" name="second_homeowners_association" value="<?php echo $second_homeowners_association;?>">
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group mb-4">
                                                    <label for="" class="mb-2">Property Management Company</label>
                                                    <input type="text" class="form-control" id="second_property_management_company" name="second_property_management_company" value="<?php echo $second_property_management_company;?>">
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group mb-4">
                                                    <label for="" class="mb-2">Property Management Number</label>
                                                    <input type="text" class="form-control" id="second_property_management_number" name="second_property_management_number" value="<?php echo $second_property_management_number;?>">
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
                                <div id="collapseThree" class="accordion-collapse collapse show" aria-labelledby="headingThree" data-bs-parent="#accordionExample">
                                    <div class="accordion-body">
                                        <div class="form-group mb-4">
                                            <label for="" class="mb-2"><b>How would you like to receive the sale proceeds after closing?</b></label>
                                            <ul class="list-unstyled">
                                                <li>
                                                    <input type="radio" id="wire" value="wire" name="sale_proceeds" <?php echo ($sale_proceeds == 'wire') ? 'checked="checked"' : '';?>>&nbsp;&nbsp;&nbsp;  
                                                    <label for="wire">Wire Funds</label>
                                                </li>
                                                <li>
                                                    <input type="radio" id="pickUp" value="pickUp" name="sale_proceeds" <?php echo ($sale_proceeds == 'pickUp') ? 'checked="checked"' : '';?>>&nbsp;&nbsp;&nbsp;  
                                                    <label for="pickUp">Pick Up Check</label>
                                                </li>
                                                <li>
                                                    <input type="radio" id="mailCheck" value="mailCheck" name="sale_proceeds" <?php echo ($sale_proceeds == 'mailCheck') ? 'checked="checked"' : '';?>>&nbsp;&nbsp;&nbsp;  
                                                    <label for="mailCheck">Mail Check</label>
                                                </li>
                                            </ul>
                                            
                                            <div class="mailAddress <?php echo ($sale_proceeds == 'mailCheck') ? '' : 'd-none';?>">
                                                <div class="form-group position-relative mb-3">
                                                    <label for="" class="mb-2"><b>Address Closing Proceeds to be Mailed To
                                                    </b></label>
                                                    <input type="text" class="form-control" id="closing_proceeds_street_address" name="closing_proceeds_street_address" value="<?php echo $closing_proceeds_street_address;?>">
                                                    <small class="small_label">Street Address</small>
                                                </div>
                                                
                                                <div class="form-group position-relative mb-3">
                                                    <input type="text" class="form-control" id="closing_proceeds_street_address2" name="closing_proceeds_street_address2" value="<?php echo $closing_proceeds_street_address2;?>">
                                                    <small  class="small_label">Street Address Line 2</small>
                                                </div>
                                                
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="form-group position-relative mb-3">
                                                            <input type="text" class="form-control" id="closing_proceeds_city" name="closing_proceeds_city" value="<?php echo $closing_proceeds_city;?>">
                                                            <small  class="small_label">City</small>
                                                        </div>
                                                        
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group position-relative mb-3">
                                                            <input type="text" class="form-control" id="closing_proceeds_state" name="closing_proceeds_state" value="<?php echo $closing_proceeds_state;?>">
                                                            <small  class="small_label">State / Province</small>
                                                        </div>
                                                        
                                                    </div>    
                                                </div>
                                                <div class="form-group position-relative mb-3 col-md-6">
                                                    <input type="text" class="form-control" id="closing_proceeds_zipcode" name="closing_proceeds_zipcode" value="<?php echo $closing_proceeds_zipcode;?>">
                                                    <small  class="small_label">Postal / Zip Code</small>
                                                </div>
                                                
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="accordion-item <?php echo ($sale_proceeds == 'wire') ? '' : 'd-none';?>" id="wireInstructions">
                                <h2 class="accordion-header" id="headingFour">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFour" aria-expanded="false" aria-controls="collapseFour">
                                        WIRE INSTRUCTIONS
                                    </button>
                                </h2>
                                <div id="collapseFour" class="accordion-collapse collapse show" aria-labelledby="headingFour" data-bs-parent="#accordionExample">
                                    <div class="accordion-body">
                                        <div class="row mb-4">
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="" class="mb-2">Name On Account</label>
                                                    <input type="text" class="form-control" id="name_on_account" name="name_on_account" value="<?php echo $name_on_account;?>">
                                                </div>
                                                
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="" class="mb-2">Bank Name</label>
                                                    <input type="text" class="form-control" id="bank_name" name="bank_name" value="<?php echo $bank_name;?>">
                                                </div>
                                                
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="" class="mb-2">Bank City</label>
                                                    <input type="text" class="form-control" id="bank_city" name="bank_city" value="<?php echo $bank_city;?>">
                                                </div>
                                                
                                            </div>
                                        </div>
                                        <div class="row mb-4">
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="" class="mb-2">Bank State</label>
                                                    <input type="text" class="form-control" id="bank_state" name="bank_state" value="<?php echo $bank_state;?>">
                                                </div>
                                                
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="" class="mb-2">Account Number</label>
                                                    <input type="text" class="form-control" id="account_number" name="account_number" value="<?php echo $account_number;?>">
                                                </div>
                                                
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="" class="mb-2">Routing Number</label>
                                                    <input type="text" class="form-control" id="routing_number" name="routing_number" value="<?php echo $routing_number;?>">
                                                </div>
                                                
                                            </div>
                                        </div>
                                        <div class="mailAddress">
                                            <div class="form-group position-relative mb-3">
                                                <label for="" class="mb-2"><b>Address Associated with Account Number
                                                </b></label>
                                                <input type="text" class="form-control" id="street_address_for_account" name="street_address_for_account" value="<?php echo $street_address_for_account;?>">
                                                <small class="small_label">Street Address</small>
                                            </div>
                                            
                                            <div class="form-group position-relative mb-3">
                                                <input type="text" class="form-control" id="street_address2_for_account" name="street_address2_for_account" value="<?php echo $street_address2_for_account;?>">
                                                <small  class="small_label">Street Address Line 2</small>
                                            </div>
                                            
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group position-relative mb-3">
                                                        <input type="text" class="form-control" id="city_for_account" name="city_for_account" value="<?php echo $city_for_account;?>">
                                                        <small  class="small_label">City</small>
                                                    </div>
                                                    
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group position-relative mb-3">
                                                        <input type="text" class="form-control" id="state_for_account" name="state_for_account" value="<?php echo $state_for_account;?>">
                                                        <small  class="small_label">State / Province</small>
                                                    </div>
                                                    
                                                </div>    
                                            </div>
                                            <div class="form-group position-relative mb-3 col-md-6">
                                                <input type="text" class="form-control" id="zipcode_for_account" name="zipcode_for_account" value="<?php echo $zipcode_for_account;?>">
                                                <small  class="small_label">Postal / Zip Code</small>
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
                                <div id="collapseEight" class="accordion-collapse collapse show" aria-labelledby="headingEight" data-bs-parent="#accordionExample">
                                    <div class="accordion-body">
                                        <div class="page">
                                            <div class="row mt-5">
                                                <div class="col-md-6">
                                                    <div class="to_address md-mb-0 mb-4">
                                                        <span>TO:</span>
                                                        <b>Pacific Coast Title Company
                                                            Madonna Pallan
                                                            516 Burchett St.
                                                            Glendale, CA  91203  </b>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="date_escrow_num md-ms-auto">
                                                        <span>DATE: </span>February 11, 2022<br>
                                                        <span>ESCROW NO.: </span>10257432-GLE-MP<br>
                                                        <span>TITLE NO.: </span>10257432-GLT-<br>
                                                        <span>PROPERTY ADDRESS: </span> Lots/APN: 210-021-30-00-1 and 210-021-29-00-9, Bakersfield, CA  93301
                                                    </div>
                                                </div>
                                            </div>
                                            <h2 class="text-center my-4"><strong>PRELIMINARY REPORT APPROVAL</strong></h2>
                                            <p>
                                                I have read the Preliminary Report dated <span class="text_red">FEBRUARY 2, 2022</span> covering the property described in your above numbered escrow, and approve the Policy of Title Insurance to be issued to me as required by my instructions to include as encumbrances therein Item Nos. 1, 4-9 of said report, in addition, to those specific items described in my escrow instructions or created by me. Legal description is also hereby approved.
                                            </p>
                                            <p>
                                                [Buyer acknowledges receipt of CC&amp;Rs.]
                                            </p>
                                            <p>
                                                [I hereby acknowledge receipt of copy of said Preliminary Report and the report has satisfied, or by this acknowledgement we waive, the condition as listed under Paragraph 13A of the purchase agreement.]
                                            </p>
                                            <div class="mb-80">
                                                Dated:    
                                                <input type="text" class="w30 input_single form-control" id="vesting_form_date" name="vesting_form_date" value="<?php echo $vesting_form_date;?>">
                                                
                                            </div>
                                            
                                            <input type="text" class="signature form-control" value="" id="vesting_form_signature" name="vesting_form_signature" value="<?php echo $vesting_form_signature;?>"> 
                                                      
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
                                <div id="collapseNine" class="accordion-collapse collapse show" aria-labelledby="headingNine" data-bs-parent="#accordionExample">
                                    <div class="accordion-body">
                                        <h2 class="text-center my-4"><strong>PRELIMINARY CHANGE OF OWNERSHIP REPORT</strong></h2>
                                        <p>
                                            To be completed by the transferee (buyer) prior to a transfer of subject property, in accordance with section 480.3 of the Revenue and Taxation Code. A Preliminary Change of Ownership Report must <b>be filed with each conveyance in the County Recorder’s office for the county where the property is located.</b>
                                        </p>
                                        <div class="row">
                                            <div class="col-md-6 mb-3">
                                                <small>
                                                    NAME AND MAILING ADDRESS OF BUYER/TRANSFEREE <br> (Make necessary corrections to the printed name and mailing address)
                                                </small>
                                                <textarea name="address" rows="6" id="address" class="form-control mt-3" style="height:auto !important" readonly>
Mordechai Citronenbaum  
48 Hauser Blvd. #1-110 
Los Angeles, CA 90036
                                                </textarea>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group position-relative mb-3">
                                                    <input type="text" class="form-control f700 f12" value="" id="assessors_parcel_number" name="assessors_parcel_number" value="<?php echo $assessors_parcel_number;?>">
                                                    <small class="small_label">ASSESSOR'S PARCEL NUMBER</small>
                                                </div>
                                                
                                                <div class="form-group position-relative mb-3">
                                                    <input type="text" class="form-control f700 f12" id="transferor" name="transferor" value="<?php echo $transferor;?>">
                                                    <small class="small_label">SELLER/TRANSFEROR</small>
                                                </div>
                                                
                                                <div class="form-group position-relative mb-3">
                                                    <input type="text" class="form-control f700 f12" id="buyer_daytime_phone_number" name="buyer_daytime_phone_number" value="<?php echo $buyer_daytime_phone_number;?>">
                                                    <small class="small_label">BUYER'S DAYTIME TELEPHONE NUMBER</small>
                                                </div>
                                                
                                                <div class="form-group position-relative mb-3">
                                                    <input type="text" class="form-control f700 f12" id="buyer_email_address" name="buyer_email_address" value="<?php echo $buyer_email_address;?>">
                                                    <small class="small_label">BUYER'S EMAIL ADDRESS</small>
                                                </div>
                                                
                                            </div>
                                        </div>
                                        
                                        <div class="form-group position-relative mb-3">
                                            <input type="text" class="form-control f700 f12" value="" id="real_property_addres" name="real_property_addres" value="<?php echo $real_property_addres;?>">
                                            <small class="small_label">STREET ADDRESS OR PHYSICAL LOCATION OF REAL PROPERTY </small>
                                        </div>
                                        

                                        <table class="table yesno_table">
                                            <tr>
                                                <th><b>YES</b></th>
                                                <th><b>NO</b></th>
                                                <th></th>
                                            </tr>
                                            <tr>
                                                <td><input type="radio" name="is_principal_residence" id="checkYes0" value="yes" <?php echo ($is_principal_residence == 'yes') ? 'checked="checked"' : '';?>></td> 
                                                <td><input type="radio" name="is_principal_residence" id="checkNo0" value="no" <?php echo ($is_principal_residence == 'no') ? 'checked="checked"' : '';?>></td>
                                                <td>
                                                    This property is intended as my principal residence. If YES, please indicate the date of occupancy or intended occupancy.
                                                    <div class="d-flex date_group">
                                                        <input type="text" class="form-control" placeholder="MO" id="intended_occupancy_month" name="intended_occupancy_month" value="<?php echo $date_of_occupancy;?>">
                                                        
                                                    </div>
                                                    
                                                </td>
                                            </tr>
                                            
                                            <tr>
                                                <td><input type="radio" name="is_disabled_veteran" id="checkYes1" value="yes" <?php echo ($is_disabled_veteran == 'yes') ? 'checked="checked"' : '';?>></td>
                                                <td><input type="radio" name="is_disabled_veteran" id="checkNo1" value="no" <?php echo ($is_disabled_veteran == 'no') ? 'checked="checked"' : '';?>></td>
                                                <td>
                                                    Are you a disabled veteran or a unmarried surviving spouse of a disabled veteran who was compensated at 100% by the Department of Veterans Affairs?
                                                    
                                                </td>
                                            </tr>
                                        </table>

                                        <div class="form-group position-relative mb-3">
                                            <input type="text" class="form-control f700 f12" value="" id="mail_property_tax_name" name="mail_property_tax_name" value="<?php echo $mail_property_tax_name;?>">
                                            <small class="small_label">MAIL PROPERTY TAX INFORMATION TO (NAME)</small>
                                        </div>
                                        

                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group position-relative mb-3">
                                                    <input type="text" class="form-control f700 f12" value="" id="mail_property_tax_address" name="mail_property_tax_address" value="<?php echo $mail_property_tax_address;?>">
                                                    <small class="small_label">MAIL PROPERTY TAX INFORMATION TO (ADDRESS)</small>
                                                </div>
                                                
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group position-relative mb-3">
                                                    <input type="text" class="form-control f700 f12" value="" id="mail_property_tax_city" name="mail_property_tax_city" value="<?php echo $mail_property_tax_city;?>">
                                                    <small class="small_label">CITY </small>
                                                </div>
                                                
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group position-relative mb-3">
                                                    <input type="text" class="form-control f700 f12" value="" id="mail_property_tax_state" name="mail_property_tax_state" value="<?php echo $mail_property_tax_state;?>">
                                                    <small class="small_label">STATE </small>
                                                </div>
                                                
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group position-relative mb-3">
                                                    <input type="text" class="form-control f700 f12" value="" id="mail_property_tax_zipcode" name="mail_property_tax_zipcode" value="<?php echo $mail_property_tax_zipcode;?>">
                                                    <small class="small_label">ZIP CODE</small>
                                                </div>
                                                
                                            </div>
                                        </div>

                                        <div class="text-center mt-5">
                                            <h5 class="f600">
                                                PART 1. TRANSFER INFORMATION
                                            </h5>
                                            <em> Please complete all statements.</em>
                                            <p>This section contains possible exclusions from reassessment for certain types of transfers.</p>
                                        </div>

                                        <table class="table yesno_table">
                                            <tr>
                                                <th></th>
                                                <th><b>YES</b></th>
                                                <th><b>NO</b></th>
                                                <th></th>
                                            </tr>
                                            <tr>
                                                <td>A.</td>
                                                <td><input type="radio" name="is_transfer_between_spouses" id="checkYes2" value="yes" <?php echo ($is_transfer_between_spouses == 'yes') ? 'checked="checked"' : '';?>></td>
                                                <td><input type="radio" name="is_transfer_between_spouses" id="checkNo2" value="no" <?php echo ($is_transfer_between_spouses == 'no') ? 'checked="checked"' : '';?>></td>
                                                <td>
                                                    This transfer is solely between spouses (addition or removal of a spouse, death of a spouse, divorce settlement, etc.).
                                                    
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>B.</td>
                                                <td><input type="radio" name="is_transfer_between_domestic_partners" id="checkYes3" value="yes" <?php echo ($is_transfer_between_domestic_partners == 'yes') ? 'checked="checked"' : '';?>></td>
                                                <td><input type="radio" name="is_transfer_between_domestic_partners" id="checkNo3" value="no" id="second_buyer_middle_name" <?php echo ($is_transfer_between_domestic_partners == 'no') ? 'checked="checked"' : '';?>></td>
                                                <td>
                                                    This transfer is solely between domestic partners currently registered with the California Secretary of State <em>
                                                        (addition or removal of a partner, death of a partner, termination settlement, etc.). 
                                                    </em>
                                                    
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>C.</td>
                                                <td><input type="radio" name="is_transfer" id="checkYes4" value="yes" <?php echo ($is_transfer == 'yes') ? 'checked="checked"' : '';?>></td>
                                                <td><input type="radio" name="is_transfer" id="checkNo4" value="no" <?php echo ($is_transfer == 'no') ? 'checked="checked"' : '';?>></td>
                                                <td>
                                                    This is a transfer:
                                                    
                                                    <div class="d-flex">
                                                        <input type="radio" name="is_parent_child_transfer" id="parentchild1" value="yes" class="me-2" <?php echo ($is_parent_child_transfer == 'yes') ? 'checked="checked"' : '';?>> <label for="parentchild1">&nbsp;&nbsp;&nbsp;This property is intended as my principal residencbetween parent(s) and child(ren)</label>
                                                    </div>
                                                    <div class="d-flex">
                                                        <input type="radio" name="is_parent_child_transfer" id="parentchild2" value="no" class="me-2" <?php echo ($is_parent_child_transfer == 'no') ? 'checked="checked"' : '';?>> <label for="parentchild2">&nbsp;&nbsp;&nbsp;between grandparent(s) and grandchild(ren).</label>
                                                    </div>
                                                   
                                                    <div class="mt-2">
                                                        Was this the transferor/grantor's principal residence? &nbsp;
                                                        <input type="radio" name="is_principal_residence" id="principal1" value="yes" class="me-2" <?php echo ($is_principal_residence == 'yes') ? 'checked="checked"' : '';?>>&nbsp;&nbsp;&nbsp; <label for="principal1">YES</label>&nbsp;&nbsp;&nbsp;
                                                        <input type="radio" name="is_principal_residence" id="principal2" value="no" class="me-2" <?php echo ($is_principal_residence == 'no') ? 'checked="checked"' : '';?>>&nbsp;&nbsp;&nbsp;NO</label>
                                                    </div>
                                                    
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>D.</td>
                                                <td><input type="radio" name="is_cotenant_death" id="checkYes5" value="yes" <?php echo ($is_cotenant_death == 'yes') ? 'checked="checked"' : '';?>></td>
                                                <td><input type="radio" name="is_cotenant_death" id="checkNo5" value="no" <?php echo ($is_cotenant_death == 'no') ? 'checked="checked"' : '';?>></td>
                                                <td>
                                                    This transfer is the result of a cotenant’s death. <br/>Date of death <input type="text" class="input_single form-control" name="date_of_death" id="date_of_death" value="<?php echo $input_single;?>">
                                                    
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>E.</td>
                                                <td><input type="radio" name="is_replace_principal_residence_own" id="checkYes6" value="yes" <?php echo ($is_replace_principal_residence_own == 'yes') ? 'checked="checked"' : '';?>></td>
                                                <td><input type="radio" name="is_replace_principal_residence_own" id="checkNo6" value="no" <?php echo ($is_replace_principal_residence_own == 'no') ? 'checked="checked"' : '';?>></td>
                                                <td>
                                                    This transaction is to replace a principal residence owned by a person 55 years of age or older.<br>
                                                    
                                                    Within the same county?  &nbsp;
                                                    <input type="radio" name="is_replace_principal_residence_own_in_same_county" id="sameCountry1" class="me-2" <?php echo ($is_replace_principal_residence_own_in_same_county == 'yes') ? 'checked="checked"' : '';?>>&nbsp;&nbsp;&nbsp; <label for="sameCountry1">YES</label>&nbsp;&nbsp;&nbsp;
                                                    <input type="radio" name="is_replace_principal_residence_own_in_same_county" id="sameCountry2" class="me-2" <?php echo ($is_replace_principal_residence_own_in_same_county == 'no') ? 'checked="checked"' : '';?>>&nbsp;&nbsp;&nbsp; <label for="sameCountry2">NO</label>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>F.</td>
                                                <td><input type="radio" name="is_replace_principal_residence_person_disabled" id="checkYes7" value="yes" <?php echo ($is_replace_principal_residence_person_disabled == 'yes') ? 'checked="checked"' : '';?>></td>
                                                <td><input type="radio" name="is_replace_principal_residence_person_disabled" id="checkNo7" value="no" <?php echo ($is_replace_principal_residence_person_disabled == 'no') ? 'checked="checked"' : '';?>></td>
                                                <td>
                                                    This transaction is to replace a principal residence by a person who is severely disabled.<br>
                                                    
                                                    Within the same county?  &nbsp;
                                                    <input type="radio" name="is_replace_principal_residence_person_disabled_in_same_county" id="severeDisabled1" class="me-2" <?php echo ($is_replace_principal_residence_person_disabled_in_same_county == 'yes') ? 'checked="checked"' : '';?>>&nbsp;&nbsp;&nbsp; <label for="severeDisabled1">YES</label>&nbsp;&nbsp;&nbsp;
                                                    <input type="radio" name="is_replace_principal_residence_person_disabled_in_same_county" id="severeDisabled2" class="me-2" <?php echo ($is_replace_principal_residence_person_disabled_in_same_county == 'no') ? 'checked="checked"' : '';?>>&nbsp;&nbsp;&nbsp; <label for="severeDisabled2">NO</label>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>G.</td>
                                                <td><input type="radio" name="is_replace_principal_residence_damaged" id="checkYes8" value="yes" <?php echo ($is_replace_principal_residence_damaged == 'yes') ? 'checked="checked"' : '';?>></td>
                                                <td><input type="radio" name="is_replace_principal_residence_damaged" id="checkNo8" value="no" <?php echo ($is_replace_principal_residence_damaged == 'no') ? 'checked="checked"' : '';?>></td>
                                                <td>
                                                    This transaction is to replace a principal residence substantially damaged or destroyed by a wildfire or natural disaster for which the Governor proclaimed a state of emergency. <br>
                                                    
                                                    Within the same county?  &nbsp;
                                                    <input type="radio" name="is_replace_principal_residence_damaged_in_same_county" id="damage1" class="me-2" <?php echo ($is_replace_principal_residence_damaged_in_same_county == 'yes') ? 'checked="checked"' : '';?>>&nbsp;&nbsp;&nbsp; <label for="damage1">YES</label>&nbsp;&nbsp;&nbsp;
                                                    <input type="radio" name="is_replace_principal_residence_damaged_in_same_county" id="damage2" class="me-2" <?php echo ($is_replace_principal_residence_damaged_in_same_county == 'no') ? 'checked="checked"' : '';?>>&nbsp;&nbsp;&nbsp; <label for="damage2">NO</label>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>H.</td>
                                                <td><input type="radio" name="is_name_change" id="checkYes9" value="yes" <?php echo ($is_name_change == 'yes') ? 'checked="checked"' : '';?>></td>
                                                <td><input type="radio" name="is_name_change" id="checkNo9" value="no" <?php echo ($is_name_change == 'no') ? 'checked="checked"' : '';?>></td>
                                                <td>
                                                    This transaction is only a correction of the name(s) of the person(s) holding title to the property (e.g., a name change
                                                    upon marriage). <br/> If YES, please explain:  &nbsp;
                                                    <input type="text" class="input_single form-control" name="name_change_reason" id="name_change_reason" value="<?php echo $name_change_reason;?>">
                                                    
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>I.</td>
                                                <td><input type="radio" name="is_lender_interest" id="checkYes10" value="yes" <?php echo ($is_lender_interest == 'yes') ? 'checked="checked"' : '';?>></td>
                                                <td><input type="radio" name="is_lender_interest" id="checkNo10" value="no" <?php echo ($is_lender_interest == 'no') ? 'checked="checked"' : '';?>></td>
                                                <td>
                                                    The recorded document creates, terminates, or reconveys a lender's interest in the property. &nbsp;
                                                    <input type="text" class="input_single form-control" name="lender_interest_reason" id="lender_interest_reason" value="<?php echo $lender_interest_reason;?>">
                                                    
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>J.</td>
                                                <td><input type="radio" name="is_financing_purpose" id="checkYes11" value="yes" <?php echo ($is_financing_purpose == 'yes') ? 'checked="checked"' : '';?>></td>
                                                <td><input type="radio" name="is_financing_purpose" id="checkNo11" value="no" <?php echo ($is_financing_purpose == 'no') ? 'checked="checked"' : '';?>></td>
                                                <td>
                                                    This transaction is recorded only as a requirement for financing purposes or to create, terminate, or reconvey a security
                                                    interest (e.g., cosigner). If YES, please explain:  &nbsp;
                                                    <input type="text" class="input_single" name="financing_purpose_reason" id="financing_purpose_reason" value="<?php echo $financing_purpose_reason;?>">
                                                    
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>K.</td>
                                                <td><input type="radio" name="is_trustee_of_trust" id="checkYes12" value="yes" <?php echo ($is_trustee_of_trust == 'yes') ? 'checked="checked"' : '';?>></td>
                                                <td><input type="radio" name="is_trustee_of_trust" id="checkNo12" value="no" <?php echo ($is_trustee_of_trust == 'no') ? 'checked="checked"' : '';?>></td>
                                                <td>
                                                    The recorded document substitutes a trustee of a trust, mortgage, or other similar document.   &nbsp;
                                                    
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>L.</td>
                                                <td><input type="radio" name="is_transfer_property" id="checkYes13" value="yes" <?php echo ($is_transfer_property == 'yes') ? 'checked="checked"' : '';?>></td>
                                                <td><input type="radio" name="is_transfer_property" id="checkNo13" value="no" <?php echo ($is_transfer_property == 'no') ? 'checked="checked"' : '';?>></td>
                                                <td>
                                                    This is a transfer of property:
                                                    
                                                    <div class="pl-3 mb-3">
                                                        1. to/from a revocable trust that may be revoked by the transferor and is for the benefit of <br>
                                                        <input type="radio" name="benefit" id="benefit1" class="me-2" value="transferor" <?php echo ($benefit == 'transferor') ? 'checked="checked"' : '';?>>&nbsp;&nbsp;&nbsp; <label for="benefit1">the transferor, and/or</label>
                                                        <input type="radio" name="benefit" id="benefit2" class="me-2" value="transferor_spouse" <?php echo ($benefit == 'transferor_spouse') ? 'checked="checked"' : '';?>>&nbsp;&nbsp;&nbsp; <label for="benefit2">the transferor's spouse</label>
                                                        <input type="radio" name="benefit" id="benefit3" class="me-2" value="registered_domestic_partner" <?php echo ($benefit == 'registered_domestic_partner') ? 'checked="checked"' : '';?>>&nbsp;&nbsp;&nbsp; <label for="benefit3"> registered domestic partner.</label>
                                                    </div>
                                                    
                                                    <div class="pl-3">
                                                        2. to/from an irrevocable trust for the benefit of the <br>
                                                        <input type="radio" name="trustor" id="trustor1" class="me-2" value="transferor" <?php echo ($trustor == 'transferor') ? 'checked="checked"' : '';?>>&nbsp;&nbsp;&nbsp; <label for="trustor1">the transferor, and/orreator/grantor/trustor and/or         </label>
                                                        <input type="radio" name="trustor" id="trustor2" class="me-2" value="trustor_spouse" <?php echo ($trustor == 'trustor_spouse') ? 'checked="checked"' : '';?>>&nbsp;&nbsp;&nbsp; <label for="trustor2">grantor's/trustor's spouse</label>
                                                        <input type="radio" name="trustor" id="trustor3" class="me-2" value="trustor_registered_domestic_partner" <?php echo ($trustor == 'trustor_registered_domestic_partner') ? 'checked="checked"' : '';?>>&nbsp;&nbsp;&nbsp; <label for="trustor3"> grantor's/trustor's registered domestic partner</label>
                                                    </div>
                                                    
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>M.</td>
                                                <td><input type="radio" name="is_subject_to_lease" id="checkYes14" value="yes" <?php echo ($is_subject_to_lease == 'yes') ? 'checked="checked"' : '';?>></td>
                                                <td><input type="radio" name="is_subject_to_lease" id="checkNo14" value="no" <?php echo ($is_subject_to_lease == 'no') ? 'checked="checked"' : '';?>></td>
                                                <td>
                                                    This property is subject to a lease with a remaining lease term of 35 years or more including written options.
                                                    
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>N.</td>
                                                <td><input type="radio" name="is_transfer_between_parties" id="checkYes15" value="yes" <?php echo ($is_transfer_between_parties == 'yes') ? 'checked="checked"' : '';?>></td>
                                                <td><input type="radio" name="is_transfer_between_parties" id="checkNo15" value="no" <?php echo ($is_transfer_between_parties == 'no') ? 'checked="checked"' : '';?>></td>
                                                <td>
                                                    This is a transfer between parties in which proportional interests of the transferor(s) and transferee(s) in each and every parcel being transferred remain exactly the same after the transfer
                                                    
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>O.</td>
                                                <td><input type="radio" name="is_subsidized_low_income" id="checkYes16" value="yes" <?php echo ($is_subsidized_low_income == 'yes') ? 'checked="checked"' : '';?>></td>
                                                <td><input type="radio" name="is_subsidized_low_income" id="checkNo16" value="no" <?php echo ($is_subsidized_low_income == 'no') ? 'checked="checked"' : '';?>></td>
                                                <td>
                                                    This is a transfer subject to subsidized low-income housing requirements with governmentally imposed restrictions, or restrictions imposed by specified nonprofit corporations.
                                                    
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>P.</td>
                                                <td><input type="radio" name="is_solar_energy_system" id="checkYes17" value="yes" <?php echo ($is_solar_energy_system == 'yes') ? 'checked="checked"' : '';?>></td>
                                                <td><input type="radio" name="is_solar_energy_system" id="checkNo17" value="no" <?php echo ($is_solar_energy_system == 'no') ? 'checked="checked"' : '';?>></td>
                                                <td>
                                                    This transfer is to the first purchaser of a new building containing an active solar energy system.
                                                    
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Q.</td>
                                                <td><input type="radio" name="is_transfer_other" id="checkYes18" value="yes" <?php echo ($is_transfer_other == 'yes') ? 'checked="checked"' : '';?>></td>
                                                <td><input type="radio" name="is_transfer_other" id="checkNo18" value="no" <?php echo ($is_transfer_other == 'no') ? 'checked="checked"' : '';?>></td>
                                                <td>
                                                    Other. This transfer is to 
                                                    <input type="text" class="input_single" name="other_transfer" id="other_transfer" value="<?php echo $other_transfer;?>">
                                                </td>
                                            </tr>
                                        </table>

                                        <small>* Please refer to the instructions for Part 1.</small>
                                        <p class="text-center f600 mt-3">Please provide any other information that will help the Assessor understand the nature of the transfer.</p>

                                        <div class="text-center my-5">
                                            <h5 class="f600">
                                                PART 2. OTHER TRANSFER INFORMATION 
                                            </h5>
                                            <em>Check and complete as applicable.</em>
                                        </div>

                                        <table class="table yesno_table">
                                            <tr>
                                                <th></th>
                                                <th></th>
                                            </tr>
                                            <tr>
                                                <td>A.</td>
                                                <td>
                                                    Date of transfer, if other than recording date: 
                                                    <input type="date" class="input_single" id="recording_date" value="<?php echo $recording_date;?>" name="recording_date">
                                
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>B.</td>
                                                <td>
                                                    Type of transfer: 
                                                    <div class="row">
                                                        <div class="col-lg-2 col-md-6">
                                                            <div class="d-flex">
                                                                <input type="checkbox" class="mt-2 me-2" id="purchase" value="purchase" name="purchase">
                                                                <label for="purchase">Purchase</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-2 col-md-6">
                                                            <div class="d-flex">
                                                                <input type="checkbox" class="mt-2 me-2" id="foreclosure" value="foreclosure" name="foreclosure">
                                                                <label for="foreclosure">Foreclosure</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-3 col-md-6">
                                                            <div class="d-flex">
                                                                <input type="checkbox" class="mt-2 me-2" id="trade" value="trade_of_exchange" name="trade_of_exchange">
                                                                <label for="trade">Trade or exchange </label>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-5 col-md-6">
                                                            <div class="d-flex">
                                                                <input type="checkbox" class="mt-2 me-2" id="acquisition" value="acquisition" name="types_of_transfer[]">
                                                                <label for="acquisition"> Merger, stock, or partnership acquisition (Form BOE-100-B) </label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row mt-3">
                                                        <div class="col-md-6">
                                                            Contract of sale. Date of contract <input type="date" class="input_single" id="date_of_contract" name="date_of_contract" value="<?php echo $date_of_contract;?>">
                                                            
                                                        </div>
                                                        <div class="col-md-6">
                                                            <input type="checkbox" id="inheritance" value="inheritance" name="types_of_transfer[]"> 
                                                            <label for="inheritance">Inheritance. Date of death: 
                                                            <input type="date" class="input_single" id="date_of_death_transfer" name="date_of_death_transfer" value="<?php echo $date_of_death_transfer;?>"></label>
                                                            
                                                        </div>
                                                    </div>
                                                    <div class="row mt-3">
                                                        <div class="col-lg-2 col-md-6">
                                                            <div class="d-flex">
                                                                <input type="checkbox" class="mt-2 me-2" id="leaseback" value="leaseback" name="types_of_transfer[]">
                                                                <label for="leaseback"> Sale/leaseback</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-2 col-md-6">
                                                            <div class="d-flex">
                                                                <input type="checkbox" class="mt-2 me-2" id="lease" value="lease" name="types_of_transfer[]">
                                                                <label for="lease">Creation of a lease</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-3 col-md-6">
                                                            <div class="d-flex">
                                                                <input type="checkbox" class="mt-2 me-2" id="assignment" value="assignment" name="types_of_transfer[]">
                                                                <label for="assignment">Assignment of a lease </label>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-5 col-md-6">
                                                            <div class="d-flex">
                                                                <input type="checkbox" class="mt-2 me-2" id="termination" value="termination" name="types_of_transfer[]">
                                                                <label for="termination"> Termination of a lease. Date lease began  
                                                                    <input type="date" class="input_single" id="date_of_lease_began" name="date_of_lease_began" value="<?php echo $date_of_lease_began;?>"></label>
                                                                
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="mt-3">
                                                        Original term in years (including written options): 
                                                         <input type="text" class="input_single w-small" id="original_terms_in_year" name="original_terms_in_year" value="<?php echo $original_terms_in_year;?>"> 
                                                         Remaining term in years (including written options):   
                                                         <input type="text"  class="input_single w-small" id="remaining_terms_in_year" name="remaining_terms_in_year" value="<?php echo $remaining_terms_in_year;?>">
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>C.</td>
                                                <td>
                                                    Only a partial interest in the property was transferred. &nbsp;
                                                    <input type="radio" name="is_partial_interest" id="propertYes" value="yes" <?php echo ($is_partial_interest == 'yes') ? 'checked="checked"' : '';?>>&nbsp;<label for="propertYes">YES</label> &nbsp;
                                                    <input type="radio" name="is_partial_interest" id="propertNo" value="no" <?php echo ($is_partial_interest == 'no') ? 'checked="checked"' : '';?>>&nbsp;<label for="propertNo">NO</label>&nbsp;
                                                    If YES, indicate the percentage transferred: 
                                                    <input type="text" class="input_single w-medium" id="start_percentage_range" name="start_percentage_range" value="<?php echo $start_percentage_range;?>"> % 
                                                    <input type="text" class="input_single w-medium" id="end_percentage_range" name="end_percentage_range" value="<?php echo $end_percentage_range;?>">
                                                    
                                                </td>
                                            </tr>
                                        </table>

                                        <div class="text-center my-5">
                                            <h5 class="f600">
                                                PART 3. PURCHASE PRICE AND TERMS OF SALE 
                                            </h5>
                                            <em>Check and complete as applicable.</em>
                                        </div>

                                        <table class="table yesno_table">
                                            <tr>
                                                <th></th>
                                                <th></th>
                                            </tr>
                                            <tr>
                                                <td>A.</td>
                                                <td>
                                                    <div class="d-flex justify-content-between">
                                                        Total purchase price   <div>$ 
                                                            <input type="text" class="input_single" id="total_purchase_price" name="total_purchase_price" value="<?php echo $total_purchase_price;?>"></div>
                                                            
                                                    </div>
                                                    
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>B.</td>
                                                <td>
                                                    <div class="d-flex justify-content-between">
                                                        Cash down payment or value of trade or exchange excluding closing costs  <div>Amount $ 
                                                            <input type="text" class="input_single" id="cash_down_payment" name="cash_down_payment" value="<?php echo $cash_down_payment;?>"></div>
                                                            
                                                    </div>
                                                    
                                                </td>
                                            </tr>       
                                            <tr>
                                                <td>C.</td>
                                                <td>
                                                    First deed of trust @ &nbsp;
                                                   <input type="text" class="input_single w-small" id="first_deed_of_trust_interest" name="first_deed_of_trust_interest" value="<?php echo $first_deed_of_trust_interest;?>"> % interest for 
                                                   <input type="text" class="input_single w-small" id="first_deed_of_trust_years" name="first_deed_of_trust_years" value="<?php echo $first_deed_of_trust_years;?>">years. 
                                                   Monthly payment $ 
                                                   <input type="text" class="input_single" id="first_deed_of_trust_monthly_payment" name="first_deed_of_trust_monthly_payment" value="<?php echo $first_deed_of_trust_monthly_payment;?>">
                                                   
                                                    <div class="row mt-3">
                                                        <div class="col-lg-3 col-md-6">
                                                            <div class="d-flex">
                                                                <input type="checkbox" class="mt-2 me-2" id="fha" value="fha" name="first_deed_payment_types[]">
                                                                <label for="discount">FHA (____Discount Points)</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-3 col-md-6">
                                                            <div class="d-flex">
                                                                <input type="checkbox" class="mt-2 me-2" id="cal_vet" value="cal_vet" name="first_deed_payment_types[]">
                                                                <label for="vet">Cal-Vet </label>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-3 col-md-6">
                                                            <div class="d-flex">
                                                                <input type="checkbox" class="mt-2 me-2" id="va_point" value="va_point" name="first_deed_payment_types[]">
                                                                <label for="va_point">VA (____Discount Points) </label>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-3 col-md-6">
                                                            <div class="d-flex">
                                                                <input type="checkbox" class="mt-2 me-2" id="fix_rate" value="fix_rate" name="first_deed_payment_types[]">
                                                                <label for="fix_rate"> Fixed rate </label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row mt-3">
                                                        <div class="col-md-4">
                                                            <div class="d-flex">
                                                                <input type="checkbox" class="mt-2 me-2" id="var_rate" value="var_rate" name="first_deed_payment_types[]">
                                                                <label for="var_rate"> Variable rate</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <div class="d-flex">
                                                                <input type="checkbox" class="mt-2 me-2" id="loan" value="loan" name="first_deed_payment_types[]">
                                                                <label for="loan"> Bank/Savings & Loan/Credit Union </label>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <div class="d-flex">
                                                                <input type="checkbox" class="mt-2 me-2" id="loan_carried_by_seller" value="loan_carried_by_seller" name="first_deed_payment_types[]">
                                                                <label for="carried">Loan carried by seller</label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row mt-3">
                                                        <div class="col-md-6">
                                                            <div class="d-flex">
                                                                <input type="checkbox" class="mt-2 me-2" id="balloon_payment" value="balloon_payment" name="first_deed_payment_types[]">
                                                                <label for="balloon">Balloon payment $</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="d-flex">
                                                                <input type="checkbox" class="mt-2 me-2" id="due_date" value="due_date" name="first_deed_payment_types[]">
                                                                <label for="due_date">Due date: <input type="date" class="input_single" id="first_deed_due_date" name="first_deed_due_date" value="<?php echo $first_deed_due_date;?>"></label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>D.</td>
                                                <td>
                                                    <div>
                                                        Second deed of trust @  <input type="text" class="input_single w-small" id="second_deed_of_trust_interest" name="second_deed_of_trust_interest" value="<?php echo $second_deed_of_trust_interest;?>"> % interest for 
                                                        <input type="text" class="input_single w-small" id="second_deed_of_trust_years" name="second_deed_of_trust_years" value="<?php echo $second_deed_of_trust_years;?>"> years.   
                                                        Monthly payment $ <input type="text" class="input_single" id="second_deed_of_trust_monthly_payment" name="second_deed_of_trust_monthly_payment" value="<?php echo $second_deed_of_trust_monthly_payment;?>">  
                                                        Amount $ <input type="text" class="input_single" id="second_deed_of_trust_amount" name="second_deed_of_trust_amount" value="<?php echo $second_deed_of_trust_amount;?>">
                                                    </div>
                                                    <div class="mt-3 row">
                                                        <div class="col-md-4">
                                                            <div class="d-flex">
                                                                <input type="checkbox" class="mt-2 me-2" id="fixed_rate" value="fixed_rate" name="second_deed_payment_types[]">
                                                                <label for="fixed_rate"> Fixed rate</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <div class="d-flex">
                                                                <input type="checkbox" class="mt-2 me-2" id="second_var_rate" value="second_var_rate" name="second_deed_payment_types[]">
                                                                <label for="variable_rate"> Variable rate</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <div class="d-flex">
                                                                <input type="checkbox" class="mt-2 me-2" id="second_loan" value="second_loan" name="second_deed_payment_types[]">
                                                                <label for="union">Bank/Savings & Loan/Credit Union </label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="mt-3 row">
                                                        <div class="col-md-4">
                                                            <div class="d-flex">
                                                                <input type="checkbox" class="mt-2 me-2" id="second_loan_carried_by_seller" value="second_loan_carried_by_seller" name="second_deed_payment_types[]">
                                                                <label for="loan_seller">Loan carried by seller</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <div class="d-flex">
                                                                <input type="checkbox" class="mt-2 me-2" id="second_ballon_payment" value="second_ballon_payment" name="second_deed_payment_types[]">
                                                                <label for="ballon_pay">Balloon payment $ <input type="text" id="ballon_payment" name="ballon_payment" class="input_single w-small" value="<?php echo $ballon_payment;?>"></label>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <div class="d-flex">
                                                                <input type="checkbox" class="mt-2 me-2" id="second_due_date" value="second_due_date" name="second_deed_payment_types[]">
                                                                <label for="date_due"> Due date: <input type="date" class="input_single" id="second_deed_due_date" name="second_deed_due_date" value="<?php echo $second_deed_due_date;?>"></label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>E.</td>
                                                <td>
                                                    Was an Improvement Bond or other public financing assumed by the buyer?    &nbsp;
                                                    <input type="radio" name="is_financing" id="financingYes" value="yes" <?php echo ($is_financing == 'yes') ? 'checked="checked"' : '';?>>&nbsp;<label for="financingYes">YES</label> &nbsp;
                                                    <input type="radio" name="is_financing" id="financingNo" value="no" <?php echo ($is_financing == 'no') ? 'checked="checked"' : '';?>>&nbsp;<label for="financingNo">NO</label>&nbsp;
                                                    Outstanding balance $ <input type="text" class="input_single w-medium" id="outstanding_balance" name="outstanding_balance" value="<?php echo $outstanding_balance;?>">
                                                    
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>F.</td>
                                                <td>
                                                    Amount, if any, of real estate commission fees paid by the buyer which are not included in the purchase price $ 
                                                    <input type="text" class="input_single w-medium" id="real_estate_commission" name="real_estate_commission" value="<?php echo $real_estate_commission;?>">
                                                    
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>G.</td>
                                                <td>
                                                    he property was purchased: 
                                                    <div class="mt-3">
                                                        <input type="radio" name="property_purchase_via" id="real_estate" value="real_estate" <?php echo ($property_purchase_via == 'yes') ? 'real_estate' : '';?>>&nbsp;&nbsp;&nbsp;
                                                        <label for="broker_name">Through real estate broker.</label> 
                                                        Broker name: <input type="text" class="input_single" id="broker_name" name="broker_name" value="<?php echo $broker_name;?>"> 
                                                        Phone number: <input type="text" class="input_single" id="broker_phone_number" name="broker_phone_number" value="<?php echo $broker_phone_number;?>">
                                                    </div>
                                                    <div class="mt-3">
                                                        <input type="radio" name="property_purchase_via" id="direct" value="direct_from_seller" <?php echo ($property_purchase_via == 'direct_from_seller') ? 'checked="checked"' : '';?>>&nbsp;&nbsp;&nbsp; <label for="direct">Direct from seller</label>  &nbsp;
                                                        <input type="radio" name="property_purchase_via" id="direct" value="family_member_relationship" <?php echo ($property_purchase_via == 'family_member_relationship') ? 'checked="checked"' : '';?>>&nbsp;&nbsp;&nbsp; <label for="family">From a family member-Relationship  &nbsp;
                                                        <input type="text" class="input_single" id="property_purchase_via_name" name="property_purchase_via_name" value="<?php echo $property_purchase_via_name;?>"></label>  
                                                    </div>
                                                    <div class="mt-3">
                                                        <input type="radio" name="property_purchase_via" id="other" value="other" <?php echo ($property_purchase_via == 'other') ? 'checked="checked"' : '';?>> 
                                                        <label for="Other">Other. Please explain: 
                                                            <input type="text" class="input_single" id="other_through" name="other_through" value="<?php echo $other_through;?>">
                                                        </label>  
                                                    </div>
                                                    
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>H.</td>
                                                <td>
                                                    Please explain any special terms, seller concessions, broker/agent fees waived, financing, and any other information (e.g., buyer assumed the existing loan balance) that would assist the Assessor in the valuation of your property.
                                                </td>
                                            </tr>

                                            
                                        </table>

                                        <div class="text-center my-5">
                                            <h5 class="f600">
                                                PART 4. PROPERTY INFORMATION 
                                            </h5>
                                            <em>Check and complete as applicable.</em>
                                        </div>

                                        <table class="table yesno_table">
                                            <tr>
                                                <th></th>
                                                <th></th>
                                            </tr>
                                            <tr>
                                                <td>A.</td>
                                                <td>
                                                    Type of property transferred
                                                    <div class="row mt-3">
                                                        <div class="col-md-4">
                                                            <div class="d-flex">
                                                                <input type="checkbox" class="mt-2 me-2" id="single" name="types_of_property_transferred[]" value="single">
                                                                <label for="single"> Single-family residence</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <div class="d-flex">
                                                                <input type="checkbox" class="mt-2 me-2" id="own" name="types_of_property_transferred[]" value="own">
                                                                <label for="own">Co-op/Own-your-own</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <div class="d-flex">
                                                                <input type="checkbox" class="mt-2 me-2" id="manufactured" name="types_of_property_transferred[]" value="manufactured">
                                                                <label for="manufactured">Manufactured home</label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row mt-3">
                                                        <div class="col-md-4">
                                                            <div class="d-flex">
                                                                <input type="checkbox" class="mt-2 me-2" id="multiple" name="types_of_property_transferred[]" value="multiple">
                                                                <label for="multiple"> Multiple-family residence. Number of units: 
                                                                <input type="text" class="input_single" id="num_of_units" name="num_of_units" value="<?php echo $num_of_units;?>"></label>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <div class="d-flex">
                                                                <input type="checkbox" class="mt-2 me-2" id="condo" name="types_of_property_transferred[]" value="condo">
                                                                <label for="condo">Condominium</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <div class="d-flex">
                                                                <input type="checkbox" class="mt-2 me-2" id="unimproved" name="types_of_property_transferred[]" value="unimproved">
                                                                <label for="unimproved">Unimproved lot</label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row mt-3">
                                                        <div class="col-md-4">
                                                            <div class="d-flex">
                                                                <input type="checkbox" class="mt-2 me-2" id="timber" name="types_of_property_transferred[]" value="timber">
                                                                <label for="timber"> Other. Description: (i.e., timber, mineral, water rights, etc.)</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <div class="d-flex">
                                                                <input type="checkbox" class="mt-2 me-2" id="timshare" name="types_of_property_transferred[]" value="timshare">
                                                                <label for="timshare">Timeshare </label>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <div class="d-flex">
                                                                <input type="checkbox" class="mt-2 me-2" id="commercial" name="types_of_property_transferred[]" value="commercial">
                                                                <label for="commercial"> Commercial/Industrial</label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>B.</td>
                                                <td>
                                                    <div class="d-flex">
                                                        <div class="me-3">
                                                            <input type="radio" name="is_personal_property" id="bpropertyYes" value="yes" <?php echo ($is_personal_property == 'yes') ? 'checked="checked"' : '';?>>&nbsp; <label for="bpropertyYes">YES</label>&nbsp;
                                                            <input type="radio" name="is_personal_property" id="bpropertyNo" value="no" <?php echo ($is_personal_property == 'no') ? 'checked="checked"' : '';?>>&nbsp; <label for="bpropertyNo">NO</label> &nbsp;
                                                        </div>
                                                        <div>
                                                            Personal/business property, or incentives, provided by seller to buyer are included in the purchase price. Examples of personal property are furniture, farm equipment, machinery, etc. Examples of incentives are club memberships, etc. Attach list if available.
                                                        </div>
                                                    </div>
                                                    

                                                    If YES, enter the value of the personal/business property: $ <input type="text" class="input_single w-medium" id="peronal_property_value" name="peronal_property_value"> 
                                                    Incentives $ <input type="text" class="input_single w-medium" id="incentives" name="incentives" value="<?php echo $incentives;?>">
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>C.</td>
                                                <td>
                                                    <div class="d-flex">
                                                        <div class="me-3">
                                                            <input type="radio" name="is_manufacture_home_included_in_purchase_price" id="purchasePriceYes" value="yes" <?php echo ($is_manufacture_home_included_in_purchase_price == 'yes') ? 'checked="checked"' : '';?>>&nbsp; <label for="purchasePriceYes">YES</label>&nbsp;
                                                            <input type="radio" name="is_manufacture_home_included_in_purchase_price" id="purchasePriceNo" value="no" <?php echo ($is_manufacture_home_included_in_purchase_price == 'no') ? 'checked="checked"' : '';?>>&nbsp; <label for="purchasePriceNo">NO</label> &nbsp;
                                                        </div>
                                                        <div>
                                                            A manufactured home is included in the purchase price.
                                                        </div>
                                                        
                                                    </div>
                                                    <div class=" mt-3">
                                                        If YES, enter the value attributed to the manufactured home: $  
                                                        <input type="text" class="input_single w-medium" id="value_manufacture_home" name="value_manufacture_home" value="<?php echo $value_manufacture_home;?>">
                                                    </div>
                                                    <div class="d-flex mt-3">
                                                        <div class="me-3">
                                                            <input type="radio" name="is_manufacture_home_tax" id="manufacturedPriceYes" value="yes" <?php echo ($is_manufacture_home_tax == 'yes') ? 'checked="checked"' : '';?>>&nbsp; <label for="manufacturedPriceYes">YES</label>&nbsp;
                                                            <input type="radio" name="is_manufacture_home_tax" id="manufacturedPriceNo" value="no" <?php echo ($is_manufacture_home_tax == 'no') ? 'checked="checked"' : '';?>>&nbsp; <label for="manufacturedPriceNo">NO</label> &nbsp;
                                                        </div>
                                                        <div>
                                                            The manufactured home is subject to local property tax. If NO, enter decal number  
                                                            <input type="text" class="input_single w-medium" id="deal_number" name="deal_number" value="<?php echo $deal_number;?>">
                                                        </div>
                                                        
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>D.</td>
                                                <td>
                                                    <div class="d-flex">
                                                        <div class="me-3">
                                                            <input type="radio" name="is_property_produce_income" id="purchasePriceYes" value="yes" <?php echo ($is_property_produce_income == 'yes') ? 'checked="checked"' : '';?>>&nbsp; <label for="purchasePriceYes">YES</label>&nbsp;
                                                            <input type="radio" name="is_property_produce_income" id="purchasePriceNo" value="no" <?php echo ($is_property_produce_income == 'no') ? 'checked="checked"' : '';?>>&nbsp; <label for="purchasePriceNo">NO</label> &nbsp;
                                                        </div>
                                                        <div>
                                                            The property produces rental or other income.
                                                        </div>
                                                        
                                                    </div>
                                                    <div class="mt-3">
                                                        If YES, the income is from: &nbsp;
                                                        <input type="radio" name="income_type" id="rent" value="rent" <?php echo ($income_type == 'rent') ? 'checked="checked"' : '';?>> &nbsp; <label for="rent">Lease/rent</label>&nbsp;
                                                        <input type="radio" name="income_type" id="contract" value="contract" <?php echo ($income_type == 'contract') ? 'checked="checked"' : '';?>> &nbsp; <label for="contract">Contract</label> &nbsp;
                                                        <input type="radio" name="income_type" id="mineral" value="mineral" <?php echo ($income_type == 'mineral') ? 'checked="checked"' : '';?>>&nbsp;<label for="mineral">Mineral rights</label>&nbsp;
                                                        <input type="radio" name="income_type" id="other_income" value="other_income" <?php echo ($income_type == 'other_income') ? 'checked="checked"' : '';?>>&nbsp;<label for="other_income">Other:&nbsp;
                                                        <input type="text" class="input_single" id="other_income_type" name="other_income_type" value="<?php echo $other_income_type;?>"></label> &nbsp;
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>E.</td>
                                                <td>
                                                    <div>
                                                        The condition of the property at the time of sale was:  &nbsp;
                                                        <input type="radio" name="property_condition" id="good" value="good" <?php echo ($property_condition == 'good') ? 'checked="checked"' : '';?>> &nbsp; <label for="good">Good   </label> &nbsp;
                                                        <input type="radio" name="property_condition" id="average" value="average" <?php echo ($property_condition == 'average') ? 'checked="checked"' : '';?>> &nbsp; <label for="average">Average   </label> &nbsp;
                                                        <input type="radio" name="property_condition" id="fair" value="fair" <?php echo ($property_condition == 'fair') ? 'checked="checked"' : '';?>> &nbsp; <label for="fair">Fair   </label> &nbsp;
                                                        <input type="radio" name="property_condition" id="poor" value="poor"<?php echo ($property_condition == 'poor') ? 'checked="checked"' : '';?>> &nbsp; <label for="poor">Poor</label> &nbsp;
                                                    </div>
                                                    <div class="mt-2"> Please describe: <input type="text" class="input_single" id="property_condition_describe" name="property_condition_describe" value="<?php echo $property_condition_describe;?>"></div>
                                                    
                                                </td>
                                            </tr>
                                        </table>

                                        <div class="text-center mt-5">
                                            <h5 class="f600">
                                                CERTIFICATION
                                            </h5>
                                            <em>
                                                I certify (or declare) that the foregoing and all information hereon, including any accompanying statements or documents, is true and correct to the best of my knowledge and belief.
                                            </em>
                                        </div>
                                        <hr class="my-3">
                                        <div>SIGNATURE OF BUYER/TRANSFEREE OR CORPORATE OFFICER</div>
                                        <div class="row mt-2">
                                            <div class="col-md-6">
                                                <div class="form-group position-relative mb-3">
                                                    <input type="date" class="form-control" id="signature_corporate_officer_date" name="signature_corporate_officer_date" value="<?php echo $signature_corporate_officer_date;?>">
                                                    <small class="small_label">DATE </small>
                                                         
                                                </div>
                                                
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group position-relative mb-3">
                                                    <input type="text" class="form-control" id="corporate_officer_telephone" name="corporate_officer_telephone" value="<?php echo $corporate_officer_telephone;?>">
                                                    <small class="small_label">TELEPHONE</small>
                                                    
                                                </div>
                                                
                                            </div>
                                        </div>
                                        <div>NAME OF BUYER/TRANSFEREE/PERSONAL REPRESENTATIVE/CORPORATE OFFICER (PLEASE PRINT)</div>
                                        <div class="row mt-2">
                                            <div class="col-md-6">
                                                <div class="form-group position-relative mb-3">
                                                    <input type="text" class="form-control" id="corporate_officer_name" name="corporate_officer_name" value="<?php echo $corporate_officer_name;?>">
                                                    <small class="small_label">TITLE  </small>
                                                   
                                                </div>
                                                
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group position-relative mb-3">
                                                    <input type="email" class="form-control" id="corporate_officer_email" name="corporate_officer_email" value="<?php echo $corporate_officer_email;?>">
                                                    <small class="small_label">EMAIL ADDRESS</small>
                                                    
                                                </div>
                                                
                                            </div>
                                        </div>
                                        <div class="f500 text-center my-3">The Assessor's office may contact you for additional information regarding this transaction.    </div>
                                        

                                    </div>
                                        
                                </div>
                            </div>
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="headingTen">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTen" aria-expanded="false" aria-controls="collapseTen">
                                       (7) Preliminary Report Approval
                                    </button>
                                </h2>
                                <div id="collapseTen" class="accordion-collapse collapse show" aria-labelledby="headingTen" data-bs-parent="#accordionExample">
                                    <div class="accordion-body">
                                        <div class="page">
                                            <h2 class="text-center my-4"><strong>WIRING INFORMATION</strong></h2>
                                            
                                            <div class="date_escrow_num">
                                                <span>ESCROW NO.:</span>10257432-GLE-MP<br>
                                                <span>TITLE NO.:</span>10257432-GLT-<br><br>
                                                <span>TO:</span>
                                                <b>
                                                    Pacific Coast Title Company<br>
                                                    516 Burchett St.<br>
                                                    Glendale, CA  91203	
                                                </b><br><br>
                                                <span>BANK:</span>
                                                <b class="text_black">
                                                    Nano Banc, 7700 Irvine Center Drive, Suite 700, Irvine, CA  92618
                                                </b><br><br>
                                                <span>ROUTING NO:</span>
                                                <b class="text_black">
                                                    122245251
                                                </b><br><br>
                                                <span>ACCOUNT NO:</span>
                                                <b class="text_black">
                                                    Credit to <b class="text_red">Pacific Coast Title Company</b> in trust for <b class="text_red">MORDECHAI CITRONENBAUM</b><br> account number 6100100846
                                                </b><br><br>
                                               <b class="text_black"> PLEASE REFER TO OUR ESCROW NO. <b class="text_red">10257432-GLE-MP</b> </b>
                                            </div>
                                            <h5 class="text-underline text-center my-5 f600">
                                                WIRED FUNDS are preferred, as the funds are immediately posted and available.
                                            </h5>
                                            <p>
                                                ANY CASHIER CHECKS should be made payable to <span class="text_red">Pacific Coast Title Company</span>, reference the escrow number noted above. Funds received by Cashier’s Checks require overnight clearing prior to any close of escrow.
                                            </p>
                                            <p>
                                                Personal checks require bank clearance and your proof from your bank of your paid check.
                                            </p>
                                    
                                            <p>
                                                Delays in closing are likely if these guidelines are not followed. <span class="text_red">Pacific Coast Title Company</span> does not accept any responsibility for these delays to your closing.
                                            </p>
                                    
                                            <p>
                                                Please Note:  Our office does not accept ACH transfers. These instructions are for the purpose of sending wire transfers only.
                                            </p>
                                            
                                            <div class="notice_box">
                                                <p class="mt-0 text-center f600">
                                                    NOTE THE FOLLOWING IS <span class="text-underline">NOT ACCEPTABLE</span> AND CAN <i class="f600">SIGNIFICANTLY DELAY YOUR CLOSING:</i>
                                                </p>
                                                <p>
                                                    OFFICIAL CHECKS &amp; CERTIFIED CHECKS - are not a Cashier’s Check and are subject to a waiting period of 3-7 days and verification of cleared funds.
                                                </p>
                                                <p>
                                                    ON-LINE TRANSFERS OR ACH CREDITS- these can be recalled by the sender and therefore are not acceptable as they do not meet existing government guidelines of “Good Funds”. Your bank may offer this option at a lower cost, DO NOT ACCEPT! 
                                                </p>
                                                <p class="mb-0">
                                                    DIRECT DEPOSIT- This could cause a significant delay in your closing.
                                                </p>
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
                                <div id="collapseEleven" class="accordion-collapse collapse show" aria-labelledby="headingEleven" data-bs-parent="#accordionExample">
                                    <div class="accordion-body">
                                        <div class="form-group d-flex mb-2">
                                            <input type="checkbox" id="acknowledge" name="acknowledge"  class="me-2 mt-1">
                                            <label for="acknowledge" class="mb-2">By clicking the submit button, I agree to terms & conditions.</label>
                                                
                                        </div>
                                        <div class="border text-danger p-3">
                                            IMPORTANT NOTICE: Cyber criminals are preying on those involved in real estate transactions. They will hack email accounts, spoof email addresses, and send emails with fake wiring or fake funds delivery instructions. These emails are convincing and sophisticated. Always independently confirm wiring and funding instructions in person or by telephone to our published office phone number of record. Never wire money without double-checking, in person or by telephone that the wiring instructions are correct. BE SKEPTICAL AND VIGILANT. 
                                        </div>
                                        <hr>

                                        <div class="form-group mb-4">
                                            <label for="" class="mb-2"><b>Signature</b></label>
                                            <div class="sign_pad">
                                                <canvas id="canvas1" width="500" height="100" style="touch-action: none;"></canvas>
                                            </div>
                                           
                                            <a onclick="clear1()" href="javascript:void()" class="text-body text-end"> Clear</a>
                                        </div>

                                        <div class="row mt-5">
                                            <div class="col-md-4">
                                                <div class="form-group mb-3">
                                                    <label for="" class="mb-2"><b>TenantID</b></label>
                                                    <input type="text" class="form-control" id="tenant_id" name="tenant_id" value="<?php echo $tenant_id;?>">
                                                </div>
                                                
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group mb-3">
                                                    <label for="" class="mb-2"><b>DocType</b></label>
                                                    <input type="text" class="form-control" id="doc_type" name="doc_type" value="<?php echo $doc_type;?>">
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

    
</body>
</html>