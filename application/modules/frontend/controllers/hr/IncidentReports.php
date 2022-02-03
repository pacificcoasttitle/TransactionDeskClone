<?php

(defined('BASEPATH')) OR exit('No direct script access allowed');

class IncidentReports extends MX_Controller 
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
        $data['employee_info'] = $this->hr->get_hr_user(array('id' => $userdata['id']));
        if ($this->session->userdata('errors')) {
            $data['errors'] = $this->session->userdata('errors');
            $this->session->unset_userdata('errors');
        }
        if ($this->session->userdata('success')) {
            $data['success'] = $this->session->userdata('success');
            $this->session->unset_userdata('success');
        }
        $data['name'] = $userdata['name'];
		$data['title'] = 'HR-Center Incident Reports';
        $this->template->show("hr", "incident_reports", $data);
	}

    public function  getIncidentReports()
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
			$incidentReportsList = $this->hr->getIncidentReports($params);
			$json_data['draw'] = intval( $params['draw'] );
		} else {
			$params['searchvalue'] = isset($_POST['keyword']) && !empty($_POST['keyword']) ? $_POST['keyword'] : '';
			$incidentReportsList = $this->hr->getIncidentReports($params);
		}
		
		if (isset($incidentReportsList['data']) && !empty($incidentReportsList['data'])) {
			$i = $params['start'] + 1;
			foreach ($incidentReportsList['data'] as $incidentReport)  {
				$nestedData = array();
				$nestedData[] = $i;
                //$nestedData[] = $incidentReport['employee_number'];
                $nestedData[] =  date("m/d/Y", strtotime($incidentReport['incident_date']));
				$nestedData[] = $incidentReport['first_name']." ".$incidentReport['last_name'];
                $nestedData[] = $incidentReport['incident_reason'];
                $nestedData[] = $incidentReport['num_of_incidents'];
                $nestedData[] = $incidentReport['actions'];
                $nestedData[] = ucfirst(!empty($incidentReport['approved_by_user_id']) || !empty($incidentReport['approved_by_admin_user_id']) ? $incidentReport['status'] : 'Pending');
                if (!empty($incidentReport['approved_by_user_id'])) {
                    $nestedData[] = $incidentReport['branch_manager_first_name']." ".$incidentReport['branch_manager_last_name'];
                } else if (!empty($incidentReport['approved_by_admin_user_id'])) {
                    $nestedData[] = $incidentReport['user_name'];
                } else {
                    $nestedData[] = ''  ;
                }
                $incidentReportId = $incidentReport['id'];
                if ($userdata['user_type_id'] == 2) {
                    if($userdata['id'] != $incidentReport['user_id']) {
                        if (!empty($incidentReport['approved_by_user_id']) || !empty($incidentReport['approved_by_admin_user_id'])) {
                            if ($incidentReport['status'] == 'approved') {
                                $nestedData[] = "<div style='display:flex;' class='smart-forms'>
                                        <form style='margin-left:10px;' onclick='return approve_deny_popup(0, $incidentReportId);' action='' method='POST'>
                                            <button style='height:35px;background-color: #e74a3b;color: white;' class='button' type='submit'>Deny</button>
                                        </form>
                                    </div>";
                            } else {
                                $nestedData[] = "<div style='display:flex;' class='smart-forms'>
                                        <form onclick='return approve_deny_popup(1, $incidentReportId);' action='' method='POST'>
                                            <button style='height:35px;' class='button btn-primary' type='submit'>Approve</button>
                                        </form>
                                    </div>";
                            }
                        } else {
                            $nestedData[] = "<div style='display:flex;' class='smart-forms'>
                                    <form onclick='return approve_deny_popup(1, $incidentReportId);' action='' method='POST'>
                                        <button style='height:35px;' class='button btn-primary' type='submit'>Approve</button>
                                    </form>
                                    <form style='margin-left:10px;' onclick='return approve_deny_popup(0, $incidentReportId);' action='' method='POST'>
                                        <button style='height:35px;background-color: #e74a3b;color: white;' class='button' type='submit'>Deny</button>
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

		$json_data['recordsTotal'] = intval( $incidentReportsList['recordsTotal'] );
		$json_data['recordsFiltered'] = intval( $incidentReportsList['recordsFiltered'] );
		$json_data['data'] = $data;
		echo json_encode($json_data);
    }

    public function saveIncidentReports()
    {
        $userdata = $this->session->userdata('hr_user');
        $errors = array();
        $success = array();
       
        $timeCardsData = array(
            'user_id' => $userdata['id'],
            'incident_date' => date("Y-m-d", strtotime($this->input->post('incident_date'))),
            'employee_number' => $this->input->post('employee_number'),
            'incident_reason' => $this->input->post('incident_reason'),
            'incident_detail' => $this->input->post('incident_detail'),
            'actions' => implode(",", $this->input->post('actions')),
            'num_of_incidents' => implode(",", $this->input->post('num_of_incidents'))
        );
        $id = $this->hr->insert($timeCardsData, 'pct_hr_incident_reports');
            
        if(!empty($id)) {
            $success[] = "Incident Report saved successfully.";
        } else {
            $errors[] = "Something went wrong. Please try again.";
        }
        
        $data = array(
            "errors" =>  $errors,
            "success" => $success
        );
        $this->session->set_userdata($data);
        redirect(base_url().'hr/incident-reports');
    }

}