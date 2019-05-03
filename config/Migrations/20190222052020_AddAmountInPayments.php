<?php
use Migrations\AbstractMigration;

class AddAmountInPayments extends AbstractMigration
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
        $table = $this->table('payments');
        $table->addColumn('amount', 'integer', [
            'default' => null,
            'limit' => 11,
        ]);
        $table->update();
    }
}
