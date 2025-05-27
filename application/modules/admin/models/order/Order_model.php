<?php
class Order_model extends CI_Model
{

    public function __construct()
    {
        // Set table name
        $this->table = 'order_details';
    }

    public function get_orders($params)
    {
        $sales_rep    = isset($params['sales_rep']) && ! empty($params['sales_rep']) ? $params['sales_rep'] : '';
        $product_type = isset($params['product_type']) && ! empty($params['product_type']) ? $params['product_type'] : '';
        $order_type   = isset($params['order_type']) && ! empty($params['order_type']) ? $params['order_type'] : '';

        if (isset($sales_rep) && ! empty($sales_rep)) {
            $this->db->where('transaction_details.sales_representative', $sales_rep);
        }

        if (isset($product_type) && ! empty($product_type)) {
            $this->db->group_start();
            $this->db->like('pct_order_product_types.product_type', $product_type)
                ->or_like('pct_softpro_product_type.product_type', $product_type)
            ->group_end();
        }

        $created_by = isset($params['created_by']) && ! empty($params['created_by']) ? $params['created_by'] : '';

        if (isset($created_by) && ! empty($created_by)) {
            $this->db->where('order_details.created_by', $created_by);
        }

        if (isset($order_type) && ! empty($order_type)) {
            if ($order_type == 'softpro_orders') {
                // $this->db->where('order_details.lp_file_number is null');
                $this->db->where('order_details.file_number is not null');
                $this->db->where('order_details.file_number !=', '0');
            } else if ($order_type == 'lp_orders') {
                $this->db->where('order_details.lp_file_number is not null');
                // $this->db->where('order_details.file_number', 0);
            }

        }

        if (isset($params['searchValue']) && ! empty($params['searchValue'])) {
            $keyword = $params['searchValue'];

            if (isset($keyword) && ! empty($keyword)) {
                $this->db->group_start()
                    ->like('property_details.full_address', $keyword)
                    ->or_like('order_details.file_number', $keyword)
                    ->group_end();
            }

            $this->db->select('order_details.file_number,
                order_details.lp_file_number,
                order_details.softpro_status,
                order_details.is_imported,
                order_details.is_softpro_order,
                order_details.file_id,
                property_details.allow_duplication,
                property_details.full_address,
                property_details.id as property_id,
                order_details.id,
                transaction_details.id as transaction_id,
                transaction_details.sales_representative,
                transaction_details.purchase_type,
                CONCAT(sp_sales.first_name, " ", sp_sales.last_name) as sp_sales_rep_name, 
                pct_softpro_product_type.product_type as sp_product_type,
                pct_order_product_types.product_type,
                pct_softpro_lookup_table.first_name,
                pct_softpro_lookup_table.last_name,
                order_details.created_at, 
                tpd.email_sent_status')
                ->from('order_details')
                ->join('pct_softpro_lookup_table', 'pct_softpro_lookup_table.id = order_details.created_by', 'left')
                ->join('property_details', 'order_details.property_id = property_details.id')
                ->join('transaction_details', 'order_details.transaction_id = transaction_details.id')
                // ->join('customer_basic_details as cbd', 'transaction_details.sales_representative = cbd.id', 'left')
                ->join('pct_softpro_lookup_table as sp_sales', 'transaction_details.sales_representative = sp_sales.id', 'left')
                ->join('pct_order_title_point_data as tpd', 'order_details.file_id = tpd.file_id', 'left')
                ->join('pct_order_product_types', 'transaction_details.purchase_type = pct_order_product_types.product_type_id AND pct_order_product_types.status=1', 'left')
                ->join('pct_softpro_product_type', 'transaction_details.purchase_type = pct_softpro_product_type.id AND pct_softpro_product_type.status=1', 'left');
            $this->db->where('order_details.is_softpro_order', 1);
            $total_records = $this->db->count_all_results();

            if (isset($sales_rep) && ! empty($sales_rep)) {
                $this->db->where('transaction_details.sales_representative', $sales_rep);
            }

            if (isset($product_type) && ! empty($product_type)) {
                $this->db->group_start();
                $this->db->like('pct_order_product_types.product_type', $product_type)
                    ->or_like('pct_softpro_product_type.product_type', $product_type)
                ->group_end();
            }

            $created_by = isset($params['created_by']) && ! empty($params['created_by']) ? $params['created_by'] : '';
            if (isset($created_by) && ! empty($created_by)) {
                $this->db->where('order_details.created_by', $created_by);
            }

            if (isset($order_type) && ! empty($order_type)) {
                if ($order_type == 'softpro_orders') {
                    // $this->db->where('order_details.lp_file_number is null');
                    $this->db->where('order_details.file_number is not null');
                    $this->db->where('order_details.file_number !=', '0');
                } else if ($order_type == 'lp_orders') {
                    $this->db->where('order_details.lp_file_number is not null');
                    // $this->db->where('order_details.file_number', 0);
                }

            }

            if (isset($keyword) && ! empty($keyword)) {
                $this->db->group_start()
                    ->like('property_details.full_address', $keyword)
                    ->or_like('order_details.file_number', $keyword)
                    ->group_end();
            }

            $limit        = isset($params['length']) && ! empty($params['length']) ? $params['length'] : '';
            $offset       = isset($params['start']) && ! empty($params['start']) ? $params['start'] : '';
            $orders_lists = [];

        
            $this->db->select('order_details.file_number,
                order_details.lp_file_number,
                order_details.softpro_status,
                order_details.is_softpro_order,
                order_details.is_imported,
                order_details.file_id,
                property_details.allow_duplication,
                property_details.full_address,
                property_details.id as property_id,
                order_details.id,
                transaction_details.id as transaction_id,
                transaction_details.sales_representative,
                transaction_details.purchase_type,
                CONCAT(sp_sales.first_name, " ", sp_sales.last_name) as sp_sales_rep_name, 
                pct_softpro_product_type.product_type as sp_product_type,
                pct_order_product_types.product_type,
                pct_softpro_lookup_table.first_name,
                pct_softpro_lookup_table.last_name,
                order_details.created_at, 
                tpd.email_sent_status')
                ->from('order_details')
                ->join('pct_softpro_lookup_table', 'pct_softpro_lookup_table.id = order_details.created_by', 'left')
                ->join('property_details', 'order_details.property_id = property_details.id')
                ->join('transaction_details', 'order_details.transaction_id = transaction_details.id')
                // ->join('customer_basic_details as cbd', 'transaction_details.sales_representative = cbd.id', 'left')
                ->join('pct_softpro_lookup_table as sp_sales', 'transaction_details.sales_representative = sp_sales.id', 'left')
                ->join('pct_order_title_point_data as tpd', 'order_details.file_id = tpd.file_id', 'left')
                ->join('pct_order_product_types', 'transaction_details.purchase_type = pct_order_product_types.product_type_id AND pct_order_product_types.status=1', 'left')
                ->join('pct_softpro_product_type', 'transaction_details.purchase_type = pct_softpro_product_type.id AND pct_softpro_product_type.status=1', 'left');
            $this->db->where('order_details.is_softpro_order', 1);
            $this->db->order_by("order_details.created_at", "desc");

            if ((isset($limit) && ! empty($limit)) || (isset($offset) && ! empty($offset))) {
                $this->db->limit($limit, $offset);
            }

            $query = $this->db->get();
            // echo $this->db->last_query();die;
            if ($query->num_rows() > 0) {
                $orders_lists = $query->result_array();
            }
        } else {
            $this->db->select('order_details.file_number,
                order_details.lp_file_number,
                order_details.softpro_status,
                order_details.is_softpro_order,
                order_details.is_imported,
                order_details.file_id,
                property_details.allow_duplication,
                property_details.full_address,
                property_details.id as property_id,
                order_details.id,
                transaction_details.id as transaction_id,
                transaction_details.sales_representative,
                transaction_details.purchase_type,
                CONCAT(sp_sales.first_name, " ", sp_sales.last_name) as sp_sales_rep_name, 
                pct_softpro_product_type.product_type as sp_product_type,
                pct_order_product_types.product_type,
                pct_softpro_lookup_table.first_name,
                pct_softpro_lookup_table.last_name,
                order_details.created_at, 
                tpd.email_sent_status')
                ->from('order_details')
                ->join('pct_softpro_lookup_table', 'pct_softpro_lookup_table.id = order_details.created_by', 'left')
                ->join('property_details', 'order_details.property_id = property_details.id')
                ->join('transaction_details', 'order_details.transaction_id = transaction_details.id')
                // ->join('customer_basic_details as cbd', 'transaction_details.sales_representative = cbd.id', 'left')
                ->join('pct_softpro_lookup_table as sp_sales', 'transaction_details.sales_representative = sp_sales.id', 'left')
                ->join('pct_order_title_point_data as tpd', 'order_details.file_id = tpd.file_id', 'left')
                ->join('pct_order_product_types', 'transaction_details.purchase_type = pct_order_product_types.product_type_id AND pct_order_product_types.status=1', 'left')
                ->join('pct_softpro_product_type', 'transaction_details.purchase_type = pct_softpro_product_type.id AND pct_softpro_product_type.status=1', 'left');
            $this->db->where('order_details.is_softpro_order', 1);
            $total_records = $this->db->count_all_results();

            $limit        = isset($params['length']) && ! empty($params['length']) ? $params['length'] : '';
            $offset       = isset($params['start']) && ! empty($params['start']) ? $params['start'] : '';
            $orders_lists = [];

            if (isset($sales_rep) && ! empty($sales_rep)) {
                $this->db->where('transaction_details.sales_representative', $sales_rep);
            }

            if (isset($product_type) && ! empty($product_type)) {
                $this->db->group_start();
                $this->db->like('pct_order_product_types.product_type', $product_type)
                    ->or_like('pct_softpro_product_type.product_type', $product_type)
                ->group_end();
            }

            $created_by = isset($params['created_by']) && ! empty($params['created_by']) ? $params['created_by'] : '';
            if (isset($created_by) && ! empty($created_by)) {
                $this->db->where('order_details.created_by', $created_by);
            }

            if (isset($order_type) && ! empty($order_type)) {
                if ($order_type == 'softpro_orders') {
                    // $this->db->where('order_details.lp_file_number is null');
                    $this->db->where('order_details.file_number is not null');
                    $this->db->where('order_details.file_number !=', '0');
                } else if ($order_type == 'lp_orders') {
                    $this->db->where('order_details.lp_file_number is not null');
                    // $this->db->where('order_details.file_number', 0);
                }

            }

            $this->db->select('order_details.file_number,
                order_details.lp_file_number,
                order_details.softpro_status,
                order_details.is_softpro_order,
                order_details.is_imported,
                order_details.file_id,
                property_details.allow_duplication,
                property_details.full_address,
                property_details.id as property_id,
                order_details.id,
                transaction_details.id as transaction_id,
                transaction_details.sales_representative,
                transaction_details.purchase_type,
                CONCAT(sp_sales.first_name, " ", sp_sales.last_name) as sp_sales_rep_name, 
                pct_softpro_product_type.product_type as sp_product_type,
                pct_order_product_types.product_type,
                pct_softpro_lookup_table.first_name,
                pct_softpro_lookup_table.last_name,
                order_details.created_at, 
                tpd.email_sent_status')
                ->from('order_details')
                ->join('pct_softpro_lookup_table', 'pct_softpro_lookup_table.id = order_details.created_by', 'left')
                ->join('property_details', 'order_details.property_id = property_details.id')
                ->join('transaction_details', 'order_details.transaction_id = transaction_details.id')
                // ->join('customer_basic_details as cbd', 'transaction_details.sales_representative = cbd.id', 'left')
                ->join('pct_softpro_lookup_table as sp_sales', 'transaction_details.sales_representative = sp_sales.id', 'left')
                ->join('pct_order_title_point_data as tpd', 'order_details.id = tpd.order_id', 'left')
                ->join('pct_order_product_types', 'transaction_details.purchase_type = pct_order_product_types.product_type_id AND pct_order_product_types.status=1', 'left')
                ->join('pct_softpro_product_type', 'transaction_details.purchase_type = pct_softpro_product_type.id AND pct_softpro_product_type.status=1', 'left');
            $this->db->where('order_details.is_softpro_order', 1);
            $this->db->order_by("order_details.created_at", "desc");

            if ((isset($limit) && ! empty($limit)) || (isset($offset) && ! empty($offset))) {
                $this->db->limit($limit, $offset);
            }

            $query = $this->db->get();
            // echo $this->db->last_query();die;
            if ($query->num_rows() > 0) {
                $orders_lists = $query->result_array();
            }
        }
        return [
            'recordsTotal'    => $total_records,
            'recordsFiltered' => $total_records,
            'data'            => $orders_lists,
        ];
    }

    public function update($data, $condition = [])
    {
        $table = $this->table;

        if (! empty($data)) {

            $data['updated_at'] = date("Y-m-d H:i:s");

            // Update data
            $update = $this->db->update($table, $data, $condition);

            // Return the status
            return $update ? true : false;
        }
        return false;
    }

    public function insert($data = [])
    {
        $table = $this->table;
        if (! empty($data)) {

            $data['created_at'] = date("Y-m-d H:i:s");

            // Insert data
            $insert = $this->db->insert($table, $data);

            // Return the status
            return $insert ? $this->db->insert_id() : false;
        }
        return false;
    }

    public function get_order_details($orderId)
    {
        $this->db->select('
            order_details.file_number,
            order_details.lp_file_number,
            order_details.customer_id,
            order_details.id as order_id,
            order_details.file_id,
            order_details.random_number,
            order_details.westcor_order_id,
            order_details.westcor_cpl_id,
            order_details.westcor_buyer_id,
            order_details.westcor_seller_id,
            order_details.westcor_secondary_buyer_id,
            order_details.westcor_secondary_seller_id,
            order_details.westcor_lender_id,
            order_details.westcor_file_id,
            order_details.is_regenerate_cpl,
            order_details.created_at as opened_date,
            order_details.fnf_agent_id,
            order_details.fnf_document_id,
            order_details.cpl_document_name,
            order_details.proposed_insured_document_name,
            order_details.verification_code,
            order_details.verification_code_for_seller,
            order_details.code_created_at,
            order_details.code_created_at_for_seller,
            order_details.borrower_mobile_number,
            order_details.borrower_mobile_number_for_seller,
            order_details.proposed_branch_id,
            order_details.escrow_officer_id,
            order_details.premium,
            order_details.is_create_order_on_safewire,
            order_details.safewire_action_link,
            order_details.prod_type,
            order_details.resware_status,
            order_details.softpro_status,
            order_details.is_softpro_order,
            order_details.borrower_email,
            property_details.id as property_id,
            property_details.address,
            property_details.full_address,
            property_details.apn,
            property_details.property_type,
            property_details.city as property_city,
            property_details.state as property_state,
            property_details.zip as property_zip,
            property_details.county,
            property_details.westcor_property_id,
            property_details.legal_description,
            property_details.primary_owner,
            property_details.secondary_owner,
            property_details.escrow_lender_id,
            property_details.cpl_lender_id,
            property_details.listing_agent_id,
            property_details.borrowers_vesting,
            property_details.cpl_proposed_property_address,
            property_details.cpl_proposed_property_city,
            property_details.cpl_proposed_property_state,
            property_details.cpl_proposed_property_zip,
            property_details.unit_number,
            property_details.buyer_agent_id,
            transaction_details.id as transaction_id,
            transaction_details.sales_representative,
            transaction_details.title_officer,
            transaction_details.sales_amount,
            transaction_details.loan_amount,
            transaction_details.loan_number,
            transaction_details.notes,
            transaction_details.transaction_type,
            transaction_details.product_type,
            transaction_details.order_type,
            transaction_details.purchase_type,
            transaction_details.supplemental_report_date,
            transaction_details.preliminary_report_date,
            transaction_details.borrower,
            transaction_details.additional_email,
            transaction_details.additional_email_1,
            transaction_details.additional_email_2,
            transaction_details.secondary_borrower,
            transaction_details.vesting,
            transaction_details.escrow_number,
            CONCAT_WS(",",transaction_details.additional_email,transaction_details.additional_email_1,transaction_details.additional_email_2) as additional_emails,
            pct_softpro_order_type.order_type as order_type_name,
            pct_order_product_types.product_type as product_type_name,
            pct_softpro_product_type.product_type as sp_product_type_name,

            pct_softpro_lookup_table.company_name as sp_escrow_lender_company_name,
            pct_softpro_lookup_table.first_name as sp_escrow_lender_first_name,
            pct_softpro_lookup_table.last_name as sp_escrow_lender_last_name,
            pct_softpro_lookup_table.email_address as sp_escrow_lender_email,
            pct_softpro_lookup_table.phone as sp_escrow_lender_telephone_no,
            pct_softpro_lookup_table.lookup_code as sp_escrow_lender_lookup_code,
            pct_softpro_lookup_table.flookup_code as sp_escrow_lender_flookup_code,
            pct_softpro_lookup_table.id as sp_lender_id,
            pct_softpro_lookup_table.address1 as sp_lender_address,
            pct_softpro_lookup_table.city as sp_lender_city,
            pct_softpro_lookup_table.state as sp_lender_state,
            pct_softpro_lookup_table.zip as sp_lender_zipcode,
            pct_softpro_lookup_table.is_escrow as sp_is_escrow,

            splt.first_name as sp_cust_first_name,
            splt.last_name as sp_cust_last_name,
            splt.email_address as sp_cust_email_address,
            splt.company_name as sp_cust_company_name,
            splt.phone as sp_cust_telephone_no,
            splt.address1 as sp_cust_street_address,
            splt.city as sp_cust_city,
            splt.zip as sp_cust_zip_code,
            splt.lookup_code as sp_cust_lookup_code,
            splt.flookup_code as sp_cust_flookup_code,
            splt.is_escrow as sp_cust_is_escrow,
            splt.is_lender as sp_cust_is_lender,
            splt.is_mortgage_broker as sp_cust_is_mortgage_broker,
            splt.is_selling_agent as sp_cust_is_selling_agent,

            CONCAT(sp_salerep.first_name, " ", sp_salerep.last_name) as sp_sales_rep_name,
            sp_salerep.phone as sales_rep_phone,
            sp_salerep.first_name as sp_salerep_first_name,
            sp_salerep.last_name as sp_salerep_last_name,
            sp_salerep.full_name as sp_salerep_full_name,
            sp_salerep.lookup_code as sp_salerep_lookup_code,
            sp_salerep.is_mail_notification as sp_salerep_is_mail_notification,
            sp_salerep.email_address as sp_salerep_email_address,

            sp_to.officer_name as sp_title_officer_name,
            sp_to.closer_examiner as sp_titleofficer_closer_examiner,
            sp_to.lookup_code as sp_titleofficer_lookup_code,

            CONCAT(sp_agents.first_name, " ", sp_agents.last_name) as sp_buyer_agent_name,
            sp_agents.email_address as sp_buyer_agent_email_address,
            sp_agents.company_name as sp_buyer_agent_company,
            sp_agents.city as sp_buyer_agent_city,
            sp_agents.zip as sp_buyer_agent_zipcode,
            sp_agents.phone as sp_buyer_agent_telephone_no,
            sp_agents.address1 as sp_buyer_agent_address,
            sp_agents.lookup_code as sp_buyer_agent_lookup_code,
            sp_agents.flookup_code as sp_buyer_agent_flookup_code,

            pct_order_fnf_agents.agent_number,
            pct_order_fnf_agents.underwriter_code,
            pct_order_fnf_agents.underwriter,
            pct_order_documents.created,
            p.created as proposed_document_created_date,

            CONCAT(sp_la.first_name, " ", sp_la.last_name) as sp_listing_agent_name,
            sp_la.email_address as sp_listing_agent_email_address,
            sp_la.company_name as sp_listing_agent_company,
            sp_la.lookup_code as sp_listing_agent_lookup_code,
            sp_la.flookup_code as sp_listing_agent_flookup_code,
            sp_la.phone as sp_listing_agent_telephone_no'
            

            
            )
            ->from('order_details')
            ->join('property_details', 'order_details.property_id = property_details.id')
            ->join('transaction_details', 'order_details.transaction_id = transaction_details.id')

            // ->join('customer_basic_details', 'property_details.escrow_lender_id = customer_basic_details.id', 'left')
            ->join('pct_softpro_lookup_table', 'property_details.escrow_lender_id = pct_softpro_lookup_table.id', 'left')

            // ->join('customer_basic_details as cbd', 'order_details.customer_id = cbd.id', 'left')
            ->join('pct_softpro_lookup_table as splt', 'order_details.customer_id = splt.id', 'left')

            // ->join('customer_basic_details as titleofficer', 'transaction_details.title_officer = titleofficer.id', 'left')
            ->join('pct_softpro_lookup_table as sp_to', 'transaction_details.title_officer = sp_to.id', 'left')

            // ->join('customer_basic_details as salerep', 'transaction_details.sales_representative = salerep.id', 'left')
            ->join('pct_softpro_lookup_table as sp_salerep', 'transaction_details.sales_representative = sp_salerep.id', 'left')

            ->join('pct_order_documents', 'pct_order_documents.document_name = order_details.cpl_document_name', 'left')
            ->join('pct_order_documents as p', 'p.document_name = order_details.proposed_insured_document_name', 'left')

            // ->join('customer_basic_details as agents', 'property_details.buyer_agent_id = agents.id', 'left')
            ->join('pct_softpro_lookup_table as sp_agents', 'property_details.buyer_agent_id = sp_agents.id', 'left')

            // ->join('customer_basic_details a', 'property_details.listing_agent_id = a.id', 'left')
            ->join('pct_softpro_lookup_table sp_la', 'property_details.listing_agent_id = sp_la.id', 'left')

            ->join('pct_softpro_product_type', 'pct_softpro_product_type.id = transaction_details.purchase_type', 'left')
            ->join('pct_order_product_types', 'transaction_details.purchase_type = pct_order_product_types.product_type_id AND pct_order_product_types.status=1', 'left')
            
            ->join('pct_softpro_order_type', 'pct_softpro_order_type.id = transaction_details.order_type', 'left')
            
            ->join('pct_order_fnf_agents', 'order_details.fnf_agent_id = pct_order_fnf_agents.id', 'left');
        $this->db->where('order_details.id', $orderId);

        $query = $this->db->get();

        // echo $this->db->last_query();die;
        return $query->row_array();
    }

    public function get_order_count($filter = null)
    {
        $query = $this->db->select('order_details.prod_type as type,COUNT(order_details.id) AS total')
            ->from('order_details');
        // ->join('transaction_details', 'order_details.transaction_id = transaction_details.id')
        // ->join('pct_order_product_types', 'transaction_details.purchase_type = pct_order_product_types.product_type_id AND pct_order_product_types.status=1');
        // ->where('is_imported=0');
        if ($filter && is_array($filter)) {
            $check_date_field = 'order_details.created_at';
            if (isset($filter['type']) && $filter['type'] == 'closed') {
                $check_date_field = 'order_details.sent_to_accounting_date';
            }
            if (isset($filter['for_month'])) {
                $query->where('MONTH(' . $check_date_field . ')', $filter['for_month']);
            }
            if (isset($filter['for_year'])) {
                $query->where('YEAR(' . $check_date_field . ')', $filter['for_year']);
            }
        }
        $query->group_by('order_details.prod_type');

        $query = $this->db->get();
        // echo $this->db->last_query();die;
        $orders_data = [];
        if ($query->num_rows() > 0) {
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

        $lv_total_records = $this->db->count_all_results();

        $this->db->group_start()
            ->where('grant_deed_status !=', 'ok')
            ->or_where('grant_deed_status is null')
            ->group_end();

        $this->db->where('file_id IS NOT NULL');
        $this->db->from('pct_order_title_point_data');

        $grant_deed_total_records = $this->db->count_all_results();

        $this->db->group_start()
            ->where('tax_file_status !=', 'success')
            ->or_where('tax_file_status is null')
            ->group_end();

        $this->db->where('file_id IS NOT NULL');
        $this->db->from('pct_order_title_point_data');

        $tax_total_records = $this->db->count_all_results();

        return [
            'lv_total_records'         => $lv_total_records,
            'grant_deed_total_records' => $grant_deed_total_records,
            'tax_total_records'        => $tax_total_records,
        ];
    }

    public function get_safewire_orders_list($params)
    {
        $this->db->select('order_details.file_number,order_details.file_id, order_details.safewire_order_status,property_details.full_address,order_details.id,order_details.created_at, pct_order_partner_company_info.partner_name')
            ->from('order_details')
            ->join('pct_order_partner_company_info', 'order_details.escrow_officer_id = pct_order_partner_company_info.partner_id')
            ->join('property_details', 'order_details.property_id = property_details.id');
        $this->db->where('order_details.is_create_order_on_safewire = 1');

        $total_records = $this->db->count_all_results();

        $limit                 = isset($params['length']) && ! empty($params['length']) ? $params['length'] : '';
        $offset                = isset($params['start']) && ! empty($params['start']) ? $params['start'] : '';
        $safewire_orders_lists = [];

        if (isset($params['searchvalue']) && ! empty($params['searchvalue'])) {
            $keyword = $params['searchvalue'];

            if (isset($keyword) && ! empty($keyword)) {
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
            $filter_total_records = $this->db->count_all_results();

            if (isset($keyword) && ! empty($keyword)) {
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

            if ((isset($limit) && ! empty($limit)) || (isset($offset) && ! empty($offset))) {
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
            $filter_total_records = $this->db->count_all_results();

            $this->db->select('order_details.file_number,order_details.file_id, order_details.safewire_order_status,property_details.full_address,order_details.id,order_details.created_at, pct_order_partner_company_info.partner_name')
                ->from('order_details')
                ->join('pct_order_partner_company_info', 'order_details.escrow_officer_id = pct_order_partner_company_info.partner_id')
                ->join('property_details', 'order_details.property_id = property_details.id');
            $this->db->where('order_details.is_create_order_on_safewire = 1');
            $this->db->order_by('order_details.id', 'desc');

            if ((isset($limit) && ! empty($limit)) || (isset($offset) && ! empty($offset))) {
                $this->db->limit($limit, $offset);
            }

            $query = $this->db->get();
            if ($query->num_rows() > 0) {
                $safewire_orders_lists = $query->result_array();
            }
        }

        return [
            'recordsTotal'    => $total_records,
            'recordsFiltered' => $filter_total_records,
            'data'            => $safewire_orders_lists,
        ];
    }

    public function get_lp_orders($params)
    {
        $sales_rep    = isset($params['sales_rep']) && ! empty($params['sales_rep']) ? $params['sales_rep'] : '';
        $product_type = isset($params['product_type']) && ! empty($params['product_type']) ? $params['product_type'] : '';
        $order_type   = isset($params['order_type']) && ! empty($params['order_type']) ? $params['order_type'] : '';
        $start_date   = isset($params['start_date']) && ! empty($params['start_date']) ? $params['start_date'] : '';
        $end_date     = isset($params['end_date']) && ! empty($params['end_date']) ? $params['end_date'] : '';

        if (isset($sales_rep) && ! empty($sales_rep)) {
            $this->db->where('transaction_details.sales_representative', $sales_rep);
        }

        if (isset($product_type) && ! empty($product_type)) {
            $this->db->group_start();
                $this->db->like('pct_order_product_types.product_type', $product_type)
                    ->or_like('pct_softpro_product_type.product_type', $product_type)
                ->group_end();
            // $this->db->like('pct_order_product_types.product_type', $product_type);
        }

        $created_by = isset($params['created_by']) && ! empty($params['created_by']) ? $params['created_by'] : '';

        if (isset($created_by) && ! empty($created_by)) {
            $this->db->where('order_details.created_by', $created_by);
        }

        if (isset($order_type) && ! empty($order_type)) {
            if ($order_type == 'resware_orders' || $order_type == 'softpro_orders') {
                //$this->db->where('order_details.lp_file_number is null');
                $this->db->where('order_details.file_number is not null');
            } else if ($order_type == 'lp_orders') {
                $this->db->where('order_details.lp_file_number is not null');
                //$this->db->where('order_details.file_number', 0);
            }

        }

        if (! empty($end_date)) {
            $this->db->where('order_details.created_at >=', date('Y-m-d H:i:s', strtotime($start_date)));
            $this->db->where('order_details.created_at <=', date('Y-m-d 23:59:59', strtotime($end_date)));
        }

        if (isset($params['searchValue']) && ! empty($params['searchValue'])) {
            $keyword = $params['searchValue'];

            if (isset($keyword) && ! empty($keyword)) {
                $this->db->where("(property_details.full_address LIKE '%" . $keyword . "%' OR order_details.lp_file_number LIKE '%" . $keyword . "%')");
            }

            $this->db->select('order_details.file_number, order_details.lp_file_number,order_details.file_id, order_details.softpro_status, order_details.is_softpro_order, property_details.allow_duplication, property_details.full_address,property_details.id as property_id,order_details.id,transaction_details.sales_representative,transaction_details.purchase_type, CONCAT(sp_sales.first_name, " ", sp_sales.last_name) as sp_sales_rep_name, pct_order_product_types.product_type, sp_pt.product_type as sp_product_type, pct_softpro_lookup_table.first_name, pct_softpro_lookup_table.last_name,order_details.created_at,tpd.email_sent_status')
                ->from('order_details')
                ->join('pct_softpro_lookup_table', 'pct_softpro_lookup_table.id = order_details.created_by', 'left')
                ->join('property_details', 'order_details.property_id = property_details.id')
                ->join('transaction_details', 'order_details.transaction_id = transaction_details.id')
                // ->join('customer_basic_details as cbd', 'transaction_details.sales_representative = cbd.id', 'left')
                ->join('pct_softpro_lookup_table as sp_sales', 'transaction_details.sales_representative = sp_sales.id', 'left')
                ->join('pct_order_title_point_data as tpd', 'order_details.id = tpd.order_id', 'left')
                ->join('pct_order_documents', 'order_details.id = pct_order_documents.order_id and pct_order_documents.is_pre_listing_report_doc=1', 'left')
                ->join('pct_order_product_types', 'transaction_details.purchase_type = pct_order_product_types.product_type_id AND pct_order_product_types.status=1', 'left')
                ->join('pct_softpro_product_type as sp_pt', 'transaction_details.purchase_type = sp_pt.id AND sp_pt.status=1', 'left');
            $this->db->where('order_details.is_softpro_order', 1);
            $total_records = $this->db->count_all_results();

            if (isset($sales_rep) && ! empty($sales_rep)) {
                $this->db->where('transaction_details.sales_representative', $sales_rep);
            }

            if (isset($product_type) && ! empty($product_type)) {
                $this->db->group_start();
                $this->db->like('pct_order_product_types.product_type', $product_type)
                    ->or_like('sp_pt.product_type', $product_type)
                ->group_end();
                // $this->db->like('pct_order_product_types.product_type', $product_type);
            }

            $created_by = isset($params['created_by']) && ! empty($params['created_by']) ? $params['created_by'] : '';
            if (isset($created_by) && ! empty($created_by)) {
                $this->db->where('order_details.created_by', $created_by);
            }

            if (isset($order_type) && ! empty($order_type)) {
                if ($order_type == 'softpro_orders') {
                    //$this->db->where('order_details.lp_file_number is null');
                    $this->db->where('order_details.file_number is not null');
                } else if ($order_type == 'lp_orders') {
                    $this->db->where('order_details.lp_file_number is not null');
                    //$this->db->where('order_details.file_number', 0);
                }

            }

            if (! empty($end_date)) {
                $this->db->where('order_details.created_at >=', date('Y-m-d H:i:s', strtotime($start_date)));
                $this->db->where('order_details.created_at <=', date('Y-m-d 23:59:59', strtotime($end_date)));
            }

            if (isset($keyword) && ! empty($keyword)) {
                $this->db->where("(property_details.full_address LIKE '%" . $keyword . "%' OR order_details.lp_file_number LIKE '%" . $keyword . "%')");
            }

            $limit        = isset($params['length']) && ! empty($params['length']) ? $params['length'] : '';
            $offset       = isset($params['start']) && ! empty($params['start']) ? $params['start'] : '';
            $orders_lists = [];

            $this->db->select('order_details.file_number, order_details.lp_file_number,order_details.file_id, order_details.softpro_status, order_details.is_softpro_order, property_details.allow_duplication, property_details.full_address,property_details.id as property_id,order_details.id,transaction_details.sales_representative,transaction_details.purchase_type, CONCAT(sp_sales.first_name, " ", sp_sales.last_name) as sp_sales_rep_name, pct_order_product_types.product_type, sp_pt.product_type as sp_product_type, pct_softpro_lookup_table.first_name, pct_softpro_lookup_table.last_name,order_details.created_at,tpd.email_sent_status')
                ->from('order_details')
                ->join('pct_softpro_lookup_table', 'pct_softpro_lookup_table.id = order_details.created_by', 'left')
                ->join('property_details', 'order_details.property_id = property_details.id')
                ->join('transaction_details', 'order_details.transaction_id = transaction_details.id')
                // ->join('customer_basic_details as cbd', 'transaction_details.sales_representative = cbd.id', 'left')
                ->join('pct_softpro_lookup_table as sp_sales', 'transaction_details.sales_representative = sp_sales.id', 'left')
                ->join('pct_order_title_point_data as tpd', 'order_details.id = tpd.order_id', 'left')
                ->join('pct_order_documents', 'order_details.id = pct_order_documents.order_id and pct_order_documents.is_pre_listing_report_doc=1', 'left')
                ->join('pct_order_product_types', 'transaction_details.purchase_type = pct_order_product_types.product_type_id AND pct_order_product_types.status=1', 'left')
                ->join('pct_softpro_product_type as sp_pt', 'transaction_details.purchase_type = sp_pt.id AND sp_pt.status=1', 'left');
            $this->db->where('order_details.is_softpro_order', 1);
            $this->db->order_by("order_details.id", "desc");

            if ((isset($limit) && ! empty($limit)) || (isset($offset) && ! empty($offset))) {
                $this->db->limit($limit, $offset);
            }

            $query = $this->db->get();

            if ($query->num_rows() > 0) {
                $orders_lists = $query->result_array();
            }
        } else {
            $this->db->select('order_details.file_number, order_details.lp_file_number,order_details.file_id, order_details.softpro_status, order_details.is_softpro_order, property_details.allow_duplication, property_details.full_address,property_details.id as property_id,order_details.id,transaction_details.sales_representative,transaction_details.purchase_type, CONCAT(sp_sales.first_name, " ", sp_sales.last_name) as sp_sales_rep_name, pct_order_product_types.product_type, sp_pt.product_type as sp_product_type, pct_softpro_lookup_table.first_name, pct_softpro_lookup_table.last_name,order_details.created_at,tpd.email_sent_status')
                ->from('order_details')
                ->join('pct_softpro_lookup_table', 'pct_softpro_lookup_table.id = order_details.created_by', 'left')
                ->join('property_details', 'order_details.property_id = property_details.id')
                ->join('transaction_details', 'order_details.transaction_id = transaction_details.id')
                // ->join('customer_basic_details as cbd', 'transaction_details.sales_representative = cbd.id', 'left')
                ->join('pct_softpro_lookup_table as sp_sales', 'transaction_details.sales_representative = sp_sales.id', 'left')
                ->join('pct_order_title_point_data as tpd', 'order_details.id = tpd.order_id', 'left')
                ->join('pct_order_documents', 'order_details.id = pct_order_documents.order_id and pct_order_documents.is_pre_listing_report_doc=1', 'left')
                ->join('pct_order_product_types', 'transaction_details.purchase_type = pct_order_product_types.product_type_id AND pct_order_product_types.status=1', 'left')
                ->join('pct_softpro_product_type as sp_pt', 'transaction_details.purchase_type = sp_pt.id AND sp_pt.status=1', 'left');
            $this->db->where('order_details.is_softpro_order', 1);
            $total_records = $this->db->count_all_results();

            $limit        = isset($params['length']) && ! empty($params['length']) ? $params['length'] : '';
            $offset       = isset($params['start']) && ! empty($params['start']) ? $params['start'] : '';
            $orders_lists = [];

            if (isset($sales_rep) && ! empty($sales_rep)) {
                $this->db->where('transaction_details.sales_representative', $sales_rep);
            }

            if (isset($product_type) && ! empty($product_type)) {
                $this->db->group_start();
                $this->db->like('pct_order_product_types.product_type', $product_type)
                    ->or_like('sp_pt.product_type', $product_type)
                ->group_end();
                // $this->db->like('pct_order_product_types.product_type', $product_type);
            }

            $created_by = isset($params['created_by']) && ! empty($params['created_by']) ? $params['created_by'] : '';
            if (isset($created_by) && ! empty($created_by)) {
                $this->db->where('order_details.created_by', $created_by);
            }

            if (isset($order_type) && ! empty($order_type)) {
                if ($order_type == 'softpro_orders') {
                    //$this->db->where('order_details.lp_file_number is null');
                    $this->db->where('order_details.file_number is not null');
                } else if ($order_type == 'lp_orders') {
                    $this->db->where('order_details.lp_file_number is not null');
                    //$this->db->where('order_details.file_number', 0);
                }

            }
            if (! empty($end_date)) {
                $this->db->where('order_details.created_at >=', date('Y-m-d H:i:s', strtotime($start_date)));
                $this->db->where('order_details.created_at <=', date('Y-m-d 23:59:59', strtotime($end_date)));
            }
            $this->db->select('order_details.file_number, order_details.lp_file_number,order_details.file_id, order_details.softpro_status, order_details.is_softpro_order, property_details.allow_duplication, property_details.full_address,property_details.id as property_id,order_details.id,transaction_details.sales_representative,transaction_details.purchase_type, CONCAT(sp_sales.first_name, " ", sp_sales.last_name) as sp_sales_rep_name, pct_order_product_types.product_type, sp_pt.product_type as sp_product_type, pct_softpro_lookup_table.first_name, pct_softpro_lookup_table.last_name,order_details.created_at,tpd.email_sent_status')
                ->from('order_details')
                ->join('pct_softpro_lookup_table', 'pct_softpro_lookup_table.id = order_details.created_by', 'left')
                ->join('property_details', 'order_details.property_id = property_details.id')
                ->join('transaction_details', 'order_details.transaction_id = transaction_details.id')
                // ->join('customer_basic_details as cbd', 'transaction_details.sales_representative = cbd.id', 'left')
                ->join('pct_softpro_lookup_table as sp_sales', 'transaction_details.sales_representative = sp_sales.id', 'left')
                ->join('pct_order_title_point_data as tpd', 'order_details.id = tpd.order_id', 'left')
                ->join('pct_order_documents', 'order_details.id = pct_order_documents.order_id and pct_order_documents.is_pre_listing_report_doc=1', 'left')
                ->join('pct_order_product_types', 'transaction_details.purchase_type = pct_order_product_types.product_type_id AND pct_order_product_types.status=1', 'left')
                ->join('pct_softpro_product_type as sp_pt', 'transaction_details.purchase_type = sp_pt.id AND sp_pt.status=1', 'left');
            $this->db->where('order_details.is_softpro_order', 1);
            $this->db->order_by("order_details.id", "desc");
            if ((isset($limit) && ! empty($limit)) || (isset($offset) && ! empty($offset))) {
                $this->db->limit($limit, $offset);
            }

            $query = $this->db->get();

            if ($query->num_rows() > 0) {
                $orders_lists = $query->result_array();
            }
        }
        // echo $this->db->last_query();exit;
        return [
            'recordsTotal'    => $total_records,
            'recordsFiltered' => $total_records,
            'data'            => $orders_lists,
        ];
    }

    public function logAdminActivity($activity)
    {
        $userdata = $this->session->userdata('admin');
        $data = array(
            'user_id' => $userdata['id'] ?? 1,
            'message' => $activity,
            'created_at' => date("Y-m-d H:i:s"),
        );
        $this->db->insert('pct_admin_activity_logs', $data);
    }
}
