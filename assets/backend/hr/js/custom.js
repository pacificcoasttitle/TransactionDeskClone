var adminList ='';
var users ='';
var time_cards = '';
var vacation_requests = '';
var incident_reports = '';
var user_types = '';
var departments = '';
var positions = '';
var memos = '';
var memos_status = '';
var notifications = '';

$(document).ready(function () {
    
    $('#hire_date').datepicker().datepicker("setDate", new Date());
    if ($("#hire_date_val").length != 0) {
        $('#hire_date').val($("#hire_date_val").val());
    }
	if($('#task_position').length) {
		$('#task_position').multiselect({
			includeSelectAllOption: true,
			buttonWidth: '100%',
		});
	}

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
    
    if ($('#users').length > 0)  {
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
            "dom": 'Blfrtip',
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
            "dom": 'Blfrtip',
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
            "dom": 'Blfrtip',
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

    if ($('#user_types').length > 0)  {
        user_types = $('#user_types').DataTable({
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
            "dom": 'Blfrtip',
            "drawCallback": function () {               
                $('.dataTables_paginate > .pagination li').addClass('page-item');
                $('.dataTables_paginate > .pagination a').addClass('page-link');
                $('.dataTables_paginate > .pagination li.previous a, .dataTables_paginate > .pagination li.next a').addClass('rounded');
            },
            "ordering": false,            
            "serverSide": true,
            "ajax": {                
                url: base_url+"hr/admin/get-user-types", 
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
                    $("#user_types tbody").append('<tr><td colspan="6" class="text-center">No records found</td></tr>');
                    $("#user_types_processing").css("display", "none");
                }
            }            
        });
    }
    
    if ($('#departments').length > 0)  {
        departments = $('#departments').DataTable({
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
            "dom": 'Blfrtip',
            "drawCallback": function () {               
                $('.dataTables_paginate > .pagination li').addClass('page-item');
                $('.dataTables_paginate > .pagination a').addClass('page-link');
                $('.dataTables_paginate > .pagination li.previous a, .dataTables_paginate > .pagination li.next a').addClass('rounded');
            },
            "ordering": false,            
            "serverSide": true,
            "ajax": {                
                url: base_url+"hr/admin/get-departments", 
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
                    $("#departments tbody").append('<tr><td colspan="6" class="text-center">No records found</td></tr>');
                    $("#departments_processing").css("display", "none");
                }
            }            
        });
    } 

    if ($('#positions').length > 0)  {
        positions = $('#positions').DataTable({
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
            "dom": 'Blfrtip',
            "drawCallback": function () {               
                $('.dataTables_paginate > .pagination li').addClass('page-item');
                $('.dataTables_paginate > .pagination a').addClass('page-link');
                $('.dataTables_paginate > .pagination li.previous a, .dataTables_paginate > .pagination li.next a').addClass('rounded');
            },
            "ordering": false,            
            "serverSide": true,
            "ajax": {                
                url: base_url+"hr/admin/get-positions", 
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
                    $("#positions tbody").append('<tr><td colspan="6" class="text-center">No records found</td></tr>');
                    $("#positions_processing").css("display", "none");
                }
            }            
        });
    }

	
    
    if ($('#memos').length > 0)  {
        memos = $('#memos').DataTable({
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
            "dom": 'Blfrtip',
            "drawCallback": function () {               
                $('.dataTables_paginate > .pagination li').addClass('page-item');
                $('.dataTables_paginate > .pagination a').addClass('page-link');
                $('.dataTables_paginate > .pagination li.previous a, .dataTables_paginate > .pagination li.next a').addClass('rounded');
            },
            "ordering": false,            
            "serverSide": true,
            "ajax": {                
                url: base_url+"hr/admin/get-memos", 
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
                    $("#memos tbody").append('<tr><td colspan="6" class="text-center">No records found</td></tr>');
                    $("#memos_processing").css("display", "none");
                }
            }            
        });
    } 

    if ($('#commonAdminTbl').length)  {
		var ajax_url = $('#commonAdminTbl').attr('data-url');
        commonAdminTbl = $('#commonAdminTbl').DataTable({
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
            // "serverSide": true,
            "ajax": {                
			url:ajax_url, 
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
                    $("#commonAdminTbl tbody").append('<tr><td colspan="7" class="text-center">No records found</td></tr>');
                    $("#commonAdminTbl_processing").css("display", "none");
                }
            }            
        });
    }

    if ($('#memos_status').length > 0)  {
        memos_status = $('#memos_status').DataTable({
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
            // "serverSide": true,
            "ajax": {                
                url: base_url+"hr/admin/get-memos-status", 
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
                    $("#memos_status tbody").append('<tr><td colspan="6" class="text-center">No records found</td></tr>');
                    $("#memos_status_processing").css("display", "none");
                }
            }            
        });
    } 

    if ($('#notifications').length > 0)  {
        notifications = $('#notifications').DataTable({
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
            "dom": 'Blfrtip',
            "drawCallback": function () {               
                $('.dataTables_paginate > .pagination li').addClass('page-item');
                $('.dataTables_paginate > .pagination a').addClass('page-link');
                $('.dataTables_paginate > .pagination li.previous a, .dataTables_paginate > .pagination li.next a').addClass('rounded');
            },
            "ordering": false,            
            "serverSide": true,
            "ajax": {                
                url: base_url+"hr/admin/get-notifications", 
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
                    $("#notifications tbody").append('<tr><td colspan="6" class="text-center">No records found</td></tr>');
                    $("#notifications_processing").css("display", "none");
                }
            }            
        });
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

