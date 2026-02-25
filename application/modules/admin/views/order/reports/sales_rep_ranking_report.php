<style>
/* Enhanced Report Styles - Premium Look */
.pct-report-container {
    --report-primary: #1F4E79;
    --report-primary-light: #4472C4;
    --report-accent: #2F5597;
    --report-gradient: linear-gradient(135deg, #1F4E79 0%, #4472C4 100%);
    --report-card-shadow: 0 10px 40px rgba(31, 78, 121, 0.15);
}

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

.pct-report-container .report-header-banner h2 { color: white; font-size: 1.5rem; font-weight: 700; margin: 0; display: flex; align-items: center; gap: 12px; }
.pct-report-container .report-header-banner h2 i { font-size: 1.8rem; opacity: 0.9; }

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

.pct-report-container .branch-section {
    margin: 20px 0;
    border: none;
    border-radius: 12px;
    box-shadow: 0 4px 20px rgba(0,0,0,0.08);
    overflow: hidden;
    transition: all 0.3s ease;
}

.pct-report-container .branch-section:hover { box-shadow: 0 8px 30px rgba(31, 78, 121, 0.15); transform: translateY(-2px); }

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
    display: flex;
    justify-content: space-between;
    align-items: center;
    transition: all 0.3s ease;
}

.pct-report-container .branch-toggle:hover { background: linear-gradient(135deg, #2F5597 0%, #5a8fd4 100%); }
.pct-report-container .branch-toggle .toggle-icon { font-size: 14px; background: rgba(255,255,255,0.2); width: 28px; height: 28px; border-radius: 50%; display: flex; align-items: center; justify-content: center; }

.pct-report-container .branch-content { padding: 24px; background: linear-gradient(180deg, #ffffff 0%, #f8f9fc 100%); display: block; }
.pct-report-container .branch-content.collapsed { display: none; }

.pct-report-container .salesrep-table { border-collapse: separate; border-spacing: 0; width: 100%; margin: 0 0 24px 0; border-radius: 10px; overflow: hidden; box-shadow: 0 4px 15px rgba(0,0,0,0.05); }
.pct-report-container .salesrep-table th { background: linear-gradient(135deg, #f8f9fc 0%, #e9ecef 100%); border: none; border-bottom: 2px solid #dee2e6; padding: 14px 12px; text-align: center; font-weight: 700; color: var(--report-primary); font-size: 12px; text-transform: uppercase; letter-spacing: 0.5px; }
.pct-report-container .salesrep-table td { border: none; border-bottom: 1px solid #eef0f5; padding: 12px 10px; text-align: center; background-color: #ffffff; font-size: 13px; transition: all 0.2s ease; }
.pct-report-container .salesrep-table tr:nth-child(even) td { background-color: #f8f9fc; }
.pct-report-container .salesrep-table tr:hover td { background-color: #e8f4fd !important; }

.pct-report-container .salesrep-name { text-align: left !important; font-weight: 600; color: var(--report-primary); padding-left: 16px !important; }
.pct-report-container .currency { text-align: right; font-family: 'Nunito', sans-serif; font-weight: 700; color: #0066CC; }
.pct-report-container .number { text-align: right; font-family: 'Nunito', sans-serif; font-weight: 600; }
.pct-report-container .percentage { text-align: right; font-family: 'Nunito', sans-serif; font-weight: 600; }
.pct-report-container .high-performance { color: #10b981; font-weight: 700; }
.pct-report-container .medium-performance { color: #f59e0b; font-weight: 700; }
.pct-report-container .low-performance { color: #ef4444; font-weight: 700; }
.pct-report-container .branch-totals td { font-weight: 700 !important; background: linear-gradient(135deg, #e8f4fd 0%, #dbeafe 100%) !important; color: var(--report-primary) !important; border-top: 2px solid var(--report-primary-light) !important; }

.pct-report-container .mapping-note { background: linear-gradient(135deg, #ecfdf5 0%, #d1fae5 100%); border: none; border-left: 4px solid #10b981; border-radius: 8px; padding: 18px 20px; margin: 20px 0; font-size: 13px; box-shadow: 0 2px 10px rgba(16, 185, 129, 0.1); }
.pct-report-container .mapping-note strong { color: #059669; }

.pct-report-container #monthSelect { width: 180px; padding: 10px 14px; border: 2px solid #e5e7eb; border-radius: 8px; font-weight: 500; background: white; transition: all 0.2s ease; }
.pct-report-container #monthSelect:hover { border-color: var(--report-primary-light); }
.pct-report-container #monthSelect:focus { outline: none; border-color: var(--report-primary); box-shadow: 0 0 0 3px rgba(68, 114, 196, 0.1); }
</style>

<div class="pct-admin-listing pct-report-container">
    <div class="page-header">
        <h1><i class="fas fa-trophy"></i> Sales Ranking Report</h1>
        
        <div class="action-buttons" style="display:flex; align-items:center;width:auto; min-width:180px;">
            <select id="monthSelect" class="form-control" data-filter="sales_rep_ranking">
                <?php
                $currentMonth = date("Y-m");
                for ($i = 0; $i < 5; $i++) { 
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
            <input type="hidden" id="reportType" value="">
        </div>
    </div>

    <div class="modern-card">
        <div class="report-header-banner">
            <h2><i class="fas fa-medal"></i> Top Performers Ranking</h2>
            <span class="report-date-badge">
                <i class="fas fa-calendar-alt mr-2"></i>As of <?php echo date('F d, Y', strtotime('-1 day')) ?>
            </span>
        </div>
        <div class="modern-card-body">
            <div class="mapping-note">
                <strong>📋 Sales Rep Mapping Logic:</strong> Sales representatives are displayed in their assigned branch from the mapping file (including zero production). 
                Additionally, reps appear in other branches where they have actual transactions. 
                <strong>4-Month Closing Ratio:</strong> Calculated as (Closings ÷ Openings) × 100 over the past 4 months.
            </div>
            
            <div id="branchSections">
                <?php if (isset($error) && $error) {
                } else {
                    echo $branch_reports; 
                }
                ?>
            </div>
        </div>
    </div>
</div>

<script>
function toggleBranch(branchId) {
    const content = document.getElementById(branchId);
    const icon = document.getElementById(branchId + '-icon');
    if (content.classList.contains('collapsed')) { content.classList.remove('collapsed'); icon.textContent = '▼'; } 
    else { content.classList.add('collapsed'); icon.textContent = '▶'; }
}
$(document).ready(function() {});
</script>
