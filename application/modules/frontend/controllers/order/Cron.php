<?php

(defined('BASEPATH')) OR exit('No direct script access allowed');

class Cron extends MX_Controller {

    function __construct() 
    {
        parent::__construct();
        $this->load->library('session');
        $this->load->model('order/home_model');
    }

    function import_orders() 
    {
        $this->load->library('order/resware');
        $this->load->model('order/apiLogs');
        $userdata = $this->session->userdata('user');
        $logid = $this->apiLogs->syncLogs($userdata['id'], 'resware', 'get_orders', RESWARE_ORDER_API.'files/search', array(), array(), 0, 0);
        $res = $this->resware->make_request('POST', 'files/search');
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
                $FullProperty = $res->Properties[0]->StreetNumber.", ".$res->Properties[0]->StreetName." ".$res->Properties[0]->StreetSuffix.", ".$res->Properties[0]->City.", ".$res->Properties[0]->State.", ".$res->Properties[0]->Zip;
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
                    'sales_amount' =>  $res->SalesPrice,
                    'loan_amount' => $res->Loans[0]->LoanAmount,
                    'transaction_type' => $res->TransactionProductType->TransactionTypeID,
                    'purchase_type' => $res->TransactionProductType->ProductTypeID,
                    'status'=> 1
                );
                $transactionId = $this->home_model->insert($transactionData,'transaction_details');

                $orderData = array(
                    'customer_id' => $userdata['id'],
                    'file_id' => $res->FileID,
                    'file_number' => $res->FileNumber,
                    'property_id' => $propertyId,
                    'transaction_id' => $transactionId,
                    'status'=> 1
                );

                $orderId = $this->home_model->insert($orderData,'order_details');

            }
        }
        echo "All orders synced successfully";
    }
}