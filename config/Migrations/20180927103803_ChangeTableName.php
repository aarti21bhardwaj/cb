<?php
use Migrations\AbstractMigration;

class ChangeTableName extends AbstractMigration
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
        
        $table = $this->table('instructor_insurance_form');
        $table->rename('instructor_insurance_forms');
        $table->update();
    }
}
