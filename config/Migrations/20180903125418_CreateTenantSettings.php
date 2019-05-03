<?php
use Migrations\AbstractMigration;

class CreateTenantSettings extends AbstractMigration
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
        $table->addColumn('tenant_id', 'integer', [
            'default' => null,
            'limit' => 11,
            'null' => false,
        ]);
        $table->addColumn('enable_training_site_module', 'boolean', [
            'default' => null,
            'null' => false,
        ]);
        $table->addColumn('enable_corporate_module', 'boolean', [
            'default' => null,
            'null' => false,
        ]);
        $table->addColumn('enable_aed_pm_module', 'boolean', [
            'default' => null,
            'null' => false,
        ]);
        $table->addColumn('shop_menu_visible', 'boolean', [
            'default' => null,
            'null' => false,
        ]);
        $table->addColumn('default_theme', 'string', [
            'default' => null,
            'limit' => 255,
            'null' => false,
        ]);
        $table->addColumn('key_management', 'boolean', [
            'default' => null,
            'null' => false,
        ]);
        $table->addColumn('admin_email', 'string', [
            'default' => null,
            'limit' => 255,
            'null' => false,
        ]);
        $table->addColumn('from_email', 'string', [
            'default' => null,
            'limit' => 255,
            'null' => false,
        ]);
        $table->addColumn('allow_duplicate_emails', 'boolean', [
            'default' => null,
            'null' => false,
        ]);
        $table->addColumn('training_centre_website', 'string', [
            'default' => null,
            'limit' => 255,
            'null' => false,
        ]);
        $table->addColumn('bcc_email', 'string', [
            'default' => null,
            'limit' => 255,
            'null' => false,
        ]);
        $table->addColumn('title_bar_text', 'string', [
            'default' => null,
            'limit' => 255,
            'null' => false,
        ]);
        $table->addColumn('enable_payment_email', 'boolean', [
            'default' => null,
            'null' => false,
        ]);
        $table->create();
    }
}
