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
			Roles
			<div class="float-right">
				<a href="javascript:void(0);" class="btn btn-secondary" data-toggle="modal"
					data-target="#addRoleModal"> Add Role</a>
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
				<table class="table table-bordered cusom__common__datatable" id="tbl-roles-users-listing" width="100%" cellspacing="0">
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
							<td><div style='display:flex;'> <a class='btn btn-action" href='javascript::void();' onclick='editRoleInfo("<?=$role->id?>","<?=$role->title?>");'><i class='fas fa-fw fa-edit'></i></a>
								<?php if($role->id != 1 && $role->id != 2) : ?>
								<button type="button"  class='btn btn-action delete-record-custom' data-url="<?php echo base_url('order/admin/delete-role-record/'.$role->id)?>" title ='Delete This User'><span class='fas fa-fw fa-trash' aria-hidden='true'></span></button>
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
			<form  method="post" id="add-edit-role-form">
				<div class="modal-header">
					<h5 class="modal-title" id="exampleModalLabel">Add / Edit Role</h5>
				</div>
				<div class="modal-body">
					
					<div class="form-group">
						<label for="role-title" class="col-form-label">Title:</label>
						<input name="title" required="" type="text" class="form-control" id="role-title">
						
					</div>
					
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
					<button class="btn btn-primary">Submit</button>
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
