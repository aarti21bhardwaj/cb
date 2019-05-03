<?php
use Migrations\AbstractMigration;

class ChangeColumnsInTenants extends AbstractMigration
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
            $table->changeColumn('valid_for', 'string', [
            'default' => null,
            'limit' => 255,
            'null' => true,
        ]);
        $table->changeColumn('course_code', 'string', [
            'default' => null,
            'limit' => 255,
            'null' => true,
        ]);
        $table->changeColumn('color_code', 'string', [
            'default' => null,
            'limit' => 255,
            'null' => true,
        ]);
        $table->changeColumn('status', 'boolean', [
            'default' => 1,
            'null' => true,
        ]);
        $table->update();
    }
}
