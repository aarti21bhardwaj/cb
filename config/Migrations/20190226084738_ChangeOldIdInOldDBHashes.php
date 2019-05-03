<?php
use Migrations\AbstractMigration;

class ChangeOldIdInOldDBHashes extends AbstractMigration
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
        $table = $this->table('old_db_hashes');
        $table->changeColumn('old_id', 'string', [
            'default' => null,
            'limit' => 255,
        ]);
        $table->update();
    }
}
