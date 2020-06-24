var customer_list ='';
var agent_list ='';
var credentials_customer_list = '';
$(document).ready(function () {
    if ($('#tbl-customers-listing').length || $('#tbl-agents-listing').length || $('#tbl-lenders-listing').length || $('#tbl-sales-rep-listing').length || $('#tbl-title-officer-listing').length || $('#tbl-credentials-customers-listing').length || $('#tbl-cpl-documents-listing').length)
    {
        jQuery.fn.DataTable.Api.register('buttons.exportData()', function (options) {
        
            if (this.context.length) 
            {
                if(this.context[0].sTableId == 'tbl-customers-listing')
                {
                    var jsonResult = $.ajax({
                        type: "POST",
                        url: base_url+"admin/order/home/get_customer_list",
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
                else if(this.context[0].sTableId == 'tbl-lenders-listing')
                {
                    var jsonResult = $.ajax({
                        type: "POST",
                        url: base_url+"admin/order/home/get_lender_list",
                        data: {
                            keyword: $('#tbl-lenders-listing_filter input').val(),
                        },
                        success: function (result) {
                        },
                        async: false
                    });
                    var data = jsonResult.responseText;
                    var res = jQuery.parseJSON(data);
                    return { body: res.data, header: $("#tbl-lenders-listing thead tr th:not(:last-child)").map(function () { return this.innerHTML; }).get() };
                }
                else if(this.context[0].sTableId == 'tbl-agents-listing')
                {
                    var jsonResult = $.ajax({
                        type: "POST",
                        url: base_url+"admin/order/agent/get_agent_list",
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
                else if(this.context[0].sTableId == 'tbl-sales-rep-listing')
                {
                    var jsonResult = $.ajax({
                        type: "POST",
                        url: base_url+"order/admin/get-sales-rep-list",
                        data: {
                            keyword: $('#tbl-sales-rep-listing_filter input').val(),
                        },
                        success: function (result) {
                        },
                        async: false
                    });
                    var data = jsonResult.responseText;
                    var res = jQuery.parseJSON(data);
                    return { body: res.data, header: $("#tbl-sales-rep-listing thead tr th:not(:last-child)").map(function () { return this.innerHTML; }).get() };
                }
                else if(this.context[0].sTableId == 'tbl-credentials-customers-listing')
                {
                    var jsonResult = $.ajax({
                        type: "POST",
                        url: base_url+"admin/order/customer/get_customer_list",
                        data: {
                            keyword: $('#tbl-credentials-customers-listing_filter input').val(),
                        },
                        success: function (result) {
                        },
                        async: false
                    });
                    var data = jsonResult.responseText;
                    var res = jQuery.parseJSON(data);
                    return { body: res.data, header: $("#tbl-credentials-customers-listing thead tr th:not(:last-child)").map(function () { return this.innerHTML; }).get() };
                }
                else if(this.context[0].sTableId == 'tbl-cpl-documents-listing')
                {
                    var jsonResult = $.ajax({
                        type: "POST",
                        url: base_url+"admin/order/home/get_cpl_document_list",
                        data: {
                            keyword: $('#tbl-cpl-documents-listing_filter input').val(),
                        },
                        success: function (result) {
                        },
                        async: false
                    });
                    var data = jsonResult.responseText;
                    var res = jQuery.parseJSON(data);
                    return { body: res.data, header: $("#tbl-cpl-documents-listing thead tr th:not(:last-child)").map(function () { return this.innerHTML; }).get() };
                }
                else 
                {
                    var jsonResult = $.ajax({
                        type: "POST",
                        url: base_url+"order/admin/get-title-officer-list",
                        data: {
                            keyword: $('#tbl-title-officer-listing_filter input').val(),
                        },
                        success: function (result) {
                        },
                        async: false
                    });
                    var data = jsonResult.responseText;
                    var res = jQuery.parseJSON(data);
                    return { body: res.data, header: $("#tbl-title-officer-listing thead tr th:not(:last-child)").map(function () { return this.innerHTML; }).get() };
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
                // searchPlaceholder: "Customer Number",
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
                url: base_url+"admin/order/home/get_customer_list", // json datasource
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

    if(jQuery('#importLenderFrm').length)
    {
       jQuery('#importLenderFrm').validate({ 
            rules: {
                file:"required",
                lenderType:"required",
            },
            messages: {
                file:"Please upload file to import",
                lenderType:"Please select lender type",
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
                url: base_url+"admin/order/agent/get_agent_list", // json datasource
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

    /* Lender listing table */
    if ($('#tbl-lenders-listing').length) 
    {
        customer_list = $('#tbl-lenders-listing').DataTable({
           /*"pageLength": 2,*/
           "paging": true,
            "lengthChange": false,
            "columnDefs": [
                { "searchable": false, "targets": [0,1] }
            ],
            "language": {
                // searchPlaceholder: "Customer Number",
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
                    title: 'Lenders',
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
                url: base_url+"admin/order/home/get_lender_list", // json datasource
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
                    $("#tbl-lenders-listing tbody").append('<tr><td colspan="12" class="text-center">No records found</td></tr>');
                    $("#tbl-lenders-listing_processing").css("display", "none");

                }
            }            
        });
    }

    if ($('#tbl-sales-rep-listing').length) 
    {
        sales_rep_list = $('#tbl-sales-rep-listing').DataTable({
           "paging": true,
            "lengthChange": false,
            "columnDefs": [
                { "searchable": false, "targets": [0,1] }
            ],
            "language": {
                searchPlaceholder: "Search",
                paginate: {
                  next: '<i class="fa fa-chevron-right" aria-hidden="true"></i>',
                  previous: '<i class="fa fa-chevron-left" aria-hidden="true"></i>',
                },
                "emptyTable": "Record(s) not found.",
            },
            initComplete: function() {
                var $buttons = jQuery('.dt-buttons').hide();
                jQuery('#export-sales-rep-data').on('click', function() {
                    var export_type = jQuery(this).attr('data-export-type');
                    if (export_type) {
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
                    title: 'Sales Rep.',
                    exportOptions: {
                        columns: [0, 1, 2],
                        format: {
                            body: function ( data, row, column, node ) {
                                return (column === 0 || column === 1|| column === 2) ?
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
                url: base_url+"order/admin/get-sales-rep-list", 
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
                    $("#tbl-sales-rep-listing tbody").append('<tr><td colspan="4" class="text-center">No records found</td></tr>');
                    $("#tbl-sales-rep-listing_processing").css("display", "none");

                }
            }            
        });
    }

    if ($('#tbl-title-officer-listing').length) 
    {
        title_officer_list = $('#tbl-title-officer-listing').DataTable({
           "paging": true,
            "lengthChange": false,
            "columnDefs": [
                { "searchable": false, "targets": [0,1] }
            ],
            "language": {
                searchPlaceholder: "Search",
                paginate: {
                  next: '<i class="fa fa-chevron-right" aria-hidden="true"></i>',
                  previous: '<i class="fa fa-chevron-left" aria-hidden="true"></i>',
                },
                "emptyTable": "Record(s) not found.",
            },
            initComplete: function() {
                var $buttons = jQuery('.dt-buttons').hide();
                jQuery('#export-title-officer-data').on('click', function() {
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
                    title: 'Title Officers',
                    exportOptions: {
                        columns: [0, 1, 2],
                        format: {
                            body: function ( data, row, column, node ) {
                                return (column === 0 || column === 1|| column === 2) ?
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
                url: base_url+"order/admin/get-title-officer-list", 
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
                    $("#tbl-title-officer-listing tbody").append('<tr><td colspan="4" class="text-center">No records found</td></tr>');
                    $("#tbl-title-officer-listing_processing").css("display", "none");

                }
            }            
        });
    }

    if ($('#tbl-credentials-customers-listing').length) 
    {
        credentials_customer_list = $('#tbl-credentials-customers-listing').DataTable({
           /*"pageLength": 2,*/
           "paging": true,
            "lengthChange": false,
            "columnDefs": [
                { "searchable": false, "targets": [0,1,2] }
            ],
            "language": {
                // searchPlaceholder: "Customer Number",
                paginate: {
                  next: '<i class="fa fa-chevron-right" aria-hidden="true"></i>',
                  previous: '<i class="fa fa-chevron-left" aria-hidden="true"></i>',
                },
                "emptyTable": "Record(s) not found.",
            },
            initComplete: function() {
                var $buttons = jQuery('.dt-buttons').hide();
                jQuery('#export_customer').on('click', function() {
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
                        columns: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9],
                        format: {
                            body: function ( data, row, column, node ) {
                                return (column === 0 || column === 1 || column === 2 || column === 3 || column === 4 || column === 5 || column === 6 || column === 7 || column === 8 || column === 9) ?
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
                url: base_url+"admin/order/customer/get_customer_list", // json datasource
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
                    $("#tbl-credentials-customers-listing tbody").append('<tr><td colspan="12" class="text-center">No records found</td></tr>');
                    $("#tbl-credentials-customers-listing_processing").css("display", "none");

                }
            },
            "createdRow": function ( row, data, index ) {
                
                if ( data[9] == 'Correct' ) {
                    $(row).addClass('alert alert-success');
                }
                else
                {
                    $(row).addClass('alert alert-danger');
                }
            }            
        });
    }

    if ($('#tbl-lv-log-listing').length) 
    {
        log_list = $('#tbl-lv-log-listing').DataTable({
           /*"pageLength": 2,*/
           "paging": true,
            "lengthChange": false,
            "columnDefs": [
                { "searchable": false, "targets": [0,1] }
            ],
            "language": {
                searchPlaceholder: "Order #",
                paginate: {
                  next: '<i class="fa fa-chevron-right" aria-hidden="true"></i>',
                  previous: '<i class="fa fa-chevron-left" aria-hidden="true"></i>',
                },
                "emptyTable": "Record(s) not found.",
            },
            initComplete: function() {
            },
            
            "drawCallback": function () {               
                $('.dataTables_paginate > .pagination li').addClass('page-item');
                $('.dataTables_paginate > .pagination a').addClass('page-link');
                $('.dataTables_paginate > .pagination li.previous a, .dataTables_paginate > .pagination li.next a').addClass('rounded');
            },
            "ordering": false,            
            "serverSide": true,
            "ajax": {                
                url: base_url+"admin/order/titlePoint/get_logs", // json datasource
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
                    $("#tbl-lv-log-listing tbody").append('<tr><td colspan="12" class="text-center">No records found</td></tr>');
                    $("#tbl-lv-log-listing_processing").css("display", "none");

                }
            },
                        
        });
    }

    if($('#refresh-data').length)
    {
        $('#refresh-data').click(function(e){
            $('body').animate({ opacity: 0.5 }, "slow");
            $.ajax({
                url: base_url+"/check-update-password",
                method: "POST",
                /*data : {id:id},*/
                success: function(data){
                    var result = jQuery.parseJSON(data);
                    if (result.status == 'success') {
                        $('body').animate({ opacity: 1.0 }, "slow");
                        $('#customer_success_msg').html(result.msg).show();
                        $([document.documentElement, document.body]).animate({
                            scrollTop: $("#customer_success_msg").offset().top
                        }, 1000);
                        credentials_customer_list.ajax.reload( null, false );
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
        });
    }

    if ($('#tbl-orders-listing').length) 
    {
        order_list = $('#tbl-orders-listing').DataTable({
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
                });


            },
            "dom": '<"FilterOrderListing">frtip',
            //"dom": '<"row"<"col-sm-12"<"text-left"f>>>',
            // dom: 'Bfrtip',
            /*buttons: [
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
            ],*/
            "drawCallback": function () {               
                $('.dataTables_paginate > .pagination li').addClass('page-item');
                $('.dataTables_paginate > .pagination a').addClass('page-link');
                $('.dataTables_paginate > .pagination li.previous a, .dataTables_paginate > .pagination li.next a').addClass('rounded');
            },
            "ordering": false,            
            "serverSide": true,
            "ajax": {                
                url: base_url+"admin/order/order/get_order_list", // json datasource
                type: "post", // method  , by default get
                data   : function( d ) {
                  d.sales_rep= $('#FilterOrderListing').val();
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
                    $("#tbl-orders-listing tbody").append('<tr><td colspan="12" class="text-center">No records found</td></tr>');
                    $("#tbl-orders-listing_processing").css("display", "none");

                }
            }            
        });

        if(sales_rep)
        {
            var obj = jQuery.parseJSON(sales_rep);
            var options='';
            $.each( obj, function( key, value ) {
              options += '<option value="'+value.id+'">'+value.name+'</option>'
            });
            $("div.FilterOrderListing").html('<label> Sales Rep: <select name="FilterOrderListing" id="FilterOrderListing"> <option value="" > All </option>"'+options+'"</select></label>');   
        }
       
    }
    $("#FilterOrderListing").on("change", function(){
        order_list.ajax.reload();
    }); 

    if ($('#tbl-cpl-documents-listing').length) 
    {
        cpl_document_list = $('#tbl-cpl-documents-listing').DataTable({
            "paging": true,
            "lengthChange": false,
            "columnDefs": [
                { "searchable": false, "targets": [0,1] }
            ],
            "language": {
                searchPlaceholder: "Search",
                paginate: {
                  next: '<i class="fa fa-chevron-right" aria-hidden="true"></i>',
                  previous: '<i class="fa fa-chevron-left" aria-hidden="true"></i>',
                },
                "emptyTable": "Record(s) not found.",
            },
            initComplete: function() {
                var $buttons = jQuery('.dt-buttons').hide();
                jQuery('#export_cpl_documents').on('click', function() {
                    var export_type = jQuery(this).attr('data-export-type');
                    if (export_type) {
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
                    title: 'CPL Documents',
                    exportOptions: {
                        columns: [0, 1, 2],
                        format: {
                            body: function ( data, row, column, node ) {
                                return (column === 0 || column === 1|| column === 2) ?
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
                url: base_url+"admin/order/home/get_cpl_document_list", 
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
                    $("#tbl-cpl-documents-listing tbody").append('<tr><td colspan="4" class="text-center">No records found</td></tr>');
                    $("#tbl-cpl-documents-listing_processing").css("display", "none");

                }
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
            url: base_url+"admin/order/home/delete_customer",
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
            url: base_url+"admin/order/agent/delete_agent",
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

function deleteSalesRep(id)
{
	if (id=='') {
        alert('Sales Rep. ID is required.');
        return false;
    }

    var ready = confirm("Are you sure want to delete?");

    if (ready) {
        $.ajax({
            url: base_url+"admin/order/sales/delete_sales_rep",
            method: "POST",
            data : {
                id: id
            },
            success: function(data) {
            	var result = jQuery.parseJSON(data);
                if (result.status == 'success') {
                    $('#sales_rep_success_msg').html(result.message).show();
                    $([document.documentElement, document.body]).animate({
                        scrollTop: $("#sales_rep_success_msg").offset().top
                    }, 1000);
                    sales_rep_list.ajax.reload( null, false );
                    setTimeout(function () {
                        $('#sales_rep_success_msg').html('').hide();
                    }, 4000);
                } else {
                    $('#sales_rep_error_msg').html(result.message).show();
                    $([document.documentElement, document.body]).animate({
                        scrollTop: $("#sales_rep_error_msg").offset().top
                    }, 1000);

                    setTimeout(function () {
                        $('#sales_rep_error_msg').html('').hide();
                    }, 4000);
                }
            },
            error: function (XMLHttpRequest, textStatus, errorThrown) {
                $('#sales_rep_error_msg').html('Something went wrong. Please try it again.').show();
                $([document.documentElement, document.body]).animate({
                    scrollTop: $("#sales_rep_success_msg").offset().top
                }, 1000);

                setTimeout(function () {
                    $('#sales_rep_error_msg').html('').hide();
                }, 4000);
            }
        })
    } else {
        return false;
    }
}

function deleteTitleOfficer(id)
{
	if (id=='') {
        alert('Title Officer ID is required.');
        return false;
    }

    var ready = confirm("Are you sure want to delete?");

    if (ready) {
        $.ajax({
            url: base_url+"admin/order/title/delete_title_officer",
            method: "POST",
            data : {
                id: id
            },
            success: function(data) {
            	var result = jQuery.parseJSON(data);
                if (result.status == 'success') {
                    $('#title_officer_success_msg').html(result.message).show();
                    $([document.documentElement, document.body]).animate({
                        scrollTop: $("#title_officer_success_msg").offset().top
                    }, 1000);
                    title_officer_list.ajax.reload( null, false );
                    setTimeout(function () {
                        $('#title_officer_success_msg').html('').hide();
                    }, 4000);
                } else {
                    $('#title_officer_error_msg').html(result.message).show();
                    $([document.documentElement, document.body]).animate({
                        scrollTop: $("#title_officer_error_msg").offset().top
                    }, 1000);

                    setTimeout(function () {
                        $('#title_officer_error_msg').html('').hide();
                    }, 4000);
                }
            },
            error: function (XMLHttpRequest, textStatus, errorThrown) {
                $('#title_officer_error_msg').html('Something went wrong. Please try it again.').show();
                $([document.documentElement, document.body]).animate({
                    scrollTop: $("#title_officer_success_msg").offset().top
                }, 1000);

                setTimeout(function () {
                    $('#title_officer_error_msg').html('').hide();
                }, 4000);
            }
        })
    } else {
        return false;
    }
}

