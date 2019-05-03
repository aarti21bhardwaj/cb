<?php
use Migrations\AbstractMigration;

class ChangeColumnTypeInTenantConfigSettings extends AbstractMigration
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
        $table = $this->table('tenant_config_settings');
            $table->changeColumn('sandbox', 'boolean', [
            'default' => 0,
            'null' => true,
        ]);
        $table->update();
    }
}
