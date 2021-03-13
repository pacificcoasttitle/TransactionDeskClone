<?php
class Order_model extends CI_Model 
{

    function __construct() {
        // Set table name
        $this->table = 'order_details';
    }
    

    public function get_orders($params)
    {
        $sales_rep = isset($params['sales_rep']) && !empty($params['sales_rep']) ? $params['sales_rep'] : '';

        $product_type = isset($params['product_type']) && !empty($params['product_type']) ? $params['product_type'] : '';

        if(isset($sales_rep) && !empty($sales_rep))
        {
            $this->db->where('transaction_details.sales_representative', $sales_rep);
        }

        if(isset($product_type) && !empty($product_type))
        {
            $this->db->like('pct_order_product_types.product_type', $product_type);
        }

        $created_by = isset($params['created_by']) && !empty($params['created_by']) ? $params['created_by'] : '';
        if(isset($created_by) && !empty($created_by))
        {
            $this->db->where('order_details.created_by', $created_by);
        }
        if(isset($params['searchValue']) && !empty($params['searchValue']))
        {
            $keyword = $params['searchValue'];

            if(isset($keyword) && !empty($keyword))
            {
                $this->db->where("(property_details.full_address LIKE '%".$keyword."%' OR order_details.file_number LIKE '%".$keyword."%')");
            }
            
            $this->db->select('order_details.file_number, order_details.file_id,property_details.full_address,order_details.id,transaction_details.sales_representative,transaction_details.purchase_type, CONCAT(cbd.first_name, " ", cbd.last_name) as sales_rep_name,pct_order_product_types.product_type, customer_basic_details.first_name, customer_basic_details.last_name,order_details.created_at')
            ->from('order_details')
            ->join('customer_basic_details', 'customer_basic_details.id = order_details.created_by')
            ->join('property_details', 'order_details.property_id = property_details.id')
            ->join('transaction_details', 'order_details.transaction_id = transaction_details.id')
            ->join('customer_basic_details as cbd', 'transaction_details.sales_representative = cbd.id', 'left')
            ->join('pct_order_product_types', 'transaction_details.purchase_type = pct_order_product_types.product_type_id AND pct_order_product_types.status=1')
            ->where('is_imported=0');
            $total_records =  $this->db->count_all_results();
            if(isset($sales_rep) && !empty($sales_rep))
            {
                $this->db->where('transaction_details.sales_representative', $sales_rep);

            }
            if(isset($product_type) && !empty($product_type))
            {
                $this->db->like('pct_order_product_types.product_type', $product_type);
            }
            $created_by = isset($params['created_by']) && !empty($params['created_by']) ? $params['created_by'] : '';
            if(isset($created_by) && !empty($created_by))
            {
                $this->db->where('order_details.created_by', $created_by);
            }
            if(isset($keyword) && !empty($keyword))
            {
                $this->db->where("(property_details.full_address LIKE '%".$keyword."%' OR order_details.file_number LIKE '%".$keyword."%')");
            }
            
            $limit = isset($params['length']) && !empty($params['length']) ? $params['length'] : '';
            $offset = isset($params['start']) && !empty($params['start']) ? $params['start'] : '';
            $orders_lists = array();
           
            $this->db->select('order_details.file_number, order_details.file_id,property_details.full_address,order_details.id,transaction_details.sales_representative,transaction_details.purchase_type,CONCAT(cbd.first_name, " ", cbd.last_name) as sales_rep_name,pct_order_product_types.product_type, customer_basic_details.first_name, customer_basic_details.last_name,order_details.created_at')
            ->from('order_details')
            ->join('customer_basic_details', 'customer_basic_details.id = order_details.created_by')
            ->join('property_details', 'order_details.property_id = property_details.id')
            ->join('transaction_details', 'order_details.transaction_id = transaction_details.id')
            ->join('customer_basic_details as cbd', 'transaction_details.sales_representative = cbd.id', 'left')
            ->join('pct_order_product_types', 'transaction_details.purchase_type = pct_order_product_types.product_type_id AND pct_order_product_types.status=1')
            ->where('is_imported=0');
            $this->db->order_by("order_details.id", "desc");

            if ((isset($limit) && !empty($limit)) || (isset($offset) && !empty($offset))) {
                $this->db->limit($limit, $offset);
            }

            $query = $this->db->get();

            if ($query->num_rows() > 0)  {
                $orders_lists = $query->result_array();
            }
        }
        else
        {
            if(isset($sales_rep) && !empty($sales_rep))
            {
                $this->db->where('transaction_details.sales_representative', $sales_rep);
            }

            if(isset($product_type) && !empty($product_type))
            {
                $this->db->like('pct_order_product_types.product_type', $product_type);
            }
            $created_by = isset($params['created_by']) && !empty($params['created_by']) ? $params['created_by'] : '';
            if(isset($created_by) && !empty($created_by))
            {
                $this->db->where('order_details.created_by', $created_by);
            }
            $this->db->select('order_details.file_number, order_details.file_id,property_details.full_address,order_details.id,transaction_details.sales_representative,transaction_details.purchase_type,CONCAT(cbd.first_name, " ", cbd.last_name) as sales_rep_name,pct_order_product_types.product_type, customer_basic_details.first_name, customer_basic_details.last_name,order_details.created_at')
            ->from('order_details')
            ->join('customer_basic_details', 'customer_basic_details.id = order_details.created_by')
            ->join('property_details', 'order_details.property_id = property_details.id')
            ->join('transaction_details', 'order_details.transaction_id = transaction_details.id')
            ->join('customer_basic_details as cbd', 'transaction_details.sales_representative = cbd.id', 'left')
            ->join('pct_order_product_types', 'transaction_details.purchase_type = pct_order_product_types.product_type_id AND pct_order_product_types.status=1')
            ->where('is_imported=0');
       
            $total_records =  $this->db->count_all_results();
           
            $limit = isset($params['length']) && !empty($params['length']) ? $params['length'] : '';
            $offset = isset($params['start']) && !empty($params['start']) ? $params['start'] : '';
            $orders_lists = array();
            if(isset($sales_rep) && !empty($sales_rep))
            {
                $this->db->where('transaction_details.sales_representative', $sales_rep);
            }
            if(isset($product_type) && !empty($product_type))
            {
                $this->db->like('pct_order_product_types.product_type', $product_type);
            }
            $created_by = isset($params['created_by']) && !empty($params['created_by']) ? $params['created_by'] : '';
            if(isset($created_by) && !empty($created_by))
            {
                $this->db->where('order_details.created_by', $created_by);
            }
            
            $this->db->select('order_details.file_number, order_details.file_id,property_details.full_address,order_details.id,transaction_details.sales_representative,transaction_details.purchase_type,CONCAT(cbd.first_name, " ", cbd.last_name) as sales_rep_name,pct_order_product_types.product_type, customer_basic_details.first_name, customer_basic_details.last_name,order_details.created_at')
            ->from('order_details')
            ->join('customer_basic_details', 'customer_basic_details.id = order_details.created_by')
            ->join('property_details', 'order_details.property_id = property_details.id')
            ->join('transaction_details', 'order_details.transaction_id = transaction_details.id')
            ->join('customer_basic_details as cbd', 'transaction_details.sales_representative = cbd.id', 'left')
            ->join('pct_order_product_types', 'transaction_details.purchase_type = pct_order_product_types.product_type_id AND pct_order_product_types.status=1')
            ->where('is_imported=0');

            $this->db->order_by("order_details.id", "desc");

            if ((isset($limit) && !empty($limit)) || (isset($offset) && !empty($offset))) {
                $this->db->limit($limit, $offset);
            }

            $query = $this->db->get();

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

    public function update($data, $condition = array()) 
    {
        $table = $this->table;

        if(!empty($data))
        {          
            
            $data['updated_at'] = date("Y-m-d H:i:s");

            // Update data
            $update = $this->db->update($table, $data, $condition);
            
            // Return the status
            return $update?true:false;
        }
        return false;
    }

    public function insert($data = array()) 
    {
        $table = $this->table;
        if(!empty($data)){

            $data['created_at'] = date("Y-m-d H:i:s");

            // Insert data
            $insert = $this->db->insert($table, $data);
            
            // Return the status
            return $insert?$this->db->insert_id():false;
        }
        return false;
    }

    public function get_order_details($fileId)
    {
        $this->db->select('order_details.file_number, 
            order_details.customer_id,
            order_details.id as order_id,
            order_details.file_id,
            order_details.created_at as opened_date, 
            property_details.id as property_id, 
            property_details.address, 
            property_details.full_address, 
            property_details.apn, 
            property_details.property_type, 
            property_details.city as property_city, 
            property_details.state as property_state, 
            property_details.zip as property_zip, 
            property_details.county,
            property_details.legal_description, 
            property_details.primary_owner,
            property_details.secondary_owner,
            transaction_details.id as transaction_id,
            transaction_details.sales_representative,
            CONCAT(cbd.first_name, " ", cbd.last_name) as sales_rep_name,
            transaction_details.title_officer,
            pct_order_title_officer.name as title_officer_name,
            transaction_details.sales_amount,
            transaction_details.loan_amount,
            transaction_details.loan_number,
            transaction_details.escrow_number,
            transaction_details.notes,
            transaction_details.transaction_type, 
            transaction_details.title_officer,
            transaction_details.purchase_type,
            pct_order_product_types.product_type,
            transaction_details.supplemental_report_date,
            transaction_details.preliminary_report_date,
            transaction_details.borrower, 
            CONCAT_WS(",",transaction_details.additional_email,transaction_details.additional_email_1,transaction_details.additional_email_2) as additional_emails,
            transaction_details.additional_email,
            transaction_details.additional_email_1,
            transaction_details.additional_email_2,
            transaction_details.secondary_borrower,
            property_details.escrow_lender_id,
            customer_basic_details.company_name as escrow_lender_company_name,
            customer_basic_details.first_name as escrow_lender_first_name,
            customer_basic_details.last_name as escrow_lender_last_name,
            customer_basic_details.email_address as escrow_lender_email,
            customer_basic_details.telephone_no as escrow_lender_telephone_no,
            property_details.buyer_agent_id,
            agents.name as buyer_agent_name,
            agents.email_address as buyer_agent_email_address,
            agents.company as buyer_agent_company,
            agents.telephone_no as buyer_agent_telephone_no,
            property_details.listing_agent_id,
            a.name as listing_agent_name,
            a.email_address as listing_agent_email_address,
            a.company as listing_agent_company,
            a.telephone_no as listing_agent_telephone_no')
            ->from('order_details')
            ->join('property_details', 'order_details.property_id = property_details.id')
            ->join('transaction_details', 'order_details.transaction_id = transaction_details.id')
            ->join('customer_basic_details', 'property_details.escrow_lender_id = customer_basic_details.id', 'left')
            ->join('agents', 'property_details.buyer_agent_id = agents.id', 'left')
            ->join('agents a', 'property_details.listing_agent_id = a.id', 'left')
            ->join('pct_order_fnf_agents', 'order_details.fnf_agent_id = pct_order_fnf_agents.id', 'left')
            ->join('customer_basic_details as cbd', 'transaction_details.sales_representative = cbd.id', 'left')
            ->join('pct_order_title_officer', 'transaction_details.title_officer = pct_order_title_officer.id')
            ->join('pct_order_product_types', 'transaction_details.purchase_type = pct_order_product_types.product_type_id AND pct_order_product_types.status=1');
        $this->db->where('file_id', $fileId);
         
        
        $query = $this->db->get();
        
        return $query->row_array();
    }

    public function get_order_count()
    {
        $this->db->select('COUNT(*) AS total,
            (
                CASE
                  WHEN pct_order_product_types.product_type LIKE "%Loan:%"
                  THEN "Loan"
                  WHEN pct_order_product_types.product_type LIKE "%Sale:%" 
                  THEN "Sale" 
                END
            ) AS type')
        ->from('order_details')
        ->join('transaction_details', 'order_details.transaction_id = transaction_details.id')
        ->join('pct_order_product_types', 'transaction_details.purchase_type = pct_order_product_types.product_type_id AND pct_order_product_types.status=1')
        ->where('is_imported=0')
        ->group_by('(
                        CASE
                          WHEN pct_order_product_types.product_type LIKE "%Loan:%"
                          THEN "Loan"
                          WHEN pct_order_product_types.product_type LIKE "%Sale:%" 
                          THEN "Sale" 
                        END
                    )');

        $query = $this->db->get();
        $orders_data = array();
        if ($query->num_rows() > 0)  
        {
            $orders_data = $query->result_array();         
        }

        return $orders_data;
    }

    public function get_title_point_count()
    { 
        $this->db->group_start()
            ->where('lv_file_status !=', 'success')
            ->or_where('lv_file_status is null')
        ->group_end();

        $this->db->where('file_id IS NOT NULL');
        $this->db->from('pct_order_title_point_data');

        $lv_total_records =  $this->db->count_all_results();

        $this->db->group_start()
            ->where('grant_deed_status !=', 'ok')
            ->or_where('grant_deed_status is null')
        ->group_end();

        $this->db->where('file_id IS NOT NULL');
        $this->db->from('pct_order_title_point_data');

        $grant_deed_total_records =  $this->db->count_all_results();


        $this->db->group_start()
            ->where('tax_file_status !=', 'success')
            ->or_where('tax_file_status is null')
        ->group_end();

        $this->db->where('file_id IS NOT NULL');
        $this->db->from('pct_order_title_point_data');

        $tax_total_records =  $this->db->count_all_results();

        return array(
            'lv_total_records' => $lv_total_records,
            'grant_deed_total_records' => $grant_deed_total_records,
            'tax_total_records' => $tax_total_records
        ); 
    }

    public function get_safewire_orders_list($params)
    {
        $this->db->select('order_details.file_number,order_details.file_id, order_details.safewire_order_status,property_details.full_address,order_details.id,order_details.created_at, pct_order_partner_company_info.partner_name')
                 ->from('order_details')
                 ->join('pct_order_partner_company_info', 'order_details.escrow_officer_id = pct_order_partner_company_info.partner_id')
                 ->join('property_details', 'order_details.property_id = property_details.id');
        $this->db->where('order_details.is_create_order_on_safewire = 1');
        
        $total_records =  $this->db->count_all_results();
    
		$limit = isset($params['length']) && !empty($params['length']) ? $params['length'] : '';
        $offset = isset($params['start']) && !empty($params['start']) ? $params['start'] : '';
        $safewire_orders_lists = array();

    	if (isset($params['searchvalue']) && !empty($params['searchvalue'])) {
    		$keyword = $params['searchvalue'];

    		if (isset($keyword) && !empty($keyword)) {
                $this->db->group_start()
                        ->like('order_details.file_number', $keyword)
                        ->or_like('order_details.safewire_order_status', $keyword)
                        ->or_like('property_details.full_address', $keyword)
                        ->or_like('pct_order_partner_company_info.partner_name', $keyword)
                        ->group_end();
            }

            $this->db->select('order_details.file_number,order_details.file_id, order_details.safewire_order_status,property_details.full_address,order_details.id,order_details.created_at, pct_order_partner_company_info.partner_name')
                 ->from('order_details')
                 ->join('pct_order_partner_company_info', 'order_details.escrow_officer_id = pct_order_partner_company_info.partner_id')
                 ->join('property_details', 'order_details.property_id = property_details.id');
            $this->db->where('order_details.is_create_order_on_safewire = 1');
			$filter_total_records =  $this->db->count_all_results();

			if(isset($keyword) && !empty($keyword)) {
                $this->db->group_start()
                    ->like('order_details.file_number', $keyword)
                    ->or_like('order_details.safewire_order_status', $keyword)
                    ->or_like('property_details.full_address', $keyword)
                    ->or_like('pct_order_partner_company_info.partner_name', $keyword)
                    ->group_end();
			}

            $this->db->select('order_details.file_number,order_details.file_id, order_details.safewire_order_status,property_details.full_address,order_details.id,order_details.created_at, pct_order_partner_company_info.partner_name')
                ->from('order_details')
                ->join('pct_order_partner_company_info', 'order_details.escrow_officer_id = pct_order_partner_company_info.partner_id')
                ->join('property_details', 'order_details.property_id = property_details.id');
            $this->db->where('order_details.is_create_order_on_safewire = 1');
            $this->db->order_by('order_details.id', 'desc');

            if ((isset($limit) && !empty($limit)) || (isset($offset) && !empty($offset))) {
                $this->db->limit($limit, $offset);
            }	
			$query = $this->db->get();
			if ($query->num_rows() > 0) {
	            $safewire_orders_lists = $query->result_array();
	        }
    	} else {    		
    		$this->db->select('order_details.file_number,order_details.file_id, order_details.safewire_order_status,property_details.full_address,order_details.id,order_details.created_at, pct_order_partner_company_info.partner_name')
                ->from('order_details')
                ->join('pct_order_partner_company_info', 'order_details.escrow_officer_id = pct_order_partner_company_info.partner_id')
                ->join('property_details', 'order_details.property_id = property_details.id');
            $this->db->where('order_details.is_create_order_on_safewire = 1');
            $filter_total_records =  $this->db->count_all_results();

            $this->db->select('order_details.file_number,order_details.file_id, order_details.safewire_order_status,property_details.full_address,order_details.id,order_details.created_at, pct_order_partner_company_info.partner_name')
                ->from('order_details')
                ->join('pct_order_partner_company_info', 'order_details.escrow_officer_id = pct_order_partner_company_info.partner_id')
                ->join('property_details', 'order_details.property_id = property_details.id');
            $this->db->where('order_details.is_create_order_on_safewire = 1');
            $this->db->order_by('order_details.id', 'desc');

			if ((isset($limit) && !empty($limit)) || (isset($offset) && !empty($offset))) {
                $this->db->limit($limit, $offset);
            }

			$query = $this->db->get();
			if ($query->num_rows() > 0) {
	            $safewire_orders_lists = $query->result_array();
	        } 
    	}

    	return array(
            'recordsTotal' => $total_records,
            'recordsFiltered' => $filter_total_records,
            'data' => $safewire_orders_lists
        );
    }

    public function syncSafewireDocuments($orderUrl, $wireUrl, $orderDetails)
    {
        $this->load->model('order/apiLogs');
        $logid = $this->apiLogs->syncLogs(0, 'safewire', 'get_order_detail_pdf', $orderUrl, array(), array(), $orderDetails['order_id'], 0);
        $ch = curl_init($orderUrl);                                    
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');                        
        curl_setopt($ch, CURLOPT_POSTFIELDS, array());                   
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                'Api-Key: jV0i1HY5.71I6FmoBg581iPMAIERe9Qnfmn0b8jLF',
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

        $logid = $this->apiLogs->syncLogs(0, 'safewire', 'get_wire_detail_pdf', $wireUrl, array(), array(), $orderDetails['order_id'], 0);
        $ch = curl_init($wireUrl);                                    
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');                        
        curl_setopt($ch, CURLOPT_POSTFIELDS, array());                   
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                'Api-Key: jV0i1HY5.71I6FmoBg581iPMAIERe9Qnfmn0b8jLF',
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
        $this->apiLogs->syncLogs(0, 'safewire', 'get_wire_detail_pdf', $wireUrl, array(), $resultWire, $orderDetails['order_id'], $logid);
        $res = json_decode($result, true);
        return $res;
    }

    public function sendSafewireDocumentToResware($document_name, $orderDetails, $binaryData, $orderFlag = 0)
	{
        $this->load->model('order/apiLogs');
		$this->load->library('order/resware');

        if ($orderFlag == 1) {
            $fileSize = filesize('./uploads/order_safewire_documents/'.$document_name);
        } else {
            $fileSize = filesize('./uploads/wire_safewire_documents/'.$document_name);
        }
		
		$documentData = array(
			'document_name' => $document_name,
			'original_document_name' => $document_name,
			'document_type_id' => 1051,
			'document_size' => $fileSize,
			'user_id' => 0,
			'order_id' => $orderDetails['order_id'],
			'description' => 'CPL Document',
			'is_sync' => 1,
			'is_prelim_document' => 0,
			'is_cpl_doc' => 0,
            'is_safewire_doc' => 1, 
            'created' => date("Y-m-d H:i:s")
		);
        $this->db->insert('pct_order_documents', $documentData);
        $documentId = $this->db->insert_id();

		$endPoint = 'files/'.$orderDetails['file_id'].'/documents';
		$documentApiData = array(			
			'DocumentName' => $document_name,
			'DocumentType' => array(
				'DocumentTypeID' => 1051,
			),
			'Description' => 'Safewire Document',
			'InternalOnly' => false,
			'DocumentBody' => $binaryData
		);
		$document_api_data = json_encode($documentApiData, JSON_UNESCAPED_SLASHES);

        $userData = array(
            'admin_api' => 1
        );	

		$logid = $this->apiLogs->syncLogs(0, 'resware', 'create_document', env('RESWARE_ORDER_API').$endPoint, $documentApiData, array(), $orderDetails['order_id'], 0);
		$result = $this->resware->make_request('POST', $endPoint, $document_api_data, $userData);
		$this->apiLogs->syncLogs(0, 'resware', 'create_document', env('RESWARE_ORDER_API').$endPoint, $documentApiData, $result, $orderDetails['order_id'], $logid);
		$res = json_decode($result);
        $data = array();
        $data['updated'] = date("Y-m-d H:i:s");
        $data['api_document_id'] = $res->Document->DocumentID;
        $this->db->update('pct_order_documents', $data, array('id' => $documentId));
	}
}
