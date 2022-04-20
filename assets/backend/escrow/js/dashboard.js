$(document).ready(function () {
	getDashboardCountBasedOnFilter(0, 0, 0);
});

$(document).on("click", function() { 
    $("#month").unbind().on("change", function(){
		var month = $(this).val();
		var user = $('#user_filter').val();
		var manager = $('#manager_filter').val();
		getDashboardCountBasedOnFilter(manager, user, month);
	});

	$("#user_filter").unbind().on("change", function(){
		var user = $(this).val();
		var month = $('#month').val();
		var manager = $('#manager_filter').val();
		getDashboardCountBasedOnFilter(manager, user, month);
	});

	$("#manager_filter").unbind().on("change", function(){
		var manager = $(this).val();
		var user = $('#user_filter').val();
		var month = $('#month').val();
		getDashboardCountBasedOnFilter(manager, user, month);
	});
});

function getDashboardCountBasedOnFilter(manager_id, user_id, month)
{
	$('#page-preloader').css('background-color', 'rgba(0,0,0,.5)');
	$('#page-preloader').css('display', 'block');
	$.ajax({
		url: base_url + "hr/admin/get-dashboard-count", 
		type: "post",
		data: {
			manager_id: manager_id,
			user_id: user_id,
			month: month
		},
		dataType: "html",
		success: function (response) {
			var results = JSON.parse(response);
			$('#dashboard_count').html(results);
			$('#page-preloader').css('display', 'none');
		}
	});
}


