<?php
declare (strict_types = 1);

use Phinx\Migration\AbstractMigration;

final class AddColumnIsDeskFileFileDocuments extends AbstractMigration
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
        $table = $this->table('pct_file_documents');
        $table->addColumn('order_number', 'string', ['after' => 'name', 'null' => true])
            ->addColumn('is_desk_file', 'boolean', ['after' => 'description', 'default' => 0])
            ->update();
    }
}
