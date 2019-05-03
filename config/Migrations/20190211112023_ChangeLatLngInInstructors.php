<?php
use Migrations\AbstractMigration;

class ChangeLatLngInInstructors extends AbstractMigration
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
        $table->changeColumn('lat', 'float', [
            'default' => null,
            'null' => false,
        ]);
        $table->changeColumn('lng', 'float', [
            'default' => null,
            'null' => false,
        ]);
        $table->update();
    }
}
