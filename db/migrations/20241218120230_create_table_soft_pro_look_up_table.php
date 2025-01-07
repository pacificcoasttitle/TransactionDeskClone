<?php
declare (strict_types = 1);

use Phinx\Migration\AbstractMigration;

final class CreateTableSoftProLookUpTable extends AbstractMigration
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
        $table = $this->table('pct_softpro_lookup_table');
        $table->addColumn('lookup_code', 'string')
            ->addColumn('flookup_code', 'string', ['null' => true])
            ->addColumn('courtesy_title', 'string', ['null' => true])
            ->addColumn('first_name', 'string', ['null' => true])
            ->addColumn('middle_name', 'string', ['null' => true])
            ->addColumn('last_name', 'string', ['null' => true])
            ->addColumn('email_address', 'string', ['null' => true])
            ->addColumn('phone', 'string', ['null' => true])
            ->addColumn('phone_ext', 'string', ['null' => true])
            ->addColumn('suffix', 'string', ['null' => true])
            ->addColumn('title', 'string', ['null' => true])
            ->addColumn('fax', 'string', ['null' => true])
            ->addColumn('cell', 'string', ['null' => true])
            ->addColumn('pager', 'string', ['null' => true])
            ->addColumn('gender_id', 'string', ['null' => true])
            ->addColumn('address1', 'string', ['null' => true])
            ->addColumn('address2', 'string', ['null' => true])
            ->addColumn('city', 'string', ['null' => true])
            ->addColumn('state', 'string', ['null' => true])
            ->addColumn('zip', 'string', ['null' => true])
            ->addColumn('note', 'string', ['null' => true])
            ->addColumn('license_no', 'string', ['null' => true])

            ->addColumn('signature_line', 'string', ['null' => true])
            ->addColumn('fee_transfer_ledger', 'string', ['null' => true])
            ->addColumn('state_of_incorporation', 'string', ['null' => true])
            ->addColumn('marketing_rep', 'string', ['null' => true])
            ->addColumn('special_instructions', 'string', ['null' => true])
            ->addColumn('legal_name', 'string', ['null' => true])
            ->addColumn('funding_address1', 'string', ['null' => true])
            ->addColumn('funding_address2', 'string', ['null' => true])
            ->addColumn('funding_city', 'string', ['null' => true])
            ->addColumn('funding_state', 'string', ['null' => true])
            ->addColumn('funding_zip', 'string', ['null' => true])
            ->addColumn('funding_phone', 'string', ['null' => true])
            ->addColumn('funding_fax', 'string', ['null' => true])
            ->addColumn('payee_name', 'string', ['null' => true])
            ->addColumn('county', 'string', ['null' => true])

            ->addColumn('home_phone', 'string', ['null' => true])
            ->addColumn('represents', 'string', ['null' => true])

            ->addColumn('splitTo_premiums', 'string', ['null' => true])
            ->addColumn('percent_premiums', 'string', ['null' => true])
            ->addColumn('billCode_premiums', 'string', ['null' => true])
            ->addColumn('splitTo_endorsements', 'string', ['null' => true])
            ->addColumn('percent_endorsements', 'string', ['null' => true])
            ->addColumn('billCode_endorsements', 'string', ['null' => true])

            ->addColumn('user_type', 'string')
            ->addColumn('status', 'boolean', ['default' => 1])
            ->addTimestamps()
            ->create();
    }
}
