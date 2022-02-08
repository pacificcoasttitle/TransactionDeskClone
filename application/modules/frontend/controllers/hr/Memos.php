<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Memos extends MX_Controller {

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
		$data['title'] = 'HR-Center Memos';
        $this->template->show("hr", "memos", $data);
    }

    public function getMemos()
    {
        $params = array();
        if (isset($_POST['draw']) && !empty($_POST['draw'])) {
            $params['draw'] = isset($_POST['draw']) && !empty($_POST['draw']) ? $_POST['draw'] : 10;
            $params['length'] = isset($_POST['length']) && !empty($_POST['length']) ? $_POST['length'] : 10;
            $params['start'] = isset($_POST['start']) && !empty($_POST['start']) ? $_POST['start'] : 0;
            $params['orderColumn'] = isset($_POST['order'][0]['column']) && !empty($_POST['order'][0]['column']) ? $_POST['order'][0]['column'] : 0;
            $params['orderDir'] = isset($_POST['order'][0]['dir']) && !empty($_POST['order'][0]['dir']) ? $_POST['order'][0]['dir'] : 0;
            $params['searchvalue'] = isset($_POST['search']['value']) && !empty($_POST['search']['value']) ? $_POST['search']['value'] : '';
            $memos = $this->hr->getMemos($params);
            $json_data['draw'] = intval( $params['draw'] );
        } else {
            $params['searchvalue'] = isset($_POST['keyword']) && !empty($_POST['keyword']) ? $_POST['keyword'] : '';
            $memos = $this->hr->getMemos($params);            
        }

        $data = array(); 
        $count = $params['start'] + 1;
	    if (isset($memos['data']) && !empty($memos['data'])) {
	    	foreach ($memos['data'] as $key => $value)  {
	    		$nestedData=array();
                $nestedData[] = $count;
	            $nestedData[] = $value['subject'];
                $nestedData[] = $value['user_name'];
                $nestedData[] = date("m/d/Y", strtotime($value['created_at'])); 
                $nestedData[] = "<div class=''>
                        <button class='btn btn-grad-2a generate button-color' type='submit'>View</button>
					</div>";
	            $data[] = $nestedData;    
                $count++;          
	    	}
	    }
        $json_data['recordsTotal'] = intval( $memos['recordsTotal'] );
        $json_data['recordsFiltered'] = intval( $memos['recordsFiltered'] );
        $json_data['data'] = $data;
	    echo json_encode($json_data);
    }
}
