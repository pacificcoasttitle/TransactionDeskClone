function getInstrumentData(file_id) {
    $('body').animate({
        opacity: 0.5
    }, "slow");
    $.ajax({
        url: base_url + "order/admin/get-instrument-data",
        method: "POST",
        data: {
            file_id: file_id
        },
        success: function (data) {
            var result = jQuery.parseJSON(data);
            $('body').animate({
                    opacity: 1.0
            }, "slow");
            if (result.status == 'success') {
                $('#instrument_number_container').html(result.data);
                $('#instrument_model').modal('show');
            } else {
                $('#instrument_number_container').html(result.data);
                $('#instrument_model').modal('show');
            }
        },
        error: function (XMLHttpRequest, textStatus, errorThrown) {
            $('#lp_order_error_msg').html('Something went wrong. Please try it again.').show();
            $([document.documentElement, document.body]).animate({
                scrollTop: $("#lp_order_success_msg").offset().top
            }, 1000);

            setTimeout(function () {
                $('#lp_order_error_msg').html('').hide();
            }, 5000);
        }
    });
}

function regenerateReport(file_id) {
    $('body').animate({
        opacity: 0.5
    }, "slow");
    $.ajax({
        url: base_url + "order/admin/regenerate-report",
        method: "POST",
        data: {
            file_id: file_id
        },
        success: function (data) {
            var result = jQuery.parseJSON(data);
            $('body').animate({
                    opacity: 1.0
            }, "slow");
            $('#lp_order_success_msg').html(result.message).show();
            $([document.documentElement, document.body]).animate({
                    scrollTop: $("#lp_order_success_msg").offset().top
            }, 1000);
            lp_order_list.ajax.reload(null, false);
            setTimeout(function () {
                $('#lp_order_success_msg').html('').hide();
            }, 5000);
            
        },
        error: function (XMLHttpRequest, textStatus, errorThrown) {
            $('#lp_order_error_msg').html('Something went wrong. Please try it again.').show();
            $([document.documentElement, document.body]).animate({
                scrollTop: $("#lp_order_success_msg").offset().top
            }, 1000);

            setTimeout(function () {
                $('#lp_order_error_msg').html('').hide();
            }, 5000);
        }
    });
}

function sendOrderToResware(file_id) {
    $('body').animate({
        opacity: 0.5
    }, "slow");
    $.ajax({
        url: base_url + "order/admin/send-order-to-resware",
        method: "POST",
        data: {
            file_id: file_id
        },
        success: function (data) {
            var result = jQuery.parseJSON(data);
            if (result.status == 'success') {
                $('body').animate({
                    opacity: 1.0
                }, "slow");
                $('#lp_order_success_msg').html(result.message).show();
                $([document.documentElement, document.body]).animate({
                    scrollTop: $("#lp_order_success_msg").offset().top
                }, 1000);
                lp_order_list.ajax.reload(null, false);
                setTimeout(function () {
                    $('#lp_order_success_msg').html('').hide();
                }, 5000);
            } else {
                $('body').animate({
                    opacity: 1.0
                }, "slow");
                $('#lp_order_error_msg').html(result.message).show();
                $([document.documentElement, document.body]).animate({
                    scrollTop: $("#lp_order_error_msg").offset().top
                }, 1000);
                setTimeout(function () {
                    $('#lp_order_error_msg').html('').hide();
                }, 5000);
            }
        },
        error: function (XMLHttpRequest, textStatus, errorThrown) {
            $('#lp_order_error_msg').html('Something went wrong. Please try it again.').show();
            $([document.documentElement, document.body]).animate({
                scrollTop: $("#lp_order_success_msg").offset().top
            }, 1000);

            setTimeout(function () {
                $('#lp_order_error_msg').html('').hide();
            }, 5000);
        }
    });
}

function updateLpReportStatus(file_id, status) {
    $('body').animate({
        opacity: 0.5
    }, "slow");
    $.ajax({
        url: base_url + "order/admin/update-lp-report-status",
        method: "POST",
        data: {
            file_id: file_id,
            status: status
        },
        success: function (data) {
            var result = jQuery.parseJSON(data);
            if (result.status == 'success') {
                $('body').animate({
                    opacity: 1.0
                }, "slow");
                $('#lp_order_success_msg').html(result.msg).show();
                $([document.documentElement, document.body]).animate({
                    scrollTop: $("#lp_order_success_msg").offset().top
                }, 1000);
                companies_list.ajax.reload(null, false);
                setTimeout(function () {
                    $('#lp_order_success_msg').html('').hide();
                }, 4000);
            } else {
                $('#lp_order_error_msg').html(result.message).show();
                $([document.documentElement, document.body]).animate({
                    scrollTop: $("#lp_order_error_msg").offset().top
                }, 1000);

                setTimeout(function () {
                    $('#lp_order_error_msg').html('').hide();
                }, 4000);
            }
        },
        error: function (XMLHttpRequest, textStatus, errorThrown) {
            $('#lp_order_error_msg').html('Something went wrong. Please try it again.').show();
            $([document.documentElement, document.body]).animate({
                scrollTop: $("#lp_order_error_msg").offset().top
            }, 1000);

            setTimeout(function () {
                $('#lp_order_error_msg').html('').hide();
            }, 4000);
        }
    });
}

