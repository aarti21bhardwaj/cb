<?php
use Migrations\AbstractMigration;

class UpdateColumnInCourses extends AbstractMigration
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
         $table->changeColumn('cost', 'string', [
            'default' => null,
            'limit' => 255,
            'null' => true,
        ]);
         $table->update();
    }
}
