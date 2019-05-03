<?php
use Migrations\AbstractMigration;

class AddColumnToEmails extends AbstractMigration
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
        $table = $this->table('emails');
        $table->addColumn('schedule', 'integer', [
            'default' => null,
            'limit' => 11,
            'null' => true
        ]);
        $table->update();
    }
}
