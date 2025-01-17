<?php
declare (strict_types = 1);

use Phinx\Migration\AbstractMigration;

final class CreateTableSpEscrowCompany extends AbstractMigration
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
        $table = $this->table('sp_company');
        $table->addColumn('lookup_code', 'string')
            ->addColumn('name', 'string', ['null' => true])
            ->addColumn('payee_name', 'string', ['null' => true])
            ->addColumn('email_address', 'string', ['null' => true])
            ->addColumn('flookup_code', 'string', ['null' => true])
            ->addColumn('address1', 'string', ['null' => true])
            ->addColumn('address2', 'string', ['null' => true])
            ->addColumn('city', 'string', ['null' => true])
            ->addColumn('state', 'string', ['null' => true])
            ->addColumn('zip', 'string', ['null' => true])
            ->addColumn('phone', 'string', ['null' => true])
            ->addColumn('fax', 'string', ['null' => true])
            ->addColumn('fee_transfer_ledger', 'string', ['null' => true])
            ->addColumn('marketing_rep', 'string', ['null' => true])
            ->addColumn('special_instructions', 'string', ['null' => true])
            ->addColumn('signature_line', 'string', ['null' => true])
            ->addColumn('state_of_incorporation', 'string', ['null' => true])

            ->addColumn('legal_name', 'string', ['null' => true])
            ->addColumn('funding_address1', 'string', ['null' => true])
            ->addColumn('funding_address2', 'string', ['null' => true])
            ->addColumn('funding_city', 'string', ['null' => true])
            ->addColumn('funding_state', 'string', ['null' => true])
            ->addColumn('funding_zip', 'string', ['null' => true])
            ->addColumn('funding_phone', 'string', ['null' => true])
            ->addColumn('funding_fax', 'string', ['null' => true])

            ->addColumn('home_phone', 'string', ['null' => true])
            ->addColumn('represents', 'string', ['null' => true])
            ->addColumn('license_no', 'string', ['null' => true])

            ->addColumn('splitTo_premiums', 'string', ['null' => true])
            ->addColumn('percent_premiums', 'string', ['null' => true])
            ->addColumn('billCode_premiums', 'string', ['null' => true])
            ->addColumn('splitTo_endorsements', 'string', ['null' => true])
            ->addColumn('percent_endorsements', 'string', ['null' => true])
            ->addColumn('billCode_endorsements', 'string', ['null' => true])

            ->addColumn('is_lender', 'boolean', ['default' => 0])
            ->addColumn('is_escrow_company', 'boolean', ['default' => 0])
            ->addColumn('is_mortgage_broker', 'boolean', ['default' => 0])
            ->addColumn('is_selling_agent', 'boolean', ['default' => 0])
            ->addColumn('is_underwriter', 'boolean', ['default' => 0])
            ->addTimestamps()
            ->create();
    }
}
