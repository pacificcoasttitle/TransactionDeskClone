<?php
/**
 * NEW MANAGEMENT REPORTS CONTROLLER
 * =================================
 * 
 * PLUG AND PLAY - Drop this file into:
 * application/modules/admin/controllers/order/ManagementReports.php
 * 
 * Then add these routes to application/config/routes.php:
 * 
 * $route['order/admin/new-daily-revenue']           = 'admin/order/managementReports/dailyRevenue';
 * $route['order/admin/new-r14-branches']            = 'admin/order/managementReports/r14Branches';
 * $route['order/admin/new-r14-ranking']             = 'admin/order/managementReports/r14Ranking';
 * $route['order/admin/new-title-officer']           = 'admin/order/managementReports/titleOfficerProduction';
 * $route['order/admin/new-escrow-production']       = 'admin/order/managementReports/escrowProduction';
 * 
 * AJAX routes:
 * $route['order/admin/get-new-daily-revenue']       = 'admin/order/managementReports/getDailyRevenue';
 * $route['order/admin/get-new-r14-branches']        = 'admin/order/managementReports/getR14Branches';
 * $route['order/admin/get-new-r14-ranking']         = 'admin/order/managementReports/getR14Ranking';
 * $route['order/admin/get-new-title-officer']       = 'admin/order/managementReports/getTitleOfficerProduction';
 * $route['order/admin/get-new-escrow-production']   = 'admin/order/managementReports/getEscrowProduction';
 * 
 * @author      Development Team
 * @created     January 7, 2026
 * @version     1.0.0
 */

(defined('BASEPATH')) or exit('No direct script access allowed');

class ManagementReports extends MX_Controller
{
    // =========================================================================
    // CONFIGURATION - Adjust these if needed
    // =========================================================================
    
    /**
     * Standard lookback period (in months) for closing ratio calculation
     */
    const LOOKBACK_MONTHS = 3;
    
    /**
     * Extended lookback on first of month
     */
    const LOOKBACK_MONTHS_FIRST = 4;
    
    /**
     * Closed orders lookback (how far back to look for orders that closed)
     */
    const CLOSED_LOOKBACK_MONTHS = 1;
    const CLOSED_LOOKBACK_MONTHS_FIRST = 2;

    // =========================================================================
    // CONSTRUCTOR
    // =========================================================================
    
    public function __construct()
    {
        parent::__construct();
        $this->load->helper(['file', 'url']);
        $this->load->library('session');
        $this->load->library('order/adminTemplate');
        $this->load->library('order/common_lib');
        $this->load->library('order/order');
        $this->common_lib->is_admin();
    }

    // =========================================================================
    // UNIFIED DATE CALCULATION - ALL REPORTS USE THIS
    // =========================================================================
    
    /**
     * Calculate all date parameters used by reports
     * This ensures CONSISTENCY across all reports
     * 
     * @param string|null $yearMonth  Optional YYYY-MM format for historical view
     * @return array Date parameters
     */
    private function calculateDateParams($yearMonth = null)
    {
        $isFirstOfMonth = (date('d') == '01');
        $isAjax = $this->input->is_ajax_request();
        
        // If AJAX with month filter
        if ($isAjax && !empty($yearMonth)) {
            list($year, $month) = explode('-', $yearMonth);
            
            // Check if viewing current month or historical
            if ($month != date('m') || $year != date('Y')) {
                // HISTORICAL VIEW
                $selectedDate = strtotime($yearMonth . "-01");
                return [
                    'startMonth'       => date('Y-m-01 00:00:00', strtotime('-' . self::LOOKBACK_MONTHS . ' months', $selectedDate)),
                    'closedStartMonth' => date('Y-m-01 00:00:00', strtotime('-' . self::CLOSED_LOOKBACK_MONTHS . ' months', $selectedDate)),
                    'endDate'          => date('Y-m-t 23:59:59', $selectedDate),
                    'today'            => 0, // No "today" for historical
                    'month'            => $month,
                    'year'             => $year,
                    'priorMonth'       => date('m', strtotime('-1 months', $selectedDate)),
                    'priorYear'        => date('Y', strtotime('-1 months', $selectedDate)),
                    'monthName'        => date("F", strtotime($yearMonth . "-01")),
                    'workedDays'       => $this->order->countDaysOfMonth($month, $year),
                    'workingDaysRemaining' => 0,
                ];
            }
        }
        
        // CURRENT MONTH VIEW (default or AJAX current month)
        if ($isFirstOfMonth) {
            $lookback = self::LOOKBACK_MONTHS_FIRST;
            $closedLookback = self::CLOSED_LOOKBACK_MONTHS_FIRST;
            $priorOffset = 2;
        } else {
            $lookback = self::LOOKBACK_MONTHS;
            $closedLookback = self::CLOSED_LOOKBACK_MONTHS;
            $priorOffset = 1;
        }
        
        $today = date('d', strtotime('-1 day'));
        $month = date('m', strtotime('-1 day'));
        $year = date('Y', strtotime('-1 day'));
        
        return [
            'startMonth'       => date('Y-m-01 00:00:00', strtotime("-{$lookback} months")),
            'closedStartMonth' => date('Y-m-01 00:00:00', strtotime("-{$closedLookback} months")),
            'endDate'          => date('Y-m-d 23:59:59', strtotime('-1 day')),
            'today'            => $today,
            'month'            => $month,
            'year'             => $year,
            'priorMonth'       => date('m', strtotime("-{$priorOffset} month")),
            'priorYear'        => date('Y', strtotime("-{$priorOffset} month")),
            'monthName'        => date("F", strtotime('-1 day')),
            'workedDays'       => $this->order->countDaysOfMonth($month, $year),
            'workingDaysRemaining' => $this->order->countWokingsDaysLeftOfSelectedMonth($today, $month, $year),
        ];
    }

