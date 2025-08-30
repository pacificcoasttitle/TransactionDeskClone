<?php

(defined('BASEPATH')) or exit('No direct script access allowed');

use PhpOffice\PhpSpreadsheet\IOFactory;
class Reports extends MX_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->helper(['file', 'url']);
        $this->load->library('session');
        $this->load->library('order/adminTemplate');
        $this->load->library('order/common');
        $this->load->library('order/order');
        $this->common->is_admin();
    }

    public function get_all_sp_order_data($fromDate, $toDate) {
        return $records = $this->db->select('o.id as order_id, o.status, o.softpro_status, o.prod_type, o.profile, o.premium, o.file_number, o.resware_closed_status_date, o.sent_to_accounting_date, t.sales_representative, t.title_officer, u.full_name as sales_rep, o.created_at')
            ->from('order_details o')
            ->join('transaction_details t', 'o.transaction_id = t.id', 'left')
            ->join('pct_softpro_lookup_table u', 't.sales_representative = u.id', 'left')
            ->where('o.created_at >=', $fromDate)
            ->where('o.created_at <=', $toDate)
            // ->where('o.profile is not null')
            ->get()
            // echo $this->db->last_query();exit;
            ->result_array();
    }

    public function get_all_to_order_data($fromDate, $toDate) {
        return $records = $this->db->select('o.id as order_id, o.status, o.softpro_status, o.prod_type, o.profile, o.premium, o.file_number, o.resware_closed_status_date, o.sent_to_accounting_date, t.sales_representative, t.title_officer, u.officer_name, o.created_at')
            ->from('order_details o')
            ->join('transaction_details t', 'o.transaction_id = t.id', 'left')
            ->join('pct_softpro_lookup_table u', 't.title_officer = u.id', 'left')
            ->where('o.created_at >=', $fromDate)
            ->where('o.created_at <=', $toDate)
            // ->where('o.profile is not null')
            ->get()
            // echo $this->db->last_query();exit;
            ->result_array();
    }

    public function mappedReport()
    {
        if (empty($this->session->userdata('admin'))) {
            redirect(base_url() . 'order');
        }
        $data = [];
        $data['title'] = 'PCT Order: Mapped Report';

        // echo 'Hello';die;

        $userdata = $this->session->userdata('admin');
        
        // $titleOfficerList = [];
        $data['branch_reports'] = $this->mappedBranchTable();
        // print_r($data['branch_reports']);die;
        // $this->admintemplate->addCss(base_url('assets/frontend/css/sales-dashboard.css?v=' . $this->js_version));
        $this->admintemplate->show("order/reports", "mapped_report", $data);
    }

    public function mappedBranchTable() {
        $data = [];
        $branchMap = [
            'Glendale Escrow'      => 'Glendale',
            'Glendale Title'       => 'Glendale',
            'Orange Escrow'        => 'Orange',
            'Orange Title'         => 'Orange',
            'Porterville Escrow'   => 'Porterville',
            'Production\Payoff'    => 'Production',
            'TSG'                  => 'TSG',
            'Inland Empire Escrow' => 'Inland Empire',
        ];

        // $fromDate = date('Y-m-d', strtotime('-4 months')); // we need last 4 months data
        // $toDate   = date('Y-m-d');
        $startMonth = date('Y-m-01', strtotime('-3 months'));  // June 1, 2025
        $endDate    = date('Y-m-d');                      // June 30, 2025
        $priorMonth = date('m', strtotime('-1 month'));
        $priorYear  = date('Y', strtotime('-1 month'));
        $ratioMonth = date('m', strtotime('-3 month'));
        $ratioYear  = date('Y', strtotime('-3 month'));
        
        $records = $this->get_all_sp_order_data($startMonth, $endDate);
        // echo "<pre>";
        // print_r($records);
        // die;

        $branches = [];
        foreach ($records as $row) {
            $profile = $row['profile'];
            if (empty($profile)) {
                continue;
            }
            $branchName = $branchMap[$profile] ?? 'Other';
            $repId = $row['sales_representative'];

            if (!isset($branches[$branchName])) {
                $branches[$branchName] = ['sales_reps' => []];
            }

            if (!isset($branches[$branchName]['sales_reps'][$repId])) {
                $branches[$branchName]['sales_reps'][$repId] = [
                    'sales_rep'   => $row['sales_rep'] ?? 'Unassigned',
                    // 'today'       => 0,
                    // 'mtd'         => 0,
                    // 'prior'       => 0,
                    // 'resale_rev'  => 0,
                    // 'refi_rev'    => 0,
                    'today_purchase_cnt' => 0,
                    'today_purchase_rev' => 0,
                    
                    'mtd_purchase_cnt' => 0,
                    'mtd_purchase_rev' => 0,
                    
                    'prior_purchase_cnt' => 0,
                    'prior_purchase_rev' => 0,
                    
                    'today_refi_cnt' => 0,
                    'today_refi_rev' => 0,
                    'mtd_refi_cnt' => 0,
                    'mtd_refi_rev' => 0,
                    'prior_refi_cnt' => 0,
                    'prior_refi_rev' => 0,
                    'escrow_rev'  => 0,
                    'created_4m' => 0,
                    'closed_4m' => 0,
                    'closing_ratio'  => 0,
                    'total_orders'=> 0,
                    'closed_orders'=>0,
                ];
            }

            $rep =&$branches[$branchName]['sales_reps'][$repId];

            $created_date = date('Y-m-d', strtotime($row['created_at']));
            $closed_date = date('Y-m-d', strtotime($row['resware_closed_status_date']));
            $rev_date = date('Y-m-d', strtotime($row['sent_to_accounting_date']));
            $rev_day = date('d', strtotime($rev_date));
            $rev_month = date('m', strtotime($rev_date));
            $rev_year  = date('Y', strtotime($rev_date));

            $created_month = date('m', strtotime($created_date));
            $created_year  = date('Y', strtotime($created_date));
            // echo $rev_day . ' ' . $rev_month . ' ' . $rev_year . '<br>';die;
            $closed_day = date('d', strtotime($closed_date));
            $closed_month = date('m', strtotime($closed_date));
            $closed_year  = date('Y', strtotime($closed_date));
            

            // if ($date == date('Y-m-d') && $row['softpro_status'] == 'closed') {
            //     $rep['today_purchase_cnt']++;
            // }

            if ($rev_month == date('m') && $rev_year == date('Y')) {
                // echo "<pre>";
                // print_r($row);die;
                if ($row['prod_type'] == 'Purchase') {
                    $rep['mtd_purchase_cnt'] += 1;
                    if ($rev_day == date('d')) {
                        $rep['today_purchase_cnt'] += 1;
                    } 
                } elseif ($row['prod_type'] == 'Refinance') {
                    $rep['mtd_refi_cnt']++;
                    if ($rev_day == date('d')) {
                        $rep['today_refi_cnt']++;
                    }
                }
            }

            if ($rev_month == date('m') && $rev_year == date('Y')) {
                if ($row['prod_type'] == 'Purchase') {
                    $rep['mtd_purchase_rev'] += $row['premium'];
                    $rep['mtd_purchase_cnt'] += 1;
                    if ($rev_day == date('d')) {
                        $rep['today_purchase_rev'] += $row['premium'];
                        $rep['today_purchase_cnt'] += 1;
                    }
                } elseif ($row['prod_type'] == 'Refinance') {
                    $rep['mtd_refi_rev'] += $row['premium'];
                    $rep['mtd_refi_cnt'] += 1;
                    if ($rev_day == date('d')) {
                        $rep['today_refi_rev'] += $row['premium'];
                        $rep['today_refi_cnt'] += 1;
                    }
                }
                // $rep['today_purchase_rev'] += $row['premium'];
                // if (stripos($row['profile'], 'Escrow') !== false) {
                //     $rep['escrow_rev'] += $row['premium'];
                // }
            }

            if ($rev_month == $priorMonth && $rev_year == $priorYear && !empty($row['sent_to_accounting_date'])) {
                if ($row['prod_type'] == 'Purchase') {
                    $rep['prior_purchase_cnt']++;
                } elseif ($row['prod_type'] == 'Refinance') {
                    $rep['prior_refi_cnt']++;
                }
            }

            if ($rev_month == $priorMonth && $rev_year == $priorYear) {
                if ($row['prod_type'] == 'Purchase') {
                    $rep['prior_purchase_rev'] += $row['premium'];
                } elseif ($row['prod_type'] == 'Refinance') {
                    $rep['prior_refi_rev'] += $row['premium'];
                }
            }

            

            if ($created_date >= $startMonth && $created_date <= $endDate) {
                $rep['created_4m']++;
                // echo $repId . ' - ' . $created_date . ' - ' . $rev_date . '<br>';
                // Among them, check if closed also in the range
                if (!empty($rev_date) && $rev_date >= $startMonth && $rev_date <= $endDate) {
                    $rep['closed_4m']++;
                }
            }

            $rep['total_orders']++;
            if ($row['softpro_status'] == 'closed') {
                $rep['closed_orders']++;
            }
        }

        $salesUsers = $this->order->get_sales_users();
        $salesClosingFigure = [];
        if (!empty($salesUsers)) {
            foreach ($salesUsers as $row) {
                $salesId = $row['id'];
                $createdCount = array_filter($records, function ($record) use ($startMonth, $endDate, $salesId) {
                    $created = date('Y-m-d', strtotime($record['created_at']));
                    // $rev_date = date('Y-m-d', strtotime($record['sent_to_accounting_date']));
                    return ($created >= $startMonth && $created <= $endDate && $record['sales_representative'] == $salesId);
                });
                $closedCount = array_filter($records, function ($record) use ($startMonth, $endDate, $salesId) {
                    // $created = date('Y-m-d', strtotime($record['created_at']));
                    $rev_date = date('Y-m-d', strtotime($record['sent_to_accounting_date']));
                    return ($rev_date >= $startMonth && $rev_date <= $endDate && $record['sales_representative'] == $salesId);
                });
                $salesClosingFigure[$salesId] = [
                    'created' => count($createdCount),
                    'closed' => count($closedCount),
                ];
            }
        }

        // echo "<pre>";
        // print_r($salesClosingFigure);die;

        
        // Finalize closing %
        foreach ($branches as &$branch) {
            foreach ($branch['sales_reps'] as $key => &$rep) {
                // echo "<pre>";
                // print_r($salesClosingFigure);die;

                $rep['closing_ratio'] = isset($salesClosingFigure[$key]) && $salesClosingFigure[$key]['created'] > 0 ? round(($salesClosingFigure[$key]['closed'] / $salesClosingFigure[$key]['created']) * 100, 1) : 0;
                $rep['created_4m'] = isset($salesClosingFigure[$key]) && $salesClosingFigure[$key]['created'] > 0 ? $salesClosingFigure[$key]['created'] : 0;
                $rep['closed_4m'] = isset($salesClosingFigure[$key]) && $salesClosingFigure[$key]['closed'] > 0 ? $salesClosingFigure[$key]['closed'] : 0;
                // $rep['closing_ratio'] = $rep['created_4m'] > 0
                // ? round(($rep['closed_4m'] / $rep['created_4m']) * 100, 1)
                // : 0;
            }
        }
        
        // echo "<pre>";
        // print_r($branches);die;
        return $this->load->view('order/reports/mapped_branch_report', ['branches' => $branches], true);
    }

    public function mappedTitleOfficerReport()
    {
        if (empty($this->session->userdata('admin'))) {
            redirect(base_url() . 'order');
        }
        $data = [];
        $data['title'] = 'PCT Order: Mapped Title Officer Report';
        
        $userdata = $this->session->userdata('admin');
        
        $titleOfficerList = [];
        $data['branch_reports'] = $this->mappedTitleOfficerBranchTable();
        // $this->admintemplate->addCss(base_url('assets/frontend/css/sales-dashboard.css?v=' . $this->js_version));
        $this->admintemplate->show("order/reports", "mapped_to_report", $data);
    }

    public function mappedTitleOfficerBranchTable() {
        $data = [];
        $branchMap = [
            'Glendale Escrow'      => 'Glendale',
            'Glendale Title'       => 'Glendale',
            'Orange Escrow'        => 'Orange',
            'Orange Title'         => 'Orange',
            'Porterville Escrow'   => 'Porterville',
            'Production\Payoff'    => 'Production',
            'TSG'                  => 'TSG',
            'Inland Empire Escrow' => 'Inland Empire',
        ];

        // $fromDate = date('Y-m-d', strtotime('-4 months')); // we need last 4 months data
        // $toDate   = date('Y-m-d');
        $startMonth = date('Y-m-01', strtotime('-3 months'));  // June 1, 2025
        $endDate    = date('Y-m-d');                      // June 30, 2025
        $priorMonth = date('m', strtotime('-1 month'));
        $priorYear  = date('Y', strtotime('-1 month'));
        $ratioMonth = date('m', strtotime('-3 month'));
        $ratioYear  = date('Y', strtotime('-3 month'));
        
        $records = $this->get_all_to_order_data($startMonth, $endDate);
        // echo "<pre>";
        // print_r($records);
        // die;

        $branches = [];
        foreach ($records as $row) {
            $profile = $row['profile'];
            if (empty($profile) || empty($row['title_officer'])) {
                continue;
            }
            $branchName = $branchMap[$profile] ?? 'Other';
            $repId = $row['title_officer'];

            if (!isset($branches[$branchName])) {
                $branches[$branchName] = ['title_officer' => []];
            }

            if (!isset($branches[$branchName]['title_officer'][$repId])) {
                $branches[$branchName]['title_officer'][$repId] = [
                    'officer_name'   => $row['officer_name'] ?? 'Unassigned',
                    // 'today'       => 0,
                    // 'mtd'         => 0,
                    // 'prior'       => 0,
                    // 'resale_rev'  => 0,
                    // 'refi_rev'    => 0,
                    'today_purchase_cnt' => 0,
                    'today_purchase_rev' => 0,
                    
                    'mtd_purchase_cnt' => 0,
                    'mtd_purchase_rev' => 0,
                    
                    'prior_purchase_cnt' => 0,
                    'prior_purchase_rev' => 0,
                    
                    'today_refi_cnt' => 0,
                    'today_refi_rev' => 0,
                    'mtd_refi_cnt' => 0,
                    'mtd_refi_rev' => 0,
                    'prior_refi_cnt' => 0,
                    'prior_refi_rev' => 0,
                    'escrow_rev'  => 0,
                    'created_4m' => 0,
                    'closed_4m' => 0,
                    'closing_ratio'  => 0,
                    'total_orders'=> 0,
                    'closed_orders'=>0,
                ];
            }

            $rep =&$branches[$branchName]['title_officer'][$repId];

            $created_date = date('Y-m-d', strtotime($row['created_at']));
            $closed_date = date('Y-m-d', strtotime($row['resware_closed_status_date']));
            $rev_date = date('Y-m-d', strtotime($row['sent_to_accounting_date']));
            $rev_day = date('d', strtotime($rev_date));
            $rev_month = date('m', strtotime($rev_date));
            $rev_year  = date('Y', strtotime($rev_date));

            $created_month = date('m', strtotime($created_date));
            $created_year  = date('Y', strtotime($created_date));
            // echo $rev_day . ' ' . $rev_month . ' ' . $rev_year . '<br>';die;
            $closed_day = date('d', strtotime($closed_date));
            $closed_month = date('m', strtotime($closed_date));
            $closed_year  = date('Y', strtotime($closed_date));
            

            // if ($date == date('Y-m-d') && $row['softpro_status'] == 'closed') {
            //     $rep['today_purchase_cnt']++;
            // }

            if ($rev_month == date('m') && $rev_year == date('Y')) {
                // echo "<pre>";
                // print_r($row);die;
                if ($row['prod_type'] == 'Purchase') {
                    $rep['mtd_purchase_cnt'] += 1;
                    if ($rev_day == date('d')) {
                        $rep['today_purchase_cnt'] += 1;
                    } 
                } elseif ($row['prod_type'] == 'Refinance') {
                    $rep['mtd_refi_cnt']++;
                    if ($rev_day == date('d')) {
                        $rep['today_refi_cnt']++;
                    }
                }
            }

            if ($rev_month == date('m') && $rev_year == date('Y')) {
                if ($row['prod_type'] == 'Purchase') {
                    $rep['mtd_purchase_rev'] += $row['premium'];
                    $rep['mtd_purchase_cnt'] += 1;
                    if ($rev_day == date('d')) {
                        $rep['today_purchase_rev'] += $row['premium'];
                        $rep['today_purchase_cnt'] += 1;
                    }
                } elseif ($row['prod_type'] == 'Refinance') {
                    $rep['mtd_refi_rev'] += $row['premium'];
                    $rep['mtd_refi_cnt'] += 1;
                    if ($rev_day == date('d')) {
                        $rep['today_refi_rev'] += $row['premium'];
                        $rep['today_refi_cnt'] += 1;
                    }
                }
                // $rep['today_purchase_rev'] += $row['premium'];
                // if (stripos($row['profile'], 'Escrow') !== false) {
                //     $rep['escrow_rev'] += $row['premium'];
                // }
            }

            if ($rev_month == $priorMonth && $rev_year == $priorYear && !empty($row['sent_to_accounting_date'])) {
                if ($row['prod_type'] == 'Purchase') {
                    $rep['prior_purchase_cnt']++;
                } elseif ($row['prod_type'] == 'Refinance') {
                    $rep['prior_refi_cnt']++;
                }
            }

            if ($rev_month == $priorMonth && $rev_year == $priorYear) {
                if ($row['prod_type'] == 'Purchase') {
                    $rep['prior_purchase_rev'] += $row['premium'];
                } elseif ($row['prod_type'] == 'Refinance') {
                    $rep['prior_refi_rev'] += $row['premium'];
                }
            }

            

            if ($created_date >= $startMonth && $created_date <= $endDate) {
                $rep['created_4m']++;
                // echo $repId . ' - ' . $created_date . ' - ' . $rev_date . '<br>';
                // Among them, check if closed also in the range
                if (!empty($rev_date) && $rev_date >= $startMonth && $rev_date <= $endDate) {
                    $rep['closed_4m']++;
                }
            }

            $rep['total_orders']++;
            if ($row['softpro_status'] == 'closed') {
                $rep['closed_orders']++;
            }
        }

        $titleOfficerList = $this->order->get_title_officer();
        $titleOffierClosingFigure = [];
        if (!empty($titleOfficerList)) {
            foreach ($titleOfficerList as $row) {
                $titleOffierId = $row['id'];
                $createdCount = array_filter($records, function ($record) use ($startMonth, $endDate, $titleOffierId) {
                    $created = date('Y-m-d', strtotime($record['created_at']));
                    // $rev_date = date('Y-m-d', strtotime($record['sent_to_accounting_date']));
                    return ($created >= $startMonth && $created <= $endDate && $record['title_officer'] == $titleOffierId);
                });
                $closedCount = array_filter($records, function ($record) use ($startMonth, $endDate, $titleOffierId) {
                    // $created = date('Y-m-d', strtotime($record['created_at']));
                    $rev_date = date('Y-m-d', strtotime($record['sent_to_accounting_date']));
                    return ($rev_date >= $startMonth && $rev_date <= $endDate && $record['title_officer'] == $titleOffierId);
                });
                $titleOffierClosingFigure[$titleOffierId] = [
                    'created' => count($createdCount),
                    'closed' => count($closedCount),
                ];
            }
        }

        // echo "<pre>";
        // print_r($titleOffierClosingFigure);die;

        
        // Finalize closing %
        foreach ($branches as &$branch) {
            foreach ($branch['title_officer'] as $key => &$rep) {
                
                $rep['closing_ratio'] = isset($titleOffierClosingFigure[$key]) && $titleOffierClosingFigure[$key]['created'] > 0 ? round(($titleOffierClosingFigure[$key]['closed'] / $titleOffierClosingFigure[$key]['created']) * 100, 1) : 0;
                $rep['created_4m'] = isset($titleOffierClosingFigure[$key]) && $titleOffierClosingFigure[$key]['created'] > 0 ? $titleOffierClosingFigure[$key]['created'] : 0;
                $rep['closed_4m'] = isset($titleOffierClosingFigure[$key]) && $titleOffierClosingFigure[$key]['closed'] > 0 ? $titleOffierClosingFigure[$key]['closed'] : 0;
                // $rep['closing_ratio'] = $rep['created_4m'] > 0
                // ? round(($rep['closed_4m'] / $rep['created_4m']) * 100, 1)
                // : 0;
            }
        }
        // echo "<pre>";
        // print_r($branches);die;
        return $this->load->view('order/reports/mapped_to_branch_report', ['branches' => $branches], true);
    }

    public function branchAnalyticsReport()
    {
        if (empty($this->session->userdata('admin'))) {
            redirect(base_url() . 'order');
        }
        $data = [];
        $data['title'] = 'PCT Order: Branch Analytics Report';
        
        $userdata = $this->session->userdata('admin');
        
        $titleOfficerList = [];
        $data['summary_reports'] = $this->branchAnalyticsSummary();
        $data['branch_analytics_reports'] = $this->branchAnalyticsTable();
        $this->admintemplate->show("order/reports", "branch_analytics_report", $data);
    }

    public function branchAnalyticsTable() {
        $data = [];
        return $this->load->view('order/reports/branch_analytics', $data, true);
    }

    public function branchAnalyticsSummary() {
        $data = [];
        return $this->load->view('order/reports/branch_analytics_summary', $data, true);
    }
}
