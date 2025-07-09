<?php
declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class ChangeColumnbuyerPurchaseSales extends AbstractMigration
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
        $table = $this->table('pct_order_borrower_buyer_purchase_sale_info');
        $table->changeColumn('types_of_property_transferred', 'string', ['null' => true, 'limit' => 50])
            ->changeColumn('cash_down_payment', 'string', ['null' => true, 'limit' => 255])
            ->changeColumn('total_purchase_price', 'string', ['null' => true, 'limit' => 255])
            ->changeColumn('property_purchase_via', 'string', ['null' => true, 'limit' => 255])
            ->changeColumn('property_condition', 'string', ['null' => true, 'limit' => 255])
            ->update();
    }
}
