<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');


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

    public function is_hr_admin()
    {
        $userdata = $this->CI->session->userdata('hr_admin');
        if (!empty($userdata['id']) && $userdata['is_hr_admin'] == 1) {
            return true;
        } else {
            redirect(base_url().'hr/admin');
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

    public function is_user()
    {
        $userdata = $this->CI->session->userdata('hr_user');
        if (empty($userdata)) {
            redirect(base_url().'hr/login');
        } 
    }

    public function is_manager_user()
    {
        $userdata = $this->CI->session->userdata('hr_user');
        if (!empty($userdata['id']) && $userdata['user_type_id'] == 2) {
            return true;
        } else {
            redirect(base_url().'hr/dashboard');
        }
    }

    public function is_employee_user()
    {
        $userdata = $this->CI->session->userdata('hr_user');
        if (!empty($userdata['id']) && $userdata['user_type_id'] == 1) {
            return true;
        } else {
            redirect(base_url().'hr/dashboard');
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

    public function getAllUsers() 
    {
        $this->CI->db->select('*');
        $this->CI->db->where('status', 1);
        $query = $this->CI->db->get('pct_hr_users');
        if ($query->num_rows() > 0)  {
            return $query->result_array();
        } else {
            return array();
        }
    }

    public function getMemoInfo($id) 
    {
        $this->CI->db->select('pct_hr_memos.*, admin.user_name');
        $this->CI->db->from('pct_hr_memos')
            ->join('admin', 'admin.id = pct_hr_memos.created_by');
        $this->CI->db->where('pct_hr_memos.id', $id);
        $this->CI->db->where('pct_hr_memos.status', 1);
        $query = $this->CI->db->get();
        if ($query->num_rows() > 0)  {
            return $query->row_array();
        } else {
            return array();
        }
    }
}
