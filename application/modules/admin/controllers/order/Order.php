<?php

(defined('BASEPATH')) or exit('No direct script access allowed');

use PhpOffice\PhpSpreadsheet\IOFactory;
class Order extends MX_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->helper(['file', 'url']);
        $this->load->library('session');
        $this->load->library('order/adminTemplate');
        $this->load->model('order/order_model');
        $this->load->model('order/sales_model');
        $this->load->model('order/title_model');
        $this->load->model('order/home_model');
        $this->load->model('order/apiLogs');
        $this->load->library('order/common');
        $this->load->library('order/order');
        $this->common->is_admin();
    }

    public function orders()
    {
        $params           = [];
        $salesRep         = $this->sales_model->get_sales_reps($params);
        $data['salesRep'] = $salesRep;
        $con              = [
            'where' => [
                'is_master' => 1,
                'status'    => 1,
            ],
        ];
        $product_type         = $this->uri->segment(4);
        $master_users         = $this->home_model->get_rows($con);
        $data['master_users'] = $master_users;
        $data['product_type'] = $product_type;
        // $this->admintemplate->addCSS( base_url('assets/backend/hr/vendor/datatables/dataTables.bootstrap4.min.css'));
        // $this->admintemplate->addJS( base_url('assets/backend/hr/vendor/datatables/jquery.dataTables.min.js'));
        $this->admintemplate->addJS(base_url('assets/backend/js/order.js'));
        $this->admintemplate->show("order/order", "orders", $data);

        // $this->load->view('order/layout/header', $data);
        // $this->load->view('order/order/orders', $data);
        // $this->load->view('order/layout/footer', $data);
    }

    public function get_order_list()
    {
        $params                 = [];
        $params['length']       = $this->input->post('length');
        $params['start']        = $this->input->post('start');
        $params['order_type']   = 'softpro_orders';
        $params['searchValue']  = isset($_POST['search']['value']) && ! empty($_POST['search']['value']) ? $_POST['search']['value'] : '';
        $params['sales_rep']    = $this->input->post('sales_rep');
        $params['created_by']   = $this->input->post('created_by');
        $params['product_type'] = $this->input->post('product_type');

        $pageno     = ($params['start'] / $params['length']) + 1;
        $ordersList = $this->order_model->get_orders($params);
        // echo "<pre>";
        // print_r($ordersList);die;
        $data  = [];
        $cnt   = ($pageno == 1) ? ($params['start'] + 1) : (($pageno - 1) * $params['length']) + 1;
        $count = $params['start'] + 1;
        $this->load->model('order/sales_model');
        $sales_rep_lists = $this->sales_model->get_sales_reps(['sales_rep_enable' => 1]);
        $salesRepList    = '<select class="custom-select custom-select-sm form-control form-control-sm" onchange="updateSalesUserForOrder(transaction_id, this.value);" id="sales_rep" name="sales_rep">
        <option value="">Select Sales Rep</option>';
        if (isset($sales_rep_lists['data']) && ! empty($sales_rep_lists['data'])) {
            foreach ($sales_rep_lists['data'] as $key => $sales_rep) {
                $salesRepList .= '<option value="' . $sales_rep['id'] . '">' . $sales_rep['first_name'] . ' ' . $sales_rep['last_name'] . '</option>';
            }
        }

        $sp_sales_rep_lists = $this->sales_model->get_sp_sales_reps(['sales_rep_enable' => 1]);
        // print_r($sp_sales_rep_lists);die;
        $spSalesRepList    = '<select class="custom-select custom-select-sm form-control form-control-sm" onchange="updateSalesUserForOrder(transaction_id, this.value);" id="sales_rep" name="sales_rep">
        <option value="">Select Sales Rep</option>';
        if (isset($sp_sales_rep_lists['data']) && ! empty($sp_sales_rep_lists['data'])) {
            foreach ($sp_sales_rep_lists['data'] as $key => $sales_rep) {
                $spSalesRepList .= '<option value="' . $sales_rep['id'] . '">' . $sales_rep['first_name'] . ' ' . $sales_rep['last_name'] . '</option>';
            }
        }
        $spSalesRepList .= '</select>';
        // echo "<pre>";
        // print_r($ordersList['data']);die;
        foreach ($ordersList['data'] as $key => $value) {
            $nestedData   = [];
            $nestedData[] = $count;
            $nestedData[] = $value['file_number'];
            $nestedData[] = removeMultipleSpace($value['full_address']);
            if ($value['is_softpro_order'] == 1) {
                $nestedData[] = $value['sp_product_type'];
                if (empty($value['sp_sales_rep_name'])) {
                    $salesRepSelection = $spSalesRepList;
                    $salesRepSelection = str_replace('transaction_id', $value['transaction_id'], $salesRepSelection);
                    // $salesRepSelection = str_replace('value="' . $value['sales_rep_id'] . '"', 'value="' . $value['sales_rep_id'] . '" selected', $salesRepSelection);
                    $nestedData[] = $salesRepSelection;
                } else {
                    $nestedData[] = $value['sp_sales_rep_name'];
                }
            } 
            // else {
            //     $nestedData[] = $value['product_type'];
            //     if (empty($value['sales_rep_name'])) {
            //         $salesRepSelection = $salesRepList;
            //         $salesRepSelection = str_replace('transaction_id', $value['transaction_id'], $salesRepSelection);
            //         // $salesRepSelection = str_replace('value="' . $value['sales_rep_id'] . '"', 'value="' . $value['sales_rep_id'] . '" selected', $salesRepSelection);
            //         $nestedData[] = $salesRepSelection;
            //     } else {
            //         $nestedData[] = $value['sales_rep_name'];
            //     }
            // }
            $nestedData[] = $value['first_name'] . " " . $value['last_name'];
            $nestedData[] = $value['email_sent_status'] ? 'Sent' : 'Not sent';
            $property_id  = $value['property_id'];
            if ($value['allow_duplication'] == 1) {
                $checked = 'checked';
            } else {
                $checked = '';
            }
            $nestedData[] = "<input $checked onclick='avoidDuplication();' style='height:30px;width:20px;' type='checkbox' id='$property_id' name='$property_id'>";
            // $nestedData[] = date("m/d/Y h:i:s A", strtotime($value['created_at']));
            $nestedData[] = convertTimezone($value['created_at']);
            $editOrderUrl = base_url() . 'order/admin/order-details/' . $value['id'];
            $action       = "<div style='display: flex;justify-content: space-evenly;'><a href='" . $editOrderUrl . "' class='view-icon action-btn-padding' title ='View Order Detail'><span class='fas fa-eye' aria-hidden='true'></span></a>";
            if (strtolower($value['softpro_status']) != 'closed') {
                $action       .= "<a href='javascript:void(0);' onclick=syncSoftProOrders('".$value['file_number']."'); class='view-icon action-btn-padding' title ='Fetch latest data'><span class='fas fa-refresh' aria-hidden='true'></span></a>";
            }
            $action       .= "</div>";
            $nestedData[] = $action;
            $data[]       = $nestedData;
            $count++;
        }

        $json_data = [
            "recordsTotal"    => $ordersList['recordsTotal'],
            "recordsFiltered" => $ordersList['recordsFiltered'],
            "data"            => $data,
        ];

        echo json_encode($json_data);
    }

    public function order_details()
    {
        $order_id      = $this->uri->segment(4);
        $data          = [];
        $data['title'] = 'PCT Order: Order Details';

        if (isset($order_id) && ! empty($order_id)) {
            $order_details            = $this->order_model->get_order_details($order_id);
            $customer_id              = $order_details['customer_id'];
            $data['order_details']    = $order_details;
            // echo "<pre>";
            // print_r($data);exit;
            $this->admintemplate->show("order/order", "order_details", $data);
            // $this->load->view('order/layout/header', $data);
            // $this->load->view('order/order/order_details', $data);
            // $this->load->view('order/layout/footer', $data);

        } else {
            redirect('order/admin/orders');
        }
    }

    public function export_orders()
    {
        $sales_rep            = $this->input->post('sales_rep');
        $seachValue           = $this->input->post('seachValue');
        $params               = [];
        $params['sales_rep']  = $sales_rep;
        $params['seachValue'] = $seachValue;
        $params['order_type'] = 'resware_orders';
        // print_r($params);die;
        $ordersList = $this->order_model->get_orders($params);

        if (isset($ordersList['data']) && ! empty($ordersList['data'])) {
            $export_data = [];
            foreach ($ordersList['data'] as $key => $value) {
                $file_id = isset($value['file_id']) && ! empty(! empty($value['file_id'])) ? $value['file_id'] : '';
                if ($file_id) {
                    $order_details    = $this->order_model->get_order_details($file_id);
                    $con              = ['id' => $order_details['customer_id']];
                    $customer_details = $this->home_model->get_rows($con);
                    $export_data[]    = [
                        'file_number'                 => $order_details['file_number'],
                        'file_id'                     => $order_details['file_id'],
                        'opened_date'                 => $order_details['opened_date'],
                        'company_name'                => $customer_details['company_name'],
                        'email_address'               => $customer_details['email_address'],
                        'first_name'                  => $customer_details['first_name'],
                        'last_name'                   => $customer_details['last_name'],
                        'telephone_no'                => $customer_details['telephone_no'],
                        'street_address'              => $customer_details['street_address'],
                        'city'                        => $customer_details['city'],
                        'zip_code'                    => $customer_details['zip_code'],
                        'full_address'                => $order_details['full_address'],
                        'apn'                         => $order_details['apn'],
                        'county'                      => $order_details['county'],
                        'legal_description'           => $order_details['legal_description'],
                        'primary_owner'               => $order_details['primary_owner'],
                        'secondary_owner'             => $order_details['secondary_owner'],
                        'borrower'                    => $order_details['borrower'],
                        'secondary_borrower'          => $order_details['secondary_borrower'],
                        'sales_rep_name'              => $order_details['sales_rep_name'],
                        'title_officer_name'          => $order_details['title_officer_name'],
                        'product_type'                => $order_details['product_type'],
                        'loan_amount'                 => $order_details['loan_amount'],
                        'sales_amount'                => $order_details['sales_amount'],
                        'loan_number'                 => $order_details['loan_number'],
                        'escrow_number'               => $order_details['escrow_number'],
                        'notes'                       => $order_details['notes'],
                        'additional_email'            => $order_details['additional_email'],
                        'additional_email_1'          => $order_details['additional_email_1'],
                        'additional_email_2'          => $order_details['additional_email_2'],
                        'buyer_agent_name'            => $order_details['buyer_agent_name'],
                        'buyer_agent_email_address'   => $order_details['buyer_agent_email_address'],
                        'buyer_agent_company'         => $order_details['buyer_agent_company'],
                        'buyer_agent_telephone_no'    => $order_details['buyer_agent_telephone_no'],
                        'listing_agent_name'          => $order_details['listing_agent_name'],
                        'listing_agent_email_address' => $order_details['listing_agent_email_address'],
                        'listing_agent_company'       => $order_details['listing_agent_company'],
                        'listing_agent_telephone_no'  => $order_details['listing_agent_telephone_no'],
                        'escrow_lender_company_name'  => $order_details['escrow_lender_company_name'],
                        'escrow_lender_first_name'    => $order_details['escrow_lender_first_name'],
                        'escrow_lender_last_name'     => $order_details['escrow_lender_last_name'],
                        'escrow_lender_email'         => $order_details['escrow_lender_email'],
                        'escrow_lender_telephone_no'  => $order_details['escrow_lender_telephone_no'],
                    ];
                }
            }
            if (isset($export_data) && ! empty($export_data)) {
                if (! is_dir('uploads/orders')) {
                    mkdir('./uploads/orders', 0777, true);
                }

                $outputPath = './uploads/orders/output.csv';
                $output     = fopen($outputPath, "w");

                $header = ["Order #", "File ID", "Order Open At", "Company Name", "Email Address", "First Name", "Last Name", "Telephone", "Street Address", "City", "Zipcode", "Property Address", "APN", "County", "Brief Legal Description", "Primary Owner", "Secondary Owner", "Primary Borrower", "Secondary Borrower", "Sales Rep", "Title Officer", "Product", "Loan Amount", "Sales Amount", "Loan Number", "Escrow Number", "Notes", "Additional Email Address", "Additional Email Address1", "Additional Email Address2", "Buyer Agent Name", "Buyer Agent Email Address", "Buyer Agent Comapny", "Buyer Agent Telephone", "Listing Agent Name", "Listing Agent Email Address", "Listing Agent Comapny", "Listing Agent Telephone", "Lender/Escrow Name", "Lender/Escrow Email Address", "Lender/Escrow Comapny", "Lender/Escrow Telephone"];
                fputcsv($output, $header);

                foreach ($export_data as $key => $value) {
                    fputcsv($output, $value);
                }

                header('Content-Type: application/json');
                $contents   = file_get_contents($outputPath);
                $binaryData = base64_encode($contents);
                unlink($outputPath);
                fclose($output);

                $res = ['status' => 'success', 'data' => $binaryData];
            } else {
                $res = ['status' => 'error', 'data' => 'No data found.'];
            }
        } else {
            $res = ['status' => 'error', 'data' => 'No data found.'];
        }

        echo json_encode($res);
        exit;
    }

    public function partnerApiLogs()
    {
        $data          = [];
        $data['title'] = 'PCT Order: Partner Api Log';

        $salesRep         = $this->sales_model->get_sales_reps([]);
        $data['salesRep'] = $salesRep;

        $titleOfficer = $this->title_model->get_title_officers([]);

        $data['titleOfficer'] = $titleOfficer;
        $this->admintemplate->show("order/home", "partner_api_logs", $data);
        // $this->load->view('order/layout/header', $data);
        // $this->load->view('order/home/partner_api_logs', $data);
        // $this->load->view('order/layout/footer', $data);
    }

    public function get_partner_api_logs()
    {
        $this->load->model('order/partnerApiLogs');

        $params = [];

        if (isset($_POST['draw']) && ! empty($_POST['draw'])) {
            $params['draw']        = isset($_POST['draw']) && ! empty($_POST['draw']) ? $_POST['draw'] : 10;
            $params['length']      = isset($_POST['length']) && ! empty($_POST['length']) ? $_POST['length'] : 10;
            $params['start']       = isset($_POST['start']) && ! empty($_POST['start']) ? $_POST['start'] : 0;
            $params['orderColumn'] = isset($_POST['order'][0]['column']) && ! empty($_POST['order'][0]['column']) ? $_POST['order'][0]['column'] : 0;
            $params['orderDir']    = isset($_POST['order'][0]['dir']) && ! empty($_POST['order'][0]['dir']) ? $_POST['order'][0]['dir'] : 0;

            $params['searchvalue'] = isset($_POST['search']['value']) && ! empty($_POST['search']['value']) ? $_POST['search']['value'] : '';
            // $params['status']['cs4_result_id_status'] = 'Success';

            $pageno                  = ($params['start'] / $params['length']) + 1;
            $params['sales_rep']     = $this->input->post('sales_rep');
            $params['title_officer'] = $this->input->post('title_officer');

            $logs_list = $this->partnerApiLogs->get_partner_api_logs($params);

            // $cnt = ($pageno == 1) ? ($params['start']+1) : (($pageno - 1) * $params['length']) + 1;

            $json_data['draw'] = intval($params['draw']);
        } else {
            $params['searchvalue'] = isset($_POST['keyword']) && ! empty($_POST['keyword']) ? $_POST['keyword'] : '';
            $logs_list             = $this->partnerApiLogs->get_partner_api_logs($params);
        }
        $data  = [];
        $count = $params['start'] + 1;
        if (isset($logs_list['data']) && ! empty($logs_list['data'])) {
            foreach ($logs_list['data'] as $key => $value) {
                $nestedData   = [];
                $nestedData[] = $count;
                $nestedData[] = $value['file_number'];
                $nestedData[] = $value['title_officer_name'];
                $nestedData[] = $value['sales_rep_name'];
                if (! empty($value['underwriter'])) {
                    if ($value['underwriter'] == 'north_american') {
                        // $nestedData[] = 'North American Title Insurance Company';
                        $nestedData[] = 'Doma Title Insurance, Inc. fka NATIC';
                    } else if ($value['underwriter'] == 'commonwealth') {
                        $nestedData[] = 'Commonwealth Land Title Insurance Company';
                    } else if ($value['underwriter'] == 'westcor') {
                        $nestedData[] = 'Westcor Land Title Insurance Company';
                    } else {
                        $nestedData[] = '';
                    }
                } else {
                    if (strpos($value['cpl_document_name'], 'natic') !== false) {
                        // $nestedData[] = 'North American Title Insurance Company';
                        $nestedData[] = 'Doma Title Insurance, Inc. fka NATIC';
                    } else if (strpos($value['cpl_document_name'], 'fnf') !== false) {
                        $nestedData[] = 'Commonwealth Land Title Insurance Company';
                    } else if (strpos($value['cpl_document_name'], 'westcor') !== false) {
                        $nestedData[] = 'Westcor Land Title Insurance Company';
                    } else {
                        $nestedData[] = '';
                    }
                }
                $response_data = $value['response_data'];
                $response      = json_decode($response_data, true);
                if (empty($response)) {
                    $nestedData[] = 'Success';
                } else {
                    $msg          = isset($response['ResponseStatus']['Message']) && ! empty($response['ResponseStatus']['Message']) ? $response['ResponseStatus']['Message'] : '';
                    $nestedData[] = $msg;
                }
                // $nestedData[] = date("m/d/Y h:i:s A", strtotime($value['created_at']));
                $nestedData[] = convertTimezone($value['created_at']);
                $data[]       = $nestedData;
                $count++;
            }
        }
        $json_data['recordsTotal']    = intval($logs_list['recordsTotal']);
        $json_data['recordsFiltered'] = intval($logs_list['recordsFiltered']);
        $json_data['data']            = $data;
        echo json_encode($json_data);
    }

    public function update_order_details()
    {
        $this->load->model('order/partnerApiLogs');
        $logs_list = $this->partnerApiLogs->get_api_logs();
        $count     = 0;
        foreach ($logs_list as $key => $value) {
            $url = $value['request_url'];

            $path          = parse_url($url, PHP_URL_PATH);
            $a             = explode('/', $path);
            $file_id       = $a[3];
            $order_details = $this->order_model->get_order_details($file_id);
            $id            = $order_details['order_id'];

            $condition = ['id' => $id];

            $data = ['partner_api_log_id' => $value['id']];

            $update = $this->order_model->update($data, $condition);
            if ($update) {
                $count++;
            }
        }
        echo "<pre>";
        print_r($count);
        exit;
    }

    public function cplErrorLogs()
    {
        $data          = [];
        $data['title'] = 'PCT Order: CPL Api Error Logs';
        $this->admintemplate->show("order/home", "cpl_error_api_logs", $data);
        // $this->load->view('order/layout/header', $data);
        // $this->load->view('order/home/cpl_error_api_logs', $data);
        // $this->load->view('order/layout/footer', $data);
    }

    public function getCplErrorLogs()
    {
        $params = [];
        if (isset($_POST['draw']) && ! empty($_POST['draw'])) {
            $params['draw']        = isset($_POST['draw']) && ! empty($_POST['draw']) ? $_POST['draw'] : 10;
            $params['length']      = isset($_POST['length']) && ! empty($_POST['length']) ? $_POST['length'] : 10;
            $params['start']       = isset($_POST['start']) && ! empty($_POST['start']) ? $_POST['start'] : 0;
            $params['orderColumn'] = isset($_POST['order'][0]['column']) && ! empty($_POST['order'][0]['column']) ? $_POST['order'][0]['column'] : 0;
            $params['orderDir']    = isset($_POST['order'][0]['dir']) && ! empty($_POST['order'][0]['dir']) ? $_POST['order'][0]['dir'] : 0;
            $params['searchvalue'] = isset($_POST['search']['value']) && ! empty($_POST['search']['value']) ? $_POST['search']['value'] : '';
            $pageno                = ($params['start'] / $params['length']) + 1;
            $cpl_logs_list         = $this->home_model->getCplErrorLogs($params);
            $json_data['draw']     = intval($params['draw']);
        } else {
            $params['searchvalue'] = isset($_POST['keyword']) && ! empty($_POST['keyword']) ? $_POST['keyword'] : '';
            $cpl_logs_list         = $this->home_model->getCplErrorLogs($params);
        }
        $data  = [];
        $count = $params['start'] + 1;
        if (isset($cpl_logs_list['data']) && ! empty($cpl_logs_list['data'])) {
            foreach ($cpl_logs_list['data'] as $key => $value) {
                $nestedData   = [];
                $nestedData[] = $count;
                $nestedData[] = $value['file_number'];
                $nestedData[] = $value['cpl_page'];
                $nestedData[] = $value['error'];
                // $nestedData[] = date("m/d/Y h:i:s A", strtotime($value['created_at']));
                $nestedData[] = convertTimezone($value['created_at']);
                $data[]       = $nestedData;
                $count++;
            }
        }
        $json_data['recordsTotal']    = intval($cpl_logs_list['recordsTotal']);
        $json_data['recordsFiltered'] = intval($cpl_logs_list['recordsFiltered']);
        $json_data['data']            = $data;
        echo json_encode($json_data);
    }

    public function reswareLogs()
    {
        $data          = [];
        $data['title'] = 'PCT Order: Resware API Logs';
        $this->admintemplate->show("order/home", "resware_api_log", $data);
    }

    public function getReswareLogs()
    {
        $params = [];
        if (isset($_POST['draw']) && ! empty($_POST['draw'])) {
            $params['draw']        = isset($_POST['draw']) && ! empty($_POST['draw']) ? $_POST['draw'] : 10;
            $params['length']      = isset($_POST['length']) && ! empty($_POST['length']) ? $_POST['length'] : 10;
            $params['start']       = isset($_POST['start']) && ! empty($_POST['start']) ? $_POST['start'] : 0;
            $params['orderColumn'] = isset($_POST['order'][0]['column']) && ! empty($_POST['order'][0]['column']) ? $_POST['order'][0]['column'] : 0;
            $params['orderDir']    = isset($_POST['order'][0]['dir']) && ! empty($_POST['order'][0]['dir']) ? $_POST['order'][0]['dir'] : 0;
            $params['searchvalue'] = isset($_POST['search']['value']) && ! empty($_POST['search']['value']) ? $_POST['search']['value'] : '';
            $pageno                = ($params['start'] / $params['length']) + 1;
            $resware_logs_list     = $this->home_model->getReswareLogs($params);
            $json_data['draw']     = intval($params['draw']);
        } else {
            $params['searchvalue'] = isset($_POST['keyword']) && ! empty($_POST['keyword']) ? $_POST['keyword'] : '';
            $resware_logs_list     = $this->home_model->getReswareLogs($params);
        }
        $data  = [];
        $count = $params['start'] + 1;
        if (isset($resware_logs_list['data']) && ! empty($resware_logs_list['data'])) {
            foreach ($resware_logs_list['data'] as $key => $value) {
                $nestedData   = [];
                $nestedData[] = $count;
                $nestedData[] = $value['request_type'];
                $nestedData[] = $value['request_url'];
                $nestedData[] = $value['request'];
                $nestedData[] = $value['response'];
                // $nestedData[] = date("m/d/Y h:i:s A", strtotime($value['created_at']));
                $nestedData[] = convertTimezone($value['created_at']);
                $data[]       = $nestedData;
                $count++;
            }
        }
        $json_data['recordsTotal']    = intval($resware_logs_list['recordsTotal']);
        $json_data['recordsFiltered'] = intval($resware_logs_list['recordsFiltered']);
        $json_data['data']            = $data;
        echo json_encode($json_data);
    }

    public function safewireOrders()
    {
        $data          = [];
        $data['title'] = 'PCT Order: Safewire Orders';
        $this->load->view('order/layout/header', $data);
        $this->load->view('order/home/safewire_orders', $data);
        $this->load->view('order/layout/footer', $data);
    }

    public function get_safewire_orders_list()
    {
        $params = [];
        if (isset($_POST['draw']) && ! empty($_POST['draw'])) {
            $params['draw']        = isset($_POST['draw']) && ! empty($_POST['draw']) ? $_POST['draw'] : 10;
            $params['length']      = isset($_POST['length']) && ! empty($_POST['length']) ? $_POST['length'] : 10;
            $params['start']       = isset($_POST['start']) && ! empty($_POST['start']) ? $_POST['start'] : 0;
            $params['orderColumn'] = isset($_POST['order'][0]['column']) && ! empty($_POST['order'][0]['column']) ? $_POST['order'][0]['column'] : 0;
            $params['orderDir']    = isset($_POST['order'][0]['dir']) && ! empty($_POST['order'][0]['dir']) ? $_POST['order'][0]['dir'] : 0;
            $params['searchvalue'] = isset($_POST['search']['value']) && ! empty($_POST['search']['value']) ? $_POST['search']['value'] : '';
            $safewire_orders_lists = $this->order_model->get_safewire_orders_list($params);
            $json_data['draw']     = intval($params['draw']);
        } else {
            $params['searchvalue'] = isset($_POST['keyword']) && ! empty($_POST['keyword']) ? $_POST['keyword'] : '';
            $safewire_orders_lists = $this->order_model->get_safewire_orders_list($params);
        }

        $data  = [];
        $count = $params['start'] + 1;
        if (isset($safewire_orders_lists['data']) && ! empty($safewire_orders_lists['data'])) {
            foreach ($safewire_orders_lists['data'] as $key => $value) {
                $nestedData   = [];
                $nestedData[] = $count;
                $nestedData[] = $value['file_number'];
                $nestedData[] = $value['full_address'];
                $nestedData[] = $value['partner_name'];
                $nestedData[] = $value['safewire_order_status'];
                $data[]       = $nestedData;
                $count++;
            }
        }
        $json_data['recordsTotal']    = intval($safewire_orders_lists['recordsTotal']);
        $json_data['recordsFiltered'] = intval($safewire_orders_lists['recordsFiltered']);
        $json_data['data']            = $data;
        echo json_encode($json_data);
    }

    public function lpOrders()
    {
        $params = [];
        if ($this->session->userdata('errors')) {
            $data['errors'] = $this->session->userdata('errors');
            $this->session->unset_userdata('errors');
        }
        if ($this->session->userdata('success')) {
            $data['success'] = $this->session->userdata('success');
            $this->session->unset_userdata('success');
        }
        $salesRep         = $this->sales_model->get_sales_reps($params);
        $data['salesRep'] = $salesRep;
        $con              = [
            'where' => [
                'is_master' => 1,
                'status'    => 1,
            ],
        ];
        $product_type         = $this->uri->segment(4);
        $master_users         = $this->home_model->get_rows($con);
        $data['master_users'] = $master_users;
        $data['product_type'] = $product_type;
        $this->admintemplate->addCSS(base_url('assets/frontend/css/smart-forms.css?v=6'));
        $this->admintemplate->addJS(base_url('assets/backend/js/lp-order.js?v=6'));
        $this->admintemplate->show("order/order", "lp_orders", $data);
        // $this->load->view('order/layout/header', $data);
        // $this->load->view('order/order/lp_orders', $data);
        // $this->load->view('order/layout/footer', $data);
    }

    public function importRevenueData()
    {
        ini_set('max_execution_time', 0); 
        ini_set('memory_limit','2048M');
        $this->load->library('form_validation');
        $data = array();
        $data['title'] = 'PCT Order: Import Revenue Data';
        if(!empty($_FILES))
            {
            $configData    = $this->common->getConfigData();
            $enableSurveyEmailFlag = $configData['enable_survey_email']['is_enable'];
            // Form field validation rules
            $this->form_validation->set_rules('file', 'CSV file', 'callback_file_check');
            // $salesBillCode = ['TPC', 'TPW'];
            $billCodeFilter = ['TPC', 'TPW', 'ESC', 'TSGW', 'UPRE'];
            // Validate submitted form data
            if($this->form_validation->run($this) == true)
            {
                $document_name           = time() . "_" . $_FILES['file']['name'];
                
                $config['upload_path']   = './uploads/';
                $config['allowed_types'] = 'xls|xlsx';
                $config['max_size']      = 12000;
                $config['file_name'] = $document_name;
                
                $this->load->library('upload', $config);
                $updateCount = 0;

                if (! $this->upload->do_upload('file')) {
                    $data['error_msg'] = $this->upload->display_errors();
                } else {
                    $fileData = $this->upload->data();
                    $filePath = './uploads/' . $fileData['file_name'];

                    $spreadsheet = IOFactory::load($filePath);
                    $sheet = $spreadsheet->getActiveSheet();
                    // echo "<pre>";
                    // print_r($sheet->toArray());die;
                    $sheetData = $sheet->toArray();
                    $updateData = [];
                    if (!empty($sheetData) && count($sheetData) > 1) {
                        $query = $this->db->select('id, product_type')
                            ->from('pct_softpro_product_type')
                            ->get();

                        $productTypeList = array_column($query->result_array(), 'id', 'product_type');

                        $query = $this->db->select('id, order_type')
                            ->from('pct_softpro_order_type')
                            ->get();

                        $orderTypeList = array_column($query->result_array(), 'id', 'order_type');


                        foreach ($sheetData as $key => $data) {
                            if ($key == 0) {
                                $columnNames = $data;
                            } else {
                                $rowData = array();
                                if (in_array($data[8], $billCodeFilter)) {
                                    $amt = $data[42];
                                    // If value is wrapped in parentheses, it's negative
                                    // if ($data[2] == '20006649-GLT') {
                                    //     print_r($data);
                                    // } else {
                                    //     continue;
                                    // }
                                    if (preg_match('/^\(.*\)$/', $amt)) {
                                        $amt = str_replace(['(', ')'], '', $amt);
                                        $amt = (float) str_replace(['$', ','], '', $amt);
                                        $amt = round($amt, 2);
                                        $amount = $amt * -1;
                                        // echo 'amt ===' . $amt . ' ********** ' . $amount . "\n";
                                    } else {
                                        $amt = (float) str_replace(['$', ','], '', $amt);
                                        $amount = round($amt, 2);
                                        // echo 'amt ===' . $amt . ' ********** ' . $amount . "\n";
                                        // $amount = (float)$amt;
                                    }
                                    // $premium = 0;
                                    // if (in_array($data[8], $salesBillCode) && str_contains(strtolower($data[4]), 'ledger transfer')) {
                                    //     if ($data[8] == 'TPC') {
                                    //         $premium = ($amount/0.88);
                                    //         // $updateData[$data[2]]['premium'] += ($amount/0.88);
                                    //     } else if ($data[8] == 'TPW') {
                                    //         $premium = ($amount/0.9);
                                    //         // $updateData[$data[2]]['premium'] += ($amount/0.9);
                                    //     }
                                    // }
                                    
                                    if (array_key_exists($data[2], $updateData)) { 
                                        $updateData[$data[2]]['premium'] += $amount;
                                        // $updateData[$data[2]]['amount'] += $amount;
                                    } else {
                                        $updateData[$data[2]] = [
                                            'order_number' => $data[2],
                                            'transaction_date' => $data[3],
                                            'bill_code' => $data[8],
                                            'transaction_type' => trim($data[15]),
                                            'sales_rep' => $data[26],
                                            'full_address' => $data[29],
                                            'address' => $data[30],
                                            'city' => $data[34],
                                            'state' => $data[33],
                                            'zip' => $data[32],
                                            'country' => $data[35],
                                            'premium' => $amount,
                                            // 'amount' => $amount,
                                            'order_type' => trim($data[48]),
                                            'escrow_closed_date' => $data[17],
                                            'profile' => $data[1],
                                        ];
                                    }
                                }
                                /*if (in_array($data[8], $billCodeFilter) && str_contains(strtolower($data[4]), 'ledger transfer')) {
                                    $amount = (float) str_replace(['$', ','], '', $data[42]);
                                    $amount = round($amount, 2);
                                    if (array_key_exists($data[2], $updateData)) { 
                                        if ($data[8] == 'TPC') {
                                            $updateData[$data[2]]['premium'] += ($amount/0.88);
                                        } else if ($data[8] == 'TPW') {
                                            $updateData[$data[2]]['premium'] += ($amount/0.9);
                                        }
                                    } else {
                                        if ($data[8] == 'TPC') {
                                            $amt = $amount/0.88;
                                        } else if ($data[8] == 'TPW') {
                                            $amt = $amount/0.9;
                                        }
                                        $updateData[$data[2]] = [
                                            'order_number' => $data[2],
                                            'transaction_date' => $data[3],
                                            'bill_code' => $data[8],
                                            'transaction_type' => trim($data[15]),
                                            'sales_rep' => $data[26],
                                            'full_address' => $data[29],
                                            'address' => $data[30],
                                            'city' => $data[34],
                                            'state' => $data[33],
                                            'zip' => $data[32],
                                            'country' => $data[35],
                                            'premium' => $amt,
                                            'amount' => $amount,
                                            'order_type' => trim($data[48]),
                                            'escrow_closed_date' => $data[17],
                                            'profile' => $data[1],
                                        ];

                                    }
                                }*/
                            }
                        }
                        // print_r($updateData);die;
                        if (!empty($updateData)) {
                            $closedOrderFileNumbers = [];
                            foreach ($updateData as $key => $value) {
                                // echo "<pre>";
                                // print_r($value);
                                // $value['order_number'] = "TEST-20001451-OCT";
                                $orderDetails = $this->db->select('id, property_id, transaction_id, escrow_officer_id, softpro_status, file_number, is_softpro_order, survey_notification_sent')->from('order_details')->where(['file_number' => trim($value['order_number']), 'is_softpro_order' => 1])->get()->row_array();
                                if (!empty($orderDetails)) {
                                    $salesRepDetails = $this->db->select('id')->from('pct_softpro_lookup_table')->where('full_name', $value['sales_rep'])->get()->row_array();

                                    // echo 'productTypeList';
                                    // print_r($productTypeList);
                                    // echo 'orderTypeList';
                                    // print_r($orderTypeList);
                                    // echo 'order details';
                                    // print_r($orderDetails);
                                    // echo 'salesRepDetails';
                                    // print_r($salesRepDetails);
                                    // print_r($value);
                                    // $transactionDate = date('Y-m-d', strtotime($value['transaction_date']));
                                    $updateOrderDetails = [
                                        'profile' => $value['profile'],
                                        'premium' => $value['premium'],
                                        'bill_code' => $value['bill_code'],
                                        'transaction_date' => date('Y-m-d', strtotime($value['transaction_date'])),
                                        // 'softpro_status' => 'closed',
                                        'sent_to_accounting_date' => date('Y-m-d H:i:s', strtotime($value['transaction_date'])),
                                        // 'resware_closed_status_date' => date('Y-m-d H:i:s', strtotime($value['transaction_date'])),
                                        'updated_at'                 => date("Y-m-d H:i:s")
                                    ];
                                    if (!empty($value['transaction_type'])) {
                                        $updateOrderDetails['prod_type'] = $value['transaction_type'];
                                        $updateTransactionDetails['transaction_type'] = $value['transaction_type'];
                                    }

                                    $id = $this->db->update('order_details', $updateOrderDetails, ['file_number' => $value['order_number']]);
                                    $activity  = 'Revenue data update for order :' . $value['order_number'] . ' and premium amount :' . $value['premium'] . ' Sales reps: ' . $value['sales_rep'] . ' Transaction Date: ' . $value['transaction_date'] . ' Bill Code: ' . $value['bill_code'];
                                    $this->order_model->logAdminActivity($activity);
                                    $updateCount++;
                                    // echo 'id ==' . $id;
                                    
                                    if (!empty($salesRepDetails)) {
                                        $updateTransactionDetails['sales_representative'] = $salesRepDetails['id'];
                                    }
                                    if (!empty($value['order_type']) && !empty($orderTypeList[$value['order_type']])) {
                                        $updateTransactionDetails['order_type'] = $orderTypeList[$value['order_type']];
                                    }
                                    // if (!empty($value['transaction_type'])) {
                                    //     $updateTransactionDetails['transaction_type'] = $value['transaction_type'];
                                    // }
                                    if (!empty($updateTransactionDetails)) {
                                        $this->db->update('transaction_details', $updateTransactionDetails, array('id' => $orderDetails['transaction_id']));
                                    }
                                    if ($enableSurveyEmailFlag == 1 && !$orderDetails['survey_notification_sent']) {
                                        $emailQueueData = [
                                            'file_number' => $value['order_number'],
                                            'email_type' => 'survey'
                                        ];
                                        // $this->db->insert('pct_email_queue', $emailQueueData);
                                        if (!$this->db->get_where('pct_email_queue', $emailQueueData)->num_rows()) {
                                            $this->db->insert('pct_email_queue', $emailQueueData);
                                        }
                                    }

                                    // if (($orderDetails['softpro_status'] != 'closed' && $orderDetails['softpro_status'] != 'completed')) {
                                    //     $emailQueueData = [
                                    //         'file_number' => $value['order_number'],
                                    //         'email_type' => 'closed_order'
                                    //     ];
                                    //     $this->db->insert('pct_email_queue', $emailQueueData);
                                    // }
    
                                    // if (!empty($value['full_address'])) {
                                    //     $updatePropertyDetails = [
                                    //         'full_address' => $value['full_address'],
                                    //         'address' => $value['address'],
                                    //         'city' => $value['city'],
                                    //         'state' => $value['state'],
                                    //         'zip' => $value['zip'],
                                    //         'county' => $value['country']
                                    //     ];
                                    //     $this->db->update('property_details', $updatePropertyDetails, array('id' => $orderDetails['property_id']));
                                    // }
    
                                    // echo 'updateOrderDetails';
                                    // print_r($updateOrderDetails);
                                    // echo 'updateTransactionDetails';
                                    // print_r($updateTransactionDetails);die;
                                }
                            }
                        }
                        // echo "hello <pre>";
                        // print_r($updateData);die;
                        
                        unlink('uploads/' . $fileData['file_name']);
                        $this->session->set_flashdata('revenue_success', 'Data updated for total ' . $updateCount . ' Orders');
                    }
                }
                
            }
            else
            {
                $this->session->set_flashdata('revenue_error', 'Invalid file, please select only CSV file.');
                $data['error_msg'] = form_error('file');
                // echo form_error('file');die;
            }
        }
        $this->admintemplate->show("order/order", "import_revenue", $data);
        // $this->load->view('order/layout/header', $data);
        // $this->load->view('order/agent/import', $data);
        // $this->load->view('order/layout/footer', $data);
    }

    public function file_check($str)
    {
        $allowed_mime_types = array('text/x-comma-separated-values','application/vnd.openxmlformats-officedocument.spreadsheetml.sheet', 'text/comma-separated-values', 'application/octet-stream', 'application/vnd.ms-excel', 'application/x-csv', 'text/x-csv', 'text/csv', 'application/csv', 'application/excel', 'application/vnd.msexcel', 'text/plain');
        if(isset($_FILES['file']['name']) && $_FILES['file']['name'] != "")
        {
            $mime = get_mime_by_extension($_FILES['file']['name']);
            $fileAr = explode('.', $_FILES['file']['name']);
            $ext = end($fileAr);
            // print_r($mime);
            // echo "<br>";
            // print_r($ext);die;
            if(($ext == 'xlsx' || $ext == 'xls') && in_array($mime, $allowed_mime_types)){
                return true;
            }else{
                $this->form_validation->set_message('file_check', 'Please select only xlsx or xls file to upload.');
                return false;
            }
        }
        else
        {
            $this->form_validation->set_message('file_check', 'Please select a xlsx or xls file to upload.');
            return false;
        }
    }

    public function searchDocumentType()
    {
        $seachValue = $this->input->post('doc_type');
        if (empty($seachValue)) {
            return;
        }
        $displayDocList = $this->home_model->getSearchDocList($seachValue);
        $result         = ['status' => 'success', 'data' => $displayDocList];

        echo json_encode($result);
        exit;
    }

    public function searchDocumentSubType()
    {
        $seachValue = $this->input->post('doc_type');
        if (empty($seachValue)) {
            return;
        }
        $displayDocList = $this->home_model->getSearchDocSubList($seachValue);
        $result         = ['status' => 'success', 'data' => $displayDocList];

        echo json_encode($result);
        exit;
    }

    public function get_lp_order_list()
    {
        $params                 = [];
        $params['length']       = $this->input->post('length');
        $params['start']        = $this->input->post('start');
        $params['order_type']   = 'lp_orders';
        $params['searchValue']  = isset($_POST['search']['value']) && ! empty($_POST['search']['value']) ? $_POST['search']['value'] : '';
        $params['sales_rep']    = $this->input->post('sales_rep');
        $params['start_date']   = $this->input->post('start_date');
        $params['end_date']     = $this->input->post('end_date');
        $params['product_type'] = $this->input->post('product_type');

        $pageno     = ($params['start'] / $params['length']) + 1;
        $ordersList = $this->order_model->get_lp_orders($params);

        $data  = [];
        $cnt   = ($pageno == 1) ? ($params['start'] + 1) : (($pageno - 1) * $params['length']) + 1;
        $count = $params['start'] + 1;
        foreach ($ordersList['data'] as $key => $value) {
            $fileNumber  = $value['lp_file_number'];
            $orderNumber = $value['lp_file_number'];
            if (! empty($value['file_number'])) {
                $number      = $value['file_number'];
                $orderNumber = $number;
                $fileNumber  = '<span data-title="' . $number . '">' . $value['lp_file_number'] . '</span>';
            }
            $nestedData   = [];
            $nestedData[] = $count;
            $nestedData[] = $fileNumber; //$value['lp_file_number'] . '(' .')';
            $nestedData[] = $value['full_address'];
            if ($value['is_softpro_order'] == 1) {
                $nestedData[] = $value['sp_product_type'];
                $nestedData[] = $value['sp_sales_rep_name'];
            } 
            // else {
            //     $nestedData[] = $value['product_type'];
            //     $nestedData[] = $value['sales_rep_name'];
            // }
            $nestedData[] = $value['first_name'] . " " . $value['last_name'];
            $nestedData[] = $value['email_sent_status'] ? 'Sent' : 'Not sent';
            //$nestedData[] = $value['document_name'];
            $lp_report_status = $value['lp_report_status'] ?? '';
            $disabled         = '';
            $orderId          = $value['id'];
            if (empty($value['document_name'])) {
                $disabled = "disabled";
            }
            $lpReportStatusSelection = '<select class="custom-select custom-select-sm form-control form-control-sm" ' . $disabled . ' onchange="updateLpReportStatus(' . $orderId . ',this.value);" id="lp_report_status" name="lp_report_status">
                                <option value="">Select</option>
                                <option value="pending">Pending</option>
                                <option value="approved">Approved</option>
                                <option value="denied">Denied</option>
                                <option value="converted">Converted</option>
                            </select>';
            $lpReportStatusSelection = str_replace('value="' . $lp_report_status . '"', 'value="' . $lp_report_status . '" selected', $lpReportStatusSelection);
            $nestedData[]            = $lpReportStatusSelection;

            $property_id = $value['property_id'];
            if ($value['allow_duplication'] == 1) {
                $checked = 'checked';
            } else {
                $checked = '';
            }
            $nestedData[] = "<input $checked onclick='avoidDuplication();' style='height:30px;width:20px;' type='checkbox' id='$property_id' name='$property_id'>";

            $nestedData[] = ! empty($value['file_number']) ? 'Yes' : 'No';
            $nestedData[] = convertTimezone($value['created_at']);
            $editOrderUrl = base_url() . 'order/admin/order-details/' . $orderId;
            $action       = "<div class='dropdown'>
                <a class='btn dropdown-toggle click-action-type' type='button' data-toggle='dropdown' href='#'>Click Action Type
                    <span class='caret'></span>
                </a>
                <ul class='dropdown-menu' style='width:210px !important;max-width:none !important;'>
                    <li>
                        <a href='" . $editOrderUrl . "' title ='View Order Detail'>
                            <button class='btn btn-grad-2a button-color' type='button'>
                                <i class='fas fa-eye' aria-hidden='true' style='margin-right:5px;'></i>
                                View
                            </button>
                        </a>
                    </li>
                    <li>
                        <a href='#' onclick='regenerateReport($orderId);' title ='Regenerate Report'>
                            <button class='btn btn-grad-2a button-color' type='button'>
                                <i class='fas fa-file' aria-hidden='true' style='margin-right:5px;'></i>
                                Regenerate Report
                            </button>
                        </a>
                    </li>
                    <li>
                        <a href='#' onclick='addVesting($orderId);' title ='Vesting'>
                            <button class='btn btn-grad-2a button-color' type='button'>
                                <i class='fas fa-institution' aria-hidden='true' style='margin-right:5px;'></i>
                                Add Vesting
                            </button>
                        </a>
                    </li>";

            if (empty($value['file_number'])) {
                $action .= "<li>
                        <a href='#' onclick='changeClient($orderId);' title ='Change Client'>
                            <button class='btn btn-grad-2a button-color' type='button'>
                                <i class='fas fa-edit' aria-hidden='true' style='margin-right:5px;'1></i>
                                Change Client
                            </button>
                        </a>
                    </li>
                    <li>
                        <a href='#' onclick='sendOrderToSoftpro($orderId);' title ='Resware Sync'>
                            <button class='btn btn-grad-2a button-color' type='button'>
                                <i class='fas fa-sync' aria-hidden='true' style='margin-right:5px;'></i>
                                Send Order Softpro
                            </button>
                        </a>
                    </li>";
            }

            $documentUrl = env('AWS_PATH') . "pre-listing-doc/" . $value['document_name'];
            if (! empty($value['document_name'])) {
                $action .= "<li>
                    <a href='#' title ='Download LP Report' onclick='downloadDocumentFromAws(" . '"' . $documentUrl . '"' . ", " . '"report"' . ");'>
                        <button class='btn btn-grad-2a button-color' type='button'>
                            <i class='fas fa-fw fa-download' style='margin-right:5px;'></i>
                            Download Lp Report
                        </button>
                    </a>
                </li>
                <li>
                    <a href='#' title ='Select Document' onclick='getInstrumentData($orderId);'>
                        <button class='btn btn-grad-2a button-color' type='button'>
                            <i class='fa fa-external-link' style='margin-right:5px;'></i>
                            Get Instrument Data
                        </button>
                    </a>
                </li>";
            }
            $action .= "<li>
                    <a href='#' title ='File Upload' onclick='fileUpload($orderId);'>
                        <button class='btn btn-grad-2a button-color' type='button'>
                            <i class='fa fa-upload' style='margin-right:5px;'></i>
                            Upload Doc
                        </button>
                    </a>
                </li></ul></div>";
            // <i class="fa-solid fa-up-right-from-square"></i>
            $nestedData[] = $action;
            $data[]       = $nestedData;
            $count++;
        }

        $json_data = [
            "recordsTotal"    => $ordersList['recordsTotal'],
            "recordsFiltered" => $ordersList['recordsFiltered'],
            "data"            => $data,
        ];

        echo json_encode($json_data);
    }

    public function exportLpOrders()
    {
        $sales_rep  = $this->input->post('sales_rep');
        $seachValue = $this->input->post('seachValue');

        $params               = [];
        $params['order_type'] = 'lp_orders';
        $params['sales_rep']  = $sales_rep;
        $params['seachValue'] = $seachValue;
        $params['start_date'] = $this->input->post('start_date');
        $params['end_date']   = $this->input->post('end_date');

        $ordersList = $this->order_model->get_lp_orders($params);

        if (isset($ordersList['data']) && ! empty($ordersList['data'])) {
            $export_data = [];
            foreach ($ordersList['data'] as $key => $value) {
                $file_id = isset($value['file_id']) && ! empty(! empty($value['file_id'])) ? $value['file_id'] : '';
                if ($file_id) {
                    $export_data[] = [
                        'order'            => $value['lp_file_number'],
                        'file_id'          => $value['file_id'],
                        'property_address' => $value['full_address'],
                        'product_type'     => $value['product_type'],
                        'sales_rep'        => $value['sales_rep_name'],
                        'owner_name'       => $value['first_name'] . ' ' . $value['last_name'],
                        'report_status'    => ! empty($value['document_name']) ? $value['document_name'] : '',
                        'status'           => $value['lp_report_status'],
                        'report_link'      => 'https://pct-doc.s3-us-west-2.amazonaws.com/pre-listing-doc/pre_listing_report_' . $value['lp_file_number'] . '.pdf',
                        'created_at'       => $value['created_at'],
                    ];
                }
            }
            if (isset($export_data) && ! empty($export_data)) {
                if (! is_dir('uploads/orders')) {
                    mkdir('./uploads/orders', 0777, true);
                }

                $outputPath = './uploads/orders/output.csv';
                $output     = fopen($outputPath, "w");

                $header = ["Order #", "File ID", "Property Address", "Product Type", "Sales Rep", "Lp Document Name", "Document Name Status", "Status", "Report Link", "Created At"];
                fputcsv($output, $header);

                foreach ($export_data as $key => $value) {
                    fputcsv($output, $value);
                }

                header('Content-Type: application/json');
                $contents   = file_get_contents($outputPath);
                $binaryData = base64_encode($contents);
                unlink($outputPath);
                fclose($output);

                $res = ['status' => 'success', 'data' => $binaryData];
            } else {
                $res = ['status' => 'error', 'data' => 'No data found.'];
            }
        } else {
            $res = ['status' => 'error', 'data' => 'No data found.'];
        }

        echo json_encode($res);
        exit;
    }

    public function getInstrumentData()
    {
        $file_id = $this->input->post('file_id');
        $this->load->library('order/order');
        $this->db->select('*');
        $this->db->from('pct_order_title_point_data');
        $this->db->where('file_id', $file_id);
        $query          = $this->db->get();
        $titlePointData = $query->row();

        $this->db->select('*');
        $this->db->from('pct_title_point_document_records');
        $this->db->where('title_point_id', $titlePointData->id);
        $query             = $this->db->get();
        $instrumentRecords = $query->result_array();

        $displayDocList       = $this->home_model->getDocumetTypes();
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

        $i         = 0;
        $j         = 0;
        $k         = 0;
        $noticeArr = [];
        $filterArr = [];
        if (! empty($instrumentRecords)) {
            foreach ($instrumentRecords as $instrumentRecord) {
                if (in_array($instrumentRecord['document_type'], array_column($displayNoticeDocList, 'doc_type'))) {

                    if (! empty($noticeArr)) {
                        if (isset($instrumentRecord['document_type']) && isset($instrumentRecord['document_sub_type']) && strlen($instrumentRecord['document_sub_type']) > 1) {
                            $docType              = $instrumentRecord['document_type'] . $instrumentRecord['document_sub_type'];
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
                        $noticeArr[$j]['document_type'] = $instrumentRecord['document_type'] . $instrumentRecord['document_sub_type'];
                    } else {
                        $noticeArr[$j]['document_type'] = $instrumentRecord['document_type'];
                    }
                    $j++;
                } else if (in_array($instrumentRecord['document_type'], array_column($displayDocList, 'doc_type'))) {
                    //echo $instrumentRecord['document_type']."----";
                    //print_r($displayDocList);
                    if (! empty($filterArr)) {
                        if (isset($instrumentRecord['document_type']) && isset($instrumentRecord['document_sub_type']) && strlen($instrumentRecord['document_sub_type']) > 1) {
                            $docType        = $instrumentRecord['document_type'] . $instrumentRecord['document_sub_type'];
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
                        $filterArr[$k]['document_type'] = $instrumentRecord['document_type'] . $instrumentRecord['document_sub_type'];
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
        if (! empty($instrumentRecords)) {
            foreach ($instrumentRecords as $instrumentRecord) {
                if (strlen(array_search($instrumentRecord['instrument'], array_column($filterArr, 'instrument')))) {
                    $checked = "checked";
                } else if (strlen(array_search($instrumentRecord['instrument'], array_column($noticeArr, 'instrument')))) {
                    $checked = "checked";
                } else {
                    $checked = "";
                }
                $document_name = $instrumentRecord['document_name'];
                $instrument    = $instrumentRecord['instrument'];
                $recorded_date = $instrumentRecord['recorded_date'];
                $id            = $instrumentRecord['id'];
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
        if (! empty($data)) {
            $result = ['status' => 'success', 'data' => $data];
        } else {
            $result = ['status' => 'error', 'data' => $data];
        }
        echo json_encode($result);
        exit;
    }

    public function getDetailsByName()
    {
        $searchTerm = isset($_POST['term']) && ! empty($_POST['term']) ? $_POST['term'] : '';
        $condition  = [
            'company_name' => $searchTerm,
        ];
        $condition['where']['is_sales_rep'] = 0;
        $userDetails                        = $this->home_model->get_customers_search($condition);
        $userInfo                           = [];

        if (isset($userDetails) && ! empty($userDetails)) {
            foreach ($userDetails as $key => $value) {
                $data['id']                       = isset($value['id']) && ! empty($value['id']) ? $value['id'] : '';
                $data['value']                    = isset($value['value']) && ! empty($value['value']) ? $value['value'] : '';
                $data['partner_id']               = isset($value['partner_id']) && ! empty($value['partner_id']) ? $value['partner_id'] : '';
                $data['name']                     = isset($value['full_name']) && ! empty($value['full_name']) ? $value['full_name'] : '';
                $data['fname']                    = isset($value['first_name']) && ! empty($value['first_name']) ? $value['first_name'] : '';
                $data['lname']                    = isset($value['last_name']) && ! empty($value['last_name']) ? $value['last_name'] : '';
                $data['email_address']            = isset($value['email_address']) && ! empty($value['email_address']) ? $value['email_address'] : '';
                $data['telephone_no']             = isset($value['telephone_no']) && ! empty($value['telephone_no']) ? $value['telephone_no'] : '';
                $data['company']                  = isset($value['company_name']) && ! empty($value['company_name']) ? $value['company_name'] : '';
                $data['address']                  = isset($value['street_address']) && ! empty($value['street_address']) ? $value['street_address'] : '';
                $data['city']                     = isset($value['city']) && ! empty($value['city']) ? $value['city'] : '';
                $data['state']                    = isset($value['state']) && ! empty($value['state']) ? $value['state'] : '';
                $data['zip_code']                 = isset($value['zip_code']) && ! empty($value['zip_code']) ? $value['zip_code'] : '';
                $data['is_escrow']                = isset($value['is_escrow']) && ! empty($value['is_escrow']) ? $value['is_escrow'] : '';
                $data['assignment_clause']        = isset($value['assignment_clause']) && ! empty($value['assignment_clause']) ? $value['assignment_clause'] : '';
                $data['is_primary_mortgage_user'] = isset($value['is_primary_mortgage_user']) && ! empty($value['is_primary_mortgage_user']) ? $value['is_primary_mortgage_user'] : '';
                // array_push($userInfo, $data);
                $userInfo[] = $data;
            }
        }
        echo json_encode($userInfo);
    }
}
