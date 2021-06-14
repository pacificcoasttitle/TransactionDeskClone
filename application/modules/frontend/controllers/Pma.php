<?php
(defined('BASEPATH')) OR exit('No direct script access allowed');
class Pma extends MX_Controller {
    private $user;
	function __construct() 
    {
        parent::__construct();
        $userdata = $this->session->userdata('user');
        if(empty($userdata) || !isset($userdata['is_master']) || $userdata['is_master'] != 1) {
            redirect('dashboard');
        }
        $this->user = $userdata;
        
        $this->load->model('order/home_model');
        $this->load->library('order/order');
    }

    function index()
    {   
        $data['title'] = 'PMA | Pacific Coast Title Company';

        $this->load->view('layout/head_dashboard',$data);
        $this->load->view('pma/list');
    }

    function task($action='fetchItems')
    {   
        
    }

    function proxy()
    {
        $arrContextOptions=array(
            "ssl"=>array(
                "verify_peer"=>false,
                "verify_peer_name"=>false,
            ),
        );  


        $request = $_GET['requrl'];
        $request = 'http://pct.com/pma/proxy.php?requrl='.urlencode($request);
        // echo $request;die;

        $file = file_get_contents($request, false, stream_context_create($arrContextOptions));
        echo $file;

        // $request = str_replace('^', '<', $request);
        // $api_key = env('BLACK_KNIGHT_KEY');        

        // $request .= '&key=' . $api_key;
        // $file = file_get_contents($request, false, stream_context_create($arrContextOptions));
        // echo $file;
    }

    function rep_list()
    {
        $condition = array(
            'where' => array(
                'is_sales_rep' => 1,
                'status' => 1,
            )
        );
        $salesReps = $this->home_model->getSalesRepDetails($condition);
        $options = '';
        $options .= '<option value="">Select Rep</option>';
        foreach ($salesReps as $salesRep) {
            $options .= '<option value="'.$salesRep['user_id_pk'].'">'.$salesRep['first_name'].' '.$salesRep['last_name'].'</option>';
        }
        echo $options;
    }

    function pma_data(){
        
    }

    

    

    
}