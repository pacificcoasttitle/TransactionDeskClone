<?php

(defined('BASEPATH')) OR exit('No direct script access allowed');

class SalesRep extends MX_Controller 
{
	function __construct() 
    {
        parent::__construct();
		$this->load->helper(
            array('file', 'url','form')
        );
        $this->load->library('session');
		$this->load->library('form_validation');
		$this->load->model('order/orderRecording');
		$this->load->library('order/order');
        $this->load->model('order/apiLogs');
        $this->load->model('order/reviewPrelimData');
		$this->load->model('order/titleOfficer');
		$this->load->model('order/home_model');
		$this->load->model('order/fees_model');
		$this->load->library('order/resware');
		$this->load->library('order/common');
		$this->common->is_sales_user();
	}
	
	function index()
	{
		$userdata = $this->session->userdata('user');
		$name = isset($userdata['name']) && !empty($userdata['name']) ? $userdata['name'] : '';
		$data['name'] = $name;
		$data['is_sales_rep_manager'] = $userdata['is_sales_rep_manager'];
        $userId = $this->uri->segment(2);
        $data['user_id'] =  $userId;
		if ($userdata['is_sales_rep_manager'] == 1) {
			$data['salesUsers'] = $this->order->get_sales_users();
		} else {
            if ($userId != $userdata['id']) {
                redirect(base_url().'sales-dashboard/'.$userdata['id']);
            }
			$data['salesUsers'] = array();
		}
		$data['user_email'] = $userdata['email'];
		$data['order_lists'] = $this->order->get_recent_orders();
		$data['title'] = 'Smart Dashboard | Pacific Coast Title Company';
        $con = array('id' => $userdata['id']);
        $sales_rep_info = $this->order->getSalesRep($con);
        $data['sales_rep_info'] = $sales_rep_info;
        $workedDays = $this->order->countWorkedDaysOfMonth();
        $workingDaysRemaining = $this->order->countWokingsDaysLeftOfMonth();
        $openRefiResult = $this->order->getOpenOrdersCountForRefiProducts(date('m'), $userId);
        $data['refi_open_count'] = !empty($openRefiResult['refi_count']) ? $openRefiResult['refi_count'] : 0;
        $openSaleResult = $this->order->getOpenOrdersCountForSaleProducts(date('m'), $userId);
        $data['sale_open_count'] = !empty($openSaleResult['sale_count']) ? $openSaleResult['sale_count'] : 0;
        $data['total_open_count'] = $data['sale_open_count'] + $data['refi_open_count'];

        if ($data['total_open_count'] > 0) {
            $numOfOpenOrderPerWorkedDays = $data['total_open_count']/$workedDays;
            $data['projected_open_count'] = (round($numOfOpenOrderPerWorkedDays*$workingDaysRemaining))+ $data['total_open_count'];
        } else {
            $numOfOpenOrderPerWorkedDays = 0;
            $data['projected_open_count'] = 0;
        }
        
        $closeRefiResult = $this->order->getClosedOrdersCountForRefiProducts(date('m'), $userId);
        $data['refi_close_count'] = !empty($closeRefiResult['refi_count']) ? $closeRefiResult['refi_count'] : 0;
        $closeSaleResult = $this->order->getClosedOrdersCountForSaleProducts(date('m'), $userId);
        $data['sale_close_count'] =  !empty($closeSaleResult['sale_count']) ? $closeSaleResult['sale_count'] : 0;
        $data['total_close_count'] = $data['refi_close_count'] + $data['sale_close_count'];

        if ($data['total_close_count'] > 0) {
            $numOfCloseOrderPerWorkedDays = $data['total_close_count']/$workedDays;
            $data['projected_close_count'] = (round($numOfCloseOrderPerWorkedDays*$workingDaysRemaining))+ $data['total_close_count'];
        } else {
            $numOfCloseOrderPerWorkedDays = 0;
            $data['projected_close_count'] = 0;
        }

        $openOrderRefiTotalPremium =  !empty($openRefiResult['total_premium_for_refi_open_orders']) ? $openRefiResult['total_premium_for_refi_open_orders'] : 0;
        $closeOrderRefiTotalPremium =  !empty($closeRefiResult['total_premium_for_refi_close_orders']) ? $closeRefiResult['total_premium_for_refi_close_orders'] : 0;
        //$data['refi_total_premium'] = $openOrderRefiTotalPremium + $closeOrderRefiTotalPremium;
		$data['refi_total_premium'] = $closeOrderRefiTotalPremium;
        $openOrderSaleTotalPremium =  !empty($openSaleResult['total_premium_for_sale_open_orders']) ? $openSaleResult['total_premium_for_sale_open_orders'] : 0;
        $closeOrderSaleTotalPremium =  !empty($closeSaleResult['total_premium_for_sale_close_orders']) ? $closeSaleResult['total_premium_for_sale_close_orders'] : 0;
        //$data['sale_total_premium'] = $openOrderSaleTotalPremium + $closeOrderSaleTotalPremium;
		$data['sale_total_premium'] = $closeOrderSaleTotalPremium;
        $data['total_premium'] = $data['sale_total_premium'] + $data['refi_total_premium'];
        if ($data['total_premium'] > 0) {
            $premiumWorkedDays = $data['total_premium']/$workedDays;
            $data['projected_revenue'] = (round($premiumWorkedDays*$workingDaysRemaining))+ $data['total_premium'];
        } else {
            $premiumWorkedDays = 0;
            $data['projected_revenue'] = 0;
        }
        $totalCount = $data['sale_close_count'] + $data['refi_close_count'] + $data['sale_open_count'] + $data['refi_open_count'];
        if($totalCount > 0) { 
            $data['refi_close_order_percetage'] = round(($data['refi_close_count']*100)/$totalCount);
            $data['sale_close_order_percetage'] = round(($data['sale_close_count']*100)/$totalCount);
            $data['close_order_percetage'] = $data['refi_close_order_percetage'] + $data['sale_close_order_percetage'];
        } else {
            $data['refi_close_order_percetage'] = 0;
            $data['sale_close_order_percetage'] = 0;
            $data['close_order_percetage'] = 0;
        }
        $this->load->view('layout/head_dashboard',$data);
        $this->load->view('order/sales_dashboard');
	}

