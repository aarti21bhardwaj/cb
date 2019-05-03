<?php
use Migrations\AbstractMigration;

class AddColumnsToTrainingSites extends AbstractMigration
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
        $table->addColumn('site_contract_name', 'string', [
            'default' => null,
            'limit' => 255,
            'null' => true,
        ]);
        $table->addColumn('site_contract_path', 'string', [
            'default' => null,
            'limit' => 255,
            'null' => true,
        ]);
        $table->addColumn('site_contract_date', 'date', [
            'default' => null,
            'null' => true,
        ]);
        $table->addColumn('site_monitoring_name', 'string', [
            'default' => null,
            'limit' => 255,
            'null' => true,
        ]);
        $table->addColumn('site_monitoring_path', 'string', [
            'default' => null,
            'limit' => 255,
            'null' => true,
        ]);
        $table->addColumn('site_monitoring_date', 'date', [
            'default' => null,
            'null' => true,
        ]);
        $table->addColumn('site_insurance_name', 'string', [
            'default' => null,
            'limit' => 255,
            'null' => true,
        ]);
        $table->addColumn('site_insurance_path', 'string', [
            'default' => null,
            'limit' => 255,
            'null' => true,
        ]);
        $table->addColumn('site_insurance_expiry_date', 'date', [
            'default' => null,
            'null' => true,
        ]);
        $table->update();
    }
}
