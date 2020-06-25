<?php

(defined('BASEPATH')) OR exit('No direct script access allowed');

class Order extends MX_Controller {

	function __construct() {
        parent::__construct();
        $this->load->helper(array('file', 'url'));
        $this->load->library('session');
        $this->load->model('order/order_model');
        $this->load->model('order/sales_model');
        $this->load->model('order/home_model');
    }

    function orders() {
    	$params = array();
    	$salesRep = $this->sales_model->get_sales_reps($params);
    	$data['salesRep'] = $salesRep;
    	$this->load->view('order/layout/header', $data);
        $this->load->view('order/order/orders', $data);
        $this->load->view('order/layout/footer', $data);
    }

    function get_order_list()
    {
    	$params = array();
        $params['length'] = $this->input->post('length');
        $params['start'] = $this->input->post('start');
        /*$params['orderColumn'] = $this->input->post('order.0.column');
        $params['orderDir'] = $this->input->post('order.0.dir');*/
        $params['searchValue'] = isset($_POST['search']['value']) && !empty($_POST['search']['value']) ? $_POST['search']['value']: '';
        $params['sales_rep'] = $this->input->post('sales_rep');
       
        $pageno = ($params['start'] / $params['length'])+1; 
        $ordersList = $this->order_model->get_orders($params);   
        
        $data = array(); 
        $cnt = ($pageno == 1) ? ($params['start']+1) : (($pageno - 1) * $params['length']) + 1;  
        foreach( $ordersList['data'] as $key => $value )
        {
            $nestedData=array();          
            $nestedData[] = $value['file_number'];
            $nestedData[] = $value['full_address'];
            $nestedData[] = $value['product_type'];
            $nestedData[] = $value['sales_rep_name'];
            $editOrderUrl = base_url().'order/admin/order-details/'.$value['file_id'];
            $action = "<a href='".$editOrderUrl."' class='btn btn-xs view-icon action-btn-padding' title ='View Order Detail'><span class='fa fa-eye' aria-hidden='true'></span></a>";
            $nestedData[] = $action;
            $data[] = $nestedData;            
            $cnt++;            
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
        $this->is_admin();
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
        	$this->load->view('order/layout/header', $data);
	        $this->load->view('order/order/order_details', $data);
	        $this->load->view('order/layout/footer', $data);
        	
        }
        else
        {
            redirect('order/admin/orders');
        }
    }

    public function is_admin()
    {
        $userdata = $this->session->userdata('admin');

        if (!empty($userdata['id']) && $userdata['is_admin'] == 1) {

        } else {
            redirect(base_url().'order/admin');
        }
    }
}