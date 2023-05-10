<?php

(defined('BASEPATH')) OR exit('No direct script access allowed');

class Order extends MX_Controller {

	function __construct() {
        parent::__construct();
        $this->load->helper(array('file', 'url'));
        $this->load->library('session');
        $this->load->library('order/adminTemplate');
        $this->load->model('order/order_model');
        $this->load->model('order/sales_model');
        $this->load->model('order/title_model');
        $this->load->model('order/home_model');
        $this->load->model('order/apiLogs');
        $this->load->library('order/common');
        $this->common->is_admin();
    }

    function orders() {
    	$params = array();
    	$salesRep = $this->sales_model->get_sales_reps($params);
    	$data['salesRep'] = $salesRep;
        $con = array(
            'where' => array(
                'is_master' => 1,
                'status' => 1,
            )
        );
        $product_type = $this->uri->segment(4);
        $master_users = $this->home_model->get_rows($con);
        $data['master_users'] = $master_users;
        $data['product_type'] = $product_type;
        // $this->admintemplate->addCSS( base_url('assets/backend/hr/vendor/datatables/dataTables.bootstrap4.min.css'));
        // $this->admintemplate->addJS( base_url('assets/backend/hr/vendor/datatables/jquery.dataTables.min.js'));
        $this->admintemplate->addJS( base_url('assets/backend/js/order.js'));
        $this->admintemplate->show("order/order", "orders", $data);
        
    	// $this->load->view('order/layout/header', $data);
        // $this->load->view('order/order/orders', $data);
        // $this->load->view('order/layout/footer', $data);
    }

    function get_order_list()
    {
    	$params = array();
        $params['length'] = $this->input->post('length');
        $params['start'] = $this->input->post('start');
        $params['order_type'] = 'resware_orders';
        $params['searchValue'] = isset($_POST['search']['value']) && !empty($_POST['search']['value']) ? $_POST['search']['value']: '';
        $params['sales_rep'] = $this->input->post('sales_rep');
        $params['created_by'] = $this->input->post('created_by');
        $params['product_type'] = $this->input->post('product_type');
       
        $pageno = ($params['start'] / $params['length'])+1; 
        $ordersList = $this->order_model->get_orders($params);   
        
        $data = array(); 
        $cnt = ($pageno == 1) ? ($params['start']+1) : (($pageno - 1) * $params['length']) + 1;
        $count = $params['start'] + 1;
        foreach( $ordersList['data'] as $key => $value )
        {
            $nestedData=array();
            $nestedData[] = $count;
            $nestedData[] = $value['file_number'];
            $nestedData[] = $value['full_address'];
            $nestedData[] = $value['product_type'];
			$nestedData[] = $value['sales_rep_name'];
			$nestedData[] = $value['first_name']." ".$value['last_name'];
            $property_id = $value['property_id'];
            if ($value['allow_duplication'] == 1) {
                $checked = 'checked';
            } else {
                $checked = '';
            }
            $nestedData[] = "<input $checked onclick='avoidDuplication();' style='height:30px;width:20px;' type='checkbox' id='$property_id' name='$property_id'>";
            // $nestedData[] = date("m/d/Y h:i:s A", strtotime($value['created_at']));
			$nestedData[] = convertTimezone($value['created_at']);
            $editOrderUrl = base_url().'order/admin/order-details/'.$value['file_id'];
            $action = "<a href='".$editOrderUrl."' class='view-icon action-btn-padding' title ='View Order Detail'><span class='fa fa-eye' aria-hidden='true'></span></a>";
            $nestedData[] = $action;
            $data[] = $nestedData;            
            $count++;          
        }  
                      
        $json_data = array(            
            "recordsTotal"    => $ordersList['recordsTotal'],
            "recordsFiltered" => $ordersList['recordsFiltered'],
            "data" => $data 
        );

        echo json_encode($json_data);
    }

