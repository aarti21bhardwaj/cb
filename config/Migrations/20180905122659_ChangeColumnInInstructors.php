<?php
use Migrations\AbstractMigration;

class ChangeColumnInInstructors extends AbstractMigration
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
        $table = $this->table('instructors');
        $table->changeColumn('image_name', 'string', [
            'default' => null,
            'limit' => 15,
            'null' => true,
        ]);
        $table->changeColumn('image_path', 'string', [
            'default' => null,
            'limit' => 15,
            'null' => true,
        ]);
        $table->changeColumn('phone_1', 'string', [
            'default' => null,
            'limit' => 15,
            'null' => true,
        ]);
        $table->changeColumn('phone_2', 'string', [
            'default' => null,
            'limit' => 15,
            'null' => true,
        ]);
        $table->update();
    }
}
