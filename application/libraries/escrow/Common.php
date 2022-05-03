<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

use ElephantIO\Client;
use ElephantIO\Engine\SocketIO\Version1X;

class Common 
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

    public function insert($data = array(), $table) 
    {
        if (!empty($data)) {
        	$data['created_at'] = date("Y-m-d H:i:s");
            $insert = $this->CI->db->insert($table, $data);
            return $insert ? $this->CI->db->insert_id() : false;
        }
        return false;
    }

    public function update($data, $condition = array(), $table) 
    {
        if (!empty($data)) {          
            $data['updated_at'] = date("Y-m-d H:i:s");
            $update = $this->CI->db->update($table, $data, $condition);
            return $update ? true : false;
        }
        return false;
    }

    public function is_escrow_admin()
    {
        $userdata = $this->CI->session->userdata('escrow_admin');
        if (!empty($userdata['id']) && ($userdata['is_escrow_manager'] == 1 || $userdata['is_escrow_officer'] == 1 || $userdata['is_escrow_assistant'] == 1)) {
            return true;
        } else {
            redirect(base_url().'escrow/admin');
        }
    }

    public function randomPassword() 
    {
        $len = 8;
        $sets = array();
        $sets[] = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $sets[] = 'abcdefghijkmnopqrstuvwxyz';
        $sets[] = '0123456789';
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

    public function is_escrow_user()
    {
        $userdata = $this->CI->session->userdata('escrow_user');
        if (empty($userdata)) {
            redirect(base_url().'escrow/login');
        } 
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

    public function sendNotification($message, $type, $sent_to_user, $is_sent_admin = 0)
    {
        if ($is_sent_admin == 1) {
            $channel = 'admin-channel-'.$sent_to_user;
            $event = 'admin-event-'.$sent_to_user;
        }

        if ($is_sent_admin == 0) {
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
    
    public function get_escrow_user($params = array()) 
    {
        $this->CI->db->select('pct_hr_users.*,pct_hr_user_types.name as user_type');
        $this->CI->db->from('pct_hr_users');
        $this->CI->db->join('pct_hr_position', 'pct_hr_position.id = pct_hr_users.position_id');
        $this->CI->db->join('pct_hr_user_types','pct_hr_users.user_type_id = pct_hr_user_types.id');
        $this->CI->db->where('pct_hr_users.department_id', 4);
        foreach($params as $key => $val){
            $this->CI->db->where('pct_hr_users.'.$key, $val);
        }
        $query = $this->CI->db->get();
        //echo $this->CI->db->last_query();exit;
        $result = $query->row_array();
        if(!empty($result)) { 
            return $result;
        } else {
            return array();
        }   
    }

    public function getUsers($params)
    {
        $this->CI->db->from('pct_hr_users')
                 ->join('pct_hr_position', 'pct_hr_position.id = pct_hr_users.position_id')
                 ->join('pct_hr_user_types', 'pct_hr_user_types.id = pct_hr_users.user_type_id')
                 ->join('pct_hr_branches', 'pct_hr_branches.id = pct_hr_users.branch_id')
                 ->join('pct_hr_departments', 'pct_hr_departments.id = pct_hr_users.department_id');
        $this->CI->db->where('pct_hr_users.status', 1);
        $this->CI->db->where('pct_hr_users.department_id', 4);
        $total_records =  $this->CI->db->count_all_results();
		$limit = isset($params['length']) && !empty($params['length']) ? $params['length'] : '';
        $offset = isset($params['start']) && !empty($params['start']) ? $params['start'] : '';
        $users = array();

    	if (isset($params['searchvalue']) && !empty($params['searchvalue'])) {
    		$keyword = $params['searchvalue'];

    		if (isset($keyword) && !empty($keyword)) {
                $this->CI->db->group_start()
                        ->like('pct_hr_users.first_name', $keyword)
                        ->or_like('pct_hr_users.last_name', $keyword)
                        ->or_like('pct_hr_users.email', $keyword)
                        ->or_like('pct_hr_users.hire_date', $keyword)
                        ->or_like('pct_hr_position.name', $keyword)
                        ->or_like('pct_hr_user_types.name', $keyword)
                        ->or_like('pct_hr_departments.name', $keyword)
                        ->group_end();
            }
            
            $this->CI->db->from('pct_hr_users')
                 ->join('pct_hr_position', 'pct_hr_position.id = pct_hr_users.position_id')
                 ->join('pct_hr_user_types', 'pct_hr_user_types.id = pct_hr_users.user_type_id')
                 ->join('pct_hr_branches', 'pct_hr_branches.id = pct_hr_users.branch_id')
                 ->join('pct_hr_departments', 'pct_hr_departments.id = pct_hr_users.department_id', 'left');
            $this->CI->db->where('pct_hr_users.status', 1);
            $this->CI->db->where('pct_hr_users.department_id', 4);
            if(!empty($usersIds)) {
                $this->CI->db->where_in('pct_hr_users.id', $usersIds);
            } 
			$filter_total_records =  $this->CI->db->count_all_results();

			if (isset($keyword) && !empty($keyword)) {
                $this->CI->db->group_start()
                        ->like('pct_hr_users.first_name', $keyword)
                        ->or_like('pct_hr_users.last_name', $keyword)
                        ->or_like('pct_hr_users.email', $keyword)
                        ->or_like('pct_hr_users.hire_date', $keyword)
                        ->or_like('pct_hr_position.name', $keyword)
                        ->or_like('pct_hr_user_types.name', $keyword)
                        ->or_like('pct_hr_departments.name', $keyword)
                        ->group_end();
            }

            $this->CI->db->select('pct_hr_users.*, pct_hr_position.name as position, pct_hr_user_types.name, pct_hr_departments.name as department_name, pct_hr_branches.name as branch_name');
            $this->CI->db->from('pct_hr_users')
                    ->join('pct_hr_position', 'pct_hr_position.id = pct_hr_users.position_id')
                    ->join('pct_hr_user_types', 'pct_hr_user_types.id = pct_hr_users.user_type_id')
                    ->join('pct_hr_branches', 'pct_hr_branches.id = pct_hr_users.branch_id')
                    ->join('pct_hr_departments', 'pct_hr_departments.id = pct_hr_users.department_id', 'left');
            $this->CI->db->where('pct_hr_users.status', 1);
            $this->CI->db->where('pct_hr_users.department_id', 4);
            if(!empty($usersIds)) {
                $this->CI->db->where_in('pct_hr_users.id', $usersIds);
            } 
            $this->CI->db->order_by('pct_hr_users.id', 'desc');

            if ((isset($limit) && !empty($limit)) || (isset($offset) && !empty($offset))) {
                $this->CI->db->limit($limit, $offset);
            }	

			$query = $this->CI->db->get();
			if ($query->num_rows() > 0) {
	            $users = $query->result_array();
	        }
    	} else {    		
            $filter_total_records =  $total_records;
            $this->CI->db->select('pct_hr_users.*, pct_hr_position.name as position,  pct_hr_user_types.name, pct_hr_departments.name as department_name, pct_hr_branches.name as branch_name');
            $this->CI->db->from('pct_hr_users')
                    ->join('pct_hr_position', 'pct_hr_position.id = pct_hr_users.position_id')
                    ->join('pct_hr_user_types', 'pct_hr_user_types.id = pct_hr_users.user_type_id')
                    ->join('pct_hr_branches', 'pct_hr_branches.id = pct_hr_users.branch_id')
                    ->join('pct_hr_departments', 'pct_hr_departments.id = pct_hr_users.department_id', 'left');
            $this->CI->db->where('pct_hr_users.status', 1);
            $this->CI->db->where('pct_hr_users.department_id', 4);
            if(!empty($usersIds)) {
                $this->CI->db->where_in('pct_hr_users.id', $usersIds);
            } 
            $this->CI->db->order_by('pct_hr_users.id', 'desc');

			if ((isset($limit) && !empty($limit)) || (isset($offset) && !empty($offset))) {
                $this->CI->db->limit($limit, $offset);
            }

			$query = $this->CI->db->get();
			if ($query->num_rows() > 0) {
	            $users = $query->result_array();
	        } 
    	}

    	return array(
            'recordsTotal' => $total_records,
            'recordsFiltered' => $filter_total_records,
            'data' => $users
        );
    }

    public function getEscrowOfficerInfoFromOrder($email)
    {
        $this->CI->db->select('*');
        $this->CI->db->from('pct_order_partner_company_info');
        $this->CI->db->where('email', $email);
        $this->CI->db->where('status', 1);
        $query = $this->CI->db->get();    
        return $query->row_array();
    }

    

    public function getEscrowOfficerInfoFromOrderForAssistant($branch_id)
    {
        $this->CI->db->select('*');
        $this->CI->db->from('pct_hr_users');
        $this->CI->db->where('branch_id', $branch_id);
        $this->CI->db->where('(position_id = 9 or position_id = 22 or position_id = 23)');
        $this->CI->db->where('department_id', 4);
        $this->CI->db->where('status', 1);
        $query = $this->CI->db->get();    
        $escroeUsers = $query->result_array();
        $escrowEmails = array_column($escroeUsers, 'email');

        $this->CI->db->select('*');
        $this->CI->db->from('pct_order_partner_company_info');
        $this->CI->db->where_in('email', $escrowEmails);
        $this->CI->db->where('status', 1);
        $query = $this->CI->db->get();    
        return $query->result_array();
    }

    public function getOrders($params)
    {
        $userdata = $this->CI->session->userdata('escrow_admin'); 
        $orders_lists = array();
        if ($userdata['is_escrow_officer'] == 1) {    
            $escrowOfficerInfo = $this->getEscrowOfficerInfoFromOrder($userdata['email']);
        }

        if ($userdata['is_escrow_assistant'] == 1) {  
            $escrowOfficersInfo = $this->getEscrowOfficerInfoFromOrderForAssistant($userdata['branch_id']);
        }

        $this->CI->db->from('order_details')
                ->join('property_details', 'order_details.property_id = property_details.id')
                ->join('transaction_details','order_details.transaction_id = transaction_details.id')
                ->join('pct_order_product_types', 'transaction_details.purchase_type = pct_order_product_types.product_type_id AND pct_order_product_types.status=1');
        $this->CI->db->where('(transaction_details.purchase_type = 2 or transaction_details.purchase_type = 3 or transaction_details.purchase_type = 4 or transaction_details.purchase_type = 5 or transaction_details.purchase_type = 36)');

        if ($userdata['is_escrow_officer'] == 1) {
            if (!empty($escrowOfficerInfo)) {
                $this->CI->db->where('order_details.escrow_officer_id', $escrowOfficerInfo['partner_id']);   
            } else {
                return array(
                    'recordsTotal' => 0,
                    'recordsFiltered' => 0,
                    'data' => $orders_lists
                );
            }
        }

        if ($userdata['is_escrow_assistant'] == 1) {
            if (!empty($escrowOfficersInfo)) {
                $escrowUserIds = array_column($escrowOfficersInfo, 'partner_id');
                $this->CI->db->where_in('order_details.escrow_officer_id', $escrowUserIds);   
            } else {
                return array(
                    'recordsTotal' => 0,
                    'recordsFiltered' => 0,
                    'data' => $orders_lists
                );
            }
        }

        $total_records =  $this->CI->db->count_all_results();
		$limit = isset($params['length']) && !empty($params['length']) ? $params['length'] : '';
        $offset = isset($params['start']) && !empty($params['start']) ? $params['start'] : '';
        
        $select = 'order_details.prelim_summary_id, order_details.created_at as opened_date, order_details.file_number, order_details.file_id,property_details.full_address,order_details.id, order_details.westcor_order_id, order_details.westcor_file_id, order_details.westcor_cpl_id, property_details.escrow_lender_id, order_details.is_regenerate_cpl, order_details.cpl_document_name,
            order_details.created_at, order_details.resware_status, order_details.proposed_insured_document_name, order_details.is_payoff_generated,property_details.primary_owner, pct_order_product_types.product_type';

        if(isset($params['searchvalue']) && !empty($params['searchvalue'])) {
            $keyword = $params['searchvalue'];

            if (isset($keyword) && !empty($keyword)) {
                $this->CI->db->group_start()
                    ->like('property_details.full_address', $keyword)         
                    ->or_like('order_details.file_number', $keyword) 
                    ->or_like('order_details.created_at', date("Y-m-d", strtotime($keyword)))
                    ->or_like('order_details.resware_status', $keyword)
                ->group_end();
            } 

            $this->CI->db->select($select)
                ->from('order_details')
                ->join('property_details', 'order_details.property_id = property_details.id')
                ->join('transaction_details','order_details.transaction_id = transaction_details.id')
                ->join('pct_order_product_types', 'transaction_details.purchase_type = pct_order_product_types.product_type_id AND pct_order_product_types.status=1');

            $this->CI->db->where('(transaction_details.purchase_type = 2 or transaction_details.purchase_type = 3 or transaction_details.purchase_type = 4 or transaction_details.purchase_type = 5 or transaction_details.purchase_type = 36)');

            if ($userdata['is_escrow_officer'] == 1) {
                if (!empty($escrowOfficerInfo)) {
                    $this->CI->db->where('order_details.escrow_officer_id', $escrowOfficerInfo['partner_id']);    
                }
            }
    
            if ($userdata['is_escrow_assistant'] == 1) {
                if (!empty($escrowOfficersInfo)) {
                    $escrowUserIds = array_column($escrowOfficersInfo, 'partner_id');
                    $this->CI->db->where_in('order_details.escrow_officer_id', $escrowUserIds);   
                } 
            }
    
            $filter_total_records =  $this->CI->db->count_all_results();
            
            if (isset($keyword) && !empty($keyword)) {
                $this->CI->db->group_start()
                    ->like('property_details.full_address', $keyword)         
                    ->or_like('order_details.file_number', $keyword) 
                    ->or_like('order_details.created_at', date("Y-m-d", strtotime($keyword)))
                    ->or_like('order_details.resware_status', $keyword)
                ->group_end();
            } 

            $this->CI->db->select($select)
                ->from('order_details')
                ->join('property_details', 'order_details.property_id = property_details.id')
                ->join('transaction_details','order_details.transaction_id = transaction_details.id')
                ->join('pct_order_product_types', 'transaction_details.purchase_type = pct_order_product_types.product_type_id AND pct_order_product_types.status=1');

            $this->CI->db->where('(transaction_details.purchase_type = 2 or transaction_details.purchase_type = 3 or transaction_details.purchase_type = 4 or transaction_details.purchase_type = 5 or transaction_details.purchase_type = 36)');

            if ($userdata['is_escrow_officer'] == 1) {
                if (!empty($escrowOfficerInfo)) {
                    $this->CI->db->where('order_details.escrow_officer_id', $escrowOfficerInfo['partner_id']);    
                }
            }
    
            if ($userdata['is_escrow_assistant'] == 1) {
                if (!empty($escrowOfficersInfo)) {
                    $escrowUserIds = array_column($escrowOfficersInfo, 'partner_id');
                    $this->CI->db->where_in('order_details.escrow_officer_id', $escrowUserIds);   
                } 
            }
            $this->CI->db->order_by("order_details.id", "desc");
           
            if ((isset($limit) && !empty($limit)) || (isset($offset) && !empty($offset))) {
                $this->CI->db->limit($limit, $offset);
            }

            $query = $this->CI->db->get();
            //echo $this->CI->db->last_query();exit;
            if ($query->num_rows() > 0)  {
                $orders_lists = $query->result_array();
            }
        } else {

            $filter_total_records =  $total_records;
            $this->CI->db->select($select)
                ->from('order_details')
                ->join('property_details', 'order_details.property_id = property_details.id')
                ->join('transaction_details','order_details.transaction_id = transaction_details.id')
                ->join('pct_order_product_types', 'transaction_details.purchase_type = pct_order_product_types.product_type_id AND pct_order_product_types.status=1');

            $this->CI->db->where('(transaction_details.purchase_type = 2 or transaction_details.purchase_type = 3 or transaction_details.purchase_type = 4 or transaction_details.purchase_type = 5 or transaction_details.purchase_type = 36)');
            if ($userdata['is_escrow_officer'] == 1) {
                if (!empty($escrowOfficerInfo)) {
                    $this->CI->db->where('order_details.escrow_officer_id', $escrowOfficerInfo['partner_id']);    
                }
            }
    
            if ($userdata['is_escrow_assistant'] == 1) {
                if (!empty($escrowOfficersInfo)) {
                    $escrowUserIds = array_column($escrowOfficersInfo, 'partner_id');
                    $this->CI->db->where_in('order_details.escrow_officer_id', $escrowUserIds);   
                } 
            }
            $this->CI->db->order_by("order_details.id", "desc");
        
            if ((isset($limit) && !empty($limit)) || (isset($offset) && !empty($offset))) {
                $this->CI->db->limit($limit, $offset);
            }
            $query = $this->CI->db->get();
            //echo $this->CI->db->last_query();exit;
            if ($query->num_rows() > 0)  {
                $orders_lists = $query->result_array();
            } 
        }
        
    	return array(
            'recordsTotal' => $total_records,
            'recordsFiltered' => $filter_total_records,
            'data' => $orders_lists
        );
    }

    public function getTasks($params)
    {
        $this->CI->db->from('pct_escrow_tasks');
        $this->CI->db->where('pct_escrow_tasks.status', 1);
        $total_records =  $this->CI->db->count_all_results();
		$limit = isset($params['length']) && !empty($params['length']) ? $params['length'] : '';
        $offset = isset($params['start']) && !empty($params['start']) ? $params['start'] : '';
        $tasks = array();

    	if (isset($params['searchvalue']) && !empty($params['searchvalue'])) {
    		$keyword = $params['searchvalue'];

    		if (isset($keyword) && !empty($keyword)) {
                $this->CI->db->group_start()
                    ->like('pct_escrow_tasks.name', $keyword)
                    ->or_like('pct_escrow_tasks.prod_type', $keyword)
                    ->group_end();
            }
            
            $this->CI->db->from('pct_escrow_tasks');
            $this->CI->db->where('pct_escrow_tasks.status', 1);
			$filter_total_records =  $this->CI->db->count_all_results();

			if (isset($keyword) && !empty($keyword)) {
                $this->CI->db->group_start()
                    ->like('pct_escrow_tasks.name', $keyword)
                    ->or_like('pct_escrow_tasks.prod_type', $keyword)
                    ->group_end();
            }

            $this->CI->db->select('pct_escrow_tasks.*');
            $this->CI->db->from('pct_escrow_tasks');
            $this->CI->db->where('pct_escrow_tasks.status', 1);
            $this->CI->db->order_by('pct_escrow_tasks.id', 'asc');

            if ((isset($limit) && !empty($limit)) || (isset($offset) && !empty($offset))) {
                $this->CI->db->limit($limit, $offset);
            }	

			$query = $this->CI->db->get();
			if ($query->num_rows() > 0) {
	            $tasks = $query->result_array();
	        }
    	} else {    		
    		$this->CI->db->from('pct_escrow_tasks');
            $this->CI->db->where('pct_escrow_tasks.status', 1);
            $filter_total_records =  $this->CI->db->count_all_results();

            $this->CI->db->select('pct_escrow_tasks.*');
            $this->CI->db->from('pct_escrow_tasks');
            $this->CI->db->where('pct_escrow_tasks.status', 1);
            $this->CI->db->order_by('pct_escrow_tasks.id', 'asc');

			if ((isset($limit) && !empty($limit)) || (isset($offset) && !empty($offset))) {
                $this->CI->db->limit($limit, $offset);
            }

			$query = $this->CI->db->get();
			if ($query->num_rows() > 0) {
	            $tasks = $query->result_array();
	        } 
    	}

    	return array(
            'recordsTotal' => $total_records,
            'recordsFiltered' => $filter_total_records,
            'data' => $tasks
        );
    }

}
