<?php
use Migrations\AbstractMigration;

class AddOthersToStudents extends AbstractMigration
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
        $table = $this->table('students');
        $table->addColumn('others', 'text', [
            'null' => true,
        ]);
        $table->update();
    }

}
