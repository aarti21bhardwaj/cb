<?php
use Migrations\AbstractMigration;

class RemoveColumnsFromTenantConfigSettings extends AbstractMigration
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
         $table->removeColumn('portal_password', 'string', [
            'default' => null,
            'limit' => 255,
            'null' => true,
        ]);
          $table->removeColumn('instructor_photo', 'boolean', [
            'default' => null,
            'null' => true,
        ]);
        $table->update();
    }
}
