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

    public function get_all_sp_order_data($fromDate, $toDate, $closedFromDate) {
        $this->db->select('o.id as order_id, o.status, o.softpro_status, o.prod_type, o.premium, o.file_number, o.resware_closed_status_date, o.sent_to_accounting_date, t.transaction_type, t.sales_representative, t.title_officer, u.full_name as sales_rep, o.created_at, ot.order_type')
        // $records = $this->db->select('o.id as order_id, o.status, o.softpro_status, o.prod_type, o.profile, o.premium, o.file_number, o.resware_closed_status_date, o.sent_to_accounting_date, t.sales_representative, t.title_officer, u.full_name as sales_rep, o.created_at, ot.order_type')
            ->from('order_details o')
            ->join('transaction_details t', 'o.transaction_id = t.id', 'left')
            ->join('pct_softpro_lookup_table u', 't.sales_representative = u.id', 'left')
            ->join('pct_softpro_order_type ot', 't.order_type = ot.id', 'left');
            // ->where('o.created_at >=', $fromDate)
            // ->where('o.created_at <=', $toDate)
            $this->db->group_start();
                $this->db->group_start();
                    $this->db->where('o.sent_to_accounting_date >=', $closedFromDate);
                    $this->db->where('o.sent_to_accounting_date <=', $toDate);
                $this->db->group_end();
                $this->db->or_group_start();
                    $this->db->where('o.created_at >=', $fromDate);
                    $this->db->where('o.created_at <=', $toDate);    
                $this->db->group_end();
            $this->db->group_end();
            $this->db->where('o.is_softpro_order', 1);
            $this->db->where('o.file_number is not null');
            // $this->db->where('t.sales_representative', 12685);
            // ->where('o.prod_type', 'Refinance')
            // ->where('o.sent_to_accounting_date is not null')
            return $this->db->get()->result_array();
            // $this->db->get();
            // print_r($this->db->last_query());exit;
    }

    public function get_all_to_order_data($fromDate, $toDate, $closedFromDate) {
        $this->db->select('o.id as order_id, o.status, o.softpro_status, o.prod_type, o.profile, o.premium, o.file_number, o.resware_closed_status_date, o.sent_to_accounting_date, t.transaction_type, t.sales_representative, t.title_officer, u.officer_name, o.created_at, ot.order_type')
            ->from('order_details o')
            ->join('transaction_details t', 'o.transaction_id = t.id', 'left')
            ->join('pct_softpro_lookup_table u', 't.title_officer = u.id', 'left')
            ->join('pct_softpro_order_type ot', 't.order_type = ot.id', 'left');
            $this->db->group_start();
                $this->db->group_start();
                    $this->db->where('o.sent_to_accounting_date >=', $closedFromDate);
                    $this->db->where('o.sent_to_accounting_date <=', $toDate);
                $this->db->group_end();
                $this->db->or_group_start();
                    $this->db->where('o.created_at >=', $fromDate);
                    $this->db->where('o.created_at <=', $toDate);    
                $this->db->group_end();
            $this->db->group_end();
            $this->db->where('o.is_softpro_order', 1);
            $this->db->where('o.file_number is not null');
            // $this->db->where('t.title_officer', 14415);
            // $this->db->get();
            // echo $this->db->last_query();exit;
            return $this->db->get()->result_array();
            
    }

    public function get_all_order_data($fromDate, $toDate) {
        $this->db->select('o.id as order_id, o.status, o.softpro_status, o.prod_type, o.profile, o.premium, o.file_number, o.resware_closed_status_date, o.sent_to_accounting_date, t.transaction_type, t.sales_representative, t.title_officer, o.created_at, ot.order_type')
        // $records = $this->db->select('o.id as order_id, o.status, o.softpro_status, o.prod_type, o.profile, o.premium, o.file_number, o.resware_closed_status_date, o.sent_to_accounting_date, t.sales_representative, t.title_officer, o.created_at, ot.order_type')
            ->from('order_details o')
            ->join('transaction_details t', 'o.transaction_id = t.id', 'left')
            // ->join('pct_softpro_lookup_table u', 't.title_officer = u.id', 'left')
            ->join('pct_softpro_order_type ot', 't.order_type = ot.id', 'left');
            // ->where('o.created_at >=', $fromDate)
            // ->where('o.created_at <=', $toDate)
            $this->db->group_start();
                $this->db->group_start();
                    $this->db->where('o.sent_to_accounting_date >=', $fromDate);
                    $this->db->where('o.sent_to_accounting_date <=', $toDate);
                $this->db->group_end();
                $this->db->or_group_start();
                    $this->db->where('o.created_at >=', $fromDate);
                    $this->db->where('o.created_at <=', $toDate);    
                $this->db->group_end();
            $this->db->group_end();
            $this->db->where('o.is_softpro_order', 1);
            $this->db->where('o.file_number is not null');
            // $this->db->get();
            // echo $this->db->last_query();exit;
            return $this->db->get()->result_array();
    }

    public function salesRepBranchReport()
    {
        if (empty($this->session->userdata('admin'))) {
            redirect(base_url() . 'order');
        }
        $data = [];
        $data['title'] = 'PCT Order: Mapped Report';

        // echo 'Hello';die;

        $userdata = $this->session->userdata('admin');
        
        // $titleOfficerList = [];
        $data['branch_reports'] = $this->getSalerepBranchReport();
        // print_r($data['branch_reports']);die;
        // $this->admintemplate->addCss(base_url('assets/frontend/css/sales-dashboard.css?v=' . $this->js_version));
        $this->admintemplate->addJS(base_url('assets/backend/js/dashboard.js?v=dashboard_1'));
        $this->admintemplate->show("order/reports", "sales_rep_report", $data);
    }

    public function getSalerepBranchReport() {
        /*if ($this->input->is_ajax_request()) {
            $filterType = $this->input->post('report_type');
            $yearMonth = $this->input->post('month_year');
            list($year, $month) = explode('-', $yearMonth);
            $selectedDate = strtotime($yearMonth . "-01");
            $startMonth = date('Y-m-01 00:00:00', strtotime('-3 months', $selectedDate));
            $endDate = date('Y-m-t 23:59:59', $selectedDate);
            $closedStartMonth = date('Y-m-01 00:00:00', strtotime('-1 months', $selectedDate));
            $today = 0;
            $monthName = date("F", strtotime($endDate));
            
            $priorMonth = date('m', strtotime('-1 months', $selectedDate));
            $priorYear  = date('Y', strtotime('-1 months', $selectedDate));
            // echo $startMonth . ' - ' . $endDate . ' -- ' . '-- Month : ' . $month . '-- Year -- ' . $year . '-- Prior - ' . $priorMonth . ' - ' . $priorYear ;
            // die;
            if ($month == date('m') && $year == date('Y')) {
                $workedDays = $this->order->countWorkedDaysOfMonth();
                $workingDaysRemaining = $this->order->countWokingsDaysLeftOfMonth();
            } else {
                $workedDays = $this->order->countDaysOfMonth($month, $year);
                $workingDaysRemaining = 0;
            }
        } else {
            $startMonth = date('Y-m-01 00:00:00', strtotime('-3 months'));
            $endDate    = date('Y-m-d 23:59:59', strtotime('-1 day'));
            $closedStartMonth = date('Y-m-01 00:00:00', strtotime('-1 months'));
            $priorMonth = date('m', strtotime('-1 month'));
            $priorYear  = date('Y', strtotime('-1 month'));
            $today = date('d', strtotime('-1 day'));
            $month = date('m', strtotime('-1 day'));
            $year = date('Y', strtotime('-1 day'));
            $monthName = date("F", strtotime('-1 day'));
            $workedDays = $this->order->countWorkedDaysOfMonth();
            $workingDaysRemaining = $this->order->countWokingsDaysLeftOfMonth();
        }*/

        if ($this->input->is_ajax_request()) {
            $filterType = $this->input->post('report_type');
            $yearMonth = $this->input->post('month_year');
            list($year, $month) = explode('-', $yearMonth);
            // $selectedDate = strtotime($yearMonth . "-01");
            // $startMonth = date('Y-m-01 00:00:00', strtotime('-3 months', $selectedDate));
            // $endDate = date('Y-m-t 23:59:59', $selectedDate);
            // $closedStartMonth = date('Y-m-01 00:00:00', strtotime('-1 months', $selectedDate));
            // $today = 0;
            // $monthName = date("F", strtotime($endDate));
            
            // $priorMonth = date('m', strtotime('-1 months', $selectedDate));
            // $priorYear  = date('Y', strtotime('-1 months', $selectedDate));

            if ($month != date('m') || $year != date('Y')) {
                // echo "hello";die;
                $selectedDate = strtotime($yearMonth . "-01");
                $startMonth = date('Y-m-01 00:00:00', strtotime('-3 months', $selectedDate));
                $endDate = date('Y-m-t 23:59:59', $selectedDate);
                $closedStartMonth = date('Y-m-01 00:00:00', strtotime('-1 months', $selectedDate));
                $today = 0;
                $monthName = date("F", strtotime($endDate));
                
                $priorMonth = date('m', strtotime('-1 months', $selectedDate));
                $priorYear  = date('Y', strtotime('-1 months', $selectedDate));
            } else {
                if (date('d') == '01') {
                    $startMonth = date('Y-m-01 00:00:00', strtotime('-4 months'));
                    $endDate    = date('Y-m-d 23:59:59', strtotime('-1 day'));
                    $closedStartMonth = date('Y-m-01 00:00:00', strtotime('-2 months'));
                    $priorMonth = date('m', strtotime('-2 month'));
                    $priorYear  = date('Y', strtotime('-2 month'));
                } else {
                    $startMonth = date('Y-m-01 00:00:00', strtotime('-3 months'));
                    $endDate    = date('Y-m-d 23:59:59', strtotime('-1 day'));
                    $closedStartMonth = date('Y-m-01 00:00:00', strtotime('-1 months'));
                    $priorMonth = date('m', strtotime('-1 month'));
                    $priorYear  = date('Y', strtotime('-1 month'));
                }
                $today = date('d', strtotime('-1 day'));
                $month = date('m', strtotime('-1 day'));
                $year = date('Y', strtotime('-1 day'));
                $monthName = date("F", strtotime('-1 day'));
            }
            if ($month == date('m') && $year == date('Y')) {
                // $workedDays = $this->order->countWorkedDaysOfMonth();
                // $workingDaysRemaining = $this->order->countWokingsDaysLeftOfMonth();
                $workedDays = $this->order->countDaysOfMonth($month, $year);
                $workingDaysRemaining = $this->order->countWokingsDaysLeftOfSelectedMonth($today, $month, $year);
            } else {
                $workedDays = $this->order->countDaysOfMonth($month, $year);
                $workingDaysRemaining = 0;
            }
        } else {
            $startMonth = date('Y-m-01 00:00:00', strtotime('-3 months'));
            $endDate    = date('Y-m-d 23:59:59', strtotime('-1 day'));
            if (date('d') == '01') {
                $priorMonth = date('m', strtotime('-2 month'));
                $priorYear  = date('Y', strtotime('-2 month'));
                $closedStartMonth = date('Y-m-01 00:00:00', strtotime('-2 months'));
            } else {
                $priorMonth = date('m', strtotime('-1 month'));
                $priorYear  = date('Y', strtotime('-1 month'));
                $closedStartMonth = date('Y-m-01 00:00:00', strtotime('-1 months'));
            }
            $today = date('d', strtotime('-1 day'));
            $month = date('m', strtotime('-1 day'));
            $year = date('Y', strtotime('-1 day'));
            $monthName = date("F", strtotime('-1 day'));
            // $workedDays = $this->order->countWorkedDaysOfMonth();
            // $workingDaysRemaining = $this->order->countWokingsDaysLeftOfMonth();
            $workedDays = $this->order->countDaysOfMonth($month, $year);
            $workingDaysRemaining = $this->order->countWokingsDaysLeftOfSelectedMonth($today, $month, $year);
        }
        
        // echo $startMonth . ' - ' . $endDate . ' -- Prior month --' . $priorMonth . ' - ' . $priorYear . '-- Current Month --' . $month . ' - ' . $year . ' -- Today --' . date('d') . '<br>';
        // die;
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
        // $ratioMonth = date('m', strtotime('-3 month'));
        // $ratioYear  = date('Y', strtotime('-3 month'));
        
        $records = $this->get_all_sp_order_data($startMonth, $endDate, $closedStartMonth);
        // echo "<pre>";
        // print_r($records);
        // die;

        $branches = [];
        foreach ($records as $row) {
            // if (empty($profile)) {
            //     continue;
            // }
            $repId = $row['sales_representative'];
            $repName = $row['sales_rep'];
            if (empty($repName)) {
                continue;
            }
            if (strpos($row['file_number'], 'GLT') !== false) {
                $branchName = 'Glendale';
            } elseif (strpos($row['file_number'], 'OCT') !== false) {
                $branchName = 'Orange';
            } elseif (strpos($row['file_number'], 'ONT') !== false) {
                $branchName = 'Inland Empire';
            } elseif (strpos($row['file_number'], 'TSG') !== false || strtolower($row['order_type']) == 'trustee sale guarantee') {
                $branchName = 'TSG';
            } elseif (strpos($row['file_number'], 'PRV') !== false) {
                $branchName = 'Porterville';
            } else {
                continue;
                // $branchName = 'Unknown';
            }
            
            // $branchName = $branchMap[$profile] ?? 'Other';
            if (!isset($branches[$branchName])) {
                $branches[$branchName] = ['sales_reps' => []];
            }

            if (!isset($branches[$branchName]['sales_reps'][$repName])) {
                $branches[$branchName]['sales_reps'][$repName] = [
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
                    'today_escrow_cnt' => 0,
                    'today_escrow_rev' => 0,
                    'mtd_escrow_cnt' => 0,
                    'mtd_escrow_rev' => 0,
                    'prior_escrow_cnt' => 0,
                    'prior_escrow_rev' => 0,

                    'today_tsg_cnt' => 0,
                    'mtd_tsg_cnt' => 0,
                    'prior_tsg_cnt' => 0,
                    
                    'today_tsg_rev' => 0,
                    'mtd_tsg_rev' => 0,
                    'prior_tsg_rev' => 0,

                    'escrow_rev'  => 0,
                    'created_4m' => 0,
                    'closed_4m' => 0,
                    'closing_ratio'  => 0,
                    'total_orders'=> 0,
                    'closed_orders'=>0,
                ];
            }

            $rep =&$branches[$branchName]['sales_reps'][$repName];

            $created_date = date('Y-m-d', strtotime($row['created_at']));
            // $closed_date = date('Y-m-d', strtotime($row['resware_closed_status_date']));
            $rev_date = date('Y-m-d', strtotime($row['sent_to_accounting_date']));
            $rev_day = date('d', strtotime($rev_date));
            $rev_month = date('m', strtotime($rev_date));
            $rev_year  = date('Y', strtotime($rev_date));

            $created_month = date('m', strtotime($created_date));
            $created_year  = date('Y', strtotime($created_date));
            // echo $rev_day . ' ' . $rev_month . ' ' . $rev_year . '<br>';die;
            // $closed_day = date('d', strtotime($closed_date));
            // $closed_month = date('m', strtotime($closed_date));
            // $closed_year  = date('Y', strtotime($closed_date));
            

            // if ($date == date('Y-m-d') && $row['softpro_status'] == 'closed') {
            //     $rep['today_purchase_cnt']++;
            // }

            // if ($rev_month == date('m') && $rev_year == date('Y')) {
            //     if (strtolower($row['order_type']) == 'title only') {
            //         if ($row['transaction_type'] == 'Purchase') {
            //             $rep['mtd_purchase_cnt'] += 1;
            //             if ($rev_day == date('d')) {
            //                 $rep['today_purchase_cnt'] += 1;
            //             } 
            //         } elseif ($row['transaction_type'] == 'Refinance') {
            //             $rep['mtd_refi_cnt']++;
            //             if ($rev_day == date('d')) {
            //                 $rep['today_refi_cnt']++;
            //             }
            //         }
            //     } else if (strtolower($row['order_type']) == 'title & escrow') {

            //     }
            // }

            if (!empty($row['sent_to_accounting_date']) && $rev_month == $month && $rev_year == $year) {
                if (strtolower($row['order_type']) == 'title only') {
                    if ($row['transaction_type'] == 'Purchase') {
                        $rep['mtd_purchase_rev'] += $row['premium'];
                        $rep['mtd_purchase_cnt'] += 1;
                        if ($rev_day == $today) {
                            $rep['today_purchase_rev'] += $row['premium'];
                            $rep['today_purchase_cnt'] += 1;
                        }
                    } elseif ($row['transaction_type'] == 'Refinance') {
                        $rep['mtd_refi_rev'] += $row['premium'];
                        $rep['mtd_refi_cnt'] += 1;
                        
                        if ($rev_day == $today) {
                            $rep['today_refi_rev'] += $row['premium'];
                            $rep['today_refi_cnt'] += 1;
                        }
                    }
                } else if (strtolower($row['order_type']) == 'title & escrow' || strtolower($row['order_type']) == 'escrow only') {
                    $rep['mtd_escrow_rev'] += $row['premium'];
                    $rep['mtd_escrow_cnt'] += 1;
                    if ($rev_day == $today) {
                        $rep['today_escrow_rev'] += $row['premium'];
                        $rep['today_escrow_cnt']++;
                    }
                } else if (strtolower($row['order_type']) == 'trustee sale guarantee') {
                    $rep['mtd_tsg_rev'] += $row['premium'];
                    $rep['mtd_tsg_cnt'] += 1;
                    if ($rev_day == $today) {
                        $rep['today_tsg_rev'] += $row['premium'];
                        $rep['today_tsg_cnt'] += 1;
                        // $todayTotalClose++;
                        // $todayTotalRev += $row['premium'];
                    }
                }
            }

            if (!empty($row['sent_to_accounting_date']) && $rev_month == $priorMonth && $rev_year == $priorYear) {
                if (strtolower($row['order_type']) == 'title only') {
                    if ($row['transaction_type'] == 'Purchase') {
                        $rep['prior_purchase_cnt']++;
                        $rep['prior_purchase_rev'] += $row['premium'];
                    } elseif ($row['transaction_type'] == 'Refinance') {
                        $rep['prior_refi_cnt']++;
                        $rep['prior_refi_rev'] += $row['premium'];
                    }

                } else if (strtolower($row['order_type']) == 'title & escrow' || strtolower($row['order_type']) == 'escrow only') {
                    $rep['prior_escrow_cnt']++;
                    $rep['prior_escrow_rev'] += $row['premium'];
                } else if (strtolower($row['order_type']) == 'trustee sale guarantee') {
                    $rep['prior_tsg_cnt']++;
                    $rep['prior_tsg_rev'] += $row['premium'];
                }
            }

            $rep['total_orders']++;
            /*if ($row['softpro_status'] == 'closed') {
                $rep['closed_orders']++;
            }*/
        }
        // echo "<pre>";
        // print_r($branches);
        // die;
        $salesUsers = $this->order->get_sales_users();
        $salesClosingFigure = [];
        if (!empty($salesUsers)) {
            foreach ($salesUsers as $row) {
                $salesId = $row['id'];
                $salesRepName = $row['full_name'];
                $createdCount = array_filter($records, function ($record) use ($startMonth, $endDate, $salesId) {
                    $created = date('Y-m-d', strtotime($record['created_at']));
                    // $rev_date = date('Y-m-d', strtotime($record['sent_to_accounting_date']));
                    return ($created >= $startMonth && $created <= $endDate && $record['sales_representative'] == $salesId);
                });
                $closedCount = array_filter($records, function ($record) use ($startMonth, $endDate, $salesId) {
                    $created = date('Y-m-d', strtotime($record['created_at']));
                    $rev_date = date('Y-m-d', strtotime($record['sent_to_accounting_date']));
                    return ($created >= $startMonth && $created <= $endDate && $rev_date >= $startMonth && $rev_date <= $endDate && $record['sales_representative'] == $salesId);
                });
                $salesClosingFigure[$salesRepName] = [
                    'created' => count($createdCount),
                    'closed' => count($closedCount),
                ];
            }
        }

        // echo "<pre>";
        // print_r($salesClosingFigure);die;

        
        // Finalize closing %
        foreach ($branches as $branch => &$branchData) {
            foreach ($branchData['sales_reps'] as $key => &$rep) {
                $rep['closing_ratio'] = isset($salesClosingFigure[$key]) && $salesClosingFigure[$key]['created'] > 0 ? round(($salesClosingFigure[$key]['closed'] / $salesClosingFigure[$key]['created']) * 100, 1) : 0;
                $rep['created_4m'] = isset($salesClosingFigure[$key]) && $salesClosingFigure[$key]['created'] > 0 ? $salesClosingFigure[$key]['created'] : 0;
                $rep['closed_4m'] = isset($salesClosingFigure[$key]) && $salesClosingFigure[$key]['closed'] > 0 ? $salesClosingFigure[$key]['closed'] : 0;
                
                // echo "<pre>";
                // print_r($rep);die;
                if ($rep['today_purchase_cnt'] == 0 && $rep['today_refi_cnt'] == 0 && $rep['today_escrow_cnt'] == 0 && $rep['today_tsg_cnt'] == 0 && $rep['prior_escrow_cnt'] == 0 && $rep['prior_purchase_cnt'] == 0  && $rep['prior_refi_cnt'] == 0  && $rep['prior_tsg_cnt'] == 0 && $rep['mtd_purchase_cnt'] == 0 && $rep['mtd_refi_cnt'] == 0 && $rep['mtd_escrow_cnt'] == 0 && $rep['mtd_tsg_cnt'] == 0) {
                    unset($branchData['sales_reps'][$key]);
                }
            }
            if (isset($branchData['sales_reps'])) {
                ksort($branchData['sales_reps']);  // Sort by key (sales_rep name)
            }
        }
        unset($branchData); // avoid reference issues
        ksort($branches);
        $daysDetails = [
            'workedDays' => $workedDays,
            'workingDaysRemaining' => $workingDaysRemaining,
            'todayDate' => date("m-d-Y", strtotime('-1 day')),
            'monthName' => $monthName
        ];
        // echo "<pre>";
        // print_r($branches);die;
        if ($this->input->is_ajax_request()) {
            $dataRes['html'] = $this->load->view('order/reports/sales_rep_branch_report', ['branches' => $branches, 'daysDetails' => $daysDetails], true);
            $res = array('status' => 'success', 'report' => $dataRes);
            echo json_encode($res);exit;
        } else {
            return $this->load->view('order/reports/sales_rep_branch_report', ['branches' => $branches, 'daysDetails' => $daysDetails], true);
        }
    }

    private function downloadSalesReport() {
        $pdfName = $this->order->generateR14Report('August', '2025');
    }

    public function escrowBranchReport()
    {
        if (empty($this->session->userdata('admin'))) {
            redirect(base_url() . 'order');
        }
        $data = [];
        $data['title'] = 'PCT Order: Mapped Report';

        // echo 'Hello';die;

        $userdata = $this->session->userdata('admin');
        
        // $titleOfficerList = [];
        $data['branch_reports'] = $this->getEscrowBranchReport();
        // print_r($data['branch_reports']);die;
        // $this->admintemplate->addCss(base_url('assets/frontend/css/sales-dashboard.css?v=' . $this->js_version));
        $this->admintemplate->addJS(base_url('assets/backend/js/dashboard.js?v=dashboard_1'));
        $this->admintemplate->show("order/reports", "escrow_report", $data);
    }

    public function getEscrowBranchReport() {
        /*if ($this->input->is_ajax_request()) {
            $filterType = $this->input->post('report_type');
            $yearMonth = $this->input->post('month_year');
            list($year, $month) = explode('-', $yearMonth);
            $selectedDate = strtotime($yearMonth . "-01");
            $startMonth = date('Y-m-01 00:00:00', strtotime('-3 months', $selectedDate));
            $endDate = date('Y-m-t 23:59:59', $selectedDate);
            $closedStartMonth = date('Y-m-01 00:00:00', strtotime('-1 months', $selectedDate));
            $today = 0;
            $monthName = date("F", strtotime($endDate));
            
            $priorMonth = date('m', strtotime('-1 months', $selectedDate));
            $priorYear  = date('Y', strtotime('-1 months', $selectedDate));
            if ($month == date('m') && $year == date('Y')) {
                $workedDays = $this->order->countWorkedDaysOfMonth();
                $workingDaysRemaining = $this->order->countWokingsDaysLeftOfMonth();
            } else {
                $workedDays = $this->order->countDaysOfMonth($month, $year);
                $workingDaysRemaining = 0;
            }
        } else {
            $startMonth = date('Y-m-01 00:00:00', strtotime('-3 months'));
            $endDate    = date('Y-m-d 23:59:59', strtotime('-1 day'));
            $closedStartMonth = date('Y-m-01 00:00:00', strtotime('-1 months'));
            $priorMonth = date('m', strtotime('-1 month'));
            $priorYear  = date('Y', strtotime('-1 month'));
            $today = date('d', strtotime('-1 day'));
            $month = date('m', strtotime('-1 day'));
            $year = date('Y', strtotime('-1 day'));
            $monthName = date("F", strtotime('-1 day'));
            $workedDays = $this->order->countWorkedDaysOfMonth();
            $workingDaysRemaining = $this->order->countWokingsDaysLeftOfMonth();
        }*/

        if ($this->input->is_ajax_request()) {
            $filterType = $this->input->post('report_type');
            $yearMonth = $this->input->post('month_year');
            list($year, $month) = explode('-', $yearMonth);
            // $selectedDate = strtotime($yearMonth . "-01");
            // $startMonth = date('Y-m-01 00:00:00', strtotime('-3 months', $selectedDate));
            // $endDate = date('Y-m-t 23:59:59', $selectedDate);
            // $closedStartMonth = date('Y-m-01 00:00:00', strtotime('-1 months', $selectedDate));
            // $today = 0;
            // $monthName = date("F", strtotime($endDate));
            
            // $priorMonth = date('m', strtotime('-1 months', $selectedDate));
            // $priorYear  = date('Y', strtotime('-1 months', $selectedDate));

            if ($month != date('m') || $year != date('Y')) {
                // echo "hello";die;
                $selectedDate = strtotime($yearMonth . "-01");
                $startMonth = date('Y-m-01 00:00:00', strtotime('-3 months', $selectedDate));
                $endDate = date('Y-m-t 23:59:59', $selectedDate);
                $closedStartMonth = date('Y-m-01 00:00:00', strtotime('-1 months', $selectedDate));
                $today = 0;
                $monthName = date("F", strtotime($endDate));
                
                $priorMonth = date('m', strtotime('-1 months', $selectedDate));
                $priorYear  = date('Y', strtotime('-1 months', $selectedDate));
            } else {
                if (date('d') == '01') {
                    $startMonth = date('Y-m-01 00:00:00', strtotime('-4 months'));
                    $endDate    = date('Y-m-d 23:59:59', strtotime('-1 day'));
                    $closedStartMonth = date('Y-m-01 00:00:00', strtotime('-2 months'));
                    $priorMonth = date('m', strtotime('-2 month'));
                    $priorYear  = date('Y', strtotime('-2 month'));
                } else {
                    $startMonth = date('Y-m-01 00:00:00', strtotime('-3 months'));
                    $endDate    = date('Y-m-d 23:59:59', strtotime('-1 day'));
                    $closedStartMonth = date('Y-m-01 00:00:00', strtotime('-1 months'));
                    $priorMonth = date('m', strtotime('-1 month'));
                    $priorYear  = date('Y', strtotime('-1 month'));
                }
                $today = date('d', strtotime('-1 day'));
                $month = date('m', strtotime('-1 day'));
                $year = date('Y', strtotime('-1 day'));
                $monthName = date("F", strtotime('-1 day'));
            }
            if ($month == date('m') && $year == date('Y')) {
                // $workedDays = $this->order->countWorkedDaysOfMonth();
                // $workingDaysRemaining = $this->order->countWokingsDaysLeftOfMonth();
                $workedDays = $this->order->countDaysOfMonth($month, $year);
                $workingDaysRemaining = $this->order->countWokingsDaysLeftOfSelectedMonth($today, $month, $year);
            } else {
                $workedDays = $this->order->countDaysOfMonth($month, $year);
                $workingDaysRemaining = 0;
            }
        } else {
            $startMonth = date('Y-m-01 00:00:00', strtotime('-3 months'));
            $endDate    = date('Y-m-d 23:59:59', strtotime('-1 day'));
            if (date('d') == '01') {
                $priorMonth = date('m', strtotime('-2 month'));
                $priorYear  = date('Y', strtotime('-2 month'));
                $closedStartMonth = date('Y-m-01 00:00:00', strtotime('-2 months'));
            } else {
                $priorMonth = date('m', strtotime('-1 month'));
                $priorYear  = date('Y', strtotime('-1 month'));
                $closedStartMonth = date('Y-m-01 00:00:00', strtotime('-1 months'));
            }
            $today = date('d', strtotime('-1 day'));
            $month = date('m', strtotime('-1 day'));
            $year = date('Y', strtotime('-1 day'));
            $monthName = date("F", strtotime('-1 day'));
            // $workedDays = $this->order->countWorkedDaysOfMonth();
            // $workingDaysRemaining = $this->order->countWokingsDaysLeftOfMonth();
            $workedDays = $this->order->countDaysOfMonth($month, $year);
            $workingDaysRemaining = $this->order->countWokingsDaysLeftOfSelectedMonth($today, $month, $year);
        }

        // echo $startMonth . ' - ' . $endDate . ' -- Prior month --' . $priorMonth . ' - ' . $priorYear . '-- Current Month --' . $month . ' - ' . $year . ' -- Today --' . date('d') . '<br>';
        // die;
        $data = [];
        $records = $this->get_all_sp_order_data($startMonth, $endDate, $closedStartMonth);
        // echo "<pre>";
        // print_r($records);
        // die;

        $branches = [];
        foreach ($records as $row) {
            $repId = $row['sales_representative'];
            $repName = $row['sales_rep'];
            if (empty($repName)) {
                continue;
            }
            if (strpos($row['file_number'], 'GLT') !== false) {
                $branchName = 'Glendale';
            } elseif (strpos($row['file_number'], 'OCT') !== false) {
                $branchName = 'Orange';
            } elseif (strpos($row['file_number'], 'ONT') !== false) {
                $branchName = 'Inland Empire';
            } elseif (strpos($row['file_number'], 'TSG') !== false || strtolower($row['order_type']) == 'trustee sale guarantee') {
                $branchName = 'TSG';
            } elseif (strpos($row['file_number'], 'PRV') !== false) {
                $branchName = 'Porterville';
            } else {
                continue;
                // $branchName = 'Unknown';
            }
            
            // $branchName = $branchMap[$profile] ?? 'Other';
            if (!isset($branches[$branchName])) {
                $branches[$branchName] = ['sales_reps' => []];
            }

            if (!isset($branches[$branchName]['sales_reps'][$repName])) {
                $branches[$branchName]['sales_reps'][$repName] = [
                    'sales_rep'   => $row['sales_rep'] ?? 'Unassigned',
                    'today_escrow_cnt' => 0,
                    'today_escrow_rev' => 0,
                    'mtd_escrow_cnt' => 0,
                    'mtd_escrow_rev' => 0,
                    'prior_escrow_cnt' => 0,
                    'prior_escrow_rev' => 0,
                    'closing_ratio'  => 0,
                    'total_orders'=> 0,
                    'closed_orders'=>0,
                    'closed_4m' => 0,
                    'created_4m' => 0,
                ];
            }

            $rep =&$branches[$branchName]['sales_reps'][$repName];

            $created_date = date('Y-m-d', strtotime($row['created_at']));
            // $closed_date = date('Y-m-d', strtotime($row['resware_closed_status_date']));
            $rev_date = date('Y-m-d', strtotime($row['sent_to_accounting_date']));
            $rev_day = date('d', strtotime($rev_date));
            $rev_month = date('m', strtotime($rev_date));
            $rev_year  = date('Y', strtotime($rev_date));

            $created_month = date('m', strtotime($created_date));
            $created_year  = date('Y', strtotime($created_date));
            

            if (!empty($row['sent_to_accounting_date']) && $rev_month == $month && $rev_year == $year) {
                if (strtolower($row['order_type']) == 'title & escrow' || strtolower($row['order_type']) == 'escrow only') {
                    $rep['mtd_escrow_rev'] += $row['premium'];
                    $rep['mtd_escrow_cnt'] += 1;
                    if ($rev_day == $today) {
                        $rep['today_escrow_rev'] += $row['premium'];
                        $rep['today_escrow_cnt']++;
                    }
                }
            }

            if (!empty($row['sent_to_accounting_date']) && $rev_month == $priorMonth && $rev_year == $priorYear) {
                if (strtolower($row['order_type']) == 'title & escrow' || strtolower($row['order_type']) == 'escrow only') {
                    $rep['prior_escrow_cnt']++;
                    $rep['prior_escrow_rev'] += $row['premium'];
                }
            }
            $rep['total_orders']++;
        }
        // die;
        $salesUsers = $this->order->get_sales_users();
        $salesClosingFigure = [];
        if (!empty($salesUsers)) {
            foreach ($salesUsers as $row) {
                // print_r($startMonth);
                // print_r($endDate);die;
                $salesId = $row['id'];
                $salesRepName = $row['full_name'];
                $createdCount = array_filter($records, function ($record) use ($startMonth, $endDate, $salesId) {
                    $created = date('Y-m-d', strtotime($record['created_at']));
                    // $rev_date = date('Y-m-d', strtotime($record['sent_to_accounting_date']));
                    return ($created >= $startMonth && $created <= $endDate && $record['sales_representative'] == $salesId);
                });
                $closedCount = array_filter($records, function ($record) use ($startMonth, $endDate, $salesId) {
                    $created = date('Y-m-d', strtotime($record['created_at']));
                    $rev_date = date('Y-m-d', strtotime($record['sent_to_accounting_date']));
                    return ($created >= $startMonth && $created <= $endDate && $rev_date >= $startMonth && $rev_date <= $endDate && $record['sales_representative'] == $salesId);
                });
                $salesClosingFigure[$salesRepName] = [
                    'created' => count($createdCount),
                    'closed' => count($closedCount),
                ];
            }
        }

        // echo "<pre>";
        // print_r($salesClosingFigure);die;

        
        // Finalize closing %
        foreach ($branches as $branch => &$branchData) {
            foreach ($branchData['sales_reps'] as $key => &$rep) {
                $rep['closing_ratio'] = isset($salesClosingFigure[$key]) && $salesClosingFigure[$key]['created'] > 0 ? round(($salesClosingFigure[$key]['closed'] / $salesClosingFigure[$key]['created']) * 100, 1) : 0;
                $rep['created_4m'] = isset($salesClosingFigure[$key]) && $salesClosingFigure[$key]['created'] > 0 ? $salesClosingFigure[$key]['created'] : 0;
                $rep['closed_4m'] = isset($salesClosingFigure[$key]) && $salesClosingFigure[$key]['closed'] > 0 ? $salesClosingFigure[$key]['closed'] : 0;
                
                if ($rep['today_escrow_cnt'] == 0 && $rep['prior_escrow_cnt'] == 0 && $rep['mtd_escrow_rev'] == 0 ) {
                    unset($branchData['sales_reps'][$key]);
                }
            }
            if (isset($branchData['sales_reps'])) {
                ksort($branchData['sales_reps']);  // Sort by key (sales_rep name)
            }
        }
        unset($branchData); // avoid reference issues
        ksort($branches);
        $daysDetails = [
            'workedDays' => $workedDays,
            'workingDaysRemaining' => $workingDaysRemaining,
            'todayDate' => date("m-d-Y", strtotime('-1 day')),
            'monthName' => $monthName
        ];
        // echo "<pre>";
        // print_r($branches);die;
        if ($this->input->is_ajax_request()) {
            $dataRes['html'] = $this->load->view('order/reports/escrow_branch_report', ['branches' => $branches, 'daysDetails' => $daysDetails], true);
            $res = array('status' => 'success', 'report' => $dataRes);
            echo json_encode($res);exit;
        } else {
            return $this->load->view('order/reports/escrow_branch_report', ['branches' => $branches, 'daysDetails' => $daysDetails], true);
        }
    }

    public function salesRankingReport()
    {
        if (empty($this->session->userdata('admin'))) {
            redirect(base_url() . 'order');
        }
        $data = [];
        $data['title'] = 'PCT Order: Mapped Report';

        // echo 'Hello';die;

        $userdata = $this->session->userdata('admin');
        
        // $titleOfficerList = [];
        $data['branch_reports'] = $this->getsalesRankingReport();
        // print_r($data['branch_reports']);die;
        // $this->admintemplate->addCss(base_url('assets/frontend/css/sales-dashboard.css?v=' . $this->js_version));
        $this->admintemplate->addJS(base_url('assets/backend/js/dashboard.js?v=dashboard_1'));
        $this->admintemplate->show("order/reports", "sales_rep_ranking_report", $data);
    }

    public function getsalesRankingReport() {
        if ($this->input->is_ajax_request()) {
            $filterType = $this->input->post('report_type');
            $yearMonth = $this->input->post('month_year');
            list($year, $month) = explode('-', $yearMonth);

            if ($month != date('m') || $year != date('Y')) {
                // echo "hello";die;
                $selectedDate = strtotime($yearMonth . "-01");
                $startMonth = date('Y-m-01 00:00:00', strtotime('-3 months', $selectedDate));
                $endDate = date('Y-m-t 23:59:59', $selectedDate);
                $closedStartMonth = date('Y-m-01 00:00:00', strtotime('-1 months', $selectedDate));
                $today = 0;
                $monthName = date("F", strtotime($endDate));
                
                $priorMonth = date('m', strtotime('-1 months', $selectedDate));
                $priorYear  = date('Y', strtotime('-1 months', $selectedDate));
            } else {
                if (date('d') == '01') {
                    $startMonth = date('Y-m-01 00:00:00', strtotime('-4 months'));
                    $endDate    = date('Y-m-d 23:59:59', strtotime('-1 day'));
                    $closedStartMonth = date('Y-m-01 00:00:00', strtotime('-2 months'));
                    $priorMonth = date('m', strtotime('-2 month'));
                    $priorYear  = date('Y', strtotime('-2 month'));
                } else {
                    $startMonth = date('Y-m-01 00:00:00', strtotime('-3 months'));
                    $endDate    = date('Y-m-d 23:59:59', strtotime('-1 day'));
                    $closedStartMonth = date('Y-m-01 00:00:00', strtotime('-1 months'));
                    $priorMonth = date('m', strtotime('-1 month'));
                    $priorYear  = date('Y', strtotime('-1 month'));
                }
                $today = date('d', strtotime('-1 day'));
                $month = date('m', strtotime('-1 day'));
                $year = date('Y', strtotime('-1 day'));
                $monthName = date("F", strtotime('-1 day'));
            }
            if ($month == date('m') && $year == date('Y')) {
                // $workedDays = $this->order->countWorkedDaysOfMonth();
                // $workingDaysRemaining = $this->order->countWokingsDaysLeftOfMonth();
                $workedDays = $this->order->countDaysOfMonth($month, $year);
                $workingDaysRemaining = $this->order->countWokingsDaysLeftOfSelectedMonth($today, $month, $year);
            } else {
                $workedDays = $this->order->countDaysOfMonth($month, $year);
                $workingDaysRemaining = 0;
            }
        } else {
            $startMonth = date('Y-m-01 00:00:00', strtotime('-3 months'));
            $endDate    = date('Y-m-d 23:59:59', strtotime('-1 day'));
            if (date('d') == '01') {
                $priorMonth = date('m', strtotime('-2 month'));
                $priorYear  = date('Y', strtotime('-2 month'));
                $closedStartMonth = date('Y-m-01 00:00:00', strtotime('-2 months'));
            } else {
                $priorMonth = date('m', strtotime('-1 month'));
                $priorYear  = date('Y', strtotime('-1 month'));
                $closedStartMonth = date('Y-m-01 00:00:00', strtotime('-1 months'));
            }
            $today = date('d', strtotime('-1 day'));
            $month = date('m', strtotime('-1 day'));
            $year = date('Y', strtotime('-1 day'));
            $monthName = date("F", strtotime('-1 day'));
            // $workedDays = $this->order->countWorkedDaysOfMonth();
            // $workingDaysRemaining = $this->order->countWokingsDaysLeftOfMonth();
            $workedDays = $this->order->countDaysOfMonth($month, $year);
            $workingDaysRemaining = $this->order->countWokingsDaysLeftOfSelectedMonth($today, $month, $year);
        }
        
        $data = [];
        
        $records = $this->get_all_sp_order_data($startMonth, $endDate, $closedStartMonth);
        
        $branches = [];
        foreach ($records as $row) {
            $repId = $row['sales_representative'];
            $repName = $row['sales_rep'];
            if (empty($repName)) {
                continue;
            }

            if (!isset($branches[$repName])) {
                $branches[$repName] = [
                    'sales_rep'   => $row['sales_rep'] ?? 'Unassigned',
                    // 'today_purchase_rev' => 0,
                    'total_rev' => 0,
                    'projected_rev' => 0,
                    'prior_rev' => 0,
                    'created_4m' => 0,
                    'closed_4m' => 0,
                    'closing_ratio'  => 0,
                    'total_orders'=> 0,
                    'closed_orders'=>0,
                ];
            }

            $rep =&$branches[$repName];

            $created_date = date('Y-m-d', strtotime($row['created_at']));
            $created_month = date('m', strtotime($created_date));
            $created_year  = date('Y', strtotime($created_date));
            
            $rev_date = date('Y-m-d', strtotime($row['sent_to_accounting_date']));
            $rev_day = date('d', strtotime($rev_date));
            $rev_month = date('m', strtotime($rev_date));
            $rev_year  = date('Y', strtotime($rev_date));

            

            if (!empty($row['sent_to_accounting_date']) && $rev_month == $month && $rev_year == $year) {
                $rep['total_rev'] += $row['premium'];
            }

            if (!empty($row['sent_to_accounting_date']) && $rev_month == $priorMonth && $rev_year == $priorYear) {
                $rep['prior_rev'] += $row['premium'];
            }

            $rep['total_orders']++;
        }
        
        $salesUsers = $this->order->get_sales_users();
        $salesClosingFigure = [];
        if (!empty($salesUsers)) {
            foreach ($salesUsers as $row) {
                $salesId = $row['id'];
                $salesRepName = $row['full_name'];
                $createdCount = array_filter($records, function ($record) use ($startMonth, $endDate, $salesId) {
                    $created = date('Y-m-d', strtotime($record['created_at']));
                    // $rev_date = date('Y-m-d', strtotime($record['sent_to_accounting_date']));
                    return ($created >= $startMonth && $created <= $endDate && $record['sales_representative'] == $salesId);
                });
                $closedCount = array_filter($records, function ($record) use ($startMonth, $endDate, $salesId) {
                    $created = date('Y-m-d', strtotime($record['created_at']));
                    $rev_date = date('Y-m-d', strtotime($record['sent_to_accounting_date']));
                    return ($created >= $startMonth && $created <= $endDate && $rev_date >= $startMonth && $rev_date <= $endDate && $record['sales_representative'] == $salesId);
                });
                $salesClosingFigure[$salesRepName] = [
                    'created' => count($createdCount),
                    'closed' => count($closedCount),
                ];
            }
        }
        
        // Finalize closing %
        foreach ($branches as $key => &$rep) {
            $rep['closing_ratio'] = isset($salesClosingFigure[$key]) && $salesClosingFigure[$key]['created'] > 0 ? round(($salesClosingFigure[$key]['closed'] / $salesClosingFigure[$key]['created']) * 100, 1) : 0;
            $rep['created_4m'] = isset($salesClosingFigure[$key]) && $salesClosingFigure[$key]['created'] > 0 ? $salesClosingFigure[$key]['created'] : 0;
            $rep['closed_4m'] = isset($salesClosingFigure[$key]) && $salesClosingFigure[$key]['closed'] > 0 ? $salesClosingFigure[$key]['closed'] : 0;
            $rep['projected_rev'] = $workedDays > 0 ? (($rep['total_rev'] / $workedDays) * ($workedDays + $workingDaysRemaining)) : $rep['total_rev'];
            
        }
        
        if (isset($branches)) {
            ksort($branches);  // Sort by key (sales_rep name)
        }
        
        // unset($branchData); // avoid reference issues
        // ksort($branches);
        $daysDetails = [
            'workedDays' => $workedDays,
            'workingDaysRemaining' => $workingDaysRemaining,
            'todayDate' => date("m-d-Y", strtotime('-1 day')),
            'monthName' => $monthName
        ];
        
        if ($this->input->is_ajax_request()) {
            $dataRes['html'] = $this->load->view('order/reports/sales_rep_ranking_branch_report', ['branches' => $branches, 'daysDetails' => $daysDetails], true);
            $res = array('status' => 'success', 'report' => $dataRes);
            echo json_encode($res);exit;
        } else {
            return $this->load->view('order/reports/sales_rep_ranking_branch_report', ['branches' => $branches, 'daysDetails' => $daysDetails], true);
        }
    }
    
    public function titleOfficerProductionReport()
    {
        if (empty($this->session->userdata('admin'))) {
            redirect(base_url() . 'order');
        }
        $data = [];
        $data['title'] = 'PCT Order: Mapped Title Officer Report';
        
        $userdata = $this->session->userdata('admin');
        
        $titleOfficerList = [];
        $data['branch_reports'] = $this->getTitleOfficerProductionReport();
        // $this->admintemplate->addCss(base_url('assets/frontend/css/sales-dashboard.css?v=' . $this->js_version));
        $this->admintemplate->addJS(base_url('assets/backend/js/dashboard.js?v=dashboard_1'));
        $this->admintemplate->show("order/reports", "title_officer_report", $data);
    }

    public function getTitleOfficerProductionReport() {
        $data = [];
        /*if ($this->input->is_ajax_request()) {
            $filterType = $this->input->post('report_type');
            $yearMonth = $this->input->post('month_year');
            list($year, $month) = explode('-', $yearMonth);
            $selectedDate = strtotime($yearMonth . "-01");
            $startMonth = date('Y-m-01 00:00:00', strtotime('-3 months', $selectedDate));
            $endDate = date('Y-m-t 23:59:59', $selectedDate);
            $closedStartMonth = date('Y-m-01 00:00:00', strtotime('-1 months', $selectedDate));
            $today = 0;
            $monthName = date("F", strtotime($endDate));
            
            $priorMonth = date('m', strtotime('-1 months', $selectedDate));
            $priorYear  = date('Y', strtotime('-1 months', $selectedDate));
            // echo $startMonth . ' - ' . $endDate . ' -- ' . '-- Month : ' . $month . '-- Year -- ' . $year . '-- Prior - ' . $priorMonth . ' - ' . $priorYear ;
            // die;
            if ($month == date('m') && $year == date('Y')) {
                $workedDays = $this->order->countWorkedDaysOfMonth();
                $workingDaysRemaining = $this->order->countWokingsDaysLeftOfMonth();
            } else {
                $workedDays = $this->order->countDaysOfMonth($month, $year);
                $workingDaysRemaining = 0;
            }
        } else {
            $startMonth = date('Y-m-01 00:00:00', strtotime('-3 months'));
            $endDate    = date('Y-m-d 23:59:59', strtotime('-1 day'));
            if (date('d') == '01') {
                $priorMonth = date('m', strtotime('-2 month'));
                $priorYear  = date('Y', strtotime('-2 month'));
                $closedStartMonth = date('Y-m-01 00:00:00', strtotime('-2 months'));
            } else {
                $priorMonth = date('m', strtotime('-1 month'));
                $priorYear  = date('Y', strtotime('-1 month'));
                $closedStartMonth = date('Y-m-01 00:00:00', strtotime('-1 months'));
            }
            $today = date('d', strtotime('-1 day'));
            $month = date('m', strtotime('-1 day'));
            $year = date('Y', strtotime('-1 day'));
            $monthName = date("F", strtotime('-1 day'));
            // $workedDays = $this->order->countWorkedDaysOfMonth();
            // $workingDaysRemaining = $this->order->countWokingsDaysLeftOfMonth();
            $workedDays = $this->order->countDaysOfMonth($month, $year);
            $workingDaysRemaining = $this->order->countWokingsDaysLeftOfSelectedMonth($today, $month, $year);
        }*/
        if ($this->input->is_ajax_request()) {
            $filterType = $this->input->post('report_type');
            $yearMonth = $this->input->post('month_year');
            list($year, $month) = explode('-', $yearMonth);
            // $selectedDate = strtotime($yearMonth . "-01");
            // $startMonth = date('Y-m-01 00:00:00', strtotime('-3 months', $selectedDate));
            // $endDate = date('Y-m-t 23:59:59', $selectedDate);
            // $closedStartMonth = date('Y-m-01 00:00:00', strtotime('-1 months', $selectedDate));
            // $today = 0;
            // $monthName = date("F", strtotime($endDate));
            
            // $priorMonth = date('m', strtotime('-1 months', $selectedDate));
            // $priorYear  = date('Y', strtotime('-1 months', $selectedDate));

            if ($month != date('m') || $year != date('Y')) {
                // echo "hello";die;
                $selectedDate = strtotime($yearMonth . "-01");
                $startMonth = date('Y-m-01 00:00:00', strtotime('-3 months', $selectedDate));
                $endDate = date('Y-m-t 23:59:59', $selectedDate);
                $closedStartMonth = date('Y-m-01 00:00:00', strtotime('-1 months', $selectedDate));
                $today = 0;
                $monthName = date("F", strtotime($endDate));
                
                $priorMonth = date('m', strtotime('-1 months', $selectedDate));
                $priorYear  = date('Y', strtotime('-1 months', $selectedDate));
            } else {
                if (date('d') == '01') {
                    $startMonth = date('Y-m-01 00:00:00', strtotime('-4 months'));
                    $endDate    = date('Y-m-d 23:59:59', strtotime('-1 day'));
                    $closedStartMonth = date('Y-m-01 00:00:00', strtotime('-2 months'));
                    $priorMonth = date('m', strtotime('-2 month'));
                    $priorYear  = date('Y', strtotime('-2 month'));
                } else {
                    $startMonth = date('Y-m-01 00:00:00', strtotime('-3 months'));
                    $endDate    = date('Y-m-d 23:59:59', strtotime('-1 day'));
                    $closedStartMonth = date('Y-m-01 00:00:00', strtotime('-1 months'));
                    $priorMonth = date('m', strtotime('-1 month'));
                    $priorYear  = date('Y', strtotime('-1 month'));
                }
                $today = date('d', strtotime('-1 day'));
                $month = date('m', strtotime('-1 day'));
                $year = date('Y', strtotime('-1 day'));
                $monthName = date("F", strtotime('-1 day'));
            }
            if ($month == date('m') && $year == date('Y')) {
                // $workedDays = $this->order->countWorkedDaysOfMonth();
                // $workingDaysRemaining = $this->order->countWokingsDaysLeftOfMonth();
                $workedDays = $this->order->countDaysOfMonth($month, $year);
                $workingDaysRemaining = $this->order->countWokingsDaysLeftOfSelectedMonth($today, $month, $year);
            } else {
                $workedDays = $this->order->countDaysOfMonth($month, $year);
                $workingDaysRemaining = 0;
            }
        } else {
            $startMonth = date('Y-m-01 00:00:00', strtotime('-3 months'));
            $endDate    = date('Y-m-d 23:59:59', strtotime('-1 day'));
            if (date('d') == '01') {
                $priorMonth = date('m', strtotime('-2 month'));
                $priorYear  = date('Y', strtotime('-2 month'));
                $closedStartMonth = date('Y-m-01 00:00:00', strtotime('-2 months'));
            } else {
                $priorMonth = date('m', strtotime('-1 month'));
                $priorYear  = date('Y', strtotime('-1 month'));
                $closedStartMonth = date('Y-m-01 00:00:00', strtotime('-1 months'));
            }
            $today = date('d', strtotime('-1 day'));
            $month = date('m', strtotime('-1 day'));
            $year = date('Y', strtotime('-1 day'));
            $monthName = date("F", strtotime('-1 day'));
            $workedDays = $this->order->countDaysOfMonth($month, $year);
            $workingDaysRemaining = $this->order->countWokingsDaysLeftOfSelectedMonth($today, $month, $year);
        }
        
        $records = $this->get_all_to_order_data($startMonth, $endDate, $closedStartMonth);
        
        $branches = [];
        foreach ($records as $row) {
            // $profile = $row['profile'];
            if (empty($row['title_officer']) || empty($row['officer_name'])) {
                continue;
            }

            if (strpos($row['file_number'], 'GLT') !== false) {
                $branchName = 'Glendale';
            } elseif (strpos($row['file_number'], 'OCT') !== false) {
                $branchName = 'Orange';
            } elseif (strpos($row['file_number'], 'ONT') !== false) {
                $branchName = 'Inland Empire';
            } elseif (strpos($row['file_number'], 'TSG') !== false || strtolower($row['order_type']) == 'trustee sale guarantee') {
                $branchName = 'TSG';
            } elseif (strpos($row['file_number'], 'PRV') !== false) {
                $branchName = 'Porterville';
            } else {
                continue;
                // $branchName = 'Unknown';
            }

            $repId = $row['title_officer'];
            $titleOfficerName = $row['officer_name'];

            if (!isset($branches[$branchName])) {
                $branches[$branchName] = ['title_officer' => []];
            }

            if (!isset($branches[$branchName]['title_officer'][$titleOfficerName])) {
                $branches[$branchName]['title_officer'][$titleOfficerName] = [
                    'officer_name'   => $row['officer_name'] ?? 'Unassigned',
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
                    'today_escrow_cnt' => 0,
                    'today_escrow_rev' => 0,
                    'mtd_escrow_cnt' => 0,
                    'mtd_escrow_rev' => 0,
                    'prior_escrow_cnt' => 0,
                    'prior_escrow_rev' => 0,
                    'escrow_rev'  => 0,

                    'today_tsg_cnt' => 0,
                    'today_tsg_rev' => 0,
                    'mtd_tsg_cnt' => 0,
                    'mtd_tsg_rev' => 0,
                    'prior_tsg_cnt' => 0,
                    'prior_tsg_rev' => 0,
                    

                    'created_4m' => 0,
                    'closed_4m' => 0,
                    'closing_ratio'  => 0,
                    'total_orders'=> 0,
                    'closed_orders'=>0,
                ];
            }

            $rep =&$branches[$branchName]['title_officer'][$titleOfficerName];

            $created_date = date('Y-m-d', strtotime($row['created_at']));
            // $closed_date = date('Y-m-d', strtotime($row['resware_closed_status_date']));
            $rev_date = date('Y-m-d', strtotime($row['sent_to_accounting_date']));
            $rev_day = date('d', strtotime($rev_date));
            $rev_month = date('m', strtotime($rev_date));
            $rev_year  = date('Y', strtotime($rev_date));

            $created_month = date('m', strtotime($created_date));
            $created_year  = date('Y', strtotime($created_date));
            
            if (!empty($row['sent_to_accounting_date']) && $rev_month == $month && $rev_year == $year) {
                
                // if (strtolower($row['order_type']) == 'title only') {
                    if ($row['transaction_type'] == 'Purchase') {
                        $rep['mtd_purchase_rev'] += $row['premium'];
                        $rep['mtd_purchase_cnt'] += 1;
                        if ($rev_day == $today) {
                            $rep['today_purchase_rev'] += $row['premium'];
                            $rep['today_purchase_cnt'] += 1;
                        }
                    } else if ($row['transaction_type'] == 'Refinance') {
                        $rep['mtd_refi_rev'] += $row['premium'];
                        $rep['mtd_refi_cnt'] += 1;
                        if ($rev_day == $today) {
                            $rep['today_refi_rev'] += $row['premium'];
                            $rep['today_refi_cnt'] += 1;
                        }
                    }
                // } else if (strtolower($row['order_type']) == 'title & escrow' || strtolower($row['order_type']) == 'escrow only') {
                //     $rep['mtd_escrow_rev'] += $row['premium'];
                //     $rep['mtd_escrow_cnt'] += 1;
                //     if ($rev_day == $today) {
                //         $rep['today_escrow_rev'] += $row['premium'];
                //         $rep['today_escrow_cnt']++;
                //     }
                // } else if (strtolower($row['order_type']) == 'trustee sale guarantee') {
                //     $rep['mtd_tsg_rev'] += $row['premium'];
                //     $rep['mtd_tsg_cnt'] += 1;
                //     if ($rev_day == $today) {
                //         $rep['today_tsg_rev'] += $row['premium'];
                //         $rep['today_tsg_cnt'] += 1;
                //         $todayTotalClose++;
                //         $todayTotalRev += $row['premium'];
                //     }
                // }
            }

            if (!empty($row['sent_to_accounting_date']) && $rev_month == $priorMonth && $rev_year == $priorYear) {
                // if (strtolower($row['order_type']) == 'title only') {
                    if ($row['transaction_type'] == 'Purchase') {
                        $rep['prior_purchase_cnt']++;
                        $rep['prior_purchase_rev'] += $row['premium'];
                    } elseif ($row['transaction_type'] == 'Refinance') {
                        $rep['prior_refi_cnt']++;
                        $rep['prior_refi_rev'] += $row['premium'];
                    }
                // } else if (strtolower($row['order_type']) == 'title & escrow' || strtolower($row['order_type']) == 'escrow only') {
                //     $rep['prior_escrow_cnt']++;
                //     $rep['prior_escrow_rev'] += $row['premium'];
                // } else if (strtolower($row['order_type']) == 'trustee sale guarantee') {
                //     $rep['prior_tsg_cnt']++;
                //     $rep['prior_tsg_rev'] += $row['premium'];
                // }
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
        
        foreach ($branches as $branch => &$branchData) {
            if (isset($branchData['title_officer'])) {
                ksort($branchData['title_officer']);  // Sort by key (title officer name)
            }
            foreach($branchData['title_officer'] as $titleOfficerId => &$titleOfficerData) {
                if ($titleOfficerData['today_purchase_cnt'] == 0 && $titleOfficerData['today_refi_cnt'] == 0 && $titleOfficerData['today_tsg_cnt'] == 0 && $titleOfficerData['prior_purchase_cnt'] == 0 && $titleOfficerData['prior_tsg_cnt'] == 0 && $titleOfficerData['mtd_purchase_cnt'] == 0 && $titleOfficerData['mtd_refi_rev'] == 0 && $titleOfficerData['prior_refi_cnt'] == 0 && $titleOfficerData['mtd_tsg_rev'] == 0) {
                    unset($branchData['title_officer'][$titleOfficerId]);
                }
            }
        }
        
        unset($branchData);
        ksort($branches);
        $daysDetails = [
            'workedDays' => $workedDays,
            'workingDaysRemaining' => $workingDaysRemaining,
            'todayDate' => date("m-d-Y", strtotime('-1 day')),
            'monthName' => $monthName
        ];
        // echo "<pre>";
        // print_r($branches);die;
        if ($this->input->is_ajax_request()) {
            $dataRes['html'] = $this->load->view('order/reports/title_officer_branch_report', ['branches' => $branches, 'daysDetails' => $daysDetails], true);
            $res = array('status' => 'success', 'report' => $dataRes);
            echo json_encode($res);exit;
        } else {
            return $this->load->view('order/reports/title_officer_branch_report', ['branches' => $branches, 'daysDetails' => $daysDetails], true);
        }
    }

    public function branchAnalyticsReport()
    {
        if (empty($this->session->userdata('admin'))) {
            redirect(base_url() . 'order');
        }
        $data = [];
        $data['title'] = 'PCT Order: Branch Analytics Report';
        
        $userdata = $this->session->userdata('admin');
        
        
        // echo "<pre>";
        // print_r($analysis);die;
        // $data['summary_reports'] = $this->branchAnalyticsSummary($branches);
        $data['branch_analytics_reports'] = $this->getBranchAnalyticsReport();
        $this->admintemplate->addJS(base_url('assets/backend/js/dashboard.js?v=dashboard_1'));
        $this->admintemplate->show("order/reports", "branch_analytics_report", $data);
    }

    public function getBranchAnalyticsReport() {
        $titleOfficerList = [];

        if ($this->input->is_ajax_request()) {
            $filterType = $this->input->post('report_type');
            $yearMonth = $this->input->post('month_year');
            list($year, $month) = explode('-', $yearMonth);
            if ($month != date('m') || $year != date('Y')) {
                // echo "hello";die;
                $selectedDate = strtotime($yearMonth . "-01");
                $startMonth = date('Y-m-01 00:00:00', strtotime('-1 months', $selectedDate));
                $endDate = date('Y-m-t 23:59:59', $selectedDate);
                $today = 0;
                $monthName = date("F", strtotime($endDate));
                
                $priorMonth = date('m', strtotime('-1 months', $selectedDate));
                $priorYear  = date('Y', strtotime('-1 months', $selectedDate));
            } else {
                if (date('d') == '01') {
                    // echo "hello prior";die;
                    $startMonth = date('Y-m-01 00:00:00', strtotime('-2 months'));
                    $endDate    = date('Y-m-d 23:59:59', strtotime('-1 day'));
                    $priorMonth = date('m', strtotime('-2 month'));
                    $priorYear  = date('Y', strtotime('-2 month'));
                } else {
                    $startMonth = date('Y-m-01 00:00:00', strtotime('-1 months'));
                    $endDate    = date('Y-m-d 23:59:59', strtotime('-1 day'));
                    $priorMonth = date('m', strtotime('-1 month'));
                    $priorYear  = date('Y', strtotime('-1 month'));
                }
                $today = date('d', strtotime('-1 day'));
                $month = date('m', strtotime('-1 day'));
                $year = date('Y', strtotime('-1 day'));
                $monthName = date("F", strtotime('-1 day'));
            }
            if ($month == date('m') && $year == date('Y')) {
                // $workedDays = $this->order->countWorkedDaysOfMonth();
                // $workingDaysRemaining = $this->order->countWokingsDaysLeftOfMonth();
                $workedDays = $this->order->countDaysOfMonth($month, $year);
                $workingDaysRemaining = $this->order->countWokingsDaysLeftOfSelectedMonth($today, $month, $year);
            } else {
                $workedDays = $this->order->countDaysOfMonth($month, $year);
                $workingDaysRemaining = 0;
            }
        } else {
            if (date('d') == '01') {
                $priorMonth = date('m', strtotime('-2 month'));
                $priorYear  = date('Y', strtotime('-2 month'));
                $startMonth = date('Y-m-01 00:00:00', strtotime('-2 months'));
                $endDate    = date('Y-m-d 23:59:59', strtotime('-1 day'));
            } else {
                $startMonth = date('Y-m-01 00:00:00', strtotime('-1 months'));
                $endDate    = date('Y-m-d 23:59:59', strtotime('-1 day'));
                $priorMonth = date('m', strtotime('-1 month'));
                $priorYear  = date('Y', strtotime('-1 month'));
            }
            // $priorMonth = date('m', strtotime('-1 month'));
            // $priorYear  = date('Y', strtotime('-1 month'));
            $today = date('d', strtotime('-1 day'));
            $month = date('m', strtotime('-1 day'));
            $year = date('Y', strtotime('-1 day'));
            $monthName = date("F", strtotime('-1 day'));
            // $workedDays = $this->order->countWorkedDaysOfMonth();
            // $workingDaysRemaining = $this->order->countWokingsDaysLeftOfMonth();
            $workedDays = $this->order->countDaysOfMonth($month, $year);
            $workingDaysRemaining = $this->order->countWokingsDaysLeftOfSelectedMonth($today, $month, $year);
        }
        // echo $startMonth . ' - ' . $endDate . ' -- ' . '-- Month : ' . $month . '-- Year -- ' . $year . '-- Prior - ' . $priorMonth . ' - ' . $priorYear ;
        // die;
        
        $records = $this->get_all_order_data($startMonth, $endDate);
        
        $todayTotalOpen = 0;
        $todayTotalClose = 0;
        $mtdTotalOpen = 0;
        $mtdTotalClose = 0;
        $priorTotalOpen = 0;
        $priorTotalClose = 0;

        $todayTotalRev = 0;
        $mtdTotalRev = 0;
        $priorTotalRev = 0;
        
        $branches = [];
        foreach ($records as $row) {
            // $profile = $row['profile'];
            if (strpos($row['file_number'], 'GLT') !== false) {
                $branchName = 'Glendale';
            } elseif (strpos($row['file_number'], 'OCT') !== false) {
                $branchName = 'Orange';
            } elseif (strpos($row['file_number'], 'ONT') !== false) {
                $branchName = 'Inland Empire';
            } elseif (strpos($row['file_number'], 'TSG') !== false || strtolower($row['order_type']) == 'trustee sale guarantee') {
                $branchName = 'TSG';
            } elseif (strpos($row['file_number'], 'PRV') !== false) {
                $branchName = 'Porterville';
            } else {
                continue;
            }
            // $repId = $row['title_officer'];

            if (!isset($branches[$branchName])) {
                $branches[$branchName] = [
                    'today_purchase_open_cnt' => 0,
                    'mtd_purchase_open_cnt' => 0,
                    'prior_purchase_open_cnt' => 0,

                    'today_purchase_close_cnt' => 0,
                    'mtd_purchase_close_cnt' => 0,
                    'prior_purchase_close_cnt' => 0,
                    
                    'today_purchase_rev' => 0,
                    'mtd_purchase_rev' => 0,
                    'prior_purchase_rev' => 0,
                    
                    
                    'today_refi_open_cnt' => 0,
                    'mtd_refi_open_cnt' => 0,
                    'prior_refi_open_cnt' => 0,

                    'today_refi_close_cnt' => 0,
                    'mtd_refi_close_cnt' => 0,
                    'prior_refi_close_cnt' => 0,
                    
                    'today_refi_rev' => 0,
                    'mtd_refi_rev' => 0,
                    'prior_refi_rev' => 0,

                    'today_tsg_open_cnt' => 0,
                    'mtd_tsg_open_cnt' => 0,
                    'prior_tsg_open_cnt' => 0,

                    'today_tsg_close_cnt' => 0,
                    'mtd_tsg_close_cnt' => 0,
                    'prior_tsg_close_cnt' => 0,
                    
                    'today_tsg_rev' => 0,
                    'mtd_tsg_rev' => 0,
                    'prior_tsg_rev' => 0,
                    
                    'today_escrow_open_cnt' => 0,
                    'mtd_escrow_open_cnt' => 0,
                    'prior_escrow_open_cnt' => 0,

                    'today_escrow_close_cnt' => 0,
                    'mtd_escrow_close_cnt' => 0,
                    'prior_escrow_close_cnt' => 0,
                    
                    'mtd_escrow_rev' => 0,
                    'prior_escrow_rev' => 0,
                    'today_escrow_rev' => 0,
                ];
            }

            $rep =&$branches[$branchName];

            $created_date = date('Y-m-d', strtotime($row['created_at']));
            $rev_date = date('Y-m-d', strtotime($row['sent_to_accounting_date']));
            if (!empty($row['sent_to_accounting_date'])) {
                $rev_day = date('d', strtotime($rev_date));
                $rev_month = date('m', strtotime($rev_date));
                $rev_year  = date('Y', strtotime($rev_date));
            } else {
                // echo $rev_day . ' ' . $rev_month . ' ' . $rev_year . '<br>';die;
                $rev_day = $rev_month = $rev_year = null;
            }

            $created_day = date('d', strtotime($created_date));
            $created_month = date('m', strtotime($created_date));
            $created_year  = date('Y', strtotime($created_date));

            /** current month and today's open order count calculation */
            if ($created_month == $month && $created_year == $year) {
                $mtdTotalOpen++;
                if (strtolower($row['order_type']) == 'title only') {
                    if ($row['transaction_type'] == 'Purchase') {
                        $rep['mtd_purchase_open_cnt'] += 1;
                        if ($created_day == $today) {
                            $rep['today_purchase_open_cnt']++;
                            $todayTotalOpen++;
                        }
                    } else if ($row['transaction_type'] == 'Refinance') {
                        // $mtdTotalOpen++;
                        $rep['mtd_refi_open_cnt'] += 1;
                        if ($created_day == $today) {
                            $rep['today_refi_open_cnt']++;
                            $todayTotalOpen++;
                        }
                    }
                } else if (strtolower($row['order_type']) == 'title & escrow' || strtolower($row['order_type']) == 'escrow only') {
                    // $mtdTotalOpen++;
                    $rep['mtd_escrow_open_cnt']++;
                    if ($created_day == $today) {
                        $rep['today_escrow_open_cnt']++;
                        $todayTotalOpen++;
                    }
                } else if (strtolower($row['order_type']) == 'trustee sale guarantee') {
                    // if ($row['transaction_type'] == 'Purchase') {
                        $rep['mtd_tsg_open_cnt'] += 1;
                        if ($created_day == $today) {
                            $rep['today_tsg_open_cnt']++;
                            $todayTotalOpen++;
                        }
                    // } else if ($row['transaction_type'] == 'Refinance') {
                    //     // $mtdTotalOpen++;
                    //     $rep['mtd_refi_open_cnt'] += 1;
                    //     if ($created_day == $today) {
                    //         $rep['today_refi_open_cnt']++;
                    //         $todayTotalOpen++;
                    //     }
                    // }
                }
            }

            /** current month and today's closed order count and revenue calculation */
            if ($rev_month == $month && $rev_year == $year) {
                $mtdTotalRev += $row['premium'];
                $mtdTotalClose++;
                if (strtolower($row['order_type']) == 'title only') {
                    if ($row['transaction_type'] == 'Purchase') {
                        $rep['mtd_purchase_rev'] += $row['premium'];
                        $rep['mtd_purchase_close_cnt'] += 1;
                        if ($rev_day == $today) {
                            $rep['today_purchase_rev'] += $row['premium'];
                            $rep['today_purchase_close_cnt'] += 1;
                            $todayTotalClose++;
                            $todayTotalRev += $row['premium'];
                        }
                    } else if ($row['transaction_type'] == 'Refinance') {
                        // $mtdTotalClose++;
                        $rep['mtd_refi_rev'] += $row['premium'];
                        $rep['mtd_refi_close_cnt'] += 1;
                        if ($rev_day == $today) {
                            $rep['today_refi_rev'] += $row['premium'];
                            $rep['today_refi_close_cnt'] += 1;
                            $todayTotalClose++;
                            $todayTotalRev += $row['premium'];
                        }
                    }
                } else if (strtolower($row['order_type']) == 'title & escrow' || strtolower($row['order_type']) == 'escrow only') {
                    // $mtdTotalClose++;
                    // $mtdTotalRev += $row['premium'];
                    $rep['mtd_escrow_rev'] += $row['premium'];
                    $rep['mtd_escrow_close_cnt'] += 1;
                    if ($rev_day == $today) {
                        $rep['today_escrow_rev'] += $row['premium'];
                        $rep['today_escrow_close_cnt']++;
                        $todayTotalClose++;
                        $todayTotalRev += $row['premium'];
                    }
                } else if (strtolower($row['order_type']) == 'trustee sale guarantee') {
                    // if ($row['transaction_type'] == 'Purchase') {
                        $rep['mtd_tsg_rev'] += $row['premium'];
                        $rep['mtd_tsg_close_cnt'] += 1;
                        if ($rev_day == $today) {
                            $rep['today_tsg_rev'] += $row['premium'];
                            $rep['today_tsg_close_cnt'] += 1;
                            $todayTotalClose++;
                            $todayTotalRev += $row['premium'];
                        }
                    // } else if ($row['transaction_type'] == 'Refinance') {
                    //     // $mtdTotalClose++;
                    //     $rep['mtd_refi_rev'] += $row['premium'];
                    //     $rep['mtd_refi_close_cnt'] += 1;
                    //     if ($rev_day == $today) {
                    //         $rep['today_refi_rev'] += $row['premium'];
                    //         $rep['today_refi_close_cnt'] += 1;
                    //         $todayTotalClose++;
                    //         $todayTotalRev += $row['premium'];
                    //     }
                    // }
                }
                
            }

            /** Prior month created order count */
            if ($created_month == $priorMonth && $created_year == $priorYear) {
                $priorTotalOpen++;
                if (strtolower($row['order_type']) == 'title only') {
                    if ($row['transaction_type'] == 'Purchase') {
                        $rep['prior_purchase_open_cnt'] += 1;
                    } else if ($row['transaction_type'] == 'Refinance') {
                        $rep['prior_refi_open_cnt'] += 1;
                        // $priorTotalOpen++;
                    }
                } else if (strtolower($row['order_type']) == 'title & escrow' || strtolower($row['order_type']) == 'escrow only') {
                    $rep['prior_escrow_open_cnt']++;
                    // $priorTotalOpen++;
                } else if (strtolower($row['order_type']) == 'trustee sale guarantee') {
                    // if ($row['transaction_type'] == 'Purchase') {
                        $rep['prior_tsg_open_cnt'] += 1;
                        // $priorTotalOpen++;
                    // } else if ($row['transaction_type'] == 'Refinance') {
                    //     $rep['prior_refi_open_cnt'] += 1;
                    //     $priorTotalOpen++;
                    // }
                }
            }

            /** Prior month closed order count and revenue calculation */
            if ($rev_month == $priorMonth && $rev_year == $priorYear) {
                $priorTotalRev += $row['premium'];
                $priorTotalClose++;
                if (strtolower($row['order_type']) == 'title only') {
                    if ($row['transaction_type'] == 'Purchase') {
                        $rep['prior_purchase_close_cnt']++;
                        $rep['prior_purchase_rev'] += $row['premium'];
                    } else if ($row['transaction_type'] == 'Refinance') {
                        // $priorTotalClose++;
                        $rep['prior_refi_close_cnt']++;
                        $rep['prior_refi_rev'] += $row['premium'];
                    }
                } else if (strtolower($row['order_type']) == 'title & escrow' || strtolower($row['order_type']) == 'escrow only') {
                    // $priorTotalClose++;
                    // $priorTotalRev += $row['premium'];
                    $rep['prior_escrow_close_cnt']++;
                    $rep['prior_escrow_rev'] += $row['premium'];
                } else if (strtolower($row['order_type']) == 'trustee sale guarantee') {
                    // if ($row['transaction_type'] == 'Purchase') {
                        $rep['prior_tsg_close_cnt']++;
                        $rep['prior_tsg_rev'] += $row['premium'];
                    // } else if ($row['transaction_type'] == 'Refinance') {
                    //     // $priorTotalClose++;
                    //     $rep['prior_refi_close_cnt']++;
                    //     $rep['prior_refi_rev'] += $row['premium'];
                    // }
                }
            }
            
            // if ($created_date >= $startMonth && $created_date <= $endDate) {
            //     $rep['created_4m']++;
            //     // echo $repId . ' - ' . $created_date . ' - ' . $rev_date . '<br>';
            //     // Among them, check if closed also in the range
            //     if (!empty($rev_date) && $rev_date >= $startMonth && $rev_date <= $endDate) {
            //         $rep['closed_4m']++;
            //     }
            // }

            // $rep['total_orders']++;
            // if ($row['softpro_status'] == 'closed') {
            //     $rep['closed_orders']++;
            // }
        }
        $analysis['monthName'] = $monthName;
        $analysis['branchData'] = $branches;
        $analysis['summaryData'] = [
            'todayTotalOpen' => $todayTotalOpen,
            'todayTotalClose' => $todayTotalClose,
            'mtdTotalOpen' => $mtdTotalOpen,
            'mtdTotalClose' => $mtdTotalClose,
            'priorTotalOpen' => $priorTotalOpen,
            'priorTotalClose' => $priorTotalClose,
            'todayTotalRev' => $todayTotalRev,
            'mtdTotalRev' => $mtdTotalRev,
            'priorTotalRev' => $priorTotalRev,
            'workedDays' => $workedDays,
            'workingDaysRemaining' => $workingDaysRemaining,
            'todayDate' => date("m-d-Y", strtotime('-1 day'))
        ];
        // echo "<pre>";
        // print_r($analysis);die;
        if ($this->input->is_ajax_request()) {
            $dataRes['html'] = $this->load->view('order/reports/branch_analytics', $analysis, true);
            $res = array('status' => 'success', 'report' => $dataRes);
            echo json_encode($res);exit;
        } else {
            // return $this->load->view('order/reports/mapped_to_branch_report', $analysis, true);
            return $this->load->view('order/reports/branch_analytics', $analysis, true);
        }
    }

    public function branchAnalyticsSummary($summary) {
        $data = [];
        return $this->load->view('order/reports/branch_analytics_summary', ['summary' => $summary], true);
    }
}