	function get_sales_orders()
    {
        $params = array();  $data = array();
		$userdata = $this->session->userdata('user');
        $status = $this->input->post('status');
		$month = $this->input->post('month') ? $this->input->post('month') :  '';
		$salesUser = $this->input->post('sales_user') ? $this->input->post('sales_user') :  '';
		$params['salesUser'] = $salesUser;
        $params['salesFlag'] = 1;
       // $params['status'] = isset($status) && !empty($status) ? $status : 'open';
		//$params['month'] = isset($month) && !empty($month) ? $month : date('m');
		
        if (isset($_POST['draw']) && !empty($_POST['draw'])) {
            $params['draw'] = isset($_POST['draw']) && !empty($_POST['draw']) ? $_POST['draw'] : 10;
            $params['length'] = isset($_POST['length']) && !empty($_POST['length']) ? $_POST['length'] : 2;
            $params['start'] = isset($_POST['start']) && !empty($_POST['start']) ? $_POST['start'] : 0;
            $params['orderColumn'] = isset($_POST['order'][0]['column']) && !empty($_POST['order'][0]['column']) ? $_POST['order'][0]['column'] : 0;
            $params['orderDir'] = isset($_POST['order'][0]['dir']) && !empty($_POST['order'][0]['dir']) ? $_POST['order'][0]['dir'] : 0;
            $params['searchvalue'] = isset($_POST['search']['value']) && !empty($_POST['search']['value']) ? $_POST['search']['value'] : '';
            $pageno = ($params['start'] / $params['length'])+1;
            $order_lists = $this->order->get_orders($params);
            $json_data['draw'] = intval( $params['draw'] );
        } else {
            $params['searchvalue'] = isset($_POST['keyword']) && !empty($_POST['keyword']) ? $_POST['keyword'] : '';
            $order_lists = $this->order->get_orders($params);
        }

        if (isset($order_lists['data']) && !empty($order_lists['data'])) {
            $i = $params['start'] + 1;
            foreach ($order_lists['data'] as $order)  {

                $nestedData = array();
                $nestedData[] = $order['file_number'];
				if ($userdata['is_sales_rep_manager'] == 1) {
					$nestedData[] = $order['sales_first_name']." ".$order['sales_last_name'];
				}
                $nestedData[] = date("m/d/Y", strtotime($order['created_at']));
                $nestedData[] = $order['full_address'];
                $nestedData[] = ucfirst($order['resware_status']);
               
                if ($order['prelim_summary_id'] != 0) {
					$action = "<a href='".base_url()."review-file/".$order['file_id']."'><button class='btn btn-grad-2a button-color' type='button'>REVIEW FILE</button></a>";
				} else {
					$action = "<a href='javascript:void(0);'><button class='btn btn-grad-2a' style='background: #d35411;' type='button'>Not Ready</button></a>";
				}
				$action .= "<a href='javascript:void(0);'><button class='btn btn-grad-2a button-color' type='button' onclick='getPartners(".$order['file_id'].");'>VIEW Partners</button></a>";
               	$nestedData[] = $action;

                $data[] = $nestedData; 
                $i++; 
            }	
        } 
        $json_data['recordsTotal'] = intval( $order_lists['recordsTotal'] );
        $json_data['recordsFiltered'] = intval( $order_lists['recordsFiltered'] );
        $json_data['data'] = $data;
        echo json_encode($json_data);
    }

