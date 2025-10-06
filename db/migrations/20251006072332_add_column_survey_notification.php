<?php
declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class AddColumnSurveyNotification extends AbstractMigration
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
        $table->addColumn('no_survey_notify', 'boolean', ['default' => 0, 'after' => 'notify_disburse_funds'])
            ->update();

        $table = $this->table('order_details');
        $table->addColumn('survey_notification_sent', 'boolean', ['default' => 0, 'after' => 'recording_confirmation_sent'])
            ->update();
    }
}
