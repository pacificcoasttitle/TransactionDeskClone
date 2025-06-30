<?php
declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class AddColumnPrelimSettings extends AbstractMigration
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
        $table = $this->table('pct_configs');
        $rows = [
            [
                'title' => 'Enable Prelim Summary Email',
                'slug' => 'enable_prelim_summary_email',
                'is_enable' => 0,
            ],
            [
                'title' => 'Prelim Summary Shut Off',
                'slug' => 'prelim_summary_shut_off',
                'is_enable' => 0,
            ]
        ];

        $table->insert($rows)->saveData();
    }
}
