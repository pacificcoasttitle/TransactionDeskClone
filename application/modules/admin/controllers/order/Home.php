<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends MX_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */

	public function __construct()
    {
        parent::__construct();
        $this->load->helper(
            array('file', 'url','form')
        );
        $this->load->library('form_validation');
        $this->load->model('order/home_model'); 
    }
    
	public function login()
	{
        $data = array();
        $userdata = $this->session->userdata('admin');
        if (!empty($userdata['id']) && $userdata['is_admin'] == 1) {
            redirect(base_url().'order/admin/dashboard');
        } else {
            $data['msg'] = $this->session->userdata('msg');
            $this->session->unset_userdata('msg');
            $this->load->view('order/layout/login_header', $data);
            $this->load->view('order/home/login', $data);
            $this->load->view('order/layout/login_footer', $data);
        }		
	}

	public function do_login()
    {
    	if($this->input->post())
    	{
    		$email_address = $this->input->post('email_address');
        	$password      = $this->input->post('password');

            $admin = $this->home_model->get_admin_user($email_address, $password);
        	if ($admin) 
        	{
        		$session_data = array(
                    "id" => isset($admin['id']) && !empty($admin['id']) ? $admin['id'] : '',
                    "name" => isset($admin['user_name']) && !empty($admin['user_name']) ? $admin['user_name'] : '',
                    "email_address" => isset($admin['email_id']) && !empty($admin['email_id']) ? $admin['email_id'] : '',
                    "is_admin" => 1
                );

                $this->session->set_userdata('admin', $session_data);
                if ($this->input->is_ajax_request()) 
                {
                    $result = array('status'=>'success');
                    echo json_encode($result); exit;
                } 
                else 
                {
                    // redirect('home/dashboard');
                    redirect(base_url().'order/admin/dashboard');
                }
        	}
        	else 
        	{
                if ($this->input->is_ajax_request()) 
                {
                    $result = array('status'=>'error','msg'=>'Incorrect email or password');
                    echo json_encode($result); exit;
                } 
                else 
                {
                    $this->session->set_userdata('msg', 'Incorrect email or password');
                    // $result['msg'] = "Incorrect email or password";
                    redirect(base_url().'order/admin');
                }
            }
    	}
    }

    public function dashboard()
    {
        $this->is_admin();
    	$data = array();
        $data['title'] = 'PCT Order: Dashboard';
		$this->load->view('order/layout/header', $data);
        $this->load->view('order/home/dashboard', $data);
        $this->load->view('order/layout/footer', $data);
    }

    public function get_customer_list()
    {
        $params = array();
       // echo "<pre>"; print_r($_POST); exit;
        if(isset($_POST['draw']) && !empty($_POST['draw']))
        {
            $params['draw'] = isset($_POST['draw']) && !empty($_POST['draw']) ? $_POST['draw'] : 10;
            $params['length'] = isset($_POST['length']) && !empty($_POST['length']) ? $_POST['length'] : 10;
            $params['start'] = isset($_POST['start']) && !empty($_POST['start']) ? $_POST['start'] : 0;
            $params['orderColumn'] = isset($_POST['order'][0]['column']) && !empty($_POST['order'][0]['column']) ? $_POST['order'][0]['column'] : 0;
            $params['orderDir'] = isset($_POST['order'][0]['dir']) && !empty($_POST['order'][0]['dir']) ? $_POST['order'][0]['dir'] : 0;

            $params['searchvalue'] = isset($_POST['search']['value']) && !empty($_POST['search']['value']) ? $_POST['search']['value'] : '';
            $params['is_escrow'] = 1;

            $pageno = ($params['start'] / $params['length'])+1;

            $customer_lists = $this->home_model->get_customers($params);
            // $cnt = ($pageno == 1) ? ($params['start']+1) : (($pageno - 1) * $params['length']) + 1;

            $json_data['draw'] = intval( $params['draw'] );
        }
        else
        {
            $params['searchvalue'] = isset($_POST['keyword']) && !empty($_POST['keyword']) ? $_POST['keyword'] : '';
            $customer_lists = $this->home_model->get_customers($params);            
        }
        $data = array(); 
    	
	    if(isset($customer_lists['data']) && !empty($customer_lists['data']))
	    {
	    	foreach ($customer_lists['data'] as $key => $value) 
	    	{
	    		$nestedData=array();
	            /*$nestedData[] = $value['customer_number'];*/
	            $nestedData[] = $value['first_name'];
	            $nestedData[] = $value['last_name'];
	            $nestedData[] = $value['email_address'];
	            $nestedData[] = $value['telephone_no'];
	            $nestedData[] = $value['company_name'];
	            $nestedData[] = $value['street_address'];
	            $nestedData[] = $value['city'];
	            $nestedData[] = $value['zip_code'];
	                     
	            
                if(isset($_POST['draw']) && !empty($_POST['draw']))
                {
                    /*$action = "<a href='javascript:void(0);' class='btn btn-action edit-group' data-id=".$value->id." data-name='".$value->name."' title ='Edit Group Detail'><span class='fa fa-edit' aria-hidden='true'></span></a>";*/

                    $action = "<a href='javascript:void(0);' onclick='deleteCustomer(".$value['id'].")' class='btn btn-action'  title='Delete Customer'><span class='fa fa-trash' aria-hidden='true'></span></a>";
                    $nestedData[] = $action;
                }
	            
	            $data[] = $nestedData;            
	            // $cnt++;
	    	}
	    }
        $json_data['recordsTotal'] = intval( $customer_lists['recordsTotal'] );
        $json_data['recordsFiltered'] = intval( $customer_lists['recordsFiltered'] );
        $json_data['data'] = $data;
	    echo json_encode($json_data);
    }

    public function import()
    {    
        $this->is_admin();  
        $data = array();
        $data['title'] = 'PCT Order: Import';
    	if($this->input->post())
        {
            ini_set('max_execution_time', 0); 
            ini_set('memory_limit','2048M');
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

                    $password = md5('Pacific1');
                    
                    // Insert/update CSV data into database
                    if(!empty($csvData)){                        
                        foreach($csvData as $row)
                        {
                            $rowCount++;
                            if(isset($row['Email']) && !empty($row['Email']))
                            {
                                $email_address = str_replace(' ','',$row['Email']);
                                $email_address = strtolower($email_address);
                                // Prepare data for DB insertion
                                $customerData = array(
                                    'resware_user_id' => $row['Partner Employee ID'],
                                    'partner_id' => $row['Partner Company ID'],
                                    'first_name' => $row['First Name'],
                                    'last_name' => $row['Last Name'],
                                    'title' => $row['Title'],
                                    'telephone_no' => $row['Phone'],
                                    'email_address' => $email_address,
                                    'password' => $password,    
                                    'company_name' => $row['Company Name'],
                                    'street_address' => $row['Street1'],
                                    'street_address_2' => $row['Street2'],
                                    'city' => $row['City'],
                                    'state' => $row['State'],
                                    'zip_code' => $row['Zip'],
                                    'is_escrow' => 1,
                                    'status'=> 1,
                                );

                                $con = array(
                                    'where' => array(
                                        'email_address' => $email_address,
                                        'resware_user_id' => $row['Partner Employee ID'],
                                        'is_escrow' => 1
                                    ),
                                    'returnType' => 'count'
                                );
                                $prevCount = $this->home_model->get_rows($con);
                              
                                if($prevCount > 0){
                                    // Update member data
                                    // unset($customerData['customer_number']);
                                    $condition = array('email_address' => $email_address,'resware_user_id'=>$row['Partner Employee ID'],'is_escrow' => 1);
                                    $update = $this->home_model->update($customerData, $condition);
                                    
                                    if($update){
                                        $updateCount++;
                                    }
                                }else{
                                    // Insert member data
                                    $insert = $this->home_model->insert($customerData);
                                    
                                    if($insert){
                                        $insertCount++;
                                    }
                                }
                            }   
                            
                        }
                        
                        // Status message with imported data count
                        $notAddCount = ($rowCount - ($insertCount + $updateCount));
                        $successMsg = 'Customers imported successfully. Total Rows ('.$rowCount.') | Inserted ('.$insertCount.') | Updated ('.$updateCount.') | Not Inserted ('.$notAddCount.')';
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
		$this->load->view('order/layout/header', $data);
        $this->load->view('order/home/import', $data);
        $this->load->view('order/layout/footer', $data);
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

    public function delete_customer()
    {
        $this->is_admin();
    	$id = isset($_POST['id']) && !empty($_POST['id']) ? $_POST['id'] : '';

    	if($id)
    	{
    		$customerData = array('status' => 0);

            $condition = array('id' => $id);

            $update = $this->home_model->update($customerData, $condition);

            if($update)
            {
                $successMsg = 'Customer deleted successfully.';
                $response = array('status'=>'success', 'message'=>$successMsg);
            }
    	}
    	else
    	{
    		$msg = 'Customer ID is required.';
			$response = array('status' => 'error','message'=>$msg);
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

    public function logout()
    {
        $this->session->unset_userdata('admin');
        redirect(base_url().'order/admin');
    }

    public function import_lenders()
    {    
        $this->is_admin();  
        $data = array();
        $successMsg = '';
        $data['title'] = 'PCT Order: Import';
        if($this->input->post())
        {
            $lenderType = $this->input->post('lenderType');

            ini_set('max_execution_time', 0); 
            ini_set('memory_limit','2048M');
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

                    $password = md5('Pacific1');

                    // Insert/update CSV data into database
                    if(!empty($csvData))
                    {
                        foreach($csvData as $row)
                        {
                            $rowCount++;

                            if(isset($row['Email']) && !empty($row['Email']))
                            {
                                $email_address = str_replace(' ','',$row['Email']);
                                $email_address = strtolower($email_address);
                                // Prepare data for DB insertion
                                $lenderData = array(
                                    'resware_user_id' => $row['Partner Employee ID'],
                                    'partner_id' => $row['Partner Company ID'],
                                    'first_name' => $row['First Name'],
                                    'last_name' => $row['Last Name'],
                                    'title' => $row['Title'],
                                    'telephone_no' => $row['Phone'],
                                    'email_address' => $email_address,
                                    'password' => $password,    
                                    'company_name' => $row['Company Name'],
                                    'street_address' => $row['Street1'],
                                    'street_address_2' => $row['Street2'],
                                    'city' => $row['City'],
                                    'state' => $row['State'],
                                    'zip_code' => $row['Zip'],
                                    'is_escrow' => 0,
                                    'lender_type' => $lenderType,
                                    'status'=> 1,
                                );

                                $con = array(
                                    'where' => array(
                                        'email_address' => $email_address,
                                        'resware_user_id' => $row['Partner Employee ID'],
                                        'is_escrow' => 0
                                    ),
                                    'returnType' => 'count'
                                );
                                $prevCount = $this->home_model->get_rows($con);
                              
                                if($prevCount > 0){
                                    // Update member data
                                    $condition = array('email_address' => $email_address,'resware_user_id'=>$row['Partner Employee ID'],'is_escrow' => 0);
                                    $update = $this->home_model->update($lenderData, $condition);
                                    
                                    if($update){
                                        $updateCount++;
                                    }
                                }else{
                                    // Insert member data
                                    $insert = $this->home_model->insert($lenderData);
                                    
                                    if($insert){
                                        $insertCount++;
                                    }
                                }
                            }   
                                                        
                        }
                        
                        // Status message with imported data count
                        $notAddCount = ($rowCount - ($insertCount + $updateCount));
                        $successMsg = 'Lenders imported successfully. Total Rows ('.$rowCount.') | Inserted ('.$insertCount.') | Updated ('.$updateCount.') | Not Inserted ('.$notAddCount.')';
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
        $this->load->view('order/layout/header', $data);
        $this->load->view('order/home/import_lender', $data);
        $this->load->view('order/layout/footer', $data);
    }

    public function lenders()
    {
        $this->is_admin();
        $data = array();
        $data['title'] = 'PCT Order: Lenders';
        $this->load->view('order/layout/header', $data);
        $this->load->view('order/home/lenders', $data);
        $this->load->view('order/layout/footer', $data);
    }

    public function get_lender_list()
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
            $params['is_escrow'] = 0;

            $pageno = ($params['start'] / $params['length'])+1;

            $lender_lists = $this->home_model->get_customers($params);
            // $cnt = ($pageno == 1) ? ($params['start']+1) : (($pageno - 1) * $params['length']) + 1;

            $json_data['draw'] = intval( $params['draw'] );
        }
        else
        {
            $params['searchvalue'] = isset($_POST['keyword']) && !empty($_POST['keyword']) ? $_POST['keyword'] : '';
            $lender_lists = $this->home_model->get_customers($params);            
        }
        $data = array(); 
        
        if(isset($lender_lists['data']) && !empty($lender_lists['data']))
        {
            foreach ($lender_lists['data'] as $key => $value) 
            {
                $nestedData=array();
                $nestedData[] = $value['first_name'];
                $nestedData[] = $value['last_name'];
                $nestedData[] = $value['email_address'];
                // $nestedData[] = $value['telephone_no'];
                $nestedData[] = $value['company_name'];
                $nestedData[] = $value['street_address'];
                $nestedData[] = $value['city'];
                $nestedData[] = $value['zip_code'];
                $specialSel = $value['is_special_lender'] == 1 ? 'selected' : '';
                $normalSel = $value['is_special_lender'] == 0 ? 'selected' : '';
                $id = $value['id'];
                $nestedData[] = "<select onchange='changeLenderUserType($id, this.value);' id='user_type' name='user_type'><option $normalSel value='0'>Normal</option><option $specialSel value='1'>Special</option></select>";
                // $nestedData[] = $value['lender_type'];
                         
                
                if(isset($_POST['draw']) && !empty($_POST['draw']))
                {
                    /*$action = "<a href='javascript:void(0);' class='btn btn-action edit-group' data-id=".$value->id." data-name='".$value->name."' title ='Edit Group Detail'><span class='fa fa-edit' aria-hidden='true'></span></a>";*/

                    $action = "<a href='javascript:void(0);' onclick='deleteCustomer(".$value['id'].")' class='btn btn-action'  title='Delete Customer'><span class='fa fa-trash' aria-hidden='true'></span></a>";
                    $nestedData[] = $action;
                }
                
                $data[] = $nestedData;            
                // $cnt++;
            }
        }
        $json_data['recordsTotal'] = intval( $lender_lists['recordsTotal'] );
        $json_data['recordsFiltered'] = intval( $lender_lists['recordsFiltered'] );
        $json_data['data'] = $data;
        echo json_encode($json_data);
    }

    public function cpl_document()
    {
        $this->is_admin();
        $data = array();
        $data['title'] = 'PCT Order: CPL Documents';
        $this->load->view('order/layout/header', $data);
        $this->load->view('order/home/cpl_document', $data);
        $this->load->view('order/layout/footer', $data);
    }

    public function get_cpl_document_list()
    {
        $params = array();

        if (isset($_POST['draw']) && !empty($_POST['draw'])) {
            $params['draw'] = isset($_POST['draw']) && !empty($_POST['draw']) ? $_POST['draw'] : 10;
            $params['length'] = isset($_POST['length']) && !empty($_POST['length']) ? $_POST['length'] : 10;
            $params['start'] = isset($_POST['start']) && !empty($_POST['start']) ? $_POST['start'] : 0;
            $params['orderColumn'] = isset($_POST['order'][0]['column']) && !empty($_POST['order'][0]['column']) ? $_POST['order'][0]['column'] : 0;
            $params['orderDir'] = isset($_POST['order'][0]['dir']) && !empty($_POST['order'][0]['dir']) ? $_POST['order'][0]['dir'] : 0;
            $params['searchvalue'] = isset($_POST['search']['value']) && !empty($_POST['search']['value']) ? $_POST['search']['value'] : '';
            $params['is_escrow'] = 0;
            $pageno = ($params['start'] / $params['length'])+1;
            $cpl_document_list = $this->home_model->get_cpl_document_list($params);
            $json_data['draw'] = intval( $params['draw'] );
        } else {
            $params['searchvalue'] = isset($_POST['keyword']) && !empty($_POST['keyword']) ? $_POST['keyword'] : '';
            $cpl_document_list = $this->home_model->get_cpl_document_list($params);            
        }

        $data = array(); 
        
        if(isset($cpl_document_list['data']) && !empty($cpl_document_list['data'])) {
            foreach ($cpl_document_list['data'] as $key => $value) {
                $nestedData=array();
                $nestedData[] = $value['file_number'];
                $nestedData[] = $value['document_name'];
                $documentName = $value['document_name'];
                if ($value['api_document_id'] > 0) {
                    $nestedData[] = 'Yes';
                } else {
                    $nestedData[] = 'No';
                }
                $nestedData[] = date("m/d/Y h:i:s A", strtotime($value['created']));
                if(isset($_POST['draw']) && !empty($_POST['draw'])) {
                    $nestedData[] = "<div style='display:flex;'><a href='".base_url()."uploads/documents/$documentName' download><i class='fas fa-fw fa-download'></i></a>
                    <a style='margin-left:10px;' target='_blank' href='".base_url()."uploads/documents/$documentName'><i class='fas fa-fw fa-eye'></i></a></div>";
                }
                $data[] = $nestedData;            
            }
        }
        $json_data['recordsTotal'] = intval( $cpl_document_list['recordsTotal'] );
        $json_data['recordsFiltered'] = intval( $cpl_document_list['recordsFiltered'] );
        $json_data['data'] = $data;
        echo json_encode($json_data);
    }

    public function newUsers()
    {
        $this->is_admin();
        $data = array();
        $data['title'] = 'PCT Order: New Users';
        $this->load->view('order/layout/header', $data);
        $this->load->view('order/home/new_users', $data);
        $this->load->view('order/layout/footer', $data);
    }

    public function get_new_users_list()
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
            $new_users_lists = $this->home_model->get_new_users_list($params);
            $json_data['draw'] = intval( $params['draw'] );
        } else {
            $params['searchvalue'] = isset($_POST['keyword']) && !empty($_POST['keyword']) ? $_POST['keyword'] : '';
            $new_users_lists = $this->home_model->get_new_users_list($params);        
        }

        $data = array(); 
        if (isset($new_users_lists['data']) && !empty($new_users_lists['data'])) {
            foreach ($new_users_lists['data'] as $key => $value) {
                $nestedData=array();
                if(isset($_POST['draw']) && !empty($_POST['draw'])) { 
                    $nestedData[] = $value['first_name'];
                    $nestedData[] = $value['last_name'];
                    $nestedData[] = $value['email_address'];
                    $nestedData[] = $value['company_name'];
                    $nestedData[] = 'Pacific1';
                    $nestedData[] = $value['random_password'];
                } else {
                    $nestedData[] = $value['email_address'];
                    $nestedData[] = 'Pacific1';
                    $nestedData[] = $value['random_password'];
                }
                $data[] = $nestedData;            
            }
        }

        $json_data['recordsTotal'] = intval( $new_users_lists['recordsTotal'] );
        $json_data['recordsFiltered'] = intval( $new_users_lists['recordsFiltered'] );
        $json_data['data'] = $data;
        echo json_encode($json_data);
    }

    public function addNewUser()
    {
        $this->load->model('order/apiLogs');
        $userdata = $this->session->userdata('admin');
        $this->is_admin();
        $data = array();
        $data['title'] = 'PCT Order: Add New User';
        $salesRepData = array();

        if ($this->input->post()) {
            $this->form_validation->set_rules('first_name', 'First Name', 'required', array('required'=> 'Please Enter First Name'));
            $this->form_validation->set_rules('last_name', 'Last Name', 'required', array('required'=> 'Please Enter Last Name'));
            $this->form_validation->set_rules('email_address', 'Email', 'trim|required|valid_email', array('required'=> 'Please Enter Email', 'valid_email' => 'Please enter valid Email'));
            $this->form_validation->set_rules('company', 'Company', 'required', array('required'=> 'Please Enter Company'));
            $this->form_validation->set_rules('user_type', 'User type', 'required', array('required'=> 'Please Select User Type'));
            $this->form_validation->set_rules('address', 'Address', 'required', array('required'=> 'Please Enter Address'));
            $this->form_validation->set_rules('city', 'City', 'required', array('required'=> 'Please Enter City'));
            $this->form_validation->set_rules('state', 'State', 'required', array('required'=> 'Please Enter State'));
            $this->form_validation->set_rules('zipcode', 'Zipcode', 'required', array('required'=> 'Please Enter Zipcode'));
            $this->form_validation->set_rules('partner_id', 'Company', 'required', array('required'=> 'Please select company based on search'));

            if ($this->form_validation->run() == true) {
                $customerData = array(
                    'partner_id' =>  $this->input->post('partner_id'),
                    'resware_user_id' =>  !empty($this->input->post('resware_client_id')) ? $this->input->post('resware_client_id') : 0,
                    'first_name' => $this->input->post('first_name'),
                    'last_name' => $this->input->post('last_name'),
                    'telephone_no' => $this->input->post('telephone_no'),
                    'email_address' => $this->input->post('email_address'),
                    'password' => 'Pacific1',    
                    'company_name' => $this->input->post('company'),
                    'street_address' => $this->input->post('address'),
                    'city' => $this->input->post('city'),
                    'state' => $this->input->post('state'),
                    'zip_code' => $this->input->post('zipcode'),
                    'is_escrow' => $this->input->post('user_type') == 'escrow' ? 1 : 0,
                    'is_master' => 0,
                    'is_password_updated' => 0,
                    'is_new_user' => 1,
                    'status'=> 1,
                );
                $response = $this->addNewUserToResware($customerData);

                if ($response['success']) {
                    $customerData['resware_user_id'] = $response['resware_user_id'];
                    $customerData['random_password'] = $this->order->randomPassword();
                    $reswareUpdatePwdData = array(
                        'user_name' =>  $this->input->post('email_address'),
                        'password' => 'Pacific1',
                        'new_password' => $customerData['random_password'],
                    );
                    $logid = $this->apiLogs->syncLogs($userdata['id'], 'resware', 'change_password', env('RESWARE_UPDATE_PWD_API'), $reswareUpdatePwdData, array(), 0, 0);
                    $updatePwdResult = $this->updatePasswordResware($reswareUpdatePwdData);
                    $this->apiLogs->syncLogs($userdata['id'], 'resware', 'change_password', env('RESWARE_UPDATE_PWD_API'), $reswareUpdatePwdData, $updatePwdResult, 0, $logid);
                    $responsePwd = json_decode($updatePwdResult,true);

                    if(!empty($responsePwd['message'])) {
                        $customerData['resware_error_msg'] = $responsePwd['message'];
                        $data['error_msg'] = 'Password update failed due to: '.$responsePwd['message'];
                        
                    } else {
                        $customerData['is_password_updated'] = 1;
                        $data['success_msg'] = 'Password updated successfully for email user: '. $userInfo['email_address'];
                    }

                    if (!empty($this->input->post('resware_client_id'))) {
                        $condition = array(
                            'where' => array(
                                'partner_id' => $this->input->post('partner_id'),
                                'resware_user_id' => $this->input->post('resware_client_id'),
                            ),
                            'returnType' => 'count'
                        );
                        $prevCount = $this->home_model->get_rows($condition);
                        if ($prevCount > 0) {
                            $updateCondition = array(
                                'partner_id' => $this->input->post('partner_id'),
                                'resware_user_id' => $this->input->post('resware_client_id')
                            );
                            $update = $this->home_model->update($customerData, $updateCondition);
                        } else {
                            $insert = $this->home_model->insert($customerData);
                        }
                    } else {
                        $insert = $this->home_model->insert($customerData);
                    }
                } else {
                    $data['error_msg'] = $response['msg'];
                }
            } else {
                $data['first_name_error_msg'] = form_error('first_name');
                $data['last_name_error_msg'] = form_error('last_name');
                $data['email_address_error_msg'] = form_error('email_address');
                $data['company_error_msg'] = form_error('company');
                $data['user_type_error_msg'] = form_error('user_type');
                $data['address_error_msg'] = form_error('address');
                $data['city_error_msg'] = form_error('city');
                $data['state_error_msg'] = form_error('state');
                $data['zipcode_error_msg'] = form_error('zipcode');
                if (empty(form_error('company')) && !empty(form_error('partner_id'))) {
                    $data['company_error_msg'] = form_error('partner_id');
                }
            }                                       
        }
        $this->load->view('order/layout/header', $data);
        $this->load->view('order/home/add_new_user', $data);
        $this->load->view('order/layout/footer', $data);
    }

    function get_company_list()
    {
    	$searchTerm = isset($_POST['term']) && !empty($_POST['term']) ? $_POST['term'] : '';
    	$condition = array(
            'partner_name' => $searchTerm,
        );
    	$companyDetails = $this->home_model->get_company_list($condition);
        $companyInfo = array();
        
    	if (isset($companyDetails) && !empty($companyDetails)) {
    		foreach ($companyDetails as $key => $value) {
    			$data['id'] = isset($value['id']) && !empty($value['id']) ? $value['id'] : '';
	            $data['value'] = isset($value['value']) && !empty($value['value']) ? $value['value'] : '';
                $data['partner_id'] = isset($value['partner_id']) && !empty($value['partner_id']) ? $value['partner_id'] : '';
                $data['partner_name'] = isset($value['partner_name']) && !empty($value['partner_name']) ? $value['partner_name'] : '';
                $data['address1'] = isset($value['address1']) && !empty($value['address1']) ? $value['address1'] : '';
                $data['city'] = isset($value['city']) && !empty($value['city']) ? $value['city'] : '';
                $data['state'] = isset($value['state']) && !empty($value['state']) ? $value['state'] : '';
                $data['zip'] = isset($value['zip']) && !empty($value['zip']) ? $value['zip'] : '';
	            $companyInfo[] =$data;
    		}
    	}
    	echo json_encode($companyInfo);
    }

    public function addNewUserToResware($customerData)
    {
        $this->load->model('order/apiLogs');
        $this->load->library('order/resware');
        $this->load->library('order/order');
        $userdata = $this->session->userdata('admin');

        if(!empty($customerData['resware_user_id'])) {
            $endPoint = 'admin/partners/'.$customerData['partner_id'].'/employees/'.$customerData['resware_user_id'];
            $method = 'PUT';
            $apiType = 'update_user';
        } else {
            $endPoint = 'admin/partners/'.$customerData['partner_id'].'/employees';
            $method = 'POST';
            $apiType = 'create_user';
        }
        
        $newUserData = array(			
            'Password' => 'Pacific1',
            'Enabled' => true,
            'Roles' => array (
                0 => array (
                    'RoleID' => 5033,
                    'Name' => 'Web Services: Access All Files for ResWare-to-ResWare Services',
                ),
                1 => 
                array (
                    'RoleID' => 6013,
                    'Name' => 'Web Services: Add Actions',
                ),
                2 => 
                array (
                    'RoleID' => 6005,
                    'Name' => 'Web Services: Add Documents',
                ),
                3 => 
                array (
                    'RoleID' => 6002,
                    'Name' => 'Web Services: Add Notes',
                ),
                4 => 
                array (
                    'RoleID' => 6009,
                    'Name' => 'Web Services: Add Partners',
                ),
                5 => 
                array (
                    'RoleID' => 6015,
                    'Name' => 'Web Services: Add WebURL Documents',
                ),
                6 => 
                array (
                    'RoleID' => 5027,
                    'Name' => 'Web Services: Bypass Address Validation',
                ),
                7 => 
                array (
                    'RoleID' => 6003,
                    'Name' => 'Web Services: Cancel Files',
                ),
                8 => 
                array (
                    'RoleID' => 5023,
                    'Name' => 'Web Services: Estimate Costs as 2010 HUD',
                ),
                9 => 
                array (
                    'RoleID' => 6016,
                    'Name' => 'Web Services: Expense Reports',
                ),
                10 => 
                array (
                    'RoleID' => 6012,
                    'Name' => 'Web Services: Get Actions',
                ),
                11 => 
                array (
                    'RoleID' => 6007,
                    'Name' => 'Web Services: Get Custom Fields',
                ),
                12 => 
                array (
                    'RoleID' => 6006,
                    'Name' => 'Web Services: Get Documents',
                ),
                13 => 
                array (
                    'RoleID' => 6001,
                    'Name' => 'Web Services: Get Notes',
                ),
                14 => 
                array (
                    'RoleID' => 6010,
                    'Name' => 'Web Services: Get Partners',
                ),
                15 => 
                array (
                    'RoleID' => 69,
                    'Name' => 'Web Services: Order Placement',
                ),
                16 => 
                array (
                    'RoleID' => 6004,
                    'Name' => 'Web Services: Override Property Address Validation and Reformatting',
                ),
                17 => 
                array (
                    'RoleID' => 6011,
                    'Name' => 'Web Services: Remove Partners',
                ),
                18 => 
                array (
                    'RoleID' => 6014,
                    'Name' => 'Web Services: Search Files',
                ),
                19 => 
                array (
                    'RoleID' => 6019,
                    'Name' => 'Web Services: Update Partner',
                ),
                20 => 
                array (
                    'RoleID' => 6008,
                    'Name' => 'Web Services: Write Custom Fields',
                ),
                21 => 
                array (
                    'RoleID' => 51,
                    'Name' => 'Website',
                ),
            ),
            'WebsiteAccess' => true,
            'Name' => $customerData['email_address'],
            'PasswordExpirationDate' => '/Date(3025656585000-0000)/',
            'FirstName' => $customerData['first_name'],
            'LastName' => $customerData['last_name'],
            'ContactInformation' => array(
                'EmailAddress' => $customerData['email_address'],
            ),
        );

        $userdata['email'] = $userdata['email_address'];
        $userdata['admin_api'] = 1;
        $newUserData = json_encode($newUserData);
        $logid = $this->apiLogs->syncLogs($userdata['id'], 'resware', $apiType, env('RESWARE_ORDER_API').$endPoint, $newUserData, array(), 0, 0);
        $result = $this->resware->make_request($method, $endPoint, $newUserData, $userdata);
        $this->apiLogs->syncLogs($v['id'], 'resware', $apiType, env('RESWARE_ORDER_API').$endPoint, $newUserData, $result, 0, $logid);

        if (isset($result) && !empty($result)) {
            $response = json_decode($result,true);
            if (isset($response['Employee']) && !empty($response['Employee'])) {
                $res = array(
                    'resware_user_id' => $response['Employee']['UserID'],
                    'msg' => !empty($customerData['resware_user_id']) ? 'User created successfully on Resware Side' : 'User updated successfully on Resware Side',
                    'success' => true
                );
            } else {
                $res = array(
                    'resware_user_id' => 0,
                    'msg' => $response['ResponseStatus']['Message'],
                    'success' => false
                );
            }
        } else {
            $res = array(
                'resware_user_id' => 0,
                'msg' => 'Something wrong! Please try again',
                'success' => false
            );
        }
        return $res;
    }

    public function grant_deed_document()
    {
        $this->is_admin();
        $data = array();
        $data['title'] = 'PCT Order: Grant Deed Documents';
        $this->load->view('order/layout/header', $data);
        $this->load->view('order/home/grant_deed_document', $data);
        $this->load->view('order/layout/footer', $data);
    }

    public function lv_document()
    {
        $this->is_admin();
        $data = array();
        $data['title'] = 'PCT Order: Legal & Vesting Documents';
        $this->load->view('order/layout/header', $data);
        $this->load->view('order/home/lv_document', $data);
        $this->load->view('order/layout/footer', $data);
    }

    public function get_grant_deed_document_list()
    {
        $params = array();

        if (isset($_POST['draw']) && !empty($_POST['draw'])) {
            $params['draw'] = isset($_POST['draw']) && !empty($_POST['draw']) ? $_POST['draw'] : 10;
            $params['length'] = isset($_POST['length']) && !empty($_POST['length']) ? $_POST['length'] : 10;
            $params['start'] = isset($_POST['start']) && !empty($_POST['start']) ? $_POST['start'] : 0;
            $params['orderColumn'] = isset($_POST['order'][0]['column']) && !empty($_POST['order'][0]['column']) ? $_POST['order'][0]['column'] : 0;
            $params['orderDir'] = isset($_POST['order'][0]['dir']) && !empty($_POST['order'][0]['dir']) ? $_POST['order'][0]['dir'] : 0;
            $params['searchvalue'] = isset($_POST['search']['value']) && !empty($_POST['search']['value']) ? $_POST['search']['value'] : '';
            $params['is_escrow'] = 0;
            $pageno = ($params['start'] / $params['length'])+1;
            $grant_document_lists = $this->home_model->get_grant_deed_document_list($params);
            $json_data['draw'] = intval( $params['draw'] );
        } else {
            $params['searchvalue'] = isset($_POST['keyword']) && !empty($_POST['keyword']) ? $_POST['keyword'] : '';
            $grant_document_lists = $this->home_model->get_grant_deed_document_list($params);            
        }

        $data = array(); 
        
        if(isset($grant_document_lists['data']) && !empty($grant_document_lists['data'])) {
            foreach ($grant_document_lists['data'] as $key => $value) {
                $nestedData=array();
                $nestedData[] = $value['file_number'];
                $nestedData[] = $value['document_name'];
                $documentName = $value['document_name'];
                if ($value['api_document_id'] > 0) {
                    $nestedData[] = 'Yes';
                } else {
                    $nestedData[] = 'No';
                }
                $nestedData[] = date("m/d/Y h:i:s A", strtotime($value['created']));
                if(isset($_POST['draw']) && !empty($_POST['draw'])) {
                    $nestedData[] = "<div style='display:flex;'><a href='".base_url()."uploads/grant-deed/$documentName' download><i class='fas fa-fw fa-download'></i></a>
                    <a style='margin-left:10px;' target='_blank' href='".base_url()."uploads/grant-deed/$documentName'><i class='fas fa-fw fa-eye'></i></a></div>";
                }
                $data[] = $nestedData;            
            }
        }
        $json_data['recordsTotal'] = intval( $grant_document_lists['recordsTotal'] );
        $json_data['recordsFiltered'] = intval( $grant_document_lists['recordsFiltered'] );
        $json_data['data'] = $data;
        echo json_encode($json_data);
    }

    public function get_lv_document_list()
    {
        $params = array();

        if (isset($_POST['draw']) && !empty($_POST['draw'])) {
            $params['draw'] = isset($_POST['draw']) && !empty($_POST['draw']) ? $_POST['draw'] : 10;
            $params['length'] = isset($_POST['length']) && !empty($_POST['length']) ? $_POST['length'] : 10;
            $params['start'] = isset($_POST['start']) && !empty($_POST['start']) ? $_POST['start'] : 0;
            $params['orderColumn'] = isset($_POST['order'][0]['column']) && !empty($_POST['order'][0]['column']) ? $_POST['order'][0]['column'] : 0;
            $params['orderDir'] = isset($_POST['order'][0]['dir']) && !empty($_POST['order'][0]['dir']) ? $_POST['order'][0]['dir'] : 0;
            $params['searchvalue'] = isset($_POST['search']['value']) && !empty($_POST['search']['value']) ? $_POST['search']['value'] : '';
            $params['is_escrow'] = 0;
            $pageno = ($params['start'] / $params['length'])+1;
            $lv_document_lists = $this->home_model->get_lv_document_list($params);
            $json_data['draw'] = intval( $params['draw'] );
        } else {
            $params['searchvalue'] = isset($_POST['keyword']) && !empty($_POST['keyword']) ? $_POST['keyword'] : '';
            $lv_document_lists = $this->home_model->get_lv_document_list($params);            
        }

        $data = array(); 
        
        if(isset($lv_document_lists['data']) && !empty($lv_document_lists['data'])) {
            foreach ($lv_document_lists['data'] as $key => $value) {
                $nestedData=array();
                $nestedData[] = $value['file_number'];
                $nestedData[] = $value['document_name'];
                $documentName = $value['document_name'];
                if ($value['api_document_id'] > 0) {
                    $nestedData[] = 'Yes';
                } else {
                    $nestedData[] = 'No';
                }
                $nestedData[] = date("m/d/Y h:i:s A", strtotime($value['created']));
                if(isset($_POST['draw']) && !empty($_POST['draw'])) {
                    $nestedData[] = "<div style='display:flex;'><a href='".base_url()."uploads/legal-vesting/$documentName' download><i class='fas fa-fw fa-download'></i></a>
                    <a style='margin-left:10px;' target='_blank' href='".base_url()."uploads/legal-vesting/$documentName'><i class='fas fa-fw fa-eye'></i></a></div>";
                }
                $data[] = $nestedData;            
            }
        }
        $json_data['recordsTotal'] = intval( $lv_document_lists['recordsTotal'] );
        $json_data['recordsFiltered'] = intval( $lv_document_lists['recordsFiltered'] );
        $json_data['data'] = $data;
        echo json_encode($json_data);
    }

    public function masterUsers()
    {
        $this->is_admin();
        $data = array();
        $data['title'] = 'PCT Order: Master Users';
        $this->load->view('order/layout/header', $data);
        $this->load->view('order/home/master_users', $data);
        $this->load->view('order/layout/footer', $data);
    }

    public function get_master_users_list()
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
            $master_users_lists = $this->home_model->get_master_users_list($params);
            $json_data['draw'] = intval( $params['draw'] );
        } else {
            $params['searchvalue'] = isset($_POST['keyword']) && !empty($_POST['keyword']) ? $_POST['keyword'] : '';
            $master_users_lists = $this->home_model->get_master_users_list($params);        
        }

        $data = array(); 
        if (isset($master_users_lists['data']) && !empty($master_users_lists['data'])) {
            foreach ($master_users_lists['data'] as $key => $value) {
                $nestedData=array();
                $nestedData[] = $value['first_name'];
                $nestedData[] = $value['last_name'];
                $nestedData[] = $value['email_address'];
                $nestedData[] = $value['street_address'].", ".$value['city'].", ".$value['state'].", ".$value['zip_code'];
                if(isset($_POST['draw']) && !empty($_POST['draw'])) {
                    $nestedData[] = "<a href='javascript:void(0);' onclick='deleteMasterUser(".$value['id'].")' class='btn btn-action'  title='Delete Master User'><span class='fa fa-trash' aria-hidden='true'></span></a>";
                }
                $data[] = $nestedData;            
            }
        }

        $json_data['recordsTotal'] = intval( $master_users_lists['recordsTotal'] );
        $json_data['recordsFiltered'] = intval( $master_users_lists['recordsFiltered'] );
        $json_data['data'] = $data;
        echo json_encode($json_data);
    }

    public function addNewMasterUser()
    {
        $this->is_admin();
        $data = array();
        $data['title'] = 'PCT Order: Add New Master User';
        $salesRepData = array();

        if ($this->input->post()) {
            $this->form_validation->set_rules('first_name', 'First Name', 'required', array('required'=> 'Please Enter First Name'));
            $this->form_validation->set_rules('last_name', 'Last Name', 'required', array('required'=> 'Please Enter Last Name'));
            $this->form_validation->set_rules('email_address', 'Email', 'trim|required|valid_email', array('required'=> 'Please Enter Email', 'valid_email' => 'Please enter valid Email'));
            $this->form_validation->set_rules('company', 'Company', 'required', array('required'=> 'Please Enter Company'));
            $this->form_validation->set_rules('address', 'Address', 'required', array('required'=> 'Please Enter Address'));
            $this->form_validation->set_rules('city', 'City', 'required', array('required'=> 'Please Enter City'));
            $this->form_validation->set_rules('state', 'State', 'required', array('required'=> 'Please Enter State'));
            $this->form_validation->set_rules('zipcode', 'Zipcode', 'required', array('required'=> 'Please Enter Zipcode'));
            
            if ($this->form_validation->run() == true) {
                $customerData = array(
                    'first_name' => $this->input->post('first_name'),
                    'last_name' => $this->input->post('last_name'),
                    'telephone_no' => $this->input->post('telephone_no'),
                    'email_address' => $this->input->post('email_address'),
                    'password' => 'Pacific1',    
                    'company_name' => $this->input->post('company'),
                    'street_address' => $this->input->post('address'),
                    'city' => $this->input->post('city'),
                    'state' => $this->input->post('state'),
                    'zip_code' => $this->input->post('zipcode'),
                    'is_escrow' => 0,
                    'is_master' => 1,
                    'is_password_updated' => 1,
                    'is_new_user' => 0,
                    'status'=> 1,
                );
                $insert = $this->home_model->insert($customerData);
                if ($insert) {
                    $data['success_msg'] = 'Master User added successfully.';
                } else {
                    $data['error_msg'] = 'User not added.';
                } 
            } else {
                $data['first_name_error_msg'] = form_error('first_name');
                $data['last_name_error_msg'] = form_error('last_name');
                $data['email_address_error_msg'] = form_error('email_address');
                $data['company_error_msg'] = form_error('company');
                $data['address_error_msg'] = form_error('address');
                $data['city_error_msg'] = form_error('city');
                $data['state_error_msg'] = form_error('state');
                $data['zipcode_error_msg'] = form_error('zipcode');
            }                                       
        }
        $this->load->view('order/layout/header', $data);
        $this->load->view('order/home/add_new_master_user', $data);
        $this->load->view('order/layout/footer', $data);
    }

    public function tax_document()
    {
        $this->is_admin();
        $data = array();
        $data['title'] = 'PCT Order: Tax Documents';
        $this->load->view('order/layout/header', $data);
        $this->load->view('order/home/tax_document', $data);
        $this->load->view('order/layout/footer', $data);
    }

    public function get_tax_document_list()
    {
        $params = array();

        if (isset($_POST['draw']) && !empty($_POST['draw'])) {
            $params['draw'] = isset($_POST['draw']) && !empty($_POST['draw']) ? $_POST['draw'] : 10;
            $params['length'] = isset($_POST['length']) && !empty($_POST['length']) ? $_POST['length'] : 10;
            $params['start'] = isset($_POST['start']) && !empty($_POST['start']) ? $_POST['start'] : 0;
            $params['orderColumn'] = isset($_POST['order'][0]['column']) && !empty($_POST['order'][0]['column']) ? $_POST['order'][0]['column'] : 0;
            $params['orderDir'] = isset($_POST['order'][0]['dir']) && !empty($_POST['order'][0]['dir']) ? $_POST['order'][0]['dir'] : 0;
            $params['searchvalue'] = isset($_POST['search']['value']) && !empty($_POST['search']['value']) ? $_POST['search']['value'] : '';
            $params['is_escrow'] = 0;
            $pageno = ($params['start'] / $params['length'])+1;
            $tax_document_lists = $this->home_model->get_tax_document_list($params);
            $json_data['draw'] = intval( $params['draw'] );
        } else {
            $params['searchvalue'] = isset($_POST['keyword']) && !empty($_POST['keyword']) ? $_POST['keyword'] : '';
            $tax_document_lists = $this->home_model->get_tax_document_list($params);            
        }

        $data = array(); 
        
        if(isset($tax_document_lists['data']) && !empty($tax_document_lists['data'])) {
            foreach ($tax_document_lists['data'] as $key => $value) {
                $nestedData=array();
                $nestedData[] = $value['file_number'];
                $nestedData[] = $value['document_name'];
                $documentName = $value['document_name'];
                if ($value['api_document_id'] > 0) {
                    $nestedData[] = 'Yes';
                } else {
                    $nestedData[] = 'No';
                }
                $nestedData[] = date("m/d/Y h:i:s A", strtotime($value['created']));
                if(isset($_POST['draw']) && !empty($_POST['draw'])) {
                    $nestedData[] = "<div style='display:flex;'><a href='".base_url()."uploads/tax/$documentName' download><i class='fas fa-fw fa-download'></i></a>
                    <a style='margin-left:10px;' target='_blank' href='".base_url()."uploads/tax/$documentName'><i class='fas fa-fw fa-eye'></i></a></div>";
                }
                $data[] = $nestedData;            
            }
        }
        $json_data['recordsTotal'] = intval( $tax_document_lists['recordsTotal'] );
        $json_data['recordsFiltered'] = intval( $tax_document_lists['recordsFiltered'] );
        $json_data['data'] = $data;
        echo json_encode($json_data);
    }

    public function curative_document()
    {
        $this->is_admin();
        $data = array();
        $data['title'] = 'PCT Order: Curative Documents';
        $this->load->view('order/layout/header', $data);
        $this->load->view('order/home/curative_document', $data);
        $this->load->view('order/layout/footer', $data);
    }

    public function get_curative_document_list()
    {
        $params = array();

        if (isset($_POST['draw']) && !empty($_POST['draw'])) {
            $params['draw'] = isset($_POST['draw']) && !empty($_POST['draw']) ? $_POST['draw'] : 10;
            $params['length'] = isset($_POST['length']) && !empty($_POST['length']) ? $_POST['length'] : 10;
            $params['start'] = isset($_POST['start']) && !empty($_POST['start']) ? $_POST['start'] : 0;
            $params['orderColumn'] = isset($_POST['order'][0]['column']) && !empty($_POST['order'][0]['column']) ? $_POST['order'][0]['column'] : 0;
            $params['orderDir'] = isset($_POST['order'][0]['dir']) && !empty($_POST['order'][0]['dir']) ? $_POST['order'][0]['dir'] : 0;
            $params['searchvalue'] = isset($_POST['search']['value']) && !empty($_POST['search']['value']) ? $_POST['search']['value'] : '';
            $params['is_escrow'] = 0;
            $pageno = ($params['start'] / $params['length'])+1;
            $curative_document_lists = $this->home_model->get_curative_document_list($params);
            $json_data['draw'] = intval( $params['draw'] );
        } else {
            $params['searchvalue'] = isset($_POST['keyword']) && !empty($_POST['keyword']) ? $_POST['keyword'] : '';
            $curative_document_lists = $this->home_model->get_curative_document_list($params);            
        }

        $data = array(); 
        
        if(isset($curative_document_lists['data']) && !empty($curative_document_lists['data'])) {
            foreach ($curative_document_lists['data'] as $key => $value) {
                $nestedData=array();
                $nestedData[] = $value['file_number'];
                $nestedData[] = $value['document_name'];
                $documentName = $value['document_name'];
                if ($value['api_document_id'] > 0) {
                    $nestedData[] = 'Yes';
                } else {
                    $nestedData[] = 'No';
                }
                $nestedData[] = date("m/d/Y h:i:s A", strtotime($value['created']));
                if(isset($_POST['draw']) && !empty($_POST['draw'])) {
                    $nestedData[] = "<div style='display:flex;'><a href='".base_url()."uploads/curative/$documentName' download><i class='fas fa-fw fa-download'></i></a>
                    <a style='margin-left:10px;' target='_blank' href='".base_url()."uploads/curative/$documentName'><i class='fas fa-fw fa-eye'></i></a></div>";
                }
                $data[] = $nestedData;            
            }
        }
        $json_data['recordsTotal'] = intval( $curative_document_lists['recordsTotal'] );
        $json_data['recordsFiltered'] = intval( $curative_document_lists['recordsFiltered'] );
        $json_data['data'] = $data;
        echo json_encode($json_data);
    }

    public function changeLenderUserType()
    {
        $selectValue = $this->input->post('selectValue');
        $user_id = $this->input->post('user_id');
		$customerData = array('is_special_lender' => $selectValue);
        $condition = array('id' => $user_id);
        $update = $this->home_model->update($customerData, $condition);

		if ($update) {
			echo json_encode(array('success' => true)); 
		} else {
			echo json_encode(array('success' => false)); 
		} 
    }

    public function companies()
    {
        $this->is_admin();
        $data = array();
        $data['title'] = 'PCT Order: Companies';
        $this->load->view('order/layout/header', $data);
        $this->load->view('order/home/companies', $data);
        $this->load->view('order/layout/footer', $data);
    }

    public function get_companies_list()
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
            $company_lists = $this->home_model->get_companies_list($params);
            $json_data['draw'] = intval( $params['draw'] );
        } else {
            $params['searchvalue'] = isset($_POST['keyword']) && !empty($_POST['keyword']) ? $_POST['keyword'] : '';
            $company_lists = $this->home_model->get_companies_list($params);        
        }

        $data = array(); 
        if (isset($company_lists['data']) && !empty($company_lists['data'])) {
            foreach ($company_lists['data'] as $key => $value) {
                $nestedData=array();
                $nestedData[] = $value['partner_id'];
                $nestedData[] = $value['partner_name'];
                $nestedData[] = $value['address1'];
                $nestedData[] = $value['city'];
                $nestedData[] = $value['state'];
                $nestedData[] = $value['zip'];
                $data[] = $nestedData;            
            }
        }

        $json_data['recordsTotal'] = intval( $company_lists['recordsTotal'] );
        $json_data['recordsFiltered'] = intval( $company_lists['recordsFiltered'] );
        $json_data['data'] = $data;
        echo json_encode($json_data);
    }

    public function addCompany()
    {
        $this->load->model('order/apiLogs');
        $this->load->library('order/order');
        $this->load->library('order/resware');
        $this->is_admin();
        $data = array();
        $data['title'] = 'PCT Order: Add Company';
        $userdata = $this->session->userdata('admin');
        $userdata['email'] = $userdata['email_address'];
        $userdata['admin_api'] = 1;

        if ($this->input->post()) {
            $this->form_validation->set_rules('resware_company_id', 'Resware Partner Company Id', 'required', array('required'=> 'Please Enter Resware Partner Company Id'));
        
            if ($this->form_validation->run() == true) {
                $partner_id = $this->input->post('resware_company_id');
                $endPoint = 'admin/partners/'.$partner_id;
                $userdata['email'] = $userdata['email_address'];
                $logid = $this->apiLogs->syncLogs($userdata['id'], 'resware', 'get_partner_information', env('RESWARE_ORDER_API').$endPoint, array(), array(), 0, 0);
                $result = $this->resware->make_request('GET', $endPoint, array(), $userdata);
                $this->apiLogs->syncLogs($v['id'], 'resware', 'get_partner_information', env('RESWARE_ORDER_API').$endPoint, array(), $result, 0, $logid);

                if (isset($result) && !empty($result)) {
                    $response = json_decode($result,true);
                    
                    if (isset($response['AdminPartner']) && !empty($response['AdminPartner'])) {
                        $companyData = array(
                            'partner_id' => trim($response['AdminPartner']['PartnerCompanyID']),
                            'partner_name' => trim($response['AdminPartner']['PartnerName']),
                            'address1' => trim($response['AdminPartner']['MailingAddress']['Address1']),
                            'city' => trim($response['AdminPartner']['MailingAddress']['City']),
                            'state' => trim($response['AdminPartner']['MailingAddress']['State']),
                            'zip' => trim($response['AdminPartner']['MailingAddress']['Zip'])
                        );
                        $companyExist = $this->order->checkCompanyExist($partner_id);
                        if ($companyExist) {
                            $condition = array(
                                'partner_id' => $response['AdminPartner']['PartnerCompanyID']
                            );
                            unset($companyData['partner_id']);
                            $update = $this->home_model->update($companyData, $condition, 'pct_order_partner_company_info');
                            $data['success_msg'] = 'Company information updated successfully.';
                           
                        } else {
                            $insert = $this->home_model->insert($companyData, 'pct_order_partner_company_info');
                            $data['success_msg'] = 'Company information added successfully.';
                        }
                        
                    } else {
                        $data['error_msg'] = 'User is not found with this id on Resware side.';
                    }
                } else {
                    $data['error_msg'] = 'Something went wrong. Please try again.';
                }

               
            } else {
                $data['resware_company_id_error_msg'] = form_error('resware_company_id');
            }                                       
        }
        $this->load->view('order/layout/header', $data);
        $this->load->view('order/home/add_company', $data);
        $this->load->view('order/layout/footer', $data);
    }

    public function primaryCheck()
    {
        $this->is_admin();
        $data = array();
        $data['title'] = 'PCT Order: Primary Account';

        $users = $this->home_model->get_user_with_duplicate_email($params);

        if(isset($users) && !empty($users))
        {
            $new_users = array();
            foreach ($users as $key => $value) 
            {
                $new_users[$value['email_address']][] = $value;
            }
        }
        
        $data['users'] = $new_users;
        $this->load->view('order/layout/header', $data);
        $this->load->view('order/home/users_check', $data);
        $this->load->view('order/layout/footer', $data);
    }

    public function make_customer_primary()
    {
        $this->load->model('order/apiLogs');
        $this->load->library('order/order');
        $this->load->library('order/resware');
        $this->is_admin();
        $id = isset($_POST['id']) && !empty($_POST['id']) ? $_POST['id'] : '';
        $email = isset($_POST['email']) && !empty($_POST['email']) ? $_POST['email'] : '';
        $userdata = $this->session->userdata('admin');
        $userdata['email'] = $userdata['email_address'];
        $userdata['admin_api'] = 1;

        if($id) {
            $userLists = $this->home_model->getUsersForEmail($email, $id);

            if(!empty($userLists)) {

                foreach($userLists as $user) {

                    if (!empty($user['resware_user_id']) && !empty($user['partner_id']) && !empty($user['email_address'])) {
                        $endPoint = 'admin/partners/'.$user['partner_id'].'/employees/'.$user['resware_user_id'];
                        $userUpdateData = array(			
                            'Enabled' => false,
                            'WebsiteAccess' => false,
                            'FirstName' => $user['first_name'],
                            'LastName' => $user['last_name'],
                            'ContactInformation' => array(
                                'EmailAddress' => $user['email_address'],
                            ),
                        );
                        $userUpdateData = json_encode($userUpdateData);
                        $logid = $this->apiLogs->syncLogs($user['id'], 'resware', 'update_password', env('RESWARE_ORDER_API').$endPoint, $userUpdateData, array(), 0, 0);
                        $result = $this->resware->make_request('PUT', $endPoint, $userUpdateData, $userdata);
                        $this->apiLogs->syncLogs($user['id'], 'resware', 'update_password', env('RESWARE_ORDER_API').$endPoint, $userUpdateData, $result, 0, $logid);

                        if (isset($result) && !empty($result)) {
                            $response = json_decode($result,true);
                            
                            if (isset($response['Employee']) && !empty($response['Employee'])) {
                                $condition = array(
                                    'id' => $user['id']
                                );
                                $customerData = array(
                                    'is_password_updated' => 0,
                                    'is_new_user' => 0,
                                    'random_password' => '',
                                    'password' => 'Pacific1',
                                    'is_primary' => 0
                                );
                                $update = $this->home_model->update($customerData, $condition, 'customer_basic_details');
                            } else {
                                $msg = 'Something went wrong. Please try again.';
                                $response = array('status' => 'error', 'message' => $msg);
                                echo json_encode($response);exit;
                            }
                        } else {
                            $msg = 'Something went wrong. Please try again.';
                            $response = array('status' => 'error', 'message' => $msg);
                            echo json_encode($response);exit;
                        }
                    }
                }
            }

            $params = array(
                'id' => $id
            );
            $userInfo = $this->home_model->get_rows($params);
            $userUpdateData = array();

            if (!empty($userInfo['resware_user_id']) && !empty($userInfo['partner_id']) && !empty($userInfo['email_address'])) {
                $endPoint = 'admin/partners/'.$userInfo['partner_id'].'/employees/'.$userInfo['resware_user_id'];
                $userUpdateData = array(			
                    'Password' => 'Pacific1',
                    'Enabled' => true,
                    'Roles' => array (
                        0 => array (
                            'RoleID' => 5033,
                            'Name' => 'Web Services: Access All Files for ResWare-to-ResWare Services',
                        ),
                        1 => 
                        array (
                        'RoleID' => 6013,
                        'Name' => 'Web Services: Add Actions',
                        ),
                        2 => 
                        array (
                        'RoleID' => 6005,
                        'Name' => 'Web Services: Add Documents',
                        ),
                        3 => 
                        array (
                        'RoleID' => 6002,
                        'Name' => 'Web Services: Add Notes',
                        ),
                        4 => 
                        array (
                        'RoleID' => 6009,
                        'Name' => 'Web Services: Add Partners',
                        ),
                        5 => 
                        array (
                        'RoleID' => 6015,
                        'Name' => 'Web Services: Add WebURL Documents',
                        ),
                        6 => 
                        array (
                        'RoleID' => 5027,
                        'Name' => 'Web Services: Bypass Address Validation',
                        ),
                        7 => 
                        array (
                        'RoleID' => 6003,
                        'Name' => 'Web Services: Cancel Files',
                        ),
                        8 => 
                        array (
                        'RoleID' => 5023,
                        'Name' => 'Web Services: Estimate Costs as 2010 HUD',
                        ),
                        9 => 
                        array (
                        'RoleID' => 6016,
                        'Name' => 'Web Services: Expense Reports',
                        ),
                        10 => 
                        array (
                        'RoleID' => 6012,
                        'Name' => 'Web Services: Get Actions',
                        ),
                        11 => 
                        array (
                        'RoleID' => 6007,
                        'Name' => 'Web Services: Get Custom Fields',
                        ),
                        12 => 
                        array (
                        'RoleID' => 6006,
                        'Name' => 'Web Services: Get Documents',
                        ),
                        13 => 
                        array (
                        'RoleID' => 6001,
                        'Name' => 'Web Services: Get Notes',
                        ),
                        14 => 
                        array (
                        'RoleID' => 6010,
                        'Name' => 'Web Services: Get Partners',
                        ),
                        15 => 
                        array (
                        'RoleID' => 69,
                        'Name' => 'Web Services: Order Placement',
                        ),
                        16 => 
                        array (
                        'RoleID' => 6004,
                        'Name' => 'Web Services: Override Property Address Validation and Reformatting',
                        ),
                        17 => 
                        array (
                        'RoleID' => 6011,
                        'Name' => 'Web Services: Remove Partners',
                        ),
                        18 => 
                        array (
                        'RoleID' => 6014,
                        'Name' => 'Web Services: Search Files',
                        ),
                        19 => 
                        array (
                        'RoleID' => 6019,
                        'Name' => 'Web Services: Update Partner',
                        ),
                        20 => 
                        array (
                        'RoleID' => 6008,
                        'Name' => 'Web Services: Write Custom Fields',
                        ),
                        21 => 
                        array (
                        'RoleID' => 51,
                        'Name' => 'Website',
                        ),
                    ),
                    'WebsiteAccess' => true,
                    'Name' => $userInfo['email_address'],
                    'PasswordExpirationDate' => '/Date(3025656585000-0000)/',
                    'FirstName' => $userInfo['first_name'],
                    'LastName' => $userInfo['last_name'],
                    'ContactInformation' => array(
                        'EmailAddress' => $userInfo['email_address'],
                    ),
                );
                $userUpdateData = json_encode($userUpdateData);
                $logid = $this->apiLogs->syncLogs($userInfo['id'], 'resware', 'update_password', env('RESWARE_ORDER_API').$endPoint, $userUpdateData, array(), 0, 0);
                $result = $this->resware->make_request('PUT', $endPoint, $userUpdateData, $userdata);
                $this->apiLogs->syncLogs($userInfo['id'], 'resware', 'update_password', env('RESWARE_ORDER_API').$endPoint, $userUpdateData, $result, 0, $logid);
                
                if (isset($result) && !empty($result)) {
                    $response = json_decode($result,true);
                    
                    if (isset($response['Employee']) && !empty($response['Employee'])) {
                        $random_password = $this->order->randomPassword();
                        $reswareUpdatePwdData = array(
                            'user_name' =>  $userInfo['email_address'],
                            'password' => 'Pacific1',
                            'new_password' => $random_password,
                        );
                        
                        $logid = $this->apiLogs->syncLogs($userInfo['id'], 'resware', 'change_password', env('RESWARE_UPDATE_PWD_API'), $reswareUpdatePwdData, array(), 0, 0);
                        $updatePwdResult = $this->updatePasswordResware($reswareUpdatePwdData);
                        $this->apiLogs->syncLogs($userInfo['id'], 'resware', 'change_password', env('RESWARE_UPDATE_PWD_API'), $reswareUpdatePwdData, $updatePwdResult, 0, $logid);
                        $responsePwd = json_decode($updatePwdResult,true);
                        $condition = array(
                            'id' => $userInfo['id']
                        );
                        $customerData = array(
                            'is_password_updated' => 0,
                            'random_password' => $random_password,
                            'password' => 'Pacific1',
                            'is_primary' => 1
                        );

                        if(!empty($responsePwd['message'])) {
                            $customerData['is_password_updated'] = 0;
                            $customerData['resware_error_msg'] = $responsePwd['message'];
                            $response = array('status' => 'error', 'message' =>  'Password update failed due to: '.$responsePwd['message']);
                        } else {
                            $customerData['is_password_updated'] = 1;
                            $response = array('status' => 'success', 'message' =>  'Password updated successfully for email user: '. $userInfo['email_address']);
                        }
                        
                        $this->home_model->update($customerData, $condition, 'customer_basic_details');
                        echo json_encode($response);exit;
                    } else {
                        $msg = $response['ResponseStatus']['Errors'][0]['Message'];
                        $condition = array(
                            'id' => $userInfo['id']
                        );
                        $customerData = array(
                            'is_password_updated' => 0,
                            'password' => 'Pacific1',
                            'is_primary' => 1,
                            'resware_error_msg' => $msg
                        );
                        $this->home_model->update($customerData, $condition, 'customer_basic_details');
                        $response = array('status' => 'error', 'message' => $msg);
                        echo json_encode($response);exit;
                    }
                } else {
                    $msg = 'Something went wrong. Please try again.';
                    $response = array('status' => 'error', 'message' => $msg);
                    echo json_encode($response);exit;
                }
            }
        } else {
            $msg = 'Customer ID is required.';
            $response = array('status' => 'error','message'=>$msg);
        }
        echo json_encode($response);
    }

    public function incorrect_users()
    {
        $this->is_admin();
        $data = array();
        $data['title'] = 'PCT Order: Incorrect Users';
        $this->load->view('order/layout/header', $data);
        $this->load->view('order/home/incorrect_users', $data);
        $this->load->view('order/layout/footer', $data);
    }

    public function get_incorrect_customer_list()
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
            $params['where']['status'] = 1;

            $pageno = ($params['start'] / $params['length'])+1;

            $incorrect_customer_lists = $this->home_model->get_incorrect_customers($params);
            // $cnt = ($pageno == 1) ? ($params['start']+1) : (($pageno - 1) * $params['length']) + 1;

            $json_data['draw'] = intval( $params['draw'] );
        }
        else
        {
            $params['searchvalue'] = isset($_POST['keyword']) && !empty($_POST['keyword']) ? $_POST['keyword'] : '';
            $incorrect_customer_lists = $this->home_model->get_incorrect_customers($params);            
        }
        $data = array(); 
        
        if(isset($incorrect_customer_lists['data']) && !empty($incorrect_customer_lists['data']))
        {
            foreach ($incorrect_customer_lists['data'] as $key => $value) 
            {  
                $nestedData=array();
                /*$nestedData[] = $value['customer_number'];*/
                $nestedData[] = $value['first_name'];
                $nestedData[] = $value['last_name'];
                $nestedData[] = $value['email_address'];
               
                $nestedData[] = $value['company_name'];
               // $nestedData[] = $value['street_address'].", ".$value['city'].", ". $value['zip_code'];
                $nestedData[] = $value['random_password'];
                
                $type = isset($value['is_escrow']) && !empty($value['is_escrow']) ? 'Escrow' : 'Lender';            
               // $nestedData[] = $type;    
                $nestedData[] = $value['resware_error_msg'];

                $action = "<a href='javascript:void(0);' onclick='resetPassword(".$value['id'].")' class='btn btn-secondary'  title='Reset Password'>Reset</a>";
                $nestedData[] = $action;       
                          
                $data[] = $nestedData;            
                // $cnt++;
            }
        }
        $json_data['recordsTotal'] = intval( $incorrect_customer_lists['recordsTotal'] );
        $json_data['recordsFiltered'] = intval( $incorrect_customer_lists['recordsFiltered'] );
        $json_data['data'] = $data;
        echo json_encode($json_data);
    }

    public function reset_user_password()
    {
        $this->load->model('order/apiLogs');
        $this->is_admin();
        $id = $this->input->post('id');
        $params = array(
            'id' => $id
        );
        $userInfo = $this->home_model->get_rows($params);
        $reswareUpdatePwdData = array(
            'user_name' =>  $userInfo['email_address'],
            'password' => 'Pacific1',
            'new_password' => $userInfo['random_password'],
        );
        $logid = $this->apiLogs->syncLogs($userInfo['id'], 'resware', 'change_password', env('RESWARE_UPDATE_PWD_API'), $reswareUpdatePwdData, array(), 0, 0);
        $updatePwdResult = $this->updatePasswordResware($reswareUpdatePwdData);
        $this->apiLogs->syncLogs($userInfo['id'], 'resware', 'change_password', env('RESWARE_UPDATE_PWD_API'), $reswareUpdatePwdData, $updatePwdResult, 0, $logid);
        $responsePwd = json_decode($updatePwdResult,true);
        $condition = array(
            'id' => $userInfo['id']
        );
        $customerData = array(
            'password' => 'Pacific1',
        );

        if(!empty($responsePwd['message'])) {
            $customerData['is_password_updated'] = 0;
            $customerData['resware_error_msg'] = $responsePwd['message'];
            $response = array('status' => 'error', 'message' =>  'Password update failed due to: '.$responsePwd['message']);
        } else {
            $customerData['is_password_updated'] = 1;
            $response = array('status' => 'success', 'message' =>  'Password updated successfully for email user: '. $userInfo['email_address']);
        }

        $this->home_model->update($customerData, $condition, 'customer_basic_details');
        echo json_encode($response);exit;
    }
    
    public function updatePasswordResware($postData)
    {
        $this->is_admin();
        $body_params = http_build_query($postData);
        $ch = curl_init(env('RESWARE_UPDATE_PWD_API'));    
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
        curl_setopt($ch, CURLOPT_FAILONERROR, 1);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $body_params);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt( $ch, CURLOPT_MAXREDIRS, 10 );
        $result = curl_exec($ch);
        return $result;
    }
}