function approve_deny_popup(status, requestId) 
{ 
    if(status == 1) {
        $('#approve_deny_title').html('Approve Request Confirmation');   
        $('#approve_deny_msg').html('Are you sure to approve this request?');   
    } else {
        $('#approve_deny_title').html('Deny Request Confirmation');   
        $('#approve_deny_msg').html('Are you sure to deny this request?');  
    }
    $('#status').val(status);
    $('#request_id').val(requestId);
    $('#approve_deny_popup').modal('show');   
    return false;
}

function deleteUserType(id)
{
    if (id=='') {
        alert('User Type ID is required.');
        return false;
    }
    var ready = confirm("Are you sure want to delete?");
    if (ready) {
        $.ajax({
            url: base_url+"hr/admin/delete-user-type",
            method: "POST",
            data : {
                id : id
            },
            success: function(data){
                var result = jQuery.parseJSON(data);
                if (result.status == 'success') {
                    $('#user_types_success_msg').html(result.message).show();
                    $([document.documentElement, document.body]).animate({
                        scrollTop: $("#user_types_success_msg").offset().top
                    }, 1000);
                    user_types.ajax.reload( null, false );
                    setTimeout(function () {
                        $('#user_types_success_msg').html('').hide();
                    }, 4000);
                } else {
                    $('#user_types_error_msg').html(result.message).show();
                    $([document.documentElement, document.body]).animate({
                        scrollTop: $("#user_types_error_msg").offset().top
                    }, 1000);

                    setTimeout(function () {
                        $('#user_types_error_msg').html('').hide();
                    }, 4000);
                }
            },
            error: function (XMLHttpRequest, textStatus, errorThrown) {
                $('#user_types_error_msg').html('Something went wrong. Please try it again.').show();
                $([document.documentElement, document.body]).animate({
                    scrollTop: $("#user_types_error_msg").offset().top
                }, 1000);

                setTimeout(function () {
                    $('#user_types_error_msg').html('').hide();
                }, 4000);
            }
        })
    } else {
        return false;
    } 
}

