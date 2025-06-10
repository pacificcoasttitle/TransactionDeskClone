jQuery(document).ready(function ($) {

    if ($('#clone-email-address').length) {
        $('#clone-email-address').cloneya({
            maximum: 5
        }).on('after_append.cloneya', function (event, toclone, newclone) {
            var name = $(newclone).find("input[type='email']").attr('id');
        }).off('remove.cloneya').on('remove.cloneya', function (event, clone) {
            $(clone).slideToggle('slow', function () {
                $(clone).remove();
            })
        });
    }
});

function addOrUpdateDeliverables(partner_id) {
    $('#page-preloader').css('background-color', 'rgba(0,0,0,.5)');
    $('#page-preloader').css('display', 'block');
    $('#deliverables_information').modal('show');
    $('#partner_id').val(partner_id);
    $.ajax({
        url: base_url + "admin/order/home/getDeliverables",
        type: "POST",
        data: {
            partner_id: partner_id,
        },
        async: false,
        success: function (result) {
            $('#page-preloader').css('display', 'none');
            $('#borrower_page').css('opacity', '1');
            var res = jQuery.parseJSON(result);
            if (res.deliverables.length > 0) {
                for (i = 0; i < res.deliverables.length; i++) {
                    if (i == 0) {
                        $('#AdditionalEmail').val(res.deliverables[i]);
                    } else {
                        $("#clonea")[0].click();
                    }
                }
                for (i = 0; i < res.deliverables.length; i++) {
                    if (i != 0) {
                        var emailVal = res.deliverables[i];
                        $('#AdditionalEmail' + i).val(emailVal);
                    }
                }
            }
        },
        error: function () {

        },
    });
}

function deleteCompany(partner_id) {
    let confirm_msg = confirm('Are you sure to want to delete this record?');
    if (confirm_msg) {
        $('#page-preloader').css('background-color', 'rgba(0,0,0,.5)');
        $('#page-preloader').css('display', 'block');

        $.ajax({
            url: base_url + "order/admin/delete-company",
            type: "POST",
            data: {
                partner_id: partner_id,
            },
            async: false,
            success: function (result) {
                $('#page-preloader').css('display', 'none');
                $('#borrower_page').css('opacity', '1');
                var res = jQuery.parseJSON(result);
                console.log('res ===', res);
                if (res.status === 'success') {
                    location.reload();
                }
            },
            error: function () {

            },
        });
    }

}

function addOrUpdateSPCompanyDeliverables(lookup_code) {
    console.log('lookup_code ===', lookup_code);
    $('#page-preloader').css('background-color', 'rgba(0,0,0,.5)');
    $('#page-preloader').css('display', 'block');
    $('#deliverables_information').modal('show');
    $('#lookup_code').val(lookup_code);
    $.ajax({
        url: base_url + "admin/order/home/getspDeliverables",
        type: "POST",
        data: {
            lookup_code: lookup_code,
        },
        async: false,
        success: function (result) {
            $('#page-preloader').css('display', 'none');
            $('#borrower_page').css('opacity', '1');
            var res = jQuery.parseJSON(result);
            if (res.deliverables.length > 0) {
                for (i = 0; i < res.deliverables.length; i++) {
                    if (i == 0) {
                        $('#AdditionalEmail').val(res.deliverables[i]);
                    } else {
                        $("#clonea")[0].click();
                    }
                }
                for (i = 0; i < res.deliverables.length; i++) {
                    if (i != 0) {
                        var emailVal = res.deliverables[i];
                        $('#AdditionalEmail' + i).val(emailVal);
                    }
                }
            }
        },
        error: function () {

        },
    });
}

function deleteSPCompany(lookup_code) {
    let confirm_msg = confirm('Are you sure to want to delete this record?');
    if (confirm_msg) {
        $('#page-preloader').css('background-color', 'rgba(0,0,0,.5)');
        $('#page-preloader').css('display', 'block');

        $.ajax({
            url: base_url + "order/admin/delete-company",
            type: "POST",
            data: {
                lookup_code: lookup_code,
            },
            async: false,
            success: function (result) {
                $('#page-preloader').css('display', 'none');
                $('#borrower_page').css('opacity', '1');
                var res = jQuery.parseJSON(result);
                if (res.status === 'success') {
                    console.log('res ===', res);
                    // location.reload();
                    $('#companies_success_msg').text(res.message).show();
                    companies_list.ajax.reload(null, false);
                }
            },
            error: function () {

            },
        });
    }

}

$('#edit-company #name, #edit-company #address1, #add-company #name, #add-company #address1').on('focusout', function (e) {
    let company_name = '';
    let address1 = '';
    if ($('#edit-company').length) {
        company_name = $('#edit-company #name').val();
        address1 = $('#edit-company #address1').val();
    }

    if ($('#add-company').length) {
        company_name = $('#add-company #name').val();
        address1 = $('#add-company #address1').val();
    }

    console.log('company_name ==', company_name);
    console.log('address1 ==', address1);
    if (company_name && address1) {
        $.ajax({
            url: base_url + "order/admin/generate-company-lookupcode",
            data: {
                company_name: company_name,
                address1: address1
            },
            type: "POST",
            dataType: "json",
            success: function (data) {
                console.log(data);
                if ($('#edit-company').length) {
                    $("#edit-company #new_lookup_code").val(data.code);
                    $("#edit-company #new_lookup_code").prop("disabled", false);
                }

                if ($('#add-company').length) {
                    $("#add-company #lookup_code").val(data.code);
                    $("#add-company #lookup_code").prop("disabled", false);
                }
            }
        });
    }
});