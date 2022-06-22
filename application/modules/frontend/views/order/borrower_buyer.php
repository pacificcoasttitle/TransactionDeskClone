<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $title;?></title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,300;0,400;0,500;0,600;0,700;1,200&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="<?php echo base_url();?>assets/frontend/css/buyer-seller-package/bootstrap.min.css?v=01">
    <link rel="stylesheet" href="<?php echo base_url();?>assets/frontend/css/buyer-seller-package/style.css?v=01">
</head>

<style>
	.error2 {
		margin: 5px 0;
	}
    input[type="radio"] { margin: 10px !important; }
</style>

<body class="">

    <header>
        <div class="container">
            <div class="row align-items-center">
                <div class="col-6">
                    <a href="#"><img src="<?php echo base_url();?>assets/frontend/images/buyer-seller-package/alanna-logo.png" alt="..." class="img-fluid img_logo"></a>
                </div>
                <div class="col-6 text-end">
                </div>
            </div>
        </div>
    </header>

    <section class="form_content">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <?php if(!empty($success)) {?>
                        <div id="agent_success_msg" class="w-100 alert alert-success alert-dismissible">
                            <?php foreach($success as $sucess) {
                                    echo $sucess."<br \>";	
                                }?>
                        </div>
                    <?php } 
                    if(!empty($errors)) {?>
                        <div id="agent_error_msg" class="w-100 alert alert-danger alert-dismissible">
                            <?php foreach($errors as $error) {
                                    echo $error."<br \>";	
                                }?>
                        </div>
                    <?php } ?>
                    <form action="<?php echo base_url().'borrower-buyer-form/'.$orderDetails['file_id']; ?>" method="post" name="borrower_buyer_form" id="borrower_buyer_form">
                        <h2 class="blue_title">Buyer Opening Package<br><span style="font-size:16px; padding-top:15px;">Property Address: <?php echo $orderDetails['full_address'];?></span><br><span style="font-size:16px; padding-top:15px;">APN:<?php echo $orderDetails['apn'];?></span></h2>
                        <div class="accordion" id="accordionExample">
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="headingOne">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">(1) Property Information</button>
                                </h2>
                                <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne" data-bs-parent="#accordionExample">
                                    <div class="accordion-body">
                                        <div class="row mb-3">
                                            <div class="col-md-12">
                                                <div class="form-group position-relative mb-3 mt-3">
                                                    <label for="" class="mb-2"><b>Property Address Being Purchased</b></label>
                                                    <input type="text" class="form-control" id="property_address" name="property_address" required data-error="#property_address-error">
                                                    <small class="small_label">Street Address</small>
                                                </div>
                                                <input type="hidden" name="order_id" id="order_id" value="<?php echo $orderDetails['order_id'];?>">
                                                <label id="property_address-error" class="error text-danger error2" for="property_address"></label>

                                                <div class="form-group position-relative mb-3">
                                                    <input type="text" class="form-control" id="property_address2" name="property_address2" required data-error="#property_address2-error">
                                                    <small  class="small_label">Street Address Line 2</small>
                                                </div>
                                                <label id="property_address2-error" class="error text-danger error2" for="property_address2"></label>

												<div class="row">
                                                    <div class="col-md-6">
                                                        <div class="form-group position-relative mb-3">
                                                            <input type="text" class="form-control" id="property_city" name="property_city" id="property_city" name="property_city" required data-error="#property_city-error">
                                                            <small  class="small_label">City</small>
                                                        </div>
                                                        <label id="property_city-error" class="error text-danger error2" for="property_city"></label>
                                                    </div>

                                                    <div class="col-md-6">
                                                        <div class="form-group position-relative mb-3 ">
                                                            <input type="text" class="form-control" id="property_zipcode" name="property_zipcode" required data-error="#property_zipcode-error">
                                                            <small  class="small_label">Zip Code</small>
                                                        </div>
                                                        <label id="property_zipcode-error" class="error text-danger error2" for="property_zipcode"></label>
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
                                                                <input type="text" class="form-control" id="first_name" name="first_name" required data-error="#first_name-error">
                                                            </div>
                                                            <label id="first_name-error" class="error text-danger" for="first_name"></label>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <div class="form-group">
                                                                <label for="" class="mb-2">Middle Name</label>
                                                                <input type="text" class="form-control" id="middle_name" name="middle_name" required data-error="#middle_name-error">
                                                            </div>
                                                            <label id="middle_name-error" class="error text-danger" for="middle_name"></label>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <div class="form-group">
                                                                <label for="" class="mb-2">Last Name</label>
                                                                <input type="text" class="form-control" id="last_name" name="last_name" required data-error="#last_name-error">
                                                            </div>
                                                            <label id="last_name-error" class="error text-danger" for="last_name"></label>
                                                        </div>
                                                    
                                                        <div class="col-md-6 mt-2">
                                                            <div class="form-group position-relative">
                                                                <label for="" class="mb-2">Phone Number</label>
                                                                <input type="text" class="form-control" id="phone_number" name="phone_number" required data-error="#phone_number-error">
                                                                <label id="phone_number-error" class="error text-danger" for="phone_number"></label>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6 mt-2">
                                                            <div class="form-group position-relative">
                                                                <label for="" class="mb-2">Email Address</label>
                                                                <input type="text" class="form-control" id="" name="email" required data-error="#email-error">
                                                                <label id="email-error" class="error text-danger" for="email"></label>
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
                                                                <input type="text" class="form-control" id="second_buyer_first_name" name="second_buyer_first_name" required data-error="#second_buyer_first_name-error">
                                                            </div>
                                                            <label id="second_buyer_first_name-error" class="error text-danger" for="second_buyer_first_name"></label>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <div class="form-group">
                                                                <label for="" class="mb-2">Middle Name</label>
                                                                <input type="text" class="form-control" id="second_buyer_middle_name" name="second_buyer_middle_name" required data-error="#second_buyer_middle_name-error">
                                                            </div>
                                                            <label id="second_buyer_middle_name-error" class="error text-danger" for="second_buyer_middle_name"></label>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <div class="form-group">
                                                                <label for="" class="mb-2">Last Name</label>
                                                                <input type="text" class="form-control" id="second_buyer_last_name" name="second_buyer_last_name" required data-error="#second_buyer_last_name-error">
                                                            </div>
                                                            <label id="second_buyer_last_name-error" class="error text-danger" for="second_buyer_last_name"></label>
                                                        </div>
                                                    
                                                        <div class="col-md-6 mt-2">
                                                            <div class="form-group position-relative mb-4">
                                                                <label for="" class="mb-2">Phone Number</label>
                                                                <input type="text" class="form-control" id="second_buyer_phone_number" name="second_buyer_phone_number" required data-error="#second_buyer_phone_number-error">
                                                                <label id="second_buyer_phone_number-error" class="error text-danger" for="second_buyer_phone_number"></label>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6 mt-2">
                                                            <div class="form-group position-relative mb-4">
                                                                <label for="" class="mb-2">Email Address</label>
                                                                <input type="email" class="form-control" id="second_buyer_email" name="second_buyer_email" required data-error="#second_buyer_email-error">
                                                                <label id="second_buyer_email-error" class="error text-danger" for="second_buyer_email"></label>
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
                                                    <input type="radio" id="sameAddress" value="same" name="is_same_property_address_as_forwarding_address" required data-error="#is_same_property_address_as_forwarding_address-error"> 
                                                    <label for="option11">Same as Property Address</label>
                                                </li>
                                                <li class="list-inline-item">
                                                    <input type="radio" id="otherAddress" value="other" name="is_same_property_address_as_forwarding_address"> 
                                                    <label for="option12">Other Address</label>
                                                </li>
                                            </ul>
                                            <label id="is_same_property_address_as_forwarding_address-error" class="error text-danger" for="is_same_property_address_as_forwarding_address"></label>
                                            
                                            <div class="otherFowardingAddressClose d-none">
                                                <div class="form-group position-relative mb-3">
                                                    <label for="" class="mb-2"><b>Enter Forwarding Address After Closing </b></label>
                                                    <input type="text" class="form-control" id="forwarding_street_address" name="forwarding_street_address" data-error="#forwarding_street_address-error">
                                                    <small class="small_label">Street Address</small>
                                                </div>
                                                <label id="forwarding_street_address-error" class="error text-danger error2" for="forwarding_street_address"></label>
                                                <div class="form-group position-relative mb-3">
                                                    <input type="text" class="form-control" id="forwarding_street_address2" name="forwarding_street_address2" data-error="#forwarding_street_address2-error">
                                                    <small  class="small_label">Street Address Line 2</small>
                                                </div>
                                                <label id="forwarding_street_address2-error" class="error text-danger error2" for="forwarding_street_address2"></label>
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="form-group position-relative mb-3">
                                                            <input type="text" class="form-control" id="forwarding_city" name="forwarding_city" data-error="#forwarding_city-error">
                                                            <small  class="small_label">City</small>
                                                        </div>
                                                        <label id="forwarding_city-error" class="error text-danger error2" for="forwarding_city"></label>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group position-relative mb-3">
                                                            <input type="text" class="form-control" id="forwarding_state" name="forwarding_state" data-error="#forwarding_state-error">
                                                            <small  class="small_label">State</small>
                                                        </div>
                                                        <label id="forwarding_state-error" class="error text-danger error2" for="forwarding_state"></label>
                                                    </div>    
                                                </div>
                                                <div class="form-group position-relative mb-3 col-md-6">
                                                    <input type="text" class="form-control" id="forwarding_zip_code" name="forwarding_zip_code" data-error="#forwarding_zip_code-error">
                                                    <small  class="small_label">Zip Code</small>
                                                </div>
                                                <label id="forwarding_zip_code-error" class="error text-danger error2" for="forwarding_zip_code"></label>
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
                                            <ul class="list-inline mb-0">
                                                <li class="list-inline-item me-md-5">
                                                    <input type="radio" id="yesMortgage" value="yes" name="is_mortgage" required data-error="#is_mortgage-error"> 
                                                    <label for="yesMortgage">Yes</label>
                                                </li>
                                                <li class="list-inline-item">
                                                    <input type="radio" id="noMortgage" value="no" name="is_mortgage"> 
                                                    <label for="noMortgage">No</label>
                                                </li>
                                            </ul>
                                            <label id="is_mortgage-error" class="error text-danger" for="is_mortgage"></label>
                                        </div> 
                                        <div class="form-group mb-4">
                                            <label for="" class="mb-2"><b>Are there any other Liens on the Property?</b></label>
                                            <ul class="list-inline mb-0">
                                                <li class="list-inline-item me-md-5">
                                                    <input type="radio" id="yesLiens" value="yes" name="is_liens" required data-error="#is_liens-error"> 
                                                    <label for="yesLiens">Yes</label>
                                                </li>
                                                <li class="list-inline-item">
                                                    <input type="radio" id="noLiens" value="no" name="is_liens"> 
                                                    <label for="noLiens">No</label>
                                                </li>
                                            </ul>
                                            <label id="is_liens-error" class="error text-danger" for="is_liens"></label>
                                        </div>
                                        <div class="form-group mb-4">
                                            <label for="" class="mb-2"><b>Are there mandatory Homeowners or Condominium Associations?</b></label>
                                            <ul class="list-inline mb-0">
                                                <li class="list-inline-item me-md-5">
                                                    <input type="radio" id="yesCondominium" value="yes" name="is_condominium" required data-error="#is_condominium-error"> 
                                                    <label for="yesCondominium">Yes</label>
                                                </li>
                                                <li class="list-inline-item">
                                                    <input type="radio" id="noCondominium" value="no" name="is_condominium"> 
                                                    <label for="noCondominium">No</label>
                                                </li>
                                            </ul>
                                            <label id="is_condominium-error" class="error text-danger" for="is_condominium"></label>
                                        </div>
                                        <div class="form-group mb-4">
                                            <label for="" class="mb-2"><b>Is this your primary residence / homestead property for tax purposes?</b></label>
                                            <ul class="list-inline mb-0">
                                                <li class="list-inline-item me-md-5">
                                                    <input type="radio" id="yesresidence" value="yes" name="is_residence" required data-error="#is_residence-error"> 
                                                    <label for="yesresidence">Yes</label>
                                                </li>
                                                <li class="list-inline-item">
                                                    <input type="radio" id="noresidence" value="no" name="is_residence"> 
                                                    <label for="noresidence">No</label>
                                                </li>
                                            </ul>
                                            <label id="is_residence-error" class="error text-danger" for="is_residence"></label>
                                        </div>
                                        <div class="form-group mb-4">
                                            <label for="" class="mb-2"><b>Has there been a divorce since the purchase of the property or are you currently in the process of getting divorced?</b></label>
                                            <ul class="list-inline mb-0">
                                                <li class="list-inline-item me-md-5">
                                                    <input type="radio" id="yesdivorced" value="yes" name="is_divorced" required data-error="#is_divorced-error"> 
                                                    <label for="yesdivorced">Yes</label>
                                                </li>
                                                <li class="list-inline-item">
                                                    <input type="radio" id="nodivorced" value="no" name="is_divorced"> 
                                                    <label for="nodivorced">No</label>
                                                </li>
                                            </ul>
                                            <label id="is_divorced-error" class="error text-danger" for="is_divorced"></label>
                                            <div class="errorMsg text-danger d-none">Please provide a copy of the divorce decree or marriage settlement agreement.</div>
                                        </div>
                                        <div class="form-group mb-4">
                                            <label for="" class="mb-2"><b>Has your name changed since purchasing the Property?
                                            </b></label>
                                            <ul class="list-inline mb-0">
                                                <li class="list-inline-item me-md-5">
                                                    <input type="radio" id="yeschanged" value="yes" name="is_changed" required data-error="#is_changed-error"> 
                                                    <label for="yeschanged">Yes</label>
                                                </li>
                                                <li class="list-inline-item">
                                                    <input type="radio" id="nochanged" value="no" name="is_changed"> 
                                                    <label for="nochanged">No</label>
                                                </li>
                                            </ul>
                                            <label id="is_changed-error" class="error text-danger" for="is_changed"></label>
                                            <div class="errorMsg text-danger d-none">Please provide a copy of the marriage certificate or other legal document showing name change. </div>
                                        </div>
                                        <div class="form-group mb-4">
                                            <label for="" class="mb-2"><b>Has there been a death of an owner since taking title to the Property?
                                            </b></label>
                                            <ul class="list-inline mb-0">
                                                <li class="list-inline-item me-md-5">
                                                    <input type="radio" id="yesdeath" value="yes" name="is_death" required data-error="#is_death-error"> 
                                                    <label for="yesdeath">Yes</label>
                                                </li>
                                                <li class="list-inline-item">
                                                    <input type="radio" id="nodeath" value="no" name="is_death"> 
                                                    <label for="nodeath">No</label>
                                                </li>
                                            </ul>
                                            <label id="is_death-error" class="error text-danger" for="is_death"></label>
                                            <div class="errorMsg text-danger d-none">We will need a certified copy of the original death certificate for recordation, The original death certificate will be returned after closing. 
                                            </div>
                                        </div>
                                        <div class="form-group mb-4">
                                            <label for="" class="mb-2"><b>Do you have an existing survey for the Property?</b></label>
                                            <ul class="list-inline mb-0">
                                                <li class="list-inline-item me-md-5">
                                                    <input type="radio" id="yessurvey" value="yes" name="is_survey" required data-error="#is_survey-error"> 
                                                    <label for="yessurvey">Yes</label>
                                                </li>
                                                <li class="list-inline-item me-md-5">
                                                    <input type="radio" id="nosurvey" value="no" name="is_survey"> 
                                                    <label for="nosurvey">No</label>
                                                </li>
                                                <li class="list-inline-item">
                                                    <input type="radio" id="na" value="n/a" name="is_survey"> 
                                                    <label for="na">N/A - Property is a Condominium</label>
                                                </li>
                                            </ul>
                                            <label id="is_survey-error" class="error text-danger" for="is_survey"></label>
                                            <div class="errorMsg d-none">
                                                <div class="text-danger mb-3"> Please provide a copy of the existing survey to our office.</div>
                                                <label for="" class="mb-2"><b>Has there been any structural changes or improvements to the Property since the date of the Survey (such as new construction, fences, pools, driveways, etc.)?</b></label>
                                                <ul class="list-inline mb-0">
                                                    <li class="list-inline-item me-md-5">
                                                        <input type="radio" id="yesstructural" value="yes" name="is_structural" data-error="#is_structural-error"> 
                                                        <label for="yesstructural">Yes</label>
                                                    </li>
                                                    <li class="list-inline-item">
                                                        <input type="radio" id="nostructural" value="no" name="is_structural"> 
                                                        <label for="nostructural">No</label>
                                                    </li>
                                                </ul>
                                                <label id="is_structural-error" class="error text-danger" for="is_structural"></label>
                                            </div>
                                        </div>
                                        <div class="form-group mb-4">
                                            <label for="" class="mb-2"><b>Do you have an existing Owner's Title Insurance Policy for the Property? (Note: Depending on your Sales Contract, the Seller could be penalized $150.00 for not delivering their current owner's title insurance policy to the Buyer within 10 days of the effective date of the Sales Contract.)</b></label>
                                            <ul class="list-inline mb-0">
                                                <li class="list-inline-item me-md-5">
                                                    <input type="radio" id="yesInsurance" value="yes" name="is_insurance" required data-error="#is_same_property_address_as_forwarding_address-error"> 
                                                    <label for="yesInsurance">Yes</label>
                                                </li>
                                                <li class="list-inline-item">
                                                    <input type="radio" id="noInsurance" value="no" name="is_insurance"> 
                                                    <label for="noInsurance">No</label>
                                                </li>
                                            </ul>
                                            <label id="is_insurance-error" class="error text-danger" for="is_insurance"></label>
                                            <div class="text-danger d-none errorMsg">Please provide a copy of the existing Owner'sTitle Insurance Policy to our office.</div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="form-group mb-4">
                                                    <label for="" class="mb-2"><b>Water Service (Please Check One): </b></label>
                                                    <ul class="list-unstyled">
                                                        <li>
                                                            <input type="radio" id="City" value="City" name="water_service" required data-error="#water_service-error"> 
                                                            <label for="City">City</label>
                                                        </li>
                                                        <li>
                                                            <input type="radio" id="County" value="County" name="water_service"> 
                                                            <label for="County">County</label>
                                                        </li>
                                                        <li>
                                                            <input type="radio" id="FGUA" value="FGUA" name="water_service"> 
                                                            <label for="FGUA">FGUA</label>
                                                        </li>
                                                        <li>
                                                            <input type="radio" id="Septic" value="Septic" name="water_service"> 
                                                            <label for="Septic">Well / Septic</label>
                                                        </li>
                                                        <li>
                                                            <input type="radio" id="other" value="other" name="water_service"> 
                                                            <label for="County"><input type="text" class="form-control" placeholder="Other" id="other_water_service_name" name="other_water_service_name"></label>
                                                        </li>
                                                        <label id="water_service-error" class="error text-danger" for="water_service"></label>
                                                    </ul>
                                                   
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group mb-4">
                                                    <label for="" class="mb-2">Water Service Provider Name</label>
                                                    <input type="text" class="form-control" id="water_service_provider_name" name="water_service_provider_name" required data-error="#water_service_provider_name-error">
                                                    <label id="water_service_provider_name-error" class="error text-danger" for="water_service_provider_name"></label>
                                                </div>
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
                                        <div class="text-danger 
                                        mb-4">Note that you should continue to make mortgage payments that are due and payable prior to closing. Do not close (freeze) any lines of credit prior to closing
                                        </div>

                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group mb-4">
                                                    <label for="" class="mb-2">1st Bank / Mortgage Company</label>
                                                    <input type="text" class="form-control" id="first_mortgage_company" name="first_mortgage_company" data-error="#first_mortgage_company-error">
                                                    <label id="first_mortgage_company-error" class="error text-danger" for="first_mortgage_company"></label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="form-group mb-4">
                                                    <label for="" class="mb-2">Loan Number</label>
                                                    <input type="text" class="form-control" id="first_mortgage_loan_number" name="first_mortgage_loan_number" data-error="#first_mortgage_loan_number-error">
                                                    <label id="first_mortgage_loan_number-error" class="error text-danger" for="first_mortgage_loan_number"></label>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group mb-3">
                                                    <label for="" class="mb-2">Phone Number</label>
                                                    <div class="row">
                                                        <div class="col-4 position-relative mb-3">
                                                            <input type="text" class="form-control" id="first_mortgage_area_code" name="first_mortgage_area_code" data-error="#first_mortgage_area_code-error">
                                                            <small class="small_label">Area Code</small>
                                                        </div>
                                                        <label id="first_mortgage_area_code-error" class="error text-danger error2" for="first_mortgage_area_code"></label>
                                                        <div class="col-8 position-relative mb-3">
                                                            <input type="text" class="form-control" id="first_mortgage_phone_number" name="first_mortgage_phone_number" data-error="#first_mortgage_phone_number-error">
                                                            <small class="small_label">Phone Number</small>
                                                        </div>
                                                        <label id="first_mortgage_phone_number-error" class="error text-danger error2" for="first_mortgage_phone_number"></label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <hr>

                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group mb-4">
                                                    <label for="" class="mb-2">2nd Bank / Mortgage Company</label>
                                                    <input type="text" class="form-control" id="second_mortgage_company" name="second_mortgage_company">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="form-group mb-4">
                                                    <label for="" class="mb-2">Loan Number</label>
                                                    <input type="text" class="form-control" id="second_mortgage_loan_number" name="second_mortgage_loan_number">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group mb-3">
                                                    <label for="" class="mb-2">Phone Number</label>
                                                    <div class="row">
                                                        <div class="col-4 position-relative">
                                                            <input type="text" class="form-control" id="second_mortgage_area_code" name="second_mortgage_area_code">
                                                            <small class="small_label">Area Code</small>
                                                        </div>
                                                        <div class="col-8 position-relative">
                                                            <input type="text" class="form-control" id="second_mortgage_phone_number" name="second_mortgage_phone_number">
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
                                                    <input type="text" class="form-control" id="third_mortgage_company" name="third_mortgage_company">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="form-group mb-4">
                                                    <label for="" class="mb-2">Loan Number</label>
                                                    <input type="text" class="form-control" id="third_mortgage_loan_number" name="third_mortgage_loan_number">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group mb-3">
                                                    <label for="" class="mb-2">Phone Number</label>
                                                    <div class="row">
                                                        <div class="col-4 position-relative">
                                                            <input type="text" class="form-control" id="third_mortgage_area_code" name="third_mortgage_area_code">
                                                            <small class="small_label">Area Code</small>
                                                        </div>
                                                        <div class="col-8 position-relative">
                                                            <input type="text" class="form-control" id="third_mortgage_phone_number" name="third_mortgage_phone_number">
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
                                                    <label for="" class="mb-2">Lienholder Name 1</label>
                                                    <input type="text" class="form-control" id="first_lien_holder_name" name="first_lien_holder_name" data-error="#first_lien_holder_name-error">
                                                    <label id="first_lien_holder_name-error" class="error text-danger" for="first_lien_holder_name"></label>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group mb-4">
                                                    <label for="" class="mb-2">Amount Owed 1</label>
                                                    <input type="text" class="form-control" id="first_amount_owed" name="first_amount_owed" data-error="#first_amount_owed-error">
                                                    <label id="first_amount_owed-error" class="error text-danger" for="first_amount_owed"></label>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group mb-4">
                                                    <label for="" class="mb-2">Lienholder Name 2</label>
                                                    <input type="text" class="form-control" id="second_lien_holder_name" name="second_lien_holder_name">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group mb-4">
                                                    <label for="" class="mb-2">Amount Owed 2</label>
                                                    <input type="text" class="form-control" id="second_amount_owed" name="second_amount_owed">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="accordion-item d-none" id="association">
                                <h2 class="accordion-header" id="headingSeven">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseSeven" aria-expanded="false" aria-controls="collapseSeven">
                                      Association Information
                                    </button>
                                </h2>
                                <div id="collapseSeven" class="accordion-collapse collapse" aria-labelledby="headingSeven" data-bs-parent="#accordionExample">
                                    <div class="accordion-body">
                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="form-group mb-4">
                                                    <label for="" class="mb-2">Condominium / Homeowners Association 1</label>
                                                    <input type="text" class="form-control" id="first_homeowners_association" name="first_homeowners_association" data-error="#first_homeowners_association-error">
                                                    <label id="first_homeowners_association-error" class="error text-danger" for="first_homeowners_association"></label>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group mb-4">
                                                    <label for="" class="mb-2">Property Management Company</label>
                                                    <input type="text" class="form-control" id="first_property_management_company" name="first_property_management_company" data-error="#first_property_management_company-error">
                                                    <label id="first_property_management_company-error" class="error text-danger" for="first_property_management_company"></label>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group mb-4">
                                                    <label for="" class="mb-2">Property Management Number</label>
                                                    <input type="text" class="form-control" id="first_property_management_number" name="first_property_management_number" data-error="#first_property_management_number-error">
                                                    <label id="first_property_management_number-error" class="error text-danger" for="first_property_management_number"></label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="form-group mb-4">
                                                    <label for="" class="mb-2">Condominium / Homeowners Association 2</label>
                                                    <input type="text" class="form-control" id="second_homeowners_association" name="second_homeowners_association">
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group mb-4">
                                                    <label for="" class="mb-2">Property Management Company</label>
                                                    <input type="text" class="form-control" id="second_property_management_company" name="second_property_management_company">
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group mb-4">
                                                    <label for="" class="mb-2">Property Management Number</label>
                                                    <input type="text" class="form-control" id="second_property_management_number" name="second_property_management_number">
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
                                                    <input type="radio" id="wire" value="wire" name="sale_proceeds" required data-error="#sale_proceeds-error"> 
                                                    <label for="wire">Wire Funds</label>
                                                </li>
                                                <li>
                                                    <input type="radio" id="pickUp" value="pickUp" name="sale_proceeds"> 
                                                    <label for="pickUp">Pick Up Check</label>
                                                </li>
                                                <li>
                                                    <input type="radio" id="mailCheck" value="mailCheck" name="sale_proceeds"> 
                                                    <label for="mailCheck">Mail Check</label>
                                                </li>
                                            </ul>
                                            <label id="sale_proceeds-error" class="error text-danger" for="sale_proceeds"></label>
                                            <div class="mailAddress d-none">
                                                <div class="form-group position-relative mb-3">
                                                    <label for="" class="mb-2"><b>Address Closing Proceeds to be Mailed To
                                                    </b></label>
                                                    <input type="text" class="form-control" id="closing_proceeds_street_address" name="closing_proceeds_street_address" data-error="#closing_proceeds_street_address-error">
                                                    <small class="small_label">Street Address</small>
                                                </div>
                                                <label id="closing_proceeds_street_address-error" class="error text-danger error2" for="closing_proceeds_street_address"></label>
                                                <div class="form-group position-relative mb-3">
                                                    <input type="text" class="form-control" id="closing_proceeds_street_address2" name="closing_proceeds_street_address2" data-error="#closing_proceeds_street_address2-error">
                                                    <small  class="small_label">Street Address Line 2</small>
                                                </div>
                                                <label id="closing_proceeds_street_address2-error" class="error text-danger error2" for="closing_proceeds_street_address2"></label>
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="form-group position-relative mb-3">
                                                            <input type="text" class="form-control" id="closing_proceeds_city" name="closing_proceeds_city" data-error="#closing_proceeds_city-error">
                                                            <small  class="small_label">City</small>
                                                        </div>
                                                        <label id="closing_proceeds_city-error" class="error text-danger error2" for="closing_proceeds_city"></label>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group position-relative mb-3">
                                                            <input type="text" class="form-control" id="closing_proceeds_state" name="closing_proceeds_state" data-error="#closing_proceeds_state-error">
                                                            <small  class="small_label">State / Province</small>
                                                        </div>
                                                        <label id="closing_proceeds_state-error" class="error text-danger error2" for="closing_proceeds_state"></label>
                                                    </div>    
                                                </div>
                                                <div class="form-group position-relative mb-3 col-md-6">
                                                    <input type="text" class="form-control" id="closing_proceeds_zipcode" name="closing_proceeds_zipcode" data-error="#closing_proceeds_zipcode-error">
                                                    <small  class="small_label">Postal / Zip Code</small>
                                                </div>
                                                <label id="closing_proceeds_zipcode-error" class="error text-danger error2" for="closing_proceeds_zipcode"></label>
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
                                        <div class="row mb-4">
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="" class="mb-2">Name On Account</label>
                                                    <input type="text" class="form-control" id="name_on_account" name="name_on_account" data-error="#name_on_account-error">
                                                </div>
                                                <label id="name_on_account-error" class="error text-danger error2" for="name_on_account"></label>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="" class="mb-2">Bank Name</label>
                                                    <input type="text" class="form-control" id="bank_name" name="bank_name" data-error="#bank_name-error">
                                                </div>
                                                <label id="bank_name-error" class="error text-danger error2" for="bank_name"></label>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="" class="mb-2">Bank City</label>
                                                    <input type="text" class="form-control" id="bank_city" name="bank_city" data-error="#bank_city-error">
                                                </div>
                                                <label id="bank_city-error" class="error text-danger error2" for="bank_city"></label>
                                            </div>
                                        </div>
                                        <div class="row mb-4">
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="" class="mb-2">Bank State</label>
                                                    <input type="text" class="form-control" id="bank_state" name="bank_state" data-error="#bank_state-error">
                                                </div>
                                                <label id="bank_state-error" class="error text-danger error2" for="bank_state"></label>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="" class="mb-2">Account Number</label>
                                                    <input type="text" class="form-control" id="account_number" name="account_number" data-error="#account_number-error">
                                                </div>
                                                <label id="account_number-error" class="error text-danger error2" for="account_number"></label>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="" class="mb-2">Routing Number</label>
                                                    <input type="text" class="form-control" id="routing_number" name="routing_number" data-error="#routing_number-error">
                                                </div>
                                                <label id="routing_number-error" class="error text-danger error2" for="routing_number"></label>
                                            </div>
                                        </div>
                                        <div class="mailAddress">
                                            <div class="form-group position-relative mb-3">
                                                <label for="" class="mb-2"><b>Address Associated with Account Number
                                                </b></label>
                                                <input type="text" class="form-control" id="street_address_for_account" name="street_address_for_account" data-error="#street_address_for_account-error">
                                                <small class="small_label">Street Address</small>
                                            </div>
                                            <label id="street_address_for_account-error" class="error text-danger error2" for="street_address_for_account"></label>
                                            <div class="form-group position-relative mb-3">
                                                <input type="text" class="form-control" id="street_address2_for_account" name="street_address2_for_account" data-error="#street_address2_for_account-error">
                                                <small  class="small_label">Street Address Line 2</small>
                                            </div>
                                            <label id="street_address2_for_account-error" class="error text-danger error2" for="street_address2_for_account"></label>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group position-relative mb-3">
                                                        <input type="text" class="form-control" id="city_for_account" name="city_for_account" data-error="#city_for_account-error">
                                                        <small  class="small_label">City</small>
                                                    </div>
                                                    <label id="city_for_account-error" class="error text-danger error2" for="city_for_account"></label>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group position-relative mb-3">
                                                        <input type="text" class="form-control" id="state_for_account" name="state_for_account" data-error="#state_for_account-error">
                                                        <small  class="small_label">State / Province</small>
                                                    </div>
                                                    <label id="state_for_account-error" class="error text-danger error2" for="state_for_account"></label>
                                                </div>    
                                            </div>
                                            <div class="form-group position-relative mb-3 col-md-6">
                                                <input type="text" class="form-control" id="zipcode_for_account" name="zipcode_for_account" data-error="#zipcode_for_account-error">
                                                <small  class="small_label">Postal / Zip Code</small>
                                            </div>
                                            <label id="zipcode_for_account-error" class="error text-danger error2" for="zipcode_for_account"></label>
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
                                                <input type="text" class="w30 input_single" id="vesting_form_date" name="vesting_form_date" required data-error="#vesting_form_date-error">
                                                <label id="vesting_form_date-error" class="error text-danger error2" for="vesting_form_date"></label>
                                            </div>
                                            
                                            <input type="text" class="signature" value="" id="vesting_form_signature" name="vesting_form_signature" required data-error="#vesting_form_signature-error"> 
                                            <label id="vesting_form_signature-error" class="error text-danger error2" for="vesting_form_signature"></label>                
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
                                                    <input type="text" class="form-control f700 f12" value="" id="assessors_parcel_number" name="assessors_parcel_number" required data-error="#assessors_parcel_number-error">
                                                    <small class="small_label">ASSESSOR'S PARCEL NUMBER</small>
                                                </div>
                                                <label id="assessors_parcel_number-error" class="error text-danger error2" for="assessors_parcel_number"></label>
                                                <div class="form-group position-relative mb-3">
                                                    <input type="text" class="form-control f700 f12" id="transferor" name="transferor" required data-error="#transferor-error">
                                                    <small class="small_label">SELLER/TRANSFEROR</small>
                                                </div>
                                                <label id="transferor-error" class="error text-danger error2" for="transferor"></label>
                                                <div class="form-group position-relative mb-3">
                                                    <input type="text" class="form-control f700 f12" id="buyer_daytime_phone_number" name="buyer_daytime_phone_number" required data-error="#buyer_daytime_phone_number-error">
                                                    <small class="small_label">BUYER'S DAYTIME TELEPHONE NUMBER</small>
                                                </div>
                                                <label id="buyer_daytime_phone_number-error" class="error text-danger error2" for="buyer_daytime_phone_number"></label>
                                                <div class="form-group position-relative mb-3">
                                                    <input type="text" class="form-control f700 f12" id="buyer_email_address" name="buyer_email_address" required data-error="#buyer_email_address-error">
                                                    <small class="small_label">BUYER'S EMAIL ADDRESS</small>
                                                </div>
                                                <label id="buyer_email_address-error" class="error text-danger error2" for="buyer_email_address"></label>
                                            </div>
                                        </div>
                                        
                                        <div class="form-group position-relative mb-3">
                                            <input type="text" class="form-control f700 f12" value="" id="real_property_addres" name="real_property_addres" required data-error="#real_property_addres-error">
                                            <small class="small_label">STREET ADDRESS OR PHYSICAL LOCATION OF REAL PROPERTY </small>
                                        </div>
                                        <label id="real_property_addres-error" class="error text-danger error2" for="real_property_addres"></label>

                                        <table class="table yesno_table">
                                            <tr>
                                                <th><b>YES</b></th>
                                                <th><b>NO</b></th>
                                                <th></th>
                                            </tr>
                                            <tr>
                                                <td><input type="radio" name="is_principal_residence" id="checkYes0" value="yes" required data-error="#is_principal_residence-error"></td>
                                                <td><input type="radio" name="is_principal_residence" id="checkNo0" value="no"></td>
                                                <td>
                                                    This property is intended as my principal residence. If YES, please indicate the date of occupancy or intended occupancy.
                                                    <div class="d-flex date_group">
                                                        <input type="text" class="form-control" placeholder="MO" id="intended_occupancy_month" name="intended_occupancy_month">
                                                        <input type="text" class="form-control" placeholder="DAY" id="intended_occupancy_day" name="intended_occupancy_day">
                                                        <input type="text" class="form-control" placeholder="YEAR" id="intended_occupancy_year" name="intended_occupancy_year">
                                                    </div>
                                                    <label id="is_principal_residence-error" class="error text-danger" for="is_principal_residence"></label>
                                                </td>
                                            </tr>
                                            
                                            <tr>
                                                <td><input type="radio" name="is_disabled_veteran" id="checkYes1" value="yes" required data-error="#is_disabled_veteran-error"></td>
                                                <td><input type="radio" name="is_disabled_veteran" id="checkNo1" value="no"></td>
                                                <td>
                                                    Are you a disabled veteran or a unmarried surviving spouse of a disabled veteran who was compensated at 100% by the Department of Veterans Affairs?
                                                    <label id="is_disabled_veteran-error" class="error text-danger d-flex" for="is_disabled_veteran"></label>
                                                </td>
                                            </tr>
                                        </table>

                                        <div class="form-group position-relative mb-3">
                                            <input type="text" class="form-control f700 f12" value="" id="mail_property_tax_name" name="mail_property_tax_name" required data-error="#mail_property_tax_name-error">
                                            <small class="small_label">MAIL PROPERTY TAX INFORMATION TO (NAME)</small>
                                        </div>
                                        <label id="mail_property_tax_name-error" class="error text-danger error2" for="mail_property_tax_name"></label>

                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group position-relative mb-3">
                                                    <input type="text" class="form-control f700 f12" value="" id="mail_property_tax_address" name="mail_property_tax_address" required data-error="#mail_property_tax_address-error">
                                                    <small class="small_label">MAIL PROPERTY TAX INFORMATION TO (ADDRESS)</small>
                                                </div>
                                                <label id="mail_property_tax_address-error" class="error text-danger error2" for="mail_property_tax_address"></label>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group position-relative mb-3">
                                                    <input type="text" class="form-control f700 f12" value="" id="mail_property_tax_city" name="mail_property_tax_city" required data-error="#mail_property_tax_city-error">
                                                    <small class="small_label">CITY </small>
                                                </div>
                                                <label id="mail_property_tax_city-error" class="error text-danger error2" for="mail_property_tax_city"></label>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group position-relative mb-3">
                                                    <input type="text" class="form-control f700 f12" value="" id="mail_property_tax_state" name="mail_property_tax_state" required data-error="#mail_property_tax_state-error">
                                                    <small class="small_label">STATE </small>
                                                </div>
                                                <label id="mail_property_tax_state-error" class="error text-danger error2" for="mail_property_tax_state"></label>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group position-relative mb-3">
                                                    <input type="text" class="form-control f700 f12" value="" id="mail_property_tax_zipcode" name="mail_property_tax_zipcode" required data-error="#mail_property_tax_zipcode-error">
                                                    <small class="small_label">ZIP CODE</small>
                                                </div>
                                                <label id="mail_property_tax_zipcode-error" class="error text-danger error2" for="mail_property_tax_zipcode"></label>
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
                                                <td><input type="radio" name="is_transfer_between_spouses" id="checkYes2" value="yes" required data-error="#is_transfer_between_spouses-error"></td>
                                                <td><input type="radio" name="is_transfer_between_spouses" id="checkNo2" value="no"></td>
                                                <td>
                                                    This transfer is solely between spouses (addition or removal of a spouse, death of a spouse, divorce settlement, etc.).
                                                    <label id="is_transfer_between_spouses-error" class="error text-danger d-flex" for="is_transfer_between_spouses"></label>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>B.</td>
                                                <td><input type="radio" name="is_transfer_between_domestic_partners" id="checkYes3" value="yes" required data-error="#is_transfer_between_domestic_partners-error"></td>
                                                <td><input type="radio" name="is_transfer_between_domestic_partners" id="checkNo3" value="no" id="second_buyer_middle_name"></td>
                                                <td>
                                                    This transfer is solely between domestic partners currently registered with the California Secretary of State <em>
                                                        (addition or removal of a partner, death of a partner, termination settlement, etc.). 
                                                    </em>
                                                    <label id="is_transfer_between_domestic_partners-error" class="error text-danger d-flex" for="is_transfer_between_domestic_partners"></label>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>C.</td>
                                                <td><input type="radio" name="is_transfer" id="checkYes4" value="yes" required data-error="#is_transfer-error"></td>
                                                <td><input type="radio" name="is_transfer" id="checkNo4" value="no"></td>
                                                <td>
                                                    This is a transfer:
                                                    <label id="is_transfer-error" class="error text-danger d-flex" for="is_transfer"></label>
                                                    <div class="d-flex">
                                                        <input type="radio" name="is_parent_child_transfer" id="parentchild1" value="yes" class="me-2" required data-error="#is_parent_child_transfer-error"> <label for="parentchild1">between parent(s) and child(ren)</label>
                                                    </div>
                                                    <div class="d-flex">
                                                        <input type="radio" name="is_parent_child_transfer" id="parentchild2" value="no" class="me-2"> <label for="parentchild2">between grandparent(s) and grandchild(ren).</label>
                                                    </div>
                                                    <label id="is_parent_child_transfer-error" class="error text-danger d-flex" for="is_parent_child_transfer"></label>
                                                    <div class="mt-2">
                                                        Was this the transferor/grantor's principal residence? &nbsp;
                                                        <input type="radio" name="is_principal_residence" id="principal1" value="yes" class="me-2"  required data-error="#is_principal_residence-error"> <label for="principal1">YES</label>
                                                        <input type="radio" name="is_principal_residence" id="principal2" value="no" class="me-2">NO</label>
                                                    </div>
                                                    <label id="is_principal_residence-error" class="error text-danger d-flex" for="is_principal_residence"></label>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>D.</td>
                                                <td><input type="radio" name="is_cotenant_death" id="checkYes5" value="yes" required data-error="#is_cotenant_death-error"></td>
                                                <td><input type="radio" name="is_cotenant_death" id="checkNo5" value="no"></td>
                                                <td>
                                                    This transfer is the result of a cotenant’s death. Date of death <input type="text" class="input_single" name="date_of_death" id="date_of_death">
                                                    <label id="is_cotenant_death-error" class="error text-danger d-flex" for="is_cotenant_death"></label>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>E.</td>
                                                <td><input type="radio" name="is_replace_principal_residence_own" id="checkYes6" value="yes" required data-error="#is_replace_principal_residence_own-error"></td>
                                                <td><input type="radio" name="is_replace_principal_residence_own" id="checkNo6" value="no"></td>
                                                <td>
                                                    This transaction is to replace a principal residence owned by a person 55 years of age or older.<br>
                                                    <label id="is_replace_principal_residence_own-error" class="error text-danger d-flex" for="is_replace_principal_residence_own"></label>
                                                    Within the same county?  &nbsp;
                                                    <input type="radio" name="is_replace_principal_residence_own_in_same_county" id="sameCountry1" class="me-2" value="yes" required data-error="#is_replace_principal_residence_own_in_same_county-error"> <label for="sameCountry1">YES</label>
                                                    <input type="radio" name="is_replace_principal_residence_own_in_same_county" id="sameCountry2" class="me-2" value="no"> <label for="sameCountry2">NO</label>
                                                    <label id="is_replace_principal_residence_own_in_same_county-error" class="error text-danger d-flex" for="is_replace_principal_residence_own_in_same_county"></label>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>F.</td>
                                                <td><input type="radio" name="is_replace_principal_residence_person_disabled" id="checkYes7" value="yes" required data-error="#is_replace_principal_residence_person_disabled-error"></td>
                                                <td><input type="radio" name="is_replace_principal_residence_person_disabled" id="checkNo7" value="no"></td>
                                                <td>
                                                    This transaction is to replace a principal residence by a person who is severely disabled.<br>
                                                    <label id="is_replace_principal_residence_person_disabled-error" class="error text-danger d-flex" for="is_replace_principal_residence_person_disabled"></label>
                                                    Within the same county?  &nbsp;
                                                    <input type="radio" name="is_replace_principal_residence_person_disabled_in_same_county" id="severeDisabled1" class="me-2" value="yes" required data-error="#is_replace_principal_residence_person_disabled_in_same_county-error"> <label for="severeDisabled1">YES</label>
                                                    <input type="radio" name="is_replace_principal_residence_person_disabled_in_same_county" id="severeDisabled2" class="me-2" value="no"> <label for="severeDisabled2">NO</label>
                                                    <label id="is_replace_principal_residence_person_disabled_in_same_county-error" class="error text-danger d-flex" for="is_replace_principal_residence_person_disabled_in_same_county"></label>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>G.</td>
                                                <td><input type="radio" name="is_replace_principal_residence_damaged" id="checkYes8" value="yes" required data-error="#is_replace_principal_residence_damaged-error"></td>
                                                <td><input type="radio" name="is_replace_principal_residence_damaged" id="checkNo8" value="no"></td>
                                                <td>
                                                    This transaction is to replace a principal residence substantially damaged or destroyed by a wildfire or natural disaster for which the Governor proclaimed a state of emergency. <br>
                                                    <label id="is_replace_principal_residence_damaged-error" class="error text-danger d-flex" for="is_replace_principal_residence_damaged"></label>
                                                    Within the same county?  &nbsp;
                                                    <input type="radio" name="is_replace_principal_residence_damaged_in_same_county" id="damage1" class="me-2" value="yes" required data-error="#is_replace_principal_residence_damaged_in_same_county-error"> <label for="damage1">YES</label>
                                                    <input type="radio" name="is_replace_principal_residence_damaged_in_same_county" id="damage2" class="me-2" value="no"> <label for="damage2">NO</label>
                                                    <label id="is_replace_principal_residence_damaged_in_same_county-error" class="error text-danger d-flex" for="is_replace_principal_residence_damaged_in_same_county"></label>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>H.</td>
                                                <td><input type="radio" name="is_name_change" id="checkYes9" value="yes" required data-error="#is_name_change-error"></td>
                                                <td><input type="radio" name="is_name_change" id="checkNo9" value="no"></td>
                                                <td>
                                                    This transaction is only a correction of the name(s) of the person(s) holding title to the property (e.g., a name change
                                                    upon marriage). If YES, please explain:  &nbsp;
                                                    <input type="text" class="input_single" name="name_change_reason" id="name_change_reason">
                                                    <label id="is_name_change-error" class="error text-danger d-flex" for="is_name_change"></label>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>I.</td>
                                                <td><input type="radio" name="is_lender_interest" id="checkYes10" value="yes" required data-error="#is_lender_interest-error"></td>
                                                <td><input type="radio" name="is_lender_interest" id="checkNo10" value="no"></td>
                                                <td>
                                                    The recorded document creates, terminates, or reconveys a lender's interest in the property. &nbsp;
                                                    <input type="text" class="input_single" name="lender_interest_reason" id="lender_interest_reason">
                                                    <label id="is_lender_interest-error" class="error text-danger d-flex" for="is_lender_interest"></label>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>J.</td>
                                                <td><input type="radio" name="is_financing_purpose" id="checkYes11" value="yes" required data-error="#is_financing_purpose-error"></td>
                                                <td><input type="radio" name="is_financing_purpose" id="checkNo11" value="no"></td>
                                                <td>
                                                    This transaction is recorded only as a requirement for financing purposes or to create, terminate, or reconvey a security
                                                    interest (e.g., cosigner). If YES, please explain:  &nbsp;
                                                    <input type="text" class="input_single" name="financing_purpose_reason" id="financing_purpose_reason">
                                                    <label id="is_financing_purpose-error" class="error text-danger d-flex" for="is_financing_purpose"></label>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>K.</td>
                                                <td><input type="radio" name="is_trustee_of_trust" id="checkYes12" value="yes" required data-error="#is_trustee_of_trust-error"></td>
                                                <td><input type="radio" name="is_trustee_of_trust" id="checkNo12" value="no"></td>
                                                <td>
                                                    The recorded document substitutes a trustee of a trust, mortgage, or other similar document.   &nbsp;
                                                    <label id="is_trustee_of_trust-error" class="error text-danger d-flex" for="is_trustee_of_trust"></label>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>L.</td>
                                                <td><input type="radio" name="is_transfer_property" id="checkYes13" value="yes" required data-error="#is_transfer_property-error"></td>
                                                <td><input type="radio" name="is_transfer_property" id="checkNo13" value="no"></td>
                                                <td>
                                                    This is a transfer of property:
                                                    <label id="is_transfer_property-error" class="error text-danger d-flex" for="is_transfer_property"></label>
                                                    <div class="pl-3 mb-3">
                                                        1. to/from a revocable trust that may be revoked by the transferor and is for the benefit of <br>
                                                        <input type="radio" name="benefit" id="benefit1" class="me-2" value="transferor" required data-error="#benefit-error"> <label for="benefit1">the transferor, and/or</label>
                                                        <input type="radio" name="benefit" id="benefit2" class="me-2" value="transferor_spouse"> <label for="benefit2">the transferor's spouse</label>
                                                        <input type="radio" name="benefit" id="benefit3" class="me-2" value="registered_domestic_partner"> <label for="benefit3"> registered domestic partner.</label>
                                                    </div>
                                                    <label id="benefit-error" class="error text-danger d-flex" for="benefit"></label>
                                                    <div class="pl-3">
                                                        2. to/from an irrevocable trust for the benefit of the <br>
                                                        <input type="radio" name="trustor" id="trustor1" class="me-2" value="transferor" required data-error="#trustor-error"> <label for="trustor1">the transferor, and/orreator/grantor/trustor and/or         </label>
                                                        <input type="radio" name="trustor" id="trustor2" class="me-2" value="trustor_spouse"> <label for="trustor2">grantor's/trustor's spouse</label>
                                                        <input type="radio" name="trustor" id="trustor3" class="me-2" value="trustor_registered_domestic_partner"> <label for="trustor3"> grantor's/trustor's registered domestic partner</label>
                                                    </div>
                                                    <label id="trustor-error" class="error text-danger d-flex" for="trustor"></label>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>M.</td>
                                                <td><input type="radio" name="is_subject_to_lease" id="checkYes14" value="yes" required data-error="#is_subject_to_lease-error"></td>
                                                <td><input type="radio" name="is_subject_to_lease" id="checkNo14" value="no"></td>
                                                <td>
                                                    This property is subject to a lease with a remaining lease term of 35 years or more including written options.
                                                    <label id="is_subject_to_lease-error" class="error text-danger d-flex" for="is_subject_to_lease"></label>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>N.</td>
                                                <td><input type="radio" name="is_transfer_between_parties" id="checkYes15" value="yes" required data-error="#is_transfer_between_parties-error"></td>
                                                <td><input type="radio" name="is_transfer_between_parties" id="checkNo15" value="no"></td>
                                                <td>
                                                    This is a transfer between parties in which proportional interests of the transferor(s) and transferee(s) in each and every parcel being transferred remain exactly the same after the transfer
                                                    <label id="is_transfer_between_parties-error" class="error text-danger d-flex" for="is_transfer_between_parties"></label>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>O.</td>
                                                <td><input type="radio" name="is_subsidized_low_income" id="checkYes16" value="yes" required data-error="#is_subsidized_low_income-error"></td>
                                                <td><input type="radio" name="is_subsidized_low_income" id="checkNo16" value="no"></td>
                                                <td>
                                                    This is a transfer subject to subsidized low-income housing requirements with governmentally imposed restrictions, or restrictions imposed by specified nonprofit corporations.
                                                    <label id="is_subsidized_low_income-error" class="error text-danger d-flex" for="is_subsidized_low_income"></label>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>P.</td>
                                                <td><input type="radio" name="is_solar_energy_system" id="checkYes17" value="yes" required data-error="#is_solar_energy_system-error"></td>
                                                <td><input type="radio" name="is_solar_energy_system" id="checkNo17" value="no"></td>
                                                <td>
                                                    This transfer is to the first purchaser of a new building containing an active solar energy system.
                                                    <label id="is_solar_energy_system-error" class="error text-danger d-flex" for="is_solar_energy_system"></label>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Q.</td>
                                                <td><input type="radio" name="is_transfer_other" id="checkYes18" value="yes" required data-error="#is_transfer_other-error"></td>
                                                <td><input type="radio" name="is_transfer_other" id="checkNo18" value="no"></td>
                                                <td>
                                                    Other. This transfer is to 
                                                    <input type="text" class="input_single" name="other_transfer" id="other_transfer">
                                                    <label id="is_transfer_other-error" class="error text-danger d-flex" for="is_transfer_other"></label>
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
                                                    <input type="date" class="input_single" id="recording_date" value="" name="recording_date" required data-error="#recording_date-error">
                                                    <label id="recording_date-error" class="error text-danger d-flex" for="recording_date"></label>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>B.</td>
                                                <td>
                                                    Type of transfer: 
                                                    <div class="row">
                                                        <div class="col-lg-2 col-md-6">
                                                            <div class="d-flex">
                                                                <input type="checkbox" class="mt-2 me-2" id="purchase" value="purchase" name="types_of_transfer[]" required data-error="#types_of_transfer-error">
                                                                <label for="purchase">Purchase</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-2 col-md-6">
                                                            <div class="d-flex">
                                                                <input type="checkbox" class="mt-2 me-2" id="foreclosure" value="foreclosure" name="types_of_transfer[]">
                                                                <label for="foreclosure">Foreclosure</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-3 col-md-6">
                                                            <div class="d-flex">
                                                                <input type="checkbox" class="mt-2 me-2" id="trade" value="trade_of_exchange" name="types_of_transfer[]">
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
                                                            Contract of sale. Date of contract <input type="date" class="input_single" id="date_of_contract" name="date_of_contract" required data-error="#date_of_contract-error">
                                                            <label id="date_of_contract-error" class="error text-danger d-flex" for="date_of_contract"></label>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <input type="checkbox" id="inheritance" value="inheritance" name="types_of_transfer[]"> 
                                                            <label for="inheritance">Inheritance. Date of death: 
                                                            <input type="date" class="input_single" id="date_of_death_transfer" name="date_of_death_transfer" required data-error="#date_of_death_transfer-error"></label>
                                                            <label id="date_of_death_transfer-error" class="error text-danger d-flex" for="date_of_death_transfer"></label>
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
                                                                    <input type="date" class="input_single" id="date_of_lease_began" name="date_of_lease_began" required data-error="#date_of_lease_began-error"></label>
                                                                <label id="date_of_lease_began-error" class="error text-danger d-flex" for="date_of_lease_began"></label>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="mt-3">
                                                        Original term in years (including written options): 
                                                         <input type="text" class="input_single w-small" id="original_terms_in_year" name="original_terms_in_year"> 
                                                         Remaining term in years (including written options):   
                                                         <input type="text"  class="input_single w-small" id="remaining_terms_in_year" name="remaining_terms_in_year">
                                                    </div>
                                                    <label id="types_of_transfer-error" class="error text-danger d-flex" for="types_of_transfer"></label>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>C.</td>
                                                <td>
                                                    Only a partial interest in the property was transferred.
                                                    <input type="radio" name="is_partial_interest" id="propertYes" required data-error="#is_partial_interest-error" value="yes">&nbsp;<label for="propertYes">YES</label> &nbsp;
                                                    <input type="radio" name="is_partial_interest" id="propertNo" value="no">&nbsp;<label for="propertNo">NO</label>&nbsp;
                                                    If YES, indicate the percentage transferred: 
                                                    <input type="text" class="input_single w-medium" id="start_percentage_range" name="start_percentage_range"> % 
                                                    <input type="text" class="input_single w-medium" id="end_percentage_range" name="end_percentage_range">
                                                    <label id="is_partial_interest-error" class="error text-danger d-flex" for="is_partial_interest"></label>
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
                                                            <input type="text" class="input_single" id="total_purchase_price" name="total_purchase_price" required data-error="#total_purchase_price-error"></div>
                                                            
                                                    </div>
                                                    <label id="total_purchase_price-error" class="error text-danger d-flex" for="total_purchase_price"></label>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>B.</td>
                                                <td>
                                                    <div class="d-flex justify-content-between">
                                                        Cash down payment or value of trade or exchange excluding closing costs  <div>Amount $ 
                                                            <input type="text" class="input_single" id="cash_down_payment" name="cash_down_payment" required data-error="#cash_down_payment-error"></div>
                                                            
                                                    </div>
                                                    <label id="cash_down_payment-error" class="error text-danger d-flex" for="cash_down_payment"></label>
                                                </td>
                                            </tr>       
                                            <tr>
                                                <td>C.</td>
                                                <td>
                                                    First deed of trust @ &nbsp;
                                                   <input type="text" class="input_single w-small" id="first_deed_of_trust_interest" name="first_deed_of_trust_interest"> % interest for 
                                                   <input type="text" class="input_single w-small" id="first_deed_of_trust_years" name="first_deed_of_trust_years">years. 
                                                   Monthly payment $ 
                                                   <input type="text" class="input_single" id="first_deed_of_trust_monthly_payment" name="first_deed_of_trust_monthly_payment" required data-error="#first_deed_of_trust_monthly_payment-error">
                                                   <label id="first_deed_of_trust_monthly_payment-error" class="error text-danger d-flex" for="first_deed_of_trust_monthly_payment"></label>                    
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
                                                                <label for="due_date">Due date: <input type="date" class="input_single" id="first_deed_due_date" name="first_deed_due_date"></label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>D.</td>
                                                <td>
                                                    <div>
                                                        Second deed of trust @  <input type="text" class="input_single w-small" id="second_deed_of_trust_interest" name="second_deed_of_trust_interest"> % interest for 
                                                        <input type="text" class="input_single w-small" id="second_deed_of_trust_years" name="second_deed_of_trust_years"> years.   
                                                        Monthly payment $ <input type="text" class="input_single" id="second_deed_of_trust_monthly_payment" name="second_deed_of_trust_monthly_payment">  
                                                        Amount $ <input type="text" class="input_single" id="second_deed_of_trust_amount" name="second_deed_of_trust_amount">
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
                                                                <label for="ballon_pay">Balloon payment $ <input type="text" class="input_single w-small" id="ballon_payment" name="ballon_payment"></label>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <div class="d-flex">
                                                                <input type="checkbox" class="mt-2 me-2" id="second_due_date" value="second_due_date" name="second_deed_payment_types[]">
                                                                <label for="date_due"> Due date: <input type="date" class="input_single" id="second_deed_due_date" name="second_deed_due_date"></label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>E.</td>
                                                <td>
                                                    Was an Improvement Bond or other public financing assumed by the buyer?    &nbsp;
                                                    <input type="radio" name="is_financing" id="financingYes" required data-error="#is_financing-error" value="yes">&nbsp;<label for="financingYes">YES</label> &nbsp;
                                                    <input type="radio" name="is_financing" id="financingNo" value="no">&nbsp;<label for="financingNo">NO</label>&nbsp;
                                                    Outstanding balance $ <input type="text" class="input_single w-medium" id="outstanding_balance" name="outstanding_balance">
                                                    <label id="is_financing-error" class="error text-danger d-flex" for="is_financing"></label>                    
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>F.</td>
                                                <td>
                                                    Amount, if any, of real estate commission fees paid by the buyer which are not included in the purchase price $ 
                                                    <input type="text" class="input_single w-medium" id="real_estate_commission" name="real_estate_commission" required data-error="#real_estate_commission-error">
                                                    <label id="real_estate_commission-error" class="error text-danger d-flex" for="real_estate_commission"></label>    
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>G.</td>
                                                <td>
                                                    he property was purchased: 
                                                    <div class="mt-3">
                                                        <input type="radio" name="property_purchase_via" id="real_estate" required data-error="#property_purchase_via-error" value="real_estate"> 
                                                        <label for="broker_name"> Through real estate broker.</label> 
                                                        Broker name: <input type="text" class="input_single" id="broker_name" name="broker_name"> 
                                                        Phone number: <input type="text" class="input_single" id="broker_phone_number" name="broker_phone_number">
                                                    </div>
                                                    <div class="mt-3">
                                                        <input type="radio" name="property_purchase_via" id="direct" value="direct_from_seller"> <label for="direct">Direct from seller</label>  &nbsp;
                                                        <input type="radio" name="property_purchase_via" id="direct" value="family_member_relationship"> <label for="family">From a family member-Relationship  &nbsp;
                                                        <input type="text" class="input_single" id="property_purchase_via_name" name="property_purchase_via_name"></label>  
                                                    </div>
                                                    <div class="mt-3">
                                                        <input type="radio" name="property_purchase_via" id="other" value="other"> 
                                                        <label for="Other">Other. Please explain: 
                                                            <input type="text" class="input_single" id="other_through" name="other_through">
                                                        </label>  
                                                    </div>
                                                    <label id="property_purchase_via-error" class="error text-danger d-flex" for="property_purchase_via"></label> 
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
                                                                <input type="text" class="input_single" id="num_of_units" name="num_of_units"></label>
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
                                                            <input type="radio" name="is_personal_property" id="bpropertyYes" value="yes" required data-error="#is_personal_property-error">&nbsp; <label for="bpropertyYes">YES</label>&nbsp;
                                                            <input type="radio" name="is_personal_property" id="bpropertyNo" value="no">&nbsp; <label for="bpropertyNo">NO</label> &nbsp;
                                                        </div>
                                                        <div>
                                                            Personal/business property, or incentives, provided by seller to buyer are included in the purchase price. Examples of personal property are furniture, farm equipment, machinery, etc. Examples of incentives are club memberships, etc. Attach list if available.
                                                        </div>
                                                    </div>
                                                    <label id="is_personal_property-error" class="error text-danger d-flex" for="is_personal_property"></label> 

                                                    If YES, enter the value of the personal/business property: $ <input type="text" class="input_single w-medium" id="peronal_property_value" name="peronal_property_value"> 
                                                    Incentives $ <input type="text" class="input_single w-medium" id="incentives" name="incentives">
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>C.</td>
                                                <td>
                                                    <div class="d-flex">
                                                        <div class="me-3">
                                                            <input type="radio" name="is_manufacture_home_included_in_purchase_price" id="purchasePriceYes" value="yes" required data-error="#is_manufacture_home_included_in_purchase_price-error">&nbsp; <label for="purchasePriceYes">YES</label>&nbsp;
                                                            <input type="radio" name="is_manufacture_home_included_in_purchase_price" id="purchasePriceNo" value="no">&nbsp; <label for="purchasePriceNo">NO</label> &nbsp;
                                                        </div>
                                                        <div>
                                                            A manufactured home is included in the purchase price.
                                                        </div>
                                                        <label id="is_manufacture_home_included_in_purchase_price-error" class="error text-danger d-flex" for="is_manufacture_home_included_in_purchase_price"></label> 
                                                    </div>
                                                    <div class=" mt-3">
                                                        If YES, enter the value attributed to the manufactured home: $  
                                                        <input type="text" class="input_single w-medium" id="value_manufacture_home" name="value_manufacture_home">
                                                    </div>
                                                    <div class="d-flex mt-3">
                                                        <div class="me-3">
                                                            <input type="radio" name="is_manufacture_home_tax" id="manufacturedPriceYes" value="yes" required data-error="#is_manufacture_home_tax-error">&nbsp; <label for="manufacturedPriceYes">YES</label>&nbsp;
                                                            <input type="radio" name="is_manufacture_home_tax" id="manufacturedPriceNo" value="no">&nbsp; <label for="manufacturedPriceNo">NO</label> &nbsp;
                                                        </div>
                                                        <div>
                                                            The manufactured home is subject to local property tax. If NO, enter decal number  
                                                            <input type="text" class="input_single w-medium" id="deal_number" name="deal_number">
                                                        </div>
                                                        <label id="is_manufacture_home_tax-error" class="error text-danger d-flex" for="is_manufacture_home_tax"></label> 
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>D.</td>
                                                <td>
                                                    <div class="d-flex">
                                                        <div class="me-3">
                                                            <input type="radio" name="is_property_produce_income" id="purchasePriceYes" value="yes" required data-error="#is_property_produce_income-error">&nbsp; <label for="purchasePriceYes">YES</label>&nbsp;
                                                            <input type="radio" name="is_property_produce_income" id="purchasePriceNo" value="no">&nbsp; <label for="purchasePriceNo">NO</label> &nbsp;
                                                        </div>
                                                        <div>
                                                            The property produces rental or other income.
                                                        </div>
                                                        <label id="is_property_produce_income-error" class="error text-danger d-flex" for="is_property_produce_income"></label> 
                                                    </div>
                                                    <div class="mt-3">
                                                        If YES, the income is from: &nbsp;
                                                        <input type="radio" name="income_type" id="rent" value="rent"> &nbsp; <label for="rent">Lease/rent</label> &nbsp;
                                                        <input type="radio" name="income_type" id="contract" value="contract"> &nbsp; <label for="contract">Contract</label> &nbsp;
                                                        <input type="radio" name="income_type" id="mineral" value="mineral"> &nbsp; <label for="mineral">Mineral rights</label> &nbsp;
                                                        <input type="radio" name="income_type" id="other_income" value="other_income"> &nbsp; <label for="other_income">Other: &nbsp;
                                                        <input type="text" class="input_single" id="other_income_type" name="other_income_type"></label> &nbsp;
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>E.</td>
                                                <td>
                                                    <div>
                                                        The condition of the property at the time of sale was:  &nbsp;
                                                        <input type="radio" name="property_condition" id="good" value="good" required data-error="#property_condition-error"> &nbsp; <label for="good">Good   </label> &nbsp;
                                                        <input type="radio" name="property_condition" id="average" value="average"> &nbsp; <label for="average">Average   </label> &nbsp;
                                                        <input type="radio" name="property_condition" id="fair" value="fair"> &nbsp; <label for="fair">Fair   </label> &nbsp;
                                                        <input type="radio" name="property_condition" id="poor" value="poor"> &nbsp; <label for="poor">Poor</label> &nbsp;
                                                    </div>
                                                    <div class="mt-2"> Please describe: <input type="text" class="input_single" id="property_condition_describe" name="property_condition_describe"></div>
                                                    <label id="property_condition-error" class="error text-danger d-flex" for="property_condition"></label>                    
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
                                                    <input type="date" class="form-control" id="signature_corporate_officer_date" name="signature_corporate_officer_date" required data-error="#signature_corporate_officer_date-error">
                                                    <small class="small_label">DATE </small>
                                                         
                                                </div>
                                                <label id="signature_corporate_officer_date-error" class="error text-danger error2" for="signature_corporate_officer_date"></label>  
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group position-relative mb-3">
                                                    <input type="text" class="form-control" id="corporate_officer_telephone" name="corporate_officer_telephone" required data-error="#corporate_officer_telephone-error">
                                                    <small class="small_label">TELEPHONE</small>
                                                    
                                                </div>
                                                <label id="corporate_officer_telephone-error" class="error text-danger error2" for="corporate_officer_telephone"></label>       
                                            </div>
                                        </div>
                                        <div>NAME OF BUYER/TRANSFEREE/PERSONAL REPRESENTATIVE/CORPORATE OFFICER (PLEASE PRINT)</div>
                                        <div class="row mt-2">
                                            <div class="col-md-6">
                                                <div class="form-group position-relative mb-3">
                                                    <input type="text" class="form-control" id="corporate_officer_name" name="corporate_officer_name" required data-error="#corporate_officer_name-error">
                                                    <small class="small_label">TITLE  </small>
                                                   
                                                </div>
                                                <label id="corporate_officer_name-error" class="error text-danger error2" for="corporate_officer_name"></label>       
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group position-relative mb-3">
                                                    <input type="email" class="form-control" id="corporate_officer_email" name="corporate_officer_email" required data-error="#corporate_officer_email-error">
                                                    <small class="small_label">EMAIL ADDRESS</small>
                                                    
                                                </div>
                                                <label id="corporate_officer_email-error" class="error text-danger error2" for="corporate_officer_email"></label>     
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
                                <div id="collapseTen" class="accordion-collapse collapse" aria-labelledby="headingTen" data-bs-parent="#accordionExample">
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
                                <div id="collapseEleven" class="accordion-collapse collapse" aria-labelledby="headingEleven" data-bs-parent="#accordionExample">
                                    <div class="accordion-body">
                                        <div class="form-group d-flex mb-2">
                                            <input type="checkbox" id="acknowledge" name="acknowledge"  class="me-2 mt-1" required data-error="#acknowledge-error">
                                            <label for="acknowledge" class="mb-2">By clicking the submit button, I agree to terms & conditions.</label>
                                            <label id="acknowledge-error" class="error text-danger d-flex" for="acknowledge"></label>    
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
                                                    <input type="text" class="form-control" id="tenant_id" name="tenant_id" required data-error="#tenant_id-error">
                                                </div>
                                                <label id="tenant_id-error" class="error text-danger" for="tenant_id"></label>     
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group mb-3">
                                                    <label for="" class="mb-2"><b>DocType</b></label>
                                                    <input type="text" class="form-control" id="doc_type" name="doc_type" required data-error="#doc_type-error">
                                                </div>
                                                <label id="doc_type-error" class="error text-danger" for="doc_type"></label>     
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <p class="my-4">
							Signing below indicates that the information included here is correct and complete to the
							best of my knowledge and ackowledges and accepts the information included in this document
						</p>
						<h4 class="text-orange text-center mb-5">
							You must click SUBMIT below to securely send your completed forms to<br> Pacific Coast Title
							Company.
						</h4>
						<div class="text-center"><button type="submit" class="btn btn-primary">Submit</button></div>
                    </form>
                </div>
            </div>
        </div>
    </section>

    <script src="<?php echo base_url();?>assets/frontend/js/order/jquery.min.js"></script>
    <script src="<?php echo base_url();?>assets/frontend/js/jquery.validate.min.js"></script>
    <script src="<?php echo base_url();?>assets/frontend/js/order/bootstrap.bundle.min.js"></script>
    <script src="<?php echo base_url();?>assets/frontend/js/order/script.js?v=01"></script>
    <script src="<?php echo base_url();?>assets/frontend/js/order/signature_pad.min.js"></script>
</body>
</html>