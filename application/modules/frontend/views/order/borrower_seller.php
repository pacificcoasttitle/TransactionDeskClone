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
<body class="sellerInfoPack">


    <!-- header -->

    <header>
        <div class="container">
            <div class="row align-items-center">
                <div class="col-8">
                    <h2>Seller(s) Information Packet</h2>
                </div>
                <div class="col-4 text-end">
                    <a href="#"><img src="<?php echo base_url();?>assets/frontend/images/buyer-seller-package/alanna-logo-small.png" alt="" class="logo_img"></a>
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
                        This is an example of a Seller Welcome Package. Please enter your email address below to receive a copy of the completed form. The completed form is what will be attached to your internal software file. Some of the fields below are fields that will be pulled from your title software and copied into the form. These fields are the "Escrow No" and Property Address. Other fields are available to be pulled from your title software. Additionally, these forms are branded as Alanna's, but we will add your branding to the forms if you provide a logo and information....
                    </p>
                    <form action="">
                        <div class="form-group">
                            <label for="" class="mb-2"><b>FOR EXAMPLE ONLY - Please enter your email address to receive a copy of the completed form</b></label>
                            <div class="col-xl-4 col-md-6">
                                <input type="text" class="form-control">
                            </div>
                        </div>
                        <div class="accordion mt-4" id="accordionExample">
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="headingOne">
                                    <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">Seller Information</button>
                                </h2>
                                <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne" data-bs-parent="#accordionExample">
                                    <div class="accordion-body">

                                        <div class="form-group sellerName mb-5">
                                            <label for="" class="mb-2"><b>Seller's Name exactly as shown on your Drivers license or government issued ID: <span>*</span></b></label>
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <div class="form-group position-relative">
                                                        <input type="text" class="form-control">
                                                        <small class="small_label">First Name</small>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group position-relative">
                                                        <input type="text" class="form-control">
                                                        <small class="small_label">Middle Name</small>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group position-relative">
                                                        <input type="text" class="form-control">
                                                        <small class="small_label">Last Name</small>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group position-relative inputDirty d-none mb-5 row">
                                            <label for="" class="mb-2 col-md-12"><b>Seller 1 Expiration Date of your Driver's License or other government issued ID: <span>*</span></b></label>
                                            <div class="col-md-4">
                                                <input type="date" class="form-control">
                                                <small class="small_label">Date</small>
                                            </div>
                                        </div>

                                        <div class="form-group mb-3 inputDirty d-none row">
                                            <label for="" class="mb-2 col-md-12"><b>Seller 1 Marital Status <span>*</span></b></label>
                                            <ul class="list-unstyled">
                                                <li>
                                                    <input type="radio" value="single" id="single" name="maritalStatus">
                                                    <label for="single">Single</label>
                                                </li>
                                                <li>
                                                    <input type="radio" value="married" id="married" name="maritalStatus">
                                                    <label for="married">Married</label>
                                                </li>
                                            </ul>
                                        </div>


                                        <div class="form-group mb-3">
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <div class="form-group position-relative">
                                                        <label for="" class="mb-2"><b>Seller 1 Preferred Phone Number <span>*</span></b></label>
                                                        <input type="text" class="form-control">
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group position-relative">
                                                        <label for="" class="mb-2"><b>Phone number is <span>*</span></b></label>
                                                        <ul class="list-unstyled">
                                                            <li>
                                                                <input type="radio" name="numberType" value="Home" id="Home">
                                                                <label for="Home">Home Number</label>
                                                            </li>
                                                            <li>
                                                                <input type="radio" name="numberType" value="Cell" id="Cell">
                                                                <label for="Cell">Cell</label>
                                                            </li>
                                                            <li>
                                                                <input type="radio" name="numberType" value="Business" id="Business">
                                                                <label for="Business">Business Phone</label>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>


                                        <div class="form-group position-relative mb-5 inputDirty d-none row">
                                            <label for="" class="mb-2 col-md-12"><b>Seller 1 Email</b></label>
                                            <div class="col-md-6">
                                                <input type="email" class="form-control">
                                                <small class="small_label"> example@example.com</small>
                                            </div>
                                        </div>


                                        <div class="form-group mb-4  inputDirty d-none row">
                                            <label for="" class="mb-2 col-md-12"><b>Seller 1 Seller's Social Security/Tax ID: <span>*</span></b></label>
                                            <div class="col-md-4">
                                                <input type="email" class="form-control">
                                            </div>
                                        </div>

                                        <div class="form-group mb-4">
                                            <label for="" class="mb-2"><b>Is Seller a citizen or resident of a foreign country? <span>*</span></b></label>
                                            <ul class="list-inline">
                                                <li class="list-inline-item me-md-5">
                                                    <input type="radio" value="yes" id="foreignYes" name="foreignResident">
                                                    <label for="foreignYes">Yes</label>
                                                </li>
                                                <li class="list-inline-item">
                                                    <input type="radio" value="no" id="foreignNo" name="foreignResident">
                                                    <label for="foreignNo">No</label>
                                                </li>
                                            </ul>
                                        </div>


                                        <div class="form-group mb-4">
                                            <label for="" class="mb-2"><b>Is there a Co-Seller for this property? <span>*</span></b></label>
                                            <ul class="list-inline">
                                                <li class="list-inline-item me-md-5">
                                                    <input type="radio" value="yes" id="coSellerYes" name="Co-Seller">
                                                    <label for="coSellerYes">Yes</label>
                                                </li>
                                                <li class="list-inline-item">
                                                    <input type="radio" value="no" id="coSellerNo" name="Co-Seller">
                                                    <label for="coSellerNo">No</label>
                                                </li>
                                            </ul>
                                        </div>

                                        <div class="coSellerInfo d-none">
                                            <div class="form-group sellerName mb-5">
                                                <label for="" class="mb-2"><b>Spouse/Co-Seller's Name exactly as shown on their Driver's License or other government issued ID: <span>*</span></b></label>
                                                <div class="row">
                                                    <div class="col-md-4">
                                                        <div class="form-group position-relative">
                                                            <input type="text" class="form-control">
                                                            <small class="small_label">First Name</small>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <div class="form-group position-relative">
                                                            <input type="text" class="form-control">
                                                            <small class="small_label">Middle Name</small>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <div class="form-group position-relative">
                                                            <input type="text" class="form-control">
                                                            <small class="small_label">Last Name</small>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
    
                                            <div class="form-group position-relative mb-5 row">
                                                <label for="" class="mb-2 col-md-12"><b>Expiration Date of their Driver's License or other government issued ID: <span>*</span></b></label>
                                                <div class="col-md-4">
                                                    <input type="date" class="form-control">
                                                    <small class="small_label">Date</small>
                                                </div>
                                            </div>
    
                                            <div class="form-group mb-3 row">
                                                <label for="" class="mb-2 col-md-12"><b>Marital Status <span>*</span></b></label>
                                                <ul class="list-unstyled">
                                                    <li>
                                                        <input type="radio" value="single" id="singlecoSeller" name="coSellermaritalStatus">
                                                        <label for="singlecoSeller">Single</label>
                                                    </li>
                                                    <li>
                                                        <input type="radio" value="married" id="marriedcoSeller" name="coSellermaritalStatus">
                                                        <label for="marriedcoSeller">Married</label>
                                                    </li>
                                                </ul>
                                            </div>

                                            <div class="form-group mb-4 row">
                                                <label for="" class="mb-2 col-md-12"><b>Seller's Social Security/Tax ID: <span>*</span></b></label>
                                                <div class="col-md-4">
                                                    <input type="email" class="form-control">
                                                </div>
                                            </div>

                                            <div class="form-group position-relative mb-5 row">
                                                <label for="" class="mb-2 col-md-12"><b>Email</b></label>
                                                <div class="col-md-6">
                                                    <input type="email" class="form-control">
                                                    <small class="small_label"> example@example.com</small>
                                                </div>
                                            </div>
    
                                            <div class="form-group mb-3">
                                                <div class="row">
                                                    <div class="col-md-4">
                                                        <div class="form-group position-relative">
                                                            <label for="" class="mb-2"><b>Preferred Phone Number <span>*</span></b></label>
                                                            <input type="text" class="form-control">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <div class="form-group position-relative">
                                                            <label for="" class="mb-2"><b>Phone number is <span>*</span></b></label>
                                                            <ul class="list-unstyled">
                                                                <li>
                                                                    <input type="radio" name="coSellernumberType" value="Home" id="HomecoSeller">
                                                                    <label for="HomecoSeller">Home Number</label>
                                                                </li>
                                                                <li>
                                                                    <input type="radio" name="coSellernumberType" value="Cell" id="CellcoSeller">
                                                                    <label for="CellcoSeller">Cell</label>
                                                                </li>
                                                                <li>
                                                                    <input type="radio" name="coSellernumberType" value="Business" id="BusinesscoSeller">
                                                                    <label for="BusinesscoSeller">Business Phone</label>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
    
                                            <div class="form-group mb-4">
                                                <label for="" class="mb-2"><b>Is Seller a citizen or resident of a foreign country? * <span>*</span></b></label>
                                                <ul class="list-inline">
                                                    <li class="list-inline-item me-md-5">
                                                        <input type="radio" value="yes" id="coSellerforeignYes" name="coSellerforeignResident">
                                                        <label for="coSellerforeignYes">Yes</label>
                                                    </li>
                                                    <li class="list-inline-item">
                                                        <input type="radio" value="no" id="coSellerforeignNo" name="coSellerforeignResident">
                                                        <label for="coSellerforeignNo">No</label>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>

                                        <div class="form-group mb-4">
                                            <label for="" class="mb-2"><b>I/We will be attending closing <span>*</span></b></label>
                                            <ul class="list-inline">
                                                <li class="list-inline-item me-md-5">
                                                    <input type="radio" value="yes" id="attendingYes" name="attending">
                                                    <label for="attendingYes">Yes</label>
                                                </li>
                                                <li class="list-inline-item">
                                                    <input type="radio" value="no" id="attendingNo" name="attending">
                                                    <label for="attendingNo">No</label>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>   
                                </div>
                            </div>
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="headingTwo">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">Property and Other Addresses</button>
                                </h2>
                                <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo" data-bs-parent="#accordionExample">
                                    <div class="accordion-body">
                                        <div class="form-group mb-4">
                                            <label for="" class="mb-2"><b>Property Address being sold: </b></label>
                                            <input type="text" class="form-control">
                                        </div>
                                        <div class="form-group mb-4">
                                            <label for="" class="mb-2"><b>Is the above address the correct address of the property being sold? <span>*</span></b></label>
                                            <ul class="list-inline">
                                                <li class="list-inline-item me-md-5">
                                                    <input type="radio" id="yesCorrect" value="yes" name="correctAddress"> 
                                                    <label for="yesCorrect">Yes</label>
                                                </li>
                                                <li class="list-inline-item">
                                                    <input type="radio" id="noCorrect" value="other" name="correctAddress"> 
                                                    <label for="noCorrect">No</label>
                                                </li>
                                            </ul>
                                            <div class="otherAddress d-none">
                                                <div class="form-group position-relative mb-3">
                                                    <label for="" class="mb-2"><b>Enter the property address being sold <span>*</span> </b></label>
                                                    <input type="text" class="form-control">
                                                    <small class="small_label">Street Address</small>
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
                                                            <select name="state" class="form-control" id="state">
                                                                <option value="" selected>Please Select</option>
                                                            </select>
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
                                        <div class="form-group mb-4">
                                            <label for="" class="mb-2"><b>Is the Property Address above your current address? <span>*</span></b></label>
                                            <ul class="list-inline">
                                                <li class="list-inline-item me-md-5">
                                                    <input type="radio" id="yesCurrent" value="yes" name="CurrentAdd"> 
                                                    <label for="yesCurrent">Yes</label>
                                                </li>
                                                <li class="list-inline-item">
                                                    <input type="radio" id="noCurrent" value="other" name="CurrentAdd"> 
                                                    <label for="noCurrent">No</label>
                                                </li>
                                            </ul>
                                            <div class="otherAddress d-none">
                                                <div class="form-group position-relative mb-3">
                                                    <label for="" class="mb-2"><b>Current Address <span>*</span> </b></label>
                                                    <input type="text" class="form-control">
                                                    <small class="small_label">Street Address</small>
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
                                                            <select name="state" class="form-control" id="state">
                                                                <option value="" selected>Please Select</option>
                                                            </select>
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
                                        <div class="form-group mb-4">
                                            <label for="" class="mb-2"><b>Is your Forwarding Address different from your Current Address?  <span>*</span></b></label>
                                            <ul class="list-inline">
                                                <li class="list-inline-item me-md-5">
                                                    <input type="radio" id="yesForwarding" value="other" name="ForwardingAdd"> 
                                                    <label for="yesForwarding">Yes</label>
                                                </li>
                                                <li class="list-inline-item">
                                                    <input type="radio" id="noForwarding" value="no" name="ForwardingAdd"> 
                                                    <label for="noForwarding">No</label>
                                                </li>
                                            </ul>
                                            <div class="otherAddress d-none">
                                                <div class="form-group position-relative mb-3">
                                                    <label for="" class="mb-2"><b>Forwarding Address <span>*</span> </b></label>
                                                    <input type="text" class="form-control">
                                                    <small class="small_label">Street Address</small>
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
                                                            <select name="state" class="form-control" id="state">
                                                                <option value="" selected>Please Select</option>
                                                            </select>
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

                                        <div class="form-group mb-4">
                                            <label for="" class="mb-2"><b>This property was our  <span>*</span></b></label>
                                            <ul class="list-inline">
                                                <li class="list-inline-item me-md-5">
                                                    <input type="radio" id="primary" value="primary" name="residence"> 
                                                    <label for="primary">Primary Residence</label>
                                                </li>
                                                <li class="list-inline-item me-md-5">
                                                    <input type="radio" id="secondary" value="secondary" name="residence"> 
                                                    <label for="secondary">Second Home</label>
                                                </li>
                                                <li class="list-inline-item">
                                                    <input type="radio" id="investment" value="investment" name="residence"> 
                                                    <label for="investment">Investment Property</label>
                                                </li>
                                            </ul>
                                        </div>

                                        <div class="form-group mb-4">
                                            <label for="" class="mb-2"><b>Do you have your title insurance policy from when you purchased the house? (It will save some time in doing your title search because we will tack to your current policy.)</b></label>
                                            <ul class="list-inline">
                                                <li class="list-inline-item me-md-5">
                                                    <input type="radio" id="yesinsurance" value="yes" name="insurance"> 
                                                    <label for="yesinsurance">Yes</label>
                                                </li>
                                                <li class="list-inline-item">
                                                    <input type="radio" id="noinsurance" value="no" name="insurance"> 
                                                    <label for="noinsurance">No</label>
                                                </li>
                                            </ul>
                                            <div class="insuranceFile d-none mb-4">
                                                <input type="file" name="insuranceFile" class="d-none" id="insuranceFile">
                                                <label for="insuranceFile">
                                                    <b>Please upload your prior title insurance policy</b>
                                                    <span>Browse Files</span>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="headingThree">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">REAL ESTATE AGENT</button>
                                </h2>
                                <div id="collapseThree" class="accordion-collapse collapse" aria-labelledby="headingThree" data-bs-parent="#accordionExample">
                                    <div class="accordion-body">

                                        <div class="form-group mb-4">
                                            <label for="" class="mb-2"><b>Are you being represented by a Real Estate Agent? <span>*</span></b></label>
                                            <ul class="list-inline">
                                                <li class="list-inline-item me-md-5">
                                                    <input type="radio" id="yesRealEstate" value="yes" name="RealEstate"> 
                                                    <label for="yesRealEstate">Yes</label>
                                                </li>
                                                <li class="list-inline-item">
                                                    <input type="radio" id="noRealEstate" value="no" name="RealEstate"> 
                                                    <label for="noRealEstate">No</label>
                                                </li>
                                            </ul>
                                        </div>    

                                        <div class="RealEstateInfo d-none">
                                            <h3 class="text-center"><b>Real Estate Agent Information:</b></h3>
                                            <hr>
                                            <div class="form-group sellerName mb-5">
                                                <label for="" class="mb-2"><b>Seller Agent's Name <span>*</span></b></label>
                                                <div class="row">
                                                    <div class="col-md-4">
                                                        <div class="form-group position-relative">
                                                            <input type="text" class="form-control">
                                                            <small class="small_label">First Name</small>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <div class="form-group position-relative">
                                                            <input type="text" class="form-control">
                                                            <small class="small_label">Middle Name</small>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <div class="form-group position-relative">
                                                            <input type="text" class="form-control">
                                                            <small class="small_label">Last Name</small>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="form-group row mb-4">
                                                <label for="" class="mb-2 col-12"><b>Agent's Company:<span>*</span></b></label>
                                                <div class="col-md-8">
                                                    <input type="text" class="form-control">
                                                </div>
                                            </div>
                                            
                                            <div class="otherAddress mb-5">
                                                <div class="form-group position-relative mb-3">
                                                    <label for="" class="mb-2"><b>Agent's Company Address </b></label>
                                                    <input type="text" class="form-control">
                                                    <small class="small_label">Street Address</small>
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
                                                            <select name="state" class="form-control" id="state">
                                                                <option value="" selected>Please Select</option>
                                                            </select>
                                                            <small  class="small_label">State</small>
                                                        </div>
                                                    </div>    
                                                </div>
                                                <div class="form-group position-relative mb-3 col-md-6">
                                                    <input type="text" class="form-control">
                                                    <small  class="small_label">Zip Code</small>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group mb-3">
                                                        <label for=""><b>Amount/Percent of Commission:</b></label>
                                                        <input type="text" class="form-control">
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group mb-3">
                                                        <label for=""><b>Amount of Any Deductions from Commission: </b></label>
                                                        <input type="text" class="form-control">
                                                    </div>
                                                </div>   
                                                <div class="col-md-6">
                                                    <div class="form-group position-relative mb-4">
                                                        <label for=""><b>Agent Phone</b></label>
                                                        <input type="text" class="form-control">
                                                        <small  class="small_label">Cell Phone or Email is required</small>
                                                    </div>
                                                </div>   
                                            </div>

                                            
                                            <div class="form-group position-relative row mb-4">
                                                <label for="" class="mb-2 col-12"><b>Email<span></span></b></label>
                                                <div class="col-md-8">
                                                    <input type="text" class="form-control">
                                                    <small  class="small_label">Cell Phone or Email is required</small>
                                                </div>
                                            </div>
                                        </div>


                                        <div class="form-group mb-4">
                                            <label for="" class="mb-2"><b>Seller Will be Paying and providing invoices for</b></label>
                                            <ul class="list-unstyled">
                                                <li>
                                                    <input type="checkbox" id="repair" value="repairs" name="payInvoice"> 
                                                    <label for="repair">Repairs</label>
                                                </li>
                                                <li>
                                                    <input type="checkbox" id="warranty" value="warranty" name="payInvoice"> 
                                                    <label for="warranty">Home Warranty</label>
                                                </li>
                                                <li>
                                                    <input type="checkbox" id="other" value="other" name="payInvoice"> 
                                                    <label for="other">Other</label>
                                                </li>
                                                <li>
                                                    <input type="checkbox" id="none" value="none" name="payInvoice"> 
                                                    <label for="none"> None</label>
                                                </li>
                                            </ul>
                                            <div class="insuranceFile d-none mb-4">
                                                <input type="file" name="insuranceFile" class="d-none" id="insuranceFile">
                                                <label for="insuranceFile">
                                                    <b>Upload Invoice(s) if available</b>
                                                    <span>Browse Files</span>
                                                </label>
                                            </div>
                                        </div>    
                                    </div>
                                </div>
                            </div>
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="headingFour">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFour" aria-expanded="false" aria-controls="collapseFour">
                                        MORTGAGE AND AUTHORIZATION FOR THE RELEASE OF INFORMATION
                                    </button>
                                </h2>
                                <div id="collapseFour" class="accordion-collapse collapse" aria-labelledby="headingFour" data-bs-parent="#accordionExample">
                                    <div class="accordion-body">
                                        <div class="form-group mb-4">
                                            <label for="" class="mb-2"><b> Is there a mortgage on the property?</b></label>
                                            <ul class="list-inline">
                                                <li class="list-inline-item me-md-5">
                                                    <input type="radio" id="yesmortgage" value="yes" name="Mortgage"> 
                                                    <label for="yesmortgage">Yes</label>
                                                </li>
                                                <li class="list-inline-item">
                                                    <input type="radio" id="nomortgage" value="no" name="Mortgage"> 
                                                    <label for="nomortgage">No</label>
                                                </li>
                                            </ul>
                                        </div>   
                                       
                                        <div class="d-none" id="mortgage">
                                            <div class="form-group mb-4">
                                                <label for="" class="mb-2"><b>Is this mortgage/loan a Line of Credit?</b></label>
                                                <ul class="list-inline">
                                                    <li class="list-inline-item me-md-5">
                                                        <input type="radio" id="yesCreditCard" value="yes" name="CreditCard"> 
                                                        <label for="yesCreditCard">Yes</label>
                                                    </li>
                                                    <li class="list-inline-item">
                                                        <input type="radio" id="noCreditCard" value="no" name="CreditCard"> 
                                                        <label for="noCreditCard">No</label>
                                                    </li>
                                                </ul>
                                                <div class="form-group CreditCardLock d-none mb-4">
                                                    <label for="" class="mb-2"><b>Do you want to close and lock this Line of Credit?</b></label>
                                                    <ul class="list-inline">
                                                        <li class="list-inline-item me-md-5">
                                                            <input type="radio" id="yesCreditCardLock" value="yes" name="CreditCardLock"> 
                                                            <label for="yesCreditCardLock">Yes</label>
                                                        </li>
                                                        <li class="list-inline-item">
                                                            <input type="radio" id="noCreditCardLock" value="no" name="CreditCardLock"> 
                                                            <label for="noCreditCardLock">No</label>
                                                        </li>
                                                    </ul>
                                                </div> 
                                            </div>    
                                            <div class="form-group mb-4">
                                                <label for="" class="mb-2"><b>Lender/Mortgage Holder:</b></label>
                                                <input type="text" class="form-control">
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group mb-4">
                                                        <label for="" class="mb-2"><b>Original Loan Amount:</b></label>
                                                        <input type="text" class="form-control">
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group mb-4">
                                                        <label for="" class="mb-2"><b>Lender/Mortgage Holder Phone:</b></label>
                                                        <input type="text" class="form-control">
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group mb-4">
                                                        <label for="" class="mb-2"><b>Loan Number:</b></label>
                                                        <input type="text" class="form-control">
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group mb-4">
                                                        <label for="" class="mb-2"><b>Approximate Loan Balance:</b></label>
                                                        <input type="text" class="form-control">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group mb-4">
                                                <label for="" class="mb-2"><b>Account Holder's Name:</b></label>
                                                <input type="text" class="form-control">
                                            </div>

                                            
                                            <div class="form-group mb-3">
                                                <label for="" class="mb-2"><b>Is there a 2nd mortgage on the property?</b></label>
                                                <ul class="list-inline">
                                                    <li class="list-inline-item me-md-5">
                                                        <input type="radio" id="yesmortgage2" value="yes" name="mortgage2"> 
                                                        <label for="yesmortgage2">Yes</label>
                                                    </li>
                                                    <li class="list-inline-item">
                                                        <input type="radio" id="nomortgage2" value="no" name="mortgage2"> 
                                                        <label for="nomortgage2">No</label>
                                                    </li>
                                                </ul>

                                                <div class="secondMortgage d-none">
                                                    <div class="form-group mb-4">
                                                        <label for="" class="mb-2"><b>Is the 2nd mortgage a Line of Credit?</b></label>
                                                        <ul class="list-inline">
                                                            <li class="list-inline-item me-md-5">
                                                                <input type="radio" id="yesCreditCard2" value="yes" name="CreditCard2"> 
                                                                <label for="yesCreditCard2">Yes</label>
                                                            </li>
                                                            <li class="list-inline-item">
                                                                <input type="radio" id="noCreditCard2" value="no" name="CreditCard2"> 
                                                                <label for="noCreditCard2">No</label>
                                                            </li>
                                                        </ul>
                                                        <div class="form-group CreditCardLock d-none mb-4">
                                                            <label for="" class="mb-2"><b>Do you want to close and lock this Line of Credit?</b></label>
                                                            <ul class="list-inline">
                                                                <li class="list-inline-item me-md-5">
                                                                    <input type="radio" id="yesCreditCardLock2" value="yes" name="CreditCardLock2"> 
                                                                    <label for="yesCreditCardLock2">Yes</label>
                                                                </li>
                                                                <li class="list-inline-item">
                                                                    <input type="radio" id="noCreditCardLock2" value="no" name="CreditCardLock2"> 
                                                                    <label for="noCreditCardLock2">No</label>
                                                                </li>
                                                            </ul>
                                                        </div> 
                                                    </div>    
                                                    <div class="form-group mb-4">
                                                        <label for="" class="mb-2"><b>2nd Lender/Mortgage Holder:</b></label>
                                                        <input type="text" class="form-control">
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <div class="form-group mb-4">
                                                                <label for="" class="mb-2"><b>2nd Original Loan Amount:</b></label>
                                                                <input type="text" class="form-control">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group mb-4">
                                                                <label for="" class="mb-2"><b>2nd Lender/Mortgage Holder Phone:</b></label>
                                                                <input type="text" class="form-control">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group mb-4">
                                                                <label for="" class="mb-2"><b>2nd Loan Number:</b></label>
                                                                <input type="text" class="form-control">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group mb-4">
                                                                <label for="" class="mb-2"><b>2nd Approximate Loan Balance:</b></label>
                                                                <input type="text" class="form-control">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="form-group mb-4">
                                                        <label for="" class="mb-2"><b>2nd Account Holder's Name:</b></label>
                                                        <input type="text" class="form-control">
                                                    </div>
                                                </div>
                                            </div>

                                            <h3 class="text-center mb-4"><b>AUTHORIZATION FOR THE RELEASE OF INFORMATION</b></h3>

                                            TO WHOM IT MAY CONCERN:<br><br>

                                            I (WE), The undersigned parties hereby release, authorize and direct TITLE COMPANY NAME to release all necessary loan information and data to my real estate broker, and other third party contractors including but not limited to lien holders, and title insurance companies. <br><br>

                                            I (WE), the undersigned parties hereby release, authorize and direct your respective companies to release all necessary loan information and data to:<br><br>

                                            TITLE COMPANY NAME, and lenders.  Phone: &nbsp; (111) 111-1111  &nbsp; &nbsp;&nbsp;&nbsp;  Fax: &nbsp; (111) 222-2222<br><br>

                                            For the purpose of obtaining payoffs of my loans below, for a Short Sale payoff of the same which may require such disclosures, and for Closing Instruction Compliance.<br><br>

                                            For your convenience, I (WE) have attached the following information:<br><br>

                                            <div class="mb-3"><b>FIRST LOAN / PRIMARY LOAN / MORTGAGE</b></div>
                                            <div class="row mb-3">
                                                <div class="col-md-6">
                                                    <table class="table_fee_table">
                                                        <tr>
                                                            <td>Loan Number</td>
                                                            <th></th>
                                                        </tr>
                                                        <tr>
                                                            <td>Loan Amount</td>
                                                            <th>$</th>
                                                        </tr>
                                                        <tr>
                                                            <td>Lender's Name</td>
                                                            <th>CASH</th>
                                                        </tr>
                                                        <tr>
                                                            <td>Lender's Phone	</td>
                                                            <th></th>
                                                        </tr>
                                                    </table>
                                                </div>
                                                <div class="col-md-6">
                                                    <table class="table_fee_table">
                                                        <tr>
                                                            <td>Account Balance</td>
                                                            <th>$</th>
                                                        </tr>
                                                        <tr>
                                                            <td>Account Holder's Name:</td>
                                                            <th></th>
                                                        </tr>
                                                        <tr>
                                                            <td>&nbsp;</td>
                                                            <th>&nbsp;</th>
                                                        </tr>
                                                        <tr>
                                                            <td>Phone Number:  </td>
                                                            <th></th>
                                                        </tr>
                                                    </table>
                                                </div>
                                            </div>
                                            <div class="mb-3"><b>SECOND LOAN / EQUITY LINE OF CREDIT</b></div>
                                            <div class="row mb-3">
                                                <div class="col-md-6">
                                                    <table class="table_fee_table">
                                                        <tr>
                                                            <td>Loan Number</td>
                                                            <th></th>
                                                        </tr>
                                                        <tr>
                                                            <td>Loan Amount</td>
                                                            <th>$</th>
                                                        </tr>
                                                        <tr>
                                                            <td>Lender's Name</td>
                                                            <th></th>
                                                        </tr>
                                                        <tr>
                                                            <td>Lender's Phone	</td>
                                                            <th></th>
                                                        </tr>
                                                    </table>
                                                </div>
                                                <div class="col-md-6">
                                                    <table class="table_fee_table">
                                                        <tr>
                                                            <td>Account Balance</td>
                                                            <th>$</th>
                                                        </tr>
                                                        <tr>
                                                            <td>Account Holder's Name:</td>
                                                            <th></th>
                                                        </tr>
                                                        <tr>
                                                            <td>&nbsp;</td>
                                                            <th>&nbsp;</th>
                                                        </tr>
                                                        <tr>
                                                            <td>Phone Number:  </td>
                                                            <th></th>
                                                        </tr>
                                                    </table>
                                                </div>
                                            </div>

                                            <div class="mb-5">
                                                I(We), authorize the release of the information and for the bank to close and freeze any equity line described above.
                                            </div>

                                        </div>

                                        <div class="form-group mb-2">
                                            <input type="checkbox" id="agree">
                                            <label for="agree">I/We have read and agree to <span>*</span></label>
                                        </div>
                                        <div class="border p-3">
                                            the above payoff authorization as indicated by signing below.
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="headingFive">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFive" aria-expanded="false" aria-controls="collapseFive">
                                        HOMEOWNERS ASSOCIATION
                                    </button>
                                </h2>
                                <div id="collapseFive" class="accordion-collapse collapse" aria-labelledby="headingFive" data-bs-parent="#accordionExample">
                                    <div class="accordion-body">
                                        
                                        <div class="form-group mb-4">
                                            <label for="" class="mb-2"><b>Does your property have an HOA? <span>*</span></b></label>
                                            <ul class="list-inline">
                                                <li class="list-inline-item me-md-5">
                                                    <input type="radio" id="yesHOA" value="yes" name="HOA"> 
                                                    <label for="yesHOA">Yes</label>
                                                </li>
                                                <li class="list-inline-item">
                                                    <input type="radio" id="noHOA" value="no" name="HOA"> 
                                                    <label for="noHOA">No</label>
                                                </li>
                                            </ul>
                                        </div>  

                                        <div class="homeOwner d-none">
                                            <h3 class="mb-4 text-center"><b>Homeowners Association Management Information:</b></h3>
                                            
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group mb-3">
                                                        <label for="" class="mb-2">Name of Management Company:</label>
                                                        <input type="text" class="form-control">
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group mb-3">
                                                        <label for="" class="mb-2">Contact Person:</label>
                                                        <input type="text" class="form-control">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group position-relative mb-3">
                                                        <label for="" class="mb-2">Email:</label>
                                                        <input type="text" class="form-control">
                                                        <small class="small_label">example@example.com</small>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group mb-3">
                                                        <label for="" class="mb-2">Phone:</label>
                                                        <input type="text" class="form-control">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group mb-3">
                                                        <label for="" class="mb-2">HOA Dues:</label>
                                                        <input type="text" class="form-control">
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group mb-3">
                                                        <label for="" class="mb-2">Dues Per</label>
                                                        <ul class="list-unstyled">
                                                            <li>
                                                                <input type="radio" id="month" name="due"> 
                                                                <label for="month">Month</label>
                                                            </li>
                                                            <li>
                                                                <input type="radio" id="Quarter" name="due"> 
                                                                <label for="Quarter">Quarter</label>
                                                            </li>
                                                            <li>
                                                                <input type="radio" id="Semi-Annually" name="due"> 
                                                                <label for="Semi-Annually">Semi-Annually</label>
                                                            </li>
                                                            <li>
                                                                <input type="radio" id="Annually" name="due"> 
                                                                <label for="Annually">Annually</label>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group mb-3">
                                                <label for="" class="mb-2">Notes:</label>
                                                <input type="text" class="form-control">
                                            </div>
                                            <div class="form-group mb-4">
                                                <label for="" class="mb-2"><b>Does the property have a 2nd Home Owner's Association? <span>*</span></b></label>
                                                <ul class="list-inline">
                                                    <li class="list-inline-item me-md-5">
                                                        <input type="radio" id="yesHOA2" value="yes" name="HOA2"> 
                                                        <label for="yesHOA2">Yes</label>
                                                    </li>
                                                    <li class="list-inline-item">
                                                        <input type="radio" id="noHOA2" value="no" name="HOA2"> 
                                                        <label for="noHOA2">No</label>
                                                    </li>
                                                </ul>
                                            </div> 
                                            
                                            <div class="homeOwner2 d-none">
                                                <h3 class="mb-4 text-center"><b>2nd Homeowners Association Management Information:</b></h3>
                                                
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="form-group mb-3">
                                                            <label for="" class="mb-2">Name of 2nd Management Company:</label>
                                                            <input type="text" class="form-control">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group mb-3">
                                                            <label for="" class="mb-2">Contact Person:</label>
                                                            <input type="text" class="form-control">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="form-group position-relative mb-3">
                                                            <label for="" class="mb-2">Email:</label>
                                                            <input type="text" class="form-control">
                                                            <small class="small_label">example@example.com</small>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group mb-3">
                                                            <label for="" class="mb-2">Phone:</label>
                                                            <input type="text" class="form-control">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="form-group mb-3">
                                                            <label for="" class="mb-2">2nd HOA Dues:</label>
                                                            <input type="text" class="form-control">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group mb-3">
                                                            <label for="" class="mb-2">Dues Per</label>
                                                            <ul class="list-unstyled">
                                                                <li>
                                                                    <input type="radio" id="month2" name="due2"> 
                                                                    <label for="month2">Month</label>
                                                                </li>
                                                                <li>
                                                                    <input type="radio" id="Quarter2" name="due2"> 
                                                                    <label for="Quarter2">Quarter</label>
                                                                </li>
                                                                <li>
                                                                    <input type="radio" id="Semi-Annually2" name="due2"> 
                                                                    <label for="Semi-Annually2">Semi-Annually</label>
                                                                </li>
                                                                <li>
                                                                    <input type="radio" id="Annually2" name="due2"> 
                                                                    <label for="Annually2">Annually</label>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group mb-3">
                                                    <label for="" class="mb-2">2nd HOA Notes:</label>
                                                    <input type="text" class="form-control">
                                                </div>
                                            </div>    
                                            
                                        </div>

                                        <div class="border p-3">
                                            * OUR STATE LAW PROHIBITS THE DISBURSEMENT OF CLOSING FUNDS PRIOR TO THE RECORDING OF THE DEED AND BUYER’S DEED OF TRUST. TITLE COMPANY NAME MAKES EVERY EFFORT TO EXPEDITE CLOSING AND RECORDING. PARTIES WILL BE NOTIFIED WHEN CLOSING DISBURSEMENTS ARE AVAILABLE. PARTIES WHO REQUEST FUNDS TO BE WIRED WILL INCUR A $25.00 WIRE FEE, WHICH IS DEDUCTED FROM WIRED FUNDS, AND MUST PROVIDE TITLE COMPANY NAME A VOIDED CHECK BEARING THE NAMES OF ALL PARTIES ENTITLED TO THE FUNDS, THE ACCOUNT NUMBER, AND BANK ROUTING NUMBER.
                                        </div>


                                    </div>
                                </div>
                            </div>
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="headingSix">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseSix" aria-expanded="false" aria-controls="collapseSix">
                                        Seller's Closing Agreement and Disclosures
                                    </button>
                                </h2>
                                <div id="collapseSix" class="accordion-collapse collapse" aria-labelledby="headingSix" data-bs-parent="#accordionExample">
                                    <div class="accordion-body">

                                        <h3 class="mb-4 text-ecnter"><b>SELLERS' CLOSING AGREEMENT AND DISCLOSURES</b></h3>

                                        <p>
                                            <b>FEES AND COSTS</b> - Our standard closing fee has been disclosed to you.  All fees paid to our firm will be designated on the Closing Disclosure or HUD, if applicable. If we are required to perform additional services beyond those described herein, we will charge extra for them. Please note this may cause a delay if we are not made aware of the change until the last minute, due to the disclosure tolerances.  Without limiting the definition of “additional services”, examples would be preparation of a subordination agreement or release deed, powers of attorney or any other documents. Certain charges on the Closing Disclosure, Settlement Statement, including but not limited to overnight/courier and recording fees, may not reflect the actual costs paid by the settlement agent to a vendor. The additional amount is to cover our administrative aspects of handling the particular item or service. I/We hereby consent to and accept the above-referenced up-charges.
                                        </p>

                                        <p class="mb-0">
                                            <b>TERMS OF REPRESENTATION -</b>  
                                        </p>
                                        <p>
                                            Unless explicitly stated in writing, we do NOT represent you, the Seller, in this transaction. We advise you to seek legal assistance.  No member of our firm can give you legal advice other than to obtain independent counsel of your choice. 
                                        </p>
                                        <p>
                                            As an accommodation to you, we are permitted by law to prepare the documents that you will need to sign at closing, such as the Seller’s Uniform Closing Disclosure, Settlement Statement, Deed and Lien Waiver. The drafting of these documents does not create an attorney–client relationship. We will prepare the documents consistent with the specifications of the purchase agreement. If the purchase agreement does not indicate specifications, we will prepare the documents to advance the interests of the Buyer.
                                        </p>
                                        <p>
                                            IF THE SELLER IS MARRIED, HIS /HER SPOUSE MUST ATTEND OR ARRANGE TO SIGN THE DEED AND LIEN WAIVER (THIS INCLUDES SEPARATION). TITLE COMPANY WILL NOT PERMIT A DEED AND LIEN WAIVER TO BE EXECUTED BY POWER OF ATTORNEY, EXCEPT IN EXTENUATING CIRCUMSTANCES.  
                                        </p>
                                        
                                        <div class="text-primary text-center mb-3"><b>  ********** Standard Closing Costs  ************</b></div>
                                        
                                        <div class="mb-3">
                                            <table class="table_fee_table mx-auto">
                                                <tr>
                                                    <td>Seller Document Preparation</td>
                                                    <th>$300</th>
                                                </tr>
                                                <tr>
                                                    <td>Satisfaction Tracking</td>
                                                    <th>$45</th>
                                                </tr>
                                                <tr>
                                                    <td>1031 Exchange</td>
                                                    <th>$200</th>
                                                </tr>
                                                <tr>
                                                    <td>Wire Fee</td>
                                                    <th>$25 per wire</th>
                                                </tr>
                                                <tr>
                                                    <td>UPS</td>
                                                    <th>$25 per package	 </th>
                                                </tr>
                                            </table>
                                        </div>
                                        <div class="text-center mb-3"><b>****Additional document(s) are on a case-by-case basis </b> </div>
                                        <p>
                                            You also have the choice of retaining your own attorney at your expense beyond the normal Closing Fee to draft your documents. In that event, please have the attorney send all necessary documents (at minimum, a deed and lien waiver) to our office at least 3 business days prior to closing for our review and possible changes.
                                        </p>
                                        <p>
                                            If you are using a 1031 Exchange, there will be an additional $200 fee for work related to the exchange. Call us as soon as possible if there is a 1031 exchange. 
                                        </p>

                                        <div class="form-group mb-3">
                                            <label for="" class="mb-2"><b>Select One: <span>*</span></b></label>
                                            <ul class="list-unstyled">
                                                <li>
                                                    <input type="radio" id="attorney" value="no" name="attorney">
                                                    <label for="attorney">I would like THIS ATTORNEY to prepare a deed and lien waiver for me pursuant to the understanding above.</label>
                                                </li>
                                                <li>
                                                    <input type="radio" id="otherAttorney" value="yes" name="attorney">
                                                    <label for="otherAttorney">The following attorney will draft my deed and lien waiver and secure cancellation of all deeds of trust and other exceptions to title.</label>
                                                </li>
                                            </ul>
                                        </div>

                                        
                                        <div class="attorneyInfo d-none">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group mb-4">
                                                        <label for="" class="mb-2"><b>Firm Name:</b></label>
                                                        <input type="text" class="form-control">
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group mb-4">
                                                        <label for="" class="mb-2"><b>Phone Number:</b></label>
                                                        <input type="text" class="form-control">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <div class="form-group mb-4">
                                                        <label for="" class="mb-2"><b>Attorney Name:</b></label>
                                                        <input type="text" class="form-control">
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group mb-4">
                                                        <label for="" class="mb-2"><b>Attorney Phone No.:</b></label>
                                                        <input type="text" class="form-control">
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group position-relative mb-4">
                                                        <label for="" class="mb-2"><b>Attorney Email:</b></label>
                                                        <input type="text" class="form-control">
                                                        <small class="small_label">example@example.com</small>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>


                                        <p>
                                            <b>WHAT SERVICES DO WE PERFORM-</b>  We conduct the title examination of the property for the Buyer, we ensure that the deed of conveyance and the loan documents have been properly executed, that the closing funds are properly received and disbursed pursuant to the Settlement Statement to be prepared by us and reviewed by you at closing, and that the Buyers deed and deed of trust (mortgage) are duly recorded and that the owners’ and lender’s policies of title insurance are issued and delivered. If we are drafting the deed and lien waiver for the Seller we will furnish payoffs of the outstanding liens, along with cancellation of lien requests to the proper creditors; however, in the event the creditor does not comply with our cancellation request we will not pursue the creditor without being further retained by the buyer or seller.
                                        </p>
                                        <p>
                                            <b>CANCELLATION OF DEEDS OF TRUST-</b>  Paragraph 8(e) of the OUR STATE Offer to Purchase and Contract, has places a legal duty on the Seller to ensure that all prior deeds of trust are canceled of record. The OUR STATE State Bar does not place the duty of cancellation on the Closing Attorney because the banks are required to cancel a Deed of Trust which is paid in full within 60 days of receiving payment in full. We will engage a third-party lien release company to guarantee your compliance with this duty at an additional fee collected on the settlement statement to the firm or our third party vendor. Please note, it is still your responsibility to release all liens and judgments from the public record. OUR LAW FIRM WILL NOT TAKE ANY ACTION BEYOND SENDING AN INITIAL LETTER OF REQUEST. A THIRD-PARTY VENDOR WILL CANCEL YOUR LIENS AT YOUR EXPENSE (APPROXIMATELY $35.00-$55.00 PER RELEASE).
                                        </p>
                                        <p>
                                            <b>FUNDS TO CLOSE-</b>  Incoming Closing Funds- Any and all funds to close must be in the form of a wire from your bank. Please be sure to include your TITLE COMPANY File Number or Name, the property address as a reference. Our trust account is set up to not accept ACH, Book Transfers or any other form money transfer.  <b>  PLEASE NOTE TITLE COMPANY NAME WILL NOT ALTER ITS WIRING INSTRUCTIONS. IF YOU RECEIVE A MESSAGE FROM US THAT SAYS WE HAVE CHANGED OUR WIRING INSTRUCTIONS DO NOT SEND A WIRE AND CALL US IMMEDIATELY!</b>
                                        </p>
                                        <p>
                                            <b>OUTGOING PROCEEDS OR REFUNDS-</b>   Should you elect to receive money from TITLE COMPANY NAME, via wire transfer we will require you to sign our wiring agreement (which is part of the closing package) and to provide us your wiring instructions. <b>If you must change your wiring instructions, we will require you to present us with new wiring instructions in person; otherwise we will deliver the funds via UPS, other expedited courier, or USPS.</b>  If you elect to receive money from TITLE COMPANY NAME via check, you must cash or deposit the check within 90 days of the check date or the check becomes VOID.  TITLE COMPANY NAME will make every effort to contact you, confirm that you have received the check and if needed, stop payment, recut and mail a replacement check to you.  A reasonable dormancy fee shall be charged against any remaining funds in the client trust account which are unclaimed after the 90 days.  Said fee shall not exceed $200.00 per year.  The charge shall be based on time and effort spent making reasonable efforts to contact you and return the funds.  Any de minimis amount of funds of $10.00 or less that remain in our trust account for a period of 6 months or longer will not be refunded to you, but will be applied to the dormancy fee charge and made payable to TITLE COMPANY NAME. <b>We appreciate your extra effort to quickly cash or deposit checks made payable to you, regardless of the amount.  </b>
                                        </p>

                                        <p class="mb-0"><b class="text-underline">VERY IMPORTANT NOTICE!</b></p>

                                        <p><b>Proceeds will NOT be disbursed at the table. OUR STATE State Law mandates we must have the following to disburse funds:</b></p>
                                        
                                        <ul>
                                            <li>Good funds from the buyer and lender</li>
                                            <li>Funding authorization from the buyer’s lender</li>
                                            <li>Original signed documents in TITLE COMPANY Property office(s)</li>
                                            <li>Documents properly recorded within the Register of Deeds</li>
                                        </ul>

                                        <div class="form-group mb-2">
                                            <input type="checkbox" id="sign">
                                            <label for="sign">My/Our Signature(s) below <span>*</span></label>
                                        </div>

                                        <div class="border p-3">
                                            CERTIFIES OUR RECEIPT, ACKNOWLEDGMENT, AND CONSENT TO THE TERMS OF OUR
                                            REPRESENTATION BY TITLE COMPANY NAME
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
                                        Limited Release of Closing Information and Documentation
                                    </button>
                                </h2>
                                <div id="collapseEight" class="accordion-collapse collapse" aria-labelledby="headingEight" data-bs-parent="#accordionExample">
                                    <div class="accordion-body">
                                        Name(s): <br><br>

                                        Date: 04-14-2022<br><br>
                                        
                                        Property Address: 202 Nice New St, City, ST 11111<br><br>
                                        
                                        <p>
                                            I/We the undersigned seller in the transaction contemplated hereunder acknowledge that from time to time, it is necessary to share information concerning this transaction with other parties to this transaction. I acknowledge that some of the information to be shared, may be protected as Non-Public Personal Information as defined by federal law.<br><br>

                                            I authorize TITLE COMPANY NAME., as the settlement agent to provide to the following parties with a copy of the Closing Disclosure, Loan Estimate, Title Insurance Policy and any Settlement Statement which is prepared and/or executed during the course of this transaction:<br><br>

                                            Buyer, their real estate agent and lender, the Seller and their real estate agent, asset management companies, the title insurance company/underwriter who is insuring this transaction, the service providers retained by the Borrower and/ or Seller to provide settlement services necessary to complete this transaction including but not limited to surveyors, pest inspectors, property inspectors, insurance agents, Seller’s counsel/settlement agent in this; or a related transaction.<br><br>

                                            I further authorize TITLE COMPANY to allow its third-party auditors and my title insurance company to review my file for accuracy and security/compliance purposes during the annual security audit of the law firm. TITLE COMPANY., will employ all necessary safeguards during such an audit to ensure the integrity and security of sensitive attorney client, and client financial information pursuant to federal law and OUR STATE State Bar Rules of Professional Conduct.         
                                        </p>
                                        
                                        	
                                        <div class="form-group mb-2 d-flex">
                                            <input type="checkbox" id="agreementSign" class="me-2 mt-1">
                                            <label for="agreementSign" class="mb-2">By checking and signing below <span>*</span></label>
                                        </div>
                                        <div class="border p-3">
                                            we agree that a copy of this authorization may be accepted as an original.
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="headingNine">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseNine" aria-expanded="false" aria-controls="collapseNine">
                                        1099 Reporting
                                    </button>
                                </h2>
                                <div id="collapseNine" class="accordion-collapse collapse" aria-labelledby="headingNine" data-bs-parent="#accordionExample">
                                    <div class="accordion-body">
                                        
                                        <ul class="list-unstyled">
                                            <li>
                                                <div class="form-group mb-3">
                                                    <label class="mb-2"><b>(1) I owned and used the residence as my principal residence for periods aggregating 2 years or more during the 5-year period ending on the date of the sale or exchange of the residence.</b></label>
                                                    <ul class="list-inline">
                                                        <li class="list-inline item me-md-5">
                                                            <input type="radio" id="exchangeeResidenceTrue" name="exchangeeResidence">
                                                            <label for="exchangeeResidenceTrue">True</label>
                                                        </li>
                                                        <li class="list-inline item me-md-5">
                                                            <input type="radio" id="exchangeeResidenceFalse" name="exchangeeResidence">
                                                            <label for="exchangeeResidenceFalse">False</label>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </li>
                                            <li>
                                                <div class="form-group mb-3">
                                                    <label class="mb-2"><b>(2) I have not sold or exchanged another principle residence during the 2-year period ending on the date of the sale or exchange of the residence.</b></label>
                                                    <ul class="list-inline">
                                                        <li class="list-inline item me-md-5">
                                                            <input type="radio" id="NotexchangeeResidenceTrue" name="NotexchangeeResidence">
                                                            <label for="NotexchangeeResidenceTrue">True</label>
                                                        </li>
                                                        <li class="list-inline item me-md-5">
                                                            <input type="radio" id="NotexchangeeResidenceFalse" name="NotexchangeeResidence">
                                                            <label for="NotexchangeeResidenceFalse">False</label>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </li>
                                            <li>
                                                <div class="form-group mb-3">
                                                    <label class="mb-2"><b>(3) I (or my spouse or former or former spouse, if I was married at any time during the period beginning after May 6, 1997, and ending today) have not used any portion of the residence for business or rental purposes after May 6, 1997..</b></label>
                                                    <ul class="list-inline">
                                                        <li class="list-inline item me-md-5">
                                                            <input type="radio" id="formerSpouseTrue" name="formerSpouse">
                                                            <label for="formerSpouseTrue">True</label>
                                                        </li>
                                                        <li class="list-inline item me-md-5">
                                                            <input type="radio" id="formerSpouseFalse" name="formerSpouse">
                                                            <label for="formerSpouseFalse">False</label>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </li>
                                            <li>
                                                <div class="form-group mb-3">
                                                    <label class="mb-2">
                                                        <b>(4) At least one of the following three statements applies:<br><br>
                                                            The sale or exchange is of the entire residence for $250,000 or less.<br><br>
    
                                                            OR<br><br>
                                                            
                                                            I am married, the sale or exchange is of the entire residence for $500,000 or less, and the gain on the sale or exchange of the entire residence is $250,000 or less.<br><br>
                                                            
                                                            OR<br><br>
                                                            
                                                            I am married, the sale or exchange is of the entire residence for $500,000 or less, and (a) I intend to file a joint return for the year of the sale or exchange, (b) my spouse also used the residence as his or her principal residence for periods aggregating 2 years or more during the 5 year period ending on the date of the sale or exchange of the residence, and (c) my spouse also has not sold or exchanged another principal residence during the 2-year period ending on the date of the sale or exchange of the principal residence.<br><br></b>
                                                    </label>
                                                    <ul class="list-inline">
                                                        <li class="list-inline item me-md-5">
                                                            <input type="radio" id="marriedTrue" name="married">
                                                            <label for="marriedTrue">True</label>
                                                        </li>
                                                        <li class="list-inline item me-md-5">
                                                            <input type="radio" id="marriedFalse" name="married">
                                                            <label for="marriedFalse">False</label>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </li>
                                            <li>
                                                <div class="form-group mb-3">
                                                    <label class="mb-2"><b>(5) During the 5-year period ending on the date of the sale or exchange of the residence, I did not acquire the residence in an exchange to which section 1031 of the Internal Revenue Code applied.</b></label>
                                                    <ul class="list-inline">
                                                        <li class="list-inline item me-md-5">
                                                            <input type="radio" id="periodTrue" name="period">
                                                            <label for="periodTrue">True</label>
                                                        </li>
                                                        <li class="list-inline item me-md-5">
                                                            <input type="radio" id="periodFalse" name="period">
                                                            <label for="periodFalse">False</label>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </li>
                                            <li>
                                                <div class="form-group mb-3">
                                                    <label class="mb-2"><b>(6) If my basis in the residence is determined by reference to the basis in the hands of a person who acquired the residence in an exchange to which section 1031 of the Internal Revenue Code applied, the exchange to which section 1031 applied occurred more than 5 years prior to the date I sold or exchanged the residence.</b></label>
                                                    <ul class="list-inline">
                                                        <li class="list-inline item me-md-5">
                                                            <input type="radio" id="RevenueTrue" name="Revenue">
                                                            <label for="RevenueTrue">True</label>
                                                        </li>
                                                        <li class="list-inline item me-md-5">
                                                            <input type="radio" id="RevenueFalse" name="Revenue">
                                                            <label for="RevenueFalse">False</label>
                                                        </li>
                                                        <li class="list-inline item me-md-5">
                                                            <input type="radio" id="RevenueNA" name="Revenue">
                                                            <label for="RevenueNA">N/A</label>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="headingTen">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTen" aria-expanded="false" aria-controls="collapseTen">
                                        Seller Closing Day
                                    </button>
                                </h2>
                                <div id="collapseTen" class="accordion-collapse collapse" aria-labelledby="headingTen" data-bs-parent="#accordionExample">
                                    <div class="accordion-body">
                                       <p class="mb-4">Please have the following information and tangible items ready for the day of closing.</p>

                                       <ul>
                                           <li>
                                               <b>Non-Expired Photo Identification</b>
                                               <ul>
                                                   <li>
                                                        Please make sure you have a valid form of photo identification whether it is a driver’s license, passport or government issued identification. If any form of Identification that you choose is expired, you will not be able to sign your closing documents and it will result in a delay in closing. Additionally, we can not accept temporary drivers licenses.
                                                   </li>
                                               </ul>
                                            </li>
                                            <li>
                                                <b>
                                                    Wiring Instructions
                                                </b>
                                                <ul>
                                                    <li>
                                                        Please bring your wiring instructions (i.e. void check) or mailing address (cannot be a P.O. Box) for proceeds to closing.
                                                    </li>
                                                </ul>
                                            </li>
                                            <li>
                                                <b>
                                                    Spousal Attendance
                                                </b>
                                                <ul>
                                                    <li>
                                                        Spouse must attend closing, whether they are listed on the deed or not.
                                                    </li>
                                                </ul>
                                            </li>
                                            <li>
                                                <b>
                                                    Proceeds
                                                </b>
                                                <ul>
                                                    <li>
                                                        Proceeds will <b>NOT</b> be disbursed at the table.
                                                    </li>
                                                </ul>
                                            </li>
                                       </ul>

                                       <img src="<?php echo base_url();?>assets/frontend/images/buyer-seller-package/sold.jpg" class="img-fluid d-block mx-auto my-5" alt="">
 


                                       <div class="form-group mb-2 d-flex">
                                            <input type="checkbox" id="readAgree" class="me-2 mt-1">
                                            <label for="readAgree" class="mb-2">I/We have read and agree to <span>*</span></label>
                                        </div>
                                        <div class="border p-3">
                                            the above requirements for Closing Day.
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>

                        <p class="my-4">
                            Signing below indicates that the information included here is correct and complete to the best of my knowledge and ackowledges and accepts the information included in this documen
                        </p>
                        <h4 class="text-danger text-center mb-5">
                            You must click SUBMIT below to securely send your completed forms to TITLE COMPANY NAME.
                        </h4>
                        <div class="text-center"><button type="submit" class="btn btn-primary">Submit</button></div>
                    </form>
                </div>
            </div>
        </div>
    </section>

    <script src="<?php echo base_url();?>assets/frontend/js/order/jquery.min.js"></script>
    <script src="<?php echo base_url();?>assets/frontend/js/order/bootstrap.bundle.min.js"></script>
    <script src="<?php echo base_url();?>assets/frontend/js/order/script.js"></script>
</body>
</html>