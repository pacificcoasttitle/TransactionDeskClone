<?php

(defined('BASEPATH')) OR exit('No direct script access allowed');

class Cron extends MX_Controller {

    function __construct() 
    {
        parent::__construct();
        $this->load->library('session');
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
        foreach($result->Files as $res) {
           
            $FullProperty = $res->Properties[0]->StreetNumber.", ".$res->Properties[0]->StreetName." ".$res->Properties[0]->StreetSuffix.", ".$res->Properties[0]->City.", ".$res->Properties[0]->State.", ".$res->Properties[0]->Zip;
            if($res->Buyers[0]->Primary->First && )
            $propertyData = array(
                'customer_id' => $userdata['id'],
                'buyer_agent_id' => 0,
                'listing_agent_id' => 0,
                'escrow_lender_id' => 0,
                'full_address' => $FullProperty,
                'apn' => '',
                'county' => $res->Properties[0]->County,
                'legal_description' => $LegalDescription,
                'primary_owner' => $res->Properties[0]->StreetNumber,
                'secondary_owner' => $SecondaryOwner,
                'additional_details'=> $sendermessage,
                'status'=> 1
            );

            $propertyId = $this->home_model->insert($propertyData,'property_details');

            $orderData = array(
                'customer_id' => $customer_id,
                'file_id' => $res->FileID,
                'file_number' => $res->FileNumber,
                'property_id' => $propertyId,
                'status'=> 1
            );

            $orderId = $this->home_model->insert($orderData,'order_details');

            $transactionData = array(
                'customer_id' => $customer_id,
                'sales_representative' => $SalesRep,
                'title_officer' => $TitleOfficer,
                'sales_amount' => $SalesAmount,
                'loan_amount' => $LoanAmount,
                'transaction_type' => $TransactionTypeID,
                'purchase_type' => $ProductTypeID,
                'is_ccr' => $CCR,
                'is_underlying_docs' => $Docs,
                'is_plotted_easements' => $Ease,
                'status'=> 1
            );

            $transactionId = $this->home_model->insert($transactionData,'transaction_details');
        }
    }
}