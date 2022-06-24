<style>
	.dataTables_length {
		width: 250px !important;
		float: left;
	}

    .bootstrap-select:not([class*="col-"]):not([class*="form-control"]):not(.input-group-btn) {
        width: 100% !important;
    }
</style>
<div class="container-fluid">
	<div class="card mb-3">
		<div class="card-header">
			<i class="fas fa-table"></i>
			Admins
			<div class="float-right">
				<a href="javascript:void(0);" class="btn btn-secondary" data-toggle="modal"
					data-target="#addAdminModal"> Add Admin</a>
			</div>
		</div>

		<div class="card-body">
			<?php
                if($this->session->flashdata('error')) :
                ?>
			<div class="alert alert-danger" role="alert"><?php echo $this->session->flashdata('error');?></div>
			<?php
                elseif($this->session->flashdata('success')):
                ?>
			<div class="alert alert-success" role="alert"><?php echo $this->session->flashdata('success');?></div>
			<?php
                endif;
            ?>
			<div id="forms_success_msg" class="w-100 alert alert-success alert-dismissible"
				style="display:none;"></div>
			<div id="forms_error_msg" class="w-100 alert alert-danger alert-dismissible"
				style="display:none;"></div>
			<div class="table-responsive">
				<table class="table table-bordered cusom__common__datatable" id="tbl-admin-users-listing" width="100%" cellspacing="0">
					<thead>
						<tr>
							<th>Sr No</th>
							<th>Name</th>
							<th>Email</th>
							<th>Role</th>
							<th>Created At</th>
							<th>Action</th>
						</tr>
					</thead>
					<tbody>
						<?php
						foreach($admin_users as $admin_key=>$admin) :
						?>
						<tr>
							<td><?=($admin_key+1)?></td>
							<td><?=$admin->first_name.' '.$admin->last_name;?></td>
							<td><?=$admin->email_id;?></td>
							<td><?=$admin->role_obj ? $admin->role_obj->title : '-';?></td>
							<td><?=date('d F y',strtotime($admin->created_at));?></td>
							<td><div style='display:flex;'> <a class='btn btn-action" href='javascript::void();' onclick='editAdminInfo("<?=$admin->id?>");'><i class='fas fa-fw fa-edit'></i></a>
								
								<button type="button"  class='btn btn-action delete-record-custom' data-url="<?php echo base_url('order/admin/delete-admin-record/'.$admin->id)?>" title ='Delete This User'><span class='fas fa-fw fa-trash' aria-hidden='true'></span></button>
								</div>
							</td>
						</tr>
						<?php
						endforeach;
						?>
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>

<!-- Modal -->
<div class="modal fade" id="addAdminModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
	aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<form  method="post" id="add-edit-admin-form">
				<div class="modal-header">
					<h5 class="modal-title" id="exampleModalLabel">Add New Admin</h5>
				</div>
				<div class="modal-body">
					<div class="form-group">
						<label for="email_id" class="col-form-label">Email</label>
						<input required="" name="email_id" type="email" id="email_id" class="form-control">
					</div>
					<div class="form-group">
						<div class="row">
							<div class="col-sm-6">

								<label for="first-name" class="col-form-label">First Name:</label>
								<input name="first_name" required="" type="text" class="form-control" id="first-name">
							</div>
							<div class="col-sm-6">
								<label for="last-name" class="col-form-label">Last Name:</label>
								<input name="last_name" required="" type="text" class="form-control" id="last-name">
							</div>
						</div>
					</div>
					
					<div class="form-group">
						<div class="row">
							<div class="col-sm-12">
								<label for="user-role" class="col-form-label">Select Role</label>
							</div>
								<div class="col-sm-12">
									<select id="user-role" required="" name="role_id" class="selectpicker" data-live-search="true" required>
										<option value="">Select Role</option>
										<?php foreach($users_roles as $users_role) {?>
											<option value="<?php echo $users_role->id;?>"> <?php echo $users_role->title;?></option>
										<?php }?>
									</select>
								</div>
							<!-- </div> -->
						</div>
					</div>

					<div id="password-check" style="display: none;">
						<div class="form-group">
							<div class="row">
								<div class="col-sm-4">
									<label for="password_update" class="col-form-label">Update Password</label>
								</div>
								<div class="col-sm-8 text-left">
									<input name="password_update" value="1" type="checkbox" class="form-control" id="password_update" style="width: 35px;height: 35px;">
								</div>
							</div>
						</div>
					</div>
					<div id="password-edit">
						<div class="form-group">
							<div class="row">
								<div class="col-sm-6">
									<label for="admin_password" class="col-form-label">Password:</label>
									<input name="password" required="" type="password" class="form-control" id="admin_password">
								</div>
								<div class="col-sm-6">
									<label for="confirm-password" class="col-form-label">Confirm Password:</label>
									<input name="confirm_password" required="" type="password" class="form-control" id="confirm-password">
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
					<button class="btn btn-primary">Submit</button>
				</div>
                <input type="hidden" name="admin_id" id="formId" value="">
			</form>
		</div>
	</div>
</div>

<script>

    function editAdminInfo(formId) 
    {
		$('#formId').val(formId);
        $('#page-preloader').css('background-color', 'rgba(0,0,0,.5)');
        $('#page-preloader').css('display', 'block');
		$("#password-edit").hide();
		$("#password-check").show();
        $.ajax({
            url: base_url + "order/admin/get_admin_details",
            type: "post",
            data: {
                admin_id: formId
            },
            success: function (response) {
                var res = jQuery.parseJSON(response);
                if(res.status) {
                    res_data = res.data;
					$('#email_id').val(res_data.email_id);
					$('#email_id').attr("readonly",true);
					$('#first-name').val(res_data.first_name);
					$('#last-name').val(res_data.last_name);
					$('select[name=role_id]').val(res_data.role_id);
					$('.selectpicker').selectpicker('refresh');
                }  
                $('#page-preloader').css('display', 'none');
                $('#addAdminModal').modal('show');
            }
        });
        return false;
	}
</script>
