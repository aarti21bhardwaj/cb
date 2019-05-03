<?php
use Migrations\AbstractMigration;

class RemoveFirstNameFromTenants extends AbstractMigration
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
        $table = $this->table('tenants');
        $table->removeColumn('first_name');
        $table->removeColumn('last_name');
        $table->removeColumn('email');
        $table->removeColumn('phone');
        $table->removeColumn('password');
        $table->removeColumn('role_id');
        $table->update();
    }
}
