<?php
use Migrations\AbstractMigration;

class RemoveColumnsInCorporateClients extends AbstractMigration
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
        $table->removeColumn('tenant_id', 'integer', [
            'default' => null,
            'limit' => 11,
            'null' => false,
        ]);
        $table->removeColumn('training_site_id', 'integer', [
            'default' => null,
            'limit' => 11,
            'null' => false,
        ]);
         $table->removeColumn('contact_name', 'string', [
            'default' => null,
            'limit' => 255,
            'null' => false,
        ]);
        $table->removeColumn('contact_phone', 'string', [
            'default' => null,
            'limit' => 255,
            'null' => false,
        ]);
        $table->removeColumn('contact_email', 'string', [
            'default' => null,
            'limit' => 255,
            'null' => false,
        ]);
        $table->removeColumn('password', 'string', [
            'default' => null,
            'limit' => 255,
            'null' => false,
        ]);
        $table->update();
    }
}
