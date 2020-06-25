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
<div class="accordion md-accordion" id="accordionEx" role="tablist" aria-multiselectable="true">
    <div class="card mx-auto mt-5 mb-5" style="border-bottom: 1px solid rgba(0, 0, 0, 0.125);">
        <div class="card-header" role="tab" id="customerDetailsTab">
            <a data-toggle="collapse" style="color: #000000;" data-parent="#accordionEx" href="#customerDetails" aria-expanded="true"
            aria-controls="customerDetails">
                <h5 class="mb-0">
                Customer Details <i class="fas fa-angle-down rotate-icon"></i>
                </h5>
            </a>
        </div>
        <div id="customerDetails" class="collapse show" role="tabpanel" aria-labelledby="customerDetailsTab" data-parent="#accordionEx">
            <div class="card-body">
            <?php
                if(isset($customer_details['company_name']) && !empty($customer_details['company_name']))
                {
            ?>
                        <div class="form-group row">
                            <label for="name" class="col-sm-3 col-form-label">Company Name:</label>
                            <div class="col-sm-9 col-form-label">
                            <?php echo $customer_details['company_name'];
                            ?>
                            </div>
                        </div>
            <?php
                }
            ?>
            <?php
                if(isset($customer_details['email_address']) && !empty($customer_details['email_address']))
                {
            ?>
                    <div class="form-group row">
                        <label for="name" class="col-sm-3 col-form-label">Email Address:</label>
                        <div class="col-sm-9 col-form-label">
                        <?php echo $customer_details['email_address']; ?>
                        </div>
                    </div>
            <?php
                }
            ?>
            <?php
                if(isset($customer_details['first_name']) && !empty($customer_details['first_name']))
                {
            ?>
                    <div class="form-group row">
                        <label for="name" class="col-sm-3 col-form-label">First Name:</label>
                        <div class="col-sm-9 col-form-label">
                        <?php echo $customer_details['first_name']; ?>
                        </div>
                    </div>
            <?php
                }
            ?>
                
            <?php
                if(isset($customer_details['last_name']) && !empty($customer_details['last_name']))
                {
            ?>
                    <div class="form-group row">
                        <label for="name" class="col-sm-3 col-form-label">Last Name:</label>
                        <div class="col-sm-9 col-form-label">
                        <?php echo $customer_details['last_name']; ?>
                        </div>
                    </div>
            <?php
                }
            ?>    
                
            <?php
                if(isset($customer_details['telephone_no']) && !empty($customer_details['telephone_no']))
                {
            ?>
                    <div class="form-group row">
                        <label for="name" class="col-sm-3 col-form-label">Telephone:</label>
                        <div class="col-sm-9 col-form-label">
                        <?php echo $customer_details['telephone_no']; ?>
                        </div>
                    </div>
            <?php
                }
            ?>
                
            <?php
                if(isset($customer_details['street_address']) && !empty($customer_details['street_address']))
                {
            ?>
                    <div class="form-group row">
                        <label for="name" class="col-sm-3 col-form-label">Street Address:</label>
                        <div class="col-sm-9 col-form-label">
                        <?php echo $customer_details['street_address']; ?>
                        </div>
                    </div>
            <?php
                }
            ?>
                
            <?php
                if(isset($customer_details['city']) && !empty($customer_details['city']))
                {
            ?>
                    <div class="form-group row">
                        <label for="name" class="col-sm-3 col-form-label">City:</label>
                        <div class="col-sm-9 col-form-label">
                        <?php echo $customer_details['city']; ?>
                        </div>
                    </div>
            <?php
                }
            ?>
                
            <?php
                if(isset($customer_details['zip_code']) && !empty($customer_details['zip_code']))
                {
            ?>
                    <div class="form-group row">
                        <label for="name" class="col-sm-3 col-form-label">Zipcode:</label>
                        <div class="col-sm-9 col-form-label">
                        <?php echo $customer_details['zip_code']; ?>
                        </div>
                    </div>
            <?php
                }
            ?>
                
            </div>
        </div>
    </div>
    <div class="card mx-auto mt-5 mb-5" style="border-bottom: 1px solid rgba(0, 0, 0, 0.125);">
        <div class="card-header" role="tab" id="propertyDetailsTab">
            <a data-toggle="collapse" style="color: #000000;" data-parent="#accordionEx" href="#propertyDetails" aria-expanded="true"
            aria-controls="propertyDetails">
                <h5 class="mb-0">
                Property Details <i class="fas fa-angle-down rotate-icon"></i>
                </h5>
            </a>
        </div>
        <div id="propertyDetails" class="collapse show" role="tabpanel" aria-labelledby="propertyDetailsTab" data-parent="#accordionEx">
            <div class="card-body">        
                <?php
                    if(isset($order_details['full_address']) && !empty($order_details['full_address']))
                    {
                ?>
                        <div class="form-group row">
                            <label for="name" class="col-sm-3 col-form-label">Property Address:</label>
                            <div class="col-sm-9 col-form-label">
                                <?php echo $order_details['full_address']; ?>
                            </div>
                        </div>
                <?php
                    }
                ?>
                
                <?php
                    if(isset($order_details['apn']) && !empty($order_details['apn']))
                    {
                ?>
                        <div class="form-group row">
                            <label for="name" class="col-sm-3 col-form-label">APN:</label>
                            <div class="col-sm-9 col-form-label">
                                <?php echo $order_details['apn']; ?>
                            </div>
                        </div>
                <?php
                    }
                ?>
                
                <?php
                    if(isset($order_details['county']) && !empty($order_details['county']))
                    {
                ?>
                        <div class="form-group row">
                            <label for="name" class="col-sm-3 col-form-label">County:</label>
                            <div class="col-sm-9 col-form-label">
                            <?php echo $order_details['county']; ?>
                            </div>
                        </div>
                <?php
                    }
                ?>
                
                <?php
                    if(isset($order_details['legal_description']) && !empty($order_details['legal_description']))
                    {
                ?>
                        <div class="form-group row">
                            <label for="name" class="col-sm-3 col-form-label">Brief Legal Description:</label>
                            <div class="col-sm-9 col-form-label">
                            <?php echo $order_details['legal_description']; ?>
                            </div>
                        </div>
                <?php
                    }
                ?>
                
                <?php
                    if(isset($order_details['primary_owner']) && !empty($order_details['primary_owner']))
                    {
                ?>
                        <div class="form-group row">
                            <label for="name" class="col-sm-3 col-form-label">Primary Owner:</label>
                            <div class="col-sm-9 col-form-label">
                            <?php echo $order_details['primary_owner']; ?>
                            </div>
                        </div>
                <?php
                    }
                ?>
                
                <?php
                    if(isset($order_details['secondary_owner']) && !empty($order_details['secondary_owner']))
                    {
                ?>
                        <div class="form-group row">
                            <label for="name" class="col-sm-3 col-form-label">Secondary Owner:</label>
                            <div class="col-sm-9 col-form-label">
                            <?php echo $order_details['secondary_owner']; ?>
                            </div>
                        </div>      
                <?php
                    }
                ?>
                
                <?php
                    if(isset($order_details['borrower']) && !empty($order_details['borrower']))
                    {
                ?>
                        <div class="form-group row">
                            <label for="name" class="col-sm-3 col-form-label">Primary Borrower:</label>
                            <div class="col-sm-9 col-form-label">
                            <?php echo $order_details['borrower']; ?>
                            </div>
                        </div>       
                <?php
                    }
                ?>
                
                <?php
                    if(isset($order_details['secondary_borrower']) && !empty($order_details['secondary_borrower']))
                    {   
                ?>
                        <div class="form-group row">
                            <label for="name" class="col-sm-3 col-form-label">Secondary Borrower:</label>
                            <div class="col-sm-9 col-form-label">
                            <?php echo $order_details['secondary_borrower']; ?>
                            </div>
                        </div>
                <?php
                    }
                ?>
                
            </div>
        </div>
    </div>

    <div class="card mx-auto mt-5 mb-5" style="border-bottom: 1px solid rgba(0, 0, 0, 0.125);">
        <div class="card-header" role="tab" id="transactionDetailsTab">
            <a data-toggle="collapse" style="color: #000000;" data-parent="#accordionEx" href="#transactionDetails" aria-expanded="true"
            aria-controls="transactionDetails">
                <h5 class="mb-0">
                Transaction Details <i class="fas fa-angle-down rotate-icon"></i>
                </h5>
            </a>
        </div>
        <div id="transactionDetails" class="collapse show" role="tabpanel" aria-labelledby="transactionDetailsTab" data-parent="#accordionEx">
            <div class="card-body">        
                <?php
                    if(isset($order_details['sales_rep_name']) && !empty($order_details['sales_rep_name']))
                    {
                ?>
                        <div class="form-group row">
                            <label for="name" class="col-sm-3 col-form-label">Sales Rep:</label>
                            <div class="col-sm-9 col-form-label">
                                <?php echo $order_details['sales_rep_name']; ?>
                            </div>
                        </div>
                <?php
                    }
                ?>
                
                <?php
                    if(isset($order_details['title_officer_name']) && !empty($order_details['title_officer_name']))
                    {
                ?>
                        <div class="form-group row">
                            <label for="name" class="col-sm-3 col-form-label">Title Officer:</label>
                            <div class="col-sm-9 col-form-label">
                                <?php echo $order_details['title_officer_name']; ?>
                            </div>
                        </div>
                <?php
                    }
                ?>
                
                <?php
                    if(isset($order_details['product_type']) && !empty($order_details['product_type']))
                    {
                ?>
                        <div class="form-group row">
                            <label for="name" class="col-sm-3 col-form-label">Product:</label>
                            <div class="col-sm-9 col-form-label">
                            <?php echo $order_details['product_type']; ?>
                            </div>
                        </div>
                <?php
                    }
                ?>
                <?php
                    if(isset($order_details['loan_amount']) && !empty($order_details['loan_amount']))
                    {
                ?>
                        <div class="form-group row">
                            <label for="name" class="col-sm-3 col-form-label">Loan Amount:</label>
                            <div class="col-sm-9 col-form-label">
                            <?php echo $order_details['loan_amount']; ?>
                            </div>
                        </div>
                <?php
                    }
                ?><?php
                    if(isset($order_details['sales_amount']) && !empty($order_details['sales_amount']))
                    {
                ?>
                        <div class="form-group row">
                            <label for="name" class="col-sm-3 col-form-label">Sales Amount:</label>
                            <div class="col-sm-9 col-form-label">
                            <?php echo $order_details['sales_amount']; ?>
                            </div>
                        </div>
                <?php
                    }
                ?>
                
                <?php
                    if(isset($order_details['loan_number']) && !empty($order_details['loan_number']))
                    {
                ?>
                        <div class="form-group row">
                            <label for="name" class="col-sm-3 col-form-label">Loan Number:</label>
                            <div class="col-sm-9 col-form-label">
                            <?php echo $order_details['loan_number']; ?>
                            </div>
                        </div>
                <?php
                    }
                ?>

                <?php
                    if(isset($order_details['escrow_number']) && !empty($order_details['escrow_number']))
                    {
                ?>
                        <div class="form-group row">
                            <label for="name" class="col-sm-3 col-form-label">Escrow Number:</label>
                            <div class="col-sm-9 col-form-label">
                            <?php echo $order_details['escrow_number']; ?>
                            </div>
                        </div>
                <?php
                    }
                ?>
                
                <?php
                    if(isset($order_details['notes']) && !empty($order_details['notes']))
                    {
                ?>
                        <div class="form-group row">
                            <label for="name" class="col-sm-3 col-form-label">Additional Details:</label>
                            <div class="col-sm-9 col-form-label">
                            <?php echo $order_details['notes']; ?>
                            </div>
                        </div>
                <?php
                    }
                ?>
                
                
            </div>
        </div>
    </div> 

    <div class="card mx-auto mt-5 mb-5" style="border-bottom: 1px solid rgba(0, 0, 0, 0.125);">
        <div class="card-header" role="tab" id="deliverablesDetailsTab">
            <a data-toggle="collapse" style="color: #000000;" data-parent="#accordionEx" href="#deliverablesDetails" aria-expanded="true"
            aria-controls="deliverablesDetails">
                <h5 class="mb-0">
                Deliverables Details <i class="fas fa-angle-down rotate-icon"></i>
                </h5>
            </a>
        </div>
        <div id="deliverablesDetails" class="collapse show" role="tabpanel" aria-labelledby="deliverablesDetailsTab" data-parent="#accordionEx">
            <div class="card-body">        
                <?php
                    if(isset($order_details['additional_emails']) && !empty($order_details['additional_emails']))
                    {
                ?>
                        <div class="form-group row">
                            <label for="name" class="col-sm-3 col-form-label">Sales Rep:</label>
                            <div class="col-sm-9 col-form-label">
                                <?php echo $order_details['additional_emails']; ?>
                            </div>
                        </div>
                <?php
                    }
                ?>
            </div>
        </div>
    </div>    
</div>
</div>