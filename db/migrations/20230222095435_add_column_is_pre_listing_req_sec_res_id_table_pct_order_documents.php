<?php
declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class AddColumnIsPreListingReqSecResIdTablePctOrderDocuments extends AbstractMigration
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
        $table->addColumn('pre_listing_service_id', 'string', ['after' => 'cs3_service_id', 'null' => true])
            ->addColumn('pre_listing_message', 'string', ['after' => 'cs3_service_id', 'null' => true])
			->addColumn('pre_listing_result_id', 'string', ['after' => 'cs3_service_id', 'null' => true])
			->addColumn('pre_listing_request_id', 'string', ['after' => 'cs3_service_id', 'null' => true])
			->update();
    }
}
