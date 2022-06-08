$(document).on('change','input[type="radio"]',function(){
    var $this = $(this);
    var selectedvalue = $this.val();

    if ($this.attr('id') == 'coSellerYes') {
        $('#co_seller_first_name').prop('required',true);
        $('#co_seller_middle_name').prop('required',true);
        $('#co_seller_last_name').prop('required',true);
        $('#co_seller_expiration_date').prop('required',true);
        $('input:radio[name=coSellermaritalStatus]').prop('required',true);
        $('#co_seller_ssn').prop('required',true);
        $('#co_seller_email').prop('required',true);
        $('#co_seller_phone_number').prop('required',true);
        $('input:radio[name=co_seller_phone_number_type]').prop('required',true);
        $('input:radio[name=co_seller_foreign_resident]').prop('required',true);
    } else if($this.attr('id') == 'coSellerNo') {
        $('#co_seller_first_name').prop('required',false);
        $('#co_seller_middle_name').prop('required',false);
        $('#co_seller_last_name').prop('required',false);
        $('#co_seller_expiration_date').prop('required',false);
        $('input:radio[name=coSellermaritalStatus]').prop('required',false);
        $('#co_seller_ssn').prop('required',false);
        $('#co_seller_email').prop('required',false);
        $('#co_seller_phone_number').prop('required',false);
        $('input:radio[name=co_seller_phone_number_type]').prop('required',false);
        $('input:radio[name=co_seller_foreign_resident]').prop('required',false);
    }

    if ($this.attr('id') == 'noCorrectPropertyAddress') {
        $('#property_street_address').prop('required',true);
        $('#property_city').prop('required',true);
        $('#property_state').prop('required',true);
        $('#property_zip_code').prop('required',true);
    } else if($this.attr('id') == 'yesCorrectPropertyAddress') {
        $('#property_street_address').prop('required',false);
        $('#property_city').prop('required',false);
        $('#property_state').prop('required',false);
        $('#property_zip_code').prop('required',false);
    }

    if ($this.attr('id') == 'noCorrectPropertyAddressAsCurrentAddress') {
        $('#current_street_address').prop('required',true);
        $('#current_city').prop('required',true);
        $('#current_state').prop('required',true);
        $('#current_zip_code').prop('required',true);
    } else if($this.attr('id') == 'yesCorrectPropertyAddressAsCurrentAddress') {
        $('#current_street_address').prop('required',false);
        $('#current_city').prop('required',false);
        $('#current_state').prop('required',false);
        $('#current_zip_code').prop('required',false);
    }

    if ($this.attr('id') == 'yesForwarding') {
        $('#forwarding_street_address').prop('required',true);
        $('#forwarding_city').prop('required',true);
        $('#forwarding_state').prop('required',true);
        $('#forwarding_zip_code').prop('required',true);
    } else if($this.attr('id') == 'noForwarding') {
        $('#forwarding_street_address').prop('required',false);
        $('#forwarding_city').prop('required',false);
        $('#forwarding_state').prop('required',false);
        $('#forwarding_zip_code').prop('required',false);
    }

    if ($this.attr('id') == 'yesinsurance') {
        $('#insuranceFile').prop('required',true);
    } else if($this.attr('id') == 'noinsurance') {
        $('#insuranceFile').prop('required',false);
    }

    if ($this.attr('id') == 'yesmortgage') {
        $('input:radio[name=is_mortgage_credit]').prop('required',true);
        $('#mortgage_holder').prop('required',true);
        $('#loan_amount').prop('required',true);
        $('#mortgage_phone').prop('required',true);
        $('#loan_number').prop('required',true);
        $('#loan_balance').prop('required',true);
        $('#account_holder_name').prop('required',true);
        $('input:radio[name=is_second_mortgage]').prop('required',true);
    } else if($this.attr('id') == 'nomortgage') {
        $('input:radio[name=is_mortgage_credit]').prop('required',false);
        $('#mortgage_holder').prop('required',false);
        $('#loan_amount').prop('required',false);
        $('#mortgage_phone').prop('required',false);
        $('#loan_number').prop('required',false);
        $('#loan_balance').prop('required',false);
        $('#account_holder_name').prop('required',false);
        $('input:radio[name=is_second_mortgage]').prop('required',false);
    }

    if ($this.attr('id') == 'yesRealEstate') {
        $('#agent_first_name').prop('required',true);
        $('#agent_middle_name').prop('required',true);
        $('#agent_last_name').prop('required',true);
        $('#agent_company').prop('required',true);
        $('#agent_company_address').prop('required',true);
        $('#agent_company_city').prop('required',true);
        $('#agent_company_state').prop('required',true);
        $('#agent_company_zip_code').prop('required',true);
        $('#amount_percent_commission').prop('required',true);
        $('#amount_deduction').prop('required',true);
        $('#agent_phone').prop('required',true);
        $('#agent_email').prop('required',true);
    } else if($this.attr('id') == 'noRealEstate') {
        $('#agent_first_name').prop('required',false);
        $('#agent_middle_name').prop('required',false);
        $('#agent_last_name').prop('required',false);
        $('#agent_company').prop('required',false);
        $('#agent_company_address').prop('required',false);
        $('#agent_company_city').prop('required',false);
        $('#agent_company_state').prop('required',false);
        $('#agent_company_zip_code').prop('required',false);
        $('#amount_percent_commission').prop('required',false);
        $('#amount_deduction').prop('required',false);
        $('#agent_phone').prop('required',false);
        $('#agent_email').prop('required',false);
    }

    if ($this.attr('id') == 'yesCreditCard') {
        $('input:radio[name=CreditCardLock]').prop('required',true);
    } else if($this.attr('id') == 'noCreditCard') {
        $('input:radio[name=CreditCardLock]').prop('required',false);
    }

    if ($this.attr('id') == 'yesmortgage2') {
        $('input:radio[name=is_second_mortgage_credit]').prop('required',true);
        $('#second_mortgage_holder').prop('required',true);
        $('#second_loan_amount').prop('required',true);
        $('#second_mortgage_phone').prop('required',true);
        $('#second_loan_number').prop('required',true);
        $('#second_loan_balance').prop('required',true);
        $('#second_account_holder_name').prop('required',true);
        
    } else if($this.attr('id') == 'nomortgage2') {
        $('input:radio[name=is_second_mortgage_credit]').prop('required',false);
        $('#second_mortgage_holder').prop('required',false);
        $('#second_loan_amount').prop('required',false);
        $('#second_mortgage_phone').prop('required',false);
        $('#second_loan_number').prop('required',false);
        $('#second_loan_balance').prop('required',false);
        $('#second_account_holder_name').prop('required',false);
    }

    if ($this.attr('id') == 'yesCreditCard2') {
        $('input:radio[name=is_second_creditcard_lock]').prop('required',true);
    } else if($this.attr('id') == 'noCreditCard2') {
        $('input:radio[name=is_second_creditcard_lock]').prop('required',false);
    }

    if ($this.attr('id') == 'otherAttorney') {
        $('#firm_name').prop('required',true);
        $('#firm_phone_number').prop('required',true);
        $('#attorney_name').prop('required',true);
        $('#attorney_phone_number').prop('required',true);
        $('#attorney_email').prop('required',true);
    } else if($this.attr('id') == 'attorney') {
        $('#firm_name').prop('required',false);
        $('#firm_phone_number').prop('required',false);
        $('#attorney_name').prop('required',false);
        $('#attorney_phone_number').prop('required',false);
        $('#attorney_email').prop('required',false);
    }

    if ($this.attr('id') == 'yesHOA') {
        $('#hoa_management_company_name').prop('required',true);
        $('#hoa_contact_person').prop('required',true);
        $('#hoa_email').prop('required',true);
        $('#hoa_phone').prop('required',true);
        $('#hoa_dues').prop('required',true);
        $('input:radio[name=hoa_dues_per]').prop('required',true);
        $('#hoa_notes').prop('required',true);
        $('input:radio[name=is_property_second_hoa]').prop('required',true);
    } else if($this.attr('id') == 'noHOA') {
        $('#hoa_management_company_name').prop('required',false);
        $('#hoa_contact_person').prop('required',false);
        $('#hoa_email').prop('required',false);
        $('#hoa_phone').prop('required',false);
        $('#hoa_dues').prop('required',false);
        $('input:radio[name=hoa_dues_per]').prop('required',false);
        $('#hoa_notes').prop('required',false);
        $('input:radio[name=is_property_second_hoa]').prop('required',false);
    }

    if ($this.attr('id') == 'yesHOA2') {
        $('#second_hoa_management_company_name').prop('required',true);
        $('#second_hoa_contact_person').prop('required',true);
        $('#second_hoa_email').prop('required',true);
        $('#second_hoa_phone').prop('required',true);
        $('#second_hoa_dues').prop('required',true);
        $('input:radio[name=second_hoa_dues_per]').prop('required',true);
        $('#second_hoa_notes').prop('required',true);
    } else if($this.attr('id') == 'noHOA2') {
        $('#second_hoa_management_company_name').prop('required',false);
        $('#second_hoa_contact_person').prop('required',false);
        $('#second_hoa_email').prop('required',false);
        $('#second_hoa_phone').prop('required',false);
        $('#second_hoa_dues').prop('required',false);
        $('input:radio[name=second_hoa_dues_per]').prop('required',false);
        $('#second_hoa_notes').prop('required',false);
    }

    if (selectedvalue == 'other') {
        $this.parents(".form-group").find('.otherAddress').removeClass('d-none')
    } else {
        $this.parents(".form-group").find('.otherAddress').addClass('d-none')
    }


    if(selectedvalue == 'other'){
        $this.parents(".form-group").find('.otherAddress').removeClass('d-none')
    }
    else{
        $this.parents(".form-group").find('.otherAddress').addClass('d-none')
    }

    if(selectedvalue == 'marriedToOther'){
        $this.parents('.col-md-4').siblings().find(".spouseName").removeClass("d-none")
    }else{
        $this.parents('.col-md-4').siblings().find(".spouseName").addClass("d-none")
    }
})

