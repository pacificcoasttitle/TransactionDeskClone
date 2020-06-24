<?php

(defined('BASEPATH')) OR exit('No direct script access allowed');

class Order extends MX_Controller {

	function __construct() {
        parent::__construct();
        $this->load->helper(array('file', 'url'));
        $this->load->library('session');
        $this->load->model('order/order_model');
        $this->load->model('order/sales_model');
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

            $action = "<a href='#' class='btn btn-xs view-icon action-btn-padding' title ='Edit Customer Detail'><span class='fa fa-edit' aria-hidden='true'></span></a>";
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
}