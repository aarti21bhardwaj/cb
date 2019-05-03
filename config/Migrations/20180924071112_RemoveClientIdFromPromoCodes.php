<?php
use Migrations\AbstractMigration;

class RemoveClientIdFromPromoCodes extends AbstractMigration
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
        $table = $this->table('promo_codes');
        $table->removeColumn('client_id');
        $table->update();
    }
}
