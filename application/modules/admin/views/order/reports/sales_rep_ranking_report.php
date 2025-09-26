<style>
/* R-14 Report Styling - Adapted for Dashboard */
.branch-section {
    margin: 20px 0;
    border: 1px solid #D4D4D4;
    border-radius: 8px;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
}

.branch-toggle {
    background: linear-gradient(to bottom, #1F4E79, #2F5597);
    color: white;
    padding: 15px 20px;
    font-weight: bold;
    font-size: 14pt;
    border: none;
    width: 100%;
    text-align: left;
    cursor: pointer;
    border-radius: 8px 8px 0 0;
    display: flex;
    justify-content: space-between;
    align-items: center;
    transition: all 0.3s ease;
}

.branch-toggle:hover {
    background: linear-gradient(to bottom, #2F5597, #4472C4);
}

.branch-toggle .toggle-icon {
    font-size: 12pt;
    transition: transform 0.3s ease;
}

.branch-content {
    padding: 20px;
    background-color: white;
    border-radius: 0 0 8px 8px;
    display: block;
}

.branch-content.collapsed {
    display: none;
}

.salesrep-table {
    border-collapse: collapse;
    width: 100%;
    margin: 0 0 20px 0;
    border: 1px solid #D4D4D4;
    font-size: 14px;
    box-shadow: 0 1px 3px rgba(0,0,0,0.1);
}

.salesrep-table th {
    background: linear-gradient(to bottom, #F8F9FA, #E9ECEF);
    border: 1px solid #D4D4D4;
    padding: 12px 8px;
    text-align: center;
    font-weight: bold;
    color: #495057;
    font-size: 13px;
    white-space: nowrap;
}

.salesrep-table td {
    border: 1px solid #D4D4D4;
    padding: 8px 6px;
    text-align: center;
    vertical-align: middle;
    background-color: #ffffff;
    font-size: 13px;
}

.salesrep-table tr:nth-child(even) td {
    background-color: #F8F9FA;
}

.salesrep-table tr:hover td {
    background-color: #E3F2FD;
}

.salesrep-name {
    text-align: left !important;
    font-weight: bold;
    color: #1F4E79;
    padding-left: 12px !important;
}

.currency {
    text-align: right;
    font-family: Nunito,-apple-system,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,sans-serif,"Apple Color Emoji","Segoe UI Emoji","Segoe UI Symbol","Noto Color Emoji";
    font-weight: bold;
    color: #0066CC;
}

.number {
    text-align: right;
    font-family: Nunito,-apple-system,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,sans-serif,"Apple Color Emoji","Segoe UI Emoji","Segoe UI Symbol","Noto Color Emoji";
    font-weight: bold;
}

.percentage {
    text-align: right;
    font-family: Nunito,-apple-system,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,sans-serif,"Apple Color Emoji","Segoe UI Emoji","Segoe UI Symbol","Noto Color Emoji";
    font-weight: bold;
}

.high-performance { color: #28a745; font-weight: bold; }
.medium-performance { color: #ffc107; font-weight: bold; }
.low-performance { color: #dc3545; font-weight: bold; }

.branch-totals td {
    font-weight: bold !important;
    background: linear-gradient(135deg, #F0F8FF, #E6F3FF) !important;
    color: #1F4E79 !important;
}

.mapping-note {
    background: #e8f5e8;
    border: 1px solid #4caf50;
    border-radius: 5px;
    padding: 15px;
    margin: 20px 0;
    font-size: 11pt;
}

#monthSelect, .d-sm-inline-block {
    width: 170px;
}
</style>

<div class="container-fluid">
    <!-- Report Header -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">R-14 Mapped Report as of : <?php echo date('m-d-Y', strtotime('-1 day')) ?></h1>
        <div class="d-sm-inline-block">
            <select id="monthSelect" class="form-control" data-filter="sales_rep_ranking">
                <?php
                $currentMonth = date("Y-m");
                for ($i = 0; $i < 5; $i++) { 
                    $date = strtotime("-$i month");
                    $value = date("Y-m", $date); // for option value (e.g., 2024-07)
                    $label = date("F Y", $date); // for display (e.g., July 2024)
                    // if ((int)date('Y', $date) < 2025) {
                    //     break; // Skip years before 2025
                    // }

                    if (((int)date('m', $date) < 3) && ((int)date('Y', $date) == 2025)) {
                        break; // Skip years before 2025
                    }
                ?>
                    <option <?php echo ($value == $currentMonth) ? 'selected' : ''; ?> value="<?php echo $value;?>"><?php echo $label;?></option>
                <?php }?>
            </select>
            <input type="hidden" id="reportType" value="">
        </div>
    </div>

    <!-- Mapping Logic Explanation -->
    <div class="mapping-note">
        <strong>📋 Sales Rep Mapping Logic:</strong> Sales representatives are displayed in their assigned branch from the mapping file (including zero production). 
        Additionally, reps appear in other branches where they have actual transactions. 
        <strong>4-Month Closing Ratio:</strong> Calculated as (Closings ÷ Openings) × 100 over the past 4 months.
    </div>
    
    <!-- Branch sections will be dynamically loaded here -->
    <div id="branchSections">
        <?php if (isset($error) && $error) {
                            
        } else {
            echo $branch_reports; 
        }
        ?>
    </div>
</div>

<script>
function toggleBranch(branchId) {
    const content = document.getElementById(branchId);
    const icon = document.getElementById(branchId + '-icon');
    
    if (content.classList.contains('collapsed')) {
        content.classList.remove('collapsed');
        icon.textContent = '▼';
    } else {
        content.classList.add('collapsed');
        icon.textContent = '▶';
    }
}

// function changeMonth() {
//     const monthSelect = document.getElementById('monthSelect');
//     const selectedMonth = monthSelect.value;
    
//     if (selectedMonth !== 'August 2025') {
//         alert('Data loading for ' + selectedMonth + ' would be implemented here.');
//     }
// }

// Load branch data when page loads
$(document).ready(function() {
    // Add your AJAX call here to load the branch data
    // For now, we'll use the static HTML from the original file
    // $('#branchSections').load('<?php echo base_url(); ?>order/get_mapped_report_data');
});
</script>