$("#borrower_seller_form").validate({
    ignore: false,
    errorClass: "error text-danger",
    validClass: "success text-success",
    highlight: function (element, errorClass) {
        //alert('em');
       // $(element).fadeOut(function () {
           // $(element).fadeIn();
        //});
    },
    rules: {
        name: "required",
        email: {
            required: true,
            email: true,
        },
    },
    submitHandler: function (form) {
         alert('Form Submitted');
    },
    invalidHandler: function(e,validator) {
        for (var i=0;i<validator.errorList.length;i++){   
            $(validator.errorList[i].element).closest('.accordion-collapse').addClass('show');
            return false;
        }
    },
    errorPlacement: function(error, element) {
        var placement = $(element).data('error');
        if (placement) {
          $(placement).append(error)
        } else {
          error.insertAfter(element);
        }
    }
});


$('input[name="maritalStatus"]').change(function(){
    if(selectedvalue == 'marriedOtherSeller' && $this.attr("id") == "marriedOtherSeller"){
        $this.parents('.col-md-4').siblings().find(".spouseName").removeClass("d-none")
    }else{
        $this.parents('.col-md-4').siblings().find(".spouseName").addClass("d-none")
    }
})

$('input[name="Seller"]').change(function(){
    var $this = $(this);
    var selectedvalue = $this.val();
    if(selectedvalue == 'individual'){
        $('.maritalStatus,.sellerFullName,.sellerCitizenship').removeClass('d-none')
    }
    else{
        $('.maritalStatus,.sellerFullName,.sellerCitizenship').addClass('d-none')
    }

    if(selectedvalue == 'trust'){
        $('.trustDetails').removeClass('d-none')
    }
    else{
        $('.trustDetails').addClass('d-none')
    }

    if(selectedvalue == 'corp'){
        $('.corpDetails').removeClass('d-none')
    }
    else{
        $('.corpDetails').addClass('d-none')
    }

    if(selectedvalue == 'trust' || selectedvalue == 'corp'){
        $('.individualDetails').addClass('d-none')
    }
    else{
        $('.individualDetails').removeClass('d-none')
    }    
})

