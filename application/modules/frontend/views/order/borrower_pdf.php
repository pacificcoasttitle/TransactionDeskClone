<?php 

?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <!-- <title> Smart forms - multi-steps form </title> -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0"> 
</head>
<?php ?>
<body class="">
    <h2>1. Personal Info</h2>
    <table class="table table-bordered">
        <thead>
            <tr>
              <th scope="col">First Name</th>
              <th scope="col">Middle Name</th>
              <th scope="col">Last Name</th>
            </tr>
        </thead>
        <tbody>
            <tr>              
              <td><?php echo isset($borrower_info[0]['first_name']) && !empty($borrower_info[0]['first_name']) ? $borrower_info[0]['first_name'] : '-'; ?></td>
              <td><?php echo isset($borrower_info[0]['middle_name']) && !empty($borrower_info[0]['middle_name']) ? $borrower_info[0]['middle_name'] : '-'; ?></td>
              <td><?php echo isset($borrower_info[0]['last_name']) && !empty($borrower_info[0]['last_name']) ? $borrower_info[0]['last_name'] : ''; ?></td>
            </tr>
        </tbody>
    </table>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th scope="col">Home Phone</th>
                <th scope="col">Mobile Phone</th>
                <th scope="col">Date of Birth</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td><?php echo isset($borrower_info[0]['telephone']) && !empty($borrower_info[0]['telephone']) ? $borrower_info[0]['telephone'] : ''; ?></td>
                <td><?php echo isset($borrower_info[0]['mobile']) && !empty($borrower_info[0]['mobile']) ? $borrower_info[0]['mobile'] : ''; ?></td>

                <td><?php echo isset($borrower_info[0]['date_of_birth']) && !empty($borrower_info[0]['date_of_birth']) ? date("m/d/Y",strtotime($borrower_info[0]['date_of_birth'])) : ''; ?></td>
            </tr>
        </tbody>
    </table>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th scope="col">Birthplace</th>
                <th scope="col">Social Security No.</th>
                <th scope="col">Drivers Lic No</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td><?php echo isset($borrower_info[0]['birthplace']) && !empty($borrower_info[0]['birthplace']) ? $borrower_info[0]['birthplace'] : ''; ?></td>
                <td><?php echo isset($borrower_info[0]['ssn']) && !empty($borrower_info[0]['ssn']) ? $borrower_info[0]['ssn'] : ''; ?></td>
                <td><?php echo isset($borrower_info[0]['dln']) && !empty($borrower_info[0]['dln']) ? $borrower_info[0]['dln'] : ''; ?></td>
            </tr>
        </tbody>
    </table>
    <?php 
        /*if($borrower_info[0]['status'] == 'single')
        {*/
    ?>
            <table class="table table-bordered">
            
                <tr>
                    <th scope="col">Status</th>
                    <td><?php echo ucfirst($borrower_info[0]['status']); ?></td>
                </tr>
            </table>
    <?php
        /*}*/
    ?>
    <?php 
        if($borrower_info[0]['status'] == 'married')
        {
    ?>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th scope="col">Spouse First Name</th>
                        <th scope="col">Spouse Middle Name</th>
                        <th scope="col">Spouse Last Name</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td><?php echo isset($borrower_info[0]['spouse_first_name']) && !empty($borrower_info[0]['spouse_first_name']) ? $borrower_info[0]['spouse_first_name'] : ''; ?></td>
                        <td><?php echo isset($borrower_info[0]['spouse_middle_name']) && !empty($borrower_info[0]['spouse_middle_name']) ? $borrower_info[0]['spouse_middle_name'] : ''; ?></td>
                        <td><?php echo isset($borrower_info[0]['spouse_last_name']) && !empty($borrower_info[0]['spouse_last_name']) ? $borrower_info[0]['spouse_last_name'] : ''; ?></td>
                    </tr>
                </tbody>
            </table>

            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th scope="col">Spouse Home Phone</th>
                        <th scope="col">Spouse Mobile Phone</th>
                        <th scope="col">Spouse Date of Birth</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td><?php echo isset($borrower_info[0]['spouse_telephone']) && !empty($borrower_info[0]['spouse_telephone']) ? $borrower_info[0]['spouse_telephone'] : ''; ?></td>
                        <td><?php echo isset($borrower_info[0]['spouse_mobile']) && !empty($borrower_info[0]['spouse_mobile']) ? $borrower_info[0]['spouse_mobile'] : ''; ?></td>
                        <td><?php echo isset($borrower_info[0]['spouse_date_of_birth']) && !empty($borrower_info[0]['spouse_date_of_birth']) ? date("m/d/Y",strtotime($borrower_info[0]['spouse_date_of_birth'])) : ''; ?></td>
                    </tr>
                </tbody>
            </table>

            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th scope="col">Spouse Birthplace</th>
                        <th scope="col">Spouse Social Security No.</th>
                        <th scope="col">Spouse Drivers Lic No</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td><?php echo isset($borrower_info[0]['spouse_birthplace']) && !empty($borrower_info[0]['spouse_birthplace']) ? $borrower_info[0]['spouse_birthplace'] : ''; ?></td>
                        <td><?php echo isset($borrower_info[0]['spouse_ssn']) && !empty($borrower_info[0]['spouse_ssn']) ? $borrower_info[0]['spouse_ssn'] : ''; ?></td>
                        <td><?php echo isset($borrower_info[0]['spouse_dln']) && !empty($borrower_info[0]['spouse_dln']) ? $borrower_info[0]['spouse_dln'] : ''; ?></td>
                    </tr>
                </tbody>
            </table>
    <?php
        }
    ?>
    <?php 
        if($borrower_info[0]['status'] == 'domestic_partner')
        {
    ?>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th scope="col">Partner First Name</th>
                        <th scope="col">Partner Middle Name</th>
                        <th scope="col">Partner Last Name</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td><?php echo isset($borrower_info[0]['partner_first_name']) && !empty($borrower_info[0]['partner_first_name']) ? $borrower_info[0]['partner_first_name'] : ''; ?></td>
                        <td><?php echo isset($borrower_info[0]['partner_middle_name']) && !empty($borrower_info[0]['partner_middle_name']) ? $borrower_info[0]['partner_middle_name'] : ''; ?></td>
                        <td><?php echo isset($borrower_info[0]['partner_last_name']) && !empty($borrower_info[0]['partner_last_name']) ? $borrower_info[0]['partner_last_name'] : ''; ?></td>
                    </tr>
                </tbody>
            </table>

            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th scope="col">Partner Home Phone</th>
                        <th scope="col">Partner Mobile Phone</th>
                        <th scope="col">Partner Date of Birth</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td><?php echo isset($borrower_info[0]['partner_telephone']) && !empty($borrower_info[0]['partner_telephone']) ? $borrower_info[0]['partner_telephone'] : ''; ?></td>
                        <td><?php echo isset($borrower_info[0]['partner_mobile']) && !empty($borrower_info[0]['partner_mobile']) ? $borrower_info[0]['partner_mobile'] : ''; ?></td>
                        <td><?php echo isset($borrower_info[0]['partner_date_of_birth']) && !empty($borrower_info[0]['partner_date_of_birth']) ? date("m/d/Y",strtotime($borrower_info[0]['partner_date_of_birth'])) : ''; ?></td>
                    </tr>
                </tbody>
            </table>

            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th scope="col">Partner Birthplace</th>
                        <th scope="col">Partner Social Security No.</th>
                        <th scope="col">Partner Drivers Lic No</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td><?php echo isset($borrower_info[0]['partner_birthplace']) && !empty($borrower_info[0]['partner_birthplace']) ? $borrower_info[0]['partner_birthplace'] : ''; ?></td>
                        <td><?php echo isset($borrower_info[0]['partner_ssn']) && !empty($borrower_info[0]['partner_ssn']) ? $borrower_info[0]['partner_ssn'] : ''; ?></td>
                        <td><?php echo isset($borrower_info[0]['partner_dln']) && !empty($borrower_info[0]['partner_dln']) ? $borrower_info[0]['partner_dln'] : ''; ?></td>
                    </tr>
                </tbody>
            </table>
    <?php
        }
    ?>
    <?php 
        if(isset($borrower_residence_info) && !empty($borrower_residence_info))
        {
    ?>
            <h2>2. Residences</h2>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th scope="col">Residence Address</th>
                        <th scope="col">From</th>
                        <th scope="col">To</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                        foreach ($borrower_residence_info as $key => $value) 
                        {
                    ?>
                            <tr>
                                <td><?php echo isset($value['address']) && !empty($value['address']) ? $value['address'] : ''; ?></td>
                                <td><?php echo isset($value['from_date']) && !empty($value['from_date']) ? $value['from_date'] : ''; ?></td>
                                <td><?php echo isset($value['to_date']) && !empty($value['to_date']) ? $value['to_date'] : ''; ?></td>
                            </tr>
                    <?php
                        }
                    ?>
                </tbody>
            </table>
    <?php
        }
    ?>
    <?php 
        if(isset($borrower_employment_info) && !empty($borrower_employment_info))
        {
    ?>
            <h2>3. Employment</h2>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th scope="col">Business Name</th>
                        <th scope="col">Address</th>
                        <th scope="col">From</th>
                        <th scope="col">To</th>
                        <th scope="col">Partner Occupation</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                        foreach ($borrower_employment_info as $k => $v) 
                        {
                    ?>
                            <tr>
                                <td><?php echo isset($v['business_name']) && !empty($v['business_name']) ? $v['business_name'] : ''; ?></td>
                                <td><?php echo isset($v['address']) && !empty($v['address']) ? $v['address'] : ''; ?></td>
                                <td><?php echo isset($v['from_date']) && !empty($v['from_date']) ? $v['from_date'] : ''; ?></td>
                                <td><?php echo isset($v['to_date']) && !empty($v['to_date']) ? $v['to_date'] : ''; ?></td>
                                <td><?php echo isset($v['is_partner_info']) && !empty($v['is_partner_info']) ? 'Yes' : 'No'; ?></td>
                            </tr>                            
                    <?php
                        }
                    ?>
                </tbody>
            </table>
    <?php
        }
    ?>
    <?php
        if(isset($borrower_info[0]['partnership_status']) && !empty($borrower_info[0]['partnership_status']))
        {
    ?>
            <h2>4. Partnerships</h2>
            <table class="table table-bordered">
                <tr>
                    <th scope="col">Partnership Status</th>
                    <td><?php echo ucfirst($borrower_info[0]['partnership_status']); ?></td>
                </tr>
            </table>    
    <?php
        } 
    ?>
    
    <?php 
        if(isset($borrower_info[0]['partnership_status']) && !empty($borrower_info[0]['partnership_status']) && $borrower_info[0]['partnership_status'] == 'me')
        {
    ?>
            
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th scope="col">Prior Spouse Name</th>
                        <th scope="col">Reason For End</th>
                        <th scope="col">End</th>
                    </tr>
                </thead>
                <tbody>                    
                    <tr>
                        <td><?php echo isset($borrower_info[0]['prior_spouse_name']) && !empty($borrower_info[0]['prior_spouse_name']) ? $borrower_info[0]['prior_spouse_name'] : ''; ?></td>
                        <td><?php echo isset($borrower_info[0]['prior_spouse_reason']) && !empty($borrower_info[0]['prior_spouse_reason']) ? $borrower_info[0]['prior_spouse_reason'] : ''; ?></td>
                        <td><?php echo isset($borrower_info[0]['prior_spouse_end']) && !empty($borrower_info[0]['prior_spouse_end']) ? $borrower_info[0]['prior_spouse_end'] : ''; ?></td>
                    </tr>
                </tbody>
            </table>
    <?php
        }
    ?>

    <?php 
        if(isset($borrower_info[0]['partnership_status']) && !empty($borrower_info[0]['partnership_status']) && $borrower_info[0]['partnership_status'] == 'spouseonly')
        {
    ?>
            
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th scope="col">Current Spouse's Prior Spouse Name</th>
                        <th scope="col">Reason For End</th>
                        <th scope="col">End</th>
                    </tr>
                </thead>
                <tbody>                    
                    <tr>
                        <td><?php echo isset($borrower_info[0]['current_spouse_prior_spouse_name']) && !empty($borrower_info[0]['current_spouse_prior_spouse_name']) ? $borrower_info[0]['current_spouse_prior_spouse_name'] : ''; ?></td>
                        <td><?php echo isset($borrower_info[0]['current_spouse_prior_spouse_reason']) && !empty($borrower_info[0]['current_spouse_prior_spouse_reason']) ? $borrower_info[0]['current_spouse_prior_spouse_reason'] : ''; ?></td>
                        <td><?php echo isset($borrower_info[0]['current_spouse_prior_spouse_end']) && !empty($borrower_info[0]['current_spouse_prior_spouse_end']) ? $borrower_info[0]['current_spouse_prior_spouse_end'] : ''; ?></td>
                    </tr>
                </tbody>
            </table>
    <?php
        }
    ?>

    <?php 
        if(isset($borrower_info[0]['partnership_status']) && !empty($borrower_info[0]['partnership_status']) && $borrower_info[0]['partnership_status'] == 'both')
        {
    ?>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th scope="col">Prior Spouse Name</th>
                    <th scope="col">Reason For End</th>
                    <th scope="col">End</th>
                </tr>
            </thead>
            <tbody>                    
                <tr>
                    <td><?php echo isset($borrower_info[0]['prior_spouse_name']) && !empty($borrower_info[0]['prior_spouse_name']) ? $borrower_info[0]['prior_spouse_name'] : ''; ?></td>
                    <td><?php echo isset($borrower_info[0]['prior_spouse_reason']) && !empty($borrower_info[0]['prior_spouse_reason']) ? $borrower_info[0]['prior_spouse_reason'] : ''; ?></td>
                    <td><?php echo isset($borrower_info[0]['prior_spouse_end']) && !empty($borrower_info[0]['prior_spouse_end']) ? $borrower_info[0]['prior_spouse_end'] : ''; ?></td>
                </tr>
            </tbody>
        </table>            
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th scope="col">Current Spouse's Prior Spouse Name</th>
                    <th scope="col">Reason For End</th>
                    <th scope="col">End</th>
                </tr>
            </thead>
            <tbody>                    
                <tr>
                    <td><?php echo isset($borrower_info[0]['current_spouse_prior_spouse_name']) && !empty($borrower_info[0]['current_spouse_prior_spouse_name']) ? $borrower_info[0]['current_spouse_prior_spouse_name'] : ''; ?></td>
                    <td><?php echo isset($borrower_info[0]['current_spouse_prior_spouse_reason']) && !empty($borrower_info[0]['current_spouse_prior_spouse_reason']) ? $borrower_info[0]['current_spouse_prior_spouse_reason'] : ''; ?></td>
                    <td><?php echo isset($borrower_info[0]['current_spouse_prior_spouse_end']) && !empty($borrower_info[0]['current_spouse_prior_spouse_end']) ? $borrower_info[0]['current_spouse_prior_spouse_end'] : ''; ?></td>
                </tr>
            </tbody>
        </table>
    <?php
        }
    ?>

    <?php
        if(isset($borrower_info[0]['street_address']) && !empty($borrower_info[0]['street_address']))
        {
    ?>
            <h2>5. About The Property</h2>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th scope="col">Street Address</th>
                        <th scope="col">The land is unimproved</th>
                        <th scope="col">Type of property on land</th>
                        <th scope="col">Buyer Intends to reside</th>
                    </tr>
                </thead>
                <tbody>                    
                    <tr>
                        <td><?php echo isset($borrower_info[0]['street_address']) && !empty($borrower_info[0]['street_address']) ? $borrower_info[0]['street_address'] : ''; ?></td>
                        <td><?php echo isset($borrower_info[0]['land_is_unimproved']) && !empty($borrower_info[0]['land_is_unimproved']) ? ucfirst($borrower_info[0]['land_is_unimproved']) : ''; ?></td>
                        <td><?php echo isset($borrower_info[0]['type_of_property']) && !empty($borrower_info[0]['type_of_property']) ? ucfirst(str_replace('_', ' ', $borrower_info[0]['type_of_property'])) : ''; ?></td>
                        <td><?php echo isset($borrower_info[0]['buyer_intends_to_reside']) && !empty($borrower_info[0]['buyer_intends_to_reside']) ? ucfirst($borrower_info[0]['buyer_intends_to_reside']) : ''; ?></td>
                    </tr>
                </tbody>
            </table>   
    <?php
        } 
    ?>
</body>
</html>