function downloadDocumentFromAws(url, documentType) {
    $('#page-preloader').css('background-color', 'rgba(0,0,0,.5)');
    $('#page-preloader').css('display', 'block');
    var fileNameIndex = url.lastIndexOf("/") + 1;
    var filename = url.substr(fileNameIndex);
    $.ajax({
        url: base_url + "download-aws-document-admin",
        type: "post",
        data: {
            url: url
        },
        async: false,
        success: function (response) {
            if (response) {
                if (navigator.msSaveBlob) {
                    var csvData = base64toBlob(response, 'application/octet-stream');
                    var csvURL = navigator.msSaveBlob(csvData, filename);
                    var element = document.createElement('a');
                    element.setAttribute('href', csvURL);
                    element.setAttribute('download', documentType + "_" + filename);
                    element.style.display = 'none';
                    document.body.appendChild(element);
                    document.body.removeChild(element);
                } else {
                    console.log(response);
                    var csvURL = 'data:application/octet-stream;base64,' + response;
                    var element = document.createElement('a');
                    element.setAttribute('href', csvURL);
                    element.setAttribute('download', documentType + "_" + filename);
                    element.style.display = 'none';
                    document.body.appendChild(element);
                    element.click();
                    document.body.removeChild(element);
                }
            }
            $('#page-preloader').css('display', 'none');
        }
    });
}

function addVesting(file_id)
{
    $('#file_id').val(file_id);
    $('body').animate({
        opacity: 0.5
    }, "slow");
    $.ajax({
        url: base_url + "order/admin/get-vesting-info",
        method: "POST",
        data: {
            file_id: file_id
        },
        success: function (data) {
            var result = jQuery.parseJSON(data);
            $('body').animate({
                    opacity: 1.0
            }, "slow");
            if (result.status == 'success') {
                $("textarea#vesting_info").val(result.vesting_information);
                $('#vesting_model').modal('show');
            } 
        },
        error: function (XMLHttpRequest, textStatus, errorThrown) {
            $('#lp_order_error_msg').html('Something went wrong. Please try it again.').show();
            $([document.documentElement, document.body]).animate({
                scrollTop: $("#lp_order_success_msg").offset().top
            }, 1000);

            setTimeout(function () {
                $('#lp_order_error_msg').html('').hide();
            }, 5000);
        }
    });
}

jQuery(document).ready(function ($) {
    $("#document_type").autocomplete({
        source: function(request, response) {
            $.ajax({
                url: base_url + "order/admin/search-document-type",
                data: {
                    doc_type: request.term
                },
                type: "POST",
                dataType: "json",
                success: function (result) {
                    console.log(result);
                    if (result.status == 'success') {
                        if (result.data.length > 0) {
                            response($.map(result.data, function (item) {
                                return item.doc_type;
                            }));
                        } else {
                            response([{ label: 'No results found.', val: -1}]);
                        }
                    } else {
                        response([{ label: 'No results found.', val: -1}]);
                    }
                }
            });
        },
        delay: 0,
        minLength: 1,
        select: function( event, ui ) {
            event.preventDefault();
            $("#document_type").val(ui.item.value);
        },
        change: function( event, ui ) {
            if (ui.item == null) {
                $("#document_type").parent().removeClass('state-success').addClass('state-error');
            }
        }
    });

    $("#document_sub_type").autocomplete({
        source: function(request, response) {
            $.ajax({
                url: base_url + "order/admin/search-document-sub-type",
                data: {
                    doc_type: request.term
                },
                type: "POST",
                dataType: "json",
                success: function (result) {
                    console.log(result);
                    if (result.status == 'success') {
                        if (result.data.length > 0) {
                            response($.map(result.data, function (item) {
                                return item.doc_type;
                            }));
                        } else {
                            response([{ label: 'No results found.', val: -1}]);
                        }
                        console.log(result.data);
                    } else {
                        response([{ label: 'No results found.', val: -1}]);
                    }
                }
            });
        },
        delay: 0,
        minLength: 1,
        select: function( event, ui ) {
            event.preventDefault();
            $("#document_sub_type").val(ui.item.value);
        },
        change: function( event, ui ) {
            if (ui.item == null) {
                $("#document_sub_type").parent().removeClass('state-success').addClass('state-error');
            }
        }
    });
});
//     var doc_type = event.target.value;
//     if (!doc_type) {
//         return;
//     }
//     $.ajax({
//         url: base_url + "order/admin/search-document-type",
//         method: "POST",
//         data: {
//             doc_type: doc_type
//         },
//         success: function (data) {
//             var result = jQuery.parseJSON(data);
//            console.log(result);
//             if (result.status == 'success') {
//                 console.log(result.data);
//             } else {
                
//             }
//         },
//         error: function (XMLHttpRequest, textStatus, errorThrown) {
//             $('#lp_order_error_msg').html('Something went wrong. Please try it again.').show();
//             $([document.documentElement, document.body]).animate({
//                 scrollTop: $("#lp_order_success_msg").offset().top
//             }, 1000);

//             setTimeout(function () {
//                 $('#lp_order_error_msg').html('').hide();
//             }, 5000);
//         }
//     });
// });