<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class CommissionRange extends MX_Controller {

	private $underwriter_type = [
		'westcor'=>'Westcor',
		'natic'=>'Natic',
		'commonwealth'=>'Commonwealth'
	];

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
		$this->load->model('order/underwriter_tier_model');
        $this->common->is_admin();
    }

    public function index()
    {
        $data = array();
        
        $data['title'] = 'PCT Order: Commission Range.';

		$data['commission_details'] = $this->commission_range_model->with('underwriter_tier_obj')->get_all();
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

        if ($this->input->post()) {
            
            
            $this->form_validation->set_rules('product_type', 'Product Type', 'trim|required');
            $this->form_validation->set_rules('underwriter_tier', 'Underwriter Tier', 'trim|required');
            $this->form_validation->set_rules('total_commission', 'Total commission %', 'trim|required|numeric');
            $this->form_validation->set_rules('revenue_range_min', 'Minimum Revenue Range', 'trim|required|numeric');
            $this->form_validation->set_rules('revenue_range_max', 'Maximum Revenue Range', 'trim|required|numeric');
              
           
            if ($this->form_validation->run() == true) {
                
                    $commissionData = array(
						'product_type' =>$this->input->post('product_type') ,
						'underwriter_tier' =>$this->input->post('underwriter_tier') ,
						'total_commission' => !empty($this->input->post('total_commission')) ? $this->input->post('total_commission') : 0,
						'min_revenue' => !empty($this->input->post('revenue_range_min')) ? $this->input->post('revenue_range_min') : 0,
						'max_revenue' => !empty($this->input->post('revenue_range_max')) ? $this->input->post('revenue_range_max') : 0,
						'additional_threshold' => !empty($this->input->post('additional_threshold')) ? $this->input->post('additional_threshold') : 0,
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

		$data['underwriter_tiers'] = $this->underwriter_tier_model->order_by('underwriter')->get_all();
		
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
            $this->form_validation->set_rules('underwriter_tier', 'Underwriter Tier', 'trim|required');
            $this->form_validation->set_rules('total_commission', 'Total commission %', 'trim|required|numeric');
            $this->form_validation->set_rules('revenue_range_min', 'Minimum Revenue Range', 'trim|required|numeric');
            $this->form_validation->set_rules('revenue_range_max', 'Maximum Revenue Range', 'trim|required|numeric');
				  
			   
				if ($this->form_validation->run() == true) {
					
						$commissionData = array(
							'product_type' =>$this->input->post('product_type') ,
							'underwriter_tier' =>$this->input->post('underwriter_tier') ,
							'total_commission' => !empty($this->input->post('total_commission')) ? $this->input->post('total_commission') : 0,
							'min_revenue' => !empty($this->input->post('revenue_range_min')) ? $this->input->post('revenue_range_min') : 0,
							'max_revenue' => !empty($this->input->post('revenue_range_max')) ? $this->input->post('revenue_range_max') : 0,
							'additional_threshold' => !empty($this->input->post('additional_threshold')) ? $this->input->post('additional_threshold') : 0,
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
		$data['underwriter_tiers'] = $this->underwriter_tier_model->order_by('underwriter')->get_all();
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

	public function index_underwriter_tier()
    {
        $data = array();
        
        $data['title'] = 'PCT Order: Underwriter Tier.';

		$data['underwriter_tier_details'] = $this->underwriter_tier_model->get_all();
		$data['success_msg'] = $this->session->flashdata('success');
		$data['error_msg'] = $this->session->flashdata('error');

        $this->load->view('order/layout/header', $data);
        $this->load->view('order/sales/underwriter_tiers', $data);
        $this->load->view('order/layout/footer', $data);
    }

	public function add_underwriter_tier()
    {

        $data = array();
        $data['title'] = 'PCT Order: Add Underwriter Tier';

        if ($this->input->post()) {
            
            $this->form_validation->set_rules('underwriter_type', 'Underwriter', 'trim|required');
            $this->form_validation->set_rules('title', 'Tier Title', 'trim|required');
              
           
            if ($this->form_validation->run() == true) {
                
                    $underwriterData = array(
						'underwriter' =>$this->input->post('underwriter_type') ,
						'title' =>$this->input->post('title') ,
						'description' =>!empty($this->input->post('description'))?$this->input->post('description'):null ,
                    );
					
                    $insert = $this->underwriter_tier_model->insert($underwriterData);
                    
                    if ($insert) {
                        $flash_data['success'] = 'Underwriter Tier added successfully.';
                    } else {
                        $flash_data['error'] = 'Underwriter Tier not added.';
                    }
					
					$this->session->set_flashdata($flash_data);
					redirect(base_url('order/admin/underwriter-tier'));
                
                
            }                                       
        }
		$data['underwriter_types'] = $this->underwriter_type;
		$data['success_msg'] = $this->session->flashdata('success');
		$data['error_msg'] = $this->session->flashdata('error');
        $this->load->view('order/layout/header', $data);
        $this->load->view('order/sales/add_underwriter_tier', $data);
        $this->load->view('order/layout/footer', $data);
    }
    
    public function edit_underwriter_tier($id)
    {
        $data = array();
        $data['title'] = 'PCT Order: Edit Underwriter Tier';
        
		$record = $this->underwriter_tier_model->get($id);
        
        if (!empty($record)) {
			if ($this->input->post()) {
            
				$this->form_validation->set_rules('underwriter_type', 'Underwriter', 'trim|required');
            	$this->form_validation->set_rules('title', 'Tier Title', 'trim|required');  
			   
				if ($this->form_validation->run() == true) {
					
						$underwriterData = array(
							'underwriter' =>$this->input->post('underwriter_type') ,
							'title' =>$this->input->post('title') ,
							'description' =>!empty($this->input->post('description'))?$this->input->post('description'):null ,
						);
						
						$update = $this->underwriter_tier_model->update($id,$underwriterData);
						
						if ($update) {
							$flash_data['success'] = 'Underwriter Tier updated successfully.';
						} else {
							$flash_data['error'] = 'Underwriter Tier not updated.';
						}
						
						$this->session->set_flashdata($flash_data);
						redirect(base_url('order/admin/edit-underwriter-tier/'.$id));
				}                                       
			}

        } else {
            redirect('order/admin/underwriter-tier');
        }
		$data['underwriter_types'] = $this->underwriter_type;
		$data['success_msg'] = $this->session->flashdata('success');
		$data['error_msg'] = $this->session->flashdata('error');
        $data['record'] = $record;
        $this->load->view('order/layout/header', $data);
        $this->load->view('order/sales/edit_underwriter_tier', $data);
        $this->load->view('order/layout/footer', $data);
    }

    public function delete_underwriter_tier($id)
    {
		$status = false;
		if($this->input->post('action') == 'delete') {
			$delete_status = $this->underwriter_tier_model->delete($id);
			if ($delete_status) {
				$flash_data['success'] = 'Underwriter Tier deleted successfully.';
				$status = true;
			} else {
				$flash_data['error'] = 'Underwriter Tier not deleted.';
			}
			
			$this->session->set_flashdata($flash_data);

		}
		echo json_encode(['status'=>$status]);
    }

	

}
