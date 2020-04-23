<?php

(defined('BASEPATH')) OR exit('No direct script access allowed');

class Cron extends MX_Controller {

    function __construct() 
    {
        parent::__construct();
        $this->load->library('session');
        $this->load->model('order/home_model');
    }

    public function import_orders_all_users()
    {
        $condition = array(
            'where' => array(
                'email_address' => 'ghernandez@pct.com',
            )
        );
        $customers = $this->home_model->get_customers($condition);
        if(!empty($customers)) {
            foreach ($customers as $customer) {
                $this->import_orders($customer);
            }
        }
        echo "All orders synced successfully for all users";exit;
    }

    function import_orders($user = array()) 
    {
        $this->load->library('order/resware');
        $this->load->model('order/apiLogs');

        if(empty($user)) {
            $userdata = $this->session->userdata('user');
        } else {
            $userdata = $user;
            $userdata['email'] = $userdata['email_address'];
        }
        
        $logid = $this->apiLogs->syncLogs($userdata['id'], 'resware', 'get_orders', RESWARE_ORDER_API.'files/search', array(), array(), 0, 0);
        $res = $this->make_request('POST', 'files/search', '',  $userdata);
        $this->apiLogs->syncLogs($userdata['id'], 'resware', 'get_orders', RESWARE_ORDER_API.'files/search', array(), $res, 0, $logid);
        $result = json_decode($res);

        $this->db->simple_query('SET SESSION group_concat_max_len=150000');
        $this->db->select('GROUP_CONCAT(file_id) as file_ids');
        $this->db->from('order_details');	
        $this->db->where('customer_id', $userdata['id']);
        $this->db->group_by('customer_id'); 
        $query = $this->db->get();
        $filesResult = $query->row_array();
        if (!empty($filesResult)) {
            $file_ids = explode(',', $filesResult['file_ids']);
        } else {
            $syncFlag = 0;
        }
   
        foreach($result->Files as $res) {
            if (!empty($file_ids)) {
                if (in_array((int)$res->FileID, $file_ids)) {
                    $syncFlag = 1;  
                } else {
                    $syncFlag = 0;  
                }
            } 
            if ($syncFlag == 0) {
                $FullProperty = $res->Properties[0]->StreetNumber." ".$res->Properties[0]->StreetName." ".$res->Properties[0]->StreetSuffix.", ".$res->Properties[0]->City.", ".$res->Properties[0]->State.", ".$res->Properties[0]->Zip;
                $primary_owner = ($res->Buyers[0]->Primary && $res->Buyers[0]->Primary->First) ? $res->Buyers[0]->Primary->First : '';
                $primary_owner .= ($res->Buyers[0]->Primary && $res->Buyers[0]->Primary->Last) ? " ".$res->Buyers[0]->Primary->Last : '';
                $secondary_owner = ($res->Buyers[0]->Secondary && $res->Buyers[0]->Secondary->First) ? $res->Buyers[0]->Secondary->First : '';
                $secondary_owner .= ($res->Buyers[0]->Secondary && $res->Buyers[0]->Secondary->Last) ? " ".$res->Buyers[0]->Secondary->Last : '';

                $propertyData = array(
                    'customer_id' => $userdata['id'],
                    'buyer_agent_id' => 0,
                    'listing_agent_id' => 0,
                    'escrow_lender_id' => 0,
                    'full_address' => $FullProperty,
                    'apn' => '',
                    'county' => $res->Properties[0]->County,
                    'legal_description' => $LegalDescription,
                    'primary_owner' => $primary_owner,
                    'secondary_owner' => $SecondaryOwner,
                    'additional_details'=> '',
                    'status'=> 1
                );

                $propertyId = $this->home_model->insert($propertyData,'property_details');

                $transactionData = array(
                    'customer_id' => $userdata['id'],
                    'sales_amount' =>  !empty($res->SalesPrice) ? $res->SalesPrice : 0,
                    'loan_number' => !empty($res->Loans[0]->LoanNumber) ? $res->Loans[0]->LoanNumber : 0,
                    'loan_amount' => !empty($res->Loans[0]->LoanAmount) ? $res->Loans[0]->LoanAmount : 0,
                    'transaction_type' => $res->TransactionProductType->TransactionTypeID,
                    'purchase_type' => $res->TransactionProductType->ProductTypeID,
                    'status'=> 1
                );
                $transactionId = $this->home_model->insert($transactionData,'transaction_details');

                $time = round((int)(str_replace("-0000)/", "", str_replace("/Date(", "",$res->Dates->OpenedDate)))/1000);

                $created_date = date('Y-m-d H:i:s', $time);

                $orderData = array(
                    'customer_id' => $userdata['id'],
                    'file_id' => $res->FileID,
                    'file_number' => $res->FileNumber,
                    'property_id' => $propertyId,
                    'transaction_id' => $transactionId,
                    'created_at' => $created_date,
                    'status'=> 1
                );

                $orderId = $this->home_model->insert($orderData,'order_details');

            }
        }
        echo "All orders synced successfully";
    }

    public function make_request($http_method, $endpoint, $body_params='', $userdata)
    {
        $login =  $userdata['email'];
        if ($userdata['email'] == 'ghernandez@pct.com') {
            $password= 'Alpha637#';
        } else {
            $password= 'Pacific2';
        }
        $ch = curl_init(RESWARE_ORDER_API.$endpoint);                                    
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $http_method);                        
        curl_setopt($ch, CURLOPT_POSTFIELDS, $body_params);                   
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
        curl_setopt($ch, CURLOPT_USERPWD, "$login:$password");
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(                                
            'Content-Type: application/json',
            'Content-Length: ' . strlen($body_params))                                 
        ); 
        $error_msg = curl_error($ch);
        $result = curl_exec($ch);
        return $result;
    }
}