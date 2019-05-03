<?php
use Migrations\AbstractMigration;

class ChangeColumnInCourseDates extends AbstractMigration
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
        $table->changeColumn('course_date', 'date', [
            'default' => null,
            'null' => true,
        ]);
        $table->changeColumn('time_from', 'time', [
            'default' => null,
            'null' => true,
        ]);
        $table->changeColumn('time_to', 'time', [
            'default' => null,
            'null' => true,
        ]);
        $table->update();
    }
}
