

<div class="pct-page-modern">
    <div class="container-invoice">
        
        <?php if(empty($calcResult)) { ?>
            <div class="invoice-card">
                <div class="error-state">
                     <i class="fas fa-file-invoice-dollar"></i>
                     <h3 class="h5">Fees estimation is not available.</h3>
                     <p>Please check the order details or try again later.</p>
                     <div class="mt-4">
                        <a href="<?php echo base_url();?>fees" class="btn-modern btn-outline">
                            <i class="fas fa-arrow-left"></i> Return to Fees
                        </a>
                     </div>
                </div>
            </div>
        <?php } else { ?>
            
            <div class="invoice-card" id="artcle_main">
                <!-- Header -->
                <div class="invoice-header">
                    <div class="brand-section">
                        <div class="brand-logo">
                            <i class="fas fa-file-signature"></i> PCT Desk
                        </div>
                        <div class="document-title">
                            <div class="doc-label">Fee Estimate For Order</div>
                            <div class="doc-id">#<?php echo isset($order_number) && !empty($order_number) ? $order_number : '---'; ?></div>
                        </div>
                    </div>
                </div>

                <!-- Details Grid -->
                <div class="details-grid">
                    <div class="detail-item">
                        <div class="detail-icon">
                            <i class="fas fa-exchange-alt"></i>
                        </div>
                        <div class="detail-content">
                            <div class="detail-label">Transaction Type</div>
                            <div class="detail-value"><?php echo isset($transactionType) && !empty($transactionType) ? $transactionType : '-'; ?></div>
                        </div>
                    </div>

                    <div class="detail-item">
                        <div class="detail-icon">
                            <i class="fas fa-map-marker-alt"></i>
                        </div>
                        <div class="detail-content">
                            <div class="detail-label">Property Location</div>
                            <div class="detail-value"><?php echo isset($full_address) && !empty($full_address) ?$full_address : '-'; ?></div>
                        </div>
                    </div>

                    <div class="detail-item">
                        <div class="detail-icon">
                            <i class="fas fa-hand-holding-usd"></i>
                        </div>
                        <div class="detail-content">
                            <div class="detail-label">Loan Amount</div>
                            <div class="detail-value">
                                <?php if(isset($loan_amount) && !empty($loan_amount)) {
                                    $loan_amount = str_replace(",", "", $loan_amount); ?>
                                    $<?php echo number_format($loan_amount); ?>
                                <?php } else { echo '-'; } ?>
                            </div>
                        </div>
                    </div>

                    <?php if(isset($sales_amount) && !empty($sales_amount)) { ?>
                    <div class="detail-item">
                        <div class="detail-icon">
                            <i class="fas fa-tag"></i>
                        </div>
                        <div class="detail-content">
                            <div class="detail-label">Sales Amount</div>
                            <div class="detail-value">$<?php echo number_format($sales_amount); ?></div>
                        </div>
                    </div>
                    <?php } ?>
                </div>

                <!-- Fees Table -->
                <div class="table-container">
                    <table class="table-fees">
                        <thead>
                            <tr>
                                <th>Description</th>
                                <th class="text-right">Amount</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($calcResult)) { 
                                foreach($calcResult as $fee)  { ?>
                                    <tr>
                                        <td><?php echo $fee['Description'];?></td>
                                        <td class="text-right"><?php echo $fee['Amount']; ?></td>
                                    </tr>
                                <?php } ?>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>

                <!-- Total Section -->
                <div class="total-section">
                    <span class="total-label">Total Estimated Fees</span>
                    <span class="total-amount"><?php echo "$".number_format($totalAmount , 2); ?></span>
                </div>
            </div>

            <!-- Action Bar -->
            <div class="action-bar">
                <a href="<?php echo base_url();?>fees" class="btn-modern btn-outline">
                    <i class="fas fa-arrow-left"></i> Back to Fees
                </a>
                <a href="javascript:void(0);" id="download_estimate" data-closing-fee-id="<?php echo $closing_fee_estimate_id; ?>" class="btn-modern btn-primary">
                    <i class="fas fa-download"></i> Download Fee Estimate
                </a>
            </div>

        <?php } ?>
    </div>
</div>
