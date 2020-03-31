<?php
class ApiLogs extends CI_Model 
{
	function __construct() {
        // Set table name
        $this->table = 'pct_order_api_logs';
    }

    public function syncLogs($user_id, $api_type, $request_type, $request_url, $request_data = array(), $response_data = array(), $order_id = 0, $logId = 0) 
    {
        if ($logId == 0) {
            $data = array(
                'user_id' => $user_id,
                'order_id' => $order_id,
                'api_type' => $api_type,
                'request_type' => $request_type,
                'request_data' => !empty($request_data) ? json_encode($request_data) : '',
                'request_url' => $request_url,
                'created' => date('Y-m-d H:i:s')
            );
            $this->db->insert($this->table, $data);
            return $this->db->insert_id();
        } else {
            $data = array(
                'response_data' => !empty($response_data) ? json_encode($response_data) : '',
                'updated' => date('Y-m-d H:i:s'),
            );
            $this->db->update($this->table, $data, array('id' => $logId));
        }
    }

}