    function order_details()
    {    	
        $file_id = $this->uri->segment(4);        
        $data = array();
        $data['title'] = 'PCT Order: Order Details';

        if(isset($file_id) && !empty($file_id))
        {
        	$order_details = $this->order_model->get_order_details($file_id);
        	$customer_id = $order_details['customer_id'];
        	$con = array('id'=>$customer_id);
        	$customer_details = $this->home_model->get_rows($con);
        	$data['order_details'] = $order_details;
        	$data['customer_details'] = $customer_details;
        	// echo "<pre>"; print_r($data); exit;
            $this->admintemplate->show("order/order", "order_details", $data);
        	// $this->load->view('order/layout/header', $data);
	        // $this->load->view('order/order/order_details', $data);
	        // $this->load->view('order/layout/footer', $data);
        	
        }
        else
        {
            redirect('order/admin/orders');
        }
    }

    function export_orders()
    {
    	$sales_rep = $this->input->post('sales_rep');
    	$seachValue = $this->input->post('seachValue');

    	$params = array();
    	$params['sales_rep'] = $sales_rep;
    	$params['seachValue'] = $seachValue;

    	$ordersList = $this->order_model->get_orders($params);

    	if(isset($ordersList['data']) && !empty($ordersList['data']))
    	{
			$export_data = array();
    		foreach ($ordersList['data'] as $key => $value) 
    		{
    			$file_id = isset($value['file_id']) && !empty(!empty($value['file_id'])) ? $value['file_id'] : '';
    			if($file_id)
    			{
    				$order_details = $this->order_model->get_order_details($file_id);
    				$con = array('id'=>$order_details['customer_id']);
        			$customer_details = $this->home_model->get_rows($con);
    				
    				$export_data[] = array(
    					'file_number' => $order_details['file_number'],
    					'file_id' => $order_details['file_id'],
    					'opened_date' => $order_details['opened_date'],
    					'company_name' => $customer_details['company_name'],
    					'email_address' => $customer_details['email_address'],
    					'first_name' => $customer_details['first_name'],
    					'last_name' => $customer_details['last_name'],
    					'telephone_no' => $customer_details['telephone_no'],
    					'street_address' => $customer_details['street_address'],
    					'city' => $customer_details['city'],
    					'zip_code' => $customer_details['zip_code'],
    					'full_address' => $order_details['full_address'],
    					'apn' => $order_details['apn'],
    					'county' => $order_details['county'],
    					'legal_description' => $order_details['legal_description'],
    					'primary_owner' => $order_details['primary_owner'],
    					'secondary_owner' => $order_details['secondary_owner'],
    					'borrower' => $order_details['borrower'],
    					'secondary_borrower' => $order_details['secondary_borrower'],
    					'sales_rep_name' => $order_details['sales_rep_name'],
    					'title_officer_name' => $order_details['title_officer_name'],
    					'product_type' => $order_details['product_type'],
    					'loan_amount' => $order_details['loan_amount'],
    					'sales_amount' => $order_details['sales_amount'],
    					'loan_number' => $order_details['loan_number'],
    					'escrow_number' => $order_details['escrow_number'],
    					'notes' => $order_details['notes'],
    					'additional_email' => $order_details['additional_email'],
    					'additional_email_1' => $order_details['additional_email_1'],
    					'additional_email_2' => $order_details['additional_email_2'],
    					'buyer_agent_name' => $order_details['buyer_agent_name'],
    					'buyer_agent_email_address' => $order_details['buyer_agent_email_address'],
    					'buyer_agent_company' => $order_details['buyer_agent_company'],
    					'buyer_agent_telephone_no' => $order_details['buyer_agent_telephone_no'],
    					'listing_agent_name' => $order_details['listing_agent_name'],
    					'listing_agent_email_address' => $order_details['listing_agent_email_address'],
    					'listing_agent_company' => $order_details['listing_agent_company'],
    					'listing_agent_telephone_no' => $order_details['listing_agent_telephone_no'],
    					'escrow_lender_company_name' => $order_details['escrow_lender_company_name'],
    					'escrow_lender_first_name' => $order_details['escrow_lender_first_name'],
    					'escrow_lender_last_name' => $order_details['escrow_lender_last_name'],
    					'escrow_lender_email' => $order_details['escrow_lender_email'],
    					'escrow_lender_telephone_no' => $order_details['escrow_lender_telephone_no']
    				);					
    			}    			
    		}
    		if(isset($export_data) && !empty($export_data))
    		{
    			if (!is_dir('uploads/orders')) {
			    	mkdir('./uploads/orders', 0777, TRUE);
				}

				$outputPath = './uploads/orders/output.csv';
	    		$output = fopen($outputPath, "w");

    			$header = array("Order #","File ID","Order Open At","Company Name","Email Address","First Name","Last Name","Telephone","Street Address","City","Zipcode","Property Address","APN","County","Brief Legal Description","Primary Owner","Secondary Owner","Primary Borrower","Secondary Borrower","Sales Rep","Title Officer","Product","Loan Amount","Sales Amount","Loan Number","Escrow Number","Notes","Additional Email Address","Additional Email Address1","Additional Email Address2","Buyer Agent Name","Buyer Agent Email Address","Buyer Agent Comapny","Buyer Agent Telephone","Listing Agent Name","Listing Agent Email Address","Listing Agent Comapny","Listing Agent Telephone","Lender/Escrow Name","Lender/Escrow Email Address","Lender/Escrow Comapny","Lender/Escrow Telephone");
				fputcsv($output, $header);

    			foreach ($export_data as $key => $value) 
    			{
    				fputcsv($output, $value);
    			}

    			header('Content-Type: application/json');
    			$contents = file_get_contents($outputPath);
    			$binaryData   = base64_encode($contents);
    			unlink($outputPath);
    			fclose($output);

    			$res = array('status'=>'success','data'=>$binaryData);	
    		}
    		else
	    	{
	    		$res = array('status'=>'error','data'=>'No data found.');
	    	}		
    	}
    	else
    	{
    		$res = array('status'=>'error','data'=>'No data found.');
    	}

    	echo json_encode($res); exit;
    }

