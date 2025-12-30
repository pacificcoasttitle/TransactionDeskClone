<?php
declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class CreateTabalePctLenderParsingDocument extends AbstractMigration
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
        $table = $this->table('pct_lender_parsing_document');
        $table->addColumn('name', 'string')
                ->addColumn('order_number', 'string')
                ->addColumn('file_path', 'string')
                ->addColumn('description', 'string')
                ->addColumn('is_parsed_file', 'boolean', ['default' => 0])
                ->addColumn('added_by', 'integer',['null' => true])
                ->addForeignKey('added_by', 'pct_softpro_lookup_table', 'id')
                ->addColumn('created_at', 'datetime')
                ->addColumn('updated_at', 'datetime', ['null' => true])
                ->create();
    }
}
