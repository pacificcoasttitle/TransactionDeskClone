<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Cpl extends MX_Controller {

	public function __construct()
    {
        parent::__construct();
        $this->load->helper(
            array('file', 'url','form')
        );
        $this->load->library('form_validation');
        $this->load->library('order/common');

        $this->common->is_admin();
    }

    public function northAmericanBranches()
	{
		$data = array();
        $data['title'] = 'North American Branches';
        $this->load->library('order/natic');
        $data['branchesData'] = $this->natic->getBranches();
        $this->load->view('order/layout/header', $data);
        $this->load->view('order/cpl/north_american_branches', $data);
        $this->load->view('order/layout/footer', $data);
	}

    public function getNorthAmericanBranches()
	{
        $this->load->library('order/natic');
        $branchesData = $this->natic->getBranchesFromApi();
        if(!empty($branchesData)) {
            $data = array('status' => 'success','msg' => '');
        } else {
            $data = array('status' => 'error','msg' => 'Somethine went wrong.Please try again.');
        }
        echo json_encode($data);
	}
}