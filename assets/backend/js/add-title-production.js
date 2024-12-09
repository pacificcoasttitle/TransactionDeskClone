$(document).ready(function () {
    if (jQuery('#frm-add-title-production').length) {
        jQuery('#frm-add-title-production').validate({
            ignore: ":not(:visible)",
            rules: {
                first_name: "required",
                last_name: "required",
                email_address: "required",
                telephone: "required"
            },
            messages: {
                first_name: "Please Enter First Name",
                last_name: "Please Enter Last Name",
                telephone: "Please Telephone Address",
                email_address: "Please Enter Email address",
            },
            submitHandler: function (form) {
                form.submit();
            }
        });
    }

    if (jQuery('#frm-edit-title-production').length) {
        jQuery('#frm-edit-title-production').validate({
            ignore: ":not(:visible)",
            rules: {
                first_name: "required",
                last_name: "required",
                email_address: "required",
                telephone: "required"
            },
            messages: {
                first_name: "Please Enter First Name",
                last_name: "Please Enter Last Name",
                telephone: "Please Telephone Address",
                email_address: "Please Enter Email address",
            },
            submitHandler: function (form) {
                form.submit();
            }
        });
    }
});