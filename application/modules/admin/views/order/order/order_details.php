<style>
.bootstrap-select:not([class*="col-"]):not([class*="form-control"]):not(.input-group-btn) {
    width: -webkit-fill-available;
}
.accordion > .card.managerInfoCard {
	overflow: initial;
}
.remove-btn-holder {
	position: absolute;
    right: -20px;
    top: -30px;
}
.remove-btn-holder .threshold-remove-btn {
    border-radius: 50%;
}
.accordion .commission-details .card{
	border-bottom: 1px solid rgba(0,0,0,.125) !important;
	border-bottom-left-radius: 0.25rem !important;
	border-bottom-right-radius: 0.25rem !important;
	margin-bottom:25px;
}

.threshold__amounts .clone-main-div .remove-btn-holder {
	display: none;
}
.commission-details .nav-pills .nav-link.active {
   position: relative;
}

.commission-details .nav-pills .nav-link.active:before {
    content: '';
    position: absolute;
    top: 0;
    right: 0;
    border-top: 23px solid #fff;
    border-bottom: 23px solid #fff;
    border-left: 29px solid transparent;
}
</style>

<div class="pct-admin-listing">
    <!-- Page Header -->
    <div class="page-header">
        <h1><i class="fas fa-file-alt"></i> Order Details</h1>
        <div class="action-buttons">
            <a href="<?php echo base_url() . 'order/admin/orders'; ?>" class="btn-action btn-action-secondary">
                <i class="fas fa-arrow-left"></i> Back to Orders
            </a>
        </div>
    </div>

    <?php if(!empty($success_msg)){ ?>
        <div class="alert-modern alert-success-modern"><?php echo $success_msg; ?></div>
    <?php } ?>
    <?php if(!empty($error_msg)){ ?>
        <div class="alert-modern alert-danger-modern"><?php echo $error_msg; ?></div>
    <?php } ?>

    <!-- Order Details Card -->
    <div class="modern-card">
        <div class="modern-card-header">
            <h2><i class="fas fa-clipboard-list"></i> Order Information</h2>
        </div>
        <div class="modern-card-body" style="padding: 24px;">
            <div class="modern-accordion" id="accordionEx">

                <!-- 1. Order Details Section -->
                <div class="accordion-section">
                    <a class="accordion-trigger" data-toggle="collapse" data-parent="#accordionEx" href="#orderDetails" aria-expanded="true" aria-controls="orderDetails">
                        <span class="accordion-trigger-title">
                            <i class="fas fa-info-circle"></i> Order Details
                        </span>
                        <i class="fas fa-chevron-down accordion-chevron"></i>
                    </a>
                    <div id="orderDetails" class="collapse show" data-parent="#accordionEx">
                        <div class="accordion-body">
                            <?php
                                if(isset($order_details['file_number']) && !empty($order_details['file_number']))
                                {
                            ?>
                                    <div class="detail-row">
                                        <div class="detail-label">Order Number</div>
                                        <div class="detail-value"><?php echo $order_details['file_number']; ?></div>
                                    </div>
                            <?php
                                } else if(isset($order_details['lp_file_number']) && !empty($order_details['lp_file_number'])) {
                            ?>
                                    <div class="detail-row">
                                        <div class="detail-label">Order Number</div>
                                        <div class="detail-value"><?php echo $order_details['lp_file_number']; ?></div>
                                    </div>
                            <?php
                                } 
                            ?>
                            <?php
                                if(isset($order_details['file_id']) && !empty($order_details['file_id']))
                                {
                            ?>
                                    <div class="detail-row">
                                        <div class="detail-label">File ID</div>
                                        <div class="detail-value"><?php echo $order_details['file_id']; ?></div>
                                    </div>
                            <?php
                                }
                            ?>
                            <?php
                                if(isset($order_details['opened_date']) && !empty($order_details['opened_date']))
                                {
                            ?>
                                    <div class="detail-row">
                                        <div class="detail-label">Order Opened At</div>
                                        <div class="detail-value"><?php echo date("m/d/Y h:i:s A", strtotime($order_details['opened_date'])); ?></div>
                                    </div>
                            <?php
                                }
                            ?>
                        </div>
                    </div>
                </div>

                <!-- 2. Customer Details Section -->
                <div class="accordion-section">
                    <a class="accordion-trigger collapsed" data-toggle="collapse" data-parent="#accordionEx" href="#customerDetails" aria-expanded="false" aria-controls="customerDetails">
                        <span class="accordion-trigger-title">
                            <i class="fas fa-user-tie"></i> Customer Details
                        </span>
                        <i class="fas fa-chevron-down accordion-chevron"></i>
                    </a>
                    <div id="customerDetails" class="collapse" data-parent="#accordionEx">
                        <div class="accordion-body">
                            <?php
                            if(
                                (isset($order_details['cust_company_name']) && !empty($order_details['cust_company_name']) && ($order_details['is_softpro_order'] == 0))
                                ||
                                (isset($order_details['sp_cust_company_name']) && !empty($order_details['sp_cust_company_name']) && ($order_details['is_softpro_order'] == 1))
                                )
                            {
                            ?>
                                    <div class="detail-row">
                                        <div class="detail-label">Company Name</div>
                                        <div class="detail-value">
                                        <?php 
                                        if ($order_details['is_softpro_order'] == 1) {
                                            echo $order_details['sp_cust_company_name'];
                                        } else {
                                            echo $order_details['cust_company_name'];
                                        }
                                        ?>
                                        </div>
                                    </div>
                            <?php
                                }
                            ?>
                            <?php
                            if(
                                (isset($order_details['cust_email_address']) && !empty($order_details['cust_email_address']) && ($order_details['is_softpro_order'] == 0))
                                ||
                                (isset($order_details['sp_cust_email_address']) && !empty($order_details['sp_cust_email_address']) && ($order_details['is_softpro_order'] == 1))
                                )
                            {
                            ?>
                                    <div class="detail-row">
                                        <div class="detail-label">Email Address</div>
                                        <div class="detail-value">
                                        <?php 
                                        if ($order_details['is_softpro_order'] == 1) {
                                            echo $order_details['sp_cust_email_address'];
                                        } else {
                                            echo $order_details['cust_email_address'];
                                        }
                                        ?>
                                        </div>
                                    </div>
                            <?php
                                }
                            ?>
                            <?php
                            if(
                                (isset($order_details['cust_first_name']) && !empty($order_details['cust_first_name']) && ($order_details['is_softpro_order'] == 0))
                                ||
                                (isset($order_details['sp_cust_first_name']) && !empty($order_details['sp_cust_first_name']) && ($order_details['is_softpro_order'] == 1))
                                )
                            {
                            ?>
                                    <div class="detail-row">
                                        <div class="detail-label">First Name</div>
                                        <div class="detail-value">
                                        <?php 
                                        if ($order_details['is_softpro_order'] == 1) {
                                            echo $order_details['sp_cust_first_name'];
                                        } else {
                                            echo $order_details['cust_first_name'];
                                        }
                                        ?>
                                        </div>
                                    </div>
                            <?php
                                }
                            ?>
                            <?php
                            if(
                                (isset($order_details['cust_last_name']) && !empty($order_details['cust_last_name']) && ($order_details['is_softpro_order'] == 0))
                                ||
                                (isset($order_details['sp_cust_last_name']) && !empty($order_details['sp_cust_last_name']) && ($order_details['is_softpro_order'] == 1))
                                )
                            {
                            ?>
                                    <div class="detail-row">
                                        <div class="detail-label">Last Name</div>
                                        <div class="detail-value">
                                        <?php 
                                        if ($order_details['is_softpro_order'] == 1) {
                                            echo $order_details['sp_cust_last_name'];
                                        } else {
                                            echo $order_details['cust_last_name'];
                                        }
                                        ?>
                                        </div>
                                    </div>
                            <?php
                                }
                            ?>
                            <?php
                            if(
                                (isset($order_details['cust_telephone_no']) && !empty($order_details['cust_telephone_no']) && ($order_details['is_softpro_order'] == 0))
                                ||
                                (isset($order_details['sp_cust_telephone_no']) && !empty($order_details['sp_cust_telephone_no']) && ($order_details['is_softpro_order'] == 1))
                                )
                            {
                            ?>
                                    <div class="detail-row">
                                        <div class="detail-label">Telephone</div>
                                        <div class="detail-value">
                                        <?php 
                                        if ($order_details['is_softpro_order'] == 1) {
                                            echo $order_details['sp_cust_telephone_no'];
                                        } else {
                                            echo $order_details['cust_telephone_no'];
                                        }
                                        ?>
                                        </div>
                                    </div>
                            <?php
                                }
                            ?>
                            <?php
                            if(
                                (isset($order_details['cust_street_address']) && !empty($order_details['cust_street_address']) && ($order_details['is_softpro_order'] == 0))
                                ||
                                (isset($order_details['sp_cust_street_address']) && !empty($order_details['sp_cust_street_address']) && ($order_details['is_softpro_order'] == 1))
                                )
                            {
                            ?>
                                    <div class="detail-row">
                                        <div class="detail-label">Street Address</div>
                                        <div class="detail-value">
                                        <?php 
                                        if ($order_details['is_softpro_order'] == 1) {
                                            echo $order_details['sp_cust_street_address'];
                                        } else {
                                            echo $order_details['cust_street_address'];
                                        }
                                        ?>
                                        </div>
                                    </div>
                            <?php
                                }
                            ?>
                            <?php
                            if(
                                (isset($order_details['cust_city']) && !empty($order_details['cust_city']) && ($order_details['is_softpro_order'] == 0))
                                ||
                                (isset($order_details['sp_cust_city']) && !empty($order_details['sp_cust_city']) && ($order_details['is_softpro_order'] == 1))
                                )
                            {
                            ?>
                                    <div class="detail-row">
                                        <div class="detail-label">City</div>
                                        <div class="detail-value">
                                        <?php 
                                        if ($order_details['is_softpro_order'] == 1) {
                                            echo $order_details['sp_cust_city'];
                                        } else {
                                            echo $order_details['cust_city'];
                                        }
                                        ?>
                                        </div>
                                    </div>
                            <?php
                                }
                            ?>
                            <?php
                            if(
                                (isset($order_details['cust_zip_code']) && !empty($order_details['cust_zip_code']) && ($order_details['is_softpro_order'] == 0))
                                ||
                                (isset($order_details['sp_cust_zip_code']) && !empty($order_details['sp_cust_zip_code']) && ($order_details['is_softpro_order'] == 1))
                                )
                            {
                            ?>
                                    <div class="detail-row">
                                        <div class="detail-label">Zipcode</div>
                                        <div class="detail-value">
                                        <?php 
                                        if ($order_details['is_softpro_order'] == 1) {
                                            echo $order_details['sp_cust_zip_code'];
                                        } else {
                                            echo $order_details['cust_zip_code'];
                                        }
                                        ?>
                                        </div>
                                    </div>
                            <?php
                                }
                            ?>
                        </div>
                    </div>
                </div>

                <!-- 3. Property Details Section -->
                <div class="accordion-section">
                    <a class="accordion-trigger collapsed" data-toggle="collapse" data-parent="#accordionEx" href="#propertyDetails" aria-expanded="false" aria-controls="propertyDetails">
                        <span class="accordion-trigger-title">
                            <i class="fas fa-home"></i> Property Details
                        </span>
                        <i class="fas fa-chevron-down accordion-chevron"></i>
                    </a>
                    <div id="propertyDetails" class="collapse" data-parent="#accordionEx">
                        <div class="accordion-body">
                            <?php
                                if(isset($order_details['full_address']) && !empty($order_details['full_address']))
                                {
                            ?>
                                    <div class="detail-row">
                                        <div class="detail-label">Property Address</div>
                                        <div class="detail-value"><?php echo $order_details['full_address']; ?></div>
                                    </div>
                            <?php
                                }
                            ?>
                            <?php
                                if(isset($order_details['apn']) && !empty($order_details['apn']))
                                {
                            ?>
                                    <div class="detail-row">
                                        <div class="detail-label">APN</div>
                                        <div class="detail-value"><?php echo $order_details['apn']; ?></div>
                                    </div>
                            <?php
                                }
                            ?>
                            <?php
                                if(isset($order_details['county']) && !empty($order_details['county']))
                                {
                            ?>
                                    <div class="detail-row">
                                        <div class="detail-label">County</div>
                                        <div class="detail-value"><?php echo $order_details['county']; ?></div>
                                    </div>
                            <?php
                                }
                            ?>
                            <?php
                                if(isset($order_details['legal_description']) && !empty($order_details['legal_description']))
                                {
                            ?>
                                    <div class="detail-row">
                                        <div class="detail-label">Brief Legal Description</div>
                                        <div class="detail-value"><?php echo $order_details['legal_description']; ?></div>
                                    </div>
                            <?php
                                }
                            ?>
                            <?php
                                if(isset($order_details['primary_owner']) && !empty($order_details['primary_owner']))
                                {
                            ?>
                                    <div class="detail-row">
                                        <div class="detail-label">Primary Owner</div>
                                        <div class="detail-value"><?php echo $order_details['primary_owner']; ?></div>
                                    </div>
                            <?php
                                }
                            ?>
                            <?php
                                if(isset($order_details['secondary_owner']) && !empty($order_details['secondary_owner']))
                                {
                            ?>
                                    <div class="detail-row">
                                        <div class="detail-label">Secondary Owner</div>
                                        <div class="detail-value"><?php echo $order_details['secondary_owner']; ?></div>
                                    </div>
                            <?php
                                }
                            ?>
                            <?php
                                if(isset($order_details['borrower']) && !empty($order_details['borrower']))
                                {
                            ?>
                                    <div class="detail-row">
                                        <div class="detail-label">Primary Borrower</div>
                                        <div class="detail-value"><?php echo $order_details['borrower']; ?></div>
                                    </div>
                            <?php
                                }
                            ?>
                            <?php
                                if(isset($order_details['secondary_borrower']) && !empty($order_details['secondary_borrower']))
                                {   
                            ?>
                                    <div class="detail-row">
                                        <div class="detail-label">Secondary Borrower</div>
                                        <div class="detail-value"><?php echo $order_details['secondary_borrower']; ?></div>
                                    </div>
                            <?php
                                }
                            ?>
                        </div>
                    </div>
                </div>

                <!-- 4. Transaction Details Section -->
                <div class="accordion-section">
                    <a class="accordion-trigger collapsed" data-toggle="collapse" data-parent="#accordionEx" href="#transactionDetails" aria-expanded="false" aria-controls="transactionDetails">
                        <span class="accordion-trigger-title">
                            <i class="fas fa-exchange-alt"></i> Transaction Details
                        </span>
                        <i class="fas fa-chevron-down accordion-chevron"></i>
                    </a>
                    <div id="transactionDetails" class="collapse" data-parent="#accordionEx">
                        <div class="accordion-body">
                            <?php
                                if((isset($order_details['sales_rep_name']) && !empty($order_details['sales_rep_name'])) || (isset($order_details['sp_sales_rep_name']) && !empty($order_details['sp_sales_rep_name'])))
                                {
                            ?>
                                    <div class="detail-row">
                                        <div class="detail-label">Sales Rep</div>
                                        <div class="detail-value">
                                        <?php 
                                            if ($order_details['is_softpro_order'] == 1) {
                                                echo $order_details['sp_sales_rep_name'];
                                            } else {
                                                echo $order_details['sales_rep_name'];
                                            }
                                        ?>
                                        </div>
                                    </div>
                            <?php
                                }
                            ?>
                            <?php
                                if(isset($order_details['title_officer_name']) && !empty($order_details['title_officer_name']) || isset($order_details['sp_title_officer_name']) && !empty($order_details['sp_title_officer_name']))
                                {
                            ?>
                                    <div class="detail-row">
                                        <div class="detail-label">Title Officer</div>
                                        <div class="detail-value">
                                        <?php 
                                            if ($order_details['is_softpro_order'] == 1) {
                                                echo $order_details['sp_title_officer_name'];
                                            } else {
                                                echo $order_details['title_officer_name']; 
                                            }
                                        ?>
                                        </div>
                                    </div>
                            <?php
                                }
                            ?>
                            <?php
                                if(isset($order_details['product_type']) && !empty($order_details['product_type']))
                                {
                            ?>
                                    <div class="detail-row">
                                        <div class="detail-label">Product</div>
                                        <div class="detail-value">
                                        <?php 
                                            if ($order_details['is_softpro_order'] == 1) {
                                                echo $order_details['sp_product_type_name'];
                                            } else {
                                                echo $order_details['product_type_name']; 
                                            }
                                        ?>
                                        </div>
                                    </div>
                            <?php
                                }
                            ?>
                            <?php
                                if(isset($order_details['loan_amount']) && !empty($order_details['loan_amount']))
                                {
                            ?>
                                    <div class="detail-row">
                                        <div class="detail-label">Loan Amount</div>
                                        <div class="detail-value"><?php echo $order_details['loan_amount']; ?></div>
                                    </div>
                            <?php
                                }
                            ?>
                            <?php
                                if(isset($order_details['sales_amount']) && !empty($order_details['sales_amount']))
                                {
                            ?>
                                    <div class="detail-row">
                                        <div class="detail-label">Sales Amount</div>
                                        <div class="detail-value"><?php echo $order_details['sales_amount']; ?></div>
                                    </div>
                            <?php
                                }
                            ?>
                            <?php
                                if(isset($order_details['loan_number']) && !empty($order_details['loan_number']))
                                {
                            ?>
                                    <div class="detail-row">
                                        <div class="detail-label">Loan Number</div>
                                        <div class="detail-value"><?php echo $order_details['loan_number']; ?></div>
                                    </div>
                            <?php
                                }
                            ?>
                            <?php
                                if(isset($order_details['escrow_number']) && !empty($order_details['escrow_number']))
                                {
                            ?>
                                    <div class="detail-row">
                                        <div class="detail-label">Escrow Number</div>
                                        <div class="detail-value"><?php echo $order_details['escrow_number']; ?></div>
                                    </div>
                            <?php
                                }
                            ?>
                            <?php
                                if(isset($order_details['notes']) && !empty($order_details['notes']))
                                {
                            ?>
                                    <div class="detail-row">
                                        <div class="detail-label">Additional Details</div>
                                        <div class="detail-value"><?php echo $order_details['notes']; ?></div>
                                    </div>
                            <?php
                                }
                            ?>
                        </div>
                    </div>
                </div>

                <!-- 5. Deliverables Details Section (Conditional) -->
                <?php
                    if(isset($order_details['additional_emails']) && !empty($order_details['additional_emails']))
                    {
                ?>
                <div class="accordion-section">
                    <a class="accordion-trigger collapsed" data-toggle="collapse" data-parent="#accordionEx" href="#deliverablesDetails" aria-expanded="false" aria-controls="deliverablesDetails">
                        <span class="accordion-trigger-title">
                            <i class="fas fa-truck"></i> Deliverables Details
                        </span>
                        <i class="fas fa-chevron-down accordion-chevron"></i>
                    </a>
                    <div id="deliverablesDetails" class="collapse" data-parent="#accordionEx">
                        <div class="accordion-body">
                            <div class="detail-row">
                                <div class="detail-label">Email Address</div>
                                <div class="detail-value"><?php echo $order_details['additional_emails']; ?></div>
                            </div>
                        </div>
                    </div>
                </div>
                <?php
                    }
                ?>

                <!-- 6. Buyer Agent Details Section (Conditional) -->
                <?php 
                    if(isset($order_details['buyer_agent_id']) && !empty($order_details['buyer_agent_id']))
                    {
                ?>
                <div class="accordion-section">
                    <a class="accordion-trigger collapsed" data-toggle="collapse" data-parent="#accordionEx" href="#buyerAgentDetails" aria-expanded="false" aria-controls="buyerAgentDetails">
                        <span class="accordion-trigger-title">
                            <i class="fas fa-user-tag"></i> Buyer Agent Details
                        </span>
                        <i class="fas fa-chevron-down accordion-chevron"></i>
                    </a>
                    <div id="buyerAgentDetails" class="collapse" data-parent="#accordionEx">
                        <div class="accordion-body">
                            <?php
                            if(
                                (isset($order_details['buyer_agent_name']) && !empty($order_details['buyer_agent_name']) && ($order_details['is_softpro_order'] == 0))
                                ||
                                (isset($order_details['sp_buyer_agent_name']) && !empty($order_details['sp_buyer_agent_name']) && ($order_details['is_softpro_order'] == 1))
                                )
                            {
                            ?>
                                    <div class="detail-row">
                                        <div class="detail-label">Buyer Agent Name</div>
                                        <div class="detail-value">
                                        <?php 
                                        if ($order_details['is_softpro_order'] == 1) {
                                            echo $order_details['sp_buyer_agent_name'];
                                        } else {
                                            echo $order_details['buyer_agent_name'];
                                        }
                                        ?>
                                        </div>
                                    </div>
                            <?php
                                }
                            ?>
                            <?php
                            if(
                                (isset($order_details['buyer_agent_email_address']) && !empty($order_details['buyer_agent_email_address']) && ($order_details['is_softpro_order'] == 0))
                                ||
                                (isset($order_details['sp_buyer_agent_email_address']) && !empty($order_details['sp_buyer_agent_email_address']) && ($order_details['is_softpro_order'] == 1))
                                )
                            {
                            ?>
                                    <div class="detail-row">
                                        <div class="detail-label">Buyer Agent Email</div>
                                        <div class="detail-value">
                                        <?php 
                                        if ($order_details['is_softpro_order'] == 1) {
                                            echo $order_details['sp_buyer_agent_email_address'];
                                        } else {
                                            echo $order_details['buyer_agent_email_address'];
                                        }
                                        ?>
                                        </div>
                                    </div>
                            <?php
                                }
                            ?>
                            <?php
                            if(
                                (isset($order_details['buyer_agent_company']) && !empty($order_details['buyer_agent_company']) && ($order_details['is_softpro_order'] == 0))
                                ||
                                (isset($order_details['sp_buyer_agent_company']) && !empty($order_details['sp_buyer_agent_company']) && ($order_details['is_softpro_order'] == 1))
                                )
                            {
                            ?>
                                    <div class="detail-row">
                                        <div class="detail-label">Buyer Agent Company</div>
                                        <div class="detail-value">
                                        <?php 
                                        if ($order_details['is_softpro_order'] == 1) {
                                            echo $order_details['sp_buyer_agent_company'];
                                        } else {
                                            echo $order_details['buyer_agent_company'];
                                        }
                                        ?>
                                        </div>
                                    </div>
                            <?php
                                }
                            ?>
                            <?php
                            if(
                                (isset($order_details['buyer_agent_telephone_no']) && !empty($order_details['buyer_agent_telephone_no']) && ($order_details['is_softpro_order'] == 0))
                                ||
                                (isset($order_details['sp_buyer_agent_telephone_no']) && !empty($order_details['sp_buyer_agent_telephone_no']) && ($order_details['is_softpro_order'] == 1))
                                )
                            {
                            ?>
                                    <div class="detail-row">
                                        <div class="detail-label">Buyer Agent Telephone</div>
                                        <div class="detail-value">
                                        <?php 
                                        if ($order_details['is_softpro_order'] == 1) {
                                            echo $order_details['sp_buyer_agent_telephone_no'];
                                        } else {
                                            echo $order_details['buyer_agent_telephone_no'];
                                        }
                                        ?>
                                        </div>
                                    </div>
                            <?php
                                }
                            ?>
                        </div>
                    </div>
                </div>
                <?php
                    }
                ?>

                <!-- 7. Listing Agent Details Section (Conditional) -->
                <?php 
                    if(isset($order_details['listing_agent_id']) && !empty($order_details['listing_agent_id']))
                    {
                ?>
                <div class="accordion-section">
                    <a class="accordion-trigger collapsed" data-toggle="collapse" data-parent="#accordionEx" href="#listingAgentDetails" aria-expanded="false" aria-controls="listingAgentDetails">
                        <span class="accordion-trigger-title">
                            <i class="fas fa-user-check"></i> Listing Agent Details
                        </span>
                        <i class="fas fa-chevron-down accordion-chevron"></i>
                    </a>
                    <div id="listingAgentDetails" class="collapse" data-parent="#accordionEx">
                        <div class="accordion-body">
                            <?php
                            if(
                                (isset($order_details['listing_agent_name']) && !empty($order_details['listing_agent_name']) && ($order_details['is_softpro_order'] == 0))
                                ||
                                (isset($order_details['sp_listing_agent_name']) && !empty($order_details['sp_listing_agent_name']) && ($order_details['is_softpro_order'] == 1))
                                )
                            {
                            ?>
                                    <div class="detail-row">
                                        <div class="detail-label">Listing Agent Name</div>
                                        <div class="detail-value">
                                        <?php 
                                        if ($order_details['is_softpro_order'] == 1) {
                                            echo $order_details['sp_listing_agent_name'];
                                        } else {
                                            echo $order_details['listing_agent_name'];
                                        }
                                        ?>
                                        </div>
                                    </div>
                            <?php
                                }
                            ?>
                            <?php
                            if(
                                (isset($order_details['listing_agent_email_address']) && !empty($order_details['listing_agent_email_address']) && ($order_details['is_softpro_order'] == 0))
                                ||
                                (isset($order_details['sp_listing_agent_email_address']) && !empty($order_details['sp_listing_agent_email_address']) && ($order_details['is_softpro_order'] == 1))
                                )
                            {
                            ?>
                                    <div class="detail-row">
                                        <div class="detail-label">Listing Agent Email</div>
                                        <div class="detail-value">
                                        <?php 
                                        if ($order_details['is_softpro_order'] == 1) {
                                            echo $order_details['sp_listing_agent_email_address'];
                                        } else {
                                            echo $order_details['listing_agent_email_address'];
                                        }
                                        ?>
                                        </div>
                                    </div>
                            <?php
                                }
                            ?>
                            <?php
                            if(
                                (isset($order_details['listing_agent_company']) && !empty($order_details['listing_agent_company']) && ($order_details['is_softpro_order'] == 0))
                                ||
                                (isset($order_details['sp_listing_agent_company']) && !empty($order_details['sp_listing_agent_company']) && ($order_details['is_softpro_order'] == 1))
                                )
                            {
                            ?>
                                    <div class="detail-row">
                                        <div class="detail-label">Listing Agent Company</div>
                                        <div class="detail-value">
                                        <?php 
                                        if ($order_details['is_softpro_order'] == 1) {
                                            echo $order_details['sp_listing_agent_company'];
                                        } else {
                                            echo $order_details['listing_agent_company'];
                                        }
                                        ?>
                                        </div>
                                    </div>
                            <?php
                                }
                            ?>
                            <?php
                            if(
                                (isset($order_details['listing_agent_telephone_no']) && !empty($order_details['listing_agent_telephone_no']) && ($order_details['is_softpro_order'] == 0))
                                ||
                                (isset($order_details['sp_listing_agent_telephone_no']) && !empty($order_details['sp_listing_agent_telephone_no']) && ($order_details['is_softpro_order'] == 1))
                                )
                            {
                            ?>
                                    <div class="detail-row">
                                        <div class="detail-label">Listing Agent Telephone</div>
                                        <div class="detail-value">
                                        <?php 
                                        if ($order_details['is_softpro_order'] == 1) {
                                            echo $order_details['sp_listing_agent_telephone_no'];
                                        } else {
                                            echo $order_details['listing_agent_telephone_no'];
                                        }
                                        ?>
                                        </div>
                                    </div>
                            <?php
                                }
                            ?>
                        </div>
                    </div>
                </div>
                <?php
                    }
                ?>

                <!-- 8. Lender/Escrow Details Section (Conditional) -->
                <?php 
                    if(isset($order_details['escrow_lender_id']) && !empty($order_details['escrow_lender_id']))
                    {
                ?>
                <div class="accordion-section">
                    <a class="accordion-trigger collapsed" data-toggle="collapse" data-parent="#accordionEx" href="#lenderDetails" aria-expanded="false" aria-controls="lenderDetails">
                        <span class="accordion-trigger-title">
                            <i class="fas fa-university"></i> Lender/Escrow Details
                        </span>
                        <i class="fas fa-chevron-down accordion-chevron"></i>
                    </a>
                    <div id="lenderDetails" class="collapse" data-parent="#accordionEx">
                        <div class="accordion-body">
                            <?php
                            if(
                                (isset($order_details['escrow_lender_first_name']) && !empty($order_details['escrow_lender_first_name']) && ($order_details['is_softpro_order'] == 0))
                                ||
                                (isset($order_details['sp_escrow_lender_first_name']) && !empty($order_details['sp_escrow_lender_first_name']) && ($order_details['is_softpro_order'] == 1))
                                )
                            {
                            ?>
                                    <div class="detail-row">
                                        <div class="detail-label">First Name</div>
                                        <div class="detail-value">
                                        <?php 
                                        if ($order_details['is_softpro_order'] == 1) {
                                            echo $order_details['sp_escrow_lender_first_name'];
                                        } else {
                                            echo $order_details['escrow_lender_first_name'];
                                        }
                                        ?>
                                        </div>
                                    </div>
                            <?php
                                }
                            ?>
                            <?php
                            if(
                                (isset($order_details['escrow_lender_last_name']) && !empty($order_details['escrow_lender_last_name']) && ($order_details['is_softpro_order'] == 0))
                                ||
                                (isset($order_details['sp_escrow_lender_last_name']) && !empty($order_details['sp_escrow_lender_last_name']) && ($order_details['is_softpro_order'] == 1))
                                )
                            {
                            ?>
                                    <div class="detail-row">
                                        <div class="detail-label">Last Name</div>
                                        <div class="detail-value">
                                        <?php 
                                        if ($order_details['is_softpro_order'] == 1) {
                                            echo $order_details['sp_escrow_lender_last_name'];
                                        } else {
                                            echo $order_details['escrow_lender_last_name'];
                                        }
                                        ?>
                                        </div>
                                    </div>
                            <?php
                                }
                            ?>
                            <?php
                            if(
                                (isset($order_details['escrow_lender_email']) && !empty($order_details['escrow_lender_email']) && ($order_details['is_softpro_order'] == 0))
                                ||
                                (isset($order_details['sp_escrow_lender_email']) && !empty($order_details['sp_escrow_lender_email']) && ($order_details['is_softpro_order'] == 1))
                                )
                            {
                            ?>
                                    <div class="detail-row">
                                        <div class="detail-label">Email Address</div>
                                        <div class="detail-value">
                                        <?php 
                                        if ($order_details['is_softpro_order'] == 1) {
                                            echo $order_details['sp_escrow_lender_email'];
                                        } else {
                                            echo $order_details['escrow_lender_email'];
                                        }
                                        ?>
                                        </div>
                                    </div>
                            <?php
                                }
                            ?>
                            <?php
                            if(
                                (isset($order_details['escrow_lender_company_name']) && !empty($order_details['escrow_lender_company_name']) && ($order_details['is_softpro_order'] == 0))
                                ||
                                (isset($order_details['sp_escrow_lender_company_name']) && !empty($order_details['sp_escrow_lender_company_name']) && ($order_details['is_softpro_order'] == 1))
                                )
                            {
                            ?>
                                    <div class="detail-row">
                                        <div class="detail-label">Company</div>
                                        <div class="detail-value">
                                        <?php 
                                        if ($order_details['is_softpro_order'] == 1) {
                                            echo $order_details['sp_escrow_lender_company_name'];
                                        } else {
                                            echo $order_details['escrow_lender_company_name'];
                                        }
                                        ?>
                                        </div>
                                    </div>
                            <?php
                                }
                            ?>
                            <?php
                            if(
                                (isset($order_details['escrow_lender_telephone_no']) && !empty($order_details['escrow_lender_telephone_no']) && ($order_details['is_softpro_order'] == 0))
                                ||
                                (isset($order_details['sp_escrow_lender_telephone_no']) && !empty($order_details['sp_escrow_lender_telephone_no']) && ($order_details['is_softpro_order'] == 1))
                                )
                            {
                            ?>
                                    <div class="detail-row">
                                        <div class="detail-label">Telephone</div>
                                        <div class="detail-value">
                                        <?php 
                                        if ($order_details['is_softpro_order'] == 1) {
                                            echo $order_details['sp_escrow_lender_telephone_no'];
                                        } else {
                                            echo $order_details['escrow_lender_telephone_no'];
                                        }
                                        ?>
                                        </div>
                                    </div>
                            <?php
                                }
                            ?>
                        </div>
                    </div>
                </div>
                <?php
                    }
                ?>
            </div>
        </div>
    </div>
</div>