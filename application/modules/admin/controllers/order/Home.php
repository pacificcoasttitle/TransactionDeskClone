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
                    redirect(base_url());
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

                    $password = md5('Pacific2');
                    // Insert/update CSV data into database
                    if(!empty($csvData)){                        

                        
                        foreach($csvData as $row)
                        { 
                            $rowCount++;
                            if(isset($row['Email Address']) && !empty($row['Email Address']))
                            {
                                // Check whether email already exists in the database
                                /*$random_number = $this->home_model->get_customer_number();
                                $customer_number = isset($random_number['random_num']) && !empty($random_number['random_num']) ? $random_number['random_num'] : '';*/

                                // Prepare data for DB insertion
                                $customerData = array(
                                    /*'customer_number' => $customer_number,*/
                                    'first_name' => ucfirst(strtolower($row['First Name'])),
                                    'last_name' => ucfirst(strtolower($row['Last Name'])),
                                    'email_address' => strtolower(str_replace(' ','',$row['Email Address'])),
                                    'telephone_no' => $row['Telephone'],
                                    'company_name' => $row['Company Name'],
                                    'street_address' => $row['Street Address'],
                                    'city' => $row['City'],
                                    'zip_code' => $row['Zipcode'],
                                    'password' => $password,
                                    'status'=> 1,
                                    'is_escrow' => 1
                                );

                                $con = array(
                                    'where' => array(
                                        'first_name' => $row['First Name'],
                                        'email_address' => strtolower(str_replace(' ','',$row['Email Address'])),
                                        'is_escrow' => 1
                                    ),
                                    'returnType' => 'count'
                                );
                                $prevCount = $this->home_model->get_rows($con);
                              
                                if($prevCount > 0){
                                    // Update member data
                                    // unset($customerData['customer_number']);
                                    $condition = array('first_name' => $row['First Name'], 'email_address' => strtolower(str_replace(' ','',$row['Email Address'])));
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
                    $password = md5('Pacific2');

                    // Insert/update CSV data into database
                    if(!empty($csvData))
                    {
                        foreach($csvData as $row)
                        {
                            $rowCount++;
                            if(isset($row['Email Address']) && !empty($row['Email Address']))
                            {
                                // Check whether email already exists in the database
                                /*$random_number = $this->home_model->get_customer_number();
                                $customer_number = isset($random_number['random_num']) && !empty($random_number['random_num']) ? $random_number['random_num'] : '';*/

                                $street_address = '';
                                if(isset($row['Address Line 1']) && !empty($row['Address Line 1']))
                                {
                                    $street_address .= $row['Address Line 1'];
                                }
                                if(isset($row['Address Line 2']) && !empty($row['Address Line 2']))
                                {
                                    $street_address .= $row['Address Line 2'];
                                }
                                
                                // Prepare data for DB insertion
                                $customerData = array(
                                    'first_name' => ucfirst(strtolower($row['First Name'])),
                                    'last_name' => ucfirst(strtolower($row['Last Name'])),
                                    'email_address' => strtolower(str_replace(' ','',$row['Email Address'])),
                                    'telephone_no' => $row['Telephone'],
                                    'company_name' => $row['Company Name'],
                                    'street_address' => $street_address,
                                    'city' => $row['City'],
                                    'zip_code' => $row['Zipcode'],
                                    'password' => $password,
                                    'status'=> 1,
                                    'is_escrow' => 0,
                                    'lender_type' => $lenderType
                                );

                                $con = array(
                                    'where' => array(
                                        'first_name' => $row['First Name'],
                                        'email_address' => strtolower(str_replace(' ','',$row['Email Address'])),
                                        'is_escrow' => 0
                                    ),
                                    'returnType' => 'count'
                                );
                                $prevCount = $this->home_model->get_rows($con);
                              
                                if($prevCount > 0)
                                {
                                    // Update member data
                                    $condition = array('first_name' => $row['First Name'], 'email_address' => strtolower(str_replace(' ','',$row['Email Address'])));
                                    $update = $this->home_model->update($customerData, $condition);
                                    
                                    if($update){
                                        $updateCount++;
                                    }
                                }
                                else
                                {
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
                $nestedData[] = $value['telephone_no'];
                $nestedData[] = $value['company_name'];
                $nestedData[] = $value['street_address'];
                $nestedData[] = $value['city'];
                $nestedData[] = $value['zip_code'];
                $nestedData[] = $value['lender_type'];
                         
                
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
}
