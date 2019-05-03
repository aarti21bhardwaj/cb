<?php
use Migrations\AbstractMigration;

class ModifyColumnsInCourses extends AbstractMigration
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

        $table->changeColumn('class_details', 'text', [
            'default' => null,
            'null' => false,
        ]);
        
        $table->changeColumn('admin_notes', 'text', [
            'default' => null,
            'null' => true,
        ]);
        $table->update();
    }
}
