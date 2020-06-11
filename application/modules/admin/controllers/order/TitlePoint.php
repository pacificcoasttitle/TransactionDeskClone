<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class TitlePoint extends MX_Controller {

	public function __construct()
    {
        parent::__construct();
        $this->load->helper(
            array('file', 'url','form')
        );
        $this->load->library('form_validation');
        $this->load->model('order/titlePoint_model');
    }

	public function index()
	{
        $this->is_admin();
		$data = array();
        $data['title'] = 'PCT Order: LV Log';
        $this->load->view('order/layout/header', $data);
        $this->load->view('order/home/lv_logs', $data);
        $this->load->view('order/layout/footer', $data);
	}

    public function get_logs()
    {
        $params = array();
       
        if(isset($_POST['draw']) && !empty($_POST['draw']))
        {
            $params['draw'] = isset($_POST['draw']) && !empty($_POST['draw']) ? $_POST['draw'] : 10;
            $params['length'] = isset($_POST['length']) && !empty($_POST['length']) ? $_POST['length'] : 10;
            $params['start'] = isset($_POST['start']) && !empty($_POST['start']) ? $_POST['start'] : 0;
            $params['orderColumn'] = isset($_POST['order'][0]['column']) && !empty($_POST['order'][0]['column']) ? $_POST['order'][0]['column'] : 0;
            $params['orderDir'] = isset($_POST['order'][0]['dir']) && !empty($_POST['order'][0]['dir']) ? $_POST['order'][0]['dir'] : 0;

            $params['searchvalue'] = isset($_POST['search']['value']) && !empty($_POST['search']['value']) ? $_POST['search']['value'] : '';
            $params['status']['cs4_result_id_status'] = 'Success';

            $pageno = ($params['start'] / $params['length'])+1;

            $titlePointData = $this->titlePoint_model->gettitlePointDetails($params);

            // $cnt = ($pageno == 1) ? ($params['start']+1) : (($pageno - 1) * $params['length']) + 1;

            $json_data['draw'] = intval( $params['draw'] );
        }
        else
        {
            $params['searchvalue'] = isset($_POST['keyword']) && !empty($_POST['keyword']) ? $_POST['keyword'] : '';
            $titlePointData = $this->titlePoint_model->gettitlePointDetails($params);          
        }
        $data = array(); 
        if(isset($titlePointData) && !empty($titlePointData))
        {
            foreach ($titlePointData as $key => $value) 
            {
                
                $file_id = isset($value['file_id']) && !empty($value['file_id']) ? $value['file_id'] : '';
                if(isset($file_id) && empty($file_id))
                {
                    $order_details = $this->titlePoint_model->get_order_details($file_id);

                    $nestedData=array();
                    /*$nestedData[] = $value['customer_number'];*/
                    $nestedData[] = $value['file_number'];
                    $nestedData[] = $order_details['full_address'];
                    $nestedData[] = $value['cs4_result_id_status'];
                    $data[] = $nestedData;
                }
                
            }
        }
        
        $json_data['recordsTotal'] = intval( $customer_lists['recordsTotal'] );
        $json_data['recordsFiltered'] = intval( $customer_lists['recordsFiltered'] );
        $json_data['data'] = $data;
        echo json_encode($json_data);
    }

    public function is_admin()
    {
        $userdata = $this->session->userdata('admin');
        if (!empty($userdata['id']) && $userdata['is_admin'] == 1) {

        } else {
            redirect(base_url().'order/admin');
        }
    }

    public function make_request($http_method, $endpoint, $body_params='', $login_details)
    {
        $details = json_decode($login_details,TRUE);
        $login =  $details['email'];
        
        if ($login == 'ghernandez@pct.com') {
            $password= 'Alpha637#';
        }elseif ($login == 'teamrestine@eatonescrow.com') {
            $password= 'Pacific12';
        } else {
            $password= 'Pacific2';
        }

        $ch = curl_init(RESWARE_ORDER_API.$endpoint);                                    
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $http_method);                        
        curl_setopt($ch, CURLOPT_POSTFIELDS, $body_params);                   
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
        curl_setopt($ch, CURLOPT_USERPWD, "$login:$password");
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(                                
            'Content-Type: application/json',
            'Content-Length: ' . strlen($body_params))                                 
        ); 
        $error_msg = curl_error($ch);
        $result = curl_exec($ch);
        return $result;
    }
}