<?php
use Migrations\AbstractMigration;

class ChangeColumnInTransferCourses extends AbstractMigration
{
    /**
     * Change Method.
     *
     * More information on this method is available here:
     * http://docs.phinx.org/en/latest/migrations.html#the-change-method
     * @return void
     */
    public function change()
    {
        $table = $this->table('transfer_courses');
        $table->addColumn('access_revoked', 'boolean', [
            'default' => false,
            'null' => true,
        ]);
        $table->renameColumn('assigner_uuid', 'assignee_uuid');
        $table->update();
    }
}
