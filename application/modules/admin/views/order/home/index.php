<style>
/* Admin Dashboard Modern Styles */
.pct-admin-dashboard {
    background: #f8fafc;
    min-height: 100%;
    padding: 1.5rem;
}

.pct-admin-dashboard .dashboard-header {
    margin-bottom: 2rem;
}

.pct-admin-dashboard .dashboard-header h1 {
    font-size: 1.75rem;
    font-weight: 700;
    color: #1e293b;
    margin-bottom: 0.25rem;
}

.pct-admin-dashboard .dashboard-header p {
    color: #64748b;
    font-size: 0.9375rem;
    margin: 0;
}

.pct-admin-dashboard .dashboard-actions {
    display: flex;
    gap: 0.75rem;
    flex-wrap: wrap;
}

.pct-admin-dashboard .btn-action-modern {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.625rem 1.25rem;
    font-size: 0.875rem;
    font-weight: 600;
    border-radius: 8px;
    border: none;
    transition: all 0.2s ease;
    text-decoration: none;
}

.pct-admin-dashboard .btn-action-primary {
    background: linear-gradient(135deg, #1e3a5f 0%, #2d4a6f 100%);
    color: #fff;
}

.pct-admin-dashboard .btn-action-primary:hover {
    background: linear-gradient(135deg, #2d4a6f 0%, #3d5a7f 100%);
    color: #fff;
    transform: translateY(-1px);
    box-shadow: 0 4px 12px rgba(30, 58, 95, 0.3);
}

.pct-admin-dashboard .btn-action-success {
    background: linear-gradient(135deg, #059669 0%, #10b981 100%);
    color: #fff;
}

.pct-admin-dashboard .btn-action-success:hover {
    background: linear-gradient(135deg, #10b981 0%, #34d399 100%);
    color: #fff;
    transform: translateY(-1px);
    box-shadow: 0 4px 12px rgba(5, 150, 105, 0.3);
}

.pct-admin-dashboard .section-header {
    display: flex;
    align-items: center;
    margin-bottom: 1.25rem;
    padding-bottom: 0.75rem;
    border-bottom: 2px solid #e2e8f0;
}

.pct-admin-dashboard .section-header h2 {
    font-size: 1.125rem;
    font-weight: 700;
    color: #1e293b;
    margin: 0;
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.pct-admin-dashboard .section-header h2 i {
    font-size: 1rem;
    color: #64748b;
}

/* Modern Stats Cards */
.pct-admin-dashboard .stats-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
    gap: 1.25rem;
    margin-bottom: 2rem;
}

.pct-admin-dashboard .stat-card {
    background: #fff;
    border-radius: 12px;
    padding: 1.5rem;
    box-shadow: 0 1px 3px rgba(0,0,0,0.06);
    border: 1px solid #e2e8f0;
    position: relative;
    overflow: hidden;
    transition: all 0.2s ease;
}

.pct-admin-dashboard .stat-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(0,0,0,0.1);
}

.pct-admin-dashboard .stat-card::before {
    content: '';
    position: absolute;
    left: 0;
    top: 0;
    bottom: 0;
    width: 4px;
    border-radius: 12px 0 0 12px;
}

.pct-admin-dashboard .stat-card.primary::before { background: linear-gradient(180deg, #3b82f6, #1d4ed8); }
.pct-admin-dashboard .stat-card.success::before { background: linear-gradient(180deg, #10b981, #059669); }
.pct-admin-dashboard .stat-card.info::before { background: linear-gradient(180deg, #06b6d4, #0891b2); }
.pct-admin-dashboard .stat-card.warning::before { background: linear-gradient(180deg, #f59e0b, #d97706); }
.pct-admin-dashboard .stat-card.secondary::before { background: linear-gradient(180deg, #6b7280, #4b5563); }

.pct-admin-dashboard .stat-card .stat-content {
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
}

.pct-admin-dashboard .stat-card .stat-label {
    font-size: 0.75rem;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.05em;
    color: #64748b;
    margin-bottom: 0.5rem;
}

.pct-admin-dashboard .stat-card .stat-value {
    font-size: 2rem;
    font-weight: 700;
    color: #1e293b;
    line-height: 1;
}

.pct-admin-dashboard .stat-card .stat-icon {
    width: 48px;
    height: 48px;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.25rem;
}

.pct-admin-dashboard .stat-card.primary .stat-icon { background: #eff6ff; color: #3b82f6; }
.pct-admin-dashboard .stat-card.success .stat-icon { background: #ecfdf5; color: #10b981; }
.pct-admin-dashboard .stat-card.info .stat-icon { background: #ecfeff; color: #06b6d4; }
.pct-admin-dashboard .stat-card.warning .stat-icon { background: #fffbeb; color: #f59e0b; }
.pct-admin-dashboard .stat-card.secondary .stat-icon { background: #f3f4f6; color: #6b7280; }

.pct-admin-dashboard .stat-card .stat-link {
    display: inline-flex;
    align-items: center;
    gap: 0.375rem;
    font-size: 0.8125rem;
    font-weight: 600;
    margin-top: 1rem;
    text-decoration: none;
    transition: all 0.15s ease;
}

.pct-admin-dashboard .stat-card.primary .stat-link { color: #3b82f6; }
.pct-admin-dashboard .stat-card.success .stat-link { color: #10b981; }
.pct-admin-dashboard .stat-card.info .stat-link { color: #06b6d4; }
.pct-admin-dashboard .stat-card.warning .stat-link { color: #f59e0b; }
.pct-admin-dashboard .stat-card.secondary .stat-link { color: #6b7280; }

.pct-admin-dashboard .stat-card .stat-link:hover {
    gap: 0.625rem;
}

/* Alert Messages */
.pct-admin-dashboard .alert-modern {
    border-radius: 8px;
    padding: 1rem 1.25rem;
    font-size: 0.875rem;
    border: none;
    margin-bottom: 1rem;
}

.pct-admin-dashboard .alert-success-modern {
    background: #ecfdf5;
    color: #047857;
}

.pct-admin-dashboard .alert-danger-modern {
    background: #fef2f2;
    color: #dc2626;
}

/* Dual Column Layout for Orders */
.pct-admin-dashboard .orders-grid {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 2rem;
    margin-bottom: 2rem;
}

@media (max-width: 992px) {
    .pct-admin-dashboard .orders-grid {
        grid-template-columns: 1fr;
    }
}

/* Modal Styles */
.pct-admin-dashboard .modal-content {
    border-radius: 12px;
    border: none;
    box-shadow: 0 25px 50px -12px rgba(0,0,0,0.25);
}

.pct-admin-dashboard .modal-header {
    border-bottom: 1px solid #e2e8f0;
    padding: 1.25rem 1.5rem;
}

.pct-admin-dashboard .modal-title {
    font-size: 1.125rem;
    font-weight: 700;
    color: #1e293b;
}

.pct-admin-dashboard .modal-body {
    padding: 1.5rem;
}

.pct-admin-dashboard .modal-footer {
    border-top: 1px solid #e2e8f0;
    padding: 1rem 1.5rem;
}
</style>

<div class="pct-admin-dashboard">
    <!-- Alert Messages -->
    <div id="daily_prod_success_msg" class="alert-modern alert-success-modern" style="display:none;"></div>
    <div id="daily_prod_error_msg" class="alert-modern alert-danger-modern" style="display:none;"></div>

    <!-- Dashboard Header -->
    <div class="dashboard-header d-flex justify-content-between align-items-start flex-wrap" style="gap: 1rem;">
        <div>
            <h1>Dashboard</h1>
            <p><?php echo date('l, F j, Y'); ?></p>
        </div>
        <div class="dashboard-actions">
            <button type="button" class="btn-action-modern btn-action-success" onclick="sendDailyProductionReport();">
                <i class="fas fa-paper-plane"></i>
                Send Daily Production Email
            </button>
            <a href="javascript:void(0);" data-toggle="modal" data-target="#generateSalesReportModel" class="btn-action-modern btn-action-primary">
                <i class="fas fa-file-export"></i>
                Sales Rep Transaction Report
            </a>
        </div>
    </div>

    <!-- Orders Section -->
    <div class="orders-grid">
        <!-- Open Orders -->
        <div>
            <div class="section-header">
                <h2><i class="fas fa-folder-open"></i> Open Orders &mdash; <?=date('F Y')?></h2>
            </div>
            <div class="stats-grid" style="grid-template-columns: repeat(2, 1fr);">
                <div class="stat-card primary">
                    <div class="stat-content">
                        <div>
                            <div class="stat-label">Sales Orders</div>
                            <div class="stat-value"><?php echo $openSalesCount; ?></div>
                        </div>
                        <div class="stat-icon">
                            <i class="fas fa-shopping-cart"></i>
                        </div>
                    </div>
                    <a class="stat-link" href="<?php echo base_url() . 'order/admin/orders' ?>">
                        View Details <i class="fas fa-arrow-right"></i>
                    </a>
                </div>
                <div class="stat-card success">
                    <div class="stat-content">
                        <div>
                            <div class="stat-label">Refi Orders</div>
                            <div class="stat-value"><?php echo $openLoanCount; ?></div>
                        </div>
                        <div class="stat-icon">
                            <i class="fas fa-sync-alt"></i>
                        </div>
                    </div>
                    <a class="stat-link" href="<?php echo base_url() . 'order/admin/orders' ?>">
                        View Details <i class="fas fa-arrow-right"></i>
                    </a>
                </div>
            </div>
        </div>

        <!-- Closed Orders -->
        <div>
            <div class="section-header">
                <h2><i class="fas fa-folder"></i> Closed Orders &mdash; <?=date('F Y')?></h2>
            </div>
            <div class="stats-grid" style="grid-template-columns: repeat(2, 1fr);">
                <div class="stat-card info">
                    <div class="stat-content">
                        <div>
                            <div class="stat-label">Sales Orders</div>
                            <div class="stat-value"><?php echo $closedSalesCount; ?></div>
                        </div>
                        <div class="stat-icon">
                            <i class="fas fa-check-circle"></i>
                        </div>
                    </div>
                    <a class="stat-link" href="<?php echo base_url() . 'order/admin/orders' ?>">
                        View Details <i class="fas fa-arrow-right"></i>
                    </a>
                </div>
                <div class="stat-card warning">
                    <div class="stat-content">
                        <div>
                            <div class="stat-label">Refi Orders</div>
                            <div class="stat-value"><?php echo $closedLoanCount; ?></div>
                        </div>
                        <div class="stat-icon">
                            <i class="fas fa-check-double"></i>
                        </div>
                    </div>
                    <a class="stat-link" href="<?php echo base_url() . 'order/admin/orders' ?>">
                        View Details <i class="fas fa-arrow-right"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Clients Section -->
    <div class="section-header">
        <h2><i class="fas fa-users"></i> Client Statistics</h2>
    </div>
    <div class="stats-grid" style="grid-template-columns: repeat(5, 1fr);">
        <div class="stat-card primary">
            <div class="stat-content">
                <div>
                    <div class="stat-label">Escrows</div>
                    <div class="stat-value"><?php echo $escrowUsersCount; ?></div>
                </div>
                <div class="stat-icon">
                    <i class="fas fa-user-tie"></i>
                </div>
            </div>
            <a class="stat-link" href="<?php echo base_url() . 'order/admin/softpro-escrow' ?>">
                View Details <i class="fas fa-arrow-right"></i>
            </a>
        </div>
        <div class="stat-card success">
            <div class="stat-content">
                <div>
                    <div class="stat-label">Lenders</div>
                    <div class="stat-value"><?php echo $lenderUsersCount; ?></div>
                </div>
                <div class="stat-icon">
                    <i class="fas fa-landmark"></i>
                </div>
            </div>
            <a class="stat-link" href="<?php echo base_url() . 'order/admin/softpro-lenders' ?>">
                View Details <i class="fas fa-arrow-right"></i>
            </a>
        </div>
        <div class="stat-card info">
            <div class="stat-content">
                <div>
                    <div class="stat-label">Sales Rep</div>
                    <div class="stat-value"><?php echo $salesRepUsersCount; ?></div>
                </div>
                <div class="stat-icon">
                    <i class="fas fa-headset"></i>
                </div>
            </div>
            <a class="stat-link" href="<?php echo base_url() . 'order/admin/softpro-sales-rep' ?>">
                View Details <i class="fas fa-arrow-right"></i>
            </a>
        </div>
        <div class="stat-card warning">
            <div class="stat-content">
                <div>
                    <div class="stat-label">Mortgage Users</div>
                    <div class="stat-value"><?php echo $mortgageUsersCount; ?></div>
                </div>
                <div class="stat-icon">
                    <i class="fas fa-home"></i>
                </div>
            </div>
            <a class="stat-link" href="<?php echo base_url() . 'order/admin/softpro-mortgage-brokers' ?>">
                View Details <i class="fas fa-arrow-right"></i>
            </a>
        </div>
        <div class="stat-card secondary">
            <div class="stat-content">
                <div>
                    <div class="stat-label">Agents</div>
                    <div class="stat-value"><?php echo $agentUsersCount; ?></div>
                </div>
                <div class="stat-icon">
                    <i class="fas fa-user-friends"></i>
                </div>
            </div>
            <a class="stat-link" href="<?php echo base_url() . 'order/admin/softpro-agents' ?>">
                View Details <i class="fas fa-arrow-right"></i>
            </a>
        </div>
    </div>

    <!-- Missing Prelims Section -->
    <div class="section-header">
        <h2><i class="fas fa-exclamation-triangle"></i> System Alerts</h2>
    </div>
    <div class="stats-grid" style="grid-template-columns: repeat(3, 1fr);">
        <div class="stat-card info">
            <div class="stat-content">
                <div>
                    <div class="stat-label">Missing Prelims</div>
                    <div class="stat-value"><?php echo $failedJsonCount; ?></div>
                </div>
                <div class="stat-icon">
                    <i class="fas fa-file-alt"></i>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="generateSalesReportModel" tabindex="-1" role="dialog" aria-labelledby="generateSalesReportLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <form method="post" id="sales-rep-csv-report">
                <div class="modal-header">
                    <h5 class="modal-title" id="generateSalesReportLabel">
                        <i class="fas fa-file-export mr-2"></i>Generate Sales Rep CSV Report
                    </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div id="sales_report_msg" class="alert-modern alert-success-modern" style="display:none;"></div>
                    <div id="sales_report_err_msg" class="alert-modern alert-danger-modern" style="display:none;"></div>
                    
                    <div class="form-group">
                        <label for="select_month" class="font-weight-bold">Select Month</label>
                        <select id="select_month" name="select_month" class="form-control" required>
                            <option value="1" <?php echo (date('m') == 1) ? "selected" : "" ?>>January</option>
                            <option value="2" <?php echo (date('m') == 2) ? "selected" : "" ?>>February</option>
                            <option value="3" <?php echo (date('m') == 3) ? "selected" : "" ?>>March</option>
                            <option value="4" <?php echo (date('m') == 4) ? "selected" : "" ?>>April</option>
                            <option value="5" <?php echo (date('m') == 5) ? "selected" : "" ?>>May</option>
                            <option value="6" <?php echo (date('m') == 6) ? "selected" : "" ?>>June</option>
                            <option value="7" <?php echo (date('m') == 7) ? "selected" : "" ?>>July</option>
                            <option value="8" <?php echo (date('m') == 8) ? "selected" : "" ?>>August</option>
                            <option value="9" <?php echo (date('m') == 9) ? "selected" : "" ?>>September</option>
                            <option value="10" <?php echo (date('m') == 10) ? "selected" : "" ?>>October</option>
                            <option value="11" <?php echo (date('m') == 11) ? "selected" : "" ?>>November</option>
                            <option value="12" <?php echo (date('m') == 12) ? "selected" : "" ?>>December</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="select_year" class="font-weight-bold">Select Year</label>
                        <select id="select_year" name="select_year" class="form-control" required>
                            <?php
                            $currently_selected = date('Y');
                            $earliest_year = 2010;
                            $latest_year = date('Y');
                            foreach (range($latest_year, $earliest_year) as $i) { ?>
                                <option value="<?php echo $i; ?>" <?php echo ($i == $currently_selected) ? "selected" : "" ?>><?php echo $i; ?></option>
                            <?php } ?>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">
                        <i class="fas fa-times mr-1"></i> Cancel
                    </button>
                    <button type="button" class="btn btn-primary" onclick="exportSalesRepReports()">
                        <i class="fas fa-download mr-1"></i> Export Report
                    </button>
                </div>
                <input type="hidden" name="admin_id" id="formId" value="">
            </form>
        </div>
    </div>
</div>