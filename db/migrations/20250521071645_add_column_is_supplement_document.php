<?php
declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class AddColumnIsSupplementDocument extends AbstractMigration
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
        $table = $this->table('pct_order_documents');
        $table->addColumn('is_supplement_statement', 'boolean', ['default' => 0, 'after' => 'is_lender_policy'])
            ->update();
    }
}
