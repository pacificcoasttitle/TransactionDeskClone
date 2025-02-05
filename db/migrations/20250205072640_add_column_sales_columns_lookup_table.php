<?php
declare(strict_types=1);

use Phinx\Migration\AbstractMigration;
use Phinx\Db\Adapter\MysqlAdapter;

final class AddColumnSalesColumnsLookupTable extends AbstractMigration
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
        $table->addColumn('sales_rep_users', 'text', ['limit' => MysqlAdapter::TEXT_LONG, 'after' => 'is_sales_rep'])
                ->addColumn('sales_rep_report_image', 'string', ['null' => true, 'after' => 'marketing_rep'])
                ->addColumn('sales_rep_profile_img', 'string', ['null' => true, 'after' => 'marketing_rep'])
                ->addColumn('sales_rep_profile_thank_you_img', 'string', ['null' => true, 'after' => 'marketing_rep'])
                ->addColumn('sales_rep_no_of_open_orders', 'integer', ['null' => true, 'after' => 'marketing_rep'])
                ->addColumn('sales_rep_no_of_close_orders', 'integer', ['null' => true, 'after' => 'marketing_rep'])
                ->addColumn('sales_rep_premium', 'integer', ['null' => true, 'after' => 'marketing_rep'])
                ->addColumn('is_sales_rep_manager', 'boolean', ['default' => 0, 'after' => 'is_sales_rep'])
                ->addColumn('is_mail_notification', 'boolean', ['default' => 0, 'after' => 'is_new_user'])
                ->update();

    }
}
