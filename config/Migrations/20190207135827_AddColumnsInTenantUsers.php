<?php
use Migrations\AbstractMigration;

class AddColumnsInTenantUsers extends AbstractMigration
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
            $table = $this->table('tenant_users');
            $table->addColumn('is_site_owner', 'boolean', [
            'default' => 0,
            'null' => false,
        ]);
            $table->update();
    }
}
