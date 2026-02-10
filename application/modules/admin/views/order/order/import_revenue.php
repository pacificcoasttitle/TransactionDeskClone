<?php
$prev_data = $this->session->flashdata('_previous_data');
?>

<div class="pct-admin-listing">
    <!-- Page Header -->
    <div class="page-header">
        <h1><i class="fas fa-file-invoice-dollar"></i> Import Revenue Report</h1>
        
        <div class="action-buttons">
            <a href="javascript:void(0);" onclick="fetchRevenueReport();" id="export-orders-data" class="btn-action btn-action-success">
                <i class="fas fa-sync-alt"></i> Update Revenue
            </a>
        </div>
    </div>

    <!-- Import Form Card -->
    <div class="modern-card" style="max-width: 800px;">
        <div class="modern-card-header">
            <h2><i class="fas fa-upload"></i> Upload Revenue File</h2>
        </div>
        <div class="modern-card-body">
            <div id="order_success_msg" class="alert-modern alert-success-modern" style="display:none;"></div>
            <div id="order_error_msg" class="alert-modern alert-danger-modern" style="display:none;"></div>
            
            <?php if ($this->session->flashdata('revenue_error')): ?>
                <div class="alert-modern alert-danger-modern">
                    <?php echo $this->session->flashdata('revenue_error'); ?>
                </div>
            <?php elseif ($this->session->flashdata('revenue_success')): ?>
                <div class="alert-modern alert-success-modern">
                    <?php echo $this->session->flashdata('revenue_success'); ?>
                </div>
            <?php endif; ?>
            
            <form method="POST" id="smart-form" enctype="multipart/form-data">
                <div class="form-group">
                    <label for="csvFile" class="font-weight-bold mb-2">
                        <i class="fas fa-file-excel text-success mr-1"></i> Select Excel File (.xlsx, .xls)
                    </label>
                    <div class="custom-file-upload">
                        <input type="file" 
                               class="form-control" 
                               name="file" 
                               id="csvFile" 
                               accept=".xlsx, .xls"
                               style="padding: 0.5rem;">
                        <small class="form-text text-muted mt-2">
                            <i class="fas fa-info-circle mr-1"></i>
                            Supported formats: Excel (.xlsx, .xls)
                        </small>
                    </div>
                </div>
                
                <div class="mt-4">
                    <button type="submit" class="btn-action btn-action-primary">
                        <i class="fas fa-cloud-upload-alt"></i> Upload & Import
                    </button>
                </div>
            </form>
        </div>
    </div>
    
    <!-- Help Card -->
    <div class="modern-card mt-4" style="max-width: 800px;">
        <div class="modern-card-header">
            <h2><i class="fas fa-question-circle"></i> Import Instructions</h2>
        </div>
        <div class="modern-card-body">
            <ul class="mb-0" style="color: var(--pct-text-muted); line-height: 1.8;">
                <li>Upload an Excel file containing revenue data</li>
                <li>The file should include columns for order numbers and revenue amounts</li>
                <li>Supported bill codes: TPC, TPW, ESC, TSGW, UPRE</li>
                <li>After upload, revenue data will be matched with existing orders</li>
            </ul>
        </div>
    </div>
</div>
