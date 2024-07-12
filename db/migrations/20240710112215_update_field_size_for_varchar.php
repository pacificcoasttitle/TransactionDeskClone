<?php
declare (strict_types = 1);

use Phinx\Migration\AbstractMigration;

final class UpdateFieldSizeForVarchar extends AbstractMigration
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
        $table = $this->table('pct_order_title_point_data');
        $table->changeColumn('file_id', 'string', ['limit' => 20])
            ->changeColumn('file_number', 'string', ['limit' => 20])
            ->changeColumn('cs4_request_id', 'string', ['limit' => 20])
            ->changeColumn('cs4_result_id', 'string', ['limit' => 20])
            ->changeColumn('cs4_service_id', 'string', ['limit' => 20])
            ->changeColumn('cs4_instrument_no', 'string', ['limit' => 50])
            ->changeColumn('lv_file_status', 'string', ['limit' => 20])
            ->changeColumn('grant_deed_type', 'string', ['limit' => 100])
            ->changeColumn('grant_deed_status', 'string', ['limit' => 100])
            ->changeColumn('cs3_request_id', 'string', ['limit' => 20])
            ->changeColumn('cs3_result_id', 'string', ['limit' => 20])
            ->changeColumn('cs3_service_id', 'string', ['limit' => 20])
            ->changeColumn('tax_file_status', 'string', ['limit' => 20])
            ->changeColumn('fips', 'string', ['limit' => 50])
            ->changeColumn('property_lotsize', 'string', ['limit' => 20])
            ->changeColumn('property_bedroom', 'string', ['limit' => 10])
            ->changeColumn('property_bathroom', 'string', ['limit' => 10])
            ->changeColumn('property_zoning', 'string', ['limit' => 100])
            ->changeColumn('property_squarefeet', 'string', ['limit' => 20])
            ->changeColumn('tax_order_id', 'string', ['limit' => 20])
            ->changeColumn('lv_order_id', 'string', ['limit' => 20])
            ->changeColumn('geo_order_id', 'string', ['limit' => 20])
            ->changeColumn('geo_file_status', 'string', ['limit' => 20])
            ->changeColumn('tax_request_id', 'string', ['limit' => 20])
            ->changeColumn('tax_rate_area', 'string', ['limit' => 20])
            ->changeColumn('use_code', 'string', ['limit' => 20])
            ->changeColumn('region_code', 'string', ['limit' => 50])
            ->changeColumn('flood_zone', 'string', ['limit' => 20])
            ->changeColumn('tax_rate', 'string', ['limit' => 20])
            ->changeColumn('land', 'string', ['limit' => 50])
            ->changeColumn('improvements', 'string', ['limit' => 50])
            ->changeColumn('tax_data_status', 'string', ['limit' => 20])
            ->update();
    }
}
