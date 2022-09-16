<?php
declare(strict_types=1);

use Phinx\Migration\AbstractMigration;
use Phinx\Db\Adapter\MysqlAdapter;

final class CreatePrelimSyncLogs extends AbstractMigration
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
        $table = $this->table('pct_order_prelim_logs');
        $table->addColumn('user_id', 'integer', ['default' => 0, 'null' => true])
                ->addColumn('order_id', 'biginteger', ['default' => 0, 'null' => true])
                ->addColumn('api_type', 'string', ['limit' => 255])
                ->addColumn('request_type', 'string', ['limit' => 255])
                ->addColumn('request_url', 'text')
                ->addColumn('request_data', 'text', ['limit' => MysqlAdapter::TEXT_LONG, 'null' => true])
                ->addColumn('response_data', 'text', ['limit' => MysqlAdapter::TEXT_LONG, 'null' => true])
                ->addColumn('created', 'datetime')
                ->addColumn('updated', 'datetime', ['null' => true])
                ->addIndex(['user_id'])
                ->addIndex(['order_id'])
                ->create();
    }
}