    function partnerApiLogs()
    {
        $data = array();
        $data['title'] = 'PCT Order: Partner Api Log';

        $salesRep = $this->sales_model->get_sales_reps(array());
        $data['salesRep'] = $salesRep;

        $titleOfficer = $this->title_model->get_title_officers(array());

        $data['titleOfficer'] = $titleOfficer;
        $this->admintemplate->show("order/home", "partner_api_logs", $data);
        // $this->load->view('order/layout/header', $data);
        // $this->load->view('order/home/partner_api_logs', $data);
        // $this->load->view('order/layout/footer', $data);
    }

    function get_partner_api_logs()
    {
        $this->load->model('order/partnerApiLogs');

        $params = array();

        if(isset($_POST['draw']) && !empty($_POST['draw']))
        {
            $params['draw'] = isset($_POST['draw']) && !empty($_POST['draw']) ? $_POST['draw'] : 10;
            $params['length'] = isset($_POST['length']) && !empty($_POST['length']) ? $_POST['length'] : 10;
            $params['start'] = isset($_POST['start']) && !empty($_POST['start']) ? $_POST['start'] : 0;
            $params['orderColumn'] = isset($_POST['order'][0]['column']) && !empty($_POST['order'][0]['column']) ? $_POST['order'][0]['column'] : 0;
            $params['orderDir'] = isset($_POST['order'][0]['dir']) && !empty($_POST['order'][0]['dir']) ? $_POST['order'][0]['dir'] : 0;

            $params['searchvalue'] = isset($_POST['search']['value']) && !empty($_POST['search']['value']) ? $_POST['search']['value'] : '';
            // $params['status']['cs4_result_id_status'] = 'Success';

            $pageno = ($params['start'] / $params['length'])+1;
            $params['sales_rep'] = $this->input->post('sales_rep');
            $params['title_officer'] = $this->input->post('title_officer');

            $logs_list = $this->partnerApiLogs->get_partner_api_logs($params);

            // $cnt = ($pageno == 1) ? ($params['start']+1) : (($pageno - 1) * $params['length']) + 1;

            $json_data['draw'] = intval( $params['draw'] );
        }
        else
        {
            $params['searchvalue'] = isset($_POST['keyword']) && !empty($_POST['keyword']) ? $_POST['keyword'] : '';
            $logs_list = $this->partnerApiLogs->get_partner_api_logs($params);    
        }
        $data = array(); 
        $count = $params['start'] + 1;
        if(isset($logs_list['data']) && !empty($logs_list['data']))
        {
            foreach ($logs_list['data'] as $key => $value) 
            {
                $nestedData=array();
                $nestedData[] = $count;
                $nestedData[] = $value['file_number'];
                $nestedData[] = $value['title_officer_name'];
                $nestedData[] = $value['sales_rep_name'];
                if (!empty($value['underwriter'])) {
                    if ($value['underwriter'] == 'north_american') {
                        $nestedData[] = 'North American Title Insurance Company';
                    } else if ($value['underwriter'] == 'commonwealth') {
                        $nestedData[] = 'Commonwealth Land Title Insurance Company';
                    } else if ($value['underwriter'] == 'westcor') {
                        $nestedData[] = 'Westcor Land Title Insurance Company';
                    }
                } else {
                    if (strpos($value['cpl_document_name'], 'natic') !== false) {
                        $nestedData[] = 'North American Title Insurance Company';
                    } else if (strpos($value['cpl_document_name'], 'fnf') !== false) {
                        $nestedData[] = 'Commonwealth Land Title Insurance Company';
                    } else if (strpos($value['cpl_document_name'], 'westcor') !== false) {
                        $nestedData[] = 'Westcor Land Title Insurance Company';
                    } else {
                        $nestedData[] = '';
                    }
                }
                $response_data = $value['response_data'];
                $response = json_decode($response_data,TRUE);
                if(empty($response))
                {
                    $nestedData[] = 'Success';
                }
                else
                {
                    $msg = isset($response['ResponseStatus']['Message']) && !empty($response['ResponseStatus']['Message']) ? $response['ResponseStatus']['Message']: '';
                    $nestedData[] = $msg;
                }
                // $nestedData[] = date("m/d/Y h:i:s A", strtotime($value['created_at']));
				$nestedData[] = convertTimezone($value['created_at']);
                $data[] = $nestedData;
                $count++;
            }
        }
        $json_data['recordsTotal'] = intval( $logs_list['recordsTotal'] );
        $json_data['recordsFiltered'] = intval( $logs_list['recordsFiltered'] );
        $json_data['data'] = $data;
        echo json_encode($json_data);
    }