$('input[name="Citizenship"]').change(function(){
    var $this = $(this);
    var selectedvalue = $this.val();
    if(selectedvalue == 'us'){
        $('.socialSecrity').removeClass('d-none')
    }
    else{
        $('.socialSecrity').addClass('d-none')
    }

    if(selectedvalue == 'Alien' || selectedvalue == 'Non-Resident'){
        $('.tax_identity').removeClass('d-none')
    }
    else{
        $('.tax_identity').addClass('d-none')
    }
})

$('#collapseTwo input[type="radio"]').change(function(){
    var $this = $(this);
    var selectedvalue = $this.val();
    if(selectedvalue == 'yes'){
        $this.parents("ul").siblings('.errorMsg').removeClass('d-none')
    }
    else{
        $this.parents("ul").siblings('.errorMsg').addClass('d-none')
    }
})

$('input[name="Mortgage"]').change(function(){
    var $this = $(this);
    var selectedvalue = $this.val();
    if(selectedvalue == 'yes'){
        $("#mortgage").removeClass("d-none")
    }
    else{
        $("#mortgage").addClass("d-none")
    }
})

$('input[name="Liens"]').change(function(){
    var $this = $(this);
    var selectedvalue = $this.val();
    if(selectedvalue == 'yes'){
        $("#lien").removeClass("d-none")
    }
    else{
        $("#lien").addClass("d-none")
    }
})

