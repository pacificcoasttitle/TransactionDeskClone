<?php
class ApiLogs extends CI_Model 
{
	function __construct() {
        // Set table name
        $this->table = 'pct_order_api_logs';
    }

    public function syncLogs($user_id, $api_type, $request_type, $request_url, $request_data, $response_data, $order_id = 0, $logId = 0) 
    {
        if(is_array($request_data)) {
            $request_data = json_encode($request_data, true);
        }
        if ($logId == 0) {
            $data = array(
                'user_id' => $user_id,
                'order_id' => $order_id,
                'api_type' => $api_type,
                'request_type' => $request_type,
                'request_data' => !empty($request_data) ? $request_data : '',
                'request_url' => $request_url,
                'created' => date('Y-m-d H:i:s')
            );
            $this->db->insert($this->table, $data);
            return $this->db->insert_id();
        } else {
            if (is_array($response_data)) {
                $response_data = json_encode($response_data, true);
            }
            $data = array(
                'response_data' => !empty($response_data) ? $response_data : '',
                'updated' => date('Y-m-d H:i:s'),
            );
            $this->db->update($this->table, $data, array('id' => $logId));
        }
    }


    public function get_partner_api_logs($params)
    {
        $this->db->where('api_type', 'resware');
        $this->db->where('request_type', 'add_partner');
        $this->db->from('pct_order_api_logs');
        $total_records =  $this->db->count_all_results();


        $limit = isset($params['length']) && !empty($params['length']) ? $params['length'] : '';
        $offset = isset($params['start']) && !empty($params['start']) ? $params['start'] : '';
        
        echo "<pre>"; print_r($params); exit;
        $logs_lists =array();

        if(isset($params['searchValue']) && !empty($params['searchValue']))
        {

        }
        else
        {
            $this->db->where('api_type', 'resware');
            $this->db->where('request_type', 'add_partner');
            $this->db->from('pct_order_api_logs');

            $filter_total_records =  $this->db->count_all_results();

            $this->db->where('api_type', 'resware');
            $this->db->where('request_type', 'add_partner');
            if((isset($limit) && !empty($limit)) || (isset($offset) && !empty($offset)))
            {
                $this->db->limit($limit, $offset);
            }
            $query = $this->db->get('pct_order_api_logs');
            
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
