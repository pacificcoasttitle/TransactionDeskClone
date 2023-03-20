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
        $this->load->model('order/order_model'); 
        $this->load->library('order/common');
        $this->common->is_admin();
    }
    
    public function index()
    {
        $data = array();
        // $data['title'] = 'PCT Order: Dashboard';
		$order_filter = ['for_month'=>date('m'),'for_year'=>date('Y')];
        $openOrderData = $this->order_model->get_order_count($order_filter);
		$order_filter['type']='closed';
        $closedOrderData = $this->order_model->get_order_count($order_filter);
        // $titlePointData = $this->order_model->get_title_point_count();
        
        $openLoanCount = $openSalesCount = 0;
        $closedLoanCount = $closedSalesCount = 0;

        if(isset($openOrderData) && !empty($openOrderData))
        {
            foreach ($openOrderData as $key => $value) 
            {
                if($value['type'] == 'loan')
                {
                    $openLoanCount = $value['total'];
                }
                if($value['type'] == 'sale')
                {
                    $openSalesCount = $value['total'];
                }
            }
        }

		if(isset($closedOrderData) && !empty($closedOrderData))
        {
            foreach ($closedOrderData as $key => $value) 
            {
                if($value['type'] == 'loan')
                {
                    $closedLoanCount = $value['total'];
                }
                if($value['type'] == 'sale')
                {
                    $closedSalesCount = $value['total'];
                }
            }
        }
        // $totalFailCount = 0;

        // $lvCount = isset($titlePointData['lv_total_records']) && !empty($titlePointData['lv_total_records']) ? $titlePointData['lv_total_records'] : 0;
        // $totalFailCount += $lvCount;

        // $grantDeedCount = isset($titlePointData['grant_deed_total_records']) && !empty($titlePointData['grant_deed_total_records']) ? $titlePointData['grant_deed_total_records'] : 0;    
        // $totalFailCount += $grantDeedCount;

        // $taxCount = isset($titlePointData['tax_total_records']) && !empty($titlePointData['tax_total_records']) ? $titlePointData['tax_total_records'] : 0;

        // $totalFailCount += $taxCount;

		$this->load->model('order/customer_basic_details_model');
		$customer_filter = ['is_escrow'=>1,'status'=>1];
		$escrowUsersCount = $this->customer_basic_details_model->count_by($customer_filter);
		$customer_filter = ['is_escrow'=>0,'status'=>1];
		$lenderUsersCount = $this->customer_basic_details_model->count_by($customer_filter);
		$customer_filter = ['is_sales_rep'=>1];
		$salesRepUsersCount = $this->customer_basic_details_model->count_by($customer_filter);
		$customer_filter = [];
		$expiredPasswords = $this->home_model->get_incorrect_customers($customer_filter);
		$expiredPasswordCount = $expiredPasswords['recordsTotal'];
		$failedJsonCount = $this->home_model->get_failed_json_files();
        
        $data = array(
            'title' => 'PCT Order: Dashboard',
            'openLoanCount' => $openLoanCount,
            'openSalesCount' => $openSalesCount,
			'closedLoanCount' => $closedLoanCount,
            'closedSalesCount' => $closedSalesCount,
			'escrowUsersCount'=>$escrowUsersCount,
			'lenderUsersCount'=>$lenderUsersCount,
			'salesRepUsersCount'=>$salesRepUsersCount,
			'expiredPasswordCount'=>$expiredPasswordCount,
			'failedJsonCount'=>$failedJsonCount,
			
            // 'lvCount' => $lvCount,
            // 'grantDeedCount' => $grantDeedCount,
            // 'taxCount' => $taxCount,
            // 'totalFailCount' => $totalFailCount
        );
        
        $this->load->view('order/layout/header', $data);
        $this->load->view('order/home/index', $data);
        $this->load->view('order/layout/footer', $data);
    }

    public function dashboard()
    {
    	$data = array();
        $data['title'] = 'PCT Order: Escrow';
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
                $user_id = $value['id'];
	            /*$nestedData[] = $value['customer_number'];*/
	            $nestedData[] = $value['first_name'];
	            $nestedData[] = $value['last_name'];
	            $nestedData[] = $value['email_address'];
                
                
	           // $nestedData[] = $value['telephone_no'];
	            $nestedData[] = $value['company_name'];
	            $nestedData[] = $value['street_address'];
	            $nestedData[] = $value['city'];
	            $nestedData[] = $value['zip_code'];
                if ($value['is_dual_cpl'] == 1) {
                    $checked = 'checked';
                } else {
                    $checked = '';
                }
                $nestedData[] = "<input $checked onclick='isDualCplUser();' style='height:30px;width:20px;' type='checkbox' id='$user_id' name='$user_id'>";
	                     
	            
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

    public function logout()
    {
        $this->session->unset_userdata('admin');
        redirect(base_url().'order/admin');
    }

    public function import_lenders()
    {    
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
                $user_id = $value['id'];
                $nestedData[] = $value['first_name'];
                $nestedData[] = $value['last_name'];
                $nestedData[] = $value['email_address'];
                // $nestedData[] = $value['telephone_no'];
                $nestedData[] = $value['company_name'];
                $nestedData[] = $value['street_address'].", ".$value['city'].", ".$value['state'].", ".$value['zip_code'];
                if ($value['is_mortgage_user'] == 1) {
                    $checked = 'checked';
                } else {
                    $checked = '';
                }
                $nestedData[] = "<input $checked onclick='isMortgageUser();' style='height:30px;width:20px;' type='checkbox' id='$user_id' name='$user_id'>";
                $specialSel = $value['is_special_lender'] == 1 ? 'selected' : '';
                $normalSel = $value['is_special_lender'] == 0 ? 'selected' : '';
                $id = $value['id'];
                $nestedData[] = "<select onchange='changeLenderUserType($id, this.value);' id='user_type' name='user_type'><option $normalSel value='0'>Normal</option><option $specialSel value='1'>Special</option></select>";
                // $nestedData[] = $value['lender_type'];
                         
                if ($value['is_dual_cpl'] == 1) {
                    $checked = 'checked';
                } else {
                    $checked = '';
                }
                $nestedData[] = "<input $checked onclick='isDualCplUser();' style='height:30px;width:20px;' type='checkbox' id='$user_id' name='$user_id'>";
	            
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
            $i = $params['start'] + 1;
            foreach ($cpl_document_list['data'] as $key => $value) {
                $nestedData=array();
                $nestedData[] = $i;
                $nestedData[] = $value['file_number'];
                $nestedData[] = $value['document_name'];
                $documentName = $value['document_name'];
                if ($value['api_document_id'] > 0) {
                    $nestedData[] = 'Yes';
                } else {
                    $nestedData[] = 'No';
                }
                // $nestedData[] = date("m/d/Y h:i:s A", strtotime($value['created']));
				$nestedData[] = convertTimezone($value['created']);

                if (env('AWS_ENABLE_FLAG') == 1) {
                    
                    $documentUrl = env('AWS_PATH')."documents/".$documentName;
                    
                    if(isset($_POST['draw']) && !empty($_POST['draw'])) {
                        $nestedData[] = "<div style='display:flex;'><a href='#' onclick='downloadDocumentFromAws(".'"'.$documentUrl.'"'.", ".'"cpl"'.");'><i class='fas fa-fw fa-download'></i></a>
                        <a style='margin-left:10px;' target='_blank' href='$documentUrl'><i class='fas fa-fw fa-eye'></i></a></div>";
                    }
                } else {
                    $documentUrl = base_url()."uploads/documents/".$documentName;
                    if(isset($_POST['draw']) && !empty($_POST['draw'])) {
                        $nestedData[] = "<div style='display:flex;'><a href='$documentUrl' download><i class='fas fa-fw fa-download'></i></a>
                        <a style='margin-left:10px;' target='_blank' href='$documentUrl'><i class='fas fa-fw fa-eye'></i></a></div>";
                    }
                }
                if(isset($_POST['draw']) && !empty($_POST['draw'])) {
                    $nestedData[] = "<div style='display:flex;'><a href='$documentUrl' download><i class='fas fa-fw fa-download'></i></a>
                    <a style='margin-left:10px;' target='_blank' href='$documentUrl'><i class='fas fa-fw fa-eye'></i></a></div>";
                }
                $data[] = $nestedData;   
                $i++;         
            }
        }
        $json_data['recordsTotal'] = intval( $cpl_document_list['recordsTotal'] );
        $json_data['recordsFiltered'] = intval( $cpl_document_list['recordsFiltered'] );
        $json_data['data'] = $data;
        echo json_encode($json_data);
    }

    public function newUsers()
    {
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
                $userType = $this->input->post('user_type');
                if($userType == 'realtor') {
                    $this->load->model('order/agent_model');
                    $agentData = array(
                        'name' => $this->input->post('first_name')." ".$this->input->post('last_name'),
                        'email_address' =>  $this->input->post('email_address'),
                        'telephone_no' => $this->input->post('telephone_no'),
                        'company' => $this->input->post('company'),
                        'address' => $this->input->post('address'),
                        'city' => $this->input->post('city'),
                        'zipcode' => $this->input->post('zipcode'),
                        'is_listing_agent' => 0,
                        'status' => 1
                    );

                    $condition = array(
                        'where' => array(
                            'partner_id' => $this->input->post('partner_id'),
                            'partner_employee_id' => $this->input->post('resware_client_id'),
                        ),
                        'returnType' => 'count'
                    );
                    $prevCount = $this->agent_model->get_rows($condition);

                    if ($prevCount > 0) {
                        $updateCondition = array(
                            'partner_id' => $this->input->post('partner_id'),
                            'partner_employee_id' => $this->input->post('resware_client_id')
                        );
                        $update = $this->agent_model->update($agentData, $updateCondition);
                    } else {
                        $agentData['partner_id'] = $this->input->post('partner_id');
                        $agentData['partner_employee_id'] = $this->input->post('resware_client_id');
                        $insert = $this->agent_model->insert($agentData);
                    }
                } else {
                    if($userType == 'escrow') {
                        $userTypeFlag = 1;
                    } else if ($userType == 'lender') {
                        $userTypeFlag = 0;
                    } else if ($userType == 'mortgage_broker') {
                        $userTypeFlag = 2;
                    }

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
                        'is_escrow' => $userTypeFlag,
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
                            $data['success_msg'] = 'Password updated successfully for email user: '. $this->input->post('email_address');
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

    function get_title_company_list()
    {
    	$searchTerm = isset($_POST['term']) && !empty($_POST['term']) ? $_POST['term'] : '';
    	$condition = array(
            'partner_name' => $searchTerm,
        );
    	$companyDetails = $this->home_model->get_title_company_list($condition);
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
        $data = array();
        $data['title'] = 'PCT Order: Grant Deed Documents';
        $this->load->view('order/layout/header', $data);
        $this->load->view('order/home/grant_deed_document', $data);
        $this->load->view('order/layout/footer', $data);
    }

    public function lv_document()
    {
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
            $i = $params['start'] + 1;
            foreach ($grant_document_lists['data'] as $key => $value) {
                $nestedData=array();
                $nestedData[] = $i;
                $nestedData[] = $value['file_number'];
                $nestedData[] = $value['document_name'];
                $documentName = $value['document_name'];
                if ($value['api_document_id'] > 0) {
                    $nestedData[] = 'Yes';
                } else {
                    $nestedData[] = 'No';
                }
				$nestedData[] = convertTimezone($value['created']);
                // $nestedData[] = date("m/d/Y h:i:s A", strtotime($value['created']));
                if (env('AWS_ENABLE_FLAG') == 1) {
                    $documentUrl = env('AWS_PATH')."grant-deed/".$documentName;
                    if(isset($_POST['draw']) && !empty($_POST['draw'])) {
                        $nestedData[] = "<div style='display:flex;'><a href='#' onclick='downloadDocumentFromAws(".'"'.$documentUrl.'"'.", ".'"grant_deed"'.");'><i class='fas fa-fw fa-download'></i></a>
                        <a style='margin-left:10px;' target='_blank' href='$documentUrl'><i class='fas fa-fw fa-eye'></i></a></div>";
                    }
                } else {
                    $documentUrl = base_url()."uploads/grant-deed/".$documentName;
                    if(isset($_POST['draw']) && !empty($_POST['draw'])) {
                        $nestedData[] = "<div style='display:flex;'><a href='$documentUrl' download><i class='fas fa-fw fa-download'></i></a>
                        <a style='margin-left:10px;' target='_blank' href='$documentUrl'><i class='fas fa-fw fa-eye'></i></a></div>";
                    }
                }
                
                $data[] = $nestedData;  
                $i++;          
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
            $i = $params['start'] + 1;
            foreach ($lv_document_lists['data'] as $key => $value) {
                $nestedData=array();
                $nestedData[] = $i;
                $nestedData[] = $value['file_number'];
                $nestedData[] = $value['document_name'];
                $documentName = $value['document_name'];
                if ($value['api_document_id'] > 0) {
                    $nestedData[] = 'Yes';
                } else {
                    $nestedData[] = 'No';
                }
                
                // $nestedData[] = date("m/d/Y h:i:s A", strtotime($value['created']));
				$nestedData[] = convertTimezone($value['created']);
                if (env('AWS_ENABLE_FLAG') == 1) {
                    $documentUrl = env('AWS_PATH')."legal-vesting/".$documentName;
                    if(isset($_POST['draw']) && !empty($_POST['draw'])) {
                        $nestedData[] = "<div style='display:flex;'><a href='#' onclick='downloadDocumentFromAws(".'"'.$documentUrl.'"'.", ".'"legal_vesting"'.");'><i class='fas fa-fw fa-download'></i></a>
                        <a style='margin-left:10px;' target='_blank' href='$documentUrl'><i class='fas fa-fw fa-eye'></i></a></div>";
                    }
                } else {
                    $documentUrl = base_url()."uploads/legal-vesting/".$documentName;
                    if(isset($_POST['draw']) && !empty($_POST['draw'])) {
                        $nestedData[] = "<div style='display:flex;'><a href='$documentUrl' download><i class='fas fa-fw fa-download'></i></a>
                        <a style='margin-left:10px;' target='_blank' href='$documentUrl'><i class='fas fa-fw fa-eye'></i></a></div>";
                    }
                }
                
                $data[] = $nestedData;  
                $i++;          
            }
        }
        $json_data['recordsTotal'] = intval( $lv_document_lists['recordsTotal'] );
        $json_data['recordsFiltered'] = intval( $lv_document_lists['recordsFiltered'] );
        $json_data['data'] = $data;
        echo json_encode($json_data);
    }

    public function masterUsers()
    {
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
                    $editUrl = base_url().'order/admin/edit-master-user/'.$value['id'];
                    $nestedData[] = "<a href='".$editUrl."'  class='btn btn-action'  title='Edit Master User'><span class='fa fa-edit' aria-hidden='true'></span></a><a href='javascript:void(0);' onclick='deleteMasterUser(".$value['id'].")' class='btn btn-action'  title='Delete Master User'><span class='fa fa-trash' aria-hidden='true'></span></a>";
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
        $data = array();
        $data['title'] = 'PCT Order: Add New Master User';
        $salesRepData = array();
        $this->db->select('*')
            ->from('pct_order_partner_company_info');
        
        $query = $this->db->get();
        $data['companys'] = $query->result_array();
        
        if ($this->input->post()) {
            $this->form_validation->set_rules('first_name', 'First Name', 'required', array('required'=> 'Please Enter First Name'));
            $this->form_validation->set_rules('last_name', 'Last Name', 'required', array('required'=> 'Please Enter Last Name'));
            $this->form_validation->set_rules('email_address', 'Email', 'trim|required|valid_email|is_unique[customer_basic_details.email_address]', array('required'=> 'Please Enter Email', 'valid_email' => 'Please enter valid Email','is_unique' => 'The %s is already taken'));
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
                    'partner_companies' => implode(",",$this->input->post('partner_companies')),
                    'is_escrow' => 0,
                    'is_master' => 1,
                    'is_password_updated' => 1,
                    'is_new_user' => 0,
                    'status'=> 1,
                );
                $insert = $this->home_model->insert($customerData);
                if ($insert) {
                    $data['success_msg'] = 'Master User added successfully.';
                    $this->form_validation->reset_validation();
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

    public function editMasterUser()
    {
        $data = array();
        $data['title'] = 'PCT Order: Edit Master User';
        $id = $this->uri->segment(4);     
        $this->db->select('*')
            ->from('pct_order_partner_company_info');
        
        $query = $this->db->get();
        $data['companys'] = $query->result_array();
        
        if(isset($id) && !empty($id)) {
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
                        'partner_companies' => implode(",",$this->input->post('partner_companies')),
                        'is_escrow' => 0,
                        'is_master' => 1,
                        'is_password_updated' => 1,
                        'is_new_user' => 0,
                        'status'=> 1,
                    );

                    $updateCondition = array(
                        'id' => $id,
                    );
                    $update = $this->home_model->update($customerData, $updateCondition);
                    if ($update) {
                        $data['success_msg'] = 'Master User updated successfully.';
                        $this->form_validation->reset_validation();
                    } else {
                        $data['error_msg'] = 'Master User not updated.';
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
            $con = array('id' => $id);
            $data['master_user_info'] = $this->home_model->get_rows($con);
        }
        $this->load->view('order/layout/header', $data);
        $this->load->view('order/home/edit_master_user', $data);
        $this->load->view('order/layout/footer', $data);
    }

    public function tax_document()
    {
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
            $i = $params['start'] + 1;
            foreach ($tax_document_lists['data'] as $key => $value) {
                $nestedData=array();
                $nestedData[] = $i;
                $nestedData[] = $value['file_number'];
                $nestedData[] = $value['document_name'];
                $documentName = $value['document_name'];
                if ($value['api_document_id'] > 0) {
                    $nestedData[] = 'Yes';
                } else {
                    $nestedData[] = 'No';
                }
                
                // $nestedData[] = date("m/d/Y h:i:s A", strtotime($value['created']));
				$nestedData[] = convertTimezone($value['created']);
                if (env('AWS_ENABLE_FLAG') == 1) {
                    $documentUrl = env('AWS_PATH')."tax/".$documentName;
                    if(isset($_POST['draw']) && !empty($_POST['draw'])) {
                        $nestedData[] = "<div style='display:flex;'><a href='#' onclick='downloadDocumentFromAws(".'"'.$documentUrl.'"'.", ".'"tax"'.");'><i class='fas fa-fw fa-download'></i></a>
                        <a style='margin-left:10px;' target='_blank' href='$documentUrl'><i class='fas fa-fw fa-eye'></i></a></div>";
                    }
                } else {
                    $documentUrl = base_url()."uploads/tax/".$documentName;
                    if(isset($_POST['draw']) && !empty($_POST['draw'])) {
                        $nestedData[] = "<div style='display:flex;'><a href='$documentUrl' download><i class='fas fa-fw fa-download'></i></a>
                        <a style='margin-left:10px;' target='_blank' href='$documentUrl'><i class='fas fa-fw fa-eye'></i></a></div>";
                    }
                }
                
                $data[] = $nestedData;  
                $i++;          
            }
        }
        $json_data['recordsTotal'] = intval( $tax_document_lists['recordsTotal'] );
        $json_data['recordsFiltered'] = intval( $tax_document_lists['recordsFiltered'] );
        $json_data['data'] = $data;
        echo json_encode($json_data);
    }

    public function curative_document()
    {
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
            $i = $params['start'] + 1;
            foreach ($curative_document_lists['data'] as $key => $value) {
                $nestedData=array();
                $nestedData[] = $i;
                $nestedData[] = $value['file_number'];
                $nestedData[] = $value['document_name'];
                $documentName = $value['document_name'];
                if ($value['api_document_id'] > 0) {
                    $nestedData[] = 'Yes';
                } else {
                    $nestedData[] = 'No';
                }
                
                // $nestedData[] = date("m/d/Y h:i:s A", strtotime($value['created']));
				$nestedData[] = convertTimezone($value['created']);
                if (env('AWS_ENABLE_FLAG') == 1) {
                    $documentUrl = env('AWS_PATH')."curative/".$documentName;
                    if(isset($_POST['draw']) && !empty($_POST['draw'])) {
                        $nestedData[] = "<div style='display:flex;'><a href='#' onclick='downloadDocumentFromAws(".'"'.$documentUrl.'"'.", ".'"curative"'.");'><i class='fas fa-fw fa-download'></i></a>
                        <a style='margin-left:10px;' target='_blank' href='$documentUrl'><i class='fas fa-fw fa-eye'></i></a></div>";
                    }
                } else {
                    $documentUrl = base_url()."uploads/curative/".$documentName;
                    if(isset($_POST['draw']) && !empty($_POST['draw'])) {
                        $nestedData[] = "<div style='display:flex;'><a href='$documentUrl' download><i class='fas fa-fw fa-download'></i></a>
                        <a style='margin-left:10px;' target='_blank' href='$documentUrl'><i class='fas fa-fw fa-eye'></i></a></div>";
                    }
                }
                
                $data[] = $nestedData;  
                $i++;          
            }
        }
        $json_data['recordsTotal'] = intval( $curative_document_lists['recordsTotal'] );
        $json_data['recordsFiltered'] = intval( $curative_document_lists['recordsFiltered'] );
        $json_data['data'] = $data;
        echo json_encode($json_data);
    }

    public function file_document()
    {
        if ($this->input->server('REQUEST_METHOD') === 'POST') {
            if (!is_dir('uploads/file_document')) {
                mkdir('./uploads/file_document', 0777, TRUE);
            }
            $error = '';
            if (!empty($_FILES['file']['name'])) {
                $document_name = date('YmdHis')."_".$_FILES['file']['name'];
                $config['upload_path'] = './uploads/file_document/';
                $config['allowed_types'] = 'doc|docx|gif|msg|pdf|tif|tiff|xls|xlsx|xml';   
                $config['max_size'] = 12000;
                // $userdata = $this->session->userdata('user');
                $config['file_name'] = $document_name;
                $this->load->library('upload', $config);
                if (! $this->upload->do_upload('file')) {
                    $error = $this->upload->display_errors();
                } else { 
                    $data = $this->upload->data();
                    $contents = file_get_contents($data['full_path']);
                    $binaryData   = base64_encode($contents); 
                    $document_name = $data['file_name'];
                    
                    $fileData = array(
                        'name' => $this->input->post('name'),
                        'file_path' => $document_name,
                        'description' => $this->input->post('description'),
                        'created_at' => date('Y-m-d H:i:s')
                    );

                    $this->load->library('order/order');
                    $this->order->uploadDocumentOnAwsS3($document_name, 'file_document');
                    $this->load->model('order/fileDocument_model');
                    $inserted = $this->fileDocument_model->insert($fileData);
                    if($inserted) {
                        $titleOfficers = $this->input->post('titleOfficers');
                        foreach ($titleOfficers as $titleOfficer) {
                            if ($titleOfficer == 'all') {
                                $this->load->model('order/title_model');
                                $titleOfficersInfo = $this->title_model->getTitleOfficers();
                                foreach($titleOfficersInfo as $titleOfficerInfo) {
                                    $data = array(
                                        'form_id' => $inserted,
                                        'user_id' => $titleOfficerInfo['id'],
                                        'created_at' => date("Y-m-d H:i:s")
                                    );
                                    $this->db->insert('pct_order_title_officers_forms', $data);
                                }
                            } else {
                                $data = array(
                                    'form_id' => $inserted,
                                    'user_id' => $titleOfficer,
                                    'created_at' => date("Y-m-d H:i:s")
                                );
                                $this->db->insert('pct_order_title_officers_forms', $data);
                            }
                        }
                        $this->session->set_flashdata('success','File uploaded.');
                        redirect('order/admin/file-documents');
                    }
                } 
            } else {
                $error = 'Please slect file to uplaod';
            }
            if($error == '') {
                $error = 'Something went wrong. Please try again';
            }
            $this->session->set_flashdata('error',$error);
            redirect('order/admin/file-documents');
        }
        $data = array();
        $data['title'] = 'PCT Order: Files';
        $this->load->model('order/title_model');
        $data['titleOfficers'] = $this->title_model->getTitleOfficers();
        $this->load->view('order/layout/header', $data);
        $this->load->view('order/home/file_document', $data);
        $this->load->view('order/layout/footer', $data);
    }

    public function get_file_document_list()
    {
        $this->load->model('order/fileDocument_model');
        $userdata = $this->session->userdata('user');
        // $where = array('added_by'=>$userdata['id']);
        $files_data = $this->fileDocument_model->get_all();

        $tableData = array();
        foreach ($files_data as $key=>$file_data) {
            $tmp_array = array();
            $tmp_array[] = ($key + 1);
            $tmp_array[] = $file_data->name;
            $tmp_array[] = $file_data->description;
            // $tmp_array[] = date('m/d/Y',strtotime($file_data->created_at));
			$tmp_array[] = convertTimezone($file_data->created_at,'m/d/Y');
            $documentName = $file_data->file_path;
            $formId = $file_data->id;
            $documentUrl = env('AWS_PATH')."file_document/".$documentName;
            $action = "<div style='display:flex;'><!-- <a href='javascript::void();' onclick='editFormInfo($formId);'><i class='fas fa-fw fa-edit'></i></a>--><a href='javascript::void();' onclick='downloadDocumentFromAws(".'"'.$documentUrl.'"'.", ".'"'.$documentName.'"'.");'><i class='fas fa-fw fa-download'></i></a>
                <a style='margin-left:10px;' target='_blank' href='$documentUrl'><i class='fas fa-fw fa-eye'></i></a><a style='margin-left:10px;' href='javascript::void();' onclick='deleteForm($formId);'><i class='fas fa-fw fa-trash'></i></a></div>";
            $tmp_array[] = $action;
            $tableData[] = $tmp_array;
        }

        $json_data['recordsTotal'] = count($tableData);
        $json_data['recordsFiltered'] = count($tableData);
        $json_data['data'] = $tableData;
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
        $data = array();
        $data['errors'] = '';
		$data['success'] = '';
		if ($this->session->userdata('errors')) {
			$data['errors'] = $this->session->userdata('errors');
			$this->session->unset_userdata('errors');
		}
		if ($this->session->userdata('success')) {
			$data['success'] = $this->session->userdata('success');
			$this->session->unset_userdata('success');
		}
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
            $i = $params['start'] + 1;
            foreach ($company_lists['data'] as $key => $value) {
                $nestedData=array();
                $nestedData[] = $i;
                $nestedData[] = $value['partner_id'];
                $nestedData[] = $value['partner_name'];
                $nestedData[] = $value['address1'].", ".$value['city'].", ".$value['state'].", ".$value['zip'];
                if (!empty($value['loan_underwriter'])) {
                    $loan_underwriter = $value['loan_underwriter'];
                } else {
                    $loan_underwriter = '';
                }
                $loanUnderwriterSelection ='<select onchange="updateUnderwriter('.$value['partner_id'].',\'loan_underwriter\' ,this.value);" id="loan_underwriter" name="loan_underwriter">
                                    <option value="">Select</option>
                                    <option value="westcor">Westcor</option>
                                    <option value="north_american">North American</option>
                                    <option value="commonwealth">Commonwealth</option>
                                </select>'; 
                $loanUnderwriterSelection = str_replace('value="' .  $loan_underwriter . '"','value="' .  $loan_underwriter . '" selected', $loanUnderwriterSelection);          
                $nestedData[] = $loanUnderwriterSelection;

                if (!empty($value['sales_underwriter'])) {
                    $sales_underwriter = $value['sales_underwriter'];
                } else {
                    $sales_underwriter = '';
                }
                $salesUnderwriterSelection ='<select onchange="updateUnderwriter('.$value['partner_id'].',\'sales_underwriter\', this.value);" id="sales_underwriter" name="sales_underwriter"><option value="">Select</option>
                                    <option value="westcor">Westcor</option>
                                    <option value="north_american">North American</option>
                                    <option value="commonwealth">Commonwealth</option>
                                </select>'; 
                $salesUnderwriterSelection = str_replace('value="' .  $sales_underwriter . '"','value="' .  $sales_underwriter . '" selected', $salesUnderwriterSelection);          
                $nestedData[] = $salesUnderwriterSelection;
                if(!empty($value['deliverables'])) {
                    $deliverables = explode(',', $value['deliverables']);
                    $deliverablesInfo = '';
                    foreach($deliverables as $deliverable) {
                        $deliverablesInfo .= $deliverable."<br>";
                    }
                    $deliverablesInfo .= "<a style='margin-top:10px;' onclick='addOrUpdateDeliverables(".$value['partner_id'].");'><i class='fas fa-edit'></i></a>";
                    $nestedData[] = $deliverablesInfo;
                } else {
                    $nestedData[] = "<a style='margin-top:10px;' onclick='addOrUpdateDeliverables(".$value['partner_id'].")'><i class='fas fa-plus-circle'></i></a>";
                }
                $data[] = $nestedData; 
                $i++;           
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
        $data = array();
        $data['title'] = 'PCT Order: Primary Account';
        $params = array();
        if(isset($_POST) && !empty($_POST))
        {
            $keyword = $this->input->post('keyword');
            $params['keyword'] = $keyword;
        }
        
        
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

    public function import_underwriters()
    {    
        $data = array();
        $successMsg = '';
        $this->load->model('order/apiLogs');
        $this->load->library('order/resware');
        $data['title'] = 'PCT Order: Import Underwriters';

        if ($this->input->post()) {
            ini_set('max_execution_time', 0); 
            ini_set('memory_limit','2048M');
            $this->form_validation->set_rules('file', 'CSV file', 'callback_file_check');
            
            if ($this->form_validation->run($this) == true) {
                $insertCount = $updateCount = $rowCount = $notAddCount = 0;

                if (is_uploaded_file($_FILES['file']['tmp_name'])) {
                    $this->load->library('CSVReader');
                    $csvData = $this->csvreader->parse_csv($_FILES['file']['tmp_name']);
                    $partnerIds = array();

                    if (!empty($csvData)) {

                        foreach ($csvData as $row) {
                            $rowCount++;

                            if (isset($row['Partner Company ID']) && !empty($row['Partner Company ID'])) {
                                $con = array(
                                    'where' => array(
                                        'partner_id' => trim($row['Partner Company ID']),
                                    ),
                                    'returnType' => 'count'
                                );
                                $prevCount = $this->home_model->get_company_rows($con);
                              
                                if ($prevCount > 0) {

                                    if (strpos(strtolower(trim($row['Underwriter'])), 'commonwealth') !== false) {
                                        $underwriter = 'commonwealth';
                                    } else if (strpos(strtolower(trim($row['Underwriter'])), 'north american') !== false) {
                                        $underwriter = 'north_american';
                                    } else if (strpos(strtolower(trim($row['Underwriter'])), 'westcor') !== false) {
                                        $underwriter = 'westcor';
                                    } else {
                                        $underwriter = null;
                                    }
                                    $condition = array('partner_id' => trim($row['Partner Company ID']));
                                    if (strpos(strtolower(trim($row['Prod Type'])), 'sale') !== false) {
                                        $update = $this->home_model->update(array('sales_underwriter' => $underwriter), $condition, 'pct_order_partner_company_info');
                                    } else if (strpos(strtolower(trim($row['Prod Type'])), 'loan') !== false) {
                                        $update = $this->home_model->update(array('loan_underwriter' => $underwriter), $condition, 'pct_order_partner_company_info');
                                    }
                                    if ($update) {
                                        $insertCount++;
                                    }
                                } else {
                                    if (!in_array($row['Partner Company ID'], $partnerIds)) {
                                        $userdata = $this->session->userdata('admin');
                                        $partner_id = $row['Partner Company ID'];
                                        $endPoint = 'admin/partners/'.$partner_id;
                                        $userdata['email'] = $userdata['email_address'];
                                        $userdata['admin_api'] = 1;
                                        $logid = $this->apiLogs->syncLogs($userdata['id'], 'resware', 'get_partner_information', env('RESWARE_ORDER_API').$endPoint, array(), array(), 0, 0);
                                        $result = $this->resware->make_request('GET', $endPoint, array(), $userdata);
                                        $this->apiLogs->syncLogs($userdata['id'], 'resware', 'get_partner_information', env('RESWARE_ORDER_API').$endPoint, array(), $result, 0, $logid);
    
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
                                               
                                                if (strpos(strtolower(trim($row['Underwriter'])), 'commonwealth') !== false) {
                                                    $underwriter = 'commonwealth';
                                                } else if (strpos(strtolower(trim($row['Underwriter'])), 'north american') !== false) {
                                                    $underwriter = 'north_american';
                                                } else if (strpos(strtolower(trim($row['Underwriter'])), 'westcor') !== false) {
                                                    $underwriter = 'westcor';
                                                } else {
                                                    $underwriter = null;
                                                }
    
                                                if (strpos(strtolower(trim($row['Prod Type'])), 'sale') !== false) {
                                                    $companyData['sales_underwriter'] = $underwriter;
                                                    $companyData['loan_underwriter'] = null;
                                                } else if (strpos(strtolower(trim($row['Prod Type'])), 'loan') !== false) {
                                                    $companyData['loan_underwriter'] = $underwriter;
                                                    $companyData['sales_underwriter'] = null;
                                                }
                                                $this->home_model->insert($companyData, 'pct_order_partner_company_info');  
                                            } 
                                        }
                                        $partnerIds[] = $row['Partner Company ID']; 
                                    }
                                   
                                }
                            }                              
                        }
                        $notAddCount = ($rowCount - ($insertCount + $updateCount));
                        $successMsg = 'Underwriters imported successfully. Total Rows ('.$rowCount.') | Inserted ('.$insertCount.') | Not Inserted ('.$notAddCount.')';
                        $data['success_msg'] = $successMsg;
                    }
                } else {
                    $data['error_msg'] = 'Error on file upload, please try again.';
                }
            } else {
                $data['error_msg'] = 'Invalid file, please select only CSV file.';
            }
        }
        $this->load->view('order/layout/header', $data);
        $this->load->view('order/home/import_underwriter', $data);
        $this->load->view('order/layout/footer', $data);
    }

    public function updateUnderwriter()
    {
        // echo "<pre>"; print_r($this->input->post()); exit;
        $partner_id = $this->input->post('partner_id');
        $underwriter = $this->input->post('underwriter');
        $underwriter_type = $this->input->post('underwriter_type');
        
        $updateData = array($underwriter_type => $underwriter);
// echo "<pre>"; print_r($updateData); exit;
        /*if($underwriter_type == 'loan_underwriter')
        {
            $updateData = array(
                '' =>
            );
        }
        elseif ($underwriter_type == 'sales_underwriter') 
        {
            # code...
        }*/

        $condition = array('partner_id' => $partner_id);
        $this->home_model->update($updateData, $condition, 'pct_order_partner_company_info');
        $data = array('status'=>'success', 'msg'=> 'Underwriter updated successfully.');
        echo json_encode($data);
    }

    public function cplProposedUsers()
    {
        $data = array();
        $data['title'] = 'PCT Order: CPL/Proposed Users';
        $this->load->view('order/layout/header', $data);
        $this->load->view('order/home/cpl_proposed_users', $data);
        $this->load->view('order/layout/footer', $data);
    }

    public function get_cpl_proposed_users_list()
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
            $master_users_lists = $this->home_model->get_cpl_proposed_users_list($params);
            $json_data['draw'] = intval( $params['draw'] );
        } else {
            $params['searchvalue'] = isset($_POST['keyword']) && !empty($_POST['keyword']) ? $_POST['keyword'] : '';
            $master_users_lists = $this->home_model->get_cpl_proposed_users_list($params);        
        }

        $data = array(); 
        if (isset($master_users_lists['data']) && !empty($master_users_lists['data'])) {
            foreach ($master_users_lists['data'] as $key => $value) {
                $nestedData=array();
                $nestedData[] = $value['first_name'];
                $nestedData[] = $value['last_name'];
                $nestedData[] = $value['email_address'];
                $nestedData[] = $value['street_address'].", ".$value['city'].", ".$value['state'].", ".$value['zip_code'];
                if($value['lender_cpl_proposed_status'] == 1) {
                    $lenderStatus = 'Approved';
                } else if ($value['lender_cpl_proposed_status'] == 2) {
                    $lenderStatus = 'Rejected';
                } else {
                    $lenderStatus = 'Pending';
                }
                $nestedData[] = $lenderStatus;
                if(isset($_POST['draw']) && !empty($_POST['draw'])) {
                    $editUrl = base_url().'order/admin/edit-cpl-proposed-user/'.$value['id'];
                    $nestedData[] = "<a href='".$editUrl."'  class='btn btn-action'  title='Edit CPL/Proposed User'><span class='fa fa-edit' aria-hidden='true'></span></a>";
                }
                $data[] = $nestedData;            
            }
        }

        $json_data['recordsTotal'] = intval( $master_users_lists['recordsTotal'] );
        $json_data['recordsFiltered'] = intval( $master_users_lists['recordsFiltered'] );
        $json_data['data'] = $data;
        echo json_encode($json_data);
    }

    public function editCplProposedUser()
    {
        $data = array();
        $id = $this->uri->segment(4);      
        $data['title'] = 'PCT Order: Edit CPL/Proposed User';
        $salesRepData = array();

        if(isset($id) && !empty($id)) {
            if ($this->input->post()) {
                $this->form_validation->set_rules('first_name', 'First Name', 'required', array('required'=> 'Please Enter First Name'));
                $this->form_validation->set_rules('last_name', 'Last Name', 'required', array('required'=> 'Please Enter Last Name'));
                $this->form_validation->set_rules('email_address', 'Email', 'trim|required|valid_email', array('required'=> 'Please Enter Email', 'valid_email' => 'Please enter valid Email'));
                $this->form_validation->set_rules('company', 'Company', 'required', array('required'=> 'Please Enter Company'));
                $this->form_validation->set_rules('address', 'Address', 'required', array('required'=> 'Please Enter Address'));
                $this->form_validation->set_rules('city', 'City', 'required', array('required'=> 'Please Enter City'));
                $this->form_validation->set_rules('state', 'State', 'required', array('required'=> 'Please Enter State'));
                $this->form_validation->set_rules('zipcode', 'Zipcode', 'required', array('required'=> 'Please Enter Zipcode'));
                $this->form_validation->set_rules('partner_id', 'Company', 'required', array('required'=> 'Please select company based on search'));
                
                if ($this->form_validation->run() == true) {
                    $customerData = array(
                        'partner_id' =>  $this->input->post('partner_id'),
                        'resware_user_id' =>  0,
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
                        'is_master' => 0,
                        'is_password_updated' => 0,
                        'is_new_user' => 0,
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
    
                        if (!empty($responsePwd['message'])) {
                            $customerData['resware_error_msg'] = $responsePwd['message'];
                            $data['error_msg'] = 'Password update failed due to: '.$responsePwd['message'];
                        } else {
                            $customerData['is_password_updated'] = 1;
                            $customerData['is_added_lender_by_cpl_proposed'] = 0;
                            $customerData['lender_cpl_proposed_status'] = 1;
                            $data['success_msg'] = 'Password updated successfully for email user: '. $userInfo['email_address'];
                        }
                        $updateCondition = array(
                            'id' => $id,
                        );
                        $update = $this->home_model->update($customerData, $updateCondition);
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
                        $data['company_error_msg'] = "This partner company is not available on Resware side so please remove this company and select new company based on search.";
                    }
                }                                       
            }
            $con = array('id' => $id);
            $data['cpl_proposed_user_info'] = $this->home_model->get_rows($con);
        }
        $this->load->view('order/layout/header', $data);
        $this->load->view('order/home/edit_cpl_proposed_user', $data);
        $this->load->view('order/layout/footer', $data);
    }

    public function rejectCplProposedUser()
    {
        $data = array();
        $id = $this->uri->segment(4);      
        $updateCondition = array(
            'id' => $id,
        );
        $customerData['lender_cpl_proposed_status'] = 2;
        $customerData['is_added_lender_by_cpl_proposed'] = 0;
        $update = $this->home_model->update($customerData, $updateCondition);
        redirect(base_url().'order/admin/cpl-proposed-users');
    }

    
	public function sendPassword()
	{
		$data = array();
        $data['title'] = 'PCT Order: Send Password Listing';
        $this->load->view('order/layout/header', $data);
        $this->load->view('order/home/password_listing', $data);
        $this->load->view('order/layout/footer', $data);
    }
    
    public function get_password_list()
    {
        $params = array();
        $params['user_type'] = $this->input->post('user_type');
        if (isset($_POST['draw']) && !empty($_POST['draw'])) {
            $params['draw'] = isset($_POST['draw']) && !empty($_POST['draw']) ? $_POST['draw'] : 10;
            $params['length'] = isset($_POST['length']) && !empty($_POST['length']) ? $_POST['length'] : 10;
            $params['start'] = isset($_POST['start']) && !empty($_POST['start']) ? $_POST['start'] : 0;
            $params['orderColumn'] = isset($_POST['order'][0]['column']) && !empty($_POST['order'][0]['column']) ? $_POST['order'][0]['column'] : 0;
            $params['orderDir'] = isset($_POST['order'][0]['dir']) && !empty($_POST['order'][0]['dir']) ? $_POST['order'][0]['dir'] : 0;
            $params['searchvalue'] = isset($_POST['search']['value']) && !empty($_POST['search']['value']) ? $_POST['search']['value'] : '';
            $pageno = ($params['start'] / $params['length'])+1;
            $customer_lists = $this->home_model->get_password_list($params);
            $json_data['draw'] = intval( $params['draw'] );
        } else {
            $params['searchvalue'] = isset($_POST['keyword']) && !empty($_POST['keyword']) ? $_POST['keyword'] : '';
            $customer_lists = $this->home_model->get_password_list($params);            
        }

        $data = array(); 
	    if (isset($customer_lists['data']) && !empty($customer_lists['data'])) {
	    	foreach ($customer_lists['data'] as $key => $value)  {
	    		$nestedData=array();
	            $nestedData[] = $value['first_name'];
	            $nestedData[] = $value['last_name'];
	            $nestedData[] = $value['email_address'];
                if ($value['is_title_officer'] == 1) {
                    $nestedData[] = 'Title Officer';
                } else if ($value['is_sales_rep'] == 1) {
                    if ($value['is_sales_rep_manager'] == 1) {
                        $nestedData[] = 'Sales Rep. Manager';
                    } else {
                        $nestedData[] = 'Sales Rep';
                    }
                } else if ($value['is_special_lender'] == 1) {
                    $nestedData[] = 'Special Lender';
                } else if ($value['is_payoff_user'] == 1) {
                    $nestedData[] = 'Payoff User';
                } else if ($value['is_escrow'] == 1) {
                    $nestedData[] = 'Escrow User';
                } else {
                    $nestedData[] = 'Lender User';
                } 
	            $nestedData[] = $value['company_name'];
	            $nestedData[] = $value['street_address'];
	            $nestedData[] = $value['city'];
	            $nestedData[] = $value['zip_code'];
                $user_id = $value['id'];

                if ($value['is_password_required'] == 1) {
                    $checked = 'checked';
                } else {
                    $checked = '';
                }
                $nestedData[] = "<input $checked onclick='isPasswordRequired();' style='height:30px;width:20px;' type='checkbox' id='$user_id' name='$user_id'>";       

                if (isset($_POST['draw']) && !empty($_POST['draw'])) {
                    $action = "<a href='javascript:void(0);' onclick='sendPasswordMail(".$value['id'].")' class='btn btn-action'  title='Delete Customer'><span class='fa fa-envelope' aria-hidden='true'></span></a>";
                    $nestedData[] = $action;
                }
	            $data[] = $nestedData;            
	    	}
	    }
        $json_data['recordsTotal'] = intval( $customer_lists['recordsTotal'] );
        $json_data['recordsFiltered'] = intval( $customer_lists['recordsFiltered'] );
        $json_data['data'] = $data;
	    echo json_encode($json_data);
    }

    public function sendPasswordMail()
    {
        $id =  $this->input->post('id');
        
    	if ($id) {
            $user = $this->home_model->get_user(array('id' => $id));
            $from_name = 'Pacific Coast Title Company';
            $from_mail = getenv('FROM_EMAIL');
            $message_body = "Hi ".$user['first_name']." ".$user['last_name'].", <br><br>";
            $message_body .= "Please login with tempoary password and change your password. <br><br>";
            $this->load->library('order/order');
            $randomPassword = $this->order->randomPassword();

            $message_body .= "Tempoary password: ".$randomPassword. "<br><br>";
            $message_body .= "Use this link for login: ".getenv('APP_URL')."order/login <br><br>";
           
            $this->home_model->update(array('password' => password_hash($randomPassword, PASSWORD_DEFAULT), 'is_tmp_password' => 1), array('id' => $user['id']));
            $subject = 'Change Passsword';
            $to = $user['email_address'];
           // $to = 'ghernandez@pct.com';
            $cc = array();
            $bcc = array();
            $file = array();
            $this->load->helper('sendemail');
            $mail_result = send_email($from_mail, $from_name, $to, $subject, $message_body, $file, $cc, $bcc);
            if($mail_result) {
                $response = array('status' => 'success', 'message' => 'Mail sent successfully.');
            } else {
                $response = array('status' => 'success', 'message' => 'Mail not sent due to some error. Please try again.');
            }
    	} else {
    		$msg = 'Customer ID is required.';
			$response = array('status' => 'error', 'message' => $msg);
    	}
    	echo json_encode($response);
    }

    public function reswareAdminCredential()
    {
        $this->load->library('order/order');
        $data = array();
        $data['title'] = 'PCT Order: Resware Admin Credential';
        $data['credResult'] = $this->order->get_resware_admin_credential();

        if ($this->input->post()) {
            $this->form_validation->set_rules('resware_username', 'Username', 'required', array('required'=> 'Please Enter Username'));
            $this->form_validation->set_rules('resware_password', 'Password', 'required', array('required'=> 'Please Enter Password'));
            if ($this->form_validation->run() == true) {
                $this->db->update('pct_resware_admin_credential', array('username' => $this->input->post('resware_username'), 'password' => $this->input->post('resware_password')));  
                $data['success_msg'] = 'Resware Admin credentials updated successfully';  
                $data['credResult'] = $this->order->get_resware_admin_credential();      
            } else {
                $data['resware_username_error_msg'] = form_error('resware_username');
                $data['resware_password_error_msg'] = form_error('resware_password');
            }                                       
        }
        
        $this->load->view('order/layout/header', $data);
        $this->load->view('order/home/resware_admin_credential', $data);
        $this->load->view('order/layout/footer', $data);
    }

    public function importOrders($value='')
    {
        $data = array();
        $data['title'] = 'PCT Order: Import Orders';
        $this->load->view('order/layout/header', $data);
        $this->load->view('order/home/import_order', $data);
        $this->load->view('order/layout/footer', $data);
    }

    public function get_import_order_customer_list()
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

            $incorrect_customer_lists = $this->home_model->get_import_order_users($params);
            // $cnt = ($pageno == 1) ? ($params['start']+1) : (($pageno - 1) * $params['length']) + 1;

            $json_data['draw'] = intval( $params['draw'] );
        }
        else
        {
            $params['searchvalue'] = isset($_POST['keyword']) && !empty($_POST['keyword']) ? $_POST['keyword'] : '';
            $incorrect_customer_lists = $this->home_model->get_import_order_users($params);            
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
               

                $action = "<a href='javascript:void(0);' onclick='importOrders(".$value['id'].")' class='btn btn-secondary'  title='Import'>Import</a>";
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

    public function updateTransaction()
    {
        $partner_id = $this->input->post('partner_id');
        $transaction = $this->input->post('transaction');
        $condition = array('partner_id' => $partner_id);
        $this->home_model->update(array('transaction' => $transaction), $condition, 'pct_order_partner_company_info');
        $data = array('status'=>'success', 'msg'=> 'Transaction updated successfully.');
        echo json_encode($data);
    }

    public function notifications()
    {
        $data = array();
        $data['title'] = 'PCT Order: Notification';
        //$data['notifications'] = $this->home_model->getNotifications();
        $this->load->view('order/layout/header', $data);
        $this->load->view('order/home/notifications', $data);
        $this->load->view('order/layout/footer', $data);
    }

    public function get_notifications_list()
    {
        $params = array();
        if (isset($_POST['draw']) && !empty($_POST['draw'])) {
            $params['draw'] = isset($_POST['draw']) && !empty($_POST['draw']) ? $_POST['draw'] : 10;
            $params['length'] = isset($_POST['length']) && !empty($_POST['length']) ? $_POST['length'] : 10;
            $params['start'] = isset($_POST['start']) && !empty($_POST['start']) ? $_POST['start'] : 0;
            $params['orderColumn'] = isset($_POST['order'][0]['column']) && !empty($_POST['order'][0]['column']) ? $_POST['order'][0]['column'] : 0;
            $params['orderDir'] = isset($_POST['order'][0]['dir']) && !empty($_POST['order'][0]['dir']) ? $_POST['order'][0]['dir'] : 0;
            $params['searchvalue'] = isset($_POST['search']['value']) && !empty($_POST['search']['value']) ? $_POST['search']['value'] : '';
            $notification_lists = $this->home_model->get_notifications_list($params);
            $json_data['draw'] = intval( $params['draw'] );
        } else {
            $params['searchvalue'] = isset($_POST['keyword']) && !empty($_POST['keyword']) ? $_POST['keyword'] : '';
            $notification_lists = $this->home_model->get_notifications_list($params);            
        }

        $data = array(); 
        $count = $params['start'] + 1;
	    if (isset($notification_lists['data']) && !empty($notification_lists['data'])) {
	    	foreach ($notification_lists['data'] as $key => $value)  {
	    		$nestedData=array();
                $nestedData[] = $count;
	            $nestedData[] = $value['name'];
                $notification_id = $value['id'];
                if(isset($_POST['draw']) && !empty($_POST['draw'])) {
                    $nestedData[] = "<div style='display:flex;'><a onclick='preview_email($notification_id)'><i class='fas fa-eye'></i></a>
                    </div>";
                }
	            $data[] = $nestedData;    
                $count++;          
	    	}
	    }
        $json_data['recordsTotal'] = intval( $notification_lists['recordsTotal'] );
        $json_data['recordsFiltered'] = intval( $notification_lists['recordsFiltered'] );
        $json_data['data'] = $data;
	    echo json_encode($json_data);
    }

    public function email_preview()
    {
        $data = array();
        $notificationId = $this->input->post('notificationId');
        if($notificationId == 5) {
            $results = $this->load->view('emails/borrower', $data, TRUE);
        } else if($notificationId == 4) {
            $results = $this->load->view('emails/order', $data, TRUE);
        } else if($notificationId == 7) {
            $results = $this->load->view('emails/prelim', $data, TRUE);
        } else if($notificationId == 6) {
            $results = $this->load->view('emails/search_package', $data, TRUE);
        } else {
            $results = "<div style='margin:50px;'><h3>User Details:</h3><p>Name: </p><p>Telephone: </p><p>Email Address: </p><p>Company Name: </p><p>Street Address: </p><p>City: </p><p>Zipcode: </p><p>Property Address: </p></div>";
        } 
        
        echo json_encode($results, true);
    }

    public function getDeliverables()
    {
        $partner_id = $this->input->post('partner_id');
        $this->db->select('*');
        $this->db->from('pct_order_partner_company_info');
        $this->db->where('partner_id', $partner_id);
        $query = $this->db->get();
        $partnerInfo = $query->row_array(); 
        if(!empty($partnerInfo['deliverables'])) {
            $deliverables = explode(',', $partnerInfo['deliverables']);
            $result = array('deliverables'=> $deliverables);    
        } else {
            $result = array('deliverables'=> array());    
        }
        echo json_encode($result); exit;
    }

    public function storeDeliverables()
    {
        $AdditionalEmail = $this->input->post('AdditionalEmail');
        $partner_id = $this->input->post('partner_id');
        $condition = array(
            'partner_id' =>  $partner_id
        );
        $this->home_model->update(array('deliverables' => implode(',',  $AdditionalEmail)), $condition, 'pct_order_partner_company_info');
        $success = 'Deliverables added successfully.';
        $data = array(
			"success" => $success
		);
		$this->session->set_userdata($data);
        redirect(base_url().'order/admin/companies');
    }

    public function escrow_officers()
    {
        $data = array();
        $data['title'] = 'PCT Order: Escrow Officers';
        $this->load->view('order/layout/header', $data);
        $this->load->view('order/home/escrow_officers', $data);
        $this->load->view('order/layout/footer', $data);
    }

    public function get_escrow_officers_list()
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

            $escrow_officer_lists = $this->home_model->get_escrow_officers($params);
            // $cnt = ($pageno == 1) ? ($params['start']+1) : (($pageno - 1) * $params['length']) + 1;

            $json_data['draw'] = intval( $params['draw'] );
        }
        else
        {
            $params['searchvalue'] = isset($_POST['keyword']) && !empty($_POST['keyword']) ? $_POST['keyword'] : '';
            $escrow_officer_lists = $this->home_model->get_escrow_officers($params);            
        }
        
        $data = array(); 
        
        if(isset($escrow_officer_lists['data']) && !empty($escrow_officer_lists['data']))
        {
            foreach ($escrow_officer_lists['data'] as $key => $value) 
            {
                $nestedData=array();
                
                $nestedData[] = $value['partner_id'];
                $nestedData[] = $value['partner_type_id'];
                $nestedData[] = $value['partner_name'];  
                $nestedData[] = $value['email'];
               
                $action = "";
                $editUrl = base_url().'order/admin/edit-escrow-officer/'.$value['id'];
                $action = "<a href='".$editUrl."' class='btn btn-action edit-agent'title ='Edit Escrow Officer Detail'><span class='fa fa-edit' aria-hidden='true'></span></a>";

                $action .= "<a href='javascript:void(0);' onclick='deleteEscrowOfficer(".$value['id'].")' class='btn btn-action'  title='Delete Escrow Officer'><span class='fa fa-trash' aria-hidden='true'></span></a>";
                $nestedData[] = $action;       
                          
                $data[] = $nestedData;            
                // $cnt++;
            }
        }
        $json_data['recordsTotal'] = intval( $escrow_officer_lists['recordsTotal'] );
        $json_data['recordsFiltered'] = intval( $escrow_officer_lists['recordsFiltered'] );
        $json_data['data'] = $data;
        echo json_encode($json_data);
    }

    public function add_escrow_officer()
    {
        $data = array();
        $data['title'] = 'PCT Order: Add Escrow Officer';
        $escrowData = array();
        if ($this->input->post()) 
        {
           // echo "<pre>"; print_r($this->input->post()); exit;
            $this->form_validation->set_rules('partner_id', 'Partner Id', 'trim|required|numeric', array('required'=> 'Please Enter Partner Id'));
            $this->form_validation->set_rules('partner_type_id', 'Partner Type Id', 'trim|required|numeric', array('required'=> 'Please Enter Partner Type Id'));
            $this->form_validation->set_rules('partner_name', 'Partner Name', 'required', array('required'=> 'Please Enter Partner Name'));
            $this->form_validation->set_rules('email_address', 'Email', 'trim|required|valid_email', array('required'=> 'Please Enter Email', 'valid_email' => 'Please enter valid Email'));
            $this->form_validation->set_rules('address', 'Address', 'required', array('required'=> 'Please Enter Address'));            
            $this->form_validation->set_rules('city', 'City', 'required', array('required'=> 'Please Enter City'));
            $this->form_validation->set_rules('state', 'State', 'required', array('required'=> 'Please Enter State'));
            $this->form_validation->set_rules('zip', 'Zip', 'required', array('required'=> 'Please Enter Zip'));
            $partner_type_ids = array();
            if ($this->form_validation->run() == true) 
            {
                $partner_type_ids[] = 1;
                $partner_type_ids[] = $_POST['partner_type_id'];
                $escrowData = array(
                    'partner_id' => $_POST['partner_id'],
                    'partner_type_id' =>  implode(',', $partner_type_ids),
                    'partner_name' => $_POST['partner_name'],
                    'email' => $_POST['email_address'],
                    'address1' => $_POST['address'],               
                    'city' =>  $_POST['city'],
                    'state' => $_POST['state'],
                    'zip' => $_POST['zip'],
                    'status' => 1
                );

                $insert = $this->home_model->insert($escrowData,'pct_order_partner_company_info');
                    
                if ($insert) {
                    $data['success_msg'] = 'Escrow Officer added successfully.';
                } else {
                    $data['error_msg'] = 'Escrow Officer not added.';
                }              
                
            } else {
                $data['partner_id_error_msg'] = form_error('partner_id');
                $data['partner_type_id_error_msg'] = form_error('partner_type_id');
                $data['partner_name_error_msg'] = form_error('partner_name');
                $data['email_error_msg'] = form_error('email_address');
                $data['address_error_msg'] = form_error('address');
                $data['city_error_msg'] = form_error('city');
                $data['state_error_msg'] = form_error('state');
                $data['zip_error_msg'] = form_error('zip');
            }                                       
        }
        $this->load->view('order/layout/header', $data);
        $this->load->view('order/home/add_escrow_officer', $data);
        $this->load->view('order/layout/footer', $data);
    }

    public function delete_escrow_officer()
    {
        $id = isset($_POST['id']) && !empty($_POST['id']) ? $_POST['id'] : '';

        if($id)
        {
            $escrowData = array('status' => 0);

            $condition = array('id' => $id);

            $update = $this->home_model->update($escrowData, $condition,'pct_order_partner_company_info');

            if($update)
            {
                $successMsg = 'Escrow Officer deleted successfully.';
                $response = array('status'=>'success', 'message'=>$successMsg);
            }
        }
        else
        {
            $msg = 'Escrow Officer ID is required.';
            $response = array('status' => 'error','message'=>$msg);
        }

        echo json_encode($response);
    }

    public function edit_escrow_officer()
    {
        $data = array();
        $id = $this->uri->segment(4);
        $data['title'] = 'PCT Order: Add Escrow Officer';
        $escrowData = array();

        if(isset($id) && !empty($id))
        {
            if ($this->input->post()) 
            {
                $this->form_validation->set_rules('partner_id', 'Partner Id', 'trim|required|numeric', array('required'=> 'Please Enter Partner Id'));
                $this->form_validation->set_rules('partner_type_id', 'Partner Type Id', 'required', array('required'=> 'Please Enter Partner Type Id'));
                $this->form_validation->set_rules('partner_name', 'Partner Name', 'required', array('required'=> 'Please Enter Partner Name'));
                $this->form_validation->set_rules('email_address', 'Email', 'trim|required|valid_email', array('required'=> 'Please Enter Email', 'valid_email' => 'Please enter valid Email'));
                $this->form_validation->set_rules('address', 'Address', 'required', array('required'=> 'Please Enter Address'));            
                $this->form_validation->set_rules('city', 'City', 'required', array('required'=> 'Please Enter City'));
                $this->form_validation->set_rules('state', 'State', 'required', array('required'=> 'Please Enter State'));
                $this->form_validation->set_rules('zip', 'Zip', 'required', array('required'=> 'Please Enter Zip'));
                
                if ($this->form_validation->run() == true) 
                {
                    $escrowData = array(
                        'partner_id' => $_POST['partner_id'],
                        'partner_type_id' =>  $_POST['partner_type_id'],
                        'partner_name' => $_POST['partner_name'],
                        'email' => $_POST['email_address'],
                        'address1' => $_POST['address'],               
                        'city' =>  $_POST['city'],
                        'state' => $_POST['state'],
                        'zip' => $_POST['zip'],
                        'status' => 1
                    );

                    $condition = array('id' => $id);
                    $update = $this->home_model->update($escrowData,$condition,'pct_order_partner_company_info');
                        
                    if ($update) {
                        $data['success_msg'] = 'Escrow Officer updated successfully.';
                    } else {
                        $data['error_msg'] = 'Error occurred while updating Escrow Officer.';
                    }              
                    
                } else {
                    $data['partner_id_error_msg'] = form_error('partner_id');
                    $data['partner_name_error_msg'] = form_error('partner_name');
                    $data['email_error_msg'] = form_error('email_address');
                    $data['address_error_msg'] = form_error('address');
                    $data['city_error_msg'] = form_error('city');
                    $data['state_error_msg'] = form_error('state');
                    $data['zip_error_msg'] = form_error('zip');
                }                                       
            }
            $con = array('id' => $id);
            $data['escrow_info'] = $this->home_model->get_escrow_officer($con);
        }
        else
        {
            redirect(base_url().'escrow-officers');
        }
        
        $this->load->view('order/layout/header', $data);
        $this->load->view('order/home/edit_escrow_officer', $data);
        $this->load->view('order/layout/footer', $data);
    }

    public function downloadAwsDocument()
    {
        $url = $this->input->post('url');
        $binaryData   = base64_encode(file_get_contents($url)); 
		echo $binaryData;exit;
    }

    public function updateAvoidDuplicationFlag()
    {
        $property_id = $this->input->post('property_id');
        $avoidFlag = $this->input->post('avoidFlag');
        $data['allow_duplication'] = $avoidFlag;
        $data['updated_at'] = date("Y-m-d H:i:s");
        $condition = array(
            'id' => $property_id
        );
        $this->db->update('property_details', $data, $condition);
        $data = array('status'=>'success', 'msg'=> 'Avoid duplication flag updated successfully.');
        echo json_encode($data);
    }

    public function updateMortgageUser()
    {
        $user_id = $this->input->post('user_id');
        $mortgageUserFlag = $this->input->post('mortgageUserFlag');
        $data['is_mortgage_user'] = $mortgageUserFlag;
        $data['updated_at'] = date("Y-m-d H:i:s");
        $condition = array(
            'id' => $user_id
        );
        $this->db->update('customer_basic_details', $data, $condition);
        $data = array('status'=>'success', 'msg'=> 'Mortgage user updated successfully.');
        echo json_encode($data);
    }

    public function mortgageBrokers()
    {
        $data = array();
        $data['title'] = 'PCT Order: Mortgage Brokers';
        $this->load->view('order/layout/header', $data);
        $this->load->view('order/home/mortgage_brokers', $data);
        $this->load->view('order/layout/footer', $data);
    }

    public function get_mortgage_brokers_list()
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
            $mortgage_lists = $this->home_model->get_mortgage_users($params);
            $json_data['draw'] = intval( $params['draw'] );
        } else {
            $params['searchvalue'] = isset($_POST['keyword']) && !empty($_POST['keyword']) ? $_POST['keyword'] : '';
            $mortgage_lists = $this->home_model->get_cget_mortgage_usersustomers($params);            
        }

        $data = array(); 
        if(isset($mortgage_lists['data']) && !empty($mortgage_lists['data'])) {
            foreach ($mortgage_lists['data'] as $key => $value) {
                $nestedData=array();
                $user_id = $value['id'];
                $nestedData[] = $value['first_name'];
                $nestedData[] = $value['last_name'];
                $nestedData[] = $value['email_address'];
                $nestedData[] = $value['company_name'];
                $nestedData[] = $value['street_address'].", ".$value['city'].", ".$value['state'].", ".$value['zip_code'];
                if ($value['is_primary_mortgage_user'] == 1) {
                    $checked = 'checked';
                } else {
                    $checked = '';
                }
                $nestedData[] = "<input $checked onclick='isMortgagePrimaryUser();' style='height:30px;width:20px;' type='checkbox' id='$user_id' name='$user_id'>";
                if (isset($_POST['draw']) && !empty($_POST['draw'])) {
                    $action = "<a href='javascript:void(0);' onclick='deleteCustomer(".$value['id'].")' class='btn btn-action'  title='Delete Customer'><span class='fa fa-trash' aria-hidden='true'></span></a>";
                    $nestedData[] = $action;
                }
                $data[] = $nestedData;            
            }
        }
        $json_data['recordsTotal'] = intval( $mortgage_lists['recordsTotal'] );
        $json_data['recordsFiltered'] = intval( $mortgage_lists['recordsFiltered'] );
        $json_data['data'] = $data;
        echo json_encode($json_data);
    }

    public function isMortgagePrimaryUser()
    {
        $user_id = $this->input->post('user_id');
        $primaryMortgageUserFlag = $this->input->post('primaryMortgageUserFlag');
        $data['is_primary_mortgage_user'] = $primaryMortgageUserFlag;
        $data['updated_at'] = date("Y-m-d H:i:s");
        $condition = array(
            'id' => $user_id
        );
        $this->db->update('customer_basic_details', $data, $condition);
        $data = array('status'=>'success', 'msg'=> 'Mortgage user updated successfully.');
        echo json_encode($data);
    }

    public function getFormDetails()
    {
        $this->load->model('order/fileDocument_model'); 
        $this->load->model('order/titleOfficerForms'); 
		$formId = $this->input->post('formId');
		$formDetails = $this->fileDocument_model->get_rows(array('id' => $formId));
        $titleOfficers = $this->titleOfficerForms->getTitleOfficersForForm($formId);
        //print_r($titleOfficers);exit;
		$response = array('status'=>'success', 'formDetails' => $formDetails, 'titleOfficers' => $titleOfficers);
		echo json_encode($response); exit; 
    }

    public function deleteForm()
    {
        $id = isset($_POST['id']) && !empty($_POST['id']) ? $_POST['id'] : '';
        if ($id) {
            $this->db->delete('pct_file_documents', array('id' => $id));
            $this->db->delete('pct_order_title_officers_forms', array('form_id' => $id));
            $successMsg = 'Form deleted successfully.';
            $response = array('status'=>'success', 'message'=>$successMsg);
        } else {
            $msg = 'Form ID is required.';
            $response = array('status' => 'error','message'=>$msg);
        }
        echo json_encode($response);
    }

    public function changePassword()
    {
        $this->load->model('order/apiLogs');
        $id = $this->input->post('id');
        $userdata = $this->session->userdata('admin');
        $params = array(
            'id' => $id
        );
        $userInfo = $this->home_model->get_rows($params);
        $response = $this->addNewUserToResware($userInfo);
        if ($response['success']) {
            $customerData['resware_user_id'] = $response['resware_user_id'];
            $customerData['random_password'] = $this->order->randomPassword();
            $reswareUpdatePwdData = array(
                'user_name' =>  $userInfo['email_address'],
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
                $response = array('status' => 'error','message' => $data['error_msg']);
            } else {
                $customerData['is_password_updated'] = 1;
                $data['success_msg'] = 'Password updated successfully for email user: '. $this->input->post('email_address');
                $response = array('status' => 'success', 'message' => $data['success_msg']);
            }

            $updateCondition = array(
                'partner_id' => $userInfo['partner_id'],
                'resware_user_id' => $userInfo['resware_user_id']
            );
            $this->home_model->update($customerData, $updateCondition);
        } else {
            $data['error_msg'] = $response['msg'];
            $response = array('status' => 'error', 'message' =>  $data['error_msg']);
        } 
    	echo json_encode($response);
    }

    public function isPasswordRequired()
    {
        $user_id = $this->input->post('user_id');
        $is_password_required = $this->input->post('is_password_required');
        $data['is_password_required'] = $is_password_required;
        $data['updated_at'] = date("Y-m-d H:i:s");
        $condition = array(
            'id' => $user_id
        );
        $this->db->update('customer_basic_details', $data, $condition);
        $data = array('status'=>'success', 'msg'=> 'Password required field updated successfully.');
        echo json_encode($data);
    }

	public function refreshExipredPasswords()
    {
		$command = "php ".FCPATH."index.php frontend/order/cron passwordUpdateAll";
		if (substr(php_uname(), 0, 7) == "Windows"){
			pclose(popen("start /B ". $command, "r")); 
		}
		else {
			exec($command . " > /dev/null &");  
		}
		echo  json_encode(array('status'=>'success', 'message'=> 'Script execution is in process.'));

	}

    public function sendDailyProductionReport()
    {
        $this->load->library('order/order');
        $result = $this->order->sendDailyProductionReport(1);
        if ($result) {
            echo json_encode(array('status'=>'success', 'message'=> 'Daily production mail sent successfully.'));   
        } else {
            echo json_encode(array('status'=>'error'));
        }
    }

    public function updateDualCplUser()
    {
        $user_id = $this->input->post('user_id');
        $dualCplUserFlag = $this->input->post('dualCplUserFlag');
        $data['is_dual_cpl'] = $dualCplUserFlag;
        $data['updated_at'] = date("Y-m-d H:i:s");
        $condition = array(
            'id' => $user_id
        );
        $this->db->update('customer_basic_details', $data, $condition);
        $data = array('status'=>'success', 'msg'=> 'Dual Cpl value updated successfully for user.');
        echo json_encode($data);
    }

    public function pre_listing_document()
    {
        $data = array();
        $data['title'] = 'PCT Order: Pre Listing Documents';
        $this->load->view('order/layout/header', $data);
        $this->load->view('order/home/pre_listing_document', $data);
        $this->load->view('order/layout/footer', $data);
    }

    public function lp_listing_document()
    {
        $data = array();
        $data['title'] = 'PCT Order: Pre Listing Report Documents';
        $this->load->view('order/layout/header', $data);
        $this->load->view('order/home/lp_listing_document', $data);
        $this->load->view('order/layout/footer', $data);
    }

    public function get_pre_listing_document_list()
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
            $pre_listing_document_lists = $this->home_model->get_pre_listing_document_list($params);
            $json_data['draw'] = intval( $params['draw'] );
        } else {
            $params['searchvalue'] = isset($_POST['keyword']) && !empty($_POST['keyword']) ? $_POST['keyword'] : '';
            $pre_listing_document_lists = $this->home_model->get_pre_listing_document_list($params);            
        }

        $data = array(); 
        
        if(isset($pre_listing_document_lists['data']) && !empty($pre_listing_document_lists['data'])) {
            $i = $params['start'] + 1;
            foreach ($pre_listing_document_lists['data'] as $key => $value) {
                $nestedData=array();
                $nestedData[] = $i;
                $nestedData[] = $value['lp_file_number'];
                $nestedData[] = $value['document_name'];
                $documentName = $value['document_name'];
                // if ($value['api_document_id'] > 0) {
                //     $nestedData[] = 'Yes';
                // } else {
                //     $nestedData[] = 'No';
                // }
                
				$nestedData[] = convertTimezone($value['created']);
                
                $documentUrl = env('AWS_PATH')."pre-listing-doc/".$documentName;
                if(isset($_POST['draw']) && !empty($_POST['draw'])) {
                    $nestedData[] = "<div style='display:flex;'><a href='#' onclick='downloadDocumentFromAws(".'"'.$documentUrl.'"'.", ".'"report"'.");'><i class='fas fa-fw fa-download'></i></a>
                    <a style='margin-left:10px;' target='_blank' href='$documentUrl'><i class='fas fa-fw fa-eye'></i></a></div>";
                }
                $data[] = $nestedData;  
                $i++;          
            }
        }
        $json_data['recordsTotal'] = intval( $pre_listing_document_lists['recordsTotal'] );
        $json_data['recordsFiltered'] = intval( $pre_listing_document_lists['recordsFiltered'] );
        $json_data['data'] = $data;
        echo json_encode($json_data);
    }

    public function get_lp_listing_document_list()
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
            $lp_listing_document_lists = $this->home_model->get_lp_listing_document_list($params);
            $json_data['draw'] = intval( $params['draw'] );
        } else {
            $params['searchvalue'] = isset($_POST['keyword']) && !empty($_POST['keyword']) ? $_POST['keyword'] : '';
            $lp_listing_document_lists = $this->home_model->get_lp_listing_document_list($params);            
        }
        
        $data = array(); 
        
        if(isset($lp_listing_document_lists['data']) && !empty($lp_listing_document_lists['data'])) {
            $i = $params['start'] + 1;
            foreach ($lp_listing_document_lists['data'] as $key => $value) {
                $nestedData=array();
                $nestedData[] = $i;
                $nestedData[] = $value['lp_file_number'];
                $nestedData[] = $value['document_name'];
                $documentName = $value['document_name'];
                
                $lp_report_status = $value['lp_report_status'];
                $lpReportStatusSelection ='<select onchange="updateLpReportStatus('.$value['file_id'].',this.value);" id="lp_report_status" name="lp_report_status">
                                    <option value="">Select</option>
                                    <option value="pending">Pending</option>
                                    <option value="approved">Approved</option>
                                    <option value="denied">Denied</option>
                                </select>'; 
                $lpReportStatusSelection = str_replace('value="' .  $lp_report_status . '"','value="' .  $lp_report_status . '" selected', $lpReportStatusSelection);          
                $nestedData[] = $lpReportStatusSelection;
                
				$nestedData[] = convertTimezone($value['created']);
                
                $documentUrl = env('AWS_PATH')."pre-listing-doc/".$documentName;
                if(isset($_POST['draw']) && !empty($_POST['draw'])) {
                    $nestedData[] = "<div style='display:flex;'><a href='#' onclick='downloadDocumentFromAws(".'"'.$documentUrl.'"'.", ".'"report"'.");'><i class='fas fa-fw fa-download'></i></a>
                    <a style='margin-left:10px;' target='_blank' href='$documentUrl'><i class='fas fa-fw fa-eye'></i></a></div>";
                }
                $data[] = $nestedData;  
                $i++;          
            }
        }
        $json_data['recordsTotal'] = intval( $lp_listing_document_lists['recordsTotal'] );
        $json_data['recordsFiltered'] = intval( $lp_listing_document_lists['recordsFiltered'] );
        $json_data['data'] = $data;
        echo json_encode($json_data);
    }

    public function updateLpReportStatus()
    {
        $this->load->model('order/apiLogs');
        $this->load->library('order/twilio');
        //$this->load->model('frontend/order/twilioMessage');
        $file_id = $this->input->post('file_id');
        $status = $this->input->post('status');
        $updateData = array('lp_report_status' => $status);
        $condition = array('file_id' => $file_id);
        $this->home_model->update($updateData, $condition, 'order_details');
        $order_details = $this->order_model->get_order_details($file_id);

        if (!empty($order_details['sales_rep_phone'])) {
            $sid = env('TWILIO_SID');
            $token = env('TWILIO_TOKEN');
            $from = env('TWILIO_FROM');
            $message = "LP Report is ready for file number ".$order_details['lp_file_number'];
            // $logid = $this->apiLogs->syncLogs('', 'twilio', 'send_message', '', array('message' => $message, 'account_sid' => $sid, 'token' => $token,'to'=> $order_details['sales_rep_phone'], 'from'=>$from), array(), 0, 0);

            // try {
            //     $result = $this->twilio->message($order_details['sales_rep_phone'], $message,'',array('from'=>$from));
            //     $response = $result->toArray();
            //     $response['msg_status'] = 'success';
            //     $response['code'] = $code;

            // } catch (Exception $e) {
            //     $response['sid'] = '';
            //     $response['to'] = $order_details['sales_rep_phone'];
            //     $response['msg_status'] = 'error';
            //     $response['errorCode'] = $e->getCode();
            //     $response['errorMessage'] = $e->getMessage();
            // } catch (\Twilio\Exceptions\RestException $e) {
            //     $response['sid'] = '';
            //     $response['to'] = $order_details['sales_rep_phone'];
            //     $response['msg_status'] = 'error';
            //     $response['errorCode'] = $e->getCode();
            //     $response['errorMessage'] = $e->getMessage();
            // }

            // $this->apiLogs->syncLogs('', 'twilio', 'send_message', '', array('code'=>$code,'account_sid'=>$sid,'token'=>$token,'to'=> $order_details['sales_rep_phone'], 'from'=>$from), $response, 0, $logid);

            // if ($response['msg_status'] == 'success') {
            //     $data = array(
            //         'message' => $response['body'],
            //         'sent_from' => $response['from'],
            //         'sent_to' => $response['to'],
            //         'status' => $response['status'],
            //         'message_sid' => $response['sid'],
            //         'error_code' => $response['errorCode'],
            //         'error_message' => $response['errorMessage'],
            //     );
            //     $this->twilioMessage->insert($data);
            //     $result = array('msg_status'=>'success', 'message'=> 'Code generated successfully.');
            // } else {
            //     $result = array('msg_status'=>'error', 'error_message'=> $response['errorMessage']);
            // }
        }
        
        $data = array('status'=>'success', 'msg'=> 'Lp report status updated successfully.');
        echo json_encode($data);exit;
    }

    public function sendOrderToResware() 
    {
        $file_id = $this->input->post('file_id');
        $order_details = $this->order_model->get_order_details($file_id);
        $splitName = explode(' ', $order_details['primary_owner']);
        $ownerLastName = end($splitName);
        $primaryName = array_slice($splitName, 0, -1);
        $ownerFirstName = implode(" ", $primaryName);

        $place_order = array();
        $loanFlag = 1;
        $legalEntity = array(
            'EntityType' => 'INDIVIDUAL', 
            'IsPrimaryTransactee' => 'true', 
            'primary' => array(
                'First' => $ownerFirstName,
                'Last' => $ownerLastName
            ),
            'Address' => array(
                'Address1' => $order_details['address'], 
                'City' => $order_details['property_city'], 
                'State' => $order_details['property_state'], 
                'Zip' => $order_details['property_zip']
            )
        );

        if (strpos($order_details['product_type'], 'Loan') !== false) {
            $place_order['Buyers'][] = $legalEntity;
        } elseif(strpos($order_details['product_type'], 'Sale') !== false) {
            $borrowerName = explode(' ', $order_details['borrower']);
            $borrowerLastName = end($borrowerName);
            $borrowerPrimaryName = array_slice($borrowerName, 0, -1);
            $borrowerFirstName = implode(" ", $borrowerPrimaryName);
            $borrowers = array(
                'EntityType' => 'INDIVIDUAL', 
                'IsPrimaryTransactee' => 'true', 
                'primary' => array(
                    'First' => $borrowerFirstName,
                    'Last' => $borrowerLastName
                )
            );
            $place_order['Sellers'][] = $legalEntity;
            $place_order['Buyers'][] = $borrowers;
            $place_order['SalesPrice'] = $order_details['sales_amount'];
            $loanFlag = 0;
        }
        
        $place_order['TransactionProductType'] = array(
            "TransactionTypeID" => $order_details['transaction_type'], 
            'ProductTypeID' => $order_details['purchase_type']
        );
        $loan = array();
        if (isset($order_details['loan_amount']) && !empty($order_details['loan_amount'])) {
            $loan['LoanAmount'] = $order_details['loan_amount'];
        }

        if(isset($order_details['loan_number']) && !empty($order_details['loan_number'])) {
            $loan['LoanNumber'] = $loan_number;
        }
        
        if ($order_details['purchase_type'] == '4' || $order_details['purchase_type'] == '5' || $order_details['purchase_type'] == '36') {
            $loan['LienPosition'] = 0;
            $loan['LoanType'] = 'ConvIns';
            $place_order['SettlementStatementVersion'] = 'HUD';
        }
        
        $splitPropertyAddress = explode(' ', $order_details['address']);
        $streetNumber = isset($splitPropertyAddress[0]) && !empty($splitPropertyAddress[0]) ? $splitPropertyAddress[0] : '';
        $primaryStreetName = array_slice($splitPropertyAddress, 1);
        $streetName = isset($primaryStreetName) && !empty($primaryStreetName) ? implode(" ", $primaryStreetName) : '';

        $place_order['Loans'][] = $loan;
        $place_order['Properties'][] = array(
            'IsPrimary' => 'true', 
            'StreetNumber' => $streetNumber, 
            'StreetName' => $streetName, 
            'City' => $order_details['property_city'], 
            'State' => $order_details['property_state'], 
            'County'=> $order_details['county'], 
            'Zip' => $order_details['property_zip']
        );
        $place_order['Note']['APN'] = $order_details['apn'];
        $place_order['Note']['parcel_id'] = $order_details['apn'];
        $place_order['Note']['legal_description'] = $order_details['legal_description'];
        
        if (!empty($order_details['title_officer_name'])) {
            $place_order['Note']['title_Officer'] = $order_details['title_officer_name'];
        }

        if (!empty($order_details['sales_rep_name'])) {
            $place_order['Note']['sales_rep'] = $order_details['sales_rep_name'];
        }

        if (!empty($order_details['buyer_agent_id'])) {
            $buyers_agent_details = array(
                'name' => $order_details['buyer_agent_name'], 
                'email' => $order_details['buyer_agent_email_address'], 
                'telephone' => $order_details['buyer_agent_company'],
                'company' => $order_details['buyer_agent_telephone_no']
            );
            $place_order['Note']['buyers_agent'] = $buyers_agent_details;
        }

        if (!empty($order_details['listing_agent_id'])) {
            $listing_agent_details = array(
                'name' => $order_details['buyer_agent_name'], 
                'email' => $order_details['buyer_agent_email_address'], 
                'telephone' => $order_details['buyer_agent_company'],
                'company' => $order_details['buyer_agent_telephone_no']
            );
            $place_order['Note']['listing_agent'] = $listing_agent_details;
        }

        // if (!empty($lender_details)) {
        //     $place_order['Note']['lender_details'] = $lender_details;
        // }

        // if (!empty($escrow_details)) {
        //     $place_order['Note']['escrow_details'] = $escrow_details;
        // }

        if (!empty($order_details['escrow_number'])) {
            $place_order['Note']['EscrowNumber'] = $order_details['escrow_number'];
        }

        if (!empty($order_details['notes'])) {
            $place_order['Note']['Notes'] = $order_details['notes'];
        }				


        $user_data = array();
        $orderUser =  $this->home_model->get_user(array('id' => $order_details['customer_id']));	
        $user_data['email'] = $orderUser['email_address'];
        $user_data['password'] = $orderUser['random_password'];
        $user_data['from_mail'] = 1;
        
        $order_data = json_encode($place_order);
        $this->load->library('order/resware');
        $this->load->model('order/apiLogs');
        $logid = $this->apiLogs->syncLogs($userdata['id'], 'resware', 'create_order', env('RESWARE_ORDER_API').'orders', $order_data, array(), 0, 0);
        $result = $this->resware->make_request('POST', 'orders', $order_data, $user_data);
        $this->apiLogs->syncLogs($userdata['id'], 'resware', 'create_order', env('RESWARE_ORDER_API').'orders', $order_data, $result, 0, $logid);
        
        if(isset($result) && !empty($result)) {
            $response = json_decode($result,true);

            if (isset($response['ResponseStatus']) && !empty($response['ResponseStatus'])) {
                $message = isset($response['ResponseStatus']['Message']) && !empty($response['ResponseStatus']['Message']) ? $response['ResponseStatus']['Message'] : '';
                $response = array('status'=>'error', 'message'=> $message);
                echo json_encode($response); exit;
            } else {
                $orderNumber = $file_id = '';
                if(isset($response['FileID']) && !empty($response['FileID'])) {
                    $fileNumber = isset($response['FileNumber']) && !empty($response['FileNumber']) ? $response['FileNumber'] : '';
                    $file_id = isset($response['FileID']) && !empty($response['FileID']) ? $response['FileID'] : '';
                }
                $condition = array('id' => $order_details['order_id']);
                $data = array('file_id' => $file_id, 'file_number' => $fileNumber);
                $update = $this->order_model->update($data, $condition);
                $data = array('status'=>'success', 'message'=> 'Order synced successfully on Resware side with file number '. $fileNumber);
                echo json_encode($data);exit;
            }
        }
    }

    public function importDocumentTypes()
    {    
        $data = array();
        $data['title'] = 'PCT Order: Import Document Types';
    	if ($this->input->post()) {
            $this->form_validation->set_rules('file', 'CSV file', 'callback_file_check');
            
            if ($this->form_validation->run($this) == true) {
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

    public function adminUserLogs()
    {
        $data = array();
        $data['title'] = 'PCT Order: Admin User Logs';
        $this->load->view('order/layout/header', $data);
        $this->load->view('order/home/admin_user_logs', $data);
        $this->load->view('order/layout/footer', $data);
    }

    public function get_admin_user_logs()
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
            $admin_logs_list = $this->home_model->get_admin_user_logs($params);
            $json_data['draw'] = intval( $params['draw'] );
        } else {
            $params['searchvalue'] = isset($_POST['keyword']) && !empty($_POST['keyword']) ? $_POST['keyword'] : '';
            $admin_logs_list = $this->home_model->get_admin_user_logs($params);            
        }

        $data = array(); 
        
        if(isset($admin_logs_list['data']) && !empty($admin_logs_list['data'])) {
            $i = $params['start'] + 1;
            foreach ($admin_logs_list['data'] as $key => $value) {
                $nestedData=array();
                $nestedData[] = $i;
                $nestedData[] = $value['first_name'];
                $nestedData[] = $value['last_name'];
                $nestedData[] = $value['message']; 
				$nestedData[] = convertTimezone($value['created_at']);
                $data[] = $nestedData;  
                $i++;          
            }
        }
        $json_data['recordsTotal'] = intval( $admin_logs_list['recordsTotal'] );
        $json_data['recordsFiltered'] = intval( $admin_logs_list['recordsFiltered'] );
        $json_data['data'] = $data;
        echo json_encode($json_data);
    }

    public function storeLpDocumentInfo()
    {
        $this->load->library('order/order');
        $this->load->model('order/titlePointData');
        $instrument_number_ids = $this->input->post('instrument_number_ids');
        $title_point_id = $this->input->post('title_point_id');

        $this->db->select('*');
        $this->db->from('pct_order_title_point_data');
        $this->db->where('id', $title_point_id);
        $query = $this->db->get();
        $titlePointData = $query->row_array(); 

        $this->db->update('pct_title_point_document_records', array('is_display' => 0),array('title_point_id' => $title_point_id));
        foreach($instrument_number_ids as $instrument_number_id) {
            $this->db->update('pct_title_point_document_records', array('is_display' => 1),array('id' => $instrument_number_id)); 
        }

        $file_id = $titlePointData['file_id'];
        $condition = array(
            'where' => array(
                'file_number' => $titlePointData['file_number'],
            )
        );
        $titlePointDetails = $this->titlePointData->gettitlePointDetails($condition);
        $titlePointInstrumentDetails = $this->titlePointData->getInstrumentDetails($titlePointData['file_number']);
        $titlePointInstrumentDetails = array_chunk($titlePointInstrumentDetails, 25);
        $orderDetails = $this->order->get_order_details($file_id);
        $instrumentRecordDetails['orderDetails'] = $orderDetails;
        $instrumentRecordDetails['titlePointDetails'] = $titlePointDetails;
        $instrumentRecordDetails['titlePointInstrumentDetails'] = $titlePointInstrumentDetails;
        $plat_map_url = '';
		if ($this->order->fileExistOrNotOnS3('plat-map/'.$titlePointData['file_number'].'.png'))  {
            $plat_map_url = env('AWS_PATH')."plat-map/".$titlePointData['file_number'].'.png';
        } 
        $instrumentRecordDetails['is_plat_map_exist'] = !empty($plat_map_url) ? 1 : 0;
        $html = $this->load->view('report/instrument_report',$instrumentRecordDetails,true);
        // echo $html;die;
        
        $this->load->library('snappy_pdf');
        
        $document_name = 'pre_listing_report_'.$fileNumber.'.pdf';
        if (!is_dir('uploads/pre-listing-doc')) {
            mkdir('./uploads/pre-listing-doc', 0777, TRUE);
        }
        $pdfFilePath = FCPATH.'/uploads/pre-listing-doc/'.$document_name;
        $pdfFilePath = str_replace('\\', '/', $pdfFilePath);
        $this->snappy_pdf->pdf->generateFromHtml($html,$pdfFilePath);
        $this->order->uploadDocumentOnAwsS3($document_name, 'pre-listing-doc');
        $this->insertRecord($document_name, $file_id, $orderDetails);
        $successMsg = 'Document Data saved successfully and LP report generated successfully for new data.';
        $this->session->set_userdata('success', $successMsg);
        redirect(base_url().'order/admin/lp-orders');

    }

    public function insertRecord($document_name, $fileId, $orderDetails)
	{
		$this->load->model('frontend/order/document');
		// $this->load->library('order/resware');
		// $this->load->model('order/apiLogs');
		
		$fileSize = filesize(env('AWS_PATH')."pre-listing-doc/".$document_name);
		// $contents = file_get_contents(env('AWS_PATH')."pre-listing-doc/".$document_name);
		// $binaryData   = base64_encode($contents); 

		$documentData = array(
			'document_name' => $document_name,
			'original_document_name' => $document_name,
			'document_type_id' => 1037,
			'document_size' => $fileSize,
			'user_id' => 0,
			'order_id' => $orderDetails['order_id'],
			'description' => 'Pre Listing Report Document',
			'is_sync' => 1,
			'is_prelim_document' => 0,
			'is_pre_listing_doc' => 0,
			'is_pre_listing_report_doc' => 1
		);
		$condition = array('is_pre_listing_report_doc' => 1, 'order_id' => $orderDetails['order_id']);
		$this->document->delete($documentData, $condition);
		$this->document->insert($documentData);
	}
}

