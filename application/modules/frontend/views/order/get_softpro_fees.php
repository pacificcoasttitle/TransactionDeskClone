<style>
/* Modernized styles based on CPL/Review Files/Fees pages */
.pct-page-modern {
    --pct-primary: #1e5f8a;
    --pct-primary-light: #2d7ab5;
    --pct-primary-soft: #e8f2f8;
    --pct-surface: #ffffff;
    --pct-surface-2: #f8fafc;
    --pct-text: #1e293b;
    --pct-text-muted: #64748b;
    --pct-border: #e2e8f0;
    --pct-radius: 12px;
    --pct-radius-sm: 8px;
    --pct-shadow: 0 1px 3px rgba(0,0,0,.06);
    font-family: 'Nunito', -apple-system, BlinkMacSystemFont, 'Segoe UI', system-ui, sans-serif;
    background: var(--pct-surface-2);
    min-height: 100vh;
    padding-bottom: 2rem;
}

/* Card */
.pct-page-modern .card.shadow.mb-4 {
    border: 1px solid var(--pct-border);
    border-radius: var(--pct-radius);
    box-shadow: var(--pct-shadow);
    overflow: hidden;
    background: var(--pct-surface);
}
.pct-page-modern .card-header {
    background: var(--pct-surface-2);
    border-bottom: 1px solid var(--pct-border);
    padding: 1.25rem 1.5rem;
}
.pct-page-modern .card-body { padding: 1.5rem; }

/* In-Page Header Details */
.pct-page-modern .invoice-header {
    margin-bottom: 2rem;
    padding-bottom: 1.5rem;
    border-bottom: 1px solid var(--pct-border);
}
.pct-page-modern .invoice-title {
    font-size: 1.5rem;
    font-weight: 700;
    color: var(--pct-primary);
    margin-bottom: 0.5rem;
}
.pct-page-modern .invoice-subtitle {
    font-size: 0.875rem;
    color: var(--pct-text-muted);
    font-weight: 500;
}

.pct-page-modern .detail-group {
    margin-bottom: 1rem;
}
.pct-page-modern .detail-label {
    font-size: 0.75rem;
    text-transform: uppercase;
    color: var(--pct-text-muted);
    font-weight: 600;
    margin-bottom: 0.25rem;
    display: block;
}
.pct-page-modern .detail-value {
    font-size: 1rem;
    color: var(--pct-text);
    font-weight: 500;
}

/* Fee Table */
.pct-page-modern .table-fee {
    width: 100%;
    border-collapse: collapse;
}
.pct-page-modern .table-fee thead th {
    background: var(--pct-surface-2);
    color: var(--pct-text);
    font-weight: 600;
    font-size: 0.8125rem;
    text-transform: uppercase;
    letter-spacing: 0.03em;
    border-bottom: 1px solid var(--pct-border);
    padding: 1rem;
    text-align: left;
}
.pct-page-modern .table-fee tbody td {
    padding: 1rem;
    font-size: 0.9375rem;
    color: var(--pct-text);
    border-bottom: 1px solid var(--pct-border);
    vertical-align: middle;
}
.pct-page-modern .table-fee tbody tr:last-child td { border-bottom: none; }
.pct-page-modern .table-fee .text-right { text-align: right; }

.pct-page-modern .total-row {
    background: var(--pct-primary-soft);
}
.pct-page-modern .total-row td {
    font-weight: 700;
    color: var(--pct-primary);
    font-size: 1.125rem;
}