    // =========================================================================
    // UNIFIED BASE QUERY - ALL REPORTS USE THIS
    // =========================================================================
    
    /**
     * Get all order data with consistent filtering
     * 
     * @param string $startMonth       Start date for created_at (open orders lookback)
     * @param string $endDate          End date for both created_at and sent_to_accounting_date
     * @param string $closedStartMonth Start date for sent_to_accounting_date (closed orders lookback)
     * @param string $personField      'sales_representative' or 'title_officer'
     * @param string $nameField        'full_name' or 'officer_name'
     * @return array Order records
     */
    private function getOrderData($startMonth, $endDate, $closedStartMonth, $personField = 'sales_representative', $nameField = 'full_name')
    {
        $this->db->select("
            o.id as order_id,
            o.file_number,
            o.premium,
            o.created_at,
            o.sent_to_accounting_date,
            o.softpro_status,
            t.sales_representative,
            t.title_officer,
            t.transaction_type,
            u.{$nameField} as person_name,
            u.full_name as sales_rep_name,
            ot.order_type
        ")
        ->from('order_details o')
        ->join('transaction_details t', 'o.transaction_id = t.id', 'left')
        ->join('pct_softpro_lookup_table u', "t.{$personField} = u.id", 'left')
        ->join('pct_softpro_order_type ot', 't.order_type = ot.id', 'left');
        
        // Date filter: Include orders that were CREATED or CLOSED in our window
        $this->db->group_start();
            // Closed orders: Use closedStartMonth for sent_to_accounting_date
            $this->db->group_start();
                $this->db->where('o.sent_to_accounting_date >=', $closedStartMonth);
                $this->db->where('o.sent_to_accounting_date <=', $endDate);
            $this->db->group_end();
            // OR Open orders: Use startMonth for created_at
            $this->db->or_group_start();
                $this->db->where('o.created_at >=', $startMonth);
                $this->db->where('o.created_at <=', $endDate);
            $this->db->group_end();
        $this->db->group_end();
        
        // Required filters
        $this->db->where('o.is_softpro_order', 1);
        $this->db->where('o.file_number is not null');
        
        return $this->db->get()->result_array();
    }

    // =========================================================================
    // HELPER FUNCTIONS
    // =========================================================================
    
    /**
     * Determine branch from file number
     * 
     * @param string $fileNumber
     * @param string $orderType
     * @return string|null Branch name or null if unknown
     */
    private function getBranch($fileNumber, $orderType)
    {
        if (strpos($fileNumber, 'GLT') !== false) {
            return 'Glendale';
        } elseif (strpos($fileNumber, 'OCT') !== false) {
            return 'Orange';
        } elseif (strpos($fileNumber, 'ONT') !== false) {
            return 'Inland Empire';
        } elseif (strpos($fileNumber, 'PRV') !== false) {
            return 'Porterville';
        } elseif (strpos($fileNumber, 'TSG') !== false || strtolower($orderType) == 'trustee sale guarantee') {
            return 'TSG';
        }
        return null; // Unknown branch - skip
    }
    
    /**
     * Categorize order into display category
     * 
     * @param string $orderType       Order type (Title Only, Escrow Only, etc.)
     * @param string $transactionType Transaction type (Purchase, Refinance)
     * @return string|null Category (purchase, refi, escrow, tsg) or null
     */
    private function categorizeOrder($orderType, $transactionType)
    {
        $orderTypeLower = strtolower($orderType ?? '');
        
        if ($orderTypeLower == 'title only') {
            if ($transactionType == 'Purchase') return 'purchase';
            if ($transactionType == 'Refinance') return 'refi';
            return null; // Unknown transaction type
        }
        
        if ($orderTypeLower == 'title & escrow' || $orderTypeLower == 'escrow only') {
            return 'escrow';
        }
        
        if ($orderTypeLower == 'trustee sale guarantee') {
            return 'tsg';
        }
        
        return null; // Unknown order type (Limited Coverage Product, Other, etc.)
    }
    
    /**
     * Categorize order for Title Officer report
     * Title Officers get credit for title work, split by transaction type
     * 
     * @param string $orderType
     * @param string $transactionType
     * @return string|null Category (purchase, refi) or null
     */
    private function categorizeForTitleOfficer($orderType, $transactionType)
    {
        $orderTypeLower = strtolower($orderType ?? '');
        
        // Title Officer only counts Title Only and Title & Escrow
        if ($orderTypeLower == 'title only' || $orderTypeLower == 'title & escrow') {
            if ($transactionType == 'Purchase') return 'purchase';
            if ($transactionType == 'Refinance') return 'refi';
        }
        
        return null; // Escrow Only and TSG are NOT title officer work
    }
    
    /**
     * Categorize order for Escrow report
     * 
     * @param string $orderType
     * @return bool Whether this is an escrow order
     */
    private function isEscrowOrder($orderType)
    {
        $orderTypeLower = strtolower($orderType ?? '');
        return ($orderTypeLower == 'title & escrow' || $orderTypeLower == 'escrow only');
    }
    
    /**
     * Initialize counter array for a person (sales rep or title officer)
     * 
     * @param string $name Person's name
     * @return array Initialized counters
     */
    private function initPersonCounters($name)
    {
        return [
            'sales_rep' => $name ?? 'Unassigned',
            
            // Purchase
            'today_purchase_cnt' => 0,
            'today_purchase_rev' => 0,
            'mtd_purchase_cnt' => 0,
            'mtd_purchase_rev' => 0,
            'prior_purchase_cnt' => 0,
            'prior_purchase_rev' => 0,
            
            // Refinance
            'today_refi_cnt' => 0,
            'today_refi_rev' => 0,
            'mtd_refi_cnt' => 0,
            'mtd_refi_rev' => 0,
            'prior_refi_cnt' => 0,
            'prior_refi_rev' => 0,
            
            // Escrow
            'today_escrow_cnt' => 0,
            'today_escrow_rev' => 0,
            'mtd_escrow_cnt' => 0,
            'mtd_escrow_rev' => 0,
            'prior_escrow_cnt' => 0,
            'prior_escrow_rev' => 0,
            
            // TSG
            'today_tsg_cnt' => 0,
            'today_tsg_rev' => 0,
            'mtd_tsg_cnt' => 0,
            'mtd_tsg_rev' => 0,
            'prior_tsg_cnt' => 0,
            'prior_tsg_rev' => 0,
            
            // Closing ratio
            'created_4m' => 0,
            'closed_4m' => 0,
            'closing_ratio' => 0,
        ];
    }
    
    /**
     * Initialize counter array for a branch
     * 
     * @return array Initialized counters
     */
    private function initBranchCounters()
    {
        return [
            // Purchase - Open
            'today_purchase_open_cnt' => 0,
            'mtd_purchase_open_cnt' => 0,
            'prior_purchase_open_cnt' => 0,
            
            // Purchase - Closed
            'today_purchase_close_cnt' => 0,
            'mtd_purchase_close_cnt' => 0,
            'prior_purchase_close_cnt' => 0,
            
            // Purchase - Revenue
            'today_purchase_rev' => 0,
            'mtd_purchase_rev' => 0,
            'prior_purchase_rev' => 0,
            
            // Refi - Open
            'today_refi_open_cnt' => 0,
            'mtd_refi_open_cnt' => 0,
            'prior_refi_open_cnt' => 0,
            
            // Refi - Closed
            'today_refi_close_cnt' => 0,
            'mtd_refi_close_cnt' => 0,
            'prior_refi_close_cnt' => 0,
            
            // Refi - Revenue
            'today_refi_rev' => 0,
            'mtd_refi_rev' => 0,
            'prior_refi_rev' => 0,
            
            // Escrow - Open
            'today_escrow_open_cnt' => 0,
            'mtd_escrow_open_cnt' => 0,
            'prior_escrow_open_cnt' => 0,
            
            // Escrow - Closed
            'today_escrow_close_cnt' => 0,
            'mtd_escrow_close_cnt' => 0,
            'prior_escrow_close_cnt' => 0,
            
            // Escrow - Revenue
            'today_escrow_rev' => 0,
            'mtd_escrow_rev' => 0,
            'prior_escrow_rev' => 0,
            
            // TSG - Open
            'today_tsg_open_cnt' => 0,
            'mtd_tsg_open_cnt' => 0,
            'prior_tsg_open_cnt' => 0,
            
            // TSG - Closed
            'today_tsg_close_cnt' => 0,
            'mtd_tsg_close_cnt' => 0,
            'prior_tsg_close_cnt' => 0,
            
            // TSG - Revenue
            'today_tsg_rev' => 0,
            'mtd_tsg_rev' => 0,
            'prior_tsg_rev' => 0,
        ];
    }
    
    /**
     * Add count/revenue to appropriate period bucket
     * 
     * @param array  &$counters Reference to counter array
     * @param string $category  Category (purchase, refi, escrow, tsg)
     * @param string $period    Period (today, mtd, prior)
     * @param bool   $isOpen    True for open count, false for closed
     * @param float  $revenue   Revenue amount (only for closed)
     */
    private function addToCounter(&$counters, $category, $period, $isOpen = true, $revenue = 0)
    {
        if ($isOpen) {
            $key = "{$period}_{$category}_open_cnt";
            if (isset($counters[$key])) {
                $counters[$key]++;
            }
        } else {
            // Closed - add count and revenue
            $cntKey = "{$period}_{$category}_close_cnt";
            $revKey = "{$period}_{$category}_rev";
            
            // For person counters (no _open/_close suffix)
            if (!isset($counters[$cntKey])) {
                $cntKey = "{$period}_{$category}_cnt";
            }
            
            if (isset($counters[$cntKey])) {
                $counters[$cntKey]++;
            }
            if (isset($counters[$revKey])) {
                $counters[$revKey] += $revenue;
            }
        }
    }
    
    /**
     * Check if person has any activity (for filtering out inactive)
     * 
     * @param array $counters
     * @return bool
     */
    private function hasActivity($counters)
    {
        // Check ALL count fields (not revenue - fixes the bug in original code)
        $countFields = [
            'today_purchase_cnt', 'today_refi_cnt', 'today_escrow_cnt', 'today_tsg_cnt',
            'mtd_purchase_cnt', 'mtd_refi_cnt', 'mtd_escrow_cnt', 'mtd_tsg_cnt',
            'prior_purchase_cnt', 'prior_refi_cnt', 'prior_escrow_cnt', 'prior_tsg_cnt',
        ];
        
        foreach ($countFields as $field) {
            if (isset($counters[$field]) && $counters[$field] > 0) {
                return true;
            }
        }
        return false;
    }

    // =========================================================================
    // REPORT 1: DAILY REVENUE (Branch Analytics)
    // =========================================================================
    
    /**
     * Daily Revenue Report - Page Load
     */
    public function dailyRevenue()
    {
        if (empty($this->session->userdata('admin'))) {
            redirect(base_url() . 'order');
        }
        
        $data = [];
        $data['title'] = 'PCT Order: Daily Revenue Report (NEW)';
        $data['branch_analytics_reports'] = $this->getDailyRevenue();
        
        $this->admintemplate->addJS(base_url('assets/backend/js/dashboard.js?v=dashboard_new_1'));
        $this->admintemplate->show("order/reports", "branch_analytics_report", $data);
    }
    
    /**
     * Daily Revenue Report - Data Generation
     */
    public function getDailyRevenue()
    {
        $yearMonth = $this->input->post('month_year');
        $dates = $this->calculateDateParams($yearMonth);
        
        // Get all orders (no person filter for Daily Revenue)
        $records = $this->getOrderData(
            $dates['startMonth'],
            $dates['endDate'],
            $dates['closedStartMonth']
        );
        
        // Initialize totals
        $totals = [
            'todayTotalOpen' => 0,
            'todayTotalClose' => 0,
            'todayTotalRev' => 0,
            'mtdTotalOpen' => 0,
            'mtdTotalClose' => 0,
            'mtdTotalRev' => 0,
            'priorTotalOpen' => 0,
            'priorTotalClose' => 0,
            'priorTotalRev' => 0,
            'unassignedCount' => 0,
            'unassignedRevenue' => 0,
        ];
        
        $branches = [];
        
        foreach ($records as $row) {
            // Get branch
            $branchName = $this->getBranch($row['file_number'], $row['order_type']);
            if (!$branchName) continue;
            
            // Initialize branch if needed
            if (!isset($branches[$branchName])) {
                $branches[$branchName] = $this->initBranchCounters();
            }
            
            // Track unassigned orders
            if (empty($row['sales_representative'])) {
                $totals['unassignedCount']++;
                if (!empty($row['sent_to_accounting_date'])) {
                    $totals['unassignedRevenue'] += floatval($row['premium']);
                }
            }
            
            // Parse dates
            $createdDate = strtotime($row['created_at']);
            $createdDay = date('d', $createdDate);
            $createdMonth = date('m', $createdDate);
            $createdYear = date('Y', $createdDate);
            
            $hasRevenue = !empty($row['sent_to_accounting_date']);
            $revDay = $revMonth = $revYear = null;
            if ($hasRevenue) {
                $revDate = strtotime($row['sent_to_accounting_date']);
                $revDay = date('d', $revDate);
                $revMonth = date('m', $revDate);
                $revYear = date('Y', $revDate);
            }
            
            // Categorize order
            $category = $this->categorizeOrder($row['order_type'], $row['transaction_type']);
            if (!$category) continue;
            
            // === OPEN ORDER COUNTS (based on created_at) ===
            
            // Current month opens
            if ($createdMonth == $dates['month'] && $createdYear == $dates['year']) {
                $this->addToCounter($branches[$branchName], $category, 'mtd', true);
                $totals['mtdTotalOpen']++;
                
                // Today opens
                if ($createdDay == $dates['today']) {
                    $this->addToCounter($branches[$branchName], $category, 'today', true);
                    $totals['todayTotalOpen']++;
                }
            }
            
            // Prior month opens
            if ($createdMonth == $dates['priorMonth'] && $createdYear == $dates['priorYear']) {
                $this->addToCounter($branches[$branchName], $category, 'prior', true);
                $totals['priorTotalOpen']++;
            }
            
            // === CLOSED ORDER COUNTS & REVENUE (based on sent_to_accounting_date) ===
            
            if ($hasRevenue) {
                $revenue = floatval($row['premium']);
                
                // Current month closed
                if ($revMonth == $dates['month'] && $revYear == $dates['year']) {
                    $this->addToCounter($branches[$branchName], $category, 'mtd', false, $revenue);
                    $totals['mtdTotalClose']++;
                    $totals['mtdTotalRev'] += $revenue;
                    
                    // Today closed
                    if ($revDay == $dates['today']) {
                        $this->addToCounter($branches[$branchName], $category, 'today', false, $revenue);
                        $totals['todayTotalClose']++;
                        $totals['todayTotalRev'] += $revenue;
                    }
                }
                
                // Prior month closed
                if ($revMonth == $dates['priorMonth'] && $revYear == $dates['priorYear']) {
                    $this->addToCounter($branches[$branchName], $category, 'prior', false, $revenue);
                    $totals['priorTotalClose']++;
                    $totals['priorTotalRev'] += $revenue;
                }
            }
        }
        
        // Sort branches alphabetically
        ksort($branches);
        
        // Build response
        $analysis = [
            'monthName' => $dates['monthName'],
            'branchData' => $branches,
            'summaryData' => array_merge($totals, [
                'workedDays' => $dates['workedDays'],
                'workingDaysRemaining' => $dates['workingDaysRemaining'],
                'todayDate' => date("m-d-Y", strtotime('-1 day')),
            ]),
        ];
        
        if ($this->input->is_ajax_request()) {
            $dataRes['html'] = $this->load->view('order/reports/branch_analytics', $analysis, true);
            $res = array('status' => 'success', 'report' => $dataRes);
            echo json_encode($res);
            exit;
        }
        
        return $this->load->view('order/reports/branch_analytics', $analysis, true);
    }

    // =========================================================================
    // REPORT 2: R-14 SALES REP BRANCHES
    // =========================================================================
    
    /**
     * R-14 Branches Report - Page Load
     */
    public function r14Branches()
    {
        if (empty($this->session->userdata('admin'))) {
            redirect(base_url() . 'order');
        }
        
        $data = [];
        $data['title'] = 'PCT Order: R-14 Sales Rep Report (NEW)';
        $data['branch_reports'] = $this->getR14Branches();
        
        $this->admintemplate->addJS(base_url('assets/backend/js/dashboard.js?v=dashboard_new_1'));
        $this->admintemplate->show("order/reports", "sales_rep_report", $data);
    }
    
    /**
     * R-14 Branches Report - Data Generation
     */
    public function getR14Branches()
    {
        $yearMonth = $this->input->post('month_year');
        $dates = $this->calculateDateParams($yearMonth);
        
        $records = $this->getOrderData(
            $dates['startMonth'],
            $dates['endDate'],
            $dates['closedStartMonth'],
            'sales_representative',
            'full_name'
        );
        
        $branches = [];
        $closingData = []; // For closing ratio calculation
        
        foreach ($records as $row) {
            // SKIP orders without sales rep (this is the key difference from Daily Revenue)
            $repName = $row['person_name'] ?? $row['sales_rep_name'];
            if (empty($repName)) {
                continue;
            }
            
            $branchName = $this->getBranch($row['file_number'], $row['order_type']);
            if (!$branchName) continue;
            
            // Initialize structures
            if (!isset($branches[$branchName])) {
                $branches[$branchName] = ['sales_reps' => []];
            }
            if (!isset($branches[$branchName]['sales_reps'][$repName])) {
                $branches[$branchName]['sales_reps'][$repName] = $this->initPersonCounters($repName);
            }
            
            $rep = &$branches[$branchName]['sales_reps'][$repName];
            
            // Track for closing ratio
            $repId = $row['sales_representative'];
            if (!isset($closingData[$repId])) {
                $closingData[$repId] = ['created' => 0, 'closed' => 0, 'name' => $repName];
            }
            
            // Parse dates
            $createdDate = strtotime($row['created_at']);
            $createdStr = date('Y-m-d', $createdDate);
            
            $hasRevenue = !empty($row['sent_to_accounting_date']);
            $revDay = $revMonth = $revYear = null;
            $revStr = null;
            if ($hasRevenue) {
                $revDate = strtotime($row['sent_to_accounting_date']);
                $revDay = date('d', $revDate);
                $revMonth = date('m', $revDate);
                $revYear = date('Y', $revDate);
                $revStr = date('Y-m-d', $revDate);
            }
            
            // Closing ratio: Count orders created in window
            if ($createdStr >= $dates['startMonth'] && $createdStr <= $dates['endDate']) {
                $closingData[$repId]['created']++;
                
                // Of those, count ones that also closed in window
                if ($hasRevenue && $revStr >= $dates['startMonth'] && $revStr <= $dates['endDate']) {
                    $closingData[$repId]['closed']++;
                }
            }
            
            // Categorize
            $category = $this->categorizeOrder($row['order_type'], $row['transaction_type']);
            if (!$category) continue;
            
            // === CLOSED ORDER COUNTS & REVENUE ===
            if ($hasRevenue) {
                $revenue = floatval($row['premium']);
                
                // Current month
                if ($revMonth == $dates['month'] && $revYear == $dates['year']) {
                    $rep["mtd_{$category}_cnt"]++;
                    $rep["mtd_{$category}_rev"] += $revenue;
                    
                    if ($revDay == $dates['today']) {
                        $rep["today_{$category}_cnt"]++;
                        $rep["today_{$category}_rev"] += $revenue;
                    }
                }
                
                // Prior month
                if ($revMonth == $dates['priorMonth'] && $revYear == $dates['priorYear']) {
                    $rep["prior_{$category}_cnt"]++;
                    $rep["prior_{$category}_rev"] += $revenue;
                }
            }
        }
        
        // Apply closing ratios and filter inactive
        foreach ($branches as $branchName => &$branchData) {
            foreach ($branchData['sales_reps'] as $repName => &$rep) {
                // Find closing data for this rep
                foreach ($closingData as $repId => $data) {
                    if ($data['name'] == $repName) {
                        $rep['created_4m'] = $data['created'];
                        $rep['closed_4m'] = $data['closed'];
                        $rep['closing_ratio'] = $data['created'] > 0 
                            ? round(($data['closed'] / $data['created']) * 100, 1) 
                            : 0;
                        break;
                    }
                }
                
                // Filter out inactive (using COUNT not REV - fixes original bug)
                if (!$this->hasActivity($rep)) {
                    unset($branchData['sales_reps'][$repName]);
                }
            }
            
            // Sort sales reps alphabetically
            if (isset($branchData['sales_reps'])) {
                ksort($branchData['sales_reps']);
            }
        }
        
        // Sort branches alphabetically
        ksort($branches);
        
        $daysDetails = [
            'workedDays' => $dates['workedDays'],
            'workingDaysRemaining' => $dates['workingDaysRemaining'],
            'todayDate' => date("m-d-Y", strtotime('-1 day')),
            'monthName' => $dates['monthName'],
        ];
        
        if ($this->input->is_ajax_request()) {
            $dataRes['html'] = $this->load->view('order/reports/sales_rep_branch_report', 
                ['branches' => $branches, 'daysDetails' => $daysDetails], true);
            $res = array('status' => 'success', 'report' => $dataRes);
            echo json_encode($res);
            exit;
        }
        // echo "<pre>";
        // print_r($branches);
        // echo "</pre>";die;
        return $this->load->view('order/reports/sales_rep_branch_report', 
            ['branches' => $branches, 'daysDetails' => $daysDetails], true);
    }

    // =========================================================================
    // REPORT 3: R-14 SALES RANKING
    // =========================================================================
    
    /**
     * R-14 Ranking Report - Page Load
     */
    public function r14Ranking()
    {
        if (empty($this->session->userdata('admin'))) {
            redirect(base_url() . 'order');
        }
        
        $data = [];
        $data['title'] = 'PCT Order: R-14 Sales Ranking (NEW)';
        $data['branch_reports'] = $this->getR14Ranking();
        
        $this->admintemplate->addJS(base_url('assets/backend/js/dashboard.js?v=dashboard_new_1'));
        $this->admintemplate->show("order/reports", "sales_rep_ranking_report", $data);
    }
    
    /**
     * R-14 Ranking Report - Data Generation
     */
    public function getR14Ranking()
    {
        $yearMonth = $this->input->post('month_year');
        $dates = $this->calculateDateParams($yearMonth);
        
        $records = $this->getOrderData(
            $dates['startMonth'],
            $dates['endDate'],
            $dates['closedStartMonth'],
            'sales_representative',
            'full_name'
        );
        
        $salesReps = [];
        $closingData = [];
        
        foreach ($records as $row) {
            $repName = $row['person_name'] ?? $row['sales_rep_name'];
            if (empty($repName)) continue;
            
            $repId = $row['sales_representative'];
            
            if (!isset($salesReps[$repName])) {
                $salesReps[$repName] = [
                    'sales_rep' => $repName,
                    'total_rev' => 0,
                    'prior_rev' => 0,
                    'projected_rev' => 0,
                    'created_4m' => 0,
                    'closed_4m' => 0,
                    'closing_ratio' => 0,
                ];
            }
            
            if (!isset($closingData[$repId])) {
                $closingData[$repId] = ['created' => 0, 'closed' => 0, 'name' => $repName];
            }
            
            // Parse dates
            $createdStr = date('Y-m-d', strtotime($row['created_at']));
            $hasRevenue = !empty($row['sent_to_accounting_date']);
            
            if ($hasRevenue) {
                $revDate = strtotime($row['sent_to_accounting_date']);
                $revMonth = date('m', $revDate);
                $revYear = date('Y', $revDate);
                $revStr = date('Y-m-d', $revDate);
                $revenue = floatval($row['premium']);
                
                // MTD revenue
                if ($revMonth == $dates['month'] && $revYear == $dates['year']) {
                    $salesReps[$repName]['total_rev'] += $revenue;
                }
                
                // Prior month revenue
                if ($revMonth == $dates['priorMonth'] && $revYear == $dates['priorYear']) {
                    $salesReps[$repName]['prior_rev'] += $revenue;
                }
                
                // Closing ratio
                if ($createdStr >= $dates['startMonth'] && $createdStr <= $dates['endDate']) {
                    $closingData[$repId]['created']++;
                    if ($revStr >= $dates['startMonth'] && $revStr <= $dates['endDate']) {
                        $closingData[$repId]['closed']++;
                    }
                }
            } else {
                // Just created, not closed
                if ($createdStr >= $dates['startMonth'] && $createdStr <= $dates['endDate']) {
                    $closingData[$repId]['created']++;
                }
            }
        }
        
        // Apply closing ratios and calculate projected
        foreach ($salesReps as $repName => &$rep) {
            foreach ($closingData as $repId => $data) {
                if ($data['name'] == $repName) {
                    $rep['created_4m'] = $data['created'];
                    $rep['closed_4m'] = $data['closed'];
                    $rep['closing_ratio'] = $data['created'] > 0 
                        ? round(($data['closed'] / $data['created']) * 100, 1) 
                        : 0;
                    break;
                }
            }
            
            // Calculate projected revenue
            $totalDays = $dates['workedDays'] + $dates['workingDaysRemaining'];
            $rep['projected_rev'] = $dates['workedDays'] > 0 
                ? ($rep['total_rev'] / $dates['workedDays']) * $totalDays 
                : $rep['total_rev'];
        }
        
        // Sort by total revenue descending
        uasort($salesReps, function($a, $b) {
            return $b['total_rev'] <=> $a['total_rev'];
        });
        
        // Filter out zero activity
        $salesReps = array_filter($salesReps, function($rep) {
            return $rep['total_rev'] > 0 || $rep['prior_rev'] > 0;
        });
        
        $daysDetails = [
            'workedDays' => $dates['workedDays'],
            'workingDaysRemaining' => $dates['workingDaysRemaining'],
            'todayDate' => date("m-d-Y", strtotime('-1 day')),
            'monthName' => $dates['monthName'],
        ];
        
        if ($this->input->is_ajax_request()) {
            $dataRes['html'] = $this->load->view('order/reports/sales_rep_ranking_branch_report', 
                ['branches' => $salesReps, 'daysDetails' => $daysDetails], true);
            $res = array('status' => 'success', 'report' => $dataRes);
            echo json_encode($res);
            exit;
        }
        
        return $this->load->view('order/reports/sales_rep_ranking_branch_report', 
            ['branches' => $salesReps, 'daysDetails' => $daysDetails], true);
    }

    // =========================================================================
    // REPORT 4: TITLE OFFICER PRODUCTION
    // =========================================================================
    
    /**
     * Title Officer Report - Page Load
     */
    public function titleOfficerProduction()
    {
        if (empty($this->session->userdata('admin'))) {
            redirect(base_url() . 'order');
        }
        
        $data = [];
        $data['title'] = 'PCT Order: Title Officer Production (NEW)';
        $data['branch_reports'] = $this->getTitleOfficerProduction();
        
        $this->admintemplate->addJS(base_url('assets/backend/js/dashboard.js?v=dashboard_new_1'));
        $this->admintemplate->show("order/reports", "title_officer_report", $data);
    }
    
    /**
     * Title Officer Report - Data Generation
     * 
     * IMPORTANT: Only counts Title Only and Title & Escrow orders
     * Escrow Only and TSG are NOT title officer work
     */
    public function getTitleOfficerProduction()
    {
        $yearMonth = $this->input->post('month_year');
        $dates = $this->calculateDateParams($yearMonth);
        
        $records = $this->getOrderData(
            $dates['startMonth'],
            $dates['endDate'],
            $dates['closedStartMonth'],
            'title_officer',
            'officer_name'
        );
        
        $branches = [];
        $closingData = [];
        
        foreach ($records as $row) {
            // Skip if no title officer assigned
            if (empty($row['title_officer']) || empty($row['person_name'])) {
                continue;
            }
            
            $officerName = $row['person_name'];
            $officerId = $row['title_officer'];
            
            $branchName = $this->getBranch($row['file_number'], $row['order_type']);
            if (!$branchName) continue;
            
            // CRITICAL: Only count title-related orders
            $category = $this->categorizeForTitleOfficer($row['order_type'], $row['transaction_type']);
            if (!$category) continue; // Skip Escrow Only, TSG, unknown
            
            // Initialize
            if (!isset($branches[$branchName])) {
                $branches[$branchName] = ['title_officer' => []];
            }
            if (!isset($branches[$branchName]['title_officer'][$officerName])) {
                $branches[$branchName]['title_officer'][$officerName] = [
                    'officer_name' => $officerName,
                    'today_purchase_cnt' => 0, 'today_purchase_rev' => 0,
                    'mtd_purchase_cnt' => 0, 'mtd_purchase_rev' => 0,
                    'prior_purchase_cnt' => 0, 'prior_purchase_rev' => 0,
                    'today_refi_cnt' => 0, 'today_refi_rev' => 0,
                    'mtd_refi_cnt' => 0, 'mtd_refi_rev' => 0,
                    'prior_refi_cnt' => 0, 'prior_refi_rev' => 0,
                    'created_4m' => 0, 'closed_4m' => 0, 'closing_ratio' => 0,
                ];
            }
            
            $rep = &$branches[$branchName]['title_officer'][$officerName];
            
            if (!isset($closingData[$officerId])) {
                $closingData[$officerId] = ['created' => 0, 'closed' => 0, 'name' => $officerName];
            }
            
            // Parse dates
            $createdStr = date('Y-m-d', strtotime($row['created_at']));
            $hasRevenue = !empty($row['sent_to_accounting_date']);
            
            // Closing ratio tracking
            if ($createdStr >= $dates['startMonth'] && $createdStr <= $dates['endDate']) {
                $closingData[$officerId]['created']++;
            }
            
            if ($hasRevenue) {
                $revDate = strtotime($row['sent_to_accounting_date']);
                $revDay = date('d', $revDate);
                $revMonth = date('m', $revDate);
                $revYear = date('Y', $revDate);
                $revStr = date('Y-m-d', $revDate);
                $revenue = floatval($row['premium']);
                
                // Closing ratio
                if ($createdStr >= $dates['startMonth'] && $createdStr <= $dates['endDate'] &&
                    $revStr >= $dates['startMonth'] && $revStr <= $dates['endDate']) {
                    $closingData[$officerId]['closed']++;
                }
                
                // Current month
                if ($revMonth == $dates['month'] && $revYear == $dates['year']) {
                    $rep["mtd_{$category}_cnt"]++;
                    $rep["mtd_{$category}_rev"] += $revenue;
                    
                    if ($revDay == $dates['today']) {
                        $rep["today_{$category}_cnt"]++;
                        $rep["today_{$category}_rev"] += $revenue;
                    }
                }
                
                // Prior month
                if ($revMonth == $dates['priorMonth'] && $revYear == $dates['priorYear']) {
                    $rep["prior_{$category}_cnt"]++;
                    $rep["prior_{$category}_rev"] += $revenue;
                }
            }
        }
        
        // Apply closing ratios and filter
        foreach ($branches as $branchName => &$branchData) {
            foreach ($branchData['title_officer'] as $officerName => &$officer) {
                foreach ($closingData as $officerId => $data) {
                    if ($data['name'] == $officerName) {
                        $officer['created_4m'] = $data['created'];
                        $officer['closed_4m'] = $data['closed'];
                        $officer['closing_ratio'] = $data['created'] > 0 
                            ? round(($data['closed'] / $data['created']) * 100, 1) 
                            : 0;
                        break;
                    }
                }
                
                // Filter inactive (using COUNT)
                $hasAny = $officer['today_purchase_cnt'] > 0 || $officer['today_refi_cnt'] > 0 ||
                          $officer['mtd_purchase_cnt'] > 0 || $officer['mtd_refi_cnt'] > 0 ||
                          $officer['prior_purchase_cnt'] > 0 || $officer['prior_refi_cnt'] > 0;
                
                if (!$hasAny) {
                    unset($branchData['title_officer'][$officerName]);
                }
            }
            
            if (isset($branchData['title_officer'])) {
                ksort($branchData['title_officer']);
            }
        }
        
        ksort($branches);
        
        $daysDetails = [
            'workedDays' => $dates['workedDays'],
            'workingDaysRemaining' => $dates['workingDaysRemaining'],
            'todayDate' => date("m-d-Y", strtotime('-1 day')),
            'monthName' => $dates['monthName'],
        ];
        
        if ($this->input->is_ajax_request()) {
            $dataRes['html'] = $this->load->view('order/reports/title_officer_branch_report', 
                ['branches' => $branches, 'daysDetails' => $daysDetails], true);
            $res = array('status' => 'success', 'report' => $dataRes);
            echo json_encode($res);
            exit;
        }
        
        return $this->load->view('order/reports/title_officer_branch_report', 
            ['branches' => $branches, 'daysDetails' => $daysDetails], true);
    }

    // =========================================================================
    // REPORT 5: ESCROW PRODUCTION
    // =========================================================================
    
    /**
     * Escrow Production Report - Page Load
     */
    public function escrowProduction()
    {
        if (empty($this->session->userdata('admin'))) {
            redirect(base_url() . 'order');
        }
        
        $data = [];
        $data['title'] = 'PCT Order: Escrow Production (NEW)';
        $data['branch_reports'] = $this->getEscrowProduction();
        
        $this->admintemplate->addJS(base_url('assets/backend/js/dashboard.js?v=dashboard_new_1'));
        $this->admintemplate->show("order/reports", "escrow_report", $data);
    }
    
    /**
     * Escrow Production Report - Data Generation
     * 
     * Only counts Escrow Only and Title & Escrow orders
     */
    public function getEscrowProduction()
    {
        $yearMonth = $this->input->post('month_year');
        $dates = $this->calculateDateParams($yearMonth);
        
        $records = $this->getOrderData(
            $dates['startMonth'],
            $dates['endDate'],
            $dates['closedStartMonth'],
            'sales_representative',
            'full_name'
        );
        
        $branches = [];
        $closingData = [];
        
        foreach ($records as $row) {
            // Skip if no sales rep
            $repName = $row['person_name'] ?? $row['sales_rep_name'];
            if (empty($repName)) continue;
            
            // ONLY include escrow-related orders
            if (!$this->isEscrowOrder($row['order_type'])) {
                continue;
            }
            
            $repId = $row['sales_representative'];
            $branchName = $this->getBranch($row['file_number'], $row['order_type']);
            if (!$branchName) continue;
            
            // Initialize
            if (!isset($branches[$branchName])) {
                $branches[$branchName] = ['sales_reps' => []];
            }
            if (!isset($branches[$branchName]['sales_reps'][$repName])) {
                $branches[$branchName]['sales_reps'][$repName] = [
                    'sales_rep' => $repName,
                    'today_escrow_cnt' => 0, 'today_escrow_rev' => 0,
                    'mtd_escrow_cnt' => 0, 'mtd_escrow_rev' => 0,
                    'prior_escrow_cnt' => 0, 'prior_escrow_rev' => 0,
                    'created_4m' => 0, 'closed_4m' => 0, 'closing_ratio' => 0,
                ];
            }
            
            $rep = &$branches[$branchName]['sales_reps'][$repName];
            
            if (!isset($closingData[$repId])) {
                $closingData[$repId] = ['created' => 0, 'closed' => 0, 'name' => $repName];
            }
            
            // Parse dates
            $createdStr = date('Y-m-d', strtotime($row['created_at']));
            $hasRevenue = !empty($row['sent_to_accounting_date']);
            
            // Closing ratio tracking
            if ($createdStr >= $dates['startMonth'] && $createdStr <= $dates['endDate']) {
                $closingData[$repId]['created']++;
            }
            
            if ($hasRevenue) {
                $revDate = strtotime($row['sent_to_accounting_date']);
                $revDay = date('d', $revDate);
                $revMonth = date('m', $revDate);
                $revYear = date('Y', $revDate);
                $revStr = date('Y-m-d', $revDate);
                $revenue = floatval($row['premium']);
                
                // Closing ratio
                if ($createdStr >= $dates['startMonth'] && $createdStr <= $dates['endDate'] &&
                    $revStr >= $dates['startMonth'] && $revStr <= $dates['endDate']) {
                    $closingData[$repId]['closed']++;
                }
                
                // Current month
                if ($revMonth == $dates['month'] && $revYear == $dates['year']) {
                    $rep['mtd_escrow_cnt']++;
                    $rep['mtd_escrow_rev'] += $revenue;
                    
                    if ($revDay == $dates['today']) {
                        $rep['today_escrow_cnt']++;
                        $rep['today_escrow_rev'] += $revenue;
                    }
                }
                
                // Prior month
                if ($revMonth == $dates['priorMonth'] && $revYear == $dates['priorYear']) {
                    $rep['prior_escrow_cnt']++;
                    $rep['prior_escrow_rev'] += $revenue;
                }
            }
        }
        
        // Apply closing ratios and filter
        foreach ($branches as $branchName => &$branchData) {
            foreach ($branchData['sales_reps'] as $repName => &$rep) {
                foreach ($closingData as $repId => $data) {
                    if ($data['name'] == $repName) {
                        $rep['created_4m'] = $data['created'];
                        $rep['closed_4m'] = $data['closed'];
                        $rep['closing_ratio'] = $data['created'] > 0 
                            ? round(($data['closed'] / $data['created']) * 100, 1) 
                            : 0;
                        break;
                    }
                }
                
                // Filter inactive
                $hasAny = $rep['today_escrow_cnt'] > 0 || 
                          $rep['mtd_escrow_cnt'] > 0 || 
                          $rep['prior_escrow_cnt'] > 0;
                
                if (!$hasAny) {
                    unset($branchData['sales_reps'][$repName]);
                }
            }
            
            if (isset($branchData['sales_reps'])) {
                ksort($branchData['sales_reps']);
            }
        }
        
        ksort($branches);
        
        $daysDetails = [
            'workedDays' => $dates['workedDays'],
            'workingDaysRemaining' => $dates['workingDaysRemaining'],
            'todayDate' => date("m-d-Y", strtotime('-1 day')),
            'monthName' => $dates['monthName'],
        ];
        
        if ($this->input->is_ajax_request()) {
            $dataRes['html'] = $this->load->view('order/reports/escrow_branch_report', 
                ['branches' => $branches, 'daysDetails' => $daysDetails], true);
            $res = array('status' => 'success', 'report' => $dataRes);
            echo json_encode($res);
            exit;
        }
        
        return $this->load->view('order/reports/escrow_branch_report', 
            ['branches' => $branches, 'daysDetails' => $daysDetails], true);
    }
}

