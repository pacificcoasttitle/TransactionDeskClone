<style>
.dataTables_length {
    width: 250px !important;
    float: left;
}
</style>
<div class="container-fluid">
    <div class="card mb-3">
        <div class="card-header">
            <i class="fas fa-table"></i>
             Notifications
             <div class="float-right">
                <a href="javascript:void(0);" data-export-type="csv" id="export_notification" class="btn btn-secondary">Export </a>
            </div>
        </div>

        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="tbl-notifications-listing" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Sr No</th>
                            <th>Name</th>
                            <th>Action</th>
                        </tr>
                    </thead>                
                    <tbody></tbody>
                </table>
            </div>
        </div>

        <div class="modal fade" id="email_preview" tabindex="-1" role="dialog" aria-labelledby="Email Preview" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document" style="width:100%;">
                
                <div class="modal-content">
                    <div id="mail_preview"></div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function preview_email(notificationId)
	{
		$('#page-preloader').css('background-color', 'rgba(0,0,0,.5)');
		$('#page-preloader').css('display', 'block');
		$.ajax({
			url:base_url+"admin/order/home/email_preview",
			type: "post",
			data: {
				notificationId: notificationId
			},
			dataType: "html",
			success: function (response) {
				var results = JSON.parse(response);
				$('#mail_preview').html(results);
                $('#email_preview').modal('show');
				$('#page-preloader').css('display', 'none');
			}
		});
	}
</script>