function deleteDepartment(id)
{
    if (id=='') {
        alert('Department ID is required.');
        return false;
    }
    var ready = confirm("Are you sure want to delete?");
    if (ready) {
        $.ajax({
            url: base_url+"hr/admin/delete-department",
            method: "POST",
            data : {
                id : id
            },
            success: function(data){
                var result = jQuery.parseJSON(data);
                if (result.status == 'success') {
                    $('#departments_success_msg').html(result.message).show();
                    $([document.documentElement, document.body]).animate({
                        scrollTop: $("#departments_success_msg").offset().top
                    }, 1000);
                    departments.ajax.reload( null, false );
                    setTimeout(function () {
                        $('#departments_success_msg').html('').hide();
                    }, 4000);
                } else {
                    $('#departments_error_msg').html(result.message).show();
                    $([document.documentElement, document.body]).animate({
                        scrollTop: $("#departments_error_msg").offset().top
                    }, 1000);

                    setTimeout(function () {
                        $('#departments_error_msg').html('').hide();
                    }, 4000);
                }
            },
            error: function (XMLHttpRequest, textStatus, errorThrown) {
                $('#departments_error_msg').html('Something went wrong. Please try it again.').show();
                $([document.documentElement, document.body]).animate({
                    scrollTop: $("#departments_error_msg").offset().top
                }, 1000);

                setTimeout(function () {
                    $('#departments_error_msg').html('').hide();
                }, 4000);
            }
        })
    } else {
        return false;
    } 
}

function deletePosition(id)
{
    if (id=='') {
        alert('Position ID is required.');
        return false;
    }
    var ready = confirm("Are you sure want to delete?");
    if (ready) {
        $.ajax({
            url: base_url+"hr/admin/delete-position",
            method: "POST",
            data : {
                id : id
            },
            success: function(data){
                var result = jQuery.parseJSON(data);
                if (result.status == 'success') {
                    $('#positions_success_msg').html(result.message).show();
                    $([document.documentElement, document.body]).animate({
                        scrollTop: $("#positions_success_msg").offset().top
                    }, 1000);
                    positions.ajax.reload( null, false );
                    setTimeout(function () {
                        $('#positions_success_msg').html('').hide();
                    }, 4000);
                } else {
                    $('#positions_success_msg').html(result.message).show();
                    $([document.documentElement, document.body]).animate({
                        scrollTop: $("#positions_error_msg").offset().top
                    }, 1000);

                    setTimeout(function () {
                        $('#positions_error_msg').html('').hide();
                    }, 4000);
                }
            },
            error: function (XMLHttpRequest, textStatus, errorThrown) {
                $('#positions_error_msg').html('Something went wrong. Please try it again.').show();
                $([document.documentElement, document.body]).animate({
                    scrollTop: $("#positions_error_msg").offset().top
                }, 1000);

                setTimeout(function () {
                    $('#positions_error_msg').html('').hide();
                }, 4000);
            }
        })
    } else {
        return false;
    } 
}

function deleteMemo(id)
{
    if (id=='') {
        alert('Memo ID is required.');
        return false;
    }
    var ready = confirm("Are you sure want to delete?");
    if (ready) {
        $.ajax({
            url: base_url+"hr/admin/delete-memo",
            method: "POST",
            data : {
                id : id
            },
            success: function(data){
                var result = jQuery.parseJSON(data);
                if (result.status == 'success') {
                    $('#memos_success_msg').html(result.message).show();
                    $([document.documentElement, document.body]).animate({
                        scrollTop: $("#memos_success_msg").offset().top
                    }, 1000);
                    memos.ajax.reload( null, false );
                    setTimeout(function () {
                        $('#memos_success_msg').html('').hide();
                    }, 4000);
                } else {
                    $('#memos_error_msg').html(result.message).show();
                    $([document.documentElement, document.body]).animate({
                        scrollTop: $("#memos_error_msg").offset().top
                    }, 1000);

                    setTimeout(function () {
                        $('#memos_error_msg').html('').hide();
                    }, 4000);
                }
            },
            error: function (XMLHttpRequest, textStatus, errorThrown) {
                $('#memos_error_msg').html('Something went wrong. Please try it again.').show();
                $([document.documentElement, document.body]).animate({
                    scrollTop: $("#memos_error_msg").offset().top
                }, 1000);

                setTimeout(function () {
                    $('#memos_error_msg').html('').hide();
                }, 4000);
            }
        })
    } else {
        return false;
    } 
}

$('#pct__delete_modal').on('show.bs.modal', function (event) {
	let record_id = $(event.relatedTarget).data('id') 
	$(this).find('.modal-body #pct__delete_record_id').val(record_id)
})

