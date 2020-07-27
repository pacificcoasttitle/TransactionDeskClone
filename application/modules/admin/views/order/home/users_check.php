<?php 
// echo "<pre>"; print_r($users); exit;
?>
<div class="container-fluid">
    <!-- DataTables Example -->
    <div class="card mb-3">
        <div class="card-header">
            <i class="fas fa-table"></i>
            Primary Check
            <div class="float-right">
                <a href="<?php echo base_url()?>order/admin/import-lenders" class="btn btn-secondary"> Import </a>
                <a href="javascript:void(0);" data-export-type="csv" id="export-csv" class="btn btn-secondary"> Export </a>
            </div>
        </div>

                
        <div class="card-body">
            <div id="customer_success_msg" class="w-100 alert alert-success alert-dismissible" style="display:none;"></div>
            <div id="customer_error_msg" class="w-100 alert alert-danger alert-dismissible" style="display:none;"></div>
            <div class="table-responsive">
                <table class="table table-bordered" id="tbl-user-check-listing" style="table-layout: fixed;" cellspacing="0" width="100%">
                    <thead>
                        <tr>
                            <th style="width: 8%;">Resware User ID</th>
                            <th style="width: 8%;">Partner ID</th>
                            <th style="width: 10%;">First Name</th>
                            <th style="width: 10%;">Last Name</th>
                            <th style="width: 20%;">Email Address</th>
                            <th style="width: 15%;">Company</th>
                            <th style="width: 15%;">Credential</th>
                            <th style="width: 14%;">Action</th>
                        </tr>
                    </thead>                
                    <tbody>
                        <?php
                            if(isset($users) && !empty($users))
                            {
                                $i = 1;
                                foreach ($users as $key => $value) 
                                {
                                    $last_ele_key = array_key_last($value);
                                    $count = count($value);
                                    $class = '';
                                    foreach ($value as $k => $v) 
                                    {
                                        $checked = $disabled = $border = '';
                                        if($last_ele_key == $k)
                                        {
                                            $border = 'border-bottom:3px solid black';
                                        }
                                        if(isset($v['is_password_updated']) && !empty($v['is_password_updated']) && $v['is_primary'] == 1)
                                        {
                                            $checked = 'checked';
                                            
                                        }
                            ?>
                                        <tr>
                                            <td style="<?php echo $border; ?>"><?php echo $v['resware_user_id'];?></td>
                                            <td style="<?php echo $border; ?>"><?php echo $v['partner_id'];?></td>
                                            <td style="<?php echo $border; ?>"><?php echo $v['first_name'];?></td>
                                            <td style="<?php echo $border; ?>"><?php echo $v['last_name'];?></td>
                                            <td style="<?php echo $border; ?>">
                                                <input type="radio" name="email_address_<?php echo $i; ?>" data-id="<?php echo $v['id'];?>" <?php echo $checked; ?> value="<?php echo $v['email_address'];?>">
                                                <?php echo $v['email_address'];?>
                                                    
                                            </td>
                                            <td style="<?php echo $border; ?>"><?php echo $v['company_name']; ?></td>
                                            <?php
                                                    if ($v['is_password_updated'] == 1 )  
                                                    {
                                                        $credential = 'Correct';     
                                                    } 
                                                    else if($v['is_password_updated'] == 0 && !empty($v['random_password'])) 
                                                    {
                                                        $credential = 'Incorrect';     
                                                    } 
                                                    else 
                                                    {
                                                        $credential = 'Duplicate Email'; 
                                                    }
                                                ?>
                                            <td style="<?php echo $border; ?>">
                                                <?php echo $credential; ?>
                                            </td>
                                            <?php 
                                                if($k == 0)
                                                {
                                            ?>
                                                    <td style="vertical-align: middle; border-bottom: 3px solid black;" align="center" rowspan="<?php echo $count; ?>"><a href="javascript:void(0);" onclick="makePrimary(<?php echo $i; ?>);"  class="btn btn-secondary <?php echo $class; ?>"> Make Primary </a></td>
                                            <?php
                                                }
                                            ?>
                                            
                                        </tr>
                            <?php
                                    } 
                        ?>
                                    
                        <?php
                                    $i++;
                                }
                            } 
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div><!-- /.container-fluid -->