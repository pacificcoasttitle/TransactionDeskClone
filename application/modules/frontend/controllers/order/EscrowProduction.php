<?php

(defined('BASEPATH')) or exit('No direct script access allowed');


use PhpOffice\PhpSpreadsheet\IOFactory;
class EscrowProduction extends MX_Controller
{
    private $js_version = '12.03.06';

    public function __construct()
    {
        parent::__construct();
        $this->load->helper(
            array('file', 'url', 'form')
        );
        $this->load->library('order/salesDashboardTemplate');
        $this->load->library('session');
        $this->load->library('form_validation');
        $this->load->library('order/order');
        $this->load->model('order/apiLogs');
        $this->load->model('order/reviewPrelimData');
        $this->load->model('order/home_model');
        $this->load->library('order/common');
        $this->load->model('order/salesRep_model');
        $this->common->is_escrow_production();
    }

    public function index()
    {
        date_default_timezone_set('America/Los_Angeles');
        $userdata = $this->session->userdata('user');
        $name = isset($userdata['name']) && !empty($userdata['name']) ? $userdata['name'] : '';
        $data['name'] = $name;
        $userId = $this->uri->segment(2);
        $data['user_id'] = $userId;
        $data['escrowOfficers'] = $this->order->get_escrow_officers();
        
        $dt = new DateTime('now', new DateTimeZone('America/Los_Angeles'));
        $currentMonth = $dt->format('m');
        $data['user_email'] = $userdata['email'];
        $data['order_lists'] = $this->order->get_recent_orders();
        $data['title'] = 'Smart Dashboard | Pacific Coast Title Company';
        $con = array('id' => $userdata['id']);
        $sales_rep_info = $this->order->getSalesRep($con);
        $data['sales_rep_info'] = $sales_rep_info;
        $workedDays = $this->order->countWorkedDaysOfMonth();
        $workingDaysRemaining = $this->order->countWokingsDaysLeftOfMonth();
        $request = [];
        if (!empty($userId)) {
            $request['userId'] = $userId;
        }
        $request['month'] = $currentMonth;
        $request['orderType'] = 'escrow';
        $request['transactionType'] = 'Refinance';
        $request['countType'] = 'open';
        $openRefiResult = $this->order->getOrdersCountForDashboard($request);
        
        // $openRefiResult = $this->order->getOpenOrdersCountForRefiProducts($currentMonth, 'all', 0, 0, 0, 0, 'escrow');
        $data['refi_open_count'] = !empty($openRefiResult['order_count']) ? $openRefiResult['order_count'] : 0;
        $request['transactionType'] = 'Purchase';
        $openSaleResult = $this->order->getOrdersCountForDashboard($request);
        // $openSaleResult = $this->order->getOpenOrdersCountForSaleProducts($currentMonth, 'all', 0, 0, 0, 0, 'escrow');
        $data['sale_open_count'] = !empty($openSaleResult['order_count']) ? $openSaleResult['order_count'] : 0;
        $data['total_open_count'] = $data['sale_open_count'] + $data['refi_open_count'];
        
        if ($data['total_open_count'] > 0) {
            $numOfOpenOrderPerWorkedDays = $data['total_open_count'] / $workedDays;
            $data['projected_open_count'] = (round($numOfOpenOrderPerWorkedDays * $workingDaysRemaining)) + $data['total_open_count'];
        } else {
            $numOfOpenOrderPerWorkedDays = 0;
            $data['projected_open_count'] = 0;
        }
        
        $request['transactionType'] = 'Refinance';
        $request['countType'] = 'closed';
        $closeRefiResult = $this->order->getOrdersCountForDashboard($request);
        // $closeRefiResult = $this->order->getClosedOrdersCountForRefiProducts($currentMonth, 'all');
        $data['refi_close_count'] = !empty($closeRefiResult['order_count']) ? $closeRefiResult['order_count'] : 0;
        $request['transactionType'] = 'Purchase';
        $closeSaleResult = $this->order->getOrdersCountForDashboard($request);
        // $closeSaleResult = $this->order->getClosedOrdersCountForSaleProducts($currentMonth, 'all');
        // echo "<pre>";
        // print_r($closeSaleResult);die;

        $data['sale_close_count'] = !empty($closeSaleResult['order_count']) ? $closeSaleResult['order_count'] : 0;
        $data['total_close_count'] = $data['refi_close_count'] + $data['sale_close_count'];

        if ($data['total_close_count'] > 0) {
            $numOfCloseOrderPerWorkedDays = $data['total_close_count'] / $workedDays;
            $data['projected_close_count'] = (round($numOfCloseOrderPerWorkedDays * $workingDaysRemaining)) + $data['total_close_count'];
        } else {
            $numOfCloseOrderPerWorkedDays = 0;
            $data['projected_close_count'] = 0;
        }

        $openOrderRefiTotalPremium = !empty($openRefiResult['total_premium_for_orders']) ? $openRefiResult['total_premium_for_orders'] : 0;
        $closeOrderRefiTotalPremium = !empty($closeRefiResult['total_premium_for_orders']) ? $closeRefiResult['total_premium_for_orders'] : 0;
        
        $data['refi_total_premium'] = round($closeOrderRefiTotalPremium);
        $openOrderSaleTotalPremium = !empty($openSaleResult['total_premium_for_orders']) ? $openSaleResult['total_premium_for_orders'] : 0;
        $closeOrderSaleTotalPremium = !empty($closeSaleResult['total_premium_for_orders']) ? $closeSaleResult['total_premium_for_orders'] : 0;
        
        $data['sale_total_premium'] = round($closeOrderSaleTotalPremium);
        $data['total_premium'] = $data['sale_total_premium'] + $data['refi_total_premium'];
        if ($data['total_premium'] > 0) {
            $premiumWorkedDays = $data['total_premium'] / $workedDays;
            $data['projected_revenue'] = (round($premiumWorkedDays * $workingDaysRemaining)) + $data['total_premium'];
        } else {
            $premiumWorkedDays = 0;
            $data['projected_revenue'] = 0;
        }
        $totalCount = $data['sale_close_count'] + $data['refi_close_count'] + $data['sale_open_count'] + $data['refi_open_count'];
        if ($totalCount > 0) {
        
            /** For last 4 months calculations */
            $request['dashboard_flag'] = 1;
            $request['transactionType'] = 'Refinance';
            // $clseRefiResult = $this->order->getClosedOrdersCountForRefiProducts($currentMonth, 'all', 0, 0, 1);
            $clseRefiResult = $this->order->getOrdersCountForDashboard($request);
            $refiClsCount = !empty($clseRefiResult['order_count']) ? $clseRefiResult['order_count'] : 0;
            
            $request['transactionType'] = 'Purchase';
            // $clsSaleResult = $this->order->getClosedOrdersCountForSaleProducts($currentMonth, 'all', 0, 0, 1);
            $clsSaleResult = $this->order->getOrdersCountForDashboard($request);
            $saleClsCount = !empty($clsSaleResult['order_count']) ? $clsSaleResult['order_count'] : 0;
            
            $request['transactionType'] = 'Refinance';
            $request['countType'] = 'open';
            // $opnRefiResult = $this->order->getOpenOrdersCountForRefiProducts($currentMonth, 'all', [], 0, 0, 1);
            $opnRefiResult = $this->order->getOrdersCountForDashboard($request);
            $refiOpnCount = !empty($opnRefiResult['order_count']) ? $opnRefiResult['order_count'] : 0;
            
            $request['transactionType'] = 'Purchase';
            // $opnSaleResult = $this->order->getOpenOrdersCountForSaleProducts($currentMonth, 'all', [], 0, 0, 1);
            $opnSaleResult = $this->order->getOrdersCountForDashboard($request);
            $saleOpnCount = !empty($opnSaleResult['order_count']) ? $opnSaleResult['order_count'] : 0;
            
            $data['refi_close_order_percetage'] = (!empty($refiClsCount)) ? round(($refiClsCount * 100) / $refiOpnCount) : 0;
            $data['sale_close_order_percetage'] = (!empty($saleClsCount)) ? (round(($saleClsCount * 100) / $saleOpnCount)) : 0;
            $totalOpen = (($saleOpnCount + $refiOpnCount) > 0) ? ($saleOpnCount + $refiOpnCount) : 1;
            $data['close_order_percetage'] = round((($saleClsCount + $refiClsCount) * 100) / ($totalOpen));
            /** End last 4 month calculations */

        } else {
            $data['refi_close_order_percetage'] = 0;
            $data['sale_close_order_percetage'] = 0;
            $data['close_order_percetage'] = 0;
        }
        $this->salesdashboardtemplate->addJS(base_url('assets/frontend/js/order/sales_dashboard.js?v=' . $this->js_version));
        $this->salesdashboardtemplate->addJS(base_url('assets/frontend/js/order/prelim.js?v=' . $this->js_version));
        $this->salesdashboardtemplate->addCss(base_url('assets/frontend/css/sales-dashboard.css?v=' . $this->js_version));

        $this->salesdashboardtemplate->show("order", "escrow_production_dashboard", $data);
    }

