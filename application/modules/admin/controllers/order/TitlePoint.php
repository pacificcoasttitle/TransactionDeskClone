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
            $params['dateRange'] = isset($_POST['dateRange']) && !empty($_POST['dateRange']) ? $_POST['dateRange'] : '';
            $params['lvLog'] = isset($_POST['lvLog']) && !empty($_POST['lvLog']) ? $_POST['lvLog'] : '';
            // $params['status']['cs4_result_id_status'] = 'Success';

            $pageno = ($params['start'] / $params['length'])+1;

            $logs_list = $this->titlePoint_model->getLvLogs($params);

            // $cnt = ($pageno == 1) ? ($params['start']+1) : (($pageno - 1) * $params['length']) + 1;

            $json_data['draw'] = intval( $params['draw'] );
        }
        else
        {
            $params['searchvalue'] = isset($_POST['keyword']) && !empty($_POST['keyword']) ? $_POST['keyword'] : '';
            $params['dateRange'] = isset($_POST['dateRange']) && !empty($_POST['dateRange']) ? $_POST['dateRange'] : '';
            $params['lvLog'] = isset($_POST['lvLog']) && !empty($_POST['lvLog']) ? $_POST['lvLog'] : '';
            $logs_list = $this->titlePoint_model->getLvLogs($params);          
        }
        $data = array();

        if(isset($logs_list['data']) && !empty($logs_list['data']))
        {
            $count = $params['start'] + 1;
            foreach ($logs_list['data'] as $key => $value) 
            {
                $file_id = isset($value['file_id']) && !empty($value['file_id']) ? $value['file_id'] : '';
                if(isset($file_id) && !empty($file_id))
                {
                    $order_details = $this->titlePoint_model->get_order_details($file_id);

                    $nestedData=array();
                    
                    $nestedData[] = $count;
                    $nestedData[] = $value['file_number'];
                    $nestedData[] = $order_details['full_address'];
                    
                    $lv_file_path = FCPATH.'uploads/legal-vesting/'.$value['file_number'].'.pdf';

                    if (file_exists($lv_file_path) || file_exists(FCPATH.'uploads/legal-vesting/LV'.$value['file_number'].'.pdf')) 
                    {
                        $nestedData[] = 'success';
                    }
                    else if((strtolower($value['lv_file_status']) != 'success') && !empty($value['lv_file_status']))
                    {
                        $nestedData[] = $value['lv_file_status'];
                    }
                    else if(empty($value['lv_file_status']) && (strtolower($value['cs4_message']) == 'success'))
                    {
                        $nestedData[] = 'Failed';
                    }
                    else
                    {
                        $nestedData[] = $value['cs4_message'];
                    }
                    $nestedData[] = date("m/d/Y h:i:s A", strtotime($value['created_at']));

                    $data[] = $nestedData;
                    $count++;
                }
            }
        }
        $json_data['recordsTotal'] = intval( $logs_list['recordsTotal'] );
        $json_data['recordsFiltered'] = intval( $logs_list['recordsFiltered'] );
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

        $ch = curl_init(env('RESWARE_ORDER_API').$endpoint);                                    
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

    public function taxLog()
    {
        $this->is_admin();
        $data = array();
        $data['title'] = 'PCT Order: Tax Log';
        $this->load->view('order/layout/header', $data);
        $this->load->view('order/home/tax_logs', $data);
        $this->load->view('order/layout/footer', $data);
    }

    public function get_tax_logs()
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
            $params['dateRange'] = isset($_POST['dateRange']) && !empty($_POST['dateRange']) ? $_POST['dateRange'] : '';
            $params['taxLog'] = isset($_POST['taxLog']) && !empty($_POST['taxLog']) ? $_POST['taxLog'] : '';

            $pageno = ($params['start'] / $params['length'])+1;

            $logs_list = $this->titlePoint_model->getTaxLogs($params);

            // $cnt = ($pageno == 1) ? ($params['start']+1) : (($pageno - 1) * $params['length']) + 1;

            $json_data['draw'] = intval( $params['draw'] );
        }
        else
        {
            $params['searchvalue'] = isset($_POST['keyword']) && !empty($_POST['keyword']) ? $_POST['keyword'] : '';
            $params['dateRange'] = isset($_POST['dateRange']) && !empty($_POST['dateRange']) ? $_POST['dateRange'] : '';
            $params['taxLog'] = isset($_POST['taxLog']) && !empty($_POST['taxLog']) ? $_POST['taxLog'] : '';
            $logs_list = $this->titlePoint_model->getTaxLogs($params);          
        }
        $data = array(); 
        
        if(isset($logs_list['data']) && !empty($logs_list['data']))
        {
            $count = $params['start'] + 1;
            foreach ($logs_list['data'] as $key => $value) 
            {
                $file_id = isset($value['file_id']) && !empty($value['file_id']) ? $value['file_id'] : '';
                if(isset($file_id) && !empty($file_id))
                {
                    $order_details = $this->titlePoint_model->get_order_details($file_id);

                    $nestedData=array();
                    /*$nestedData[] = $value['customer_number'];*/
                    $nestedData[] = $count;
                    $nestedData[] = $value['file_number'];
                    $nestedData[] = $order_details['full_address'];
                    $nestedData[] = $order_details['apn'];
                    
                    /*if(strtolower($value['cs3_message']) == 'success')
                    {
                        if(strtolower($value['tax_file_status']) == 'success')
                        {
                            $nestedData[] = $value['tax_file_status'];
                        }
                        else
                        {
                            $nestedData[] = $value['tax_file_message']; 
                        }
                    }
                    else
                    {
                        
                        $tax_file_path = FCPATH.'uploads/tax/'.$value['file_number'].'.pdf';

                        if (file_exists($tax_file_path)) 
                        {
                            $nestedData[] = 'success';
                        }
                        else if(strtolower($value['tax_file_status']) != 'success')
                        {
                            $nestedData[] = $value['tax_file_status'];
                        }
                        else
                        {
                            $nestedData[] = isset($value['cs3_message']) && !empty($value['cs3_message']) ? $value['cs3_message'] : 'Failed';
                        }
                        
                    }*/

                    $tax_file_path = FCPATH.'uploads/tax/'.$value['file_number'].'.pdf';

                    if (file_exists($tax_file_path)) 
                    {
                        $nestedData[] = 'success';
                    }
                    else if((strtolower($value['tax_file_status']) != 'success') && !empty($value['tax_file_status']))
                    {
                        $nestedData[] = $value['tax_file_status'];
                    }
                    else if(empty($value['tax_file_status']) && (strtolower($value['cs3_message']) == 'success'))
                    {
                        $nestedData[] = 'Failed';
                    }
                    else
                    {
                        $nestedData[] = $value['cs3_message'];
                    }
                    // $nestedData[] = $value['cs3_message'];
                    $nestedData[] = date("m/d/Y h:i:s A", strtotime($value['created_at']));
                    $data[] = $nestedData;
                    $count++;
                }
            }
        }
        $json_data['recordsTotal'] = intval( $logs_list['recordsTotal'] );
        $json_data['recordsFiltered'] = intval( $logs_list['recordsFiltered'] );
        $json_data['data'] = $data;
        echo json_encode($json_data);
    }

    public function grantDeedLog()
    {
        $this->is_admin();
        $data = array();
        $data['title'] = 'PCT Order: Grant Deed Log';
        $this->load->view('order/layout/header', $data);
        $this->load->view('order/home/grant_deed_logs', $data);
        $this->load->view('order/layout/footer', $data);
    }

    public function get_grant_deed_logs()
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
            $params['dateRange'] = isset($_POST['dateRange']) && !empty($_POST['dateRange']) ? $_POST['dateRange'] : '';
            $params['grantLog'] = isset($_POST['grantLog']) && !empty($_POST['grantLog']) ? $_POST['grantLog'] : '';
            $pageno = ($params['start'] / $params['length'])+1;

            $logs_list = $this->titlePoint_model->getGrantDeedLogs($params);

            // $cnt = ($pageno == 1) ? ($params['start']+1) : (($pageno - 1) * $params['length']) + 1;

            $json_data['draw'] = intval( $params['draw'] );
        }
        else
        {
            $params['searchvalue'] = isset($_POST['keyword']) && !empty($_POST['keyword']) ? $_POST['keyword'] : '';
            $params['dateRange'] = isset($_POST['dateRange']) && !empty($_POST['dateRange']) ? $_POST['dateRange'] : '';
            $params['grantLog'] = isset($_POST['grantLog']) && !empty($_POST['grantLog']) ? $_POST['grantLog'] : '';
            $logs_list = $this->titlePoint_model->getGrantDeedLogs($params);          
        }
        $data = array(); 
        
        if(isset($logs_list['data']) && !empty($logs_list['data']))
        {
            $count = $params['start'] + 1;
            foreach ($logs_list['data'] as $key => $value) 
            {
                $file_id = isset($value['file_id']) && !empty($value['file_id']) ? $value['file_id'] : '';
                if(isset($file_id) && !empty($file_id))
                {
                    $order_details = $this->titlePoint_model->get_order_details($file_id);
                    

                    $nestedData=array();
                    
                    $nestedData[] = $count;
                    $nestedData[] = $value['file_number'];
                    $nestedData[] = $order_details['full_address'];
                    $nestedData[] = $value['grant_deed_type'];

                    $deed_file_path = FCPATH.'uploads/grant-deed/'.$value['file_number'].'.pdf';

                    if (file_exists($deed_file_path)) 
                    {
                        $nestedData[] = 'Success';
                    }
                    elseif (strtolower($value['grant_deed_message']) != 'success') 
                    {
                        $nestedData[] = $value['grant_deed_message'];
                    }
                    else
                    {
                        $nestedData[] = 'Failed';
                    }
                    
                    
                    $nestedData[] = date("m/d/Y h:i:s A", strtotime($value['created_at']));
                    $data[] = $nestedData;
                    $count++;
                }
            }
        }
        $json_data['recordsTotal'] = intval( $logs_list['recordsTotal'] );
        $json_data['recordsFiltered'] = intval( $logs_list['recordsFiltered'] );
        $json_data['data'] = $data;
        echo json_encode($json_data);
    }
}