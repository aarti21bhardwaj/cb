<?php
use Migrations\AbstractMigration;

class ChangeColumnsInCourses extends AbstractMigration
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
        $table->changeColumn('location_id', 'integer', [
            'default' => null,
            'limit' => 11,
            'null' => true,
        ]);
        $table->changeColumn('training_site_id', 'integer', [
            'default' => null,
            'limit' => 11,
            'null' => true,
        ]);
        $table->changeColumn('corporate_client_id', 'integer', [
            'default' => null,
            'limit' => 11,
            'null' => true,
        ]);
        $table->changeColumn('course_type_category_id', 'integer', [
            'default' => null,
            'limit' => 11,
            'null' => true,
        ]);
        $table->changeColumn('course_type_id', 'integer', [
            'default' => null,
            'limit' => 11,
            'null' => true,
        ]);
        $table->changeColumn('seats', 'integer', [
            'default' => null,
            'limit' => 11,
            'null' => true,
        ]);
        $table->changeColumn('instructor_pay', 'string', [
            'default' => null,
            'limit' => 255,
            'null' => true,
        ]);
        $table->update();
    }
}
