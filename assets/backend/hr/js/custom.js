var adminList ='';
var users ='';
var time_cards = '';
var vacation_requests = '';
var incident_reports = '';

$(document).ready(function () {
    if ($('#admin_users').length)  {
        adminList = $('#admin_users').DataTable({
           "paging": true,
            "lengthMenu": [10, 20, 50, 100, 200, 500, 1000],
            "lengthChange": true,
            "language": {
                paginate: {
                  next: '<i class="fa fa-chevron-right" aria-hidden="true"></i>',
                  previous: '<i class="fa fa-chevron-left" aria-hidden="true"></i>',
                },
                "emptyTable": "Record(s) not found.",
            },
            initComplete: function() {
            },
            "dom": 'lf<"FilterOrderListing">rtip',
            "drawCallback": function () {               
                $('.dataTables_paginate > .pagination li').addClass('page-item');
                $('.dataTables_paginate > .pagination a').addClass('page-link');
                $('.dataTables_paginate > .pagination li.previous a, .dataTables_paginate > .pagination li.next a').addClass('rounded');
            },
            "ordering": false,            
            "serverSide": true,
            "ajax": {                
                url: base_url+"hr/admin/get-admin-users", 
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
                    $("#admin_users tbody").append('<tr><td colspan="6" class="text-center">No records found</td></tr>');
                    $("#admin_users_processing").css("display", "none");
                }
            }            
        });
    } 
    
    if ($('#users').length)  {
        users = $('#users').DataTable({
           "paging": true,
            "lengthMenu": [10, 20, 50, 100, 200, 500, 1000],
            "lengthChange": true,
            "language": {
                paginate: {
                  next: '<i class="fa fa-chevron-right" aria-hidden="true"></i>',
                  previous: '<i class="fa fa-chevron-left" aria-hidden="true"></i>',
                },
                "emptyTable": "Record(s) not found.",
            },
            initComplete: function() {
            },
            "dom": 'lf<"FilterOrderListing">rtip',
            "drawCallback": function () {               
                $('.dataTables_paginate > .pagination li').addClass('page-item');
                $('.dataTables_paginate > .pagination a').addClass('page-link');
                $('.dataTables_paginate > .pagination li.previous a, .dataTables_paginate > .pagination li.next a').addClass('rounded');
            },
            "ordering": false,            
            "serverSide": true,
            "ajax": {                
                url: base_url+"hr/admin/get-users", 
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
                    $("#users tbody").append('<tr><td colspan="6" class="text-center">No records found</td></tr>');
                    $("#users_processing").css("display", "none");
                }
            }            
        });
    } 

    if ($('#time_cards').length)  {
        time_cards = $('#time_cards').DataTable({
           "paging": true,
            "lengthMenu": [10, 20, 50, 100, 200, 500, 1000],
            "lengthChange": true,
            "language": {
                paginate: {
                  next: '<i class="fa fa-chevron-right" aria-hidden="true"></i>',
                  previous: '<i class="fa fa-chevron-left" aria-hidden="true"></i>',
                },
                "emptyTable": "Record(s) not found.",
            },
            initComplete: function() {
            },
            "dom": 'lf<"FilterOrderListing">rtip',
            "drawCallback": function () {               
                $('.dataTables_paginate > .pagination li').addClass('page-item');
                $('.dataTables_paginate > .pagination a').addClass('page-link');
                $('.dataTables_paginate > .pagination li.previous a, .dataTables_paginate > .pagination li.next a').addClass('rounded');
            },
            "ordering": false,            
            "serverSide": true,
            "ajax": {                
                url: base_url+"hr/admin/get-time-cards", 
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
                    $("#time_cards tbody").append('<tr><td colspan="8" class="text-center">No records found</td></tr>');
                    $("#time_cards_processing").css("display", "none");
                }
            }            
        });
    } 

    if ($('#vacation_requests').length)  {
        vacation_requests = $('#vacation_requests').DataTable({
           "paging": true,
            "lengthMenu": [10, 20, 50, 100, 200, 500, 1000],
            "lengthChange": true,
            "language": {
                paginate: {
                  next: '<i class="fa fa-chevron-right" aria-hidden="true"></i>',
                  previous: '<i class="fa fa-chevron-left" aria-hidden="true"></i>',
                },
                "emptyTable": "Record(s) not found.",
            },
            initComplete: function() {
            },
            "dom": 'lf<"FilterOrderListing">rtip',
            "drawCallback": function () {               
                $('.dataTables_paginate > .pagination li').addClass('page-item');
                $('.dataTables_paginate > .pagination a').addClass('page-link');
                $('.dataTables_paginate > .pagination li.previous a, .dataTables_paginate > .pagination li.next a').addClass('rounded');
            },
            "ordering": false,            
            "serverSide": true,
            "ajax": {                
                url: base_url+"hr/admin/get-vacation-requests", 
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
                    $("#vacation_requests tbody").append('<tr><td colspan="7" class="text-center">No records found</td></tr>');
                    $("#vacation_requests_processing").css("display", "none");
                }
            }            
        });
    } 

    if ($('#incident_reports').length)  {
        incident_reports = $('#incident_reports').DataTable({
           "paging": true,
            "lengthMenu": [10, 20, 50, 100, 200, 500, 1000],
            "lengthChange": true,
            "language": {
                paginate: {
                  next: '<i class="fa fa-chevron-right" aria-hidden="true"></i>',
                  previous: '<i class="fa fa-chevron-left" aria-hidden="true"></i>',
                },
                "emptyTable": "Record(s) not found.",
            },
            initComplete: function() {
            },
            "dom": 'lf<"FilterOrderListing">rtip',
            "drawCallback": function () {               
                $('.dataTables_paginate > .pagination li').addClass('page-item');
                $('.dataTables_paginate > .pagination a').addClass('page-link');
                $('.dataTables_paginate > .pagination li.previous a, .dataTables_paginate > .pagination li.next a').addClass('rounded');
            },
            "ordering": false,            
            "serverSide": true,
            "ajax": {                
                url: base_url+"hr/admin/get-incident-reports", 
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
                    $("#incident_reports tbody").append('<tr><td colspan="7" class="text-center">No records found</td></tr>');
                    $("#incident_reports_processing").css("display", "none");
                }
            }            
        });
    } 

    $('#hire_date').datepicker().datepicker("setDate", new Date());
    if ($("#hire_date_val").length != 0) {
        $('#hire_date').val($("#hire_date_val").val());
    }
    
});


