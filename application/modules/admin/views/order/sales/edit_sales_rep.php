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
      <div class="card-header">Edit Sales Rep</div>
        <div class="card-body">        
            <form id="frm-add-sales-rep" method="POST" enctype="multipart/form-data">
        
                <div class="form-group row">
                    <label for="sales_rep_first_name" class="col-sm-4 col-form-label">First Name<span class="required"> *</span></label>
                    <div class="col-sm-8">
                        <input type="text" class="form-control" name="sales_rep_first_name" id="sales_rep_first_name" class="form-control" placeholder="Enter Sales Rep. First Name" value="<?php echo isset($sales_rep_info['first_name']) && !empty($sales_rep_info['first_name']) ? $sales_rep_info['first_name'] : ''?>">
                        <?php if(!empty($first_name_error_msg)){ ?>                     
                            <span class="error"><?php echo $first_name_error_msg; ?></span>
                        <?php } ?>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="sales_rep_last_name" class="col-sm-4 col-form-label">Last Name<span class="required"> *</span></label>
                    <div class="col-sm-8">
                        <input type="text" class="form-control" name="sales_rep_last_name" id="sales_rep_last_name" class="form-control" placeholder="Enter Sales Rep. Last Name" value="<?php echo isset($sales_rep_info['last_name']) && !empty($sales_rep_info['last_name']) ? $sales_rep_info['last_name'] : ''?>">
                        <?php if(!empty($last_name_error_msg)){ ?>                     
                            <span class="error"><?php echo $last_name_error_msg; ?></span>
                        <?php } ?>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="email_address" class="col-sm-4 col-form-label">Email Address<span class="required"> *</span></label>
                    <div class="col-sm-8">
                        <input type="text" class="form-control" name="email_address" id="email_address" class="form-control" placeholder="Email Address" value="<?php echo isset($sales_rep_info['email_address']) && !empty($sales_rep_info['email_address']) ? $sales_rep_info['email_address'] : ''?>">
                        <?php if(!empty($email_error_msg)){ ?>                     
                            <span class="error"><?php echo $email_error_msg; ?></span>
                        <?php } ?>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="telephone" class="col-sm-4 col-form-label">Phone Number<span class="required"> *</span></label>
                    <div class="col-sm-8">
                        <input type="text" class="form-control" name="telephone" id="telephone" class="form-control" placeholder="Phone Number" value="<?php echo isset($sales_rep_info['telephone_no']) && !empty($sales_rep_info['telephone_no']) ? $sales_rep_info['telephone_no'] : ''?>">
                        <?php if(!empty($phone_error_msg)){ ?>                     
                            <span class="error"><?php echo $phone_error_msg; ?></span>
                        <?php } ?>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="partner_id" class="col-sm-4 col-form-label">Partner Id<span class="required"> *</span></label>
                    <div class="col-sm-8">
                        <input type="number" class="form-control" name="partner_id" id="partner_id" class="form-control" placeholder="Partner Id" value="<?php echo isset($sales_rep_info['partner_id']) && !empty($sales_rep_info['partner_id']) ? $sales_rep_info['partner_id'] : ''?>">
                        <?php if(!empty($partner_id_error_msg)){ ?>                     
                            <span class="error"><?php echo $partner_id_error_msg; ?></span>
                        <?php } ?>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="partner_type_id" class="col-sm-4 col-form-label">Partner Type Id<span class="required"> *</span></label>
                    <div class="col-sm-8">
                        <input type="number" class="form-control" name="partner_type_id" id="partner_type_id" class="form-control" placeholder="Partner Type Id" value="<?php echo isset($sales_rep_info['partner_type_id']) && !empty($sales_rep_info['partner_type_id']) ? $sales_rep_info['partner_type_id'] : ''?>">
                        <?php if(!empty($partner_type_id_error_msg)){ ?>                     
                            <span class="error"><?php echo $partner_type_id_error_msg; ?></span>
                        <?php } ?>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="sales_rep_no_of_open_orders" class="col-sm-4 col-form-label">Number of Open Orders<span class="required"> *</span></label>
                    <div class="col-sm-8">
                        <input type="text" class="form-control" name="sales_rep_no_of_open_orders" id="sales_rep_no_of_open_orders" value="<?php echo isset($sales_rep_info['sales_rep_no_of_open_orders']) && !empty($sales_rep_info['sales_rep_no_of_open_orders']) ? $sales_rep_info['sales_rep_no_of_open_orders'] : ''?>" class="form-control">
                        <?php if(!empty($sales_rep_no_of_open_orders_error_msg)){ ?>                     
                            <span class="error"><?php echo $sales_rep_no_of_open_orders_error_msg; ?></span>
                        <?php } ?>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="sales_rep_no_of_close_orders" class="col-sm-4 col-form-label">Number of Closed Orders<span class="required"> *</span></label>
                    <div class="col-sm-8">
                        <input type="text" class="form-control" name="sales_rep_no_of_close_orders" id="sales_rep_no_of_close_orders" value="<?php echo isset($sales_rep_info['sales_rep_no_of_close_orders']) && !empty($sales_rep_info['sales_rep_no_of_close_orders']) ? $sales_rep_info['sales_rep_no_of_close_orders'] : ''?>" class="form-control">
                        <?php if(!empty($sales_rep_no_of_close_orders_error_msg)){ ?>                     
                            <span class="error"><?php echo $sales_rep_no_of_close_orders_error_msg; ?></span>
                        <?php } ?>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="sales_rep_premium" class="col-sm-4 col-form-label">Revenue<span class="required"> *</span></label>
                    <div class="col-sm-8">
                        <input type="text" class="form-control" name="sales_rep_premium" id="sales_rep_premium" value="<?php echo isset($sales_rep_info['sales_rep_premium']) && !empty($sales_rep_info['sales_rep_premium']) ? $sales_rep_info['sales_rep_premium'] : ''?>" class="form-control">
                        <?php if(!empty($sales_rep_premium_error_msg)){ ?>                     
                            <span class="error"><?php echo $sales_rep_premium_error_msg; ?></span>
                        <?php } ?>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="sales_rep_profile_img" class="col-sm-4 col-form-label">Profile Img For Borrower Email</label>
                    <div class="col-sm-6">
                        <input type="file" class="form-control" name="sales_rep_profile_img" id="sales_rep_profile_img" accept=".png,.jpg" class="form-control">
                        <?php if(!empty($sales_rep_profile_img_error_msg)){ ?>                     
                            <span class="error"><?php echo $sales_rep_profile_img_error_msg; ?></span>
                        <?php } ?>
                    </div>
                    <div class="col-sm-4">
                        <?php
                            if(isset($sales_rep_info['sales_rep_profile_img']) && !empty($sales_rep_info['sales_rep_profile_img']))
                            {
                                if (env('AWS_ENABLE_FLAG') == 1) { 
                                    $sales_rep_info['sales_rep_profile_img'] = str_replace('uploads/', '', $sales_rep_info['sales_rep_profile_img']);
                                    $img = env('AWS_PATH').$sales_rep_info['sales_rep_profile_img'];
                                } else {
                                    $img = base_url().$sales_rep_info['sales_rep_profile_img'];
                                }
                                
                            }
                        ?>
                        <?php
                            if(isset($img) && !empty($img))
                            {
                        ?>
                                <img src="<?php echo $img; ?>" width="100" height="100">
                                <a href="javascript:void(0);" onclick="removeSalesRepProfileImg(<?php echo $sales_rep_info['id'];?>);">Remove img</a>
                        <?php
                            }
                        ?>
                        
                    </div>
                </div>

                <div class="form-group row">
                    <label for="sales_rep_profile_thank_you_img" class="col-sm-4 col-form-label">Profile Img For Thank you Email</label>
                    <div class="col-sm-6">
                        <input type="file" class="form-control" name="sales_rep_profile_thank_you_img" id="sales_rep_profile_thank_you_img" accept=".png,.jpg" class="form-control">
                        <?php if(!empty($sales_rep_profile_thank_you_img_error_msg)){ ?>                     
                            <span class="error"><?php echo $sales_rep_profile_thank_you_img_error_msg; ?></span>
                        <?php } ?>
                    </div>
                    <div class="col-sm-4">
                        <?php
                            if (env('AWS_ENABLE_FLAG') == 1) { 
                                $sales_rep_info['sales_rep_profile_thank_you_img'] = str_replace('uploads/', '', $sales_rep_info['sales_rep_profile_thank_you_img']);
                                $imgThank = env('AWS_PATH').$sales_rep_info['sales_rep_profile_thank_you_img'];
                            } else {
                                $imgThank = base_url().$sales_rep_info['sales_rep_profile_thank_you_img'];
                            }
                        ?>
                        <?php
                            if(isset($imgThank) && !empty($imgThank))
                            {
                        ?>
                                <img src="<?php echo $imgThank; ?>" width="100" height="100">
                                <a href="javascript:void(0);" onclick="removeSalesRepThankYouProfileImg(<?php echo $sales_rep_info['id'];?>);">Remove img</a>
                        <?php
                            }
                        ?>
                        
                    </div>
                </div>

                <div class="form-group row">
                    <label for="telephone" class="col-sm-4 col-form-label">&nbsp;</label>
                    <div class="col-sm-8">
                        <input type="checkbox" <?php echo ($sales_rep_info['is_mail_notification'] == 1) ?  'checked' : ''?> class="" style="height:18px;width:18px;margin-right:10px;" name="is_mail_notification" id="is_mail_notification" class="form-control" placeholder="Mail Notification">Mail Notification
                    </div>
                </div>
                
                <div class="pull-right">
                    <button type="submit" id="edit-sales-rep" name="add-sales-rep" class="btn btn-secondary">Update</button>
                    <a href="<?php echo site_url('order/admin/sales-rep'); ?>" id="cancel" name="cancel" class="btn btn-secondary">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</div>