<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Sales extends MX_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->helper(
            array('file', 'url','form')
        );
        $this->load->library('form_validation');
        $this->load->library('order/order');
        $this->load->model('order/sales_model');
        $this->load->library('order/common');
        $this->common->is_admin();
    }

    public function index()
    {
        $data = array();
        
        $data['title'] = 'PCT Order: Sales Rep.';
        $this->load->view('order/layout/header', $data);
        $this->load->view('order/sales/sales', $data);
        $this->load->view('order/layout/footer', $data);
    }

    public function get_sales_rep_list()
    {
        $params = array();  $data = array();
        if (isset($_POST['draw']) && !empty($_POST['draw'])) {
            $params['draw'] = isset($_POST['draw']) && !empty($_POST['draw']) ? $_POST['draw'] : 10;
            $params['length'] = isset($_POST['length']) && !empty($_POST['length']) ? $_POST['length'] : 2;
            $params['start'] = isset($_POST['start']) && !empty($_POST['start']) ? $_POST['start'] : 0;
            $params['orderColumn'] = isset($_POST['order'][0]['column']) && !empty($_POST['order'][0]['column']) ? $_POST['order'][0]['column'] : 0;
            $params['orderDir'] = isset($_POST['order'][0]['dir']) && !empty($_POST['order'][0]['dir']) ? $_POST['order'][0]['dir'] : 0;
            $params['searchvalue'] = isset($_POST['search']['value']) && !empty($_POST['search']['value']) ? $_POST['search']['value'] : '';
            $pageno = ($params['start'] / $params['length'])+1;
            $sales_rep_lists = $this->sales_model->get_sales_reps($params);
            $json_data['draw'] = intval( $params['draw'] );
        } else {
            $params['searchvalue'] = isset($_POST['keyword']) && !empty($_POST['keyword']) ? $_POST['keyword'] : '';
            $sales_rep_lists = $this->sales_model->get_sales_reps($params);
        }
        
        if (isset($sales_rep_lists['data']) && !empty($sales_rep_lists['data'])) {
            foreach ($sales_rep_lists['data'] as $key => $value)  {
               // echo "<pre>"; print_r($value); exit;
                $nestedData=array();
                $nestedData[] = $value['first_name']." ".$value['last_name'];
                // $nestedData[] = $value['name'];
                $nestedData[] = $value['email_address'];
                $nestedData[] = $value['telephone_no'];
                $nestedData[] = $value['partner_id'];
                $nestedData[] = $value['partner_type_id'];
                $nestedData[] = ($value['is_mail_notification'] == 1) ? 'On' : 'Off';
                
                if (isset($_POST['draw']) && !empty($_POST['draw'])) {
                    $editOrderUrl = base_url().'order/admin/edit-sales-rep/'.$value['id'];
                    $action = "<a href='".$editOrderUrl."' class='btn btn-action edit-agent'title ='Edit Sales Rep Detail'><span class='fa fa-edit' aria-hidden='true'></span></a>";
                    $action .= "<a href='javascript:void(0);' onclick='deleteSalesRep(".$value['id'].")' class='btn btn-action'  title='Delete Sales Rep'><span class='fa fa-trash' aria-hidden='true'></span></a>";
                    $nestedData[] = $action;
                }
                $data[] = $nestedData;            
            }
        }

        $json_data['recordsTotal'] = intval( $sales_rep_lists['recordsTotal'] );
        $json_data['recordsFiltered'] = intval( $sales_rep_lists['recordsFiltered'] );
        $json_data['data'] = $data;
        echo json_encode($json_data);
    }

    public function add_sales_rep()
    {
        $data = array();
        $data['title'] = 'PCT Order: Add Sales Rep.';
        $salesRepData = array();

        if ($this->input->post()) {
            $this->form_validation->set_rules('sales_rep_first_name', 'Sales Rep. First Name', 'required', array('required'=> 'Please Enter Sales Rep. First Name'));
            $this->form_validation->set_rules('sales_rep_last_name', 'Sales Rep. Last Name', 'required', array('required'=> 'Please Enter Sales Rep. Last Name'));
            $this->form_validation->set_rules('email_address', 'Email', 'trim|required|valid_email', array('required'=> 'Please Enter Email', 'valid_email' => 'Please enter valid Email'));
            $this->form_validation->set_rules('telephone', 'Phone Number', 'required', array('required'=> 'Please Enter Phone Number'));
            $this->form_validation->set_rules('partner_id', 'Partner Id', 'trim|required|numeric', array('required'=> 'Please Enter Partner Id'));
            $this->form_validation->set_rules('partner_type_id', 'Partner Type Id', 'trim|required|numeric', array('required'=> 'Please Enter Partner Type Id'));
            $this->form_validation->set_rules('sales_rep_no_of_open_orders', 'Sales Rep No of Open Orders', 'trim|required|numeric', array('required'=> 'Please Enter Sales Rep No of Open Orders'));
            $this->form_validation->set_rules('sales_rep_no_of_close_orders', 'Sales Rep No of Close Orders', 'trim|required|numeric', array('required'=> 'Please Enter Sales Rep No of Close Orders'));
            $this->form_validation->set_rules('sales_rep_premium', 'Sales Rep Premium', 'trim|required|numeric', array('required'=> 'Sales Rep Premium'));
              
            $config['upload_path'] = 'uploads/sales-rep/';
            $config['allowed_types'] = 'jpg|png';
            $config['max_size']  = 12000;
                    
            if ($this->form_validation->run() == true) {
                $fileuri = ''; $status = "success";
                if(is_uploaded_file($_FILES['sales_rep_profile_img']['tmp_name'])) 
                {  
                    if (!is_dir('uploads/sales-rep')) 
                    {
                        mkdir('./uploads/sales-rep', 0777, TRUE);
                    }
                    
                    $new_name = 'sales_rep_'.time().rand(10,100000);
                    $config['file_name'] = $new_name;         
                    $this->load->library('upload', $config);

                    if (!$this->upload->do_upload('sales_rep_profile_img')) {
                        $status = 'error';
                        $msg = $this->upload->display_errors();
                    } else{
                        $data = $this->upload->data();
                        $status = "success";
                        $msg = "Borrower File successfully uploaded";
                        $document_name = 'sales_rep_'.time().rand(10,100000).'.'.$data['image_type'];
                        rename('./uploads/sales-rep/'.$data['file_name'], './uploads/sales-rep/'.$document_name);
                        $this->order->uploadDocumentOnAwsS3($document_name, 'sales-rep');
                        $fileuri=  $config['upload_path'].$document_name;
                    }
                }

                $fileUrlThankYou = ''; $statusThank = "success";
                if (is_uploaded_file($_FILES['sales_rep_profile_thank_you_img']['tmp_name'])) { 

                    if (!is_dir('uploads/sales-rep')) {
                        mkdir('./uploads/sales-rep', 0777, TRUE);
                    }
                    $sales_rep_profile_thank_you_img_name = 'sales_rep_thank_you'.time().rand(10,100000);
                    $config['file_name'] = $sales_rep_profile_thank_you_img_name;         
                    $this->load->library('upload', $config);
                    $msgThankyou = '';
                    if (!$this->upload->do_upload('sales_rep_profile_thank_you_img')) {
                        $statusThank = 'error';
                        $msgThankyou = $this->upload->display_errors();
                    } else {
                        $dataThank = $this->upload->data();
                        $statusThank = "success";
                        $msgThankyou = "Thank you File successfully uploaded";
                        $document_name = 'sales_rep_thank_you'.time().rand(10,100000).'.'.$dataThank['image_type'];
                        rename('./uploads/sales-rep/'.$dataThank['file_name'], './uploads/sales-rep/'.$document_name);
                        $this->order->uploadDocumentOnAwsS3($document_name, 'sales-rep');
                        $fileUrlThankYou =  $config['upload_path'].$document_name;
                    }
                }

                if($status == "success" && $statusThank == "success")
                {
                    $salesRepData = array(
                        'first_name' => $_POST['sales_rep_first_name'],
                        'last_name' => $_POST['sales_rep_last_name'],
                        'email_address' => $_POST['email_address'],
                        'telephone_no' =>  $_POST['telephone'],
                        'partner_id' => $_POST['partner_id'],
                        'partner_type_id' =>  $_POST['partner_type_id'],
                        'is_mail_notification' =>  isset($_POST['is_mail_notification']) ? 1 : 0,
                        'status' => 1,
                        'is_sales_rep' => 1,
                        'is_sales_rep_manager' => isset($_POST['is_sales_rep_manager']) ? 1 : 0,
                        'sales_rep_profile_img' => $fileuri,
                        'sales_rep_profile_thank_you_img' => $fileUrlThankYou,
                        'sales_rep_no_of_open_orders' => $_POST['sales_rep_no_of_open_orders'],
                        'sales_rep_no_of_close_orders' => $_POST['sales_rep_no_of_close_orders'],
                        'sales_rep_premium' => $_POST['sales_rep_premium'],
                        'is_password_updated' => 1
                    );

                    $insert = $this->sales_model->insert($salesRepData);
                    
                    if ($insert) {
                        $data['success_msg'] = 'Sales Rep. added successfully.';
                    } else {
                        $data['error_msg'] = 'Sales Rep. not added.';
                    }
                }
                else
                {
                    $data['sales_rep_profile_img_error_msg'] = $msg;
                    $data['sales_rep_profile_thank_you_img_error_msg'] = $msgThankyou;
                }
                
            } else {
                $data['first_name_error_msg'] = form_error('sales_rep_first_name');
                $data['last_name_error_msg'] = form_error('sales_rep_last_name');
                $data['email_error_msg'] = form_error('email_address');
                $data['phone_error_msg'] = form_error('telephone');
                $data['partner_id_error_msg'] = form_error('partner_id');
                $data['sales_rep_no_of_open_orders_error_msg'] = form_error('sales_rep_no_of_open_orders');
                $data['sales_rep_no_of_close_orders_error_msg'] = form_error('sales_rep_no_of_close_orders');
                $data['sales_rep_premium_error_msg'] = form_error('sales_rep_premium');
            }                                       
        }
        $this->load->view('order/layout/header', $data);
        $this->load->view('order/sales/add_sales_rep', $data);
        $this->load->view('order/layout/footer', $data);
    }

    public function edit_sales_rep()
    {
        $data = array();
        $data['title'] = 'PCT Order: Edit Sales Rep.';
        $id = $this->uri->segment('4');
        
        if (isset($id) && !empty($id)) {
            $con = array('id' => $id);
            $sales_rep_info = $this->sales_model->getSalesRep($con);
            if (isset($_POST) && !empty($_POST)) {
               
                $this->form_validation->set_rules('sales_rep_first_name', 'Sales Rep. First Name', 'required', array('required'=> 'Please Enter Sales Rep. First Name'));
                $this->form_validation->set_rules('sales_rep_last_name', 'Sales Rep. Last Name', 'required', array('required'=> 'Please Enter Sales Rep. Last Name'));
                $this->form_validation->set_rules('email_address', 'Email', 'trim|required|valid_email', array('required'=> 'Please Enter Email', 'valid_email' => 'Please enter valid Email'));
                $this->form_validation->set_rules('telephone', 'Phone Number', 'required', array('required'=> 'Please Enter Phone Number'));
                $this->form_validation->set_rules('partner_id', 'Partner Id', 'trim|required|numeric', array('required'=> 'Please Enter Partner Id'));
                $this->form_validation->set_rules('partner_type_id', 'Partner Type Id', 'trim|required|numeric', array('required'=> 'Please Enter Partner Type Id'));
                $this->form_validation->set_rules('sales_rep_no_of_open_orders', 'Sales Rep No of Open Orders', 'trim|required|numeric', array('required'=> 'Please Enter Sales Rep No of Open Orders'));
                $this->form_validation->set_rules('sales_rep_no_of_close_orders', 'Sales Rep No of Close Orders', 'trim|required|numeric', array('required'=> 'Please Enter Sales Rep No of Close Orders'));
                $this->form_validation->set_rules('sales_rep_premium', 'Sales Rep Premium', 'trim|required|numeric', array('required'=> 'Sales Rep Premium'));

                $config['upload_path'] = 'uploads/sales-rep/';
                $config['allowed_types'] = 'jpg|png';
                $config['max_size']  = '2048';
                        
                if($this->form_validation->run() == true) {
                    $fileuri = isset($sales_rep_info['sales_rep_profile_img']) && !empty($sales_rep_info['sales_rep_profile_img']) ? $sales_rep_info['sales_rep_profile_img'] : '';
                    $status = "success";
                    if(is_uploaded_file($_FILES['sales_rep_profile_img']['tmp_name'])) 
                    {  
                        if (!is_dir('uploads/sales-rep')) 
                        {
                            mkdir('./uploads/sales-rep', 0777, TRUE);
                        }
                        
                        $new_name = 'sales_rep_'.time().rand(10,100000);

                        $config['file_name'] = $new_name;         
                        $this->load->library('upload', $config);

                        if (!$this->upload->do_upload('sales_rep_profile_img'))
                        {
                            $status = 'error';
                            $msg = $this->upload->display_errors();
                        }
                        else
                        {
                            $data = $this->upload->data();
                            $status = "success";
                            $msg = "File successfully uploaded";
                            $document_name = 'sales_rep_'.time().rand(10,100000).'.'.$data['image_type'];
                            rename('./uploads/sales-rep/'.$data['file_name'], './uploads/sales-rep/'.$document_name);
                            $this->order->uploadDocumentOnAwsS3($document_name, 'sales-rep');
                            $fileuri=  $config['upload_path'].$document_name;
                        }
                    }

                    $fileUrlThankYou = isset($sales_rep_info['sales_rep_profile_thank_you_img']) && !empty($sales_rep_info['sales_rep_profile_thank_you_img']) ? $sales_rep_info['sales_rep_profile_thank_you_img'] : ''; 
                    $statusThank = "success";
                    if(is_uploaded_file($_FILES['sales_rep_profile_thank_you_img']['tmp_name'])) { 
    
                        if (!is_dir('uploads/sales-rep')) {
                            mkdir('./uploads/sales-rep', 0777, TRUE);
                        }
                        
                        $sales_rep_profile_thank_you_img_name = 'sales_rep_thank_you'.time().rand(10,100000);
                        $config['file_name'] = $sales_rep_profile_thank_you_img_name;         
                        $this->load->library('upload', $config);
                        $msgThankyou = '';
                        if (!$this->upload->do_upload('sales_rep_profile_thank_you_img')) {
                            $statusThank = 'error';
                            $msgThankyou = $this->upload->display_errors();
                        } else {
                            $data = $this->upload->data();
                            $statusThank = "success";
                            $msgThankyou = "Thank you File successfully uploaded";
                            $document_name = 'sales_rep_thank_you'.time().rand(10,100000).'.'.$data['image_type'];
                            rename('./uploads/sales-rep/'.$data['file_name'], './uploads/sales-rep/'.$document_name);
                            $this->order->uploadDocumentOnAwsS3($document_name, 'sales-rep');
                            $fileUrlThankYou =  $config['upload_path'].$document_name;
                        }
                    }

                    if($status == "success" && $statusThank == "success")
                    {
                       
                        $salesRepData = array(
                            'first_name' => $_POST['sales_rep_first_name'],
                            'last_name' => $_POST['sales_rep_last_name'],
                            'email_address' => $_POST['email_address'],
                            'telephone_no' =>  $_POST['telephone'],
                            'partner_id' => $_POST['partner_id'],
                            'partner_type_id' =>  $_POST['partner_type_id'],
                            'is_mail_notification' =>  isset($_POST['is_mail_notification']) ? 1 : 0,
                            'status' => 1,
                            'is_sales_rep' => 1,
                            'is_sales_rep_manager' => isset($_POST['is_sales_rep_manager']) ? 1 : 0,
                            'sales_rep_profile_img' => $fileuri,
                            'sales_rep_profile_thank_you_img' => $fileUrlThankYou,
                            'sales_rep_no_of_open_orders' => $_POST['sales_rep_no_of_open_orders'],
                            'sales_rep_no_of_close_orders' => $_POST['sales_rep_no_of_close_orders'],
                            'sales_rep_premium' => $_POST['sales_rep_premium'],
                            'is_password_updated' => 1
                        );

                        $condition = array('id' => $id);
                        $update = $this->sales_model->update($salesRepData, $condition);
                            
                        if ($update) {
                            $data['success_msg'] = 'Sales Rep. updated successfully.';
                        } else {
                            $data['error_msg'] = 'Error occurred while updating Sales Rep.';
                        }
                    }
                    else
                    {
                        $data['sales_rep_profile_img_error_msg'] = $msg;
                        $data['sales_rep_profile_thank_you_img_error_msg'] = $msgThankyou;
                    }

                } else {
                    $data['first_name_error_msg'] = form_error('sales_rep_first_name');
                    $data['last_name_error_msg'] = form_error('sales_rep_last_name');
                    $data['email_error_msg'] = form_error('email_address');
                    $data['phone_error_msg'] = form_error('telephone');
                    $data['partner_id_error_msg'] = form_error('partner_id');
                    $data['partner_type_id_error_msg'] = form_error('partner_type_id');
                    $data['sales_rep_no_of_open_orders_error_msg'] = form_error('sales_rep_no_of_open_orders');
                    $data['sales_rep_no_of_close_orders_error_msg'] = form_error('sales_rep_no_of_close_orders');
                    $data['sales_rep_premium_error_msg'] = form_error('sales_rep_premium');
                }
            }
            $con = array('id' => $id);
            $sales_rep_info = $this->sales_model->getSalesRep($con);

        } else {
            redirect('order/admin/sales-rep');
        }
        $data['sales_rep_info'] = $sales_rep_info;
        $this->load->view('order/layout/header', $data);
        $this->load->view('order/sales/edit_sales_rep', $data);
        $this->load->view('order/layout/footer', $data);
    }

    public function delete_sales_rep()
    {
        $id = isset($_POST['id']) && !empty($_POST['id']) ? $_POST['id'] : '';
        if ($id) {
            $salesRepData = array('status' => 0);
            $condition = array('id' => $id);
            $update = $this->sales_model->update($salesRepData, $condition);
            if($update) {
                $successMsg = 'Sales Rep. deleted successfully.';
                $response = array('status' =>'success', 'message' => $successMsg);
            }
        } else {
            $msg = 'Sales Rep. ID is required.';
            $response = array('status' => 'error', 'message' => $msg);
        }
        echo json_encode($response);
    }

    public function sales_rep_profile_img_check($str)
    {
        $allowed_mime_type_arr = array('image/jpeg','image/pjpeg','image/png','image/x-png');
        $mime = get_mime_by_extension($_FILES['sales_rep_profile_img']['name']);
        if(isset($_FILES['sales_rep_profile_img']['name']) && $_FILES['sales_rep_profile_img']['name']!=""){
            if(in_array($mime, $allowed_mime_type_arr)){
                return true;
            }else{
                $this->form_validation->set_message('sales_rep_profile_img_check', 'Please select only jpg/png file.');
                return false;
            }
        }else{
            $this->form_validation->set_message('sales_rep_profile_img_check', 'Please choose a file to upload.');
            return false;
        }
    }

    public function remove_sales_rep()
    {
        $id = isset($_POST['id']) && !empty($_POST['id']) ? $_POST['id'] : '';
        if ($id) {
            $con = array('id' => $id);
            $sales_rep_info = $this->sales_model->getSalesRep($con);
            $imgPath = isset($sales_rep_info['sales_rep_profile_img']) && !empty($sales_rep_info['sales_rep_profile_img']) ? $sales_rep_info['sales_rep_profile_img'] : '';
            $salesRepData = array('sales_rep_profile_img' => '');
            $condition = array('id' => $id);
            $update = $this->sales_model->update($salesRepData, $condition);
            if($update) {
                unlink('./'.$imgPath);
                $successMsg = 'Sales Rep. Borrower profile image deleted successfully.';
                $response = array('status' =>'success', 'message' => $successMsg);
            }
        } else {
            $msg = 'Sales Rep. ID is required.';
            $response = array('status' => 'error', 'message' => $msg);
        }
        echo json_encode($response);
    }

    public function remove_sales_rep_thank_you()
    {
        $id = isset($_POST['id']) && !empty($_POST['id']) ? $_POST['id'] : '';
        if ($id) {
            $con = array('id' => $id);
            $sales_rep_info = $this->sales_model->getSalesRep($con);
            $imgPath = isset($sales_rep_info['sales_rep_profile_thank_you_img']) && !empty($sales_rep_info['sales_rep_profile_thank_you_img']) ? $sales_rep_info['sales_rep_profile_thank_you_img'] : '';
            $salesRepData = array('sales_rep_profile_thank_you_img' => '');
            $condition = array('id' => $id);
            $update = $this->sales_model->update($salesRepData, $condition);
            if($update) {
                unlink('./'.$imgPath);
                $successMsg = 'Sales Rep. Thank you profile image deleted successfully.';
                $response = array('status' =>'success', 'message' => $successMsg);
            }
        } else {
            $msg = 'Sales Rep. ID is required.';
            $response = array('status' => 'error', 'message' => $msg);
        }
        echo json_encode($response);
    }
}
