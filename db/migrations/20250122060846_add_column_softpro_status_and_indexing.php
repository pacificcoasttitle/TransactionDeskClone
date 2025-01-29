<?php
declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class AddColumnSoftproStatusAndIndexing extends AbstractMigration
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
        $table = $this->table('order_details');
        $table->addColumn('softpro_status', 'string', ['after' => 'resware_status', 'null' => true])
              ->update();
        
        $table = $this->table('pct_softpro_lookup_table');
        $table->addIndex(['lookup_code', 'flookup_code', 'company_name', 'is_escrow', 'is_lender'])
            ->update();

        $table = $this->table('sp_company');
        $table->addIndex(['lookup_code'])
            ->update();

        $table = $this->table('sp_officers');
        $table->addIndex(['closer_examiner'])
            ->update();
        $table = $this->table('order_details');
        $table->addIndex(['softpro_status'])
            ->update();
    }
}
