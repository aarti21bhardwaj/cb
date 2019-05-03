<?php
use Migrations\AbstractMigration;

class RemoveColumnsFromStudentTransferHistories extends AbstractMigration
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
        $table = $this->table('student_transfer_histories');
        $table->removeColumn('amount_paid', 'integer', [
            'default' => null,
            'limit' => 11,
            'null' => false,
        ]);
        $table->removeColumn('balance_due', 'integer', [
            'default' => null,
            'limit' => 11,
            'null' => false,
        ]);
        $table->update();
    }
}
