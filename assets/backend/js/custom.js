var customer_list ='';
var agent_list ='';
var credentials_customer_list = '';
var incorrect_customer_list = '';
var fees_list = '';
$(document).ready(function () {

    // Add active class to menu
    if(jQuery('#users').children().hasClass('active')) {
        jQuery('#users').parent('li').addClass('active');
        jQuery('#users').addClass('show');
    } else {
        jQuery('#users').removeClass('show');
        jQuery('#users').parent('li').removeClass('active');
    }

    // Add active class to menu
    if(jQuery('#documents').children().hasClass('active')) {
        jQuery('#documents').parent('li').addClass('active');
        jQuery('#documents').addClass('show');
    } else {
        jQuery('#documents').removeClass('show');
        jQuery('#documents').parent('li').removeClass('active');
    }

    // Add active class to logs menu
    if(jQuery('#logs').children().hasClass('active')) {
        jQuery('#logs').parent('li').addClass('active');
        jQuery('#logs').addClass('show');
    } else {
        jQuery('#logs').removeClass('show');
        jQuery('#logs').parent('li').removeClass('active');
    }

    if ($('#tbl-customers-listing').length || $('#tbl-agents-listing').length || $('#tbl-lenders-listing').length || $('#tbl-sales-rep-listing').length || $('#tbl-title-officer-listing').length || $('#tbl-credentials-customers-listing').length || $('#tbl-cpl-documents-listing').length || $('#tbl-new-users-listing').length || $('#tbl-master-users-listing').length || $('#tbl-companies-listing').length)
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
                else if(this.context[0].sTableId == 'tbl-grant-documents-listing')
                {
                    var jsonResult = $.ajax({
                        type: "POST",
                        url: base_url+"admin/order/home/get_grant_deed_document_list",
                        data: {
                            keyword: $('#tbl-grant-documents-listing_filter input').val(),
                        },
                        success: function (result) {
                        },
                        async: false
                    });
                    var data = jsonResult.responseText;
                    var res = jQuery.parseJSON(data);
                    return { body: res.data, header: $("#tbl-grant-documents-listing thead tr th:not(:last-child)").map(function () { return this.innerHTML; }).get() };
                }
                else if(this.context[0].sTableId == 'tbl-lv-documents-listing')
                {
                    var jsonResult = $.ajax({
                        type: "POST",
                        url: base_url+"admin/order/home/get_lv_document_list",
                        data: {
                            keyword: $('#tbl-lv-documents-listing_filter input').val(),
                        },
                        success: function (result) {
                        },
                        async: false
                    });
                    var data = jsonResult.responseText;
                    var res = jQuery.parseJSON(data);
                    return { body: res.data, header: $("#tbl-lv-documents-listing thead tr th:not(:last-child)").map(function () { return this.innerHTML; }).get() };
                }
                else if(this.context[0].sTableId == 'tbl-tax-documents-listing')
                {
                    var jsonResult = $.ajax({
                        type: "POST",
                        url: base_url+"admin/order/home/get_tax_document_list",
                        data: {
                            keyword: $('#tbl-tax-documents-listing_filter input').val(),
                        },
                        success: function (result) {
                        },
                        async: false
                    });
                    var data = jsonResult.responseText;
                    var res = jQuery.parseJSON(data);
                    return { body: res.data, header: $("#tbl-tax-documents-listing thead tr th:not(:last-child)").map(function () { return this.innerHTML; }).get() };
                }
                else if(this.context[0].sTableId == 'tbl-curative-documents-listing')
                {
                    var jsonResult = $.ajax({
                        type: "POST",
                        url: base_url+"admin/order/home/get_curative_document_list",
                        data: {
                            keyword: $('#tbl-curative-documents-listing_filter input').val(),
                        },
                        success: function (result) {
                        },
                        async: false
                    });
                    var data = jsonResult.responseText;
                    var res = jQuery.parseJSON(data);
                    return { body: res.data, header: $("#tbl-curative-documents-listing thead tr th:not(:last-child)").map(function () { return this.innerHTML; }).get() };
                }
                else if(this.context[0].sTableId == 'tbl-new-users-listing')
                {
                    var jsonResult = $.ajax({
                        type: "POST",
                        url: base_url+"admin/order/home/get_new_users_list",
                        data: {
                            keyword: $('#tbl-new-users-listing_filter input').val(),
                        },
                        success: function (result) {
                        },
                        async: false
                    });
                    var data = jsonResult.responseText;
                    var res = jQuery.parseJSON(data);
                    return { body: res.data, header: $("#tbl-new-users-listing thead tr th:not('.not-take')").map(function () { return this.innerHTML; }).get() };
                }
                else if(this.context[0].sTableId == 'tbl-master-users-listing')
                {
                    var jsonResult = $.ajax({
                        type: "POST",
                        url: base_url+"admin/order/home/get_master_users_list",
                        data: {
                            keyword: $('#tbl-master-users-listing_filter input').val(),
                        },
                        success: function (result) {
                        },
                        async: false
                    });
                    var data = jsonResult.responseText;
                    var res = jQuery.parseJSON(data);
                    return { body: res.data, header: $("#tbl-master-users-listing thead tr th:not('.not-take')").map(function () { return this.innerHTML; }).get() };
                }
                else if(this.context[0].sTableId == 'tbl-companies-listing')
                {
                    var jsonResult = $.ajax({
                        type: "POST",
                        url: base_url+"admin/order/home/get_companies_list",
                        data: {
                            keyword: $('#tbl-companies-listing_filter input').val(),
                        },
                        success: function (result) {
                        },
                        async: false
                    });
                    var data = jsonResult.responseText;
                    var res = jQuery.parseJSON(data);
                    return { body: res.data, header: $("#tbl-companies-listing thead tr th:not('.not-take')").map(function () { return this.innerHTML; }).get() };
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
           "lengthMenu": [10, 20, 50, 100, 200, 500, 1000],
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
            dom: 'Blfrtip',
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
           "lengthMenu": [10, 20, 50, 100, 200, 500, 1000],
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
            dom: 'Blfrtip',
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
           "lengthMenu": [10, 20, 50, 100, 200, 500, 1000],
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
            dom: 'Blfrtip',
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
           "lengthMenu": [10, 20, 50, 100, 200, 500, 1000],
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
            dom: 'Blfrtip',
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
           "lengthMenu": [10, 20, 50, 100, 200, 500, 1000],
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
            dom: 'Blfrtip',
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
            "lengthMenu": [10, 20, 50, 100, 200, 500, 1000],
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
            dom: 'lf<"FilterCredentialListing">rtip',
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
                type: "post",
                data   : function( d ) {
                    d.credentials_check = $('#FilterCredentialListing').val();
                }, // method  , by default get
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
                
                if ( data[8] == 'Correct' ) {
                    $(row).addClass('alert alert-success');
                }
                else
                {
                    $(row).addClass('alert alert-danger');
                }
            }            
        });

        $("div.FilterCredentialListing").html('<label style="margin-bottom:10px;"> Credentials Check: <select style="width:auto;" class="custom-select custom-select-sm form-control form-control-sm" name="FilterCredentialListing" id="FilterCredentialListing"> <option value="" > All </option><option value="1" > Correct </option><option value="0" > Incorrect </option><option value="2" > Duplicate Email </option></select></label>');   
    }

    $("#FilterCredentialListing").on("change", function(){
        credentials_customer_list.ajax.reload();
    });

    if ($('#tbl-lv-log-listing').length) 
    {
        log_list = $('#tbl-lv-log-listing').DataTable({
            "paging": true,
            "lengthMenu": [10, 20, 50, 100, 200, 500, 1000],
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
                data : {
                    new_users: 0
                },
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

    if($('#refresh-new-users-data').length)
    {
        $('#refresh-new-users-data').click(function(e){
            $('body').animate({ opacity: 0.5 }, "slow");
            $.ajax({
                url: base_url+"/check-update-password",
                method: "POST",
                data : {
                    new_users: 1
                },
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
            "lengthMenu": [10, 20, 50, 100, 200, 500, 1000],
            "lengthChange": true,
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
                url: base_url+"admin/order/order/get_order_list", // json datasource
                type: "post", // method  , by default get
                data   : function( d ) {
                  d.sales_rep= $('#FilterOrderListing').val();
                  d.created_by= $('#FilterCreatedBy').val();
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
            $("div.FilterOrderListing").html('<label> Sales Rep: <select style="width:auto;" name="FilterOrderListing" id="FilterOrderListing" class="custom-select custom-select-sm form-control form-control-sm"> <option value="" > All </option>"'+options+'"</select></label>');   
        }

        if(master_users)
        {
            var obj = jQuery.parseJSON(master_users);
            var options='';
            $.each( obj, function( key, value ) {
              options += '<option value="'+value.id+'">'+value.first_name+' '+value.last_name+'</option>'
            });
            
            $("div.FilterOrderListing").append('<div class="col-sm-3" style="display:inline"><label> Created By: <select name="FilterCreatedBy" id="FilterCreatedBy" class="custom-select custom-select-sm form-control form-control-sm" style="width:auto;"> <option value="" > All </option>"'+options+'"</select></label></div>'); 
        }
       
    }
    $("#FilterOrderListing").on("change", function(){
        order_list.ajax.reload();
    });

    $("#FilterCreatedBy").on("change", function(){
        order_list.ajax.reload();
    }); 

    if ($('#tbl-cpl-documents-listing').length) 
    {
        cpl_document_list = $('#tbl-cpl-documents-listing').DataTable({
            "paging": true,
            "lengthMenu": [10, 20, 50, 100, 200, 500, 1000],
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
            dom: 'Blfrtip',
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

    if ($('#tbl-grant-documents-listing').length) 
    {
        cpl_document_list = $('#tbl-grant-documents-listing').DataTable({
            "paging": true,
            "lengthMenu": [10, 20, 50, 100, 200, 500, 1000],
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
                jQuery('#export_grant_documents').on('click', function() {
                    var export_type = jQuery(this).attr('data-export-type');
                    if (export_type) {
                        var btnClass = '.buttons-' + export_type;
                    }
                    if (btnClass) $buttons.find(btnClass).click();
                })
            },
            dom: 'Blfrtip',
            buttons: [
                {
                    extend: 'csvHtml5',
                    text: 'Export',
                    title: 'Grant Deed Documents',
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
                url: base_url+"admin/order/home/get_grant_deed_document_list", 
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
                    $("#tbl-grant-documents-listing tbody").append('<tr><td colspan="4" class="text-center">No records found</td></tr>');
                    $("#tbl-grant-documents-listing_processing").css("display", "none");

                }
            }            
        });
    }

    if ($('#tbl-lv-documents-listing').length) 
    {
        cpl_document_list = $('#tbl-lv-documents-listing').DataTable({
            "paging": true,
            "lengthMenu": [10, 20, 50, 100, 200, 500, 1000],
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
                jQuery('#export_lv_documents').on('click', function() {
                    var export_type = jQuery(this).attr('data-export-type');
                    if (export_type) {
                        var btnClass = '.buttons-' + export_type;
                    }
                    if (btnClass) $buttons.find(btnClass).click();
                })
            },
            dom: 'Blfrtip',
            buttons: [
                {
                    extend: 'csvHtml5',
                    text: 'Export',
                    title: 'Legal & Vesting Documents',
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
                url: base_url+"admin/order/home/get_lv_document_list", 
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
                    $("#tbl-lv-documents-listing tbody").append('<tr><td colspan="4" class="text-center">No records found</td></tr>');
                    $("#tbl-lv-documents-listing_processing").css("display", "none");

                }
            }            
        });
    }

    /* New Users listing table */
    if ($('#tbl-new-users-listing').length) 
    {
        customer_list = $('#tbl-new-users-listing').DataTable({
        "paging": true,
        "lengthMenu": [10, 20, 50, 100, 200, 500, 1000],
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
                jQuery('#export_new_user').on('click', function() {
                    var export_type = jQuery(this).attr('data-export-type');
                    if(export_type)
                    {
                        var btnClass = '.buttons-' + export_type;
                    }
                    if (btnClass) $buttons.find(btnClass).click();
                })
            },
            dom: 'Blfrtip',
            buttons: [
                {
                    extend: 'csvHtml5',
                    text: 'Export',
                    title: '',
                    exportOptions: {
                        columns: [2, 4, 5],
                        format: {
                            body: function ( data, row, column, node ) {
                                return (column === 2  || column === 4 || column === 5) ?
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
                url: base_url+"admin/order/home/get_new_users_list", 
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
                    $("#tbl-new-users-listing tbody").append('<tr><td colspan="12" class="text-center">No records found</td></tr>');
                    $("#tbl-new-users-listing_processing").css("display", "none");

                }
            }            
        });
    }

    if ($('#tbl-master-users-listing').length) 
    {
        customer_list = $('#tbl-master-users-listing').DataTable({
            "paging": true,
            "lengthMenu": [10, 20, 50, 100, 200, 500, 1000],
            "columnDefs": [
                { "searchable": false, "targets": [0,1] }
            ],
            "language": {
                paginate: {
                next: '<i class="fa fa-chevron-right" aria-hidden="true"></i>',
                previous: '<i class="fa fa-chevron-left" aria-hidden="true"></i>',
                },
                "emptyTable": "Record(s) not found.",
            },
            initComplete: function() {
                var $buttons = jQuery('.dt-buttons').hide();
                jQuery('#export_master_users').on('click', function() {
                    var export_type = jQuery(this).attr('data-export-type');
                    if(export_type)
                    {
                        var btnClass = '.buttons-' + export_type;
                    }
                    if (btnClass) $buttons.find(btnClass).click();
                })
            },
            dom: 'Blfrtip',
            buttons: [
                {
                    extend: 'csvHtml5',
                    text: 'Export',
                    title: '',
                    exportOptions: {
                        columns: [0, 1, 2, 3],
                        format: {
                            body: function ( data, row, column, node ) {
                                return (column === 0  || column === 1 || column === 2 || column === 3) ?
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
                url: base_url+"admin/order/home/get_master_users_list", 
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
                    $("#tbl-master-users-listing tbody").append('<tr><td colspan="12" class="text-center">No records found</td></tr>');
                    $("#tbl-master-users-listing_processing").css("display", "none");

                }
            }            
        });
    }

    /* Tax logs */
    if ($('#tbl-tax-log-listing').length) 
    {
        log_list = $('#tbl-tax-log-listing').DataTable({
            "paging": true,
            "lengthMenu": [10, 20, 50, 100, 200, 500, 1000],
            "columnDefs": [
                { "searchable": false, "targets": [0,1] }
            ],
            "columns": [
                {
                    "width": "5%"
                },
                {
                    "width": "10%"
                },
                {
                    "width": "30%"
                },
                {
                    "width": "20%"
                },
                {
                    "width": "17%"
                },{
                    "width": "18%"
                },
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
                url: base_url+"admin/order/titlePoint/get_tax_logs", // json datasource
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
                    $("#tbl-tax-log-listing tbody").append('<tr><td colspan="12" class="text-center">No records found</td></tr>');
                    $("#tbl-tax-log-listing_processing").css("display", "none");

                }
            },
                        
        });
    }
    /* Tax logs */

    if ($('#tbl-tax-documents-listing').length) 
    {
        cpl_document_list = $('#tbl-tax-documents-listing').DataTable({
            "paging": true,
            "lengthMenu": [10, 20, 50, 100, 200, 500, 1000],
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
                jQuery('#export_tax_documents').on('click', function() {
                    var export_type = jQuery(this).attr('data-export-type');
                    if (export_type) {
                        var btnClass = '.buttons-' + export_type;
                    }
                    if (btnClass) $buttons.find(btnClass).click();
                })
            },
            dom: 'Blfrtip',
            buttons: [
                {
                    extend: 'csvHtml5',
                    text: 'Export',
                    title: 'Tax Documents',
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
                url: base_url+"admin/order/home/get_tax_document_list", 
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
                    $("#tbl-tax-documents-listing tbody").append('<tr><td colspan="4" class="text-center">No records found</td></tr>');
                    $("#tbl-tax-documents-listing_processing").css("display", "none");

                }
            }            
        });
    }

    /* Grant deed logs */
    if ($('#tbl-grant-deed-log-listing').length) 
    {
        log_list = $('#tbl-grant-deed-log-listing').DataTable({
            "paging": true,
            "lengthMenu": [10, 20, 50, 100, 200, 500, 1000],
            "columnDefs": [
                { "searchable": false, "targets": [0,1] }
            ],
            "columns": [
                {
                    "width": "5%"
                },
                {
                    "width": "10%"
                },
                {
                    "width": "30%"
                },
                {
                    "width": "20%"
                },
                {
                    "width": "17%"
                },{
                    "width": "18%"
                },
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
                url: base_url+"admin/order/titlePoint/get_grant_deed_logs", // json datasource
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
                    $("#tbl-grant-deed-log-listing tbody").append('<tr><td colspan="12" class="text-center">No records found</td></tr>');
                    $("#tbl-grant-deed-log-listing_processing").css("display", "none");

                }
            },
                        
        });
    }
    /* Grant deed logs */

    if ($('#tbl-curative-documents-listing').length) 
    {
        cpl_document_list = $('#tbl-curative-documents-listing').DataTable({
            "paging": true,
            "lengthMenu": [10, 20, 50, 100, 200, 500, 1000],
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
                jQuery('#export_curative_documents').on('click', function() {
                    var export_type = jQuery(this).attr('data-export-type');
                    if (export_type) {
                        var btnClass = '.buttons-' + export_type;
                    }
                    if (btnClass) $buttons.find(btnClass).click();
                })
            },
            dom: 'Blfrtip',
            buttons: [
                {
                    extend: 'csvHtml5',
                    text: 'Export',
                    title: 'Curative Documents',
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
                url: base_url+"admin/order/home/get_curative_document_list", 
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
                    $("#tbl-curative-documents-listing tbody").append('<tr><td colspan="4" class="text-center">No records found</td></tr>');
                    $("#tbl-curative-documents-listing_processing").css("display", "none");
                }
            }            
        });
    }

    if ($('#tbl-companies-listing').length) 
    {
        cpl_document_list = $('#tbl-companies-listing').DataTable({
            "paging": true,
            "lengthMenu": [10, 20, 50, 100, 200, 500, 1000],
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
                jQuery('#export_companies').on('click', function() {
                    var export_type = jQuery(this).attr('data-export-type');
                    if (export_type) {
                        var btnClass = '.buttons-' + export_type;
                    }
                    if (btnClass) $buttons.find(btnClass).click();
                })
            },
            dom: 'Blfrtip',
            buttons: [
                {
                    extend: 'csvHtml5',
                    text: 'Export',
                    title: 'Companies',
                    exportOptions: {
                        columns: [0, 1, 2],
                        format: {
                            body: function ( data, row, column, node ) {
                                return (column === 0 || column === 1 || column === 2 || column === 3 || column === 4 || column === 5) ?
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
                url: base_url+"admin/order/home/get_companies_list", 
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
                    $("#tbl-companies-listing tbody").append('<tr><td colspan="4" class="text-center">No records found</td></tr>');
                    $("#tbl-companies-listing_processing").css("display", "none");
                }
            }            
        });
    }

    if ($('#tbl-incorrect-customers-listing').length) 
    {
        incorrect_customer_list = $('#tbl-incorrect-customers-listing').DataTable({
           /*"pageLength": 2,*/
            "paging": true,
            "lengthMenu": [10, 20, 50, 100, 200, 500, 1000],
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
            dom: '<"FilterCredentialListing">lfrtip',
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
                url: base_url+"admin/order/home/get_incorrect_customer_list", // json datasource
                type: "post",
                /*data   : function( d ) {
                    d.credentials_check = $('#FilterCredentialListing').val();
                }, */// method  , by default get
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
        }); 
    }

    $('#frmSearch #btnClear').click(function () {
        $('#frmSearch #keyword').val('');
        $('#frmSearch #btnSearch').click();
    });

    if ($('#tbl-partner-api-log-listing').length) 
    {
        partner_log_list = $('#tbl-partner-api-log-listing').DataTable({
           // "searching": false,
            "paging": true,
            "lengthMenu": [10, 20, 50, 100, 200, 500, 1000],
            "columnDefs": [
                { "searchable": false, "targets": [0,1] }
            ],
            "columns": [
                {
                    "width": "5%"
                },
                {
                    "width": "10%"
                },
                {
                    "width": "15%"
                },
                {
                    "width": "15%"
                },
                {
                    "width": "35%"
                },
                {
                    "width": "20%"
                },
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
            "dom": 'lf<"custom_filter">rtip',
            "drawCallback": function () {               
                $('.dataTables_paginate > .pagination li').addClass('page-item');
                $('.dataTables_paginate > .pagination a').addClass('page-link');
                $('.dataTables_paginate > .pagination li.previous a, .dataTables_paginate > .pagination li.next a').addClass('rounded');
            },
            "ordering": false,            
            "serverSide": true,
            "ajax": {                
                url: base_url+"admin/order/order/get_partner_api_logs", // json datasource
                type: "post", // method  , by default get
                data   : function( d ) {
                  d.sales_rep = $('#log_sales_rep').val();
                  d.title_officer = $('#log_title_officer').val();
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
                    $("#tbl-partner-api-log-listing tbody").append('<tr><td colspan="12" class="text-center">No records found</td></tr>');
                    $("#tbl-partner-api-log-listing_processing").css("display", "none");

                }
            },
                        
        });

        if(sales_rep)
        {
            var obj = jQuery.parseJSON(sales_rep);
            var options='';
            $.each( obj, function( key, value ) {
              options += '<option value="'+value.id+'">'+value.name+'</option>'
            });
            $("div.custom_filter").html('<label> Sales Rep: <select style="width:auto;" class="custom-select custom-select-sm form-control form-control-sm" name="log_sales_rep" id="log_sales_rep"> <option value="" > All </option>"'+options+'"</select></label>');   
        }

        if(title_officer)
        {
            var obj = jQuery.parseJSON(title_officer);
            var options='';
            $.each( obj, function( key, value ) {
              options += '<option value="'+value.id+'">'+value.name+'</option>'
            });
            $("div.custom_filter").append('<div class="col-sm-3" style="display:inline"><label> Title Officer: <select style="width:auto;" class="custom-select custom-select-sm form-control form-control-sm" name="log_title_officer" id="log_title_officer"> <option value="" > All </option>"'+options+'"</select></label>');   
        }
    }

    $("#log_sales_rep").on("change", function(){
        partner_log_list.ajax.reload();
    });

    $("#log_title_officer").on("change", function(){
        partner_log_list.ajax.reload();
    });

    /* Fees listing */
    if ($('#tbl-fees').length) 
    {
        fees_list = $('#tbl-fees').DataTable({
            "paging": true,
            "lengthMenu": [10, 20, 50, 100, 200, 500, 1000],
            "columnDefs": [
                { "searchable": false, "targets": [0,1] }
            ],
            "language": {
                // searchPlaceholder: "Name",
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
                url: base_url+"admin/order/fees/get_fees", // json datasource
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
                    $("#tbl-fees tbody").append('<tr><td colspan="12" class="text-center">No records found</td></tr>');
                    $("#tbl-fees_processing").css("display", "none");

                }
            },
                        
        });
    }
    /* Fees listing */

    /* Add fee validation */
    if(jQuery('#frm-add-fee').length || jQuery('#frm-edit-fee').length)
    {
       jQuery('#frm-add-fee,#frm-edit-fee').validate({ 
            rules: {
                txn_type:"required",
                fee_name:"required",
                fee_value:"required"
            },
            messages: {
                txn_type:"Please select Transaction Type",
                fee_name:"Please enter fee name",
                fee_value: "Please enter fee value"
            },
            submitHandler: function(form) {
                form.submit();
            }
        }); 
    }
    /* Add fee validation */
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
function download(filename, text) 
{
    if (navigator.msSaveBlob)
    {
        var csvData = base64toBlob(text,'application/octet-stream');
        var csvURL = navigator.msSaveBlob(csvData, filename);
        var element = document.createElement('a');
        element.setAttribute('href', csvURL);
        element.setAttribute('download', filename);

        element.style.display = 'none';
        document.body.appendChild(element);

        document.body.removeChild(element);
    }
    else
    {
        var csvURL = 'data:application/octet-stream;base64,'+text;
        var element = document.createElement('a');
        element.setAttribute('href', csvURL);
        element.setAttribute('download', filename);

        element.style.display = 'none';
        document.body.appendChild(element);
        element.click();
        document.body.removeChild(element);
    }
}

function exportOrders()
{
    var sales_rep = $('#FilterOrderListing').val();
    var seachValue = $('.dataTables_filter input').val();

    $.ajax({
        url: base_url+"admin/order/order/export_orders",
        method: "POST",
        data : {sales_rep:sales_rep,seachValue:seachValue },
        success: function(data){
            if(data.status == 'success')
            {
                download('users.csv', data.data);
            }
            else 
            {
                $('#order_error_msg').html(result.message).show();
                $([document.documentElement, document.body]).animate({
                    scrollTop: $("#order_success_msg").offset().top
                }, 1000);

                setTimeout(function () {
                    $('#order_error_msg').html('').hide();
                }, 4000);
            }
            
        },
        error: function (XMLHttpRequest, textStatus, errorThrown) {
            $('#order_error_msg').html('Something went wrong. Please try it again.').show();
            $([document.documentElement, document.body]).animate({
                scrollTop: $("#customer_success_msg").offset().top
            }, 1000);

            setTimeout(function () {
                $('#order_error_msg').html('').hide();
            }, 4000);
        }
    });
}

function deleteMasterUser(id)
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
                    $('#master_users_success_msg').html('Master User deleted successfully').show();
                    $([document.documentElement, document.body]).animate({
                        scrollTop: $("#master_users_success_msg").offset().top
                    }, 1000);
                    customer_list.ajax.reload( null, false );
                    setTimeout(function () {
                        $('#master_users_success_msg').html('').hide();
                    }, 4000);
                } else {
                    $('#master_users_error_msg').html(result.message).show();
                    $([document.documentElement, document.body]).animate({
                        scrollTop: $("#master_users_error_msg").offset().top
                    }, 1000);

                    setTimeout(function () {
                        $('#master_users_error_msg').html('').hide();
                    }, 4000);
                }
            },
            error: function (XMLHttpRequest, textStatus, errorThrown) {
                $('#master_users_error_msg').html('Something went wrong. Please try it again.').show();
                $([document.documentElement, document.body]).animate({
                    scrollTop: $("#customer_success_msg").offset().top
                }, 1000);

                setTimeout(function () {
                    $('#master_users_error_msg').html('').hide();
                }, 4000);
            }
        })
    } else {
        return false;
    }
}

function makePrimary(i)
{
    var id = $("input[name='email_address_"+i+"']:checked").data('id');
    var email = $("input[name='email_address_"+i+"']:checked").val();

    if (id=='') 
    {
        alert('Customer ID is required.');
        return false;
    }

    var ready = confirm("Are you sure want to make account primary?");

    if (ready) 
    {
        $.ajax({
            url: base_url+"admin/order/home/make_customer_primary",
            method: "POST",
            data : {
                id:id,
                email:email
            },
            success: function(data){
                var result = jQuery.parseJSON(data);
                console.log(data);
                if (result.status == 'success') {
                    $('#customer_success_msg').html(result.message).show();
                    $([document.documentElement, document.body]).animate({
                        scrollTop: $("#customer_success_msg").offset().top
                    }, 1000);
                    setTimeout(function () {
                        location.reload();
                    }, 5000);
                } else {
                    $('#customer_error_msg').html(result.message).show();
                    $([document.documentElement, document.body]).animate({
                        scrollTop: $("#customer_error_msg").offset().top
                    }, 1000);
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

function resetPassword(id)
{
    if (id=='') 
    {
        alert('Customer ID is required.');
        return false;
    }

    var ready = confirm("Are you sure want to reset password?");

    if (ready) 
    {
        $.ajax({
            url: base_url+"admin/order/home/reset_user_password",
            method: "POST",
            data : {
                id:id
            },
            success: function(data){
                var result = jQuery.parseJSON(data);
                if (result.status == 'success') {
                    $('#customer_success_msg').html(result.message).show();
                    $([document.documentElement, document.body]).animate({
                        scrollTop: $("#customer_success_msg").offset().top
                    }, 1000);
                    setTimeout(function () {
                        incorrect_customer_list.ajax.reload();
                    }, 5000);
                } else {
                    $('#customer_error_msg').html(result.message).show();
                    $([document.documentElement, document.body]).animate({
                        scrollTop: $("#customer_error_msg").offset().top
                    }, 1000);
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

function deleteFees(id)
{
    if (id=='') {
        alert('Fee ID is required.');
        return false;
    }
    var ready = confirm("Are you sure want to delete?");
    if (ready) 
    {
        $.ajax({
          url: base_url+"admin/order/fees/delete_fees",
          type    : "POST",
          data    : {id:id},
          success: function(data){

                var result = jQuery.parseJSON(data);
                
                if (result.status == 'success') {
                    $('#fees_success_msg').html(result.message).show();
                    $([document.documentElement, document.body]).animate({
                        scrollTop: $("#fees_success_msg").offset().top
                    }, 1000);

                    fees_list.ajax.reload( null, false );
                    setTimeout(function () {
                        $('#fees_success_msg').html('').hide();
                    }, 4000);
                } else {
                    $('#fees_error_msg').html(result.message).show();
                    $([document.documentElement, document.body]).animate({
                        scrollTop: $("#fees_error_msg").offset().top
                    }, 1000);

                    setTimeout(function () {
                        $('#fees_error_msg').html('').hide();
                    }, 4000);
                }
            },
          error   : function( xhr, err )
          {
            alert('Connection Problem !!');
            return false;
          }
        });
    }
    else
    {
        return false;
    }
    
}