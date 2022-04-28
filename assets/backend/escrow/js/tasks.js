var tasks ='';
$(document).ready(function () {
    if ($('#tasks').length > 0)  {
        tasks = $('#tasks').DataTable({
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
                url: base_url+"hr/admin/get-tasks", 
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
                    $("#tasks tbody").append('<tr><td colspan="6" class="text-center">No records found</td></tr>');
                    $("#tasks_processing").css("display", "none");
                }
            }            
        });
    }
	if ($('.custom__task_button').length > 0){
		change_progress();
		$('.task_check_all').click(function(){
			$('.custom__task_card .custom__task_checkbox').prop('checked', true);
			change_progress();
		});
		$('.task_un_check_all').click(function(){
			$('.custom__task_card .custom__task_checkbox').prop('checked', false);
			change_progress();
		});
		$('.task_show_all').click(function(){
			$(".custom__task_card .custom__task_collapse").collapse('show');
		});
		$('.task_hide_all').click(function(){
			$(".custom__task_card .custom__task_collapse").collapse('hide');
		});

		$('.custom__task_checkbox').change(function(){
			change_progress();
		});
	}
});

function change_progress() {
	var total_task_list = $("[type='checkbox'].custom__task_checkbox").length;
	var checked_task_list = $("[type='checkbox'].custom__task_checkbox:checked").length;
	var progress_precent = Math.floor((100*checked_task_list)/total_task_list);
	$('.custom__task_progress').css('width', progress_precent+'%').attr('aria-valuenow', progress_precent).text(progress_precent+'%');    
}

function deleteTask(id)
{
    if (id=='') {
        alert('Task ID is required.');
        return false;
    }
    var ready = confirm("Are you sure want to delete?");
    if (ready) {
        $.ajax({
            url: base_url+"hr/admin/delete-task",
            method: "POST",
            data : {
                id : id
            },
            success: function(data){
                var result = jQuery.parseJSON(data);
                if (result.status == 'success') {
                    $('#tasks_success_msg').html(result.message).show();
                    $([document.documentElement, document.body]).animate({
                        scrollTop: $("#tasks_success_msg").offset().top
                    }, 1000);
                    tasks.ajax.reload( null, false );
                    setTimeout(function () {
                        $('#tasks_success_msg').html('').hide();
                    }, 4000);
                } else {
                    $('#tasks_error_msg').html(result.message).show();
                    $([document.documentElement, document.body]).animate({
                        scrollTop: $("#tasks_error_msg").offset().top
                    }, 1000);

                    setTimeout(function () {
                        $('#tasks_error_msg').html('').hide();
                    }, 4000);
                }
            },
            error: function (XMLHttpRequest, textStatus, errorThrown) {
                $('#tasks_error_msg').html('Something went wrong. Please try it again.').show();
                $([document.documentElement, document.body]).animate({
                    scrollTop: $("#tasks_error_msg").offset().top
                }, 1000);

                setTimeout(function () {
                    $('#tasks_error_msg').html('').hide();
                }, 4000);
            }
        })
    } else {
        return false;
    }
}

