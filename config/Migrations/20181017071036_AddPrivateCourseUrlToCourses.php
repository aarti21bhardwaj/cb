<?php
use Migrations\AbstractMigration;

class AddPrivateCourseUrlToCourses extends AbstractMigration
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
        $table->addColumn('private_course_url', 'text', [
            'default' => null,
            'null' => true,
        ]);
        $table->update();
    }
}
