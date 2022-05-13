<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class CommissionRange extends MX_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->helper(
            array('file', 'url','form')
        );
        $this->load->library('form_validation');
        $this->load->library('order/order');
        $this->load->model('order/sales_model');
        $this->load->library('order/common');
		$this->load->model('order/commission_range_model');
        $this->common->is_admin();
    }

    public function index()
    {
        $data = array();
        
        $data['title'] = 'PCT Order: Commission Range.';

		$data['commission_details'] = $this->commission_range_model->get_all();
		$data['success_msg'] = $this->session->flashdata('success');
		$data['error_msg'] = $this->session->flashdata('error');

        $this->load->view('order/layout/header', $data);
        $this->load->view('order/sales/commission_range', $data);
        $this->load->view('order/layout/footer', $data);
    }

	

	public function add_commission_range()
    {
        $data = array();
        $data['title'] = 'PCT Order: Add Commission Range';
        $salesRepData = array();

        if ($this->input->post()) {
            
            
            $this->form_validation->set_rules('product_type', 'Product Type', 'trim|required');
            $this->form_validation->set_rules('underwriter_type', 'Underwriter', 'trim|required');
            $this->form_validation->set_rules('total_commission', 'Total commission %', 'trim|required|numeric');
            $this->form_validation->set_rules('revenue_range_min', 'Minimum Revenue Range', 'trim|required|numeric');
            $this->form_validation->set_rules('revenue_range_max', 'Maximum Revenue Range', 'trim|required|numeric');
              
           
            if ($this->form_validation->run() == true) {
                
                    $commissionData = array(
						'product_type' =>$this->input->post('product_type') ,
						'underwriter' =>$this->input->post('underwriter_type') ,
						'total_commission' => !empty($this->input->post('total_commission')) ? $this->input->post('total_commission') : 0,
						'min_revenue' => !empty($this->input->post('revenue_range_min')) ? $this->input->post('revenue_range_min') : 0,
						'max_revenue' => !empty($this->input->post('revenue_range_max')) ? $this->input->post('revenue_range_max') : 0,
                    );
					
                    $insert = $this->commission_range_model->insert($commissionData);
                    
                    if ($insert) {
                        $flash_data['success'] = 'Commission Range added successfully.';
                    } else {
                        $flash_data['error'] = 'Commission Range not added.';
                    }
					
					$this->session->set_flashdata($flash_data);
					redirect(base_url('order/admin/commission-range'));
                
                
            }                                       
        }
		$data['success_msg'] = $this->session->flashdata('success');
		$data['error_msg'] = $this->session->flashdata('error');
        $this->load->view('order/layout/header', $data);
        $this->load->view('order/sales/add_commission_range', $data);
        $this->load->view('order/layout/footer', $data);
    }
    
    public function edit_commission_range($id)
    {
        $data = array();
        $data['title'] = 'PCT Order: Edit Commission Range';
        
		$record = $this->commission_range_model->get($id);
        
        if (!empty($record)) {
			if ($this->input->post()) {
            
            
				$this->form_validation->set_rules('product_type', 'Product Type', 'trim|required');
				$this->form_validation->set_rules('underwriter_type', 'Underwriter', 'trim|required');
				$this->form_validation->set_rules('total_commission', 'Total commission %', 'trim|required|numeric');
				$this->form_validation->set_rules('revenue_range_min', 'Minimum Revenue Range', 'trim|required|numeric');
				$this->form_validation->set_rules('revenue_range_max', 'Maximum Revenue Range', 'trim|required|numeric');
				  
			   
				if ($this->form_validation->run() == true) {
					
						$commissionData = array(
							'product_type' =>$this->input->post('product_type') ,
							'underwriter' =>$this->input->post('underwriter_type') ,
							'total_commission' => !empty($this->input->post('total_commission')) ? $this->input->post('total_commission') : 0,
							'min_revenue' => !empty($this->input->post('revenue_range_min')) ? $this->input->post('revenue_range_min') : 0,
							'max_revenue' => !empty($this->input->post('revenue_range_max')) ? $this->input->post('revenue_range_max') : 0,
						);
						
						$update = $this->commission_range_model->update($id,$commissionData);
						
						if ($update) {
							$flash_data['success'] = 'Commission Range updated successfully.';
						} else {
							$flash_data['error'] = 'Commission Range not updated.';
						}
						
						$this->session->set_flashdata($flash_data);
						redirect(base_url('order/admin/edit-commission-range/'.$id));
					
					
				}                                       
			}

        } else {
            redirect('order/admin/commission-range');
        }
		$data['success_msg'] = $this->session->flashdata('success');
		$data['error_msg'] = $this->session->flashdata('error');
        $data['record'] = $record;
        $this->load->view('order/layout/header', $data);
        $this->load->view('order/sales/edit_commission_range', $data);
        $this->load->view('order/layout/footer', $data);
    }

    public function delete_commission_range($id)
    {
		$status = false;
		if($this->input->post('action') == 'delete') {
			$delete_status = $this->commission_range_model->delete($id);
			if ($delete_status) {
				$flash_data['success'] = 'Commission Range deleted successfully.';
				$status = true;
			} else {
				$flash_data['error'] = 'Commission Range not deleted.';
			}
			
			$this->session->set_flashdata($flash_data);

		}
		echo json_encode(['status'=>$status]);
    }

}
