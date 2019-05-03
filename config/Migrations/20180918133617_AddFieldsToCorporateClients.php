<?php
use Migrations\AbstractMigration;

class AddFieldsToCorporateClients extends AbstractMigration
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
        $table->addColumn('url_id', 'string', [
            'default' => null,
            'limit' => 255,
            'null' => true,
        ]);
        $table->addColumn('corporate_details', 'text', [
            'default' => null,
            'null' => true,
        ]);
        $table->update();
    }
}
