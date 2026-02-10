<div class="pct-admin-listing">
    <!-- Page Header -->
    <div class="page-header">
        <h1><i class="fas fa-user-shield"></i> Admin Users</h1>
        
        <div class="action-buttons">
            <a href="javascript:void(0);" data-toggle="modal" data-target="#addAdminModal" class="btn-action btn-action-primary">
                <i class="fas fa-plus"></i> Add Admin
            </a>
        </div>
    </div>

    <!-- Admin Users Table Card -->
    <div class="modern-card">
        <div class="modern-card-header">
            <h2><i class="fas fa-users"></i> Admin User Listing</h2>
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
                <table class="table table-bordered" id="tbl-admin-users-listing" width="100%" cellspacing="0">
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
                        <?php foreach($admin_users as $admin_key => $admin): ?>
                        <tr>
                            <td><?=($admin_key+1)?></td>
                            <td><?=$admin->first_name.' '.$admin->last_name;?></td>
                            <td><?=$admin->email_id;?></td>
                            <td><?=$admin->role_obj ? $admin->role_obj->title : '-';?></td>
                            <td><?=date('d F y', strtotime($admin->created_at));?></td>
                            <td>
                                <div style='display:flex;'>
                                    <a href='javascript:void(0);' onclick='editAdminInfo("<?=$admin->id?>");' title="Edit">
                                        <i class='fas fa-fw fa-edit'></i>
                                    </a>
                                    <a href='javascript:void(0);' class='delete-record-custom' data-url="<?php echo base_url('order/admin/delete-admin-record/'.$admin->id)?>" title='Delete This User'>
                                        <span class='fas fa-fw fa-trash' aria-hidden='true'></span>
                                    </a>
                                </div>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Add/Edit Admin Modal -->
<div class="modal fade pct-admin-listing" id="addAdminModal" tabindex="-1" role="dialog" aria-labelledby="addAdminModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document" style="max-width: 600px;">
        <div class="modal-content">
            <form method="post" id="add-edit-admin-form">
                <div class="modal-header">
                    <h5 class="modal-title"><i class="fas fa-user-plus mr-2"></i>Add / Edit Admin</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="email_id" class="font-weight-bold">Email</label>
                        <input name="email_id" required type="email" class="form-control" id="email_id">
                    </div>
                    
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="first-name" class="font-weight-bold">First Name</label>
                                <input required name="first_name" type="text" id="first-name" class="form-control">
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="last-name" class="font-weight-bold">Last Name</label>
                                <input required name="last_name" type="text" id="last-name" class="form-control">
                            </div>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label for="user-role" class="font-weight-bold">Select Role</label>
                        <select id="user-role" required name="role_id" class="selectpicker form-control" data-live-search="true">
                            <option value="">Select Role</option>
                            <?php foreach($users_roles as $users_role) { ?>
                                <option value="<?php echo $users_role->id; ?>"><?php echo $users_role->title; ?></option>
                            <?php } ?>
                        </select>
                    </div>
                    
                    <div id="password-check" style="display: none;">
                        <div class="form-group">
                            <div class="custom-control custom-checkbox">
                                <input name="password_update" value="1" type="checkbox" class="custom-control-input" id="password_update">
                                <label class="custom-control-label" for="password_update">Update Password</label>
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="admin_password" class="font-weight-bold">Password</label>
                                <input required name="password" type="password" id="admin_password" class="form-control">
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="confirm-password" class="font-weight-bold">Confirm Password</label>
                                <input required name="confirm_password" type="password" id="confirm-password" class="form-control">
                            </div>
                        </div>
                    </div>
                    
                    <input type="hidden" name="admin_id" id="formId" value="">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">
                        <i class="fas fa-times mr-1"></i> Cancel
                    </button>
                    <button type="submit" class="btn btn-success">
                        <i class="fas fa-check mr-1"></i> Submit
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    function editAdminInfo(formId) {
        $('#formId').val(formId);
        $('#page-preloader').css('background-color', 'rgba(0,0,0,.5)');
        $('#page-preloader').css('display', 'block');
        $("#password-edit").hide();
        $("#password-check").show();
        $.ajax({
            url: base_url + "order/admin/get_admin_details",
            type: "post",
            data: { admin_id: formId },
            success: function(response) {
                var res = jQuery.parseJSON(response);
                if(res.status) {
                    res_data = res.data;
                    $('#email_id').val(res_data.email_id);
                    $('#email_id').attr("readonly", true);
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