/* Buttons */
.pct-page-modern .btn-icon-split {
    padding: 0;
    display: inline-flex;
    align-items: stretch;
    justify-content: center;
    overflow: hidden;
    border-radius: 8px;
    text-decoration: none;
}
.pct-page-modern .btn-icon-split .icon {
    background: rgba(0,0,0,0.15);
    display: flex;
    align-items: center;
    padding: 0.375rem 0.75rem;
}
.pct-page-modern .btn-icon-split .text {
    display: flex;
    align-items: center;
    padding: 0.375rem 0.75rem;
    font-size: 0.875rem;
    font-weight: 500;
}
.pct-page-modern .btn-secondary { background: #64748b; border-color: #64748b; color: #fff; }
.pct-page-modern .btn-secondary:hover { background: #475569; border-color: #475569; color: #fff; }

.pct-page-modern .btn-primary { background: #1e5f8a; border-color: #1e5f8a; color: #fff; }
.pct-page-modern .btn-primary:hover { background: #164e73; border-color: #164e73; color: #fff; }

/* Error State */
.pct-page-modern .error-state {
    text-align: center;
    padding: 4rem 2rem;
    color: var(--pct-text-muted);
}
.pct-page-modern .error-state i {
    font-size: 3rem;
    margin-bottom: 1rem;
    color: #cbd5e1;
}

</style>

<div class="pct-page-modern">
<section class="section-type-4a section-defaulta" style="padding-bottom:0px;">
	<div class="container-fluid px-4 py-4">
        
        <!-- Top Nav -->
        <div class="row mb-4 align-items-center">
            <div class="col-sm-6">
                <!-- Placeholder for potential breadcrumb or back -->
            </div>
            <div class="col-sm-6 text-right">
                <a class="btn btn-secondary btn-icon-split" href="<?php echo base_url();?>fees">
                    <span class="icon text-white-50">
                        <i class="fa fa-arrow-left"></i>
                    </span>
                    <span class="text">Back</span>
                </a>
            </div>
        </div>

        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="card shadow mb-4">
                    <div class="card-body">
                        
                        <?php if(empty($calcResult)) { ?>
                            <div class="error-state">
                                 <i class="fas fa-exclamation-circle"></i>
                                 <h3 class="h5">Fees estimation does not exist.</h3>
                            </div>
                        <?php } else { ?>
                            
                            <!-- Header -->
                            <div class="invoice-header">
                                <div class="row align-items-start">
                                    <div class="col-md-6">
                                        <div class="invoice-title">Fee Estimate</div>
                                        <div class="invoice-subtitle">Pacific Coast Title Company</div>
                                    </div>
                                    <div class="col-md-6 text-md-right mt-3 mt-md-0">
                                        <div class="detail-label">Order Number</div>
                                        <div class="detail-value text-primary font-weight-bold" style="font-size: 1.25rem;">
                                            <?php echo isset($order_number) && !empty($order_number) ? $order_number : '-'; ?>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Details Grid -->
                            <div class="row mb-4">
                                <div class="col-md-4">
                                    <div class="detail-group">
                                        <span class="detail-label">Transaction Type</span>
                                        <div class="detail-value"><?php echo isset($transactionType) && !empty($transactionType) ? $transactionType : '-'; ?></div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="detail-group">
                                         <span class="detail-label">Property Location</span>
                                         <div class="detail-value"><?php echo isset($full_address) && !empty($full_address) ?$full_address : '-'; ?></div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <?php if(isset($loan_amount) && !empty($loan_amount)) {
                                        $loan_amount = str_replace(",", "", $loan_amount); ?>
                                        <div class="detail-group">
                                            <span class="detail-label">Loan Amount</span>
                                            <div class="detail-value">$<?php echo number_format($loan_amount); ?></div>
                                        </div>
                                    <?php } ?>
                                    <?php if(isset($sales_amount) && !empty($sales_amount)) { ?>
                                        <div class="detail-group">
                                            <span class="detail-label">Sales Amount</span>
                                            <div class="detail-value">$<?php echo number_format($sales_amount); ?></div>
                                        </div>
                                    <?php } ?>
                                </div>
                            </div>

                            <!-- Fees Table -->
                            <div class="table-responsive mb-4">
                                <table class="table-fee">
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
                                        <tr class="total-row">
                                            <td>Total</td>
                                            <td class="text-right"><?php echo "$".number_format($totalAmount , 2); ?></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>

                            <!-- Actions -->
                            <div class="text-right">
                                <a class="btn btn-primary btn-icon-split" id="download_estimate" data-closing-fee-id="<?php echo $closing_fee_estimate_id; ?>" href="javascript:void(0);">
                                    <span class="icon text-white-50">
                                        <i class="fas fa-download"></i>
                                    </span>
                                    <span class="text">Download Fee Estimate</span>
                                </a>
                            </div>

                        <?php } ?>

                    </div>
                </div>
            </div>
        </div>
        
    </div>
</section>
</div>
