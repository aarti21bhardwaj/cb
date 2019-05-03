<?php
use Migrations\AbstractMigration;

class CreateTenantThemes extends AbstractMigration
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
        $table = $this->table('tenant_themes');
        $table->addColumn('theme_color_light', 'string', [
            'default' => null,
            'limit' => 255,
            'null' => true,
        ]);
        $table->addColumn('theme_color_dark', 'string', [
            'default' => null,
            'limit' => 255,
            'null' => true,
        ]);
        $table->addColumn('logo_name', 'string', [
            'default' => null,
            'limit' => 255,
            'null' => true,
        ]);
        $table->addColumn('logo_path', 'string', [
            'default' => null,
            'limit' => 255,
            'null' => true,
        ]);
        $table->addColumn('content_area', 'text', [
            'default' => null,
            'null' => true,
        ]);
        $table->addColumn('content_sidebar', 'text', [
            'default' => null,
            'null' => true,
        ]);
        $table->addColumn('content_header', 'text', [
            'default' => null,
            'null' => true,
        ]);
        $table->addColumn('content_footer', 'text', [
            'default' => null,
            'null' => true,
        ]);
        $table->addColumn('redirect_url', 'string', [
            'default' => null,
            'limit' => 255,
            'null' => true,
        ]);
        $table->create();
    }
}
