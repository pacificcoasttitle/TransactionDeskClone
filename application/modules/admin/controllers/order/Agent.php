<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Agent extends MX_Controller {

	public function __construct()
    {
        parent::__construct();
        $this->load->helper(
            array('file', 'url','form')
        );
        $this->load->library('order/adminTemplate');
        $this->load->library('form_validation');
        $this->load->model('order/agent_model');
        $this->load->model('order/home_model');
        $this->load->library('order/common_lib');
        $this->common_lib->is_admin();
    }

	public function index()
	{
		$data = array();
        $data['title'] = 'PCT Order: Agents';
        $this->admintemplate->show("order/agent", "agents", $data);
        // $this->load->view('order/layout/header', $data);
        // $this->load->view('order/agent/agents', $data);
        // $this->load->view('order/layout/footer', $data);
	}

    public function import_agents()
    {
        ini_set('max_execution_time', 0); 
        ini_set('memory_limit','2048M');
        $data = array();
        $data['title'] = 'PCT Order: Import Agents';
        if($this->input->post())
        {
            // Form field validation rules
            $this->form_validation->set_rules('file', 'CSV file', 'callback_file_check');
            
            // Validate submitted form data
            if($this->form_validation->run($this) == true)
            {
                $insertCount = $updateCount = $rowCount = $notAddCount = 0;
                
                // If file uploaded
                if(is_uploaded_file($_FILES['file']['tmp_name']))
                {
                    // Load CSV reader library
                    $this->load->library('CSVReader');
                    
                    // Parse data from CSV file
                    $csvData = $this->csvreader->parse_csv($_FILES['file']['tmp_name']);
                    $rowNumber = '';
                    // Insert/update CSV data into database
                    if(!empty($csvData))
                    {
                        foreach($csvData as $row)
                        {
                            $rowCount++;
                            if(isset($row['Email']) && !empty($row['Email']))
                            {
                                $name = $row['First Name']." ".$row['Last Name'];
                                $email_address = str_replace(' ','',$row['Email']);
                                $email_address = strtolower($email_address);

                                $agentData = array(
                                    'partner_id' => $row['Partner Company ID'],
                                    'partner_employee_id' => $row['Partner Employee ID'],
                                    'name' => $name,
                                    'email_address' => $email_address,
                                    'company' => ($row['Name']),
                                    'telephone_no' => $row['Cell Phone'],
                                    'address' => $row['Street1'],
                                    'city' => $row['City'],
                                    'zipcode' => $row['Zip'],
                                    'is_listing_agent' => 0,
                                    /*'list_unit' => $row['List Unit'],
                                    'list_volume' => $row['List Volume'],
                                    'selected_revenue' => $row['Selected Revenue'],*/
                                    'status'=> 1,
                                );

                                //$this->db->replace('agents', $agentData);
                                $con = array(
                                    'where' => array(
                                        'partner_id' => $row['Partner Company ID'],
                                        'partner_employee_id' => $row['Partner Employee ID']
                                    ),
                                    'returnType' => 'count'
                                );
                                $prevCount = $this->agent_model->get_rows($con);
                                
                                if($prevCount > 0){
                                                                  
                                    $condition = array('partner_id' => $row['Partner Company ID'], 'partner_employee_id' => $row['Partner Employee ID']);
                                    $update = $this->agent_model->update($agentData, $condition);
                                    
                                    if($update){
                                        $updateCount++;
                                    } else {
                                        $notAddCount++;
                                        $rowNumber .= $rowCount.",";
                                    }
                                }else{
                                    // Insert member data
                                    $insert = $this->agent_model->insert($agentData);
                                    
                                    if($insert){
                                        $insertCount++;
                                    } else {
                                        $notAddCount++; 
                                        $rowNumber .= $rowCount.",";
                                    }
                                }
                                $maxEmployeeid =  $this->agent_model->findMaxEmployeeId($email_address);
                                $statusCondition = array('email_address' => $email_address, 'partner_employee_id != ' => $maxEmployeeid);
                                $update = $this->agent_model->update( array('status' => 0), $statusCondition);
                            }
                            
                        }
                        
                        
                        // Status message with imported data count
                        $notAddCount = ($rowCount - ($insertCount + $updateCount));
                        $successMsg = 'Agents imported successfully. Total Rows ('.$rowCount.') | Inserted ('.$insertCount.') | Updated ('.$updateCount.') | Not Inserted ('.$notAddCount.')';
                        // $this->session->set_userdata('success_msg', $successMsg);
                        $data['success_msg'] = $successMsg;
                    }
                }
                else
                {
                   // $this->session->set_userdata('error_msg', 'Error on file upload, please try again.');
                    $data['error_msg'] = 'Error on file upload, please try again.';
                }
            }
            else
            {
                // $this->session->set_userdata('error_msg', 'Invalid file, please select only CSV file.');
                $data['error_msg'] = 'Invalid file, please select only CSV file.';
            }
        }
        $this->admintemplate->show("order/agent/", "import", $data);
        // $this->load->view('order/layout/header', $data);
        // $this->load->view('order/agent/import', $data);
        // $this->load->view('order/layout/footer', $data);
    }

    public function file_check($str)
    {
        $allowed_mime_types = array('text/x-comma-separated-values', 'text/comma-separated-values', 'application/octet-stream', 'application/vnd.ms-excel', 'application/x-csv', 'text/x-csv', 'text/csv', 'application/csv', 'application/excel', 'application/vnd.msexcel', 'text/plain');
        if(isset($_FILES['file']['name']) && $_FILES['file']['name'] != "")
        {
            $mime = get_mime_by_extension($_FILES['file']['name']);
            $fileAr = explode('.', $_FILES['file']['name']);
            $ext = end($fileAr);
            if(($ext == 'csv') && in_array($mime, $allowed_mime_types)){
                return true;
            }else{
                $this->form_validation->set_message('file_check', 'Please select only CSV file to upload.');
                return false;
            }
        }
        else
        {
            $this->form_validation->set_message('file_check', 'Please select a CSV file to upload.');
            return false;
        }
    }

    public function get_agent_list()
    {
        $params = array();  $data = array();
        if(isset($_POST['draw']) && !empty($_POST['draw']))
        {
            $params['draw'] = isset($_POST['draw']) && !empty($_POST['draw']) ? $_POST['draw'] : 10;
            $params['length'] = isset($_POST['length']) && !empty($_POST['length']) ? $_POST['length'] : 2;
            $params['start'] = isset($_POST['start']) && !empty($_POST['start']) ? $_POST['start'] : 0;
            $params['orderColumn'] = isset($_POST['order'][0]['column']) && !empty($_POST['order'][0]['column']) ? $_POST['order'][0]['column'] : 0;
            $params['orderDir'] = isset($_POST['order'][0]['dir']) && !empty($_POST['order'][0]['dir']) ? $_POST['order'][0]['dir'] : 0;

            $params['searchvalue'] = isset($_POST['search']['value']) && !empty($_POST['search']['value']) ? $_POST['search']['value'] : '';

            $pageno = ($params['start'] / $params['length'])+1;

            $agent_lists = $this->agent_model->get_agents($params);
           
           // $cnt = ($pageno == 1) ? ($params['start']+1) : (($pageno - 1) * $params['length']) + 1;
            $json_data['draw'] = intval( $params['draw'] );
        }
        else
        {
            $params['searchvalue'] = isset($_POST['keyword']) && !empty($_POST['keyword']) ? $_POST['keyword'] : '';
            $agent_lists = $this->agent_model->get_agents($params);
        }
        

        if(isset($agent_lists['data']) && !empty($agent_lists['data']))
        {
            foreach ($agent_lists['data'] as $key => $value) 
            {
                $nestedData=array();
                $partner_id = isset($value['partner_id']) && !empty($value['partner_id']) ? $value['partner_id'] : '-';
                $nestedData[] = $partner_id;
                $nestedData[] = $value['name'];
                /*$nestedData[] = $value['last_name'];*/
                $nestedData[] = $value['email_address'];
                $nestedData[] = $value['telephone_no'];
                $nestedData[] = $value['company'];
                $nestedData[] = $value['address']." ".$value['city']." ".$value['zipcode'];
                
                if(isset($_POST['draw']) && !empty($_POST['draw']))
                {
                    $editOrderUrl = base_url().'order/admin/edit-agent/'.$value['id'];
                    $action = "<div style='display: flex;justify-content: space-evenly;'><a href='".$editOrderUrl."' class='edit-agent' title ='Edit Agent Detail'><i class='fas fa-edit' aria-hidden='true'></i></a>";

                    $action .= "<a href='javascript:void(0);' onclick='deleteAgent(".$value['id'].")' title='Delete Customer'><i class='fas fa-trash' aria-hidden='true'></i></a> </div>";

                    $nestedData[] = $action;
                }
                
                $data[] = $nestedData;
            }
        }

        $json_data['recordsTotal'] = intval( $agent_lists['recordsTotal'] );
        $json_data['recordsFiltered'] = intval( $agent_lists['recordsFiltered'] );
        $json_data['data'] = $data;
        echo json_encode($json_data);
    }

    public function delete_agent()
    {
        $id = isset($_POST['id']) && !empty($_POST['id']) ? $_POST['id'] : '';
        if($id)
        {
            $agentData = array('status' => 0);
            $condition = array('id' => $id);
            $agent = $this->agent_model->get_rows($condition);
            $update = $this->agent_model->update($agentData, $condition);
            if($update)
            {
                $successMsg = 'Agent deleted successfully.';
                $response = array('status'=>'success', 'message'=>$successMsg);
                /** Save user Activity */
                $activity = 'Deleted agent : '. $agent['email_address'];
                $this->common_lib->logAdminActivity($activity);
                /** End Save user activity */
            }
        }
        else
        {
            $msg = 'Agent ID is required.';
            $response = array('status' => 'error','message'=>$msg);
        }

        echo json_encode($response);
    }

    public function edit()
    {
        $this->load->library('order/softPro');
        $id = $this->uri->segment(4);        
        $data = array();
        $data['title'] = 'PCT Order: Edit Agent';
        if(isset($id) && !empty($id))
        {

            if(isset($_POST) && !empty($_POST))
            {
                // Validations
                $this->form_validation->set_rules('first_name', 'First Name', 'required', ['required' => 'Please Enter First Name']);
                $this->form_validation->set_rules('last_name', 'Last Name', 'required', ['required' => 'Please Enter Last Name']);
                $this->form_validation->set_rules('email_address', 'Email', 'trim|required|valid_email', ['required' => 'Please Enter Email', 'valid_email' => 'Please enter valid Email']);
                $this->form_validation->set_rules('company_name', 'Company Name', 'required', ['required' => 'Please Enter Company']);
                $this->form_validation->set_rules('lookup_code', 'Lookup Code', 'required|min_length[10]', ['required' => 'Please Lookup Code']);
                $this->form_validation->set_rules('user_type', 'User type', 'required', ['required' => 'Please Select User Type']);
                $this->form_validation->set_rules('phone', 'Phone', 'required', ['required' => 'Please Enter Telephone']);
                $this->form_validation->set_rules('address1', 'Address', 'required', ['required' => 'Please Enter Address']);
                $this->form_validation->set_rules('city', 'City', 'required', ['required' => 'Please Enter City']);
                $this->form_validation->set_rules('state', 'State', 'required', ['required' => 'Please Enter State']);
                $this->form_validation->set_rules('zip', 'Zip', 'required', ['required' => 'Please Enter Zipcode']);

                if($this->form_validation->run($this) == true)
                {
                    $userType  = $this->input->post('user_type');
                    $is_escrow = $is_lender = $is_mortgage_broker = $is_realtor = 0;
                    if ($userType == 'escrow') {
                        $is_escrow = 1;
                    } else if ($userType == 'lender') {
                        $is_lender = 1;
                    } else if ($userType == 'mortgage_broker') {
                        $is_mortgage_broker = 1;
                    } else if ($userType == 'realtor') {
                        $is_realtor = 1;
                    }
                    $first_name   = $this->input->post('first_name');
                    $last_name    = $this->input->post('last_name');
                    $company_name = $this->input->post('company_name');
                    $lookup_code = $this->input->post('lookup_code');
                    $customerData = [
                        'FirstName'         => $first_name,
                        'LastName'          => $last_name,
                        'Phone'             => $this->input->post('phone'),
                        'Email'             => $this->input->post('email_address'),
                        'ClientLookupCode'  => $lookup_code,
                        'CompanyLookupCode' => $this->input->post('flookup_code'),
                        'Address1'          => $this->input->post('address1'),
                        'City'              => $this->input->post('city'),
                        'State'             => $this->input->post('state'),
                        'Zip'               => $this->input->post('zip'),
                    ];

                    $response = $this->softpro->updateUserToSoftpro($customerData, 'update_user');
                    // echo "<pre>";
                    // print_r($response);die;
                    $customerData = [
                        'first_name'         => $first_name,
                        'last_name'          => $last_name,
                        'phone'              => $this->input->post('phone'),
                        'email_address'      => $this->input->post('email_address'),
                        'lookup_code'        => $lookup_code,
                        'flookup_code'       => $this->input->post('flookup_code'),
                        'address1'           => $this->input->post('address1'),
                        'city'               => $this->input->post('city'),
                        'state'              => $this->input->post('state'),
                        'zip'                => $this->input->post('zip'),
                        'company_name'       => $company_name,
                        'is_escrow'          => $is_escrow,
                        'is_lender'          => $is_lender,
                        'is_mortgage_broker' => $is_mortgage_broker,
                        'is_selling_agent'   => $is_realtor,
                        'is_new_user'        => 1,
                        'status'             => 1,
                    ];

                    if ($response['success']) {
                        $this->load->library('order/order');
                        $condition = array('lookup_code' => $lookup_code);
                        $update = $this->home_model->update($customerData, $condition, 'pct_softpro_lookup_table');
                        /** Save user Activity */
                        $activity = 'New user created :- ' . $this->input->post('email_address');
                        $this->order->logAdminActivity($activity);
                        /** End Save user activity */
                        $data['success_msg'] = 'New User updated successfully.';
                        $this->form_validation->reset_validation();

                    } else {
                        $data['error_msg'] = $response['msg'];
                    }
                }
                else
                {
                    $data['name_error_msg']    = form_error('name');
                    $data['email_address_error_msg'] = form_error('email_address');
                    $data['user_type_error_msg']     = form_error('user_type');
                    $data['address_error_msg']       = form_error('address1');
                    $data['phone_error_msg']       = form_error('phone');
                    $data['city_error_msg']          = form_error('city');
                    $data['state_error_msg']         = form_error('state');
                    $data['zipcode_error_msg']       = form_error('zipcode');
                    
                }
            }

            $con = array('id' => $id);
            $data['userDetails'] = $this->home_model->sp_get_rows($con);
            // echo "<pre>";
            // print_r($data['userDetails']);die;
        }
        else
        {
            redirect(base_url().'agents');
        }
        $data['back_url'] = base_url().'order/admin/softpro-agents';

        $this->admintemplate->show("order/home", "edit_user", $data);
    }
}
