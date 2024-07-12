<?php
declare (strict_types = 1);

use Phinx\Migration\AbstractMigration;

final class DecreseVarcharFieldSize extends AbstractMigration
{
    /**
     * Change Method.
     *
     * Write your reversible migrations using this method.
     *
     * More information on writing migrations is available here:
     * https://book.cakephp.org/phinx/0/en/migrations.html#the-change-method
     *
     * Remember to call "create()" or "update()" and NOT "save()" when working
     * with the Table class.
     */
    public function change(): void
    {
        $table = $this->table('property_details');
        $table->changeColumn('city', 'string', ['limit' => 50])
            ->changeColumn('state', 'string', ['limit' => 20])
            ->changeColumn('zip', 'string', ['limit' => 50])
            ->changeColumn('property_type', 'string', ['limit' => 100])
            ->changeColumn('apn', 'string', ['limit' => 50])
            ->changeColumn('county', 'string', ['limit' => 50])
            ->changeColumn('primary_owner', 'string', ['limit' => 100])
            ->changeColumn('secondary_owner', 'string', ['limit' => 100])
            ->changeColumn('cpl_proposed_property_city', 'string', ['limit' => 100])
            ->changeColumn('cpl_proposed_property_state', 'string', ['limit' => 20])
            ->changeColumn('cpl_proposed_property_zip', 'string', ['limit' => 50])
            ->changeColumn('unit_number', 'string', ['limit' => 20])
            ->update();

        $table = $this->table('transaction_details');
        $table->changeColumn('sales_amount', 'string', ['limit' => 30])
        // ->changeColumn('loan_number', 'string', ['limit' => 100])
            ->changeColumn('escrow_number', 'string', ['limit' => 50])
            ->changeColumn('additional_email_1', 'string', ['limit' => 50])
            ->changeColumn('additional_email_2', 'string', ['limit' => 50])
            ->changeColumn('borrower', 'string', ['limit' => 150])
            ->changeColumn('secondary_borrower', 'string', ['limit' => 150])
            ->update();

        $table = $this->table('pct_lp_document_types');
        $table->changeColumn('doc_type', 'string', ['limit' => 20])
            ->changeColumn('doc_sub_type', 'string', ['limit' => 20])
            ->changeColumn('display_in_section', 'string', ['limit' => 5])
            ->changeColumn('map_in_section', 'string', ['limit' => 20])
            ->changeColumn('doc_type_description', 'string', ['limit' => 250])
            ->changeColumn('doc_sub_type_description', 'string', ['limit' => 250])
            ->update();

        $table = $this->table('pct_lp_document_types');
        $table->addIndex(['subtype_flag', 'is_display', 'display_in_section', 'doc_type'])
            ->update();

        $table = $this->table('pct_order_api_logs');
        $table->changeColumn('api_type', 'string', ['limit' => 100])
            ->update();

        $table = $this->table('pct_order_code_book');
        $table->changeColumn('code', 'string', ['limit' => 50])
            ->changeColumn('type', 'string', ['limit' => 50])
            ->update();

        $table = $this->table('pct_order_counties');
        $table->changeColumn('county', 'string', ['limit' => 50])
            ->changeColumn('fips', 'string', ['limit' => 50])
            ->update();

        $table = $this->table('pct_order_cpl_api_logs');
        $table->changeColumn('file_number', 'string', ['limit' => 50])
            ->changeColumn('cpl_page', 'string', ['limit' => 50])
            ->update();

        $table = $this->table('pct_order_fees');
        $table->changeColumn('transaction_type', 'string', ['limit' => 50])
            ->changeColumn('name', 'string', ['limit' => 100])
            ->update();

        $table = $this->table('pct_order_fees_types');
        $table->changeColumn('name', 'string', ['limit' => 50])
            ->update();

        $table = $this->table('pct_order_fnf_agents');
        $table->changeColumn('agent_number', 'string', ['limit' => 50])
            ->changeColumn('agent_status', 'string', ['limit' => 20])
            ->changeColumn('agent_account_type', 'string', ['limit' => 50])
            ->changeColumn('location_city', 'string', ['limit' => 100])
            ->changeColumn('state', 'string', ['limit' => 20])
            ->changeColumn('zip', 'string', ['limit' => 50])
            ->changeColumn('phone_number', 'string', ['limit' => 20])
            ->changeColumn('underwriter_code', 'string', ['limit' => 50])
            ->changeColumn('underwriter', 'string', ['limit' => 100])
            ->update();

        $table = $this->table('pct_order_natic_branches');
        $table->changeColumn('city', 'string', ['limit' => 100])
            ->changeColumn('state', 'string', ['limit' => 20])
            ->changeColumn('address1', 'string', ['limit' => 150])
            ->update();

        $table = $this->table('pct_order_national_form_data');
        $table->changeColumn('buyer_name', 'string', ['limit' => 50])
            ->changeColumn('buyer_email', 'string', ['limit' => 50])
            ->changeColumn('buyer_mobile', 'string', ['limit' => 20])
            ->changeColumn('title_hold_reason', 'string', ['limit' => 20])
            ->changeColumn('ssn', 'string', ['limit' => 20])
            ->changeColumn('estimated_closing_date', 'string', ['limit' => 20])
            ->changeColumn('lender', 'string', ['limit' => 50])
            ->changeColumn('loan_amount', 'string', ['limit' => 20])
            ->changeColumn('loan_number', 'string', ['limit' => 100])
            ->changeColumn('title_items_required_by', 'string', ['limit' => 150])
            ->changeColumn('lender_clause', 'string', ['limit' => 150])
            ->changeColumn('return_document_to', 'string', ['limit' => 150])
            ->changeColumn('loan_officer', 'string', ['limit' => 150])
            ->update();

        $table = $this->table('pct_order_notifications');
        $table->changeColumn('type', 'string', ['limit' => 50])
            ->update();

        $table = $this->table('pct_order_partner_company_info');
        $table->changeColumn('partner_name', 'string', ['limit' => 150])
            ->changeColumn('email', 'string', ['limit' => 50])
            ->changeColumn('city', 'string', ['limit' => 100])
            ->changeColumn('state', 'string', ['limit' => 20])
            ->changeColumn('zip', 'string', ['limit' => 50])
            ->changeColumn('sales_underwriter', 'string', ['limit' => 100])
            ->changeColumn('loan_underwriter', 'string', ['limit' => 100])
            ->update();

        $table = $this->table('pct_order_product_types');
        $table->changeColumn('transaction_type', 'string', ['limit' => 30])
            ->changeColumn('product_type', 'string', ['limit' => 100])
            ->changeColumn('county', 'string', ['limit' => 50])
            ->changeColumn('state', 'string', ['limit' => 20])
            ->changeColumn('display_name', 'string', ['limit' => 50])
            ->update();

        $table = $this->table('pct_order_proposed_branches');
        $table->changeColumn('city', 'string', ['limit' => 100])
            ->changeColumn('state', 'string', ['limit' => 20])
            ->changeColumn('zip', 'string', ['limit' => 50])
            ->update();

        $table = $this->table('pct_order_recordings_monthly_sync');
        $table->changeColumn('month', 'string', ['limit' => 20])
            ->changeColumn('day', 'string', ['limit' => 20])
            ->update();

        $table = $this->table('pct_order_sales_rep');
        $table->changeColumn('name', 'string', ['limit' => 100])
            ->changeColumn('email_address', 'string', ['limit' => 50])
            ->changeColumn('telephone', 'string', ['limit' => 20])
            ->update();

        $table = $this->table('pct_order_title_officer');
        $table->changeColumn('email_address', 'string', ['limit' => 50])
            ->changeColumn('name', 'string', ['limit' => 100])
            ->changeColumn('phone', 'string', ['limit' => 20])
            ->update();

        $table = $this->table('pct_order_twilio_message_records');
        $table->changeColumn('sent_from', 'string', ['limit' => 20])
            ->changeColumn('sent_to', 'string', ['limit' => 20])
            ->changeColumn('status', 'string', ['limit' => 20])
            ->changeColumn('message_sid', 'string', ['limit' => 50])
            ->changeColumn('error_code', 'string', ['limit' => 50])
            ->update();

        $table = $this->table('pct_realtor_data');
        $table->changeColumn('agent', 'string', ['limit' => 100])
            ->changeColumn('company', 'string', ['limit' => 100])
            ->changeColumn('city', 'string', ['limit' => 100])
            ->changeColumn('state', 'string', ['limit' => 20])
            ->changeColumn('zip', 'string', ['limit' => 50])
            ->update();

        $table = $this->table('pct_resware_log');
        $table->changeColumn('request_type', 'string', ['limit' => 100])
            ->changeColumn('file_id', 'string', ['limit' => 50])
            ->changeColumn('file_number', 'string', ['limit' => 50])
            ->update();

        $table = $this->table('pct_sales_activity_report');
        $table->changeColumn('month', 'string', ['limit' => 10])
            ->changeColumn('county', 'string', ['limit' => 50])
            ->changeColumn('report_url', 'string', ['limit' => 100])
            ->update();

        $table = $this->table('pct_sales_rep_report');
        $table->changeColumn('zip_code', 'string', ['limit' => 50])
            ->changeColumn('sort_by', 'string', ['limit' => 50])
            ->changeColumn('area_name', 'string', ['limit' => 100])
            ->changeColumn('report_url', 'string', ['limit' => 100])
            ->update();

        $table = $this->table('pct_sales_snap_shot_report');
        $table->changeColumn('area_name', 'string', ['limit' => 100])
            ->changeColumn('report_url', 'string', ['limit' => 100])
            ->changeColumn('month_option', 'string', ['limit' => 10])
            ->changeColumn('property_type', 'string', ['limit' => 100])
            ->update();

        $table = $this->table('pct_title_point_document_records');
        $table->changeColumn('document_name', 'string', ['limit' => 100])
            ->changeColumn('document_type', 'string', ['limit' => 20])
            ->changeColumn('loan_amount', 'string', ['limit' => 20])
            ->changeColumn('type', 'string', ['limit' => 20])
            ->changeColumn('sub_type', 'string', ['limit' => 20])
            ->changeColumn('order_number', 'string', ['limit' => 150])
            ->changeColumn('color_coding', 'string', ['limit' => 20])
            ->changeColumn('icon_text', 'string', ['limit' => 20])
            ->changeColumn('document_sub_type', 'string', ['limit' => 20])
            ->changeColumn('coupling', 'string', ['limit' => 10])
            ->changeColumn('amount', 'string', ['limit' => 20])
            ->changeColumn('recorded_date', 'string', ['limit' => 20, 'null' => true])
            ->changeColumn('instrument', 'string', ['limit' => 100])
            ->changeColumn('display_in_section', 'string', ['limit' => 5])
            ->update();

        $table = $this->table('pct_vendors');
        $table->changeColumn('transctee_name', 'string', ['limit' => 100])
            ->changeColumn('file_number', 'string', ['limit' => 50])
            ->changeColumn('account_number', 'string', ['limit' => 20])
            ->changeColumn('aba', 'string', ['limit' => 100])
            ->changeColumn('bank_name', 'string', ['limit' => 20])
            ->changeColumn('submitted', 'string', ['limit' => 20])
            ->changeColumn('approved_date', 'string', ['limit' => 20])
            ->changeColumn('created_by', 'string', ['limit' => 20])
            ->update();

    }
}
