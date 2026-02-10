<style>
    .bootstrap-select:not([class*="col-"]):not([class*="form-control"]):not(.input-group-btn) {
        width: 100% !important;
    }
</style>

<div class="pct-admin-listing">
    <!-- Page Header -->
    <div class="page-header">
        <h1><i class="fas fa-user-tag"></i> Roles Listing</h1>
        <div class="action-buttons">
            <a href="javascript:void(0);" data-toggle="modal" data-target="#addRoleModal" class="btn-action btn-action-success">
                <i class="fas fa-plus"></i> Add Role
            </a>
        </div>
    </div>

    <!-- Roles Table Card -->
    <div class="modern-card">
        <div class="modern-card-header">
            <h2><i class="fas fa-users"></i> Roles</h2>
        </div>
        <div class="modern-card-body">
            <?php if($this->session->flashdata('error')) : ?>
                <div class="alert-modern alert-danger-modern"><?php echo $this->session->flashdata('error');?></div>
            <?php elseif($this->session->flashdata('success')): ?>
                <div class="alert-modern alert-success-modern"><?php echo $this->session->flashdata('success');?></div>
            <?php endif; ?>

            <div id="forms_success_msg" class="alert-modern alert-success-modern" style="display:none;"></div>
            <div id="forms_error_msg" class="alert-modern alert-danger-modern" style="display:none;"></div>

            <div class="table-responsive">
                <table class="table table-bordered" id="tbl-roles-users-listing" width="100%" cellspacing="0">
                    <thead>
                        <tr>
							<th>Sr No</th>
							<th>Title</th>
							<th>Created At</th>
							<th>Action</th>
                        </tr>
                    </thead>                
                    <tbody>
						<?php
						foreach($users_roles as $role_key=>$role) :
						?>
						<tr>
							<td><?=($role_key+1)?></td>
							<td><?=$role->title;?></td>
							
							<td><?=date('d F y',strtotime($role->created_at));?></td>
							<td><div style='display:flex;'> <a href='javascript::void();' onclick='editRoleInfo("<?=$role->id?>","<?=$role->title?>");'><i class='fas fa-fw fa-edit'></i></a>
								<?php if($role->id != 1 && $role->id != 2) : ?>
								<a href='javascript::void();'  class='delete-record-custom' data-url="<?php echo base_url('order/admin/delete-role-record/'.$role->id)?>" title ='Delete This User'><span class='fas fa-fw fa-trash' aria-hidden='true'></span></a>
								<?php endif; ?>
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
<div class="modal fade" id="addRoleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
	aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<form method="post" id="add-edit-role-form">
				<div class="modal-header">
					<h5 class="modal-title"><i class="fas fa-user-tag"></i> Add / Edit Role</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<div class="form-group">
						<label for="role-title" class="col-form-label">Title</label>
						<input name="title" required="" type="text" class="form-control" id="role-title">
					</div>
				</div>
				<div class="modal-footer">
					<button type="submit" data-btntext-sending="Sending..." class="btn-action btn-action-primary">
						<i class="fas fa-check"></i> Submit
					</button>
					<button type="reset" data-dismiss="modal" aria-label="Close" class="btn-action btn-action-secondary">
						<i class="fas fa-ban"></i> Cancel
					</button>
				</div>
				<input type="hidden" name="role_id" id="formId" value="">
			</form>
		</div>
	</div>
</div>

<script>

    function editRoleInfo(formId,title) 
    {
		$('#formId').val(formId);
        $('#page-preloader').css('background-color', 'rgba(0,0,0,.5)');
        $('#page-preloader').css('display', 'block');
		$('#role-title').val(title);
		$('#page-preloader').css('display', 'none');
        $('#addRoleModal').modal('show');
		
       
        return false;
	}
</script>