    function update_order_details()
    {
        $this->load->model('order/partnerApiLogs');
        $logs_list = $this->partnerApiLogs->get_api_logs();
        $count = 0;
        foreach ($logs_list as $key => $value) 
        {
            $url = $value['request_url'];

            $path = parse_url($url,PHP_URL_PATH);
            $a = explode('/', $path);
            $file_id = $a[3];
            $order_details = $this->order_model->get_order_details($file_id);
            $id = $order_details['order_id'];

            $condition = array('id' => $id);

            $data = array('partner_api_log_id' => $value['id']);

            $update = $this->order_model->update($data, $condition);
            if($update)
            {
                $count++;
            }
        }
        echo "<pre>"; print_r($count); exit;
    }

    function cplErrorLogs()
    {
        $data = array();
        $data['title'] = 'PCT Order: CPL Api Error Logs';
        $this->admintemplate->show("order/home", "cpl_error_api_logs", $data);
        // $this->load->view('order/layout/header', $data);
        // $this->load->view('order/home/cpl_error_api_logs', $data);
        // $this->load->view('order/layout/footer', $data);
    }

    function getCplErrorLogs()
    {
        $params = array();
        if (isset($_POST['draw']) && !empty($_POST['draw'])) {
            $params['draw'] = isset($_POST['draw']) && !empty($_POST['draw']) ? $_POST['draw'] : 10;
            $params['length'] = isset($_POST['length']) && !empty($_POST['length']) ? $_POST['length'] : 10;
            $params['start'] = isset($_POST['start']) && !empty($_POST['start']) ? $_POST['start'] : 0;
            $params['orderColumn'] = isset($_POST['order'][0]['column']) && !empty($_POST['order'][0]['column']) ? $_POST['order'][0]['column'] : 0;
            $params['orderDir'] = isset($_POST['order'][0]['dir']) && !empty($_POST['order'][0]['dir']) ? $_POST['order'][0]['dir'] : 0;
            $params['searchvalue'] = isset($_POST['search']['value']) && !empty($_POST['search']['value']) ? $_POST['search']['value'] : '';
            $pageno = ($params['start'] / $params['length'])+1;
            $cpl_logs_list = $this->home_model->getCplErrorLogs($params);
            $json_data['draw'] = intval( $params['draw'] );
        } else {
            $params['searchvalue'] = isset($_POST['keyword']) && !empty($_POST['keyword']) ? $_POST['keyword'] : '';
            $cpl_logs_list = $this->home_model->getCplErrorLogs($params);    
        }
        $data = array(); 
        $count = $params['start'] + 1;
        if (isset($cpl_logs_list['data']) && !empty($cpl_logs_list['data'])) {
            foreach ($cpl_logs_list['data'] as $key => $value)  {
                $nestedData=array();
                $nestedData[] = $count;
                $nestedData[] = $value['file_number'];
                $nestedData[] = $value['cpl_page'];
                $nestedData[] = $value['error'];
                // $nestedData[] = date("m/d/Y h:i:s A", strtotime($value['created_at']));
				$nestedData[] = convertTimezone($value['created_at']);
                $data[] = $nestedData;
                $count++;
            }
        }
        $json_data['recordsTotal'] = intval( $cpl_logs_list['recordsTotal'] );
        $json_data['recordsFiltered'] = intval( $cpl_logs_list['recordsFiltered'] );
        $json_data['data'] = $data;
        echo json_encode($json_data);
    }

