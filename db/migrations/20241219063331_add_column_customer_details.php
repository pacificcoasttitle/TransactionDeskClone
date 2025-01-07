<?php
declare (strict_types = 1);

use Phinx\Migration\AbstractMigration;

final class AddColumnCustomerDetails extends AbstractMigration
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
        $table = $this->table('customer_basic_details');
        $table->addColumn('courtesy_title', 'string', ['after' => 'id', 'null' => true])
            ->addColumn('flookup_code', 'string', ['after' => 'id', 'null' => true])
            ->addColumn('lookup_code', 'string', ['after' => 'id', 'null' => true])
            ->addColumn('middle_name', 'string', ['after' => 'first_name', 'null' => true])
            ->addColumn('telephone_no_ext', 'string', ['after' => 'telephone_no', 'null' => true])
            ->addColumn('gender_id', 'string', ['after' => 'telephone_no', 'null' => true])
            ->addColumn('pager', 'string', ['after' => 'telephone_no', 'null' => true])
            ->addColumn('cell', 'string', ['after' => 'telephone_no', 'null' => true])
            ->addColumn('fax', 'string', ['after' => 'telephone_no', 'null' => true])
            ->addColumn('suffix', 'string', ['after' => 'telephone_no', 'null' => true])
            ->addColumn('note', 'string', ['after' => 'status', 'null' => true])
            ->addColumn('license_no', 'string', ['after' => 'state', 'null' => true])
            ->addColumn('user_type', 'string', ['after' => 'email_address', 'null' => true])
            ->update();
    }
}
