<?php
declare (strict_types = 1);

use Phinx\Migration\AbstractMigration;

final class OptimizeOrderProductTypes extends AbstractMigration
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
        $table = $this->table('pct_order_product_types');
        $table->changeColumn('transaction_type', 'string', ['limit' => 30])
            ->changeColumn('product_type', 'string', ['limit' => 100])
            ->changeColumn('county', 'string', ['limit' => 50])
            ->changeColumn('state', 'string', ['limit' => 20])
            ->changeColumn('display_name', 'string', ['limit' => 50])
            ->update();
    }
}
