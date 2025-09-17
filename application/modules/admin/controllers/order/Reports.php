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
        return $records = $this->db->select('o.id as order_id, o.status, o.softpro_status, o.prod_type, o.profile, o.premium, o.file_number, o.resware_closed_status_date, o.sent_to_accounting_date, t.sales_representative, t.title_officer, u.full_name as sales_rep, o.created_at, ot.order_type')
        // $records = $this->db->select('o.id as order_id, o.status, o.softpro_status, o.prod_type, o.profile, o.premium, o.file_number, o.resware_closed_status_date, o.sent_to_accounting_date, t.sales_representative, t.title_officer, u.full_name as sales_rep, o.created_at, ot.order_type')
            ->from('order_details o')
            ->join('transaction_details t', 'o.transaction_id = t.id', 'left')
            ->join('pct_softpro_lookup_table u', 't.sales_representative = u.id', 'left')
            ->join('pct_softpro_order_type ot', 't.order_type = ot.id', 'left')
            ->where('o.created_at >=', $fromDate)
            ->where('o.created_at <=', $toDate)
            // ->where('t.sales_representative', 12694)
            // ->where('o.prod_type', 'Refinance')
            // ->where('o.sent_to_accounting_date is not null')
            ->get()
            // echo $this->db->last_query();exit;
            ->result_array();
    }

    public function get_all_to_order_data($fromDate, $toDate) {
        return $records = $this->db->select('o.id as order_id, o.status, o.softpro_status, o.prod_type, o.profile, o.premium, o.file_number, o.resware_closed_status_date, o.sent_to_accounting_date, t.sales_representative, t.title_officer, u.officer_name, o.created_at, ot.order_type')
            ->from('order_details o')
            ->join('transaction_details t', 'o.transaction_id = t.id', 'left')
            ->join('pct_softpro_lookup_table u', 't.title_officer = u.id', 'left')
            ->join('pct_softpro_order_type ot', 't.order_type = ot.id', 'left')
            ->where('o.created_at >=', $fromDate)
            ->where('o.created_at <=', $toDate)
            // ->where('o.profile is not null')
            ->get()
            // echo $this->db->last_query();exit;
            ->result_array();
    }

    public function get_all_order_data($fromDate, $toDate) {
        return $records = $this->db->select('o.id as order_id, o.status, o.softpro_status, o.prod_type, o.profile, o.premium, o.file_number, o.resware_closed_status_date, o.sent_to_accounting_date, t.sales_representative, t.title_officer, o.created_at, ot.order_type')
            ->from('order_details o')
            ->join('transaction_details t', 'o.transaction_id = t.id', 'left')
            // ->join('pct_softpro_lookup_table u', 't.title_officer = u.id', 'left')
            ->join('pct_softpro_order_type ot', 't.order_type = ot.id', 'left')
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
        $data['branch_reports'] = $this->getSalesMappedReport();
        // print_r($data['branch_reports']);die;
        // $this->admintemplate->addCss(base_url('assets/frontend/css/sales-dashboard.css?v=' . $this->js_version));
        $this->admintemplate->addJS(base_url('assets/backend/js/dashboard.js?v=dashboard_1'));
        $this->admintemplate->show("order/reports", "mapped_report", $data);
    }

    public function getSalesMappedReport() {
        if ($this->input->is_ajax_request()) {
            $filterType = $this->input->post('report_type');
            $yearMonth = $this->input->post('month_year');
            list($year, $month) = explode('-', $yearMonth);
            $selectedDate = strtotime($yearMonth . "-01");
            $startMonth = date('Y-m-01', strtotime('-3 months', $selectedDate));
            $endDate = date('Y-m-t', $selectedDate);
            $today = 0;
            $monthName = date("F", strtotime($endDate));
            
            $priorMonth = date('m', strtotime('-1 months', $selectedDate));
            $priorYear  = date('Y', strtotime('-1 months', $selectedDate));
            // die;
            
        } else {
            $startMonth = date('Y-m-01', strtotime('-3 months'));  // June 1, 2025
            $endDate    = date('Y-m-d');                      // June 30, 2025
            $priorMonth = date('m', strtotime('-1 month'));
            $priorYear  = date('Y', strtotime('-1 month'));
            $today = 0;
            $month = date('m');
            $year = date('Y');
            $monthName = date("F");
        }
        
        // echo $startMonth . ' - ' . $endDate . ' -- Prior month --' . $priorMonth . ' - ' . $priorYear . '-- Current Month --' . $month . ' - ' . $year . ' -- Today --' . date('d') . '<br>';

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
        
        $records = $this->get_all_sp_order_data($startMonth, $endDate);
        // echo "<pre>";
        // print_r($records);
        // die;

        $branches = [];
        foreach ($records as $row) {
            $profile = $row['profile'];
            // if (empty($profile)) {
            //     continue;
            // }
            if (strpos($row['file_number'], 'GLT') !== false) {
                $branchName = 'Glendale';
            } elseif (strpos($row['file_number'], 'OCT') !== false) {
                $branchName = 'Orange';
            } else {
                continue;
                // $branchName = 'Unknown';
            }
            // $branchName = $branchMap[$profile] ?? 'Other';
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
                    'today_escrow_cnt' => 0,
                    'today_escrow_rev' => 0,
                    'mtd_escrow_cnt' => 0,
                    'mtd_escrow_rev' => 0,
                    'prior_escrow_cnt' => 0,
                    'prior_escrow_rev' => 0,
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
            //         if ($row['prod_type'] == 'Purchase') {
            //             $rep['mtd_purchase_cnt'] += 1;
            //             if ($rev_day == date('d')) {
            //                 $rep['today_purchase_cnt'] += 1;
            //             } 
            //         } elseif ($row['prod_type'] == 'Refinance') {
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
                    if ($row['prod_type'] == 'Purchase') {
                        $rep['mtd_purchase_rev'] += $row['premium'];
                        $rep['mtd_purchase_cnt'] += 1;
                        if ($rev_day == $today) {
                            $rep['today_purchase_rev'] += $row['premium'];
                            $rep['today_purchase_cnt'] += 1;
                        }
                    } elseif ($row['prod_type'] == 'Refinance') {
                        $rep['mtd_refi_rev'] += $row['premium'];
                        $rep['mtd_refi_cnt'] += 1;
                        
                        if ($rev_day == $today) {
                            $rep['today_refi_rev'] += $row['premium'];
                            $rep['today_refi_cnt'] += 1;
                        }
                    }
                } else if (strtolower($row['order_type']) == 'title & escrow') {
                    $rep['mtd_escrow_rev'] += $row['premium'];
                    $rep['mtd_escrow_cnt'] += 1;
                    if ($rev_day == $today) {
                        $rep['today_escrow_rev'] += $row['premium'];
                        $rep['today_escrow_cnt']++;
                    }
                }
            }

            if (!empty($row['sent_to_accounting_date']) && $rev_month == $priorMonth && $rev_year == $priorYear) {
                if (strtolower($row['order_type']) == 'title only') {
                    if ($row['prod_type'] == 'Purchase') {
                        $rep['prior_purchase_cnt']++;
                        $rep['prior_purchase_rev'] += $row['premium'];
                    } elseif ($row['prod_type'] == 'Refinance') {
                        $rep['prior_refi_cnt']++;
                        $rep['prior_refi_rev'] += $row['premium'];
                    }

                } else if (strtolower($row['order_type']) == 'title & escrow') {
                    $rep['prior_escrow_cnt']++;
                    $rep['prior_escrow_rev'] += $row['premium'];
                }
            }

            // if ($rev_month == $priorMonth && $rev_year == $priorYear) {
            //     if (strtolower($row['order_type']) == 'title only') {
            //         if ($row['prod_type'] == 'Purchase') {
            //             $rep['prior_purchase_rev'] += $row['premium'];
            //         } elseif ($row['prod_type'] == 'Refinance') {
            //             $rep['prior_refi_rev'] += $row['premium'];
            //         }
            //     } else if (strtolower($row['order_type']) == 'title & escrow') {

            //     }
            // }

            

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
        // die;
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
        if ($this->input->is_ajax_request()) {
            $dataRes['html'] = $this->load->view('order/reports/mapped_branch_report', ['branches' => $branches, 'monthName' => $monthName], true);
            $res = array('status' => 'success', 'report' => $dataRes);
            echo json_encode($res);exit;
        } else {
            return $this->load->view('order/reports/mapped_branch_report', ['branches' => $branches, 'monthName' => $monthName], true);
        }
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
        $data['branch_reports'] = $this->getMappedTitleOfficerReport();
        // $this->admintemplate->addCss(base_url('assets/frontend/css/sales-dashboard.css?v=' . $this->js_version));
        $this->admintemplate->addJS(base_url('assets/backend/js/dashboard.js?v=dashboard_1'));
        $this->admintemplate->show("order/reports", "mapped_to_report", $data);
    }

    public function getMappedTitleOfficerReport() {
        $data = [];
        if ($this->input->is_ajax_request()) {
            $filterType = $this->input->post('report_type');
            $yearMonth = $this->input->post('month_year');
            list($year, $month) = explode('-', $yearMonth);
            $selectedDate = strtotime($yearMonth . "-01");
            $startMonth = date('Y-m-01', strtotime('-3 months', $selectedDate));
            $endDate = date('Y-m-t', $selectedDate);
            $today = 0;
            $monthName = date("F", strtotime($endDate));
            
            $priorMonth = date('m', strtotime('-1 months', $selectedDate));
            $priorYear  = date('Y', strtotime('-1 months', $selectedDate));
            // echo $startMonth . ' - ' . $endDate . ' -- ' . $priorMonth . ' - ' . $priorYear ;
            // die;

        } else {
            $startMonth = date('Y-m-01', strtotime('-3 months'));  // June 1, 2025
            $endDate    = date('Y-m-d');                      // June 30, 2025
            $priorMonth = date('m', strtotime('-1 month'));
            $priorYear  = date('Y', strtotime('-1 month'));
            $today = date('d');
            $month = date('m');
            $year = date('Y');
            $monthName = date("F");
        }

        // $branchMap = [
        //     'Glendale Escrow'      => 'Glendale',
        //     'Glendale Title'       => 'Glendale',
        //     'Orange Escrow'        => 'Orange',
        //     'Orange Title'         => 'Orange',
        //     'Porterville Escrow'   => 'Porterville',
        //     'Production\Payoff'    => 'Production',
        //     'TSG'                  => 'TSG',
        //     'Inland Empire Escrow' => 'Inland Empire',
        // ];

        // $fromDate = date('Y-m-d', strtotime('-4 months')); // we need last 4 months data
        // $toDate   = date('Y-m-d');
        // $startMonth = date('Y-m-01', strtotime('-3 months'));  // June 1, 2025
        // $endDate    = date('Y-m-d');                      // June 30, 2025
        // $priorMonth = date('m', strtotime('-1 month'));
        // $priorYear  = date('Y', strtotime('-1 month'));
        // $ratioMonth = date('m', strtotime('-3 month'));
        // $ratioYear  = date('Y', strtotime('-3 month'));
        
        $records = $this->get_all_to_order_data($startMonth, $endDate);
        // echo "<pre>";
        // print_r($records);
        // die;

        $branches = [];
        foreach ($records as $row) {
            $profile = $row['profile'];
            if (empty($row['title_officer'])) {
                continue;
            }

            if (strpos($row['file_number'], 'GLT') !== false) {
                $branchName = 'Glendale';
            } elseif (strpos($row['file_number'], 'OCT') !== false) {
                $branchName = 'Orange';
            } else {
                continue;
                // $branchName = 'Unknown';
            }

            $repId = $row['title_officer'];

            if (!isset($branches[$branchName])) {
                $branches[$branchName] = ['title_officer' => []];
            }

            if (!isset($branches[$branchName]['title_officer'][$repId])) {
                $branches[$branchName]['title_officer'][$repId] = [
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
                    'created_4m' => 0,
                    'closed_4m' => 0,
                    'closing_ratio'  => 0,
                    'total_orders'=> 0,
                    'closed_orders'=>0,
                ];
            }

            $rep =&$branches[$branchName]['title_officer'][$repId];

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
            //     if ($row['prod_type'] == 'Purchase') {
            //         $rep['mtd_purchase_cnt'] += 1;
            //         if ($rev_day == date('d')) {
            //             $rep['today_purchase_cnt'] += 1;
            //         } 
            //     } elseif ($row['prod_type'] == 'Refinance') {
            //         $rep['mtd_refi_cnt']++;
            //         if ($rev_day == date('d')) {
            //             $rep['today_refi_cnt']++;
            //         }
            //     }
            // }

            // if ($rev_month == date('m') && $rev_year == date('Y')) {
            //     if ($row['prod_type'] == 'Purchase') {
            //         $rep['mtd_purchase_rev'] += $row['premium'];
            //         $rep['mtd_purchase_cnt'] += 1;
            //         if ($rev_day == date('d')) {
            //             $rep['today_purchase_rev'] += $row['premium'];
            //             $rep['today_purchase_cnt'] += 1;
            //         }
            //     } elseif ($row['prod_type'] == 'Refinance') {
            //         $rep['mtd_refi_rev'] += $row['premium'];
            //         $rep['mtd_refi_cnt'] += 1;
            //         if ($rev_day == date('d')) {
            //             $rep['today_refi_rev'] += $row['premium'];
            //             $rep['today_refi_cnt'] += 1;
            //         }
            //     }
            // }

            if (!empty($row['sent_to_accounting_date']) && $rev_month == $month && $rev_year == $year) {
                if (strtolower($row['order_type']) == 'title only') {
                    if ($row['prod_type'] == 'Purchase') {
                        $rep['mtd_purchase_rev'] += $row['premium'];
                        $rep['mtd_purchase_cnt'] += 1;
                        if ($rev_day == $today) {
                            $rep['today_purchase_rev'] += $row['premium'];
                            $rep['today_purchase_cnt'] += 1;
                        }
                    } elseif ($row['prod_type'] == 'Refinance') {
                        $rep['mtd_refi_rev'] += $row['premium'];
                        $rep['mtd_refi_cnt'] += 1;
                        if ($rev_day == $today) {
                            $rep['today_refi_rev'] += $row['premium'];
                            $rep['today_refi_cnt'] += 1;
                        }
                    }
                } else if (strtolower($row['order_type']) == 'title & escrow') {
                    $rep['mtd_escrow_rev'] += $row['premium'];
                    $rep['mtd_escrow_cnt'] += 1;
                    if ($rev_day == $today) {
                        $rep['today_escrow_rev'] += $row['premium'];
                        $rep['today_escrow_cnt']++;
                    }
                }
            }

            if (!empty($row['sent_to_accounting_date']) && $rev_month == $priorMonth && $rev_year == $priorYear) {
                if (strtolower($row['order_type']) == 'title only') {
                    if ($row['prod_type'] == 'Purchase') {
                        $rep['prior_purchase_cnt']++;
                        $rep['prior_purchase_rev'] += $row['premium'];
                    } elseif ($row['prod_type'] == 'Refinance') {
                        $rep['prior_refi_cnt']++;
                        $rep['prior_refi_rev'] += $row['premium'];
                    }
                } else if (strtolower($row['order_type']) == 'title & escrow') {
                    $rep['prior_escrow_cnt']++;
                    $rep['prior_escrow_rev'] += $row['premium'];
                }
            }

            // if ($rev_month == $priorMonth && $rev_year == $priorYear && !empty($row['sent_to_accounting_date'])) {
            //     if ($row['prod_type'] == 'Purchase') {
            //         $rep['prior_purchase_cnt']++;
            //     } elseif ($row['prod_type'] == 'Refinance') {
            //         $rep['prior_refi_cnt']++;
            //     }
            // }

            // if ($rev_month == $priorMonth && $rev_year == $priorYear) {
            //     if ($row['prod_type'] == 'Purchase') {
            //         $rep['prior_purchase_rev'] += $row['premium'];
            //     } elseif ($row['prod_type'] == 'Refinance') {
            //         $rep['prior_refi_rev'] += $row['premium'];
            //     }
            // }

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
        if ($this->input->is_ajax_request()) {
            $dataRes['html'] = $this->load->view('order/reports/mapped_to_branch_report', ['branches' => $branches, 'monthName' => $monthName], true);
            $res = array('status' => 'success', 'report' => $dataRes);
            echo json_encode($res);exit;
        } else {
            return $this->load->view('order/reports/mapped_to_branch_report', ['branches' => $branches, 'monthName' => $monthName], true);
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
            $selectedDate = strtotime($yearMonth . "-01");
            $startMonth = date('Y-m-01', strtotime('-1 months', $selectedDate));
            $endDate = date('Y-m-t', $selectedDate);
            $today = 0;
            $monthName = date("F", strtotime($endDate));
            
            $priorMonth = date('m', strtotime('-1 months', $selectedDate));
            $priorYear  = date('Y', strtotime('-1 months', $selectedDate));
            // echo $startMonth . ' - ' . $endDate . ' -- ' . '-- Month : ' . $month . '-- Year -- ' . $year . '-- Prior - ' . $priorMonth . ' - ' . $priorYear ;
            // die;

        } else {
            $startMonth = date('Y-m-01', strtotime('-1 months'));  // June 1, 2025
            $endDate    = date('Y-m-d');                      // June 30, 2025
            $priorMonth = date('m', strtotime('-1 month'));
            $priorYear  = date('Y', strtotime('-1 month'));
            $today = date('d');
            $month = date('m');
            $year = date('Y');
            $monthName = date("F");
        }
        // echo $startMonth . ' - ' . $endDate . ' -- ' . '-- Month : ' . $month . '-- Year -- ' . $year . '-- Prior - ' . $priorMonth . ' - ' . $priorYear ;
        // die;

        // $startMonth = date('Y-m-01', strtotime('-1 months'));  // June 1, 2025
        // $endDate    = date('Y-m-d');                      // June 30, 2025
        // $priorMonth = date('m', strtotime('-1 month'));
        // $priorYear  = date('Y', strtotime('-1 month'));
        
        $records = $this->get_all_order_data($startMonth, $endDate);
        // echo "<pre>";
        // print_r($records);
        // die;
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
            $profile = $row['profile'];
            // if (empty($profile) || empty($row['title_officer'])) {
            //     continue;
            // }
            if (strpos($row['file_number'], 'GLT') !== false) {
                $branchName = 'Glendale';
            } elseif (strpos($row['file_number'], 'OCT') !== false) {
                $branchName = 'Orange';
            } else {
                continue;
                // $branchName = 'Unknown';
            }
            $repId = $row['title_officer'];

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
                if (strtolower($row['order_type']) == 'title only') {
                    $mtdTotalOpen++;
                    if ($row['prod_type'] == 'Purchase') {
                        $rep['mtd_purchase_open_cnt'] += 1;
                        if ($created_day == $today) {
                            $rep['today_purchase_open_cnt']++;
                            $todayTotalOpen++;
                        }
                    } else if ($row['prod_type'] == 'Refinance') {
                        $rep['mtd_refi_open_cnt'] += 1;
                        if ($created_day == $today) {
                            $rep['today_refi_open_cnt']++;
                            $todayTotalOpen++;
                        }
                    }
                } else if (strtolower($row['order_type']) == 'title & escrow') {
                    $mtdTotalOpen++;
                    $rep['mtd_escrow_open_cnt']++;
                    if ($created_day == $today) {
                        $rep['today_escrow_open_cnt']++;
                        $todayTotalOpen++;
                    }
                }
            }

            /** current month and today's closed order count and revenue calculation */
            if ($rev_month == $month && $rev_year == $year) {
                if (strtolower($row['order_type']) == 'title only') {
                    $mtdTotalClose++;
                    $mtdTotalRev += $row['premium'];
                    if ($row['prod_type'] == 'Purchase') {
                        $rep['mtd_purchase_rev'] += $row['premium'];
                        $rep['mtd_purchase_close_cnt'] += 1;
                        if ($rev_day == $today) {
                            $rep['today_purchase_rev'] += $row['premium'];
                            $rep['today_purchase_close_cnt'] += 1;
                            $todayTotalClose++;
                            $todayTotalRev += $row['premium'];
                        }
                    } else if ($row['prod_type'] == 'Refinance') {
                        $rep['mtd_refi_rev'] += $row['premium'];
                        $rep['mtd_refi_close_cnt'] += 1;
                        if ($rev_day == $today) {
                            $rep['today_refi_rev'] += $row['premium'];
                            $rep['today_refi_close_cnt'] += 1;
                            $todayTotalClose++;
                            $todayTotalRev += $row['premium'];
                        }
                    }
                } else if (strtolower($row['order_type']) == 'title & escrow') {
                    $mtdTotalClose++;
                    $mtdTotalRev += $row['premium'];
                    $rep['mtd_escrow_rev'] += $row['premium'];
                    $rep['mtd_escrow_close_cnt'] += 1;
                    if ($rev_day == $today) {
                        $rep['today_escrow_rev'] += $row['premium'];
                        $rep['today_escrow_close_cnt']++;
                        $todayTotalClose++;
                        $todayTotalRev += $row['premium'];
                    }
                }
                
            }

            /** Prior month created order count */
            if ($created_month == $priorMonth && $created_year == $priorYear) {
                if (strtolower($row['order_type']) == 'title only') {
                    if ($row['prod_type'] == 'Purchase') {
                        $rep['prior_purchase_open_cnt'] += 1;
                        $priorTotalOpen++;
                    } else if ($row['prod_type'] == 'Refinance') {
                        $rep['prior_refi_open_cnt'] += 1;
                        $priorTotalOpen++;
                    }
                } else if (strtolower($row['order_type']) == 'title & escrow') {
                    $rep['prior_escrow_open_cnt']++;
                    $priorTotalOpen++;
                }
            }

            /** Prior month closed order count and revenue calculation */
            if ($rev_month == $priorMonth && $rev_year == $priorYear) {
                if (strtolower($row['order_type']) == 'title only') {
                    $priorTotalClose++;
                    $priorTotalRev += $row['premium'];
                    if ($row['prod_type'] == 'Purchase') {
                        $rep['prior_purchase_close_cnt']++;
                        $rep['prior_purchase_rev'] += $row['premium'];
                    } else if ($row['prod_type'] == 'Refinance') {
                        $rep['prior_refi_close_cnt']++;
                        $rep['prior_refi_rev'] += $row['premium'];
                    }
                } else if (strtolower($row['order_type']) == 'title & escrow') {
                    $priorTotalClose++;
                    $priorTotalRev += $row['premium'];
                    $rep['prior_escrow_close_cnt']++;
                    $rep['prior_escrow_rev'] += $row['premium'];
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
        ];
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
