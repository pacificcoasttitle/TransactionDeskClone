<?php

(defined('BASEPATH')) OR exit('No direct script access allowed');

class TimeCards extends MX_Controller 
{
	function __construct() 
    {
        parent::__construct();
		$this->load->helper(
            array('file', 'url','form')
        );
        $this->load->library('session');
		$this->load->library('form_validation');
		$this->load->library('hr/template');
        $this->load->library('hr/common');
        $this->load->model('hr/hr'); 
        $this->common->is_user();
	}
	
	public function index()
	{
        $userdata = $this->session->userdata('hr_user');
        $data['errors'] = array();
        $data['success'] = array();
        if ($this->session->userdata('errors')) {
            $data['errors'] = $this->session->userdata('errors');
            $this->session->unset_userdata('errors');
        }
        if ($this->session->userdata('success')) {
            $data['success'] = $this->session->userdata('success');
            $this->session->unset_userdata('success');
        }
        $data['name'] = $userdata['name'];
		$data['title'] = 'HR-Center Time Cards';
        $this->template->show("hr", "time_cards", $data);
	}

    public function getTimeCards()
    {
        $userdata = $this->session->userdata('hr_user');
        $params = array();  $data = array();
		if (isset($_POST['draw']) && !empty($_POST['draw'])) {
			$params['draw'] = isset($_POST['draw']) && !empty($_POST['draw']) ? $_POST['draw'] : 10;
			$params['length'] = isset($_POST['length']) && !empty($_POST['length']) ? $_POST['length'] : 2;
			$params['start'] = isset($_POST['start']) && !empty($_POST['start']) ? $_POST['start'] : 0;
			$params['orderColumn'] = isset($_POST['order'][0]['column']) && !empty($_POST['order'][0]['column']) ? $_POST['order'][0]['column'] : 0;
			$params['orderDir'] = isset($_POST['order'][0]['dir']) && !empty($_POST['order'][0]['dir']) ? $_POST['order'][0]['dir'] : 0;
			$params['searchvalue'] = isset($_POST['search']['value']) && !empty($_POST['search']['value']) ? $_POST['search']['value'] : '';
			$pageno = ($params['start'] / $params['length'])+1;
			$timeCardsList = $this->hr->getTimeCards($params);
			$json_data['draw'] = intval( $params['draw'] );
		} else {
			$params['searchvalue'] = isset($_POST['keyword']) && !empty($_POST['keyword']) ? $_POST['keyword'] : '';
			$timeCardsList = $this->hr->getTimeCards($params);
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
				//$nestedData[] = $timeCard['total_hours'];
                $status = '<span class="badge-new badge-new-info">Pending</span>';
                if (ucfirst(!empty($timeCard['approved_by_user_id']) || !empty($timeCard['approved_by_admin_user_id']))) {
                    if ($timeCard['status'] == 'approved') {
                        $status = '<span class="badge-new badge-new-success">Approved</span>';
                    } else {
                        $status = '<span class="badge-new badge-new-danger">Denied</span>';
                    }
                }
                $nestedData[] = $status;
                if (!empty($timeCard['approved_by_user_id'])) {
                    $nestedData[] = $timeCard['branch_manager_first_name']." ".$timeCard['branch_manager_last_name'];
                } else if (!empty($timeCard['approved_by_admin_user_id'])) {
                    $nestedData[] = $timeCard['user_name'];
                } else {
                    $nestedData[] = ''  ;
                }
                if ($userdata['user_type_id'] == 1) {
                    $nestedData[] = !empty($timeCard['approved_date']) ? date("m/d/Y", strtotime($timeCard['approved_date'])) : '';
                }
                $timeCardId = $timeCard['id'];
                if ($userdata['user_type_id'] == 2) {
                    if($userdata['id'] != $timeCard['user_id']) {
                        if (!empty($timeCard['approved_by_user_id']) || !empty($timeCard['approved_by_admin_user_id'])) {
                            if ($timeCard['status'] == 'approved') {
                                $nestedData[] = "<div class='smart-forms'>
                                        <form onclick='return approve_deny_popup(0, $timeCardId);' action='' method='POST'>
                                            <button style='height:29px;background-color: #e74a3b;color: white;' class='button' type='submit'>Deny</button>
                                        </form>
                                    </div>";
                            } else {
                                $nestedData[] = "<div class='smart-forms'>
                                        <form onclick='return approve_deny_popup(1, $timeCardId);' action='' method='POST'>
                                            <button style='height:29px;' class='button btn-primary' type='submit'>Approve</button>
                                        </form>
                                    </div>";
                            }
                        } else {
                            $nestedData[] = "<div style='display:inline-flex;' class='smart-forms'>
                                    <form onclick='return approve_deny_popup(1, $timeCardId);' action='' method='POST'>
                                        <button style='height:29px;' class='button btn-primary' type='submit'>Approve</button>
                                    </form>
                                    <form style='margin-left:5px;' onclick='return approve_deny_popup(0, $timeCardId);' action='' method='POST'>
                                        <button style='height:29px;background-color: #e74a3b;color: white;' class='button' type='submit'>Deny</button>
                                    </form>
                                </div>";
                        }
                    } else {
                        $nestedData[] = '';
                    }
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

    public function saveTimeCards()
    {
        $userdata = $this->session->userdata('hr_user');
        $errors = array();
        $success = array();
        $ids = array();
        $exception_dates = $this->input->post('exception_date');
        $reg_hours = $this->input->post('reg_hours');
        $ot_hours = $this->input->post('ot_hours');
        $double_ot = $this->input->post('double_ot');
        $total_hours = $this->input->post('total_hours');
        $comment = $this->input->post('comment');
        $i = 0;

        foreach($exception_dates as $exception_date) {
            $timeCardsData = array(
                'user_id' => $userdata['id'],
                'exception_date' => date("Y-m-d", strtotime($exception_date)),
                'reg_hours' => $reg_hours[$i],
                'ot_hours' => $ot_hours[$i],
                'double_ot' => $double_ot[$i],
                'total_hours' => $total_hours[$i],
                'comment' => $comment[$i]
            );
            $ids[] = $this->hr->insert($timeCardsData, 'pct_hr_time_cards');
            $i++;
        }
        if(!empty($ids)) {
            $success[] = "Time Cards saved successfully.";
        } else {
            $errors[] = "Something went wrong. Please try again.";
        }
        
        $data = array(
            "errors" =>  $errors,
            "success" => $success
        );
        $this->session->set_userdata($data);
        redirect(base_url().'hr/time-cards');
    }

}