<?php
use Migrations\AbstractMigration;

class ChangeDescriptionInAddons extends AbstractMigration
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
        $table = $this->table('addons');
        $table->changeColumn('description', 'text', [
            'default' => null,
            'null' => true,
        ]);

        $table->changeColumn('key_category_id', 'integer', [
            'default' => null,
            'limit' => 11,
            'null' => true,
        ]);
        $table->update();
    }
}
