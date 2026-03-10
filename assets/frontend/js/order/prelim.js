function getContacts(fileNumber) {
    $('#page-preloader').css('background-color', 'rgba(0,0,0,.5)');
    $('#page-preloader').css('display', 'block');
    $.ajax({
        url: base_url + "get-contacts",
        type: "post",
        data: {
            fileNumber: fileNumber
        },
        dataType: "html",
        success: function (response) {

            var results = JSON.parse(response);

            var table_data = '';
            if (results.status == 'success') {
                if (!jQuery.isEmptyObject(results.contacts)) {
                    $.each(results.contacts, function (key, value) {
                        console.log('key ==', key);
                        console.log('value ==', value);
                        let type = '';
                        if (key == 'escrow') {
                            type = 'Escrow';
                        } else if (key == 'lender') {
                            type = 'Lender';
                        } else if (key == 'listing_agent') {
                            type = 'Listing Agent';
                        } else if (key == 'title_officer') {
                            type = 'Title Company';
                        } else if (key == 'underwritter') {
                            type = 'Underwriter';
                        }
                        if (key == 'escrow' || key == 'lender' || key == 'listing_agent') {
                            table_data += '<tr><td>' + type + '</td><td>' + value.company_name + '</td><td>' + value.name + '</td><td>' + value.email_address + '</td></tr>';
                        } else if (key == 'title_officer' || key == 'underwritter') {
                            table_data += '<tr><td>' + type + '</td><td>' + value.company_name + '</td><td></td><td></td></tr>';
                        }
                    });
                }
                else {
                    table_data += '<tr><td colspan="4" style="text-align: center;">No records found.</td></tr>';
                }
                $('#tbl-contacts-data tbody').html(table_data);
                $('#contactsModal').modal('show');
            }
            else if (results.status == 'error') {
                alert(results.msg);
            }
            $('#page-preloader').css('display', 'none');
        }
    });
}
function getInvoice(orderId) {
    $('#page-preloader').css('background-color', 'rgba(0,0,0,.5)');
    $('#page-preloader').css('display', 'block');
    const newTab = window.open('', '_blank');
    newTab.document.write(`
        <html>
            <head><title>Loading PDF...</title></head>
            <body style="font-family: sans-serif; text-align: center; padding-top: 50px;">
                <h2>Please wait...</h2>
                <p>Your invoice is being prepared.</p>
            </body>
        </html>
    `);
    newTab.document.close(); // Important!
    $.ajax({
        url: base_url + "get-fees-invoice",
        type: "post",
        data: {
            orderId: orderId
        },
        dataType: "html",
        success: function (response) {
            $('#page-preloader').css('display', 'none');
            var results = JSON.parse(response);
            var table_data = '';
            console.log('results ==', results.pdf_url);
            if (results.status == 'success') {
                // const newTab = window.open('', '_blank');
                newTab.location.href = results.pdf_url;
                console.log('results ==', results.pdf_url);
            }
            else if (results.status == 'error') {
                newTab.close();
                alert(results.msg);
            }
        },
        error: function () {
            $('#page-preloader').css('display', 'none');
            newTab.close();
            alert("Error while fetching the invoice.");
        }
    });
}
function getPrelimSummary(fileNumber) {
    $('#page-preloader').css('background-color', 'rgba(0,0,0,.5)');
    $('#page-preloader').css('display', 'block');
    $.ajax({
        url: base_url + "get-prelim-summary",
        type: "post",
        data: {
            fileNumber: fileNumber
        },
        dataType: "json",
        success: function (results) {
            $('#page-preloader').css('display', 'none');
            // var results = JSON.parse(response);
            if (results.status == 'error') {
                alert(results.message);
                return;
            }
            $('#prelim_property').text(results.address);
            $('#prelim_file_number').text(results.file_number);
            $('.prelim_summary').html(results.summary_view);
            $('#aiPrelimSummary').modal('show');
        },
        error: function () {
            $('#page-preloader').css('display', 'none');
            alert("Error while fetching the preliminary summary.");
        }
    });
}

function regeneratePrelimSummary(fileNumber) {
    $('#page-preloader').css('background-color', 'rgba(0,0,0,.5)');
    $('#page-preloader').css('display', 'block');
    $.ajax({
        url: base_url + "regenerate-prelim-summary",
        type: "post",
        data: {
            fileNumber: fileNumber
        },
        dataType: "json",
        success: function (results) {

            // var results = JSON.parse(response);
            $('#prelim_property').text(results.address);
            $('#prelim_file_number').text(results.file_number);
            $('.prelim_summary').html(results.summary_view);
            $('#aiPrelimSummary').modal('show');
            $('#page-preloader').css('display', 'none');
        }
    });
}

function fetchPrelimDocument(fileNumber = '') {
    $("#page-preloader").show();
    let queryParams = '';
    let url = '';
    if (fileNumber != '') {
        queryParams = `orderNumber=${fileNumber}`;
        url = base_url + "fetch-single-prelim-report?" + queryParams;
    } else {
        url = base_url + "fetch-bulk-prelim-report";
    }
    $.ajax({
        url: url,
        method: "POST",
        success: function (data) {
            var result = jQuery.parseJSON(data);
            console.log(result);
            if (result.status == 'success') {
                console.log('status code: ' + result.status);
                $('body').animate({ opacity: 1.0 }, "slow");
                let msg = result.message;
                $('#order_listing_success_msg').html(msg).show();
                $([document.documentElement, document.body]).animate({
                    scrollTop: $("#order_listing_success_msg").offset().top
                }, 1000);
                prelim_list.ajax.reload(null, false);
                setTimeout(function () {
                    $('#order_listing_success_msg').html('').hide();
                }, 4000);
            } else {
                $('#order_listing_error_msg').html("Error while syncing sales reps").show();
                $([document.documentElement, document.body]).animate({
                    scrollTop: $("#order_listing_error_msg").offset().top
                }, 1000);

                setTimeout(function () {
                    $('#order_listing_error_msg').html('').hide();
                }, 10000);
            }
            $("#page-preloader").hide();
        },
        error: function (XMLHttpRequest, textStatus, errorThrown) {
            $('#order_listing_error_msg').html('Something went wrong. Please try it again.').show();
            $([document.documentElement, document.body]).animate({
                scrollTop: $("#order_listing_success_msg").offset().top
            }, 1000);

            setTimeout(function () {
                $('#order_listing_error_msg').html('').hide();
            }, 10000);
        }
    });
}

function updatePrelimAction(order_id) {
    $('#note_information').modal('hide');
    $('.modal-backdrop').remove();
    $('body').removeClass('modal-open');
    $('body').css('padding-right', '');

    $('#order_id').val(order_id);
    console.log('order_id =**=', order_id);
    console.log("Modal opened");
    // return;
    $('#note_information').modal('show');
    let action = base_url + "update-prelim-action/" + order_id;
    $('#prelim_add_note_form').attr('action', action);
}

function displayComment(comments) {
    if (comments.length > 0) {
        $("#commentList").html(comments);
        $("#commentModal").modal("show");
    }
}