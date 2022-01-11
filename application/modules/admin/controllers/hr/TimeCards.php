<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Timecards extends MX_Controller {

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
        $this->load->library('hr/adminTemplate');
        $this->load->model('hr/hr'); 
        $this->load->library('hr/common');
        $this->common->is_hr_admin();
    }

    public function index()
    {
        $data['title'] = 'HR-Center Time Cards';
        $data['page_title'] = 'Time Cards';
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
        $this->admintemplate->show("hr", "time_cards", $data);
    }

    public function getTimeCards()
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
			$timeCardsList = $this->common->getTimeCards($params);
			$json_data['draw'] = intval( $params['draw'] );
		} else {
			$params['searchvalue'] = isset($_POST['keyword']) && !empty($_POST['keyword']) ? $_POST['keyword'] : '';
			$timeCardsList = $this->common->getTimeCards($params);
		}
		
		if (isset($timeCardsList['data']) && !empty($timeCardsList['data'])) {
			$i = $params['start'] + 1;
			foreach ($timeCardsList['data'] as $timeCard)  {
				$nestedData = array();
				$nestedData[] = $i;
				$nestedData[] = $timeCard['first_name']." ".$timeCard['last_name'];
                $nestedData[] = date("m/d/Y", strtotime($timeCard['exception_date']));
                $nestedData[] = $timeCard['reg_hours'];
                $nestedData[] = $timeCard['ot_hours'];
                $nestedData[] = $timeCard['double_ot'];
				$nestedData[] = $timeCard['total_hours'];
                if(isset($_POST['draw']) && !empty($_POST['draw'])) {
                    $editUrl = base_url().'hr/admin/edit-time-card/'.$timeCard['id'];
                    $nestedData[] = '<a href=""><button type="button" rel="tooltip" title="" class="btn btn-info btn-simple btn-link" data-original-title="Edit Task">
                    <i class="fa fa-edit"></i></a>
                    </button><button type="button" style="cursor:pointer;" rel="tooltip" title="" onclick="deleteTimeCard('.$timeCard["id"].')" class="btn btn-danger btn-simple btn-link" data-original-title="Remove">
                        <i class="fa fa-times"></i>
                    </button>';
                }
				$data[] = $nestedData; 
				$i++; 
			}
		}

		$json_data['recordsTotal'] = intval( $timeCardsList['recordsTotal'] );
		$json_data['recordsFiltered'] = intval( $timeCardsList['recordsFiltered'] );
		$json_data['data'] = $data;
		echo json_encode($json_data);
    }

    public function addTimeCard()
    {
        $data['title'] = 'HR-Center Add User';
        $data['page_title'] = 'Users';
        $data['hrPositions'] = $this->hr->getHrPositions(); 
        $data['userTypes'] = $this->hr->getHrUserTypes(); 
        if ($this->input->post()) {
            $this->load->library('hr/common');
            $this->form_validation->set_rules('first_name', 'First Name', 'required', array('required'=> 'Please Enter First Name'));
            $this->form_validation->set_rules('last_name', 'Last Name', 'required', array('required'=> 'Please Enter Last Name'));
            $this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email|is_unique[pct_hr_users.email]', array('required'=> 'Please Enter Email', 'valid_email' => 'Please enter valid Email', 'is_unique'=>'Email already Exist'));
            $this->form_validation->set_rules('position', 'Password', 'required', array('required'=> 'Please Select Position'));
            $this->form_validation->set_rules('hire_date', 'Hire Date', 'required', array('required'=> 'Please Enter Hire Date'));
            $this->form_validation->set_rules('user_type', 'User Type', 'required', array('required'=> 'Please Check User Type'));
           
            if ($this->form_validation->run() == true) {
                $randomPassword = $this->common->randomPassword();
                $usersData = array(
                    'first_name' =>  $this->input->post('first_name'),
                    'last_name' =>  $this->input->post('last_name'),
                    'email' => $this->input->post('email'),
                    'password' => password_hash($randomPassword, PASSWORD_DEFAULT),    
                    'position_id' => $this->input->post('position'),
                    'user_type_id' => $this->input->post('user_type'),
                    'hire_date' => date("Y-m-d", strtotime($this->input->post('hire_date'))),
                    'status' => 1,
                    'is_tmp_password' => 1
                );
                $this->hr->insert($usersData, 'pct_hr_users');
                $successMsg = 'User added successfully.';

                $from_name = 'Pacific Coast Title Company';
                $from_mail = getenv('FROM_EMAIL');
                $message_body = "Hi ".$this->input->post('first_name')." ".$this->input->post('last_name').", <br><br>";
                $message_body .= "You have been invited to the Pacific Coast Title HR center. Please login with tempoary password and change your password.<br><br>";
                $message_body .= "Tempoary password: ".$randomPassword. "<br><br>";
                $message_body .= "Please click on the link below to complete your registration.<br><br> ".getenv('APP_URL')."hr/login";
                $subject = 'Invitation For Pacific Coast Title HR Center';
                $to = $this->input->post('email');
                $this->load->helper('sendemail');
                send_email($from_mail, $from_name, $to, $subject, $message_body);
                $this->session->set_userdata('success', $successMsg);
                redirect(base_url().'hr/admin/users');
            } else {
                $data['first_name_error_msg'] = form_error('first_name');
                $data['last_name_error_msg'] = form_error('last_name');
                $data['email_error_msg'] = form_error('email');
                $data['position_error_msg'] = form_error('position');
                $data['hire_date_error_msg'] = form_error('hire_date');
                $data['user_type_error_msg'] = form_error('user_type');
            }                                       
        }
        $this->admintemplate->show("hr", "add_time_card", $data);
    }

    public function editTimeCard()
    {
        $id = $this->uri->segment(4);
        $data['title'] = 'HR-Center Edit User';
        $data['page_title'] = 'Users';
        $data['hrPositions'] = $this->hr->getHrPositions(); 
        $data['userTypes'] = $this->hr->getHrUserTypes(); 

        if(isset($id) && !empty($id)) {
            if ($this->input->post()) {
                $this->load->library('hr/common');
                $this->form_validation->set_rules('first_name', 'First Name', 'required', array('required'=> 'Please Enter First Name'));
                $this->form_validation->set_rules('last_name', 'Last Name', 'required', array('required'=> 'Please Enter Last Name'));
                $this->form_validation->set_rules('position', 'Password', 'required', array('required'=> 'Please Select Position'));
                $this->form_validation->set_rules('hire_date', 'Hire Date', 'required', array('required'=> 'Please Enter Hire Date'));
                $this->form_validation->set_rules('user_type', 'User Type', 'required', array('required'=> 'Please Check User Type'));
               
                if ($this->form_validation->run() == true) {
                    $usersData = array(
                        'first_name' =>  $this->input->post('first_name'),
                        'last_name' =>  $this->input->post('last_name'), 
                        'position_id' => $this->input->post('position'),
                        'user_type_id' => $this->input->post('user_type'),
                        'hire_date' => date("Y-m-d", strtotime($this->input->post('hire_date'))),
                        'status' => 1
                    );
                    $condition = array('id' => $id);
                    $this->hr->update($usersData, $condition, 'pct_hr_users');
                    $successMsg = 'User updated successfully.';
                    $this->session->set_userdata('success', $successMsg);
                    redirect(base_url().'hr/admin/users');
                } else {
                    $data['first_name_error_msg'] = form_error('first_name');
                    $data['last_name_error_msg'] = form_error('last_name');
                    $data['position_error_msg'] = form_error('position');
                    $data['hire_date_error_msg'] = form_error('hire_date');
                    $data['user_type_error_msg'] = form_error('user_type');
                }                                       
            }
            $data['userInfo'] = $this->hr->getUserInfo($id);
        } else {
            redirect(base_url().'hr/admin/users');
        }
        $this->admintemplate->show("hr", "edit_user", $data);
    }

    public function deleteTimeCard()
    {
        $id = isset($_POST['id']) && !empty($_POST['id']) ? $_POST['id'] : '';
        if ($id) {
            $userData = array('status' => 0);
            $condition = array('id' => $id);
            $update = $this->hr->update($userData, $condition, 'pct_hr_users');
            if ($update) {
                $successMsg = 'User deleted successfully.';
                $response = array('status'=>'success', 'message' => $successMsg);
            }
        } else {
            $msg = 'User ID is required.';
            $response = array('status' => 'error','message'=>$msg);
        }
        echo json_encode($response);
    }
}
