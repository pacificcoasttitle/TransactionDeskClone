
<div class="container">
    <?php if(!empty($success_msg)){ ?>
        <div class="col-xs-12">
            <div class="alert alert-success"><?php echo $success_msg; ?></div>
        </div>
    <?php } ?>

    <?php if(!empty($error_msg)){ ?>
        <div class="col-xs-12">
            <div class="alert alert-danger"><?php echo $error_msg; ?></div>
        </div>
    <?php } ?>

    <div class="card mx-auto mt-5">
      <div class="card-header">Resware Admin Credential</div>
        <div class="card-body">        
            <form id="resware-admin-credential" method="POST">

                <div class="form-group row">
                    <label for="resware_username" class="col-sm-2 col-form-label">Username<span class="required"> *</span></label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" name="resware_username" id="resware_username" value="<?php echo  set_value('username') ?  set_value('username') : $credResult['username'];?>" class="form-control" placeholder="Resware Admin Username" required>
                    
                        <?php if(!empty($resware_username_error_msg)){ ?>                     
                            <span class="error"><?php echo $resware_username_error_msg; ?></span>
                        <?php } ?>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="resware_password" class="col-sm-2 col-form-label">Password<span class="required"> *</span></label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" name="resware_password" id="resware_password" value="<?php echo set_value('password') ?  set_value('password') : $credResult['password'];?>" class="form-control" placeholder="Resware Admin Password" required>
                        <?php if(!empty($resware_password_error_msg)){ ?>                     
                            <span class="error"><?php echo $resware_password_error_msg; ?></span>
                        <?php } ?>
                    </div>
                </div>
                   
                <div class="pull-right">
                    <button type="submit" class="btn btn-secondary">Save</button>
                </div>      
            </form>
        </div>
    </div>
</div>




