<!DOCTYPE html>
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
                    <a href="#">
                        <img src="<?php echo base_url();?>assets/frontend/images/buyer-seller-package/alanna-logo.png" alt="" class="img-fluid img_logo">
                    </a>
                </div>
                
            </div>
        </div>
    </header>
    <section class="form_content">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <form name="borrower_buyer_form" id="borrower_buyer_form">
                        <h2 class="blue_title">Buyer Opening Package<br><span style="font-size:16px; padding-top:15px;">Property Address: <?php echo $full_address;?></span><br><span style="font-size:16px; padding-top:15px;">APN:<?php echo $apn;?></span></h2>
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
                                                    <label for="property_address" class="mb-2"><b>Property Address Being Purchased</b></label>
                                                    <input type="text" style='width: 100%;' class="form-control" id="property_address" name="property_address" value="<?php echo $property_address;?>">
                                                    <small class="small_label">Street Address</small>
                                                </div>
                                                <div class="form-group position-relative mb-3">
                                                    <input type="text" style='width: 100%;' class="form-control" id="property_address2" name="property_address2" value="<?php echo $property_address2;?>">
                                                    <small  class="small_label">Street Address Line 2</small>
                                                </div>
												<div class="row">
                                                    <div class="col-md-6">
                                                        <div class="form-group position-relative mb-3">
                                                            <input type="text" style='width: 100%;' class="form-control" id="property_city" name="property_city" value="<?php echo $property_city;?>">
                                                            <small  class="small_label">City</small>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group position-relative mb-3 ">
                                                            <input type="text" style='width: 100%;' class="form-control" id="property_zipcode" name="property_zipcode" value="<?php echo $property_zip_code;?>">
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
                                        <div class="date_escrow_num mt-md-5">
                                            <span>Escrow No.:</span> 10257432-GLE-MP<br><span>Title No.:</span> 10257432-GLT-
                                        </div> 

                                        <h4 class="text-center my-4"><strong>PLEASE FILL OUT THIS FORM COMPLETELY AND RETURN TO OUR OFFICE AS SOON AS POSSIBLE <br> AS IT WILL ASSIST US IN THE ADMINISTRATION OF YOUR TRANSACTION.</strong></h4>

                                        <div class="form-group position-relative mb-3 mt-3">
                                            <label for="" class="mb-2"><b></b></label>
                                            <input type="text" style='width: 100%;' class="form-control" id="buyer_full_name" name="buyer_full_name" value="<?php echo $buyer_full_name;?>">
                                            <small class="small_label">Buyer(s):</small>
                                        </div>
                                       
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group position-relative mb-3 mt-3">
                                                    <label for="" class="mb-2"><b></b></label>
                                                    <input type="text" style='width: 100%;' class="form-control" id="buyer_home_number" name="buyer_home_number" value="<?php echo $buyer_home_number;?>">
                                                    <small class="small_label">Home Phone Number:</small>
                                                </div>
                                            </div>
                                            
                                            <div class="col-md-6">
                                                <div class="form-group position-relative mb-3 mt-3">
                                                    <label for="" class="mb-2"><b></b></label>
                                                    <input type="text" style='width: 100%;' class="form-control" id="buyer_work_number" name="buyer_work_number" value="<?php echo $buyer_work_number;?>">
                                                    <small class="small_label">Work Phone Number:</small>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group position-relative mb-3 mt-3">
                                                    <label for="" class="mb-2"><b></b></label>
                                                    <input type="text" style='width: 100%;' class="form-control" id="buyer_email_address" name="buyer_email_address" value="<?php echo $buyer_email_address;?>">
                                                    <small class="small_label">E-Mail Address:</small>
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="form-group position-relative mb-3 mt-3">
                                                    <label for="" class="mb-2"><b></b></label>
                                                    <input type="text" style='width: 100%;' class="form-control" id="buyer_fax_number" name="buyer_fax_number" value="<?php echo $buyer_fax_number;?>">
                                                    <small class="small_label">Fax Number:</small>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group position-relative mb-3 mt-3">
                                                    <label for="" class="mb-2"><b></b></label>
                                                    <input type="text" style='width: 100%;' class="form-control" id="buyer_ssn" name="buyer_ssn" value="<?php echo $buyer_ssn;?>">
                                                    <small class="small_label">Social Security #:</small>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group position-relative mb-3 mt-3">
                                            <label for="" class="mb-2"><b></b></label>
                                            <textarea rows="5" style='height:auto !important;width: 100%;' class="form-control" id="buyer_current_mailing_address" name="buyer_current_mailing_address"><?php echo $buyer_current_mailing_address;?></textarea>
                                            <small class="small_label">Buyer(s) Current Mailing Address:</small>
                                        </div>

                                        <div class="form-group position-relative mb-3 mt-3">
                                            <label for="" class="mb-2"><b></b></label>
                                            <textarea rows="5" style='height:auto !important;width: 100%;' class="form-control" id="buyer_mailing_address_after_close" name="buyer_mailing_address_after_close"><?php echo $buyer_mailing_address_after_close;?></textarea>
                                            <small class="small_label">Buyer(s) Mailing Address After Close Of Escrow:</small>
                                        </div>

                                        <div class="form-group position-relative mb-3 mt-5">
                                            <label for="" class="mb-2"><b>New Loan(s) Buyer(s) Are Applying For:</b></label>
                                            <input type="text" style='width: 100%;' class="form-control" id="lender_name" name="lender_name" value="<?php echo $lender_name;?>">
                                            <small class="small_label">Name Of Lender:</small>
                                        </div>
                                        
                                        <div class="form-group position-relative mb-3 mt-3">
                                            <label for="" class="mb-2"><b></b></label>
                                            <textarea rows="5" class="form-control" style="height:auto !important; width: 100%;" id="lender_address" name="lender_address"><?php echo $lender_address;?></textarea>
                                            <small class="small_label">Address:</small>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group position-relative mb-3 mt-3">
                                                    <label for="" class="mb-2"><b></b></label>
                                                    <input type="text" style='width: 100%;' class="form-control" id="agent_name" name="agent_name" value="<?php echo $agent_name;?>">
                                                    <small class="small_label">Agent's Name:</small>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group position-relative mb-3 mt-3">
                                                    <label for="" class="mb-2"><b></b></label>
                                                    <input type="text" style='width: 100%;' class="form-control" id="agent_phone_number" name="agent_phone_number" value="<?php echo $agent_phone_number;?>">
                                                    <small class="small_label">Phone Number:</small>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group position-relative mb-3">
                                            <label for="" class="mb-2"><b></b></label>
                                            <input type="text" style='width: 100%;' class="form-control" id="second_lender_name" name="second_lender_name" value="<?php echo $second_lender_name;?>">
                                            <small class="small_label">Name Of Seond Lender:</small>
                                        </div>
                                        
                                        
                                        <div class="form-group position-relative mb-3 mt-3">
                                            <label for="" class="mb-2"><b></b></label>
                                            <textarea rows="5" style='height:auto !important;width: 100%;' class="form-control" id="seond_lender_address" name="seond_lender_address"><?php echo $seond_lender_address;?></textarea>
                                            <small class="small_label">Address:</small>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group position-relative mb-3 mt-3">
                                                    <label for="" class="mb-2"><b></b></label>
                                                    <input type="text" style='width: 100%;' class="form-control" id="second_agent_name" name="second_agent_name" value="<?php echo $second_agent_name;?>">
                                                    <small class="small_label">Second Agent's Name:</small>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group position-relative mb-3 mt-3">
                                                    <label for="" class="mb-2"><b></b></label>
                                                    <input type="text" style='width: 100%;' class="form-control" id="seond_agent_phone_number" name="seond_agent_phone_number" value="<?php echo $seond_agent_phone_number;?>">
                                                    <small class="small_label">Phone Number:</small>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group position-relative mb-3 mt-3">
                                                    <label for="" class="mb-2"><b>New Insurance:</b></label>
                                                    <input type="text" style='width: 100%;' class="form-control" id="insurance_name" name="insurance_name" value="<?php echo $insurance_name;?>">
                                                    <small class="small_label">Insurance's Name:</small>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group position-relative mb-3 mt-3">
                                                    <label for="" class="mb-2"><b>&nbsp;</b></label>
                                                    <input type="text" style='width: 100%;' class="form-control" id="insurance_phone_number" name="insurance_phone_number" value="<?php echo $insurance_phone_number;?>">
                                                    <small class="small_label">Phone Number:</small>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group position-relative mb-3 mt-3">
                                            <label for="" class="mb-2"><b></b></label>
                                            <textarea rows="5" class="form-control" style="height:auto !important;width: 100%;" id="insurance_address" name="insurance_address"><?php echo $insurance_address;?></textarea>
                                            <small class="small_label">Insurance's Address:</small>
                                        </div>
                                        
                                        <div class="form-group position-relative mb-3 mt-3">
                                            <label for="" class="mb-2"><b></b></label>
                                            <input type="text" style='width: 100%;' class="form-control" id="insurance_company" name="insurance_company" value="<?php echo $insurance_company;?>">
                                            <small class="small_label">Insurance Company:</small>
                                        </div>

                                        <p class="mt-5">Please place any additional information that you feel we may require on the reverse side of this form.</p>
                                                
                                        <div class="mb-80 mt-5">
                                            Dated:    
                                            <input type="text" class="form-control" id="buyer_date" name="buyer_date" value="<?php echo $buyer_date;?>">
                                        </div>
                                       
                                        <input type="text" class="form-control" value="" placeholder="signature" id="buyer_signature" name="buyer_signature" value="<?php echo $buyer_signature;?>">  
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
                                                    &nbsp;<input  type="radio" id="yesMortgage" value="yes" <?php echo ($is_mortgage == 'yes') ? 'checked="checked"' : '';?> name="is_mortgage">&nbsp;&nbsp;&nbsp;
                                                    <label class="escrow_radio" for="yesMortgage">Yes</label>
                                                </li>
                                                <li class="list-inline-item">
                                                    &nbsp;<input  type="radio" id="noMortgage" <?php echo ($is_mortgage == 'no') ? 'checked="checked"' : '';?> value="no" name="is_mortgage">&nbsp;&nbsp;&nbsp;
                                                    <label class="escrow_radio" for="noMortgage">No</label>
                                                </li>
                                            </ul>
                                        </div> 
                                        <div class="form-group mb-4">
                                            <label for="" class="mb-2"><b>Are there any other Liens on the Property?</b></label>
                                            <ul class="list-inline mb-0">
                                                <li class="list-inline-item me-md-5">
                                                    &nbsp;<input type="radio" id="yesLiens" <?php echo ($is_liens == 'yes') ? 'checked="checked"' : '';?> value="yes" name="is_liens">&nbsp;&nbsp;&nbsp;
                                                    <label for="yesLiens">Yes</label>
                                                </li>
                                                <li class="list-inline-item">
                                                    &nbsp;<input type="radio" id="noLiens" <?php echo ($is_liens == 'no') ? 'checked="checked"' : '';?> value="no" name="is_liens">&nbsp;&nbsp;&nbsp;
                                                    <label for="noLiens">No</label>
                                                </li>
                                            </ul>
                                            
                                        </div>
                                        <div class="form-group mb-4">
                                            <label for="" class="mb-2"><b>Are there mandatory Homeowners or Condominium Associations?</b></label>
                                            <ul class="list-inline mb-0">
                                                <li class="list-inline-item me-md-5">
                                                    &nbsp;<input type="radio" id="yesCondominium" <?php echo ($is_condominium == 'yes') ? 'checked="checked"' : '';?> value="yes" name="is_condominium">&nbsp;&nbsp;&nbsp;
                                                    <label for="yesCondominium">Yes</label>
                                                </li>
                                                <li class="list-inline-item">
                                                    &nbsp;<input type="radio" id="noCondominium" <?php echo ($is_condominium == 'no') ? 'checked="checked"' : '';?> value="no" name="is_condominium">&nbsp;&nbsp;&nbsp;
                                                    <label for="noCondominium">No</label>
                                                </li>
                                            </ul>
                                            
                                        </div>
                                        <div class="form-group mb-4">
                                            <label for="" class="mb-2"><b>Is this your primary residence / homestead property for tax purposes?</b></label>
                                            <ul class="list-inline mb-0">
                                                <li class="list-inline-item me-md-5">
                                                    &nbsp;<input type="radio" id="yesresidence" <?php echo ($is_residence == 'yes') ? 'checked="checked"' : '';?> value="yes" name="is_residence">&nbsp;&nbsp;&nbsp;
                                                    <label for="yesresidence">Yes</label>
                                                </li>
                                                <li class="list-inline-item">
                                                    &nbsp;<input type="radio" id="noresidence" <?php echo ($is_residence == 'no') ? 'checked="checked"' : '';?> value="no" name="is_residence">&nbsp;&nbsp;&nbsp;
                                                    <label for="noresidence">No</label>
                                                </li>
                                            </ul>
                                            
                                        </div>
                                        <div class="form-group mb-4">
                                            <label for="" class="mb-2"><b>Has there been a divorce since the purchase of the property or are you currently in the process of getting divorced?</b></label>
                                            <ul class="list-inline mb-0">
                                                <li class="list-inline-item me-md-5">
                                                    &nbsp;<input type="radio" id="yesdivorced" <?php echo ($is_divorced == 'yes') ? 'checked="checked"' : '';?> value="yes" name="is_divorced">&nbsp;&nbsp;&nbsp;
                                                    <label for="yesdivorced">Yes</label>
                                                </li>
                                                <li class="list-inline-item">
                                                    &nbsp;<input type="radio" id="nodivorced" <?php echo ($is_divorced == 'no') ? 'checked="checked"' : '';?> value="no" name="is_divorced">&nbsp;&nbsp;&nbsp;
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
                                                    &nbsp;<input type="radio" id="yeschanged" <?php echo ($is_changed == 'yes') ? 'checked="checked"' : '';?> value="yes" name="is_changed">&nbsp;&nbsp;&nbsp;
                                                    <label for="yeschanged">Yes</label>
                                                </li>
                                                <li class="list-inline-item">
                                                    &nbsp;<input type="radio" id="nochanged" <?php echo ($is_changed == 'no') ? 'checked="checked"' : '';?> value="no" name="is_changed">&nbsp;&nbsp;&nbsp;
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
                                                    &nbsp;<input type="radio" id="yesdeath" value="yes" <?php echo ($is_death == 'yes') ? 'checked="checked"' : '';?> name="is_death">&nbsp;&nbsp;&nbsp;
                                                    <label for="yesdeath">Yes</label>
                                                </li>
                                                <li class="list-inline-item">
                                                    &nbsp;<input type="radio" id="nodeath" value="no" <?php echo ($is_death == 'no') ? 'checked="checked"' : '';?> name="is_death">&nbsp;&nbsp;&nbsp;
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
                                                    &nbsp;<input type="radio" id="yessurvey" value="yes" name="is_survey" <?php echo ($is_survey == 'yes') ? 'checked="checked"' : '';?>>&nbsp;&nbsp;&nbsp;
                                                    <label for="yessurvey">Yes</label>
                                                </li>
                                                <li class="list-inline-item me-md-5">
                                                    &nbsp;<input type="radio" id="nosurvey" value="no" name="is_survey" <?php echo ($is_survey == 'no') ? 'checked="checked"' : '';?>>&nbsp;&nbsp;&nbsp;
                                                    <label for="nosurvey">No</label>
                                                </li>
                                                <li class="list-inline-item">
                                                    &nbsp;<input type="radio" id="na" value="n/a" name="is_survey" <?php echo ($is_survey == 'n/a') ? 'checked="checked"' : '';?>>&nbsp;&nbsp;&nbsp;
                                                    <label for="na">N/A - Property is a Condominium</label>
                                                </li>
                                            </ul>
                                            
                                            <div class="errorMsg d-none">
                                                <div class="text-danger mb-3"> Please provide a copy of the existing survey to our office.</div>
                                                <label for="" class="mb-2"><b>Has there been any structural changes or improvements to the Property since the date of the Survey (such as new construction, fences, pools, driveways, etc.)?</b></label>
                                                <ul class="list-inline mb-0">
                                                    <li class="list-inline-item me-md-5">
                                                        &nbsp;<input type="radio" id="yesstructural" value="yes" name="is_structural" <?php echo ($is_structural == 'yes') ? 'checked="checked"' : '';?>>&nbsp;&nbsp;&nbsp;
                                                        <label for="yesstructural">Yes</label>
                                                    </li>
                                                    <li class="list-inline-item">
                                                        &nbsp;<input type="radio" id="nostructural" value="no" name="is_structural" <?php echo ($is_structural == 'no') ? 'checked="checked"' : '';?>>&nbsp;&nbsp;&nbsp;
                                                        <label for="nostructural">No</label>
                                                    </li>
                                                </ul>
                                                
                                            </div>
                                        </div>
                                        <div class="form-group mb-4">
                                            <label for="" class="mb-2"><b>Do you have an existing Owner's Title Insurance Policy for the Property? (Note: Depending on your Sales Contract, the Seller could be penalized $150.00 for not delivering their current owner's title insurance policy to the Buyer within 10 days of the effective date of the Sales Contract.)</b></label>
                                            <ul class="list-inline mb-0">
                                                <li class="list-inline-item me-md-5">
                                                    &nbsp;<input type="radio" id="yesInsurance" value="yes" name="is_insurance" <?php echo ($is_insurance == 'yes') ? 'checked="checked"' : '';?>>&nbsp;&nbsp;&nbsp;  
                                                    <label for="yesInsurance">Yes</label>
                                                </li>
                                                <li class="list-inline-item">
                                                    &nbsp;<input type="radio" id="noInsurance" value="no" name="is_insurance" <?php echo ($is_insurance == 'no') ? 'checked="checked"' : '';?>>&nbsp;&nbsp;&nbsp;
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
                                                            &nbsp;<input type="radio" id="City" value="City" name="water_service" <?php echo ($water_service == 'City') ? 'checked="checked"' : '';?>>&nbsp;&nbsp;&nbsp;
                                                            <label for="City">City</label>
                                                        </li>
                                                        <li>
                                                            &nbsp;<input type="radio" id="County" value="County" name="water_service" <?php echo ($water_service == 'County') ? 'checked="checked"' : '';?>>&nbsp;&nbsp;&nbsp;
                                                            <label for="County">County</label>
                                                        </li>
                                                        <li>
                                                            &nbsp;<input type="radio" id="FGUA" value="FGUA" name="water_service" <?php echo ($water_service == 'FGUA') ? 'checked="checked"' : '';?>>&nbsp;&nbsp;&nbsp;
                                                            <label for="FGUA">FGUA</label>
                                                        </li>
                                                        <li>
                                                            &nbsp;<input type="radio" id="Septic" value="Septic" name="water_service" <?php echo ($water_service == 'Septic') ? 'checked="checked"' : '';?>>&nbsp;&nbsp;&nbsp;
                                                            <label for="Septic">Well / Septic</label>
                                                        </li>
                                                        <li>
                                                            &nbsp;<input type="radio" id="other" value="other" name="water_service" <?php echo ($water_service == 'other') ? 'checked="checked"' : '';?>>&nbsp;&nbsp;&nbsp; 
                                                            <label for="County"><input type="text" style='width: auto;' class="form-control" placeholder="Other" id="other_water_service_name" name="other_water_service_name" value="<?php echo $other_water_service_name;?>"></label>
                                                        </li>
                                                        
                                                    </ul>
                                                   
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group mb-4">
                                                    <label for="" class="mb-2">Water Service Provider Name</label>
                                                    <input type="text" style='width: 100%;' class="form-control" id="water_service_provider_name" name="water_service_provider_name" value="<?php echo $water_service_provider_name;?>">
                                                    
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
                                                    <input type="text" style='width: 100%;' class="form-control" id="first_mortgage_company" name="first_mortgage_company" value="<?php echo $first_mortgage_company;?>">
                                                    
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="form-group mb-4">
                                                    <label for="" class="mb-2">Loan Number</label>
                                                    <input type="text" style='width: 100%;' class="form-control" id="first_mortgage_loan_number" name="first_mortgage_loan_number" value="<?php echo $first_mortgage_loan_number;?>">
                                                    
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group mb-3">
                                                    <label for="" class="mb-2">Phone Number</label>
                                                    <div class="row">
                                                        <div class="col-4 position-relative mb-3">
                                                            <input type="text" style='width: 100%;' class="form-control" id="first_mortgage_area_code" name="first_mortgage_area_code" value="<?php echo $first_mortgage_area_code;?>">
                                                            <small class="small_label">Area Code</small>
                                                        </div>
                                                        
                                                        <div class="col-8 position-relative mb-3">
                                                            <input type="text" style='width: 100%;' class="form-control" id="first_mortgage_phone_number" name="first_mortgage_phone_number" value="<?php echo $first_mortgage_phone_number;?>">
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
                                                    <input type="text" style='width: 100%;' class="form-control" id="second_mortgage_company" name="second_mortgage_company" value="<?php echo $second_mortgage_company;?>">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="form-group mb-4">
                                                    <label for="" class="mb-2">Loan Number</label>
                                                    <input type="text" style='width: 100%;' class="form-control" id="second_mortgage_loan_number" name="second_mortgage_loan_number" value="<?php echo $second_mortgage_loan_number;?>">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group mb-3">
                                                    <label for="" class="mb-2">Phone Number</label>
                                                    <div class="row">
                                                        <div class="col-4 position-relative">
                                                            <input type="text" style='width: 100%;' class="form-control" id="second_mortgage_area_code" name="second_mortgage_area_code" value="<?php echo $second_mortgage_area_code;?>">
                                                            <small class="small_label">Area Code</small>
                                                        </div>
                                                        <div class="col-8 position-relative">
                                                            <input type="text" style='width: 100%;' class="form-control" id="second_mortgage_phone_number" name="second_mortgage_phone_number" value="<?php echo $second_mortgage_phone_number;?>">
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
                                                    <input type="text" style='width: 100%;' class="form-control" id="third_mortgage_company" name="third_mortgage_company" value="<?php echo $third_mortgage_company;?>">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="form-group mb-4">
                                                    <label for="" class="mb-2">Loan Number</label>
                                                    <input type="text" style='width: 100%;' class="form-control" id="third_mortgage_loan_number" name="third_mortgage_loan_number" value="<?php echo $third_mortgage_loan_number;?>">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group mb-3">
                                                    <label for="" class="mb-2">Phone Number</label>
                                                    <div class="row">
                                                        <div class="col-4 position-relative">
                                                            <input type="text" style='width: 100%;' class="form-control" id="third_mortgage_area_code" name="third_mortgage_area_code" value="<?php echo $third_mortgage_area_code;?>">
                                                            <small class="small_label">Area Code</small>
                                                        </div>
                                                        <div class="col-8 position-relative">
                                                            <input type="text" style='width: 100%;' class="form-control" id="third_mortgage_phone_number" name="third_mortgage_phone_number" value="<?php echo $third_mortgage_phone_number;?>">
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
                                                    <input type="text" style='width: 100%;' class="form-control" id="first_lien_holder_name" name="first_lien_holder_name" value="<?php echo $first_lien_holder_name;?>">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group mb-4">
                                                    <label for="" class="mb-2">Amount Owed 1</label>
                                                    <input type="text" style='width: 100%;' class="form-control" id="first_amount_owed" name="first_amount_owed" value="<?php echo $first_amount_owed;?>">
                                                    
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group mb-4">
                                                    <label for="" class="mb-2">Lienholder Name 2</label>
                                                    <input type="text" style='width: 100%;' class="form-control" id="second_lien_holder_name" name="second_lien_holder_name" value="<?php echo $second_lien_holder_name;?>">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group mb-4">
                                                    <label for="" class="mb-2">Amount Owed 2</label>
                                                    <input type="text" style='width: 100%;' class="form-control" id="second_amount_owed" name="second_amount_owed" value="<?php echo $second_amount_owed;?>">
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
                                                    <input type="text" style='width: 100%;' class="form-control" id="first_homeowners_association" name="first_homeowners_association" value="<?php echo $first_homeowners_association;?>">
                                                    
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group mb-4">
                                                    <label for="" class="mb-2">Property Management Company</label>
                                                    <input type="text" style='width: 100%;' class="form-control" id="first_property_management_company" name="first_property_management_company" value="<?php echo $first_property_management_company;?>">
                                                    
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group mb-4">
                                                    <label for="" class="mb-2">Property Management Number</label>
                                                    <input type="text" style='width: 100%;' class="form-control" id="first_property_management_number" name="first_property_management_number" value="<?php echo $first_property_management_number;?>">
                                                    
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="form-group mb-4">
                                                    <label for="" class="mb-2">Condominium / Homeowners Association 2</label>
                                                    <input type="text" style='width: 100%;' class="form-control" id="second_homeowners_association" name="second_homeowners_association" value="<?php echo $second_homeowners_association;?>">
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group mb-4">
                                                    <label for="" class="mb-2">Property Management Company</label>
                                                    <input type="text" style='width: 100%;' class="form-control" id="second_property_management_company" name="second_property_management_company" value="<?php echo $second_property_management_company;?>">
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group mb-4">
                                                    <label for="" class="mb-2">Property Management Number</label>
                                                    <input type="text" style='width: 100%;' class="form-control" id="second_property_management_number" name="second_property_management_number" value="<?php echo $second_property_management_number;?>">
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
                                        <h4 class="text-center my-4"><strong>CONFIDENTIAL INFORMATION FOR YOUR PROTECTION</strong></h4>

                                        <div class="mb-20">
                                            Completion of this statement expedites your application for title insurance, as it assists in establishing identity, eliminating matters affecting persons with similar names and avoiding the use of fraudulent or forged documents.  Complete all blanks (please print) or indicate "none" or "N/A."  If more space is needed for any item(s), use the reverse side of the form.  Each party (and spouse/domestic partner, if applicable) to the transaction should personally sign this form.
                                        </div>
                                        <div class="row my-5">
                                            <div class="col-md-6">
                                                To: Pacific Coast Title Company <br>
                                                516 Burchett St., Glendale, CA  91203	
                                            </div>
                                            <div class="col-md-6 text-md-end">
                                                ESCROW NO.:  <b>10257432-GLE-MP</b><br>TITLE NO.: <b> 10257432-GLT-</b>	
                                            </div> 
                                        </div>
                                        <h4 class="text-center"><b>NAME AND PERSONAL INFORMATION</b></h4>

                                        <div class="row mt-5">
                                            <div class="col-md-9">	
                                                <div class="row">
                                                    <div class="col-lg-3 col-md-6">
                                                        <div class="form-group position-relative mb-3">
                                                            <label for="" class="mb-2"><b></b></label>
                                                            <input type="text" style='width: 100%;' class="form-control" id="first_name" name="first_name" value="<?php echo $first_name;?>">
                                                            <small class="small_label">First Name</small>
                                                        </div>
                                                        
                                                    </div>
                                                    <div class="col-lg-3 col-md-6">
                                                        <div class="form-group position-relative mb-3">
                                                            <label for="" class="mb-2"><b></b></label>
                                                            <input type="text" style='width: 100%;' class="form-control" id="middle_name" name="middle_name" value="<?php echo $middle_name;?>">
                                                            <small class="small_label">Middle Name</small>
                                                        </div>
                                                        
                                                    </div>
                                                    <div class="col-lg-3 col-md-6">
                                                        <div class="form-group position-relative mb-3">
                                                            <label for="" class="mb-2"><b></b></label>
                                                            <input type="text" style='width: 100%;' class="form-control" id="last_name" name="last_name" value="<?php echo $last_name;?>">
                                                            <small class="small_label">Last Name</small>
                                                        </div>
                                                        
                                                    </div>
                                                    <div class="col-lg-3 col-md-6">
                                                        <div class="form-group position-relative mb-3">
                                                            <label for="" class="mb-2"><b></b></label>
                                                            <input type="text" style='width: 100%;' class="form-control" id="maiden_name" name="maiden_name" value="<?php echo $maiden_name;?>">
                                                            <small class="small_label">Maiden Name</small>
                                                        </div>
                                                        
                                                    </div>
                                                </div>
                                                <div class="text-center mt-4 f14">(If none, indicate)</div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group position-relative mb-3">
                                                    <label for="" class="mb-2"><b></b></label>
                                                    <input type="text" style='width: 100%;' class="form-control" id="date_of_birth" name="date_of_birth" value="<?php echo $date_of_birth;?>">
                                                    <small class="small_label">Date of Birth</small>
                                                </div>
                                                
                                            </div>
                                        </div>
                                            <div class="row mt-3">
                                                <div class="col-md-4">
                                                    <div class="form-group position-relative mb-3">
                                                        <label for="" class="mb-2"><b></b></label>
                                                        <input type="text" style='width: 100%;' class="form-control" id="home_phone_number" name="home_phone_number" value="<?php echo $home_phone_number;?>">
                                                        <small class="small_label">Home Phone</small>
                                                    </div>
                                                    
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group position-relative mb-3">
                                                        <label for="" class="mb-2"><b></b></label>
                                                        <input type="text" style='width: 100%;' class="form-control" id="business_phone_number" name="business_phone_number" value="<?php echo $business_phone_number;?>">
                                                        <small class="small_label">Business Phone</small>
                                                    </div>
                                                    
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group position-relative mb-3">
                                                        <label for="" class="mb-2"><b></b></label>
                                                        <input type="text" style='width: 100%;' class="form-control" id="birthplace" name="birthplace" value="<?php echo $birthplace;?>">
                                                        <small class="small_label">Birthplace</small>
                                                    </div>
                                                    
                                                </div>
                                            </div>
                                            <div class="row mt-3">
                                                <div class="col-md-6">
                                                    <div class="form-group position-relative mb-3">
                                                        <label for="" class="mb-2"><b></b></label>
                                                        <input type="text" style='width: 100%;' class="form-control" id="ssn" name="ssn" value="<?php echo $ssn;?>">
                                                        <small class="small_label">Social Security No.</small>
                                                    </div>
                                                    
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group position-relative mb-3">
                                                        <label for="" class="mb-2"><b></b></label>
                                                        <input type="text" style='width: 100%;' class="form-control" id="driver_license_no" name="driver_license_no" value="<?php echo $driver_license_no;?>">
                                                        <small class="small_label">Driver’s License No.</small>
                                                    </div>
                                                    
                                                </div>
                                            </div>
                                            <div class="row mt-3">
                                                <div class="col-md-12">
                                                    <div class="form-group position-relative mb-3">
                                                        <label for="" class="mb-2"><b></b></label>
                                                        <input type="text" style='width: 100%;' class="form-control" id="another_name_that_used" name="another_name_that_used" value="<?php echo $another_name_that_used;?>">
                                                        <small class="small_label">List any other name you have used or been known by</small>
                                                    </div>
                                                    
                                                </div>
                                            </div>
                                            <div class="row mt-3">
                                                <div class="col-md-6">
                                                    <div class="form-group position-relative mb-3">
                                                        <label for="" class="mb-2"><b></b></label>
                                                        <input type="text" style='width: 100%;' class="form-control" id="residence_state" name="residence_state" value="<?php echo $residence_state;?>">
                                                        <small class="small_label">State of residence</small>
                                                    </div>
                                                    
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group position-relative mb-3">
                                                        <label for="" class="mb-2"><b></b></label>
                                                        <input type="text" style='width: 100%;' class="form-control" id="lived_year" name="lived_year" value="<?php echo $lived_year;?>">
                                                        <small class="small_label">I have lived continuously in the U.S.A. since</small>
                                                    </div>
                                                    
                                                </div>
                                            </div>                                            
                                            <div class="mt-5">
                                                Are you currently married? <input type="checkbox" style='font-size: 18pt;' class="" name="is_married" id="is_married" <?php echo  ($is_married == 'on') ? 'checked="checked"' : '';?>> If yes, complete the following information:
                                            </div>

                                            <div class="form-group position-relative mt-3 mb-3">
                                                <label for="" class="mb-2"><b></b></label>
                                                <input type="text" style='width: 100%;' class="form-control" id="date_and_place_marriage" name="date_and_place_marriage" value="<?php echo $date_and_place_marriage;?>">
                                                <small class="small_label">Date and place of marriage</small>
                                            </div>
                                            

                                            <div class="row mt-3">
                                                <div class="col-md-9">	
                                                    <div class="row">
                                                        <div class="col-lg-3 col-md-6">
                                                            <div class="form-group position-relative mb-3">
                                                                <label for="" class="mb-2"><b>Spouse:</b></label>
                                                                <input type="text" style='width: 100%;' class="form-control" id="spouse_first_name" name="spouse_first_name" value="<?php echo $spouse_first_name;?>">
                                                                <small class="small_label">First Name</small>
                                                            </div>
                                                            
                                                        </div>
                                                        <div class="col-lg-3 col-md-6">
                                                            <div class="form-group position-relative mb-3">
                                                                <label for="" class="mb-2"><b>&nbsp;</b></label>
                                                                <input type="text" style='width: 100%;' class="form-control" id="spouse_middle_name" name="spouse_middle_name" value="<?php echo $spouse_middle_name;?>">
                                                                <small class="small_label">Middle Name</small>
                                                            </div>
                                                            
                                                        </div>
                                                        <div class="col-lg-3 col-md-6">
                                                            <div class="form-group position-relative mb-3">
                                                                <label for="" class="mb-2"><b>&nbsp;</b></label>
                                                                <input type="text" style='width: 100%;' class="form-control" id="spouse_last_name" name="spouse_last_name" value="<?php echo $spouse_last_name;?>">
                                                                <small class="small_label">Last Name</small>
                                                            </div>
                                                            
                                                        </div>
                                                        <div class="col-lg-3 col-md-6">
                                                            <div class="form-group position-relative mb-3">
                                                                <label for="" class="mb-2"><b>&nbsp;</b></label>
                                                                <input type="text" style='width: 100%;' class="form-control" id="spouse_maiden_name" name="spouse_maiden_name" value="<?php echo $spouse_maiden_name;?>">
                                                                <small class="small_label">Maiden Name</small>
                                                            </div>
                                                            
                                                        </div>
                                                    </div>
                                                    <div class="text-center mt-4 f14">(If none, indicate)</div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="form-group position-relative mb-3">
                                                        <label for="" class="mb-2"><b>&nbsp;</b></label>
                                                        <input type="text" style='width: 100%;' class="form-control" id="spouse_date_of_birth" name="spouse_date_of_birth" value="<?php echo $spouse_date_of_birth;?>">
                                                        <small class="small_label">Date of Birth</small>
                                                    </div>
                                                    
                                                </div>
                                            </div>
                                            <div class="row mt-3">
                                                <div class="col-md-4">
                                                    <div class="form-group position-relative mb-3">
                                                        <label for="" class="mb-2"><b></b></label>
                                                        <input type="text" style='width: 100%;' class="form-control" id="spouse_home_phone_number" name="spouse_home_phone_number" value="<?php echo $spouse_home_phone_number;?>">
                                                        <small class="small_label">Home Phone</small>
                                                    </div>
                                                    
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group position-relative mb-3">
                                                        <label for="" class="mb-2"><b></b></label>
                                                        <input type="text" style='width: 100%;' class="form-control" id="spouse_business_phone_number" name="spouse_business_phone_number" value="<?php echo $spouse_business_phone_number;?>">
                                                        <small class="small_label">Business Phone</small>
                                                    </div>
                                                    
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group position-relative mb-3">
                                                        <label for="" class="mb-2"><b></b></label>
                                                        <input type="text" style='width: 100%;' class="form-control" id="spouse_birthplace" name="spouse_birthplace" value="<?php echo $spouse_birthplace;?>">
                                                        <small class="small_label">Birthplace</small>
                                                    </div>
                                                    
                                                </div>
                                            </div>
                                            <div class="row mt-3">
                                                <div class="col-md-6">
                                                    <div class="form-group position-relative mb-3">
                                                        <label for="" class="mb-2"><b></b></label>
                                                        <input type="text" style='width: 100%;' class="form-control" id="spouse_ssn" name="spouse_ssn" value="<?php echo $spouse_ssn;?>">
                                                        <small class="small_label">Social Security No.</small>
                                                    </div>
                                                    
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group position-relative mb-3">
                                                        <label for="" class="mb-2"><b></b></label>
                                                        <input type="text" style='width: 100%;' class="form-control" id="spouse_driver_license_no" name="spouse_driver_license_no" value="<?php echo $spouse_driver_license_no;?>">
                                                        <small class="small_label">Driver’s License No.</small>
                                                    </div>
                                                    
                                                </div>
                                            </div>
                                            <div class="row mt-3">
                                                <div class="col-md-12">
                                                    <div class="form-group position-relative mb-3">
                                                        <label for="" class="mb-2"><b></b></label>
                                                        <input type="text" style='width: 100%;' class="form-control" id="spouse_another_name_that_used" name="spouse_another_name_that_used" value="<?php echo $spouse_another_name_that_used;?>">
                                                        <small class="small_label">List any other name you have used or been known by</small>
                                                    </div>
                                                    
                                                </div>
                                            </div>
                                            <div class="row mt-3">
                                                <div class="col-md-6">
                                                    <div class="form-group position-relative mb-3">
                                                        <label for="" class="mb-2"><b></b></label>
                                                        <input type="text" style='width: 100%;' class="form-control" id="spouse_state_residence" name="spouse_state_residence" value="<?php echo $spouse_state_residence;?>">
                                                        <small class="small_label">State of residence</small>
                                                    </div>
                                                    
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group position-relative mb-3">
                                                        <label for="" class="mb-2"><b></b></label>
                                                        <input type="text" style='width: 100%;' class="form-control" id="spouse_lived_year" name="spouse_lived_year" value="<?php echo $spouse_lived_year;?>">
                                                        <small class="small_label">I have lived continuously in the U.S.A. since</small>
                                                    </div>
                                                    
                                                </div>
                                            </div>                                            
                                            <div class="mt-5">
                                                Are you currently a registered domestic partner? <input type="checkbox" style='font-size: 18pt;' name="is_domestic_partner" id="is_domestic_partner" <?php echo  ($is_domestic_partner == 'on') ? 'checked="checked"' : '';?>> If yes, complete the following information:
                                            </div>

                                            <div class="row mt-3">
                                                <div class="col-md-9">	
                                                    <div class="row">
                                                        <div class="col-lg-3 col-md-6">
                                                            <div class="form-group position-relative mb-3">
                                                                <label for="" class="mb-2"><b>Domestic Partner:</b></label>
                                                                <input type="text" style='width: 100%;' class="form-control" id="domestic_first_name" name="domestic_first_name" value="<?php echo $domestic_first_name;?>">
                                                                <small class="small_label">First Name</small>
                                                            </div>
                                                            
                                                        </div>
                                                        <div class="col-lg-3 col-md-6">
                                                            <div class="form-group position-relative mb-3">
                                                                <label for="" class="mb-2"><b>&nbsp;</b></label>
                                                                <input type="text" style='width: 100%;' class="form-control" id="domestic_middle_name" name="domestic_middle_name" value="<?php echo $domestic_middle_name;?>">
                                                                <small class="small_label">Middle Name</small>
                                                            </div>
                                                            
                                                        </div>
                                                        <div class="col-lg-3 col-md-6">
                                                            <div class="form-group position-relative mb-3">
                                                                <label for="" class="mb-2"><b>&nbsp;</b></label>
                                                                <input type="text" style='width: 100%;' class="form-control" id="domestic_last_name" name="domestic_last_name" value="<?php echo $domestic_last_name;?>">
                                                                <small class="small_label">Last Name</small>
                                                            </div>
                                                            
                                                        </div>
                                                        <div class="col-lg-3 col-md-6">
                                                            <div class="form-group position-relative mb-3">
                                                                <label for="" class="mb-2"><b>&nbsp;</b></label>
                                                                <input type="text" style='width: 100%;' class="form-control" id="domestic_maiden_name" name="domestic_maiden_name" value="<?php echo $domestic_maiden_name;?>">
                                                                <small class="small_label">Maiden Name</small>
                                                            </div>
                                                            
                                                        </div>
                                                    </div>
                                                    <div class="text-center mt-4 f14">(If none, indicate)</div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="form-group position-relative mb-3">
                                                        <label for="" class="mb-2"><b>&nbsp;</b></label>
                                                        <input type="text" style='width: 100%;' class="form-control" id="domestic_date_of_birth" name="domestic_date_of_birth" value="<?php echo $domestic_date_of_birth;?>">
                                                        <small class="small_label">Date of Birth</small>
                                                    </div>
                                                    
                                                </div>
                                            </div>
                                            <div class="row mt-3">
                                                <div class="col-md-4">
                                                    <div class="form-group position-relative mb-3">
                                                        <label for="" class="mb-2"><b></b></label>
                                                        <input type="text" style='width: 100%;' class="form-control" id="domestic_home_phone_number" name="domestic_home_phone_number" value="<?php echo $domestic_home_phone_number;?>">
                                                        <small class="small_label">Home Phone</small>
                                                    </div>
                                                    
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group position-relative mb-3">
                                                        <label for="" class="mb-2"><b></b></label>
                                                        <input type="text" style='width: 100%;' class="form-control" id="domestic_business_phone_number" name="domestic_business_phone_number" value="<?php echo $domestic_business_phone_number;?>">
                                                        <small class="small_label">Business Phone</small>
                                                    </div>
                                                    
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group position-relative mb-3">
                                                        <label for="" class="mb-2"><b></b></label>
                                                        <input type="text" style='width: 100%;' class="form-control" id="domestic_birthplace" name="domestic_birthplace" value="<?php echo $domestic_birthplace;?>">
                                                        <small class="small_label">Birthplace</small>
                                                    </div>
                                                    
                                                </div>
                                            </div>
                                            <div class="row mt-3">
                                                <div class="col-md-6">
                                                    <div class="form-group position-relative mb-3">
                                                        <label for="" class="mb-2"><b></b></label>
                                                        <input type="text" style='width: 100%;' class="form-control" id="domestic_ssn" name="domestic_ssn" value="<?php echo $domestic_ssn;?>">
                                                        <small class="small_label">Social Security No.</small>
                                                    </div>
                                                    
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group position-relative mb-3">
                                                        <label for="" class="mb-2"><b></b></label>
                                                        <input type="text" style='width: 100%;' class="form-control" id="domestic_driver_license_no" name="domestic_driver_license_no" value="<?php echo $domestic_driver_license_no;?>">
                                                        <small class="small_label">Driver’s License No.</small>
                                                    </div>
                                                    
                                                </div>
                                            </div>
                                            <div class="row mt-3">
                                                <div class="col-md-12">
                                                    <div class="form-group position-relative mb-3">
                                                        <label for="" class="mb-2"><b></b></label>
                                                        <input type="text" style='width: 100%;' class="form-control" id="domestic_another_name_that_used" name="domestic_another_name_that_used" value="<?php echo $domestic_another_name_that_used;?>">
                                                        <small class="small_label">List any other name you have used or been known by</small>
                                                    </div>
                                                    
                                                </div>
                                            </div>
                                            <div class="row mt-3">
                                                <div class="col-md-6">
                                                    <div class="form-group position-relative mb-3">
                                                        <label for="" class="mb-2"><b></b></label>
                                                        <input type="text" style='width: 100%;' class="form-control" id="domestic_state_residence" name="domestic_state_residence" value="<?php echo $domestic_state_residence;?>">
                                                        <small class="small_label">State of residence</small>
                                                    </div>
                                                    
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group position-relative mb-3">
                                                        <label for="" class="mb-2"><b></b></label>
                                                        <input type="text" style='width: 100%;' class="form-control" id="domestic_lived_year" name="domestic_lived_year" value="<?php echo $domestic_lived_year;?>">
                                                        <small class="small_label">I have lived continuously in the U.S.A. since</small>
                                                    </div>
                                                    
                                                </div>
                                            </div>   

                                            <div class="mt-5 mb-2 text-center title_string"><b>***********************************************************************************************************************************</b></div>

                                            <h5 class="text-center"><strong>RESIDENCES (LAST 10 YEARS)</strong></h5>

                                            <div class="mt-3 mb-3 text-center title_string"><b>***********************************************************************************************************************************</b></div>

                                            <div class="row">
                                                <div class="col-md-4">
                                                    <div class="form-group position-relative mb-3">
                                                        <label for="" class="mb-2"><b></b></label>
                                                        <input type="text" style='width: 100%;' class="form-control" id="residence_number_street" name="residence_number_street" value="<?php echo $residence_number_street;?>">
                                                        <small class="small_label">Number &amp; Street</small>
                                                    </div>
                                                    
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group position-relative mb-3">
                                                        <label for="" class="mb-2"><b></b></label>
                                                        <input type="text" style='width: 100%;' class="form-control" id="residence_city" name="residence_city" value="<?php echo $residence_city;?>">
                                                        <small class="small_label">City</small>
                                                    </div>
                                                    
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group position-relative mb-3">
                                                        <label for="" class="mb-2"><b></b></label>
                                                        <input type="text" style='width: 100%;' class="form-control" id="residence_from_date_to_date" name="residence_from_date_to_date" value="<?php echo $residence_from_date_to_date;?>">
                                                        <small class="small_label">From (date) to (date)</small>
                                                    </div>
                                                    
                                                </div>
                                            </div>
                                            <div class="row mt-3">
                                                <div class="col-md-4">
                                                    <div class="form-group position-relative">
                                                        <label for="" class="mb-2"><b></b></label>
                                                        <input type="text" style='width: 100%;' class="form-control" id="second_residence_number_street" name="second_residence_number_street" value="<?php echo $second_residence_number_street;?>">
                                                        <small class="small_label">Number &amp; Street</small>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group position-relative">
                                                        <label for="" class="mb-2"><b></b></label>
                                                        <input type="text" style='width: 100%;' class="form-control" id="second_residence_city" name="second_residence_city" value="<?php echo $second_residence_city;?>">
                                                        <small class="small_label">City</small>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group position-relative">
                                                        <label for="" class="mb-2"><b></b></label>
                                                        <input type="text" style='width: 100%;' class="form-control" id="second_residence_from_date_to_date" name="second_residence_from_date_to_date" value="<?php echo $second_residence_from_date_to_date;?>">
                                                        <small class="small_label">From (date) to (date)</small>
                                                    </div>
                                                    
                                                </div>
                                            </div>
                                            <div class="text-center mt-4 f14">(If more space is required, use reverse side of form)</div>
                                            <div class="mt-4 mb-2 text-center title_string"><b>***********************************************************************************************************************************</b></div>

                                            <h5 class="text-center"><strong>OCCUPATIONS/BUSINESSES (LAST 10 YEARS)</strong></h5>

                                            <div class="mt-3 mb-3 text-center title_string"><b>***********************************************************************************************************************************</b></div>

                                            <div class="row">
                                                <div class="col-md-4">
                                                    <div class="form-group position-relative mb-3">
                                                        <label for="" class="mb-2"><b></b></label>
                                                        <input type="text" style='width: 100%;' class="form-control" id="firm_or_business_name" name="firm_or_business_name" value="<?php echo $firm_or_business_name;?>">
                                                        <small class="small_label">Firm or Business name</small>
                                                    </div>
                                                    
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group position-relative mb-3">
                                                        <label for="" class="mb-2"><b></b></label>
                                                        <input type="text" style='width: 100%;' class="form-control" id="business_address" name="business_address" value="<?php echo $business_address;?>">
                                                        <small class="small_label">Address</small>
                                                    </div>
                                                    
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group position-relative mb-3">
                                                        <label for="" class="mb-2"><b></b></label>
                                                        <input type="text" style='width: 100%;' class="form-control" id="business_from_date_to_date" name="business_from_date_to_date" value="<?php echo $business_from_date_to_date;?>">
                                                        <small class="small_label">From (date) to (date)</small>
                                                    </div>
                                                    
                                                </div>
                                            </div>
                                            <div class="row mt-3">
                                                <div class="col-md-4">
                                                    <div class="form-group position-relative">
                                                        <label for="" class="mb-2"><b></b></label>
                                                        <input type="text" style='width: 100%;' class="form-control" id="second_firm_or_business_name" name="second_firm_or_business_name" value="<?php echo $second_firm_or_business_name;?>">
                                                        <small class="small_label">Firm or Business name</small>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group position-relative">
                                                        <label for="" class="mb-2"><b></b></label>
                                                        <input type="text" style='width: 100%;' class="form-control" id="second_business_address" name="second_business_address" value="<?php echo $second_business_address;?>">
                                                        <small class="small_label">Address</small>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group position-relative">
                                                        <label for="" class="mb-2"><b></b></label>
                                                        <input type="text" style='width: 100%;' class="form-control" id="second_business_from_date_to_date" name="second_business_from_date_to_date" value="<?php echo $second_business_from_date_to_date;?>">
                                                        <small class="small_label">From (date) to (date)</small>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="mt-5 mb-2 text-center title_string"><b>***********************************************************************************************************************************</b></div>

                                            <h5 class="text-center"><strong>INFORMATION ABOUT THE PROPERTY</strong></h5>

                                            <div class="mt-3 mb-3 text-center title_string"><b>***********************************************************************************************************************************</b></div>

                                            <div class="d-flex">
                                                <div class="me-3">
                                                    Buyer intends to reside on the property in this transaction:  
                                                </div>
                                                <div class="me-3">
                                                    &nbsp;<input type="radio" id="yesProperty" value="Yes" name="is_buyer_intends" <?php echo ($is_buyer_intends == 'Yes') ? 'checked="checked"' : '';?>>&nbsp;&nbsp;&nbsp;
                                                    <label for="yesProperty">Yes</label>
                                                </div>
                                                <div>
                                                    &nbsp;<input type="radio" id="noPorperty" value="No" name="is_buyer_intends" <?php echo ($is_buyer_intends == 'No') ? 'checked="checked"' : '';?>>&nbsp;&nbsp;&nbsp;
                                                    <label for="noPorperty">No</label>
                                                </div>
                                            </div>
                                            

                                            <div class="mt-5 mb-2 text-center title_string"><b>***********************************************************************************************************************************</b></div>

                                            <h5 class="text-center"><strong>Owner to complete the following items</strong></h5>

                                            <div class="mt-3 mb-3 text-center title_string"><b>***********************************************************************************************************************************</b></div>

                                            <div class="form-group position-relative mb-3">
                                                <label for="" class="mb-2"><b></b></label>
                                                <input type="text" style='width: 100%;' class="form-control" id="owner_street_address" name="owner_street_address" value="<?php echo $owner_street_address;?>">
                                                <small class="small_label"> Street Address of Property in this transaction: </small>
                                            </div>

                                            <div class="mt-4">
                                                The land is unimproved <input type="text" class="input_single form-control" id="unimproved" name="unimproved" value="<?php echo $unimproved;?>">; or improved with a structure of the following type:  A Single or 1-4 Family <input type="text" class="input_single form-control" id="single_family" name="single_family" value="<?php echo $single_family;?>"> Condo Unit <input type="text" class="input_single form-control" id="condo_unit" name="condo_unit" value="<?php echo $condo_unit;?>"> Other <input type="text" class="input_single form-control" id="other" name="other" value="<?php echo $other;?>"> 	
                                            </div>

                                            <div class="d-flex mt-3">
                                                <div class="me-3">
                                                    Improvements, remodeling or repairs to this property have been made within the past six months: 
                                                </div>
                                                <div class="me-3">
                                                    &nbsp;<input type="radio" name="is_improvement" id="yesImprovements" value="Yes" <?php echo ($is_improvement == 'Yes') ? 'checked="checked"' : '';?>>&nbsp;&nbsp;&nbsp;
                                                    <label for="yesImprovements">Yes</label>
                                                </div>
                                                <div>
                                                    &nbsp;<input type="radio" name="is_improvement" id="noImprovements" value="No" <?php echo ($is_improvement == 'No') ? 'checked="checked"' : '';?>>&nbsp;&nbsp;&nbsp;
                                                    <label for="noImprovements">No</label>
                                                </div>
                                            </div>
                                            

                                            <div class="d-flex mt-3">
                                                <div class="me-3">
                                                    If yes, have all costs for labor and materials arising in connection therewith been paid in full?
                                                </div>
                                                <div class="me-3">
                                                    &nbsp;<input type="radio" name="is_materials" id="yesmaterials" value="Yes" <?php echo ($is_materials == 'Yes') ? 'checked="checked"' : '';?>>&nbsp;&nbsp;&nbsp;
                                                    <label for="yesmaterials">Yes</label>
                                                </div>
                                                <div>
                                                    &nbsp;<input type="radio" name="is_materials" id="nomaterials" value="No" <?php echo ($is_materials == 'No') ? 'checked="checked"' : '';?>>&nbsp;&nbsp;&nbsp;
                                                    <label for="nomaterials">No</label>
                                                </div>
                                                
                                            </div>
                                            

                                            <div class="mt-3">
                                                Any current loans on property? <input style='font-size: 18pt;' type="checkbox" name="is_loan" id="is_loan" <?php echo  ($is_loan == 'on') ? 'checked="checked"' : '';?>>; If yes, complete the following:
                                            </div>

                                            <div class="mt-3 row">
                                                <div class="col-md-4">
                                                    <div class="form-group position-relative mb-3">
                                                        <label for="" class="mb-2"><b></b></label>
                                                        <input type="text" style='width: 100%;' class="form-control" id="lender" name="lender" value="<?php echo $lender;?>">
                                                        <small class="small_label">Lender</small>
                                                    </div>
                                                    
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group position-relative mb-3">
                                                        <label for="" class="mb-2"><b></b></label>
                                                        <input type="text" style='width: 100%;' class="form-control" id="loan_amount" name="loan_amount" value="<?php echo $loan_amount;?>">
                                                        <small class="small_label">Loan Amount</small>
                                                    </div>
                                                    
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group position-relative mb-3">
                                                        <label for="" class="mb-2"><b></b></label>
                                                        <input type="text" style='width: 100%;' class="form-control" id="loan_account" name="loan_account" value="<?php echo $loan_account;?>">
                                                        <small class="small_label">Loan Account #</small>
                                                    </div>
                                                    
                                                </div>
                                            </div>

                                            <div class="mt-3 row">
                                                <div class="col-md-4">
                                                    <div class="form-group position-relative">
                                                        <label for="" class="mb-2"><b></b></label>
                                                        <input type="text" style='width: 100%;' class="form-control" id="second_lender" name="second_lender" value="<?php echo $second_lender;?>">
                                                        <small class="small_label">Lender</small>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group position-relative">
                                                        <label for="" class="mb-2"><b></b></label>
                                                        <input type="text" style='width: 100%;' class="form-control" id="second_loan_amount" name="second_loan_amount" value="<?php echo $second_loan_amount;?>">
                                                        <small class="small_label">Loan Amount</small>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group position-relative">
                                                        <label for="" class="mb-2"><b></b></label>
                                                        <input type="text" style='width: 100%;' class="form-control" id="second_loan_account" name="second_loan_account" value="<?php echo $second_loan_account;?>">
                                                        <small class="small_label">Loan Account #</small>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="mt-4">The undersigned declare, under penalty of perjury, that the foregoing is true and correct.</div>

                                            <div class="mt-3 row">
                                                <div class="col-md-6">
                                                    Executed on <input type="text" class="input_single form-control" id="executed_date" name="executed_date" value="<?php echo $executed_date;?>">, <input type="text" class="input_single form-control" id="executed_year" name="executed_year" value="<?php echo $executed_year;?>">
                                                    
                                                </div>
                                                <div class="col-md-6">
                                                    at <input type="text" class="input_single form-control" id="executed_time" name="executed_time" value="<?php echo $executed_time;?>">
                                                    
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="mt-5 form-group">
                                                        Signature :    
                                                        <input type="text" style='width: auto;' class="form-control" id="signature" name="signature" value="<?php echo $signature;?>">
                                                    </div>
                                                    
                                                </div>
                                                <div class="col-md-6 text-md-end">
                                                    <div class="mt-5 form-group">
                                                        Signature :    
                                                        <input type="text" style='width: auto;' class="form-control" id="second_signature" name="second_signature" value="<?php echo $second_signature;?>">
                                                    </div>
                                                    
                                                </div>
                                            </div>

                                            <p class="mt-4 text-center">
                                                (Note:  If applicable, both spouses/domestic partners must sign.)
                                                <strong class="d-block">THANK YOU</strong>
                                            </p>
                                        
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
                                            <div class="d-float">
                                                <div class="date_escrow_num mt-md-5">
                                                    <span>Date:</span>February 11, 2022<br><br>
                                                    <span>ESCROW NO.:</span>10257432-GLE-MP<br>
                                                    <span>TITLE NO.:</span>10257432-GLT-
                                                </div>
                                            </div>
                                            <p class="mt-3">
                                                YOU AS ESCROW HOLDER ARE AUTHORIZED TO SHOW VESTING ON THE GRANT DEED TO RECORD AS FOLLOWS:
                                            </p>
                                            
                                            <div class="form-group position-relative mb-4 mt-3">
                                                <label for="" class="mb-2"><b></b></label>
                                                <input type="text" style='width: 100%;' class="form-control" id="names" name="names" value="<?php echo $names;?>">
                                                <small class="small_label">Names:</small>
                                            </div>

                                            <div class="mb-4">PLEASE MARK APPROPRIATE CHOICE FOR STATUS: check for PICK-UP </div>
                                            <div class="d-flex align-items-center mb-2">
                                                <input style='font-size: 18pt;' type="checkbox" id="husbandWife" name="pick_ups[]" value="husbandWife" class="me-2" <?php echo (in_array('husbandWife', $pick_ups)) ? 'checked="checked"' : '';?>>
                                                <label for="husbandWife">Husband and Wife</label>                                                 
                                            </div>
                                            <div class="d-flex align-items-center mb-2">
                                                <input style='font-size: 18pt;' type="checkbox" id="wifeHusband" name="pick_ups[]" value="wifeHusband" class="me-2" <?php echo (in_array('wifeHusband', $pick_ups)) ? 'checked="checked"' : '';?>>
                                                <label for="wifeHusband">Wife and Husband</label>                                                 
                                            </div>
                                            <div class="d-flex align-items-center mb-2">
                                                <input type="checkbox" style="font-size: 18pt" id="couple" name="pick_ups[]" value="couple" class="me-2" <?php echo (in_array('couple', $pick_ups)) ? 'checked="checked"' : '';?>>
                                                <label for="couple">A Married Couple</label>                                                 
                                            </div>
                                            <div class="d-flex align-items-center mb-2">
                                                <input type="checkbox" style="font-size: 18pt" id="singleMan" name="pick_ups[]" value="singleMan" class="me-2" <?php echo (in_array('singleMan', $pick_ups)) ? 'checked="checked"' : '';?>>
                                                <label for="singleMan">A Single Man (never married)</label>                                                 
                                            </div>
                                            <div class="d-flex align-items-center mb-2">
                                                <input type="checkbox" style="font-size: 18pt" id="singleWoman" name="pick_ups[]" value="singleWoman" class="me-2" <?php echo (in_array('singleWoman', $pick_ups)) ? 'checked="checked"' : '';?>>
                                                <label for="singleWoman">A Single Woman (never married)</label>                                                 
                                            </div>
                                            <div class="d-flex align-items-center mb-2">
                                                <input type="checkbox" style="font-size: 18pt" id="singlePerson" name="pick_ups[]" value="singlePerson" class="me-2" <?php echo (in_array('singlePerson', $pick_ups)) ? 'checked="checked"' : '';?>>
                                                <label for="singlePerson">A Single Person (never married)</label>                                                 
                                            </div>
                                            <div class="d-flex align-items-center mb-2">
                                                <input type="checkbox" style="font-size: 18pt" id="marriedMan" name="pick_ups[]" value="marriedMan" class="me-2" <?php echo (in_array('marriedMan', $pick_ups)) ? 'checked="checked"' : '';?>>
                                                <label for="marriedMan">A Married Man (as his sole and separate property)*</label>                                                 
                                            </div>
                                            <div class="d-flex align-items-center mb-2">
                                                <input type="checkbox" style="font-size: 18pt" id="marriedWoman" name="pick_ups[]" value="marriedWoman" class="me-2" <?php echo (in_array('purchase', $pick_ups)) ? 'checked="checked"' : '';?>>
                                                <label for="marriedWoman">A Married Woman (as her sole and separate property)*</label>                                                 
                                            </div>
                                            <div class="d-flex align-items-center mb-2">
                                                <input type="checkbox" style="font-size: 18pt" id="marriedPerson" name="pick_ups[]" value="marriedPerson" class="me-2" <?php echo (in_array('marriedPerson', $pick_ups)) ? 'checked="checked"' : '';?>>
                                                <label for="marriedPerson">A Married Person (as his/her sole and separate property)*</label>                                                 
                                            </div>
                                            <div class="mb-2">
                                                <label for="interspousal">* Please indicate name of spouse so interspousal deed may be drawn:</label>  
                                                <input style='width: 100%;' type="text" class="form-control" id="names_of_spouse" name="names_of_spouse" value="<?php echo $names;?>">                                               
                                            </div>
                                            
                                            <div class="d-flex align-items-center mb-2">
                                                <input type="checkbox" style="font-size: 18pt" id="unmarriedMan" name="pick_ups[]" value="unmarriedMan" class="me-2" <?php echo (in_array('unmarriedMan', $pick_ups)) ? 'checked="checked"' : '';?>>
                                                <label for="unmarriedMan">An Unmarried Man (divorced)</label>                                                 
                                            </div>
                                            <div class="d-flex align-items-center mb-2">
                                                <input type="checkbox" style="font-size: 18pt" id="unmarriedWoman" name="pick_ups[]" value="unmarriedWoman" class="me-2" <?php echo (in_array('unmarriedWoman', $pick_ups)) ? 'checked="checked"' : '';?>>
                                                <label for="unmarriedWoman">An Unmarried Woman (divorced)</label>                                                 
                                            </div>
                                            <div class="d-flex align-items-center mb-2">
                                                <input type="checkbox" style="font-size: 18pt" id="unmarriedPerson" name="pick_ups[]" value="unmarriedPerson" class="me-2" <?php echo (in_array('unmarriedPerson', $pick_ups)) ? 'checked="checked"' : '';?>>
                                                <label for="unmarriedPerson">An Unmarried Person (divorced)</label>                                                 
                                            </div>
                                            <div class="d-flex align-items-center mb-2">
                                                <input type="checkbox" style="font-size: 18pt" id="widow" name="pick_ups[]" value="widow" class="me-2" <?php echo (in_array('widow', $pick_ups)) ? 'checked="checked"' : '';?>>
                                                <label for="widow">A Widow (spouse deceased)</label>                                                 
                                            </div>
                                            <div class="d-flex align-items-center mb-2">
                                                <input type="checkbox" style="font-size: 18pt" id="widower" name="pick_ups[]" value="widower" class="me-2" <?php echo (in_array('widower', $pick_ups)) ? 'checked="checked"' : '';?>>
                                                <label for="widower">A Widower (spouse deceased)</label>                                                 
                                            </div>
                                            <div class="d-flex align-items-center mb-2">
                                                <input type="checkbox" style="font-size: 18pt" id="domestic" name="pick_ups[]" value="domestic" class="me-2" <?php echo (in_array('domestic', $pick_ups)) ? 'checked="checked"' : '';?>>
                                                <label for="domestic">Registered Domestic Partners</label>                                                 
                                            </div>
                                            <div class="mb-3 mt-3"><b>PLEASE MARK APPROPRIATE CHOICE FOR VESTING:</b></div>
                                            <div class="d-flex align-items-center mb-2">
                                                <input type="checkbox" style="font-size: 18pt" id="community" name="appropriate_choice[]" value="community" class="me-2" <?php echo (in_array('community', $appropriate_choice)) ? 'checked="checked"' : '';?>>
                                                <label for="community">Community Property</label>                                                 
                                            </div>
                                            <div class="d-flex align-items-center mb-2">
                                                <input type="checkbox" style="font-size: 18pt" id="survivorship" name="appropriate_choice[]" value="survivorship" class="me-2" <?php echo (in_array('survivorship', $appropriate_choice)) ? 'checked="checked"' : '';?>>
                                                <label for="survivorship">Community Property with Right of Survivorship</label>                                                 
                                            </div>
                                            <div class="d-flex align-items-center mb-2">
                                                <input type="checkbox" style="font-size: 18pt" id="tenants" name="appropriate_choice[]" value="tenants" class="me-2" <?php echo (in_array('tenants', $appropriate_choice)) ? 'checked="checked"' : '';?>>
                                                <label for="tenants">Joint Tenants</label>                                                 
                                            </div>
                                            <div class="d-flex align-items-center mb-2">
                                                <input type="checkbox" style="font-size: 18pt" id="internetAmount" name="appropriate_choice[]" value="internetAmount" class="me-2" <?php echo (in_array('internetAmount', $appropriate_choice)) ? 'checked="checked"' : '';?>>
                                                <label for="internetAmount">Tenants In Common (Please Give Interest Amounts)</label>                                                 
                                            </div>
                                            <div class="d-flex align-items-center mb-2">
                                                <input type="checkbox" style="font-size: 18pt" id="partnership" name="appropriate_choice[]" value="partnership" class="me-2" <?php echo (in_array('partnership', $appropriate_choice)) ? 'checked="checked"' : '';?>>
                                                <label for="partnership">Sole and Separate Property (If Married or Domestic Partnership, an Interspousal Grant Deed, A Quitclaim Deed, Statement Of Information and Appropriate Instructions Will Need To Be Submitted.)</label>                                                 
                                            </div>
                                            <div class="d-flex align-items-center mb-2">
                                                <input type="checkbox" style="font-size: 18pt" id="general" name="appropriate_choice[]" value="general" class="me-2" <?php echo (in_array('general', $appropriate_choice)) ? 'checked="checked"' : '';?>>
                                                <label for="general">Partnership (Limited Or General)</label>     
                                                <input type="text" class="form-control w-50 ms-3" id="partnership_name" name="partnership_name" value="<?php echo $partnership_name;?>">                                            
                                            </div>
                                            <div class="d-flex align-items-center mb-2">
                                                <input type="checkbox" style="font-size: 18pt" id="corporation" name="appropriate_choice[]" value="corporation" class="me-2" <?php echo (in_array('corporation', $appropriate_choice)) ? 'checked="checked"' : '';?>>
                                                <label for="corporation">Corporation (California Or Other State)</label>     
                                                <input type="text" class="form-control w-50 ms-3" id="corporation_name" name="corporation_name" value="<?php echo $corporation_name;?>">                                            
                                            </div>
                                            <div class="d-flex align-items-center mb-2">
                                                <input type="checkbox" style="font-size: 18pt" id="trust" name="appropriate_choice[]" value="trust" class="me-2" <?php echo (in_array('trust', $appropriate_choice)) ? 'checked="checked"' : '';?>>
                                                <label for="trust">A Trust (attach copy of Trust Agreement)</label>                                     
                                            </div>
                                            <div class="d-flex align-items-center mb-2">
                                                <input type="checkbox" style="font-size: 18pt" id="other" name="appropriate_choice[]" value="other" class="me-2" <?php echo (in_array('other', $appropriate_choice)) ? 'checked="checked"' : '';?>>
                                                <label for="other">Other</label>                                     
                                            </div>

                                            <div class="mt-5 mb-5">
                                                Escrow Holder advises the parties hereto to seek legal counsel with their attorney and/or accountant as to how they should hold title.
                                            </div>

                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="mt-5">
                                                        Signature :    
                                                        <input type="text" class="input_single form-control" id="vesting_form_signature" name="vesting_form_signature" value="<?php echo $vesting_form_signature;?>">
                                                    </div>
                                                    
                                                </div>
                                                <div class="col-md-6 text-md-end">
                                                    <div class="mt-5">
                                                        Date :    
                                                        <input type="text" class="input_single form-control" id="vesting_form_date" name="vesting_form_date" value="<?php echo $vesting_form_date;?>">
                                                    </div>
                                                </div> 
                                            </div>                                
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
                                                <textarea name="address" rows="6" id="address" class="form-control mt-3" style="height:auto !important;width: 100%;" readonly>
