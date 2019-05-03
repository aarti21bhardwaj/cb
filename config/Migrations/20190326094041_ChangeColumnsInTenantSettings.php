<?php
use Migrations\AbstractMigration;

class ChangeColumnsInTenantSettings extends AbstractMigration
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
        $table = $this->table('tenant_settings');
        $table->changeColumn('default_theme', 'string', [
            'default' => null,
            'limit' => 255,
            'null' => true,
        ]);
        $table->changeColumn('admin_email', 'string', [
            'default' => null,
            'limit' => 255,
            'null' => true,
        ]);
        $table->changeColumn('from_email', 'string', [
            'default' => null,
            'limit' => 255,
            'null' => true,
        ]);
        $table->changeColumn('training_centre_website', 'string', [
            'default' => null,
            'limit' => 255,
            'null' => true,
        ]);
        $table->changeColumn('bcc_email', 'string', [
            'default' => null,
            'limit' => 255,
            'null' => true,
        ]);
        $table->changeColumn('title_bar_text', 'string', [
            'default' => null,
            'limit' => 255,
            'null' => true,
        ]);
        $table->update();
    }
}
