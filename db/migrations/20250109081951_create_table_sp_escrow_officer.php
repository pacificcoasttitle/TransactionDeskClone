<?php
declare (strict_types = 1);

use Phinx\Migration\AbstractMigration;

final class CreateTableSpEscrowOfficer extends AbstractMigration
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
        $table = $this->table('sp_officers');
        $table->addColumn('closer_examiner', 'string')
            ->addColumn('lookup_code', 'string', ['null' => true])
            ->addColumn('officer_name', 'string', ['null' => true])

            ->addColumn('is_escrow_officer', 'boolean', ['default' => 0])
            ->addColumn('is_title_officer', 'boolean', ['default' => 0])
            ->addTimestamps()
            ->create();
    }
}
