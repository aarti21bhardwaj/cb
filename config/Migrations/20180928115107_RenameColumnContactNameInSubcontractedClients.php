<?php
use Migrations\AbstractMigration;

class RenameColumnContactNameInSubcontractedClients extends AbstractMigration
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
        $table = $this->table('subcontracted_clients');
        $table->renameColumn('contant_name', 'contact_name');
        $table->update();
    }
}
