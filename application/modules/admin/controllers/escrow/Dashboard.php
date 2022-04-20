<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends MX_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */

    private $dashboard_js_version = '01';
	public function __construct()
    {
        parent::__construct();
        $this->load->helper(
            array('file', 'url','form')
        );
        $this->load->library('form_validation');
        $this->load->library('escrow/template');
        $this->load->library('escrow/common');
		$this->load->library('order/order');
        $this->common->is_escrow_admin();
    }

    public function index()
    {		
		$userdata = $this->session->userdata('is_escrow_admin');
        $data['title'] = 'Escrow Admin Dashboard';
        $data['page_title'] = 'Dashboard';
	
        if ($userdata['user_type_id'] == '6') {
			
		} else {
			
		}

        $this->template->addCSS( base_url('assets/libs/calendar/main.css'));
        $this->template->addJS( base_url('assets/libs/calendar/main.js'));
        $this->template->addJS( base_url('assets/backend/escrow/js/dashboard.js?v=dashboard_'.$this->dashboard_js_version) );
        $this->template->show("escrow", "dashboard", $data);
    }

    public function getVacationDataForCalendar()
    {
        $start = date('Y-m-d', strtotime($this->input->post('start')));
        $end = date('Y-m-d', strtotime($this->input->post('end')));
        $vacationData = $this->common->getVacationDataForCalendar($start, $end);
        $data = array();
        $i = 0;
        foreach ($vacationData as $vacation) {
            $data[$i]['id'] = $vacation['id'];
            $data[$i]['title'] = $vacation['first_name']." ".$vacation['last_name'];
            $data[$i]['start'] = $vacation['from_date'];
            $data[$i]['end'] = date('Y-m-d', strtotime($vacation['to_date'] . ' +1 day'));
			if (!empty($vacation['approved_by_user_id'])) {
				if ($vacation['status'] == 'approved') {
					$data[$i]['backgroundColor'] = '#28a745';
				} 
			}
            $i++;
        }
        $i++;
        echo json_encode($data); 
    }

	public function getDashboardCount()
	{
		$userdata = $this->session->userdata('hr_admin');
		$data['month'] = $month = !empty($this->input->post('month')) ? $this->input->post('month') : date('m');
		$data['user_id'] = $user_id = !empty($this->input->post('user_id')) ? $this->input->post('user_id') : 0;
		$data['manager_id'] = $manager_id = !empty($this->input->post('manager_id')) ? $this->input->post('manager_id') : 0;
		$data['users'] = array();
		$data['managers'] = array();
		$usersEmails = array();
		$usersIds = array();

		if ($userdata['user_type_id'] == '6') {
			$workedDays = $this->order->countWorkedDaysOfMonth();
			$workingDaysRemaining = $this->order->countWokingsDaysLeftOfMonth();
			$openRefiResult = $this->order->getOpenOrdersCountForRefiProducts($month, $usersIds, 0, 1);
			$data['refi_open_count'] = !empty($openRefiResult['refi_count']) ? $openRefiResult['refi_count'] : 0;
			$openSaleResult = $this->order->getOpenOrdersCountForSaleProducts($month, $usersIds, 0, 1);
			$data['sale_open_count'] = !empty($openSaleResult['sale_count']) ? $openSaleResult['sale_count'] : 0;
			$data['total_open_count'] = $data['sale_open_count'] + $data['refi_open_count'];

			if ($data['total_open_count'] > 0) {
				$numOfOpenOrderPerWorkedDays = $data['total_open_count']/$workedDays;
				$data['projected_open_count'] = (round($numOfOpenOrderPerWorkedDays*$workingDaysRemaining))+ $data['total_open_count'];
			} else {
				$numOfOpenOrderPerWorkedDays = 0;
				$data['projected_open_count'] = 0;
			}
			$data['projected_open_count'] = 0;
			$closeRefiResult = $this->order->getClosedOrdersCountForRefiProducts($month, $usersIds, 0, 1);
			$data['refi_close_count'] = !empty($closeRefiResult['refi_count']) ? $closeRefiResult['refi_count'] : 0;
			$closeSaleResult = $this->order->getClosedOrdersCountForSaleProducts($month, $usersIds, 0, 1);
			$data['sale_close_count'] =  !empty($closeSaleResult['sale_count']) ? $closeSaleResult['sale_count'] : 0;
			$data['total_close_count'] = $data['refi_close_count'] + $data['sale_close_count'];

			if ($data['total_close_count'] > 0) {
				$numOfCloseOrderPerWorkedDays = $data['total_close_count']/$workedDays;
				$data['projected_close_count'] = (round($numOfCloseOrderPerWorkedDays*$workingDaysRemaining))+ $data['total_close_count'];
			} else {
				$numOfCloseOrderPerWorkedDays = 0;
				$data['projected_close_count'] = 0;
			}
			$data['projected_close_count'] = 0;
			$closeOrderRefiTotalPremium =  !empty($closeRefiResult['total_escrow_amount_for_refi_close_orders']) ? $closeRefiResult['total_escrow_amount_for_refi_close_orders'] : 0;
			$data['refi_total_premium'] = $closeOrderRefiTotalPremium;
			$closeOrderSaleTotalPremium =  !empty($closeSaleResult['total_escrow_amount_for_sale_close_orders']) ? $closeSaleResult['total_escrow_amount_for_sale_close_orders'] : 0;
			$data['sale_total_premium'] = $closeOrderSaleTotalPremium;
			$data['total_premium'] = $data['sale_total_premium'] + $data['refi_total_premium'];

			if ($data['total_premium'] > 0) {
				$premiumWorkedDays = $data['total_premium']/$workedDays;
				$data['projected_revenue'] = (round($premiumWorkedDays*$workingDaysRemaining))+ $data['total_premium'];
			} else {
				$premiumWorkedDays = 0;
				$data['projected_revenue'] = 0;
			}
			$data['projected_revenue'] = 0;
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
		$results = $this->load->view('hr/dashboard_count', $data, TRUE);
		echo json_encode($results, true);
	}

    public function logout()
    {
        $this->session->unset_userdata('escrow_admin');
        redirect(base_url().'escrow/admin');
    }
}