$('input[name="Condominium"]').change(function(){
    var $this = $(this);
    var selectedvalue = $this.val();
    if(selectedvalue == 'yes'){
        $("#association").removeClass("d-none")
    }
    else{
        $("#association").addClass("d-none")
    }
})



$('input[value="cpa"]').change(function(){
    var $this = $(this);
    if($this.is(":checked")){
        $('.cpaDetail').removeClass('d-none')
    }
    else{
        $('.cpaDetail').addClass('d-none')
    }
})


$(function() {
    $('#trustees').change(function() {
      var userNumber = $(this).val();
      if (userNumber < 2) {
        $("#trusteeFields").empty();
      } else {
        $("#trusteeFields").empty();
        create(userNumber);
      }
    });
    function create(userNumber) {
        for (var i = 2; i <= userNumber; i++) {
            $("#trusteeFields").append(`<div class="trustee`+ i +`"> <div class="row"> <div class="col-md-4"> <div class="form-group mb-4"> <label for="" class="mb-2"><b>Name of <span class="numberOfTrustee"> `+ i +`</span> Trustee</b></label> <input type="text" class="form-control" name="trusteename`+i+`"> </div></div></div><div class="row"> <div class="col-md-4"> <div class="form-group mb-4"> <label for="" class="mb-2"><b><span class="numberOfTrustee">`+  i +`</span> Trustee Marital Status<span>*</span></b></label> <ul class="list-unstyled"> <li> <input type="radio" id="trusteesingle`+i+`" value="trusteesingle" name="trusteeMaritalStatus`+i+`"> <label for="trusteesingle`+i+`">Single</label> </li><li> <input type="radio" id="marriedOtherTrustee`+i+`" value="marriedOtherTrustee" name="trusteeMaritalStatus`+i+`"> <label for="marriedOtherTrustee`+i+`">Married (To Other Trustee)</label> </li><li> <input type="radio" id="marriedToOther`+i+`" value="marriedToOther" name="trusteeMaritalStatus`+i+`"> <label for="marriedToOther`+i+`">Married (To Other)</label> </li></ul> </div></div><div class="col-md-4"> <div class="spouseName d-none"> <div class="form-group mb-4"> <label for="" class="mb-2"><b><span class="numberOfTrustee">`+i+`</span> Trustee's Spouse's Full Legal Name</b></label> <input type="text" class="form-control" name="spousename`+i+`"> </div></div></div></div><div class="row mb-4"> <div class="col-md-4"> <div class="form-group mb-4"> <label for="" class="mb-2"><b><span class="numberOfTrustee">`+  i +`</span> Trustee's Phone Number</b></label> <input type="text" class="form-control" name="trusteenumber`+i+`"> </div></div><div class="col-md-4"> <div class="form-group mb-4"> <label for="" class="mb-2"><b><span class="numberOfTrustee">`+  i +`</span> Trustee's Email Address</b></label> <input type="text" class="form-control" name="trusteeemail`+i+`"> </div></div></div><div class="row"> <div class="col-md-6"> <div class="form-group mb-4"> <label for="" class="mb-2"><b><span class="numberOfTrustee">`+  i +`</span>  Trustee's Social Security Number</b></label> <input type="text" class="form-control" name="socialnumber`+i+`"> </div></div></div></div>`)
        }
    }
  });

  
