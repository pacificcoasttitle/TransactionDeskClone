<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class Order 
{
    public static $CI;
    
	public function __construct($params = array())
	{
		$this->CI =& get_instance();                        
		$this->CI->load->database();
        $this->CI->load->library('email');
        $this->CI->load->library('session');
		self::$CI = $this->CI;
    }

    public function get_recent_orders()
    {
        $userdata = $this->CI->session->userdata('user');
        $this->CI->db->select('order_details.file_number, order_details.file_id, property_details.full_address,order_details.id, order_details.westcor_order_id, order_details.westcor_file_id, order_details.westcor_cpl_id, order_details.created_at, property_details.primary_owner,order_details.borrower_invited,order_details.resware_status')
            ->from('order_details')
            ->join('property_details', 'order_details.property_id = property_details.id');

        if ($userdata['is_master'] == 0) {
            $this->CI->db->group_start()
                    ->where('order_details.customer_id', $userdata['id'])
                    ->or_where('property_details.escrow_lender_id', $userdata['id'])
                    ->group_end();
        }
        $this->CI->db->order_by("order_details.created_at", "desc");
        $this->CI->db->limit(10);
        $query = $this->CI->db->get();

        if ($query->num_rows() > 0)  {
            return $query->result_array();
        } else {
            return array();
        } 
    }

    public function get_orders($params)
    {
        $userdata = $this->CI->session->userdata('user');
        $status = isset($params['status']) && !empty($params['status']) ? $params['status'] : '';
        $month = isset($params['month']) && !empty($params['month']) ? $params['month'] : '';
        $salesFlag = isset($params['salesFlag']) && !empty($params['salesFlag']) ? $params['salesFlag'] : '';
        $salesUser = isset($params['salesUser']) && !empty($params['salesUser']) ? $params['salesUser'] : '';
        $is_pay_off = isset($params['is_pay_off']) && !empty($params['is_pay_off']) ? $params['is_pay_off'] : '';
        $yearFlag = isset($params['yearFlag']) && !empty($params['yearFlag']) ? $params['yearFlag'] : '';
        $dashboard_order_by = isset($params['dashboard_order_by']) && !empty($params['dashboard_order_by']) ? $params['dashboard_order_by'] : '';
        $result = $this->getUserFromPartners();
        $select = 'order_details.prelim_summary_id, order_details.created_at as opened_date, order_details.file_number, order_details.file_id,property_details.full_address,order_details.id, order_details.westcor_order_id, order_details.westcor_file_id, order_details.westcor_cpl_id, property_details.escrow_lender_id, order_details.is_regenerate_cpl, order_details.cpl_document_name,
            order_details.created_at, order_details.resware_status, order_details.proposed_insured_document_name, order_details.is_payoff_generated, pct_order_prelim_summary.is_updated, pct_order_documents.created as document_created_date, p.created as proposed_document_created_date,  property_details.primary_owner';

        if(isset($params['searchvalue']) && !empty($params['searchvalue'])) {
            $keyword = $params['searchvalue'];

            if (isset($keyword) && !empty($keyword) && $salesFlag == 1) {
                $this->CI->db->like('property_details.full_address', $keyword);            
                $this->CI->db->or_like('order_details.file_number', $keyword); 
                $this->CI->db->or_like('order_details.created_at', date("Y-m-d", strtotime($keyword))); 
                $this->CI->db->or_like('order_details.resware_status', $keyword); 
            } else {
                $this->CI->db->like('property_details.full_address', $keyword);            
                $this->CI->db->or_like('order_details.file_number', $keyword);
            }

            if(isset($status) && !empty($status))
            {
                if ($status == 'open') {
                    $this->CI->db->where('((order_details.resware_status != "closed" and  order_details.resware_status != "cancelled") OR order_details.resware_status IS NULL)');
                } else {
                    $this->CI->db->where('order_details.resware_status', $status); 
                }
            }

            if(isset($month) && !empty($month)) {
                if ($status == 'open') {
                    $this->CI->db->where('MONTH(order_details.created_at)', $month);
                    $this->CI->db->where('YEAR(order_details.created_at)', date('Y'));  
                } else {
                    $this->CI->db->where('MONTH(order_details.resware_closed_status_date)', $month); 
                    $this->CI->db->where('YEAR(order_details.resware_closed_status_date)', date('Y')); 
                } 
            }

            if (isset($yearFlag) && !empty($yearFlag)) {
                $this->CI->db->where('YEAR(order_details.created_at)', date('Y'));  
            }

            if (isset($is_pay_off) && !empty($is_pay_off)) {        
                $select .= ', customer_basic_details.first_name, customer_basic_details.last_name';
            }

            if ($userdata['is_sales_rep_manager'] == 1) {
                $select .= ', sales_users.first_name as sales_first_name, sales_users.last_name as sales_last_name';
            }

            $this->CI->db->select($select)
                ->from('order_details')
                ->join('property_details', 'order_details.property_id = property_details.id')
                ->join('pct_order_documents', 'pct_order_documents.document_name = order_details.cpl_document_name', 'left')
                ->join('pct_order_documents as p', 'p.document_name = order_details.proposed_insured_document_name', 'left')
                ->join('pct_order_prelim_summary', 'order_details.prelim_summary_id = pct_order_prelim_summary.id','left');

            if (isset($is_pay_off) && !empty($is_pay_off)) { 
                $this->CI->db->join('transaction_details','order_details.transaction_id = transaction_details.id'); 
                $this->CI->db->join('customer_basic_details','customer_basic_details.id = transaction_details.title_officer', 'left');
                $this->CI->db->where('order_details.is_payoff_order', 1);
            }
            
            if ($userdata['is_master'] == 0 && $userdata['is_sales_rep'] == 0 && $userdata['is_title_officer'] == 0 && $userdata['is_payoff_user'] == 0) {
                $this->CI->db->group_start()
                    ->where('order_details.customer_id', $userdata['id'])
                    ->or_where('property_details.escrow_lender_id', $userdata['id'])
                    ->group_end();
            }
            if ($userdata['is_master'] == 0 && $userdata['is_sales_rep'] == 1) {
                if ($userdata['is_sales_rep_manager'] == 1) {
                    $this->CI->db->join('transaction_details','order_details.transaction_id = transaction_details.id');
                    $this->CI->db->join('customer_basic_details as sales_users','sales_users.id = transaction_details.sales_representative', 'inner');
                    if ($salesUser != 'all') {
                        $this->CI->db->where('transaction_details.sales_representative', $salesUser);
                    } 
                } else {
                    $this->CI->db->join('transaction_details','order_details.transaction_id = transaction_details.id');
                    $this->CI->db->where('transaction_details.sales_representative', $userdata['id']);
                } 
            }

            if ($userdata['is_master'] == 0 && $userdata['is_title_officer'] == 1) {
                $this->CI->db->join('transaction_details','order_details.transaction_id = transaction_details.id');
                $this->CI->db->where('transaction_details.title_officer', $userdata['id']);
            }

            if ($userdata['is_master'] == 1 && !empty($userdata['partner_companies'])) {
                if(!empty($result)) {
                    $this->CI->db->group_start()
                        ->where_in('order_details.customer_id', explode(',', $result['ids']))
                        ->or_where_in('property_details.escrow_lender_id', explode(',', $result['ids']))
                        ->group_end();
                }
            }

            $total_records =  $this->CI->db->count_all_results();
            
            if (isset($keyword) && !empty($keyword) && $salesFlag == 1) {
                $this->CI->db->like('property_details.full_address', $keyword);            
                $this->CI->db->or_like('order_details.file_number', $keyword); 
                $this->CI->db->or_like('order_details.created_at', date("Y-m-d", strtotime($keyword))); 
                $this->CI->db->or_like('order_details.resware_status', $keyword); 
            } else {
                $this->CI->db->like('property_details.full_address', $keyword);            
                $this->CI->db->or_like('order_details.file_number', $keyword);
            }

            if(isset($status) && !empty($status))
            {
                if ($status == 'open') {
                    $this->CI->db->where('((order_details.resware_status != "closed" and  order_details.resware_status != "cancelled") OR order_details.resware_status IS NULL)');
                } else {
                    $this->CI->db->where('order_details.resware_status', $status); 
                }
            }

            if(isset($month) && !empty($month)) {
                if ($status == 'open') {
                    $this->CI->db->where('MONTH(order_details.created_at)', $month);
                    $this->CI->db->where('YEAR(order_details.created_at)', date('Y'));  
                } else {
                    $this->CI->db->where('MONTH(order_details.resware_closed_status_date)', $month); 
                    $this->CI->db->where('YEAR(order_details.resware_closed_status_date)', date('Y')); 
                } 
            }

            if (isset($yearFlag) && !empty($yearFlag)) {
                $this->CI->db->where('YEAR(order_details.created_at)', date('Y'));  
            }

            $limit = isset($params['length']) && !empty($params['length']) ? $params['length'] : '';
            $offset = isset($params['start']) && !empty($params['start']) ? $params['start'] : '';
            $orders_lists = array();

            $this->CI->db->select($select)
                ->from('order_details')
                ->join('property_details', 'order_details.property_id = property_details.id')
                ->join('pct_order_documents', 'pct_order_documents.document_name = order_details.cpl_document_name', 'left')
                ->join('pct_order_documents as p', 'p.document_name = order_details.proposed_insured_document_name', 'left')
                ->join('pct_order_prelim_summary', 'order_details.prelim_summary_id = pct_order_prelim_summary.id','left');
            
            if (isset($is_pay_off) && !empty($is_pay_off)) { 
                $this->CI->db->join('transaction_details','order_details.transaction_id = transaction_details.id'); 
                $this->CI->db->join('customer_basic_details','customer_basic_details.id = transaction_details.title_officer', 'left');
                $this->CI->db->where('order_details.is_payoff_order', 1);
            }

            if ($userdata['is_master'] == 0 && $userdata['is_sales_rep'] == 0 && $userdata['is_title_officer'] == 0 && $userdata['is_payoff_user'] == 0) {
                $this->CI->db->group_start()
                    ->where('order_details.customer_id', $userdata['id'])
                    ->or_where('property_details.escrow_lender_id', $userdata['id'])
                    ->group_end();
            }
            if ($userdata['is_master'] == 0 && $userdata['is_sales_rep'] == 1) {
                if ($userdata['is_sales_rep_manager'] == 1) {
                    $this->CI->db->join('transaction_details','order_details.transaction_id = transaction_details.id');
                    $this->CI->db->join('customer_basic_details as sales_users','sales_users.id = transaction_details.sales_representative', 'inner');
                    if ($salesUser != 'all') {
                        $this->CI->db->where('transaction_details.sales_representative', $salesUser);
                    } 
                } else {
                    $this->CI->db->join('transaction_details','order_details.transaction_id = transaction_details.id');
                    $this->CI->db->where('transaction_details.sales_representative', $userdata['id']);
                } 
            }
            if ($userdata['is_master'] == 0 && $userdata['is_title_officer'] == 1) {
                $this->CI->db->join('transaction_details','order_details.transaction_id = transaction_details.id');
                $this->CI->db->where('transaction_details.title_officer', $userdata['id']);
            }
            if ($userdata['is_master'] == 1 && !empty($userdata['partner_companies'])) {
                if(!empty($result)) {
                    $this->CI->db->group_start()
                        ->where_in('order_details.customer_id', explode(',', $result['ids']))
                        ->or_where_in('property_details.escrow_lender_id', explode(',', $result['ids']))
                        ->group_end();
                }
            }

            if (!empty($dashboard_order_by)) {
                $this->CI->db->order_by('FIELD(order_details.resware_status, "closed") desc');
                $this->CI->db->order_by("order_details.id", "desc");
            } else {
                $this->CI->db->order_by("order_details.id", "desc");
            }
                       
            if ((isset($limit) && !empty($limit)) || (isset($offset) && !empty($offset))) {
                $this->CI->db->limit($limit, $offset);
            }

            $query = $this->CI->db->get();
            if ($query->num_rows() > 0)  {
                $orders_lists = $query->result_array();
            }
        }
        else
        {
            if(isset($status) && !empty($status))
            {
                if ($status == 'open') {
                    $this->CI->db->where('((order_details.resware_status != "closed" and  order_details.resware_status != "cancelled") OR order_details.resware_status IS NULL)');
                } else {
                    $this->CI->db->where('order_details.resware_status', $status); 
                }
            }

            if(isset($month) && !empty($month)) {
                if ($status == 'open') {
                    $this->CI->db->where('MONTH(order_details.created_at)', $month);
                    $this->CI->db->where('YEAR(order_details.created_at)', date('Y'));  
                } else {
                    $this->CI->db->where('MONTH(order_details.resware_closed_status_date)', $month); 
                    $this->CI->db->where('YEAR(order_details.resware_closed_status_date)', date('Y')); 
                } 
            }

            if (isset($yearFlag) && !empty($yearFlag)) {
                $this->CI->db->where('YEAR(order_details.created_at)', date('Y'));  
            }

            if (isset($is_pay_off) && !empty($is_pay_off)) {        
                $select .= ', customer_basic_details.first_name, customer_basic_details.last_name';
            }

            if ($userdata['is_sales_rep_manager'] == 1) {
                $select .= ', sales_users.first_name as sales_first_name, sales_users.last_name as sales_last_name';
            }

            $this->CI->db->select($select)
                ->from('order_details')
                ->join('property_details', 'order_details.property_id = property_details.id')
                ->join('pct_order_documents', 'pct_order_documents.document_name = order_details.cpl_document_name', 'left')
                ->join('pct_order_documents as p', 'p.document_name = order_details.proposed_insured_document_name', 'left')
                ->join('pct_order_prelim_summary', 'order_details.prelim_summary_id = pct_order_prelim_summary.id','left');
            
            if (isset($is_pay_off) && !empty($is_pay_off)) { 
                $this->CI->db->join('transaction_details','order_details.transaction_id = transaction_details.id'); 
                $this->CI->db->join('customer_basic_details','customer_basic_details.id = transaction_details.title_officer', 'left');
                $this->CI->db->where('order_details.is_payoff_order', 1);
            }

            if ($userdata['is_master'] == 0 && $userdata['is_sales_rep'] == 0 && $userdata['is_title_officer'] == 0 && $userdata['is_payoff_user'] == 0) {
                $this->CI->db->group_start()
                    ->where('order_details.customer_id', $userdata['id'])
                    ->or_where('property_details.escrow_lender_id', $userdata['id'])
                    ->group_end();
            }
            if ($userdata['is_master'] == 0 && $userdata['is_sales_rep'] == 1) {
                if ($userdata['is_sales_rep_manager'] == 1) {
                    $this->CI->db->join('transaction_details','order_details.transaction_id = transaction_details.id');
                    $this->CI->db->join('customer_basic_details as sales_users','sales_users.id = transaction_details.sales_representative', 'inner');
                    if ($salesUser != 'all') {
                        $this->CI->db->where('transaction_details.sales_representative', $salesUser);
                    } 
                } else {
                    $this->CI->db->join('transaction_details','order_details.transaction_id = transaction_details.id');
                    $this->CI->db->where('transaction_details.sales_representative', $userdata['id']);
                } 
            }
            if ($userdata['is_master'] == 0 && $userdata['is_title_officer'] == 1) {
                $this->CI->db->join('transaction_details','order_details.transaction_id = transaction_details.id');
                $this->CI->db->where('transaction_details.title_officer', $userdata['id']);
            }
            if ($userdata['is_master'] == 1 && !empty($userdata['partner_companies'])) {
                if(!empty($result)) {
                    $this->CI->db->group_start()
                        ->where_in('order_details.customer_id', explode(',', $result['ids']))
                        ->or_where_in('property_details.escrow_lender_id', explode(',', $result['ids']))
                        ->group_end();
                }
            }

            /*if ($userdata['is_master'] == 0) {
                $this->CI->db->where('order_details.customer_id', $userdata['id']);
            }*/
       
            $total_records =  $this->CI->db->count_all_results();

            $limit = isset($params['length']) && !empty($params['length']) ? $params['length'] : '';
            $offset = isset($params['start']) && !empty($params['start']) ? $params['start'] : '';
            $orders_lists = array();

            if(isset($status) && !empty($status))
            {
                if ($status == 'open') {
                    $this->CI->db->where('((order_details.resware_status != "closed" and  order_details.resware_status != "cancelled") OR order_details.resware_status IS NULL)');
                } else {
                    $this->CI->db->where('order_details.resware_status', $status); 
                }
            }

            if(isset($month) && !empty($month)) {
                if ($status == 'open') {
                    $this->CI->db->where('MONTH(order_details.created_at)', $month);
                    $this->CI->db->where('YEAR(order_details.created_at)', date('Y'));  
                } else {
                    $this->CI->db->where('MONTH(order_details.resware_closed_status_date)', $month); 
                    $this->CI->db->where('YEAR(order_details.resware_closed_status_date)', date('Y')); 
                } 
            }

            if (isset($yearFlag) && !empty($yearFlag)) {
                $this->CI->db->where('YEAR(order_details.created_at)', date('Y'));  
            }

            $this->CI->db->select($select)
                ->from('order_details')
                ->join('property_details', 'order_details.property_id = property_details.id')
                ->join('pct_order_documents', 'pct_order_documents.document_name = order_details.cpl_document_name', 'left')
                ->join('pct_order_documents as p', 'p.document_name = order_details.proposed_insured_document_name', 'left')
                ->join('pct_order_prelim_summary', 'order_details.prelim_summary_id = pct_order_prelim_summary.id','left');
            
            if (isset($is_pay_off) && !empty($is_pay_off)) { 
                $this->CI->db->join('transaction_details','order_details.transaction_id = transaction_details.id'); 
                $this->CI->db->join('customer_basic_details','customer_basic_details.id = transaction_details.title_officer', 'left');
                $this->CI->db->where('order_details.is_payoff_order', 1);
            }

            if ($userdata['is_master'] == 0 && $userdata['is_sales_rep'] == 0 && $userdata['is_title_officer'] == 0 && $userdata['is_payoff_user'] == 0) {
                $this->CI->db->group_start()
                    ->where('order_details.customer_id', $userdata['id'])
                    ->or_where('property_details.escrow_lender_id', $userdata['id'])
                    ->group_end();
            }
            if ($userdata['is_master'] == 0 && $userdata['is_sales_rep'] == 1) {
                if ($userdata['is_sales_rep_manager'] == 1) {
                    $this->CI->db->join('transaction_details','order_details.transaction_id = transaction_details.id');
                    $this->CI->db->join('customer_basic_details as sales_users','sales_users.id = transaction_details.sales_representative', 'inner');
                    if ($salesUser != 'all') {
                        $this->CI->db->where('transaction_details.sales_representative', $salesUser);
                    } 
                } else {
                    $this->CI->db->join('transaction_details','order_details.transaction_id = transaction_details.id');
                    $this->CI->db->where('transaction_details.sales_representative', $userdata['id']);
                } 
            }
            if ($userdata['is_master'] == 0 && $userdata['is_title_officer'] == 1) {
                $this->CI->db->join('transaction_details','order_details.transaction_id = transaction_details.id');
                $this->CI->db->where('transaction_details.title_officer', $userdata['id']);
            }
            if ($userdata['is_master'] == 1 && !empty($userdata['partner_companies'])) {
                if(!empty($result)) {
                    $this->CI->db->group_start()
                        ->where_in('order_details.customer_id', explode(',', $result['ids']))
                        ->or_where_in('property_details.escrow_lender_id', explode(',', $result['ids']))
                        ->group_end();
                }
            }

            if (!empty($dashboard_order_by)) {
                $this->CI->db->order_by('FIELD(order_details.resware_status, "closed") desc');
                $this->CI->db->order_by("order_details.id", "desc");
            } else {
                $this->CI->db->order_by("order_details.id", "desc");
            }

            if ((isset($limit) && !empty($limit)) || (isset($offset) && !empty($offset))) {
                $this->CI->db->limit($limit, $offset);
            }

            $query = $this->CI->db->get();
            if ($query->num_rows() > 0)  {
                $orders_lists = $query->result_array();
            } 
        }
        
    	return array(
            'recordsTotal' => $total_records,
            'recordsFiltered' => $total_records,
            'data' => $orders_lists
        );
    }

    public function get_document_types() 
    {
        $this->CI->db->select('*');
        $this->CI->db->from('pct_order_documents_types');
        $query = $this->CI->db->get();
        return $rs = $query->result_array();
    }

    public function getUserFromPartners() 
    {
        $userdata = $this->CI->session->userdata('user');
        $this->CI->db->select('GROUP_CONCAT(id) as ids');
        $this->CI->db->from('customer_basic_details');
        $this->CI->db->where_in('partner_id', explode(',', $userdata['partner_companies']));
        $query = $this->CI->db->get();
        $result = $query->row_array();
        return $result;
    }

    public function get_order_details($fileId, $from_mail=0)
    {
        $userdata = $this->CI->session->userdata('user');
        $this->CI->db->select('order_details.file_number, 
            order_details.customer_id,
            order_details.id as order_id,
            order_details.file_id, 
            order_details.random_number, 
            order_details.westcor_order_id,
            order_details.westcor_cpl_id, 
            order_details.westcor_buyer_id,
            order_details.westcor_seller_id, 
            order_details.westcor_secondary_buyer_id,
            order_details.westcor_secondary_seller_id,
            order_details.westcor_lender_id,
            order_details.westcor_file_id,
            order_details.is_regenerate_cpl,
            order_details.created_at as opened_date, 
            order_details.fnf_agent_id,
            order_details.fnf_document_id,
            order_details.cpl_document_name,
            order_details.proposed_insured_document_name,
            order_details.verification_code,
            order_details.verification_code_for_seller,
            order_details.code_created_at,
            order_details.code_created_at_for_seller,
            order_details.borrower_mobile_number,
            order_details.borrower_mobile_number_for_seller,
            order_details.proposed_branch_id,
            order_details.escrow_officer_id,
            order_details.premium,
            order_details.is_create_order_on_safewire,
            order_details.safewire_action_link,
            property_details.id as property_id, 
            property_details.address, 
            property_details.full_address, 
            property_details.property_type, 
            property_details.city as property_city, 
            property_details.state as property_state, 
            property_details.zip as property_zip, 
            property_details.county, 
            property_details.westcor_property_id, 
            property_details.legal_description, 
            property_details.primary_owner,
            property_details.secondary_owner,
            property_details.escrow_lender_id,
            property_details.cpl_lender_id,
            property_details.buyer_agent_id,
            property_details.borrowers_vesting,
            property_details.cpl_proposed_property_address,
            property_details.cpl_proposed_property_city,
            property_details.cpl_proposed_property_state,
            property_details.cpl_proposed_property_zip,
            property_details.unit_number,
            property_details.apn,
            transaction_details.id as transaction_id,
            transaction_details.sales_representative,
            transaction_details.title_officer,
            transaction_details.sales_amount,
            transaction_details.loan_amount,
            transaction_details.loan_number,
            transaction_details.transaction_type, 
            transaction_details.purchase_type,
            transaction_details.supplemental_report_date,
            transaction_details.preliminary_report_date,
            transaction_details.borrower, 
            transaction_details.secondary_borrower,
            transaction_details.vesting,
            customer_basic_details.id as lender_id,
            customer_basic_details.partner_id as lender_partner_id,
            customer_basic_details.street_address as lender_address,
            customer_basic_details.city as lender_city,
            customer_basic_details.state as lender_state,
            customer_basic_details.zip_code as lender_zipcode,
            customer_basic_details.company_name as lender_company_name,
            customer_basic_details.first_name as lender_first_name,
            customer_basic_details.last_name as lender_last_name,
            customer_basic_details.email_address as lender_email,
            customer_basic_details.assignment_clause as lender_assignment_clause,
            customer_basic_details.is_escrow,
            customer_basic_details.telephone_no as lender_telephone_no,
            agents.name as agent_name,
            agents.address as agent_address,
            agents.city as agent_city,
            agents.zipcode as agent_zipcode,
            agents.telephone_no as agent_telephone_no,
            pct_order_fnf_agents.agent_number,
            pct_order_fnf_agents.underwriter_code,
            pct_order_fnf_agents.underwriter,
            pct_order_product_types.product_type,
            pct_order_documents.created, p.created as proposed_document_created_date')
            ->from('order_details')
            ->join('property_details', 'order_details.property_id = property_details.id')
            ->join('transaction_details', 'order_details.transaction_id = transaction_details.id')
            ->join('customer_basic_details', 'property_details.escrow_lender_id = customer_basic_details.id', 'left')
            ->join('pct_order_documents', 'pct_order_documents.document_name = order_details.cpl_document_name', 'left')
            ->join('pct_order_documents as p', 'p.document_name = order_details.proposed_insured_document_name', 'left')
            ->join('agents', 'property_details.buyer_agent_id = agents.id', 'left')
            ->join('pct_order_fnf_agents', 'order_details.fnf_agent_id = pct_order_fnf_agents.id', 'left')
            ->join('pct_order_product_types', 'transaction_details.purchase_type = pct_order_product_types.product_type_id AND pct_order_product_types.status=1');
        $this->CI->db->where('file_id', $fileId);
         
        if (isset($userdata) && $userdata['is_master'] == 0 && $from_mail == 0 && $userdata['is_sales_rep'] == 0 && $userdata['is_title_officer'] == 0 && $userdata['is_payoff_user'] == 0) {
            $this->CI->db->group_start()
                ->where('order_details.customer_id', $userdata['id'])
                ->or_where('property_details.escrow_lender_id', $userdata['id'])
                ->group_end();
           
        }
        $query = $this->CI->db->get();
        return $query->row_array();
    }

    public function is_user()
    {
        $userdata = $this->CI->session->userdata('user');
        if (!empty($userdata['id'])) {
            if ($userdata['is_title_officer'] ==  1) {
                redirect(base_url().'title-officer-dashboard');
            } else if ($userdata['is_sales_rep'] ==  1) {
                redirect(base_url().'sales-dashboard/'.$userdata['id']);
            } else if ($userdata['is_special_lender'] ==  1) {
                redirect(base_url().'special-lender-dashboard');
            }
        } else {
            redirect(base_url().'order/login');
        }
    }
    
    public function get_order_documents($fileId,$from_mail=0)
    {
        $userdata = $this->CI->session->userdata('user');
        $this->CI->db->select('order_details.file_number, 
                order_details.file_id, 
                order_details.id as order_id, 
                pct_order_documents.document_name, 
                pct_order_documents.document_name, 
                pct_order_documents.original_document_name, 
                pct_order_documents.is_sync, 
                pct_order_documents.is_prelim_document, 
                pct_order_documents.api_document_id, 
                pct_order_documents.index_number, 
                pct_order_documents.is_linked_doc')
            ->from('order_details')
            ->join('property_details', 'order_details.property_id = property_details.id')
            ->join('pct_order_documents', 'order_details.id = pct_order_documents.order_id');
        $this->CI->db->where('order_details.file_id', $fileId);
        if ($userdata['is_master'] == 0 && $from_mail == 0) {
            $this->CI->db->group_start()
                ->where('order_details.customer_id', $userdata['id'])
                ->or_where('property_details.escrow_lender_id', $userdata['id'])
                ->group_end();
        }
        $query = $this->CI->db->get();
        if ($query->num_rows() > 0)  {
            return $query->result_array();
        } else {
            return array();
        }         
    }

    public function get_order_linked_documents($fileId, $from_mail=0)
    {
        $userdata = $this->CI->session->userdata('user');
        $this->CI->db->select('order_details.file_number, 
                order_details.file_id, 
                order_details.id as order_id, 
                pct_order_documents.document_name, 
                pct_order_documents.id, 
                pct_order_documents.original_document_name, 
                pct_order_documents.is_sync, 
                pct_order_documents.is_prelim_document, 
                pct_order_documents.api_document_id, 
                pct_order_documents.index_number, 
                pct_order_documents.is_linked_doc')
            ->from('order_details')
            ->join('property_details', 'order_details.property_id = property_details.id')
            ->join('pct_order_documents', 'order_details.id = pct_order_documents.order_id');

        $this->CI->db->where('order_details.file_id', $fileId);
        $this->CI->db->where('pct_order_documents.is_linked_doc', 1);
        $this->CI->db->order_by('pct_order_documents.index_number', 'asc');
        if ($userdata['is_master'] == 0 && $from_mail == 0) {
            $this->CI->db->group_start()
                ->where('order_details.customer_id', $userdata['id'])
                ->or_where('property_details.escrow_lender_id', $userdata['id'])
                ->group_end();
        }
        $query = $this->CI->db->get();
        if ($query->num_rows() > 0)  {
            return $query->result_array();
        } else {
            return array();
        }         
    }

    public function update($data, $condition = array()) 
    { 
        $table = 'order_details';

        if(!empty($data))
        {   
            $data['updated_at'] = date("Y-m-d H:i:s");

            // Update data
            $update = $this->CI->db->update($table, $data, $condition);
            // Return the status
            return $update?true:false;
        }
        return false;
    }

    public function get_linked_documents($order_id)
    {
        $this->CI->db->select('*')
            ->from('pct_order_documents');
            
        $this->CI->db->where('order_id', $order_id);
        $this->CI->db->where('is_linked_doc', 1);
        $this->CI->db->order_by('index_number', 'asc');
        $query = $this->CI->db->get();
        if ($query->num_rows() > 0)  {
            return $query->result_array();
        } else {
            return array();
        }         
    }

    public function get_user_documents($order_id)
    {
        $userdata = $this->CI->session->userdata('user');
        $this->CI->db->select('*')
            ->from('pct_order_documents');
         
        if ($userdata['is_title_officer'] == 0) {
            $this->CI->db->where('user_id', $userdata['id']);
        }
        
        $this->CI->db->where('order_id', $order_id);
        $this->CI->db->order_by('id', 'desc');
        $query = $this->CI->db->get();
        if ($query->num_rows() > 0)  {
            return $query->result_array();
        } else {
            return array();
        }         
    }

    public function getOrderdocuments($params)
    {
        $userdata = $this->CI->session->userdata('user');

        $this->CI->db->select('*')
            ->from('pct_order_documents');
         
        if ($userdata['is_title_officer'] == 0) {
            $this->CI->db->where('user_id', $userdata['id']);
        }
        $this->CI->db->where('order_id', $params['order_id']);
        $total_records =  $this->CI->db->count_all_results();

        $limit = isset($params['length']) && !empty($params['length']) ? $params['length'] : '';
        $offset = isset($params['start']) && !empty($params['start']) ? $params['start'] : '';
        $document_lists = array();

        if(isset($params['searchvalue']) && !empty($params['searchvalue'])) {
            $keyword = $params['searchvalue'];

            if (isset($keyword) && !empty($keyword)) {
                $this->CI->db->like('original_document_name', $keyword);
            }

            if ($userdata['is_title_officer'] == 0) {
                $this->CI->db->where('user_id', $userdata['id']);
            }

            $this->CI->db->where('order_id', $params['order_id']);
            $this->CI->db->select('*')
                ->from('pct_order_documents');
            $total_records =  $this->CI->db->count_all_results();


            if (isset($keyword) && !empty($keyword)) {
                $this->CI->db->like('original_document_name', $keyword);
            }

            if ($userdata['is_title_officer'] == 0) {
                $this->CI->db->where('user_id', $userdata['id']);
            }

            $this->CI->db->where('order_id', $params['order_id']);
            $this->CI->db->select('*')
                ->from('pct_order_documents');

            $this->CI->db->order_by('id', 'desc');  

            if((isset($limit) && !empty($limit)) || (isset($offset) && !empty($offset))) {
                $this->CI->db->limit($limit, $offset);
            } 

            $query = $this->CI->db->get();
            if ($query->num_rows() > 0) {
                $document_lists = $query->result_array();
            }
        } else {
            if ($userdata['is_title_officer'] == 0) {
                $this->CI->db->where('user_id', $userdata['id']);
            }

            $this->CI->db->where('order_id', $params['order_id']);
            $this->CI->db->select('*')
                ->from('pct_order_documents');

            $this->CI->db->order_by('id', 'desc');    

            
            if ((isset($limit) && !empty($limit)) || (isset($offset) && !empty($offset))) {
                $this->CI->db->limit($limit, $offset);
            }

            $query = $this->CI->db->get();
            if ($query->num_rows() > 0) {
                $document_lists = $query->result_array();
            }
        }

        return array(
            'recordsTotal' => $total_records,
            'recordsFiltered' => $total_records,
            'data' => $document_lists
        );
    }

    public function get_prelim_document($order_id)
    {
        $this->CI->db->select('*')
            ->from('pct_order_documents');
            
        $this->CI->db->where('order_id', $order_id);
        $this->CI->db->where('is_prelim_document', 1);
        $query = $this->CI->db->get();
        if ($query->num_rows() > 0)  {
            return $query->row_array();
        } else {
            return array();
        }         
    }

    public function get_document_detail($api_document_id, $order_id, $document_id)
    {
        $this->CI->db->select('*')
            ->from('pct_order_documents');
        
        $this->CI->db->where('api_document_id', $api_document_id);
        $this->CI->db->where('order_id', $order_id);
        $this->CI->db->where('id', $document_id);
        $query = $this->CI->db->get();
        if ($query->num_rows() > 0)  {
            return $query->row_array();
        } else {
            return array();
        }         
    }

    public function get_rows($params = array())
    {
        $table = 'order_details';

        $this->CI->db->select('*');
        $this->CI->db->from($table);
        
        if(array_key_exists("where", $params)){
            foreach($params['where'] as $key => $val){
                $this->CI->db->where($key, $val);
            }
        }
        
        if(array_key_exists("returnType",$params) && $params['returnType'] == 'count'){
            $result = $this->CI->db->count_all_results();
        }else{
            if(array_key_exists("id", $params)){
                $this->CI->db->where('id', $params['id']);
                $query = $this->CI->db->get();
                $result = $query->row_array();
            }else{
                $this->CI->db->order_by('id', 'asc');
                if(array_key_exists("start",$params) && array_key_exists("limit",$params)){
                    $this->CI->db->limit($params['limit'],$params['start']);
                }elseif(!array_key_exists("start",$params) && array_key_exists("limit",$params)){
                    $this->CI->db->limit($params['limit']);
                }
                
                $query = $this->CI->db->get();
                $result = ($query->num_rows() > 0)?$query->row_array():FALSE;
            }
        }
        
        // Return fetched data
        return $result;
    }

    public function randomPassword() 
    {
        $len = 8;
        $sets = array();
        $sets[] = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $sets[] = 'abcdefghijkmnopqrstuvwxyz';
        $sets[] = '0123456789';
        // $sets[]  = '~!@#$%^&*(){}[],./?';
        $password = '';
        
        foreach ($sets as $set) {
            $password .= $set[array_rand(str_split($set))];
        }
    
        while(strlen($password) < $len) {
            $randomSet = $sets[array_rand($sets)];
            $password .= $randomSet[array_rand(str_split($randomSet))]; 
        }
        return str_shuffle($password);
    }

    public function checkDuplicateOrder($apn)
    {
        $this->CI->db->select('*')
            ->from('property_details');
        
        $this->CI->db->where('apn', $apn);
        $query = $this->CI->db->get();
        if ($query->num_rows() > 0)  {
            $count = $query->num_rows();
            if ($count == 1) {
                $propertyData = $query->row_array();
                if ($propertyData['allow_duplication'] == 1) {
                    return false;
                } else {
                    return true;
                }
            } else {
                $propertyData = $query->result_array();
                $key = array_search(1, array_column($propertyData, 'allow_duplication'));
                if (isset($key)) {
                    return false;
                } else {
                    return true;
                }
            }
        } else {
            return false;
        }     
    }

    public function get_special_lenders_orders($params)
    {
        $userdata = $this->CI->session->userdata('user');
        if (isset($params['searchvalue']) && !empty($params['searchvalue'])) {
            $keyword = $params['searchvalue'];

            if (isset($keyword) && !empty($keyword)) {
                $this->CI->db->group_start()
                    ->like("property_details.full_address", $keyword)
                    ->or_like('order_details.file_number',$keyword)
                    ->group_end();
            }
            $this->CI->db->select('order_details.file_number, 
                order_details.file_id,
                property_details.full_address,
                order_details.id, 
                customer_basic_details.company_name, 
                pct_order_sales_rep.name, 
                order_details.created_at, 
                property_details.primary_owner')
            ->from('order_details')
            ->join('property_details', 'order_details.property_id = property_details.id')
            ->join('customer_basic_details', 'customer_basic_details.id = order_details.created_by')
            ->join('transaction_details', 'order_details.transaction_id = transaction_details.id')
            ->join('pct_order_sales_rep', 'pct_order_sales_rep.id = transaction_details.sales_representative', 'left');
            $this->CI->db->where('property_details.escrow_lender_id', $userdata['id']);
            
            $total_records =  $this->CI->db->count_all_results();
            
            if(isset($keyword) && !empty($keyword))
            {
                $this->CI->db->group_start()
                    ->like("property_details.full_address", $keyword)
                    ->or_like('order_details.file_number',$keyword)
                    ->or_like('order_details.file_number',$keyword)
                    ->group_end();
            }
            $limit = isset($params['length']) && !empty($params['length']) ? $params['length'] : '';
            $offset = isset($params['start']) && !empty($params['start']) ? $params['start'] : '';
            $orders_lists = array();
           
            $this->CI->db->select('order_details.file_number, 
                order_details.file_id,
                property_details.full_address,
                order_details.id, 
                customer_basic_details.company_name, 
                pct_order_sales_rep.name, 
                order_details.created_at, 
                property_details.primary_owner')
            ->from('order_details')
            ->join('property_details', 'order_details.property_id = property_details.id')
            ->join('customer_basic_details', 'customer_basic_details.id = order_details.created_by')
            ->join('transaction_details', 'order_details.transaction_id = transaction_details.id')
            ->join('pct_order_sales_rep', 'pct_order_sales_rep.id = transaction_details.sales_representative', 'left');
            $this->CI->db->where('property_details.escrow_lender_id', $userdata['id']);
            $this->CI->db->order_by("order_details.id", "desc");

            if ((isset($limit) && !empty($limit)) || (isset($offset) && !empty($offset))) {
                $this->CI->db->limit($limit, $offset);
            }

            $query = $this->CI->db->get();

            if ($query->num_rows() > 0)  {
                $orders_lists = $query->result_array();
            }
        }
        else
        {
            $this->CI->db->select('order_details.file_number, 
                order_details.file_id,
                property_details.full_address,
                order_details.id, 
                customer_basic_details.company_name, 
                pct_order_sales_rep.name, 
                order_details.created_at, 
                property_details.primary_owner')
            ->from('order_details')
            ->join('property_details', 'order_details.property_id = property_details.id')
            ->join('customer_basic_details', 'customer_basic_details.id = order_details.created_by')
            ->join('transaction_details', 'order_details.transaction_id = transaction_details.id')
            ->join('pct_order_sales_rep', 'pct_order_sales_rep.id = transaction_details.sales_representative', 'left');
            $this->CI->db->where('property_details.escrow_lender_id', $userdata['id']);
       
            $total_records =  $this->CI->db->count_all_results();
           
            $limit = isset($params['length']) && !empty($params['length']) ? $params['length'] : '';
            $offset = isset($params['start']) && !empty($params['start']) ? $params['start'] : '';
            $orders_lists = array();
           
            $this->CI->db->select('order_details.file_number, 
                order_details.file_id,
                property_details.full_address,
                order_details.id, 
                customer_basic_details.company_name, 
                pct_order_sales_rep.name, 
                order_details.created_at, 
                property_details.primary_owner')
            ->from('order_details')
            ->join('property_details', 'order_details.property_id = property_details.id')
            ->join('customer_basic_details', 'customer_basic_details.id = order_details.created_by')
            ->join('transaction_details', 'order_details.transaction_id = transaction_details.id')
            ->join('pct_order_sales_rep', 'pct_order_sales_rep.id = transaction_details.sales_representative', 'left');
            $this->CI->db->where('property_details.escrow_lender_id', $userdata['id']);
            $this->CI->db->order_by("order_details.id", "desc");

            if ((isset($limit) && !empty($limit)) || (isset($offset) && !empty($offset))) {
                $this->CI->db->limit($limit, $offset);
            }

            $query = $this->CI->db->get();

            if ($query->num_rows() > 0)  {
                $orders_lists = $query->result_array();
            } 
        }
        
    	return array(
            'recordsTotal' => $total_records,
            'recordsFiltered' => $total_records,
            'data' => $orders_lists
        );
    }

    public function checkCompanyExist($partner_company_id)
    {
        $this->CI->db->select('*')
            ->from('pct_order_partner_company_info');
        
        $this->CI->db->where('partner_id', $partner_company_id);
        $query = $this->CI->db->get();
        if ($query->num_rows() > 0)  {
            return true;
        } else {
            return false;
        }     
    }

    public function get_order_uploaded_documents($fileId)
    {
        $userdata = $this->CI->session->userdata('user');
        $this->CI->db->select('order_details.file_number, 
                order_details.file_id, 
                order_details.id as order_id, 
                pct_order_documents.id, 
                pct_order_documents.document_name, 
                pct_order_documents.original_document_name, 
                pct_order_documents.is_sync, 
                pct_order_documents.is_prelim_document, 
                pct_order_documents.api_document_id, 
                pct_order_documents.index_number, 
                pct_order_documents.is_linked_doc')
            ->from('order_details')
            ->join('pct_order_documents', 'order_details.id = pct_order_documents.order_id');

        $this->CI->db->where('order_details.file_id', $fileId);
        $this->CI->db->group_start()
            ->where('pct_order_documents.is_grant_doc', 1)
            ->or_where('pct_order_documents.is_cpl_doc', 1)
            ->or_where('pct_order_documents.is_proposed_insured_doc', 1)
            ->group_end();
        
        $query = $this->CI->db->get();
        if ($query->num_rows() > 0)  {
            return $query->result_array();
        } else {
            return array();
        }         
    }

    public function get_resware_admin_credential() 
    {
        $this->CI->db->select('*');
        $this->CI->db->from('pct_resware_admin_credential');
        $query = $this->CI->db->get();
        return $result = $query->row_array();
    }
    

    public function get_order($params)
    {
        $this->CI->db->select('*');
        $this->CI->db->from('order_details');
        
        if(array_key_exists("where", $params)){
            foreach($params['where'] as $key => $val){
                $this->CI->db->where($key, $val);
            }
        }
        
        if(array_key_exists("returnType",$params) && $params['returnType'] == 'count'){
            $result = $this->CI->db->count_all_results();
        }else{
            if(array_key_exists("id", $params)){
                $this->CI->db->where('id', $params['id']);
                $query = $this->CI->db->get();
                $result = $query->row_array();
            }else{
                $this->CI->db->order_by('id', 'asc');
                if(array_key_exists("start",$params) && array_key_exists("limit",$params)){
                    $this->CI->db->limit($params['limit'],$params['start']);
                }elseif(!array_key_exists("start",$params) && array_key_exists("limit",$params)){
                    $this->CI->db->limit($params['limit']);
                }
                
                $query = $this->CI->db->get();
                $result = ($query->num_rows() > 0)?$query->result_array():FALSE;
            }
        }
        
        // Return fetched data
        return $result;
    }


    public function get_borrower_info($orderId, $buyerFlag)
    {
        $this->CI->db->select('*')
            ->from('pct_order_borrower_info');
            
        $this->CI->db->where('order_id', $orderId);
        $this->CI->db->where('is_buyer', $buyerFlag);
        $query = $this->CI->db->get();
        if ($query->num_rows() > 0)  {
            return $query->result_array();
        } else {
            return array();
        }
    }

    public function get_borrower_residence_info($orderId, $buyerFlag)
    {
        $this->CI->db->select('*')
            ->from('pct_order_borrower_residence_info');
            
        $this->CI->db->where('order_id', $orderId);
        $this->CI->db->where('is_buyer', $buyerFlag);
        $query = $this->CI->db->get();
        if ($query->num_rows() > 0)  {
            return $query->result_array();
        } else {
            return array();
        }
    }

    public function get_borrower_employment_info($orderId, $buyerFlag)
    {
        $this->CI->db->select('*')
            ->from('pct_order_borrower_employment_info');
            
        $this->CI->db->where('order_id', $orderId);
        $this->CI->db->where('is_buyer', $buyerFlag);
        $query = $this->CI->db->get();
        if ($query->num_rows() > 0)  {
            return $query->result_array();
        } else {
            return array();
        }
    }  
    
    public function storeCplError($data)
    {
        $userdata = $this->CI->session->userdata('user');
        $this->CI->load->model('order/home_model');

        if (!empty($userdata['id'])) {
            $user_id = $userdata['id']; 
        } else {
            $user_id = 0; 
        }

        $errorLogsdata = array(
            'user_id' => $user_id,
            'order_id' => $data['order_id'],
            'file_number' => $data['file_number'],
            'cpl_page' => $data['cpl_page'],
            'error' => $data['error'],
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        );
        $this->CI->db->insert('pct_order_cpl_api_logs', $errorLogsdata);
        $customer_id = $data['customer_id'];
        $subject = 'CPL Document Not Generated';
        $property = $data['property_address'];
        $condition = array(
            'id' => $customer_id
        );
        $customerDetails = $this->CI->home_model->get_customers($condition);

        if (!empty($customerDetails)) {
            $first_name = isset($customerDetails['first_name']) && !empty($customerDetails['first_name']) ? $customerDetails['first_name'] : '';
            $last_name = isset($customerDetails['last_name']) && !empty($customerDetails['last_name']) ? $customerDetails['last_name'] : '';
            $telephone_no = isset($customerDetails['telephone_no']) && !empty($customerDetails['telephone_no']) ? $customerDetails['telephone_no'] : '';
            $email_address = isset($customerDetails['email_address']) && !empty($customerDetails['email_address']) ? $customerDetails['email_address'] : '';
            $company_name = isset($customerDetails['company_name']) && !empty($customerDetails['company_name']) ? $customerDetails['company_name'] : '';
            $street_address = isset($customerDetails['street_address']) && !empty($customerDetails['street_address']) ? $customerDetails['street_address'] : '';
            $city = isset($customerDetails['city']) && !empty($customerDetails['city']) ? $customerDetails['city'] : '';
            $zipcode = isset($customerDetails['zip_code']) && !empty($customerDetails['zip_code']) ? $customerDetails['zip_code'] : '';

            $message = '<h3>User Details:</h3><p>Name: '.$first_name.' '.$last_name.'</p><p>Telephone: '.$telephone_no.'</p><p>Email Address: '.$email_address.'</p><p>Company Name: '.$company_name.'</p><p>Street Address: '.$street_address.'</p><p>City: '.$city.'</p><p>Zipcode: '.$zipcode.'</p><p>Property Address: '.$property.'</p>';
            
            $from_name = 'Pacific Coast Title Company';
            $from_mail = env('FROM_EMAIL');
            $subject = 'Notification for '.$subject;
            $to = env('ADMIN_EMAIL');
            $this->CI->load->helper('sendemail');
            $mail_result = send_email($from_mail,$from_name, $to, $subject, $message);
        }
        return true;
    }

    public function getProposedBranches()
    {
        $this->CI->db->select('*');
        $this->CI->db->from('pct_order_westcore_branches');
        $this->CI->db->where('is_proposed_branch', 1);
        $query = $this->CI->db->get();
        $result = $query->result_array();
        return $result;
    }

    public function getProposedBranchDetail($branchId)
    {
        $this->CI->db->select('*');
        $this->CI->db->from('pct_order_westcore_branches');
        $this->CI->db->where('id', $branchId);
        $query = $this->CI->db->get();
        $result = $query->row_array();
        return $result;
    }

    public function syncSafewireDocuments($orderUrl, $wireUrl, $orderDetails)
    {
        $this->CI->load->model('order/apiLogs');
        $logid = $this->CI->apiLogs->syncLogs(0, 'safewire', 'get_order_detail_pdf', $orderUrl, array(), array(), $orderDetails['order_id'], 0);
        $ch = curl_init($orderUrl);                                    
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');                        
        curl_setopt($ch, CURLOPT_POSTFIELDS, array());                   
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                'Api-Key: '.env('SAFEWIRE_API_KEY'),
                'Content-Type: application/json',
            )
        );
        $result = curl_exec($ch);

        if (!is_dir('uploads/order_safewire_documents')) {
            mkdir('./uploads/order_safewire_documents', 0777, TRUE);
        }
        file_put_contents('./uploads/order_safewire_documents/'.$orderDetails['file_id'].'.pdf', $result);
        
        $binaryOrderData   = base64_encode($result); 
        $this->sendSafewireDocumentToResware($orderDetails['file_id'].'.pdf', $orderDetails, $binaryOrderData, 1);
        $this->uploadDocumentOnAwsS3($orderDetails['file_id'].'.pdf', 'order_safewire_documents');

        $logid = $this->CI->apiLogs->syncLogs(0, 'safewire', 'get_wire_detail_pdf', $wireUrl, array(), array(), $orderDetails['order_id'], 0);
        $ch = curl_init($wireUrl);                                    
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');                        
        curl_setopt($ch, CURLOPT_POSTFIELDS, array());                   
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                'Api-Key: '.env('SAFEWIRE_API_KEY'),
                'Content-Type: application/json',
            )
        );
        $error_msg = curl_error($ch);
        $resultWire = curl_exec($ch);

        if (!is_dir('uploads/wire_safewire_documents')) {
            mkdir('./uploads/wire_safewire_documents', 0777, TRUE);
        }
        file_put_contents('./uploads/wire_safewire_documents/'.$orderDetails['file_id'].'.pdf', $resultWire);
        $binaryWireOrderData   = base64_encode($resultWire); 
        $this->sendSafewireDocumentToResware($orderDetails['file_id'].'.pdf', $orderDetails, $binaryWireOrderData, 0);
        $this->uploadDocumentOnAwsS3($orderDetails['file_id'].'.pdf', 'wire_safewire_documents');
        $this->CI->apiLogs->syncLogs(0, 'safewire', 'get_wire_detail_pdf', $wireUrl, array(), $resultWire, $orderDetails['order_id'], $logid);
        $res = json_decode($result, true);
        return $res;
    }

    public function sendSafewireDocumentToResware($document_name, $orderDetails, $binaryData, $orderFlag = 0)
	{
        $this->CI->load->model('order/apiLogs');
		$this->CI->load->library('order/resware');

        if ($orderFlag == 1) {
            $fileSize = filesize('./uploads/order_safewire_documents/'.$document_name);
        } else {
            $fileSize = filesize('./uploads/wire_safewire_documents/'.$document_name);
        }
		
		$documentData = array(
			'document_name' => $document_name,
			'original_document_name' => $document_name,
			'document_type_id' => 1037,
			'document_size' => $fileSize,
			'user_id' => 0,
			'order_id' => $orderDetails['order_id'],
			'description' => 'Safewire Document',
			'is_sync' => 1,
			'is_prelim_document' => 0,
			'is_cpl_doc' => 0,
            'is_safewire_doc' => 1, 
            'created' => date("Y-m-d H:i:s")
		);
        $this->CI->db->insert('pct_order_documents', $documentData);
        $documentId = $this->CI->db->insert_id();

		$endPoint = 'files/'.$orderDetails['file_id'].'/documents';
		$documentApiData = array(			
			'DocumentName' => $document_name,
			'DocumentType' => array(
				'DocumentTypeID' => 1037,
			),
			'Description' => 'Safewire Document',
			'InternalOnly' => false,
			'DocumentBody' => $binaryData
		);
		$document_api_data = json_encode($documentApiData, JSON_UNESCAPED_SLASHES);

        $userData = array(
            'admin_api' => 1
        );	

		$logid = $this->CI->apiLogs->syncLogs(0, 'resware', 'create_document', env('RESWARE_ORDER_API').$endPoint, $documentApiData, array(), $orderDetails['order_id'], 0);
		$result = $this->CI->resware->make_request('POST', $endPoint, $document_api_data, $userData);
		$this->CI->apiLogs->syncLogs(0, 'resware', 'create_document', env('RESWARE_ORDER_API').$endPoint, $documentApiData, $result, $orderDetails['order_id'], $logid);
		$res = json_decode($result);
        $data = array();
        $data['updated'] = date("Y-m-d H:i:s");
        $data['api_document_id'] = $res->Document->DocumentID;
        $this->CI->db->update('pct_order_documents', $data, array('id' => $documentId));
	}

    public function array_recursive_search_key_map($needle, $haystack) 
    {
        foreach($haystack as $first_level_key=>$value) {
            if ($needle === $value) {
                return array($first_level_key);
            } elseif (is_array($value)) {
                $callback = $this->array_recursive_search_key_map($needle, $value);
                if ($callback) {
                    return array_merge(array($first_level_key), $callback);
                }
            }
        }
        return false;
    }

    public function uploadDocumentOnAwsS3($fileName, $folder= '', $csv = 0)
    {
        $bucket = env('AWS_BUCKET');
        if(!empty($folder)) {
            $keyname = $folder."/".basename($fileName);    
            $filepath = "uploads/".$folder."/".$fileName;             
        } else {
            if ($csv == 1) {
                $keyname = "csv/".basename($fileName); 
            } else {
                $keyname = basename($fileName); 
            }
            $filepath = "uploads/".$fileName;  
        }
        
        try {
            $s3Client = new Aws\S3\S3Client([
                'region' => env('AWS_REGION'),
                'version' => '2006-03-01',
                'credentials' => [
                    'key' => env('AWS_ACCESS_KEY_ID'),
                    'secret' => env('AWS_SECRET_ACCESS_KEY')
                ],
            ]);
            
            $result = $s3Client->putObject([
                'Bucket' => $bucket,
                'Key' => $keyname,
                'SourceFile' => $filepath,
            ]);
        } catch (Aws\Exception\AwsException $e) {
            //return $e->getMessage() . "\n";
            return false;
        }
        if(!empty($result['ObjectURL'])) {
            chmod($filepath, 0644);
            gc_collect_cycles();
            unlink($filepath);
            return true;
        } else {
            return false;
        } 
    }

    public function fileExistOrNotOnS3($key)
    {
        try {
            $s3Client = new Aws\S3\S3Client([
                'region' => env('AWS_REGION'),
                'version' => '2006-03-01',
                'credentials' => [
                    'key' => env('AWS_ACCESS_KEY_ID'),
                    'secret' => env('AWS_SECRET_ACCESS_KEY')
                ],
            ]);
            $result = $s3Client->doesObjectExist(env('AWS_BUCKET'), $key);
        } catch (Aws\Exception\AwsException $e) {
            return false;
        }
        if ($result) {
            return true;
        } else {
            return false;
        }
    }

    public function getOpenOrdersCountForRefiProducts($month, $userId, $year = 0, $escrow_flag = 0)
    {
        $this->CI->db->select('count(*) as refi_count, sum(premium) as total_premium_for_refi_open_orders, sum(escrow_amount) as total_escrow_amount_for_refi_open_orders')
            ->from('order_details')
            ->join('transaction_details', 'order_details.transaction_id = transaction_details.id');
        $this->CI->db->where('order_details.prod_type', 'loan');
        $this->CI->db->where('MONTH(order_details.created_at)', $month); 

        if ($year == 0) {
            $this->CI->db->where('YEAR(order_details.created_at)', date('Y')); 
        } else {
            $this->CI->db->where('YEAR(order_details.created_at)', $year); 
        }
        
        if (is_array($userId)) {
            if (!empty($userId)) {
                $this->CI->db->where_in('transaction_details.sales_representative', $userId); 
            } else {
                $this->CI->db->where('transaction_details.sales_representative is not null'); 
            }
        } else {
            if ($userId != 'all') {
                $this->CI->db->where('transaction_details.sales_representative', $userId); 
            } else {
                $this->CI->db->where('transaction_details.sales_representative is not null'); 
            }
        }

        if ($escrow_flag == 1) {
            $this->CI->db->where('order_details.escrow_amount > 0');
        }

        $query = $this->CI->db->get();
        $result = $query->row_array();
        return $result;
    }

    public function getOpenOrdersCountForSaleProducts($month, $userId, $year = 0, $escrow_flag = 0)
    {
        $this->CI->db->select('count(*) as sale_count, sum(premium) as total_premium_for_sale_open_orders, sum(escrow_amount) as total_escrow_amount_for_sale_open_orders')
            ->from('order_details')
            ->join('transaction_details', 'order_details.transaction_id = transaction_details.id');
        $this->CI->db->where('order_details.prod_type', 'sale');
        $this->CI->db->where('MONTH(order_details.created_at)', $month); 

        if ($year == 0) {
            $this->CI->db->where('YEAR(order_details.created_at)', date('Y')); 
        } else {
            $this->CI->db->where('YEAR(order_details.created_at)', $year); 
        }

        if (is_array($userId)) {
            if (!empty($userId)) {
                $this->CI->db->where_in('transaction_details.sales_representative', $userId); 
            } else {
                $this->CI->db->where('transaction_details.sales_representative is not null'); 
            }
        } else {
            if ($userId != 'all') {
                $this->CI->db->where('transaction_details.sales_representative', $userId); 
            } else {
                $this->CI->db->where('transaction_details.sales_representative is not null'); 
            }
        }

        if ($escrow_flag == 1) {
            $this->CI->db->where('order_details.escrow_amount > 0');
        }

        $query = $this->CI->db->get();
        $result = $query->row_array();
        return $result;
    }

    public function getClosedOrdersCountForRefiProducts($month, $userId, $year = 0, $escrow_flag = 0)
    {
        $this->CI->db->select('count(*) as refi_count, sum(premium) as total_premium_for_refi_close_orders, sum(escrow_amount) as total_escrow_amount_for_refi_close_orders')
            ->from('order_details')
            ->join('transaction_details', 'order_details.transaction_id = transaction_details.id');
        $this->CI->db->where('order_details.prod_type', 'loan');
        $this->CI->db->where('MONTH(order_details.sent_to_accounting_date)', $month); 

        if ($year == 0) {
            $this->CI->db->where('YEAR(order_details.sent_to_accounting_date)', date('Y')); 
        } else {
            $this->CI->db->where('YEAR(order_details.sent_to_accounting_date)', $year); 
        }
        
        if (is_array($userId)) {
            if (!empty($userId)) {
                $this->CI->db->where_in('transaction_details.sales_representative', $userId); 
            } else {
                $this->CI->db->where('transaction_details.sales_representative is not null'); 
            }
        } else {
            if ($userId != 'all') {
                $this->CI->db->where('transaction_details.sales_representative', $userId); 
            } else {
                $this->CI->db->where('transaction_details.sales_representative is not null'); 
            }
        }

        if ($escrow_flag == 1) {
            $this->CI->db->where('order_details.escrow_amount > 0');
        }

        $query = $this->CI->db->get();
        $result = $query->row_array();
        return $result;
    }

    public function getClosedOrdersCountForSaleProducts($month, $userId, $year = 0, $escrow_flag = 0)
    {
        $this->CI->db->select('count(*) as sale_count, sum(premium) as total_premium_for_sale_close_orders, sum(escrow_amount) as total_escrow_amount_for_sale_close_orders')
            ->from('order_details')
            ->join('transaction_details', 'order_details.transaction_id = transaction_details.id');
        $this->CI->db->where('order_details.prod_type', 'sale');
        $this->CI->db->where('MONTH(order_details.sent_to_accounting_date)', $month); 

        if ($year == 0) {
            $this->CI->db->where('YEAR(order_details.sent_to_accounting_date)', date('Y')); 
        } else {
            $this->CI->db->where('YEAR(order_details.sent_to_accounting_date)', $year); 
        }
        
        if (is_array($userId)) {
            if (!empty($userId)) {
                $this->CI->db->where_in('transaction_details.sales_representative', $userId); 
            } else {
                $this->CI->db->where('transaction_details.sales_representative is not null'); 
            }
        } else {
            if ($userId != 'all') {
                $this->CI->db->where('transaction_details.sales_representative', $userId); 
            } else {
                $this->CI->db->where('transaction_details.sales_representative is not null'); 
            }
        }

        if ($escrow_flag == 1) {
            $this->CI->db->where('order_details.escrow_amount > 0');
        }

        $query = $this->CI->db->get();
        $result = $query->row_array();
        return $result;
    }

    public function getSalesRep($params = array())
    {
        $table = 'customer_basic_details';
        $this->CI->db->select('*');
        $this->CI->db->from($table);

        if (array_key_exists("where", $params)) {
            foreach($params['where'] as $key => $val){
                $this->CI->db->where($key, $val);
            }
        }
        
        if (array_key_exists("returnType",$params) && $params['returnType'] == 'count') {
            $result = $this->CI->db->count_all_results();
        } else {
            if (array_key_exists("id", $params)) {
                $this->CI->db->where('id', $params['id']);
                $query = $this->CI->db->get();
                $result = $query->row_array();
            } else {
                $this->CI->db->order_by('id', 'asc');
                if (array_key_exists("start",$params) && array_key_exists("limit",$params)) {
                    $this->CI->db->limit($params['limit'],$params['start']);
                } elseif (!array_key_exists("start",$params) && array_key_exists("limit",$params)) {
                    $this->CI->db->limit($params['limit']);
                }
                $query = $this->CI->db->get();
                $result = ($query->num_rows() > 0) ? $query->result_array() : FALSE;
            }
        }
        return $result;
    }

    public function countWokingsDaysLeftOfMonth() 
	{
		$count = 0;
		$counter = mktime(0, 0, 0, date('m'), date('d'), date('Y'));
		while (date("n", $counter) == date('m')) {
			if (in_array(date("w", $counter), array(0, 6)) == false) {
				$count++;
			}
			$counter = strtotime("+1 day", $counter);
		}
		$this->CI->db->select('*');
        $this->CI->db->from('pct_holidays');	
		$this->CI->db->where('holiday_date >', date('Y-m-d'));
		$this->CI->db->where('holiday_date <=', date("Y-m-t", strtotime(date('Y-m-d'))));
        $query = $this->CI->db->get();
		$result = $query->result_array();
		foreach ($result as $res) {
			$weekendFlag = (date('N', strtotime($res['holiday_date'])) >= 6);
			if($weekendFlag != 1) {
				$count--;
			}
		}
		return $count;
	}

	public function countWorkedDaysOfMonth() 
	{
		$count = 0;
		$counter = mktime(0, 0, 0, date('m'), date('d')-1, date('Y'));
		while (date("n", $counter) == date('m')) {
			if (in_array(date("w", $counter), array(0, 6)) == false) {
				$count++;
			}
			$counter = strtotime("-1 day", $counter);
		}
		$this->CI->db->select('*');
        $this->CI->db->from('pct_holidays');	
		$this->CI->db->where('holiday_date >=', date('Y-m-01'));
		$this->CI->db->where('holiday_date <', date('Y-m-d'));
        $query = $this->CI->db->get();
		$result = $query->result_array();
		foreach ($result as $res) {
			$weekendFlag = (date('N', strtotime($res['holiday_date'])) >= 6);
			if($weekendFlag != 1) {
				$count--;
			}
		}
		return $count;
	}

    public function get_order_notes($orderId)
    {
        $this->CI->db->select('*')
            ->from('pct_order_notes');
            
        $this->CI->db->where('order_id', $orderId);
        $query = $this->CI->db->get();
        if ($query->num_rows() > 0)  {
            return $query->result_array();
        } else {
            return array();
        }
    }

    public function uploadCPLDocumentToResware($document_name, $orderDetails, $binaryData)
	{
		$this->CI->load->model('order/document');
		$this->CI->load->library('order/resware');
		$this->CI->load->model('order/apiLogs');
		$userdata = $this->CI->session->userdata('user');
        if(empty($userdata)) {
			$userdata['id'] = 0;
		}
		$fileSize = filesize('./uploads/documents/'.$document_name);
		$documentData = array(
			'document_name' => $document_name,
			'original_document_name' => $document_name,
			'document_type_id' => 1051,
			'document_size' => $fileSize,
			'user_id' => $userdata['id'],
			'order_id' => $orderDetails['order_id'],
			'description' => 'CPL Document',
			'is_sync' => 1,
			'is_prelim_document' => 0,
			'is_cpl_doc' => 1
		);
		$documentId = $this->CI->document->insert($documentData);
		$endPoint = 'files/'.$orderDetails['file_id'].'/documents';
		$documentApiData = array(			
			'DocumentName' => $document_name,
			'DocumentType' => array(
				'DocumentTypeID' => 1051,
			),
			'Description' => 'CPL Document',
			'InternalOnly' => false,
			'DocumentBody' => $binaryData
		);
		$document_api_data = json_encode($documentApiData, JSON_UNESCAPED_SLASHES);

        $user_data = array();
		if (!empty($userdata['id'])) {
			if ($userdata['is_title_officer'] == 1 || $userdata['is_master'] == 1) {
				$user_data['admin_api'] = 1; 
			} else {
				$user_data = array();
			}
		} else {
			$user_data['admin_api'] = 1; 
		}
		
		$logid = $this->CI->apiLogs->syncLogs($userdata['id'], 'resware', 'create_document', env('RESWARE_ORDER_API').$endPoint, $documentApiData, array(), $orderDetails['order_id'], 0);
		$result = $this->CI->resware->make_request('POST', $endPoint, $document_api_data, $user_data);
		$this->CI->apiLogs->syncLogs($userdata['id'], 'resware', 'create_document', env('RESWARE_ORDER_API').$endPoint, $documentApiData, $result, $orderDetails['order_id'], $logid);
		$res = json_decode($result);
		$this->CI->document->update(array('api_document_id' => $res->Document->DocumentID), array('id' => $documentId));

		/*$from_name = 'Pacific Coast Title Company';
		$from_mail = env('FROM_EMAIL');
		$order_message_body = 'Please check attachment for CPL document.';
		$message = $order_message_body; 
		$subject = 'CPL Document';
		$to = $orderDetails['lender_email'];
		$cc = array();
		if (!empty($orderDetails['sales_representative'])) {
			$this->CI->db->select('*')
            	->from('pct_order_sales_rep');
			$this->CI->db->where('id', $orderDetails['sales_representative']);
			$query = $this->CI->db->get();
			$salesResult = $query->row_array();
			if (!empty($salesResult)) {
				$cc = array($salesResult['email_address']);
			}
		}
		$bcc = array();
		$file = array(base_url().'uploads/documents/'.$document_name);
		$this->CI->load->helper('sendemail');
		$mail_result = send_email($from_mail,$from_name, $to, $subject, $message,$file,$cc,$bcc);*/
	}

    public function uploadProposedDocumentToResware($document_name, $orderDetails, $binaryData)
    {
    	$this->CI->load->model('order/document');
		$this->CI->load->library('order/resware');
		$this->CI->load->model('order/apiLogs');
        $userdata = $this->CI->session->userdata('user');
        if(empty($userdata)) {
			$userdata['id'] = 0;
		}
		$fileSize = filesize('./uploads/proposed-insured/'.$document_name);
		$documentData = array(
			'document_name' => $document_name,
			'original_document_name' => $document_name,
			'document_type_id' => 1037,
			'document_size' => $fileSize,
			'user_id' => $userdata['id'],
			'order_id' => $orderDetails['order_id'],
			'description' => 'Proposed Insured Document',
			'is_sync' => 1,
			'is_prelim_document' => 0,
			'is_proposed_insured_doc' => 1
		);
		$documentId = $this->CI->document->insert($documentData);
		$endPoint = 'files/'.$orderDetails['file_id'].'/documents';
		$documentApiData = array(			
			'DocumentName' => $document_name,
			'DocumentType' => array(
				'DocumentTypeID' => 1037,
			),
			'Description' => 'Proposed Insured Document',
			'InternalOnly' => false,
			'DocumentBody' => $binaryData
		);
		$document_api_data = json_encode($documentApiData, JSON_UNESCAPED_SLASHES);

		$user_data = array();
		if (!empty($userdata['id'])) {
			if ($userdata['is_title_officer'] == 1 || $userdata['is_master'] == 1) {
				$user_data['admin_api'] = 1; 
			} else {
				$user_data = array();
			}
		} else {
			$user_data['admin_api'] = 1; 
		}
		$logid = $this->CI->apiLogs->syncLogs($userdata['id'], 'resware', 'create_document', env('RESWARE_ORDER_API').$endPoint, $documentApiData, array(), $orderDetails['order_id'], 0);
		$result = $this->CI->resware->make_request('POST', $endPoint, $document_api_data, $user_data);
		$this->CI->apiLogs->syncLogs($userdata['id'], 'resware', 'create_document', env('RESWARE_ORDER_API').$endPoint, $documentApiData, $result, $orderDetails['order_id'], $logid);
		$res = json_decode($result);
		$this->CI->document->update(array('api_document_id' => $res->Document->DocumentID), array('id' => $documentId));
    }

    public function uploadPrelimDocxDocToResware($document_name, $order_id, $binaryData, $file_id)
    {
    	$this->CI->load->model('order/document');
		$this->CI->load->library('order/resware');
		$this->CI->load->model('order/apiLogs');
        $userdata = $this->CI->session->userdata('user');
        if(empty($userdata)) {
			$userdata['id'] = 0;
		}
		$fileSize = filesize('./uploads/documents/'.$document_name);
		$documentData = array(
			'document_name' => $document_name,
			'original_document_name' => $document_name,
			'document_type_id' => 1032,
			'document_size' => $fileSize,
			'user_id' => $userdata['id'],
			'order_id' => $order_id,
			'description' => 'Prelim Word Document',
			'is_sync' => 1,
			'is_prelim_document' => 0,
			'is_proposed_insured_doc' => 1
		);
		$documentId = $this->CI->document->insert($documentData);
		$endPoint = 'files/'.$file_id.'/documents';
		$documentApiData = array(			
			'DocumentName' => $document_name,
			'DocumentType' => array(
				'DocumentTypeID' => 1032,
			),
			'Description' => 'Prelim Word Document',
			'InternalOnly' => false,
			'DocumentBody' => $binaryData
		);
		$document_api_data = json_encode($documentApiData, JSON_UNESCAPED_SLASHES);

		$user_data = array();
		if (!empty($userdata['id'])) {
			if ($userdata['is_title_officer'] == 1 || $userdata['is_master'] == 1) {
				$user_data['admin_api'] = 1; 
			} else {
				$user_data = array();
			}
		} else {
			$user_data['admin_api'] = 1; 
		}
		$logid = $this->CI->apiLogs->syncLogs($userdata['id'], 'resware', 'create_document', env('RESWARE_ORDER_API').$endPoint, $documentApiData, array(), $order_id, 0);
		$result = $this->CI->resware->make_request('POST', $endPoint, $document_api_data, $user_data);
		$this->CI->apiLogs->syncLogs($userdata['id'], 'resware', 'create_document', env('RESWARE_ORDER_API').$endPoint, $documentApiData, $result, $order_id, $logid);
		$res = json_decode($result);
		$this->CI->document->update(array('api_document_id' => $res->Document->DocumentID), array('id' => $documentId));
    }

    public function get_sales_users($sales_rep_users = array()) 
    {
        $this->CI->db->select('*');
        $this->CI->db->from('customer_basic_details');
        $this->CI->db->where('is_sales_rep', 1);
        if (!empty($sales_rep_users)) {
            $this->CI->db->where_in('id', $sales_rep_users);
        }
        $this->CI->db->order_by('first_name', 'asc');
        $query = $this->CI->db->get();
        $result = $query->result_array();
        return $result;
    }

    public function getOpenOrdersCountForLastMonthOfPreviousYear($userId)
    {
        $previousYear =  (string)(date('Y')-1);
        $this->CI->db->select('count(*) as total_count')
            ->from('order_details')
            ->join('transaction_details', 'order_details.transaction_id = transaction_details.id');
        $this->CI->db->where('MONTH(order_details.created_at)', '12'); 
        $this->CI->db->where('YEAR(order_details.created_at)', $previousYear); 
        if ($userId != 'all') {
            $this->CI->db->where('transaction_details.sales_representative', $userId); 
        } else {
            $this->CI->db->where('transaction_details.sales_representative is not null'); 
        }
        $query = $this->CI->db->get();
        $result = $query->row_array();
        return $result;
    }

    public function getCountBasedOnCurrentDayForPreviousMonthForPreviousYear($userId)
    {
        $firstDate = date("Y",strtotime("-1 year")).'-12-01';
        $lastDate = date("Y",strtotime("-1 year")).'-12-%d';
        $this->CI->db->select('count(*) as total_count')
            ->from('order_details')
            ->join('transaction_details', 'order_details.transaction_id = transaction_details.id');
        $this->CI->db->where("(order_details.created_at BETWEEN  DATE_FORMAT(NOW() , '$firstDate') AND DATE_FORMAT(NOW() + INTERVAL 1 DAY , '$lastDate'))"); 
        if ($userId != 'all') {
            $this->CI->db->where('transaction_details.sales_representative', $userId); 
        } else {
            $this->CI->db->where('transaction_details.sales_representative is not null'); 
        }
        $query = $this->CI->db->get();
        $result = $query->row_array();
        return $result;
    }

    public function getCountBasedOnCurrentDayForPreviousMonth($userId)
    {
        $firstDate = '%Y-'.date("m",strtotime("-1 month")).'-01';
        $lastDate = '%Y-'.date("m",strtotime("-1 month")).'-%d';
        $this->CI->db->select('count(*) as total_count')
            ->from('order_details')
            ->join('transaction_details', 'order_details.transaction_id = transaction_details.id');
        $this->CI->db->where("(order_details.created_at BETWEEN  DATE_FORMAT(NOW() , '$firstDate') AND DATE_FORMAT(NOW() + INTERVAL 1 DAY , '$lastDate'))"); 
        if ($userId != 'all') {
            $this->CI->db->where('transaction_details.sales_representative', $userId); 
        } else {
            $this->CI->db->where('transaction_details.sales_representative is not null'); 
        }
        $query = $this->CI->db->get();
        $result = $query->row_array();
        return $result;
    }

    public function getUsersInfo($emailAddresses) 
    {
        $this->CI->db->select('*');
        $this->CI->db->where_in('email_address', $emailAddresses);
        $query = $this->CI->db->get('customer_basic_details');
        if ($query->num_rows() > 0)  {
            return $query->result_array();
        } else {
            return array();
        }
    }
    
    public function sendNotification($message, $type, $sent_to_user, $is_sent_admin = 0)
    {
        if ($is_sent_admin == 1) {
            $channel = 'admin-channel';
            $event = 'admin-event';
        }

        if(!empty($sent_to_user) && $is_sent_admin == 0) {
            $channel = 'user-channel-'.$sent_to_user;
            $event = 'user-event-'.$sent_to_user;
        }

        $options = array(
            'cluster' => env("PUSHER_CLUSTER"),
            'useTLS' => true
        );

        $pusher = new Pusher\Pusher(
            env("PUSHER_KEY"),
            env("PUSHER_SECRET"),
            env("PUSHER_APP_ID"),
            $options
        );

        $data['message'] = $message ;
        $data['date'] = date("F d, Y");
        $data['type'] = $type;
        $pusher->trigger($channel, $event, $data);
    }
}
