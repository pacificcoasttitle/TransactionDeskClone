
$(document).ready(function () {
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