$('input[name="saleProceeds"]').change(function(){
    var $this = $(this);
    var selectedvalue = $this.val();
    if(selectedvalue == 'wire'){
        $('#wireInstructions').removeClass('d-none')
    }
    else{
        $('#wireInstructions').addClass('d-none')
    }

    if(selectedvalue == 'mailCheck'){
        $this.parents('.accordion-body').find('.mailAddress').removeClass('d-none')
    }
    else{
        $this.parents('.accordion-body').find('.mailAddress').addClass('d-none')
    }
})

$(".sellerName input").blur(function(){
    var $this = $(this);
    var inputText = $this.val();
    if(inputText.length > 0){
        $(".inputDirty").removeClass("d-none")
    }
    else{
        $(".inputDirty").addClass("d-none")
    }
})


$('input[name="Co-Seller"]').change(function(){
    var $this = $(this);
    var selectedvalue = $this.val();
    if(selectedvalue == 'yes'){
        $(".coSellerInfo").removeClass("d-none")
    }
    else{
        $(".coSellerInfo").addClass("d-none")
    }
})
$('input[name="insurance"]').change(function(){
    var $this = $(this);
    var selectedvalue = $this.val();
    if(selectedvalue == 'yes') {
        $(".insuranceFile").removeClass("d-none")
    } else {
        $(".insuranceFile").addClass("d-none")
    }
})
$('input[name="RealEstate"]').change(function(){
    var $this = $(this);
    var selectedvalue = $this.val();
    if(selectedvalue == 'yes'){
        $(".RealEstateInfo").removeClass("d-none")
    }
    else{
        $(".RealEstateInfo").addClass("d-none")
    }
})

$('input[name="payInvoice[]"]').change(function(){
    var $this = $(this);
    var selectedvalue = $this.val();
    console.log(selectedvalue);
    if ($this.is(":checked") && selectedvalue !== 'none') {
        $(".insuranceFile").removeClass("d-none")
    } else {
        $(".insuranceFile").addClass("d-none")
    }
})
$('input[name="CreditCard"],input[name="CreditCard2"]').change(function(){
    var $this = $(this);
    var selectedvalue = $this.val();
    if(selectedvalue == 'yes'){
        $this.parents('ul').siblings(".CreditCardLock").removeClass("d-none")
    }
    else{
        $this.parents('ul').siblings(".CreditCardLock").addClass("d-none")
    }
})

$('input[name="mortgage2"]').change(function(){
    var $this = $(this);
    var selectedvalue = $this.val();
    if(selectedvalue == 'yes'){
        $(".secondMortgage").removeClass("d-none")
    }
    else{
        $(".secondMortgage").addClass("d-none")
    }
})
$('input[name="HOA"]').change(function(){
    var $this = $(this);
    var selectedvalue = $this.val();
    if(selectedvalue == 'yes'){
        $(".homeOwner").removeClass("d-none")
    }
    else{
        $(".homeOwner").addClass("d-none")
    }
})

