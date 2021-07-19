<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class Westcor
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

    public function make_request($http_method, $endpoint, $body_params, $is_token_call = 0, $bearerToken = '')
    {
        $ch = curl_init(getenv('WESTCORE_URL').$endpoint);                                    
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $http_method);                        
        curl_setopt($ch, CURLOPT_POSTFIELDS, $body_params);                   
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        if ($is_token_call == 0) {
            curl_setopt($ch, CURLOPT_HTTPHEADER, array(                                
                'Content-Type: application/json',
                'Authorization: Bearer '.$bearerToken,
                'Content-Length: ' . strlen($body_params))                                 
            ); 
        }
        $error_msg = curl_error($ch);
        $result = curl_exec($ch);
        return $result;
    }

    public function createToken($orderNumber, $is_branch_update = 0) 
    {
        if (!empty($this->CI->session->userdata('user'))) {
            $userdata = $this->CI->session->userdata('user');
        } else if(!empty($this->CI->session->userdata('admin'))) {
            $userdata = $this->CI->session->userdata('admin');
        } else {
            $userdata = array();
            $userdata['id'] = 0;
        }
        $this->CI->load->model('order/apiLogs');
        $endPoint = 'Token';
        $postData = 'grant_type='.getenv('WESTCORE_GRANT_TYPE').'&username='.getenv('WESTCORE_USERNAME').'&password='.getenv('WESTCORE_PASSWORD').'&integrationpartner='.getenv('WESTCORE_INTEGRATION_PARTNER');
        $logid = $this->CI->apiLogs->syncLogs($userdata['id'], 'westcor', 'create_token', getenv('WESTCORE_URL').$endPoint, $postData, array(), $orderNumber, 0);
        $result = $this->CI->westcor->make_request('POST', $endPoint, $postData, 1);
        $this->CI->apiLogs->syncLogs($userdata['id'], 'westcor', 'create_token', getenv('WESTCORE_URL').$endPoint, $postData, $result, $orderNumber, $logid);
        $resToken = json_decode($result, true);
        $groups = json_decode($resToken['groups'],true);
        if (!empty($resToken)) {
            $records = array(
                'token' => $resToken['access_token'], 
                'first_name' => $resToken['firstName'], 
                'last_name' => $resToken['lastName'], 
                'email' => $resToken['email'],
                'role' => $resToken['role'],
                'servername' =>$resToken['servername'],
                'create_token_time' => date('Y-m-d H:i:s'), 
                'expires_in' => $resToken['expires_in'],
                'original_agent_number' => $resToken['agentNumber'],
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            );
            $this->CI->db->replace('pct_order_westcore_token', $records); 
        }

        if($is_branch_update == 1) {
            $branchesData = array();
            foreach ($groups as $group) {
                $this->CI->db->select('*');
                $this->CI->db->from('pct_order_westcore_branches');
                $this->CI->db->like('city', $group['city'] != '.' ? $group['city'] : 'Other');
                $query = $this->CI->db->get();
                $result = $query->row_array();
                if(!empty($result)) {
                    $condition = array(
                        'city' => $result['city']
                    ); 
                    $branchData = array(
                        'agency_name' => $group['agencyName'],
                        'address' => $group['address'],
                        'state' => $group['state'], 
                        'zip' => $group['zip'], 
                        'phone' => $group['phone'], 
                        'agent_number' => $group['agentNumber'],
                        'is_proposed_branch' => ($group['city'] == 'Glendale' || $group['city'] == 'Orange' || $group['city'] == 'Oxnard' || $group['city'] == 'San Diego') ? 1 : 0,
                        'created_at' => date('Y-m-d H:i:s'),
                        'updated_at' => date('Y-m-d H:i:s')
                    ); 
                    $this->CI->db->update('pct_order_westcore_branches', $branchData, $condition);
                    $branchData['city'] =  $group['city'] != '.' ? $group['city'] : 'Other';
                    $branchData['id'] =  $result['id'] != '.' ? $group['city'] : 'Other';
                } else {
                    $branchData = array(
                        'agency_name' => $group['agencyName'],
                        'address' => $group['address'],
                        'city' => $group['city'] != '.' ? $group['city'] : 'Other',
                        'state' => $group['state'], 
                        'zip' => $group['zip'], 
                        'phone' => $group['phone'], 
                        'agent_number' => $group['agentNumber'],
                        'is_proposed_branch' => ($group['city'] == 'Glendale' || $group['city'] == 'Orange' || $group['city'] == 'Oxnard' || $group['city'] == 'San Diego') ? 1 : 0,
                        'created_at' => date('Y-m-d H:i:s'),
                        'updated_at' => date('Y-m-d H:i:s')
                    ); 
                    $insert_id = $this->CI->db->insert('pct_order_westcore_branches', $branchData); 
                    $branchData['id'] =  $insert_id;
                }
                $branchesData[] = $branchData;
            }
            return $branchesData;
        } else {
            if(!empty($resToken['access_token'])) {
                return array('token' => $resToken['access_token']);
            } else {
                return array('token' => '');
            }
        }
    }

    public function get_token($orderNumber)
    {
        $this->CI->db->select('*');
        $this->CI->db->from('pct_order_westcore_token');
        $query = $this->CI->db->get();
        $result = $query->row_array();
        if(!empty($result)) {
            $date = new DateTime($result['create_token_time']);
            $date2 = new DateTime(date('Y-m-d H:i:s'));
            $diff = $date2->getTimestamp() - $date->getTimestamp();
            if($diff < $result['expires_in']) {
                return $result;
            } else {
                $resToken = $this->createToken($orderNumber, 0);
                return $resToken;
            }
        } 
    }

    public function getBranches($id = 0)
    {
        $this->CI->db->select('*');
        $this->CI->db->from('pct_order_westcore_branches');
        if (!empty($id)) {
            $this->CI->db->where('id', $id);
        }
        $query = $this->CI->db->get();
        if($id == 0) {
            $result = $query->result_array();
        } else {
            $result = $query->row_array();
        }
        
        if(!empty($result)) {
            return $result;
        } else {
            return false;
        }
    }

    public function getBranchesFromApi()
    {
        $branchData = $this->createToken(0, 1);
        return $branchData;
    }
}
 