function deleteAdminUser(id)
{
    if (id=='') {
        alert('Admin ID is required.');
        return false;
    }
    var ready = confirm("Are you sure want to delete?");
    if (ready) {
        $.ajax({
            url: base_url+"hr/admin/delete-admin-user",
            method: "POST",
            data : {
                id : id
            },
            success: function(data){
                var result = jQuery.parseJSON(data);
                if (result.status == 'success') {
                    $('#admin_user_success_msg').html(result.message).show();
                    $([document.documentElement, document.body]).animate({
                        scrollTop: $("#admin_user_success_msg").offset().top
                    }, 1000);
                    adminList.ajax.reload( null, false );
                    setTimeout(function () {
                        $('#admin_user_success_msg').html('').hide();
                    }, 4000);
                } else {
                    $('#admin_user_error_msg').html(result.message).show();
                    $([document.documentElement, document.body]).animate({
                        scrollTop: $("#admin_user_error_msg").offset().top
                    }, 1000);

                    setTimeout(function () {
                        $('#admin_user_error_msg').html('').hide();
                    }, 4000);
                }
            },
            error: function (XMLHttpRequest, textStatus, errorThrown) {
                $('#admin_user_error_msg').html('Something went wrong. Please try it again.').show();
                $([document.documentElement, document.body]).animate({
                    scrollTop: $("#admin_user_success_msg").offset().top
                }, 1000);

                setTimeout(function () {
                    $('#admin_user_error_msg').html('').hide();
                }, 4000);
            }
        })
    } else {
        return false;
    }
}

function deleteUser(id)
{
    if (id=='') {
        alert('User ID is required.');
        return false;
    }
    var ready = confirm("Are you sure want to delete?");
    if (ready) {
        $.ajax({
            url: base_url+"hr/admin/delete-user",
            method: "POST",
            data : {
                id : id
            },
            success: function(data){
                var result = jQuery.parseJSON(data);
                if (result.status == 'success') {
                    $('#users_success_msg').html(result.message).show();
                    $([document.documentElement, document.body]).animate({
                        scrollTop: $("#users_success_msg").offset().top
                    }, 1000);
                    adminList.ajax.reload( null, false );
                    setTimeout(function () {
                        $('#users_success_msg').html('').hide();
                    }, 4000);
                } else {
                    $('#users_error_msg').html(result.message).show();
                    $([document.documentElement, document.body]).animate({
                        scrollTop: $("#users_error_msg").offset().top
                    }, 1000);

                    setTimeout(function () {
                        $('#users_error_msg').html('').hide();
                    }, 4000);
                }
            },
            error: function (XMLHttpRequest, textStatus, errorThrown) {
                $('#users_error_msg').html('Something went wrong. Please try it again.').show();
                $([document.documentElement, document.body]).animate({
                    scrollTop: $("#users_success_msg").offset().top
                }, 1000);

                setTimeout(function () {
                    $('#users_error_msg').html('').hide();
                }, 4000);
            }
        })
    } else {
        return false;
    }
}


