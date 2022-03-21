<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends MX_Controller {

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

    private $dashboard_js_version = '01';
	public function __construct()
    {
        parent::__construct();
        $this->load->helper(
            array('file', 'url','form')
        );
        $this->load->library('form_validation');
        $this->load->library('hr/adminTemplate');
        $this->load->library('hr/common');
        $this->load->model('hr/timecards_model');
        $this->load->model('hr/vacation_request_model');
        $this->load->model('hr/report_incident_model');
        $this->load->model('hr/training_status_model');
        $this->common->is_hr_admin();
    }

    public function index()
    {
        $data['title'] = 'HR-Center Admin Dashboard';
        $data['page_title'] = 'Dashboard';
        $data['pending_timecard_count'] = $this->timecards_model->count_by('approved_date', null);
        $data['pending_vacation_request_count'] = $this->vacation_request_model->count_by('approved_date', null);
        $data['pending_report_incident_count'] = $this->report_incident_model->count_by('approved_date', null);
        $data['pending_training_count'] = $this->training_status_model->count_by('is_complete', 0);
        $this->admintemplate->addCSS( base_url('assets/libs/calendar/main.css'));
        $this->admintemplate->addJS( base_url('assets/libs/calendar/main.js'));
        $this->admintemplate->addJS( base_url('assets/backend/hr/js/dashboard.js?v=dashboard_'.$this->dashboard_js_version) );
        $this->admintemplate->show("hr", "dashboard", $data);
    }

    public function getVacationDataForCalendar()
    {
        $start = date('Y-m-d', strtotime($this->input->post('start')));
        $end = date('Y-m-d', strtotime($this->input->post('end')));
        $vacationData = $this->common->getVacationDataForCalendar($start, $end);
        $data = array();
        $i = 0;
        foreach ($vacationData as $vacation) {
            $data[$i]['id'] = $vacation['id'];
            $data[$i]['title'] = $vacation['first_name']." ".$vacation['last_name'];
            $data[$i]['start'] = $vacation['from_date'];
            $data[$i]['end'] = date('Y-m-d', strtotime($vacation['to_date'] . ' +1 day'));
            $i++;
        }
        $i++;
        echo json_encode($data); 
    }

    public function logout()
    {
        $this->session->unset_userdata('hr_admin');
        redirect(base_url().'hr/admin');
    }
}
