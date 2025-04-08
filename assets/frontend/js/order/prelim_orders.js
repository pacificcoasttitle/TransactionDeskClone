$(document).ready(function () {
    // var prelim_list;
    if ($('#prelim_files').length) {
        prelim_list = $('#prelim_files').DataTable({
            "paging": true,
            "lengthChange": false,
            "language": {
                searchPlaceholder: "Search #File or Address",
                paginate: {
                    next: '<span class="fa fa-angle-right"></span>',
                    previous: '<span class="fa fa-angle-left"></span>',
                },
                "emptyTable": "Record(s) not found.",
                "search": ""
            },
            // "searching": false,
            "bStateSave": true,
            "fnStateSave": function (oSettings, oData) {
                localStorage.setItem('offersDataTables', JSON.stringify(oData));
            },
            "fnStateLoad": function (oSettings) {
                return JSON.parse(localStorage.getItem('offersDataTables'));
            },
            initComplete: function () { },
            dom: 'Bfrtip',
            buttons: [],
            "drawCallback": function () { },
            "ordering": false,
            "serverSide": true,
            "ajax": {
                url: base_url + "get-orders-prelim", // json datasource
                type: "post", // method  , by default get
                beforeSend: function () {
                    $('#page-list-loader').css('background-color', 'rgba(0,0,0,.5)');
                    $('#page-list-loader').css('display', 'block');
                },
                error: function (XMLHttpRequest, textStatus, errorThrown) {
                    if (parseInt(XMLHttpRequest.status) == 419) {
                        alert("You are logged out. Please login.");
                    }
                    if (parseInt(XMLHttpRequest.status) == 419) {
                        setTimeout(function () {
                            location.reload();
                        }, 1000);
                    }
                    $("#cpl_listing tbody").append(
                        '<tr><td colspan="4" class="text-center">No records found</td></tr>');
                    $("#cpl_listing_processing").css("display", "none");
                },
                complete: function () {
                    $("#page-list-loader").hide();
                    $('#page-list-loader').css('display', 'none');
                }
            }
        });
    }
});

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
                $('#prelim_success_msg').html(msg).show();
                $([document.documentElement, document.body]).animate({
                    scrollTop: $("#prelim_success_msg").offset().top
                }, 1000);
                prelim_list.ajax.reload(null, false);
                setTimeout(function () {
                    $('#prelim_success_msg').html('').hide();
                }, 4000);
            } else {
                $('#prelim_error_msg').html("Error while syncing sales reps").show();
                $([document.documentElement, document.body]).animate({
                    scrollTop: $("#prelim_error_msg").offset().top
                }, 1000);

                setTimeout(function () {
                    $('#prelim_error_msg').html('').hide();
                }, 10000);
            }
            $("#page-preloader").hide();
        },
        error: function (XMLHttpRequest, textStatus, errorThrown) {
            $('#prelim_error_msg').html('Something went wrong. Please try it again.').show();
            $([document.documentElement, document.body]).animate({
                scrollTop: $("#prelim_success_msg").offset().top
            }, 1000);

            setTimeout(function () {
                $('#prelim_error_msg').html('').hide();
            }, 10000);
        }
    });
}