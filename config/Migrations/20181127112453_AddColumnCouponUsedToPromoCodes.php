<?php
use Migrations\AbstractMigration;

class AddColumnCouponUsedToPromoCodes extends AbstractMigration
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
        $table->addColumn('coupon_used', 'integer', [
            'default' => null,
            'null' => true,
        ]);
        $table->update();
    }
}
