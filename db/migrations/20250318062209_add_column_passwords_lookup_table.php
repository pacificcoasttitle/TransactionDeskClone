<?php
declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class AddColumnPasswordsLookupTable extends AbstractMigration
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
        $table->addColumn('password', 'text', ['after' => 'email_address', 'null' => true])
            ->addColumn('random_password', 'text', ['after' => 'password', 'null' => true])
            ->addColumn('is_password_updated', 'boolean', ['after' => 'random_password', 'default' => 0])
            ->addColumn('is_password_required', 'boolean', ['after' => 'is_password_updated', 'default' => 0])
            ->addColumn('is_tmp_password', 'boolean', ['after' => 'is_password_required', 'default' => 0])
            ->addColumn('allow_login', 'boolean', ['after' => 'is_tmp_password', 'default' => 0])
            ->update();
    }
}