    public function get_escrow_orders()
    {
        $params = array();
        $data = array();
        $userdata = $this->session->userdata('user');
        $status = $this->input->post('status');
        $month = $this->input->post('month') ? $this->input->post('month') : '';
        $params['escrowOfficer'] = $this->input->post('escrow_officer') ? $this->input->post('escrow_officer') : '';
        // $order_type = $this->input->post('order_type');
        $order_status = $this->input->post('order_status');
        // $sales_rep_manager_flag = $this->input->post('sales_rep_manager_flag');
        // $params['salesUser'] = $salesUser;
        // $params['salesFlag'] = 1;
        //$params['status'] = isset($status) && !empty($status) ? $status : 'open';
        //$params['month'] = isset($month) && !empty($month) ? $month : date('m');
        // $params['order_type'] = isset($order_type) && !empty($order_type) ? $order_type : '';
        $params['status'] = isset($order_status) && !empty($order_status) ? $order_status : '';
        // $params['sales_rep_manager_flag'] = isset($sales_rep_manager_flag) && !empty($sales_rep_manager_flag) ? $sales_rep_manager_flag : false;

        if (isset($_POST['draw']) && !empty($_POST['draw'])) {
            $params['draw'] = isset($_POST['draw']) && !empty($_POST['draw']) ? $_POST['draw'] : 10;
            $params['length'] = isset($_POST['length']) && !empty($_POST['length']) ? $_POST['length'] : 2;
            $params['start'] = isset($_POST['start']) && !empty($_POST['start']) ? $_POST['start'] : 0;
            $params['orderColumn'] = isset($_POST['order'][0]['column']) && !empty($_POST['order'][0]['column']) ? $_POST['order'][0]['column'] : 0;
            $params['orderDir'] = isset($_POST['order'][0]['dir']) && !empty($_POST['order'][0]['dir']) ? $_POST['order'][0]['dir'] : 0;
            $params['searchvalue'] = isset($_POST['search']['value']) && !empty($_POST['search']['value']) ? $_POST['search']['value'] : '';
            $pageno = ($params['start'] / $params['length']) + 1;
            $order_lists = $this->order->get_escrow_orders($params);
            $json_data['draw'] = intval($params['draw']);
        } else {
            $params['searchvalue'] = isset($_POST['keyword']) && !empty($_POST['keyword']) ? $_POST['keyword'] : '';
            $order_lists = $this->order->get_escrow_orders($params);
        }
        // echo "<pre>";
        // print_r($order_lists['data']);die;
        if (isset($order_lists['data']) && !empty($order_lists['data'])) {
            $configData                  = $this->order->getConfigData();
            $prelimSummaryEmailFlag = $configData['enable_prelim_summary_email']['is_enable'];
            $prelimSummaryShutOffFlag = $configData['prelim_summary_shut_off']['is_enable'];
            $i = $params['start'] + 1;
            foreach ($order_lists['data'] as $order) {

                $nestedData = array();
                $nestedData[] = (empty($order['file_number']) ? $order['lp_file_number'] : ((empty($order['lp_file_number'])) ? $order['file_number'] : $order['file_number'] . '&nbsp; <i class="fa fa-info-circle" aria-hidden="true"></i> <span class="tooltiptext">It\'s LP order ' . $order['lp_file_number'] . ' and it\'s converted into normal order </span>'));
                
                $nestedData[] = date("m/d/Y", strtotime($order['created_at']));
                $nestedData[] = $order['full_address'];
                if ($order['file_number'] == 0 && !empty($order['lp_file_number'])) {
                    $nestedData[] = ucfirst($order['lp_report_status']);
                } else {
                    $nestedData[] = ucfirst($order['softpro_status']);
                }

                $action = "<div style='display: flex;justify-content: space-evenly;'>";
                $fileNumber = !empty($order['file_number']) ? $order['file_number'] : '';
                if ($order['prelim_summary_id'] != 0) {
                    $prelimDoc = $this->order->get_prelim_document($order['id']);
                    if (env('AWS_ENABLE_FLAG') == 1 && !empty($prelimDoc['document_name'])) {
                        $prelimUrl = env('AWS_PATH') . "documents/" . $prelimDoc['document_name'];
                    } 
                    // else {
                    //     $prelimUrl = base_url() . 'uploads/documents/' . $prelimDoc['document_name'];
                    // }
                    $class = isset($order['is_visited']) && !empty($order['is_visited']) ? 'secondary' : 'success';
                    $class = isset($order['is_doc_updated']) && !empty($order['is_doc_updated']) ? 'updated-prelim-btn' : 'btn-success';
                    if (!empty($prelimDoc['document_name'])) {
                        $action .= "<a href='" . $prelimUrl . "' target='_blank'>
                                <button type='submit' class='btn $class btn-icon-split'>
                                    <span class='icon text-white-50'>
                                        <i class='fas fa-file'></i>
                                    </span>
                                    <span class='text'>Review Prelim</span>
                                </button>
                            </a>";
                    }
                    if ($prelimSummaryShutOffFlag == 0) {
                        $action .= "<a href='javascript:void(0)' onclick=getPrelimSummary('".$order['file_number']."');>
                                <button type='submit' class='btn prelim-summary-btn btn-icon-split'>
                                    <span class='icon text-white-50'>
                                        <i class='fas fa-file-alt'></i>
                                    </span>
                                    <span class='text'>Prelim Summary</span>
                                </button>
                            </a>";
                    }
                    $action .= "<div class='dropdown'>
                        <a class='btn dropdown-toggle click-action-type type='button' data-toggle='dropdown' href='#'>
                            <button type='submit' class='btn btn-light btn-icon-split action-prelim-btn'>
                                <span class='icon text-white-50'>
                                    <i class='fas fa-tasks'></i>
                                </span>
                                <span class='text'>Click Action Type</span>
                                <span class='caret'></span>
                            </button>
                        </a>
                        <ul class='dropdown-menu' style='width:210px !important;max-width:none !important;'>";
                    if (empty($prelimDoc['document_name'])) {
                        $action .= "<li>
                                    <a href='javascript:void(0)' onclick=fetchPrelimDocument('".$order['file_number']."');>
                                        <button type='button' class='btn btn-grad-2a button-color'>
                                            <i class='fas fa-refresh' style='margin-right:5px;'></i>
                                            <span class='text'>Get Prelim Doc</span>
                                        </button>
                                    </a>
                                </li>";
                    }
                    $action .= "<li>
                                <a href='javascript:void(0)' onclick=updatePrelimAction('".$order['id']."');>
                                    <button type='button' class='btn btn-grad-2a button-color'>
                                        <i class='fas fa-refresh' style='margin-right:5px;'></i>
                                        <span class='text'>Update Prelim</span>
                                    </button>
                                </a>
                            </li>
                            <li>
                                <a href='javascript:void(0)' onclick=getContacts('".$order['file_number']."');>
                                    <button class='btn btn-grad-2a button-color' type='button'>
                                        <i class='fas fa-eye' aria-hidden='true' style='margin-right:5px;'></i>
                                        View Contacts
                                    </button>
                                </a>
                            </li>
                            <li>
                                <a href='javascript:void(0)' onclick=getInvoice('".$order['id']."');>
                                    <button class='btn btn-grad-2a button-color' type='button'>
                                        <i class='fas fa-file' aria-hidden='true' style='margin-right:5px;'></i>
                                        View Invoice
                                    </button>
                                </a>
                            </li>
                            <li>
                                <a href='javascript:void(0)' onclick=regeneratePrelimSummary('".$order['file_number']."');>
                                    <button class='btn btn-grad-2a button-color' type='button'>
                                        <i class='fa fa-refresh' aria-hidden='true' style='margin-right:5px;'></i>
                                        Regenerate Summary
                                    </button>
                                </a>
                            </li>
                        </ul></div>
                        ";
                } else {
                    $action .= "<a href='javascript:void(0)'>
						<button type='submit' class='btn btn-info btn-icon-split info-prelim-btn'>
							<span class='icon text-white-50'>
								<i class='fas fa-tasks'></i>
							</span>
							<span class='text'>Not Ready</span>
						</button></a>
                        <div class='dropdown'>
                        <a class='btn dropdown-toggle click-action-type' type='button' data-toggle='dropdown' href='#'>
                            <button type='submit' class='btn btn-light btn-icon-split action-prelim-btn'>
                                <span class='icon text-white-50'>
                                    <i class='fas fa-tasks'></i>
                                </span>
                                <span class='text'>Click Action Type</span>
                                <span class='caret'></span>
                            </button>
                        </a>
                        <ul class='dropdown-menu' style='width:210px !important;max-width:none !important;'>
                            <li>
                                <a href='javascript:void(0)' onclick=fetchPrelimDocument('".$order['file_number']."');>
                                    <button type='button' class='btn btn-grad-2a button-color'>
                                        <i class='fas fa-refresh' style='margin-right:5px;'></i>
                                        <span class='text'>Get Prelim Doc</span>
                                    </button>
                                </a>
                            </li>
                            <li>
                                <a href='#' onclick=getContacts('".$order['file_number']."');>
                                    <button class='btn btn-grad-2a button-color' type='button'>
                                        <i class='fas fa-eye' aria-hidden='true' style='margin-right:5px;'></i>
                                        View Contacts
                                    </button>
                                </a>
                            </li>
                            <li>
                                <a href='#' onclick=getInvoice('".$order['id']."');>
                                    <button class='btn btn-grad-2a button-color' type='button'>
                                        <i class='fas fa-file' aria-hidden='true' style='margin-right:5px;'></i>
                                        View Invoice
                                    </button>
                                </a>
                            </li>
                        </ul></div>
                    
                    ";
                }

                $action .= "</div>";


                $nestedData[] = $action;
                $now = time();
                $your_date = strtotime($order['created_at']);
                $new_date = date('Y-m-d', $your_date);
                $nowDate = date('Y-m-d');
                $datetime1 = new DateTime($new_date);
                $datetime2 = new DateTime($nowDate);

                $datediff = $datetime1->diff($datetime2)->format("%a");

                $data[] = $nestedData;
                $i++;
            }
        }
        $json_data['recordsTotal'] = intval($order_lists['recordsTotal']);
        $json_data['recordsFiltered'] = intval($order_lists['recordsFiltered']);
        $json_data['data'] = $data;
        // echo "<pre>";
        // print_r($json_data);die;
        echo json_encode($json_data);
    }

