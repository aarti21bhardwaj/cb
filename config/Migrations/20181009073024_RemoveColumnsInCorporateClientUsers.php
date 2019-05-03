<?php
use Migrations\AbstractMigration;

class RemoveColumnsInCorporateClientUsers extends AbstractMigration
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
        $table = $this->table('corporate_client_users');
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
        $table->update();
    }
}
