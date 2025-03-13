jQuery(document).ready(function ($) {
    $("#company").autocomplete({
        source: function (request, response) {
            $.ajax({
                url: base_url + "admin/order/home/get_company_list",
                data: {
                    term: request.term
                },
                type: "POST",
                dataType: "json",
                success: function (data) {
                    if (data.length > 0) {
                        response($.map(data, function (item) {
                            return item;
                        }))
                    } else {
                        response([{ label: 'No results found.', val: -1 }]);
                    }
                }
            });
        },
        delay: 0,
        minLength: 3,
        select: function (event, ui) {
            event.preventDefault();
            $("#company").val(ui.item.partner_name);
            $("#partner_id").val(ui.item.partner_id);
            $("#address").val(ui.item.address1);
            $("#city").val(ui.item.city);
            $("#state").val(ui.item.state);
            $("#zipcode").val(ui.item.zip);
        },
        change: function (event, ui) {
            if (ui.item == null) {
                $("#company").parent().removeClass('state-success').addClass('state-error');
            }
        }
    });

    $("#title_company").autocomplete({
        source: function (request, response) {
            $.ajax({
                url: base_url + "admin/order/home/get_title_company_list",
                data: {
                    term: request.term
                },
                type: "POST",
                dataType: "json",
                success: function (data) {
                    if (data.length > 0) {
                        response($.map(data, function (item) {
                            return item;
                        }))
                    } else {
                        response([{ label: 'No results found.', val: -1 }]);
                    }
                }
            });
        },
        delay: 0,
        minLength: 2,
        select: function (event, ui) {
            event.preventDefault();
            $("#title_company").val(ui.item.partner_name);
            $("#title_partner_id").val(ui.item.partner_id);
        },
        change: function (event, ui) {
            if (ui.item == null) {
                $("#title_company").parent().removeClass('state-success').addClass('state-error');
            }
        }
    });

    if ($('#add-new-user #company_name').length) {
        console.log('testt --');
        $("#add-new-user #company_name").autocomplete({
            source: function (request, response) {
                $.ajax({
                    url: base_url + "admin/order/home/get_sp_company_list",
                    data: {
                        term: request.term,
                        is_master_search: 1
                    },
                    type: "POST",
                    dataType: "json",
                    success: function (data) {
                        console.log('data ===', data);
                        if (data.length > 0) {
                            response($.map(data, function (item) {
                                return item;
                            }))
                        } else {
                            response([{ label: 'No results found.', val: -1 }]);
                        }
                    }
                });
            },
            delay: 0,
            minLength: 3,
            select: function (event, ui) {
                event.preventDefault();
                $("#add-new-user #company_name").val(ui.item.name);
                $("#add-new-user #flookup_code").val(ui.item.flookup_code).parent().addClass('state-success');
                // $("#Opentelephone").val(ui.item.telephone_no).parent().addClass('state-success');
                // $("#OpenName").val(ui.item.fname).parent().addClass('state-success');
                // $("#OpenLastName").val(ui.item.lname).parent().addClass('state-success');
                $("#address").val(ui.item.address).parent().addClass('state-success');
                $("#city").val(ui.item.city).parent().addClass('state-success');
                $("#state").val(ui.item.state).parent().addClass('state-success');
                $("#zipcode").val(ui.item.zipcode).parent().addClass('state-success');
                // $("#ClientLookupCode").val(ui.item.lookup_code).parent().addClass('state-success');
                // $("#CompanyLookupCode").val(ui.item.flookup_code).parent().addClass('state-success');
                // $("#ClientType").val(ui.item.client_type).parent().addClass('state-success');
                // $("#CustomerId").val(ui.item.id);
                // if (ui.item.sales_rep_id) {
                //     $("#SalesRep").val(ui.item.sales_rep_id)
                // }

                // if (ui.item.title_officer_id) {
                //     $("#TitleOfficer").val(ui.item.title_officer_id)
                // }


                var is_escrow = ui.item.is_escrow_company;
                var is_lender = ui.item.is_lender;
                var is_mortgage_broker = ui.item.is_mortgage_broker;
                var is_selling_agent = ui.item.is_selling_agent;

                if (is_escrow) {
                    $("#add-new-user #user_type").val("escrow");
                } else if (is_lender) {
                    $("#add-new-user #user_type").val("lender");
                } else if (is_mortgage_broker) {
                    $("#add-new-user #user_type").val("mortgage_broker");
                } else if (is_selling_agent) {
                    $("#add-new-user #user_type").val("realtor");
                }

            },
            change: function (event, ui) {
                if (ui.item == null) {
                    $("#CompanyName").parent().removeClass('state-success').addClass('state-error');
                    $("#OpenEmail").val('').parent().removeClass('state-success').addClass('state-error');
                    $("#Opentelephone").val('').parent().removeClass('state-success').addClass('state-error');
                    $("#OpenName").val('').parent().removeClass('state-success').addClass('state-error');
                    $("#OpenLastName").val('').parent().removeClass('state-success').addClass('state-error');
                    $("#StreetAddress").val('').parent().removeClass('state-success').addClass('state-error');
                    $("#City").val('').parent().removeClass('state-success').addClass('state-error');
                    $("#Zipcode").val('').parent().removeClass('state-success').addClass('state-error');
                    $("#CustomerId").val('');
                }
            }
        });
    }


});

$("#add-new-user #lookup_code").prop("disabled", false);
if (!$('#add-new-user #company_name').val() || !$('#add-new-user #first_name').val() || !$('#add-new-user #last_name').val()) {
    $("#add-new-user #lookup_code").prop("disabled", true);
}

$('#add-new-user #company_name, #add-new-user #first_name, #add-new-user #last_name').on('focusout', function (e) {
    let company_name = $('#add-new-user #company_name').val();
    let first_name = $('#add-new-user #first_name').val();
    let last_name = $('#add-new-user #last_name').val();

    if (company_name && first_name && last_name) {
        $.ajax({
            url: base_url + "order/admin/generate-lookupcode",
            data: {
                company_name: company_name,
                first_name: first_name,
                last_name: last_name
            },
            type: "POST",
            dataType: "json",
            success: function (data) {
                console.log(data);
                $("#add-new-user #lookup_code").val(data.code);
                $("#add-new-user #lookup_code").prop("disabled", false);
            }
        });
    }

});