Mordechai Citronenbaum  
48 Hauser Blvd. #1-110 
Los Angeles, CA 90036
                                                </textarea>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group position-relative mb-3">
                                                    <input type="text" style='width: 100%;' class="form-control f700 f12" value="" id="assessors_parcel_number" name="assessors_parcel_number" value="<?php echo $assessors_parcel_number;?>">
                                                    <small class="small_label">ASSESSOR'S PARCEL NUMBER</small>
                                                </div>
                                                
                                                <div class="form-group position-relative mb-3">
                                                    <input type="text" style='width: 100%;' class="form-control f700 f12" id="transferor" name="transferor" value="<?php echo $transferor;?>">
                                                    <small class="small_label">SELLER/TRANSFEROR</small>
                                                </div>
                                                
                                                <div class="form-group position-relative mb-3">
                                                    <input type="text" style='width: 100%;' class="form-control f700 f12" id="buyer_daytime_phone_number" name="buyer_daytime_phone_number" value="<?php echo $buyer_daytime_phone_number;?>">
                                                    <small class="small_label">BUYER'S DAYTIME TELEPHONE NUMBER</small>
                                                </div>
                                                
                                                <div class="form-group position-relative mb-3">
                                                    <input type="text" style='width: 100%;' class="form-control f700 f12" id="buyer_email_address" name="buyer_email_address" value="<?php echo $buyer_email_address;?>">
                                                    <small class="small_label">BUYER'S EMAIL ADDRESS</small>
                                                </div>
                                                
                                            </div>
                                        </div>
                                        
                                        <div class="form-group position-relative mb-3">
                                            <input type="text" style='width: 100%;' class="form-control f700 f12" value="" id="real_property_addres" name="real_property_addres" value="<?php echo $real_property_addres;?>">
                                            <small class="small_label">STREET ADDRESS OR PHYSICAL LOCATION OF REAL PROPERTY </small>
                                        </div>
                                        

                                        <table class="table yesno_table">
                                            <tr>
                                                <th><b>YES</b></th>
                                                <th><b>NO</b></th>
                                                <th></th>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <input type="radio" name="is_principal_residence" id="checkYes0" value="yes" <?php echo ($is_principal_residence == 'yes') ? 'checked="checked"' : '';?>></td> 
                                                <td>
                                                    <input type="radio" name="is_principal_residence" id="checkNo0" value="no" <?php echo ($is_principal_residence == 'no') ? 'checked="checked"' : '';?>></td>
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
                                            <input type="text" style='width: 100%;' class="form-control f700 f12" value="" id="mail_property_tax_name" name="mail_property_tax_name" value="<?php echo $mail_property_tax_name;?>">
                                            <small class="small_label">MAIL PROPERTY TAX INFORMATION TO (NAME)</small>
                                        </div>
                                        

                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group position-relative mb-3">
                                                    <input type="text" style='width: 100%;' class="form-control f700 f12" value="" id="mail_property_tax_address" name="mail_property_tax_address" value="<?php echo $mail_property_tax_address;?>">
                                                    <small class="small_label">MAIL PROPERTY TAX INFORMATION TO (ADDRESS)</small>
                                                </div>
                                                
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group position-relative mb-3">
                                                    <input type="text" style='width: 100%;' class="form-control f700 f12" value="" id="mail_property_tax_city" name="mail_property_tax_city" value="<?php echo $mail_property_tax_city;?>">
                                                    <small class="small_label">CITY </small>
                                                </div>
                                                
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group position-relative mb-3">
                                                    <input type="text" style='width: 100%;' class="form-control f700 f12" value="" id="mail_property_tax_state" name="mail_property_tax_state" value="<?php echo $mail_property_tax_state;?>">
                                                    <small class="small_label">STATE </small>
                                                </div>
                                                
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group position-relative mb-3">
                                                    <input type="text" style='width: 100%;' class="form-control f700 f12" value="" id="mail_property_tax_zipcode" name="mail_property_tax_zipcode" value="<?php echo $mail_property_tax_zipcode;?>">
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
                                                    <input type="text" class="input_single form-control" name="financing_purpose_reason" id="financing_purpose_reason" value="<?php echo $financing_purpose_reason;?>">
                                                    
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
                                                    <input type="text" class="input_single form-control" name="other_transfer" id="other_transfer" value="<?php echo $other_transfer;?>">
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
                                                                <input type="checkbox" style="font-size: 18pt" class="mt-2 me-2" id="purchase" value="purchase" name="types_of_transfer[]" <?php echo (in_array('purchase', $types_of_transfer)) ? 'checked="checked"' : '';?>>
                                                                <label for="purchase">Purchase</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-2 col-md-6">
                                                            <div class="d-flex">
                                                                <input type="checkbox" style="font-size: 18pt" class="mt-2 me-2" id="foreclosure" value="foreclosure" name="types_of_transfer[]" <?php echo (in_array('foreclosure', $types_of_transfer)) ? 'checked="checked"' : '';?>>
                                                                <label for="foreclosure">Foreclosure</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-3 col-md-6">
                                                            <div class="d-flex">
                                                                <input type="checkbox" style="font-size: 18pt" class="mt-2 me-2" id="trade" value="trade_of_exchange" name="types_of_transfer[]" <?php echo (in_array('trade_of_exchange', $types_of_transfer)) ? 'checked="checked"' : '';?>>
                                                                <label for="trade">Trade or exchange </label>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-5 col-md-6">
                                                            <div class="d-flex">
                                                                <input type="checkbox" style="font-size: 18pt" class="mt-2 me-2" id="acquisition" value="acquisition" name="types_of_transfer[]" <?php echo (in_array('acquisition', $types_of_transfer)) ? 'checked="checked"' : '';?>>
                                                                <label for="acquisition"> Merger, stock, or partnership acquisition (Form BOE-100-B) </label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row mt-3">
                                                        <div class="col-md-6">
                                                            Contract of sale. Date of contract <input type="date" class="input_single" id="date_of_contract" name="date_of_contract" value="<?php echo $date_of_contract;?>">
                                                            
                                                        </div>
                                                        <div class="col-md-6">
                                                            <input type="checkbox" style="font-size: 18pt" id="inheritance" value="inheritance" name="types_of_transfer[]" <?php echo (in_array('inheritance', $types_of_transfer)) ? 'checked="checked"' : '';?>> 
                                                            <label for="inheritance">Inheritance. Date of death: 
                                                            <input type="date" class="input_single" id="date_of_death_transfer" name="date_of_death_transfer" value="<?php echo $date_of_death_transfer;?>"></label>
                                                            
                                                        </div>
                                                    </div>
                                                    <div class="row mt-3">
                                                        <div class="col-lg-2 col-md-6">
                                                            <div class="d-flex">
                                                                <input type="checkbox" style="font-size: 18pt" class="mt-2 me-2" id="leaseback" value="leaseback" name="types_of_transfer[]" <?php echo (in_array('leaseback', $types_of_transfer)) ? 'checked="checked"' : '';?>>
                                                                <label for="leaseback"> Sale/leaseback</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-2 col-md-6">
                                                            <div class="d-flex">
                                                                <input type="checkbox" style="font-size: 18pt" class="mt-2 me-2" id="lease" value="lease" name="types_of_transfer[]" <?php echo (in_array('lease', $types_of_transfer)) ? 'checked="checked"' : '';?>>
                                                                <label for="lease">Creation of a lease</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-3 col-md-6">
                                                            <div class="d-flex">
                                                                <input type="checkbox" style="font-size: 18pt" class="mt-2 me-2" id="assignment" value="assignment" name="types_of_transfer[]" <?php echo (in_array('assignment', $types_of_transfer)) ? 'checked="checked"' : '';?>>
                                                                <label for="assignment">Assignment of a lease </label>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-5 col-md-6">
                                                            <div class="d-flex">
                                                                <input type="checkbox" style="font-size: 18pt" class="mt-2 me-2" id="termination" value="termination" name="types_of_transfer[]" <?php echo (in_array('termination', $types_of_transfer)) ? 'checked="checked"' : '';?>>
                                                                <label for="termination"> Termination of a lease. Date lease began  
                                                                    <input type="date" class="input_single" id="date_of_lease_began" name="date_of_lease_began" value="<?php echo $date_of_lease_began;?>"></label>
                                                                
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="mt-3">
                                                        Original term in years (including written options): 
                                                         <input type="text" class="input_single form-control" id="original_terms_in_year" name="original_terms_in_year" value="<?php echo $original_terms_in_year;?>"> 
                                                         Remaining term in years (including written options):   
                                                         <input type="text"  class="input_single form-control" id="remaining_terms_in_year" name="remaining_terms_in_year" value="<?php echo $remaining_terms_in_year;?>">
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
                                                    <input type="text" class="input_single form-control" id="start_percentage_range" name="start_percentage_range" value="<?php echo $start_percentage_range;?>"> % 
                                                    <input type="text" class="input_single form-control" id="end_percentage_range" name="end_percentage_range" value="<?php echo $end_percentage_range;?>">
                                                    
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
                                                            <input type="text" class="input_single form-control" id="total_purchase_price" name="total_purchase_price" value="<?php echo $total_purchase_price;?>"></div>
                                                            
                                                    </div>
                                                    
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>B.</td>
                                                <td>
                                                    <div class="d-flex justify-content-between">
                                                        Cash down payment or value of trade or exchange excluding closing costs  <div>Amount $ 
                                                            <input type="text" class="input_single form-control" id="cash_down_payment" name="cash_down_payment" value="<?php echo $cash_down_payment;?>"></div>
                                                            
                                                    </div>
                                                    
                                                </td>
                                            </tr>       
                                            <tr>
                                                <td>C.</td>
                                                <td>
                                                    First deed of trust @ &nbsp;
                                                   <input type="text" class="input_single form-control" id="first_deed_of_trust_interest" name="first_deed_of_trust_interest" value="<?php echo $first_deed_of_trust_interest;?>"> % interest for 
                                                   <input type="text" class="input_single form-control" id="first_deed_of_trust_years" name="first_deed_of_trust_years" value="<?php echo $first_deed_of_trust_years;?>">years. 
                                                   Monthly payment $ 
                                                   <input type="text" class="input_single form-control" id="first_deed_of_trust_monthly_payment" name="first_deed_of_trust_monthly_payment" value="<?php echo $first_deed_of_trust_monthly_payment;?>">
                                                   
                                                    <div class="row mt-3">
                                                        <div class="col-lg-3 col-md-6">
                                                            <div class="d-flex">
                                                                <input type="checkbox" style="font-size: 18pt" class="mt-2 me-2" id="fha" value="fha" name="first_deed_payment_types[]" <?php echo (in_array('fha', $first_deed_payment_types)) ? 'checked="checked"' : '';?>>
                                                                <label for="discount">FHA (____Discount Points)</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-3 col-md-6">
                                                            <div class="d-flex">
                                                                <input type="checkbox" style="font-size: 18pt" class="mt-2 me-2" id="cal_vet" value="cal_vet" name="first_deed_payment_types[]" <?php echo (in_array('cal_vet', $first_deed_payment_types)) ? 'checked="checked"' : '';?>>
                                                                <label for="vet">Cal-Vet </label>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-3 col-md-6">
                                                            <div class="d-flex">
                                                                <input type="checkbox" style="font-size: 18pt" class="mt-2 me-2" id="va_point" value="va_point" name="first_deed_payment_types[]" <?php echo (in_array('va_point', $first_deed_payment_types)) ? 'checked="checked"' : '';?>>
                                                                <label for="va_point">VA (____Discount Points) </label>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-3 col-md-6">
                                                            <div class="d-flex">
                                                                <input type="checkbox" style="font-size: 18pt" class="mt-2 me-2" id="fix_rate" value="fix_rate" name="first_deed_payment_types[]" <?php echo (in_array('fix_rate', $first_deed_payment_types)) ? 'checked="checked"' : '';?>>
                                                                <label for="fix_rate">Fixed rate </label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row mt-3">
                                                        <div class="col-md-4">
                                                            <div class="d-flex">
                                                                <input type="checkbox" style="font-size: 18pt" class="mt-2 me-2" id="var_rate" value="var_rate" name="first_deed_payment_types[]" <?php echo (in_array('var_rate', $first_deed_payment_types)) ? 'checked="checked"' : '';?>>
                                                                <label for="var_rate">Variable rate</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <div class="d-flex">
                                                                <input type="checkbox" style="font-size: 18pt" class="mt-2 me-2" id="loan" value="loan" name="first_deed_payment_types[]" <?php echo (in_array('loan', $first_deed_payment_types)) ? 'checked="checked"' : '';?>>
                                                                <label for="loan">Bank/Savings & Loan/Credit Union </label>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <div class="d-flex">
                                                                <input type="checkbox" style="font-size: 18pt" class="mt-2 me-2" id="loan_carried_by_seller" value="loan_carried_by_seller" name="first_deed_payment_types[]" <?php echo (in_array('loan_carried_by_seller', $first_deed_payment_types)) ? 'checked="checked"' : '';?>>
                                                                <label for="carried">Loan carried by seller</label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row mt-3">
                                                        <div class="col-md-6">
                                                            <div class="d-flex">
                                                                <input type="checkbox" style="font-size: 18pt" class="mt-2 me-2" id="balloon_payment" value="balloon_payment" name="first_deed_payment_types[]" <?php echo (in_array('balloon_payment', $first_deed_payment_types)) ? 'checked="checked"' : '';?>>
                                                                <label for="balloon">Balloon payment $</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="d-flex">
                                                                <input type="checkbox" style="font-size: 18pt" class="mt-2 me-2" id="due_date" value="due_date" name="first_deed_payment_types[]" <?php echo (in_array('due_date', $first_deed_payment_types)) ? 'checked="checked"' : '';?>>
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
                                                        Second deed of trust @  <input type="text" class="input_single form-control" id="second_deed_of_trust_interest" name="second_deed_of_trust_interest" value="<?php echo $second_deed_of_trust_interest;?>"> % interest for 
                                                        <input type="text" class="input_single form-control" id="second_deed_of_trust_years" name="second_deed_of_trust_years" value="<?php echo $second_deed_of_trust_years;?>"> years.   
                                                        Monthly payment $ <input type="text" class="input_single form-control" id="second_deed_of_trust_monthly_payment" name="second_deed_of_trust_monthly_payment" value="<?php echo $second_deed_of_trust_monthly_payment;?>">  
                                                        Amount $ <input type="text" class="input_single form-control" id="second_deed_of_trust_amount" name="second_deed_of_trust_amount" value="<?php echo $second_deed_of_trust_amount;?>">
                                                    </div>
                                                    <div class="mt-3 row">
                                                        <div class="col-md-4">
                                                            <div class="d-flex">
                                                                <input type="checkbox" style="font-size: 18pt" class="mt-2 me-2" id="fixed_rate" value="fixed_rate" name="second_deed_payment_types[]" <?php echo (in_array('fixed_rate', $second_deed_payment_types)) ? 'checked="checked"' : '';?>>
                                                                <label for="fixed_rate">Fixed rate</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <div class="d-flex">
                                                                <input type="checkbox" style="font-size: 18pt" class="mt-2 me-2" id="second_var_rate" value="second_var_rate" name="second_deed_payment_types[]" <?php echo (in_array('second_var_rate', $second_deed_payment_types)) ? 'checked="checked"' : '';?>>
                                                                <label for="variable_rate">Variable rate</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <div class="d-flex">
                                                                <input type="checkbox" style="font-size: 18pt" class="mt-2 me-2" id="second_loan" value="second_loan" name="second_deed_payment_types[]" <?php echo (in_array('second_loan', $second_deed_payment_types)) ? 'checked="checked"' : '';?>>
                                                                <label for="union">Bank/Savings & Loan/Credit Union </label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="mt-3 row">
                                                        <div class="col-md-4">
                                                            <div class="d-flex">
                                                                <input type="checkbox" style="font-size: 18pt" class="mt-2 me-2" id="second_loan_carried_by_seller" value="second_loan_carried_by_seller" name="second_deed_payment_types[]" <?php echo (in_array('second_loan_carried_by_seller', $second_deed_payment_types)) ? 'checked="checked"' : '';?>>
                                                                <label for="loan_seller">Loan carried by seller</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <div class="d-flex">
                                                                <input type="checkbox" style="font-size: 18pt" class="mt-2 me-2" id="second_ballon_payment" value="second_ballon_payment" name="second_deed_payment_types[]" <?php echo (in_array('second_ballon_payment', $second_deed_payment_types)) ? 'checked="checked"' : '';?>>
                                                                <label for="ballon_pay">Balloon payment $ <input type="text" id="ballon_payment" name="ballon_payment" class="input_single form-control" value="<?php echo $ballon_payment;?>"></label>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <div class="d-flex">
                                                                <input type="checkbox" style="font-size: 18pt" class="mt-2 me-2" id="second_due_date" value="second_due_date" name="second_deed_payment_types[]" <?php echo (in_array('second_due_date', $second_deed_payment_types)) ? 'checked="checked"' : '';?>>
                                                                <label for="date_due">Due date:<input type="date" class="input_single form-control" id="second_deed_due_date" name="second_deed_due_date" value="<?php echo $second_deed_due_date;?>"></label>
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
                                                    Outstanding balance $ <input type="text" class="input_single form-control" id="outstanding_balance" name="outstanding_balance" value="<?php echo $outstanding_balance;?>">
                                                    
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>F.</td>
                                                <td>
                                                    Amount, if any, of real estate commission fees paid by the buyer which are not included in the purchase price $ 
                                                    <input type="text" class="input_single form-control" id="real_estate_commission" name="real_estate_commission" value="<?php echo $real_estate_commission;?>">
                                                    
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>G.</td>
                                                <td>
                                                    he property was purchased: 
                                                    <div class="mt-3">
                                                        &nbsp;<input type="radio" name="property_purchase_via" id="real_estate" value="real_estate" <?php echo ($property_purchase_via == 'yes') ? 'real_estate' : '';?>>&nbsp;&nbsp;&nbsp;
                                                        <label for="broker_name">Through real estate broker.</label> 
                                                        Broker name: <input type="text" class="input_single form-control" id="broker_name" name="broker_name" value="<?php echo $broker_name;?>"> 
                                                        Phone number: <input type="text" class="input_single form-control" id="broker_phone_number" name="broker_phone_number" value="<?php echo $broker_phone_number;?>">
                                                    </div>
                                                    <div class="mt-3">
                                                        &nbsp;<input type="radio" name="property_purchase_via" id="direct" value="direct_from_seller" <?php echo ($property_purchase_via == 'direct_from_seller') ? 'checked="checked"' : '';?>>&nbsp;&nbsp;&nbsp; <label for="direct">Direct from seller</label>  &nbsp;
                                                        &nbsp;<input type="radio" name="property_purchase_via" id="direct" value="family_member_relationship" <?php echo ($property_purchase_via == 'family_member_relationship') ? 'checked="checked"' : '';?>>&nbsp;&nbsp;&nbsp; <label for="family">From a family member-Relationship  &nbsp;
                                                        <input type="text" class="input_single form-control" id="property_purchase_via_name" name="property_purchase_via_name" value="<?php echo $property_purchase_via_name;?>"></label>  
                                                    </div>
                                                    <div class="mt-3">
                                                        &nbsp;<input type="radio" name="property_purchase_via" id="other" value="other" <?php echo ($property_purchase_via == 'other') ? 'checked="checked"' : '';?>>&nbsp;&nbsp;&nbsp; 
                                                        <label for="Other"> Other. Please explain: 
                                                            <input type="text" class="input_single form-control" id="other_through" name="other_through" value="<?php echo $other_through;?>">
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
                                                    &nbsp;Type of property transferred
                                                    <div class="row mt-3">
                                                        <div class="col-md-4">
                                                            <div class="d-flex">
                                                                <input type="checkbox" style="font-size: 18pt" class="mt-2 me-2" id="single" name="types_of_property_transferred[]" value="single" <?php echo (in_array('single', $types_of_property_transferred)) ? 'checked="checked"' : '';?>>
                                                                <label for="single">Single-family residence</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <div class="d-flex">
                                                                <input type="checkbox" style="font-size: 18pt" class="mt-2 me-2" id="own" name="types_of_property_transferred[]" value="own" <?php echo (in_array('own', $types_of_property_transferred)) ? 'checked="checked"' : '';?>>
                                                                <label for="own">Co-op/Own-your-own</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <div class="d-flex">
                                                                <input type="checkbox" style="font-size: 18pt" class="mt-2 me-2" id="manufactured" name="types_of_property_transferred[]" value="manufactured" <?php echo (in_array('manufactured', $types_of_property_transferred)) ? 'checked="checked"' : '';?>>
                                                                <label for="manufactured">Manufactured home</label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row mt-3">
                                                        <div class="col-md-4">
                                                            <div class="d-flex">
                                                                <input type="checkbox" style="font-size: 18pt" class="mt-2 me-2" id="multiple" name="types_of_property_transferred[]" value="multiple" <?php echo (in_array('multiple', $types_of_property_transferred)) ? 'checked="checked"' : '';?>>
                                                                <label for="multiple">Multiple-family residence. Number of units: 
                                                                <input type="text" class="input_single form-control" id="num_of_units" name="num_of_units" value="<?php echo $num_of_units;?>"></label>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <div class="d-flex">
                                                                <input type="checkbox" style="font-size: 18pt" class="mt-2 me-2" id="condo" name="types_of_property_transferred[]" value="condo" <?php echo (in_array('condo', $types_of_property_transferred)) ? 'checked="checked"' : '';?>>
                                                                <label for="condo">Condominium</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <div class="d-flex">
                                                                <input type="checkbox" style="font-size: 18pt" class="mt-2 me-2" id="unimproved" name="types_of_property_transferred[]" value="unimproved" <?php echo (in_array('unimproved', $types_of_property_transferred)) ? 'checked="checked"' : '';?>>
                                                                <label for="unimproved">Unimproved lot</label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row mt-3">
                                                        <div class="col-md-4">
                                                            <div class="d-flex">
                                                                <input type="checkbox" style="font-size: 18pt" class="mt-2 me-2" id="timber" name="types_of_property_transferred[]" value="timber" <?php echo (in_array('timber', $types_of_property_transferred)) ? 'checked="checked"' : '';?>>
                                                                <label for="timber">Other. Description: (i.e., timber, mineral, water rights, etc.)</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <div class="d-flex">
                                                                <input type="checkbox" style="font-size: 18pt" class="mt-2 me-2" id="timshare" name="types_of_property_transferred[]" value="timshare" <?php echo (in_array('timshare', $types_of_property_transferred)) ? 'checked="checked"' : '';?>>
                                                                <label for="timshare">Timeshare </label>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <div class="d-flex">
                                                                <input type="checkbox" style="font-size: 18pt" class="mt-2 me-2" id="commercial" name="types_of_property_transferred[]" value="commercial" <?php echo (in_array('commercial', $types_of_property_transferred)) ? 'checked="checked"' : '';?>>
                                                                <label for="commercial">Commercial/Industrial</label>
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
                                                            &nbsp;<input type="radio" name="is_personal_property" id="bpropertyYes" value="yes" <?php echo ($is_personal_property == 'yes') ? 'checked="checked"' : '';?>>&nbsp; <label for="bpropertyYes"> YES</label>&nbsp;
                                                            &nbsp;<input type="radio" name="is_personal_property" id="bpropertyNo" value="no" <?php echo ($is_personal_property == 'no') ? 'checked="checked"' : '';?>>&nbsp; <label for="bpropertyNo"> NO</label> &nbsp;
                                                        </div>
                                                        <div>
                                                            Personal/business property, or incentives, provided by seller to buyer are included in the purchase price. Examples of personal property are furniture, farm equipment, machinery, etc. Examples of incentives are club memberships, etc. Attach list if available.
                                                        </div>
                                                    </div>
                                                    

                                                    If YES, enter the value of the personal/business property: $ <input type="text" class="input_single form-control" id="peronal_property_value" name="peronal_property_value" value="<?php echo $peronal_property_value;?>"> 
                                                    Incentives $ <input type="text" class="input_single form-control" id="incentives" name="incentives" value="<?php echo $incentives;?>">
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>C.</td>
                                                <td>
                                                    <div class="d-flex">
                                                        <div class="me-3">
                                                            &nbsp;<input type="radio" name="is_manufacture_home_included_in_purchase_price" id="purchasePriceYes" value="yes" <?php echo ($is_manufacture_home_included_in_purchase_price == 'yes') ? 'checked="checked"' : '';?>>&nbsp; <label for="purchasePriceYes"> YES</label>&nbsp;
                                                            &nbsp;<input type="radio" name="is_manufacture_home_included_in_purchase_price" id="purchasePriceNo" value="no" <?php echo ($is_manufacture_home_included_in_purchase_price == 'no') ? 'checked="checked"' : '';?>>&nbsp; <label for="purchasePriceNo"> NO</label> &nbsp;
                                                        </div>
                                                        <div>
                                                            A manufactured home is included in the purchase price.
                                                        </div>
                                                        
                                                    </div>
                                                    <div class=" mt-3">
                                                        If YES, enter the value attributed to the manufactured home: $  
                                                        <input type="text" class="input_single form-control" id="value_manufacture_home" name="value_manufacture_home" value="<?php echo $value_manufacture_home;?>">
                                                    </div>
                                                    <div class="d-flex mt-3">
                                                        <div class="me-3">
                                                            &nbsp;<input type="radio" name="is_manufacture_home_tax" id="manufacturedPriceYes" value="yes" <?php echo ($is_manufacture_home_tax == 'yes') ? 'checked="checked"' : '';?>>&nbsp; <label for="manufacturedPriceYes"> YES</label>&nbsp;
                                                            &nbsp;<input type="radio" name="is_manufacture_home_tax" id="manufacturedPriceNo" value="no" <?php echo ($is_manufacture_home_tax == 'no') ? 'checked="checked"' : '';?>>&nbsp; <label for="manufacturedPriceNo"> NO</label> &nbsp;
                                                        </div>
                                                        <div>
                                                            The manufactured home is subject to local property tax. If NO, enter decal number  
                                                            <input type="text" class="input_single form-control" id="deal_number" name="deal_number" value="<?php echo $deal_number;?>">
                                                        </div>
                                                        
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>D.</td>
                                                <td>
                                                    <div class="d-flex">
                                                        <div class="me-3">
                                                            &nbsp;<input type="radio" name="is_property_produce_income" id="purchasePriceYes" value="yes" <?php echo ($is_property_produce_income == 'yes') ? 'checked="checked"' : '';?>>&nbsp; <label for="purchasePriceYes"> YES</label>&nbsp;
                                                            &nbsp;<input type="radio" name="is_property_produce_income" id="purchasePriceNo" value="no" <?php echo ($is_property_produce_income == 'no') ? 'checked="checked"' : '';?>>&nbsp; <label for="purchasePriceNo"> NO</label> &nbsp;
                                                        </div>
                                                        <div>
                                                            The property produces rental or other income.
                                                        </div>
                                                        
                                                    </div>
                                                    <div class="mt-3">
                                                        If YES, the income is from: &nbsp;
                                                        <input type="radio" name="income_type" id="rent" value="rent" <?php echo ($income_type == 'rent') ? 'checked="checked"' : '';?>> &nbsp; <label for="rent">Lease/rent</label>&nbsp;&nbsp;
                                                        <input type="radio" name="income_type" id="contract" value="contract" <?php echo ($income_type == 'contract') ? 'checked="checked"' : '';?>> &nbsp; <label for="contract">Contract</label>&nbsp;&nbsp;
                                                        <input type="radio" name="income_type" id="mineral" value="mineral" <?php echo ($income_type == 'mineral') ? 'checked="checked"' : '';?>> &nbsp; <label for="mineral">Mineral rights</label>&nbsp;&nbsp;
                                                        <input type="radio" name="income_type" id="other_income" value="other_income" <?php echo ($income_type == 'other_income') ? 'checked="checked"' : '';?>> &nbsp; <label for="other_income">Other:&nbsp;&nbsp;
                                                        <input type="text" class="input_single form-control" id="other_income_type" name="other_income_type" value="<?php echo $other_income_type;?>"></label> &nbsp;
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
                                                    <div class="mt-2"> Please describe: <input type="text" class="input_single form-control" id="property_condition_describe" name="property_condition_describe" value="<?php echo $property_condition_describe;?>"></div>
                                                    
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
                                                    <input type="date" style="width:100%;" class="form-control" id="signature_corporate_officer_date" name="signature_corporate_officer_date" value="<?php echo $signature_corporate_officer_date;?>">
                                                    <small class="small_label">DATE </small>
                                                         
                                                </div>
                                                
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group position-relative mb-3">
                                                    <input type="text" style="width:100%;" class="form-control" id="corporate_officer_telephone" name="corporate_officer_telephone" value="<?php echo $corporate_officer_telephone;?>">
                                                    <small class="small_label">TELEPHONE</small>
                                                    
                                                </div>
                                                
                                            </div>
                                        </div>
                                        <div>NAME OF BUYER/TRANSFEREE/PERSONAL REPRESENTATIVE/CORPORATE OFFICER (PLEASE PRINT)</div>
                                        <div class="row mt-2">
                                            <div class="col-md-6">
                                                <div class="form-group position-relative mb-3">
                                                    <input type="text" style="width:100%;" class="form-control" id="corporate_officer_name" name="corporate_officer_name" value="<?php echo $corporate_officer_name;?>">
                                                    <small class="small_label">TITLE  </small>
                                                   
                                                </div>
                                                
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group position-relative mb-3">
                                                    <input type="email" style="width:100%;" class="form-control" id="corporate_officer_email" name="corporate_officer_email" value="<?php echo $corporate_officer_email;?>">
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
                                            <input type="checkbox" style="font-size: 18pt" id="acknowledge" name="acknowledge"  class="me-2 mt-1" checked="checked">
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
                                                    <input type="text" style="width:100%;" class="form-control" id="tenant_id" name="tenant_id" value="<?php echo $tenant_id;?>">
                                                </div>
                                                
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group mb-3">
                                                    <label for="" class="mb-2"><b>DocType</b></label>
                                                    <input type="text" style="width:100%;" class="form-control" id="doc_type" name="doc_type" value="<?php echo $doc_type;?>">
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