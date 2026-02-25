<style>
/* Enhanced Report Styles - Premium Look */
.pct-report-container {
    --report-primary: #1F4E79;
    --report-primary-light: #4472C4;
    --report-accent: #2F5597;
    --report-gradient: linear-gradient(135deg, #1F4E79 0%, #4472C4 100%);
    --report-card-shadow: 0 10px 40px rgba(31, 78, 121, 0.15);
}

/* Report Header Enhancement */
.pct-report-container .report-header-banner {
    background: var(--report-gradient);
    border-radius: 16px;
    padding: 24px 30px;
    margin-bottom: 24px;
    box-shadow: var(--report-card-shadow);
    position: relative;
    overflow: hidden;
}

.pct-report-container .report-header-banner::before {
    content: '';
    position: absolute;
    top: -50%;
    right: -20%;
    width: 300px;
    height: 300px;
    background: radial-gradient(circle, rgba(255,255,255,0.1) 0%, transparent 70%);
    border-radius: 50%;
}

.pct-report-container .report-header-banner h2 {
    color: white;
    font-size: 1.5rem;
    font-weight: 700;
    margin: 0;
    display: flex;
    align-items: center;
    gap: 12px;
}

.pct-report-container .report-header-banner h2 i {
    font-size: 1.8rem;
    opacity: 0.9;
}

.pct-report-container .report-date-badge {
    background: rgba(255,255,255,0.2);
    color: white;
    padding: 6px 16px;
    border-radius: 20px;
    font-size: 0.85rem;
    font-weight: 500;
    backdrop-filter: blur(10px);
    margin-top: 10px;
    display: inline-block;
}

/* Enhanced Branch Sections */
.pct-report-container .branch-section {
    margin: 20px 0;
    border: none;
    border-radius: 12px;
    box-shadow: 0 4px 20px rgba(0,0,0,0.08);
    overflow: hidden;
    transition: all 0.3s ease;
}

.pct-report-container .branch-section:hover {
    box-shadow: 0 8px 30px rgba(31, 78, 121, 0.15);
    transform: translateY(-2px);
}

.pct-report-container .branch-toggle {
    background: var(--report-gradient);
    color: white;
    padding: 18px 24px;
    font-weight: 600;
    font-size: 15px;
    border: none;
    width: 100%;
    text-align: left;
    cursor: pointer;
    border-radius: 0;
    display: flex;
    justify-content: space-between;
    align-items: center;
    transition: all 0.3s ease;
    letter-spacing: 0.3px;
}

.pct-report-container .branch-toggle:hover {
    background: linear-gradient(135deg, #2F5597 0%, #5a8fd4 100%);
}

.pct-report-container .branch-toggle .toggle-icon {
    font-size: 14px;
    transition: transform 0.3s ease;
    background: rgba(255,255,255,0.2);
    width: 28px;
    height: 28px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
}

.pct-report-container .branch-content {
    padding: 24px;
    background: linear-gradient(180deg, #ffffff 0%, #f8f9fc 100%);
    display: block;
}

.pct-report-container .branch-content.collapsed { display: none; }

/* Branch Header Enhancement */
.pct-report-container .branch-header {
    background: var(--report-gradient);
    color: white;
    padding: 16px 24px;
    margin: 24px 0 12px 0;
    font-weight: 600;
    font-size: 15px;
    border-radius: 10px;
    text-align: center;
    cursor: pointer;
    display: flex;
    justify-content: space-between;
    align-items: center;
    box-shadow: 0 4px 15px rgba(31, 78, 121, 0.2);
    transition: all 0.3s ease;
}

.pct-report-container .branch-header:hover {
    transform: scale(1.01);
    box-shadow: 0 6px 20px rgba(31, 78, 121, 0.25);
}

/* Enhanced Tables */
.pct-report-container .branch-table,
.pct-report-container .salesrep-table,
.pct-report-container .title-table {
    border-collapse: separate;
    border-spacing: 0;
    width: 100%;
    margin: 0 0 24px 0;
    border-radius: 10px;
    overflow: hidden;
    box-shadow: 0 4px 15px rgba(0,0,0,0.05);
    font-size: 13px;
}

.pct-report-container .branch-table th,
.pct-report-container .salesrep-table th,
.pct-report-container .title-table th {
    background: linear-gradient(135deg, #f8f9fc 0%, #e9ecef 100%);
    border: none;
    border-bottom: 2px solid #dee2e6;
    padding: 14px 12px;
    text-align: center;
    font-weight: 700;
    color: var(--report-primary);
    font-size: 12px;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    white-space: nowrap;
}

.pct-report-container .branch-table td,
.pct-report-container .salesrep-table td,
.pct-report-container .title-table td {
    border: none;
    border-bottom: 1px solid #eef0f5;
    padding: 12px 10px;
    text-align: center;
    vertical-align: middle;
    background-color: #ffffff;
    font-size: 13px;
    transition: all 0.2s ease;
}

.pct-report-container .branch-table tr:nth-child(even) td,
.pct-report-container .salesrep-table tr:nth-child(even) td,
.pct-report-container .title-table tr:nth-child(even) td {
    background-color: #f8f9fc;
}

.pct-report-container .branch-table tr:hover td,
.pct-report-container .salesrep-table tr:hover td,
.pct-report-container .title-table tr:hover td {
    background-color: #e8f4fd !important;
}

/* Name Columns */
.pct-report-container .salesrep-name,
.pct-report-container .title-officer-name {
    text-align: left !important;
    font-weight: 600;
    color: var(--report-primary);
    padding-left: 16px !important;
}

/* Currency & Numbers */
.pct-report-container .currency {
    text-align: right;
    font-family: 'Nunito', -apple-system, sans-serif;
    font-weight: 700;
    color: #0066CC;
    padding-right: 12px !important;
}

.pct-report-container .number {
    text-align: right;
    font-family: 'Nunito', -apple-system, sans-serif;
    font-weight: 600;
}

.pct-report-container .percentage {
    text-align: right;
    font-family: 'Nunito', -apple-system, sans-serif;
    font-weight: 600;
}

/* Performance Indicators */
.pct-report-container .high-performance {
    color: #10b981;
    font-weight: 700;
    position: relative;
}

.pct-report-container .medium-performance {
    color: #f59e0b;
    font-weight: 700;
}

.pct-report-container .low-performance {
    color: #ef4444;
    font-weight: 700;
}

/* Branch Totals */
.pct-report-container .branch-totals td {
    font-weight: 700 !important;
    background: linear-gradient(135deg, #e8f4fd 0%, #dbeafe 100%) !important;
    color: var(--report-primary) !important;
    border-top: 2px solid var(--report-primary-light) !important;
}

/* Service Type Badges */
.pct-report-container .service-escrow {
    background: linear-gradient(135deg, #d1fae5 0%, #a7f3d0 100%) !important;
    color: #059669 !important;
    font-weight: 600;
}

.pct-report-container .service-title-resale {
    background: linear-gradient(135deg, #dbeafe 0%, #bfdbfe 100%) !important;
    color: #1d4ed8 !important;
    font-weight: 600;
}

.pct-report-container .service-title-refi {
    background: linear-gradient(135deg, #fef3c7 0%, #fde68a 100%) !important;
    color: #d97706 !important;
    font-weight: 600;
}

/* Enhanced Mapping Note */
.pct-report-container .mapping-note {
    background: linear-gradient(135deg, #ecfdf5 0%, #d1fae5 100%);
    border: none;
    border-left: 4px solid #10b981;
    border-radius: 8px;
    padding: 18px 20px;
    margin: 20px 0;
    font-size: 13px;
    box-shadow: 0 2px 10px rgba(16, 185, 129, 0.1);
}

.pct-report-container .mapping-note strong {
    color: #059669;
}

/* Month Select Enhancement */
.pct-report-container #monthSelect {
    width: 180px;
    padding: 10px 14px;
    border: 2px solid #e5e7eb;
    border-radius: 8px;
    font-weight: 500;
    background: white;
    transition: all 0.2s ease;
    cursor: pointer;
}

.pct-report-container #monthSelect:hover {
    border-color: var(--report-primary-light);
}

.pct-report-container #monthSelect:focus {
    outline: none;
    border-color: var(--report-primary);
    box-shadow: 0 0 0 3px rgba(68, 114, 196, 0.1);
}

/* Toggle Icon Animation */
.pct-report-container .toggle-icon { transition: transform 0.3s ease; }
.pct-report-container .toggle-icon.collapsed { transform: rotate(-90deg); }

/* Executive Summary */
.pct-report-container .executive-summary {
    background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);
    border: none;
    border-left: 4px solid var(--report-primary);
    border-radius: 12px;
    padding: 24px;
    margin: 20px 0 30px 0;
    box-shadow: 0 4px 15px rgba(0,0,0,0.05);
}

.pct-report-container .summary-title {
    font-size: 18px;
    font-weight: 700;
    color: var(--report-primary);
    margin-bottom: 15px;
    text-align: center;
}

/* Metric Headers */
.pct-report-container .metric-header {
    background: linear-gradient(135deg, #eff6ff 0%, #dbeafe 100%);
    border: none;
    border-left: 4px solid var(--report-primary-light);
    padding: 12px 18px;
    margin: 24px 0 8px 0;
    font-weight: 600;
    font-size: 13px;
    color: var(--report-primary);
    border-radius: 6px;
}

/* Page Header Fix */
.pct-report-container.pct-admin-listing .page-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    flex-wrap: wrap;
    gap: 1rem;
    margin-bottom: 1.5rem;
}

.pct-report-container.pct-admin-listing .page-header h1 {
    margin: 0;
    font-size: 1.5rem;
    font-weight: 700;
    color: #1e293b;
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.pct-report-container.pct-admin-listing .page-header .action-buttons {
    display: flex;
    align-items: center;
    gap: 0.75rem;
}

/* Month Dropdown Styling */
.pct-report-container.pct-admin-listing .page-header .action-buttons #monthSelect {
    width: auto;
    min-width: 180px;
    padding: 8px 32px 8px 14px;
    border: 2px solid #e2e8f0;
    border-radius: 8px;
    font-size: 0.9rem;
    font-weight: 500;
    color: #1e293b;
    background-color: #fff;
    background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 16 16'%3e%3cpath fill='none' stroke='%23343a40' stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='m2 5 6 6 6-6'/%3e%3c/svg%3e");
    background-repeat: no-repeat;
    background-position: right 0.75rem center;
    background-size: 12px;
    -webkit-appearance: none;
    -moz-appearance: none;
    appearance: none;
    cursor: pointer;
    transition: border-color 0.2s ease, box-shadow 0.2s ease;
}

.pct-report-container.pct-admin-listing .page-header .action-buttons #monthSelect:hover {
    border-color: var(--report-primary-light);
}

.pct-report-container.pct-admin-listing .page-header .action-buttons #monthSelect:focus {
    outline: none;
    border-color: var(--report-primary);
    box-shadow: 0 0 0 3px rgba(68, 114, 196, 0.15);
}
</style>

<div class="pct-admin-listing pct-report-container">
    <!-- Enhanced Page Header -->
    <div class="page-header">
        <h1><i class="fas fa-chart-bar"></i> Branch Analytics Report</h1>
        
        <div class="action-buttons" style="display:flex; align-items:center;width:auto; min-width:180px;">
            <select id="monthSelect" class="form-control" onchange="changeMonth()" data-filter="branch_analytics" style="padding:8px 14px; border:2px solid #e2e8f0; border-radius:8px; font-size:0.9rem; font-weight:500; color:#1e293b; background-color:#fff; cursor:pointer; -webkit-appearance:menulist; appearance:menulist;">
                <?php
                $currentMonth = date("Y-m");
                for ($i = 0; $i < 12; $i++) { 
                    $date = strtotime("-$i month");
                    $value = date("Y-m", $date);
                    $label = date("F Y", $date);
                    if (((int)date('m', $date) < 3) && ((int)date('Y', $date) == 2025)) {
                        break;
                    }
                ?>
                    <option <?php echo ($value == $currentMonth) ? 'selected' : ''; ?> value="<?php echo $value;?>"><?php echo $label;?></option>
                <?php }?>
            </select>
        </div>
    </div>

    <!-- Report Content Card -->
    <div class="modern-card">
        <div class="report-header-banner">
            <h2><i class="fas fa-building"></i> Branch Analytics Overview</h2>
            <span class="report-date-badge">
                <i class="fas fa-calendar-alt mr-2"></i>As of <?php echo date('F d, Y', strtotime('-1 day')) ?>
            </span>
        </div>
        <div class="modern-card-body">
            <div id="branchSections">
                <?php if (isset($error) && $error) {
                } else {
                    echo $branch_analytics_reports; 
                }
                ?>
            </div>
        </div>
    </div>
</div>

<script>
function toggleSection(sectionId) {
    const content = document.getElementById(sectionId + '-content');
    const icon = document.getElementById(sectionId + '-icon');
    
    if (content.classList.contains('collapsed')) {
        content.classList.remove('collapsed');
        icon.classList.remove('collapsed');
        icon.textContent = '▼';
    } else {
        content.classList.add('collapsed');
        icon.classList.add('collapsed');
        icon.textContent = '▶';
    }
}

function changeMonth() {}

$(document).ready(function() {});
</script>
