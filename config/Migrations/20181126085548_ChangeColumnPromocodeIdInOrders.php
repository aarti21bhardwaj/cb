<?php
use Migrations\AbstractMigration;

class ChangeColumnPromocodeIdInOrders extends AbstractMigration
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
        $table = $this->table('orders');
        $table->renameColumn('promocode_id', 'promo_code_id');
        $table->update();
    }

}
