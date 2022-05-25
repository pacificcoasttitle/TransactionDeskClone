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
<body class="buyerInfoPack">


    <!-- header -->

    <header>
        <div class="container">
            <div class="row align-items-center">
                <div class="col-8">
                    <h2>Buyer Information Request</h2>
                </div>
                <div class="col-4 text-end">
                    <a href="#"><img src="<?php echo base_url();?>assets/frontend/images/buyer-seller-package/alanna-logo-small.png" alt="" class="logo_img"></a>
                </div>
            </div>
        </div>
    </header>

    <!-- form content -->

    <section class="form_content wizard">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <ul class="nav nav-tabs d-none" role="tablist">
                        <li class="nav-item step1">
                            <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#step1" type="button" role="tab" aria-controls="step1" aria-selected="true">step1</button>
                        </li>
                        <li class="nav-item step2">
                            <button class="nav-link" data-bs-toggle="tab" data-bs-target="#step2" type="button" role="tab" aria-controls="step2" aria-selected="false">step2</button>
                        </li>
                        <li class="nav-item step4">
                            <button class="nav-link" data-bs-toggle="tab" data-bs-target="#step4" type="button" role="tab" aria-controls="step4" aria-selected="false">step4</button>
                        </li>
                    </ul>
                    <form id="wizard-custom"  class="tab-content">
                        <section class="tab-pane active" id="step1" data-step="step1">
                            <p class="mb-5">
                                This is an example of a Buyer Welcome Package.  Please enter your email address below to receive a copy of the completed form.  The completed form is what will be attached to your internal software file.  Some of the fields below are fields that will be pulled from your title software and copied into the form.  These fields are the "Escrow No" and Property Address.  Other fields are available to be pulled from your title software.  Additionally, these forms are branded as Alanna's, but we will add your branding  to the forms if you provide a logo and information....
                            </p>

                            <div class="form-group mb-3">
                                <div class="row">
                                    <label for="" class="mb-2 col-12"><b>FOR EXAMPLE ONLY - Please enter your email to receive a copy of the completed form</b></label>
                                    <div class="col-xl-4 col-md-6">
                                        <input type="text" class="form-control">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="form-group mb-3">
                                        <label for="" class="mb-2">Escrow No. :</label>
                                        <input type="text" class="form-control">
                                    </div>
                                </div>
                                <div class="col-md-9">
                                    <div class="form-group mb-3">
                                        <label for="" class="mb-2">Property Address:</label>
                                        <input type="text" class="form-control">
                                    </div>
                                </div>
                            </div>                        
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
                                </div>
                            </div>
                            <div class="fieldset buyer2">
                                <div class="legend">Enter Buyer #2 Name *</div>
    
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="" class="mb-2">First Name</label>
                                            <input type="text" class="form-control firstName">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="" class="mb-2">Middle Name</label>
                                            <input type="text" class="form-control middleName">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="" class="mb-2">Last Name</label>
                                            <input type="text" class="form-control lastName">
                                        </div>
                                    </div>
                                </div>
                            </div>
    
    
                            <div class="mt-4">
                                Hello Buyer(s)– <br><br>
    
                                We are pleased to have this transaction placed in escrow with us for closing. Upon opening your file and within the process of your closing, we will be gathering information and details about your transaction. Enclosed you will find the following documents which will need your review to complete, sign, and returned to us.<br><br>
    
                                The following items enclosed are:<br><br>
    
                                <ul>
                                    <li>Notice of Compliance to Admission to Practice Rule 12 to be reviewed, acknowledged, and returned to our office.</li>
                                    <li>Escrow Questionnaire for you to complete, sign, and returned to our office to be processed for closing.</li>
                                </ul>
    
                                
                                
                                Once we have received the listed documents back completed and signed, we will be able to proceed with processing your file to prepare for your closing date.<br><br>
    
                                Throughout the transaction, we will provide you with progress updates and access to information. If you have any questions or concerns, please contact our office.
                            </div>
    
    
                            <div class="mt-5">
                                <h4 class="text-center"><b>NOTICE TO PARTIES:</b></h4>
                                <h6 class="text-center mb-5"><b>URGENT!  Please sign and return</b></h6>
    
                                <p>
                                    The undersigned parties acknowledge that the Escrow Agent’s function is to be a neutral third party, taking mutual instructions from the parties to a transaction for preparation of documents to complete the parties prior agreements to facilitate a real estate transaction between the below parties. <br><br>
    
                                    The Escrow Agent is <b>NOT AN ATTORNEY</b> and <b>CAN IN NO WAY ADVISE</b> the parties as to any legal remedy, tax or business consequences of any provision or instrument set forth or prepared in connection with this transaction.  BY EXECUTION HEREOF, the undersigned acknowledge they have read and understand each document which they have signed and have authorized and instructed escrow in the manner in which any blanks remaining in any documents are to be completed.  The undersigned understand that this escrow shall close in accordance with the matters set forth in the documents they have signed. <br><br>
                                    
                                    <b>DO NOT SIGN THIS DOCUMENT UNTIL YOU HAVE READ AND AGREED TO THE MATTERS SET FORTH ABOVE.  SHOULD YOU STILL HAVE QUESTIONS WITH REGARD TO THE ABOVE, YOU ARE ADVISED TO SEEK INDEPENDENT LEGAL COUNSEL.</b>
                                </p>
                            </div>
                            
    
                            <div class="privacy">
                                <input type="checkbox" id="privacyAgreement">
                                <label for="privacyAgreement">I/We agree to the below privacy notice <span>*</span></label>
                            </div>
    
                            <div class="border mt-3 p-3">
                                PLEASE READY THE PRIVACY POLICY CAREFULLY!!
                            </div>
    
                            <div>
                                <label for="canvas1" class="mb-2 mt-4"><b>Buyer #1 Signature: <span>*</span></b></label>
                                <div class="sign_pad">
                                    <canvas id="canvas1" width="500" height="100"></canvas>
                                </div>
                                <a onclick="clear1()" class="clearSign">clear</a>
                            </div>

                            <div class="d-none buyer2_sign">
                                <label for="canvas2" class="mb-2 mt-4"><b>Buyer #2 Signature: <span>*</span></b></label>
                                <div class="sign_pad">
                                    <canvas id="canvas2" width="500" height="100"></canvas>
                                </div>
                                <a onclick="clear2()" class="clearSign">clear</a>
                            </div>
    
                            <div class="mt-5">
                                <h4 class="text-center mb-5"><b>STATEMENT OF INFORMATION</b></h4>
                                <p>
                                    A Statement of Information is a form routinely requested from all the parties within an escrow transaction where title insurance is to be issued at the successful close of escrow. <br><br>
    
                                    We don’t like to ask you to fill out this statement of information.  We don’t want you to think we are unnecessarily interested in your personal affairs.  We are not.  We have been asked to insure a title to real property in which you are interested and if you will give us the information requested, it will help us do our job timely. <br><br>
    
                                    Proper completion of this form will help protect you by enabling the title company to eliminate title problems that might arise through similarities of your name with the name of another person against whom there may be judgments, tax liens, divorce or other matters affecting property ownership.
                                    
                                    The completed form provides THE TITLE COMPANY with information needed to adequately examine documents so as to disregard matters which do not affect you or the property to be insured, matters which may actually apply to some other person.<br><br>
    
                                    Please complete this form completely and return at your earliest convenience.  If you are unable to process this request for any reason, please call our office as soon as possible.<br><br>
    
                                    We thank you in advance for your cooperation.
                                </p>
                            </div>

                            <hr>
                            <div class="mb-5 d-flex justify-content-between">                                
                                &nbsp;
                                <div>
                                  <button class="btn btn-outline-secondary">Save</button>
                                  <button class="btn btn-primary next-step" data-next>Next</button>
                                </div>
                              </div>
                        </section>
              
                        <section class="tab-pane" id="step2" data-step="step2">
                            <h4 class="text-center"><b>BUYER #1 INFORMATION SHEET</b></h4>
                            <hr>
                            <h5 class="text-center"><b>PLEASE COMPLETE AND RETURN IMMEDIATELY</b></h5>
                            <hr>

                            <p class="text-center">
                                Please provide as much information as possible so we can expedite your closing.  Your prompt attention is greatly appreciated.  <span class="text-undeliner"><b>The information you provide will be kep strictly confidential and secure.</b></span>
                            </p>


                            <div class="buyer_info">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group position-relative mb-3">
                                            <label for="" class="mb-2"><b>Buyer #1 - Date of completion of form</b></label>
                                            <input type="date" class="form-control">
                                            <small class="small_label">Date</small>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group mb-3">
                                            <label for="" class="mb-2"><b>Buyer #1 Cell Phone <span>*</span></b></label>
                                            <input type="text" class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group mb-3">
                                            <label for="" class="mb-2"><b>Buyer #1 Home Phone</b></label>
                                            <input type="text" class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group mb-3">
                                            <label for="" class="mb-2"><b>Buyer #1 Email Address <span>*</span></b></label>
                                            <input type="text" class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group mb-3">
                                            <label for="" class="mb-2"><b>Buyer #1 Work Phone</b></label>
                                            <input type="text" class="form-control">
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group mb-4">
                                    <label for="" class="mb-2"><b>Buyer #1 - Are you married or in a registered domestic partnership? <span>*</span></b></label>
                                    <ul class="list-inline">
                                        <li class="list-inline-item me-md-5">
                                            <input type="radio" id="yesmarried" value="yes" name="isMarried"> 
                                            <label for="yesmarried">Yes</label>
                                        </li>
                                        <li class="list-inline-item">
                                            <input type="radio" id="nomarried" value="other" name="isMarried"> 
                                            <label for="nomarried">No</label>
                                        </li>
                                    </ul>
                                </div> 

                                <div class="spouseInfo my-5 d-none">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group mb-3">
                                                <label for="" class="mb-2"><b>Buyer #1 - Spouse/Partners legal name if different than Buyer #2</b></label>
                                                <input type="text" class="form-control">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group mb-3">
                                                <label for="" class="mb-2"><b>Buyer #1 - Please upload your Domestic Partner recorded document</b></label>
                                                <input type="file" id="DomesticFile" class="form-control d-none">
                                                <label for="DomesticFile">
                                                    <span class="mt-0">Browse Files</span>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group mb-3">
                                                <label for="" class="mb-2">We were married on </label>
                                                <input type="date" class="form-control">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group mb-3">
                                                <label for="" class="mb-2">at</label>
                                                <input type="text" placeholder="City, State " class="form-control">
                                            </div>
                                        </div>
                                    </div>
                                </div>


                                <div class="form-group mb-4">
                                    <label for="" class="mb-2"><b>Buyer #1 - Will you be traveling during this transaction?</b></label>
                                    <ul class="list-inline">
                                        <li class="list-inline-item me-md-5">
                                            <input type="radio" id="yesTraveling" value="yes" name="isTraveling"> 
                                            <label for="yesTraveling">Yes</label>
                                        </li>
                                        <li class="list-inline-item">
                                            <input type="radio" id="noTraveling" value="other" name="isTraveling"> 
                                            <label for="noTraveling">No</label>
                                        </li>
                                    </ul>
                                </div>

                                <div class="form-group mb-4">
                                    <label for="" class="mb-2"><b>Buyer #1 - Will you be using a Power of Attorney? <span>*</span></b></label>
                                    <ul class="list-inline">
                                        <li class="list-inline-item me-md-5">
                                            <input type="radio" id="yesAttorney" value="yes" name="isAttorney"> 
                                            <label for="yesAttorney">Yes</label>
                                        </li>
                                        <li class="list-inline-item">
                                            <input type="radio" id="noAttorney" value="other" name="isAttorney"> 
                                            <label for="noAttorney">No</label>
                                        </li>
                                    </ul>
                                </div>

                                <div class="attorneyInfo my-5 d-none">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group mb-3">
                                                <label for="" class="mb-2"><b>Buyer #1 - Who is giving Power of Attorney?  <span>*</span></b></label>
                                                <input type="text" class="form-control">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group mb-3">
                                                <label for="" class="mb-2"><b>Buyer #1 - Who is signing on your behalf? <span>*</span></b></label>
                                                <input type="text" class="form-control">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group mb-3">
                                                <label for="" class="mb-2"><b>Recording No. of Recorded Power of Attorney</b> </label>
                                                <input type="text" class="form-control">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group mb-3">
                                                <label for="" class="mb-2"><b>County of Recorded Power of Attorney</b></label>
                                                <input type="text" class="form-control">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group mb-3">
                                                <label for="" class="mb-2"><b>Buyer #1 - Upload copy of unrecorded POA</b></label>
                                                <input type="file" id="POAFile" class="form-control d-none">
                                                <label for="POAFile">
                                                    <span class="mt-0">Browse Files</span>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>


                                <div class="row mt-4">
                                    <div class="col-md-3">
                                        <div class="form-group position-relative mb-3">
                                            <label for="" class="mb-2"><b><small>Buyer #1 Birthplace <span>*</span></small></b></label>
                                            <input type="text" class="form-control">
                                            <small class="small_label">City, State</small>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group position-relative mb-3">
                                            <label for="" class="mb-2"><b><small>Buyer #1 Date of birth <span>*</span></small></b></label>
                                            <input type="date" class="form-control">
                                            <small class="small_label">Date</small>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group mb-3">
                                            <label for="" class="mb-2"><b><small>Buyer #1 Years lived in this state</small></b></label>
                                            <input type="text" class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group mb-3">
                                            <label for="" class="mb-2"><b><small>Buyer #1 Social Security number <span>*</span></small></b></label>
                                            <input type="text" class="form-control">
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group mb-3 mt-4">
                                    <label for="" class="mb-3"><b>Buyer #1 - Residence during the past 10 years:</b></label>
                                    <ol>
                                        <li>
                                            <div class="row mb-4">
                                                <div class="col-md-4 mb-3">
                                                    <div class="position-relative">
                                                        <input type="text" class="form-control">
                                                        <small class="small_label">Address</small>
                                                    </div>
                                                </div>
                                                <div class="col-md-4 mb-3">
                                                    <div class="position-relative">
                                                        <input type="text" class="form-control">
                                                        <small class="small_label">City</small>
                                                    </div>
                                                </div>
                                                <div class="col-md-4 mb-3">
                                                    <div class="position-relative">
                                                        <select id="" class="form-control">
                                                            <option value="">Please select</option>
                                                        </select>
                                                        <small class="small_label">State</small>
                                                    </div>
                                                </div>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="row mb-4">
                                                <div class="col-md-4 mb-3">
                                                    <div class="position-relative">
                                                        <input type="text" class="form-control">
                                                        <small class="small_label">Address</small>
                                                    </div>
                                                </div>
                                                <div class="col-md-4 mb-3">
                                                    <div class="position-relative">
                                                        <input type="text" class="form-control">
                                                        <small class="small_label">City</small>
                                                    </div>
                                                </div>
                                                <div class="col-md-4 mb-3">
                                                    <div class="position-relative">
                                                        <select id="" class="form-control">
                                                            <option value="">Please select</option>
                                                        </select>
                                                        <small class="small_label">State</small>
                                                    </div>
                                                </div>
                                            </div>
                                        </li>
                                    </ol>
                                </div>

                                <div class="form-group mb-3 mt-4">
                                    <label for="" class="mb-3"><b>Buyer #1 - Occupations during the past 10 years </b> (if Buyer #1 has more than two former occupations during the past 10 years, you will have opportunity to add those separately)</label>
                                    <ol>
                                        <li>
                                            <div class="row mb-4">
                                                <div class="col-md-3 mb-3">
                                                    <div class="position-relative">
                                                        <input type="text" class="form-control">
                                                        <small class="small_label">Occupation</small>
                                                    </div>
                                                </div>
                                                <div class="col-md-3 mb-3">
                                                    <div class="position-relative">
                                                        <input type="text" class="form-control">
                                                        <small class="small_label">Company Name</small>
                                                    </div>
                                                </div>
                                                <div class="col-md-3 mb-3">
                                                    <div class="position-relative">
                                                        <input type="text" class="form-control">
                                                        <small class="small_label">Address, City State</small>
                                                    </div>
                                                </div>
                                                <div class="col-md-3 mb-3">
                                                    <div class="position-relative">
                                                        <input type="text" class="form-control">
                                                        <small class="small_label"># of years</small>
                                                    </div>
                                                </div>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="row mb-4">
                                                <div class="col-md-3 mb-3">
                                                    <div class="position-relative">
                                                        <input type="text" class="form-control">
                                                        <small class="small_label">Occupation</small>
                                                    </div>
                                                </div>
                                                <div class="col-md-3 mb-3">
                                                    <div class="position-relative">
                                                        <input type="text" class="form-control">
                                                        <small class="small_label">Company Name</small>
                                                    </div>
                                                </div>
                                                <div class="col-md-3 mb-3">
                                                    <div class="position-relative">
                                                        <input type="text" class="form-control">
                                                        <small class="small_label">Address, City State</small>
                                                    </div>
                                                </div>
                                                <div class="col-md-3 mb-3">
                                                    <div class="position-relative">
                                                        <input type="text" class="form-control">
                                                        <small class="small_label"># of years</small>
                                                    </div>
                                                </div>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="row mb-4">
                                                <div class="col-md-3 mb-3">
                                                    <div class="position-relative">
                                                        <input type="text" class="form-control">
                                                        <small class="small_label">Occupation</small>
                                                    </div>
                                                </div>
                                                <div class="col-md-3 mb-3">
                                                    <div class="position-relative">
                                                        <input type="text" class="form-control">
                                                        <small class="small_label">Company Name</small>
                                                    </div>
                                                </div>
                                                <div class="col-md-3 mb-3">
                                                    <div class="position-relative">
                                                        <input type="text" class="form-control">
                                                        <small class="small_label">Address, City State</small>
                                                    </div>
                                                </div>
                                                <div class="col-md-3 mb-3">
                                                    <div class="position-relative">
                                                        <input type="text" class="form-control">
                                                        <small class="small_label"># of years</small>
                                                    </div>
                                                </div>
                                            </div>
                                        </li>
                                    </ol>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group mb-3">
                                            <label for="" class="mb-2"><b>Buyer #1 - Former Marriage (s)</b> (if no former marriages write none)</label>
                                            <input type="text" class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group mb-3">
                                            <label for="" class="mb-2"><b>Buyer #1: Name of former spouse/domestic partner</b></label>
                                            <input type="text" class="form-control">
                                        </div>
                                    </div>
                                </div>
                                 
                            </div>

                            <div class="mb-5 d-flex justify-content-between">                                
                              <button class="btn btn-primary prev-step" data-prev>Previous</button>
                              <div>
                                <button class="btn btn-outline-secondary">Save</button>
                                <button class="btn btn-primary next-step" data-next>Next</button>
                              </div>
                            </div>
                        </section>

                        <section class="tab-pane" id="step3" data-step="step3">
                            <h4 class="text-center"><b>BUYER #2 INFORMATION SHEET</b></h4>
                            <hr>
                            <h5 class="text-center"><b>PLEASE COMPLETE AND RETURN IMMEDIATELY</b></h5>
                            <hr>

                            <p class="text-center">
                                Please provide as much information as possible so we can expedite your closing.  Your prompt attention is greatly appreciated.  <span class="text-undeliner"><b>The information you provide will be kep strictly confidential and secure.</b></span>
                            </p>


                            <div class="buyer_info">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group position-relative mb-3">
                                            <label for="" class="mb-2"><b>Buyer #2 - Date of completion of form</b></label>
                                            <input type="date" class="form-control">
                                            <small class="small_label">Date</small>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group mb-3">
                                            <label for="" class="mb-2"><b>Buyer #2 Cell Phone <span>*</span></b></label>
                                            <input type="text" class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group mb-3">
                                            <label for="" class="mb-2"><b>Buyer #2 Home Phone</b></label>
                                            <input type="text" class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group mb-3">
                                            <label for="" class="mb-2"><b>Buyer #2 Email Address <span>*</span></b></label>
                                            <input type="text" class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group mb-3">
                                            <label for="" class="mb-2"><b>Buyer #2 Work Phone</b></label>
                                            <input type="text" class="form-control">
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group mb-4">
                                    <label for="" class="mb-2"><b>Are you married or in a domestic relationship?<span>*</span></b></label>
                                    <ul class="list-inline">
                                        <li class="list-inline-item me-md-5">
                                            <input type="radio" id="yesmarried2" value="yes" name="isMarried2"> 
                                            <label for="yesmarried2">Yes</label>
                                        </li>
                                        <li class="list-inline-item">
                                            <input type="radio" id="nomarried2" value="other" name="isMarried2"> 
                                            <label for="nomarried2">No</label>
                                        </li>
                                    </ul>
                                </div> 

                                <div class="spouseInfo2 my-5 d-none">
                                    <div class="row">                                        
                                        <div class="col-md-6">
                                            <div class="form-group mb-3">
                                                <label for="" class="mb-2"><b>Buyer #2 - Spouse/Partners legal name if different than Buyer #1</b></label>
                                                <input type="text" class="form-control">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group mb-3">
                                                <label for="" class="mb-2"><b>Buyer #2 - Maiden name</b></label>
                                                <input type="text" class="form-control">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group mb-3">
                                                <label for="" class="mb-2"><b>Buyer #2 - Upload your Domestic Partner recorded document</b></label>
                                                <input type="file" id="DomesticFile2" class="form-control d-none">
                                                <label for="DomesticFile2">
                                                    <span class="mt-0">Browse Files</span>
                                                </label>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group mb-4">
                                                <label for="" class="mb-2"><b>Buyer #2 - Will your spouse/partner be residing at this property?<span></span></b></label>
                                                <ul class="list-inline">
                                                    <li class="list-inline-item me-md-5">
                                                        <input type="radio" id="yesresiding2" value="yes" name="isresiding2"> 
                                                        <label for="yesresiding2">Yes</label>
                                                    </li>
                                                    <li class="list-inline-item">
                                                        <input type="radio" id="noresiding2" value="other" name="isresiding2"> 
                                                        <label for="noresiding2">No</label>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>


                                <div class="form-group mb-4">
                                    <label for="" class="mb-2"><b>Buyer #2 - Will you be traveling during this transaction? </b></label>
                                    <ul class="list-inline">
                                        <li class="list-inline-item me-md-5">
                                            <input type="radio" id="yesTraveling2" value="yes" name="isTraveling2"> 
                                            <label for="yesTraveling2">Yes</label>
                                        </li>
                                        <li class="list-inline-item">
                                            <input type="radio" id="noTraveling2" value="other" name="isTraveling2"> 
                                            <label for="noTraveling2">No</label>
                                        </li>
                                    </ul>
                                </div>

                                <div class="form-group mb-4">
                                    <label for="" class="mb-2"><b>Buyer #2 - Will you be using a Power of Attorney? <span>*</span></b></label>
                                    <ul class="list-inline">
                                        <li class="list-inline-item me-md-5">
                                            <input type="radio" id="yesAttorney2" value="yes" name="isAttorney2"> 
                                            <label for="yesAttorney2">Yes</label>
                                        </li>
                                        <li class="list-inline-item">
                                            <input type="radio" id="noAttorney2" value="other" name="isAttorney2"> 
                                            <label for="noAttorney2">No</label>
                                        </li>
                                    </ul>
                                </div>

                                <div class="attorneyInfo2 my-5 d-none">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group mb-3">
                                                <label for="" class="mb-2"><b>Buyer #2 - Who is giving Power of Attorney?   <span>*</span></b></label>
                                                <input type="text" class="form-control">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group mb-3">
                                                <label for="" class="mb-2"><b>Buyer #2 - Who is signing on your behalf? <span>*</span></b></label>
                                                <input type="text" class="form-control">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group mb-3">
                                                <label for="" class="mb-2"><b>Recording No. of Recorded Power of Attorney</b> </label>
                                                <input type="text" class="form-control">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group mb-3">
                                                <label for="" class="mb-2"><b>County of Recorded Power of Attorney</b></label>
                                                <input type="text" class="form-control">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group mb-3">
                                                <label for="" class="mb-2"><b>Buyer #2 - Upload copy of unrecorded POA</b></label>
                                                <input type="file" id="POAFile" class="form-control d-none">
                                                <label for="POAFile">
                                                    <span class="mt-0">Browse Files</span>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>


                                <div class="row mt-4">
                                    <div class="col-md-3">
                                        <div class="form-group position-relative mb-3">
                                            <label for="" class="mb-2"><b><small>Buyer #2 Birthplace <span>*</span></small></b></label>
                                            <input type="text" class="form-control">
                                            <small class="small_label">City, State</small>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group position-relative mb-3">
                                            <label for="" class="mb-2"><b><small>Buyer #2 Date of birth <span>*</span></small></b></label>
                                            <input type="date" class="form-control">
                                            <small class="small_label">Date</small>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group mb-3">
                                            <label for="" class="mb-2"><b><small>Buyer #2 Years lived in this state</small></b></label>
                                            <input type="text" class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group mb-3">
                                            <label for="" class="mb-2"><b><small>Buyer #2 Social Security number <span>*</span></small></b></label>
                                            <input type="text" class="form-control">
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group mb-3 mt-4">
                                    <label for="" class="mb-3"><b>Buyer #2 - Residence during the past 10 years:</b></label>
                                    <ol>
                                        <li>
                                            <div class="row mb-4">
                                                <div class="col-md-4 mb-3">
                                                    <div class="position-relative">
                                                        <input type="text" class="form-control">
                                                        <small class="small_label">Address</small>
                                                    </div>
                                                </div>
                                                <div class="col-md-4 mb-3">
                                                    <div class="position-relative">
                                                        <input type="text" class="form-control">
                                                        <small class="small_label">City</small>
                                                    </div>
                                                </div>
                                                <div class="col-md-4 mb-3">
                                                    <div class="position-relative">
                                                        <select id="" class="form-control">
                                                            <option value="">Please select</option>
                                                        </select>
                                                        <small class="small_label">State</small>
                                                    </div>
                                                </div>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="row mb-4">
                                                <div class="col-md-4 mb-3">
                                                    <div class="position-relative">
                                                        <input type="text" class="form-control">
                                                        <small class="small_label">Address</small>
                                                    </div>
                                                </div>
                                                <div class="col-md-4 mb-3">
                                                    <div class="position-relative">
                                                        <input type="text" class="form-control">
                                                        <small class="small_label">City</small>
                                                    </div>
                                                </div>
                                                <div class="col-md-4 mb-3">
                                                    <div class="position-relative">
                                                        <select id="" class="form-control">
                                                            <option value="">Please select</option>
                                                        </select>
                                                        <small class="small_label">State</small>
                                                    </div>
                                                </div>
                                            </div>
                                        </li>
                                    </ol>
                                </div>

                                <div class="form-group mb-3 mt-4">
                                    <label for="" class="mb-3"><b>Buyer #2 - Occupations during the past 10 years </b>(if Buyer #2 has more than two former occupations during the past 10 years, you will have opportunity to add those separately)</label>
                                    <ol>
                                        <li>
                                            <div class="row mb-4">
                                                <div class="col-md-3 mb-3">
                                                    <div class="position-relative">
                                                        <input type="text" class="form-control">
                                                        <small class="small_label">Occupation</small>
                                                    </div>
                                                </div>
                                                <div class="col-md-3 mb-3">
                                                    <div class="position-relative">
                                                        <input type="text" class="form-control">
                                                        <small class="small_label">Company Name</small>
                                                    </div>
                                                </div>
                                                <div class="col-md-3 mb-3">
                                                    <div class="position-relative">
                                                        <input type="text" class="form-control">
                                                        <small class="small_label">Address, City State</small>
                                                    </div>
                                                </div>
                                                <div class="col-md-3 mb-3">
                                                    <div class="position-relative">
                                                        <input type="text" class="form-control">
                                                        <small class="small_label"># of years</small>
                                                    </div>
                                                </div>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="row mb-4">
                                                <div class="col-md-3 mb-3">
                                                    <div class="position-relative">
                                                        <input type="text" class="form-control">
                                                        <small class="small_label">Occupation</small>
                                                    </div>
                                                </div>
                                                <div class="col-md-3 mb-3">
                                                    <div class="position-relative">
                                                        <input type="text" class="form-control">
                                                        <small class="small_label">Company Name</small>
                                                    </div>
                                                </div>
                                                <div class="col-md-3 mb-3">
                                                    <div class="position-relative">
                                                        <input type="text" class="form-control">
                                                        <small class="small_label">Address, City State</small>
                                                    </div>
                                                </div>
                                                <div class="col-md-3 mb-3">
                                                    <div class="position-relative">
                                                        <input type="text" class="form-control">
                                                        <small class="small_label"># of years</small>
                                                    </div>
                                                </div>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="row mb-4">
                                                <div class="col-md-3 mb-3">
                                                    <div class="position-relative">
                                                        <input type="text" class="form-control">
                                                        <small class="small_label">Occupation</small>
                                                    </div>
                                                </div>
                                                <div class="col-md-3 mb-3">
                                                    <div class="position-relative">
                                                        <input type="text" class="form-control">
                                                        <small class="small_label">Company Name</small>
                                                    </div>
                                                </div>
                                                <div class="col-md-3 mb-3">
                                                    <div class="position-relative">
                                                        <input type="text" class="form-control">
                                                        <small class="small_label">Address, City State</small>
                                                    </div>
                                                </div>
                                                <div class="col-md-3 mb-3">
                                                    <div class="position-relative">
                                                        <input type="text" class="form-control">
                                                        <small class="small_label"># of years</small>
                                                    </div>
                                                </div>
                                            </div>
                                        </li>
                                    </ol>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group mb-3">
                                            <label for="" class="mb-2"><b>Buyer #2: Name of former spouse/domestic partner - Write NONE is no former spouse or domestic partner</b></label>
                                            <input type="text" class="form-control">
                                        </div>
                                    </div>
                                </div>
                                 
                            </div>

                            <div class="mb-5 d-flex justify-content-between">                                
                              <button class="btn btn-primary prev-step" data-prev>Previous</button>
                              <div>
                                <button class="btn btn-outline-secondary">Save</button>
                                <button class="btn btn-primary next-step" data-next>Next</button>
                              </div>
                            </div>
                        </section>
              
                        <section class="tab-pane" id="step4" data-step="step4">
                            <div class="form-group mb-4">
                                <label for="" class="mb-2"><b>Has any Buyer ever declared bankruptcy? <span>*</span></b></label>
                                <ul class="list-inline">
                                    <li class="list-inline-item me-md-5">
                                        <input type="radio" id="yesbankruptcy" value="yes" name="isbankruptcy"> 
                                        <label for="yesbankruptcy">Yes</label>
                                    </li>
                                    <li class="list-inline-item">
                                        <input type="radio" id="nobankruptcy" value="other" name="isbankruptcy"> 
                                        <label for="nobankruptcy">No</label>
                                    </li>
                                </ul>
                            </div>

                            <div class="isbankruptInfo d-none">
                                <div class="row mb-4">
                                    <div class="col-md-6">
                                        <div class="form-group mb-3">
                                            <label for="" class="mb-2"><b>What year filed?</b></label>
                                            <input type="text" class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group mb-3">
                                            <label for="" class="mb-2"><b>Filed in what name(s)? </b></label>
                                            <input type="text" class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group mb-3">
                                            <label for="" class="mb-2"><b>Discharge Granted?</b></label>
                                            <ul class="list-inline">
                                                <li class="list-inline-item me-md-5">
                                                    <input type="radio" id="yesDischarge" value="yes" name="isDischarge"> 
                                                    <label for="yesDischarge">Yes</label>
                                                </li>
                                                <li class="list-inline-item">
                                                    <input type="radio" id="noDischarge" value="other" name="isDischarge"> 
                                                    <label for="noDischarge">No</label>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group mb-3">
                                            <label for="" class="mb-2"><b>Dismissed?</b></label>
                                            <ul class="list-inline">
                                                <li class="list-inline-item me-md-5">
                                                    <input type="radio" id="yesDismissed" value="yes" name="isDismissed"> 
                                                    <label for="yesDismissed">Yes</label>
                                                </li>
                                                <li class="list-inline-item">
                                                    <input type="radio" id="noDismissed" value="other" name="isDismissed"> 
                                                    <label for="noDismissed">No</label>
                                                </li>
                                            </ul>
                                        </div>

                                        <div class="dismissedWhen d-none">
                                            <div class="form-group mb-3">
                                                <label for="" class="mb-2"><b>When?</b></label>
                                                <input type="text" class="form-control">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                               
                            </div>


                            <h4><b>Lender Information</b></h4>
                            <hr>


                            <div class="form-group mb-4">
                                <label for="" class="mb-2"><b> Will this property be purchased using financing? <span>*</span></b></label>
                                <ul class="list-inline">
                                    <li class="list-inline-item me-md-5">
                                        <input type="radio" id="yespurchased" value="yes" name="ispurchased"> 
                                        <label for="yespurchased">Yes</label>
                                    </li>
                                    <li class="list-inline-item">
                                        <input type="radio" id="nopurchased" value="other" name="ispurchased"> 
                                        <label for="nopurchased">No</label>
                                    </li>
                                </ul>
                            </div>

                            <div class="purchasedInfo d-none">
                                <div class="row mb-4">
                                    <div class="col-md-6">
                                        <div class="form-group mb-3">
                                            <label for="" class="mb-2"><b>Lending Institution</b></label>
                                            <input type="text" class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group mb-3">
                                            <label for="" class="mb-2"><b>Loan Officer</b></label>
                                            <input type="text" class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group mb-3">
                                            <label for="" class="mb-2"><b>Loan Officer - Office Phone</b></label>
                                            <input type="text" class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group mb-3">
                                            <label for="" class="mb-2"><b>Loan Officer - Cell Phone</b></label>
                                            <input type="text" class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group mb-3">
                                            <label for="" class="mb-2"><b>Loan Officer - Email Address</b></label>
                                            <input type="text" class="form-control">
                                        </div>
                                    </div>
                                </div>    
                            </div>

                           
                            <h4><b>Property Information</b></h4>
                            <hr>


                            <div class="form-group mb-4">
                                <label for="" class="mb-2"><b>Please verify the address of the property being purchased </b></label>
                                <div class="otherAddress">
                                    <div class="form-group position-relative mb-3">
                                        <input type="text" class="form-control">
                                        <small class="small_label">Street Address</small>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group position-relative mb-3">
                                                <input type="text" class="form-control">
                                                <small class="small_label">City</small>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group position-relative mb-3">
                                                <select name="state" class="form-control" id="state">
                                                    <option value="" selected="">Please Select</option>
                                                </select>
                                                <small class="small_label">State</small>
                                            </div>
                                        </div>    
                                    </div>
                                    <div class="form-group position-relative mb-3 col-md-6">
                                        <input type="text" class="form-control">
                                        <small class="small_label">Zip Code</small>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group mb-4">
                                <label for="" class="mb-2"><b>Is your current address </b></label>
                                <ul class="list-inline">
                                    <li class="list-inline-item me-md-5">
                                        <input type="radio" id="yescurrentAdd" value="yes" name="iscurrentAdd"> 
                                        <label for="yescurrentAdd">Same as the new property address</label>
                                    </li>
                                    <li class="list-inline-item">
                                        <input type="radio" id="nocurrentAdd" value="other" name="iscurrentAdd"> 
                                        <label for="nocurrentAdd">Different address</label>
                                    </li>
                                </ul>
                                <div class="otherAddress mt-4 d-none">
                                    <div class="form-group position-relative mb-3">
                                        <label for="" class="mb-2"><b>Current Address</b></label>
                                        <input type="text" class="form-control">
                                        <small class="small_label">Street Address</small>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group position-relative mb-3">
                                                <input type="text" class="form-control">
                                                <small class="small_label">City</small>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group position-relative mb-3">
                                                <select name="state" class="form-control" id="state">
                                                    <option value="" selected="">Please Select</option>
                                                </select>
                                                <small class="small_label">State</small>
                                            </div>
                                        </div>    
                                    </div>
                                    <div class="form-group position-relative mb-3 col-md-6">
                                        <input type="text" class="form-control">
                                        <small class="small_label">Zip Code</small>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group mb-4">
                                <label for="" class="mb-2"><b>What type of property is being purchased?</b></label>
                                <ul class="list-inline">
                                    <li class="list-inline-item me-md-5">
                                        <input type="radio" id="primaryType" value="yes" name="propertyType"> 
                                        <label for="primaryType">Primary Residence</label>
                                    </li>
                                    <li class="list-inline-item">
                                        <input type="radio" id="investMentType" value="other" name="propertyType"> 
                                        <label for="investMentType">Investment Property</label>
                                    </li>
                                </ul>
                            </div>    


                            <div class="mb-3">
                                <input type="checkbox" name="statement" id="statement">
                                <label for="statement"> This statement is true and to the best of my knowledge</label>
                                <div class="border p-2 mt-2">
                                    There are not outstanding judgements, state tax warrants or internal revenue liens against me. 
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group mb-3">
                                        <label for="" class="mb-2"><b>Date</b></label>
                                        <input type="date" class="form-control" id="">
                                    </div>
                                </div>
                            </div>
                           
                            <div class="row">
                                <div class="col-md-6">
                                    <label for="canvas3" class="mb-2 mt-4"><b>Buyer #1 Signature: <span>*</span></b></label>
                                    <div class="sign_pad">
                                        <canvas id="canvas3" width="500" height="100"></canvas>
                                    </div>
                                    <a onclick="clear3()" class="clearSign">clear</a>
                                </div>
                                <div class="col-md-6">
                                    <label for="canvas4" class="mb-2 mt-4"><b>Buyer #2 Signature: <span>*</span></b></label>
                                    <div class="sign_pad">
                                        <canvas id="canvas4" width="500" height="100"></canvas>
                                    </div>
                                    <a onclick="clear4()" class="clearSign">clear</a>
                                </div>
                            </div>

                            <h5 class="text-danger text-center my-5"><b>You must click SUBMIT below to submit this form to THE TITLE COMPANY.</b></h5>

                            <div class="mb-5 d-flex justify-content-between">                                
                                <button class="btn btn-primary prev-step" data-prev>Previous</button>
                                <div>
                                  <button  class="btn btn-outline-secondary">Save</button>
                                  <button type="submit"  class="btn btn-primary" data-next>Submit</button>

                                  <button class="btn btn-secondary print">Print</button>
                                </div>
                            </div>
                        </section>
                    </form>
                </div>
            </div>
        </div>
    </section>

    <script src="<?php echo base_url();?>assets/frontend/js/order/jquery.min.js"></script>
    <script src="<?php echo base_url();?>assets/frontend/js/order/bootstrap.bundle.min.js"></script>
    <script src="<?php echo base_url();?>assets/frontend/js/order/signature_pad.min.js"></script>
    <script src="<?php echo base_url();?>assets/frontend/js/order/script.js"></script>


    <script>

    $(".next-step").click(function () {
        $('.nav-link.active').parents("li").next("li").find(".nav-link").trigger("click");

    });
    $(".prev-step").click(function () {
        $('.nav-link.active').parents("li").prev("li").find(".nav-link").trigger("click");
    });

    </script>
</body>
</html>