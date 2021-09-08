var time_card_listing = '';
var vacation_requests_listing = '';

$(document).ready(function() {
    "use strict";
    var $preloader = $('#page-preloader'),
    $spinner   = $preloader.find('.spinner-loader');
    $spinner.fadeOut();
    $preloader.delay(50).fadeOut('slow');

    $('#time-cards-clone-group-fields').cloneya({
        maximum: 5
    }).on('after_append.cloneya', function (event, toclone, newclone) {
        $(newclone).find("li").remove();
        $(newclone).find("ul").remove();
        $("#reg_hours1, #ot_hours1, #double_ot1").on('change', function(){
            console.log('dfd');
            var reg_hours = $('#reg_hours1').val() != '' ? $('#reg_hours1').val() : 0;
            var ot_hours = $('#ot_hours1').val() != '' ? $('#ot_hours1').val() : 0;
            var double_ot = $('#double_ot1').val() != '' ? $('#double_ot1').val() : 0;
            $('#total_hours1').val(parseInt(reg_hours) + parseInt (ot_hours) + parseInt(double_ot));
        });
    
        $("#reg_hours2, #ot_hours2, #double_ot2").on('change', function(){
            var reg_hours = $('#reg_hours2').val() != '' ? $('#reg_hours2').val() : 0;
            var ot_hours = $('#ot_hours2').val() != '' ? $('#ot_hours2').val() : 0;
            var double_ot = $('#double_ot2').val() != '' ? $('#double_ot2').val() : 0;
            $('#total_hours2').val(parseInt(reg_hours) + parseInt (ot_hours) + parseInt(double_ot));
        });
    
        $("#reg_hours3, #ot_hours3, #double_ot3").on('change', function(){
            var reg_hours = $('#reg_hours3').val() != '' ? $('#reg_hours3').val() : 0;
            var ot_hours = $('#ot_hours3').val() != '' ? $('#ot_hours3').val() : 0;
            var double_ot = $('#double_ot3').val() != '' ? $('#double_ot3').val() : 0;
            $('#total_hours3').val(parseInt(reg_hours) + parseInt (ot_hours) + parseInt(double_ot));
        });
    
        $("#reg_hours4, #ot_hours4, #double_ot4").on('change', function(){
            var reg_hours = $('#reg_hours4').val() != '' ? $('#reg_hours4').val() : 0;
            var ot_hours = $('#ot_hours4').val() != '' ? $('#ot_hours4').val() : 0;
            var double_ot = $('#double_ot4').val() != '' ? $('#double_ot4').val() : 0;
            $('#total_hours4').val(parseInt(reg_hours) + parseInt (ot_hours) + parseInt(double_ot));
        });
        $(newclone).find("input.exp_date")
        .removeClass('hasDatepicker')
        .removeData('datepicker')
        .unbind()
        .datepicker({
            defaultDate: "+1w",
            changeMonth: false,
            numberOfMonths: 1,
            prevText: '<i class="fa fa-chevron-left"></i>',
            nextText: '<i class="fa fa-chevron-right"></i>',
            beforeShow: function() {
                setTimeout(function() {
                    $('.ui-datepicker').css('z-index', 99999999999999);
    
                }, 0);
            }
        });
    }).off('remove.cloneya').on('remove.cloneya', function (event, clone) {
        $(clone).slideToggle('slow', function () {
            $(clone).remove();
        })
    });


    $('#vacation-requests-clone-group-fields').cloneya({
        maximum: 5
    }).on('after_append.cloneya', function (event, toclone, newclone) {
        $(newclone).find("li").remove();
        $(newclone).find("ul").remove();
        $(newclone).find("input.from_date, input.to_date")
            .removeClass('hasDatepicker')
            .removeData('datepicker')
            .unbind()
            .datepicker({
                defaultDate: "+1w",
                changeMonth: false,
                numberOfMonths: 1,
                prevText: '<i class="fa fa-chevron-left"></i>',
                nextText: '<i class="fa fa-chevron-right"></i>',
                beforeShow: function() {
                    setTimeout(function() {
                        $('.ui-datepicker').css('z-index', 99999999999999);
        
                    }, 0);
                }
            });
    }).off('remove.cloneya').on('remove.cloneya', function (event, clone) {
        $(clone).slideToggle('slow', function () {
            $(clone).remove();
        })
    });

    if ($('#time_card_listing').length) {
        time_card_listing = $('#time_card_listing').DataTable({
            "paging": true,
            "lengthChange": false,
            "language": {
                searchPlaceholder: "Search",
                paginate: {
                    next: '<span class="fa fa-angle-right"></span>',
                    previous: '<span class="fa fa-angle-left"></span>',
                },
                "emptyTable": "Record(s) not found.",
                "search": "",
            },
            /*"searching": false,*/
            "bStateSave": true,
            "fnStateSave": function (oSettings, oData) {
                localStorage.setItem('offersDataTables', JSON.stringify(oData));
            },
            "fnStateLoad": function (oSettings) {
                return JSON.parse(localStorage.getItem('offersDataTables'));
            },
            initComplete: function () {


            },
            dom: 'Bfrtip',
            buttons: [],
            "drawCallback": function () {

            },
            "ordering": false,
            "serverSide": true,
            "ajax": {
                url: base_url + "hr/get-time-cards", 
                type: "post",
                error: function (XMLHttpRequest, textStatus, errorThrown) {
                    if (parseInt(XMLHttpRequest.status) == 419) {
                        alert("You are logged out. Please login.");
                    }
                    if (parseInt(XMLHttpRequest.status) == 419) {
                        setTimeout(function () {
                            location.reload();
                        }, 1000);
                    }
                    $("#time_card_listing tbody").append(
                        '<tr><td colspan="4" class="text-center">No records found</td></tr>');
                    $("#time_card_listing_processing").css("display", "none");
                }
            }
        });
    }

    if ($('#vacation_requests_listing').length) {
        vacation_requests_listing = $('#vacation_requests_listing').DataTable({
            "paging": true,
            "lengthChange": false,
            "language": {
                searchPlaceholder: "Search",
                paginate: {
                    next: '<span class="fa fa-angle-right"></span>',
                    previous: '<span class="fa fa-angle-left"></span>',
                },
                "emptyTable": "Record(s) not found.",
                "search": "",
            },
            /*"searching": false,*/
            "bStateSave": true,
            "fnStateSave": function (oSettings, oData) {
                localStorage.setItem('offersDataTables', JSON.stringify(oData));
            },
            "fnStateLoad": function (oSettings) {
                return JSON.parse(localStorage.getItem('offersDataTables'));
            },
            initComplete: function () {


            },
            dom: 'Bfrtip',
            buttons: [],
            "drawCallback": function () {

            },
            "ordering": false,
            "serverSide": true,
            "ajax": {
                url: base_url + "hr/get-vacation-requests", 
                type: "post",
                error: function (XMLHttpRequest, textStatus, errorThrown) {
                    if (parseInt(XMLHttpRequest.status) == 419) {
                        alert("You are logged out. Please login.");
                    }
                    if (parseInt(XMLHttpRequest.status) == 419) {
                        setTimeout(function () {
                            location.reload();
                        }, 1000);
                    }
                    $("#vacation_requests_listing tbody").append(
                        '<tr><td colspan="4" class="text-center">No records found</td></tr>');
                    $("#vacation_requests_listing_processing").css("display", "none");
                }
            }
        });
    }

    $("#reg_hours, #ot_hours, #double_ot").on('change', function(){
        var reg_hours = $('#reg_hours').val() != '' ? $('#reg_hours').val() : 0;
        var ot_hours = $('#ot_hours').val() != '' ? $('#ot_hours').val() : 0;
        var double_ot = $('#double_ot').val() != '' ? $('#double_ot').val() : 0;
        $('#total_hours').val(parseInt(reg_hours) + parseInt (ot_hours) + parseInt(double_ot));
    });
});

$(function() {
    $(".exp_date").datepicker({
        defaultDate: "+1w",
        changeMonth: false,
        numberOfMonths: 1,
        prevText: '<i class="fa fa-chevron-left"></i>',
        nextText: '<i class="fa fa-chevron-right"></i>',
        onClose: function () {
            $(this).parsley().validate();
        }
    });

    $(".from_date").datepicker({
        defaultDate: "+1w",
        changeMonth: false,
        numberOfMonths: 1,
        prevText: '<i class="fa fa-chevron-left"></i>',
        nextText: '<i class="fa fa-chevron-right"></i>',
        onClose: function () {
            $(this).parsley().validate();
        }
    });

    $(".to_date").datepicker({
        defaultDate: "+1w",
        changeMonth: false,
        numberOfMonths: 1,
        prevText: '<i class="fa fa-chevron-left"></i>',
        nextText: '<i class="fa fa-chevron-right"></i>',
        onClose: function () {
            $(this).parsley().validate();
        }
    });
});