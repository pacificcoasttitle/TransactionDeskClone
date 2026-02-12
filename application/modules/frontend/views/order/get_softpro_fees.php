<style>
/* Modernized styles - Invoice/Estimate Theme */
:root {
    --pct-primary: #1e5f8a;
    --pct-primary-dark: #164e73;
    --pct-primary-light: #e8f2f8;
    --pct-text: #1e293b;
    --pct-text-muted: #64748b;
    --pct-border: #e2e8f0;
    --pct-bg: #f1f5f9;
    --pct-surface: #ffffff;
    --pct-radius: 12px;
    --pct-shadow-sm: 0 1px 2px 0 rgb(0 0 0 / 0.05);
    --pct-shadow: 0 4px 6px -1px rgb(0 0 0 / 0.1), 0 2px 4px -2px rgb(0 0 0 / 0.1);
}

.pct-page-modern {
    font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
    background-color: var(--pct-bg);
    min-height: 100vh;
    padding: 2rem 0;
}

.pct-page-modern .container-invoice {
    max-width: 900px;
    margin: 0 auto;
    padding: 0 1rem;
}

/* Card / Document Container - Scoped to class for portability to PDF */
.invoice-card {
    background: var(--pct-surface);
    border-radius: var(--pct-radius);
    box-shadow: var(--pct-shadow);
    overflow: hidden;
    position: relative;
    /* Ensure styles applied when isolated */
    font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
    color: var(--pct-text);
}

/* Header Section */
.invoice-card .invoice-header {
    background: #fff;
    padding: 2.5rem;
    border-bottom: 2px solid var(--pct-primary-light);
    position: relative;
}

.invoice-card .brand-section {
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
    margin-bottom: 2rem;
}

.invoice-card .brand-logo {
    font-size: 1.75rem;
    font-weight: 800;
    color: var(--pct-primary);
    text-transform: uppercase;
    letter-spacing: -0.5px;
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.invoice-card .document-title {
    text-align: right;
}

.invoice-card .doc-label {
    font-size: 0.875rem;
    text-transform: uppercase;
    color: var(--pct-text-muted);
    font-weight: 600;
    letter-spacing: 1px;
    margin-bottom: 0.25rem;
}

.invoice-card .doc-id {
    font-size: 1.5rem;
    font-weight: 700;
    color: var(--pct-text);
}

/* Details Grid */
.invoice-card .details-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 1.5rem;
    padding: 2rem 2.5rem;
    background: var(--pct-surface);
}

.invoice-card .detail-item {
    display: flex;
    align-items: flex-start;
    gap: 1rem;
}

.invoice-card .detail-icon {
    width: 42px;
    height: 42px;
    border-radius: 10px;
    background: var(--pct-primary-light);
    color: var(--pct-primary);
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.1rem;
    flex-shrink: 0;
}

.invoice-card .detail-content {
    flex: 1;
}

.invoice-card .detail-label {
    font-size: 0.75rem;
    text-transform: uppercase;
    color: var(--pct-text-muted);
    font-weight: 600;
    margin-bottom: 0.25rem;
}

.invoice-card .detail-value {
    font-size: 1rem;
    font-weight: 600;
    color: var(--pct-text);
    word-break: break-word;
}

/* Fees Table */
.invoice-card .table-container {
    padding: 0 2.5rem 2.5rem;
    width: 100%; 
}

.invoice-card .table-fees {
    width: 100%;
    border-collapse: separate;
    border-spacing: 0;
}

.invoice-card .table-fees th {
    background: var(--pct-primary-light); /* Distinct background */
    color: var(--pct-primary-dark); /* Darker text for contrast */
    font-weight: 700;
    font-size: 0.8rem;
    text-transform: uppercase;
    letter-spacing: 0.05em;
    padding: 1rem 1.5rem;
    border-bottom: 2px solid var(--pct-border);
    text-align: left;
}

.invoice-card .table-fees th.text-right { text-align: right; }

.invoice-card .table-fees td {
    padding: 1.25rem 1.5rem;
    color: var(--pct-text);
    font-size: 0.95rem;
    border-bottom: 1px solid var(--pct-border);
    transition: background-color 0.2s;
}

.invoice-card .table-fees tr:hover td {
    background-color: var(--pct-primary-light);
}

.invoice-card .table-fees tr:last-child td {
    border-bottom: none;
}

.invoice-card .total-section {
    background: #f8fafc;
    padding: 1.5rem 2.5rem;
    display: flex;
    justify-content: flex-end;
    align-items: center;
    border-top: 1px solid var(--pct-border);
}

.invoice-card .total-label {
    font-size: 1.1rem;
    font-weight: 600;
    color: var(--pct-text-muted);
    margin-right: 2rem;
}

.invoice-card .total-amount {
    font-size: 1.75rem;
    font-weight: 800;
    color: var(--pct-primary);
}

/* Actions - Keep these scoped to page modern or generic outside of invoice-card if possible, 
   but they are inside .invoice-card in HTML structure for error state. 
   The main invoice card #artcle_main does NOT contain actions, so we are good. 
*/

.pct-page-modern .action-bar {
    margin-top: 2rem;
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.pct-page-modern .btn-modern {
    display: inline-flex;
    align-items: center;
    gap: 0.75rem;
    padding: 0.875rem 1.5rem;
    border-radius: 10px;
    font-weight: 600;
    font-size: 0.95rem;
    transition: all 0.2s;
    text-decoration: none;
    border: none;
    cursor: pointer;
}

.pct-page-modern .btn-primary {
    background: var(--pct-primary);
    color: white;
    box-shadow: 0 4px 6px -1px rgba(30, 95, 138, 0.3);
}

.pct-page-modern .btn-primary:hover {
    background: var(--pct-primary-dark);
    transform: translateY(-2px);
    box-shadow: 0 6px 8px -1px rgba(30, 95, 138, 0.4);
}

.pct-page-modern .btn-outline {
    background: transparent;
    color: var(--pct-text-muted);
    border: 1px solid var(--pct-border);
}

.pct-page-modern .btn-outline:hover {
    background: white;
    color: var(--pct-text);
    border-color: var(--pct-text);
}

/* Error State */
.pct-page-modern .error-state {
    text-align: center;
    padding: 5rem 2rem;
    color: var(--pct-text-muted);
}
.pct-page-modern .error-state i {
    font-size: 4rem;
    margin-bottom: 1.5rem;
    color: #e2e8f0;
}

@media print {
    body { background: white; }
    .pct-page-modern { padding: 0; background: white; }
    .pct-page-modern .action-bar { display: none; }
    .invoice-card { box-shadow: none !important; border: 1px solid #ddd !important; }
}
</style>

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
