<?php
use Migrations\AbstractMigration;

class ChangeDescriptionsInCourseTypes extends AbstractMigration
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
        $table = $this->table('course_types');
        $table->changeColumn('description', 'text', [
            'default' => null,
            'null' => true,
        ]);
        $table->changeColumn('class_detail', 'text', [
            'default' => null,
            'null' => true,
        ]);
        $table->changeColumn('notes_to_instructor', 'text', [
            'default' => null,
            'null' => true,
        ]);
        $table->update();
    }
}
