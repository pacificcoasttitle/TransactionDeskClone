<?php

(defined('BASEPATH')) OR exit('No direct script access allowed');

class SalesRep extends MX_Controller 
{
    private $sales_dashboard_js_version = '03';

	function __construct() 
    {
        parent::__construct();
		$this->load->helper(
            array('file', 'url','form')
        );
        $this->load->library('session');
		$this->load->library('form_validation');
        $this->load->library('order/template');
		$this->load->model('order/orderRecording');
		$this->load->library('order/order');
        $this->load->model('order/apiLogs');
        $this->load->model('order/reviewPrelimData');
		$this->load->model('order/titleOfficer');
		$this->load->model('order/home_model');
		$this->load->model('order/fees_model');
		$this->load->library('order/resware');
		$this->load->library('order/common');
        $this->load->model('order/salesRep_model');
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
			$salesUser =  $this->home_model->get_user(array('id' => $userdata['id']));
            if (!empty($salesUser['sales_rep_users'])) {
                $salesRepUsers = explode(',', $salesUser['sales_rep_users']);
                if (!in_array($userdata['id'], $salesRepUsers)) {
                    $salesRepUsers[] = $userdata['id'];
                }
                if (!in_array($userId, $salesRepUsers)) {
                    redirect(base_url().'sales-dashboard/'.$userdata['id']);
                }
                $data['salesUsers'] = $this->order->get_sales_users($salesRepUsers);
            } else {
                $data['salesUsers'] = $this->order->get_sales_users();
            }
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
		
		//Commission Logic
		$all_order_data = $this->order->getOrdersForUser($userId);
		// echo '<pre>';var_dump($all_order_data);die;
		$sales_commission = 0;
		$this->load->model('admin/order/underwriter_tier_model');
		$underwriter_tiers = $this->underwriter_tier_model->with('commision_range_obj')->get_all();
		$underwriter_tier_data = array();
		foreach($underwriter_tiers as $underwriter_tier_obj) {
			$underwriter_tier_data[$underwriter_tier_obj->product_type][$underwriter_tier_obj->underwriter][$underwriter_tier_obj->id] = $underwriter_tier_obj;
			// if($underwriter_tier_obj->commision_range_obj) {
			// }
		}
		// echo '<pre>';var_dump($underwriter_tier_data);die;
		$this->load->model('admin/order/underwriter_user_model');
		$existing_comission_data = $this->underwriter_user_model->with('underwriter_tier_obj')->with('underwriter_user_threshold_obj')->get_many_by('user_id',$userId);
		$user_specific_commission = array();
		foreach ($existing_comission_data as $existing_comission_record) {
			if($existing_comission_record->underwriter_tier_obj) {
				$pord_type = $existing_comission_record->underwriter_tier_obj->product_type;
				$underwriter_type = $existing_comission_record->underwriter_tier_obj->underwriter;
				$user_specific_commission[$existing_comission_record->underwriter_tier_id] = $existing_comission_record;
			}
		}

		$order_tier_group = array();
		
		$underwriters = UNDERWRITERS;
		foreach ($all_order_data as $all_order_record) {
			$product_type = $all_order_record['prod_type'];
			$underwriter = $all_order_record['underwriter'];

			$underwriter_type = $underwriter;
			$check_key = array_search($underwriter,$underwriters);
			if($check_key !== false) {
				$underwriter_type =$check_key;
			}
			$premium =  $all_order_record['premium'];
			$check_amount = 0;
			if($product_type == 'loan') {
				$check_amount = $all_order_record['loan_amount'];
			}
			else {
				$check_amount = $all_order_record['sale_amount'];
			}

			//Find Tier
			if(isset($underwriter_tier_data[$product_type][$underwriter_type])) {
				// echo "in";die;
				$default_tier_value = null;
				//Check if Underwriter has single tier
				if(count($underwriter_tier_data[$product_type][$underwriter_type]) <= 1) {
					$default_tier_value = reset($underwriter_tier_data[$product_type][$underwriter_type]);
				} else {
					//Find Tier
					$tires = $underwriter_tier_data[$product_type][$underwriter_type];
					$found_tier = false;
					foreach($tires as $tire){
						$commission_range_data = $tire->commision_range_obj;
						foreach($commission_range_data as $commission_range_obj ) {
							$check_premium = $commission_range_obj->premium;
							$check_min = $commission_range_obj->min_revenue;
							$check_max = $commission_range_obj->max_revenue;
							if($check_premium == $premium && $check_amount >= $check_min && $check_amount <=  $check_max) {
								$default_tier_value = $tire;
								$found_tier = true;
								break;
							}
						}
						if($found_tier) {
							break;
						}
					}
				}

				//Check if we found tier
				if($default_tier_value) {
					// $commission_val = $default_tier_value['commission'];
					$tier_id = $default_tier_value->id;
					if(!is_array($order_tier_group[$tier_id][$premium])) {
						$order_tier_group[$tier_id][$premium]['default'] = $default_tier_value;
						$order_tier_group[$tier_id][$premium]['data'] = array();
					}
					$order_tier_group[$tier_id][$premium]['data'][]=$all_order_record;
					

				}


			}
		}

		
		$sales_commission = 0;
		foreach ($order_tier_group as $tier_id=>$order_tier_record) {
			foreach ($order_tier_record as $premium_amount=>$order_record) {
				$commission_val = $order_record['default']->commission;
				$total_premium = $premium_amount*count($order_record['data']);
				//Check if its override
				if(isset($user_specific_commission[$tier_id]) && !empty($user_specific_commission[$tier_id])) {
					$user_specific_commission_obj = $user_specific_commission[$tier_id];
					if($user_specific_commission_obj->allow_threshold == 0 && $user_specific_commission_obj->fix_commission) {
						$commission_val = $user_specific_commission_obj->fix_commission;
						$sales_commission += ((float)$commission_val * (float)$total_premium) / 100;
					}
					elseif($user_specific_commission_obj->allow_threshold == 1 && $user_specific_commission_obj->underwriter_user_threshold_obj) {
						$threshold_data = $user_specific_commission_obj->underwriter_user_threshold_obj;
						usort($threshold_data, function($a, $b) {
							return $a->threshold_amount_min <=> $b->threshold_amount_min;
						});
						$remaining_amount = $total_premium;
						$threshold_i = 0;
						$threshold_cnt = count($threshold_data);
						$commission_calculated = false;
						if(isset($threshold_data[0]) && !empty($threshold_data[0])) {
							$check_min = $threshold_data[0]->threshold_amount_min;
							if($check_min > 1 && $remaining_amount >= $check_min) {
								$remaining_amount -= $check_min;
								$sales_commission += ((float)$commission_val * (float)$check_min) / 100;
								$commission_calculated = true;

							}
						}
						foreach($threshold_data as $threshold_obj) {
							// if($threshold_obj->threshold_amount_min < 1)
							if($remaining_amount >= $threshold_obj->threshold_amount_min) {
								$calculate_value = $threshold_obj->threshold_amount_max;
								$commission_val = $threshold_obj->threshold_commission;
								$commission_calculated = true;
								if($remaining_amount <= $threshold_obj->threshold_amount_max || $threshold_i == ($threshold_cnt -1)) {
									$calculate_value = $remaining_amount;
									$sales_commission += ((float)$commission_val * (float)$calculate_value) / 100;
									break;
								} else {
									$sales_commission += ((float)$commission_val * (float)$calculate_value) / 100;
								}
								$remaining_amount -= $calculate_value;
								$threshold_i++;
							}
						}

						if(!$commission_calculated) {
							$sales_commission += ((float)$commission_val * (float)$total_premium) / 100;
						}
					}
					else {
						$sales_commission += ((float)$commission_val * (float)$total_premium) / 100;
					}
				}
				else {
					$sales_commission += ((float)$commission_val * (float)$total_premium) / 100;
				}
				
				
			}	
		}

        $data['sales_commission'] = $sales_commission;
		//Commission Logic Ends

		
		
		
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
        $this->template->addJS( base_url('assets/frontend/js/order/sales_dashboard.js?v=sales_dashboard_'.$this->sales_dashboard_js_version) );
		// echo "<pre>";
		// var_dump($data);die;
		$this->template->show("order", "sales_dashboard", $data);
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
            //echo "hehe";exit;
            $salesUser =  $this->home_model->get_user(array('id' => $userdata['id']));
            if (!empty($salesUser['sales_rep_users'])) {
                $salesRepUsers = explode(',', $salesUser['sales_rep_users']);
                if (!in_array($userdata['id'], $salesRepUsers)) {
                    $salesRepUsers[] = $userdata['id'];
                }
                if (!in_array($userId, $salesRepUsers)) {
                    redirect(base_url().'sales-production-history/'.$userdata['id']);
                }
                $data['salesUsers'] = $this->order->get_sales_users($salesRepUsers);
            } else {
                $data['salesUsers'] = $this->order->get_sales_users();
            }
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
                $salesHistory[$iM-1]['trending'] = $previousCount['total_count'] > $salesHistory[$iM-1]['total_open_count'] ? '<span style="color: red;font-weight:bold;"><i class="fa fa-arrow-down"></i></span>' : '<span style="color: limegreen;font-weight:bold;"><i class="fa fa-arrow-up"></i></span>';
            } else {
                if ($month == '01') {
                    $previousCount = $this->order->getOpenOrdersCountForLastMonthOfPreviousYear($userId);
                    $previousCount = $previousCount['total_count'];
                } else {
                    $previousCount = $salesHistory[$iM-2]['total_open_count'];
                }
                $salesHistory[$iM-1]['trending'] = $previousCount > $salesHistory[$iM-1]['total_open_count'] ? '<span style="color: red;font-weight:bold;"><i class="fa fa-arrow-down"></i></span>' : '<span style="color: limegreen;font-weight:bold;"><i class="fa fa-arrow-up"></i></span>';
            }

		}
		$data['salesHistory'] = $salesHistory;
        $this->template->addJS( base_url('assets/frontend/js/order/sales_dashboard.js?v=sales_dashboard_'.$this->sales_dashboard_js_version) );
		$this->template->show("order", "sales_production_history", $data);
	}

    function trends()
	{
        $userdata = $this->session->userdata('user');
		$userId = $this->uri->segment(2);
		$data['sales_user_id']  = $userId;
		$data['is_sales_rep_manager'] = $userdata['is_sales_rep_manager'];

		if ($userdata['is_sales_rep_manager'] == 1) {
			$salesUser =  $this->home_model->get_user(array('id' => $userdata['id']));
            if (!empty($salesUser['sales_rep_users'])) {
                $salesRepUsers = explode(',', $salesUser['sales_rep_users']);
                if (!in_array($userdata['id'], $salesRepUsers)) {
                    $salesRepUsers[] = $userdata['id'];
                }
                if (!in_array($userId, $salesRepUsers)) {
                    redirect(base_url().'trends/'.$userdata['id']);
                }
                $data['salesUsers'] = $this->order->get_sales_users($salesRepUsers);
            } else {
                $data['salesUsers'] = $this->order->get_sales_users();
            }
		} else {
            if ($userId != $userdata['id']) {
                redirect(base_url().'trends/'.$userdata['id']);
            }
			$data['salesUsers'] = array();
		}
		$data['title'] = 'Trends | Pacific Coast Title Company';
        $salesHistory = array();

        for ($year = (int)date('Y'); $year > (int)date('Y')- 2; $year--) {
            $monthLimit = ($year == (int)date('Y')) ? (int)date('m') : 12; 
            
            for ($iM = 1; $iM <= $monthLimit; $iM++) {
                $month = date("m", strtotime("$iM/12/10"));
                $dateObj   = DateTime::createFromFormat('!m', $iM);
                $monthName = $dateObj->format('F'); 
                $salesHistory[$year][$iM-1]['month'] = $monthName;
    
                $openRefiResult = $this->order->getOpenOrdersCountForRefiProducts($month, $userId, strval( $year));
                $refi_open_count = !empty($openRefiResult['refi_count']) ? $openRefiResult['refi_count'] : 0;
                $openSaleResult = $this->order->getOpenOrdersCountForSaleProducts($month, $userId, strval( $year));
                $sale_open_count = !empty($openSaleResult['sale_count']) ? $openSaleResult['sale_count'] : 0;
                $salesHistory[$year][$iM-1]['total_open_count'] = $sale_open_count + $refi_open_count;
    
                $closeRefiResult = $this->order->getClosedOrdersCountForRefiProducts($month, $userId, strval( $year));
                $refi_close_count = !empty($closeRefiResult['refi_count']) ? $closeRefiResult['refi_count'] : 0;
                $closeSaleResult = $this->order->getClosedOrdersCountForSaleProducts($month, $userId, strval( $year));
                $sale_close_count =  !empty($closeSaleResult['sale_count']) ? $closeSaleResult['sale_count'] : 0;
                $salesHistory[$year][$iM-1]['total_close_count'] = $refi_close_count + $sale_close_count;
    
                $closeOrderRefiTotalPremium =  !empty($closeRefiResult['total_premium_for_refi_close_orders']) ? $closeRefiResult['total_premium_for_refi_close_orders'] : 0;
                $refi_total_premium =  $closeOrderRefiTotalPremium;
                $closeOrderSaleTotalPremium =  !empty($closeSaleResult['total_premium_for_sale_close_orders']) ? $closeSaleResult['total_premium_for_sale_close_orders'] : 0;
                $sale_total_premium = $closeOrderSaleTotalPremium;
                $salesHistory[$year][$iM-1]['total_premium'] = $sale_total_premium + $refi_total_premium;
            }
        }	
		$data['salesHistory'] = $salesHistory;
        $this->template->addJS( base_url('assets/plugins/chart/Chart.min.js') );
        $this->template->addJS( base_url('assets/frontend/js/order/sales_dashboard.js?v=sales_dashboard_'.$this->sales_dashboard_js_version) );
		$this->template->show("order", "sales_trends", $data);
    }

    function summary()
	{
        $userdata = $this->session->userdata('user');
		$userId = $this->uri->segment(2);
		$data['sales_user_id']  = $userId;
		$data['is_sales_rep_manager'] = $userdata['is_sales_rep_manager'];

		if ($userdata['is_sales_rep_manager'] == 1) {
			$salesUser =  $this->home_model->get_user(array('id' => $userdata['id']));
            if (!empty($salesUser['sales_rep_users'])) {
                $salesRepUsers = explode(',', $salesUser['sales_rep_users']);
                if (!in_array($userdata['id'], $salesRepUsers)) {
                    $salesRepUsers[] = $userdata['id'];
                }
                if (!in_array($userId, $salesRepUsers)) {
                    redirect(base_url().'sales-summary/'.$userdata['id']);
                }
                $data['salesUsers'] = $this->order->get_sales_users($salesRepUsers);
            } else {
                $data['salesUsers'] = $this->order->get_sales_users();
            }
		} else {
            if ($userId != $userdata['id']) {
                redirect(base_url().'sales-summary/'.$userdata['id']);
            }
			$data['salesUsers'] = array();
		}

        $result = $this->salesRep_model->getSummaryDetailsForSalesRep($userId);
        if(!empty($result)) {
            
            $data['summary_info'] = array();
            $i = 0;
            $j = 0;
            $companyName = '';
            $position = 0;
            $num_of_company_deals = 0;

            foreach($result as $res) {
                if ($res['company_name'] == $companyName) {
                    $data['summary_info'][$i]['company_id'] = $j;
                    $data['summary_info'][$i]['sales_name'] = $res['sales_name'];
                    $data['summary_info'][$i]['company_name'] = $companyName;
                    $data['summary_info'][$i]['name'] = $res['name'];
                    $data['summary_info'][$i]['num_of_deals'] = $res['num_of_deals'];
                    $data['summary_info'][$i]['parent_id'] = $j;
                    $num_of_company_deals += $res['num_of_deals'];
                    $i++;
                } else {
                    $data['summary_info'][$position]['num_of_deals'] = $num_of_company_deals;
                    $num_of_company_deals = 0;
                    $j++;
                    $position = $i;
                    $companyName = $res['company_name'];
                    $data['summary_info'][$i]['company_id'] = $j;
                    $data['summary_info'][$i]['sales_name'] = $res['sales_name'];
                    $data['summary_info'][$i]['company_name'] = $companyName;
                    $data['summary_info'][$i]['name'] = $res['name'];
                    $data['summary_info'][$i]['num_of_deals'] = $res['num_of_deals'];
                    $data['summary_info'][$i]['parent_id'] = 0;
                    $i++;

                    $data['summary_info'][$i]['company_id'] = $j;
                    $data['summary_info'][$i]['sales_name'] = $res['sales_name'];
                    $data['summary_info'][$i]['company_name'] = $companyName;
                    $data['summary_info'][$i]['name'] = $res['name'];
                    $data['summary_info'][$i]['num_of_deals'] = $res['num_of_deals'];
                    $data['summary_info'][$i]['parent_id'] = $j;
                    $num_of_company_deals += $res['num_of_deals'];
                    $i++; 
                }
            }
        }
       // echo "<pre>";
        //print_r($data['summary_info']);exit;
        $this->template->addJS( base_url('assets/frontend/js/order/sales_dashboard.js?v=sales_dashboard_'.$this->sales_dashboard_js_version) );
        $this->template->addCss( base_url('assets/frontend/css/escrow_tasks.css?v=05') );
		$this->template->show("order", "sales_summary", $data);
    }

	function commission($userId) {
		$userdata = $this->session->userdata('user');
		// $userId = $this->uri->segment(2);
		$data['sales_user_id']  = $userId;
		$data['is_sales_rep_manager'] = $userdata['is_sales_rep_manager'];
		if ($userdata['is_sales_rep_manager'] == 1) {
            //echo "hehe";exit;
            $salesUser =  $this->home_model->get_user(array('id' => $userdata['id']));
            if (!empty($salesUser['sales_rep_users'])) {
                $salesRepUsers = explode(',', $salesUser['sales_rep_users']);
                if (!in_array($userdata['id'], $salesRepUsers)) {
                    $salesRepUsers[] = $userdata['id'];
                }
                if (!in_array($userId, $salesRepUsers)) {
                    redirect(base_url().'sales-commission/'.$userdata['id']);
                }
                $data['salesUsers'] = $this->order->get_sales_users($salesRepUsers);
            } else {
                $data['salesUsers'] = $this->order->get_sales_users();
            }
		} else {
            if ($userId != $userdata['id']) {
                redirect(base_url().'sales-commission/'.$userdata['id']);
            }
			$data['salesUsers'] = array();
		}
		$data['title'] = 'Sales Production History | Pacific Coast Title Company';
		$commissionHistory = array();
		$current_year = date('Y');
		$this->load->model('admin/order/user_monthly_commission_model');
		for ($iM = 1; $iM <= (int)date('m'); $iM++) {
			$dateObj   = DateTime::createFromFormat('!m', $iM);
			$monthName = $dateObj->format('F'); 
			$commissionHistory[$iM-1]['month'] = $monthName;
			$get_month_conditon = [
				'user_id'=>$userId,
				'commission_year'=>$current_year,
				'commission_month'=>$iM,
			];
			$commisson_data = $this->user_monthly_commission_model->get_by($get_month_conditon);
			if($iM == date('m') && (!($commisson_data) || empty($commisson_data->commission))) {
				//Call procedure
				$stored_pocedure = "CALL calculate_commission(?)";
				$this->user_monthly_commission_model->call_sp($stored_pocedure,array('id'=>$userId));
				$commisson_data = $this->user_monthly_commission_model->get_by($get_month_conditon);
			}
			$commissionHistory[$iM-1]['commission_data'] = $commisson_data;

			

		}
		$data['commissionHistory'] = $commissionHistory;
        $this->template->addJS( base_url('assets/frontend/js/order/sales_dashboard.js?v=sales_dashboard_'.$this->sales_dashboard_js_version) );
		$this->template->show("order", "sales_commission_history", $data);
	}
}
