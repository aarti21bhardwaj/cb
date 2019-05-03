<?php
use Migrations\AbstractMigration;

class AddColumnsDatesToCourseStudents extends AbstractMigration
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
        $table = $this->table('course_students');
        $table->addColumn('registration_date', 'datetime', [
            'default' => null,
            'null' => true,
        ]);
        $table->addColumn('cancellation_date', 'datetime', [
            'default' => null,
            'null' => true,
        ]);
        $table->update();
    }
}
