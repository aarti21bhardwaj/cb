<?php
use Migrations\AbstractMigration;

class UpdateColumnsInCourses extends AbstractMigration
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
         $table->changeColumn('pay_structure', 'string', [
            'default' => null,
            'limit' => 255,
            'null' => true,
        ]);
        $table->changeColumn('av_provided_by', 'string', [
            'default' => null,
            'limit' => 255,
            'null' => true,
        ]);
        $table->update();

    }
}
