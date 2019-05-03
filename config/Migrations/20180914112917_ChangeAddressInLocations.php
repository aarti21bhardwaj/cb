<?php
use Migrations\AbstractMigration;

class ChangeAddressInLocations extends AbstractMigration
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
        $table->changeColumn('address', 'text', [
            'default' => null,
            'null' => true,
        ]);
        $table->update();
    }
}
