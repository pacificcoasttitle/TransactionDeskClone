<?php
declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class CreateSalesSnapShotReportData extends AbstractMigration
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
        $table = $this->table('pct_sales_snap_shot_report_records');
        $table->addColumn('report_id', 'integer')
            ->addColumn('apn', 'string', ['null' => true])
            ->addColumn('building_size', 'string', ['null' => true])
            ->addColumn('bedrooms', 'string', ['null' => true])
            ->addColumn('baths', 'string', ['null' => true])
            ->addColumn('purchase_price', 'string', ['null' => true])
            ->addColumn('owner_occupied', 'string', ['null' => true])
			->addTimestamps()
            ->create();
    }
}
