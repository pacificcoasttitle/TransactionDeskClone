<style>

}

.report-header {
    background: linear-gradient(to bottom, #4472C4, #365F94);
    color: white;
    padding: 15px 20px;
    margin: -20px -20px 20px -20px;
    border-bottom: 2px solid #2F5597;
}

.report-title {
    font-size: 18pt;
    font-weight: bold;
    margin: 0;
    letter-spacing: 0.5px;
}

.report-subtitle {
    font-size: 12pt;
    margin: 5px 0 0 0;
    opacity: 0.9;
}

/* Executive Summary Section */
.executive-summary {
    background: linear-gradient(135deg, #F8F9FA, #E9ECEF);
    border: 2px solid #4472C4;
    border-radius: 8px;
    padding: 20px;
    margin: 20px 0 30px 0;
}

.summary-title {
    font-size: 16pt;
    font-weight: bold;
    color: #1F4E79;
    margin-bottom: 15px;
    text-align: center;
}

/* Branch Section Headers */
.branch-header {
    background: linear-gradient(to bottom, #1F4E79, #2F5597);
    color: white;
    padding: 12px 20px;
    margin: 30px 0 8px 0;
    font-weight: bold;
    font-size: 14pt;
    border-radius: 5px;
    text-align: center;
    cursor: pointer;
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.branch-header:hover {
    background: linear-gradient(to bottom, #2F5597, #1F4E79);
}

/* Metric Section Headers */
.metric-header {
    background: linear-gradient(to bottom, #E7F3FF, #D1E7FF);
    border: 1px solid #B4D5F0;
    padding: 10px 15px;
    margin: 20px 0 5px 0;
    font-weight: bold;
    font-size: 12pt;
    color: #1F4E79;
    border-radius: 3px;
}

/* Analytics tables */
.branch-table {
    border-collapse: collapse;
    width: 100%;
    margin: 0 0 20px 0;
    border: 1px solid #D4D4D4;
    font-size: 14px;
    box-shadow: 0 1px 3px rgba(0,0,0,0.1);
}

.branch-table th {
    background: linear-gradient(to bottom, #F8F9FA, #E9ECEF);
    border: 1px solid #D4D4D4;
    padding: 10px 12px;
    text-align: left;
    font-weight: bold;
    color: #495057;
    font-size: 13px;
    white-space: nowrap;
}

.branch-table td {
    border: 1px solid #D4D4D4;
    padding: 8px 12px;
    vertical-align: middle;
    background-color: #ffffff;
}

.branch-table tr:nth-child(even) td {
    background-color: #F8F9FA;
}

.branch-table tr:hover td {
    background-color: #E3F2FD;
}

/* Service type styling */
.service-escrow { 
    background-color: #E8F5E8 !important; 
    font-weight: bold;
    color: #2E7D32;
}

.service-title-resale { 
    background-color: #E3F2FD !important; 
    font-weight: bold;
    color: #1565C0;
}

.service-title-refi { 
    background-color: #FFF3E0 !important; 
    font-weight: bold;
    color: #EF6C00;
}

/* Number formatting */
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

.center {
    text-align: center;
}

/* Branch content */
.branch-content {
    display: block;
    transition: all 0.3s ease;
}

.branch-content.collapsed {
    display: none;
}

.toggle-icon {
    font-size: 14pt;
    transition: transform 0.3s ease;
}

.toggle-icon.collapsed {
    transform: rotate(-90deg);
}

/* Controls */
.controls {
    background: linear-gradient(135deg, #F8F9FA, #E9ECEF);
    border: 1px solid #4472C4;
    border-radius: 5px;
    padding: 15px;
    margin: 20px 0;
}

.controls label {
    font-size: 12pt;
    font-weight: bold;
    margin-right: 15px;
    color: #1F4E79;
}

.controls select, #monthSelect {
    font-size: 11pt;
    padding: 5px 10px;
    border: 1px solid #D4D4D4;
    border-radius: 3px;
    background: white;
}
#monthSelect, .d-sm-inline-block {
    width: 170px;
}
</style>

<div class="container-fluid">
    <!-- Report Header -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Branch Analytics Report: As on <?php echo date('m-d-Y', strtotime('-1 day')) ?></h1>
        <div class="d-sm-inline-block">
            <select id="monthSelect" class="form-control" onchange="changeMonth()" data-filter="branch_analytics">
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
                <!-- <option value="August 2025" selected>August 2025</option>
                <option value="July 2025">July 2025</option>
                <option value="June 2025">June 2025</option>
                <option value="May 2025">May 2025</option>
                <option value="April 2025">April 2025</option>
                <option value="March 2025">March 2025</option> -->
            </select>
        </div>
    </div>

    <!-- Mapping Logic Explanation -->
    <!-- <div class="mapping-note">
        <strong>📋 Sales Rep Mapping Logic:</strong> Sales representatives are displayed in their assigned branch from the mapping file (including zero production). 
        Additionally, reps appear in other branches where they have actual transactions. 
        <strong>4-Month Closing Ratio:</strong> Calculated as (Closings ÷ Openings) × 100 over the past 4 months.
    </div> -->

    <!-- <div id="branchSummarySections">
        <?php if (isset($error) && $error) {
                            
        } else {
            echo $summary_reports; 
        }
        ?>
    </div> -->

    <!-- Branch sections will be dynamically loaded here -->
    <div id="branchSections">
        <?php if (isset($error) && $error) {
                            
        } else {
            echo $branch_analytics_reports; 
        }
        ?>
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

function changeMonth() {
    // const monthSelect = document.getElementById('monthSelect');
    // const selectedMonth = monthSelect.value;
    
    // if (selectedMonth !== 'August 2025') {
    //     alert('Data loading for ' + selectedMonth + ' would be implemented here.');
    // }
}

// Load branch data when page loads
$(document).ready(function() {
    // Add your AJAX call here to load the branch data
    // For now, we'll use the static HTML from the original file
    // $('#branchSections').load('<?php echo base_url(); ?>order/get_mapped_report_data');
});
</script>