	function salesProductionHistory()
	{
		$userdata = $this->session->userdata('user');
		$userId = $this->uri->segment(2);
		$data['sales_user_id']  = $userId;
		$data['is_sales_rep_manager'] = $userdata['is_sales_rep_manager'];
		if ($userdata['is_sales_rep_manager'] == 1) {
			$data['salesUsers'] = $this->order->get_sales_users();
		} else {
            if ($userId != $userdata['id']) {
                redirect(base_url().'sales-production-history/'.$userdata['id']);
            }
			$data['salesUsers'] = array();
		}
		$data['title'] = 'Sales Production History | Pacific Coast Title Company';
		$salesHistory = array();
		for ($iM = 1; $iM <= (int)date('m'); $iM++) {
			$month = date("m", strtotime("$iM/12/10"));
			$dateObj   = DateTime::createFromFormat('!m', $iM);
			$monthName = $dateObj->format('F'); 
			$salesHistory[$iM-1]['month'] = $monthName;

			$openRefiResult = $this->order->getOpenOrdersCountForRefiProducts($month, $userId);
			$refi_open_count = !empty($openRefiResult['refi_count']) ? $openRefiResult['refi_count'] : 0;
			$openSaleResult = $this->order->getOpenOrdersCountForSaleProducts($month, $userId);
			$sale_open_count = !empty($openSaleResult['sale_count']) ? $openSaleResult['sale_count'] : 0;
			$salesHistory[$iM-1]['total_open_count'] = $sale_open_count + $refi_open_count;

			$closeRefiResult = $this->order->getClosedOrdersCountForRefiProducts($month, $userId);
			$refi_close_count = !empty($closeRefiResult['refi_count']) ? $closeRefiResult['refi_count'] : 0;
			$closeSaleResult = $this->order->getClosedOrdersCountForSaleProducts($month, $userId);
			$sale_close_count =  !empty($closeSaleResult['sale_count']) ? $closeSaleResult['sale_count'] : 0;
			$salesHistory[$iM-1]['total_close_count'] = $refi_close_count + $sale_close_count;

			$openOrderRefiTotalPremium =  !empty($openRefiResult['total_premium_for_refi_open_orders']) ? $openRefiResult['total_premium_for_refi_open_orders'] : 0;
			$closeOrderRefiTotalPremium =  !empty($closeRefiResult['total_premium_for_refi_close_orders']) ? $closeRefiResult['total_premium_for_refi_close_orders'] : 0;
			//$refi_total_premium = $openOrderRefiTotalPremium + $closeOrderRefiTotalPremium;
			$refi_total_premium =  $closeOrderRefiTotalPremium;
			$openOrderSaleTotalPremium =  !empty($openSaleResult['total_premium_for_sale_open_orders']) ? $openSaleResult['total_premium_for_sale_open_orders'] : 0;
			$closeOrderSaleTotalPremium =  !empty($closeSaleResult['total_premium_for_sale_close_orders']) ? $closeSaleResult['total_premium_for_sale_close_orders'] : 0;
			//$sale_total_premium = $openOrderSaleTotalPremium + $closeOrderSaleTotalPremium;
			$sale_total_premium = $closeOrderSaleTotalPremium;
			$salesHistory[$iM-1]['total_premium'] = $sale_total_premium + $refi_total_premium;

			$totalCount = $sale_close_count + $refi_close_count + $sale_open_count + $refi_open_count;
			if($totalCount > 0) { 
				$refi_close_order_percetage = round(($refi_close_count*100)/$totalCount);
				$sale_close_order_percetage = round(($sale_close_count*100)/$totalCount);
				$salesHistory[$iM-1]['close_order_percetage'] = $refi_close_order_percetage + $sale_close_order_percetage;
			} else {
				$refi_close_order_percetage = 0;
				$sale_close_order_percetage = 0;
				$salesHistory[$iM-1]['close_order_percetage'] = 0;
			}
            if ($month == date('m')) {
                if ($month == '01') {
                    $previousCount = $this->order->getCountBasedOnCurrentDayForPreviousMonthForPreviousYear($userId);
                } else {
                    $previousCount = $this->order->getCountBasedOnCurrentDayForPreviousMonth($userId);
                }
                $salesHistory[$iM-1]['trending'] = $previousCount['total_count'] > $salesHistory[$iM-1]['total_open_count'] ? '<span style="color: red;font-weight:bold;">Negatively</span>' : '<span style="color: limegreen;font-weight:bold;">Positively</span>';
            } else {
                if ($month == '01') {
                    $previousCount = $this->order->getOpenOrdersCountForLastMonthOfPreviousYear($userId);
                    $previousCount = $previousCount['total_count'];
                } else {
                    $previousCount = $salesHistory[$iM-2]['total_open_count'];
                }
                $salesHistory[$iM-1]['trending'] = $previousCount > $salesHistory[$iM-1]['total_open_count'] ? '<span style="color: red;font-weight:bold;">Negatively</span>' : '<span style="color: limegreen;font-weight:bold;">Positively</span>';
            }

		}
		$data['salesHistory'] = $salesHistory;
		$this->load->view('layout/head_dashboard',$data);
		$this->load->view('order/sales_production_history', $data);
	}
}