(function($) {



    var form = $("#signup-form");
    form.validate({
        errorPlacement: function errorPlacement(error, element) {
            element.before(error);
        },
        rules: {
            email: {
                email: true
            }
        },
        onfocusout: function(element) {
            $(element).valid();
        },
    });
    form.children("div").steps({
        headerTag: "h3",
        bodyTag: "fieldset",
        transitionEffect: "fade",
        stepsOrientation: "vertical",
        titleTemplate: '<div class="title"><span class="step-number">#index#</span><span class="step-text">#title#</span></div>',
        labels: {
            previous: 'Previous',
            next: 'Next',
            finish: 'Finish',
            current: ''
        },
        onStepChanging: function(event, currentIndex, newIndex) {
            if (currentIndex === 0) {
                form.parent().parent().parent().append('<div class="footer footer-' + currentIndex + '"></div>');
            }
            if (currentIndex === 1) {
                form.parent().parent().parent().find('.footer').removeClass('footer-0').addClass('footer-' + currentIndex + '');
            }
            if (currentIndex === 2) {
                form.parent().parent().parent().find('.footer').removeClass('footer-1').addClass('footer-' + currentIndex + '');
            }
            if (currentIndex === 3) {
                form.parent().parent().parent().find('.footer').removeClass('footer-2').addClass('footer-' + currentIndex + '');
            }
            // if(currentIndex === 4) {
            //     form.parent().parent().parent().append('<div class="footer" style="height:752px;"></div>');
            // }
            form.validate().settings.ignore = ":disabled,:hidden";
            return form.valid();
        },
        onFinishing: function(event, currentIndex) {
            form.validate().settings.ignore = ":disabled";
            return form.valid();
        },
        onFinished: function(event, currentIndex) {
            $("#signup-form").submit();
        },
        onStepChanged: function(event, currentIndex, priorIndex) {

            return true;
        }
    });

    jQuery.extend(jQuery.validator.messages, {
        required: "",
        remote: "",
        email: "",
        url: "",
        date: "",
        dateISO: "",
        number: "",
        digits: "",
        creditcard: "",
        equalTo: ""
    });

    $.dobPicker({
        daySelector: '#birth_date',
        monthSelector: '#birth_month',
        yearSelector: '#birth_year',
        dayDefault: '',
        monthDefault: '',
        yearDefault: '',
        minimumAge: 0,
        maximumAge: 120
    });
    $.dobPicker({
        daySelector: '#second_birth_date',
        monthSelector: '#second_birth_month',
        yearSelector: '#second_birth_year',
        dayDefault: '',
        monthDefault: '',
        yearDefault: '',
        minimumAge: 0,
        maximumAge: 120
    });
    var marginSlider = document.getElementById('slider-margin');
    if (marginSlider != undefined) {
        noUiSlider.create(marginSlider, {
              start: [1100],
              step: 100,
              connect: [true, false],
              tooltips: [true],
              range: {
                  'min': 100,
                  'max': 2000
              },
              pips: {
                    mode: 'values',
                    values: [100, 2000],
                    density: 4
                    },
                format: wNumb({
                    decimals: 0,
                    thousand: '',
                    prefix: '$ ',
                })
        });
        var marginMin = document.getElementById('value-lower'),
	    marginMax = document.getElementById('value-upper');

        marginSlider.noUiSlider.on('update', function ( values, handle ) {
            if ( handle ) {
                marginMax.innerHTML = values[handle];
            } else {
                marginMin.innerHTML = values[handle];
            }
        });
    }

    $('#is_another_seller').change(function(){
        var $this = $(this);
        var selectedvalue = $this.val();
        if(selectedvalue == 'Yes'){
            $("#second_seller").removeClass("d-none");
            $('#second_first_name').prop('required',true);
            $('#second_last_name').prop('required',true);
            $('#second_email').prop('required',true);
            $('#second_phone').prop('required',true);
            $('#second_birth_month').prop('required',true);
            $('#second_birth_date').prop('required',true);
            $('#second_birth_year').prop('required',true);
            $('#second_ssn1').prop('required',true);
            $('#second_ssn2').prop('required',true);
            $('#second_ssn3').prop('required',true);
            $('#second_current_mailing_address').prop('required',true);
            $('#second_mailing_address_port_closing').prop('required',true);
        } else {
            $("#second_seller").addClass("d-none");
            $('#second_first_name').prop('required',false);
            $('#second_last_name').prop('required',false);
            $('#second_email').prop('required',false);
            $('#second_phone').prop('required',false);
            $('#second_birth_month').prop('required',false);
            $('#second_birth_date').prop('required',false);
            $('#second_birth_year').prop('required',false);
            $('#second_ssn1').prop('required',false);
            $('#second_ssn2').prop('required',false);
            $('#second_ssn3').prop('required',false);
            $('#second_current_mailing_address').prop('required',false);
            $('#second_mailing_address_port_closing').prop('required',false);
        }
    });

    $('#is_trustee').change(function(){
        var $this = $(this);
        var selectedvalue = $this.val();
        if(selectedvalue == 'Yes'){
            $("#trustee_container").removeClass("d-none");
            $('#current_trustees').prop('required',true);
            $('#is_original_trustees').prop('required',true);
        } else {
            $("#trustee_container").addClass("d-none");
            $('#current_trustees').prop('required',false);
            $('#is_original_trustees').prop('required',false);
        }
    });

    $('#is_property_owned_free_clear').change(function(){
        var $this = $(this);
        var selectedvalue = $this.val();
        if(selectedvalue == 'No'){
            $("#property_owned_free_clear_no").removeClass("d-none");
            $('#lender_name').prop('required',true);
            $('#lender_address').prop('required',true);
            $('#loan_number').prop('required',true);
            $('#lender_phone_number').prop('required',true);
            $('#unpaid_balance').prop('required',true);
            $('#payment_due_date').prop('required',true);
            $('#loan_type').prop('required',true);
            $('#is_impound_account').prop('required',true);
            $('#tax_status').prop('required',true);
            $('#is_paid_impound').prop('required',true);
        } else {
            $("#property_owned_free_clear_no").addClass("d-none");
            $('#lender_name').prop('required',false);
            $('#lender_address').prop('required',false);
            $('#loan_number').prop('required',false);
            $('#lender_phone_number').prop('required',false);
            $('#unpaid_balance').prop('required',false);
            $('#payment_due_date').prop('required',false);
            $('#loan_type').prop('required',false);
            $('#is_impound_account').prop('required',false);
            $('#tax_status').prop('required',false);
            $('#is_paid_impound').prop('required',false);
        }
    });

    $('#is_another_loan').change(function(){
        var $this = $(this);
        var selectedvalue = $this.val();
        if(selectedvalue == 'Yes'){
            $("#another_loan_option").removeClass("d-none");
            $('#second_lender_name').prop('required',true);
            $('#second_lender_address').prop('required',true);
            $('#second_loan_number').prop('required',true);
            $('#second_lender_phone_number').prop('required',true);
            $('#second_unpaid_balance').prop('required',true);
            $('#second_payment_due_date').prop('required',true);
            $('#second_loan_type').prop('required',true);
            $('#second_is_impound_account').prop('required',true);
            $('#second_tax_status').prop('required',true);
            $('#second_is_paid_impound').prop('required',true);
        } else {
            $("#another_loan_option").addClass("d-none");
            $('#second_lender_name').prop('required',false);
            $('#second_lender_address').prop('required',false);
            $('#second_loan_number').prop('required',false);
            $('#second_lender_phone_number').prop('required',false);
            $('#second_unpaid_balance').prop('required',false);
            $('#second_payment_due_date').prop('required',false);
            $('#second_loan_type').prop('required',false);
            $('#second_is_impound_account').prop('required',false);
            $('#second_tax_status').prop('required',false);
            $('#second_is_paid_impound').prop('required',false);
        }
    });

    $('#is_private_water_company').change(function(){
        var $this = $(this);
        var selectedvalue = $this.val();
        if(selectedvalue == 'Yes'){
            $("#water_company_container").removeClass("d-none");
            $('#water_company').prop('required',true);
            $('#water_company_address').prop('required',true);
            $('#water_account_number').prop('required',true);
            $('#water_phone_number').prop('required',true);
        } else {
            $("#water_company_container").addClass("d-none");
            $('#water_company').prop('required',false);
            $('#water_company_address').prop('required',false);
            $('#water_account_number').prop('required',false);
            $('#water_phone_number').prop('required',false);
        }
    });

    $('#is_hoa').change(function(){
        var $this = $(this);
        var selectedvalue = $this.val();
        if(selectedvalue == 'Yes'){
            $("#hoa_container").removeClass("d-none");
            $('#hoa_company').prop('required',true);
            $('#hoa_company_address').prop('required',true);
            $('#hoa_contact_person').prop('required',true);
            $('#hoa_contact_number').prop('required',true);
        } else {
            $("#hoa_container").addClass("d-none");
            $('#hoa_company').prop('required',false);
            $('#hoa_company_address').prop('required',false);
            $('#hoa_contact_person').prop('required',false);
            $('#hoa_contact_number').prop('required',false);
        }
    });
   
})(jQuery);

