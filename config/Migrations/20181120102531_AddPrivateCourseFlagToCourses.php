<?php
use Migrations\AbstractMigration;

class AddPrivateCourseFlagToCourses extends AbstractMigration
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
        $table = $this->table('courses');
        $table->addColumn('private_course_flag', 'boolean', [
            'default' => false,
            'null' => true,
        ]);
        $table->update();
    }
}