    public function escrowProductionHistory()
    {
        $userdata = $this->session->userdata('user');
        
        $data['title'] = 'Sales Production History | Pacific Coast Title Company';
        $salesHistory = array();
        $request = [];
        $request['orderType'] = 'escrow';
        for ($iM = 1; $iM <= (int) date('m'); $iM++) {
            $month = date("m", strtotime("$iM/12/10"));
            $dateObj = DateTime::createFromFormat('!m', $iM);
            $monthName = $dateObj->format('F');
            $salesHistory[$iM - 1]['month'] = $monthName;
            $salesHistory[$iM - 1]['month_val'] = $month;
            
            $request['transactionType'] = 'Refinance';
            $request['countType'] = 'open';
            $request['month'] = $month;
            // $openRefiResult = $this->order->getOpenOrdersCountForRefiProducts($month, $userId);
            $openRefiResult = $this->order->getOrdersCountForDashboard($request);
            $refi_open_count = !empty($openRefiResult['order_count']) ? $openRefiResult['order_count'] : 0;
            $request['transactionType'] = 'Purchase';
            // $openSaleResult = $this->order->getOpenOrdersCountForSaleProducts($month, $userId);
            $openSaleResult = $this->order->getOrdersCountForDashboard($request);
            $sale_open_count = !empty($openSaleResult['order_count']) ? $openSaleResult['order_count'] : 0;
            $salesHistory[$iM - 1]['total_open_count'] = $sale_open_count + $refi_open_count;

            $request['transactionType'] = 'Refinance';
            $request['countType'] = 'closed';
            // $closeRefiResult = $this->order->getClosedOrdersCountForRefiProducts($month, $userId);
            $closeRefiResult = $this->order->getOrdersCountForDashboard($request);
            $refi_close_count = !empty($closeRefiResult['order_count']) ? $closeRefiResult['order_count'] : 0;
            $request['transactionType'] = 'Purchase';
            // $closeSaleResult = $this->order->getClosedOrdersCountForSaleProducts($month, $userId);
            $closeSaleResult = $this->order->getOrdersCountForDashboard($request);
            $sale_close_count = !empty($closeSaleResult['order_count']) ? $closeSaleResult['order_count'] : 0;
            $salesHistory[$iM - 1]['total_close_count'] = $refi_close_count + $sale_close_count;

            $openOrderRefiTotalPremium = !empty($openRefiResult['total_premium_for_orders']) ? $openRefiResult['total_premium_for_orders'] : 0;
            $closeOrderRefiTotalPremium = !empty($closeRefiResult['total_premium_for_orders']) ? $closeRefiResult['total_premium_for_refi_close_orders'] : 0;
            //$refi_total_premium = $openOrderRefiTotalPremium + $closeOrderRefiTotalPremium;
            $refi_total_premium = $closeOrderRefiTotalPremium;
            $openOrderSaleTotalPremium = !empty($openSaleResult['total_premium_for_orders']) ? $openSaleResult['total_premium_for_orders'] : 0;
            $closeOrderSaleTotalPremium = !empty($closeSaleResult['total_premium_for_orders']) ? $closeSaleResult['total_premium_for_orders'] : 0;
            //$sale_total_premium = $openOrderSaleTotalPremium + $closeOrderSaleTotalPremium;
            $sale_total_premium = $closeOrderSaleTotalPremium;
            $salesHistory[$iM - 1]['total_premium'] = $sale_total_premium + $refi_total_premium;

            $totalCount = $sale_close_count + $refi_close_count + $sale_open_count + $refi_open_count;
            if ($totalCount > 0) {
                $refi_close_order_percetage = round(($refi_close_count * 100) / $totalCount);
                $sale_close_order_percetage = round(($sale_close_count * 100) / $totalCount);
                $salesHistory[$iM - 1]['close_order_percetage'] = $refi_close_order_percetage + $sale_close_order_percetage;
            } else {
                $refi_close_order_percetage = 0;
                $sale_close_order_percetage = 0;
                $salesHistory[$iM - 1]['close_order_percetage'] = 0;
            }
            if ($month == date('m')) {
                if ($month == '01') {
                    $previousCount = $this->order->getEscrowOrderCountBasedOnCurrentDayForPreviousMonthForPreviousYear();
                } else {
                    $previousCount = $this->order->getEscrowOrderCountBasedOnCurrentDayForPreviousMonth();
                }
                $salesHistory[$iM - 1]['trending'] = $previousCount['total_count'] >= $salesHistory[$iM - 1]['total_open_count'] ? '<span style="color: red;font-weight:bold;"><i class="fa fa-arrow-down"></i></span>' : '<span style="color: limegreen;font-weight:bold;"><i class="fa fa-arrow-up"></i></span>';
            } else {
                if ($month == '01') {
                    $previousCount = $this->order->getOpenEscrowOrdersCountForLastMonthOfPreviousYear();
                    $previousCount = $previousCount['total_count'];
                } else {
                    $previousCount = $salesHistory[$iM - 2]['total_open_count'];
                }
                $salesHistory[$iM - 1]['trending'] = $previousCount >= $salesHistory[$iM - 1]['total_open_count'] ? '<span style="color: red;font-weight:bold;"><i class="fa fa-arrow-down"></i></span>' : '<span style="color: limegreen;font-weight:bold;"><i class="fa fa-arrow-up"></i></span>';
            }

        }
        $data['salesHistory'] = $salesHistory;
        $this->salesdashboardtemplate->addJS(base_url('assets/frontend/js/order/sales_dashboard.js?v=' . $this->js_version));
        $this->salesdashboardtemplate->addJS(base_url('assets/frontend/js/order/prelim.js?v=' . $this->js_version));
        $this->salesdashboardtemplate->addCss(base_url('assets/frontend/css/sales-production-history.css?v=' . $this->js_version));
        //$this->template->show("order", "sales_production_history", $data);
        $this->salesdashboardtemplate->show("order", "escrow_production_history", $data);
    }

