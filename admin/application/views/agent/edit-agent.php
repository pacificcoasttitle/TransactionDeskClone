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
      <div class="card-header">Edit Agent</div>
        <div class="card-body">        
            <form id="edit-agent" method="POST">
                <div class="form-group row">
                    <label for="first_name" class="col-sm-2 col-form-label">First Name<span class="required"> *</span></label>
                    <div class="col-sm-10">
                        <?php
                        // echo "<pre>"; print_r($first_name_error_msg); exit;
                            $first_name = isset($agent_info['first_name']) ? $agent_info['first_name'] : '';
                        ?>
                        <input type="text" class="form-control" name="first_name" id="first_name" value="<?php echo $first_name; ?>" class="form-control" placeholder="First Name">

                        <?php if(!empty($first_name_error_msg)){ ?>                     
                            <span class="error"><?php echo $first_name_error_msg; ?></span>
                        <?php } ?>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="last_name" class="col-sm-2 col-form-label">Last Name<span class="required"> *</span></label>
                    <div class="col-sm-10">
                        <?php 
                            $last_name = isset($agent_info['last_name']) ? $agent_info['last_name'] : '';
                        ?>
                        <input type="text" value="<?php echo $last_name; ?>" class="form-control" name="last_name" id="last_name" class="form-control" placeholder="Last Name">
                        <?php if(!empty($last_name_error_msg)){ ?>                     
                            <span class="error"><?php echo $last_name_error_msg; ?></span>
                        <?php } ?>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="email_address" class="col-sm-2 col-form-label">Email Address<span class="required"> *</span></label>
                    <div class="col-sm-10">
                        <?php 
                            $email_address = isset($agent_info['email_address']) ? $agent_info['email_address'] : '';
                        ?>
                        <input type="email" value="<?php echo $email_address; ?>" class="form-control" name="email_address" id="email_address" class="form-control" placeholder="Email Address">
                        <?php if(!empty($email_address_error_msg)){ ?>                     
                            <span class="error"><?php echo $email_address_error_msg; ?></span>
                        <?php } ?>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="telephone_no" class="col-sm-2 col-form-label">Telephone<span class="required"> *</span></label>
                    <div class="col-sm-10">
                        <?php 
                            $telephone_no = isset($agent_info['telephone_no']) ? $agent_info['telephone_no'] : '';
                        ?>
                        <input type="text" value="<?php echo $telephone_no; ?>" class="form-control" name="telephone_no" id="telephone_no" class="form-control" placeholder="Telephone">
                        <?php if(!empty($telephone_no_error_msg)){ ?>                     
                            <span class="error"><?php echo $telephone_no_error_msg; ?></span>
                        <?php } ?>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="company" class="col-sm-2 col-form-label">Company<span class="required"> *</span></label>
                    <div class="col-sm-10">
                        <?php
                        // echo "<pre>"; print_r($company_error_msg); exit;
                            $company = isset($agent_info['company']) ? $agent_info['company'] : '';
                        ?>
                        <input type="text" class="form-control" name="company" id="company" value="<?php echo $company; ?>" class="form-control" placeholder="Company">

                        <?php if(!empty($company_error_msg)){ ?>                     
                            <span class="error"><?php echo $company_error_msg; ?></span>
                        <?php } ?>
                    </div>
                </div>
                <div class="pull-right">
                    <button type="submit" class="btn btn-secondary">Update</button>
                    <a href="<?php echo base_url().'?agents'; ?>" id="cancel" name="cancel" class="btn btn-secondary">Cancel</a>
                </div>           
            </form>
        </div>
    </div>
</div>