<?php
declare(strict_types=1);

use Phinx\Migration\AbstractMigration;
use Phinx\Db\Adapter\MysqlAdapter;

final class CreateTableManualBuyers extends AbstractMigration
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
        $table = $this->table('pct_manual_buyers');
        $table->addColumn('order_id', 'integer', ['limit' => 100,  'null' => true])
                ->addColumn('order_number', 'string', ['limit' => 100])
                ->addColumn('property_address', 'string', ['limit' => 255])
                ->addColumn('buyer_name', 'string', ['limit' => 100,  'null' => true])
                ->addColumn('buyer_email', 'string', ['limit' => 50,  'null' => true])
                ->addColumn('buyer_phone_no', 'string', ['limit' => 50,  'null' => true])
                ->addColumn('buyer_office_name', 'string', ['limit' => 50,  'null' => true])
                ->addColumn('sales_rep_id', 'integer', ['limit' => 11])
                ->addColumn('sales_rep_name', 'string', ['limit' => 50,  'null' => true])
                ->addColumn('email_recipient', 'string', ['limit' => 255])
                ->addColumn('email_sent_status', 'boolean', ['default' => 0])
                ->addTimestamps()
                ->create();

    }
}