    public function salesReports()
    {
        $this->load->model('salesReport_model');
        $userdata = $this->session->userdata('user');
        $userId = $this->uri->segment(2);

        $data['title'] = 'Sales Reports | Pacific Coast Title Company';
        if ($userdata['is_sales_rep'] == 1) {

            $data['sales_user_id'] = $userId;
            // $data['is_sales_rep'] = $userdata['is_sales_rep'];

            $report_condition = array(
                'sales_rep' => $userId,
            );

            $data['reports_data'] = $this->salesReport_model->getSalesAllReportData($report_condition);

            $this->salesdashboardtemplate->addJS(base_url('assets/frontend/js/report.js?v=' . $this->js_version));
            $this->salesdashboardtemplate->show("order", "sales_report", $data);
        } else {
            redirect(base_url() . 'sales-dashboard/' . $userId);
        }
    }

    public function getEscrowRevenueData()
    {
        date_default_timezone_set('America/Los_Angeles');
        $user_id = $this->input->post('user_id');
        $revenueData = $this->order->getEscrowRevenueData($this->input->post('month') ? $this->input->post('month') : date('m'), $user_id);
        $data = "<table class='table table-bordered' id='tbl-lp-orders-listing' width='100%' cellspacing='0'>
            <thead>
                <tr>
                    <th>Sr No</th>
                    <th>File Number</th>
                    <th>Address</th>
                    <th>Prod Type</th>
                    <th>Revenue</th>
                </tr>
            </thead>
        <tbody>";

        $i = 1;
        if (!empty($revenueData)) {
            foreach ($revenueData as $revenue) {
                $file_number = $revenue['file_number'];
                $full_address = $revenue['full_address'];
                $prod_type = $revenue['prod_type'];
                $revenue = '$' . number_format($revenue['premium']);
                $data .= "<tr>
                                <td width='12%'>$i</td>
                                <td width='12%'>$file_number</td>
                                <td width='52%'>$full_address</td>
                                <td width='12%'>$prod_type</td>
                                <td width='12%'>$revenue</td>
                            </tr>";
                $i++;
            }
        } else {
            $data .= "<tr class='norecord'><td colspan='5'>No records found.</td></tr>";
        }
        $data .= '</tbody></table>';
        if (!empty($data)) {
            $result = array('status' => 'success', 'data' => $data);
        } else {
            $result = array('status' => 'error', 'data' => $data);
        }
        echo json_encode($result);
        exit;
    }
    
}
