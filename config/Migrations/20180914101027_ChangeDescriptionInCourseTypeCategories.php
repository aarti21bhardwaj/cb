<?php
use Migrations\AbstractMigration;

class ChangeDescriptionInCourseTypeCategories extends AbstractMigration
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
        $table = $this->table('course_type_categories');
        $table->changeColumn('description', 'text', [
            'default' => null,
            'null' => true,
        ]);
        $table->update();
    }
}