    public function safewireOrders()
    {
        $data = array();
        $data['title'] = 'PCT Order: Safewire Orders';
        $this->load->view('order/layout/header', $data);
        $this->load->view('order/home/safewire_orders', $data);
        $this->load->view('order/layout/footer', $data);
    }

    public function get_safewire_orders_list()
    {
        $params = array();
        if (isset($_POST['draw']) && !empty($_POST['draw'])) {
            $params['draw'] = isset($_POST['draw']) && !empty($_POST['draw']) ? $_POST['draw'] : 10;
            $params['length'] = isset($_POST['length']) && !empty($_POST['length']) ? $_POST['length'] : 10;
            $params['start'] = isset($_POST['start']) && !empty($_POST['start']) ? $_POST['start'] : 0;
            $params['orderColumn'] = isset($_POST['order'][0]['column']) && !empty($_POST['order'][0]['column']) ? $_POST['order'][0]['column'] : 0;
            $params['orderDir'] = isset($_POST['order'][0]['dir']) && !empty($_POST['order'][0]['dir']) ? $_POST['order'][0]['dir'] : 0;
            $params['searchvalue'] = isset($_POST['search']['value']) && !empty($_POST['search']['value']) ? $_POST['search']['value'] : '';
            $safewire_orders_lists = $this->order_model->get_safewire_orders_list($params);
            $json_data['draw'] = intval( $params['draw'] );
        } else {
            $params['searchvalue'] = isset($_POST['keyword']) && !empty($_POST['keyword']) ? $_POST['keyword'] : '';
            $safewire_orders_lists = $this->order_model->get_safewire_orders_list($params);            
        }

        $data = array(); 
        $count = $params['start'] + 1;
	    if (isset($safewire_orders_lists['data']) && !empty($safewire_orders_lists['data'])) {
	    	foreach ($safewire_orders_lists['data'] as $key => $value)  {
	    		$nestedData=array();
                $nestedData[] = $count;
	            $nestedData[] = $value['file_number'];
	            $nestedData[] = $value['full_address'];
	            $nestedData[] = $value['partner_name'];
	            $nestedData[] = $value['safewire_order_status'];
	            $data[] = $nestedData;    
                $count++;          
	    	}
	    }
        $json_data['recordsTotal'] = intval( $safewire_orders_lists['recordsTotal'] );
        $json_data['recordsFiltered'] = intval( $safewire_orders_lists['recordsFiltered'] );
        $json_data['data'] = $data;
	    echo json_encode($json_data);
    }

    function lpOrders() 
    {
    	$params = array();
        if ($this->session->userdata('errors')) {
			$data['errors'] = $this->session->userdata('errors');
			$this->session->unset_userdata('errors');
		}
		if ($this->session->userdata('success')) {
			$data['success'] = $this->session->userdata('success');
			$this->session->unset_userdata('success');
		}
    	$salesRep = $this->sales_model->get_sales_reps($params);
    	$data['salesRep'] = $salesRep;
        $con = array(
            'where' => array(
                'is_master' => 1,
                'status' => 1,
            )
        );
        $product_type = $this->uri->segment(4);
        $master_users = $this->home_model->get_rows($con);
        $data['master_users'] = $master_users;
        $data['product_type'] = $product_type;
        $this->admintemplate->addCSS( base_url('assets/frontend/css/smart-forms.css'));
        $this->admintemplate->addJS( base_url('assets/backend/js/lp-order.js'));
        $this->admintemplate->show("order/order", "lp_orders", $data);
    	// $this->load->view('order/layout/header', $data);
        // $this->load->view('order/order/lp_orders', $data);
        // $this->load->view('order/layout/footer', $data);
    }

