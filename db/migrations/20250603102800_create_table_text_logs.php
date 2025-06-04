<?php
declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class CreateTableTextLogs extends AbstractMigration
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
        $table = $this->table('pct_order_text_sms_logs');
        $table->addColumn('task_id', 'string', ['limit' => 50])
                ->addColumn('file_number', 'string', ['limit' => 50])
                ->addColumn('message', 'text')
                ->addColumn('response', 'text')
                ->addColumn('status', 'boolean', ['default' => false])
                ->addTimestamps()
                ->create();

        $table = $this->table('pct_configs');
        $rows = [
            [
                'title' => 'Recording Confirmation Notification Shut Off',
                'slug' => 'recording_confirmation_shut_off',
                'is_enable' => 0,
            ],
            [
                'title' => 'Disburse Funds Notification Shut Off',
                'slug' => 'disburse_funds_shut_off',
                'is_enable' => 0,
            ]
        ];

        $table->insert($rows)->saveData();

        $table = $this->table('pct_softpro_lookup_table');
        $table->addColumn('notify_recording_confirm', 'boolean', ['default' => 0, 'after' => 'is_title_officer'])
            ->addColumn('notify_disburse_funds', 'boolean', ['default' => 0, 'after' => 'is_title_officer'])
            ->update();
    }
}
