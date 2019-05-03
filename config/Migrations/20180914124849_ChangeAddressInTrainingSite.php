<?php
use Migrations\AbstractMigration;

class ChangeAddressInTrainingSite extends AbstractMigration
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
        $table = $this->table('training_sites');
        $table->changeColumn('address', 'text', [
            'default' => null,
            'null' => true,
            ]);
        $table->update();
    }
}
