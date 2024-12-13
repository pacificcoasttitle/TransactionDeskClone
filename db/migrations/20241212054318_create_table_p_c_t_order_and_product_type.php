<?php
declare (strict_types = 1);

use Phinx\Migration\AbstractMigration;

final class CreateTablePCTOrderAndProductType extends AbstractMigration
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
        $table = $this->table('pct_softpro_product_type');
        $table->addColumn('product_type', 'string', ['null' => true])
            ->addColumn('status', 'boolean', ['default' => 1])
            ->addTimestamps()
            ->create();

        $rows = [
            [
                'product_type' => "Short Sale",
                'status' => 1,
            ],
            [
                'product_type' => "Title Report",
                'status' => 1,
            ],
            [
                'product_type' => "Prelim",
                'status' => 1,
            ],
            [
                'product_type' => "Full ALTA",
                'status' => 1,
            ],
            [
                'product_type' => "Short Form",
                'status' => 1,
            ],
            [
                'product_type' => "Hard Money",
                'status' => 1,
            ],
        ];

        $table->insert($rows)->saveData();

        $table = $this->table('pct_softpro_order_type');
        $table->addColumn('order_type', 'string', ['null' => true])
            ->addColumn('status', 'boolean', ['default' => 1])
            ->addTimestamps()
            ->create();

        $rows = [
            [
                'order_type' => "Title only",
                'status' => 1,
            ],
            [
                'order_type' => "Escrow only",
                'status' => 1,
            ],
            [
                'order_type' => "Title & Escrow",
                'status' => 1,
            ],
            [
                'order_type' => "Trustee Sale Guarantee",
                'status' => 1,
            ],
            [
                'order_type' => "Limited Coverage Product",
                'status' => 1,
            ],
            [
                'order_type' => "Other",
                'status' => 1,
            ],
        ];

        $table->insert($rows)->saveData();
    }
}
