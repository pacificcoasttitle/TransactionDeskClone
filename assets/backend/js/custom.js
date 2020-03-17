var customer_list ='';
var agent_list ='';
$(document).ready(function () {

    if ($('#tbl-customers-listing').length || $('#tbl-agents-listing').length)
    {
        jQuery.fn.DataTable.Api.register('buttons.exportData()', function (options) {
        
            if (this.context.length) 
            {
                if(this.context[0].sTableId == 'tbl-customers-listing')
                {
                    var jsonResult = $.ajax({
                        type: "POST",
                        url: base_url+"admin/home/get_customer_list",
                        data: {
                            keyword: $('#tbl-customers-listing_filter input').val(),
                        },
                        success: function (result) {
                        },
                        async: false
                    });
                    var data = jsonResult.responseText;
                    var res = jQuery.parseJSON(data);
                    return { body: res.data, header: $("#tbl-customers-listing thead tr th:not(:last-child)").map(function () { return this.innerHTML; }).get() };
                }
                else
                {
                    var jsonResult = $.ajax({
                        type: "POST",
                        url: base_url+"admin/agent/get_agent_list",
                        data: {
                            keyword: $('#tbl-agents-listing_filter input').val(),
                        },
                        success: function (result) {
                        },
                        async: false
                    });
                    var data = jsonResult.responseText;
                    var res = jQuery.parseJSON(data);
                    return { body: res.data, header: $("#tbl-agents-listing thead tr th:not(:last-child)").map(function () { return this.innerHTML; }).get() };
                }
                
            }
        });
    }
    

	/* Customer listing table */
    if ($('#tbl-customers-listing').length) 
    {
        customer_list = $('#tbl-customers-listing').DataTable({
           /*"pageLength": 2,*/
           "paging": true,
            "lengthChange": false,
            "columnDefs": [
                { "searchable": false, "targets": [0,1] }
            ],
            "language": {
                searchPlaceholder: "Customer Number",
                paginate: {
                  next: '<i class="fa fa-chevron-right" aria-hidden="true"></i>',
                  previous: '<i class="fa fa-chevron-left" aria-hidden="true"></i>',
                },
                "emptyTable": "Record(s) not found.",
            },
            initComplete: function() {
                var $buttons = jQuery('.dt-buttons').hide();
                jQuery('#export-csv').on('click', function() {
                    var export_type = jQuery(this).attr('data-export-type');
                    if(export_type)
                    {
                        var btnClass = '.buttons-' + export_type;
                    }
                    if (btnClass) $buttons.find(btnClass).click();
                })
            },
            dom: 'Bfrtip',
            buttons: [
                {
                    extend: 'csvHtml5',
                    text: 'Export',
                    title: 'Customers',
                    exportOptions: {
                        columns: [0,1, 2, 3, 4, 5, 6, 7,8],
                        format: {
                            body: function ( data, row, column, node ) {
                                // Strip $ from salary column to make it numeric
                                return (column === 0 || column === 1|| column === 2 || column === 3 || column === 4|| column === 5|| column === 6) ?
                                    data.replace( /[$,]/g, '' ) :
                                    data;
                            }
                        }
                    }
                },
            ],
            "drawCallback": function () {               
                $('.dataTables_paginate > .pagination li').addClass('page-item');
                $('.dataTables_paginate > .pagination a').addClass('page-link');
                $('.dataTables_paginate > .pagination li.previous a, .dataTables_paginate > .pagination li.next a').addClass('rounded');
            },
            "ordering": false,            
            "serverSide": true,
            "ajax": {                
                url: base_url+"admin/home/get_customer_list", // json datasource
                type: "post", // method  , by default get
                error: function (XMLHttpRequest, textStatus, errorThrown) {
                    if (parseInt(XMLHttpRequest.status) == 419) {
                        alert("You are logged out. Please login.");
                    }
                    if (parseInt(XMLHttpRequest.status) == 419) {
                        setTimeout(function () {
                            location.reload();
                        }, 1000);
                    }
                    $("#tbl-customers-listing tbody").append('<tr><td colspan="12" class="text-center">No records found</td></tr>');
                    $("#tbl-customers-listing_processing").css("display", "none");

                }
            }            
        });
    }    

    if(jQuery('#importFrm').length)
    {
       jQuery('#importFrm').validate({ 
            rules: {
                file:"required"
            },
            messages: {
                file:"Please upload file to import"
            },
            submitHandler: function(form) {
                form.submit();
                /*$(form).ajaxSubmit({      
                    error:function(){
                        // $('.form-footer').removeClass('progress');
                    },
                    success:function(data){
                        var res = jQuery.parseJSON(data);
                        if(res.status == 'success')
                        { 
                            var content = '<div class="alert alert-success">'+res.msg+'</div>';
                        }
                        else
                        {
                            var content = '<div class="alert alert-danger">'+res.msg+'</div>';
                        }
                        $("#importFrm").trigger("reset");
                        $('#import-result').html(content);
                        $('#import-result').delay(5000).fadeOut();
                    }
                });*/
            }
        }); 
    }    

    if ($('#tbl-agents-listing').length) 
    {
        agent_list = $('#tbl-agents-listing').DataTable({
           /*"pageLength": 2,*/
           "paging": true,
            "lengthChange": false,
            /*"columnDefs": [
                { "searchable": false, "targets": [0,1] }
            ],*/
            "language": {
                paginate: {
                  next: '<i class="fa fa-chevron-right" aria-hidden="true"></i>',
                  previous: '<i class="fa fa-chevron-left" aria-hidden="true"></i>',
                },
                "emptyTable": "Record(s) not found.",
            },
            initComplete: function() {
                var $buttons = jQuery('.dt-buttons').hide();
                jQuery('#export-agent-data').on('click', function() {
                    var export_type = jQuery(this).attr('data-export-type');
                    if(export_type)
                    {
                        var btnClass = '.buttons-' + export_type;
                    }
                    if (btnClass) $buttons.find(btnClass).click();
                })
            },
            dom: 'Bfrtip',
            buttons: [
                {
                    extend: 'csvHtml5',
                    text: 'Export',
                    title: 'Agents',
                    exportOptions: {
                        columns: [0,1, 2, 3, 4],
                        format: {
                            body: function ( data, row, column, node ) {
                                // Strip $ from salary column to make it numeric
                                return (column === 0 || column === 1|| column === 2 || column === 3 || column === 4|| column === 5|| column === 6) ?
                                    data.replace( /[$,]/g, '' ) :
                                    data;
                            }
                        }
                    }
                },
            ],
            "drawCallback": function () {               
                $('.dataTables_paginate > .pagination li').addClass('page-item');
                $('.dataTables_paginate > .pagination a').addClass('page-link');
                $('.dataTables_paginate > .pagination li.previous a, .dataTables_paginate > .pagination li.next a').addClass('rounded');
            },
            "ordering": false,            
            "serverSide": true,
            "ajax": {                
                url: base_url+"admin/agent/get_agent_list", // json datasource
                type: "post", // method  , by default get
                error: function (XMLHttpRequest, textStatus, errorThrown) {
                    if (parseInt(XMLHttpRequest.status) == 419) {
                        alert("You are logged out. Please login.");
                    }
                    if (parseInt(XMLHttpRequest.status) == 419) {
                        setTimeout(function () {
                            location.reload();
                        }, 1000);
                    }
                    $("#tbl-customers-listing tbody").append('<tr><td colspan="12" class="text-center">No records found</td></tr>');
                    $("#tbl-customers-listing_processing").css("display", "none");

                }
            }            
        });
    }

    if(jQuery('#edit-agent').length)
    {
       jQuery('#edit-agent').validate({ 
            rules: {
                name:"required",
                email_address: {
                    required: true,
                    email: true,
                },
                telephone_no:"required",
                company:"required",
            },
            messages: {
                name:{
                    required: 'Enter your name'
                },
                email_address: {
                    required: 'Enter your email address',
                    email: 'Enter a valid email address'
                },
                telephone_no:{
                    required: 'Enter your telephone no'
                },
                company:{
                    required: 'Enter your company name'
                },
            },
            submitHandler: function(form) {
                form.submit();
            }
        }); 
    }
    
});

