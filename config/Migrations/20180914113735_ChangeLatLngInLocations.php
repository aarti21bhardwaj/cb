<?php
use Migrations\AbstractMigration;

class ChangeLatLngInLocations extends AbstractMigration
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
        $table = $this->table('locations');
        $table->changeColumn('lat', 'float', [
            'default' => null,
            'null' => true,
        ]);
        $table->changeColumn('lng', 'float', [
            'default' => null,
            'null' => true,
        ]);
        $table->update();
    }
}
