<?php
class PartnerApiLogs extends CI_Model 
{

	function __construct() {
        // Set table name
        $this->table = 'pct_order_partner_api_logs';
    }

    public function get_partner_api_logs($params)
    {
        $this->db->select('pct_order_partner_api_logs.*,order_details.file_id,order_details.file_number')
        ->from('pct_order_partner_api_logs')
        ->join('order_details', 'order_details.partner_api_log_id = pct_order_partner_api_logs.id');
        $total_records =  $this->db->count_all_results();

        $limit = isset($params['length']) && !empty($params['length']) ? $params['length'] : '';
        $offset = isset($params['start']) && !empty($params['start']) ? $params['start'] : '';
        $logs_lists =array();

        if(isset($params['searchValue']) && !empty($params['searchValue']))
        {

        }
        else
        {
            $this->db->select('pct_order_partner_api_logs.*,order_details.file_id,order_details.file_number,transaction_details.id as transaction_id,
            transaction_details.sales_representative,
            pct_order_sales_rep.name as sales_rep_name,
            transaction_details.title_officer,
            pct_order_title_officer.name as title_officer_name')
            ->from('pct_order_partner_api_logs')
            ->join('order_details', 'order_details.partner_api_log_id = pct_order_partner_api_logs.id')
            ->join('transaction_details', 'order_details.transaction_id = transaction_details.id')
            ->join('pct_order_sales_rep', 'transaction_details.sales_representative = pct_order_sales_rep.id')
            ->join('pct_order_title_officer', 'transaction_details.title_officer = pct_order_title_officer.id');
            $this->db->order_by("pct_order_partner_api_logs.id", "desc");

            if ((isset($limit) && !empty($limit)) || (isset($offset) && !empty($offset))) {
                $this->db->limit($limit, $offset);
            }

            $query = $this->db->get();
            
            if ($query->num_rows() > 0) 
            {
                $logs_lists = $query->result_array();
            } 
        }
        return array(
            'recordsTotal' => $total_records,
            'recordsFiltered' => $filter_total_records,
            'data' => $logs_lists
        );
    }
}