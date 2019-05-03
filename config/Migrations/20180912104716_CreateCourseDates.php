<?php
use Migrations\AbstractMigration;

class CreateCourseDates extends AbstractMigration
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
        $table = $this->table('course_dates');
        $table->addColumn('course_id', 'integer', [
            'default' => null,
            'limit' => 11,
            'null' => false,
        ]);
        $table->addColumn('course_date', 'date', [
            'default' => null,
            'null' => false,
        ]);
        $table->addColumn('time_from', 'time', [
            'default' => null,
            'null' => false,
        ]);
        $table->addColumn('time_to', 'time', [
            'default' => null,
            'null' => false,
        ]);
        $table->create();
    }
}
