<?php
use Migrations\AbstractMigration;

class ChangeAddressInCorporateClients extends AbstractMigration
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
        $table = $this->table('corporate_clients');
        $table->changeColumn('address', 'text', [
            'default' => null,
            'null' => true,
        ]);
        $table->update();
    }
}
