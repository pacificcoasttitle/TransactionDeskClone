<?php
declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class AddNewProductTypeResidential extends AbstractMigration
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
        $rows = [
            [
                'product_type' => "Junior Loan",
                'status' => 1,
            ],
            [
                'product_type' => "Mobile Home",
                'status' => 1,
            ],
            [
                'product_type' => "Residential Resale",
                'status' => 1,
            ],
        ];

        $table->insert($rows)->saveData();
    }
}
