<?php
use Migrations\AbstractMigration;

class CreateKeys extends AbstractMigration
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
        $table = $this->table('keys');
        $table->addColumn('key_category_id', 'integer', [
            'default' => null,
            'limit' => 11,
            'null' => false,
        ]);
        $table->addColumn('key', 'text', [
            'default' => null,
            'null' => false,
        ]);
        $table->create();
    }
}