    function get_lp_order_list()
    {
    	$params = array();
        $params['length'] = $this->input->post('length');
        $params['start'] = $this->input->post('start');
        $params['order_type'] = 'lp_orders';
        $params['searchValue'] = isset($_POST['search']['value']) && !empty($_POST['search']['value']) ? $_POST['search']['value']: '';
        $params['sales_rep'] = $this->input->post('sales_rep');
        $params['start_date'] = $this->input->post('start_date');
        $params['end_date'] = $this->input->post('end_date');
        $params['product_type'] = $this->input->post('product_type');
       
        $pageno = ($params['start'] / $params['length'])+1; 
        $ordersList = $this->order_model->get_lp_orders($params);
        
        $data = array(); 
        $cnt = ($pageno == 1) ? ($params['start']+1) : (($pageno - 1) * $params['length']) + 1;
        $count = $params['start'] + 1;
        foreach( $ordersList['data'] as $key => $value )
        {
            $nestedData=array();
            $nestedData[] = $count;
            $nestedData[] = $value['lp_file_number'];
            $nestedData[] = $value['full_address'];
            $nestedData[] = $value['product_type'];
			$nestedData[] = $value['sales_rep_name'];
			$nestedData[] = $value['first_name']." ".$value['last_name'];
            $nestedData[] = $value['document_name'];
            $lp_report_status = $value['lp_report_status'];
            $disabled = '';
            if (empty($value['document_name'])) {
                $disabled = "disabled";
            }
            $lpReportStatusSelection ='<select '.$disabled.' onchange="updateLpReportStatus('.$value['file_id'].',this.value);" id="lp_report_status" name="lp_report_status">
                                <option value="">Select</option>
                                <option value="pending">Pending</option>
                                <option value="approved">Approved</option>
                                <option value="denied">Denied</option>
                            </select>'; 
            $lpReportStatusSelection = str_replace('value="' .  $lp_report_status . '"','value="' .  $lp_report_status . '" selected', $lpReportStatusSelection);          
            $nestedData[] = $lpReportStatusSelection;

            $property_id = $value['property_id'];
            // if ($value['allow_duplication'] == 1) {
            //     $checked = 'checked';
            // } else {
            //     $checked = '';
            // }
            // $nestedData[] = "<input $checked onclick='avoidDuplication();' style='height:30px;width:20px;' type='checkbox' id='$property_id' name='$property_id'>";
            
            
            $nestedData[] = !empty($value['file_number']) ? 'Yes' : 'No';
			$nestedData[] = convertTimezone($value['created_at']);
            $editOrderUrl = base_url().'order/admin/order-details/'.$value['file_id'];
            $file_id = $value['file_id'];
            $action = "<div style='display:flex;'><a href='".$editOrderUrl."' title ='View Order Detail'><i class='fas fa-eye' aria-hidden='true'></i></a><a style='margin-left:8px;' href='#' onclick='regenerateReport($file_id);' title ='Regenerate Report'><i class='fas fa-file' aria-hidden='true'></i></a>";

            if (empty($value['file_number'])) {
                $action .= "<a style='margin-left:5px;' href='#' onclick='sendOrderToResware($file_id);' title ='Resware Sync'><i class='fas fa-sync' aria-hidden='true'></i></a>";
            } 

            $documentUrl = env('AWS_PATH')."pre-listing-doc/".$value['document_name'];
            if (!empty($value['document_name'])) {
                $action .= "<a href='#' style='margin-left:5px;' title ='Download LP Report' onclick='downloadDocumentFromAws(".'"'.$documentUrl.'"'.", ".'"report"'.");'><i class='fas fa-fw fa-download'></i></a>
                     <a href='#' style='margin-left:5px;' title ='Select Document' onclick='getInstrumentData($file_id);'><i class='fa fa-external-link'></i></a></div> ";
            } else {
                $action .= "</div>";
            }
            // <i class="fa-solid fa-up-right-from-square"></i>
            $nestedData[] = $action;
            $data[] = $nestedData;            
            $count++;          
        }  
                      
        $json_data = array(            
            "recordsTotal"    => $ordersList['recordsTotal'],
            "recordsFiltered" => $ordersList['recordsFiltered'],
            "data" => $data 
        );

        echo json_encode($json_data);
    }