$('input[name="HOA"]').change(function(){
    var $this = $(this);
    var selectedvalue = $this.val();
    if(selectedvalue == 'yes'){
        $(".homeOwner").removeClass("d-none")
    }
    else{
        $(".homeOwner").addClass("d-none")
    }
})
$('input[name="HOA2"]').change(function(){
    var $this = $(this);
    var selectedvalue = $this.val();
    if(selectedvalue == 'yes'){
        $(".homeOwner2").removeClass("d-none")
    }
    else{
        $(".homeOwner2").addClass("d-none")
    }
})
$('input[name="attorney"]').change(function(){
    var $this = $(this);
    var selectedvalue = $this.val();
    if(selectedvalue == 'yes'){
        $(".attorneyInfo").removeClass("d-none")
    }
    else{
        $(".attorneyInfo").addClass("d-none")
    }
})
$('input[name="isMarried"]').change(function(){
    var $this = $(this);
    var selectedvalue = $this.val();
    if(selectedvalue == 'yes'){
        $(".spouseInfo").removeClass("d-none")
    }
    else{
        $(".spouseInfo").addClass("d-none")
    }
})
$('input[name="isMarried2"]').change(function(){
    var $this = $(this);
    var selectedvalue = $this.val();
    if(selectedvalue == 'yes'){
        $(".spouseInfo2").removeClass("d-none")
    }
    else{
        $(".spouseInfo2").addClass("d-none")
    }
})
$('input[name="isAttorney"]').change(function(){
    var $this = $(this);
    var selectedvalue = $this.val();
    if(selectedvalue == 'yes'){
        $(".attorneyInfo").removeClass("d-none")
    }
    else{
        $(".attorneyInfo").addClass("d-none")
    }

})
$('input[name="isAttorney2"]').change(function(){
    var $this = $(this);
    var selectedvalue = $this.val();
    if(selectedvalue == 'yes'){
        $(".attorneyInfo2").removeClass("d-none")
    }
    else{
        $(".attorneyInfo2").addClass("d-none")
    }
})

$('input[name="isbankruptcy"]').change(function(){
    var $this = $(this);
    var selectedvalue = $this.val();
    if(selectedvalue == 'yes'){
        $(".isbankruptInfo").removeClass("d-none")
    }
    else{
        $(".isbankruptInfo").addClass("d-none")
    }
})

$('input[name="isDismissed"]').change(function(){
    var $this = $(this);
    var selectedvalue = $this.val();
    if(selectedvalue == 'yes'){
        $(".dismissedWhen").removeClass("d-none")
    }
    else{
        $(".dismissedWhen").addClass("d-none")
    }
})

$('input[name="ispurchased"]').change(function(){
    var $this = $(this);
    var selectedvalue = $this.val();
    if(selectedvalue == 'yes'){
        $(".purchasedInfo").removeClass("d-none")
    }
    else{
        $(".purchasedInfo").addClass("d-none")
    }
})


$('.buyer2 input.lastName').blur(function(){
    if($(".buyer2 input").val() ) {
        $(".buyer2_sign").removeClass("d-none");
        
        var step3 = '<li class="nav-item step3"><button class="nav-link" data-bs-toggle="tab" data-bs-target="#step3" type="button" role="tab" aria-controls="step3" aria-selected="false">step3</button></li>';
    
        $(step3).insertAfter(".step2")
    }
    else{
        $(".buyer2_sign").addClass("d-none");     
        $(".step3").remove()
    }
});


// signature


// $(function () {
//     window.signaturePad1 = new SignaturePad($('#canvas1').get(0), {
//     });
    
//     window.signaturePad2 = new SignaturePad($('#canvas2').get(0), {
//     });
    
//     window.signaturePad3 = new SignaturePad($('#canvas3').get(0), {
//     });
    
//     window.signaturePad4 = new SignaturePad($('#canvas4').get(0), {
//     });
// })
  
// var clear1 = function () {
//     window.signaturePad1.clear()
// }  
// var clear2 = function () {
//     window.signaturePad2.clear()
// }
// var clear3 = function () {
//     window.signaturePad3.clear()
// }
// var clear4 = function () {
//     window.signaturePad4.clear()
// }



// function printContent(el) {
//     var restorepage = document.body.innerHTML; // save original page html to variable
//     var printcontent = document.querySelector(el).innerHTML; // save content to be printed to variable
//     document.body.innerHTML = printcontent; // display only content to be printed in document body
//     window.print(); // print commands
//     document.body.innerHTML = restorepage; // restore original page content
//   }
  
//   document.querySelector('.print').addEventListener('click', function() { // bind event to print button
    
//     $(".tab-pane").show()
//    setTimeout(function(){
//     $(".tab-pane:not(.active)").hide()
//    },2000)
//     printContent('.wizard'); // initial print function on selector for content to be printed

//   });
