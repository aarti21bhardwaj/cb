<?php
use Migrations\AbstractMigration;

class ChangeColumnsInLocations extends AbstractMigration
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
        $table->changeColumn('contact_email', 'string', [
            'default' => null,
            'limit' => 255,
            'null' => true,
        ]);

        $table->changeColumn('notes', 'text', [
            'default' => null,
            'null' => true,
        ]);
        $table->update();
    }
}