    function exportLpOrders()
    {
    	$sales_rep = $this->input->post('sales_rep');
    	$seachValue = $this->input->post('seachValue');
        
    	$params = array();
        $params['order_type'] = 'lp_orders';
    	$params['sales_rep'] = $sales_rep;
    	$params['seachValue'] = $seachValue;
        $params['start_date'] = $this->input->post('start_date');
        $params['end_date'] = $this->input->post('end_date');
        
    	$ordersList = $this->order_model->get_lp_orders($params);
        
    	if(isset($ordersList['data']) && !empty($ordersList['data']))
    	{
			$export_data = array();
    		foreach ($ordersList['data'] as $key => $value) 
    		{
    			$file_id = isset($value['file_id']) && !empty(!empty($value['file_id'])) ? $value['file_id'] : '';
    			if($file_id)
    			{
    				$export_data[] = array(
    					'order' => $value['lp_file_number'],
    					'file_id' => $value['file_id'],
    					'property_address' => $value['full_address'],
    					'product_type' => $value['product_type'],
    					'sales_rep' => $value['sales_rep_name'],
    					'owner_name' => $value['first_name'] . ' ' . $value['last_name'],
    					'report_status' => !empty($value['document_name']) ? $value['document_name'] : '',
    					'status' => $value['lp_report_status'],
    					'created_at' => $value['created_at']
    				);					
    			}    			
    		}
    		if(isset($export_data) && !empty($export_data))
    		{
    			if (!is_dir('uploads/orders')) {
			    	mkdir('./uploads/orders', 0777, TRUE);
				}

				$outputPath = './uploads/orders/output.csv';
	    		$output = fopen($outputPath, "w");

    			$header = array("Order #","File ID","Property Address","Product Type","Sales Rep","Lp Document Name","Report Status","Status","Created At");
				fputcsv($output, $header);

    			foreach ($export_data as $key => $value) 
    			{
    				fputcsv($output, $value);
    			}

    			header('Content-Type: application/json');
    			$contents = file_get_contents($outputPath);
    			$binaryData   = base64_encode($contents);
    			unlink($outputPath);
    			fclose($output);

    			$res = array('status'=>'success','data'=>$binaryData);	
    		}
    		else
	    	{
	    		$res = array('status'=>'error','data'=>'No data found.');
	    	}		
    	}
    	else
    	{
    		$res = array('status'=>'error','data'=>'No data found.');
    	}

    	echo json_encode($res); exit;
    }