function deleteCustomer(id)
{
    if (id=='') {
        alert('Customer ID is required.');
        return false;
    }

    var ready = confirm("Are you sure want to delete?");

    if (ready) {
        $.ajax({
            url: base_url+"admin/home/delete_customer",
            method: "POST",
            data : {id:id},
            success: function(data){
                var result = jQuery.parseJSON(data);
                console.log(result);
                if (result.status == 'success') {
                    $('#customer_success_msg').html(result.message).show();
                    $([document.documentElement, document.body]).animate({
                        scrollTop: $("#customer_success_msg").offset().top
                    }, 1000);

                    customer_list.ajax.reload( null, false );
                    setTimeout(function () {
                        $('#customer_success_msg').html('').hide();
                    }, 4000);
                } else {
                    $('#customer_error_msg').html(result.message).show();
                    $([document.documentElement, document.body]).animate({
                        scrollTop: $("#customer_error_msg").offset().top
                    }, 1000);

                    setTimeout(function () {
                        $('#customer_error_msg').html('').hide();
                    }, 4000);
                }
            },
            error: function (XMLHttpRequest, textStatus, errorThrown) {
                $('#customer_error_msg').html('Something went wrong. Please try it again.').show();
                $([document.documentElement, document.body]).animate({
                    scrollTop: $("#customer_success_msg").offset().top
                }, 1000);

                setTimeout(function () {
                    $('#customer_error_msg').html('').hide();
                }, 4000);
            }
        })
    } else {
        return false;
    }
}

function deleteAgent(id)
{
	if (id=='') {
        alert('Agent ID is required.');
        return false;
    }

    var ready = confirm("Are you sure want to delete?");

    if (ready) {
        $.ajax({
            url: base_url+"admin/agent/delete_agent",
            method: "POST",
            data : {id:id},
            success: function(data){

            	var result = jQuery.parseJSON(data);
                
                if (result.status == 'success') {
                    $('#agent_success_msg').html(result.message).show();
                    $([document.documentElement, document.body]).animate({
                        scrollTop: $("#agent_success_msg").offset().top
                    }, 1000);

                    agent_list.ajax.reload( null, false );
                    setTimeout(function () {
                        $('#agent_success_msg').html('').hide();
                    }, 4000);
                } else {
                    $('#agent_error_msg').html(result.message).show();
                    $([document.documentElement, document.body]).animate({
                        scrollTop: $("#agent_error_msg").offset().top
                    }, 1000);

                    setTimeout(function () {
                        $('#agent_error_msg').html('').hide();
                    }, 4000);
                }
            },
            error: function (XMLHttpRequest, textStatus, errorThrown) {
                $('#agent_error_msg').html('Something went wrong. Please try it again.').show();
                $([document.documentElement, document.body]).animate({
                    scrollTop: $("#agent_success_msg").offset().top
                }, 1000);

                setTimeout(function () {
                    $('#agent_error_msg').html('').hide();
                }, 4000);
            }
        })
    } else {
        return false;
    }
}

