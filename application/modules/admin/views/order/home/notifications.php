<?php 
    $userdata = $this->session->userdata('admin');
	$roleList = $this->common_lib->getRoleList();
	$role_id = isset($userdata['role_id']) ? $userdata['role_id'] : 0;
	$roleName = $roleList[$role_id];
?>

<div class="pct-admin-listing">
    <!-- Page Header -->
    <div class="page-header">
        <h1><i class="fas fa-bell"></i> Notifications</h1>
        <div class="action-buttons">
            <?php  if (!in_array($roleName, ['CS Admin'])) : ?>
                <a href="javascript:void(0);" data-export-type="csv" id="export_notification" class="btn-action btn-action-success">
                    <i class="fas fa-file-export"></i> Export
                </a>
            <?php endif; ?>
        </div>
    </div>

    <!-- Notifications Table Card -->
    <div class="modern-card">
        <div class="modern-card-header">
            <h2><i class="fas fa-list-alt"></i> Notifications Listing</h2>
        </div>
        <div class="modern-card-body">
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
                    <div class="modal-header">
                        <h5 class="modal-title"><i class="fas fa-envelope-open-text"></i> Email Preview</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div id="mail_preview"></div>
                    </div>
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