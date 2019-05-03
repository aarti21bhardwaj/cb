<?php
use Migrations\AbstractMigration;

class ChangeColumnsInTransactions extends AbstractMigration
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
         $table = $this->table('transactions');
         $table->removeColumn('lft', 'integer', [
             'default' => null,
             'limit' => 11,
             'null' => false,
         ]);
         $table->removeColumn('rght', 'integer', [
             'default' => null,
             'limit' => 11,
             'null' => false,
         ]);
         $table->addColumn('available_amount', 'integer', [
             'default' => null,
             'limit' => 11,
             'null' => true,
         ]);
         $table->update();
    }
}
