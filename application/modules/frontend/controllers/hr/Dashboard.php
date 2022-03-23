<?php

(defined('BASEPATH')) OR exit('No direct script access allowed');

class Dashboard extends MX_Controller 
{
	function __construct() 
    {
        parent::__construct();
		$this->load->helper(
            array('file', 'url','form')
        );
        $this->load->library('session');
		$this->load->library('form_validation');
		$this->load->library('hr/template');
        $this->load->library('hr/common');
		$this->load->library('order/order');
		$this->load->model('hr/hr'); 
        $this->common->is_user();
	}
	
	function index()
	{
		$userdata = $this->session->userdata('hr_user');
		if ($userdata['user_type_id'] == 2) {
			$usersForBranchManager = $this->common->getUsersForBranchManager($userdata['id']);
			if(!empty($usersForBranchManager)) {
				$usersEmails = array_column($usersForBranchManager, 'email');	
				$pctOrderUserInfo = $this->order->getUsersInfo($usersEmails);

				if (!empty($pctOrderUserInfo)) {
					$usersIds = array_column($pctOrderUserInfo, 'id');	
					$workedDays = $this->order->countWorkedDaysOfMonth();
					$workingDaysRemaining = $this->order->countWokingsDaysLeftOfMonth();
					$openRefiResult = $this->order->getOpenOrdersCountForRefiProducts(date('m'), $usersIds);
					$data['refi_open_count'] = !empty($openRefiResult['refi_count']) ? $openRefiResult['refi_count'] : 0;
					$openSaleResult = $this->order->getOpenOrdersCountForSaleProducts(date('m'), $usersIds);
					$data['sale_open_count'] = !empty($openSaleResult['sale_count']) ? $openSaleResult['sale_count'] : 0;
					$data['total_open_count'] = $data['sale_open_count'] + $data['refi_open_count'];

					if ($data['total_open_count'] > 0) {
						$numOfOpenOrderPerWorkedDays = $data['total_open_count']/$workedDays;
						$data['projected_open_count'] = (round($numOfOpenOrderPerWorkedDays*$workingDaysRemaining))+ $data['total_open_count'];
					} else {
						$numOfOpenOrderPerWorkedDays = 0;
						$data['projected_open_count'] = 0;
					}
					$closeRefiResult = $this->order->getClosedOrdersCountForRefiProducts(date('m'), $usersIds);
					$data['refi_close_count'] = !empty($closeRefiResult['refi_count']) ? $closeRefiResult['refi_count'] : 0;
					$closeSaleResult = $this->order->getClosedOrdersCountForSaleProducts(date('m'), $usersIds);
					$data['sale_close_count'] =  !empty($closeSaleResult['sale_count']) ? $closeSaleResult['sale_count'] : 0;
					$data['total_close_count'] = $data['refi_close_count'] + $data['sale_close_count'];

					if ($data['total_close_count'] > 0) {
						$numOfCloseOrderPerWorkedDays = $data['total_close_count']/$workedDays;
						$data['projected_close_count'] = (round($numOfCloseOrderPerWorkedDays*$workingDaysRemaining))+ $data['total_close_count'];
					} else {
						$numOfCloseOrderPerWorkedDays = 0;
						$data['projected_close_count'] = 0;
					}
					$closeOrderRefiTotalPremium =  !empty($closeRefiResult['total_premium_for_refi_close_orders']) ? $closeRefiResult['total_premium_for_refi_close_orders'] : 0;
					$data['refi_total_premium'] = $closeOrderRefiTotalPremium;
					$closeOrderSaleTotalPremium =  !empty($closeSaleResult['total_premium_for_sale_close_orders']) ? $closeSaleResult['total_premium_for_sale_close_orders'] : 0;
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
				}
			} 
		}

		$this->load->model('hr/pct_hr_employee_time_tracking_model');
		$clock_event = $this->pct_hr_employee_time_tracking_model->get_clock_event($userdata['id']);
		$get_today_working = $this->pct_hr_employee_time_tracking_model->get_today_working($userdata['id']);
		$get_last_time = $this->pct_hr_employee_time_tracking_model->get_last_time($userdata['id']);
		$data['clock_event'] = $clock_event;
		$data['time_tracking'] = $get_today_working + $get_last_time;

		if ($userdata['user_type_id'] == 2) {
			$data['title'] = 'HR-Center Branch Manager Dashboard';
			$this->template->show("hr/branch_manager", "dashboard", $data);
		} else {
			$data['title'] = 'HR-Center Employee Dashboard';
			$this->template->show("hr/employee", "dashboard", $data);
		}
	}

	function logout()
	{
		$userdata = $this->session->userdata('hr_user');
		if(!empty($userdata['id'])) {
			$this->load->model('hr/pct_hr_employee_time_tracking_model');
			$clock_event = $this->pct_hr_employee_time_tracking_model->get_clock_event($userdata['id']);
			if($clock_event == 'OUT') {
				$this->pct_hr_employee_time_tracking_model->track_time($userdata['id'],$clock_event);
			}
		}
		$this->session->sess_destroy();
		$this->session->unset_userdata('hr_user');
		redirect(base_url().'hr');
	}
}
