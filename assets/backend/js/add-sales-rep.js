$(document).ready(function () {
    if(jQuery('#frm-add-sales-rep').length)
    {
       jQuery('#frm-add-sales-rep').validate({
            ignore:"",
            rules: {
                sales_rep_first_name:"required",
                sales_rep_last_name:"required",
                email_address:"required",
                telephone:"required",
                partner_id:"required",
                partner_type_id:"required",
                sales_rep_no_of_open_orders:"required",
                sales_rep_no_of_close_orders:"required",
                sales_rep_premium:"required",
            },
            messages: {
                sales_rep_first_name:"Please Enter First Name",
                sales_rep_last_name:"Please Enter Last Name",
                email_address:"Please Enter Email address",
                telephone:"Please Enter Phone Number",
                partner_id:"Please Enter Partner Id",
                partner_type_id:"Please Enter Partner Type Id",
            },
            invalidHandler: function(event, validator) {
                if (validator.numberOfInvalids() > 0) {
                    validator.showErrors();
                    var collapse_class_id = $(":input.error").closest(".collapse").attr('id');
                    $('#'+collapse_class_id).collapse('show');
                }
            },
            submitHandler: function(form) {
                form.submit();  
            }
        }); 
    }
});