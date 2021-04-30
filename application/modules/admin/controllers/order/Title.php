<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Title extends MX_Controller {

	public function __construct()
    {
        parent::__construct();
        $this->load->helper(
            array('file', 'url','form')
        );
        $this->load->library('form_validation');
        $this->load->model('order/title_model');
    }

	public function index()
	{
        $this->is_admin();
		$data = array();
        $data['title'] = 'PCT Order: Title Officers';
        $this->load->view('order/layout/header', $data);
        $this->load->view('order/title/title', $data);
        $this->load->view('order/layout/footer', $data);
	}

    public function get_title_officer_list()
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
            $title_officer_lists = $this->title_model->get_title_officers($params);
            $json_data['draw'] = intval( $params['draw'] );
        } else {
            $params['searchvalue'] = isset($_POST['keyword']) && !empty($_POST['keyword']) ? $_POST['keyword'] : '';
            $title_officer_lists = $this->title_model->get_title_officers($params);
        }
        
        if (isset($title_officer_lists['data']) && !empty($title_officer_lists['data'])) {
            foreach ($title_officer_lists['data'] as $key => $value) {
                $nestedData=array();
                $nestedData[] = $value['name'];
                $nestedData[] = $value['email_address'];
                $nestedData[] = $value['phone'];
                $nestedData[] = $value['partner_id'];
                $nestedData[] = $value['partner_type_id'];
                
                if (isset($_POST['draw']) && !empty($_POST['draw'])) {
                    $editOrderUrl = base_url().'order/admin/edit-title-officer/'.$value['id'];
                    $action = "<a href='".$editOrderUrl."' class='btn btn-action edit-agent'title ='Edit Title Officer Detail'><span class='fa fa-edit' aria-hidden='true'></span></a>";
                    $action .= "<a href='javascript:void(0);' onclick='deleteTitleOfficer(".$value['id'].")' class='btn btn-action'  title='Delete Title Officer'><span class='fa fa-trash' aria-hidden='true'></span></a>";
                    $nestedData[] = $action;
                }
                $data[] = $nestedData;            
            }
        }

        $json_data['recordsTotal'] = intval( $title_officer_lists['recordsTotal'] );
        $json_data['recordsFiltered'] = intval( $title_officer_lists['recordsFiltered'] );
        $json_data['data'] = $data;
        echo json_encode($json_data);
    }

    public function add_title_officer()
    {
        $this->is_admin();
        $data = array();
        $data['title'] = 'PCT Order: Add Title Officer.';
        $titleOfficerData = array();

        if ($this->input->post()) {
            $this->form_validation->set_rules('title_officer_name', 'Title Officer Name', 'required', array('required'=> 'Please Enter Title Officer Name'));
            $this->form_validation->set_rules('email_address', 'Email', 'trim|required|valid_email', array('required'=> 'Please Enter Email', 'valid_email' => 'Please enter valid Email'));
            $this->form_validation->set_rules('telephone', 'Phone Number', 'required', array('required'=> 'Please Enter Phone Number'));
            $this->form_validation->set_rules('partner_id', 'Partner Id', 'trim|required|numeric', array('required'=> 'Please Enter Partner Id'));
            $this->form_validation->set_rules('partner_type_id', 'Partner Type Id', 'trim|required|numeric', array('required'=> 'Please Enter Partner Type Id'));

            if ($this->form_validation->run() == true) {
                $titleOfficerData = array(
                    'name' => $_POST['title_officer_name'],
                    'email_address' => $_POST['email_address'],
                    'phone' =>  $_POST['telephone'],
                    'partner_id' => $_POST['partner_id'],
                    'partner_type_id' =>  $_POST['partner_type_id'],
                    'status' => 1
                );
                $insert = $this->title_model->insert($titleOfficerData);
                
                if ($insert) {
                    $data['success_msg'] = 'Title Officer added successfully.';
                } else {
                    $data['error_msg'] = 'Title Officer not added.';
                } 
                
            } else {
                $data['name_error_msg'] = form_error('title_officer_name');
                $data['email_error_msg'] = form_error('email_address');
                $data['phone_error_msg'] = form_error('telephone');
                $data['partner_id_error_msg'] = form_error('partner_id');
                $data['partner_type_id_error_msg'] = form_error('partner_type_id');
            }                                       
        }
        $this->load->view('order/layout/header', $data);
        $this->load->view('order/title/add_title_officer', $data);
        $this->load->view('order/layout/footer', $data);
    }

    public function edit_title_officer()
    {
        $this->is_admin();
        $data = array();
        $data['title'] = 'PCT Order: Edit Title Officer';
        $id = $this->uri->segment('4');
        
        if (isset($id) && !empty($id)) {
            if (isset($_POST) && !empty($_POST)) {
                
                $this->form_validation->set_rules('title_officer_name', 'Title Officer Name', 'required', array('required'=> 'Please Enter Title Officer Name'));
                $this->form_validation->set_rules('email_address', 'Email', 'trim|required|valid_email', array('required'=> 'Please Enter Email', 'valid_email' => 'Please enter valid Email'));
                $this->form_validation->set_rules('telephone', 'Phone Number', 'required', array('required'=> 'Please Enter Phone Number'));
                $this->form_validation->set_rules('partner_id', 'Partner Id', 'trim|required|numeric', array('required'=> 'Please Enter Partner Id'));
                $this->form_validation->set_rules('partner_type_id', 'Partner Type Id', 'trim|required|numeric', array('required'=> 'Please Enter Partner Type Id'));

                if($this->form_validation->run() == true) {
                    $titleOfficerData = array(
                        'name' => $_POST['title_officer_name'],
                        'email_address' => $_POST['email_address'],
                        'phone' =>  $_POST['telephone'],
                        'partner_id' => $_POST['partner_id'],
                        'partner_type_id' =>  $_POST['partner_type_id'],
                        'status' => 1
                    );
                    $condition = array('id' => $id);
                    $update = $this->title_model->update($titleOfficerData, $condition);
                        
                    if ($update) {
                        $data['success_msg'] = 'Title Officer updated successfully.';
                    } else {
                        $data['error_msg'] = 'Error occurred while updating Title Officer';
                    }
                } else {
                    $data['name_error_msg'] = form_error('title_officer_name');
                    $data['email_error_msg'] = form_error('email_address');
                    $data['phone_error_msg'] = form_error('telephone');
                    $data['partner_id_error_msg'] = form_error('partner_id');
                    $data['partner_type_id_error_msg'] = form_error('partner_type_id');
                }
            }
            $con = array('id' => $id);
            $title_officer_info = $this->title_model->getTitleOfficers($con);
        } else {
            redirect('order/admin/title-officers');
        }

        $data['title_officer_info'] = $title_officer_info;
        $this->load->view('order/layout/header', $data);
        $this->load->view('order/title/edit_title_officer', $data);
        $this->load->view('order/layout/footer', $data);
    }

    public function delete_title_officer()
    {
        $this->is_admin();
        $id = isset($_POST['id']) && !empty($_POST['id']) ? $_POST['id'] : '';
        if ($id) {
            $titleOfficerData = array('status' => 0);
            $condition = array('id' => $id);
            $update = $this->title_model->update($titleOfficerData, $condition);
            if($update) {
                $successMsg = 'Title Officer deleted successfully.';
                $response = array('status' =>'success', 'message' => $successMsg);
            }
        } else {
            $msg = 'Title Officer ID is required.';
            $response = array('status' => 'error', 'message' => $msg);
        }
        echo json_encode($response);
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