    public function getInstrumentData()
    {
        $file_id = $this->input->post('file_id');
        $this->load->library('order/order');
        $this->db->select('*');
        $this->db->from('pct_order_title_point_data');
        $this->db->where('file_id', $file_id);
        $query = $this->db->get();
        $titlePointData = $query->row(); 

        $this->db->select('*');
        $this->db->from('pct_title_point_document_records');
        $this->db->where('title_point_id', $titlePointData->id);
        $query = $this->db->get();
        $instrumentRecords = $query->result_array(); 

        $displayDocList = $this->home_model->getDocumetTypes();
        $displayNoticeDocList = $this->home_model->getNoticeDocumetTypes();

        //echo in_array('NOT', array_column($displayNoticeDocList, 'doc_type'));
        //print_r($displayNoticeDocList);exit;

        $data = "<input type='hidden' id='title_point_id' name='title_point_id' value='$titlePointData->id'>
        <table class='table table-bordered' id='tbl-lp-orders-listing' width='100%' cellspacing='0'>
            <thead>
                <tr>
                    <th>Sr No</th>
                    <th>Document Name</th>
                    <th>Instrument</th>
                    <th>Recorded Date</th>
                    <th>Action</th>        
                </tr>
            </thead>
        <tbody>";

        $i = 0;
        $j = 0;
        $k = 0;
        $noticeArr = array();
        $filterArr = array();
        if (!empty($instrumentRecords)) {
            foreach ($instrumentRecords as $instrumentRecord) {
                if (in_array($instrumentRecord['document_type'], array_column($displayNoticeDocList, 'doc_type'))) {
                    
                    if (!empty($noticeArr)) {
                        if (isset($instrumentRecord['document_type']) && isset($instrumentRecord['document_sub_type']) && strlen($instrumentRecord['document_sub_type']) > 1) {
                            $docType = $instrumentRecord['document_type'].$instrumentRecord['document_sub_type'];
                            $filterNoticeExistKey = array_search($docType, array_column($noticeArr, 'document_type'));
                        } else if (isset($instrumentRecord['document_type'])) {
                            $filterNoticeExistKey = array_search($instrumentRecord['document_type'], array_column($noticeArr, 'document_type'));
                        }
                
                        if (strlen($filterNoticeExistKey) > 0) {
                            unset($noticeArr[$filterNoticeExistKey]);
                            $noticeArr = array_values($noticeArr); 
                            $j--;
                        }
                    }

                    $noticeArr[$j]['instrument'] = $instrumentRecord['instrument'];
                    if (isset($instrumentRecord['document_sub_type'])) {
                        $noticeArr[$j]['document_type'] = $instrumentRecord['document_type'].$instrumentRecord['document_sub_type'];
                    } else {
                        $noticeArr[$j]['document_type'] = $instrumentRecord['document_type'];
                    }
                    $j++;
                } else if (in_array($instrumentRecord['document_type'], array_column($displayDocList, 'doc_type'))) {
                    //echo $instrumentRecord['document_type']."----";
                    //print_r($displayDocList);
                    if (!empty($filterArr)) {
                        if (isset($instrumentRecord['document_type']) && isset($instrumentRecord['document_sub_type']) && strlen($instrumentRecord['document_sub_type']) > 1) {
                            $docType = $instrumentRecord['document_type'].$instrumentRecord['document_sub_type'];
                            $filterExistKey = array_search($docType, array_column($filterArr, 'document_type'));
                        } else if (isset($instrumentRecord['document_type'])) {
                            $filterExistKey = array_search($instrumentRecord['document_type'], array_column($filterArr, 'document_type'));
                        }
                
                        if (strlen($filterExistKey) > 0) {
                            unset($filterArr[$filterExistKey]);
                            $filterArr = array_values($filterArr); 
                            $k--;
                        }
                    }

                    $filterArr[$k]['instrument'] = $instrumentRecord['instrument'];
                    if (isset($instrumentRecord['document_sub_type'])) {
                        $filterArr[$k]['document_type'] = $instrumentRecord['document_type'].$instrumentRecord['document_sub_type'];
                    } else {
                        $filterArr[$k]['document_type'] = $instrumentRecord['document_type'];
                    }
                    $k++;
                } else {
                    $instrumentRecords[$i]['is_display'] = 0;
                }
                $i++;
            }
        }
          
        $i = 1;
        if (!empty($instrumentRecords)) {
            foreach ($instrumentRecords as $instrumentRecord) {
                if (strlen(array_search($instrumentRecord['instrument'], array_column($filterArr, 'instrument')))) {
                    $checked = "checked";                
                } else if (strlen(array_search($instrumentRecord['instrument'], array_column($noticeArr, 'instrument')))) {
                    $checked = "checked";                    
                } else {
                    $checked = "";
                }
                $document_name = $instrumentRecord['document_name'];
                $instrument = $instrumentRecord['instrument'];
                $recorded_date = $instrumentRecord['recorded_date'];
                $id = $instrumentRecord['id'];
                $data .= "<tr>
                            <td>$i</td>
                            <td>$document_name</td>
                            <td>$instrument</td>
                            <td>$recorded_date</td>
                            <td><input type='checkbox' id='$id' $checked name='instrument_number_ids[]' value='$id'></td>
                        </tr>";
                $i++;
            }
        } else {
            $data .= "<tr><td colspan='5'>No records found.</td></tr>";  
        }
        $data .= '</tbody></table>';
        if(!empty($data)) {
            $result = array('status'=> 'success', 'data' => $data);    
        } else {
            $result = array('status'=> 'error', 'data' => $data);   
        }
        echo json_encode($result); exit;
    }
    
}
